<?php require_once 'db_connection.php';
require_once 'session.php';
require_once 'functions.php'; ?>

<?php if (isset($_POST['addedfaculty']) && $_POST['name'] != NULL) {
  $dept_type = $_POST['dept_type'];
  if ($_POST['dept_type'] == 'teaching') {
    $id = $_POST['idteach'];
    $dept_name = $_POST['dept_name_teach'];
    $designation = $_POST['designation_teach'];
  } else {
    $id = $_POST['idnteach'];
    $dept_name = $_POST['dept_name_nteach'];
    $designation = $_POST['designation_nteach'];
  }
  if ($id != NULL) {
    $name = $_POST['name'];
    $contact_number = $_POST['contact_number'];
    $email_id = $_POST['email_id'];
    $room_number = $_POST['room_number'];
    $resigned = $_POST['resigned'];
    $query = "INSERT INTO `faculty`(`id`, `name`, `contact_number`, `email_id`, `room_number`,`resigned`) VALUES ('{$id}','{$name}','{$contact_number}','{$email_id}','{$room_number}','{$resigned}'); ";
    $res = mysqli_query($connection, $query);
    $flag = 0;
    if ($res) {
      $flag++;
    }
    $query = "INSERT INTO `department`(`id`, `dept_type`, `dept_name`, `designation`) VALUES ('{$id}','{$dept_type}','{$dept_name}','{$designation}'); ";
    $res = mysqli_query($connection, $query);
    if ($res) {
      $flag++;
    }
    $query = "INSERT INTO `no_items_assigned`(`id`) VALUES ('{$id}'); ";
    $res = mysqli_query($connection, $query);
    if ($res) {
      $flag++;
    }
    if ($flag == 3) {
      $_SESSION["successMessage"] = "Faculty Added Successfully!";
      redirect_to("admin.php");
    } else {
      $_SESSION["error"] = "Faculty can't be Added!";
      redirect_to("admin.php");
    }
  }
} ?>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<?php if (isset($_POST['addedlab'])) {
  $lab_no = $_POST['lab_no'];
  $room_no = $_POST['room_no'];
  $q1 = "SELECT lab_no from lab; ";
  $r1 = mysqli_query($connection, $q1);
  while ($rr = mysqli_fetch_assoc($r1)) {
    if ($rr['lab_no'] == $lab_no) {
      $_SESSION["error"] = "Lab already exists!";
      redirect_to('admin.php');
      die();
    }
  }
  $query = "INSERT INTO `lab`(`lab_no`, `room_no`) VALUES ('{$lab_no}','{$room_no}'); ";
  $res = mysqli_query($connection, $query);
  $flag = 0;
  if ($res) {
    $flag++;
  }
  if ($flag == 1) {
    $_SESSION["successMessage"] = "Lab Added Successfully!";
    redirect_to("admin.php");
  } else {
    $_SESSION["error"] = "Lab can't be Added!";
    redirect_to("admin.php");
  }
}
?>
<!----------------------------------------------------------------------------------------------------------------------------------------------------------->
<?php if (isset($_POST['addeditem'])) {
  $id = $_POST['id'];
  $reg_page = $_POST['reg_page_no'];
  $item_type = $_POST['item_type'];
  $model = $_POST['Model'];
  $dop = $_POST['date_of_purchase'];
  $quantity_received = $_POST['quantity_received'];
  $balance_instock = $quantity_received;
  $quantity_issued = 0;
  $rate = $_POST['rate'];
  $amount = $_POST['amount'];
  $writeoff = $_POST['writeoff'];
  $query = "INSERT INTO `computational_items`(`id`, `reg_page_no`, `item_type`, `Model`, `date_of_purchase`, `quantity_received`, `rate`, `amount`,`balance_instock`,`quantity_issued`,`writeoff`) ";
  $query .= "VALUES ('{$id}','{$reg_page}','{$item_type}','{$model}','{$dop}','{$quantity_received}','{$rate}','{$amount}','{$balance_instock}','{$quantity_issued}','{$writeoff}'); ";
  $res = mysqli_query($connection, $query);
  if ($res) {
    $_SESSION["successMessage"] = "Computational Item Added Successfully!";
    redirect_to("admin.php");
  } else {
    $_SESSION["error"] = "Computational Item could't be Added!";
    redirect_to("admin.php");
  }
} ?>
<!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<?php if (isset($_POST['addedadmin']) && $_POST['username'] != NULL && $_POST['password'] != NULL) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $encrypted_password = password_encrypt($password);
  $check = "SELECT username from admins where username='$username'; ";
  $checked = mysqli_query($connection, $check);
  while ($ch = mysqli_fetch_assoc($checked)) {
    $_SESSION["error"] = "Admin({$ch['username']}) with this username already exists!";
    redirect_to("admin.php");
    die();
  }
  $query = "INSERT INTO `admins`( `id`,`username`, `hashed_password`) VALUES ('','{$username}','{$encrypted_password}'); ";
  $res = mysqli_query($connection, $query);
  if ($res) {
    $_SESSION["successMessage"] = "Admin Added Successfully!";
    redirect_to("admin.php");
  } else {
    $_SESSION["error"] = "Admin can't be Added!";
    redirect_to("admin.php");
  }
}
?>
<!-------------------------------------------------------------------------------------------------------------------------------------------------->
<?php if (isset($_POST['removedfaculty'])) {
  $flag = 0;
  $id = $_POST['id'];
  $sq = "SELECT DISTINCT item_type from computational_items";
  $res = mysqli_query($connection, $sq);
  while ($r = mysqli_fetch_assoc($res)) {
    $item_type = $r['item_type'];
    $sq1 = "SELECT {$item_type}_model,quantity FROM {$item_type} WHERE id='{$id}'; ";
    $res1 = mysqli_query($connection, $sq1);
    while ($r1 = mysqli_fetch_assoc($res1)) {
      $sq2 = "update `computational_items` set balance_instock=balance_instock+{$r1['quantity']} where id='{$item_type}_model'; ";
      $res2 = mysqli_query($connection, $sql2);
      $sq3 = "update `computational_items` set quantity_issued=quantity_issued-{$r1['quantity']} where id='{$item_type}_model'; ";
      $res3 = mysqli_query($connection, $sq3);
    }
  }
  $query = "DELETE FROM `faculty` WHERE id='{$id}'; ";
  $res = mysqli_query($connection, $query);
  if ($res) {
    $flag++;
  }
  $query = "DELETE FROM `department` WHERE id='{$id}'; ";
  $res = mysqli_query($connection, $query);
  if ($res) {
    $flag++;
  }
  $query = "DELETE FROM `no_items_assigned` WHERE id='{$id}'; ";
  $res = mysqli_query($connection, $query);
  if ($res) {
    $flag++;
  }
  $sql = "SELECT DISTINCT item_type from computational_items";
  $result = mysqli_query($connection, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $item_type = $row['item_type'];
    $query = "DELETE FROM `{$item_type}` WHERE id='{$id}'; ";
    $res = mysqli_query($connection, $query);
  }
  if ($res) {
    $flag++;
  }

  if ($flag == 4) {
    $_SESSION["successMessage"] = "Faculty Removed Successfully!";
    redirect_to("admin.php");
  } else {
    $_SESSION["error"] = "Faculty couldn't be Removed!";
    redirect_to("admin.php");
  }
}
?>
<!---------------------------------------------------------------------------------------------------------------------------------------------->
<?php if (isset($_POST['removedlab'])) {
  $lab_no = $_POST['lab_no'];
  $sq = "SELECT DISTINCT item_type from computational_items";
  $res = mysqli_query($connection, $sq);
  while ($r = mysqli_fetch_assoc($res)) {
    $item_type = $r['item_type'];
    $sq1 = "SELECT {$item_type}_model,quantity FROM {$item_type} WHERE id='{$lab_no}'; ";
    $res1 = mysqli_query($connection, $sq1);
    while ($r1 = mysqli_fetch_assoc($res1)) {
      $sq2 = "update `computational_items` set balance_instock=balance_instock+{$r1['quantity']} where id='{$item_type}_model'; ";
      $res2 = mysqli_query($connection, $sql2);
      $sq3 = "update `computational_items` set quantity_issued=quantity_issued-{$r1['quantity']} where id='{$item_type}_model'; ";
      $res3 = mysqli_query($connection, $sq3);
    }
  }
  $query = "DELETE FROM `lab` WHERE lab_no='{$lab_no}'; ";
  $res = mysqli_query($connection, $query);
  if ($res) {
    $_SESSION["successMessage"] = "Lab Removed Successfully!";
    redirect_to("admin.php");
  } else {
    $_SESSION["error"] = "Lab can't be Removed!";
    redirect_to("admin.php");
  }
}
?>
<!------------------------------------------------------------------------------------------------------------------------------------------------->
<?php if (isset($_POST['removedadmin']) && attempt_login($_POST['username'], $_POST['password'])) {
  $username = $_POST['username'];
  $q1="SELECT count(id) as count from admins; ";
  $r1=mysqli_query($connection,$q1);
  $rr=mysqli_fetch_assoc($r1);
  if($rr['count']<2){
    $_SESSION["error"]="Only one admin in system, hence can't be removed...";
    redirect_to("admin.php");
    die();
  }
  $query = "DELETE FROM `admins` WHERE username='{$username}'; ";
  $res = mysqli_query($connection, $query);
  if ($res) {
    $_SESSION["successMessage"] = "Admin Removed Successfully!";
    redirect_to("admin.php");
  } else {
    $_SESSION["error"] = "Admin can't be Removed!";
    redirect_to("admin.php");
  }
}
?>
<!-------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
$sq = "SELECT DISTINCT item_type from computational_items";
$res = mysqli_query($connection, $sq);
while ($r = mysqli_fetch_assoc($res)) {
  $item_type = $r['item_type'];
  if (isset($_POST["remove{$item_type}"])) {
    $flag = 0;
    $Model = $_POST["{$item_type}Model"];
    $sql = "select {$item_type}.id, count({$item_type}_model) as no_of_items from {$item_type} where {$item_type}.{$item_type}_model in (select computational_items.id from computational_items where computational_items.Model = '$Model') group by {$item_type}.id;";
    $result = mysqli_query($connection, $sql);
    if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
        $id = $row["id"];
        $no_of_items = $row["no_of_items"];
        $sql1 = "update no_items_assigned set no_items_assigned.{$item_type} = no_items_assigned.{$item_type}-'$no_of_items' where no_items_assigned.id = '$id';";
        $result1 = mysqli_query($connection, $sql1);
        $sql2 = "update lab set lab.{$item_type} = lab.{$item_type} - '$no_of_items' where lab.id = '$id';";
        $result2 = mysqli_query($connection, $sql2);
        $flag++;
      }
    }

    $sql2 = "DELETE FROM `{$item_type}` WHERE {$item_type}.{$item_type}_model in (select computational_items.id from computational_items where computational_items.Model = '$Model')";
    $result2 = mysqli_query($connection, $sql2);
    if ($result2) {
      $flag++;
    }

    $sql3 =  "delete from computational_items where computational_items.Model = '$Model';";
    $result3 = mysqli_query($connection, $sql3);
    if ($result2) {
      $flag++;
    }
    $fcap = ucfirst(str_replace('_', ' ', $item_type));
    if ($flag >= 1) {
      $_SESSION["successMessage"] = "Computational Item ($fcap) Removed Successfully!";
      redirect_to("admin.php");
    } else {
      $_SESSION["error"] = "Computational Item ($fcap) could't be Removed Successfully!";
      redirect_to("admin.php");
    }
  }
}
?>

