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

if (isset($_GET['cat'])){
	$cat=$_GET['cat'];
	
	if ($cat == "1"){
	 $menuTitle = "SHURUAT - APPETISERS";	
	 $selectedMenu = $cat;
	 	
	} else if ($cat == "2"){
	 $menuTitle = "TANDOORI DISHES (DRY DISHES)";	
	 $selectedMenu = $cat;
	 
 	} else if ($cat == "3"){
	 $menuTitle = "GAYLORD EXCLUSIVE NEW DISHES";	
	  $selectedMenu = $cat;
	 	 
	}else if ($cat == "4"){
	 $menuTitle = "OUR CHEF’S SPECIALITIES";	
	 $selectedMenu = $cat;
	 
	}else if ($cat == "5"){
	 $menuTitle = "GAYLORD CHICKEN SPECIALITIES";	
	 $selectedMenu = $cat;
	 
	}else if ($cat == "6"){
	 $selectedMenu = $cat;
	 $menuTitle = "GAYLORD LAMB SPECIALITIES";		
	 
	}else if ($cat == "7"){
	 $selectedMenu = $cat;
	 $menuTitle = "GAYLORD SEAFOOD AND FISH SPECIALITIES";		
	 
	}else if ($cat == "8"){
	 $selectedMenu = $cat;
	 $menuTitle = "AKHANI AUR-BIRIYANI - RICE DISHES";		
	 
	}else if ($cat == "9"){
	 $selectedMenu = $cat;
	 $menuTitle = "GAYLORD VEGETARIAN SIDE DISHES";		
	 
	}else if ($cat == "10"){
	 $selectedMenu = $cat;
	 $menuTitle = "CHAWAL - RICE SIDE DISHES";		

	}else if ($cat == "11"){
	 $selectedMenu = $cat;
	 $menuTitle = "NAN/ROTI - FLATBREAD";		

	}else if ($cat == "12"){
	 $selectedMenu = $cat;
	 $menuTitle = "SUNDRIES & OTHER EXTRAS";		
	
	}else if ($cat == "13"){
	$selectedMenu = $cat;
	 $menuTitle = "DRINKS";		
	
	}else if ($cat == "14"){
	$selectedMenu = $cat;
	$menuTitle = 'MY BASKET ';		

	}else{
	$cat = "1";
	$selectedMenu = $cat;
	$menuTitle = "SHURUAT - APPETISERS";		

}
}
   

	include_once ("db_connect.php");
	if($cat == 14){
	
// Basket script goes here	
//########################################################################################################################
//#######Display baskey content from database#############################################################################
//########################################################################################################################
	
	$crt_sess = session_id();
	if ($crt_sess != ""){
	
	include_once("db_connect.php");
	
	$crt_sess = $_SESSION['crt_sess'];
	$fname = $_SESSION['fname'];
	
	$insert_client = "UPDATE cart_tbl SET  user_name = '$fname'
	WHERE crt_sess = '$crt_sess'";

	$sql_product_list = "SELECT * FROM cart_tbl INNER JOIN product_tbl ON product_tbl.p_id = cart_tbl.p_id
												INNER JOIN client_tbl ON client_tbl.c_id = cart_tbl.c_id
						WHERE cart_tbl.crt_sess='$crt_sess' ORDER BY product_tbl.pc_id ASC";
				
	$get_product_db = mysqli_query($db_connection, $sql_product_list) or die (mysqli_error($db_connection));
			
	

	$insert_client_db = mysqli_query($db_connection, $insert_client) or die (mysqli_error($db_connection));
	
				
				while ($row = mysqli_fetch_assoc($get_product_db)){
				$sub = $row['crt_qt']* $row['crt_price'];
				
				$basket .= '
				<div id="UserCart">
				
				<div id="dishName">'.$row['crt_name'].'</div>
				
				
				<div id="quant">'.$row['crt_qt'].' x &pound;' .number_format ($row['crt_price'], 2). '</div>
				
				<div id="cost">


				<a href="neworder.php?add='.$row['p_id'].'&cat=14" id="add_prod" >+</a> 
				<a href="neworder.php?remove='.$row['p_id'].'&cat=14" id="dec_prod" >-</a> 
				<a href="neworder.php?delete='.$row['p_id'].'&cat=14" id="del_prod" >x</a>


				</div>
				
				<hr>
				</div>
				';	
				$total += $sub;
				}
			
	
	if ($total==0){	
	
	
		$basketMsg = '
				<div id="cartMsg">
					<p>'.$row['user_name'].' Your cart is empty.</p>
					<p>Click the add link beside the dish to include it into the basket</p>
					<p>When you happy with the selected dish click check out to proces the basket</p>
			 	</div>';
	}
	else{
		
	$crt_sess = $_SESSION['crt_sess'];
	$activation = $_SESSION['activation'];
	$activateorderid = $_SESSION['activateorderid'];
	$c_id = $_SESSION['c_id'];
		
		$grandtotal= '<div id="usertotal">'.$fname.' Your Bill Total Is: &pound;<span class="user_total_bill"> '.number_format($total, 2).'</span></div>';
		$complete_btn = '<div class="Order_complete">
						<span>Once you are happy with your order, click the complete button to process your order. A waiter will come and confirm your order.</span>

  						<div class="buttons">
						<form action="orderProcess.php" method="post" target="_self" enctype="multipart/form-data">
						
						<div class ="continue_button">
						<input type="submit" name="complete" value="Next Step" class="" />
						</div>
						<input name="complete" type="hidden" value="incomplete">
						<input name="crt_sess" type="hidden" value="'.$crt_sess.'">
						<input name="activation" type="hidden" value="'.$activation.'">
						<input name="activateorderid" type="hidden" value="'.$activateorderid.'">
						<input name="c_id" type="hidden" value="'.$c_id.'">

						</div>
						</form>
					</div>
					<div id="table_order_title">
					<h2> Table Order </h2>
					</div>';
	}
	
	// table basket

	 $activation = $_SESSION['activation'];
	 $activateorderid = $_SESSION['activateorderid'];
	
	$sql_table_product_list = "SELECT * FROM cart_tbl INNER JOIN product_tbl ON product_tbl.p_id = cart_tbl.p_id
													INNER JOIN client_tbl ON client_tbl.c_id = cart_tbl.c_id
					WHERE cart_tbl.o_activation='$activation' AND cart_tbl.o_id = '$activateorderid' ORDER BY cart_tbl.crt_sess ASC";
				
	$get_table_product_db = mysqli_query($db_connection, $sql_table_product_list) or die (mysqli_error($db_connection));
			
				$total ="";
				while ($t_row = mysqli_fetch_assoc($get_table_product_db)){
				$sub = $t_row['crt_qt']* $t_row['crt_price'];
				
				$table_basket .= '
				<div id="table_order">
					<div id="table_order_section">
					
					<div id="dish_name_table">'.$t_row['crt_name'].'</div>
					
					
					<div id="cost_table">'.$t_row['crt_qt'].' x &pound;' .number_format ($t_row['crt_price'], 2). '</div>
					
					<div id="user_name_total">
					'.$t_row['user_name'].'
					</div>
					
					</div>
				</div>
				';	
				$total += $sub;
				}
			
	
	if ($total==0){	
		$table_basketMsg = '
				<div id="cartMsg">
			 	</div>';
	}
	else{
		
		$table_grandtotal= '<div id="usertotal"><span class="table_total">Total Table Bill: &pound;'.number_format($total, 2).'</span></div>';
		
	} 

}	
	
##########################################################################################################################	
#######End of basket script###############################################################################################
##########################################################################################################################
	
	}else{

	$get_category = "SELECT * FROM product_tbl INNER JOIN productcat_tbl ON productcat_tbl.pc_id = product_tbl.pc_id WHERE productcat_tbl.pc_id = '$selectedMenu' AND product_tbl.p_active= '1' ORDER BY product_tbl.p_id ASC";
	
	
	$get_category_db = mysqli_query($db_connection, $get_category) or die (mysqli_error($db_connection));
	$get_menu_db = mysqli_query($db_connection, $get_category) or die (mysqli_error($db_connection));
		
		
		$row_check = mysqli_num_rows($get_category_db);
		
	if ($row_check >= 1){
		
	if ($get_category_row = mysqli_fetch_assoc($get_category_db))
		{
		
		$heading = $get_category_row ['pc_name'];
		$description = $get_category_row ['pc_desc'];
		
		$menuHeading .= '
		
		<div id="menuCat">
		<div class="menuHeading">'. $heading .'</div>
		<div class="menuDescription">'. $description .'</div>
		</div>
		
		';
		}
		mysqli_free_result($get_category_db);

		while ($get_row = mysqli_fetch_assoc($get_menu_db)){

		if ($get_row['p_ldesc'] == ""){
			$descRow = "";
		} else{
			$descRow = '
			<div class="prodlDesc">'.$get_row['p_ldesc'].'</div>
			';
		}
		
		if ($get_row['p_spice'] == "0"){
			$spice = "";
		} else{
			$spice = $get_row['p_spice'];
		}
		
		if ($get_row['p_nut'] == "0"){
			$nut = "";
		} else{
			$nut = $get_row['p_nut'];
		}
		
		$orderMenu .= '
		
			<div id="menuHolder">
			<div class="prodName">'.$get_row['p_name'].'</div>
			<div class="prodsDesc">'.$get_row['p_sdesc'].' '.$spice.' '.$nut.'</div>
			<div class="prodPrice">£'.number_format($get_row['p_inprice'], 2).'</div>

			<div class="prodAdd">
			<a href="neworder.php?add='.$get_row['p_id'].'&pn='.$get_row['p_name'].'&cat='.$get_row['pc_id'].'&pr='.$get_row['p_inprice'].'&par='.$par.'">+</a>		
			</div>

			'.$descRow.'
			</div>
		
		';
		}		
	mysqli_free_result($get_menu_db);

	}else{
		
	$page = "http://lunarwebstudio.com/Demos/GaylordTablet/user/neworder.php";
	
	header('Location:'.$page .'?cat=14');
		
	}
		
}	


