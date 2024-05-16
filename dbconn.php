<?php
  $host = "127.0.0.1";
  $port = 5432;
  $dbname = "paw-store";
  $username = "postgres";
  $password = "postgres";

  try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
  } catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
  }
?>