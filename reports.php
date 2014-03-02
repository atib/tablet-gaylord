<?php
session_start();

if(!isset($_SESSION['username'])){
	
	$error_msg="Unauthorised Access";
    header("Location: maincontroller.php?err=$error_msg");
	exit();
}
?>
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<?php include_once('head.php'); ?>
<script>
	
	$(document).ready(function(){
			var pull 		= $('#pull');
			var push_up = $("#push_up");
			menu 		= $('.reportmenu .reportmenu_list');
			menuHeight	= menu.height();

		$(pull).on('click', function(e) {
			e.preventDefault();
			menu.slideToggle();
		});

		$(push_up).on('click', function(e) {
			e.preventDefault();
			menu.slideToggle();
		});

		$(window).resize(function(){
      		var w = $(window).width();
      		if(w > 320 && menu.is(':hidden')) {
      			menu.removeAttr('style');
      		}
  		});

  		$('.prodAdd a').click(function(){
  			
  			// Need to look at this function a little more in depth 
				$('#flash').show().delay(2000).fadeOut(500);
  		});
	});
</script>

<body>
<div class="gridContainer clearfix">

    <div id="Header"><?php include_once("header.php");?>     
      <div id="heading">
        <h3>Welcome <?php echo $username;?> <a href="maincontroller.php"> <img src="Images/home.png"> </a> </h3>
      </div>
    </div>  

    <div id="main_content">

      <div class="title">
        <h2>Reports</h2>
      </div>
 <nav class="reportmenu">
	        <a href="#" id="pull">You are currently viewing: <br/> <?php echo $selectpage;?></a>  

	        <ul class="reportmenu_list"> 
	          	<a class="op" href="?cat=1" >Active Tablet</a>
	            <a class="op" href="?cat=2" >Today Active Order</a>
	            <a class="op" href="?cat=3" >Todays Closed Order</a>
	            <a class="op" href="?cat=4" >Cash Up</a>
	            <a class="op" href="?cat=5" >Generate Report</a>
	            <a class="op" href="#" id="push_up">CLOSE</a>
	        </ul>
	    </nav>    

            <?php echo $error_msg;?> <?php $success_msg; ?>
  </div>
     
    


	
<div id="footer"><?php include_once("footer.php");?></div>
</div>
</body>
</html>