<?php
class pemusnahanbaObj extends DaftarObj2{
	var $Prefix = 'pemusnahanba';
	var $SHOW_CEK = TRUE;	
	var $TblName = 'v_pemusnahanba';//'v1_rkb'
	var $TblName_Hapus = 'pemusnahan';
	var $TblName_Edit = 'pemusnahan';
	var $KeyFields = array('id');
	var $FieldSum = array('jml_harga');
	var $fieldSum_lokasi = array(8);
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 7, 6, 6);
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $totalCol = 9; //total kolom daftar
	var $FormName = 'pemusnahanbaForm';
	//var $pagePerHal = 7;
	//var $thnsensus_default = 2013;
	//var $periode_sensus = 5;// tahun	
	var $PageTitle = 'Pemindahtanganan';
	var $PageIcon = 'images/pemindahtanganan_ico.gif';	
	var $checkbox_rowspan = 2;
	var $fileNameExcel='pemusnahan.xls';
	var $Cetak_Judul = 'Pemindahtanganan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $fmST = 0;
	var $idpilih = '';
	
	function setPage_OtherScript(){
		$scriptload = 

					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".	
			 "<script type='text/javascript' src='js/pemusnahan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/pemusnahan/pemusnahan_panitia.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/pemusnahan/pemusnahan_det.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/penatausaha.js' language='JavaScript' ></script>".
			$scriptload;
	}
	function setTitle(){
		return 'BERITA ACARA PEMUSNAHAN BARANG';
		//return 'Rencana Kebutuhan Barang Milik D';
	}
	function setNavAtas(){
		$Pg = $_REQUEST['Pg'];
		switch($Pg){
				case		'pemusnahanba': $styleMenu1_3 = " style='color:blue;'"; break;
				default		: $styleMenu1 = " style='color:blue;'"; break;
				
			}
		return
			'<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td class="menudottedline" width="60%" height="20" style="text-align:right"><b>
				<a href="index.php?Pg=10&bentuk=1&SSPg=" title="PEMINDAHTANGANAN">PEMINDAHTANGANAN</a>  |  
				<a style="color:blue;" href="pages.php?Pg=pemusnahan" title="PEMUSNAHAN">PEMUSNAHAN</a>&nbsp;&nbsp;&nbsp;
			</b></td>
			</tr>
			<tr>
			<tr>
			<td class="menudottedline" width="60%" height="20" style="text-align:right"><b>
				<a '.$styleMenu1_3.' href="pages.php?Pg=pemusnahanba" title="Berita Acara">Berita Acara </a>  |  
				<a '.$styleMenu1.' href="pages.php?Pg=pemusnahan" title="Pemusnahan">Pemusnahan</a>  
				
				<!--
				|<a href="pages.php?Pg=pemusnahanrekap" title="Rekap">Rekap</a>  |  
				<a href="pages.php?Pg=pemusnahanrekap_skpd" title="Rekap (SKPD)">Rekap (SKPD)</a>  
				-->
				  &nbsp;&nbsp;&nbsp;
			</b></td>
			</tr>
			</table>';
	}
	function setMenuEdit(){		
		return
			
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru2()","new_f2.png","Baru",'DPBMD Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit2()","edit_f2.png","Edit", 'Edit DPBMD')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus DPBMD')."</td>";
			
			
	}
	
	function setKolomHeader($Mode=1, $Checkbox=''){
		$NomorColSpan = $Mode==1? 2: 1;
		$headerTable =
			"<thead>
				<tr>
				
					<th class='th01' width='40' rowspan=2 width='40'>No.</th>
					$Checkbox		
					<th class='th02' colspan=2>Berita Acara</th>
					<th class='th01' rowspan=2 width=''>Cara Pemusnahan</th>
					<th class='th01' rowspan=2 width=''>Penganggungjawab</th>		
					<th class='th01' rowspan=2>Jumlah Barang</th>
					<th class='th01' rowspan=2 width=''>Jumlah Harga</th>
					<th class='th01' rowspan=2 width='100'>Keterangan </th>
				</tr>
				<tr>
					<th class='th01' width='80'>Nomor </th>				
					<th class='th01' width='60'>Tanggal </th>
				</tr>
				
			</thead>";
		return $headerTable;
	}
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref,$HTTP_COOKIE_VARS;
		
		$Koloms = array();		
		$Koloms[] = array('align=right', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
				
		$Koloms[] = array("align='left'",  $isi['no_ba']  );
		$Koloms[] = array("align='left'",  TglInd($isi['tgl_ba'] ) );		
		$Koloms[] = array("align='left'",  $isi['cara_pemusnahan']  );
		$Koloms[] = array("align='left'",  $isi['penganggungjawab']  );
		$Koloms[] = array("align='right'", number_format( $isi['jml_barang'] ,0,',','.') );		
		$Koloms[] = array("align='right'", number_format( $isi['jml_harga'] ,2,',','.') );
		$Koloms[] = array("align='right'", $isi['ket']);
		return $Koloms;
	}
	function setCekBox($cb, $KeyValueStr, $isi){
		return "<input type='checkbox' id='".$this->Prefix."_cb$cb' name='".$this->Prefix."_cb[]' 
					value='".$KeyValueStr."' stat='".$isi['stat']."'  onClick=\"isChecked2(this.checked,'".$this->Prefix."_jmlcek');\" />";					
	}
	
	function cmbQueryUrusan($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE) {
     global $Ref,$Main,$HTTP_COOKIE_VARS;
			
	 $aqry="select * from ref_skpd where c1!=0 and c='00' and d='00'  GROUP by c1";
	 $Query = mysql_query($aqry);
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $nmSKPDUrusan='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['c1'] ==  $value ? "selected" : "";
				if ($nmSKPDUrusan=='' ) $nmSKPDUrusan =  $value == $Hasil['c1'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[c1]}'>{$Hasil['c1']}. {$Hasil['nm_skpd']}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDUrusan <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	
	function cmbQueryBidang($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE) {
     global $Ref,$Main,$HTTP_COOKIE_VARS;
	 
	 	$fmSKPDUrusan = cekPOST('fmSKPDUrusan')!=$vAtas? cekPOST('fmSKPDUrusan'): $HTTP_COOKIE_VARS['cofmUrusan'];
			
	 $aqry=$Main->URUSAN==1?"select * from ref_skpd where c1='$fmSKPDUrusan' and c!='00' and d='00'  GROUP by c"
	 :"select * from ref_skpd where c!='00' and d='00'  GROUP by c";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDBidang='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['c'] ==  $value ? "selected" : "";
				if ($nmSKPDBidang=='' ) $nmSKPDBidang =  $value == $Hasil['c'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[c]}'>{$Hasil['c']}. {$Hasil['nm_skpd']}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDBidang <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	
	function cmbQuerySKPD($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE) {
	 global $Ref,$Main,$HTTP_COOKIE_VARS;
	 
		$fmSKPDUrusan = cekPOST('fmSKPDUrusan')!=$vAtas? cekPOST('fmSKPDUrusan'): $HTTP_COOKIE_VARS['cofmUrusan'];
		$fmSKPDBidang = cekPOST('fmSKPDBidang')!=$vAtas? cekPOST('fmSKPDBidang'): $HTTP_COOKIE_VARS['fmSKPDBidang'];
			
	 $aqry=$Main->URUSAN==1?"select * from ref_skpd where c1='$fmSKPDUrusan' and c='$fmSKPDBidang' and d!='00' and e='00' GROUP by d"
	 :"select * from ref_skpd where c='$fmSKPDBidang' and d!='00' and e='00' GROUP by d";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDskpd='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['d'] ==  $value ? "selected" : "";
				if ($nmSKPDskpd=='' ) $nmSKPDskpd =  $value == $Hasil['d'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[d]}'>{$Hasil['d']}. {$Hasil['nm_skpd']}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDskpd <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	
	function cmbQueryUnit($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE,$edit='') {
	 global $Ref,$Main,$HTTP_COOKIE_VARS;
	 if($edit==""){
	 	$fmSKPDBidang = cekPOST('fmSKPDBidang')!=$vAtas? cekPOST('fmSKPDBidang'): $HTTP_COOKIE_VARS['cofmSKPD'];
		$fmSKPDSkpd = cekPOST('fmSKPDskpd')!=$vAtas? cekPOST('fmSKPDskpd'): $HTTP_COOKIE_VARS['cofmUNIT'];
	 }else{
	 	$xplode=explode('.',$edit);
		$fmSKPDBidang=$xplode[0];
		$fmSKPDSkpd=$xplode[1];
	 }
		
			
	 $aqry="select * from ref_skpd where c='$fmSKPDBidang' and d='$fmSKPDSkpd' and e!='00' and e1='000' GROUP by e";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDUnit='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['e'] ==  $value ? "selected" : "";
				if ($nmSKPDUnit=='' ) $nmSKPDUnit =  $value == $Hasil['e'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[e]}'>{$Hasil[nm_skpd]}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDUnit <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	
	function cmbQuerySubUnit($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE,$edit='') {
	 global $Ref,$Main,$HTTP_COOKIE_VARS;
	 if($edit==""){
	 	$fmSKPDBidang = cekPOST('c')!=$vAtas? cekPOST('c'): $HTTP_COOKIE_VARS['cofmSKPD'];
		$fmSKPDSkpd = cekPOST('d')!=$vAtas? cekPOST('d'): $HTTP_COOKIE_VARS['cofmUNIT'];
		$fmSKPDUnit = cekPOST('fmSKPDUnit_form')!=$vAtas? cekPOST('fmSKPDUnit_form'): $HTTP_COOKIE_VARS['cofmSUBUNIT'];
	}else{
	 	$xplode=explode('.',$edit);
		$fmSKPDBidang=$xplode[0];
		$fmSKPDSkpd=$xplode[1];
		$fmSKPDUnit=$xplode[2];
	 }
			
	 $aqry="select * from ref_skpd where c='$fmSKPDBidang' and d='$fmSKPDSkpd' and e='$fmSKPDUnit' and e1!='000' GROUP by e1";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDUnit='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['e1'] ==  $value ? "selected" : "";
				if ($nmSKPDUnit=='' ) $nmSKPDUnit =  $value == $Hasil['e1'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[e1]}'>{$Hasil[nm_skpd]}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDUnit <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	
	function genDaftarInitial(){
		global $HTTP_COOKIE_VARS,$Main;
		$vOpsi = $this->genDaftarOpsi();
		$fmThnAnggaran=  $_COOKIE['coThnAnggaran'];
		$fmSKPDUrusan = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST('fmSKPDUrusan');
		$fmSKPDBidang = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST('fmSKPDBidang');
		$fmSKPDskpd = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST('fmSKPDskpd');
		
		$divHal = "<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
							"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
						"</div>";
		switch($this->daftarMode){						
			case '1' :{ //detail horisontal
				$vdaftar = 
					"<table width='100%'><tr valign=top>
					<td style='width:$this->containWidth;'>".
						"<div id='{$this->Prefix}_cont_daftar' style='position:relative;width:$this->containWidth;overflow:auto' >"."</div>".
						$divHal.
					"</td>".
					"<td>".
						"<div id='{$this->Prefix}_cont_daftar_det' style=''>".$this->genTableDetail()."</div>".
					"</td>".
					"</tr></table>";
				break;
			}
			default :{
				$vdaftar = 
					"<div id='{$this->Prefix}_cont_daftar' style='position:relative;' >"."</div>".
					$divHal;					
				break;
			}
		}
		
		return		
			//$NavAtas.	
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 
				"<input type='hidden' value='$fmThnAnggaran' id='fmThnAnggaran' name='fmThnAnggaran' >".
				"<input type='hidden' value='$fmSKPDUrusan' id='fmSKPDUrusan' name='fmSKPDUrusan' >".
				"<input type='hidden' value='$fmSKPDBidang' id='fmSKPDBidang' name='fmSKPDBidang' >".
				"<input type='hidden' value='$fmSKPDskpd' id='fmSKPDskpd' name='fmSKPDskpd' >".
			"</div>".	
			//"<div style='position:relative'>".
			$vdaftar.
			//"</div>".
			'';
	}
	
	function genDaftarOpsi(){
		global $Ref, $Main,$HTTP_COOKIE_VARS;
		
		//$fmSKPDBidang=cekPOST('fmSKPDBidang');
		// $fmSKPDskpd=cekPOST('fmSKPDskpd');
		 $fmThnAnggaran=  $_COOKIE['coThnAnggaran'];
		 $fmThnAnggaranDari=  cekPOST('fmThnAnggaranDari')=='' ? $fmThnAnggaran : cekPOST('fmThnAnggaranDari');
		 $fmThnAnggaranSampai=  cekPOST('fmThnAnggaranSampai')=='' ? $fmThnAnggaran : cekPOST('fmThnAnggaranSampai');
		
		$fmSKPDUrusan = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST('fmSKPDUrusan');
		$fmSKPDBidang = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST('fmSKPDBidang');
		$fmSKPDskpd = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST('fmSKPDskpd');
		
		//data cari ----------------------------
		
		$arrCari = array(
			array('1','1'),
			array('2','2'), //array('3','Kode Rekening'),	//array('4','Nama Rekening')
		);
			
		 //get selectbox cari data :kode barang,nama barang
		 $fmPILCARI = cekPOST('fmPILCARI');
		 
		$filterc1=$Main->URUSAN==1?"<tr><td width='100'>Urusan</td><td width='10'>:</td><td>".
				$this->cmbQueryUrusan('fmSKPDUrusan',$fmSKPDUrusan,'','onchange='.$this->Prefix.'.UrusanAfter()','--- Pilih Urusan ---','0')."</td></tr>".
			"</td><tr>":"";
		$TampilOpt =
			
			"<input type='hidden' value='".$Main->URUSAN."' id='settingurusan' name='settingurusan' >
			<table  class=\"adminform\"><tr>		
			<td width=\"100%\" valign=\"top\">
			<table>
			$filterc1
			<tr><td width='100'>Bidang</td><td width='10'>:</td><td>".
				$this->cmbQueryBidang('fmSKPDBidang',$fmSKPDBidang,'','onchange='.$this->Prefix.'.BidangAfter()'.$disabled1,'--- Pilih Bidang ---','00')."</td></tr>".
			"</td><tr>".
			"<tr><td width='100'>Skpd</td><td width='10'>:</td><td>".
				$this->cmbQuerySKPD('fmSKPDskpd',$fmSKPDskpd,'','onchange='.$this->Prefix.'.SKPDAfter()'.$disabled1,'--- Pilih Skpd ---','00').
			"</td><tr>
			<td width='100'>Tahun Anggaran</td><td width='10'>:</td><td>
				<input type='text'  size='4' value='$fmThnAnggaranDari' id='fmThnAnggaranDari' name='fmThnAnggaranDari' > s/d <input type='text'  size='4' value='$fmThnAnggaranSampai' id='fmThnAnggaranSampai' name='fmThnAnggaranSampai' >
				<td style='border-right:1px solid #E5E5E5;'></td></tr> 	
			</table></table>".			
				genFilterBar(
				array(	
					"<table><tr>
					<td width='60'>Semester</td><td width='10'>:</td><td>".
					cmbArray('fmPILCARI',$fmPILCARI,$arrCari,'Semua','').
					"</td></tr>			
					</table>"					
				),$this->Prefix.".refreshList(true)",TRUE
			);
		
		return array('TampilOpt'=>$TampilOpt);
	}	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		
		//kondisi -----------------------------------
		$arrKondisi = array();		
		$arrKondisi[] = "sttemp='0'";
		$fmUrusan = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST('fmSKPDUrusan');
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST('fmSKPDBidang');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST('fmSKPDskpd');
		//$fmSUBUNIT = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		//$fmSEKSI = isset($HTTP_COOKIE_VARS['cofmSEKSI'])? $HTTP_COOKIE_VARS['cofmSEKSI']: cekPOST($this->Prefix.'SkpdfmSEKSI');
		$fmThnAnggaranDari=  cekPOST('fmThnAnggaranDari');
		$fmThnAnggaranSampai=  cekPOST('fmThnAnggaranSampai');
		$fmPILCARI = cekPOST('fmPILCARI');
		if($Main->URUSAN==1 && !($fmUrusan=='' || $fmUrusan=='0')  ) $arrKondisi[] = "c1='$fmUrusan'";
		if(!($fmSKPD=='' || $fmSKPD=='00') ) $arrKondisi[] = "c='$fmSKPD'";
		if(!($fmUNIT=='' || $fmUNIT=='00') ) $arrKondisi[] = "d='$fmUNIT'";
		//if(!($fmSUBUNIT=='' || $fmSUBUNIT=='00') ) $arrKondisi[] = "e='$fmSUBUNIT'";
		//if(!($fmSEKSI=='' || $fmSEKSI=='00') ) $arrKondisi[] = "e1='$fmSEKSI'";
		if ($fmThnAnggaranDari == $fmThnAnggaranSampai){
		
			if(!($fmThnAnggaranDari=='')  && !($fmThnAnggaranSampai=='')) $arrKondisi[] = "thn_anggaran>='$fmThnAnggaranDari' and thn_anggaran<='$fmThnAnggaranSampai'";
			switch($fmPILCARI){			
			case '1': $arrKondisi[] = " tgl_ba>='".$fmThnAnggaranDari."-01-01' and  cast(tgl_ba as DATE)<='".$fmThnAnggaranSampai."-06-30' "; break;
			case '2': $arrKondisi[] = " tgl_ba>='".$fmThnAnggaranDari."-07-01' and  cast(tgl_ba as DATE)<='".$fmThnAnggaranSampai."-12-31' "; break;
			default :""; break;
			}
		}else{
			if(!($fmThnAnggaranDari=='') && !($fmThnAnggaranSampai=='')) $arrKondisi[] = "thn_anggaran>='$fmThnAnggaranDari' and thn_anggaran<='$fmThnAnggaranSampai'";
		}
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
				
		
		$arrOrders = array();
		//$arrOrders[] = " a,b,c,d,e,nip ";
		switch($fmORDER1){
			case '1': $arrOrders[] = " tahun $Asc1 " ;break;
			case '2': $arrOrders[] = " concat(f,g,h,i,j) $Asc1 " ;break;
			case '3': $arrOrders[] = " concat(k,l,m,n,o) $Asc1 " ;break;
		}		
		
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//limit --------------------------------------
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	
	function getJmlDKB($tahun, $c, $d, $e,$e1, $f,$g,$h,$i,$j){
		$aqry = "select * from dkb where tahun='$tahun' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' ";
		$get =  mysql_fetch_array(mysql_query($aqry));
		if($get['jml_barang']== NULL) $get['jml_barang']=0;
		return $get['jml_barang'];
	}
	
	function setFormBaru(){
		global $HTTP_COOKIE_VARS,$Main;
		$dt=array();
		$dt['c1'] = $Main->URUSAN==1?$_REQUEST['fmSKPDUrusan']:"";
		$dt['c'] = $_REQUEST['fmSKPDBidang'];
		$dt['d'] = $_REQUEST['fmSKPDskpd'];
		$dt['thn_anggaran'] = $_COOKIE['coThnAnggaran'];
		$uid = $HTTP_COOKIE_VARS['coID'];
		$tgl_buku =	$_COOKIE['coThnAnggaran'].'-'.date('m').'-'.date('d');
		//$tgl_buku =	$_COOKIE['coThnAnggaran'].'-00-00';
		$dt['tgl_buku'] = $tgl_buku;
		$dt['tgl_ba'] = date('Y-m-d');
		$this->form_fmST = 0;
		$query="INSERT into pemusnahan(uid,tgl_update,sttemp)"." values('$uid',NOW(),'1')"; $cek.=$query;
		$result=mysql_query($query);
		$dt['id']=mysql_insert_id(); 
		$this->form_idplh =$dt['id'];
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	
	function setFormEdit(){		
		global $Main;
		$cek = ''; $err=''; $content='';// $json=FALSE;
		$form = '';
		
		//$err = $_REQUEST['rkbSkpdfmSKPD'];
		$cbid = $_POST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];		
		$this->form_fmST = 1;
		$form_name = $this->Prefix.'_form';
		
		$aqry = "select * from $this->TblName where Id='$this->form_idplh'";
		$dt = mysql_fetch_array(mysql_query($aqry));
		
		$akun = mysql_fetch_array(mysql_query("select * from ref_jurnal where concat(ka,kb,kc,kd,ke,kf)='".$dt['k'].$dt['l'].$dt['m'].$dt['n'].$dt['o'].$dt['kf']."'")) ;
		$dt['nm_account']=$akun['nm_account'];
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err']	, 'content'=> $fm['content']);
	}
	
	
	
	function setForm($dt){	
		global $fmIDBARANG,$fmIDREKENING,$Main;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	 	
	 $form_name = $this->Prefix.'_form';
	 $sw=$_REQUEST['sw'];
	 $sh=$_REQUEST['sh'];				
	 $this->form_width = $sw-50;
	 $this->form_height = $sh-100;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU';
	  }else{
		$this->form_caption = 'EDIT';
	  }
	 
	/* $filc1 = 'urusan' => array('label'=>'URUSAN', 
								'labelWidth'=>200,
								'value'=>$urusan, 
								'type'=>'', 'row_params'=>"height='21'"
							)
			;*/	
		//items ----------------------
		$editunit= $dt['e'] != '' ? $dt['c'].".".$dt['d']:'';
		$editsubunit=$dt['e1'] != '' ? $dt['c'].".".$dt['d'].".".$dt['e']:'';
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='00' and d='00' "));
		$urusan = $get['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='00' "));
		$bidang = $get['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='00' "));
		$unit = $get['nm_skpd'];
		if($Main->URUSAN==1){
		 	$inputc1 = "<input type='hidden' id='c1' name='c1' value='".$dt['c1']."'> ";
		 	$labelc1="URUSAN";
		 	$valuec1=$urusan;
		 	$rowparamc1="height='21'";		
		 	$pemisahc1="";		
	 	}else{
		 	$inputc1 = "";
		 	$labelc1="";
		 	$valuec1="";
		 	$rowparamc1="";	
		 	$pemisahc1=" ";	
	 	}	
		/*****************************************************************
		 *				FORM UTAMA                                       *
		 *                                                               *
		 *****************************************************************/
		 $this->form_fields = array(									 
			'urusan' => array('label'=>$labelc1, 
								'labelWidth'=>200,
								'value'=>$valuec1, 
								'type'=>'',
								'row_params'=>$rowparamc1,
								'pemisah'=>$pemisahc1
							),
			'bidang' => array( 'label'=>'BIDANG', 
								'labelWidth'=>200,
								'value'=>$bidang, 
								'type'=>'', 'row_params'=>"height='21'"
							),
			'skpd' => array( 'label'=>'SKPD', 
								'value'=>$unit, 
								'type'=>'', 'row_params'=>"height='21'"
							),			
            'thn_anggaran' => array( 
								'label'=>'Tahun',
								'labelWidth'=>200, 
								'value'=>"<input type='text' name='fmtahun' id='fmtahun' size='4' value='".$dt['thn_anggaran']."' readonly=''>"
									 ),
			'tgl_buku' => array(
							'label'=>'Tanggal Buku Pemusnahan', 
							'value'=>createEntryTgl('tgl_buku', $dt['tgl_buku'], false, '','','FormPemusnahan','2'), 
							'type'=>''
			),
			'ba' => array(
							'label'=>'', 
							'value'=>'Berita Acara Pemusnahan Barang', 
							'type'=>'merge',
							'row_params'=>" height='21'"
							),
			'no_ba' => array(
							'label'=>'&nbsp;&nbsp;Nomor', 
							'value'=>$dt['no_ba'], 
							'type'=>'text'
			),
			'tgl_ba' => array(
							'label'=>'&nbsp;&nbsp;Tanggal', 
							'value'=> createEntryTgl('tgl_ba',$dt['tgl_ba'] ), 
							'type'=>''
			),			
			'cr_pemusnahan' => array(
							'label'=>'Cara Pemusnahan', 
							'value'=>$dt['cara_pemusnahan'], 
							'type'=>'text',
							'param'=> "style='width:430px'"
			),
			'penanggungjawab' => array(
							'label'=>'Penanggung Jawab', 
							'value'=>$dt['penganggungjawab'], 
							'type'=>'text',
							'param'=> "style='width:430px'"
			),
			'ket' => array( 'label'=>'Keterangan', 
				'value'=>"<textarea name=\"fmKET\" cols=\"60\" style='margin: 2px;width: 438px; height: 51px;' >".$dt['ket']."</textarea>", 
				'type'=>'', 'row_params'=>"valign='top'"
			),
			'daftarpanitia' => array( 
						'label'=>'',
						 'value'=>"<a href=\"javascript:pemusnahanba.showPanitia('divPanitiaList');\">
						 			<div style=\"border-bottom: 2px solid #02769D;\">
									 <table class=\"barHeader\" style=\"height:25;\" id=\"barPanitia_head\">
									  <tbody>
									   <tr>
									     <td style=\"width:20\" class=\"\"><img id=\"barPanitia_ico\" src=\"images/tumbs/right.png\"></td>
							             <td style=\"padding: 0 8 0 0\" class=\"\" width=\"\">Panitia
									      </td>
										 </tr>
										 </tbody>
										 </table>
										 </a>
										  </div>
										 <div id='divPanitiaList' style='display:none'></div>
									  ", 
						 'type'=>'merge'
			),
			'daftarbarang' => array( 
						'label'=>'',
						 'value'=>"<a href=\"javascript:pemusnahanba.showBarang('divBarangList');\">
						 			<div style=\"border-bottom: 2px solid #02769D;\">
									 <table class=\"barHeader\" style=\"height:25;\" id=\"barBarang_head\">
									  <tbody>
									   <tr>
									     <td style=\"width:20\" class=\"\"><img id=\"barBarang_ico\" src=\"images/tumbs/right.png\"></td>
							             <td style=\"padding: 0 8 0 0\" class=\"\" width=\"\">Barang yang dimusnahkan
									      </td>
										 </tr>
										 </tbody>
										 </table>
										 </a>
										  </div>
										 <div id='divBarangList' style='display:none'></div>
									  ", 
						 'type'=>'merge'
			),
			
			/*'menu' => array( 
						'label'=>'',
						'value'=>"<table width='100%' class='menudottedline'>
								   <tbody>
								    <tr>
									 <td>
										<table width='50'>
										 <tbody>
										  <tr>				
											<td>					
											 <table cellpadding='0' cellspacing='0' border='0' id='toolbar' >
											  <tbody>
											   <tr valign='middle' align='center'> 
											     <td class='border:none'> 
												  <a class='toolbar' id='btsave' 
													href='javascript:".$this->Prefix.".Simpan()'> 
												     <img src='images/administrator/images/save_f2.png' alt='Save' name='save' width='32' height='32' border='0' align='middle' title='Simpan'> Simpan</a> 
											      </td> 
											     </tr> 
											     </tbody>
											    </table> 
											   </td>
											 <td>			
											   <table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
											    <tbody>
												 <tr valign='middle' align='center'> 
											      <td class='border:none'> 
												    <!--<a class='toolbar' id='' href='javascript:window.close();'>-->
												    <a class='toolbar' id='btbatal' href='javascript:".$this->Prefix.".Batal()'>
													   <img src='images/administrator/images/cancel_f2.png' alt='Batal' name='batal' width='32' height='32' border='0' align='middle' title='Batal'> Batal</a> 
											      </td> 
											      </tr> 
											     </tbody>
												</table> 
											 </td>
											</tr>
										</tbody>
									  </table>
									</td>
								   </tr>
									</tbody>
									</table>",
						 'type'=>'merge'
					 )*/
		);
		
				
		//tombol
		$this->form_menubawah = //"";
			$inputc1.
			"<input type='hidden' id='c' name='c' value='".$dt['c']."'> ".
			"<input type='hidden' id='d' name='d' value='".$dt['d']."'> ".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan2()' >&nbsp;".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >"
			;
		
		//$this->genForm_nodialog();
		$form = $this->genForm();		
				
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function simpan2(){
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
		$id = $_REQUEST[$this->Prefix.'_idplh'];
		$UID = $HTTP_COOKIE_VARS['coID'];
		
		$a1 = $Main->DEF_KEPEMILIKAN;
		$a = $Main->DEF_PROPINSI;
		$b = $Main->DEF_WILAYAH;
		
		$c1 = $_REQUEST['c1'];
		$c = $_REQUEST['c'];
		$d = $_REQUEST['d'];		
		$tahun = $_REQUEST['fmtahun'];	
		$no_ba 	= $_REQUEST['no_ba'];
		$tgl_ba 	= $_REQUEST['tgl_ba'];
		$tgl_buku 	= $_REQUEST['tgl_buku'];
		$cr_pemusnahan = $_REQUEST['cr_pemusnahan'];
		$penanggungjawab = $_REQUEST['penanggungjawab'];
		$ket = $_REQUEST['fmKET'];

			
		
		//-- validasi
		if($err=='' && $no_ba == '')$err = "No BA belum diisi !";
		if($err=='' && $tgl_ba == '')$err = "Tangal BA belum dipilih !";
		if($err=='' && !cektanggal($tgl_buku))$err = "Tanggal Buku Pemusnahan $tgl_buku Salah!";
		if($err=='' && $tgl_buku == $_COOKIE['coThnAnggaran'].'-00-00' || $tgl_buku=='' )$err = 'Tanggal Buku Pemusnahan belum diisi!';
		if($err=='' && compareTanggal($tgl_buku,$tgl_ba)==0 )$err = 'Tanggal Buku harus lebih besar dari Tangal BA !';		
		if($err=='' && $cr_pemusnahan == '')$err = "Cara Pemusnahan belum diisi !";
		if($err=='' && $penanggungjawab == '')$err = "Penanggung Jawab belum diisi !";		
		if($err=='' && sudahClosing($tgl_buku,$c,$d,'','',$c1))$err = 'Tanggal sudah Closing !';		
		$old = mysql_fetch_array( mysql_query(
			"select * from $this->TblName where id='$id' "		
		));	
		
		$get = "select * from pemusnahan_det where refid_pemusnahan = '$id' ";//$cek.=$get;				
				$qry = mysql_query($get);
				while($row = mysql_fetch_array($qry)){
					$id_bukuinduk = $row['id_bukuinduk'];
					$querybi="select tgl_buku from buku_induk where id='$id_bukuinduk'";$cek.=$querybi;
					$bi = mysql_fetch_array( mysql_query($querybi));	
					if($err=='' && compareTanggal($tgl_buku,$bi['tgl_buku'])==0)$err = "Tanggal Buku Pemusnahan harus besar lebih dari Tangal Buku Barang !";		
				}
		if($err==''){
			if($fmST == 0){//baru
				
				$aqry = 
					"update $this->TblName_Edit  ".
					"set ".
					" c1='$c1',c='$c',d='$d',no_ba='$no_ba',tgl_ba='$tgl_ba',tgl_buku='$tgl_buku',cara_pemusnahan='$cr_pemusnahan',".
					" penganggungjawab='$penanggungjawab',ket='$ket',thn_anggaran='$tahun',".
					" uid='$UID', tgl_update= now(),sttemp='0' ".
					"where id='$id'";				
				
			}else{
			
				$aqry = 
					"update $this->TblName_Edit  ".
					"set ".
					" no_ba='$no_ba',tgl_ba='$tgl_ba',tgl_buku='$tgl_buku',cara_pemusnahan='$cr_pemusnahan',".
					" penganggungjawab='$penanggungjawab',ket='$ket',".
					" uid='$UID', tgl_update= now() ".
					"where id='$id'";
				
			}
			$cek .= $aqry;
			$qry = mysql_query($aqry);
			if($qry == FALSE) $err='Gagal SQL'.mysql_error();			
		}		
		//$err=$cek;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);					
	}	
	
	function Hapus_Validasi($id){
		$err ='';
		//$KeyValue = explode(' ',$id);
		$get = mysql_fetch_array(mysql_query(
			"select count(*) as cnt from penerimaan where id_pengadaan ='$id' "
		));
		if($err=='' && $get['cnt']>0 ) $err = 'Data Tidak Bisa Dihapus, Sudah ada di Penerimaan!';
		$getdt = "select * from $this->TblName where id = '$id' ";		
		$row = mysql_fetch_array( mysql_query($getdt));	
		$tgl_buku = $row['tgl_buku'];
		$c1 = $row['c1'];
		$c = $row['c'];
		$d = $row['d'];
		//$err='tglclosing='.getTglClosing($c,$d,'00','000',$c1);
		if($err=='' && sudahClosing($tgl_buku,$c,$d,'00','000',$c1))$err = 'Tanggal sudah Closing !';
				
		return $err;
	}
	
	
	function getStat(){
		$cek=''; $err=''; $content='';
		//global $Main;
		$cbid = $_POST[$this->Prefix.'_cb'];
		$id = $cbid[0];		
		$aqry = "select * from $this->TblName where id='$id' ";
		$isi = mysql_fetch_array(mysql_query($aqry));
		$content->stat = $isi['stat'];
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);					
	}	
	
	
	function getPengadaanSebelumnya($tahun, $c, $d, $e ,$e1 , $f, $g, $h, $i, $j, $id=''){
		$idstr = $id==''? '' : " and id<>'$id' ";
		$aqry = "select sum(jml_barang) as tot from pengadaan where ".
				"tahun='$tahun'".
				" and c='$c' and d='$d' and e='$e'  and e1='$e1'  ".
				" and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' $idstr "; $cek.=$aqry;
		$get = mysql_fetch_array( mysql_query(
			$aqry
		));	
		if($get['tot']==NULL) $get['tot'] = 0;
		return $get['tot'];
	}
	function hitPengadaanSebelumnya(){
		$cek=''; $err=''; $content='';
		$tahun = $_REQUEST['tahun'];
		$c = $_REQUEST['c'];		
		$d = $_REQUEST['d'];		
		$e = $_REQUEST['e'];	
		$e1 = $_REQUEST['e1'];	
		$fmIDBARANG = $_REQUEST['kdbrg'];		
		$f = $fmIDBARANG['0'].$fmIDBARANG['1'];
		$g = $fmIDBARANG['3'].$fmIDBARANG['4'];
		$h = $fmIDBARANG['6'].$fmIDBARANG['7'];
		$i = $fmIDBARANG['9'].$fmIDBARANG['10'];
		$j = $fmIDBARANG['12'].$fmIDBARANG['13'].$fmIDBARANG['14'];	
		$id = $_REQUEST['id'];
		
		
		$content->jmlada = $this->getPengadaanSebelumnya( $tahun , $c, $d, $e ,$e1 , $f, $g, $h, $i, $j, $id);		
		$content->jmldkb = $this->getJmlDKB($tahun , $c, $d, $e ,$e1 , $f, $g, $h, $i, $j); 
		if($content->jmlada == NULL) $content->jmlada=0;
		if($content->jmldkb == NULL) $content->jmldkb =0;
		
		$content->jml = $content->jmldkb - $content->jmlada;
		$content->jmlsisa = 0;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);					
	}
	
	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){
			case 'formBaru2':{				
				//echo 'tes';
				$get=$this->setFormBaru();				
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];			
				break;
			}
			case 'formEdit2':{								
				$get=$this->setFormEdit();				
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];				
				break;
			}
			case 'simpan2' : {
				$get = $this->simpan2();
				$cek = $get['cek']; 
				$err = $get['err']; 
				$content=$get['content']; 
				break;
			}
			case 'getJmlBrgBI':{
				$get = $this->getJmlBrgBI();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 
				break;
			}
			case 'formDKB':{
				$get = $this->setFormDKB();
				$json = FALSE;
				break;
			}
			case 'simpanDKB' : {
				$get = $this->simpanDKB();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 
				break;
			}
			case 'getsat': {
				$get = $this->getStat();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 
				break;
			}	
			case 'hitPengadaanSebelumnya':{
				$get = $this->hitPengadaanSebelumnya();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 				
				break;
			}
			case 'UrusanAfter':{
				$content->fmSKPDBidang= $this->cmbQueryBidang('fmSKPDBidang',$fmSKPDBidang,'','','--- Pilih Bidang ---','00');
				$content->fmSKPDskpd= $this->cmbQuerySKPD('fmSKPDskpd',$fmSKPDskpd,'','','--- Pilih Skpd ---','00');
				$fmSKPDUrusan = cekPOST('fmSKPDUrusan');
				setcookie('cofmURUSAN',$fmSKPDUrusan);
				setcookie('cofmSKPD','00');
				setcookie('cofmUNIT','00');
				setcookie('cofmSUBUNIT','00');
				setcookie('cofmSEKSI','000');
			break;
		    }
			case 'BidangAfter':{
				$content= $this->cmbQuerySKPD('fmSKPDskpd',$fmSKPDskpd,'','','--- Pilih Skpd ---','00');
				$fmSKPDBidang = cekPOST('fmSKPDBidang');
				setcookie('cofmURUSAN',$fmSKPDUrusan);
				setcookie('cofmSKPD',$fmSKPDBidang);
				setcookie('cofmUNIT','00');
				setcookie('cofmSUBUNIT','00');
				setcookie('cofmSEKSI','000');
			break;
		    }
			case 'SKPDAfter':{
				$fmSKPDBidang = cekPOST('fmSKPDBidang');
				$fmSKPDskpd = cekPOST('fmSKPDskpd');
				setcookie('cofmSKPD',$fmSKPDBidang);
				setcookie('cofmUNIT',$fmSKPDskpd);
				setcookie('cofmSUBUNIT','00');
				setcookie('cofmSUBUNIT','000');
			break;
		    }
			case 'UnitRefresh':{
				$fmc = cekPOST('c');
				$fmd = cekPOST('d');
				$fme = cekPOST('fmSKPDUnit_form');
				$ref_iddkb = cekPOST('ref_iddkb');
				
				$editunit= $fmc != '' ? $fmc.".".$fmd:'';
				if($ref_iddkb != ''){
					$content=$this->cmbQueryUnit('fmSKPDUnit_form',$fme,'','','--- Pilih Unit ---','00',TRUE,$editunit);	
				}else{
					$content=$this->cmbQueryUnit('fmSKPDUnit_form',$fme,'','','--- Pilih Unit ---','00',FALSE,$editunit);
				}
				
			break;
		    }
			case 'UnitAfter':{
			//$fmSKPDUnit = cekPOST('fmSKPDUnit_form');
			//setcookie('cofmSUBUNIT',$fmSKPDUnit);
			$ref_iddkb = cekPOST('ref_iddkb');
			$fme1 = cekPOST('fmSKPDSubUnit_form');
			if($ref_iddkb != ''){
					$content= $this->cmbQuerySubUnit('fmSKPDSubUnit_form',$fme1,'','','--- Pilih Sub Unit ---','000',TRUE);	
				}else{
					$content= $this->cmbQuerySubUnit('fmSKPDSubUnit_form',$fme1,'','','--- Pilih Sub Unit ---','000',FALSE);
				}
			
			break;
		    }	
			/*case 'hitungSisa': {
				$get = $this->hitungSisa();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 
				break;
			}*/			
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		$fmURUSAN = cekPOST('fmSKPDUrusan');
		$fmSKPD = cekPOST('fmSKPDBidang'); //echo 'fmskpd='.$fmSKPD;
		$fmUNIT = cekPOST('fmSKPDskpd');
		$fmSUBUNIT = '00';
		$fmSEKSI = '000';
		$vskpd = $Main->URUSAN ==1 ? PrintSKPD2_urusan($fmURUSAN,$fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI) : PrintSKPD2($fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI);
		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>	
			<table width=\"100%\" border=\"0\">
				<tr>
					<td class=\"subjudulcetak\">".$vskpd."</td>
				</tr>
			</table><br>";
	}
}
$pemusnahanba = new pemusnahanbaObj();

?>