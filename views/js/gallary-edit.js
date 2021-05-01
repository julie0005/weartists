
$('.gallary-done').on('click',clear);
function clear(){
    $('#editmode').attr('value','0');
    $('.gallary-name-edit').css('display','none');
    $('.gallary-delete').css('display','none');
    $('.gallary-add').css('display','none');
    $('.gallary-done').css('display','none');
    $('.gallary-edit').css('display','inline-block');
}
$('.gallary-edit').on('click',editon);
function editon(){
    $('#editmode').attr('value','1');
    $('.gallary-edit').css('display','none');
    $('.gallary-name-edit').css('display','inline-block');
    $('.gallary-name-edit').css('z-index','999');
    $('.gallary-delete').css('display','inline-block');
    $('.gallary-add').css('display','inline-block');
    $('.gallary-done').css('display','inline-block');
}
$('.gallary-add').on('click',function(){
    $('#gallarymodal.modal').css('display','flex');
});
//갤러리 추가
$('#gallarymodal .doneBtn').on('click', function(){
    //html 확인
    let newname=$('.newname').val();
    let regex=/^[가-힣a-zA-Z\s]+$/ig
    if(!regex.test(newname) || newname=='All'){
        alert("올바르지 않은 이름입니다.");
        $('.newname').val('');
        return;
    }
    $.ajax({
        url:"../ajax/ajax-gcreate.php",
        type:'POST',
        dataType:'json',
        data:{
            'title' : newname
        },
        success:function(data){
            if(data[0].logged){

                let g_id=data[0].g_id;
                let title=data[0].title;
                let thumbnail=data[0].thumbnail;
                let elem="<div class='item'>"
                    +"<a href='./gallary.php?idx="+g_id+"'><img src='../../temp/gallarythumb/"+thumbnail+"' alt='"+title+"'></a>"   
                    +"<p class='gallary-name bold' id='gallary-name-default'><i class='far fa-edit gallary-name-edit'></i> "+title+"</p>"
                    +"<button class='gallary-delete' style='padding:5px; background:none'><i class='fas fa-minus-circle ' style='color:red'></i></button></div>"
               $('#ajaxg.works-container').append(elem);
               clear();
               $('.modal').css('display','none');
            }
            else{
                //로그인하지 않은 사용자.
                location.href="../login.php";
            }
            
        },
        error : function(err){
            console.log(err);
        }
        
    });
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