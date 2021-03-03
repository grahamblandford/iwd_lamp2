<?php
    session_start();
    include_once("check_session.php");  

    $_SESSION['PAGE'] = "employees";
?>
<!DOCTYPE html>
<html>

<head>
    <!-- 
        Title:       employees.php
        Application: INFO-5094 LAMP 2 Employee Project
        Purpose:     Handles employee maintenance
        Author:      G. Blandford, Group 5, INFO-5094-01-21W
        Date:        March 2nd, 2021 (March 2nd, 2021)
    -->

    <title>LAMP 2 Project - Employees</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="INFO-5094 LAMP 2 Employee Project">
    <meta name="author" content="Graham Blandford">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Metrophobic&display=swap" rel="stylesheet">

    <!-- jQuery AJAX -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

    <!-- Custom JS -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script> 
    <script src="../js/employees.js"></script> 

    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">

    <?php
    // Load common
    define('__ROOT__', dirname(__FILE__));
    require_once(__ROOT__ . "/common.php");

    // Auto Mock Generator and symfony
    require_once '../vendor/autoload.php';
    ?>

</head>

<body>
    <!-- Load navigationMenu -->
    <?php
        include_once('./navigationMenu.php');
    ?>

    <div id="div-employees" class="container-fluid">
        <legend class="text-light bg-dark" style="margin-top: 10px">Employees</legend>
        <table id="table-employees" class="table table-light table-responsive table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">No.</th>
                    <th scope="col">Name</th>             
                    <th scope="col">PT/FT</th>             
                    <th scope="col">DoB</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Hired</th>
                    <th scope="col">Salary</th>
                </tr>
            </thead>
            <tbody id="tbody-employees">
            </tbody>
        </table>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
