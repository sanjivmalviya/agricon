<?php

   require_once('../../functions.php');

   $request = json_decode(trim(file_get_contents('php://input')));

   $data = null;
   if(isset($request->employee_id)){

         $employee_id = $request->employee_id;

         $check_day_in = "SELECT * FROM tbl_marketing_employee_routine WHERE employee_id = '".$employee_id."' AND day_in LIKE '".date('d-m-Y')."%'  ";
         $check_day_in = getRaw($check_day_in);

         $check_day_out = "SELECT * FROM tbl_marketing_employee_routine WHERE employee_id = '".$employee_id."' AND day_out LIKE '".date('d-m-Y')."%'  ";
         $check_day_out = getRaw($check_day_out);

         $check_meeting_count = "SELECT COUNT(*) AS meeting_count FROM tbl_marketing_employee_routine_meeting WHERE employee_id = '".$employee_id."' AND meeting_in LIKE '".date('d-m-Y')."%'  ";
         $check_meeting_count = getRaw($check_meeting_count);
         $check_meeting_count = $check_meeting_count[0]['meeting_count'];
         

         $found = 0;
         if(count($check_day_in) > 0){ 

               $status = 1;
               $message = "Day In";
               $found = 1;

         }
         if($check_meeting_count > 0){

            $check_meeting_out = "SELECT * FROM tbl_marketing_employee_routine_meeting WHERE employee_id = '".$employee_id."' AND meeting_out IS NULL ";
            $check_meeting_out = getRaw($check_meeting_out);  
            if(count($check_meeting_out) > 0){
               $status = 3;
               $message = 'Meeting is under running';
               $data = array('meeting_id'=>$check_meeting_out[0]['meeting_id']);
            }else{
               $status = 4;
               $message = 'All meetings are over, but no day out';
            }
 
         }
         if(count($check_day_out) > 0){

               $status = 2;
               $message = "Day Out";
               $found = 1;

         }


         if($found == 0){

               $status = 0;
               $message = "No punch in for today";
               
         }

   }else{


		$status = 0;
		$message = 'Invalid request !';

   }

   $data = array('status' => $status, 'message' => $message,'data'=>$data);
   echo json_encode($data);
