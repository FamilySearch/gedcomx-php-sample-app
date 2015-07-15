<?php
  
  include '../header.php';
  include '../includes/prettyprint.php';
  
  $personId = isset($_GET['personId']) ? $_GET['personId'] : null;
  
?>

  <form>
    <div class="row">
      <div class="form-group col-sm-6 col-md-4">
        <label for="personIdInput">Person Id</label>
        <input type="text" class="form-control" id="personIdInput" placeholder="Person Id" name="personId" value="<?= $personId; ?>">
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Read Ancestry</button>
  </form>
  <br>

<?php
  
  if($personId){
  
    // First we make a request to the API for the person and save the response
    $personResponse = $client->familytree()->readPersonById($personId);
    
    // Check for errors
    if($personResponse->hasError()){
      handleErrors($personResponse);
    }
    
    // No errors
    else {
    
      // Then we get the person from the response
      $ancestryResponse = $personResponse->readAncestry(Gedcomx\Rs\Client\Options\QueryParameter::generations('4'));
      
      // Check for errors
      if($ancestryResponse->hasError()){
        handleErrors($ancestryResponse);
      } else {
        
        // There are two ways we can traverse the tree. The first is recursively
        // via a tree structure. The second is by iterating over the Ahnentafel numbers.

        $tree = $ancestryResponse->getTree();
        ?>
          <h2>Recursive</h2>
          <table class="table">
            <tr>
              <th>Ahnentafel #</th>
              <th>ID</th>
              <th>Name</th>
            </tr>
        <?php
        printTreeNodeRecursive($root = $tree->getRoot());
        echo '</table>';
        
        ?>
          <h2>Iterative</h2>
          <table class="table">
            <tr>
              <th>Ahnentafel #</th>
              <th>ID</th>
              <th>Name</th>
            </tr>
        <?php
        for($i = 1; $i <= 15; $i++){
          printTreeNode($tree->getAncestor($i));
        }
        echo '</table>';
      }
    
    }
  
  }
  
  /**
   * Display basic information about the person in the tree node
   */
  function printTreeNode($node){
    if($node){
      $person = $node->getPerson();
      if($person){
        $display = $node->getPerson()->getDisplayExtension();
        ?>
        <tr>
          <td><?= $display->getAscendancyNumber(); ?></td>
          <td><a href="/examples/ReadPerson.php?personId=<?= $person->getId(); ?>"><?= $person->getId(); ?></a></td>
          <td><?= $display->getName(); ?></td>
        </tr>
        <?php
      }
    }
  }
  
  /**
   * Recursively print all nodes (persons) in the tree. This
   * uses a pre-order graph traversal to print them in ascending
   * order according to their Ahnentafel number.
   * 
   * https://en.wikipedia.org/wiki/Tree_traversal
   */
  function printTreeNodeRecursive($node){
    printTreeNode($node);
    printTreeNode($node->getFather());
    printTreeNode($node->getMother());
  }
  
  include '../footer.php';