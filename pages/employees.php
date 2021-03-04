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
    <link href="https://fonts.googleapis.com/css2?family=Metrophobic&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap" rel="stylesheet">

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

    <form method="POST" id="form-employees">
        <div id="div-employees" class="container-fluid">
            <legend class="text-light bg-dark" style="margin-top: 10px">Employees</legend>
            <table id="table-employees" class="table table-light table-responsive table-striped">
                <thead id="thead-employees" class="table-dark">
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

        <div class="container-fluid container-crud">
            <table>
                <tr>
                    <td><input type="submit" form="form-employees" class="btn btn-success btn-crud" name="btn-add" value="Add"></td>
                    <td><input type="submit" class="btn btn-secondary btn-warning btn-crud" name="btn-edit" value="Edit"></td>
                </tr>
            </table>
        </div>
    </form>

    <!-- Modal to edit employee -->


    <div class="modal fade" id="edit-employee-modal" style="opacity:0.97 !important;"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">
                <!-- <div class="modal-header">
                    <h5 class="modal-title" id="edit-employee-modal-label">Employee Details</h5>
                </div> -->
                <div class="modal-body" id="edit-employee-modal-body">

                    <!-- <div class="container-fluid"> -->

                        <form id="form-employee" class="form form-inline" method="POST" style="padding-right: 30px;">

                        <fieldset class="bg-light">
                        <legend class="text-light bg-dark">Employee Details</legend>
    
                            <!-- Employee no.-->
                            <div class="input-group">
                                <label for="employee-id">No.</label>
                                <input type="text" size="10" maxlength="10" class="form-control" style="max-width: 100px" id="employee-id" name="employee-id" aria-describedby="employee-id-help" placeholder="" value="" readonly>
                                <small id="employee-id-help" class="form-text text-muted"></small>
                            </div>

                            <!-- First & Middle -->
                            <div class="input-group">
                                <label for="first-name">First/Middle</label>
                                <input type="text" size="20" maxlength="50" class="form-control" id="first-name" name="first-name" aria-describedby="first-name-help" placeholder="Enter first name" value="" required>
                                <small id="first-name-help" class="form-text text-muted"></small>

                                <input type="text" size="20" maxlength="50" class="form-control" id="middle-name" name="middle-name" aria-describedby="middle-name-help" placeholder="Enter middle name" value="">
                                <small id="middle-name-help" class="form-text text-muted"></small>
                            </div>

                            <!-- Last -->
                            <div class="input-group">
                                <label for="last-name">Last</label>
                                <input type="text" size="30" maxlength="50" class="form-control" id="last-name" name="last-name" aria-describedby="last-name-help" placeholder="Enter last name" value="" required>
                                <small id="last-name-help" class="form-text text-muted"></small>
                            </div>
                            
                            <!-- job type -->
                            <div class="input-group">
                                <label for="job-type">Part/Full-time</label>
                                <select class="selectpicker form-control" style="max-width: 220px;" id="job-type" name="job-type" aria-describedby="job-type-help" placeholder="Enter job type" required>
                                    <option value="FT" default>Full-time</option>
                                    <option value="PT">Part-time</option>
                                </select>
                                <small id="job-type-help" class="form-text text-muted"></small>
                            </div>

                            <!-- date of birth -->
                            <div class="input-group">
                                <label for="date-of-birth">Date of Birth</label>
                                <input type="date" size="30" maxlength="50" class="form-control" id="date-of-birth" name="date-of-birth" aria-describedby="date-of-birth-help" placeholder="Enter date of birth" value="" required>
                                <small id="date-of-birth-help" class="form-text text-muted"></small>
                            </div>

                            <!-- gender -->
                            <div class="input-group">
                                <label for="gender">Gender</label>
                                <select class="selectpicker form-control" style="max-width: 220px;" id="gender" name="gender" aria-describedby="gender-help" placeholder="Enter gender" required>
                                    <option value="Male" default>Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                                <small id="gender-help" class="form-text text-muted"></small>
                            </div>

                            <!-- date hired -->
                            <div class="input-group">
                                <label for="date-hired">Hired Date</label>
                                <input type="date" size="30" maxlength="50" class="form-control" id="date-hired" name="date-hired" aria-describedby="date-hired-help" placeholder="Enter date hired" value="" required>
                                <small id="date-hired-help" class="form-text text-muted"></small>
                            </div>

                            <!-- Salary Level -->
                            <div class="input-group">
                                <label for="hired-salary-level">Salary Level</label>
                                <input type="number" min="1" max="9" step="1" size="2" maxlength="2" 
                                        class="form-control" id="hired-salary-level" name="hired-salary-level" 
                                        aria-describedby="hired-salary-level-help" placeholder="Enter salary level" 
                                        value="1" required>
                                <small id="hired-salary-level-help" class="form-text text-muted"></small>
                            </div>

                            <table>
                                <tr>
                                <td><button id="btn-save" form="form-employee" type="submit" class="btn btn-primary btn-crud" name="btn-save" data-bs-dismiss="modal">Save</button></td>
                                <td><button type="submit" class="btn btn-secondary btn-crud close" form="form-cancel" data-bs-dismiss="modal" aria-label="Cancel">Cancel</button></td>
                                </tr>
                            </table>

                        </fieldset>

                        </form>

                    <!-- </div> -->

                    <!-- empty form for cancel button -->
                    <form id="form-cancel" hidden>
                    <form>

                </div>

            </div>
        </div>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>