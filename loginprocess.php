<?php
session_start();

//error_reporting(E_ALL | E_WARNING | E_NOTICE);
//ini_set('display_errors', TRUE);

$par = md5(2);

if(isset($_POST['username']))
{
	$username = stripslashes($_POST['username']);
	$password = stripslashes($_POST['password']);
	$username = strip_tags($username);
	$password = strip_tags($password );	
	
	if((!$username)||(!$password)){
	
	$error_msg = "Please complete all manditory fields! <br>";	
		
		if(!$username){
			
			$error_msg .= "Username is missing";
				
		} else if (!$password){
		
			$error_msg .= "Password is missing";
			
		//} else if(!eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z-0-9-]+)*(\.[a-z]{2,4})$", $username)){
			
		///	$error_msg .= "Email has be in a valid email format";
			
		}
		
	$par = md5(2);
	
	header("Location: index.php?err=$error_msg&par=$par");
	exit();
	} else{
		
	include_once ("db_connect.php");

	$username = mysqli_real_escape_string($db_connection, $username);
	$password = mysqli_real_escape_string($db_connection, $password);
	
	$retrieve_salt = "SELECT u_salt FROM user_tbl WHERE u_name = '$username'";
	
	$retrieve_salt_db = mysqli_query($db_connection, $retrieve_salt) or die (mysqli_error($db_connection));
	
	$salt_check = mysqli_num_rows($retrieve_salt_db);
	
	
	if ($salt_check > 0){
	
		while($db_salt = mysqli_fetch_array($retrieve_salt_db)){
			
		$user_salt = $db_salt["u_salt"];
			
		}
		
	$password = md5($password .$user_salt);
	
	$password = md5($password);
			
	mysqli_free_result($retrieve_salt_db);
	
	$check_user = "SELECT * FROM user_tbl WHERE u_name = '$username' AND u_identifier = '$password'";
	
	$check_user_db = mysqli_query($db_connection, $check_user) or die (mysqli_error($db_connection));
	
	$user_check = mysqli_num_rows($check_user_db);

		if ($user_check > 0){
	
			while($user = mysqli_fetch_array($check_user_db)){
			
				$u_id = $user["u_id"];
				$_SESSION['u_id'] = $u_id;
				$username = $user["u_name"];
				$_SESSION['username'] = $username;
				$u_type = $user["u_type"];
				$_SESSION['u_type'] = $u_type;
			
			}
		
			mysqli_free_result($check_user_db);

			$par = md5(1);
				
			header("Location: maincontroller.php?n=$username&par=$par");
		
			exit();
		
		} else{
		
			$error_msg = "Your selected credentials are incorrect";
		
			header("Location: index.php?err=$error_msg&par=$par");
		
			exit();
		}
		
	} else {
		
		echo "Essencial loging information not found. Contact site administrator";	
			
		$error_msg = "Essencial loging information not found. Contact site administrator";
		
		header("Location: index.php?err=$error_msg&par=$par");
		
		exit();
	}
	
	} 
	
} else{
		
	$error_msg = "Please login with your credentials";
	
	header("Location: index.php?err=$error_msg&par=$par");
	
	exit();
}
?>