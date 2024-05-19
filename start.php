<link rel="stylesheet" href="styles/start.css">

<div class="start">
  <div class="items">
    <?php 
    
    require("./dbconn.php");

    $query = $conn->query("SELECT * FROM paws.items;");

    while ($row = $query->fetch()) {
      echo('
        <div class="item">
          <div class="image-container"><img class="item-image" src="img/'.$row["image"].'"></div>
          <h2>'.$row["name"].'</h2>
          '.$row["description"].'
          <p>Price: '.$row["price"].'</p>
          <a class="item-anchor" href="cart.php?item='.$row["id"].'">Add to Cart</a>
        </div>
      ');
    }

    ?>
  </div>
</div>