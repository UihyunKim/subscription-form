<?php
    $host = 'localhost';
    $user = 'root';
    $password = '123456';
    $dbname = 'daily_photo';

    // Set DSN
    $dsn = 'mysql:host='. $host .';dbname=' .$dbname;

    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    // PDO Query
    // $stmt = $pdo->query('SELECT * FROM accounts');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="./style/style.css">
    <title>Daily Photo</title>
</head>

<body class="bg-dark d-flex justify-content-center align-items-center">
    <div class="container">
        <div class="row h-100">

            <!-- left main colon - Background image-->
            <div class="col-lg-8 main-img">
                <h1>Get feeling up with wonderful pics!</h1>
                <h2>We deliver most inspired photos to make your bothered mail box happy.</h2>
            </div>

            <!-- right main colon - Forms -->
            <div class="col-lg-4 bg-white form-container">
            