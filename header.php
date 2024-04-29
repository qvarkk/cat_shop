<?php 

  session_start();

  $active = "inactive";
  $msg = "";

  if (isset($_SESSION["message"])) {
    $msg = $_SESSION["message"];
    $active = "";
    unset($_SESSION["message"]);
  }

?>

<script src="js/header.js"></script>

<header class="header">
  <a href="index.php"><h1>CAT SHOP</h1></a>
  <nav class="header-nav">
    <a href="index.php?page=login"><img src="img/profile.svg" alt="Profile" class="profile"></a>
    <img src="img/cart.svg" alt="Cart" class="cart">
  </nav>

  <div id="msg" class="message-modulo <? echo $active ?>">
    <p class="message-text"><? echo $msg ?></p>
  </div>
</header>