<!--------------------------------------------------------------------------------------------------------------------------------------------->
<?php if (isset($_POST['allocateditem'])) {
  $flag = 0;
  $id = $_POST['id'];
  $quantity = $_POST['quantity'];
  if($quantity==0){
    $_SESSION["error"] = "No item allocated!";
    redirect_to("admin.php");
  }
  $item_type = $_POST['item_type'];
  $item_model = $_POST["{$item_type}Model"];
  $query = "SELECT id,balance_instock FROM computational_items WHERE Model='{$item_model}'; ";
  $res = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($res)) {
    $item_id = $row['id'];
    if ($row['balance_instock'] >= $quantity) {
      $q1 = "update `computational_items` set balance_instock=balance_instock-{$quantity} where id='{$item_id}'; ";
      $r = mysqli_query($connection, $q1);
      if ($r) {
        $flag++;
      }
      $q2 = "update `computational_items` set quantity_issued=quantity_issued+{$quantity} where id='{$item_id}'; ";
      $r = mysqli_query($connection, $q2);
      if ($r) {
        $flag++;
      }
      $query = "SELECT id from faculty WHERE id='{$id}'; ";
      $res = mysqli_query($connection, $query);
      while ($row = mysqli_fetch_assoc($res)) {
        $fac_id = $row['id'];
      }
      $query1 = "SELECT id,{$item_type}_model from {$item_type} where id='{$id}' and {$item_type}_model='{$item_id}'; ";
      $res1 = mysqli_query($connection, $query1);
      $rr=mysqli_fetch_assoc($res1);
      if ($rr) {
        $query2 = "update `{$item_type}` set quantity=quantity+{$quantity} where id='{$id}' and {$item_type}_model='{$item_id}'; ";
        $res2 = mysqli_query($connection, $query2);
        if ($res2) {
          $flag++;
        }
      } else {
        $query3 = "INSERT INTO `{$item_type}`(`id`, `{$item_type}_model`,`quantity`) VALUES ('{$id}','{$item_id}','{$quantity}'); ";
        $res3 = mysqli_query($connection, $query3);
        if ($res3) {
          $flag++;
        }
        if ($fac_id == $id) {
          $sql1 = "update no_items_assigned set no_items_assigned.{$item_type} = no_items_assigned.{$item_type} + 1 where no_items_assigned.id = '{$id}'; ";
          $res1 = mysqli_query($connection, $sql1);
          if ($res1) {
            $flag++;
          }
        } else {
          $sql2 = "update lab set lab.{$item_type}= lab.{$item_type}+1 where lab.lab_no='{$id}'; ";
          $res2 = mysqli_query($connection, $sql2);
          if ($res2) {
            $flag++;
          }
        }
      }
      break;
    } else {
      $q1 = "update `computational_items` set balance_instock=0 where id='{$item_id}'; ";
      $r = mysqli_query($connection, $q1);
      $q2 = "update `computational_items` set quantity_issued=quantity_issued+{$row['balance_instock']} where id='{$item_id}'; ";
      $r = mysqli_query($connection, $q2);
      $query = "SELECT id from faculty WHERE id='{$id}'; ";
      $res = mysqli_query($connection, $query);
      while ($row = mysqli_fetch_assoc($res)) {
        $fac_id = $row['id'];
      }
      $query1 = "SELECT id,{$item_type}_model from {$item_type} where id='$id' and {$item_type}_model='{$item_id}'; ";
      $res1 = mysqli_query($connection, $query1);
      $rr=mysqli_fetch_assoc($res1);
      if ($rr) {
        $query2 = "update `{$item_type}` set quantity=quantity+{$quantity} where id='$id' and {$item_type}_model='{$item_id}'; ";
        $res2 = mysqli_query($connection, $query2);
        if ($res2) {
          $flag++;
        }
      } else {
        $query3 = "INSERT INTO `{$item_type}`(`id`, `{$item_type}_model`,`quantity`) VALUES ('{$id}','{$item_id}','{$quantity}'); ";
        $res3 = mysqli_query($connection, $query3);
        if ($res3) {
          $flag++;
        }
        if ($fac_id == $id) {
          $sql1 = "update no_items_assigned set no_items_assigned.{$item_type} = no_items_assigned.{$item_type} + 1 where no_items_assigned.id = '{$id}'; ";
          $res1 = mysqli_query($connection, $sql1);
          if ($res1) {
            $flag++;
          }
        } else {
          $sql2 = "update lab set lab.{$item_type}= lab.{$item_type}+1 where lab.lab_no='{$id}'; ";
          $res2 = mysqli_query($connection, $sql2);
          if ($res2) {
            $flag++;
          }
        }
      }
      
    }
    $quantity = $quantity - $row['balance_instock'];
  }

  if (($flag % 4) == 0) {
    $fcap = ucfirst(str_replace('_', ' ', $item_type));
    $_SESSION["successMessage"] = "$fcap Allocated Successfully!";
    redirect_to("admin.php");
  } else {
    $_SESSION["error"] = "$fcap could't be Allocated!";
    redirect_to("admin.php");
  }
} ?>

