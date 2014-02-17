<?PHP
session_start();
/*
error_reporting(E_ALL);
ini_set('display_errors', 1);
*/
$error_msg ="";
$success_msg="";
$activate ="";
$orderid="";
$tab_sess="";
$msg2user="";

if(isset($_GET['err'])){

	$error_msg = $_GET['err'];

} else{
	$error_msg = "";
	$msg2user = " Please use the drop down list to activate the tablet. Please ensure the correct activation reference is used so the tablet is correctly assigned to an order.";	
}

if(isset($_SESSION['activation']))
{
	
	$activation = $_SESSION['activation'];
	
	$success_msg = 'Tablet is Activated: '.$activation.'';
} else{
	
	$error_msg .= "Tablet not activated.";
		
}
?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->

<?php include_once("head.php") ;?>
<body>

<div class="gridContainer clearfix">
    <div id="Header"><?php include_once("header1.php");?>     
    </div> 
  
  <div  id="">
   <div class="">
    <p>We would like to introduce you to our new ordering menu </p>
    <p>You can view our interactive menu and place an order directly to our system.</p>
    <p>Please follow the instruction outlined in each section to ensure your order is correctly placed.</p>
    <p>A member of staff will come and confirm your order once everyone on the table  have submited their order.</p>
    <p>Please click the continue button below to move to the next page, you will be asked to login.</p>
    <p>If you have not registered with us using the table you can use our simple register form to create an account.</p>
    <p>Registeration is not required to use this system, please click skip to move on.</p>
    <br/>
	

	<a class="continueBtn" href="login.php">Continue</a>
  
  </div>  
      





  </div>
    
	 
    
 
    
    
    
             
<div id="footer"><?php include_once("footer1.php");?></div>
</div>
</body>
</html>