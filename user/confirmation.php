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

$crt_sess = $_SESSION['crt_sess'];

  include_once("db_connect.php");
  $find_items_qry = "SELECT od_prodname, od_quantity FROM orderdetail_tbl WHERE od_session = '$crt_sess'";
  $get_order_items = mysqli_query($db_connection, $find_items_qry) or die (mysqli_error($db_connection));

$display_order = "";

  while ($order = mysqli_fetch_assoc($get_order_items)) {
      
      $od_prodname = $order['od_prodname'];
      $od_quantity = $order['od_quantity'];

      $display_order .= '

            <div class="display_order_tbl">
              <div class="prod_quant_conf">'.$od_quantity.' x </div>

              <div class="prod_name_conf">'.$od_prodname.'</div> 
            </div>
      ';

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
      <h3>Welcome <span class="username"><?php echo $username;?></span> <a href="index.php"> <img src="../Images/home.png"> </a> </h3>
    </div>
  </div>  
    
    <div id="main_content">
 
      <div class="title">
        <h2>Confirmation</h2>
      </div>
      <?php echo $error_msg; ?> 
      <div class="success_order">
      <?php echo $success_msg; ?>
      </div>

      <div class="display_order">
      <h2> Your order is displayed below </h2>

      <?php echo $display_order; ?>

      </div>

    </div>  


  		
  <div id="footer"><?php include_once("footer1.php");?></div>
</div>
</body>
</html>