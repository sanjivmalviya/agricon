<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $login_type = $_SESSION['agricon_credentials']['user_type'];
 
 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $customers = getWhere('tbl_customer','added_by',$login_id);

   if(isset($_POST['submit'])){

     $customer_id = $_POST['customer_id'];
      
     $total_sales = "SELECT COALESCE(SUM(det.employee_order_amount),0) as total_sales,ord.customer_id FROM tbl_employee_target_detail det INNER JOIN tbl_orders ord ON ord.order_id = det.employee_order_id AND ord.customer_id = '$customer_id' ";

   }else{ 

       $total_sales = "SELECT COALESCE(SUM(det.employee_order_amount),0) as total_sales,ord.customer_id FROM tbl_employee_target_detail det INNER JOIN tbl_orders ord ON ord.order_id = det.employee_order_id GROUP BY ord.customer_id ";
   }

   $total_sales = getRaw($total_sales);

   if(isset($total_sales)){

      foreach($total_sales as $rs){

        $dataset['customer_id'] = $rs['customer_id'];
        $dataset['total_sales'] = $rs['total_sales'];
        
        $total_received_amount = "SELECT COALESCE(SUM(accounting_amount),0) as total_received_amount FROM tbl_accounting WHERE accounting_party_id = '".$rs['customer_id']."' ";
        $total_received_amount = getRaw($total_received_amount);
        $total_received_amount = $total_received_amount[0]['total_received_amount'];
        $dataset['total_received_amount'] = $total_received_amount;
        $dataset['total_pending_amount'] =$dataset['total_sales'] - $dataset['total_received_amount'];          
        $dataset['total_pending_amount'] = $dataset['total_pending_amount'];          
        $data[] = $dataset;
      }
     
     }
?>

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
                           <h4 class="page-title">Outstanding Report</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">

                           <div class="row">

                              <form method="post">

                                 <div class="col-md-3 ">                              
                                    <div class="form-group">
                                          Choose Customer
                                          <select name="customer_id" class="form-control select2">
                                              <?php if(isset($customers) && count($customers) > 0){ ?>

                                                  <?php foreach($customers as $rs){ ?>

                                                      <option value="<?php echo $rs['customer_id']; ?>"><?php echo $rs['customer_name']; ?></option>

                                                  <?php } ?>
                                                <?php } ?>
                                             </select>
                                    </div>
                                 </div>

                                 <div class="col-md-3">
                                    <br>
                                    <button type="submit" name="submit" class="btn btn-primary btn-md"><i class="fa fa-filter"></i> Filter</button>
                                 </div>


                              </form>

                           </div>

   
                           <div class="row" style="margin-top: 10px;">

                              <?php if(isset($customer_id)){ 

                                  $customer_name = getOne('tbl_customer','customer_id',$customer_id);
                                  $customer_name =  $customer_name['customer_name'];     
                              ?>
                                  <h4 style="padding-right: 20px;"><i> <?php echo "Customer Report of  ".$customer_name; ?></b></i></h4>
                                 <?php } ?>
                                 <br> 

                                 <table class="table table-striped table-bordered table-condensed table-hover">
                                    
                                    <thead>
                                       <th class="text-center">Customer</th>
                                       <th class="text-center">Total Sales</th>
                                       <th class="text-center">Payment Received</th>
                                       <th class="text-center">Pending Payment</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($data) && count($data) > 0){ ?>

                                          <?php $i=1; foreach($data as $rs){ ?>

                                          <tr>
                                             <td class="text-center"><?php 
                                                $customer_name = getOne('tbl_customer','customer_id',$rs['customer_id']);
                                                echo $customer_name =  $customer_name['customer_name']; 
                                             ?></td>
                                                                            
                                             <td class="text-center"><?php echo $rs['total_sales']; ?></td>
                                             <td class="text-center"><?php echo $rs['total_received_amount']; ?></td>
                                             <td class="text-center">
                                              <?php if($rs['total_pending_amount'] < 0){ 

                                                  echo "<span class='text-primary'> + </span>".number_format(substr($rs['total_pending_amount'], 1),2);
                                                }else{

                                                  echo "<span class='text-danger'> - </span>".number_format($rs['total_pending_amount'],2);
                                                  
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

   </body>
</html>