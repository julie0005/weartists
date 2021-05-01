$(document).on('click','.expand',function(){
    let imgsrc=$(this).attr('value');
    $('.modal').find('.body-image').attr('src',imgsrc);
    $('.modal').css('display','flex');
});
$(document).on('click','.closeBtn',function(){
    $('.modal').css('display','none');
});