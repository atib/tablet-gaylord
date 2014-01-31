<?PHP
session_start();

if(isset($_SESSION['email']))
{
	
	$email = $_SESSION['email'];
	$fname = $_SESSION['fname'];

	$par = md5(1);

    header("Location: index.php?n=$fname&par=$par");
    exit();
}

if ($_GET['par'] = md5(2)){

	$error_msg = $_GET['err'];

} else{
	$error_msg = "";
	$user_msg = "You will need to log in, to progress any further. <br>
				If you have not have an account with us you can fill in a simple form to create a new account or alternatively log in as a guest user. ";	
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
    
	<?php echo $error_msg; $user_msg; ?>  
        
    <div id="login">

	<!--LOGIN FORM-->
	<form name="login-form" class="login-form" action="loginprocess.php" method="post">

	<!--HEADER-->
    <div class="titles">
    <!--TITLE--><h3>Login Form</h3>
    <!--END TITLE-->
    <!--DESCRIPTION--><span>Log in to access your personal ordering area, you will be able to view what you have previously ordered with us and what you have said about each dish you have tried.</span>
    <span>If you have not got a logging account, use our simple register form for instant access. You do not have to be registered to use this system, use the skip button to login as a guest.</span><!--END DESCRIPTION-->
    </div>
    <!--END HEADER-->
	
	<!--CONTENT-->
    <div class="fields">
	<!--USERNAME--><input name="email" class="field1" type="text" placeholder="email" required><!--END USERNAME-->
    <!--PASSWORD--><input name="password" class="field1" type="password" placeholder="password" required><!--END PASSWORD-->
    </div>
    <!--END CONTENT-->
    
    <!--FOOTER-->
    <div class="buttons">
    <!--LOGIN BUTTON--><input type="submit" name="submit" value="Login" class="button2" /><!--END LOGIN BUTTON-->
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