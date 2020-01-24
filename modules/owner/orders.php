<?php

require_once('../../functions.php');

$login_id = $_SESSION['agricon_credentials']['user_id'];


if(isset($_POST['submit'])){

   $start_date = date('Y-m-d', strtotime($_POST['start_date']));
   $end_date = date('Y-m-d', strtotime($_POST['end_date']));

   $orders = "SELECT * FROM tbl_orders ord INNER JOIN tbl_employee sales ON ord.employee_id = sales.employee_id WHERE ord.created_at BETWEEN '$start_date' AND '$end_date' ";
   
}else{
   
   $orders = "SELECT * FROM tbl_orders ord INNER JOIN tbl_employee sales ON ord.employee_id = sales.employee_id ";

}

$orders = getRaw($orders);

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



                           <div class="row">


                                 <form method="post">            
                                    <div class="col-md-4">
                                                   
                                          <input type="date" class="form-control" name="start_date">

                                    </div>

                                    <div class="col-md-4">
                                                   
                                          <input type="date" class="form-control" name="end_date">

                                    </div>

                                    <div class="col-md-4">
                                                   
                                       <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>

                                    </div>
                                 </form>

                                 <div class="col-md-12" style="margin-top: 20px;">
                                    <?php if(isset($start_date) && isset($end_date)){ echo "Order(s) between <i class='text-primary'>".$start_date."</i> AND <i class='text-primary'>".$end_date."</i>"; }else{ echo "All Orders"; } ?><h4></h4>
                                 </div>
                           
                                 <table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                    
                                    <thead>
                                       <th>Sr.</th>
                                       <th>Admin</th>
                                       <th>Placed by</th>
                                       <th>Godown</th>
                                       <th>Order Number</th>
                                       <th>Customer</th>
                                       <th>Consignee</th>
                                       <th>Approval Status</th>
                                       <th>Dispatch Status</th>
                                       <th>Invoices</th>                                       
                                       <th>Accept/Deny</th>
                                       <th class="text-right">Actions</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($orders) && count($orders) > 0){ ?>

                                          <?php $i=1; foreach($orders as $rs){ ?>

                                          <tr>
                                             <td><?php echo $i++; ?></td>
                                             <td><?php  
                                                $added_by = getOne('tbl_admins','admin_id',$rs['added_by']);
                                                echo $added_by['admin_name'];
                                             ?></td>                                    
                                             <td><?php  
                                                $employee_name = getOne('tbl_employee','employee_id',$rs['employee_id']);
                                                echo $employee_name['employee_name'];
                                             ?></td>                                    
                                             <td class="text-center"><?php if($rs['godown_id'] == ""){ echo "<a href='assign.php?order_id=".$rs['order_id']."'>assign</a>"; }else{

                                                   $godown_name = getOne('tbl_godown','godown_id',$rs['godown_id']);
                                                   echo $godown_name['godown_name'];

                                                } ?></td>                                    
                                             <td><?php echo $rs['order_number']; ?></td>                                    
                                             <td><?php 
                                                $customer_name = getOne('tbl_customer','customer_id',$rs['customer_id']);
                                                echo $customer_name['customer_name']; 
                                             ?></td>                                    
                                             <td><?php if($rs['consignee_same_as_customer'] == '1'){ echo $customer_name['customer_name']; }else{ echo $rs['consignee']; } ?></td>
                                             <td class="text-center"><span class="status <?php echo $rs['order_id']; ?>"><?php if($rs['order_approve_status'] == 0){ echo "<span class='text-danger'>Not Approved</span>"; }else{ echo "<span class='text-primary'>Approved</span>"; } ?></span></td>
                                             <td class="text-center"> 
                                                <strong>
                                                <?php if($rs['order_dispatch_status'] == 0){ ?>       
                                                <span class="text-danger">Not Dispatched</span>
                                                <?php }else if($rs['order_dispatch_status'] == 1){ ?>
                                                <span class="text-primary">Dispatched</span>
                                                <?php }else if($rs['order_dispatch_status'] == 2){ ?>
                                                <span class="text-info">Dispatched Partially</span>
                                                <?php } ?>
                                                </strong>
                                             </td> 
                                             <td class="text-center">
                                                <?php 

                                                   $condition = "order_id = '".$rs['order_id']."' ";
                                                   $total_invoices = getCountWhere('tbl_invoices',$condition);
                                                   if($total_invoices >0){
                                                ?>
   
                                                <a href="invoice.php?order_id=<?php echo $rs['order_id']; ?>"><?php echo $total_invoices; ?></a>
   
                                                <?php }else{ echo $total_invoices; } ?>
   
                                             </td> 
                                             <td class="text-center status_button">
                                                <?php if($rs['order_approve_status'] == 0){ ?>
                                              <button class="btn btn-xs btn-danger btn-block accept_order" id="<?php echo $rs['order_id']; ?>">Accept</button> <?php }else{ ?> <button class="btn btn-xs btn-primary btn-block deny_order" id="<?php echo $rs['order_id']; ?>">Deny</button> </td> <?php } ?>
                                             <td class="text-center">
                                                <a href="detail.php?order_id=<?php echo $rs['order_id']; ?>" class="text-primary"><i class="fa fa-eye" style="font-size: 20px;"></i></a> <a href="edit.php?order_id=<?php echo $rs['order_id']; ?>" class="text-success"><i class="fa fa-pencil" style="font-size: 20px;"></i></a> 
                                                <!-- <a href="" class="text-danger"><i class="fa fa-trash" style="font-size: 20px;"></i></a> -->
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