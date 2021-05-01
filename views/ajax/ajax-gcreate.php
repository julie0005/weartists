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
        $title=$_POST['title'];
        $u_id=$_SESSION['u_id'];
        $object=new stdClass();
        $object->logged = true;
        
        $query="INSERT into gallary(`u_id`, `title`, `thumbnail`) values({$u_id},'{$title}', 'blank.jpg')";
        $result=mysqli_query($db, $query) or die("gallary insert fails.".mysqli_error($db));
        $g_id=mysqli_insert_id($db);
        $object->g_id = $g_id;
        $object->title=$title;
        $object->thumbnail='blank.jpg';
        
        $arr[]=$object;
        unset($object);
        echo json_encode($arr);
    
    }



?>