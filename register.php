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
      <div class="registerpage">

<!-- *******************************************************************************************************************************
SESSION MSG HÄMTAR MEDDELANDE FRÅN LOGINCHECK.PHP OCH TALAR OM IFALL LÖSENORD/EMAIL SAKNAS ELLER OM ANVÄNDAREN SOM FÖRSÖKER LOGGA IN INTE FINNS
************************************************************************************************************************************ -->

  <?php if (isset( $_SESSION['msg'])) { echo $_SESSION['msg']; unset($_SESSION['msg']); } ?>


       <!-- REGISTRERA ANVÄNDARE -->

          <div class="register-box"> 
              <form method="post">
                <h1>Bra beslut kompis! <br> Registrera dig nedan.</h1>
                <input type="text" name="firstname" placeholder="Förnamn"><br>
                <input type="text" name="lastname" placeholder="Efternamn"><br>
                <input type="email" name="email" placeholder="E-post"><br>
                <input type="password" name="password" placeholder="Lösenord"><br>
                <input name="register" class="button" type="submit" value="Registrera"><br>
                <span class="loginlinks">Har du redan ett konto? <a href="login.php">Logga in</a></span>
              </form>
          </div>
          
          <?php 
         
          regUser(); 


          ?>

      </div>
    </body>
</html>
