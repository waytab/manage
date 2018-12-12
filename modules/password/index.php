<?php
require('../../waytab-secure/connect.php');

$hashedPassword = "";
if(isset($_POST['password'])) {
  $hashedPassword = hash('sha512', $_POST['password']);
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

    <title>Schedules - Manage</title>
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
            <a class="nav-item nav-link" href="../schedule">Schedule</a>
            <a class="nav-item nav-link active" href="#">Password <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link ml-auto" href="../../logout.php">Log out</a>
          </div>
        </div>
      </div>
    </nav>

    <div class="container mt-3 mt-md-4">
      <h3 class="display-4">Generate Password</h3>
      <p class="lead">Generate a SHA-512 hash (database-less)</p>

      <form action="" method="post">
        <input type="password" name="password" class="form-control mb-3">
        <button type="submit" class="btn btn-primary">Generate</button>
      </form>

      <?php if($hashedPassword != '') { ?>
        <h3 class="mt-5">Password (SHA-512):</h3>
        <pre><?= $hashedPassword ?></pre>
      <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>