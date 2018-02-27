<?php

include "pages/keuangan/daftarsuratpermohonan.php";
$DataSurat = $daftarsuratpermohonan;

class carino_spd_detObj  extends DaftarObj2{	
	var $Prefix = 'carino_spd_det';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'v1_nomor_spd_det'; //bonus
	var $TblName_Hapus = 't_nomor_spd_det';
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
	var $PageIcon = 'images/pengadaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal =100;
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pemasukan.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'Pemasukan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'carino_spd_detForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	var $kode_prog = "";
	var $kode_kegiatan = "";
	var $pid_urutan = 0;
	var $pid_nomor = 0;
	
	var $kdRek = array();
	var $Arr_IdSPD_det = array();
	
	var $cb_urut = 0;
	
	function setTitle(){
		return 'PENERIMA PIHAK KE-3';
	}
	
	/*function setMenuEdit(){
		return "";
	}
	*/
	function setMenuView(){
		return "";
	}
	
	function simpan(){
	 global $HTTP_COOKIE_VARS, $DataPengaturan;
	 
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = cekPOST2("idplh");
	 
	 $c1= cekPOST2('c1nya');
	 $c= cekPOST2('cnya');
	 $d= cekPOST2('dnya');
	 
	 $namapenyedia= cekPOST2('namapenyedia');
	 $alamatpenyedia= cekPOST2('alamatpenyedia');
	 $kotapenyedia= cekPOST2('kotapenyedia');
	 $namapimpinan= cekPOST2('namapimpinan');
	 $nonpwp= cekPOST2('nonpwp');
	 $norekeningbank= cekPOST2('norekeningbank');
	 $namabank= cekPOST2('namabank');
	 $atasnamabank= cekPOST2('atasnamabank');
	  
	 if($err=='' && $namapenyedia =='' ) $err= 'Nama Belum Di Isi !!';
	 if($err=='' && $namapimpinan =='' ) $err= 'Nama Pimpinan Belum Di Isi !!';
	 if($err=='' && $nonpwp =='' ) $err= 'Nomor NPWP Belum Di Isi !!';
	 if($err=='' && $norekeningbank =='' ) $err= 'Nomor Rekening Belum Di Isi !!';
	 if($err=='' && $namabank =='' ) $err= 'Nama Bank Belum Di Isi !!';
	 if($err=='' && $atasnamabank =='' ) $err= 'Atas Nama Bank Belum Di Isi !!';
	 
	 if($err == ""){
	 	$data = array(
					array("nama_penyedia",$namapenyedia),
					array("alamat",$alamatpenyedia),
					array("kota",$kotapenyedia),
					array("nama_pimpinan",$namapimpinan),
					array("no_npwp",$nonpwp),
					array("nama_bank",$namabank),
					array("norek_bank",$norekeningbank),
					array("atasnama_bank",$atasnamabank),
				);
		
		if($fmST == "0"){
			array_push($data,
					array("c1",$c1),
					array("c",$c),
					array("d",$d)
				);
			$qry = $DataPengaturan->QryInsData("ref_penyedia",$data);
		}else{
			$qry = $DataPengaturan->QryUpdData("ref_penyedia",$data,"WHERE id='$idplh'");
		}
		
		$cek.=$qry["cek"];
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
		case 'formBaru'		: $fm = $this->setFormBaru();break;		
		case 'formEdit'		: $fm = $this->setFormEdit();break;
		case 'simpan'		: $fm = $this->simpan();break;
		case 'windowshow'	: $fm = $this->windowShow();break;
		case 'pilData'		: $fm = $this->pilData();break;	   
		case 'Set_cb_Temp'	: $fm = $this->Set_cb_Temp();break;	   
		case 'windowBatal'	: $fm = $this->windowBatal();break;	   
		case 'windowSimpan'	: $fm = $this->windowSimpan();break;	   
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
			fn_TagScript('js/pencarian/DataPengaturan.js').
			fn_TagScript('js/pencarian/'.strtolower($this->Prefix).'.js').
			$DataPengaturan->Gen_Script_DatePicker().
			$scriptload;
	}
	
	//form ==================================
	function setFormBaru(){
		global $Ref, $Main, $HTTP_COOKIE_VARS;
		$dt=array();
		$cek = '';$err='';
		
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		 //set waktu sekarang
		
		$dt['tgl'] = date("d-m-Y");
		$dt['c1'] = cekPOST2('c1');
		$dt['c'] = cekPOST2('c');
		$dt['d'] = cekPOST2('d');
		
		if($err == '')$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}
   
  	function setFormEdit(){
		global $Ref, $Main, $HTTP_COOKIE_VARS, $DataPengaturan;
		$dt=array();
		$cek = '';$err='';
		
		$cbid = $_REQUEST[$this->Prefix."_cb"];
		$Id = $cbid[0];
		
		$this->form_idplh =$Id_penyedia;
		$this->form_fmST = 1;
		 //set waktu sekarang
		$qry = $DataPengaturan->QyrTmpl1Brs("ref_penyedia", "*", "WHERE Id='$Id' ");
		$dt = $qry["hasil"];
		
		
		if($err == '')$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp, $Ref, $Main, $HTTP_COOKIE_VARS;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 470;
	 $this->form_height = 300;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU PENERIMA PIHAK KE-3';
		$nip	 = '';
	  }else{
		$this->form_caption = 'UBAH PENERIMA PIHAK KE-3';			
		$Id = $dt['Id'];			
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			'namapenyedia' => array( 
						'label'=>'NAMA',
						'labelWidth'=>150, 
						'value'=>$dt["nama_penyedia"], 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='NAMA'"
						 ),
			'alamatpenyedia' => array( 
						'label'=>'ALAMAT LENGKAP',
						'labelWidth'=>150, 
						'value'=>"<textarea name='alamatpenyedia' id='alamatpenyedia' style='width:270px;height:50px;' placeholder='ALAMAT LENGKAP'>".$dt["alamat"]."</textarea>",
						 ),
			'kotapenyedia' => array( 
						'label'=>'KOTA / KABUPATEN',
						'labelWidth'=>150, 
						'value'=>$dt["kota"], 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='KOTA / KABUPATEN'"
						 ),
			'namapimpinan' => array( 
						'label'=>'NAMA PIMPINAN',
						'labelWidth'=>150, 
						'value'=>$dt["nama_pimpinan"], 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='NAMA PIMPINAN'"
						 ),
			'nonpwp' => array( 
						'label'=>'NO NPWP',
						'labelWidth'=>150, 
						'value'=>$dt["no_npwp"], 
						'type'=>'text',
						'param'=>"style='width:270px;' maxlength='25' placeholder='NO NPWP'"
						 ),
			'norekeningbank' => array( 
						'label'=>'NO REKENING BANK',
						'labelWidth'=>150, 
						'value'=>$dt["norek_bank"], 
						'type'=>'text',
						'param'=>"style='width:270px;' maxlength='30' placeholder='NO REKENING BANK'"
						 ),
			'namabank' => array( 
						'label'=>'NAMA BANK',
						'labelWidth'=>150, 
						'value'=>$dt["nama_bank"], 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='NAMA BANK'"
						 ),
			'atasnamabank' => array( 
						'label'=>'ATAS NAMA BANK',
						'labelWidth'=>150, 
						'value'=>$dt["atasnama_bank"], 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='ATAS NAMA BANK'"
						 ),
			);
		//tombol
		$this->form_menubawah =
			InputTypeHidden("idplh",$dt['id']).
			InputTypeHidden("c1nya",$dt['c1']).
			InputTypeHidden("cnya",$dt['c']).
			InputTypeHidden("dnya",$dt['d']).
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
	  	   <th class='th01' width='5'>No.</th>
	  	   <th class='th01' width='5'></th>
	  	   ".
		  // $Checkbox.
		   "		
		   <th class='th01' width='80px;'>REKENING</th>
		   <th class='th01'>URAIAN</th>
		   <th class='th01' width='120px;'>JUMLAH SPD</th>
	   </thead>";
	 
		return $headerTable;
	}
	
