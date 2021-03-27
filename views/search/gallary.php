<?php
    include "../../db.php";
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
                <div class="wrapper" id="gallary-wrapper">
                    <div class="search-title">
                        <?php
                        $result=mysqli_query($db, "select count(*) as cnt from gallary inner join user on gallary.u_id=user.u_id where title like '%{$squery}%' or user.nickname like '%{$squery}%'");
                        $row=mysqli_fetch_assoc($result);
                        $cnt=$row['cnt'];
                        ?>
                        <div class="titleinfo">
                            <p class="bold maininfo">갤러리</p>
                            <p id="gallarycnt"><?php echo"{$cnt}"; ?></p>
                        </div>
                    </div>
                    <?php if($cnt ==0){
                        echo "<div class='msg'>검색 결과가 존재하지 않습니다.</div>";
                    } ?>
                    <div id="ajaxg" class="works-container">
                    <?php
                            if($cnt!=0){
                            $query="select gallary.*,user.nickname from gallary inner join user on gallary.u_id=user.u_id where gallary.title like '%{$squery}%' or user.nickname like '%{$squery}%' limit 20";
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
                
               
                
        </main>

        <script src="../js/input_limit.js"></script>
        <script type="text/javascript">
            //갤러리 폴더 infinite scroll.  
            var next_page=2;
            var sync=true;
            $(window).on('load',function(){
                $(document).on("scroll", function(){
                    if($(document).height()<=$(window).scrollTop()+$(window).height()+80 && sync==true){
                        sync=false;
                        $.ajax({
                            url: "../ajax/search/ajax-sgallary.php",
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
                                            "<a href='../user/gallaryo.php?id="+val.gu_id+"&idx="+val.g_id+"' class='item' style='display:none;'>"
                                            +"<img src='../../temp/gallarythumb/"+val.thumbnail+"' alt="+val.thumbnail+">"
                                            +"<div class='gallary-text'><p class='gallary-name bold' id='gallary-name-default'>"+val.gallary_title+"</p><p class='gallary-author'>"+val.gauthor+"</p></div>"
                                            +"</a>";
                                            $("#ajaxg").append($elem);
                                    });
                                    $('#ajaxg').imagesLoaded(function(){
                                        $(".item").css('display','block');
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
