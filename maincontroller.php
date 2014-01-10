<?php
session_start();

if(!isset($_SESSION['username'])){
	
	$error_msg = "";
    header("Location: index.php?err=$error_msg");
    exit();
	
}

$par=md5(3);
$username = $_SESSION['username'];


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
  <div id="pagetitle">Select An Option</div>
  <div id="mainbody">
  
  <div id="Navigation">
		<ul id="navList">
		<a id="nav1" href="neworder.php?par=<?php print $par;?>"><li>Create Order</li></a>
        <a id="nav1" href="vieworder.php"><li>View Order</li></a>
        <a id="nav1" href="customer.php"><li>Customer</li></a>
        <a id="nav1" href="orderhistory.php"><li>Order Hisotry</li></a>
        <a id="nav1" href="reviews.php"><li>Reviews</li></a>
        <a id="nav1" href="reports.php"><li>Reports</li></a>	
        <a id="nav2" href="logout.php"><li>Logout</li></a>	
	  </ul>
  </div>
	

  		
</div>
  <div id="footer">A Pummello Designed & Developed Product</div>
</div>
</body>
</html>