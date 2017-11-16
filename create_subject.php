<?php
include("includes/session.php");
check_login();
require_once("includes/db_connect.php");
require_once("includes/functions.php");
?>
<?php
	$prone_fields=array('menu_name','position','visible');
	$errors=array();
	foreach ($prone_fields as $field_name) {
		if(!isset($_POST[$field_name]) || empty($_POST[$field_name ]) )
		{
			$errors[]=$field_name;
		}
	}
	if(!empty($errors))
	{
		redirect_to("new_subject.php");
	}
?>
<?php
	$menu_name=mysqli_prep($_POST['menu_name']);
	$position=mysqli_prep($_POST['position']);
	$visible=mysqli_prep($_POST['visible']);
	
?>
<?php
	$query="Insert into subjects(menu_name,position,visible) VALUES('{$menu_name}', '{$position}', '{$visible}') ; ";
	if(!mysqli_query($connection,$query))
	{ 
		die("Insertion Failed: ".mysqli_error($connection));
	}
	else
	{
		redirect_to("contents.php");
	}
?>
<?php
	include("includes/db_close.php");
?>