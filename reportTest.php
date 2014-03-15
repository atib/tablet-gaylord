<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Report Test</title>
<link rel="stylesheet" type="text/css" href="CSS/Main.css">

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
</head>

<body>
<div class="gridContainer clearfix">

    <div id="Header"><?php include_once("header.php");?>     
      <div id="heading">
        <h3>Welcome <?php echo $username;?> <a href="maincontroller.php"> <img src="Images/home.png"> </a> </h3>
      </div>
    </div>  

    <div id="main_content">

 	<div class="QueryHolder">
    	<div class="queryTitle">Sales Report</div>
        <div class="queryFilter">
        <form action="reportTest.php" method="post" name="salesReport">
		<label for="from">From</label>
       	<input type="text" id="salesFrom" name="salesFrom" value="<?php echo $dateFrom;?>" placeholder="from: mm/dd/yyyy">
       	<label for="to">to</label>
		<input type="text" id="salesTo" name="salesTo" value="<?php echo $dateTo;?>" placeholder="to: mm/dd/yyyy">
        <input name="salesFilter" type="submit" value="Filter">
        </form>
        </div>
    </div>
  	<div class="QueryHolder">
    	<div class="queryTitle">Dish Popularity</div>
        <div class="queryFilter">
        <form action="reportTest.php" method="post" name="salesReport">
		<label for="from">From</label>
       	<input type="text" id="dishFrom" name="dishFrom" value="<?php echo $dateFrom;?>" placeholder="from: mm/dd/yyyy">
       	<label for="to">to</label>
		<input type="text" id="dishTo" name="dishTo" value="<?php echo $dateTo;?>" placeholder="to: mm/dd/yyyy">
        <input name="dishFilter" type="submit" value="Filter">
        </form>        
        </div>
    </div>
    
 	<div class="QueryDisplay">
    <?php echo $displayQuery;?>

    </div>
 
    </div>
	
  <div id="footer"><?php include_once("footer.php");?></div>
</div>
</body>
</html>