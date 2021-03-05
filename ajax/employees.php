<?php
/*
    Title:       employees.php
    Application: INFO-5094 LAMP 2 Employee Project
    Purpose:     Server-side employees 
    Author:      G. Blandford, Group 5, INFO-5094-01-21W
    Date:        March 1st, 2021 (March 1st, 2021)
*/
session_start();
header("Content-Type: application/json");
// require $_SERVER['DOCUMENT_ROOT'] . 'pages/common.php';

// POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if ( (isset($_POST['save-action']) && $_POST['save-action'] == "Save") ) {

        // Update
        if ($_POST['employee-id'] > "") {

            updateEmployee();
            
        // Insert
        } else {

            insertEmployee();
        }
    }

    // Edit
    if ( (isset($_POST['action']) && $_POST['action'] == "edit") ) {

        if ( (isset($_POST['selected']) && $_POST['selected'] > "0") ) {

            getEmployee();
        } else {
            // Error - no selected item
        }

    // Add
    } else if ( (isset($_POST['action']) && $_POST['action'] == "add") ) {

        initEmployee();
    } 

// GET
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

            $path = $_SERVER['DOCUMENT_ROOT'] . 'pages/common.php';
            $response['path'] = array("path" => $path);

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

// Update
function updateEmployee() {

    // Server-side validation
    $errors = validateEmployee();

    // Errors
    if (count($errors) > 0 ) {

        $response = array("status" => "ERR");
        $response['errors'] = $errors;
        echo json_encode($response);
        exit(1);

    } 

    $db_conn = connectDB();
    
    // SQL query
    $querySQL = "update employees as e
                    set
                    e.first_name        = :first_name
                    , e.middle_name     = :middle_name
                    , e.last_name       = :last_name
                    , e.job_type        = :job_type
                    , e.date_of_birth   = :date_of_birth
                    , e.gender          = :gender
                    , e.date_hired      = :date_hired
                    , e.hired_salary_level = :hired_salary_level
                    , e.last_updated    = now()
                    , e.last_updated_user_id = :session_user_id
                where e.employee_id = :employee_id";

    $session_user_id = $_SESSION['CURRENT_USER']['user_id'];
    $row = $_SESSION['data'];

    $data = array(":employee_id"          => $row['employee_id']
                , ":first_name"     => $row['first_name']
                , ":middle_name"    => $row['middle_name']
                , ":last_name"      => $row['last_name']
                , ":job_type"       => $row['job_type']
                , ":date_of_birth"  => $row['date_of_birth']
                , ":gender"         => $row['gender']
                , ":date_hired"     => $row['date_hired']
                , ":hired_salary_level" => $row['hired_salary_level']
                , ":session_user_id"    => $session_user_id
                );

    // prepare query
    $stmt = $db_conn->prepare($querySQL);
               

    // prepare error check
    if (!$stmt) {
        echo "<p>Error: " . $db_conn->errorCode() . "<br>Message: " . implode($db_conn->errorInfo()) . "</p><br>";
        exit(1);
    }

    $status = $stmt->execute($data);

    if ($status) {

        $response = array("status" => "OK");
        $response['info'] = $_SERVER;
        echo json_encode($response);

    } else {
        echo "<p>Error: " . $stmt->errorCode() . "<br>Message: " . implode($stmt->errorInfo()) . "</p><br>";

        // close database connection
        $db_conn = null;
        exit(1);
    }
    $db_conn = null;
}

// Insert Employee
function insertEmployee() {

    // Server-side validation
    $errors = validateEmployee();

    // Errors
    if (count($errors) > 0 ) {

        $response = array("status" => "ERR");
        $response['errors'] = $errors;
        echo json_encode($response);
        exit(1);

    } 

    $db_conn = connectDB();
    
    // SQL query
    $querySQL = "insert into employees (
                    first_name
                    , middle_name
                    , last_name
                    , job_type
                    , date_of_birth
                    , gender
                    , date_hired
                    , hired_salary_level
                    , last_updated_user_id
                ) values (
                    :first_name
                    , :middle_name
                    , :last_name
                    , :job_type
                    , :date_of_birth
                    , :gender
                    , :date_hired
                    , :hired_salary_level
                    , :session_user_id
                )";

    $session_user_id = $_SESSION['CURRENT_USER']['user_id'];
    $row = $_SESSION['data'];

    $data = array(":first_name"     => $row['first_name']
                , ":middle_name"    => $row['middle_name']
                , ":last_name"      => $row['last_name']
                , ":job_type"       => $row['job_type']
                , ":date_of_birth"  => $row['date_of_birth']
                , ":gender"         => $row['gender']
                , ":date_hired"     => $row['date_hired']
                , ":hired_salary_level" => $row['hired_salary_level']
                , ":session_user_id"    => $session_user_id
                );

    // prepare query
    $stmt = $db_conn->prepare($querySQL);
               

    // prepare error check
    if (!$stmt) {
        echo "<p>Error: " . $db_conn->errorCode() . "<br>Message: " . implode($db_conn->errorInfo()) . "</p><br>";
        exit(1);
    }

    $status = $stmt->execute($data);

    if ($status) {

        $employee_id = $db_conn->lastInsertId(); // Get employee_id

        $response = array("status" => "OK");
        $response['employee_id'] = $employee_id;
        echo json_encode($response);

    } else {
        echo "<p>Error: " . $stmt->errorCode() . "<br>Message: " . implode($stmt->errorInfo()) . "</p><br>";

        // close database connection
        $db_conn = null;
        exit(1);
    }
    $db_conn = null;
}

