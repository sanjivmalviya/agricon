<?php

require_once('../../functions.php');
$login_id = $_SESSION['agricon_credentials']['user_id'];

$godowns = getWhere('tbl_godown','added_by',$login_id);

if(isset($_POST['submit'])){

   $godown_id = $_POST['godown_id'];
   $order_detail_id = $_GET['order_detail_id'];

   $order_id = getOne('tbl_order_detail','order_detail_id',$order_detail_id);
   $order_id = $order_id['order_id'];

   $update = "UPDATE tbl_order_detail SET godown_id = '$godown_id' WHERE order_detail_id = '$order_detail_id' ";
   
   if(query($update)){

      // send notifications
      $sender_user_type = 2;
      $sender_id = $login_id;

      $receiver_user_type = 3;
      $receiver_id = $godown_id;

      $sender_name = getOne('tbl_admins','admin_id',$sender_id);
      $sender_name = $sender_name['admin_name']; 

      $order_number = getOne('tbl_orders','order_id',$order_id);
      $order_number = $order_number['order_number'];

      $notification_title = "New Order Assigned";
      $notification_description = "You have a new order from ".$sender_name." for order number <b>#".$order_number."</b>";

      // feed notification
      $form_data = array(
         'notification_sender_user_type' => $sender_user_type,
         'notification_sender_user_id' => $sender_id,
         'notification_receiver_user_type' => 3 ,
         'notification_receiver_user_id' => $receiver_id,
         'notification_title' => '',
         'notification_title' => $notification_title, 
         'notification_description' => $notification_description 
      );      
      insert('tbl_notifications',$form_data);

      header('location:view.php');


   }else{
      $error = "Something went wrong, Try again later";
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
                 <!--  <div class ="row">
                     <div class="col-xs-4 col-xs-offset-4 text-center">
                        <div class="page-title-box text-center">
                           <h4 class="page-title"> Assigning to Godown</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div> -->
                  <div class="row">
                     <div class="col-sm-4 col-sm-offset-4 ">
                        <div class="card-box">
                           <div class="row">

                              <div class="col-md-12">

                                 <form method="post">  
                                 
                                    <div class="form-group">
                                       
                                       <select name="godown_id" class="form-control select2">
                                          
                                          <?php if(isset($godowns)){ ?>
                                             <?php foreach($godowns as $rs){ ?>

                                                <option value="<?php echo $rs['godown_id']; ?>"><?php echo $rs['godown_name']; ?></option>

                                             <?php } ?>
                                          <?php } ?>

                                       </select>

                                    </div>

                                    <div class="col-md-12 p-t-30">
                                       <?php if(isset($success)){ ?>
                                          <div class="alert alert-success"><?php echo $success; ?></div>
                                       <?php }else if(isset($warning)){ ?>
                                          <div class="alert alert-warning"><?php echo $warning; ?></div>
                                       <?php }else if(isset($error)){ ?>
                                          <div class="alert alert-danger"><?php echo $error; ?></div>
                                       <?php } ?>
                                    </div> 
                                    

                                    <div class="form-group">
                                       <input type="submit" name="submit" class="btn btn-primary btn-sm btn-block" value="ASSIGN">
                                    </div>

                                 </form>

                              </div>
                      
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