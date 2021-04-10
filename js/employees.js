// Title:       employees.js
// Application: INFO-5094 LAMP 2 Employee Project
// Purpose:     jQuery handling AJAX calls
// Author:      G. Blandford, Group 5, INFO-5094-01-21W
// Date:        March 2nd, 2021 (March 2nd, 2021)

//              20210404      SKC     Added retirement functionality      
// 				20210410      GPB     Combined Retirement fields & re-wording
//                                    for styling purposes (mobile view)   

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
    // From and including start date, and
    // To, but NOT including end date
    function getRetirement (emp) {
        if (emp.employee_id) {
            var dob = new Date(emp.date_of_birth);
            var hired = new Date(emp.date_hired);

            var dobYear = dob.getFullYear();
            var dobMonth = dob.getMonth();
            var dobDate = dob.getDate();

            // Date for Scenario A (Date turning Age 65)
            var retireA = new Date(dobYear + 65, dobMonth, dobDate)

            var today = new Date();
            var difference1 = today.getTime() - dob.getTime();        
            var difference2 = today.getTime() - hired.getTime();
            
            // 2682396000000 is the number of milliseconds in 85 years
            // 1 year = 365.25 days
            var retireBms = (2682396000000 - (difference1 + difference2))/2 + today.getTime();
            var retireBmsDate = new Date(retireBms);

            var retireBYear = retireBmsDate.getFullYear();
            var retireBMonth = retireBmsDate.getMonth();
            var retireBDate = retireBmsDate.getDate();

            // Date for Scenario B (Date when Age + Service Years = 85)
            var retireB = new Date(retireBYear, retireBMonth, retireBDate);

            var retirePriority = retireA <= retireB ? retireA : retireB;
            
            var retirement_year = retirePriority.getFullYear();
            var retirement_month = retirePriority.getMonth() + 1;
            var retirement_date = retirePriority.getDate();

            function checkMonthDate (num) {
                return num < 10 ? "0" + num : num;
            }

            retirement_full_date = retirement_year + "-" + checkMonthDate(retirement_month) + "-" + checkMonthDate(retirement_date);
            retirement_scenario = retireA <= retireB ? "Age = 65 (A)" : "Age + Service Years = 85 (B)";
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

            getRetirement(employee);

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

            retirement_full_date = '';
            retirement_scenario = '';

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

                getRetirement(employee);

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

