<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['nb_credentials']['user_id'];
 $login_type = $_SESSION['nb_credentials']['user_type'];

 $date = date('d-m-Y');

 $customer = getWhere('tbl_customer','meeting_id',$_GET['id']);
 $crops = getWhere('tbl_farmer_crop_details','meeting_id',$_GET['id']);

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

                                 <h4> Farmer Details : </h4>
                                    
                                 </div>  


                                 <table class="table table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                    
                                    <thead>
                                       <tr>
                                          <th>Sr.</th>
                                          <th>Photo</th>
                                          <th>Farmer Name</th>
                                          <th>Address</th>
                                          <th>Village</th>
                                          <th>Taluka</th>
                                          <th>District</th>
                                          <th>Mobile</th>
                                          <th>Dealer Name</th>
                                          <th>Total Acre</th>
                                          <th>Created at</th>
                                       </tr>
                                    </thead>

                                    <tbody>
                                       
                                       <?php $m=0; if(isset($farmer) && count($farmer) > 0){ ?>

                                          <?php  

                                          $sr = 1;

                                          foreach($farmer as $rs){ ?>

                                          <tr>
                                             <td><?php echo $sr++; ?></td>
                                             <td><?php echo $rs['farmer_photo']; ?></td>
                                             <td><?php echo $rs['farmer_name']; ?></td>
                                             <td><?php echo $rs['farmer_address']; ?></td>
                                             <td><?php echo $rs['farmer_village']; ?></td>
                                             <td><?php echo $rs['farmer_taluka']; ?></td>
                                             <td><?php echo $rs['farmer_district']; ?></td>
                                             <td><?php echo $rs['farmer_mobile']; ?></td>
                                             <td><?php echo $rs['farmer_dealer_name']; ?></td>
                                             <td><?php echo $rs['farmer_total_acre']; ?></td>
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

                           <div class="row">

                                 <div class="col-md-12">

                                 <h4> Crop Details : </h4>
                                    
                                 </div>  


                                 <table class="table table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                    
                                    <thead>
                                       <tr>
                                          <th>Sr.</th>
                                          <th>Crop Name</th>
                                          <th>Acre</th>
                                          <th>Date of Plantation</th>
                                          <th>Crop Condition</th>
                                          <th>Recommendation</th>
                                          <th>Created at</th>
                                       </tr>
                                    </thead>

                                    <tbody>
                                       
                                       <?php $m=0; if(isset($crops) && count($crops) > 0){ ?>

                                          <?php  

                                          $sr = 1;
                                          foreach($crops as $rs){ ?>

                                          <tr>
                                             <td><?php echo $sr++; ?></td>
                                             <td><?php echo $rs['crop_name']; ?></td>
                                             <td><?php echo $rs['acre']; ?></td>
                                             <td><?php echo $rs['date_of_plantation']; ?></td>
                                             <td><?php echo $rs['crop_condition']; ?></td>
                                             <td><?php echo $rs['recommendation']; ?></td>
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
