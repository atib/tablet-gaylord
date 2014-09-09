<?php
session_start();

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$error_msg = ""; 
$success_msg = "";	
$username = $_SESSION['username'];
$basketMsg="";
$activeClient="";
$c_id="";
$o_activation="";
$clientSess = "";
$clientName = "";	
$o_id ="";	
$c_id = "";
$od_note="";
$basket = ""; 
$total  = "";	
$activation ="";
$activateorderid ="";
$orderMenu ="";
$menuHeading  = "";
$clientName = "";	
$p_id ="";	
$cat = "";
$orderrow ="";
$menuTitle ="";
$table_basket="";
$table_basketMsg ="";
$discount="";
$table_grandtotal ="";
$complete_btn="";
$cashDisc="";
$grandtotal="";
$percentDisc="";

//To be used for load more function, in the future
$item_per_page = 5;

if(isset($_GET['ac'])!=""){

	$o_activation = $_GET['ac'];

} else if(isset($_POST['o_activation'])){
		
	$o_activation = $_POST['o_activation'];
		
}else {
	header("Location: vieworder.php?err=$error_msg");
    exit();	
}

if(isset($_GET['err'])){
	$error_msg = $_GET['err'];
	$success_msg = "";
} else if(isset($_GET['succ'])){
	$error_msg = "";
	$success_msg  = $_GET['succ'];
}else{
	$error_msg = "";
	$success_msg  = "";	
}

if (isset($_POST['userSelect'])){

	 $user_clientSess = $_POST['clientSess'];
	 $user_clientName = $_POST['clientName'];	
	 $user_o_id = $_POST['o_id'];	
	 $user_c_id = $_POST['c_id'];	
	 
	 $_SESSION['user_clientSess'] = $user_clientSess;
	 $_SESSION['user_clientName'] = $user_clientName;
	 $_SESSION['user_o_id'] = $user_o_id;
	 $_SESSION['user_c_id'] = $user_c_id;
	 
	if ($user_clientName !=""){
		
		 $activeClient = $user_clientName;

	}else{
		
		 $activeClient ="No User Selected";	

	}
}	
		
if(!isset($_SESSION['username'])){
	
	$error_msg = "";
    header("Location: index.php?err=$error_msg");
    exit();
	
}

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
	$menuTitle = "Table ORDER";		

	}else{
	$cat = "1";
	$selectedMenu = $cat;
	$menuTitle = "SHURUAT - APPETISERS";		

}
}

