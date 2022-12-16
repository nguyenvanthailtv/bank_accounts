<?php
    session_start();
    require_once('./assets/php/connect.php');
    require_once('./assets/php/function.php');
    $_SESSION['active'] ='';
    $account_err=[];
    $login_roles = '';
    $login_username='';
    $_SESSION['arr_permissions'] = array();

    require_once('./assets/php/user_data.php');
    require_once('./assets/php/account/create_new_account.php');
    require_once('./assets/php/account/update_account.php');
    require_once('./assets/php/account/delete_account.php');

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
                            <p class="label-p">'.$login_username.'</p>
                        </div>';
                } 
           ?>

            <div class="side-bars__content">
                <ul class="list-content">
                    <li class="list-item active">
                        <a class="list-item__link" href="main.php">
                            <div class="list-item__link__wrapper">
                                <i class="fa-sharp fa fa-pen-to-square"></i>
                                <span>Account management</span>
                            </div>
                            <i class="fa fa-chevron-up arrow"></i>
                        </a>
                    </li>

                    <?php 
                        if(in_array('view_user',$_SESSION['arr_permissions'])){
                            echo '                    
                            <li class="list-item">
                                <a class="list-item__link" href="user.php">
                                    <div class="list-item__link__wrapper">
                                        <i class="fa-sharp fa fa-pen-to-square"></i>
                                        <span class="">User management</span>
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


        <div class="account-management">
            <div class="content">
                <div class="header">
                    <div class="header__container">
                        <form action="" method="get">
                            <div class="header__input">
                                <input type="text" placeholder="Search" name="search">
                            </div>
                        </form>
                    </div>
                    <i class="fa fa-bell"></i>
                </div>
                <div class="content__container">
                    <div class="title">
                        <h3>Account list</h3>

                        <?php 
                        if(in_array('create_account',$_SESSION['arr_permissions'])){
                            echo '                    
                                <div class="create-new">
                                    <i class="fa fa-plus"></i>
                                    <p>Create new account</p>
                                </div>';
                            }
                        ?>
                       
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th class="id">ID</th>
                                <th class="balance">Balance</th>
                                <th class="fullname">Full Name</th>
                                <th class="age">Age</th>
                                <th class="gender">Gender</th>
                                <th class="address">Address</th>
                                <th class="emloyer">Employer</th>
                                <th class="email">Email</th>
                                <?php 
                                    if(in_array('update_account',$_SESSION['arr_permissions']) && in_array('delete_account',$_SESSION['arr_permissions'])){
                                        echo '<th colspan="2" class="account-action">Action</th>';
                                    }
                                    elseif(in_array('update_account',$_SESSION['arr_permissions']) || in_array('delete_account',$_SESSION['arr_permissions'])){
                                        echo '<th colspan="1" class="roles-action">Action</th>';
                                    }
                                ?>

                            </tr>
                        </thead>
    
                        <tbody>
                        <?php
                            // connectdb();
                            if(!isset($_GET['page'])){
                                $page= 1 ;
                            }
                            else{
                                $page = $_GET['page'];
                            }
                            $results_per_page = 12;
                            $page_first_result = ($page - 1) * $results_per_page;
    
                            
                            if(isset($_GET['search']) && $_GET['search'] != ''){
                                $sql_count = "SELECT account_number,balance,firstname,lastname,age,gender,address,employer,email,city,states.name FROM `accounts` INNER JOIN states on states.abbreviation = accounts.state WHERE account_number LIKE'%".$_GET['search']."%' or balance LIKE'%".$_GET['search']."%' or firstname like'%".$_GET['search']."%' or lastname like'%".$_GET['search']."%' or age like'%".$_GET['search']."%' or gender like'%".$_GET['search']."%' or address like'%".$_GET['search']."%' or employer like'%".$_GET['search']."%' or email like'%".$_GET['search']."%' or city LIKE'%".$_GET['search']."%' or states.name like'%".$_GET['search']."%'   ORDER BY `accounts`.`account_number` ASC";
                                $rowcount = count(getdata($sql_count));
                                $number_of_page = ceil($rowcount / $results_per_page);
                                $sql = "SELECT account_number,balance,firstname,lastname,age,gender,address,employer,email,city,states.name FROM `accounts` INNER JOIN states on states.abbreviation = accounts.state WHERE account_number LIKE'%".$_GET['search']."%' or balance LIKE'%".$_GET['search']."%' or firstname like'%".$_GET['search']."%' or lastname like'%".$_GET['search']."%' or age like'%".$_GET['search']."%' or gender like'%".$_GET['search']."%' or address like'%".$_GET['search']."%' or employer like'%".$_GET['search']."%' or email like'%".$_GET['search']."%' or city LIKE'%".$_GET['search']."%' or states.name like'%".$_GET['search']."%'    ORDER BY `accounts`.`account_number`  ASC LIMIT ".$page_first_result.",".$results_per_page."";
                            }
                            else{
                                $sql_count = "SELECT account_number,balance,firstname,lastname,age,gender,address,employer,email,city,states.name FROM `accounts` INNER JOIN states on states.abbreviation = accounts.state ORDER BY `accounts`.`account_number` ASC";
                                $rowcount = count(getdata($sql_count));
                                $number_of_page = ceil($rowcount / $results_per_page);
                                $sql = "SELECT account_number,balance,firstname,lastname,age,gender,address,employer,email,city,states.name FROM `accounts` INNER JOIN states on states.abbreviation = accounts.state ORDER BY `accounts`.`account_number`  ASC LIMIT ".$page_first_result.",".$results_per_page."";
                            }
    
                            $arr = getdata($sql);
                            foreach($arr as $row){
                                $gender ='';
                                ($row['gender'] =='M')?$gender='Male':$gender='Female';
    
                                echo "<tr class='row-item'>";
                                echo "<td class='id'>".$row['account_number']."</td>";
                                echo "<td>".$row['balance']."</td>";
                                echo "<td>".$row['firstname']." ".$row['lastname']."</td>";
                                echo "<td  class='age'>".$row['age']."</td>";
                                echo "<td>".$gender."</td>";
                                echo "<td title='".$row['address'].'-'.$row['city'].'-'.$row['name']."'>".$row['address'].'-'.$row['city'].'-'.$row['name']."</td>";
                                echo "<td>".$row['employer']."</td>";
                                echo "<td title='".$row['email']."'>".$row['email']."</td>";
                                if(in_array('update_account',$_SESSION['arr_permissions'])){
                                    echo "<td><a href='main.php?ud_account_number=".$row['account_number']."' class='update-account'><i class='fa fa-file-pen'></i></a></td>";
                                }
                                if(in_array('create_account',$_SESSION['arr_permissions'])){
                                    echo "<td><a href='main.php?dl_account_number=".$row['account_number']."'><i class='fa fa-trash'></i></a></td>";
                                }
                                echo "</tr>";
                                $account_number = $row['account_number'];
                            }
    
                        ?>
                        </tbody>
                    </table>
    
                    <!-- pagin -->
                    <div class="paging">
                        <?php
                            $current_page =!empty($_GET['page'])?$_GET['page']:1;
                            
                            // fist page
                            if($current_page > 3){
                                $first_page = 1;
                                if(isset($_GET['search']) && $_GET['search'] != ''){
                                    echo '<a class="page" href = "main.php?page=' . $first_page . '&search='.$_GET['search'].'"><i class="fa fa-backward-fast"></i></a>';
                                }
                                else{
    
                                    echo '<a class="page" href = "main.php?page=' . $first_page . '"><i class="fa fa-backward-fast"></i></a>';
                                }
                            }
                            
                            // prev page
                            if($current_page > 1){
                                $prev_page = $current_page - 1;
                                if(isset($_GET['search']) && $_GET['search'] != ''){
                                    echo '<a class="page" href = "main.php?page=' . $prev_page . '&search='.$_GET['search'].'"><i class="fa fa-backward-step"></i></i></a>';
                                }
                                else{
    
                                    echo '<a class="page" href = "main.php?page=' . $prev_page . '"><i class="fa fa-backward-step"></i></i></a>';
                                }
                            }
    
                            // list page
                            for($page = 1; $page<= $number_of_page; $page++) {
                                if($page != $current_page){
                                    if($page > $current_page - 3 && $page < $current_page + 3){
                                        if(isset($_GET['search']) && $_GET['search'] != ''){
                                            echo '<a class="page" href = "main.php?page=' . $page . '&search='.$_GET['search'].'">' . $page . '</a>';
                                        }
                                        else{
                                            echo '<a class="page" href = "main.php?page=' . $page . '">' . $page . '</a>';
                                        }
                                    }
                                }
                                else{
                                    echo '<a class="page active">' . $page . '</a>';
                                }
                            }
    
                            // next page
                            if($current_page < $number_of_page - 1){
                                $next_page = $current_page + 1;
                                if(isset($_GET['search']) && $_GET['search'] != ''){
                                    echo '<a class="page" href = "main.php?page=' . $next_page . '&search='.$_GET['search'].'"><i class="fa fa-forward-step"></i></a>';   
                                }
                                else{
                                    echo '<a class="page" href = "main.php?page=' . $next_page . '"><i class="fa fa-forward-step"></i></a>';   
                                }
                            }
    
                            // last page
                            if($current_page < $number_of_page - 3){
                                $last_page = $number_of_page;
                                if(isset($_GET['search']) && $_GET['search'] != ''){
                                    echo '<a class="page" href = "main.php?page=' . $last_page . '&search='.$_GET['search'].'"><i class="fa fa-forward-fast"></i></a>';
                                }
                                else{
                                    echo '<a class="page" href = "main.php?page=' . $last_page . '"><i class="fa fa-forward-fast"></i></a>';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="account-impacts <?php 
                if(!empty($update_account) || !empty($create_account)){
                    echo 'active';
                }
                ?>" >
    
                <!-- Create account -->
                <form action="" method="post" class="insert-form ">
                    <h2 class="account-label">
                        <?php
                            if(empty($update_account)){
                                echo 'Create Account';
                            }
                            else{
                                echo 'Update Account';
                            }
                        
                        ?>
                        
                    </h2>
                    <div class="insert-form__wrapper">
                        
                        <div class="insert-form__content">
    
                            <!-- firstname -->
                            <div class="insert-form__input insert-form__firstname">
                                <input type="text" name="firstname" autocomplete="off"  required  
                                    value="<?php 
                                                if(!empty($_GET['ud_account_number'])) {echo $update_arr[0]['firstname'];} 
                                                if(!empty($firstname) && isset($_POST['create'])){echo $firstname;}
                                                ?>">
                                <p class="label-p">Firstname:</p>
                                <p class="account-err">
                                    <?php 
                                        if(isset($_POST['create'])){
                                            if(!empty($account_err['firstname_err']['required'])){
                                                echo $account_err['firstname_err']['required'];
                                            }
                                        }
                                    
                                    ?>
                                </p>
                            </div>
    
                            <!-- lastname -->
                            <div class="insert-form__input insert-form__lastname">
                                <input type="text" name="lastname" autocomplete="off"   required 
                                    value="<?php 
                                                if(isset($_GET['ud_account_number'])) echo $update_arr[0]['lastname']; 
                                                if(!empty($lastname) && isset($_POST['create'])) echo $lastname;
                                            ?>">
                                <p class="label-p">Lastname:</p>
                                <p class="account-err">
                                    <?php 
                                        if(isset($_POST['update']) || isset($_POST['create'])){
                                            if(!empty($account_err['lastname_err']['required'])){
                                                echo $account_err['lastname_err']['required'];
                                            }
                                        }
                                    
                                    ?>
                                </p>
                            </div>
    
                            <!-- age -->
                            <div class="insert-form__input insert-form__age">
                                <input type="text" name="age" autocomplete="off"  required min="0" 
                                    value="<?php 
                                                if(isset($_GET['ud_account_number'])) echo $update_arr[0]['age']; 
                                                if(!empty($age) && isset($_POST['create'])){echo $age;}
                                                ?>">
                                <p class="label-p">age:</p>
                                <p class="account-err">
                                    <?php 
                                        if(isset($_POST['update']) || isset($_POST['create'])){
                                            if(!empty($account_err['age_err']['required'])){
                                                echo $account_err['age_err']['required'];
                                            }elseif(!empty($account_err['age_err']['min'])){
                                                echo $account_err['age_err']['min'];
                                            }
                                        }
                                    
                                    ?>
                                </p>
                            </div>
    
                            <!-- gender -->
                            <div class="insert-form__input insert-form__gender">
                                <input type="hidden" class="input--hidden " name="gender"
                                    value="<?php 
                                                if(isset($_POST['create']) && !empty($gender_input)) echo $gender_input;
                                                if(isset($_GET['ud_account_number']) || isset($_POST['update'])) echo $gender_update;
                                                ?>">
                                <label class="label <?php if((isset($_POST['create']) || isset($_POST['update']) || !empty($_GET['ud_account_number'])) && !empty($gender) ) echo 'active'; ?>" ><?php 
                                        if(isset($_POST['create']) && !empty($gender_input)) echo $gender_input; 
                                        if(!empty($_GET['ud_account_number']) || isset($_POST['update'])) echo $gender_update;
                                ?></label>
                                <i class="fa fa-caret-up icon"></i>
                                <p class="label-p">Gender:</p>
                                <p class="account-err">
                                    <?php 
                                        if(isset($_POST['update']) or isset($_POST['create'])){
                                            if(!empty($account_err['gender_err']['required'])){
                                                echo $account_err['gender_err']['required'];
                                            }
                                        }
                                    
                                    ?>
                                </p>

                                <div class="list-wrapper">
                                    <ul class="list">
                                        <li class='list__item'>Male</li>
                                        <li class='list__item'>Female</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- email -->
                            <div class="insert-form__input insert-form__email">
                                <input type="email" name="email" autocomplete="off"  required 
                                    value="<?php 
                                                if(isset($_GET['ud_account_number'])) echo $update_arr[0]['email']; 
                                                if(!empty($email) && isset($_POST['create'])){echo $email;}?>">
                                <p class="label-p">Email:</p>
                                <p class="account-err">
                                    <?php 
                                        if(isset($_POST['update']) || isset($_POST['create'])){
                                            if(!empty($account_err['email_err']['required'])){
                                                echo $account_err['email_err']['required'];
                                            }elseif(!empty($account_err['email_err']['min_length'])){
                                                echo $account_err['email_err']['min_length'];
                                            }
                                        }
                                        if(isset($_POST['create']) && !empty($account_err['email_err']['already_exist'])){
                                            echo $account_err['email_err']['already_exist'];
                                        }
                                    ?>
                                </p>
                            </div>
    
                        </div>
                        <div class="insert-form__content">
    
                            <!-- balance -->
                            <div class="insert-form__input insert-form__balance">
                                <input type="text" name="balance" autocomplete="off"  required 
                                    value="<?php 
                                                if(isset($_GET['ud_account_number'])) echo $update_arr[0]['balance']; 
                                                if(!empty($balance) && isset($_POST['create'])){echo $balance;}
                                                ?>">
                                <p class="label-p">balance:</p>
                                <p class="account-err">
                                    <?php 
                                        if(isset($_POST['update']) || isset($_POST['create'])){
                                            if(!empty($account_err['balance_err']['required'])){
                                                echo $account_err['balance_err']['required'];
                                            }elseif(!empty($account_err['balance_err']['min'])){
                                                echo $account_err['balance_err']['min'];
                                            }
                                        }
                                    
                                    ?>
                                </p>
                            </div>
    
                            <!-- address -->
                            <div class="insert-form__input insert-form__address">
                                <input type="text" name="address" autocomplete="off"  required 
                                    value="<?php 
                                                if(isset($_GET['ud_account_number'])) echo $update_arr[0]['address']; 
                                                if(!empty($address) && isset($_POST['create'])){echo $address;}
                                                ?>">
                                <p class="label-p">address:</p>
                                <p class="account-err">
                                    <?php 
                                        if(isset($_POST['update']) || isset($_POST['create'])){
                                            if(!empty($account_err['address_err']['required'])){
                                                echo $account_err['address_err']['required'];
                                            }
                                        }
                                    
                                    ?>
                                </p>
                            </div>
                            
                            <!-- city -->
                            <div class="insert-form__input insert-form__City">
                                <input type="text" name="city" autocomplete="off"  required 
                                    value="<?php 
                                                if(isset($_GET['ud_account_number'])) echo $update_arr[0]['city']; 
                                                if(!empty($city) && isset($_POST['create'])){echo $city;}
                                                ?>">
                                <p class="label-p">City:</p>
                                <p class="account-err">
                                    <?php 
                                        if(isset($_POST['update']) || isset($_POST['create'])){
                                            if(!empty($account_err['city_err']['required'])){
                                                echo $account_err['city_err']['required'];
                                            }
                                        }
                                    
                                    ?>
                                </p>
                            </div>
    
                            <!-- states -->
                            <div class="insert-form__input insert-form__state">
                                <input type="hidden" class="input--hidden " name="state"
                                    value="<?php 
                                                if(isset($_POST['create']) && !empty($state)) echo $state;
                                                if(isset($_GET['ud_account_number'])) echo $state;
                                                ?>">
                                <label class="label <?php if(!empty($state)) echo 'active'; ?>" >
                                    <?php 
                                        if(isset($_POST['create']) && !empty($state)) echo $state; 
                                        if(!empty($_GET['ud_account_number'])) echo $state;
                                    ?>
                                </label>
                                <i class="fa fa-caret-up icon"></i>
                                <p class="label-p">State:</p>
                                <p class="account-err">
                                    <?php 
                                        if(isset($_POST['update']) || isset($_POST['create'])){
                                            if(!empty($account_err['state_err']['required'])){
                                                echo $account_err['state_err']['required'];
                                            }
                                        }
                                    
                                    ?>
                                </p>
                                <div class="list-wrapper">
                                    <ul class="list">
                                        <?php
                                            $sql = "SELECT name FROM states";
                                            $arr = getdata($sql);
                                            foreach($arr as $item){
                                                echo "<li class='list__item'>".$item['name']."</li>";
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
    
                            <!-- employer -->
                            <div class="insert-form__input insert-form__employer" >
                                <input type="text" name="employer" autocomplete="off"  required 
                                    value="<?php 
                                                if(isset($_GET['ud_account_number'])) echo $update_arr[0]['employer']; 
                                                if(!empty($employer) && isset($_POST['create'])){echo $employer;}
                                                ?>">
                                <p class="label-p">employer:</p>
                                <p class="account-err">
                                    <?php 
                                        if(isset($_POST['update']) || isset($_POST['create'])){
                                            if(!empty($account_err['employer_err']['required'])){
                                                echo $account_err['employer_err']['required'];
                                            }
                                        }
                                    
                                    ?>
                                </p>
                            </div>
    
                        </div>
                    </div>
    
                    <div class="insert-form__btn">
                        <?php 
                            if(isset($_GET['ud_account_number'])){ 
                                echo '<button type="submit" name="update" class="btn btn--action">Update</button>';
                            }
                            else{
                                echo '<button type="submit" name="create" class="btn btn--action">Create</button>';
                            }
                                            
                        ?>
                        <button type="submit" name="close" class="btn btn--close">Close</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <script src="./assets/js/style.js?v=<?php echo time(); ?>"></script>
</body>
</html>
