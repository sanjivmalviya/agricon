<?php

   require_once('../../functions.php');

   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->customer_id)){

      $customers = getWhere('tbl_customer','customer_id',$request->customer_id);

      if(isset($customers) && count($customers) > 0){

            $customer_id = $request->customer_id;
            $customer_name = $request->customer_name;
            $customer_address = $request->customer_address;
            $customer_at = $request->customer_at;
            $customer_taluka = $request->customer_taluka;
            $customer_district = $request->customer_district;
            $customer_pincode = $request->customer_pincode;
            $customer_email = $request->customer_email;
            $customer_landline = $request->customer_landline;
            $customer_mobile = $request->customer_mobile;
            $customer_gst = $request->customer_gst;
            $customer_mode_of_payment = $request->customer_mode_of_payment;
            $customer_pan = $request->customer_pan;
            $customer_doj = $request->customer_doj;
            $customer_dob = $request->customer_dob;
            $customer_fertilizer_lic = $request->customer_fertilizer_lic;
            $customer_pesticide_lic = $request->customer_pesticide_lic;
            $customer_seed_lic = $request->customer_seed_lic;
            $customer_aadhaar_number = $request->customer_aadhaar_number;
            $contact_person_name = $request->contact_person_name;

            // generate order id
            $update_customer = "UPDATE tbl_customer SET  
               customer_name = '$customer_name',
               customer_address = '$customer_address',
               customer_at = '$customer_at',
               customer_taluka = '$customer_taluka',
               customer_district = '$customer_district',
               customer_pincode = '$customer_pincode',
               customer_email = '$customer_email',
               customer_landline = '$customer_landline',
               customer_mobile = '$customer_mobile',
               customer_gst = '$customer_gst',
               customer_mode_of_payment = '$customer_mode_of_payment',
               customer_pan = '$customer_pan',
               customer_doj = '$customer_doj',
               customer_dob = '$customer_dob',
               customer_fertilizer_lic = '$customer_fertilizer_lic',
               customer_pesticide_lic = '$customer_pesticide_lic',
               customer_seed_lic = '$customer_seed_lic',
               customer_aadhaar_number = '$customer_aadhaar_number',
               contact_person_name = '$contact_person_name'
            WHERE customer_id = '$customer_id'
            ";
            
            if(query($update_customer)){

               $json = array('status' => 1 , 'message' => 'Customer Updated Successfully');
            
            }else{
      		
                $json = array('status' => 0 , 'message' => 'Failed to update Customer');
            
            }


      }else{
               
            $json = array('status' => 0 , 'message' => 'Customer not found');

   	}


   }else{
            
         $json = array('status' => 0 , 'message' => 'Invalid Request');

   }

   
   echo json_encode($json);

?>
