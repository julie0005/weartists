
$('.gallary-done').on('click',function(){
    $('#editmode').attr('value','0');
    $('.gallary-name-edit').css('display','none');
    $('.gallary-delete').css('display','none');
    $('.gallary-add').css('display','none');
    $('.gallary-done').css('display','none');
    $('.gallary-edit').css('display','inline-block');
});
$('.gallary-edit').on('click',function(){
    $('#editmode').attr('value','1');
    $('.gallary-edit').css('display','none');
    $('.gallary-name-edit').css('display','inline-block');
    $('.gallary-delete').css('display','inline-block');
    $('.gallary-add').css('display','inline-block');
    $('.gallary-done').css('display','inline-block');
});
$('.gallary-add').on('click',function(){
    $('#gallarymodal.modal').css('display','flex');
});
$('#gallarymodal .closeBtn').on('click', function(){
    //html 검사
    //ajax 요청. 갤러리 생성
    //닫기
    $('.modal').css('display','none');
});

$(document).on('click','.gallary-delete',function(){
    $('#deletemodal.modal').css('display','flex');
});
$(document).on('click','#deletemodal .closeBtn',function(){
    $('.modal').css('display','none');
});