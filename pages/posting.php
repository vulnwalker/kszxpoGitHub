<?php
class postingPerencanaanObj extends DaftarObj2{
	var $Prefix = 'postingPerencanaan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'postingPerencanaan_x'; //bonus
	var $TblName_Hapus = 'postingPerencanaan_x';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'ADMINISTRASI SYSTEM';
	var $PageIcon = 'images/administrasi_ico.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='postingPerencanaan.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'postingPerencanaan';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'postingPerencanaanForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0
	var $daftarMode = '1'; //(''=normal,1=detail horisontal)
	var $tableWidth = '50%'; //width utk daftar master pada mode detail horison
	var $containWidth = '500';

  var $modul = "RKA-SKPD";
  var $jenisForm = "";
  var $tahun = "";
  var $nomorUrut = "";
  var $jenisAnggaran = "";
  var $idTahap = "";
  var $currentTahap = "";
  var $namaTahapTerakhir = "";
  var $masaTerakhir = "";
  //buatview
  var $urutTerakhir = "";
  var $urutSebelumnya = "";
  var $jenisFormTerakhir = "";

  var $username = "";
  var $wajibValidasi = "";

  var $sqlValidasi = "";
  //buatview


  var $publicVar = "";
  var $publicKondisi = "";
  var $publicExcept = array();
  var $publicGrupId = array();


  var $provinsi = "";
  var $kota = "";
  var $pengelolaBarang = "";
  var $pejabatPengelolaBarang = "";
  var $pengurusPengelolaBarang = "";
  var $nipPengelola = "";
  var $nipPejabat = "";
  var $nipPengurus ="";


	function set_selector_other($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;

	  switch($tipe){




    case 'postRKA':{
			foreach ($_REQUEST as $key => $value) {
		  	$$key = $value;
	 		}
      if(empty($tujuanPosting)){
        $err = "Pilih Tujuan Posting";
      }elseif(  $this->jenisForm != "PENYUSUNAN" && $this->jenisForm !="KOREKSI" && $tujuanPosting =="9"){
        $err = "Posting sudah di lakukan";
      }

      if(empty($err)){
          if($tujuanPosting == "9"){
            $jenisForm = "READ";
            $namaTahap = "PENETAPAN DPA";
          }
          $getDataModul = mysql_fetch_array(mysql_query("select * ref_modul where id_modul = '$tujuanPosting'"));

          $content = array(
           "tahunAnggaran" => $this->tahun,
           "jenisAnggaran" => $this->jenisAnggaran,
           "jenisForm" => $jenisForm,
           "namaModul" => $getDataModul['nama_modul'],
           'namaTahap' => $namaTahap
          );

      }


		break;
		}


    case 'postAnggaranKas':{
			foreach ($_REQUEST as $key => $value) {
		  	$$key = $value;
	 		}
      if(empty($tujuanPosting)){
        $err = "Pilih Tujuan Posting";
      }elseif(mysql_num_rows(mysql_query("select * from ref_tahap_anggaran where tahun = '$this->tahun' and anggaran = '$this->jenisAnggaran' and id_modul = '10'")) != 0){
        $err = "Posting sudah di lakukan";
      }elseif( mysql_num_rows(mysql_query("select * from ref_tahap_anggaran where tahun = '$this->tahun' and anggaran = '$this->jenisAnggaran' and id_modul = '9'")) == 0){
        $err = "Lakukan Posting ke DPA terlebih dahulu";
      }

      if(empty($err)){
          if($tujuanPosting == "10"){
            $jenisForm = "PENYUSUNAN";
            $namaTahap = "PENYUSUNAN SPD";
          }
          $getDataModul = mysql_fetch_array(mysql_query("select * ref_modul where id_modul = '$tujuanPosting'"));

          $content = array(
           "tahunAnggaran" => $this->tahun,
           "jenisAnggaran" => $this->jenisAnggaran,
           "jenisForm" => $jenisForm,
           "namaModul" => $getDataModul['nama_modul'],
           'namaTahap' => $namaTahap
          );

      }


		break;
		}


		 default:{
				$other = $this->set_selector_other2($tipe);
				$cek = $other['cek'];
				$err = $other['err'];
				$content=$other['content'];
				$json=$other['json'];
		 break;
		 }

	 }//end switch

		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }
}
$postingPerencanaan = new postingPerencanaanObj;

