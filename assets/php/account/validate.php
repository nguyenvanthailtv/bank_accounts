<?php

if(empty($firstname)){
    $account_err['firstname_err']['required'] ='Please enter firstname!';
}
if(empty($lastname)){
    $account_err['lastname_err']['required'] ='Please enter lastname!';
}
if(empty($age)){
    $account_err['age_err']['required'] ='Please enter age!';
}elseif($age <= 18){
    $account_err['age_err']['min'] ='age must be more than 18!';
}
if(empty($gender)){
    $account_err['gender_err']['required'] ='Please enter gender!';
}

if(empty($email)){
    $account_err['email_err']['required'] ='Please enter email!';
}elseif(strlen($email) < 12 ){
    $account_err['email_err']['min_length'] ='Email must be more than 12 characters!';
}elseif(!empty($test_email) &&  count($test_email) === 1 ){
    $account_err['email_err']['already_exist'] ='Email already in use!';
}

if(empty($balance)){
    $account_err['balance_err']['required'] ='Please enter balance!';
}elseif($balance < 0){
    $account_err['balance_err']['min'] ='balance must be greater than or equal to 0!';
}

if(empty($address)){
    $account_err['address_err']['required'] ='Please enter address!';
}

if(empty($state)){
    $account_err['state_err']['required'] ='Please enter state!';
}

if(empty($city)){
    $account_err['city_err']['required'] ='Please enter city!';
}

if(empty($employer)){
    $account_err['employer_err']['required'] ='Please enter employer!';
}

?>