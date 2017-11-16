
<?php
require_once("includes/session.php");
require_once("includes/db_connect.php");
require_once("includes/functions.php");
if(isset($_SESSION['user_id']))
{
	redirect_to("staff.php");
}
get_method();
$messgae=null;
	$error=array();
if(isset($_POST['submit']))
{
	$username=mysqli_prep($_POST['username']);
	$password=mysqli_prep($_POST['password']);
	if(!isset($username)||empty($username))
	{
		$error[] = 'Invalid Credentials';
	}
	if(!isset($password)||empty($password)||strlen($password)<8)
	{
		{
			$error[]='Invalid Credentials';
		}
	}
	if(empty($error))
	{
		$hashed_password=sha1($password);
		$query="Select id, username from users where username= '{$username}' and hashed_password='{$hashed_password}';";
		$result=mysqli_query($connection,$query);
		$row_count=mysqli_num_rows($result);
		if($row_count>=1)
		{
			$user_row=mysqli_fetch_assoc($result);
			$_SESSION['user_id']=$user_row['id'];
			$_SESSION['username']=$user_row['username'];
			redirect_to("staff.php");
		}
		else
		{
			$messgae="Invalid Credentials."; 
		}

	}
	
}
else
{
	if(isset($_GET['logout']) && $_GET['logout']==1)
	{
		$messgae="Logout Successful.";
	}
}


?>


	<table id="structure">
		<tr>
		<td id="navigation">	
		<ul>
		<b><a href="index.php">Return to home</a>
		</b></ul>
		</ul>
		</td>
		<td id="page">
		<form action="login.php" method="post">
<p>User Name: <input type="text" name="username" value="" id="username " size='30' maxlength="30" /></p>
<p>Password:&nbsp;&nbsp; <input type="password" name="password"  size='30' maxlength="30" /></p>
			
			
			<input type="submit" name="submit" value="Login"></input>
			&nbsp;
			
		</form>
		<br/>
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