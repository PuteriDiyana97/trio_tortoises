<?php


$data ='[{"name":"test label without condition","label_text":"","image":"https:\/\/mcstaging.senheng.com.my\/media\/amasty\/amlabel\/1test-mic-pen.jpg","styles":"max-width: 600px; ","text_style":"","wrapper_style":"bottom:0; left:0; right:0; margin-left:auto; margin-right:auto; line-height:normal; position:absolute; z-index:8; display:block; max-width:95%","product":"15197","label":633,"margin":"10","alignment":null}]';

$data2 = json_decode($data);

print_r($data2[0]->name);
