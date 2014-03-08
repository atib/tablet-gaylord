<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION['username'])){
	
	$error_msg="Unauthorised Access";
    header("Location: maincontroller.php?err=$error_msg");
	exit();
}

if(isset($_GET['err'])){

	$error_msg = $_GET['err'];
	$success = "";
} else if(isset($_GET['succ'])){
	$error_msg = "";
	$success = $_GET['succ'];
}else{
	$error_msg = "";
	$success = "";	
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
		 
		 <div class="activeTabblock">Tablet ID</div>
		 <div class="activeTabblock">Activation</div>
		 <div class="activeTabblock">Order ID</div>
		
		 <div class="activeTabblock">'.$tab_id.'</div>
		 <div class="activeTabblock">'.$o_activation.'</div>
		 <div class="activeTabblock">'.$o_id.'</div>
		 
		 <div class="activeTabblock">Tablet Session</div>
		 <div class="activeTabblock">Tablet Order Process</div>
		 <div class="activeTabblock">Activation Date</div>
		
		 <div class="activeTabblock">'.$tab_sess.'</div>
		 <div class="activeTabblock">'.$tab_order.'</div>
		 <div class="activeTabblock">'.$tab_activeDate.'</div>
		 
		 <div class="activeTabblock">Tablet Active</div>
		 <div class="activeTabblock"></div>
		 <div class="activeTabblock"></div>
		 
		 <div class="activeTabblock">'.$tab_active.'</div>
		 <div class="activeTabblock"></div>
		 <div class="activeTabblock">
			<div class="buttons">
			<input name="tabID" type="hidden" value="'.$tab_id.'">
			<input name="closeTab" class="" type="submit" value="Tablet Collected">
			</div>
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
			if ($tab_order == "Order Complete" && $tab_active == 0 || $tab_order == "Order Complete" && $tab_active == 1){
				
			}else if ($tab_order == "Ordering" && $tab_active == 1){
			$error_msg = "User is still ordering. If User has finish please deactivate tablet by logging off";
			}
			
		}
		}
	
	} else if ($page == "2"){
	 $pagetitle = "Todays Active Orders";	
	 $selectpage = $pagetitle;	

	date_default_timezone_set('Europe/London');

	$todaydate = date("y/m/d");
	
	include_once ("db_connect.php");

	$sql_activeOrder_list = "SELECT * FROM order_tbl WHERE o_date='$todaydate' AND o_active = '1'";
				
	echo $get_activeOrder_db = mysqli_query($db_connection, $sql_activeOrder_list) or die (mysqli_error($db_connection));
	
	if ($get_activeOrder_db ==""){
		$displayReport .= 'No Active Orders today';
	}else{
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
		
		<div class="orderholder">
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
		<div class="order_OrderProcess_ol_content ol_pulled_content">'.$process.'</div>

        <div class="ol_content">Payment (Paid/ Not Paid)</div>	 
		<div class="order_Payment_ol_content ol_pulled_content">'.$payment.'</div>
          
        <div class="ol_content">Payment Type</div>	
		<div class="order_paymenttype_ol_content ol_pulled_content">'.$paymenttype.'</div> 
              
    </div>
    </div>
		';
	}
	}


 	} else if ($page == "3"){
	 $pagetitle = "Todays Closed Orders";	
	 $selectpage = $pagetitle;	
	 	 
date_default_timezone_set('Europe/London');

	$todaydate = date("y/m/d");
	
	include_once ("db_connect.php");

	$sql_closedOrder_list = "SELECT * FROM order_tbl WHERE o_date='$todaydate' AND o_process = 'Complete' AND o_active = '2'";
				
	$get_closedOrder_db = mysqli_query($db_connection, $sql_closedOrder_list) or die (mysqli_error($db_connection));
	
	if ($get_closedOrder_db!=""){
	
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
		
		<div class="orderholder">
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
		<div class="order_OrderProcess_ol_content ol_pulled_content">'.$process.'</div>

        <div class="ol_content">Payment (Paid/ Not Paid)</div>	 
		<div class="order_Payment_ol_content ol_pulled_content">'.$payment.'</div>
          
        <div class="ol_content">Payment Type</div>	
		<div class="order_paymenttype_ol_content ol_pulled_content">'.$paymenttype.'</div> 
              
    </div>
    <div class="clear"></div>
    
    </form>
    </div>
	';
	}
	}else{
		$displayReport .= 'No closed Orders today';
	}			 
	}else if ($page == "4"){
	 $pagetitle = "Cash Up";	
	 $selectpage = $pagetitle;	
	 
	}else if ($page == "5"){
	 $pagetitle = "Generate Report";	
	 $selectpage = $pagetitle;	
	 
	}else {
	 $pagetitle = "Reports Page";		
	 $selectpage = $pagetitle;	
	// 
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
<script type="text/javascript" src="Script/jquery.js" ></script>

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

            <?php echo $error_msg;?> <?php $success_msg; ?>
 
 <?php echo $pagetitle;?>
 <?php echo $displayReport; ?>
 
 
 
 
 
 
 
 
  </div>
     
    


	
<div id="footer"><?php include_once("footer.php");?></div>
</div>
</body>
</html>