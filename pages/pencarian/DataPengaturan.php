<?php
function cekPOST2($name, $val=''){
	if(isset($_REQUEST[$name])){
		if($_REQUEST[$name] != ''){
			$val = addslashes($_REQUEST[$name]);
			$val = htmlspecialchars($val);
		}		
	}
	
	return $val;
}

function cekPOST2Float($name, $val=0){
	if(isset($_REQUEST[$name])){
		if($_REQUEST[$name] != ''){
			$val = addslashes($_REQUEST[$name]);
			$val = htmlspecialchars($val);
		}		
	}
	
	$val = floatval($val);	
	return $val;
}

function cekPOST_Arr($name, $no, $val=''){
	if(isset($_REQUEST[$name][$no])){
		if($_REQUEST[$name][$no] != ''){
			$val = addslashes($_REQUEST[$name][$no]);
			$val = htmlspecialchars($val);
		}		
	}
	
	return $val;
}

function FormatTanggalnya($tgl){
	if($tgl != ''){
		$tgl = explode("-",$tgl);
		$tgl = $tgl[2]."-".$tgl[1]."-".$tgl[0];
	}	
	return $tgl;
}

function FormatTanggalBulan($tgl){
	$tgl = explode("-",$tgl);
	$tgl = $tgl[2]."-".$tgl[1];
	return $tgl;
}

function GetTahunFromDB($tgl){
	$tgl = explode("-",$tgl);
	$tgl = $tgl[0];
	return $tgl;
}

function InputTypeHidden($name,$value){
	return '<input type="hidden" name="'.$name.'" value="'.$value.'" id="'.$name.'"/>';
}

function InputTypeText($name, $val, $style="style='width:300px;'"){
	return "<input type='text' name='$name' id='$name' value='$val' $style />";
}

function InputTypeNumber($name, $val, $style="style='width:300px;'"){
	return "<input type='number' name='$name' id='$name' value='$val' $style />";
}

function InputTypeTextArea($name, $val, $style="style='width:300px;'"){
	return "<textarea name='$name' id='$name' $style >$val</textarea>";
}

function InputTypeButton($name, $val='', $style=""){
	return "<input type='button' name='$name' id='$name' value='$val' $style />";
}

function InputTypeCheckbox($name, $val='', $style=""){
	return "<input type='checkbox' name='$name' id='$name' value='$val' $style />";
}

function FormatUang($val){
	return number_format($val, 2, ",",".");
}

function FormatAngka($val){
	return number_format($val, 0, ".",",");
}

function GenCmbQuery($name='txtField', $value='', $query='', $param='', $StatAtis=TRUE,$Atas='Pilih', $vAtas='') {
    global $Ref;
    $Input = $StatAtis==TRUE?"<option value='$vAtas'>$Atas</option>":"";
    $Query = mysql_query($query);
    while ($Hasil = mysql_fetch_row($Query)) {
        $Sel = $Hasil[0] == $value ? "selected" : "";
        $Input .= "<option $Sel value='{$Hasil[0]}'>{$Hasil[1]}";
    }
    $Input = "<select $param name='$name' id='$name'>$Input</select>";
    return $Input;
}

function Msg_Dt_TdkVld(){
	return "Data Tidak Valid !";
}

function genFilterBarKhusus($Filters, $onClick, $withButton=TRUE, $TombolCaption='Tampilkan', $Style='FilterBar'){
	$Content=''; $i=0;
	while( $i < count($Filters) ){
		$border	= $i== count($Filters)-1 ? '' : "border-right:1px solid #E5E5E5;";		
		$Content.= "<td  align='left' style='padding:1 8 0 8; $border'>".
						$Filters[$i].
					"</td>";
		$i++;
	}
	//tombol
	if($withButton){
		$Content.= "<td  align='left' style='padding:1 8 0 8;'>
					<input type=button id='btTampil' value='$TombolCaption' 
						onclick=\"$onClick\">
				</td>";		
	}
		
	/*return  "
		<table class='$Style' width='100%' style='margin: 4 0 0 0' cellspacing='0' cellpadding='0' border='0'>
		<tr><td>
			<table cellspacing='0' cellpadding='0' border='0'>
			<tr valign='middle'>   						
				$Content				
			</tr>
			</table>
		</td><td width='*'>&nbsp</td></tr>		
		</table>";	*/
	return  "
		<!--<table class='$Style' width='100%' style='margin: 4 0 0 0' cellspacing='0' cellpadding='0' border='0'>
		<tr><td> -->
		<div class='$Style' >
			<table style='width:100%'><tr><td align=left>
			<table cellspacing='0' cellpadding='0' border='0' style='height:28;width:100%'>
			<tr valign='middle'>   						
				$Content				
			</tr>
			</table>
			</td></tr></table>
		</div>
		<!--</td><td width='*'>&nbsp</td>
		</tr>		
		</table>-->
		
		";	
}

function BtnImg_Cari($fungsi, $judul="Cari", $style=" style='width:20px;height:20px;margin-bottom:-5px;' "){
	return "<a href='javascript:".$fungsi.";' title='$judul'> 
				<img src='datepicker/search.png' $style  />
			</a>";
}

function BtnImgSave($fungsi, $judul="Simpan",$style=" style='width:20px;height:20px;' "){
	return "<a href='javascript:".$fungsi."' title='$judul' >
				<img src='datepicker/save.png' $style />
			</a>";
}

function BtnImgSave2($fungsi, $judul="Simpan",$style=" style='width:20px;height:20px;' "){
	return "<a href='javascript:".$fungsi."' title='$judul' >
				<img src='datepicker/save2.png' $style />
			</a>";
}

function BtnImgCancel($fungsi, $judul="Batal", $style=" style='width:20px;height:20px;' "){
	return "<a href='javascript:".$fungsi."' title='$judul' >
				<img src='datepicker/cancel.png' $style />
			</a>";
}

function BtnImgAdd($fungsi,$judul="Tambah Data", $style=" style='width:20px;height:20px;' "){
	return "<a href='javascript:".$fungsi."' title='$judul' >
				<img src='datepicker/add-256.png' $style />
			</a>";
}

function BtnImgDelete($fungsi,$judul="Hapus", $style=" style='width:20px;height:20px;' "){
	return "<a href='javascript:".$fungsi."')' title='$judul' >
				<img src='datepicker/remove2.png' $style />
			</a>";
}

function BtnImgDelete2($fungsi,$judul="Hapus", $style=" style='width:20px;height:20px;' "){
	return "<a href='javascript:".$fungsi."')' title='$judul' >
				<img src='datepicker/remove3.png' $style />
			</a>";
}

function BtnImgUpdate($fungsi,$judul="Ubah Data", $style=" style='width:20px;height:20px;' "){
	return "<a href='javascript:".$fungsi."')' title='$judul' >
				<img src='datepicker/edit-icon.png' $style />
			</a>";
}

function BtnImgCopy($fungsi,$judul="Gandakan Data", $style=" style='width:20px;height:20px;' "){
	return "<a href='javascript:".$fungsi."')' title='$judul' >
				<img src='images/administrator/images/move_f2.png' $style />
			</a>";
}

function BtnImgTemplate($fungsi,$judul="Template", $style=" style='width:20px;height:20px;' "){
	return "<a href='javascript:".$fungsi."')' title='$judul' >
				<img src='images/administrator/images/icon_template.png' $style />
			</a>";
}

function BtnText($val, $functionnya, $style=''){
	return "<a href='javascript:".$functionnya."' $style >".$val."</a>";
}

function LabelSPan1($Id, $value, $style=''){
	return "<span id='$Id' $style >$value</span>";
}

function LabelDiv1($style='', $value=''){
	return "<div $style >$value</div>";
}

function Tbl_Td($val='', $align='left', $style='', $ulang=1){
	$data = "";
	for($i=0;$i<$ulang;$i++){$data.="<td align='$align' $style >$val</td>";}
	return $data;
}

function fn_TagScript($src){
	return "<script type='text/javascript' src='$src' language='JavaScript' ></script>";
}

function QueryJoin($tabel=array(), $join='', $select='*' ,$On=array(),$where=array(),$order = ""){
	$qry = '';
	$wherenya='';
	$Onya='';
	if(isset($tabel[0]) && isset($tabel[1])){
		for($a=0;$a<count($On);$a++){
			if($a != 0)$Onya .= ' AND ';
			$penghubung = isset($On[$i][2])?$On[$i][2]:"=";
			$Onya .= " ".$On[$a][0]." $penghubung ".$On[$a][1];
		}
		
		for($i=0;$i<count($where);$i++){
			if($i != 0){
				$wherenya .= ' AND ';
			}
			$pembanding = isset($where[$i][2])?$where[$i][2]:"=";
			$wherenya .= $where[$i][0]." $pembanding '".$where[$i][1]."'";
		}
		$wherenya = $wherenya==""?"":"WHERE ".$wherenya;
		$qry = "SELECT $select FROM ".$tabel[0]." $join ".$tabel[1]." ON $Onya $wherenya $order";
	}
	
	return $qry;
	
} 

function QueryTmplBrs($tablenya, $field='*',$where = array(), $order='') {
	$wherenya = '';
	for($i=0;$i<count($where);$i++){
		if($i != 0){
			$wherenya .= ' AND ';
		}
		$pembanding = isset($where[$i][2])?$where[$i][2]:"=";
		$wherenya .= $where[$i][0]." $pembanding '".$where[$i][1]."'";
	}

	if($wherenya != '')$wherenya = "WHERE ".$wherenya;
	$qry = "SELECT $field FROM $tablenya $wherenya $order";				
	return $qry;
}

function QueryTmplBrs2($tablenya, $field='*',$where, $order='') {
	$qry = "SELECT $field FROM $tablenya $where $order";				
	return $qry;
}

function Format4Digit($val){
	$hit = strlen($val);
	
	switch($hit){
		case 1:$val="000".$val;break;
		case 2:$val="00".$val;break;
		case 3:$val="0".$val;break;
	}
	
	return $val;
}

class DataPengaturanObj  extends DaftarObj2{	
	var $Prefix = 'DataPengaturan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_pengaturan'; //bonus
	var $TblName_Hapus = 't_pengaturan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'PENGADAAN DAN PENERIMAAN';
	var $PageIcon = 'images/administrator/images/InformationSetting.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='DataPengaturan.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'DataPengaturan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'DataPengaturanForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	var $FieldC1 = 0;
	// REFID KATEGORI TANDA TANGAN
	var $kat_PENERIMABARANG = 1;
	var $kat_PA_KPA = 16;
	var $kat_PPK = 17; //PEJABAT PEMBUAT KOMITMEN
	var $kat_PPTK = 18;
	var $kat_BPP = 19; //BENDAHARA PENGELUARAN PEMBANTU	
	var $kat_BP = 20; //BENDAHARA PENGELUARAN	
	var $kat_TTD_SPM = 21; //PENANDATANGAN SPM
	var $kat_TTD_SP2D = 22; //PENANDATANGAN SP2D
	
	var $Tbl_Temp = "temp_data";
	var $Tbl_Temp_det = "temp_data_det";

