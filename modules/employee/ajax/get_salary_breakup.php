<?php 
	
	 require_once('../../../functions.php');

	 $employee_id = $_POST['vals']['employee_id'];
	 $year = $_POST['vals']['year'];
	 $month = $_POST['vals']['month'];

	 $employee = getOne('tbl_employee','employee_id',$employee_id);

	 // get salary details
	 $employee_monthly_hra = $employee['employee_monthly_hra'];
	 $employee_monthly_da = $employee['employee_monthly_da'];
	 $employee_monthly_extra_allowances = $employee['employee_monthly_extra_allowances'];
	 $employee_monthly_basic_salary = $employee['employee_monthly_basic_salary'];
	 
	 // get leaves
	 $employee_monthly_leaves = "SELECT IFNULL(SUM(days),0) as employee_monthly_leaves FROM employee_applied_leaves WHERE YEAR(from_date) = '".$year."' AND MONTH(from_date) = '".$month."' AND employee_id = '".$employee_id."' AND approve_status = '1' ";
	 $employee_monthly_leaves = getRaw($employee_monthly_leaves);
	 $employee_monthly_leaves = $employee_monthly_leaves[0]['employee_monthly_leaves'];

	 // deduct leaves from basic salary
	 $employee_monthly_leave_amount = ($employee_monthly_basic_salary / 30) * $employee_monthly_leaves;
	 $employee_monthly_nett_salary = $employee_monthly_basic_salary - $employee_monthly_leave_amount;
	 	
	 $data = array(
	 	'employee_monthly_basic_salary' => $employee_monthly_basic_salary,
	 	'employee_monthly_hra' => $employee_monthly_hra,
	 	'employee_monthly_da' => $employee_monthly_da,
	 	'employee_monthly_extra_allowances' => $employee_monthly_extra_allowances,
	 	'employee_monthly_leaves' => $employee_monthly_leaves,
	 	'employee_monthly_leave_amount' => $employee_monthly_leave_amount,
	 	'employee_monthly_nett_salary' => $employee_monthly_nett_salary
	 );

	 echo json_encode($data);

?>