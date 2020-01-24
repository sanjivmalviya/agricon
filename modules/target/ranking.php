<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $login_type = $_SESSION['agricon_credentials']['user_type'];
 
 $target_months = getAll('tbl_target_months');
 

 if(isset($_POST['submit'])){

      $target_year = $_POST['target_year']; 
      
      if($_POST['target_month']==""){

          $annuall_rankings = "SELECT SUM(target_category_amount) as target_amount,employee_id,target_year FROM tbl_target WHERE added_by = '$login_id' AND target_year = '$target_year' GROUP BY target_year ORDER BY target_id DESC";
          $annuall_rankings = getRaw($annuall_rankings);

         if(isset($annuall_rankings)){
         
            foreach($annuall_rankings as $rs){

               $year = $rs['target_year'];
               $employee_id = $rs['employee_id'];
               $total_orders = "SELECT COALESCE(COUNT(*),0) as total_order FROM tbl_orders WHERE employee_id = '$employee_id' AND YEAR(updated_at) = $target_year";
               $total_orders = getRaw($total_orders);
               $total_orders = $total_orders[0]['total_order'];

               $total_order_amount = "SELECT COALESCE(SUM(employee_order_amount),0) as total_order_amount FROM tbl_employee_target_detail WHERE employee_id = '$employee_id' AND YEAR(created_at) = $target_year ";
               $total_order_amount = getRaw($total_order_amount);
               $total_order_amount = $total_order_amount[0]['total_order_amount'];

               $rs['total_orders'] = $total_orders ;
               $rs['total_order_amount'] = number_format($total_order_amount,2);
               $rs['total_outstanding'] = $rs['target_amount'] - $total_order_amount;
               $rs['total_outstanding'] = number_format($rs['total_outstanding'],2);
               if($total_order_amount >= $rs['target_amount']){
                  $rs['target_status'] = 1;
                  $rs['total_outstanding'] = substr($rs['total_outstanding'],1);
               }else{
                  $rs['target_status'] = 0;
               }

               if($total_order_amount == 0){
                  $rs['percentage'] = 0;
               }else{
                  // $percentage = number_format((1 - $total_order_amount / $rs['target_amount'] ) * 100,0);
                  // $rs['percentage'] = substr($percentage,1);
                  $percentage = ($total_order_amount / $rs['target_amount']) * 100;
                  $rs['percentage'] = number_format($percentage,2);                        
               }
               $data[] = $rs;

            }
         }

      }else{

          $target_month =  $_POST['target_month'];
          $target_year =  $_POST['target_year'];
          
          $annuall_rankings = "SELECT SUM(target_category_amount) as target_amount,employee_id,target_year FROM tbl_target WHERE added_by = '$login_id' AND target_year = '$target_year' AND  target_month = '$target_month' GROUP BY target_year ORDER BY target_id DESC";
          $annuall_rankings = getRaw($annuall_rankings);
          
          if(isset($annuall_rankings)){
         
            foreach($annuall_rankings as $rs){

               $year = $rs['target_year'];

               $employee_id = $rs['employee_id'];
               $total_orders = "SELECT COALESCE(COUNT(*),0) as total_order FROM tbl_orders WHERE employee_id = '$employee_id' AND YEAR(updated_at) = $target_year AND MONTH(updated_at) = $target_month";
               $total_orders = getRaw($total_orders);
               $total_orders = $total_orders[0]['total_order'];

               $total_order_amount = "SELECT COALESCE(SUM(employee_order_amount),0) as total_order_amount FROM tbl_employee_target_detail WHERE employee_id = '$employee_id' AND YEAR(created_at) = $target_year AND MONTH(created_at) = $target_month ";
               $total_order_amount = getRaw($total_order_amount);
               $total_order_amount = $total_order_amount[0]['total_order_amount'];

               $rs['total_orders'] = $total_orders ;
               $rs['total_order_amount'] = number_format($total_order_amount,2);
               $rs['total_outstanding'] = $rs['target_amount'] - $total_order_amount;
               $rs['total_outstanding'] = number_format($rs['total_outstanding'],2);
               if($total_order_amount >= $rs['target_amount']){
                  $rs['target_status'] = 1;
                  $rs['total_outstanding'] = substr($rs['total_outstanding'],1);
               }else{
                  $rs['target_status'] = 0;
               }

               if($total_order_amount == 0){
                  $rs['percentage'] = 0;
               }else{
                  // $percentage = number_format((1 - $total_order_amount / $rs['target_amount'] ) * 100,0);
                  // $rs['percentage'] = substr($percentage,1);
                  $percentage = ($total_order_amount / $rs['target_amount']) * 100;
                  $rs['percentage'] = number_format($percentage,2);                    
               }
               $data[] = $rs;

            }
         }
      }

 }else{
   
   $annuall_rankings = "SELECT SUM(target_category_amount) as target_amount,employee_id,target_year FROM tbl_target WHERE added_by = '$login_id' GROUP BY target_year ORDER BY target_id DESC";
   $annuall_rankings = getRaw($annuall_rankings);

    if(isset($annuall_rankings)){

      foreach($annuall_rankings as $rs){

            $year = $rs['target_year'];
            $employee_id = $rs['employee_id'];
            $total_orders = "SELECT COALESCE(COUNT(*),0) as total_order FROM tbl_orders WHERE employee_id = '$employee_id' AND YEAR(updated_at) = $year ";
            $total_orders = getRaw($total_orders);
            $total_orders = $total_orders[0]['total_order'];

            $total_order_amount = "SELECT COALESCE(SUM(employee_order_amount),0) as total_order_amount FROM tbl_employee_target_detail WHERE employee_id = '$employee_id' AND YEAR(created_at) = $year ";
            $total_order_amount = getRaw($total_order_amount);
            $total_order_amount = $total_order_amount[0]['total_order_amount'];

            $rs['total_orders'] = $total_orders ;
            $rs['total_order_amount'] = number_format($total_order_amount,2);
            $rs['total_outstanding'] = $rs['target_amount'] - $total_order_amount;
            $rs['total_outstanding'] = number_format($rs['total_outstanding'],2);
            if($total_order_amount >= $rs['target_amount']){
               $rs['target_status'] = 1;
               $rs['total_outstanding'] = substr($rs['total_outstanding'],1);
            }else{
               $rs['target_status'] = 0;
            }

            if($total_order_amount == 0){
               $rs['percentage'] = 0;
            }else{

               // $percentage = number_format((1 - $total_order_amount / $rs['target_amount'] ) * 100,0);
               // $rs['percentage'] = substr($percentage,1);
               $percentage = ($total_order_amount / $rs['target_amount']) * 100;
               $rs['percentage'] = number_format($percentage,2);                    
            }
            $data[] = $rs;

      }
    }
   
 }

