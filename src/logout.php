<?php

  session_start();
  
  // Clear the session
  session_unset();
  
  // Forward user to the home page
  header('Location: /');