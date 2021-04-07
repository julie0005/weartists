<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include "../../db.php";
$profile_dir="../../temp/profile";
$image_dir="../../temp";
$paging=3;

    if(isset($_SESSION['u_id'])){
        $visitorid=$_SESSION['u_id'];
        $result=mysqli_query($db, "SELECT photo,nickname from user where u_id={$visitorid}") or die("visitor select fails.".mysqli_error($db));
        $row=mysqli_fetch_assoc($result);
        $v_photo=$row['photo'];
        $v_name=$row['nickname'];
    }
    else{
        echo "<script>location.href='../login.php'</script>";
        exit();
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
            <link rel="stylesheet" href="./feedstyle.css">
            <meta name="description" content="우리 모두는 화가입니다.">
    </head>
    <body>
        <!-- Header -->
       
        <div id="header_all">
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
                <?php
                    if(!isset($_SESSION['u_id'])){
                        //방문자
                ?>
                <div id=header_account>
                    <a href="../login.php">로그인</a>
                    <a href="../register.php">회원가입</a>
                </div>
                <?php } else{
                        //로그인한 사람
                ?>
                    <div id=header_account>
                        <a href="../user/index.php">MY</a>
                        <a href="../logout.php">로그아웃</a>
                    </div>
                <?php } ?>
            </header>
            <nav class="top-nav bold">
                <div id=topnav-container>
                    <a href="../main.php">Home</a>
                    <a href="../topic/index.php">주제</a>
                    <a href="../workboard.php">워크보드</a>
                    <a href="./feed/index.php">피드</a>
                </div>
            </nav>
        </div>
        <!-- SideBar -->
        <main>
            <div class="sidebar-container">
                <div class="sidebar-logo">
                <a href="../user/index.php">
                <u class="medium">
                    
                    <?php 
                        echo "{$v_name}";
                    ?>
                    
                </u></a>님, 안녕하세요!
                </div>
                <ul class="sidebar-navigation">
                <li class="header medium">마이페이지</li>
                <li>
                    <a href="../user/gallary.php">
                     갤러리
                    </a>
                </li>
                <li>
                    <a href="../user/shop.php">
                     상점
                    </a>
                </li>
                <li class="header medium">구독</li>
                <?php
                    $query="SELECT user.nickname, user.u_id from user inner join subscription on user.u_id=subscription.target_id where subscription.u_id={$visitorid}";
                    $result=mysqli_query($db,$query) or die("select subscribe target fails.".mysqli_error($db));
                    if(mysqli_num_rows($result)==0){
                        $empty=1;
                    }
                    while($row=mysqli_fetch_assoc($result)){
                ?>
                <li>
                    <a href="../user/other.php?id=<?php echo "{$row['u_id']}";?>">
                     <?php echo "{$row['nickname']}"; ?>
                    </a>
                </li>
                <?php }?>
                </ul>
            </div>
                    
            <!-- Main Contents -->
            <section class="feed">
                <?php if(isset($empty)){?>
                    <!-- 구독한 사람이 존재하지 않는 경우 -->
                    <div class="nosubscribe"><p style="margin-bottom:20px;">아직 구독한 작가가 없습니다.<br>워크보드에서 작품을 탐험하고 작가를 구독하세요!</p>
                    <a class="bold nosublink" href="../workboard.php">워크보드</a>
                    </div>

                <?php } ?>
                <ul>
                
                <?php

                    $query="SELECT * from work where u_id in (select user.u_id from user inner join subscription on user.u_id=subscription.target_id where subscription.u_id={$visitorid}) order by update_date desc limit {$paging}";
                    $result0=mysqli_query($db,$query) or die("구독한 사람들의 작품들 최신순으로 가져오기 실패".mysqli_error($db));
                    while($row=mysqli_fetch_assoc($result0)){
                        $w_id=$row['w_id'];
                        $authorid=$row['u_id'];
                        $title=$row['title'];
                        $description=$row['description'];
                        $update_date=$row['update_date'];
                        $image=$row['image'];
                        $views=$row['views'];
                        $likes=$row['likes'];
                        $s_id=$row['s_id'];
                        $comments=$row['comments'];
                        $result2=mysqli_query($db,"SELECT photo,nickname from user where u_id={$authorid}") or die("작품 작가 조회 실패.".mysqli_error($db));
                        $row2=mysqli_fetch_assoc($result2);
                        $author=$row2['nickname'];
                        $author_img=$row2['photo'];
                        

                ?>
                    <li>
                        <article class="gallary-container">
                            <div class="post-info">
                                <div class=post-maininfo>
                                    <img class="user-profile" src="<?php echo "{$profile_dir}/{$author_img}"?>" alt=<?php echo "{$author_img}"?>>
                                    <h2 class="title text bold"><?php echo "{$title}"?></h2>
                                    <a href="../user/other.php?id=<?php echo "{$authorid}"?>"><p class="username text medium"><?php echo "{$author}"?></p></a>
                                </div>
                                <div class="post-subinfo">
                                    <p class="update"><?php echo "{$update_date}"?></p>
                                    <p class="pageview"><?php echo "{$views}"?>회</p>
                                </div>
                            </div>
                            <div class="body-contents">
                                <img class="body-image" src="<?php echo "{$image_dir}/{$image}"?>" alt="작품">
                            </div>
                            <div class="icon-bar">
                                <?php
                                if(isset($_SESSION['u_id'])){
                                ?>
                                    <button type='button' class='like' value=<?php echo "{$w_id}"?>>
                                <?php
                                    $result=mysqli_query($db, "SELECT * FROM `like` WHERE u_id={$visitorid} AND w_id={$w_id}") or die("like 테이블 조회 실패.".mysqli_error($db));
                                    if(mysqli_num_rows($result)==0){
                                        echo "<i class='far fa-heart' aria-hidden='true'></i>";
                                    }
                                    else{
                                        echo "<i class='fa fa-heart' aria-hidden='true'></i>";
                                    }
                                    echo "</button>";
                                } else{
                                ?>
                                    <a href="./login.php"><i class='far fa-heart' aria-hidden='true'></i></a>
                                <?php } ?>    
                                <!-- 좋아요 -->

                                <?php if($s_id!=NULL){?>
                                <a><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>
                                <?php }?>
                                <!-- 쇼핑 -->
                                
                                <button type="button" class="expand" value="<?php echo "{$image_dir}/{$image}"?>"><i class="fa fa-expand" aria-hidden="true"></i></button>
                                <!--  -->
                                <?php if(isset($_SESSION['u_id']) && $_SESSION['u_id']==$authorid){?>
                                <form method=POST action="../user/update-work.php">
                                    <input type=hidden value="<?php echo "{$w_id}";?>" name="w_id">
                                    <input type=hidden value="<?php echo "{$authorid}";?>" name="u_id">
                                    <button><i class="fa fa-edit" style="font-size:1.3rem;" aria-hidden="true"></i></button>
                                </form>
                                <form method=POST action="../user/delete.php">
                                    <input type=hidden value="<?php echo "{$w_id}";?>" name="w_id">
                                    <input type=hidden value="<?php echo "{$authorid}";?>" name="u_id">
                                    <input type=hidden value="<?php echo "{$s_id}";?>" name="s_id">
                                    <input type=hidden value="<?php echo "{$image}";?>" name="image">
                                    <button><i class="fa fa-trash" style="font-size:1.3rem;" aria-hidden="true"></i></button>
                                </form>
                                <?php }?>
                                <p style="font-size:1.0rem; margin:auto 0; position:absolute; right:30px;" class="medium likeCount"><?php echo "{$likes}";?> likes</p>
                            </div>
                            <div class="description">
                                    <p name="description"><?php echo "{$description}"?></p>
                            </div>
                        </article>
                        <div class="comments-container">
                            <div class="comments-header">
                                <div class=group>
                                    <a href="../work.php?id=<?php echo "{$w_id}"?>#comments-loc"><h4 class="text">View Comments</h4></a>
                                    <p class="count text regular"><?php echo "{$comments}"?></p>
                                </div>
                            </div>
                        </div>
                        
                    </li>
                    <?php } ?>
                </ul>
            </section>
            <aside>
                <div>
                    Here is Aside
                </div>
            </aside>
            <div class="modal" style="display:none;">
                <div class="bg"></div>
                <div class="modalBox">
                    <img class="body-image" src=<?php echo "{$image_dir}/{$image}";?> alt="작품">
                    <button class="closeBtn bold">X</button>
                </div>
            </div>
        </main>
       <script src="../js/input_limit.js"></script>
       <script src="../js/expand.js"></script>
        <script>
            //좋아요 스크립트
            //동시 접속. 나와 나는 동시 접속이 안되지만 나와 타인은 동시 접속이 가능하게하려면..?
            $('.like').dblclick(likeClick);

            function likeClick(){
                var accessableCount=1;
                accessableCount  = accessableCount -1;
                if(accessableCount>=0){
                    var likeObj=$(this);
                    var w_id=likeObj.attr('value');
                    $.ajax({
                        url:"../ajax/ajax-like.php",
                        type:"POST",
                        dataType:'json',
                        data:{
                            'type':0,
                            'w_id':w_id,
                            'u_id':<?php if(isset($visitorid)){echo "{$visitorid}";} else {echo "-1";}?>
                        },
                        success : function(data){
                            
                            if(data[0].success){
                                alert("좋아요 성공!");
                                let likeCount=data[0].likes;
                                likeObj.html("<i class='fa fa-heart' aria-hidden='true'>");
                                likeObj.parent('div.icon-bar').children('p.likeCount').html(likeCount+" likes");
                            }
                            else{
                                alert("좋아요를 이미 하셨습니다.");
                            }
                            accessableCount  = accessableCount+1;
                        },
                        error : function(err){
                            console.log(err);
                            accessableCount  = accessableCount+1;
                        }

                    });
                }
            }

            //피드 무한스크롤
            var next_page=2;
            var sync=true;
            $(window).on('load',function(){
                $(document).on("scroll", function(){
                    console.log("Scroll event");
                    if($(document).height()<=$(window).scrollTop()+$(window).height()+80 && sync==true){
                        sync=false;
                        $.ajax({
                            url: "../ajax/ajax-feed.php",
                            type: "POST",
                            dataType:'json',
                            data: {
                                'page':next_page,
                                'u_id':<?php echo "{$visitorid}";?>,
                                'paging':<?php echo "{$paging}";?>
                            },
                            success : function(data){
                            
                            if(data.length!=0){
                                next_page+=1;
                                $.each(data,function(key,val){
                                    var $elem=
                                        "<li><article class='gallary-container'><div class='post-info'><div class=post-maininfo>"
                                        +"<img class='user-profile' src='<?php echo "{$profile_dir}/";?>"+val.author_img+"' alt='"+val.author_img+"'>"
                                        +"<h2 class='title text bold'>"+val.title+"</h2>"
                                        +"<a href='../user/other.php?id="+val.authorid+"'><p class='username text medium'>"+val.author+"</p></a></div>"
                                        +"<div class='post-subinfo'><p class='update'>"+val.update_date+"</p>"
                                        +"<p class='pageview'>"+val.views+"회</p></div></div>"
                                        +"<div class='body-contents'><img class='body-image' src='<?php echo "{$image_dir}/";?>"+val.image+"' alt='"+val.image+"'></div>"
                                        +"<div class='icon-bar'><button type='button' class='like' value="+val.w_id+">";
                                    if(val.liked){
                                        $elem+="<i class='fa fa-heart' aria-hidden='true'></i>";
                                    }
                                    else{
                                        $elem+="<i class='far fa-heart' aria-hidden='true'></i>";
                                    }
                                    $elem+="</button>"
                                    if(val.s_id!=''){
                                        $elem+="<a><i class='fa fa-shopping-bag' aria-hidden='true'></i></a>";
                                    }
                                    $elem+="<button type='button' class='expand' value='<?php echo "{$image_dir}/";?>"+val.image+"'><i class='fa fa-expand' aria-hidden='true'></i></button>"
                                        +"<p class='medium likeCount'>"+val.likes+" likes</p></div>"
                                        +"<div class='description'><p name='description'>"+val.description+"</p></div></article>"
                                        +"<div class='comments-container'><div class='comments-header'><div class='group'>"
                                        +"<a href='../work.php?id="+val.w_id+"#comments-loc'><h4 class='text'>View Comments<h4></a>"
                                        +"<p class='count text regular'>"+val.comments+"</p></div></div></div>"
                                        +"</li>"

                                    $("section.feed ul").append($elem);                   
                                });
                            }
                            sync=true;
                            $('.like').off('dblclick').dblclick(likeClick);
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
