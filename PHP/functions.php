<?php
function listFirstLogonNodeActivity($calendarDate, $nodeList) {
  $directory = realpath('.') . "/nodes/" . date("Y-m/d", $calendarDate);
  $scanned_directory = array_diff(scandir($directory), array('..', '.'));
  $uniqueNodeList =[];
  foreach( $scanned_directory as $logFiles ) {
    $OSAction = substr($logFiles, -12, 8);
    $scannedNode = substr($logFiles, 0, 26);
    if (in_array($scannedNode, $nodeList) && !in_array($scannedNode, $uniqueNodeList)) {
      if ($OSAction == "Logon_at") {
          $timeOfScannedNode = substr($logFiles, 27, 5);
          echo '<div class="text-light border-bottom border-white nodeActivity ';
            if (substr($scannedNode, 0, 8) == "Bartosz_") {echo 'BartoszTime';}
            if (substr($scannedNode, 0, 8) == "Hanna___") {echo 'HannaTime';}
            if (substr($scannedNode, 0, 8) == "Joanna__") {echo 'JoannaTime';}
          echo '">' . str_replace("_", ":", $timeOfScannedNode) . ' ';
          echo str_replace("_", "", substr($scannedNode, 9, 17)) . '</div>' . "\n";
          if(!in_array($scannedNode, $uniqueNodeList , true)){
            array_push($uniqueNodeList , $scannedNode);
        }
        }
      }
  }
}
// Side Panel
function listAllNodeActivity($sidePanelDate, $nodeList) {
  $directory = realpath('.') . "/nodes/" . $sidePanelDate;
  $scanned_directory = array_diff(scandir($directory), array('..', '.'));
  $uniqueNodeList =[];
  foreach( $scanned_directory as $logFiles ) {
    $OSAction = substr($logFiles, -12, 8);
    $scannedNode = substr($logFiles, 0, 26);
    if (in_array($scannedNode, $nodeList) && !in_array($scannedNode, $uniqueNodeList)) {
      if(!in_array($scannedNode, $uniqueNodeList , true)){
        array_push($uniqueNodeList , $scannedNode);
      }
    }
  }
  $newUniqueNodeArrays = 0;
  $sortedNodeArrays = 0;
  
  foreach ($uniqueNodeList as $uniqueNode){
    $newUniqueNodeArrays++;
    $newUniqueNodeArrays = [];
    $sortedNodeArrays++;
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
      $shortNewUniqueNode = substr($shortNewUniqueNode, 36, 8);
      array_push($shortNewUniqueNodeArray, $shortNewUniqueNode);
    }
    if(in_array("Logon_at", $shortNewUniqueNodeArray)){} else {
      // If noone has logged onto the node this is first stated in new Array
      $sortedNodeLabel = substr($newUniqueNodeArrays[0], 0, 26);
      $sortedNodeLabel = str_replace("_", "", $sortedNodeLabel);
      $sortedNodeLabel = str_replace("-", " ", $sortedNodeLabel) . ':';
      array_push($sortedNodeArrays, $sortedNodeLabel);
      array_push($sortedNodeArrays, " ■ No log on, turned on: " . substr($newUniqueNodeArrays[0], 27, 2) . ":" . substr($newUniqueNodeArrays[0], 30, 2));
    }

    foreach ($newUniqueNodeArrays as $newUniqueNodeArray){
      if ((strpos($newUniqueNodeArray, "Logon") !== FALSE)) {
        $rep++;
        if ($rep == 1) {
          // Pushes the first time that a user logs onto a node to new Array
          $sortedNodeLabel = substr($newUniqueNodeArray, 0, 26);
          $sortedNodeLabel = str_replace("_", "", $sortedNodeLabel);
          $sortedNodeLabel = str_replace("-", " ", $sortedNodeLabel) . ':';
          array_push($sortedNodeArrays, $sortedNodeLabel);

          // Pushes the first time that a user logs onto a node to new Array
          $sortedNodeFirstLogon = substr($newUniqueNodeArray, 27, 5);
          $sortedNodeFirstLogon = str_replace("_", ":", $sortedNodeFirstLogon);
          $sortedNodeFirstLogon = " ■ First Logged On: " . $sortedNodeFirstLogon;
          array_push($sortedNodeArrays, $sortedNodeFirstLogon);
        } 
      } 
      // else if ((strpos($newUniqueNodeArray, "Logon") !== TRUE))
      if ((strpos($newUniqueNodeArray, "Idled") !== FALSE)) {
        $idleCount++;
      }
      if ((strpos($newUniqueNodeArray, "TurnedOn") !== FALSE)) {
        $turnedOnCount++;
      }
    }

    // Pushes the total time that a node is turned on to new Array
    $turnedOnCount = $turnedOnCount * 15;
    $convertedturnedOnCount = " ■ Total time turned on: " . intdiv($turnedOnCount, 60).':'. ($turnedOnCount % 60) . " hrs";
    array_push($sortedNodeArrays, $convertedturnedOnCount);

    // Pushes the real idle time registered on a new to new Array
    $idleCount = $idleCount * 15;
    $convertedIdleCount = " ■ Total idle time: " . intdiv($idleCount, 60).':'. ($idleCount % 60)  . " hrs";
    if ($idleCount == 0) { $convertedIdleCount = " ■ Total idle time: none √";}
    array_push($sortedNodeArrays, $convertedIdleCount);

    // Pushes the last registered node activity to new Array
    $lastNodeActivity = substr($newUniqueNodeArray, 36, 8) . ": " . substr($newUniqueNodeArray, 27, 2) . ":" . substr($newUniqueNodeArray, 30, 2);
    $lastNodeActivity  = " ■ " . str_replace("_", " ", $lastNodeActivity );
    array_push($sortedNodeArrays, $lastNodeActivity );

    $rep = 0;
    foreach ($sortedNodeArrays as $sortedNodeArray){
      $rep++;
      if ($rep == 1) {
        echo '<div class="text-light border-bottom border-white nodeActivitySidePanel ';
        if (substr($sortedNodeArray, 0, 7) == "Bartosz") {echo 'BartoszTime';}
        if (substr($sortedNodeArray, 0, 5) == "Hanna") {echo 'HannaTime';}
        if (substr($sortedNodeArray, 0, 6) == "Joanna") {echo 'JoannaTime';}
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

function populateCalendar($date, $nodeList, $weeks){
  $dayOfTheWeekNo = date('w') - 1;
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
        listFirstLogonNodeActivity($calendarDate, $nodeList);
        echo '</div></div>' . "\n";
  // Sunday
      } else if ($dayOfTheWeek == 7) {
        echo "\t" .'<div class="row calendarSatSunRow">' . "\n";
        echo("\t" . '<div style="overflow-y: scroll" class="calendarSatSunRow col border border-secondary day-hover responsiveFont');
        listDateHeaders($date, $calendarDay, $calendarDate);
        listFirstLogonNodeActivity($calendarDate, $nodeList);
        echo '</div></div></div></div>' . "\n";
        $dayOfTheWeek = 0;
  // Monday-Friday
      } else {
        echo("\t" . '<div style="overflow-y: scroll" class="calendarRow col border border-secondary day-hover responsiveFont');
        listDateHeaders($date, $calendarDay, $calendarDate);
        listFirstLogonNodeActivity($calendarDate, $nodeList);
        echo '</div>' . "\n";
      }
      $dayOfTheWeek++;
      $calendarDay++;
  } while ($calendarDay < 28);
}

?>