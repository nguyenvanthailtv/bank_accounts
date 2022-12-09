<?php 
    if(!empty($_GET['dl_account_number'])){
        $account_number = $_GET['dl_account_number'];

        try{
            deleteAccounts($account_number);
            header('location: main.php');
        }
        catch(Exception $e){
            echo "Message: An error occurred. Please try again later! " ;
            echo "<pre>";
        }

    }


?>