// 
// Get Employee
function getEmployee() {

    $db_conn = connectDB();

    $employee_id = $_POST['selected'][0];

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
             WHERE e.employee_id = :employee_id";

    $data = array(":employee_id" => $employee_id);  

    // prepare query
    $stmt = $db_conn->prepare($querySQL);

    // prepare error check
    if (!$stmt) {
        echo "<p>Error: " . $db_conn->errorCode() . "<br>Message: " . implode($db_conn->errorInfo()) . "</p><br>";
        exit(1);
    }
    $status = $stmt->execute($data);
    if ($status) {

        if ($stmt->rowCount() == 1) {
            $response = array("status" => "OK");
            $response['info'] = $_SERVER;

            $path = $_SERVER['DOCUMENT_ROOT'] . '/pages/common.php';
            $response['path'] = array("path" => $path);

            $response['employee'] = array();


            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($response['employee'], $row);
            }
            echo json_encode($response);
        } else {
            echo '{ "status": "DBERR" }';
        }
    } else {
        echo "<p>Error: " . $stmt->errorCode() . "<br>Message: " . implode($stmt->errorInfo()) . "</p><br>";

        // close database connection
        $db_conn = null;
        exit(1);
    }
    $db_conn = null;
}

// Init a new Employee
// Can load defaults here
function initEmployee() {

    $db_conn = connectDB();

    // SQL query
    $querySQL = 'SELECT
                "" as employee_id
                , "" as first_name
                , "" as middle_name
                , "" as last_name
                , "FT" as job_type
                , "" as date_of_birth
                , "Male" as gender
                , now() as date_hired
                , 1 as hired_salary_level
             FROM dual';

    // prepare query
    $stmt = $db_conn->prepare($querySQL);

    // prepare error check
    if (!$stmt) {
        echo "<p>Error: " . $db_conn->errorCode() . "<br>Message: " . implode($db_conn->errorInfo()) . "</p><br>";
        exit(1);
    }
    $status = $stmt->execute();
    if ($status) {

        if ($stmt->rowCount() == 1) {
            $response = array("status" => "OK");
            $response['info'] = $_SERVER;
            $response['employee'] = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($response['employee'], $row);
            }
            echo json_encode($response);
        } else {
            echo '{ "status": "DBERR" }';
        }
    } else {
        echo "<p>Error: " . $stmt->errorCode() . "<br>Message: " . implode($stmt->errorInfo()) . "</p><br>";

        // close database connection
        $db_conn = null;
        exit(1);
    }
    $db_conn = null;
}

// Validate 
function validateEmployee() {

    $errors = [];

    // First name
	if( !isset($_POST['first-name'] ) ) {
		$errors[] = "A first name is required";
	} else {
		$first_name = $_POST['first-name'];
		if ( strlen($first_name) == 0 ){
			$errors[] = "A first name is required";
		} else if (strlen( $first_name ) > 50 ) {
			$errors[] = "The first name exceeds 50 characters";
		}
	}

    // Middle name
	if( isset($_POST['middle-name'] ) ) {
		$middle_name = $_POST['middle-name'];
        if (strlen( $middle_name ) > 50 ) {
			$errors[] = "The middle name exceeds 50 characters";
		}
	} else {
        $middle_name = "";
    }

    // Last name
	if( !isset($_POST['last-name'] ) ) {
		$errors[] = "A last name is required";
	} else {
		$last_name = $_POST['last-name'];
		if ( strlen($last_name) == 0 ){
			$errors[] = "A last name is required";
		} else if (strlen( $last_name ) > 50 ) {
			$errors[] = "The last name exceeds 50 characters";
		}
	}

    // Job type
	if( !isset($_POST['job-type'] ) ) {
		$errors[] = "A job type is required";
	} else {
		$job_type = $_POST['job-type'];
		if ( $job_type != 'FT' && $job_type != 'PT' ){
			$errors[] = "Job type must be 'PT' or 'FT'";
		}
	}
    
    // Date of birth
	if( !isset($_POST['date-of-birth'] ) ) {
		$errors[] = "A date of birth is required";
	} else {
		$date_of_birth = $_POST['date-of-birth'];
		if ( !checkIsDate($date_of_birth) ){
			$errors[] = "Date of birth is not a valid date";
		}
	}

    // Gender
	if( !isset($_POST['gender'] ) ) {
		$errors[] = "A gender is required";
	} else {
		$gender = $_POST['gender'];
		if ( $gender != 'Female' && $gender != 'Male' && $gender != 'Other' ){
			$errors[] = "Gender must be 'Female', 'Male' or 'Other'";
		}
	}

        // Date hired
	if( !isset($_POST['date-hired'] ) ) {
		$errors[] = "A hired date is required";
	} else {
		$date_hired = $_POST['date-hired'];
		if ( !checkIsDate($date_hired) ){
			$errors[] = "Date hired is not a valid date";
		}
	}

    // Job type
    if( !isset($_POST['hired-salary-level'] ) ) {
        $errors[] = "A salary level is required";
    } else {
        $hired_salary_level = (int)$_POST['hired-salary-level'];
        if ( $hired_salary_level < 0 || $hired_salary_level > 9 ){
            $errors[] = "Salary level must be between 1 and 9";
        }
    }

    $employee_id = $_POST['employee-id'];
    $_SESSION['data'] = array("employee_id" => $employee_id
                            , "first_name" => $first_name
                            , "middle_name" => $middle_name
                            , "last_name" => $last_name
                            , "job_type" => $job_type
                            , "date_of_birth" => $date_of_birth
                            , "gender" => $gender
                            , "date_hired" => $date_hired
                            , "hired_salary_level" => $hired_salary_level
                        );
    return $errors;
}

// Check if date
function checkIsDate($date){
    return (bool)strtotime($date);
}

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