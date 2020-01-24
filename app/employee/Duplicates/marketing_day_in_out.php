<?php

   require_once('../../functions.php');

   $request = json_decode(trim(file_get_contents('php://input')));

   $data = array();
   if(isset($request->employee_id) && isset($request->in_out_status) && isset($request->latitude) &&  isset($request->longitude)){

      // 0 - in 
      // 1 - out

      $employee_id = $request->employee_id;
      $latitude = $request->latitude;
      $longitude = $request->longitude;

      if($request->in_out_status == '0'){

         $last_id = "";

         $form_data = array(
            'employee_id' => $request->employee_id,
            'day_in' => date('d-m-Y H:i'),
            'latitude_in' => $latitude,
            'longitude_in' => $longitude
         );

         $query = "SELECT * FROM tbl_marketing_employee_routine WHERE employee_id = '".$employee_id."' AND day_in LIKE '".date('d-m-Y')."%'  ";
         $check = getRaw($query);

         if(count($check) > 0){

            $status = 0;
            $message = "you have already punched for day in";
            $last_id = getRaw($query);
            $last_id = $last_id[0]['routine_id'];

         }else{

            if(insert('tbl_marketing_employee_routine',$form_data)){

               $last_id = last_id('tbl_marketing_employee_routine','routine_id');
               
               $status = 1;
               $message = 'you have successfully punched for day in';

            }else{

               $status = 0;
               $message = 'Failed to punch for day in, please try again later';

            }

         }
      
      }else{

         $query = "SELECT * FROM tbl_marketing_employee_routine WHERE employee_id = '".$employee_id."' AND day_out LIKE '".date('d-m-Y')."%'  ";
         $check = getRaw($query);

         if(count($check) > 0){

            $status = 0;
            $message = "you have already punched for day out";
            $last_id = getRaw($query);
            $last_id = $last_id[0]['routine_id'];

         }else{

            $update = "UPDATE tbl_marketing_employee_routine SET day_out = '".date('d-m-Y H:i')."',latitude_out = '".$latitude."',longitude_out = '".$longitude."' WHERE employee_id = '".$employee_id."' AND day_in LIKE '".date('d-m-Y')."%' ";
         
            if(query($update)){

               $last_id = getRaw($query);
               $last_id = $last_id[0]['routine_id'];

               $status = 1;
               $message = 'you have successfully punched for day out';
              

            }else{

               $status = 0;
               $message = 'Failed to punch for day out, please try again later';

            }

         }

      }   

      $data = array('routine_id'=>$last_id);      

   }else{

      $status = 0;
      $message = 'Invalid request !';

   }

   $json = array('status' => $status, 'message' => $message, 'data'=>$data );
   echo json_encode($json);
   
