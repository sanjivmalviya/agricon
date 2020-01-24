
<?php

   require_once('../../functions.php');   
   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->order_id) & isset($request->order_detail)){

      $order_id = $request->order_id;
      $total_item = count($request->order_detail);

      foreach($request->order_detail as $rs){

         $order_product_cgst = ""; 
         $order_product_sgst = ""; 
         $order_product_igst = ""; 

         $product = getOne('tbl_product','product_id',$rs->order_product_id);
         
         if($rs->order_product_tax_type == 1){
            $order_product_cgst =  $product['product_gst'] / 2;
            $order_product_sgst = $order_product_cgst; 
         }else{
            $order_product_igst =  $product['product_gst'];
         }

         $form_data = array(
            'order_id' => $order_id,
            'order_product_id' => $rs->order_product_id,
            'order_product_quantity' => $rs->order_product_quantity,
            'order_dispatch_quantity' => 0,
            'order_product_rate' => $rs->order_product_rate,
            'order_product_discount' => $rs->order_product_discount,
            'order_product_tax_type' => $rs->order_product_tax_type,
            'order_product_cgst' => $order_product_cgst,
            'order_product_sgst' => $order_product_sgst,
            'order_product_igst' => $order_product_igst
         );                  
         if(insert('tbl_order_detail',$form_data)){
            $insert = 1;                              
         }else{
            $insert = 0;
         }

      }

          
      if($insert == 1){

         $required_quantity = "SELECT SUM(order_product_quantity) as required_quantity FROM tbl_order_detail WHERE order_id = '$order_id' "; 
         $required_quantity = getRaw($required_quantity);
         $required_quantity = $required_quantity[0]['required_quantity'];

         $dispatched_quantity = "SELECT SUM(order_dispatch_quantity) as dispatched_quantity FROM tbl_order_detail WHERE order_id = '$order_id' "; 
         $dispatched_quantity = getRaw($dispatched_quantity);
         $dispatched_quantity = $dispatched_quantity[0]['dispatched_quantity'];

         if($required_quantity == $dispatched_quantity){
         // fully disaptched
         $update_order = "UPDATE tbl_orders SET order_dispatch_status = '1' WHERE order_id = '$order_id' ";
         query($update_order);
         $status = "Dispatched";
      }else{
         // partially disaptched
         $update_order = "UPDATE tbl_orders SET order_dispatch_status = '2' WHERE order_id = '$order_id' ";
         query($update_order);
         $status = "Partially Dispatched";
      }

         // notify admin
         $sender_user_type = 4;

         $sender = getOne('tbl_orders','order_id',$order_id);
         $sender_id = $sender['employee_id'];
         $order_number = $sender['order_number'];
         
         $sender = getOne('tbl_employee','employee_id',$sender_id);
         $sender_name = $sender['employee_name'];

         $receiver_user_type = 2;

         $receiver_id = $sender['added_by'];        

         $notification_title = "Order Updated";
         $notification_description = $sender_name."has updated the order by adding ".$total_item." new items for order number <b>#".$order_number."</b>";
         
         send_notification($sender_user_type,$sender_id,$receiver_user_type,$receiver_id,$notification_title,$notification_description);

         // notify godown
         $sender_user_type = 4;

         $order = getOne('tbl_orders','order_id',$order_id);
         $sender_id = $order['employee_id'];
         $order_number = $order['order_number'];
         
         $sender = getOne('tbl_employee','employee_id',$sender_id);
         $sender_name = $sender['employee_name'];

         $receiver_user_type = 3;
         $receiver_id = $order['godown_id'];        

         $notification_title = "Order Updated";
         $notification_description = $sender_name."has updated the order by adding ".$total_item." new items for order number <b>#".$order_number."</b>";
         
         send_notification($sender_user_type,$sender_id,$receiver_user_type,$receiver_id,$notification_title,$notification_description);
         
         $status = 1;
         $message = "Order Updated successfully";

        
      }else{

         $status = 0;
         $message = "Failed to add item, try again later";

      }

   }else{

         $status = 0;
         $message = "Invalid Request";

   }

   $data = array('status' => $status, 'message' => $message);
   echo json_encode($data);

?>