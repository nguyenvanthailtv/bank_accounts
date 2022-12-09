<?php
    if(isset($_POST['create'])){
        $create_account =true;
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $age = trim($_POST['age']);
        $gender_input = trim($_POST['gender']);
        $gender = (trim($_POST['gender'] == 'Male'))? 'M':'F';
        $email = trim($_POST['email']);
        $balance = trim($_POST['balance']);
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
        $state = trim($_POST['state']);
        $employer = trim($_POST['employer']);
        
        $test_email = getdata("select * from accounts where email='".$email."'");
        require_once('./assets/php/account/validate.php');

        try{
            if(empty($account_err)){
                $returl = getdata("SELECT * FROM `states` WHERE name ='".$state."'");
                $state = $returl[0]['abbreviation'];
                insertAccounts($firstname,$lastname,$age,$gender,$email,$balance,$address,$city,$state,$employer);
                
                header('location: main.php');
            }
        }
        catch(Exception $e){
            echo "Message: An error occurred. Please try again later! " ;
            echo "<pre>";
        }
    }

?>