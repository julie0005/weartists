<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include "../db.php";
    $id=$_POST['id'];
    $nickname=$_POST['nickname'];
    $password=password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email=$_POST['email'];
   $result=mysqli_query($db, "INSERT INTO user(id, password, email,nickname) values('$id','$password', '$email','$nickname')") or die ("알 수 없는 오류");
   $u_id=mysqli_insert_id($db);
   $result2=mysqli_query($db, "INSERT INTO gallary(u_id,title) values('$u_id','All')");
   echo("<script>alert('회원가입이 완료되었습니다!'); location.href='./login.php';</script>");

?>