if($cat == 14){
	
// Basket script goes here	
//########################################################################################################################
//#######Display baskey content from database#############################################################################
//########################################################################################################################
	
if ($o_activation != ""){
	
	if (isset($_POST['noteupdate'])){

	$comment = $_POST['comment'];
	$o_id = $_POST['o_id'];
	$od_id = $_POST['od_id'];

	include_once("db_connect.php");

	$updateNote_order = "UPDATE orderdetail_tbl SET od_note = '$comment' WHERE o_id = '$o_id' AND od_id = '$od_id'";
	$updateNote_order_db = mysqli_query($db_connection, $updateNote_order) or die (mysqli_error($db_connection));
	
}
	
	
	
	
	
	include_once("db_connect.php");


	$sql_clientorder_list = "SELECT * FROM order_tbl INNER JOIN orderdetail_tbl ON orderdetail_tbl.o_id = order_tbl.o_id
						WHERE order_tbl.o_activation='$o_activation' GROUP BY orderdetail_tbl.od_clientname ASC";
				
	$get_clientorder_db = mysqli_query($db_connection, $sql_clientorder_list) or die (mysqli_error($db_connection));

	while ($orderrow = mysqli_fetch_assoc($get_clientorder_db)){
		
		$o_id = $orderrow['o_id'];
		$c_id = $orderrow['c_id'];
		$od_clientname = $orderrow['od_clientname'];
		$od_session = $orderrow['od_session'];
		

		
			$basket .= '<div id="clientOrder">'.$od_clientname.'
			
			</div>
			<div id="clientOrderBtn">
			<form action="displayorder.php?ac='.$o_activation.'&cat=14&cn='.$od_clientname.'" method="post">
			<input name="clientName" type="hidden" value="'.$od_clientname.'">
			<input name="clientSess" type="hidden" value="'.$od_session.'">
			<input name="o_id" type="hidden" value="'.$o_id.'">
			<input name="c_id" type="hidden" value="'.$c_id.'">
			<input name="o_activation" type="hidden" value="'.$o_activation.'">
			<input name="userSelect" type="submit" value="Select Customer">
			
			</form>
			</div>
			
			';
	$total =0;

	$sql_product_list = "SELECT * FROM order_tbl INNER JOIN orderdetail_tbl ON orderdetail_tbl.o_id = order_tbl.o_id
						INNER JOIN product_tbl ON product_tbl.p_id = orderdetail_tbl.p_id
						WHERE order_tbl.o_activation='$o_activation' AND orderdetail_tbl.o_id='$o_id' 
						AND orderdetail_tbl.od_clientname='$od_clientname' ORDER BY orderdetail_tbl.od_clientname ASC";
				
	$get_product_db = mysqli_query($db_connection, $sql_product_list) or die (mysqli_error($db_connection));
						
		while ($row = mysqli_fetch_assoc($get_product_db)){
		
		$p_applydiscount = $row['p_applydiscount'];
		$o_cashdisc	= $row['o_cashdisc'];	
		$o_percentCash= $row['o_percentCash'];
		$orderComment= $row['o_tableNote'];
		$od_note= $row['od_note'];
		if ($p_applydiscount == 1){
			 
		$dis_sub = $row['od_quantity']* $row['od_price']; // product which discount is applicable (sum of)
		
		}else{
		
		$no_dis_sub = $row['od_quantity']* $row['od_price']; // product which discount is not applicable (sum of)
	
		}
		
		
		if ($od_note ==""){
			$od_note ="";
		}
			
		$basket .= '
		<div id="UserCart">
				
		<div id="dishName">'.$row['od_prodname'].'</div>
				
				
		<div id="quant">'.$row['od_quantity'].' x &pound;' .number_format ($row['od_price'], 2). '</div>
				
		<div id="cost">
		<a href="displayorder.php?ac='.$o_activation.'&add='.$row['p_id'].'&pn='.$row['od_prodname'].'&cn='.$orderrow['od_clientname'].'&cat='.$row['pc_id'].'&pr='.$row['od_price'].'"  id="add_prod">+</a> 
		<a href="displayorder.php?ac='.$o_activation.'&remove='.$row['p_id'].'&pn='.$row['od_prodname'].'&cn='.$orderrow['od_clientname'].'&cat='.$row['pc_id'].'&pr='.$row['od_price'].'" id="dec_prod">-</a> 
		<a href="displayorder.php?ac='.$o_activation.'&delete='.$row['p_id'].'&pn='.$row['od_prodname'].'&cn='.$orderrow['od_clientname'].'&cat='.$row['pc_id'].'&pr='.$row['od_price'].'" id="del_prod">x</a>
		</div>
		<div id="dishComment">
		<form action="displayorder.php?ac='.$o_activation.'&cat=14" method="post">         	
		<textarea name="comment" class="" style="width:75%" rows="2" placeholder="Enter dish notes ">'.$od_note.'</textarea>
		<input name="o_id" type="hidden" value="'.$row['o_id'].'">
		<input name="od_id" type="hidden" value="'.$row['od_id'].'">

		<input name="noteupdate" type="submit" class="filter_continue" value="Update Note">
		</form>
		</div>

		</div>
		';	
		$total += $dis_sub + $no_dis_sub;
		
		}

	    $nettotal += $total;
		$displayNet = $nettotal;
		
		if ($total==0){	
	
	
		$basketMsg = '
				<div id="cartMsg">
					<p>'.$orderrow['od_clientname'].' Your cart is empty.</p>
					<p>Click the add link beside the dish to include it into the basket</p>
					<p>When you happy with the selected dish click check out to proces the basket</p>
			 	</div>';
	}
	else{
		
		
		$basket .= '<div id="usertotal">'.$orderrow['od_clientname'].' Bill Total Is: <span class="user_total_bill">&pound;'.number_format($total, 2).'</span></div>';
	}	
	$basket .='<div class="greylinethick"></div>';
}//client order while close
	
	if ($nettotal==0){	
		$table_basketMsg = '
				<div id="cartMsg">
					<p>Table order is empty.</p>
			 	</div>';
	}else{
	
	
	if ($o_cashdisc !=""){
		
	$nettotal = $nettotal - $no_dis_sub;	
	
	$nettotal = $nettotal - $o_cashdisc;
	
	$cashDisc = $o_cashdisc;

	$totalDiscount = $o_cashdisc;

	} else if ($o_percentCash !=""){
		
	$nettotal = $nettotal - $no_dis_sub;	
	
	$nettotal = $nettotal - $o_percentCash;
	
	$percentDisc = $o_percentCash;

	$totalDiscount = $o_percentCash;

	} else{
		
	$nettotal = $nettotal;	
	
	}	
		
	$grandtotal = $nettotal;	
	
	$update_order = "UPDATE order_tbl SET o_total = '$nettotal' WHERE o_id = '$o_id'";
	$update_order_db = mysqli_query($db_connection, $update_order) or die (mysqli_error($db_connection));
	
					
	} 

}	

/*	include_once("db_connect.php");
	$user_o_id  = $_SESSION['user_o_id'];
	$grandtotal = $nettotal;

	$sql_gettotal = "SELECT * FROM order_tbl WHERE o_id = '$user_o_id'";
	$sql_gettotal_db = mysqli_query($db_connection, $sql_gettotal) or die (mysqli_error($db_connection));
	
	while ($totalrow = mysqli_fetch_assoc($sql_gettotal_db)){
	echo $cashDisc = $totalrow['o_cashdisc'];
	echo $percentDisc = $totalrow['o_percentdisc'];
	echo $grandtotal = $totalrow['o_total']; // total saved on the order table (discount possibly applied)

	}
	
	//echo $totalDiscount = $o_cashdisc;
	echo $cashDisc;


	$cashDisc = $o_cashdisc;
	$percentDisc = $o_percentCash;
	$grandtotal = $nettotal;
	
if ($cashDisc !='' && $percentDisc =='0'){
	
	$grandtotal = $grandtotal - $cashDisc;
	$totalDiscount = $cashDisc;
	$percentDisc = "";
	$minus = "£ -";
	
	} else if ($cashDisc =='0.00' && $percentDisc !=''){
	
	$percentAmount = ($grandtotal/100)*$percentDisc;
	$grandtotal = $grandtotal - $percentAmount;
	$totalDiscount = $percentAmount;
	$cashDisc = "";
	$minus = "£ -";
	}else{
	
	$cashDisc = '';
	$percentDisc = '';
	$minus = "";
	$totalDiscount="";
	}
*/

##########################################################################################################################	
#######End of basket script###############################################################################################
##########################################################################################################################
	
}

