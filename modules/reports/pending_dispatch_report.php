<?php

 require_once('../../functions.php');
 
 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $employees = getWhere('tbl_employee','added_by',$login_id);

$order_numbers = "SELECT * FROM tbl_orders ord INNER JOIN tbl_employee sales ON ord.employee_id = sales.employee_id WHERE sales.added_by = '$login_id' ";
$order_numbers = getRaw($order_numbers);

$customers = "SELECT DISTINCT(cust.customer_id) as customer_id,cust.customer_name as customer_name FROM tbl_orders ord INNER JOIN tbl_customer cust ON ord.customer_id = cust.customer_id WHERE cust.added_by = '$login_id' ";
$customers = getRaw($customers);

if(isset($_POST['submit'])){

      if(isset($_POST['order_number']) && $_POST['order_number'] != ""){

         $orders = "SELECT * FROM `tbl_orders` ord INNER JOIN tbl_customer cust ON ord.customer_id = cust.customer_id WHERE cust.added_by = '$login_id' AND ord.order_dispatch_status = '2' AND ord.order_number = '".$_POST['order_number']."' GROUP BY ord.order_id,ord.customer_id ";
         $orders = getRaw($orders);

      }else if(isset($_POST['customer_id']) && $_POST['customer_id'] != ""){

         $orders = "SELECT * FROM `tbl_orders` ord INNER JOIN tbl_customer cust ON ord.customer_id = cust.customer_id WHERE cust.added_by = '$login_id' AND ord.order_dispatch_status = '2' AND ord.customer_id = '".$_POST['customer_id']."' GROUP BY ord.order_id,ord.customer_id ";
         $orders = getRaw($orders);

      }else{

         $orders = "SELECT * FROM `tbl_orders` ord INNER JOIN tbl_customer cust ON ord.customer_id = cust.customer_id WHERE cust.added_by = '$login_id' AND ord.order_dispatch_status = '2' GROUP BY ord.order_id,ord.customer_id ";
         $orders = getRaw($orders);
      
      }

}else{

    $orders = "SELECT * FROM `tbl_orders` ord INNER JOIN tbl_customer cust ON ord.customer_id = cust.customer_id WHERE cust.added_by = '$login_id' AND ord.order_dispatch_status = '2' GROUP BY ord.order_id,ord.customer_id ";
    $orders = getRaw($orders);

}

 if(isset($orders)){

      foreach($orders as $rs){

         $dataset['party_name'] = $rs['customer_id'];
         $dataset['order_id'] = $rs['order_id'];
         $dataset['order_date'] = date('d-m-Y', strtotime($rs['created_at']));
         $dataset['order_number'] = $rs['order_number'];

         // get total pending product 
         $ordered_quantity = "SELECT order_product_quantity,order_detail_id,order_product_discount,order_product_igst,order_product_sgst,order_product_cgst,order_product_rate FROM tbl_order_detail WHERE order_id = '".$rs['order_id']."' ";
         $ordered_quantity = getRaw($ordered_quantity);

         $total_products = 0;
         $total_pending_quantity = 0;
         $excluding_amount = 0;
         $including_amount = 0;
         foreach($ordered_quantity as $rs){

               $dispatch_quantity = "SELECT COALESCE(SUM(dispatch_quantity),0) as dispatch_quantity FROM tbl_invoice_detail WHERE order_detail_id = '".$rs['order_detail_id']."' AND order_id = '".$dataset['order_id']."' ";
               $dispatch_quantity = getRaw($dispatch_quantity);   
               $dispatch_quantity = $dispatch_quantity[0]['dispatch_quantity'];
               
               if($dispatch_quantity < $rs['order_product_quantity'] ){
                  $total_products++;
                  $pending_quantity = $rs['order_product_quantity'] - $dispatch_quantity;
                  $total_pending_quantity += $pending_quantity;
                  
                  // total amount excluding gst
                  $excluding_discount = ($rs['order_product_rate'] * $rs['order_product_discount']) / 100;
                  $excluding_rate = $rs['order_product_rate'] - $excluding_discount;
                  $excluding_amount += $pending_quantity * $excluding_rate;   

                  // total amount including gst
                  $including_gst = $rs['order_product_igst'] + $rs['order_product_sgst'] + $rs['order_product_cgst'];
                  $including_gst = ($excluding_rate * $including_gst) / 100;
                  $including_rate = $excluding_rate + $including_gst;
                  $including_amount += $including_rate * $pending_quantity;

               }

         }
         // total pending quantity product count
         $dataset['products'] = $total_products;
         $dataset['pending_quantity'] = $total_pending_quantity;
         $dataset['amount_excluding_gst'] = $excluding_amount;
         $dataset['amount_including_gst'] = $including_amount;
         $data[] = $dataset;
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
                     <div class="col-xs-12">
                        <div class="page-title-box">
                           <h4 class="page-title">Pending Dispatch Report</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">

                           <div class="row">

                              <form method="post">
                              
                              <div class="col-md-4">
                                 <br>
                                 <select name="order_number" id="order_number" class="form-control select2">
                                       <?php if(isset($order_numbers) && count($order_numbers) > 0){ ?>
                                          <option value="">--Select Order Number--</option>
                                          <?php $i=1; foreach($order_numbers as $rs){ ?>

                                             <option value="<?php echo $rs['order_number']; ?>"><?php echo $rs['order_number']; ?></option>
                                          
                                          <?php } ?>
                                       <?php } ?>
                                 </select>
                              </div>


                              <div class="col-md-4">
                              <br>
                                  <select name="customer_id" id="customer_id" class="form-control select2">
                                       <?php if(isset($customers) && count($customers) > 0){ ?>
                                          <option value="">--Select Customer--</option>
                                          <?php $i=1; foreach($customers as $rs){ ?>

                                             <option value="<?php echo $rs['customer_id']; ?>"><?php echo $rs['customer_name']; ?></option>
                                          
                                          <?php } ?>
                                       <?php } ?>
                                 </select>
                              </div>

                              <div class="col-md-4">
                                    <br>
                                    <button type="submit" class="btn btn-primary btn-md" name="submit"><i class="fa fa-filter"></i>  Filter</button>
                              </div>

                              </form>

                           </div>
                           <div class="row">

                                 <table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                    
                                    <thead>
                                       <th class="text-center">Party Name</th>
                                       <th class="text-center">Order Id</th>
                                       <th class="text-center">Order Date</th>
                                       <th class="text-center">Order Number</th>
                                       <th class="text-center">Products</th>
                                       <th class="text-center">Pending Quantity</th>
                                       <th class="text-center">Order Value Exclusing GST</th>
                                       <th class="text-center">Order Value Including GST</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($data) && count($data) > 0){ ?>

                                          <?php $i=1; foreach($data as $rs){ ?>

                                          <tr>
                                             <td class="text-center">
                                                <?php
                                                   $party_name = getOne('tbl_customer','customer_id',$rs['party_name']) ; 
                                                   echo $party_name = $party_name['customer_name'];
                                                 ?>
                                             </td>
                                             <td class="text-center"><?php echo $rs['order_id']; ?></td>
                                             <td class="text-center"><?php echo $rs['order_date']; ?></td>
                                             <td class="text-center"><?php echo $rs['order_number']; ?></td>
                                             <td class="text-center"><?php echo $rs['products']; ?></td>
                                             <td class="text-center"><?php echo $rs['pending_quantity']; ?></td>
                                             <td class="text-center"><?php echo number_format($rs['amount_excluding_gst'],2); ?></td>
                                             <td class="text-center"><?php echo number_format($rs['amount_including_gst'],2); ?></td>                                 
                                          </tr>
                                          <?php } ?>

                                       <?php } ?>

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
        
         $('#employee_id').on('change', function(){

            var id = $(this).val();

            $.ajax({

               url : 'ajax/getCustomerList.php',
               type : 'post',
               data : { id : id },
               success : function(data){
                     $('#customer_id').html(data);
               }

            });

         });

      </script>

   </body>
</html>