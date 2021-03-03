<?php
    $gallary_data=array(
        array(
            "name"=>"보이지 않지만 빛나는 것들",
            array("name"=>"호랑이", "artist"=>"고몽", "imgsrc"=>"../../resources/moon_in_yard.jpg", "artist_statement"=>"Hello There"),
            array("name"=>"호랑이", "artist"=>"고몽", "imgsrc"=>"../../resources/moon_in_yard.jpg", "artist_statement"=>"Hello There")
        ),
        array(
            "name"=>"한팔업어치기",
            array("name"=>"양팔업어치기", "artist"=>"고몽", "imgsrc"=>"../../resources/judo.png", "artist-statement"=>"Hello There2")
        )
    );
    $idx=$_GET['idx'];
    echo "갤러리 폴더 이름 : ".$gallary_data[$idx]['name']."<br>\n";
    for($i=0; $i<count($gallary_data[$idx])-1; $i++){
        echo "게시글 제목 : ".$gallary_data[$idx][$i]["name"]."<br>\n";
        echo "게시글 작가 : ".$gallary_data[$idx][$i]["artist"]."<br>\n";
        echo "게시글 설명 : ".$gallary_data[$idx][$i]["artist_statement"]."<br>\n";
        echo "게시글 이미지 : "."<img src=\"{$gallary_data[$idx][$i]["imgsrc"]}\"  width=\"100px\" height=\"100px\">"."<br>\n";
    }
    
?>