<!---------------------------------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------ Deallocate item------------------------------------------------------------------- -->
<?php
if (isset($_POST["removeItem"])) {
  $flag = 0;
  $teacherId =  $_SESSION["teacherId"];
  $_SESSION["teacherId"] = NULL;
  $item_type = $_SESSION["item_type"];
  $_SESSION["item_type"] = NULL;
  $item_model = $_POST[$item_type."Model"];
  $quantity = $_POST["quantity"];
  $query = "SELECT id FROM computational_items WHERE Model='{$item_model}'; ";
  $res = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($res)) {
    $item_id = $row['id'];
    $query1 = "SELECT id,{$item_type}_model,quantity from {$item_type} where id='{$teacherId}' and {$item_type}_model='{$item_id}'; ";
    $res1 = mysqli_query($connection, $query1);
    while ($r = mysqli_fetch_assoc($res1)) {
      if ($r['quantity'] == $quantity) {
        $quan = $r['quantity'];
        $q1 = "update `computational_items` set balance_instock=balance_instock+{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q1);
        $q2 = "update `computational_items` set quantity_issued=quantity_issued-{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q2);
        $query2 = "delete from `{$item_type}` where id='{$teacherId}' and {$item_type}_model='{$item_id}'; ";
        $res2 = mysqli_query($connection, $query2);
        if ($res2) {
          $flag++;
        }
        $query = "SELECT id from faculty WHERE id='{$teacherId}'; ";
        $res = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($res)) {
          $fac_id = $row['id'];
        }
        if ($fac_id == $teacherId) {
          $sql1 = "update no_items_assigned set no_items_assigned.{$item_type} = no_items_assigned.{$item_type}-1 where no_items_assigned.id = '{$teacherId}'; ";
          $res1 = mysqli_query($connection, $sql1);
        }
        break;
      } else if ($r['quantity'] > $quantity) {
        $quan = $quantity;
        $q1 = "update `computational_items` set balance_instock=balance_instock+{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q1);
        $q2 = "update `computational_items` set quantity_issued=quantity_issued-{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q2);
        $query3 = "update `{$item_type}` set quantity=quantity-{$quantity} where id='{$teacherId}' and {$item_type}_model='{$item_id}'; ";
        $res3 = mysqli_query($connection, $query3);
        if ($res3) {
          $flag++;
        }
        break;
      } else {
        $quan = $r['quantity'];
        $q1 = "update `computational_items` set balance_instock=balance_instock+{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q1);
        $q2 = "update `computational_items` set quantity_issued=quantity_issued-{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q2);
        $query4 = "delete from `{$item_type}` where id='{$teacherId}' and {$item_type}_model='{$item_id}'; ";
        $res4 = mysqli_query($connection, $query2);
        $query = "SELECT id from faculty WHERE id='{$teacherId}'; ";
        $res = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($res)) {
          $fac_id = $row['id'];
        }
        if ($fac_id == $teacherId) {
          $sql1 = "update no_items_assigned set no_items_assigned.{$item_type} = no_items_assigned.{$item_type} - 1 where no_items_assigned.id = '{$teacherId}'; ";
          $res1 = mysqli_query($connection, $sql1);
        }
        $quantity = $quantity - $r['quantity'];
      }
    }
  }

  if ($flag == 1) {
    $_SESSION["successMessage"] = "{$item_type} Deallocated Successfully!";
    redirect_to("admin.php");
  } else {
    $_SESSION["error"] = "{$item_type} couldn't be Deallocated!";
    redirect_to("admin.php");
  }
}
?>


