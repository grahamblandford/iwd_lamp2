<!-- 
    Title:       check_session.php
    Application: INFO-5094 LAMP 2 Employee Project
    Purpose:     Include to do a check on logged in user
    Author:      G. Blandford,  Group 5, INFO-5094-01-21W
    Date:        March 1st, 2021 (March 1st, 2021)
-->

<?php
session_start();

// Check for session user
if ( !empty( $_SESSION['CURRENT_USER'] ) ) {
	$user_id = $_SESSION['CURRENT_USER'];
}
else {
	header("Location: /pages/login.php");
	die();
}
?>
