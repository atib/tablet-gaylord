<?php
	
	date_default_timezone_set('Europe/London');

	$todaydate = date("y/m/d");	
		
	include_once ("db_connect.php");
		
	$sql_UpdateCashUP_list = "UPDATE order_tbl SET o_active = '3' WHERE o_date='$todaydate' AND o_process = 'Complete'";
				
	$get_UpdateCashUP_db = mysqli_query($db_connection, $sql_UpdateCashUP_list) or die (mysqli_error($db_connection));
	

	
	include_once ("db_connect.php");

	$sql_CheckCashUPSub_list = "SELECT * FROM order_tbl LEFT JOIN paymentSplit_tbl ON order_tbl.o_id = paymentSplit_tbl.o_id WHERE order_tbl.o_date='$todaydate' AND order_tbl.o_process = 'Complete' AND order_tbl.o_active = '3'";
				
	$get_CheckCashUPSub_db = mysqli_query($db_connection, $sql_CheckCashUPSub_list) or die (mysqli_error($db_connection));
	
	$CheckCashUPSub = mysqli_affected_rows($db_connection);

		
	if ($CheckCashUPSub !=""){
		
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
		$cash ="";
		$card = "";
		
	while ($cuprow = mysqli_fetch_assoc($get_CheckCashUPSub_db)){
		
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

					$o_paymentSplit = $cuprow["o_paymentSplit"];
					$ps_cash = $cuprow["ps_cash"];
					$ps_card = $cuprow["ps_card"];

					if ($o_paymentSplit == 1 && $paymenttype == "Both"){
						
					$cash = $cash + $ps_cash;
					$card = $card + $ps_card;
					
					} else if ($o_paymentSplit == 0 && $paymenttype == "Cash"){
				
					$cash = $cash + $total;
					
					} else if ($o_paymentSplit == 0 && $paymenttype == "Card"){
				
					$card = $card + $total;						

					}
					
					
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
		
		$emailReport .=' <tr>       
		<td width="12.5%" height="35" align="center">'.$o_activation.'</td>
       	<td width="12.5%" align="center">'.$o_date.'</td>
        <td width="12.5%" align="center">'.$o_time.'</td>
       	<td width="12.5%" align="center">'.$discount.'</td>
        <td width="12.5%" align="center">&pound;' .number_format ($total, 2). '</td>
       	<td width="12.5%" align="center">'.$payment.'</td>
        <td width="12.5%" align="center">'.$process.'</td>
       	<td width="12.5%" align="center">'.$paymenttype.'</td> 
		</tr>
		';
		
	}
		
}
		
// Start assembly of Email
		//$to = "$email";
		$to = "jobanali23@gmail.com, Atib.chowdhury@gmail.com";
		
		// Change this to your site admin email
		$from = "info@lunarwebstudio.com";
		$subject = "Gaylord Auto Full Cash Up ";
		//Begin HTML Email Message where you need to change the activation URL inside
		$message ='<html>
<head>
<title>HTML email</title>
</head>
<body>
		
		<table width="100%" cellspacing="1" cellpadding="1">
  <tr>
    <td colspan="3" align="center" bgcolor="#000000" style="color:#FFF"><img src="http://lunarwebstudio.com/Demos/GaylordTablet/Images/GR_small_logo.png" width="263" height="224"></td>
  </tr>
  <tr>
    <td width="3%" bgcolor="#666666" style="color:#FFF">&nbsp;</td>
    <td width="94%">
    
    <table width="100%" cellspacing="1" cellpadding="1">
      <tr>
        <td height="41" colspan="8" align="center"><h1>Gaylord Cash Up - Report</h1></td>
        </tr>
      <tr>
        <td height="34" colspan="8" align="center">Hi '.$username.', <br>Please find below todays Auto cash up report as of today: '.$todaydate.'</td>
        </tr>
      <tr>
        <td width="12.5%" height="35" align="center" bgcolor="#CCCCCC"><strong>Activation</strong></td>
       	<td width="12.5%" align="center" bgcolor="#CCCCCC"><strong>Date</strong></td>
        <td width="12.5%" align="center" bgcolor="#CCCCCC"><strong>Time</strong></td>
       	<td width="12.5%" align="center" bgcolor="#CCCCCC"><strong>Discount</strong></td>
        <td width="12.5%" align="center" bgcolor="#CCCCCC"><strong>Total</strong></td>
       	<td width="12.5%" align="center" bgcolor="#CCCCCC"><strong>Payment</strong></td>
        <td width="12.5%" align="center" bgcolor="#CCCCCC"><strong>Process</strong></td>
       	<td width="12.5%" align="center" bgcolor="#CCCCCC"><strong>Type</strong></td>    
      </tr>
     
        '.$emailReport.' 
      
      <tr>
        <td colspan="8" height="35" align="center">&nbsp;</td>
       	</tr>
      <tr>
        <td colspan="2" width="25%" height="35" align="center">&nbsp;</td>
       	<td width="25%" colspan="2" align="center" bgcolor="#CCCCCC"><strong>Cash</strong></td>
        <td colspan="2" width="25%" align="center">&pound;' .number_format ($cash, 2). '</td>
       	<td colspan="2" width="25%" align="center">&nbsp;</td>   
      </tr>
      <tr>
        <td colspan="2" width="25%" height="35" align="center">&nbsp;</td>
       	<td width="25%" colspan="2" align="center" bgcolor="#CCCCCC"><strong>Card</strong></td>
        <td colspan="2" width="25%" align="center">&pound;' .number_format ($card, 2). '</td>
       	<td colspan="2" width="25%" align="center">&nbsp;</td>   
      </tr>
      <tr>
        <td colspan="2" width="25%" height="35" align="center">&nbsp;</td>
       	<td width="25%" colspan="2" align="center" bgcolor="#CCCCCC"><strong>Total</strong></td>
        <td colspan="2" width="25%" align="center">&pound;' .number_format ($sum, 2). '</td>
       	<td colspan="2" width="25%" align="center">&nbsp;</td>   
      </tr>
      <tr>
        <td colspan="8" height="35" align="center">&nbsp;</td>
       	</tr>     
      <tr>
        <td colspan="8" height="35" align="center"><p><strong>Kind Regards</strong></p>
          <p><strong>Gaylord Tablet Systems</strong></p></td>
       	</tr>
    </table>
    
    </td>
    <td width="3%" bgcolor="#666666" style="color:#FFF">&nbsp;</td>
  </tr>
</table>
</body>
</html>

';

		// end of message
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: $from\r\n";
		
		$to = "$to";
		// Finally send the activation email to the member
		mail($to, $subject, $message, $headers);
		// Then print a message to the browser for the joiner 	
		
?>