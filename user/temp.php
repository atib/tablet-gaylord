if (isset($_GET['cat'])){
	$menu=$_GET['cat'];
	
	if ($cat == "1"){
	 $menuTitle = "SHURUAT - APPETISERS";	
	 $selectedMenu = SHURUAT_APPETISERS();
	 	
	} else if ($cat == "2"){
	 $menuTitle = "TANDOORI DISHES (DRY DISHES)";	
	 $selectedMenu = TANDOORI_DISHES();
	 
 	} else if ($cat == "3"){
	 $menuTitle = "GAYLORD EXCLUSIVE NEW DISHES";	
	 $selectedMenu = NEW_DISHES();
	 	 
	}else if ($cat == "4"){
	 $menuTitle = "OUR CHEF’S SPECIALITIES";	
	 $selectedMenu = CHEF_SPECIALITIES();
	 
	}else if ($cat == "5"){
	 $menuTitle = "GAYLORD CHICKEN SPECIALITIES";	
	 $selectedMenu = CHICKEN_SPECIALITIES();
	 
	}else if ($cat == "6"){
	 $selectedMenu = LAMB_SPECIALITIES();
	 $menuTitle = "GAYLORD LAMB SPECIALITIES";		
	 
	}else if ($cat == "7"){
	 $selectedMenu = SEAFOOD_SPECIALITIES();
	 $menuTitle = "GAYLORD SEAFOOD AND FISH SPECIALITIES";		
	 
	}else if ($cat == "8"){
	 $selectedMenu = RICE_DISHES();
	 $menuTitle = "AKHANI AUR-BIRIYANI - RICE DISHES";		
	 
	}else if ($cat == "9"){
	 $selectedMenu = VEG_SIDE_DISHES();
	 $menuTitle = "GAYLORD VEGETARIAN SIDE DISHES";		
	 
	}else if ($cat == "10"){
	 $selectedMenu = CHAWAL_SIDE_DISHES();
	 $menuTitle = "CHAWAL - RICE SIDE DISHES";		

	}else if ($cat == "11"){
	 $selectedMenu = FLATBREAD();
	 $menuTitle = "NAN/ROTI - FLATBREAD";		

	}else if ($cat == "12"){
	 $selectedMenu = SUNDRIES();
	 $menuTitle = "SUNDRIES & OTHER EXTRAS";		
	
	}else if ($cat == "13"){
	$selectedMenu = DRINKS();
	 $menuTitle = "DRINKS";		
	
	}else if ($cat == "14"){
	$selectedMenu = MY_ORDER();
	$menuTitle = "MY ORDER";		

	}else{
	$selectedMenu = SHURUAT_APPETISERS();
	$menuTitle = "SHURUAT - APPETISERS";		

}
}




------------------


if ($get_category_db == '0') {
	echo "There are no products available!";
	}
	else{
	 
	if ($get_category_row = mysqli_fetch_assoc($get_category_db))
	{
 	
	echo $get_category_row;
	$heading = $get_category_row ['pc_name'];
	$description = $get_category_row ['pc_desc'];
	
	$menuHeading .= '
	
	<div id="menuCat">
	<div class="menuHeading">'. $heading .'</div>
	<div class="menuDescription">'. $description .'</div>
	</div>
	
	';
	}
			
	while ($get_row = mysqli_fetch_assoc($get_category_db)){
	
	if ($get_row['p_ldesc'] == ""){
		$descRow = "";
	} else{
		$descRow = '
		<div class="prodlDesc">Bangladeshi Telapia fish, marinated and grilled over charcoal on skewers</div>
		';
	}
	
	$orderMenu .= '
	
		<div id="menuHolder">
		<div class="prodName">'.$get_row['p_name'].'</div>
		<div class="prodsDesc">'.$get_row['p_sdesc'].' '.$get_row['p_spice'].' '.$get_row['p_nut'].'</div>
		<div class="prodPrice">£'.number_format($get_row['p_inprice'], 2).'</div>
		<div class="prodAdd">
		
		<a href="cart.php?add='.$get_row['p_id'].'&cat='.$get_row['pc_id'].'&pr='.$get_row['p_inprice'].'&par='.$par.'"><font style="color:#C00; font-weight:bolder; font-size:14px;" >Add</font></a>
		
		</div>
		'.$descRow.'
		</div>
	
	';
	
	}
	}
    
    
    
    		if ($get_row['p_ldesc'] == ""){
			$descRow = "";
		} else{
			$descRow = '
			<div class="prodlDesc">Bangladeshi Telapia fish, marinated and grilled over charcoal on skewers</div>
			';
		}
		
        
        
        --------------------------------------------
        
        
