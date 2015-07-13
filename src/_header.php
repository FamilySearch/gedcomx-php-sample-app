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
        </div>
      </div>
    </nav>
    <div class="container"><!-- start main container -->
      <div class="row">
        
        <div id="sidebar" class="col-sm-3">
          
          <div class="panel panel-default">
            <div class="panel-heading">Authentication</div>
            <div class="list-group">
              <a href="/OAuth2Authorize.php" class="list-group-item">OAuth2 Authorize</a>
              <a href="/OAuth2Code.php" class="list-group-item">OAuth2 Code</a>
            </div>
          </div>
          
        </div>
        <div class="col-sm-9"><!-- start main column -->