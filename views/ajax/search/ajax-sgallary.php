<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../../../db.php";
    $offset=($_POST['page']-1)*20;
    $squery=$_POST['squery'];
    $query="select gallary.*,user.nickname from gallary inner join user on gallary.u_id=user.u_id where gallary.title like '%{$squery}%' or user.nickname like '%{$squery}%' limit {$offset}, 20";
    $result=mysqli_query($db, $query) or die("gallary select fails".mysqli_error($db));
    $arr=array();
    while($row=mysqli_fetch_assoc($result)){
        $object=new stdClass();
        $object->gu_id=$row['u_id'];
        $object->g_id=$row['g_id'];
        $object->gallary_title=$row['title'];
        $object->thumbnail=$row['thumbnail'];
        $object->gauthor=$row['nickname'];
        $arr[]=$object;
        unset($object);
    }
    echo json_encode($arr);

?>