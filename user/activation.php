<?PHP
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$error_msg ="";
$success_msg="";
$activate ="";
$orderid="";
$tab_sess="";
$msg2user="";

if(isset($_GET['par'])){

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

include_once("db_connect.php");

$sql_activation_list = "SELECT * FROM order_tbl WHERE o_activation != '' AND o_process='Arrived' OR o_process = 'Order Taken' ORDER BY o_id DESC";
				
$get_activation_list_db = mysqli_query($db_connection, $sql_activation_list) or die (mysqli_error($db_connection));			
				
				
	while ($row = mysqli_fetch_assoc($get_activation_list_db)){
				
			$activate .= '<option value='.$row['o_activation'].'>'.$row['o_activation'].'</option>';
			$orderid .='<input name="activateorderid" class="field1" type="hidden" value="'.$row['o_id'].'" required>';
				
	}

if ($activate == ""){
	$activate = '<option value="">No Tablet Activated</option>';

}


mysqli_free_result($get_activation_list_db);

if (isset($_POST['activate'])){

	if($activation == ""){
	
	$error_msg = "Please select a valid activation reference. ";
	
	header("Location: activation.php?par=1&err=$error_msg");
	exit();
	}


	$activation = $_POST['activation'];
	$activateorderid = $_POST['activateorderid'];

	$_SESSION['activation'] = $activation;
	$_SESSION['activateorderid'] = $activateorderid;
	
	$crt_sess = session_id();
	include_once("db_connect.php");

	$sql_activation_check = "SELECT tab_id FROM tabletactivate_tbl WHERE o_activation = '$activation' AND tab_sess = '$tab_sess'";

	$get_activation_check_db = mysqli_query($db_connection, $sql_activation_check) or die (mysqli_error($db_connection));

	$tabletcheck = mysqli_num_rows($get_activation_check_db);
	
	if ($tabletcheck == 0){ 
	

			$activate_tablet = "INSERT INTO tabletactivate_tbl (o_activation, o_id, tab_sess, tab_active)
										VALUES ('$activation','$activateorderid','$crt_sess', '1')";
		
			$activate_tablet_db = mysqli_query($db_connection, $activate_tablet) or die (mysqli_error($db_connection));
				
		
		$success_msg = 'Tablet is Activated: '.$activation.'';
		$error_msg ="";	
		
		
	$msg2user = 'Tablet is now activated. <a href="login.php">Go to user login page</a> ';
		} else{
		$error_msg ="Tablet already activated";
			
		}
	
} 

if (isset($_POST['deactivate'])){

	if($activation == ""){
	
	$error_msg = "Please select a valid activation reference to deactivate";
	
	header("Location: activation.php?par=1&err=$error_msg");
	exit();

	}


unset($_SESSION['activation']);
unset($_SESSION['activateorderid']);

	if ($activation ==""){
		$success_msg = ' Tablet is Deactivated';
		$error_msg ="";

	}else{
		$error_msg = " Dectivation Failed";
		$success_msg="";

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
<link href="CSS/Main.css" rel="stylesheet" type="text/css">

</head>
<body>
<div class="gridContainer clearfix">

   <div id="Header"><?php include_once("header1.php");?></div>
  
  <div id="heading"><h2>User Controller</h2></div>
    
	<?php echo $error_msg;?> 
	<?php echo $success_msg; ?>  
    <?php echo $msg2user; ?>
    <div id="login">

	<form name="activation-form" class="activation-form" action="activation.php" method="post">

    <div class="titles">
    <h3>Activate Tablet</h3>
 	</div>
    
    <div class="fields">
    <select name="activation" class="field1" type="text">    
    
    <?php echo $activate;?>
    
    </select>
 	
	<?php echo $orderid;?> 

    </div>
    
    <div class="buttons">
    <input type="submit" name="activate" value="Activate" class="button2" />
    <input type="submit" name="deactivate" value="Deactivate" class="button2" />
    </div>

	</form>

	</div>
             
  <div id="footer"><?php include_once("footer1.php");?></div>
</div>
</body>
</html>