<?php
	
	include "pages/pengadaanpenerimaan/pemasukan.php";
	$pemasukan_saja = $pemasukan;
 
class pemasukan_atribusiObj  extends DaftarObj2{	
	var $Prefix = 'pemasukan_atribusi';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_satuan'; //bonus
	var $TblName_Hapus = 'ref_satuan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('nama');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'PENGADAAN DAN PENERIMAAN';
	var $PageIcon = 'images/pengadaan_ico.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pemasukan_atribusi.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'pemasukan_atribusi';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'pemasukan_atribusiForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	var $stat_barang = array(
		array("1", "SUDAH"),
		array("2", "BELUM"),
	);
	
	function setTitle(){
		return 'BIAYA ATRIBUSI BARANG';
	}
	
	function setMenuEdit(){
		return "";
		/*return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","new_f2.png","Atribusi", 'Atribusi')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","new_f2.png","Distribusi", 'Distribusi')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","new_f2.png","Validasi", 'Validasi')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","new_f2.png","Posting", 'Posting')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","export_xls.png","Excel", 'Excel')."</td>";*/
	}
	
	function setMenuView(){
		return "";
	}
	
	function SimpanSemua(){
	 global $HTTP_COOKIE_VARS;
	 global $Main, $DataPengaturan, $pemasukan_saja;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 
	 $c1= cekPOST('c1nya');
	 $c= cekPOST('cnya');
	 $d= cekPOST('dnya');
	 $e= cekPOST('enya');
	 $e1= cekPOST('e1nya');
	 
	 $jns_transaksi= cekPOST('jns_transaksi');
	 $pencairan_dana= cekPOST('pencairan_dana');
	 $sumberdana= cekPOST('sumberdana');
	 $cara_bayar= cekPOST('cara_bayar');
	 $stat_barang= cekPOST('stat_barang');
	 $id_penerimaan= cekPOST('id_penerimaan');
	 $prog= cekPOST('prog');
	 $kegiatan= cekPOST('kegiatan');
	 $pekerjaan= cekPOST('pekerjaan');
	 $penyedian= cekPOST('penyedian');
	 $pelaksana= cekPOST('pelaksana');
	 $dokumen_atribusi= cekPOST('dokumen_atribusi');
	 
	 $dokumen_sumber= $_REQUEST['dokumen_sumber'];
	 $tgl_dokumen_bast= explode("-", $_REQUEST['tgl_dokumen_bast']);
	 $tgl_dokumen_bast = $tgl_dokumen_bast[2].$tgl_dokumen_bast[1].$tgl_dokumen_bast[0];
	 $nomor_dokumen_bast= $_REQUEST['nomor_dokumen_bast'];
	 
	 
	 $refid_terima= $_REQUEST['refid_terima'];
	 $pemasukan_atribusi_idplh= $_REQUEST['pemasukan_atribusi_idplh'];
	 
	 $qry_Penerimaan = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang", "asal_usul", "WHERE Id='".$refid_terima."' ");
	 $dt_Penerimaan = $qry_Penerimaan["hasil"];
	 
	 if($err == '' && $jns_transaksi =='')$err = "Jenis Transaksi Belum Dipilih !";
	 if($err == '' && $pencairan_dana =='')$err = "Mekanisme Pencairan Dana Belum Dipilih !";
	 if($err == '' && $sumberdana =='')$err = "Sumber Dana Belum Dipilih !";
	 if($err == '' && $cara_bayar =='')$err = "Jenis Pembayaran Belum Dipilih !";
	 if($err == '' && $pelaksana =='')$err = "Pelaksana Belum Dipilih !";
	 if($err == '' && $stat_barang =='')$err = "'Barang Sudah Diterima ?' Belum Dipilih !";
	 if($err == '' && $stat_barang == '1' && $dt_Penerimaan["asal_usul"] == "1"){
	 	if($err == '' && $prog == '')$err = "Program Belum Diisi !";
	 	if($err == '' && $kegiatan == '')$err = "Kegiatan Belum Diisi !";
	 	if($err == '' && $pekerjaan == '')$err = "Pekerjaan Belum Diisi !";
		if($err == ''){
			$prog = explode(".", $prog);
			$bknya = $prog[0];
			$cknya = $prog[1];
			$dknya = $prog[2];
			$prog = $prog[3];
		}
	 }else{
	 	$prog='';
		$bknya = '';
		$cknya = '';
		$dknya = '';
		$kegiatan='';
		$pekerjaan='';
	 }
	 
	 
	 // CEK ATRIBUSI
	 if($err == ''){
		$hit_data = $DataPengaturan->QryHitungData($pemasukan_saja->TblName_atr_det,"WHERE refid_atribusi = '$pemasukan_atribusi_idplh' AND status='0' ");$cek.=$hit_data["cek"];
		if($hit_data["hasil"] < 1){
			$err = "Tidak Ada Rekening Belanja Atribusi, Data Atribusi Akan Di Hapus ?";
	 		$content = "1";
		}
	 }	 
								
		if($err==''){
			$data_rnc = array(array("sttemp", "0"));
			$where_upd = " refid_atribusi='$pemasukan_atribusi_idplh' ";
			//UPDATE t_atribusi_rincian
			array_push($data_rnc, array("status", "0"));
			$qryUpd_rinAtr = $DataPengaturan->QryUpdData("t_atribusi_rincian", $data_rnc, "WHERE status ='0' AND $where_upd ");
			//UPDATE t_atribusi_dokumen
			$qry_upd_dokSum = $DataPengaturan->QryUpdData("t_atribusi_dokumen", $data_rnc, "WHERE status !='2' AND $where_upd ");
			
			//DELETE t_atribusi_rincian
			$qry_del_rinAtr = "DELETE FROM t_atribusi_rincian WHERE $where_upd AND status !='0' ";
			$aqry_del_rinAtr = mysql_query($qry_del_rinAtr);			
			//DELETE t_atribusi_dokumen
			$qry_del_Dok = "DELETE FROM t_atribusi_dokumen WHERE $where_upd AND status ='2' ";
			$aqry_del_Dok = mysql_query($qry_del_Dok);
			
			if($refid_terima == ''){
				$ins_penerimaan = "INSERT INTO t_penerimaan_barang (c1,c,d,e,e1,jns_trans,uid,sttemp, biayaatribusi, bk, ck, dk, p, q, tahun) values ('$c1', '$c', '$d', '$e', '$e1', '$jns_transaksi', '$uid','0','1', '$bknya', '$cknya', '$dknya', '$prog', '$kegiatan', '$thn_anggaran')";$cek.=" | ".$ins_penerimaan;
				$qry_ins_penerimaan = mysql_query($ins_penerimaan);
				
				$tmpl_penerimaan = "SELECT Id FROM t_penerimaan_barang WHERE c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' AND jns_trans='$jns_transaksi' AND uid='$uid' AND sttemp='0' ORDER BY Id DESC ";$cek.=" | ".$tmpl_penerimaan;
				
				$qry_tmpl_penerimaan = mysql_query($tmpl_penerimaan);
				$daqry_penerimaan = mysql_fetch_array($qry_tmpl_penerimaan);
				$refid_terima=$daqry_penerimaan['Id'];
			}
			
			//UPDATE t_atribusi
			$data_upd_Atr = array(
								array("pencairan_dana", $pencairan_dana),
								array("sumber_dana", $sumberdana),
								array("cara_bayar", $cara_bayar),
								array("pelaksana", $pelaksana),
								array("status_barang", $stat_barang),
								array("dokumen_sumber", $dokumen_sumber),
								array("tgl_sp2d", $tgl_dokumen_bast),
								array("no_sp2d", $nomor_dokumen_bast),
								array("refid_terima", $refid_terima),
								array("uid", $uid),
								array("tahun", $thn_anggaran),
								array("refid_penyedia", $penyedian),
								array("sttemp", '0'),
							);
			$aqry_upd_Atr = $DataPengaturan->QryUpdData("t_atribusi", $data_upd_Atr, "WHERE Id='$pemasukan_atribusi_idplh' ");$cek.=$aqry_upd_Atr['cek'];
			
			//UPDATE t_atribusi_rincian lagi
			$qry_upd_rinAtr1 = "UPDATE t_atribusi_rincian SET refid_terima='$refid_terima', refid_dokumen_atribusi_fix=refid_dokumen_atribusi WHERE status ='0' AND refid_atribusi='$pemasukan_atribusi_idplh' AND sttemp='0' ";$cek.=' | '.$qry_upd_rinAtr1;
			$aqry_upd_rinAtr1 = mysql_query($qry_upd_rinAtr1);
			
			// SET HARGA BARU UPDATE 9-10-2017 -------------------------------------------------------------------
			$cek.=$pemasukan_saja->GetHargaBarangDanAttr($refid_terima);
			
			//HAPUS DATA t_penerimaan_barang Jika refid_terima berbeda dengan sebelumnya
			$refid_terima_sebelumnya = $_REQUEST['refid_terima_sebelumnya'];
			
			if($refid_terima_sebelumnya != $refid_terima){
				$hapus_penerimaan = "DELETE FROM t_penerimaan_barang WHERE Id='$refid_terima_sebelumnya' ";
				$qry_hapus_penerimaan = mysql_query($hapus_penerimaan);
			}
			
		}
		
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
		
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function set_selector_other($tipe){
	 global $Main,$HTTP_COOKIE_VARS;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	  
	  switch($tipe){	
		case 'formBaru'					: $fm = $this->setFormBaru();break;
		case 'formEdit'					: $fm = $this->setFormEdit();break;
		case 'SimpanSemua'				: $fm = $this->SimpanSemua();break;
		case 'SimpanSemua_HapusData'	: $fm = $this->SimpanSemua_HapusData();break;
		case 'BatalSemua'				: $fm = $this->BatalSemua();break;
		
		case 'tabelRekening'			: $fm = $this->Option_tabelRekening();break;
		case 'InsertRekening'			: $fm = $this->Option_InsertRekening();break;
		case 'updKodeRek'				: $fm = $this->Option_updKodeRek();break;
		case 'jadiinput'				: $fm = $this->Option_jadiinput();break;
		case 'namarekening'				: $fm = $this->Option_namarekening();break;
		case 'HapusRekening'			: $fm = $this->Option_HapusRekening();break;
		
		case 'formBaruPenyedia'			: $fm = $this->setformBaruPenyedia();break;
		case 'simpanPenyedia'			: $fm = $this->simpanPenyedia();break;
		case 'formBaruDokumen'			: $fm = $this->SetformBaruDokumen();break;
		case 'formUbahDokumen'			: $fm = $this->SetformUbahDokumen();break;
		case 'SimpanDokumen'			: $fm = $this->SimpanDokumen();break;
		case 'GetDokumenAtribusi'		: $fm = $this->GetDokumenAtribusi();break;
		case 'HapusDokumen'				: $fm = $this->HapusDokumen();break;
		
		 default:{
				$other = $this->set_selector_other2($tipe);
				$cek = $other['cek'];
				$err = $other['err'];
				$content=$other['content'];
				$json=$other['json'];
		 break;
		 }
	 }//end switch
		if($json && isset($fm)){
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];	
		 }
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }
   
