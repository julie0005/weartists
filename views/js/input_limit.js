// 검색부분 입력 가공 : 한글, 영어(대소문자), 숫자, <, >, :, "" 외 지움
function checkSearch(){
    let searchcontent=document.querySelector("#search-bar").value;
    document.querySelector("#search-bar").value=searchcontent.replace(/(<([^>]+)>)/ig,'');
    document.querySelector("#search-bar").value=document.querySelector("#search-bar").value.replace(/[^0-9a-zㄱ-ㅎㅏ-ㅣ가-힣\(\)\^\!\?\:\s'"]/gi,'');
    if(document.querySelector("#search-bar").value=='') return false;
    console.log('user searches for '+searchcontent);
    return true;
}
//텍스트 부분 입력 가공 : html script 제거
//덧글부분.
function checkTag(){
    let content=document.querySelector(".comment-bar").value;
    content=content.replace(/(<([^>]+)>)/ig,'');
    console.log('user comment : '+content);
    return true;
}
//글쓰기 폼 가격 입력 텍스트 부분 : 숫자만 입력가능, max는 100만.
function checkPrice(text){
    text.value=text.value.replace(/[^0-9]/g,'');
    if(text.value>=1000000){
        text.value=1000000;
    }
}
