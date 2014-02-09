<?PHP
session_start();

if(!isset($_SESSION['email']))
{
	
	$par = md5(1);

    header("Location: login.php");
    exit();
}else{
	$email = $_SESSION['email'];
	$fname = $_SESSION['fname'];	
}

if ($_GET['par'] = md5(2)){

	$error_msg = $_GET['err'];

} else{
	$error_msg = "";
	$user_msg = "Use your given loging credencials to log into the user controller";	
}
?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<?php include_once("head.php") ;?>
<body>

<div class="gridContainer clearfix">

  <div id="Header"><?php include_once("header1.php");?></div>
  
  <div id="heading"><h2>User Controller</h2></div>
    <div class="titles"><h3>User Homepage</h3></div>
	<?php echo $error_msg;?> <?php echo $user_msg; ?>  
  
	<div id="Navigation">
		<ul id="navList">
		<a id="nav1" href="neworder.php?cat=1"><li>View Menu</li></a>
        <a id="nav1" href="neworder.php?cat=14"><li>View Table Order</li></a>
        <a id="nav1" href="orderhistory.php"><li>Order Hisotry</li></a>
        <a id="nav1" href="reviews.php"><li>Reviews</li></a>
        <a id="nav1" href="share.php"><li>share</li></a>	
        <a id="nav2" href="logout.php"><li>Close</li></a>	
	  </ul>
  </div>
  		
  <div id="footer"><?php include_once("footer1.php");?></div>
</div>
</body>
</html>