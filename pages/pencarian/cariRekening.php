<?php
 include "pages/pencarian/DataPengaturan.php";
 $DataOption = $DataPengaturan->DataOption();
 
class cariRekeningObj  extends DaftarObj2{	
	var $Prefix = 'cariRekening';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_rekening'; //bonus
	var $TblName_Hapus = 'ref_rekening';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('k','l','m','n','o');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'ADMINISTRASI SYSTEM';
	var $PageIcon = 'images/pengadaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pemasukan.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'cariRekening';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'cariRekeningForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	function setTitle(){
		return 'DAFTAR PROGRAM';
	}
	
	function setMenuEdit(){
		return "";
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
		case "windowshow"				: $fm = $this->windowShow(); break;
		case "getid"					: $fm = $this->Option_getid(); break;   
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
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
					</script>";
		return 	
			"<script type='text/javascript' src='js/pencarian/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			$scriptload;
	}
	
	//form ==================================
	
	
	function setPage_HeaderOther(){
		return "";			
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
	  	   <th class='th01' width='5'>NO.</th>".
	  	   /*$Checkbox*/"		
		   <th class='th01'>KODE REKENING</th>
		   <th class='th01'>NAMA REKENING</th>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 $koderekening = $isi['k'].".".$isi['l'].".".$isi['m'].".".$isi['n'].".".$isi['o'];
	 $jns_rek_pil = cekPOST2("jns_rek_pil");
	 if($jns_rek_pil == "form_pengeluaran"){
	 	$Data = BtnText($koderekening, $this->Prefix.".GetKodeRekening(`".$koderekening."`)");
	 }else{
	 	$Data = "<a href='javascript:".$this->Prefix.".pilRek(`".$koderekening."`)' >".$koderekening."</a>";
	 }
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  /*if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);*/
	 $Koloms[] = array('align="center" width="100"',$Data);
	 $Koloms[] = array('align="left"',$isi['nm_rekening']);
	 return $Koloms;
	}
	
	function PilJns_REK($jns_rek_pil){
		global $Ref, $Main, $DataPengaturan;	
		 
		switch ($jns_rek_pil){
			case "1":
				$isi_kode_rekeing = $Main->KODE_BELANJA_DIPILIH;
			break;
			case "2":
				$isi_kode_rekeing = $Main->KODE_BELANJA_DIPILIH;
			break;
		} 
		
		return $isi_kode_rekeing;
	}
	
