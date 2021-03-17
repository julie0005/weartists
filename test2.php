<?php


?>

<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<p id="result"> </p>
<script>
    $.ajax({
        url: "test.php",
        type: "POST",
        dataType:'json',
        data: {
            'page':3,
            'g_id':6
        },
        success : function(data){
           if(data.length!=0){
               console.log(data);
               $.each(data,function(key,val){
                $('#result').append(val.title+'<br>');
               });
           }
           else{
            $('#result').append("here");
           }

        },
        error : function(err){
            console.log(err);
        }
    });
</script>
</html>
