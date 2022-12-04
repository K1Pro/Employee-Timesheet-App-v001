<?php

// Shows first node activity inside calendar days
function listFirstLogonNodeActivity($calendarDate, $nodeList, $userList) {
  $directory = realpath('.') . "/nodes/" . date("Y-m/d", $calendarDate);
  $scanned_directory = array_diff(scandir($directory), array('..', '.'));
  $uniqueNodeList =[];
  foreach( $scanned_directory as $logFiles ) {
    $firstUnderscore = strpos($logFiles, "_", 0) + 1;
    $secondUnderscore = strpos($logFiles, "_", strpos($logFiles, "_") + 1);
    $nodeLength = $secondUnderscore - $firstUnderscore;
    $nodeName = substr($logFiles, $firstUnderscore, $nodeLength);
    if (!in_array($nodeName, $uniqueNodeList)) {
      echo '<div class="text-light border-bottom border-white nodeActivity ' . $nodeName . '">';
      echo str_replace("-", ":", substr($logFiles, $secondUnderscore + 1, 5)) . " " . ucfirst(strtolower($nodeName));
      echo '</div>';
      array_push($uniqueNodeList , $nodeName);
    }
  }
}

// Side Panel
function listAllNodeActivity($sidePanelDate, $nodeList) {
  $directory = realpath('.') . "/nodes/" . $sidePanelDate;
  $scanned_directory = array_diff(scandir($directory), array('..', '.'));
  $uniqueNodeList =[];
  foreach( $scanned_directory as $logFiles ) {
    $firstUnderscore = strpos($logFiles, "_", 0);
    $secondUnderscore = strpos($logFiles, "_", strpos($logFiles, "_") + 1);
    $lastUnderscore = strripos($logFiles, "_");
    $nodeLength = $secondUnderscore - $firstUnderscore;
    $OSAction = substr($logFiles, $lastUnderscore + 1, 8); // I don't think this is being used anywhere, check this later
    $scannedNode = substr($logFiles, 0, $secondUnderscore);
    if (!in_array($scannedNode, $uniqueNodeList)) {
      if ($firstUnderscore !== 0) {
        // This gives us a list of unique nodes that have indeed logged on
        array_push($uniqueNodeList , $scannedNode);
      }
    }
    // if (!in_array($scannedNode, $uniqueNodeList)) {
    //   if(!in_array($scannedNode, $uniqueNodeList , true)){
    //     // echo "</br>" . $scannedNode;
    //     array_push($uniqueNodeList , $scannedNode);
    //   }
    // }
  }
  // probably can delete this  VVVV check
  // $newUniqueNodeArrays = 0;
  // $sortedNodeArrays = 0;
  
  foreach ($uniqueNodeList as $uniqueNode){
    // echo "</br>" . $uniqueNode;
    //////////////////Check these four lines beneath very closely, it caused a serious bug in the side panel
    // $newUniqueNodeArraysNo++;
    $newUniqueNodeArrays = [];
    // $sortedNodeArraysNo++;
    $sortedNodeArrays = [];
    foreach( $scanned_directory as $logFilesTwo ) {
      if (strpos($logFilesTwo, $uniqueNode) !== FALSE) {
        array_push($newUniqueNodeArrays, $logFilesTwo);
      }
    }
    $rep = 0;
    $arrayRep = 0;
    $idleCount = 0;
    $turnedOnCount = 0;
    $newUniqueNodeArraysCount = count($newUniqueNodeArrays) - 1;
    $shortNewUniqueNodeArray = [];
    // echo $newUniqueNodeArrays[$newUniqueNodeArraysCount];
    foreach ($newUniqueNodeArrays as $shortNewUniqueNode){
      $lastUnderscore = strripos($shortNewUniqueNode, "_");
      $shortNewUniqueNode = substr($shortNewUniqueNode, $lastUnderscore + 1, 8);
      // echo "</br>" . $shortNewUniqueNode;
      array_push($shortNewUniqueNodeArray, $shortNewUniqueNode);
    }

    if(in_array("LoggedOn", $shortNewUniqueNodeArray) || in_array("Unlocked", $shortNewUniqueNodeArray)){} else {
      // If noone has logged onto the node this is first stated in new Array
      $secondUnderscore = strpos($newUniqueNodeArrays[0], "_", strpos($newUniqueNodeArrays[0], "_") + 1);
      $sortedNodeLabel = substr($newUniqueNodeArrays[0], 0, $secondUnderscore);
      $sortedNodeLabel = str_replace("_", " ", $sortedNodeLabel) . ':';
      array_push($sortedNodeArrays, $sortedNodeLabel);
      array_push($sortedNodeArrays, " ■ No log on, turned on: " . substr($newUniqueNodeArrays[0], $secondUnderscore + 1, 2) . ":" . substr($newUniqueNodeArrays[0], $secondUnderscore + 4, 2));
    }

    foreach ($newUniqueNodeArrays as $newUniqueNodeArray){
      if ((strpos($newUniqueNodeArray, "LoggedOn") !== FALSE) || in_array("Unlocked", $shortNewUniqueNodeArray)) {
        $rep++;
        if ($rep == 1) {
          // Pushes the user name from the first time that that user logs onto a node to new Array
          $secondUnderscore = strpos($newUniqueNodeArray, "_", strpos($newUniqueNodeArray, "_") + 1);
          $sortedNodeLabel = substr($newUniqueNodeArray, 0, $secondUnderscore);
          $sortedNodeLabel = str_replace("_", " ", $sortedNodeLabel) . ':';
          array_push($sortedNodeArrays, $sortedNodeLabel);

          // Pushes the first time that a user logs onto a node to new Array
          $sortedNodeFirstLogon = substr($newUniqueNodeArray, $secondUnderscore + 1, 5);
          $sortedNodeFirstLogon = str_replace("-", ":", $sortedNodeFirstLogon);
          $sortedNodeFirstLogon = " ■ First Logged On: " . $sortedNodeFirstLogon;
          array_push($sortedNodeArrays, $sortedNodeFirstLogon);
        } 
      } 
      // else if ((strpos($newUniqueNodeArray, "Logon") !== TRUE))
      if ((strpos($newUniqueNodeArray, "Idle-Yes") !== FALSE)) {
        $idleCount++;
      }
      if ((strpos($newUniqueNodeArray, "LogInYes") !== FALSE)) {
        $turnedOnCount++;
      }
    }

    // Pushes the total time that a node is turned on to new Array
    $turnedOnCount = $turnedOnCount * 15; // adding a minus one here might compensate for one thing on the OS side, explore this further
    $convertedturnedOnCount = " ■ Total time logged on: " . intdiv($turnedOnCount, 60).':'. ($turnedOnCount % 60) . " hrs";
    array_push($sortedNodeArrays, $convertedturnedOnCount);

    // Pushes the real idle time registered on a new to new Array
    $idleCount = $idleCount * 15;
    $convertedIdleCount = " ■ Total idle time: " . intdiv($idleCount, 60).':'. ($idleCount % 60)  . " hrs";
    if ($idleCount == 0) { $convertedIdleCount = " ■ Total idle time: none √";}
    array_push($sortedNodeArrays, $convertedIdleCount);

    // Pushes the last registered node activity to new Array
    $secondUnderscore = strpos($newUniqueNodeArray, "_", strpos($newUniqueNodeArray, "_") + 1);
    $lastUnderscore = strripos($newUniqueNodeArray, "_");
    $lastNodeActivity = substr($newUniqueNodeArray, $lastUnderscore, 9) . ": " . substr($newUniqueNodeArray, $secondUnderscore + 1, 2) . ":" . substr($newUniqueNodeArray, $secondUnderscore + 4, 2);
    $lastNodeActivity  = " ■ " . str_replace("_", " ", $lastNodeActivity );
    array_push($sortedNodeArrays, $lastNodeActivity );

    $rep = 0;
    foreach ($sortedNodeArrays as $sortedNodeArray){
      $rep++;
      if ($rep == 1) {
        echo '<div class="text-light border-bottom border-white nodeActivitySidePanel ';
        if (substr($sortedNodeArray, 0, 7) == "bartosz") {echo 'bartosz';}
        if (substr($sortedNodeArray, 0, 5) == "hanna") {echo 'hanna';}
        if (substr($sortedNodeArray, 0, 6) == "joanna") {echo 'joanna';}
        if (substr($sortedNodeArray, 0, 5) == "staff") {echo 'staff';}
        echo '">';
      }
      echo $sortedNodeArray . "</br>";
      if ($rep == 5) {
        echo '</div>' . "\n";
      }
    }
    // echo "</br>";
  }
}

