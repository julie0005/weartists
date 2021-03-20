
$('.deletebtn').on('click',deleteComments);
$('#commentbtn').on('click',function(){
    let w_id=$(this).attr('value');
    let contents=document.querySelector("#comment-bar").value;
    contents=contents.replace(/(<([^>]+)>)/ig,'');
        
        
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
                        "<li class='other-comments first'>"
                        +"<img class='user-profile' src='../temp/profile/"+v_photo+"' alt='"+v_photo+"'>"
                        +"<div class='none-image'><p class='medium text'>"+v_name+"</p>"
                        +"<p class='update text'>"+update_date+"</p>"
                        +"<button type='button' class='deletebtn text' value="+c_id+">삭제</button>"
                        +"<div class='comment-bar'><p>"+contents+"</p></div>"
                        +"<button type='button' class='comment-comment-button medium'>답글</button></div></li>"
                    $(".other-comments-container").prepend(elem);
                    $(".deletebtn").off('click').on('click',deleteComments);
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

function deleteComments(){
    let c_id=$(this).attr('value');
    let btn=$(this);
    console.log(btn);
    console.log("what");
    if(!confirm("댓글을 삭제하시겠습니까?")) return;
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
                location.href="../login.php";
            }
            
        },
        error : function(err){
            console.log(err);
        }
        
    });
}
