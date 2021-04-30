
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
    $('.gallary-name-edit').css('z-index','999');
    $('.gallary-delete').css('display','inline-block');
    $('.gallary-add').css('display','inline-block');
    $('.gallary-done').css('display','inline-block');
});
$('.gallary-add').on('click',function(){
    $('#gallarymodal.modal').css('display','flex');
});
//갤러리 추가
$('#gallarymodal .doneBtn').on('click', function(){
    //html 확인
    let newname=$('.newname').attr('value');
    $('.modal').css('display','none');
});
$('#gallarymodal .closeBtn').on('click', function(){
    $('.modal').css('display','none');
});
$(document).on('click','.gallary-name-edit', function(){

});

$(document).on('click','.gallary-delete',function(){
    $('#deletemodal.modal').css('display','flex');
});
//x 버튼 누르면
$(document).on('click','#deletemodal .closeBtn',function(){
    $('.modal').css('display','none');
});