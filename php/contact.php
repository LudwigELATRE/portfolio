<?php
if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])){
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    if(filter_ver($email, filter)){

    }else{}
}else{
    header('location:index.php');
    exit();
}