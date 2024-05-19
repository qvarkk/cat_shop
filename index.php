<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paw Store</title>
  <?php require "linker.php" ?>
</head>
<body>
  <?php require "header.php" ?>

  <main class="main">
    <div class="container">
      <?php
        if (isset($_GET["page"])) {
          switch ($_GET["page"]) {
            case "start":
              require "start.php";
              break;
            case "register":
              require "register.php";
              break;
            case "login":
              require "login.php";
              break;
            case "profile":
              require "profile.php";
              break;
          }
        } else {
          require "start.php";
        }
      ?>
    </div>
  </main>

  <?php require "footer.php" ?>
</body>
</html>