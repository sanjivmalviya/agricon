<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $login_type = $_SESSION['agricon_credentials']['user_type'];

 $date = date('d-m-Y');

 if(isset($_POST['submit'])){
        
      $date_from = date('d-m-Y', strtotime($_POST['date_from']));

      if(isset($_POST['date_to']) && $_POST['date_to'] != ""){
         
          $date_to = date('d-m-Y', strtotime($_POST['date_to']));
          echo $routine_details = "SELECT employee_id,date(day_in) as day_in,latitude_in as day_in_location,longitude_in as day_out_location,routine_id,(SELECT employee_name FROM tbl_employees WHERE employee_id = et.employee_id) AS employee_name FROM tbl_employee_routine et WHERE `date` BETWEEN '".$date_from."' AND '".$date_to."' ORDER BY created_at ";
          exit;

      }else{
      
         $routine_details = "SELECT routine_id,employee_id,SUBSTRING(day_in, 1, 10) as `date`,SUBSTRING(day_in, 12, 5) as day_in_time,SUBSTRING(day_out, 12, 5) as day_out_time,(SELECT employee_name FROM tbl_employee WHERE employee_id = employee_id ORDER BY employee_id ASC LIMIT 1) AS employee_name FROM tbl_marketing_employee_routine WHERE day_in LIKE '%".$date_from."%' ORDER BY routine_id DESC ";
         
      }
      
 }else{

    $routine_details = "SELECT routine_id,employee_id,SUBSTRING(day_in, 1, 10) as `date`,SUBSTRING(day_in, 12, 5) as day_in_time,SUBSTRING(day_out, 12, 5) as day_out_time,(SELECT employee_name FROM tbl_employee WHERE employee_id = employee_id ORDER BY employee_id ASC LIMIT 1) AS employee_name FROM tbl_marketing_employee_routine WHERE day_in LIKE '%".$date."%' ORDER BY routine_id DESC ";
    
 }

 $routine_details = getRaw($routine_details);

