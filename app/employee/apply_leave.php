<?php

   require_once('../../functions.php');
   
   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->employee_id) && isset($request->from_date)){

        $employee_id = $request->employee_id; 
        $from_date = $request->from_date; 
        $to_date = $request->to_date; 
     
        if(isset($to_date) && $to_date != ""){
           $days = dateDiff($from_date,$to_date) + 1; 
        }else{
          $days = 1;
        }


        $check = "SELECT * FROM employee_applied_leaves WHERE employee_id = '".$employee_id."' AND from_date = '".$from_date."' ";

        if(count(getRaw($check)) > 0){

            $status = 0;
            $message = "oops ! you have already applied for particular dates";

        }else if($days > 3){
        
            $status = 0;
            $message = "sorry ! you are not allowed to take leave for more than 3 days";

        }else{        

              $form_data = array(
                 "employee_id" => $employee_id,
                 "from_date" => $from_date,
                 "to_date" => $to_date,
                 "days" => $days
              );
             
             if(insert('employee_applied_leaves',$form_data)){

                $status = 1;
                $message = "Leave Application Sent successfully";

             }else{

                $status = 0;
                $message = "Failed to sent leave application";

             }
         
        }

   }else{

         $status = 0;
         $message = "Invalid Request";


   }



   $data = array('status' => $status, 'message' => $message);

   echo json_encode($data);



?>
