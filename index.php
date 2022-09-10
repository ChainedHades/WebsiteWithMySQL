<?php
    // File: index.php

    declare(strict_types = 1);
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    if ( !(isset( $_SESSION['username'] ) ) ) {
        header('Location: loginForm.php');
        die;
      }

      $username = $_SESSION['username'];

      $welcomeMessage = "<h3>Welcome $username to Mason's Homepage</h3>";

    include 'inc.header.php';
?>


<header class="w3-container w3-red w3-margin-top">
    <h1 class="w3-center">Mason's Homepage</h1>
</header>
<body>
    <body class="w3-container w3-margin-left">

<div class="w3-container w3-light-grey w3-center">
    <br>
    <form method="GET">
        <p><?php echo $welcomeMessage; ?></p>
        
    <p>
            <button formaction="addTrainer.php" class="w3-button w3-round-large w3-red">Add Trainer</button>
            <button formaction="addPokemon.php" class="w3-button w3-round-large w3-red">Add Pokemon</button>
            <button formaction="listTrainers.php" class="w3-button w3-round-large w3-red">Show Trainers</button>
            <button formaction="listPokemon.php" class="w3-button w3-round-large w3-red">Show Pokemon</button>
        </p>

    </form>
    <br>
</div>
</body>
<?php include 'inc.footer.php'; ?>