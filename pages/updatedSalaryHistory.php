var_dump(getSalaryHistory('2018-03-01', 1));

function getSalaryHistory($hireDate, $startLevel) {

		// Get current date
        $currentDate = date_create(date("Y-m-d"));

        // Set start values for first iteration
        $salaryDate = date_create($hireDate);
        $salaryLevel = $startLevel;
        $endDate = null;

        $results = array();

        do {
            // We only need to query the database if
            // the anniversary date is after the last 
            // end date retrieved

            if ($endDate == null | $salaryDate > $endDate) {

                // Get the salary row from the database
                // Add the results and the anniversary date to the array
                $row = getSalaryLevel($salaryLevel, $salaryDate);

                $end_date = strtotime($row['end_date']);
                $end_date = date('Y', $end_date) . '-' . date('m', $end_end) . '-' . date('d', $end_date);

                array_push($results, ['salary_level' => $row['salary_level'], 'end_date' => $end_date, 'salary_per_annum' => $row['salary_per_annum'], 'salary_date' => $salaryDate]);

                $endDate = date_create($row['end_date']);
            }

            // If salary level is less than 9, add one
            if ($salaryLevel < 9) {
                $salaryLevel++;
            }

            $salaryDate = date_add($salaryDate, date_interval_create_from_date_string( "1 year"));

        } while (date_diff($currentDate, $salaryDate)->format("%R%a") < 0); // Check each anniversary date until today

        return $results;
    }

    function getSalaryLevel($level, $enddate) {

        $enddate = date(date_format($enddate, "Y-m-d"));

        $db_conn = connectDB();
    
        // query database
        try {
            $query = "SELECT salary_level, end_date, salary_per_annum FROM salaries WHERE salary_level = $level AND end_date >= '$enddate' ORDER BY end_date LIMIT 1";

            $stmt = $db_conn->query($query);

            // prepare error check
            if (!$stmt) {
                echo "<p>Error: " . $db_conn->errorCode() . "<br>Message: " . implode($db_conn->errorInfo()) . "</p><br>";
                exit(1);
            }

            if ($stmt->rowCount() > 0) { // Found
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                return $row;
            }

        } catch (Exception $err) {
            die("Oh noes! There's an error in the query!");
        }

        // close database connection
        $db_conn = null;
    }
?>