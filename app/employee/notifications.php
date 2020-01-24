
<?php

   require_once('../../functions.php');
   
   $request = json_decode(file_get_contents('php://input'));

  
  if(isset($request->employee_id)){

    $employee_id = $request->employee_id;

    $where = array(
      'notification_receiver_user_type' => '4',
      'notification_receiver_user_id' => $employee_id,
      'notification_status' => 0
    );

    $notifications = selectWhereMultiple('tbl_notifications',$where);

    if(isset($notifications)){

		foreach ($notifications as $rs) {
			
			$setdata['title'] = $rs['notification_title'];
			$setdata['description'] = $rs['notification_description'];
			$setdata['created_at'] = time_ago($rs['created_at']);

			$data[] = $setdata; 

		}

    	$json = array('status'=>1,'message'=>'Data Found','data'=>$data);

    }else{

    	$json = array('status'=>0,'message'=>'No Data Found');

    }
  
  }else{

    $json = array('status'=>0,'message'=>'Invalid Request');

  }

 echo json_encode($json);
   