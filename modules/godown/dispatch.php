<?php



require_once('../../functions.php');



$login_id = $_SESSION['agricon_credentials']['user_id'];



$order_id = $_GET['order_id'];

$godown_id = $_GET['godown_id'];

$order = getOne('tbl_orders','order_id',$order_id);
$order_time = date('h:i:s', strtotime($order['created_at']));
$order_date = date('d-m-Y', strtotime($order['created_at']));
$order_number = $order['order_number'];
$transport_by = $order['transport_by'];
$employee = getOne('tbl_employee','employee_id',$order['employee_id']);
$employee_name = $employee['employee_name'];

$orders = "SELECT * FROM tbl_order_detail WHERE order_id = '$order_id' AND godown_id = '$godown_id' ";

$orders = getRaw($orders);



if(isset($_POST['submit'])){



    $ids = array();

    $batch_data = array();



   foreach($_POST['order_detail_ids'] as $rs){



      $batch_number = "batch_number_".$rs;

      $batch_qty = "qty_".$rs;



      if(isset($_POST[$batch_number]) && !empty($_POST[$batch_number])){



         $batch_number_array = array_filter($_POST[$batch_number]);

         $batch_qty_array = array_filter($_POST[$batch_qty]);



         $k=0;

         foreach($_POST[$batch_number] as $val){

            

            if($_POST[$batch_qty][$k] > 0){

   

               $inner_dataset['order_detail_id'] = $rs;

               $inner_dataset['godown_id'] = $login_id;

               $inner_dataset['batch_number'] = $val;

               $inner_dataset['batch_quantity'] = $_POST[$batch_qty][$k];

               $batch_data[] = $inner_dataset;

            }

            $k++;

         

         } 



         $dataset['order_detail_id'] = $rs;

         $dataset['quantity'] = array_sum($batch_qty_array);

         $ids[] = $dataset; 

      }



   }



  // generate invoice number
     
   $previous_invoice_number = "SELECT invoice_number FROM tbl_invoices ORDER BY invoice_id DESC LIMIT 1";
  

   if($rs = getRaw($previous_invoice_number)){

      $previous_invoice_number = $rs[0]['invoice_number'];

      $invoice_number = substr($previous_invoice_number,3)+1;

      $invoice_number = "INV".$invoice_number;

   }else{

      $invoice_number = "INV1";

   }



   $form_data = array(

      'order_id' => $order_id,

      'godown_id' => $godown_id,

      'invoice_number' => $invoice_number,

      'invoice_date' => $_POST['invoice_date'],

      'invoice_delivery_note' => $_POST['invoice_delivery_note'],

      // 'invoice_terms_of_payment' => $_POST['invoice_terms_of_payment'],

      'invoice_supplier_reference' => $_POST['invoice_supplier_reference'],

      'invoice_other_reference' => $_POST['invoice_other_reference'],

      'invoice_buyer_order_number' => $_POST['invoice_buyer_order_number'],

      'invoice_buyer_order_date' => $_POST['invoice_buyer_order_date'],

      'invoice_dispatch_document_number' => $_POST['invoice_dispatch_document_number'],

      'invoice_delivery_note_date' => $_POST['invoice_delivery_note_date'],

      'invoice_dispatch_through' => $_POST['invoice_dispatch_through'],

      'invoice_dispatch_destination' => $_POST['invoice_dispatch_destination'],

      'transport_by' => $_POST['transport_by']

   );



   if(insert('tbl_invoices',$form_data)){



      $last_id = last_id('tbl_invoices','invoice_id');



      $ids = array();



      foreach($_POST['order_detail_ids'] as $rs){



         $batch_number = "batch_number_".$rs;

         $batch_qty = "qty_".$rs;



         if(isset($_POST[$batch_number]) && !empty($_POST[$batch_number])){



            $batch_number_array = array_filter($_POST[$batch_number]);

            $batch_qty_array = array_filter($_POST[$batch_qty]);



            $dataset['order_detail_id'] = $rs;

            $dataset['quantity'] = array_sum($batch_qty_array);

            $ids[] = $dataset; 

         }



      }



      $i=0; 

      foreach($ids as $rs){



            if($rs['quantity'] > 0){



               $insert = "INSERT INTO tbl_invoice_detail(invoice_id,order_id,order_detail_id,dispatch_quantity) VALUES('$last_id','$order_id','".$rs['order_detail_id']."','".$rs['quantity']."')";



               $update = "UPDATE tbl_order_detail SET order_dispatch_quantity = order_dispatch_quantity + ".$rs['quantity']." WHERE order_detail_id = '".$rs['order_detail_id']."' ";



               if(query($insert)){

                  $success = "Order Dispatched";



                  $updated_qty = getOne('tbl_order_detail','order_detail_id',$rs['order_detail_id']);

                  

                  if($updated_qty['order_product_quantity'] == $updated_qty['order_dispatch_quantity']){

                     $update_qty = "UPDATE tbl_order_detail SET dispatch_status = '2' WHERE order_detail_id = '".$rs['order_detail_id']."' ";

                  }else{

                     $update_qty = "UPDATE tbl_order_detail SET dispatch_status = '1' WHERE order_detail_id = '".$rs['order_detail_id']."' ";

                  }

                  query($update_qty);



               }else{

                  $error = "Something went wrong, try again later";            

               }

               $i++;

               

            }



      }



      if(isset($success) && count($batch_data) > 0){



         foreach($batch_data as $rs){



            $form_data = array(

               'order_detail_id' => $rs['order_detail_id'],

               'batch_number' => $rs['batch_number'],

               'batch_quantity' => $rs['batch_quantity']

            );

            $insert = insert('tbl_order_batch_detail',$form_data); 



         }



      }

      // $required_quantity = "SELECT SUM(order_product_quantity) as required_quantity FROM tbl_order_detail WHERE order_id = '$order_id' AND godown_id = '$godown_id' "; 

      // $required_quantity = getRaw($required_quantity);

      // $required_quantity = $required_quantity[0]['required_quantity'];



      // $dispatched_quantity = "SELECT SUM(dispatch_quantity) as dispatched_quantity FROM tbl_invoice_detail WHERE order_id = '$order_id' AND godown_id = '$godown_id' "; 

      // $dispatched_quantity = getRaw($dispatched_quantity);

      // $dispatched_quantity = $dispatched_quantity[0]['dispatched_quantity'];

      



      // if($required_quantity == $dispatched_quantity){

      //    // fully disaptched

      //    $update_order = "UPDATE tbl_order_detail SET dispatch_status = '1' WHERE order_id = '$order_id' ";

      //    query($update_order);

      //    $status = "Dispatched";



      // }else{

      //    // partially disaptched

      //    $update_order = "UPDATE tbl_order_detail SET dispatch_status = '2' WHERE order_id = '$order_id' ";

      //    query($update_order);

      //    $status = "Partially Dispatched";



      // }



      // Notifications : Start



      // if(isset($success)){



      //    // notify salesperson

      //    $sender_user_type = 3;

      //    $sender_id = $login_id;

         

      //    $receiver_user_type = 4;

      //    $where = array(

      //       'godown_id' => $login_id,

      //       'order_id' => $order_id

      //    );

      //    $receiver_id = selectWhereMultiple('tbl_orders',$where);

      //    $receiver_id = $receiver_id[0]['employee_id'];



      //    $sender_name = getOne('tbl_godown','godown_id',$sender_id);

      //    $godown_person_name = $sender_name['godown_person_name']; 

      //    $godown_name = $sender_name['godown_name']; 



      //    $order_number = getOne('tbl_orders','order_id',$order_id);

      //    $order_number = $order_number['order_number'];



      //    $notification_title = "Order ".$status;

      //    $notification_description = $godown_person_name." has ".$status." order from ".$godown_name." for order number <b>#".$order_number."</b>";



      //    send_notification($sender_user_type,$sender_id,$receiver_user_type,$receiver_id,$notification_title,$notification_description);



      //    // notify admin

      //    $sender_user_type = 3;

      //    $sender_id = $login_id;

         

      //    $receiver_user_type = 2;      

      //    $sender = getOne('tbl_godown','godown_id',$sender_id);

      //    $receiver_id = $sender['added_by'];

      //    $godown_person_name = $sender['godown_person_name']; 

      //    $godown_name = $sender['godown_name']; 



      //    $order_number = getOne('tbl_orders','order_id',$order_id);

      //    $order_number = $order_number['order_number'];



      //    $notification_title = "Order ".$status;

      //    $notification_description = $godown_person_name." has ".$status." order from ".$godown_name." for order number <b>#".$order_number."</b>";



      //    send_notification($sender_user_type,$sender_id,$receiver_user_type,$receiver_id,$notification_title,$notification_description);



      // }



      // Notifications : End



   }else{



      $error = "Failed to Process, try again later";



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

                  <div class ="row">

                     <div class="col-xs-12">

                        <div class="page-title-box">

                           <h4 class="page-title">Order Dispatching</h4>

                           <div class="clearfix"></div>

                        </div>

                     </div>

                  </div>

                  <div class="row">

                     <div class="col-sm-12">



                        <div class="card-box">



                           <a href="../../modules/godown/orders.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left" style="font-size: 20px;"></i></a>





                           <form method="post">

                           

                           <div class="row" style="margin-top: 20px;">

                              

                              <div class="col-md-6 form-group">

                                 <input type="text" class="datepicker form-control" name="invoice_date" placeholder="invoice date" style="padding:10px;" value="<?php echo date('m/d/Y'); ?>">

                              </div>



                              <div class="col-md-6 form-group">

                                 <input type="text" class="form-control" name="invoice_delivery_note" placeholder="delivery note">

                              </div>


   <!-- 
                                 <div class="col-md-6 form-group">

                                    <input type="text" class="form-control" name="invoice_terms_of_payment" placeholder="terms of payment">

                                 </div> -->



                              <div class="col-md-6 form-group">

                                 <input type="text" class="form-control" name="invoice_supplier_reference" placeholder="supplier reference" value="<?php echo $employee_name; ?>">

                              </div>



                              <div class="col-md-6 form-group">

                                 <input type="text" class="form-control" name="invoice_other_reference" placeholder="other reference" value="<?php echo $order_time; ?>">

                              </div>



                              <div class="col-md-6 form-group">

                                 <input type="text" class="form-control" name="invoice_buyer_order_number" placeholder="buyer order number" value="<?php echo $order_number; ?>">

                              </div>



                              <div class="col-md-6 form-group">

                                 <input type="text" class="form-control datepicker" name="invoice_buyer_order_date" placeholder="buyer order date" value="<?php echo date('m/d/Y',strtotime($order_date)); ?>">

                              </div>



                              <div class="col-md-6 form-group">

                                 <input type="text" class="form-control" name="invoice_dispatch_document_number" placeholder="dispatch document number">

                              </div>



                              <div class="col-md-6 form-group">

                                 <input type="text" class="form-control datepicker" name="invoice_delivery_note_date" placeholder="delivery note date">

                              </div>



                              <div class="col-md-6 form-group">

                                 <input type="text" class="form-control" name="invoice_dispatch_through" placeholder="dispatch through">

                              </div>



                              <div class="col-md-6 form-group">

                                 <input type="text" class="form-control" name="invoice_dispatch_destination" placeholder="dispatch destination">

                              </div>

                              <div class="col-md-6 form-group">

                                 <input type="text" class="form-control" name="transport_by" placeholder="transport by" value="<?php echo $transport_by; ?>">

                              </div>



                           </div>

                           

                           <div class="row">





                                 <table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">

                                    

                                    <thead>

                                       <th>Sr.</th>

                                       <th>Product</th>

                                       <th class="text-center">Required Quantity</th>

                                       <th class="text-center">Dispatched Quantity</th>

                                       <th class="text-center">Status</th>

                                    </thead>



                                    <tbody>

                                       

                                       <?php if(isset($orders) && count($orders) > 0){ ?>



                                          <?php $i=1; foreach($orders as $rs){ 



                                                $dispatched_quantity = getOne('tbl_invoice_detail','order_detail_id',$rs['order_detail_id']);

                                                $dispatched_quantity = "SELECT SUM(disp.dispatch_quantity) AS dispatched_quantity FROM tbl_invoice_detail disp WHERE order_id = '".$rs['order_id']."' AND order_detail_id = '".$rs['order_detail_id']."' ";

                                                $dispatched_quantity = getRaw($dispatched_quantity);

                                                $dispatched_quantity = $dispatched_quantity[0]['dispatched_quantity'];



                                          ?>



                                          <tr class="<?php if($rs['order_product_quantity'] == $dispatched_quantity){ echo "text-muted"; } ?>">



                                             <td><?php echo $i++; ?></td>

                                             <td width="50%"><?php 

                                                $product_name = getOne('tbl_product','product_id',$rs['order_product_id']);

                                                echo $product_name['product_name']; 

                                                echo "<p><small><i> Last Dispatched : ". date('d-M-Y h:i',strtotime($rs['dispatched_at']))."</i></small></p>";

                                             ?>

                                             </td>                                    

                                             <td class="text-center"><?php echo $rs['order_product_quantity']; ?></td>

                                             <td class="text-center"><?php if($dispatched_quantity == ""){ echo '0'; }else { echo $dispatched_quantity; } ?></td>



                                             <?php if($rs['order_product_quantity'] != $dispatched_quantity){ ?>

                                                <td width="20%" class="text-center">

                                                <h5 class="text-primary">Pending</h5>

                                                </td>



                                          <?php }else{ ?>

                                             <td width="20%" class="text-center">

                                                <h5 class="text-primary">Dispatched</h5>

                                             </td>



                                          <?php } ?>

                                          </tr>

                                          <input type="hidden" name="order_detail_ids[]" value="<?php echo $rs['order_detail_id']; ?>">

                                          <tr>

                                             <td colspan="3"></td>

                                             <td><input type="text" placeholder="Enter Batch Number" class="form-control_" name="batch_number_<?php echo $rs['order_detail_id']; ?>[]"></td>

                                             <td><input type="number" placeholder="Enter Qty." class="form-control_" name="qty_<?php echo $rs['order_detail_id']; ?>[]"></td>

                                          </tr>

                                          <tr>

                                             <td colspan="3"></td>

                                             <td><input type="text" placeholder="Enter Batch Number" class="form-control_" name="batch_number_<?php echo $rs['order_detail_id']; ?>[]"></td>

                                             <td><input type="number" placeholder="Enter Qty." class="form-control_" name="qty_<?php echo $rs['order_detail_id']; ?>[]"></td>

                                          </tr>

                                          <tr>

                                             <td colspan="3"></td>

                                             <td><input type="text" placeholder="Enter Batch Number" class="form-control_" name="batch_number_<?php echo $rs['order_detail_id']; ?>[]"></td>

                                             <td><input type="number" placeholder="Enter Qty." class="form-control_" name="qty_<?php echo $rs['order_detail_id']; ?>[]"></td>

                                          </tr>

                                          <tr>

                                             <td colspan="3"></td>

                                             <td><input type="text" placeholder="Enter Batch Number" class="form-control_" name="batch_number_<?php echo $rs['order_detail_id']; ?>[]"></td>

                                             <td><input type="number" placeholder="Enter Qty." class="form-control_" name="qty_<?php echo $rs['order_detail_id']; ?>[]"></td>

                                          </tr>

                                          

                                          

                                          <?php } ?>



                                       <?php } ?>



                                    </tbody>



                                 </table>



                                 <div class="col-md-12 p-t-30">

                                    <?php if(isset($success)){ ?>

                                       <div class="alert alert-success"><?php echo $success; ?></div>

                                    <?php }else if(isset($warning)){ ?>

                                       <div class="alert alert-warning"><?php echo $warning; ?></div>

                                    <?php }else if(isset($error)){ ?>

                                       <div class="alert alert-danger"><?php echo $error; ?></div>

                                    <?php } ?>

                                 </div>      



                                 <div class="col-md-12 text-center">

                                    

                                    

                                       <button type="submit" name="submit" class="btn btn-primary btn-sm"><i class="fa fa-truck"></i> Dispatch</button>





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



      <script>

         

         $('.datepicker').datepicker();



      </script>



   </body>

</html>
