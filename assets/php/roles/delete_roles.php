<?php 
    if(!empty($_GET['dl_roles_number'])){
        $roles_id = $_GET['dl_roles_number'];

        try{
            deleteRoles_Permissions($roles_id);
            deletetRoles($roles_id);
            header('location: roles.php');
        }
        catch(Exception $e){
            echo "Message: An error occurred. Please try again later! " ;
            echo "<pre>";
        }

    }


?>