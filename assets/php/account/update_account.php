<?php 
    if(isset($_GET['ud_account_number'])){
        $update_account = true;
        $account_number = $_GET['ud_account_number'];

        $sql = "SELECT account_number,balance,firstname,lastname,age,gender,address,employer,email,city,states.name FROM `accounts` INNER JOIN states on states.abbreviation = accounts.state where account_number='$account_number'";
        $update_arr = getdata($sql);
        (($update_arr[0]['gender']) == 'M')? $gender_update ="Male":$gender_update="Female";
        $state = $update_arr[0]['name'];
    }

    if(isset($_POST['close'])){
        header("location: main.php");
    }

    if(isset($_POST['update'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $age = $_POST['age'];
        $gender = ($_POST['gender'] == 'Male')? 'M':'F';
        $gender_update = $_POST['gender'];
        $email = $_POST['email'];
        $balance = $_POST['balance'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $employer = $_POST['employer'];
        
        $account_number = $_GET['ud_account_number'];
        require_once('./assets/php/account/validate.php');

        try{
            if(empty($account_err)){
                $returl = getdata("SELECT * FROM `states` WHERE name ='".$state."'");
                $state = $returl[0]['abbreviation'];
                updateAccount($account_number,$firstname,$lastname,$age,$gender,$email,$balance,$address,$city,$state,$employer);
                header('location: main.php');
            }
        }
        catch(Exception $e){
            echo "Message: An error occurred. Please try again later! " ;
            echo "<pre>";
        }

    }
?>