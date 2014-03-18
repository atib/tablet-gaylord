<?php
class Fun {

    public function limit_text($text, $len) {
        if (strlen($text) < $len) {
            return $text;
        }
        $text_words = explode(' ', $text);
        $out = null;


        foreach ($text_words as $word) {
            if ((strlen($word) > $len) && $out == null) {

                return substr($word, 0, $len) . "...";
            }
            if ((strlen($out) + strlen($word)) > $len) {
                return $out . "...";
            }
            $out.=" " . $word;
        }
        return $out;
    }

}

####################################################################

if (isset($_POST['update'])){

	$cashDisc = $_POST['cashdisc'];
	$percentDisc = $_POST['percentdisc'];	
	
	$db_total = $nettotal;
	
	if ($cashDisc !='' && $percentDisc ==''){
	
	$grandtotal = $db_total - $cashDisc;
echo 	$totalDiscount = $cashDisc;
	$success_msg = "Cash Discount Applied";
	$percentDisc = "";
	$minus = "£ -";
	} else if ($cashDisc =='' && $percentDisc !=''){
	
	$percentAmount = ($db_total/100)*$percentDisc;
	$grandtotal = $db_total - $percentAmount;
	$success_msg = "Percentage Discount Applied";
	$totalDiscount = $percentAmount;
	$cashDisc = "";
	$minus = "£ -";
	}else if ($cashDisc =='' && $percentDisc ==''){
	
	$cashDisc = '';
	$percentDisc = '';
	$success_msg = "Total updated";
	$minus = "£";
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

	$update_myorder = "UPDATE order_tbl SET o_cashdisc = '$cashDisc', o_percentCash = '$percentAmount', o_percentdisc='$percentDisc', o_total = '$grandtotal' WHERE o_id = '$user_o_id'";
	$update_myorderdb = mysqli_query($db_connection, $update_myorder) or die (mysqli_error($db_connection));

	$page = 'http://lunarwebstudio.com/Demos/GaylordTablet/displayorder.php?ac='.$o_activation.'&cat=14&succ='.$success_msg.'';
	
	header('Location:'.$page);
}


?>