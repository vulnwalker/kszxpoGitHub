<?php
echo $_SERVER['REQUEST_URI'];
//echo ' <br>'.$_SERVER['PHP_SELF'];
//echo ' <br>'.$_SERVER['QUERY_STRING'];
//echo ' <br>'.$_SERVER['SCRIPT_FILENAME'];

$url = $_SERVER['REQUEST_URI'];
$arrulr = explode('/',$url);
$so = sizeof($arrulr);
echo "<br>".$arrulr[$so-1];
		

//$url = parse_url($url);
//echo ' <br>'.$url['path'];
//echo ' <br>'.$url['query'];


echo '<br> tes';
$kode = $_REQUEST['kode'];

include("../config.php");
echo 'tes2';
include('../common/fnMenu.php');

//include('../common/DaftarObj.php');
echo $kode;
echo $Menu->genMenu($kode);
//echo $Menu->tes('1.1.2.');
?>