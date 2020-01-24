
<?php

   require_once('../../functions.php');
   
   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->employee_id)){

         $employee_id = $request->employee_id;

         $targets = "SELECT employee_id,employee_target_start_date,employee_target_end_date,employee_target_amount,status FROM tbl_employee_target WHERE employee_id = '$employee_id' ";
         $targets = getRaw($targets);

         if(isset($targets) && count($targets) > 0){ 
         
            $i=1; 

            foreach($targets as $rs){ 

                 $employee_name = getOne('tbl_employee','employee_id',$rs['employee_id']);
                 $data['employee_name'] =  $employee_name['employee_name'];
                 $data['employee_target_amount'] =  $rs['employee_target_amount'];
                
                   $start_date = date('Y-m-d', strtotime($rs['employee_target_start_date']));
                   $end_date = date('Y-m-d', strtotime($rs['employee_target_end_date']));

                   $created_at = date('d-m-Y', strtotime($rs[0]['created_at']));

                   $target_achieved = "SELECT sum(employee_order_amount) as target_achieved FROM tbl_employee_target_detail WHERE DATE(created_at) BETWEEN '$start_date' AND '$end_date' AND employee_id = '".$rs['employee_id']."'  ";
                   $target_achieved = getRaw($target_achieved);

                   if(isset($target_achieved[0]['target_achieved'])){
                      $target_achieved_amount = $target_achieved[0]['target_achieved'];  
                   }else{
                      $target_achieved_amount = 0;
                   }

                   $data['target_achieved_amount'] = $target_achieved_amount;
                   $data['start_date'] =  $start_date;
                   $data['end_date'] =  $end_date;

                   if($target_achieved_amount >= $rs['employee_target_amount']){  
                        $data['achieve_status'] = "Achieved";
                   }else{
                        $data['achieve_status'] = "Not Achieved";
                   }
                   
                   $today = date('Y-m-d', strtotime($timestamp));

                   if($today >= $start_date && $today <= $end_date){
                        $data['running_status'] = "Running";
                   }else if($start_date >= $today) {
                        $data['running_status'] = "Awaiting";
                   }else{
                        $data['running_status'] = "Closed";
                   }

                   $data2[] = $data;
            }

            $json = array('status'=>1,'message'=>'Data Found','data'=>$data2);

        }else{

         $json = array('status'=>0,'message'=>'No Data Found');
          
        }

   
   }else{
   
         $json = array('status'=>0,'message'=>'Invalid Request');

   }

   echo json_encode($json);
   