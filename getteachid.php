
<?php require_once('./session.php');
require_once('./functions.php');
require_once('./db_connection.php'); ?>

<?php $query = "SELECT max(faculty.id)as id from faculty natural left outer join department where department.dept_type='teaching' and dept_name='{$_GET['dept']}' ORDER BY id; ";
$res = mysqli_query($connection, $query);
$dept = $_GET['dept'];
if ($dept == 'AppSci') {
    while ($row = mysqli_fetch_assoc($res)) {
        $arr = explode('-', $row['id']);
        $max_id = $arr[1];
    }
    $max_id++;
    $query2 = "SELECT faculty.id as id from faculty natural join department where dept_type='teaching' and dept_name='{$_GET['dept']}' ORDER BY faculty.id; ";
    $res = mysqli_query($connection, $query2);
    $count = 1;
    while ($row = mysqli_fetch_assoc($res)) {
        if ((explode('-', $row['id'])[1]) == $count) {
            $count++;
        } else {
            $max_id = $count;
            break;
        }
    }
    if ($max_id < 10) {
        $id = "AS-0{$max_id}";
    } else {
        $id = "AS-{$max_id}";
    }
    echo $id;
} else if ($dept == 'CSE') {
    while ($row = mysqli_fetch_assoc($res)) {
        $arr = explode('-', $row['id']);
        $max_id = $arr[1];
    }
    $max_id++;
    $query2 = "SELECT faculty.id as id from faculty natural join department where dept_type='teaching' and dept_name='{$_GET['dept']}' ORDER BY faculty.id; ";
    $res = mysqli_query($connection, $query2);
    $count = 1;
    while ($row = mysqli_fetch_assoc($res)) {
        if ((explode('-', $row['id'])[1]) == $count) {
            $count++;
        } else {
            $max_id = $count;
            break;
        }
    }
    if ($max_id < 10) {
        $id = "CSE-0{$max_id}";
    } else {
        $id = "CSE-{$max_id}";
    }
    echo $id;
} else if ($dept == 'ME') {
    while ($row = mysqli_fetch_assoc($res)) {
        $arr = explode('-', $row['id']);
        $max_id = $arr[1];
    }
    $max_id++;
    $query2 = "SELECT faculty.id as id from faculty natural join department where dept_type='teaching' and dept_name='{$_GET['dept']}' ORDER BY faculty.id; ";
    $res = mysqli_query($connection, $query2);
    $count = 1;
    while ($row = mysqli_fetch_assoc($res)) {
        if ((explode('-', $row['id'])[1]) == $count) {
            $count++;
        } else {
            $max_id = $count;
            break;
        }
    }
    if ($max_id < 10) {
        $id = "MECH-0{$max_id}";
    } else {
        $id = "MECH-{$max_id}";
    }
    echo $id;
} else if ($dept == 'CE') {
    while ($row = mysqli_fetch_assoc($res)) {
        $arr = explode('-', $row['id']);
        $max_id = $arr[1];
    }
    $max_id++;
    $query2 = "SELECT faculty.id as id from faculty natural join department where dept_type='teaching' and dept_name='{$_GET['dept']}' ORDER BY faculty.id; ";
    $res = mysqli_query($connection, $query2);
    $count = 1;
    while ($row = mysqli_fetch_assoc($res)) {
        if ((explode('-', $row['id'])[1]) == $count) {
            $count++;
        } else {
            $max_id = $count;
            break;
        }
    }
    if ($max_id < 10) {
        $id = "CIV-0{$max_id}";
    } else {
        $id = "CIV-{$max_id}";
    }
    echo $id;
} else if ($dept == 'ECE') {
    while ($row = mysqli_fetch_assoc($res)) {
        $arr = explode('-', $row['id']);
        $max_id = $arr[1];
    }
    $max_id++;
    $query2 = "SELECT faculty.id as id from faculty natural join department where dept_type='teaching' and dept_name='{$_GET['dept']}' ORDER BY faculty.id; ";
    $res = mysqli_query($connection, $query2);
    $count = 1;
    while ($row = mysqli_fetch_assoc($res)) {
        if ((explode('-', $row['id'])[1]) == $count) {
            $count++;
        } else {
            $max_id = $count;
            break;
        }
    }
    if ($max_id < 10) {
        $id = "ECE-0{$max_id}";
    } else {
        $id = "ECE-{$max_id}";
    }
    echo $id;
}

?>