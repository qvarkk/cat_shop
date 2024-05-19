<?php

  session_start();

  if (!isset($_GET["total"]) || !isset($_SESSION["username"]) || !isset($_SESSION["profile_image"])) {
    $_SESSION["message"] = "Login first to access profile!";
    header("Location: index.php?page=login");
    die();
  }

  if ($_GET["total"] <= 0) {
    $_SESSION["message"] = "The cart is empty!";
    header("Location: index.php?page=profile");
    die();
  } 

  require("dbconn.php");

  $user_query = $conn->query("SELECT * FROM paws.users WHERE username = '".$_SESSION["username"]."'");
  $user_row = $user_query->fetch();

  $details_query = $conn->prepare("INSERT INTO paws.order_details (user_id, total) VALUES (".$user_row["id"].", ".$_GET["total"].")");

  if ($details_query->execute()) {
    $details_id = $conn->lastInsertId();
    
    $cart_query = $conn->query("SELECT * FROM paws.cart WHERE user_id = ".$user_row["id"]);
    while ($cart_row = $cart_query->fetch()) {
      $items_query = $conn->prepare("INSERT INTO paws.order_items (order_id, item_id, quantity) VALUES (".$details_id.", ".$cart_row["item_id"].", ".$cart_row["quantity"].")");      
      if ($items_query->execute()) {
        $conn->query("DELETE FROM paws.cart WHERE user_id = ".$cart_row["user_id"]."AND item_id = ".$cart_row["item_id"]);
      } else {
        $_SESSION["message"] = "Error processing order!";
        header("Location: index.php?page=profile");
        die();
      }
    }

    $_SESSION["message"] = "Order created successfully!";
    header("Location: index.php?page=profile");
    die();
  } else {
    $_SESSION["message"] = "Error creating order!";
    header("Location: index.php?page=profile");
    die();
  }

?>