else{
	include_once("db_connect.php");

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
		
		$user_clientName = $_GET['cn'];
		$orderMenu .= '
		
			<div id="menuHolder">
			<div class="prodName">'.$get_row['p_name'].'</div>
			<div class="prodsDesc">'.$get_row['p_sdesc'].' '.$spice.' '.$nut.'</div>
			<div class="prodPrice">£'.number_format($get_row['p_inprice'], 2).'</div>
			<div class="prodAdd">
			
			<a href="displayorder.php?ac='.$o_activation.'&add='.$get_row['p_id'].'&pn='.$get_row['p_name'].'&cn='.$user_clientName.'&cat='.$get_row['pc_id'].'&pr='.$get_row['p_inprice'].'">+</a>
			
			</div>
			'.$descRow.'
			</div>
		
		';
		}		
	mysqli_free_result($get_menu_db);

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
	$client_name = $_GET['cn'];
	$prod_name = $_GET['pn'];
	
	$user_clientSess  = $_SESSION['user_clientSess'];
	$user_clientName  = $_SESSION['user_clientName'];
	$user_o_id  = $_SESSION['user_o_id'];
	$user_c_id  = $_SESSION['user_c_id'];

	$page = 'http://lunarwebstudio.com/Demos/GaylordTablet/displayorder.php?ac='.$o_activation.'&cat=14';

	include_once("db_connect.php");

	$sql_product_check = "SELECT p_id FROM orderdetail_tbl WHERE p_id = '$p_id' AND od_session = '$user_clientSess'";

	$get_product_check_db = mysqli_query($db_connection, $sql_product_check) or die (mysqli_error($db_connection));

	
	$product_check = mysqli_num_rows($get_product_check_db); 
	//check to see if the product already within the cart
	if ($product_check == 0){ 
	$product_insert = "INSERT INTO orderdetail_tbl (p_id, pc_id, o_id, c_id, od_clientname, od_prodname, od_quantity, od_price, od_sum, od_session)
					VALUES ('$p_id','$pc_id','$user_o_id','$user_c_id','$user_clientName','$prod_name','1','$price','$price', '$user_clientSess')";
									
	$get_product_insert_db = mysqli_query($db_connection, $product_insert) or die (mysqli_error($db_connection));
							
	} else { 
	$product_update = "UPDATE orderdetail_tbl SET od_quantity = od_quantity + 1 WHERE od_session= '$user_clientSess' AND p_id = $p_id";
	
	$get_product_update_db = mysqli_query($db_connection, $product_update) or die (mysqli_error($db_connection));

	
	$sql_price ="SELECT * FROM orderdetail_tbl WHERE p_id = $p_id AND od_session = '$user_clientSess'";
	
	$get_sql_price_db = mysqli_query($db_connection, $sql_price) or die (mysqli_error($db_connection));

	
	
	while ($get_row = mysqli_fetch_assoc($get_sql_price_db)){
	$newSub = $get_row['od_quantity'] * $get_row['od_price'];
	}
	$update_subtotal = "UPDATE orderdetail_tbl SET od_sum = '$newSub' WHERE od_session = '$user_clientSess' AND p_id = $p_id";
	
	$get_update_subtotal_db = mysqli_query($db_connection, $update_subtotal) or die (mysqli_error($db_connection));

	}
	header('Location:'.$page);
}

