$('.seeccomments').on('click', seeccomments);
$('.deletebtn').on('click',deleteComments);
$('.ccdeletebtn').on('click',deleteCComments);
$('.comment-comment-button').on('click',showwriteCC);
$('.cchidebutton').on('click',hidewriteCC);
$('.ccomment-button').on('click',writeCComments);
$('.commentbtn').on('click',function(){
    //동기화 작업 필요.
    let w_id=$(this).attr('value');
    let contents=document.querySelector(".comment-bar").value;
    contents=contents.replace(/(<([^>]+)>)/ig,'');
    if(contents=="") return;

    document.querySelector(".comment-bar").value=contents;   
        $.ajax({
            url:"./ajax/ajax-comment.php",
            type:'POST',
            dataType:'json',
            data:{
                'writing_id' : w_id ,
                'contents' : contents
            },
            success:function(data){
                if(data[0].logged){

                    let c_id=data[0].c_id;
                    let v_name=data[0].v_name;
                    let v_photo=data[0].v_photo;
                    let update_date=data[0].update_date;
                    let contents=data[0].contents;
                    let elem=
                        "<li class='first'><div class='other-comments'>"
                        +"<img class='user-profile' src='../temp/profile/"+v_photo+"' alt='"+v_photo+"'>"
                        +"<div class='none-image'><p class='medium text'>"+v_name+"</p>"
                        +"<p class='update text'>"+update_date+"</p>"
                        +"<button type='button' class='deletebtn text' value="+c_id+">삭제</button>"
                        +"<div class='comment-bar2'>"+contents+"</div>"
                        +"<button type='button' class='comment-comment-button medium' value='"+c_id+"'>답글</button></div></div>"
                        +"<div class='ccomments'></div></li>"
                    $(".other-comments-container ul").prepend(elem);
                    $(".deletebtn").off('click').on('click',deleteComments);
                    $('.comment-comment-button').off('click').on('click',showwriteCC);
                }
                else{
                    //로그인하지 않은 사용자.
                    location.href="./login.php";
                }
                
            },
            error : function(err){
                console.log(err);
            }
            
        });
});

function deleteComments(){
    let c_id=$(this).attr('value');
    let btn=$(this);
    let sync=true;
    
        if(!confirm("댓글을 삭제하시겠습니까?")) return;
        sync=false;
        $.ajax({
            url:"./ajax/ajax-co_delete.php",
            type:'POST',
            dataType:'json',
            data:{
                'c_id' : c_id,
            },
            success:function(data){
                if(data[0].logged && data[0].success){

                    btn.parents("li.first").remove();
                }
                else{
                    //로그인하지 않은 사용자.
                    location.href="./login.php";
                }
                sync=true;
            },
            error : function(err){
                console.log(err);
                sync=true;
            }
            
        });
    
}
function deleteCComments(){
    let cc_id=$(this).attr('value');
    let btn=$(this);
    let sync=true;
    
        if(!confirm("답글을 삭제하시겠습니까?")) return;
        sync=false;
        $.ajax({
            url:"./ajax/ajax-cco-delete.php",
            type:'POST',
            dataType:'json',
            data:{
                'cc_id' : cc_id,
            },
            success:function(data){
                if(data[0].logged && data[0].success){

                    btn.parents(".other-ccomments").remove();
                }
                else{
                    //로그인하지 않은 사용자.
                    location.href="./login.php";
                }
                sync=true;
            },
            error : function(err){
                console.log(err);
                sync=true;
            }
            
        });
    
}


