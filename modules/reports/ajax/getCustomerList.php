<?php 

	require_once('../../../functions.php');
	
	$id = $_POST['id'];

	$customers = getWhere('tbl_customer','party_handled_by',$id);

	$html = "";

	if(isset($customers)){

		foreach($customers as $rs){
			$html .= "<option value='".$rs['customer_id']."'>".$rs['customer_name']."</option>";
		}

	}

	echo $html;

?>