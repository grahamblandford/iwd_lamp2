<!-- 
    File: JavaScript.js
    Author: T.Kim
    Date: Jan 31, 2021
    Description: Generate employee list and make CSV file 
-->
<?php session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="../css/starter-template.css" rel="stylesheet">

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

        $table = "";
        $header = "";
        $lines = array();
        $msg = "";
        $field_data = sanitize_html($_POST);

        //dump($_POST);

        // Click re-load page
        if (isset($field_data['again'])) {
        ?>
            <script>
                location.href = './insertEmployee.php';
            </script>
        <?php
        }
        // when file is uploaded...
        else if (file_exists($_FILES['file']['tmp_name']) || is_uploaded_file($_FILES['file']['tmp_name'])) {
            // Check the Meta Data
            if ($_FILES['file']['type'] == 'text/csv' && $_FILES['file']['error'] == 0) {

                $destination_file = '../file/employeeList_' . time() . '.csv';
                move_uploaded_file($_FILES['file']['tmp_name'], $destination_file);

                if (($handle = fopen($destination_file, "r")) !== FALSE) {
                
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $num = count($data);
                        $lines[] = $data;
                    }
                    fclose($handle);
                }
                // Check Duplicate and Insert Data
                duplicateCheck($lines);

                // show date from database
                showDataFromDatabase($db_conn);

            } else {
                $msg = 'It is not a CSV file. Please upload again.';
                makeHeader('fileuploadfail');
                showUploadForm();
            }
        } else if (isset($field_data['showdata'])) {
            showDataFromDatabase($db_conn);
        }
        // Main page
        else {
            showUploadForm();
        }
        function showDataFromDatabase($dbc)
        {
            $temp_arrs = [];
            $stmt = $dbc->prepare("Select employee_id, last_name, first_name, middle_name, date_of_birth, gender, date_hired, hired_salary_level, job_type, last_updated_user_id from employees");
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
                makeTable('db', $temp_arrs);
            } catch (Exception $e) {
                $dbc->rollback();
                echo $e->getMessage();
            }
        }

        function duplicateCheck($arg)
        {
            global $msg;
            global $db_conn;

            $newArr = array();
            foreach ($arg as $val) {
                $newArr[$val[0] . $val[1] . $val[3] . $val[4]] = $val;
            }
            $unUnique = array_values($newArr);
            if (count($unUnique) != count($arg)) {
                $msg = 'In the uploaded CSV file, there is ' . number_format(count($arg) - count($unUnique)) . ' data with the same name, gender, and birthday. ' . count($unUnique) . ' data is inserted.';
            } elseif (count($unUnique) == count($arg)) {
                $msg =  count($unUnique) . ' data is inserted.';
            }
            insertEmp($db_conn, $unUnique);
        }

        function insertEmp($dbc, $arr)
        {
            try {
                $stmt = $dbc->prepare("TRUNCATE `lamp`.`employees`");
                $stmt->execute();
            } catch (Exception $e) {
                $dbc->rollback();
                echo $e->getMessage();
            }
            $stmt = $dbc->prepare("INSERT INTO employees (last_name, first_name, middle_name, date_of_birth, gender, date_hired, hired_salary_level, job_type, last_updated_user_id) values(?, ?, ?, ?, ?, ?, ?, ?, 'CSVinsert')");

            try {
                $dbc->beginTransaction();

                foreach ($arr as $row) {
                    $stmt->execute($row);
                }
                unset($row);
                $dbc->commit();
            } catch (Exception $e) {
                $dbc->rollback();
                echo $e->getMessage();
            }
        }

        function makeTable($type, $arg)
        {
            global $table;
           
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
            $i = 1;
            foreach ($arg as $v1) {
                if ($type == 'csv') {
                    $table = $table . "<tr><th scope='row'>" . $i . "</th>";
                }
                $i++;
                foreach ($v1 as $v2) {
                    $table = $table . "<td>" . $v2 . "</td>";
                }
                $table = $table . "</tr>";
            }
            $table = $table . "</tbody></table>";
            makeHeader($type);
            echo $table;
        }

        function makeHeader($type)
        {
            global $header;
            global $lines;
            global $msg;
            if ($type == 'db') {
                if (strlen($msg) > 0) {
                    $header = "<div class=\"alert alert-success\" role=\"alert\">" . $msg . "</div>";
                    echo $header;
                }
            } else if ($type == 'fileuploadfail') {
                $header = "<div class=\"alert alert-danger\" role=\"alert\">" . $msg . "</div>";
                echo $header;
            }
        }

        function showUploadForm()
        {
        ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Please select the CSV file... <br>Click "Choose File" to select a CSV file and click the Upload button.<br>Please refer to the "CSV Generator" menu for the format of the CSV file.<br>If there is data in the CSV file with the same first, last name, gender and birthday, the data will merged.</label>
                    <div class="row g-2">
                        <div class="col-auto">
                            <input class="form-control" type="file" id="formFile" name="file">
                        </div>
                        <div class="col-auto">
                            <button type="submit" name="submit" class="btn btn-primary" value="submit">Upload</button>
                        </div>
                        <div class="col-auto">
                            <button type="submit" name="showdata" class="btn btn-secondary" value="showdata">Show Data</button>
                        </div>
                    </div>
                </div>
            </form>

        <?php
        }
        ?>
        <!-- Optional JavaScript -->
        <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>