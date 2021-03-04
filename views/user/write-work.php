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
            <div id="logged">
                <a href="./index.html" class="bold">MY</a>
                &nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="medium">로그아웃</a>
            </div>
        </header>
        <main id="write">
            <nav class="top-nav bold">
                <div id=topnav-container>
                    <a href="main.html">홈</a>
                    <a href="./topic/index.html">주제</a>
                    <a href="./workboard.html">워크<br>보드</a>
                    <a href="./feed/post.html">피드</a>
                </div>
            </nav>
            <div id="main-contents">
                <!-- user info -->
                <div class="user-info">
                    <div class=user-maininfo>
                        <img class="user-profile" src="../../resources/arab.jpg" alt=프로필>
                        <div class="textinfo">
                            <h3 class="username bold">고몽</h3>
                            <div class="user-subinfo">
                                <span class="follower">1k 구독자</span>&nbsp;&nbsp;|&nbsp;
                                <span class="works-number">512</span>&nbsp;작품
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
                    <form method="POST" enctype="multipart/form-data" action="write_process.php" onsubmit="return submitContents();">
                      <input type="text" value="work" name="category" style="display:none;"></input>
                      <input type="text" id="title" name="title" style="width:100%; height:40px; font-size:1.0rem; font-weight:700;" placeholder="제목" maxlength="40"></input>
                        <div class="file-upload" style="margin-bottom:10px;">
                            <div class="image-upload-wrap">
                                <input class="file-upload-input" type='file' name="upload" onchange="readURL(this);" accept="image/*" />
                                <div class="drag-text">
                                    <h3>Drag and drop a file or select add Image</h3>
                                </div>
                            </div>
                            <div class="file-upload-content">
                                <img class="file-upload-image" src="#" alt="your image" />
                                <div class="image-title-wrap">
                                    <button type="button" onclick="removeUpload()" class="remove-image">삭제</button>
                                </div>
                            </div>
                        </div>
                        <select id="gallary-folder" style="border:1px solid #dbdbdb;" name="gallary-folder">
                            <option value="" selected>갤러리 선택</option>
                            <?php
                               $folder_array=array("밤하늘", "낮에 뜨는 달");
                               foreach($folder_array as $value){
                            ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                        <select id="topic" style="border:1px solid #dbdbdb;" name="topic">
                            <option value="" selected>주제 선택</option>
                            <option value="유화">유화</option>
                            <option value="수채화">수채화</option>
                            <option value="공예">공예</option>
                            <option value="판타지">판타지</option>
                            <option value="한국화">한국화</option>
                            <option value="서양화">서양화</option>
                            <option value="3D펜">3D펜</option>
                            <option value="일러스트">일러스트</option>
                            <option value="팬아트">팬아트</option>
                            <option value="캐릭터">캐릭터</option>
                            <option value="굿즈">굿즈</option>
                        </select>
                        <textarea id="artist-statement" name="artist-statement" style="width:100%; height:120px; font-size:0.9rem;" placeholder="작품을 200자 내로 설명해주세요." maxlength="200"></textarea>
                        <div class="shop-form">
                            <p class="ask" style="font-size:0.9rem; margin-top:10px;">판매하시겠습니까?&nbsp;&nbsp;
                            <input type="radio" name="isShop" value="true"> 예&nbsp;&nbsp;
                            <input type="radio" name="isShop" value="false" checked> 아니오
                            </p>
                            <div class="price-input" style="display:none;">
                                <p style="font-size:0.9rem; margin-top:5px;">가격 : 
                                <input type="text" maxlength="7" id="price" name="price" style="width:130px; border:1px solid #dbdbdb;" placeholder="10000" oninput=checkPrice(this)></input>
                                    원
                                </p>
                                <p style="font-size:0.8rem; margin-top:5px;color:red;">최대 백만원까지 입력할 수 있습니다.</p>
                            </div>
                        </div>
                        
                      <button type="submit" class="dd-button" id="save-button">저장</button>
                      <button type="button" class="dd-button" id="cancel-button" onclick="history.back()">취소</button>
                    </form>
                </div>
            </div>
        </main>
        
        
        <script type="text/javascript" src="../js/write-work.js"></script>
        <script type="text/javascript" src="../js/input_limit.js"></script>
        <script type="text/javascript">
            let price_input=document.querySelector('.price-input');
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
