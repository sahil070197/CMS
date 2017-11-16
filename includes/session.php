<?php
require_once("includes/functions.php");
session_start();
function logged_in()
{
	return isset($_SESSION['user_id']);
}
function check_login()
{
	if(!logged_in())
	{
		redirect_to("login.php"); 
	}
}
?>