##########################################################################################################################
// Add items onto the basket
//########################################################################################################################
//#######ADD items from basket#########################################################################################
//########################################################################################################################
if (isset($_GET['add'])){
	$p_id = $_GET['add'];
	$pc_id = $_GET['cat'];
	$price = $_GET['pr'];
	$crt_name = $_GET['pn'];

	$page = "http://lunarwebstudio.com/Demos/GaylordTablet/user/neworder.php";
	
	if ($pc_id != ""){
	$location  = ''.$page.'?cat='.$pc_id.'';
	} else {
	$location  = $page ."?cat=1";	
	}
	include_once("db_connect.php");

	$_SESSION['crt_sess'] = session_id();
	$crt_sess = $_SESSION['crt_sess'];
	$activation = $_SESSION['activation'];
	$activateorderid = $_SESSION['activateorderid'];
	$c_id = $_SESSION['c_id'];
	$fname = $_SESSION['fname'];

	$sql_product_check = "SELECT p_id FROM cart_tbl WHERE p_id = '$p_id' AND crt_sess = '$crt_sess'";

	$get_product_check_db = mysqli_query($db_connection, $sql_product_check) or die (mysqli_error($db_connection));

	
	$product_check = mysqli_num_rows($get_product_check_db); 
	//check to see if the product already within the cart
	if ($product_check == 0){ 
	$product_insert = "INSERT INTO cart_tbl (p_id, pc_id, o_id, c_id,user_name, o_activation, crt_name, crt_qt, crt_price, crt_sum, crt_sess, crt_date)
					VALUES ('$p_id','$pc_id','$activateorderid','$c_id','$fname','$activation','$crt_name', '1','$price','$price', '$crt_sess', NOW())";
									
	$get_product_insert_db = mysqli_query($db_connection, $product_insert) or die (mysqli_error($db_connection));
							
	} else { 
	$product_update = "UPDATE cart_tbl SET crt_qt = crt_qt + 1 WHERE crt_sess= '$crt_sess' AND p_id = $p_id";
	
	$get_product_update_db = mysqli_query($db_connection, $product_update) or die (mysqli_error($db_connection));

	
	$sql_price ="SELECT * FROM cart_tbl WHERE p_id = $p_id AND crt_sess = '$crt_sess'";
	
	$get_sql_price_db = mysqli_query($db_connection, $sql_price) or die (mysqli_error($db_connection));

	
	
	while ($get_row = mysqli_fetch_assoc($get_sql_price_db)){
	$newSub = $get_row['crt_qt'] * $get_row['crt_price'];
	}
	$update_subtotal = "UPDATE cart_tbl SET crt_sum = '$newSub' WHERE crt_sess = '$crt_sess' AND p_id = $p_id";
	
	$get_update_subtotal_db = mysqli_query($db_connection, $update_subtotal) or die (mysqli_error($db_connection));

	}
	header('Location:'.$location);
}

