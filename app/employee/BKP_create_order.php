
<?php

   require_once('../../functions.php');
   
   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->invoice_date) && isset($request->invoice_delivery_note) && isset($request->invoice_terms_of_payment) && isset($request->invoice_supplier_reference) && isset($request->invoice_other_reference) && isset($request->invoice_buyer_order_number) && isset($request->invoice_buyer_order_date) && isset($request->invoice_dispatch_document_number) && isset($request->invoice_delivery_note_date) && isset($request->invoice_dispatch_through) && isset($request->invoice_dispatch_destination) && isset($request->customer_id) && isset($request->consignee_same_as_customer) && isset($request->consignee)){

         // generate order id
         $previous_order_number = "SELECT order_number FROM tbl_orders ORDER BY order_id DESC LIMIT 1";
         
         if($rs = getRaw($previous_order_number)){
            $previous_order_number = $rs[0]['order_number'];
            $order_number = substr($previous_order_number,5)+1;
            $order_number = "ORDER".$order_number;
         }else{

            $order_number = "ORDER1";

         }


         $form_data = array(
            'employee_id' => $request->employee_id,
            'order_number' => $order_number,
            'invoice_date' => $request->invoice_date,
            'invoice_delivery_note' => $request->invoice_delivery_note,
            'invoice_terms_of_payment' => $request->invoice_terms_of_payment,
            'invoice_supplier_reference' => $request->invoice_supplier_reference,
            'invoice_other_reference' => $request->invoice_other_reference,
            'invoice_buyer_order_number' => $request->invoice_buyer_order_number,
            'invoice_buyer_order_date' => $request->invoice_buyer_order_date,
            'invoice_dispatch_document_number' => $request->invoice_dispatch_document_number,
            'invoice_delivery_note_date' => $request->invoice_delivery_note_date,
            'invoice_dispatch_through' => $request->invoice_dispatch_through,
            'invoice_dispatch_destination' => $request->invoice_dispatch_destination,
            'invoice_gst_type' => $request->invoice_gst_type,
            'customer_id' => $request->customer_id,
            'consignee_same_as_customer' => $request->consignee_same_as_customer,
            'consignee' => $request->consignee  
         );

         if(insert('tbl_orders',$form_data)){

            $last_id = last_id('tbl_orders','order_id');

            if(isset($request->order_detail)){

               $product_total = 0;
               
               foreach($request->order_detail as $rs){

                  $order_product_cgst = ""; 
                  $order_product_sgst = ""; 
                  $order_product_igst = ""; 

                  $product = getOne('tbl_product','product_id',$rs->order_product_id);

                  if($request->invoice_gst_type == 1){
                     $order_product_cgst =  $product['product_gst'] / 2;
                     $order_product_sgst = $order_product_cgst; 
                  }else{
                     $order_product_igst =  $product['product_gst'];
                  }

                  $form_data = array(
                     'order_id' => $last_id,
                     'order_product_id' => $rs->order_product_id,
                     'order_product_quantity' => $rs->order_product_quantity,
                     'order_dispatch_quantity' => 0,
                     'order_product_rate' => $rs->order_product_rate,
                     'order_product_discount' => $rs->order_product_discount,
                     // 'order_product_tax_type' => $rs->order_product_tax_type,
                     'order_product_cgst' => $order_product_cgst,
                     'order_product_sgst' => $order_product_sgst,
                     'order_product_igst' => $order_product_igst
                  );   
                  
                  if(insert('tbl_order_detail',$form_data)){
                     $insert = 1;                              
                  }else{
                     $insert = 0;
                  }
                 
                  $product_amount = $rs->order_product_quantity * $rs->order_product_rate - ($rs->order_product_discount * $rs->order_product_rate * $rs->order_product_quantity / 100);
                  
                  $request->invoice_gst_type;

                  if($request->invoice_gst_type == 1){
           
                     // cgst/sgst
                    $cgst_sgst = $product['product_gst'] / 2;
                    $cgst_sgst_amount = ($product_amount * $cgst_sgst / 100) ;

                    // hsn tax rates
                    $central_tax_rate = $cgst_sgst;
                    $central_tax_amount = $cgst_sgst_amount;

                    $state_tax_rate = $cgst_sgst;
                    $state_tax_amount = $cgst_sgst_amount;
                    $total_tax_amount = $central_tax_amount + $state_tax_amount;
                  
                  }else{

                    $igst = $product['product_gst'];
                    $igst_amount = ($product_amount * $igst / 100) ;

                    $central_tax_rate = $igst;
                    $central_tax_amount = $igst_amount;

                    $state_tax_rate = 0;
                    $state_tax_amount = 0;

                    $total_tax_amount = $central_tax_amount;

                  }

                  $product_total += $product_amount + $total_tax_amount; 

               }


            }

            if($insert == 0){
               // delete order if order details are not inserted
               delete('tbl_orders','order_id',$last_id);

            }else{

               // get running target assigned to sales perosn

               $today = date('Y-m-d', strtotime($timestamp));
               $target_assigned = "SELECT * FROM tbl_employee_target WHERE '$today' BETWEEN employee_target_start_date AND employee_target_end_date ORDER BY employee_target_id DESC LIMIT 1";
               $target_assigned = getRaw($target_assigned);
               $employee_target_id = $target_assigned[0]['employee_target_id'];
               $employee_target_amount = $target_assigned[0]['employee_target_amount'];
               $employee_target_amount = $target_assigned[0]['employee_target_amount'];
               $employee_target_start_date = $target_assigned[0]['employee_target_start_date'];
               $employee_target_end_date = $target_assigned[0]['employee_target_end_date'];

               // add entry to Employee target
               $form_data = array(
                  'employee_target_id' => $employee_target_id,
                  'employee_id' => $request->employee_id,
                  'employee_order_id' => $last_id,
                  'employee_order_amount' => $product_total
               );

               insert('tbl_employee_target_detail',$form_data);

               $target_achieved = "SELECT sum(employee_order_amount) as employee_achieve_amount,count(*) as total_orders FROM tbl_employee_target_detail WHERE employee_target_id = '$employee_target_id' ";
               $target_achieved = getRaw($target_achieved);

               $employee_achieve_amount = $target_achieved[0]['employee_achieve_amount']; 
               $employee_total_orders = $target_achieved[0]['total_orders']; 

               if($employee_achieve_amount >= $employee_target_amount){
                  $achieved_status = 1;

                  // FOR(admin->employee) send notifications regarding target achievement
                  $sender_user_type = 4;
                  $sender_id = $request->employee_id;

                  $receiver_user_type = 2;
                  $receiver_id = getWhere('tbl_employee','employee_id',$sender_id);
                  $receiver_id = $receiver_id[0]['added_by'];

                  $sender_name = getOne('tbl_employee','employee_id',$sender_id);
                  $sender_name = $sender_name['employee_name']; 

                  $notification_title = "Target Achieved";
                  $notification_description = "<b>GREAT ! </b> ".$sender_name." has achieved the target of <b>".$employee_target_amount."</b> by placing <b>".$employee_total_orders." Orders</b> assigned between ".$employee_target_start_date." to ".$employee_target_end_date;
                  // feed notification
                  $form_data = array(
                     'notification_sender_user_type' => $sender_user_type,
                     'notification_sender_user_id' => $sender_id,
                     'notification_receiver_user_type' => $receiver_user_type ,
                     'notification_receiver_user_id' => $receiver_id,
                     'notification_title' => '',
                     'notification_title' => $notification_title, 
                     'notification_description' => $notification_description 
                  );
                  insert('tbl_notifications',$form_data);

                  // FOR(employee->self) send notifications regarding target achievement
                  $receiver_user_type = 4;
                  $receiver_id = $request->employee_id;

                  $sender_user_type = 2;
                  $sender_id = getWhere('tbl_employee','employee_id',$receiver_id);
                  $sender_id = $sender_id[0]['added_by'];

                  $receiver_name = getOne('tbl_employee','employee_id',$receiver_id);
                  $receiver_name = $receiver_name['employee_name']; 

                  $notification_title = "Target Achieved";
                  $notification_description = "<b>CONGRATULATIONS ".$receiver_name."</b>, You have achieved the target of <b>".$employee_target_amount."</b> by placing <b>".$employee_total_orders." Orders</b> assigned between ".$employee_target_start_date." to ".$employee_target_end_date;
                  // feed notification
                  $form_data = array(
                     'notification_sender_user_type' => $sender_user_type,
                     'notification_sender_user_id' => $sender_id,
                     'notification_receiver_user_type' => $receiver_user_type ,
                     'notification_receiver_user_id' => $receiver_id,
                     'notification_title' => '',
                     'notification_title' => $notification_title, 
                     'notification_description' => $notification_description 
                  );
                  insert('tbl_notifications',$form_data);

                  // notify super_admin by Employee
                  $sender_user_type = 4;
                  $sender_id = $request->employee_id;

                  $receiver_user_type = 1;
                  $receiver_id = 1;
                  
                  $sender = getOne('tbl_employee','employee_id',$sender_id);
                  $sender_name = $sender['employee_name']; 
                  $admin_id = $sender['added_by']; 
                  $admin_name = getOne('tbl_admins','admin_id',$admin_id);
                  $admin_name = $admin_name['admin_name'];

                  $notification_title = "Target Achieved";
                  $notification_description = "<b>GREAT ".$sender_name."</b>, has achieved the target of <b>".$employee_target_amount."</b> by placing <b>".$employee_total_orders." Orders</b> assigned by ".$admin_name." between ".$employee_target_start_date." to ".$employee_target_end_date;

                  // feed notification
                  $form_data = array(
                     'notification_sender_user_type' => $sender_user_type,
                     'notification_sender_user_id' => $sender_id,
                     'notification_receiver_user_type' => $receiver_user_type ,
                     'notification_receiver_user_id' => $receiver_id,
                     'notification_title' => '',
                     'notification_title' => $notification_title, 
                     'notification_description' => $notification_description 
                  );
                  insert('tbl_notifications',$form_data);


               }else{
                  $achieved_status = 0;
               }

               // updating the status of target achieved
               $update_achieved_status = "UPDATE tbl_employee_target SET status = '$achieved_status' WHERE employee_target_id = '$employee_target_id' ";
               query($update_achieved_status);

               // send notifications
               $sender_user_type = 4;
               $sender_id = $request->employee_id;

               $receiver_user_type = 2;
               $receiver_id = getWhere('tbl_employee','employee_id',$sender_id);
               $receiver_id = $receiver_id[0]['added_by'];

               $sender_name = getOne('tbl_employee','employee_id',$sender_id);
               $sender_name = $sender_name['employee_name']; 

               $notification_title = "New Order";
               $notification_description = "You got a new order from ".$sender_name." as order number <b>#".$order_number."</b>";
               // feed notification
               $form_data = array(
                  'notification_sender_user_type' => $sender_user_type,
                  'notification_sender_user_id' => $sender_id,
                  'notification_receiver_user_type' => 2 ,
                  'notification_receiver_user_id' => $receiver_id,
                  'notification_title' => '',
                  'notification_title' => $notification_title, 
                  'notification_description' => $notification_description 
               );
               insert('tbl_notifications',$form_data);
              
            }

            $status = 1;
            $message = "Order Created successfully";
         }else{
            $status = 0;
            $message = "Failed to create Order";
         }
         
   }else{

         $status = 0;
         $message = "Invalid Request";

   }

   $data = array('status' => $status, 'message' => $message);
   echo json_encode($data);

   print_r($form_data1);

?>