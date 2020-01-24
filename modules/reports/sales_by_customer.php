<?php

 require_once('../../functions.php');
 
 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $employees = getWhere('tbl_employee','added_by',$login_id);

 if(isset($_POST['submit'])){

      $employee_id = $_POST['employee_id'];
      $customer_id = $_POST['customer_id'];

      $orders = "SELECT COUNT(*) as total_orders,cust.customer_name as customer_name FROM tbl_orders ord INNER JOIN tbl_customer cust ON ord.customer_id = cust.customer_id WHERE ord.employee_id = '$employee_id' AND ord.customer_id = '$customer_id'";
      
      $orders = getRaw($orders);

      if(isset($orders)){
         foreach($orders as $rs){

            $dataset['customer_name'] = $rs['customer_name'];
            $dataset['total_orders'] = $rs['total_orders'];

            $total_payment = "SELECT SUM(accounting_amount) as total_payment FROM tbl_accounting WHERE added_by = '$login_id' AND accounting_party_id = '$customer_id' ";
            $total_payment = getRaw($total_payment);
            $dataset['total_payment'] = $total_payment[0]['total_payment'];

            $total_order_amount = "SELECT SUM(det.employee_order_amount) as total_order_amount FROM tbl_employee_target_detail det INNER JOIN tbl_customer cust ON det.employee_id = cust.party_handled_by INNER JOIN tbl_orders ord ON ord.order_id = det.employee_order_id WHERE det.employee_id = '$employee_id' AND cust.customer_id='$customer_id'";
            
            $total_order_amount = getRaw($total_order_amount);
            $dataset['total_order_amount'] = $total_order_amount[0]['total_order_amount'];
            $data[] = $dataset;
         }

      }

      if(isset($data)){
         $success = "Records Found";
      }else{
         $error = "No Records Found";
      }      
 
 }else{

      $orders = "SELECT COUNT(*) as total_orders,cust.customer_name as customer_name,cust.customer_id,cust.party_handled_by as employee_id FROM tbl_orders ord INNER JOIN tbl_customer cust ON ord.customer_id = cust.customer_id GROUP BY employee_id";      

      $orders = getRaw($orders);

      if(isset($orders)){
         foreach($orders as $rs){

            $customer_id = $rs['customer_id'];
            $employee_id = $rs['employee_id'];

            $dataset['customer_name'] = $rs['customer_name'];
            $dataset['total_orders'] = $rs['total_orders'];

            $total_payment = "SELECT SUM(accounting_amount) as total_payment FROM tbl_accounting WHERE added_by = '$login_id' AND accounting_party_id = '$customer_id' ";
            $total_payment = getRaw($total_payment);
            $dataset['total_payment'] = $total_payment[0]['total_payment'];

            $total_order_amount = "SELECT SUM(det.employee_order_amount) as total_order_amount FROM tbl_employee_target_detail det INNER JOIN tbl_customer cust ON det.employee_id = cust.party_handled_by INNER JOIN tbl_orders ord ON ord.order_id = det.employee_order_id WHERE det.employee_id = '$employee_id' AND cust.customer_id='$customer_id'";
            
            $total_order_amount = getRaw($total_order_amount);
            $dataset['total_order_amount'] = $total_order_amount[0]['total_order_amount'];
            $data[] = $dataset;
         }

      }

      if(isset($data)){
         $success = "Records Found";
      }else{
         $error = "No Records Found";
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
                           <h4 class="page-title">Sales by Customer Report</h4>
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
                                 <select name="employee_id" id="employee_id" class="form-control select2">
                                       <?php if(isset($employees) && count($employees) > 0){ ?>
                                          <option value="">--Select Employee--</option>
                                          <?php $i=1; foreach($employees as $rs){ ?>

                                             <option value="<?php echo $rs['employee_id']; ?>"><?php echo $rs['employee_name']; ?></option>
                                          
                                          <?php } ?>
                                       <?php } ?>
                                 </select>
                              </div>


                              <div class="col-md-4">
                              <br>
                                 <select name="customer_id" id="customer_id" class="form-control select2">
                                       <option value="">--Select Customer--</option>
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
                                       <th class="text-center">Customer</th>
                                       <th class="text-center">Total Orders</th>
                                       <th class="text-right">Total Payment</th>
                                       <th class="text-right">Pending Payment</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($data) && count($data) > 0){ ?>

                                          <?php $i=1; foreach($data as $rs){ ?>

                                          <tr>
                                             <td class="text-center"><?php echo $rs['customer_name']; ?></td>                                    
                                             <td class="text-center"><?php echo $rs['total_orders']; ?></td>
                                             <td class="text-right"><?php echo $rs['total_order_amount']; ?></td>                                    
                                             <td class="text-right">
                                                <?php 
                                                   $pending = $rs['total_order_amount'] - $rs['total_payment'];

                                                   if($pending <= 0){
   
                                                      echo "<span class='text-danger'>- ".abs($pending)."</span>"; 

                                                   }else{

                                                      echo "<span class='text-primary'>+ ".$pending."</span>"; 
                                                     
                                                   }
                                                ?>
                                                   
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
