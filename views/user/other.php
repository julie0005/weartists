<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include "../../db.php";
$profile_dir="../../temp/profile";
if(isset($_SESSION['u_id'])){

    $visitorid=$_SESSION['u_id'];
    $query="SELECT * FROM user WHERE u_id={$visitorid}";
    $result=mysqli_query($db, $query);
    if(!$result){
        die("user 조회 fails.<br>\n".mysqli_error($db));
    }
    else{
        $row=mysqli_fetch_assoc($result);
        $vauthor=$row['nickname'];
        $vphoto=$row['photo'];
    }
}
if(isset($_GET['id'])){
    $u_id=$_GET['id'];
    if(isset($visitorid) && $u_id==$visitorid){ echo "<script>location.href='./index.php'</script>";}
    $result=mysqli_query($db, "SELECT * FROM user WHERE u_id={$u_id}") or die("user 조회 실패".mysqli_error($db));
    $row=mysqli_fetch_assoc($result);
    $author=$row['nickname'];
    $profile_photo=$row['photo'];
    $works=$row['works'];
    $subscribers=$row['subscribers'];
    $profile=$row['profile'];
}
else{
    echo "<script>alert('존재하지 않는 사용자입니다.'); location.href=history.back();</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
            <meta charset="UTF-8">
            <title>모두화가</title>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                <form class="search-container" id="search-form" action="../search/index.php" method="get" onsubmit="return checkSearch()">
                        <input type="text" id="search-bar" name="query" maxlength="100" placeholder="오늘은 어떤 그림을 구경할래요?">
                        <button type="submit" class="searchButton">
                            <i class="fa fa-search"></i>
                        </button>
                </form>
            </div>
            <?php if(isset($_SESSION['u_id'])){?>
            <div class="logged">
                <a href="./index.php" class="bold">MY</a>
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
                    <a href="../main.php">홈</a>
                    <a href="../topic/index.php">주제</a>
                    <a href="../workboard.php">워크<br>보드</a>
                    <a href="../feed/index.php">피드</a>
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
                        
                            <button class="dd-button subscribebtn" style="width:80px;" value=<?php echo "{$u_id}"?>>
                                <?php
                                    if(isset($visitorid)){
                                        $result=mysqli_query($db, "SELECT * FROM subscription WHERE u_id={$visitorid} AND target_id={$u_id}") or die("구독 조회 실패.".mysqli_error($db));
                                        if(mysqli_num_rows($result)==0){
                                            echo "구독";
                                            $substatus=0;
                                        }
                                        else{
                                            echo "구독중";
                                            $substatus=1;
                                        }
                                    }
                                    else{
                                        echo "구독";
                                        $substatus=0;
                                    }
                                ?>
                                <input type="text" style="display:none;" class="substatus" value="<?php echo "{$substatus}"; ?>"></input>
                            </button>
                            
                    </div>
                </div>
                <!-- user header -->
                <nav class="user-nav medium">
                    <div id=usernav-container>
                        <a href="other.php?id=<?php echo "{$u_id}"; ?>">홈</a>
                        <a href="./gallaryo.php?id=<?php echo "{$u_id}"; ?>">갤러리</a>
                        <a href="./shopo.php?id=<?php echo "{$u_id}"; ?>">상점</a>
                        <a href="./subscribeo.php?id=<?php echo "{$u_id}"; ?>">구독</a>
                    </div>
                </nav>
                <!-- user home -->
                <div class="wrapper" id="gallary-wrapper">
                    <div class="subcontainer">
                    <div class="user-title">
                        <div class="titleinfo">
                            <p class="medium maininfo">갤러리</p>
                        </div>
                        <a href="./gallaryo.php?id=<?php echo "{$u_id}"; ?>" class="more">더보기</a>
                    </div>
                    <div class="works-container">
                        <?php
                            $query="SELECT * FROM gallary WHERE u_id={$u_id} LIMIT 8";
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
                                <a href="./gallaryo.php?id=<?php echo "{$u_id}"?>&idx=<?php echo "{$g_id}"?>" class="item"><img src="../../temp/gallarythumb/<?php echo "{$thumbnail}"?>" alt=<?php echo "{$gallary_title}"?>>
                                <p class="gallary-name bold" id="gallary-name-default"><?php echo "{$gallary_title}"?></p>
                                </a>
                        <?php        
                                }
                                
                            }
                        ?>
                    </div>
                    </div>
                </div>
                
               
                <div class="container-wrapper">
                    <div class="subcontainer">
                    <div class="subwrapper" id="artist-wrapper">
                            <?php
                                $result=mysqli_query($db, "SELECT COUNT(*) AS cnt FROM subscription WHERE u_id={$u_id}") or die("subscribe count fails.".mysqli_Error($db));
                                $row=mysqli_fetch_assoc($result);
                                $subCount=$row['cnt'];
                            ?>
                            <div class="user-title">
                                <div class="titleinfo">
                                    <p class="medium maininfo">작가</p>
                                    <p id="postcnt"><?php echo"{$subCount}"; ?></p>
                                </div>
                                <a href="./subscribeo.php?id=<?php echo"{$u_id}"; ?>" class="more">더보기</a>
                            </div>
                            <ul class="works_container" id="container_artists">
                                <?php
                                    $query="SELECT user.photo, user.nickname, subscription.target_id from user inner join subscription on subscription.target_id=user.u_id where subscription.u_id={$u_id} limit 6";
                                    $result=mysqli_query($db,$query);
                                    if(!$result){
                                        die("subscription 조회 fails.<br>\n".mysqli_error($db));
                                    }
                                    else{
                                        while($row=mysqli_fetch_assoc($result)){
                                            $target_id=$row['target_id'];
                                            $t_name=$row['nickname'];
                                            $t_photo=$row['photo'];
                                ?>    
                                        <li>
                                            <img src="../../temp/profile/<?php echo "{$t_photo}"; ?>" al="<?php echo "{$t_photo}"; ?>">
                                            <div class=artists_text>
                                                <a href="./other.php?id=<?php echo "{$target_id}";?>"><p class="username bold"><?php echo "{$t_name}";?></p></a>
                                            </div>
                                        </li>
                                <?php        
                                        }
                                        
                                    }
                                ?>
                            </ul>
                        
                    </div>
                    <div class="subwrapper" id="shop-wrapper">
                         
                        <div class="user-title">
                            <div class="titleinfo">
                                <p class="medium maininfo">상점</p>
                                <p id="postcnt">528</p>
                            </div>
                            <a href="./shopo.php?id=<?php echo "{$u_id}"?>" class="more">더보기</a>
                        </div>
                        <div class="works-container" id="shop">
                        <?php
                            $query="SELECT shop.s_id, shop.w_id, work.image, work.title, shop.price from shop inner join work on shop.w_id=work.w_id where shop.u_id={$u_id} order by s_id desc limit 8";
                            $result=mysqli_query($db, $query) or die("shop select fails".mysqli_error($db));
                            while($row=mysqli_fetch_assoc($result)){
                                $w_id=$row['w_id'];
                                $s_id=$row['s_id'];
                                $price=$row['price'];
                                $image=$row['image'];
                                $title=$row['title'];
                            ?>
                            <a href="#" class="item">
                                <img src="../../temp/<?php echo "{$image}"; ?>" alt=<?php echo "{$image}"; ?>>
                                <div class="goods-info">
                                    <p id="title-value"><?php echo "{$title}"; ?></p>
                                    <div class="subinfo">
                                        <div class="price"><p class="bold" id="price-value"><?php echo "{$price}"; ?></p>&nbsp;원</div>
                                    </div>
                                </div>
                            </a>
                            <?php
                            }
                            ?>
                        </div>
                        
                    </div>
                    </div>
                </div> 


            </div>
        </main>
        
        
       <script src="../js/input_limit.js"></script>
       <script src="../js/subscribe.js"></script>
    </body>
</html>
