<!-- 
    Title:       InsertEmployee.php
    Application: INFO-5094 LAMP 2 Employee Project
    Purpose:     Generate employee list and make CSV file
    Author:      T. Kim,  Group 5, INFO-5094-01-21W
    Date:        January 31st, 2021 (March 1st, 2021)

    20210301    GPB Added check_session.php
    20210303    GPB Added id tags for css corrections
-->
<?php 
    session_start(); 
    include_once("./check_session.php");    
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Metrophobic&display=swap" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">

    <?php
    //define('_SERVER_PATH_', str_replace(basename(__FILE__), "", realpath(__FILE__)));
    //include _SERVER_PATH_ . 'common.php';
    include 'common.php';
    $db_conn = connectDB();

    // Auto Mock Generator and symfony
    require_once '../vendor/autoload.php';
    ?>
</head>

<body>
    <div class="container">
        <!-- Load navigationMenu -->
        <?php
        //include _SERVER_PATH_ . 'navigationMenu.php';
        include 'navigationMenu.php';

        $lines = array();
        $msg = "";
        $field_data = sanitize_html($_POST);

        // When file is uploaded..
        if (file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name'])) {
            // Check the Meta Data

            // dump($_FILES);
            // dump(pathinfo( $_FILES['file']['name'], PATHINFO_EXTENSION));
                        
            if ( ($_FILES['file']['type'] == 'text/csv' || (pathinfo( $_FILES['file']['name'], PATHINFO_EXTENSION) == 'csv' && $_FILES['file']['type'] == 'application/vnd.ms-excel'))&& $_FILES['file']['error'] == 0) {
            // if ($_FILES['file']['type'] == 'text/csv' && $_FILES['file']['error'] == 0) {
                    $destination_path = '../file/';
                $destination_file = 'employeeList_' . time() . '.csv';
                move_uploaded_file($_FILES['file']['tmp_name'], $destination_path . $destination_file);

                // Insert file name to Database
                try {
                    $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "INSERT INTO employee_files (file_name) VALUES ('$destination_file')";
                    $db_conn->exec($sql);
                } catch (PDOException $e) {
                    echo $sql . "<br>" . $e->getMessage();
                }

                // truncate employee table
                truncateDB();

                // set insert count
                $num = 0;

                // Read file from permanent location
                if (($handle = fopen($destination_path . $destination_file, "r")) !== FALSE) {
                    $num = 0;
                    //RegExp for date "1234-12-12"
                    $datePattern = "/[0-9]{4}-[0-9]{2}-[0-9]{2}/";

                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        // Read data in one line at a time
                        // Check the Validation

                        // FirstName
                        if (is_string($data[0]) == false) {
                            $msg = $data[0] . " cannot be used as a First name.";
                        }
                        // LastName
                        elseif (is_string($data[1]) == false) {
                            $msg = $data[1] . " cannot be used as a Last name.";
                        }
                        // MiddleName
                        elseif ($data[2] != '') {
                            if (is_string($data[2]) == false)
                                $msg = $data[2] . " cannot be used as a Middle name.";
                        }
                        // Birth Date
                        elseif (preg_match_all($datePattern, $data[3]) != 1) {
                            $msg = $data[3] . " cannot be used as a Birth Date.";
                        }
                        // Gender
                        elseif ($data[4] != "Male" && $data[4] != "Female") {
                            $msg = $data[4] . " cannot be used as a Gender.";
                        }
                        // Hired Date
                        elseif (preg_match_all($datePattern, $data[5]) != 1) {
                            $msg = $data[5] . " cannot be used as a Hired Date.";
                        }
                        // Level
                        elseif (preg_match_all("/[0-9]{1}/", $data[6]) != 1) {
                            $msg = $data[6] . " cannot be used as a Level.";
                        }
                        // Job Type
                        elseif ($data[7] != "FT" && $data[7] != "PT") {
                            $msg = $data[7] . " cannot be used as a Job Type.";
                        }
                        // if $msg have message,
                        if (strlen($msg) != 0) {
                            makeHeader('red');
                            break;
                        } else {
                            // Data Insert Here
                            insertEmp($data);
                            $num++;
                        }
                    }
                    fclose($handle);
                }

                $msg =  $num . ' data is inserted.';

                // Duplicate Check Here
                duplicateCheck();
                // show date from database
                showDataFromDatabase();
            } else {
                $msg = 'It is not a CSV file. Please upload again.';
                makeHeader('red');
                showUploadForm();
            }
        } else if (isset($field_data['showdata'])) {
            showDataFromDatabase();
        }
        // Main page
        else {
            showUploadForm();
        }
        function showDataFromDatabase()
        {
            global $db_conn;
            $temp_arrs = [];
            $stmt = $db_conn->prepare("Select employee_id, last_name, first_name, middle_name, date_of_birth, gender, date_hired, hired_salary_level, job_type, last_updated_user_id from employees");
            try {
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $details = [
                        $row['employee_id'],
                        $row['last_name'],
                        $row['first_name'],
                        $row['middle_name'],
                        $row['date_of_birth'],
                        $row['gender'],
                        $row['date_hired'],
                        $row['hired_salary_level'],
                        $row['job_type'],
                    ];
                    array_push($temp_arrs, $details);
                }
                // showTable
                makeTable($temp_arrs);
                unset($temp_arrs);
            } catch (Exception $e) {
                $db_conn->rollback();
                echo $e->getMessage();
            }
        }

        function duplicateCheck()
        {
            global $db_conn;
            $temp_arrs = [];
            $stmt = $db_conn->prepare("Select first_name, middle_name, last_name, date_of_birth, gender From employees Group by first_name, middle_name, last_name, date_of_birth, gender Having count(*)>1");

            try {
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $details = [
                        $row['last_name'],
                        $row['first_name'],
                        $row['middle_name'],
                        $row['date_of_birth'],
                        $row['gender'],
                    ];
                    array_push($temp_arrs, $details);
                }
                if (count($temp_arrs) > 0) {
                    //if Duplicate data is existed                            
                    $table = "<div class=\"alert alert-danger\" role=\"alert\">There are " . count($temp_arrs) . " duplicate data below.</div><table class='table table-striped table-hover'><thead>
                    <tr>
                    <th scope='col'>Surname</th>
                    <th scope='col'>GivenName</th>
                    <th scope='col'>MiddleName</th>
                    <th scope='col'>BirthDate</th>
                    <th scope='col'>Gender</th>
                    </tr></thead><tbody>";
                    foreach ($temp_arrs as $v1) {
                        foreach ($v1 as $v2) {
                            $table = $table . "<td>" . $v2 . "</td>";
                        }
                        $table = $table . "</tr>";
                    }
                    $table = $table . "</tbody></table>";
                    echo $table;
                    unset($table);
                }
                unset($temp_arrs);
            } catch (Exception $e) {
                $db_conn->rollback();
                echo $e->getMessage();
            }
        }

        function truncateDB()
        {
            global $db_conn;
            try {
                $stmt = $db_conn->prepare("TRUNCATE `lamp`.`employees`");
                $stmt->execute();
            } catch (Exception $e) {
                $db_conn->rollback();
                echo $e->getMessage();
            }
        }

        function insertEmp($array)
        {
            global $db_conn;
            $stmt = $db_conn->prepare("INSERT INTO employees (last_name, first_name, middle_name, date_of_birth, gender, date_hired, hired_salary_level, job_type, last_updated_user_id) values(?, ?, ?, ?, ?, ?, ?, ?, 'CSVinsert')");

            try {
                $db_conn->beginTransaction();
                $stmt->execute($array);
                $db_conn->commit();
            } catch (Exception $e) {
                $db_conn->rollback();
                echo $e->getMessage();
            }
        }

        function makeTable($arg)
        {
            $table = "<table class='table table-striped table-hover'><thead>
        <tr>
          <th scope='col'>#</th>
          <th scope='col'>Surname</th>
          <th scope='col'>GivenName</th>
          <th scope='col'>MiddleName</th>
          <th scope='col'>BirthDate</th>
          <th scope='col'>Gender</th>
          <th scope='col'>HireDate</th>
          <th scope='col'>InitialLevel</th>
          <th scope='col'>WorkType</th>
        </tr>
      </thead>
      <tbody>";
            foreach ($arg as $v1) {
                foreach ($v1 as $v2) {
                    $table = $table . "<td>" . $v2 . "</td>";
                }
                $table = $table . "</tr>";
            }
            $table = $table . "</tbody></table>";
            makeHeader('green');
            echo $table;
            unset($table);
        }

        function makeHeader($type)
        {
            global $msg;
            if ($type == 'green') {
                if (strlen($msg) > 0) {
                    $header = "<div class=\"alert alert-success\" role=\"alert\">" . $msg . "</div>";
                    echo $header;
                }
            } else if ($type == 'red') {
                $header = "<div class=\"alert alert-danger\" role=\"alert\">" . $msg . "</div>";
                echo $header;
            }
            unset($msg);
            unset($header);
        }

        function showUploadForm()
        {
        ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label id="label-csv" for="formFile" class="form-label">Please select the CSV file... <br>Click "Choose File" to select
                    a CSV file and click the Upload button.<br>Please refer to the "CSV Generator" menu for the format
                    of the CSV file.<br>If there is data in the CSV file with the same first, last name, gender and
                    birthday, the data will merged.</label>
                <div class="row g-2">
                    <div class="col-auto">
                        <input class="form-control" type="file" id="formFile" name="file">
                    </div>
                    <div class="col-auto">
                        <button type="submit" name="submit" class="btn btn-primary" value="submit">Upload</button>
                    </div>
                    <div class="col-auto">
                        <button type="submit" name="showdata" class="btn btn-secondary" value="showdata">Show
                            Data</button>
                    </div>
                </div>
            </div>
        </form>

        <?php
        }
        ?>
        <!-- Optional JavaScript -->
        <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>