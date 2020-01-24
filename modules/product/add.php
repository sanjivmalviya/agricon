

<?php



   require_once('../../functions.php');



   $login_id = $_SESSION['agricon_credentials']['user_id'];



   $sub_categorories = getAll('tbl_sub_category');



   $table_name = 'tbl_product';

   $field_name = 'product_id';

    

   if(isset($_POST['submit'])){

    

    $form_data = array(

      'added_by' => $login_id, // admin id 

      'sub_category_id' => $_POST['sub_category_id'],

      'product_name' => $_POST['product_name'],

      'product_packaging' => $_POST['product_packaging'],

      'product_billing_rate' => $_POST['product_billing_rate'],

      'product_gst' => $_POST['product_gst'],

      'product_hsn_code' => $_POST['product_hsn_code'],

      'product_batch_number' => $_POST['product_batch_number'],

      'product_discount' => $_POST['product_discount'],

      'product_discount2' => $_POST['product_discount2'],

      'product_discount3' => $_POST['product_discount3'],

      'product_unit' => $_POST['product_unit']

     );


     if(insert('tbl_product',$form_data)){

         $success = "Product Added Successfully";

     }else{

         $error = "Failed to add Product, try again later";

     }      

   }



   $packings = getAll('tbl_packing');

   $units = getAll('tbl_unit');



   if(isset($_GET['edit_id'])){



         $edit_data = getOne($table_name,$field_name,$_GET['edit_id']);         

         $edit_data = array(

           'added_by' => $login_id,

           'sub_category_id' => $edit_data['sub_category_id'],

           'product_name' => $edit_data['product_name'],

           'product_packaging' => $edit_data['product_packaging'],

           'product_billing_rate' => $edit_data['product_billing_rate'],

           'product_gst' => $edit_data['product_gst'],

           'product_hsn_code' => $edit_data['product_hsn_code'],

           'product_batch_number' => $edit_data['product_batch_number'],

           'product_discount' => $edit_data['product_discount'],

           'product_discount2' => $edit_data['product_discount2'],

           'product_discount3' => $edit_data['product_discount3'],

           'product_unit' => $edit_data['product_unit']

         );



   }



  if(isset($_POST['update'])){



    // POST DATA

 

      $form_data = array(

        'added_by' => $login_id,

        'sub_category_id' => $_POST['sub_category_id'],

        'product_name' => $_POST['product_name'],

        'product_packaging' => $_POST['product_packaging'],

        'product_billing_rate' => $_POST['product_billing_rate'],

        'product_gst' => $_POST['product_gst'],

        'product_hsn_code' => $_POST['product_hsn_code'],

        'product_batch_number' => $_POST['product_batch_number'],

        'product_discount' => $_POST['product_discount'],

        'product_discount2' => $_POST['product_discount2'],

        'product_discount3' => $_POST['product_discount3'],

        'product_unit' => $_POST['product_unit']

      );



         if(update($table_name,$field_name,$_GET['edit_id'],$form_data)){

             $success = "Product Updated Successfully";

         }else{

             $error = "Failed to update Product, try again later";

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

                           <h4 class="page-title">Add Product</h4>

                           <div class="clearfix"></div>

                        </div>

                     </div>                   

                  </div>

                  <div class="row">   

                     

                     <div class="col-sm-12">

                        <div class="card-box">

                           <div class="row">

                              <form method="post" class="form-horizontal" role="form">

                                 <div class="col-md-12">

                                    <div class="row">

                                       <div class="col-md-6">

                                          <div class="form-group">

                                             <label for="userName">Choose Category<span class="text-danger">*</span></label>

                                             <select name="sub_category_id" class="form-control select2">

                                                <?php if(isset($sub_categorories) && count($sub_categorories) > 0){ ?>



                                                  <?php foreach($sub_categorories as $rs){ ?>



                                                      <option <?php if(isset($edit_data['sub_category_id']) && $edit_data['sub_category_id'] == $rs['sub_category_id']){ echo "selected";  } ?> value="<?php echo $rs['sub_category_id']; ?>"><?php echo $rs['sub_category_name']; ?></option>



                                                  <?php } ?>

                                                <?php } ?>

                                             </select>

                                          </div>

                                       </div>

                                    </div>

                                    <div class="row">

                                       <div class="col-md-6">

                                          <div class="form-group">

                                             <label for="product_name">Product Name<span class="text-danger">*</span></label>

                                             <input type="text" name="product_name" parsley-trigger="change" required=""  class="form-control" id="product_name" value="<?php if(isset($edit_data['product_name'])){ echo $edit_data['product_name']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-6">

                                          <div class="form-group">

                                             <label for="product_packaging">Packing<span class="text-danger">*</span></label>



                                             <select  name="product_packaging" parsley-trigger="change" required=""  class="form-control select2" id="product_packaging">

                                             	<?php if(isset($packings)){ ?>

                                             		<?php foreach($packings as $rs){ ?>



                                             			<option <?php if(isset($edit_data['product_packaging']) && $edit_data['product_packaging'] == $rs['packing_id']){ echo "selected";  } ?> value="<?php echo $rs['packing_id']; ?>"><?php echo $rs['packing_name']; ?></option>



                                             		<?php } ?>

                                             	<?php } ?>

                                             </select>

                                          </div>

                                       </div>

                                       <div class="col-md-6">

                                          <div class="form-group">

                                             <label for="product_billing_rate">Biling Rate<span class="text-danger">*</span></label>

                                             <input type="text" name="product_billing_rate" parsley-trigger="change" required=""  class="form-control" id="product_billing_rate" value="<?php if(isset($edit_data['product_billing_rate'])){ echo $edit_data['product_billing_rate']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-6">

                                          <div class="form-group">

                                             <label for="product_gst">GST<span class="text-danger">*</span></label>

                                             <select name="product_gst" class="form-control select2">

                                                <option <?php if(isset($edit_data['product_gst']) && $edit_data['product_gst'] == '5'){ echo "selected";  } ?> value="5" >5%</option>

                                                <option <?php if(isset($edit_data['product_gst']) && $edit_data['product_gst'] == '12'){ echo "selected";  } ?> value="12">12%</option>

                                                <option <?php if(isset($edit_data['product_gst']) && $edit_data['product_gst'] == '18'){ echo "selected";  } ?> value="18">18%</option>

                                                

                                             </select>

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="product_hsn_code">HSN Code</label>

                                             <input type="text" name="product_hsn_code" parsley-trigger="change" class="form-control" id="product_hsn_code" value="<?php if(isset($edit_data['product_hsn_code'])){ echo $edit_data['product_hsn_code']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="product_batch_number">Batch No</label>

                                             <input type="text" name="product_batch_number" parsley-trigger="change" class="form-control" id="product_batch_number" value="<?php if(isset($edit_data['product_batch_number'])){ echo $edit_data['product_batch_number']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="product_unit">Unit</label>

                                             <select  name="product_unit" parsley-trigger="change"  class="form-control select2" id="product_unit">

                                              <?php if(isset($units)){ ?>

                                                <?php foreach($units as $rs){ ?>



                                                  <option <?php if(isset($edit_data['product_unit']) && $edit_data['product_unit'] == $rs['unit_id']){ echo "selected";  } ?> value="<?php echo $rs['unit_id']; ?>"><?php echo $rs['unit_name']; ?></option>



                                                <?php } ?>

                                              <?php } ?>

                                             </select>

                                             <!-- <input type="text" name="product_unit" parsley-trigger="change" required=""  class="form-control" id="product_unit"> -->

                                          </div>

                                       </div>

                                       <div class="clearfix"></div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="product_discount">Discount 1</label>

                                             <input type="text" name="product_discount" parsley-trigger="change" class="form-control" id="product_discount" value="<?php if(isset($edit_data['product_discount'])){ echo $edit_data['product_discount']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="product_discount2">Discount 2</label>

                                             <input type="text" name="product_discount2" parsley-trigger="change" class="form-control" id="product_discount2" value="<?php if(isset($edit_data['product_discount2'])){ echo $edit_data['product_discount2']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="product_discount3">Discount 3</label>

                                             <input type="text" name="product_discount3" parsley-trigger="change" class="form-control" id="product_discount3" value="<?php if(isset($edit_data['product_discount3'])){ echo $edit_data['product_discount3']; } ?>">

                                          </div>

                                       </div>

                                       

                                      

                                    </div>

                                    <div class="row">

                                       <div class="col-md-12" align="left">



                                          <div class="col-md-12 p-t-30">

                                            <?php if(isset($success)){ ?>

                                               <div class="alert alert-success"><?php echo $success; ?></div>

                                            <?php }else if(isset($warning)){ ?>

                                               <div class="alert alert-warning"><?php echo $warning; ?></div>

                                            <?php }else if(isset($error)){ ?>

                                               <div class="alert alert-danger"><?php echo $error; ?></div>

                                            <?php } ?>

                                         </div> 

                                          

                                          <div class="col-md-12" align="right">

                                             <?php if(isset($edit_data)){ ?>                                             

                                               <button type="submit" name="update" id="update" class="btn btn-danger btn-bordered waves-effect w-md waves-light m-b-5">Update</button>

                                            <?php }else{ ?>

                                               <button type="submit" name="submit" id="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Submit</button>

                                            <?php } ?>

                                          </div>

                                       

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