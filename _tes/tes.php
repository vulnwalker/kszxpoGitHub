<?php

set_time_limit(0);
ob_start("ob_gzhandler");

$serverDemo= 1;

if ($serverDemo ){
	$Main->DB_Hostname = 'localhost';
	$Main->DB_Databasename = 'db_atsb_demo_v2';
	$Main->DB_User = 'operatordb';
	$Main->DB_Pass = 'Lupa321Zx';
	$Main->DB_Port = ':50300';
}else{
	$Main->DB_Hostname = 'localhost';
	$Main->DB_Databasename = 'db_atsb_demo_v2';
	$Main->DB_User = 'root';
	$Main->DB_Pass = '';
	$Main->DB_Port = '';
}

//**/
//**

//**/

$MySQL->HOST = $Main->DB_Hostname;
$MySQL->USER = $Main->DB_User;
$MySQL->PWD  = $Main->DB_Pass;
$MySQL->DB   = $Main->DB_Databasename;
$MySQL->PORT  = $Main->DB_Port;
$KoneksiMySQL = mysql_connect($MySQL->HOST.$MySQL->PORT,$MySQL->USER,$MySQL->PWD) or die("Koneksi ke MySQL Server Gagal");

$BukaDataBase = mysql_select_db($MySQL->DB) or die("Database $MySQL->DB, tidak ada");

$tipe = $_REQUEST['tipe'];
switch($tipe){
	case 'get_tes': 
		$cek = ''; $err=''; $content=''; $json=FALSE;
		$aqry = "select count(*) as cnt from view_buku_induk where tgl_buku <= '2016-12-31' ;"; $cek .= $aqry;
		$qry = mysql_fetch_array(mysql_query($aqry)) ;
		$content = ' jml = '.$qry['cnt'];
		$pageArr = array(
			//'cek'=>utf8_encode($cek), 
			//'cek'=>substr($cek,1,$Main->SHOW_CEK_LIMIT), 
			'cek'=>htmlspecialchars($cek), 
			'err'=>$err, 
			'content'=>$content	
		);
		$page = json_encode($pageArr);	
		echo $page;
		break;
	
	default: 
		echo 
			"<html>
			<head>
			   <script language=\"JavaScript\" src=\"tes.js\" type=\"text/javascript\"></script> 
			   <script language=\"JavaScript\" src=\"../js/jquery.js\" type=\"text/javascript\"></script>
			</head>
			<body>
			    <input type='button' value='klik' onclick='get_tes()'>
			</body>
			</html>";
}




?>