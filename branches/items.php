<?php require_once('../db_connection.php') ?>
<?php

$Model =  $_GET["link"];
$item_type = $_GET['item_type'];
$cap = ucfirst($item_type);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="./branch-style.css">
  <title><?php echo $item_type; ?> Details</title>
</head>

<body>
  <?php include('./header.php'); ?>
  <?php
  global $connection;
  $sql = "select quantity_received, rate, date_of_purchase,reg_page_no,balance_instock,writeoff from computational_items where Model = '$Model';";
  $result = mysqli_query($connection, $sql);
  if ($result) {

    echo "<div class='container text-center' style='margin:auto auto; margin-top:1%; font-size: 4vh; font-weight:600; color:#055C9D;'> {$cap} Model : $Model</div>";

    while ($row = mysqli_fetch_assoc($result)) {
      $no_of_items = $row["quantity_received"];
      $laptop_price = $row["rate"];
      $issue_date = $row["date_of_purchase"];
      $reg_page_no = $row["reg_page_no"];
      $bal_instock = $row["balance_instock"];
      $write_off=$row["writeoff"];

      echo "<div style='display:flex; margin:auto auto; padding:6px; font-weight:600; color:#055C9D; margin-top:1%;'>";
      echo "<div style='margin:auto auto;'>Register page no. : $reg_page_no</div>";
      echo "<div style='margin:auto auto;'>Quantity Received : $no_of_items</div>";
      echo "<div style='margin:auto auto;'>Issue Date : $issue_date </div>";
      echo "<div style='margin:auto auto;'>Balance : $bal_instock</div>";
      echo "<div style='margin:auto auto;'>Price : $laptop_price</div>";
      echo "<div style='margin:auto auto;'>Write Off : $write_off</div>";
      echo "</div>";
    }
  }
  ?>
  <div class="container">
    <table id="tableId" style="margin-top:2%;  margin-bottom:3%;">
      <tr class="thead">
        <th>#</th>
        <th>ID</th>
        <th>Name</th>
        <th>Department</th>
        <th>Designation</th>
        <th>Quantity</th>
      </tr>
      <tbody>
        <?php

        global $connection;
        $sql = "select DISTINCT faculty.id,faculty.name,department.dept_name,department.designation, count(DISTINCT {$item_type}.id) as quantity from computational_items,{$item_type}, faculty, department where {$item_type}.id = faculty.id and faculty.id = department.id and department.id = {$item_type}.id and department.dept_type='teaching' and {$item_type}.{$item_type}_model in (select computational_items.id from computational_items where Model = '$Model') GROUP BY faculty.id;";
        $query = mysqli_query($connection, $sql);
        $s = 0;
        if ($query) {
          while ($row = mysqli_fetch_assoc($query)) {
            $id = $row["id"];
            $dept_name = $row["dept_name"];
            $designation = $row["designation"];
            $name = $row["name"];
            $quantity = $row["quantity"];
            $s++;
        ?>
            <tr>
              <td> <?php echo $s ?></td>
              <td> <?php echo $id ?></td>
              <td> <?php echo $name ?></td>
              <td> <?php echo $dept_name ?></td>
              <td> <?php echo $designation ?></td>
              <td> <?php echo $quantity ?></td>
            </tr>
          <?php }
        }
        $sql = "select DISTINCT faculty.id,faculty.name,department.dept_name,department.designation, count(DISTINCT {$item_type}.id) as quantity from computational_items, {$item_type}, faculty, department where {$item_type}.id = faculty.id and faculty.id = department.id and department.id = {$item_type}.id and department.dept_type='nonteaching' and {$item_type}.{$item_type}_model in (select computational_items.id from computational_items where Model = '$Model') GROUP BY faculty.id;";
        $query = mysqli_query($connection, $sql);

        if ($query) {
          while ($row = mysqli_fetch_assoc($query)) {
            $id = $row["id"];
            $dept_name = $row["dept_name"];
            $designation = $row["designation"];
            $name = $row["name"];
            $quantity = $row["quantity"];
            $s++;
          ?>
            <tr>
              <td> <?php echo $s ?></td>
              <td> <?php echo $id ?></td>
              <td> <?php echo $name ?></td>
              <td> <?php echo $dept_name ?></td>
              <td> <?php echo $designation ?></td>
              <td> <?php echo $quantity ?></td>
            </tr>

        <?php  }
        }

        ?>
      </tbody>

    </table>

  </div>
  <div class="container">
    <table id="tableId" style="margin-top:2%; margin-bottom:3%;">
      <tr class="thead">
        <th>#</th>
        <th>Lab Number</th>
        <th>Room Number</th>
        <th>Quantity</th>
      </tr>

      <tbody>
        <?php
        $s = 0;
        global $connection;

        $sql = "select DISTINCT lab.lab_no,lab.room_no,{$item_type}.quantity from lab,{$item_type} where lab.lab_no={$item_type}.id and {$item_type}.{$item_type}_model in (select computational_items.id from computational_items where Model = '$Model') GROUP BY lab.room_no;";
        $query = mysqli_query($connection, $sql);

        if ($query) {
          while ($row = mysqli_fetch_assoc($query)) {
            $lab_no = $row["lab_no"];
            $room_no = $row["room_no"];
            $quantity = $row["quantity"];
            $s++;
        ?>
            <tr>
              <td> <?php echo $s ?></td>
              <td> <?php echo $lab_no ?></td>
              <td> <?php echo $room_no ?></td>
              <td> <?php echo $quantity ?></td>
            </tr>

        <?php  }
        }
        ?>
      </tbody>

    </table>

  </div>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>