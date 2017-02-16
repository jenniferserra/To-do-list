<?php
//-----------------------------------------------------------------------------
// MIN DATABASUPPKOPPLING
//-----------------------------------------------------------------------------
 
/* detta är för lokal åtkomst
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "todo_list");
*/


//för binero
define("DB_HOST", "todo-list-221747.mysql.binero.se");
define("DB_USER", "221747_ky65756");
define("DB_PASS", "Examen2018");
define("DB_NAME", "221747-todo-list");

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//För att få språket till utf8
if (!$conn->set_charset("utf8")) {

exit();
} 

?>