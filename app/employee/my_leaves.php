<?php

   require_once('../../functions.php');
   
   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->employee_id)){

        $employee_id = $request->employee_id; 

        $get = "SELECT * FROM employee_applied_leaves WHERE employee_id = '".$employee_id."' ORDER BY created_at DESC ";
        $get = getRaw($get);

        if(count($get) > 0){

            $data = $get;

            $status = 1;
            $message = "found";

        }else{
        
            $status = 0;
            $message = "not found";

        }
      
   }else{

         $status = 0;
         $message = "Invalid Request";


   }



   $data = array('status' => $status, 'message' => $message, 'data' => $data);

   echo json_encode($data);



?>
