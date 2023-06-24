<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Computational Database for staff of CCET</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php include('./header.php') ?>
  <div class="cardview">
    <button onclick="window.location.href ='./departmentwise_list.php'" class="btn-primary" style="all:unset;">
      <div class="card" id="card1">
        <div class="card-body">
          <h5 class="card-title">
            <p class="txt">Department wise list of computational items</p><img class="card-img" src="./images/departmentwise.jpg"></img>
          </h5>
          <p class="card-text">Click here for showing department wise list of computational items</p>
        </div>
      </div>
    </button>
    <button onclick="window.location.href = './item_types.php'" class="btn-primary" style=" all:unset; ">
      <div class="card" id="card2">
        <div class="card-body">
          <h5 class="card-title">
            <p class="txt">Itemwise list of computational items</p><img class="card-img" src="./images/itemwise.jpg" />
          </h5>
          <p class="card-text">Click here for showing itemwise list of computational items</p>
        </div>
      </div>
    </button>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>