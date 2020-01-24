<?php

   require_once('../../functions.php');

 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $login_type = $_SESSION['agricon_credentials']['user_type'];


 if(isset($_POST['submit'])){

   $start_date = $_POST['start_date'];
   $end_date = $_POST['end_date'];
   $title = "Rankings Between ";
   $status = 1;
   
}else{
   
   $start_date = date('Y-m-01'); // hard-coded '01' for first day
   $end_date  = date('Y-m-t');
   $title = "Ranking of This Month";
   $status = 2;

}

$targets = "SELECT target.employee_id,SUM(target.employee_order_amount) as total_sales,COUNT(*) as total_orders FROM tbl_employee_target_detail target INNER JOIN tbl_employee sales ON target.employee_id = sales.employee_id WHERE sales.added_by = '$login_id' AND DATE(target.created_at) BETWEEN '$start_date' AND '$end_date' GROUP BY target.employee_id ORDER BY total_sales DESC ";
$targets = getRaw($targets); 

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
                           <h4 class="page-title">Ranking Board</h4>
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
                                    <div class="form-group">
                                          Start Date
                                          <input type="date" id="start_date" name="start_date" class="form-control" style="width: 100%;">
                                       
                                    </div>
                                 </div>

                                 <div class="col-md-3 ">                              
                                    <div class="form-group">
                                          End Date
                                          <input type="date" name="end_date" class="form-control">
                                    </div>
                                 </div>

                                 <div class="col-md-3">
                                    <br>
                                    <button type="submit" name="submit" class="btn btn-primary btn-md"><i class="fa fa-filter"></i> Filter</button>
                                 </div>

                              </form>

                           </div>
   
                           <div class="row" style="margin-top: 10px;">

                                 <?php if($status == 1){ ?>

                                 <h4 style="padding-right: 20px;"><i> <?php echo $title; ?> <b style="font-size:20px;" class="text-primary"><?php echo date('d-M-Y',strtotime($start_date)); ?></b> To <b style="font-size:20px;" class="text-primary"><?php echo date('d-M-Y',strtotime($end_date)); ?></b></i></h4>

                                 <?php }else{ ?>
                                    <h4 style="padding-right: 20px;"><i> <?php echo $title; ?></b></i></h4>
                                 <?php } ?>
                                 <br> 

                                 <table class="table table-striped table-bordered table-condensed table-hover">
                                    
                                    <thead>
                                       <th class="text-center">Rank</th>
                                       <th>Employee</th>
                                       <th class="text-center">Number of Orders</th>
                                       <th class="text-right">Total Sales</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($targets) && count($targets) > 0){ ?>

                                          <?php $grand_orders = 0; $grand_total = 0; $i=1; foreach($targets as $rs){ ?>

                                             <?php 

                                                if($i==1){
                                                   $img = "gold.png";
                                                }else if($i==2){
                                                   $img = "silver.png";
                                                }else if($i==3){
                                                   $img = "bronze.png";
                                                }

                                             ?>

                                          <tr>
                                             <td width="10%" class="text-center"><?php  
                                                 if($i==1){ 
                                                   echo "<img width='35' src='images/".$img."'>";
                                                 }else if($i==2){ 
                                                   echo "<img width='33' src='images/".$img."'>";
                                                 }else if($i==3){ 
                                                   echo "<img width='25' src='images/".$img."'>";
                                                 }else{ 
                                                   echo $i; 
                                                 } 
                                                 $i++;
                                                 ?> 
                                             </td>
                                             <td width="60%"><?php 
                                                $employee_name = getOne('tbl_employee','employee_id',$rs['employee_id']);
                                                echo $employee_name =  $employee_name['employee_name']; 
                                             ?></td>
                                             <td width="15%" class="text-center"><?php echo $rs['total_orders']; ?></td>                                             
                                             <td width="15%" class="text-right"><?php echo $rs['total_sales']; ?></td>



                                             <?php $grand_orders += $rs['total_orders'];  ?>
                                             <?php $grand_total += $rs['total_sales'];  ?>                                             
                                          </tr>
                                          <?php } ?>

                                       <?php } ?>

                                       <tr>
                                          <td colspan="2" class="text-center"><h4>Grand Total</h4> </td>
                                          <td class="text-center"><b><h4><?php echo $grand_orders; ?></b></h4></td>
                                          <td class="text-right"><b><h4><?php echo number_format($grand_total,2); ?></b></h4></td>
                                       </tr>

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