<?php 
    if(isset($_GET['ud_roles_number'])){
        $update_roles = true;
        $roles_id = $_GET['ud_roles_number'];
        $sql = "SELECT * from roles where roles_id = '".$roles_id."'";
        $update_arr = getdata($sql);

        $listPermissions = getdata("select permission_id from roles_permissions where roles_id = '".$roles_id."'");

        foreach($listPermissions as $permission){
            $arr_per[]= $permission['permission_id'];
        }
        // echo '<pre>';
        // print_r($arr_per);
    }

    if(isset($_POST['close'])){
        header("location: roles.php");
    }

    if(isset($_POST['update'])){
        
        $roles_id = $_GET['ud_roles_number'];
        $roles_name = $_POST['name'];
        $roles_description = $_POST['description'];
        // require_once('./assets/php/account/validate.php');
        try{
            if(empty($account_err)){
                updateRoles($roles_id,$roles_name,$roles_description);
                echo $roles_id;
                deleteRoles_Permissions($roles_id);
                $all_permissions = $_POST['data'];
                foreach($all_permissions as $per){
                    if(filter_var($per,FILTER_VALIDATE_INT)){
                        insertRoles_Permissions2($roles_id,$per);
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