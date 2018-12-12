<?php

session_start();

require('waytab-secure/connect.php');

$error = false;
if(isset($_POST['email']) && isset($_POST['password'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $login_query = $pdo->prepare("SELECT * FROM `users` WHERE (`email` = ? OR `login` = ?) AND (`password` = ? OR `password-sha512` = ?)");
  $login_query->execute([$email, $email, sha1($password), hash('sha512', $password)]);
  $user_row = $login_query->fetch(PDO::FETCH_ASSOC);

  $login_id = $user_row['id'];
  
  if($login_id) {
    $_SESSION['user'] = $login_id;

    if($user_row['password-sha512']) {
      $del_sha1_query = $pdo->query("UPDATE `users` SET `password` = '' WHERE `id` = $login_id");
    } else {
      $sha_pw_query = $pdo->prepare("UPDATE `users` SET `password-sha512` = ? WHERE `id` = ?");
      $sha_pw_query->execute([hash('sha512', $password), $login_id]);
      $del_sha1_query = $pdo->query("UPDATE `users` SET `password` = '' WHERE `id` = $login_id");
    }

    header('location: index.php');
  } else {
    $error = true;
  }
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

    <title>Sign in - Manage</title>

    <link rel="stylesheet" href="css/signin.css">
  </head>
  <body class="text-center">
    <form class="form-signin" action="#" method="post">
      <h1 class="display-3 mb-3">Manage</h1>
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <?php if($error) { ?><p class="text-danger">Invalid Credentials</p><?php } ?>
      <label for="inputEmail" class="sr-only">Email address or usename</label>
      <input type="text" id="inputEmail" class="form-control" placeholder="Email address or Username" required="" autofocus="" name="email">
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="" name="password">
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
  </body>
</html>