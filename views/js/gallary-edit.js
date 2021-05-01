
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
    let regex=/^[가-힣a-zA-Z0-9\s]+$/ig
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
                    +"<button class='gallary-delete' style='padding:5px; background:none' value="+g_id+"><i class='fas fa-minus-circle ' style='color:red'></i></button></div>"
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
var item;
var dg_id;
var ug_id;
//갤러리 삭제
$('#deletemodal .doneBtn').on('click', function(){
    let recursive=$('.rdelete').is(':checked');
    $.ajax({
        url:"../ajax/ajax-gdelete.php",
        type:'POST',
        dataType:'json',
        data:{
            'g_id' : dg_id,
            'recursive' : recursive
        },
        success:function(data){
            if(data[0].logged && data[0].success){
                item.remove();
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
//갤러리 이름 수정
$(document).on('click','.gallary-name-edit', function(){
    let gtitle=$(this).parents('#gallary-name-default').find('.gtitle');
    ug_id=$(this).attr('value');
    $(this).remove();
    let title=gtitle.html();
    let string="<input class='gnameedit' type='text' maxlength='22' value='"+title+"'>"
    gtitle.html(string);
});
//갤러리 이름 수정 완료
$(document).on('focusout','.gnameedit', function(){
    let title=$(this).val();
    let regex=/^[가-힣a-zA-Z0-9\s]+$/ig;
    let btn=$(this);
    if(!regex.test(title) || title=='All'){
        alert("올바르지 않은 이름입니다.");
        $(this).val('');
        return;
    }
    console.log(title);
    console.log(ug_id);
    $.ajax({
        url:"../ajax/ajax-gupdate.php",
        type:'POST',
        dataType:'json',
        data:{
            'title':title,
            'g_id':ug_id
        },
        success:function(data){
            if(data[0].logged && data[0].success){
                let string="<i class='far fa-edit gallary-name-edit' style='display:inline-block' value="+ug_id+"></i>";
                btn.parents('#gallary-name-default').prepend(string);
                btn.parents('.gtitle').html(title);
                btn.remove();
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
//-버튼 누르면
$(document).on('click','.gallary-delete',function(){
    dg_id=$(this).attr('value');
    item=$(this).parents('.item');
    $('#deletemodal.modal').css('display','flex');
});
//x 버튼 누르면
$(document).on('click','#deletemodal .closeBtn',function(){
    $('.modal').css('display','none');
});