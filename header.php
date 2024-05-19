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
    <h2><? if (isset($_SESSION["username"])) { echo($_SESSION["username"]); } else { echo("Login"); } ?></h2>
    <a href="index.php?page=<? if (isset($_SESSION["username"])) { echo("profile"); } else { echo("login"); } ?>"><img src="img/profile.svg" alt="Profile" class="profile"></a>
  </nav>

  <div id="msg" class="message-modulo <? echo $active ?>">
    <p class="message-text"><? echo $msg ?></p>
  </div>
</header>