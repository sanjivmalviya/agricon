<?php

	require_once('../functions.php');

	$notification_receiver_user_type = $_POST['user_type'];
	$notification_receiver_user_id = $_POST['user_id'];

	$update = "UPDATE tbl_notifications SET notification_status = '1' WHERE notification_receiver_user_type = '$notification_receiver_user_type' AND notification_receiver_user_id ='$notification_receiver_user_id' ";
	if(query($update)){
		 $status = 1;
	}else{
		 $status = 0;
	}

	echo json_encode($status);

?>