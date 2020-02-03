<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['agricon_credentials']['user_id'];

   $table_name = "employee_applied_leaves";
   $field_name = "id"; 

   $leaves = "SELECT *,(SELECT employee_name FROM tbl_employee WHERE employee_id = lv.employee_id) as employee_name FROM employee_applied_leaves lv ORDER BY created_at DESC";
   $leaves = getRaw($leaves);

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

                           <h4 class="page-title">Leave Applications</h4>

                           <div class="clearfix"></div>

                        </div>

                     </div>                   

                  </div>

                    <div class="row">   

                     <div class="col-sm-12">

                        <div class="card-box table-responsive">
                            
                            <table id="products" class="table table-condensed table-bordered">
                              <thead>
                                <tr>
                                  <th>Sr.</th>
                                  <th width="30%">Employee</th>
                                  <th>Date From</th>
                                  <th>Date To</th>
                                  <th>Days</th>
                                  <th class="text-center">Approve Status</th>
                                  <th>Applied at</th>
                                </tr>
                              </thead>

                              <tbody>
                                <?php if(isset($leaves)){ ?>
                                  <?php $i=1; foreach($leaves as $rs){ ?>
                                    <tr>
                                      <td><?php echo $i++; ?></td>
                                      <td><?php echo $rs['employee_name']; ?></td>
                                      <td><?php echo date('d-m-Y', strtotime($rs['from_date'])); ?></td>
                                      <td><?php echo date('d-m-Y', strtotime($rs['to_date'])); ?></td>
                                      <td><?php echo $rs['days']; ?></td>
                                      <td class="text-center" width="15%"><?php if($rs['approve_status'] == 0){ ?> <a class="btn btn-primary btn-xs approve_leave" id="<?php echo $rs['id']; ?>" >Approve</a> <?php }else{ echo "<span class='text-primary'>Approved</span>"; } ?></td>
                                      <td><?php echo date('d-m-Y h:i', strtotime($rs['created_at'])); ?></td>
                                    </tr>
                                  <?php } ?>
                                <?php } ?>
                              </tbody>
                            </table>

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
        
        $('.approve_leave').on('click', function(){

          var id = $(this).attr('id');

          $.ajax({

            url : 'ajax/approve_leave.php',
            type : 'POST',
            dataType : 'JSON',
            data : { id : id },
            success : function(data){
              // console.log(data);
              alert(data.msg)
            }

          });

        });

      </script>

   </body>

</html>
