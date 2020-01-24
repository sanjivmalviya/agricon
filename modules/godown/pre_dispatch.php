<?php

require_once('../../functions.php');

$login_id = $_SESSION['agricon_credentials']['user_id'];

$order_id = $_GET['order_id'];

$order_details = "SELECT *,COUNT(godown_id) as item_total FROM tbl_order_detail WHERE order_id = '$order_id' GROUP BY godown_id ";
$order_details = getRaw($order_details);

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
                           <h4 class="page-title">Orders</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">

                           <a href="../../modules/godown/orders.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left" style="font-size: 20px;"></i></a>

                           <div class="row">

                                 <table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                    
                                    <thead>
                                       <th>Sr.</th>
                                       <th>Godown</th>
                                       <th class="text-center">Item Total</th>
                                       <th class="text-center">Dispatch Status</th>
                                       <th class="text-center">Last Dispatched at</th>
                                       <th class="text-right">Action</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($order_details) && count($order_details) > 0){ ?>

                                          <?php $i=1; foreach($order_details as $rs){ ?>

                                          <tr>
                                             <td><?php echo $i++; ?></td>        
                                             <td><?php 
                                                $godown_name = getOne('tbl_godown','godown_id',$rs['godown_id']);
                                                echo $godown_name['godown_name']; 
                                             ?></td>
                                             <td class="text-center"><?php echo $rs['item_total']; ?></td>
                                            
                                             <td class="text-center"> 
                                                <!-- get dispatch status -->
                                                <?php 

                                                   $godown_id = $rs['godown_id'];

                                                   $dispatch_status = "SELECT SUM(order_product_quantity) as required_qty,SUM(order_dispatch_quantity) as dispatch_qty FROM tbl_order_detail WHERE order_id = '$order_id' AND godown_id = '$godown_id' ";
                                                   $dispatch_status = getRaw($dispatch_status);

                                                   if($dispatch_status[0]['dispatch_qty'] == 0 || $dispatch_status[0]['dispatch_qty'] == ''){

                                                      echo "<span class='text-danger'>Pending</span>";

                                                   }else if($dispatch_status[0]['dispatch_qty'] != $dispatch_status[0]['required_qty']){
                                                      
                                                      echo "<span class='text-info'>Partially Dispatched</span>";
                                                      
                                                   }else if($dispatch_status[0]['dispatch_qty'] == $dispatch_status[0]['required_qty']){
                                                      
                                                      echo "<span class='text-primary'>Dispatched</span>";
                                                   
                                                   }
                                                   
                                                ?>

                                             </td>           
                                             <td class="text-center"><?php echo $rs['dispatched_at']; ?></td>
                                             <td class="text-right">
                                                <a href="dispatch.php?order_id=<?php echo $rs['order_id']; ?>&godown_id=<?php echo $rs['godown_id']; ?>" class="text-primary btn btn-xs btn-primary"><i class="fa fa-truck" style="font-size: 15px;"></i> Dispatch</a>
                                                <!-- <a href="detail.php?order_id=<?php echo $rs['order_id']; ?>" class="text-primary btn btn-xs btn-default"><i class="fa fa-print " style="font-size: 15px;"></i>Print Invoice</a> --> 
                                             </td>
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
         
         $(document).on('click','.accept_order', function(){

            var order_id = $(this).attr('id');
            var term = 1;

            $(this).hide();
            $(this).replaceWith('<button class="btn btn-xs btn-primary btn-block deny_order" id="'+order_id+'">Deny</button>');
            
            $.ajax({

               url : "ajax/accept_deny.php",
               type : 'post',
               dataType : 'json',
               data : {order_id : order_id, term : term},
               success : function(data){
                  
                  $('.'+order_id).html("<span class='text-primary'>"+data.msg+"</span>");

               }

            });

         });

         $(document).on('click','.deny_order', function(){

            var order_id = $(this).attr('id');
            var term = 2;

            var this_block = $(this); 
            $(this).hide();
            $(this).replaceWith('<button class="btn btn-xs btn-danger btn-block accept_order" id="'+order_id+'">Accept</button>');

            $.ajax({

               url : "ajax/accept_deny.php",
               type : 'post',
               dataType : 'json',
               data : {order_id : order_id, term : term},
               success : function(data){
                  
                  $('.'+order_id).html("<span class='text-danger'>"+data.msg+"</span>");
               }

            });

         });

      </script>

   </body>
</html>