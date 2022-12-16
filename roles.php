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
    require_once('./assets/php/roles/create_new_roles.php');
    require_once('./assets/php/roles/update_roles.php');
    require_once('./assets/php/roles/delete_roles.php');

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
                    <li class="list-item active">
                        <a class="list-item__link" href="roles.php">
                            <div class="list-item__link__wrapper">
                                <i class="fa-sharp fa fa-pen-to-square"></i>
                                <span class="">Roles management</span>
                            </div>
                            <i class="fa fa-chevron-up arrow"></i>
                        </a>
                    </li>
                    <li class="list-item">
                        <a class="list-item__link" href="permissions.php">
                            <div class="list-item__link__wrapper">
                                <i class="fa-sharp fa fa-pen-to-square"></i>
                                <span class="">Permission</span>
                            </div>
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
                        <h3>Roles list</h3>
                        <?php 
                            if(in_array('create_roles',$_SESSION['arr_permissions'])){
                                echo '                    
                                    <div class="create-new-roles">
                                        <i class="fa fa-plus"></i>
                                        <p>Create new roles</p>
                                    </div>';
                            }
                        ?>
                       
                    </div>
                    <table class="tb-roles">
                        <thead>
                            <tr>
                                <th class="roles-id">ID</th>
                                <th class="roles-name">Name</th>
                                <th class="roles-description">Description</th>
                                <?php 
                                    if(in_array('update_roles',$_SESSION['arr_permissions']) && in_array('delete_roles',$_SESSION['arr_permissions'])){
                                        echo '<th colspan="2" class="roles-action">Action</th>';
                                    }
                                    elseif(in_array('update_roles',$_SESSION['arr_permissions']) || in_array('delete_roles',$_SESSION['arr_permissions'])){
                                        echo '<th colspan="1" class="roles-action">Action</th>';
                                    }
                                ?>
                                
                            </tr>
                        </thead>
    

                        <tbody>
                            <?php
                                connectdb();
                                $sql = "select * from roles ORDER BY roles_id ASC";

                                $arr = getdata($sql);
                                foreach($arr as $row){

                                    echo "<tr class='row-item'>";
                                    echo "<td class='id'>".$row['roles_id']."</td>";
                                    echo "<td>".$row['roles_name']."</td>";
                                    echo "<td>".$row['roles_description']."</td>";
                                    if(in_array('update_roles',$_SESSION['arr_permissions'])){
                                        echo "<td><a href='roles.php?ud_roles_number=".$row['roles_id']."' class='update-roles'><i class='fa fa-file-pen'></i></a></td>";
                                    }
                                    if(in_array('delete_roles',$_SESSION['arr_permissions'])){
                                        echo "<td><a href='roles.php?dl_roles_number=".$row['roles_id']."'><i class='fa fa-trash'></i></a></td>";
                                    }
                                    echo "</tr>";
                                }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="roles-impacts <?php 
                if(!empty($update_roles) || !empty($create_roles)){
                    echo 'active';
                }
                ?>" >
    
                <!-- Create roles -->
                <form action="" method="post" class="insert-form roles">
                    <h2 class="roles-label">
                        <?php
                            if(empty($update_roles)){
                                echo 'Create Roles';
                            }
                            else{
                                echo 'Update Roles';
                            }
                        
                        ?>
                        
                    </h2>
                    <div class="insert-form__wrapper roles">
                        
                        <div class="insert-form__content roles">
                            <!-- Name -->
                            <div class="insert-form__input insert-form__name">
                                <input type="text" name="name" autocomplete="off"  required  
                                    value="<?php 
                                                if(!empty($_GET['ud_roles_number'])) {echo $update_arr[0]['roles_name'];} 
                                                if(!empty($roles_name) && isset($_POST['create'])){echo $roles_name;}
                                                ?>">
                                <p class="label-p">Name:</p>
                                <p class="roles-err">
                                    <?php 
                                        if(isset($_POST['create'])){
                                            if(!empty($roles_err['name_err']['required'])){
                                                echo $roles_err['name_err']['required'];
                                            }
                                        }
                                    
                                    ?>
                                </p>
                            </div>
                            <!-- Description -->
                            <div class="insert-form__input insert-form__description">
                                <input type="text" name="description" autocomplete="off"   required 
                                    value="<?php 
                                                if(isset($_GET['ud_roles_number'])) echo $update_arr[0]['roles_description']; 
                                                if(!empty($desc) && isset($_POST['create'])) echo $desc;
                                            ?>">
                                <p class="label-p">Description:</p>
                                <p class="roles-err">
                                    <?php 
                                        if(isset($_POST['update']) || isset($_POST['create'])){
                                            if(!empty($roles_err['desc_err']['required'])){
                                                echo $roles_err['desc_err']['required'];
                                            }
                                        }
                                    
                                    ?>
                                </p>
                            </div>    
                        </div>
                        <div class="insert-form__content permission">
                            <h3 class="per__headding">Permission</h3>
                            <!-- account -->
                            <div class="per__wrapper">
                                <p class="per__label">Account</p>
                                <div class="per__checkbox">
                                    <div class="per__checkbox-box">
                                        <input type="checkbox" <?php if(in_array('1',$arr_per)): echo 'checked'; endif; ?> name="data[]" id="view_account" value="1" >
                                        <label for="view_account">view account</label>
                                    </div>
                                    <div class="per__checkbox-box">
                                        <input type="checkbox" <?php if(in_array('2',$arr_per)): echo 'checked'; endif; ?> name="data[]" id="create_account" value="2" >
                                        <label for="create_account">create account</label>
                                    </div>
                                    <div class="per__checkbox-box">
                                        <input type="checkbox" <?php if(in_array('3',$arr_per)): echo 'checked'; endif; ?> name="data[]" id="update_account" value="3" >
                                        <label for="update_account">update account</label>
                                    </div>
                                    <div class="per__checkbox-box">
                                        <input type="checkbox" <?php if(in_array('4',$arr_per)): echo 'checked'; endif; ?> name="data[]" id="delete_account" value="4" >
                                        <label for="delete_account">delete account</label>
                                    </div>
                                </div>
                            </div>

                            <!-- user -->
                            <div class="per__wrapper">
                                <p class="per__label">User</p>
                                <div class="per__checkbox">
                                    <div class="per__checkbox-box">
                                        <input type="checkbox" <?php if(in_array('5',$arr_per)): echo 'checked'; endif; ?> name="data[]" id="view_user" value="5" >
                                        <label for="view_user">view user</label>
                                    </div>
                                    <div class="per__checkbox-box">
                                        <input type="checkbox" <?php if(in_array('6',$arr_per)): echo 'checked'; endif; ?> name="data[]" id="create_user"  value="6">
                                        <label for="create_user">create user</label>
                                    </div>
                                    <div class="per__checkbox-box">
                                        <input type="checkbox" <?php if(in_array('7',$arr_per)): echo 'checked'; endif; ?> name="data[]" id="update_user" value="7" >
                                        <label for="update_user">update user</label>
                                    </div>
                                    <div class="per__checkbox-box">
                                        <input type="checkbox" <?php if(in_array('8',$arr_per)): echo 'checked'; endif; ?> name="data[]" id="delete_user" value="8">
                                        <label for="delete_user">delete user</label>
                                    </div>
                                </div>
                            </div>

                            <!-- roles -->
                            <div class="per__wrapper">
                                <p class="per__label">Roles</p>
                                <div class="per__checkbox">
                                    <div class="per__checkbox-box">
                                        <input type="checkbox" <?php if(in_array('9',$arr_per)): echo 'checked'; endif; ?> name="data[]" id="view_roles" value="9" >
                                        <label for="view_roles">view roles</label>
                                    </div>
                                    <div class="per__checkbox-box">
                                        <input type="checkbox" <?php if(in_array('10',$arr_per)): echo 'checked'; endif; ?> name="data[]" id="create_roles" value="10">
                                        <label for="create_roles">create roles</label>
                                    </div>
                                    <div class="per__checkbox-box">
                                        <input type="checkbox" <?php if(in_array('11',$arr_per)): echo 'checked'; endif; ?> name="data[]" id="update_roles" value="11">
                                        <label for="update_roles">update roles</label>
                                    </div>
                                    <div class="per__checkbox-box">
                                        <input type="checkbox" <?php if(in_array('12',$arr_per)): echo 'checked'; endif; ?> name="data[]" id="delete_roles" value="12">
                                        <label for="delete_roles">delete roles</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="insert-form__btn roles">
                        <?php 
                            if(isset($_GET['ud_roles_number'])){ 
                                echo '<button type="submit" name="update" class="btn roles btn--action">Update</button>';
                            }
                            else{
                                echo '<button type="submit" name="create" class="btn roles btn--action">Create</button>';
                            }
                                            
                        ?>
                        <button type="submit" name="close" class="btn roles btn--close">Close</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <!-- <script src="./assets/js/roles/roles_style.js?v=<?php echo time(); ?>"></script> -->
</body>
</html>
