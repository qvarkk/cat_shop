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
    if (isset($_POST["username"]) && isset($_POST["password"])) {
      
      if ($_POST["username"] == "admin" &&
          $_POST["password"] == "admin") {

        setcookie("username", $_POST["username"], time() + 3600);
        $_SESSION["username"] = $_POST["username"];
        setcookie("password", $_POST["password"], time() + 3600);

        $_SESSION["message"] = "Logged in";
        header("Location: index.php?page=profile");
        die();

      } else {
        $_SESSION["message"] = "Wrong credentials";
        header("Location: index.php?page=login");
        die();
      }
    }
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
<script src="js/login.js" defer></script>

<form method="POST" class="login-form" enctype="multipart/form-data">
  <p class="login-title">Login</p>
  <input type="text" name="username" placeholder="Username" value="<? echo($username) ?>" required>
  <input type="password" name="password" placeholder="Password" value="<? echo($password) ?>" required>
  <input type="submit" value="Login">
  <input type="button" id="logoutBtn" value="Logout">
  <p>Don't have an account yet? <span class="login-href" id="regBtn"> Register here</span></p>
</form>