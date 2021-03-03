// 검색부분 입력 가공 : 한글, 영어(대소문자), 숫자, <, >, :, "" 외 지움
function checkSearch(){
    let searchcontent=document.querySelector("#search-bar").value;
    searchcontent=searchcontent.replace(/[^0-9a-zㄱ-ㅎㅏ-ㅣ가-힣\!\?\<\>\:\s'"]/gi,'');
    console.log('user searches for '+searchcontent);
    return true;
}
//텍스트 부분 입력 가공 : html script 제거
function checkTag(){
    let content=document.querySelector("#comment-bar").value;
    content=content.replace(/(<([^>]+)>)/ig,'');
    console.log('user comment : '+content);
    return true;
}
