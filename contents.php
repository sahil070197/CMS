<?php
include("includes/session.php");
check_login();
require_once("includes/db_connect.php");
require_once("includes/functions.php");
$sel_subj;
$sel_page;
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
		<b><a href="new_subject.php">+ Add a new subject</a></b>
		</ul>
		</td>
		<td id="page">
	
		<?php
		if(isset($sel_page))
		{
			$page_res=get_page_by_id($sel_page);
			echo "<h2>".$page_res["menu_name"]."</h2>";
			echo "<p>".$page_res["content"]."</p>";
			echo "<a href=\" edit_page.php?page=".
			urlencode($page_res['id'])."
			\">Click here to edit this page.</a>";
		}
		else
		{
			echo "<h2>Select a subject or page to edit</h2>


			";
		}
		?>
		</td>
		</tr>

		</table>
<?php
include("includes/footer.php");
include("includes/db_close.php");
?>