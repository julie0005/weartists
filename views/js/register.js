
var id = document.querySelector('#id');
var pw1 = document.querySelector('#pswd1');
var msg = document.querySelectorAll('#alertTxt');
var pw2 = document.querySelector('#pswd2');
var pwMsgArea = document.querySelector('.int_pass');
var email = document.querySelector('#email');
var error = document.querySelectorAll('.error_next_box');
var nickname=document.querySelector('#nickname');
var isValid=[false,false,false,false,false,false,false,false]; //5,6,7은 중복체크.
id.addEventListener("keyup", checkId);
pw1.addEventListener("keyup", checkPw);
pw2.addEventListener("keyup", comparePw);
email.addEventListener("keyup", isEmailCorrect);
nickname.addEventListener("keyup",checkName);
$('#IDdup').on('click',function(){
    dupCheck($(this),'id',0,'아이디');
});
$('#NIdup').on('click',function(){
    
    dupCheck($(this),'nickname',1,'닉네임')
});
$('#EMdup').on('click',function(){
    dupCheck($(this),'email',2,'이메일');
});

function dupCheck(obj, type, index, account){
    let info=obj.parents('.dpcheck').find('.int').val();
    if(isValid[index]==false){
        alert("양식을 다시 한번 확인해주세요.");
        return;
    }
    $.ajax({
        url:"./ajax/ajax-register.php",
        type:"POST",
        dataType:"json",
        data:{
            column:type,
            string:info
        },
        success:function(data){
            if(data[0].success){
                alert("사용 가능한 "+account+"입니다.");
                isValid[index+5]=true;
                msg[index].innerHTML="확인완료";
                msg[index].style.color = "#03c75a";
                msg[index].style.display = "block";
            }
            else{
                alert("이미 있는 "+account+"입니다.");
                isValid[index+5]=false;
                msg[index].innerHTML = "사용불가";
                msg[index].style.color = "red";
                msg[index].style.display = "block";
            }
        },
        error:function(err){
            console.log(err);
        }
    });

}

function checkId() {
    var idPattern = /[a-z0-9]{5,20}/;
    if(id.value === "") {
        error[0].innerHTML = "필수 정보입니다.";
        error[0].style.display = "block";
        msg[0].display="none";
        isValid[0]=false;
    } else if(!idPattern.test(id.value)) {
        error[0].innerHTML = "5~20자의 영문 소문자와 숫자만 사용 가능합니다.";
        error[0].style.display = "block";
        msg[0].style.display="none";
        isValid[0]=false;
        isValid[5]=false;
    } else {
        error[0].style.display = "none";
        msg[0].innerHTML = "중복 확인 필요";
        msg[0].style.display = "block";
        msg[0].style.color = "#03c75a";
        isValid[0]=true;
    }
}

function checkName() {
    var namePattern = /[a-z0-9ㄱ-ㅎㅏ-ㅣ가-힣]{2,10}/;
    if(nickname.value === "") {
        error[1].innerHTML = "필수 정보입니다.";
        error[1].style.display = "block";
        msg[1].display="none";
        isValid[1]=false;
    } else if(!namePattern.test(nickname.value)) {
        error[1].innerHTML = "2~10자의 영문 소문자와 숫자, 한글만 사용 가능합니다.";
        error[1].style.display = "block";
        msg[1].style.display="none";
        isValid[1]=false;
        isValid[6]=false;
    } else {
        error[1].style.display = "none";
        msg[1].innerHTML = "중복 확인 필요";
        msg[1].style.display = "block";
        msg[1].style.color = "#03c75a";
        isValid[1]=true;
    }
}
function checkPw() {
    var pwPattern=/^(?=.*[a-z])(?=.*\d)(?=.*\W).{8,16}$/i;

    if(pw1.value === "") {
        error[3].innerHTML = "필수 정보입니다.";
        error[3].style.display = "block";
        msg[3].style.display="none";
        isValid[3]=false;
    } else if(!pwPattern.test(pw1.value)) {
        error[3].innerHTML = "영문 소문자(대문자), 숫자, 특수문자를 포함한 8~16자 비밀번호를 사용해주세요.";
        msg[3].innerHTML = "사용불가";
        msg[3].style.color = "red";
        error[3].style.display = "block";
        msg[3].style.display = "block";
        isValid[3]=false;
    } else {
        error[3].style.display = "none";
        msg[3].innerHTML = "사용가능";
        msg[3].style.display = "block";
        msg[3].style.color = "#03c75a";
        isValid[3]=true;
    }
}

function comparePw() {
    if(pw2.value === "") {
        error[4].innerHTML = "필수 정보입니다.";
        error[4].style.display = "block";
        isValid[4]=false;
    }
    else if(pw2.value === pw1.value) {
        error[4].style.display = "none";
        isValid[4]=true;
    } else if(pw2.value !== pw1.value) {
        error[4].innerHTML = "비밀번호가 일치하지 않습니다.";
        error[4].style.display = "block";
        isValid[4]=false;
    } 

}


function isEmailCorrect() {
    var emailPattern = /^[\w\.]+@[\w](\.?[\w])*\.[a-z]{2,3}$/i;

    if(email.value === ""){ 
        error[2].innerHTML = "필수 정보입니다.";
        error[2].style.display = "block";
        isValid[2]=false;
    } else if(!emailPattern.test(email.value)) {
        error[2].innerHTML = "올바르지 않은 양식입니다.";
        error[2].style.display = "block";
        isValid[2]=false;
        isValid[7]=false;
    } else {
        error[2].style.display = "none"; 
        msg[2].innerHTML = "중복 확인 필요";
        msg[2].style.display = "block";
        msg[2].style.color = "#03c75a";
        isValid[2]=true;
    }

}
function registerCheck(){
    let finalValid=true;
    for( let i=0; i<isValid.length; i++){
        finalValid=finalValid&&isValid[i];
    }
    if(finalValid){
        return true;
    }
    else{
        console.log(finalValid);
        alert("양식을 다시 한번 확인해주세요.");

        return false;
    }
}
