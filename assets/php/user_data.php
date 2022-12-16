<?php
    if(!empty($_SESSION['login_roles']) && !empty($_SESSION['login_username'])){

        $login_roles = $_SESSION['login_roles'];
        $login_username = $_SESSION['login_username'];
        foreach($_SESSION['login_permissions'] as $permission){
            $_SESSION['arr_permissions'][] =$permission['permission_name'];
        }
    }
?>