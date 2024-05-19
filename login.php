<?php 

  require("dbconn.php");

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
      
      $query = $conn->query("SELECT * FROM paws.users WHERE username = '".$_POST["username"]."';");

      if ($row = $query->fetch()) {
        if (md5($_POST["password"]) == $row['password']) {

          setcookie("username", $_POST["username"], time() + 3600);
          $_SESSION["username"] = $_POST["username"];
          $_SESSION["profile_image"] = $row["image"];

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
  }

  $username = "";

  if (isset($_COOKIE["username"])) {
    $username = $_COOKIE["username"];
  }
?>

<link rel="stylesheet" href="styles/login.css">
<script src="js/login.js" defer></script>

<form method="POST" class="login-form" enctype="multipart/form-data">
  <p class="login-title">Login</p>
  <input type="text" name="username" placeholder="Username" value="<? echo($username) ?>" required>
  <input type="password" name="password" placeholder="Password" required>
  <input type="submit" value="Login">
  <p>Don't have an account yet? <a class="login-href" id="regBtn" href="index.php?page=register"> Register here</a></p>
</form>