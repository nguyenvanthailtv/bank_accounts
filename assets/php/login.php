<?php
    if(isset($_POST['submit'])){
        $character_err =['\'','"','`','='];
        $email = trim(str_replace($character_err,'',$_POST['email']));
        $password = trim(str_replace($character_err,'',$_POST['password']));

        $_SESSION['login_email'] = $email;
        $_SESSION['login_password'] = $password;
        $result = getdata("select username,roles_name from users inner join roles on roles.roles_id = users.roles_id where email='".$email."'");
        if(!empty($result)){
            $_SESSION['login_username'] = $result[0]['username'];
            $_SESSION['login_roles'] = $result[0]['roles_name'];
        }
        $result_permissions = getdata("select permission_name from roles,users,roles_permissions,permissions where roles.roles_id = users.roles_id and roles.roles_id = roles_permissions.roles_id and roles_permissions.permission_id = permissions.permission_id and users.email='".$email."'");
        if(!empty($result_permissions)){
            $_SESSION['login_permissions'] =  $result_permissions;
        }
        if(empty($email)){
            $login_err['email_err']['required'] = 'Please enter Email!';
        }
        elseif(strlen($email) < 12){
            $login_err['email_err']['min_length'] = 'Email must be more than 12 characters!';
        }

        if(empty($password)){
            $login_err['password_err']['required'] = 'Please enter Password!';
        }
        elseif(strlen($password) < 6){
            $login_err['password_err']['min_length'] = 'Password must be more than 6 characters!';
        }

        $password_hash = hash_data($password);

        if(empty($login_err)){
            $result = getdata("select * from users where email ='".$email."' and password = '".$password_hash."'");
            // echo '<pre>';
            // print_r($_SESSION['login_permissions']);
            if(count($result) > 0){
                foreach($result_permissions as $permission){
                    if(in_array("view_account", $permission)){
                        header("location: main.php");
                        exit;
                    }
                    elseif(in_array("view_user", $permission)){
                        header("location: user.php");
                        exit;
                    }
                    elseif(in_array("view_roles", $permission)){
                        header("location: roles.php");
                        exit;
                    }
                }
                
            }
            else{
                $login_err['login_failed']['failed'] ='Login failed. Please check again!';
            }
        }
    }

?>