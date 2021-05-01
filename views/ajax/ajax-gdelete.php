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
        $recursive=$_POST['recursive'];
        $u_id=$_SESSION['u_id'];
        $object=new stdClass();
        $object->logged = true;
        if($recursive==true){
            $query="DELETE FROM work WHERE g_id={$g_id}";
            $result=mysqli_query($db, $query) or die("gallary works delete fails.".mysqli_error($db));
        }
        $query="DELETE FROM gallary WHERE g_id={$g_id}";
        $result=mysqli_query($db, $query) or die("gallary delete fails.".mysqli_error($db));
        $object->success=true;
        $arr[]=$object;
        unset($object);
        echo json_encode($arr);
    
    }
?>