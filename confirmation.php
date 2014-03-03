<?php
session_start();

if(!isset($_SESSION['username'])){
	
	$error_msg="Unauthorised Access";
    header("Location: maincontroller.php?err=$error_msg");
	exit();
}

	$access=md5(15);
	
if ($_GET['par']== $access) {
	
	$username = $_SESSION['username'];
	
	
	$o_id = $_GET['oid'];
	$o_activation = $_GET["oa"];
	
	$o_id = stripslashes($o_id);
	$o_activation  = stripslashes($o_activation);
	$o_id = strip_tags($o_id);
	$o_activation  = strip_tags($o_activation );	

	$success_msg = '
		<div class="success_activation">
		 	<h3> Success! </h3>
			<h4> Order #: '.$o_activation.'</h4>

		 	<h5> Please follow the instructions to get the tablet activated.</h5>
		</div>'; 
		
	$displayresult='
		<div class="activation_message">
			<h3> Please use the below activation code to link individual tablet to this order id</h3>
			<div class="request_processed">
				<p>Your request has been processed</p>
			</div>
			<a href="maincontroller.php">Back to main menu</a>		
		
		</div>';
	
	
	
	
	
} else{

	$error_msg="Access code missing, please follow the guidelines set";
    header("Location: maincontroller.php?err=$error_msg");
	exit();
}

include_once ("db_connect.php");



?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<?php include_once("head.php");?>

<body>
  <div class="gridContainer clearfix">

    <div id="Header"><?php include_once("header.php");?>     
      <div id="heading">
        <h3>Welcome <?php echo $username;?> <a href="index.php"> <img src="Images/home.png"> </a> </h3>
      </div>
    </div>  
    
    <div id="main_content">

      <div class="title">
        <h2>New Order Request</h2>
      </div>
      
   	  <?php echo $error_msg; ?>
   	  <?php echo $success_msg; ?>
	  <?php echo $displayresult; ?>
  
			
    

    </div>

          
    
  		
  <div id="footer"><?php include_once("footer.php");?></div>
</div>
</body>
</html>