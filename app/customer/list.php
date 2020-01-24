<?php

   require_once('../../functions.php');

   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->employee_id)){

      $customers = getWhere('tbl_customer','party_handled_by',$request->employee_id);

      if(isset($customers) && count($customers) > 0){

            // generate order id
            $previous_order_number = "SELECT order_number FROM tbl_orders ORDER BY order_id DESC LIMIT 1";
            
            if($rs = getRaw($previous_order_number)){
               $previous_order_number = $rs[0]['order_number'];
               $order_number = substr($previous_order_number,5)+1;
               $order_number = "ORDER".$order_number;
            }else{

               $order_number = "ORDER1";

            }
            
         foreach($customers as $rs){
            
            $data[] = $rs;
     			$json = array('status' => 1 , 'message' => 'data found' , 'data' => $data, 'order_number' => $order_number);
             
      		}

      }else{
      			
      		$json = array('status' => 0 , 'message' => 'No data found');

   	}


   }else{
            
         $json = array('status' => 0 , 'message' => 'Invalid Request');

   }

   
   echo json_encode($json);

?>