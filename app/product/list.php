<?php

   require_once('../../functions.php');

   $products = getAll('tbl_product');

   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->employee_id)){

      $products = "SELECT * FROM tbl_product p INNER JOIN tbl_employee s ON p.added_by = s.added_by WHERE s.employee_id = ".$request->employee_id."  ";
      $products = getRaw($products);

      foreach($products as $rs){
         
          $data[] = $rs;

      }
       
      $json = array('status' => 1 , 'message' => 'data found' , 'data' => $data);

   }else{
   			
   		$json = array('status' => 0 , 'message' => 'No data found');

	}
   
   echo json_encode($json);

?>