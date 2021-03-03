
var id = document.querySelector('#id');
var pw1 = document.querySelector('#pswd1');
var msg = document.querySelectorAll('#alertTxt');
var pw2 = document.querySelector('#pswd2');
var pwMsgArea = document.querySelector('.int_pass');
var email = document.querySelector('#email');
var error = document.querySelectorAll('.error_next_box');
var isValid=false;

id.addEventListener("focusout", checkId);
pw1.addEventListener("focusout", checkPw);
pw2.addEventListener("focusout", comparePw);
email.addEventListener("focusout", isEmailCorrect);

function checkId() {
    var idPattern = /[a-z0-9]{5,20}/;
    if(id.value === "") {
        error[0].innerHTML = "필수 정보입니다.";
        error[0].style.display = "block";
        msg[0].display="none";
        isValid=false;
    } else if(!idPattern.test(id.value)) {
        error[0].innerHTML = "5~20자의 영문 소문자와 숫자만 사용 가능합니다.";
        error[0].style.display = "block";
        msg[0].style.display="none";
        isValid=false;
    } else {
        error[0].style.display = "none";
        msg[0].innerHTML = "사용가능";
        msg[0].style.display = "block";
        msg[0].style.color = "#03c75a";
        isValid=true;
    }
}

function checkPw() {
    var pwPattern=/^(?=.*[a-z])(?=.*\d)(?=.*\W).{8,16}$/i;

    if(pw1.value === "") {
        error[2].innerHTML = "필수 정보입니다.";
        error[2].style.display = "block";
        msg[1].style.display="none";
        isValid=false;
    } else if(!pwPattern.test(pw1.value)) {
        error[2].innerHTML = "영문 소문자(대문자), 숫자, 특수문자를 포함한 8~16자 비밀번호를 사용해주세요.";
        msg[1].innerHTML = "사용불가";
        msg[1].style.color = "red";
        error[2].style.display = "block";
        msg[1].style.display = "block";
        isValid=false;
    } else {
        error[2].style.display = "none";
        msg[1].innerHTML = "안전";
        msg[1].style.display = "block";
        msg[1].style.color = "#03c75a";
        isValid=true;
    }
}

function comparePw() {
    if(pw2.value === "") {
        error[3].innerHTML = "필수 정보입니다.";
        error[3].style.display = "block";
        isValid=false;
    }
    else if(pw2.value === pw1.value) {
        error[3].style.display = "none";
        isValid=true;
    } else if(pw2.value !== pw1.value) {
        error[3].innerHTML = "비밀번호가 일치하지 않습니다.";
        error[3].style.display = "block";
        isValid=false;
    } 

}


function isEmailCorrect() {
    var emailPattern = /^[\w\.]+@[\w](\.?[\w])*\.[a-z]{2,3}$/i;

    if(email.value === ""){ 
        error[1].innerHTML = "필수 정보입니다.";
        error[1].style.display = "block";
        isValid=false;
    } else if(!emailPattern.test(email.value)) {
        error[1].innerHTML = "올바르지 않은 양식입니다.";
        error[1].style.display = "block";
        isValid=false;
    } else {
        error[1].style.display = "none"; 
        isValid=true;
    }

}
function registerCheck(){
    if(isValid){
        return true;
    }
    else{
        console.log(isValid);
        alert("양식을 다시 한번 확인해주세요.");

        return false;
    }
}
