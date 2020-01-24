<?php

 require_once('../../functions.php');
   
 $request = json_decode(file_get_contents('php://input'));
 
 if(isset($request->customer_id)){

     $customer_id = $request->customer_id;

     $total_sales = "SELECT COALESCE(SUM(employee_order_amount),0) as total_sales FROM tbl_employee_target_detail det INNER JOIN tbl_orders ord ON det.employee_order_id = ord.order_id WHERE ord.customer_id = '$customer_id' ";
     $total_sales = getRaw($total_sales);
     $total_sales = $total_sales[0]['total_sales'];   

     $total_amount_received = "SELECT COALESCE(SUM(accounting_amount),0) as total_amount_received FROM tbl_accounting WHERE accounting_party_id = '$customer_id' ";
     $total_amount_received = getRaw($total_amount_received);
     $total_amount_received = $total_amount_received[0]['total_amount_received'];   

     $credit_limit = getOne('tbl_customer','customer_id',$customer_id);
     $credit_limit = $credit_limit['customer_credit_limit'];

     $total_outstaning_amount = $total_sales - $total_amount_received;
     $total_outstaning_amount = $credit_limit - $total_outstaning_amount;
     
     $data = array('total_outstaning_amount'=>$total_outstaning_amount);    
     $json = array('status'=>1,'message'=>'data found','data'=>$data);

}else{

  $json = array('status'=>0,'message'=>'Invalid Request');  

}  

echo json_encode($json);

?>
