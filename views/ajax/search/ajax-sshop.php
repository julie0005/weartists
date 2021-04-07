<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../../../db.php";
    $offset=($_POST['page']-1)*20;
    $squery=$_POST['squery'];
    if($_POST['orderby']=="popular"){
        $orderby='views+likes+comments';
    }
    else{
        $orderby='update_date';
    }
    $date=$_POST['datelimit'];
    $query="select shop.*, work.*, user.nickname from shop inner join work on shop.w_id=work.w_id inner join user on work.u_id=user.u_id where (user.nickname like '%{$squery}%' or work.title like '%{$squery}%' or work.description like '%{$squery}%') ";
    if($date!=''){
        $query.="and work.update_date>date_add(now(),interval-{$date}) ";
    }
    $query.="order by {$orderby} desc limit {$offset}, 20";
    $result=mysqli_query($db,$query) or die("select shop fails.".mysqli_error($db));
    $arr=array();
    while($row=mysqli_fetch_assoc($result)){
        $w_id=$row['w_id'];
        $s_id=$row['s_id'];
        $price=$row['price'];
        $object=new stdClass();
        $object->image=$row['image'];
        $object->title=$row['title'];
        $object->su_name=$row['nickname'];
        $object->w_id=$w_id;
        $object->s_id=$s_id;
        $object->price=$price;
        $arr[]=$object;
        unset($object);
    }
    echo json_encode($arr);

?>