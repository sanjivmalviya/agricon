<?php

   require_once('../../functions.php');

 $login_id = $_SESSION['agricon_credentials']['user_id'];
 $categories = getAll('tbl_category');
 $sub_categories = getAll('tbl_sub_category');

 function getCategoryLevel($sub_category_id){

      $get = getOne('tbl_sub_category','sub_category_id',$sub_category_id);
      $sub_category_level = $get['sub_category_level'];
      $parent_category_id = $get['parent_category_id'];
      $category_level[] = $get['sub_category_name'];

      if($sub_category_level == 3){

          
          $getL3 = "SELECT * FROM tbl_sub_category WHERE  sub_category_id = '$parent_category_id' AND sub_category_level != '1' ";
          $getL3 = getRaw($getL3);
          $category_level[] = $getL3[0]['sub_category_name'];
          $parent_category_id = $getL3[0]['parent_category_id'];

          $getL2 = "SELECT * FROM tbl_sub_category WHERE  sub_category_id = '$parent_category_id' ";
          $getL2 = getRaw($getL2);
          $category_level[] = $getL2[0]['sub_category_name'];
          $parent_category_id = $getL2[0]['parent_category_id'];

          $getL1 = "SELECT * FROM tbl_category WHERE category_id = '$parent_category_id' ";
          $getL1 = getRaw($getL1);
          $category_level[] = $getL1[0]['category_name'];
      
      }else if($sub_category_level == 2){
          
          $getL2 = "SELECT * FROM tbl_sub_category WHERE  sub_category_id = '$parent_category_id' ";
          $getL2 = getRaw($getL2);
          $category_level[] = $getL2[0]['sub_category_name'];
          $parent_category_id = $getL2[0]['parent_category_id'];

          $getL1 = "SELECT * FROM tbl_category WHERE category_id = '$parent_category_id' ";
          $getL1 = getRaw($getL1);
          $category_level[] = $getL1[0]['category_name'];
      
      }else if($sub_category_level == 1){
       
          $getL1 = "SELECT * FROM tbl_category WHERE category_id = '$parent_category_id' ";
          $getL1 = getRaw($getL1);
          $category_level[] = $getL1[0]['category_name'];
      
      }

      return $category_level;

 }

 $table_name = 'tbl_sub_category';
 $field_name = 'sub_category_id';

 if(isset($_GET['delete_id'])){
         
   if(delete($table_name,$field_name,$_GET['delete_id'])){
      $success = "Record Deleted Successfully";
   }else{
      $error = "Failed to Delete Record";
   }

 }

 if(isset($_GET['delete_category'])){

   if(delete('tbl_category','category_id',$_GET['delete_category'])){
      delete($table_name,'parent_category_id',$_GET['delete_category']);
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
                     <div class="col-xs-12">
                        <div class="page-title-box">
                           <h4 class="page-title">Categories</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                        <div class="card-box">
                           <div class="row">

                            <h5>Categories</h5>

                                 <table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                    
                                    <thead>
                                       <th>Sr.</th>
                                       <th>Category</th>
                                       <th class="text-right">Actions</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($categories) && count($categories) > 0){ ?>

                                          <?php $i=1; foreach($categories as $rs){  ?>

                                          <tr>
                                             <td><?php echo $i++; ?></td>
                                             <td><?php echo $rs['category_name']; ?></td>
                                             <td class="text-center">
                                                <!-- <a href="add.php?edit_id=<?php echo $rs['sub_category_id']; ?>"><i class="fa fa-pencil"></i></a> -->
                                                <a href="view.php?delete_category=<?php echo $rs['category_id']; ?>" onclick=" return confirm('Are you sure ?'); "><i class="fa fa-trash"></i></a>
                                             </td>
                                          </tr>
                                          <?php } ?>

                                       <?php } ?>

                                    </tbody>

                                 </table>


                      
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="card-box">
                           <div class="row">

                             <h5>Sub Categories</h5>

                                 <table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                    
                                    <thead>
                                       <th>Sr.</th>
                                       <th>Category</th>
                                       <th>Level</th>
                                       <th class="text-right">Actions</th>
                                    </thead>

                                    <tbody>
                                       
                                       <?php if(isset($sub_categories) && count($sub_categories) > 0){ ?>

                                          <?php $i=1; foreach($sub_categories as $rs){  ?>

                                          <tr>
                                             <td><?php echo $i++; ?></td>
                                             <td><?php echo $rs['sub_category_name']; ?></td>
                                             <td><?php 
                                             
                                                   $data = getCategoryLevel($rs['sub_category_id']);
                                                   $j = 0;
                                                   $len = count($data);
                                                   foreach($data as $rs1){

                                                      echo "<button type='button' class='btn btn-xs btn-primary'>".$rs1." </button> ";
                                                      if ($j != $len - 1) {
                                                           echo " <i class='fa fa-arrow-right'></i> ";
                                                      }
                                                      $j++;

                                                   }

                                             ?></td>
                                             <td class="text-center">
                                                <!-- <a href="add.php?edit_id=<?php echo $rs['sub_category_id']; ?>"><i class="fa fa-pencil"></i></a> -->
                                                <a href="view.php?delete_id=<?php echo $rs['sub_category_id']; ?>" onclick=" return confirm('Are you sure ?'); "><i class="fa fa-trash"></i></a>
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