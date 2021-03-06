<?php
session_start();
include_once("check_session.php");

$_SESSION['PAGE'] = "employees";
if ( isset($_SESSION['text-search']) ) {
    unset($_SESSION['text-search']);
}
?>
<!DOCTYPE html>
<html>

<head>
    <!-- 
        Title:       employees.php
        Application: INFO-5094 LAMP 2 Employee Project
        Purpose:     Handles employee maintenance
        Author:      G. Blandford, Group 9, INFO-5094-01-21W
        Date:        March 2nd, 2021 (March 2nd, 2021)

        20210404    SKC     Added retirement functionality                
        20210407    GPB     Change Retirement age to date type                
        20210410    GPB     Combined Retirement fields                

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


    <!-- Custom JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../js/employees.js"></script>

    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">

    <?php
    // Load common
    // define('__ROOT__', dirname(__FILE__));
    // require_once(__ROOT__ . "/common.php");

    // Auto Mock Generator and symfony
    require_once '../vendor/autoload.php';
    ?>

</head>

<body>
    <!-- Load navigationMenu -->
    <?php
        include_once('./navigationMenu.php');
        include_once('./search-bar.php');
    ?>

    <div id="div-errors" class="container-fluid"></div>

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
                        <th scope="col">Retirement</th>
                        <th scope="col">Scenario</th>
                    </tr>
                </thead>
                <tbody id="tbody-employees">
                </tbody>
            </table>
        </div>

        <div class="container-fluid container-crud">
            <!-- Use this hidden element to pass action -->
            <input id="action" type="text" name="action" hidden>
            <table>
                <tr>
                    <td><input type="submit" class="btn btn-success btn-crud" name="btn-add" value="Add" onclick="(function(){ document.getElementById('action').value='add'; })()"></td>
                    <td><input type="submit" class="btn btn-secondary btn-warning btn-crud" name="btn-edit" value="Edit" onclick="(function(){ document.getElementById('action').value='edit'; })()"></td>
                </tr>
            </table>
        </div>

    </form>

    <form id="form-search" method="GET">
            <?php
            $fvalue = "";
            if (isset($_SESSION['text-search'])) {
                $fvalue = $_SESSION['text-search'];
            }
                getSearch($fvalue);
            ?>
    </form>


    <!-- Modal to edit employee -->
    <div class="modal fade" id="edit-employee-modal" style="opacity:0.97 !important;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-md" role="document">

            <div class="modal-content">
                <!-- <div class="modal-header">
                    <h5 class="modal-title" id="edit-employee-modal-label">Employee Details</h5>
                </div> -->
                <div class="modal-body" id="edit-employee-modal-body">

                    <form id="form-employee" class="form form-inline" method="POST">

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
                                <!-- <label for="date-hired">Hired Date</label> -->
                                <label for="date-hired">Hired / Salary Level</label>
                                <input type="date" size="30" maxlength="50" class="form-control" id="date-hired" name="date-hired" aria-describedby="date-hired-help" placeholder="Enter date hired" value="" required>
                                <small id="date-hired-help" class="form-text text-muted"></small>
                            <!-- </div> -->

                            <!-- Salary Level -->
                            <!-- <div class="input-group"> -->
                                <!-- <label for="hired-salary-level">Salary Level</label> -->
                                <input type="number" min="1" max="9" step="1" size="2" maxlength="2" style="max-width: 45px;" class="form-control" id="hired-salary-level" name="hired-salary-level" aria-describedby="hired-salary-level-help" placeholder="Enter salary level" value="1" required>
                                <small id="hired-salary-level-help" class="form-text text-muted"></small>
                            </div>

                            <!-- Earliest Retirement Date -->
                            <!-- <div class="input-group">
                                <label for="earliest-retirement-date">Earliest Retirement Date</label>
                                <input type="text" style="max-width: 100px;" class="form-control" id="earliest-retirement-date" name="earliest-retirement-date" aria-describedby="earliest-retirement-date-help" placeholder="" value="" readonly>
                                <small id="earliest-retirement-date-help" class="form-text text-muted"></small>
                            </div> -->

                            <!-- Retirement Scenario -->
                            <!-- <div class="input-group">
                                <label for="retirement-scenario">Retirement Scenario</label>
                                <input type="text" size="30" maxlength="50" class="form-control" id="retirement-scenario" name="retirement-scenario" aria-describedby="retirement-scenario-help" placeholder="" value="" readonly> 
                                <small id="hired-salary-level-help" class="form-text text-muted"></small>
                            </div> -->
                            <div class="input-group">
                                <label for="earliest-retirement">Earliest Retirement</label>
                                <input type="text" class="form-control" id="earliest-retirement" name="earliest-retirement" aria-describedby="earliest-retirement-help" placeholder="" value="" readonly>
                                <small id="earliest-retirement-help" class="form-text text-muted"></small>
                            </div>

                            <table>
                                <tr>
                                    <input id="save-action" type="text" name="save-action" value="" hidden>
                                    <td><input type="submit" class="btn btn-primary btn-crud" id="btn-save" name="btn-save" onclick="(function(){ document.getElementById('save-action').value='Save'; })()"></td>
                                    <td><button type="submit" class="btn btn-secondary btn-crud close" form="form-cancel" data-bs-dismiss="modal" aria-label="Cancel">Cancel</button></td>
                                    <!-- Show History Functionality | Added by Mykyta Koryliuk -->
                                    <td>
                                        <button
                                            type='button'
                                            class='btn btn-info btn-crud'
                                            id='btn-history'
                                            name='btn-history'
                                            onclick="(function() { window.open(`./salaryHistory.php?hired=${document.getElementById('date-hired').value}&level=${document.getElementById('hired-salary-level').value}&type=${document.getElementById('job-type').value}`, `salary_history`, 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=0,width=500,height=500'); })()"
                                        >
                                            Show History
                                        </button>
                                    </td>
                                    <!-- Show History Functionality | Added by Mykyta Koryliuk -->
                                </tr>
                            </table>

                        </fieldset>
                    </form>

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