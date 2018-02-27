<?php

 include "pages/pencarian/DataPengaturan.php";
 $DataOption = $DataPengaturan->DataOption();

class cariPenyediaObj  extends DaftarObj2{	
	var $Prefix = 'cariPenyedia';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_penyedia'; //bonus
	var $TblName_Hapus = 'ref_penyedia';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
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
	var $Cetak_Judul = 'Pemasukan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'cariPenyediaForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	var $arr_cari = 
		array(
			array("nama_penyedia","NAMA PENYEDIA"),
			array("alamat","ALAMAT"),
			array("kota","KOTA"),
			array("nama_pimpinan","NAMA PIMPINAN"),
		);
		
	function setTitle(){
		return 'CARI PENYEDIA BARANG';
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
		case 'windowshow'				: $fm = $this->windowShow();break;
		case 'GetData'					: $fm = $this->GetData();break;	  	   
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
			fn_TagScript("js/pencarian/DataPengaturan.js").
			fn_TagScript("js/pencarian/".$this->Prefix.".js").
			$scriptload;
	}
	
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
		   <th class='th01' style='min-width:150px;'>NAMA</th>
		   <th class='th01'>ALAMAT</th>
		   <th class='th01'>KOTA</th>
		   <th class='th01'>PIMPINAN</th>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref, $DataPengaturan;
	 	 
	 $data = BtnText($isi['nama_penyedia'], $this->Prefix.".GetData(".$isi["id"].")");
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  /*if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);*/
	 $Koloms[] = array('align="left"',$data);
	 $Koloms[] = array('align="left"', $isi['alamat'] );
	 $Koloms[] = array('align="left"', $isi['kota']);
	 $Koloms[] = array('align="left"', $isi['nama_pimpinan']);
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main, $DataPengaturan;
	 
	 $checked = cekPOST2("fm_cbDESC") == "Y"?"checked='checked' ":"";
	 $DtSKPD = $DataPengaturan->GenViewSKPD5(cekPOST2("c1"), cekPOST2("c"), cekPOST2("d"), "100px");
	 
	 $TampilOpt =
	 	genFilterBar(array($DtSKPD),'','').
		genFilterBar(
			array(
				cmbArray("fmPILCARI",cekPOST2("fmPILCARI"),$this->arr_cari,"--- CARI BERDASARKAN ---","style='width:200px;'"),
				InputTypeText("fmPILCARIvalue", cekPOST2("fmPILCARIvalue"), "placeholder='PENCARIAN' size='70'"),
				InputTypeButton("btTampil", "CARI", " onclick='".$this->Prefix.".refreshList(true)' ")
			),			
		'','').
		genFilterBar(
			array(
				cmbArray("fmORDER",cekPOST2("fmORDER"),$this->arr_cari,"--- URUTKAN BERDASARKAN ---","style='width:200px;'").
				" ".InputTypeCheckbox("fm_cbDESC","Y", $checked)." Menurun.",
				InputTypeButton("btTampil1", "TAMPILKAN", " onclick='".$this->Prefix.".refreshList(true)' ")
			),			
		'','');
			
			
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		
		$fmPILCARI = cekPOST2('fmPILCARI');	
		$fmPILCARIvalue = cekPOST2('fmPILCARIvalue');
		$c1 = cekPOST2('c1');
		$c = cekPOST2('c');
		$d = cekPOST2('d');
		
		if($fmPILCARI != '' && $fmPILCARIvalue != '')$arrKondisi[] = " $fmPILCARI LIKE '%$fmPILCARIvalue%'";
		$arrKondisi[] = " c1='$c1'";		
		$arrKondisi[] = " c='$c'";		
		$arrKondisi[] = " d='$d'";		
		
		$Kondisi = join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER = cekPOST2('fmORDER');
		$fmDESC = cekPOST2('fm_cbDESC');			
		$Asc1 = $fmDESC ==''? '': 'desc';		
		$arrOrders = array();
		
		if($fmORDER != "")$arrOrders[] = "$fmORDER $Asc1";
				
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
	
	function setTopBar(){
	   	return '';
	}	
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
				
		$form_name = $this->FormName;
		$judul = "PILIH PENYEDIA BARANG";
		//if($err==''){
			$FormContent = $this->genDaftarInitial($ref_jenis);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						900,
						500,
						$judul,
						'',
						InputTypeHidden("c1",cekPOST2("c1nya")).
						InputTypeHidden("c",cekPOST2("cnya")).
						InputTypeHidden("d",cekPOST2("dnya")).
						InputTypeButton("Batal","BATAL", "onclick ='".$this->Prefix.".windowClose()' ")
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
		//}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function GetData(){
		global $DataPengaturan;
		$cek = ''; $err=''; $content='';
		
		$Id = cekPOST2("Id"); 		 
		$c1 = cekPOST2("c1"); 		 
		$c = cekPOST2("c"); 		 
		$d = cekPOST2("d"); 	
			 
		$qry = $DataPengaturan->QyrTmpl1Brs($this->TblName, "*","WHERE id='$Id' AND c1='$c1' AND c='$c' AND d='$d' ");$cek.=$qry["cek"];
		$dt = $qry["hasil"];
		
		if($dt["id"] == NULL || $dt["id"] == "")$err="Data Tidak Valid !";
		if($err == "")$content=$dt["id"];					
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
}
$cariPenyedia = new cariPenyediaObj();
?>