	function QryRekening($field, $WHERE=''){
		$qry = "select $field, concat($field,'. ',nm_rekening) from ref_rekening $WHERE";
		
		return $qry;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main, $DataPengaturan;	 
	 
	 $arr = array(
			//array('selectAll','Semua'),	
			array('selectSatuan','Satuan'),		
			);
		
	 //data order ------------------------------
	 $arrOrder = array(
			     	array('1','Satuan'),
					);
	
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	
	$fmBIDANG = cekPOST('fmBIDANG');
	$fmKELOMPOK = cekPOST('fmKELOMPOK');
	$fmSUBKELOMPOK = cekPOST('fmSUBKELOMPOK');
	$fmSUBSUBKELOMPOK = cekPOST('fmSUBSUBKELOMPOK');
	$fmKODE = cekPOST('fmKODE');
	$fmBARANG = cekPOST('fmBARANG');
	$jns_rek_pil = $_REQUEST['jns_rek_pil'];
	$jns_transaksi = $_REQUEST['jns_transaksi_nya'];
	$refid = $_REQUEST['refid'];
	
	$kdisable ='';
	$ldisable ='';
	$mdisable ='';
	if($jns_rek_pil != '0'){
		$isi_kode_rekeing = $this->PilJns_REK($jns_rek_pil);		
		$kode_rekening= explode(".",$isi_kode_rekeing);
		
		$eksekusiFilter = TRUE;
		if($jns_transaksi == '2' && $jns_rek_pil == '2'){
			$eksekusiFilter = FALSE;
			$kdisable = "disabled";
			$ldisable = "disabled";
			$fmBIDANG = $Main->KODE_BELANJA;
			$fmKELOMPOK = $Main->KODE_BELANJA_LANGSUNG;
		}
		if($eksekusiFilter == TRUE){
			if(isset($kode_rekening[0]))if($kode_rekening[0] != '' || $kode_rekening[0] != null){
				$fmBIDANG=$kode_rekening[0];
				$kdisable ='disabled';
			}
			if(isset($kode_rekening[1]))if($kode_rekening[1] != '' || $kode_rekening[1] != null){
				$fmKELOMPOK=$kode_rekening[1];
				$ldisable ='disabled';
			}
			if(isset($kode_rekening[2]))if($kode_rekening[2] != '' || $kode_rekening[2] != null){
				$fmSUBKELOMPOK=$kode_rekening[2];
				$mdisable ='disabled';
			}
			
			$cekDataRekening=$this->getDataCekRekening($jns_rek_pil, $refid);
			if($cekDataRekening != ''){
				$fmSUBKELOMPOK=$cekDataRekening;
				$mdisable ='disabled';
			}
		}
		
		
	}
	
	$WHERE_o = "00";
	if($Main->REK_DIGIT_O == 1)$WHERE_o.="0";
	
	$WHERE_REK = 'WHERE ';
	
	$qry_bidang = $this->QryRekening("k", $WHERE_REK." k!='0' and l ='0' and m = '0' and n='00' and o='$WHERE_o' ");
	
	$WHERE_REK.=" k='$fmBIDANG' ";
	$qry_kelompok = $this->QryRekening("l", $WHERE_REK." and l !='0' and m = '0' and n='00' and o='$WHERE_o' ");
	
	//SETINGAN UPDATE 21 Februari 2018 Belanja Pegawai
	$where_m = $Main->PENERIMAAN_REK_BELANJAPEGAWAI == 0 && $jns_rek_pil == 1  && $jns_transaksi != 0?" AND m != '1' ":"";
	$WHERE_REK.=" and l ='$fmKELOMPOK' $where_m";
	$qry_Subkelompok = $this->QryRekening("m", $WHERE_REK." and m != '0' and n='00' and o='$WHERE_o' ");
	
	$WHERE_REK.=" and m ='$fmSUBKELOMPOK' ";
	$qry_SubSubkelompok = $this->QryRekening("n", $WHERE_REK." and n!='00' and o='$WHERE_o' ");
	
	$defStyle="onChange=\"$this->Prefix.refreshList(true)\" style='width:300px;' ";
	
	$TampilOpt =
			//<table width=\"100%\" class=\"adminform\">
			"<tr><td>".
			$vOrder=''.
				genFilterBar(
					array(
						$DataPengaturan->isiform(
							array(
								array(
									'label'=>'BIDANG',
									'label-width'=>'150px;',
									'value'=>cmbQuery("fmBIDANG",$fmBIDANG,$qry_bidang,"$defStyle $kdisable",'--- PILIH BIDANG ---',''),
								),
								array(
									'label'=>'KELOMPOK',
									'label-width'=>'150px;',
									'value'=>cmbQuery("fmKELOMPOK",$fmKELOMPOK,$qry_kelompok,"$defStyle $ldisable",'--- PILIH KELOMPOK ---',''),
								),
								array(
									'label'=>'SUB KELOMPOK',
									'label-width'=>'150px;',
									'value'=>cmbQuery("fmSUBKELOMPOK",$fmSUBKELOMPOK,$qry_Subkelompok,"$defStyle $mdisable",'--- PILIH SUB KELOMPOK ---',''),
								),
								array(
									'label'=>'SUB SUB KELOMPOK',
									'label-width'=>'150px;',
									'value'=>cmbQuery("fmSUBSUBKELOMPOK",$fmSUBSUBKELOMPOK,$qry_SubSubkelompok,$defStyle,'--- PILIH SUB SUB KELOMPOK ---',''),
								),
							
						)						
					)
				)
				,'','','').
				genFilterBar(
					array(
						"<table style='width:100%'>
						<tr><td>
							Kode Rekening : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' size=20px>&nbsp
							Nama Rekening : <input type='text' id='fmBARANG' name='fmBARANG' value='".$fmBARANG."' size=30px>&nbsp
							<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
						</td></tr>
						</table>"					
					)
				,'','','')
			/*genFilterBar(
				array(							
					WilSKPD_ajx3($this->Prefix.'SKPD'),
					),			
				'','');*/
				;
			
			
		return array('TampilOpt'=>$TampilOpt);
	}
	
