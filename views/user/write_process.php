<?php
ini_set("display_errors", "1");
$uploads_dir='../../temp';
    $category=$_POST['category'];
    $title=$_POST['title'];
    $user=$_POST['username'];
    if($category==='work'){
        $artist_statement=$_POST['artist-statement'];
        if(isset($_FILES['upload'])){
            $imgname=$_FILES['upload']['name'];
            $gallary_folder=$_POST['gallary-folder'];
            $tmp=explode('.',$imgname);
            $ext=array_pop($tmp);
            $imgname=date("YmdHis").'.'.$ext;
            move_uploaded_file($_FILES['upload']['tmp_name'],"$uploads_dir/$imgname");
            echo("title : ".$title."<br>\nartist_statement : ".$artist_statement."<br>\ngallary_folder : ".$gallary_folder);
            echo "<h2>파일 정보</h2>
            <ul>
                <li>파일명: $imgname</li>
                <li>확장자: $ext</li>
                <li>파일형식: {$_FILES['upload']['type']}</li>
                <li>파일크기: {$_FILES['upload']['size']} 바이트</li>
            </ul>";
            echo ("<img src='{$uploads_dir}/{$imgname}'/>");
            }
        else{
            echo "NO IMG UPLOAD";
        }
    }
    else if($category==='post'){
        $contents=$_POST['ir1'];
        echo("title : ".$title." contents : ".$contents."<br>\n");
    }
    else{
        echo("Wrong Category was sent. ".$category);
    }
    
?>