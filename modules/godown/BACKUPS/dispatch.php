<?php

require_once('../../functions.php');

$login_id = $_SESSION['agricon_credentials']['user_id'];

$order_id = $_GET['order_id'];
$orders = getWhere('tbl_order_detail','order_id',$order_id);

if(isset($_POST['submit'])){

   $i=0; 
   foreach($_POST['id'] as $rs){

         $last_quantity = getOne('tbl_order_detail','order_detail_id',$rs);
         $last_quantity = $last_quantity['order_dispatch_quantity'];

         $new_quantity = $last_quantity + $_POST['quantity'][$i];

         $update = "UPDATE tbl_order_detail SET order_dispatch_quantity = ".$new_quantity." WHERE order_detail_id = '$rs' ";
         
         if(query($update)){
            $success = "Order Dispatched";
         }else{
            $error = "Something went wrong, try again later";            
         }
         $i++;
   }

   $required_quantity = "SELECT SUM(order_product_quantity) as required_quantity FROM tbl_order_detail WHERE order_id = '$order_id' "; 
   $required_quantity = getRaw($required_quantity);
   $required_quantity = $required_quantity[0]['required_quantity'];

   $dispatched_quantity = "SELECT SUM(order_dispatch_quantity) as dispatched_quantity FROM tbl_order_detail WHERE order_id = '$order_id' "; 
   $dispatched_quantity = getRaw($dispatched_quantity);
   $dispatched_quantity = $dispatched_quantity[0]['dispatched_quantity'];
   

   if($required_quantity == $dispatched_quantity){
      // fully disaptched
      $update_order = "UPDATE tbl_orders SET order_dispatch_status = '1' WHERE order_id = '$order_id' ";
      query($update_order);
      $status = "Dispatched";
   }else{
      // partially disaptched
      $update_order = "UPDATE tbl_orders SET order_dispatch_status = '2' WHERE order_id = '$order_id' ";
      query($update_order);
      $status = "Partially Dispatched";
   }

   if(isset($success)){

      // notify salesperson
      $sender_user_type = 3;
      $sender_id = $login_id;
      
      $receiver_user_type = 4;
      $where = array(
         'godown_id' => $login_id,
         'order_id' => $order_id
      );
      $receiver_id = selectWhereMultiple('tbl_orders',$where);
      $receiver_id = $receiver_id[0]['employee_id'];

      $sender_name = getOne('tbl_godown','godown_id',$sender_id);
      $godown_person_name = $sender_name['godown_person_name']; 
      $godown_name = $sender_name['godown_name']; 

      $order_number = getOne('tbl_orders','order_id',$order_id);
      $order_number = $order_number['order_number'];

      $notification_title = "Order ".$status;
      $notification_description = $godown_person_name." has ".$status." order from ".$godown_name." for order number <b>#".$order_number."</b>";

      send_notification($sender_user_type,$sender_id,$receiver_user_type,$receiver_id,$notification_title,$notification_description);

      // notify admin
      $sender_user_type = 3;
      $sender_id = $login_id;
      
      $receiver_user_type = 2;      
      $sender = getOne('tbl_godown','godown_id',$sender_id);
      $receiver_id = $sender['added_by'];
      $godown_person_name = $sender['godown_person_name']; 
      $godown_name = $sender['godown_name']; 

      $order_number = getOne('tbl_orders','order_id',$order_id);
      $order_number = $order_number['order_number'];

      $notification_title = "Order ".$status;
      $notification_description = $godown_person_name." has ".$status." order from ".$godown_name." for order number <b>#".$order_number."</b>";

      send_notification($sender_user_type,$sender_id,$receiver_user_type,$receiver_id,$notification_title,$notification_description);

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

                           <div class="row">

                              <form method="post">

                                 <table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                    
                                    <thead>
                                       <th>Sr.</th>
                                       <th>Product</th>
                                       <th class="text-right">Required Quantity</th>
                                       <th class="text-right">Dispatched Quantity</th>
                                       <th class="text-center">Add Dispatch Quantity</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($orders) && count($orders) > 0){ ?>

                                          <?php $i=1; foreach($orders as $rs){ ?>



                                          <tr>

                                             <td><?php echo $i++; ?></td>
                                             <td width="50%"><?php 
                                                $product_name = getOne('tbl_product','product_id',$rs['order_product_id']);
                                                echo $product_name['product_name']; 
                                                echo "<p><small><i> Last Dispatched : ". date('d-M-Y h:i',strtotime($rs['dispatched_at']))."</i></small></p>";
                                             ?>
                                             </td>                                    
                                             <td class="text-right"><?php echo $rs['order_product_quantity']; ?></td>
                                             <td class="text-right"><?php echo $rs['order_dispatch_quantity']; ?></td>
                                             <?php $max_limit = $rs['order_product_quantity'] - $rs['order_dispatch_quantity']; 

                                             if($rs['order_product_quantity'] != $dispatched_quantity){

                                             ?>
                                             <td width="20%" class="text-center">


                                                <input style="width: 100%;padding: 5px;" type="number" max="<?php echo $max_limit; ?>" min="0" name="quantity[]" value="0" required></td>
                                                <input type="hidden" value="<?php echo $rs['order_detail_id']; ?>" name="id[]">

                                             </td>
                                                <?php }else{ ?>

                                                   <td>sad</td>
                                                   

                                                <?php } ?>
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

   </body>
</html>