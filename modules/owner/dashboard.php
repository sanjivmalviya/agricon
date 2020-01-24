
<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['agricon_credentials']['user_id'];
   $admins = getAll('tbl_admins');

   if(isset($_GET['superadmin']) && $_GET['superadmin'] == 1){

        $super_admin = getOne('tbl_super_admin','super_admin_id',1);
        session_destroy();
        session_start();

        $_SESSION['agricon_credentials'] = array(
            'user_type' => 2,
            'user_id' => $super_admin['super_admin_id'],
            'user_name' => $super_admin['username'],
            'created_at' => $super_admin['created_at'],
        );

        header('location:../owner/dashboard.php');        

   }

   // total customers
   $total_employees = getCount('tbl_employee');
   $total_customers= getCount('tbl_customer');
   $total_orders= getCount('tbl_orders');

   $total_sales = "SELECT COALESCE(SUM(employee_order_amount),0) as target_achieved FROM tbl_employee_target_detail target_detail INNER JOIN tbl_employee sales ON target_detail.employee_id = sales.employee_id ";
   $total_sales = getRaw($total_sales);
   $total_sales = $total_sales[0]['target_achieved'];

?>

<!DOCTYPE html>
<html>
<head>
   <style>
      /* FontAwesome for working BootSnippet :> */

@import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
#team {
    background: #eee !important;
}

.btn-primary:hover,
.btn-primary:focus {
    background-color: #108d6f;
    border-color: #108d6f;
    box-shadow: none;
    outline: none;
}

.btn-primary {
    color: #fff;
    background-color: #007b5e;
    border-color: #007b5e;
}

section {
    padding: 20px 0;
}

section .section-title {
    text-align: center;
    color: #007b5e;
    margin-bottom: 50px;
    text-transform: uppercase;
}

#team .card {
    border: none;
    background: #ffffff;
}

.image-flip:hover .backside,
.image-flip.hover .backside {
    -webkit-transform: rotateY(0deg);
    -moz-transform: rotateY(0deg);
    -o-transform: rotateY(0deg);
    -ms-transform: rotateY(0deg);
    transform: rotateY(0deg);
    border-radius: .25rem;
    width: 100%;
}

.image-flip:hover .frontside,
.image-flip.hover .frontside {
    -webkit-transform: rotateY(180deg);
    -moz-transform: rotateY(180deg);
    -o-transform: rotateY(180deg);
    transform: rotateY(180deg);
}

.mainflip {
    -webkit-transition: 1s;
    -webkit-transform-style: preserve-3d;
    -ms-transition: 1s;
    -moz-transition: 1s;
    -moz-transform: perspective(1000px);
    -moz-transform-style: preserve-3d;
    -ms-transform-style: preserve-3d;
    transition: 1s;
    transform-style: preserve-3d;
    position: relative;
}

.frontside {
    position: relative;
    -webkit-transform: rotateY(0deg);
    -ms-transform: rotateY(0deg);
    z-index: 2;
    margin-bottom: 30px;
}

.backside {
    position: absolute;
    top: 0;
    left: 0;
    background: white;
    -webkit-transform: rotateY(-180deg);
    -moz-transform: rotateY(-180deg);
    -o-transform: rotateY(-180deg);
    -ms-transform: rotateY(-180deg);
    transform: rotateY(-180deg);
    -webkit-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
    -moz-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
    box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
    width: 100%;
}

.frontside,
.backside {
    -webkit-backface-visibility: hidden;
    -moz-backface-visibility: hidden;
    -ms-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transition: 1s;
    -webkit-transform-style: preserve-3d;
    -moz-transition: 1s;
    -moz-transform-style: preserve-3d;
    -o-transition: 1s;
    -o-transform-style: preserve-3d;
    -ms-transition: 1s;
    -ms-transform-style: preserve-3d;
    transition: 1s;
    transform-style: preserve-3d;
}

.frontside .card,
.backside .card {
    min-height: 312px;
    padding: 10px;
    height: 360px;   
    border: 1px solid rgba(0,0,0,0.1) !important;
    box-shadow: 2px 4px #888888;
    border-radius: 5px;
}

.backside .card a {
    font-size: 18px;
    color: #007b5e !important;
}

.frontside .card .card-title,
.backside .card .card-title {
    /*color: #007b5e !important;*/
}

