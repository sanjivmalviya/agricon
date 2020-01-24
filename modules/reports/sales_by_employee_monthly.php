<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $login_type = $_SESSION['agricon_credentials']['user_type'];
 
 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $employees = getWhere('tbl_employee','added_by',$login_id);

 $target_months = getAll('tbl_target_months');
 $sub_categories = getAll('tbl_sub_category');

   if(isset($_POST['submit'])){

     $year = $_POST['target_year'];
     $month = $_POST['target_month'];
     $category_id = $_POST['target_category'];
     $employee_id = $_POST['employee_id'];
 
     // all by default
     $target_assigned = "SELECT target_year,target_month,IFNULL(SUM(target_category_amount),0) as target_assigned,IFNULL(SUM(target_category_achieved),0) as target_achieved,employee_id FROM tbl_target WHERE employee_id = '$employee_id' AND target_year = '$year' AND target_month = '$month' ";     
     $target_assigned = getRaw($target_assigned);

     if(isset($target_assigned)){

       foreach($target_assigned as $rs){            

            $dataset['employee_id'] = $rs['employee_id'];
            $dataset['year'] = $rs['target_year'];
            $dataset['month'] = $rs['target_month'];
            $dataset['assigned'] = $rs['target_assigned'];
              
             // get achieved target
             $order_detail = "SELECT * FROM tbl_order_detail det INNER JOIN tbl_orders ord ON ord.order_id = det.order_id WHERE ord.employee_id = '".$rs['employee_id']."' AND YEAR(ord.created_at) = '".$rs['target_year']."' AND MONTH(ord.created_at) = '".$rs['target_month']."' ";
             
             $order_detail = getRaw($order_detail);

             $final_amount = 0;

             if(isset($order_detail)){

                foreach($order_detail as $val){

                    $dispatch_quantity = "SELECT IFNULL(SUM(dispatch_quantity),0) AS dispatch_quantity FROM tbl_invoice_detail WHERE order_detail_id = '".$val['order_detail_id']."'";
                    
                    $dispatch_quantity = getRaw($dispatch_quantity);
                    $dispatch_quantity = $dispatch_quantity[0]['dispatch_quantity'];

                    $amount = $val['order_product_rate'] * $dispatch_quantity;
                    $order_product_discount = $val['order_product_discount'];
                                   
                    $amount_after_discount = $amount * $order_product_discount / 100 ;
                    $amount_after_discount = $amount - $amount_after_discount;

                    
                   if($val['order_product_igst'] > 0){

                      $tax = ($val['order_product_igst'] * $amount_after_discount ) / 100;                

                   }else{

                      $sgst_csgt = 0;
                      $sgst_csgt = $val['order_product_cgst'] * $amount_after_discount  / 100;     
                      $tax  = $sgst_csgt * 2;
                    
                   }
      
                   $final_amount += $amount_after_discount + $tax;  
                
                }

             }else{
             
              $final_amount = 0;
             
             }

             $dataset['achieved'] = $final_amount  + $rs['target_achieved'];
             $dataset['pending'] = $dataset['assigned'] - $dataset['achieved'];
             $data[] = $dataset;

       }

   }

   }else{ 

     // all by default
     $target_assigned = "SELECT target_year,target_month,IFNULL(SUM(target_category_amount),0) as target_assigned,IFNULL(SUM(target_category_achieved),0) as target_achieved,employee_id FROM tbl_target WHERE target_category_id IS NULL GROUP BY target_month,employee_id";     
     $target_assigned = getRaw($target_assigned);


     if(isset($target_assigned)){


       foreach($target_assigned as $rs){

            

            $dataset['employee_id'] = $rs['employee_id'];
            $dataset['year'] = $rs['target_year'];
            $dataset['month'] = $rs['target_month'];
            $dataset['assigned'] = $rs['target_assigned'];
              
             // get achieved target
             $order_detail = "SELECT * FROM tbl_order_detail det INNER JOIN tbl_orders ord ON ord.order_id = det.order_id WHERE ord.employee_id = '".$rs['employee_id']."' AND YEAR(ord.created_at) = '".$rs['target_year']."' AND MONTH(ord.created_at) = '".$rs['target_month']."' ";
             
             $order_detail = getRaw($order_detail);

             $final_amount = 0;

             if(isset($order_detail)){

                foreach($order_detail as $val){

                    $dispatch_quantity = "SELECT IFNULL(SUM(dispatch_quantity),0) AS dispatch_quantity FROM tbl_invoice_detail WHERE order_detail_id = '".$val['order_detail_id']."'";
                    
                    $dispatch_quantity = getRaw($dispatch_quantity);
                    $dispatch_quantity = $dispatch_quantity[0]['dispatch_quantity'];

                    $amount = $val['order_product_rate'] * $dispatch_quantity;
                    $order_product_discount = $val['order_product_discount'];
                                   
                    $amount_after_discount = $amount * $order_product_discount / 100 ;
                    $amount_after_discount = $amount - $amount_after_discount;

                    
                   if($val['order_product_igst'] > 0){

                      $tax = ($val['order_product_igst'] * $amount_after_discount ) / 100;                

                   }else{

                      $sgst_csgt = 0;
                      $sgst_csgt = $val['order_product_cgst'] * $amount_after_discount  / 100;     
                      $tax  = $sgst_csgt * 2;
                    
                   }
      
                   $final_amount += $amount_after_discount + $tax;  
                
                }

             }else{
             
              $final_amount = 0;
             
             }

             $dataset['achieved'] = $final_amount  + $rs['target_achieved'];
             $dataset['pending'] = $dataset['assigned'] - $dataset['achieved'];
             $data[] = $dataset;

       }

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
                           <h4 class="page-title">Sales by Employee</h4>
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
                                              <?php if(isset($target_months) && count($target_months) > 0){ ?>

                                                  <?php foreach($target_months as $rs){ ?>

                                                      <option value="<?php echo $rs['month_id']; ?>"><?php echo $rs['month_name']; ?></option>

                                                  <?php } ?>
                                                <?php } ?>
                                             </select>
                                    </div>
                                 </div>

                                 <div class="col-md-3 ">                              
                                    <div class="form-group">
                                          Choose Employee
                                          <select name="employee_id" class="form-control select2">
                                              <?php if(isset($employees) && count($employees) > 0){ ?>

                                                  <?php foreach($employees as $rs){ ?>

                                                      <option value="<?php echo $rs['employee_id']; ?>"><?php echo $rs['employee_name']; ?></option>

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

                              <?php if(isset($year) && isset($month) && isset($employee_id) && isset($category_id)){ 

                                  $employee_name = getOne('tbl_employee','employee_id',$employee_id);
                                  $employee_name =  $employee_name['employee_name'];     

                                  $category_name = getOne('tbl_category','category_id',$category_id);
                                  $category_name =  $category_name['category_name'];     
                              ?>
                                  <h4 style="padding-right: 20px;"><i> <?php echo $employee_name."'s Sales in ".$month."-".$year." for Category ".$category_name; ?></b></i></h4>
                                 <?php } ?>
                                 <br> 

                                 <table class="table table-striped table-bordered table-condensed table-hover">
                                    
                                    <thead>
                                       <th class="text-center">Employee Name</th>
                                       <th class="text-center">Year</th>
                                       <th class="text-center">Month</th>
                                       <th class="text-center">Assigned Target</th>
                                       <th class="text-center">Achieved Target</th>
                                       <th class="text-center">Pending</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($data) && count($data) > 0){ ?>

                                          <?php $i=1; foreach($data as $rs){ ?>

                                          <tr>
                                             <td class="text-center"><?php 
                                                $employee_name = getOne('tbl_employee','employee_id',$rs['employee_id']);
                                                echo $employee_name =  $employee_name['employee_name']; 
                                             ?></td>
                                             
                                             <td class="text-center"><?php echo $rs['year']; ?></td>
                                             <td class="text-center"><?php echo $rs['month']; ?></td>
                                             
                                                                            
                                             <td class="text-center"><?php echo $rs['assigned']; ?></td>
                                             <td class="text-center"><?php echo $rs['achieved']; ?></td>
                                             <td class="text-center"><?php echo $rs['pending']; ?></td>                                             
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
