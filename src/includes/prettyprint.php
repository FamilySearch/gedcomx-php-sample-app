<?php

  /**
   * Pretty print a person
   */
  function printPerson($person){
    
    if(!$person) return;
    
    $personId = $person->getId();
    $displayInfo = $person->getDisplayExtension();
    
    ?>
      <h1><?= $displayInfo->getName(); ?></h1>
      <h3>Display</h3>
      <div class="panel panel-default">
        <table class="table">
          <tr>
            <th>ID</th>
            <th>Gender</th>
            <th>Lifespan</th>
            <th>Living</th>
          </tr>
          <tr>
            <td><?= $personId; ?></td>
            <td><?= $displayInfo->getGender(); ?></td>
            <td><?= $displayInfo->getLifespan(); ?></td>
            <td><?= $person->isLiving() ? 'Living' : 'Deceased'; ?></td>
          </tr>
          <tr>
            <th>Birth Date</th>
            <th>Birth Place</th>
            <th>Death Date</th>
            <th>Death Place</th>
          </tr>
          <tr>
            <td><?= $displayInfo->getBirthDate(); ?></td>
            <td><?= $displayInfo->getBirthPlace(); ?></td>
            <td><?= $displayInfo->getDeathDate(); ?></td>
            <td><?= $displayInfo->getDeathPlace(); ?></td>
          </tr>
        </table>
      </div>
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
    
    // Links to other sample app pages
    ?>
      <h3>Links</h3>
      <div class="row">
        <div class="col-sm-2">
          <a class="btn btn-default" href="/examples/ReadFamily.php?personId=<?= $personId; ?>">Read Family</a>
        </div>
        <div class="col-sm-2">
          <a class="btn btn-default" href="/examples/ReadAncestry.php?personId=<?= $personId; ?>">Read Ancestry</a>
        </div>
      </div>
    <?php
    
    // Raw
    echo '<h3>Raw</h3>';
    rawDump($person->toArray());
    
  }
  
  /**
   * Pretty print a relationship
   */
  function printRelationship($relationship, $person1, $person2){
    $person1Id = $person1->getId();
    $person2Id = $person2->getId();
    ?>
    <div class="panel panel-default">
      <div class="panel-heading">Relationship</div>
      <table class="table">
        <tr>
          <th>Relationship ID</th>
          <th>Type</th>
          <th>Person1</th>
          <th>Person2</th>
        </tr>
        <tr>
          <td><?= $relationship->getId(); ?></td>
          <td><code><?= $relationship->getType(); ?></code></td>
          <td><a href="/examples/ReadPerson.php?personId=<?= $person1Id; ?>"><?= $person1Id; ?></a></td>
          <td><a href="/examples/ReadPerson.php?personId=<?= $person2Id; ?>"><?= $person2Id; ?></a></td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td><?= $person1->getDisplayExtension()->getName(); ?></td>
          <td><?= $person2->getDisplayExtension()->getName(); ?></td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td><?= $person1->getDisplayExtension()->getLifespan(); ?></td>
          <td><?= $person2->getDisplayExtension()->getLifespan(); ?></td>
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
  function printChildAndParentsRelationship($relationship, $father, $mother, $child){
    $fatherId = '';
    if($father){
      $fatherId = $father->getId();
    }
    
    $motherId = '';
    if($mother){
      $motherId = $mother->getId();
    }
    
    $childId = '';
    if($child){
      $childId = $child->getId();
    }
    ?>
    <div class="panel panel-default">
      <div class="panel-heading">Child and Parents Relationship</div>
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
        <tr>
          <td><?= $father ? $father->getDisplayExtension()->getName() : ''; ?></td>
          <td><?= $mother ? $mother->getDisplayExtension()->getName() : ''; ?></td>
          <td><?= $child ? $child->getDisplayExtension()->getName() : ''; ?></td>
        </tr>
        <tr>
          <td><?= $father ? $father->getDisplayExtension()->getLifespan() : ''; ?></td>
          <td><?= $mother ? $mother->getDisplayExtension()->getLifespan() : ''; ?></td>
          <td><?= $child ? $child->getDisplayExtension()->getLifespan() : ''; ?></td>
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