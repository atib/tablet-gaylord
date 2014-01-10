<?PHP
session_start();

if(isset($_SESSION['username']))
{
	
	$username = $_SESSION['username'];
	
	$par = md5(1);

    header("Location: maincontroller.php?n=$username&par=$par");
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
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gaylord</title>
<link href="CSS/boilerplate.css" rel="stylesheet" type="text/css">
<link href="CSS/Main.css" rel="stylesheet" type="text/css">

<script src="Script/respond.min.js"></script>
</head>
<body>
<div class="gridContainer clearfix">

  <div id="Header">Gaylord Logo </div>
  <div id="heading">Master Controller</div>
  <div id="mainbody">
  
	<?php echo $error_msg; $user_msg; ?>  
    
   <form action="loginprocess.php" method="post">
   <input name="username" class="field" type="text" placeholder="username"><br>
   <input name="password" class="field" type="password" placeholder="password"><br>
   <input name="login" type="submit" value="Login">
   </form>
  		
  </div>
  <div id="footer">A Pummello Designed & Developed Product</div>
</div>
</body>
</html>