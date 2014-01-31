<?php
session_start();

if(!isset($_SESSION['username'])){
	
	$error_msg = "";
    header("Location: index.php?err=$error_msg");
    exit();
	
}

$par=md5(3);
$username = $_SESSION['username'];


?>
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<?php include_once("head.php");?>

<body>
  <div class="gridContainer clearfix">

    <div id="Header"><?php include_once("header.php");?>     
      <div id="heading">
        <h3>Welcome <?php echo $username;?></h3>
      </div>
    </div>  
    
    <div id="main_content">

      <div class="title">
        <h2>Select An Option</h2>
      </div>
      
      <div id="Navigation">
    		<ul id="navList">
    		<a id="nav1" href="neworder.php?par=<?php print $par;?>"><li>Create Order</li></a>
            <a id="nav1" href="vieworder.php"><li>View Order</li></a>
            <a id="nav1" href="customer.php"><li>Customer</li></a>
            <a id="nav1" href="tablet/orderhistory.php"><li>Order History</li></a>
            <a id="nav1" href="tablet/reviews.php"><li>Reviews</li></a>
            <a id="nav1" href="tablet/reports.php"><li>Reports</li></a>	
    	  </ul>
      </div>
    </div>
    
    <div id="footer">
      <?php include_once("footer.php");?>
    </div>
  </div>
</body>
</html>