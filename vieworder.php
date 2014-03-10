<?PHP
session_start();
	
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$error_msg = ""; 
$success_msg = "";	
$username = $_SESSION['username'];
//To be used for load more function, in the future
$item_per_page = 5;
	
if(isset($_GET['err'])){

	$error_msg = $_GET['err'];
	$success = "";
} else if(isset($_GET['succ'])){
	$error_msg = "";
	$success = $_GET['err'];
}else{
	$error_msg = "";
	$success = "";	
}
	
	
if(!isset($_SESSION['username'])){
	
	$error_msg = "";
    header("Location: index.php?err=$error_msg");
    exit();
	
}else if(isset($_POST['update'])){
	
	$process = stripslashes($_POST['process']);
	$payment = stripslashes($_POST['payment']);
	$paymenttype = stripslashes($_POST['paymenttype']);
	$orderid = stripslashes($_POST['orderid']);	
	$total = stripslashes($_POST['total']);	
	
	$total = strip_tags($_POST['total']);
	$process = strip_tags($_POST['process']);
	$payment = strip_tags($_POST['payment']);	
	$paymenttype = strip_tags($_POST['paymenttype']);	
	$orderid = strip_tags($_POST['orderid']);	
	
	if($paymenttype == "Both"){
		
	$SplitCash = stripslashes($_POST['SplitCash']);	
	$SplitCard = stripslashes($_POST['SplitCard']);	
	
	$SplitCash = strip_tags($_POST['SplitCash']);
	$SplitCard = strip_tags($_POST['SplitCard']);
	
		if((!$SplitCash)||(!$SplitCard)){
		
		$error_msg = 'Please enter the payment split for order reference: '.$orderid.' <br>';
		header("Location: vieworder.php?err=$error_msg");
		exit();
		}else{
			include_once ("db_connect.php");
			
			$sql_insert_split = "INSERT INTO paymentSplit_tbl(o_id, ps_card, ps_cash, ps_total)
						 VALUES ($orderid, $SplitCard, $SplitCash, $total)";
	
			$sql_insert_split_db = mysqli_query($db_connection, $sql_insert_split) or die (mysqli_error($db_connection));
			
		}
	}
	
	
	include_once ("db_connect.php");
		
		$update_orderid = "UPDATE order_tbl SET o_process='$process', o_payment='$payment', o_paymentType='$paymenttype' 
							WHERE o_id='$orderid' AND o_active='1'";
		
		$update_order_db = mysqli_query($db_connection, $update_orderid) or die (mysqli_error($db_connection));
		
	//	mysqli_free_result($update_orderid_db);

		$update_check = mysqli_num_rows($update_order_db);
	
		if($update_check !=""){
		
		$success_msg = "Updated";
			
		} else{
		
		$error_msg = "Not Updated ";	
		
		}	
		
} else if(isset($_POST['deactivate'])){
	
	$orderid = stripslashes($_POST['orderid']);	
	$orderid = strip_tags($_POST['orderid']);	
	
	
	include_once ("db_connect.php");
		
		$deactivate_orderid = "UPDATE order_tbl SET  o_active='0' WHERE o_id='$orderid'";
		
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
		
		$activate_orderid = "UPDATE order_tbl SET  o_active='1' WHERE o_id='$orderid'";
		
		$activate_order_db = mysqli_query($db_connection, $activate_orderid) or die (mysqli_error($db_connection));
		
		mysqli_free_result($activate_order_db);

		$activate_check = mysqli_num_rows($activate_order_db);
	
		if($activate_check){
		
		$success_msg = "Activated";
			
		} else{
		
		$error_msg = "Activation Failed";	
		
		}
	
} 

