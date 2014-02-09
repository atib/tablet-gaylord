<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$par = md5(2);

if(isset($_SESSION['activation']))
{
	
	$activation = $_SESSION['activation'];
	
} else{
	
	$error_msg .= "It would seem that this tablet has not been assigned to the table order. Please inform a member of staff to assign this tablet";
	
	$par = md5(2);
	
	header("Location: login.php?err=$error_msg&par=$par");
		
}

if(isset($_POST['email']))
{
	$email = $_POST['email'];
	$password = stripslashes($_POST['password']);
	$email = $email;
	$password = strip_tags($password );	
	
	if((!$email)||(!$password)){
	
	$error_msg = "Please complete all manditory fields! <br>";	
		
		if(!$username){
			
			$error_msg .= "Email is missing";
				
		} else if (!$password){
		
			$error_msg .= "Password is missing";
			
		//} else if(!eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z-0-9-]+)*(\.[a-z]{2,4})$", $username)){
			
		///	$error_msg .= "Email has be in a valid email format";
			
		}
		
	$par = md5(2);
	
	header("Location: login.php?err=$error_msg&par=$par");
	exit();
	} else{
		
	include_once ("db_connect.php");

	$email = mysqli_real_escape_string($db_connection, $email);
	$password = mysqli_real_escape_string($db_connection, $password);
	
	$retrieve_salt = "SELECT c_salt FROM client_tbl WHERE c_email = '$email'";
	
	$retrieve_salt_db = mysqli_query($db_connection, $retrieve_salt) or die (mysqli_error($db_connection));
	
	$salt_check = mysqli_num_rows($retrieve_salt_db);
	
	
	if ($salt_check > 0){
	
		while($db_salt = mysqli_fetch_array($retrieve_salt_db)){
			
		$user_salt = $db_salt["c_salt"];
			
		}
		
	$password = md5($password .$user_salt);
	
	$password = md5($password);
			
	mysqli_free_result($retrieve_salt_db);
	
	$check_user = "SELECT * FROM client_tbl WHERE c_email = '$email' AND c_identifier = '$password'";
	
	$check_user_db = mysqli_query($db_connection, $check_user) or die (mysqli_error($db_connection));
	
	$user_check = mysqli_num_rows($check_user_db);

		if ($user_check > 0){
	
			while($user = mysqli_fetch_array($check_user_db)){
			
				$c_id = $user["c_id"];
				$_SESSION['c_id'] = $c_id;
				$email = $user["c_email"];
				$_SESSION['email'] = $email;
				$fname = $user["c_fname"];
				$_SESSION['fname'] = $fname;
			
			}
		
			mysqli_free_result($check_user_db);

			$par = md5(1);
				
			header("Location: index.php?n=$fname&par=$par");
		
			exit();
		
		} else{
		
			$error_msg = "Your selected credentials are incorrect";
		
			header("Location: login.php?err=$error_msg&par=$par");
		
			exit();
		}
		
	} else {
		
		echo "Essencial loging information not found. Contact site administrator";	
			
		$error_msg = "Essencial loging information not found. Contact site administrator";
		
		header("Location: login.php?err=$error_msg&par=$par");
		
		exit();
	}
	
	} 
	
} 	


if(isset($_POST['bypass'])){
	
	$email = "guest@gaylord.com";
	$c_salt = "gaylord";
	
	$password = md5("gaylord" .$c_salt);
	
	$password = md5($password);
	
	include_once ("db_connect.php");

	$check_user = "SELECT * FROM client_tbl WHERE c_email = '$email' AND c_identifier = '$password'";
	
	$check_user_db = mysqli_query($db_connection, $check_user) or die (mysqli_error($db_connection));
	
	$user_check = mysqli_num_rows($check_user_db);

		if ($user_check > 0){
	
$nameAppend = rand(100, 999); 
	
			while($user = mysqli_fetch_array($check_user_db)){
			
				$c_id = $user["c_id"];
				$_SESSION['c_id'] = $c_id;
				$email = $user["c_email"];
				$_SESSION['email'] = $email;
				$fname = $user["c_fname"];
				$lname = $user["c_lname"];
				$_SESSION['fname'] = ''.$fname.' '.$lname .' '.$nameAppend.'';
			
			}
		
			mysqli_free_result($check_user_db);

			$par = md5(1);
				
			header("Location: index.php?n=$fname&par=$par");
		
			exit();
		
		} else{
		
			$error_msg = "Your selected credentials are incorrect";
		
			header("Location: login.php?err=$error_msg&par=$par");
		
			exit();
		}
	
	
	
}

?>