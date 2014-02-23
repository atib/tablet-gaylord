<?PHP
session_start();

//ini_set('error_reporting', version_compare(PHP_VERSION,5,'>=') && version_compare(PHP_VERSION,6,'<') ?E_ALL^E_STRICT:E_ALL);
	
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
	
	$process = strip_tags($_POST['process']);
	$payment = strip_tags($_POST['payment']);	
	$paymenttype = strip_tags($_POST['paymenttype']);	
	$orderid = strip_tags($_POST['orderid']);	
	
	include_once ("db_connect.php");
		
		$update_orderid = "UPDATE order_tbl SET o_process='$process', o_payment='$payment', o_paymentType='$paymenttype' 
							WHERE o_id='$orderid' AND o_active='1'";
		
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

		$display_order = 'SELECT * FROM order_tbl '.$filtercondition_qry.'';
	
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
					$o_datetime = $order["o_datetime"];
					$o_active = $order["o_active"];

			if($o_active == 1){
				
				$activation_btn ='<input name="deactivate" class="button3" type="submit" value="Deactivate">';
				
			}else if($o_active == 0){
				
				$activation_btn ='<input name="activate" class="button3" type="submit" value="Activate">';

			}



			$orderDisplay .='
     <div class="orderholder">
    <form action="vieworder.php" method="post" name="orderform" target="_self">
        <div class="ol_title"><a href="displayorder.php?ac=$o_activation">View '.$o_activation.'</a></div>
        <div id="ol_content_container">
	        <div class="ol_content">Order ID</div>
	        <div class="ol_content">Date / Time</div>
	        <div class="ol_content">Total</div>
	        <div class="ol_content order_id_ol_content">'. $orderid.'</div>
	        <div class="ol_content order_date_ol_content">'. $datetime.'</div>
	        <div class="ol_content order_total_ol_content">'. $total.'</div>
        </div>
  	 <div class="filter_selection_actions">
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
                   
        <select class="payment" name="payment"> 
                <option value="'.$payment.'">'.$payment.'</option>
                <option value="Not Paid">Not Paid</option>
                <option value="Paid">Paid</option>
        </select> 
       
            <select class="paymenttype" name="paymenttype"> 
                <option value="'.$paymenttype.'">'.$paymenttype.'</option>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="Both">Both</option>
            </select>   
         
         <input name="orderid"  type="hidden" value="'. $orderid.'">
     
        </div>        
		<div class="buttons">
            '. $activation_btn.'
			<input name="update" class="update" type="submit" value="Update">
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
<!-- <script type="text/javascript" src="Script/jquery.mobile-1.4.0.min.js"></script> -->

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