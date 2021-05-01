<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include "../../db.php";
if(!isset($_SESSION['u_id'])){
    echo "<script>alert('로그인이 필요합니다.'); location.href='../login.php';</script>";
}
else{
    $u_id=$_SESSION['u_id'];
}
$uploads_dir='../../temp';
$category=$_POST['category'];
$title=addslashes($_POST['title']);
    if($category==='work'){
        $artist_statement=addslashes($_POST['artist-statement']);
        $g_id=$_POST['g_id'];
        $t_id=$_POST['t_id'];
        $result=mysqli_query($db, "SELECT * FROM gallary WHERE u_id={$u_id} AND title='All'");
        $row=mysqli_fetch_assoc($result);
        $all_g_id=$row['g_id'];
        if($g_id==""){
            $g_id=$all_g_id;
        }
        if($t_id==""){
            $t_id=11;
        }
        
        if(isset($_FILES['upload'])){
            $imgname=$_FILES['upload']['name'];
            $tmp=explode('.',$imgname);
            $ext=array_pop($tmp);
            $imgname=date("YmdHis").'.'.$ext;
            move_uploaded_file($_FILES['upload']['tmp_name'],"$uploads_dir/$imgname");
            $query="INSERT INTO work(u_id, title,description, g_id,image,t_id) VALUES({$u_id},'{$title}', '{$artist_statement}',{$g_id},'{$imgname}',{$t_id})";
            $result=mysqli_query($db,$query);
            if(!$result) die("work table data insert fails.<br>\n".mysqli_error($db));
            else{
                $w_id=mysqli_insert_id($db);
                $result=mysqli_query($db, "INSERT INTO pair(w_id, g_id, u_id) VALUES({$w_id},{$all_g_id},{$u_id})") or die("pair data insert(all) fails.<br>\n".mysqli_error($db));
                if($g_id!=$all_g_id){
                    $result=mysqli_query($db, "INSERT INTO pair(w_id, g_id, u_id) VALUES({$w_id},{$g_id},{$u_id})") or die("pair data insert(gallary) fails.<br>\n".mysqli_error($db));
                }
            }
        }
        else{
            echo "NO IMG UPLOAD";
        }

        $isShop=$_POST['isShop'];
        if($isShop=='true'){
            $price=$_POST['price'];
            $query="INSERT INTO shop(w_id, price, u_id) VALUES('$w_id', '$price', '$u_id')";
            $result=mysqli_query($db, $query);
            if(!$result) die("shop table data insert fails.");
            else{
                $s_id=mysqli_insert_id($db);
            }
            $result=mysqli_query($db, "UPDATE work SET s_id={$s_id} WHERE w_id={$w_id}");
            if(!$result) die("work table s_id update fails.");
        }
        mysqli_query($db, "UPDATE user SET works=works+1 WHERE u_id={$u_id}") or die("views increment fails.".mysqli_error($db));
        echo "<script>alert('저장되었습니다.'); location.href='../work.php?id={$w_id}';</script>";
    }
    else if($category==='post'){
        $contents=$_POST['ir1'];
        echo("title : ".$title." contents : ".$contents."<br>\n");
    }
    else{
        echo("Wrong Category was sent. ".$category);
    }
    
?>