<?php if (isset($_POST["removeItem_nteach"])) {
  $flag = 0;
  $facultyName =  $_SESSION["facultyName"];
  $departmentName = $_SESSION["departmentName"];
  $designationName = $_SESSION["designationName"];
  $item_type = $_SESSION["item_type"];
  $_SESSION["facultyName"] = NULL;
  $_SESSION["departmentName"] = NULL;
  $_SESSION["designationName"] = NULL;
  $_SESSION["item_type"] = NULL;
  $query = "select faculty.id as id from faculty natural join department where faculty.name='{$facultyName}' and dept_name='{$departmentName}' and designation='{$designationName}'; ";
  $res = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($res)) {
    $id = $row['id'];
  }
  $item_model =  $_POST["{$item_type}Model"];
  $quantity = $_POST['quantity'];
  $query = "SELECT id FROM computational_items WHERE Model='{$item_model}'; ";
  $res = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($res)) {
    $item_id = $row['id'];
    $query1 = "SELECT id,{$item_type}_model,quantity from {$item_type} where id='{$id}' and {$item_type}_model='{$item_id}'; ";
    $res1 = mysqli_query($connection, $query1);
    while ($r = mysqli_fetch_assoc($res1)) {
      if ($r['quantity'] == $quantity) {
        $quan = $r['quantity'];
        $q1 = "update `computational_items` set balance_instock=balance_instock+{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q1);
        $q2 = "update `computational_items` set quantity_issued=quantity_issued-{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q2);
        $query2 = "delete from `{$item_type}` where id='{$id}' and {$item_type}_model='{$item_id}'; ";
        $res2 = mysqli_query($connection, $query2);
        if ($res2) {
          $flag++;
        }
        $query = "SELECT id from faculty WHERE id='{$id}'; ";
        $res = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($res)) {
          $fac_id = $row['id'];
        }
        if ($fac_id == $id) {
          $sql1 = "update no_items_assigned set no_items_assigned.{$item_type} = no_items_assigned.{$item_type} - 1 where no_items_assigned.id = '{$id}'; ";
          $res1 = mysqli_query($connection, $sql1);
        }
        break;
      } else if ($r['quantity'] > $quantity) {
        $quan = $quantity;
        $q1 = "update `computational_items` set balance_instock=balance_instock+{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q1);
        $q2 = "update `computational_items` set quantity_issued=quantity_issued-{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q2);
        $query3 = "update `{$item_type}` set quantity=quantity-{$quantity} where id='{$id}' and {$item_type}_model='{$item_id}'; ";
        $res3 = mysqli_query($connection, $query3);
        if ($res3) {
          $flag++;
        }
        break;
      } else {
        $quan = $r['quantity'];
        $q1 = "update `computational_items` set balance_instock=balance_instock+{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q1);
        $q2 = "update `computational_items` set quantity_issued=quantity_issued-{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q2);
        $query4 = "delete from `{$item_type}` where id='{$id}' and {$item_type}_model='{$item_id}'; ";
        $res4 = mysqli_query($connection, $query2);
        $query = "SELECT id from faculty WHERE id='{$id}'; ";
        $res = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($res)) {
          $fac_id = $row['id'];
        }
        if ($fac_id == $id) {
          $sql1 = "update no_items_assigned set no_items_assigned.{$item_type} = no_items_assigned.{$item_type} - 1 where no_items_assigned.id = '{$id}'; ";
          $res1 = mysqli_query($connection, $sql1);
        }
        $quanity = $quantity - $r['quantity'];
      }
    }
  }

  if ($flag == 1) {
    $_SESSION["successMessage"] = "{$item_type} Deallocated Successfully!";
    redirect_to("admin.php");
  } else {
    $_SESSION["error"] = "{$item_type} couldn't be Deallocated!";
    redirect_to("admin.php");
  }
}
?>

