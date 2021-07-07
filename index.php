<?php
session_start();
require('util/db.php');

$name = "";
if(isset($_SESSION["user"])) {
  $name_query = $pdo->prepare("SELECT fname, lname FROM `users` WHERE `id` = ?");
  $name_query->execute([$_SESSION["user"]]);
  $name = $name_query->fetch(PDO::FETCH_ASSOC);
  $name = $name['fname'] . ' ' . $name['lname'];
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Manage</title>
  </head>
  <body>
    <div class="container mt-5">
      <h1>Manage</h1>
      <p class="lead">Manage is WayTab's remote management suite</p>
      <p>Manage allows us to implement features like special bell schedules.</p>
      <?php if(isset($_SESSION["user"])) { ?><p class="lead">Welcome back, <?= $name ?></p><?php } ?>
      <p>
        <a href="https://waytab.org" class="btn btn-primary">WayTab.org</a> 
        <?php
          if(isset($_SESSION["user"])) {
            ?>
            <a href="manage.php" class="btn btn-primary">Manage</a> 
            <a href="logout.php" class="ml-2">Log out</a>
            <?php
          } else {
            ?>
            <a href="signin.php" class="btn btn-primary">Sign in</a>
            <?php 
            if(isset($_GET['forbidden']) && $_GET['forbidden'] == 1) {
              ?>
              <span class="ml-2 text-danger">You must be signed in to do that!</span>
              <?php
            }
            ?>
            <?php
          }
        ?>
      </p>
    </div>
  </body>
</html>