function seeccomments(){
    let c_id=$(this).attr('value');
    let btn=$(this);
    $.ajax({
        url:"./ajax/ajax-getcco.php",
        type:'POST',
        dataType:'json',
        data:{
            'c_id':c_id,
        },
        success:function(data){
            if(data.length!=0){
                $.each(data,function(key,val){
                    var $elem=
                        "<div class='other-ccomments'>"
                        +"<img class='user-profile' src='../temp/profile/"+val.photo+"' alt='"+val.photo+"'>"
                        +"<div class='none-image'>"
                        +"<p class='medium text user'>"+val.name+"</p>"
                        +"<p class='update text'>"+val.update_date+"</p>";

                    if(val.isMine){
                        $elem+="<button type='button' class='ccdeletebtn text' value='"+val.cc_id+"'>삭제</button>"
                    }
                    $elem+="<div class='comment-bar2'>"+val.contents+"</div>"
                        +"</div></div>";
                    btn.parents("li.first").children(".ccomments").append($elem);
                    $(".ccdeletebtn").off('click').on('click',deleteCComments);
                    //답글 버튼 수정 이벤트 추가.
                        
                });
                btn.replaceWith("<button type='button' class='hideccomments medium' value="+c_id+">답글 숨기기</button>");
                $(".hideccomments").off('click').on('click',hideCComments);
            }
            
            sync=true;
        },
        error : function(err){
            console.log(err);
        }
    }); 
}

function hideCComments(){
    let btn=$(this);
    let c_id=btn.attr('value');
    btn.parents("li.first").children(".ccomments").empty();
    btn.replaceWith("<button type='button' class='seeccomments medium' value='"+c_id+"'>답글 보기</button>");
    $('.seeccomments').off('click').on('click',seeccomments);
}

function showwriteCC(){
    let btn=$(this);
    let c_id=btn.attr('value');
    let v_photo=$('.my-comment .user-profile').attr('alt');
    let $elem="<div class='my-ccomment'>"
        +"<img class='user-profile' src='../temp/profile/"+v_photo+"' alt='"+v_photo+"'>"
        +"<div class='comments-post-container comments-post'>"
        +"<input type='text' maxlength='200' class='ccomment-bar' placeholder='답글 추가...'>"
        +"<button type='button' class='ccomment-button medium' value='"+c_id+"'>답글</button></div></div>";
    btn.parents('.other-comments').after($elem);
    btn.replaceWith("<button type='button' class='cchidebutton medium' value="+c_id+">취소</button>");
    $('.cchidebutton').off('click').on('click',hidewriteCC);
    $('.ccomment-button').off('click').on('click',writeCComments);
    
}
function hidewriteCC(){
    let btn=$(this);
    let c_id=btn.attr('value');
    btn.parents('li.first').children(".my-ccomment").remove();
    btn.replaceWith("<button type='button' class='comment-comment-button medium' value='"+c_id+"'>답글</button>");
    $('.comment-comment-button').off('click').on('click',showwriteCC);
}

function writeCComments(){
    //동기화 작업 필요.
    let btn=$(this);
    let c_id=$(this).attr('value');
    let contents=document.querySelector(".ccomment-bar").value;
    contents=contents.replace(/(<([^>]+)>)/ig,'');
    if(contents=="") return;
    document.querySelector(".ccomment-bar").value=contents;   
        $.ajax({
            url:"./ajax/ajax-ccomment.php",
            type:'POST',
            dataType:'json',
            data:{
                'c_id' : c_id ,
                'contents' : contents
            },
            success:function(data){
                if(data[0].logged){

                    let cc_id=data[0].cc_id;
                    let v_name=data[0].v_name;
                    let v_photo=data[0].v_photo;
                    let update_date=data[0].update_date;
                    let contents=data[0].contents;
                    let $elem=
                        "<div class='other-ccomments'>"
                        +"<img class='user-profile' src='../temp/profile/"+v_photo+"' alt='"+v_photo+"'>"
                        +"<div class='none-image'>"
                        +"<p class='medium text user'>"+v_name+"</p>"
                        +"<p class='update text'>"+update_date+"</p>"
                        +"<button type='button' class='ccdeletebtn text' value='"+cc_id+"'>삭제</button>"
                        +"<div class='comment-bar2'>"+contents+"</div>";
                    btn.parents("li.first").children(".ccomments").append($elem);
                    btn.parents("li.first").children(".other-comments").find(".cchidebutton").replaceWith("<button type='button' class='comment-comment-button medium' value='"+c_id+"'>답글</button>");
                    btn.parents(".my-ccomment").remove();
                    $(".ccdeletebtn").off('click').on('click',deleteCComments);
                    $('.comment-comment-button').off('click').on('click',showwriteCC);
                }
                else{
                    //로그인하지 않은 사용자.
                    location.href="./login.php";
                }
                
            },
            error : function(err){
                console.log(err);
            }
            
        });

}