	function getDataCekRekening($jns, $refid){
		global $DataPengaturan;
		$hasil ='';
		$tbl = '';
		
		if(addslashes($_REQUEST['jns_transaksi_nya']) == '2'){
			switch($jns){
				case "1":
					//Cek Dulu Di Atribusi Rincian
					$qry_cek = $DataPengaturan->QyrTmpl1Brs("t_atribusi_rincian","m", "WHERE refid_terima='$refid' AND status='0' AND sttemp='0' ORDER BY Id ");
					$daqry_cek = $qry_cek['hasil'];
					if($daqry_cek['m'] != '' || $daqry_cek['m'] != NULL ){	
						$hasil = $daqry_cek['m'];
					}else{
						$tbl = "t_penerimaan_rekening";
						$whererefid=" refid_terima='$refid' ";
					}
					
				break;
				case "2":
					$qry_refid_terima = $DataPengaturan->QyrTmpl1Brs("t_atribusi","refid_terima","WHERE Id='$refid'");
					$aqry_refid_terima = $qry_refid_terima['hasil'];
					
					$qry_cek = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_rekening","m", "WHERE refid_terima='".$aqry_refid_terima['refid_terima']."' AND status='0' AND sttemp='0' ORDER BY Id ");
					$daqry_cek = $qry_cek['hasil'];
					if($daqry_cek['m'] != '' || $daqry_cek['m'] != NULL ){	
						$hasil = $daqry_cek['m'];
					}else{
						$tbl = "t_atribusi_rincian";
						$whererefid=" refid_atribusi='$refid' ";
					}
				break;
			}
				
			if($tbl != ''){
				$qry = $DataPengaturan->QyrTmpl1Brs($tbl,"m", "WHERE $whererefid AND status='0' ORDER BY Id ");
				$daqry = $qry['hasil'];	
				$hasil = $daqry['m'];	
				//$hasil = $qry['cek'];	
			}
		}
		return $hasil;		
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
		
		$fmBIDANG = $_REQUEST['fmBIDANG'];
		$fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
		$fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
		$fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];
		$fmKODE = cekPOST('fmKODE');
		$fmBARANG = cekPOST('fmBARANG');
		$refid = addslashes($_REQUEST['refid']);
		//Cari 
		/*switch($fmPILCARI){			
			case 'selectSatuan': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;						 	
		}
		if(!empty($fmFiltTglBtw_tgl1)) $arrKondisi[]= " tgl_daftar>='$fmFiltTglBtw_tgl1'";
		if(!empty($fmFiltTglBtw_tgl2)) $arrKondisi[]= " tgl_daftar<='$fmFiltTglBtw_tgl2'";	*/
		if($fmBIDANG !='')$arrKondisi[] = " k = '$fmBIDANG'";
		if($fmKELOMPOK !='')$arrKondisi[] = " l = '$fmKELOMPOK'";
		if($fmSUBKELOMPOK !='')$arrKondisi[] = " m = '$fmSUBKELOMPOK'";
		if($fmSUBSUBKELOMPOK !='')$arrKondisi[] = " n = '$fmSUBSUBKELOMPOK'";
		
		
		//Filter Langsung
		$jns_rek_pil = $_REQUEST['jns_rek_pil'];
		$jns_transaksi = $_REQUEST['jns_transaksi_nya'];
		if($jns_rek_pil != '0'){
			$isi_kode_rekeing = $this->PilJns_REK($jns_rek_pil);	
			$kode_rekening= explode(".",$isi_kode_rekeing);
			
			$eksekusiFilter = TRUE;
			if($jns_transaksi == '2' && $jns_rek_pil == '2')$eksekusiFilter = FALSE;
			if($eksekusiFilter == TRUE){
				if(isset($kode_rekening[0]))if($kode_rekening[0] != '' || $kode_rekening[0] != null){
				$arrKondisi[] = " k = '".$kode_rekening[0]."'";
				}
				if(isset($kode_rekening[1]))if($kode_rekening[1] != '' || $kode_rekening[1] != null){
					$arrKondisi[] = " l = '".$kode_rekening[1]."'";
				}
				if(isset($kode_rekening[2]))if($kode_rekening[2] != '' || $kode_rekening[2] != null){
					$arrKondisi[] = " m = '".$kode_rekening[2]."'";
				}
				
				$cekDataRekening=$this->getDataCekRekening($jns_rek_pil, $refid);
				if($cekDataRekening != '')$arrKondisi[] = " m = '".$cekDataRekening."'";
			}	
			
		}
		
