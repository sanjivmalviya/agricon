<?php 

	require_once('../../../functions.php');
	
	$category_name = $_POST['category_name'];
	$parent_category_id = $_POST['parent_category_id'];
	$type = $_POST['type'];

	$form_data = array(
		'sub_category_name'=> $category_name,
		'sub_category_level'=> $type,
		'parent_category_id'=> $parent_category_id
	);

	if(isExists('tbl_sub_category','sub_category_name',$category_name)){
		
		$msg = "Category already exists";

	}else{
		
		if(insert('tbl_sub_category',$form_data)){
			$msg = "Category Added";
		}else{
			$msg = "Failed to add Category, try again later";
		}

	}

	echo json_encode($msg);


?>