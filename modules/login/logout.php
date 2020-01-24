<?php
    
    require_once('../../functions.php');
    
    unset($_SESSION['agricon_credentials']);
    header('location:../../modules/login/index.php');

?>