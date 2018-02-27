<?php
	include "pages/keuangan/daftarsuratpermohonan.php";
 	$DataPermohonan = $daftarsuratpermohonan;
	
class suratpermohonan_sppObj  extends DaftarObj2{	
	var $Prefix = 'suratpermohonan_spp';
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
	var $PageTitle = 'SURAT PERMOHONAN PEMBAYARAN (SPP)';
	var $PageIcon = 'images/order1.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='suratpermohonan_spp.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'suratpermohonan_spp';	
	var $Cetak_Mode=2;
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'suratpermohonan_sppForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	var $urutan=0;
	var $KodeProg="";
	var $KodeKeg="";
	
	//Dekripsi ------------------------------------------------------------------
	var $DataSPP=array();
	
	var $jns_spp="";
	var $NomorSPP="";
	var $TglSPP="";
	var $refid_terima="";
	var $refid_terima_sebelumnya="";
	var $uraian_pembayaran="";
	var $refid_pptk="";
	var $refid_nomor_tagihan="";
	var $refid_penyedia="";
	var $refid_penyedia_jns="";
	var $refid_nomor_spd="";
	
	var $fm_jumlah_rek=0;
	
	var $STAT_RefTerima = FALSE;
	
	var $Data_Cek="";
	
	var $stat_barang = array(
		array("1", "SUDAH"),
		array("2", "BELUM"),
	);
	
	function setTitle(){
		return 'SURAT PERMOHONAN PEMBAYARAN (SPP)';
	}
		
	function setMenuEdit(){
		return "";
	}
	
	function setMenuView(){
		return "";
	}
	
	function SimpanSemua_Validasi(){
		global $DataPengaturan,$DataPermohonan;
		$t_spp = $DataPermohonan->TblName_N;
		$Tbl_rek = $DataPermohonan->TblName_Rekening;
		$err="";
		$NOSPP = cekPOST2("nomor_spp_no");
		
		if($err == "" && $this->jns_spp=='')$err="Jenis SPP Belum di Pilih !";
		if($err == "" && intval($NOSPP) == 0)$err="Nomor SPP Belum di Isi !";
		if($err == "" && !cektanggal($this->TglSPP))$err="Tanggal SPP Tidak Valid ! ".$this->TglSPP;		
		if($err == "" && $this->refid_pptk=='')$err="Nama PPTK Belum di Pilih !";
		if($err == "" && $this->refid_nomor_tagihan=='')$err="Nomor Tagihan Belum di Isi !";
		if($err == "" && $this->refid_penyedia=='')$err="Penerima Belum di Pilih !";
		
		//Cek Nomor SPP
		if($err == ""){
			$qry_noSPP = $DataPengaturan->QryHitungData($t_spp,"WHERE nomor_spp='".$this->NomorSPP."' AND Id!='".$this->DataSPP["Id"]."'");
			if($qry_noSPP["hasil"] > 0)$err = "Nomor SPP Sudah di Gunakan !";
		}
		//VALIDASI SPP LS -------------------------------------------------------------------------------------------
		if($this->DataSPP["jns_spp"] == "1"){			
			if($err == "" && $this->refid_nomor_spd=='')$err="Nomor SPD Belum di Pilih !";
			$where = "WHERE refid_spp='".$this->DataSPP["Id"]."' AND refid_nomor_spd='$this->refid_nomor_spd' AND status='0' ";		
			if($err == ""){
				$qry_hit = $DataPengaturan->QryHitungData($Tbl_rek, $where);			
				if($qry_hit["hasil"] < 1)$err="Data Rekening SPD Belum di isi !";	
			}	
			
			if($err == ""){
				$qry_hit2 = $DataPengaturan->QryHitungData($Tbl_rek, $where." AND jumlah='0' ");
				if($qry_hit2["hasil"] > 0)$err="Data Rekening SPD Masih Ada Yang Berjumlah Rp 0,00. Tidak Bisa di Simpan !";
				$this->Data_Cek.=$qry_hit2["cek"];	
			}	
		}
		
		//VALIDASI SPP UP -------------------------------------------------------------------------------------------
		if($this->DataSPP["jns_spp"]){
			$this->fm_jumlah_rek = cekPOST2Float("fm_jumlah_rek");
			if($this->fm_jumlah_rek <= 0 && $err == "")$err = "Rekening Belum di Isi !";
			
		}
			
		
		return $err;
	}
	
	function SimpanSemua_BeforeSimpan(){
		global $DataPengaturan;
		$cek="";
		
		switch($this->DataSPP["jns_spp"]){
			case "1":
				$cek.=$this->SimpanSemua_Before_SPPLS();
			break;
			case "2":
				$cek.=$this->SimpanSemua_Before_SPPUP();
			break;
		}
		
		return $cek;
	}
	
	function SimpanSemua_Before_SPPLS(){
		global $DataPengaturan;
		$cek="";
		
		//Delete t_spp_rekening --------------------------------------------------------------------------------
		$del_rekSPP = $DataPengaturan->QryDelData("t_spp_rekening","WHERE (refid_nomor_spd != '$this->refid_nomor_spd' OR status!='0') AND refid_spp='$idplh' "); $cek.=" | ".$del_rekSPP["cek"];
		//Update t_spp_rekening
		$data_upd = array(array("sttemp","0"));
		$upd_rekSPP = $DataPengaturan->QryUpdData("t_spp_rekening",$data_upd, "WHERE refid_spp='$idplh' AND refid_nomor_spd='$this->refid_nomor_spd' AND status='0'"); $cek.=" | ".$upd_rekSPP["cek"];
		
		return $cek;
	}
	
	function SimpanSemua_Before_SPPUP(){
		global $DataPengaturan, $DataPermohonan;
		$cek="";
		$data = array(array("jumlah", $this->fm_jumlah_rek),array("sttemp", "0"));
		$qry_upd = $DataPengaturan->QryUpdData($DataPermohonan->TblName_Rekening, $data, "WHERE refid_spp='".$this->DataSPP["Id"]."' LIMIT 1");$cek.=$qry_upd["cek"];
			
		return $cek;
	}
	
