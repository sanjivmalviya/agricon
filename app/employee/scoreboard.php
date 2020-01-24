<?php
require_once('../../functions.php');
 
$target_months = getAll('tbl_target_months'); 
$request = json_decode(file_get_contents('php://input'));

if(isset($request->employee_id) && isset($request->year) && isset($request->month)){

   $employee_id = $request->employee_id; 
   $target_year = $request->year; 
   $target_month = $request->month; 
      
   $scroreboard = "SELECT SUM(target_category_amount) as target_amount,employee_id,target_year FROM tbl_target WHERE employee_id = '$employee_id' AND YEAR(created_at) = '$target_year' AND  MONTH(created_at) = '$target_month' GROUP BY target_year,target_month DESC";
   $scroreboard = getRaw($scroreboard);
   
   if(isset($scroreboard)){

      foreach($scroreboard as $rs){

         $year = $rs['target_year'];

         $employee_id = $rs['employee_id'];
         $total_orders = "SELECT COALESCE(COUNT(*),0) as total_order FROM tbl_orders WHERE employee_id = '$employee_id' AND YEAR(updated_at) = $target_year AND MONTH(updated_at) = $target_month";
         $total_orders = getRaw($total_orders);
         $total_orders = $total_orders[0]['total_order'];

         $total_order_amount = "SELECT COALESCE(SUM(employee_order_amount),0) as total_order_amount FROM tbl_employee_target_detail WHERE employee_id = '$employee_id' AND YEAR(created_at) = $target_year AND MONTH(created_at) = $target_month ";
         $total_order_amount = getRaw($total_order_amount);
         $total_order_amount = $total_order_amount[0]['total_order_amount'];

         $employee_name = getOne('tbl_employee','employee_id',$employee_id);
         $rs['employee_name'] = $employee_name['employee_name'];
         $rs['total_orders'] = $total_orders ;
         $rs['total_order_amount'] = number_format($total_order_amount,2);
         $rs['total_outstanding'] = $rs['target_amount'] - $total_order_amount;
         $rs['total_outstanding'] = number_format($rs['total_outstanding'],2);
         if($total_order_amount >= $rs['target_amount']){
            $rs['target_status'] = "Achieved";
            $rs['total_outstanding'] = substr($rs['total_outstanding'],1);
         }else{
            $rs['target_status'] = "Not Achieved";
         }

         if($total_order_amount == 0){
            $rs['percentage'] = 0;
         }else{
            // $percentage = number_format((1 - $total_order_amount / $rs['target_amount'] ) * 100,0);
            // $rs['percentage'] = substr($percentage,1);
            $percentage = ($total_order_amount / $rs['target_amount']) * 100;
            $rs['percentage'] = number_format($percentage,2);                    
         }
         $data[] = $rs;

      }
   }     
   
   if(isset($data)){
      
      function compare($a, $b)
      {
         return ($data['percentage']< $data['percentage']);
      }
      usort($data, "compare");
         
      $json = array('status'=>1,'message'=>"data found",'data'=>$data);


   }else{

      $json = array('status'=>0,'message'=>"no data found");
   }
   
 }else{
   
   $json = array('status'=>0,'message'=>"Invalid Request");
   
 }

 echo json_encode($json);