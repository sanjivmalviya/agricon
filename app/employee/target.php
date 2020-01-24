<?php

   require_once('../../functions.php');

   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->employee_id)){



	        $employee_id = $request->employee_id;

	        $year = $request->year;

	        $month = $request->month;



	        if($year != "" && $month != ""){

	        // by year and month



	        	  $target_month =  $month;

		          $target_year =  $year;

		          

		          $annuall_rankings = "SELECT SUM(target_category_amount) as target_amount,employee_id,target_year FROM tbl_target WHERE employee_id = '$employee_id' AND target_year = '$target_year' AND  target_month = '$target_month' GROUP BY target_year ORDER BY target_id DESC";

		          $annuall_rankings = getRaw($annuall_rankings);

		          

		          if(isset($annuall_rankings)){

		         

		            foreach($annuall_rankings as $rs){



		               $year = $rs['target_year'];

		               $employee_id = $rs['employee_id'];



		               $total_orders = "SELECT COALESCE(COUNT(*),0) as total_order FROM tbl_orders WHERE employee_id = '$employee_id' AND YEAR(updated_at) = $target_year AND MONTH(updated_at) = $target_month";

		               $total_orders = getRaw($total_orders);

		               $total_orders = $total_orders[0]['total_order'];



		               $total_order_amount = "SELECT COALESCE(SUM(employee_order_amount),0) as total_order_amount FROM tbl_employee_target_detail WHERE employee_id = '$employee_id' AND YEAR(created_at) = $target_year AND MONTH(created_at) = $target_month ";

		               $total_order_amount = getRaw($total_order_amount);

		               $total_order_amount = $total_order_amount[0]['total_order_amount'];



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

		                  $percentage = number_format((1 - $total_order_amount / $rs['target_amount'] ) * 100,0);

		                  $rs['percentage'] = substr($percentage,1);                    

		               }

		               $data[] = $rs;



		            }

		         }





	        }else if($year != ""){

	        // by year 



	        	  $target_year = $year;



	        	  $annuall_rankings = "SELECT SUM(target_category_amount) as target_amount,employee_id,target_year FROM tbl_target WHERE employee_id = '$employee_id' AND target_year = '$target_year' GROUP BY target_year ORDER BY target_id DESC";

		          $annuall_rankings = getRaw($annuall_rankings);



		         if(isset($annuall_rankings)){

		         

		            foreach($annuall_rankings as $rs){



		               $year = $rs['target_year'];

		               $employee_id = $rs['employee_id'];

		               $total_orders = "SELECT COALESCE(COUNT(*),0) as total_order FROM tbl_orders WHERE employee_id = '$employee_id' AND YEAR(updated_at) = $target_year";

		               $total_orders = getRaw($total_orders);

		               $total_orders = $total_orders[0]['total_order'];



		               $total_order_amount = "SELECT COALESCE(SUM(employee_order_amount),0) as total_order_amount FROM tbl_employee_target_detail WHERE employee_id = '$employee_id' AND YEAR(created_at) = $target_year ";

		               $total_order_amount = getRaw($total_order_amount);

		               $total_order_amount = $total_order_amount[0]['total_order_amount'];



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

		                  $percentage = number_format((1 - $total_order_amount / $rs['target_amount'] ) * 100,0);

		                  $rs['percentage'] = substr($percentage,1);                    

		               }

		               $data[] = $rs;



		            }

		         }

	        

	        }else{

	        // by default 

	        	

	        	$annuall_rankings = "SELECT SUM(target_category_amount) as target_amount,employee_id,target_year FROM tbl_target WHERE employee_id = '$employee_id' GROUP BY target_year ORDER BY target_id DESC";

			    $annuall_rankings = getRaw($annuall_rankings);



			    if(isset($annuall_rankings)){



			      foreach($annuall_rankings as $rs){



			            $year = $rs['target_year'];

			            $employee_id = $rs['employee_id'];

			            $total_orders = "SELECT COALESCE(COUNT(*),0) as total_order FROM tbl_orders WHERE employee_id = '$employee_id' AND YEAR(updated_at) = $year ";

			            $total_orders = getRaw($total_orders);

			            $total_orders = $total_orders[0]['total_order'];



			            $total_order_amount = "SELECT COALESCE(SUM(employee_order_amount),0) as total_order_amount FROM tbl_employee_target_detail WHERE employee_id = '$employee_id' AND YEAR(created_at) = $year ";

			            $total_order_amount = getRaw($total_order_amount);

			            $total_order_amount = $total_order_amount[0]['total_order_amount'];



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

			               $percentage = number_format((1 - $total_order_amount / $rs['target_amount'] ) * 100,0);

			               $rs['percentage'] = substr($percentage,1);                    

			            }

			            $data[] = $rs;



			      }

			    }



	        }



	        if(isset($data)){

   

			   function compare($a, $b)

			   {

			      return ($data['percentage']< $data['percentage']);

			   }

			   usort($data, "compare");



		        $json = array('status'=>1,'message'=>'data found','data'=>$data);

			   

			}else{



		        $json = array('status'=>0,'message'=>'no data found');



			}



   

   }else{

   

         $json = array('status'=>0,'message'=>'Invalid Request');



   }



   echo json_encode($json);

   
