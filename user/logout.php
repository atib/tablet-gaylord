<?php
session_start();

$crt_sess = session_id();
$activation = $_SESSION['activation'];
$orderid=$_SESSION['activateorderid'];

include_once("db_connect.php");

$deactivate_tablet = "DELETE FROM tabletactivate_tbl WHERE o_id = '$orderid' AND tab_sess = '$crt_sess' AND o_activation = '$activation' AND tab_active = '1'";
	
$deactivate_tablet_db = mysqli_query($db_connection, $deactivate_tablet) or die (mysqli_error($db_connection));

// Unset all of the session variables.
$_SESSION = array();

unset($_SESSION['u_id']);
unset($_SESSION['fname']);
unset($_SESSION['email']);
unset($_SESSION['activation']);
unset($_SESSION['activateorderid']);

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();


header("Location: activation.php");
?>