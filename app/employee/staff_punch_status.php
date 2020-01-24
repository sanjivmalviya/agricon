<?php

   require_once('../../functions.php');

   $request = json_decode(trim(file_get_contents('php://input')));

   $data = array();
   if(isset($request->employee_id)){

         $employee_id = $request->employee_id;

         $check_day_in = "SELECT * FROM tbl_staff_employee_routine WHERE employee_id = '".$employee_id."' AND day_in LIKE '".date('d-m-Y')."%'  ";
         $check_day_in = getRaw($check_day_in);

         $check_lunch_in = "SELECT * FROM tbl_staff_employee_routine WHERE employee_id = '".$employee_id."' AND lunch_in LIKE '".date('d-m-Y')."%'  ";
         $check_lunch_in = getRaw($check_lunch_in);

         $check_lunch_out = "SELECT * FROM tbl_staff_employee_routine WHERE employee_id = '".$employee_id."' AND lunch_out LIKE '".date('d-m-Y')."%'  ";
         $check_lunch_out = getRaw($check_lunch_out);

         $check_day_out = "SELECT * FROM tbl_staff_employee_routine WHERE employee_id = '".$employee_id."' AND day_out LIKE '".date('d-m-Y')."%'  ";
         $check_day_out = getRaw($check_day_out);

         $found = 0;
         if(count($check_day_in) > 0){ 

               $status = 1;
               $message = "Day In";
               $found = 1;

         }
         if(count($check_lunch_in) > 0){

               $status = 2;
               $message = "Lunch In";
               $found = 1;

         }
         if(count($check_lunch_out) > 0){

               $status = 3;
               $message = "Lunch Out";
               $found = 1;

         }
         if(count($check_day_out) > 0){

               $status = 4;
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

   $data = array('status' => $status, 'message' => $message);
   echo json_encode($data);
