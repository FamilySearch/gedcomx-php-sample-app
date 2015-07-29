<?php

  $groups = array(
    'AUTHENTICATION' => array(
      array(
        'title' => 'FamilySearch Authentication',
        'url' => 'OAuth2Code.php'
      )
    ),
    'PERSON READ' => array(
      array(
        'title' => 'Read Current User Person',
        'url' => 'CurrentUserPerson.php'
      ),
      array(
        'title' => 'Read A Person By Id',
        'url' => 'ReadPerson.php'
      ),
      array(
        'title' => 'Read A Person\'s Family',
        'url' => 'ReadFamily.php'
      ),
      array(
        'title' => 'Read A Person\'s Ancestry',
        'url' => 'ReadAncestry.php'
      ),
      array(
        'title' => 'Person Search',
        'url' => 'PersonSearch.php'
      )
    )
  );
  
?>

<div id="sidebar" class="col-sm-3">
  <?php foreach($groups as $groupTitle => $pages){ ?>
  <div class="panel panel-default">
    <div class="panel-heading"><?= $groupTitle; ?></div>
    <div class="list-group">
      <?php foreach($pages as $page){ ?>
      <a href="/examples/<?= $page['url']; ?>" class="list-group-item"><?= $page['title']; ?></a>
      <?php } ?>
    </div>
  </div>
  <?php } ?>
</div>
