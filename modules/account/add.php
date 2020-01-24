

<?php



   require_once('../../functions.php');



   $login_id = $_SESSION['agricon_credentials']['user_id'];



   $packings = getAll('tbl_packing');

   $customers = getWhere('tbl_customer','added_by',$login_id);



   if(isset($_POST['submit'])){



	   	$form_data = array(	

   		'added_by' => $login_id,

   		'accounting_date' => $_POST['accounting_date'],

			'accounting_type' => $_POST['accounting_type'],

			'accounting_party_id' => $_POST['accounting_party'],

			'accounting_description' => $_POST['accounting_description'],

			'accounting_amount' => $_POST['accounting_amount'],

			'accounting_note_number' => $_POST['accounting_number']

	   	);

         // echo "<pre>";
         // print_r($form_data);
         // exit;



	    if(insert('tbl_accounting',$form_data)){              

			$success = "Accounting Addded Successfully";



         // create customer outstanding

         $form_data = array(

            'customer_id' => $_POST['accounting_party'],

            'customer_outstanding_type' => $_POST['accounting_type'],

            'customer_outstanding_amount' => $_POST['accounting_amount'],

            'customer_outstanding_date' => date('Y-m-d', strtotime($_POST['accounting_date']))

         ); 

         insert('tbl_customer_outstanding',$form_data);



	     }else{

	        $error = "Failed to Add Accounting";

	 	}		   		



   }



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

                           <h4 class="page-title">Add Accounting</h4>

                           <div class="clearfix"></div>

                        </div>

                     </div>                   

                  </div>

                  <div class="row">   

                     

                     <div class="col-sm-12">

                        <div class="card-box">

                           <div class="row">



                               <form method="post" class="form-horizontal">

                                 <div class="col-md-12">



                                    <div class="row">



                                    	<div class="col-md-4">

                                          <div class="form-group">

                                             <label for="accounting_date">Date<span class="text-danger">*</span></label>

                                             <input type="date" name="accounting_date" parsley-trigger="change" required="" placeholder="" class="form-control" id="accounting_date">

                                          </div>

                                       </div>



                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="accounting_type">Type<span class="text-danger">*</span></label>

                                             <select name="accounting_type" parsley-trigger="change" required="" class="form-control select2" id="accounting_type">

                                             	<option value="1">Receipt</option>
                                             	<!-- <option value="2">Credit Note</option> -->
                                                
                                             </select>

                                          </div>

                                       </div>



                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="accounting_party">Party (Customer)<span class="text-danger">*</span></label>

                                             <select name="accounting_party" parsley-trigger="change" required="" class="form-control select2" id="accounting_party">

                                             	<?php if(isset($customers)){ ?>



                                             		<?php foreach($customers as $rs){ ?>



                                             			<option value="<?php echo $rs['customer_id']; ?>"><?php echo $rs['customer_name']; ?></option>



                                             		<?php } ?>



                                             	<?php } ?>

                                             </select>

                                          </div>

                                       </div>



                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="accounting_amount">Amount<span class="text-danger">*</span></label>

                                             <input type="text" name="accounting_amount" parsley-trigger="change" required="" class="form-control select2" id="accounting_amount">

                                          </div>

                                       </div>



                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="accounting_number">Receipt/Credit Number<span class="text-danger">*</span></label>

                                             <input type="text" name="accounting_number" parsley-trigger="change" required="" class="form-control select2" id="accounting_number">

                                          </div>

                                       </div>



                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="accounting_description">Description<span class="text-danger">*</span></label>

                                             <textarea name="accounting_description" parsley-trigger="change" required="" class="form-control select2" id="accounting_description"></textarea>

                                          </div>

                                       </div>



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



                                       <div class="col-md-12" align="left">

                                          <button type="submit" name="submit" id="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Submit</button>

                                       </div>

                                    </div>

                                 </div>

                              </form>

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