	var $arrEselon = array( 
		array('1','ESELON I'),
		array('2','ESELON II'),
		array('3','ESELON III'),
		array('4','ESELON IV'),
		array('5','ESELON V')
		);
		
	var $jns_trans = array(
			//array('selectAll','Semua'),	
			array('1','PENGADAAN BARANG'),	
			array('2','PEMELIHARAAN BARANG'),			
			);
			
	var $arr_jns_trans = array(
			"1"=>"Pengadaan Barang",			
			"2"=>"Pemeliharaan Barang",			
			"3"=>"Persediaan Barang",			
			);
	
	var $arr_jns_trans_2 = array(
			"1"=>"Pengadaan",			
			"2"=>"Pemeliharaan",			
			"3"=>"Persediaan",			
			);
			
	var $arr_pencairan_dana = array(
			array('1', "SPP-LS"),
			array('2', "SPP-UP"),
			array('3', "SPP-GU"),
			array('4', "SPP-TU"),
			);
				
	var $Daftar_arr_pencairan_dana_SPM = array(
			'1' => "SPM-LS",
			'2' => "SPM-UP",
			'3' => "SPM-GU",
			'4' => "SPM-TU");
			
	var $Daftar_arr_pencairan_dana_SP2D = array(
			'1' => "SP2D-LS",
			'2' => "SP2D-UP",
			'3' => "SP2D-GU",
			'4' => "SP2D-TU");
	
	var $Daftar_arr_pencairan_dana = array(
			'1' => "SPP-LS",
			'2' => "SPP-UP",
			'3' => "SPP-GU",
			'4' => "SPP-TU");
	
	var $Daftar_arr_pencairan_dana2 = array(
			'1' => "SPPLS",
			'2' => "SPPUP",
			'3' => "SPPGU",
			'4' => "SPPTU");
			
	var $Daftar_arr_pencairan_dana_SPM2 = array(
			'1' => "SPMLS",
			'2' => "SPMUP",
			'3' => "SPMGU",
			'4' => "SPMTU");
			
	var $Daftar_arr_pencairan_dana_SP2D2 = array(
			'1' => "SP2DLS",
			'2' => "SP2DUP",
			'3' => "SP2DGU",
			'4' => "SP2DTU");
			
	var $arr_cara_bayar = array(
			//array('selectAll','Semua'),	
			//array('1','UANG MUKA'),	
			array('2','TERMIN'),			
			array('3','LUNAS'),			
			);
			
	var $Daftar_arr_cara_bayar = array(
			'1' => "UANG MUKA",
			'2' => "TERMIN",
			'3' => "LUNAS");
			
	var $arr_metode_pengad = array(
			array('1', "PIHAK KE 3"),
			array('2', "SWAKELOLA"),
			);
	
	var $arr_cara_perolehan = array(
			array('1','PEMBELIAN'),	
			array('2','HIBAH'),			
			array('3','LAINNYA'),			
			);
	var $arr_JNS_TRANS = array(
			"1"=>"PENGADAAN",
			"2"=>"PEMELIHARAAN",
			"3"=>"PERSEDIAAN",
		);
	
	var $arr_JNS_TRANS2 = array(
			"1"=>"PENGADAAN",
			"2"=>"PEMELIHARAAN",
			"3"=>"PERSEDIAAN",
		);
	var $CekDistribusi = 1; //1=Ya, 0=Tidak
			
	function setTitle(){
		return 'PENGATURAN PENGADAAN DAN PENERIMAAN';
	}
	
	function setMenuEdit(){
		return "";
	}
	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $nama= $_REQUEST['nama'];
	  
	 if( $err=='' && $nama =='' ) $err= 'Satuan Belum Di Isi !!';
	 
