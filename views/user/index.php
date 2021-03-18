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
            <meta charset="UTF-8">
            <title>모두화가</title>
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
                <a href="./user/" class="bold">MY</a>
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
                    <a href="main.php">홈</a>
                    <a href="./topic/index.html">주제</a>
                    <a href="./workboard.html">워크<br>보드</a>
                    <a href="./feed/post.html">피드</a>
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
                              <li><a href="./write-work.php">작품</a></li>
                              <li><a href="./write-post.php">작가노트</a></li>
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
                        <a href="#">홈</a>
                        <a href="./gallary.php">갤러리</a>
                        <a href="#">작가노트</a>
                        <a href="./shop.php">상점</a>
                        <a href="./subscribe.php">구독</a>
                    </div>
                </nav>
                <!-- user home -->
                <div class="wrapper" id="gallary-wrapper">
                    <div class="subcontainer">
                    <div class="user-title">
                        <div class="titleinfo">
                            <p class="medium maininfo">갤러리</p>
                            <p id="postcnt">528</p>
                        </div>
                        <a href="#" class="more">더보기</a>
                    </div>
                    <div class="works-container">
                        <?php
                            $query="SELECT * FROM gallary WHERE u_id={$u_id}";
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
                                <a href="./gallary.php?idx=<?php echo "{$g_id}"?>" class="item"><img src="../../temp/gallarythumb/<?php echo "{$thumbnail}"?>" alt=<?php echo "{$gallary_title}"?>>
                                <p class="gallary-name bold" id="gallary-name-default"><?php echo "{$gallary_title}"?></p>
                                </a>
                        <?php        
                                }
                                
                            }
                        ?>
                    </div>
                    </div>
                </div>
                <div class="wrapper" id="post-wrapper">
                    <div class="subcontainer">
                        <div class="user-title">
                            <div class="titleinfo">
                                <p class="medium maininfo">작가노트</p>
                                <p id="postcnt">528</p>
                            </div>
                            <a href="#" class="more">더보기</a>
                        </div>
                        
                        
                        <div class="works-container">
                            <a class="post" href="#">
                                <p class="post-title medium">호랑이와 사자에 대한 고찰과 호랑이와 사자의 관계성과 블라블라블라블라블라블라</p>
                                <p class="post-date">2021-01-24</p>
                                <div class="post-subinfo">
                                    <span><i class="fas fa-comments"></i></span>&nbsp;
                                    <p class="post-comments">32</p>
                                    <span><i class="fas fa-heart"></i></span>&nbsp;
                                    <p class="likes">89</p>
                                </div>
                            </a>
                            <a class="post" href="#">
                                <p class="post-title medium">호랑이와 사자에 대한 고찰과 호랑이와 사자의 관계성과 블라블라블라블라블라블라</p>
                                <p class="post-date">2021-01-24</p>
                                <div class="post-subinfo">
                                    <span><i class="fas fa-comments"></i></span>&nbsp;
                                    <p class="post-comments">32</p>
                                    <span><i class="fas fa-heart"></i></span>&nbsp;
                                    <p class="likes">89</p>
                                </div>
                            </a>
                            <a class="post" href="#">
                                <p class="post-title medium">호랑이와 사자에 대한 고찰과 호랑이와 사자의 관계성과 블라블라블라블라블라블라</p>
                                <p class="post-date">2021-01-24</p>
                                <div class="post-subinfo">
                                    <span><i class="fas fa-comments"></i></span>&nbsp;
                                    <p class="post-comments">32</p>
                                    <span><i class="fas fa-heart"></i></span>&nbsp;
                                    <p class="likes">89</p>
                                </div>
                            </a>
                            <a class="post" href="#">
                                <p class="post-title medium">호랑이와 사자에 대한 고찰과 호랑이와 사자의 관계성과 블라블라블라블라블라블라</p>
                                <p class="post-date">2021-01-24</p>
                                <div class="post-subinfo">
                                    <span><i class="fas fa-comments"></i></span>&nbsp;
                                    <p class="post-comments">32</p>
                                    <span><i class="fas fa-heart"></i></span>&nbsp;
                                    <p class="likes">89</p>
                                </div>
                            </a>
                        </div>
                   
                    </div>
                </div>
               
                <div class="container-wrapper">
                    <div class="subcontainer">
                    <div class="subwrapper" id="artist-wrapper">
                        
                            <div class="user-title">
                                <div class="titleinfo">
                                    <p class="medium maininfo">작가</p>
                                    <p id="postcnt">528</p>
                                </div>
                                <a href="works.html" class="more">더보기</a>
                            </div>
                            <ul class="works_container" id="container_artists">
                                <li>
                                    <img src="../../resources/arab.jpg" al="발밤프로필">
                                    <div class=artists_text>
                                        <a href="#"><p class="username bold">발밤</p></a>
                                    </div>
                                    <button class="dd-button">
                                        구독중
                                    </button>
                                </li>
                                <li>
                                    <img src="../../resources/judo.png" al="이연프로필">
                                    <div class=artists_text>
                                        <a href="#"><p class="username bold">이연</p></a>
                                    </div>
                                    <button class="dd-button">
                                        구독중
                                    </button>
                                </li>
                                <li>
                                    <img src="../../resources/judo2.PNG" al="노마드프로필">
                                    <div class=artists_text>
                                        <a href="#"><p class="username bold">노마드</p></a>
                                    </div>
                                    <button class="dd-button">
                                        구독중
                                    </button>
                                </li>
                                <li>
                                    <img src="../../resources/arab.jpg" al="발밤프로필">
                                    <div class=artists_text>
                                        <a href="#"><p class="username bold">발밤</p></a>
                                    
                                    </div>
                                    <button class="dd-button">
                                        구독중
                                    </button>
                                </li>
                                <li>
                                    <img src="../../resources/judo.png" al="이연프로필">
                                    <div class=artists_text>
                                        <a href="#"><p class="username bold">이연</p></a>
                                    </div>
                                    <button class="dd-button">
                                        구독중
                                    </button>
                                </li>
                                <li>
                                    <img src="../../resources/judo2.PNG" al="노마드프로필">
                                    <div class=artists_text>
                                        <a href="#"><p class="username bold">노마드</p></a>
                                    </div>
                                    <button class="dd-button">
                                        구독중
                                    </button>
                                </li>
                            </ul>
                        
                    </div>
                    <div class="subwrapper" id="shop-wrapper">
                         
                        <div class="user-title">
                            <div class="titleinfo">
                                <p class="medium maininfo">상점</p>
                                <p id="postcnt">528</p>
                            </div>
                            <a href="#" class="more">더보기</a>
                        </div>
                        <div class="works-container" id="shop">
                            <a href="#" class="item"><img src="../../resources/starry_night.jpg" alt="별이 빛나는 밤"></a>
                            <a href="#" class="item" ><img src="../../resources/tiger.jpg" alt="호랑이"></a>
                            <a href="#" class="item" ><img src="../../resources/23identity.jpg" alt="다중인격"></a>
                            <a href="#" class="item" ><img src="../../resources/forest.jpg" alt="숲"></a>
                            <a href="#" class="item" ><img src="../../resources/superrealistic.jpg" alt="초현실"></a>
                            <a href="#" class="item" ><img src="../../resources/wolf.jpg" alt="늑대"></a>
                            <a href="#" class="item" ><img src="../../resources/withchild.jpg" alt="아이와함께"></a>
                            <a href="#" class="item" ><img src="../../resources/moon_in_yard.jpg" alt="초원의달"></a>
                        </div>
                        
                    </div>
                    </div>
                </div> 


            </div>
        </main>
        
        
       <script src="../js/input_limit.js">

       </script>
    </body>
</html>