<?php
if (isset($_POST["removeItemlab"])) {
  $flag = 0;
  $lab_no =  $_SESSION["lab_no"];
  $_SESSION["lab_no"] = NULL;
  $item_type = $_SESSION["item_type"];
  $_SESSION["item_type"] = NULL;
  $item_model = $_POST[$item_type . "Model"];
  $quantity = $_POST["quantity"];
  $query = "SELECT id FROM computational_items WHERE Model='{$item_model}'; ";
  $res = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($res)) {
    $item_id = $row['id'];
    $query1 = "SELECT id,{$item_type}_model,quantity from {$item_type} where id='{$lab_no}' and {$item_type}_model='{$item_id}'; ";
    $res1 = mysqli_query($connection, $query1);
    while ($r = mysqli_fetch_assoc($res1)) {
      if ($r['quantity'] == $quantity) {
        $quan = $r['quantity'];
        $q1 = "update `computational_items` set balance_instock=balance_instock+$quan where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q1);
        $q2 = "update `computational_items` set quantity_issued=quantity_issued-$quan where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q2);
        $query2 = "delete from `{$item_type}` where id='{$lab_no}' and {$item_type}_model='{$item_id}'; ";
        $res2 = mysqli_query($connection, $query2);
        if ($res2) {
          $flag++;
        }
        $query = "SELECT lab_no from lab WHERE lab_no='{$lab_no}'; ";
        $res = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($res)) {
          $lab = $row['lab_no'];
        }
        if ($lab == $lab_no) {
          $sql1 = "update lab set lab.{$item_type} = lab.{$item_type} - 1 where lab.lab_no = '{$lab_no}'; ";
          $res1 = mysqli_query($connection, $sql1);
        }
        break;
      } else if ($r['quantity'] > $quantity) {
        $quan = $quantity;
        $q1 = "update `computational_items` set balance_instock=balance_instock+{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q1);
        $q2 = "update `computational_items` set quantity_issued=quantity_issued-{$quan} where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q2);
        $query3 = "update `{$item_type}` set quantity=quantity-{$quantity} where id='{$lab_no}' and {$item_type}_model='{$item_id}'; ";
        $res3 = mysqli_query($connection, $query3);
        if ($res3) {
          $flag++;
        }
        break;
      } else {
        $quan = $r['quantity'];
        $q1 = "update `computational_items` set balance_instock=balance_instock+$quan where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q1);
        $q2 = "update `computational_items` set quantity_issued=quantity_issued-$quan where id='{$item_id}'; ";
        $r = mysqli_query($connection, $q2);
        $query4 = "delete from `{$item_type}` where id='{$lab_no}' and {$item_type}_model='{$item_id}'; ";
        $res4 = mysqli_query($connection, $query2);
        $query = "SELECT lab_no from lab WHERE lab_no='{$lab_no}'; ";
        $res = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($res)) {
          $lab = $row['lab_no'];
        }
        if ($lab == $lab_no) {
          $sql1 = "update lab set lab.{$item_type} = lab.{$item_type} - 1 where lab.lab_no = '{$lab_no}'; ";
          $res1 = mysqli_query($connection, $sql1);
        }
        $quanity = $quantity - $r['quantity'];
      }
    }
  }

  if ($flag == 1) {
    $_SESSION["successMessage"] = "{$item_type} Deallocated Successfully!";
    redirect_to("admin.php");
  } else {
    $_SESSION["error"] = "{$item_type} couldn't be Deallocated!";
    redirect_to("admin.php");
  }
}
?>