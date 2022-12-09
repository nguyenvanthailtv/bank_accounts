<?php 

    if(isset($_POST['create-user'])){

        $create_user = true;
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $phone = trim($_POST['phone']);
        $roles = trim($_POST['roles']);
        $country = trim($_POST['country']);
        $email =trim($_POST['email']);

        $test_email_user = getdata("select * from users where email ='".$email."'");
        require_once('./assets/php/user/validate.php');

        try{
            if(empty($user_err)){
                $password_hash = hash_data($password);
                $result_roles = getdata("select * from roles where roles_name = '".$roles."'");
                $roles = $result_roles[0]['roles_id'];
                $result_country = getdata("SELECT * FROM `country` WHERE country_name='".$country."'");
                $country = $result_country[0]['abbreviation'];
                insertUser($username,$email,$password_hash,$phone,$roles,$country);    
                header("location: user.php");
            }
        }
        catch(Exception $e){
            echo "Error: ".$e->getMessage();
            echo "<pre>";
        }
    }
?>