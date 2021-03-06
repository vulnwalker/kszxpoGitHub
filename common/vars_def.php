<?php
$Main->APP_NAME = 'ATISISBADA';//'MANTAP';
$Main->Judul = ":: ".$Main->APP_NAME." (Aplikasi Teknologi Informasi Siklus Barang Daerah)";
$Main->CopyRight = "<br>
<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"hakcipta\">
<tr><td>
	Pemerintah Kota Demo.
	 2015.
</td></tr>
</table>
";
$Main->CopyRight_isi = "Pengembang : PT. PILAR WAHANA ARTHA, Jl.Cikutra Baru XII No.24 Bandung
	Telp. (022) 87240297 HP. 081221239899";
$Main->HeadStyleico="<link rel=\"shortcut icon\" href=\"images/logo_web_demo_kota.ico\" />";
$Main->ManualBook="Buku_Petunjuk_ATISISBADA.pdf";
$Main->Image13='index_13_demo_kota.gif';
$Main->Image14='index_14_demo_kota.gif';
$Main->Logocetak='logo_cetak1_demo_kota.jpg';




//---------- DEFAULT -----------------
$USER_TIME_OUT = 15;//menit timeout, otomatis logout jika iddle
$USER_TIME_OUT2 = 1;//menit timeout untuk login
$Main->DB_Hostname = 'localhost';
$Main->DB_Databasename = 'db_atisisbada_2017';
$Main->DB_User = 'operatordb';
$Main->DB_Pass = 'Lupa321Zx';
$Main->DB_Port = ':50300';


$Main->PagePerHal 		= 25;
$Main->JmlDataHal 		= 0;
//$Main->DEF_KEPEMILIKAN 	= '12';//12 milik kota/kab , 11 milik propinsi  //pindah tbl setting
//$Main->NM_KEPEMILIKAN = 'Pemerintah Kabupaten/Kota'; //'Propinsi'  //pindah tbl setting
//Provinsi
$Main->Provinsi =array("28","CONTOH");
//$Main->DEF_PROPINSI		= '10';  //pindah tbl setting
//$Main->DEF_WILAYAH 		= '03';  //pindah tbl setting
//$Main->NM_WILAYAH 		= 'Kota Demo';  //pindah tbl setting
//$Main->NM_WILAYAH2		= 'PEMERINTAH KOTA DEMO';  //pindah tbl setting

$Main->BARCODE_ENABLE = TRUE;
$Main->PENATAUSAHA_TOOLBARBAWAH = TRUE;

$Main->MODUL_PEMELIHARAAN = TRUE;
$Main->MODUL_PENGAMANAN = TRUE;
$Main->MODUL_MUTASI = TRUE;
$Main->MODUL_SENSUS = TRUE;
$Main->MODUL_SENSUS_MANUAL = FALSE;


$Main->MODUL_PERENCANAAN = TRUE;
$Main->MODUL_PENGADAAN = TRUE;
$Main->MODUL_PENERIMAAN = TRUE;
$Main->MODUL_PENGGUNAAN = TRUE;
$Main->MODUL_PENATAUSAHAAN = TRUE;
$Main->MODUL_PEMANFAATAN = TRUE;
$Main->MODUL_PENGAMANPELIHARA = TRUE;
$Main->MODUL_PENILAIAN = TRUE;
$Main->MODUL_PENGAPUSAN = TRUE;
$Main->MODUL_PENGAPUSAN_SK = TRUE;
$Main->MODUL_PENGAPUSAN_SEBAGIAN =TRUE;
$Main->MODUL_PEMINDAHTANGAN = TRUE;
$Main->MODUL_PEMBIAYAAN = FALSE;
$Main->MODUL_GANTIRUGI = FALSE;
$Main->MODUL_MONITORING = FALSE;
$Main->MODUL_CHART = TRUE;
$Main->MODUL_PEMBUKUAN = TRUE;
$Main->MODUL_AKUNTANSI= FALSE;
$Main->MODUL_RECLASS= TRUE;
$Main->TAMPIL_BIDANG=FALSE;
$Main->MODUL_PEMUSNAHAN= 1; // 1=tampil
$Main->MODUL_PERSEDIAAN = TRUE;

$Main->KEPALA_OPD	= 'KEPALA SKPD';
$Main->CETAK_LOKASI = 'Demo';
$Main->MODUL_ASET_LAINNYA = TRUE; //kib g

$Main->SUBUNIT_DIGIT = 3; // ditampilkan 3
$Main->LABEL_KODE_WIDTH = 248; //labael kode di kanan atas penatausahaan - edit
$Main->LABEL_KODE_SUBUNIT_WIDTH = 32 ;// width utk kode e1 /seksi

