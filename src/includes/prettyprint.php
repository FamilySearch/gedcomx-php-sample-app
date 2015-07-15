<?php

  /**
   * Pretty print a person
   */
  function printPerson($person){
    
    if(!$person) return;
    
    // Display Information
    $displayInfo = $person->getDisplayExtension();
    ?>
      <h1><?= $displayInfo->getName(); ?></h1>
      <ul>
        <?php if($person->isLiving()){ echo '<li><span class="label label-primary">Living</span></li>'; } ?>
        <li>ID: <code><?= $person->getId(); ?></code></li>
        <li>Gender: <code><?= $displayInfo->getGender(); ?></code></li>
        <li>Lifespan: <code><?= $displayInfo->getLifespan(); ?></code></li>
        <li>Birth Date: <code><?= $displayInfo->getBirthDate(); ?></code></li>
        <li>Birth Place: <code><?= $displayInfo->getBirthPlace(); ?></code></li>
        <li>Death Date: <code><?= $displayInfo->getDeathDate(); ?></code></li>
        <li>Death Place: <code><?= $displayInfo->getDeathPlace(); ?></code></li>
      </ul>
    <?php
    
    // Names
    echo '<h3>Names</h3>';
    foreach($person->getNames() as $name){
      printName($name);
    }
    
    // Facts
    echo '<h3>Facts</h3>';
    foreach($person->getFacts() as $fact){
      printFact($fact);
    }
    
    
    // Raw
    echo '<h3>Raw</h3>';
    rawDump($person->toArray());
    
  }
  
  /**
   * Pretty print a relationship
   */
  function printRelationship($relationship){
    $person1Id = $relationship->getPerson1()->getResourceId();
    $person2Id = $relationship->getPerson2()->getResourceId();
    ?>
    <div class="panel panel-default">
      <table class="table">
        <tr>
          <th>Relationship ID</th>
          <th>Type</th>
          <th>Person1 ID</th>
          <th>Person2 ID</th>
        </tr>
        <tr>
          <td><?= $relationship->getId(); ?></td>
          <td><code><?= $relationship->getType(); ?></code></td>
          <td><a href="/examples/ReadPerson.php?personId=<?= $person1Id; ?>"><?= $person1Id; ?></a></td>
          <td><a href="/examples/ReadPerson.php?personId=<?= $person2Id; ?>"><?= $person2Id; ?></a></td>
        </tr>
      </table>
    </div>
    <?php
    
    // Facts
    foreach($relationship->getFacts() as $fact){
      printFact($fact, false);
    }
    
    // Raw
    rawDump($relationship->toArray());
  }
  
  /**
   * Pretty print a child and parents relationship
   */
  function printChildAndParentsRelationship($relationship){
    $father = $relationship->getFather();
    $fatherId = '';
    if($father){
      $fatherId = $father->getResourceId();
    }
    
    $mother = $relationship->getMother();
    $motherId = '';
    if($mother){
      $motherId = $mother->getResourceId();
    }
    
    $child = $relationship->getChild();
    $childId = '';
    if($child){
      $childId = $child->getResourceId();
    }
    ?>
    <div class="panel panel-default">
      <table class="table">
        <tr>
          <th>Father</th>
          <th>Mother</th>
          <th>Child</th>
        </tr>
        <tr>
          <td><a href="/examples/ReadPerson.php?personId=<?= $fatherId; ?>"><?= $fatherId; ?></a></td>
          <td><a href="/examples/ReadPerson.php?personId=<?= $motherId; ?>"><?= $motherId; ?></a></td>
          <td><a href="/examples/ReadPerson.php?personId=<?= $childId; ?>"><?= $childId; ?></a></td>
        </tr>
      </table>
    </div>
    <?php
    
    // Father facts
    if(count($relationship->getFatherFacts())){
      echo '<h4>Father Facts</h4>';
      foreach($relationship->getFatherFacts() as $fact){
        printFact($fact);
      }
    }
    
    // Mother facts
    if(count($relationship->getMotherFacts())){
      echo '<h4>Mother Facts</h4>';
      foreach($relationship->getMotherFacts() as $fact){
        printFact($fact);
      }
    }
    
    // Raw
   rawDump($relationship->toArray());
  }
  
  /**
   * Pretty print a name
   */
  function printName($name){
    ?>
    <div class="panel panel-default">
      <div class="panel-heading"><?php echo '<code>',$name->getType(),'</code>'; if($name->getPreferred()){ echo ' <span class="label label-success">Preferred</span>'; } ?></div>
      <table class="table">
        <tr>
          <th>Full Text</th>
          <th>Given</th>
          <th>Surname</th>
          <th>Lang</th>
        </tr>
        <?php 
          foreach($name->getNameForms() as $nameForm){
            $nameParts = array();
            foreach($nameForm->getParts() as $namePart){
              $nameParts[$namePart->getType()] = $namePart->getValue();
            }
            ?>
              <tr>
                <td><?= $nameForm->getFullText(); ?></td>
                <td><?= $nameParts['http://gedcomx.org/Given']; ?></td>
                <td><?= $nameParts['http://gedcomx.org/Surname']; ?></td>
                <td><?= $nameForm->getLang(); ?></td>
              </tr>
            <?php
          }
        ?>
      </table>
    </div>
    <?php
  }
  
  /**
   * Pretty print a fact
   */
  function printFact($fact){
    $date = $fact->getDate();
    $normalizedDates = array();
    $normalizedDate = '&nbsp;';
    if($date){
      $normalizedDates = $date->getNormalizedExtensions();
      if(count($normalizedDates)){
        $normalizedDate = $normalizedDates[0]->getValue();
      }
    }
    
    $place = $fact->getPlace();
    $normalizedPlaces = array();
    $normalizedPlace = '&nbsp;';
    if($place){
      $normalizedPlaces = $place->getNormalizedExtensions();
      if(count($normalizedPlaces)){
        $normalizedPlace = $normalizedPlaces[0]->getValue();
      }
    }
    ?>
    <div class="panel panel-default">
      <div class="panel-heading"><code><?= $fact->getType(); ?></code></div>
      <table class="table">
        <tr>
          <th>Value</th>
          <th>Place - Original</th>
          <th>Place - Normalized</th>
        </tr>
        <tr>
          <td><?= $fact->getValue(); ?></td>
          <td><?= $place ? $place->getOriginal() : '&nbsp;'; ?></td>
          <td><?= $normalizedPlace; ?></td>
        </tr>
        <tr>
          <th>Date - Original</th>
          <th>Date - Formal</th>
          <th>Date - Normalized</th>
        </tr>
        <tr>
          <td><?= $date ? $date->getOriginal() : '&nbsp;'; ?></td>
          <td><?= $date ? $date->getFormal() : '&nbsp;'; ?></td>
          <td><?= $normalizedDate; ?></td>
        </tr>
      </table>
    </div>
    <?php
  }
  
  /**
   * Pretty print a raw dump of the variable
   */
  function rawDump($var){
    echo '<pre>',print_r($var, true),'</pre>';
  }