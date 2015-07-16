<?php
  
  include '../header.php';
  include '../includes/prettyprint.php';
  
  $personId = isset($_GET['personId']) ? $_GET['personId'] : null;
  
?>
  <style>
    pre {
      margin-bottom: 64px;
    }
  </style>
  
  <form>
    <div class="row">
      <div class="form-group col-sm-6 col-md-4">
        <label for="personIdInput">Person Id</label>
        <input type="text" class="form-control" id="personIdInput" placeholder="Person Id" name="personId" value="<?= $personId; ?>">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Read Family</button>
  </form>
  <br>

<?php
  
  if($personId){
  
    // First we make a request to the API for the person and save the response
    $personResponse = $client->familytree()->readPersonById($personId);
    
    // Check for errors
    if($personResponse->hasError()){
      handleErrors($personResponse);
    }
    
    // No errors
    else {
    
      // As we request this person's relationships and all other persons
      // in the relationships, we will not another reference to the primary
      // person so we will keep a reference to it now for use later
      $person = $personResponse->getPerson();
      
      // We will keep a running list of all persons so that we can properly 
      // assemble families later
      $persons = array($person);
      
      echo '<h3>Parent Relationships</h3>';
      
      // Request the parents and relationships to parents from the API
      $parentsResponse = $personResponse->readParents();
      
      // Check for errors
      if($parentsResponse->hasError()){
        handleErrors($parentsResponse);
      } else {
        
        // Merge the list of parents into our running list of persons
        $persons = array_merge($persons, $parentsResponse->getPersons());
        
        // Print each child and parents relationships in the response
        foreach($parentsResponse->getChildAndParentsRelationships() as $relationship){
          
          // Get the father and mother ids
          list($fatherId, $motherId, $childId) = getChildAndParentsRelationshipRoleIds($relationship);
          
          // Get the father and mother person objects.
          $father = getPersonFromList($persons, $fatherId);
          $mother = getPersonFromList($persons, $motherId);
          
          // We don't extract the child because it's the primary person and therefore
          // not included in the response. But we already have a reference to
          // that person from above.
          
          printChildAndParentsRelationship($relationship, $father, $mother, $person);
        }
      }
      
      echo '<h3>Spouse Relationships</h3>';
      
      // Request the spouse relationships from the API
      $spousesResponse = $personResponse->readSpouses();
      
      // Check for errors
      if($spousesResponse->hasError()){
        handleErrors($spousesResponse);
      } else {
        
        // Merge the list of spouses into our running list of persons
        $persons = array_merge($persons, $spousesResponse->getPersons());
        
        // Retrieve a list of all couple relationships from the response
        foreach($spousesResponse->getRelationships() as $relationship){
          
          $person1Id = $relationship->getPerson1()->getResourceId();
          $person1 = getPersonFromList($persons, $person1Id);
          
          $person2Id = $relationship->getPerson2()->getResourceId();
          $person2 = getPersonFromList($persons, $person2Id);
          
          printRelationship($relationship, $person1, $person2);
        }
      }
      
      echo '<h3>Child Relationships</h3>';
      
      // Request the parents and relationships to parents from the API
      $childrenResponse = $personResponse->readChildren();
      
      // Check for errors
      if($childrenResponse->hasError()){
        handleErrors($childrenResponse);
      } else {
        
        // Merge the list of children into our running list of persons.
        // The response _only_ contains children, not the parents. One of the
        // parents is the primary person which we stored above. The other person
        // is likely a spouse, which we also stored above, but not necessarily.
        // A child and parents relationship can exist without the two parents
        // having a spouse relationship. In those cases you'll need to make an
        // additional request request for the missing parent. We don't do that here.
        $persons = array_merge($persons, $childrenResponse->getPersons());
        
        // Print each child and parents relationships in the response
        foreach($childrenResponse->getChildAndParentsRelationships() as $relationship){
          
          // Get the father and mother ids
          list($fatherId, $motherId, $childId) = getChildAndParentsRelationshipRoleIds($relationship);
          
          // Get the father and mother person objects.
          $father = getPersonFromList($persons, $fatherId);
          $mother = getPersonFromList($persons, $motherId);
          $child = getPersonFromList($persons, $childId);
          
          printChildAndParentsRelationship($relationship, $father, $mother, $child);
        }
      }
    
      // TODO: show how to assemble families?
    }
  
  }
  
  /**
   * Get the IDs of all persons in the child and parents relationship.
   * Returns array($fatherId, $motherId, $childId)
   */
  function getChildAndParentsRelationshipRoleIds($relationship){
    return array(
      getChildAndParentsRelationshipRoleId($relationship, 'father'),
      getChildAndParentsRelationshipRoleId($relationship, 'mother'),
      getChildAndParentsRelationshipRoleId($relationship, 'child')
    );
  }
  
  /**
   * Retrieve a person ID from a child and parents relationship.
   */
  function getChildAndParentsRelationshipRoleId($relationship, $role){
    $reference = null;
    if($role === 'mother'){
      $reference = $relationship->getMother();
    } else if($role === 'father'){
      $reference = $relationship->getFather();
    } else if($role === 'child'){
      $reference = $relationship->getChild();
    }
    if($reference){
      return $reference->getResourceId();
    } else {
      return null;
    }
  }
  
  /**
   * Get the specified person from an array of persons
   */
  function getPersonFromList($persons, $personId){
    foreach($persons as $person){
      if($person->getId() === $personId){
        return $person;
      }
    }
  }
  
  include '../footer.php';