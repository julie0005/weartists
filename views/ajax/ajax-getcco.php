<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../../db.php";
    $c_id=$_POST['c_id'];
    if(isset($_SESSION['u_id'])){
        $visitor=$_SESSION['u_id'];
    }
    else{
        $visitor=0;
    }
    $query="SELECT user.photo, user.nickname, user.u_id, ccomment.cc_id, ccomment.update_date, ccomment.contents from user inner join ccomment on user.u_id=ccomment.u_id where c_id={$c_id}";
    $result=mysqli_query($db, $query) or die("ccomment select fails".mysqli_error($db));
    $arr=array();
    while($row=mysqli_fetch_assoc($result)){
        $object=new stdClass();
        if($row['u_id']==$visitor){
            $object->isMine=true;
        }
        else{
            $object->isMine=false;
        }
        $object->photo=$row['photo'];
        $object->name=$row['nickname'];
        $object->contents=$row['contents'];
        $object->cc_id=$row['cc_id'];
        $object->update_date=$row['update_date'];
        $arr[]=$object;
        unset($object);
    }
    echo json_encode($arr);

?>