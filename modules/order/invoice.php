<?php

require_once('../../functions.php');

$login_id = $_SESSION['agricon_credentials']['user_id'];

$order_id = $_GET['order_id'];
if(!isset($order_id) || !isExists('tbl_invoice_detail','order_id',$order_id)){
   header('location:orders.php');
}
                                       
$invoices = getWhere('tbl_invoices','order_id',$order_id);

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
      <link rel="stylesheet" href="print.css" media="print">
      <link rel="stylesheet" href="print.css" media="screen">
      <link rel="stylesheet" href="components.css" media="screen">
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
               <section style="padding-top:2%; padding-bottom:2%;">

         <div class="container">

          <a href="../../modules/order/view.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left" style="font-size: 20px;"></i></a>

         <div class="row" style="margin-top: 20px;">

            <table class="table table-striped table-hover table-repsonsive table-bordered table-condensed" style="border-collapse:collapse;">

              <thead>
                <tr>
                  <th>Sr.</th>
                  <th></th>
                  <th>INVOICE NUMBER</th>
                  <th>DATE</th>
                  <!-- <th>Delivery Note</th>
                  <th>Terms of Payment</th>
                  <th>Supplier Reference</th>
                  <th>Other Referencce</th>
                  <th>Buyer Order Number</th>
                  <th>Buyer Order Date</th>
                  <th>Dispatch Document Number</th>
                  <th>Dispatch Delivery Note</th> -->
                  <th>DISPATCH THROUGH</th>
                  <th>DISPATCH DESTINATION</th>
                  <th>DISPATCHED AT</th>
                  <!-- <th>View Detail</th> -->
                  <th>ACTIONS</th>
                </tr>
              </thead>

              <tbody>

                <?php if(isset($invoices)){ ?>

                    <?php $i=1; foreach($invoices as $rs){ ?>

                      <tr>
                        <td><?php echo $i; ?></td>
                        <td data-toggle="collapse" data-target="#<?php echo $i; ?>" class="accordion-toggle text-center text-primary"><i style="cursor: pointer;" class="fa fa-plus-circle" aria-hidden="true"></i></td>
                        <td><?php echo $rs['invoice_number']; ?></td>
                        <td><?php echo $rs['invoice_date']; ?></td>
                   <!--      <td><?php echo $rs['invoice_delivery_note']; ?></td>
                        <td><?php echo $rs['invoice_terms_of_payment']; ?></td>
                        <td><?php echo $rs['invoice_supplier_reference']; ?></td>
                        <td><?php echo $rs['invoice_other_reference']; ?></td>
                        <td><?php echo $rs['invoice_buyer_order_number']; ?></td>
                        <td><?php echo $rs['invoice_buyer_order_date']; ?></td>
                        <td><?php echo $rs['invoice_dispatch_document_number']; ?></td>
                        <td><?php echo $rs['invoice_delivery_note_date']; ?></td> -->
                        <td><?php echo $rs['invoice_dispatch_through']; ?></td>
                        <td><?php echo $rs['invoice_dispatch_destination']; ?></td>
                        <td><?php echo $rs['created_at']; ?></td>
                        <!-- <td><a href="" class="text-primary">View Detail</a></td> -->
                        <td class="text-right"><a href="invoice_detail.php?invoice_id=<?php echo $rs['invoice_id']; ?>" class="btn btn-primary btn-xs"><i style="font-size: 18px;" class="fa fa-eye"></i></a></td>
                      </tr>

                  <tr>
                    <td colspan="12" class="hiddenRow"><div class="accordian-body collapse" id="<?php echo $i; ?>">
                      <table class="table table-bordered">
                        <thead>
                          <th class="text-center">Product</th>
                          <th class="text-center">Dispatched Quantity</th>
                        </thead>
                        <tbody>
                          <?php 
                            $invoice_details = getWhere('tbl_invoice_detail','invoice_id',$rs['invoice_id']);
                            if(isset($invoice_details)){
                              $total_quantity = 0;
                              foreach ($invoice_details as $val) {
                                ?>
                                <tr>
                                  <td class="text-center">
                                    <?php 
                                      $product_id = getOne('tbl_order_detail','order_detail_id',$val['order_detail_id']);
                                      $product_id = $product_id['order_product_id'];
                                      $product_name = getOne('tbl_product','product_id',$product_id);
                                      echo $product_name = $product_name['product_name'];
                                    ?>
                                  </td>
                                  <td class="text-center"><?php 

                                    echo $val['dispatch_quantity']; 

                                    $total_quantity += $val['dispatch_quantity']; 

                                  ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                  <td class="text-right">Total Quantity Dispatched</td>
                                  <td class="text-center"><b><?php echo $total_quantity; ?></b></td>
                                </tr>
                              <?php } ?>
                      </tbody>
                    </table>
                  </td>
                  </tr>

                    <?php $i++; } ?>

                  <?php } ?>
              </tbody>
          </table

         </div>

      </section>

               
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