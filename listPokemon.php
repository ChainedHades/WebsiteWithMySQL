<?php
    // File: listPokemon.php

    declare(strict_types = 1);
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    if ( !(isset( $_SESSION['username'] ) ) ) {
        header('Location: loginForm.php');
        die;
      }

    include 'inc.header.php';

    $formError = '';

    function pokemonList(PDOStatement $pdoStatement) : string {
        $row = $pdoStatement->fetch(PDO::FETCH_ASSOC);
        $table = '<table class="w3-table-all w3-hoverable w3-margin-top"><tr class="w3-red">';

        if($row == 0) { $formError = "Database is empty. Add some records."; } else {

            foreach($row as $col => $value) {
                $table .= "<th>$col</th>";
            }
            $table .= '</tr>';

            do {
                foreach($row as $col => $value) {
                    if ( $col === 'id' ) {
                        $table .= "<tr><td><a href='recordPokemon.php?id=$value'>$value</a></td>";
                    } else {
                        $table .= "<td>$value</td>";
                    }
                }
                $table .= '</tr>';
            } while ( $row = $pdoStatement->fetch(PDO::FETCH_ASSOC) );
            
            $table .= "</table>";
            return $table;
        }
    }// end trainerList()
    
    try {
        // Include the db connection string.
        require 'inc.db.php';

        // Connect to the db.
        $pdo = new PDO(DSN, USER, PWD);
        
        // Configure the error handling.
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create the query.
        $sql = '
            SELECT id, name, type, trainer$id
            FROM pokemon
            ORDER BY trainer$id
        ';

        // Execute the query.
        $pdoStatement = $pdo->query($sql);

        // Display the records in a table.
        echo pokemonList($pdoStatement);

        // Disconnect from the db.
        $pdo = null;
        
    } catch(PDOException $e) {
        die ($e->getMessage() );
    }

?>

<?php include 'inc.footer.php'; ?>
