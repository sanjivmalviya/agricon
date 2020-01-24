<?php

require_once('../../functions.php');

$login_id = $_SESSION['agricon_credentials']['user_id'];
$order_detail_id = $_GET['order_detail_id'];

if(!isset($order_detail_id) || !isExists('tbl_order_detail','order_detail_id',$order_detail_id)){
   header('location:view.php');
}
                                       
$order_detail = getOne('tbl_order_detail','order_detail_id',$order_detail_id);
$order_id = $order_detail['order_id'];

if(isset($_POST['submit'])){
    
    $order_product_quantity = $_POST['order_product_quantity'];
    $order_product_discount = $_POST['order_product_discount'];
    $order_product_rate = $_POST['order_product_rate'];

    $update = "UPDATE tbl_order_detail SET order_product_quantity = '$order_product_quantity',order_product_discount = '$order_product_discount', order_product_rate = '$order_product_rate' WHERE order_detail_id = '$order_detail_id' ";
    if(query($update)){
      $success = "Product Updated";
    }else{
      $error = "Failed to update product, try again later";
    }
    
}


?>
<!DOCTYPE html>
<html>
   
   <head>
      <style type="text/css">

      /* Both z-index are resolving recursive element containment */

      .no-border{
        border: none !important;
        margin: 0 !important;
        padding: 0 !important;
      }

      [background-color] {

        z-index: 0;

        position: relative;

        -webkit-print-color-adjust: exact !important;

      }

      [background-color] canvas {

      display: block;

      position:absolute;

      z-index: -1;

      top: 0;

      left: 0;

      width: 100%;

      height: 100%;

      }

      .btn-inverse {

      background-color: #3b3e47 !important;

      border: 1px solid #3b3e47 !important;

      }

      .btn {

      border-radius: 2px;

      padding: 6px 14px;

      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.16), 0 2px 10px rgba(0, 0, 0, 0.12);

      }

      .waves-effect {

      position: relative;

      cursor: pointer;

      display: inline-block;

      overflow: hidden;

      -webkit-user-select: none;

      -moz-user-select: none;

      -ms-user-select: none;

      user-select: none;

      -webkit-tap-highlight-color: transparent;

      vertical-align: middle;

      z-index: 1;

      will-change: opacity, transform;

      -webkit-transition: all 0.3s ease-out;

      -moz-transition: all 0.3s ease-out;

      -o-transition: all 0.3s ease-out;

      -ms-transition: all 0.3s ease-out;

      transition: all 0.3s ease-out;

      }
      </style>
   
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

            <section style="padding-top:2%; padding-bottom:2%;">


              <form method="post">

                 <table class="table table-condensed table-striped table-bordered">
                  
                  <thead>
                    <th class="text-center" width="60%">Product</th>
                    <th class="text-center" width="10%">Quantity</th>
                    <th class="text-center" width="10%">Discount</th>
                    <th class="text-center" width="20%">Rate</th>
                  </thead>
                  
                  <tbody>
                    <?php if(isset($order_detail)){ 
                          
                          // product detail
                          $product = getOne('tbl_product','product_id',$order_detail['order_product_id']);

                      ?>
                      <tr>
                        <td>
                          <?php 
                            echo $product['product_name']; 
                            echo "<br><small><i> Batch </i>: ".$product['product_batch_number']."</small>";
                          ?>
                        </td>
                        <td class="text-right">
                          <input type="text" name="order_product_quantity" value="<?php echo $order_detail['order_product_quantity']; ?>">
                        </td>
                        <td class="text-center">
                          <input type="text" name="order_product_discount" value="<?php echo $order_detail['order_product_discount']; ?>">
                        </td>
                        <td class="text-center">
                          <input type="text" name="order_product_rate" value="<?php echo $order_detail['order_product_rate']; ?>">
                        </td>
                      </tr>
                      <?php } ?>

                  </tbody>

                 </table>

                 <div class="col-md-12 p-t-30">
                    <?php if(isset($success)){ ?>
                       <div style="color:black !important;" class="alert alert-success"><i class="fa fa-check"></i> <?php echo $success; ?></div>
                    <?php }else if(isset($warning)){ ?>
                       <div style="color:black !important;" class="alert alert-warning"><?php echo $warning; ?></div>
                    <?php }else if(isset($error)){ ?>
                       <div style="color:black !important;" class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>
                 </div> 

                 <div class="text-center">
                  <button type="submit" name="submit" id="submit" class="btn btn-md btn-primary"><i class="fa fa-circle-o-notch"></i> Update</button>
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