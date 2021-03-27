<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    include "../../../db.php";
    $offset=($_POST['page']-1)*20;
    $squery=$_POST['squery'];
    $query="select photo, u_id, nickname, profile,subscribers from user where nickname like '%{$squery}%' or profile like '%{$squery}%' order by create_date desc limit {$offset}, 20";
    $result=mysqli_query($db, $query) or die("subscribers select fails".mysqli_error($db));
    $arr=array();
    while($row=mysqli_fetch_assoc($result)){
        $u_id=$row['u_id'];
        $object=new stdClass();
        if(isset($_SESSION['u_id'])){
            $result2=mysqli_query($db, "SELECT COUNT(*) as cnt FROM subscription WHERE u_id={$_SESSION['u_id']} AND target_id={$u_id}") or die("구독 조회 실패.".mysqli_error($db));
            $row2=mysqli_fetch_assoc($result2);
            $cnt=$row['cnt'];
            if($cnt==0){
                $object->subscribed=false;
            }
            else{
                $object->subscribed=true;
            }
        }
        else{
            $object->subscribed=false;
        }
        $object->target_id=$row['u_id'];
        $object->t_image=$row['photo'];
        $object->t_name=$row['nickname'];
        $object->t_subscribers=$row['subscribers'];
        $arr[]=$object;
        unset($object);
    }
    echo json_encode($arr);

?>