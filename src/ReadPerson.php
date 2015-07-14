<?php
  
  include '_header.php';
  
  $personId = isset($_GET['personId']) ? $_GET['personId'] : null;
  
?>

  <form>
    <div class="row">
      <div class="form-group col-sm-6 col-md-4">
        <label for="personIdInput">Person Id</label>
        <input type="text" class="form-control" id="personIdInput" placeholder="Person Id" name="personId" value="<?= $personId; ?>">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Read Person</button>
  </form>
  <br>

<?php
  
  if($personId){
  
    // First we make a request to the API for the person and save the response
    $response = $client->familytree()->readPersonById($personId);
    
    // Check for errors
    if($response->hasError()){
      handleErrors($response);
    }
    
    // No errors
    else {
    
      // Then we get the person from the response
      $person = $response->getPerson();
      
      // Print the person's information
      printPerson($person);
    
    }
  
  }
  
  include '_footer.php';