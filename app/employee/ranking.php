
<?php

   require_once('../../functions.php');

   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->employee_id)){

     if(isset($request->start_date) && isset($request->end_date) && $request->start_date !="" && $request->end_date != ""){

       $start_date = $request->start_date;
       $end_date = $request->end_date;
    
    }else{
       
       $start_date = date('Y-m-01'); // hard-coded '01' for first day
       $end_date  = date('Y-m-t');
    
    }

    $admin_id = getOne('tbl_employee','employee_id',$request->employee_id);
    $admin_id = $admin_id['added_by'];

    $targets = "SELECT target.employee_id,SUM(target.employee_order_amount) as total_sales,COUNT(*) as total_orders FROM tbl_employee_target_detail target INNER JOIN tbl_employee sales ON target.employee_id = sales.employee_id WHERE sales.added_by = '$admin_id' AND DATE(target.created_at) BETWEEN '$start_date' AND '$end_date' GROUP BY target.employee_id ORDER BY total_sales DESC ";
    
    $targets = getRaw($targets); 

    if(isset($targets) && count($targets) > 0){ 

        $grand_orders = 0;
        $grand_total = 0;
        $i=1;

        foreach($targets as $rs){

          
          $employee_name = getOne('tbl_employee','employee_id',$rs['employee_id']);

          $data['rank'] = $i; 
          $data['employee_name'] = $employee_name['employee_name']; 
          $data['total_orders'] = $rs['total_orders'];            
          $data['total_sales'] = $rs['total_sales'];

          $grand_orders += $rs['total_orders'];
          $grand_total += $rs['total_sales']; 

          $data2[] = $data;
          $i++;

      }

        $json = array('status'=>1,'message'=>'Data Found','data'=>$data2,'total_orders'=>$grand_orders,'total_sales'=> number_format($grand_total,2));
     
  }else{

    $json = array('status'=>0,'message'=>'No Data Found');
 
  } 

 }else{

     $json = array('status'=>0,'message'=>'Invalid Request');

 }

 echo json_encode($json);
   