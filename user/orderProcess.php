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

$insert_product = "UPDATE orderdetail_tbl
INNER JOIN product_tbl ON orderdetail_tbl.p_id = product_tbl.p_id
SET  orderdetail_tbl.od_prodname = product_tbl.p_name
WHERE orderdetail_tbl.p_id = product_tbl.p_id;";

$insert_product_db = mysqli_query($db_connection, $insert_product) or die (mysqli_error($db_connection));

$insert_client = "UPDATE orderdetail_tbl
INNER JOIN client_tbl ON orderdetail_tbl.c_id = client_tbl.c_id
SET  orderdetail_tbl.od_clientname = client_tbl.c_fname
WHERE orderdetail_tbl.c_id = client_tbl.c_id;";

$insert_client_db = mysqli_query($db_connection, $insert_client) or die (mysqli_error($db_connection));
	
	$success_msg = "Your order has been Process. Please wait while the rest of the table has confirmed their order.";
	
    header("Location: confirmation.php?succ=$success_msg");

}else{
	
	$error_msg="update failed";	
	header("Location: confirmation.php?err=$error_msg");
}
	
}

?>