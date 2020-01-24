

<?php

   require_once('../../functions.php');

   

   $request = json_decode(file_get_contents('php://input'));



   if(isset($request->employee_id)){



          $employee_id = $request->employee_id;



          if(isset($request->month) && $request->month != "" && isset($request->year) && $request->year != ""){

            $month =  $request->month;

            $year = $request->year;            

            $start_date = $year."-".$month."-01";
            $end_date = date("Y-m-t", strtotime($start_date));
            $today_day = date('d-m-Y');

            $total_days_left_in_month = dateDiff($today_day,$end_date);

          }else{

            $month =  date('m');

            $year = date('Y');

            $today_day = date('d');

            $total_days_in_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);

            $total_days_left_in_month = $total_days_in_month - $today_day;

          }

          // Employee's target by current month           
          $target_assigned = "SELECT COALESCE(SUM(target_category_amount),0) as target_assigned FROM tbl_target WHERE employee_id = '$employee_id' AND YEAR(created_at) = '$year' AND MONTH(created_at) = '$month' ";

          $target_assigned = getRaw($target_assigned);

          $dataset['total_target'] = $target_assigned[0]['target_assigned'];


          $target_achieved = "SELECT COALESCE(SUM(employee_order_amount),0) as total_achieved FROM tbl_employee_target_detail WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = '$month' AND employee_id = '$employee_id' ";

          $target_achieved = getRaw($target_achieved);

          

          $dataset['total_achieved'] = $target_achieved[0]['total_achieved'];

          

          if($dataset['total_achieved'] > $dataset['total_target']){



              $dataset['target_status'] = "Achieved";

              $dataset['target_pending'] = "+".$dataset['total_achieved'] - $dataset['total_target'];



          }else{

            

              $dataset['target_status'] = "Pending";

              $dataset['target_pending'] = $dataset['total_target'] - $dataset['total_achieved'];

            

          }



          $dataset['target_pending'] = number_format($dataset['target_pending'],2);

          $dataset['days_left'] = json_encode($total_days_left_in_month);

          $data[] = $dataset;



          if(isset($data)){



              $json = array('status' =>1,'message'=>'data found','data'=>$data);



          }else{

            

              $json = array('status' =>0,'message'=>'no data found');



          }



   }else{

   

         $json = array('status'=>0,'message'=>'Invalid Request');



   }



   echo json_encode($json);

   
