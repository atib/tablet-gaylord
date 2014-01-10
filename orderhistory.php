<?PHP
session_start();

if(!isset($_SESSION['username'])){
	
	$error_msg = "";
    header("Location: index.php?err=$error_msg");
    exit();
	
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
  
  
	

  		
  </div>
  <div id="footer">A Pummello Designed & Developed Product</div>
</div>
</body>
</html>