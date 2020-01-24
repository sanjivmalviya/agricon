<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $login_type = $_SESSION['agricon_credentials']['user_type'];
 
 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $employees = getWhere('tbl_employee','added_by',$login_id);


 if(isset($_POST['submit'])){

    echo "this feature is under testing, please search through root entries. Thank You";
    exit; 

    $employee_id = $_POST['employee_id'];       
      
    $target = "SELECT target_category_id,SUM(target_category_amount) as target_amount,employee_id FROM tbl_target WHERE added_by = '$login_id' AND employee_id = '$employee_id' ";

    $target = getRaw($target);

    if(isset($target)){
   
      foreach($target as $rs){

         $total_order_amount = "SELECT COALESCE(SUM(employee_order_amount),0) as total_order_amount FROM tbl_employee_target_detail WHERE employee_id = '$employee_id' ";
         $total_order_amount = getRaw($total_order_amount);
         $total_order_amount = $total_order_amount[0]['total_order_amount'];

         $target_pre_achieved = "SELECT SUM(target_category_achieved) as target_pre_achieved,employee_id FROM tbl_target WHERE target_category_id IS NULL AND employee_id = '".$rs['employee_id']."' ";
          $target_pre_achieved = getRaw($target_pre_achieved);

          if(count($target_pre_achieved) > 0){
            $target_pre_achieved = $target_pre_achieved[0]['target_pre_achieved'];
          }else{
            $target_pre_achieved = 0;
          }

          $target_achieved = "SELECT det.order_detail_id,det.order_product_discount,det.order_product_igst,det.order_product_sgst,det.order_product_cgst,det.order_product_rate FROM `tbl_order_detail` det INNER JOIN tbl_product pro ON det.order_product_id  = pro.product_id INNER JOIN tbl_sub_category cat ON cat.sub_category_id = pro.sub_category_id WHERE cat.sub_category_id = '".$rs['target_category_id']."' ";
           // exit;

           // $target_achieved = "SELECT det.order_detail_id,det.order_product_igst,det.order_product_sgst,det.order_product_cgst,det.order_product_rate FROM `tbl_order_detail` det INNER JOIN tbl_product pro ON det.order_product_id  = pro.product_id INNER JOIN tbl_category cat ON cat.category_id = pro.category_id WHERE cat.category_id = '".$rs['target_category_id']."' AND YEAR(det.created_at) = '$year' AND MONTH(det.created_at) = '$month' ";
           
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

               $dataset['target_achieved'] = $final_amount;

           }else{

               $dataset['target_achieved'] = 0;

           }
           exit;

         // $rs['employee_id'] = $rs['employee_id'];
         // // $rs['total_order_amount'] = number_format($total_order_amount,2);
         // $rs['total_order_amount'] = $total_order_amount + $target_pre_achieved;         
         // $rs['total_outstanding'] = $rs['target_amount'] - $rs['total_order_amount'];
         // $rs['total_outstanding'] = number_format($rs['total_outstanding'],2);
         // if($rs['total_order_amount'] >= $rs['target_amount']){
         //    $rs['target_status'] = 1;
         //    $rs['total_outstanding'] = substr($rs['total_outstanding'],1);
         // }else{
         //    $rs['target_status'] = 0;
         // }

         if($rs['total_order_amount'] == 0){
            $rs['percentage'] = 0;
         }else{
            // $percentage = number_format((1 - $total_order_amount / $rs['target_amount'] ) * 100,0);
            $percentage = ($rs['total_order_amount'] / $rs['target_amount']) * 100;
            $rs['percentage'] = number_format($percentage,2);                    
         }
         $data[] = $rs;
         // $rs['total_order_amount'] = $rs['total_order_amount'] + $target_pre_achieved;
         $data[] = $rs;

      }
   }
   
 }else{

  
    $target = "SELECT SUM(target_category_amount) as target_amount,employee_id FROM tbl_target WHERE added_by = '$login_id' GROUP BY employee_id ";
    $target = getRaw($target);

    // echo "<pre>";
    // print_r($target);
    // exit;

   if(isset($target)){
      
      $data = array();

      foreach($target as $rs){

            // pre achieved
            $target_pre_achieved = "SELECT  IFNULL(SUM(target_category_achieved),0) as target_pre_achieved FROM tbl_target WHERE employee_id = '".$rs['employee_id']."' ";
            $target_pre_achieved = getRaw($target_pre_achieved);
            $target_pre_achieved = $target_pre_achieved[0]['target_pre_achieved'];

            // achieved by placing orders
            $target_achieved = "SELECT det.order_detail_id,det.order_product_discount,det.order_product_igst,det.order_product_sgst,det.order_product_cgst,det.order_product_rate FROM `tbl_order_detail` det INNER JOIN tbl_orders ord ON ord.order_id = det.order_id WHERE ord.employee_id = '".$rs['employee_id']."' ";
            $target_achieved = getRaw($target_achieved);

              if(isset($target_achieved)){

               foreach($target_achieved as $val){

                    $dispatch_quantity = "SELECT IFNULL(SUM(dispatch_quantity),0) AS dispatch_quantity FROM tbl_invoice_detail WHERE order_detail_id = '".$val['order_detail_id']."' ";
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
            }


            $dataset['employee_id'] = $rs['employee_id'];
            $dataset['total_target_assigned'] = $rs['target_amount'];
            $dataset['total_target_achieved'] = $final_amount + $target_pre_achieved;
            $dataset['total_outstanding'] = $dataset['total_target_assigned'] - $dataset['total_target_achieved'];

            if($dataset['total_target_achieved'] == 0){
               $percentage = 0;
            }else{
               $percentage = ($dataset['total_target_achieved'] / $dataset['total_target_assigned']) * 100;
               $percentage = number_format($percentage,2);                    
            }
            $dataset['total_percentage'] = $percentage;
            $data[] = $dataset;
      }
   }

 }

if(isset($data)){
   
   function compare($a, $b)
   {
      return ($data['percentage'] < $data['percentage']);
   }
   usort($data, "compare");   
   $data = array_map("unserialize", array_unique(array_map("serialize", $data)));

   // $data = array_unique($data);
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
                           <h4 class="page-title">Sales by Target Report</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">

                           <div class="row">

                              <form method="post">

                                 <div class="col-md-4 ">                              
                                    <div class="form-group">
                                          Select Employee
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

                                 <?php if(isset($employee_name)){ ?>
                                    <h4 style="padding-right: 20px;"><i> <?php echo $employee_name; ?></b></i></h4>
                                 <?php } ?>
                                 <br> 

                                 <table class="table table-striped table-bordered table-condensed table-hover">
                                    
                                    <thead>
                                       <th class="text-center">Employee Name</th>
                                       <th class="text-center">Total Target</th>
                                       <th class="text-center">Achieved</th>
                                       <th class="text-center">Outstanding</th>
                                       <!-- <th class="text-center">Status</th> -->
                                       <th class="text-center">Percentage</th>
                                       <!-- <th class="text-right">Total Sales</th> -->
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($data) && count($data) > 0){ ?>

                                          <?php $i=1; foreach($data as $rs){ ?>

                                          <tr>
                                             <td class="text-center"><?php 
                                                $employee_name = getOne('tbl_employee','employee_id',$rs['employee_id']);
                                                echo $employee_name =  $employee_name['employee_name']; 
                                             ?></td>
                                                                            
                                             <td class="text-center"><?php echo $rs['total_target_assigned']; ?></td>                                             
                                             <td class="text-center"><?php echo  $rs['total_target_achieved']; ?></td>
                                             <td class="text-center"><?php echo $rs['total_outstanding']; ?></td>
                                             <td class="text-center"><?php echo $rs['total_percentage']." %"; ?></td>                                             
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
