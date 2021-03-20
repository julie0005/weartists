<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../../db.php";
    if(!isset($_SESSION['u_id'])){
        $object=new stdClass();
        $object->logged = false;
        $arr[]=$object;
        unset($object);
        echo json_encode($arr);
        exit();
    }
    else{
        $substatus=$_POST['substatus'];
        $target_id=$_POST['target_id'];
        $u_id=$_SESSION['u_id'];
        $object=new stdClass();
        $object->logged = true;
        
        if($substatus==0){
            //아직 구독하지 않은 경우
            $result=mysqli_query($db, "INSERT INTO subscription(u_id, target_id) VALUES({$u_id},{$target_id})") or die("subscription insert fails.".mysqli_error($db));
            $f_id=mysqli_insert_id($db);
            $result=mysqli_query($db, "SELECT user.nickname from user inner join subscription on subscription.target_id=user.u_id WHERE subscription.f_id={$f_id}") or die("subscription 조회 실패.".mysqli_error($db));
            $row=mysqli_fetch_assoc($result);
            $object->subscribe = true;
            $object->target=$row['nickname'];
            $arr[]=$object;
            unset($object);

            $result=mysqli_query($db, "UPDATE user SET subscribers=subscribers+1 WHERE u_id={$target_id}") or die("target subscribers update fails".mysqli_error($db));
            echo json_encode($arr);
        }
        else if($substatus==1){
            //구독한 경우(구독 취소)
                $result=mysqli_query($db, "SELECT user.nickname, subscription.f_id from user inner join subscription on subscription.target_id=user.u_id WHERE subscription.u_id={$u_id} AND subscription.target_id={$target_id}") or die("subscription 조회 실패.".mysqli_error($db));
                $row=mysqli_fetch_assoc($result);
                $f_id=$row['f_id'];
                $object->target=$row['nickname'];

                $result=mysqli_query($db, "DELETE FROM subscription WHERE f_id={$f_id}") or die("subscription delete fails".mysqli_error($db));
                $object->subscribe = false;
                
                $arr[]=$object;
                unset($object);
                $result=mysqli_query($db, "UPDATE user SET subscribers=subscribers-1 WHERE u_id={$target_id}") or die("target subscribers update fails".mysqli_error($db));
                echo json_encode($arr);
            
        }
    
    }



?>