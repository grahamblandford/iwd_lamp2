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