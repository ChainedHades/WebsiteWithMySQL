<?php

    declare(strict_types = 1);
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $username = $password = "";
    $phpScript = sanitizeValue($_SERVER['PHP_SELF']);

    function sanitizeValue($value) {
        return htmlspecialchars( stripslashes( trim( $value ) ) );
    }

    $errorMessage = "";
    // If posting then create account
    if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
        // Get the user credentials
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if(strlen($username)>4 && strlen($username)< 21 && strlen($password)>4 && strlen($password)<21) {
        
        try {
            require 'inc.db.php';

            $pdo = new PDO(DSN, USER, PWD);
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Hash the password
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            
            // Insert username and password hash into 'users' table, with the 'bcrypt' database.
            $sql = 'INSERT INTO users ' .
            '  (username, password) ' .
            'VALUES ' .
            "  ('$username', '$passwordHash')";
            
            if ( $pdo->exec($sql) ) {
                echo '<p>Your account has been created.</p>',
                '<p><a href="loginForm.php">Login</a></p>';
                $pdo = null;
                die;
            } else {
                $errorMessage = "Sorry, could not create your account.";
            }
        } catch (PDOException $e) {
             $errorMessage = "Account with that username has already been created.";
        }
    } else {   
        $errorMessage = "Sorry, could not create your account because username or password did not meet requirements.";
    }
}
?>

<?php include 'inc.header.php'; ?>

<!DOCTYPE html>
<html>
<body>
<body class="w3-container w3-margin-left">
<div class="w3-card w3-light-gray">
        <header class="w3-container w3-red w3-margin-top">
                <h1>Create Account Form</h1>
            </header>
        <script scr="validate.js" defer></script>
        <form action="<?php echo $phpScript; ?>" method="POST" id="account" class="w3-container">
        
        <p>
            <label class="w3-text-dark-grey" minlength="5" maxlength="20">Username (must be between 5-20 characters): </label>
            <span class="w3-text-red"> *</span>
            <input required name="username" placeholder="username" value="<?php echo $username; ?>" class="w3-input w3-border" autofocus>
        </p>
        <p>
            <label class="w3-text-dark-grey" minlength="5" maxlength="20">Password (must be between 5-20 characters): </label>
            <span class="w3-text-red"> *</span>
            <input type="password" placeholder="password" value="<?php echo $username; ?>" required name="password" class="w3-input w3-border">
        </p>
        <p> <!-- create account -->
                    <button name="submit" class="w3-btn w3-red">Create Account</button>
                </p>
    </form>
    <h2 class="w3-container w3-text-red"><?php echo $errorMessage; ?></h2>
    </div>
</body>
</html>

<?php include 'inc.footer.php'; ?>
