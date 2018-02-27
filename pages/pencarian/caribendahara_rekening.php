<?php

include "pages/pencarian/DataPengaturan.php";

class caribendahara_rekeningObj  extends DaftarObj2{	
	var $Prefix = 'caribendahara_rekening';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_norek_bendahara'; //bonus
	var $TblName_Hapus = 'ref_norek_bendahara';
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
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pemasukan.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'Pemasukan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'caribendahara_rekeningForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	function setTitle(){
		return 'PENERIMA PIHAK KE-3';
	}
	
	function setMenuEdit(){
		return "";
	}
	
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
		case 'windowshow':{
			$fm = $this->windowShow();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];	
		break;
		}
		
		case 'pilData':{
			$fm = $this->pilData();
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
	  	   $Checkbox		
		   <th class='th01'>NAMA</th>
		   <th class='th01' width='30%'>ALAMAT</th>
		   <th class='th01'>BANK/ REKENING</th>
		   <th class='th01'>NPWP</th>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 $nama_penyedia = $isi['nama'];
	 $dari_widwowsshow = cekPOST2("dari_widwowsshow");
	 
	 if($dari_widwowsshow == "1"){
	 	$nama_penyedia =  "<a href='javascript:".$this->Prefix.".Get_PilData(`".$isi['Id']."`)' >$nama_penyedia</a>";
	 }
	 	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="left"', $nama_penyedia);
	 $Koloms[] = array('align="left"', $isi['alamat']);
	 $Koloms[] = array('align="left"', $isi['bank']."/ <br>".$isi['no_rekening']);
	 $Koloms[] = array('align="left"', $isi['npwp']);
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 
	 $arr = array(
				array('nama','NAMA'),		
				array('alamat','ALAMAT'),		
				array('bank','NAMA BANK'),				
				array('npwp','NO NPWP'),		
			);
		
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
	
	$TampilOpt =
			//<table width=\"100%\" class=\"adminform\">
			"<tr><td>".
			$vOrder=
			genFilterBar(
				array(
					cmbArray("fmPILCARI",cekPOST2("fmPILCARI"),$arr,"--- CARI BERDASARKAN ---",''),
					InputTypeText("fmPILCARIvalue",cekPOST2("fmPILCARIvalue"),"placeholder='PENCARIAN' size='70'"),
					InputTypeButton("btTampil","CARI", " onclick='".$this->Prefix.".refreshList(true)'")),			
				'','');
				;
			
			
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
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
					
		if($fmPILCARI !='' && $fmPILCARIvalue != '')$arrKondisi[] = " $fmPILCARI like '%$fmPILCARIvalue%' ";
		
		$arrKondisi[] = " c1='".cekPOST2("c1")."' ";
		$arrKondisi[] = " c='".cekPOST2("c")."' ";
		$arrKondisi[] = " d='".cekPOST2("d")."' ";
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		/*if($fmORDER1 == ''){
			$arrOrders[] = " bk ";
			$arrOrders[] = " ck ";
			$arrOrders[] = " dk ";
			$arrOrders[] = " p ";
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
						'Pilih Bendahara Penerima',
						'',
						/*"
						<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".*/
						InputTypeHidden("dari_widwowsshow","1").
						InputTypeHidden("c1",cekPOST2("c1nya")).
						InputTypeHidden("c",cekPOST2("cnya")).
						InputTypeHidden("d",cekPOST2("dnya")).
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='CariBarang_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
						"<input type='hidden' id='CariBarang_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >"
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
		
		if($err == '' && $id=='')$err="Data Tidak Valid !";
		if($err == ""){
			$qry = $DataPengaturan->QryHitungData("ref_norek_bendahara","WHERE Id='$id' AND c1='$c1' AND c='$c' AND d='$d'");
			if($qry["hasil"] < 1)$err="Data Tidak Valid !";
		}
		
		if($err=="")$content=$id;
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
}
$caribendahara_rekening = new caribendahara_rekeningObj();
?>