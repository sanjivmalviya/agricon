<?php

require_once('../../functions.php');

$login_id = $_SESSION['agricon_credentials']['user_id'];

$order_id = $_GET['order_id'];
if(!isset($order_id) || !isExists('tbl_order_detail','order_id',$order_id)){
   header('location:view.php');
}
                                       
$order = getWhere('tbl_orders','order_id',$order_id);

$order_detail = getWhere('tbl_order_detail','order_id',$order_id);

// owner details
$owner = getAll('tbl_owner');
$owner_company_name  = $owner[0]['owner_company_name'];
$owner_name  = $owner[0]['owner_name'];
$owner_address  = $owner[0]['owner_address'];
$owner_city_id  = $owner[0]['owner_city_id'];
$owner_state_id  = $owner[0]['owner_state_id'];
$owner_pincode  = $owner[0]['owner_pincode'];
$owner_email  = $owner[0]['owner_email'];
$owner_mobile  = $owner[0]['owner_mobile'];
$owner_company_vat_tin_number = $owner[0]['owner_company_vat_tin_number'];
$owner_company_cst_number = $owner[0]['owner_company_cst_number'];
$owner_company_pan_number = $owner[0]['owner_company_pan_number'];
$owner_bank_name = $owner[0]['owner_bank_name'];
$owner_bank_account_number = $owner[0]['owner_bank_account_number'];
$owner_bank_ifsc = $owner[0]['owner_bank_ifsc'];

// owner fertilizer lic numbers
$owner_fertilizer_lic_numbers = getAll('tbl_owner_fertilizer_lic');
$owner_pesticide_lic_numbers = getAll('tbl_owner_pesticide_lic');

