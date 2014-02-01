<?php
session_start();

if(!isset($_SESSION['email']))
{
	$error_msg = "user not found";

    header("Location: index.php?err=$error_msg");
    exit();
}
if(isset($_POST['complete'])=='imcomplete'){
	
	include_once("db_connect.php");
	
	$crt_sess = $_POST['crt_sess'];
	$activation = $_POST['activation'];
	$activateorderid = $_POST['activateorderid'];
	$c_id = $_POST['c_id'];

$cart_update = "UPDATE cart_tbl SET tab_process = 'Complete' WHERE o_id= '$activateorderid' AND o_activation = '$activation'";
	
$get_order_update_db = mysqli_query($db_connection, $cart_update) or die (mysqli_error($db_connection));


$order_update = "UPDATE order_tbl SET o_process = 'Order Taken', o_active = '1' WHERE o_id= '$activateorderid' AND o_activation = '$activation'";
	
$get_order_update_db = mysqli_query($db_connection, $order_update) or die (mysqli_error($db_connection));


if ($get_order_update_db){


$sql_copy_order = "INSERT orderdetail_tbl(o_id, c_id, p_id, pc_id, od_quantity, od_price, od_sum, od_session)
					 SELECT o_id, c_id, p_id, pc_id, crt_qt,crt_price, crt_sum, crt_sess FROM cart_tbl
					WHERE cart_tbl.crt_sess ='$crt_sess' AND cart_tbl.o_id = '$activateorderid' AND cart_tbl.tab_process = 'Complete'";

$sql_copy_order_db = mysqli_query($db_connection, $sql_copy_order) or die (mysqli_error($db_connection));

$insert_product = "INSERT orderdetail_tbl(od_prodname)
					 SELECT p_name FROM product_tbl
					WHERE orderdetail_tbl.crt_sess ='$crt_sess' AND orderdetail_tbl.o_id = '$activateorderid'";

$insert_product_db = mysqli_query($db_connection, $insert_product) or die (mysqli_error($db_connection));

$insert_client = "INSERT orderdetail_tbl(od_clientname)
					 SELECT c_fname FROM product_tbl
					WHERE orderdetail_tbl.crt_sess ='$crt_sess' AND orderdetail_tbl.o_id = '$activateorderid'";

$insert_client_db = mysqli_query($db_connection, $insert_client) or die (mysqli_error($db_connection));
	


}else{
	
	$error_msg="update failed";	
}


	
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

 	<div id="Header"><?php include_once("header.php");?></div>  
  	<div id="heading"><h2>Welcome <?php echo $username;?></h2></div>
    
    <div class="title">Confirmation</div>

  		
  <div id="footer"><?php include_once("footer.php");?></div>
</div>
</body>
</html>