<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $login_type = $_SESSION['agricon_credentials']['user_type'];

 $employee_id = $_GET['id'];

 $detail = getOne('tbl_employee','employee_id',$employee_id);


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
                           <h4 class="page-title">Employee Detail</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">

                           		<table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">

                                    <tbody>
                                       
                                       <tr>
                                          <th colspan="2" class="text-center">EMPLOYEE PROFILE</th>
                                       </tr>

                                       <tr>
                                          <td width="50%"><b>Name</b></td>
                                          <td width="50%"><?php echo $detail['employee_name']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Designation</b></td>
                                          <td><?php echo $detail['employee_designation']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>H.Q.</b></td>
                                          <td><?php echo $detail['employee_hq']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Mobile Number</b></td>
                                          <td><?php echo $detail['employee_mobile']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Date of Joining</b></td>
                                          <td><?php echo $detail['employee_doj']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Date of Birth</b></td>
                                          <td><?php echo $detail['employee_dob']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>PAN Number</b></td>
                                          <td><?php echo $detail['employee_pan']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Email</b></td>
                                          <td><?php echo $detail['employee_email']; ?></td>
                                       </tr>
                                       <tr>
                                          <td>View Aadhaar</td>
                                          <td><a href="<?php echo $detail['employee_aadhaar']; ?>"><?php if(isset($detail['employee_aadhaar']) && $detail['employee_aadhaar'] != ""){echo $detail['employee_aadhaar']; }else{ echo "N/A"; } ?></a></td>
                                       </tr>
                                       <tr>
                                          <td><b>Aadhaar Number</b></td>
                                          <td><?php echo $detail['employee_aadhaar_number']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Spouse Name</b></td>
                                          <td><?php echo $detail['employee_spouse_name']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Spouse Mobile</b></td>
                                          <td><?php echo $detail['employee_spouse_mobile']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Employee Type</b></td>
                                          <td><?php echo ($detail['employee_type'] == '1') ? 'Office Employee' : 'Marketing Employee' ; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>App Order Access</b></td>
                                          <td><?php echo ($detail['employee_order_access'] == '1') ? 'Yes' : 'No' ; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Shop Number</b></td>
                                          <td><?php echo $detail['shop_number']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Shop Phone Number</b></td>
                                          <td><?php echo $detail['shop_phone_number']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Customer State</b></td>
                                          <td><?php echo $detail['customer_state']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Customer Photo</b></td>
                                          <td><?php echo $detail['customer_photo']; ?></td>
                                       </tr>

                                       <tr>
                                          <th colspan="2" class="text-center">SALARY DETAILS</th>
                                       </tr>

                                       <tr>
                                          <td><b>Basic Salary</b></td>
                                          <td><?php echo $detail['employee_monthly_basic_salary']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Monthly HRA</b></td>
                                          <td><?php echo $detail['employee_monthly_hra']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Monthly Da</b></td>
                                          <td><?php echo $detail['employee_monthly_da']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Monthly Extra Allowances</b></td>
                                          <td><?php echo $detail['employee_monthly_extra_allowances']; ?></td>
                                       </tr>

                                       <tr>
                                          <th colspan="2" class="text-center">TIMESTAMPS</th>
                                       </tr>

                                       <tr>
                                          <td><b>Updated at</b></td>
                                          <td><?php echo $detail['updated_at']; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Created at</b></td>
                                          <td><?php echo $detail['created_at']; ?></td>
                                       </tr>
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
