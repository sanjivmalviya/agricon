<?php

   require_once('../../functions.php');

   if(isset($_POST['submit'])){

         $connect = connect();

         $menu_name = sanitize($_POST['menu_name']);
         $menu_link = sanitize($_POST['menu_link']);
         $module_class = sanitize($_POST['module_class']);
         $menu_module = sanitize($_POST['menu_module']);

         if($menu_module == 0){
           
            $menu_new_module = sanitize($_POST['menu_new_module']);

            if(isExists('tbl_modules','module_name',$menu_new_module)){

               $warning = "Sorry, Module already exists";

               }else{

                  $form_data = array(
                     'module_name' => strtolower($menu_new_module),
                     'module_class' => strtolower($module_class)
                  );
                  
                  if(insert('tbl_modules',$form_data)){
                     

                     $last_id = last_id('tbl_modules','module_id');

                     // added role - edit
                     $checkEditExists = "SELECT * FROM tbl_modules WHERE module_id = '$last_id' AND module_name = 'Edit' ";
                     $checkEditExists = getRaw($checkEditExists);
                    
                     if(!isset($checkEditExists)){

                        // EDIT
                        $form_data = array(
                           'module_id' => $last_id,
                           'menu_name' => "Edit"
                        );

                        insert('tbl_menus',$form_data);                        

                     }
                     
                     // add menu
                     $form_data = array(
                        'module_id' => $last_id,
                        'menu_name' => $menu_name,
                        'menu_link' => strtolower($menu_link)
                     );

                     // added role - edit
                     $checkDeleteExists = "SELECT * FROM tbl_modules WHERE module_id = '$last_id' AND module_name = 'Delete' ";
                     $checkDeleteExists = getRaw($checkDeleteExists);
                    
                     if(!isset($checkDeleteExists)){

                        // Delete
                        $form_data = array(
                           'module_id' => $last_id,
                           'menu_name' => "Delete"
                        );

                        insert('tbl_menus',$form_data);                        

                     }
                     
                     // add menu
                     $form_data = array(
                        'module_id' => $last_id,
                        'menu_name' => $menu_name,
                        'menu_link' => strtolower($menu_link)
                     );

                        $check = "SELECT * FROM tbl_menus WHERE menu_name = '$menu_name' AND module_id = '$last_id' ";
                        $check = getRaw($check);

                        if(isset($check)){

                           $warning = "Sorry, Menu already exists";
                           delete('tbl_modules','module_id',$last_id);

                     }else{

                        if(insert('tbl_menus',$form_data)){

                           mkdir('../'.strtolower($menu_new_module),0777,true);
                           $success = "Menu and Module Added Successfully"; 

                        }else{

                           $error = "Failed to add Menu and Module, try again later";
                           delete('tbl_modules','module_id',$last_id);

                        }
                        
                     }

                  }else{

                     $error = "Failed to add Menu, try again later";

                  }
                  
               }

         }else{

            // add menu
            $form_data = array(
               'module_id' => $menu_module,
               'menu_name' => $menu_name,
               'menu_link' => strtolower($menu_link),
            );

            $check = "SELECT * FROM tbl_menus WHERE menu_name = '$menu_name' AND module_id = '$menu_module' ";
            $check = getRaw($check);

            if(isset($check)){

                  $warning = "Sorry, Menu already exists";

            }else{

               if(insert('tbl_menus',$form_data)){

                  $success = "Menu and Module Added Successfully"; 

               }else{

                  $error = "Failed to add Menu and Module, try again later";

               }
               
            }

         }

   }

   $modules = getAll('tbl_modules');

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
                     <div class="col-xs-12">
                        <div class="page-title-box">
                           <h4 class="page-title">Add Menu</h4>
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

                                    <div class="pull-left col-md-12">
                                       <a href="../../modules/menus/view.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left" style="font-size: 20px;"></i></a>
                                    </div>

                                    <div class="col-md-12" style="margin-top: 20px;">
                                        <div class="form-group">
                                             <label for="menu_link">Choose Module<span class="text-danger">*</span></label>
                                             <select name="menu_module" id="menu_module" parsley-trigger="change" class="form-control select2">
                                                <option value="">--Choose Module--</option>
                                                <?php if(isset($modules) && count($modules) > 0){ ?>     
                                                   <?php foreach($modules as $rs){ ?>

                                                      <option value="<?php echo $rs['module_id']; ?>"><?php echo $rs['module_name']; ?></option>

                                                   <?php } ?>

                                                <?php } ?>
                                                <option value="0">+ Add New</option>
                                             </select>
                                          </div>
                                    </div>
                                     <div class="col-md-6 newModuleBlock">
                                        <div class="form-group">
                                             <label for="menu_link">New Module Name<span class="text-danger">*</span></label>
                                             <input type="text" name="menu_new_module" id="menu_new_module" parsley-trigger="change" class="form-control" >
                                          </div>
                                    </div>
                                    <div class="col-md-6 newModuleBlock">
                                        <div class="form-group">
                                             <label for="module_class">New Module Icon Class<span class="text-danger"></span></label>
                                             <input type="text" name="module_class" id="module_class" parsley-trigger="change" class="form-control" placeholder="eg. fa fa-home">
                                          </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                             <label for="menu_name">Menu<span class="text-danger">*</span></label>
                                             <input type="text" name="menu_name" id="menu_name" parsley-trigger="change" class="form-control">
                                          </div>
                                    </div>
                                   
                                    <div class="col-md-12">
                                        <div class="form-group">
                                             <label for="menu_link">File Name<span class="text-danger">*</span></label>
                                             <input type="text" name="menu_link" id="menu_link" parsley-trigger="change" class="form-control" >
                                          </div>
                                    </div>                                    
                                    <div class="col-md-4 p-t-30">
                                       <button type="submit" name="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Submit</button>
                                    </div>

                                    <div class="col-md-12 p-t-30">
                                       <?php if(isset($success)){ ?>
                                          <div class="alert alert-success"><?php echo $success; ?></div>
                                       <?php }else if(isset($warning)){ ?>
                                          <div class="alert alert-warning"><?php echo $warning; ?></div>
                                       <?php }else if(isset($error)){ ?>
                                          <div class="alert alert-danger"><?php echo $error; ?></div>
                                       <?php } ?>
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
         
         $(function(){

            $('.newModuleBlock').hide();

         });
         $('#menu_module').on('change', function(){

            var val = $(this).val();
            if(val == 0){
               $('.newModuleBlock').show();
            }else{
               $('.newModuleBlock').hide();               
            }

         });

      </script>

   </body>
</html>