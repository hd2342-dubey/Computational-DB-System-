<?php require_once 'db_connection.php';
require_once 'session.php';
require_once 'functions.php';
$sql = "SELECT DISTINCT item_type from computational_items";
$result = mysqli_query($connection, $sql);
while ($row = mysqli_fetch_assoc($result)) {
  $item_type = $row['item_type'];
  if (isset($_POST["submit{$item_type}"])) {
    if (empty($_POST["{$item_type}Model"])) {
      $_SESSION["error"] = "Please select an item.";
      redirect_to("item_types.php");
    } else if (isset($_POST["{$item_type}Model"])) {
      $pm = $_POST["{$item_type}Model"];
      redirect_to("./branches/items.php?link=$pm&item_type={$item_type}");
    }
  }
  // if( (isset($_POST["{$item_type}Model"]) && !isset($_POST["submit{$item_type}"]))) {
  //   $_SESSION["error"]="Please select a relevant View Details button.";
  //   redirect_to("item_types.php");
  // }


}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="./item-types-style.css">
  <title>Item Types</title>
</head>

<body>
  <?php include('./header.php'); ?>
  <?php
  echo errorMessage();
  successMessage();
  ?>

  <form class="form" id="myForm" action="item_types.php" method="post">
    <div class="main-container">
      <?php
      global $connection;
      $n = 1;
      $sql = "SELECT DISTINCT item_type from computational_items";
      $result = mysqli_query($connection, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        $item_type = $row['item_type'];
        $fcap = ucwords(str_replace('_',' ',$item_type));
        echo "<div class='sub-container text-center'>
                <div class='card' style='border-radius: 18px; background-color:white;'>
                <div class='img'>
                <img class='card-img-top mt-2' src='./images/{$item_type}.png' alt='Card image cap'>
                </div>
                <div class='card-body'>
                <h5 class='card-title mt-2'>{$fcap}</h5>
                <p class='card-text'>Select a {$fcap} type from the dropdown to view its details.</p>
                <select class='form-control' id='selectBox{$n}' name='{$item_type}Model'>
                <option value='0' selected disabled hidden>Select {$item_type}</option>";
        $n++;



        $sql2 = "select DISTINCT Model from computational_items where item_type='{$item_type}' and Model is not null;";
        $r = mysqli_query($connection, $sql2);
        while ($re = mysqli_fetch_assoc($r)) {
          $categoryName = $re["Model"];
          echo "<option>$categoryName</option>";
        }
        echo "</select><input type='submit' name='submit{$item_type}' value='View Details' class='btn  btn-primary btn-outline-light mt-3' style='width:100%' />
</div>
</div>
</div>";
      } ?>

    </div>
  </form>

  <script>
    n = <?php echo $n; ?>
    i = $n
    j = $n
    while (i--) {
      sel = 'selectBox'.$n;
      document.getElementById(sel).addEventListener("click", function() {
        j = $n
        while (j--) {
          if (j == i) continue;
          sell = 'selectBox'.$j;
          document.getElementById(sell).selectedIndex = 0;
        }

      });
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>