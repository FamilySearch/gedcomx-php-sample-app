<?php
  
  include '../header.php';
  include '../includes/prettyprint.php';
  
  $personId = isset($_GET['personId']) ? $_GET['personId'] : null;
  
?>

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
    
      // Now that we have a valid response object for the person,
      // we can request that person's relationships.
      
      echo '<h3>Parent Relationships</h3>';
      
      // Request the parent relationships from the API
      $parentsResponse = $personResponse->loadParentRelationships();
      
      // Check for errors
      if($parentsResponse->hasError()){
        handleErrors($parentsResponse);
      } else {
        
        // Retrieve a list of all relationships to parents from the response
        foreach($parentsResponse->getRelationshipsToParents() as $relationship){
          echo '<pre>',print_r($relationship->toArray(), true),'</pre>';
        }
      }
      
      echo '<h3>Spouse Relationships</h3>';
      
      // Request the spouse relationships from the API
      $spousesResponse = $personResponse->loadSpouseRelationships();
      
      // Check for errors
      if($spousesResponse->hasError()){
        handleErrors($spousesResponse);
      } else {
        
        // Retrieve a list of all relationships to parents from the response
        foreach($spousesResponse->getSpouseRelationships() as $relationship){
          echo '<pre>',print_r($relationship->toArray(), true),'</pre>';
        }
      }
      
      echo '<h3>Child Relationships</h3>';
      
      // Request the child relationships
      $childResponse = $personResponse->loadChildRelationships();
      
      // Check for errors
      if($childResponse->hasError()){
        handleErrors($childResponse);
      } else {
        
        // Retrieve a list of all relationships to parents from the response
        foreach($childResponse->getRelationshipsToChildren() as $relationship){
          echo '<pre>',print_r($relationship->toArray(), true),'</pre>';
        }
      }
    
      // TODO: show how to assemble families
    }
  
  }
  
  include '../footer.php';