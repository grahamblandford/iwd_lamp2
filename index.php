<?php
session_start();
include_once("./pages/check_session.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>LAMP 2 Project - Main Page</title>

    <!-- 
        Title:       index.php
        Application: INFO-5094 LAMP 2 Employee Project
        Purpose:     Main page
        Author:      T. Kim,  Group 9, INFO-5094-01-21W
        Date:        January 30th, 2021 (March 1st, 2021)

        20210413    GPB Update Description
    -->

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Metrophobic&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran&display=swap" rel="stylesheet">

    <!-- jQuery AJAX -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="./css/style.css" rel="stylesheet">

</head>

<body>
    <!-- Load navigationMenu -->
    <?php
    include 'pages/navigationMenu.php';
    ?>

    <main class="container">

        <div class="starter-template text-center py-5 px-3">
            <h1>INFO-5094-01-21W - LAMP 2 Project - Employee Information</h1>
            <h2>Group 9</h2>
            <h3>
            Graham Blandford<br>
            Sung-Kyu Choi<br>
            Jordan Foster<br>
            Taehyung Kim<br>
            Mykyta Koryliuk<br></h3>
            <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text
                and a mostly barebones HTML document.</p>
        </div>

    </main>
    <!-- Push test-->
    <!-- Optional JavaScript -->
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>