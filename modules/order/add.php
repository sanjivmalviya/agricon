<?php

require_once('../../functions.php');

$login_id = $_SESSION['agricon_credentials']['user_id'];
$order_id = $_GET['order_id'];

if(!isset($order_id) || !isExists('tbl_order_detail','order_id',$order_id)){
   header('location:view.php');
}

$products = getWhere('tbl_product','added_by',$login_id);

if(isset($_POST['submit'])){

  $order_product_cgst = ""; 
  $order_product_sgst = ""; 
  $order_product_igst = ""; 

  
  $customer_gst_type = getOne('tbl_orders','order_id',$order_id);
  $customer_gst_type = $customer_gst_type['customer_gst_type'];
  
  $product = getOne('tbl_product','product_id',$_POST['product_id']);

  if($customer_gst_type == 1){
     $order_product_cgst =  $product['product_gst'] / 2;
     $order_product_sgst = $order_product_cgst; 
  }else{
     $order_product_igst =  $product['product_gst'];
  }

  $form_data = array(
     'order_id' => $order_id,
     'order_product_id' => $_POST['product_id'],
     'order_product_quantity' => $_POST['quantity'],
     'order_dispatch_quantity' => 0,
     'order_product_rate' => $_POST['rate'],
     'order_product_discount' => $_POST['discount'],
     'order_product_cgst' => $order_product_cgst,
     'order_product_sgst' => $order_product_sgst,
     'order_product_igst' => $order_product_igst
  );                  

  if(insert('tbl_order_detail',$form_data)){
     $success= "Item Added Successfully";                              
  }else{
     $error = "Failed to add item, try again later";
  }

}

?>
<!DOCTYPE html>
<html>
   
   <head>
     
      <!-- Print Formatting CSS -->
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

            <a href="../../modules/order/edit.php?order_id=<?php echo $order_id; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-left" style="font-size: 20px;"></i></a>

            <!-- <a href="../../modules/order/add.php" class="btn btn-primary pull-right">+ Add Product</a>          -->

            <section style="padding-top:2%; padding-bottom:2%;">

              <form method="post">

                <div class="row">
                <div class="col-md-4 col-md-offset-4">

                 <table class="table table-condensed table-striped table-bordered">
                  
                    <tr>
                      <td>
                        <select class="form-control select2" name="product_id" required="">
                          <option value="">--Select Product--</option>

                          <?php if(isset($products)){ ?>

                            <?php foreach($products as $rs){ ?>

                              <option value="<?php echo $rs['product_id']; ?>"><?php echo $rs['product_name']; ?></option>
                            
                            <?php } ?>   

                          <?php } ?>   
                        </select>
                      </td>
                    </tr>

                    <tr>
                       <td>
                        <input type="text" class="form-control" name="quantity" placeholder="enter quantity" required="">
                       </td>
                    </tr>

                    <tr>
                       <td>
                        <input type="text" class="form-control" name="rate" placeholder="enter rate" required="">
                       </td>
                    </tr>

                    <tr>
                       <td>
                        <input type="text" class="form-control" name="discount" placeholder="enter discount" required="">
                       </td>
                    </tr>
                  
                 </table>
                </div>
                </div>

                <div class="row">

                  <div class="col-md-4 col-md-offset-4 p-t-30">
                    <?php if(isset($success)){ ?>
                       <div style="color:black !important;" class="alert alert-success"><i class="fa fa-check"></i> <?php echo $success; ?></div>
                    <?php }else if(isset($warning)){ ?>
                       <div style="color:black !important;" class="alert alert-warning"><?php echo $warning; ?></div>
                    <?php }else if(isset($error)){ ?>
                       <div style="color:black !important;" class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>
                 </div> 
                 
                 <div class="col-md-4 col-md-offset-4">
                   <button type="submit" name="submit" class="btn btn-block btn-primary">Save</button>
                 </div>
                 
               </div>

               </form>

            </section>

          </div>
      </div>

      <!-- END wrapper -->
      <!-- START Footerscript -->
      <?php require_once('../../include/footerscript.php'); ?>

   </body>

</html>