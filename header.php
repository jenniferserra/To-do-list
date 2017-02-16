<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>It's todo o'clock</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    require "dbconnect.php";

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE ) {
        // ------------------------------------------------------------------------
        // OM MAN ÄR INLOGGAD
        // ------------------------------------------------------------------------
        $user_id = $_SESSION['user_id'];
        $firstname = $_SESSION["firstname"];
        $lastname = $_SESSION["lastname"];


        $stmt = $conn->stmt_init();
        $stmt->prepare("SELECT * FROM users WHERE user_id = '{$user_id}'");
        $stmt->execute();
        $stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypt_password);
        $stmt->fetch();
    ?>

    <header> 
        <nav>
             <ul>
                 <li><a href="logout.php">Logga ut</a></li>
                 <li><a href="tasks.php">Mina uppgifter</a></li>
                 <li><a href="index.php">Hem</a></li>           
            </ul>     
         </nav>
    </header>

<?php

    // ------------------------------------------------------------------------
    // OM MAN INTE ÄR INLOGGAD
    // ------------------------------------------------------------------------

}else {
    ?>

    <header>     
        <nav class="navbar">
               <a href="login.php">Logga in</a>
         </nav>
    </header>

    <?php
}
?>
   
    
