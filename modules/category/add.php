
<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['agricon_credentials']['user_id'];
   $categories = getAll('tbl_category');

   if(isset($_POST['submit'])){

    print_r($_POST);
    exit;

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

     // FILE DATA 
     $name = $_FILES['employee_aadhaar'];
     $allowed_extensions = array('jpg','jpeg','png','gif');
     $target_path = "../../uploads/aadhaar/";
     $file_prefix = "IMG_";
     $upload = file_upload($name,$allowed_extensions,$target_path,$file_prefix);

     if($upload['error'] == 1){
     
         $error = "Failed to Upload files, try again later";
     
     }else{

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
             );
             
             if(insert('tbl_employee',$form_data)){
                 $success = "Employee Added Successfully";
             }else{
                 $error = "Failed to add Employee, try again later";
                 unlink($rs);
             }

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
                           <h4 class="page-title">Add Category</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>                   
                  </div>
                  <div class="row">   
                     
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">
                              <form class="form-horizontal" role="form">
                                 <div class="col-md-12">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="category_type">Choose Type<span class="text-danger">*</span></label>
                                             <select id="category_type" class="form-control select2">
                                                   <option value="0">Category (L1)</option>
                                                   <option value="1">Sub-Category (L2)</option>
                                                   <option value="2">Sub Sub-Category (L3)</option>
                                                   <option value="3">Sub Sub Sub-Category (L4)</option>
                                             </select>
                                          </div>
                                       </div>          
                                    </div>
                                    <!-- category -->
                                    <div class="category-block">
                                      <div class="row">
                                         <div class="col-md-6">
                                            <div class="form-group">
                                               <label for="l1_category_name">Category name<span class="text-danger">*</span></label>
                                               <input type="text" id="l1_category_name" required="" class="form-control">
                                            </div>
                                         </div>          
                                      </div>
                                    </div>

                                    <div class="sub-category-block" style="display: none;">
                                      <div class="row">
                                         <div class="col-md-6">
                                            <div class="form-group">
                                               <label for="l2_category_id">Choose Category<span class="text-danger">*</span></label>
                                               <select name="l2_category_id" id="l2_category_id" data-level="1" class="form-control select2">
                                                <option value="">--Choose Category--</option>
                                                <?php if(isset($categories)){ ?>
                                                  <?php foreach($categories as $rs){ ?>
                                                    <option value="<?php echo $rs['category_id']; ?>"><?php echo $rs['category_name']; ?></option>
                                                  <?php } ?>
                                                <?php } ?>
                                               </select>
                                            </div>
                                         </div>          
                                      </div>
                                      <div class="row">
                                         <div class="col-md-6">
                                            <div class="form-group">
                                               <label for="l2_sub_category_name">Category Name<span class="text-danger">*</span></label>
                                               <input type="text" name="l2_sub_category_name" id="l2_sub_category_name" class="form-control">
                                            </div>
                                         </div>          
                                      </div>
                                    </div>

                                    <div class="sub-sub-category-block" style="display: none;">
                                      <div class="row">
                                         <div class="col-md-6">
                                            <div class="form-group">
                                               <label for="l3_category_id">Choose Category<span class="text-danger">*</span></label>
                                               <select id="l3_category_id" data-level="1" class="form-control select2">
                                                <option value="">--Choose Category--</option>
                                                <?php if(isset($categories)){ ?>
                                                  <?php foreach($categories as $rs){ ?>
                                                    <option value="<?php echo $rs['category_id']; ?>"><?php echo $rs['category_name']; ?></option>
                                                  <?php } ?>
                                                <?php } ?>
                                               </select>
                                            </div>
                                         </div>          
                                      </div>
                                      <div class="row">
                                         <div class="col-md-6">
                                            <div class="form-group">
                                               <label for="l3_sub_category_id">Choose Sub  Category<span class="text-danger">*</span></label>
                                               <select name="l3_sub_category_id" id="l3_sub_category_id" class="form-control select2">
                                               </select>
                                            </div>
                                         </div>          
                                      </div>
                                      <div class="row">
                                         <div class="col-md-6">
                                            <div class="form-group">
                                               <label for="l3_sub_sub_category_name">Sub Sub Category name<span class="text-danger">*</span></label>
                                               <input type="text" id="l3_sub_sub_category_name"class="form-control">
                                            </div>
                                         </div>          
                                      </div>
                                    </div>

                                    <div class="sub-sub-sub-category-block" style="display: none;">
                                      <div class="row">
                                         <div class="col-md-6">
                                            <div class="form-group">
                                               <label for="l4_category_id">Choose Category<span class="text-danger">*</span></label>
                                               <select name="l4_category_id" id="l4_category_id" data-level="1" class="form-control select2">
                                                <option value="">--Choose Category--</option>
                                                <?php if(isset($categories)){ ?>
                                                  <?php foreach($categories as $rs){ ?>
                                                    <option value="<?php echo $rs['category_id']; ?>"><?php echo $rs['category_name']; ?></option>
                                                  <?php } ?>
                                                <?php } ?>
                                               </select>
                                            </div>
                                         </div>          
                                      </div>
                                      <div class="row">
                                         <div class="col-md-6">
                                            <div class="form-group">
                                               <label for="l4_sub_category_id">Choose Sub  Category<span class="text-danger">*</span></label>
                                               <select name="l4_sub_category_id" id="l4_sub_category_id" class="form-control select2" data-level="2">
                                               </select>
                                            </div>
                                         </div>          
                                      </div>
                                      <div class="row">
                                         <div class="col-md-6">
                                            <div class="form-group">
                                               <label for="l4_sub_sub_category_id">Choose Sub Sub Category<span class="text-danger">*</span></label>
                                               <select name="l4_sub_sub_category_id" id="l4_sub_sub_category_id" class="form-control select2">
                                               </select>
                                            </div>
                                         </div>          
                                      </div>
                                      <div class="row">
                                         <div class="col-md-6">
                                            <div class="form-group">
                                               <label for="l4_sub_sub_sub_category_name">Sub Sub Sub Category Name<span class="text-danger">*</span></label>
                                               <input type="text" name="l4_sub_sub_sub_category_name" id="l4_sub_sub_sub_category_name" class="form-control">
                                            </div>
                                         </div>          
                                      </div>
                                    </div>

                                    <div class="row">
                                       <div class="col-md-12" align="left">
                                          
                                          <button type="button" name="submit" id="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Save</button>
                                       
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

     
         $('#category_type').on('change', function(){

            var type = $(this).val();

            if(type == 0){

              $('.category-block').show();
              $('.sub-category-block,.sub-sub-category-block,.sub-sub-sub-category-block').hide();
            }else if(type == 1){
              $('.sub-category-block').show();
              $('.category-block,.sub-sub-category-block,.sub-sub-sub-category-block').hide();              
            }else if(type == 2){
              $('.sub-sub-category-block').show();
              $('.category-block,.sub-category-block,.sub-sub-sub-category-block').hide();              
            }else if(type == 3){
              $('.sub-sub-sub-category-block').show();
              $('.category-block,.sub-category-block,.sub-sub-category-block').hide();              
            }
            
         });

         $('#l2_category_id,#l3_category_id,#l4_category_id').on('change', function(){

            var parent_category_id = $(this).val();
            var sub_category_level = $(this).attr('data-level');
            
            populate_sub_categories(parent_category_id,sub_category_level);

         });

         $('#l4_sub_category_id').on('change', function(){

            var parent_category_id = $(this).val();
            var sub_category_level = $(this).attr('data-level');

            populate_sub_categories(parent_category_id,sub_category_level);

         });

         $('#submit').on('click', function(){

            var type = $('#category_type').val();

            if(type == 0 && $('#l1_category_name').val() != ""){

                var category_name = $('#l1_category_name').val();

                $.ajax({
                    url : 'ajax/add_category.php',
                    type : 'POST',
                    dataType : 'json',
                    data : { type : type, category_name : category_name  },
                    success : function(msg){

                      alert(msg);

                    }
                });                   

            }else if(type == 1 && $('#l2_sub_category_name').val() != ""){

              var category_name = $('#l2_sub_category_name').val();
              var parent_category_id = $('#l2_category_id').val();

              $.ajax({
                  url : 'ajax/add_sub_category.php',
                  type : 'POST',
                  dataType : 'json',
                   data : { type : type, category_name : category_name, parent_category_id : parent_category_id  },
                  success : function(msg){
                    
                    alert(msg);

                  }
              });

            }else if(type == 2 && $('#l3_sub_sub_category_name').val() != ""){

              var category_name = $('#l3_sub_sub_category_name').val();
              var parent_category_id = $('#l3_sub_category_id').val();
                  
                $.ajax({
                    url : 'ajax/add_sub_category.php',
                    type : 'POST',
                    dataType : 'json',
                     data : { type : type, category_name : category_name, parent_category_id : parent_category_id  },
                    success : function(msg){
                      
                      alert(msg);

                    }
                });

            }else if(type == 3 && $('#l4_sub_sub_sub_category_name').val() != ""){

              var category_name = $('#l4_sub_sub_sub_category_name').val();
              var parent_category_id = $('#l4_sub_sub_category_id').val();
                 
                $.ajax({
                    url : 'ajax/add_sub_category.php',
                    type : 'POST',
                    dataType : 'json',
                    data : { type : type, category_name : category_name, parent_category_id : parent_category_id  },
                    success : function(msg){
                      
                      alert(msg);

                    }
                });

            }

         });

      </script>

   </body>
</html>