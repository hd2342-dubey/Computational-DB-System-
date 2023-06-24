<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CSE Faculty</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="./branch-style.css">
</head>

<body>
    <?php include('./header.php'); ?>
    <?php require_once('../db_connection.php');
    require_once('../functions.php') ?>
    <?php
    $query = "SELECT lab_no,room_no ";
    $query .= "FROM lab ";
    $list = mysqli_query($connection, $query); ?>
    <form class=method='get' action='./lablist.php' style='width:50%; margin:auto auto;'>
        <input type="Submit" name="View Items" value="View items" /><br />
        <table id="tableId">
            <tr class="thead">
                <th></th>
                <th>Lab Number</th>
                <th>Room Number</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($list)) {
                $output = "<tr id='row_{$row['lab_no']}' onclick='hover_click(this.id)'><label for='{$row['lab_no']}'><td><input name='radio'  id='{$row['lab_no']}' type='radio' value='{$row['lab_no']}'/></td>";
                foreach ($row as $x => $x_value) {
                    $output .= "<td>";
                    $output .= $x_value;
                    $output .= "</td>";
                }
                $output .= "</label></tr>";
                echo $output;
            }
            ?>
        </table>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>
        function hover_click(id) {
            var radio = document.getElementById(id.split("_")[1]).checked = true;
        }
    </script>

</body>

</html>