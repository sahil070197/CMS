<?php	
$result_subject=get_all_subjects();	
while ($row_subjects=mysqli_fetch_assoc($result_subject))
 {
echo "<li";
if($row_subjects["id"] == $sel_subj)
   {   echo " class=\"selected\"";
}
  	  echo "><a href=\"edit_subject.php?subj=".urlencode($row_subjects["id"])."\">".$row_subjects["menu_name"]."</a></li>";
echo "<ul class=\"pages\">";
$result_pages=get_all_pages($row_subjects);
while ($row_pages=mysqli_fetch_assoc($result_pages))	  
{
echo "<li";
	if($row_pages['id']==$sel_page)
	{

	  echo " class=\"selected\"";
	}
	  echo "><a href=\"contents.php?page=".urlencode($row_pages["id"])."\">{$row_pages['menu_name']}</a></li>";
 }
 ?>

 <?php	
echo "</ul>";
}
?>
