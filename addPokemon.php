<?php
    // File: addTrainer.php
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

    function sanitizeInput($value) {
        return trim( stripslashes( htmlspecialchars($value) ) );
    }// end sanitizeInput()


    function savePokemonRecord($name, $type, $tid) {
        try {
            require_once 'inc.db.php';

            // Connect to the database
            $pdo = new PDO(DSN, USER, PWD);
            
            // Configure error handling
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create the query
            $sql = "
                INSERT INTO pokemon
                  (name, type, trainer\$id)
                VALUES 
                  ('$name', '$type', '$tid')
            ";

            // Execute the query.
            $result = $pdo->exec($sql);

            // Disconnect from the db.
            $pdo = null;
            return true;

        } catch (PDOException $e) {
           return false;
        }
    }// end saveStudentRecord()

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        
        $name = sanitizeInput($_POST['name']);
        $type = sanitizeInput($_POST['type']);
        $tid = sanitizeInput($_POST['tid']);

        $isNameEmpty = empty($name);
        $isTypeEmpty = empty($type);
        $isTidEmpty = empty($tid);

        $hasFormEmptyFields = $isNameEmpty || $isTypeEmpty || $isTidEmpty;

        if ( !$hasFormEmptyFields || strlen($name) > 20 ) {
            // Update the database with the new student record
            if ( savePokemonRecord($name, $type, $tid) ) {
                // Show confirmation message
                header('Location: addConfirm.php?record=Pokemon');

            } else {
                $formError = "Oops, saving error occurred.";
            }

        } else {
            $formError = "Please fill out all the fields correctly";
        }
    }
?>

<?php include 'inc.header.php'; ?>

    <body>
    <body class="w3-container w3-margin-left">
        <div class="w3-card w3-light-gray">
    <header class="w3-container w3-red w3-margin-top">
        <h1>Add Pokemon Form</h1>
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
    <p> <!-- Save -->
        <button name="submit" class="w3-btn w3-red">Submit</button> 
        <span class="w3-text-red"><?php echo $formError; ?></span>
    <p>
</form>
</body>
<?php include 'inc.footer.php'; ?>