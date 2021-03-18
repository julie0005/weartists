<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include "../../db.php";
if(!isset($_SESSION['u_id'])){
    echo "<script>alert('로그인이 필요합니다.'); location.href='../login.php';</script>";
}
else{
    if($_SESSION['u_id']!=$_POST['u_id']) echo "<script>alert('이용할 수 없는 페이지입니다.'); history.back();</script>";
    else{$u_id=$_SESSION['u_id'];}
}
$uploads_dir='../../temp';
$category=$_POST['category'];
$title=addslashes($_POST['title']);
    if($category==='work'){
        $previmg=$_POST['previmg'];
        $w_id=$_POST['w_id'];
        $artist_statement=addslashes($_POST['artist-statement']);
        $g_id=$_POST['g_id'];
        $t_id=$_POST['t_id'];
        if($t_id==""){
            $t_id=11;
        }
        $isShop=$_POST['isShop'];
        //user의 all 폴더 고유 아이디.
        $result=mysqli_query($db,"SELECT * FROM gallary WHERE u_id={$u_id} AND title='All'") or die("gallary 조회 실패.<br>\n".mysqli_error($db));
        $row=mysqli_fetch_assoc($result);
        $all_g_id=$row['g_id']; 

        //기존 갤러리-작품 연결 상태
        $result=mysqli_query($db, "SELECT * FROM pair WHERE u_id={$u_id} AND w_id={$w_id}") or die("pair 조회 실패.<br>\n".mysqli_error($db));
        while($row=mysqli_fetch_assoc($result)){
            if($row['g_id']!=$all_g_id){
                $p_id=$row['p_id']; //all이 아닌 folder
            }
        }
        if(mysqli_num_rows($result)>1){
            //기존 : all + 사용자가 다른 폴더도 선택함
            if($g_id==$all_g_id){
                //수정 후 : 사용자가 아무 폴더 선택 안함.(all 만 함)
                $result=mysqli_query($db, "DELETE FROM pair WHERE u_id={$u_id} AND w_id={$w_id} AND g_id!={$all_g_id}") or die("all 폴더 제외 연결 쌍 해제 실패.".mysqli_error($db));
            }
            else{
                $result=mysqli_query($db, "UPDATE pair SET g_id={$g_id} WHERE p_id={$p_id}") or die("pair에서 g_id 수정 실패.".mysqli_error($db));
            }
        }
        else{
            //기존 : all만 있는 상태.
            if($g_id!=$all_g_id){
                //사용자가 수정한 후의 갤러리가 all이 아님.
                $result=mysqli_query($db, "INSERT INTO pair(w_id,g_id,u_id) VALUES({$w_id},{$g_id},{$u_id})") or die("all 말고 다른 pair 추가 실패.".mysqli_error($db));
            }
        }
        
        if(isset($_FILES['upload'])){
            unlink("../../temp/{$previmg}");
            $imgname=$_FILES['upload']['name'];
            $tmp=explode('.',$imgname);
            $ext=array_pop($tmp);
            $imgname=date("YmdHis").'.'.$ext;
            move_uploaded_file($_FILES['upload']['tmp_name'],"$uploads_dir/$imgname");
            $query="UPDATE work SET title='{$title}', description='{$artist_statement}', g_id={$g_id}, image='{$imgname}', t_id={$t_id}, update_date=now() WHERE w_id={$w_id}";
            $result=mysqli_query($db,$query);
            if(!$result) die("work table data update fails.<br>\n".mysqli_error($db));
        }
        else{
            echo "NO IMG UPLOAD";
        }
        if($isShop=='true'){
            $s_id=$_POST['s_id'];
            $price=$_POST['price'];
            if($s_id==""){
                $query="INSERT INTO shop(w_id, price, u_id) VALUES({$w_id},{$price},{$u_id})";
                $result=mysqli_query($db, $query) or die("shop table data insert fails.".mysqli_error($db));
                $s_id=mysqli_insert_id($db);
                $result=mysqli_query($db, "UPDATE work SET s_id={$s_id} WHERE w_id={$w_id}");
                if(!$result) die("work table s_id update fails.");
            }
            else{
                $query="UPDATE shop SET price={$price} WHERE s_id={$s_id}";
                $result=mysqli_query($db, $query) or die("shop table data update fails.");
            }
        }
        else if($isShop=='false'){
            $s_id=$_POST['s_id'];
            if($s_id!=""){
                $result=mysqli_query($db, "DELETE FROM shop WHERE s_id={$s_id}") or die("상점 데이터 삭제 실패");
                $result=mysqli_query($db, "UPDATE work SET s_id=NULL WHERE w_id={$w_id}") or die("work update fails in shop.");
            }
        }
        echo "<script>alert('수정되었습니다.'); location.href='../work.php?id={$w_id}';</script>";
    }
    else if($category==='post'){
        $contents=$_POST['ir1'];
        echo("title : ".$title." contents : ".$contents."<br>\n");
    }
    else{
        echo("Wrong Category was sent. ".$category);
    }
    
?>