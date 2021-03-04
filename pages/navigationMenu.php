<!-- 
    Title:       navigationMenu.php
    Application: INFO-5094 LAMP 2 Employee Project
    Purpose:     Main navigation and menu
    Author:      T. Kim,  Group 5, INFO-5094-01-21W
    Date:        January 30th, 2021 (March 1st, 2021)

    20210301    GPB Move List functions to separate dropdown menu, Added Logout ability, Employees link
    20210303    GPB Corrected links to pages 
-->
<?php

$base_URL = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
$base_URL .= $_SERVER['HTTP_HOST'];
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">

  <div class="container-fluid">

    <a class="navbar-brand" href="<?php echo $base_URL . "/index.php" ?>">LAMP 2 Project</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">

      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item active">
          <a class="nav-link" aria-current="page" href="<?php echo $base_URL . "/index.php" ?>">Home</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          List Functions
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink1">
            <li><a class="dropdown-item" href="<?php echo $base_URL . "/pages/csv_generator.php" ?>">Create CSV</a></li>
            <li><a class="dropdown-item" href="<?php echo $base_URL . "/pages/insertEmployee.php" ?>">Load CSV > Employees</a></li>
          </ul>
        </li>
        <li class="nav-item active">
          <a class="nav-link" aria-current="page" href="<?php echo $base_URL . "/pages/employees.php" ?>">Employees</a>
        </li>
      </ul>

      <?php
      if (isset($_SESSION['CURRENT_USER'])) {
      ?>
      <div  style="float: right;">
        <!-- Logout -->
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Welcome, <?php echo $_SESSION['CURRENT_USER']['user_id'];?>!
            </a>
            <ul class="dropdown-menu me-auto mb-2 mb-md-0" aria-labelledby="navbarDropdownMenuLink2">
              <li><a class="dropdown-item" href="<?php echo $base_URL . "/pages/logout.php" ?>">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <?php
      }
      ?>

    </div>
  </div>
</nav>