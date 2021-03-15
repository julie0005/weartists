<!DOCTYPE html>
<html lnag="ko">
    <head>
        <meta charset="UTF-8">
        <title>회원가입</title>
        <link rel="stylesheet" href="register.css">
        
    </head>
    <body>
        <!-- header -->
        <header>
			<div class="logo-wrap">
				<a href="./main.html"><h1 class="bold">모두화가</h1></a>
			</div>
		</header>

        <!-- wrapper -->
        <div id="wrapper">

            <!-- content-->
            <div id="content">
                <form id="register-form" action="./register_ok.php" method="POST" onsubmit="return registerCheck()">
                <!-- ID -->
                <div>
                    <h3 class="join_title">
                        <label for="id" class="medium">아이디</label>
                    </h3>
                    <span class="box int_id">
                        <input type="text" id="id" name="id" class="int" maxlength="20" >
                        <span id="alertTxt">사용불가</span>
                    </span>
                    <span class="error_next_box"></span>
                </div>

                <div>
                    <h3 class="join_title">
                        <label for="nickname" class="medium">닉네임</label>
                    </h3>
                    <span class="box int_nickname">
                        <input type="text" id="nickname" name="nickname" class="int" maxlength="10" >
                        <span id="alertTxt">사용불가</span>
                    </span>
                    <span class="error_next_box"></span>
                </div>

                <!-- EMAIL -->
                <div>
                    <h3 class="join_title">
                        <label for="email" class="medium">이메일</label>
                    </h3>
                    <span class="box int_email">
                        <input type="text" id="email" name="email" class="int" maxlength="50" >
                    </span>
                    <span class="error_next_box"></span>
                </div>

                <!-- PW1 -->
                <div>
                    <h3 class="join_title"><label for="pswd1" class="medium">비밀번호</label></h3>
                    <span class="box int_pass">
                        <input type="password" id="pswd1" name="password" class="int" maxlength="16">
                        <span id="alertTxt">사용불가</span>
                    </span>
                    <span class="error_next_box"></span>
                </div>

                <!-- PW2 -->
                <div>
                    <h3 class="join_title"><label for="pswd2" class="medium">비밀번호 재확인</label></h3>
                    <span class="box int_pass_check">
                        <input type="password" id="pswd2" class="int" maxlength="16">
                    </span>
                    <span class="error_next_box"></span>
                </div>



                <!-- JOIN BTN-->
                <div class="btn_area">
                    <button type="submit" id="btnJoin">
                        <span class="bold">가입하기</span>
                    </button>
                </div>
                <div class="link"><a href="./login.html" class="already-member">이미 회원이신가요?</a></div>
                
                </form>
            </div> 
            <!-- content-->
        <footer>
            <span class="bold">We artists</span> <span>Copyright © 2021 Painter.co.Ltd. All rights reserved.</span>
       </footer>
        </div> 
        <!-- wrapper -->
        
    <script src="./js/register.js"></script>
    </body>
</html>