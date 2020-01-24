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
 
     $target_assigned = "SELECT target_category_id,COALESCE(SUM(target_category_amount),0) as target_assigned,employee_id FROM tbl_target WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = '$month' AND target_category_id = '$category_id' AND employee_id = '$employee_id' GROUP BY target_category_id,employee_id";
     $target_assigned = getRaw($target_assigned);

     if(isset($target_assigned)){
       foreach($target_assigned as $rs){

        if($rs['target_category_id'] != ""){

           $dataset['target_category_id'] = $rs['target_category_id'];
           $dataset['employee_id'] = $rs['employee_id'];
           $dataset['target_assigned'] = $rs['target_assigned'];

           $target_achieved = "SELECT det.order_detail_id,det.order_product_discount,det.order_product_igst,det.order_product_sgst,det.order_product_cgst,det.order_product_rate FROM `tbl_order_detail` det INNER JOIN tbl_product pro ON det.order_product_id  = pro.product_id INNER JOIN tbl_sub_category cat ON cat.sub_category_id = pro.sub_category_id INNER JOIN tbl_target tgt ON tgt.target_category_id = cat.sub_category_id WHERE tgt.employee_id = '$employee_id' AND cat.sub_category_id = '".$rs['target_category_id']."' AND YEAR(det.created_at) = '$year' AND MONTH(det.created_at) = '$month' ";
           
           $target_achieved = getRaw($target_achieved);

           if(isset($target_achieved)){

               foreach($target_achieved as $val){

                   $dispatch_quantity = "SELECT SUM(dispatch_quantity) AS dispatch_quantity FROM tbl_invoice_detail WHERE order_detail_id = '".$val['order_detail_id']."' ";
                   $dispatch_quantity = getRaw($dispatch_quantity);

                   if(isset($dispatch_quantity)){
                     $dispatch_quantity = $dispatch_quantity[0]['dispatch_quantity'];
                   }else{
                     $dispatch_quantity = 0;
                   }

                   $amount = $val['order_product_rate'] * $dispatch_quantity;

                   $order_product_discount = $amount * $val['order_product_discount'] / 100;
                   $amount_after_discount = $amount - $order_product_discount;
                   
                   if($val['order_product_igst'] > 0){
                      
                      $tax = $val['order_product_igst'] * $amount_after_discount / 100;
                   
                   }else{

                      $tax = $val['order_product_sgst'] * $amount_after_discount / 100;
                      $tax = $tax * 2;
                    
                   }

                   $final_amount += $amount_after_discount + $tax; 
               }

               $dataset['target_achieved'] = $final_amount;

           }else{

               $dataset['target_achieved'] = 0;

           }

           if($dataset['target_achieved'] > $dataset['target_assigned']){

               $target_status = "Achieved";
               $dataset['target_pending'] = "+".$dataset['target_achieved'] - $dataset['target_assigned'];

           }else{
             
               $target_status = "Pending";
               $dataset['target_pending'] = $dataset['target_assigned'] - $dataset['target_achieved'];
             
           }
           
           $dataset['target_assigned'] = number_format($dataset['target_assigned'],2);
           $dataset['target_achieved'] = number_format($dataset['target_achieved'],2);
           $dataset['target_pending'] = number_format($dataset['target_pending'],2);

           $data[] = $dataset;

       }

     }

     }

   }else{ 

     // all by default
     $target_assigned = "SELECT target_category_id,COALESCE(SUM(target_category_amount),0) as target_assigned,employee_id FROM tbl_target GROUP BY target_category_id,employee_id";
     $target_assigned = getRaw($target_assigned);

     if(isset($target_assigned)){

       foreach($target_assigned as $rs){

           if($rs['target_category_id'] != ""){

           $dataset['target_category_id'] = $rs['target_category_id'];
           $dataset['employee_id'] = $rs['employee_id'];
           $dataset['target_assigned'] = $rs['target_assigned'];

           $target_achieved = "SELECT det.order_detail_id,det.order_product_discount,det.order_product_igst,det.order_product_sgst,det.order_product_cgst,det.order_product_rate FROM `tbl_order_detail` det INNER JOIN tbl_product pro ON det.order_product_id  = pro.product_id INNER JOIN tbl_sub_category cat ON cat.sub_category_id = pro.sub_category_id WHERE cat.sub_category_id = '".$rs['target_category_id']."' ";
           
           $target_achieved = getRaw($target_achieved);

           if(isset($target_achieved)){

               foreach($target_achieved as $val){

                   $dispatch_quantity = "SELECT SUM(dispatch_quantity) AS dispatch_quantity FROM tbl_invoice_detail WHERE order_detail_id = '".$val['order_detail_id']."' ";
                   $dispatch_quantity = getRaw($dispatch_quantity);

                   if(isset($dispatch_quantity)){
                     $dispatch_quantity = $dispatch_quantity[0]['dispatch_quantity'];
                   }else{
                     $dispatch_quantity = 0;
                   }

                   $amount = $val['order_product_rate'] * $dispatch_quantity;

                   $order_product_discount = $amount * $val['order_product_discount'] / 100;
                   $amount_after_discount = $amount - $order_product_discount;
                   
                   $val['order_product_igst'];

                   if($val['order_product_igst'] > 0){
                      
                      $tax = $val['order_product_igst'] * $amount_after_discount / 100;
                   
                   }else{

                      $tax = $val['order_product_sgst'] * $amount_after_discount / 100;
                      $tax = $tax * 2;
                    
                   }

                   $final_amount += $amount_after_discount + $tax; 
               
               }

               $dataset['target_achieved'] = $final_amount;


           }else{

               $dataset['target_achieved'] = 0;

           }

           if($dataset['target_achieved'] > $dataset['target_assigned']){

               $target_status = "Achieved";
               $dataset['target_pending'] = "+".$dataset['target_achieved'] - $dataset['target_assigned'];

           }else{
             
               $target_status = "Pending";
               $dataset['target_pending'] = $dataset['target_assigned'] - $dataset['target_achieved'];
             
           }
           
           $dataset['target_assigned'] = number_format($dataset['target_assigned'],2);
           $dataset['target_achieved'] = number_format($dataset['target_achieved'],2);
           $dataset['target_pending'] = number_format($dataset['target_pending'],2);

           $data[] = $dataset;

       }

     }
   }

   }

   // echo "<pre>";
   // print_r($data);
   // exit;


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
                                          Choose Sub Category
                                          <!-- note : above is sub categorry -->
                                          <select name="target_category" class="form-control select2">
                                              <?php if(isset($sub_categories) && count($sub_categories) > 0){ ?>

                                                  <?php foreach($sub_categories as $rs){ ?>

                                                      <option value="<?php echo $rs['sub_category_id']; ?>"><?php echo $rs['sub_category_name']; ?></option>

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
                                       <th class="text-center">Sub Cateogory</th>
                                       <th class="text-center">Target</th>
                                       <th class="text-center">Achieved</th>
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
                                             
                                             <td class="text-center"><?php 
                                                $target_category_name = getOne('tbl_sub_category','sub_category_id',$rs['target_category_id']);                    
                                                echo $target_category_name =  $target_category_name['sub_category_name']; 
                                             ?></td>
                                             
                                                                            
                                             <td class="text-center"><?php echo $rs['target_assigned']; ?></td>
                                             <td class="text-center"><?php echo $rs['target_achieved']; ?></td>
                                             <td class="text-center"><?php echo $rs['target_pending']; ?></td>                                             
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
