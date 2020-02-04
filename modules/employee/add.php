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
    
    $employee_order_access = $_POST['employee_order_access'];

    // $employee_annual_ctc = $_POST['employee_annual_ctc'];
    
    $employee_monthly_hra = $_POST['employee_monthly_hra'];
    
    $employee_monthly_da = $_POST['employee_monthly_da'];

    $employee_monthly_extra_allowances = $_POST['employee_monthly_extra_allowances'];
    
    $employee_monthly_basic_salary = $_POST['employee_monthly_basic_salary'];
   

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
               
               'employee_order_access' => $employee_order_access,
               
               // 'employee_annual_ctc' => $employee_annual_ctc,
               'employee_monthly_hra' => $employee_monthly_hra,
               'employee_monthly_da' => $employee_monthly_da,
               'employee_monthly_extra_allowances' => $employee_monthly_extra_allowances,
               'employee_monthly_basic_salary' => $employee_monthly_basic_salary

             );


             if(insert('tbl_employee',$form_data)){

                 $last_id = last_id('tbl_employee','employee_id');

                 $form_data_salary_history = array(
                  'employee_id' => $last_id,
                  'employee_monthly_hra' => $employee_monthly_hra,
                  'employee_monthly_da' => $employee_monthly_da,
                  'employee_monthly_extra_allowances' => $employee_monthly_extra_allowances,
                  'employee_monthly_basic_salary' => $employee_monthly_basic_salary
                 );
                 insert('employee_salary_history',$form_data_salary_history);
                 
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

               'employee_type' => $employee_type,
               'employee_order_access' => $employee_order_access,
               
               // 'employee_annual_ctc' => $employee_annual_ctc,
               'employee_monthly_hra' => $employee_monthly_hra,
               'employee_monthly_da' => $employee_monthly_da,
               'employee_monthly_extra_allowances' => $employee_monthly_extra_allowances,
               'employee_monthly_basic_salary' => $employee_monthly_basic_salary

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

           'employee_type' => $edit_data['employee_type'],
           'employee_order_access' => $edit_data['employee_order_access'],

           // 'employee_annual_ctc' => $edit_data['employee_annual_ctc'],
           'employee_monthly_hra' => $edit_data['employee_monthly_hra'],
           'employee_monthly_da' => $edit_data['employee_monthly_da'],
           'employee_monthly_extra_allowances' => $edit_data['employee_monthly_extra_allowances'],
           'employee_monthly_basic_salary' => $edit_data['employee_monthly_basic_salary']

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
    $employee_order_access = $_POST['employee_order_access'];
    
    // $employee_annual_ctc = $_POST['employee_annual_ctc'];

    $employee_monthly_hra = $_POST['employee_monthly_hra'];

    $employee_monthly_da = $_POST['employee_monthly_da'];

    $employee_monthly_extra_allowances = $_POST['employee_monthly_extra_allowances'];

    $employee_monthly_basic_salary = $_POST['employee_monthly_basic_salary'];



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

               'employee_type' => $_POST['employee_type'],
               'employee_order_access' => $_POST['employee_order_access'],
              
               // 'employee_annual_ctc' => $_POST['employee_annual_ctc'],
               
               'employee_monthly_hra' => $_POST['employee_monthly_hra'],
               
               'employee_monthly_da' => $_POST['employee_monthly_da'],

               'employee_monthly_extra_allowances' => $_POST['employee_monthly_extra_allowances'],

               'employee_monthly_basic_salary' => $_POST['employee_monthly_basic_salary']

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

           'employee_type' => $_POST['employee_type'],
           'employee_order_access' => $_POST['employee_order_access'],

           // 'employee_annual_ctc' => $_POST['employee_annual_ctc'],
           'employee_monthly_hra' => $_POST['employee_monthly_hra'],
           'employee_monthly_da' => $_POST['employee_monthly_da'],
           'employee_monthly_extra_allowances' => $_POST['employee_monthly_extra_allowances'],
           'employee_monthly_basic_salary' => $_POST['employee_monthly_basic_salary']

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

                                                <input type="date" required="" class="form-control" placeholder="mm/dd/yyyy" id="employee_doj" value="<?php if(isset($edit_data['employee_doj'])){ echo date('Y-m-d',strtotime($edit_data['employee_doj'])); }else{ echo date('Y-m-d');  } ?>" name="employee_doj" >

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

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="employee_order_access">Order Access</label> 
                                             <br>
                                             <label for="employee_order_access_0">
                                             <input type="radio" name="employee_order_access" id="employee_order_access_0" value="0" checked=""> No</label> 

                                             <label for="employee_order_access_1">
                                             <input type="radio" name="employee_order_access" id="employee_order_access_1" value="1"> Yes</label> 


                                          </div>

                                       </div>                             

                                    </div>

                                    <div class="row">

                                      <div class="col-md-12"> 
                                        <h4>Employee Salary</h4>
                                      </div>

                                      <div class="col-md-6 table-responsive">

                                      <table class="table table-condensed table-bordered">
                                        <tbody>
                                          <!-- <tr>
                                            <td width="50%">Annual CTC </td>
                                            <td width="50%"><input type="number" parsley-trigger="change" placeholder="" class="form-control" name="employee_annual_ctc" id="employee_annual_ctc" value="<?php if(isset($edit_data['employee_annual_ctc'])){ echo $edit_data['employee_annual_ctc']; } ?>"></td>
                                          </tr> -->
                                          <tr>
                                            <td>Monthly Basic Salary <span class="text-danger">*</span></td>
                                            <td><input type="number" required="" parsley-trigger="change" placeholder="" class="form-control" name="employee_monthly_basic_salary" id="employee_monthly_basic_salary" value="<?php if(isset($edit_data['employee_monthly_basic_salary'])){ echo $edit_data['employee_monthly_basic_salary']; } ?>"></td>
                                          </tr>
                                          <tr>
                                            <td>Monthly HRA</td>
                                            <td><input type="number" parsley-trigger="change" placeholder="" class="form-control" name="employee_monthly_hra" id="employee_monthly_hra" value="<?php if(isset($edit_data['employee_monthly_hra'])){ echo $edit_data['employee_monthly_hra']; }else{ echo 0; } ?>"></td>
                                          </tr>
                                          <tr>
                                            <td>Monthly DA</td>
                                            <td><input type="number" parsley-trigger="change" placeholder="" class="form-control" name="employee_monthly_da" id="employee_monthly_da" value="<?php if(isset($edit_data['employee_monthly_da'])){ echo $edit_data['employee_monthly_da']; }else{ echo 0; } ?>"></td>
                                          </tr>

                                          <tr>
                                            <td>Monthly Extra Allowances</td>
                                            <td><input type="number" parsley-trigger="change" placeholder="" class="form-control" name="employee_monthly_extra_allowances" id="employee_monthly_extra_allowances" value="<?php if(isset($edit_data['employee_monthly_extra_allowances'])){ echo $edit_data['employee_monthly_extra_allowances']; }else{ echo 0; } ?>"></td>
                                          </tr>
                                          
                                        </tbody>
                                      </table>

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
