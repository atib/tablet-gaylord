<?PHP
session_start();
/*
error_reporting(E_ALL);
ini_set('display_errors', 1);
*/
$error_msg = ""; 
$success_msg = "";	
$menuHeading = "";
$orderMenu = "";
$basket ="";
$basketMsg="";
$grandtotal="";	

if(!isset($_SESSION['email']))
{
	$error_msg = "user not found";

    header("Location: index.php?err=$error_msg");
    exit();
}

$fname = $_SESSION['fname'];

?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<?php //include_once('head.php'); ?>
<script type="text/javascript" src="../Script/jquery.js" ></script>
<script>
$(document).ready(function() {
  $.ajaxSetup({ cache: true });
  $.getScript('//connect.facebook.net/en_UK/all.js', function(){
    FB.init({
      appId: '472812626151651',
    });     
    $('#loginbutton,#feedbutton').removeAttr('disabled');
    FB.getLoginStatus(updateStatusCallback);
  });
});
</script>


<body>

<div class="gridContainer clearfix">
    <div id="Header"><?php include_once("header1.php");?>     
    </div>
  	<div id="heading">
  		<h3>Welcome <?php echo $fname;?>  <a href="index.php"> <img src="../Images/home.png"> </a> </h3>
  	</div>
   
  <div id="main_content" style="margin-top: 15%;">
   
  <iframe src="//www.facebook.com/plugins/facepile.php?app_id=472812626151651&amp;href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FThe-Gaylord-Restaurant%2F219983038085736%3Frf%3D127973883918936&amp;action&amp;width=100%25&amp;height&amp;max_rows=15&amp;colorscheme=light&amp;size=large&amp;show_count=true&amp;appId=472812626151651" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%px;" allowTransparency="true"></iframe>
   
   

  </div>


<div id="footer"><?php include_once("footer1.php");?></div>
</div>
</body>
</html>