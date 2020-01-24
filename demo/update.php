<?php
//update.php
$connect = mysqli_connect("localhost", "root", "", "agricon");
//$page_id = $_POST["page_id_array"];
for($i=0; $i<count($_POST["page_id_array"]); $i++)
{
 $query = "
 UPDATE page 
 SET page_order = '".$i."' 
 WHERE page_id = '".$_POST["page_id_array"][$i]."'";
 mysqli_query($connect, $query);
}
echo 'Page Order has been updated'; 

?>