##########################################################################################################################
// Remove item from the cart
//########################################################################################################################
//#######Remove items from the basket#####################################################################################
//########################################################################################################################
if (isset($_GET['remove'])){
	$p_id = $_GET['remove'];
	
	$pc_id = $_GET['cat'];
	
	$page = "http://lunarwebstudio.com/Demos/GaylordTablet/user/neworder.php";

	if ($pc_id != ""){
	$location  = ''.$page.'?cat='.$pc_id.'';
	} else {
	$location  = $page ."cat=1";	
	}
		
	$_SESSION['crt_sess'] = session_id();
	$crt_sess = $_SESSION['crt_sess'];
	
	include_once("db_connect.php");

	
	$sql_product_call = "SELECT crt_qt FROM cart_tbl WHERE p_id = $p_id AND crt_sess = '$crt_sess'";
	$get_sql_product_call_db = mysqli_query($db_connection, $sql_product_call) or die (mysqli_error($db_connection));


	$row = mysqli_fetch_assoc($get_sql_product_call_db);
	$quantity_check = $row['crt_qt'];
	
	if ($quantity_check == 1){ 
		$product_Delete = "DELETE FROM cart_tbl WHERE crt_sess = '$crt_sess' AND p_id = '$p_id'";
		$get_product_Delete_db = mysqli_query($db_connection, $product_Delete) or die (mysqli_error($db_connection));

	} else { 
	--$quantity_check;

	$product_remove = "UPDATE cart_tbl SET crt_qt = '$quantity_check' WHERE crt_sess = '$crt_sess' AND p_id = '$p_id'";
	$get_product_remove_db = mysqli_query($db_connection, $product_remove) or die (mysqli_error($db_connection));

	$sql_price = "SELECT * FROM cart_tbl WHERE p_id = '$p_id' AND crt_sess = '$crt_sess'";
	$get_sql_price_db = mysqli_query($db_connection, $sql_price) or die (mysqli_error($db_connection));
	
	while ($get_row = mysqli_fetch_assoc($get_sql_price_db)){
	$newSub = $get_row['crt_sum'] - $get_row['crt_price'];
	}
	$update_subtotal = "UPDATE cart_tbl SET crt_sum = '$newSub' WHERE crt_sess = '$crt_sess' AND p_id = '$p_id'";		
	$get_update_subtotal_db = mysqli_query($db_connection, $update_subtotal) or die (mysqli_error($db_connection));
	
							
		}
	header('Location:'.$page);
}

