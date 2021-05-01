<?php
    include "../db.php";
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
            <meta charset="UTF-8">
            <title>모두화가</title>
            <script src="https://kit.fontawesome.com/03b31c0e0f.js" crossorigin="anonymous"></script>
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
                    <h1 class="bold logo"><a href="main.php">모두화가</a></h1>
                    <form class="search-container" id="search-form" action="./search/index.php" method="get" onsubmit="return checkSearch()">
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
                    <a href="main.php">Home</a>
                    <a href="./topic/index.php">주제</a>
                    <a href="./workboard.php">워크보드</a>
                    <a href="./feed/index.php">피드</a>
                </div>
            </nav>
        </div>
        <!-- Contents_Home //most views, hot gallaries, hot artists -->
        <main class="popular_contents">
        
            <div class="popular_works">
                <a class="title medium" href="#">인기 작품</a>
                <div id="main_popular"class="container_works">
                    <?php
                        $query="select work.*, user.nickname from work inner join user on user.u_id=work.u_id order by views+comments+likes desc limit 8";
                        $result=mysqli_query($db, $query) or die("작품 인기순 집계 실패.".mysqli_error($db));
                        while($row=mysqli_fetch_assoc($result)){
                            $title=$row['title'];
                            $nickname=$row['nickname'];
                            $likes=$row['likes'];
                            $comments=$row['comments'];
                            $image=$row['image'];
                            $w_id=$row['w_id'];
                    ?>
                    <a href="./work.php?id=<?php echo "{$w_id}";?>">
                        <img src="../temp/<?php echo "{$image}"; ?>" alt="<?php echo "{$image}"; ?>">
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
                    <?php } ?>
                </div>
            </div>
            <div class="popular_sub">
                <div class="popular_artists">
                    <div class="title medium">인기 작가</div>
                    <ul class="container_artists">
                    <?php
                        $query="select user.u_id, user.nickname, user.profile, user.photo from user order by subscribers desc, works desc limit 3";
                        $result=mysqli_query($db, $query) or die("작가 인기순 집계 실패.".mysqli_error($db));
                        while($row=mysqli_fetch_assoc($result)){
                            $author=$row['nickname'];
                            $photo=$row['photo'];
                            $u_id=$row['u_id'];
                            $profile=$row['profile'];
                    ?>
                        <li>
                            <img src="../temp/profile/<?php echo "{$photo}";?>" al="<?php echo "{$photo}";?>">
                            <div class=artists_text>
                                <a href="./user/other.php?id=<?php echo "{$u_id}";?>"><p class="username bold"><?php echo "{$author}";?></p></a>
                                <p class="user_intro"><?php echo "{$profile}";?></p>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="popular_exhibition">
                    <div class="title medium">랜덤 추천 갤러리</div>
                    
                    <div class="contatiner_exhibition">
                    <?php
                        $query="select gallary.*, user.u_id, user.nickname from gallary inner join user on gallary.u_id=user.u_id where title not in ('All') order by rand() limit 3";
                        $result=mysqli_query($db,$query) or die("랜덤 추천 갤러리 조회 실패.".mysqli_error($db));
                        while($row=mysqli_fetch_assoc($result)){
                            $gu_id=$row['u_id'];
                            $g_id=$row['g_id'];
                            $thumbnail=$row['thumbnail'];
                            $gallary_title=$row['title'];
                            $gauthor=$row['nickname'];
                    ?>
                        <a href="./user/gallaryo.php?id=<?php echo "{$gu_id}"?>&idx=<?php echo "{$g_id}"?>" class="item"><img src="../temp/gallarythumb/<?php echo "{$thumbnail}"?>" alt=<?php echo "{$gallary_title}"?>>
                        <div class="gallary-text"><p class="gallary-name bold" id="gallary-name-default"><?php echo "{$gallary_title}"?></p><p class="gallary-author"><?php echo "{$gauthor}" ?></p></div>
                        </a>
                    <?php } ?>
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
