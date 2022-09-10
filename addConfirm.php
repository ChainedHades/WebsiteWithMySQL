<?php
    // File: addConfirm.php
    // The $_GET['record'] value represents to which table we just added.

    function sanitizeInput($value) {
        return trim( stripslashes( htmlspecialchars($value) ) );
    }// end sanitizeInput()


    $record = sanitizeInput($_GET['record']);
?>
<?php include 'inc.header.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add Confirmation</title>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://www.w3schools.com/w3css/4/w3.css" rel="stylesheet">
    </head>

    <body>
        <div class = "w3-card w3-center w3-margin-top">
            <header class="w3-container w3-red">
                <h1>Add <?php echo $record; ?> Confirmation</h1>
            </header>

            <div class="w3-panel w3-center">
                <a href="index.php"><button class="w3-button w3-red">Ok</button></a>
            </div>

            <div class="w3-panel w3-light-grey">
                <h2 class="w3-text-green">Record added successfully.</h2>
            </div>
        </div>
    </body>
</html>
<?php include 'inc.footer.php'; ?>