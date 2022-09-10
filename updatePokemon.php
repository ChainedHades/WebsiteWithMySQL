<?php
    // File: updateStudentForm.php
    declare(strict_types = 1);
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    if ( !(isset( $_SESSION['username'] ) ) ) {
        header('Location: loginForm.php');
        die;
      }

    $name = $type = $tid = $formError = '';
    $phpScript = sanitizeInput($_SERVER['PHP_SELF']);

    function sanitizeInput($data) {
        return htmlspecialchars( stripslashes( trim( $data) ) );
    }// end sanitizeInput()
    

    function loadPokemonRecord($id) {
        try {
            require 'inc.db.php';

            // Connect to the database
            $pdo = new PDO(DSN, USER, PWD);
            
            // Configure error handling
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create the query
            $sql = 'SELECT id, name, type, trainer$id ' .
                   'FROM pokemon ' .
                   "WHERE id=$id";
            
            // Execute the query.
            $pdoStatement = $pdo->query($sql);
            $pdo = null;
            
            return $pdoStatement->fetch();
            
        } catch (PDOException $e) {
            die ( $e->getMessage() );
        }
    }

    function savePokemonRecord($id, $name, $type, $tid) {
        try {
            require 'inc.db.php';

            // Connect to the database
            $pdo = new PDO(DSN, USER, PWD);
            
            // Configure error handling
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create the query
            $sql = "
                UPDATE trainer
                SET name='$name',
                    type='$type',
                    trainer\$id='$tid'
                WHERE id=$id
            ";
            
            // Execute the query.
            $result = $pdo->exec($sql);
            $pdo = null;
            
            return $result;

        } catch (PDOException $e) {
            die ( $e->getMessage() );
        }
    }

   
    if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
        
        $id = sanitizeInput($_GET['id']);
        $record = loadPokemonRecord($id);
        $name = $record['name'];
        $type = $record['type'];
        $tid = $record['trainer$id'];

    } else {
        
        // Get the form field values. Trim and sanitize them first.
        $name = sanitizeInput($_POST['name']);
        $type = sanitizeInput($_POST['type']);
        $tid = sanitizeInput($_POST['tid']);

        if ( $id == 0 ) {
            // Update is being canceled.
            header("Location: listPokemon.php?rec=0");

        } else {
            // Updates are being saved.

            $isNameEmpty = empty($name);
            $isTypeEmpty = empty($type);
            $isTidEmpty = empty($tid);

            $hasFormEmptyFields = $isNameEmpty || $isTypeEmpty || $isTidEmpty;

            
            if ( !$hasFormEmptyFields ) {
                // First, we must save the changes to the DB.
                savePokemonRecord($id, $name, $type, $tid);
                header("Location: editConfirm.php?record=Pokemon&recId=$id&editMode=Update");
                
            } else {
                $formError = "Please fill out all the fields";
            }
        }
    } 
?>

<?php include 'inc.header.php'; ?>


<div class="w3-card w3-light-grey">
    <header class="w3-container w3-red w3-margin-top">
        <h1>Update Pokemon Form</h1>
    </header>

    <form action="<?php echo $phpScript; ?>" method="POST" class="w3-container">
    <p> 
        <label for="name" class="w3-text-grey">Name (Less than 20 characters)</label>
        <span class="w3-text-red"> *</span>
        <input id="name" class="w3-input w3-border"
               name="name" placeholder="Name of Pokemon" required autofocus 
               value="<?php echo $name; ?>"></p>
    <p>
    <label>Pokemon Type:</label>
                <select id = "type" name="type" required>
                    <option value="" disabled selected>Pokemon Type</option>
                    <option value="normal" >Normal</option>
                    <option value="fighting" >Fighting</option>
                    <option value="flying" >Flying</option>
                    <option value="poison" >Poison</option>
                    <option value="ground" >Ground</option>
                    <option value="rock" >Rock</option>
                    <option value="bug" >Bug</option>
                    <option value="ghost" >Ghost</option>
                    <option value="steel" >Steel</option>
                    <option value="fire" >Fire</option>
                    <option value="water" >Water</option>
                    <option value="grass" >Grass</option>
                    <option value="electric" >Electric</option>
                    <option value="psychic" >Psychic</option>
                    <option value="ice" >Ice</option>
                    <option value="dragon" >Dragon</option>
                    <option value="dark" >Dark</option>
                    <option value="fairy" >Fairy</option>
                </select>
                <span class="w3-text-red"> *</span>
            </p>

            <p> 
        <label for="tid" class="w3-text-grey">Trainer ID Number</label>
        <span class="w3-text-red"> *</span>
        <input id="tid" class="w3-input w3-border" required
               name="tid" placeholder="Trainer ID Number"  
               value="<?php echo $tid; ?>"></p>

        <!-- Edit buttons -->
        <div class="w3-container w3-center">
            <p>
                <button name="submit" value=<?php echo $id; ?> class="w3-button w3-green">Save</button>
                <button name="submit" value=0 class="w3-button w3-red">Cancel</button>
            </p> 
        </div>
    </form>
</div>

<?php include 'inc.footer.php'; ?>