<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require('../../util/db.php');

$get_announcement = $pdo->query('SELECT * FROM `announcements`');

echo '{';
  if($get_announcement) {
    echo json_encode($get_announcement->fetchAll(PDO::FETCH_ASSOC));
  }
echo '}';