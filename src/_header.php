<?php
  include '_setup.php'; 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gedcom X PHP Sample App</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="/">Gedcom X PHP Sample App</a>
        </div>
        <div class="collapse navbar-collapse">
          <p class="navbar-text navbar-right"><a class="navbar-link" href="https://github.com/FamilySearch/gedcomx-php" target="_blank">GitHub</a></p>
          <?php if(isset($_SESSION['fs_username'])){ ?>
          <p class="navbar-text navbar-right"><a class="navbar-link" href="/logout.php">Logout</a></p>
          <p class="navbar-text navbar-right"><?= $_SESSION['fs_username']; ?></p>
          <?php } ?>
        </div>
      </div>
    </nav>
    <div class="container"><!-- start main container -->

      <div class="row">
        
        <?php include '_sidebar.php'; ?>
        
        <div class="col-sm-9"><!-- start main column -->