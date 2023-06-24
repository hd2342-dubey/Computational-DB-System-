<?php require_once("db_connection.php"); ?>
<?php
    function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
	}

	function mysql_prep($string) {
		global $connection;
		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}

    function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}

	function find_all_admins() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "ORDER BY username ASC";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		return $admin_set;
	}

	function find_admin_by_id($admin_id) {
		global $connection;
		
		$safe_admin_id = mysqli_real_escape_string($connection, $admin_id);
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE id = {$safe_admin_id} ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

	function find_admin_by_username($username) {
		global $connection;
		
		$safe_username = mysqli_real_escape_string($connection, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

	function password_encrypt($password) {
		$hash=password_hash($password,PASSWORD_DEFAULT);
		  return $hash;
	  }
	  
	  function password_check($password, $existing_hash) {
		$verify=password_verify($password,$existing_hash);
		if ($verify) {
		  return true;
		} else {
		  return false;
		}
	  }
  
	  function attempt_login($username, $password) {
		  $admin = find_admin_by_username($username);
		  if ($admin) {
			  if (password_check($password, $admin["hashed_password"])) {
				  return $admin;
			  } else {
				  return false;
			  }
		  } else {
			  return false;
		  }
	  }
  
	  function logged_in() {
		  return isset($_SESSION['admin_id']);
	  }
	  
	  function confirm_logged_in() {
		  if (!logged_in()) {
			  redirect_to("index.php");
		  }
	  }

	  ?>