$Main->SUBSUBKEL_DIGIT = 3; // ditampilkan 3
$Main->LABEL_KODE_SUBSUBKEL_WIDTH = 32 ;// width utk kode e1 /seksi

$Main->PATH_IMAGES='gambar2011';
$Main->PATH_DOKUMENS='dokum2011';



$Main->TAHUN_CUTOFF = 0; //<= : tahun tglbuku =  2012
$Main->NILAI_EXTRACOMPATIBLE=0;
$Main->TGL_CUTOFF = '31 Desember '.$Main->TAHUN_CUTOFF;
$Main->VerifikasiEnable=FALSE;

$Main->MODUL_PETA = TRUE;
$Main->SUB_UNIT = TRUE;

$Main->SHOW_CEK = 1;
$Main->KOND_ADA_TIDAK = FALSE;


$Main->BACKUP_DIR = '../../backup_sistem/atisisbada_bogor_kab/mysql/mysql/';

//$Main->WEB_LOCATION = 'http://atisisbada.net/';

if ($Main->KOND_ADA_TIDAK){
	$Main->KondisiBarang = array(
		array("1","Baik"),
		array("2","Kurang Baik"),
		array("3","Rusak Berat"),
		array("4","Tidak Ada")
	);
}else{
	$Main->KondisiBarang = array(
		array("1","Baik"),
		array("2","Kurang Baik"),
		array("3","Rusak Berat")
	);
}

$Main->KondisiBarangLainnya = array(
	array("80","Ada Bukan Rusak Berat"),
	array("81","Ada")
);

$Main->KondisiEkstra=array(
		array("02","00","00","00","00",500000),
		array("05","00","00","00","00",500000)

);



$Main->CekIntraEkstra=FALSE;
$Main->thnsensus_default = 2016;//2014;
$Main->periode_sensus = 5;// tahun
$Main->defTglBukuBelumSensus =  '2016-12-31';//'2014-12-31';
/*$Main->GambarPath="/var/www/docs_atsb1/gambar2011";
$Main->DokumenPath="/var/www/docs_atsb1/dokum2011";
$Main->DownloadPath="/var/www/docs_atsb1/downloads2011";
$Main->ProfilePath="/var/www/docs_atsb1/profile2011";
$Main->TempPath="/var/www/tmps2011";
*/


$Main->StatusCek = array(
array("0","Belum di cek"),
array("1","Tidak ada error"),
array("2","Ada Error")
);

$Main->StatusMigrasi = array(
array("0","Belum Migrasi"),
array("1","Sudah Migrasi"),
array("2","Migrasi Ada Error")
);



/*$Main->StatusAsetView = array(
	array("1","Intrakomptabel"),
	array("2","Aset Lancar"),
	array("3","Aset Tetap"), f,g
	array("4","Aset Lainnya"),
	array("5","Tagihan Penjualan Angsuran"),  f,g = 07.21
	array("6","Tuntutan Ganti Rugi"),  f,g = 07.22
	array("7","Kemitraan dengan Pihak Tiga"), f,g = 07.23
	array("8","Aset Tidak Berwujud"), f,g = 07.24
	array("9","Aset Lain-lain"),  f,g = 07.25
	array("10","Ekstrakomptabel")staset 10
);
*/

//$Main->MODUL_JURNAL = FALSE;
//$Main->MODUL_HISTORY = FALSE;

//$Main->REKON=FALSE;


/* default */
$Main->CLOSING_SKPD=1; //0 clsoing perskpd
$Main->MODUL_SUBUNIT = TRUE;
$Main->SUBUNIT_DIGIT = 3;
$Main->KODEBARANGJ = '000';
$Main->KODEBARANGJ_DIGIT = 3; //digit
$Main->NOREG_SIZE = 4;
$Main->NOREG_SAMPLE = '0002';
$Main->NOREG_MAX = 9999;


$Main->MODUL_AKUNTANSI = TRUE;
$Main->MODUL_ASET_LAINNYA = TRUE;
$Main->MODUL_SENSUS = TRUE;
$Main->REKAP_NERACA_2 = TRUE;//rekap neraca kertas kerja, rekap neraca 1 = jabar
$Main->MENU_PERBANDINGAN = TRUE;
$Main->MODUL_HISTORY = TRUE;

$Main->STASET_OTOMATIS = FALS;
$Main->MODUL_ASETLAINLAIN = TRUE;

$Main->MODUL_KAPITALISASI = TRUE;
$Main->MODUL_KOREKSI = TRUE;
$Main->MODUL_KONDISI = TRUE;
$Main->MODE_EDIT_SKPD = 1;
$Main->STATUS_SURVEY = 0;





