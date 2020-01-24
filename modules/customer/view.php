<?php



 require_once('../../functions.php');



 $login_id = $_SESSION['agricon_credentials']['user_id'];

 $login_type = $_SESSION['agricon_credentials']['user_type'];



 $table_name = 'tbl_customer';

 $field_name = 'customer_id';



 if(isset($_GET['id']) && $_GET['id'] != ""){

      $customers = getWhere('tbl_customer','meeting_id',$_GET['id']);

 }else{
   
    if($login_type == '1'){

      $customers = getAllByOrder('tbl_customer','customer_id','DESC');

    }else{

      $customers = getRaw('SELECT * FROM tbl_customer WHERE added_by = '.$login_id.' ORDER BY customer_id ASC ');

    }

 }




 if(isset($_GET['delete_id'])){

         

   if(delete($table_name,$field_name,$_GET['delete_id'])){

      $success = "Record Deleted Successfully";

      header('location:view.php');

   }else{

      $error = "Failed to Delete Record";

   }



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

                           <h4 class="page-title">Customers List</h4>

                           <div class="clearfix"></div>

                        </div>

                     </div>

                  </div>

                  <div class="row">

                     <div class="col-sm-12">

                        <div class="card-box">

                           <div class="row">



                           		<div class="col-md-12 table-responsive">

                                 <table id="customers" class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;font-size:12px; ">
                                    
                                    <thead>
                                       <th width="2%">Sr.</th>
                                       <th width="5%">Handled by</th>
                                       <th width="5%">Name</th>
                                       <th width="10%">Address</th>
                                       <th width="5%">At</th>
                                       <th width="5%">Limit</th>
                                       <th width="2%">Detail</th>
                                  
                                       
                                       <th width="2%">Discount Slab</th>
                                       <th width="10%" class="text-right">Actions</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($customers) && count($customers) > 0){ ?>

                                          <?php $i=1; foreach($customers as $rs){ ?>

                                          <tr>
                                             <td><?php echo $i++; ?></td>
                                             <td>
                                             <?php 
                                                $employee_name = getOne('tbl_employee','employee_id',$rs['party_handled_by']);
                                                echo $employee_name = $employee_name['employee_name']; 
                                             ?></td>
                                             <td><?php echo $rs['customer_name']; ?></td>
                                             <td><?php echo $rs['customer_address']; ?></td>
                                             <td><?php echo $rs['customer_at']; ?></td>
                                              <td><?php echo $rs['customer_credit_limit']; ?></td>
                                             <td>
                                             <?php 
                                                $detail_html = "
                                                <table class='table table-striped table-bordered table-condensed'>

                                                <tr>  
                                                   <th>Landline</th>
                                                   <th>Mobile</th>
                                                   <th>GST</th>
                                                   <th>PAN</th>
                                                   <th>D.O.J</th>
                                                   <th>D.O.B</th>
                                                   <th>Fertilizer LIC</th>
                                                   <th>Pesticid LIC</th>
                                                   <th>Adhaar Number</th>
                                                   <th>Contact Person</th>
                                                </tr>
                                                <tr>  
                                                   <td>".$rs['customer_landline']."</td> 
                                                   <td>".$rs['customer_mobile']."</td>
                                                   <td>".$rs['customer_gst']."</td>
                                                   <td>".$rs['customer_pan']."</td>
                                                   <td>".$rs['customer_doj']."</td>
                                                   <td>".$rs['customer_dob']."</td>
                                                   <td>".$rs['customer_fertilizer_lic']."</td>
                                                   <td>".$rs['customer_pesticide_lic']."</td>
                                                   <td>".$rs['customer_aadhaar_number']."</td>
                                                   <td>".$rs['contact_person_name']."</td>
                                                </tr>      
                                                </table>";
                                             ?>
                                                 <!--   <th>Dealer Deposited</th>
                                                   <th>Dealer Security Cheque</th>
                                                   <th>Dealer Cheque Number</th>
                                                   <th>Dealer Bank Name</th>
                                                   <th>Dealer IFSC Code</th> -->
                                              <!--     <td>".$rs['dealer_deposit']."</td>
                                                   <td>".$rs['dealer_security_cheque']."</td>
                                                   <td>".$rs['dealer_cheque_number']."</td>
                                                   <td>".$rs['dealer_bank_name']."</td>
                                                   <td>".$rs['dealer_ifsc_code']."</td>
                                               -->
                                             <a class='danger' data-placement='top' 
                                             data-content="<?php echo $detail_html; ?>" 
                                             title="About Customers" href='#'>Detail</a>
                                             </td>
                                          
                                         
                                             <td><?php if($rs['customer_discount'] == '0') echo "Regular Slab"; else if($rs['customer_discount'] == '1') echo "First Slab"; else if($rs['customer_discount'] == '2') echo "Second Slab"; else if($rs['customer_discount'] == '3') echo "Third Slab"; ?></td>
                                             <td>
                                                <a href="add.php?edit_id=<?php echo $rs['customer_id']; ?>"><i class="fa fa-pencil"></i></a>
                                                <a href="view.php?delete_id=<?php echo $rs['customer_id']; ?>" onclick=" return confirm('Are you sure ?'); "><i class="fa fa-trash"></i></a>
                                             </td>
                                          </tr>
                                          <?php } ?>

                                       <?php } ?>

                                    </tbody>

                                 </table>

                                 </div>



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

   </body>

</html>
