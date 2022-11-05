<?php
// get the date from the URL
$date = $_GET["date"];
if($date == ""){$date = date("Y-m-d");} 
$sidePanelDate = substr($date, 0, 7) . "/" . substr($date, 8, 2);



// get the amount of weeks chosen from the URL
$weeks = $_GET["weeks"];
if($weeks){} else {$weeks=-3;}

// List of all monitored work computers: String Length has to equal 26
$nodeList = [
  "node1" => "Bartosz_-Poland-Desktop-01",
  "node2" => "Bartosz_-Poland-Desktop-02",
  "node3" => "Hanna___-Office-Desktop-01",
  "node4" => "Bartosz_-Office-Desktop-01",
  "node5" => "Hanna___-Office-Desktop-02",
  "node6" => "Bartosz_-Office-Desktop-02",
  "node7" => "Staff___-Office-Desktop-02",
  "node8" => "Joanna__-Poland-Laptop_-01",
];
?>