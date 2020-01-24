<?php

    require_once("../functions.php");

    $delete_id = $_POST['delete_id'];
    $delete_info = json_decode($_POST['delete_info'], true);

    $i=0;
    $delete_query = "";
    foreach ($delete_info['column'] as $val) {
        
        $column = $val;
        $table = $delete_info['table'][$i];
        $delete_query .= "DELETE FROM $table WHERE $column = '".$delete_id."';";
        $i++;
    
    }

    if(query($delete_query)){
        $status = '1';
    }else{
        $status = '0';
    }

    $data = array('status'=>$status);
    echo json_encode($data);

?>

