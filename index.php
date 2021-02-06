<?php session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>
    <!-- Custom styles for this template -->
    <link href="./css/starter-template.css" rel="stylesheet">

    <?php
    //define('_SERVER_PATH_', str_replace(basename(__FILE__), "", realpath(__FILE__)));
    //include _SERVER_PATH_ . 'common.php';
    //$db_conn = connectDB();
    ?>


</head>

<body>
    <!-- Load navigationMenu -->
    <?php
    define('_SERVER_PATH_', str_replace(basename(__FILE__), "", realpath(__FILE__)));
    include _SERVER_PATH_ . 'pages/navigationMenu.php';
    ?>

    <main class="container">

        <div class="starter-template text-center py-5 px-3">
            <h1>Bootstrap starter template</h1>
            <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text
                and a mostly barebones HTML document.</p>
        </div>

    </main><!-- /.container -->

    <!-- Optional JavaScript -->
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- commit update test by original accout by taehyung kim not taehyung kim-test -->

</body>

</html>