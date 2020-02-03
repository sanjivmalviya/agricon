<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['agricon_credentials']['user_id'];

   $table_name = "employee_annual_leaves";
   $field_name = "id"; 

   $getLeaves = "SELECT *,(SELECT employee_name FROM tbl_employee WHERE employee_id = lv.employee_id) as employee_name FROM employee_annual_leaves lv ORDER BY year,id DESC";
   $getLeaves = getRaw($getLeaves);


   $employees = getAll('tbl_employee');
   

   if(isset($_POST['submit'])){

    $employee_id = $_POST['employee_id'];
    $year = $_POST['year'];
    $leaves = $_POST['leaves'];

    $check = "SELECT * FROM employee_annual_leaves WHERE employee_id = '".$employee_id."' AND year = '".$year."' ";
    $check = getRaw($check);

    // allow if employee has passed 1 year
    $checkDOJ = getOne('tbl_employee','employee_id',$employee_id);
    $checkDOJ = dateDiff($checkDOJ['employee_doj'],date('Y-m-d'));

    if(isset($check) && count($check) > 0){

      $error = "Leaves already added to this year for selected employee";

    }else if(isset($checkDOJ) && $checkDOJ <= 365 ){
      
      $error = "Leaves cant be added because employee must have completed 1 year";

    }else{
      
      $form_data = array(
          'employee_id' => $employee_id,
          'year' => $year,
          'leaves' => $leaves
      );
      
      if(insert('employee_annual_leaves',$form_data)){
        $success = "Leaves added Successfully";
      }else{
        $error = "Failed to add leaves";
      }

    }

   }


   if(isset($_GET['edit_id'])){

         $edit_data = getOne($table_name,$field_name,$_GET['edit_id']);         

         $edit_data = array(

           'employee_id' => $edit_data['employee_id'],
           'year' => $edit_data['year'],
           'leaves' => $edit_data['leaves'],

         );

   }
    

  if(isset($_POST['update'])){

     $form_data = array(

       'year' => $_POST['year'],
       'leaves' => $_POST['leaves'],

     );

     if(update($table_name,$field_name,$_GET['edit_id'],$form_data)){

           $success = "Leaves Updated Successfully";

       }else{

           $error = "Failed to update Leave, try again later";


       }

  }

  if(isset($_GET['delete_id'])){
    
   if(delete($table_name,$field_name,$_GET['delete_id'])){

      $success = "Record Deleted Successfully";

      header('location:add_leave.php');

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

                           <h4 class="page-title">Add Annual Leaves</h4>

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

                                             <label for="leaves">Annual Leaves<span class="text-danger">*</span></label>

                                             <input type="number" name="leaves" parsley-trigger="change" required="" placeholder="" class="form-control" id="leaves" value="<?php if(isset($edit_data['leaves'])){ echo $edit_data['leaves']; } ?>">

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
                                  <th width="50%">Employee</th>
                                  <th>Year</th>
                                  <th>Leaves</th>
                                  <th>Created at</th>
                                  <th width="5%">Action</th>
                                </tr>
                              </thead>

                              <tbody>
                                <?php if(isset($getLeaves)){ ?>
                                  <?php $i=1; foreach($getLeaves as $rs){ ?>
                                    <tr>
                                      <td><?php echo $i++; ?></td>
                                      <td><?php echo $rs['employee_name']; ?></td>
                                      <td><?php echo $rs['year']; ?></td>
                                      <td><?php echo $rs['leaves']; ?></td>
                                      <td><?php echo date('d-m-Y h:i', strtotime($rs['created_at'])); ?></td>
                                      <td class="text-center">

                                          <a href="add_leave.php?edit_id=<?php echo $rs['id']; ?>"><i class="fa fa-pencil"></i></a>

                                          <a href="add_leave.php?delete_id=<?php echo $rs['id']; ?>" onclick=" return confirm('Are you sure ?'); "><i class="fa fa-trash"></i></a></td>
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
        
        $('#employee_id').select2();
        $('#year').select2();

        $('#leaveTable').dataTable();

      </script>


   </body>

</html>
