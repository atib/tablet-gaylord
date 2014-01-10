<?PHP
session_start();

if(isset($_SESSION['username']))
{
	
	$username = $_SESSION['username'];
	
	$par = md5(1);

    header("Location: login.php?n=$username&par=$par");
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
<link href="../CSS/boilerplate.css" rel="stylesheet" type="text/css">
<link href="../CSS/userMain.css" rel="stylesheet" type="text/css">

<script src="../Script/respond.min.js"></script>
</head>
<body>
<div class="gridContainer clearfix">

  <div id="Header">Gaylord Logo </div>
  <div id="heading">Gaylord Interactive Ordering Menu</div>
  <div id="mainbody">
  
	<?php echo $error_msg; $user_msg; ?>  
    
   <form action="loginprocess.php" method="post">
   <input name="email" class="field" type="text" placeholder="email"><br>
   <input name="password" class="field" type="password" placeholder="password"><br>
   <input class="btngo" name="login" type="submit" value="Login">
   </form>
  		
  </div>
  <div id="footer">A Pummello Designed & Developed Product</div>
</div>
</body>
</html>