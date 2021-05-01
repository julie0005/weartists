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
        $writing_id=$_POST['writing_id'];
        $contents=addslashes($_POST['contents']);
        $u_id=$_SESSION['u_id'];
        $object=new stdClass();
        $object->logged = true;
        
        $query="INSERT INTO comment(u_id, writing_id, contents) VALUES({$u_id},{$writing_id},'{$contents}')";
        $result=mysqli_query($db, $query) or die("comment insert fails.".mysqli_error($db));
        $c_id=mysqli_insert_id($db);
        $query="SELECT user.nickname, user.photo, comment.c_id, comment.update_date, comment.contents from user inner join comment on comment.u_id=user.u_id where c_id={$c_id}";
        $result=mysqli_query($db, $query) or die("comment select fails.".mysqli_error($db));
        $row=mysqli_fetch_assoc($result);
        $object->c_id = $c_id;
        $object->v_name=$row['nickname'];
        $object->v_photo=$row['photo'];
        $object->update_date=$row['update_date'];
        $object->contents=$row['contents'];
        
        $result=mysqli_query($db, "UPDATE work SET comments=comments+1 WHERE w_id={$writing_id}") or die("comments update fails".mysqli_error($db));
        
        $arr[]=$object;
        unset($object);
        echo json_encode($arr);
    
    }



?>