if($_POST['filtercondition'] == 7){
		
	$filtercondition_qry	="";
	$filtercondition = "ALL (Selected)";
	
	}else if($_POST['filtercondition'] == 2){
		
	$filtercondition_qry	="WHERE o_active = '0'";
	$filtercondition = "Not Active (Selected)";

	}else if($_POST['filtercondition'] == 3){
	
	$filtercondition_qry ='WHERE o_payment = "Not Paid"';
	$filtercondition = "Not Paid (Selected)";
	
	}else if($_POST['filtercondition'] == 4){
	
	$filtercondition_qry ='WHERE o_payment = "Paid"';
	$filtercondition = "Paid (Selected)";
	
	}else if($_POST['filtercondition'] == 5){
	
	$filtercondition_qry ='WHERE o_process = "Complete"';
	$filtercondition = "Complete (Selected)";
	
	}else if($_POST['filtercondition'] == 6){
	
	$filtercondition_qry ='WHERE o_process = "Payment"';
	$filtercondition = "Payment (Selected)";

	}else{
	
	$filtercondition_qry ="WHERE o_active = '1'";
	$filtercondition = "Active Order (Selected)";
	}

		
		include_once ("db_connect.php");

		$display_order = 'SELECT * FROM order_tbl  '.$filtercondition_qry.'';
		//$display_order = 'SELECT * FROM order_tbl INNER JOIN paymentSplit_tbl ON order_tbl.o_id = paymentSplit_tbl.o_id  '.$filtercondition_qry.'';

		$display_order_db = mysqli_query($db_connection, $display_order) or die (mysqli_error($db_connection));
		
		$display_check = mysqli_num_rows($display_order_db);
		
		$filtercondition .=" " .$display_check ." orders found";
			
		$total_pages = ceil($display_check[0]/$item_per_page);
		

			if ($display_check > 0){ //gather information from database
		
				while($order = mysqli_fetch_array($display_order_db)){
				
					$orderid = $order["o_id"];
					$process = $order["o_process"];
					$payment = $order["o_payment"];
					$o_activation = $order["o_activation"];
					$paymenttype = $order["o_paymentType"];
					$total = $order["o_total"];
					$o_date = $order["o_date"];
					$o_date = date("d-m-Y", strtotime($o_date));
					$o_time = $order["o_time"];
					$o_active = $order["o_active"];
					
					
					$display_orderSplit = 'SELECT * FROM paymentSplit_tbl WHERE o_id = '.$orderid.'';
					$display_orderSplit_db = mysqli_query($db_connection, $display_orderSplit) or die (mysqli_error($db_connection));

				while($splitRow = mysqli_fetch_array($display_orderSplit_db)){

					$ps_cash = $splitRow["ps_cash"];
					$ps_card = $splitRow["ps_card"];
					$ps_total = $splitRow["ps_total"];
				}
				
				if($ps_cash == 0.00){
					$ps_cash = "";
					$ps_card = "";
				} else if($ps_card == 0.00){
					$ps_cash = "";
					$ps_card = "";	
				}
				
			if($o_active == 1){
				
				$activation_btn ='
				<div class="cancel_button">
				<input name="deactivate" class="" type="submit" value="Deactivate">
				</div>';
				
			}else if($o_active == 0){
				
				$activation_btn ='
				<div class="continue_button">
				<input name="activate" class="" type="submit" value="Activate">
				</div>';

			}

$checkTablet = 'SELECT * FROM tabletactivate_tbl LEFT JOIN orderdetail_tbl ON orderdetail_tbl.od_session = tabletactivate_tbl.tab_sess
					WHERE tabletactivate_tbl.o_id = '.$orderid.' AND orderdetail_tbl.od_session IS NULL';
	
		$usuage_checkTablet_db = mysqli_query($db_connection, $checkTablet) or die (mysqli_error($db_connection));
		
		$tablet_count = mysqli_num_rows($usuage_checkTablet_db);


 		if ($tablet_count !=""){
		
		$tableorder	= "No. User still ordering";
		
		} else{
		
		$tableorder	= "Yes. Table Have submited there order";

		}



			$orderDisplay .='
<div class="orderholder">
    <form action="vieworder.php" method="post" name="orderform" target="_self">
        <div class="ol_title"><a href="displayorder.php?ac='.$o_activation.'&cat=14">View order <span> '.$o_activation.' <span></a></div>
<div id="order_information">	

        <div id="ol_content_container">
	        <div class="ol_content">Order ID</div>
	        <div class="order_id_ol_content ol_pulled_content">'. $orderid.'</div>

	        <div class="ol_content">Date / Time</div>
	        <div class="order_date_ol_content ol_pulled_content">'. $o_date.'  at '. $o_time.'</div>

	        <div class="ol_content">Total</div>
	        <div class="order_total_ol_content ol_pulled_content">&pound;' .number_format ($total, 2). '</div>
			
			<div class="ol_content">Table Order Complete</div>
	        <div class="order_total_ol_content ol_pulled_content">'.$tableorder.'</div>
        </div>
</div>
  	<div class="filter_selection_actions">
        <div class="ol_content">Order process</div>	
        <select class="process" name="process"> 
                <option value="'.$process.'">'.$process.'</option>
                <option value="Arrived">Arrived</option>
                <option value="Order Take">Order Taken</option>
                <option value="In Kitchen">In Kitchen</option>
                <option value="Serving">Serving</option>
                <option value="Service Finished">Service Finished</option>
                <option value="Payment">Payment</option>
                <option value="Complete">Complete</option>
            </select> 
        <div class="ol_content">Payment (Paid/ Not Paid)</div>	           
        <select class="payment" name="payment"> 
                <option value="'.$payment.'">'.$payment.'</option>
                <option value="Paid">Paid</option>
        </select> 
        <div class="ol_content">Payment Type</div>	           	
            <select class="paymenttype" name="paymenttype"> 
                <option value="'.$paymenttype.'">'.$paymenttype.'</option>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="Both">Both</option>
            </select>   
       <div class="ol_content">Payment Split</div>	           	
		<input name="SplitCash" type="text" value="' .number_format ($ps_cash, 2). '" placeholder="Cash Split Amount"><input name="SplitCard" type="text" value="' .number_format ($ps_card, 2). '" placeholder="Card Split Amount">

         <input name="orderid"  type="hidden" value="'. $orderid.'">
		 <input name="total"  type="hidden" value="'. $total.'">

     
    </div>
    <div class="clear"></div>
		<div class="buttons_vieworder">
            <div class="update_button">
			<input name="update" class="update" type="submit" value="Update">
			</div>
            '. $activation_btn.'
			
        </div>
    
    </form>
    </div>
			';


			}
}
?>
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<?php include_once("head.php");?>
<script type="text/javascript">
    $(document).bind('mobileinit', function() {
        $.extend($.mobile, {
            hashListeningEnabled: false,
            pushStateEnabled: false,
            ajaxEnabled: false,
            linkBindingEnabled: false
        });
    });
