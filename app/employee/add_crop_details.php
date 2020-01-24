<?php

   require_once('../../functions.php');
   

   $request = json_decode(file_get_contents('php://input'));

   // print_r($request);
   // exit;

   if(isset($request->employee_id) && isset($request->meeting_id) && isset($request->crop_details)){

        // PENDING field :: farmer_photo
        $data = array();

        $check = "SELECT * FROM tbl_farmer_crop_details WHERE employee_id = '".$request->employee_id."' AND meeting_id = '".$request->meeting_id."' ";
      
        if(count(getRaw($check)) > 0){

            $status = 0;
            $message = "crop already added for the running meeting";

        }else{
        
        $last_id = "";
        foreach($request->crop_details as $rs){

            $form_data = array(
               "employee_id" => $request->employee_id,
               "meeting_id" => $request->meeting_id,
               "crop_name" => $rs->crop_name,
               "acre" => $rs->acre,
               "date_of_plantation" => $rs->date_of_plantation,
               "crop_condition" => $rs->crop_condition,
               "recommendation" => $rs->recommendation
            );
               
               if(insert('tbl_farmer_crop_details',$form_data)){

                  $last_id = last_id('tbl_farmer_crop_details','crop_detail_id');

                  $status = 1;
                  $message = "Crop added successfully";
                  $data = array('crop_detail_id'=>$last_id);

               }else{

                  $status = 0;
                  $message = "Failed to add crop";

               }
          }
        

        }


   }else{



         $status = 0;

         $message = "Invalid Request";



   }



   $data = array('status' => $status, 'message' => $message,'data'=>$data);

   echo json_encode($data);



?>
