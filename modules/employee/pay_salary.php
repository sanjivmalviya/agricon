<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['agricon_credentials']['user_id'];

   $employees = getAll('tbl_employee');

   $table_name = "tbl_employee_salary_payouts";
   $field_name = "id"; 

   $salary_payouts = "SELECT *,(SELECT employee_name FROM tbl_employee WHERE employee_id = sal.employee_id) as employee_name FROM tbl_employee_salary_payouts sal ORDER BY created_at DESC";
   $salary_payouts = getRaw($salary_payouts);

  if(isset($_POST['submit'])){

      $check = "SELECT * FROM tbl_employee_salary_payouts WHERE employee_id =  '".$_POST['employee_id']."' AND year = '".$_POST['year']."' AND month = '".$_POST['month']."' ";
      $check = getRaw($check);
      
      if(isset($check) && count($check) > 0){

        $error = "Salary already paid for this month";

      }else{
         
         $form_data = array(
          'employee_id' => $_POST['employee_id'],
          'year' => $_POST['year'],
          'month' => $_POST['month'],
          'employee_monthly_hra' => $_POST['employee_monthly_hra'],
          'employee_monthly_da' => $_POST['employee_monthly_da'],
          'employee_monthly_extra_allowances' => $_POST['employee_monthly_extra_allowances'],
          'employee_monthly_basic_salary' => $_POST['employee_monthly_basic_salary'],
          'employee_monthly_leaves' => $_POST['employee_monthly_leaves'],
          'employee_monthly_leave_amount' => $_POST['employee_monthly_leave_amount'],
          'employee_monthly_nett_salary' => $_POST['employee_monthly_nett_salary']
         ); 

        if(insert('tbl_employee_salary_payouts',$form_data)){

           $success = "Employee Salary Paid Successfully";

        }else{

           $error = "Failed to pay salary, try again later";

        }

      }
       

  }

  if(isset($_GET['delete_id'])){
         
   if(delete($table_name,$field_name,$_GET['delete_id'])){

      $success = "Record Deleted Successfully";

      header('location:pay_salary.php');

   }else{

      $error = "Failed to Delete Record";

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

                     <div class="col-md-6">

                        <div class="page-title-box">

                           <h4 class="page-title">Pay Salary</h4>

                           <div class="clearfix"></div>

                        </div>

                     </div>                   

                  </div>

                   <div class="row">   

                     

                     <div class="col-sm-12">

                        <div class="card-box">

                           <div class="row">

                              <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

                                 <div class="col-md-12">

                                    <div class="row">

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="employee_id">Employee<span class="text-danger">*</span></label>

                                             <select name="employee_id" id="employee_id" class="form-control select2">
                                               <?php if(isset($employees)){ ?>
                                                  <?php foreach($employees as $rs){ ?>
                                                    <option <?php if($edit_data['employee_id'] == $rs['employee_id']){ echo "selected"; } ?> value="<?php echo $rs['employee_id']; ?>"><?php echo $rs['employee_name']; ?></option>
                                                  <?php } ?>
                                                <?php } ?>
                                             </select>

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="year">Select Year<span class="text-danger">*</span></label>

                                             <select name="year" id="year" class="form-control select2">
                                               <option <?php if($edit_data['year'] == '2020'){ echo "
                                               selected"; } ?> value="2020">2020</option>
                                               <option <?php if($edit_data['year'] == '2021'){ echo "
                                               selected"; } ?> value="2021">2021</option>
                                               <option <?php if($edit_data['year'] == '2022'){ echo "
                                               selected"; } ?> value="2022">2022</option>
                                               <option <?php if($edit_data['year'] == '2023'){ echo "
                                               selected"; } ?> value="2023">2023</option>
                                               <option <?php if($edit_data['year'] == '2024'){ echo "
                                               selected"; } ?> value="2024">2024</option>
                                               <option <?php if($edit_data['year'] == '2025'){ echo "
                                               selected"; } ?> value="2025">2025</option>
                                               <option <?php if($edit_data['year'] == '2026'){ echo "
                                               selected"; } ?> value="2026">2026</option>
                                               <option <?php if($edit_data['year'] == '2027'){ echo "
                                               selected"; } ?> value="2027">2027</option>
                                               <option <?php if($edit_data['year'] == '2028'){ echo "
                                               selected"; } ?> value="2028">2028</option>
                                               <option <?php if($edit_data['year'] == '2029'){ echo "
                                               selected"; } ?> value="2029">2029</option>
                                               <option <?php if($edit_data['year'] == '2030'){ echo "
                                               selected"; } ?> value="2030">2030</option>
                                             </select>

                                          </div>

                                       </div>

                                         <div class="col-md-4">

                                            <div class="form-group">

                                               <label for="month">Select Month<span class="text-danger">*</span></label>

                                               <select name="month" id="month" class="form-control select2">
                                                 <option <?php if($edit_data['month'] == '01'){ echo "
                                                 selected"; } ?> value="01">January</option>
                                                 <option <?php if($edit_data['month'] == '02'){ echo "
                                                 selected"; } ?> value="02">February</option>
                                                 <option <?php if($edit_data['month'] == '03'){ echo "
                                                 selected"; } ?> value="03">March</option>
                                                 <option <?php if($edit_data['month'] == '04'){ echo "
                                                 selected"; } ?> value="04">April</option>
                                                 <option <?php if($edit_data['month'] == '05'){ echo "
                                                 selected"; } ?> value="05">May</option>
                                                 <option <?php if($edit_data['month'] == '06'){ echo "
                                                 selected"; } ?> value="06">June</option>
                                                 <option <?php if($edit_data['month'] == '07'){ echo "
                                                 selected"; } ?> value="07">July</option>
                                                 <option <?php if($edit_data['month'] == '08'){ echo "
                                                 selected"; } ?> value="08">August</option>
                                                 <option <?php if($edit_data['month'] == '09'){ echo "
                                                 selected"; } ?> value="09">September</option>
                                                 <option <?php if($edit_data['month'] == '10'){ echo "
                                                 selected"; } ?> value="10">October</option>
                                                 <option <?php if($edit_data['month'] == '11'){ echo "
                                                 selected"; } ?> value="11">November</option>
                                                 <option <?php if($edit_data['month'] == '12'){ echo "
                                                 selected"; } ?> value="12">December</option>
                                               </select>

                                            </div>

                                         </div>

                                    
                                     </div>


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

                                       <div class="col-md-12">
                                         
                                         <button type="button" class="btn btn-info btn-md calculate_salary">Calculate Salary</button>

                                       </div>


                                     <div class="row">

                                      <div class="col-md-12"> 
                                       <br>
                                        <h4>Employee Salary</h4>
                                      </div>

                                      <div class="col-md-6 table-responsive">

                                      <table class="table table-condensed table-bordered">
                                        <tbody>
                                          <tr>
                                            <td>Monthly Basic Salary <span class="text-danger">*</span></td>
                                            <td><input type="number" required="" parsley-trigger="change" placeholder="" readonly class="form-control" name="employee_monthly_basic_salary" required="" id="employee_monthly_basic_salary" value="<?php if(isset($edit_data['employee_monthly_basic_salary'])){ echo $edit_data['employee_monthly_basic_salary']; } ?>"></td>
                                          </tr>
                                          <tr>
                                            <td>Monthly HRA</td>
                                            <td><input type="number" parsley-trigger="change" placeholder="" readonly class="form-control" name="employee_monthly_hra" id="employee_monthly_hra" value="<?php if(isset($edit_data['employee_monthly_hra'])){ echo $edit_data['employee_monthly_hra']; }else{ echo 0; } ?>"></td>
                                          </tr>
                                          <tr>
                                            <td>Monthly DA</td>
                                            <td><input type="number" parsley-trigger="change" placeholder="" readonly class="form-control" name="employee_monthly_da" id="employee_monthly_da" value="<?php if(isset($edit_data['employee_monthly_da'])){ echo $edit_data['employee_monthly_da']; }else{ echo 0; } ?>"></td>
                                          </tr>

                                          <tr>
                                            <td>Monthly Extra Allowances</td>
                                            <td><input type="number" parsley-trigger="change" placeholder="" readonly class="form-control" name="employee_monthly_extra_allowances" id="employee_monthly_extra_allowances" value="<?php if(isset($edit_data['employee_monthly_extra_allowances'])){ echo $edit_data['employee_monthly_extra_allowances']; }else{ echo 0; } ?>"></td>
                                          </tr>

                                          <tr>
                                            <td>Leaves Taken</td>
                                            <td><input type="number" parsley-trigger="change" placeholder="" readonly class="form-control" name="employee_monthly_leaves" id="employee_monthly_leaves" value="<?php if(isset($edit_data['employee_monthly_leaves'])){ echo $edit_data['employee_monthly_leaves']; }else{ echo 0; } ?>"></td>
                                          </tr>

                                          <tr>
                                            <td>Leave Amount</td>
                                            <td><input type="number" parsley-trigger="change" placeholder="" readonly class="form-control" name="employee_monthly_leave_amount" id="employee_monthly_leave_amount" value="<?php if(isset($edit_data['employee_monthly_leave_amount'])){ echo $edit_data['employee_monthly_leave_amount']; }else{ echo 0; } ?>"></td>
                                          </tr>

                                          <tr>
                                            <td>Nett Salary</td>
                                            <td><input type="number" parsley-trigger="change" placeholder="" readonly class="form-control" name="employee_monthly_nett_salary" id="employee_monthly_nett_salary" value="<?php if(isset($edit_data['employee_monthly_nett_salary'])){ echo $edit_data['employee_monthly_nett_salary']; }else{ echo 0; } ?>"></td>
                                          </tr>
                                          
                                        </tbody>
                                      </table>

                                    </div>

                                       

                                       <div class="col-md-12" align="right">

                                          <?php if(isset($edit_data)){ ?>                                             

                                            <button type="submit" name="update" id="update" class="btn btn-danger btn-bordered waves-effect w-md waves-light m-b-5">Update</button>

                                         <?php }else{ ?>

                                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Submit</button>

                                         <?php } ?>

                                       </div>

                                    </div>

                                 </div>

                              </form>

                           </div>

                        </div>

                     </div>

                

                  </div>

                    <div class="row">   

                     <div class="col-sm-12">

                        <div class="card-box table-responsive">
                            
                            <table id="products" class="table table-condensed table-bordered">
                              <thead>
                                <tr>
                                  <th>Sr.</th>
                                  <th width="20%">Employee</th>
                                  <th>Year</th>
                                  <th>Month</th>
                                  <th>Basic Salary</th>
                                  <th>HRA</th>
                                  <th>DA</th>
                                  <th>Extra Allowances</th>
                                  <th>Leave Taken</th>
                                  <th>Leave Amount</th>
                                  <th>Salary Amount</th>
                                  <th>Paid at</th>
                                  <th>Action</th>
                                </tr>
                              </thead>

                              <tbody>
                                <?php if(isset($salary_payouts)){ ?>
                                  <?php $i=1; foreach($salary_payouts as $rs){ ?>
                                    <tr>
                                      <td><?php echo $i++; ?></td>
                                      <td><?php echo $rs['employee_name']; ?></td>
                                      <td><?php echo $rs['year']; ?></td>
                                      <td><?php echo $rs['month']; ?></td>
                                      <td><?php echo $rs['employee_monthly_basic_salary']; ?></td>
                                      <td><?php echo $rs['employee_monthly_hra']; ?></td>
                                      <td><?php echo $rs['employee_monthly_da']; ?></td>
                                      <td><?php echo $rs['employee_monthly_extra_allowances']; ?></td>
                                      <td><?php echo $rs['employee_monthly_leaves']; ?></td>
                                      <td><?php echo $rs['employee_monthly_leave_amount']; ?></td>
                                      <td><?php echo $rs['employee_monthly_paid_salary']; ?></td>
                                      <td><?php echo date('d-m-Y h:i', strtotime($rs['created_at'])); ?></td>
                                      <td><a href="pay_salary.php?delete_id=<?php echo $rs['id']; ?>" onclick="return confirm('Are you sure ?'); "><i class="fa fa-trash"></i></a></td>
                                    </tr>
                                  <?php } ?>
                                <?php } ?>
                              </tbody>
                            </table>

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
        
        $('.calculate_salary').on('click', function(){

          var vals = { 
              employee_id : $('#employee_id').val(),
              year : $('#year').val(),
              month : $('#month').val()
          };

          $.ajax({

            url : 'ajax/get_salary_breakup.php',
            type : 'POST',
            dataType : 'JSON',
            data : { vals },
            success : function(data){
                
                $('#employee_monthly_hra').val(data.employee_monthly_hra);
                $('#employee_monthly_da').val(data.employee_monthly_da);
                $('#employee_monthly_extra_allowances').val(data.employee_monthly_extra_allowances);
                $('#employee_monthly_basic_salary').val(data.employee_monthly_basic_salary);
                $('#employee_monthly_leaves').val(data.employee_monthly_leaves);
                $('#employee_monthly_leave_amount').val(data.employee_monthly_leave_amount);
                $('#employee_monthly_nett_salary').val(data.employee_monthly_nett_salary);

            }

          });

        });

      </script>

   </body>

</html>
