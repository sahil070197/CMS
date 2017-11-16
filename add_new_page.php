<?php
include("includes/session.php");
check_login();
require_once("includes/db_connect.php");
require_once("includes/functions.php");
get_method();
if($sel_subj==null)
{
	redirect_to("contents.php");
}
$error_message=null;
$error_prone_fields=array('menu_name','explain');
$errors=array();
if(isset($_POST['add_submit']))
{
if(!isset($_POST['visible']))
{
	$errors[]='visible';
}

	foreach ($error_prone_fields as $i) {
		if(!isset($_POST[$i]) || empty($_POST[$i]))
		{
			$errors[]=$i;
		}
	}
		if(empty($errors))
		{
			$updated_page_name=mysqli_prep($_POST['menu_name']);
			$updated_position=mysqli_prep($_POST['position']);
			$updated_subject_id=mysqli_prep($_POST['subject_id']);
			$updated_visible=mysqli_prep($_POST['visible']);
			$updated_content=mysqli_prep($_POST['explain']);
			$query=" Insert into pages(subject_id, menu_name, position, visible, content)  Values ('{$updated_subject_id}','{$updated_page_name}', '{$updated_position}', '{$updated_visible}',  '{$updated_content}')";
			if(!mysqli_query($connection,$query))
			{
				$error_message="Error in mysql query: ".mysqli_query($connection);
				die();
			}
			$last_insert=mysqli_insert_id($connection);
			 redirect_to("edit_page.php?page=".$last_insert);
		}
		else
		{
				$error_message="Incomplete entries found at";
		}
	
}
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
		<h2>Add Page:</h2>

		<form action="add_new_page.php?subj=
		<?php
		echo urlencode($sel_subj);
		?>
" method="post" id="form2">
			<p>Page Name:&nbsp;
			&nbsp; <input type="text" name="menu_name" value="" id="menu_name"/></p>
			<p>Position under subject:
			<select name="position">
			<?php
			 $query="select * from pages where subject_id='{$sel_subj}'";
			 $result=mysqli_query($connection,$query);
			 $page_count=mysqli_num_rows($result);
			 for($count=1;$count<=$page_count+1;$count++)
			 {
			 	echo "<option value=\"{$count}\">{$count}</option>";
			 }
			?>
			</select></p>
			<p>Subject ID: <select name="subject_id">
			<?php $subject_set=get_all_subjects();
			$total_subjects=mysqli_num_rows($subject_set);
			for($count=1;$count<=$total_subjects;$count++)
			{
				echo "<option value=\"{$count}\">{$count}</option>";
			}
			?>
				
			</select></p>
			<p>
			Visible:
			<input type="radio" name="visible" value="0"?/>No
			&nbsp;
			<input type="radio" name="visible" value="1"/>Yes
			</p>
			<p>
		Content: <br/><textarea rows="20" cols="80" value="" name="explain"></textarea>
		</p>
			<input type="submit" name="add_submit" value="Add Page" onclick="return confirm('Sure to add this page?');"></input>
		<p>
		<?php
		if(isset($error_message))
		{
			echo "<h2>".$error_message."</h2>";
			foreach($errors as $error)
			{
				if($error=='menu_name')
				{
					$error='Page Name';
				}
				echo "<h2>-".$error."</h2><br/>";
			}
		}
		?>
		</p>
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