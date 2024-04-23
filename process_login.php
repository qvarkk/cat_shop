<?php

  session_start();

  if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
      case "register":
        if (isset($_POST["username"])) {
          setcookie("username", $_POST["username"], time() + 3600);
        }
        
        if (isset($_POST["phone_num"])) {
          setcookie("phone_num", $_POST["phone_num"], time() + 3600);
        }

        if (isset($_POST["password"])) {
          setcookie("password", $_POST["password"], time() + 3600);
        }

        if (isset($_POST["gender"])) {
          setcookie("gender", $_POST["gender"], time() + 3600);
        }

        if (isset($_FILES["profile_image"])) {
          $uploadDir = "uploads/";
          $uploadFile = $uploadDir.basename($_FILES["profile_image"]["name"]);
          echo($_FILES["profile_image"]["tmp_name"]." aaaaaaaa");
          if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $uploadFile)) {
            setcookie("profile_image", $_POST["profile_image"], time() + 3600);
          } else {
            echo "Error loading file to server";
          }
        }

        $_SESSION["username"] = $_POST["username"];
        break;
      default:  
        header("Location: index.php");
        die();
        break;
    }
  }

?>