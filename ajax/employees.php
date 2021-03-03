<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $response = array("status" => "OK");
    $response['post'] = $_POST;
    
    echo json_encode($response);
    exit(1);
        
} else {
    getEmployees();
}

// Get Employees
function getEmployees() {

    $db_conn = connectDB();

    // SQL query
    $querySQL = "SELECT
                e.employee_id
                , e.first_name
                , e.middle_name
                , e.last_name
                , trim(concat(e.first_name, ' ', e.middle_name, ' ', e.last_name)) as full_name
                , e.job_type
                , e.date_of_birth
                , e.gender
                , e.date_hired
                , e.hired_salary_level
                , e.last_updated
                , e.last_updated_user_id
             FROM employees as e 
             WHERE 1";

    $querySQL .= " order by e.last_name;";

    // prepare query
    $stmt = $db_conn->prepare($querySQL);

    // prepare error check
    if (!$stmt) {
        echo "<p>Error: " . $db_conn->errorCode() . "<br>Message: " . implode($db_conn->errorInfo()) . "</p><br>";
        exit(1);
    }
    $status = $stmt->execute();
    if ($status) {

        if ($stmt->rowCount() > 0) {
            $response = array("status" => "OK");
            $response['info'] = $_SERVER;
            $response['employees'] = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($response['employees'], $row);
            }
            echo json_encode($response);
        } else {
            echo '{ "status": "None" }';
        }
    } else {
        echo "<p>Error: " . $stmt->errorCode() . "<br>Message: " . implode($stmt->errorInfo()) . "</p><br>";

        // close database connection
        $db_conn = null;
        exit(1);
    }
    $db_conn = null;
}


//Connect to database using PDO method
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