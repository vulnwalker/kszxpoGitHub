<?php
//

$file = 'http://123.231.253.229/images/administrator/images/home_24.png';


//$newfile = $_SERVER['DOCUMENT_ROOT'] . '/home_24.jpg'; ///var/www/wp_pilar/home_24.jpg 
//$newfile = $_SERVER['HTTP_HOST'] . '/atis/tmp2011/home_24.jpg'; 
//$newfile = '/var/www/atisisbada_demo_v2/tmp2011/home_24.jpg';
$newfile = '/var/www/atisisbada_demo_v2/common/home_24.jpg';

echo 'f='.$newfile;
//**
if ( copy($file, $newfile) ) {
    echo "Copy success! ". $newfile;
}else{
    echo "Copy failed. ". $newfile;
}
//**/
?>