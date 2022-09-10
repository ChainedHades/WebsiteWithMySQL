<?php
    // File: deleteTrainer.php
    declare(strict_types = 1);
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    if ( !(isset( $_SESSION['username'] ) ) ) {
        header('Location: loginForm.php');
        die;
      }

    $id = sanitizeInput($_GET['id']);

    deleteTrainerRecord($id);
    header("Location: editConfirm.php?record=Trainer&recId=$id&editMode=Delete");

    function sanitizeInput($data) {
        return htmlspecialchars( stripslashes( trim($data) ) );
    }// end sanitizeInput()


    function deleteTrainerRecord($id) {
        
        try {
            require 'inc.db.php';

            // Connect to the database
            $pdo = new PDO(DSN, USER, PWD);
            
            // Configure error handling
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create the queries
            $sql = "
                DELETE FROM pokemon
                WHERE trainer\$id=$id;
            
                DELETE FROM trainer
                WHERE id=$id
            ";

            // Execute the query.
            $result = $pdo->exec($sql);
            $pdo = null;
                        
        } catch (PDOException $e) {
            die ( $e->getMessage() );
        }
    }// end deleteStudentRecord()
?>