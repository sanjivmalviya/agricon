
<?php

   require_once('../../functions.php');

   $states = getAll('tbl_state');
   $cities = getAll('tbl_city');

   if(isset($_POST['submit_state'])){

         $connect = connect();

         $state_name = sanitize($_POST['state_name']);

         if(isExists('tbl_state','state_name',$state_name)){

               $warning = "Sorry ! name already exists";

         }else{

            $form_data = array(
               'state_name' => $state_name
            );

            if(insert('tbl_state',$form_data)){
               
               $success = "State added successfully ";

            }else{
               
               $error = "Failed to add State";

            }

         }

   }

   if(isset($_POST['submit2'])){

         $state_id = $_POST['state_id'];
         $city_name = $_POST['city_name'];

         $connect = connect();

         $state_name = sanitize($_POST['state_name']);

         if(isExists('tbl_city','city_name',$city_name)){

               $warning = "Sorry ! City already exists";

         }else{

            $form_data = array(
               'state_id' => $state_id,
               'city_name' => $city_name
            );

            if(insert('tbl_city',$form_data)){
               
               $success2 = "City added successfully ";

            }else{
               
               $error2 = "Failed to add City";

            }

         }

   }


   $table_name1 = 'tbl_state';
   $field_name1 = 'state_id';

   if(isset($_GET['edit_state_id'])){

         $edit_state = getOne($table_name1,$field_name1,$_GET['edit_state_id']);         
         $edit_state = array(
           'state_name' => $edit_state['state_name']
         );

   }

   if(isset($_POST['update_state'])){

      // POST DATA 
      $form_data = array(
        'state_name' => $_POST['state_name']
      );

      if(update($table_name1,$field_name1,$_GET['edit_state_id'],$form_data)){
          $success = "State Updated Successfully";
      }else{
          $error = "Failed to update State, try again later";
      }

   }

 if(isset($_GET['delete_state_id'])){
         
   if(delete($table_name1,$field_name1,$_GET['delete_state_id'])){
      $success = "Record Deleted Successfully";
   }else{
      $error = "Failed to Delete Record";
   }

 }

   $table_name2 = 'tbl_city';
   $field_name2 = 'city_id';

   if(isset($_GET['edit_city_id'])){

         $edit_city = getOne($table_name2,$field_name2,$_GET['edit_city_id']);         
         $edit_city = array(
           'state_id' => $edit_city['state_id'],
           'city_name' => $edit_city['city_name']
         );

   }

   if(isset($_POST['update_city'])){

      // POST DATA 
      $form_data = array(
        'state_id' => $_POST['state_id'],
        'city_name' => $_POST['city_name']
      );

      if(update($table_name2,$field_name2,$_GET['edit_city_id'],$form_data)){
          $success = "city Updated Successfully";
      }else{
          $error = "Failed to update city, try again later";
      }

   }

 if(isset($_GET['delete_city_id'])){
         
   if(delete($table_name2,$field_name2,$_GET['delete_city_id'])){
      $success = "Record Deleted Successfully";
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
                     <div class="col-md-4">
                        <div class="page-title-box">
                           <h4 class="page-title">Add State</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>              
                     <div class="col-md-8">
                        <div class="page-title-box">
                           <h4 class="page-title">Add City</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>                    
                  </div>
                  <div class="row">
                     <div class="col-sm-4">
                        <div class="card-box">
                           <div class="row">
                              <form method="post" class="form-horizontal" role="form">
                                 <div class="col-md-12">                                    
                                    <div class="row">
                                       <div class="col-md-12">
                                          <div class="form-group">
                                             <label for="userName">State Name<span class="text-danger">*</span></label>
                                             <input type="text" name="state_name" parsley-trigger="change" class="form-control" id="state_name" value="<?php if(isset($edit_state['state_name'])){ echo $edit_state['state_name']; } ?>">
                                          </div>
                                       </div>     
                                      
                                    </div>
                                    <div class="row">
                                       <div class="col-md-12" align="right">
                                          

                                          <?php if(isset($edit_state)){ ?>                                             
                                                <button type="submit" name="update_state" class="btn btn-danger btn-bordered waves-effect w-md waves-light m-b-5">Update</button>
                                            <?php }else{ ?>
                                                <button type="submit" name="submit_state" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Save</button>
                                            <?php } ?>
                                       
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-12 p-t-30">
                                       <?php if(isset($success)){ ?>
                                          <div class="alert alert-success"><?php echo $success; ?></div>
                                       <?php }else if(isset($warning)){ ?>
                                          <div class="alert alert-warning"><?php echo $warning; ?></div>
                                       <?php }else if(isset($error)){ ?>
                                          <div class="alert alert-danger"><?php echo $error; ?></div>
                                       <?php } ?>
                                    </div>
                              </form>
                           </div>

                           <div class="row">
                              
                              <table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                 
                                 <thead>
                                    <th>State</th>
                                    <th class="text-right">Actions</th>
                                 </thead>

                                 <tbody>
                                    
                                    <?php if(isset($states) && count($states) > 0){ ?>

                                       <?php foreach($states as $rs){ ?>

                                       <tr>
                                          <td width="60%" ><?php echo ucwords($rs['state_name']); ?></td>
                                          <td width="40%" class="text-right" >
                                             <a href="add_state.php?edit_state_id=<?php echo $rs['state_id']; ?>"><i class="fa fa-pencil"></i></a>
                                                <a href="add_state.php?delete_state_id=<?php echo $rs['state_id']; ?>" onclick=" return confirm('Are you sure ?'); "><i class="fa fa-trash"></i></a>
                                          </td>
                                       </tr>

                                       <?php } ?>

                                    <?php } ?>

                                 </tbody>

                              </table>

                           </div>
                        </div>
                     </div>
                     <div class="col-sm-8">
                        <div class="card-box">
                           <div class="row">
                              <form method="post" class="form-horizontal" role="form">
                                 <div class="col-md-12">
                                    <div class="row">
                                       <div class="col-md-12">
                                          <div class="form-group">
                                             <label for="state_id">Select State<span class="text-danger">*</span></label>
                                             <select name="state_id" class="form-control select2" id="state_id">
                                                <?php if(isset($states)){ ?>
                                                   <?php foreach($states as $rs){ ?>

                                                      <option <?php if(isset($edit_city['state_id']) && $edit_city['state_id'] == $rs['state_id']){ echo "selected";  } ?> value="<?php echo $rs['state_id']; ?>"><?php echo $rs['state_name']; ?></option>

                                                   <?php } ?>
                                                <?php } ?>
                                             </select>
                                          </div>
                                       </div>     
                                      
                                    </div>

                                    <div class="row">
                                       <div class="col-md-12">
                                          <div class="form-group">
                                             <label for="city_name">City Name<span class="text-danger">*</span></label>
                                             <input type="text" name="city_name" parsley-trigger="change" class="form-control" id="city_name" value="<?php if(isset($edit_city['city_name'])){ echo $edit_city['city_name']; } ?>">
                                          </div>
                                       </div>     
                                      
                                    </div>
                                    <div class="row">
                                       <div class="col-md-12" align="right">
                                          

                                          <?php if(isset($edit_city)){ ?>                                             
                                                <button type="submit" name="update_city" class="btn btn-danger btn-bordered waves-effect w-md waves-light m-b-5">Update</button>
                                            <?php }else{ ?>
                                                <button type="submit" name="submit2" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Save</button>
                                            <?php } ?>
                                       
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-12 p-t-30">
                                       <?php if(isset($success2)){ ?>
                                          <div class="alert alert-success"><?php echo $success2; ?></div>
                                       <?php }else if(isset($warning2)){ ?>
                                          <div class="alert alert-warning"><?php echo $warning2; ?></div>
                                       <?php }else if(isset($error2)){ ?>
                                          <div class="alert alert-danger"><?php echo $error2; ?></div>
                                       <?php } ?>
                                    </div>
                              </form>
                           </div>

                           <div class="row">
                              
                              <table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                 
                                 <thead>
                                    <th>State</th>
                                    <th>City</th>
                                    <th class="text-right">Actions</th>
                                 </thead>

                                 <tbody>
                                    
                                    <?php if(isset($cities) && count($cities) > 0){ ?>

                                       <?php foreach($cities as $rs){ ?>

                                       <tr>
                                          <td width="" >
                                          <?php 
                                             $state_name = getOne('tbl_state','state_id',$rs['state_id']);
                                             echo $state_name['state_name']; 
                                          ?></td>
                                          <td width="" ><?php echo $rs['city_name']; ?></td>
                                          <td width="20%" class="text-right" >
                                             <a href="add_state.php?edit_city_id=<?php echo $rs['city_id']; ?>"><i class="fa fa-pencil"></i></a>
                                             <a href="add_state.php?delete_city_id=<?php echo $rs['city_id']; ?>" onclick=" return confirm('Are you sure ?'); "><i class="fa fa-trash"></i></a>
                                          </td>
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