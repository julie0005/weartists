<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../../db.php";
    $offset=($_POST['page']-1)*20;
    $u_id=$_POST['u_id'];
    $result=mysqli_query($db, "SELECT * FROM shop WHERE u_id={$u_id} ORDER BY s_id DESC LIMIT {$offset}, 20") or die("shop select fails".mysqli_error($db));
    $arr=array();
    while($row=mysqli_fetch_assoc($result)){
        $w_id=$row['w_id'];
        $s_id=$row['s_id'];
        $price=$row['price'];
        $result2=mysqli_query($db, "SELECT image, title FROM work WHERE w_id={$w_id}") or die("work table select fails".mysqli_error($db));
        $row=mysqli_fetch_assoc($result2);
        $object=new stdClass();
        $object->image=$row['image'];
        $object->title=$row['title'];
        $object->w_id=$w_id;
        $object->s_id=$s_id;
        $object->price=$price;
        $arr[]=$object;
        unset($object);
    }
    echo json_encode($arr);

?>