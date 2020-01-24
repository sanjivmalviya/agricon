<?php

   require_once('../../functions.php');

   $request = json_decode(trim(file_get_contents('php://input')));

   $data = array();
   if(isset($request->employee_id)){

         $employee_id = $request->employee_id;

         $form_data = array(
            'employee_id' => $request->employee_id,
            'day_out' => date('d-m-Y H:i')
         );

         $check = "SELECT * FROM tbl_staff_employee_routine WHERE employee_id = '".$employee_id."' AND day_out LIKE '".date('d-m-Y')."%'  ";
         $check = getRaw($check);

         if(count($check) > 0){

            $status = 0;
            $message = "you have already punched for day out";

         }else{

            $update = "UPDATE tbl_staff_employee_routine SET day_out = '".date('d-m-Y H:i')."' WHERE employee_id = '".$employee_id."' AND day_in LIKE '".date('d-m-Y')."%' ";
         
            if(query($update)){

               $status = 1;
                  $message = 'you have successfully punched for day out';

            }else{

               $status = 0;
               $message = 'Failed to punch for day out, please try again later';

            }

         }
         

   }else{

      $status = 0;
      $message = 'Invalid request !';

   }

   $data = array('status' => $status, 'message' => $message);
   echo json_encode($data);
