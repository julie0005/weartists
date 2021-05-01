<?php
    include "../../db.php";
    $profile_dir="../../temp/profile";
    $img_dir="../../temp";
    if(isset($_GET['query'])){
        $squery=$_GET['query'];
    }
    else{
        echo "<script>history.back();</script>";
        exit();
    }
    $total=0;
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
            <meta charset="UTF-8">
            <title>모두화가</title>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://kit.fontawesome.com/03b31c0e0f.js" crossorigin="anonymous"></script>
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
                    <h1 class="bold logo"><a href="../main.php">모두화가</a></h1>
                    <form class="search-container" id="search-form" action="index.php" method="get" onsubmit="return checkSearch()">
                        <input type="text" id="search-bar" name="query" maxlength="100" value="<?php echo htmlspecialchars($squery);?>" placeholder="오늘은 어떤 그림을 구경할래요?">
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
                        <input type="hidden" name="query" maxlength="100" value='<?php echo "{$squery}";?>'>
                        <button type="submit">통합</button>
                    </form>
                    <form class="searchnav-link" action="./works.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value='<?php echo "{$squery}";?>'>
                        <button type="submit">작품</button>
                    </form>
                    <form class="searchnav-link" action="./gallary.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value='<?php echo "{$squery}";?>'>
                        <button type="submit">갤러리</button>
                    </form>
                    <form class="searchnav-link" action="./artists.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value='<?php echo "{$squery}";?>'>
                        <button type="submit">작가</button>
                    </form>
                    <form class="searchnav-link" action="./shop.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value='<?php echo "{$squery}";?>'>
                        <button type="submit">상점</button>
                    </form>
                </nav>
            </div>
            <p class="results-doc">결과&nbsp;</p><p id="results">3242</p>&nbsp;<p>개</p>
                <div class="wrapper" id="works-wrapper">
                    <?php
                        $result=mysqli_query($db, "select count(*) as cnt from work inner join user on work.u_id=user.u_id where title like '%{$squery}%' or description like '%{$squery}%' or user.nickname like '%{$squery}%'");
                        $row=mysqli_fetch_assoc($result);
                        $cnt=$row['cnt'];
                        $total+=$cnt;
                    ?>      
                    <div class="search-title">
                        <div class="titleinfo">
                            <p class="bold maininfo">작품</p>
                            <p id="gallarycnt"><?php echo "{$cnt}"?></p>
                        </div>
                        <form class="searchnav-link" action="./works.php" method="get">
                            <input type="hidden" name="query" maxlength="100" value="<?php echo "{$squery}";?>">
                            <button type="submit">더보기</button>
                        </form>
                    </div>
                    <?php if($cnt ==0){
                        echo "<div class='msg'>검색 결과가 존재하지 않습니다.</div>";
                    } ?>
                        <div class="works-container">
                            <?php
                                if($cnt!=0){
                                $query="select work.*,user.nickname from user inner join work on work.u_id=user.u_id where work.title like '%{$squery}%' or work.description like '%{$squery}%' or user.nickname like '%{$squery}%' order by work.update_date desc limit 8";
                                $result=mysqli_query($db,$query) or die("갤러리 최신 순 8개 검색 실패".mysqli_error($db));
                                while($row=mysqli_fetch_assoc($result)){
                                    $wimage=$row['image'];
                                    $wtitle=$row['title'];
                                    $author=$row['nickname'];
                                    $likes=$row['likes'];
                                    $comments=$row['comments'];
                                    $w_id=$row['w_id'];
                            ?>
                            <a href="../work.php?id=<?php echo "{$w_id}"?>" class="item">
                            <img src="<?php echo "{$img_dir}"?>/<?php echo "{$wimage}"?>" alt="<?php echo "{$wimage}"?>">
                            <div class="text_content">
                                <p class="title"><?php echo "{$wtitle}"?></p>
                                <p class="artists"><?php echo "{$author}"?></p>
                                <div class="sub_desciption">
                                    <i class="fas fa-heart"></i>
                                    <span class="likes"><?php echo "{$likes}"?></span>&nbsp;&nbsp;
                                    <i class="fas fa-comment"></i>
                                    <span class="comments"><?php echo "{$comments}"?></span>
                                </div>
                            </div>
                            </a>
                            <?php }
                            }
                            ?>
                        </div>
                    
                </div>
                
                <div class="wrapper" id="gallary-wrapper">
                    <div class="search-title">
                        <?php
                        $result=mysqli_query($db, "select count(*) as cnt from gallary inner join user on gallary.u_id=user.u_id where title like '%{$squery}%' or user.nickname like '%{$squery}%'");
                        $row=mysqli_fetch_assoc($result);
                        $cnt=$row['cnt'];
                        $total+=$cnt;
                        ?>
                        <div class="titleinfo">
                            <p class="bold maininfo">갤러리</p>
                            <p id="postcnt"><?php echo "{$cnt}"?></p>
                        </div>
                        <form class="searchnav-link" action="./gallary.php" method="get">
                            <input type="hidden" name="query" maxlength="100" value="<?php echo "{$squery}";?>">
                            <button type="submit">더보기</button>
                        </form>
                    </div>
                    <?php if($cnt ==0){
                        echo "<div class='msg'>검색 결과가 존재하지 않습니다.</div>";
                    } ?>
                    <div class="works-container">
                        <?php
                            if($cnt!=0){
                            $query="select gallary.*,user.nickname from gallary inner join user on gallary.u_id=user.u_id where gallary.title like '%{$squery}%' or user.nickname like '%{$squery}%' limit 8";
                            $result=mysqli_query($db,$query);
                            if(!$result){
                                die("gallary 조회 fails.<br>\n".mysqli_error($db));
                            }
                            else{
                                while($row=mysqli_fetch_assoc($result)){
                                    $gu_id=$row['u_id'];
                                    $g_id=$row['g_id'];
                                    $gallary_title=$row['title'];
                                    $thumbnail=$row['thumbnail'];
                                    $gauthor=$row['nickname'];
                        ?>    
                                <a href="../user/gallaryo.php?id=<?php echo "{$gu_id}"?>&idx=<?php echo "{$g_id}"?>" class="item"><img src="../../temp/gallarythumb/<?php echo "{$thumbnail}"?>" alt=<?php echo "{$gallary_title}"?>>
                                <div class="gallary-text"><p class="gallary-name bold" id="gallary-name-default"><?php echo "{$gallary_title}"?></p><p class="gallary-author"><?php echo "{$gauthor}" ?></p></div>
                                </a>
                        <?php        
                                }    
                            }
                            }
                        ?>
                        
                    </div>
                   
                </div>
                <div class="container-wrapper">
                    <div class="wrapper" id="artist-wrapper">
                        <div class="search-title">
                            <?php
                            $result=mysqli_query($db, "select count(*) as cnt from user where nickname like '%{$squery}%' or profile like '%{$squery}%'");
                            $row=mysqli_fetch_assoc($result);
                            $cnt=$row['cnt'];
                            $total+=$cnt;
                            ?>
                            <div class="titleinfo">
                                <p class="bold maininfo">작가</p>
                                <p id="postcnt"><?php echo "{$cnt}"; ?></p>
                            </div>
                            <form class="searchnav-link" action="./artists.php" method="get">
                                <input type="hidden" name="query" maxlength="100" value="<?php echo "{$squery}";?>">
                                <button type="submit">더보기</button>
                            </form>
                        </div>
                        <?php if($cnt ==0){
                            echo "<div class='msg'>검색 결과가 존재하지 않습니다.</div>";
                        } ?>
                        <ul class="works_container" id="container_artists">
                            <?php if($cnt!=0){
                                $query="select photo, u_id, nickname, profile from user where nickname like '%{$squery}%' or profile like '%{$squery}%' order by create_date desc limit 6";
                                $result=mysqli_query($db, $query) or die("작가 불러오기 실패.".mysqli_error($db));    
                                while($row=mysqli_fetch_assoc($result)){
                                    $user_photo=$row['photo'];
                                    $u_id=$row['u_id'];
                                    $user_name=$row['nickname'];
                                    $profile=$row['profile'];

                            ?>
                            <li>
                                <img src="<?php echo "{$profile_dir}"?>/<?php echo "{$user_photo}"?>" al="<?php echo "{$user_photo}"?>">
                                <div class=artists_text>
                                    <a href="../user/other.php?id=<?php echo "{$u_id}"?>"><p class="username bold"><?php echo "{$user_name}"?></p></a>
                                    <p class="user_intro"><?php echo "{$profile}"?></p>
                                </div>
                            </li>
                            <?php } }?>
                        </ul>
                    </div>
                    <div class="wrapper" id="shop-wrapper">
                        <div class="search-title">
                            <?php
                            $result=mysqli_query($db, "select count(*) as cnt from shop inner join work on shop.w_id=work.w_id inner join user on work.u_id=user.u_id where user.nickname like '%{$squery}%' or work.title like '%{$squery}%' or work.description like '%{$squery}%'");
                            $row=mysqli_fetch_assoc($result);
                            $cnt=$row['cnt'];
                            $total+=$cnt;
                            ?>
                            <div class="titleinfo">
                                <p class="bold maininfo">상점</p>
                                <p id="postcnt"><?php echo"{$cnt}";?></p>
                            </div>
                            <form class="searchnav-link" action="./shop.php" method="get">
                                <input type="hidden" name="query" maxlength="100" value="<?php echo "{$squery}";?>">
                                <button type="submit">더보기</button>
                            </form>
                        </div>
                        <?php if($cnt ==0){
                            echo "<div class='msg'>검색 결과가 존재하지 않습니다.</div>";
                        } ?>
                        <div class="works-container">
                            <?php if($cnt!=0){
                                $query="select shop.*, work.image, work.title, work.w_id, work.update_date, shop.price, user.nickname from shop inner join work on shop.w_id=work.w_id inner join user on work.u_id=user.u_id where user.nickname like '%{$squery}%' or work.title like '%{$squery}%' or work.description like '%{$squery}%' order by work.update_date desc limit 6";
                                $result=mysqli_query($db, $query) or die("작가 불러오기 실패.".mysqli_error($db));    
                                while($row=mysqli_fetch_assoc($result)){
                                    $sw_id=$row['w_id'];
                                    $su_name=$row['nickname'];
                                    $stitle=$row['title'];
                                    $simage=$row['image'];
                                    $price=$row['price'];
                            ?>
                            <a href="#" class="item">
                                <img src="<?php echo "{$img_dir}"; ?>/<?php echo "{$simage}"; ?>" alt=<?php echo "{$simage}"; ?>>
                                <div class="goods-info">
                                    <p id="title-value"><?php echo "{$stitle}"; ?></p>
                                    <div class="subinfo">
                                        <div class="price"><p class="bold" id="price-value"><?php echo "{$price}"; ?></p>&nbsp;원</div>
                                        <div class="artist">작가&nbsp;<p id="artist-value"><?php echo "{$su_name}"; ?></p></div>
                                    </div>
                                </div>
                            </a>
                            <?php } } ?>
                        </div>
                    </div>
                </div> 
                
        </main>



        <script src="../js/input_limit.js"></script>
        <script>$('#results').text("<?php echo "{$total}"?>");</script>
    </body>
</html>
