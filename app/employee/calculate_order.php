<?php

   require_once('../../functions.php');
   
   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->product_detail) && isset($request->customer_id)){

       $grand_total = 0;         
       $total_tax_amount = 0;
       $tax_grand_total = 0;

       $customer_gst_type = getOne('tbl_customer','customer_id',$request->customer_id);
       $customer_gst_type = $customer_gst_type['customer_gst_type'];

   	   foreach($request->product_detail as $rs){

   	   	    $product = getOne('tbl_product','product_id',$rs->product_id);

   	   	    $product_amount = $rs->product_quantity * $rs->product_rate - ($rs->product_discount * $rs->product_rate * $rs->product_quantity / 100);
   	   	    
   	   	    if($customer_gst_type == 1){
           
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

            }

            $tax_grand_total += $total_tax_amount; 

             $hsn_data[] = array(
              'hsn_code'=>$product['product_hsn_code'],
              'taxable_value'=>$rs->product_rate,
              'central_tax_rate'=>$central_tax_rate,
              'central_tax_amount'=>$central_tax_amount,
              'state_tax_rate'=>$state_tax_rate,
              'state_tax_amount'=>$state_tax_amount,
              'total_tax_amount'=>$total_tax_amount
            );  

       }
       
       $json = array('status'=>1,'message'=>'Data Found','tax_total'=>$tax_grand_total,'tax_data'=>$tax_array,'hsn_data'=>$hsn_data);

   }else{

   		$json = array('status'=>0,'message'=>'Invalid Request');

   }

   echo json_encode($json);

   		

