// Title:       employees.js
// Application: INFO-5094 LAMP 2 Employee Project
// Purpose:     jQuery handling AJAX calls
// Author:      G. Blandford, Group 5, INFO-5094-01-21W
// Date:        March 2nd, 2021 (March 2nd, 2021)

//              210404      SKC     Added retirement functionality                

$(document).ready(function() {

    $("#form-search").submit( function(event){
		$.get("../ajax/employees.php", $(this).serialize(), showEmployees);
		event.preventDefault();	 
	});

    $("#form-employees").submit( function(event){
		$.post("../ajax/employees.php", $(this).serialize(), displayEmployee);
		event.preventDefault();	 
	});

    $("#form-employee").submit( function(event){
		$.post("../ajax/employees.php", $(this).serialize(), saveEmployee);
		event.preventDefault();	 
	});

    // function post-save actions
    var saveEmployee = function(response) {

        // Reset action
        $('#save-action').val("");

        if (response.status == "OK") {

            // Show employees
            $.get("../ajax/employees.php", showEmployees);

            // Dismiss the modal
            $("#edit-employee-modal").modal('hide');

        } else {
            let errors = response.errors;
            showErrors(errors);
        }
    }

    var retirement_full_date = '';
    var retirement_scenario = '';

    // function for getting retirement data
    function getRetirement (emp, type) {
        if (emp.employee_id) {
            var dob = new Date(emp.date_of_birth);
            var hired = new Date(emp.date_hired);

            var dobYear = dob.getFullYear();
            var dobMonth = dob.getMonth() + 1;
            var dobDate = dob.getDate();

            // Date for Scenario A (Date turning Age 65)
            var retireA = new Date(dobYear + 65, dobMonth - 1, dobDate);

            var today = new Date();
            var difference1 = today.getTime() - dob.getTime();        
            var difference2 = today.getTime() - hired.getTime();
            
            // Date for Scenario B (Date when Age + Serbive Years = 85
            // 2682396000000 is the number of milliseconds in 85 years
            var retireBms = (2682396000000 - (difference1 + difference2))/2 + today.getTime();
            var retireB = new Date(retireBms);

            var retirePriority = retireA <= retireB ? retireA : retireB;

            var retirement_year = retirePriority.getFullYear();
            var retirement_month = retirePriority.getMonth();
            var retirement_date = retirePriority.getDate();

            if (type === "mainPage") {
                if (retirement_month < 10) {
                    retirement_full_date = retirement_year + "-0" + retirement_month + "-" + retirement_date;       
                } else {
                    retirement_full_date = retirement_year + "-" + retirement_month + "-" + retirement_date;   
                }
            } else {
                if (retirement_month < 10) {
                    retirement_full_date = "0" + retirement_month + " / " + retirement_date + " / " + retirement_year;   
                } else {
                    retirement_full_date = retirement_month + " / " + retirement_date + " / " + retirement_year;
                }    
            }

            retirement_scenario = retireA <= retireB ? "A (Date turning Age 65)" : "B (Date when Age + Service Years = 85)";
        } else {
            retirement_full_date = '';
            retirement_scenario = '';
        }
    }
    
    // function to display the employee form
    var displayEmployee = function(response) {

        // Reset action
        $('#action').val("");

        //console.log(response);
        let employee;

        if (response.status == "OK") {

            employee = response.employee[0];

            getRetirement(employee, "editPage");

            $('#employee-id').val(employee.employee_id);
            $('#first-name').val(employee.first_name);
            $('#middle-name').val(employee.middle_name);
            $('#last-name').val(employee.last_name);
            $('#job-type').val(employee.job_type);
            $('#date-of-birth').val(employee.date_of_birth);
            $('#gender').val(employee.gender);
            $('#date-hired').val(employee.date_hired);
            $('#hired-salary-level').val(employee.hired_salary_level);
            $('#earliest-retirement-date').val(retirement_full_date);
            $('#retirement-scenario').val(retirement_scenario);

            // Show the modal form
            $("#edit-employee-modal").modal('show');
        
        } else if ( response.status == "ERR" ) {

            let errors = response.errors;
            showErrors(errors);
        }
    }

    // function to show employees table
    var showEmployees = function(response) {

//  console.log(response);        
        let employee;

        if (response.status == "OK" || response.employees.length()) {
            $("#tbody-employees").html("")

            for (row in response.employees) {
                employee = response.employees[row];

                getRetirement(employee, "mainPage");

                $("#tbody-employees").append(
                    "<tr>"
                    + '<th><input type="radio" style="width:10px;" name="selected[]" value="' + employee.employee_id + '"></th>'
                    + "<td>" + employee.employee_id + "</td>"
                    + "<td>" + employee.full_name + "</td>"
                    + "<td>" + employee.job_type + "</td>"
                    + "<td>" + employee.date_of_birth + "</td>"
                    + "<td>" + employee.gender + "</td>"
                    + "<td>" + employee.date_hired + "</td>"
                    + "<td>" + employee.hired_salary_level + "</td>"
                    + "<td>" + retirement_full_date + "</td>"
                    + "<td>" + retirement_scenario + "</td>"
                    + "</tr>"
                );
            }
        } else {
            $("#tbody-employees").html('<tr>' +
                '<td>No employees found.</td>' +
                '</tr>');
        }
    }

    // Function to display errors in a timed
    // dismissible block
    function showErrors(errors) {

        if (errors === undefined) {
            $('#div-errors').html('');
            return;
        }

        let html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';

        errors.forEach(function(e){
            html += ('<p>' + e + '</p>');
        });
        html += '<button type="button" class="btn btn-danger btn-crud close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">OK</span></button></div>';
        $('#div-errors').html(html);

        setTimeout(function () { showErrors(); }, 3000);
    }

    // Show all employees
    $.get("../ajax/employees.php", showEmployees);
});

