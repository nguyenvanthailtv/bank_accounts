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
            die("<script>alert('Message: add account failed!')</script>");
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
            die("<script>alert('Message: update account failed!')</script>");
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
            die("<script>alert('Message: delete account failed!')</script>") ;
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
            die("<script>alert('Message: add user failed!')</script>");
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
            die("<script>alert('Message: update user failed!')</script>");
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
            die("<script>alert('Message: delete user failed!')</script>");
        }
    }


    function insertRoles($roles_name,$roles_desc){
        try {
            $conn  = connectdb();
            $result_id = getdata("select max(roles_id) from roles;");
            $id = $result_id[0]['max(roles_id)'] + 1;
            $sql  = "insert into roles(roles_id,roles_name,roles_description) values(:id,:roles_name,:roles_description);";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':roles_name',$roles_name);
            $stmt->bindParam(':roles_description',$roles_desc);
            $stmt->execute();
            $conn = null;
        } catch (Exception $e) {
            die("<script>alert('Message: add roles failed!')</script>");
        }  
    }

    function insertRoles_Permissions($permission_id){
        try {
            $conn  = connectdb();

            $result_id = getdata("select max(id) from roles_permissions;");
            $id = $result_id[0]['max(id)'] + 1;

            $result_id = getdata("select max(roles_id) from roles;");
            $roles_id = $result_id[0]['max(roles_id)'];

            $sql  = "insert into roles_permissions(id,roles_id,permission_id) values(:id,:roles_id,:permission_id);";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':roles_id',$roles_id);
            $stmt->bindParam(':permission_id',$permission_id);
            $stmt->execute();
            $conn = null;
        } catch (Exception $e) {
            die("<script>alert('Message: add roles failed!')</script>");
        }  
    }

    function updateRoles($roles_id,$roles_name,$roles_description){
        try {
            $conn  = connectdb();
            $sql  = "update roles set roles_name = :roles_name, roles_description =:roles_description where roles_id=:roles_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':roles_id',$roles_id);
            $stmt->bindParam(':roles_name',$roles_name);
            $stmt->bindParam(':roles_description',$roles_description);
            $stmt->execute();
            $conn = null;
        } catch (Exception $e) {
            die("<script>alert('Message: update roles failed!')</script>");
        }  
    }

    function insertRoles_Permissions2($roles_id,$permission_id){
        try {
            $conn  = connectdb();

            $result_id = getdata("select max(id) from roles_permissions;");
            $id = $result_id[0]['max(id)'] + 1;

            $sql  = "insert into roles_permissions(id,roles_id,permission_id) values(:id,:roles_id,:permission_id);";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':roles_id',$roles_id);
            $stmt->bindParam(':permission_id',$permission_id);
            $stmt->execute();
            $conn = null;
        } catch (Exception $e) {
            die("<script>alert('Message: add roles failed!')</script>");
        }  
    }

    function deletetRoles($roles_id){
        try {
            $conn  = connectdb();
            $sql  = "delete from roles where roles_id =:roles_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':roles_id',$roles_id);
            $stmt->execute();
            $conn = null;
        } catch (Exception $e) {
            die("<script>alert('Message: remove roles failed!')</script>");
        }  
    }

    function deleteRoles_Permissions($roles_id){
        try {
            $conn  = connectdb();

            $sql  = "delete from roles_permissions where roles_id =:roles_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':roles_id',$roles_id);
            $stmt->execute();
            $conn = null;
        } catch (Exception $e) {
            die("<script>alert('Message: remove roles failed!')</script>");
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
            die("<script>alert('Message: An error occurred. Please try again later!')</script>");
        }

    }

    function hash_data($value){
        $hash = hash_hmac('sha256', '123456', $value);
        return $hash;
    }
?>
