<?php
    include "../../db.php";
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
            <meta charset="UTF-8">
            <title>모두화가</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="../header.css">
            <link rel="stylesheet" href="./home-topic.css">
            <meta name="description" content="우리 모두는 화가입니다.">
    </head>
    <body>
        <!-- Header -->
       
        <div id="header_all">
            <header class="page-header wrapper">
                <div id=header_main>
                    <h1 class="bold logo"><a href="../main.php">모두화가</a></h1>
                    <form class="search-container" id="search-form" onsubmit="return checkSearch()">
                        <input type="text" id="search-bar" placeholder="오늘은 어떤 그림을 구경할래요?">
                        <button type="submit" class="searchButton">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
                <?php
                    if(!isset($_SESSION['u_id'])){
                        //방문자
                ?>
                <div id=header_account>
                    <a href="../login.php">로그인</a>
                    <a href="../register.php">회원가입</a>
                </div>
                <?php } else{
                        //로그인한 사람
                        $u_id=$_SESSION['u_id'];
                        $result=mysqli_query($db,"SELECT nickname FROM user WHERE u_id={$u_id}") or die("user select fails.".mysqli_error($db));
                        $row=mysqli_fetch_assoc($result);
                        $username=$row['nickname'];
                ?>
                    <div id=header_account>
                        <a href="../user/index.php">MY</a>
                        <a href="../logout.php">로그아웃</a>
                    </div>
                <?php } ?>
            </header>
            <nav class="top-nav bold">
                <div id=topnav-container>
                    <a href="../main.php">Home</a>
                    <a href="./topic/index.php">주제</a>
                    <a href="../workboard.php">워크보드</a>
                    <a href="../feed/index.php">피드</a>
                </div>
            </nav>
        </div>
        
        <!-- SideBar -->
        <main id="topic">
            <div class="sidebar-container">
                <div class="sidebar-logo">
                <u class="medium">
                    <a href="../user/index.php">
                        <?php if(isset($_SESSION['u_id'])){
                            echo "{$username}";
                        }else{
                            echo "User";
                        } ?>
                    </a>
                </u> 
                님, 안녕하세요!
                </div>
                <ul class="sidebar-navigation">
                <li class="header medium">전체 주제</li>
                <?php
                    $result=mysqli_query($db,"SELECT * FROM topic ORDER BY t_id DESC");
                    while($row=mysqli_fetch_assoc($result)){
                        $topicname=$row['topic'];
                        $t_id=$row['t_id'];
                        if($t_id!=11){
                ?>
                <li>
                    <a href="./topic.php?id=<?php echo"{$t_id}";?>">
                    <?php echo"{$topicname}";?>
                    </a>
                </li>
                <?php }} ?>
                </ul>
            </div>
            
            <section class="feed">
                <div id="popular_topics">
                    <div class="title medium" href="#">인기 주제</div>
                    <div class="container_items">
                        <?php
                            $result=mysqli_query($db,"SELECT * FROM topic LIMIT 8");
                            while($row=mysqli_fetch_assoc($result)){
                                $topicname=$row['topic'];
                                $t_id=$row['t_id'];
                        ?>
                        <a class="topic bold" href="./topic.php?id=<?php echo"{$t_id}";?>"><?php echo"{$topicname}";?></a>
                        <?php } ?>
                    </div>
                </div>
            </section>


        </main>
            

        
        

    </body>
</html>