// Delete Item
if (isset($_GET['delete'])){
	$p_id = $_GET['delete'];
	
	$pc_id = $_GET['cat'];
	
	$page = "http://lunarwebstudio.com/Demos/GaylordTablet/user/neworder.php";

	if ($pc_id != ""){
	$location  = ''.$page.'?cat='.$pc_id.'';
	} else {
	$location  = $page ."?cat=1";	
	}
		
	$_SESSION['crt_sess'] = session_id();
	$crt_sess = $_SESSION['crt_sess'];
	
	$sql_product_check = "SELECT p_id FROM cart_tbl WHERE p_id = '$p_id' AND crt_sess = '$crt_sess'";
	$get_sql_product_check_db = mysqli_query($db_connection, $sql_product_check) or die (mysqli_error($db_connection));

	
	$product_check = mysqli_num_rows($get_sql_product_check_db); 
	//check to see if the product already within the cart
	if ($product_check != ""){ 
	$product_Delete = "DELETE FROM cart_tbl WHERE crt_sess = '$crt_sess' AND p_id = '$p_id'";
	$get_product_Delete_db = mysqli_query($db_connection, $product_Delete) or die (mysqli_error($db_connection));

	} else { 
	header('Location:'.$page .'?cat=14');
	}
	header('Location:'.$page);
}

