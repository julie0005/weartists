<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include "../../db.php";
if(isset($_GET['id'])){
    $t_id=$_GET['id'];
    $result=mysqli_query($db, "SELECT topic FROM topic WHERE t_id={$t_id}") or die("topic select fails.".mysqli_error($db));
    $row=mysqli_fetch_assoc($result);
    $topicname=$row['topic'];
}
if(!isset($t_id) || $t_id==11){
    echo "<script>alert('존재하지 않는 페이지입니다.'); location.href=history.back();</script>";
}
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <meta charset="UTF-8">
            <title>모두화가</title>
            <script src="https://kit.fontawesome.com/03b31c0e0f.js" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="../header.css">
            <link rel="stylesheet" href="../mainbody.css">
            <meta name="description" content="우리 모두는 화가입니다.">
            
            <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
            <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.js"></script>
    </head>
    <body id="topic-body">
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
                ?>
                <div id=header_account>
                    <a href="../login.php">로그인</a>
                    <a href="../register.php">회원가입</a>
                </div>
                <?php } else{
                    $u_id=$_SESSION['u_id'];
                ?>
                    <div id=header_account>
                        <a href="../user/index.php">MY</a>
                        <a href="../logout.php">로그아웃</a>
                    </div>
                <?php } ?>
            </header>
            <nav class="top-nav bold">
                <div id=topnav-container>
                    <a href="../main.php">홈</a>
                    <a href="./index.php">주제</a>
                    <a href="../workboard.php">워크보드</a>
                    <a href="../feed/index.php">피드</a>
                </div>
            </nav>
        </div>
        <!-- Contents_Home //most views, hot gallaries, hot artists -->
       
        <main id="workboard" class="popular_contents topicboard">
        
            <div class="popular_works">
                <div class="works-header" style="display:flex;">
                    <div style="display:flex;">
                        <a style="font-size:30px;margin-right:20px;" href="javascript:history.back();"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                        <h2 style="margin: auto 30px auto 0;"><?php echo "{$topicname}"?></h2>
                    </div>
                    <label class="dropdown">

                        <div class="dd-button">
                          최신순
                        </div>
                      
                        <input type="checkbox" class="dd-input" id="test">
                      
                        <ul class="dd-menu">
                          <li>인기순</li>
                          <li>1주일 내</li>
                          <li>1달 내</li>
                          <li>1년 내</li>
                        </ul>
                        
                    </label>
                </div>
                <?php
                    $query="SELECT COUNT(*) as cnt FROM user INNER JOIN work ON user.u_id=work.u_id WHERE work.t_id={$t_id}";
                    $result=mysqli_query($db,$query);
                    $row=mysqli_fetch_assoc($result);
                    $cnt=$row['cnt'];
                    if($cnt==0){
                            
                            echo "<div class='msg'>작품이 존재하지 않습니다.<br>해당 주제로 첫 게시글을 올리는 주인공이 되어보세요!<br><br>
                                    <a href='../user/write-work.php' class='bold'>글쓰기</a>
                                </div>";
                        
                    }
                    if($cnt!=0){
                ?>
                <div id="ajax" class="container_works">
                    <?php
                       
                        $query="SELECT user.nickname, work.* FROM user INNER JOIN work ON user.u_id=work.u_id WHERE work.t_id={$t_id} ORDER BY update_date DESC LIMIT 20";
                        $result=mysqli_query($db, $query) or die("work select fails".mysqli_error($db));
                        while($row=mysqli_fetch_assoc($result)){
                            $w_id=$row['w_id'];
                            $image=$row['image'];
                            $title=$row['title'];
                            $description=$row['description'];
                            $views=$row['views'];
                            $likes=$row['likes'];
                            $comments=$row['comments'];
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
                <?php } ?>
                
            </div>
            

        </main>     
        <script src="../js/input_limit.js"></script>
        <script src="../js/masonry.js"></script>
            <script type="text/javascript"> 
            var next_page=2;
            var sync=true;
            $(window).scrollTop(300);
            $(window).on('load',function(){
                $(document).on("scroll", function(){
                    console.log("Scroll event");
                    if($(document).height()<=$(window).scrollTop()+$(window).height()+80 && sync==true){
                        sync=false;
                        console.log("ajax before next_page : "+next_page);
                        $.ajax({
                            url: "./ajax/ajax-topic.php",
                            type: "POST",
                            dataType:'json',
                            data: {
                                'page':next_page,
                                't_id':<?php echo "{$t_id}"?>
                            },
                            success : function(data){
                           
                            if(data.length!=0){
                                next_page+=1;
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
                                    sync=true;
                                });
                               
                            }
                            else{
                                sync=true;
                            }
                            
                    
                            },
                            error : function(err){
                                console.log(err);
                            }
                        });
                    }
                });
            });
            

        </script>
        
        
    </body>
</html>