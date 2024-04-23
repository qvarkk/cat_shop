<link rel="stylesheet" href="styles/start.css">

<div class="start">
  <div class="items">
    <div class="item">
      <?
      if (isset($_COOKIE["profile_image"]))
        echo('<img class="profile-image" src="'.$_COOKIE["profile_image"].'">');
      else
        echo("<p>Cat Shop!</p>");
      ?>
    </div>
    <div class="item">
      <?
      if (isset($_SESSION["username"]))
        echo("<p>Welcome back, ".$_SESSION["username"]."</p>");
      else
        echo("<p>Cutest cat on Earth for cheap</p>");
      ?>
    </div>
    <div class="item">
      <?
      if (isset($_SESSION["message"]))
        echo("<p>".$_SESSION["message"]."</p>");
      else
        echo("<p>Meow meow meow</p>");
      ?>
    </div>
  </div>
</div>