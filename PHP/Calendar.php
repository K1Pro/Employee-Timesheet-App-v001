<?php
$nodeList = [
  // String Length has to equal 26
  "node1" => "Bartosz_-Poland-Desktop-01",
  "node2" => "Bartosz_-Poland-Desktop-02",
  "node3" => "Hanna___-Office-Desktop-01",
  "node4" => "Bartosz_-Office-Desktop-01",
  "node5" => "Hanna___-Office-Desktop-02",
  "node6" => "Bartosz_-Office-Desktop-02",
  "node7" => "Staff___-Office-Desktop-02",
];
?>

<!-- Calendar Header -->
<div
  id="calendarHeader"
  class="row calendarHeaderRow bg-secondary responsiveHeaderFont"
  style="--bs-bg-opacity: 0.5"
>
  <div id="LastMonthButton" class="col-1">
    <img src="images/FastBackwardWhite.png" alt="Last-Month" />
  </div>
  <div class="col-1"></div>
  <div id="LastWeekButton" class="col-1">
    <img src="images/BackwardWhite.png" alt="Last-Week" />
  </div>
  <div id="CalendarDate" class="col-6 text-center text-light font-weight-bold">
    <?php 
      $date = $_GET["date"];
      if($date == ""){
        $date = date("Y-m-d");
        echo date("Y-m-d");   
      } else { echo $date; }
    ?>
  </div>
  <div id="NextWeekButton" class="col-1 text-end">
    <img src="images/ForwardWhite.png" alt="Next-Week" />
  </div>
  <div class="col-1 text-end"></div>
  <div id="NextMonthButton" class="col-1 text-end">
    <img src="images/FastForwardWhite.png" alt="Next-Month" />
  </div>
</div>

<!-- Calendar Dates -->
<?php
function listNodeActivity($date, $nodeList, $directory) {
  $scanned_directory = array_diff(scandir($directory), array('..', '.'));
  $uniqueNodeList =[];
  foreach( $scanned_directory as $logFiles ) {
    $OSAction = substr($logFiles, -12, 8);
    $scannedNode = substr($logFiles, 0, 26);
    if (in_array($scannedNode, $nodeList) && !in_array($scannedNode, $uniqueNodeList)) {
      if ($OSAction == "Unlocked") {
        
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
// $directory = realpath('.') . "/nodes/" . substr($date, 0, 7) . "/" . substr($date, 8, 2);
// listNodeActivity($date, $nodeList, $directory);


$dayOfTheWeek = 1;
$calendarDay = 0;
do {
    $calendarDate=strtotime("-3 week last monday + $calendarDay day");
    if ($dayOfTheWeek == 1) {
      echo '<div class="row calendarRow">' . "\n";
    }
// Saturday
    if ($dayOfTheWeek == 6) {
      echo "\t" .'<div class="col">' . "\n";


      echo "\t" . "\t" . '<div class="row calendarSatSunRow">' . "\n";
      echo("\t" . "\t" . "\t" . '<a class="col border border-secondary day-hover responsiveFont');
        if (date("Y-m-d", $calendarDate) == $date) { echo ' calendarCurrentDay';}
      echo '" href="?date='.date("Y-m-d", $calendarDate).'">' . "\n";
      echo "\t" . "\t" . "\t" . "\t" . '<div id="day'.$calendarDay.'">'.date("m-d", $calendarDate).'</div></a></div>' . "\n";
// Sunday
    } else if ($dayOfTheWeek == 7) {
      echo "\t" . "\t" . '<div class="row calendarSatSunRow">' . "\n";


      echo("\t" . "\t" . "\t" . '<a class="col border border-secondary day-hover responsiveFont');
        if (date("Y-m-d", $calendarDate) == $date) { echo ' calendarCurrentDay';}
      echo '" href="?date='.date("Y-m-d", $calendarDate).'">' . "\n";
      echo "\t" . "\t" . "\t" . "\t" . '<div id="day'.$calendarDay.'">'.date("m-d", $calendarDate).'</div></a></div></div></div>' . "\n";
      $dayOfTheWeek = 0;
// Monday-Friday
    } else {
      echo("\t" . '<div style="overflow-y: scroll" class="calendarRow col border border-secondary day-hover responsiveFont');
      if (date("Y-m-d", $calendarDate) == $date) { echo ' calendarCurrentDay';}
      echo '">';
      echo "\n" . '<a href="?date='.date("Y-m-d", $calendarDate).'">';
      echo '<div id="day'.$calendarDay.'">'.date("m-d", $calendarDate).'</div></a>' . "\n";
      $directory = realpath('.') . "/nodes/" . date("Y-m/d", $calendarDate);
      listNodeActivity($date, $nodeList, $directory);
      echo '</div>' . "\n";
    }
    $dayOfTheWeek++;
    $calendarDay++;
} while ($calendarDay < 28);
?>
<div id="CalendarHTMLModule"></div>
