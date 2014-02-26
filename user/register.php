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
<script type="text/javascript" src="../Script/jquery.mobile-1.4.0.min.js"></script>

<body>

<div class="gridContainer clearfix">
    <div id="Header"><?php include_once("header1.php");?>     
    </div>
    <div id= "top_action_bar"> 
      <div class="gaylord_name"> 
        <h3> Registration </h3> 
      </div>
    </div> 
  <div id="main_content" style="margin-top: 5%;">
    
    <div id="title">
      <p style="margin-bottom:3%; color: #B3B2B2;"> The Gaylord Restaurant</p>
      <p style="color: #B3B2B2;"> Interactive Experience </p>
    </div>

    <?php 
      echo $error_msg; 
    ?>  

    <div id="login-page-text">
      <p>Please use the simple form to register.</p>
      <p>If you do not wish to register simply press 'Guest Login' to skip process</p>
    </div>

    <div id="login">
      <form name="register-form" class="register-form" action="loginprocess.php" method="post">

          <div class="register_form" style="margin-bottom: 10%;">
            <input name="c_fname" class="" type="text" placeholder="First Name" required>
            <input name="c_lname" class="" type="text" placeholder="Last Name" required>
            <input name="c_address1" class="" type="text" placeholder="First Line Address" required>
            <input name="c_town" class="" type="text" placeholder="Town" required>
            <input name="c_postcode" class="" type="text" placeholder="Postcode" required>
            <input name="c_mobile" class="" type="text" placeholder="Mobile" required>
            <input name="c_email" class="" type="text" placeholder="Email" required>
            <input name="password" class="" type="password" placeholder="Password" required>
            <input name="password2" class="" type="password" placeholder="Confirm Password" required>
          </div>
          
          <div class="continue_button">
            <input type="submit" name="register" value="Register" class="" />
          </div>

      </form>

      <form name="login-form" class="login-form" action="loginprocess.php" method="post">
        <div class="skip_button">
          <input name="bypass" class="field1" type="hidden" required>
          <!--Skip BUTTON-->
          <input type="submit" name="skip" value="Guest Login" class="" />
          <!--END Skip BUTTON-->
        </div>
      </form>

    </div>
        
  </div>
    
     
    
 
    
    
    
             
<div id="footer"><?php include_once("footer1.php");?></div>
</div>
</body>



</html>