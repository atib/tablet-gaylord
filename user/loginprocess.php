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
		
	header("Location: login.php?err=$error_msg");
		
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
			
	header("Location: login.php?err=$error_msg");
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
	include_once ("db_connect.php");

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
				
			header("Location: index.php?n=$fname");
		
			exit();
		
		} else{
		
			$error_msg = "Your selected credentials are incorrect";
		
			header("Location: login.php?err=$error_msg");
		
			exit();
		}
		
	} else {
					
		$error_msg = "Your selected credentials are incorrect";
		
		header("Location: login.php?err=$error_msg");
		
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
		
			header("Location: login.php?err=$error_msg");
		
			exit();
		}
	
	
	
}

if(isset($_POST['register'])){
	
	$c_fname = stripslashes($_POST['c_fname']);
	$c_lname = stripslashes($_POST['c_lname']);
	$c_address1 = stripslashes($_POST['c_address1']);
	$c_town = stripslashes($_POST['c_town']);
	$c_postcode = stripslashes($_POST['c_postcode']);
	$c_mobile = stripslashes($_POST['c_mobile']);
	$c_email = stripslashes($_POST['c_email']);
	$c_password = stripslashes($_POST['c_password']);
	$c_password2 = stripslashes($_POST['c_password2']);
	$c_fname = strip_tags($c_fname);	
	$c_lname = strip_tags($c_lname);	
	$c_address1 = strip_tags($c_address1);	
	$c_town = strip_tags($c_town);	
	$c_postcode = strip_tags($c_postcode);	
	$c_mobile = strip_tags($c_mobile);	
	$c_email = strip_tags($c_email);	
	$c_password = strip_tags($c_password);	
	$c_password2 = strip_tags($c_password2);	

	if((!$c_fname)||(!$c_lname)||(!$c_address1)||(!$c_town)||(!$c_postcode)||(!$c_mobile)||(!$c_email)||(!$c_password)||(!$c_password2)){
	
	$error_msg = "Please complete all manditory fields! <br>";	
		
		if(!$c_fname){
			
			$error_msg .= "First Name is missing";
				
		} else if (!$c_lname){
		
			$error_msg .= "Last Name is missing";
			
		} else if (!$c_address1){
		
			$error_msg .= "First Line of Address is missing";
			
		}else if (!$c_town){
		
			$error_msg .= "Town is missing";
			
		}else if (!$c_postcode){
		
			$error_msg .= "Postcode is missing";
			
		}else if (!$c_mobile){
		
			$error_msg .= "Mobile is missing";
			
		}else if (!$c_email){
		
			$error_msg .= "Email is missing";
			
		}else if(!$c_password){
			
			$error_msg .= "Password Missing";
	
		}else if($c_password != $c_password2){
			
			$error_msg .= "Password Do Not Match";
	
		}
			
	header("Location: login.php?err=$error_msg");
	exit();
	} else{
	
    $salt = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
    
	$password1 = md5($c_password .$salt);
	
	$password = md5($password1);	
		
	include_once ("db_connect.php");

	$check_user = "SELECT * FROM client_tbl WHERE c_email = '$email' AND c_identifier = '$password'";
	
	$check_user_db = mysqli_query($db_connection, $check_user) or die (mysqli_error($db_connection));
	
	$user_check = mysqli_num_rows($check_user_db);


	if ($user_check ===0){
	
	include_once ("db_connect.php");

	$Insert_user = "INSERT INTO client_tbl (c_fname, c_lname, c_address1, c_town, c_postcode, c_mobile, c_email, c_password, c_salt, c_identifier)
					VALUES ('$c_fname', '$c_lname', '$c_address1', '$c_town', '$c_postcode', '$c_mobile', '$c_email', '$salt', '$password')";
	
	$check_insert_user_db = mysqli_query($db_connection, $Insert_user) or die (mysqli_error($db_connection));
	
	
				$c_id = mysql_insert_id();
				$_SESSION['c_id'] = $c_id;
				$email = $user["c_email"];
				$_SESSION['email'] = $email;
				$fname = $user["c_fname"];
				$_SESSION['fname'] = $fname;
	
/*	

##send email to customer - currently this exposes outside orders. local ip will need to be part of the session check otherwise dont activate

// Start assembly of Email Member the activation link
		$to = "$email";
		// Change this to your site admin email
		$from = "info@lunarwebstudio.com";
		$subject = "Gaylord Account Activation";
		//Begin HTML Email Message where you need to change the activation URL inside
		$message = "Hi $fname,
		You must complete this step to activate your account with us.
		Please click here to activate now";
		$message.="http://www.lunarwebstudio.com/Demos/GaylordTablet/user/activation.php?id=$c_id&sequence=$password1";
		$message.="
		Your Login Data is as follows: 
 	 	_______________________
 		E-mail Address: $email 
 		Password: $c_password
 		_______________________

		Thanks!";
		// end of message
		$headers = "From: $from\r\n";
		$to = "$to";
		// Finally send the activation email to the member
		mail($to, $subject, $message, $headers);
		// Then print a message to the browser for the joiner 
		$success_msg = 'OK '. $firstname .' '.$lastname.', 
		We just sent an Activation link to: '.$email.'
		Please check your email inbox in a moment for the Activation. 
		Link inside the message. Your account is currently set up as a guest account.
		Email can often be sent to the junk mail folder so be sure to check their and dont forget to add us to your 		safelist. You may proceed with your order.';	
	
*/	
	
			header("Location: index.php?n=$fname");
		
			exit();
	
	}	else{
		
		$error_msg = "Sorry we encountered problem inserting your data.Please Try again.";
		
	}
	$error_msg = 'This email is already registered. <a href="#">Click here to reset your password.</a>';

	}
	
	
	
	
}

?>