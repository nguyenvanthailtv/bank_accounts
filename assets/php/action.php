<?php
    if(!empty($_SESSION['login_roles_id']) && !empty($_SESSION['login_roles']) && !empty($_SESSION['login_username'])){
        
        $login_roles = $_SESSION['login_roles'];
        $login_username = $_SESSION['login_username'];
        $login_roles_id = $_SESSION['login_roles_id'];
        
        $permission_arr = getdata("select permission_name from roles_permissions where roles_id = '".$login_roles_id."'");
        foreach($permission_arr as $permission){
            if(in_array("create", $permission)){
                $isCreate = true;
            }

            if(in_array("update", $permission)){
                $isUpdate = true;
            }

            if(in_array("delete", $permission)){
                $isDelete = true;
            }
        }
    }

?>