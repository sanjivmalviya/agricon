<?php

   require_once('../../functions.php');
   
   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->order_id)){

            $order_id = $request->order_id;

            $invoices = "SELECT * FROM tbl_invoices WHERE order_id = '$order_id'";
            $invoices = getRaw($invoices);

            if(isset($invoices)){

            	$json = array('status'=>1,'message'=>'data found','data'=>$invoices);
            	
            }else{

            	$json = array('status'=>0,'message'=>'no data Found');

         	}

   }else{
   
         $json = array('status'=>0,'message'=>'Invalid Request');

   }

   echo json_encode($json);
