<?php

   require_once('../../functions.php');

   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->employee_id) && isset($request->customer_id)){
		
		// 1-customer outstanding
		$customer_total_debit = "SELECT  IFNULL(SUM(customer_outstanding_amount),0) as debit_amount FROM tbl_customer_outstanding WHERE customer_id = '".$request->customer_id."' AND customer_outstanding_type = '1' ";
		$customer_total_debit = getRaw($customer_total_debit);   
		$customer_total_debit = $customer_total_debit[0]['debit_amount'];

		$customer_total_credit = "SELECT  IFNULL(SUM(customer_outstanding_amount),0) as credit_amount FROM tbl_customer_outstanding WHERE customer_id = '".$request->customer_id."' AND customer_outstanding_type = '2' ";
		$customer_total_credit = getRaw($customer_total_credit);   
		$customer_total_credit = $customer_total_credit[0]['credit_amount'];

		$customer_outstanding_amount = $customer_total_debit - $customer_total_credit;
		
		// 2 - customer credit limit
		$customer_credit_limit = getOne('tbl_customer','customer_id',$request->customer_id);
		$customer_credit_limit = $customer_credit_limit['customer_credit_limit'];
		
		// 3 - employee total assigned target, employee total achieved target, employee total target remaining
		$target = "SELECT SUM(target_category_amount) as target_amount,employee_id FROM tbl_target WHERE employee_id = '".$request->employee_id."' GROUP BY employee_id ";
	    $target = getRaw($target);

	    $employee_total_target_assigned = "";
	    $employee_total_target_achieved = "";
        $employee_total_target_remaining = "";

	    if(isset($target)){
	      
	      $data = array();
	      
	      foreach($target as $rs){

	            // pre achieved
	            $target_pre_achieved = "SELECT  IFNULL(SUM(target_category_achieved),0) as target_pre_achieved FROM tbl_target WHERE employee_id = '".$rs['employee_id']."' ";
	            $target_pre_achieved = getRaw($target_pre_achieved);
	            $target_pre_achieved = $target_pre_achieved[0]['target_pre_achieved'];

	            // achieved by placing orders
	            $target_achieved = "SELECT det.order_detail_id,det.order_product_discount,det.order_product_igst,det.order_product_sgst,det.order_product_cgst,det.order_product_rate FROM `tbl_order_detail` det INNER JOIN tbl_orders ord ON ord.order_id = det.order_id WHERE ord.employee_id = '".$rs['employee_id']."' ";
	            $target_achieved = getRaw($target_achieved);

	              if(isset($target_achieved)){

	               foreach($target_achieved as $val){

	                    $dispatch_quantity = "SELECT IFNULL(SUM(dispatch_quantity),0) AS dispatch_quantity FROM tbl_invoice_detail WHERE order_detail_id = '".$val['order_detail_id']."' ";
	                    $dispatch_quantity = getRaw($dispatch_quantity);
	                    $dispatch_quantity = $dispatch_quantity[0]['dispatch_quantity'];

	                    $amount = $val['order_product_rate'] * $dispatch_quantity;
	                    $order_product_discount = $val['order_product_discount'];
	                                   
	                    $amount_after_discount = $amount * $order_product_discount / 100 ;
	                    $amount_after_discount = $amount - $amount_after_discount;

	                    
	                   if($val['order_product_igst'] > 0){

	                      $tax = ($val['order_product_igst'] * $amount_after_discount ) / 100;                   

	                   }else{

	                      $sgst_csgt = 0;
	                      $sgst_csgt = $val['order_product_cgst'] * $amount_after_discount  / 100;     
	                      $tax  = $sgst_csgt * 2;
	                    
	                   }

	                   $final_amount += $amount_after_discount + $tax; 
	               
	               }
	            }


            $employee_total_target_assigned = $rs['target_amount'];
            $employee_total_target_achieved = $final_amount + $target_pre_achieved;
            $employee_total_target_achieved = $employee_total_target_achieved;
            $employee_total_target_remaining = $dataset['total_target_assigned'] - $dataset['total_target_achieved'];

	      }
	    }

	    $data = array(
	    	'customer_outstanding' => (string)$customer_outstanding_amount,
	    	'customer_credit_limit' => (string)$customer_credit_limit,
	    	'employee_assigned_target' => (string)$employee_total_target_assigned,
	    	'employee_achieved_target' => (string)$employee_total_target_achieved,
	    	'employee_remaining_target' => (string)$employee_total_target_remaining
	    );
	    $status = 1;
	    $msg = "data found";

   }else{
            
         $status = 0;
         $msg = "invalid request";

   }
   
   $json = array('status'=>$status,'message'=>$msg,'data'=>$data);
   echo json_encode($json);

?>
