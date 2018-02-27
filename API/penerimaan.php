<?php 
header('Content-Type: application/json');

include "common/daftarobj.php";
include "pages/pencarian/DataPengaturan.php";

function KodeProgram($bk, $ck, $dk, $p){
	//if(strlen($bk) < 1)$bk='0'.$bk;
	if(strlen($ck) < 2)$ck='0'.$ck;
	if(strlen($dk) < 2)$dk='0'.$dk;
	if(strlen($p) < 2)$p='0'.$p;
	
	return $bk.".".$ck.".".$dk.".".$p;
}

$arrKondisi = array();
$data = array();
$cek="";
$jml_bayar = 0;

$start=$_GET['start'];
$limit=$_GET['limit'];

//$kdskpd=$_GET['kdskpd'];
$kdskpd=$_GET['skpd'];
$tahun=$_GET['tahun'];
//$jns_trans = 1;
$jns_trans = '';

$limit = $limit==0 ? 100 : $limit;
$awal= $start==0 ? '0' :($start-1)*$limit;

//DEKLARASI SKPD ------------------------------------------------------------------
$skpd = explode(".", $kdskpd);

$c1="";
$c="";
$d="";
$e="";
$e1="";

if(isset($skpd[0]))$c1=$skpd[0];
if(isset($skpd[1]))$c=$skpd[1];
if(isset($skpd[2]))$d=$skpd[2];
if(isset($skpd[3]))$e=$skpd[3];
if(isset($skpd[4]))$e1=$skpd[4];

$t_penerimaan_barang_det = "v1_penerimaan_barang_det";
//CEK APAKAH SKPD LEVEL 4 atau 5
IF($Main->URUSAN == 0){
	$arrKondisi_SKPD = array();
	
	IF($skpd[0] != "")$arrKondisi_SKPD[] = "bk='".$skpd[0]."' ";
	IF($skpd[1] != "")$arrKondisi_SKPD[] = "ck='".$skpd[1]."' ";
	IF($skpd[2] != "")$arrKondisi_SKPD[] = "dk='".$skpd[2]."' ";
	
	$KodeSKPD = join(" AND ", $arrKondisi_SKPD);
	$KodeSKPD = $KodeSKPD != "" ? "WHERE ".$KodeSKPD : $KodeSKPD;
	
	$qry_skpd= $DataPengaturan->QyrTmpl1Brs("ref_skpd_urusan", "c,d", $KodeSKPD);
	$aqry_skpd = $qry_skpd['hasil'];
	
	$c=$aqry_skpd['c'];
	$d=$aqry_skpd['d'];
	$t_penerimaan_barang_det = "v_penerimaan_barang_det";
}
// END DEKLARASI SKPD ---------------------------------------------------------


 //kondisi ---------------------------------
	$arrKondisi[] = " status_validasi=1 ";
	IF($c1 != "")$arrKondisi[] = "tpb.c1 = '$c1' ";
	IF($c != "")$arrKondisi[] = "tpb.c = '$c' ";
	IF($d != "")$arrKondisi[] = "tpb.d = '$d' ";
	IF($e != "")$arrKondisi[] = "tpb.e = '$e' ";
	IF($e1 != "")$arrKondisi[] = "tpb.e1 = '$e1' ";
	IF($tahun != "")$arrKondisi[] = "tahun = '$tahun' ";
	IF($jns_trans != "")$arrKondisi[] = "jns_trans = '$jns_trans' ";
	
	$no_kontrak = $_GET['nokontrak'];
	if($no_kontrak != "") $arrKondisi[] = "nomor_kontrak = '$no_kontrak' ";
	
	$no_bast = $_GET['nobast'];
	if($no_bast != "") $arrKondisi[] = "no_dokumen_sumber = '$no_bast' ";
	
	$Kondisi = join(" AND ", $arrKondisi);
	$Kondisi = $Kondisi != "" ? " WHERE ".$Kondisi : $Kondisi;

