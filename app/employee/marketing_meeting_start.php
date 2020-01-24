<?php

   require_once('../../functions.php');

   $request = json_decode(trim(file_get_contents('php://input')));

   $data = array();
   if(isset($request->meeting_with) && isset($request->routine_id) && isset($request->employee_id) && isset($request->latitude) && isset($request->longitude)){

      $check = "SELECT * FROM tbl_marketing_employee_routine_meeting WHERE  meeting_with = ".$request->meeting_with." AND routine_id = '".$request->routine_id."' AND employee_id = '".$request->employee_id."'  AND meeting_in LIKE '%".date('d-m-Y')."%' AND latitude = '".$request->latitude."' AND longitude = '".$request->longitude."' ";
      $check = getRaw($check);

      if(isset($check) && count($check) > 0){

         $status = 0;
         $message = "Meeting already started";

      }else{

         $form_data = array(
            'meeting_with' => $request->meeting_with, // 1-farmer, 2-customer
            'routine_id' => $request->routine_id,
            'employee_id' => $request->employee_id,
            'meeting_in' => date('d-m-Y H:i'),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
         );

         if(insert('tbl_marketing_employee_routine_meeting',$form_data)){

            $last_id = last_id('tbl_marketing_employee_routine_meeting','meeting_id');
            $status = 1;
            $message = 'you have successfully punched for meeting in';
            $data = array('meeting_id'=>$last_id);

         }else{

            $status = 0;
            $message = 'Failed to punch for meeting in, please try again later';

         }

      }

       

   }else{

      $status = 0;
      $message = 'Invalid request !';

   }

   $data = array('status' => $status, 'message' => $message,'data'=>$data);
   echo json_encode($data);
   