			if($fmST == 0){
				if($err==''){
					$aqry = "INSERT into ref_satuan (nama)values('$nama')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{						
				if($err==''){
				$aqry = "UPDATE ref_satuan set nama='$nama' WHERE Id='".$idplh."'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());
					}
			} //end else
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function SimpanUbah(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	
		$Idplh = addslashes($_REQUEST['IDNYA']);		
	 	$nama_bidang = addslashes($_REQUEST['nama_bidang']);
	 	$nama_skpd = addslashes($_REQUEST['nama_skpd']);
	 	$alamat = addslashes($_REQUEST['alamat']);
	 	$kota = addslashes($_REQUEST['kota']);
		
	 	$titimangsa_surat = addslashes($_REQUEST['titimangsa_surat']);
	 	$nama_aplikasi = addslashes($_REQUEST['nama_aplikasi']);
	 	
	 	$def_atrib = addslashes($_REQUEST['def_atrib']);
		
		if($err == '' && $nama_bidang == '')$err="Nama Bidang Belum di Isi !";
		if($err == '' && $nama_skpd == '')$err="Nama SKPD Belum di Isi !";
		if($err == '' && $alamat == '')$err="Alamat Belum di Isi !";
		if($err == '' && $kota == '')$err="Kota Belum di Isi !";
		
		if($err == '' && $titimangsa_surat == '')$err="Titimangsa Surat Belum di Isi !";
		if($err == '' && $nama_aplikasi == '')$err="Nama Aplikasi Belum di Isi !";
		if($err == '' && $def_atrib == '')$err="Setelan Otomatis Biaya Atribusi Belum di Pilih !";
		
		if(isset($_REQUEST['ver_skpd'])){
			$ver_skpd = addslashes($_REQUEST['ver_skpd']);
	 		$ver_kodebarang = addslashes($_REQUEST['ver_kodebarang']);
			
			if($err == '' && $ver_skpd == '')$err="Versi SKPD Belum di Pilih !";
			if($err == '' && $ver_kodebarang == '')$err="Versi Kode Barang Belum di Pilih !";
			
			$filter = ", skpd='$ver_skpd', kode_barang='$ver_kodebarang' ";
		}
		
		if($err == ''){
			$qry = "UPDATE ".$this->TblName." SET nama_bidang='$nama_bidang', nama_skpd='$nama_skpd', alamat='$alamat', kota='$kota', titimangsa_surat='$titimangsa_surat', nama_aplikasi='$nama_aplikasi' $filter, harga_atribusi='$def_atrib' WHERE Id='$Idplh'";$cek.=$qry;
			$aqry = mysql_query($qry);
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
		case 'formBaru'					: $fm = $this->setFormBaru();break;
		case 'formEdit'					: $fm = $this->setFormEdit();break;
		case 'UbahPengaturan'			: $fm = $this->UbahData();break;
		case 'simpan'					: $fm = $this->simpan();break;
		case 'SimpanUbah'				: $fm = $this->SimpanUbah();break;
		case 'SimpanUbah'				: $fm = $this->SimpanUbah();break;
		case 'windowshow'				: $fm = $this->windowShow();break;
		case 'pilihan'					: $fm = $this->setTemplate();break;
		case 'DataSkpd'					: $fm = $this->DataSkpd();break;
	   
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
			"<script type='text/javascript' src='js/pencarian/".$this->Prefix.".js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/pengadaanpenerimaan/pemasukan_ins.js' language='JavaScript' ></script>".
			'
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>
			'.
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
	return "
	<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
		<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
			<A href=\"pages.php?Pg=pemasukan&halman=1\" title='PENGADAAN' >PENGADAAN</a> | 
			<A href=\"pages.php?Pg=pemasukan&halman=2\" title='PEMELIHARAAN' >PEMELIHARAAN</a> 
			&nbsp&nbsp&nbsp	
			</td>
		</tr>
	</table>";
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
	  	   <th class='th01' width='5'>No.</th>".
	  	   /*$Checkbox*/"		
		   <th class='th01'>NAMA</th>
		   <th class='th01'>JUMLAH</th>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  /*if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);*/
	 $Koloms[] = array('align="left" width="15%"',"<a href='javascript:".$this->Prefix.".pilihan(`".$isi['id']."`)' >".$isi['nama']."</a>");
	 $Koloms[] = array('align="right"',number_format($isi['jumlah'],0,'.',','));
	 return $Koloms;
	}
	
	function setMenuView(){
		return 
			
			"";				
			
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 	 
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST2('fmORDER1');
	$fmDESC1 = cekPOST2('fmDESC1');
	
	
	$daqry =$this->DataOption();
	
	//KODE SKPD
	$VerSKPD = '';
	if($daqry['skpd'] == '1')$VerSKPD = "PERMENDAGRI NO.17 TAHUN 2007";
	if($daqry['skpd'] == '2')$VerSKPD = "PERMENDAGRI NO.19 TAHUN 2016";
	
	//KODE BARANG
	$VerKodeBarang = '';
	if($daqry['kode_barang'] == '1')$VerKodeBarang = "PERMENDAGRI NO.17 TAHUN 2007";
	if($daqry['kode_barang'] == '2')$VerKodeBarang = "PERMENDAGRI NO.19 TAHUN 2016";
	
	//
	$harga_atribusi = 'TIDAK';
	if($daqry['harga_atribusi'] == 1)$harga_atribusi = 'YA';
	
	$TampilOpt =
			//<table width=\"100%\" class=\"adminform\">
			"<tr><td>".
			$vOrder=
			"<div id='DaftarPengaturan'>".
			genFilterBar(
				array(
					$this->isiform(
						array(
							array(
								'label'=>'<b>KEPADA YTH</b>',
								'pemisah'=>'',
							),
						)
					).						
					$this->isiform(
						array(
							array(
								'label'=>'Nama Bidang/bagian',
								'name'=>'nama_bidang',
								'label-width'=>'210px;',
								'value'=>$daqry['nama_bidang'],
							),
							array(
								'label'=>'Nama SKPD',
								'name'=>'nama_skpd',
								'label-width'=>'210px;',
								'value'=>$daqry['nama_skpd'],
							),
							array(
								'label'=>'Alamat',
								'name'=>'alamat',
								'label-width'=>'210px;',
								'value'=>$daqry['alamat'],
							),
							array(
								'label'=>'Kota/Kab',
								'name'=>'kota',
								'label-width'=>'210px;',
								'value'=>$daqry['kota'],
							),
						), "style='margin-left:20px;'"
					).
					$this->isiform(
						array(
							array(
								'label'=>'<b>TITIMANGSA SURAT</b>',
								'name'=>'titimangsa_surat',
								'label-width'=>'230px;',
								'value'=>$daqry['titimangsa_surat'],
							),
							array(
								'label'=>'<b>NAMA APLIKASI</b>',
								'name'=>'nama_aplikasi',
								'label-width'=>'230px;',
								'value'=>$daqry['nama_aplikasi'],
							),
							/*array(
								'label'=>'<b>VERSI SKPD</b>',
								'name'=>'ver_skpd',
								'label-width'=>'230px;',
								'value'=>$VerSKPD,
							),
							array(
								'label'=>'<b>VERSI KODE BARANG</b>',
								'name'=>'ver_kodebarang',
								'label-width'=>'230px;',
								'value'=>$VerKodeBarang,
							),*/
							array(
								'label'=>'<b>SETELAN OTOMATIS BIAYA ATRIBUSI</b>',
								'name'=>'harga_atribusi',
								'label-width'=>'230px;',
								'value'=>$harga_atribusi,
							),
						)
					).
					"<table>
						<tr>
							<td>".$this->buttonnya($this->Prefix.'.UbahData()','edit_f2.png','UBAH','UBAH','UBAH')."</td>
							
						</tr>".
					"</table>"
				),			
				'','').
				"</div>"
				;
			
			
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function UbahData(){
		global $Ref, $Main;
		
		$arr_ver = array(
			//array('selectAll','Semua'),	
			array('1','PERMENDAGRI NO.17 TAHUN 2007'),	
			array('2','PERMENDAGRI NO.19 TAHUN 2016'),		
			);
			
		$arr_def = array(
			//array('selectAll','Semua'),	
			array('1','YA'),	
			array('0','TIDAK'),		
			);
			
		
		$daqry = $this->DataOption();
		
		//
		$harga_atribusi = 'TIDAK';
		if($daqry['harga_atribusi'] == 1)$harga_atribusi = 'YA';
			
		$cek='';$err='';
		$content = 
			genFilterBar(
				array(
					$this->isiform(
						array(
							array(
								'label'=>'<b>KEPADA YTH</b>',
								'pemisah'=>'',
							),
						)
					).						
					$this->isiform(
						array(
							array(
								'label'=>'Nama Bidang/bagian',
								'name'=>'nama_bidang',
								'label-width'=>'210px;',
								'type'=>'text',
								'value'=>$daqry['nama_bidang'],
								'parrams'=>"style='width:300px;'",
							),
							array(
								'label'=>'Nama SKPD',
								'name'=>'nama_skpd',
								'label-width'=>'210px;',
								'type'=>'text',
								'value'=>$daqry['nama_skpd'],
								'parrams'=>"style='width:300px;'",
							),
							array(
								'label'=>'Alamat',
								'name'=>'alamat',
								'label-width'=>'210px;',
								'value'=>"<textarea name='alamat' style='width:300px;height:50px;'>".$daqry['alamat']."</textarea>",
							),
							array(
								'label'=>'Kota/Kab',
								'name'=>'kota',
								'label-width'=>'210px;',
								'type'=>'text',
								'value'=>$daqry['kota'],
								'parrams'=>"style='width:300px;'",
							),
						), "style='margin-left:20px;'"
					).
					$this->isiform(
						array(
							array(
								'label'=>'<b>TITIMANGSA SURAT</b>',
								'name'=>'titimangsa_surat',
								'label-width'=>'230px;',
								'value'=>$daqry['titimangsa_surat'],
								'type'=>'text',
								'parrams'=>"style='width:300px;'",
							),
							array(
								'label'=>'<b>NAMA APLIKASI</b>',
								'name'=>'nama_aplikasi',
								'label-width'=>'230px;',
								'value'=>$daqry['nama_aplikasi'],
								'type'=>'text',
								'parrams'=>"style='width:300px;'",
							),
							/*array(
								'label'=>'<b>VERSI SKPD</b>',
								'name'=>'ver_skpd',
								'label-width'=>'230px;',
								'value'=>cmbArray('ver_skpd',$daqry['skpd'], $arr_ver,'--- PILIH VERSI ---',"style='width:300px;'"),
							),
							array(
								'label'=>'<b>VERSI KODE BARANG</b>',
								'name'=>'ver_kodebarang',
								'label-width'=>'230px;',
								'value'=>cmbArray('ver_kodebarang',$daqry['kode_barang'], $arr_ver,'--- PILIH VERSI ---',"style='width:300px;'"),
							),*/
							array(
								'label'=>'<b>SETELAN OTOMATIS BIAYA ATRIBUSI</b>',
								'name'=>'harga_atribusi',
								'label-width'=>'230px;',
								'value'=>cmbArray('def_atrib',$daqry['harga_atribusi'], $arr_def,'--- PILIH ---',"style='width:300px;'"),
							),
						)
					).
					"
					<input type='hidden' name='IDNYA' id='IDNYA' value='".$daqry['Id']."'/>
					<table>
						<tr>
							<td>".$this->buttonnya($this->Prefix.'.SimpanUbahData()','save_f2.png','SIMPAN','SIMPAN','SIMPAN')."</td>
							<td>".$this->buttonnya($this->Prefix.'.loading()','cancel_f2.png','BATAL','BATAL','BATAL')."</td>
							
						</tr>".
					"</table>"
				),			
				'','')
				;
				
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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
		
		
		if($fmPILCARIvalue !='')$arrKondisi[] = " nama like '%$fmPILCARIvalue%' ";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST2('fmORDER1');
		$fmDESC1 = cekPOST2('fmDESC1');			
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
		/**$HalDefault=cekPOST2($this->Prefix.'_hal',1);	//Cat:Settingan Lama				
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		**/
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST2($this->Prefix.'_hal',1);					
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	
	/*function setTopBar(){
	   	return '';
	}	*/
	
	function DataOption(){
		global $Main, $HTTP_COOKIE_VARS;
		$qry = "SELECT * FROM $this->TblName WHERE Id='1' ";
		$aqry = mysql_query($qry);
		
		$data = mysql_fetch_array($aqry);
		
		$skpd = 1;
		$kdBarang = 1;
		if($Main->URUSAN == 1)$skpd = 2;
		if($Main->KD_BARANG_P108 == 1)$kdBarang = 2;
		$data['skpd'] = $skpd;
		$data['kode_barang'] = $kdBarang;
		
		return $data;
	}
	
	function VPenerima_det(){
		$Data = $this->DataOption();
		/*if($Data['kode_barang'] == 1){
			$tbl = 'v_penerimaan_barang_det';
		}else{*/
			$tbl = 'v1_penerimaan_barang_det';
		//}
		
		return $tbl;
	}	
		
	function isiform($value, $parram=''){
		$isinya = '';
		$tbl ='<table width="100%" '.$parram.'>';
		for($i=0;$i<count($value);$i++){
			if(!isset($value[$i]["kosong"])){
				if(!isset($value[$i]['align']))$value[$i]['align'] = "left";
				if(!isset($value[$i]['valign']))$value[$i]['valign'] = "top";
				
				if(isset($value[$i]['type'])){
					switch ($value[$i]['type']){
						case "text" :
							$isinya = "<input type='text' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
						break;
						case "hidden" :
							$isinya = "<input type='hidden' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
						break;
						case "password" :
							$isinya = "<input type='password' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
						break;
						default:
							$isinya = $value[$i]['value'];
						break;					
					}
				}else{
					$isinya = $value[$i]['value'];
				}
				
				$pemisah = ':';
				if(isset($value[$i]['pemisah']))$pemisah = $value[$i]['pemisah'];
				$labelwidth = isset($value[$i]['label-width'])? "width='".$value[$i]['label-width']."'":"";
				
				$tbl .= "
					<tr>
						<td $labelwidth valign='top'>".$value[$i]['label']."</td>
						<td width='10px' valign='top'>$pemisah<br></td>
						<td align='".$value[$i]['align']."' valign='".$value[$i]['valign']."'> $isinya</td>
					</tr>
				";	
			}
				
		}
		$tbl .= '</table>';
		
		return $tbl;
	}
	
	function buttonnya($js,$img,$name,$alt,$judul){
		return "<table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
					<tbody><tr valign='middle' align='center'> 
					<td class='border:none'> 
						<a class='toolbar' id='btsave' 
							href='javascript:$js'> 
						<img src='images/administrator/images/$img' alt='$alt' name='$name' width='32' height='32' border='0' align='middle' title='$judul'> $judul</a> 
					</td> 
					</tr> 
					</tbody></table> ";
	}
	
	function pageShow(){
		global $app, $Main; 
		
		$navatas_ = $this->setNavAtas();
		$navatas = $navatas_==''? // '0': '20';
			'':
			"<tr><td height='20'>".
					$navatas_.
			"</td></tr>";
			
		$form1 = $this->withform? "<form name='$this->FormName' id='$this->FormName' method='post' action=''>" : '';
		$form2 = $this->withform? "</form >": '';
		
		if(!isset($_REQUEST['halman']))$_REQUEST['halman']='1';
		return
		
		//"<html xmlns='http://www.w3.org/1999/xhtml'>".			
		"<html>".
			$this->genHTMLHead().
			"<body >".
			/*"<div id='pageheader'>".$this->setPage_Header()."</div>".
			"<div id='pagecontent'>".$this->setPage_Content()."</div>".
			$Main->CopyRight.*/
							
			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0' width='100%' height='100%' >".
				//header page -------------------		
				"<tr height='34'><td>".					
					//$this->setPage_Header($IconPage, $TitlePage).
					$this->setPage_Header().
					"<div id='header' ></div>".
				"</td></tr>".	
				$navatas.			
				//$this->setPage_HeaderOther().
				//Content ------------------------			
				//style='padding:0 8 0 8'
				"<tr height='*' valign='top'> <td >".
					
					$this->setPage_HeaderOther().
					"<div align='center' class='centermain' >".
					"<div class='main' >".
					$form1.
//
					
						//Form ------------------
						//$hidden.					
						//genSubTitle($TitleDaftar,$SubTitle_menu).						
						$this->setPage_Content().
						//$OtherInForm.
						
					$form2.//"</form>".
					"</div></div>".
				"</td></tr>".
				//$OtherContentPage.				
				//Footer ------------------------
				"<tr><td height='29' >".	
					//$app->genPageFoot(FALSE).
					$Main->CopyRight.							
				"</td></tr>".
				$OtherFooterPage.
			"</table>
			
			".
			/*'<script src="assets2/js/bootstrap.min.js"></script>'.
			'<script src="assets2/jquery.min.js"></script>'.*/
			"</body>
		</html>"; 
	}
	
	function setPage_Header(){		
		//return createHeaderPage($this->PageIcon, $this->PageTitle);
		return $this->createHeaderPage($this->PageIcon, $this->PageTitle,  
			'', FALSE, 'pageheader', $this->ico_width, $this->ico_height
		);
	}
	
	function createHeaderPage($headerIco, $headerTitle,  $otherMenu='', $headerFixed= FALSE, 
	$headerClass='pageheader', 
	$ico_width=20, $ico_height=30, $tmpl_setting=TRUE)
{
	global $Main;
	//$headerIco = 'images/icon/daftar32.png'; $headerTitle = 'Pendaftaran & Pendataan';
	$headerMenu = $Main->MenuHeader;
	$TampilPosFix = $headerFixed==TRUE? "position:fixed;top:0;":'';	
	/*return 
		"<table id='head' cellspacing='0' cellpadding='0' border='0' class='$headerClass' style='$TampilPosFix'>
			<tr class=''>
			<td width='36'><img src='$headerIco' ></td>
			<td>$headerTitle</td>
			<td>$otherMenu $headerMenu</td>			
		</tr>	
	</table>
	";
	*/
	
	$Data = "
		<div style='margin:0 4 0 4;width:24;height:24;float:right;position:relative'>
			<a style='background: no-repeat url(images/administrator/images/Setting2_24.png);	
						width:24;height:24;display: inline-block;position:absolute' href='pages.php?Pg=DataPengaturan' title='Pengaturan Penerimaan' > 											
			</a>
		</div>
	";
	
	if($tmpl_setting == FALSE)$Data="";
	
	return 
	"<table width='100%' class='menubar' cellpadding='0' cellspacing='0' border='0'>
		<tbody><tr>
		<td background='images/bg.gif'>
		
			<div id='pagetitle'>					
					<table width='100%'> <tbody><tr>
					<td width='30'>						
						<img src='$headerIco' height='$ico_height' width='$ico_width'>
					</td>
					<td>$headerTitle</td>
					<td align='right'>
						<!--menubar_kanatas-->
						<table><tbody><tr><td>
						
						
						<div style='margin:0 4 0 4;width:24;height:24;float:right;position:relative'>
						<a style='background: no-repeat url(images/administrator/images/home_24.png);	
									width:24;height:24;display: inline-block;position:absolute' href='index.php?Pg=' title='Main Menu'> 											
						</a>
						</div>
												
						<div style='margin:0 4 0 4;width:24;height:24;float:right;position:relative'>
						<a style='background: no-repeat url(images/administrator/images/logout_24.png);	
									width:24;height:24;display: inline-block;position:absolute' href='index.php?Pg=LogOut' title='Logout'> 											
						</a>
						</div>
						
						<div style='margin:0 4 0 4;width:24;height:24;float:right;position:relative'>
						<a style='background: no-repeat url(images/administrator/images/search_24.png);	
									width:24;height:24;display: inline-block;position:absolute' target='_blank' href='viewer.php' title='Pencarian Data'> 				
							
						</a>
						</div>
						
						<div style='margin:0 4 0 4;width:24;height:24;float:right;position:relative'>
						<a style='background: no-repeat url(images/administrator/images/help_f2_24.png);	
									width:24;height:24;display: inline-block;position:absolute' href='pages.php?Pg=userprofil' title='User Profile'> 											
						</a>
						</div>
						
						<div style='margin:0 4 0 4;width:24;height:24;float:right;position:relative'>
						<a id='chat_alert' style='background-image: url(images/administrator/images/message_24_off.png); background-attachment: scroll; background-color: transparent; width: 24px; height: 24px; 
							display: inline-block; position: absolute; background-position: 0px 0px; background-repeat: no-repeat no-repeat; ' 
							target='_blank' href='index.php?Pg=Menu&amp;SPg=01' title='Chat'></a>
	</div>
	
						</div>
						
						$Data
									
						</td></tr></tbody></table>
						
					</td>
					</tr>
					</tbody></table>
										
					
					
			</div>
					
					
					
		</td></tr>
		</tbody></table>";
	}
	
	function QyrTmpl1Brs($tablenya, $field='*',$where = '',$eksekusi=1) {
		$qry = "SELECT $field FROM $tablenya $where";
		$hasil =array();
		if($eksekusi == 1){
			$aqry = mysql_query($qry);
			$hasil = mysql_fetch_assoc($aqry);
		}
		
				
		return array('hasil'=>$hasil, 'cek'=>$qry);
	}
	
	function QryHitungData($tablenya, $where = '', $field=" * "){
		$qry = "SELECT $field FROM $tablenya $where";
		$aqry = mysql_query($qry);
		$hasil = mysql_num_rows($aqry);
				
		return array('hasil'=>$hasil, 'cek'=>$qry);
	}
	
	function QryHitungData2($tablenya,$where = array(), $field=' * ') {
		$wherenya = '';

		for($i=0;$i<count($where);$i++){
			if($i != 0){
				$wherenya .= ' AND ';
			}
			$pembanding = isset($where[$i][2])?$where[$i][2]:"=";
			$wherenya .= $where[$i][0]." $pembanding '".$where[$i][1]."'";
		}

		if($wherenya != '')$wherenya = "WHERE ".$wherenya;

		$qry = "SELECT $field FROM $tablenya $wherenya $order";
		$aqry = mysql_query($qry);
		$hasil = mysql_num_rows($aqry);
				
		return array('hasil'=>$hasil, 'cek'=>$qry);
	}
	
	function QryInsData($tbl, $values){
		$cek='';
		$field = '';
		$isifield = '';
		$errmsg = '';
		for($i=0;$i<count($values);$i++){
			if($i != 0){
				$field .= ',';
				$isifield .= ', ';
			}
			$field .= $values[$i][0];
			$isifield .= "'".$values[$i][1]."'";	
		}		
		
		$qry = "INSERT INTO $tbl ($field) values ($isifield)";$cek.=$qry;
		$aqry = mysql_query($qry);
		
		if(!$aqry)$errmsg = mysql_error();
		
		return array('hasil'=>$aqry, 'cek'=>$qry, 'errmsg'=>$errmsg);
	}
	
	function QryUpdData($tbl, $values, $where){
		$cek='';
		$isifield = '';
		for($i=0;$i<count($values);$i++){
			if($i != 0){
				$isifield .= ',';
			}
			$pembanding = isset($values[$i][2])?$values[$i][2]:"=";
			$isifield .= !isset($values[$i][3])?$values[$i][0]."$pembanding'".$values[$i][1]."'":$values[$i][0];	
		}
		
		$qry = "UPDATE $tbl SET $isifield $where ";$cek.=$qry;
		$aqry = mysql_query($qry);
		
		if(!$aqry)$errmsg = mysql_error();
		
		return array('hasil'=>$aqry, 'cek'=>$qry, 'errmsg'=>$errmsg);
	}
	
	function QryUpdData2($tbl, $values,$where = array(), $order=''){
		$cek='';
		$isifield = '';
		for($i=0;$i<count($values);$i++){
			if($i != 0){
				$isifield .= ',';
			}
			$isifield .= $values[$i][0]."='".$values[$i][1]."'";	
		}
		
		for($x=0;$x<count($where);$x++){
			if($x != 0){
				$wherenya .= ' AND ';
			}
			$pembanding = isset($where[$x][2])?$where[$x][2]:"=";
			$value_where = $where[$x][1] != " "?"'".$where[$x][1]."'":"";
			$wherenya .= $where[$x][0]." $pembanding ".$value_where;
		}

		if($wherenya != '')$wherenya = "WHERE ".$wherenya;
		
		$qry = "UPDATE $tbl SET $isifield $wherenya $order";$cek.=$qry;
		$aqry = mysql_query($qry);
		
		if(!$aqry)$errmsg = mysql_error();
		
		return array('hasil'=>$aqry, 'cek'=>$qry, 'errmsg'=>$errmsg);
	}
	
	function HargaPerolehanAtribusi($idTerima,$idTerima_det, $jns_trans='1'){
		$where_brgDSTR = " AND barangdistribusi='1' ";
	 	if($jns_trans == "2")$where_brgDSTR='';
		
		$qry_cek_pendet = $this->QyrTmpl1Brs("t_penerimaan_barang_det", "harga_total", "WHERE Id='$idTerima_det' AND refid_terima='$idTerima' $where_brgDSTR " );
		$aqry_cek_pendet = $qry_cek_pendet['hasil'];
		
		$qry_cek_distri = $this->QyrTmpl1Brs("t_distribusi", "SUM(jumlah) as jumlah", "WHERE refid_penerimaan_det='$idTerima_det' AND refid_terima='$idTerima' AND status='1' ");
		$aqry_cek_distri = $qry_cek_distri['hasil'];	 
	 	
	  	//Harga Perolehan Barang
	 	$tot_pmlhrn = $this->QyrTmpl1Brs("t_penerimaan_barang_det", "IFNULL(SUM(harga_total),0) as harga_total", "WHERE refid_terima='".$idTerima."' AND sttemp='0' $where_brgDSTR");
	 	$qry_pmlhrn = $tot_pmlhrn['hasil'];//$hsl = $tot_pmlhrn['cek'];
	 
	 	$tot_attribusi = $this->QyrTmpl1Brs("t_atribusi_rincian", "IFNULL(SUM(jumlah),0) as tot_atr", "WHERE refid_terima='".$idTerima."' AND sttemp='0' ");
		 $qry_tot_attr = $tot_attribusi['hasil'];$hsl = $tot_attribusi['cek'];
	 
	 //Hitung Harga Perolehan ------------------------------------------------------------------------------------------- 
	 //$hrg_perolehan = (($dt['harga_total']/$qry_pmlhrn['harga_total'])*$qry_tot_attr['tot_atr'])+$dt['harga_total'];
	 	$hrg1brg = round(floatval($aqry_cek_pendet['harga_total']));
	 	$hrg_tot_bar = round(floatval($qry_pmlhrn['harga_total']));
	 
	 	$hrg = @($hrg1brg/$hrg_tot_bar);
	 	$hrg_perolehan = round(($hrg*$qry_tot_attr['tot_atr'])+$aqry_cek_pendet['harga_total']);
		
		return $hrg_perolehan;
	}
	
	function CekBiayaAtribusi($Idplh){	
		$err = '';	
		$qry_Penerimaan = $this->QyrTmpl1Brs("t_penerimaan_barang", "*", " WHERE Id='$Idplh'" );
		$daqry_Penerimaan = $qry_Penerimaan['hasil'];
						
		if($daqry_Penerimaan['biayaatribusi'] == '1'){			
			$aqry_attribusi = $this->QryHitungData("t_atribusi", "WHERE refid_terima='$Idplh' AND sttemp='0'");
			
			if($aqry_attribusi['hasil'] < 1)$err = "Biaya Atribusi Belum Di Masukan !";
		}
		
		return $err;
		
		
	}
	
	function AmbilUraianBarang($IdBI){
		
		$qry = "SELECT * FROM buku_induk WHERE id='$IdBI'";
		$daqry = mysql_query($qry);
		$dt=mysql_fetch_array($daqry);
		
		$wherenya = "WHERE idbi='$IdBI' ";
		$content = $qry;
		
		$ada_alm = '';
		$ada_alm .= ($dt['rt'] && $dt['rw']) == ''? '' : '<br>RT/RW. '.$dt['rt'].'/'.$dt['rw'];		
		$ada_alm .= $dt['kampung'] == ''? '' : '<br>Kp/Komp. '.$dt['kampung'];	
		
		switch($dt['f']){
			case "01":
				$data_kib = "SELECT * FROM view_kib_a $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));
				
				$alm = '';
				$alm .= ifempty($qry_data_kib['alamat'],'-');
				$alm .= $ada_alm; 	
				$alm .= $qry_data_kib['alamat_kel'] != ''? '<br>Kel/Desa. '.$qry_data_kib['alamat_kel'] : '';
				$alm .= $qry_data_kib['alamat_kec'] != ''? '<br>Kec. '.$qry_data_kib['alamat_kec'] : '';
				$alm .= $qry_data_kib['alamat_kota'] != ''? '<br>'.$qry_data_kib['alamat_kota'] : '';
					
			break;
			case "02":
				$data_kib = "SELECT * FROM view_kib_b $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));
				
				$qry_data_kib = array_map('utf8_encode', $qry_data_kib);
				$alm = $qry_data_kib['merk'];
				$alm .= $alm == ''?$qry_data_kib['ket'] : '';
							
			break;
			case "03":
				$data_kib = "SELECT * FROM view_kib_c $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));
				
				$alm = '';
				$alm .= ifempty($qry_data_kib['alamat'],'-');		
				$alm .= $ada_alm; 
				$alm .= $qry_data_kib['alamat_kel'] != ''? '<br>Kel/Desa. '.$qry_data_kib['alamat_kel'] : '';
				$alm .= $qry_data_kib['alamat_kec'] != ''? '<br>Kec. '.$qry_data_kib['alamat_kec'] : '';
				$alm .= $qry_data_kib['alamat_kota'] != ''? '<br>'.$qry_data_kib['alamat_kota'] : '';
				
			break;
			case "04":
				$data_kib = "SELECT * FROM view_kib_d $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));
				
				$alm = '';
				$alm .= ifempty($qry_data_kib['alamat'],'-');
				$alm .= $ada_alm; 		
				$alm .= $qry_data_kib['alamat_kel'] != ''? '<br>Kel/Desa. '.$qry_data_kib['alamat_kel'] : '';
				$alm .= $qry_data_kib['alamat_kec'] != ''? '<br>Kec. '.$qry_data_kib['alamat_kec'] : '';
				$alm .= $qry_data_kib['alamat_kota'] != ''? '<br>'.$qry_data_kib['alamat_kota'] : '';
			break;
			case "05":
				$data_kib = "SELECT * FROM view_kib_e $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));
				
				$alm = $qry_data_kib['ket'] != ''? $qry_data_kib['ket'] : '-';
				
				
			break;
			case "06":
				$data_kib = "SELECT * FROM view_kib_f $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));
				
				$alm = '';
				$alm .= ifempty($qry_data_kib['alamat'],'-');
				$alm .= $ada_alm; 		
				$alm .= $qry_data_kib['alamat_kel'] != ''? '<br>Kel/Desa. '.$qry_data_kib['alamat_kel'] : '';
				$alm .= $qry_data_kib['alamat_kec'] != ''? '<br>Kec. '.$qry_data_kib['alamat_kec'] : '';
				$alm .= $qry_data_kib['alamat_kota'] != ''? '<br>'.$qry_data_kib['alamat_kota'] : '';
				
			break;
			case "07":
				$data_kib = "SELECT * FROM view_kib_g $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));
				
				$alm = $qry_data_kib['ket'] != ''? $qry_data_kib['ket'] : '-';
			break;
		}
		
		
		return $alm;	
		
	}
	
	function TampilanTable($label, $val, $width='100px'){
		return 
			"<table>
				<tr>
					<td style='width:$width'>$label</td>
					<td> : </td>
					<td>$val</td>
				</tr>
			</table>";		
	}
	
	function QyrTmpl1Brs2($tablenya, $field='*',$where = array(), $order='') {
		$wherenya = '';

		for($i=0;$i<count($where);$i++){
			if($i != 0){
				$wherenya .= ' AND ';
			}
			$pembanding = isset($where[$i][2])?$where[$i][2]:"=";
			$isinya = isset($where[$i][1])?" $pembanding '".$where[$i][1]."'":"";
			$wherenya .= $where[$i][0].$isinya;
		}

		if($wherenya != '')$wherenya = "WHERE ".$wherenya;

		$qry = "SELECT $field FROM $tablenya $wherenya $order";
		$aqry = mysql_query($qry);
		$hasil = mysql_fetch_assoc($aqry);
				
		return array('hasil'=>$hasil, 'cek'=>$qry);
	}
	
	function QryDelData($tablenya,$where,$order='') {

		$qry = "DELETE FROM $tablenya $where $order";
		$aqry = mysql_query($qry);
				
		return array('hasil'=>$hasil, 'cek'=>$qry);
	}
	
	function QryDelData2($tablenya,$where = array(), $order='') {
		$wherenya = '';

		for($i=0;$i<count($where);$i++){
			if($i != 0){
				$wherenya .= ' AND ';
			}
			$pemisah = isset($where[$i][2])?$where[$i][2]:"=";
			$value = $where[$i][1] != " "?"'".$where[$i][1]."'":"";
			$wherenya .= $where[$i][0]." $pemisah ".$value;
		}

		if($wherenya != '')$wherenya = "WHERE ".$wherenya;

		$qry = "DELETE FROM $tablenya $wherenya $order";
		$aqry = mysql_query($qry);
				
		return array('hasil'=>$hasil, 'cek'=>$qry);
	}
	
	function KodeProgram($bk, $ck, $dk, $p){
		//if(strlen($bk) < 2)$bk='0'.$bk;
		if(strlen($ck) < 2)$ck='0'.$ck;
		if(strlen($dk) < 2)$dk='0'.$dk;
		if(strlen($p) < 2)$p='0'.$p;
		
		return $bk.".".$ck.".".$dk.".".$p;
	}
	
	function KodeKegiatan($q){
		if(strlen($q) < 2)$q='0'.$q;
		return $q;
	}
	
	function KodeProgramKegiatan($bk, $ck, $dk, $p, $q){
		if(strlen($bk) < 2)$bk='0'.$bk;
		if(strlen($ck) < 2)$ck='0'.$ck;
		if(strlen($dk) < 2)$dk='0'.$dk;
		if(strlen($p) < 2)$p='0'.$p;
		if(strlen($q) < 2)$q='0'.$q;
		
		return $bk.".".$ck.".".$dk.".".$p.".".$q;
	}
	
	function InputTextbox($name,$value,$placeholder='',$style=''){
		return '<input type="text" name="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'" id="'.$name.'" '.$style.' />';
	}
	
	function InputHidden($name,$value){
		return '<input type="hidden" name="'.$name.'" value="'.$value.'" id="'.$name.'"/>';
	}
	
	function GenViewHiddenSKPD($c1, $c, $d, $e, $e1){
		$DataOption = $this->DataOption();
		if($DataOption['skpd'] != 2)$c1=0;
		return 
			"<input type='hidden' name='c1nya' value='$c1' id='c1nya' />".
			"<input type='hidden' name='cnya' value='$c' id='cnya' />".
			"<input type='hidden' name='dnya' value='$d' id='dnya' />".
			"<input type='hidden' name='enya' value='$e' id='enya' />".
			"<input type='hidden' name='e1nya' value='$e1' id='e1nya' />";
	}
	
	function GenViewSKPD($c1, $c, $d, $e, $e1, $widthCol="200px;"){
		$DataOption = $this->DataOption();
		if($DataOption['skpd'] != 1){
			$qryC1 = $this->QyrTmpl1Brs("ref_skpd", "*", " WHERE c1='$c1' AND c='00' AND d='00' AND e='00' AND e1='000'");
			$data4 = $qryC1['hasil'];
			$dataC1 = $this->isiform(
						array(
							array(
									'label'=>'URUSAN',
									'name'=>'urusan',
									'label-width'=>$widthCol,
									'type'=>'text',
									'value'=>$data4['c1'].'. '.$data4['nm_skpd'],
									'align'=>'left',
									'parrams'=>"style='width:400px;' readonly",
								),
						)
					);
			
			$WHEREC1 = "c1='$c1' AND";
		}else{
			$dataC1 = '';
			$WHEREC1 = '';
		}
		
		$qry = $this->QyrTmpl1Brs("ref_skpd", "*", "WHERE $WHEREC1 c='$c' AND d='00' AND e='00' AND e1='000'");
		$data = $qry['hasil'];
		
		$qry1 = $this->QyrTmpl1Brs("ref_skpd", "*", "WHERE $WHEREC1 c='$c' AND d='$d' AND e='00' AND e1='000'");
		$data1 = $qry1['hasil'];
		
		$qry2 = $this->QyrTmpl1Brs("ref_skpd", "*", "WHERE $WHEREC1 c='$c' AND d='$d' AND e='$e' AND e1='000'");
		$data2 = $qry2['hasil'];

		$qry3 = $this->QyrTmpl1Brs("ref_skpd", "*", "WHERE $WHEREC1 c='$c' AND d='$d' AND e='$e' AND e1='$e1'");
		$data3 = $qry3['hasil'];
		
		$hasil = genFilterBar(
				array(
					$dataC1.
					$this->isiform(
						array(
							array(
								'label'=>'BIDANG',
								'name'=>'bidang',
								'label-width'=>$widthCol,
								'type'=>'text',
								'value'=>$c.'. '.$data['nm_skpd'],
								'align'=>'left',
								'parrams'=>"style='width:400px;' readonly",
							),
							array(
								'label'=>'SKPD',
								'name'=>'skpd',
								'label-width'=>$widthCol,
								'type'=>'text',
								'value'=>$d.'. '.$data1['nm_skpd'],
								'align'=>'left',
								'parrams'=>"style='width:400px;' readonly",
							),
							array(
								'label'=>'UNIT',
								'name'=>'unit',
								'label-width'=>$widthCol,
								'type'=>'text',
								'value'=>$e.'. '.$data2['nm_skpd'],
								'align'=>'left',
								'parrams'=>"style='width:400px;' readonly",
							),
							array(
								'label'=>'SUB UNIT',
								'name'=>'subunit',
								'label-width'=>$widthCol,
								'type'=>'text',
								'value'=>$e1.'. '.$data3['nm_skpd'],
								'parrams'=>"style='width:400px;' readonly",
							),
						)
					)
				
				),'','','');
		return $hasil;
	}
	
	function GenViewSKPD2($c1, $c, $d, $e, $e1, $width_cols=100,$width_isi=380){
		$DataOption = $this->DataOption();
		$WHERE_SKPD = "WHERE ";	
		if($DataOption['skpd'] != '1'){
			$WHERE_SKPD = $WHERE_SKPD." c1='$c1' AND ";
			$qry4 = "SELECT concat(c1,'. ', nm_skpd) as nama FROM ref_skpd $WHERE_SKPD c='00' AND d='00' AND e='00' AND e1='000'";
			$aqry4 = mysql_query($qry4);
			$data4 = mysql_fetch_array($aqry4);
			$URUSAN = array( 
							'label'=>'URUSAN',
							'labelWidth'=>$width_cols, 
							'value'=>$data4['nama'], 
							'type'=>'text',
							'param'=>"style='width:".$width_isi."px;' readonly"
							 );
		}else{
			$URUSAN = array("lewat" => "d",
							'type'=>'merge',);
		}
		
		$qry = $this->QyrTmpl1Brs("ref_skpd", "concat(c,'. ', nm_skpd) as nama", "WHERE $WHEREC1 c='$c' AND d='00' AND e='00' AND e1='000'");
		$data = $qry['hasil'];
		
		$qry1 = $this->QyrTmpl1Brs("ref_skpd", "concat(d,'. ', nm_skpd) as nama", "WHERE $WHEREC1 c='$c' AND d='$d' AND e='00' AND e1='000'");
		$data1 = $qry1['hasil'];
		
		$qry2 = $this->QyrTmpl1Brs("ref_skpd", "concat(e,'. ', nm_skpd) as nama", "WHERE $WHEREC1 c='$c' AND d='$d' AND e='$e' AND e1='000'");
		$data2 = $qry2['hasil'];

		$qry3 = $this->QyrTmpl1Brs("ref_skpd", "concat(e1,'. ', nm_skpd) as nama", "WHERE $WHEREC1 c='$c' AND d='$d' AND e='$e' AND e1='$e1'");
		$data3 = $qry3['hasil'];
		
		$hasil = array(
			$URUSAN,
			'BIDANG' => array( 
						'label'=>'BIDANG',
						'labelWidth'=>$width_cols, 
						'value'=>$data['nama'], 
						'type'=>'text',
						'param'=>"style='width:".$width_isi."px;' readonly"
						 ),
			'SKPD' => array( 
						'label'=>'SKPD',
						'labelWidth'=>$width_cols, 
						'value'=>$data1['nama'], 
						'type'=>'text',
						'param'=>"style='width:".$width_isi."px;' readonly"
						 ),
			'UNIT' => array( 
						'label'=>'UNIT',
						'labelWidth'=>$width_cols, 
						'value'=>$data2['nama'], 
						'type'=>'text',
						'param'=>"style='width:".$width_isi."px;' readonly"
						 ),
			'SUBUNIT' => array( 
						'label'=>'SUB UNIT',
						'labelWidth'=>$width_cols, 
						'value'=>$data3['nama'], 
						'type'=>'text',
						'param'=>"style='width:".$width_isi."px;' readonly"
						 ),
			);
			
		return $hasil;
	}
	
	function GenViewSKPD3($dt){
		//SKPD ------------------------------------------------------------------------------------------------
		$data_urusan = array("lewat" => "d",
							'type'=>'merge',);
		$WHERE_SKPD = "WHERE ";
		$DataOption = $this->DataOption();
		if($DataOption["skpd"] != '1'){
			$WHERE_SKPD.="c1='".$dt["c1"]."' AND ";
			$qry_c1 = $this->QyrTmpl1Brs("ref_skpd", "concat(c1,'. ', nm_skpd) as nama", $WHERE_SKPD." c='00' AND d='00' AND e='00' AND e1='000' ");
			$aqry_c1 = $qry_c1["hasil"];
			$data_urusan = array( 
							'label'=>'URUSAN',
							'labelWidth'=>100, 
							'value'=>$aqry_c1['nama'], 
						);
		}
		
		$WHERE_SKPD.="c='".$dt["c"]."' AND ";
		$qry_c = $this->QyrTmpl1Brs("ref_skpd", "concat(c,'. ', nm_skpd) as nama", $WHERE_SKPD." d='00' AND e='00' AND e1='000' ");
		$aqry_c = $qry_c["hasil"];
		
		$WHERE_SKPD.="d='".$dt["d"]."' AND ";
		$qry_d = $this->QyrTmpl1Brs("ref_skpd", "concat(c,'. ', nm_skpd) as nama", $WHERE_SKPD." e='00' AND e1='000' ");
		$aqry_d = $qry_d["hasil"];
		
		$WHERE_SKPD.="e='".$dt["e"]."' AND ";
		$qry_e = $this->QyrTmpl1Brs("ref_skpd", "concat(c,'. ', nm_skpd) as nama", $WHERE_SKPD." e1='000' ");
		$aqry_e = $qry_e["hasil"];
		
		$WHERE_SKPD.="e1='".$dt["e1"]."' ";
		$qry_e1 = $this->QyrTmpl1Brs("ref_skpd", "concat(c,'. ', nm_skpd) as nama", $WHERE_SKPD);
		$aqry_e1 = $qry_e1["hasil"];
		
		//END SKPD -------------------------------------------------------------------------------------------
		$data_arr = array(
			'URUSAN'=>$data_urusan,
			'BIDANG'=> array( 
							'label'=>'BIDANG',
							'labelWidth'=>200, 
							'value'=>$aqry_c['nama'], 
						),
			'SKPD'=> array( 
							'label'=>'SKPD',
							'labelWidth'=>200, 
							'value'=>$aqry_d['nama'], 
						),
			'UNIT'=> array( 
							'label'=>'UNIT',
							'labelWidth'=>200, 
							'value'=>$aqry_e['nama'], 
						),
			'SUBUNIT'=> array( 
							'label'=>'SUB UNIT',
							'labelWidth'=>200, 
							'value'=>$aqry_e1['nama'], 
						),
			);
			
		return $data_arr;
	}
	
	function GenViewSKPD4($c1, $c, $d, $e, $widthCol="200px;"){
		$DataOption = $this->DataOption();
		if($DataOption['skpd'] != 1){
			$qryC1 = $this->QyrTmpl1Brs("ref_skpd", "*", " WHERE c1='$c1' AND c='00' AND d='00' AND e='00' AND e1='000'");
			$data4 = $qryC1['hasil'];
			$dataC1 = $this->isiform(
						array(
							array(
									'label'=>'URUSAN',
									'name'=>'urusan',
									'label-width'=>$widthCol,
									'type'=>'text',
									'value'=>$data4['c1'].'. '.$data4['nm_skpd'],
									'align'=>'left',
									'parrams'=>"style='width:400px;' readonly",
								),
						)
					);
			
			$WHEREC1 = "c1='$c1' AND";
		}else{
			$dataC1 = '';
			$WHEREC1 = '';
		}
		
		$qry = $this->QyrTmpl1Brs("ref_skpd", "*", "WHERE $WHEREC1 c='$c' AND d='00' AND e='00' AND e1='000'");
		$data = $qry['hasil'];
		
		$qry1 = $this->QyrTmpl1Brs("ref_skpd", "*", "WHERE $WHEREC1 c='$c' AND d='$d' AND e='00' AND e1='000'");
		$data1 = $qry1['hasil'];
		
		$qry2 = $this->QyrTmpl1Brs("ref_skpd", "*", "WHERE $WHEREC1 c='$c' AND d='$d' AND e='$e' AND e1='000'");
		$data2 = $qry2['hasil'];
		
		$hasil = $dataC1.
					$this->isiform(
						array(
							array(
								'label'=>'BIDANG',
								'name'=>'bidang',
								'label-width'=>$widthCol,
								'type'=>'text',
								'value'=>$c.'. '.$data['nm_skpd'],
								'align'=>'left',
								'parrams'=>"style='width:400px;' readonly",
							),
							array(
								'label'=>'SKPD',
								'name'=>'skpd',
								'label-width'=>$widthCol,
								'type'=>'text',
								'value'=>$d.'. '.$data1['nm_skpd'],
								'align'=>'left',
								'parrams'=>"style='width:400px;' readonly",
							),
							array(
								'label'=>'UNIT',
								'name'=>'unit',
								'label-width'=>$widthCol,
								'type'=>'text',
								'value'=>$e.'. '.$data2['nm_skpd'],
								'align'=>'left',
								'parrams'=>"style='width:400px;' readonly",
							),
						)
					);
		return $hasil;
	}
	
	function GenViewSKPD5($c1, $c, $d, $widthCol="200px;"){
		$DataOption = $this->DataOption();
		if($DataOption['skpd'] != 1){
			$qryC1 = $this->QyrTmpl1Brs("ref_skpd", "*", " WHERE c1='$c1' AND c='00' AND d='00' AND e='00' AND e1='000'");
			$data4 = $qryC1['hasil'];
			$dataC1 = $this->isiform(
						array(
							array(
									'label'=>'URUSAN',
									'name'=>'urusan',
									'label-width'=>$widthCol,
									'type'=>'text',
									'value'=>$data4['c1'].'. '.$data4['nm_skpd'],
									'align'=>'left',
									'parrams'=>"style='width:400px;' readonly",
								),
						)
					);
			
			$WHEREC1 = "c1='$c1' AND";
		}else{
			$dataC1 = '';
			$WHEREC1 = '';
		}
		
		$qry = $this->QyrTmpl1Brs("ref_skpd", "*", "WHERE $WHEREC1 c='$c' AND d='00' AND e='00' AND e1='000'");
		$data = $qry['hasil'];
		
		$qry1 = $this->QyrTmpl1Brs("ref_skpd", "*", "WHERE $WHEREC1 c='$c' AND d='$d' AND e='00' AND e1='000'");
		$data1 = $qry1['hasil'];
		
		
		$hasil = $dataC1.
					$this->isiform(
						array(
							array(
								'label'=>'BIDANG',
								'name'=>'bidang',
								'label-width'=>$widthCol,
								'type'=>'text',
								'value'=>$c.'. '.$data['nm_skpd'],
								'align'=>'left',
								'parrams'=>"style='width:400px;' readonly",
							),
							array(
								'label'=>'SKPD',
								'name'=>'skpd',
								'label-width'=>$widthCol,
								'type'=>'text',
								'value'=>$d.'. '.$data1['nm_skpd'],
								'align'=>'left',
								'parrams'=>"style='width:400px;' readonly",
							),
						)
					);
		return $hasil;
	}
	
	function GenViewSKPD6($c1, $c, $d, $width_cols=100,$width_val=380){
		$DataOption = $this->DataOption();
		$WHERE_SKPD = "WHERE ";	
		if($DataOption['skpd'] != '1'){
			$WHERE_SKPD = $WHERE_SKPD." c1='$c1' AND ";
			$qry4 = "SELECT concat(c1,'. ', nm_skpd) as nama FROM ref_skpd $WHERE_SKPD c='00' AND d='00' AND e='00' AND e1='000'";
			$aqry4 = mysql_query($qry4);
			$data4 = mysql_fetch_array($aqry4);
			$URUSAN = array( 
							'label'=>'URUSAN',
							'labelWidth'=>$width_cols, 
							'value'=>$data4['nama'], 
							'type'=>'text',
							'param'=>"style='width:".$width_val."px;' readonly"
							 );
		}else{
			$URUSAN = array("lewat" => "d");
		}
		
		$qry = $this->QyrTmpl1Brs("ref_skpd", "concat(c,'. ', nm_skpd) as nama", "$WHERE_SKPD c='$c' AND d='00' AND e='00' AND e1='000'");
		$data = $qry['hasil'];
		
		$qry1 = $this->QyrTmpl1Brs("ref_skpd", "concat(d,'. ', nm_skpd) as nama", "$WHERE_SKPD c='$c' AND d='$d' AND e='00' AND e1='000'");
		$data1 = $qry1['hasil'];
		
		
		$hasil = array(
			$URUSAN,
			'BIDANG' => array( 
						'label'=>'BIDANG'.$qry["ce"],
						'labelWidth'=>$width_cols, 
						'value'=>$data['nama'], 
						'type'=>'text',
						'param'=>"style='width:".$width_val."px;' readonly"
						 ),
			'SKPD' => array( 
						'label'=>'SKPD',
						'labelWidth'=>$width_cols, 
						'value'=>$data1['nama'], 
						'type'=>'text',
						'param'=>"style='width:".$width_val."px;' readonly"
						 ),
			);
			
		return $hasil;
	}
	
	function GenViewSKPD7($c1, $c, $d, $width_cols=100,$width_val=380){
		$DataOption = $this->DataOption();
		$WHERE_SKPD = "WHERE ";	
		if($DataOption['skpd'] != '1'){
			$WHERE_SKPD = $WHERE_SKPD." c1='$c1' AND ";
			$qry4 = "SELECT concat(c1,'. ', nm_skpd) as nama FROM ref_skpd $WHERE_SKPD c='00' AND d='00' AND e='00' AND e1='000'";
			$aqry4 = mysql_query($qry4);
			$data4 = mysql_fetch_array($aqry4);
			$URUSAN = array( 
							'label'=>'URUSAN',
							'labelWidth'=>$width_cols, 
							'value'=>$data4['nama'], 
							 );
		}else{
			$URUSAN = array("lewat" => "d");
		}
		
		$qry = $this->QyrTmpl1Brs("ref_skpd", "concat(c,'. ', nm_skpd) as nama", "$WHERE_SKPD c='$c' AND d='00' AND e='00' AND e1='000'");
		$data = $qry['hasil'];
		
		$qry1 = $this->QyrTmpl1Brs("ref_skpd", "concat(d,'. ', nm_skpd) as nama", "$WHERE_SKPD c='$c' AND d='$d' AND e='00' AND e1='000'");
		$data1 = $qry1['hasil'];
		
		
		$hasil = array(
			$URUSAN,
			'BIDANG' => array( 
						'label'=>'BIDANG'.$qry["ce"],
						'labelWidth'=>$width_cols, 
						'value'=>$data['nama'], 
						 ),
			'SKPD' => array( 
						'label'=>'SKPD',
						'labelWidth'=>$width_cols, 
						'value'=>$data1['nama'], 
						 ),
			);
			
		return $hasil;
	}
	
	function GenViewSKPD8($c1, $c, $d, $widthCol="200px;"){
		$DataOption = $this->DataOption();
		if($DataOption['skpd'] != 1){
			$qryC1 = $this->QyrTmpl1Brs("ref_skpd", "*", " WHERE c1='$c1' AND c='00' AND d='00' AND e='00' AND e1='000'");
			$data4 = $qryC1['hasil'];
			$dataC1 = $this->isiform(
						array(
							array(
									'label'=>'URUSAN',
									'label-width'=>$widthCol,
									'value'=>$data4['c1'].'. '.$data4['nm_skpd'],
								),
						)
					);
			
			$WHEREC1 = "c1='$c1' AND";
		}else{
			$dataC1 = '';
			$WHEREC1 = '';
		}
		
		$qry = $this->QyrTmpl1Brs("ref_skpd", "*", "WHERE $WHEREC1 c='$c' AND d='00' AND e='00' AND e1='000'");
		$data = $qry['hasil'];
		
		$qry1 = $this->QyrTmpl1Brs("ref_skpd", "*", "WHERE $WHEREC1 c='$c' AND d='$d' AND e='00' AND e1='000'");
		$data1 = $qry1['hasil'];
		
		
		$hasil = $dataC1.
					$this->isiform(
						array(
							array(
								'label'=>'BIDANG',
								'label-width'=>$widthCol,
								'value'=>$c.'. '.$data['nm_skpd'],
							),
							array(
								'label'=>'SKPD',
								'label-width'=>$widthCol,
								'value'=>$d.'. '.$data1['nm_skpd'],
							),
						)
					);
		return $hasil;
	}
	
	function Gen_valRekening($dt,$pemisah='.'){
		return $dt['k'].$pemisah.$dt['l'].$pemisah.$dt['m'].$pemisah.$dt['n'].$pemisah.$dt['o'];
	}
	
	function Get_valRekening($dt){
		$data = array(
					array("k",$dt['k']),
					array("l",$dt['l']),
					array("m",$dt['m']),
					array("n",$dt['n']),
					array("o",$dt['o']),
				);
		$qry = $this->QyrTmpl1Brs2("ref_rekening","*, count(*) as cnt",$data);
		$isi = $qry["hasil"];
		
		return array("kode"=>$this->Gen_valRekening($isi),"nm_rekening"=>$isi["nm_rekening"], "jml"=>$isi["cnt"]);
	}
	
	function Get_valRekening2($k,$l,$m,$n,$o){
		$data = array(
					array("k",$k),
					array("l",$l),
					array("m",$m),
					array("n",$n),
					array("o",$o),
				);
		$qry = $this->QyrTmpl1Brs2("ref_rekening","*",$data);
		$isi = $qry["hasil"];
				
		$kd_rek = $isi["k"] == NULL || $isi["k"] == ""?"":$this->Gen_valRekening($isi);
		
		return array("kode"=>$kd_rek,"nm_rekening"=>$isi["nm_rekening"], "cek"=>$qry["cek"]);
	}
	
	function Gen_valProgram($dt){
		return $dt['bk'].".".$dt['ck'].".".$dt['dk'].".".$dt['p'];
	}
	
	function Gen_valKegiatan($dt){
		return $dt['bk'].".".$dt['ck'].".".$dt['dk'].".".$dt['p'].".".$dt['q'];
	}
	
	function GetProgKeg($bk, $ck, $dk, $p, $q=0) {
		
		$qry = $this->QyrTmpl1Brs("ref_program", "nama", "WHERE bk='$bk' AND ck='$ck' AND dk='$dk' AND p='$p' AND q='$q' ");
		$dt = $qry["hasil"];
		
		$val = $bk.".".$ck.".".$dk.".".$p.". ";
		if($q != 0)$val = $q.". ";
		
		return $val.$dt["nama"];
	}
	
	function GetProgKeg2($bk, $ck, $dk, $p, $q=0) {
		
		$qry = $this->QyrTmpl1Brs("ref_program", "nama", "WHERE bk='$bk' AND ck='$ck' AND dk='$dk' AND p='$p' AND q='$q' ");
		$dt = $qry["hasil"];
		
		$val = $this->KodeProgram($bk, $ck, $dk, $p).". ";
		if($q != 0)$val = $q.". ";
		
		return $val.$dt["nama"];
	}
	
	function GetProgKeg3($bk, $ck, $dk, $p, $q=0) {
		
		$qry = $this->QyrTmpl1Brs("ref_program", "nama", "WHERE bk='$bk' AND ck='$ck' AND dk='$dk' AND p='$p' AND q='$q' ");
		$dt = $qry["hasil"];
		
		$val = $this->KodeProgram($bk, $ck, $dk, $p).".".$this->KodeKegiatan($q);
				
		return array("kode"=>$val,"nm_prog"=>$dt["nama"]);
	}
	
	
	
	function GenViewKode_Barang($f1,$f2,$f,$g,$h,$i,$j, $functionnya='', $widthCol='100px;'){
		$DataOption = $this->DataOption();
		
		$WHERE_kdBRg = "WHERE f1='$f1' AND f2='$f2' ";
		$dataBarangF1F2 = '';
		if($DataOption['kode_barang'] == '2'){
	 		$cmbAkun = $_REQUEST['cmbAkun'];
			$cmbKelompok = $_REQUEST['cmbKelompok'];
			
			$WHERE_kdBRg = "WHERE f1='$f1' ";
			$qry_F1 = $this->QyrTmpl1Brs("ref_barang", "concat(f1,'. ', nm_barang) as nama", $WHERE_kdBRg." and f2 = '0' and f = '00' and g ='00' and h ='00' and i='00' and j = '000'");
			$dt_F1 = $qry_F1["hasil"];
			
			$WHERE_kdBRg .= "AND f2='$f2' ";
			$qry_F2 = $this->QyrTmpl1Brs("ref_barang", "concat(f2,'. ', nm_barang) as nama", $WHERE_kdBRg." and f = '00' and g ='00' and h ='00' and i='00' and j = '000'");
			$dt_F2 = $qry_F2["hasil"];
			
			$dataBarangF1F2 = 
				$this->isiform(
					array(
						array(
							'label'=>'AKUN',
							'name'=>'cmbAkun',
							'label-width'=>$widthCol,
							'type'=>'text',
							'value'=>$dt_F1['nama'],
							'align'=>'left',
							'parrams'=>"style='width:400px;' readonly",
						),
						array(
							'label'=>'KELOMPOK',
							'name'=>'cmbKelompok',
							'label-width'=>$widthCol,
							'type'=>'text',
							'value'=>$dt_F2['nama'],
							'align'=>'left',
							'parrams'=>"style='width:400px;' readonly",
						)
					)
				);
		}
		// Kode Barang f --------------------------------------------------------------------------------------
		$WHERE_kdBRg.= " AND f='$f' ";
		$qry_F = $this->QyrTmpl1Brs("ref_barang", "concat(f,'. ', nm_barang) as nama", $WHERE_kdBRg." and g ='00' and h ='00' and i='00' and j = '000'");
		$dt_F = $qry_F["hasil"];
		
		// Kode Barang g --------------------------------------------------------------------------------------
		$WHERE_kdBRg.= " AND g='$g' ";
		$qry_G = $this->QyrTmpl1Brs("ref_barang", "concat(g,'. ', nm_barang) as nama", $WHERE_kdBRg." and h ='00' and i='00' and j = '000'");
		$dt_G = $qry_G["hasil"];
		
		// Kode Barang h --------------------------------------------------------------------------------------
		$WHERE_kdBRg.= " AND h='$h' ";
		$qry_H = $this->QyrTmpl1Brs("ref_barang", "concat(h,'. ', nm_barang) as nama", $WHERE_kdBRg." and i='00' and j = '000'");
		$dt_H = $qry_H["hasil"];
		
		// Kode Barang i --------------------------------------------------------------------------------------
		$qry_I = "SELECT i, concat(i, '. ', nm_barang) as nama FROM ref_barang $WHERE_kdBRg AND i!='00' AND j='000' ";
		
		// Kode Barang j --------------------------------------------------------------------------------------
		$WHERE_kdBRg.= " AND i='$i' ";
		$qry_J = "SELECT j, concat(j, '. ', nm_barang) as nama FROM ref_barang $WHERE_kdBRg AND j!='000' ";
		
		$DataKirim = $dataBarangF1F2.
			$this->isiform(
				array(
					array(
						'label'=>'JENIS',
						'name'=>'cmbJenis',
						'label-width'=>$widthCol,
						'type'=>'text',
						'value'=>$dt_F['nama'],
						'align'=>'left',
						'parrams'=>"style='width:400px;' readonly",
					),
					array(
						'label'=>'OBYEK',
						'name'=>'cmbObyek',
						'label-width'=>$widthCol,
						'type'=>'text',
						'value'=>$dt_G['nama'],
						'align'=>'left',
						'parrams'=>"style='width:400px;' readonly",
					),
					array(
						'label'=>'RINCIAN OBYEK',
						'name'=>'cmbRincianObyek',
						'label-width'=>$widthCol,
						'type'=>'text',
						'value'=>$dt_H['nama'],
						'align'=>'left',
						'parrams'=>"style='width:400px;' readonly",
					),
					array(
						'label'=>'SUB RINCIAN OBYEK',
						'label-width'=>$widthCol,
						'value'=>cmbQuery("cmbSubRincianObyek",$i,$qry_I,"$functionnya style='width:400px;'",'--- PILIH SUB RINCIAN OBYEK ---'),
					)
					,
					array(
						'label'=>'SUB SUB RINCIAN OBYEK',
						'label-width'=>$widthCol,
						'value'=>cmbQuery("cmbSubSubRincianObyek",$j,$qry_J,"$functionnya style='width:400px;'",'--- PILIH SUB RINCIAN OBYEK ---'),
					)
				)
			);
			
		return $DataKirim;
		
	}
	
	function GenViewKode_Barang2($f1,$f2,$f,$g,$h,$i,$j, $functionnya='', $widthCol='100px;'){
		$DataOption = $this->DataOption();
		
		$WHERE_kdBRg = "WHERE f1='$f1' AND f2='$f2' ";
		$dataBarangF1F2 = '';
		if($DataOption['kode_barang'] == '2'){
	 		$cmbAkun = $_REQUEST['cmbAkun'];
			$cmbKelompok = $_REQUEST['cmbKelompok'];			
			
			$qry_F1 = "select f1 , nm_barang from ref_barang where f1 != '0' and f2 = '0' and f = '00' and g ='00' and h ='00' and i='00' and j = '000'";
			$WHERE_kdBRg = "WHERE f1='$f1' ";
			
			$qry_F2 = "select f2 , nm_barang from ref_barang $WHERE_kdBRg and f2 != '0' and f = '00' and g ='00' and h ='00' and i='00' and j = '000'";
			$WHERE_kdBRg .= "WHERE f2='$f2' ";
						
			
			
			$dataBarangF1F2 = 
				$this->isiform(
					array(
						array(
							'label'=>'AKUN',
							'name'=>'cmbAkun',
							'label-width'=>$widthCol,
							'value'=>cmbQuery1("cmbAkun",$f1,$qry_F1,"$functionnya style='width:400px;'",'--- PILIH AKUN ---',''),
						),
						array(
							'label'=>'KELOMPOK',
							'name'=>'cmbKelompok',
							'label-width'=>$widthCol,
							'type'=>'text',
							'value'=>cmbQuery1("cmbKelompok",$f2,$qry_F2,"$functionnya style='width:400px;'",'--- PILIH KELOMPOK ---',''),
						)
					)
				);
		}
		// Kode Barang f --------------------------------------------------------------------------------------
		$qry_F = "select f, nm_barang from ref_barang $WHERE_kdBRg and f != '00' and g ='00' and h ='00' and i='00' and j = '000'";		
		$WHERE_kdBRg.= " AND f='$f' ";
		
		// Kode Barang g --------------------------------------------------------------------------------------
		$qry_G = "select g, nm_barang from ref_barang $WHERE_kdBRg and g !='00' and h ='00' and i='00' and j = '000'";		
		$WHERE_kdBRg.= " AND g='$g' ";
		
		// Kode Barang h --------------------------------------------------------------------------------------
		$qry_H = "select h, nm_barang from ref_barang $WHERE_kdBRg and h !='00' and i='00' and j = '000'";		
		$WHERE_kdBRg.= " AND h='$h' ";
		
		// Kode Barang i --------------------------------------------------------------------------------------
		$qry_I = "SELECT i, concat(i, '. ', nm_barang) as nama FROM ref_barang $WHERE_kdBRg AND i!='00' AND j='000' ";
		$WHERE_kdBRg.= " AND i='$i' ";
		
		// Kode Barang j --------------------------------------------------------------------------------------		
		$qry_J = "SELECT j, concat(j, '. ', nm_barang) as nama FROM ref_barang $WHERE_kdBRg AND j!='000' ";
		
		$DataKirim = $dataBarangF1F2.
			$this->isiform(
				array(
					array(
						'label'=>'JENIS',
						'name'=>'cmbJenis',
						'label-width'=>$widthCol,
						'value'=>cmbQuery1("cmbJenis",$f,$qry_F,"$functionnya style='width:400px;'",'--- PILIH JENIS ---',''),
					),
					array(
						'label'=>'OBYEK',
						'name'=>'cmbObyek',
						'label-width'=>$widthCol,
						'value'=>cmbQuery1("cmbObyek",$g,$qry_G,"$functionnya style='width:400px;'",'--- PILIH OBYEK ---',''),
					),
					array(
						'label'=>'RINCIAN OBYEK',
						'name'=>'cmbRincianObyek',
						'label-width'=>$widthCol,
						'value'=>cmbQuery1("cmbRincianObyek",$h,$qry_H,"$functionnya style='width:400px;'",'--- PILIH RINCIAN OBYEK ---',''),
					),
					array(
						'label'=>'SUB RINCIAN OBYEK',
						'label-width'=>$widthCol,
						'value'=>cmbQuery("cmbSubRincianObyek",$i,$qry_I,"$functionnya style='width:400px;'",'--- PILIH SUB RINCIAN OBYEK ---'),
					)
					,
					array(
						'label'=>'SUB SUB RINCIAN OBYEK',
						'label-width'=>$widthCol,
						'value'=>cmbQuery("cmbSubSubRincianObyek",$j,$qry_J,"$functionnya style='width:400px;'",'--- PILIH SUB RINCIAN OBYEK ---'),
					)
				)
			);
			
		return $DataKirim;
		
	}
	
	function InputTypeText($name, $val, $style="style='width:300px;'"){
		return "<input type='text' name='$name' id='$name' value='$val' $style />";
	}
	
	// DI SISTEM KEUANGAN ------------------------------------------------------------------------------------------------
	function GetData_SisaAnggaran($Id_noSPD, $Id_noSPDdet, $totanggaran){
		global $DataPengaturan;
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_spp_rekening a LEFT JOIN t_spp b ON a.refid_spp=b.Id","IFNULL(SUM(a.jumlah),0) as jumlah","WHERE a.refid_nomor_spd='$Id_noSPD' AND a.refid_nomor_spd_det='$Id_noSPDdet' AND b.status_sp2d='1' ");
		$dt = $qry["hasil"];
		
		$data = $totanggaran-$dt["jumlah"];
		
		return $data;
	}
	
	function Gen_Script_DatePicker(){
		return '
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>
			';
	}
	
	function Gen_NomorSurat($val){
		$hit = strlen($val);
		switch($hit){
			case 1 : $data="0000".$val;break;
			case 2 : $data="000".$val;break;
			case 3 : $data="00".$val;break;
			case 4 : $data="0".$val;break;
			default : $data=$val;break;
		}
		
		return $data;
	}
	
	function BUATBarcode($value,$nm_folder,$nm_file){
		include "lib/phpqrcode/qrlib.php"; //<-- LOKASI FILE UTAMA PLUGINNYA
 
		$tempdir = "Media/$nm_folder/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
		if (!file_exists($tempdir))#kalau folder belum ada, maka buat.
		    mkdir($tempdir);
		 
		 
		$isi_teks = $value;
		$namafile = $nm_file.".png";
		$quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
		$ukuran = 5; //batasan 1 paling kecil, 10 paling besar
		$padding = 0;
		 
		QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
	}
	
	function DataSkpd_Form($name, $width='100px', $c1='0', $c='00', $d='00'){
		$get = $this->DataSkpd($name, $width, $c1, $c, $d );
		
		$data = LabelSPan1($name,$get["content"]);
		
		return $data;
	}
	
	function DataSkpd($name='', $widthnya='100px', $c1='0',$c='00',$d='00'){
		global $Main;
		$cek='';$err="";$content="";
		
		$SKPDname = cekPOST2("SKPDname", $name);
		$widthnya = cekPOST2("widthnya", $widthnya);
		
		$c1=cekPOST2($SKPDname."_fm_Urusan",$c1);
		$c=cekPOST2($SKPDname."_fm_Bidang",$c);
		$d=cekPOST2($SKPDname."_fm_Skpd",$d);
		
		$fn = $this->Prefix.".DataSkpd(`$SKPDname`, `$widthnya`)";
		
		$data_skpd = array();
		$DataOption = $this->DataOption();
		if($DataOption["skpd"] == 2){
			$qry_c1 = "SELECT c1, nm_skpd FROM ref_skpd WHERE c1!='0' AND c='00' AND d='00' AND e='00' AND e1='000'"; 
			$data_skpd = 
				array(
					array(
						'label'=>'URUSAN',
						'label-width'=>$widthnya,
						'value'=>cmbQuery1($SKPDname."_fm_Urusan",$c1,$qry_c1, "onchange='$fn'", "--- SEMUA URUSAN ---")
					),
				);
		}
		
		
		$qry_c = "SELECT c, nm_skpd FROM ref_skpd WHERE c1='$c1' AND c!='00' AND d='00' AND e='00' AND e1='000'";
		$qry_d = "SELECT d, nm_skpd FROM ref_skpd WHERE c1='$c1' AND c='$c' AND d!='00' AND e='00' AND e1='000'";
		
		$data_skpd1 =
			array(
				array(
					'label'=>'BIDANG',
					'label-width'=>$widthnya,
					'value'=>cmbQuery1($SKPDname."_fm_Bidang",$c,$qry_c, "onchange='$fn'", "--- SEMUA BIDANG ---"),
				),
				array(
					'label'=>'SKPD',
					'value'=>cmbQuery1($SKPDname."_fm_Skpd",$d,$qry_d, "onchange='$fn'", "--- SEMUA SKPD ---"),
				),
			);
			
		$data = $this->isiform(array_merge($data_skpd, $data_skpd1));		
		$content = genFilterBar(array($data),'','','');
	
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function SetDelete_Temp($Id=""){
		$where = $Id != ""?"Id='$Id'":"tgl_create < DATE_SUB(NOW(), INTERVAL 8 HOUR)";
		$qry = $this->QryDelData($this->Tbl_Temp,"WHERE $where");
	}
	
	function Validasi_SKPD($name, $err=""){		
		$DataOption = $this->DataOption();
		
		$defVal = $name."SKPDfm";
		$c1 = cekPOST2($defVal."URUSAN");
		$c = cekPOST2($defVal."SKPD");
		$d = cekPOST2($defVal."UNIT");
		$e = cekPOST2($defVal."SUBUNIT");
		$e1 = cekPOST2($defVal."SEKSI");
		
		if($err == "" && $DataOption["skpd"] == 2 && ($c1 == 0 || $c1 == ""))$err = "Urusan Belum Di Pilih !";
		if($err == "" && ($c == "00" || $c == ""))$err = "Bidang Belum Di Pilih !";
		if($err == "" && ($d == "00" || $d == ""))$err = "SKPD Belum Di Pilih !";
		if($err == "" && ($e == "00" || $e == ""))$err = "Unit Belum Di Pilih !";
		if($err == "" && ($e1 == "000" || $e1 == ""))$err = "Sub Unit Belum Di Pilih !";
		
		return $err;
	}
		
}
$DataPengaturan = new DataPengaturanObj();
?>