function listDateHeaders($date, $calendarDay, $calendarDate) {
    if (date("Y-m-d", $calendarDate) == $date) { echo ' calendarCurrentDay';}
    // echo date("Y-m-d", $calendarDate);
  echo '">';
  echo "\n" . '<a href="?date='.date("Y-m-d", $calendarDate).'">';
  echo '<div id="day'.$calendarDay.'">'.date("m-d", $calendarDate).'</div></a>' . "\n";
}

function populateCalendar($date, $nodeList, $weeks, $userList){
  // here is a slight bug when it is a Sunday
  $dayOfTheWeekNo = date('w') - 0;
  $dayOfTheWeek = 1;
  $calendarDay = 0;
  do {
      $calendarDate=strtotime("$weeks week + $calendarDay day - $dayOfTheWeekNo day");
      // echo $weeks . "week, " . $calendarDay . "day, ";
      if ($dayOfTheWeek == 1) {
        echo '<div class="row calendarRow">' . "\n";
      }
  // Saturday
      if ($dayOfTheWeek == 6) {
        echo "\t" .'<div class="col">' . "\n";
        echo "\t" .'<div class="row calendarSatSunRow">' . "\n";
        echo("\t" . '<div style="overflow-y: scroll" class="calendarSatSunRow col border border-secondary day-hover responsiveFont');
        listDateHeaders($date, $calendarDay, $calendarDate);
        listFirstLogonNodeActivity($calendarDate, $nodeList, $userList);
        echo '</div></div>' . "\n";
  // Sunday
      } else if ($dayOfTheWeek == 7) {
        echo "\t" .'<div class="row calendarSatSunRow">' . "\n";
        echo("\t" . '<div style="overflow-y: scroll" class="calendarSatSunRow col border border-secondary day-hover responsiveFont');
        listDateHeaders($date, $calendarDay, $calendarDate);
        listFirstLogonNodeActivity($calendarDate, $nodeList, $userList);
        echo '</div></div></div></div>' . "\n";
        $dayOfTheWeek = 0;
  // Monday-Friday
      } else {
        echo("\t" . '<div style="overflow-y: scroll" class="calendarRow col border border-secondary day-hover responsiveFont');
        listDateHeaders($date, $calendarDay, $calendarDate);
        listFirstLogonNodeActivity($calendarDate, $nodeList, $userList);
        echo '</div>' . "\n";
      }
      $dayOfTheWeek++;
      $calendarDay++;
  } while ($calendarDay < 28);
}

?>