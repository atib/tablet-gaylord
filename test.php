<?php

$username = "Joban";
$password = "gaylord";
$user_salt = "gaylord";

$password = md5($password .$user_salt);
	
	$password = md5($password);
			
		
	echo $username."<br>";
	
	echo $password. "<br>";	
?>