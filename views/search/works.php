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
            <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
            <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.js"></script>
            <meta name="description" content="우리 모두는 화가입니다.">
    </head>
    <body>
        <!-- Header -->
       
        <div id="header_all">
            <header class="page-header wrapper">
                <div id=header_main>
                    <h1 class="bold logo"><a href="../main.php">모두화가</a></h1>
                    <form class="search-container" id="search-form" action="index.php" method="get" onsubmit="return checkSearch()">
                        <input type="text" id="search-bar" name="query" maxlength="100" value='<?php echo"{$squery}";?>' placeholder="오늘은 어떤 그림을 구경할래요?">
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
                        <input type="hidden" name="query" maxlength="100" value='<?php echo"{$squery}";?>'>
                        <button type="submit">통합</button>
                    </form>
                    <form class="searchnav-link" action="./works.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value='<?php echo"{$squery}";?>'>
                        <button type="submit">작품</button>
                    </form>
                    <form class="searchnav-link" action="./gallary.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value='<?php echo"{$squery}";?>'>
                        <button type="submit">갤러리</button>
                    </form>
                    <form class="searchnav-link" action="./artists.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value='<?php echo"{$squery}";?>'>
                        <button type="submit">작가</button>
                    </form>
                    <form class="searchnav-link" action="./shop.php" method="get">
                        <input type="hidden" name="query" maxlength="100" value='<?php echo"{$squery}";?>'>
                        <button type="submit">상점</button>
                    </form>
                </nav>
            </div>
                <div class="wrapper" id="works-wrapper">
                    <div class="search-title">
                        <?php
                            $query="SELECT COUNT(*) as cnt FROM user INNER JOIN work ON user.u_id=work.u_id where work.title like '%{$squery}%' or work.description like '%{$squery}' or user.nickname like '%{$squery}'";
                            $result=mysqli_query($db, $query) or die("work cnt fails".mysqli_error($db));
                            $row=mysqli_fetch_assoc($result);
                            $cnt=$row['cnt'];
                        ?>
                        <div class="titleinfo">
                            <p class="bold maininfo">작품</p>
                            <p id="gallarycnt"><?php echo "{$cnt}"; ?></p>
                            <label class="dropdown">

                                <div class="dd-button">
                                  최신 순
                                </div>
                              
                                <input type="checkbox" class="dd-input" id="test">
                              
                                <ul class="dd-menu">
                                  <li>인기 순</li>
                                  <li>1주일 내</li>
                                  <li>1달 내</li>
                                  <li>1년 내</li>
                                </ul>
                                
                              </label>
                        </div>
                    </div>
                    <?php if($cnt ==0){
                        echo "<div class='msg'>검색 결과가 존재하지 않습니다.</div>";
                    } ?>
                    <div id="ajax" class="container_works">
                        <?php
                            $query="SELECT user.nickname, work.* FROM user INNER JOIN work ON user.u_id=work.u_id where work.title like '%{$squery}%' or work.description like '%{$squery}' or user.nickname like '%{$squery}' ORDER BY update_date DESC LIMIT 20";
                            $result=mysqli_query($db, $query) or die("work select fails".mysqli_error($db));
                            while($row=mysqli_fetch_assoc($result)){
                                $w_id=$row['w_id'];
                                $image=$row['image'];
                                $title=$row['title'];
                                $description=$row['description'];
                                $views=$row['views'];
                                $likes=$row['likes'];
                                $comments=$row['comments'];
                                $u_id=$row['u_id'];
                                $s_id=$row['s_id'];
                                $update_date=$row['update_date'];
                                $nickname=$row['nickname'];
                        ?>
                        <a href="../work.php?id=<?php echo "{$w_id}"?>" class="mason-item">
                            <img class="mason-image" src="<?php echo "{$img_dir}"; ?>/<?php echo "{$image}"; ?>" alt=<?php echo "{$image}"; ?>>
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
                
               
                
        </main>
        

        <script src="../js/input_limit.js"></script>
        <script src="../js/masonry.js"></script>
        <script type="text/javascript"> 
            var next_page=2;
            var sync=true;
            $(window).scrollTop(200);
            $(window).on('load',function(){
                $(document).on("scroll", function(){
                    console.log("Scroll event");
                    if($(document).height()<=$(window).scrollTop()+$(window).height()+80 && sync==true){
                        sync=false;
                        console.log("ajax before next_page : "+next_page);
                        $.ajax({
                            url: "../ajax/search/ajax-swork.php",
                            type: "POST",
                            dataType:'json',
                            data: {
                                'page':next_page,
                                'squery':<?php echo "'{$squery}'"; ?>
                            },
                            success : function(data){
                            next_page+=1;
                            if(data.length!=0){
                                console.log(next_page);
                                $.each(data,function(key,val){
                                    var $elem=
                                        "<a href='./work.php?id="+val.w_id+"' class='mason-item' style='display:none;'>"
                                        +"<img class='mason-image' src='../../temp/"+val.image+"' alt="+val.image+">"
                                        +"<div class='text_content'>"
                                        +"<p class='title'>"+val.title+"</p>"
                                        +"<p class='artists'>"+val.nickname+"</p>"
                                        +"<div class='sub_description'>"
                                        +"<i class='fas fa-heart'></i>&nbsp;"
                                        +"<span class='likes'>"+val.likes+"</span>&nbsp;&nbsp;"
                                        +"<i class='fas fa-comment'></i>&nbsp;"
                                        +"<span class='comments'>"+val.comments+"</span>"
                                        +"</div></div></a>";
                                        $("#ajax").append($elem);
                                        
                                });
                                $('#ajax').imagesLoaded(function(){
                                    $(".mason-item").css('display','block');
                                    $("#ajax").masonry('reloadItems');
                                    $('#ajax').masonry('layout');
                                    
                                });
                               
                            }
                            sync=true;
                    
                            },
                            error : function(err){
                                console.log(err);
                                sync=true;
                            }
                        });
                    }
                });
            });
            

        </script>
        
    </body>
</html>
