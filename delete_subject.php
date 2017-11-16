<?php
include("includes/session.php");
check_login();
	require_once("includes/db_connect.php");
	require_once("includes/functions.php");
	if(intval($_GET['subj']==0))
	{
		redirect_to("contents.php");
	}
	$delete=$_GET['subj'];
	
	$query="DELETE FROM `subjects` WHERE `subjects`.`id` = {$delete} ";
	$result=mysqli_query($connection,$query);
	if(!$result)
		{
		die("error occured: ".mysqli_error($connection));
	}
	redirect_to("contents.php");
?>
