<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $login_type = $_SESSION['agricon_credentials']['user_type'];
 
if($login_type == '1'){

   $customers = getAll('tbl_customer_outstanding');

 }else{

   $customers = "SELECT * FROM tbl_customer_outstanding a INNER JOIN tbl_customer b ON a.customer_id = b.customer_id WHERE b.added_by = '$login_id' ";
   $customers = getRaw($customers);   

 } 

 if(isset($_POST['submit'])){

      $start_date = date('Y-m-d', strtotime($_POST['start_date']));
      $end_date = date('Y-m-d', strtotime($_POST['end_date']));

      $customers = "SELECT * FROM tbl_customer_outstanding WHERE customer_outstanding_date BETWEEN '$start_date' AND '$end_date'";
      $customers = getRaw($customers);

 }

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
      <?php require_once('../../include/headerscript.php'); ?>
   </head>
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
                           <h4 class="page-title">Customer Outstandings</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">

                           <div class="row">
                              
                              <form method="post">
                                 
                                 <div class="col-md-4">
                                    <label for="">Start Date : </label>
                                    <input type="date" name="start_date" class="form-control" name="start_date">
                                 </div>

                                 <div class="col-md-4">
                                    <label for="">End Date : </label>
                                    <input type="date" name="end_date" class="form-control" name="start_date">
                                 </div>

                                 <div class="col-md-4">
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-md" name="submit"><i class="fa fa-filter"></i>  Filter</button>
                                 </div>

                              </form>

                                 



                           </div>
                           
                           <div class="row" style="margin-top: 10px;">
                              <div class="col-md-12">                                 
                                 <?php if(isset($start_date) && isset($end_date)){ ?>
                                 <h4 class="text-muted">Records between <span class="text-primary"><?php echo date('d-m-Y',strtotime($start_date)); ?></span> AND <span class="text-primary"><?php echo date('d-m-Y', strtotime($end_date)); ?></span></h4>
                                 <?php }else{ ?>
                                    <h4 class="text-muted">All Records</h4>
                                 <?php } ?>
                              </div>
                           </div>

                           <div class="row">

                           		<table class="table table-striped table-bordered table-condensed table-hover">
                           			
                           			<thead>
                                       <th>Sr.</th>
                                       <th>Customer</th>
                                       <th>Outstanding Type</th>
                                       <th>Outstanding Amount</th>
                                       <th>Outstanding Date</th>
                           			</thead>

                           			<tbody>
                           				
                           				<?php 
                                       $total_debit = 0;
                                       $total_credit = 0;
                                       if(isset($customers) && count($customers) > 0){ ?>

                           					<?php $i=1; foreach($customers as $rs){ ?>

                           					<tr>
                                             <td><?php echo $i++; ?></td>
                                         
                                             <td>
                                             <?php 
                                                $customer_name = getOne('tbl_customer','customer_id',$rs['customer_id']);
                                                echo $customer_name = $customer_name['customer_name']; 
                                             ?></td>
                                             <td><?php

                                                if($rs['customer_outstanding_type'] == 1){ 
                                                   $total_debit += $rs['customer_outstanding_amount'];  
                                                   echo "<span class='text-primary'> + Debit </span>"; 
                                                }else{
                                                   $total_credit += $rs['customer_outstanding_amount'];
                                                   echo "<span class='text-danger'> - Credit </span>"; 
                                                 } ?>
                                             </td>
                                             <td><?php echo $rs['customer_outstanding_amount']; ?></td>
                                             <td><?php echo $rs['customer_outstanding_date']; ?></td>
                           					</tr>
                           					<?php } ?>

                           				<?php } ?>

                           			</tbody>

                           		</table>

                                 <div class="col-md-12 text-center">
                                    <span class="text-danger">Total Credit :</span> <?php echo number_format($total_credit,2); ?><br> 
                                    <span class="text-primary">Total Debit :</span> <?php echo number_format($total_debit,2); ?> <br>
                                    <h4>Outstanding Balance : <?php $balance = $total_debit - $total_credit; echo number_format($balance,2); ?></h4> 
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