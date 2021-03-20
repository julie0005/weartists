<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include "../../db.php";
$profile_dir="../../temp/profile";
if(!isset($_SESSION['u_id'])){
    echo "<script>alert('로그인이 필요합니다.'); location.href='../login.php';</script>";
}
else{
    if($_POST['u_id']!=$_SESSION['u_id']) echo "<script>alert('수정할 수 있는 권한이 없습니다.'); history.back();</script>";
    $u_id=$_POST['u_id'];
    $query="SELECT * FROM user WHERE u_id={$u_id}";
    $result=mysqli_query($db, $query);
    if(!$result){
        die("user 조회 fails.<br>\n".mysqli_error($db));
    }
    else{
        $row=mysqli_fetch_assoc($result);
        $author=$row['nickname'];
        $profile_photo=$row['photo'];
        $works=$row['works'];
        $subscribers=$row['subscribers'];
        $profile=$row['profile'];
        if(isset($_POST['w_id'])){
            $w_id=$_POST['w_id'];
            $query="SELECT * FROM work WHERE w_id={$w_id}";
            $result=mysqli_query($db, $query) or die("작품 조회 fails.");
            $row=mysqli_fetch_assoc($result);
            $title=$row['title'];
            $description=$row['description'];
            $image=$row['image'];
            $g_id=$row['g_id'];
            $t_id=$row['t_id'];
            $s_id=$row['s_id'];
            $result=mysqli_query($db, "SELECT * FROM gallary WHERE g_id={$g_id}") or die("갤러리 조회 실패.");
            $row=mysqli_fetch_assoc($result);
            $gallary_title=$row['title'];

            $result=mysqli_query($db, "SELECT * FROM topic WHERE t_id={$t_id}") or die("주제 조회 실패.");
            $row=mysqli_fetch_assoc($result);
            $topic_title=$row['topic'];
            if($s_id!=NULL){
                $result=mysqli_query($db, "SELECT * FROM shop WHERE s_id={$s_id}") or die("상점 조회 실패.");
                $row=mysqli_fetch_assoc($result);
                $price=$row['price'];
            }
            else{
                $price=10000;
            }
        }
       
    }
}
?>
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
            <script type="text/javascript" src="../../smarteditor2-2.8.2.3/js/HuskyEZCreator.js" charset="utf-8"></script>
            
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
            <?php if(isset($_SESSION['u_id'])){?>
            <div class="logged">
                <a href="./index.php" class="bold">MY</a>
                &nbsp;&nbsp;&nbsp;&nbsp;<a href="./logout.php" class="medium">로그아웃</a>
            </div>
            <?php } else{?>
                <div class="logged">
                    <a href="./login.php">로그인</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="./register.php">회원가입</a>
                </div>
            <?php }?>
        </header>
        <main id="write">
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
                        <a href="./gallary.php">갤러리</a>
                        <a href="#">작가노트</a>
                        <a href="#">상점</a>
                        <a href="#">구독</a>
                    </div>
                </nav>
                <!-- user home -->
                <div class="form-group" id="frm">
                    <form method="POST" enctype="multipart/form-data" action="update_process.php" onsubmit="return submitContents();">
                      <input type="text" value="<?php echo "{$u_id}";?>" name="u_id" style="display:none;"></input>
                      <input type="text" value="<?php echo "{$w_id}";?>" name="w_id" style="display:none;"></input>
                      <input type="text" value="<?php echo "{$s_id}";?>" name="s_id" style="display:none;"></input>
                      <input type="text" value="work" name="category" style="display:none;"></input>
                      <input type="text" id="title" name="title" style="width:100%; height:40px; font-size:1.0rem; font-weight:700;" value="<?php echo "{$title}";?>" maxlength="40"></input>
                        <div class="file-upload" style="margin-bottom:10px;">
                            <div class="image-upload-wrap">
                                <input class="file-upload-input" type='file' name="upload" onchange="readURL(this);" accept="image/*" />
                                <div class="drag-text">
                                    <h3>Drag and drop a file or select add Image</h3>
                                </div>
                            </div>
                            <div class="file-upload-content" style="display:block;">
                                <img class="file-upload-image" src="../../temp/<?php echo "{$image}" ?>" alt="your image" />
                                <div class="image-title-wrap">
                                    <button type="button" onclick="removeUpload()" class="remove-image">삭제</button>
                                </div>
                                <input type="text" style="display:none;" name="previmg" value="<?php echo"{$image}";?>"></input>
                            </div>
                        </div>
                        <select id="gallary-folder" style="border:1px solid #dbdbdb;" name="g_id">
                            
                            <?php
                                if($gallary_title=="All") echo "<option value='{$g_id}' selected>갤러리 선택</option>";
                                else{echo "<option value='{$g_id}' selected>{$gallary_title}</option>";}
                               $query="select * from gallary where u_id={$u_id}";
                               $result=mysqli_query($db,$query) or die("알 수 없는 오류");
                               if(mysqli_num_rows($result)==0){
                                 die("사용자가 존재하지 않습니다.");
                               }
                               else{
                                while($row=mysqli_fetch_assoc($result)){
                                    if($row['title']=="All"){
                                        continue;
                                    }
                                    else{
                                        echo "<option value={$row['g_id']}>{$row['title']}</option>";
                                    }
                                }
                               } 
                            ?>
                        </select>
                        <select id="topic" style="border:1px solid #dbdbdb;" name="t_id">
                            <?php
                               echo "<option value={$t_id} selected>{$topic_title}</option>";
                               $query="select * from topic";
                               $result=mysqli_query($db,$query) or die("알 수 없는 오류");
                               if(mysqli_num_rows($result)==0){
                                 die("서버에 아무 주제가 존재하지 않습니다.");
                               }
                               else{
                                while($row=mysqli_fetch_assoc($result)){
                                    if($row['topic']=="기타"){
                                        continue;
                                    }
                                    else{
                                        echo "<option value={$row['t_id']}>{$row['topic']}</option>";
                                    }
                                }
                               } 
                            ?>
                        </select>
                        <textarea id="artist-statement" name="artist-statement" style="width:100%; height:120px; font-size:0.9rem;" placeholder="작품을 300자 내로 설명해주세요." maxlength="300"><?php echo "{$description}"?></textarea>
                        <div class="shop-form">
                            <p class="ask" style="font-size:0.9rem; margin-top:10px;">판매하시겠습니까?&nbsp;&nbsp;
                            <?php if($s_id==NULL){?>
                            <input type="radio" name="isShop" value="true"> 예&nbsp;&nbsp;
                            <input type="radio" name="isShop" value="false" checked> 아니오
                            </p>
                            <?php } else{?>
                                <input type="radio" name="isShop" value="true" checked> 예&nbsp;&nbsp;
                                <input type="radio" name="isShop" value="false"> 아니오
                            <?php } ?>
                            <div class="price-input" style="display:none;">
                                <p style="font-size:0.9rem; margin-top:5px;">가격 : 
                                <input type="text" maxlength="7" id="price" name="price" style="width:130px; border:1px solid #dbdbdb;" 
                                value=<?php echo "{$price}";?> oninput=checkPrice(this)></input>
                                    원
                                </p>
                                <p style="font-size:0.8rem; margin-top:5px;color:red;">최대 백만원까지 입력할 수 있습니다.</p>
                            </div>
                        </div>
                        
                      <button type="submit" class="dd-button" id="save-button">수정하기</button>
                      <button type="button" class="dd-button" id="cancel-button" onclick="history.back()">취소</button>
                    </form>
                </div>
            </div>
        </main>
        
        
        <script type="text/javascript" src="../js/update-work.js"></script>
        <script type="text/javascript" src="../js/input_limit.js"></script>
        <script type="text/javascript">
            let price_input=document.querySelector('.price-input');
            if($("input:radio[name='isShop']:checked").val()=="true"){
                price_input.style.display='block';
            }
            else{
                price_input.style.display='none';
            }
            $('input[name=isShop]').change(function(){
                if($("input:radio[name='isShop']:checked").val()=="true"){
                    price_input.style.display='block';
                }
                else{
                    price_input.style.display='none';
                }
            });
        </script>
    </body>
</html>
