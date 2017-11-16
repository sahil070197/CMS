<?php
include("includes/session.php");
check_login();
include("includes/header.php");
require_once("includes/functions.php");
?>
	<table id="structure">
		<tr>
		<td id="navigation">
			&nbsp;
		</td>
		<td id="page">
			<h2>Staff Menu</h2>
		
		<p>Welcome to staff area <?php echo $_SESSION['username'];?></p>
		<ul>
		<li><a href="contents.php">Manage Website Contents</a></li>
		<li><a href="new_user.php">Add Staff User</a></li>
		<li><a href="logout.php">Logout</a></li>
		</ul>
		</td>
		</tr>
		</table>
<?php
include("includes/footer.php");
?>