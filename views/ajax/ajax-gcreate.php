<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../../db.php";
    $uploads_dir='../../temp/gallarythumb';
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
        if(isset($_FILES['thumbnail']['name'])) $imgname=$_FILES['thumbnail']['name'];
        if(isset($imgname)){
            $tmp=explode('.',$imgname);
            $ext=array_pop($tmp);
            $imgname=date("YmdHis").'.'.$ext;
            move_uploaded_file($_FILES['thumbnail']['tmp_name'],"$uploads_dir/$imgname");
        }
        else{
            $imgname="blank.jpg";
        }
        $object=new stdClass();
        $object->logged = true;
        
        $query="INSERT into gallary(`u_id`, `title`, `thumbnail`) values({$u_id},'{$title}', '{$imgname}')";
        $result=mysqli_query($db, $query) or die("gallary insert fails.".mysqli_error($db));
        $g_id=mysqli_insert_id($db);
        $object->g_id = $g_id;
        $object->title=$title;
        $object->thumbnail=$imgname;
        
        $arr[]=$object;
        unset($object);
        echo json_encode($arr);
    
    }
?>