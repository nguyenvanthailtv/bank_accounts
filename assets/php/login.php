<?php
    if(isset($_POST['submit'])){
        $character_err =['\'','"','`','='];
        $email = trim(str_replace($character_err,'',$_POST['email']));
        $password = trim(str_replace($character_err,'',$_POST['password']));

        $_SESSION['login_email'] = $email;
        $_SESSION['login_password'] = $password;
        $result = getdata("SELECT username,roles_name,users.roles_id FROM users INNER JOIN roles on roles.roles_id = users.roles_id WHERE email ='".$email."'");
        if(!empty($result)){
            $_SESSION['login_roles'] = $result[0]['roles_name'];
            $_SESSION['login_roles_id'] = $result[0]['roles_id'];
            $_SESSION['login_username'] = $result[0]['username'];
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
        
            if(count($result) > 0){
                header("location: main.php");
            }
            else{
                $login_err['login_failed']['failed'] ='Login failed. Please check again!';
            }
        }
    }

?>