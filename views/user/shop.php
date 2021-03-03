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
                <div class="wrapper" id="works-wrapper">
                    <div class="subcontainer">
                        <div class="user-title">
                            <div class="titleinfo">
                                <p class="medium maininfo">상점</p>
                                <p id="postcnt">528</p>
                            </div>
                        </div>
                        <div class="container_works">
                            <a href="#" class="mason-item">
                                <img class="mason-image" src="../../resources/starry_night.jpg" alt="별이 빛나는 밤">
                                <div class="goods-info">
                                    <p id="title-value">호랑이가 빛나는 밤</p>
                                    <div class="subinfo">
                                        <div class="price"><p class="bold" id="price-value">15000</p>&nbsp;원</div>
                                        <div class="artist">작가&nbsp;<p id="artist-value">발밤발밤</p></div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/tiger.jpg" alt="호랑이">
                            <div class="goods-info">
                                    <p id="title-value">호랑이가 빛나는 밤</p>
                                    <div class="subinfo">
                                        <div class="price"><p class="bold" id="price-value">15000</p>&nbsp;원</div>
                                        <div class="artist">작가&nbsp;<p id="artist-value">발밤발밤</p></div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/23identity.jpg" alt="다중인격">
                                <div class="goods-info">
                                    <p id="title-value">호랑이가 빛나는 밤</p>
                                    <div class="subinfo">
                                        <div class="price"><p class="bold" id="price-value">15000</p>&nbsp;원</div>
                                        <div class="artist">작가&nbsp;<p id="artist-value">발밤발밤</p></div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/forest.jpg" alt="숲">
                                <div class="goods-info">
                                    <p id="title-value">호랑이가 빛나는 밤</p>
                                    <div class="subinfo">
                                        <div class="price"><p class="bold" id="price-value">15000</p>&nbsp;원</div>
                                        <div class="artist">작가&nbsp;<p id="artist-value">발밤발밤</p></div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/superrealistic.jpg" alt="초현실">
                                <div class="goods-info">
                                    <p id="title-value">호랑이가 빛나는 밤</p>
                                    <div class="subinfo">
                                        <div class="price"><p class="bold" id="price-value">15000</p>&nbsp;원</div>
                                        <div class="artist">작가&nbsp;<p id="artist-value">발밤발밤</p></div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/wolf.jpg" alt="늑대">
                                <div class="goods-info">
                                    <p id="title-value">호랑이가 빛나는 밤</p>
                                    <div class="subinfo">
                                        <div class="price"><p class="bold" id="price-value">15000</p>&nbsp;원</div>
                                        <div class="artist">작가&nbsp;<p id="artist-value">발밤발밤</p></div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/withchild.jpg" alt="아이와함께">
                                <div class="goods-info">
                                    <p id="title-value">호랑이가 빛나는 밤</p>
                                    <div class="subinfo">
                                        <div class="price"><p class="bold" id="price-value">15000</p>&nbsp;원</div>
                                        <div class="artist">작가&nbsp;<p id="artist-value">발밤발밤</p></div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="mason-item"><img class="mason-image" src="../../resources/moon_in_yard.jpg" alt="초원의달">
                                <div class="goods-info">
                                    <p id="title-value">호랑이가 빛나는 밤</p>
                                    <div class="subinfo">
                                        <div class="price"><p class="bold" id="price-value">15000</p>&nbsp;원</div>
                                        <div class="artist">작가&nbsp;<p id="artist-value">발밤발밤</p></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!--maincontets-->
            </div>
        </main>
        
        
        <script src="../js/input_limit.js"></script>
       <script src="../js/masonry.js"></script>
    </body>
</html>
