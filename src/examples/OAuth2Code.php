<?php
  
  include '../header.php';

  // If the request for the authorization code resulted in an error then display the message.
  if(isset($_GET['error'])) {
    $message = '<p class="lead">There was an error while authenticating.</p>
        <p>Error type: ' . $_GET['error'] . '></p>
        <p>Error description: ' . $_GET['error_description'] . '></p>';
    printStatusMessage($message, 'danger');
  }

  // If the request is successful, get the code from the URL params
  // and pass to the client object so that it can complete the authentication
  // by obtaining an access token.
  else if(isset($_GET['code'])) {
    
    // Get the code from the URL params
    $code = $_GET['code'];
    
    // Exchange the code for an access token
    $token = $client->authenticateViaOAuth2AuthCode($code)->getAccessToken();
    
    // Store the access token in a session variable
    $_SESSION['fs_access_token'] = $token;
    
    ?>
      <h2>Access Token</h2>
      <p>Here's the access token we obtained. It has been stored in a
      session so that future interactions in the sample app are authenticated.</p>
      <pre><?= $token; ?></pre>
    <?php
    
    // Get and store the user's information so that we can show
    // the sign-in status in the header
    $response = $client->familytree()->readCurrentUser();
    
    // Check for errors
    if($response->hasError()){
      handleErrors($response);
    }
    
    // No errors
    else {
      
      // Extract the user from the response
      $user = $response->getUser();
      
      // Store the username. Sandbox users are generated with fake names that
      // confuse us so we're just going to display the username that we login with.
      $_SESSION['fs_username'] = $user->getContactName();
      
      ?>
        <h2>Contact Name</h2>
        <p>We have also stored your contact name (username) to display in the header
        so that you can know when you're logged in to the sample app.</p>
        <pre><?= $_SESSION['fs_username']; ?></pre>
      <?php
    }
    
  }
  
  // If this page was called directly with no parameters then begin OAuth
  else {
    
    // Ask the SDK client object to generate the authorization
    // URL to being OAuth then forward the user to that URL
    header('Location: ' . $client->getOAuth2AuthorizationURI());
  }

  include '../footer.php';
