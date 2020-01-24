<?php

   require_once('../../functions.php');

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
                           <h4 class="page-title">Modules List</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="card-box">
                           <div class="row">

                           	<div class="pull-right">
                           		<a href="../../modules/menus/add.php" class="btn btn-sm btn-primary">+ Add New</a>
                           	</div>

                           		<table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                           			
                           			<thead>
                           				<th>Module Name</th>
                           				<th class="text-right">Actions</th>
                           			</thead>

                           			<tbody>
                           				
                           				<?php if(isset($modules) && count($modules) > 0){ ?>

                           					<?php foreach($modules as $rs){ ?>

                           					<tr>
                           						<td width="50%" ><?php echo ucwords($rs['module_name']); ?></td>
                           						<td width="50%" class="text-right" ><a href="manage_menu.php?module_id=<?php echo $rs['module_id']; ?>" class="btn btn-xs btn-primary">Manage Menu</a> 
                                                <!-- <a href="" class="btn btn-xs btn-danger">Remove</a></td> -->
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