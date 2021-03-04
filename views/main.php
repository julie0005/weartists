<?php
    include "../db.php";
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
            <meta charset="UTF-8">
            <title>모두화가</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="header.css">
            <link rel="stylesheet" href="mainbody.css">
            <meta name="description" content="우리 모두는 화가입니다.">
    </head>
    <body>
        <!-- Header -->
       
        <div id="header_all">
            <header class="page-header wrapper">
                <div id=header_main>
                    <h1 class="bold logo"><a href="main.html">모두화가</a></h1>
                    <form class="search-container" id="search-form" onsubmit="return checkSearch()">
                        <input type="text" id="search-bar" placeholder="오늘은 어떤 그림을 구경할래요?">
                        <button type="submit" class="searchButton">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
                <?php
                    if(!isset($_SESSION['id'])){
                ?>
                <div id=header_account>
                    <a href="./login.php">로그인</a>
                    <a href="./register.php">회원가입</a>
                </div>
                <?php } else{?>
                    <div id=header_account>
                        <a href="./user/">MY</a>
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
        <main class="popular_contents">
        
            <div class="popular_works">
                <a class="title medium" href="#">인기 작품</a>
                <div id="main_popular"class="container_works">
                    <a href="#"><img src="../resources/starry_night.jpg" alt="별이 빛나는 밤"></a>
                    <a href="#"><img src="../resources/tiger.jpg" alt="호랑이"></a>
                    <a href="#"><img src="../resources/23identity.jpg" alt="다중인격"></a>
                    <a href="#"><img src="../resources/forest.jpg" alt="숲"></a>
                    <a href="#"><img src="../resources/superrealistic.jpg" alt="초현실"></a>
                    <a href="#"><img src="../resources/wolf.jpg" alt="늑대"></a>
                    <a href="#"><img src="../resources/withchild.jpg" alt="아이와함께"></a>
                    <a href="#"><img src="../resources/moon_in_yard.jpg" alt="초원의달"></a>
                </div>
            </div>
            <div class="popular_sub">
                <div class="popular_artists">
                    <div class="title medium">인기 작가</div>
                    <ul class="container_artists">
                        <li>
                            <img src="../resources/arab.jpg" al="발밤프로필">
                            <div class=artists_text>
                                <a href="#"><p class="username bold">발밤</p></a>
                                <p class="user_intro">유화, 수채화를 그리는 발밤입니다. :D</p>
                            </div>
                        </li>
                        <li>
                            <img src="../resources/judo.png" al="이연프로필">
                            <div class=artists_text>
                                <a href="#"><p class="username bold">이연</p></a>
                                <p class="user_intro">수채화, 펜화를 그립니다.</p>
                            </div>
                        </li>
                        <li>
                            <img src="../resources/judo2.PNG" al="노마드프로필">
                            <div class=artists_text>
                                <a href="#"><p class="username bold">노마드</p></a>
                                <p class="user_intro">일러스트레이터, 포토샵 전문 작가 노마드입니다. :D</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="popular_exhibition">
                    <div class="title medium">인기 갤러리</div>
                    <div class="contatiner_exhibition">
                        <a href="#"><img src="../resources/last_farewell.jpg" al="마지막인사"></a>
                        <a href="#"><img src="../resources/spiekermann.jpg" al="스피커맨"></a>
                        <a href="#"><img src="../resources/art_festival.jpg" al="미술축제"></a>
                        <a href="#" class="button bold">MORE</a>
                    </div>
                </div>
            </div>

        </main>
       <footer>
            <span class="bold">We artists</span> <span>Copyright © 2021 Painter.co.,Ltd. All rights reserved.</span><br>
           <span>(주)Painter</span><span> | </span><span>대표 : 김승은</span><span> | </span>
           <span>사업자등록번호 : 000-00-00000</span>
           <p>주소 : 경기도 용인시 동막골 무야호</p>
       </footer>
       <script src="./js/input_limit.js">

       </script>
    </body>
</html>