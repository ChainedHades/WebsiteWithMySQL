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


    $fname = $lname= $formError = '';
    $phpScript = sanitizeInput($_SERVER['PHP_SELF']);

    function sanitizeInput($value) {
        return trim( stripslashes( htmlspecialchars($value) ) );
    }// end sanitizeInput()


    function saveTrainerRecord($first, $last) {
        try {
            require_once 'inc.db.php';

            // Connect to the database
            $pdo = new PDO(DSN, USER, PWD);
            
            // Configure error handling
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create the query
            $sql = "
                INSERT INTO trainer
                  (first, last)
                VALUES 
                  ('$first', '$last')
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
        
        $fname = sanitizeInput($_POST['fname']);
        $lname = sanitizeInput($_POST['lname']);

        $isFnameEmpty = empty($fname);
        $isLnameEmpty = empty($lname);

        $hasFormEmptyFields =$isFnameEmpty || $isLnameEmpty;

        if ( !$hasFormEmptyFields || strlen($fname) > 20 || strlen($lname) > 20) {
            // Update the database with the new student record
            if ( saveTrainerRecord($fname, $lname) ) {
                // Show confirmation message
                header('Location: addConfirm.php?record=trainer');

            } else {
                $formError = "Oops, saving error occurred.";
            }

        } else {
            $formError = "Please fill out all the fields";
        }
    }
?>

<?php include 'inc.header.php'; ?>

    <body>
    <body class="w3-container w3-margin-left">
        <div class="w3-card w3-light-gray">
    <header class="w3-container w3-red w3-margin-top">
        <h1>Add Trainer Form</h1>
    </header>

<form action="<?php echo $phpScript; ?>" method="POST" class="w3-container">
    <p> <!-- first -->
        <label for="fname" class="w3-text-grey">First Name (Less than 20 characters)</label>
        <span class="w3-text-red"> *</span>
        <input id="fname" class="w3-input w3-border" accesskey="F"
               name="fname" placeholder="First name" required autofocus 
               value="<?php echo $fname; ?>"></p>
    <p> <!-- last -->
        <label for="lname" class="w3-text-grey">Last Name (Less than 20 characters)</label>
        <span class="w3-text-red"> *</span>
        <input id="lname" class="w3-input w3-border" accesskey="L"
               name="lname" placeholder="Last name" required
               value="<?php echo $lname; ?>"></p>
    <p> <!-- Save -->
        <button name="submit" class="w3-btn w3-red">Submit</button> 
        <span class="w3-text-red"><?php echo $formError; ?></span>
    <p>
</form>
</body>
<?php include 'inc.footer.php'; ?>