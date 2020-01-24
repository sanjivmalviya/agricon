<?php

   require_once('../../functions.php');

   $admin_id = $_GET['admin_id'];
   $admin = getOne('tbl_admins','admin_id',$admin_id);
   $admin_name = $admin['admin_name'];

   $menus = getAll('tbl_menus');
   $roles = getWhere('tbl_user_roles','admin_id',$admin_id);

   $existing_roles = array();

   if(isset($roles) && count($roles) > 0){
   
      foreach ($roles as $rs) {
         
         $existing_roles[] = $rs['menu_id']; 
         
      }
      
   }

   if(isset($_POST['submit'])){
      
      delete('tbl_user_roles','admin_id',$admin_id);

      if(isset($_POST['role_access']) && !empty($_POST['role_access'])){

         foreach($_POST['role_access'] as $role){

               $form_data = array(
                  'admin_id' => $admin_id,
                  'menu_id' => $role
               );

               if(insert('tbl_user_roles',$form_data)){
                  
                  $success = "Access Granted";

               }else{
                  
                  $error = "Failed to Grant Access";

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
                     <div class="col-xs-12">
                        <div class="page-title-box">
                           <h4 class="page-title"><small>Manage Role for </small><?php echo $admin_name; ?></h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="card-box">
                           <div class="row">

                              <a href="../../modules/admins/view.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left" style="font-size: 20px;"></i></a>

                              <div class="text-right">
                                 <label for="select_all">Select All 
                                    <input type="checkbox" id="select_all">
                                 </label> 
                              </div>

                              
                              <form method="post" style="margin-top: 20px;">

                           		<table class="table table-striped table-bordered table-condensed table-hover">
                           			
                           			<thead>
                           				<th>Features</th>
                           				<th class="text-center">Access</th>
                           			</thead>

                           			<tbody>
                           				
                           				<?php if(isset($menus) && count($menus) > 0){ ?>

                           					<?php 

                                             foreach($menus as $rs){

                                                $module_name = getOne('tbl_modules','module_id',$rs['module_id']);
                                                $module_name = $module_name['module_name'];

                                          ?>

                           					<tr>
                           						<td width="90%" ><b><span class="text-primary"><?php echo ucwords($module_name)."</span> <i class='fa fa-arrow-right'></i> <span class='text-primary'>".ucwords($rs['menu_name']); ?></span></b></td>
                           						<td width="10%" class="text-center"><input type="checkbox" class="check" <?php if(in_array($rs['menu_id'], $existing_roles)){ echo "checked"; } ?> value="<?php echo $rs['menu_id']; ?>" name="role_access[]"></td>
                           					</tr>

                           					<?php } ?>

                           				<?php } ?>

                           			</tbody>

                           		</table>
                      
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
                                       
                                       <button type="submit" name="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Grant Access</button>
                                    
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
         
         $('#select_all').on('click', function(){

            if($(this).prop('checked') == true){
               $('.check').prop('checked',true);               
            }

            if($(this).prop('checked') == false){
               $('.check').prop('checked',false);               
             
            }


         });

      </script>

   </body>
</html>