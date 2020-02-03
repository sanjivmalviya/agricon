<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $login_type = $_SESSION['agricon_credentials']['user_type'];
 
 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $employees = getWhere('tbl_employee','employee_type','2');

 $target_months = getAll('tbl_target_months');
 $sub_categories = getAll('tbl_sub_category');

 if(isset($_POST['submit'])){

     $employee_id = $_POST['employee_id'];
     $date_from = $_POST['date_from'];
     $date_to = $_POST['date_to'];

     if(isset($employee_id) && $employee_id != ""){
        $and = " AND met.employee_id = '".$employee_id."' GROUP BY met.employee_id,frm.farmer_name ORDER BY repetive_meeting_with_farmer DESC "; 
        $and2 = "AND met.employee_id = '".$employee_id."' GROUP BY met.employee_id,cst.customer_id ORDER BY repetive_meeting_with_dealer DESC";
     }else{
        $and = " GROUP BY met.employee_id,frm.farmer_name ORDER BY repetive_meeting_with_farmer DESC ";
        $and2 = "GROUP BY met.employee_id,cst.customer_id ORDER BY repetive_meeting_with_dealer DESC";
     } 
     
     if(isset($date_to) && $date_to != ""){

        $repetive_meeting_with_farmer = " SELECT met.employee_id,frm.farmer_name,COUNT(*) as repetive_meeting_with_farmer FROM `tbl_marketing_employee_routine_meeting` met INNER JOIN tbl_farmer_basic_details frm ON met.meeting_id = frm.meeting_id WHERE met.meeting_with = '1' AND date(met.created_at) BETWEEN '".$date_from."' AND '".$date_to."' ".$and;

        $repetive_meeting_with_dealer = "SELECT met.employee_id,cst.customer_id,COUNT(*) as repetive_meeting_with_dealer FROM `tbl_marketing_employee_routine_meeting` met INNER JOIN tbl_customer cst ON met.meeting_id = cst.meeting_id WHERE met.meeting_with = '2' AND date(met.created_at) BETWEEN '".$date_from."' AND '".$date_to."'  ".$and2;
        
     }else{

        $repetive_meeting_with_farmer = " SELECT met.employee_id,frm.farmer_name,COUNT(*) as repetive_meeting_with_farmer FROM `tbl_marketing_employee_routine_meeting` met INNER JOIN tbl_farmer_basic_details frm ON met.meeting_id = frm.meeting_id WHERE met.meeting_with = '1' AND date(met.created_at) = '".$date_from."' ".$and;

        $repetive_meeting_with_dealer = " SELECT employee_id,COUNT(*) as total_meeting_with_dealer FROM tbl_marketing_employee_routine_meeting WHERE meeting_with = '2' AND date(met.created_at) = '".$date_from."' ".$and2;

     }


     $repetive_meeting_with_farmer = getRaw($repetive_meeting_with_farmer);
     $repetive_meeting_with_dealer = getRaw($repetive_meeting_with_dealer);


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
                           <h4 class="page-title">Employee Tracking Report</h4>
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
                                            Choose Employee
                                            <select name="employee_id" class="form-control select2">
                                              <option value="">All</option>
                                                <?php if(isset($employees) && count($employees) > 0){ ?>

                                                    <?php foreach($employees as $rs){ ?>

                                                        <option <?php if(isset($_POST['employee_id']) && $_POST['employee_id'] == $rs['employee_id']){ echo "selected"; } ?> value="<?php echo $rs['employee_id']; ?>"><?php echo $rs['employee_name']; ?></option>

                                                    <?php } ?>
                                                  <?php } ?>
                                               </select>
                                      </div>
                                   </div>

                                 <div class="col-md-3">                              
                                    <div class="form-group">
                                          Date From
                                          <input type="date" name="date_from" id="date_from" class="form-control" value="<?php if(isset($_POST['date_from'])){ echo $_POST['date_from']; } ?>">                                       
                                    </div>
                                 </div>

                                 <div class="col-md-3">                              
                                    <div class="form-group">
                                          Date To
                                          <input type="date" name="date_to" id="date_to" class="form-control" value="<?php echo date('Y-m-d'); ?>" value="<?php if(isset($_POST['date_to'])){ echo $_POST['date_to']; } ?>">                                       
                                    </div>
                                 </div>
                                

                                 <div class="col-md-3">
                                    <br>
                                    <button type="submit" name="submit" class="btn btn-primary btn-md"><i class="fa fa-filter"></i> Filter</button>
                                 </div>


                              </form>

                           </div>

   
                           <div class="row" style="margin-top: 10px;">

                              <div class="col-md-6">


                                 <table class="table table-striped table-bordered table-condensed table-hover">
                                    
                                    <thead>
                                       <th width="5%" class="text-center">Sr.</th>
                                       <th>Employee Name</th>
                                       <th>Farmer</th>
                                       <th class="text-center">Meetings with Farmer</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($repetive_meeting_with_farmer) && count($repetive_meeting_with_farmer) > 0){ ?>

                                          <?php $i=1; foreach($repetive_meeting_with_farmer as $rs){ ?>

                                          <tr>
                                            <td class="text-center"><?php echo $i++; ?></td>
                                             <td><?php 
                                                $employee_name = getOne('tbl_employee','employee_id',$rs['employee_id']);
                                                echo $employee_name =  $employee_name['employee_name']; 
                                             ?></td>
                                             
                                             <td><?php echo $rs['farmer_name']; ?></td>
                                             <td class="text-center"><?php echo $rs['repetive_meeting_with_farmer']; ?></td>
                             
                                          </tr>
                                          <?php } ?>

                                       <?php $j++; } ?>

                                    </tbody>


                                 </table>

                               </div>

                               <div class="col-md-6">


                                 <table class="table table-striped table-bordered table-condensed table-hover">
                                    
                                    <thead>
                                       <th width="5%" class="text-center">Sr.</th>
                                       <th>Employee Name</th>
                                       <th>Customer</th>
                                       <th class="text-center">Meetings with Dealer</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($repetive_meeting_with_dealer) && count($repetive_meeting_with_dealer) > 0){ ?>

                                          <?php $i=1; foreach($repetive_meeting_with_dealer as $rs){ ?>

                                          <tr>
                                            <td class="text-center"><?php echo $i++; ?></td>
                                             <td><?php 
                                                $employee_name = getOne('tbl_employee','employee_id',$rs['employee_id']);
                                                echo $employee_name =  $employee_name['employee_name']; 
                                             ?></td>
                                             <td><?php 
                                                $customer_name = getOne('tbl_customer','customer_id',$rs['customer_id']);
                                                echo $customer_name =  $customer_name['customer_name']; 
                                             ?></td>
                                             <td class="text-center"><?php echo $rs['repetive_meeting_with_dealer']; ?></td>
                             
                                          </tr>
                                          <?php } ?>

                                       <?php $j++; } ?>

                                    </tbody>


                                 </table>

                               </div>
                      
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
