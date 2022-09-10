<?php
    // File: recordTrainer.php

    declare(strict_types = 1);
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    if ( !(isset( $_SESSION['username'] ) ) ) {
        header('Location: loginForm.php');
        die;
      }

    $recordId = $id = sanitizeInput($_GET['id']);

    function sanitizeInput($value) {
        return htmlspecialchars( stripslashes( trim($value) ) );
    }

    function buildTrainerCard($id) {
        $trainerRecord = getTrainerRecord($id);
        $trainerFName = $trainerRecord['first'];
        $trainerLName = $trainerRecord['last'];
        $tid = $trainerRecord['id'];

        // Build a card and show the student record.
        $card = "
            <div class='w3-card-4 w3-center' style='width:40%'>
                <header class='w3-container w3-light-grey'>
                    <h2>$trainerFName $trainerLName</h2>
                </header>
                <div class='w3-container'>
                    <p>Trainer ID: $tid</p>
                    <p>Trainer First Name: $trainerFName</p>
                    <p>Trainer Last Name: $trainerLName</p>
                </div>
                <a href='listTrainers.php' class='w3-button w3-block w3-dark-grey'>Ok</a>
            </div>
        ";

        return $card;
    }

    function getTrainerRecord($id) {
        try {
            require 'inc.db.php';

            $pdo = new PDO(DSN, USER, PWD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "
                SELECT id, first, last
                FROM trainer
                WHERE id = $id
            ";

            $row = $pdo->query($sql)->fetch();
            $pdo = null;
            return $row;

        } catch(PDOException $e) {
            die ($e->getMessage() );
        }
    }
?>

<?php include 'inc.header.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Trainer</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<header class="w3-container w3-red w3-margin-top">
        <h1>Trainer</h1>
    </header>
<body class="w3-panel">
    <?php echo buildTrainerCard($id); ?>

</body>
<div class="w3-container w3-center">
        <p>
        <!-- Edit buttons -->
        <a href="<?php echo "deleteTrainer.php?id=$recordId"; ?>" 
        class="w3-button w3-red w3-right"> Delete</a>
        <a href="<?php echo "updateTrainer.php?id=$recordId"; ?>" 
        class="w3-button w3-green w3-right w3-margin-right"> Update</a>
        </p> 
    </div>
</div>

<?php include 'inc.footer.php'; ?>