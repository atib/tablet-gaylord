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
    $user_msg = "You will need to log in, to progress any further. <br>
                If you have not have an account with us you can fill in a simple form to create a new account or alternatively log in as a guest user. ";
} else if(isset($_GET['usrm'])){
	$error_msg = "";
	$error_msg = $_GET['usrm'];
}else{
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

<?php include_once("head.php") ;?>
<script type="text/javascript" src="../Script/jquery.mobile-1.4.0.min.js"></script>

<body>

<div class="gridContainer clearfix">
    <div id="Header"><?php include_once("header1.php");?>     
    </div> 
        <div id= "top_action_bar"> 
              <div class="gaylord_name"> 
              </div>
              <div class="register_button">             
                <a href="register.php"> Register </a>
              </div>
          </div> 
  <div id="main_content">
    <div id="title">
      <p> Login to</p>
      <p>Gaylords' Interactive Menu </p>
    </div>

    <?php 
      echo $error_msg; 
    ?> 
    <?php 
      // echo $user_msg; 
    ?>  

    <div id="login-page-text">
      <p>Log in to access your personal ordering area.</p>
      <p>If you do not have an account use our simple register form or select skip to login as a guest.</p>      
    </div>

    <div id="login">
      <form name="login-form" class="login-form" action="loginprocess.php" method="post">

          <div class="">
            <input name="email" class="" type="text" placeholder="Email" required>
            <input name="password" class="" type="password" placeholder="Password" required>
          </div>

          
          <div class="continue_button">
            <input type="submit" name="submit" value="Login" class="" />
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