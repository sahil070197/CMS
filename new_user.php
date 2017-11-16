<?php
include("includes/session.php");
check_login();
require_once("includes/db_connect.php");
require_once("includes/functions.php");
get_method();
$messgae=null;
	$error=array();
if(isset($_POST['submit']))
{
	$username=mysqli_prep($_POST['username']);
	$password=mysqli_prep($_POST['password']);
	if(!isset($username)||empty($username))
	{
		$error[] = 'Invalid username';
	}
	if(!isset($password)||empty($password)||strlen($password)<8)
	{

		if(strlen($password)<8)
		{
			$error[]='Password should be minimum 8 characters long';
		}
		else
		{
			$error[]='password cannot be empty!';
		}
	}
	if(empty($error))
	{
		$hashed_password=sha1($password);
		$query="Insert into users ( username, hashed_password) values ('{$username}', '{$hashed_password}');";
		$result=mysqli_query($connection,$query);
		if($result)
		{
			redirect_to("staff.php");
		}
		else
		{
			$messgae="Error occured: Duplicate entries found."; 
		}

	}
	
}


?>


	<table id="structure">
		<tr>
		<td id="navigation">
		<ul type="subjects">
		<?php include("includes/navigation_menu.php");
		?></ul>	
		<ul>
		<b><a href="new_subject.php">+ Add a new subject</a>
		</b></ul>
		</ul>
		</td>
		<td id="page">
		<form action="new_user.php" method="post">
<p>User Name: <input type="text" name="username" value="" id="username " size='30' maxlength="30" /></p>
<p>Password:&nbsp;&nbsp; <input type="password" name="password"  size='30' maxlength="30" /></p>
			
			
			<input type="submit" name="submit" value="Add User"></input>
			&nbsp;
			
		</form>
		<br/>
		<p><a href="staff.php">Cancel</a></p>
		<p><?php 
		echo $messgae;
		foreach ($error as $i) {
		 echo $i."<br/>";
		 } ?></p>
		
		</td>
		</tr>
		
		</table>

<?php
include("includes/footer.php");
include("includes/db_close.php");
?>