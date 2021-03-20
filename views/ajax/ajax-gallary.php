<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../../db.php";
    $offset=($_POST['page']-1)*20;
    $u_id=$_POST['u_id'];
    $query="SELECT * FROM gallary WHERE u_id={$u_id} ORDER BY g_id DESC LIMIT {$offset}, 20";
    $result=mysqli_query($db, $query) or die("gallary select fails".mysqli_error($db));
    $arr=array();
    while($row=mysqli_fetch_assoc($result)){
        $object=new stdClass();
        $object->g_id=$row['g_id'];
        $object->gallary_title=$row['title'];
        $object->thumbnail=$row['thumbnail'];
        $arr[]=$object;
        unset($object);
    }
    echo json_encode($arr);

?>