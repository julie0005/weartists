function readURL(input) {
    if (input.files && input.files[0]) {
        let regex=/\.(jpg|png|jpeg|ai|bmp|gif)$/gi;
        if(/[\\\/\:\*\?"<>|]/.test(input.files[0].name)){
            alert('파일 이름에 \,/,:,?,",<,>,|는 포함될 수 없습니다.');
            return false;
        }
        if(!regex.test(input.files[0].name)){
            alert('jpg, png, jpeg, ai, bmp, gif 파일만 선택할 수 있습니다.');
            return false;
        }
        if((input.files[0].size/1024)/1024 > 30){
            alert('30MB 크기의 사진까지 업로드할 수 있습니다.');
            return false;
        }

      var reader = new FileReader();
  
      reader.onload = function(e) {
        $('.image-upload-wrap').hide();
  
        $('.file-upload-image').attr('src', e.target.result);
        $('.file-upload-content').show();
        //날짜 시간 초로 다른 이름으로 저장해야함.
      };
  
      reader.readAsDataURL(input.files[0]);
  
    } else {
      removeUpload();
    }
  }
  
  function removeUpload() {
    let files=document.querySelector(".file-upload-input");
    files.value="";
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
  }
  $('.image-upload-wrap').on('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
});
$('.image-upload-wrap').on('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});

function submitContents() {
  let title=document.querySelector(".form-group #title").value;
	document.querySelector(".form-group #title").value=title.replace(/(<([^>]+)>)/ig,'');
    let image=document.querySelector(".file-upload-input");
    let description=document.querySelector("#artist-statement").value;
    document.querySelector("#artist-statement").value=description.replace(/(<([^>]+)>)/ig,'');
    if(title==='' || description===""){
        alert("제목과 본문을 입력해주세요.");
        return false;
    }
    if(!image.files || !image.files[0] ){
        alert("이미지를 업로드해주세요.");
        return false;
    }
    return true;
}

  