</script>
<script type="text/javascript" src="Script/jquery.mobile-1.4.0.min.js"></script>

<body>
<div class="gridContainer clearfix">

  <div id="Header"><?php include_once("header.php");?>     
    <div id="heading">
      <h3>Welcome <?php echo $username;?> <a href="maincontroller.php"> <img src="Images/home.png"> </a> </h3>
   	</div>
  </div>  
    
    <div id="main_content">
 
      <div class="title">
        <h2>View Order</h2>
      </div>
      
      <div id="orderfilter">
    	<p> Order Filter: </p>
    	<form action="vieworder.php" method="post" target="_self">
  			<div class="styled-select">
            <select class="filter_selected" name="filtercondition"> 
                <option value="<?php echo $filtercondition;?>" selected><?php echo $filtercondition;?></option>
                <option value="1">Active Order (Default)</option>
                <option value="2">Not Active</option>
                <option value="3">Not Paid</option>
                <option value="4">Paid</option>
                <option value="5">Complete</option>
                <option value="6">Payment</option>
                <option value="7">All</option>

            </select>  
            </div>
	        	  <div class="continue_button">
            	  <input class="filter_continue" name="filter" type="submit" value="Apply Filter">   
            	</div>
            </form>
            
            <?php echo $error_msg;?> <?php $success_msg; ?>
  </div>


     <!-- End Main Content -->
<?php echo $orderDisplay;?>

    </div>
 
  <div id="footer"><?php include_once("footer.php");?></div>
</div>
</body>
</html>