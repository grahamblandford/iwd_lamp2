<?php
# When installed via composer
require_once 'vendor/autoload.php';

$faker = Faker\Factory::create();

// generate data by accessing properties
//echo $faker->name;
  // 'Lucy Cechtelar';
//echo $faker->address;
  // "426 Jordy Lodge
  // Cartwrightshire, SC 88120-6700"
//echo $faker->text;


//echo '<br>';
  // Dolores sit sint laboriosam dolorem culpa et autem. Beatae nam sunt fugit
  // et sit et mollitia sed.
  // Fuga deserunt tempora facere magni omnis. Omnis quia temporibus laudantium
  // sit minima sint.
        //BirthDate
        //echo $birthDate = $faker->dateTimeThisCentury($max ='-20 years')->format('Y-m-d');
        //echo '<BR>';
        //echo date("Y-m-d",strtotime($birthDate."+19 years"));
        //echo '<BR>';
        //echo $hireDate = $faker->dateTimeBetween($startDate = date("Y-m-d",strtotime($birthDate."+19 years")), $endDate = 'now')->format('Y-m-d');

        //echo '<BR>';
        //HireDate
        //$hireDate = $faker->dateTimeBetween($startDate= $birthDate, $endDate = 'now', $timezone = null);
        //echo $hireDate;




        
        
        function outputCSV($data) {
          header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=file.csv");
          $output = fopen("php://output", "wb");
          foreach ($data as $row)
            fputcsv($output, $row); // here you can change delimiter/enclosure
          fclose($output);
        }
        
        outputCSV(array(
          array("name 1", "age 1", "city 1"),
          array("name 2", "age 2", "city 2"),
          array("name 3", "age 3", "city 3")
        ));

?>