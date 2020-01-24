
<?php

   require_once('../../functions.php');
   
   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->employee_id) && isset($request->today)){

         $employee_id = $request->employee_id;
         $today = $request->today;
         $start_date = $request->start_date;
         $end_date = $request->end_date;
         
         if(isset($start_date) && $start_date !="" && isset($end_date) && $end_date != ""){

         	// filter by date
            $start_date = date('Y-m-d', strtotime($start_date)); 
            $end_date = date('Y-m-d', strtotime($end_date)); 

            $orders = "SELECT * FROM tbl_orders WHERE employee_id = '$employee_id' AND DATE(created_at) BETWEEN '$start_date' AND '$end_date' ORDER BY created_at DESC";
            $orders = getRaw($orders);
          
         }else if($today == 0){

         	// only today's records
            $orders = "SELECT * FROM tbl_orders WHERE employee_id = '$employee_id' ORDER BY created_at DESC";
            $orders = getRaw($orders);

         }else{

         	// show all by default
            $today_date = date('Y-m-d'); 
            $orders = "SELECT * FROM tbl_orders WHERE employee_id = '$employee_id' AND DATE(created_at) = '$today_date'  ORDER BY created_at DESC";
            $orders = getRaw($orders);

         }


         if(isset($orders) && count($orders) > 0){

            $total_orders = count($orders);

            foreach($orders as $ord){
               
               $customer_name = getOne('tbl_customer','customer_id',$ord['customer_id']);
               $customer_name = $customer_name['customer_name'];
               $val['customer_name'] = $customer_name;
               $val['order_id'] = $ord['order_id'];
               $val['order_number'] = $ord['order_number'];
               if($ord['order_approve_status'] == '1'){
           			$val['order_approve_status'] = "Approved";
               }else if($ord['order_approve_status'] == '0'){
           			$val['order_approve_status'] = "Not Approved";
               }

               if($ord['order_dispatch_status'] == '0'){
           			$val['order_dispatch_status'] = "Not Dispatched";
               }else if($ord['order_dispatch_status'] == '1'){
           			$val['order_dispatch_status'] = "Dispatched";
               }else if($ord['order_dispatch_status'] == '2'){
           			$val['order_dispatch_status'] = "Partially Dispatched";
               }

               $val['order_date'] = $ord['created_at'];
               
               $grand_total = 0;         
               $total_tax_amount = 0;
               $tax_grand_total = 0;
               $product_amount_total = 0;

               $order_items = getWhere('tbl_order_detail','order_id',$ord['order_id']);
               $number_of_products = count($order_items); 

               foreach($order_items as $rs){

                   $product = getOne('tbl_product','product_id',$rs['order_product_id']);

                   $product_amount = $rs['order_product_quantity'] * $rs['order_product_rate'] - ($rs['order_product_discount'] * $rs['order_product_rate'] * $rs['order_product_quantity'] / 100);
                  

                   $product_amount_total += $product_amount;

                   if($ord->invoice_gst_type == 1){
                 
                    // cgst/sgst
                    $cgst_sgst = $product['product_gst'] / 2;

                    $cgst_sgst_amount = ($product_amount * $cgst_sgst / 100) ;

                    $data = array('cgst'=> $cgst_sgst, 'sgst' => $cgst_sgst , 'cgst_amount' => number_format($cgst_sgst_amount,2), 'sgst_amount' => number_format($cgst_sgst_amount,2));
                    $tax_array['cgst_sgst'][] = $data;
                    
                    // hsn tax rates
                    $central_tax_rate = $cgst_sgst;
                    $central_tax_amount = $cgst_sgst_amount;

                    $state_tax_rate = $cgst_sgst;
                    $state_tax_amount = $cgst_sgst_amount;
                    $total_tax_amount = $central_tax_amount + $state_tax_amount;
                    $tax_grand_total += $total_tax_amount; 
                  
                  }else{
                    
                    $igst = $product['product_gst'];
                    $igst_amount = ($product_amount * $igst / 100) ;

                    $tax_array['igst'][] = array('igst' => $igst, 'igst_amount' => number_format($igst_amount,2));

                    // hsn tax rates
                    $central_tax_rate = $igst;
                    $central_tax_amount = $igst_amount;

                    $state_tax_rate = 0;
                    $state_tax_amount = 0;

                    $total_tax_amount = $central_tax_amount;
                    $tax_grand_total += $total_tax_amount; 
                  }

               }

               $val['product_total'] = $tax_grand_total + $product_amount_total;
               $val['number_of_products'] = $number_of_products;

               $data[] = $val;

            }
            $message = $total_orders." Order(s) found";
            $json = array('status'=>1,'message'=>$message,'data'=>$data);

         }else{

            $json = array('status'=>0,'message'=>'0 Orders Found');

         }

   }else{
   
         $json = array('status'=>0,'message'=>'Invalid Request');

   }

   echo json_encode($json);
   