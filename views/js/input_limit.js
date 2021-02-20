// 검색부분 입력 가공 : 한글, 영어(대소문자), 숫자, <, >, :, "" 외 지움
function checkSearch(){
    let searchcontent=document.querySelector("#search-bar").value;
    searchcontent=searchcontent.replace(/[^0-9a-zㄱ-ㅎㅏ-ㅣ가-힣\!\?\<\>\:\s"]/gi,'');
    console.log('user searches for '+searchcontent);
    return true;
}
//텍스트 부분 입력 가공 : html script 제거
function checkTag(){
    let content=document.querySelector("#comment-bar").value;
    content=content.replace(/(<([^>]+)>)/ig,'');
    console.log('user comment : '+content);
    alert(content);
    return true;
}
//사진 첨부 제한 : size는 30mb 이하, 확장자는 jpg, png, jpeg, ai, bmp, gif
function checkImg(){
    let regex=/\.(jpg|png|jpeg|ai|bmp|gif)$/gi;
    let imgFile=document.querySelector('#image').files;
    for(let i=0; i<imgFile.length; i++){
        if(!imgFile[i]){
            alert('이미지를 선택해주세요');
            return false;
        }
        if(!regex.test(imgFile[i].name)){
            alert('jpg, png, jpeg, ai, bmp, gif 파일만 선택할 수 있습니다.');
            return false;
        }
        if((imgFile[i].size/1024)/1024 > 30){
            alert('30MB 크기의 사진까지 업로드할 수 있습니다.');
            return false;
        }
    }
    return true;
}