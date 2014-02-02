<?PHP
session_start();

if(isset($_SESSION['username']))
{
	
	$username = $_SESSION['username'];
	
    header("Location: maincontroller.php?n=$username");
    exit();
}

if ($_GET['par'] = md5(2)){

	$error_msg = $_GET['err'];

} else{
	$error_msg = "";
	$user_msg = "Use your given loging credencials to log into the admin controller";	
}
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

  <div id="Header">
    <?php include_once("header.php");?>
  </div>
  
    
	<?php echo $error_msg; $user_msg; ?>  
        
    <div id="login">

	<!--LOGIN FORM-->
	<form name="login-form" class="login-form" action="loginprocess.php" method="post">

	<!--HEADER-->
    <div id="logo">
        <img src="Images/GR_small_logo.png">
    </div>
    <div class="titles">
    <!--TITLE-->
        <!-- <h3>Login Form</h3> -->
    <!--END TITLE-->
    <!--DESCRIPTION-->
    <!-- <span>Fill out the form below to login to my super awesome imaginary control panel.</span> -->
    <!--END DESCRIPTION-->
    </div>
    <!--END HEADER-->
	
	<!--CONTENT-->

    <div class="fields">
	<!--USERNAME--><input name="username" class="field1" type="text" placeholder="Username" required><!--END USERNAME-->
    <!--PASSWORD--><input name="password" class="field1" type="password" placeholder="Password" required><!--END PASSWORD-->
    </div>
    <!--END CONTENT-->
    
    <!--FOOTER-->
    <div class="buttons">
    <!--LOGIN BUTTON-->
        <input type="submit" name="submit" value="Continue" class="button" />
    <!--END LOGIN BUTTON-->
    </div>
    <!--END FOOTER-->

	</form>
	<!--END LOGIN FORM-->

	</div>
	<!--END WRAPPER-->
             
  <div id="footer"><?php include_once("footer.php");?></div>
</div>
</body>
</html>