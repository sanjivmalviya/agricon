<?php

   require_once('../../functions.php');

 $login_id = $_SESSION['agricon_credentials']['user_id'];

 if($_SESSION['agricon_credentials']['user_type'] == 1){   
   $godowns = getAll('tbl_godown');
 }else{
   $godowns = getWhere('tbl_godown','added_by',$login_id);
 }

$table_name = 'tbl_godown';
$field_name = 'godown_id';

if(isset($_GET['delete_id'])){
      
if(delete($table_name,$field_name,$_GET['delete_id'])){
   $success = "Record Deleted Successfully";
   header('location:view.php');
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
                     <div class="col-xs-12">
                        <div class="page-title-box">
                           <h4 class="page-title">Godowns</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">

                                 <table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                    
                                    <thead>
                                       <th>Sr.</th>
                                       <?php if($_SESSION['agricon_credentials']['user_type'] == 1){ ?>
                                       <th>Added By</th>
                                       <?php } ?>
                                       <th>Person Name</th>
                                       <th>Person Mobile</th>
                                       <th>Person Designation</th>
                                       <th>Godown Name</th>
                                       <th>Godown Email</th>
                                       <th>Godown Address</th>
                                       <th>Godown City</th>
                                       <th>Godown State</th>
                                       <th class="text-right">Actions</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($godowns) && count($godowns) > 0){ ?>

                                          <?php $i=1; foreach($godowns as $rs){ ?>

                                          <tr>
                                             <td><?php echo $i++; ?></td>
                                             <?php if($_SESSION['agricon_credentials']['user_type'] == 1){ ?>
                                             <td><?php 
                                              $added_by = getOne('tbl_admins','admin_id',$rs['added_by']); 
                                              echo $added_by['admin_name'];
                                             ?></td>
                                             <?php } ?>
                                             <td><?php echo $rs['godown_person_name']; ?></td>                                    
                                             <td><?php echo $rs['godown_person_mobile']; ?></td>                                    
                                             <td><?php echo $rs['godown_person_designation']; ?></td>                                    
                                             <td><?php echo $rs['godown_name']; ?></td>
                                             <td><?php echo $rs['godown_email']; ?></td>                                    
                                             <td><?php echo $rs['godown_address']; ?></td>                                    
                                             <td>
                                                <?php 
                                                 $godown_city = getOne('tbl_city','city_id',$rs['godown_city']);
                                                 echo $godown_city =  $godown_city['city_name']; 
                                                ?>
                                             </td>
                                             <td><?php 
                                              $godown_state = getOne('tbl_state','state_id',$rs['godown_state']); 
                                              echo $godown_state = $godown_state['state_name'];
                                             ?></td>
                                             
                                             <td class="text-center">
                                                <a href="add.php?edit_id=<?php echo $rs['godown_id']; ?>"><i class="fa fa-pencil"></i></a>
                                                <a href="view.php?delete_id=<?php echo $rs['godown_id']; ?>" onclick=" return confirm('Are you sure ?'); "><i class="fa fa-trash"></i></a>
                                             </td>
                                          </tr>
                                          <?php } ?>

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
         
         $(function(){

            $('.newModuleBlock').hide();

         });
         $('#menu_module').on('change', function(){

            var val = $(this).val();
            if(val == 0){
               $('.newModuleBlock').show();
            }else{
               $('.newModuleBlock').hide();               
            }

         });

      </script>

   </body>
</html>