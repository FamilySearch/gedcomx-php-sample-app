<?php
  
  include '../header.php';
  include '../includes/prettyprint.php';
  
  $validParams = array(
    'givenName',
    'surname',
    'birthDate',
    'birthPlace',
    'deathDate',
    'deathPlace',
    'fatherGivenName',
    'fatherSurname',
    'motherGivenName',
    'motherSurname',
    'spouseGivenName',
    'spouseSurname'
  );
  
  // Collect the search params from the URL
  $params = array();
  foreach($_GET as $key => $val){
    $val = trim($val);
    if($val && in_array($key, $validParams)){
      $params[$key] = $val;
    }
  }
  
?>

  <p class="text-muted">We only attempt to show the most commonly used search params.
  Read the <a href="https://familysearch.org/developers/docs/api/tree/Person_Search_resource" target="_blank">API Docs</a>
  for a more complete list of possible search parameters, such as more advanced relationship constraints and date ranges.</p>
  <form>
    <div class="row">
      <div class="form-group col-sm-6">
        <label for="givenName">Given Name</label>
        <input type="text" class="form-control" id="givenName" placeholder="given name" name="givenName" value="<?= $params['givenName']; ?>">
      </div>
      <div class="form-group col-sm-6">
        <label for="surname">Surname</label>
        <input type="text" class="form-control" id="surname" placeholder="surname" name="surname" value="<?= $params['surname']; ?>">
      </div>
      <div class="form-group col-sm-6">
        <label for="birthDate">Birth Date</label>
        <input type="text" class="form-control" id="birthDate" placeholder="birth date" name="birthDate" value="<?= $params['birthDate']; ?>">
      </div>
      <div class="form-group col-sm-6">
        <label for="birthPlace">Birth Place</label>
        <input type="text" class="form-control" id="birthPlace" placeholder="birth place" name="birthPlace" value="<?= $params['birthPlace']; ?>">
      </div>
      <div class="form-group col-sm-6">
        <label for="deathDate">Death Date</label>
        <input type="text" class="form-control" id="deathDate" placeholder="death date" name="deathDate" value="<?= $params['deathDate']; ?>">
      </div>
      <div class="form-group col-sm-6">
        <label for="deathPlace">Death Place</label>
        <input type="text" class="form-control" id="deathPlace" placeholder="death place" name="deathPlace" value="<?= $params['deathPlace']; ?>">
      </div>
      <div class="form-group col-sm-6">
        <label for="fatherGivenName">Father's Given Name</label>
        <input type="text" class="form-control" id="fatherGivenName" placeholder="father's given name" name="fatherGivenName" value="<?= $params['fatherGivenName']; ?>">
      </div>
      <div class="form-group col-sm-6">
        <label for="fatherSurname">Father's Surname</label>
        <input type="text" class="form-control" id="fatherSurname" placeholder="father's surname" name="fatherSurname" value="<?= $params['fatherSurname']; ?>">
      </div>
      <div class="form-group col-sm-6">
        <label for="motherGivenName">Mother's Given Name</label>
        <input type="text" class="form-control" id="motherGivenName" placeholder="mother's given name" name="motherGivenName" value="<?= $params['motherGivenName']; ?>">
      </div>
      <div class="form-group col-sm-6">
        <label for="motherSurname">Mother's Surname</label>
        <input type="text" class="form-control" id="motherSurname" placeholder="mother's surname" name="motherSurname" value="<?= $params['motherSurname']; ?>">
      </div>
      <div class="form-group col-sm-6">
        <label for="spouseGivenName">Spouse's Given Name</label>
        <input type="text" class="form-control" id="spouseGivenName" placeholder="spouse's given name" name="spouseGivenName" value="<?= $params['spouseGivenName']; ?>">
      </div>
      <div class="form-group col-sm-6">
        <label for="spouseSurname">Spouse's Surname</label>
        <input type="text" class="form-control" id="spouseSurname" placeholder="spouse's surname" name="spouseSurname" value="<?= $params['spouseSurname']; ?>">
      </div>
    </div>
    <p class="text-center"><button type="submit" class="btn btn-primary">Search</button></p>
  </form>

<?php
  
  // Only search if any of the search params are set
  if(!empty($params)){
  
    // Print the search parameters; useful for debugging
    echo '<h3>Search Parameters</h3>';
    rawDump($params);
  
    // Construct the search query using the given parameters
    $query = new Gedcomx\Rs\Client\Util\GedcomxPersonSearchQueryBuilder();
    
    if(isset($params['givenName'])){
      $query->givenName($params['givenName']);
    }
    
    if(isset($params['surname'])){
      $query->surname($params['surname']);
    }
    
    if(isset($params['birthDate'])){
      $query->birthDate($params['birthDate']);
    }
    
    if(isset($params['birthPlace'])){
      $query->birthPlace($params['birthPlace']);
    }
    
    if(isset($params['deathDate'])){
      $query->deathDate($params['deathDate']);
    }
    
    if(isset($params['deathPlace'])){
      $query->deathPlace($params['deathPlace']);
    }
    
    if(isset($params['fatherGivenName'])){
      $query->fatherGivenName($params['fatherGivenName']);
    }
    
    if(isset($params['fatherSurname'])){
      $query->fatherSurname($params['fatherSurname']);
    }
    
    if(isset($params['motherGivenName'])){
      $query->motherGivenName($params['motherGivenName']);
    }
    
    if(isset($params['motherSurname'])){
      $query->motherSurname($params['motherSurname']);
    }
    
    if(isset($params['spouseGivenName'])){
      $query->spouseGivenName($params['spouseGivenName']);
    }
    
    if(isset($params['spouseSurname'])){
      $query->spouseSurname($params['spouseSurname']);
    }
    
    // You can avoid all of the previous code duplication using dynamic method calls.
    // http://stackoverflow.com/questions/251485/dynamic-class-method-invocation-in-php
    //
    // foreach($validParams as $searchParam){
    //  if($params[$searchParam]){
    //    $query->$searchParam($params[$searchParam]);
    //  }
    // }
  
    // First we make a request to the API for the person and save the response
    $searchResponse = $client->familytree()->searchForPersons($query);
    
    // Check for errors
    if($searchResponse->hasError()){
      handleErrors($searchResponse);
    }
    
    // No errors
    else {
    
      ?>
        <h3>Results</h3>
        <table class="table">
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Birth</th>
            <th>Death</th>
          </tr>
      <?php
      $entries = $searchResponse->getResults()->getEntries();
      foreach($entries as $entry){
        
        // The ID of the entry matches the ID of the primary person in the result.
        // Results may also contain spouses and parents so we need the ID to
        // know which person is the primary person.
        $personId = $entry->getId();
        
        $gedcomx = $entry->getContent()->getGedcomx();
        foreach($gedcomx->getPersons() as $person){
          if($person->getId() === $personId){
            $display = $person->getDisplayExtension();
            ?>
              <tr>
                <td><a href="/examples/ReadPerson.php?personId=<?= $person->getId(); ?>"><?= $person->getId(); ?></a></td>
                <td><?= $display->getName(); ?></td>
                <td>
                  <?= $display->getBirthDate(); ?>
                  <br>
                  <?= $display->getBirthPlace(); ?>
                </td>
                <td>
                  <?= $display->getDeathDate(); ?>
                  <br>
                  <?= $display->getDeathPlace(); ?>
                </td>
              </tr>
            <?php
          }
        }
      }
      echo '</table>';
    }
  
  }

  
  include '../footer.php';