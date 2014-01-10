<?PHP
session_start();

ini_set('error_reporting', version_compare(PHP_VERSION,5,'>=') && version_compare(PHP_VERSION,6,'<') ?E_ALL^E_STRICT:E_ALL);
	
$error_msg = ""; 
$success_msg = "";	
	
if(!isset($_SESSION['username'])){
	
	$error_msg = "";
    header("Location: index.php?err=$error_msg");
    exit();
	
}else if(isset($_POST['update'])){
	
	$process = stripslashes($_POST['process']);
	$payment = stripslashes($_POST['payment']);
	$paymenttype = stripslashes($_POST['paymenttype']);
	$orderid = stripslashes($_POST['orderid']);	
	
	$process = strip_tags($_POST['process']);
	$payment = strip_tags($_POST['payment']);	
	$paymenttype = strip_tags($_POST['paymenttype']);	
	$orderid = strip_tags($_POST['orderid']);	
	
	include_once ("db_connect.php");
		
		$update_orderid = "UPDATE order_tbl SET o_process='$process', o_payment='$payment', o_paymentType='$paymenttype' 
							WHERE o_id='$orderid' AND o_active=1";
		
		$update_order_db = mysqli_query($db_connection, $update_orderid) or die (mysqli_error($db_connection));
		
		mysqli_free_result($update_orderid_db);

		$update_check = mysqli_num_rows($update_order_db);
	
		if($update_check){
		
		$success_msg = "Updated";
			
		} else{
		
		$error_msg = "Not Updated ";	
		
		}	
		
} else if(isset($_POST['deactivate'])){
	
	$orderid = stripslashes($_POST['orderid']);	
	$orderid = strip_tags($_POST['orderid']);	
	
	
	include_once ("db_connect.php");
		
		$deactivate_orderid = "UPDATE order_tbl SET  o_active=0 WHERE o_id='$orderid'";
		
		$deactivate_order_db = mysqli_query($db_connection, $deactivate_orderid) or die (mysqli_error($db_connection));
		
		mysqli_free_result($deactivate_order_db);

		$deactivate_check = mysqli_num_rows($deactivate_order_db);
	
		if($deactivate_check){
		
		$success_msg = "Deactivated";
			
		} else{
		
		$error_msg = "Deactivation Failed";	
		
		}
	

	
} else if(isset($_POST['activate'])){
	
	$orderid = stripslashes($_POST['orderid']);	
	$orderid = strip_tags($_POST['orderid']);	

include_once ("db_connect.php");
		
		$activate_orderid = "UPDATE order_tbl SET  o_active=1 WHERE o_id='$orderid'";
		
		$activate_order_db = mysqli_query($db_connection, $activate_orderid) or die (mysqli_error($db_connection));
		
		mysqli_free_result($activate_order_db);

		$activate_check = mysqli_num_rows($activate_order_db);
	
		if($activate_check){
		
		$success_msg = "Activated";
			
		} else{
		
		$error_msg = "Activation Failed";	
		
		}
	
} 

if($_POST['filtercondition'] == 1){
		
	$filterconditon_qry	='WHERE o_active = 1';
	$filterconditon = "Active Order (Default)";
	
	}else if($_POST['filtercondition'] == 2){
		
	$filterconditon_qry	="WHERE o_active = 0";
	$filterconditon = "Not Active";

	}else if($_POST['filtercondition'] == 3){
	
	$filterconditon_qry	='WHERE o_payment = "Not Paid"';
	$filterconditon = "Not Paid";

	}else{
	
	$filterconditon_qry	="";
	$filterconditon = "ALL";

	}

		
		include_once ("db_connect.php");

		$display_order = 'SELECT * FROM order_tbl '.$filterconditon_qry.'';
	
		$display_order_db = mysqli_query($db_connection, $display_order) or die (mysqli_error($db_connection));
		
		$display_check = mysqli_num_rows($display_order_db);
			
			echo $display_check;			
	
			if ($display_check > 0){ //gather information from database
		
				while($order = mysqli_fetch_array($display_order_db)){
				
					$orderid = $order["o_id"];
					$process = $order["o_process"];
					$payment = $order["o_payment"];
					$o_activation = $order["o_activation"];
					$paymenttype = $order["o_paymentType"];
					$total = $order["o_total"];
					$o_datetime = $order["o_datetime"];
					$o_active = $order["o_active"];

			if($o_active == 1){
				
				$activation_btn ='<input name="deactivate" type="submit" value="Deactivate">';
				
			}else if($o_active == 0){
				
				$activation_btn ='<input name="activate" type="submit" value="Activate">';

			}



			$orderDisplay .='
			  <div class="orderholder">
    <form action="vieworder.php" method="post" name="orderform" target="_self">
        <div class="ol_title"><a href="#">View '.$o_activation.'</a></div>
        <div class="ol_content">Order ID: '. $orderid.'</div>
        <div class="ol_content">Date/Time'. $datetime.'</div>
       <div class="ol_content">Total'. $total.'</div>
        
        <div class="ol_contentfrm">            
        <select class="dropdown1" name="process"> 
                <option value="'.$process.'">'.$process.'</option>
                <option value="Arrived">Arrived</option>
                <option value="Order Take">Order Taken</option>
                <option value="In Kitchen">In Kitchen</option>
                <option value="Serving">Serving</option>
                <option value="Service Finished">Service Finished</option>
                <option value="Payment">Payment</option>
                <option value="Complete">Complete</option>
            </select> 
        </div>
            
        <div class="ol_contentfrm">            
        <select class="dropdown1" name="payment"> 
                <option value="'.$payment.'">'.$payment.'</option>
                <option value="Not Paid">Not Paid</option>
                <option value="Paid">Paid</option>
        </select> 
        </div>
        
        <div class="ol_contentfrm">
            <select class="dropdown1" name="paymenttype"> 
                <option value="'.$paymenttype.'">'.$paymenttype.'</option>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="Both">Both</option>
            </select>        
        </div>        
		  
        <div class="ol_content">   
      		<input name="orderid" type="hidden" value="'. $orderid.'">
            '. $activation_btn.'
        </div>
        <div class="ol_content"></div>
        <div class="ol_content"><input name="update" type="submit" value="Update"></div>
    
    </form>
    </div>
			';


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
<link href="CSS/boilerplate.css" rel="stylesheet" type="text/css">
<link href="CSS/Main.css" rel="stylesheet" type="text/css">

<script src="Script/respond.min.js"></script>
</head>
<body>
<div class="gridContainer clearfix">

  <div id="Header">Gaylord Logo </div>
  <div id="heading">Master Controller</div>
  <div id="mainbody">
  
    <div id="orderlist">
    <div id="orderfilter">Order Filter: <form action="vieworder.php" method="post" target="_self">
  			<select class="dropdown1" name="filtercondition"> 
                <option value="<?php echo $filtercondition;?>" selected><?php echo $filtercondition;?></option>
                <option value="1">Active Order (Default)</option>
                <option value="2">Not Active</option>
                <option value="3">Not Paid</option>
                <option value="">All</option>

            </select>  
            
            <input name="filter" type="submit" value="Apply Filter">   
            </form>
            
            <?php echo $error_msg; $success_msg; ?>
  </div>
<?php echo $orderDisplay;?>
    
    </div>
    
  </div>
  <div id="footer">A Pummello Designed & Developed Product</div>
</div>
</body>
</html>