<?php

// error_reporting(1);
session_start();
date_default_timezone_set('Asia/Kolkata');
$timestamp = date('Y-m-d h:i:s');
$baseurl = $_SERVER['SERVER_NAME'];
// $baseurl = $_SERVER['SERVER_NAME']."/project/agricon";

define('ROOT',$baseurl);


// database connection
function connect(){


    $host = 'localhost';

     $user = 'agriconf_erp';

     $password = '#T2l#ZD[(m?m';

     $db = 'agriconf_erp';

    // $host = 'localhost';

    // $user = 'root';

    // $password = '';

    // $db = 'agricon';

    $connect = mysqli_connect($host,$user,$password,$db);

    return $connect;

}



function last_id($table,$field_name){



    $connect = connect();



    $getLastId = "SELECT MAX($field_name) as last_id FROM $table";

    $getLastId = mysqli_query($connect,$getLastId);

    $getLastId = mysqli_fetch_assoc($getLastId);



    return $getLastId['last_id'];



}



// insert into table

function insert($table,$form_data){ 

    $connect = connect();
   

    // retrieve the keys of the array (column titles)

    $fields = array_keys($form_data);



    // build the query

    $sql = "INSERT INTO ".$table."

    (`".implode('`,`', $fields)."`)

    VALUES('".implode("','", $form_data)."')";
    

    // run and return the query result resource

    return mysqli_query($connect,$sql);

}


function update($table,$field_name,$field_value,$form_data) {

    $set = '';

    $x = 1;


    foreach($form_data as $name => $value) {

        $set .= "{$name} = \"{$value}\"";

        if($x < count($form_data)) {

            $set .= ',';

        }

        $x++;

    }


    $sql = "UPDATE {$table} SET {$set} WHERE $field_name = {$field_value}";

    if(query($sql)) {

        return true;

    }



    return false;

}



function sanitize($value){

    

    $connect = connect();

    return mysqli_real_escape_string($connect,$value);



}



// raw query

function query($qry){



    $connect = connect();



    if(mysqli_query($connect,$qry)){

        return 1;

    }else{

        return 0;

    }    



}



// check if record already exists

function delete($table,$field,$field_value){



    $connect = connect();



    $delete = "DELETE FROM $table WHERE $field = '$field_value' ";

    

    if(mysqli_query($connect,$delete)){

        return 1;

    }else{

        return 0;

    }

    

}



function truncate($table_name){



    $connect = connect();



    $query = "TRUNCATE $table_name";

    if(mysqli_query($connect,$query)){

        return 1;

    }else{

        return 0;

    }

}



// auto increment field value

function getIncrement($field,$table,$au_value,$first_laters,$first_laters_value,$total_laters,$default_value){



     $connect = connect();



     $get = "SELECT $field FROM $table ORDER BY $au_value DESC LIMIT 1";

     $get=mysqli_query($connect,$get);



     if($get){

            $rs=mysqli_fetch_assoc($get);

            $PO_sub=$rs[$field];

            $PO = substr($PO_sub , $first_laters);                               

            $PO_count = str_pad($PO + 1,$total_laters,0,STR_PAD_LEFT);

            $PO_ins =  $first_laters_value.$PO_count;

            

      }else{

             $PO_ins = $default_value;

      }



      return $PO_ins;

}



// check if record already exists

function isExists($table,$field,$field_value){



    $connect = connect();



    $check = "SELECT * FROM $table WHERE $field = '$field_value' ";

    $check = mysqli_query($connect,$check);



    if(mysqli_num_rows($check) > 0){

        return 1;

    }else{

        return 0;

    }



}



