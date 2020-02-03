<?php 
	
	 require_once('../../../functions.php');

	 $id = $_POST['id'];

	 $update = "UPDATE employee_applied_leaves SET approve_status = '1' WHERE id = '".$id."' ";
	 
	 if(query($update)){
	 	$status = 1;
	 	$msg = "Leave Approved successfully";
	 }else{
	 	$status = 0;
	 	$msg = "failed to approve leave";
	 }

	 $data = array('status'=>$status,'msg'=>$msg);
	 echo json_encode($data);

?>