<?php
header('Content-Type: application/json');
require('../../waytab-secure/connect.php');

$get_schedule = $pdo->prepare('SELECT * FROM `schedules` WHERE `date` >= ? ORDER BY `date` ASC LIMIT 1');
$get_schedule->execute([$_GET['timestamp']]);
$schedule = $get_schedule->fetch(PDO::FETCH_ASSOC);

$get_periods = $pdo->prepare('SELECT * FROM `schedule_periods` WHERE `schedule` = ?');
$get_periods->execute([$schedule['id']]);

echo '{';
   echo '"name":"' . $schedule['name'] . '",';
   echo '"date":"' . $schedule['date'] . '",';
   echo '"schedule":[';
    foreach($get_periods as $period) {
      echo '{';
        echo '"name":"' . $period['name'] . '",';
        echo '"start":"' . $period['start'] . '",';
        echo '"end":"' . $period['end'] . '"';
      echo '}';
    }
  echo ']';
echo '}';