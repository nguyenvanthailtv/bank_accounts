<?php
    session_start();
    require_once('./assets/php/connect.php');
    require_once('./assets/php/function.php');
    $login_err=[];
    $_SESSION['login_permissions']=[];
    $_SESSION['login_username']='';
    $_SESSION['login_roles']='';
    $_SESSION['login_email'] = '';
    $_SESSION['login_password'] = '';
    require_once('./assets/php/login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/main.css">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" class="form-login">
        <div class="login__nav">
            <div class="login__wrapper">

                <div class="login__content">
                    <h2>LOGIN</h2>
                    <div class="login__email">
                        <input type="email" name="email" class="login__email__input" autocomplete="off" required value="<?php if(!empty($_SESSION['login_email'])) echo $_SESSION['login_email']; ?>" >
                        <p class="login__email__text"0>Email: </p>
                        <p class="login-err" ><?php 
                            if(isset($_POST['submit'])){
                                if(!empty($login_err['email_err']['required'])){
                                    echo $login_err['email_err']['required'];
                                }
                                elseif(!empty($login_err['email_err']['min_length'])){
                                    echo $login_err['email_err']['min_length'];
                                }
                            }
                        ?></p>
                    </div>
                    <div class="login__password">
                        <input type="password" name="password" class="login__password__input" autocomplete="off" required value="<?php if(!empty($_SESSION['login_password'])) echo $_SESSION['login_password'];?>" >
                        <p class="login__password__text">Password: </p>
                        <p class="login-err" ><?php 
                            if(isset($_POST['submit'])){
                                if(!empty($login_err['password_err']['required'])){
                                    echo $login_err['password_err']['required'];
                                }
                                elseif(!empty($login_err['password_err']['min_length'])){
                                    echo $login_err['password_err']['min_length'];
                                }
                            }
                        ?></p>
                    </div>
                    
                    <p class="login-err" ><?php 
                        if(isset($_POST['submit'])){
                            if(!empty($login_err['login_failed']['failed'])){
                                echo $login_err['login_failed']['failed'];
                            }
                        }
                    ?></p>

                    <div class="login__btn">
                        <div class="login__btn__btn">
                            <button type="submit" name="submit">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>