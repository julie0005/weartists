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
        $g_id=$_POST['g_id'];
        $u_id=$_SESSION['u_id'];
        $result=mysqli_query($db, "select thumbnail from gallary where g_id={$g_id}") or die("prev thumbnail fails");
        $row=mysqli_fetch_assoc($result);
        $prev=$row['thumbnail'];
        if($prev!="blank.jpg") unlink("$uploads_dir/$prev");
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

        $query="UPDATE gallary SET thumbnail='{$imgname}' WHERE g_id={$g_id}";
        $result=mysqli_query($db, $query) or die("gallary thumbnail update fails.".mysqli_error($db));
        $object->success=true;
        $object->thumbnail=$imgname;
        $arr[]=$object;
        unset($object);
        echo json_encode($arr);
    
    }
?>