<?php
session_start();
require('../../waytab-secure/connect.php');

if(isset($_POST['new_schedule'])) {
  $items = $_POST['item'];
  $date = strtotime($_POST['date']);

  $new_schedule = $pdo->prepare("INSERT INTO `schedules` (`name`, `date`) VALUES (?, ?)");
  $new_schedule->execute([$_POST['name'], $date]);
  $new_schedule_id = $pdo->lastInsertId();

  foreach($items as $item) {
    $new_item = $pdo->prepare("INSERT INTO `schedule_periods` (`name`, `start`, `end`, `schedule`) VALUES (?, ?, ?, ?)");
    $new_item->execute([$item[0], $item[1], $item[2], $new_schedule_id]);
  }
}

if(isset($_POST['deleteSchedule'])) {
  $delete_schedule = $pdo->prepare("DELETE FROM `schedules` WHERE `id` = ?");
  $delete_schedule->execute([$_POST['id']]);
}

if(isset($_GET['timestamp']) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
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
              <a class="nav-item nav-link active" href="#">Schedule <span class="sr-only">(current)</span></a>
              <a class="nav-item nav-link ml-auto" href="../../logout.php">Log out</a>
            </div>
          </div>
        </div>
      </nav>

      <div class="container mt-3 mt-md-4">
        <h3 class="display-4">New Special Schedule</h3>
        <form action="" method="post">
          <input type="hidden" name="num-items" id="num-items" value="1">
          <div class="list-group" id="newScheduleList">
            <div class="list-group-item">
              <div class="row">
                <div class="col"><input type="text" placeholder="Name" class="form-control" name="name"></div>
                <div class="col"><input type="date" class="form-control" name="date"></div>
              </div>
            </div>
            <div class="list-group-item">
              <div class="row">
                <div class="col"><input type="text" placeholder="Name" class="form-control" name="item[0][]"></div>
                <div class="col"><input type="text" placeholder="Start" class="form-control" name="item[0][]"></div>
                <div class="col"><input type="text" placeholder="End" class="form-control" name="item[0][]"></div>
              </div>
            </div>
          </div>
          <button class="btn btn-secondary mt-3" id="new-item">Add new item</button>
          <button class="btn btn-primary mt-3 float-right" name="new_schedule">Submit</button>
        </form>

        <h3 class="display-4 mt-5">Upcoming Special Schedules</h3>
        <?php
          $get_schedule = $pdo->query('SELECT * FROM `schedules` WHERE `date` >= UNIX_TIMESTAMP()');
          foreach($get_schedule as $schedule) {
            ?>
              <h4><?= $schedule['name'] ?> on <?= date('m/d/Y', $schedule['date']) ?>
                <form method="post" class="d-inline-block"><button class="ml-3 btn btn-sm btn-danger" name="deleteSchedule">Delete</button><input type="hidden" value="<?= $schedule['id'] ?>" name="id"></form>
              </h4>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Period</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $get_periods = $pdo->prepare('SELECT * FROM `schedule_periods` WHERE `schedule` = ?');
                    $get_periods->execute([$schedule['id']]);

                    foreach($get_periods as $period) {
                      ?>
                      <tr>
                        <td><?= $period['name'] ?></td>
                        <td><?= $period['start'] ?></td>
                        <td><?= $period['end'] ?></td>
                      </tr>
                      <?php
                    }
                  ?>
                </tbody>
              </table>
            <?php
          }
        ?>
      </div>

      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

      <script type="text/javascript">
        $('[data-toggle="popover"').popover()

        $(document).on('click', '#new-item', (e) => {
          e.preventDefault()
          let thisNum = $('#num-items').val()
          $('#num-items').val(parseInt(thisNum) + 1)
          $('#newScheduleList').append(
            $('<div></div>').addClass('list-group-item').append(
              $('<div></div>').addClass('row').append(
                $('<div></div>').addClass('col').append(
                  $('<input>').attr({
                    type: 'text',
                    name: `item[${thisNum}][]`,
                    placeholder: 'Name',
                    class: 'form-control',
                  })
                )
              ).append(
                $('<div></div>').addClass('col').append(
                  $('<input>').attr({
                    type: 'text',
                    name: `item[${thisNum}][]`,
                    placeholder: 'Start',
                    class: 'form-control',
                  })
                )
              ).append(
                $('<div></div>').addClass('col').append(
                  $('<input>').attr({
                    type: 'text',
                    name: `item[${thisNum}][]`,
                    placeholder: 'End',
                    class: 'form-control',
                  })
                )
              )
            )
          )
        })
      </script>
    </body>
  </html>
  <?php 
  }
} ?>