<?php
    session_start();
    require_once('./assets/php/connect.php');
    require_once('./assets/php/function.php');
    $_SESSION['active'] ='';
    $roles_id='';
    $roles_err=[];
    $login_roles = '';
    $login_username='';
    $create_roles = false;
    $update_roles=false;
    // $all_permissions = [];
    $arr_per = array();
    require_once('./assets/php/user_data.php');
    // require_once('./assets/php/roles/create_new_roles.php');
    // require_once('./assets/php/roles/update_roles.php');
    // require_once('./assets/php/roles/delete_roles.php');

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
    <script src="./assets/js/roles/roles_style.js?v=<?php echo time(); ?>"></script>
    
    
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
                            <p class="label-p">'.$login_username.'</p>
                        </div>';
                } 
           ?>

            <div class="side-bars__content">
                <ul class="list-content">
                    <?php 
                        if(in_array('view_account',$_SESSION['arr_permissions'])){
                            echo '
                                <li class="list-item">
                                    <a class="list-item__link" href="main.php">
                                        <div class="list-item__link__wrapper">
                                            <i class="fa-sharp fa fa-pen-to-square"></i>
                                            <span>Account management</span>
                                        </div>
                                    </a>
                                </li>';
                        }
                    ?>
                    <?php 
                        if(in_array('view_user',$_SESSION['arr_permissions'])){
                            echo '
                                <li class="list-item">
                                    <a class="list-item__link" href="user.php">
                                        <div class="list-item__link__wrapper">
                                            <i class="fa-sharp fa fa-pen-to-square"></i>
                                            <span>User management</span>
                                        </div>
                                    </a>
                                </li>';
                        }
                    ?>
                    <?php 
                        if(in_array('view_roles',$_SESSION['arr_permissions'])){
                            echo '
                            <li class="list-item">
                            <a class="list-item__link" href="roles.php">
                                <div class="list-item__link__wrapper">
                                    <i class="fa-sharp fa fa-pen-to-square"></i>
                                    <span class="">Roles management</span>
                                </div>
                            </a>
                        </li>';
                        }
                    ?>
                    
                    <li class="list-item active">
                        <a class="list-item__link" href="permissions.php">
                            <div class="list-item__link__wrapper">
                                <i class="fa-sharp fa fa-pen-to-square"></i>
                                <span class="">Permission</span>
                            </div>
                            <i class="fa fa-chevron-up arrow"></i>
                        </a>
                    </li>

                    <?php 
                            if(isset($_POST['logout'])){
                                session_reset();
                                header('location: index.php');
                            }
                        ?>
                    <li class="list-item">
                        <form action="" method="post">
                            <button type="submit" name="logout" class="list-item__link">
                                <div class="list-item__link__wrapper">
                                    <i class="fa fa-arrow-right-from-bracket"></i>
                                    <span>Log Out</span>
                                </div>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>


        <div class="roles-management">
            <div class="content">
                <div class="header header-roles">
                </div>
                <div class="content__container">
                    <div class="title">
                        <h3>Permission list</h3>
                    </div>
                    <table class="tb-roles">
                        <thead>
                            <tr>
                                <th class="roles-id">ID</th>
                                <th class="roles-name">Name</th>
                                <th class="roles-description">Description</th>
                            </tr>
                        </thead>
    

                        <tbody>
                            <?php
                                connectdb();
                                $sql = "select * from permissions ORDER BY permission_id ASC";

                                $arr = getdata($sql);
                                foreach($arr as $row){

                                    echo "<tr class='row-item'>";
                                    echo "<td class='id'>".$row['permission_id']."</td>";
                                    echo "<td>".$row['permission_name']."</td>";
                                    echo "<td>".$row['permission_description']."</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- <script src="./assets/js/roles/roles_style.js?v=<?php echo time(); ?>"></script> -->
</body>
</html>
