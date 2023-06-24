<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Items assigned</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <style>
    table {
      border-collapse: collapse;
      width: 90%;
      margin: auto auto;
    }


    table {
      font-family: Arial, Verdana, sans-serif;
      border-spacing: 1px;
      margin: auto auto;
      width: 100%;
    }

    th,
    td {
      padding: 5px 30px 5px 10px;
      border-spacing: 0px;
      font-size: 1vw;
      margin: 0px;
    }

    th,
    td {
      text-align: left;
      border-top: 1px solid #f1f8fe;
      border-bottom: 1px solid #cbd2d8;
      border-right: 1px solid #cbd2d8;
    }

    tr th {
      color: #fff;
      background-color: #90b4d6;
      border-bottom: 2px solid #547ca0;
      border-right: 1px solid #749abe;
      border-top: 1px solid #90b4d6;
      text-align: center;
      text-shadow: -1px -1px 1px #666;
      letter-spacing: 0.15em;
    }

    tr {
      background-color: #e0e9f0;
    }

    td {
      text-shadow: 1px 1px 1px #fff;
    }

    body {
      background: #f6f6f6;
    }

    .card {
      box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.5);
      border-radius: 18px;
    }

    .card-body {
      margin: 1% 5%;
    }

    hr {
      margin: 8px 0px;
    }
  </style>
</head>

<body>
  <?php include('./header.php'); ?>

  <?php require_once('../db_connection.php'); ?>
  <div class="card w-75" style="margin: 3% auto;">
    <div class="card-body">
      <p class="card-text">

        <?php
        if (!empty($_GET['radio'])) {
          $query = "SELECT name FROM faculty WHERE id='{$_GET['radio']}'; ";
          $res = mysqli_query($connection, $query);
          while ($name = mysqli_fetch_assoc($res)) {
            foreach ($name as $key => $value) {
              echo "<b>ID:</b> {$_GET['radio']}<br/><b>Name:</b> $value<br/>";
            }
          }
        } else {
          echo 'Please Go back and select a radiobutton.';
          die();
        }
        $id = $_GET['radio'];
        $query = "SELECT * ";
        $query .= "FROM no_items_assigned ";
        $query .= "WHERE id='{$id}';";
        $number_items = mysqli_query($connection, $query);
        $num_arr = mysqli_fetch_assoc($number_items);
        $q2 = "SELECT DISTINCT item_type from computational_items";
        $s2 = mysqli_query($connection, $q2);
        $out = "<pre>";
        while ($sec_row = mysqli_fetch_assoc($s2)) {
          $item_type = $sec_row['item_type'];
          $out .= "<em><b>Number of {$item_type}:</b> {$num_arr[$item_type]}</em>\t";
        }
        $out .= "</pre>";
        echo $out;
        echo "<table>
                <tr>
                <th><b>Item type</b></th>
                <th><b>Model</b></th>
                <th><b>Price</b></th>
                <th><b>Issue Date</b></th>
                <th><b>Quantity</b></th></tr>";
        $q2 = "SELECT DISTINCT item_type from computational_items";
        $s2 = mysqli_query($connection, $q2);
        while ($row = mysqli_fetch_assoc($s2)) {
          $item_type = $row['item_type'];
          if ($num_arr[$item_type] != 0) {
            $new_str = str_replace('_', ' ', $item_type);
            $cap = strtoupper($new_str);
            $output = "<tr><td rowspan='{$num_arr[$item_type]}'>{$cap}</td>";
            $query = "SELECT {$item_type}_model ";
            $query .= "FROM {$item_type} ";
            $query .= "WHERE id='{$id}'; ";
            $res = mysqli_query($connection, $query);
            while ($item_id = mysqli_fetch_assoc($res)) {
              foreach ($item_id as $key => $value) {
                $query = "SELECT Model,rate,date_of_purchase ";
                $query .= "FROM computational_items ";
                $query .= "WHERE id='{$value}'; ";
                $item = mysqli_query($connection, $query);
                while ($_arr = mysqli_fetch_assoc($item)) {
                  if ($output) {
                  } else {
                    $output = "<tr>";
                  }
                  foreach ($_arr as $key => $value) {
                    if ($key == "rate") {
                      $output .= "<td>₹{$value}</td>";
                    } else $output .= "<td>{$value}</td>";
                  }
                  $mod=$item_type."_model";
                  $query = "SELECT quantity ";
                  $query .= "FROM {$item_type} ";
                  $query .= "WHERE id='{$id}' and {$item_type}_model='{$item_id[$mod]}'; ";
                  $res2=mysqli_query($connection,$query);
                  while($rr=mysqli_fetch_assoc($res2)){
                    $output .= "<td>{$rr['quantity']}</td>";
                  }
                  $output.="</tr>";
                  
                  echo $output;
                  $output = '';
                }
              }
            }
          }
        }
        echo "</table>";

        ?>
      </p>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>