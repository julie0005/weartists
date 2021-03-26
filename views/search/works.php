<?php
    include "../../db.php";
    if(isset($_GET['query'])){
        $query=$_GET['query'];
    }
    else{
        echo "<script>history.back();</script>";
        exit();
    }
?>
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
                <div id="search-result">'<p id="search-word" class="bold">호랑이</p>'<p>&nbsp;에 대한 검색 결과</p></div>
                <nav id="searchnav-container">
                    <form class="searchnav-link" action="./index.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value="<?php echo "{$query}";?>">
                        <button type="submit">통합</button>
                    </form>
                    <form class="searchnav-link" action="./works.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value="<?php echo "{$query}";?>">
                        <button type="submit">작품</button>
                    </form>
                    <form class="searchnav-link" action="./gallary.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value="<?php echo "{$query}";?>">
                        <button type="submit">갤러리</button>
                    </form>
                    <form class="searchnav-link" action="./artists.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value="<?php echo "{$query}";?>">
                        <button type="submit">작가</button>
                    </form>
                    <form class="searchnav-link" action="./shop.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value="<?php echo "{$query}";?>">
                        <button type="submit">상점</button>
                    </form>
                </nav>
            </div>
                <div class="wrapper" id="works-wrapper">
                    <div class="search-title">
                        <div class="titleinfo">
                            <p class="bold maininfo">작품</p>
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
                    
                        <div class="works-container">
                            <a href="#" class="item"><img src="../../resources/starry_night.jpg" alt="별이 빛나는 밤"></a>
                            <a href="#" class="item" ><img src="../../resources/tiger.jpg" alt="호랑이"></a>
                            <a href="#" class="item" ><img src="../../resources/23identity.jpg" alt="다중인격"></a>
                            <a href="#" class="item" ><img src="../../resources/forest.jpg" alt="숲"></a>
                            <a href="#" class="item" ><img src="../../resources/superrealistic.jpg" alt="초현실"></a>
                            <a href="#" class="item" ><img src="../../resources/wolf.jpg" alt="늑대"></a>
                            <a href="#" class="item" ><img src="../../resources/withchild.jpg" alt="아이와함께"></a>
                            <a href="#" class="item" ><img src="../../resources/moon_in_yard.jpg" alt="초원의달"></a>
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
                
               
                
        </main>



        
    </body>
</html>
