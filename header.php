<?php require_once("./session.php"); ?>
<?php require_once("./db_connection.php"); ?>
<?php require_once("./functions.php"); ?>
<?php require_once("./validation_functions.php"); ?>

<?php

if (isset($_POST['submit'])) {

    $required_fields = array("username", "password");
    validate_presences($required_fields);

    $username = $_POST["username"];
    $password = $_POST["password"];

    $found_admin = attempt_login($username, $password);

    if ($found_admin) {
        $_SESSION["admin_id"] = $found_admin["id"];
        $_SESSION["username"] = $found_admin["username"];
        redirect_to("./admin.php");
    } else {
        // Failure
        redirect_to('./index.php');
        $_SESSION["message"] = "Username/password not found.";
        echo "Username/password not found.";
    }
}
?>
<?php if (isset($_POST['logout'])) {
    session_destroy();
    redirect_to('./index.php');
} ?>

<style>
    .navbar-custom {
        background-color: #1866a2;
    }

    .btn {
        height: 5vh;
        font-size: 1.20vw;
        text-align: center;
    }

    .btn:hover {
        color: #1866a2;
    }
</style>
<div class="header" style="background-image: linear-gradient(#034E86, #53B5E0); padding-top: 8px;margin-top: 0px; height:140px;">
    <div style="display:flex; margin:auto auto;">
        <img style="width:8vw; margin-left: 15%;" src="./images/ccetLogoBlack.png" alt="CCETLogo" />
        <div style="display:flex; flex-direction: column; margin-left: 90px;">
            <h4 style="font-weight: 700;color: white;margin: 7px 0px 10px 0px; font-size:1.55vw;">Chandigarh College of Engineering
                and Technology (Degree Wing)</h4>
            <p style="font-size: 1.1vw; color: white;margin-bottom:0px;">(Government Institute Under Chandigarh UT
                Administration | Affiliated to Panjab University, Chandigarh)</p>
            <header style="font-size:1.4vw; color:black;">Database for CCET's computational items assigned to staff</header>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <!-- <a class="navbar-brand" style="margin-left: 20px;" href="#">CCET</a> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <button class="btn btn-outline-light me-2" style="border:none;" onclick="window.location.href = './index.php'">Home</button>
                </li>
                <li class="nav-item">
                    <button style="border:none;" class="btn btn-outline-light me-2" onclick="window.location.href = './branches/cse.php'">CSE</button>
                </li>
                <li class="nav-item">
                    <button style="border:none;" class="btn btn-outline-light me-2" onclick="window.location.href = './branches/me.php'">ME</button>
                </li>
                <li class="nav-item">
                    <button style="border:none;" class="btn btn-outline-light me-2" onclick="window.location.href = './branches/ece.php'">ECE</button>
                </li>
                <li class="nav-item">
                    <button style="border:none;" class="btn btn-outline-light me-2" onclick="window.location.href = './branches/ce.php'">CE</button>
                </li>
                <li class="nav-item">
                    <button style="border:none;" class="btn btn-outline-light me-2" onclick="window.location.href = './branches/appsci.php'">App. Sci.</button>
                </li>
                <li class="nav-item">
                    <button style="border:none;" class="btn btn-outline-light me-2" onclick="window.location.href = './branches/non_teaching.php'">Non Teaching</button>
                </li>
                <li class="nav-item">
                    <button style="border:none;" class="btn btn-outline-light me-2" onclick="window.location.href = './branches/lab.php'">Labs</button>
                </li>
                <li class="nav-item">
                    <a href='./pdf-viewer/stock_register104.html' target="_blank"><button style="border:none;" class="btn btn-outline-light me-2">Reg 104</button></a>
                </li>
                <li class="nav-item">
                    <a href='./pdf-viewer/stock_register71.html' target="_blank"><button style="border:none;" class="btn btn-outline-light me-2">Reg 71</button></a>
                </li>
                <?php if (logged_in()) { ?>
                    <li>
                        <button style="border:none;" class="btn btn-outline-light me-2" onclick="window.location.href = './admin.php'">Admin</button>
                    </li>
            </ul>
        </div>
        <div class='pull-right'>
            <form class="form-inline pull-right" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" style="float:right;">
                <div class="input-group float-end">
                    <button type="submit" name="logout" value="logout" name="submit" class="btn btn-outline-light" style="width:7vw; margin:2px;">Logout</button>
                </div>
            </form>
        </div>
    <?php } else { ?>
        </ul>
    </div>
    <div class='pull-right'>
        <form class="form-inline pull-right" method="post" action="./header.php" style=" float:right;">
            <div class="input-group float-end">
                <input type="text" name="username" class="form-control" placeholder="username" aria-label="username" aria-describedby="basic-addon1" style="width:10vw; margin:1px;">
                <input type="password" name="password" class="form-control" placeholder="password" aria-label="password" aria-describedby="basic-addon1" style="width:10vw; margin:1px;">
                <button type="submit" name="submit" value="submit" name="submit" class="btn btn-outline-light" style="width:7vw; margin:2px;">Sign in</button>
            </div>
        </form>
    </div>
<?php } ?>
</div>
</nav>