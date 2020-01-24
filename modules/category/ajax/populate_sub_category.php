<?php 

	require_once('../../../functions.php');

	$sub_category_level = $_POST['sub_category_level'];
	$parent_category_id = $_POST['parent_category_id'];

	$get = "SELECT * FROM tbl_sub_category WHERE parent_category_id = '$parent_category_id' AND sub_category_level = '$sub_category_level' ";

	$get = getRaw($get);

	$html = "<option> --Choose Category-- </option>";

	foreach($get as $rs){

			$html .= "<option value='".$rs['sub_category_id']."'>".$rs['sub_category_name']."</option>";
	}	

	$data = array('sub_category_level' => $sub_category_level, 'html' => $html);

	echo json_encode($data);

?>