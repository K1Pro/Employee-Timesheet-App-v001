<!-- Calendar Header -->
<div
  id="calendarHeader"
  class="row calendarHeaderRow bg-secondary responsiveHeaderFont"
  style="--bs-bg-opacity: 0.5"
>
  <div id="LastMonthButton" class="col-1">
    <?php echo "\n" . '<a href="?date='.date("Y-m-d").'&weeks='.($weeks - 4).'"><img src="images/FastBackwardWhite.png" alt="Last-Month" /></a>'; ?>
  </div>
  <div class="col-1"></div>
  <div id="LastWeekButton" class="col-1">
    <?php echo "\n" . '<a href="?date='.date("Y-m-d").'&weeks='.($weeks - 1).'"><img src="images/BackwardWhite.png" alt="Last-Week" /></a>'; ?>
  </div>
  <div id="CalendarDate" class="col-6 text-center text-light font-weight-bold">
    <?php 
      echo $date;
    ?>
  </div>
  <div id="NextWeekButton" class="col-1 text-end">
    <?php echo "\n" . '<a href="?date='.date("Y-m-d").'&weeks='.($weeks + 1).'"><img src="images/ForwardWhite.png" alt="Next-Week" /></a>'; ?>
  </div>
  <div class="col-1 text-end"></div>
  <div id="NextMonthButton" class="col-1 text-end">
    <?php echo "\n" . '<a href="?date='.date("Y-m-d").'&weeks='.($weeks + 4).'"><img src="images/FastForwardWhite.png" alt="Next-Month" /></a>'; ?>
  </div>
</div>

<!-- Calendar Dates -->
<?php
  // $directory = realpath('.') . "/nodes/" . substr($date, 0, 7) . "/" . substr($date, 8, 2);
  // listNodeActivity($date, $nodeList, $directory);
  populateCalendar($date, $nodeList, $weeks, $userList);
?>
<div id="CalendarHTMLModule"></div>
