
<?php
	
   require_once('../../functions.php');
   
   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->employee_id)){

          $year = $request->year;
          $month = $request->month;
          $employee_id = $request->employee_id;

          if(isset($year) && $year != "" && isset($month) && $month != ""){
          
             $target_assigned = "SELECT target_category_id,COALESCE(SUM(target_category_amount),0) as target_assigned,employee_id FROM tbl_target WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = '$month' AND employee_id = '$employee_id' GROUP BY target_category_id,employee_id";
             $target_assigned = getRaw($target_assigned);

             if(isset($target_assigned)){
               foreach($target_assigned as $rs){

                   $dataset['target_category_id'] = $rs['target_category_id'];
                   // $dataset['employee_id'] = $rs['employee_id'];
                   $dataset['target_assigned'] = $rs['target_assigned'];

                   $target_achieved = "SELECT det.order_detail_id,det.order_product_igst,det.order_product_sgst,det.order_product_cgst,det.order_product_rate FROM `tbl_order_detail` det INNER JOIN tbl_product pro ON det.order_product_id  = pro.product_id INNER JOIN tbl_category cat ON cat.category_id = pro.category_id INNER JOIN tbl_target tgt ON tgt.target_category_id = cat.category_id WHERE tgt.employee_id = '$employee_id' AND cat.category_id = '".$rs['target_category_id']."' AND YEAR(det.created_at) = '$year' AND MONTH(det.created_at) = '$month' ";
                   
                   $target_achieved = getRaw($target_achieved);

                   if(isset($target_achieved)){

                       foreach($target_achieved as $val){

                           $dispatch_quantity = "SELECT SUM(dispatch_quantity) AS dispatch_quantity FROM tbl_invoice_detail WHERE order_detail_id = '".$val['order_detail_id']."' ";
                           $dispatch_quantity = getRaw($dispatch_quantity);

                           if(isset($dispatch_quantity)){
                             $dispatch_quantity = $dispatch_quantity[0]['dispatch_quantity'];
                           }else{
                             $dispatch_quantity = 0;
                           }

                           $amount = $val['order_product_rate'] * $dispatch_quantity;
                           $tax = ($val['order_product_igst'] + $val['order_product_cgst'] + $val['order_product_sgst'] * $amount ) / 100;
                           $final_amount += $amount + $tax; 
                       }

                       $dataset['target_achieved'] = $final_amount;

                   }else{

                       $dataset['target_achieved'] = 0;

                   }

                   if($dataset['target_achieved'] > $dataset['target_assigned']){

                       $target_status = "Achieved";
                       $dataset['target_pending'] = "+".$dataset['target_achieved'] - $dataset['target_assigned'];

                   }else{
                     
                       $target_status = "Pending";
                       $dataset['target_pending'] = $dataset['target_assigned'] - $dataset['target_achieved'];
                     
                   }
                   
                   $dataset['target_assigned'] = number_format($dataset['target_assigned'],2);
                   $dataset['target_achieved'] = number_format($dataset['target_achieved'],2);
                   $dataset['target_pending'] = number_format($dataset['target_pending'],2);

                   $data[] = $dataset;

               }

             }

          }else{

             $target_assigned = "SELECT target_category_id,COALESCE(SUM(target_category_amount),0) as target_assigned,employee_id FROM tbl_target WHERE employee_id = '$employee_id' GROUP BY target_category_id,employee_id";
             $target_assigned = getRaw($target_assigned);

             if(isset($target_assigned)){
               foreach($target_assigned as $rs){

                   $dataset['target_category_id'] = $rs['target_category_id'];
                   // $dataset['employee_id'] = $rs['employee_id'];
                   $dataset['target_assigned'] = $rs['target_assigned'];

                   $target_achieved = "SELECT det.order_detail_id,det.order_product_igst,det.order_product_sgst,det.order_product_cgst,det.order_product_rate FROM `tbl_order_detail` det INNER JOIN tbl_product pro ON det.order_product_id  = pro.product_id INNER JOIN tbl_category cat ON cat.category_id = pro.category_id INNER JOIN tbl_target tgt ON tgt.target_category_id = cat.category_id WHERE tgt.employee_id = '$employee_id' AND cat.category_id = '".$rs['target_category_id']."' ";
                   
                   $target_achieved = getRaw($target_achieved);

                   if(isset($target_achieved)){

                       foreach($target_achieved as $val){

                           $dispatch_quantity = "SELECT SUM(dispatch_quantity) AS dispatch_quantity FROM tbl_invoice_detail WHERE order_detail_id = '".$val['order_detail_id']."' ";
                           $dispatch_quantity = getRaw($dispatch_quantity);

                           if(isset($dispatch_quantity)){
                             $dispatch_quantity = $dispatch_quantity[0]['dispatch_quantity'];
                           }else{
                             $dispatch_quantity = 0;
                           }

                           $amount = $val['order_product_rate'] * $dispatch_quantity;
                           $tax = ($val['order_product_igst'] + $val['order_product_cgst'] + $val['order_product_sgst'] * $amount ) / 100;
                           $final_amount += $amount + $tax; 
                       }

                       $dataset['target_achieved'] = $final_amount;

                   }else{

                       $dataset['target_achieved'] = 0;

                   }

                   if($dataset['target_achieved'] > $dataset['target_assigned']){

                       $target_status = "Achieved";
                       $dataset['target_pending'] = "+".$dataset['target_achieved'] - $dataset['target_assigned'];

                   }else{
                     
                       $target_status = "Pending";
                       $dataset['target_pending'] = $dataset['target_assigned'] - $dataset['target_achieved'];
                     
                   }
                   
                   $dataset['target_assigned'] = number_format($dataset['target_assigned'],2);
                   $dataset['target_achieved'] = number_format($dataset['target_achieved'],2);
                   $dataset['target_pending'] = number_format($dataset['target_pending'],2);

                   $data[] = $dataset;

               }

             }

          }
       

          if(isset($data)){

              $json = array('status' =>1,'message'=>'data found','data'=>$data);

          }else{
            
              $json = array('status' =>0,'message'=>'no data found');

          }

   }else{
   
         $json = array('status'=>0,'message'=>'Invalid Request');

   }

   echo json_encode($json);
   