$arrayResult = VulnWalkerTahap_v2('RKA');
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];

$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$postingPerencanaan->jenisForm = $jenisForm;
$postingPerencanaan->nomorUrut = $nomorUrut;
$postingPerencanaan->urutTerakhir = $nomorUrut;
$postingPerencanaan->tahun = $tahun;
$postingPerencanaan->jenisAnggaran = $jenisAnggaran;
$postingPerencanaan->idTahap = $idTahap;

$postingPerencanaan->username = $_COOKIE['coID'];

$postingPerencanaan->wajibValidasi = $Main->wajibValidasi;
if($Main->wajibValidasi == TRUE){
	$postingPerencanaan->sqlValidasi = " and status_validasi ='1' ";
}else{
	$postingPerencanaan->sqlValidasi = " ";
}


if(empty($postingPerencanaan->tahun)){

	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_rka_2_2_1 "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where id_anggaran = '$maxAnggaran'"));
	/*$postingPerencanaan->tahun = "select max(id_anggaran) as max from view_rka_2_2_1 where nama_modul = 'rkaSKPD221'";*/
	$postingPerencanaan->tahun  = $get2['tahun'];
	$postingPerencanaan->jenisAnggaran = $get2['jenis_anggaran'];
	$postingPerencanaan->urutTerakhir = $get2['no_urut'];
	$postingPerencanaan->jenisFormTerakhir = $get2['jenis_form_modul'];
	$postingPerencanaan->urutSebelumnya = $postingPerencanaan->urutTerakhir - 1;


	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$postingPerencanaan->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$postingPerencanaan->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$postingPerencanaan->currentTahap = $arrayHasil['currentTahap'];
}else{
	$getCurrenttahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$postingPerencanaan->idTahap'"));
	$postingPerencanaan->currentTahap = $getCurrenttahap['nama_tahap'];

	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$postingPerencanaan->idTahap'"));
	$postingPerencanaan->jenisFormTerakhir =  $namaTahap['jenis_form_modul'];
	$postingPerencanaan->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$postingPerencanaan->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
}


$setting = settinganPerencanaan_v2();
$postingPerencanaan->provinsi = $setting['provinsi'];
$postingPerencanaan->kota = $setting['kota'];
$postingPerencanaan->pengelolaBarang = $setting['pengelolaBarang'];
$postingPerencanaan->pejabatPengelolaBarang = $setting['pejabat'];
$postingPerencanaan->pengurusPengelolaBarang = $setting['pengurus'];
$postingPerencanaan->nipPengelola = $setting['nipPengelola'];
$postingPerencanaan->nipPengurus = $setting['nipPengurus'];
$postingPerencanaan->nipPejabat = $setting['nipPejabat'];


if($postingPerencanaan->jenisForm != "PENYUSUNAN"){
$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_rka_2_2_1 where jenis_form_modul = 'PENYUSUNAN' "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where id_anggaran = '$maxAnggaran'"));
	$postingPerencanaan->tahun  = $get2['tahun'];
	$postingPerencanaan->jenisAnggaran = $get2['jenis_anggaran'];
	$postingPerencanaan->urutTerakhir = $get2['no_urut'];
	$postingPerencanaan->jenisFormTerakhir = $get2['jenis_form_modul'];
	$postingPerencanaan->urutSebelumnya = $postingPerencanaan->urutTerakhir - 1;


	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$postingPerencanaan->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$postingPerencanaan->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$postingPerencanaan->currentTahap = $arrayHasil['currentTahap'];
			$postingPerencanaan->jenisForm = "";
			$postingPerencanaan->jenisFormTerakhir = "PENYUSUNAN";
			$postingPerencanaan->idTahap = $get2['id_tahap'];
			$postingPerencanaan->nomorUrut = $get2['no_urut'];
			$postingPerencanaan->urutTerakhir = $get2['no_urut'];
			$postingPerencanaan->idTahap = $idtahapTerakhir;
			$postingPerencanaan->tahun = $get2['tahun'];
}
?>
