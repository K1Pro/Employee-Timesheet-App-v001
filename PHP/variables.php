<?php

// get the amount of weeks chosen from the URL
$weeks = $_GET["weeks"];
if($weeks){} else {$weeks=-3;}

// get the date from the URL
$date = $_GET["date"];
if($date == ""){$date = date("Y-m-d");} 

$sidePanelDate = substr($date, 0, 7) . "/" . substr($date, 8, 2);

// List of all monitored work computers: String Length has to equal 26
$nodeList = [
  "node1" => "POLAND-DESKTOP1",
  "node2" => "POLAND-DESKTOP2",
  "node3" => "OFFICE-DESKTOP1",
  "node4" => "OFFICE-DESKTOP2",
  "node5" => "OFFICE-LAPTOP1",
  "node6" => "POLAND-LAPTOP1",
];

// List of all monitored work computers: String Length has to equal 26
$userList = [
  "user1" => "Hanna",
  "user2" => "Bartosz",
  "user3" => "Joanna",
  "user4" => "Staff",
];
?>