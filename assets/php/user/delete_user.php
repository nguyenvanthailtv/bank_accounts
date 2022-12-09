<?php 
    if(isset($_GET['dl_user_number'])){
        $id = $_GET['dl_user_number'];

        try{
            deleteUer($id);
            header('location: user.php');
        }
        catch(Exception $e){
            echo "Message: An error occurred. Please try again later! " ;
            echo "<pre>";
        }

    }

?>