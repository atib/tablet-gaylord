<?php
$printPage="";
?>
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>The Gaylord</title>
	<link rel="stylesheet" type="text/css" href="CSS/jquery.mobile-1.4.0.min.css">
	<link href="CSS/reset.css" rel="stylesheet" type="text/css">
	<link href="CSS/Main.css" rel="stylesheet" type="text/css">
	<?php
	if (isset($_POST["printFront"])){
	 	$printPage=' <link rel="stylesheet" type="text/css" href="CSS/print.css">';

	}else if(isset($_POST["printKitchen"])){
		$printPage=' <link rel="stylesheet" type="text/css" href="CSS/print2.css">';

	}else{
		$printPage=' <link rel="stylesheet" type="text/css" href="CSS/print.css">';

	}
	?>
    <?php echo $printPage;?>
	<script src="Script/jquery.js"></script>
    <link rel="shortcut icon" href="Images/favicon.png">

</head>