<?PHP
session_start();

if(!isset($_SESSION['username']))
{
		
	$par = md5(1);

    header("Location: login.php?n=$username&par=$par");
    exit();
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
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gaylord</title>
<link href="../CSS/boilerplate.css" rel="stylesheet" type="text/css">
<link href="../CSS/userMain.css" rel="stylesheet" type="text/css">

<script src="../Script/respond.min.js"></script>
</head>
<body>
<div class="gridContainer clearfix">

  <div id="Header">Gaylord Logo </div>
  <div id="heading">Gaylord Navigation Menu</div>
  <div id="mainbody">
  
	<div id="Navigation">
		<ul id="navList">
		<a id="nav1" href="neworder.php?par=<?php echo $par;?>"><li>View Menu</li></a>
        <a id="nav1" href="vieworder.php?par=<?php echo $par;?>"><li>View Table Order</li></a>
        <a id="nav1" href="orderhistory.php?par=<?php echo $par?>"><li>Order Hisotry</li></a>
        <a id="nav1" href="reviews.php?par=<?php echo $par;?>"><li>Reviews</li></a>
        <a id="nav1" href="share.php?par=<?php echo $par;?>"><li>share</li></a>	
        <a id="nav2" href="logout.php"><li>Close</li></a>	
	  </ul>
  </div>
  		
  </div>
  <div id="footer">A Pummello Designed & Developed Product</div>
</div>
</body>
</html>