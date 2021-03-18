<?php


?>

<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<p id="result"> </p>
<button type="button" class="button">흐음</button>
<script>
    $('.button').click(function(){
        var obj=$(this);
        $.ajax({
        url: "test.php",
        type: "POST",
        success : function(data){
           if(data=="true"){
               console.log("success");
               console.log(data);
               console.log(obj);
               obj.html(data);
           }
           else{
            console.log(data);
            obj.html(data);
           }
        },
        error : function(err){
            console.log("wat");
        }
        });
       
    });
</script>
</html>
