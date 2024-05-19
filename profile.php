<?php

  if (!isset($_SESSION["username"]) || !isset($_SESSION["profile_image"])) {
    $_SESSION["message"] = "Login first to access profile!";
    header("Location: index.php?page=login");
    die();
  }

  require("./dbconn.php");

  $user_query = $conn->query("SELECT * FROM paws.users WHERE username = '".$_SESSION["username"]."'");
  $user_row = $user_query->fetch();

  if (isset($_GET["remove"])) {
    if ($_GET["remove"] == "all") {
      $conn->query("DELETE FROM paws.cart WHERE user_id = ".$user_row["id"]);
      $_SESSION["message"] = "All items removed";
      header("Location: index.php?page=profile");
      die();
    }

    $query = $conn->prepare("DELETE FROM paws.cart WHERE user_id = ".$user_row["id"]." AND item_id = ".$_GET["remove"]);
    if ($query->execute()) {
      $_SESSION["message"] = "Item successfully removed";
    } else {
      $_SESSION["message"] = "Error couldn't remove item";
    }
    header("Location: index.php?page=profile");
    die();
  }
?>

<link rel="stylesheet" href="styles/profile.css">

<div class="profile">
  <img class="profile-image" src="<? echo($_SESSION["profile_image"]); ?>" alt="Profile Image">
  <h2><? echo($_SESSION["username"]); ?></h2>
  <div class="profile-info">
    <div class="orders">
      <h3>Orders</h3>
      <?php

        $orders_query = $conn->query("SELECT * FROM paws.order_details WHERE user_id = ".$user_row["id"]);
        while ($orders_row = $orders_query->fetch()) {
          echo('<div class="order"><p class="order-number">Order №'.$orders_row["id"].'</p>');
          echo('<div class="order-item">
                  <p>Name</p>
                  <p>Quantity</p>
                  <p>Price</p>
                </div>');
          $order_items_query = $conn->query("SELECT * FROM paws.order_items WHERE order_id = ".$orders_row["id"]);
          while ($order_items_row = $order_items_query->fetch()) {
            $item_query = $conn->query("SELECT * FROM paws.items WHERE id = ".$order_items_row["item_id"]);
            $item_row = $item_query->fetch();
            echo('
              <div class="order-item">
                <p>'.$item_row["name"].'</p>
                <p>'.$order_items_row["quantity"].'</p>
                <p>$'.((float)substr($item_row["price"], 1, 999) * (int)$order_items_row["quantity"]).'</p>
              </div>
            ');
          }
          echo('<p>Total: '.$orders_row["total"].'</p></div></br>');
        }

      ?>
    </div>
    <div class="cart-items">
      <h3>Cart</h3>
      <div class="cart-item">
        <p>Name</p>
        <p>Quantity</p>
        <a href="index.php?page=profile&remove=all">Remove All</a>
      </div>
      <?php
        $cart_query = $conn->query("SELECT * FROM paws.cart WHERE user_id = ".$user_row["id"]);
        $total = 0;
        while ($cart_row = $cart_query->fetch()) {
          $item_query = $conn->query("SELECT * FROM paws.items WHERE id = ".$cart_row["item_id"]);
          $item_row = $item_query->fetch();
          $total += ((float)substr($item_row["price"], 1, 999) * (int)$cart_row["quantity"]);
          echo('
            <div class="cart-item">
              <p>'.$item_row["name"].'</p>
              <p>'.$cart_row["quantity"].'</p>
              <a href="index.php?page=profile&remove='.$cart_row["item_id"].'">Remove</a>
            </div>
          ');
        }
      ?>
      <h2>Total: $<? echo($total) ?></h2>
      <a class="order-anchor" href="order.php?total=<? echo($total) ?>">Order</a>
    </div>
  </div>
  <a class="logout-anchor" href="index.php?page=login&action=logout">Logout</a>
</div>