<?PHP
session_start();
/*
if(!isset($_SESSION['username'])){
	
	$error_msg = "";
    header("Location: index.php?err=$error_msg");
    exit();
	
}
*/
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
    <div id="navHolder">
    	<div class="optBtn"><a href="#">Add Customer</a></div>
    	<div class="optBtn"><a href="#">Edit Customer</a></div>
        <div class="optBtn"><a href="#">Delete Customer</a></div>
    </div>
    
    <div id="searchfilter">
    
        <form action="vieworder.php" method="post" target="_self">
        
        <div class="searchOpt"><input name="searchbar" type="text" placeholder="E.g. ID, Name, Address or Email" ></div>
    	
        <div class="searchOpt">
            <select class="dropdown1" name="filtercondition"> 
            
                <option value="<?php echo $filtercondition;?>" selected><?php echo $filtercondition;?></option>
                <option value="<?php echo $option1; ?>"><?php echo $option1; ?></option>
                <option value="<?php echo $option2; ?>"><?php echo $option2; ?></option>
                <option value="<?php echo $option3; ?>"><?php echo $option3;?></option>
                <option value="<?php echo $option4; ?>"><?php echo $option4;?></option>

            </select>
        </div>
        
        <div class="searchOpt">
        <input class="btngo1" name="search" type="submit" value="search"> 
        </div>
        
            </form>
            
            <?php echo $error_msg; $success_msg; ?>
  </div>
    
  </div>
  <div id="footer">A Pummello Designed & Developed Product</div>
</div>
</body>
</html>