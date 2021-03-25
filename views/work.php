<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include "../db.php";
$profile_dir="../temp/profile";
$image_dir="../temp";
if(!isset($_GET['id'])){
    echo "<script>alert('이용할 수 없는 페이지입니다.'); location.href=history.back();</script>";
}
$w_id=$_GET['id'];
$result=mysqli_query($db, "SELECT * FROM work WHERE w_id=$w_id");
if(!$result){
    die("work table 불러오기 fails.<br>\n".mysqli_error($db));
}
else{
    if(mysqli_num_rows($result)==0){
        echo("<script>alert('해당 글은 존재하지 않습니다.'); history.back();</script>");
    }
    $row=mysqli_fetch_assoc($result);
    $title=$row['title'];
    $description=$row['description'];
    $update_date=$row['update_date'];
    $g_id=$row['g_id'];
    $image=$row['image'];
    $t_id=$row['t_id'];
    $view=$row['views'];
    $u_id=$row['u_id'];
    $s_id=$row['s_id'];
    $like=$row['likes'];
    $comments=$row['comments'];
    $result=mysqli_query($db, "SELECT * FROM user WHERE u_id={$u_id}");
    if(!$result) die("user 조회 fails.<br>\n".mysqli_error($db));
    else{
        $row=mysqli_fetch_assoc($result);
        $author=$row['nickname'];
        $profile_img=$row['photo'];
    }
    if(isset($_SESSION['u_id'])){
        $visitorid=$_SESSION['u_id'];
        $result=mysqli_query($db, "SELECT photo from user where u_id={$visitorid}") or die("visitor select fails.".mysqli_error($db));
        $row=mysqli_fetch_assoc($result);
        $v_photo=$row['photo'];
    }
    else{
        $v_photo="blank.png";
    }

    //조회수 업데이트
    if(empty($_COOKIE['board_work_' . $w_id])) {
        $view++;
		$result=mysqli_query($db, "UPDATE work SET views={$view} WHERE w_id={$w_id}");

		if(empty($result)) {
			die("조회수 업데이트 실패".mysqli_error($db));
		} else {
			setcookie('board_work_' . $w_id, TRUE, time() + (60 * 60 * 24), '/weartists/views/');
		}
	}
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
            <link rel="stylesheet" href="./header.css">
            <link rel="stylesheet" href="./user/index.css">
            <link rel="stylesheet" href="./detail.css">
            <meta name="description" content="우리 모두는 화가입니다.">
    </head>
    <body id="detail">
        <!-- Header -->
        <header class="page-header wrapper">
            <div id=header_main>
                <h1 class="bold logo"><a href="main.php">모두화가</a></h1>
                <form class="search-container" id="search-form" onsubmit="return checkSearch()">
                    <input type="text" id="search-bar" placeholder="오늘은 어떤 그림을 구경할래요?">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
                <?php
                    if(!isset($_SESSION['u_id'])){
                ?>
                <div id=header_account>
                    <a href="./login.php">로그인</a>
                    <a href="./register.php">회원가입</a>
                </div>
                <?php } else{?>
                    <div id=header_account>
                        <a href="./user/index.php">MY</a>
                        <a href="./logout.php">로그아웃</a>
                    </div>
                <?php } ?>
        </header>
        <main>
            <nav class="top-nav bold">
                <div id=topnav-container>
                    <a href="main.php">홈</a>
                    <a href="./topic/index.php">주제</a>
                    <a href="./workboard.php">워크<br>보드</a>
                    <a href="./feed/index.php">피드</a>
                </div>
            </nav>
            <div id="main-contents">
                <section class="feed">
                    <ul>
                        <a href="javascript:window.history.back();" class="backward"><i class="fas fa-chevron-left"></i></a> 
                        <li>
                            <article class="gallary-container">
                                <div class="post-info">
                                    <div class=post-maininfo>
                                        <img class="user-profile" src=<?php echo "{$profile_dir}/{$profile_img}";?> alt=프로필>
                                        <h2 class="title text bold" name="title"><?php echo "{$title}";?></h2>
                                        <a href="./user/other.php?id=<?php echo"{$u_id}";?>"><p class="username text medium" name="author"><?php echo "{$author}";?></p></a>
                                    </div>
                                    <div class="post-subinfo">
                                        <p class="update"><?php echo "{$update_date}";?></p>
                                        <p class="pageview"><?php echo "{$view}";?>회</p>
                                    </div>
                                </div>
                                <div class="body-contents">
                                    <a href="#"><i class="fas fa-chevron-left"></i></a>
                                    <img class="body-image" src=<?php echo "{$image_dir}/{$image}";?> alt="작품">
                                    <a href="#"><i class="fas fa-chevron-right"></i></a> 
                                </div>
                                <div class="icon-bar">
                                    <?php
                                    if(isset($_SESSION['u_id'])){
                                    ?>
                                        <button type='button' class='like' value=<?php echo "{$w_id}"?>>
                                    <?php
                                        $result=mysqli_query($db, "SELECT * FROM `like` WHERE u_id={$visitorid} AND w_id={$w_id}") or die("like 테이블 조회 실패.".mysqli_error($db));
                                        if(mysqli_num_rows($result)==0){
                                            echo "<i class='far fa-heart' aria-hidden='true'></i>";
                                        }
                                        else{
                                            echo "<i class='fa fa-heart' aria-hidden='true'></i>";
                                        }
                                        echo "</button>";
                                    } else{
                                    ?>
                                        <a href="./login.php"><i class='far fa-heart' aria-hidden='true'></i></a>
                                    <?php } ?>    
                                    <!-- 좋아요 -->

                                    <?php if($s_id!=NULL){?>
                                    <a><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>
                                    <?php }?>
                                    <!-- 쇼핑 -->
                                    
                                    <button type="button"><i class="fa fa-expand" aria-hidden="true"></i></button>
                                    <!--  -->
                                    <?php if(isset($_SESSION['u_id']) && $_SESSION['u_id']==$u_id){?>
                                    <form method=POST action="./user/update-work.php">
                                        <input type=hidden value="<?php echo "{$w_id}";?>" name="w_id">
                                        <input type=hidden value="<?php echo "{$u_id}";?>" name="u_id">
                                        <button><i class="fa fa-edit" style="font-size:1.3rem;" aria-hidden="true"></i></button>
                                    </form>
                                    <form method=POST action="./user/delete.php">
                                        <input type=hidden value="<?php echo "{$w_id}";?>" name="w_id">
                                        <input type=hidden value="<?php echo "{$u_id}";?>" name="u_id">
                                        <input type=hidden value="<?php echo "{$s_id}";?>" name="s_id">
                                        <input type=hidden value="<?php echo "{$image}";?>" name="image">
                                        <button><i class="fa fa-trash" style="font-size:1.3rem;" aria-hidden="true"></i></button>
                                    </form>
                                    <?php }?>
                                    <p style="font-size:1.0rem; margin:auto 0;position:absolute; right:30px;" class="medium likeCount"><?php echo "{$like}";?> likes</p>
                                </div>
                                <div class="description">
                                    <p name="description"><?php echo "{$description}";?></p>
                                </div>
                                
                            </article>
                                <div class="comments-container" id="comments-loc">
                                    <div class="comments-header">
                                        <div class=group>
                                            <h4 class="text">Comments</h4>
                                            <p class="count text regular"><?php echo "{$comments}";?></p>
                                        </div>
                                        <p class="comment-filter">정렬 기준</p>
                                    </div>
                                    <div class="my-comment">
                                        <img class="user-profile" src="../temp/profile/<?php echo "{$v_photo}";?>" alt="<?php echo "{$v_photo}";?>">
                                        <div class="comments-post-container comments-post">
                                            <input type="text" maxlength="200" class="comment-bar" placeholder="댓글 추가...">
                                            <button type="button" class="comment-button medium commentbtn" value="<?php echo "{$w_id}";?>">
                                                댓글
                                            </button>
                                        </div>
                                    </div>
                                    <div class="other-comments-container">

                                        <ul>
                                            <?php
                                                $query="SELECT user.u_id, user.nickname, user.photo, comment.c_id, comment.update_date, comment.contents from user inner join comment on comment.u_id=user.u_id WHERE writing_id={$w_id} order by c_id desc";
                                                $result=mysqli_query($db, $query) or die("댓글 조회 실패".mysqli_error($db)); 
                                                while($row=mysqli_fetch_assoc($result)){
                                                    $cu_id=$row['u_id'];
                                                    $cname=$row['nickname'];
                                                    $cimage=$row['photo'];
                                                    $c_id=$row['c_id'];
                                                    $update_date=$row['update_date'];
                                                    $contents=$row['contents'];
                                            ?>
                                            <li class="first">
                                                <div class="other-comments">
                                                    <img class="user-profile" src="../temp/profile/<?php echo"{$cimage}"?>" alt="<?php echo"{$cimage}"?>">
                                                    <div class="none-image">
                                                        <p class="medium text user"><?php echo"{$cname}"?></p>
                                                        <p class="update text"><?php echo"{$update_date}"?></p>
                                                        <?php if(isset($_SESSION['u_id']) && $visitorid==$cu_id){?>
                                                        <button type="button" class="deletebtn text" value="<?php echo"{$c_id}"?>">삭제</button>
                                                        <?php }?>
                                                        <div class="comment-bar2">
                                                            <?php echo"{$contents}"?>
                                                        </div>
                                                        <button type="button" class="comment-comment-button medium" value="<?php echo "{$c_id}";?>">
                                                            답글
                                                        </button>
                                                        <?php
                                                            $query2="select count(*) as cnt from ccomment where c_id={$c_id}";
                                                            $result2=mysqli_query($db,$query2) or die("ccomment count fails".mysqli_error($db));
                                                            if(mysqli_num_rows($result2)!=0){
                                                        ?>
                                                        <button type="button" class="seeccomments medium" value="<?php echo "{$c_id}";?>">답글 보기</button>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <div class="ccomments"></div>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                        </li>
                    </ul>
                </section>
                <aside>
                    <div>
                        Here is Aside
                    </div>
                </aside>
            </div>
        </main>
        
        
       <script src="./js/input_limit.js"></script>
       <script src="./js/comment.js"></script>
        <script>
            //동시 접속. 나와 나는 동시 접속이 안되지만 나와 타인은 동시 접속이 가능하게하려면..?
            var accessableCount=1;
            $('.like').dblclick(function(e){
                accessableCount  = accessableCount -1;
                if(accessableCount>=0){
                    var likeObj=$(this);
                    $.ajax({
                        url:"./ajax/ajax-like.php",
                        type:"POST",
                        dataType:'json',
                        data:{
                            //작가노트 type : 1, 작품 type : 0
                            'type':0,
                            'w_id':<?php echo "{$w_id}"; ?>,
                            'u_id':<?php if(isset($visitorid)){echo "{$visitorid}";} else {echo "-1";}?>
                        },
                        success : function(data){
                            
                            if(data[0].success){
                                alert("좋아요 성공!");
                                let likeCount=data[0].likes;
                                likeObj.html("<i class='fa fa-heart' aria-hidden='true'>");
                                likeObj.parent('div.icon-bar').children('p.likeCount').html(likeCount+" likes");
                            }
                            else{
                                alert("좋아요를 이미 하셨습니다.");
                            }
                            accessableCount  = accessableCount+1;
                        },
                        error : function(err){
                            console.log(err);
                            accessableCount  = accessableCount+1;
                        }

                    });
                }
               
                
                
            })

        </script>

    </body>
</html>
