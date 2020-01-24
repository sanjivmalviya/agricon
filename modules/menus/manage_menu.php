<?php

   require_once('../../functions.php');

   $menus = getWhere('tbl_menus','module_id',$_GET['module_id']);
   $module_name = getOne('tbl_modules','module_id',$_GET['module_id']);
   $module_name = $module_name['module_name'];

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
                           <h4 class="page-title"><small>Menu For</small> <?php echo ucwords($module_name); ?></h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="card-box">
                           <div class="row">

                                 <div class="pull-left">
                                    <a href="../../modules/menus/view.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left" style="font-size: 20px;"></i></a>
                                 </div>

                           		<table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                           			
                           			<thead>
                           				<th>Menu Name</th>
                           				<!-- <th class="text-right">Actions</th> -->
                           			</thead>

                           			<tbody>
                           				
                           				<?php if(isset($menus) && count($menus) > 0){ ?>

                           					<?php foreach($menus as $rs){ ?>

                           					<tr>
                           						<td width="50%" ><?php echo ucwords($rs['menu_name']); ?></td>
                           						<!-- <td width="50%" class="text-right" ><a href="" class="btn btn-xs btn-danger">Remove</a></td> -->
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