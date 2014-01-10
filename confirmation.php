<?php
session_start();

if(!isset($_SESSION['username'])){
	
	$error_msg="Unauthorised Access";
    header("Location: maincontroller.php?err=$error_msg");
	exit();
}

	$access=md5(15);
	
if ($_GET['par']== $access) {
	
	$username = $_SESSION['username'];
	
	
	$o_id = $_GET['oid'];
	$o_activation = $_GET["oa"];
	
	$o_id = stripslashes($o_id);
	$o_activation  = stripslashes($o_activation);
	$o_id = strip_tags($o_id);
	$o_activation  = strip_tags($o_activation );	

	$success_msg = "We all good, follow the instruction to activate alias tablet.";
		
	$displayresult='Please use the below activation code to link individual tablet to this order id<br>
		
		'.$o_activation.' <br>

		<a href="maincontroller.php">Back to main menu</a>		
		
		';
	
	
	
	
	
} else{

	$error_msg="Access code missing, please follow the guidelines set";
    header("Location: maincontroller.php?err=$error_msg");
	exit();
}

include_once ("db_connect.php");



?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gaylord</title>
<link href="CSS/boilerplate.css" rel="stylesheet" type="text/css">
<link href="CSS/Main.css" rel="stylesheet" type="text/css">

<script src="Script/respond.min.js"></script>
</head>
<body>
<div class="gridContainer clearfix">

  <div id="Header">Gaylord Logo </div>
  <div id="heading">Welcome <?php echo $username;?></div>
  <div id="pagetitle">New Order Request</div>

  <div id="mainbody">
  
  <?php echo $error_msg; ?>
  <?php echo $success_msg; ?>
   <?php echo $displayresult; ?>
  
	<p>Your request has been processed. Click on main menu button to return to main menu</p>
    
    <p><a href="maincontroller.php">Main Menu</a></p>
  		
  </div>
  <div id="footer">A Pummello Designed & Developed Product</div>
</div>
</body>
</html>