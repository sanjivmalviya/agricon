<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['agricon_credentials']['user_id'];

   $table_name = 'tbl_employee';

   $field_name = 'employee_id';

    

   if(isset($_POST['submit'])){



    // POST DATA

    $employee_name = $_POST['employee_name'];

    $employee_mobile = $_POST['employee_mobile'];

    $employee_hq = $_POST['employee_hq'];

    $employee_designation = $_POST['employee_designation'];

    $employee_pan = $_POST['employee_pan'];

    $employee_doj = $_POST['employee_doj'];

    $employee_dob = $_POST['employee_dob'];

    $employee_email = $_POST['employee_email'];

    $employee_password = $_POST['employee_password'];

    $employee_spouse_name = $_POST['employee_spouse_name'];

    $employee_spouse_mobile = $_POST['employee_spouse_mobile'];

    $employee_aadhaar_number = $_POST['employee_aadhaar_number'];

    $employee_type = $_POST['employee_type'];


    // FILE DATA 

     $name = $_FILES['employee_aadhaar'];

     $allowed_extensions = array('jpg','jpeg','png','gif','pdf');

     $target_path = "../../uploads/aadhaar/";

     $file_prefix = "IMG_";

     $upload = file_upload($name,$allowed_extensions,$target_path,$file_prefix);

     

     if($upload['error'] == 1){

      

         $error = "Failed to Upload files, try again later";

     

     }else{



        if(isset($upload['files']) && $upload['files'] != ""){

          

          foreach($upload['files'] as $rs){



             $form_data = array(

               'added_by' => $login_id,

               'employee_name' => $employee_name,

               'employee_designation' => $employee_designation,

               'employee_hq' => $employee_hq,

               'employee_mobile' => $employee_mobile,

               'employee_doj' => $employee_doj,

               'employee_dob' => $employee_dob,

               'employee_pan' => $employee_pan,

               'employee_email' => $employee_email,

               'employee_aadhaar' => substr($rs,6),

               'employee_aadhaar_number' => $employee_aadhaar_number,

               'employee_password' => $employee_password,

               'employee_spouse_name' => $employee_spouse_name,

               'employee_spouse_mobile' => $employee_spouse_mobile,
               
               'employee_type' => $employee_type,

             );



             

             if(insert('tbl_employee',$form_data)){

                 $success = "Employee Added Successfully";

             }else{

                 $error = "Failed to add Employee, try again later";

                 unlink($rs);

             }



          }



        }else{



          // if image not uploaded

          $form_data = array(

               'added_by' => $login_id,

               'employee_name' => $employee_name,

               'employee_designation' => $employee_designation,

               'employee_hq' => $employee_hq,

               'employee_mobile' => $employee_mobile,

               'employee_doj' => $employee_doj,

               'employee_dob' => $employee_dob,

               'employee_pan' => $employee_pan,

               'employee_email' => $employee_email,

               'employee_aadhaar_number' => $employee_aadhaar_number,

               'employee_password' => $employee_password,

               'employee_spouse_name' => $employee_spouse_name,

               'employee_spouse_mobile' => $employee_spouse_mobile,

               'employee_type' => $employee_type

             );



             

             if(insert('tbl_employee',$form_data)){

                 $success = "Employee Added Successfully";

             }else{

                 $error = "Failed to add Employee, try again later";

             }



        }



     }

      

   }



   if(isset($_GET['edit_id'])){



         $edit_data = getOne($table_name,$field_name,$_GET['edit_id']);         

         $edit_data = array(

           'added_by' => $login_id,

           'employee_name' => $edit_data['employee_name'],

           'employee_designation' => $edit_data['employee_designation'],

           'employee_hq' => $edit_data['employee_hq'],

           'employee_mobile' => $edit_data['employee_mobile'],

           'employee_doj' => $edit_data['employee_doj'],

           'employee_dob' => $edit_data['employee_dob'],

           'employee_pan' => $edit_data['employee_pan'],

           'employee_email' => $edit_data['employee_email'],

           'employee_aadhaar' => substr($rs,6),

           'employee_aadhaar_number' => $edit_data['employee_aadhaar_number'],

           'employee_password' => $edit_data['employee_password'],

           'employee_spouse_name' => $edit_data['employee_spouse_name'],

           'employee_spouse_mobile' => $edit_data['employee_spouse_mobile'],

           'employee_type' => $edit_data['employee_type']

         );



   }



  if(isset($_POST['update'])){



    // POST DATA

    $employee_name = $_POST['employee_name'];

    $employee_mobile = $_POST['employee_mobile'];

    $employee_hq = $_POST['employee_hq'];

    $employee_designation = $_POST['employee_designation'];

    $employee_pan = $_POST['employee_pan'];

    $employee_doj = $_POST['employee_doj'];

    $employee_dob = $_POST['employee_dob'];

    $employee_email = $_POST['employee_email'];

    $employee_password = $_POST['employee_password'];

    $employee_spouse_name = $_POST['employee_spouse_name'];

    $employee_spouse_mobile = $_POST['employee_spouse_mobile'];

    $employee_aadhaar_number = $_POST['employee_aadhaar_number'];

    $employee_type = $_POST['employee_type'];



     // FILE DATA 

     $name = $_FILES['employee_aadhaar'];

     $allowed_extensions = array('jpg','jpeg','png','gif','pdf');

     $target_path = "../../uploads/aadhaar/";

     $file_prefix = "IMG_";

     $upload = file_upload($name,$allowed_extensions,$target_path,$file_prefix);

     

    if($_FILES['employee_aadhaar']['error'][0] == 0){



     if($upload['error'] == 1){

      

         $error = "Failed to Upload files, try again later";

     

     }else{

     

         foreach($upload['files'] as $rs){


             $form_data = array(

               'added_by' => $login_id,

               'employee_name' => $_POST['employee_name'],

               'employee_designation' => $_POST['employee_designation'],

               'employee_hq' => $_POST['employee_hq'],

               'employee_mobile' => $_POST['employee_mobile'],

               'employee_doj' => $_POST['employee_doj'],

               'employee_dob' => $_POST['employee_dob'],

               'employee_pan' => $_POST['employee_pan'],

               'employee_email' => $_POST['employee_email'],

               'employee_aadhaar' => substr($rs,6),

               'employee_aadhaar_number' => $_POST['employee_aadhaar_number'],

               'employee_password' => $_POST['employee_password'],

               'employee_spouse_name' => $_POST['employee_spouse_name'],

               'employee_spouse_mobile' => $_POST['employee_spouse_mobile'],

               'employee_type' => $_POST['employee_type']

             );



             // clear old resource

             $old_employee_aadhar = getOne($table_name,$field_name,$_GET['edit_id']);

             $old_employee_aadhar['employee_aadhaar'];

             unlink("../../".$old_employee_aadhar['employee_aadhaar']);



             if(update($table_name,$field_name,$_GET['edit_id'],$form_data)){

                   $success = "Employee Updated Successfully";

               }else{

                   $error = "Failed to update Employee, try again later";

                   unlink($rs);

               }



         }



     }



     }else{



          $form_data = array(

           'added_by' => $login_id,

           'employee_name' => $_POST['employee_name'],

           'employee_designation' => $_POST['employee_designation'],

           'employee_hq' => $_POST['employee_hq'],

           'employee_mobile' => $_POST['employee_mobile'],

           'employee_doj' => $_POST['employee_doj'],

           'employee_dob' => $_POST['employee_dob'],

           'employee_pan' => $_POST['employee_pan'],

           'employee_email' => $_POST['employee_email'],

           'employee_aadhaar_number' => $_POST['employee_aadhaar_number'],

           'employee_password' => $_POST['employee_password'],

           'employee_spouse_name' => $_POST['employee_spouse_name'],

           'employee_spouse_mobile' => $_POST['employee_spouse_mobile'],

           'employee_type' => $_POST['employee_type']

         );



         if(update($table_name,$field_name,$_GET['edit_id'],$form_data)){

             $success = "Employee Updated Successfully";

         }else{

             $error = "Failed to update Employee, try again later";

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

                           <h4 class="page-title">Add Employee</h4>

                           <div class="clearfix"></div>

                        </div>

                     </div>                   

                  </div>

                  <div class="row">   

                     

                     <div class="col-sm-12">

                        <div class="card-box">

                           <div class="row">

                              <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

                                 <div class="col-md-12">

                                    <div class="row">

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="employee_name">Name<span class="text-danger">*</span></label>

                                             <input type="text" name="employee_name" parsley-trigger="change" required="" placeholder="" class="form-control" id="employee_name" value="<?php if(isset($edit_data['employee_name'])){ echo $edit_data['employee_name']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="employee_mobile">Mobile<span class="text-danger">*</span></label>

                                             <input type="number" name="employee_mobile" parsley-trigger="change" required="" placeholder="" class="form-control" id="employee_mobile" value="<?php if(isset($edit_data['employee_mobile'])){ echo $edit_data['employee_mobile']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="employee_hq">HQ</label>

                                             <input type="text" name="employee_hq" parsley-trigger="change" placeholder="" class="form-control" id="employee_hq" value="<?php if(isset($edit_data['employee_hq'])){ echo $edit_data['employee_hq']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="employee_designation">Designation</label>

                                             <input type="text" name="employee_designation" parsley-trigger="change" placeholder="" class="form-control" id="employee_designation" value="<?php if(isset($edit_data['employee_designation'])){ echo $edit_data['employee_designation']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label>DOJ <span class="text-danger">*</span></label>

                                             <div class="input-group">

                                                <input type="date" required="" class="form-control" placeholder="mm/dd/yyyy" id="employee_doj" value="<?php if(isset($edit_data['employee_doj'])){ echo date('Y-m-d',strtotime($edit_data['employee_doj'])); } ?>" name="employee_doj" >

                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>

                                             </div>

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label>DOB <span class="text-danger">*</span></label>

                                             <div class="input-group">

                                                <input type="date" required="" class="form-control" placeholder="mm/dd/yyyy" name="employee_dob" id="employee_dob" value="<?php if(isset($edit_data['employee_dob'])){ echo date('Y-m-d',strtotime($edit_data['employee_dob'])); } ?>" >

                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>

                                             </div>

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="employee_pan">Pan</label>

                                             <input type="text" name="employee_pan" parsley-trigger="change" placeholder="" class="form-control" id="employee_pan" value="<?php if(isset($edit_data['employee_pan'])){ echo $edit_data['employee_pan']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="employee_email">Email<span class="text-danger">*</span></label>

                                             <input type="email" name="employee_email" parsley-trigger="change" required="" placeholder="" class="form-control" id="employee_email" value="<?php if(isset($edit_data['employee_email'])){ echo $edit_data['employee_email']; } ?>">

                                          </div>

                                       </div>

                                        <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="employee_password">Password<span class="text-danger">*</span></label>

                                             <input type="text" name="employee_password" parsley-trigger="change" required="" placeholder="" class="form-control" id="employee_password" value="<?php if(isset($edit_data['employee_password'])){ echo $edit_data['employee_password']; } ?>">

                                          </div>

                                       </div>



                                       



                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="employee_spouse_name">Spouse Name</label>

                                             <input type="text" name="employee_spouse_name" parsley-trigger="change" placeholder="" class="form-control" id="employee_spouse_name" value="<?php if(isset($edit_data['employee_spouse_name'])){ echo $edit_data['employee_spouse_name']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="employee_spouse_mobile">Spouse Mo. No</label>

                                             <input type="number" name="employee_spouse_mobile" parsley-trigger="change" placeholder="" class="form-control" id="employee_spouse_mobile" value="<?php if(isset($edit_data['employee_spouse_mobile'])){ echo $edit_data['employee_spouse_mobile']; } ?>">

                                          </div>

                                       </div>



                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label class="control-label">Adhar Upload</label>

                                             <input type="file" class="filestyle" data-buttonname="btn-default" name="employee_aadhaar[]" id="employee_aadhaar" >

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="employee_aadhaar_number">Adhar No</label>

                                             <input type="text" parsley-trigger="change" placeholder="" class="form-control" name="employee_aadhaar_number" id="employee_aadhaar_number" value="<?php if(isset($edit_data['employee_aadhaar_number'])){ echo $edit_data['employee_aadhaar_number']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="employee_type">Employee Type</label> 
                                             <br>
                                             <label for="employee_type_1">
                                             <input type="radio" name="employee_type" id="employee_type_1" value="1" checked=""> Office Employee</label> 

                                             <label for="employee_type_2">
                                             <input type="radio" name="employee_type" id="employee_type_2" value="2"> Marketing Employee</label> 


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
