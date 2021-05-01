$(document).on('click','.subscribebtn',function(){
        let btn=$(this);
        let target=$(this).attr('value');
        let substatus=$(this).find(".substatus").attr('value');
        $.ajax({
            url:"../ajax/ajax-subscribe.php",
            type:'POST',
            dataType:'json',
            data:{
                'substatus' : substatus,
                'target_id' : target
            },
            success:function(data){
                if(data[0].logged){
                    if(data[0].banned){
                        alert("자신은 구독할 수 없습니다.");
                        return;
                    }
                    if(data[0].subscribe){
                        //구독 -> 구독중 (구독완료)
                        btn.html("구독중"+"<input type='text' style='display:none;' class='substatus' value='1'></input>");
                        alert(data[0].target+" 님을 구독하였습니다.");
                    }
                    else{
                        //구독중 -> 구독 (구독취소)
                        btn.html("구독"+"<input type='text' style='display:none;' class='substatus' value='0'></input>");
                        alert(data[0].target+" 님을 구독 취소하였습니다.");
                    }
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