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
    echo "<script>alert('존재하지 않는 사용자입니다.') location.href=history.back();</script>";
}
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
            <meta charset="UTF-8">
            <title>모두화가</title>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css"/>
            <link rel="stylesheet" href="../header.css">
            <link rel="stylesheet" href="./index.css">
            <meta name="description" content="우리 모두는 화가입니다.">
    </head>
    <body id="user">
        <!-- Header -->
        <header class="page-header wrapper">
            <div id=header_main>
                <h1 class="bold logo"><a href="../main.php">모두화가</a></h1>
                <form class="search-container" id="search-form" onsubmit="return checkSearch()">
                    <input type="text" id="search-bar" placeholder="오늘은 어떤 그림을 구경할래요?">
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
                        <div class="wrapper" id="subscribe-wrapper">
                            <ul class="works-container">
                                <?php
                                    $query="select user.photo, user.nickname, user.subscribers, subscription.target_id from user inner join subscription on subscription.target_id=user.u_id where subscription.u_id={$u_id} limit 16";
                                    $result=mysqli_query($db,$query) or die("subscribe select fails. ".mysqli_error($db));
                                    while($row=mysqli_fetch_assoc($result)){
                                        $target_id=$row['target_id'];
                                        $t_image=$row['photo'];
                                        $t_name=$row['nickname'];
                                        $t_subscribers=$row['subscribers'];
                                ?>

                                <li>
                                    <div><img src="../../temp/profile/<?php echo "{$t_image}"; ?>" class="artist-profile" alt="<?php echo "{$t_image}"; ?>">
                                        <a href="./other.php?id=<?php echo"{$target_id}"; ?>" class="artist-name bold"><?php echo "{$t_name}"; ?></a>
                                        <div class="artist-info">
                                            <div class="follower-info"><p class="artist-followers"><?php echo "{$t_subscribers}"; ?></p>&nbsp;구독자</div>
                                        </div>
                                    </div>
                                </li>
                               
                                <?php } ?>
                                

                            </ul>
                        </div>
                


            </div>
        </main>
        
        
       <script src="../js/input_limit.js">
       </script>
       <script src="../js/subscribe.js"></script>
       <script type="text/javascript">
            //구독 폴더 infinite scroll.  
            var next_page=2;
            var sync=true;
            $(window).on('load',function(){
                $(document).on("scroll", function(){
                    if($(document).height()<=$(window).scrollTop()+$(window).height()+80 && sync==true){
                        sync=false;
                        $.ajax({
                            url: "../ajax/ajax-getsub.php",
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
                                            "<li class='subitem' style='display:none;'><div><img src='../../temp/profile/"+val.t_image+"' class='artist-profile' alt='"+val.t_image+"'>"
                                            +"<a href='./other.php?id="+val.target_id+"' class='artist-name bold'>"+val.t_name+"</a>"
                                            +"<div class='artist-info'><div class='follower-info'><p class='artist-followers'>"+val.t_subscribers+"</p>&nbsp;구독자</div>"
                                            +"</div></div></li>"
                                            $("#ajax").append($elem);

                                    });
                                    $('#ajax').imagesLoaded(function(){
                                        $("li.subitem").css('display','block');
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
