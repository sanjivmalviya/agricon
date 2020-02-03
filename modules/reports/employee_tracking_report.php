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
        $and = " AND employee_id = '".$employee_id."' "; 
     }else{
        $and = " GROUP BY employee_id ";
     } 
     
     if(isset($date_to) && $date_to != ""){

        $total_meeting_with_farmer = " SELECT employee_id,COUNT(*) as total_meeting_with_farmer FROM tbl_marketing_employee_routine_meeting WHERE meeting_with = '1' AND (DATE(created_at) BETWEEN '".$date_from."' AND '".$date_to."') ".$and;

        $total_meeting_with_dealer = " SELECT employee_id,COUNT(*) as total_meeting_with_dealer FROM tbl_marketing_employee_routine_meeting WHERE meeting_with = '2' AND (DATE(created_at) BETWEEN '".$date_from."' AND '".$date_to."') ".$and;
        
     }else{

        $total_meeting_with_farmer = " SELECT employee_id,COUNT(*) as total_meeting_with_farmer FROM tbl_marketing_employee_routine_meeting WHERE meeting_with = '1' AND (DATE(created_at) = '".$date_from."') ".$and;

        $total_meeting_with_dealer = " SELECT employee_id,COUNT(*) as total_meeting_with_dealer FROM tbl_marketing_employee_routine_meeting WHERE meeting_with = '2' AND (DATE(created_at) = '".$date_from."') ".$and;

     }


     $total_meeting_with_farmer = getRaw($total_meeting_with_farmer);
     $total_meeting_with_dealer = getRaw($total_meeting_with_dealer);



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


                                 <table class="table table-striped table-bordered table-condensed table-hover">
                                    
                                    <thead>
                                       <th width="5%" class="text-center">Sr.</th>
                                       <th class="text-center">Employee Name</th>
                                       <th class="text-center">Meetings with Farmer</th>
                                       <th class="text-center">Meetings with Customer</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php $total_farmer_meetings = 0; $total_dealer_meetings = 0; if(isset($total_meeting_with_farmer) && count($total_meeting_with_farmer) > 0){ ?>

                                          <?php $i=1; $j=0; foreach($total_meeting_with_farmer as $rs){ ?>

                                          <tr>
                                            <td class="text-center"><?php echo $i++; ?></td>
                                             <td class="text-center"><?php 
                                                $employee_name = getOne('tbl_employee','employee_id',$rs['employee_id']);
                                                echo $employee_name =  $employee_name['employee_name']; 

                                                $total_farmer_meetings += $rs['total_meeting_with_farmer']; 
                                                $total_dealer_meetings += $total_meeting_with_dealer[$j]['total_meeting_with_dealer']; 
                                             ?></td>
                                             
                                             <td class="text-center"><?php echo $rs['total_meeting_with_farmer']; ?></td>
                                             <td class="text-center"><?php echo $total_meeting_with_dealer[$j]['total_meeting_with_dealer']; ?></td>
                                          </tr>
                                          <?php } ?>

                                       <?php $j++; } ?>

                                    </tbody>

                                    <tfoot>
                                      <tr>
                                        <td class="text-center" colspan="2"><b>TOTAL MEETINGS</b></td>
                                        <td class="text-center"><b><?php echo $total_farmer_meetings; ?></b></td>
                                        <td class="text-center"><b><?php echo $total_dealer_meetings; ?></b></td>
                                      </tr>
                                    </tfoot>

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
