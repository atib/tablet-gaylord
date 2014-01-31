<?php
$db_host="localhost";

$db_username="lunarweb";

$db_pass = "Ridhwan123.";

$db_name="lunarweb_pummello";

$db_connection = mysqli_connect("$db_host", "$db_username", "$db_pass", "$db_name") or die ("Could not connect to the database. Please contact the administrator quoting: ErrDBFail");

mysqli_set_charset($db_connection, "utf8");
?> 