   function setPage_OtherScript(){
   		global $DataPengaturan;
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							setTimeout(function myFunction() {".$this->Prefix.".loading()},100);					
						});
					</script>";
		return 	
			fn_TagScript("js/pencarian/DataPengaturan.js").
			fn_TagScript("js/pengadaanpenerimaan/pemasukan_ins.js").
			fn_TagScript("js/pengadaanpenerimaan/".strtolower($this->Prefix).".js").
			fn_TagScript("js/skpd.js").
			fn_TagScript("js/pencarian/cariRekening.js").
			fn_TagScript("js/pencarian/cariprogram.js").
			fn_TagScript("js/pencarian/cariIdPenerima.js").
			$DataPengaturan->Gen_Script_DatePicker().
			$scriptload;
	}
	
	function setPage_Content(){
		global $DataPengaturan;
		$YN = cekPOST2("YN");
		
		$dskrp = "pemasukanSKPD";
		$c1 = $YN == "1"?cekPOST2($dskrp."2fmURUSAN","0"):"";
		$c = $YN == "1"?cekPOST2($dskrp."2fmSKPD",'01'):"";
		$d = $YN == "1"?cekPOST2($dskrp."2fmUNIT",'01'):"";
		$e = $YN == "1"?cekPOST2($dskrp."2fmSUBUNIT",'01'):"";
		$e1 = $YN == "1"?cekPOST2($dskrp."2fmSEKSI",'001'):"";
		$jns_trans = cekPOST2("halmannya");
		
		$Id=$_REQUEST["pemasukan_cb"];
		
		$data = InputTypeHidden($dskrp."fmUrusan",$c1).
				InputTypeHidden($dskrp."fmSKPD",$c).
				InputTypeHidden($dskrp."fmUNIT",$d).
				InputTypeHidden($dskrp."fmSUBUNIT",$e).
				InputTypeHidden($dskrp."fmSEKSI",$e1).
				InputTypeHidden("pil_jns_trans",$jns_trans).
				InputTypeHidden("databaru",$YN).
				InputTypeHidden("idubah",$Id[0]);
		
		return $data.$this->genDaftarInitial();
		
	}
	
	//form ==================================
	function setFormBaru(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
   
  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;				
		//get data 
		$a = "SELECT count(*) as cnt, aa.satuan_terbesar, aa.satuan_terkecil, bb.nama, aa.f, aa.g, aa.h, aa.i, aa.j FROM ref_barang aa INNER JOIN ref_satuan bb ON aa.satuan_terbesar = bb.nama OR aa.satuan_terkecil = bb.nama WHERE bb.nama='".$this->form_idplh."' "; $cek .= $a;
		$aq = mysql_query($a);
		$cnt = mysql_fetch_array($aq);
		
		if($cnt['cnt'] > 0) $err = "Satuan Tidak Bisa Diubah ! Sudah Digunakan Di Ref Barang.";
		if($err == ''){
			$aqry = "SELECT * FROM  ref_satuan WHERE nama='".$this->form_idplh."' "; $cek.=$aqry;
			$dt = mysql_fetch_array(mysql_query($aqry));
			$fm = $this->setForm($dt);
		}
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 300;
	 $this->form_height = 50;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
		$nip	 = '';
	  }else{
		$this->form_caption = 'Edit';			
		$Id = $dt['nama'];			
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			'nama' => array( 
						'label'=>'Satuan',
						'labelWidth'=>100, 
						'value'=>$dt['nama'], 
						'type'=>'text',
						'param'=>"style='width:200px;'"
						 ),			
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setPage_HeaderOther(){
	return 
			"";
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox		
	   <th class='th01' width='900'>Satuan</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$isi['nama']);
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main, $HTTP_COOKIE_VARS, $DataPengaturan,$pemasukan_saja,$DataOption;
	 	 
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 if(isset($_REQUEST['databaru'])){
 		$baru = TRUE;
		$databaru=cekPOST2("databaru");
		$idubah=cekPOST2("idubah");
		
		if($databaru == '1' && $idubah == ''){
			$baru = TRUE;
			$baru_IdTerima = "";
			$baru_IdTerima_Val = "";
			$AND_IdTerima = "";
			$dskrp = "pemasukanSKPDfm";
			$c1 = cekPOST2($dskrp.'Urusan');
		 	$c = cekPOST2($dskrp.'SKPD');
		 	$d = cekPOST2($dskrp.'UNIT');
		 	$e = cekPOST2($dskrp.'SUBUNIT');
		 	$e1 = cekPOST2($dskrp.'SEKSI');			
		}else{			
			$hitung_atr = $DataPengaturan->QryHitungData($pemasukan_saja->TblName_atr,"WHERE refid_terima='$idubah' ");	
			if($hitung_atr["hasil"] == 0){
				$baru_IdTerima = ", refid_terima, bk,ck,dk,p,q";
				$baru_IdTerima_Val = ", '$id_ubahnya'";
				$AND_IdTerima = " refid_terima='$id_ubahnya' ";
				
				$qry_terima = $DataPengaturan->QyrTmpl1Brs($pemasukan_saja->TblName, "*", "WHERE Id='$idubah' ");
				$dt_terima = $qry_terima["hasil"];				
				
				$c1 = $dt_terima['c1'];
				$c = $dt_terima['c'];
				$d = $dt_terima['d'];
				$e = $dt_terima['e'];
				$e1 = $dt_terima['e1'];					
				
				$data_insAtr = 
					array(
						array("bk",$dt_terima["bk"]),array("ck",$dt_terima["ck"]),array("dk",$dt_terima["dk"]),
						array("p",$dt_terima["p"]),array("q",$dt_terima["q"]),
						array("pekerjaan",$dt_terima["pekerjaan"]),
						array("refid_terima",$dt_terima["Id"]),
					);				
			}else{
				$baru = FALSE;
				$data_insAtr = array();
			}
		}				
				
		if($baru == TRUE){		
			$data_ins = 
				array(
					array("c1",$c1),array("c",$c),array("d",$d),array("e",$e),array("e1",$e1),
					array("sttemp","1"),array("uid",$uid),
				);
			if(count($data_insAtr) > 0)$data_ins = array_merge($data_ins, $data_insAtr);
			$qry_InsAtr = $DataPengaturan->QryInsData($pemasukan_saja->TblName_atr, $data_ins);
			$cek.=$qry_InsAtr["cek"];
			$qry_tmpl = $DataPengaturan->QyrTmpl1Brs2($pemasukan_saja->TblName_atr, "*", $data_ins, "ORDER BY Id ");	 
			$dt1 = $qry_tmpl["hasil"];
			$cek.=" | ".$qry_tmpl["cek"];
			$dt['Id'] = $dt1['Id'];			 		
		}
		
		if($idubah != ''){
			$qry_tmpl = "SELECT a.*, b.id_penerimaan FROM t_atribusi a INNER JOIN t_penerimaan_barang b ON a.refid_terima = b.Id WHERE refid_terima='$idubah'";$cek.=" | ".$qry_tmpl;
			$aqry_tmpl = mysql_query($qry_tmpl);
			
			$dt = mysql_fetch_array($aqry_tmpl);
						
			 $jns_transaksi = $dt['jns_trans'];
			 $pencairan_dana= $dt['pencairan_dana'];
			 $sumberdana = $dt['sumber_dana'];
			 $cara_bayar = $dt['cara_bayar'];
			 $stat_barang = $dt['status_barang'];
			
			
			//p,q
			$prog = $dt['bk'].".".$dt['ck'].".".$dt['dk'].".".$dt['p'];
			$p= $dt['p'];
			$bknya = $dt['bk'];
			$cknya = $dt['ck'];
			$dknya = $dt['dk'];

			$cariprogmnya = "SELECT *, concat (IF(LENGTH(bk)=1,concat('0',bk), bk),'.', IF(LENGTH(ck)=1,concat('0',ck), ck),'.', IF(LENGTH(dk)=1,concat('0',dk), dk),'.', IF(LENGTH(p)=1,concat('0',p), p),'. ', nama) as v2_nama FROM ref_program WHERE bk='$bknya' AND ck='$cknya' AND dk='$dknya' AND p='$p' AND q='0' ";$cek.=$cariprogmnya;
			$qrycariprogmnya = mysql_fetch_array(mysql_query($cariprogmnya));
			
			$programnya = $qrycariprogmnya['v2_nama'];
						
			$kegiatanDSBL ='';
			$qrykegitan = "SELECT q,concat (IF(LENGTH(q)=1,concat('0',q), q),'. ',nama) as nama FROM ref_program WHERE bk='$bknya' AND ck='$cknya' AND dk='$dknya' AND p='$p' AND q!='0'";
			$kegiatan=$dt['q'];
			
			//PEKERJAAN
			$pekerjaan = $dt['pekerjaan'];	
			
					
			//NO DOKUMEN 			 
			 $dokumen_sumber = $dt['dokumen_sumber'];
			 $tgl_dokumen_bast = explode("-",$dt['tgl_sp2d']);
			 $tgl_dokumen_bast = $tgl_dokumen_bast[2]."-".$tgl_dokumen_bast[1]."-".$tgl_dokumen_bast[0];
			 $nomor_dokumen_bast =  $dt['no_sp2d'];
			 $penyedia =  $dt['refid_penyedia'];
			 $pelaksana =  $dt['pelaksana'];
			 
			 
			 $id_penerimaan = $dt['id_penerimaan'];
			 
			 $disableIpPenerimaan = 'disabled';
			 if($dt['id_penerimaan'] =='')$disableIpPenerimaan='';
			 
			 
			 $refid_terimanya=$id;
			 
			 $bacasaja ='readonly';
			 $disableCariPenerimaan = 'disabled';
			 $disableProgram = 'disabled';
			 $refid_terimanya=$_REQUEST['idubah'];
			 
			 
			 $c1 = $dt['c1'];
			 $c = $dt['c'];
			 $d = $dt['d'];
			 $e = $dt['e'];
			 $e1 = $dt['e1'];
		}else{
			 $id_penerimaan = $dt1['id_penerimaan'];
			 
			 $disableIpPenerimaan = 'disabled';
			 $refid_terimanya=$_REQUEST['idubah'];			
			
			 $jns_transaksi = $_REQUEST['pil_jns_trans'];
			 $pencairan_dana='3';
			 $sumberdana = "APBD";
			 $cara_bayar = '3';
			 $stat_barang = '1';
			 $dokumen_sumber = 'SP2D';
			 $tgl_dokumen_bast = date('d-m-Y');
			 $nomor_dokumen_bast = '';
			 $disableCariPenerimaan = '';
			 $penyedia =  "";
			 $pelaksana = "2";
			 
			 $kegiatanDSBL ='disabled';
			 $bacasaja='';
			 $disableProgram = '';
			 $c1 = $_REQUEST['pemasukanSKPDfmUrusan'];
			 $c = $_REQUEST['pemasukanSKPDfmSKPD'];
			 $d = $_REQUEST['pemasukanSKPDfmUNIT'];
			 $e = $_REQUEST['pemasukanSKPDfmSUBUNIT'];
			 $e1 = $_REQUEST['pemasukanSKPDfmSEKSI'];
		}
	 }
	 
	 // CEK DEFAULT FORM ----------------------------------------------------------------------------------
	  		if($pencairan_dana == "" || $pencairan_dana == null)$pencairan_dana='3';
			 if($sumberdana == "" || $sumberdana == null)$sumberdana = "APBD";
			 if($cara_bayar == "" || $cara_bayar == null)$cara_bayar = '3';
			 if($stat_barang == "" || $stat_barang == null)$stat_barang = '1';
			 if($dokumen_sumber == "" || $dokumen_sumber == null)$dokumen_sumber = 'SP2D';
			 if($tgl_dokumen_bast == "" || $tgl_dokumen_bast == null || $tgl_dokumen_bast =="--")$tgl_dokumen_bast = date('d-m-Y');
			 if($pelaksana == "" || $pelaksana == null)$pelaksana = "2";
	 //------------------------------------------------------------------------------------------------------
	 
	if(!isset($qrykegitan))$qrykegitan = "SELECT q,nama_program_kegiatan FROM ref_programkegiatan WHERE p='00' AND q='00'"; 
	$qrysumber_dn = "SELECT nama,nama FROM ref_sumber_dana";$cek.=$qrysumber_dn;
	$qrypenyedia = "SELECT id,nama_penyedia FROM ref_penyedia WHERE c1= '$c1' AND c='$c' AND d='$d'";
	$qrypenerima = "SELECT Id,nama FROM ref_tandatangan WHERE c1= '$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1'";$cek.=$qrypenerima;
	$qry_dokumen_sumber = "SELECT nama_dokumen,nama_dokumen FROM ref_dokumensumber ";
	$pil_jns_tran = "<select style='width:300px;' onchange='pemasukan_ins.inputpenerimaan()' id='jns_transaksi' name='jns_transaksi'>";
	if($jns_transaksi == 1){
		$pil_jns_tran.="<option selected value='1'>ATRIBUSI PENGADAAN BARANG</option></select>";
	}else{
		$pil_jns_tran.="<option selected value='2'>ATRIBUSI PEMELIHARAAN BARANG</option></select>";
	}
	
	$qry_Dok_atribusi = "SELECT Id, nomor_dok FROM t_atribusi_dokumen WHERE refid_atribusi='".$dt['Id']."' AND status !='2'";
	$DokPil = $DataPengaturan->QyrTmpl1Brs("t_atribusi_dokumen", "Id", "WHERE refid_atribusi='".$dt['Id']."' AND status !='2'");
	$dt_DokPil = $DokPil["hasil"];		
	$TampilOpt =			
			$vOrder=
			$DataPengaturan->GenViewHiddenSKPD($c1, $c, $d, $e, $e1).
			$DataPengaturan->GenViewSKPD($c1, $c, $d, $e, $e1).
				genFilterBar(
				array(
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>'TRANSAKSI',
								'label-width'=>'200px;',
								'value'=>$pil_jns_tran,	
							),							
							array(
								'label'=>'MEKANISME PENCAIRAN DANA',
								'value'=>cmbArray('pencairan_dana',$pencairan_dana,$DataPengaturan->arr_pencairan_dana,"--- PILIH MEKANISME PENCAIRAN DANA ---", "style='width:300px;'"),
							),
							array(
								'label'=>'SUMBER DANA',
								'value'=>cmbQuery('sumberdana',$sumberdana,$qrysumber_dn, "style='width:300px;' ","--- PILIH SUMBER DANA ---"),
							),
							array(
								'label'=>'JENIS PEMBAYARAN',
								'value'=>cmbArray('cara_bayar',$cara_bayar,$DataPengaturan->arr_cara_bayar,"--- PILIH JENIS TRANSAKSI ---", "style='width:150px;'"),
							),
							array(
								'label'=>'PELAKSANA',
								'value'=>cmbArray('pelaksana',$pelaksana,$DataPengaturan->arr_metode_pengad,"--- PELAKSANA ---", "style='width:150px;' onchange='".$this->Prefix.".PilPelakasana()'"),
							),
							array(
								'label'=>'PENYEDIA BARANG',
								'value'=>"<span id='det_dafpenyedia'><span id='dafpenyedia'>".cmbQuery('penyedian',$penyedia,$qrypenyedia," style='width:300px;' ",'--- PILIH PENYEDIA BARANG ---')."</span> ".
										"<input type='button' id='BaruPenyedia' name='BaruPenyedia' value='BARU' onclick='pemasukan_atribusi.BaruPenyedia()' /></span>"
								,
							),
							array(
								'label'=>'BARANG SUDAH DITERIMA ?',
								'value'=>cmbArray('stat_barang',$stat_barang,$this->stat_barang,"--- PILIH ---", "style='width:150px;' onchange='".$this->Prefix.".konfBarang();'"),
							),
							array(
								'label'=>'ID PENERIMAAN',
								'value'=>
									InputTypeText("id_penerimaan",$id_penerimaan,"readonly style='width:300px;'")." ".
									InputTypeButton("cariIdPenerimaan","CARI"," $disableCariPenerimaan onclick='".$this->Prefix.".CariIdPenerimaan()'"),
							),
							array(
								'label'=>'PROGRAM',
								'name'=>'program',
								'value'=>
									InputTypeText("program",$programnya,"style='width:500px;' readonly")." ".
									InputTypeButton("progcar","CARI"," $disableProgram onclick='pemasukan_atribusi.CariProgram()'").
									InputTypeHidden("prog",$prog),
							),
							array(
								'label'=>'KEGIATAN',
								'name'=>'kegiatan',
								'value'=>
									LabelDiv1("id='dafkeg'",
										cmbQuery('kegiatan1',$kegiatan,$qrykegitan,"$kegiatanDSBL style='width:500px;' onchange='document.getElementById(`kegiatan`).value=this.value;' $disableIpPenerimaan",'--- PILIH KEGIATAN ---').
										InputTypeHidden("kegiatan",$kegiatan)
									),
							),
							array(
								'label'=>'PEKERJAAN',
								'value'=>
									InputTypeText("pekerjaan",$pekerjaan,"style='width:500px;' placeholder='PEKERJAAN' $bacasaja"),
							),
							array(
								'label'=>'DOKUMEN',
								'value'=>
									LabelSPan1("Pil_Dokumen",
										cmbQuery('dokumen_atribusi',$dt_DokPil["Id"],$qry_Dok_atribusi," style='width:300px;' onchange='pemasukan_atribusi.GetDokumenAtribusi()' ",'--- PILIH DOKUMEN ---')
									)." ".
									InputTypeButton("BaruDok","BARU","onclick='pemasukan_atribusi.BaruDokumen()' /> <span id='OPTDokumen'").
									LabelSPan1("OPTDokumen",""),
							),
							array(
								'label'=>'DOKUMEN SUMBER',
								'value'=>
								InputTypeText("dokumensumber","","style='width:353px;' placeholder='DOKUMEN SUMBER' readonly"),
							),	
							array(
								'label'=>'TANGGAL DAN NOMOR',
								'value'=>
									InputTypeText("tgl_dokumen_bast","","style='width:80px;' readonly placeholder='TANGGAL'")." ".
									InputTypeText("nomor_dokumen_bast","","style='width:270px;' readonly placeholder='NOMOR DOKUMEN'"),						
							),
						)
					)
				
				),'','','').
				genFilterBar(
					array(
						LabelSPan1("inputpenerimaanbarang","INPUT KODE REKENING BELANJA ATRIBUSI","style='color:black;font-size:14px;font-weight:bold;'"),
					)
				,'','','').
				InputTypeHidden("jns_dari_rek","2").
				LabelDiv1("id='tbl_rekening' style='width:100%;'","").
				genFilterBar(
				array(
					
					"<table>
						<tr>							
							<td><span id='selesaisesuai'>".$DataPengaturan->buttonnya($this->Prefix.'.SimpanSemua()','save_f2.png','SIMPAN','SIMPAN','SIMPAN')."</span></td>
							<td>".$DataPengaturan->buttonnya($this->Prefix.'.BatalSemua()','cancel_f2.png','BATAL','BATAL','BATAL')."</td>
						</tr>".
					"</table>"
					
				
				),'','','').
				genFilterBar(
					array(
						InputTypeHidden($this->Prefix."_idplh",$dt['Id']).
						InputTypeHidden("refid_terima",$refid_terimanya).
						InputTypeHidden("refid_terima_sebelumnya",$refid_terimanya)
					)
				,'','','')
							;
			
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn
		$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];			
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
		//Cari 
		switch($fmPILCARI){			
			case 'selectSatuan': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;						 	
		}
		if(!empty($fmFiltTglBtw_tgl1)) $arrKondisi[]= " tgl_daftar>='$fmFiltTglBtw_tgl1'";
		if(!empty($fmFiltTglBtw_tgl2)) $arrKondisi[]= " tgl_daftar<='$fmFiltTglBtw_tgl2'";	
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " nama $Asc1 " ;break;
		}	
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//$Order ="";
		//limit --------------------------------------
		/**$HalDefault=cekPOST($this->Prefix.'_hal',1);	//Cat:Settingan Lama				
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		**/
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	
	function Hapus($ids){ //validasi hapus ref_kota
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++)	{
		
			$a = "SELECT count(*) as cnt, aa.satuan_terbesar, aa.satuan_terkecil, bb.nama, aa.f, aa.g, aa.h, aa.i, aa.j FROM ref_barang aa INNER JOIN ref_satuan bb ON aa.satuan_terbesar = bb.nama OR aa.satuan_terkecil = bb.nama WHERE bb.nama='".$ids[$i]."' "; $cek .= $a;
		$aq = mysql_query($a);
		$cnt = mysql_fetch_array($aq);
		
		if($cnt['cnt'] > 0) $err = "Satuan ".$ids[$i]." Tidak Bisa DiHapus ! Sudah Digunakan Di Ref Barang.";
		
			if($err=='' ){
					$qy = "DELETE FROM $this->TblName_Hapus WHERE nama='".$ids[$i]."' ";$cek.=$qy;
					$qry = mysql_query($qy);
						
			}else{
				break;
			}			
		}
		return array('err'=>$err,'cek'=>$cek);
	}
	
	function tabelRekening(){
		global $DataPengaturan;
			
		$cek = '';
		$err = '';
		$jml_harga=0;
		$datanya='';
		
		$where2 = '';
		$dokumen_atribusi = cekPOST("dokumen_atribusi");
		$where2="AND refid_dokumen_atribusi='$dokumen_atribusi' ";
				
		$refid_terima = addslashes($_REQUEST[$this->Prefix."_idplh"]);
		$qry = "SELECT a.*,b.nm_rekening FROM v1_atribusi_rincian a LEFT JOIN ref_rekening b ON a.k=b.k AND a.l=b.l AND a.m=b.m AND a.n=b.n AND a.o=b.o WHERE a.refid_atribusi = '$refid_terima' AND status != '2' $where2 ORDER BY Id DESC";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		while($dt = mysql_fetch_array($aqry)){
			if($dt['status'] == '0'){
				$kode = "
					<a href='javascript:".$this->Prefix.".jadiinput(`".$dt['Id']."`,`".$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o']."`);' />
						".$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o']."
					</a>
					";
				
				$idrek = '';
				
				$jumlahnya = number_format($dt['jumlah'],2,",",".");
				$btn ="
				<a href='javascript:".$this->Prefix.".HapusRekening(`".$dt['Id']."`)' />
					<img src='datepicker/remove2.png' style='width:20px;height:20px;' />
				</a>";
				
				
			}
			
			if($dt['status'] == '1'){
			// DENGAN INPUTAN TEXT
				$kode = "<input type='text' onkeyup='setTimeout(function myFunction() {".$this->Prefix.".namarekening();},100);' name='koderek' id='koderek' value='".$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o']."' style='width:80px;' maxlength='11' />"
				."<a href='javascript:cariRekening.windowShow(".$dt['Id'].");'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>"
				;
						 
				$idrek = "<input type='hidden' name='idrek' id='idrek' value='".$dt['Id']."' />".
						"<input type='hidden' name='statidrek' id='statidrek' value='".$dt['status']."' />";
				
				$jumlahnya = "
					
							<input type='text' name='jumlahharga' id='jumlahharga' value='".intval($dt['jumlah'])."' style='text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = ".$this->Prefix.".formatCurrency(this.value);' />
							<span id='formatjumlah'></span>
							
						";
				
				$btn ="
						<a href='javascript:".$this->Prefix.".updKodeRek()' />
							<img src='datepicker/save.png' style='width:20px;height:20px;' />
						</a>
						";
			}
			
			$datanya.="
				<tr class='row0'>
					<td class='GarisDaftar' align='right'>$no</td>
					<td class='GarisDaftar' align='center'>
						<span id='koderekeningnya_".$dt['Id']."' >
							$kode $idrek
						</span>
					</td>
					<td class='GarisDaftar'>
						<span id='namaakun_".$dt['Id']."'>".$dt['nm_rekening']."</span>
					</td>
					<td class='GarisDaftar' align='right'>
						<span id='jumlanya_".$dt['Id']."'>$jumlahnya</span>
					</td>
					<td class='GarisDaftar' align='center'>
						<span id='option_".$dt['Id']."'>$btn</span>
					</td>
				</tr>
			";
			$no = $no+1;
			$jml_harga = $jml_harga+intval($dt['jumlah']);
		}
		
						
					
		$content['tabel'] =
			genFilterBar(
				array("
					<table class='koptable' style='min-width:780px;' border='1'>
						<tr>
							<th class='th01'>NO</th>
							<th class='th01' width='50px'>KODE REKENING</th>
							<th class='th01'>NAMA REKENING BELANJA</th>
							<th class='th01'>JUMLAH (Rp)</th>
							<th class='th01'>
								<span id='atasbutton'>
								<a href='javascript:".$this->Prefix.".BaruRekening()' /><img src='datepicker/add-256.png' style='width:20px;height:20px;' /></a>
								</span>
							</th>
						</tr>
						$datanya
						
					</table>"
				)
			,'','','')
		;
		$content['jumlah'] = 
				$DataPengaturan->isiform(
						array(
								array(
									'label'=>'TOTAL BELANJA',
									'label-width'=>'200px;',
									'name'=>'totalbelanja',
									'value'=>"<input type='text' name='totalbelanja' id='totalbelanja' value='".number_format($jml_harga,2,",",".")."' style='width:150px;text-align:right' readonly /><span id='jumlahsudahsesuai'><input type='checkbox' name='jumlah_sesuai' value='1' id='jumlah_sesuai' style='margin-left:20px;' disabled /><span style='font-weight:bold;color:red;'>TOTAL HARGA SESUAI</span></span>",
									
								),
						)
				);
		$content['atasbutton'] = "<a href='javascript:".$this->Prefix.".tabelRekening()' /><img src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>";
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function BatalSemua(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 	 
	 	$qry = "SELECT * FROM t_atribusi WHERE Id='$idplh'";$cek.=$qry;
		$aqry = mysql_query($qry);
		$daqry = mysql_fetch_array($aqry);
		//$err="dgdfg";
		if($err == ""){			
			if($daqry['sttemp'] == '1'){
				$whereAttr = "WHERE refid_atribusi='".$daqry['Id']."' ";
								
				//Atribusi Detail -----------------------------------------------------------------------------------
				$hapusatribusi_det = "DELETE FROM t_atribusi_rincian $whereAttr"; $cek.="| ".$hapusatribusi_det;
				$qry_hapusatribusi_det = mysql_query($hapusatribusi_det);
				
				//Hapus Dokumen Atribusi ---------------------------------------------------------------------------
				$del_DokAttr = "DELETE FROM t_atribusi_dokumen $whereAttr";
				$qry_del_DokAttr = mysql_query($del_DokAttr);
							
				//Penerimaan ------------------------------------------------------------------------------------------
				$hapus_atribusi = "DELETE FROM t_atribusi WHERE Id='".$daqry['Id']."'"; $cek.="| ".$hapus_penerimaan;		
				$qry_hapus_penerimaan = mysql_query($hapus_penerimaan);
			}else{
				$whereAttr2 = "WHERE refid_atribusi='".$daqry['Id']."' AND sttemp='1'";
				$fmWhereAttr = "WHERE refid_atribusi='".$daqry['Id']."' AND sttemp='0' ";
				//Atribusi Detail -----------------------------------------------------------------------------------
				$hapuspenerimaan_det = "DELETE FROM t_atribusi_rincian $whereAttr2"; $cek.="| ".$hapuspenerimaan_det;
				$qry_hapuspenerimaan_det = mysql_query($hapuspenerimaan_det);
				
				$updpenerimaan_det =  "UPDATE t_atribusi_rincian SET status='0', refid_dokumen_atribusi=refid_dokumen_atribusi_fix $fmWhereAttr"; $cek.='| '.$updpenerimaan_det;			
				$qry_updpenerimaan_det = mysql_query($updpenerimaan_det);
				
				//Dokumen Atribusi ----------------------------------------------------------------------------------
				$hps_AtrDok = "DELETE FROM t_atribusi_dokumen $whereAttr2";
				$qry_hps_AtrDok = mysql_query($hps_AtrDok);
				
				$upd_AtrDok = "UPDATE t_atribusi_dokumen SET status='0' $fmWhereAttr";
				$qry_AtrDok = mysql_query($upd_AtrDok);
			}
		}
		
		
	  
						
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function setformBaruPenyedia(){
		global $Ref, $Main, $HTTP_COOKIE_VARS;
		$dt=array();
		$cek = '';$err='';
		
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		 //set waktu sekarang
		
		$dt['tgl'] = date("d-m-Y");
		$dt['c1'] = $_REQUEST['c1nya'];
		$dt['c'] = $_REQUEST['cnya'];
		$dt['d'] = $_REQUEST['dnya'];
		$dt['idweh'] = $_REQUEST['pemasukan_ins_idplh'];
		
		if($err == '')$fm = $this->setFormPenyedia($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormPenyedia($dt){	
	 global $SensusTmp, $Ref, $Main, $HTTP_COOKIE_VARS;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 470;
	 $this->form_height = 300;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU PENYEDIA BARANG';
		$nip	 = '';
	  }else{
		$this->form_caption = 'UBAH DOKUMEN SUMBER';			
		$Id = $dt['Id'];			
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			'namapenyedia' => array( 
						'label'=>'NAMA PENYEDIA',
						'labelWidth'=>150, 
						'value'=>"", 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='NAMA PENYEDIA'"
						 ),
			'alamatpenyedia' => array( 
						'label'=>'ALAMAT LENGKAP',
						'labelWidth'=>150, 
						'value'=>"<textarea name='alamatpenyedia' id='alamatpenyedia' style='width:270px;height:50px;' placeholder='ALAMAT LENGKAP'></textarea>",
						 ),
			'kotapenyedia' => array( 
						'label'=>'KOTA / KABUPATEN',
						'labelWidth'=>150, 
						'value'=>"", 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='KOTA / KABUPATEN'"
						 ),
			'namapimpinan' => array( 
						'label'=>'NAMA PIMPINAN',
						'labelWidth'=>150, 
						'value'=>"", 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='NAMA PIMPINAN'"
						 ),
			'nonpwp' => array( 
						'label'=>'NO NPWP',
						'labelWidth'=>150, 
						'value'=>"", 
						'type'=>'text',
						'param'=>"style='width:270px;' maxlength='25' placeholder='NO NPWP'"
						 ),
			'norekeningbank' => array( 
						'label'=>'NO REKENING BANK',
						'labelWidth'=>150, 
						'value'=>"", 
						'type'=>'text',
						'param'=>"style='width:270px;' maxlength='30' placeholder='NO REKENING BANK'"
						 ),
			'namabank' => array( 
						'label'=>'NAMA BANK',
						'labelWidth'=>150, 
						'value'=>"", 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='NAMA BANK'"
						 ),
			'atasnamabank' => array( 
						'label'=>'ATAS NAMA BANK',
						'labelWidth'=>150, 
						'value'=>"", 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='ATAS NAMA BANK'"
						 ),
			);
		//tombol
		$this->form_menubawah =
			/*"<input type='text' name='idweh' id='c1nya' value='".$dt['idweh']."' />".*/
			"<input type='hidden' name='c1nya' id='c1nya' value='".$dt['c1']."' />".
			"<input type='hidden' name='cnya' id='cnya' value='".$dt['c']."' />".
			"<input type='hidden' name='dnya' id='dnya' value='".$dt['d']."' />".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanPenyedia()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function simpanPenyedia(){
	 global $HTTP_COOKIE_VARS, $DataPengaturan;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 
	 $namapenyedia= $_REQUEST['namapenyedia'];
	 $alamatpenyedia= $_REQUEST['alamatpenyedia'];
	 $kotapenyedia= $_REQUEST['kotapenyedia'];
	 $namapimpinan= $_REQUEST['namapimpinan'];
	 $nonpwp= $_REQUEST['nonpwp'];
	 $norekeningbank= $_REQUEST['norekeningbank'];
	 $namabank= $_REQUEST['namabank'];
	 $atasnamabank= $_REQUEST['atasnamabank'];
	 $c1= $_REQUEST['c1nya'];
	 $c= $_REQUEST['cnya'];
	 $d= $_REQUEST['dnya'];
	 
	 	  
	 if( $err=='' && $namapenyedia =='' ) $err= 'Nama Penyedia Belum Di Isi !';
	 if( $err=='' && $nonpwp =='' ) $err= 'No NPWP Belum Di Isi ! Penyedia Belum Di Isi !!';
	 //CEK Di ref_tandatangan
	 if($err == ""){
	 	 $Qry_Cek = $DataPengaturan->QryHitungData("ref_penyedia","WHERE c1='$c1' AND c='$c' AND d='$d' AND no_npwp='$nonpwp' ");
		 if($Qry_Cek["hasil"] > 0)$err = "No NPWP Sudah Ada !";
	 }
	 
	 
	 if($fmST == 0){
		if($err==''){
			$aqry = "INSERT into ref_penyedia(c1,c,d,nama_penyedia,alamat,kota,nama_pimpinan,no_npwp,nama_bank,norek_bank,atasnama_bank)values('$c1','$c','$d', '$namapenyedia', '$alamatpenyedia', '$kotapenyedia', '$namapimpinan', '$nonpwp', '$namabank', '$norekeningbank', '$atasnamabank')";	$cek .= $aqry;	
			$qry = mysql_query($aqry);
			
			$dtidpenyedia = "SELECT id,nama_penyedia FROM ref_penyedia WHERE c1='$c1' AND c='$c' AND d='$d' AND nama_penyedia='$namapenyedia' ORDER BY id DESC";
			$qrdtidpenyedia = mysql_query($dtidpenyedia);
			$dtId = mysql_fetch_array($qrdtidpenyedia);
			
			$qrypenyedia = "SELECT id,nama_penyedia FROM ref_penyedia WHERE c1='$c1' AND c='$c' AND d='$d' ";
			
			
			$content['penyedian'] = cmbQuery('penyedian',$dtId['id'],$qrypenyedia," style='width:303px;' ","--- PILIH PENYEDIA BARANG ---");
		}
	 } //end else
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function setformBaruDokumen(){
		global $HTTP_COOKIE_VARS;
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$cek='';$err='';$content='';
		$this->form_fmST = 0;	
		$dt["refid_atribusi"] = cekPOST($this->Prefix."_idplh"); 
		
		$dt["jns_dok"] = "SP2D";
		$dt["tanggal_dok"] = date("d-m");
		$dt["tahun_dok"] = $coThnAnggaran;
		$dt["nomor_dok"] = "";
		$dt['refid_atribusi'] = cekPOST($this->Prefix."_idplh");
		if($err == ""){
			$fm = $this->setformDokumen($dt);
			$cek.=$fm['cek'];
			$err=$fm['err'];
			$content=$fm['content'];
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setformUbahDokumen(){
		global $DataPengaturan;
		$cek='';$err='';$content='';
		
		$dokumen_atribusi = cekPOST("dokumen_atribusi");
		$refid_atribusi = cekPOST($this->Prefix."_idplh");
		
		$this->form_fmST = 1;	
		$this->form_idplh = $dokumen_atribusi;
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_atribusi_dokumen", "*", "WHERE Id='$dokumen_atribusi' AND refid_atribusi='$refid_atribusi' AND status !='2'");
		$dt = $qry['hasil'];
		if($dt["Id"] == "" || $dt["Id"] == NULL)$err="Data Tidak Valid !";
		
		
		if($err == ""){
			$tgl_dok = explode("-", $dt["tanggal_dok"]);
			$dt["tanggal_dok"] = $tgl_dok[2]."-".$tgl_dok[1];
			$dt["tahun_dok"] = $tgl_dok[0];
			$fm = $this->setformDokumen($dt);
			$cek.=$fm['cek'];
			$err=$fm['err'];
			$content=$fm['content'];
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setformDokumen($dt){	
	 global $SensusTmp, $Ref, $Main, $HTTP_COOKIE_VARS;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 470;
	 $this->form_height = 100;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU DOKUMEN';
		$nip	 = '';
	  }else{
		$this->form_caption = 'UBAH DOKUMEN';			
		$Id = $dt['Id'];			
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		$qry_dokumen_sumber = "SELECT nama_dokumen,nama_dokumen FROM ref_dokumensumber ";
		
	 //items ----------------------
	  $this->form_fields = array(
			'jns_dok' => array( 
						'label'=>'DOKUMEN SUMBER',
						'labelWidth'=>150, 
						'value'=>cmbQuery('jns_dok',$dt["jns_dok"],$qry_dokumen_sumber," style='width:270px;' ",'--- PILIH DOKUMEN SUMBER ---'), 
						 ),
			'tanggal_dok' => array( 
						'label'=>'TANGGAL',
						'labelWidth'=>150, 
						'value'=>
							InputTypeText("tanggal_dok",$dt["tanggal_dok"]," placeholder='TANGGAL' class='datepicker2' style='width:40px;'")." ".
							InputTypeText("tahun_dok",$dt["tahun_dok"]," placeholder='TAHUN' readonly style='width:40px;'"),
						 ),
			'nomor_dok' => array( 
						'label'=>'NOMOR',
						'labelWidth'=>150, 
						'value'=>$dt["nomor_dok"], 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='NOMOR'"
						 ),
			);
		//tombol
		$this->form_menubawah =
			InputTypeHidden("refid_atribusi",$dt['refid_atribusi']).
			InputTypeButton("btn_smpn","SIMPAN", "onclick ='".$this->Prefix.".SimpanDokumen()'")." ".
			InputTypeButton("btn_btl","BATAL", "onclick ='".$this->Prefix.".Close()'");
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function SimpanDokumen(){
		global $DataPengaturan, $HTTP_COOKIE_VARS;
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$cek='';$err='';$content='';
		
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		
		$jns_dok = cekPOST("jns_dok");
		$tanggal_dok = cekPOST("tanggal_dok")."-".$coThnAnggaran;
		$nomor_dok = cekPOST("nomor_dok");
		$refid_atribusi = cekPOST("refid_atribusi");
		
		if($err=="" && $jns_dok == "")$err="Dokumen Sumber Belum Di Isi !";
		if($err=="" && $tanggal_dok == "")$err="Tanggal Dokumen Belum Di Isi !";
		if($err=="" && $nomor_dok == "")$err="Nomor Dokumen Belum Di Isi !";
		
		$tanggal_dok = explode("-",$tanggal_dok);
		$tanggal_dok = $tanggal_dok[2]."-".$tanggal_dok[1]."-".$tanggal_dok[0];
		if($err=='' && !cektanggal($tanggal_dok)) $err= 'Tanggal Dokumen Tidak Valid';
		
		
		
		//if($err=='')$err='fgd';
		
		if($err == ""){
			if($fmST != 0){
				$data_upd = array(array("status", "2"));
				$qry = $DataPengaturan->QryUpdData("t_atribusi_dokumen", $data_upd, "WHERE Id='$idplh'");
			}
			
			$data_ins= array(
							array("jns_dok", $jns_dok),
							array("tanggal_dok", $tanggal_dok),
							array("nomor_dok", $nomor_dok),
							array("refid_atribusi", $refid_atribusi),
							array("sttemp", "1"),
							array("status", "1")
						);
			$qry = $DataPengaturan->QryInsData("t_atribusi_dokumen", $data_ins);
				
			$qry_dok = $DataPengaturan->QyrTmpl1Brs2("t_atribusi_dokumen", "Id", $data_ins, " ORDER BY Id DESC");
			$dt_dok = $qry_dok["hasil"];			
			
			
			if($fmST != 0){
				$data_upd_rek = array(array("refid_dokumen_atribusi", $dt_dok["Id"]));
				$qry_rek = $DataPengaturan->QryUpdData("t_atribusi_rincian", $data_upd_rek, "WHERE refid_dokumen_atribusi='$idplh'");$cek.=$qry_rek['cek'];
			}
			
			$err=$qry["errmsg"];$cek.=$qry["cek"];
			$qry_Dok_atribusi = "SELECT Id, nomor_dok FROM t_atribusi_dokumen WHERE refid_atribusi='$refid_atribusi' AND status!='2' ";
			$content =cmbQuery('dokumen_atribusi',$dt_dok["Id"],$qry_Dok_atribusi," style='width:300px;' onchange='".$this->Prefix.".GetDokumenAtribusi();' ",'--- PILIH DOKUMEN ---');
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function BtnUbahHapus($tmblUbah, $fnc_Ubah, $tmblHapus, $fnc_Hapus ){
	
		return " <input type='button' name='$tmblUbah' id='$tmblUbah' value='UBAH' onclick='pemasukan_atribusi.$fnc_Ubah()' /> <input type='button' name='$tmblHapus' id='$tmblHapus' value='HAPUS' onclick='pemasukan_atribusi.$fnc_Hapus()' />";
	}
	
	function GetDokumenAtribusi(){
		global $DataPengaturan, $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';		
		$refid_atribusi = cekPOST($this->Prefix."_idplh");
		$dokumen_atribusi = cekPOST("dokumen_atribusi");
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_atribusi_dokumen", "*", "WHERE Id='$dokumen_atribusi' AND refid_atribusi='$refid_atribusi' AND status !='2'");$cek.=$qry["cek"];
		$dt = $qry["hasil"];
		
		$content["OPTDokumen"] = "";
		$content["dokumensumber"] = "";
		$content["tgl_dokumen_bast"] = "";
		$content["nomor_dokumen_bast"] = "";
		
		if($dt["Id"] != "" || $dt["Id"] != NULL){
			$tgl = explode("-", $dt["tanggal_dok"]);
			$tgl_dok = $tgl[2]."-".$tgl[1]."-".$tgl[0];
			
			$content["OPTDokumen"] = $this->BtnUbahHapus("btn_ubah_dok", "UbahDokumen", "btn_hapus_dok", "HapusDokumen");
			$content["dokumensumber"] = $dt["jns_dok"];
			$content["tgl_dokumen_bast"] = $tgl_dok;
			$content["nomor_dokumen_bast"] = $dt["nomor_dok"];
		}
			
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function HapusDokumen(){
		global $DataPengaturan, $HTTP_COOKIE_VARS;;
		$cek='';$err='';$content='';		
		$refid_atribusi = cekPOST($this->Prefix."_idplh");
		$dokumen_atribusi = cekPOST("dokumen_atribusi");
		
		$data = array(
					array("status", "2"),
				);
		$qry = $DataPengaturan->QryUpdData("t_atribusi_dokumen", $data, "WHERE Id='$dokumen_atribusi' AND refid_atribusi='$refid_atribusi' ");
		
		$qry_Dok_atribusi = "SELECT Id, nomor_dok FROM t_atribusi_dokumen WHERE refid_atribusi='$refid_atribusi' AND status!='2' ";
		$content =cmbQuery('dokumen_atribusi',"",$qry_Dok_atribusi," style='width:300px;' onchange='".$this->Prefix.".GetDokumenAtribusi();' ",'--- PILIH DOKUMEN ---');
		
		//UPDATE t_atribusi_rincian
		$qry_upd_rnc = $DataPengaturan->QryUpdData("t_atribusi_rincian", $data, "WHERE refid_dokumen_atribusi='$dokumen_atribusi' AND refid_atribusi='$refid_atribusi' ");
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_tabelRekening(){
		$cek='';$err='';$content='';		
		$idplh = $_REQUEST['pemasukan_atribusi_idplh'];
			
		if(cekPOST2('HapusData')==1){	
			$qrydel1 = "DELETE FROM t_atribusi_rincian WHERE refid_atribusi='$idplh' AND status='1' ";
			$aqrydel1 = mysql_query($qrydel1);
		}
		$get= $this->tabelRekening();
		$cek = $get['cek'];
		$err = $get['err'];
		$content = $get['content'];	
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_InsertRekening(){
		global $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		$uid = $HTTP_COOKIE_VARS['coID'];
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$dokumen_atribusi = cekPOST("dokumen_atribusi");
		
		if($dokumen_atribusi == "" && $err=="")$err="Dokumen Belum Di Pilih !";
		
		if($err == ""){
			$qrydel = "DELETE FROM t_atribusi_rincian WHERE refid_atribusi='$idplh' AND status='1' AND uid='$uid'";
			$aqrydel = mysql_query($qrydel);
			
			if($aqrydel){
				$qry="INSERT INTO t_atribusi_rincian (refid_atribusi, status,uid, sttemp,tahun, refid_dokumen_atribusi) values ('$idplh','1','$uid','1','$coThnAnggaran', '$dokumen_atribusi')";$cek.=$qry;
				$aqry = mysql_query($qry);
				if($aqry){
					$content = 1;
				}else{
					$err= 'Gagal !';
				}
			}
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_updKodeRek(){
		global $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		$uid = $HTTP_COOKIE_VARS['coID'];
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$idrek = $_REQUEST['idrek'];
		$koderek = $_REQUEST['koderek'];
		$jumlahharga = $_REQUEST['jumlahharga'];
		$dokumen_atribusi = cekPOST("dokumen_atribusi");
		if($jumlahharga < 1 && $err=='')$err='Jumlah Harga Belum Di Isi !';
		
		$qry = "SELECT nm_rekening FROM ref_rekening WHERE concat(k,'.',l,'.',m,'.',n,'.',o) = '$koderek' AND k != '0' AND l != '0' AND m != '0' AND n != '00' AND o != '00'"; $cek.=$qry;
		$aqry = mysql_query($qry);
		
		if(mysql_num_rows($aqry) == 0 && $err=='')$err = "KODE REKENING TIDAK VALID !";
		
		if($err==''){
			$kode = explode(".",$koderek);
			$knya = $kode[0];
			$lnya = $kode[1];
			$mnya = $kode[2];
			$nnya = $kode[3];
			$onya = $kode[4];
			if($_REQUEST['statidrek'] == '1'){
				$qryupd="UPDATE t_atribusi_rincian SET k='$knya',l = '$lnya',m = '$mnya', n= '$nnya',o= '$onya', jumlah='$jumlahharga', status='0' WHERE refid_atribusi='$idplh' AND Id='$idrek'";
			}else{
				$qryupd="INSERT INTO t_atribusi_rincian (k,l,m,n,o,status,refid_atribusi,sttemp,uid,jumlah, refid_dokumen_atribusi)values('$knya','$lnya','$mnya','$nnya','$onya','0','$idplh','1','$uid','$jumlahharga', '$dokumen_atribusi')";
				$updq = "UPDATE t_atribusi_rincian SET status = '2' WHERE Id='$idrek'";
				$aupdq = mysql_query($updq); 
			}
			$cek.=" | ".$qryupd;
			$aqryupd = mysql_query($qryupd);
			if($aqryupd){
				$content['koderek'] = "<a href='javascript:pemasukan_ins.jadiinput(`".$idrek."`);' />".$koderek."</a>";
				$content['jumlahnya'] = number_format($jumlahharga,2,",",".");
				$content['idrek'] = $idrek;
				$content['option'] = "
			<a href='javascript:".$this->Prefix.".HapusRekening(`$idrek`)' />
				<img src='datepicker/remove2.png' style='width:20px;height:20px;' />
			</a>";
			}else{
				$err= 'Gagal !';
			}
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_jadiinput(){
		global $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		$uid = $HTTP_COOKIE_VARS['coID'];
		$idrek = $_REQUEST['idrekeningnya'];
		
		$qry = "SELECT * FROM t_atribusi_rincian WHERE Id='$idrek'";$cek.=$qry;
		$aqry = mysql_query($qry);
		$dt = mysql_fetch_array($aqry);
		
		$content['koderek'] = "
			<input type='text' onkeyup='setTimeout(function myFunction() {".$this->Prefix.".namarekening();},100);' name='koderek' id='koderek' value='".$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o']."' style='width:80px;' maxlength='11' />
			"."<input type='hidden' name='idrek' id='idrek' value='".$idrek."' />".
			"<input type='hidden' name='statidrek' id='statidrek' value='".$dt['status']."' />
			<a href='javascript:cariRekening.windowShow(".$dt['Id'].");'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>
			";
		
		$content['jumlahnya'] = "<input type='text' name='jumlahharga' id='jumlahharga' value='".intval($dt['jumlah'])."' style='text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = ".$this->Prefix.".formatCurrency(this.value);' />
						<span id='formatjumlah'></span>";
		$content['idrek'] = $idrek;
		$content['option'] = "
			<a href='javascript:".$this->Prefix.".updKodeRek()' />
				<img src='datepicker/save.png' style='width:20px;height:20px;' />
			</a>";
		$content['atasbutton'] = "<a href='javascript:".$this->Prefix.".tabelRekening()' /><img src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>";
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_namarekening(){
		global $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		
		$idrek = $_REQUEST['idrek'];
		$koderek = addslashes($_REQUEST['koderek']);
		
		$qry = "SELECT nm_rekening FROM ref_rekening WHERE concat(k,'.',l,'.',m,'.',n,'.',o) = '$koderek' AND k<>'0' AND l<>'0' AND m<>'0' AND n<>'00' AND o<>'00'"; $cek.=$qry;
		$aqry = mysql_query($qry);
		$daqry = mysql_fetch_array($aqry);
		$content['namarekening'] = $daqry['nm_rekening'];
		$content['idrek'] = $idrek;
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_HapusRekening(){
		global $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';

		$uid = $HTTP_COOKIE_VARS['coID'];
		$idrekei = $_REQUEST['idrekei'];
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		
		$qrydel = "UPDATE t_atribusi_rincian SET status='2' WHERE Id='$idrekei'";$cek.=$qrydel;
		$aqrydel = mysql_query($qrydel);
		
		$qrydel1 = "DELETE FROM t_atribusi_rincian WHERE refid_atribusi='$idplh' AND status='1' AND uid='$uid'";
		$aqrydel1 = mysql_query($qrydel1);
		
		if(!$aqrydel)$err='Gagal Menghapus Data Rekening Belanja Atribusi'.$qrydel;
		if(!$aqrydel1)$err='Gagal Menghapus Data Rekening Belanja Atribusi';
				
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function SimpanSemua_HapusData(){
		global $HTTP_COOKIE_VARS,$DataPengaturan, $pemasukan_saja;
		$cek='';$err='';$content='';
		$idplh = cekPOST2($this->Prefix."_idplh");
		$qry = $DataPengaturan->QryDelData($pemasukan_saja->TblName_atr,"WHERE Id='$idplh' ");$cek.=$qry["cek"];
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
}
$pemasukan_atribusi = new pemasukan_atribusiObj();
?>