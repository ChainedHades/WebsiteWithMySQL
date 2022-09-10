<?php
    // File: recordPokemon.php

    declare(strict_types = 1);
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    if ( !(isset( $_SESSION['username'] ) ) ) {
        header('Location: loginForm.php');
        die;
      }

    $recId = $pid = sanitizeInput($_GET['id']);

    function sanitizeInput($value) {
        return htmlspecialchars( stripslashes( trim($value) ) );
    }

    function buildPokemonCard($pid) {
        $pokemonRecord = getPokemonRecord($pid);
        $pokemonName = $pokemonRecord['name'];
        $pokemonType = $pokemonRecord['type'];
        $tid = $pokemonRecord['trainer$id'];

        // Build a card and show the pokemon record.
        $card = "
            <div class='w3-card-4 w3-center' style='width:40%'>
                <header class='w3-container w3-light-grey'>
                    <h2>$pokemonName</h2>
                </header>
                <div class='w3-container'>
                    <p>Pokemon Name: $pokemonName</p>
                    <p>Pokemon Type: $pokemonType</p>
                    <p>Trainer ID: $tid</p>
                </div>
                <a href='listPokemon.php' class='w3-button w3-block w3-dark-grey'>Ok</a>
            </div>
        ";

        return $card;
    }

    function getPokemonRecord($pid) {
        try {
            require 'inc.db.php';

            $pdo = new PDO(DSN, USER, PWD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "
                SELECT id, name, type, trainer\$id
                FROM pokemon
                WHERE id = $pid
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
    <title>Pokemon</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<header class="w3-container w3-red w3-margin-top">
        <h1>Pokemon</h1>
    </header>
<body class="w3-panel">
    <?php echo buildPokemonCard($pid); ?>

</body>
<div class="w3-container w3-center">
        <p>
        <!-- Edit buttons -->
        <a href="<?php echo "deletePokemon.php?id=$recId"; ?>" 
        class="w3-button w3-red w3-right"> Delete</a>
        <a href="<?php echo "updatePokemon.php?id=$recId"; ?>" 
        class="w3-button w3-green w3-right w3-margin-right"> Update</a>
        </p> 
    </div>
</div>

<?php include 'inc.footer.php'; ?>