<?php

    require_once('../../functions.php');

    $login_id = $_SESSION['agricon_credentials']['user_id'];

    $where = array(
        'notification_receiver_user_type' => '3',
        'notification_receiver_user_id' => $login_id,
        'notification_status' => '0',
    );

    $notifications = selectWhereMultiple('tbl_notifications',$where,'DESC');

    if(isset($notifications)){
        $notification_count = count($notifications);
    }
?>
<!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="index.html" class="logo"><span>E<span>rp</span></span><i class="mdi mdi-layers"></i></a>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">

                        <!-- Navbar-left -->
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <button class="button-menu-mobile open-left waves-effect">
                                    <i class="mdi mdi-menu"></i>
                                </button>
                            </li>
                         
                        </ul>

                        <!-- Right(Notification) -->
                        <ul class="nav navbar-nav navbar-right">

                            <li class="dropdown user-box">
                                <a data-receiver-user-type="3" data-receiver-user-id="<?php echo $login_id; ?>" data-sender class="dropdown-toggle waves-effect user-link notification_bell" data-toggle="dropdown" aria-expanded="true">
                                    <?php if(isset($notification_count) && $notification_count > 0){ ?>
                                    <span style="position: absolute;"><span class="badge badge-notify notification_badge"><?php echo $notification_count; ?></span></span>  <i style="font-size: 20px;padding-top: 10px;" class="fa fa-bell"></i>                 
                                    <?php } ?>
                                </a>
                                
                                <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list" style="min-width: 340px;padding-bottom: 0px;">
                                    <?php if(isset($notifications)){ ?>
                                        <?php foreach($notifications as $rs){ ?>
                                        <div class="col-md-12" style="border-bottom: 1px solid rgba(0,0,0,0.2);padding: 10px;line-height: 20px;"><?php echo $rs['notification_description']; ?>
                                            <br><i><small><?php echo time_ago($rs['created_at']); ?></small></i>
                                        </div>
                                        <?php } ?>                                   
                                    <?php } ?>                                   
                                </ul>
                            </li>
                            
                            <li class="dropdown user-box">
                                <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                                    <img src="assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle user-img">
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                                    <li>
                                        <h5>Hi, <?php echo $_SESSION["agricon_credentials"]['user_name']; ?></h5>
                                    </li>                                   
                                    <li><a href="../../modules/login/logout.php"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                                </ul>
                            </li>

                        </ul> <!-- end navbar-right -->

                    </div><!-- end container -->
                </div><!-- end navbar -->
            </div>
            <!-- Top Bar End -->
