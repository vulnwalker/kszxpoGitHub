<?php
	include "pages/keuangan/daftarsuratpermohonan.php";
 	$DataPermohonan = $daftarsuratpermohonan;
	
class suratpermohonan_sp2dObj  extends DaftarObj2{	
	var $Prefix = 'suratpermohonan_sp2d';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_program'; //bonus
	var $TblName_Hapus = 'ref_program';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('bk','ck','dk','p');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'SURAT PERMOHONAN';
	var $PageIcon = 'images/order1.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pemasukan.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'Pemasukan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'suratpermohonan_sp2dForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	function setTitle(){
		return 'SURAT PERINTAH PENCAIRAN DANA (SP2D)';
	}
	
	function setMenuEdit(){
		return "";
	}
	
	function SimpanSemua_GetNomor_BKU(){
		$GetNomorBKU = $this->GetNomorBKU();
		$NomorBKU = intval($GetNomorBKU["content"]);
		
		return $NomorBKU;
	}
	
	function SimpanSemua(){
		global $HTTP_COOKIE_VARS, $Main, $DataPengaturan, $DataPermohonan;
		
		$t_spp = $DataPermohonan->TblName_N;
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		$thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//Get Data -----------------------------------------
		$IdSPP = cekPOST2("IdSPP");
		$tgl_sp2d = FormatTanggalnya(cekPOST2("tgl_sp2d")."-".$thn_anggaran);
		$refid_bank = cekPOST2("refid_bank");
		$uraian = cekPOST2("uraian");
		$refid_ttd_sp2d = cekPOST2("refid_ttd_sp2d");
		$nomor_sp2d_no = cekPOST2("nomor_sp2d_no");
		
		if($err == "" && $IdSPP == "")$err="Nomor SPP Belum di Pilih !";
		if($err == "" && intval($nomor_sp2d_no) == 0)$err="Nomor SP2D Belum di Isi !";
		if($err == "" && !cektanggal($tgl_sp2d))$err="Tanggal SP2D Tidak Valid !";
		if($err == "" && $refid_bank=="")$err="Bank Pembayar Belum di Pilih !";
		if($err == "" && $refid_ttd_sp2d=="")$err="Penandatanganan Belum di Pilih !";
		if($err == ""){
			$Getnomor_sp2d = $this->getNomorSP2D();
			$nomor_sp2dDet = $Getnomor_sp2d["content"];
			$nomor_sp2d = $nomor_sp2d_no.$nomor_sp2dDet["ket"];
			$qry_cek = $DataPengaturan->QryHitungData($t_spp, "WHERE Id!='$IdSPP' AND nomor_sp2d='$nomor_sp2d'");
			if($qry_cek["hasil"] > 1)$err="Nomor SP2D sudah di Gunakan !";
		}
		if($err == ""){
			$data = array(
						array("nomor_sp2d", $nomor_sp2d),
						array("tgl_sp2d", $tgl_sp2d),
						array("uraian_sp2d", $uraian),
						array("refid_bank", $refid_bank),
						array("refid_ttd_sp2d", $refid_ttd_sp2d),
						array("uid_sp2d", $uid),
						array("status_sp2d", 1),
						array("status", "4"),
						array("nomor_bku", $this->SimpanSemua_GetNomor_BKU()),
					);	
					
			$qry = $DataPengaturan->QryUpdData("t_spp", $data, "WHERE Id='$IdSPP' ");$cek.=$qry["cek"];
			//$err=$qry["cek"];
		} 
					
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
		
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function set_selector_other($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	  
	  switch($tipe){	
		case 'formBaru'					 : $fm = $this->setFormBaru();break;
		case 'formEdit'					 : $fm = $this->setFormEdit();break;
		case 'SimpanSemua'				 : $fm = $this->SimpanSemua();break;
		case 'Get_DataSPP'				 : $fm = $this->Get_DataSPP();break;
		case 'getNomorSP2D'				 : $fm = $this->getNomorSP2D();break;
		case 'GetNomorBKU'				 : $fm = $this->GetNomorBKU();break;
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
							".$this->Prefix.".loading();
						});
					</script>";
		return 	
			fn_TagScript("js/pencarian/DataPengaturan.js").
			fn_TagScript("js/pencarian/cariIdSPP.js").
			fn_TagScript("js/keuangan/suratpermohonan_spm.js").
			fn_TagScript("js/keuangan/".strtolower($this->Prefix).".js").
			$DataPengaturan->Gen_Script_DatePicker().
			$scriptload;
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
		$aqry = "SELECT * FROM  ref_satuan WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
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
		$Id = $dt['Id'];			
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
	return "";
			/*"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=bagian\" title='Organisasi' >Organisasi</a> |
	<A href=\"pages.php?Pg=pegawai\" title='Pegawai' >Pegawai</a> |
	<A href=\"pages.php?Pg=barang\" title='Barang'>Barang</a> |
	<A href=\"pages.php?Pg=jenis\" title='Jenis'  >Jenis</a> |
	<A href=\"pages.php?Pg=satuan\" title='Satuan' style='color:blue' >Satuan</a> 
	&nbsp&nbsp&nbsp	
	</td></tr></table>";*/
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
	  	   <th class='th01' width='5'>No.</th>".
	  	   /*$Checkbox*/"		
		   <th class='th01'>Kode</th>
		   <th class='th01'>Program</th>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 $bk = $isi['bk'];
	 if(strlen($bk) == 1)$bk = "0".$bk;
	 
	 $ck = $isi['ck'];
	 if(strlen($ck) == 1)$ck = "0".$ck;
	 
	 $dk = $isi['dk'];
	 if(strlen($dk) == 1)$dk = "0".$dk;
	 
	 $p = $isi['p'];
	 if(strlen($p) == 1)$p="0".$p;
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  /*if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);*/
	 $Koloms[] = array('align="center" width="15%"',"<a href='javascript:".$this->Prefix.".pilProg(`".$isi['bk']."`,`".$isi['ck']."`,`".$isi['dk']."`,`".$isi['p']."`)' >".$bk.".".$ck.".".$dk.".".$p."</a>");
	 $Koloms[] = array('align="left"', $isi['nama'] );
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	  global $Ref, $Main, $HTTP_COOKIE_VARS, $DataPengaturan,$DataOption, $DataPermohonan;
	 $databaru = cekPOST2("databaru");
	 $thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 
	if($databaru == '2'){
		$Idplh = cekPOST("idubah");
		$qry_det = $DataPermohonan->Gen_QueryTabel_Spp($Idplh);$cek.=$qry_det["cek"];
		$dt = $qry_det["content"];
		
		$getTgl_SP2D = $dt['tgl_sp2d'] == "" || $dt['tgl_sp2d'] == "0000-00-00"?date("Y-m-d"):$dt['tgl_sp2d'];
		
		$dt_penyedia = $DataPermohonan->Get_PenerimaUang($dt['refid_penyedia'], $dt["refid_penyedia_jns"]);
		
	}	
	
	//Deklarasi SKPD
	$IdSPP = $databaru == '2'?$dt["Id"]:"";
	
	$c1 = $databaru == '2'?$dt["c1"]:cekPOST2("c1");
	$c = $databaru == '2'?$dt["c"]:cekPOST2("c");
	$d = $databaru == '2'?$dt["d"]:cekPOST2("d");
	$e = $databaru == '2'?$dt["e"]:cekPOST2("e");
	$e1 = $databaru == '2'?$dt["e1"]:cekPOST2("e1");
	
	$BTN_CR_no_spm= $databaru=="1"?InputTypeButton("cariNoSPM","CARI","onclick='".$this->Prefix.".CariIdSPP()'"):"";
	
	$tgl_sp2d = $databaru == "2"?FormatTanggalBulan($getTgl_SP2D):date("d-m");
	$thn_sp2d = $databaru == "2"?GetTahunFromDB($getTgl_SP2D):$thn_anggaran;	
		
	//Query
	$qry_ref_bank = "SELECT Id, nm_bank FROM ref_bank";
	$qry_ttd = "SELECT Id, nama FROM ref_tandatangan WHERE c1='$c1' AND c='$c' AND d='$d' AND kategori_tandatangan='$DataPengaturan->kat_TTD_SP2D' ";
	
	//STYLE -------------------------------------------------------------------------------------------------
	$style1_RdOnly="readonly style='width:300px;'";
	$style2_RdOnly="readonly style='width:200px;text-align:right;'";
	
	$TampilOpt =
		"<tr><td>".
		$vOrder=
		$DataPengaturan->GenViewHiddenSKPD($c1, $c, $d, $e, $e1).			
		$DataPengaturan->GenViewSKPD($c1, $c, $d, $e, $e1).
		genFilterBar(
			array(
				$DataPengaturan->isiform(
					array(
						array(
							'label'=>'NOMOR SPM',
							'label-width'=>'200px;',
							'value'=>InputTypeText("nomor_spm", $nomor_spm, $style1_RdOnly)." ".
									 $BTN_CR_no_spm.
									 InputTypeHidden("IdSPP",$IdSPP),
						),
						array(
							'label'=>'NILAI SPM',
							'value'=>InputTypeText("nilai_spm","", $style2_RdOnly." placeholder='NILAI SPM'"),
						),
						array(
							'label'=>'POTONGAN SPM',
							'value'=>InputTypeText("potongan_spm","", $style2_RdOnly." placeholder='POTONGAN SPM'"),
						),
						array(
							'label'=>'YANG DIBAYAR',
							'value'=>InputTypeText("ygdibayar_spm","", $style2_RdOnly." placeholder='YANG DIBAYAR'"),
						),
						array(
							'label'=>'NOMOR SP2D',
							'value'=>
								InputTypeText("nomor_sp2d_no", "", 'style="width:40px;text-align:right;"')." ".
								InputTypeText("nomor_sp2d_ket", "", 'style="width:157px;" readonly'),
						),
						array(
							'label'=>'TANGGAL SP2D',
							'value'=>
								InputTypeText("tgl_sp2d",$tgl_sp2d,"placeholder='TANGGAL' maxlength='5' style='width:40px;' class='datepicker2' " )." ".
								InputTypeText("thn_sp2d",$thn_sp2d,"placeholder='TAHUN' maxlength='4' style='width:40px;' readonly" ),
						),
						array(
							'label'=>'NOMOR BKU',
							'label-width'=>'200px;',
							'value'=>InputTypeText("nomor_bku", "", "readonly style='width:80px;text-align:right;'"),
						),
						array(
							'label'=>'BANK PEMBAYAR',
							'label-width'=>'200px;',
							'value'=>cmbQuery("refid_bank","",$qry_ref_bank," style='width:300px;'", "--- PILIH BANK ---"),
						),
						array(
							'label'=>'URAIAN',
							'label-width'=>'200px;',
							'value'=>InputTypeTextArea("uraian",$uraian," style='width:300px;height:50px;'"),
						),
						array(
							'label'=>'<b>PENANDATAGANAN</b>',
							'pemisah'=>'',
						),
						array(
							'label'=>'<span style="margin-left:10px;">NAMA</span>',
							'label-width'=>'200px',
							'value'=>
									cmbQuery("refid_ttd_sp2d", $penandatanganan_nama, $qry_ttd," style='width:300px;' onchange='suratpermohonan_spm.Get_PenandatanganSPM(`".$this->Prefix."Form`);'","--- PILIH PENANDATANGAN ---",""),
						),
						array(
							'label'=>'<span style="margin-left:10px;">NIP</span>',
							'label-width'=>'200px',
							'value'=>
									InputTypeText("penandatanganan_nip",$penandatanganan_nip,$style1_RdOnly." placeholder='NIP'"),
						),
						array(
							'label'=>'<span style="margin-left:10px;">JABATAN</span>',
							'label-width'=>'200px',
							'parrams'=>"style='width:300px;' readonly placeholder='REKENING'",
							'value'=>
									InputTypeText("penandatanganan_jabatan",$penandatanganan_jabatan,$style1_RdOnly." placeholder='JABATAN'"),
						),
					)
				)
			)
		,'','','').
		genFilterBar(
			array(				
				"<table>
					<tr>							
						<td>".$DataPengaturan->buttonnya($this->Prefix.'.SimpanSemua()','checkin.png','SIMPAN','SIMPAN','SIMPAN')."</td>
						<td>".$DataPengaturan->buttonnya($this->Prefix.'.BatalSemua()','cancel_f2.png','BATAL','BATAL','BATAL')."</td>
					</tr>".
				"</table>"	
			),'','','')
		;
	;
			
			
		return array('TampilOpt'=>$TampilOpt);
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
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		$kodeprogram = $_REQUEST['kodeprogram'];
		//cari tgl,bln,thn
		$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];			
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
		//Cari 
		$kodePRG = explode(".",$kodeprogram);
		$bk = '';
		$ck = '';
		$dk = '';
		$p = '';
		if(isset($kodePRG[0]) && $kodePRG[0]!='')$bk = intval($kodePRG[0]);
		if(isset($kodePRG[1]))$ck = intval($kodePRG[1]);
		if(isset($kodePRG[2]))$dk = intval($kodePRG[2]);
		if(isset($kodePRG[3]))$p = intval($kodePRG[3]);
		/*switch($fmPILCARI){			
			case 'selectSatuan': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;						 	
		}
		
		
		if(!empty($fmFiltTglBtw_tgl1)) $arrKondisi[]= " tgl_daftar>='$fmFiltTglBtw_tgl1'";
		if(!empty($fmFiltTglBtw_tgl2)) $arrKondisi[]= " tgl_daftar<='$fmFiltTglBtw_tgl2'";	*/
		$bk="$bk";
		$ck="$ck";
		$dk="$dk";
		$p="$p";
		
		/*$kodenya = "";
		if($bk == '')$kodenya.=$bk;
		if($ck != '')$kodenya.=".".$ck;
		if($dk != '')$kodenya.=".".$dk;
		if($p != '')$kodenya.=".".$pk;*/
				
		if($fmPILCARIvalue !='')$arrKondisi[] = " nama like '%$fmPILCARIvalue%' ";
		if($kodenya !='')$arrKondisi[] = " CONCAT(bk,'.',ck,'.',dk,'.',p) like '%$kodenya%' ";
		if($bk != '')$arrKondisi[] = "bk='$bk' ";
		if($ck != '')$arrKondisi[] = "ck='$ck' ";
		if($dk != '')$arrKondisi[] = "dk='$dk' ";
		if($p != '')$arrKondisi[] = "p='$p'";
		
		$arrKondisi[] = " q='0'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		if($fmORDER1 == ''){
			$arrOrders[] = " bk ";
			$arrOrders[] = " ck ";
			$arrOrders[] = " dk ";
			$arrOrders[] = " p ";
		}
		switch($fmORDER1){
			case '1': $arrOrders[] = " p $Asc1 " ;break;
		}	
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		
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
	function setMenuView(){
		return "";
	}
	/*function setTopBar(){
	   	return '';
	}*/	
	
	function Get_DataSPP(){
		global $DataPermohonan;
		$err="";$cek='';$content=array();
		
		$Idplh = cekPOST2("IdSPP");
		$qry_det = $DataPermohonan->Gen_QueryTabel_Spp($Idplh);$cek.=$qry_det["cek"];		
		$content = $qry_det["content"];		
		
		$NilaiSPM = $DataPermohonan->Get_QueryTotalRekSPP($Idplh);
		$PotonganSPM = $DataPermohonan->Get_QueryTotalPotongan_SPP($Idplh);
		$ygdibayar_spm = $NilaiSPM-$PotonganSPM;
			
		//$content["nilai_spm"] = $NilaiSPM;	
		$content["nilai_spm"] = FormatUang($NilaiSPM);
		$content["potongan_spm"] = FormatUang($PotonganSPM);
		$content["ygdibayar_spm"] = FormatUang($ygdibayar_spm);
		
		$dt_penyedia = $DataPermohonan->Get_PenerimaUang($content['refid_penyedia'], $content["refid_penyedia_jns"]);
		$content["uraian"] = $content["uraian_sp2d"]==""?$content["uraian_spm"]:$content["uraian_sp2d"];	
		$content["nama_penerima_uang"] = $dt_penyedia["nama"];
		$content["bank_penerima_uang"] = $dt_penyedia["bank"];
		$content["rek_penerima_uang"] = $dt_penyedia["no_rekening"];
		$content["npwp_penerima_uang"] = $dt_penyedia["npwp"];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function getNomorSP2D(){
		global $DataPengaturan, $Main, $DataPermohonan, $HTTP_COOKIE_VARS;
		
		$proses=TRUE;
		$thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$no_spm = "";
		$cek='';$err='';$content='';
		$tgl_sp2d = FormatTanggalnya(cekPOST2("tgl_sp2d")."-".$thn_anggaran);
		$c1 = cekPOST2("c1nya");
		$c = cekPOST2("cnya");
		$d = cekPOST2("dnya");
		$IdSPP = cekPOST2("IdSPP");
		
		$qry_spp = $DataPermohonan->Gen_QueryTabel_Spp($IdSPP);$cek.=$qry_spp["cek"];
		$dt_spp = $qry_spp["content"];
		
		if($proses == TRUE && $IdSPP == "")$proses=FALSE;
		if($proses == TRUE && ($dt_spp["Id"] == "" && $dt_spp["Id"] == NULL))$proses=FALSE;
		if($proses == TRUE && !cektanggal($tgl_sp2d))$proses=FALSE;
		$content["no"]="";
		$content["ket"]="";
		if($proses == TRUE){			
			if($dt_spp["nomor_sp2d"] == "" ||$dt_spp["nomor_sp2d"] == NULL){
				$data_cari = array(
								array("Id", $dt_spp["Id"], "!="),
								array("sttemp", "0"),
								array("nomor_sp2d", "", "!="),
								array("c1", $c1),
								array("c", $c),
								array("d", $d),
								array("status", "3", ">="),
								array("jns_spp", $dt_spp["jns_spp"]),
								array("tahun", $thn_anggaran),
							);
				$qry = $DataPengaturan->QyrTmpl1Brs2("t_spp", "Id, nomor_sp2d", $data_cari," ORDER BY substr(nomor_sp2d, 1, 4) DESC");$cek.=$qry["cek"];
				$dt = $qry["hasil"];
				
				$jenis_spp = $DataPengaturan->Daftar_arr_pencairan_dana_SP2D2[$dt_spp["jns_spp"]];
				if($dt["Id"] == "" || $dt["Id"] == NULL){
					$NoSP2D = "0001";
				}else{
					$getNoSP2D = explode("/", $dt["nomor_sp2d"]);
					$NoSP2D = intval($getNoSP2D[0]) + 1;
					if(strlen($NoSP2D) == 1)$NoSP2D="000".$NoSP2D;
					if(strlen($NoSP2D) == 2)$NoSP2D="00".$NoSP2D;
					if(strlen($NoSP2D) == 3)$NoSP2D="0".$NoSP2D;
				}
				$no_sp2d="$NoSP2D/$c1.$c.$d/$jenis_spp/$thn_anggaran";
			}else{
				$no_sp2d=$dt_spp["nomor_sp2d"];
			}
			$noSP2Dnya = explode("/",$no_sp2d);
			$content["no"]=$noSP2Dnya[0];
			$content["ket"]="/".$noSP2Dnya[1]."/".$noSP2Dnya[2]."/".$noSP2Dnya[3];
		}		
		
		return	array ('cek'=>$tgl_sp2d, 'err'=>$err, 'content'=>$content);
	}
	
	function GetNomorBKU(){
		global $DataPengaturan, $Main, $DataPermohonan, $HTTP_COOKIE_VARS;
		$cek="";$err="";$content="0";
		
		$TblBKU = $DataPermohonan->TblName_BKU;
		
		$c1 = cekPOST2("c1nya");
		$c = cekPOST2("cnya");
		$d = cekPOST2("dnya");
		$e = cekPOST2("enya");
		$e1 = cekPOST2("e1nya");
		$IdSPP = cekPOST2("IdSPP");
		$jns_spp = cekPOST2("haljns_sppnya");
		
		if($jns_spp != "2" && $err=="")$err="Data Tidak Valid";
		if($err == ""){
			$qry_rek = $DataPengaturan->QyrTmpl1Brs($DataPermohonan->TblName_Rekening, "Id, tahun", "WHERE refid_spp='$IdSPP' AND sttemp='0' ");$cek.=$qry_rek["cek"];
			$dt_rek = $qry_rek["hasil"];
			$data = array(array("c1",$c1),array("c",$c),array("d",$d),array("tahun",$dt_rek["tahun"]));
			
			//Cek Apakaha Ada nomorBKU ----------------------------------------------------------------------------
			$data1 =  array(array("refid",$IdSPP),array("jns","1"));
			$qry_BKUcek = $DataPengaturan->QyrTmpl1Brs2($TblBKU, "nomor_bku", array_merge($data, $data1), "ORDER BY nomor_bku DESC ");$cek.=$qry_BKUcek["cek"];
			$dt_BKUcek = $qry_BKUcek["hasil"];
			
			if(intval($dt_BKUcek["nomor_bku"]) == 0){
				$qry = $DataPengaturan->QyrTmpl1Brs2($TblBKU, "nomor_bku", $data, "ORDER BY nomor_bku DESC ");$cek.=$qry["cek"];
				$dt = $qry["hasil"];			
				$nomor = intval($dt["nomor_bku"])+1;
			}else{
				$nomor = $dt_BKUcek["nomor_bku"];
			}
			
			$content = Format4Digit($nomor);
		}
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
}
$suratpermohonan_sp2d = new suratpermohonan_sp2dObj();
?>