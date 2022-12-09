<?php
    session_start();
    require_once('./assets/php/connect.php');
    require_once('./assets/php/function.php');
    $update_user =false;
    $create_user = false;
    $user_err=[];
    require_once('./assets/php/action.php');
    require_once('./assets/php/user/create_new_user.php');
    require_once('./assets/php/user/update_user.php');
    require_once('./assets/php/user/delete_user.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/image/fontawesome-free-6.2.0-web/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="./assets/css/main.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" ></script>
    
    
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
        <div class="side-bars">
            <?php 
                if(!empty($login_roles) && !empty($login_username)){
                    echo '
                        <div class="side-bars__roles">
                            <p class="side-bars__roles__logo">A</p>
                            <label for="" class="type-of-roles">'.$login_roles.'</label>
                        </div>
                        <div class="side-bars__username">
                            <i class="fa fa-user"></i>
                            <p>'.$login_username.'</p>
                        </div>';
                } 
           ?>

            <div class="side-bars__content">
                <ul class="list-content">
                    <li class="list-item">
                        <a class="list-item__link" href="main.php">
                            <div class="list-item__link__wrapper">
                                <i class="fa-sharp fa fa-pen-to-square"></i>
                                <span>Account management</span>
                            </div>
                        </a>
                    </li>

                <?php 
                    if($login_roles == 'admin'){
                        echo '                    
                        <li class="list-item active">
                            <a class="list-item__link" href="user.php">
                                <div class="list-item__link__wrapper">
                                    <i class="fa-sharp fa fa-pen-to-square"></i>
                                    <span class="">User management</span>
                                </div>
                                <i class="fa fa-chevron-up arrow"></i>
                            </a>
                        </li>';
                    }
                ?>

                    <li class="list-item">
                        <a href="login.php" class="list-item__link">
                            <div class="list-item__link__wrapper">
                                <i class="fa fa-arrow-right-from-bracket"></i>
                                <span>Log Out</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="user-management">
            <div class="content">
                <div class="header header-user"></div>
                <div class="content__container">
                    <div class="title">
                        <h3>User list</h3>
                        <div class="create-new-user">
                            <i class="fa fa-plus"></i>
                            <p>Create new User</p>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th class="id">ID</th>
                                <th class="username">Username</th>
                                <th class="email">Email</th>
                                <th class="phone">Phone</th>
                                <th class="password">Password</th>
                                <th class="roles">roles</th>
                                <th class="country">Country</th>
                                <th class="action" colspan="2">Action</th>
                                
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                            connectdb();
                            $sql = "SELECT id, username,email,phone,password,roles.roles_name,country.country_name FROM users,roles,country WHERE roles.roles_id = users.roles_id and country.abbreviation = users.country";

                            $arr = getdata($sql);
                            foreach($arr as $row){

                                echo "<tr class='row-item'>";
                                echo "<td class='id'>".$row['id']."</td>";
                                echo "<td>".$row['username']."</td>";
                                echo "<td>".$row['email']."</td>";
                                echo "<td  class='age'>".$row['phone']."</td>";
                                echo "<td title='".$row['password']."'>".$row['password']."</td>";
                                echo "<td>".$row['roles_name']."</td>";
                                echo "<td>".$row['country_name']."</td>";
                                echo "<td><a href='user.php?ud_user_number=".$row['id']."' class='update-user'><i class='fa fa-file-pen'></i></a></td>";
                                echo "<td><a href='user.php?dl_user_number=".$row['id']."'><i class='fa fa-trash'></i></a></td>";
                                echo "</tr>";
                            }

                        ?>
                        </tbody>
                    </table>
        
                </div>
            </div>

            <div class="user-impacts <?php
                    if(!empty($create_user) || !empty($update_user)){
                        echo 'active';
                    }
                    else{
                        echo '';
                    }
                
                ?>">
    
                <!-- Create user -->
                <form action="" method="post" class="insert-form user">
    
                    <h2 class="label">
                        <?php
                            if(!empty($update_user)){
                                echo 'Update User';
                            }
                            else{
                                echo 'Create User';
                            }
                        
                        ?>
                        
                    </h2>
                    <div class="insert-form__wrapper">
                        
                        <div class="insert-form__content user">
    
                            <!-- username -->
                            <div class="insert-form__input insert-form__username">
                                <input type="text" name="username" required autocomplete="off" 
                                    value="<?php if(isset($_POST['create-user']) && !empty($username)) echo $username;
                                                if(!empty($_GET['ud_user_number'])) echo $username;?>">
                                <p class="label-p">Username:</p>
                                <p class="user_err">
                                    <?php 
                                        if(isset($_POST['create-user']) || isset($_POST['update_user']) ){
                                            if(!empty($user_err['username_err']['required'])){
                                                echo $user_err['username_err']['required'];
                                            }
                                        }
                                    ?>
                                </p>
                            </div>
    
                            <!-- password -->
                            <div class="insert-form__input insert-form__password">
                                <input type="password" name="password" required autocomplete="off" 
                                    value="<?php if(isset($_POST['create-user']) && !empty($password)) echo $password; 
                                                 if(!empty($_GET['ud_user_number'])) echo $password; ?>">
                                <p class="label-p">Password:</p>
                                <p class="user_err">
                                    <?php 
                                        if(isset($_POST['create-user']) || isset($_POST['update_user']) ){
                                            if(!empty($user_err['password_err']['required'])){
                                                echo $user_err['password_err']['required'];
                                            }elseif(!empty($user_err['password_err']['min_length'])){
                                                echo $user_err['password_err']['min_length'];
                                            }
                                        }
                                    ?>
                                </p>
                            </div>
    
                            <!-- phone -->
                            <div class="insert-form__input insert-form__phone">
                                <input type="text" name="phone" required autocomplete="off" 
                                    value="<?php if(isset($_POST['create-user']) && !empty($phone)) echo $phone; 
                                                if(!empty($_GET['ud_user_number'])) echo $phone; ?>">
                                <p class="label-p">Phone:</p>
                                <p class="user_err">
                                    <?php 
                                        if(isset($_POST['create-user']) || isset($_POST['update_user']) ){
                                            if(!empty($user_err['phone_err']['required'])){
                                                echo $user_err['phone_err']['required'];
                                            }
                                        }
                                    ?>
                                </p>
                            </div>
    
                            <!-- roles -->
                            <div class="insert-form__input insert-form__roles">
                                <input type="hidden" class="input--hidden" name="roles" 
                                    value="<?php if(isset($_POST['create-user']) && !empty($roles)) echo $roles; 
                                                if(!empty($_GET['ud_user_number'])) echo $roles; ?>">
                                <label class="label <?php if(!empty($roles)) echo 'active'; ?>" >
                                    <?php 
                                        if(isset($_POST['create-user']) && !empty($roles)) echo $roles; 
                                        if(!empty($_GET['ud_user_number'])) echo $roles;
                                    ?>
                                </label>
                                <i class="fa fa-caret-up icon"></i>
                                <p class="label-p">Roles:</p>
                                <p class="user_err">
                                    <?php 
                                        if(isset($_POST['create-user']) || isset($_POST['update-user']) ){
                                            if(!empty($user_err['roles_err']['required'])){
                                                echo $user_err['roles_err']['required'];
                                            }
                                        }
                                    ?>
                                </p>
                                <div class="list-wrapper">
                                    <ul class="list">
                                    <?php
                                            $sql = "SELECT roles_name FROM roles";
                                            $arr = getdata($sql);
                                            foreach($arr as $item){
                                                echo "<li class='list__item'>".$item['roles_name']."</li>";
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- country -->
                            <div class="insert-form__input insert-form__Country">
                                <input type="hidden" class="input--hidden " name="country" readonly="false" 
                                    value="<?php if(isset($_POST['create-user']) && !empty($country)) echo $country; 
                                                if(!empty($_GET['ud_user_number'])) echo $country; ?>">
                                <label class="label <?php if(!empty($country)) echo 'active'; ?>" >
                                    <?php 
                                        if(isset($_POST['create-user']) && !empty($country)) echo $country; 
                                        if(!empty($_GET['ud_user_number'])) echo $country;
                                    ?>
                                </label>
                                <i class="fa fa-caret-up icon"></i>
                                <p class="label-p">Country:</p>
                                <p class="user_err">
                                    <?php 
                                        if(isset($_POST['create-user']) || isset($_POST['update_user']) ){
                                            if(!empty($user_err['country_err']['required'])){
                                                echo $user_err['country_err']['required'];
                                            }
                                        }
                                    ?>
                                </p>
                                <div class="list-wrapper">
                                    <ul class="list">
                                        <?php
                                            $sql = "SELECT country_name FROM country";
                                            $arr = getdata($sql);
                                            foreach($arr as $item){
                                                echo "<li class='list__item'>".$item['country_name']."</li>";
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- email -->
                            <div class="insert-form__input insert-form__email">
                                <input type="email" name="email" required autocomplete="off" 
                                    value="<?php if(isset($_POST['create-user']) && !empty($email)) echo $email; 
                                                if(!empty($_GET['ud_user_number'])) echo $email; ?>">
                                <p class="label-p">Email:</p>
                                <p class="user_err">
                                    <?php 
                                        if(isset($_POST['create-user']) || isset($_POST['update_user']) ){
                                            if(!empty($user_err['email_err']['required'])){
                                                echo $user_err['email_err']['required'];
                                            }elseif(!empty($user_err['email_err']['already_exist'])){
                                                echo $user_err['email_err']['already_exist'];
                                            }
                                        }
                                    ?>
                                </p>
                            </div>
                        </div>


                    </div>
    
                    <div class="insert-form__btn user">
                        <?php 
                            if(isset($_GET['ud_user_number'])){ 
                                echo '<button type="submit" name="update-user" class="btn user btn--action">Update</button>';
                            }
                            else{
                                echo '<button type="submit" name="create-user" class="btn user btn--action">Create</button>';
                            }
                                            
                        ?>
                        <button type="submit" name="close" class="btn user btn--close">Close</button>
                    </div>
                </form>
            </div>
        </div>

    <script src="./assets/js/style.js?v=<?php echo time(); ?>"></script>
</body>
</html>
