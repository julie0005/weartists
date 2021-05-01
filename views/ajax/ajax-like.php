<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../../db.php";
    $type=$_POST['type'];
    $u_id=$_POST['u_id'];
    
    if(isset($type)&&$type==0){
        //작품에 대한 좋아요
        $w_id=$_POST['w_id'];
        $arr=array();
        $result=mysqli_query($db, "SELECT * FROM `like` WHERE u_id={$u_id} AND w_id={$w_id}") or die("like 테이블 조회 실패.".mysqli_error($db));
        if(mysqli_num_rows($result)==0){
           $result=mysqli_query($db,"INSERT INTO `like`(u_id, w_id) VALUES({$u_id},{$w_id})") or die("like(work)에 insert 실패.".mysqli_error($db));
           $result=mysqli_query($db,"UPDATE work SET likes=likes+1 WHERE w_id={$w_id}") or die("work likes increment fails.".mysqli_error($db));
           $result=mysqli_query($db,"SELECT `likes` FROM work WHERE w_id={$w_id}") or die("get likes fails.".mysqli_error($db));
           $row=mysqli_fetch_assoc($result);
           $object=new stdClass();
           $object->success = true;
           $object->likes=$row['likes'];
           $arr[]=$object;
           unset($object);
           echo json_encode($arr);
        }
        else{
            //좋아요를 이미 하셨습니다.
            $object=new stdClass();
            $object->success = false;
            $arr[]=$object;
            unset($object);
            echo json_encode($arr);
        }
    }
    else if(isset($type)&&$type==1){
        //작가노트에 대한 좋아요
        $p_id=$_POST['p_id'];
    }
    else{
        die("이용할 수 없는 페이지입니다.");
    }

?>