##########################################################################################################################
// Remove item from the cart
//########################################################################################################################
//#######Remove items from the basket#####################################################################################
//########################################################################################################################
if (isset($_GET['remove'])){
	$p_id = $_GET['remove'];
	
	$pc_id = $_GET['cat'];
	$price = $_GET['pr'];
	$client_name = $_GET['cn'];
	$prod_name = $_GET['pn'];
	
	$user_clientSess  = $_SESSION['user_clientSess'];
	$user_clientName  = $_SESSION['user_clientName'];
	$user_o_id  = $_SESSION['user_o_id'];
	$user_c_id  = $_SESSION['user_c_id'];

	$page = 'http://lunarwebstudio.com/Demos/GaylordTablet/displayorder.php?ac='.$o_activation.'&cat=14';
	include_once("db_connect.php");
	
	$sql_product_call = "SELECT od_quantity FROM orderdetail_tbl WHERE p_id = $p_id AND od_session = '$user_clientSess'";
	$get_sql_product_call_db = mysqli_query($db_connection, $sql_product_call) or die (mysqli_error($db_connection));


	$row = mysqli_fetch_assoc($get_sql_product_call_db);
	$quantity_check = $row['od_quantity'];
	
	if ($quantity_check == 1){ 
		$product_Delete = "DELETE FROM orderdetail_tbl WHERE od_session = '$user_clientSess' AND p_id = '$p_id'";
		$get_product_Delete_db = mysqli_query($db_connection, $product_Delete) or die (mysqli_error($db_connection));

	} else { 
	--$quantity_check;

	$product_remove = "UPDATE orderdetail_tbl SET od_quantity = '$quantity_check' WHERE od_session = '$user_clientSess' AND p_id = '$p_id'";
	$get_product_remove_db = mysqli_query($db_connection, $product_remove) or die (mysqli_error($db_connection));

	$sql_price = "SELECT * FROM orderdetail_tbl WHERE p_id = '$p_id' AND od_session = '$user_clientSess'";
	$get_sql_price_db = mysqli_query($db_connection, $sql_price) or die (mysqli_error($db_connection));
	
	while ($get_row = mysqli_fetch_assoc($get_sql_price_db)){
	$newSub = $get_row['od_sum'] - $get_row['od_price'];
	}
	$update_subtotal = "UPDATE orderdetail_tbl SET od_sum = '$newSub' WHERE od_session = '$user_clientSess' AND p_id = '$p_id'";		
	$get_update_subtotal_db = mysqli_query($db_connection, $update_subtotal) or die (mysqli_error($db_connection));
	
							
		}
	header('Location:'.$page);
}

