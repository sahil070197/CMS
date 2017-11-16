<?php
include("includes/session.php");
check_login();
require_once("includes/db_connect.php");
require_once("includes/functions.php");
get_method();
?>
	<table id="structure">
		<tr>
		<td id="navigation">
		<ul type="subjects">
		<?php	
			include("includes/navigation_menu.php");
		?>
		<br/>
		</ul>
		</td>
		<td id="page">
		<h2> Add Subject</h2>
		<form action="create_subject.php" method="post">
			<p>Subject Name: <input type="text" name="menu_name" value="" id="menu_name"/></p>
			<p>Position:
			<select name="position">
			<?php
			 $subject_set=get_all_subjects();
			 $subject_count=mysqli_num_rows($subject_set);
			 for($count=1;$count<=$subject_count+1;$count++)
			 {
			 	echo "<option value=\" {$count} \">{$count}</option>";
			 }

			?>
			</select></p>
			<p>
			Visible: 
			<input type="radio" name="visible" value="0"/>No
			&nbsp;
			<input type="radio" name="visible" value="1"/>Yes
			</p>
			<input type="submit" value="Add Subject"></input>

		</form>
		<br/>
		<a href="contents.php">Cancel</a>
		</td>
		</tr>
		</table>
<?php
include("includes/footer.php");
include("includes/db_close.php");
?>