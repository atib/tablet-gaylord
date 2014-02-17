<?PHP
session_start();

$name = $_SESSION['fname'];

if(!isset($_SESSION['activation']))
{

    header("Location: activation.php");
    exit();
	
}else if(!isset($_SESSION['email']))
{
	
	$par = md5(1);

    header("Location: login.php");
    exit();
}else{
	$email = $_SESSION['email'];
	$fname = $_SESSION['fname'];	
}

if(isset($_GET['err'])){

	$error_msg = $_GET['err'];
  $user_msg = "Use your given loging credencials to log into the user controller";  

} else{
	$error_msg = "";
	
}

?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<?php include_once("head.php") ;?>
<body>

<div class="gridContainer clearfix">
    <div id="Header"><?php include_once("header1.php");?>     
      <div id="heading">
        <h3>Welcome <span class="username"><?php echo $name;?></span> </h3>
      </div>
    </div> 
  

  <div  id="main_content">
 
      <div class="title">
        <h2>Select an option</h2>
      </div>
      


  </div>

    <!-- <div class="titles"><h3>User Homepage</h3></div> -->
	<?php echo $error_msg;?> <?php echo $user_msg; ?>  
  
	<div id="Navigation">
		<ul id="navList">
		<a id="nav1" href="neworder.php?cat=1"><li>View Menu</li></a>
        <a id="nav1" href="neworder.php?cat=14"><li>Table Order</li></a>
        <a id="nav1" href="orderhistory.php"><li>Order History</li></a>
        <a id="nav1" href="reviews.php"><li>Reviews</li></a>
        <a id="nav1" href="share.php"><li>Share</li></a>
	  </ul>
  </div>
  		
  <div id="footer"><?php include_once("footer1.php");?></div>
</div>
</body>
</html>