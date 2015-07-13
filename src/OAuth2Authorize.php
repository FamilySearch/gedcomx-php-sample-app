<?php
  
  include '_setup.php';
  
  // Ask the SDK client object to generate the authorization
  // URL to being OAuth then forward the user to that URL
  header('Location: ' . $client->getOAuth2AuthorizationURI());