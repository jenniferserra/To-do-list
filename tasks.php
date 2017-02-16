<?php 

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == TRUE ) {
//-----------------------------------------------------------------------------
// OM INLOGGAD
//-----------------------------------------------------------------------------
	$user_id = $_SESSION["user_id"];
	$firstname = $_SESSION["firstname"];
    $lastname = $_SESSION["lastname"];


	include "header.php";

	include "addtask.php";

	include "functions.php";

	if($conn->connect_errno){
	echo "connection to database failed";
	die();
} 

	?>

	<div class="sortList">
		<p>Sortera:
			<a href="tasks.php?sort=name">Namn</a> |
			<a href="tasks.php?sort=asc">Prioritet stigande</a> |
			<a href="tasks.php?sort=desc">Prioritet fallande</a> |
			<a href="tasks.php?sort=done">Klara</a> |
			<a href="tasks.php?sort=none">Original</a> |
		</p>
	</div>

<?php

	

	$stmt = $conn->stmt_init(); 
		if($stmt->prepare("SELECT * FROM tasks WHERE user_id = '".$user_id."' " . sortList() )) { 
			$stmt->execute();
			$stmt->bind_result($task_id, $title, $description, $priority, $complete, $image, $deadline, $user_id);
			
			//detta gör tiden till ett format som man kan räkna med
			$deadlinetimestamp = strtotime($deadline);
			$today = date("N");
			$now = time();

			while ($stmt->fetch()) {
				 
				if($priority == 1) { 
					$priorityclass = 'prio1'; 
				} //om uppgiften har prio 1 har den fått css-klassen prio1
				elseif ($priority == 2) {
					$priorityclass = 'prio2';
				} // om uppgiften har prio 2 har den fått css-klassen prio2
				else {
					$priorityclass = 'prio3'; 
				} // om den varken har prio 1 eller 2 har den klassen prio3


				//lite konstiga formatteringsregler för vad som ska hända med uppgiftens titel beroende på olika faktorer
				if($deadlinetimestamp == $now && $priority == 3) {
					$feedback = strtoupper($title); //om deadline är idag och uppgiften har prio 3 så får uppgiftens titel textformateringen versaler
				} else if ($deadlinetimestamp == $now || $priority == 2) {
					$feedback = '<i>'. $title . '</i>'; //om deadline är idag eller uppgiften har prio 2 så får uppgiftens titel textformateringen kursiv
				} else if($deadlinetimestamp !== $now && $priority == 3)  {
					$feedback = '<b>' . $title . '</b>';
					 //om deadline INTE är idag OCH uppgiftens prio är 3 så får uppgiftens titel fetstil
				} else if ($deadlinetimestamp > $now) {
					$feedback = '<u>' . $title . '</u>'; //om deadline är i framtiden så får uppgiften textformateringen underline
				} else {
					$feedback = $title; //om inget ovan uppfylls skrivs uppgiftens titel ut som vanligt
				}

					$class = "";
					if($complete == 1){
						$class = "done";
					}
					?>
					
				<div class="task">
					<div class="title <?php echo $class; ?>"><?php echo $feedback; ?></div>
					<div class="description"><?php echo $description; ?></div>
					<div class="priority <?php echo $priorityclass; ?>"><?php echo "Prioritet: " . $priority; ?></div>
					<div class="deadline"><?php echo "Deadline: ". $deadline; ?></div>
					
					<?php 
					$url = "taskimage/task-image-$task_id.jpg";
					if(file_exists($url)){
						?><img src="taskimage/task-image-<?php echo $task_id ?>.jpg" class="taskimage"><br>

					<?php }
					?>
					<a href="tasks.php?delete=<?php echo $task_id; ?>" class="delete-done-link">Radera</a>
					<a href="tasks.php?complete=<?php echo $task_id?>" class="delete-done-link">Klar</a>
				
				</div>
			<?php
			} 
		}	
	?>
		
</body>
</html>

<?php

}	else {
//-----------------------------------------------------------------------------
// OM UTLOGGAD
//-----------------------------------------------------------------------------
	echo "Du är inte inloggad";
	echo "<br><a href='login.php'>Logga in</a>";
}

?>

