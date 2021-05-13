
var iscomplete=true;
var item;
var dg_id;
var ug_id;

$('.gallary-done').on('click',clear);
function clear(){
    if(!iscomplete){
        alert("작업이 완료되지 않았습니다.");
        return;
    }
    $('#editmode').attr('value','0');
    $('.gallary-name-edit').css('display','none');
    $('.gallary-photo-edit').css('display','none');
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
    $('.gallary-photo-edit').css('display','inline-block');
    $('.gallary-photo-edit').css('z-index','999');
    $('.gallary-delete').css('display','inline-block');
    $('.gallary-add').css('display','inline-block');
    $('.gallary-done').css('display','inline-block');
}
$('.gallary-add').on('click',function(){
    $('#gallarymodal.modal').css('display','flex');
});
//갤러리 추가
$('#gallarymodal .doneBtn').on('click', function(){
    iscomplete=false;
    //html 확인
    let newname=$('.newname').val();
    let regex=/^[가-힣a-zA-Z0-9\s]+$/ig
    if(!regex.test(newname) || newname=='All' || newname==''){
        alert("올바르지 않은 이름입니다.");
        $('.newname').val('');
        return;
    }

    let imgFile = $('.gthumbnail').val();
    let imgVal=$('.gthumbnail')[0].files[0];
    let imgName=imgFile.split("\\");
    imgName = imgName[imgName.length-1];
    let fileForm = /(.*?)\.(jpg|jpeg|png|gif|bmp|ai)$/ig;
    let maxSize = 5 * 1024 * 1024;
    let fileSize;
    if($('.gthumbnail').val() == "") {
        $(".gthumbnail").trigger('focus');
    }

    if(imgFile != "" && imgFile != null) {
        fileSize = document.getElementById("gthumbnail").files[0].size;
        
        if(!imgFile.match(fileForm)) {
            alert("이미지 파일만 업로드 가능합니다.");
            return;
        } else if(fileSize == maxSize) {
            alert("파일 사이즈는 5MB까지 가능합니다.");
            return;
        }
        
    }

    let data=new FormData;
    data.append('title',newname);
    data.append('thumbnail',imgVal);

    $.ajax({
        url:"../ajax/ajax-gcreate.php",
        type:'POST',
        processData: false,
        contentType: false,
        data:data,
        success:function(data){
            data=JSON.parse(data);
            if(data[0].logged){

                let g_id=data[0].g_id;
                let title=data[0].title;
                let thumbnail=data[0].thumbnail;
                let elem="<div class='item'>"
                    +"<a href='./gallary.php?idx="+g_id+"'><img src='../../temp/gallarythumb/"+thumbnail+"' alt='"+title+"'></a>"   
                    +"<p class='gallary-name bold' id='gallary-name-default'><i class='far fa-edit gallary-name-edit'></i> "+title+"</p>"
                    +"<button class='gallary-delete' style='padding:5px; background:none' value="+g_id+"><i class='fas fa-minus-circle '></i></button></div>"
               $('#ajaxg.works-container').append(elem);
               iscomplete=true;
               clear();
               $('.modal').css('display','none');
               
            }
            else{
                
                // //로그인하지 않은 사용자.
                // location.href="../login.php";
            }
            
        },
        error : function(err){
            console.log(err);
        }
        
    });
});

//갤러리 삭제
$('#deletemodal .doneBtn').on('click', function(){
    iscomplete=false;
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
               iscomplete=true;
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
//x 버튼 누를 때 모든 모달은 닫힘
$('.closeBtn').on('click', function(){
    $('.modal').css('display','none');
});
//갤러리 썸네일 수정
$(document).on('click','.gallary-photo-edit', function(){
    ug_id=$(this).attr('value');
    item=$(this).parents('.item');
    $('#updatemodal.modal').css('display','flex');
    $('#updatemodal .ngthumbnail').val('');
});
//썸네일 수정 모달 확인 누르면
$('#updatemodal .doneBtn').on('click', function(){
    iscomplete=false;
    let imgobj=item.find('img');
    let imgFile = $('.ngthumbnail').val();
    let imgVal=$('.ngthumbnail')[0].files[0];
    let imgName=imgFile.split("\\");
    imgName = imgName[imgName.length-1];
    let fileForm = /(.*?)\.(jpg|jpeg|png|gif|bmp|ai)$/ig;
    let maxSize = 5 * 1024 * 1024;
    let fileSize;
    if($('.ngthumbnail').val() == "") {
        
        $(".ngthumbnail").trigger('focus');
        
    }

    if(imgFile != "" && imgFile != null) {
        fileSize = document.getElementById("ngthumbnail").files[0].size;
        
        if(!imgFile.match(fileForm)) {
            alert("이미지 파일만 업로드 가능합니다.");
            return;
        } else if(fileSize == maxSize) {
            alert("파일 사이즈는 5MB까지 가능합니다.");
            return;
        }
        
    }

    let data=new FormData;
    data.append('thumbnail',imgVal);
    data.append('g_id',ug_id);
    $.ajax({
        url:"../ajax/ajax-gpupdate.php",
        type:'POST',
        processData: false,
        contentType: false,
        data:data,
        success:function(data){
            data=JSON.parse(data);
            if(data[0].logged && data[0].success){
                let thumbnail=data[0].thumbnail;
                let elem="<img src='../../temp/gallarythumb/"+thumbnail+"' alt='"+"newthumb"+"'>";
                
               imgobj.replaceWith(elem);
               iscomplete=true;
               clear();
               $('.modal').css('display','none');
               
            }
            else{
                
                // //로그인하지 않은 사용자.
                // location.href="../login.php";
            }
            
        },
        error : function(err){
            console.log(err);
        }
        
    });
});
//갤러리 이름 수정
$(document).on('click','.gallary-name-edit', function(){
    let gtitle=$(this).parents('#gallary-name-default').find('.gtitle');
    ug_id=$(this).attr('value');
    $(this).remove();
    let title=gtitle.html();
    let string="<input id='edittxt' class='gnameedit' type='text' maxlength='22' value='"+title+"'>"
    gtitle.html(string);
    console.log(gtitle.find('#edittxt'));
    gtitle.find('#edittxt').trigger('focus');
});
//갤러리 이름 수정 완료
$(document).on('focusout','.gnameedit', function(){
    iscomplete=false;
    let title=$(this).val();
    let regex=/^[가-힣a-zA-Z0-9\s]+$/ig;
    let btn=$(this);
    if(!regex.test(title) || title=='All' || title==''){
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
                iscomplete=true;
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