function sendSMS($mobile_number,$msg){



        //Your authentication key

        $authKey = "100679AO6BL8ElT56c2fb0f";



        //Multiple mobiles numbers separated by comma

        $mobileNumber = $mobile_number;



        //Sender ID,While using route4 sender id should be 6 characters long.

        $senderId = "AHCARE";



        //Your message to send, Add URL encoding here.

        $message = urlencode($msg);



        $route = 4;

        

        //Prepare you post parameters

        $postData = array(

            'authkey' => $authKey,

            'mobiles' => $mobileNumber,

            'message' => $msg,

            'sender' => $senderId,

            'route' => $route

        );



        //API URL

        $url = "https://control.msg91.com/api/sendhttp.php";





        $ch = curl_init();

        curl_setopt_array($ch, array(

            CURLOPT_URL => $url,

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_POST => true,

            CURLOPT_POSTFIELDS => $postData

                //,CURLOPT_FOLLOWLOCATION => true

        ));





        //Ignore SSL certificate verification

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);





        //get response

        $output = curl_exec($ch);



        //Print error if any

        if (curl_errno($ch)) {

            echo 'error:' . curl_error($ch);

        }



        curl_close($ch);



        return 1;

              

}





function generateOTP(){

        $string = '0123456789';

        $string_shuffled = str_shuffle($string);

        $password = substr($string_shuffled, 1, 4);

        $otp = $password;



        return $otp;

}



function generateGUID() {

 

    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',



        // 32 bits for "time_low"

        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),



        // 16 bits for "time_mid"

        mt_rand( 0, 0xffff ),



        // 16 bits for "time_hi_and_version",

        // four most significant bits holds version number 4

        mt_rand( 0, 0x0fff ) | 0x4000,



        // 16 bits, 8 bits for "clk_seq_hi_res",

        // 8 bits for "clk_seq_low",

        // two most significant bits holds zero and one for variant DCE1.1

        mt_rand( 0, 0x3fff ) | 0x8000,



        // 48 bits for "node"

        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )

    );



}



function getCount($table,$delete_status=""){



    $connect = connect();

    

    if(isset($delete_status) && $delete_status != ""){





        $get = "SELECT * FROM $table WHERE delete_status = '$delete_status' ";

        if($get = mysqli_query($connect,$get)){

    

            $get = mysqli_num_rows($get);

            return $get;

        }else{

            return 0;

        }

        

    }else{



        $get = "SELECT * FROM $table";

        if($get = mysqli_query($connect,$get)){

    

            $get = mysqli_num_rows($get);

            return $get;

        }else{

            return 0;

        }



    }



}



function getCountWhere($table,$condition){



    $connect = connect();



    $get = "SELECT * FROM $table WHERE $condition ";

    if($get = mysqli_query($connect,$get)){

                        

        $get = mysqli_num_rows($get);

        return $get;

    }else{

        return 0;

    }



}



// single record

function getOne($table,$field,$field_value){



    $connect = connect();



    $get = "SELECT * FROM $table WHERE $field = '$field_value' ";

    $get = mysqli_query($connect,$get);

    $get = mysqli_fetch_assoc($get);



    return $get;



}



// where condition

function getWhere($table,$where,$field){



    $connect = connect();



    $get = "SELECT * FROM $table WHERE $where = '$field'";

    

    $get = mysqli_query($connect,$get);

    if(mysqli_num_rows($get) > 0){

        while($rs = mysqli_fetch_assoc($get)){

            $data[] = $rs;

        }

    }else{

        $data = null;

    }



    return $data;



}



// all records

function getRaw($query){



        $connect = connect();



        $get = mysqli_query($connect,$query);

        if(mysqli_num_rows($get) > 0){

            while($rs = mysqli_fetch_assoc($get)){

                $data[] = $rs;

            }

        }else{

            $data = null;

        }



        return $data;

}



// all records

function getAll($table){



        $connect = connect();



        $query = "SELECT * FROM $table";

        $get = mysqli_query($connect,$query);

        if(mysqli_num_rows($get) > 0){

            while($rs = mysqli_fetch_assoc($get)){

                $data[] = $rs;

            }

        }else{

            $data = null;

        }



        return $data;

}



function getAllByOrder($table,$field_name,$ordering){



        $connect = connect();



        $query = "SELECT * FROM $table ORDER BY $field_name $ordering ";

        $get = mysqli_query($connect,$query);

        if(mysqli_num_rows($get) > 0){

            while($rs = mysqli_fetch_assoc($get)){

                $data[] = $rs;

            }

        }else{

            $data = null;

        }



        return $data;

}



