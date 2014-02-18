<?php 
session_start();

// If the GET variable id is not empty, then this script, if variable is empty message is given message at bottom
if ($_GET['id'] != "") {
	
    
    include_once "db_connect.php"; //Connect to the database through an include 
	$parcel = 1;
    $c_id = $_GET['id'];   //sticking the get id into the user id field
    $hashcode = $_GET['sequence']; //this is the hash md5 password

    $c_id  = mysql_real_escape_string($c_id ); //preventing database attacks
    $c_id = eregi_replace("`", "", $c_id); //replacing the appostrophe like character which is found above tab button with nothing

    $hashcode = mysql_real_escape_string($hashcode); 
    $hashcode = eregi_replace("`", "", $hashcode);
	
	$password = md5($hashcode);

	$update_user = "UPDATE client_tbl SET c_active='1' WHERE c_id='$c_id' AND c_identifier='$password'";
	
	$update_user_db = mysqli_query($db_connection, $update_user) or die (mysqli_error($db_connection));
//double check user is updated
	
	$dc_update_user = "SELECT * FROM client_tbl WHERE c_id='$c_id' AND c_identifier='$password' AND c_active='1'";
	
	$dc_update_user_db = mysqli_query($db_connection, $dc_update_user) or die (mysqli_error($db_connection));
   
    //checking if update is successful
   
    $doublecheck = mysqli_num_rows($dc_update_user_db); // return the number of rows found

    if($doublecheck == 0){ //if equal to zero than the user doesnt exist which means that it cant be activated
       //display message to user
	    $error_msg = "Your account could not be activated!
        Please email site administrator and request manual activation. 
        "; 
	header("Location: http://www.lunarwebstudio.com/Demos/GaylordTablet/user/login.php?msg=$error_msg");
	
    } elseif ($doublecheck > 0) { 

        $user_msg = "Your account setting has been set up!Log In anytime up top.";
	
	header("Location: http://www.lunarwebstudio.com/Demos/GaylordTablet/user/login.php?&usrm=$msgToUser");
} 

} else{ // close first if
 //if the ID was not found the folling message would be displayed.
 $user_msg = "Essential data from the activation URL is missing! Close your browser, go back to your email inbox, and please use the full URL supplied in the activation link we sent you.
info@gaylord.com
";
	header("http://www.lunarwebstudio.com/Demos/GaylordTablet/user/login.php?usrm=$msgToUser");
}
?>