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

    $fname = $lname = $formError = '';
    $phpScript = sanitizeInput($_SERVER['PHP_SELF']);

    function sanitizeInput($data) {
        return htmlspecialchars( stripslashes( trim( $data) ) );
    }// end sanitizeInput()
    

    function loadTrainerRecord($id) {
        try {
            require 'inc.db.php';

            // Connect to the database
            $pdo = new PDO(DSN, USER, PWD);
            
            // Configure error handling
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create the query
            $sql = 'SELECT id, first, last ' .
                   'FROM trainer ' .
                   "WHERE id=$id";
            
            // Execute the query.
            $pdoStatement = $pdo->query($sql);
            $pdo = null;
            
            return $pdoStatement->fetch();
            
        } catch (PDOException $e) {
            die ( $e->getMessage() );
        }
    }

    function saveTrainerRecord($id, $fname, $lname) {
        try {
            require 'inc.db.php';

            // Connect to the database
            $pdo = new PDO(DSN, USER, PWD);
            
            // Configure error handling
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create the query
            $sql = "
                UPDATE trainer
                SET first='$fname',
                    last='$lname'
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
        $record = loadTrainerRecord($id);

        $fname = $record['first'];
        $lname = $record['last'];

    } else {
        
        // Get the form field values. Trim and sanitize them first.
        $id = sanitizeInput($_POST['submit']);
        $fname = sanitizeInput($_POST['fname']);
        $lname = sanitizeInput($_POST['lname']);

        if ( $id == 0 ) {
            // Update is being canceled.
            header("Location: listTrainers.php?rec=0");

        } else {
            // Updates are being saved.
            $isFnameEmpty = empty($fname);
            $isLnameEmpty = empty($lname);

            $hasFormEmptyFields =  $isFnameEmpty || $isLnameEmpty;
            
            if ( !$hasFormEmptyFields ) {
                // First, we must save the changes to the DB.
                saveTrainerRecord($id, $fname, $lname);
                header("Location: editConfirmTrainer.php?record=Trainer&recId=$id&editMode=Update");
                
            } else {
                $formError = "Please fill out all the fields";
            }
        }
    } 
?>

<?php include 'inc.header.php'; ?>


<div class="w3-card w3-light-grey">
    <header class="w3-container w3-red w3-margin-top">
        <h1>Update Trainer Form</h1>
    </header>

    <form action="<?php echo $phpScript; ?>" method="POST">
        <div class="w3-container">
            <p> <!-- first -->
                <label for="fname" class="w3-text-grey">First Name</label>
                <span class="w3-text-red"> *</span>
                <input id="fname" class="w3-input w3-border" accesskey="F" name="fname" placeholder="First name" value="<?php echo $fname; ?>" required>
            </p>
            <p> <!-- last -->
                <label for="lname" class="w3-text-grey">Last Name</label>
                <span class="w3-text-red"> *</span>
                <input id="lname" class="w3-input w3-border" accesskey="L" name="lname" placeholder="Last name" value="<?php echo $lname; ?>" required>
            </p>
        </div>

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