<?php

   require_once('../../functions.php');
   
   $request = json_decode(file_get_contents('php://input'));

   if(isset($request->username) && isset($request->password)){

   		$username = $request->username;
   		$password = $request->password;

   		$where = array('employee_email' => $username, 'employee_password' => $password);
   		$get = selectWhereMultiple('tbl_employee',$where);
         
   		$data = array();	

   		if(isset($get) && count($get) > 0 ){
   			
   		$data['employee_id'] = $get[0]['employee_id'];
			$data['added_by'] = $get[0]['added_by'];
			$data['employee_name'] = $get[0]['employee_name'];
			$data['employee_designation'] = $get[0]['employee_designation'];
			$data['employee_hq'] = $get[0]['employee_hq'];
			$data['employee_mobile'] = $get[0]['employee_mobile'];
			$data['employee_doj'] = $get[0]['employee_doj'];
			$data['employee_dob'] = $get[0]['employee_dob'];
			$data['employee_pan'] = $get[0]['employee_pan'];
			$data['employee_email'] = $get[0]['employee_email'];
			$data['employee_aadhaar'] = $get[0]['employee_aadhaar'];
			$data['employee_aadhaar_number'] = $get[0]['employee_aadhaar_number'];
			$data['employee_spouse_name'] = $get[0]['employee_spouse_name'];
			$data['employee_spouse_mobile'] = $get[0]['employee_spouse_mobile'];
         $data['employee_type'] = $get[0]['employee_type'];
         $data['employee_order_access'] = $get[0]['employee_order_access'];
			$data['created_at'] = $get[0]['created_at'];

   			$json = array('status' => 1 , 'message' => 'data found' , 'data' => $data);
          
   		}else{
   			
   			$json = array('status' => 0 , 'message' => 'No data found');

   		}

   
   }else{

		$json = array('status' => 0 , 'message' => 'invalid request');
   	
   }

   echo json_encode($json);

?>