.frontside .card .card-body img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
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
            <div class="content" style="margin-top: 45px;">
            
               <section id="team" class="pb-5">
                   <div class="container">
                       <!-- <h5 class="section-title h1">OUR TEAM</h5> -->

                       <div class="row">
                          
                          <div class="col-md-12 col-xs-12 col-sm-12">
                             
                             <div style="width: 270px;min-height: 100px;height: 150px; margin-left: 10px;padding-top: 30px;" class="col-md-3 col-sm-12 col-xs-12 jumbotron bg-primary text-white">
                              <ul style="list-style-type:none;padding: 0;">
                                 <li class="text-center"><i style="font-size: 25px;" class="fa fa-user"></i></li>
                                 <li class="text-center"><h3 class="text-white"><?php echo $total_customers; ?></h3></li>
                                 <li class="text-center">CUSTOMERS</li>
                              </ul>
                             </div>
                             <div style="width: 270px;min-height: 100px;height: 150px; margin-left: 10px;padding-top: 30px;" class="col-md-3 jumbotron bg-primary text-white">
                              <ul style="list-style-type:none;padding: 0;">
                                 <li class="text-center"><i style="font-size: 25px;" class="fa fa-user"></i></li>
                                 <li class="text-center"><h3 class="text-white"><?php echo $total_employees; ?></h3></li>
                                 <li class="text-center">EmployeeS</li>
                              </ul>
                             </div>
                             <div style="width: 270px;min-height: 100px;height: 150px; margin-left: 10px;padding-top: 30px;" class="col-md-3 jumbotron bg-primary text-white">
                              <ul style="list-style-type:none;padding: 0;">
                                 <li class="text-center"><i style="font-size: 25px;" class="fa     fa-shopping-cart"></i></li>
                                 <li class="text-center"><h3 class="text-white"><?php echo $total_orders; ?></h3></li>
                                 <li class="text-center">ORDERS PLACED</li>
                              </ul>
                             </div>
                             <div style="width: 270px;min-height: 100px;height: 150px; margin-left: 10px;padding-top: 30px;" class="col-md-3 jumbotron bg-primary text-white">
                              <ul style="list-style-type:none;padding: 0;">
                                 <li class="text-center"><i style="font-size: 25px;" class="fa     fa-rupee"></i></li>
                                 <li class="text-center"><h3 class="text-white"><?php echo $total_sales; ?></h3></li>
                                 <li class="text-center">TOTAL SALES</li>
                              </ul>
                             </div>

                          </div>

                       </div>
                       <div class="row">
                           
                           <?php if(isset($admins)){ ?>
                              <?php foreach($admins as $rs){ ?>
                                 <div class="col-xs-12 col-sm-6 col-md-3">
                                     <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                                         <div class="mainflip">
                                             <div class="frontside">
                                                 <div class="card">
                                                     <div class="card-body text-center">
                                                         <p><img class=" img-fluid" src="../../<?php echo $rs['admin_profile']; ?>" alt="card image"></p>
                                                         <h4 class="card-title text-primary"><?php echo $rs['admin_name']; ?></h4>
                                                         <p class="card-text">
                                                            <ul class="list-group">
                                                              <li class="list-group-item">
                                                                 <?php 
                                                                 $condition = "added_by = '".$rs['admin_id']."' ";
                                                                 $total_employees = getCountWhere('tbl_employee',$condition);
                                                                 if($total_employees ==0){
                                                                  echo "<span class='text-danger'>No Employee Added</span>";
                                                                 }else{
                                                                  echo "Added <span class='text-primary'>".$total_employees."</span> Employees";
                                                                 }
                                                                 ?>
                                                              </li>
                                                              <li class="list-group-item">
                                                                 <?php 

                                                                  $condition = "added_by = '".$rs['admin_id']."' ";
                                                                  $total_customers = getCountWhere('tbl_customer',$condition)."</b>";
                                                                  if($total_customers ==0){
                                                                     echo "<span class='text-danger'>No Customers</span>";
                                                                    }else{
                                                                     echo "Added <span class='text-primary'>".$total_customers."</span> Customers";
                                                                    }
                                                                 ?>
                                                              </li>
                                                              <li class="list-group-item">
                                                                 <?php 

                                                                  $query = "SELECT COUNT(*) as total_orders FROM tbl_orders ord INNER JOIN tbl_employee sales ON ord.employee_id = sales.employee_id WHERE sales.added_by = '".$rs['admin_id']."' ";
                                                                  $total_orders = getRaw($query);
                                                                  $total_orders = $total_orders[0]['total_orders'];
                                                                  if($total_orders ==0){
                                                                  echo "<span class='text-danger'>No Order Placed Yet</span>";
                                                                 }else{
                                                                  echo "Placed <span class='text-primary'>".$total_orders."</span> Orders ";
                                                                 }
                                                                 ?>
                                                              </li>
                                                              <li class="list-group-item bg-primary">
                                                                 <?php 

                                                                  $query = "SELECT COALESCE(SUM(employee_order_amount),0) as target_achieved FROM tbl_employee_target_detail target_detail INNER JOIN tbl_employee sales ON target_detail.employee_id = sales.employee_id WHERE sales.added_by = '".$rs['admin_id']."' ";
                                                                  $target_achieved = getRaw($query);
                                                                  if($target_achieved[0]['target_achieved'] == 0){
                                                                     echo "<span class='text-white'><i class='fa fa-rupee'></i> ".number_format($target_achieved[0]['target_achieved'],2)." </span> of Sales";
                                                                  }else{
                                                                     echo "<span class='text-white'><i class='fa fa-rupee'></i> ".number_format($target_achieved[0]['target_achieved'],2)." </span> of Sales";
                                                                  }
                                                                 ?>
                                                              </li>
                                                            </ul>
                                                         </p>
                                                         <!-- <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a> -->
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="backside">
                                                 <div class="card">
                                                     <div class="card-body text-center mt-4">
                                                            
                                                            <a href="../../modules/login/index.php?admin=<?php echo $rs['admin_id']; ?>" style="color:white !important;margin-top: 140px;" class="btn btn-primary text-muted">Sign In as <?php echo $rs['admin_name']; ?></a>                                                         
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                           <?php } ?>
                        <?php } ?>
                          
                       </div>
                   </div>
               </section>
              
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