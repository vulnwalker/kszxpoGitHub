<?php

include "pages/pencarian/DataPengaturan.php";
$DataOption = $DataPengaturan->DataOption();

class jurnal_keuanganObj  extends DaftarObj2{	
	var $Prefix = 'jurnal_keuangan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
//	var $TblName = 'v1_jurnal_keuangan2'; //bonus
//	var $TblName_Hapus = 'v1_jurnal_keuangan2';
	var $TblName = 'v1_jurnal_keuangan'; //bonus
	var $TblName_Hapus = 'v1_jurnal_keuangan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Data Jurnal Keuangan';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'JURNAL';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'jurnal_keuanganForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
//	var $pid='';
//	var $no_urut=0;
//	var $noakhirnya = 1; 
	
	var $pid='';
	var $no_urut=0;
	var $noakhirnya = 1;
	var $totalDebet=0; 
	var $totalKredit=0; 
	var $totalAnggaran=0; 
	
	function setTitle(){
		return 'JURNAL KEUANGAN ';
	}
	
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
	}
	
	function setPage_Header(){		
		return createHeaderPage($this->PageIcon, $this->PageTitle,  
			'', FALSE, 'pageheader', $this->ico_width, $this->ico_height
		);
	}
	
	function setNavAtas(){
		global $Menu;
		if($Menu) {
		return '';
		}
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
	  
		case 'cek_proses':{
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$qrydel1 = "DELETE FROM t_jurnal_keuangan_det WHERE status='1' and refid_jurnal='$idplh' ";
		$aqrydel1 = mysql_query($qrydel1);
		
			$get= $this->TampilRekening();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];								
			break;
	    }
		
		case 'hapus':{ //untuk ref_pegawai
					$idplh= $_REQUEST['Id'];		
					$get= $this->Hapus();
					$err= $get['err']; 
					$cek = $get['cek'];
					$json=TRUE;	
					break;
		}
		
		case 'formEdit':{				
			$fm = $this->setFormEdit();				
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
   
  function Hapus($ids){ //validasi hapus ref_pegawai
		 $err=''; $cek=''; $content=''; $json=TRUE;
		for($i = 0; $i<count($ids); $i++)	{
		
			$qry = "SELECT * FROM v1_jurnal_keuangan WHERE Id='".$ids[$i]."' ";
			$aqry = mysql_query($qry);
			$dt = mysql_fetch_array($aqry);
			
			if($err == '' && $dt['st_pilih'] == '0'){
				$err = "Data Tidak dapat Dihapus !!";
				break;
			}
			
			if($err=='' ){
				
				
				//	while($DataHapusJurnalDet = mysql_fetch_array(mysql_query("select * from t_jurnal_keuangan_det where refid_jurnal='".$ids[$i]."'"))){
				//	$cek.="select * from t_jurnal_keuangan_det where refid_jurnal ='".$ids[$i]."'";					
					$HapusJurnalDet = mysql_query("delete from t_jurnal_keuangan_det where refid_jurnal ='".$ids[$i]."'");
					
				//	}
					$HapusJurnal = mysql_query("delete from t_jurnal_keuangan where Id ='".$ids[$i]."'");	
			}			
		}
		return array('err'=>$err,'cek'=>$cek);
	}
	
	
	function setPage_OtherScript(){
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
							//document.getElementById('".$this->Prefix."_cont_skpd').innerHTML='<div id=\"skpd_penerimaan\"></div>';
							//skpd_penerimaan.initial();
						});
					</script>";
		return 	
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<script src='js/jquery-ui.custom.js'></script>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>".
			"<script src='js/jquery.js' type='text/javascript'></script>".			
			"<script src='js/jquery-ui.js' type='text/javascript'></script>".
			"<script src='js/jquery.min.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/jquery.form.js'></script> ".
			"<link rel='stylesheet' href='css/upload_style.css' type='text/css'>".		
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".	
			
			"<script type='text/javascript' src='js/jurnal_keuangan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			
		//	"<script type='text/javascript' src='js/jurnal_keuangan/jurnal_keuangan_ins.js' language='JavaScript' ></script>".
		//	"<script type='text/javascript' src='js/master/ref_jurnal_keuangan/jurnalkeuangandetail.js' language='JavaScript' ></script>".
			'
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>
			'.
			$scriptload;
	}
	
	//form ==================================
	function setFormBaru(){
		global $HTTP_COOKIE_VARS;
		if(isset($HTTP_COOKIE_VARS['coThnAnggaran'])){
		 	$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		 }else{
		 	$coThnAnggaran = '2016';
		 }
		 
		$dt=array();
		$this->form_fmST = 0;
		$uid = $HTTP_COOKIE_VARS['coID'];
		$this->form_idplh =$dt['id'];
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
   
  	function setFormEdit(){
		$cek = '';
		$err = '';
		$content = '';
			
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$idplh = $cbid[0];			
		//get data 
		$aqry = "SELECT * FROM  v1_jurnal_keuangan WHERE Id='$idplh' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
	
		if($dt['st_pilih']==0)$err = "Data Tidak Bisa Diubah !!";
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	
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
  	   <th class='th01' rowspan=2 width='30'>No.</th>
  	   $Checkbox		
	
	   <th class='th01' align='center' width='70'>TANGGAL</th>
	   <th class='th01' align='center' width='70'>NO BUKTI</th>
	   <th class='th01' align='center' width='20'>BKU</th>
	   <th class='th01' align='center' width='100'>REFERENSI</th>
	   <th class='th01' align='center' width='200'>JURNAL</th> 
	   <th class='th01' align='center' width='70'>KODE AKUN</th>
	   <th class='th01' align='center' width='500'>NAMA AKUN</th>
	   <th class='th01' align='center' width='100'>DEBET</th>
	   <th class='th01' align='center' width='100'>KREDIT</th>  
	   <th class='th01' align='center' width='100'>KETERANGAN /<br> SKPD</th>
	   <th class='th01' align='center' width='50'>STATUS</th>
	   </tr>
	   </thead>";
		return $headerTable;
	}
		
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	global $Ref, $DataOption, $DataPengaturan;
	
	if($isi['status']==0){
		$file = 'OK';
	}else{
		$file = "<font color='red'>PROSES</font>";
	}	
	
	$j1=mysql_fetch_array(mysql_query("select * from t_jurnal_keuangan_det"));
	$j2=mysql_fetch_array(mysql_query("select sum(debet) as debet from t_jurnal_keuangan_det where c1='".$j1['c1']."' and c='".$j1['c']."' and d='".$j1['d']."' and e='".$j1['e']."' and e1='".$j1['e1']."' and status='0'"));	
	 
	 $tgl_bukti = explode("-",$isi['tgl_bukti']);
	 $tgl_bukti_sumber = $tgl_bukti[2]."-".$tgl_bukti[1]."-".$tgl_bukti[0];

	 if($isi['status']==0){
		$file = 'OK';
	}else{
		$file = "<font color='red'>PROSES</font>";
	}
	 
	  if($this->pid <> $isi['Id']){
	  	if ($this->no_urut==0){
			$this->no_urut=$no;
		
		}else{
			$this->no_urut++;
		}
		$kd_skpd=$isi['c1'].'.'.$isi['c'].'.'.$isi['d'].'.'.$isi['e'].'.'.$isi['e1']; 
		$no_bku=$isi['no_bku']; 
	  	$no_pilih=$this->no_urut;
	 	$tgl_bukti_sumber2 = $tgl_bukti_sumber;
		$no_bukti = $isi['no_bukti'];
		$nm_jns_jurnal = $isi['nm_jns_jurnal'];
		$no_referensi = $isi['no_referensi'];
		$keterangan = $isi['keterangan'];
		$TampilCheckBox = $TampilCheckBox;
		$file = $file;
	 }else{
	 	$kd_skpd=''; 
	 	$no_bku=''; 
	 	$kd_skpd=''; 
	 	$tgl_bukti_sumber2 = '';
		$no_pilih='';
		$no_bukti = '';
		$nm_jns_jurnal ='';
		$keterangan ='';
		$no_referensi='';
		$TampilCheckBox = '';
		$file = '';
	 }
	 
	 
	 if($isi['debetkredit']==0){
				$margin = '';
			}else{
				$margin =  'style="margin-left:20px;"';
			}
	
	if ($isi['kd']=='' && $isi['kd']==''){
	 	$newkdd = '';
	 	$newkee = '';
	 }else{
	 	$newkdd = sprintf("%02s",$isi['kd']);
	 	$newkee = sprintf("%02s",$isi['ke']);
	 }	
	 
	 
	 
	//  $Koloms[] = array('align="left"',"<span $margin>".$isi['nm_account']."</span>");
	 
	 $Koloms.= "<td class='$cssclass' align='center'>$no_pilih</td>";
		if($Mode == 1)$Koloms.= "<td class='$cssclass' align='center'>$TampilCheckBox</td>";
	//	$Koloms.= "<td class='$cssclass' align='center'>".$kd_skpd."</td>";
		$Koloms.= "<td class='$cssclass' align='center'>".$tgl_bukti_sumber2."</td>";
	 	$Koloms.= "<td class='$cssclass' align='left' width='5%'>".$no_bukti."</td>";
		$Koloms.= "<td class='$cssclass' align='center'>".$no_bku."</td>";
	 	$Koloms.= "<td class='$cssclass' align='left' width='5%'>".$no_referensi."</td>";
		$Koloms.= "<td class='$cssclass' align='left'>".$nm_jns_jurnal."</td>";
	 	$Koloms.= "<td class='$cssclass' align='left'>".$isi['ka'].'.'.$isi['kb'].'.'.$isi['kc'].'.'.$newkdd.'.'.$newkee."</td>";
	 	$Koloms.= "<td class='$cssclass' align='left' width='30%'><span $margin>".$isi['nm_account']."</span></td>";
	 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($isi['debet'],2, ',', '.')."</td>";
		$Koloms.= "<td class='$cssclass' align='right'>".number_format($isi['kredit'],2, ',', '.')."</td>";
	//	$Koloms.= "<td class='$cssclass' align='left'>".$nm_jns_jurnal."</td>";
		$Koloms.= "<td class='$cssclass' align='left'>".$keterangan.'<br>'.$kd_skpd."</td>";
		$Koloms.= "<td class='$cssclass' align='center'>".$file."</td>";
		
	
 		$Koloms.= "</tr>";
	if($isi['Id']!=$this->pid){
	$this->jml_dat=0;
			
		$jml_saldo=mysql_fetch_array(mysql_query(" select count(*) as cnt from v1_jurnal_keuangan where Id='".$isi['Id']."'"));
		$this->jml_dat=$jml_saldo['cnt'];
		$this->jml_dat_urut=1;
	}else{
		$this->jml_dat_urut++;
	}
	
	 if ($this->jml_dat_urut==$this->jml_dat){
	 $jml_debet=mysql_fetch_array(mysql_query("SELECT SUM(debet) as debet FROM t_jurnal_keuangan_det WHERE refid_jurnal='".$isi['Id']."' "));
	 $jml_kredit=mysql_fetch_array(mysql_query("SELECT SUM(kredit) as kredit FROM t_jurnal_keuangan_det WHERE refid_jurnal='".$isi['Id']."' "));
	 	 $Koloms.= "<td class='$cssclass' align='right'></td>";
		  if($Mode == 1)$Koloms.= "<td class='$cssclass' align='right'></td>";
		  $Koloms.= "<td class='$cssclass' align='right' colspan='7'><b>SUB TOTAL</b></td>";
		  $Koloms.= "<td class='$cssclass' align='right'><b>".number_format($jml_debet['debet'],2,',','.')."</b></td>";
		  $Koloms.= "<td class='$cssclass' align='right'><b>".number_format($jml_kredit['kredit'],2,',','.')."</b></td>";
		  $Koloms.= "<td class='GarisDaftar' align='right'></td>";
		  $Koloms.= "<td class='GarisDaftar' align='right'></td>";
	$Koloms.= "</tr>";
	 }
	
	$this->totalDebet+=$jml_debet['debet'];
	$this->totalKredit+=$jml_kredit['kredit'];
	
	 $Koloms = array(
	 	array("Y", $Koloms),
	 );
	
	  $this->pid = $isi['Id'];  
	  return $Koloms;
	}
	
	function genDaftar($Kondisi='', $Order='', $Limit='', $noAwal = 0, $Mode=1, $vKondisi_old=''){
		$cek =''; $err='';
		$MaxFlush=$this->MaxFlush;		
		$headerTable = $this->genDaftarHeader($Mode);		
		$TblStyle =	$this->TblStyle[$Mode-1];//$Mode ==1 ? 'koptable': 'cetak';
		$ListData = 
			"<table class='$TblStyle' border='1'   style='margin:4 0 0 0;width:100%'>".
			$headerTable.
			"<tbody>";
				
		$ColStyle = $this->ColStyle[$Mode-1];//$Mode==1? 'GarisDaftar':'GariCetak';			
		$no=$noAwal; $cb=0; $jmlDataPage =0;
		$TotalHalRp = 0;
		
		$aqry = $this->setDaftar_query($Kondisi, $Order, $Limit); $cek .= $aqry.'<br>';
		$tuk_Kondisi = $Kondisi;
		$qry = mysql_query($aqry);
		$numrows = mysql_num_rows($qry); $cek.= " jmlrow = $numrows ";
		if( $numrows> 0 ) {
					
		while ( $isi=mysql_fetch_array($qry)){
			if ( $isi[$this->KeyFields[0]] != '' ){
				$isi = array_map('utf8_encode', $isi);	
				
				$no++;
				$jmlDataPage++;
				if($Mode == 1) $RowAtr = $no % 2 == 1? "class='row0'" : "class='row1'";
				
				$KeyValue = array();
				for ($i=0; $i< sizeof($this->KeyFields) ; $i++) {
					$KeyValue[$i] = $isi[$this->KeyFields[$i]];
				}
				$KeyValueStr = join($this->pemisahID,$KeyValue);
				$TampilCheckBox =  $this->setCekBox($cb, $KeyValueStr, $isi);//$Cetak? '' : 
					
				//sum halaman
				for ($i=0; $i< sizeof($this->FieldSum) ; $i++) {
					$this->SumValue[$i] += $isi[$this->FieldSum[$i]];
				}
				
				//---------------------------
				$rowatr_ = $RowAtr." valign='top' id='$cb' value='".$isi['Id']."'";
				$bef= $this->setDaftar_before_getrow(
						$no,$isi,$Mode, $TampilCheckBox,  
						$rowatr_,
						$ColStyle
						);
				$ListData .= $bef['ListData'];
				$no = $bef['no'];
				//get row
				$Koloms = $this->setKolomData($no,$isi,$Mode, $TampilCheckBox);	$cek .= $Koloms;		
				
				if($Koloms != NULL){
					
				
					$list_row = genTableRow($Koloms, 
								$rowatr_,
								$ColStyle);		
					
					
					$ListData .= $this->setDaftar_after_getrow($list_row, $isi , $no, $Mode, $TampilCheckBox,
						$RowAtr, $ColStyle);
					
					$cb++;
					
					if( ($Mode == 3 ) && ($cb % $MaxFlush==0) && $cb >0 ){				
						echo $ListData;
						ob_flush();
						flush();
						$ListData='';
						//sleep(2); //tes
					}
				}
			}
		}
		
		}
		
		$ListData .= $this->setDaftar_After($no, $ColStyle);
		//total -----------------------		
		if ($Mode==3) {	//flush
			echo $ListData;
			ob_flush();
			flush();
			$ListData='';			
			$SumHal = $this->genSumHal($Kondisi); 			
		}
		//$SumHal = $this->genSumHal($Kondisi);
		$ContentSum = $this->genRowSum($ColStyle,  $Mode, 
			$SumHal['sums']
		);
				
		$ListData .= 
				$this->GrandTotal($Mode,$tuk_Kondisi).
				$ContentSum.
				"</tbody>".
			"</table>				
			<input type='hidden' id='".$this->Prefix."_jmldatapage' name='".$this->Prefix."_jmldatapage' value='$jmlDataPage'>
			<input type='hidden' id='".$this->Prefix."_jmlcek' name='".$this->Prefix."_jmlcek' value=''>"
			.$vKondisi_old
			;
		if ($Mode==3) {	//flush
			echo $ListData;	
		}
					
		return array('cek'=>$cek,'content'=>$ListData, 'err'=>$err);
	}
	
	function GrandTotal($Mode=1,$tuk_Kondisi=''){
		global $DataPengaturan;
		$Koloms='';
		
		$cols=9;
		if($Mode == 1)$cols=9;
		
		$Koloms.= "<tr class='row0'><td class='GarisDaftar' align='center' colspan='$cols'><b>TOTAL PER HALAMAN </b></td>";
		$Koloms.= "<td class='GarisDaftar' align='right'><b>".number_format($this->totalDebet,2,',','.')."</b></td>";
		$Koloms.= "<td class='GarisDaftar' align='right'><b>".number_format($this->totalKredit,2,',','.')."</b></td>";
		$Koloms.= "<td class='GarisDaftar' align='right'></td>";
		$Koloms.= "<td class='GarisDaftar' align='right'></td>";
	 	$Koloms.= "</tr>";
		
		//Grand Total Semua Halaman -------------------------------------------------------------------------
		
		$qry = $DataPengaturan->QyrTmpl1Brs("v1_jurnal_keuangan", " IFNULL(SUM(debet),0) as jml_debet, IFNULL(SUM(kredit),0) as jml_kredit", $tuk_Kondisi);
		$dt=$qry["hasil"];
		$jml_debet=$dt['jml_debet'];
		
		$Koloms.= "<tr class='row1'><td class='GarisDaftar' align='center' colspan='$cols'><b>TOTAL</b></td>";
		$Koloms.= "<td class='GarisDaftar' align='right'><b>".number_format($jml_debet,2,',','.')."</b></td>";
		$Koloms.= "<td class='GarisDaftar' align='right'><b>".number_format($dt['jml_kredit'],2,',','.')."</b></td>";
		$Koloms.= "<td class='GarisDaftar' align='right'></td>";
		$Koloms.= "<td class='GarisDaftar' align='right'></td>";
	 	$Koloms.= "</tr>";
		
		return $Koloms;
	}
	
	function genDaftarInitial(){
		global $HTTP_COOKIE_VARS;
		$TampilOpt = $this->genDaftarOpsi();
		
		if($HTTP_COOKIE_VARS['coSKPD']=='00'){
			$skpd=$HTTP_COOKIE_VARS['cofmSKPD'];
			$unit=$HTTP_COOKIE_VARS['cofmUNIT'];
			$subunit=$HTTP_COOKIE_VARS['cofmSUBUNIT'];
		}
		else{
			$skpd=$HTTP_COOKIE_VARS['coSKPD'];
			$unit=$HTTP_COOKIE_VARS['coUNIT'];
			$subunit=$HTTP_COOKIE_VARS['coSUBUNIT'];
		}
		
		return		
			//$NavAtas.	
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_skpd' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 
			//$vOpsi['TampilOpt'].
			"<input type='hidden' id='thn' name='thn' value='".date('Y')."'>".
			"<input type='hidden' id='bln' name='bln' value='".date('m')."'>".
			"<input type='hidden' id='skpd_penerimaanfmBidang' name='skpd_penerimaanfmBidang' value='".$skpd."'>".
			"<input type='hidden' id='skpd_penerimaanfmBagian' name='skpd_penerimaanfmBagian' value='".$unit."'>".
			"<input type='hidden' id='skpd_penerimaanfmSubBagian' name='skpd_penerimaanfmSubBagian' value='".$subunit."'>".
			"</div>".					
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".									
			"</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
			"</div>";
	}
	
	function genDaftarOpsi($Mode=1){
	global $Main, $HTTP_COOKIE_VARS;
	$fmFiltStatus = cekPOST('fmFiltStatus');
	$JnsKontrak = cekPOST('jns_jurnal'); 
	 $fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
	 $fmJnsJurnal = $_REQUEST['fmJnsJurnal'];
	 $arrStatus = array(	
			array('1','1. OK'),	
			array('2','2. PROSES'),		
			);
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	$queryJnsJurnal = "SELECT nm_jns_jurnal,nm_jns_jurnal FROM ref_jns_jurnal Order By  Id asc";
	
	$TampilOpt = 
	"<tr><td>".
			$vOrder=
			genFilterBar(array(WilSKPD_ajx3($this->Prefix.'SKPD')),'','','').
			genFilterBar(
				array(
				"Cari Jenis Jurnal : ".cmbQuery('fmJnsJurnal',$fmJnsJurnal,$queryJnsJurnal,'style=width:250px;','--PILIH--')."&nbsp
&nbsp"							
					.cmbArray('fmFiltStatus',$fmFiltStatus,$arrStatus,'-- Status --',''). //generate checkbox					
					""
					
					),			
				$this->Prefix.".refreshList(true)");
			"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>";
			
		return array('TampilOpt'=>$TampilOpt);
	}		
	
	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
			
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		$fmFiltStatus = cekPOST('fmFiltStatus');
		$JnsKontrak = cekPOST('jns_jurnal'); 
		$fmLimit = $_REQUEST['baris'];
		$this->pagePerHal=$fmLimit;
		
		
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		$c1 = $_COOKIE['cofmURUSAN'];
		$c = $_COOKIE['cofmSKPD'];
		$d = $_COOKIE['cofmUNIT'];
		$e = $_COOKIE['cofmSUBUNIT'];
		$e1 = $_COOKIE['cofmSEKSI'];
		/*$c1=$_REQUEST['jurnal_keuanganSKPDfmURUSAN'];
		$c=$_REQUEST['jurnal_keuanganSKPDfmSKPD'];
		$d=$_REQUEST['jurnal_keuanganSKPDfmUNIT'];
		$e=$_REQUEST['jurnal_keuanganSKPDfmSUBUNIT'];
		$e1=$_REQUEST['jurnal_keuanganSKPDfmSEKSI'];*/
		$fmJnsJurnal = $_REQUEST['fmJnsJurnal'];
				
		if($c1 != '' && $c1 != '00')$arrKondisi[] = "c1='$c1'";
		if($c != '' && $c != '00')$arrKondisi[] = "c='$c'";
		if($d != '' && $d != '00')$arrKondisi[] = "d='$d'";
		if($e != '' && $e != '00')$arrKondisi[] = "e='$e'";
		if($e1 != '' && $e1 != '000')$arrKondisi[] = "e1='$e1'";
		
		switch($fmFiltStatus){
			case "1" :$arrKondisi[] = "status ='0'";	break;
			case "2" :$arrKondisi[] = "status ='3'";	break;
		}
	
		if(!empty($_POST['fmJnsJurnal']) ) $arrKondisi[] = " nm_jns_jurnal like '%".$_POST['fmJnsJurnal']."%'";
	//	if($JnsKontrak != '')$arrKondisi[] = "nm_jns_jurnal like '%$JnsKontrak%'";
		
		$fmPILCARI = $_REQUEST['fmPILCARI'];
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		$arrOrders[] = " no_bku,tgl_bukti,debetkredit asc $Asc1 ";
	//	$arrOrders[] = " tgl_bukti,debetkredit asc $Asc1 ";
		if(empty($fmORDER1)){ 
		//	$arrOrders[] = " tgl_ba desc $Asc1 ";
		}
		
		switch($fmORDER1){
			case '1': $arrOrders[] = " nip $Asc1 " ;break;
			case '2': $arrOrders[] = " nama $Asc1 " ;break;
		}	
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
	}
}
$jurnal_keuangan = new jurnal_keuanganObj();
?>