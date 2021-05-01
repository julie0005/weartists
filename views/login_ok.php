<?php
    include "../db.php";
    $id=$_POST['id'];
    $password=$_POST['password'];
    $result=mysqli_query($db, "select * from user where id='$id'") or die ("알 수 없는 오류");

    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        $hash_pwd=$row['password'];
        if(password_verify($password,$hash_pwd)){
            $_SESSION['u_id']=$row['u_id'];
            echo "<script>location.href='./main.php';</script>";
        }
        else{
            echo "<script>alert('비밀번호가 잘못되었습니다.'); history.back();</script>";
        }
    }
    else{
        echo "<script>alert('아이디가 존재하지 않습니다.'); history.back();</script>";
    }
    
?>