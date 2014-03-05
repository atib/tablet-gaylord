<?php
session_start();

$username = $_SESSION['fname'];

if(!isset($_SESSION['email']))
{
	$error_msg = "user not found";

    header("Location: index.php?err=$error_msg");
    exit();
}

if (isset($_GET['err'])){
	$error_msg = $_GET['err'];
	$success_msg = "";
} else if(isset($_GET['succ'])){
	$success_msg = $_GET['succ'];
	$error_msg = "";
}

?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<?php include_once('head.php'); ?>
<body>
<div class="gridContainer clearfix">

 	<div id="Header"><?php include_once("header1.php");?>     
    <div id="heading">
      <h3>Welcome <?php echo $username;?> <a href="maincontroller.php"> <img src="../Images/home.png"> </a> </h3>
    </div>
  </div>  
    
    <div id="main_content">
 
      <div class="title">
        <h2>Confirmation</h2>
      </div>
            <?php echo $error_msg; ?> <?php echo $success_msg; ?>
    </div>      

  		
  <div id="footer"><?php include_once("footer1.php");?></div>
</div>
</body>
</html>