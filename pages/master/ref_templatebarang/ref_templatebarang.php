<?php
 include "pages/pencarian/DataPengaturan.php";
 $DataOption = $DataPengaturan->DataOption();

class ref_templatebarangObj  extends DaftarObj2{	
	var $Prefix = 'ref_templatebarang';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_templatebarang'; //daftar 
	var $TblName_Hapus = 'ref_templatebarang';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Data Template';
	var $PageIcon = 'images/administrator/images/icon_template.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'SKPD';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_templatebarangForm'; 
			
	function setTitle(){
		return 'TEMPLATE BARANG';
	}
	
	function setMenuView(){
		return "";
	}
	
	function setMenuEdit(){		
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus').
			"</td>";
	}
	
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		
		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>";	
	}	
	
	function simpan(){
		global $HTTP_COOKIE_VARS, $DataPengaturan, $Main;
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = cekPOST($this->Prefix.'_fmST');
		$idplh = cekPOST($this->Prefix.'_idplh');
		$nama_tmplt = cekPOST('nama_tmplt');
		$tgl_template = cekPOST('tgl_template');
		$keterangan = cekPOST('keterangan');
		
		
		if($err == "" && $nama_tmplt=="")$err="Nama Template Belum Di Isi !";
		$tgl_template = explode("-",$tgl_template);
		$tgl_template = $tgl_template[2]."-".$tgl_template[1]."-".$tgl_template[0];
		if($err=='' && !cektanggal($tgl_template)) $err= 'Tanggal Template Tidak Valid !';
		
		//Hitung Template Barang Detail		
		if($err == ""){
			$qryHit = $DataPengaturan->QryHitungData("ref_templatebarang_det", "WHERE refid_templatebarang='$idplh' AND status!='2' ");
			if($qryHit["hasil"] < 1)$err = "Template Barang Belum Di Isi !";
		}
		
		
		//if($err == "")$err="sdgfdfg";
		if($err == ""){
			//UPDATE ref_templatebarang_det DIMANA status=1 
			$data_upd = array(array("status", "0"), array("sttemp", "0"),);
			$qry_upd = $DataPengaturan->QryUpdData("ref_templatebarang_det", $data_upd, "WHERE refid_templatebarang='$idplh' AND status!='2' "); $cek.=$qry_upd["cek"];
			
			//Hapus ref_templatebarang_det DIMANA status=1 
			$qry_hps = "DELETE FROM ref_templatebarang_det WHERE refid_templatebarang='$idplh' AND status='2'  ";$cek.=$qry_hps; 
			$aqry_hps = mysql_query($qry_hps);
			
			$data_updRefBrg = array(
								array("nama_tmplt", $nama_tmplt),
								array("tgl_template", $tgl_template),
								array("keterangan", $keterangan),
								array("sttemp", "0"),
							);
			$qryRefTMPL = $DataPengaturan->QryUpdData("ref_templatebarang", $data_updRefBrg, "WHERE Id='$idplh'"); $cek.=$qryRefTMPL["cek"];
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
	  	
		case 'formBaru':{				
			$fm = $this->setFormBaru();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'formEdit':{				
			$fm = $this->setFormEdit();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'simpan':{
			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'Batal':{
			$get= $this->Batal();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'getdata':{
			$cek = "";
			$err = "";
			$content = cekPOST("id");
		break;
	    }
	   
		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
		break;
		}
		
				
	   
	  /* case 'hapus':{	
				$fm= $this->Hapus($pil);
				$err= $fm['err']; 
				$cek = $fm['cek'];
				$content = $fm['content'];
		break;
		}	*/		
	   
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
   
   function setPage_HeaderOther(){
		$jns_tr = cekPOST("jns_tr");
		return "<input type='hidden' name='jns_tr' id='jns_tr' value='$jns_tr' />";
	}
   
   	function setPage_OtherScript(){
		$scriptload = 

					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			 "<script src='js/skpd.js' type='text/javascript'></script>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/pencarian/cariBarang.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/pengadaanpenerimaan/pemasukan_ins.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/master/ref_templatebarang/".strtolower($this->Prefix)."_det.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/master/ref_templatebarang/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
			 ".
			 '
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>
			'.
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".
			
			$scriptload;
	}
	
	function setFormEdit(){
		global $DataOption, $DataPengaturan;
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = $cbid[0];
		$this->form_fmST = 1;				
		//get data 
		$tampil = $DataPengaturan->QyrTmpl1Brs("ref_templatebarang","*", "WHERE Id='$kode' ");
		$dt = $tampil["hasil"];
		
		$tglTMPLT = explode("-", $dt["tgl_template"]);
		$dt['tgl_template'] = $tglTMPLT[2]."-".$tglTMPLT[1]."-".$tglTMPLT[0];
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
		
	function setFormBaru(){
		global $DataOption, $DataPengaturan, $HTTP_COOKIE_VARS;
		$err="";$content="";$cek=''; 
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek = $cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$dt=array();
		$this->form_fmST = 0;
		
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		$c1 = cekPOST($this->Prefix."SKPD2fmURUSAN");
		$c = cekPOST($this->Prefix."SKPD2fmSKPD");
		$d = cekPOST($this->Prefix."SKPD2fmUNIT");
		$e = cekPOST($this->Prefix."SKPD2fmSUBUNIT");
		$e1 = cekPOST($this->Prefix."SKPD2fmSEKSI");
		$jns_transaksi = cekPOST("jns_transaksi");
		
		if($DataOption['skpd'] != 1)if($err == "" && ($c1 == "" || $c1=='0'))$err="Urusan Belum Di Pilih !";
		if($err == "" && ($c == "" || $c == "00"))$err="Bidang Belum Di Pilih !";
		if($err == "" && ($d == "" || $d == "00"))$err="SKPD Belum Di Pilih !";
		if($err == "" && ($e == "" || $e == "00"))$err="UNIT Belum Di Pilih !";
		if($err == "" && ($e1 == "" || $e1 == "000"))$err="SUB UNIT Belum Di Pilih !";
		if($err == "" && $jns_transaksi == "")$err="Jenis Transaksi Belum Di Pilih !";
		
		//TUK nama template
		
		$qry_ambil = $DataPengaturan->QyrTmpl1Brs("ref_templatebarang", "nama_tmplt", "WHERE nama_tmplt LIKE 'TEMPLATE-%' AND c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' AND jns_trans='$jns_transaksi' AND sttemp='0' ORDER BY Id DESC");
		$dt_ambil = $qry_ambil["hasil"];
		$no_tmplt=explode("-", $dt_ambil["nama_tmplt"]);
		$noTMPLT = intval($no_tmplt["1"]);
		$noTMPLT = $noTMPLT+1;
		
		
		if($err == ""){
			$data = array(
						array("c1",$c1),
						array("c",$c),
						array("d",$d),
						array("e",$e),
						array("e1",$e1),
						array("jns_trans",$jns_transaksi),
						array("nama_tmplt","TEMPLATE-".$noTMPLT),
						array("sttemp","1"),
						array("uid",$uid),
					);
			$qry = $DataPengaturan->QryInsData("ref_templatebarang", $data);$cek.=$qry["cek"];
			$tampil = $DataPengaturan->QyrTmpl1Brs2("ref_templatebarang","*", $data, "ORDER BY Id DESC ");
			$dt = $tampil["hasil"];
			$dt['tgl_template'] = date("d-m-Y");
			
			$fm = $this->setForm($dt);
			$cek.=$fm['cek'];
			$err=$fm['err'];
			$content=$fm['content'];
		}
		
			
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setForm($dt){	
	 global $SensusTmp ,$Main,$DataPengaturan;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_detForm';				
	 $this->form_width = 520;
	 $this->form_height = 70;
	 $this->form_idplh =$dt["Id"];
	  if ($this->form_fmST==0) {
		$this->form_caption = 'FORM BARU TEMPLATE BARANG';
	  }else{
		$this->form_caption = 'FORM UBAH TEMPLATE BARANG';			
		$readonly='readonly';
					
	  }
	  $message=$dt['syarat'];
	  
	  $JenisTransaksi = "PENGADAAN BARANG";
	  if($dt["jns_trans"] == "2")$JenisTransaksi="PEMELIHARAAN BARANG";
		//items ----------------------
			$dataSKPD = $DataPengaturan->GenViewSKPD2($dt["c1"],$dt["c"],$dt["d"],$dt["e"],$dt["e1"],150);
		  	array_push($dataSKPD, 
						array( 
							'label'=>'JENIS TRANSAKSI',
							'labelWidth'=>150, 
							'value'=>"<input type='text' name='jns_tran' id='jns_tran' value='".$JenisTransaksi."' readonly style='width:380px;'>"
						
						 ),					 
						array( 
							'label'=>'NAMA TEMPLATE',
							'labelWidth'=>150, 
							'value'=>"<input type='text' name='nama_tmplt' id='nama_tmplt' value='".$dt['nama_tmplt']."' placeholder='NAMA TEMPLATE' style='width:380px;'>"
						
						 ),
						array( 
							'label'=>'TANGGAL TEMPLATE',
							'labelWidth'=>150, 
							'value'=>"<input type='text' name='tgl_template' id='tgl_template' value='".$dt['tgl_template']."' placeholder='NAMA TEMPLATE' style='width:80px;' class='datepicker'>"
						
						 ),	
						array( 
							'label'=>'KETERANGAN',
							'labelWidth'=>150, 
							'value'=>"<textarea id='keterangan' name='keterangan' style='width:380px;'>".$dt['keterangan']."</textarea>"
						
						 ),		
						array( 
							'type'=>'merge',
							'value'=>"<div id='det_barang'></div>"
						
						 )						 
					);			
			$this->form_fields = $dataSKPD;
		//tombol
		$this->form_menubawah =	
			$DataPengaturan->GenViewHiddenSKPD($dt["c1"],$dt["c"],$dt["d"],$dt["e"],$dt["e1"]).
			"<input type='hidden' name='IdPilih' value='".$dt["Id"]."' />".
			"<input type='hidden' name='jns_transaksi' value='".$dt["jns_trans"]."' />".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Batal()' >";
			
							
		$form = $this->genForm2(TRUE,$form_name);		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function genForm2($withForm=TRUE, $form_name=''){	
		if($form_name=='')$form_name = $this->Prefix.'_form';	
				
		if($withForm){
			$params->tipe=1;
			$form= "<form name='$form_name' id='$form_name' method='post' action=''>".
				createDialog(
					$form_name.'_div', 
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height,
					'',$params
					).
				"</form>";
				
		}else{
			$form= 
				createDialog(
					$form_name.'_div', 
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height
				);
			
			
		}
		return $form;
	}	
	
	
	
		
	//daftar =================================	
	function setKolomHeader($Mode=1, $Checkbox=''){
	$datanya = $this->BersihkanData();
	$NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox		
	   <th class='th01' width='80'>TANGGAL</th>
	   <th class='th01'>NAMA</th>
	   <th class='th01'>KETERANGAN</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	  $Koloms[] = array('align="center"',$isi['tgl_template']);
	  $Koloms[] = array('align="left"',$isi['nama_tmplt']);
	  $Koloms[] = array('align="left"',$isi['keterangan']);
	 return $Koloms;
	}
		
	function genDaftarOpsi(){
	 global $Ref, $Main, $DataPengaturan;
	 
	$RB = "ref_templatebarangSKPD2fm";
	$fmJns = $_REQUEST['fmJns'];	
	$crSyarat = $_REQUEST['crSyarat'];	
	
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	$jns_transaksi = cekPOST('jns_transaksi', cekPOST("jns_tr"));
	$Dari_jns_transaksi = cekPOST('Dari_jns_transaksi');
	
	$TUKC1=cekPOST($RB."URUSAN");
	$TUKC=cekPOST($RB."SKPD");
	$TUKD=cekPOST($RB."UNIT");
	$TUKE=cekPOST($RB."SUBUNIT");
	$TUKE1=cekPOST($RB."SEKSI");
	
	$FM_JNSTRANS = cmbArray('jns_transaksi',$jns_transaksi,$DataPengaturan->jns_trans,"--- PILIH JENIS TRANSAKSI ---", "style='width:200px;' onchange='pemasukan_ins.inputpenerimaan()'");
	
			
	$DataSKPD = genFilterBar(array(WilSKPD_ajx3($this->Prefix.'SKPD2')),'','');
	if($Dari_jns_transaksi != ""){
		$DataSKPD=$DataPengaturan->GenViewSKPD($TUKC1, $TUKC, $TUKD, $TUKE, $TUKE1, "100px");
		//Filter Jenis Transaksi ----------------------------------------------------------------------------------------
		$FM_JNSTRANS = "<select style='width:300px;' id='jns_transaksi' name='jns_transaksi'>";
		if($Dari_jns_transaksi == 1){
			$FM_JNSTRANS.="<option selected value='1'>PENGADAAN BARANG</option></select>";
		}else{
			$FM_JNSTRANS.="<option selected value='2'>PEMELIHARAAN BARANG</option></select>";
		}
	//------------------------------------------------------------------------------------------------------------------
	}
	$TampilOpt = 
	"<tr><td>".
			$vOrder=$DataSKPD.
			genFilterBar(
				array("JENIS TRANSAKSI : ".$FM_JNSTRANS,"
					<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>"),'',''
			);
			
		return array('TampilOpt'=>$TampilOpt);
	}				
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$arrKondisi = array();	
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		
		$c1input = $_COOKIE['cofmURUSAN'];
		$cinput = $_COOKIE['cofmSKPD'];
		$dinput = $_COOKIE['cofmUNIT'];
		$einput = $_COOKIE['cofmSUBUNIT'];
		$e1input = $_COOKIE['cofmSEKSI'];
		
		
		$Dari_jns_transaksi = cekPOST("Dari_jns_transaksi");
		$jns_transaksi = cekPOST("jns_transaksi",$Dari_jns_transaksi);
		
		if($Dari_jns_transaksi != ""){
			$c1input = cekPOST("ref_templatebarangSKPD2fmURUSAN");
			$cinput = cekPOST("ref_templatebarangSKPD2fmSKPD");
			$dinput = cekPOST("ref_templatebarangSKPD2fmUNIT");
			$einput = cekPOST("ref_templatebarangSKPD2fmSUBUNIT");
			$e1input = cekPOST("ref_templatebarangSKPD2fmSEKSI");
			
		}
		
		if($c1input != '' && $c1input != '0')$arrKondisi[] = "c1='$c1input'";
		if($cinput != '' && $cinput != '00')$arrKondisi[] = "c='$cinput'";
		if($dinput != '' && $dinput != '00')$arrKondisi[] = "d='$dinput'";
		if($einput != '' && $einput != '00')$arrKondisi[] = "e='$einput'";
		if($e1input != '' && $e1input != '000')$arrKondisi[] = "e1='$e1input'";
		if($jns_transaksi != '')$arrKondisi[] = "jns_trans='$jns_transaksi'";
		
		
		
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " jns $Asc1 " ;break;
			case '2': $arrOrders[] = " saldo $Asc1 " ;break;
			
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
	
	function BersihkanData(){
		global $DataPengaturan;
		$cek='';
		$tbl = "ref_templatebarang";
		$tbl_det = "ref_templatebarang_det";
		//Hapus ref_templatebarang ----------------------------------------------------------------------------------------
		$hapus = $DataPengaturan->QryDelData($tbl, "WHERE tgl_create < DATE_SUB(NOW(), INTERVAL 2 DAY) AND sttemp!='0'");
		$cek.=$hapus["cek"];
		
		//Hapus ref_templatebarang_det
		$hapus1 = $DataPengaturan->QryDelData($tbl_det,"WHERE tgl_create < DATE_SUB(NOW(), INTERVAL 3 HOUR) AND sttemp!='0'");
		$cek.=$hapus1["cek"];
		
		//Update ref_templatebarang_det
		$data = array(array("status",'0'));
		$upd1 = $DataPengaturan->QryUpdData($tbl_det,$data, "WHERE tgl_create < DATE_SUB(NOW(), INTERVAL 3 HOUR) AND sttemp='0' AND status!='0'");
		$cek.=$upd1["cek"];
		
		return $cek;
	}
	
	function Batal(){
		global $DataPengaturan;
		
		$cek='';$err='';$content='';
		$idplh = cekPOST($this->Prefix."_idplh");
		//Cek Apakah sttemp = "1"
		$qry_RTB = $DataPengaturan->QyrTmpl1Brs("ref_templatebarang", "*", "WHERE Id='$idplh' ");$cek.=$qry_RTB["hasil"];
		$dt_RTB = $qry_RTB["hasil"];
		
		if($err == ""){
			if($dt_RTB["sttemp"] == "1"){
				$hps_RTB = "DELETE FROM ref_templatebarang WHERE Id='$idplh' ";$cek.=$hps_RTB;
				$qry_hps_RTB = mysql_query($hps_RTB);
			}else{
				//Hapus sttemp='1'
				$hps_RTB_det = "DELETE FROM ref_templatebarang_det WHERE refid_templatebarang='$idplh' AND sttemp='1' "; $cek.=$hps_RTB_det;
				$qry_hps_RTB_det = mysql_query($hps_RTB_det);
				//UPDATE ref_templatebarang_det SET status='0' DIMANA sttemp='0' ----------------------------------------
				$data_upd = array(array("status", "0"),);
				$qry_upd_RTB_det = $DataPengaturan->QryUpdData("ref_templatebarang_det", $data_upd, "WHERE sttemp='0' "); $cek.=$qry_upd_RTB_det["cek"];
			}
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
		
		$cara_bayar = cekPOST("cara_bayar");
		$jns_transaksi = cekPOST("jns_transaksi", cekPOST2("Kdjns_tran"));
		$DariHalVersion = cekPOST2("DariHalVersion");
		
		$c1nya = cekPOST("c1nya");
		$cnya = cekPOST("cnya");
		$dnya = cekPOST("dnya");
		$enya = cekPOST("enya");
		$e1nya = cekPOST("e1nya");
		
		$RB = "ref_templatebarangSKPD2fm";
				
		$form_name = $this->FormName;
		//$ref_jenis=$_REQUEST['ref_jenis'];
		//if($err==''){
			$FormContent = $this->genDaftarInitial($ref_jenis);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						1000,
						500,
						'Pilih Template Barang',
						'',
						"
						<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' > ".
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						
						InputTypeHidden($RB."URUSAN",$c1nya).
						InputTypeHidden($RB."SKPD",$cnya).
						InputTypeHidden($RB."UNIT",$dnya).
						InputTypeHidden($RB."SUBUNIT",$enya).
						InputTypeHidden($RB."SEKSI",$e1nya).
						
						InputTypeHidden("cara_bayar",$cara_bayar).
						InputTypeHidden("Dari_jns_transaksi",$jns_transaksi).
						InputTypeHidden("DariHalVersion",$DariHalVersion).
						
						InputTypeHidden($this->Prefix."_idplh",$this->form_idplh).
						InputTypeHidden($this->Prefix."_fmST",$this->form_fmST).
						InputTypeHidden("sesi",$sesi)
						
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
		//}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setForm_content_fields(){
		$content = '';
		
		
		
		foreach ($this->form_fields as $key=>$field){
		
			$labelWidth = $field['labelWidth']==''? $this->formLabelWidth: $field['labelWidth'];
			$pemisah = $field['pemisah']==NULL? ':': $field['pemisah'];			
			$row_params = $field['row_params']==NULL? $this->row_params : $field['row_params'];
			
			$valign = $field['valign']==""?"top":$field['valign'];
			$valign = " valign='$valign' ";
			if(!isset($field['lewat'])){
				if ($field['type'] == ''){
					$val = $field['value'];
					$content .= 
						"<tr $row_params>
							<td style='width:$labelWidth' $valign>".$field['label']."</td>
							<td style='width:10' $valign>$pemisah</td>
							<td>". $val."</td>
						</tr>";
				}else if ($field['type'] == 'merge' ){
					$val = $field['value'];
					$content .= 
						"<tr $row_params>
							<td colspan=3 $valign>".$val."</td>
						</tr>";
				}else{
					$val = Entry($field['value'],$key,$field['param'],$field['type']);	
					$content .= 
						"<tr $row_params>
							<td style='width:$labelWidth' $valign>".$field['label']."</td>
							<td style='width:10' $valign>$pemisah</td>
							<td>". $val."</td>
						</tr>";
				}	
			}					
			
		}
		//$content = 
		//	"<tr><td style='width:100'>field</td><td style='width:10'>:</td><td>value</td></tr>";
		return $content;	
	}	
	
	
}
$ref_templatebarang = new ref_templatebarangObj();
?>