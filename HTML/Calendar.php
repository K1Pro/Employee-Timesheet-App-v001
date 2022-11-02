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

$directory = realpath('.') . "/nodes/" . substr($date, 0, 7) . "/" . substr($date, 8, 2);
// echo $directory;
$scanned_directory = array_diff(scandir($directory), array('..', '.'));
print_r($scanned_directory);
foreach( $scanned_directory as $bartkadirectory ) {
  echo substr($bartkadirectory, , ) . '<br>';
}

$dayOfTheWeek = 1;
$calendarDay = 0;
do {
    $calendarDate=strtotime("-1 week last monday + $calendarDay day");
    if ($dayOfTheWeek == 1) {
      echo '<div class="row calendarRow">';
    }
// Saturday
    if ($dayOfTheWeek == 6) {
      echo '<div class="col">';
      echo '<div class="row calendarSatSunRow">';
      echo('<a class="col border border-secondary day-hover responsiveFont');
        if (date("Y-m-d", $calendarDate) == $date) { echo ' calendarCurrentDay';}
      echo '" href="?date='.date("Y-m-d", $calendarDate).'">';
      echo '<div id="day'.$calendarDay.'">'.date("m-d", $calendarDate).'</div></a></div>';
// Sunday
    } else if ($dayOfTheWeek == 7) {
      echo '<div class="row calendarSatSunRow">';
      echo('<a class="col border border-secondary day-hover responsiveFont');
        if (date("Y-m-d", $calendarDate) == $date) { echo ' calendarCurrentDay';}
      echo '" href="?date='.date("Y-m-d", $calendarDate).'">';
      echo '<div id="day'.$calendarDay.'">'.date("m-d", $calendarDate).'</div></a></div></div></div>';
      $dayOfTheWeek = 0;
// Monday-Friday
    } else {
      echo('<a class="col border border-secondary day-hover responsiveFont');
        if (date("Y-m-d", $calendarDate) == $date) { echo ' calendarCurrentDay';}
      echo '" href="?date='.date("Y-m-d", $calendarDate).'">';
      echo '<div id="day'.$calendarDay.'">'.date("m-d", $calendarDate).'</div></a>';
    }
    $dayOfTheWeek++;
    $calendarDay++;
} while ($calendarDay < 28);
?>
<div id="CalendarHTMLModule"></div>
