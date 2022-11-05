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

function listAllNodeActivity($sidePanelDate, $nodeList) {
  $directory = realpath('.') . "/nodes/" . $sidePanelDate;
  $scanned_directory = array_diff(scandir($directory), array('..', '.'));
  foreach( $scanned_directory as $logFiles ) {
    $scannedNode = substr($logFiles, 0, 26);
    if (in_array($scannedNode, $nodeList)) {
          $timeOfScannedNode = substr($logFiles, 27, 5);
          echo '<div class="text-light border-bottom border-white nodeActivitySidePanel ';
            if (substr($scannedNode, 0, 8) == "Bartosz_") {echo 'BartoszTime';}
            if (substr($scannedNode, 0, 8) == "Hanna___") {echo 'HannaTime';}
            if (substr($scannedNode, 0, 8) == "Joanna__") {echo 'JoannaTime';}
          echo '">' . str_replace("_", ":", $timeOfScannedNode) . ' ';
          echo str_replace("_", "", $scannedNode) . ": ";
          echo str_replace("_", " ", substr($logFiles, 36, 8)) . '</div>' . "\n";
      }
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
  $dayOfTheWeek = 1;
  $calendarDay = 0;
  do {
      $calendarDate=strtotime("$weeks week last monday + $calendarDay day");
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