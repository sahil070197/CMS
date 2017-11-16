<?php
include("includes/session.php");
check_login();
require_once("includes/db_connect.php");
require_once("includes/functions.php");
get_method();
$message=null;
if(intval($_GET['subj'])==0)
{
	redirect_to("contents.php");
}
if(isset($_POST['submit']))

{
	if(isset($_POST['menu_name']) && !empty($_POST['menu_name']) && isset($_POST['visible']))
	{
		$updated_menu_name=mysqli_prep($_POST['menu_name']);
		$updated_position=mysqli_prep($_POST['position']);
		$updated_visible=mysqli_prep($_POST['visible']);
		
		if(!mysqli_query($connection,$query))
		{
			die("Error: ".mysqli_error($connection)); 
		}
	}
	else
	{
		$message="Incomplete entries found. No changes submitted.";
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
		<h2>
		
		Edit Subject : <?php
		$subject_row=get_subject_by_id($sel_subj);
		 echo $subject_row['menu_name'];
		 ?></h2>
		<form action="edit_subject.php?subj=
		<?php
			echo urlencode($subject_row['id']);
		?>
		" method="post">
<p>Subject Name: <input type="text" name="menu_name" value="<?php
			echo $subject_row['menu_name'];
			?>" id="menu_name" size='30'/></p>
			<p>Position:
			<select name="position" value="">
			<?php
			 $subject_set=get_all_subjects();
			 $subject_count=mysqli_num_rows($subject_set);
			 for($count=1;$count<=$subject_count+1;$count++)
			 {

			 	echo "<option value=\" {$count}\"";
			 	if($subject_row['position']==$count)
			 	{
			 		echo " selected ";
			 	}



			 	 echo ">{$count}</option>";
			 }
			?>
			</select></p>
			<p>
			Visible: 
			<input type="radio" name="visible" value="0"
			<?php if($subject_row['visible']==0) echo "checked";  ?>
			/>No
			&nbsp;
			<input type="radio" name="visible" value="1"
			<?php if($subject_row['visible']==1) echo "checked";  ?>/>Yes
			</p>
			<input type="submit" name="submit" value="Edit Subject"></input>
			&nbsp;
			<a href="delete_subject.php?subj=
		<?php
			echo urlencode($subject_row['id']);
		?>
		" method="post" onClick=" return confirm('Are you Sure '); "><u>Delete this subject</u></a>

		</form>
		<br/>
		<a href="contents.php">Cancel</a>

		<p>
		<?php
		if(isset($message))
			echo "{$message}"."<br/>";
		?> </h2></p>
		<p><hr width="100%" color="black"/></p>
		<p>
		<h2 color="red">
		
		<?php 
		$query="Select * from pages where subject_id = {$sel_subj}; ";
		$result=mysqli_query($connection,$query);
		if($result)
		{
			if(!mysqli_num_rows($result))
			{
				echo "Currently no pages exist.";
			}
			else
			{		
				echo "Pages under the subject ".$subject_row['menu_name']." are:<br/><br/><br/>";
				while($page_row_set=mysqli_fetch_assoc($result))
				{
					echo "<a href=\"edit_page.php?page=".$page_row_set['id']."\">".$page_row_set['menu_name']."</a><br/><br/>";
				}
			}
		}
		else
		{
			echo mysqli_error($connection);
		}
		?>


		</h2>
		</p>
		<p>
			<a href="add_new_page.php?subj=
			<?php
				echo urlencode($sel_subj);
			?>


			">+ Click here to add a new page</a>
		</p>
		</td>
		</tr>
		
		</table>

<?php
include("includes/footer.php");
include("includes/db_close.php");
?>