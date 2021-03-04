<!-- 
    Title:       common.php
    Application: INFO-5094 LAMP 2 Employee Project
    Purpose:     Common functionality
    Author:      T. Kim,  Group 5, INFO-5094-01-21W
    Date:        January 31st, 2021 (January 31st, 2021)
-->

<?php
// Connect to database using PDO method
function connectDB()
{
    define("DBHOST", "localhost");
    define("DBDB",   "lamp");
    define("DBUSER", "lamp");
    define("DBPW", "LQBXwyMZBpJZwIAn");

    try {
        $dbconn = new PDO('mysql:host=' . DBHOST . ';dbname=' . DBDB . ';charset=utf8', DBUSER, DBPW);

        $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbconn;
    } catch (Exception $e) {
        echo 'Failed to obtain database handle : ' . $e->getMessage();
    }
}
?>