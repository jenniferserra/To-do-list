<?php

$stmt = $conn->stmt_init(); 
if($stmt->prepare("SELECT * FROM tasks WHERE user_id = '".$user_id."'")) { 
	$stmt->execute();
	$stmt->bind_result($task_id, $title, $description, $priority, $complete, $image, $deadline, $user_id);



?>
<!-- *******************************************************
FORMULÄR FÖR ATT LÄGGA TILL UPPGIFTER 
************************************************************-->
<form method="post" action="tasks.php" class="addtasks" enctype="multipart/form-data">
	<h2>Lägg till nya uppgifter här:</h2>
	<input type="text" name="title" placeholder="Titel"><br>
	<input type="text" name="description" placeholder="Beskrivning"><br>
	<input type="date" name="deadline"><br>
	<select name="priority">
		<option value="0">Välj prioritet</option>
		<option value="1">Prio 1: Viktigt</option>
		<option value="2">Prio 2: Ganska viktigt</option>
		<option value="3">Prio 3: Helvete vad viktigt</option>
	</select>
	<h3>Välj en bild till uppgiften:</h3>
    <input type="file" name="fileToUpload" id="fileToUpload"><br>
	<input type="submit" name="addtask" value="Lägg till" class="add-task-button">
</form>

<?php

/*
___________________________________________________________________________________________

**PHP-KODEN FÖR ATT LÄGGA TILL UPPPGIFTER**

* 1: Om användaren tryckt på addtask så ska uppgifterna in i databasen
___________________________________________________________________________________________
*/

if (isset ($_POST["addtask"])) {

	$title = $_POST["title"];
	$description = $_POST["description"];
	$priority = $_POST["priority"];
	$deadline = $_POST["deadline"];
	
	$query = "INSERT INTO tasks VALUES ('','{$title}', '{$description}', '{$priority}', 0, '', '{$deadline}', '{$_SESSION["user_id"]}' )"; 

	if($stmt->prepare($query) ) {
		$stmt->execute();
		echo "<div class='message'>" . 'Uppgiften lades till' . "</div>";
	}


/*
___________________________________________________________________________________________

**Uppladdning av uppgiftsbild**

* 1: Användaren trycker på upload -> definiera vart bilderna ska laddas upp i $target_folder. Här används mappen som skapas genom registreringen
* 2: Ange att namnet på filen ska sparas som ska vara "task-image-task_id.jpg" i $target_folder
* 3: Kolla så att storleken på bilden är under 10MB, om så är fallet informeras användaren att välja en mindre bild
* 4: Kolla så att filen är en JPG eller JPEG, om så inte är fallet informeras användaren att välja en annan bild
* 5: Flytta bilden från dess temporära plats till användarens egna mapp

___________________________________________________________________________________________
*/


	$task_id = $conn->insert_id;

	$target_folder = "taskimage/";
	$target_name = $target_folder . basename ("task-image-".$task_id.".jpg");


	if ($_FILES["fileToUpload"]["size"] > 10000000) {
		echo "<div class='message'>" . 'Filen är för stor, den får max vara 10MB.' . "</div>";
		exit;
	}

	$type = pathinfo ($target_name, PATHINFO_EXTENSION);
	if($type !== 'jpg') {
		echo "<div class='message'>" . 'Du kan bara ladda upp JPEG-filer' . "</div>";
		exit;
	}

	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_name)) {


    $lastinsertID = mysql_insert_id();

    $query ="UPDATE tasks SET image ='{$target_name}' WHERE task_id = '{$lastinsertID}'";

    if ($stmt->prepare($query)) {
        $stmt->execute();
      echo "<div class='message'>" . 'Uppladdningen lyckades' . "</div>";
      header("Refresh:0");
    }
	}
}
?>


<?php

/* **********************************************************************
**PHP-KODEN FÖR ATT RADERA OCH MARKERA UPPGIFTER SOM KLARA**

* 1: Om användaren tryckt på delete eller complete så raderas uppgift i databasen / så ändras complete från 0 till 1 i databasen
***************************************************************************** */

	if(isset($_GET["delete"]) ) { //kolla om "delete" finns i tabellen
		$taskToDelete = $_GET["delete"];
		$query = "DELETE FROM tasks WHERE task_id = '{$taskToDelete}'";

		if($stmt->prepare($query) ) {
			$stmt->execute();
			echo "<div class='message'>" . 'Uppgiften raderades' . "</div>";
		}

	}

	if(isset($_GET["complete"]) ) {
		$idToComplete = $_GET["complete"];
		$query = "UPDATE tasks SET complete = 1 WHERE task_id = '{$idToComplete}'";

		if($stmt->prepare($query) ) {
			$stmt->execute();
			echo "<div class='message'>" . 'Uppgiften markerades som klar' . "</div>";
		}
	}

}
?>