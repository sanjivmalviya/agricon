<?php 

	require_once('../../../functions.php');
	
	$category_name = $_POST['category_name'];

	$form_data = array(
		'category_name'=> $category_name
	);

	if(isExists('tbl_category','category_name',$category_name)){
		$msg = "Category already exists";
	}else{
		
		if(insert('tbl_category',$form_data)){
			$msg = "Category Added";
		}else{
			$msg = "Failed to add Category, try again later";
		}

	}

	echo json_encode($msg);

?>