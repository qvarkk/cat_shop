<?php

  session_start();

  require("dbconn.php");

  if (isset($_SESSION["username"]) && isset($_GET["item"])) {
    $user_query = $conn->query("SELECT * FROM paws.users WHERE username = '".$_SESSION["username"]."'");
    $user_row = $user_query->fetch();

    $cart_query = $conn->query("SELECT * FROM paws.cart WHERE user_id = ".$user_row["id"]." AND item_id = ".$_GET["item"]);
    $cart_row = $cart_query->fetch();
    if ($cart_row) {
      $query = $conn->prepare("UPDATE paws.cart SET quantity = ".($cart_row["quantity"] + 1)." WHERE user_id = ".$user_row["id"]." AND item_id = ".$_GET["item"]);
    } else {
      $query = $conn->prepare("INSERT INTO paws.cart (user_id, item_id, quantity) VALUES (".$user_row["id"].", ".$_GET["item"].", ".'1'.")");
    }
    if ($query->execute()) {
      $_SESSION["message"] = "Added items to cart!";
    } else {
      $_SESSION["message"] = "Error adding item to cart";
    }
  } else {
    $_SESSION["message"] = "Login first to access cart";
  }
  header("Location: index.php");
  die();

?>