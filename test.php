<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    $db=mysqli_connect("127.0.0.1", "root", "@5252@OkOk", "mysql");
    if($db){
        echo 'Success!';
    }
    else{
        echo 'Fail';
    }
    $result=mysqli_query($db, 'SELECT VERSION() as VERSION');
    $data =mysqli_fetch_assoc($result);
    echo $data['VERSION'];

?>