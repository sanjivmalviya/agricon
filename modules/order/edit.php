<?php

require_once('../../functions.php');

$login_id = $_SESSION['agricon_credentials']['user_id'];
$order_id = $_GET['order_id'];

if(isset($_GET['delete_id'])){
  
  if(delete('tbl_order_detail','order_detail_id',$_GET['delete_id'])){
 
    header('location:edit.php?order_id='.$order_id);
 
  }else{
 
    $danger = "Failed to delete Item";
 
  }

}else if(!isset($order_id) || !isExists('tbl_order_detail','order_id',$order_id)){
   header('location:view.php');
}
                                       
$order = getWhere('tbl_orders','order_id',$order_id);
$order_detail = getWhere('tbl_order_detail','order_id',$order_id);

?>
<!DOCTYPE html>
<html>
   
   <head>

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

            <a href="../../modules/order/view.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left" style="font-size: 20px;"></i></a>

            <a href="../../modules/order/add.php?order_id=<?php echo $order_id; ?>" class="btn btn-primary pull-right">+ Add Product</a>         

            <section style="padding-top:2%; padding-bottom:2%;">

               <table class="table table-condensed table-striped table-bordered">
                
                <thead>
                  <th class="text-center" width="5%">Sr No.</th>
                  <th class="text-center" width="30%">Description of Goods</th>
                  <th class="text-center" width="5%">HSN/SAC</th>
                  <th class="text-center" width="10%">GST Rate</th>
                  <th class="text-center" width="10%">Quantity</th>
                  <th class="text-center" width="10%">Rate</th>
                  <th class="text-center" width="10%">per</th>
                  <th class="text-center" width="10%">Disc %</th>
                  <th class="text-center" width="10%">Amount</th>
                  <th class="text-center" width="10%">Actions</th>
                </thead>
                
                <tbody>
                  <?php if(isset($order_detail)){ ?>
                    <?php

                        $tax_data = array();                                
                        $total = 0; $i=1; 
                        foreach($order_detail as $rs){

                        // product detail
                        $product = getOne('tbl_product','product_id',$rs['order_product_id']);

                    ?>
                    <tr>
                      <td><?php echo $i++; ?></td>
                      <td>
                        <?php 
                          echo $product['product_name']; 
                          echo "<br><small><i> Batch </i>: ".$product['product_batch_number']."</small>";
                        ?>
                      </td>
                      <td class="text-center"><?php echo $product['product_hsn_code']; ?></td>
                      <td class="text-center"><?php echo substr($product['product_gst'],0,-3); ?> %</td>
                      <td class="text-right"><?php echo $rs['order_product_quantity']." ".$product['product_packaging']; ?></td>
                      <td class="text-center"><?php echo $rs['order_product_rate']; ?></td>
                      <td class="text-center"><?php echo $product['product_packaging']; ?></td>
                      <td class="text-center"><?php echo substr($rs['order_product_discount'],0,-3); ?> %</td>
                      <td class="text-center"><?php 
                        $product_rate = $rs['order_product_quantity'] * $rs['order_product_rate'] - ($rs['order_product_discount'] * $rs['order_product_rate'] * $rs['order_product_quantity'] / 100);
                        echo number_format($product_rate,2);
                        $total += $product_rate; 

                        // calculate taxation
                        if($order[0]['invoice_gst_type'] == 1){
                          // cgst/sgst
                          $cgst_sgst = $rs['order_product_sgst'];
                          $cgst_sgst_amount = ($product_rate * $cgst_sgst / 100) ;

                          $data = array('cgst'=> $cgst_sgst, 'sgst' => $cgst_sgst , 'cgst_amount' => number_format($cgst_sgst_amount,2), 'sgst_amount' => number_format($cgst_sgst_amount,2));
                          $tax_array['cgst_sgst'][] = $data;
                          
                          // hsn tax rates
                          $central_tax_rate = $cgst_sgst;
                          $central_tax_amount = $cgst_sgst_amount;

                          $state_tax_rate = $cgst_sgst;
                          $state_tax_amount = $cgst_sgst_amount;
                          $total_tax_amount = $central_tax_amount + $state_tax_amount;
                        } else{
                          
                          $igst = $rs['order_product_igst'];
                          $igst_amount = ($product_rate * $igst / 100) ;

                          $tax_array['igst'][] = array('igst' => $igst, 'igst_amount' => number_format($igst_amount,2));

                          // hsn tax rates
                          $central_tax_rate = $igst;
                          $central_tax_amount = $igst_amount;

                          $state_tax_rate = 0;
                          $state_tax_amount = 0;

                          $total_tax_amount = $central_tax_amount;

                        }

                        // calculate HSN/SAC Taxation
                        $hsn_data[] = array(
                          'hsn_code'=>$product['product_hsn_code'],
                          'taxable_value'=>$product_rate,
                          'central_tax_rate'=>$central_tax_rate,
                          'central_tax_amount'=>$central_tax_amount,
                          'state_tax_rate'=>$state_tax_rate,
                          'state_tax_amount'=>$state_tax_amount,
                          'total_tax_amount'=>$total_tax_amount
                        );  

                      ?></td>
                      <td>
                        <a href="edit_detail.php?order_detail_id=<?php echo $rs['order_detail_id']; ?>"><i class="fa fa-pencil"></i></a>
                        <a onclick="return confirm('Are you sure ?');" href="edit.php?order_id=<?php echo $rs['order_id']; ?>&delete_id=<?php echo $rs['order_detail_id']; ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <?php } } ?>

                    
                </tbody>

               </table>

            </section>

          </div>
      </div>

      <!-- END wrapper -->
      <!-- START Footerscript -->
      <?php require_once('../../include/footerscript.php'); ?>

   </body>

</html>