	function SimpanSemua(){
		global $HTTP_COOKIE_VARS, $Main, $DataPengaturan, $DataPermohonan;
		$uid = $HTTP_COOKIE_VARS['coID'];
		$thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		
			
		$idplh = cekPOST2($this->Prefix."_idplh");
		$this->DataSPP = $DataPermohonan->GetDataSPP($idplh);
		$c1 = $this->DataSPP["c1"];
		$c = $this->DataSPP["c"];
		$d = $this->DataSPP["d"];		
		
		$this->jns_spp = cekPOST2("jns_spp");
		$this->NomorSPP = cekPOST2("nomor_spp_no")."/$c1.$c.$d/".$DataPengaturan->Daftar_arr_pencairan_dana2[$this->jns_spp]."/".$thn_anggaran;		
		$this->TglSPP = FormatTanggalnya(cekPOST2("tgl_spp")."-".cekPOST2("thn_spp")); 		
		$this->refid_terima = cekPOST2("refid_terima");
		$this->refid_terima_sebelumnya = cekPOST2("refid_terima_sebelumnya");
		$this->uraian_pembayaran = cekPOST2("uraian_pembayaran");
		$this->refid_pptk = cekPOST2("refid_pptk");
		$this->refid_nomor_tagihan = cekPOST2("refid_nomor_tagihan");
		$this->refid_penyedia = cekPOST2("refid_penyedia");
		$this->refid_penyedia_jns = cekPOST2("refid_penyedia_jns");
		$this->refid_nomor_spd = cekPOST2("refid_nomor_spd");		
		
		$err = $this->SimpanSemua_Validasi();
		//if($err=="")$err="sddf".$this->Data_Cek;		
		if($err == ""){
			$cek.= $this->SimpanSemua_BeforeSimpan();			
			//Update t_spp --------------------------------------------------------------------------------
			$data = array(
						//array("jns_spp", $this->jns_spp),
						array("nomor_spp", $this->NomorSPP),
						array("tgl_spp", $this->TglSPP),
						array("refid_terima", $this->refid_terima),
						array("uraian", $this->uraian_pembayaran),
						array("refid_pptk", $this->refid_pptk),
						array("refid_nomor_tagihan", $this->refid_nomor_tagihan),
						array("refid_penyedia", $this->refid_penyedia),
						array("refid_penyedia_jns", $this->refid_penyedia_jns),
						array("refid_nomor_spd", $this->refid_nomor_spd),
						array("status", "1"),
						array("sttemp", "0"),
					);
			$qry = $DataPengaturan->QryUpdData("t_spp",$data, "WHERE Id='$idplh' ");$cek.=$qry["cek"];	
		}
			
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function SimpanKelengkapanDok($Id){
		global $DataPengaturan;
		$cek = ""; $err = "";
		
		//DOKUMEN KELENGKAPAN
		$IdDokumen_syarat = cekPOST("IdDokumen_syarat");
		
		for($i=0;$i<count($IdDokumen_syarat);$i++){
		
			$status_spp = "1";
			if(!isset($_REQUEST["suratpermohonan_spp_cb_rkd_".$IdDokumen_syarat[$i]]))$status_spp='0';
			if($err == ""){
				$data_inputDok = 
					array(
						array("refid_kelengkapan_dok", $IdDokumen_syarat[$i]),
						array("status_spp", $status_spp),
						array("refid_spp", $Id),
					);
				$qry = $DataPengaturan->QryInsData("t_spp_kelengkapan_dok", $data_inputDok);
				$cek.= $suratpermohonan." | ".$qry['cek']; $err=$qry['errmsg'];
			}else{
				break;
			}
			
			
		}
		
		return	array ('cek'=>$cek, 'err'=>$err,);
					
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
		case 'formBaru'					 : $fm = $this->setFormBaru();break;
		case 'formEdit'					 : $fm = $this->setFormEdit();break;			
		case 'SimpanSemua'				 : $fm= $this->SimpanSemua();break;
		case 'BatalSemua'				 : $fm= $this->BatalSemua();break;
		case 'TabelDokumen'				 : $fm= $this->TabelDokumen();break;
		case 'tabelRekening'			 : $fm= $this->tabelRekening();break;
		case 'tabelRekening_Ins'		 : $fm= $this->tabelRekening_Ins();break;
		case 'getNomorSPP'				 : $fm= $this->getNomorSPP();break;
		case 'getInformasi_jmlTrsd'		 : $fm= $this->getInformasi_jmlTrsd();break;
		case 'Get_Tgl_nomorSPD'			 : $fm= $this->Get_Tgl_nomorSPD();break;
		case 'Get_pil_nomorSPD'			 : $fm= $this->Get_pil_nomorSPD();break;
		case 'GetNomorTagihan'			 : $fm= $this->GetNomorTagihan();break;
		case 'GetData_Penerima'			 : $fm= $this->GetData_Penerima();break;
		case 'tabelRekening_Save'		 : $fm= $this->tabelRekening_Save();break;		
		case 'tabelRekening_Del'		 : $fm= $this->tabelRekening_Del();break;
		case 'tabelRekening_Edit'		 : $fm= $this->tabelRekening_Edit();break;
		case 'GetData_AfterIdPenerimaan' : $fm= $this->GetData_AfterIdPenerimaan();break;
		case 'getNomorSPP_saja' 		 : $fm= $this->getNomorSPP_saja();break;
		case 'getSisaSPD' 		 		 : $fm= $this->getSisaSPD();break;
		
		case 'tabelRekening_SPPUP' 		 : $fm= $this->tabelRekening_SPPUP();break;
		   
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
			fn_TagScript('js/skpd.js').
			fn_TagScript('js/master/ref_tagihan/ref_tagihan.js').
			fn_TagScript('js/keuangan/daftarsuratpermohonan.js').
			fn_TagScript('js/pencarian/DataPengaturan.js').
			fn_TagScript('js/pencarian/cariRekening.js').
			fn_TagScript('js/pencarian/cariprogram.js').
			fn_TagScript('js/pencarian/cariIdPenerima.js').
			fn_TagScript('js/pencarian/caripenerima.js').
			fn_TagScript('js/pencarian/caribendahara_rekening.js').
			fn_TagScript('js/pencarian/carino_spd_det.js').
			fn_TagScript('js/keuangan/'.$this->Prefix.'.js').
			$DataPengaturan->Gen_Script_DatePicker().
			$scriptload;
	}
	
	function setPage_Content(){
		global $DataPengaturan;
		$YN = cekPOST2("YN");
		
		$dskrp = "daftarsuratpermohonanSKPD2fm";
		$c1 = $YN == "1"?cekPOST2($dskrp."URUSAN",0):"";
		$c = $YN == "1"?cekPOST2($dskrp."SKPD"):"";
		$d = $YN == "1"?cekPOST2($dskrp."UNIT"):"";
		$e = $YN == "1"?cekPOST2($dskrp."SUBUNIT"):"";
		$e1 = $YN == "1"?cekPOST2($dskrp."SEKSI"):"";
		
		$Id=$_REQUEST["daftarsuratpermohonan_cb"];
		
		$data = InputTypeHidden("c1",$c1).
				InputTypeHidden("c",$c).
				InputTypeHidden("d",$d).
				InputTypeHidden("e",$e).
				InputTypeHidden("e1",$e1).
				InputTypeHidden("idubah",$Id[0]).
				InputTypeHidden("databaru",$YN).
				InputTypeHidden("haljns_sppnya",cekPOST2("jns_spp","1"));
		
		return $data.$this->genDaftarInitial();
		
	}
		
	function BaruNamaPejabat(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['c1'] = cekPOST('c1nya');
		$dt['c'] = cekPOST('cnya');
		$dt['d'] = cekPOST('dnya');
		$dt['jns'] = cekPOST('jns');
		
		$fm = $this->setFormBaruNamaPejabat($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	
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
	 global $Ref, $Main, $HTTP_COOKIE_VARS, $DataPengaturan,$DataOption, $DataPermohonan;
	 
	 $thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 
	 $databaru = cekPOST2("databaru");
	 
	if($databaru == '1'){
		$c1 = cekPOST2("c1");
		$c = cekPOST2("c");
		$d = cekPOST2("d");
		$e = cekPOST2("e");
		$e1 = cekPOST2("e1");
		$jns_spp = cekPOST2("haljns_sppnya");
		
		$data_Simpan_SPP = array(
			array("c1", $c1),
			array("c", $c),
			array("d", $d),
			array("e", $e),
			array("e1", $e1),
			array("jns_spp", $jns_spp),
			array("sttemp", "1"),
			array("uid_spp", $uid),
			array("status", "0"),
			array("tahun", $thn_anggaran),
		);
		
		$qry_simpan = $DataPengaturan->QryInsData("t_spp", $data_Simpan_SPP);
		$qry_Tmpl = $DataPengaturan->QyrTmpl1Brs2("t_spp","*",$data_Simpan_SPP," ORDER BY Id DESC");		
	}else{	
		$Idplh = cekPOST("idubah");
		$Get_DataSPP = $DataPermohonan->Gen_QueryTabel_Spp($Idplh);
		$qry_Tmpl["hasil"]=$Get_DataSPP["content"];
	}	 
		
	$dt=$qry_Tmpl["hasil"]; $cek.=$qry_Tmpl["cek"];
	
	switch($dt['jns_spp']){
		case "2":
			if($databaru == "1")$SetJNS_SPP = $this->Set_JNS_SPP_UP($dt);
		break;
	}
	
	$c1 = $dt["c1"];
	$c = $dt["c"];
	$d = $dt["d"];
	$e = $dt["e"];
	$e1 = $dt["e1"];
	
	$jns_spp = $dt['jns_spp'];
	$no_SPD = $databaru == "2"?$dt['no_spd']:"";
	$tgl_SPD = $databaru == "2"?FormatTanggalnya($dt['tgl_spd']):"";
	$tgl_SPP = $databaru == "2"?FormatTanggalBulan($dt['tgl_spp']):date("d-m");
	$thn_SPP = $databaru == "2"?GetTahunFromDB($dt['tgl_spp']):$thn_anggaran;
	$nomor_spp = $databaru == "2"?$dt['nomor_spp']:"";	
	if($databaru == "2"){
		$nomor_sppnya = explode("/", $dt['nomor_spp']);
		$no_spp = $nomor_sppnya[0];
		$no_spp_ket = "/$c1.$c.$d/".$nomor_sppnya[2]."/".$nomor_sppnya[3];
	}else{
		$no_spp = "";
		$no_spp_ket = "/$c1.$c.$d/SPPLS/".$thn_anggaran;
	}
	
	$id_penerimaan = "";
	if($databaru == "2" && ($dt["refid_terima"] != 0 || $dt["refid_terima"] != NULL || $dt["refid_terima"] != "")){
		$qry_Terima = $DataPengaturan->QyrTmpl1Brs($DataPermohonan->TblName_Terima, "*", "WHERE Id='".$dt["refid_terima"]."' AND sttemp='0'");
		$dt_Terima = $qry_Terima["hasil"];
		
		$id_penerimaan = $dt_Terima["id_penerimaan"];
	}
	
	$uraian = $databaru == "2"?$dt['uraian']:"";
	$refid_pptk = $databaru == "2"?$dt['refid_pptk']:"";
	
	$refid_pa_kpa = $databaru == "2"?$dt['refid_pa_kpa']:"";
	$refid_pejabat_pk = $databaru == "2"?$dt['refid_pejabat_pk']:"";
	$refid_bendahara_pp = $databaru == "2"?$dt['refid_bendahara_pp']:"";
	$refid_terima = $databaru == "2"?$dt['refid_terima']:"";
	$refid_nomor_tagihan = $databaru == "2"?$dt['refid_nomor_tagihan']:"";
	$penerima_uang = $databaru == "2"?"":"";
	$refid_penyedia = $databaru == "2"?$dt['refid_penyedia']:"";
	$refid_penyedia_jns = $databaru == "2"?$dt['refid_penyedia_jns']:"";
	$nomor_spd = $databaru == "2"?$dt['no_spd']:"";
	$tgl_spd = $databaru == "2"?FormatTanggalnya($dt['tgl_spd']):"";
	$refid_nomor_spd = $databaru == "2"?$dt['refid_nomor_spd']:"";
	
	$qrykegitan = "SELECT q,concat (IF(LENGTH(q)=1,concat('0',q), q),'. ',nama) as nama FROM ref_program WHERE bk='$bknya' AND ck='$cknya' AND dk='$dknya' AND p='$p' AND q!='0'";
	
	$qry_NamaPejabat = "SELECT Id, nama FROM ref_tandatangan WHERE $WHEREC1 c='$c' AND d='$d' ";
	
	$jns_PA_KPA = $DataPengaturan->kat_PA_KPA;
	$jns_PPK = $DataPengaturan->kat_PPK;
	$jns_PPTK = $DataPengaturan->kat_PPTK;
	$jns_BPP = $DataPengaturan->kat_BPP;
	
	$qry_pakpa = $qry_NamaPejabat." AND kategori_tandatangan='$jns_PA_KPA' ";
	$qry_ppk = $qry_NamaPejabat." AND kategori_tandatangan='$jns_PPK' ";
	$qry_pptk = $qry_NamaPejabat." AND kategori_tandatangan='$jns_PPTK' ";
	$qry_bpp = $qry_NamaPejabat." AND kategori_tandatangan='$jns_BPP' ";
	
	switch($jns_spp){
		case "2":$data_spp="<option value='2'>SPP-UP</option>";break;
		case "3":$data_spp="<option value='3'>SPP-GU</option>";break;
		case "4":$data_spp="<option value='3'>SPP-TU</option>";break;
		default :$data_spp="<option value='1'>SPP-LS</option>";break;
	}
	$FM_jns_spp = "<select name='jns_spp' id='jns_spp' style='width:174px;'>$data_spp</select>";
	
	$data_penerimaan = array("kosong"=>"");
	$modul_penerima = 0;
	if($Main->MODUL_PENERIMAAN == TRUE && $dt["jns_spp"] == "1"){
		$data_penerimaan = 
			array(
				'label'=>'PENERIMAAN BARANG',
				'name'=>'id_penerimaan',
				'label-width'=>'200px;',
				'value'=>
						InputTypeHidden("refid_terima",$refid_terima).
						InputTypeHidden("refid_terima_sebelumnya",$refid_terima).
						" 
						<table style='margin-left:-3px;'>
							<tr>
								<td>".InputTypeText("id_penerimaan",$id_penerimaan," readonly style='width:300px;' ")."</td>
								<td>".InputTypeButton("cariIdPenerimaan","CARI", "onclick='".$this->Prefix.".CariIdPenerimaan();'")."</td>
								<td><span id='informasi_jmlTrsd'></span></td>
							</tr>
						</table>
						",
			);
		$modul_penerima = 1;
	}
	$Btn_CariPIHAKKE3 = "";
	$arr_DasarPembayaran = array();
	switch($jns_spp){
		case "1":
			$Btn_CariPIHAKKE3 = InputTypeButton("cari_penerima_pihakke3","PIHAK KE-3","title='Cari Penerima Pihak Ke-3' onclick='".$this->Prefix.".caripenerima(2)'");
			$arr_DasarPembayaran = 
				array(
					array(
						'label'=>'<b>DASAR PEMBAYARAN</b>',
						'pemisah'=>'',
					),
					array(
						'label'=>'<span style="margin-left:10px;">NOMOR SPD</span>',
						'value'=>
							InputTypeText("nomor_spd",$tgl_spd,"style='width:300px;' readonly  placeholder='NOMOR SPD'")." ".
							InputTypeButton("cari_noSPD", "CARI","onclick='".$this->Prefix.".cariNoSPDdet();'").
							InputTypeHidden("refid_nomor_spd",$refid_nomor_spd)
						,
					),
					array(
						'label'=>'<span style="margin-left:10px;">TANGGAL SPD</span>',
						'name'=>'tgl_spd',
						'type'=>'text',
						'value'=>$tgl_SPD,
						'parrams'=>"style='width:80px;' readonly placeholder='TANGGAL'",
					)
				);
		break;
	}
	
	$IsiForm = 
		array(
			array(
				'label'=>'JENIS SPP',
				'label-width'=>'200px',
				'value'=>$FM_jns_spp
					
			),
			array(
				'label'=>'NOMOR SPP',
				'value'=>
					InputTypeText("nomor_spp_no",$no_spp,"style='width:40px;text-align:right;' maxlength='4' ")." ".											
					InputTypeText("nomor_spp_ket",$no_spp_ket,"style='width:130px;' readonly "),
			),
			array(
				'label'=>'TANGGAL SPP',
				'name'=>'tgl_spp',
				'value'=>InputTypeText("tgl_spp",$tgl_SPP,"placeholder='TANGGAL' maxlength='5' style='width:40px;' class='datepicker3' onkeyup='".$this->Prefix.".Get_pil_nomorSPD();'" )." ".InputTypeText("thn_spp",$thn_SPP,"placeholder='TAHUN' maxlength='4' style='width:40px;' readonly" ),
			),
			$data_penerimaan,
			array(
				'label'=>'NOMOR TAGIHAN',
				'name'=>'refid_nomor_tagihan',
				'value'=>
					InputTypeText("nomor_tagihan","", "placeholder='NOMOR TAGIHAN' style='width:300px;' readonly ")." ".
					InputTypeButton("cariTagihan","CARI", "onclick='".$this->Prefix.".cariTagihan();'").
					InputTypeHidden("refid_nomor_tagihan",$refid_nomor_tagihan), 
			),
			array(
				'label'=>'URAIAN PEMBAYARAN',
				'name'=>'uraian_pembayaran',
				'value'=>InputTypeTextArea("uraian_pembayaran",$uraian,"placeholder='URAIAN PEMBAYARAN' style='width:300px;height:60px;'" ),
			),
			array(
				'label'=>'NAMA PPTK',
				'name'=>'pptk',
				'value'=>"<span id='jns_".$jns_PPTK."'>".cmbQuery('refid_pptk',$refid_pptk,$qry_pptk, "style='width:300px;' ","--- PILIH ---")."</span> ".$DataPermohonan->getTombolBaruNamaPejabat($jns_PPTK,$this->Prefix."Form"),
			),
			array(
				'label'=>'<b>PENERIMA</b>',
				'pemisah'=>'',
			),
			array(
				'label'=>'<span style="margin-left:10px;">NAMA</span>',
				'name'=>'nama_penerima_uang',
				'value'=>
						InputTypeText("nama_penerima_uang",$nama_penerima_uang," readonly style='width:300px;' placeholder='NAMA'")." ".
						InputTypeButton("cari_penerima_bendahara","BENDAHARA","title='Cari Penerima, di Rekening Bendahara' onclick='".$this->Prefix.".caripenerima(1)'")." ".
						$Btn_CariPIHAKKE3.
						InputTypeHidden("refid_penyedia",$refid_penyedia).
						InputTypeHidden("refid_penyedia_jns",$refid_penyedia_jns),
			),
			array(
				'label'=>'<span style="margin-left:10px;">ALAMAT</span>',
				'name'=>'alamat_penerima_uang',
				'value'=>InputTypeTextArea("alamat_penerima_uang",$alamat_penerima_uang, "placeholder='ALAMAT' style='width:300px;height:50px;' readonly "), 
			),
			array(
				'label'=>'<span style="margin-left:10px;">BANK</span>',
				'name'=>'bank_penerima_uang',
				'type'=>'text',
				'value'=>$nip_penerima_uang,
				'parrams'=>"style='width:300px;' readonly placeholder='BANK'",
			),
			array(
				'label'=>'<span style="margin-left:10px;">REKENING</span>',
				'name'=>'rek_penerima_uang',
				'type'=>'text',
				'value'=>$nip_penerima_uang,
				'parrams'=>"style='width:300px;' readonly placeholder='REKENING'",
			),
			array(
				'label'=>'<span style="margin-left:10px;">NPWP</span>',
				'name'=>'npwp_penerima_uang',
				'type'=>'text',
				'value'=>$nip_penerima_uang,
				'parrams'=>"style='width:300px;' readonly placeholder='NPWP'",
			),
		);
		
	$IsiForm = array_merge($IsiForm, $arr_DasarPembayaran);	
	
	$TampilOpt =			
			$vOrder=
			$DataPengaturan->GenViewHiddenSKPD($c1, $c, $d, $e, $e1).InputTypeHidden("modul_penerima",$modul_penerima).
			$DataPengaturan->GenViewSKPD($c1, $c, $d, $e, $e1).
				genFilterBar(array($DataPengaturan->isiform($IsiForm)),'','','').
				LabelSPan1("Form_DasarPembayaran","").
				"<input type='hidden' name='jns_dari_rek' id='jns_dari_rek' value='2' />
				"."<div id='tbl_rekening'></div>".		
				/*genFilterBar(
				array(
					$DataPengaturan->isiform(
						array(						
							array(
								'label'=>'PA/KPA',
								'name'=>'pakpa',
								'label-width'=>'200px',
								'value'=>"<span id='jns_".$jns_PA_KPA."'>".cmbQuery('refid_pa_kpa',$refid_pa_kpa,$qry_pakpa, "style='width:300px;' ","--- PILIH ---")."</span> ".$DataPermohonan->getTombolBaruNamaPejabat($jns_PA_KPA,$this->Prefix."Form"),
							),
							array(
								'label'=>'PEJABAT PEMBUAT KOMITMEN',
								'name'=>'ppk',
								'label-width'=>'200px',
								'value'=>"<span id='jns_".$jns_PPK."'>".cmbQuery('refid_pejabat_pk',$refid_pejabat_pk,$qry_ppk, "style='width:300px;' ","--- PILIH ---")."</span> ".$DataPermohonan->getTombolBaruNamaPejabat($jns_PPK,$this->Prefix."Form"),
							),
							
							array(
								'label'=>'BENDAHARA PENGELUARAN PEMBANTU',
								'name'=>'ppp',
								'label-width'=>'200px',
								'value'=>"<span id='jns_".$jns_BPP."'>".cmbQuery('refid_bendahara_pp',$refid_bendahara_pp,$qry_bpp, "style='width:300px;' ","--- PILIH ---")."</span> ".$DataPermohonan->getTombolBaruNamaPejabat($jns_BPP,$this->Prefix."Form"),
							),
						)
					),
					
				
				),'','','').
				genFilterBar(array("<span style='color:black;font-size:14px;font-weight:bold;'/>KELENGKAPAN DOKUMEN</span>",	),'','','').
				"<div id='tbl_dokumen' style='width:100%;'></div>". */
				"
				<input type='hidden' name='fmURUSAN' id='fmURUSAN' value='$c1' />
				<input type='hidden' name='fmBIDANG' id='fmBIDANG' value='$c' />
				<input type='hidden' name='fmSKPD' id='fmSKPD' value='$d' />".
				genFilterBar(
				array(
					
					"<table>
						<tr>							
							<td><span id='selesaisesuai'>".$DataPengaturan->buttonnya($this->Prefix.'.SimpanSemua()','checkin.png','SIMPAN','SIMPAN','SIMPAN')."</span></td>
							<td>".$DataPengaturan->buttonnya($this->Prefix.'.BatalSemua()','cancel_f2.png','BATAL','BATAL','BATAL')."</td>
						</tr>".
					"</table>"
					
				
				),'','','').
				genFilterBar(
				array(
					InputTypeHidden($this->Prefix."_idplh",$dt['Id'])
				),'','','')
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
	
	/* UPDATE LAMA DARI PENERIMAAN REKENING, JANGAN DULU DIHAPUS
	
	function tabelRekening(){
		global $DataPengaturan;
			
		$cek = '';
		$err = '';
		$datanya='';
		$content=array();
		
		$Idplh = cekPOST("refid_terima");
		$qry = "SELECT * FROM v1_penerimaan_barang_rekening WHERE refid_terima='$Idplh' AND sttemp='0' AND status='0' ";$cek.=$qry;
		$aqry = mysql_query($qry);
		
		$no=1;
		$jml_rek=0;
		while($dt = mysql_fetch_array($aqry)){
			$row="row0";
			if($no%2==0)$row="row1";
			$datanya.="<tr class='$row'>
						<td class='GarisDaftar' align='right' style='width:25px' >$no</td>
						<td class='GarisDaftar' align='center'>".$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o']."</td>
						<td class='GarisDaftar' align='left'>".$dt['nm_rekening']."</td>
						<td class='GarisDaftar' align='right'>".number_format($dt['jumlah'],2,",",".")."</td>
						<td class='GarisDaftar' align='center'></td>
					</tr>";
			$no++;
			$jml_rek+=$dt['jumlah'];
		}
		
		$content['tabel'] ="
					<table class='koptable' style='min-width:780px;' border='1'>
						<tr>
							<th class='th01'>NO</th>
							<th class='th01' width='100px'>KODE REKENING</th>
							<th class='th01'>NAMA REKENING BELANJA</th>
							<th class='th01'>JUMLAH (Rp)</th>
							<th class='th01'>PAGU (Rp)</th>
						</tr>
						$datanya
						<tr class='row0'>
							<td class='GarisDaftar' align='center' colspan='3'><b>TOTAL</b></td>
							<td class='GarisDaftar' align='right'><b>".number_format($jml_rek,2,",",".")."</b></td>
							<td class='GarisDaftar'></td>
						</tr>
						
					</table>";
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}*/
	
	function tabelRekening_Ins(){
		 global $HTTP_COOKIE_VARS, $Main, $DataPengaturan;
	 	$uid = $HTTP_COOKIE_VARS['coID'];
	 	$thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];	
		$cek = '';$err = '';$content="";
		
		$refid_spp = cekPOST2($this->Prefix."_idplh");
		$c1 = cekPOST2("c1nya");
		$c = cekPOST2("cnya");
		$d = cekPOST2("dnya");
		$refid_nomor_spd = cekPOST2("refid_nomor_spd");
		
		if($err=="" && $refid_nomor_spd=="")$err = "NOMOR SPD Belum di Pilih !";		
		if($err==""){
			$data = array(
						array("c1",$c1),
						array("c",$c),
						array("d",$d),
						array("bk","0"),
						array("ck","0"),
						array("dk","0"),
						array("p","0"),
						array("q","0"),
						array("refid_spp",$refid_spp),
						array("refid_nomor_spd",$refid_nomor_spd),
						array("tahun",$thn_anggaran),
						array("uid",$uid),
						array("status","1"),
						array("sttemp","1"),
					);
			$qry = $DataPengaturan->QryInsData("t_spp_rekening",$data);
		}
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function tabelRekening_GetProgKeg($dt, $css_class){
		global $DataPengaturan;
		$datanya = "";
		$row=$this->urutan%2==0?"row1":"row0";
		$GetKodeProg = $DataPengaturan->Gen_valProgram($dt);
		$cols_ulang = $this->STAT_RefTerima == TRUE?3:4;		
		//PROGRAM -------------------------------------------------
		if($this->KodeProg != $GetKodeProg){
			$datanya.="
				<tr class='$row'>".
				Tbl_Td("","right", $css_class,2).
				Tbl_Td("<b>".$dt["nm_program1"]."</b>","left", $css_class).
				Tbl_Td("","right", $css_class,$cols_ulang).
				"</tr>";					
			$this->urutan++;
		}
		$this->KodeProg = $GetKodeProg;
		
		//KEGIATAN -------------------------------------------------
		$row=$this->urutan%2==0?"row1":"row0";
		$GetKodeKeg = $DataPengaturan->Gen_valKegiatan($dt);
		if($this->KodeKeg != $GetKodeKeg){
			$datanya.="
				<tr class='$row'>".
				Tbl_Td("","right", $css_class,2).
				Tbl_Td(LabelSPan1("nm_keg_".$dt["Id"],$dt["nm_kegiatan1"],"style='margin-left:5px;font-weight:bold;'"),"left", $css_class).
				Tbl_Td("","right", $css_class,$cols_ulang).
				"</tr>";			
			$this->urutan++;
		}
		$this->KodeProg = $GetKodeProg;	
		
		return $datanya;
	}
	
	function tabelRekening(){
		global $DataPengaturan, $DataPermohonan;
			
		$cek = '';
		$err = '';
		$datanya='';
		$content=array();
		$Idplh = cekPOST2($this->Prefix."_idplh");
		$refid_nomor_spd = cekPOST2("refid_nomor_spd");		
		$del =cekPOST2("del");
		$jns_spp =cekPOST2("jns_spp");
		
		if($jns_spp != "1")$err="Data Tidak Valid !";
		if($err == ""){
			if($del == "1"){
				$qry_del = "DELETE FROM t_spp_rekening WHERE status='1' AND refid_spp='$Idplh' ";$cek.=$qry_del;
				$aqry_del = mysql_query($qry_del);
			}
			
			$qry=$DataPermohonan->Gen_Query_viewRekSPP($Idplh);$cek.=$qry;
			$qry= "SELECT tspd.total, vrekspp.* FROM v1_nomor_spd_det tspd RIGHT JOIN ($qry) vrekspp ON tspd.Id=vrekspp.refid_nomor_spd_det ORDER BY bk,ck,dk,p,q,k,l,m,n,o";
			$aqry = mysql_query($qry);
			
			$no=1;
			$jml_rek=0;
			$total_spd=0;
			$this->urutan=1;
			$this->STAT_RefTerima=FALSE;
			while($dt = mysql_fetch_array($aqry)){		
				$css_class = "class='GarisDaftar'";	
							
				$Btn_Aksi = BtnImgDelete($this->Prefix.".tabelRekening_Del(".$dt["Id"].")");
				$KolomBtn_Aksi = Tbl_Td(LabelSPan1("Btn_Opt_Pil_".$dt["Id"], $Btn_Aksi),"center",$css_class);
				$isi_jml = LabelSPan1("jumlah_txt_".$dt["Id"], BtnText(FormatUang($dt["jumlah"]), $this->Prefix.".tabelRekening_Edit(".$dt["Id"].")"));
				
				if($dt["refid_terima"] != 0){
					$KolomBtn_Aksi = "";
					$isi_jml = FormatUang($dt["jumlah"]);
					if($this->STAT_RefTerima == FALSE)$this->STAT_RefTerima=TRUE;				
				}
				
				$datanya.=$this->tabelRekening_GetProgKeg($dt, $css_class);			
				$row=$this->urutan%2==0?"row1":"row0";			
										
				$datanya.=
					"<tr class='$row'>".
						Tbl_Td($no,"right", $css_class).
						Tbl_Td($DataPengaturan->Gen_valRekening($dt),"center", $css_class).
						Tbl_Td(LabelSPan1("nm_rek_".$dt["Id"],$dt["nm_rekening1"], "style='margin-left:10px;'"),"left", $css_class).
						Tbl_Td($isi_jml,"right", $css_class).
						Tbl_Td(FormatUang($dt["total"]),"right", $css_class).
						Tbl_Td(LabelSPan1("sisa_spd_".$dt["Id"],
							InputTypeButton("btn_sisaspd".$no,"SISA SPD", "onclick='".$this->Prefix.".getSisaSPD(`".$dt["refid_nomor_spd_det"]."`,`".$dt["Id"]."`)'")),
						"center", $css_class."id='col_JML_".$dt["Id"]."' ").
						$KolomBtn_Aksi.
					"</tr>";
				$no++;
				$jml_rek+=$dt['jumlah'];
				$total_spd+=$dt['total'];
				$this->urutan++;
			}
					
			//$TombolBaru=$del == "0"?BtnImgCancel($this->Prefix.".tabelRekening(1)"):BtnImgAdd($this->Prefix.".tabelRekening_Ins($jns)");
			$TombolBaru=$del == "0"?BtnImgCancel($this->Prefix.".tabelRekening(1)"):BtnImgAdd($this->Prefix.".cariNoSPDdet()");
			$Kolom_Button = $this->STAT_RefTerima?"":"<th class='th01' width='30px'><span id='btn_option'>$TombolBaru</span></th>";
			$cols_ulang = $this->STAT_RefTerima?1:2;
			
			$row1=$this->urutan%2==0?"row1":"row0";
			$content['tabel'] =
					genFilterBar(array(BtnText("REKENING SPD", $this->Prefix.".tabelRekening();","style='color:black;font-size:14px;font-weight:bold;'")),'','','').
					genFilterBar(array("
						<table class='koptable' style='min-width:1024px;' border='1'>
							<tr>
								<th class='th01' width='25'>NO</th>
								<th class='th01' width='75'>REKENING</th>
								<th class='th01'>URAIAN</th>
								<th class='th01' width='115px'>JUMLAH (Rp)</th>
								<th class='th01' width='115px'>SPD (Rp)</th>
								<th class='th01' width='115px'>SISA SPD (Rp)</th>
								$Kolom_Button
							</tr>
							$datanya
							<tr class='$row1'>".
								Tbl_Td("<b>TOTAL</b>","center", $css_class." colspan='3'").
								Tbl_Td("<b>".FormatUang($jml_rek)."</b>","right", $css_class).
								Tbl_Td("<b>".FormatUang($total_spd)."</b>","right", $css_class).
								Tbl_Td("","right", $css_class, $cols_ulang).
							"</tr>						
						</table>"
					),'','','');
		}
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function TabelDokumen(){
	 global $DataPermohonan;
	 
		$cek='';$err='';$content='';
		//DEFINISI
		$databaru = cekPOST("databaru");
		
		$jns_spp = cekPOST('jns_spp');
		if($jns_spp == '' && $err =='')$err = "Jenis SPP Belum di Pilih !";
		
		if($err == ''){
			$qry = "SELECT * FROM ref_kelengkapan_dokumen WHERE jns='$jns_spp' ";
			$ceklis_CEKBOX = "";
			
			if($databaru != "1"){
				$idplh = cekPOST("idubah");
				$ambil_tSpp = $DataPermohonan->GetDataSPP($idplh);
				$dt_TSpp = $ambil_tSpp["content"];
				
				if($dt_TSpp['jns_spp'] == $jns_spp)$qry = "SELECT * FROM v1_spp_dokumen WHERE jns='$jns_spp' AND refid_spp='".$dt_TSpp['Id']."' ";		
			}
			$aqry = mysql_query($qry);$cek.=$qry;
			$datanya='';
			$no=1;
			$IdCekbox = array();
			while($dt = mysql_fetch_array($aqry)){
				$ceklis_CEKBOX = "";
				if($databaru != "1")if($dt['status_spp'] == "1")$ceklis_CEKBOX="checked";
				
				$datanya.= "
					<tr class='row0'>
						<td class='GarisDaftar' align='right' style='width:25px' >$no</td>
						<td class='GarisDaftar' align='left'>".$dt['syarat']."</td>
						<td class='GarisDaftar' align='center' width='25px'><input type='checkbox' name='".$this->Prefix."_cb_rkd_".$dt['Id']."' id='".$this->Prefix."_cb_rkd_$no' $ceklis_CEKBOX/>
							<input type='hidden' name='IdDokumen_syarat[]' id='IdDokumen_syarat_no' value='".$dt['Id']."' />
						</td>
					</tr>";
				
				$no++;
			}
			
			$content = genFilterBar(
				array(
					"
					<div style='text-align:right;font-style:italic;' />CENTANG KELENGKAPAN DOKUMEN UNTUK VERIFIKASI SPP</div>
					<table class='koptable' style='min-width:780px;' border='1'>
						<tr>
							<th class='th01' style='width:25px'>NO</th>
							<th class='th01'>NAMA DOKUMEN</th>
							<th class='th01'></th>							
						</tr>
						$datanya
						
					</table>"				
				),'','','');
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function getTombolBaruNamaPejabat($jns){
		return " <input type='button' value='BARU' onclick='".$this->Prefix.".BaruNamaPejabat($jns)' />";
	}
	
	function getNomorSPP_saja(){
		global $DataPengaturan, $Main, $DataPermohonan,$HTTP_COOKIE_VARS;
		$cek="";$err="";$content="";
		$GetData_NomorSPP = $this->getNomorSPP();
		$NomorSPP=explode("/",$GetData_NomorSPP["content"]);
		
		$content["NomorSPP"]=$NomorSPP[0];		
		$content["NomorSPP_Ket"]="/".$NomorSPP[1]."/".$NomorSPP[2]."/".$NomorSPP[3];		
				
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
		
	function getNomorSPP(){
		global $DataPengaturan, $Main, $DataPermohonan,$HTTP_COOKIE_VARS;
		
		$thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$t_spp = $DataPermohonan->TblName_N;
		
		$no_spp = "";
		$cek='';$err='';$content;
		$idplh = cekPOST2($this->Prefix."_idplh");
		$jns_spp = cekPOST2("jns_spp");
		$tgl_spp = cekPOST2("tgl_spp");
		$c1 = cekPOST2("c1nya");
		$c = cekPOST2("cnya");
		$d = cekPOST2("dnya");
				
		//Validasi Tgl SPP
		$Get_tgl_spp = cekPOST2("tgl_spp")."-".cekPOST2("thn_spp");
		if($err == "" && $Get_tgl_spp == ""){
			$err = "Tanggal SPP Belum di Isi !";
		}else{
			$tgl_spp = FormatTanggalnya($Get_tgl_spp);
			if($err=='' && !cektanggal($tgl_spp)) $err= 'Tanggal SPP Tidak Valid'; 
		}
		
		//Cek Apakah Data Edit
		if($err == ""){
			$DataBaru = cekPOST("databaru");
			$BlnThn_SPP = $ex_Get_tgl_spp[2]."-".$ex_Get_tgl_spp[1];
			
			if($DataBaru == "2"){
				$refid_terima = cekPOST("refid_terima");
				$Ambildata_spp = $DataPermohonan->GetDataSPP($refid_terima);
				$data_spp = $Ambildata_spp["content"];
				$BlnThn_SPP_DataAmbil = explode("-", $data_spp['tgl_spp']);
				$BlnThn_SPP_Ambil = $BlnThn_SPP_DataAmbil[0]."-".$BlnThn_SPP_DataAmbil[1];
				
				if($data_spp["jns_spp"] == $jns_spp && $BlnThn_SPP == $BlnThn_SPP_Ambil)$no_spp=$data_spp['nomor_spp'];
				
			}
		}
		
		$where_data = "WHERE c1='$c1' AND c='$c' AND d='$d' AND tahun = '$thn_anggaran' AND jns_spp='$jns_spp' AND sttemp='0' ";
		
		
		if($err == "" && $no_spp == ""){
			if($tgl_spp != '' && $jns_spp != ''){				
				//Cek Apakah Data INI Mempunyai Nomor Surat
				$qry_spp = $DataPengaturan->QyrTmpl1Brs($t_spp, "*",$where_data." AND Id='$idplh'");
				$dt_spp = $qry_spp["hasil"];
				
				if($dt_spp["Id"] != "" || $data_spp != NULL){
					$no_spp = $dt_spp["nomor_spp"];
				}else{
					//DEFINISI
					$tgl_pilih = explode("-", $tgl_spp);
					$bln_thn_spp = $tgl_pilih[0]."-".$tgl_pilih[1];
					
					$Kata_jns_spp = $DataPengaturan->Daftar_arr_pencairan_dana2[$jns_spp];
					//$Bulan_romawi = $Main->BulanRomawi[$tgl_pilih[1]];
						
					//Cari Data di t_spp
					$qry = $DataPengaturan->QyrTmpl1Brs($t_spp, "Id, nomor_spp", $where_data." ORDER BY substr(nomor_spp, 1, 4) DESC");$cek.=$qry["cek"];
					$aqry= $qry['hasil'];
					
					if($aqry['nomor_spp'] != NULL || $aqry['nomor_spp'] != ''){
						$ambil_no_spp = explode("/", $aqry['nomor_spp']);
						$no_spp_plh = intval($ambil_no_spp[0]);
						$hasil_no_spp = $no_spp_plh+1;
						if(strlen($hasil_no_spp) == 1)$hasil_no_spp="000".$hasil_no_spp;
						if(strlen($hasil_no_spp) == 2)$hasil_no_spp="00".$hasil_no_spp;
						if(strlen($hasil_no_spp) == 3)$hasil_no_spp="0".$hasil_no_spp;
						
						$no_spp = $hasil_no_spp;					
						
					}else{
						$no_spp = "0001";
					}
					$no_spp = $no_spp."/".$c1.".".$c.".".$d."/".$Kata_jns_spp."/".$tgl_pilih[0];
				}				
				$content=$no_spp;
				
				
			}
		}
		
		$err="";
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function getInformasi_jmlTrsd(){
		global $DataPengaturan, $Main;
		
		$cek='';$err='';$content;
		$c1 = cekPOST("c1nya");
		$c = cekPOST("cnya");
		$d = cekPOST("dnya");
		$e = cekPOST("enya");
		$e1 = cekPOST("e1nya");
		
		$hitung = $DataPengaturan->QryHitungData("t_penerimaan_barang", "WHERE pencairan_dana='1' AND sttemp='0' AND c1='$c1' AND c='$c' AND d='$d' AND Id NOT IN (SELECT refid_terima FROM t_spp  WHERE sttemp='0' AND refid_terima != '0' )");$cek.=$hitung["cek"];
		
		$content = "<span style='background-image:url(images/administrator/images/pemberitahuaan.png);width:40px;height:20px;float:right;text-align:center;color:white;font-weight:bold;font-size:14px;padding-top:2px;pading-left:15px;margin-top:-20px;position:static;'>".$hitung['hasil']."</span>";
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function BatalSemua(){
		$cek='';$err="";$content='';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_pil_nomorSPD(){
		global $DataPengaturan, $Main,$DataPermohonan;
		$cek='';$err="";$content='';
		
		$dt_Tmpl["refid_nomor_spd"]="";
		if(cekPOST2("databaru") == "2"){
			$idubah = cekPOST2("idubah");
			$qry_Tmpl = $DataPermohonan->Gen_QueryTabel_Spp($idubah);
			$dt_Tmpl = $qry_Tmpl["content"];
		}
		
		
		$c1=cekPOST2("c1nya");
		$c=cekPOST2("cnya");
		$d=cekPOST2("dnya");
		$refid_nomor_spd=cekPOST2("refid_nomor_spd",$dt_Tmpl["refid_nomor_spd"]);
		
		$tgl_spp=cekPOST2("tgl_spp")."-".cekPOST2("thn_spp");
		$tgl_spp=FormatTanggalnya($tgl_spp);
		
		$qry = "SELECT Id, nomor_spd FROM t_nomor_spd WHERE c1='$c1' AND c='$c' AND d='$d' AND tanggal_spd <= '$tgl_spp' ";$cek.=$qry;	
		$content = cmbQuery('refid_nomor_spd',$refid_nomor_spd,$qry, "style='width:300px;' onchange='".$this->Prefix.".Get_Tgl_nomorSPD();'","--- PILIH NOMOR SPD---")."</span> ";
			
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_Tgl_nomorSPD($IdNoSPD=''){
		global $DataPengaturan, $Main;
		$cek='';$err="";$content='';
		
		$IdNoSPD=$IdNoSPD == ""?cekPOST2("refid_nomor_spd"):$IdNoSPD;
		$qry = $DataPengaturan->QyrTmpl1Brs("t_nomor_spd", "tanggal_spd", "WHERE Id='$IdNoSPD' ");
		$dt = $qry["hasil"];
		$content=FormatTanggalnya($dt["tanggal_spd"]);
		$content=$content == "--"?"":$content;		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function GetNomorTagihan(){
		global $DataPengaturan, $Main;
		$cek='';$err="";$content="";
		
		$refid_nomor_tagihan = cekPOST2("refid_nomor_tagihan");
		$c1 = cekPOST2("c1nya");
		$c = cekPOST2("cnya");
		$d = cekPOST2("dnya");
		
		$qry = $DataPengaturan->QyrTmpl1Brs("ref_tagihan", "Id, no_tagihan", "WHERE Id='$refid_nomor_tagihan' AND c1='$c1' AND c='$c' AND d='$d' ");$cek.=$qry["cek"];
		$dt = $qry["hasil"];
		if($err=="" && ($dt["Id"] == NULL || $dt["Id"] == ""))$err="Nomor Tagihan Tidak Valid !";
		
		if($err == "")$content=$dt["no_tagihan"];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function GetData_Penerima(){
		global $DataPengaturan, $Main;
		$cek='';$err="";$content="";
		
		$refid_penyedia = cekPOST2("refid_penyedia");
		$refid_penyedia_jns = cekPOST2("refid_penyedia_jns");
		
		switch($refid_penyedia_jns){
			case "1":
				$qry = $DataPengaturan->QyrTmpl1Brs("ref_norek_bendahara","*","WHERE Id='$refid_penyedia' ");
				$dt=$qry["hasil"];
				$content["nama"]=$dt["nama"];
				$content["alamat"]=$dt["alamat"];
				$content["bank"]=$dt["bank"];
				$content["rekening"]=$dt["no_rekening"];
				$content["npwp"]=$dt["npwp"];
			break;
			case "2":
				$qry = $DataPengaturan->QyrTmpl1Brs("ref_penyedia","*","WHERE id='$refid_penyedia' ");
				$dt=$qry["hasil"];
				$content["nama"]=$dt["nama_penyedia"];
				$content["alamat"]=$dt["alamat"]." ".$dt["kota"];
				$content["bank"]=$dt["nama_bank"];
				$content["rekening"]=$dt["norek_bank"];
				$content["npwp"]=$dt["no_npwp"];
			break;
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_Query_NoSPD($Id, $refid_nomor_spd){
		global $DataPengaturan, $Main;
		$qry= $DataPengaturan->QyrTmpl1Brs("v1_nomor_spd_det", "*","WHERE Id='$Id' AND refid_nomor_spd='$refid_nomor_spd' ");
		
		return $qry;
	}
	
	function tabelRekening_Save(){
		global $DataPengaturan, $Main, $DataPermohonan;
		$cek='';$err="";$content=array();
		$UID = $_COOKIE['coID'];
		$Tbl_rek = $DataPermohonan->TblName_Rekening;
		
		$IdPilihnya = cekPOST2("IdPilihnya");
		$Jumlah = cekPOST2("jumlah_rek_".$IdPilihnya);
		$Id = cekPOST2($this->Prefix."_idplh");
		
		$where = "WHERE refid_spp='$Id' AND Id='$IdPilihnya' ";
		
		$qry = $DataPengaturan->QyrTmpl1Brs($Tbl_rek, "*", $where);$cek.=$qry["cek"];
		$dt = $qry["hasil"];
		if($err == "" && ($dt["Id"] == "" || $dt["Id"] == NULL))$err="Data Tidak Valid !";
		if($err == ""){
			if($dt["sttemp"] == "0"){
				$data_upd = array(array("status","2"));
				$data_ins = 
					array(
						array("bk",$dt["bk"]),array("ck",$dt["ck"]),array("dk",$dt["dk"]),
						array("p",$dt["p"]),array("q",$dt["q"]),
						array("k",$dt["k"]),array("l",$dt["l"]),array("m",$dt["m"]),
						array("n",$dt["n"]),array("o",$dt["o"]),
						array("jumlah",$Jumlah),	
						array("refid_spp",$dt["refid_spp"]),	
						array("jns_rek",$dt["jns_rek"]),	
						array("refid_nomor_spd",$dt["refid_nomor_spd"]),	
						array("refid_nomor_spd_det",$dt["refid_nomor_spd_det"]),	
						array("refid_terima",$dt["refid_terima"]),	
						array("refid_terima_det",$dt["refid_terima_det"]),	
						array("uid",$UID),array("status","0"),array("sttemp","1"),	
					);
				$qry_ins = $DataPengaturan->QryInsData($Tbl_rek, $data_ins);
			}else{
				$data_upd = array(array("jumlah",$Jumlah));
			}			
			$qry_upd = $DataPengaturan->QryUpdData($Tbl_rek, $data_upd, $where);
		}	
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function tabelRekening_Del(){
		global $DataPengaturan, $Main;
		$cek='';$err="";$content=array();
		$Idnya = cekPOST2("Idnya");
		
		$data = array(array("status","2"));		
		$qry_upd = $DataPengaturan->QryUpdData("t_spp_rekening",$data,"WHERE Id='$Idnya'");
		$cek.=$qry_upd["cek"];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function tabelRekening_Edit(){
		global $DataPengaturan, $Main;
		$cek='';$err="";$content=array();
		
		$Id_det = cekPOST2("Idnya");
		$Id = cekPOST2($this->Prefix."_idplh");
		
		$qry=$DataPengaturan->QyrTmpl1Brs("v1_spp_rekening","*","WHERE Id='$Id_det' AND refid_spp='$Id' AND status='0' ");
		$dt=$qry["hasil"];
		if($err == "" && ($dt["Id"] == NULL || $dt["Id"] == ""))$err = "Data Tidak Valid !";
		if($err == ""){							
			$content["jumlah"]=
				InputTypeText("jumlah_rek_".$dt["Id"],$dt['jumlah'],"style='text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah_".$dt["Id"]."`).innerHTML = DataPengaturan.formatCurrency(this.value);'").
				"<span id='formatjumlah_".$dt["Id"]."'></span>";
				
			$content["btn_option"]= BtnImgCancel($this->Prefix.".tabelRekening()");			
			$content["Btn_Pilih"]= BtnImgSave($this->Prefix.".tabelRekening_Save(".$dt["Id"].")'");
					
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function GetData_AfterIdPenerimaan_InsRek($dt){
		global $DataPengaturan, $DataPermohonan;
		$UID = $_COOKIE['coID'];
		$cek="";
		
		$Tbl_Rek = $DataPermohonan->TblName_Rekening;
		$Tbl_TerimaRek = $DataPermohonan->TblName_Terima_rek;
		
		$IdSPP = cekPOST2($this->Prefix."_idplh");
		
		//UPDATE t_spp_rekening
		$qry_upd = $DataPengaturan->QryUpdData($Tbl_Rek,array(array("status","2")), "WHERE refid_spp='$IdSPP' AND status='0' ");$cek.=$qry_upd["cek"];
		
		$data_ins = 
			array(
				array("bk",$dt["bk"]),array("ck",$dt["ck"]),array("dk",$dt["dk"]),array("p",$dt["p"]),array("q",$dt["q"]),
				array("refid_spp",$IdSPP),
				array("jns_rek","2"),
				array("refid_terima",$dt["Id"]),
				array("tahun",$dt["Id"]),
				array("uid",$UID),
				array("status","0"),
				array("sttemp","0"),
			);

		$qry_TerimaRek = "SELECT * FROM $Tbl_TerimaRek WHERE refid_terima='".$dt["Id"]."' AND sttemp='0' ";
		$cek.=$qry_TerimaRek;
		$aqry_TerimaRek = mysql_query($qry_TerimaRek);
		while($dt_Rek = mysql_fetch_assoc($aqry_TerimaRek)){
			$data_Rek = 
				array(
					array("k",$dt_Rek["k"]),
					array("l",$dt_Rek["l"]),
					array("m",$dt_Rek["m"]),
					array("n",$dt_Rek["n"]),
					array("o",$dt_Rek["o"]),
					array("jumlah",$dt_Rek["jumlah"]),
					array("refid_terima_det",$dt_Rek["Id"]),
				);	
			$qry_InsRek = $DataPengaturan->QryInsData($Tbl_Rek, array_merge($data_ins,$data_Rek)); 
			$cek.=" | ".$qry_InsRek["cek"];
		}		
		
		return $cek;
	}
	
	function GetData_AfterIdPenerimaan(){
		global $DataPengaturan, $Main, $DataPermohonan;
		$cek='';$err="";$content=array();
		$Tbl_Terima = $DataPermohonan->TblName_Terima;
		
		$refid_terima = cekPOST2("refid_terima");
		
		$qry = $DataPengaturan->QyrTmpl1Brs($Tbl_Terima,"*","WHERE Id='$refid_terima' ");
		$dt = $qry["hasil"];
		
		$content["id_penerimaan"]=$dt["id_penerimaan"];
		
		//PENYEDIA BARANG
		$qry_penyedia = $DataPengaturan->QyrTmpl1Brs("ref_penyedia","*","WHERE id='".$dt['refid_penyedia']."'");
		$dt_penyedia = $qry_penyedia["hasil"];
		
		//SET Rekeningnya
		$cek.=$this->GetData_AfterIdPenerimaan_InsRek($dt);
				
		$content["refid_penyedia"]=$dt_penyedia["id"];
		$content["nama_penerima_uang"]=$dt_penyedia["nama_penyedia"];
		$content["alamat_penerima_uang"]=$dt_penyedia["alamat"];
		$content["bank_penerima_uang"]=$dt_penyedia["nama_bank"];
		$content["rek_penerima_uang"]=$dt_penyedia["norek_bank"];
		$content["npwp_penerima_uang"]=$dt_penyedia["no_npwp"];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function getSisaSPD(){
		global $DataPengaturan, $Main, $DataPermohonan;
		$cek='';$err="";$content="";
		
		$Tbl_Rek = $DataPermohonan->TblName_Rekening;
		$vSPDdet = $DataPermohonan->View_NomorSPD_det;
		
		$IdSPDnya = cekPOST2("IdSPDnya");
		$IdRekSPP = cekPOST2("IdRekSPP");
		$Idplh = cekPOST2($this->Prefix."_idplh");
		
		if($err == "" && $IdSPDnya == "")$err="Tidak Ada Nomor SPD !";
		
		if($err == ""){
			$data_where = 
				array(
					array("sttemp","0"),
					array("refid_nomor_spd_det",$IdSPDnya),
					array("Id",$IdRekSPP," != "),
				);
			$qry_rek = $DataPengaturan->QyrTmpl1Brs2($Tbl_Rek, "IFNULL(SUM(jumlah),0) as tot_jml", $data_where);
			$cek.=$qry_rek["cek"];
			$dt_rek = $qry_rek["hasil"];
			
			$qry_jmlspd = $DataPengaturan->QyrTmpl1Brs($vSPDdet, "total", "WHERE Id='$IdSPDnya' ");
			$cek.=$qry_jmlspd["cek"];
			$dt_spd = $qry_jmlspd["hasil"];
			
			$content = $dt_spd["total"] - $dt_rek["tot_jml"];
			$content = BtnText(FormatUang($content),$this->Prefix.".getSisaSPD($IdSPDnya, $IdRekSPP);");
		}
				
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Gen_KodeRek_SPPUP(){
		global $Main;
		$KdRek = $Main->KODE_KAS_BENDAHARA_KELUAR_BANK;
		$dtRek = explode(".",$KdRek);
		$dt["k"] = $dtRek[0];
		$dt["l"] = $dtRek[1];
		$dt["m"] = $dtRek[2];
		$dt["n"] = $dtRek[3];
		$o = $dtRek[4];
		$dt["o"] = $Main->REK_DIGIT_O == 0?substr($o,1,2):$o;
		
		return $dt;
	}
	
	function Set_JNS_SPP_UP($dt){
		global $DataPengaturan, $HTTP_COOKIE_VARS, $DataPermohonan;
		$cek="";$err="";$content="";
		$uid = $HTTP_COOKIE_VARS['coID'];
		//INSERT REKENING
		$dtRek = $this->Gen_KodeRek_SPPUP();
		
		$data_ins = 
			array(
				array("k",$dtRek["k"]),array("l",$dtRek["l"]),array("m",$dtRek["m"]),
				array("n",$dtRek["n"]),array("o",$dtRek["o"]),
				array("refid_spp",$dt["Id"]),array("jns_rek","3"),array("uid",$uid),array("status","0"),array("sttemp","1"),
			);
		$qry_ins = $DataPengaturan->QryInsData($DataPermohonan->TblName_Rekening, $data_ins);$cek.=$qry_ins["cek"];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function tabelRekening_SPPUP(){
		global $DataPermohonan, $DataPengaturan;
		$cek="";$err="";$content="";
		$css_class = "class='GarisDaftar'";
		$idplh = cekPOST2($this->Prefix."_idplh");
		$Get_DataSPP = $DataPermohonan->Gen_QueryTabel_Spp($idplh);
		$dt_SPP = $Get_DataSPP["content"];
		
		if($err == "" && ($dt_SPP["Id"] == "" || $dt_SPP["Id"] == NULL))$err = "Data Tidak Valid !";
		if($err == "" && $dt_SPP["jns_spp"] != "2")$err = "Data Tidak Valid !";
		
		if($err == ""){
			$qry_Rek = $DataPengaturan->QyrTmpl1Brs($DataPermohonan->View_SPPRek2, "*", "WHERE refid_spp='".$dt_SPP["Id"]."' AND status='0' ");
			$dt_Rek = $qry_Rek["hasil"];
			$kdRek = $DataPengaturan->Gen_valRekening($dt_Rek);
			$fm_IsiJumlah = 
				InputTypeText("fm_jumlah_rek", $dt_Rek["jumlah"], "style='text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = `<br>`+DataPengaturan.formatCurrency(this.value);'").
				LabelSPan1("formatjumlah","<br>".FormatUang($dt_Rek["jumlah"]));
					
			$content =
			genFilterBar(array(BtnText("REKENING", $this->Prefix.".tabelRekening_SPPUP();","style='color:black;font-size:14px;font-weight:bold;'")),'','','').
			genFilterBar(array("
				<table class='koptable' style='min-width:1024px;' border='1'>
					<tr>
						<th class='th01' width='25'>NO</th>
						<th class='th01' width='75'>REKENING</th>
						<th class='th01'>URAIAN</th>
						<th class='th01' width='150px'>JUMLAH (Rp)</th>		
					</tr>
					<tr class='row0'>".
						Tbl_Td("1", "right", $css_class).				
						Tbl_Td($kdRek, "center", $css_class).				
						Tbl_Td($dt_Rek["nm_rekening"], "left", $css_class).				
						Tbl_Td($fm_IsiJumlah, "right", $css_class).				
					"</tr>
				</table>"
			),'','','');
		}
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
}
$suratpermohonan_spp = new suratpermohonan_sppObj();
?>