//MULAI TAMPILKAN	
	//cari total tanpa limit
	$qry = "SELECT count(*)  as cnt FROM t_penerimaan_barang tpb LEFT JOIN ref_skpd rs ON tpb.c1=rs.c1 AND tpb.c=rs.c AND tpb.d=rs.d AND tpb.e=rs.e AND tpb.e1=rs.e1 $Kondisi" ;
	$totSql = mysql_fetch_array(mysql_query($qry));
	$total = $totSql['cnt'];
	
	//ambil data
	$qry = "SELECT tpb.*, rs.nm_skpd FROM t_penerimaan_barang tpb LEFT JOIN ref_skpd rs ON tpb.c1=rs.c1 AND tpb.c=rs.c AND tpb.d=rs.d AND tpb.e=rs.e AND tpb.e1=rs.e1 $Kondisi LIMIT $awal,$limit";
	//echo $qry;
	$daqry = mysql_query($qry);
	$jml_data = mysql_num_rows($daqry);
	$no = 0;
	while($dt = mysql_fetch_array($daqry)){
		$WHER_prog_keg = "WHERE bk='".$dt['bk']."' AND ck='".$dt['ck']."' AND dk='".$dt['dk']."' AND p='".$dt['p']."' ";
		//Ambil Program
		$qry_prog = $DataPengaturan->QyrTmpl1Brs("ref_program", "nama", $WHER_prog_keg." AND q='0' ");
		$dt_prog = $qry_prog['hasil'];
		//Ambil Kegiatan
		$qry_kgt = $DataPengaturan->QyrTmpl1Brs("ref_program", "nama", $WHER_prog_keg." AND q='".$dt['q']."' ");
		$dt_kgt = $qry_kgt['hasil'];
		
		$WHERE_Kondisi ="WHERE refid_terima='".$dt['Id']."' AND sttemp='0' AND status='0' ";
		
		//Belanja t_penerimaan_rekening -----------------------------------------------------------------------------------
		$arr_belanja = array();
		$qry_belanja = "SELECT * FROM v1_penerimaan_barang_rekening $WHERE_Kondisi ";
		$aqry_belanja = mysql_query($qry_belanja);
		$jml_bayar = 0;
		while($dt_belanja = mysql_fetch_array($aqry_belanja)){
			$arr_belanja[] = array(
				"kd_belanja"=>$dt_belanja['k'].".".$dt_belanja['l'].".".$dt_belanja['m'].".".$dt_belanja['n'].".".$dt_belanja['o'],
				"nm_rekening"=>$dt_belanja["nm_rekening"],
				"jumlah"=>$dt_belanja["jumlah"],
			);
			$jml_bayar += $dt_belanja["jumlah"];
		}
		
		//BARANG DETAIL ---------------------------------------------------------------------------------------------------
		$arr_barang_detail = array();
		$qry_barang_det = "SELECT * FROM $t_penerimaan_barang_det $WHERE_Kondisi ";
		$aqry_barang_det = mysql_query($qry_barang_det);
		while($dt_barang_det = mysql_fetch_array($aqry_barang_det)){
			$kodebarang = $dt_barang_det['f1'].".".$dt_barang_det['f2'].".".$dt_barang_det['f'].".".$dt_barang_det['g'].".".$dt_barang_det['h'].".".$dt_barang_det['i'].".".$dt_barang_det['j'];
			//if($Main->KD_BARANG_P108 != 0 || $Main->KD_BARANG_LEVEL7)$kodebarang = $dt_barang_det['f1'].".".$dt_barang_det['f2'].".".$kodebarang;
			
			//BARANG DISTRIBUSI ------------------------------------------------------------------------------------------
			/*$arr_brg_ditribusi = array();
			if($dt_barang_det['barangdistribusi'] == "1"){
			
				$qry_brg_distribusi = "SELECT * FROM t_distribusi WHERE refid_terima='".$dt['Id']."' AND sttemp='0' AND status='1' AND refid_penerimaan_det='".$dt_barang_det['Id']."' ";
				$daqry_brg_distribusi = mysql_query($qry_brg_distribusi);
				while($dt_brg_dstr = mysql_fetch_array($daqry_brg_distribusi)){
					$arr_brg_ditribusi[] = array(
												"e_dist" => $dt_brg_dstr["e"],
												"e1_dist" => $dt_brg_dstr["e1"],
												"jumlah" => $dt_brg_dstr["jumlah"],
												"nomor" => $dt_brg_dstr["nomor"],
												"tgl_dok" => $dt_brg_dstr["tgl_dok"],
												"jns_pemeliharaan" => $dt_brg_dstr["jns_pemeliharaan"],
												"refid_buku_induk" => $dt_brg_dstr["refid_buku_induk"],
												"refid_jns_pemeliharaan" => $dt_brg_dstr["refid_jns_pemeliharaan"],
											);
				}
			}*/
			
			
			$arr_barang_detail[] = array(
				"kd_barang"=>$kodebarang,
				"nm_barang"=>$dt_barang_det["nm_barang"],
				"ket_barang"=>$dt_barang_det["ket_barang"],
				"jml"=>$dt_barang_det["jml"],
				"satuan"=>$dt_barang_det["satuan"],
				"kuantitas"=>$dt_barang_det["kuantitas"],
				//"ket_kuantitas"=>$dt_barang_det["ket_kuantitas"], //pemeliharaan
				"harga_satuan"=>$dt_barang_det["harga_satuan"],
				"harga_total"=>$dt_barang_det["harga_total"],
				"keterangan"=>$dt_barang_det["keterangan"],
				//"barang_distribusi"=>$arr_brg_ditribusi,
			);
		
		}
		
		// BARANG ATRIBUSI ------------------------------------------------------------------------------------------------
		$arr_atribusi = array();		
		if($dt['biayaatribusi'] == "1" && $denganAtribusi == 1){
			$qry_attr = $DataPengaturan->QyrTmpl1Brs("t_atribusi", "*", "WHERE refid_terima='".$dt['Id']."' AND sttemp='0' AND jns_trans='".$dt['jns_trans']."' ");
			$daqry_attr = $qry_attr["hasil"];
			
			$arr_atribusi["Id"] = $daqry_attr["Id"];
			//$arr_atribusi["pencairan_dana"] = $daqry_attr["pencairan_dana"];
			$arr_atribusi["pencairan_dana"] = $DataPengaturan->Daftar_arr_pencairan_dana[$daqry_attr['pencairan_dana']];
			$arr_atribusi["sumber_dana"] = $daqry_attr["sumber_dana"];			
			//$arr_atribusi["cara_bayar"] = $daqry_attr["cara_bayar"];
			$arr_atribusi["cara_bayar"] = $DataPengaturan->Daftar_arr_cara_bayar[$daqry_attr["cara_bayar"]];
			$arr_atribusi["status_barang"] = $daqry_attr["status_barang"]; //?
			/**$arr_atribusi["ck"] = $daqry_attr["ck"];
			$arr_atribusi["dk"] = $daqry_attr["dk"];
			$arr_atribusi["q"] = $daqry_attr["q"];
			$arr_atribusi["pekerjaan"] = $daqry_attr["pekerjaan"];**/
			$arr_atribusi["dokumen_sumber"] = $daqry_attr["dokumen_sumber"];
			$arr_atribusi["no_sp2d"] = $daqry_attr["no_sp2d"];
			
			//ATRIBUSI RINCIAN
			$arr_attr_det = array();
			$qry_attr_det = "SELECT tar.*, rk.nm_rekening FROM t_atribusi_rincian tar LEFT JOIN ref_rekening rk ON (tar.k=rk.k AND tar.l=rk.l AND tar.m=rk.m AND tar.n=rk.n AND tar.o=rk.o) WHERE tar.refid_terima='".$dt['Id']."' AND tar.sttemp='0' AND tar.status='0' AND tar.refid_atribusi='".$daqry_attr["Id"]."' ";
			$aqry_attr_det = mysql_query($qry_attr_det);
			
			while($dt_attr_det = mysql_fetch_array($aqry_attr_det)){
				$arr_attr_det[] = array(
					"kd_belanja_atr"=>$dt_attr_det["k"].".".$dt_attr_det["l"].".".$dt_attr_det["m"].".".$dt_attr_det["n"].".".$dt_attr_det["o"],
					"nm_rekening_atr"=>$dt_attr_det["nm_rekening"],
					"jumlah"=>$dt_attr_det["jumlah"],
				);
			}
			$arr_atribusi["rincian"] = $arr_attr_det;
			
		}
		
		
		//$skpd = mysql_fetch_array(mysql_query("select * from ref_skpd where "))
		if($denganAtribusi==1){
		
			$data[] = array(
				"Id"=>$dt['Id'],
				"last_update"=>$dt['tgl_update'],
				//"kode_skpd"=>$dt['c1'].".".$dt['c'].".".$dt['d'].".".$dt['e'].".".$dt['e1'],
				"kode_skpd"=>$dt['c1'].".".$dt['c'].".".$dt['d'],
				"nm_skpd"=>$dt['nm_skpd'],
				/*"c1"=>$dt['c1'],
				"c"=>$dt['c'],
				"d"=>$dt['d'],
				"e"=>$dt['e'],
				"e1"=>$dt['e1'],
				"jns_trans"=>$dt['jns_trans'],*/
				"jenis_trans"=>$Main->ARR_JNS_TRANS[$dt['jns_trans']],
				//"asal_usul"=>$dt['asal_usul'],
				"asal_usul"=>$Main->ARR_ASALUSUL[$dt['asal_usul']],
				"sumber_dana"=>$dt['sumber_dana'],
				//"metode_pengadaan"=>$dt['metode_pengadaan'],
				"metode_pengadaan"=>$Main->ARR_METODEPENGADAAN[$dt['metode_pengadaan']],
				"pencairan_dana"=>$DataPengaturan->Daftar_arr_pencairan_dana[$dt['pencairan_dana']],
				/**"bk"=>$dt['bk'],
				"ck"=>$dt['ck'],
				"dk"=>$dt['dk'],
				"p"=>$dt['p'],
				"q"=>$dt['q'],**/
				//"kode_program"=>$DataPengaturan->KodeProgram($dt['bk'],$dt['ck'],$dt['dk'],$dt['p']),
				"kode_program"=>KodeProgram($dt['bk'],$dt['ck'],$dt['dk'],$dt['p']),
				"kode_kegiatan"=>$DataPengaturan->KodeKegiatan($dt['q']),
				"nama_program"=>$dt_prog['nama'],
				"nama_kegiatan"=>$dt_kgt['nama'],
				"pekerjaan"=>$dt['pekerjaan'],
				"nomor_kontrak"=>$dt['nomor_kontrak'],
				"tgl_kontrak"=>$dt['tgl_kontrak'],
				//"jml_bayar"=>$dt['jml_bayar'], //?
				//"jml_bayar"=>$jml_bayar, 
				//"cara_bayar"=>$dt['cara_bayar'],
				"cara_bayar"=>$DataPengaturan->Daftar_arr_cara_bayar[$dt['cara_bayar'] ],
				//"id_penerimaan"=>$dt['id_penerimaan'],
				"no_penerimaan"=>$dt['id_penerimaan'],
				"dokumen_sumber"=>$dt['dokumen_sumber'],
				"tgl_dokumen_sumber"=>$dt['tgl_dokumen_sumber'],
				"no_dokumen_sumber"=>$dt['no_dokumen_sumber'],
				"tgl_buku"=>$dt['tgl_buku'],
				//"refid_penyedia"=>$dt['refid_penyedia'],
				//"refid_penerima"=>$dt['refid_penerima'],
				"nama_penyedia"=>$dt['nama_refid_penyedia'],
				"nama_penerima"=>$dt['nama_refid_penerima'],
				//"biaya_atribusi"=>$dt['biayaatribusi'], //DITAMBAH BIAYA ATRIBUSI ?
				"tahun"=>$dt['tahun'],
				"belanja"=>$arr_belanja,
				"barang_detail"=>$arr_barang_detail,
				"attribusi"=>$arr_atribusi,
			);
		}
		else{
			$data[] = array(
				"Id"=>$dt['Id'],
				"last_update"=>$dt['tgl_update'],
				//"kode_skpd"=>$dt['c1'].".".$dt['c'].".".$dt['d'].".".$dt['e'].".".$dt['e1'],
				"kode_skpd"=>$dt['c1'].".".$dt['c'].".".$dt['d'],
				"nm_skpd"=>$dt['nm_skpd'],
				/*"c1"=>$dt['c1'],
				"c"=>$dt['c'],
				"d"=>$dt['d'],
				"e"=>$dt['e'],
				"e1"=>$dt['e1'],
				"jns_trans"=>$dt['jns_trans'],*/
				"jenis_trans"=>$Main->ARR_JNS_TRANS[$dt['jns_trans']],
				//"asal_usul"=>$dt['asal_usul'],
				"asal_usul"=>$Main->ARR_ASALUSUL[$dt['asal_usul']],
				"sumber_dana"=>$dt['sumber_dana'],
				//"metode_pengadaan"=>$dt['metode_pengadaan'],
				"metode_pengadaan"=>$Main->ARR_METODEPENGADAAN[$dt['metode_pengadaan']],
				"pencairan_dana"=>$DataPengaturan->Daftar_arr_pencairan_dana[$dt['pencairan_dana']],
				/**"bk"=>$dt['bk'],
				"ck"=>$dt['ck'],
				"dk"=>$dt['dk'],
				"p"=>$dt['p'],
				"q"=>$dt['q'],**/
				//"kode_program"=>$DataPengaturan->KodeProgram($dt['bk'],$dt['ck'],$dt['dk'],$dt['p']),
				"kode_program"=>KodeProgram($dt['bk'],$dt['ck'],$dt['dk'],$dt['p']),
				"kode_kegiatan"=>$DataPengaturan->KodeKegiatan($dt['q']),
				"nama_program"=>$dt_prog['nama'],
				"nama_kegiatan"=>$dt_kgt['nama'],
				"pekerjaan"=>$dt['pekerjaan'],
				"nomor_kontrak"=>$dt['nomor_kontrak'],
				"tgl_kontrak"=>$dt['tgl_kontrak'],
				//"jml_bayar"=>$dt['jml_bayar'], //?
				//"jml_bayar"=>$jml_bayar, 
				//"cara_bayar"=>$dt['cara_bayar'],
				"cara_bayar"=>$DataPengaturan->Daftar_arr_cara_bayar[$dt['cara_bayar'] ],
				//"id_penerimaan"=>$dt['id_penerimaan'],
				"no_penerimaan"=>$dt['id_penerimaan'],
				"dokumen_sumber"=>$dt['dokumen_sumber'],
				"tgl_dokumen_sumber"=>$dt['tgl_dokumen_sumber'],
				"no_dokumen_sumber"=>$dt['no_dokumen_sumber'],
				"tgl_buku"=>$dt['tgl_buku'],
				//"refid_penyedia"=>$dt['refid_penyedia'],
				//"refid_penerima"=>$dt['refid_penerima'],
				"nama_penyedia"=>$dt['nama_refid_penyedia'],
				"nama_penerima"=>$dt['nama_refid_penerima'],
				//"biaya_atribusi"=>$dt['biayaatribusi'], //DITAMBAH BIAYA ATRIBUSI ?
				"tahun"=>$dt['tahun'],
				"belanja"=>$arr_belanja,
				"barang_detail"=>$arr_barang_detail,
				//"attribusi"=>$arr_atribusi,
			);
		}
	}
	
	
	//$data = array("cek"=>$cek, "jml_data" => $jml_data, "data"=>$data);
	$data = array( "total_data"=>$total, "jml_data" => $jml_data, "data"=>$data);
	
	echo json_encode($data);

?>