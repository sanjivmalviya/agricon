<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['nb_credentials']['user_id'];
 $login_type = $_SESSION['nb_credentials']['user_type'];

 $date = date('d-m-Y');

 $recovery = getWhere('tbl_customer_recovery','meeting_id',$_GET['id']);

 $remark = getOne('tbl_customer_remark','meeting_id',$_GET['id']);

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
                           <!-- <h4 class="page-title">Farmer Details</h4> -->
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">
                           
                           <div class="row">

                                 <div class="col-md-12">

                                 <h4> Recovery Details : </h4>
                                    
                                 </div>  


                                 <table class="table table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                    
                                    <thead>
                                       <tr>
                                          <th>Sr.</th>
                                          <th>Customer</th>
                                          <th>Employee</th>
                                          <th>Transaction Type</th>
                                          <th>Cheque Date</th>
                                          <th>Cheque Photo</th>
                                          <th>Amount</th>
                                          <th>Commitment Date</th>
                                          <th>Created at</th>
                                       </tr>
                                    </thead>

                                    <tbody>
                                       
                                       <?php $m=0; if(isset($recovery) && count($recovery) > 0){ ?>

                                          <?php  

                                          $sr = 1;

                                          foreach($recovery as $rs){ ?>

                                          <tr>
                                             <td><?php echo $sr++; ?></td>
                                             <td>
                                                <?php 
                                                   
                                                   $customer_name = getOne('tbl_customer','customer_id',$rs['customer_id']);
                                                   echo $customer_name = $customer_name['customer_name'];
                                                ?>
                                                </td>
                                             <td><?php 

                                                   $employee_name = getOne('tbl_employee','employee_id',$rs['employee_id']);
                                                   echo $employee_name = $employee_name['employee_name'];
                                              ?></td>
                                             <td><?php if($rs['transaction_type']== 1){ echo "Cheque"; }else{ echo "RTGS"; } ?></td>
                                             <td><?php echo $rs['cheque_date']; ?></td>
                                             <td><?php echo $rs['cheque_photo']; ?></td>
                                             <td><?php echo $rs['amount']; ?></td>
                                             <td><?php echo $rs['commitment_date']; ?></td>
                                             <td><?php echo $rs['created_at']; ?></td>
                                          </tr>

                                       <?php } }else{ ?>

                                          <tr>
                                             <td colspan="6" class="text-center">No Records Found</td>
                                          </tr>

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

                        <div class="card-box">
                           
                           <div class="row">

                                 <div class="col-md-12">

                                    <h4> Remark : </h4>
                                    
                                 </div>  
                      
                           </div>


                                 <div class="row">
                                    
                                    <div class="col-md-12">

                                       <p><?php echo $remark['remark']; ?></p>

                                       
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
