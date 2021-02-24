var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
    oAppRef: oEditors,
    elPlaceHolder: "ir1",
    sSkinURI: "../../smarteditor2-2.8.2.3/SmartEditor2Skin.html",
    htParams : {
    // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
    bUseToolbar : true,             
    // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
    bUseVerticalResizer : true,     
    // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
    bUseModeChanger : false,
    aAdditionalFontList : [['Noto Sans KR', 'sans-serif']],            
    }, 
fOnAppLoad : function(){
    oEditors.getById['ir1'].setDefaultFont( "Noto Sans KR", 10);
},
    fCreator: "createSEditor2"
});


function submitContents() {
	oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
	// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
	let title=document.querySelector(".form-group #title").value;
    console.log(title.length);
    let content=document.getElementById("ir1").value;
    let content_text=content.replace(/(&nbsp;|<\/?(?!img)\w*\b[^>]*>)/ig,'');
    console.log(content_text);  
    if(title==='' || content_text===""){
        alert("제목과 본문을 입력해주세요.");
        return false;
    }
    if(content>65000){
        alert("본문 내용이 너무 많습니다.");
        return false;
    }
    alert("Success!");
	return true;
}

