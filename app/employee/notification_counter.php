
<?php

  require_once('../../functions.php');   
  $request = json_decode(file_get_contents('php://input'));

  if(isset($request->employee_id)){

    $employee_id = $request->employee_id;
    $condition = "notification_receiver_user_type = '4' AND notification_receiver_user_id = '$employee_id' AND notification_status = '0' ";
    $notification_counter = getCountWhere('tbl_notifications',$condition);

  	$json = array('status'=>1,'message'=>'Data found','counter'=>$notification_counter);
    
  }else{

    $json = array('status'=>0,'message'=>'Invalid Request');

  }

 echo json_encode($json);
   