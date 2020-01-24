<?php

   require_once('../../functions.php');
   

   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->customer_id) && isset($request->meeting_id) && isset($request->employee_id) && isset($request->remark)){

        $data = null;
        $last_id = "";

        $check = "SELECT * FROM tbl_customer_remark WHERE customer_id = '".$request->customer_id."' AND meeting_id = '".$request->meeting_id."' AND employee_id = '".$request->employee_id."' ";
      
        if(count(getRaw($check)) > 0){

            $status = 0;
            $message = "remark already added for the running meeting";

        }else{

               $form_data = array(
                  "customer_id" => $request->customer_id,
                  "employee_id" => $request->employee_id,
                  "meeting_id" => $request->meeting_id,
                  "remark" => $request->remark 
               );
               
               if(insert('tbl_customer_remark',$form_data)){

                  $last_id = last_id('tbl_customer_remark','remark_id');

                  $status = 1;
                  $message = "Remark added successfully";
                  $data = array('remark_id'=>$last_id);

               }else{

                  $status = 0;
                  $message = "Failed to add remark";
               
               }         
         
        }

   }else{

         $status = 0;
         $message = "Invalid Request";

   }

   $data = array('status' => $status, 'message' => $message,'data'=>$data);
   echo json_encode($data);

?>
