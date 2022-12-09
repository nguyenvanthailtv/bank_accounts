<?php 

    if(isset($_GET['ud_user_number'])){
        $update_user =true;
        $user_id = $_GET['ud_user_number'];
        $sql = "SELECT  username, email, phone, password, roles_name, country_name FROM users, roles, country where roles.roles_id = users.roles_id and country.abbreviation = users.country and id ='".$user_id."'";
        $update_user_arr = getdata($sql);

        if(!empty($update_user_arr)){
            $username = $update_user_arr[0]['username'];
            $email = $update_user_arr[0]['email'];
            $password = $update_user_arr[0]['password'];
            $phone = $update_user_arr[0]['phone'];
            $roles = $update_user_arr[0]['roles_name'];
            $country = $update_user_arr[0]['country_name'];
        }
    }

    if(isset($_POST['update-user'])){
        $id = $_GET['ud_user_number'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $roles = $_POST['roles'];
        $country = $_POST['country'];
        $email =$_POST['email'];


        try{
            $password_hash = hash_data($password);
            $result_roles = getdata("select * from roles where roles_name = '".$roles."'");
            $roles = $result_roles[0]['roles_id'];
            $result_country = getdata("SELECT * FROM `country` WHERE country_name='".$country."'");
            $country = $result_country[0]['abbreviation'];      
            updateUser($id,$username,$email,$password_hash,$phone,$roles,$country);
            header("location: user.php");
        }
        catch(Exception $e){
            echo "Message: An error occurred. Please try again later! " ;
            echo "<pre>";
        }
    }

    if(isset($_POST['close'])){
        header("location: user.php");
    }

?>