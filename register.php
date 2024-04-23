<?php
  if (isset($_SESSION["username"])) {
    $_SESSION["message"] = "Already logged in";
    header("Location: index.php?page=start");
    die();
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"])) {
      $_SESSION["username"] = $_POST["username"];
      setcookie("username", $_POST["username"], time() + 3600);
    }

    if (isset($_POST["password"])) {
      setcookie("password", $_POST["password"], time() + 3600);
    }

    if (isset($_FILES["profile_image"])) {
      $uploadDir = "uploads/";
      $uploadFile = $uploadDir.basename($_FILES["profile_image"]["name"]);

      if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $uploadFile)) {
        setcookie("profile_image", $uploadFile, time() + 3600);
      } else {
        echo "Error loading file to server";
      }
    }    

    $_SESSION["message"] = "Registered";
    header("Location: index.php?page=start");
    die();
  }

  $username = "";
  $password = "";
  $profile_image = "";

  if (isset($_COOKIE["username"])) {
    $username = $_COOKIE["username"];
  }

  if (isset($_COOKIE["password"])) {
    $password = $_COOKIE["password"];
  }

  if (isset($_COOKIE["profile_image"])) {
    $profile_image = $_COOKIE["profile_image"];
  }

?>

<link rel="stylesheet" href="styles/register.css">

<form method="POST" enctype="multipart/form-data" class="reg-form">
  <p class="reg-title">Register</p>
  <input type="text" placeholder="Username" name="username" value="<? echo($username) ?>" required>
  <input type="number" placeholder="Phone number" name="phone_num" value="<? echo($phone_num) ?>" required>
  <input type="password" placeholder="Password" name="password" value="<? echo($password) ?>" required>
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
</form>