$Main->DOWNLOAD_MOBILE = TRUE;
$Main->APK_FILE = "ATISISBADA_KabSrg.apk";

//0. mode 2 dihitung tahun, nilai susut sem dibagi2, disimpan per sem; mode 1/kosong = dihitung per bulan, bulan berikut sudah penyusutan, disimpan per semester
$Main->JURNAL_FISIK = 1;

$Main->MODUL_JMLGAMBAR = TRUE;
$Main->TAMPIL_BIDANG = TRUE;
$Main->MODUL_BAST = TRUE;
$Main->MODUL_SPK = TRUE;
$Main->MODUL_IDBARANG = TRUE;




//PP27 -----------------------------------------------
//$Main->PP27_MAINMENU = TRUE;//
$Main->PP27_PERENCANAAN = TRUE;
$Main->PP27_PENGADAAN = TRUE;
//$Main->PP27_PENERIMAAN = TRUE;
//$Main->PP27_PENGGUNAAN = TRUE;
//$Main->PP27_PEMANFAATAN = TRUE;
//$Main->PP27_PEMELIHARA = TRUE;
//$Main->PP27_PENILAIAN = TRUE;
//$Main->PP27_PENGHAPUSAN = TRUE;
//$Main->PP27_PEMINDAHTANGAN = TRUE;
$Main->PP27_GANTIRUGI = TRUE;

$Main->MODUL_PENGGUNAAN = TRUE;
$Main->MODUL_BAST = TRUE;
$Main->MODUL_SPK = TRUE;
$Main->MODUL_IDBARANG = TRUE;

$Main->REF_URUSAN = 0;
$Main->REFSKPD_URUSAN = 0;



$Main->MODUL_PEMANFAATAN_BERAKHIR =1;




/***
switch ($Main->VERSI_NAME){

	case 'SERANG' :{
		$Main->MODUL_SUBUNIT = TRUE; //seksi
		$Main->SUBUNIT_DIGIT = 3;
		$Main->KODEBARANGJ = '000';
		$Main->KODEBARANGJ_DIGIT = 3; //digit
		$Main->NOREG_SIZE = 4;
		$Main->NOREG_SAMPLE = '0002';
		$Main->NOREG_MAX = 9999;
		$Main->PENYUSUTAN = TRUE;
		$Main->TAHUN_MULAI_SUSUT = 0;
		$Main->MODUL_AKUNTANSI = TRUE;
		$Main->MODUL_ASET_LAINNYA = TRUE;
		$Main->MODUL_SENSUS = TRUE;
		$Main->REKAP_NERACA_2 = TRUE;
		$Main->MENU_PERBANDINGAN = TRUE;
		$Main->MODUL_HISTORY = TRUE;
		$Main->SUSUT_MODE=2;// dihitung tahun, utk sem dibagi2

		break;
	}
	default:{//all
		break;
	}
}
***/

//$Main->VERSI_NAME = 'CIREBON_KAB'; //pindah tbl setting //'CIREBON_KAB';//'PANDEGLANG';// 'SERANG';//''; //CIREBON_KAB, GARUT, SERANG, JABAR, BOGOR, BDG_BARAT, TASIKMALAYA_KAB
//$Main->VERSI_NAME = 'KOTA_BANDUNG';

$Main->REKON_BA = 0;//utk cirebon

//penyusutan ------------------------------------------------------------------
$Main->PENYUSUTAN = TRUE;
$Main->TAMPIL_SUSUT = 0; //ket : 1 untuk di tampilkan, 0 untuk tidak ditampilkan
//$Main->SUSUT_MODE=9;//pindah ke tabel setting
$Main->TAHUN_MULAI_SUSUT = 0;
$Main->TOMBOL_PENYUSUTAN = 1;

//tahun anggaran ------------------------------------------------------------
$Main->WITH_THN_ANGGARAN = TRUE;// tahun login
//$Main->THN_ANGGARAN = 2016; //sudah di pindah , diset di tabel setting, id = 'THN_ANGGARAN', di ambil di config

//untuk perencanaan , penerimaan p19-----------------------------------------
$Main->KODE_BELANJA_MODAL = '5.2.3';
$Main->KODE_BELANJA_ATRIBUSI = '5.2.2';
$Main->KODE_BELANJA_BJ = '5.1.2';//barang jasa
$Main->KODE_PENDAPATAN_HIBAH = '4.3.1'; // u/ perolehan hibah?
$Main->KODE_BELANJA='5';
$Main->KODE_BELANJA_LANGSUNG='2';
$Main->KODE_ASET_TETAP = '1.3';
$Main->KODE_AKUMSUSUT = '1.3.7';

