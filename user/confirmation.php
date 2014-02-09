<?php
session_start();

if(!isset($_SESSION['email']))
{
	$error_msg = "user not found";

    header("Location: index.php?err=$error_msg");
    exit();
}

if (isset($_GET['err'])){
	$error_msg = $_GET['err'];
} else if(isset($_GET['succ'])){
	$success_msg=$_GET['succ'];
}

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
<link href="CSS/Main.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="gridContainer clearfix">

 	<div id="Header"><?php include_once("header1.php");?></div>  
  	<div id="heading"><h2>Welcome <?php echo $username;?></h2></div>
    
    <div class="title">Confirmation</div>
            <?php echo $error_msg; ?> <?php echo $success_msg; ?>

  		
  <div id="footer"><?php include_once("footer1.php");?></div>
</div>
</body>
</html>