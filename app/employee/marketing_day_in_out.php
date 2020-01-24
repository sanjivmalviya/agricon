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

               // purpose : collect all stored co-ordinates including day_in,multiple trips and day_out to build distance matrix api
               // use of below api : to get distance in miles and travel time in mins for one source to multiple destinations seperated by |.
               
               $get_trip = 'SELECT * FROM tbl_marketing_employee_routine WHERE employee_id = "'.$employee_id.'" AND routine_id = "'.$last_id.'" AND latitude_out != "" AND longitude_out != "" ';
               $get_trip = getRaw($get_trip);
               
               $source_cordinates =  $get_trip[0]['latitude_in'].",".$get_trip[0]['longitude_in'];
               
               $get_trip_detail = 'SELECT * FROM tbl_marketing_employee_routine_meeting WHERE employee_id = "'.$employee_id.'" AND routine_id = "'.$last_id.'" ';
               $get_trip_detail = getRaw($get_trip_detail);

               $mid_cordinates = "";
               foreach($get_trip_detail as $rs){
                     $dataset[] = $rs['latitude'].",".$rs['longitude'];
               }

               // now get end cordinates
               $end_cordinates =  $get_trip[0]['latitude_out'].",".$get_trip[0]['longitude_out'];
               $dataset[] = $end_cordinates;
               
               array_unshift($dataset, $source_cordinates);

               $limit = count($dataset);
               $origin_cordinates = "";
               for($i=0;$i<$limit-1;$i++){
                  if($i==$limit-2){
                     $origin_cordinates .= $dataset[$i];
                  }else{
                     $origin_cordinates .= $dataset[$i]."|";
                  }
               }
               $destination_cordinates = "";
               for($i=1;$i<$limit;$i++){
                  if($i==$limit-1){
                     $destination_cordinates .= $dataset[$i];
                  }else{
                     $destination_cordinates .= $dataset[$i]."|";
                  }
               }

               $api_url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$origin_cordinates."&destinations=".$destination_cordinates."&key=AIzaSyDGSG21Xmgqp4De36T2Xh2ftB5tbDQku3A";               
               $api_response = file_get_contents($api_url);

               $form_data = array(
                  'employee_id' => $employee_id,
                  'routine_id' => $last_id,
                  'api_response' => $api_response
               );
               $saveApiResponse = insert('tbl_employee_routine_tracking',$form_data);

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
   
