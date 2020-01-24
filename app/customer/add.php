<?php

   require_once('../../functions.php');

   $request = json_decode(file_get_contents('php://input'));

   $data = null;

   if(isset($request->employee_id) && isset($request->customer_name) && isset($request->contact_person_name) && isset($request->customer_dob) && isset($request->customer_address) && isset($request->customer_at) && isset($request->customer_taluka) && isset($request->customer_district) && isset($request->customer_state) && isset($request->customer_email) && isset($request->customer_mobile)){

      $form_data = array(
      'party_handled_by' => $request->employee_id,
      // 'customer_photo' => $request->customer,
      'customer_name' => $request->customer_name,
      'contact_person_name' => $request->contact_person_name,
      'customer_dob' => $request->customer_dob,
      'customer_address' => $request->customer_address,
      'customer_at' => $request->customer_at,
      'customer_taluka' => $request->customer_taluka,
      'customer_district' => $request->customer_district,
      'customer_state' => $request->customer_state,
      'customer_email' => $request->customer_email,
      'customer_mobile' => $request->customer_mobile,
      'shop_number' => $request->customer_shop_number,
      'shop_phone_number' => $request->customer_shop_phone_number,
      'meeting_id' => $request->meeting_id
      );

      // echo "<xmp>";
      // print_r($form_data);
      // exit;

      if(insert('tbl_customer',$form_data)){

         $last_id = last_id('tbl_customer','customer_id');

         $data = array('customer_id'=>$last_id);

         $status = 1;
         $msg = "customer added successfully";

      }else{

         $status = 0;
         $msg = "failed to add customer";
      
      }

   }else{
            
         $status = 0;
         $msg = "invalid request";

   }
   
   $json = array('status'=>$status,'message'=>$msg,'data'=>$data);
   echo json_encode($json);

?>
