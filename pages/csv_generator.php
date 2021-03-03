<!-- 
    Title:       csv_generator.php
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

<!DOCTYPE html>
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
//    define('_SERVER_PATH_', str_replace(basename(__FILE__), "", realpath(__FILE__)));
    //include _SERVER_PATH_ . 'common.php';
    include 'common.php';
    
    // It's not needed in this page
    //$db_conn = connectDB();

    // Auto Mock Generator and symfony
    require_once '../vendor/autoload.php';
    ?>
</head>

<body>
    <!-- Load navigationMenu -->
    <?php
    //define('_SERVER_PATH_', str_replace(basename(__FILE__), "", realpath(__FILE__)));
    include 'navigationMenu.php';
    ?>

    <?php
    $field_data = sanitize_html($_POST);
    //dump($field_data);

    if (isset($field_data['numberEmp'])) {
        employeeGenerator();
    }

    function employeeGenerator()
    {
        global $field_data;
        $values = array();
        $number = $field_data['numberEmp'];
        // Use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create();

        for ($i = 0; $i < $number; $i++) {
            //Middle Name
            $randomD = $faker->randomDigit;
            $mName = "";
            if ($randomD == '1' || $randomD == '2' || $randomD == '3') { //30%
                $mName = $faker->colorName;
            }
            //Gender
            $boo = $faker->boolean($chanceOfGettingTrue = 50); //50%
            $gender = "Male";
            if ($boo == true) {
                $gender = "Female";
            }
            //BirthDate
            $birthDate = $faker->dateTimeThisCentury($max = '-20 years')->format('Y-m-d');

            //Type
            $booType = $faker->boolean($chanceOfGettingTrue = 50); //50%
            $workType = "FT";
            if ($booType == true) {
                $workType = "PT";
            }

            //HireDate
            $hireDate = $faker->dateTimeBetween($startDate = date("Y-m-d", strtotime($birthDate . "+19 years")), $endDate = 'now')->format('Y-m-d');

            $emps = array();
            ///////////////////Surname         GivenName          MiddleName BirthDate Gender    HireDate    InitialLevel         Worktype
            array_push($emps, $faker->lastName, $faker->firstName, $mName, $birthDate, $gender, $hireDate, $faker->randomDigitNot(0), $workType);

            array_push($values, $emps);
        }
        outputCSV($values);
    }

    function outputCSV($data)
    {
        ob_clean();
        ob_start();
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=employee.csv");

        $output = fopen("php://output", "wb");

        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }
    ?>

    <div class="container">
        <div class="float-end d-flex flex-row">
            <h4>Code referenced for automatic creation of employees: </h4>
            <a href="https://github.com/fzaninotto/Faker" target="_blank"><button style="margin-left: 10px;"
                    type="button" class="btn btn-secondary btn-sm">Faker</button></a>
        </div><br><br>

        <form method="POST">
            <div class="form-floating">
                <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                    name="numberEmp">
                    <option selected>400</option>
                    <option>500</option>
                    <option>600</option>
                    <option>700</option>
                    <option>800</option>
                </select>
                <label id="floatingSelect-label" for="floatingSelect">Please select the number of employee</label>
            </div>
            <br>
            <div class="d-flex justify-content-end">
                <button type="submit" name="submit" class="btn btn-primary" value="submit">Generate</button>
            </div>
        </form>

    </div>

      <!-- Optional JavaScript -->
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>