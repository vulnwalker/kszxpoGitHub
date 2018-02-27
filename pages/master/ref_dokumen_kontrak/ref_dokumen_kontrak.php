<?php
 include "pages/pencarian/DataPengaturan.php";
 $DataOption = $DataPengaturan->DataOption();

class ref_dokumen_kontrakObj  extends DaftarObj2{	
	var $Prefix = 'ref_dokumen_kontrak';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_nomor_dokumen'; //daftar 
	var $TblName_Hapus = 'ref_nomor_dokumen';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Kelengkapan Dokumen';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'SKPD';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_dokumen_kontrakForm'; 
			
	function setTitle(){
		$ref = "REFRENSI ";
		$darijenis=cekPOST2("dari_jenis");
		if($darijenis != '')$ref='';
		return $ref.'DOKUMEN KONTRAK';
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
		global $HTTP_COOKIE_VARS, $Main, $DataPengaturan;
		$uid = $HTTP_COOKIE_VARS['coID'];
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		
		$c1= cekPOST("c1");
		$c= cekPOST("c");
		$d= cekPOST("d");
		
		$tgl_dok= cekPOST("tgl_doku")."-".$coThnAnggaran;
		$tgl_dok=FormatTanggalnya($tgl_dok);
		$nomdok= cekPOST("nomdok2");
		$tgl = explode("-", $tgl_dok);
		
	
		if($nomdok=='' && $err=="")$err="Nomor Dokumen Kontrak Belum di Isi !";
		if($tgl_dok=='' && $err=="")$err="Tanggal Belum di Isi !";
		if($err=='' && !cektanggal($tgl_dok))$err="Tanggal Tidak Valid !".$tgl_dok;
		
		$data = array(
					array("nomor_dok", $nomdok),
					array("tgl_dok", $tgl_dok),
				);
								
		if($err == ""){
			if($fmST == "0"){
				array_push($data,
					array("c1", $c1),
					array("c", $c),
					array("d", $d)
				);
				$qry = $DataPengaturan->QryInsData("ref_nomor_dokumen", $data);
				$qry_tmpl = $DataPengaturan->QyrTmpl1Brs2("ref_nomor_dokumen","*", $data, "ORDER BY Id DESC");
				$dt_tmpl = $qry_tmpl["hasil"];
			}else{
				$qry = $DataPengaturan->QryUpdData("ref_nomor_dokumen", $data, "WHERE Id='$idplh' ");
			}
			$cek.=$qry["cek"];
			$content = $fmST == "0"?$dt_tmpl["Id"]:$idplh;
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
		
		case 'PilDokumenKontrak':{				
			$fm = $this->PilDokumenKontrak();				
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
				
		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
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
   
   	function setPage_OtherScript(){
		global $DataPengaturan;
		$scriptload = 

					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			fn_TagScript('js/skpd.js').
			fn_TagScript('js/pencarian/DataPengaturan.js').
			fn_TagScript('js/master/ref_dokumen_kontrak/ref_dokumen_kontrak.js').
			$DataPengaturan->Gen_Script_DatePicker().		
			$scriptload;
	}
	
	function CekUbahData($id, $dari="Menghapus"){
		global $DataPengaturan;
		$err = '';
		
		$qry_dok = $DataPengaturan->QyrTmpl1Brs("ref_nomor_dokumen", "*", "WHERE Id='$id' ");
		$dt_dok = $qry_dok["hasil"];
		
		//Cek Di t_penerimaan_barang
		$hit = $DataPengaturan->QryHitungData("t_penerimaan_barang", "WHERE nomor_kontrak='".$dt_dok["nomor_dok"]."' AND tgl_kontrak='".$dt_dok["tgl_dok"]."' ");
		
		$hit1 = $DataPengaturan->QryHitungData("t_penerimaan_retensi", "WHERE nomor_kontrak='".$dt_dok["nomor_dok"]."' AND tgl_kontrak='".$dt_dok["tgl_dok"]."' ");
		
		if($err == "" && $hit["hasil"] > 0)$err = "Tidak Bisa $dari Data, Nomor Dokumen Sudah Digunakan !";
		if($err == "" && $hit1["hasil"] > 0)$err = "Tidak Bisa $dari Data, Nomor Dokumen Sudah Digunakan !";
		//if($err=="")$err="dsfd".$hit["cek"];
	
		
		return $err;
	}
	
	function setFormBaru(){
		global $DataOption, $HTTP_COOKIE_VARS;
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$cek='';$err='';$content='';
		
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek = $cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$dt=array();
		$this->form_fmST = 0;
		
		$dt["c1"] = cekPOST2($this->Prefix."SKPD2fmURUSAN","0");
		$dt["c"] = cekPOST2($this->Prefix."SKPD2fmSKPD","00");
		$dt["d"] = cekPOST2($this->Prefix."SKPD2fmUNIT","00");
		$dt["tgl_dok"] = date("d-m");
		$dt["thn_dok"] = $coThnAnggaran;
		
		if($err == "" && $DataOption["skpd"] != "1" && $dt["c1"] == "0")$err="URUSAN Belum di Pilih !";
		if($err == "" && $dt["c"] == "00")$err="BIDANG Belum di Pilih !";
		if($err == "" && $dt["d"] == "00")$err="SKPD Belum di Pilih !";
		
		if($err == ""){
			$fm = $this->setForm($dt);
			$cek.=$fm["cek"];
			$err=$fm["err"];
			$content=$fm["content"];			
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
		
	}
	
	function genDaftarHeader($Mode=1){
		$cek_aplikasi_jmldatapage = cekPOST("cek_aplikasi_jmldatapage");
		$hal = 25;
		if($cek_aplikasi_jmldatapage != '')$hal = intval($cek_aplikasi_jmldatapage);
		//mode :1.;ist, 2.cetak hal, 3. cetak semua
		global $Main;
		$rowspan_cbx = $this->checkbox_rowspan >1 ? "rowspan='$this->checkbox_rowspan'":'';
		$Checkbox = $Mode==1? 
			"<th class='th01' width='10' $rowspan_cbx>
					<input type='checkbox' name='".$this->Prefix."_toggle' id='".$this->Prefix."_toggle' value='' ".
						//" onClick=\"checkAll4($Main->PagePerHal,'".$this->Prefix."_cb','".$this->Prefix."_toggle','".$this->Prefix."_jmlcek');\" /> ".
						" onClick=\"checkAll4($Main->PagePerHal,'".$this->Prefix."_cb','".$this->Prefix."_toggle','".$this->Prefix."_jmlcek');".
							"$this->Prefix.checkAll($Main->PagePerHal,'".$this->Prefix."_cb','".$this->Prefix."_toggle','".$this->Prefix."_jmlcek')\" /> ".
						
			" </th>" : '';		
		$headerTable = $this->setKolomHeader($Mode, $Checkbox);
		return $headerTable;
	}
	
  	function setFormEdit(){
		global $DataPengaturan, $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$idplh = $cbid[0];
		$this->form_fmST = 1;				
		
		//get data 	
		$qry = $DataPengaturan->QyrTmpl1Brs("ref_nomor_dokumen", "*", "WHERE Id='$idplh' ");
		$dt = $qry["hasil"];
		
		if($err == "")$err=$this->CekUbahData($idplh, "Mengubah");
		
		if($err == ""){
			$dt["tgl_dok"]=FormatTanggalBulan($dt["tgl_dok"]);
			$dt["thn_dok"]=$coThnAnggaran;
			$fm = $this->setForm($dt);
			$cek.=$fm["cek"];
			$err=$fm["err"];
			$content=$fm["content"];			
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}	
	
	function setForm($dt){	
	 global $SensusTmp ,$Main,$DataPengaturan, $DataOption;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 550;
	 $this->form_height = 170;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU DOKUMEN KONTRAK';
	  }else{
		$this->form_caption = 'UBAH DOKUMEN KONTRAK';			
		$readonly='readonly';
					
	  }	  	    
		
	  $DataSKPD = $DataPengaturan->GenViewSKPD6($dt['c1'],$dt['c'],$dt['d']);  
	  //items ----------------------
	  $DataForm = array(
		'nomdok2' => array( 
					'label'=>'NOMOR',
					'value'=>InputTypeText("nomdok2",$dt["nomor_dok"] ,"style='width:380px;' placeholder='DOKUMEN KONTRAK'"),
					 ),
		'tgl' => array( 
					'label'=>'TANGGAL',
					'value'=>
						InputTypeText("tgl_doku",$dt["tgl_dok"], "class='datepicker2' style='width:40px;'").
						InputTypeText("thn_doku",$dt["thn_dok"], "style='width:40px;' readonly"), 				
					 ),						 
		);
			
			$this->form_fields=array_merge($DataSKPD,$DataForm);
		//tombol
		$this->form_menubawah =	
			InputTypeHidden("c1", $dt['c1']).
			InputTypeHidden("c", $dt['c']).
			InputTypeHidden("d", $dt['d']).
			InputTypeButton("Btn_sv","SIMPAN", "onclick ='".$this->Prefix.".Simpan()'")." ".
			InputTypeButton("Btn_bt","BATAL", "onclick ='".$this->Prefix.".Close()' ");
			
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	
		
	//daftar =================================	
	function setKolomHeader($Mode=1, $Checkbox=''){
	$NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox		
	   <th class='th01' width='100px' >TANGGAL</th>
	   <th class='th01'>NO DOKUMEN</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 $tgl = explode("-", $isi["tgl_dok"]);
	 $isi_tgl = $tgl[2]."-".$tgl[1]."-".$tgl[0];
	 
	 $isiNomorDok = $isi["nomor_dok"];
	 $dari_jenis = cekPOST2("dari_jenis");
	 if($dari_jenis != "")$isiNomorDok="<a href='#' onclick='".$this->Prefix.".PilDokumenKontrak(".$isi["Id"].");'>$isiNomorDok</a>";
	 	 	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	  $Koloms[] = array('align="center"',$isi_tgl);
	  $Koloms[] = array('align="left"',$isiNomorDok);
	 return $Koloms;
	}
		
	function genDaftarOpsi(){
	 global $Ref, $Main,$DataPengaturan, $HTTP_COOKIE_VARS;
	$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	$fmJns = $_REQUEST['fmJns'];	
	$crSyarat = $_REQUEST['crSyarat'];	
	
	$fmORDER1 = cekPOST2('fmORDER1');
	$fmDESC1 = cekPOST2('fmDESC1');
	$tgl_dokumen = cekPOST2("tgl_dokumen");
	$no_dokumen = cekPOST2("no_dokumen");
	
	$dari_jenis = cekPOST2("dari_jenis");
	
	$DataSKPD = genFilterBar(array(WilSKPD_ajx3($this->Prefix.'SKPD2')),"","");
	if($dari_jenis == "1"){
		$c1n=cekPOST2("c1n");
		$cn=cekPOST2("cn");
		$dn=cekPOST2("dn");
		$DataSKPD=genFilterBar(array($DataPengaturan->GenViewSKPD5($c1n,$cn,$dn,"100px")),"","");
	}
	$arr = array(	
			array('1','SPP-LS'),	
			array('2','SPP-UP'),
			array('3','SPP-GU'),	
			array('4','SPP-TU'),	
		
			);
	$TampilOpt = 
	"<tr><td>".
			$vOrder=
			$DataSKPD.
			genFilterBar(
				array(
				InputTypeText("tgl_dokumen", $tgl_dokumen, "class='datepicker2' placeholder='Tanggal' style='width:40px;'").
				InputTypeText("thn_dokumen", $coThnAnggaran, "readonly style='width:40px;'"),
				InputTypeText("no_dokumen", $no_dokumen, "placeholder='No Dokumen' style='width:380px;'"),
				InputTypeButton("btTampil", "CARI", "onclick='".$this->Prefix.".refreshList(true)' "),
				),'',''
			);
			
		return array('TampilOpt'=>$TampilOpt);
	}				
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		//kondisi -----------------------------------
		$arrKondisi = array();	
		$fmJns = $_REQUEST['fmJns'];
		$crSyarat = $_REQUEST['syarat'];
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		
		$c1input = $_COOKIE['cofmURUSAN'];
		$cinput = $_COOKIE['cofmSKPD'];
		$dinput = $_COOKIE['cofmUNIT'];		
		
		$tgl_dokumen = cekPOST2("tgl_dokumen");
		$tgl_dok = explode("-", $tgl_dokumen);
		$tgl_doknya = $tgl_dok[2]."-".$tgl_dok[1]."-".$tgl_dok[0];
		$no_dokumen = cekPOST2("no_dokumen");
		//UPDATE 9 Januari 2017
		$vers = cekPOST2("vers");
		if($vers == 1){
			$c1nya=cekPOST2("c1n");
			$cnya=cekPOST2("cn");
			$dnya=cekPOST2("dn");
			
			//$arrKondisi[] = "concat(tgl_dok,'.',nomor_dok) NOT IN (SELECT concat(tgl_kontrak,'.',nomor_kontrak) as nomor FROM t_penerimaan_barang WHERE c1='$c1nya' AND c='$cnya' AND d='$dnya' AND sttemp='0' AND cara_bayar='3' )";
			$arrKondisi[] = "concat(tgl_dok,'.',nomor_dok) IN (SELECT concat(tgl_kontrak,'.',nomor_kontrak) as nomor FROM t_penerimaan_barang WHERE c1='$c1nya' AND c='$cnya' AND d='$dnya' AND sttemp='0' AND cara_bayar='2' )";
		}
		
		$dari_jenis = cekPOST("dari_jenis");	
		if($dari_jenis == "1"){
			$c1n=cekPOST2("c1n");
			$cn=cekPOST2("cn");
			$dn=cekPOST2("dn");
			
			$arrKondisi[] = "c1='$c1n'";
			$arrKondisi[] = "c='$cn'";
			$arrKondisi[] = "d='$dn'";
			if($Main->TAHUN_RETENSI_SBLM == 1){
				$arrKondisi[] = "tgl_dok<'".$coThnAnggaran."-01-01'";
			}else{
				$arrKondisi[] = "tgl_dok<'".$coThnAnggaran."-12-31'";
			}
			
		}else{
			if($c1input != '' && $c1input != '0')$arrKondisi[] = "c1='$c1input'";
			if($cinput != '' && $cinput != '00')$arrKondisi[] = "c='$cinput'";
			if($dinput != '' && $dinput != '00')$arrKondisi[] = "d='$dinput'";
		}
		
		if($tgl_dokumen != '')$arrKondisi[] = "tgl_dok='$coThnAnggaran-$tgl_doknya'";
		if($no_dokumen != '')$arrKondisi[] = "nomor_dok like '%".$no_dokumen."%' ";
		
		if(empty($fmJns)) {
			
		}
		elseif(!empty($fmJns))
		{
			$arrKondisi[]= "jns =$fmJns";
		}
		if(!empty($_POST['fmJns']) ) $arrKondisi[] = " jns like '%".$_POST['fmJns']."%'";
		if(!empty($_POST['crSyarat']) ) $arrKondisi[] = " syarat like '%".$_POST['crSyarat']."%'";
		//Cari 
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			
			case 'selectNama': $arrKondisi[] = " nama_rek like '%$fmPILCARIvalue%'"; break;	
			case 'selectRuang': $arrKondisi[] = " syarat like '%$fmPILCARIvalue%'"; break;	
								 	
		}	
		
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		$arrOrders[] = " tgl_dok DESC " ;
	/*	switch($fmORDER1){
			case '1': $arrOrders[] = " jns $Asc1 " ;break;
			case '2': $arrOrders[] = " saldo $Asc1 " ;break;
			
		}	*/
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
	
	function Hapus_Validasi($id){
		$errmsg =$this->CekUbahData($id);		
		return $errmsg;
	}
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
		
		$c1 = cekPOST2("c1nya");
		$c = cekPOST2("cnya");
		$d = cekPOST2("dnya");
		$dari_jenis = cekPOST2("dari_jenis");
				
		$form_name = $this->FormName;
		
			$FormContent = $this->genDaftarInitial($ref_jenis);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						1000,
						500,
						'Pilih Dokumen Kontrak',
						'',
						InputTypeButton("Btn_close", "BATAL", "onclick ='".$this->Prefix.".windowClose()'" ).
						InputTypeHidden("dari_jenis",$dari_jenis).
						InputTypeHidden("c1n",$c1).
						InputTypeHidden("cn",$c).
						InputTypeHidden("dn",$d).
						InputTypeHidden("vers",cekPOST2("vers")).
						
						"<input type='hidden' value='$c1' id='".$this->Prefix."SKPD2' name='".$this->Prefix."SKPD2fmURUSAN' >".
						"<input type='hidden' value='$c' id='".$this->Prefix."SKPD2' name='".$this->Prefix."SKPD2fmSKPD' >".
						"<input type='hidden' value='$d' id='".$this->Prefix."SKPD2' name='".$this->Prefix."SKPD2fmUNIT' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
		//}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function PilDokumenKontrak(){
		global $DataPengaturan;
		$cek='';$err='';$content=array();
		
		$Idnya = cekPOST2("Idnya");
		$qry = $DataPengaturan->QyrTmpl1Brs($this->TblName, "*", "WHERE Id='$Idnya'");
		$dt = $qry["hasil"];
		
		if($dt["Id"] != NULL){
			$tgl_dok_copy = explode("-",$dt["tgl_dok"]);
			$content['tgl_dokcopy'] = $tgl_dok_copy[2]."-".$tgl_dok_copy[1]."-".$tgl_dok_copy[0];
			$content["tgl_dok"] = $dt["tgl_dok"];
			$content["nomor_dok"] = $dt["nomor_dok"];
		}else{
			$err="Nomor Dokumen Tidak Valid !";
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
}
$ref_dokumen_kontrak = new ref_dokumen_kontrakObj();
?>