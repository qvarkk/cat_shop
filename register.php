<?php

  require("dbconn.php");

  if (isset($_SESSION["username"])) {
    $_SESSION["message"] = "Already logged in";
    header("Location: index.php?page=start");
    die();
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["gender"]) && isset($_FILES["profile_image"])) {

      $uploadDir = "uploads/";
      $uploadFile = $uploadDir.basename($_FILES["profile_image"]["name"]);

      if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $uploadFile)) {
        setcookie("profile_image", $uploadFile, time() + 3600);
      } else {
        echo "Error loading file to server";
        die();
      }

      $id_q = $conn->query("SELECT MAX(id) FROM paws.users");
      $id = $id_q->fetch();
      $query = $conn->prepare("INSERT INTO paws.users (id, username, email, gender, password, image) VALUES (".($id["max"] + 1).", '".$_POST["username"]."', '".$_POST["email"]."', '".$_POST["gender"]."', '".md5($_POST["password"])."', '".$uploadFile."');");
      
      if ($query->execute()) {
        $_SESSION["message"] = "Registered";
        header("Location: index.php?page=start");
        die();
      } else {
        $_SESSION["message"] = "This username is already in use";
        header("Location: index.php?page=register");
        die();
      }
    } else {
      $_SESSION["message"] = "Some internal error occured";
        header("Location: index.php?page=register");
        die();
    }
  }

  $username = "";

  if (isset($_COOKIE["username"])) {
    $username = $_COOKIE["username"];
  }
?>

<link rel="stylesheet" href="styles/register.css">
<script src="js/register.js" defer></script>

<form method="POST" enctype="multipart/form-data" class="reg-form">
  <p class="reg-title">Register</p>
  <input type="text" placeholder="Username" name="username" value="<? echo($username) ?>" required>
  <input type="email" placeholder="Email" name="email" required>
  <input type="password" placeholder="Password" name="password" required>
  <select name="gender" required>
    <option value="" disabled selected>Select gender</option>
    <option value="male">Male</option>
    <option value="female">Female</option>
    <option value="other">Other</option>
    <option value="no">Prefer not to say</option>
  </select>
  <div>
    <label for="profile_image">Profile Image</label>
    <input type="file" name="profile_image" accept=".png,.jpeg,.jpg,.webp">
  </div>
  <input type="submit" value="Register">
  <p>Already registered? <span class="reg-href" id="loginBtn"> Login here</span></p>
</form>