//URUSAN ---------------------------------------------------------------------
//$Main->URUSAN =1;// pindah seting ke tabel setting,  di ambil di config

//KODE BARANG P108 -----------------------------------------------------------
$Main->KD_BARANG_P108 = 0;

//INTEGRASI SIPKD Pandeglang ------------------------------------------------
$Main->MODUL_PROGRAM = 0; //untuk integrasi dgn sipkd, pandeglang =1

//INTEGRASI BIRMS -----------------------------------------------------------
$Main->BIRMS = 0;
$Main->BIRMS_URL = "https://birms.bandung.go.id/api/pekerjaan/";
//$Main->BIRMS_URL = "http://123.231.253.228/atis/testBirmNew.php/";
$Main->REK_PENERIMAAN_BIRM = 2; //1 = Lama, 2 Baru

//PENERIMAAN P19 ------------------------------------------------------------
//$Main->PENERIMAAN_P19 = 1;  // pindah seting ke tabel setting,  di ambil di config
$Main->PENERIMAAN_P19_POST = 1;
//$Main->CEK_BI = 1;// pindah seting ke tabel setting,  di ambil di config




//$Main->MENU_VERSI =3;//0; pindah ke tabel seting //0=defaulkt, 1 pp27, 2= mantap kota bandung 3=permen19 4= peta sebaran, 5 = menu baru
$Main->REKAP_KONDISI = 0;

$Main->FIELD_KODE_BELANJA_MODAL = "CONCAT(k, '.', l, '.', m) ";
$Main->KODE_BELANJA_DIPILIH = '5.2';

$Main->ASET_TDK_BERWUJUD = "24";
$Main->KIB_F = "06";



$Main->ARR_JNS_TRANS = array(
			'1'=>'PENGADAAN BARANG',
			'2'=>'PEMELIHARAAN BARANG',
			);
$Main->ARR_ASALUSUL = array(
			'1'=>'PEMBELIAN',
			'2'=>'HIBAH',
			'3'=>'LAINNYA',
			);

$Main->ARR_METODEPENGADAAN = array(
			'1'=>'PIHAK KE-3',
			'2'=>'SWAKELOLA',
			);
$Main->HEADER_JSON = 0;

$Main->REK_DIGIT_O =0; //Type Data Char 0 = 2 Digit, 1=3 Digit. untuk kode ref rekening level 5 (o) kode 3 digit (garut, tasik )
$Main->PENERIMAAN_REK_BELANJAPEGAWAI = 0;

$Main->VALIDASI_ATRIBUSI = 0; // 1 Ya, 0=Tidak
$Main->VALIDASI_KAPITALISASI = 0; // 1 Ya, 0=Tidak

$Main->SINGKRON_ATRIBUSI = 1;
$Main->PEMBAGIANHARGA = 2; // 1 Yang Lama, 2= Yang Baru (hargabarang dari t_penerimaan_rekening, atribusi dari t_penerimaan_atribusi)
$Main->SUSUT_INFO_ALL = 1;

$Main->SHORTCUT_MUTASI_SOTK = 0; //1= tampil di menu utama di bagian bawah, 0 =tidak tampil
$Main->SHORTCUT_MUTASI_SOTK_LINK = "http://123.231.253.228/atis_mapping/"; //link sesuai pemda

$Main->HAL_RETENSI = 0; //1=Aktif, 0=Tidak
$Main->TAHUN_RETENSI_SBLM = 0;//Aktif,0=Tidak

// cek referensi kapitalisasi dengan buku induk
$Main->REF_KAPITAL_CEK = 1; //1= cek buku induk, 0=tanpa pengecekan buku induk.

//BATAL VALIDASI PENERIMAAN
$Main->ADMIN_BATAL_VALIDASI = 1;

$Main->REK_POTONGAN_SPM = 7;

$Main->PPN_PENGADAANV2 = 0;//Aktif,0=Tidak
$Main->Kode_j1 = 1;//1=Aktif 0=Tidak
$Main->f_Persedian = "f='08'";
$Main->f_KodePersedian = "08";
$Main->DPA = 0; //1=Aktif, 0=Tidak
$Main->PENERIMAAN_DET_DPA_DEL = 1; //1=Aktif, 0=Tidak
$Main->PENERIMAAN_DETAIL_POSTING = 0;//1=Aktif, 0=Tidak Jika Data masih belum selesai semua di posting, maka tanda selesai post hanya diberikan kepada yg sudah selesai posting
$Main->CekNPWP_PenyediaBarang = FALSE;

$Main->WAIT_PostingPenerimaan = 0.5;
$Main->KODE_KAS_BENDAHARA_KELUAR_BANK = '1.1.1.03.001';
?>
