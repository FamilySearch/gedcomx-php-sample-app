<?php
// MODIFY setup.php TO USE YOUR OWN APP KEY AND URL FOR THIS FILE
// ADD AN INCLUDE STATEMENT HERE FOR setup.php


// THIS CODE IS A MODIFIED COPY OF header.php
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
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="/">Gedcom X PHP Sample App</a>
        </div>
        <div class="collapse navbar-collapse">
          <p class="navbar-text navbar-right"><a class="navbar-link" href="https://github.com/FamilySearch/gedcomx-php" target="_blank">SDK</a></p>
          <?php if(isset($_SESSION['fs_username'])){ ?>
          <p class="navbar-text navbar-right"><a class="navbar-link" href="/logout.php">Logout</a></p>
          <p class="navbar-text navbar-right"><?= $_SESSION['fs_username']; ?></p>
          <?php } ?>
        </div>
      </div>
    </nav>
    <div class="container"><!-- start main container -->

      <div class="row">
        <div class="col-sm-9"><!-- start main column -->

// THIS IS THE FIRST SCREEN OF THE TUTORIAL AND IT INITIATES AUTHENTICATION

<div class="jumbotron">
    <p>Welcome to the Gedcom X PHP tutorial. You must authenticate with FamilySearch (obtain an access token) before you can access the Family Tree data. Sign in with the FamilySearch sandbox to get started.</p>
    <a href="/examples/OAuth2Authorize.php" class="btn btn-primary">Sign In</a>
  </div>
  
      <p class="text-muted pull-right"><a href="https://github.com/FamilySearch/gedcomx-php-sample-app/blob/master/src<?= $_SERVER['PHP_SELF']; ?>" target="_blank">Click</a> to read the current user.</p>
// PLACE THE CODE HERE TO READ THE CURRENT LOGGED IN PERSON



// PLACE THE CODE HERE TO SEARCH FOR A PERSON



// PLACE THE CODE HERE TO DISPLAY A SELECTED PERSON


// PLACE THE CODE HERE TO DISPLAY THE SPOUSE OF THE PERSON


// PLACE THE CODE HERE TO DISPLAY THE PARENTS OF THE PERSON


// PLACE THE CODE HERE TO DISPLAY THE CHILDREN OF THE PERSON'S PARENTS


CONGRATULATIONS!!! CODE ON TO GREAT CONTRIBUTIONS TO MEANINGFUL GENEALOGY.
