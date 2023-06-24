<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Departments</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
        body{
            background:#f6f6f6;
        }
        .grid-view {
            font-family: 'Times New Roman', Times, serif;
            font-size: 1.8vw;
            font-weight: 800;
        }

        .grid-view p {
            margin: auto auto;
            color: whitesmoke;
            background-color: rgba(63, 50, 50, 0.541);
            width: fit-content;
        }

        .branches{
            float: center; 
            border:0.05px solid black; 
            width:45%;
            height:100%; 
            border-radius:2%; 
            margin-left:2vw; 
            margin-right:2vw; 
            background-position: center;
            background-size:cover;
            background-repeat:no-repeat;
        }

        .branches:hover{
            transform:scale(1.05,1.05);
            box-shadow: 5px 5px 15px rgba(0,0,0,0.5);
        }
    </style>
</head>

<body>
    
    <?php include('./header.php')?>
    <div class="grid-view" style="display:flex; flex-direction:column; height:73vh;">
        <div class="frow" style="display:flex; flex-direction:row; height:32%; padding:1%;">
            <button class="branches" onclick="window.location.href = './branches/cse.php'"
                style="background-image: url(./images/cse.jpg); ">
                <p>Computer Science Engineering</p>
            </button> 
            <button class="branches" onclick="window.location.href = './branches/me.php'"
                style="background-image: url(./images/me.jpg);">
                <p>Mechanical Engineering</p>
            </button>
            </div>
        <div class="center" style="display:flex; flex-direction:row; padding:1%; height:32%;">
            <button class="branches" onclick="window.location.href = './branches/ece.php'"
                    style=" background-image: url(./images/ece.jpg); ">
                    <p>Electronics and Communication Engineering</p>
                </button>
            <button class="branches" onclick="window.location.href = './branches/ce.php'"
                    style=" background-image: url(./images/ce.jpg); background-size:cover;">
                    <p>Civil Engineering</p>
                </button>
        </div>
        <div class="brow" style="display:flex; flex-direction:row; padding:1%; height:32%;">
                <button class="branches" onclick="window.location.href = './branches/appsci.php'"
                style=" background-image:url(./images/appsci.jpg);">
                <p>Applied Science</p>
            </button>
                <button class="branches" onclick="window.location.href = './branches/non_teaching.php'"
                    style="background-image: url(./images/nonteaching.jpg); ">
                    <p>Non Teaching</p>
                </button>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
</body>

</html>