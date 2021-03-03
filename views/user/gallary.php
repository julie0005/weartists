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
                <h1 class="bold logo"><a href="main.html">모두화가</a></h1>
                <form class="search-container" id="search-form" onsubmit="return checkSearch()">
                    <input type="text" id="search-bar" placeholder="오늘은 어떤 그림을 구경할래요?">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
            <div id="logged">
                <a href="./index.html" class="bold">MY</a>
                &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="medium">로그아웃</a>
            </div>
        </header>
        <main>
            <nav class="top-nav bold">
                <div id=topnav-container>
                    <a href="main.html">홈</a>
                    <a href="./topic/index.html">주제</a>
                    <a href="./workboard.html">워크<br>보드</a>
                    <a href="./feed/post.html">피드</a>
                </div>
            </nav>
            <div id="main-contents">
                <!-- user info -->
                <div class="user-info">
                    <div class=user-maininfo>
                        <img class="user-profile" src="../../resources/arab.jpg" alt=프로필>
                        <div class="textinfo">
                            <h3 class="username bold">고몽</h3>
                            <div class="user-subinfo">
                                <span class="follower">1k 구독자</span>&nbsp;&nbsp;|&nbsp;
                                <span class="works-number">512</span>&nbsp;작품
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
                        <a href="#">갤러리</a>
                        <a href="#">작가노트</a>
                        <a href="#">상점</a>
                        <a href="#">구독</a>
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
                        <a href="#" class="more">수정하기</a>
                    </div>
                    <div class="works-container">
                        <?php
                            $idx=0;
                        ?>
                        <a href="./gallary.php?idx=<?php echo $idx; $idx++;?>" class="item"><img src="../../resources/starry_night.jpg" alt="별이 빛나는 밤">
                            <p class="gallary-name bold" id="gallary-name-default">보이지 않지만 언제나 반짝반짝 빛나는 것</p>
                        </a>
                        <a href="./read.php?idx=<?php echo $idx; $idx++;?>" class="item" ><img src="../../resources/tiger.jpg" alt="호랑이">
                            <p class="gallary-name bold" id="gallary-name-default">보이지 않지만 언제나 반짝반짝 빛나는 것</p>
                        </a>
                        <a href="#" class="item" ><img src="../../resources/23identity.jpg" alt="다중인격">
                            <p class="gallary-name bold" id="gallary-name-default">보이지 않지만 언제나 반짝반짝 빛나는 것</p>
                        </a>
                        <a href="#" class="item" ><img src="../../resources/forest.jpg" alt="숲">
                            <p class="gallary-name bold" id="gallary-name-default">보이지 않지만 언제나 반짝반짝 빛나는 것</p>
                        </a>
                        <a href="#" class="item" ><img src="../../resources/superrealistic.jpg" alt="초현실">
                            <p class="gallary-name bold" id="gallary-name-default">보이지 않지만 언제나 반짝반짝 빛나는 것</p>
                        </a>
                        <a href="#" class="item" ><img src="../../resources/wolf.jpg" alt="늑대">
                            <p class="gallary-name bold" id="gallary-name-default">보이지 않지만 언제나 반짝반짝 빛나는 것</p>
                        </a>
                        <a href="#" class="item" ><img src="../../resources/withchild.jpg" alt="아이와함께">
                            <p class="gallary-name bold" id="gallary-name-default">보이지 않지만 언제나 반짝반짝 빛나는 것</p>
                        </a>
                        <a href="#" class="item" ><img src="../../resources/moon_in_yard.jpg" alt="초원의달">
                            <p class="gallary-name bold" id="gallary-name-default">보이지 않지만 언제나 반짝반짝 빛나는 것</p>
                        </a>
                    </div>
                    </div>
                </div>
                <?php
                    if(isset($_GET['idx'])){
                ?>
                    <div class="wrapper" id="works-wrapper">
                    <div class="subcontainer">
                        <div class="user-title">
                            <div class="titleinfo">
                                <a href="javascript:window.history.back()" style="margin-right:10px;"><i style="padding:0px 10px;"class="fas fa-chevron-left"></i></a> 
                                <p class="medium maininfo" id="folder-name">보이지 않지만 언제나 반짝반짝 빛나는 것</p>
                                <p id="workcnt">528</p>
                            </div>
                        </div>
                        <div class="container_works">
                            <a href="#" class="mason-item">
                                <img class="mason-image" src="../../resources/starry_night.jpg" alt="별이 빛나는 밤">
                                <div class="text_content">
                                    <p class="title">별이 빛나는 밤</p>
                                    <p class="artists">발밤발밤</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/tiger.jpg" alt="호랑이">
                                <div class="text_content">
                                    <p class="title">호랑이</p>
                                    <p class="artists">어흥</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/23identity.jpg" alt="다중인격">
                                <div class="text_content">
                                    <p class="title">다중인격</p>
                                    <p class="artists">고몽</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/forest.jpg" alt="숲">
                                <div class="text_content">
                                    <p class="title">숲속의 정령</p>
                                    <p class="artists">전사</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/superrealistic.jpg" alt="초현실">
                                <div class="text_content">
                                    <p class="title">초현실주의</p>
                                    <p class="artists">호방호방</p>
                                    
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/wolf.jpg" alt="늑대">
                                <div class="text_content">
                                    <p class="title">늑대</p>
                                    <p class="artists">wolf</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/withchild.jpg" alt="아이와함께">
                                <div class="text_content">
                                    <p class="title">with Child</p>
                                    <p class="artists">고몽</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/moon_in_yard.jpg" alt="초원의달">
                                <div class="text_content">
                                    <p class="title">초원의 달</p>
                                    <p class="artists">노마드</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/starry_night.jpg" alt="별이 빛나는 밤">
                                <div class="text_content">
                                    <p class="title">별이 빛나는 밤</p>
                                    <p class="artists">발밤발밤</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/tiger.jpg" alt="호랑이">
                                <div class="text_content">
                                    <p class="title">별이 빛나는 밤</p>
                                    <p class="artists">발밤발밤</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/23identity.jpg" alt="다중인격">
                                <div class="text_content">
                                    <p class="title">별이 빛나는 밤</p>
                                    <p class="artists">발밤발밤</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/forest.jpg" alt="숲">
                                <div class="text_content">
                                    <p class="title">별이 빛나는 밤</p>
                                    <p class="artists">발밤발밤</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/superrealistic.jpg" alt="초현실">
                                <div class="text_content">
                                    <p class="title">별이 빛나는 밤</p>
                                    <p class="artists">발밤발밤</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/wolf.jpg" alt="늑대">
                                <div class="text_content">
                                    <p class="title">별이 빛나는 밤</p>
                                    <p class="artists">발밤발밤</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/withchild.jpg" alt="아이와함께">
                                <div class="text_content">
                                    <p class="title">별이 빛나는 밤</p>
                                    <p class="artists">발밤발밤</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/moon_in_yard.jpg" alt="초원의달">
                                <div class="text_content">
                                    <p class="title">별이 빛나는 밤</p>
                                    <p class="artists">발밤발밤</p>
                                    <div class="sub_desciption">
                                        <i class="fas fa-heart"></i>
                                        <span class="likes">89</span>&nbsp;&nbsp;
                                        <i class="fas fa-comment"></i>
                                        <span class="comments">302</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </main>
        
        
        <script src="../js/input_limit.js"></script>
       <script src="../js/masonry.js"></script>
    </body>
</html>
