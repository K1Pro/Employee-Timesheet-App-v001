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
    Date
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
$dayOfTheWeek = 1;
$calendarDay = 1;
do {
    if ($dayOfTheWeek == 1) {
      echo '<div class="row calendarRow">';
    }
    if ($dayOfTheWeek == 6) {
      echo '<div class="col">';
      echo '<div class="row calendarSatSunRow">';
      echo '<div id="day'.$calendarDay.'" class="col border border-secondary day-hover responsiveFont">'.$calendarDay.'</div></div>';
    } else if ($dayOfTheWeek == 7) {
      echo '<div class="row calendarSatSunRow">';
      echo '<div id="day'.$calendarDay.'" class="col border border-secondary day-hover responsiveFont">'.$calendarDay.'</div></div></div></div>';
      $dayOfTheWeek = 0;
    } else {
      echo '<div id="day'.$calendarDay.'" class="col border border-secondary day-hover responsiveFont">'.$calendarDay.'</div>';
    }
    $dayOfTheWeek++;
    $calendarDay++;
} while ($calendarDay < 29);
?>
<div id="CalendarHTMLModule"></div>
