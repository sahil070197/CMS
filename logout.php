<?php
require_once("includes/functions.php");
// Four steps to log_out
//1. identify the session
session_start();
//2. unset all values;
$_SESSION=array();
//3. destroy the session cookie
if(isset($_COOKIE[session_name()]))
{
	setcookie(session_name(),'',time()-42000,'/');
}
//4. Destroy session
session_destroy();
redirect_to("login.php?logout=1");
?>