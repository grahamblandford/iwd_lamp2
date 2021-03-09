<!-- 
    Title:       check_session.php
    Application: INFO-5094 LAMP 2 Employee Project
    Purpose:     Include to do a check on logged in user
    Author:      G. Blandford,  Group 5, INFO-5094-01-21W
    Date:        March 1st, 2021 (March 1st, 2021)

    20210308    GPB Added HTTPS check
-->

<?php
// session_start();

if ($_SERVER['HTTPS'] != 'on') {
    $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $url, true, 301);
    exit();
}

// Check for session user
if ( !empty( $_SESSION['CURRENT_USER'] ) ) {
	$user_id = $_SESSION['CURRENT_USER'];
}
else {
	header("Location: /pages/login.php");
	die();
}
?>
