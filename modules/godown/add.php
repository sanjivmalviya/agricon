
<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['agricon_credentials']['user_id'];
   $states = getAll('tbl_state');
   $cities = getAll('tbl_city');
    
   if(isset($_POST['submit'])){
   
       $form_data = array(
         'added_by' => $login_id, // admin id 
         'godown_person_name' => $_POST['godown_person_name'],
         'godown_person_mobile' => $_POST['godown_person_mobile'],
         'godown_person_designation' => $_POST['godown_person_designation'],
         'godown_name' => $_POST['godown_name'],
         'godown_email' => $_POST['godown_email'],
         'godown_password' => $_POST['godown_password'],
         'godown_address' => $_POST['godown_address'],
         'godown_city' => $_POST['godown_city'],
         'godown_state' => $_POST['godown_state']
      );
       
      if(insert('tbl_godown',$form_data)){
         $success = "Godown Added Successfully";
      }else{
         $error = "Failed to add Godown, try again later";
      }
      
   }

   $table_name = 'tbl_godown';
   $field_name = 'godown_id';

   if(isset($_GET['edit_id'])){

         $edit_data = getOne($table_name,$field_name,$_GET['edit_id']);         
         $edit_data = array(
           'added_by' => $login_id,
           'godown_person_name' => $edit_data['godown_person_name'],
           'godown_person_mobile' => $edit_data['godown_person_mobile'],
           'godown_person_designation' => $edit_data['godown_person_designation'],
           'godown_name' => $edit_data['godown_name'],
           'godown_email' => $edit_data['godown_email'],
           'godown_password' => $edit_data['godown_password'],
           'godown_address' => $edit_data['godown_address'],
           'godown_city' => $edit_data['godown_city'],
           'godown_state' => $edit_data['godown_state']
         );

   }

  if(isset($_POST['update'])){

    // POST DATA
 
      $form_data = array(
        'added_by' => $login_id,
        'godown_person_name' => $_POST['godown_person_name'],
        'godown_person_mobile' => $_POST['godown_person_mobile'],
        'godown_person_designation' => $_POST['godown_person_designation'],
        'godown_name' => $_POST['godown_name'],
        'godown_email' => $_POST['godown_email'],
        'godown_password' => $_POST['godown_password'],
        'godown_address' => $_POST['godown_address'],
        'godown_city' => $_POST['godown_city'],
        'godown_state' => $_POST['godown_state']
      );

         if(update($table_name,$field_name,$_GET['edit_id'],$form_data)){
             $success = "Godown Updated Successfully";
         }else{
             $error = "Failed to update godown, try again later";
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
                           <h4 class="page-title">Add godown</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>                   
                  </div>
                  <div class="row">   
                     
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">
                              <form method="post" class="form-horizontal" role="form">
                                 <div class="col-md-12">
                           
                                    <div class="row">
                                       <div class="clearfix"></div>
                                       <div class="col-md-12"><h5><hr>Handler Details</h5>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="godown_person_name">Godown Person Name<span class="text-danger">*</span></label>
                                             <input type="text" name="godown_person_name" parsley-trigger="change" required=""  class="form-control" id="godown_person_name" value="<?php if(isset($edit_data['godown_person_name'])){ echo $edit_data['godown_person_name']; } ?>">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="godown_person_mobile">Godown Person Mobile<span class="text-danger">*</span></label>
                                             <input type="text" name="godown_person_mobile" parsley-trigger="change" required=""  class="form-control" id="godown_person_mobile" value="<?php if(isset($edit_data['godown_person_mobile'])){ echo $edit_data['godown_person_mobile']; } ?>">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="godown_person_designation">Godown Person Designation<span class="text-danger">*</span></label>
                                             <input type="text" name="godown_person_designation" parsley-trigger="change" required=""  class="form-control" id="godown_person_designation" value="<?php if(isset($edit_data['godown_person_designation'])){ echo $edit_data['godown_person_designation']; } ?>">
                                          </div>
                                       </div>               
                                       <div class="clearfix"></div>
                                       <div class="col-md-12"><h5><hr>Godown Details</h5>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="godown_name">Godown Name<span class="text-danger">*</span></label>
                                             <input type="text" name="godown_name" parsley-trigger="change" required=""  class="form-control" id="godown_name" value="<?php if(isset($edit_data['godown_name'])){ echo $edit_data['godown_name']; } ?>">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="godown_email">Email<span class="text-danger">*</span></label>
                                             <input type="text" name="godown_email" parsley-trigger="change" required=""  class="form-control" id="godown_email" value="<?php if(isset($edit_data['godown_email'])){ echo $edit_data['godown_email']; } ?>">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                             <input type="button" class="btn btn-default btn-xs generatePassword pull-right" value="Generate Password">
                                          <div class="form-group">
                                             <label for="godown_password   ">Password<span class="text-danger">*</span></label>
                                             <input type="text" name="godown_password" parsley-trigger="change" required=""  class="form-control" id="godown_password" value="<?php if(isset($edit_data['godown_password'])){ echo $edit_data['godown_password']; } ?>">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="godown_address">Address<span class="text-danger">*</span></label>
                                             <input type="text" name="godown_address" parsley-trigger="change" required=""  class="form-control" id="godown_address" value="<?php if(isset($edit_data['godown_address'])){ echo $edit_data['godown_address']; } ?>">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="godown_city">City<span class="text-danger">*</span></label>
                                             <select name="godown_city" parsley-trigger="change" required="" class="form-control select2" id="godown_city">
                                             <?php if(isset($cities) && count($cities) > 0){ ?>
                                                <?php foreach($cities as $rs){ ?>
                                                   <option <?php if(isset($edit_data['godown_city']) && $edit_data['godown_city'] == $rs['city_id']){ echo "selected";  } ?> value="<?php echo $rs['city_id']; ?>"><?php echo $rs['city_name']; ?></option>   
                                                <?php } ?>
                                             <?php } ?>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="godown_state">State<span class="text-danger">*</span></label>
                                             <select name="godown_state" class="form-control select2">
                                                <?php if(isset($states) && count($states) > 0){ ?>

                                                  <?php foreach($states as $rs){ ?>

                                                      <option <?php if(isset($edit_data['godown_state']) && $edit_data['godown_state'] == $rs['state_id']){ echo "selected";  } ?> value="<?php echo $rs['state_id']; ?>"><?php echo $rs['state_name']; ?></option>

                                                  <?php } ?>
                                                <?php } ?>
                                             </select>
                                          </div>
                                       </div>
                                      
                                    </div>
                                    <div class="row">
                                       <div class="col-md-12" align="left">

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
            $('#godown_password').val(password);

         });

      </script>

   </body>
</html>