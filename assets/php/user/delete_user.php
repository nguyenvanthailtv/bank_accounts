<?php 
    if(isset($_GET['dl_user_number'])){
        $id = $_GET['dl_user_number'];

        try{
            deleteUer($id);
            header('location: user.php');
        }
        catch(Exception $e){
            echo "Error: ".$e->getMessage();
            echo "<pre>";
        }

    }

?>