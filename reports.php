<?php
session_start();

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

if(!isset($_SESSION['username'])){
	
	$error_msg="Unauthorised Access";
    header("Location: maincontroller.php?err=$error_msg");
	exit();
}

$username = $_SESSION['username'];

if(isset($_GET['err'])){

	$error_msg = $_GET['err'];
	$success = "";
	$msg2user ="";
} else if(isset($_GET['succ'])){
	$error_msg = "";
	$msg2user ="";
	$success = $_GET['succ'];
}else if(isset($_GET['msg'])){
	$error_msg = "";
	$msg2user = $_GET['msg'];
}else{
	$error_msg = "";
	$success = "";	
	$msg2user ="";
}


if (isset($_GET['page'])){
	$page=$_GET['page'];
	
	if ($page == "1"){
	 $pagetitle = "Active Tablet";	
	 $selectpage = $pagetitle;	
	//display all active tablets which the user is currently using
	
	date_default_timezone_set('Europe/London');

	$todaydate = date("y/m/d");
	
	include_once ("db_connect.php");

	$sql_Check_ActiveTablet_list = "SELECT * FROM tabletactivate_tbl WHERE tab_activeDate='$todaydate' AND tab_active = '1'";
	//$sql_activeTablet_list = "SELECT * FROM tabletactivate_tbl WHERE tab_active = '1'";
			
	$get_Check_ActiveTablet_db = mysqli_query($db_connection, $sql_Check_ActiveTablet_list) or die (mysqli_error($db_connection));

	$row_cat_cnt = mysqli_num_rows($get_Check_ActiveTablet_db);

	if ($row_cat_cnt !=""){

	$sql_activeTablet_list = "SELECT * FROM tabletactivate_tbl WHERE tab_activeDate='$todaydate' AND tab_active = '1'";
	//$sql_activeTablet_list = "SELECT * FROM tabletactivate_tbl WHERE tab_active = '1'";
			
	$get_activeTablet_db = mysqli_query($db_connection, $sql_activeTablet_list) or die (mysqli_error($db_connection));
	
	while ($activerow = mysqli_fetch_assoc($get_activeTablet_db)){
		
		$tab_id= $activerow['tab_id'];
		$o_activation = $activerow['o_activation'];
		$o_id = $activerow['o_id'];
		$tab_activeDate = $activerow['tab_activeDate'];
		$tab_activeDate = date("d-m-Y", strtotime($tab_activeDate));
		$tab_sess = $activerow['tab_sess'];
		$tab_order = $activerow['tab_order'];
		$tab_active = $activerow['tab_active'];

		$displayReport .= '
		
		<form action="reports.php?page=1" method="post" name="report_form">
		 <div class="ActiveTabReport">
		 
		<div class="tablet_info_id">

			<div class="activeTabblock">Tablet ID</div>
			<div class="tablet_info ordering">'.$tab_id.'</div>

			<div class="activeTabblock">Order ID</div>
			<div class="tablet_info ">'.$o_id.'</div>


			<div class="activeTabblock">Activation</div>
			<div class="tablet_info">'.$o_activation.'</div>



			<div class="activeTabblock">Tablet Active</div>		 
		 	<div class="tablet_info">'.$tab_active.'</div>
		</div>

		<div class="order_info_tablet">

		  <div class="activeTabblock">Activation Date</div>		
		  <div class="order_info">'.$tab_activeDate.'</div>

 		  <div class="activeTabblock">Tablet Order Process</div>
		  <div class="order_info ordering">'.$tab_order.'</div>


		
		</div> 

		<div class="clear"></div>
		<div class="session_tablet_report">
		  <div class="activeTabblock">Tablet Session</div>
		  <div class="session_tab">'.$tab_sess.'</div>
		</div>
		<div class="clear"></div>

		<div class="collect_tablet">
			<input name="tabID" type="hidden" value="'.$tab_id.'">
			<input name="closeTab" class="" type="submit" value="Tablet Collected">
		</div>
		 
		</div>
		</form>
		';
			
	}
	
		if (isset($_POST['closeTab'])){	
			
		$tabID = $_POST['tabID'];
		include_once("db_connect.php");
		
		$sql_tablestate_call = "SELECT * FROM tabletactivate_tbl WHERE tab_id = '$tabID' AND tab_active = '1'";
		$get_tablestate_db = mysqli_query($db_connection, $sql_tablestate_call) or die (mysqli_error($db_connection));
	
		while ($row = mysqli_fetch_assoc($get_tablestate_db)){

		 $tab_order = $row['tab_order'];
		 $tab_active = $row['tab_active'];
		 $tab_sess = $row['tab_sess'];
			if ($tab_order == "Order Complete" && $tab_active == 0 || $tab_order == "Order Complete" && $tab_active == 1){
				
			
			$deleteTablet = "DELETE FROM tabletactivate_tbl WHERE tab_sess = '$tab_sess'";

			$update_deleteTablet_db = mysqli_query($db_connection, $deleteTablet) or die (mysqli_error($db_connection));
	
			$success_msg = "<h5>Tablet been deactivated</h5>";
	
				
				
				
			}else if ($tab_order == "Ordering" && $tab_active == 1){
			$error_msg = "User is still ordering. If User has finish please deactivate tablet by logging off";
			}
			
		}
		}
		}else{
	$displayReport = '';
	$msg2user = "No Active Tablet"; 
	}

	
	} else if ($page == "2"){
	 $pagetitle = "Todays Active Orders";	
	 $selectpage = $pagetitle;	

	date_default_timezone_set('Europe/London');

	$todaydate = date("y/m/d");
	
	include_once ("db_connect.php");

	$sql_CheckActiveOrder_list = "SELECT * FROM order_tbl WHERE o_date='$todaydate' AND o_active = '1'";
				
	$get_CheckActiveOrder_db = mysqli_query($db_connection, $sql_CheckActiveOrder_list) or die (mysqli_error($db_connection));
	
	$row_cao_cnt = mysqli_num_rows($get_CheckActiveOrder_db);

	if ($row_cao_cnt !=""){
	
	include_once ("db_connect.php");

	$sql_activeOrder_list = "SELECT * FROM order_tbl WHERE o_date='$todaydate' AND o_active = '1'";
				
	$get_activeOrder_db = mysqli_query($db_connection, $sql_activeOrder_list) or die (mysqli_error($db_connection));
	while ($aorow = mysqli_fetch_assoc($get_activeOrder_db)){
		
					$orderid = $aorow["o_id"];
					$process = $aorow["o_process"];
					$payment = $aorow["o_payment"];
					$o_activation = $aorow["o_activation"];
					$paymenttype = $aorow["o_paymentType"];
					$total = $aorow["o_total"];
					$o_date = $aorow["o_date"];
					$o_date = date("d-m-Y", strtotime($o_date));
					$o_time = $aorow["o_time"];
					$o_active = $aorow["o_active"];		
		
		$displayReport .= '
		
		<div class="orderholder order_fix_width">
        <div class="ol_title"><a href="displayorder.php?ac='.$o_activation.'&cat=14">View order <span> '.$o_activation.' <span></a></div>
<div id="order_information">	

        <div id="ol_content_container">
	        <div class="ol_content">Order ID</div>
	        <div class="order_id_ol_content ol_pulled_content">'. $orderid.'</div>

	        <div class="ol_content">Date / Time</div>
	        <div class="order_date_ol_content ol_pulled_content">'. $o_date.'  at '. $o_time.'</div>

	        <div class="ol_content">Total</div>
	        <div class="order_total_ol_content ol_pulled_content">&pound;' .number_format ($total, 2). '</div>
        </div>
</div>
  	<div class="filter_selection_actions">
        <div class="ol_content">Order process</div>	
		<div class="order_OrderProcess_ol_content ol_pulled_content pulled_right_content">'.$process.'</div>

        <div class="ol_content">Payment (Paid/ Not Paid)</div>	 
		<div class="order_Payment_ol_content ol_pulled_content pulled_right_content">'.$payment.'</div>
          
        <div class="ol_content">Payment Type</div>	
		<div class="order_paymenttype_ol_content ol_pulled_content pulled_right_content">'.$paymenttype.'</div> 
              
    </div>
    </div>
		';
	}
	}else{
	$displayReport = '';
	$msg2user = "No Active Orders Today"; 
	}


 	} else if ($page == "3"){
	 $pagetitle = "Todays Closed Orders";	
	 $selectpage = $pagetitle;	
	 	 
	date_default_timezone_set('Europe/London');

	$todaydate = date("y/m/d");
	
	include_once ("db_connect.php");

	$sql_CheckClosedOrder_list = "SELECT * FROM order_tbl WHERE o_date='$todaydate' AND o_process = 'Complete' AND o_active = '2'";
				
	$get_CheckClosedOrder_db = mysqli_query($db_connection, $sql_CheckClosedOrder_list) or die (mysqli_error($db_connection));
	
	$row_cco_cnt = mysqli_num_rows($get_CheckClosedOrder_db);


	if ($row_cco_cnt ===""){
	
	include_once ("db_connect.php");

	$sql_closedOrder_list = "SELECT * FROM order_tbl WHERE o_date='$todaydate' AND o_process = 'Complete' AND o_active = '2'";
				
	$get_closedOrder_db = mysqli_query($db_connection, $sql_closedOrder_list) or die (mysqli_error($db_connection));
		
	while ($corow = mysqli_fetch_assoc($get_closedOrder_db)){
		
					$orderid = $corow["o_id"];
					$process = $corow["o_process"];
					$payment = $corow["o_payment"];
					$o_activation = $corow["o_activation"];
					$paymenttype = $corow["o_paymentType"];
					$total = $corow["o_total"];
					$o_date = $corow["o_date"];
					$o_date = date("d-m-Y", strtotime($o_date));
					$o_time = $corow["o_time"];
					$o_active = $corow["o_active"];		
		
		$displayReport .= '
		
		<div class="orderholder order_fix_width">
        <div class="ol_title"><a href="displayorder.php?ac='.$o_activation.'&cat=14">View order <span> '.$o_activation.' <span></a></div>
<div id="order_information">	

        <div id="ol_content_container">
	        <div class="ol_content">Order ID</div>
	        <div class="order_id_ol_content ol_pulled_content">'. $orderid.'</div>

	        <div class="ol_content">Date / Time</div>
	        <div class="order_date_ol_content ol_pulled_content">'. $o_date.'  at '. $o_time.'</div>

	        <div class="ol_content">Total</div>
	        <div class="order_total_ol_content ol_pulled_content">&pound;' .number_format ($total, 2). '</div>
        </div>
</div>
  	<div class="filter_selection_actions">
        <div class="ol_content">Order process</div>	
		<div class="order_OrderProcess_ol_content ol_pulled_content pulled_right_content">'.$process.'</div>

        <div class="ol_content">Payment (Paid/ Not Paid)</div>	 
		<div class="order_Payment_ol_content ol_pulled_content pulled_right_content">'.$payment.'</div>
          
        <div class="ol_content">Payment Type</div>	
		<div class="order_paymenttype_ol_content ol_pulled_content pulled_right_content">'.$paymenttype.'</div> 
              
    </div>
    <div class="clear"></div>
    
    </div>
	';
	}
	}else{
	$displayReport = '';
	$msg2user = "No Closed Orders"; 
	}
	
			 
	}else if ($page == "4"){
	 $pagetitle = "Cash Up";	
	 $selectpage = $pagetitle;	
	 
	 date_default_timezone_set('Europe/London');

	$todaydate = date("y/m/d");
	
	include_once ("db_connect.php");

	$sql_CheckCashUPSub_list = "SELECT * FROM order_tbl WHERE o_date='$todaydate' AND o_process = 'Complete' AND o_active = '2'";
				
	$get_CheckCashUPSub_db = mysqli_query($db_connection, $sql_CheckCashUPSub_list) or die (mysqli_error($db_connection));
	
	if ($get_CheckCashUPSub_db !=""){
	
	include_once ("db_connect.php");

	$sql_CheckCashUP_list = "SELECT * FROM order_tbl WHERE o_date='$todaydate' AND o_process = 'Complete' AND o_active = '1'";
				
	$get_CheckCashUP_db = mysqli_query($db_connection, $sql_CheckCashUP_list) or die (mysqli_error($db_connection));
	
	$row_ccup_cnt = mysqli_num_rows($get_CheckCashUP_db);

	if ($row_ccup_cnt !=""){
	
	include_once ("db_connect.php");

	$sql_CashUp_list = "SELECT * FROM order_tbl WHERE o_date='$todaydate' AND o_process = 'Complete' AND o_active = '1'";
				
	$get_CashUp_db = mysqli_query($db_connection, $sql_CashUp_list) or die (mysqli_error($db_connection));
	
	
		$displayReport .= '

		<div class="cashupWrapperHeading">

		<div class="cashupBlockHeading">Activation</div>
		<div class="cashupBlockHeading">Date</div>
		<div class="cashupBlockHeading">Time</div>
		<div class="cashupBlockHeading">Discount</div>
		<div class="cashupBlockHeading">Total</div>
		<div class="cashupBlockHeading">Payment</div>
		<div class="cashupBlockHeading">Process</div>
		<div class="cashupBlockHeading">Type</div>

		</div>';
		
	while ($cuprow = mysqli_fetch_assoc($get_CashUp_db)){
		
					$orderid = $cuprow["o_id"];
					$process = $cuprow["o_process"];
					$payment = $cuprow["o_payment"];
					$o_activation = $cuprow["o_activation"];
					$paymenttype = $cuprow["o_paymentType"];
					$total = $cuprow["o_total"];
					$o_date = $cuprow["o_date"];
					$o_date = date("d-m-Y", strtotime($o_date));
					$o_time = $cuprow["o_time"];
					$o_active = $cuprow["o_active"];		
					$o_cashdisc = $cuprow["o_cashdisc"];		
					$o_percentdisc = $cuprow["o_percentdisc"];		

					if ($o_percentdisc == 0 && $o_cashdisc ==0.00){
						$discount = "NO";
					} else if($o_percentdisc !=0){
					 $discount = $o_percentdisc;
					} else if($o_cashdisc !=0.00){
					 $discount = $o_cashdisc;
					}else{
					 $discount = "NO";
					}
					
					
		$sum = $sum + $total;
		
		$displayReport .= '

		<div class="cashupWrapperContent">

		<div class="cashupBlockContent">'.$o_activation.'</div>
		<div class="cashupBlockContent">'.$o_date.'</div>
		<div class="cashupBlockContent">'.$o_time.'</div>
		<div class="cashupBlockContent">'.$discount.'</div>
		<div class="cashupBlockContent">&pound;' .number_format ($total, 2). '</div>
		<div class="cashupBlockContent">'.$payment.'</div>
		<div class="cashupBlockContent">'.$process.'</div>
		<div class="cashupBlockContent">'.$paymenttype.'</div>

		</div>';
		
	}
	$displayReport .= '
			<div class="cashupWrapperBtn">Todays taking is: &pound;' .number_format ($sum, 2). '
			<form action="reports.php?page=4" method="post">
			<div class="continue_button">
			<input class="" align="middle" name="CashUp" type="submit" value="Cash Up + Print">
			</div>
			</form>
			</div>	
	';
	
	if (isset($_POST['CashUp'])){	
		
	date_default_timezone_set('Europe/London');

	$todaydate = date("y/m/d");	
		
	include_once ("db_connect.php");
		
	$sql_UpdateCashUP_list = "UPDATE order_tbl SET o_active = '2' WHERE o_date='$todaydate' AND o_process = 'Complete'";
				
	$get_UpdateCashUP_db = mysqli_query($db_connection, $sql_UpdateCashUP_list) or die (mysqli_error($db_connection));
	
	## enter print script
	
		
	}
	
	}else{
		$displayReport = '';
		$msg2user = "Today orders has not been cashed up"; 	
	}
	}else{
		$displayReport = '';
		$msg2user = "Today orders has been cashed up";
	}
	 
	}else if ($page == "5"){
	 $pagetitle = "Generate Report";	
	 $selectpage = $pagetitle;	
	 
	 date_default_timezone_set('Europe/London');
$todaydate = date("m/d/y");

$dateFrom = $todaydate;
$dateTo = $todaydate;

if (isset($_POST['salesFilter'])){
	
	$salesFrom = stripslashes($_POST['salesFrom']);
	$dateFrom = strip_tags($salesFrom);
	$salesTo = stripslashes($_POST['salesTo']);
	$dateTo = strip_tags($salesTo);
	
	$dateFrom = date("Y-m-d", strtotime($dateFrom));
	$dateTo = date("Y-m-d", strtotime($dateTo));
	
	include_once ("db_connect.php");

	$sql_sales_list = "SELECT * FROM order_tbl WHERE o_date BETWEEN '$dateFrom' AND '$dateTo' AND o_active = '2' ORDER BY o_id";
			
	$get_sales_db = mysqli_query($db_connection, $sql_sales_list) or die (mysqli_error($db_connection));
	
	$salesCount = mysqli_num_rows($get_sales_db);
	if ($salesCount > 0){ //gather information from database

			$cashDiscount = "";
			$percentageDiscount =""; 

			while($getSales = mysqli_fetch_array($get_sales_db)){
				
			$o_id = $getSales['o_id'];
			$o_guestno = $getSales['o_guestno'];
			$o_cashdisc = $getSales['o_cashdisc'];
			$o_percentdisc = $getSales['o_percentdisc'];

			$o_total = $getSales['o_total'];
			$o_paymentType = $getSales['o_paymentType'];
			$o_paymentSplit = $getSales['o_paymentSplit'];
			
			$cashDiscount = $cashDiscount + $o_cashdisc; //sum up total cash discount
			$percentageDiscount =$percentageDiscount + $o_percentdisc; //sum up total card discount
			
			if ($o_paymentType == "Cash"){
				
				$cash_total = $cash_total + $o_total; //find cash total
				
			}
			
			if ($o_paymentType == "Card"){
				
				$card_total = $card_total + $o_total; //find card total

			}


			if ($o_paymentSplit == 1){ //gather information from database
			
			include_once ("db_connect.php");

			$sql_salesSplit_list = 'SELECT * FROM paymentSplit_tbl WHERE o_id ='.$o_id.'';		
			
			$get_salesSplit_db = mysqli_query($db_connection, $sql_salesSplit_list) or die (mysqli_error($db_connection));
	
			$salesSplit_Count = mysqli_num_rows($get_salesSplit_db);
			
			while($getSplit = mysqli_fetch_array($get_salesSplit_db)){

			$ps_cash = $getSplit['ps_cash'];
			$ps_card = $getSplit['ps_card'];

			if ($ps_cash != ""){
				
				$cash_total = $cash_total + $ps_cash; //find cash total within split
				
			}
			
			if ($ps_card != ""){
				
				$card_total = $card_total + $ps_card; //find card total within split

			}


			}
			}//close of split check loop
			
			
		} //close main while loop
		
			$cashTotal = $cash_total;
			$cardTotal = $card_total;
			
			$netTotal = $cash_total + $card_total;
			
			$cashDiscTotal = $cashDiscount;
			$percentDiscTotal = $percentageDiscount;
			
			$displayQuery .='Sales Figures '.$dateFrom.' BETWEEN '.$dateTo.' <br><br>
			
			Cash Discount Applied: £'.number_format($cashDiscTotal, 2).'<br>
			Percentage Discount Applied: £'.number_format($percentDiscTotal, 2).'<br><br>
			
			Cash Total: £'.number_format($cashTotal, 2).'<br>
			Card Total: £'.number_format($cardTotal, 2).'<br><br>
			
			NetTotal: £'.number_format($netTotal, 2).'<br>
			<br>
			
			<div class="ReportHolder">

		    <form action="printReciept" method="post">
			<div class="print_button">
	    		<input type="button" class="filter_continue" onClick="print()" value="Print Sales Report">
			</div>
		    
		    </form>  
	       
			</div>
			';
		
$dateFrom = date("m-d-y", strtotime($dateFrom));
$dateTo = date("m-d-y", strtotime($dateTo));	
	}
	
	
} else if (isset($_POST['dishFilter'])){

	$dishFrom = stripslashes($_POST['dishFrom']);
	$dateFrom = strip_tags($dishFrom);
	$dishTo = stripslashes($_POST['dishTo']);
	$dateTo = strip_tags($dishTo);
	
	$dateFrom = date("Y-m-d", strtotime($dateFrom));
	$dateTo = date("Y-m-d", strtotime($dateTo));
	
	include_once ("db_connect.php");

	$sql_dish_list = "SELECT *, COUNT(orderdetail_tbl.p_id) AS ProductCount FROM order_tbl INNER JOIN orderdetail_tbl ON order_tbl.o_id = orderdetail_tbl.o_id WHERE o_date BETWEEN '$dateFrom' AND '$dateTo' AND order_tbl.o_active = '2' GROUP BY orderdetail_tbl.p_id ORDER BY ProductCount DESC";
			
	$get_dish_db = mysqli_query($db_connection, $sql_dish_list) or die (mysqli_error($db_connection));
	
	$dishCount = mysqli_num_rows($get_dish_db);
	
	if ($dishCount > 0){ //gather information from database
	$productQTYtotal;
	
			while($getDishes = mysqli_fetch_array($get_dish_db)){
				
			$od_prodname = $getDishes['od_prodname'];
			$c_id = $getDishes['c_id'];
			$ProductCount = $getDishes['ProductCount'];

			$productDisplay .='
			<div class="productDisplayHolder">
			<div class="pdh_name">'.$od_prodname.'</div><div class="pdh_count">'.$ProductCount.'</div>
			</div>';
			
			$productQTYtotal =$productQTYtotal + $ProductCount; //sum up total card discount


			
			
		} //close main while loop
		
			
			$displayQuery .='Dishes Report '.$dateFrom.' BETWEEN '.$dateTo.' <br><br>
			
			Product Most Sold: <br>'.$productDisplay.' <br>
					
			Total Sold: '.$productQTYtotal.'<br>
			<br>
			
			<div class="ReportHolder">

		    <form action="printReciept" method="post">
			<div class="print_button">
	    		<input type="button" class="filter_continue" onClick="print()" value="Print Dish Report">
			</div>
		    
		    </form>  
	       
			</div>
			';
		
$dateFrom = date("m-d-y", strtotime($dateFrom));
$dateTo = date("m-d-y", strtotime($dateTo));	
	}

}
	 
	 
	 $displayReport = '
	 
	 <div class="QueryHolder">
    	<div class="queryTitle">Sales Report</div>
        <div class="queryFilter">
        <form action="reports.php?page=5" method="post" name="salesReport">
		<label for="from">From</label>
       	<input type="text" id="salesFrom" name="salesFrom" value="'.$dateFrom.'" placeholder="from: mm/dd/yyyy">
       	<label for="to">to</label>
		<input type="text" id="salesTo" name="salesTo" value="'.$dateTo.'" placeholder="to: mm/dd/yyyy">
        <input name="salesFilter" type="submit" value="Filter">
        </form>
        </div>
    </div>
  	<div class="QueryHolder">
    	<div class="queryTitle">Dish Popularity</div>
        <div class="queryFilter">
        <form action="reports.php?page=5" method="post" name="salesReport">
		<label for="from">From</label>
       	<input type="text" id="dishFrom" name="dishFrom" value="'.$dateFrom.'" placeholder="from: mm/dd/yyyy">
       	<label for="to">to</label>
		<input type="text" id="dishTo" name="dishTo" value="'.$dateTo.'" placeholder="to: mm/dd/yyyy">
        <input name="dishFilter" type="submit" value="Filter">
        </form>        
        </div>
    </div>
    
 	<div class="QueryDisplay">
    '.$displayQuery.'

    </div>
	  
	 ';

	 
	}else {
	 $pagetitle = "Reports Page";		
	 $selectpage = $pagetitle;	
	// default page
	
	$displayReport = 'Default page show something here';
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

<?php include_once('head.php'); ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script>
  $(function() {
    $( "#salesFrom" ).datepicker({
      defaultDate: "+0d",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#salesTo" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#salesTo" ).datepicker({
      defaultDate: "+0d",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#salesFrom" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
    $( "#dishFrom" ).datepicker({
      defaultDate: "+0d",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#dishTo" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#dishTo" ).datepicker({
      defaultDate: "+0d",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#dishFrom" ).datepicker( "option", "maxDate", selectedDate );
      }
    });	
  });
  </script>
<script>
	
	$(document).ready(function(){
			var pull 		= $('#pull');
			var push_up = $("#push_up");
			menu 		= $('.reportmenu .reportmenu_list');
			menuHeight	= menu.height();

		$(pull).on('click', function(e) {
			e.preventDefault();
			menu.slideToggle();
		});

		$(push_up).on('click', function(e) {
			e.preventDefault();
			menu.slideToggle();
		});

		$(window).resize(function(){
      		var w = $(window).width();
      		if(w > 320 && menu.is(':hidden')) {
      			menu.removeAttr('style');
      		}
  		});

  		$('.prodAdd a').click(function(){
  			
  			// Need to look at this function a little more in depth 
				$('#flash').show().delay(2000).fadeOut(500);
  		});
	});
</script>

<body>
<div class="gridContainer clearfix">

    <div id="Header"><?php include_once("header.php");?>     
      <div id="heading">
        <h3>Welcome <?php echo $username;?> <a href="maincontroller.php"> <img src="Images/home.png"> </a> </h3>
      </div>
    </div>  

    <div id="main_content">

      <div class="title">
        <h2>Reports</h2>
      </div>
      
      <div class="messages">
  		<div class="error_message_activation">
	      	<?php echo $error_msg;?> 
	    </div>      	
    	
    	<div class="success_message_activation">
			<?php echo $success_msg; ?>     		
    	</div>  
	
		<div class="normal_message_activation">
			<?php echo $msg2user; ?>			
		</div>
      </div>





 		<nav class="reportmenu">
	        <a href="#" id="pull">You are currently viewing: <br/> <?php echo $selectpage;?></a>  

	        <ul class="reportmenu_list"> 
	          	<a class="op" href="?page=1" >Active Tablet</a>
	            <a class="op" href="?page=2" >Today Active Order</a>
	            <a class="op" href="?page=3" >Todays Closed Order</a>
	            <a class="op" href="?page=4" >Cash Up</a>
	            <a class="op" href="?page=5" >Generate Report</a>
	            <a class="op" href="#" id="push_up">CLOSE</a>
	        </ul>
	    </nav>    

           

		<?php echo $displayReport; ?>
 
 
 		<div class="cashupWrapperBtn">
			
		</div>
 
 
 
  </div>
     
    


	
<div id="footer"><?php include_once("footer.php");?></div>
</div>
</body>
</html>