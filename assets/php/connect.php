<?php
    function connectdb(){
        // $servername = "localhost";
        // $username = "root";
        // $password = "";
        // $dbname="dbbank_accounts";

        try {
            $conn = new PDO("sqlite:db_bank.db");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;

        } catch(PDOException $e) {
            echo "Message: Database connection failed!";
        }


    }
?>