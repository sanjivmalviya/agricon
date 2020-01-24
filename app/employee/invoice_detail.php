<?php

   require_once('../../functions.php');
   
   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->invoice_id)){

            $invoice_id = $request->invoice_id;

            $invoice_detail = "SELECT * FROM tbl_invoice_detail WHERE invoice_id = '$invoice_id'";
            $invoice_detail = getRaw($invoice_detail);

            if(isset($invoice_detail)){

            	$json = array('status'=>1,'message'=>'data found','data'=>$invoice_detail);
            	
            }else{

            	$json = array('status'=>0,'message'=>'no data Found');

         	}

   }else{
   
         $json = array('status'=>0,'message'=>'Invalid Request');

   }

   echo json_encode($json);
