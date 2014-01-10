<?php
session_start();

if(!isset($_SESSION['username'])){
	
	$error_msg="Unauthorised Access";
    header("Location: maincontroller.php?err=$error_msg");
	exit();
}

$access= md5(3);
	
if ($_GET['par']== $access) {
	
	$username = $_SESSION['username'];
	
	include_once ("db_connect.php");

	// /*
	$create_NO = 'INSERT INTO order_tbl (c_id, o_type, o_date, o_time, o_payment, o_process)
									VALUES (1, "Dine In", CURDATE(),NOW(), "Not Paid", "Arrived")';
	
	mysqli_query($db_connection, $create_NO) or die (mysqli_error($db_connection));
	
	$order_id = mysqli_insert_id($db_connection)or die (mysqli_error($db_connection));
	 // */
	
	$par=md5(10);

} else{

	$error_msg="Access code missing, please follow the guidelines set";
    header("Location: maincontroller.php?err=$error_msg");
	exit();
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
<link href="CSS/boilerplate.css" rel="stylesheet" type="text/css">
<link href="CSS/Main.css" rel="stylesheet" type="text/css">

<script src="Script/respond.min.js"></script>
</head>
<body>
<div class="gridContainer clearfix">

  <div id="Header">Gaylord Logo </div>
  <div id="heading">Welcome <?php echo $username;?></div>
  <div id="pagetitle">New Order</div>

  <div id="mainbody">

   <div id="orderno">Order Number #<span class="redbold"><?php echo $order_id;?>345</span></div>
  
<form action="neworderprocessed.php?par=<?php echo $par;?>" method="post" target="_self">
 
  <select class="dropdown1" name="guestno" > 
    <option value="">select guest no</option>
	<option value="1">1 guest</option>
    <option value="2">2 guest</option>
    <option value="3">3 guest</option>
    <option value="4">4 guest</option>
    <option value="5">5 guest</option>
    <option value="6">6 guest</option>
  	<option value="7">7 guest</option>
    <option value="8">8 guest</option>
    <option value="9">9 guest</option>
    <option value="10">10 guest</option>
   	<option value="11">11 guest</option>
    <option value="12">12 guest</option>
    <option value="13">13 guest</option>
    <option value="14">14 guest</option>
    <option value="15">15 guest</option>
    <option value="16">16 guest</option>
  	<option value="17">17 guest</option>
    <option value="18">18 guest</option>
    <option value="19">19 guest</option>
    <option value="20">20 guest</option>
  </select><br>
  
  <select class="dropdown1" name="tableno"> 
    <option value="">select table no</option>
    <option value="1">table 1</option>
    <option value="2">table 2</option>
    <option value="3">table 3</option>
    <option value="4">table 4</option>
    <option value="5">table 5</option>
    <option value="6">table 6</option>
  	<option value="7">table 7</option>
    <option value="8">table 8</option>
    <option value="9">table 9</option>
    <option value="10">table 10</option>
  </select><br>
  
  <input name="orderid" type="hidden" value="<?php echo $order_id;?>">
  <p>Create the order</p>
  <input class="btngo1" align="middle" name="create" type="submit" value="Create">

  <p>Cancel the order and return to the menu</p>
  
  <input class="btnstp1" name="cancel" type="submit" value="Cancel">

  
  </form>
	

  		
  </div>
  <div id="footer">A Pummello Designed & Developed Product</div>
</div>
</body>
</html>