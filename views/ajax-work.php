<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../db.php";
    $offset=($_POST['page']-1)*20;
    $g_id=$_POST['g_id'];
    $result=mysqli_query($db, "SELECT * FROM pair WHERE g_id={$g_id} ORDER BY `p_id` DESC LIMIT {$offset}, 20") or die("pair select fails".mysqli_error($db));
    $arr=array();
    while($row=mysqli_fetch_assoc($result)){
        $w_id=$row['w_id'];
        $result2=mysqli_query($db, "SELECT user.nickname, work.* FROM user INNER JOIN work ON user.u_id=work.u_id WHERE w_id={$w_id};") or die("work 가져오기 실패".mysqli_error($db));
        $row=mysqli_fetch_assoc($result2);
        $object=new stdClass();
        $object->image=$row['image'];
        $object->title=$row['title'];
        $object->description=$row['description'];
        $object->views=$row['views'];
        $object->likes=$row['likes'];
        $object->comments=$row['comments'];
        $object->w_id=$row['w_id'];
        $object->u_id=$row['u_id'];
        $object->s_id=$row['s_id'];
        $object->update_date=$row['update_date'];
        $object->nickname=$row['nickname'];
        $arr[]=$object;
        unset($object);
    }
    echo json_encode($arr);

?>