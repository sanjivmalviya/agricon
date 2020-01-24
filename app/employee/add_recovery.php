<?php

   require_once('../../functions.php');
   

   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->customer_id) && isset($request->meeting_id) && isset($request->employee_id) && isset($request->transaction_type) && isset($request->amount)){

        $data = null;
        $last_id = "";

        $check = "SELECT * FROM tbl_customer_recovery WHERE customer_id = '".$request->customer_id."' AND meeting_id = '".$request->meeting_id."' AND employee_id = '".$request->employee_id."' ";
      
        if(count(getRaw($check)) > 0){

            $status = 0;
            $message = "recovery already added for the running meeting";

        }else{

              // PENDING FIELDS : cheque photo
              // transaction_type = 1 = cheque
              // transaction_type = 2 = RTGS

               $form_data = array(
                  "customer_id" => $request->customer_id,
                  "employee_id" => $request->employee_id,
                  "meeting_id" => $request->meeting_id,
                  "transaction_type" => $request->transaction_type, 
                  "cheque_date" => $request->cheque_date, 
                  // "cheque_photo" => $request->cheque_photo, 
                  "amount" => $request->amount, 
                  "commitment_date" => $request->commitment_date,
               );
               
               if(insert('tbl_customer_recovery',$form_data)){

                  $last_id = last_id('tbl_customer_recovery','current_stock_id');

                  $status = 1;
                  $message = "Recovery added successfully";
                  $data = array('recovery_id'=>$last_id);

               }else{

                  $status = 0;
                  $message = "Failed to add recovery";
               
               }
         
         
        }


   }else{

         $status = 0;
         $message = "Invalid Request";

   }



   $data = array('status' => $status, 'message' => $message,'data'=>$data);
   echo json_encode($data);

?>