	function setKolomData_cb_CHECKED($id){
		global $DataPengaturan;
		$cek = "";
		
		$IdTemp_data=cekPOST2("IdTemp_data");
		$qry_hit= $DataPengaturan->QryHitungData($DataPengaturan->Tbl_Temp_det, "WHERE refid='$id' AND refid_temp_data='$IdTemp_data' ");
		if($qry_hit["hasil"] > 0)$cek=" checked ";
		
		return $cek;
	}
	
	function setKolomData_cb($no, $isi, $Mode, $TampilCheckBox, $cssclass){
		$cb = "<input type='checkbox' name='".$this->Prefix."_cb[]' id='".$this->Prefix."_cb".$this->cb_urut."' value='".$isi["Id"]."' onclick='isChecked2(this.checked,`carino_spd_det_jmlcek`);".$this->Prefix.".cbxPilih(this);".$this->Prefix.".Set_cb_Temp(".$isi["Id"].",".$this->cb_urut.")' ".$this->setKolomData_cb_CHECKED($isi['Id'])." />";		
		
		$Koloms.=$this->pid_urutan%2==0?"<tr class='row0'>":"<tr class='row1'>";
		$Koloms.=$this->pid_nomor==0?Tbl_Td($no,"right",$cssclass):Tbl_Td("","right",$cssclass);			
		if($Mode == 1)$Koloms.=$this->pid_nomor==0?Tbl_Td($cb,"center",$cssclass):Tbl_Td("","right",$cssclass);
		$this->cb_urut++;
		return $Koloms;	
	}
	
