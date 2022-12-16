<?php
    if(isset($_POST['create'])){
        $create_roles =true;
        $roles_name = trim($_POST['name']);
        $roles_desc = trim($_POST['description']);

        try{
            if(empty($roles_err)){
                $all_permissions = $_POST['data'];
                insertRoles($roles_name,$roles_desc);
                foreach($all_permissions as $item){
                    if(filter_var($item,FILTER_VALIDATE_INT)){
                        insertRoles_Permissions($item);
                    }
                }
                header('location: roles.php');
            }
        }
        catch(Exception $e){
            echo "Message: An error occurred. Please try again later! " ;
            echo "<pre>";
        }
    }

?>