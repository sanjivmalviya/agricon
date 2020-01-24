 <?php 

    require_once('../../functions.php'); 
    
    $sidebar_modules = getAllByOrder('tbl_modules','module_order','ASC');
    $sidebar_menus = getAllByOrder('tbl_menus','menu_order','ASC');

    $hide_menus = array('Edit','edit','Delete','delete');

 ?>
 <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <ul>
                           <li class="menu-title" align="center">SUPER ADMIN</li>

                            <li>
                                <a href="../../modules/owner/dashboard.php" class="waves-effect"><i class="ti-dashboard"></i><span> Dashboard </span> </a>
                            </li>

                            <li>
                                <a href="../../modules/owner/owner.php" class="waves-effect"><i class="ti-user"></i><span> My Profile </span> </a>
                            </li>

                            <!-- ONLY FOR DEVELOPER :START -->

                             <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-layout-grid2"></i><span> Modules </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="../../modules/menus/add.php"> Add New Module </a></li>                               
                                    <li><a href="../../modules/menus/view.php"> View All Modules </a></li>
                                </ul>
                            </li>
                            
                            <!-- ONLY FOR DEVELOPER : ENDS -->

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-settings"></i><span> Manage Roles </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="../../modules/admins/add_state.php"> Add/View State </a></li>                               
                                    <li><a href="../../modules/admins/add.php"> Add New Admin </a></li>
                                    <li><a href="../../modules/admins/view.php"> View All Admins </a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-settings"></i><span> Order / Invoices </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="../../modules/owner/orders.php"> Orders </a></li>
                                    <li><a href="../../modules/owner/invoices.php"> Invoices </a></li>
                                </ul>
                            </li>


                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-settings"></i><span> Reports </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="../../modules/owner/sales_by_category.php"> Sales by Category </a></li>
                                    <li><a href="../../modules/owner/sales_by_employee.php"> Sales by Employee </a></li>                               
                                </ul>
                            </li>

                       <!--      <?php if(isset($sidebar_modules) && count($sidebar_modules) > 0){ ?>

                                <?php foreach($sidebar_modules as $rs){ ?>

                                     <li class="has_sub">
                                        <a href="javascript:void(0);" class="waves-effect"><i class="ti-layout-grid2"></i><span> <?php echo ucwords($rs['module_name']); ?> </span> <span class="menu-arrow"></span></a>
                                        <ul class="list-unstyled">
                                           <?php 

                                            $sidebar_menus = getWhere('tbl_menus','module_id',$rs['module_id']);
                                            $sidebar_module_name = $rs['module_name'];

                                            if(isset($sidebar_menus) && count($sidebar_menus) > 0){ 

                                                foreach($sidebar_menus as $rs){ 

                                                    if(!in_array($rs['menu_name'], $hide_menus)){

                                                    ?>
                                                        <li><a href="../../modules/<?php echo $sidebar_module_name; ?>/<?php echo $rs['menu_link']; ?>"> <?php echo ucwords($rs['menu_name']); ?> </a></li>
                                                    
                                                    <?php
                                                }

                                                }
                                            }

                                           ?>
                                        </ul>
                                    </li>

                                <?php } ?>

                            <?php } ?> 
 -->
                        </ul>
                    </div>
                    <!-- Sidebar -->
                    <div class="clearfix"></div>

                   

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->
