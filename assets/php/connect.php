<?php
    function connectdb(){
        try {
            $conn = new PDO("sqlite:db_bank.db");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;

        } catch(PDOException $e) {
            die("<script>alert('Message: Database connection failed!')</script>");
        }
    }
?>