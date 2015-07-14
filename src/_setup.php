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