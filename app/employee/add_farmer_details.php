<?php

   require_once('../../functions.php'); 
   $request = json_decode(file_get_contents('php://input'));
   
   if(
      isset($request->meeting_id) && 
      isset($request->employee_id) && 
      isset($request->farmer_name) && 
      isset($request->farmer_address) && 
      isset($request->farmer_village) && 
      isset($request->farmer_taluka) && 
      isset($request->farmer_district) && 
      isset($request->farmer_mobile) && 
      isset($request->farmer_dealer_name) && 
      isset($request->farmer_total_acre)
   ){

         // PENDING field :: farmer_photo
         $data = array();

         $check = "SELECT * FROM tbl_farmer_basic_details WHERE employee_id = ".$request->employee_id." AND meeting_id = ".$request->meeting_id." ";
         $check = getRaw($check);

         if(isset($check) && count($check) > 0){

            $status = 0;
            $message = "Farmer details already added for this meeting";

         }else{
            
            $form_data = array(
               "meeting_id" => $request->meeting_id,
               "employee_id" => $request->employee_id,
               "farmer_name" => $request->farmer_name,
               "farmer_address" => $request->farmer_address,
               "farmer_village" => $request->farmer_village,
               "farmer_taluka" => $request->farmer_taluka,
               "farmer_district" => $request->farmer_district,
               "farmer_mobile" => $request->farmer_mobile,
               "farmer_dealer_name" => $request->farmer_dealer_name,
               "farmer_total_acre" => $request->farmer_total_acre
            );

            if(insert('tbl_farmer_basic_details',$form_data)){

               $last_id = last_id('tbl_farmer_basic_details','basic_detail_id');

               $status = 1;

               $message = "Farmer details addedd successfully";
               $data = array('meeting_id'=>$last_id);

            }else{

               $status = 0;
               $message = "Failed to create Order";

            }

         }

   }else{

         $status = 0;
         $message = "Invalid Request";

   }



   $data = array('status' => $status, 'message' => $message,'data'=>$data);

   echo json_encode($data);



?>
