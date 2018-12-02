<?php
session_start();
require('waytab-secure/connect.php');

if(isset($_SESSION['user'])) {
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
    <nav class="navbar navbar-expand-md navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand mb-0 h1" href="manage.php">Manage</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#manageNavbar" aria-controls="manageNavbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="manageNavbar">
          <div class="navbar-nav w-100">
            <a class="nav-item nav-link active" href="#">Home</a>
            <a class="nav-item nav-link" href="modules/schedule">Schedule <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link ml-auto" href="logout.php">Log out</a>
          </div>
        </div>
      </div>
    </nav>

    <div class="container mt-3 mt-md-4">
      <div class="card card-body">
        <h4 class="card-title">Special Schedules</h4>
        <?php
          $get_schedule = $pdo->prepare('SELECT * FROM `schedules` WHERE `date` >= ? ORDER BY `date` ASC LIMIT 1');
          $get_schedule->execute([time()]);
          $schedule = $get_schedule->fetch(PDO::FETCH_ASSOC);

          if($schedule) {
            ?>
            <p class="lead">Next special schedule: <strong><?= $schedule['name'] ?></strong> on <strong><?= date('m/d/Y', $schedule['date']) ?></strong></p>
            <?php
          } else {
            ?>
            <p class="lead">There are no upcoming special schedules.</p>
            <?php
          }
        ?>
        <a href="modules/schedule" class="card-link">Manage Special Schedules</a>
      </div>
      <h4 class="mt-5">Important links:</h4>
      <a href="https://waytab.org" class="h5">WayTab.org</a><br>
      <a href="https://github.com/WayTab" class="h5">WayTab on GitHub</a><br>
      <a href="https://andrewward2001.com/phpmyadmin" class="h5">Database (for Manage)</a><br>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
<?php } else { header('location:index.php'); } ?>