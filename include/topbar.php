 <?php 

    require_once('../../functions.php'); 

    if($_SESSION["agricon_credentials"]['user_type'] == '1'){

            require_once('topbar_super_admin.php');

    }else if($_SESSION["agricon_credentials"]['user_type'] == '2'){

            require_once('topbar_admin.php');

    }else if($_SESSION["agricon_credentials"]['user_type'] == '3'){

            require_once('topbar_godown.php');

    } 

?>