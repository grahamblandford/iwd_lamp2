<!-- 
    Title:       common.php
    Application: INFO-5094 LAMP 2 Employee Project
    Purpose:     Common functionality
    Author:      T. Kim,  Group 5, INFO-5094-01-21W
    Date:        January 31st, 2021 (January 31st, 2021)
-->

<?php
// time and date correction.
date_default_timezone_set('America/Toronto');

// For database connection
define("DBHOST", "localhost");
define("DBDB",   "lamp");
define("DBUSER", "lamp");
define("DBPW", "LQBXwyMZBpJZwIAn");


//Connect to database using PDO method
function connectDB()
{
    try{
        $dbconn = new PDO('mysql:host='.DBHOST.';dbname='.DBDB.';charset=utf8', DBUSER, DBPW);
    
        $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbconn;
    }
    catch(Exception $e) {
        echo 'Failed to obtain database handle : '.$e->getMessage();
    }

}

function sanitize_html($arg)
{
    $sanitizedArray = array();
    foreach ($arg as $key => $value) {
        $sanitizedArray[$key] = htmlentities($value);
    }
    //return the array of sanitized values
    return $sanitizedArray;
}
?>