// Delete Item
if (isset($_GET['delete'])){
	$p_id = $_GET['delete'];
	
	$pc_id = $_GET['cat'];
	$price = $_GET['pr'];
	$client_name = $_GET['cn'];
	$prod_name = $_GET['pn'];
	
	$user_clientSess  = $_SESSION['user_clientSess'];
	$user_clientName  = $_SESSION['user_clientName'];
	$user_o_id  = $_SESSION['user_o_id'];
	$user_c_id  = $_SESSION['user_c_id'];

	$page = 'http://lunarwebstudio.com/Demos/GaylordTablet/displayorder.php?ac='.$o_activation.'&cat=14';
	
	$sql_product_check = "SELECT p_id FROM orderdetail_tbl WHERE p_id = '$p_id' AND od_session = '$user_clientSess'";
	$get_sql_product_check_db = mysqli_query($db_connection, $sql_product_check) or die (mysqli_error($db_connection));
	
	$product_check = mysqli_num_rows($get_sql_product_check_db); 
	//check to see if the product already within the cart
	if ($product_check != ""){ 
	$product_Delete = "DELETE FROM orderdetail_tbl WHERE od_session = '$user_clientSess' AND p_id = '$p_id'";
	$get_product_Delete_db = mysqli_query($db_connection, $product_Delete) or die (mysqli_error($db_connection));

	} else { 
	header('Location:'.$page);
	}
	header('Location:'.$page);
}

