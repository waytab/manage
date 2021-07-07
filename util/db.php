<?php

// essentially, we're not going to be cloning the waytab-secure submodule
// during local development. it's a private repo that exists only on the
// server. so, if we can't find it (local dev environment), let's go ahead
// and connect to vagrant's root user.
if(file_exists('../waytab-secure/connect.php')) {
  require '../waytab-secure/connect.php';
} else {
  $host = 'localhost';
  $user = 'waytab';
  $pass = '';

  try {
    $pdo = new PDO(
      "mysql:host=$host;dbname=waytab",
      $user,
      $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo $e;
  }
}
