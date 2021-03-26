<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include "../../db.php";
$profile_dir="../../temp/profile";
if(!isset($_SESSION['u_id'])){
    echo "<script>alert('로그인이 필요합니다.'); location.href='../login.php';</script>";
}
else{
    $u_id=$_SESSION['u_id'];
    $query="SELECT * FROM user WHERE u_id={$u_id}";
    $result=mysqli_query($db, $query);
    if(!$result){
        die("user 조회 fails.<br>\n".mysqli_error($db));
    }
    else{
        $row=mysqli_fetch_assoc($result);
        $author=$row['nickname'];
        $profile_photo=$row['photo'];
        $works=$row['works'];
        $subscribers=$row['subscribers'];
        $profile=$row['profile'];
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
                        <label class="dropdown">
                            <div class="dd-button">
                              글쓰기
                            </div>
                          
                            <input type="checkbox" class="dd-input" id="test">
                          
                            <ul class="dd-menu">
                            <li style="width:80px; text-align:center;"><a href="./write-work.php">작품</a></li>
                            </ul>
                        </label>
                        
                        <button class="dd-button">
                            설정
                            <i class="fas fa-cog"></i>
                        </button>
                        
                    </div>
                </div>
                <!-- user header -->
                <nav class="user-nav medium">
                    <div id=usernav-container>
                        <a href="./index.php">홈</a>
                        <a href="./gallary.php">갤러리</a>
                        <a href="./shop.php">상점</a>
                        <a href="./subscribe.php">구독</a>
                    </div>
                </nav>
                <!-- user home -->
                <div class="wrapper" id="works-wrapper">
                    <div class="subcontainer">

                        <?php
                        //숫자 하나를 가져오기 위해 쿼리를 보내는 것이 맞나. 
                        $result=mysqli_query($db, "SELECT COUNT(*) AS cnt FROM shop WHERE u_id={$u_id}") or die("shop count fails".mysqli_error($db));
                        $row=mysqli_fetch_assoc($result);
                        $shopCount=$row['cnt'];
                        $result=mysqli_query($db, "SELECT * FROM shop WHERE u_id={$u_id} ORDER BY s_id DESC LIMIT 20") or die("shop select fails".mysqli_error($db));
                        
                        ?>
                        <div class="user-title">
                            <div class="titleinfo">
                                <p class="medium maininfo">상점</p>
                                <p id="postcnt"><?php echo "{$shopCount}"; ?></p>
                            </div>
                        </div>
                        <div id="ajax" class="container_works">
                        <?php
                            while($row=mysqli_fetch_assoc($result)){
                                $w_id=$row['w_id'];
                                $s_id=$row['s_id'];
                                $price=$row['price'];
                                $result2=mysqli_query($db, "SELECT image, title FROM work WHERE w_id={$w_id}") or die("work table select fails".mysqli_error($db));
                                $row=mysqli_fetch_assoc($result2);
                                $image=$row['image'];
                                $title=$row['title'];
                            ?>
                            <a href="#" class="mason-item">
                                <img class="mason-image" src="../../temp/<?php echo "{$image}"; ?>" alt="<?php echo "{$image}"; ?>">
                                <div class="goods-info">
                                    <p id="title-value"><?php echo "{$title}"; ?></p>
                                    <div class="subinfo">
                                        <div class="price"><p class="bold" id="price-value"><?php echo "{$price}"; ?></p>&nbsp;원</div>
                                        <div class="artist">작가&nbsp;<p id="artist-value"><?php echo "{$author}"; ?></p></div>
                                    </div>
                                </div>
                            </a>
                            <?php
                            }
                            ?>
                            
                        </div>
                    </div>
                </div>
                <!--maincontets-->
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
                        $.ajax({
                            url: "../ajax/ajax-shop.php",
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
                                            "<a href='#' class='mason-item' style='display:none;'>"
                                            +"<img class='mason-image' src='../../temp/"+val.image+"' alt="+val.image+">"
                                            +"<div class='goods-info'>"
                                            +"<p id='title-value'>"+val.title+"</p>"
                                            +"<div class='subinfo'>"
                                            +"<div class='price'><p class='bold' id='price-value'>"+val.price+"</p>&nbsp;원</div>"
                                            +"<div class='artist'>작가&nbsp;<p id='artist-value'>"+<?php echo "{$author}";?>+"</p></div>"
                                            +"</div></div></a>"
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
