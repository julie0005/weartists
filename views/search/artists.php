<!DOCTYPE html>
<html lang="ko">
    <head>
            <meta charset="UTF-8">
            <title>모두화가</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="../header.css">
            <link rel="stylesheet" href="./index.css">
            
            <meta name="description" content="우리 모두는 화가입니다.">
    </head>
    <body>
        <!-- Header -->
       
        <div id="header_all">
            <header class="page-header wrapper">
                <div id=header_main>
                    <h1 class="bold logo"><a href="main.php">모두화가</a></h1>
                    <form class="search-container" id="search-form" action="index.php" method="get" onsubmit="return checkSearch()">
                        <input type="text" id="search-bar" name="query" maxlength="100" value="<?php echo"{$squery}";?>" placeholder="오늘은 어떤 그림을 구경할래요?">
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
                <?php } else{?>
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
                    <a href="../feed/index.php">피드</a>
                </div>
            </nav>
        </div>

        <main id="search">
            <div id="search-header">
                <div id="search-result">'<p id="search-word" class="bold"><?php echo"{$squery}";?></p>'<p>&nbsp;에 대한 검색 결과</p></div>
                <nav id="searchnav-container">
                    <form class="searchnav-link" action="./index.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value="<?php echo "{$squery}";?>">
                        <button type="submit">통합</button>
                    </form>
                    <form class="searchnav-link" action="./works.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value="<?php echo "{$squery}";?>">
                        <button type="submit">작품</button>
                    </form>
                    <form class="searchnav-link" action="./gallary.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value="<?php echo "{$squery}";?>">
                        <button type="submit">갤러리</button>
                    </form>
                    <form class="searchnav-link" action="./artists.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value="<?php echo "{$squery}";?>">
                        <button type="submit">작가</button>
                    </form>
                    <form class="searchnav-link" action="./shop.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value="<?php echo "{$squery}";?>">
                        <button type="submit">상점</button>
                    </form>
                </nav>
            </div>
                <div class="wrapper" id="works-wrapper">
                    <div class="search-title">
                        <div class="titleinfo">
                            <p class="bold maininfo">작가</p>
                            <p id="gallarycnt">528</p>
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
                    </div>
                    
                        <div class="works-container-wrapper">
                            <ul class="works-container">
                                <li>
                                    <a href="#"><img src="../../resources/judo.png" class="artist-profile">
                                    <p class="artist-name bold">고몽</p>
                                    <div class="artist-info">
                                        <div class="follower-info"><p class="artist-followers">3231</p>&nbsp;구독자</div>
                                        <p class="artist-explain">호랑이 그림 좋아하는 고몽 호랑이 호랑이</p>
                                    </div></a>
                                </li>
                                <li>
                                    <a href="#"><img src="../../resources/judo.png" class="artist-profile">
                                        <p class="artist-name bold">고몽</p>
                                        <div class="artist-info">
                                            <div class="follower-info"><p class="artist-followers">3231</p>&nbsp;구독자</div>
                                            <p class="artist-explain">호랑이 그림 좋아하는 고몽 호랑이 호랑이</p>
                                    </div></a>
                                </li>
                                <li>
                                    <a href="#"><img src="../../resources/judo.png" class="artist-profile">
                                        <p class="artist-name bold">고몽</p>
                                        <div class="artist-info">
                                            <div class="follower-info"><p class="artist-followers">3231</p>&nbsp;구독자</div>
                                            <p class="artist-explain">호랑이 그림 좋아하는 고몽 호랑이 호랑이</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="../../resources/judo.png" class="artist-profile">
                                        <p class="artist-name bold">고몽</p>
                                        <div class="artist-info">
                                            <div class="follower-info"><p class="artist-followers">3231</p>&nbsp;구독자</div>
                                            <p class="artist-explain">호랑이 그림 좋아하는 고몽 호랑이 호랑이</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="../../resources/judo.png" class="artist-profile">
                                        <p class="artist-name bold">고몽</p>
                                        <div class="artist-info">
                                            <div class="follower-info"><p class="artist-followers">3231</p>&nbsp;구독자</div>
                                            <p class="artist-explain">호랑이 그림 좋아하는 고몽 호랑이 호랑이</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="../../resources/judo.png" class="artist-profile">
                                        <p class="artist-name bold">고몽</p>
                                        <div class="artist-info">
                                            <div class="follower-info"><p class="artist-followers">3231</p>&nbsp;구독자</div>
                                            <p class="artist-explain">호랑이 그림 좋아하는 고몽 호랑이 호랑이</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="../../resources/judo.png" class="artist-profile">
                                        <p class="artist-name bold">고몽</p>
                                        <div class="artist-info">
                                            <div class="follower-info"><p class="artist-followers">3231</p>&nbsp;구독자</div>
                                            <p class="artist-explain">호랑이 그림 좋아하는 고몽 호랑이 호랑이</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><img src="../../resources/judo.png" class="artist-profile">
                                        <p class="artist-name bold">고몽</p>
                                        <div class="artist-info">
                                            <div class="follower-info"><p class="artist-followers">3231</p>&nbsp;구독자</div>
                                            <p class="artist-explain">호랑이 그림 좋아하는 고몽 호랑이 호랑이</p>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    
                </div>
                
               
                
        </main>



        
    </body>
</html>
