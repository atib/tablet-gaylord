<?php
	if ($_POST["one"]){
	echo "hello";
	  $printPage=' <link rel="stylesheet" type="text/css" href="CSS/print.css">';

	}else if($_POST["two"]){
		$printPage=' <link rel="stylesheet" type="text/css" href="CSS/print2.css">';
	echo "hello";

	}
?>
    <?php echo $printPage;?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>


   <form action="test.php" method="post" enctype="multipart/form-data" target="_self" >
        	    <input type="submit" class="filter_continue" name="one" onClick="print()"  value="Print Front House Recipet">
	    		<input type="submit" class="filter_continue" name="two" onClick="print()" value="Print Kitchen Recipet">		    
</form>  
</body>
</html>