function file_upload($name,$allowed_extensions,$target_path,$file_prefix=""){

    

    $files = "";

    if($name['error'][0] != '4'){

        

    $file_error = 0;

    $i=0;

    foreach($name['name'] as $value) {



        $ext = explode(".", $value);

        if(!in_array(end($ext), $allowed_extensions)){

           $file_error = 1;

        }

    }



    if($file_error == 0){



      if($file_prefix == ""){

        $file_prefix = "FILE_";

      }



      foreach ($name['name'] as $value){

          $uniqid = uniqid();

          $ext = explode(".", $value);

          $ext = end($ext);

          $filename = $file_prefix.$uniqid.".".$ext;

          move_uploaded_file($name['tmp_name'][$i], $target_path.$filename);

          $files_path[] = $target_path.$filename;

          $i++;

      }



      $files = $files_path;

      }

    

    }



    $data = array('error'=>$file_error,'files'=>$files);

    return $data;

}



function randomPassword() {

    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

    $pass = array(); //remember to declare $pass as an array

    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

    for ($i = 0; $i < 8; $i++) {

        $n = rand(0, $alphaLength);

        $pass[] = $alphabet[$n];

    }

    return implode($pass); //turn the array into a string

}



function deleteById($table_name,$field_name,$field_value){



    $query = "DELETE FROM $table_name WHERE $field_name = '$field_value' ";

    if(mysqli_query($query,$connect)){

        return 1;

    }else{

        return 0;

    }



}



function selectWhereMultiple($table_name,$where,$order="ASC"){



    $connect = connect();

    

    $condition = "";

    $i=1;

    $count = count($where);



    foreach ($where as $key => $value) {



        if($i == $count){

            $condition .= $key."='".$value."' ";            

        }else{

            $condition .= $key."='".$value."' AND ";

        }

        $i++;

    }



    $query = "SELECT * FROM $table_name WHERE ".$condition." ORDER BY created_at $order";

    $query = mysqli_query($connect,$query);

    if(mysqli_num_rows($query) > 0){

        while($rs = mysqli_fetch_assoc($query)){



            $data[] = $rs;



        }

    }else{

        $data = null;

    }



    return $data;

}



function time_ago($ts){



    if(!ctype_digit($ts))



        $ts = strtotime($ts);







    $diff = time() - $ts;



    if($diff == 0)



        return 'now';



    elseif($diff > 0)



    {



        $day_diff = floor($diff / 86400);



        if($day_diff == 0)



        {



            if($diff < 60) return 'just now';



            if($diff < 120) return '1 minute ago';



            if($diff < 3600) return floor($diff / 60) . ' minutes ago';



            if($diff < 7200) return '1 hour ago';



            if($diff < 86400) return floor($diff / 3600) . ' hours ago';



        }



        if($day_diff == 1) return 'Yesterday';



        if($day_diff < 7) return $day_diff . ' days ago';



        if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';



        if($day_diff < 60) return 'last month';



        return date('F Y', $ts);



    }



    else



    {



        $diff = abs($diff);



        $day_diff = floor($diff / 86400);



        if($day_diff == 0)



        {



            if($diff < 120) return 'in a minute';



            if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';



            if($diff < 7200) return 'in an hour';



            if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';



        }



        if($day_diff == 1) return 'Tomorrow';



        if($day_diff < 4) return date('l', $ts);



        if($day_diff < 7 + (7 - date('w'))) return 'next week';



        if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';



        if(date('n', $ts) == date('n') + 1) return 'next month';



        return date('F Y', $ts);



    }



}



function send_notification($sender_user_type,$sender_id,$receiver_user_type,$receiver_id,$notification_title,$notification_description){



      // feed notification

      $form_data = array(

         'notification_sender_user_type' => $sender_user_type,

         'notification_sender_user_id' => $sender_id,

         'notification_receiver_user_type' => $receiver_user_type ,

         'notification_receiver_user_id' => $receiver_id,

         'notification_title' => $notification_title, 

         'notification_description' => $notification_description 

      );

      insert('tbl_notifications',$form_data);



}



function dateDiff($date1, $date2) 

{

    $date1_ts = strtotime($date1);

    $date2_ts = strtotime($date2);

    $diff = $date2_ts - $date1_ts;

    return abs(round($diff / 86400));

}
