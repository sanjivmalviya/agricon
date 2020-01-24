

<?php



   require_once('../../functions.php');



   $login_id = $_SESSION['agricon_credentials']['user_id'];

   

   if($_SESSION['agricon_credentials']['user_type'] == 2){



      $employees = getWhere('tbl_employee','added_by',$login_id);



   }else{



     $employees = getAll('tbl_employee');

    

   }

 

   $table_name = 'tbl_customer';

   $field_name = 'customer_id';



   if(isset($_POST['submit'])){



    if(isset($_POST['dealer_deposit'])){

      $dealer_deposit = 1;

    }else{     

      $dealer_deposit = 0;

    }



    if(isset($_POST['dealer_security_cheque'])){

      $dealer_security_cheque = 1;

    }else{     

      $dealer_security_cheque = 0;

    }





     // FILE DATA 

     $name = $_FILES['customer_aadhaar'];

     $allowed_extensions = array('jpg','jpeg','png','gif');

     $target_path = "../../uploads/aadhaar/";

     $file_prefix = "IMG_";

     $upload = file_upload($name,$allowed_extensions,$target_path,$file_prefix);



     if($upload['error'] == 1){

     

         $error = "Failed to Upload files, try again later";

     

     }else{



        if(isset($upload['files']) && $upload['files'] !=""){

          

         foreach($upload['files'] as $rs){



             $form_data = array(

              'added_by' => $login_id, // current admin id 

              'party_handled_by' => $_POST['party_handled_by'], // Employee who handles it 

              'customer_name' => $_POST['customer_name'], 

              'customer_address' => $_POST['customer_address'], 

              'customer_at' => $_POST['customer_at'], 

              'customer_taluka' => $_POST['customer_taluka'], 

              'customer_district' => $_POST['customer_district'], 

              'customer_pincode' => $_POST['customer_pincode'], 

              'customer_email' => $_POST['customer_email'], 

              'customer_landline' => $_POST['customer_landline'], 

              'customer_mobile' => $_POST['customer_mobile'], 

              'customer_gst' => $_POST['customer_gst'], 

              'customer_gst_type' => $_POST['customer_gst_type'], 

              'customer_credit_limit' => $_POST['customer_credit_limit'], 

              'customer_credit_limit_days' => $_POST['customer_credit_limit_days'], 

              'customer_mode_of_payment' => $_POST['customer_mode_of_payment'], 

              'customer_discount' => $_POST['customer_discount'], 

              'customer_pan' => $_POST['customer_pan'], 

              'customer_dob' => $_POST['customer_dob'], 

              'customer_doj' => $_POST['customer_doj'], 

              'customer_fertilizer_lic' => $_POST['customer_fertilizer_lic'], 

              'customer_pesticide_lic' => $_POST['customer_pesticide_lic'], 

              'customer_seed_lic' => $_POST['customer_seed_lic'], 

              'contact_person_name' => $_POST['contact_person_name'], 

              'customer_aadhaar' => $rs, 

              'customer_aadhaar_number' => $_POST['customer_aadhaar_number'], 

              'dealer_deposit' => $dealer_deposit, 

              'dealer_security_cheque' => $dealer_security_cheque, 

              'dealer_amount' => $_POST['dealer_amount'], 

              'dealer_cheque_number' => $_POST['dealer_cheque_number'], 

              'dealer_bank_name' => $_POST['dealer_bank_name'], 

              'dealer_ifsc_code' => $_POST['dealer_ifsc_code'],

            );

             

             

         }



     }else{



      $form_data = array(

              'added_by' => $login_id, // current admin id 

              'party_handled_by' => $_POST['party_handled_by'], // Employee who handles it 

              'customer_name' => $_POST['customer_name'], 

              'customer_address' => $_POST['customer_address'], 

              'customer_at' => $_POST['customer_at'], 

              'customer_taluka' => $_POST['customer_taluka'], 

              'customer_district' => $_POST['customer_district'], 

              'customer_pincode' => $_POST['customer_pincode'], 

              'customer_email' => $_POST['customer_email'], 

              'customer_landline' => $_POST['customer_landline'], 

              'customer_mobile' => $_POST['customer_mobile'], 

              'customer_gst' => $_POST['customer_gst'], 

              'customer_gst_type' => $_POST['customer_gst_type'], 

              'customer_credit_limit' => $_POST['customer_credit_limit'], 

              'customer_credit_limit_days' => $_POST['customer_credit_limit_days'], 

              'customer_mode_of_payment' => $_POST['customer_mode_of_payment'], 

              'customer_discount' => $_POST['customer_discount'], 

              'customer_pan' => $_POST['customer_pan'], 

              'customer_dob' => $_POST['customer_dob'], 

              'customer_doj' => $_POST['customer_doj'], 

              'customer_fertilizer_lic' => $_POST['customer_fertilizer_lic'], 

              'customer_pesticide_lic' => $_POST['customer_pesticide_lic'], 

              'customer_seed_lic' => $_POST['customer_seed_lic'], 

              'contact_person_name' => $_POST['contact_person_name'], 

              'customer_aadhaar_number' => $_POST['customer_aadhaar_number'], 

              'dealer_deposit' => $dealer_deposit, 

              'dealer_security_cheque' => $dealer_security_cheque, 

              'dealer_amount' => $_POST['dealer_amount'], 

              'dealer_cheque_number' => $_POST['dealer_cheque_number'], 

              'dealer_bank_name' => $_POST['dealer_bank_name'], 

              'dealer_ifsc_code' => $_POST['dealer_ifsc_code'],

            );


     }



     if(insert('tbl_customer',$form_data)){

         $success = "Customer Added Successfully";

     }else{

         $error = "Failed to add Customer, try again later";

         unlink($rs);

     }



  }      



}



   if(isset($_GET['edit_id'])){



         $edit_data = getOne($table_name,$field_name,$_GET['edit_id']);

         $edit_data = array(

              'party_handled_by' => $edit_data['party_handled_by'], // Employee who handles it 

              'customer_name' => $edit_data['customer_name'], 

              'customer_address' => $edit_data['customer_address'], 

              'customer_at' => $edit_data['customer_at'], 

              'customer_taluka' => $edit_data['customer_taluka'], 

              'customer_district' => $edit_data['customer_district'], 

              'customer_pincode' => $edit_data['customer_pincode'], 

              'customer_email' => $edit_data['customer_email'], 

              'customer_landline' => $edit_data['customer_landline'], 

              'customer_mobile' => $edit_data['customer_mobile'], 

              'customer_gst' => $edit_data['customer_gst'], 

              'customer_gst_type' => $edit_data['customer_gst_type'], 
              
              'customer_discount' => $edit_data['customer_discount'], 

              'customer_credit_limit' => $edit_data['customer_credit_limit'], 

              'customer_credit_limit_days' => $edit_data['customer_credit_limit_days'], 

              'customer_mode_of_payment' => $edit_data['customer_mode_of_payment'], 

              'customer_pan' => $edit_data['customer_pan'], 

              'customer_dob' => $edit_data['customer_dob'], 

              'customer_doj' => $edit_data['customer_doj'], 

              'customer_fertilizer_lic' => $edit_data['customer_fertilizer_lic'], 

              'customer_pesticide_lic' => $edit_data['customer_pesticide_lic'], 

              'customer_seed_lic' => $edit_data['customer_seed_lic'], 

              'contact_person_name' => $edit_data['contact_person_name'], 

              'customer_aadhaar_number' => $edit_data['customer_aadhaar_number'], 

              'dealer_deposit' => $edit_data['dealer_deposit'], 

              'dealer_security_cheque' => $edit_data['dealer_security_cheque'], 

              'dealer_amount' => $edit_data['dealer_amount'], 

              'dealer_cheque_number' => $edit_data['dealer_cheque_number'], 

              'dealer_bank_name' => $edit_data['dealer_bank_name'], 

              'dealer_ifsc_code' => $edit_data['dealer_ifsc_code'],

            );



   }



   if(isset($_POST['update'])){



    if(isset($_POST['dealer_deposit'])){

      $dealer_deposit = 1;

    }else{     

      $dealer_deposit = 0;

    }



    if(isset($_POST['dealer_security_cheque'])){

      $dealer_security_cheque = 1;

    }else{     

      $dealer_security_cheque = 0;

    }



     if($_FILES['customer_aadhaar']['error'][0] == 0){



       // FILE DATA 

       $name = $_FILES['customer_aadhaar'];

       $allowed_extensions = array('jpg','jpeg','png','gif');

       $target_path = "../../uploads/aadhaar/";

       $file_prefix = "IMG_";

       $upload = file_upload($name,$allowed_extensions,$target_path,$file_prefix);



       if($upload['error'] == 1){

       

           $error = "Failed to Upload files, try again later";

       

       }else{



           foreach($upload['files'] as $rs){



               $form_data = array(

                'added_by' => $login_id, // current admin id 

                'party_handled_by' => $_POST['party_handled_by'], // Employee who handles it 

                'customer_name' => $_POST['customer_name'], 

                'customer_address' => $_POST['customer_address'], 

                'customer_at' => $_POST['customer_at'], 

                'customer_taluka' => $_POST['customer_taluka'], 

                'customer_district' => $_POST['customer_district'], 

                'customer_pincode' => $_POST['customer_pincode'], 

                'customer_email' => $_POST['customer_email'], 

                'customer_landline' => $_POST['customer_landline'], 

                'customer_mobile' => $_POST['customer_mobile'], 

                'customer_gst' => $_POST['customer_gst'], 

                'customer_gst_type' => $_POST['customer_gst_type'], 

                'customer_credit_limit' => $_POST['customer_credit_limit'], 

                'customer_credit_limit_days' => $_POST['customer_credit_limit_days'], 

                'customer_mode_of_payment' => $_POST['customer_mode_of_payment'], 

                'customer_discount' => $_POST['customer_discount'], 

                'customer_pan' => $_POST['customer_pan'], 

                'customer_dob' => $_POST['customer_dob'], 

                'customer_doj' => $_POST['customer_doj'], 

                'customer_fertilizer_lic' => $_POST['customer_fertilizer_lic'], 

                'customer_pesticide_lic' => $_POST['customer_pesticide_lic'], 

                'customer_seed_lic' => $_POST['customer_seed_lic'], 

                'contact_person_name' => $_POST['contact_person_name'], 

                'customer_aadhaar' => $rs, 

                'customer_aadhaar_number' => $_POST['customer_aadhaar_number'], 

                'dealer_deposit' => $dealer_deposit, 

                'dealer_security_cheque' => $dealer_security_cheque, 

                'dealer_amount' => $_POST['dealer_amount'], 

                'dealer_cheque_number' => $_POST['dealer_cheque_number'], 

                'dealer_bank_name' => $_POST['dealer_bank_name'], 

                'dealer_ifsc_code' => $_POST['dealer_ifsc_code'],

              );



               // clear old resource

               $old_customer_aadhar = getOne('tbl_customer','customer_id',$_GET['edit_id']);

               unlink($old_customer_aadhar['customer_aadhaar']);

               

               

               if(update('tbl_customer',$field_name,$_GET['edit_id'],$form_data)){

                   $success = "Customer Updated Successfully";

                   echo '<script type="text/javascript">' . "\n";
echo 'window.location="../../modules/customer/view.php";';
echo '</script>';

               }else{

                   $error = "Failed to update Customer, try again later";

                   unlink($rs);

               }



           }



       }



     }else{



              $form_data = array(

                'added_by' => $login_id, // current admin id 

                'party_handled_by' => $_POST['party_handled_by'], // Employee who handles it 

                'customer_name' => $_POST['customer_name'], 

                'customer_address' => $_POST['customer_address'], 

                'customer_at' => $_POST['customer_at'], 

                'customer_taluka' => $_POST['customer_taluka'], 

                'customer_district' => $_POST['customer_district'], 

                'customer_pincode' => $_POST['customer_pincode'], 

                'customer_email' => $_POST['customer_email'], 

                'customer_landline' => $_POST['customer_landline'], 

                'customer_mobile' => $_POST['customer_mobile'], 

                'customer_gst' => $_POST['customer_gst'], 

                'customer_gst_type' => $_POST['customer_gst_type'], 

                'customer_credit_limit' => $_POST['customer_credit_limit'], 

                'customer_credit_limit_days' => $_POST['customer_credit_limit_days'], 

                'customer_mode_of_payment' => $_POST['customer_mode_of_payment'], 

                'customer_discount' => $_POST['customer_discount'], 

                'customer_pan' => $_POST['customer_pan'], 

                'customer_dob' => $_POST['customer_dob'], 

                'customer_doj' => $_POST['customer_doj'], 

                'customer_fertilizer_lic' => $_POST['customer_fertilizer_lic'], 

                'customer_pesticide_lic' => $_POST['customer_pesticide_lic'], 

                'customer_seed_lic' => $_POST['customer_seed_lic'], 

                'contact_person_name' => $_POST['contact_person_name'], 

                'customer_aadhaar_number' => $_POST['customer_aadhaar_number'], 

                'dealer_deposit' => $dealer_deposit, 

                'dealer_security_cheque' => $dealer_security_cheque, 

                'dealer_amount' => $_POST['dealer_amount'], 

                'dealer_cheque_number' => $_POST['dealer_cheque_number'], 

                'dealer_bank_name' => $_POST['dealer_bank_name'], 

                'dealer_ifsc_code' => $_POST['dealer_ifsc_code'],

              );

               

             if(update('tbl_customer',$field_name,$_GET['edit_id'],$form_data)){

                 $success = "Customer Updated Successfully";

                  echo '<script type="text/javascript">' . "\n";
echo 'window.location="../../modules/customer/view.php";';
echo '</script>';

             }else{

                 $error = "Failed to update Customer, try again later";

             }



     }

     



   }





