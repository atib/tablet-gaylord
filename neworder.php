<?php
session_start();

$username = $_SESSION['username'];

if(!isset($_SESSION['username'])){
	
	$error_msg="Unauthorised Access";
    header("Location: maincontroller.php?err=$error_msg");
	exit();
}
$par=md5(3);

?>
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->

<?php include_once("head.php");?>
<script type="text/javascript" src="Script/jquery.mobile-1.4.0.min.js"></script>


<body>
<div class="gridContainer clearfix">

    <div id="Header"><?php include_once("header.php");?>     
      <div id="heading">
        <h3>Welcome <?php echo $username;?> <a href="maincontroller.php"> <img src="Images/home.png"> </a> </h3>
      </div>
    </div>  

    <div id="main_content">

      <div class="title">
        <h2>New Order</h2>
      </div>
      
      <form action="neworderprocessed.php?par=<?php echo $par;?>" method="post" target="_self">
      
        <div class="">
          
          <select class="" name="guestno" > 
            <option value="">Select number of guests</option>
            <option value="1">1 Guest</option>
            <option value="2">2 Guests</option>
            <option value="3">3 Guests</option>
            <option value="4">4 Guests</option>
            <option value="5">5 Guests</option>
            <option value="6">6 Guests</option>
            <option value="7">7 Guests</option>
            <option value="8">8 Guests</option>
            <option value="9">9 Guests</option>
            <option value="10">10 Guests</option>
            <option value="11">11 Guests</option>
            <option value="12">12 Guests</option>
            <option value="13">13 Guests</option>
            <option value="14">14 Guests</option>
            <option value="15">15 Guests</option>
            <option value="16">16 Guests</option>
            <option value="17">17 Guests</option>
            <option value="18">18 Guests</option>
            <option value="19">19 Guests</option>
            <option value="20">20 Guests</option>
          </select><br>
          
          <select class="" name="tableno"> 
            <option value="">Select table number</option>
            <option value="1">Table 1</option>
            <option value="2">Table 2</option>
            <option value="3">Table 3</option>
            <option value="4">Table 4</option>
            <option value="5">Table 5</option>
            <option value="6">Table 6</option>
            <option value="7">Table 7</option>
            <option value="8">Table 8</option>
            <option value="9">Table 9</option>
            <option value="10">Table 10</option>
          </select><br>
                    
          <div class="continue_button">
            <input class="" align="middle" name="create" type="submit" value="Create">
          </div>
          <div class="cancel_button">  
            <input class="" name="cancel" type="submit" value="Cancel">
          </div>
      
      </form>
    
    </div>


	
  <div id="footer"><?php include_once("footer.php");?></div>
</div>
</body>
</html>