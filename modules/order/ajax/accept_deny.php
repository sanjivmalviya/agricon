
<?php

   require_once('../../../functions.php');

   $connect = connect();

   $term = $_POST['term'];
   
   $order_id = $_POST['order_id'];

   if($term == 1){

      $update = "UPDATE tbl_orders SET order_approve_status = '1' WHERE order_id = '$order_id' ";
      
      if(query($update)){
         
         $msg = "Approved";
         $status = 1; 
      
      }
      
   }else if($term == 2){

      $update = "UPDATE tbl_orders SET order_approve_status = '0' WHERE order_id = '$order_id' ";
      
      if(query($update)){
         
         $msg = "Not Approved";
         $status = 0; 
      
      }
      
   }

   $json = array('status'=>$status, 'msg'=>$msg);
   echo json_encode($json);


?>