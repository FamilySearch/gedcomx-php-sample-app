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
      // in those relationships, we will not get another reference to the primary
      // person so we will keep a reference to it now for later use.
      $person = $personResponse->getPerson();
      
      echo '<h3>Parent Relationships</h3>';
      
      // Request the parents and relationships to parents from the API
      $parentsResponse = $personResponse->readParents();
      
      // Check for errors
      if($parentsResponse->hasError()){
        handleErrors($parentsResponse);
      } else {
        
        // Print each child and parents relationships in the response
        foreach($parentsResponse->getChildAndParentsRelationships() as $relationship){
          
          // Get the father and mother person objects. getFather() and getMother()
          // return a ResourceReference which is passed to getPerson() so that
          // we can extract those persons from the response.
          $father = $parentsResponse->getPerson($relationship->getFather());
          $mother = $parentsResponse->getPerson($relationship->getMother());
          
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
        
        // Retrieve a list of all couple relationships from the response
        foreach($spousesResponse->getRelationships() as $relationship){
          
          // The spouses response only includes spouses; it does not include
          // the main person. Therefore we have to figure out whether person1
          // or person2 is the spouse and then extract them from the response.
          // We already have a reference to the main person from above.
          if($relationship->getPerson1()->getResourceId() === $person->getId()){
            $spouse1 = $person;
            $spouse2 = $spousesResponse->getPerson($relationship->getPerson2());
          } else {
            $spouse1 = $spousesResponse->getPerson($relationship->getPerson1());
            $spouse2 = $person;
          }
          
          printRelationship($relationship, $spouse1, $spouse2);
        }
      }
      
      echo '<h3>Child Relationships</h3>';
      
      // Request the parents and relationships to parents from the API
      $childrenResponse = $personResponse->readChildren();
      
      // Check for errors
      if($childrenResponse->hasError()){
        handleErrors($childrenResponse);
      } else {
        
        // Print each child and parents relationships in the response
        foreach($childrenResponse->getChildAndParentsRelationships() as $relationship){
          
          // The children response _only_ contains children; it does not contain
          // the parents. We know that one of the parents is the primary person
          // which we have a reference to from above. We need to figure out whether
          // they are the mother or father.
          //
          // The other parent is likely a spouse in which case we have a 
          // reference to them in the spouses response. But the other parent 
          // doesn't have to be a spouse. A child and parents relationship can 
          // exist without the two parents having a spouse relationship. 
          // In those cases you'll need to make an additional request for the 
          // other parent. We don't do that here.
          
          $child = $childrenResponse->getPerson($relationship->getChild());
          if($relationship->getFather()->getResourceId() === $person->getId()){
            $father = $person;
            $mother = $spousesResponse->getPerson($relationship->getMother());
          } else {
            $mother = $person;
            $father = $spousesResponse->getPerson($relationship->getFather());
          }
          
          printChildAndParentsRelationship($relationship, $father, $mother, $child);
        }
      }
    
      // TODO: show how to assemble families?
    }
  
  }
  
  include '../footer.php';