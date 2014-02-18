<?PHP
session_start();

if(isset($_SESSION['email']))
{
	
	$email = $_SESSION['email'];
	$fname = $_SESSION['fname'];

    header("Location: index.php?n=$fname");
    exit();
}
if(isset($_GET['err'])){

	$error_msg = $_GET['err'];
    $user_msg = "Please use the simple form to register ";
} else{
	$error_msg = "";
		
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<?php include_once("head.php"); ?>
<body>
<div class="gridContainer clearfix">

   <div id="Header"><?php include_once("header1.php");?></div>
  
  <div id="heading"><h2>User Controller</h2></div>
    
	<?php echo $error_msg; ?> <?php $user_msg; ?>  
        
    <div id="login">

	<!--LOGIN FORM-->
	<form name="register-form" class="register-form" action="loginprocess.php" method="post">

	<!--HEADER-->
    <div class="titles">
    <!--TITLE--><h3>Register Form</h3>
    <!--END TITLE-->
    <!--DESCRIPTION--><span>Fill in the form below to create your Gaylord login credencials</span>
    <span>If you have do not want to register anymore, use the skip button to login as a guest.</span><!--END DESCRIPTION-->
    </div>
    <!--END HEADER-->
	
	<!--CONTENT-->
    <div class="fields">
	<!--FNAME--><input name="c_fname" class="field1" type="text" placeholder="First Name" required><!--END FNAME-->
    <!--LNAME--><input name="c_lname" class="field1" type="text" placeholder="Last Name" required><!--END LNAME-->
	<!--ADDRESS--><input name="c_address1" class="field1" type="text" placeholder="Address 1" required><!--END ADDRESS-->
	<!--TOWN--><input name="c_town" class="field1" type="text" placeholder="Town" required><!--END TOWN-->
	<!--POSTCODE--><input name="c_postcode" class="field1" type="text" placeholder="Postcode" required><!--END POSTCODE-->
	<!--MOBILE--><input name="c_mobile" class="field1" type="text" placeholder="Mobile" required><!--END MOBILE-->
	<!--EMAIL--><input name="c_email" class="field1" type="text" placeholder="email" required><!--END EMAIL-->
    <!--PASSWORD--><input name="password" class="field1" type="password" placeholder="password" required><!--END PASSWORD-->
    <!--PASSWORD2--><input name="password2" class="field1" type="password" placeholder="Confirm password" required><!--END PASSWORD-->
    </div>
    <!--END CONTENT-->
    
    <!--FOOTER-->
    <div class="buttons">    
    <!--LOGIN BUTTON--><input type="submit" name="submit" value="register" class="button2" /><!--END LOGIN BUTTON-->
    </div>
    <!--END FOOTER-->

	</form>
	<!--END LOGIN FORM-->
	<form name="login-form" class="login-form" action="loginprocess.php" method="post">
    <div class="buttons">
    <input name="bypass" class="field1" type="hidden" required>
    <!--Skip BUTTON--><input type="submit" name="skip" value="Skip" class="button2" /><!--END Skip BUTTON-->
	</div>
    </form>
	</div>
	<!--END WRAPPER-->
             
  <div id="footer"><?php include_once("footer1.php");?></div>
</div>
</body>
</html>