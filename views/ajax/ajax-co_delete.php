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
        $c_id=$_POST['c_id'];
        $object=new stdClass();
        $object->logged = true;
        $result=mysqli_query($db, "SELECT * FROM comment WHERE c_id={$c_id}") or die("comment select fails".mysqli_error($db));
        $row=mysqli_fetch_assoc($result);
        $writing_id=$row['writing_id'];
        $result=mysqli_query($db,"SELECT COUNT(*) AS cnt FROM ccomment WHERE c_id={$c_id}") or die("ccomment count fails.".mysqli_error($db));
        $row=mysqli_fetch_assoc($result);
        $decrease=$row['cnt']+1;
        $result=mysqli_query($db, "UPDATE work SET comments=comments-{$decrease} WHERE w_id={$writing_id}") or die("work comments update fails".mysqli_error($db));
        $query="DELETE FROM comment WHERE c_id={$c_id}";
        $result=mysqli_query($db, $query) or die("comment delete fails.".mysqli_error($db));
        $result=mysqli_query($db,"DELETE FROM ccomment WHERE c_id={$c_id}") or die("ccomment delete fails.".mysqli_error($db));
        $object->success=true;
        $arr[]=$object;
        unset($object);
        echo json_encode($arr);
    
    }



?>