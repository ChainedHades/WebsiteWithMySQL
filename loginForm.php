<?php
    // File: loginForm.php
    declare(strict_types = 1);

    session_start();
    
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    
    
    $curYear = date('Y');
    $username = $password = "";
    $errorMessage = "";
    $phpScript = sanitizeValue($_SERVER['PHP_SELF']);
    $keyUser = "";
    $keyPass = "";


    function sanitizeValue($value) {
        return htmlspecialchars( stripslashes( trim( $value ) ) );
    }

    
    if ( $_SERVER['REQUEST_METHOD'] == 'POST') {    
        require_once 'inc.db.php';

        $username = sanitizeValue($_POST['username']);
        $password = sanitizeValue($_POST['password']);


        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        try {
            $pdo = new PDO(DSN, USER, PWD);
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql = "SELECT username, password
                    FROM users                         
                    WHERE username = '$username';";
                
            $pdoStatement = $pdo->query($sql);
            $row = $pdoStatement->fetch();

            if($row != NULL){
                $keyUser = $row['username'];
                $keyPass = $row['password'];
            } else { $errorMessage = "Incorrect username or password."; }

            if($keyUser == $username && password_verify($password, $keyPass) )  {
                $_SESSION['username'] = $username;
                echo '<p>You have been successfully logged in.</p>',
                '<p><a href="index.php">Home</a></p>';        
                die;
            } else {
                $errorMessage = "Incorrect username or password."; 
            }
            $pdo = null;
            
    } catch (PDOException $e) {
        die ( $e->getMessage() );
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
                <h1>Login Form</h1>
            </header>

            <form action="<?php echo $phpScript; ?>" method="POST" class="w3-container">
            <p><!-- username -->
                    <label class="w3-text-dark-grey">Username:</label>
                    <span class="w3-text-red"> *</span>
                    <input required name="username" placeholder="username" value="<?php echo $username; ?>" class="w3-input w3-border">
                </p>
                <p><!-- password -->
                    <label class="w3-text-dark-grey">Password:</label>
                    <span class="w3-text-red"> *</span>
                    <input required type="password" name="password" placeholder="password" value="<?php echo $password; ?>" class="w3-input w3-border">
                </p>
                <p> <!-- login -->
                    <button name="submit" class="w3-btn w3-red">Login</button>
                </p>
            </form>

            <h2 class="w3-container w3-text-red"><?php echo $errorMessage; ?></h2>
        </div>

        
    </body>
</html>

<?php include 'inc.footer.php'; ?>