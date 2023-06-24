<?php require_once('./session.php');
require_once('./functions.php');
require_once('./db_connection.php'); ?>
<?php if (isset($_POST['logout'])) {
  session_destroy();
  redirect_to('./index.php');
} ?>
<?php confirm_logged_in() ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
  </script>
</head>

<body>
  <style>
    .navbar-custom {
      background-color: #1866a2;
    }

    .btn {
      height: 4.9vh;
      font-size: 1.20vw;
      text-align: center;
    }

    .btn:hover {
      color: #1866a2;
    }

    input,
    select {
      font-size: 100%;
      color: #5a5854;
      background-color: #f2f2f2;
      border: 1px solid #bdbdbd;
      border-radius: 5px;
      padding: 2px 2px 2px 10px;
      background-repeat: no-repeat;
      background-position: 8px 9px;
      display: block;
    }

    input:focus {
      background-color: #ffffff;
      border: 1px solid #b1e1e4;
    }

    input[type="submit"]:not(.btn) {
      color: #444444;
      width: 100%;
      text-shadow: 0px 1px 1px #ffffff;
      margin-top: 5%;
      background-color: #b9e4e3;
      background: -webkit-gradient(linear, left top, left bottom, from(#beeae9), to(#a8cfce));
      background:
        -moz-linear-gradient(top, #beeae9, #a8cfce);
      background:
        -o-linear-gradient(top, #beeae9, #a8cfce);
      background:
        -ms-linear-gradient(top, #beeae9, #a8cfce);
    }

    input[type="submit"]:not(.btn):hover {
      color: #333333;
      border: 1px solid #a4a4a4;
      border-top: 2px solid #b2b2b2;
      background-color: #a0dbc4;
      background: -webkit-gradient(linear, left top, left bottom, from(#a8cfce), to(#beeae9));
      background:
        -moz-linear-gradient(top, #a8cfce, #beeae9);
      background:
        -o-linear-gradient(top, #a8cfce, #beeae9);
      background:
        -ms-linear-gradient(top, #a8cfce, #beeae9);
    }
  </style>
  <?php include("./header.php"); ?>
  <div style="display:flex; flex-direction:col;">
    <div style="height: 100%; width:20%; float:left; top: 0; z-index: 1; left: 0; padding-top:0.5%; overflow-x:auto; overflow-y: auto;">
      <form class="nav flex-column" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method='get'>
        <input class="btn btn-primary btn-outline-light mb-2" type="submit" name="addfaculty" value="Add new faculty" style='height:7vh;'>
        <input class="btn btn-primary btn-outline-light mb-2" type="submit" name="removefaculty" value="Remove faculty" style='height:7vh;'>
        <input class="btn btn-primary btn-outline-light mb-2" type="submit" name="addlab" value="Add new lab" style='height:7vh;'>
        <input class="btn btn-primary btn-outline-light mb-2" type="submit" name="removelab" value="Remove lab" style='height:7vh;'>
        <input class="btn btn-primary btn-outline-light mb-2" type="submit" name="additem" value="Add new Computational item" style='height:7vh;'>
        <input class="btn btn-primary btn-outline-light mb-2" type="submit" name="removeitem" value="Remove item" style='height:7vh;'>
        <input class="btn btn-primary btn-outline-light mb-2" type="submit" name="addadmin" value="Add new admin" style='height:7vh;'>
        <input class="btn btn-primary btn-outline-light mb-2" type="submit" name="removeadmin" value="Remove admin" style='height:7vh;'>
        <input class="btn btn-primary btn-outline-light mb-2" type="submit" name="allocateitem" value="Allocate computational items" style='height:7vh;'>
        <input class="btn btn-primary btn-outline-light mb-2" type="submit" name="deallocateitem" value="Deallocate computational items" style='height:7vh;'>
      </form>
    </div>
    <?php
    echo successMessage();
    echo errorMessage();
    ?>
    <div class='form' style="display:flex; overflow-x:auto; width:80%; justify-content:center; margin:2% auto;">
      <!-- -------------------------------------------------------------------------------------------------------------------------------------------------------->
      <?php if (isset($_GET['addfaculty'])) { ?>

        <style>
          .hide {
            display: none;
          }

          .show {
            display: block;
          }

          .form-select-sm {
            width: 100%;
          }
        </style>
        <form method='post' action="db_ops.php">
          <span>Department type:
            <div class="form-check">
              <label class="form-check-label" for='afacteach'>Teaching </label><input type='radio' class="form-check-input" id='afacteach' name='dept_type' value='teaching' onclick='onLoad();' required><br>
              <label class="form-check-label" for='afacnteach'>Non Teaching </label><input type='radio' class="form-check-input" id='afacnteach' name='dept_type' value='nonteaching' onclick='onLoad2();'>
            </div>
          </span>
          <div class='hide' id='teaching'><label for='dept_name_teach'>Department:</label>
            <select class='form-select-sm' onclick="showteachid(this.value)" id='afacdept' name='dept_name_teach'>
              <option value="" selected disabled hidden>Select Department</option>
              <option value='CSE'>CSE</option>
              <option value='ECE'>ECE</option>
              <option value='ME'>ME</option>
              <option value='CE'>CE</option>
              <option value='AppSci'>AppSci</option>
            </select>
          </div>
          <div id='nonteaching' class='hide'><label for='dept_name_nteach'>Department:</label><input id='afacndept' type='text' name='dept_name_nteach'></div>

          <div class='hide' id='afacid1'><label for='idteach'>ID:</label><input type='text' id='afacid1inp' name='idteach' value="" /></div>
          <div class='hide' id='afacid2'><label for='idnteach'>ID:</label><input type='text' id='afacid2inp' name='idnteach' value="<?php $query = 'SELECT max(faculty.id+0) as max_id from faculty natural join department where department.dept_type=\'nonteaching\'; ';
                                                                                                                                    $res = mysqli_query($connection, $query);
                                                                                                                                    while ($row = mysqli_fetch_assoc($res)) {
                                                                                                                                      $max_id = $row['max_id'];
                                                                                                                                    }
                                                                                                                                    $max_id++;
                                                                                                                                    $query2 = 'SELECT faculty.id from faculty natural join department where department.dept_type=\'nonteaching\' ORDER BY faculty.id+0 ASC; ';
                                                                                                                                    $res = mysqli_query($connection, $query2);
                                                                                                                                    $count = 1;
                                                                                                                                    while ($row = mysqli_fetch_assoc($res)) {
                                                                                                                                      if ($row['id'] == $count) {
                                                                                                                                        $count++;
                                                                                                                                      } else {
                                                                                                                                        $max_id = $count;
                                                                                                                                        break;
                                                                                                                                      }
                                                                                                                                    }
                                                                                                                                    echo $max_id; ?>" readonly /></div>

          <div><label for='afacname'>Name:</label>
            <input type='text' name='name' id='afacname' required />
          </div>
          <div><label for='afaccn'>Contact Number:</label>
            <input type='text' name='contact_number' id='afaccn' />
          </div>
          <div><label for='afacmail'>Email-id:</label>
            <input type='text' name='email_id' id='afacmail' />
          </div>
          <div id='rn' class='hide'><label for='afacrn'>Room Number:</label>
            <input type='text' name='room_number' id='afacrn' />
          </div>
          <div class='hide' id='afacdesteach'><label for='afacdes'>Designation:</label>
            <select class='form-select-sm' name='designation_teach'>
              <option value="" selected disabled hidden>Select Designation</option>
              <option value='Professor and HOD'>Professor and HOD</option>
              <option value='Professor'>Professor</option>
              <option value='Assistant Professor'>Assistant Professor</option>
              <option value='Principal'>Principal</option>
            </select>
          </div>
          <div class='hide' id='afacdesnteach'><label for='afacdes'>Designation:</label>
            <input type='text' name='designation_nteach' />
          </div>
          <div><label for='resigned'>Resigned:</label><select class='form-select-sm' name='resigned'>
              <option value="" selected disabled hidden>Select TRUE if resigned</option>
              <option value=1>TRUE</option>
              <option value=0>FALSE</option>
            </select></div>
          <input type='submit' name='addedfaculty' value='Add Faculty' />
        </form>
        <script>
          function onLoad() {
            //method for button times
            var teaching_dept = document.getElementById('teaching');
            teaching_dept.classList.remove('hide');
            teaching_dept.classList.add('show');
            var dept_teach = document.getElementsByName('dept_name_teach')[0];
            dept_teach.setAttribute("required", "");
            var room_no = document.getElementById('rn');
            room_no.classList.remove('hide');
            room_no.classList.add('show');
            var id_teach = document.getElementById('afacid1');
            id_teach.classList.remove('hide');
            id_teach.classList.add('show');
            var id_inp_teach = document.getElementById('afacid1inp');
            id_inp_teach.readOnly = true;
            var desig_teach = document.getElementById('afacdesteach');
            desig_teach.classList.remove('hide');
            desig_teach.classList.add('show');
            var designation_teach = document.getElementsByName('designation_teach')[0];
            designation_teach.setAttribute("required", "");

            var nonteach_dept = document.getElementById('nonteaching');
            nonteach_dept.classList.remove('show');
            nonteach_dept.classList.add('hide');
            var dept_nteach = document.getElementsByName('dept_name_nteach')[0];
            dept_nteach.removeAttribute("required");
            var afacndept = document.getElementById('afacndept');
            afacndept.removeAttribute("required");
            var id_nteach = document.getElementById('afacid2');
            id_nteach.classList.remove('show');
            id_nteach.classList.add('hide');
            var desig_nteach = document.getElementById('afacdesnteach');
            desig_nteach.classList.remove('show');
            desig_nteach.classList.add('hide');
            var designation_nteach = document.getElementsByName('designation_nteach')[0];
            designation_nteach.removeAttribute("required");
          }

          function onLoad2() {
            var id_nteach2 = document.getElementById('nonteaching');
            id_nteach2.classList.remove('hide');
            id_nteach2.classList.add('show');
            var dept_nteach2 = document.getElementsByName('dept_name_nteach')[0];
            dept_nteach2.setAttribute("required", "");
            var afacndept2 = document.getElementById('afacndept');
            afacndept2.setAttribute("required", "");
            var id_nteach2 = document.getElementById('afacid2');
            id_nteach2.classList.remove('hide');
            id_nteach2.classList.add('show');
            var desig_nteach2 = document.getElementById('afacdesnteach');
            desig_nteach2.classList.remove('hide');
            desig_nteach2.classList.add('show');
            var designation_nteach2 = document.getElementsByName('designation_nteach')[0];
            designation_nteach2.setAttribute("required", "");

            var teaching_dept2 = document.getElementById('teaching');
            teaching_dept2.classList.remove('show');
            teaching_dept2.classList.add('hide');
            var dept_teach2 = document.getElementsByName('dept_name_teach')[0];
            dept_teach2.removeAttribute("required");
            var room_no2 = document.getElementById('rn');
            room_no2.classList.remove('show');
            room_no2.classList.add('hide');
            var id_teach2 = document.getElementById('afacid1');
            id_teach2.classList.remove('show');
            id_teach2.classList.add('hide');
            var desig_teach2 = document.getElementById('afacdesteach');
            desig_teach2.classList.remove('show');
            desig_teach2.classList.add('hide');
            var designation_teach2 = document.getElementsByName('designation_teach')[0];
            designation_teach2.removeAttribute("required");


          }

          function showteachid(str) {
            if (str == "") {
              document.getElementById("afacid1inp").innerHTML = "";
              return;
            } else {
              var xmlhttp = new XMLHttpRequest();
              xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  document.getElementById("afacid1inp").readOnly = false;
                  document.getElementById("afacid1inp").value = this.responseText;
                  document.getElementById("afacid1inp").readOnly = true;
                }
              };
              xmlhttp.open("GET", "getteachid.php?dept=" + str, true);
              xmlhttp.send();

            }
          }
        </script>
      <?php } ?>
      <!-- ------------------------------------------------------------------------------------------------------------------------------------- -->
      <?php if (isset($_GET['addlab'])) { ?>
        <form method='post' action="db_ops.php">
          <div>
            <label for='lab_no'>Lab Number:</label>
            <input class='form-input' type='text' name='lab_no' required>
          </div>
          <p></p>
          <div><label for='room_no'>Room Number:</label>
            <input class='form-input' type='text' name='room_no' required>
          </div>
          <input type='submit' name='addedlab' value='Add Lab' />
        </form>
      <?php } ?>
      <!------------------------------------------------------------------------------------------------------------------------------------------->
      <?php if (isset($_GET['additem'])) { ?>
        <style>
          .form-select-sm {
            width: 100%;
          }

          .form-control-sm {
            width: 100%;
          }
        </style>
        <form method='post' action="db_ops.php">
          <div><label for='aiid'>ID:</label>
            <input type='text' id='aiid' name='id' value=" <?php $query = 'SELECT max(id) as max_id from computational_items; ';
                                                            $res = mysqli_query($connection, $query);
                                                            while ($row = mysqli_fetch_assoc($res)) {
                                                              $max_id = $row['max_id'];
                                                            }
                                                            $max_id++;
                                                            $query2 = 'SELECT id from computational_items ORDER BY id; ';
                                                            $res = mysqli_query($connection, $query2);
                                                            $count = 1;
                                                            while ($row = mysqli_fetch_assoc($res)) {
                                                              if ($row['id'] == $count) {
                                                                $count++;
                                                              } else {
                                                                $max_id = $count;
                                                                break;
                                                              }
                                                            }
                                                            echo $max_id; ?>" readonly>
          </div>
          <div><label for='reg_page_no'>Register page number:</label>
            <input type='text' name='reg_page_no' required/>
          </div>
          <div><label for='item_type'>Item Type:</label>
            <select class='form-select-sm' name='item_type' required>
              <option value='' selected hidden disabled>Select item type</option>
              <?php $sql = "SELECT DISTINCT item_type from computational_items";
              $result = mysqli_query($connection, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
                $item_type = $row['item_type'];
                $fcap = ucfirst($item_type);
                $fcap = str_replace('_', ' ', $fcap);
                echo "<option value='{$item_type}'>{$fcap}</option>";
              } ?>
            </select>
          </div>
          <div><label for='Model'>Model:</label>
            <input type='text' name='Model' required />
          </div>
          <div><label for='date_of_purchase'>Date of Purchase:</label>
            <input class='form-control-sm' type='date' id='dop' name='date_of_purchase' required />
          </div>
          <div><label for='quantity_received'>Quantity Received:</label>
            <input type='number' min='0' name='quantity_received' required/>
          </div>
          <div><label for='rate'>Rate:</label>
            <input type='number' min='0' name='rate' />
          </div>
          <div><label for='amount'>Amount:</label>
            <input type='number' min='0' name='amount' />
          </div>
          <div><label for='writeoff'>Write Off:</label>
            <input type='number' name='writeoff' min='0' required/>
          </div>
          <input type='submit' name='addeditem' value='Add Item' />
        </form>
      <script>
//         function mydate()
// {
//  d=new Date(document.getElementById("dop").value);
// dt=d.getDate();
// mn=d.getMonth();
// mn++;
// yy=d.getFullYear();
// document.getElementById("dop").value=dt+"/"+mn+"/"+yy;
// console.log(dt+"/"+mn+"/"+yy);
// }

      </script>
      <?php } ?>
      <!----------------------------------------------------------------------------------------------------------------------------------------->
      <?php if (isset($_GET['addadmin'])) { ?>
        <form method='post' action="db_ops.php">
          <div><label for='username'>Username:</label>
            <input type='text' name='username' required />
          </div>
          <div><label for='password'>Password:</label>
            <input type='password' name='password' onchange="validatePassword();" required />
          </div>
          <div><label for='confirm_password'>Confirm Password:</label><input type="password" placeholder="Confirm Password" id="confirm_password" onkeyup="validatePassword();" required>
            <input type='submit' name='addedadmin' value='Add Admin' />
        </form>
        <script>
          var password = document.getElementsByName("password")[0],
            confirm_password = document.getElementById("confirm_password");

          function validatePassword() {
            if (password.value != confirm_password.value) {
              confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
              confirm_password.setCustomValidity('');
            }
          }
        </script>
      <?php } ?>
      <!-- ---------------------------------------------------------------------------------------------------------------------------- -->
      <?php if (isset($_GET['removefaculty'])) { ?>
        <form method='post' action="db_ops.php">
          <span>Department type:
            <div class="form-check">
              <label class="form-check-label" for='rfacteach'>Teaching</label> <input class="form-check-input" id='rfacteach' type='radio' name='dept_type' value='teaching' required><br />
              <label class="form-check-label" for='rfacnteach'>Non Teaching</label> <input class="form-check-input" id='rfacnteach' type='radio' name='dept_type' value='nonteaching'>
            </div>
          </span>
          <div><label for='id'>ID:</label>
            <input type='text' name='id' required />
          </div>
          <input type='submit' name='removedfaculty' value='Remove faculty' />
        </form>
      <?php } ?>

      <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

      <?php if (isset($_GET['removelab'])) { ?>
        <form method='post' action="db_ops.php">
          <div>
            <label for='lab_no'>Lab Number:</label>
            <input class='form-input' type='text' name='lab_no' required>
          </div>
          <input type='submit' name='removedlab' value='Remove Lab' />
        </form>
      <?php } ?>
      <!-------------------------------------------------------------------------------------------------------------------------------->

      <?php if (isset($_GET['removeitem'])) { ?>
        <style>
          .hide {
            display: none;
          }

          .show {
            display: block;
          }

          .form-select-sm {
            width: 100%;
          }
        </style>
        <form method='post' action='db_ops.php'>
          <div><label for='item_type'>Select an Item Type:</label>
            <select class='form-select-sm' name='item_type' id="select_item" required>
              <option value='' selected hidden disabled>Select item type</option>
              <?php $sql = "SELECT DISTINCT item_type from computational_items";
              $result = mysqli_query($connection, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
                $item_type = $row['item_type'];
                $fcap = ucfirst($item_type);
                $fcap = str_replace('_', ' ', $fcap);
                echo "<option value='{$item_type}'>{$fcap}</option>";
              } ?>
            </select>
          </div>
          <?php $sql = "SELECT DISTINCT item_type from computational_items";
          $result = mysqli_query($connection, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
            $item_type = $row['item_type'];
            $fcap = ucfirst($item_type);
            $fcap = str_replace('_', ' ', $fcap);

            echo "<div class='hide' id='{$item_type}modelselect'><hr><p> Select a {$fcap} Model: </p>
          <select class='form-select-sm' id='selectBox{$item_type}' name='{$item_type}Model'>
          <option value='' selected disabled hidden>Select {$fcap}</option>";
            $sql = "select DISTINCT Model from computational_items where item_type = '{$item_type}'; ";
            $query = mysqli_query($connection, $sql);
            while ($r = mysqli_fetch_assoc($query)) {
              $categoryName = $r["Model"];
              echo "<option value='{$categoryName}'>$categoryName</option>";
            }
            echo "</select>";
            echo " <input type='submit' name='remove{$item_type}' value='Remove {$fcap}' style='width:100%' />
          </div>";
          }
          ?>
        </form>

        <script>
          document.getElementById("select_item").addEventListener('click', function() {
            var val = document.getElementById("select_item").value;
            var fun = window["select" + val];
            fun();
          });
          <?php $sql = "SELECT DISTINCT item_type from computational_items";
          $result = mysqli_query($connection, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
            $item_type = $row['item_type'];
            echo "\nfunction select{$item_type}(){\n";
            $sql2 = "SELECT DISTINCT item_type from computational_items";
            $result2 = mysqli_query($connection, $sql2);
            while ($r = mysqli_fetch_assoc($result2)) {
              $it = $r['item_type'];
              if ($item_type == $it) continue;
              echo "var {$it}modelselect= document.getElementById('{$it}modelselect');
              {$it}modelselect.classList.remove('show');
              {$it}modelselect.classList.add('hide');
              document.getElementById('selectBox{$it}').removeAttribute('required');\n";
            }
            echo "var {$item_type}modelselect=document.getElementById('{$item_type}modelselect');
            {$item_type}modelselect.classList.remove('hide');
            {$item_type}modelselect.classList.add('show');
            document.getElementById('selectBox{$item_type}').setAttribute('required', '');\n};";
          } ?>
        </script>
      <?php } ?>
      <!--------------------------------------------------------------------------------------------------------------------------------------- -->
      <?php if (isset($_GET['removeadmin'])) { ?>
        <form method='post' action="db_ops.php">
          <div><label for='username'>Username:</label>
            <input type='text' name='username' required />
          </div>
          <div><label for='password'>Password:</label>
            <input type='password' name='password' onchange="validatePassword();" required />
          </div>
          <div><label for='confirm_password'>Confirm Password:</label><input type="password" placeholder="Confirm Password" id="confirm_password" onkeyup="validatePassword();" required>
            <input type='submit' name='removedadmin' value='Remove Admin' />
        </form>
        <script>
          var password = document.getElementsByName("password")[0],
            confirm_password = document.getElementById("confirm_password");

          function validatePassword() {
            if (password.value != confirm_password.value) {
              confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
              confirm_password.setCustomValidity('');
            }
          }
        </script>
      <?php } ?>

      <!-- -------------------------------------------------------------------------------------------------------------------------------- -->
      <?php if (isset($_GET['allocateitem'])) { ?>
        <style>
          .hide {
            display: none;
          }

          .show {
            display: block;
          }

          .form-select-sm {
            width: 100%;
          }
        </style>
        <form method='post' action='db_ops.php'>
          <div><label for='item_type'>Select an Item Type:</label>
            <select class='form-select-sm' name='item_type' id="select_item" required>
              <option value='' selected hidden disabled>Select item type</option>
              <?php $sql = "SELECT DISTINCT item_type from computational_items";
              $result = mysqli_query($connection, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
                $item_type = $row['item_type'];
                $fcap = ucfirst($item_type);
                $fcap = str_replace('_', ' ', $fcap);
                echo "<option value='{$item_type}'>{$fcap}</option>";
              } ?>
            </select>
          </div>
          <?php $sql = "SELECT DISTINCT item_type from computational_items";
          $result = mysqli_query($connection, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
            $item_type = $row['item_type'];
            $fcap = ucfirst($item_type);
            $fcap = str_replace('_', ' ', $fcap);

            echo "<div class='hide' id='{$item_type}modelselect'><p></p>Select an item model:
          <select class='form-select-sm' id='selectBox{$item_type}' name='{$item_type}Model' onclick='select_quantity(this.value);'>
          <option value='' selected disabled hidden>Select model</option>";
            $sql = "select DISTINCT Model from computational_items where item_type = '{$item_type}'; ";
            $query = mysqli_query($connection, $sql);
            while ($r = mysqli_fetch_assoc($query)) {
              $categoryName = $r["Model"];
              echo "<option value='{$categoryName}'>$categoryName</option>";
            }
            echo "</select></div>";
          }
          ?>
          <div id='quantityselect'>
            <p></p>Select the quantity to be issued:
            <input type='number' min='0' class='form-select-sm' id ='quantityBox' name='quantity' placeholder='Select quantity' required/>
          </div>
          <div>
            <p></p><label for='id'>ID: </label>
            <input class='form-select-sm' type='text' name='id' id='id' required>
          </div>
          <input type='submit' name='allocateditem' value='Allocate item' />

        </form>
        <script>
          document.getElementById("select_item").addEventListener('click', function() {
            var val = document.getElementById("select_item").value;
            var fun = window["select" + val];
            fun();
          });

          function select_quantity(model) {
            var quantity = 0;
            var item_model;
            <?php $sql = "SELECT DISTINCT Model from computational_items";
            $result = mysqli_query($connection, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
              $item_model = $row['Model']; ?>
              item_model = "<?php echo $item_model; ?>";
              if (item_model == model) {
                quantity = <?php $sql2 = 'SELECT SUM(balance_instock) as balance from computational_items where Model="';
                            $sql2 .= strval($item_model);
                            $sql2 .= '"; ';
                            $res = mysqli_query($connection, $sql2);
                            while ($r = mysqli_fetch_assoc($res)) {
                              echo $r['balance'];
                              echo ";";
                            } ?>
              }
            <?php  } ?>

            var i = 1;
            document.getElementById('quantityBox').max = quantity;
            // "<option value='' selected disabled hidden>Select quantity</option>";
            // while (i <= quantity) {
            //   var option = "<option value='" + i + "'>" + i + "</option>";
            //   document.getElementById('quantityBox').innerHTML += option;
            //   i++;
            // }
          };
          <?php $sql = "SELECT DISTINCT item_type from computational_items";
          $result = mysqli_query($connection, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
            $item_type = $row['item_type'];
            echo "\nfunction select{$item_type}(){\n";
            $sql2 = "SELECT DISTINCT item_type from computational_items";
            $result2 = mysqli_query($connection, $sql2);
            while ($r = mysqli_fetch_assoc($result2)) {
              $it = $r['item_type'];
              if ($item_type == $it) {
                continue;
              }
              echo "var {$it}modelselect= document.getElementById('{$it}modelselect');
              {$it}modelselect.classList.remove('show');
              {$it}modelselect.classList.add('hide');
              document.getElementById('selectBox{$it}').removeAttribute('required');\n";
            }
            echo "var {$item_type}modelselect=document.getElementById('{$item_type}modelselect');
            {$item_type}modelselect.classList.remove('hide');
            {$item_type}modelselect.classList.add('show');
            document.getElementById('selectBox{$item_type}').setAttribute('required', '');};\n";
          } ?>
        </script>
      <?php } ?>
      <!----------------------------------------------------------------------------------------------------------------------------------------->
      <?php if (isset($_GET["deallocateitem"])) { ?>

        <form class="" action="admin.php" method="post">

          <div class="container text-center">
            Select department type:
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="dept_type" value="Teaching" required>
            <label class="form-check-label" for="Teaching">Teaching</label>
          </div>

          <div class="form-check">
          <input class="form-check-input" type="radio" name="dept_type" value="Non-Teaching">
          <label class="form-check-label" for="Non-Teaching">Non-Teaching</label>  
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="dept_type" value="lab">
            <label class="form-check-label" for="lab">Lab</label>
          </div>

          <div class="form-check">
            <input type="submit" value="Next" class="form-check-input" name="submitRemoveItemType" style="width:100%;height:min-content;">
          </div>

        </form>
      <?php } ?>

      <?php if (isset($_POST["submitRemoveItemType"])) {
        if ($_POST["dept_type"] == 'Teaching') { ?>
          <form class="" action="admin.php" method="post">
            <div id="idTeacher">
              Enter Teacher ID :
              <input calss="form-input" type="text" name="teacherId" value="" placeholder="Enter Teacher ID" required>
            </div>
            <hr>
            Select an Item Type :
            <div>
              <select class='form-select-sm' name='itemType' required>
                <?php $sql = "SELECT DISTINCT item_type from computational_items";
                $result = mysqli_query($connection, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                  $item_type = $row['item_type'];
                  $cap = strtoupper(str_replace('_', ' ', $item_type));
                  echo "<option value='$item_type'>$cap</option>";
                } ?>
              </select>
            </div>
            <div>
              <input type="submit" value="Next" class="form-input" name="removeItemType" style="width:100%;height:min-content;">
            </div>
          </form>
        <?php   } 
        else if ($_POST["dept_type"] == 'Non-Teaching') { ?>
          <style>
            .form-select-sm {
              width: 100%;
            }
          </style>
          <form class="" action="admin.php" method="post">
            Select Faculty Name :
            <select class="form-select-sm" id="selectFacultyName" name="facultyName" required>
              <option value="" selected disabled hidden>Select Faculty</option>
              <?php
              global $connection;
              $sql = "select DISTINCT name from faculty natural join department where dept_type='nonteaching';";
              $query = mysqli_query($connection, $sql);
              if ($query) {
                while ($row = mysqli_fetch_assoc($query)) {
                  $facultyName = $row["name"];
                  echo "<option value='{$facultyName}'>$facultyName</option>";
                }
              } ?>
            </select>

            <hr>

            Select Department :
            <select class="form-select-sm" id="selectDepartmentName" name="departmentName" required>
              <option value="" selected disabled hidden>Select Department</option>
              <?php
              global $connection;
              $sql = "select DISTINCT dept_name from department where dept_type='nonteaching';";
              $query = mysqli_query($connection, $sql);
              if ($query) {
                while ($row = mysqli_fetch_assoc($query)) {
                  $deptName = $row["dept_name"];
                  echo "<option value='{$deptName}'>$deptName</option>";
                }
              } ?>
            </select>
            <hr>
            Select Designation :
            <select class="form-select-sm" id="selectDesignation" name="designationName" required>
              <option value="" selected disabled hidden>Select Designation</option>
              <?php
              global $connection;
              $sql = "select DISTINCT designation from department where dept_type='nonteaching';";
              $query = mysqli_query($connection, $sql);
              if ($query) {
                while ($row = mysqli_fetch_assoc($query)) {
                  $designationName = $row["designation"];
                  echo "<option value='{$designationName}'>$designationName</option>";
                }
              } ?>
            </select>
            <hr>
            Select an Item Type :
            <div>
              <select class='form-select-sm' name='itemType' required>
                <?php $sql = "SELECT DISTINCT item_type from computational_items";
                $result = mysqli_query($connection, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                  $item_type = $row['item_type'];
                  $cap = strtoupper(str_replace('_', ' ', $item_type));
                  echo "<option value='$item_type'>$cap</option>";
                } ?>
              </select>
            </div>
            <div>
              <input type="submit" value="Next" class="form-input" name="removeNon-Teaching" style="width:100%;height:min-content;">
            </div>
          </form>
      <?php }
      else if($_POST["dept_type"] == 'lab'){?>
            <form class="" action="admin.php" method="post">
            <div>
            <label for='lab_no' class='form-select-label'>Select Lab:</label>
              <select class='form-select-sm' name='lab_no' style="width:100%;" required>
              <option value='' selected disabled hidden>Select Lab</option>
                <?php $sql = "SELECT DISTINCT lab_no from lab order by lab_no";
                $result = mysqli_query($connection, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<option value='{$row['lab_no']}'>{$row['lab_no']}</option>";
                } ?>
              </select>
            </div>
            <hr>
            <div>
            <label for='itemType' class='form-select-label'>Select an item type:</label>
              <select class='form-select-sm' name='itemType' style="width:100%;" required>
              <option value='' selected disabled hidden>Select item type</option>
                <?php $sql = "SELECT DISTINCT item_type from computational_items";
                $result = mysqli_query($connection, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                  $item_type = $row['item_type'];
                  $cap = strtoupper(str_replace('_', ' ', $item_type));
                  echo "<option value='$item_type'>$cap</option>";
                } ?>
              </select>
            </div>
              <input type="submit" value="Next" class="form-input" name="removeItemTypeLab" style="width:100%;height:min-content;">
          </form>
      <?php }}?>

      <?php
      if (isset($_POST["removeNon-Teaching"])) {
        $_SESSION["facultyName"] = $_POST["facultyName"];
        $_SESSION["departmentName"] = $_POST["departmentName"];
        $_SESSION["designationName"] = $_POST["designationName"];
        $_SESSION["item_type"] = $_POST["itemType"];
        $facultyName = $_POST["facultyName"];
        $departmentName = $_POST["departmentName"];
        $designationName = $_POST["designationName"];
        $item_type = $_POST["itemType"];
        $sql = "select * from department natural join faculty where dept_type='nonteaching' and name = '{$facultyName}' and dept_name = '{$departmentName}' and designation = '{$designationName}';";
        $res = mysqli_query($connection, $sql);
        if ($res) {
          $num_of_rows = mysqli_num_rows($res);
          if (!$num_of_rows) {
            echo "Faculty Name, Department and Designation don't Match!";
          } else {
            echo "<form action='db_ops.php' method='post'>";
            echo "<div class='container text-center'>Name : {$facultyName}" . "<br/>" . "Department : {$departmentName}" . "<br/>" . "Designation : {$designationName}</div>"; ?>
            <hr>
        <?php
            $cap = strtoupper(str_replace('_', ' ', $item_type));
            echo "<div style='display:block;'>
          Select {$cap} Model to Remove :
          <select class='form-select-sm' style='width:100%;' id='selectBox{$item_type}' name='{$item_type}Model' onclick='select_quantity(this.value);' required>
          <option value='' selected disabled hidden>Select {$cap}</option>";
            $sql = "select DISTINCT Model from computational_items where id in (Select {$item_type}.{$item_type}_model from faculty NATURAL LEFT OUTER JOIN department NATURAL LEFT OUTER JOIN {$item_type} where dept_type='nonteaching' and faculty.name = '{$facultyName}' and dept_name = '{$departmentName}' and designation = '{$designationName}');";
            $query = mysqli_query($connection, $sql);
            if ($query) {
              while ($row = mysqli_fetch_assoc($query)) {
                $categoryName = $row["Model"];
                echo "<option value='{$categoryName}'>$categoryName</option>";
              }
              echo "</select><div id='quantityselect'><p></p>Select the quantity to be removed:
          <select class='form-select-sm' style='width:100%;' id='quantityBox' name='quantity' required>
          <option value='' selected disabled hidden>Select quantity</option>
          </select></div>
          <input type='submit' name='removeItem_nteach' value='Remove {$cap}' style='width:100%' />
          </div></form>";
            }
          }
        }
        ?>

        <script>
          function select_quantity(model) {
            var quantity = 0,
              item_model;
            <?php $sql = "SELECT DISTINCT Model from computational_items";
            $result = mysqli_query($connection, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
              $item_model = $row['Model']; ?>
              item_model = "<?php echo $item_model; ?>";
              if (item_model === model) {
                quantity = <?php $item_type = $_SESSION['item_type'];
                            $sql1 = 'SELECT id from computational_items where Model="';
                            $sql1 .= strval($item_model);
                            $sql1 .= '";';
                            $result1 = mysqli_query($connection, $sql1);
                            $quan = 0;
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                              $item_id = $row1['id'];
                              $sql2 = "SELECT quantity from {$item_type} where {$item_type}_model=$item_id and id in (select faculty.id from faculty natural join department where faculty.name='{$facultyName}' and department.dept_name='{$departmentName}' and department.designation='{$designationName}'); ";
                              $result2 = mysqli_query($connection, $sql2);
                              while ($row2 = mysqli_fetch_assoc($result2)) {
                                $quan += $row2['quantity'];
                              }
                            }
                            echo $quan; ?>
              };
            <?php } ?>
            var i = 1;
            document.getElementById('quantityBox').innerHTML = "<option value='' selected disabled hidden>Select quantity</option>";
            while (i <= quantity) {
              var option = "<option value='" + i + "'>" + i + "</option>";
              document.getElementById('quantityBox').innerHTML += option;
              i++;
            }
          };
        </script>
      <?php } ?>

      <?php if (isset($_POST["removeItemType"])) { ?>
        <form class="" action="db_ops.php" method="post">
          <?php if (isset($_POST["itemType"])) {
            $item_type =   $_POST["itemType"];
            $teacherId =  $_POST["teacherId"];
            $_SESSION["teacherId"] = $teacherId;
            $_SESSION["item_type"] = $item_type;
            $sql = "select faculty.name as name from faculty natural join department where id = '{$teacherId}' and dept_type='teaching';";
            $res = mysqli_query($connection, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
              $teacherName = $row["name"];
              if ($teacherName != '') {
                echo "<div class='container text-center'>Teacher Name : " . "{$teacherName}" . "<br/>" . "Teacher Id : " . "{$teacherId}" . "</div>";
                $cap = strtoupper(str_replace('_', ' ', $item_type));
                echo "<hr>Select  $cap Model to Remove :
      <select class='form-select-sm' id='selectBox{$item_type}' name='{$item_type}Model' onclick='select_quantity(this.value);' required>
      <option value='' selected disabled hidden>Select {$cap}</option>";
                $sql = "select DISTINCT Model from computational_items where id in (select {$item_type}_model from {$item_type} where id = '{$teacherId}');";
                $query = mysqli_query($connection, $sql);
                if ($query) {
                  while ($row = mysqli_fetch_assoc($query)) {
                    $categoryName = $row["Model"];
                    echo "<option value='{$categoryName}'>$categoryName</option>";
                  }
                  echo "</select>";
                  echo "</select><div id='quantityselect'><p></p>Select the quantity to be removed:
              <select class='form-select-sm' style='width:100%;' id='quantityBox' name='quantity' required>
              <option value='' selected disabled hidden>Select quantity</option>
              </select></div>
                  <input type='submit' name='removeItem' value='Remove {$cap}' style='width:100%' />";
                }
              } else {
                $_SESSION["error"] = "Faculty with $teacherId id doesn't exist!";
                echo errorMessage();
                redirect_to("admin.php");
                die();
              }
            }
          } ?>
        </form>
        <script>
          function select_quantity(model) {
            var quantity = 0,
              item_model;
            <?php $sql = "SELECT DISTINCT Model from computational_items";
            $result = mysqli_query($connection, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
              $item_model = $row['Model']; ?>
              item_model = "<?php echo $item_model; ?>";
              if (item_model === model) {
                quantity = <?php $item_type = $_SESSION['item_type'];
                            $sql1 = 'SELECT id from computational_items where Model="';
                            $sql1 .= strval($item_model);
                            $sql1 .= '";';
                            $result1 = mysqli_query($connection, $sql1);
                            $quan = 0;
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                              $item_id = $row1['id'];
                              $sql2 = "SELECT quantity from {$item_type} where {$item_type}_model=$item_id and id='{$teacherId}'; ";
                              $result2 = mysqli_query($connection, $sql2);
                              while ($row2 = mysqli_fetch_assoc($result2)) {
                                $quan += $row2['quantity'];
                              }
                            }
                            echo $quan; ?>
              };
            <?php } ?>
            var i = 1;
            document.getElementById('quantityBox').innerHTML = "<option value='' selected disabled hidden>Select quantity</option>";
            while (i <= quantity) {
              var option = "<option value='" + i + "'>" + i + "</option>";
              document.getElementById('quantityBox').innerHTML += option;
              i++;
            }
          };
        </script>
      <?php } ?>
      <?php if (isset($_POST["removeItemTypeLab"])) { ?>
        <form class="" action="db_ops.php" method="post">
          <?php if (isset($_POST["itemType"])) {
            $item_type =   $_POST["itemType"];
            $lab_no =  $_POST["lab_no"];
            $_SESSION["lab_no"] = $lab_no;
            $_SESSION["item_type"] = $item_type;
            $sql = "select room_no from lab where lab_no = '{$lab_no}';";
            $res = mysqli_query($connection, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
              $room_no = $row["room_no"];
                echo "<div class='container text-center'>Lab Number: {$lab_no}" . "<br/>" . "Room Number : " . "{$room_no}" . "</div>";
                $cap = strtoupper(str_replace('_', ' ', $item_type));
                echo "<hr>Select  $cap Model to Remove :
      <select class='form-select-sm' style='width:100%;' id='selectBox{$item_type}' name='{$item_type}Model' onclick='select_quantity(this.value);' required>
      <option value='' selected disabled hidden>Select {$cap}</option>";
                $sql = "select DISTINCT Model from computational_items where id in (select {$item_type}_model from {$item_type} where id = '{$lab_no}');";
                $query = mysqli_query($connection, $sql);
                if ($query) {
                  while ($row = mysqli_fetch_assoc($query)) {
                    $categoryName = $row["Model"];
                    echo "<option value='{$categoryName}'>$categoryName</option>";
                  }
                  echo "</select>";
                  echo "</select><div id='quantityselect'><p></p>Select the quantity to be removed:
              <select class='form-select-sm' style='width:100%;' id='quantityBox' name='quantity' required>
              <option value='' selected disabled hidden>Select quantity</option>
              </select></div>
                  <input type='submit' name='removeItemlab' value='Remove {$cap}' style='width:100%' />";
                }
            }
          } ?>
        </form>
        <script>
          function select_quantity(model) {
            var quantity = 0,
              item_model;
            <?php $sql = "SELECT DISTINCT Model from computational_items";
            $result = mysqli_query($connection, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
              $item_model = $row['Model']; ?>
              item_model = "<?php echo $item_model; ?>";
              if (item_model === model) {
                quantity = <?php $item_type = $_SESSION['item_type'];
                            $sql1 = 'SELECT id from computational_items where Model="';
                            $sql1 .= strval($item_model);
                            $sql1 .= '";';
                            $result1 = mysqli_query($connection, $sql1);
                            $quan = 0;
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                              $item_id = $row1['id'];
                              $sql2 = "SELECT quantity from {$item_type} where {$item_type}_model=$item_id and id='{$lab_no}'; ";
                              $result2 = mysqli_query($connection, $sql2);
                              while ($row2 = mysqli_fetch_assoc($result2)) {
                                $quan += $row2['quantity'];
                              }
                            }
                            echo $quan; ?>
              };
            <?php } ?>
            var i = 1;
            document.getElementById('quantityBox').innerHTML = "<option value='' selected disabled hidden>Select quantity</option>";
            while (i <= quantity) {
              var option = "<option value='" + i + "'>" + i + "</option>";
              document.getElementById('quantityBox').innerHTML += option;
              i++;
            }
          };
        </script>
      <?php } ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>