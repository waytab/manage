<?php
session_start();
require('../../util/db.php');

if(isset($_POST['new_announcement']) && isset($_POST['announcement'])) {
  $createAnnouncement = $pdo->prepare("INSERT INTO `announcements` (`title`, `text`) VALUES (?, ?)");
  $createAnnouncement->execute([@$_POST['title'], $_POST['announcement']]);
}

if(isset($_POST['deleteAnnouncement'])) {
  $delete_schedule = $pdo->prepare("DELETE FROM `announcements` WHERE `id` = ?");
  $delete_schedule->execute([$_POST['id']]);
}

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  require('ajax.php');
} else {
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

      <title>Announcements - Manage</title>
    </head>
    <body>
      <nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container">
          <a class="navbar-brand mb-0 h1" href="../../manage.php">Manage</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#manageNavbar" aria-controls="manageNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="manageNavbar">
            <div class="navbar-nav w-100">
              <a class="nav-item nav-link" href="../../manage.php">Home</a>
              <a class="nav-item nav-link active" href="#">Announcements <span class="sr-only">(current)</span></a>
              <a class="nav-item nav-link" href="../schedule">Schedule</a>
              <a class="nav-item nav-link" href="../password">Password</a>
              <a class="nav-item nav-link ml-auto" href="../../logout.php">Log out</a>
            </div>
          </div>
        </div>
      </nav>

      <div class="container mt-3 mt-md-4">
        <h3 class="display-4">New Announcement</h3>
        <form action="" method="post">
          <input class="form-control mb-2" name="title" placeholder="Title (optional)" />
          <textarea class="form-control" name="announcement" placeholder="Body"></textarea>
          <button class="btn btn-primary mt-3 float-right" name="new_announcement">Submit</button>
        </form>

        <h3 class="display-4 mt-5">Current Announcements</h3>
        <?php
          $get_announcements = $pdo->query('SELECT * FROM `announcements`');
          foreach($get_announcements as $announcement) {
            ?>
              <div class="card card-body mb-3">
                <h3>Title: <?= $announcement['title'] ?></h3>
                <p><?= $announcement['text'] ?></p>
                <form method="post"><button class="btn btn-sm btn-danger" name="deleteAnnouncement">Delete</button><input type="hidden" value="<?= $announcement['id'] ?>" name="id"></form>
              </div>
            <?php
          }
        ?>
      </div>

      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
  </html>
  <?php 
  } else { header('location:../../index.php?forbidden=1'); }
} ?>