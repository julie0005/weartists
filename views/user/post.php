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
                <form class="search-container" id="search-form" onsubmit="return checkSearch()">
                    <input type="text" id="search-bar" placeholder="오늘은 어떤 그림을 구경할래요?">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="logged">
                <a href="./index.html" class="bold">MY</a>
                &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="medium">로그아웃</a>
            </div>
        </header>
        <main>
            <nav class="top-nav bold">
                <div id=topnav-container>
                    <a href="../main.php">홈</a>
                    <a href="../topic/index.html">주제</a>
                    <a href="../workboard.php">워크<br>보드</a>
                    <a href="../feed/post.html">피드</a>
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
            </div>
        </main>
        
        
        <script src="../js/input_limit.js"></script>
       <script src="../js/masonry.js"></script>
    </body>
</html>
