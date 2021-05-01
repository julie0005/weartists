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
    //default : 인기 순
    $ordercd="views+comments+likes";

    //$andcd="work.update_date>date_add(now().internal-1 year";
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
            <meta charset="UTF-8">
            <title>모두화가</title>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                        <div class="titleinfo">
                        <?php
                            $result=mysqli_query($db, "select count(*) as cnt from shop inner join work on shop.w_id=work.w_id inner join user on work.u_id=user.u_id where user.nickname like '%{$squery}%' or work.title like '%{$squery}%' or work.description like '%{$squery}%'");
                            $row=mysqli_fetch_assoc($result);
                            $cnt=$row['cnt'];
                        ?>
                            <p class="bold maininfo">판매 작품</p>
                            <p id="gallarycnt"><?php echo "{$cnt}"; ?></p>
                            <label class="dropdown">

                                <div class="dd-button">
                                <li class='popular' value=''>인기 순</li>
                                </div>
                              
                                <input type="checkbox" class="dd-input" id="test">
                              
                                <ul id="filter" class="dd-menu">
                                  <li class='recent' value=''>최신 순</li>
                                  <li class='popular' value=''>인기 순</li>
                                  <li class='limit' value='1 week'>1주일 내</li>
                                  <li class='limit' value='1 month'>1달 내</li>
                                  <li class='limit' value='1 year'>1년 내</li>
                                </ul>
                                
                              </label>
                        </div>
                    </div>
                    <?php if($cnt ==0){
                        echo "<div class='msg'>검색 결과가 존재하지 않습니다.</div>";
                    } ?>
                        <div class="container_works ajax" id=shop-container>
                            <?php if($cnt!=0){
                                $query="select shop.*, work.*, user.nickname from shop inner join work on shop.w_id=work.w_id inner join user on work.u_id=user.u_id where user.nickname like '%{$squery}%' or work.title like '%{$squery}%' or work.description like '%{$squery}%'";
                                if(isset($andcd)){
                                    $query.="and {$andcd} ";
                                }
                                $query.="order by {$ordercd} desc limit 20";
                                $result=mysqli_query($db, $query) or die("작가 불러오기 실패.".mysqli_error($db));    
                                while($row=mysqli_fetch_assoc($result)){
                                    $sw_id=$row['w_id'];
                                    $su_name=$row['nickname'];
                                    $stitle=$row['title'];
                                    $simage=$row['image'];
                                    $price=$row['price'];
                            ?>
                            <a href="#" class="mason-item">
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
                
               
                
        </main>


        <script src="../js/input_limit.js"></script>
        <script src="../js/masonry.js"></script>
        <script type="text/javascript"> 
            //필터
            var next_page=2;
            var syncf=true;
            $(document).on('click','#filter li',function(){
                if(syncf==false) return;
                var syncf=false;
                let btn=$(this);
                let date=$(this).attr('value');
                let btnc=$(this).clone();
                let classify=btn.attr('class');
                if(btn.text()==btn.parents('.dropdown').find('.dd-button li').text()){
                    return;
                }
                btn.parents('.dropdown').children('.dd-button').html(btnc);
                $.ajax({
                    url: "../ajax/search/ajax-sshop.php",
                    type:"POST",
                    dataType:'json',
                    data:{
                        'page':1,
                        'squery':<?php echo "'{$squery}'"; ?>,
                        'orderby':classify,
                        'datelimit':date
                    },
                    success:function(data){
                        //여기서 container 안에 내용 비우고, ajax로 가져온 데이터로 대체하기.
                        next_page=2;
                        $('.ajax').empty();
                        $('.msg').remove();
                        if(data.length!=0){
                            $.each(data,function(key,val){
                                var $elem=
                                "<a href='#' class='mason-item' style='display:none;'>"
                                +"<img class='mason-image' src='../../temp/"+val.image+"' alt="+val.image+">"
                                +"<div class='goods-info'>"
                                +"<p id='title-value'>"+val.title+"</p>"
                                +"<div class='subinfo'>"
                                +"<div class='price'><p class='bold' id='price-value'>"+val.price+"</p>&nbsp;원</div>"
                                +"<div class='artist'>작가&nbsp;<p id='artist-value'>"+val.su_name+"</p></div>"
                                +"</div></div></a>"
                                $(".ajax").append($elem);
                                    
                            });
                            $('.ajax').imagesLoaded(function(){
                                $(".mason-item").css('display','block');
                                $(".ajax").masonry('reloadItems');
                                $('.ajax').masonry('layout');
                                syncf=true;
                            });
                            
                        }
                        else{
                            $("<div class='msg'>검색 결과가 존재하지 않습니다.</div>").insertBefore('.ajax');
                            syncf=true;
                        }
                        
                    },
                    error:function(err){
                        console.log(err);
                        syncf=true;
                    }

                });

            });
            
            //페이징
            var sync=true;
            $(window).on('load',function(){
                $(document).on("scroll", function(){
                    console.log("Scroll event");
                    if($(document).height()<=$(window).scrollTop()+$(window).height()+80 && sync==true){
                        sync=false;
                        let classify=$('.dropdown').find('.dd-button li').attr('class');
                        let date=$('.dropdown').find('.dd-button li').attr('value');
                        $.ajax({
                            url: "../ajax/search/ajax-sshop.php",
                            type: "POST",
                            dataType:'json',
                            data: {
                                'page':next_page,
                                'squery':<?php echo "'{$squery}'"; ?>,
                                'orderby':classify,
                                'datelimit':date
                                 
                            },
                            success : function(data){
                                
                                if(data.length!=0){
                                    next_page+=1;
                                    console.log(next_page);
                                    $.each(data,function(key,val){
                                        var $elem=
                                            "<a href='#' class='mason-item' style='display:none;'>"
                                            +"<img class='mason-image' src='../../temp/"+val.image+"' alt="+val.image+">"
                                            +"<div class='goods-info'>"
                                            +"<p id='title-value'>"+val.title+"</p>"
                                            +"<div class='subinfo'>"
                                            +"<div class='price'><p class='bold' id='price-value'>"+val.price+"</p>&nbsp;원</div>"
                                            +"<div class='artist'>작가&nbsp;<p id='artist-value'>"+val.su_name+"</p></div>"
                                            +"</div></div></a>"
                                            $(".ajax").append($elem);
                                            
                                    });
                                    $('.ajax').imagesLoaded(function(){
                                        $(".mason-item").css('display','block');
                                        $(".ajax").masonry('reloadItems');
                                        $('.ajax').masonry('layout');
                                        sync=true;
                                    });
                                
                                }
                                else{
                                    sync=true;
                                }
                               
                    
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