?>
<!DOCTYPE html>
<html>
   <head>
      <style>
         .popover{
            z-index: 99999 !important;
            max-width: 100% !important;
            width: 100% !important;
         }
      </style>
   </head>
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
                           <h4 class="page-title">Employee Tracks</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">

                              <form method="post">

                               <!--   <div class="col-md-4">

                                    <div class="form-group">

                                       <label for="id">Select Employee<span class="text-danger">*</span></label>

                                       <select name="id" parsley-trigger="change" required="" class="form-control select2" id="id">

                                          <option value="0">All</option>

                                          <?php if(isset($employees)){ ?>

                                             <?php foreach($employees as $rs){ ?>

                                                <option value="<?php echo $rs['employee_id']; ?>"><?php echo $rs['employee_name']; ?></option>

                                             <?php } ?>

                                          <?php } ?>

                                       </select>

                                    </div>

                                 </div> -->

                                <div class="col-md-3">
                                  
                                  <div class="form-group">
                                    
                                    <label for="">* From Date : </label>
                                    <input type="date" class="form-control" name="date_from" <?php if(isset($date_from)){ echo "value=".date('Y-m-d', strtotime($date_from))."";  }else{ echo "value=".date('Y-m-d', strtotime($date)).""; } ?> required>

                                  </div>  

                                </div>

                                <div class="col-md-3">
                                  
                                  <div class="form-group">
                                    
                                    <label for="">To Date : </label>
                                    <input type="date" class="form-control" name="date_to" <?php if(isset($date_to)){ echo "value=".date('Y-m-d', strtotime($date_to))."";  } ?>>

                                  </div>  

                                </div>

                                 <div class="col-md-3">
                                    <br>
                                    <button type="submit" name="submit" class="btn btn-primary btn-md"><i class="fa fa-filter"></i> Filter</button>
                                    <a href="employee_tracking.php" class="btn btn-default btn-md"><i class="fa fa-filter"></i> Reset</a>
                                 </div>

                              </form>

                           </div>
                           
                           <div class="row">

                           		<table class="table table-sroutineed table-bordered table-condensed table-hover" style="margin-top: 50px;">
                           			
                           			<thead>
                                       <tr>
                                       <th width="5%">Sr.</th>
                                       <th width="20%">Employee</th>
                                       <th width="7%">Date</th>
                                       <th width="15%">Day-in Location</th>
                                       <th width="15%">Day-Out Location</th>
                                       <th width="7%">Day-In Time</th>
                                       <th width="7%">Day-Out Time</th>
                                       <th width="7%">Routine Id</th>
                           				<th width="10%" class="text-center">Actions</th>
                                       </tr>
                           			</thead>

                           			<tbody>
                           				
                           				<?php if(isset($routine_details) && count($routine_details) > 0){ ?>

                           					<?php $i=1; foreach($routine_details as $rs){ ?>

                           					<tr>
                                             <td><?php echo $i++; ?></td>
                                             <td><?php echo $rs['employee_name']; ?></td> 
                                             <td><?php echo $rs['date']; ?></td>
                                             <?php 
                                            
                                                $start_location = "-";
                                                $end_location = "-";
                                                $api_calls = "-";

                                                $api_response = "SELECT * FROM tbl_employee_routine_tracking WHERE routine_id = '".$rs['routine_id']."' ";
                                                $api_response = getRaw($api_response);
                                                $tracking_id = $api_response[0]['tracking_id'];

                                                $total_miles = 0;
                                                $total_km = 0;
                                                $total_location_count = 0;
                                                if(isset($api_response)){
                                                
                                                   $api_response =json_decode($api_response[0]['api_response'],true);
                                                   $start_location = $api_response['origin_addresses'][0]; 
                                                   $end_location = end($api_response['destination_addresses']);

                                                   $total_distance = 0;
                                                   $total_location_count = count($api_response['destination_addresses']);

                                                   for($i=0;$i<$total_location_count;$i++){ 

                                                      $distance = $api_response['rows'][$i]['elements'][$i]['distance']['value'] / 1000; // to convert meters to km
                                                      $distance = number_format($distance,2);
                                                      $total_distance += $distance;

                                                   }

                                                }
                                             ?>

                                             <td><?php echo $start_location; ?></td>
                                             <td><?php echo $end_location; ?></td>
                                             <td><?php echo $rs['day_in_time']; ?></td>
                                             <td><?php echo $rs['day_out_time']; ?></td>
                                             <td><?php echo $rs['routine_id']; ?></td> 
                                             <td><a href="marketing_employee_meetings.php?routine_id=<?php echo $rs['routine_id']; ?>" class="btn btn-primary btn-sm">View Meetings</a></td>
                           					</tr>
                           					<?php } ?>

                           				<?php }else{ ?>

                                          <tr>
                                             <td colspan="11" class="text-center">No Records Found</td>
                                          </tr>

                                       <?php } ?>

                           			</tbody>

                           		</table>

                                 <div class="row">
                                    <div class="col-md-12 p-t-30">
                                          <?php if(isset($success)){ ?>
                                             <div class="alert alert-success"><?php echo $success; ?></div>
                                          <?php }else if(isset($warning)){ ?>
                                             <div class="alert alert-warning"><?php echo $warning; ?></div>
                                          <?php }else if(isset($error)){ ?>
                                             <div class="alert alert-danger"><?php echo $error; ?></div>
                                          <?php } ?>
                                       </div>  
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

      <script>
         
         $('.claim-accept').on('click', function(){
               
            var claim_id = $(this).attr('id');

            if(confirm('are you sure ?')){
               
               $.ajax({

                     url : 'ajax/accept_claim_request.php',
                     type : 'POST',
                     dataType : 'json',
                     data : { claim_id : claim_id },
                     success : function(data){
                        alert(data.msg);
                        // console.log(data);
                     }

               });

            }
            

         });

      </script>

   </body>
</html>