	function set_KolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass){
		$Koloms="";
		
		$Koloms.=$this->pid_urutan%2==0?"<tr class='row0'>":"<tr class='row1'>";
		$Koloms.=$this->pid_nomor==0?Tbl_Td($no,"right",$cssclass):Tbl_Td("","right",$cssclass);			
		if($Mode == 1)$Koloms.=$this->pid_nomor==0?Tbl_Td($TampilCheckBox,"center",$cssclass):Tbl_Td("","right",$cssclass);			
		return $Koloms;
	}
	
	function setKolomData_GetProgKeg($no, $isi, $Mode, $TampilCheckBox, $cssclass){
	 global $Ref, $DataPengaturan;
	 $Koloms='';	 
	 $this->pid_nomor=1;
	 $KodeProg = $DataPengaturan->Gen_valProgram($isi);
	 if($this->kode_prog != $KodeProg){
	 	$Koloms.=$this->set_KolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass);
		$Koloms.=Tbl_Td("","left",$cssclass);
		$Koloms.=Tbl_Td("<b>".$isi["nm_program"]."</b>","left",$cssclass);
		$Koloms.=Tbl_Td("","left",$cssclass);
	 	$Koloms.="</tr>";
		$this->pid_urutan++;
	 } 
	 
	 $KodeKegiatan=$DataPengaturan->Gen_valKegiatan($isi);
	 if($this->kode_kegiatan != $KodeKegiatan){
	 	$Koloms.=$this->set_KolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass);
		$Koloms.=Tbl_Td("","left",$cssclass);
		$Koloms.=Tbl_Td(LabelSPan1("col_keg",$isi["nm_kegiatan"], "style='margin-left:5px;font-weight:bold;'"),"left",$cssclass);
		$Koloms.=Tbl_Td("","left",$cssclass);
	 	$Koloms.="</tr>";
		$this->pid_urutan++;
	 }
	 
	 $this->kode_prog=$KodeProg;
	 $this->kode_kegiatan=$KodeKegiatan;
	 		
	 return $Koloms;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref, $DataPengaturan;
	 $Koloms='';
	 $cssclass = $Mode == 1?'class="GarisDaftar"':'class="GarisCetak"';
	 
	 $Koloms.=$this->setKolomData_GetProgKeg($no, $isi, $Mode, $TampilCheckBox, $cssclass);
	 
	 $this->pid_nomor = 0;
	 $Koloms.=$this->setKolomData_cb($no, $isi, $Mode, $TampilCheckBox, $cssclass);
	 $Koloms.=Tbl_Td($DataPengaturan->Gen_valRekening($isi),"center",$cssclass);
	 $Koloms.=Tbl_Td(LabelSPan1("col_rek",$isi["nm_rekening"],"style='margin-left:10px;'"),"left",$cssclass);
	 $Koloms.=Tbl_Td(FormatUang($isi["total"]),"right",$cssclass);
	 $Koloms.="</tr>";	 
	 $this->pid_urutan++;
	 
	 $Koloms = array(
		array("Y", $Koloms),
	 );
		
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main,$DataPengaturan, $HTTP_COOKIE_VARS, $DataSurat;	 
	 $thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];	
	 $arr = array(
				array('nm_rekening','NAMA REKENING'),
				array('nm_program','NAMA PROGRAM'),
				array('nm_kegiatan','NAMA KEGIATAN'),
			);
	 $T_SPD = $DataSurat->TblName_NomorSPD;
		
	 //data order ------------------------------
	 $arrOrder = array(
			     	array('1','Satuan'),
					);
	 
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	$kodeprogram = $_REQUEST['kodeprogram'];		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	
	$c1 = cekPOST2('c1');
	$c = cekPOST2('c');
	$d = cekPOST2('d');
	$fm_program = cekPOST2('fm_program');
	$jns_anggaran = cekPOST2('jns_anggaran', cekPOST2("pil_jns_anggaran"));
	$triwulan = cekPOST2('triwulan', cekPOST2("pil_triwulan"));
	$nomor_spd = cekPOST2("nomor_spd", cekPOST2("pil_nomor_spd"));
	$fm_tgl_spd = "";
	
	if($nomor_spd != ""){
		$qryGetTgl = $DataPengaturan->QyrTmpl1Brs($T_SPD,"tanggal_spd","WHERE Id='$nomor_spd'");
		$dt_Tgl = $qryGetTgl["hasil"];
		$fm_tgl_spd = FormatTanggalnya($dt_Tgl["tanggal_spd"]);
	}	
	
	
	$IdSPD = cekPOST2('fm_refid_nomor_spd');
	$qry_spd = $DataPengaturan->QyrTmpl1Brs("t_nomor_spd","*","WHERE Id='$IdSPD' ");
	$dt = $qry_spd["hasil"];
	
	$concat_prog = "concat(a.bk,'.',a.ck,'.',a.dk,'.',a.p)";
	$where_nya = "c1='$c1' AND c='$c' AND d='$d' AND jenis_anggaran='$jns_anggaran' AND type_spd='$triwulan' ";
	$where_skpd = $where_nya." AND ";
	$groupby = " GROUP BY a.bk,a.ck,a.dk,a.p,a.q ";
	
	$qry_anggaran = "SELECT jenis_anggaran, jenis_anggaran FROM ".$this->TblName." GROUP BY jenis_anggaran";
	
	$qry_nomor_spd = "SELECT refid_nomor_spd, nomor_spd FROM ".$this->TblName." WHERE $where_nya GROUP BY refid_nomor_spd";
	
	$qry_program = "SELECT $concat_prog, b.nama FROM ".$this->TblName." a LEFT JOIN ref_program b ON a.bk=b.bk AND a.ck=b.ck AND a.dk=b.dk AND a.p=b.p WHERE $where_skpd b.q='0' $groupby ";
	$qry_kegiatan = "SELECT a.q, b.nama FROM ".$this->TblName." a LEFT JOIN ref_program b ON a.bk=b.bk AND a.ck=b.ck AND a.dk=b.dk AND a.p=b.p AND a.q=b.q WHERE $where_skpd b.q!='0' AND $concat_prog='$fm_program'  $groupby";
	
	$fungsi_onchange= "onchange='".$this->Prefix.".refreshList(true);'";
	
	$TampilOpt =
			//<table width=\"100%\" class=\"adminform\">
			"<tr><td>".
			$vOrder=
			genFilterBar(
				array(
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>'ANGGARAN',
								'label-width'=>'175px',
								'value'=>cmbQuery("jns_anggaran", $jns_anggaran,$qry_anggaran,"style='width:200px' $fungsi_onchange ", "--- PILIH JENIS ANGGARAN ---"),
							),
							array(
								'label'=>'TRIWULAN',
								'value'=>cmbArray("triwulan",$triwulan,$Main->ARR_TRIWULAN,"--- PILIH TRIWULAN ---","style='width:200px' $fungsi_onchange"),
							),
							array(
								'label'=>'NOMOR SPD',
								'value'=>cmbQuery("nomor_spd", $nomor_spd,$qry_nomor_spd,"style='width:400px' $fungsi_onchange ", "--- PILIH NOMOR SPD ---"),
							),
							array(
								'label'=>'TANGGAL SPD',
								'value'=>InputTypeText("fm_tgl_spd",$fm_tgl_spd, " style='width:80px;' readonly ")
							),
							array(
								'label'=>'PROGRAM',
								'value'=>cmbQuery("fm_program", $fm_program, $qry_program,"style='width:400px;' $fungsi_onchange ", "--- SEMUA PROGRAM ---"),
							),
							array(
								'label'=>'KEGIATAN',
								'value'=>
									cmbQuery("fm_kegiatan", cekPOST2("fm_kegiatan"), $qry_kegiatan,"style='width:400px;' $fungsi_onchange", "--- SEMUA KEGIATAN ---")." ".
									InputTypeButton("btn_cari", "CARI", "onclick='".$this->Prefix.".refreshList(true);'")
								,
							),
						)
					)
				),			
				'','')/*.
			genFilterBar(
				array(
					cmbArray("fmPILCARI",cekPOST2("fmPILCARI"),$arr,"--- CARI BERDASARKAN ---",''),
					InputTypeText("fmPILCARIvalue",cekPOST2("fmPILCARIvalue"),"placeholder='PENCARIAN' size='70'"),
					InputTypeButton("btTampil","CARI", " onclick='".$this->Prefix.".refreshList(true)'")),			
				'','')*/
				;
			
			
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS, $DataSurat;
		$UID = $_COOKIE['coID'];  
		$thn_anggaran = $_COOKIE['coThnAnggaran'];	
		//kondisi -----------------------------------
		
		$Tbl_SPPRek = $DataSurat->TblName_Rekening;
				
		$arrKondisi = array();		
		
		$fmPILCARI = cekPOST2('fmPILCARI');	
		$fmPILCARIvalue = cekPOST2('fmPILCARIvalue');
		$kodeprogram = $_REQUEST['kodeprogram'];
		//cari tgl,bln,thn
		$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];			
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
		//Cari 
		$kodePRG = explode(".",$kodeprogram);
		$IdSpp = cekPOST2("IdSpp");
		$IdSpp_det = cekPOST2("IdSpp_det");
		$jns_anggaran = cekPOST2('jns_anggaran', cekPOST2("pil_jns_anggaran"));
		$triwulan = cekPOST2('triwulan', cekPOST2("pil_triwulan"));
		$nomor_spd = cekPOST2("nomor_spd", cekPOST2("pil_nomor_spd"));
		$fm_tgl_spd = cekPOST2("fm_tgl_spd", cekPOST2("pil_tgl_spd"));
		$fm_kegiatan = cekPOST2("fm_kegiatan");
		$fm_program = cekPOST2("fm_program");
		$IdTerima = cekPOST2("IdTerima");
					
		//if($fmPILCARI !='' && $fmPILCARIvalue != '')$arrKondisi[] = " $fmPILCARI like '%$fmPILCARIvalue%' ";
		
		$arrKondisi[] = " c1='".cekPOST2("c1")."' ";
		$arrKondisi[] = " c='".cekPOST2("c")."' ";
		$arrKondisi[] = " d='".cekPOST2("d")."' ";
		$arrKondisi[] = " jenis_anggaran='".$jns_anggaran."' ";
		$arrKondisi[] = " type_spd='".$triwulan."' ";
		$arrKondisi[] = " refid_nomor_spd='".$nomor_spd."' ";
		if($fm_program != "")$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p)='".$fm_program."' ";
		if($fm_kegiatan != "")$arrKondisi[] = " q='".$fm_kegiatan."' ";
		if($IdTerima != ""){
			$concat_kdRek = "concat(k,'.',l,'.',m,'.',n,'.',o)";
			$qry = "SELECT $concat_kdRek as kd_rek FROM $Tbl_SPPRek WHERE refid_terima='$IdTerima' AND status='0' ";
			$arrKondisi[] = " $concat_kdRek IN ($qry) ";
		}
		
		/*$arrKondisi[] = " refid_nomor_spd='".cekPOST2("fm_refid_nomor_spd")."' ";
		$arrKondisi[] = " Id NOT IN (SELECT refid_nomor_spd_det FROM t_spp_rekening WHERE Id !='$IdSpp_det' AND refid_spp='$IdSpp' AND status='0') ";*/
		
		//if($nomor_spd != "")$arrKondisi[] = " nomor_spd LIKE '%".$nomor_spd."%' ";
		//if($fm_tgl_spd != "")$arrKondisi[] = " tanggal_spd ='".FormatTanggalnya($fm_tgl_spd."-".$thn_anggaran)."' ";
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		
		
		$arrOrders[] = " bk ";
		$arrOrders[] = " ck ";
		$arrOrders[] = " dk ";
		$arrOrders[] = " p ";
		$arrOrders[] = " q ";
		$arrOrders[] = " k ";
		$arrOrders[] = " l ";
		$arrOrders[] = " m ";
		$arrOrders[] = " n ";
		$arrOrders[] = " o ";
		/*
		switch($fmORDER1){
			case '1': $arrOrders[] = " p $Asc1 " ;break;
		}	*/
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
	
	function setTopBar(){
	   	return '';
	}
	
	function windowShow_Ins_temp(){
		global $DataPengaturan;
		$tbl = "temp_data";
		$UID = $_COOKIE['coID'];
		
		$DataPengaturan->SetDelete_Temp();
		
		$data = array(array("uid",$UID),array("jns","1"));
		$qry_ins = $DataPengaturan->QryInsData($tbl,$data);
		$qry_tmpl = $DataPengaturan->QyrTmpl1Brs2($tbl,"*",$data," ORDER BY Id DESC ");
		$dt = $qry_tmpl["hasil"];
		
		return $dt;		 
	}
	
	function windowShow_SetTemp($IdTemp){
		global $DataPengaturan, $DataSurat;
		$content="";
		$UID = $_COOKIE['coID'];
		
		$IdSPP = cekPOST2("suratpermohonan_spp_idplh");
		$qry = "SELECT * FROM ".$DataSurat->TblName_Rekening." WHERE refid_spp='$IdSPP' AND jns_rek='1' AND status='0'";
		$aqry = mysql_query($qry);
		$nomorSPD = "";
		while($dt = mysql_fetch_assoc($aqry)){
			$data_ins = 
				array(
					array("refid_temp_data", $IdTemp),
					array("uid", $UID),
					array("refid", $dt["refid_nomor_spd_det"]),
					array("refid_master",$dt["refid_nomor_spd"])
				);
			$data_ins_Temp = $DataPengaturan->QryInsData($DataPengaturan->Tbl_Temp_det,$data_ins);
			$nomorSPD=$dt["refid_nomor_spd"];
		}
		
		//Get Nomor SPD
		if($nomorSPD != ""){
			$qry_spd = $DataPengaturan->QyrTmpl1Brs($DataSurat->TblName_NomorSPD, "*", "WHERE Id='".$nomorSPD."' ");
			$dt_spd = $qry_spd["hasil"];
		
			$content=
				InputTypeHidden("pil_jns_anggaran",$dt_spd["jenis_anggaran"]).
				InputTypeHidden("pil_triwulan",$dt_spd["type_spd"]).
				InputTypeHidden("pil_nomor_spd",$dt_spd["nomor_spd"]).
				InputTypeHidden("pil_tgl_spd", FormatTanggalBulan($dt_spd["tanggal_spd"]));
		}
		
		return $content;
		
	}
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
		
		$Id_Temp = $this->windowShow_Ins_temp();
		$kontenTemp = $this->windowShow_SetTemp($Id_Temp["Id"]);
						
		$form_name = $this->FormName;
		//$ref_jenis=$_REQUEST['ref_jenis'];
		//if($err==''){
			$FormContent = $this->genDaftarInitial($ref_jenis);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						900,
						500,
						'Pilih Rekening SPD',
						'',
						/*"
						<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".*/
						InputTypeHidden("dari_widwowsshow","1").
						InputTypeHidden("c1",cekPOST2("c1nya")).
						InputTypeHidden("c",cekPOST2("cnya")).
						InputTypeHidden("d",cekPOST2("dnya")).
						InputTypeHidden("fm_refid_nomor_spd",cekPOST2("refid_nomor_spd")).
						InputTypeHidden("IdSpp",cekPOST2("suratpermohonan_spp_idplh")).
						InputTypeHidden("IdSpp_det",cekPOST2("Id_spp_det")).
						InputTypeHidden("IdTemp_data", $Id_Temp["Id"]).
						InputTypeHidden("IdTerima", cekPOST2("refid_terima")).
						$kontenTemp.
						InputTypeButton("btn_pilih", "PILIH", "onclick ='".$this->Prefix.".windowSimpan()'")." ".
						InputTypeButton("btn_cancel", "BATAL", "onclick ='".$this->Prefix.".windowBatal()'")
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
		//}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Hapus_Validasi($id){
		global $DataPengaturan;
		$errmsg ='';		
		$pesan="Data Tidak Bisa Di Hapus, Sudah di Gunakan di ";
		
		$qry_pnrmn = $DataPengaturan->QryHitungData("t_penerimaan_barang","WHERE refid_penyedia='$id'");
		if($qry_pnrmn["hasil"] > 0)$errmsg=$pesan."Pengadaan Barang !";
		
		if($errmsg == ""){
			$qry_spp = $DataPengaturan->QryHitungData("t_spp","WHERE refid_penyedia='$id' AND refid_penyedia_jns='2'");
			if($qry_spp["hasil"] > 0)$errmsg=$pesan."Surat Permohonanss !";
		}
		
		return $errmsg;
	}
	
	function pilData(){
		global $DataPengaturan;
		$cek='';$err='';$content='';
		$id = cekPOST2("id");
		$c1 = cekPOST2("c1");
		$c = cekPOST2("c");
		$d = cekPOST2("d");
		$refid_nomor_spd = cekPOST2("fm_refid_nomor_spd");
		
		if($err == '' && $id=='')$err="Data Tidak Valid !";
		if($err == ""){
			$qry = $DataPengaturan->QyrTmpl1Brs("t_nomor_spd_det","*","WHERE Id='$id' AND c1='$c1' AND c='$c' AND d='$d' AND refid_nomor_spd='$refid_nomor_spd'");$cek.=$qry["cek"];
			$dt = $qry["hasil"];
			if($dt["Id"] == "" || $dt["Id"] == NULL)$err="Data Tidak Valid !";
		}
		
		if($err=="")$content=$id;
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Set_cb_Temp(){
		global $DataPengaturan;
		$cek='';$err='';$content='';
		$UID = $_COOKIE['coID'];
		
		$tbl_Temp = $DataPengaturan->Tbl_Temp_det;
		
		$cb = $_REQUEST[$this->Prefix."_cb"];
		$IdNomorSPD = cekPOST2("IdNomorSPD");
		$IdTemp_data = cekPOST2("IdTemp_data");
		$status = cekPOST2("status_id");	
			
		if($status){
			$qry_tmpl = $DataPengaturan->QyrTmpl1Brs($this->TblName,"refid_nomor_spd", "WHERE Id='$IdNomorSPD' ");
			$dt_tmpl = $qry_tmpl["hasil"];
			
			$data = array(array("refid_temp_data",$IdTemp_data),array("uid",$UID),array("refid",$IdNomorSPD),array("refid_master",$dt_tmpl["refid_nomor_spd"]));
			$qry = $DataPengaturan->QryInsData($tbl_Temp,$data);
		}else{
			$qry = $DataPengaturan->QryDelData($tbl_Temp,"WHERE refid='$IdNomorSPD' AND refid_temp_data='$IdTemp_data' ");
		}
		$cek.=$qry["cek"];				
		$content = $status;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function windowBatal(){
		global $DataPengaturan;
		$cek='';$err='';$content='';		
		
		$IdTemp_data = cekPOST2("IdTemp_data"); 
		$DataPengaturan->SetDelete_Temp($IdTemp_data);
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}	
	
	function windowSimpan_Kosongan(){
		global $DataPengaturan, $DataSurat;
		$cek='';$err='';$content='';	
		$UID = $_COOKIE['coID'];
	
		$Tbl_TempDet = $DataPengaturan->Tbl_Temp_det;		
		$Tbl_SPPRek = $DataSurat->TblName_Rekening;	
		
		$IdSpp = cekPOST2("IdSpp"); 
		$IdTemp_data = cekPOST2("IdTemp_data"); 
		
		//VALIDASI ---------------------------------------------------
		$where_temp = "WHERE refid_temp_data='$IdTemp_data' ";
		$qry_hit = $DataPengaturan->QryHitungData($Tbl_TempDet, $where_temp. " GROUP BY refid_master");$cek=$qry_hit["cek"];
		if($err == "" && $qry_hit["hasil"] == 0)$err="Data Belum di Pilih !";
		if($err == "" && $qry_hit["hasil"] > 1)$err="Pilih Data Hanya Dari 1 Nomor SPD !";
		
		if($err == ""){
			$qry_temp = "SELECT * FROM $Tbl_TempDet $where_temp";
			$aqry_temp = mysql_query($qry_temp);
			while($dt_temp = mysql_fetch_assoc($aqry_temp)){
				//Cek Data Di t_nomor_spd
				$qry_SPDdet = $DataPengaturan->QyrTmpl1Brs($this->TblName, "*","WHERE Id='".$dt_temp["refid"]."'");
				$dt_SPDdet = $qry_SPDdet["hasil"];
				if($dt_SPDdet["Id"] != '' || $dt_SPDdet["Id"] != NULL){
					$data_where = 
						array(
							array("refid_nomor_spd", $dt_SPDdet["refid_nomor_spd"]),
							array("refid_nomor_spd_det", $dt_SPDdet["Id"]),
							array("refid_spp", $IdSpp),
							array("status", "0"),
						);
					//UPDATE Jika ada sttemp 0
					$data_where1 = array_merge($data_where,array(array("sttemp","0")));
					$qry_upd_sppRek = $DataPengaturan->QryUpdData2($Tbl_SPPRek, array(array("status","2")), $data_where1);
					//Tampil Data Jika Belum Fix			
					$qry_sppRek = $DataPengaturan->QyrTmpl1Brs2($Tbl_SPPRek, "*", $data_where);
					$dt_sppRek = $qry_sppRek["hasil"];
					
					if($dt_sppRek["Id"] == "" || $dt_sppRek["Id"] == NULL){
						$data_ins = 
							array(
								array("bk",$dt_SPDdet["bk"]),array("ck",$dt_SPDdet["ck"]),array("dk",$dt_SPDdet["dk"]),
								array("p",$dt_SPDdet["p"]),array("q",$dt_SPDdet["q"]),
								array("k",$dt_SPDdet["k"]),array("l",$dt_SPDdet["l"]),array("m",$dt_SPDdet["m"]),
								array("n",$dt_SPDdet["n"]),array("o",$dt_SPDdet["o"]),
								array("refid_spp",$IdSpp),
								array("jns_rek","1"),array("jumlah","0"),
								array("refid_nomor_spd",$dt_SPDdet["refid_nomor_spd"]),
								array("refid_nomor_spd_det",$dt_SPDdet["Id"]),
								array("uid",$UID),
								array("status","0"),
								array("sttemp","1"),
							);
						$qry_ins_SPPRek = $DataPengaturan->QryInsData($Tbl_SPPRek, $data_ins);$cek.=$qry_ins_SPPRek["cek"];
					}
					
				}
				
			}
			
			$content["refid_nomor_spd"]=$dt_SPDdet["refid_nomor_spd"];
			$content["nomor_spd"]=$dt_SPDdet["nomor_spd"];
			$content["tgl_spd"]=FormatTanggalnya($dt_SPDdet["tanggal_spd"]);
		}	
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function windowSimpan_Terima_Validasi(){
		global $DataPengaturan, $DataSurat;
		$cek='';$err='';$content='';	
		$UID = $_COOKIE['coID'];
		
		$Tbl_SPPRek = $DataSurat->TblName_Rekening;			
		$V_Rek = $DataSurat->View_SPPRek;
		
		$IdTerima = cekPOST2("IdTerima");
		$IdSpp = cekPOST2("IdSpp"); 
		
		$cb = $_REQUEST[$this->Prefix."_cb"];
		$hit = count($cb);
		if($err == "" && $hit < 1)$err="Data Belum di Pilih !";		
		if($err == ""){
			$this->kdRek = array();
			for($i=0;$i<$hit;$i++){
				$IdSPDdet = cekPOST_Arr($this->Prefix."_cb",$i);
				$qryNomorSPD = $DataPengaturan->QyrTmpl1Brs($this->TblName,"*","WHERE Id='$IdSPDdet' ");
				$dtNomorSPD = $qryNomorSPD["hasil"];
				$this->kdRek["ke-".$i]=$DataPengaturan->Gen_valRekening($dtNomorSPD);
				$this->Arr_IdSPD_det[$i]=$IdSPDdet;
			}
			
			$qry_SPPRek = "SELECT * FROM $V_Rek WHERE refid_spp='$IdSpp' AND refid_terima='$IdTerima' AND status='0' ";
			$aqry_SPPRek= mysql_query($qry_SPPRek);
			while($dt_SPPRek = mysql_fetch_assoc($aqry_SPPRek)){
				$RekSPP = $DataPengaturan->Gen_valRekening($dt_SPPRek);
				$cariRek = array_search($RekSPP, $this->kdRek);
				if($cariRek == FALSE && $err == ""){
					$err="Kode Rekening $RekSPP. ".$dt_SPPRek["nm_rekening"]." Belum di Pilih Atau Tidak Ada !";		
					break;
				}
			}
		}
		
		return $err;
	}
	
	function windowSimpan_Terima(){
		global $DataPengaturan, $DataSurat;
		$cek='';$err='';$content='';	
		$UID = $_COOKIE['coID'];
		
		$V_Rek = $DataSurat->View_SPPRek;		
		$Tbl_SPPRek = $DataSurat->TblName_Rekening;	
		$V_NoSPD = $DataSurat->View_NomorSPD_det;	
		
		$IdTerima = cekPOST2("IdTerima");
		$IdSpp = cekPOST2("IdSpp"); 
		
		$err = $this->windowSimpan_Terima_Validasi();
		if($err == ""){
			$qry_SPPRek = "SELECT * FROM $V_Rek WHERE refid_spp='$IdSpp' AND refid_terima='$IdTerima' AND status='0' ";
			$aqry_SPPRek= mysql_query($qry_SPPRek);
			$refid_nomor_spd = "";
			$nomor_spd = "";
			$tgl_spd = "";
			while($dt_SPPRek = mysql_fetch_assoc($aqry_SPPRek)){
				$RekSPP = $DataPengaturan->Gen_valRekening($dt_SPPRek);
				$cariRek = array_search($RekSPP, $this->kdRek);
				$index = explode("-",$cariRek);
				
				$qryNoSPD = $DataPengaturan->QyrTmpl1Brs($V_NoSPD,"*", "WHERE Id='".$this->Arr_IdSPD_det[$index[1]]."'");
				$dtNoSPD = $qryNoSPD["hasil"];$cek.=$qryNoSPD["cek"];
				
				$data_upd = 
					array(
						array("refid_nomor_spd",$dtNoSPD["refid_nomor_spd"]),
						array("refid_nomor_spd_det",$dtNoSPD["Id"]),
					);
				$qry_updRek = $DataPengaturan->QryUpdData($Tbl_SPPRek,$data_upd,"WHERE Id='".$dt_SPPRek["Id"]."'");
				$cek.=$qry_updRek["cek"];		
				
				$refid_nomor_spd = $dtNoSPD["refid_nomor_spd"];
				$nomor_spd = $dtNoSPD["nomor_spd"];
				$tgl_spd = $dtNoSPD["tanggal_spd"];
			}
			
			$content["refid_nomor_spd"]=$refid_nomor_spd;
			$content["nomor_spd"]=$nomor_spd;
			$content["tgl_spd"]=FormatTanggalnya($tgl_spd);
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function windowSimpan(){
		global $DataPengaturan, $DataSurat;
		$cek='';$err='';$content='';	
		$UID = $_COOKIE['coID'];
		$IdTerima = cekPOST2("IdTerima");
		
		if($IdTerima == ""){
			$GetData = $this->windowSimpan_Kosongan();
		}else{
			$GetData = $this->windowSimpan_Terima();
		}	
		
		$cek = $GetData["cek"];
		$err = $GetData["err"];
		$content = $GetData["content"];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
}
$carino_spd_det = new carino_spd_detObj();
?>