		//SETINGAN UPDATE 21 Februari 2018 Belanja Pegawai
		if($Main->PENERIMAAN_REK_BELANJAPEGAWAI == 0 && $jns_rek_pil == 1 && $jns_transaksi != 0)$arrKondisi[] = " m != '1'";
		
		if($jns_transaksi == '2' && $jns_rek_pil == '2'){
			$arrKondisi[] = " k = '$Main->KODE_BELANJA'";
			$arrKondisi[] = " l = '$Main->KODE_BELANJA_LANGSUNG'";
		}
		
		//SELESAI FILTER
		
		
		if(!empty($_POST['fmKODE'])) $arrKondisi[] = " concat(k,'.',l,'.',m,'.',n,'.',o) like '".$_POST['fmKODE']."%'";			if(!empty($_POST['fmBARANG'])) $arrKondisi[] = " nm_rekening like '%".$_POST['fmBARANG']."%'";
		
		$arrKondisi[] = " k != '0'";
		$arrKondisi[] = " l != '0'";
		$arrKondisi[] = " m != '0'";
		$arrKondisi[] = " n != '00'";
		if($Main->REK_DIGIT_O == 1){			
			$arrKondisi[] = " o != '000'";
		}else{
			
			$arrKondisi[] = " o != '00'";
		}
		
		//$arrKondisi[] = " q='00'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		/*if($fmORDER1 == ''){
			$arrOrders[] = " p ";
			$arrOrders[] = " q ";
		}
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
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
		$jns_rek_pil = cekPOST2('jns_rek_pil');
		$refid_pilih = cekPOST2('refid_pilih');
		$jns_transaksi = cekPOST2('jns_transaksi');
				
		$form_name = $this->FormName;
		$FormContent = $this->genDaftarInitial($ref_jenis);
		$form = centerPage(
				"<form name='$form_name' id='$form_name' method='post' action=''>".
				createDialog(
					$form_name.'_div', 
					$FormContent,
					900,
					500,
					'CARI REKENING',
					'',
					
					"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
					"<input type='hidden' value='' id='idrekeningnya1' >".
					"<input type='hidden' value='$jns_rek_pil' name='jns_rek_pil' id='jns_rek_pil' >".
					"<input type='hidden' id='CariBarang_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
					"<input type='hidden' id='CariBarang_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
					"<input type='hidden' id='sesi' name='sesi' value='$sesi' >".
					"<input type='hidden' id='refid' name='refid' value='$refid_pilih' >".
					"<input type='hidden' id='jns_transaksi_nya' name='jns_transaksi_nya' value='$jns_transaksi' >"
					,
					$this->form_menu_bawah_height
				).
				"</form>"
		);
		$content = $form;
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_getid(){
		$cek = ''; $err=''; $content=''; 
		$klmno = $_REQUEST['idrekening'];
		if($idrekening == '' && $err == '')$err == "Data Belum Dipilih !";
		
		if($err == ''){
			$qry = "SELECT * FROM ref_rekening WHERE concat(k,'.',l,'.',m,'.',n,'.',o) = '$klmno' ";$cek.=$qry;
			$aqry = mysql_query($qry);
			$daqry = mysql_fetch_array($aqry);
				
			
			$content['koderekening'] = $klmno;
			$content['namarekening'] = $daqry['nm_rekening'];
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
}
$cariRekening = new cariRekeningObj();
?>