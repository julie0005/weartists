<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include "../../db.php";
if(!isset($_SESSION['u_id'])){
    echo "<script>alert('로그인이 필요합니다.'); location.href='../login.php';</script>";
}
else{
    if($_SESSION['u_id']!=$_POST['u_id']) echo "<script>alert('이용할 수 없는 페이지입니다.'); history.back();</script>";
    else{$u_id=$_POST['u_id'];}
}
$w_id=$_POST['w_id'];
$s_id=$_POST['s_id'];
$result=mysqli_query($db, "DELETE FROM work WHERE w_id={$w_id}") or die("work table delete fails.").mysqli_error($db);
if($s_id!=NULL){
    $result=mysqli_query($db, "DELETE FROM shop WHERE s_id={$s_id}") or die("shop table delete fails.").mysqli_error($db);
}
unlink("../../temp/{$_POST['image']}");
mysqli_query($db, "UPDATE user SET works=works-1 WHERE u_id={$u_id}") or die("views decrement fails.".mysqli_error($db));
mysqli_query($db, "DELETE FROM pair WHERE w_id={$w_id}") or die("pair delete fails.".mysqli_error($db));
echo "<script>alert('삭제가 완료되었습니다.'); location.href='./gallary.php'</script>";

?>