// customer details
$customer_detail = getWhere('tbl_customer','customer_id',$order[0]['customer_id']);
$customer_name = $customer_detail[0]['customer_name'];
$customer_address = $customer_detail[0]['customer_address'];
$customer_at = $customer_detail[0]['customer_at'];
$customer_taluka = $customer_detail[0]['customer_taluka'];
$customer_district = $customer_detail[0]['customer_district'];
$customer_pincode = $customer_detail[0]['customer_pincode'];
$customer_email = $customer_detail[0]['customer_email'];
$customer_mobile = $customer_detail[0]['customer_mobile'];
$customer_gst = $customer_detail[0]['customer_gst'];

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

           <a href="../../modules/owner/orders.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left" style="font-size: 20px;"></i></a>

         <div class="row">



            <div class="col-md-10 col-xs-12 col-md-offset-1 table-border table-striped">

               <div id="background" style="z-index: -1;">

                  <p id="bg-text" style="font-size: 120px;opacity: 0.2;cursor: default;z-index: 9999999999;user-select: none;transform: rotate(-40deg);position: absolute;top:420px;left: -30px; color: #ffb900"><b>AGRICON</b></p>

               </div>

               <div class="row">

                  <div class="col-md-12 col-xs-12">

                     <p class="font-weight-600 text-center font-24 p-t-10 p-b-10 ">TAX INVOICE <span class="pull-right font-12"><i>(ORIGINAL FOR RECIPIENT)</i></span> </p>

                  </div>

               </div>

               <div class="row b-t-1">

                 <!--  <br>

                  <div class="col-xs-12 col-md-12 p-l-0 p-r-0 b-r-1 p-1 " background-color="#51266dd6">

                     <p class="text-center" ><strong style="color:#fff;">BUYER DETAIL</strong></p>

                  </div> -->

               </div>

               <div class="row">

                  <div class="col-md-6 col-xs-6">

                     <div class="row">

                        <div class="col-md-12 col-xs-12 ">
                           <p><b> <?php echo $owner_company_name; ?> </b></p>
                        </div>

                        <div class="col-md-12 col-xs-12">
                           <p><?php echo $owner_address; ?></p>
                        </div>

                        <div class="col-md-12 col-xs-12">
                           <p><?php echo $owner_city_id." - ".$owner_pincode; ?></p>
                        </div>

                        <?php if(isset($owner_fertilizer_lic_numbers)){ ?>
                            <?php foreach($owner_fertilizer_lic_numbers as $rs){ ?>

                            <div class="col-md-12 col-xs-12">
                               <p>Ferti Lic. No-<?php echo $rs['owner_fertilizer_lic_number']; ?> Dt-<?php echo $rs['owner_fertilizer_lic_date']; ?> </p>
                            </div>

                            <?php } ?>
                        <?php } ?>

                     </div>

                    <div class="row text-left">

                        <div class="col-md-12 col-xs-12 ">
                             <h6>Consignee</h6>
                             <p><b> <?php echo $customer_name; ?> </b></p>
                        </div>

                        <div class="col-md-12 col-xs-12">
                           <p><?php echo $customer_address; ?></p>
                        </div>

                        <div class="col-md-12 col-xs-12">
                           <p>AT. <?php echo $customer_at." - ".$customer_pincode; ?></p>
                        </div>

                        <div class="col-md-12 col-xs-12">
                           <p>DIST. <?php echo $customer_district; ?></p>
                        </div>

                        <div class="col-md-12 col-xs-12">
                           <p>MO NO. <?php echo $customer_mobile; ?></p>
                        </div>

                        <div class="col-md-12 col-xs-12">
                           <p>GSTIN/UIN. <?php echo $customer_gst; ?></p>
                        </div>

                        <?php if($order[0]['consignee_same_as_customer'] == 1){ ?>     

                        <div class="col-md-12 col-xs-12 ">
                           <h6>Buyer (if other than consignee)</h6>
                           <p><b> <?php echo $customer_name; ?> </b></p>
                        </div>

                        <div class="col-md-12 col-xs-12">
                           <p><?php echo $customer_address; ?></p>
                        </div>

                        <div class="col-md-12 col-xs-12">
                           <p>AT. <?php echo $customer_at." - ".$customer_pincode; ?></p>
                        </div>

                        <div class="col-md-12 col-xs-12">
                           <p>DIST. <?php echo $customer_district; ?></p>
                        </div>

                        <div class="col-md-12 col-xs-12">
                           <p>MO NO. <?php echo $customer_mobile; ?></p>
                        </div>

                        <div class="col-md-12 col-xs-12">
                           <p>GSTIN/UIN. <?php echo $customer_gst; ?></p>
                        </div>


                      <?php }else{ ?>
  
                        <div class="col-md-12 col-xs-12">
                          <h6>Buyer</h6>
                          <p> <?php echo $order[0]['consignee']; ?> </p>
                        </div>

                      <?php } ?> 

                    </div>

                   </div>

                  <div class="col-md-6 col-xs-6" align="right">

                    <div class="row pull-right">
                      <table class="table table-condensed">
                        <tbody style="border: none;">
                          <tr>
                            <td width="50%" style="border: none;">Invoice No. <br><b><?php echo $order[0]['invoice_number'] ?></b></td>
                            <td width="50%" style="border: none;">Dated <br><b><?php echo $order[0]['invoice_date'] ?></b></td>
                          </tr>
                          <tr>
                            <td width="50%" style="border: none;">Delivery Note <br><b><?php echo $order[0]['invoice_delivery_note'] ?></b></td>
                            <td width="50%" style="border: none;">Mode/Terms of Payment <br><b><?php echo $order[0]['invoice_terms_of_payment'] ?></b></td>
                          </tr>
                          <tr>
                            <td width="50%" style="border: none;">Supplier's Ref. <br><b><?php echo $order[0]['invoice_supplier_reference'] ?></b></td>
                            <td width="50%" style="border: none;">Other Reference(s) <br><b><?php echo $order[0]['invoice_other_reference'] ?></b></td>
                          </tr>
                          <tr>
                            <td width="50%" style="border: none;">Buyer's Order No<br><b><?php echo $order[0]['invoice_buyer_order_number'] ?></b></td>
                            <td width="50%" style="border: none;">Dated<br><b><?php echo $order[0]['invoice_buyer_order_date'] ?></b></td>
                          </tr>
                          <tr>
                            <td width="50%" style="border: none;">Dispatch Document No. <br><b><?php echo $order[0]['invoice_date'] ?></b></td>
                            <td width="50%" style="border: none;">Delivery Note Date<br><b><?php echo $order[0]['invoice_delivery_note_date'] ?></b></td>
                          </tr>
                          <tr>
                            <td width="50%" style="border: none;">Dispatched Through <br><b><?php echo $order[0]['invoice_dispatch_through'] ?></b></td>
                            <td width="50%" style="border: none;">Destination<br><b><?php echo $order[0]['invoice_dispatch_destination'] ?></b></td>
                          </tr>
                          <tr>
                            <td colspan="2" style="border: none;">Terms of Delivery <br><b><?php echo "-"; ?></b></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                  </div>
                
                </div>

               <div class="row" background-color="#fff" style="margin-top: 10px;">

                  <div class="col-md-12 col-xs-12">

                     <p class="font-weight-600 text-center p-t-5 p-b-5">PRODUCT DETAIL</p>

                  </div>

                  <canvas id="canvas-0" width="1168" height="62"></canvas>

               </div>

               <div class="row "></div>

                    <div class="row b-t-1">


                      <table class="table table-condensed">
                        
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
                        </thead>
                        
                        <tbody>
                          <?php if(isset($order_detail)){ ?>
                            <?php

                                $tax_data = array();                                
                                $total = 0; $i=1; 
                                $total_tax_amount2 = 0;
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
                                if($order[0]['customer_gst_type'] == 1){
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

                                $total_tax_amount2 += $total_tax_amount;

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
                            </tr>
                            <?php } ?>

                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class="text-right"><?php echo number_format($total,2);  ?></td>
                            </tr>

                            <?php if(isset($tax_array['cgst_sgst'])){ $tax_total = 0; foreach($tax_array['cgst_sgst'] as $rs){ ?>

                            <tr>
                              <td class="no-border"></td>
                              <td class="text-right no-border"> 
                                <?php 
                                    echo "CGST @ ". $rs['cgst']." %";
                                    echo "<br> SGST @ ". $rs['sgst']." %"; 
                                ?>
                              </td>
                              <td class="no-border"></td>
                              <td class="no-border"></td>
                              <td class="no-border"></td>
                              <td class="no-border text-right">
                                <?php 
                                    echo $rs['cgst'];
                                    echo "<br>".$rs['sgst']; 
                                ?>
                              </td>
                              <td class="no-border">
                                <?php 
                                    echo " %";
                                    echo "<br> %"; 
                                ?>
                              </td>
                              <td class="no-border"></td>
                              <td class="no-border text-right">
                                 <?php 
                                    echo $rs['cgst_amount'];
                                    echo "<br>".$rs['sgst_amount']; 

                                    $tax_total += $rs['cgst_amount'];
                                    $tax_total += $rs['sgst_amount'];
                                ?>
                              </td>
                            </tr>
                            <?php } }  ?>

                            <?php if(isset($tax_array['igst'])){ foreach($tax_array['igst'] as $rs){ ?>

                            <tr>
                              <td class="no-border"></td>
                              <td class="text-right no-border">                                   
                                <?php 
                                    echo "IGST @ ". $rs['igst']." %";
                                ?>
                              </td>
                              <td class="no-border"></td>
                              <td class="no-border"></td>
                              <td class="no-border"></td>
                              <td class="no-border text-right">
                                <?php 
                                    echo $rs['igst'];
                                ?>
                              </td>
                              <td class="no-border">
                                <?php 
                                    echo "%";
                                ?>
                              </td>
                              <td class="no-border"></td>
                              <td class="no-border text-right">
                                <?php 
                                    echo $rs['igst_amount'];
                                    $tax_total += $rs['igst_amount'];
                                ?>
                              </td>
                            </tr>
                            <?php } } ?>

                            <tr>
                              <td></td>
                              <td class="text-right">Total</td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class="text-right"><?php $grand_total =$total + $total_tax_amount2; echo "<i class='fa fa-rupee'></i> ".number_format($grand_total,2); ?></td>
                            </tr>

                             <tr>
                              <td colspan="3" class="text-left">Amount Chargeable (in words) <br><b>INR <span id="grand_total_in_words"></span></b>
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class="text-right"><small><i>E. & O.E</i></small></td>
                            </tr>

                          <?php } ?>
                        </tbody>

                      </table>

                      <table class="table table-striped table-condensed table-bordered">
                        <thead>
                          <tr>
                            <td width="50%" rowspan="2" class="text-center">HSN/SAC</td>
                            <td rowspan="2" class="text-center">Taxable Value</td>
                            <td colspan="2" class="text-center">Central Tax</td>
                            <td colspan="2" class="text-center">State Tax</td>
                            <td rowspan="2" class="text-center">Total Tax Amount</td>
                          </tr>
                          <tr>
                            <td class="text-center">Rate</td>
                            <td class="text-center">Amount</td>
                            <td class="text-center">Rate</td>
                            <td class="text-center">Amount</td>
                          </tr>

                          <?php if(isset($hsn_data)){ 

                            $hsn_taxes  = array();

                            foreach($hsn_data as $vals){
                                
                                if(array_key_exists($vals['hsn_code'],$hsn_taxes)){
                                    
                                    $hsn_taxes[$vals['hsn_code']]['hsn_code'] = $vals['hsn_code'];
                                    $hsn_taxes[$vals['hsn_code']]['taxable_value'] += $vals['taxable_value'];
                                    $hsn_taxes[$vals['hsn_code']]['central_tax_rate'] = $vals['central_tax_rate'];
                                    $hsn_taxes[$vals['hsn_code']]['central_tax_amount'] += $vals['central_tax_amount'];
                                    $hsn_taxes[$vals['hsn_code']]['state_tax_rate'] = $vals['state_tax_rate'];
                                    $hsn_taxes[$vals['hsn_code']]['state_tax_amount'] += $vals['state_tax_amount'];
                                    $hsn_taxes[$vals['hsn_code']]['total_tax_amount'] += $vals['total_tax_amount'];

                                }else{
                                
                                    $hsn_taxes[$vals['hsn_code']]  = $vals;
                                
                                }
                            }


                            // sortind data from minimum to maximum taxation rates
                            $sort = array();
                            foreach ($hsn_taxes as $key => $row)
                            {
                                $sort[$key] = $row['central_tax_amount'];
                            }
                            array_multisort($sort, SORT_ASC, $hsn_taxes);
                            
                            $tax_grand_total = 0;
                            $tax_total_taxable_amount = 0;
                            $central_grand_total = 0;
                            $state_grand_total = 0;

                            foreach($hsn_taxes as $rs){ ?>
                                
                                <tr>    
                                  <td class="text-left"><?php echo $rs['hsn_code']; ?></td>
                                  <td class="text-right"><?php echo number_format($rs['taxable_value'],2); ?></td>
                                  <td class="text-right"><?php echo $rs['central_tax_rate']; ?></td>
                                  <td class="text-right"><?php echo number_format($rs['central_tax_amount'],2); ?></td>
                                  <td class="text-right"><?php echo number_format($rs['state_tax_rate'],2); ?></td>
                                  <td class="text-right"><?php echo number_format($rs['state_tax_amount'],2); ?></td>
                                  <td class="text-right"><?php echo number_format($rs['total_tax_amount'],2); ?></td>
                                  <?php 
                                    $tax_total_taxable_amount += $rs['taxable_value'];
                                    $tax_grand_total += $rs['total_tax_amount']; 
                                    $central_grand_total += $rs['central_tax_amount']; 
                                    $state_grand_total += $rs['state_tax_amount']; 
                                  ?>
                                </tr>
                            
                            <?php } ?>

                             <tr>    
                                  <td class="text-right">Total</td>
                                  <td class="text-right"><?php echo number_format($tax_total_taxable_amount,2); ?></td>
                                  <td class="text-right"></td>
                                  <td class="text-right"><?php echo number_format($central_grand_total,2); ?></td>
                                  <td class="text-right"></td>
                                  <td class="text-right"><?php echo number_format($state_grand_total,2); ?></td>
                                  <td class="text-right"><?php echo number_format($tax_grand_total,2); ?></td>
                                </tr>

                          <?php } ?>

                        </thead>
                      </table>

                            <div class="col-md-12 col-xs-12" style="margin-bottom: 50px;">Tax Amount (in words) : <b>INR <span id="tax_grand_total_in_words"></span></b></div>
                            <div class="col-md-12 col-xs-12"> Company's VAT TIN : <b><?php echo $owner_company_vat_tin_number; ?></b> </div>
                            <div class="col-md-12 col-xs-12"> Company's CST No. : <b><?php echo $owner_company_cst_number; ?></b> </div>
                            <div class="col-md-6 col-xs-6"> Company's PAN : <b><?php echo $owner_company_pan_number; ?></b> </div>
                            <div class="col-md-2 col-xs-2"> Date & Time </div>
                            <div class="col-md-4 col-xs-4"> <?php echo date('d-M-Y')." at ".date('h:i'); ?> </b> </div>
                            <div class="col-md-6 col-xs-6" style="margin-top: 5px;height: 100px;">
                              <u>Declaration</u>
                              <p><small>We declare that this invoice shows the actual price of the goods and that all particulars are true and correct. Our <?php echo $owner_bank_name; ?> Bank A/C Nos are - <?php echo $owner_bank_account_number; ?> RTGS/NEFT/IFSC NO - <?php echo $owner_bank_ifsc; ?></small> </p>
                            </div>
                            <div class="col-md-6 col-xs-6" style="border: 1px solid rgba(0,0,0,0.2);margin-top: 5px;height: 100px;">
                              <span style="position: absolute;right: 5px;">for AGRICON FERTILIZERS</span>
                              <span style="position: absolute;bottom: 0px;right:5px;">Authorised Signatory</span>
                            </div>
                    </div>


                    <input type="hidden" id="grand_total" value="<?php echo $grand_total; ?>">
                    <input type="hidden" id="tax_grand_total" value="<?php echo $tax_grand_total; ?>">


               <!-- End Of Report Design  -->

            </div>
            <div style="margin-top: 5px;" class="col-md-12 col-xs-12 text-center"><small>This is a Computer Generated Invoice</small></div>

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

     <script type="text/javascript">

         $(function(){

            var grand_total = $('#grand_total').val();
            var grand_total_in_words = convertNumberToWords(grand_total);
            $('#grand_total_in_words').text(grand_total_in_words);
            
            var tax_grand_total = $('#tax_grand_total').val();
            var tax_grand_total_in_words = convertNumberToWords(tax_grand_total);
            $('#tax_grand_total_in_words').text(tax_grand_total_in_words);
          
         }); 

         var containers = document.querySelectorAll("[background-color]");
         for (i = 0; i < containers.length; i++)
         {

             // Element

             var container = containers[i];

             container.insertAdjacentHTML('beforeend', '<canvas id="canvas-' + i + '"></canvas>');

         

             // Color

             var color = container.getAttribute("background-color");

             container.style.backgroundColor = color;

         

             // Inner Canvas

             var canvas = document.getElementById("canvas-" + i);

             canvas.width = container.offsetWidth;

             canvas.height = container.offsetHeight;

             var ctx = canvas.getContext("2d");

             ctx.fillStyle = color;

             ctx.fillRect(0, 0, canvas.width, canvas.height);

         }
     </script>

   </body>

</html>