// Remove item from the cart
if (isset($_GET['remove'])){
	$p_id = $_GET['remove'];
	
	$pc_id = $_GET['cat'];
	
	if ($pc_id != ""){
	$page  = ''.$location.'.php?cat='.$pc_id.'';
	} else {
	$page  = $location ."cat=1";	
	}
		
	$_SESSION['crt_sess'] = session_id();
	$crt_sess = $_SESSION['crt_sess'];
	
	$sql_product_call = "SELECT crt_qt FROM cart_tbl WHERE p_id = $p_id AND crt_sess = '$crt_sess'";
	$get_sql_product_call_db = mysqli_query($db_connection, $sql_product_call) or die (mysqli_error($db_connection));


	$row = mysqli_fetch_assoc($get_sql_product_call_db);
	$quantity_check = $row['crt_qt'];
	
	if ($quantity_check == 1){ 
		$product_Delete = "DELETE FROM cart_tbl WHERE crt_sess = '$crt_sess' AND p_id = $p_id";
		$get_product_Delete_db = mysqli_query($db_connection, $product_Delete) or die (mysqli_error($db_connection));

	} else { 
	--$quantity_check;

	$product_remove = "UPDATE cart_tbl SET crt_qt = '$quantity_check' WHERE crt_sess = '$crt_sess' AND p_id = $p_id";
	$get_product_remove_db = mysqli_query($db_connection, $product_remove) or die (mysqli_error($db_connection));

	$sql_price = "SELECT * FROM cart_tbl WHERE p_id = $p_id AND crt_sess = '$crt_sess'";
	$get_sql_price_db = mysqli_query($db_connection, $sql_price) or die (mysqli_error($db_connection));
	
	while ($get_row = mysqli_fetch_assoc($get_sql_price_db)){
	$newSub = $get_row['crt_sum'] - $get_row['crt_price'];
	}
	$update_subtotal = "UPDATE cart_tbl SET crt_sum = '$newSub' WHERE crt_sess = '$crt_sess' AND p_id = $p_id";		
	$get_update_subtotal_db = mysqli_query($db_connection, $update_subtotal) or die (mysqli_error($db_connection));
	
							
		}
	header('Location:'.$page .'cat='.$pc_id.'');
}
// Delete Item
if (isset($_GET['delete'])){
	$p_id = $_GET['remove'];
	
	$pc_id = $_GET['cat'];
	
	if ($pc_id != ""){
	$page  = ''.$location.'.php?cat='.$pc_id.'';
	} else {
	$page  = $location ."cat=1";	
	}
		
	$_SESSION['crt_sess'] = session_id();
	$crt_sess = $_SESSION['crt_sess'];
	
	$sql_product_check = "SELECT p_id FROM cart_tbl WHERE p_id = $p_id AND crt_sess = '$crt_sess'";
	$get_sql_product_check_db = mysqli_query($db_connection, $sql_product_check) or die (mysqli_error($db_connection));

	
	$product_check = mysql_num_rows($get_sql_product_check_db); 
	//check to see if the product already within the cart
	if ($product_check != ""){ 
	$product_Delete = mysql_query("DELETE FROM cart_tbl WHERE crt_sess = '$crt_sess' AND p_id = $p_id");
	$get_product_Delete_db = mysqli_query($db_connection, $product_Delete) or die (mysqli_error($db_connection));

	} else { 
	header('Location:'.$page .'cat='.$pc_id.'');
	}
	header('Location:'.$page .'cat='.$pc_id.'');
}
