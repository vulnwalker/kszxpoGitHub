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

$head = 
	'<head>
	<title>:: ATISISBADA (Aplikasi Teknologi Informasi Siklus Barang Daerah) Tim</title>
	<meta name="format-detection" content="telephone=no">
	<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
	<!--  
	<link rel="stylesheet" href="css/template_css.css" type="text/css" />
	<link rel="stylesheet" href="css/theme.css" type="text/css" />
	<link rel="stylesheet" href="dialog/dialog.css" type="text/css" />
	<link rel="stylesheet" href="lib/chatx/chatx.css" type="text/css" />
	<link rel=\'stylesheet\' href=\'css/menu.css\' type=\'text/css\' />
	
	<script language="JavaScript" src="lib/js/JSCookMenu_mini.js" type="text/javascript"></script>
	<script language="JavaScript" src="lib/js/ThemeOffice/theme.js" type="text/javascript"></script>
	<script language="JavaScript" src="lib/js/joomla.javascript.js" type="text/javascript"></script>
	<script language="JavaScript" src="js/ajaxc2.js" type="text/javascript"></script>
	<script language="JavaScript" src="dialog/dialog.js" type="text/javascript"></script>
	<script language="JavaScript" src="js/base.js" type="text/javascript"></script>
	<script language="JavaScript" src="lib/chatx/chatx.js" type="text/javascript"></script>
	-->

		
	<link rel="stylesheet" href="css/menu.css" type="text/css">
	<link rel="stylesheet" href="css/template_css.css" type="text/css">
	<link rel="stylesheet" href="css/theme.css" type="text/css">
	<link rel="stylesheet" href="dialog/dialog.css" type="text/css">
	<link rel="stylesheet" href="lib/chatx/chatx.css" type="text/css">
	<link href="css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">	
	<link rel="stylesheet" href="css/base.css" type="text/css">
	<!--<link rel=\'stylesheet\' href=\'css/sislog.css\' type=\'text/css\' />-->
	<!--<link rel="stylesheet" type="text/css" media="all" href="js/jscalendar-1.0/calendar-win2k-cold-1.css" title="win2k-cold-1" />-->
	
	 
	
	<script language="JavaScript" src="lib/js/JSCookMenu_mini.js" type="text/javascript"></script>
	<script language="JavaScript" src="lib/js/ThemeOffice/theme.js" type="text/javascript"></script>
	<script language="JavaScript" src="lib/js/joomla.javascript.js" type="text/javascript"></script>
	
	<script src="js/jquery.js" type="text/javascript"></script>	
	<script language="JavaScript" src="js/ajaxc2.js" type="text/javascript"></script>
	<script language="JavaScript" src="dialog/dialog.js" type="text/javascript"></script>
	<script language="JavaScript" src="js/global.js" type="text/javascript"></script>
	<script language="JavaScript" src="js/base.js" type="text/javascript"></script>
	<script language="JavaScript" src="js/encoder.js" type="text/javascript"></script>	
	<script language="JavaScript" src="lib/chatx/chatx.js" type="text/javascript"></script>
	<script src="js/jquery-ui.custom.js"></script>
	<script src="js/daftarobj.js" type="text/javascript"></script>
	<script src="js/pageobj.js" type="text/javascript"></script>