?>



<!DOCTYPE html>

<html>

   <?php require_once('../../include/headerscript.php'); ?>

   <body class="fixed-left">

      <!-- Begin page -->

      <div id="wrapper">

         <!-- Top Bar Start -->

         <?php require_once('../../include/topbar.php'); ?>

         <!-- Top Bar End -->

         <!-- ========== Left Sidebar Start ========== -->

         <?php require_once('../../include/sidebar.php'); ?>

         <!-- Left Sidebar End -->

         <!-- ============================================================== -->

         <!-- Start Page Content here -->

         <!-- ============================================================== -->

         <div class="content-page">

            <!-- Start content -->

            <div class="content">

               <div class="container">

                   <div class="row">

                     <div class="col-md-6">

                        <div class="page-title-box">

                           <h4 class="page-title">Add Customer</h4>

                           <div class="clearfix"></div>

                        </div>

                     </div>                   

                  </div>

                  <div class="row">   

                     

                     <div class="col-sm-12">

                        <div class="card-box">

                           <div class="row">

                               <form method="post" class="form-horizontal" enctype="multipart/form-data">

                                 <div class="col-md-12">

                                    <div class="row">



                                      <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="party_handled_by">Party Handled By (Employee)<span class="text-danger">*</span></label>

                                            <select class="form-control select2" name="party_handled_by" id="party_handled_by">

                                              <?php if(isset($employees) && count($employees) > 0){ ?>

                                                <?php foreach($employees as $rs){ ?>

                                                

                                                  <option <?php if(isset($edit_data['party_handled_by']) && $edit_data['party_handled_by'] == $rs['employee_id']){ echo "selected";  } ?> value="<?php echo $rs['employee_id']; ?>"><?php echo $rs['employee_name']; ?></option>



                                                <?php } ?>

                                              <?php } ?>

                                             </select>

                                          </div>

                                       </div>



                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_name">Customer Name (Party)<span class="text-danger">*</span></label>

                                             <input type="text" name="customer_name" parsley-trigger="change" required="" placeholder="" class="form-control" id="customer_name" value="<?php if(isset($edit_data['customer_name'])){ echo $edit_data['customer_name']; } ?>" >

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_address">Address<span class="text-danger">*</span></label>

                                             <input type="text" name="customer_address" parsley-trigger="change" required="" placeholder="" class="form-control" id="customer_addres" value="<?php if(isset($edit_data['customer_address'])){ echo $edit_data['customer_address']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_at">AT<span class="text-danger">*</span></label>

                                             <input type="text" name="customer_at" parsley-trigger="change"  placeholder="" class="form-control" id="customer_at" value="<?php if(isset($edit_data['customer_at'])){ echo $edit_data['customer_at']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_taluka">Taluka<span class="text-danger">*</span></label>

                                             <input type="text" name="customer_taluka" parsley-trigger="change" placeholder="" class="form-control" id="customer_taluka" value="<?php if(isset($edit_data['customer_taluka'])){ echo $edit_data['customer_taluka']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_district">Dist<span class="text-danger">*</span></label>

                                             <input type="text" name="customer_district" required="" parsley-trigger="change"  placeholder="" class="form-control" id="customer_district" value="<?php if(isset($edit_data['customer_district'])){ echo $edit_data['customer_district']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_pincode">Pin code</label>

                                             <input type="number" name="customer_pincode" parsley-trigger="change"  placeholder="" class="form-control" id="customer_pincode" value="<?php if(isset($edit_data['customer_pincode'])){ echo $edit_data['customer_pincode']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_email">Email</label>

                                             <input type="email" name="customer_email" parsley-trigger="change"  placeholder="" class="form-control" id="customer_email" value="<?php if(isset($edit_data['customer_email'])){ echo $edit_data['customer_email']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_landline">Landline Number </label>

                                             <input type="number" name="customer_landline" parsley-trigger="change"placeholder="" class="form-control" id="customer_landline" value="<?php if(isset($edit_data['customer_landline'])){ echo $edit_data['customer_landline']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_mobile">Mobile <span class="text-danger">*</span></label>

                                             <input type="number" name="customer_mobile" parsley-trigger="change" required="" placeholder="" class="form-control" id="customer_mobile" value="<?php if(isset($edit_data['customer_mobile'])){ echo $edit_data['customer_mobile']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_gst">Gst No<span class="text-danger">*</span></label>

                                             <input type="text" name="customer_gst" parsley-trigger="change"  placeholder="" class="form-control" id="customer_gst" value="<?php if(isset($edit_data['customer_gst'])){ echo $edit_data['customer_gst']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_gst_type">Gst Type<span class="text-danger">*</span></label>

                                             <select name="customer_gst_type" parsley-trigger="change"  class="form-control select2" id="customer_gst_type">

                                                <option <?php if(isset($edit_data['customer_gst_type']) && $edit_data['customer_gst_type'] == "1"){ echo "selected";  } ?> value="1">CGST/SGST</option>

                                                <option <?php if(isset($edit_data['customer_gst_type']) && $edit_data['customer_gst_type'] == "2"){ echo "selected";  } ?> value="2">IGST</option>

                                             </select>

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_mode_of_payment">Mode of Payment</label>

                                             <input name="customer_mode_of_payment" id="customer_mode_of_payment" parsley-trigger="change" class="form-control" value="<?php if(isset($edit_data['customer_gst'])){ echo $edit_data['customer_mode_of_payment']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_pan">Pan No</label>

                                             <input type="text" name="customer_pan" parsley-trigger="change" placeholder="" class="form-control" id="customer_pan" value="<?php if(isset($edit_data['customer_pan'])){ echo $edit_data['customer_pan']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label>DOJ</label>

                                             <div class="input-group">

                                                <input type="date" class="form-control" placeholder="mm/dd/yyyy" id="customer_doj" value="<?php if(isset($edit_data['customer_doj'])){ echo $edit_data['customer_doj']; } ?>" name="customer_doj">

                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>

                                             </div>

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label>DOB</label>

                                             <div class="input-group">

                                                <input type="date" class="form-control" placeholder="mm/dd/yyyy" id="customer_dob" value="<?php if(isset($edit_data['customer_dob'])){ echo $edit_data['customer_dob']; } ?>" name="customer_dob">

                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>

                                             </div>

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_fertilizer_lic">Fartilizer LIC No<span class="text-danger">*</span></label>

                                             <input type="text" name="customer_fertilizer_lic" parsley-trigger="change" required="" placeholder="" class="form-control" id="customer_fertilizer_lic" value="<?php if(isset($edit_data['customer_fertilizer_lic'])){ echo $edit_data['customer_fertilizer_lic']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_pesticide_lic">Pesticide LIC<span class="text-danger">*</span></label>

                                             <input type="text" name="customer_pesticide_lic" parsley-trigger="change" required="" placeholder="" class="form-control" id="customer_pesticide_lic" value="<?php if(isset($edit_data['customer_pesticide_lic'])){ echo $edit_data['customer_pesticide_lic']; } ?>" >

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_seed_lic">Seed LIC</label>

                                             <input type="text" name="customer_seed_lic" parsley-trigger="change"  placeholder="" class="form-control" id="customer_seed_lic" value="<?php if(isset($edit_data['customer_seed_lic'])){ echo $edit_data['customer_seed_lic']; } ?>">

                                          </div>

                                       </div>

                                        <div class="col-md-4">

                                          <div class="form-group">

                                             <label class="control-label">Upload Aadhaar</label>

                                             <input type="file" class="filestyle_" data-buttonname="btn-default" name="customer_aadhaar[]" id="customer_aadhaar" value="<?php if(isset($edit_data['customer_aadhaar'])){ echo $edit_data['customer_aadhaar']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_aadhaar_number">Aadhaar No<span class="text-danger">*</span></label>

                                             <input type="text" name="customer_aadhaar_number" parsley-trigger="change" required="" placeholder="" class="form-control" id="customer_aadhaar_number" value="<?php if(isset($edit_data['customer_aadhaar_number'])){ echo $edit_data['customer_aadhaar_number']; } ?>">

                                          </div>

                                       </div>

                                         <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="contact_person_name">Contact Person Name</label>

                                             <input type="text" name="contact_person_name" parsley-trigger="change"placeholder="" class="form-control" id="contact_person_name" value="<?php if(isset($edit_data['contact_person_name'])){ echo $edit_data['contact_person_name']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <div class="col-md-6">

                                                <label class="control-label">Dealer Deposit</label>

                                             </div>

                                             <div class="col-md-6 p-t-10">

                                                <input <?php if(isset($edit_data['dealer_deposit']) && $edit_data['dealer_deposit'] == '1'){ echo "checked"; } ?> type="checkbox" id="dealer_deposit" name="dealer_deposit">

                                             </div>

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <div class="col-md-6">

                                                <label class="control-label">security Cheque<span class="text-danger">*</span></label>

                                             </div>

                                             <div class="col-md-6 p-t-10">

                                                <input <?php if(isset($edit_data['dealer_security_cheque']) && $edit_data['dealer_security_cheque'] == '1'){ echo "checked"; } ?> type="checkbox" id="dealer_security_cheque" name="dealer_security_cheque">

                                             </div>

                                          </div>

                                       </div>

                                       <div class="clearfix"></div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="dealer_amount">Amount</label>

                                             <input type="number" name="dealer_amount" parsley-trigger="change"placeholder="" class="form-control" id="dealer_amount" value="<?php if(isset($edit_data['dealer_amount'])){ echo $edit_data['dealer_amount']; } ?>" >

                                          </div>

                                       </div>



                                         <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="dealer_cheque_number">Cheque No<span class="text-danger">*</span></label>

                                             <input type="text" name="dealer_cheque_number" parsley-trigger="change"placeholder="" class="form-control" id="dealer_cheque_number" value="<?php if(isset($edit_data['dealer_cheque_number'])){ echo $edit_data['dealer_cheque_number']; } ?>">

                                          </div>

                                       </div>

                                         <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="dealer_bank_name">Bank Name<span class="text-danger">*</span></label>

                                             <input type="text" name="dealer_bank_name" parsley-trigger="change" placeholder="" class="form-control" id="dealer_bank_name" value="<?php if(isset($edit_data['dealer_bank_name'])){ echo $edit_data['dealer_bank_name']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="dealer_ifsc_code">IFSC Code<span class="text-danger">*</span></label>

                                             <input type="text" name="dealer_ifsc_code" parsley-trigger="change"  placeholder="" class="form-control" id="dealer_ifsc_code" value="<?php if(isset($edit_data['dealer_ifsc_code'])){ echo $edit_data['dealer_ifsc_code']; } ?>">

                                          </div>

                                       </div>



                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_credit_limit">Credit Limit<span class="text-danger">*</span></label>

                                             <input type="number" name="customer_credit_limit" required="" parsley-trigger="change" placeholder="" class="form-control" id="customer_credit_limit" value="<?php if(isset($edit_data['customer_credit_limit'])){ echo $edit_data['customer_credit_limit']; } ?>">

                                          </div>

                                       </div>



                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_credit_limit_days">Credit Limit in Days<span class="text-danger">*</span></label>

                                             <input type="number" name="customer_credit_limit_days" required="" parsley-trigger="change" placeholder="" class="form-control" id="customer_credit_limit_days" value="<?php if(isset($edit_data['customer_credit_limit_days'])){ echo $edit_data['customer_credit_limit_days']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="customer_discount">Select Discount Slab<span class="text-danger">*</span></label>

                                             <select name="customer_discount" parsley-trigger="change" required="" class="form-control select2" id="customer_discount">

                                                <option <?php if(isset($edit_data['customer_discount']) && $edit_data['customer_discount'] == "0"){ echo "selected";  } ?> value="0">Regular</option>

                                                <option <?php if(isset($edit_data['customer_discount']) && $edit_data['customer_discount'] == "1"){ echo "selected";  } ?> value="1">First</option>

                                                <option <?php if(isset($edit_data['customer_discount']) && $edit_data['customer_discount'] == "2"){ echo "selected";  } ?> value="2">Second</option>

                                                <option <?php if(isset($edit_data['customer_discount']) && $edit_data['customer_discount'] == "3"){ echo "selected";  } ?> value="3">Third</option>

                                             </select>

                                          </div>

                                       </div>



                                    </div>

                                    <div class="row">

                                       <div class="col-md-12 p-t-30">

                                          <?php if(isset($success)){ ?>

                                             <div class="alert alert-success"><?php echo $success; ?></div>

                                          <?php }else if(isset($warning)){ ?>

                                             <div class="alert alert-warning"><?php echo $warning; ?></div>

                                          <?php }else if(isset($error)){ ?>

                                             <div class="alert alert-danger"><?php echo $error; ?></div>

                                          <?php } ?>

                                       </div>      



                                       <div class="col-md-12" align="right">

                                          <?php if(isset($edit_data)){ ?>                                             

                                            <button type="submit" name="update" id="update" class="btn btn-danger btn-bordered waves-effect w-md waves-light m-b-5">Update</button>

                                         <?php }else{ ?>

                                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Submit</button>

                                         <?php } ?>

                                       </div>

                                    </div>

                                 </div>

                              </form>

                           </div>

                        </div>

                     </div>

                

                  </div>

                 

               </div>

               <!-- container -->

            </div>

            <!-- content -->

         </div>

         <!-- ============================================================== -->

         <!-- End of the page -->

         <!-- ============================================================== -->

      </div>

      <!-- END wrapper -->

      <!-- START Footerscript -->

      <?php require_once('../../include/footerscript.php'); ?>



      <script>

         

         $('.generatePassword').on('click', function(){



            var password = randomPassword();

            $('#admin_password').val(password);



         });



      </script>



   </body>

</html>
