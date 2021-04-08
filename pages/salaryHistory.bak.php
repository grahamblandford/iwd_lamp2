<?php
    session_start();
    include_once('check_session.php');
    require_once('common.php');
?>

<?php
    // Init primary variables
    $params = null;
    $levels_and_salaries = [[], [], [], []];
    $calculated_linear_progression = [];
?>

<?php
    // React on get request
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Retrieve url
        $url_params = parse_url($_SERVER['REQUEST_URI']);

        // Retrieve params from url
        parse_str($url_params['query'], $params);

        // Retrieve salary levels and periods from db
        retrieve_salary_levels_and_periods();

        // Analyze params and salary levels/periods from db to present progression
        prepare_linear_progression();
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- 
        Title:       salaryHistory.php
        Application: INFO-5094 LAMP 2 Employee Project
        Purpose:     Show Salary History
        Author:      M. Koryliuk, Group 9, INFO-5094-01-21W
        Date:        April 5th, 2021 (April 5th, 2021)
    -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="INFO-5094 LAMP 2 Employee Project">
    <meta name="author" content="Mykyta Koryliuk">

    <title>Salary History</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Metrophobic&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/style.css" rel="stylesheet">
    </head>
    <body>
        <div style="margin-top: -40px; margin-bottom: 40px;" class="container">
            <h1 class="text-light bg-dark text-center" style="padding-right: 45px; margin-bottom: 15px;">Annual Salary Grid</h1>
                <table class="table table-light table-responsive table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center">Level</th>
                            <th scope="col" class="text-center">End Date</th>
                            <th scope="col" class="text-center">Salary</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        for ($i = 0; $i < count($calculated_linear_progression); $i++) {
                            $row = $calculated_linear_progression[$i];

                            $level = $row['level'];
                            $end_date = $row['end_date'];
                            $salary = $row['salary'] < 100 ? $row['salary'] : number_format($row['salary'], 2, ".", ",");

                            echo "<tr><td class='text-center'>$level</td><td class='text-center'>$end_date</td><td class='text-center'>$$salary</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            
            <button class="btn btn-danger" onclick="javascript:window.close('','_parent','');">Close</button>
        </div>
    </body>
</html>

    <!-- Funtional Part starts here -->
<?php
    // Make db select and group data by year
    function retrieve_salary_levels_and_periods(): void {
        try {
            $db_conn = connectDB();

            $sql_query = "SELECT * FROM salaries";

            $stmt = $db_conn->query($sql_query);

            while ($count = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $date = strtotime($count['end_date']);
                $year = date('Y', $date);
                $month = date('m', $date);

                switch ($year) {
                    case '2017':
                        array_push($GLOBALS['levels_and_salaries'][0], $count);
                        break;
                    case '2020':
                        if ($month == 03) {
                            array_push($GLOBALS['levels_and_salaries'][1], $count);
                        } else {
                            array_push($GLOBALS['levels_and_salaries'][2], $count);
                        }
                        break;
                    case '2021':
                        array_push($GLOBALS['levels_and_salaries'][3], $count);
                        break;
                    default:
                        break;
                }
            }
        } catch (Exception $err) {
            die("Oh noes! There's an error in the query!");
        }
    }
?>

<?php
    // Facilitator for date handling
    function prepare_date($date): array {

        $str_date = strtotime($date);

        $year = intval(date('Y', $str_date));
        $month = intval(date('m', $str_date));
        $day = intval(date('d', $str_date));

        return ['year' => $year, 'month' => $month, 'day' => $day];
    }
?>

<?php
    // Perform data inserts in one function
    function perform_insert($years, $hired_level, $hired_type, $year_in_progress, $month_in_progress, $day_in_progress) {
        for ($a = 0; $a < count($years); $a++) {
            $year = $years[$a];

            if ($hired_level == $year['salary_level']) {
                $salary = ($hired_type == 'FT') ? $year['salary_per_annum'] : round($year['salary_per_annum'] / 261 / 8);
                $date = prepare_date($year['end_date']);
                $month_to_insert = $month_in_progress ? $month_in_progress : $date['month'];
                $day_to_insert = $day_in_progress ? $day_in_progress : $date['day'];
                $date_to_insert = $year_in_progress . '-' . $month_to_insert . '-' . $day_to_insert;
                
                array_push($GLOBALS['calculated_linear_progression'], ['salary' => $salary, 'level' => $year['salary_level'], 'end_date' => $date_to_insert]);
            
                break;
            }
        }
    }

    function handle_progression($period, $mode, $hired_level, $hired_type, $year_in_progress, $month_in_progress, $day_in_progress): void {

        // Retrieve db info from global variable
        $local_salaries = $GLOBALS['levels_and_salaries'];

        // Check for conflict months
        // 1: Perform Insertions for one month
        if ($mode == 1) {
            $years = $local_salaries[$period];

            perform_insert($years, $hired_level, $hired_type, $year_in_progress, $month_in_progress, $day_in_progress);
        } // 2: Perform Insertions for two month 
        else {
            $years_first = $local_salaries[$period];
            $years_second = $local_salaries[$period + 1];

            perform_insert($years_first, $hired_level, $hired_type, $year_in_progress, $month_in_progress, $day_in_progress);
            perform_insert($years_second, $hired_level, $hired_type, $year_in_progress, $month_in_progress, $day_in_progress);
        }
    }
?>

<?php
    function sorting_years_to_handle_progression($year, $hired_level, $hired_date, $hired_type, $is_same_level): void {

        // Date for IF manipulations
        $hired_year = $hired_date['year'];
        $hired_month = $hired_date['month'];
        $hired_day = $hired_date['day'];

        // Perform navigation via dates
        if ($year <= 2017) {
            if ($year == 2017) {
                handle_progression(0, 1, $hired_level, $hired_type, $year, false, false);
            } else {
                if (!$is_same_level) {
                    handle_progression(0, 1, $hired_level, $hired_type, $year + 1, $hired_month, $hired_day - 1);
                }
            }
        } else if ($year == 2018 || $year == 2019) {
            if (!$is_same_level) {
                handle_progression(1, 1, $hired_level, $hired_type, $year, false, false);
            }
        } else if ($year == 2020) {
            if ($hired_year == 2020) {
                if ($hired_month <= 2 || ($hired_month == 3 && $hired_day <= 13)) {
                    handle_progression(1, 2, $hired_level, $hired_type, $year, false, false);
                } else if ($hired_month > 3 || ($hired_month == 3 && $hired_day >= 14)) {
                    handle_progression(2, 1, $hired_level, $hired_type, $year, 12, 31);
                }
            } else {
                handle_progression(1, 1, $hired_level, $hired_type, $year, 3, 13);
                handle_progression(2, 1, $hired_level, $hired_type, $year, 12, 31);
            }
        } else if ($year == 2021) {
            handle_progression(3, 1, $hired_level, $hired_type, $year, 0, 0);
        }
    }
?>

<?php
    function prepare_linear_progression(): void {

        // Retrieve URL params from global variable
        $local_params = $GLOBALS['params'];

        // Establish type of employment
        $hired_type = $local_params['type'];

        // Prepare current date AND hired date to keep track of years to come
        $current_date = prepare_date(date("Y-m-d"));
        $hired_date = prepare_date($local_params['hired']);
        $year = $hired_date['year'];

        // Calculate number of levels left
        $hired_level = intval($local_params['level']);
        $levels_to_maximum_level = 9 - $hired_level;

        // Calculate number of years left
        $year_difference = $current_date['year'] - $year;
        $years_to_count = $year_difference ? $year_difference : 1;

        if ($years_to_count) {
            for ($i = 0; $i <= $years_to_count; $i++) {
                if ($hired_level == 9) {
                    sorting_years_to_handle_progression($year, $hired_level, $hired_date, $hired_type, true);
                } else {
                    sorting_years_to_handle_progression($year, $hired_level, $hired_date, $hired_type, false);
                }

                if ($levels_to_maximum_level) {
                    ++$hired_level;
                    --$levels_to_maximum_level;
                }

                ++$year;
            }
        }
    }
?>