<?php

require_once('../../functions.php');

$login_id = $_SESSION['agricon_credentials']['user_id'];
$customers = getWhere('tbl_customer','added_by',$login_id);

if(isset($_POST['submit'])){

   $start_date = date('Y-m-d', strtotime($_POST['start_date']));
   $end_date = date('Y-m-d', strtotime($_POST['end_date']));
   $customer_id = $_POST['customer_id'];

   if($customer_id == ""){
      
      $invoices = "SELECT ord.order_number as order_number,ord.created_at as order_created_at,inv.invoice_number as invoice_number,inv.created_at as invoice_created_at,ord.customer_id as customer_id,ord.order_dispatch_status as dispatch_status,inv.invoice_id as invoice_id FROM tbl_invoices inv INNER JOIN tbl_orders ord ON inv.order_id = ord.order_id INNER JOIN tbl_employee sales ON ord.employee_id = sales.employee_id WHERE sales.added_by = '$login_id' AND inv.created_at BETWEEN '$start_date' AND '$end_date' ";
   
   }else{

      $invoices = "SELECT ord.order_number as order_number,ord.created_at as order_created_at,inv.invoice_number as invoice_number,inv.created_at as invoice_created_at,ord.customer_id as customer_id,ord.order_dispatch_status as dispatch_status,inv.invoice_id as invoice_id FROM tbl_invoices inv INNER JOIN tbl_orders ord ON inv.order_id = ord.order_id INNER JOIN tbl_employee sales ON ord.employee_id = sales.employee_id WHERE sales.added_by = '$login_id' AND ord.customer_id ='$customer_id' AND inv.created_at BETWEEN '$start_date' AND '$end_date' ";

   }   

}else{
   
   $invoices = "SELECT ord.order_number as order_number,ord.created_at as order_created_at,inv.invoice_number as invoice_number,inv.created_at as invoice_created_at,ord.customer_id as customer_id,ord.order_dispatch_status as dispatch_status,inv.invoice_id as invoice_id FROM tbl_invoices inv INNER JOIN tbl_orders ord ON inv.order_id = ord.order_id INNER JOIN tbl_employee sales ON ord.employee_id = sales.employee_id WHERE sales.added_by = '$login_id' ";

}

$invoices = getRaw($invoices);

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
                           <h4 class="page-title">Invoices</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">

                   
                     
                     <div class="col-sm-12">
                        <div class="card-box">



                           <div class="row">


                                 <form method="post">            
                                    <div class="col-md-3">
                                                   
                                          <input type="date" class="form-control" name="start_date">

                                    </div>

                                    <div class="col-md-3">
                                                   
                                          <input type="date" class="form-control" name="end_date">

                                    </div>

                                    <div class="col-md-3">
                                                   
                                          <select class="form-control select2" name="customer_id">
                                           <?php if(isset($customers) && count($customers) > 0){ ?>
                                             <option value="">All</option>
                                             <?php foreach($customers as $rs){ ?>
                                                <option value="<?php echo $rs['customer_id']; ?>"><?php echo $rs['customer_name']; ?></option>
                                             <?php } ?>
                                          <?php } ?>
                                          </select>

                                    </div>

                                    <div class="col-md-3">
                                                   
                                       <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>

                                    </div>
                                 </form>

                                 <div class="col-md-12" style="margin-top: 20px;">
                                    <h4><?php 
                                       if(isset($start_date) && isset($end_date)){ 

                                          if($customer_id != ""){
                                                $custName = getOne('tbl_customer','customer_id',$customer_id);
                                                echo $custName['customer_name']."'s ";
                                          }
                                        
                                          echo "Invoice(s) between <i class='text-primary'>".$start_date."</i> AND <i class='text-primary'>".$end_date."</i> ";
                                        
                                        }else{ 

                                          echo "All Invoices"; 
                                       } 
                                    ?></h4>
                                 </div>
                           
                                 <table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                    
                                    <thead>
                                       <th>Sr.</th>
                                       <th class="text-center">Order Number</th>
                                       <th class="text-center">Order Date</th>
                                       <th class="text-center">Inovoice Number</th>
                                       <th class="text-center">Invoice Date</th>
                                       <th class="text-center">Customer</th>
                                       <th class="text-center">Last Dispatch Date</th>
                                       <th class="text-center">View/Print</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($invoices) && count($invoices) > 0){ ?>

                                          <?php $i=1; foreach($invoices as $rs){ ?>

                                          <tr>
                                             <td class="text-center"><?php echo $i++; ?></td>
                                             <td class="text-center"><?php echo $rs['order_number']; ?></td>
                                             <td class="text-center"><?php echo $rs['order_created_at']; ?></td>
                                             <td class="text-center"><?php echo $rs['invoice_number']; ?></td>
                                             <td class="text-center"><?php echo date('d-M-Y', strtotime($rs['invoice_created_at'])); ?></td>
                                             <td class="text-center">
                                             <?php 
                                               $customer_name = getOne('tbl_customer','customer_id',$rs['customer_id']);
                                               echo $customer_name = $customer_name['customer_name'];
                                             ?>                                                
                                             </td>
                                             <td class="text-center">
                                                <?php 
                                                
                                                   // last dispatch date            
                                                    $last_dispatch_date = "SELECT dispatched_at FROM tbl_invoice_detail WHERE invoice_id = '".$rs['invoice_id']."' ORDER BY dispatched_at DESC LIMIT 1 ";
                                                    $last_dispatch_date = getRaw($last_dispatch_date);
                                                    if(isset($last_dispatch_date)){
                                                      echo date('d-M-Y', strtotime($last_dispatch_date[0]['dispatched_at']));        
                                                    }else{
                                                      echo "<span class='text-danger'> No Dispatching </span>";
                                                    }

                                                ?>
                                                
                                             </td>
                                             <td class="text-center"><a href="invoice_detail.php?invoice_id=<?php echo $rs['invoice_id']; ?>" class="btn btn-default btn-xs"><i style="font-size: 18px;" class="fa fa-print"></i></a></td>
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