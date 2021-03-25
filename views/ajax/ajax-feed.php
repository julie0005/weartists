<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../../db.php";
    $paging=$_POST['paging'];
    $offset=($_POST['page']-1)*$paging;
    $u_id=$_POST['u_id'];
    $visitorid=$_SESSION['u_id'];
    $query="SELECT * from work where u_id in (select user.u_id from user inner join subscription on user.u_id=subscription.target_id where subscription.u_id={$visitorid}) order by update_date desc limit {$offset},{$paging}";
    $result=mysqli_query($db, $query) or die("subscribe work select fails".mysqli_error($db));
    $arr=array();
    while($row=mysqli_fetch_assoc($result)){
        $object=new stdClass();
        $object->w_id=$row['w_id'];
        $w_id=$row['w_id'];
        $object->authorid=$row['u_id'];
        $authorid=$row['u_id'];
        $object->title=$row['title'];
        $object->description=$row['description'];
        $object->update_date=$row['update_date'];
        $object->image=$row['image'];
        $object->views=$row['views'];
        $object->likes=$row['likes'];
        $object->s_id=$row['s_id'];
        $object->comments=$row['comments'];
        $result2=mysqli_query($db,"SELECT photo,nickname from user where u_id={$authorid}") or die("작품 작가 조회 실패.".mysqli_error($db));
        $row2=mysqli_fetch_assoc($result2);
        $object->author=$row2['nickname'];
        $object->author_img=$row2['photo'];
        $result3=mysqli_query($db, "SELECT * FROM `like` WHERE u_id={$visitorid} AND w_id={$w_id}") or die("like 테이블 조회 실패.".mysqli_error($db));
        if(mysqli_num_rows($result3)==0){
            $object->liked=false;
        }
        else{
            $object->liked=true;
        }
        $arr[]=$object;
        unset($object);
    }
    echo json_encode($arr);

?>