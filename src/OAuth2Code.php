<?php
  
  include '_header.php';

  // If the request resulted in an error then display the message.
  if(isset($_GET['error'])) {
    ?>
      <div class="alert alert-danger">
        <p class="lead">There was an error while authenticating.</p>
        <p>Error type: <?= $_GET['error']; ?></p>
        <p>Error description: <?= $_GET['error_description']; ?></p>
      </div>
    <?php
  }

  // If the request is successful, get the code from the URL params
  // and pass to the client object so that it can finish authorization
  // and obtain an access token.
  else if(isset($_GET['code'])) {
    
    // Get the code from the URL params
    $code = $_GET['code'];
    
    // Exchange the code for an access token
    $token = $client->authenticateViaOAuth2AuthCode($code)->getAccessToken();
    
    // Store the access token in a session variable
    $_SESSION['fs_access_token'] = $token;
    
    ?>
      <h2>Access Token</h2>
      <p>Here's the access token we obtained via OAuth2. It has been stored in a
      session so that future interactions in the sample app are authenticated.</p>
      <pre><?= $token; ?></pre>
    <?php
  }
  
  // If this page was called directly, display a helpful message.
  else {
    ?>
      <p>This page is designed to receive OAuth2 redirects. To begin the OAuth2
      process, visit the <a href="OAuth2Authorize.php">OAuth2 Authorize</a> page.</p>
    <?php
  }

  include '_footer.php';