
<?php

   require_once('../../../functions.php');

   $connect = connect();

   $state_id = $_POST['state_id'];

   $html = "";
  
   if($cities = getWhere('tbl_city','state_id',$state_id)){
	
	   foreach($cities as $rs){

	   		$html .= "<option value='".$rs['city_id']."'>".$rs['city_name']."</option>";

	   }
   	
   }

   echo json_encode($html);


?>