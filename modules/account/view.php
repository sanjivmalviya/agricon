<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $login_type = $_SESSION['agricon_credentials']['user_type'];

$accounting = getWhere('tbl_accounting','added_by',$login_id);

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
                           <h4 class="page-title">Accoutings (Payouts)</h4>
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
                                       <th>Sr.</th>
                                       <th>Date</th>
                                       <th>Type</th>
                                       <th>Party</th>
                                       <th>Description</th>
                                       <th>Amount</th>
                                       <th>Note Number</th>
                                       <th>Created at</th>
                                       <th class="text-right">Actions</th>
                           			</thead>

                           			<tbody>
                           				
                           				<?php if(isset($accounting) && count($accounting) > 0){ ?>

                           					<?php $i=1; foreach($accounting as $rs){ ?>

                           					<tr>
                                             <td><?php echo $i++; ?></td>
                                             <td><?php echo date('d-m-Y',$rs['accounting_date']); ?></td>
                                             <td><?php if($rs['accounting_type'] == 1){ echo "<span class='text-primary'>Receipt</span>"; }else { echo "<span class='text-danger'>Credit Note</span>";  } ; ?></td>
                                             <td>
                                             <?php 
                                                $customer_name = getOne('tbl_customer','customer_id',$rs['accounting_party_id']);
                                                echo $customer_name = $customer_name['customer_name']; 
                                             ?>                                                
                                             </td>
                                             <td><?php echo $rs['accounting_description']; ?></td>
                                             <td><?php echo $rs['accounting_amount']; ?></td>
                                             <td><?php echo $rs['accounting_note_number']; ?></td>
                                             <td><?php echo $rs['created_at']; ?></td>                                           
                                             <td class="text-right"><a href=""><i class="fa fa-pencil"></i></a> <a href=""><i class="fa fa-trash"></i></a></td>
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

            $('.danger').popover({ html : true});

         });

      </script>

   </body>
</html>