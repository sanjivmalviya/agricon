<?php

   require_once('../../functions.php');

   $request = json_decode(trim(file_get_contents('php://input')));

   $data = array();
   if(isset($request->meeting_id)){
      
      $meeting_out = date('d-m-Y H:i');
      $query = "SELECT * FROM tbl_marketing_employee_routine_meeting WHERE meeting_id = '".$request->meeting_id."' AND meeting_out IS NULL";
      $query = getRaw($query);
      
      if(count($query) > 0){

         $update = "UPDATE tbl_marketing_employee_routine_meeting SET meeting_out = '".$meeting_out."' WHERE meeting_id = '".$request->meeting_id."' ";
         if(query($update)){
            $status = 1;
            $message = 'you have successfully punched for meeting out';
         }else{
            $status = 0;
            $message = 'something went wrong, please try again later';
         }


      }else{

         $status = 0;
         $message = 'you have already punched for meeting out';

      }
       

   }else{

      $status = 0;
      $message = 'Invalid request !';

   }

   $data = array('status' => $status, 'message' => $message);
   echo json_encode($data);
   
