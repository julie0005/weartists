<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
    include "../db.php";
    $id=$_POST['id'];
    $password=password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email=$_POST['email'];
   $result=mysqli_query($db, "INSERT INTO user(id, password, email) values('$id','$password', '$email')") or die ("알 수 없는 오류");
   echo("<script>alert('회원가입이 완료되었습니다!'); location.href='./login.php';</script>");

?>