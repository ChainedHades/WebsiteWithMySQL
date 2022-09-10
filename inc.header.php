<?php
      // File: inc.header.php
      $homePage = 'index.php';
?>

<!DOCTYPE html>
<html>
<head>
      <title>Mason's Website</title>
      <meta charset="utf-8"
            name="viewport"
            content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" 
            href="https://www.w3schools.com/w3css/4/w3.css">
            <header class="w3-container w3-red w3-margin-top ">
                <h1>Mason's Website</h1>
            </header>
</head>

<body>
<!--Include the navigation bar. -->
<div class="w3-panel w3-bar w3-red">
      <a href="<?php echo $homePage; ?>" 
         class="w3-bar-item w3-button">Home<i class="fa fa-home w3-xlarge"></i></a>
      <a href="loginForm.php" 
         class="w3-bar-item w3-button">Login<i class="fa fa-home w3-xlarge"></i></a>
      <a href="createAccount.php" 
         class="w3-bar-item w3-button">Create Account<i class="fa fa-home w3-xlarge"></i></a>
      <a href="logout.php" 
         class="w3-bar-item w3-button">Logout<i class="fa fa-home w3-xlarge"></i></a>
</div>
<main class="w3-display">