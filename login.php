<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Logga in/Registrera</title>
    <link rel="stylesheet" href="css/style.css">
      
<?php
include "functions.php";
?>
  </head>

  <body class="loginbackground">
    <div class="loginpage"> 

<!-- *******************************************************************************************************************************
SESSION MSG HÄMTAR MEDDELANDE FRÅN LOGINCHECK.PHP OCH TALAR OM IFALL LÖSENORD/EMAIL SAKNAS ELLER OM ANVÄNDAREN SOM FÖRSÖKER LOGGA IN INTE FINNS
************************************************************************************************************************************ -->
 
  <?php if (isset( $_SESSION['msg'])) { echo "<div class='message'>" . $_SESSION['msg'] . "</div>"; unset($_SESSION['msg']); } ?>


  <!-- LOGGA IN -->

    <div class="login-box">
      <form method="POST" action="logincheck.php">
        <h1>Hej kompis! Välkommen tillbaka.</h1>
        <input type="email" name="email" placeholder="E-post"><br>
        <input type="password" name="password" placeholder="Lösenord"><br>
        <input name="login" class="button" type="submit" value="Logga in"><br>
        <span class="loginlinks">Inget konto än? <a href="register.php">Registrera dig nu!</a></span>
      </form>

    </div>
      <?php 
     
      regUser(); 

      ?>

    </div>
  </body>
</html>
