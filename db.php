<?php
    error_reporting(E_ALL);
    ini_set("display_errors",1);
    $db=mysqli_connect("127.0.0.1", "root", "@5252@OkOk", "weartist_db");
    $db->set_charset("utf8");
    session_start();
?>