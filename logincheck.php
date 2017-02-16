<?php
    
//-----------------------------------------------------------------------------
// INNAN MAN ÄR INLOGGAD
//-----------------------------------------------------------------------------
session_start();
$_SESSION['loggedin'] = FALSE;

//-----------------------------------------------------------------------------
// STARTA LOGINPROCESS
//-----------------------------------------------------------------------------

  if(isset($_POST["login"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
     
      require "dbconnect.php";
     

      $email = $_POST["email"];
      $password = $_POST["password"];

      $stmt = $conn->stmt_init();

      $sql = "SELECT * FROM users WHERE email = '{$email}'";

      $stmt->prepare($sql);

      $stmt->execute();
      $stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypt_password);
      $stmt->fetch();

      if(password_verify($password, $encrypt_password)) {
          header('Location: index.php');

//-----------------------------------------------------------------------------
// STARTA SESSION
//-----------------------------------------------------------------------------
          
          $_SESSION['loggedin'] = TRUE;
          $_SESSION['user_id'] = $user_id;
          $_SESSION['email'] = $email;
          $_SESSION['firstname'] = $firstname;
          $_SESSION['lastname'] = $lastname;

          
      }else {
        $_SESSION['msg'] = "Ingen användare hittades";
          header('Location: login.php'); 
      }

    }else {
      $_SESSION['msg'] = "Email eller lösenord är inte ifyllt";
     header('Location: login.php');

    }

?>