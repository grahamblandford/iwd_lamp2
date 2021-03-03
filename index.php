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
        Author:      T. Kim,  Group 5, INFO-5094-01-21W
        Date:        January 30th, 2021 (March 1st, 2021)
    -->

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Metrophobic&display=swap" rel="stylesheet">

    <!-- jQuery AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Custom styles for this template -->
    <!-- <link href="./css/starter-template.css" rel="stylesheet"> -->
    <link href="./css/style.css" rel="stylesheet">

</head>

<body>
    <!-- Load navigationMenu -->
    <?php
    include 'pages/navigationMenu.php';
    ?>

    <main class="container">

        <div class="starter-template text-center py-5 px-3">
            <h1>Update test </h1>
            <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text
                and a mostly barebones HTML document.</p>
        </div>

    </main>

    <!-- Optional JavaScript -->
    <!-- <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

</body>

</html>