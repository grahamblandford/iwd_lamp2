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
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
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
    <link href="./css/starter-template.css" rel="stylesheet">

    <?php
    define('_SERVER_PATH_', str_replace(basename(__FILE__), "", realpath(__FILE__)));
    include _SERVER_PATH_ . 'common.php';
    //$db_conn = connectDB();

    // Auto Mock Generator and symfony
    require_once 'vendor/autoload.php';
    ?>
</head>

<body>
    <!-- Load navigationMenu -->
    <?php
    //define('_SERVER_PATH_', str_replace(basename(__FILE__), "", realpath(__FILE__)));
    include _SERVER_PATH_ . 'navigationMenu.php';
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
                <label for="floatingSelect">Please select the number of employee</label>
            </div>
            <br>
            <div class="d-flex justify-content-end">
                <button type="submit" name="submit" class="btn btn-primary" value="submit">Generate</button>
            </div>
        </form>

    </div>

    <!-- /.container -->

    <!-- Optional JavaScript -->
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>