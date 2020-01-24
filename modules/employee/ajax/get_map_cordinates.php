<?php 

  require_once('../../../functions.php');

  if(isset($_POST['routine_id']) && $_POST['routine_id'] != ""){

    $routine = getOne('tbl_marketing_employee_routine','routine_id',$_POST['routine_id']);

    $dataset[] = array('lat'=>$routine['latitude_in'],'lng'=>$routine['longitude_in']);

    $routine_details = getWhere('tbl_marketing_employee_routine_meeting','routine_id',$_POST['routine_id']);
    foreach($routine_details as $rs){
      $dataset[] = array('lat'=>$rs['latitude'],'lng'=>$rs['longitude']);
    }

    $cordinates = json_encode($dataset, JSON_NUMERIC_CHECK);

  }else{
    
    $cordinates = "no data found";

  }

  echo $cordinates;
  
?>