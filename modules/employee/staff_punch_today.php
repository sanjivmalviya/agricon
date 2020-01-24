<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $login_type = $_SESSION['agricon_credentials']['user_type'];

 $punchings = getRaw('SELECT * FROM tbl_staff_employee_routine WHERE day_in LIKE "'.date('d-m-Y').'%" ORDER BY routine_id DESC');

?>
<!DOCTYPE html>
<html>
   <head>
      <style>
         .popover{
            z-index: 99999 !important;
            max-width: 100% !important;
            width: 100% !important;
         }
      </style>
   </head>
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
                           <h4 class="page-title">Punchings</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">

                                 <div class="col-md-6">
                                    <h4>All Records</h4>
                                 </div>
                                 <div class="col-md-6 text-right">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                      <a href="staff_punch_all.php" class="btn btn-secondary">All</a>
                                      <a href="javascript:;" class="btn btn-secondary active">Today</a>
                                    </div>
                                 </div>

                           		<table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                           			
                           			<thead>
                                       <th>Sr.</th>
                                       <th>Employee</th>
                                       <th>Date</th>
                                       <th class="text-primary">Day In</th>
                                       <th class="text-info">Lunch In</th>
                                       <th class="text-info">Lunch Out</th>           
                                       <th class="text-primary">Day Out</th>           
                           			</thead>

                           			<tbody>
                           				
                           				<?php if(isset($punchings) && count($punchings) > 0){ ?>

                           					<?php $i=1; foreach($punchings as $rs){ ?>

                           					<tr>
                                             <td><?php echo $i++; ?></td>
                                             <td>
                                                  <?php 
                                                   $employee_name = getOne('tbl_employee','employee_id',$rs['employee_id']);
                                                   echo $employee_name['employee_name'];
                                                ?>
                                             </td>
                                             <td><?php echo date('d-m-Y', strtotime($rs['created_at'])); ?></td>
                                             <td class="text-primary"><?php echo $rs['day_in']; ?></td>
                                             <td class="text-info"><?php echo $rs['lunch_in']; ?></td>
                                             <td class="text-info"><?php echo $rs['lunch_out']; ?></td>
                                             <td class="text-primary"><?php echo $rs['day_out']; ?></td>
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
                                 </div>
                      
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

            $('.danger').popover({ html : true});

         });

      </script>

   </body>
</html>
