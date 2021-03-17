<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include "../db.php";
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <meta charset="UTF-8">
            <title>모두화가</title>
            <script src="https://kit.fontawesome.com/03b31c0e0f.js" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="header.css">
            <link rel="stylesheet" href="mainbody.css">
            <meta name="description" content="우리 모두는 화가입니다.">
            
            <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
            <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.js"></script>
    </head>
    <body>
        <!-- Header -->
       
        <div id="header_all">
            <header class="page-header wrapper">
                <div id=header_main>
                    <h1 class="bold logo"><a href="main.html">모두화가</a></h1>
                    <form class="search-container">
                        <input type="text" id="search-bar" placeholder="오늘은 어떤 그림을 구경할래요?">
                        <button type="submit" class="searchButton">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
                <?php
                    if(!isset($_SESSION['u_id'])){
                ?>
                <div id=header_account>
                    <a href="./login.php">로그인</a>
                    <a href="./register.php">회원가입</a>
                </div>
                <?php } else{?>
                    <div id=header_account>
                        <a href="./user/index.php">MY</a>
                        <a href="./logout.php">로그아웃</a>
                    </div>
                <?php } ?>
            </header>
            <nav class="top-nav bold">
                <div id=topnav-container>
                    <a href="main.html">Home</a>
                    <a href="./topic/index.html">주제</a>
                    <a href="./workboard.html">워크보드</a>
                    <a href="./feed/post.html">피드</a>
                </div>
            </nav>
        </div>
        <!-- Contents_Home //most views, hot gallaries, hot artists -->
       
        <main id="workboard" class="popular_contents">
        
            <div class="popular_works">
                <div class="works-header">
                    <label class="dropdown">

                        <div class="dd-button">
                          인기 순
                        </div>
                      
                        <input type="checkbox" class="dd-input" id="test">
                      
                        <ul class="dd-menu">
                          <li>최신 순</li>
                          <li>1주일 내</li>
                          <li>1달 내</li>
                          <li>1년 내</li>
                        </ul>
                        
                    </label>
                </div>
                
                <div id="ajax" class="container_works">
                    <?php
                        $query="SELECT user.nickname, work.* FROM user INNER JOIN work ON user.u_id=work.u_id ORDER BY update_date DESC LIMIT 20";
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
                            <img class="mason-image" src="../temp/<?php echo "{$image}"; ?>" alt=<?php echo "{$image}"; ?>>
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
            

        </main>     
        <script src="./js/input_limit.js"></script>
        <script src="./js/masonry.js"></script>
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
                            url: "./ajax/ajax-workboard.php",
                            type: "POST",
                            dataType:'json',
                            data: {
                                'page':next_page
                            },
                            success : function(data){
                            next_page+=1;
                            if(data.length!=0){
                                console.log(next_page);
                                $.each(data,function(key,val){
                                    var $elem=
                                        "<a href='../work.php?id="+val.w_id+"' class='mason-item' style='display:none;'>"
                                        +"<img class='mason-image' src='../temp/"+val.image+"' alt="+val.image+">"
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