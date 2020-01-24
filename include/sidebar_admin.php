 <?php 

    require_once('../../functions.php'); 

    $this_admin_roles = getWhere('tbl_user_roles','admin_id',$_SESSION["agricon_credentials"]['user_id']);

    if(isset($this_admin_roles) && count($this_admin_roles) > 0){

        foreach ($this_admin_roles as $rs) {
            $admin_menus[] = $rs['menu_id'];    
        }

    }

    if(isset($admin_menus) && count($admin_menus) > 0){

        $sidebar_menus = "SELECT * FROM tbl_menus WHERE menu_id IN (".implode(",", $admin_menus).") ";
        $sidebar_menus = getRaw($sidebar_menus);

        foreach($sidebar_menus as $rs){

            $sidebar_modules[] = $rs['module_id'];
            
        }

        $sidebar_modules = array_unique($sidebar_modules);

    }

    $hide_menus = array('Edit','edit','Delete','delete');

 ?>
 <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft" style="overflow-y: scroll;">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu" >
                        <ul>
                           <li class="menu-title" align="center">ADMIN</li>

                            <li>
                                <a href="../../modules/login/dashboard.php" class="waves-effect"><i class="ti-dashboard"></i><span> Dashboard </span> </a>
                            </li>


                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-harddrive"></i><span> Masters </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="../../modules/masters/packing.php">Packing</a></li>
                                    <li><a href="../../modules/masters/unit.php">Unit</a></li>
                                </ul>
                            </li>

                             <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-target"></i><span> Target Analytics </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="../../modules/target/add.php">Create New Target</a></li>
                                    <li><a href="../../modules/target/ranking.php">Score Board</a></li>
                                    <li><a href="../../modules/target/view.php">View</a></li>
                                </ul>
                            </li>


                            <?php if(isset($sidebar_modules) && count($sidebar_modules) > 0){ ?>

                                <?php foreach($sidebar_modules as $sidebar_module_id){ 

                                    $sidebar_module_name1 = getOne('tbl_modules','module_id',$sidebar_module_id);
                                    $sidebar_module_name = $sidebar_module_name1['module_name'];

                                    ?>

                                     <li class="has_sub">
                                        <a href="javascript:void(0);" class="waves-effect"><i class="<?php echo $sidebar_module_name1['module_class']; ?>"></i><span> <?php echo ucwords($sidebar_module_name); ?> </span> <span class="menu-arrow"></span></a>
                                        <ul class="list-unstyled">
                                           <?php 


                                            if(isset($sidebar_menus) && count($sidebar_menus) > 0){ 

                                                foreach($sidebar_menus as $rs){ 
        
                                                    if($sidebar_module_id == $rs['module_id'] && !in_array($rs['menu_name'], $hide_menus)){

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

                        </ul>
                    </div>
                    <!-- Sidebar -->
                    <div class="clearfix"></div>

                   

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->
