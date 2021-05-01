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
        $g_id=$_POST['g_id'];
        $title=$_POST['title'];
        $object=new stdClass();
        $object->logged = true;
        $query="UPDATE gallary SET title='{$title}' WHERE g_id={$g_id}";
        $result=mysqli_query($db, $query) or die("gallary update fails.".mysqli_error($db));
        $object->success=true;
        $arr[]=$object;
        unset($object);
        echo json_encode($arr);
    
    }
?>