if(isset($data)){
   
   function compare($a, $b)
   {
      return ($data['percentage']< $data['percentage']);
   }
   usort($data, "compare");
   
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
                                          Choose Year
                                          <select name="target_year" class="form-control select2">
                                             <option value="2019">2019</option>
                                             <option value="2020">2020</option>
                                             <option value="2021">2021</option>
                                          </select>                                       
                                    </div>
                                 </div>

                                 <div class="col-md-3 ">                              
                                    <div class="form-group">
                                          Choose Month
                                          <select name="target_month" class="form-control select2">
                                             <option value="">--Month--</option>
                                              <?php if(isset($target_months) && count($target_months) > 0){ ?>

                                                  <?php foreach($target_months as $rs){ ?>

                                                      <option value="<?php echo $rs['month_id']; ?>"><?php echo $rs['month_name']; ?></option>

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
                                       <th class="text-center">Target Year</th>
                                       <th class="text-center">Orders</th>
                                       <th class="text-center">Assigned</th>
                                       <th class="text-center">Achieved</th>
                                       <th class="text-center">Outstanding</th>
                                       <th class="text-center">Status</th>
                                       <th class="text-center">Percentage</th>
                                       <!-- <th class="text-right">Total Sales</th> -->
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($data) && count($data) > 0){ ?>

                                          <?php $i=1; foreach($data as $rs){ ?>

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
                                             <td><?php 
                                                $employee_name = getOne('tbl_employee','employee_id',$rs['employee_id']);
                                                echo $employee_name =  $employee_name['employee_name']; 
                                             ?></td>
                                             <td class="text-center"><?php echo $rs['target_year']; ?></td>
                                             <td class="text-center"><?php if($rs['total_orders'] == 0){ echo "<span class='text-danger'>".$rs['total_orders']."</span>"; }else{ echo $rs['total_orders']; } ?></td>                                             
                                             <td class="text-center"><?php echo  number_format($rs['target_amount'],2); ?></td>
                                             <td class="text-center"><?php echo $rs['total_order_amount']; ?></td>                                             
                                             <td class="text-center"><?php echo $rs['total_outstanding']; ?></td>                                             
                                             <td class="text-center"><?php if($rs['target_status'] == 1){ echo "<span class='text-primary'> Achieved </span>"; }else{ echo "<span class='text-danger'> Pending </span>"; } ?></td>                                             
                                             <td class="text-center"><?php echo $rs['percentage']." %"; ?></td>                                             
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