<?php
include("includes/session.php");
check_login();
require_once("includes/db_connect.php");
require_once("includes/functions.php");
get_method();
if($sel_page==null)
{
	redirect_to("contents.php");
}
$error_message=null;
$error_prone_fields=array('menu_name','content');
$errors=array();
if(isset($_POST['submit']))
{
	foreach ($error_prone_fields as $i) {
		if(!isset($_POST[$i]) || empty($_POST[$i]))
		{
			$errors[]=$i;
		}
		if(empty($errors))
		{
			$updated_page_name=mysqli_prep($_POST['menu_name']);
			$updated_position=mysqli_prep($_POST['position']);
			$updated_subject_id=mysqli_prep($_POST['subject_id']);
			$updated_visible=mysqli_prep($_POST['visible']);
			$updated_content=mysqli_prep(	$_POST['content']);
			$query=" UPDATE `pages` SET `subject_id` = '{$updated_subject_id}', `menu_name` = '{$updated_page_name}', `position` = '{$updated_position}', `visible` = '{$updated_visible}', `content` = '{$updated_content}' WHERE `pages`.`id` = {$sel_page}";
			if(!mysqli_query($connection,$query))
			{
				$error_message="Error in mysql query: ".mysqli_query($connection);
			}
		}
		else
		{
				$error_message="Incomplete entries found at";
		}
	}
}
?>
<table id="structure">
		<tr>
		<td id="navigation">
		<ul type="subjects">
		<?php	
			include("includes/navigation_menu.php");
			$page_row=get_page_by_id($sel_page);
		?>
		<br/>
		</ul>
		</td>
		<td id="page">
		<h2>Edit Page: <?php
		echo $page_row['menu_name'];
		?></h2>

		<form action="edit_page.php?page=
		<?php
		echo urlencode($page_row['id']);
		?>
" method="post" id="form1">
			<p>Page Name:&nbsp;
			&nbsp; <input type="text" name="menu_name" value="<?php
			echo $page_row['menu_name'];
			?>" id="menu_name"/></p>
			<p>Position under subject:
			<select name="position">
			<?php
			 $subject_id=$page_row['subject_id'];
			 $query="select * from pages where subject_id='{$subject_id}'";
			 $result=mysqli_query($connection,$query);
			 $page_count=mysqli_num_rows($result);
			 for($count=1;$count<=$page_count;$count++)
			 {
			 	echo "<option value=\" {$count} \"";
			 	if($page_row['position']==$count)
			 	{
			 		echo " selected";
			 	}
			 	echo ">{$count}</option>";
			 }

			?>
			</select></p>
			<p>Subject ID: <select name="subject_id">
			<?php $subject_set=get_all_subjects();
			$total_subjects=mysqli_num_rows($subject_set);
			for($count=1;$count<=$total_subjects;$count++)
			{
				echo "<option value=\"{$count}\"";
				if($count==$page_row['subject_id'])
					echo " selected";
				echo ">{$count}</option>";
			}
			?>
				
			</select></p>
			<p>
			Visible:
			<input type="radio" name="visible" value="0"
			<?php if($page_row['visible']==0) echo "checked";  ?>/>No
			&nbsp;
			<input type="radio" name="visible" value="1" <?php if($page_row['visible']==1) echo "checked";?>/>Yes
			</p>
			<p>
		Content: <br/><textarea rows="20" cols="80" form="form1" value="" name="content"><?php
		echo $page_row['content'];
		?></textarea>
		</p>
			<input type="submit" name="submit" value="Edit Page" onclick="return confirm('Sure to make these changes');"></input>
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