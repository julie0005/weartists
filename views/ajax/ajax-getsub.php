<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../../db.php";
    $offset=($_POST['page']-1)*16;
    $u_id=$_POST['u_id'];
    $query="SELECT user.photo, user.nickname, user.subscribers, subscription.target_id from user inner join subscription on subscription.target_id=user.u_id where subscription.u_id={$u_id} limit {$offset}, 16";
    $result=mysqli_query($db, $query) or die("subscribers select fails".mysqli_error($db));
    $arr=array();
    while($row=mysqli_fetch_assoc($result)){
        $object=new stdClass();
        $object->target_id=$row['target_id'];
        $object->t_image=$row['photo'];
        $object->t_name=$row['nickname'];
        $object->t_subscribers=$row['subscribers'];
        $arr[]=$object;
        unset($object);
    }
    echo json_encode($arr);

?>