<?php 

  if (isset($_GET["action"])) {
    if ($_GET["action"] == "logout") {
      session_unset();
      $_SESSION["message"] = "Logged out";
      header("Location: index.php?page=start");
      die();
    }
  }

  if (isset($_SESSION["username"])) {
    $_SESSION["message"] = "Already logged in";
    header("Location: index.php?page=profile");
    die();
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"])) {
      setcookie("username", $_POST["username"], time() + 3600);
      $_SESSION["username"] = $_POST["username"];
    }

    if (isset($_POST["password"])) {
      setcookie("password", $_POST["password"], time() + 3600);
    }

    $_SESSION["message"] = "Logged in";
    header("Location: index.php?page=profile");
    die();
  }

  $username = "";
  $password = "";

  if (isset($_COOKIE["username"])) {
    $username = $_COOKIE["username"];
  }

  if (isset($_COOKIE["password"])) {
    $password = $_COOKIE["password"];
  }
?>

<link rel="stylesheet" href="styles/login.css">

<form method="POST" enctype="multipart/form-data">
  <input type="text" placeholder="Username" value="<? echo($username) ?>" required>
  <input type="password" placeholder="Password" value="<? echo($password) ?>" required>
  <input type="submit" value="Login">
</form>

<form method="GET" action="index.php?page=register">
  <input type="submit" value="Register">
</form>

<form method="GET" action="index.php?page=login&action=logout">
  <input type="submit" value="Logout">
</form>