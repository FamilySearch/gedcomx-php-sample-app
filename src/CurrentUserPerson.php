<?php
  
  include '_header.php';
  
  // First we make a request to the API for the current user's person and save the response
  $response = $client->familytree()->readPersonForCurrentUser();
  
  // Then we get the person from the response
  $person = $response->getPerson();
  
  echo '<pre>',print_r($person, true),'</pre>';
  
  include '_footer.php';