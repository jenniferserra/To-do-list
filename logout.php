<?php
	
//-----------------------------------------------------------------------------
// NÄR ANVÄNDAREN LOGGAR UT: AVSLUTA SESSION
//-----------------------------------------------------------------------------

session_start();
session_destroy();

header('Location: login.php?loggedout=true');

?>