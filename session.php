<?php

   session_start();

   function message() {
		if (isset($_SESSION["message"])) {
			$output = "<div class=\"message\">";
			$output .= htmlentities($_SESSION["message"]);
			$output .= "</div>";
			
			$_SESSION["message"] = null;
			
			return $output;
		}
	}

   function errorMessage(){
     if(isset($_SESSION["error"])){
   if($_SESSION["error"]!="null"){
    $Output = "<div class = 'alert alert-danger alert-dismissible fade show' style='width:100%; position:absolute; z-index:999;'>";
    $Output .= htmlentities($_SESSION["error"]);
    $Output .= "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    $_SESSION["error"]  = "null";
    return $Output;
   }
   }
 }

 function successMessage(){
  if(isset($_SESSION["successMessage"])){
if($_SESSION["successMessage"]!="null"){
 $Output = "<div class = \"alert alert-success alert-dismissible fade show\" style='width:100%; position:absolute; z-index:999;'>";
 $Output .= htmlentities($_SESSION["successMessage"]);
 $Output .= "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
 $_SESSION["successMessage"]  = "null";
 return $Output;
}
}
}

 ?>
