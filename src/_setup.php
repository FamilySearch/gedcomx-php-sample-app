<?php

  require '../vendor/autoload.php';
  
  use Gedcomx\Extensions\FamilySearch\Rs\Client\FamilySearchClient;
  
  session_start();
  
  $clientOptions = array(
    'environment' => 'sandbox',
    'clientId' => 'a02j0000007s2BiAAI',
    'redirectURI' => 'http://' . $_SERVER['HTTP_HOST'] . '/OAuth2Code.php'
  );
  
  if(isset($_SESSION['fs_access_token'])){
    $clientOptions['accessToken'] = $_SESSION['fs_access_token'];
  }
  
  $client = new FamilySearchClient($clientOptions);
  
  /**
   * Pretty print a person
   */
  function printPerson($person){
    
    if(!$person) return;
    
    // Display Information
    $displayInfo = $person->getDisplayExtension();
    ?>
      <h1><?= $displayInfo->getName(); ?></h1>
      <ul>
        <?php if($person->isLiving()){ echo '<li><span class="label label-primary">Living</span></li>'; } ?>
        <li>ID: <code><?= $person->getId(); ?></code></li>
        <li>Gender: <code><?= $displayInfo->getGender(); ?></code></li>
        <li>Lifespan: <code><?= $displayInfo->getLifespan(); ?></code></li>
        <li>Birth Date: <code><?= $displayInfo->getBirthDate(); ?></code></li>
        <li>Birth Place: <code><?= $displayInfo->getBirthPlace(); ?></code></li>
        <li>Death Date: <code><?= $displayInfo->getDeathDate(); ?></code></li>
        <li>Death Place: <code><?= $displayInfo->getDeathPlace(); ?></code></li>
      </ul>
    <?php
    
    // Names
    echo '<h3>Names</h3>';
    foreach($person->getNames() as $name){
      ?>
      <div class="panel panel-default">
        <div class="panel-heading"><?php echo '<code>',$name->getType(),'</code>'; if($name->getPreferred()){ echo ' <span class="label label-success">Preferred</span>'; } ?></div>
        <table class="table">
          <tr>
            <th>Full Text</th>
            <th>Given</th>
            <th>Surname</th>
            <th>Lang</th>
          </tr>
          <?php 
            foreach($name->getNameForms() as $nameForm){
              $nameParts = array();
              foreach($nameForm->getParts() as $namePart){
                $nameParts[$namePart->getType()] = $namePart->getValue();
              }
              ?>
                <tr>
                  <td><?= $nameForm->getFullText(); ?></td>
                  <td><?= $nameParts['http://gedcomx.org/Given']; ?></td>
                  <td><?= $nameParts['http://gedcomx.org/Surname']; ?></td>
                  <td><?= $nameForm->getLang(); ?></td>
                </tr>
              <?php
            }
          ?>
        </table>
      </div>

      <?php
    }
    
    // Facts
    echo '<h3>Facts</h3>';
    
    
    // Raw
    echo '<h3>Raw</h3>';
    echo '<pre>',print_r($person->toArray(), true),'</pre>';
    
  }
  
  /**
   * Process errors from the API
   */
  function handleErrors($response){
    if($response->hasError()){
      
      $statusCode = $response->getResponse()->getStatusCode();
      $message = "HTTP $statusCode. Learn more about this error in the <a href=\"https://familysearch.org/developers/docs/guides/http-status-codes\">status codes guide</a>.";
      $details = '';
      $type = 'danger';
      
      // 401 - Unauthenticated
      if($response->hasStatus(401)){
        $type = 'warning';
        if(isset($_SESSION['fs_access_token'])){
          $details = 'Your session has expired. <a href="/OAuth2Authorize.php">Sign in</a> again.';
        } else {
          $details = '<a href="/OAuth2Authorize.php">Sign in</a> to use the sample app.';
        }
      }
      
      if($details){
        $message .= '<br><br>' . $details;
      }
      
      printStatusMessage($message, $type);
    }
  }
  
  /**
   * Print status message using a bootstrap alert box
   */
  function printStatusMessage($message, $type = 'default'){
    echo "<div class=\"alert alert-$type\">$message</div>";
  }