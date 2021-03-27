<!doctype HTML>
<head>
	<meta charset="UTF-8">
	<title>로그인</title>
	<link rel="stylesheet" href="login.css">
	<script src="https://kit.fontawesome.com/51db22a717.js" crossorigin="anonymous"></script>
</head>
<body>
	<div class="main-container">
		<div class="main-wrap">
		<header>
			<div class="logo-wrap">
				<a href="./main.php"><h1 class="bold">모두화가</h1></a>
			</div>
		</header>
		<section class="login-input-section-wrap">
			<form id="login-form" action="./login_ok.php" method="POST" onsubmit="return loginCheck()">
			<div class="login-input-wrap">	
				<input id="id" name="id" placeholder="아이디" type="text"></input>
			</div>
			<div class="login-input-wrap password-wrap">	
				<input id="password" name="password" placeholder="비밀번호" type="password"></input>
			</div>
			<div class="login-button-wrap">
				<button class="bold" type="submit">로그인</button>
			</div>
			<div class="login-stay-sign-in">
				<input id="check" type="checkbox" class="checkbox" checked>
				<label for="check">&nbsp;로그인 유지</label>
			</div>
			</form>
		</section>
		<section class="Easy-sgin-in-wrap">
			<h2>소셜로그인</h2>
			<ul class="sign-button-list">
				<li><button><i class="fab fa-google"></i><span>Google</span></button></li>
				<li><button><i class="fab fa-facebook"></i><span>Facebook</span></button></li>
			</ul>
            <div class="links"><a href="#" class="forget-msg">아이디 또는 비밀번호를 잊으셨나요?</a> | <a href="register.php" class="sign-up">회원가입</a></div>
			
		</section>
		</div>
	</div>
	<footer>
		<span class="bold">We artists</span> <span>Copyright © 2021 Painter.co.Ltd. All rights reserved.</span>
   </footer>
	<script>
		function loginCheck(){
			let idValue=document.querySelector('#id').value;
			let psValue=document.querySelector('#password').value;
			if(idValue==='' || psValue===''){
				alert("아이디나 패스워드를 입력하지 않았습니다.");
				return false;
			}
			return true;
		}
	</script>
</body>