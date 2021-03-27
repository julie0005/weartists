<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../../db.php";
    $column=$_POST['column'];
    $string=$_POST['string'];
    $query="SELECT COUNT(*) as cnt FROM user WHERE {$column}='{$string}'";
    $result=mysqli_query($db,$query) or die("중복 조회 실패.".mysqli_error($db));
    $row=mysqli_fetch_assoc($result);
    $cnt=$row['cnt'];
    
    $object=new stdClass();
    if($cnt==0){
        $object->success=true;
    }
    else{
        $object->success=false;
    }
    $arr[]=$object;
    unset($object);
    echo json_encode($arr);

?>