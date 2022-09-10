<?php
    // File: editConfirm.php
    // The $_GET['record'] value represents what table we just added.
    // The $_GET['id'] is the id of the udtate/deleted record
    declare(strict_types = 1);
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    if ( !(isset( $_SESSION['username'] ) ) ) {
        header('Location: loginForm.php');
        die;
      }

    function sanitizeInput($data) {
        return htmlspecialchars( stripslashes( trim($data) ) );
    }// end sanitizeInput()

    $record = sanitizeInput($_GET['record']);
    $recId = sanitizeInput($_GET['recId']);
    $editMode = sanitizeInput($_GET['editMode']);
?>
<?php include 'inc.header.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit Confirmation</title>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet">
    </head>

    <body>
        <div class = "w3-card w3-center w3-margin-top">
            <header class="w3-container w3-red">
                <h1><?php echo "$editMode $record "; ?>Confirmation</h1>
            </header>

            <div class="w3-panel w3-center">
                <a href="index.php"><button class="w3-button w3-red">Ok</button></a>
            </div>

            <div class="w3-panel w3-light-grey">
                <h2 class="w3-text-green">Record <?php echo "($recId) $editMode" . "d"; ?> successfully.</h2>
            </div>
        </div>
    </body>
</html>

<?php include 'inc.footer.php'; ?>