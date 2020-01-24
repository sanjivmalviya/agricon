
<?php
  
   require_once('../../functions.php');
   
   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->employee_id)){

          $employee_id = $request->employee_id;

          $month_names = array(            
           '1' => 'January', 
           '2' => 'February', 
           '3' => 'March', 
           '4' => 'April', 
           '5' => 'May', 
           '6' => 'June', 
           '7' => 'July ', 
           '8' => 'August', 
           '9' => 'September', 
           '10' => 'October', 
           '11' => 'November', 
           '12' => 'December');
          
          // total sales by months 
          $total_sales_by_months = "SELECT MONTH(created_at) as month,COALESCE(SUM(employee_order_amount),0) as total_sales FROM `tbl_employee_target_detail` WHERE employee_id = '$employee_id' GROUP BY MONTH(created_at)";
          
          $total_sales_by_months = getRaw($total_sales_by_months);

          foreach ($total_sales_by_months as $rs) {

              $dataset['month'] = $rs['month']; 
              $dataset['month_name'] = $month_names[$rs['month']]; 
              $dataset['total_sales'] = $rs['total_sales']; 
              $data[] = $dataset;

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
   