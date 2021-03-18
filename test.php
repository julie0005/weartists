<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "./db.php";
    $result=mysqli_query($db, "SELECT * FROM `like` WHERE u_id=1 AND w_id=37") or die("like 테이블 조회 실패.".mysqli_error($db));
    if(mysqli_num_rows($result)==0){
        echo "true";
    }
    else{
        //좋아요를 이미 하셨습니다.
        echo "false";
    }
    
?>