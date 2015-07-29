<?php

require __DIR__ . '/../../vendor/autoload.php';
use Gedcomx\Extensions\FamilySearch\Rs\Client\FamilySearchClient;

// MODIFY THIS CODE TO USE YOUR OWN APP KEY. 
// MAKE SURE YOUR FAMILYSEARCH APP HAS THE redirectURI ADDED TO IT. 

session_start();
  
  $clientOptions = array(
    'environment' => 'sandbox',
    'clientId' => 'your-app-key-here',
    'redirectURI' => 'http://' . $_SERVER['HTTP_HOST'] . '/tutorial.php'
  );
?>  

// THE FOLLOWING CODE IS A MODIFIED COPY OF header.php FOUND IN THE SAMPLE APP. THE SIDEBAR IS REMOVED.
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gedcom X PHP Sample App</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/main.css" rel="stylesheet">
  </head>
  <body>
    <div class="container"><!-- start main container -->
      <div class="row">
        <div class="col-sm-9"><!-- start main column -->

// THIS IS THE FIRST PAGE OF THE TUTORIAL AND IT INITIATES AUTHENTICATION. INSERT THE REQUIRED CODE WHERE INSTRUCTED.

<div class="jumbotron">
    <p>Welcome to the Gedcom X PHP tutorial. Users must authenticate with FamilySearch (obtain an access token) before they can access the FamilySearch Family Tree. Sign a user into the FamilySearch sandbox to obtain authentication.</p>
    <a href="/examples/OAuth2Authorize.php" class="btn btn-primary">Sign In</a>
</div>

<?php
        // UNCOMMENT THE SDK CALLS TO OBTAIN AN AUTHORIZATION CODE AND TO EXCHANGE THE CODE FOR AN ACCESS TOKEN.
        // THE REQUEST FOR AN AUTHORIZATION CODE GOES TO THE FAMILYSEARCH LOGIN PAGE. 
        // IF LOGIN IS SUCCESSFUL, A 'CODE' IS RETURNED WHICH CAN BE EXCHANGED FOR AN ACCESS TOKEN (AUTHENTICATION).
        
    //header('Location: ' . $client->getOAuth2AuthorizationURI());
    
        // Exchange the code for an access token
    //$_SESSION['fs_access_token'] = $client->authenticateViaOAuth2AuthCode($_GET['code'])->getAccessToken();
    
    
?>
      <h2>Access Token</h2>
      <p>Here's the access token we obtained. It has been stored in a
      session so that future interactions in the sample app are authenticated.</p>
      <pre><?= $token; ?></pre>
       

<?php
  if(isset($_SESSION['fs_access_token'])){
    $clientOptions['accessToken'] = $_SESSION['fs_access_token'];
  }
  
  $client = new FamilySearchClient($clientOptions);

// UNCOMMENT CODE TO READ AND DISPLAY THE CURRENT LOGGED IN PERSON
      
    // First we make a request to the API for the current user's person and save the response
        //$response = $client->familytree()->readPersonForCurrentUser();
  
    // Then we get the person from the response
        // $person = $response->getPerson();
        
    // Display the person info
        //$personId = $person->getId();
        //$displayInfo = $person->getDisplayExtension();
?>
      <h1><?= $displayInfo->getName(); ?></h1>
      <h3>Display</h3>
      <div class="panel panel-default">
        <table class="table">
          <tr>
            <!-- <th>ID</th>
            <th>Gender</th>  -->
            <th>Birth Date</th>
            <!-- <th>Living</th> -->
          </tr>
          <tr>
            <!-- <td><?= $personId; ?></td>
            <td><?= $displayInfo->getGender(); ?></td> -->
            <td><?= $displayInfo->getBirthDate(); ?></td>
            <!-- <td><?= $person->isLiving() ? 'Living' : 'Deceased'; ?></td> -->
          </tr>
        </table>
      </div>

<?php
// PLACE THE CODE HERE TO SEARCH FOR A PERSON



// PLACE THE CODE HERE TO DISPLAY A SELECTED PERSON


// PLACE THE CODE HERE TO DISPLAY THE SPOUSE OF THE PERSON


// PLACE THE CODE HERE TO DISPLAY THE PARENTS OF THE PERSON


// PLACE THE CODE HERE TO DISPLAY THE CHILDREN OF THE PERSON'S PARENTS

?>
CONGRATULATIONS!!! CODE ON WITH GREAT CONTRIBUTIONS TO MEANINGFUL GENEALOGY.
