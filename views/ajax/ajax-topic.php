<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../../db.php";
    $offset=($_POST['page']-1)*20;
    $t_id=$_POST['t_id'];
    if($_POST['orderby']=="popular"){
        $orderby='views+likes+comments';
    }
    else{
        $orderby='update_date';
    }
    $date=$_POST['datelimit'];
    $query="SELECT user.nickname, work.* FROM user INNER JOIN work ON user.u_id=work.u_id WHERE work.t_id={$t_id} ";
    if($date!=''){
        $query.="and work.update_date>date_add(now(),interval-{$date}) ";
    }
    $query.="ORDER BY {$orderby} DESC LIMIT {$offset}, 20";
    $result=mysqli_query($db, $query) or die("work select fails".mysqli_error($db));
    $arr=array();
    while($row=mysqli_fetch_assoc($result)){
        $w_id=$row['w_id'];
        $object=new stdClass();
        $object->image=$row['image'];
        $object->title=$row['title'];
        $object->description=$row['description'];
        $object->views=$row['views'];
        $object->likes=$row['likes'];
        $object->comments=$row['comments'];
        $object->u_id=$row['u_id'];
        $object->s_id=$row['s_id'];
        $object->update_date=$row['update_date'];
        $object->nickname=$row['nickname'];
        $arr[]=$object;
        unset($object);
    }
    echo json_encode($arr);

?>