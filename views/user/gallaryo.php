<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include "../../db.php";
$profile_dir="../../temp/profile";
if(isset($_SESSION['u_id'])){

    $visitorid=$_SESSION['u_id'];
    $query="SELECT * FROM user WHERE u_id={$visitorid}";
    $result=mysqli_query($db, $query);
    if(!$result){
        die("user 조회 fails.<br>\n".mysqli_error($db));
    }
    else{
        $row=mysqli_fetch_assoc($result);
        $vauthor=$row['nickname'];
        $vphoto=$row['photo'];
    }
}
if(isset($_GET['id'])){
    $u_id=$_GET['id'];
    $result=mysqli_query($db, "SELECT * FROM user WHERE u_id={$u_id}") or die("user 조회 실패".mysqli_error($db));
    $row=mysqli_fetch_assoc($result);
    $author=$row['nickname'];
    $profile_photo=$row['photo'];
    $works=$row['works'];
    $subscribers=$row['subscribers'];
    $profile=$row['profile'];
}
else{
    echo "<script>alert('존재하지 않는 사용자입니다.'); location.href=history.back();</script>";
}

if(isset($_GET['idx'])){
    $g_id=$_GET['idx'];
    if(isset($visitorid) && $visitorid==$u_id){
        echo "<script>location.href='./gallary.php?idx={$g_id}'</script>";
        exit();
    }
    $result=mysqli_query($db, "SELECT * FROM gallary WHERE g_id={$g_id}") or die("갤러리 조회 실패.".mysqli_error($db));
    $row=mysqli_fetch_assoc($result);
    $gallary_title=$row['title'];
}
else{
    if(isset($visitorid) && $visitorid==$u_id){
        echo "<script>location.href='./gallary.php'</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <meta charset="UTF-8">
            <title>모두화가</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>
            <link rel="stylesheet" href="../header.css">
            <link rel="stylesheet" href="./index.css">
            <meta name="description" content="우리 모두는 화가입니다.">
            <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
            <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.js"></script>
    </head>
    <body id="user">
        <!-- Header -->
        <header class="page-header wrapper">
            <div id=header_main>
                <h1 class="bold logo"><a href="../main.php">모두화가</a></h1>
                <form class="search-container" id="search-form" action="../search/index.php" method="get" onsubmit="return checkSearch()">
                        <input type="text" id="search-bar" name="query" maxlength="100" placeholder="오늘은 어떤 그림을 구경할래요?">
                        <button type="submit" class="searchButton">
                            <i class="fa fa-search"></i>
                        </button>
                </form>
            </div>
            <?php if(isset($_SESSION['u_id'])){?>
            <div class="logged">
                <a href="./index.php" class="bold">MY</a>
                &nbsp;&nbsp;&nbsp;&nbsp;<a href="../logout.php" class="medium">로그아웃</a>
            </div>
            <?php } else{?>
                <div class="logged">
                    <a href="../login.php">로그인</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="../register.php">회원가입</a>
                </div>
            <?php }?>
        </header>
        <main>
            <nav class="top-nav bold">
                <div id=topnav-container>
                    <a href="../main.php">홈</a>
                    <a href="../topic/index.php">주제</a>
                    <a href="../workboard.php">워크<br>보드</a>
                    <a href="../feed/index.php">피드</a>
                </div>
            </nav>
            <div id="main-contents" class="index">
                <!-- user info -->
                <div class="user-info">
                    <div class=user-maininfo>
                        <img class="user-profile" src=<?php echo "{$profile_dir}/{$profile_photo}"; ?> alt=프로필>
                        <div class="textinfo">
                            <h3 class="username bold"><?php echo "{$author}"; ?></h3>
                            <div class="user-subinfo">
                                <span class="follower"><?php echo "{$subscribers}"; ?> 구독자</span>&nbsp;&nbsp;|&nbsp;
                                <span class="works-number"><?php echo "{$works}"; ?></span>&nbsp;작품
                            </div>
                        </div>
                    </div>
                    <div class="user-option">
                        
                            <button class="dd-button subscribebtn" style="width:80px;" value=<?php echo "{$u_id}"?>>
                                <?php
                                    if(isset($visitorid)){
                                        $result=mysqli_query($db, "SELECT * FROM subscription WHERE u_id={$visitorid} AND target_id={$u_id}") or die("구독 조회 실패.".mysqli_error($db));
                                        if(mysqli_num_rows($result)==0){
                                            echo "구독";
                                            $substatus=0;
                                        }
                                        else{
                                            echo "구독중";
                                            $substatus=1;
                                        }
                                    }
                                    else{
                                        echo "구독";
                                        $substatus=0;
                                    }
                                ?>
                                <input type="text" style="display:none;" class="substatus" value="<?php echo "{$substatus}"; ?>"></input>
                            </button>
                        
                        
                    </div>
                </div>
                <!-- user header -->
                <nav class="user-nav medium">
                    <div id=usernav-container>
                            <a href="other.php?id=<?php echo "{$u_id}"; ?>">홈</a>
                            <a href="./gallaryo.php?id=<?php echo "{$u_id}"; ?>">갤러리</a>
                            <a href="./shopo.php?id=<?php echo "{$u_id}"; ?>">상점</a>
                            <a href="./subscribeo.php?id=<?php echo "{$u_id}"; ?>">구독</a>
                    </div>
                </nav>
                <!-- user home -->
                <?php if(!isset($_GET['idx'])){?>
                
                <div class="wrapper" id="gallary-wrapper">
                    <div class="subcontainer">
                    <div class="user-title">
                        <?php
                            $result=mysqli_query($db,"SELECT COUNT(*) AS cnt FROM gallary WHERE u_id={$u_id}") or die("gallary cnt fails.".mysqli_error($db));
                            $row=mysqli_fetch_assoc($result);
                            $cnt=$row['cnt'];
                        ?>
                        <div class="titleinfo">
                            <p class="medium maininfo">갤러리</p>
                            <p id="postcnt"><?php echo "{$cnt}"?></p>
                        </div>
                    </div>
                    <div id="ajaxg" class="works-container">
                        
                        <?php
                            $query="SELECT * FROM gallary WHERE u_id={$u_id} LIMIT 20";
                            $result=mysqli_query($db,$query);
                            if(!$result){
                                die("gallary 조회 fails.<br>\n".mysqli_error($db));
                            }
                            else{
                                while($row=mysqli_fetch_assoc($result)){
                                    $g_id=$row['g_id'];
                                    $gallary_title=$row['title'];
                                    $thumbnail=$row['thumbnail'];
                        ?>    
                                <a href="./gallaryo.php?id=<?php echo "{$u_id}";?>&idx=<?php echo "{$g_id}"?>" class="item"><img src="../../temp/gallarythumb/<?php echo "{$thumbnail}"?>" alt=<?php echo "{$gallary_title}"?>>
                                <p class="gallary-name bold" id="gallary-name-default"><?php echo "{$gallary_title}"?></p>
                                </a>
                        <?php        
                                }
                                
                            }
                        ?>
                    </div>
                    </div>
                </div>
                <?php } ?>
                <?php
                    if(isset($_GET['idx'])){
                ?>
                    <div class="wrapper" id="works-wrapper">
                    <div class="subcontainer">
                        <div class="user-title">
                            <?php 
                            $result=mysqli_query($db, "SELECT COUNT(*) AS cnt FROM pair WHERE g_id={$g_id}") or die("pair count fails".mysqli_error($db));
                            $row=mysqli_fetch_assoc($result);
                            $gallaryCount=$row['cnt'];
                            ?>
                            <div class="titleinfo">
                                <a href="javascript:window.history.back()" style="margin-right:10px;"><i style="padding:0px 10px;"class="fas fa-chevron-left"></i></a> 
                                <p class="medium maininfo" id="folder-name"><?php echo "{$gallary_title}"?></p>
                                <p id="workcnt"><?php echo "{$gallaryCount}"?></p>
                            </div>
                        </div>
                        <div id= "ajax" class="container_works" style="width:100%;">
                            <?php

                                $result=mysqli_query($db, "SELECT * FROM pair WHERE g_id={$g_id} ORDER BY p_id DESC LIMIT 20") or die("pair select fails".mysqli_error($db));
                                while($row=mysqli_fetch_assoc($result)){
                                    $w_id=$row['w_id'];
                                    $result2=mysqli_query($db, "SELECT user.nickname, work.* FROM user INNER JOIN work ON user.u_id=work.u_id WHERE w_id={$w_id};") or die("work 가져오기 실패".mysqli_error($db));
                                    $row=mysqli_fetch_assoc($result2);
                                    $image=$row['image'];
                                    $title=$row['title'];
                                    $description=$row['description'];
                                    $views=$row['views'];
                                    $likes=$row['likes'];
                                    $comments=$row['comments'];
                                    $w_id=$row['w_id'];
                                    $u_id=$row['u_id'];
                                    $s_id=$row['s_id'];
                                    $update_date=$row['update_date'];
                                    $nickname=$row['nickname'];

                            ?>
                                <a href="../work.php?id=<?php echo "{$w_id}"?>" class="mason-item">
                                    <img class="mason-image" src="../../temp/<?php echo "{$image}"; ?>" alt=<?php echo "{$image}"; ?>>
                                    <div class="text_content">
                                        <p class="title"><?php echo "{$title}"; ?></p>
                                        <p class="artists"><?php echo "{$nickname}"; ?></p>
                                        <div class="sub_desciption">
                                            <i class="fas fa-heart"></i>
                                            <span class="likes"><?php echo "{$likes}"; ?></span>&nbsp;&nbsp;
                                            <i class="fas fa-comment"></i>
                                            <span class="comments"><?php echo "{$comments}"; ?></span>
                                        </div>
                                    </div>
                                </a>
                            <?php
                                }
                            ?>
                            
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </main>
        
        
        <script src="../js/input_limit.js"></script>
       <script src="../js/masonry.js"></script>
       <script src="../js/subscribe.js"></script>
       <script type="text/javascript">
            //갤러리 폴더 infinite scroll.  
            var next_page=2;
            var sync=true;
            $(window).on('load',function(){
                $(document).on("scroll", function(){
                    <?php
                        if(isset($_GET['idx'])){
                    ?>
                        return;
                    <?php } ?>
                   
                    if($(document).height()<=$(window).scrollTop()+$(window).height()+80 && sync==true){
                        sync=false;
                        $.ajax({
                            url: "../ajax/ajax-gallary.php",
                            type: "POST",
                            dataType:'json',
                            data: {
                                'page':next_page,
                                'u_id':<?php echo "{$u_id}"; ?>
                            },
                            success : function(data){
                                next_page+=1;
                                if(data.length!=0){
                                    console.log(next_page);
                                    $.each(data,function(key,val){
                                        var $elem=
                                            "<a href='./gallary.php?idx="+val.g_id+"' class='item' style='display:none;'>"
                                            +"<img src='../../temp/gallarythumb/"+val.thumbnail+"' alt="+val.thumbnail+">"
                                            +"<p class='gallary-name bold' id='gallary-name-default'>"+val.title+"</p>"
                                            +"</a>";
                                            $("#ajaxg").append($elem);
                                    });
                                    $('#ajaxg').imagesLoaded(function(){
                                        $(".item").css('display','block');
                                    });
                                }
                                sync=true;
                    
                            },
                            error : function(err){
                                console.log(err);
                                sync=true;
                            }
                        });
                    }
                });
            });

       </script>
        <script type="text/javascript"> 
            var next_page=2;
            var sync=true;
            $(window).scrollTop(300);
            $(window).on('load',function(){
                $(document).on("scroll", function(){
                    <?php
                        if(!isset($_GET['idx'])){
                    ?>
                       return;
                    <?php } ?>
                    
                    if($(document).height()<=$(window).scrollTop()+$(window).height()+80 && sync==true){
                        sync=false;
                        $.ajax({
                            url: "../ajax/ajax-work.php",
                            type: "POST",
                            dataType:'json',
                            data: {
                                'page':next_page,
                                'g_id':<?php echo "{$g_id}"; ?>
                            },
                            success : function(data){
                                next_page+=1;
                                if(data.length!=0){
                                    console.log(next_page);
                                    $.each(data,function(key,val){
                                        var $elem=
                                            "<a href='../work.php?id="+val.w_id+"' class='mason-item' style='display:none;'>"
                                            +"<img class='mason-image' src='../../temp/"+val.image+"' alt="+val.image+">"
                                            +"<div class='text_content'>"
                                            +"<p class='title'>"+val.title+"</p>"
                                            +"<p class='artists'>"+val.nickname+"</p>"
                                            +"<div class='sub_description'>"
                                            +"<i class='fas fa-heart'></i>&nbsp;"
                                            +"<span class='likes'>"+val.likes+"</span>&nbsp;&nbsp;"
                                            +"<i class='fas fa-comment'></i>&nbsp;"
                                            +"<span class='comments'>"+val.comments+"</span>"
                                            +"</div></div></a>";
                                            $("#ajax").append($elem);
                                            
                                    });
                                    $('#ajax').imagesLoaded(function(){
                                        $(".mason-item").css('display','block');
                                        $("#ajax").masonry('reloadItems');
                                        $('#ajax').masonry('layout');
                                        
                                    });
                                
                                }
                                sync=true;
                    
                            },
                            error : function(err){
                                console.log(err);
                                sync=true;
                            }
                        });
                    }
                });
            });
            

        </script>

    
    </body>
</html>
