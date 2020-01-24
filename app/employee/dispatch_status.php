
<?php

   require_once('../../functions.php');
   
   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->order_id)){

            $order_id = $request->order_id;

            $orders = "SELECT * FROM tbl_order_detail WHERE order_id = '$order_id'";
            $orders = getRaw($orders);

         if(isset($orders) && count($orders) > 0){

            foreach($orders as $rs){
 
                $product_name = getOne('tbl_product','product_id',$rs['order_product_id']);
                $product_name = $product_name['product_name'];

                $dataset['product_name'] = $product_name;
                $dataset['order_quantity'] = $rs['order_product_quantity'];

                $get_dispatch_quantity = "SELECT SUM(dispatch_quantity) AS dispatch_quantity FROM tbl_invoice_detail WHERE order_id = '$order_id' AND order_detail_id = '".$rs['order_detail_id']."' ";
                $get_dispatch_quantity = getRaw($get_dispatch_quantity);

                if(isset($get_dispatch_quantity)){
                  $dataset['dispatch_quantity'] = $get_dispatch_quantity[0]['dispatch_quantity'];
                }else{
                  $dataset['dispatch_quantity'] = 0;
                }

                $dataset['pending_quantity'] = $dataset['order_quantity'] - $dataset['dispatch_quantity'];
                
                if($dataset['pending_quantity'] > 0 ){
                  $amount = $rs['order_product_rate'] * $dataset['pending_quantity'];
                  $tax = ($rs['order_product_igst'] + $rs['order_product_cgst'] + $rs['order_product_sgst'] * $amount ) / 100;
                  // echo $tax = $amount * $tax;
                  $dataset['pending_amount'] = $amount + $tax; 
                }else{
                  $dataset['pending_amount'] = 0;                   
                }
                                
                $data[] = $dataset;

            }

              $json = array('status'=>1,'message'=>'data found','data'=>$data);

         }else{

            $json = array('status'=>0,'message'=>'no data Found');

         }

   }else{
   
         $json = array('status'=>0,'message'=>'Invalid Request');

   }

   echo json_encode($json);
   