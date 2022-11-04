<?php
function listNodeActivity($calendarDate, $nodeList) {
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
          echo '">' . str_replace("_", ":", $timeOfScannedNode) . ' ';
          echo str_replace("_", "", $scannedNode) . '</div>' . "\n";
          if(!in_array($scannedNode, $uniqueNodeList , true)){
            array_push($uniqueNodeList , $scannedNode);
        }
        }
      }
  }
}
?>