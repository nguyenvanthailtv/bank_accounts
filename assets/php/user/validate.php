<?php 
    if(empty($username)){
        $user_err['username_err']['required'] = 'Please enter username!';
    }
    if(empty($password)){
        $user_err['password_err']['required'] = 'Please enter password!';
    }elseif(strlen($password) < 6){
        $user_err['password_err']['min_length'] = 'Password must be more than 6 characters!!';
    }

    if(empty($phone)){
        $user_err['phone_err']['required'] = 'Please enter phone!';
    }
    if(empty($roles)){
        $user_err['roles_err']['required'] = 'Please enter roles!';
    }
    if(empty($country)){
        $user_err['country_err']['required'] = 'Please enter country!';
    }
    if(empty($email)){
        $user_err['email_err']['required'] = 'Please enter email!';
    }elseif(!empty($test_email_user) && count($test_email_user) != 0){
        $user_err['email_err']['already_exist'] = 'Email already in use!';
    }
?>