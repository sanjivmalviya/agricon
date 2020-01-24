<?php

   require_once('../../functions.php');
   

   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->customer_id) && isset($request->meeting_id) && isset($request->employee_id) && isset($request->current_stock)){

        $data = array();
        $last_id = "";

        $check = "SELECT * FROM tbl_customer_current_stock WHERE customer_id = '".$request->customer_id."' AND meeting_id = '".$request->meeting_id."' ";
      
        if(count(getRaw($check)) > 0){

            $status = 0;
            $message = "current stock already added for the running meeting";

        }else{

           foreach($request->current_stock as $rs){

               $form_data = array(
                  "customer_id" => $request->customer_id,
                  "employee_id" => $request->employee_id,
                  "meeting_id" => $request->meeting_id,
                  "item" => $rs->item,
                  "quantity" => $rs->quantity
               );
                  
               if(insert('tbl_customer_current_stock',$form_data)){

                  $last_id = last_id('tbl_customer_current_stock','current_stock_id');

                  $status = 1;
                  $message = "Stock added successfully";
                  $data = array('last_stock_id'=>$last_id);

               }else{

                  $status = 0;
                  $message = "Failed to add current stock";
               
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
