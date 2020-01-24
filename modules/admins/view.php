<?php

   require_once('../../functions.php');

   $admins = getAll('tbl_admins');

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
                           <h4 class="page-title">Admins List</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">

                           		<table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                           			
                           			<thead>
                                       <th>Profile</th>
                           				<th>Admin Name</th>
                           				<th class="text-right">Actions</th>
                           			</thead>

                           			<tbody>
                           				
                           				<?php if(isset($admins) && count($admins) > 0){ ?>

                           					<?php foreach($admins as $rs){ ?>

                           					<tr>
                                             <td width="10%" class="text-center" style="padding: 15px;"><img src="../../<?php echo $rs['admin_profile']; ?>" alt="" width="50" height="50" class="img-circle"></td>
                           						<td width="40%" style="padding: 15px;"><span style="line-height: 50px;"></span><?php echo ucwords($rs['admin_name']); ?></td>
                           						<td width="50%" style="padding: 15px;" class="text-right" ><span style="line-height: 50px;"><a href="manage_roles.php?admin_id=<?php echo $rs['admin_id']; ?>" class="btn btn-xs btn-default">Manage Roles</a> 

                                                <!-- <a href="edit.php?admin_id=<?php echo $rs['admin_id']; ?>" class="btn btn-xs btn-primary">Edit</a> <a href="" class="btn btn-xs btn-danger">Remove</a></span> -->
                                             </td>
                           					</tr>

                           					<?php } ?>

                           				<?php } ?>

                           			</tbody>

                           		</table>
                      
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