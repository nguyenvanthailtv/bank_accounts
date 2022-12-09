<?php 
    function insertAccounts($firstname,$lastname,$age,$gender,$email,$balance,$address,$city,$state,$employer){
        try{
            $conn = connectdb();
            $result_id = getdata("select MAX(account_number) FROM accounts");
            $id = $result_id[0]['MAX(account_number)'] + 1;
            $sql = "INSERT INTO accounts( account_number , balance, firstname, lastname, age, gender, address, employer, email, city, state) VALUES (:id, :balance, :firstname, :lastname, :age, :gender, :address, :employer, :email, :city, :state)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':balance',$balance);
            $stmt->bindParam(':firstname',$firstname);
            $stmt->bindParam(':lastname',$lastname);
            $stmt->bindParam(':age',$age);
            $stmt->bindParam(':gender',$gender);
            $stmt->bindParam(':address',$address);
            $stmt->bindParam(':employer',$employer);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':city',$city);
            $stmt->bindParam(':state',$state);

            $stmt->execute();
            $conn = null;
        }catch(Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    function updateAccount($account_number,$firstname,$lastname,$age,$gender,$email,$balance,$address,$city,$state,$employer){
        try {
            $conn = connectdb();
            $sql = "UPDATE accounts SET balance=:balance,firstname=:firstname,lastname=:lastname,age=:age,gender=:gender,address=:address,employer=:employer,email=:email,city=:city,state=:state where account_number=:account_number";
            $stmt = $conn->prepare($sql);
    
            $stmt->bindParam(':account_number',$account_number);
            $stmt->bindParam(':balance',$balance);
            $stmt->bindParam(':firstname',$firstname);
            $stmt->bindParam(':lastname',$lastname);
            $stmt->bindParam(':age',$age);
            $stmt->bindParam(':gender',$gender);
            $stmt->bindParam(':address',$address);
            $stmt->bindParam(':employer',$employer);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':city',$city);
            $stmt->bindParam(':state',$state);
    
            $stmt->execute();
            $conn = null;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function deleteAccounts($account_number){
        try {
            $conn = connectdb();
            $sql = "delete from accounts where account_number=:account_number";
            $stmt = $conn->prepare($sql);
            
            $stmt->bindParam(':account_number',$account_number);
    
            $stmt->execute();
            $conn = null;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function insertUser($username,$email,$password,$phone,$roles,$country){
        try {
            $conn  = connectdb();
            $result_id = getdata("select MAX(id) FROM users");
            $id = $result_id[0]['MAX(id)'] + 1;
            $sql  = " insert into users(id,username,password,phone,roles_id,email,country) values(:id,:username,:password,:phone,:roles_id,:email,:country)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':username',$username);
            $stmt->bindParam(':password',$password);
            $stmt->bindParam(':phone',$phone);
            $stmt->bindParam(':roles_id',$roles);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':country',$country);

            $stmt->execute();
            $conn = null;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function updateUser($id,$username,$email,$password,$phone,$roles,$country){
        try {
            $conn = connectdb();
            $sql = "UPDATE users SET username=:username,email=:email,phone=:phone,password=:password,roles_id=:roles,country=:country WHERE id =:id";
            $stmt = $conn->prepare($sql);
            
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':username',$username);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':password',$password);
            $stmt->bindParam(':phone',$phone);
            $stmt->bindParam(':roles',$roles);
            $stmt->bindParam(':country',$country);

            $stmt->execute();
            $conn = null;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function deleteUer($id){
        try {
            $conn = connectdb();
            $sql = "delete from users where id ='".$id."'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $conn=null;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function getdata($sql){
        try{
            $conn =connectdb();
            $stmt = $conn->query($sql);
            $arr = $stmt->fetchAll();
            $conn = null;
            return $arr;
        }
        catch(Exception $e){
            echo "Error: " . $e->getMessage();
        }

    }

    function hash_data($value){
        $hash = hash_hmac('sha256', '123456', $value);
        return $hash;
    }
?>