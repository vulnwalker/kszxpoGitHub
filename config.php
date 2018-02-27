<?php

include("common/vars.php");
include ("common/fnport.php");
include('common/floodprotection.php');

$MySQL->HOST = $Main->DB_Hostname;
$MySQL->USER = $Main->DB_User;
$MySQL->PWD  = $Main->DB_Pass;
$MySQL->DB   = $Main->DB_Databasename;
$MySQL->PORT   = $Main->DB_Port;
$KoneksiMySQL = mysql_connect($MySQL->HOST.$MySQL->PORT,$MySQL->USER,$MySQL->PWD) or die("Koneksi ke MySQL Server Gagal, ". mysql_error());

$DirBase	=	"";

$BukaDataBase = mysql_select_db($MySQL->DB) or die("Database $MySQL->DB, tidak ada");


//SETTING -------------------------------------------------
$qry = mysql_query('select * from setting ');
while( $row = mysql_fetch_array( $qry)){
    $Main->SETTING[$row['Id'] ] = $row['nilai']; 
}
$Main->THN_ANGGARAN = $Main->SETTING['THN_ANGGARAN']; //$Main->THN_ANGGARAN = 2017; //tahun login
$Main->PENERIMAAN_P19 = $Main->SETTING['PENERIMAAN_P19'];
$Main->URUSAN =$Main->SETTING['URUSAN'];
$Main->CEK_BI = $Main->SETTING['CEK_BI'];
$Main->SUSUT_MODE = $Main->SETTING['SUSUT_MODE'];
$Main->MENU_VERSI = $Main->SETTING['MENU_VERSI'];

$Main->DEF_KEPEMILIKAN 	= $Main->SETTING['DEF_KEPEMILIKAN']; //'12';//12 milik kota/kab , 11 milik propinsi
$Main->NM_KEPEMILIKAN 	= $Main->SETTING['NM_KEPEMILIKAN']; //'Pemerintah Kabupaten/Kota'; //'Propinsi'
//Provinsi
$Main->DEF_PROPINSI		= $Main->SETTING['DEF_PROPINSI']; //'10';
$Main->DEF_WILAYAH 		= $Main->SETTING['DEF_WILAYAH']; //'03';
$Main->NM_WILAYAH 		= $Main->SETTING['NM_WILAYAH']; //'Kota Demo';
$Main->NM_WILAYAH2		= $Main->SETTING['NM_WILAYAH2']; //'PEMERINTAH KOTA DEMO';
$Main->VERSI_NAME		= $Main->SETTING['VERSI_NAME'];

//menu versi 4 : peta sebaran
if($Main->MENU_VERSI==4){
	//$Main->APP_NAME = 'PETA SEBARAN';
	
	$Main->MODUL_PEMELIHARAAN = FALSE;
	$Main->MODUL_PENGAMANAN = FALSE;
	$Main->MODUL_MUTASI = FALSE;
	$Main->MODUL_SENSUS = FALSE;
	$Main->MODUL_SENSUS_MANUAL = FALSE;
	$Main->MODUL_PERENCANAAN = FALSE;
	$Main->MODUL_PENGADAAN = FALSE;
	$Main->MODUL_PENERIMAAN = FALSE;
	$Main->MODUL_PENGGUNAAN = FALSE;
	$Main->MODUL_PENATAUSAHAAN = TRUE;
	$Main->MODUL_PEMANFAATAN = FALSE;
	$Main->MODUL_PENGAMANPELIHARA = FALSE;
	$Main->MODUL_PENILAIAN = FALSE;
	$Main->MODUL_PENGAPUSAN = FALSE;
	$Main->MODUL_PENGAPUSAN_SK = FALSE;
	$Main->MODUL_PENGAPUSAN_SEBAGIAN =FALSE;
	$Main->MODUL_PEMINDAHTANGAN = FALSE;
	$Main->MODUL_PEMBIAYAAN = FALSE;
	$Main->MODUL_GANTIRUGI = FALSE;
	$Main->MODUL_MONITORING = FALSE;
	$Main->MODUL_CHART = FALSE;
	$Main->MODUL_PEMBUKUAN = FALSE;
	$Main->MODUL_AKUNTANSI= FALSE;
	$Main->MODUL_RECLASS= FALSE;
	$Main->TAMPIL_BIDANG=FALSE;
	$Main->MODUL_PEMUSNAHAN= 0; // 1=tampil
	$Main->MODUL_ASET_LAINNYA = FALSE;		
	$Main->REKAP_NERACA_2 = FALSE;//rekap neraca kertas kerja, rekap neraca 1 = jabar
	$Main->MENU_PERBANDINGAN = FALSE;
	$Main->MODUL_HISTORY = FALSE;
	$Main->MODUL_ASETLAINLAIN = FALSE;
	$Main->MODUL_KAPITALISASI = FALSE;
	$Main->MODUL_KOREKSI = FALSE;
	$Main->MODUL_KONDISI = FALSE;
	$Main->MODUL_PENGGUNAAN = FALSE;
	$Main->MODUL_PEMANFAATAN_BERAKHIR =0;
	$Main->BARCODE_ENABLE = FALSE;
	$Main->PENERIMAAN_P19 = 0;
	////
	
	$Main->APP_NAME =  'PETA';
	$Main->Judul = ":: ".$Main->APP_NAME." (Pencatatan Elektronik Tanah Aset) ";

	
}

//cek
$errSetting ='';
if($Main->SUSUT_MODE == '' || $Main->SUSUT_MODE==0 ) $errSetting .= 'SUSUT_MODE belum diseting! <br>';
if($Main->THN_ANGGARAN == '' ) $errSetting .= 'THN_ANGGARAN belum diseting! <br> ';
//cek ref_rekening sinkron seting dgn Data
$get = mysql_fetch_array(mysql_query("select count(*) as cnt from ref_rekening"));
if($get['cnt']>0){
	$rek = mysql_fetch_array(mysql_query("select max(length(o)) as maxlengtho from ref_rekening"));
	if ($Main->REK_DIGIT_O == 0 && $rek['maxlengtho'] <>2 ) $errSetting .= ' Seting $Main->REK_DIGIT_O ='.$Main->REK_DIGIT_O.', tidak sesuai data ref_rekening ('.$rek['maxlengtho'].')! <br>';
	if ($Main->REK_DIGIT_O == 1 && $rek['maxlengtho'] <>3 ) $errSetting .= ' Seting $Main->REK_DIGIT_O ='.$Main->REK_DIGIT_O.', tidak sesuai data ref_rekening ('.$rek['maxlengtho'].')! <br>';
}

/*****
// cek ref urusan dan ref skpd sinkron
select count(*) as cnt from ref_skpd aa 
left JOIN ref_urusan bb
on aa.c1= bb.bk and aa.c=bb.ck and aa.d=bb.dk and aa.nm_skpd =  bb.nm_urusan
where
aa.e='00'  and bb.bk is  null 
*****/



if($errSetting <> '' ) die($errSetting );// die($errSetting .' belum diseting!');


include ("common/fnfile.php");
?>
