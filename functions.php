<?php

// ----------------------------------------------------------
// FUNKTIONEN FÖR ATT REGISTRERA EN ANVÄNDARE
// ----------------------------------------------------------
function regUser() {

	if(isset($_POST["register"])) {

		if(	!empty($_POST["firstname"]) &&
			!empty($_POST["lastname"]) &&
			!empty($_POST["email"]) &&
			!empty($_POST["password"])
			) {
			
			require "dbconnect.php";
			
			$firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
			$lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
			$email = mysqli_real_escape_string($conn, $_POST["email"]);
			$password = mysqli_real_escape_string($conn, $_POST["password"]);

			$encrypt_pass = password_hash($password, PASSWORD_DEFAULT); //krypterar lösenordet

			
			$query = "INSERT INTO users VALUES (
			NULL, /* för att user_id ska skapas per automatik */
			'$firstname',
			'$lastname',
			'$email',
			'$encrypt_pass'
			)"; 

			mysqli_query($conn, $query);

			$_SESSION['msg'] = "Du är nu registrerad!"; //meddelande som visas på login.php när användaren registrerats på register.php
			header('Location: login.php'); 
			
		}
	}
}

/* *************************************************************
* FUNKTIONEN FÖR ATT KUNNA SORTERA SIN TODO-LIST
*************************************************************** */

function sortList() {

	$query = "";

	$sort = "";
	if(isset($_GET["sort"])) { //undvik felmeddelande
		$sort = $_GET["sort"]; //om man klickat på någonting, så sortera på det
	}

	if($sort == "name"){
		$query = " ORDER BY title";

	} else if ($sort == "asc"){
		$query = " ORDER BY priority ASC";

	} else if ($sort == "desc"){
		$query = " ORDER BY priority DESC";

	} else if ($sort == "done"){
		$query = " ORDER BY complete";

	}

	return $query;
	}


?>