<script src="js/skpd.js" type="text/javascript"></script>	
	<script src="js/pindahtangan.js" type="text/javascript"></script>
	<script src="js/ruang.js" type="text/javascript"></script>
	<script src="js/pegawai.js" type="text/javascript"></script>	
	<script src="js/sensus.js" type="text/javascript"></script>	
			
		<script src="js/reclass.js" type="text/javascript"></script>	
		<script src="js/asetlainlain.js" type="text/javascript"></script>	
		<script src="js/kapitalisasi.js" type="text/javascript"></script>	
		<script src="js/koreksi.js" type="text/javascript"></script>
		<script src="js/kondisi/kondisi.js" type="text/javascript"></script>	
		<script src="js/master/refstatusbarang/refstatusbarang.js" type="text/javascript"></script>
		<script src="js/master/refprogram/refprogram.js" type="text/javascript"></script>
		
		<!--<script>
			$(document).ready(function(){
					    	$(".toggler").click(function(e){
						        //e.preventDefault();
						        //$("#det_"+$(this).attr("data-prod-cat")).toggle();
								alert("tes");
						    });
						});
		</script>				-->
			
	
	

	  <!-- calendar stylesheet -->
	  <link rel="stylesheet" type="text/css" media="all" href="js/jscalendar-1.0/calendar-win2k-cold-1.css" title="win2k-cold-1">

	  <!-- main calendar program -->
	  <script type="text/javascript" src="js/jscalendar-1.0/calendar.js"></script>

	  <!-- language for the calendar -->
	  <script type="text/javascript" src="js/jscalendar-1.0/lang/calendar-id.js"></script>

	  <!-- the following script defines the Calendar.setup helper function, which makes
		   adding a calendar a matter of 1 or 2 lines of code. -->
	  <script type="text/javascript" src="js/jscalendar-1.0/calendar-setup.js"></script>
	  
	  <script type="text/javascript">
	  	RefStatusBarang.autocomplete_initialsurvey();
	  
	  </script>
	  <script type="text/javascript">
	  	function checkedMM(){						
						//alert(\'TES !\');
						if(document.getElementById(\'fmTAMBAHMasaManfaat\').checked==true){
							document.getElementById(\'fmTAMBAHASET\').checked = true;
						}else{
							document.getElementById(\'fmTAMBAHASET\').checked = false;
						}
					}
	  
	  </script>
	
	<script language="JavaScript" src="tes.js" type="text/javascript"></script> 
	
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="Generator" content="Joomla! Content Management System">
	<link rel="shortcut icon" href="images/logo_web_demo_kota.ico">

	</head>';

$tipe = $_REQUEST['tipe'];
switch($tipe){
	case 'get_tes': 
		$cek = ''; $err=''; $content=''; $json=FALSE;
		
		$arr[] = 1;
		$arr[] = 2;
		$arr[]= 3;
		
		$aqry = "select count(*) as cnt from view_buku_induk where tgl_buku <= '2016-12-31' ;"; $cek .= $aqry;
		$qry = mysql_fetch_array(mysql_query($aqry)) ;
		$content->cnt = ' jml = '.$qry['cnt'];
		$content->arr = $arr;
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
			"<html>".
			/**
			"<head>".
			'<meta name="format-detection" content="telephone=no">'.
			'<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">'.
			'<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">'.
			'<meta name="Generator" content="Joomla! Content Management System">'.
			'<link rel="shortcut icon" href="images/&lt;link rel=&quot;shortcut icon&quot; href=&quot;images/logo_web_demo_kota.ico&quot; /&gt;">'.
			'<link rel="shortcut icon" href="images/logo_web_demo_kota.ico">'.
			   //"<script language=\"JavaScript\" src=\"tes.js\" type=\"text/javascript\"></script> ".
			  // "<script language=\"JavaScript\" src=\"../js/jquery.js\" type=\"text/javascript\"></script> ".
				"<script language=\"JavaScript\" src=\"tes.js\" type=\"text/javascript\"></script> ".
				"<script language=\"JavaScript\" src=\"js/jquery.js\" type=\"text/javascript\"></script> ".
			"</head>".
			**/
			$head.
			"<body>
			    <input type='button' value='klik' onclick='get_tes()'>".
				
				"<div id='_cont_title' style='position:relative'></div>". 
				"<div id='_cont_opsi' style='position:relative'></div>". 
				"<div id='_cont_daftar' style=''></div>".
				"<div id='_cont_hal'></div>".
				//$vOpsi['TampilOpt'].
				
			"</body>
			</html>";
}




?>