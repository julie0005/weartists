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
        $contents=addslashes($_POST['contents']);
        $u_id=$_SESSION['u_id'];
        $object=new stdClass();
        $object->logged = true;
        
        $query="INSERT INTO ccomment(u_id, c_id, contents) VALUES({$u_id},{$c_id},'{$contents}')";
        $result=mysqli_query($db, $query) or die("ccomment insert fails.".mysqli_error($db));
        $cc_id=mysqli_insert_id($db);
        $query="SELECT user.nickname, user.photo, ccomment.cc_id, ccomment.update_date, ccomment.contents from user inner join ccomment on ccomment.u_id=user.u_id where cc_id={$cc_id}";
        $result=mysqli_query($db, $query) or die("ccomment select fails.".mysqli_error($db));
        $row=mysqli_fetch_assoc($result);
        $object->cc_id = $cc_id;
        $object->v_name=$row['nickname'];
        $object->v_photo=$row['photo'];
        $object->update_date=$row['update_date'];
        $object->contents=$row['contents'];
        $result=mysqli_query($db,"SELECT writing_id from comment where c_id={$c_id}") or die("comment select fails".mysqli_error($db));
        $row=mysqli_fetch_assoc($result);
        $w_id=$row['writing_id'];
        $result=mysqli_query($db, "UPDATE work SET comments=comments+1 WHERE w_id={$w_id}") or die("comments update fails".mysqli_error($db));
        
        $arr[]=$object;
        unset($object);
        echo json_encode($arr);
    
    }



?>