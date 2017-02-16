<?php 

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE ) {
//-----------------------------------------------------------------------------
// OM MAN ÄR INLOGGAD
//-----------------------------------------------------------------------------
	$user_id = $_SESSION["user_id"];
	$firstname = $_SESSION["firstname"];
    $lastname = $_SESSION["lastname"];


	include "header.php";

	if($conn->connect_errno){
	echo "connection to database failed";
	die();
} 


	$stmt = $conn->stmt_init(); 

		if($stmt->prepare("SELECT * FROM users")) { 
			$stmt->execute();
			$stmt->bind_result($user_id, $firstname, $lastname, $email, $encrypted_password); 
			$stmt->fetch();
		}		
			echo '<div class="welcome"> Hej '. $_SESSION["firstname"] .' '. $_SESSION["lastname"] .'!<br> It\'s todo o\'clock! </div>';	

	?>

			<form action="tasks.php">
   				 <input type="submit" class="go-to-list-button" value="Gå till mina uppgifter">
   			</form>
		
</body>
</html>

<?php

}else {
//-----------------------------------------------------------------------------
// OM MAN INTE ÄR INLOGGAD
//-----------------------------------------------------------------------------
	echo "Du är inte inloggad";
	echo "<br><a href='login.php'>Logga in</a>";
}

?>