// Title:       employees.js
// Application: INFO-5094 LAMP 2 Employee Project
// Purpose:     jQuery handling AJAX calls
// Author:      G. Blandford, Group 5, INFO-5094-01-21W
// Date:        March 2nd, 2021 (March 2nd, 2021)

$(document).ready(function() {

    var showEmployees = function(response) {

        // console.log(response);        
        let employee;

        if (response.status == "OK" || response.employees.length()) {
            $("#tbody-employees").html("")

            for (row in response.employees) {
                employee = response.employees[row];

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
                    + "</tr>"
                );
            }
        } else {
            $("#tbody-employees").html('<tr>' +
                '<td>No employees found.</td>' +
                '</tr>');
        }
    }

    $.get("../ajax/employees.php", showEmployees);
});

