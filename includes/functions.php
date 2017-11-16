<?php
function mysqli_prep($value)
{
		global $connection;
	$magic_quotes_active=get_magic_quotes_gpc();
	$new_enough_php=function_exists("mysqli_real_escape_string");
	if($new_enough_php)
	{
	// PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if($magic_quotes_active)
			{
				$value=stripslashes($value);
			}
			//additional connection identifier needs to be soecified int the following statement, not as per the tutorials;
			$value=mysqli_real_escape_string($connection,$value);	
	}
	else
	{
		// before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
		if(!$magic_quotes_active)
		{
			$value=addslashes($value);
		}
	}
	return $value;
}
function check_query($connection)
{
	die("Error occured: ".mysqli_error($connection));
}


function get_all_subjects()
{
	global $connection;
	$sql_subjects="Select *
		 				from subjects 
		 				order by position asc;";
		$result_subject=mysqli_query($connection,$sql_subjects);
		if(!$result_subject)
		{
			check_query($connection);
		}
		return $result_subject;	
}
function get_all_pages($row_subjects)
{
	global $connection;
	$sql_pages="Select * from pages where subject_id = {$row_subjects["id"]} order by position asc;";
			$result_pages=mysqli_query($connection,$sql_pages);
			if(!$result_pages)
			{
				check_query($connection);
			}
			return $result_pages;
}
function get_subject_by_id($subject_id)
{
	global $connection;
	$query="select * from subjects where id=".$subject_id.";";
	$result=mysqli_query($connection,$query);
	if(!$result)
	{
		die("error here: ".mysqli_error($connection));
	}
	//if no rows are returnred the next statement would be false; 
	if($row_subjects=mysqli_fetch_assoc($result))
	{ 
		return $row_subjects;
	}
	else
	{
		return null;
	}

}
function get_page_by_id($subject_id)
{
	global $connection;
	$query="select * from pages where id=".$subject_id.";";
	$result=mysqli_query($connection,$query);
	if(!$result)
	{
		check_query($connection);
	}
	// if no rows are returnred the next statement would be false; 
	if($row_page=mysqli_fetch_assoc($result))
	{
	 return $row_page;
	}
	else
	{
		return null;
	}

}


function get_method()
{
	global $sel_page;
	global $sel_subj; 
	if(isset($_GET['subj']))
{
	$sel_subj= $_GET["subj"];
	$sel_page=null;
}
elseif (isset($_GET["page"])) {
	$sel_page= $_GET["page"];
	$sel_subj=null;
}
 else{
$sel_subj=null;
	$sel_page=null;
}
include("includes/header.php");
}



function redirect_to($value = NULL)
{
	if($value!=NULL)
	{
		header("Location: {$value}");
		exit();
	}
}
?>