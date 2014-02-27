<?php
session_start();

//ini_set('error_reporting', version_compare(PHP_VERSION,5,'>=') && version_compare(PHP_VERSION,6,'<') ?E_ALL^E_STRICT:E_ALL);

$domainurl= "http://lunarwebstudio.com/Demos/GaylordTablet/tablet/";

$username = $_SESSION['username'];

if(!isset($_SESSION['username'])){
	
	$error_msg="Unauthorised Access";
    header("Location: maincontroller.php?err=$error_msg");
	exit();
}

	if (isset($_POST['create'])){
	
	$guestno = stripslashes($_POST['guestno']);
	$tableno = stripslashes($_POST['tableno']);
	$guestno = strip_tags($_POST['guestno']);
	$tableno = strip_tags($_POST['tableno']);	

	if((!$guestno)||(!$tableno)){
	
	$error_msg = "Please complete all manditory fields! <br>";	
		
		if(!$guestno){
			
			$error_msg .= "Guest No is missing";
				
		} else if (!$tableno){
		
			$error_msg .= "Table No is missing";	
		}
	$par=md5(3);

	$displayresult='
	<form action="neworderprocessed.php?par='.$par.'" method="post" target="_self">
     <div class="">
  <select class="" name="guestno" > 
    <option value="">select guest no</option>
	<option value="1">1 guest</option>
    <option value="2">2 guest</option>
    <option value="3">3 guest</option>
    <option value="4">4 guest</option>
    <option value="5">5 guest</option>
    <option value="6">6 guest</option>
  	<option value="7">7 guest</option>
    <option value="8">8 guest</option>
    <option value="9">9 guest</option>
    <option value="10">10 guest</option>
   	<option value="11">11 guest</option>
    <option value="12">12 guest</option>
    <option value="13">13 guest</option>
    <option value="14">14 guest</option>
    <option value="15">15 guest</option>
    <option value="16">16 guest</option>
  	<option value="17">17 guest</option>
    <option value="18">18 guest</option>
    <option value="19">19 guest</option>
    <option value="20">20 guest</option>
  </select><br>
  
  <select class="" name="tableno"> 
    <option value="">select table no</option>
    <option value="1">table 1</option>
    <option value="2">table 2</option>
    <option value="3">table 3</option>
    <option value="4">table 4</option>
    <option value="5">table 5</option>
    <option value="6">table 6</option>
  	<option value="7">table 7</option>
    <option value="8">table 8</option>
    <option value="9">table 9</option>
    <option value="10">table 10</option>
  </select><br>
  
  </div>
          <div class="continue_button">
            <input class="" align="middle" name="create" type="submit" value="Create">
          </div>
          <div class="cancel_button">  
            <input class="" name="cancel" type="submit" value="Cancel">
          </div>  
  </form>';	
		
	}else{ //required information exisit
		
		include_once ("db_connect.php");

$access= md5(3);
	$par = "";
if ($_GET['par']== $access) {
	
	
	include_once ("db_connect.php");

	// /*
	$create_NO = 'INSERT INTO order_tbl (o_type, o_date, o_time, o_payment, o_process)
									VALUES ("Dine In", CURDATE(),NOW(), "Not Paid", "Arrived")';
	
	mysqli_query($db_connection, $create_NO) or die (mysqli_error($db_connection));
	
	$orderid = mysqli_insert_id($db_connection)or die (mysqli_error($db_connection));
	 // */
	
} else{

	$error_msg="Order not created.";
    header("Location: neworder.php?err=$error_msg");
	exit();
}


		$activation =''.$orderid.'-'.$tableno.'-'.$guestno.''; //unique table activation code
		
		$update_orderid = "UPDATE order_tbl SET o_guestno='$guestno', o_tableno='$tableno', o_active=1, o_activation='$activation' WHERE o_id='$orderid'";
		
		$update_order_db = mysqli_query($db_connection, $update_orderid) or die (mysqli_error($db_connection));
		
		mysqli_free_result($update_orderid_db);


		$check_order = "SELECT * FROM order_tbl WHERE o_id='$orderid'";
	
		$check_order_db = mysqli_query($db_connection, $check_order) or die (mysqli_error($db_connection));
		
		$order_check = mysqli_num_rows($check_order_db);
						
	
			if ($order_check > 0){ //gather information from database
		
				while($order = mysqli_fetch_array($check_order_db)){
				
					$o_id = $order["o_id"];
					$o_guest = $order["o_guest"];
					$o_table = $order["o_table"];
					$o_activation = $order["o_activation"];

			}
			
			mysqli_free_result($check_order_db);
			$par=md5(15);

			header("Location: confirmation.php?par=$par&oid=$o_id&oa=$o_activation");
				
			} 
		}
} //end of create 
	
	else if(isset($_POST['cancel'])){
		
	$displayresult='';	
	header("Location: maincontroller.php");	
	exit();	
	}


?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->

<?php include_once("head.php");?>

<script type="text/javascript" src="Script/jquery.mobile-1.4.0.min.js"></script>


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
		  <br/>
		  <?php echo $success_msg; ?>
		  <br/>
		  <?php echo $displayresult; ?>

  	</div>
  	<div id="footer"><?php include_once("footer.php");?></div>

</body>
</html>