if (isset($_POST['update'])){

	$cashDisc = $_POST['cashdisc'];
	$percentDisc = $_POST['percentdisc'];	
	$orderComment = $_POST['comment'];	

	//echo $dis_sub .'<br>'; 
//	echo $no_dis_sub .'<br>'; 

// retrieves true total from order detail table suming all dishes up - without discount
	
	if ($cashDisc !='' && $percentDisc ==''){
	
	$grandtotal = $dis_sub - $cashDisc;
	$grandtotal = $grandtotal + $no_dis_sub;

	$totalDiscount = $cashDisc;
	$success_msg = "Cash Discount Applied";
	$percentDisc = "";
	$minus = "£ -";
	
	} else if ($cashDisc =='' && $percentDisc !=''){
	
	$percentAmount = ($dis_sub/100)*$percentDisc;
	
	$grandtotal = $dis_sub - $percentAmount;
	$grandtotal = $grandtotal + $no_dis_sub;

	$success_msg = "Percentage Discount Applied";
	$totalDiscount = $percentAmount;
	$cashDisc = "";
	$minus = "£ -";
	
	}else if ($cashDisc =='' && $percentDisc ==''){
	
	$cashDisc = '';
	$percentDisc = '';
	$success_msg = '';
	$minus = '';
	$totalDiscount="";

	}else{
	
	$cashDisc = '';
	$percentDisc = '';
	$minus = "";
	$totalDiscount="";

	$error_msg = "Please only use one discount option cash or percentage";
		
	$page = 'http://lunarwebstudio.com/Demos/GaylordTablet/displayorder.php?ac='.$o_activation.'&cat=14&err='.$error_msg.'';
	
	header('Location:'.$page);
	
	}

include_once("db_connect.php");

	$user_o_id  = $_SESSION['user_o_id'];

	$update_myorder = "UPDATE order_tbl SET o_cashdisc = '$cashDisc', o_percentCash = '$percentAmount', o_percentdisc='$percentDisc', o_total = '$grandtotal', o_tableNote='$orderComment' WHERE o_id = '$user_o_id'";
	$update_myorderdb = mysqli_query($db_connection, $update_myorder) or die (mysqli_error($db_connection));

	$page = 'http://lunarwebstudio.com/Demos/GaylordTablet/displayorder.php?ac='.$o_activation.'&cat=14&succ='.$success_msg.'';
	
	header('Location:'.$page);

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
<script type="text/javascript" src="Script/jquery.js" ></script>
<script src="Script/new_order_client.js"></script>

<body>
<div class="gridContainer clearfix">


  <div id="Header"><?php include_once("header.php");?>     
    <div id="heading">
      <h3>Welcome <?php echo $username;?> <a href="maincontroller.php"> <img src="Images/home.png"> </a> </h3>
   	</div>
  </div>  
    
    <div id="main_content">
 
      <div class="title">
        <h2>Display Order <span id="do_activation_code"><?php echo $o_activation; ?></span></h2>
      </div>

      <div class="title_print">

      	<h1> The Gaylord Tandoori Indian Restaurant </h1>
      	<h6>141 Manchester Road, Isle of Dogs 
      		<br/> London E14 3DN </h6>

        <h2>Order #<span id="do_activation_code"><?php echo $o_activation; ?></span></h2>

        <p class="receipt_date">
        	<?php
    		date_default_timezone_set('Europe/London');

			$todaydate = date("d-m-Y");
			$todaytime = date("H:i");

    		echo $todaydate." @ ".$todaytime;	
		?>
        </p>

        <div class="clear"></div>
      </div>
        
      	<div class="active_client" >
        	<?php echo $activeClient; ?>    
      	</div>

	<div class="error_message_activation">
		<?php echo $error_msg;?> 
	</div>

	<div class="success_activation">
		<h3><?php echo $success_msg; ?></h3>
  	</div>

  <div id="description_menu">
  	<?php echo $menuHeading;?>  	
  </div>

  <div id="takeawaymenuOption">
    <nav class="ordermenu">
        <a href="#" id="pull" class="push_down" ><?php echo $menuTitle;?> <?php echo ": ". $user_clientName; ?></a>  

        <ul class="ordermenu_list"> 
            <a class="myorder" id="basket_order_menu" href="?ac=<?php echo $o_activation;?>&cat=14&cn=<?php echo $user_clientName;?>" ><?php echo $user_clientName;?> CART <img src="Images/basket.png"> </a>
          	<a class="op" href="?ac=<?php echo $o_activation;?>&cat=1&cn=<?php echo $user_clientName;?>" >SHURUAT - APPETISERS</a>
            <a class="op" href="?ac=<?php echo $o_activation;?>&cat=2&cn=<?php echo $user_clientName;?>" >TANDOORI DISHES (DRY DISHES)</a>
            <a class="op" href="?ac=<?php echo $o_activation;?>&cat=3&cn=<?php echo $user_clientName;?>" >GAYLORD EXCLUSIVE NEW DISHES</a>
            <a class="op" href="?ac=<?php echo $o_activation;?>&cat=4&cn=<?php echo $user_clientName;?>" >OUR CHEF’S SPECIALITIES</a>
            <a class="op" href="?ac=<?php echo $o_activation;?>&cat=5&cn=<?php echo $user_clientName;?>" >GAYLORD CHICKEN SPECIALITIES</a>
            <a class="op" href="?ac=<?php echo $o_activation;?>&cat=6&cn=<?php echo $user_clientName;?>" >GAYLORD LAMB SPECIALITIES</a>
            <a class="op" href="?ac=<?php echo $o_activation;?>&cat=7&cn=<?php echo $user_clientName;?>" >GAYLORD SEAFOOD AND FISH SPECIALITIES</a>
            <a class="op" href="?ac=<?php echo $o_activation;?>&cat=8&cn=<?php echo $user_clientName;?>" >AKHANI AUR-BIRIYANI - RICE DISHES</a>
            <a class="op" href="?ac=<?php echo $o_activation;?>&cat=9&cn=<?php echo $user_clientName;?>" >GAYLORD VEGETARIAN SIDE DISHES</a>
            <a class="op" href="?ac=<?php echo $o_activation;?>&cat=10&cn=<?php echo $user_clientName;?>" >CHAWAL - RICE SIDE DISHES</a>
            <a class="op" href="?ac=<?php echo $o_activation;?>&cat=11&cn=<?php echo $user_clientName;?>" >NAN/ROTI - FLATBREAD</a>
            <a class="op" href="?ac=<?php echo $o_activation;?>&cat=12&cn=<?php echo $user_clientName;?>" >SUNDRIES &amp; OTHER EXTRAS</a>
            <a class="op" href="?ac=<?php echo $o_activation;?>&cat=13&cn=<?php echo $user_clientName;?>" >DRINKS</a>
            <a class="op" href="#" id="push_up">CLOSE</a>

        </ul>
    </nav>    
    </div>

	<?php echo $orderMenu;?>
	<?php echo $basket;?>
	<?php echo $basketMsg;?>
	<?php echo $table_basket;?>
	<?php echo $table_basketMsg;?>
	<?php //echo $discount; ?>
	<?php echo $table_grandtotal;?>    
	<?php echo $complete_btn;?>
    
   
	<div class="Order_discount">
	    <div class="buttons">
	      <form action="displayorder.php?ac=<?php echo $o_activation; ?>&cat=14&cn=<?php echo $od_clientname; ?>" method="post">
         	<textarea name="comment" class="" style="width:100%" rows="4" placeholder="Enter table notes "><?php echo $orderComment;?></textarea>
	        <input name="cashdisc" class="" type="tel" value="<?php echo $cashDisc;?>" placeholder="Cash Based Discount £">
	        <input name="percentdisc" class="" type="tel" value="<?php echo $percentDisc?>" placeholder="Percentage Based Discount %">
	        <div class="update_button">
		      	<input name="update" type="submit" class="filter_continue" value="Update">	        	
	        </div>
	      </form>  
	      </div>					
	</div>
					
	<div id="total_do_staff">
		<div id="nettotal">Net Total:  <span class="dp_or_staff">&pound;<?php echo number_format($displayNet, 2)?></span></div>
		<div id="discounttotal">Discount: <span class="dp_or_staff"><?php echo $minus;?><?php echo number_format($totalDiscount, 2);?></span></div>
		<div id="grandtotal">Grandtotal: <span class="dp_or_staff">&pound;<?php echo number_format($grandtotal, 2)?></span></div>	
	</div>	
	
	
	<div class="Order_complete">

		    <form action="printReciept" method="post">
		<div class="print_button">
	    		<input type="button" class="filter_continue" onClick="print()" value="Print Reciept">
                <input type="button" class="filter_continue" name="filter_pdf" value="Generate PDF">

		</div>
		    
		    </form>  
	       
	</div>
  		
  	    <div class="title_print bottom_receipt">
			<div class="clear"></div>
			<h6 >Tel: 020 7538 9826
			<br />Email: info@gaylordrestaurant.co.uk </h6>
            <p class="break_page"></p>
      </div>

  	<div id="flash"> Item added to cart </div>
  	<div id="flash_dec"> Updated cart </div>
  	<div id="flash_rem"> Item(s) removed from cart </div>
   
</div>
   
  <div id="footer"><?php include_once("footer.php");?></div>
</body>
</html>