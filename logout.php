<?php
session_start();

unset($_SESSION['u_id']);
unset($_SESSION['username']);
unset($_SESSION['u_type']);

session_destroy();

header("Location: index.php");
?>