<?php
    
    require_once('../../functions.php');

    $user_types = getAll('tbl_user_types');

    if(isset($_GET['admin'])){

        $admin = getOne('tbl_admins','admin_id',$_GET['admin']);
        
        session_destroy();
        session_start();

        $_SESSION['agricon_credentials'] = array(
            'user_type' => 2,
            'user_id' => $admin['admin_id'],
            'user_name' => $admin['admin_name'],
            'created_at' => $admin['created_at'],
            'access_call' => 1
        );

        header('location:../login/dashboard.php');
        

    }

    if(isset($_POST['submit'])){

     // POST DATA
     $user_type = $_POST['user_type'];
     $username = $_POST['username'];
     $password = $_POST['password'];   
 
     $form_data = array(
       'user_type' => $user_type,
       'username' => $username,
       'password' => $password
     );

     if($user_type == 1){
        // super admin

        $check = "SELECT * FROM tbl_super_admin WHERE username = '$username' AND password = '$password' ";

        if(getRaw($check)){

            $session_data = getOne('tbl_super_admin','username',$username);
            
            $_SESSION['agricon_credentials'] = array(
                'user_type' => $user_type,
                'user_id' => $session_data['super_admin_id'],
                'user_name' => $username,
                'created_at' => $session_data['created_at'],
            );
            if($user_type == 1){
              header('location:../owner/dashboard.php');
            }else{
              header('location:../login/dashboard.php');
            }

        }else{
            
            $error = "Invalid Username or Password";
            unset($_SESSION['agricon_credentials']);

        }

     }else if($user_type == 2){
        // admin

        $check = "SELECT * FROM tbl_admins WHERE admin_email = '$username' AND admin_password = '$password' ";
        
        if(getRaw($check)){

            $session_data = getOne('tbl_admins','admin_email',$username);
            
            $_SESSION['agricon_credentials'] = array(
                'user_type' => $user_type,
                'user_id' => $session_data['admin_id'],
                'user_name' => $username,
                'created_at' => $session_data['created_at']
            );
            header('location:../login/dashboard.php');

        }else{
            
            $error = "Invalid Username or Password";
            unset($_SESSION['agricon_credentials']);

        }

     }else if($user_type == 3){
        // godown

        $check = "SELECT * FROM tbl_godown WHERE godown_email = '$username' AND godown_password = '$password' ";
        
        if(getRaw($check)){

            $session_data = getOne('tbl_godown','godown_email',$username);
            
            $_SESSION['agricon_credentials'] = array(
                'user_type' => $user_type,
                'user_id' => $session_data['godown_id'],
                'user_name' => $username,
                'created_at' => $session_data['created_at']
            );
            header('location:../login/dashboard.php');

        }else{
            
            $error = "Invalid Username or Password";
            unset($_SESSION['agricon_credentials']);

        }

     }

    }


?>

<!DOCTYPE html>
<html>
<?php require_once('../../include/headerscript.php'); ?>

<body class="" style="background: url(../../assets/images/loginbanner.jpg) no-repeat center center  !important;">
       
       <!-- HOME -->
        <section>
            <div class="container-alt">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page p-t-30">

                            <div class="m-t-40 account-pages" style="background: #0098db !important;">
                                <div class="text-center">
                                    <img src="../../assets/images/logo.jpg" style="height: 127px;width: 100%;" alt="">
                                </div>
                                <div class="account-content">
                                    <form class="form-horizontal" method="post">

                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <select class="form-control select2" name="user_type">

                                                    <?php if(isset($user_types) && count($user_types) > 0){ ?>

                                                        <?php foreach($user_types as $rs){ ?>

                                                           <option value="<?php echo $rs['user_type_id']; ?>"><?php echo $rs['user_type']; ?></option>

                                                        <?php } ?>

                                                    <?php } ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="text" placeholder="Username" name="username">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="password"  placeholder="Password" name="password">
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

                                        <div class="form-group account-btn text-center m-t-10">
                                            <div class="col-xs-12">
                                               <input type="submit" name="submit" value="Log In" class="btn w-md btn-bordered btn-danger waves-effect waves-light">
                                            </div>
                                        </div>

                                    </form>

                                    <div class="clearfix"></div>

                                </div>
                            </div>
                           
                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
          </section>
          <!-- END HOME -->

    </body>
</html>