?>
<!doctype html>
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
			menu 		= $('.ordermenu .ordermenu_list');
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
			$('#flash').show().delay(2000).fadeOut(500);
  		});

  		$('#add_prod').click(function(){  			
			$('#flash').show().delay(2000).fadeOut(500);
  		});

  		$('#dec_prod').click(function(){  			
			$('#flash_dec').show().delay(2000).fadeOut(500);
  		});

  		$('#del_prod').click(function(){  			
			$('#flash_rem').show().delay(2000).fadeOut(500);
  		});
	});
</script>

<?php 

include_once("db_connect.php");	
$crt_sess = $_SESSION['crt_sess'];

$cart_user_quant = "SELECT SUM(crt_qt) AS quantity FROM cart_tbl WHERE crt_sess = '$crt_sess'";
$get_usr_crt_qt = mysqli_query($db_connection, $cart_user_quant) or die (mysqli_error($db_connection));

while ($row = mysqli_fetch_assoc($get_usr_crt_qt)) {
	$_SESSION['usr_qt_crt'] = $row['quantity'];
	$usr_crt_quant = $_SESSION['usr_qt_crt'];
	
}

?>

<body>

<div class="gridContainer clearfix">
    <div id="Header"><?php include_once("header1.php");?>     
    </div>
  	<div id="heading">
  		<h3>Welcome <?php echo $fname;?>  <a href="index.php"> <img src="../Images/home.png"> </a> </h3>
  	</div>
   
  <div id="main_content" style="margin-top: 15%;">
    
    <div class="title">
      <h3>View Menu</h3>
      <div class="basket_icon">
	      <img id="basket" src="../Images/basket_grey.png"><?php 
	      if ($usr_crt_quant > 0) {
	      	echo $usr_crt_quant;
	      }
	      else {
	      	echo "0";
	      }
	      ?> items
      </div>
    </div>

    <div id="takeawaymenuOption">
	    <nav class="ordermenu">
	        <a href="#" id="pull">You are currently viewing: <br/> <?php echo $menuTitle;?></a>  

	        <ul class="ordermenu_list"> 
	            <a class="myorder" href="?cat=14" id="basket_order_menu"> <img src="../Images/basket.png"> My Basket  (Items currently in basket: <?php 
	            	      if ($usr_crt_quant > 0) {
					      	echo $usr_crt_quant;
					      }
					      else {
					      	echo "0";
					      }
	      			?>) 
	      		</a>
	          	<a class="op" href="?cat=1" >SHURUAT - APPETISERS</a>
	            <a class="op" href="?cat=2" >TANDOORI DISHES (DRY DISHES)</a>
	            <a class="op" href="?cat=3" >GAYLORD EXCLUSIVE NEW DISHES</a>
	            <a class="op" href="?cat=4" >OUR CHEF’S SPECIALITIES</a>
	            <a class="op" href="?cat=5" >GAYLORD CHICKEN SPECIALITIES</a>
	            <a class="op" href="?cat=6" >GAYLORD LAMB SPECIALITIES</a>
	            <a class="op" href="?cat=7" >GAYLORD SEAFOOD AND FISH SPECIALITIES</a>
	            <a class="op" href="?cat=8" >AKHANI AUR-BIRIYANI - RICE DISHES</a>
	            <a class="op" href="?cat=9" >GAYLORD VEGETARIAN SIDE DISHES</a>
	            <a class="op" href="?cat=10" >CHAWAL - RICE SIDE DISHES</a>
	            <a class="op" href="?cat=11" >NAN/ROTI - FLATBREAD</a>
	            <a class="op" href="?cat=12" >SUNDRIES &amp; OTHER EXTRAS</a>
	            <a class="op" href="?cat=13" >DRINKS</a>
	            <a class="op" href="#" id="push_up">CLOSE</a>
	        </ul>
	    </nav>    
  	</div>
  
  	<div id="flash">
  	Item added to cart
  	</div>
  	<div id="flash_dec">
  	Updated cart
  	</div>
  	<div id="flash_rem">
  	Item(s) removed from cart
  	</div>

<?php echo $error_msg; ?> <?php echo $success_msg; ?>
<?php echo $orderMenu;?>
<?php echo $basket;?>
<?php echo $basketMsg;?>
<?php echo $grandtotal;?>
<?php echo $complete_btn;?>
<?php echo $table_basket;?>
<?php echo $table_basketMsg;?>
<?php echo $table_grandtotal;?>

  </div>






<div id="footer"><?php include_once("footer1.php");?></div>
</div>
</body>
</html>