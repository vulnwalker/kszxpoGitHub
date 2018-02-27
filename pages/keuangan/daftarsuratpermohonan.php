<?php
include "pages/pencarian/DataPengaturan.php";
$DataOption = $DataPengaturan->DataOption();

class daftarsuratpermohonanObj  extends DaftarObj2{	
	var $Prefix = 'daftarsuratpermohonan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName			 = 'v1_spp'; //bonus
	var $TblName_Hapus 		 = 't_spp';	
	
	var $TblName_N			 = 't_spp'; 
	var $TblName_Dokumen	 = 't_spp_kelengkapan_dok'; 
	var $TblName_Rekening	 = 't_spp_rekening'; 
	var $TblName_NomorSPD	 = 't_nomor_spd'; 
	var $TblName_NomorSPD_det= 't_nomor_spd_det'; 
	
	var $TblName_BKU= 't_bku'; 
	
	var $View_SPP = "v1_spp";
	var $View_SPPRek = "v1_spp_rek";
	var $View_SPPRek2 = "v1_spp_rek2";
	var $View_SPPPotongan = "v1_spp_potongan";
	var $View_NomorSPD_det = "v1_nomor_spd_det";
	var $View_PotonganSPM = "v1_ref_potongan_spm";
	var $View_PotonganSPMRek = "v1_ref_potongan_spm_rek";
	
	var $View_SPP_Total = "v1_spp_total_semua";
	var $View_SPP_Total_Rek = "v1_spp_total_rekening";
	var $View_SPP_Total_Pot = "v1_spp_total_potongan";
	
	//Tabel Dari Penerimaan --------------------------------------------------
	var $TblName_Terima 	= 't_penerimaan_barang'; 
	var $TblName_Terima_det = 't_penerimaan_barang_det';
	var $TblName_Terima_rek = 't_penerimaan_rekening';
	//------------------------------------------------------------------------
	
	//Tabel Refrensi
	var $Tbl_Ref_KDok = "ref_kelengkapan_dokumen";
	
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'SURAT PERMOHONAN';
	var $PageIcon = 'images/order1.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='daftarsuratpermohonan.xls';
	var $namaModulCetak='SURAT PERMOHONAN';
	var $Cetak_Judul = 'daftarsuratpermohonan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'daftarsuratpermohonanForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	var $form_fields_Konten="";
	
	
	var $pid_urutan=0;
	var $pid_nomor=0;
	var $pid="";
	
	var $subTotal=0;
	var $subTotal_Rek=0;
	var $subTotal_Pot=0;
	var $TotalHargaPerhal=0;
	
	var $Total_Rekening = 0;
	var $Total_Potongan = 0;
	var $Total_Jumlah = 0;
	
	var $program = "";
	var $kegiatan="";
	
	var $halman="";
	
	var $arr_statusSPP = 
		array(
			"1" => "SPP",
			"2" => "VERIFIKASI<br>SPP",
			"3" => "BATAL SPP",
		);
	
	var $arr_statusSPP2 = 
		array(
			"1" => "SPP",
			"2" => "VERIFIKASI SPP",
			"3" => "SPM",
			"4" => "SP2D",
		); 
		
	var $arr_statusSPM = 
		array(
			"1" => "SPM",
			"2" => "VERIFIKASI SPM",
			"3" => "BATAL SPM",
		);
						
	var $arr_statusSP2D = 
		array(
			"1" => "SP2D",
			"2" => "BATAL SP2D",
			"3" => "PENGUJI SP2D",
			"4" => "PENCAIRAN",
		);
	
	function setTitle(){
		$hal = cekPOST2("hal");
		$jns = cekPOST2("jns_spp");
		switch($jns){
			case "2":$Ket="UP";break;
			case "3":$Ket="GU";break;
			case "4":$Ket="TU";break;
			default :$Ket="LS";break;
		}
		
		switch($hal){
			case "2":$daf="VERIVIKASI SPP-";break;
			case "3":$daf="SPM-";break;
			case "4":$daf="SP2D-";break;
			default :$daf="SPP-";break;
		}
		return 'DAFTAR '.$daf.$Ket;
	}
	
	function StyleMenuEdit($val){
		return "<span style='font-size:7px'> $val </span>";
	}
	
	function setMenuEdit(){
		$data = "";
		$stat = TRUE;
		$hal = cekPOST2("hal");
		if($hal != "")$stat=FALSE;
		
		if($stat == TRUE || $hal==1)$data.="<td>".genPanelIcon("javascript:".$this->Prefix.".BaruSPP()","spp.png","SPP", 'SPP')."</td>";
		if($stat == TRUE || $hal==2)$data.= "<td>".genPanelIcon("javascript:".$this->Prefix.".VerivikasiSPP()","verifikasi_spp.png",$this->StyleMenuEdit('VERIFIKASI<br>SPP'), 'VERIFIKASI SPP')."</td>";
		if($stat == TRUE || $hal==3)$data.= "<td>".genPanelIcon("javascript:".$this->Prefix.".BaruSPM()","spm.png","SPM", 'SPM')."</td>";
		//if($stat == TRUE || $hal==4)$data.= "<td>".genPanelIcon("javascript:".$this->Prefix.".VerivikasiSPM()","verifikasi_spm.png",$this->StyleMenuEdit('VERIFIKASI<br>SPM'), 'VERIFIKASI SPM')."</td>";
		if($stat == TRUE || $hal==4)$data.= "<td>".genPanelIcon("javascript:".$this->Prefix.".BaruSP2D()","spd.png","SP2D", 'SP2D')."</td>";	
		if($stat == TRUE || $hal==1)$data.="<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
		
		return $data;
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
	  
	 if( $err=='' && $nama =='' ) $err= 'daftarsuratpermohonan Belum Di Isi !!';
	 
			if($fmST == 0){
				if($err==''){
					$aqry = "INSERT into ref_daftarsuratpermohonan (nama)values('$nama')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{						
				if($err==''){
				$aqry = "UPDATE ref_daftarsuratpermohonan set nama='$nama' WHERE nama='".$idplh."'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());
					}
			} //end else
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function setPage_Content(){
		global $DataPengaturan;
		//return "<div id='".$this->Prefix."_pagecontent'></div>";
		$jns = cekPOST2("jns");
		switch($jns){
			case "UP":$Ket="2";break;
			case "GU":$Ket="3";break;
			case "TU":$Ket="4";break;
			default :$Ket="1";break;
		}
		
		return 
			InputTypeHidden("hal",cekPOST2("hal",1)).
			InputTypeHidden("jns_spp",$Ket).
			$this->genDaftarInitial();
		
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
		case 'simpan'					 		: $fm = $this->simpan();break;
		case 'PengecekanUbahSPP'		 		: $fm = $this->PengecekanUbahSPP();break;
		case 'BaruNamaPejabat'		 	 		: $fm = $this->BaruNamaPejabat();break;
		case 'SimpanNamaPejabat'		 		: $fm = $this->SimpanNamaPejabat();break;
		case 'View_FormSPP'		 		 		: $fm = $this->View_FormSPP();break;
		case 'PengecekanUbahSPM'		 		: $fm = $this->PengecekanUbahSPM();break;
		case 'PengecekanUbahS2D'		 		: $fm = $this->PengecekanUbahS2D();break;
		case 'VerivikasiRekSPM'		 			: $fm = $this->VerivikasiRekSPM();break;
		//LS
		case 'formVerivikasiSPP'		 		: $fm = $this->formVerivikasiSPP();break;
		case 'formVerivikasiSPP_KelengkapanDok' : $fm = $this->formVerivikasiSPP_KelengkapanDok();break;
		case 'SetDokumenSPP' 					: $fm = $this->SetDokumenSPP();break;
		case 'SimpanVerivikasiSPP' 				: $fm = $this->SimpanVerivikasiSPP();break;
		case 'BatalVerivikasiSPP' 				: $fm = $this->BatalVerivikasiSPP();break;
		case 'Lihat_formVerivikasiSPP' 			: $fm = $this->Lihat_formVerivikasiSPP();break;
	   
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
			fn_TagScript("js/skpd.js").
			fn_TagScript("js/keuangan/suratpermohonan_spp.js").
			fn_TagScript("js/keuangan/".strtolower($this->Prefix).".js").
			$DataPengaturan->Gen_Script_DatePicker().
			$scriptload;
	}
	
	//form ==================================
	function View_FormSPP(){
		global $DataPengaturan;
		$cek='';$err='';$content='';
		$dt=array();
		
		$IdSPP = cekPOST2("IdSPP");
		$qry = $DataPengaturan->QyrTmpl1Brs("v1_penerimaan_spp","*", "WHERE Id='$IdSPP'	");$cek.=$qry['cek'];
		$dt = $qry["hasil"];
		
		
		if($err==''){
			$fm = $this->set_View_FormSPP($dt);
			$cek.=$fm['cek'];
			$err=$fm['err'];
			$content=$fm['content'];
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
		
	function set_View_FormSPP($dt){	
	 global $SensusTmp, $DataPengaturan;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 900;
	 $this->form_height = 500;
	 $this->form_caption = 'Surat Permohonan Pembayaran';
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
	
	 $DataTMPL = $DataPengaturan->GenViewSKPD3($dt);
	 array_push($DataTMPL,
	 	array(  'label'=>'<br>',
				'labelWidth'=>200, 
				'type'=>"merge", 
				'value'=>"<br>", 
			),
		array(  'label'=>'ID PENERIMAAN',
				'labelWidth'=>200, 
				'value'=>$dt["id_penerimaan"], 
			),
		array(  'label'=>'JENIS SPP',
				'labelWidth'=>200, 
				'value'=>$DataPengaturan->Daftar_arr_pencairan_dana[$dt['jns_spp']], 
			),
		array(  'label'=>'<br>',
				'labelWidth'=>200, 
				'type'=>"merge",
				'value'=>"<div id='tbl_rekening'></div>", 
			),
		array(  'label'=>'<br>',
				'labelWidth'=>200, 
				'type'=>"merge", 
				'value'=>"<br>", 
			),
		array(  'label'=>'PROGRAM',
				'labelWidth'=>200, 
				'value'=>$DataPengaturan->GetProgKeg2($dt['bk'],$dt['ck'],$dt['dk'],$dt['p']), 
			),
		array(  'label'=>'KEGIATAN',
				'labelWidth'=>200, 
				'value'=>$DataPengaturan->GetProgKeg2($dt['bk'],$dt['ck'],$dt['dk'],$dt['p'],$dt['q']), 
			),
		array(  'label'=>'PEKERJAAN',
				'labelWidth'=>200, 
				'value'=>$dt['pekerjaan'], 
			),
		array(  'label'=>'TANGGAL/ NOMOR KONTRAK',
				'labelWidth'=>200, 
				'value'=>FormatTanggalnya($dt['tgl_dok_kontrak'])."/ ".$dt['no_dok_kontrak'], 
			)
	 );
	 
	// ---- 
		
	 //items ----------------------
	  $this->form_fields = $DataTMPL;
	 //tombol
	  $this->form_menubawah =
	  		$DataPengaturan->InputHidden("refid_terima",$dt["refid_terima"]).
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function set_Href($val, $KetHal, $pil){
		return "<A href='pages.php?Pg=daftarsuratpermohonan&jns=".$val.$KetHal."' title='Surat Permohonan $val' $pil>$val</a>";
	}
	
	function setPage_HeaderOther(){

		$style="style='color:blue'";
			
		$jns = cekPOST2("jns", "LS");
		$pil1 = $jns == "UP"?$style:"";
		$pil2 = $jns == "GU"?$style:"";
		$pil3 = $jns == "TU"?$style:"";
		$pil4 = $jns == "LS"?$style:"";
		
		$hal = cekPOST2("hal");
		$KetHal=$hal!=""?"&hal=".$hal:"";	
	
	return 
		"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
			<tr>
				<td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
					".$this->set_Href("UP", $KetHal, $pil1)." | 
					".$this->set_Href("GU", $KetHal, $pil2)." | 
					".$this->set_Href("TU", $KetHal, $pil3)." | 
					".$this->set_Href("LS", $KetHal, $pil4)."					
					&nbsp &nbsp
				</td>
			</tr>
		</table>";
	}
	
	function genDaftar($Kondisi='', $Order='', $Limit='', $noAwal = 0, $Mode=1, $vKondisi_old=''){
		//$Mode -> 1. daftar, 2. cetak hal, 3.cetak all
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
		
		//$aqry = "select * from $this->TblName $Kondisi $Order $Limit ";	//echo $aqry;
		//$qry = mysql_query($aqry);
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
				//$ContentTotalHal.$ContentTotal.
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
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $BersihData = $this->BersihkanData();
	 $hal = cekPOST2("hal");
	 $data="<th class='th01' width='120'>JUMLAH</th>";
	 $this->halman=$hal;
	 if($hal > 2){
		$data =$hal == 4?"<th class='th01' width='120'>BANK PEMBAYAR</th>":"";
	 	$data.= 
			"<th class='th01' width='120'>JUMLAH SPM</th>".
			"<th class='th01' width='120'>POTONGAN</th>".
			"<th class='th01' width='120'>TOTAL BAYAR</th>";
	 }
	 	 
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' rowspan='2'>NO.</th>
  	   $Checkbox		
	   <th class='th01' width='60px' rowspan='2'>TANGGAL</th>
	   <th class='th01' width='40px'>NOMOR</th>
	   <th class='th01'>URAIAN</th>
	   $data
	   <th class='th01' width='80px'>STATUS</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}
	
	function setKolomData_DataSurat_GetStatus($dt){
		$status="";
		switch($dt["status"]){
			case "1":$status="SPP";break;
			case "2":$status=BtnText("VERIFIKASI<br>SPP",$this->Prefix.".Lihat_formVerivikasiSPP(".$dt["Id"].");", "style='color:black;'");break;
			case "3":$status="SPM";break;
			case "4":$status="SP2D";break;
		}
		
		return $status;
	}
	
	function set_KolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass){
		$Koloms="";
		
		$Koloms.=$this->pid_urutan%2==0?"<tr class='row0'>":"<tr class='row1'>";
		$Koloms.=$this->pid_nomor==0?Tbl_Td($no,"right",$cssclass):Tbl_Td("","right",$cssclass);			
		if($Mode == 1)$Koloms.=$this->pid_nomor==0?Tbl_Td($TampilCheckBox,"center",$cssclass):Tbl_Td("","right",$cssclass);			
		return $Koloms;
	}
	
	function setKolomData_RekSPP_Qry($isi){
		switch($isi["jns_spp"]){
			case "2":
				$qry = "SELECT * FROM $this->View_SPPRek2 WHERE refid_spp='".$isi["Id"]."' AND sttemp='0' ";
			break;
			default:
				$qry = "SELECT a.*, b.nomor_spd, b.tanggal_spd FROM $this->View_SPPRek a LEFT JOIN t_nomor_spd b ON a.refid_nomor_spd=b.Id WHERE a.refid_spp='".$isi["Id"]."' AND a.sttemp='0' ";
			break;
		}
		return $qry;
	}
	
	function setKolomData_RekSPP($no, $isi, $Mode, $TampilCheckBox, $cssclass){
	 global $Ref, $DataPengaturan;
	 $Koloms=""; 
	 
	 $hal = cekPOST2("hal");
	 
	 $qry_rek = $this->setKolomData_RekSPP_Qry($isi);
	 $aqry_rek = mysql_query($qry_rek);
	 $nonya= 0;
	 $this->pid_nomor=1;
	 while($dt = mysql_fetch_assoc($aqry_rek)){
	 	$Tgl = $nonya == 0?FormatTanggalnya($dt["tanggal_spd"]):"";
	 	$nomor = $nonya == 0?$dt["nomor_spd"]:"";
		
		$status = "";
		if($hal == "2"){
			$ceked = $dt["status_valid"] == "1"?"checked='checked' ":"";
			$status = InputTypeCheckbox("cb_valid_rek_".$dt["Id"], "OK", $ceked." onclick='".$this->Prefix.".VerivikasiRekSPM(".$dt["Id"].")'");
			
		}		
		if($isi["status"] > 1)$status="<img src='images/administrator/images/valid.png' width='20px' heigh='20px' />";
		$kdRekening = $DataPengaturan->Gen_valRekening($dt);
		
		$nomorBKU = BtnText(Format4Digit($isi['nomor_bku']), "", "style='color:black;' title='NOMOR BKU = ".Format4Digit($isi['nomor_bku'])."'");
		$NOBKU = $isi["jns_spp"]=="2" && $hal == "4"?$nomorBKU:"";
		
	 	$Koloms.=
			$this->set_KolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass).
			Tbl_Td("", "left",$cssclass).
			Tbl_Td($NOBKU, "left",$cssclass).
			Tbl_Td(LabelSPan1($nonya,$kdRekening.". ".$dt['nm_rekening'],"style='margin-left:5px;'"), "left",$cssclass);
		$Koloms.=$hal==4?Tbl_Td("", "right",$cssclass):"";
		$Koloms.=Tbl_Td(FormatUang($dt['jumlah']), "right",$cssclass);
		$Koloms.=$hal>2?Tbl_Td("", "right",$cssclass,2):"";
		$Koloms.=Tbl_Td($status, "center",$cssclass)."</tr>";
			 
		$this->pid_urutan++;
		$this->subTotal+=$dt['jumlah'];
		$this->subTotal_Rek+=$dt['jumlah'];
		$nonya++;
	 }
	 
	 
	 return $Koloms;
	}
	
	
	function setKolomData_SubTotal($no, $isi, $Mode, $TampilCheckBox, $cssclass){
		global $Ref, $DataPengaturan;
		$Koloms="";
		
		$hal = cekPOST2("hal");
		$cols = $hal == 4?4:3;		
				
	 	$Koloms.= $this->set_KolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass);
		$Koloms.=Tbl_Td("<b>SUB TOTAL</b>", "right",$cssclass." colspan='$cols' ");
		$Koloms.=Tbl_Td("<b>".FormatUang($this->subTotal_Rek)."</b>", "right",$cssclass);
		if($hal>2){
			$Koloms.=Tbl_Td("<b>".FormatUang($this->subTotal_Pot)."</b>", "right",$cssclass);
			$Koloms.=Tbl_Td("<b>".FormatUang($this->subTotal)."</b>", "right",$cssclass);
		}
		$Koloms.=Tbl_Td("", "center",$cssclass)."</tr>";
		$this->pid_urutan++;
		
		$this->Total_Rekening+=$this->subTotal_Rek;	
		$this->Total_Potongan+=$this->subTotal_Pot;
		$this->Total_Jumlah+=$this->subTotal;	
		
	 	return $Koloms;
	}
	
	function setKolomData_RekPotSPM($no, $isi, $Mode, $TampilCheckBox, $cssclass){
		global $Ref, $DataPengaturan;
		$Koloms="";
		$Tbl = $this->View_SPPPotongan;
		$hal=cekPOST2("hal");
		$ulang = $hal == 4?2:1;
		if($isi["status"] > 2){					
			$qry = "SELECT * FROM $Tbl WHERE refid_spp='".$isi["Id"]."' AND sttemp='0' ";
			$aqry = mysql_query($qry);
			$jumlah_potongan=0;
			while($dt = mysql_fetch_assoc($aqry)){
				$kdRekening = $DataPengaturan->Gen_valRekening($dt);
				$Koloms.= 
					$this->set_KolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass).
					Tbl_Td("", "center",$cssclass,2).
					Tbl_Td(LabelSPan1("ket_pot",$kdRekening.". ".$dt["nm_rekening"]."/ ".$dt["nama_potongan"], "style='margin-left:20px;'"), "left",$cssclass).
					Tbl_Td("", "right",$cssclass,$ulang).
					Tbl_Td(FormatUang($dt["jumlah"]), "right",$cssclass).
					Tbl_Td("", "center",$cssclass, 2)."</tr>";
				$this->pid_urutan++;
				$jumlah_potongan+=$dt["jumlah"];
			}
			$this->subTotal-=$jumlah_potongan;
			$this->subTotal_Pot+=$jumlah_potongan;
		}					
		
		//$this->pid_urutan++;
		
	 	return $Koloms;
	}
	
	function setKolomData_Pil_SPP($no, $isi, $Mode, $TampilCheckBox, $cssclass){
		global $Ref, $DataPengaturan;
	 	$Koloms=""; 
		
		$nomor = BtnText(substr($isi['nomor_spp'],0,4)."...", "", "style='color:black;' title='".$isi["nomor_spp"]."'");
		
		$Koloms.= $this->set_KolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass);
		$Koloms.=Tbl_Td(FormatTanggalnya($isi["tgl_spp"]), "center",$cssclass);
		$Koloms.=Tbl_Td($nomor, "center",$cssclass);
		$Koloms.=Tbl_Td($isi["uraian"], "left",$cssclass);
		$Koloms.=Tbl_Td("", "left",$cssclass);
		$Koloms.=Tbl_Td($this->setKolomData_DataSurat_GetStatus($isi), "center",$cssclass)."</tr>";	
		//$Koloms.=$this->setKolomData_Ket_SPP($no, $isi, $Mode, $TampilCheckBox, $cssclass)."</tr>";
		$this->pid_urutan++;
		
		$Koloms.=$this->setKolomData_RekSPP($no, $isi, $Mode, $TampilCheckBox, $cssclass);
		return $Koloms;
	}
	
	function setKolomData_Pil_SP($no, $isi, $Mode, $TampilCheckBox, $cssclass){
		global $Ref, $DataPengaturan;
	 	$Koloms=""; 
		$hal = cekPOST2("hal");
		$ulang=3;
		switch($hal){
			case "3":$sp="_spm";break;
			case "4":$sp="_sp2d";break;
			default:$sp="";break;
		}
		
		$nomor = BtnText(substr($isi['nomor'.$sp],0,4)."...", "", "style='color:black;' title='".$isi["nomor".$sp]."'");
		
		$Koloms.= $this->set_KolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass);
		$Koloms.=Tbl_Td(FormatTanggalnya($isi["tgl".$sp]), "center",$cssclass);
		$Koloms.=Tbl_Td($nomor, "left",$cssclass);
		$Koloms.=Tbl_Td($isi['uraian'.$sp], "left",$cssclass);
		$Koloms.=$hal == 4?Tbl_Td($isi['nm_bank'], "left",$cssclass):"";
		$Koloms.=Tbl_Td("", "center",$cssclass,$ulang);
		$Koloms.=Tbl_Td($this->setKolomData_DataSurat_GetStatus($isi), "center",$cssclass)."</tr>";	
		$this->pid_urutan++;
		
		$Koloms.=$this->setKolomData_RekSPP($no, $isi, $Mode, $TampilCheckBox, $cssclass);		
		$Koloms.=$this->setKolomData_RekPotSPM($no, $isi, $Mode, $TampilCheckBox, $cssclass);	
					
		return $Koloms;
	}
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref, $DataPengaturan;
	 $Koloms=""; 
	 $this->pid_nomor=0;
	 $this->subTotal=0;
	 $this->subTotal=0;
	 $this->subTotal_Rek=0;
	 $this->subTotal_Pot=0;
	 $cssclass = $Mode == 1?'class="GarisDaftar"':'class="GarisCetak"';	
	 $hal = cekPOST2("hal"); 
	 
	 if($hal < 3)$Koloms.=$this->setKolomData_Pil_SPP($no, $isi, $Mode, $TampilCheckBox, $cssclass);	 
	 if($hal > 2)$Koloms.=$this->setKolomData_Pil_SP($no, $isi, $Mode, $TampilCheckBox, $cssclass);
	 
 	 $Koloms.=$this->setKolomData_SubTotal($no, $isi, $Mode, $TampilCheckBox, $cssclass);
	 $Koloms = array(
	 	array("Y", $Koloms),
	 );
	 
	 $this->pid=$isi["Id"];
	 $this->pid_nomor=0;
	 
	 return $Koloms;
	}
	
	function ImgStat($img, $title, $width='20px', $height='20px'){
		return "<img src='images/administrator/images/$img' title='$title' width='$width' height='$height' />";
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main, $DataOption;
	 $thn_anggaran = $_COOKIE['coThnAnggaran'];
	 $arr = array(
			//array('selectAll','Semua'),	
			array('selectdaftarsuratpermohonan','daftarsuratpermohonan'),		
			);
	 $arr_pencarian = array(	
		array('1','NOMOR SPP'),		
		array('2','NOMOR SPM'),		
		array('3','NOMOR SP2D'),		
	 );
	 
	 $arr_status = array(	
		array('1','SPP'),		
		array('2','VERIVIKASI SPP'),		
		array('3','SPM'),		
		array('4','SP2D'),		
	 );
	 
	 $arr_status2 = array(			
		array('3','SPM'),		
		array('4','SP2D'),		
	 );
		
	 //data order ------------------------------
	 $arrOrder = array(
			     	array('1','daftarsuratpermohonan'),
					);
	 
	$fmPILCARI = cekPOST2('fmPILCARI');		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	
	$hal = cekPOST2("hal");	
	$DataSKPD = WilSKPD_ajx3($this->Prefix.'SKPD2');
	//DEKLARASI ----------------------------------------------------------------------------------------------------
	
	//$fmPILSTATUS = cekPOST2('fmPILSTATUS', $this->Get_FMStatus());
	$fmPILSTATUS = cekPOST2('fmPILSTATUS');
	$width_KdRek = $hal < 4?120:80;	
	$width_uraian = $hal > 2?327:400;	
		
	$Konten_Pencarian = 
		array(
			//cmbArray("fmPILCARI",$fmPILCARI, $arr_pencarian, "--- CARI DATA ---","style='width:150px;'"),
			InputTypeText("fm_nomor",cekPOST2("fm_nomor"),"style='width:190px;' placeholder='NOMOR $nosp' "),
			InputTypeText("fm_kd_rek",cekPOST2("fm_kd_rek"),"style='width:".$width_KdRek."px;' placeholder='REKENING' "),
			InputTypeText("fm_nm_rek",cekPOST2("fm_nm_rek"),"style='width:400px;' placeholder='NAMA REKENING' "),		
		);
	$Konten_Filter =
		array(
			cmbArray("fm_triwulan", cekPOST2("fm_triwulan"), $Main->ARR_TRIWULAN2, "SEMUA TRIWULAN","style='width:190px;'")
		);	
		
	$FmUraian="";
	$TXT_URAIAN = InputTypeText("fm_uraian",cekPOST2("fm_uraian"),"style='width:".$width_uraian."px;' placeholder='URAIAN PEMBAYARAN' ");
	$Btn_Cari = InputTypeButton("btn_cari", "CARI", "onclick='".$this->Prefix.".refreshList(true);'");
	if($hal > 2){
		array_push($Konten_Pencarian,
			InputTypeText("fm_kd_pot",cekPOST2("fm_kd_pot"),"style='width:80px;' placeholder='POTONGAN' "),
			InputTypeText("fm_nm_pot",cekPOST2("fm_nm_pot"),"style='width:400px;' placeholder='NAMA POTONGAN' ")
		);
		$FmUraian = genFilterBar(array($TXT_URAIAN,$Btn_Cari),"","","");	
	}	
	
	switch($hal){
		case 3:
			$nosp="SPM";
			$arr_stat_pil = $arr_status2;
		break;
		case 4:$nosp="SP2D";break;
		default:
			$nosp="SPP";
			$arr_stat_pil = $arr_status;
			array_push($Konten_Pencarian, $TXT_URAIAN, $Btn_Cari);
		break;
	}
	
	if($hal < 4){
		array_push($Konten_Filter,
			cmbArray("fmPILSTATUS",$fmPILSTATUS, $arr_stat_pil, "SEMUA STATUS","style='width:120px;'")				
		);
	}
	
	array_push($Konten_Filter,
		InputTypeText("fm_thn_anggaran",$thn_anggaran,"style='width:40px;' readonly"),
		InputTypeButton("btn_cari", "TAMPILKAN", "onclick='".$this->Prefix.".refreshList(true);'")
	);
	
	$TampilOpt =
			InputTypeHidden("ver_skpd",$DataOption['skpd']).
			genFilterBar(array($DataSKPD),"","","").
			genFilterBar($Konten_Pencarian,"","","").
			$FmUraian.
			genFilterBar($Konten_Filter,"","","");
			
		return array('TampilOpt'=>$TampilOpt);
	}		
	
	function Get_FMStatus(){
		$def_status="";
		$hal = cekPOST2("hal");
		if($hal){
			if(!isset($_REQUEST["fmPILSTATUS"])){
				switch($hal){
					case "2":$def_status="1";break;
					case "3":$def_status="3";break;
					case "4":$def_status="4";break;
				}
			}
		}
		
		return $def_status;
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		$thn_anggaran = $_COOKIE['coThnAnggaran'];
		
		$t_spp_rek = $this->View_SPPRek;
		$t_spp_pot = $this->View_SPPPotongan;
		
		//kondisi -----------------------------------		
		$arrKondisi = array();		
		
		$fmPILCARI = cekPOST2('fmPILCARI');	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn
		$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];			
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
		$jns_spp = cekPOST2("jns_spp");
		$fm_nomor = cekPOST2("fm_nomor");
		$fm_kd_rek = cekPOST2("fm_kd_rek");
		$fm_nm_rek = cekPOST2("fm_nm_rek");
		$fm_kd_pot = cekPOST2("fm_kd_pot");
		$fm_nm_pot = cekPOST2("fm_nm_pot");
		$fm_triwulan = cekPOST2("fm_triwulan");
		$fm_uraian = cekPOST2("fm_uraian");
		$hal = cekPOST2("hal");
		//$fmPILSTATUS = cekPOST2('fmPILSTATUS', $this->Get_FMStatus());
		$fmPILSTATUS = cekPOST2('fmPILSTATUS');
		switch($hal){
			case "3":
				$sp = "spm";
			break;
			case "4":
				$sp = "sp2d";
			break;
			default:
				$sp = "spp";
			break;
		}
		
		$sp_uraian = $hal > 2?"uraian_".$sp:"uraian"; 
		
		$c1input = $_COOKIE['cofmURUSAN'];
		$cinput = $_COOKIE['cofmSKPD'];
		$dinput = $_COOKIE['cofmUNIT'];
		$einput = $_COOKIE['cofmSUBUNIT'];
		$e1input = $_COOKIE['cofmSEKSI'];
		
		if($c1input != '' && $c1input != '0')$arrKondisi[] = "c1='$c1input'";
		if($cinput != '' && $cinput != '00')$arrKondisi[] = "c='$cinput'";
		if($dinput != '' && $dinput != '00')$arrKondisi[] = "d='$dinput'";
		if($einput != '' && $einput != '00')$arrKondisi[] = "e='$einput'";
		if($e1input != '' && $e1input != '000')$arrKondisi[] = "e1='$e1input'";
		
		$concat_KdRek = "concat(k,'.',l,'.',m,'.',n,'.',o)";
		$selectTbl_Rek = "SELECT refid_spp FROM $t_spp_rek WHERE sttemp='0' ";
		$selectTbl_Pot = "SELECT refid_spp FROM $t_spp_pot WHERE sttemp='0' ";
		
		if($fm_nomor != "")$arrKondisi[] = " nomor_$sp LIKE '%$fm_nomor%' ";
		if($fm_kd_rek != "")$arrKondisi[] = "Id IN ($selectTbl_Rek AND $concat_KdRek LIKE '%$fm_kd_rek%' ) ";
		if($fm_nm_rek != "")$arrKondisi[] = "Id IN ($selectTbl_Rek AND nm_rekening LIKE '%$fm_nm_rek%' ) ";
		if($fm_kd_pot != "")$arrKondisi[] = "Id IN ($selectTbl_Pot AND $concat_KdRek LIKE '%$fm_kd_pot%' ) ";
		if($fm_nm_pot != "")$arrKondisi[] = "Id IN ($selectTbl_Pot AND concat(nm_rekening,'/ ',nama_potongan) LIKE '%$fm_nm_pot%' ) ";
		if($fm_uraian != "")$arrKondisi[] = "$sp_uraian LIKE '%$fm_uraian%' ";
		
		if($fm_triwulan != ""){
			switch($fm_triwulan){
				case "1":$arrKondisi[] = "(tgl_$sp BETWEEN '$thn_anggaran-01-01' AND '$thn_anggaran-03-31') ";break;
				case "2":$arrKondisi[] = "(tgl_$sp BETWEEN '$thn_anggaran-04-01' AND '$thn_anggaran-06-30') ";break;
				case "3":$arrKondisi[] = "(tgl_$sp BETWEEN '$thn_anggaran-07-01' AND '$thn_anggaran-09-30') ";break;
				case "4":$arrKondisi[] = "(tgl_$sp BETWEEN '$thn_anggaran-10-01' AND '$thn_anggaran-12-31') ";break;
			}
		}
		
		$arrKondisi[] = "jns_spp='$jns_spp'";
		$arrKondisi[] = " sttemp='0'";
		if($hal == "3")$arrKondisi[] = " status>='3'";
		if($hal == "4")$arrKondisi[] = " status>='4'";		
		
		if($fmPILSTATUS != "")$arrKondisi[] = " status='$fmPILSTATUS'";	
		
		//Cari 
		switch($fmPILCARI){			
			case 'selectdaftarsuratpermohonan': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;						 	
		}
		if(!empty($fmFiltTglBtw_tgl1)) $arrKondisi[]= " tgl_daftar>='$fmFiltTglBtw_tgl1'";
		if(!empty($fmFiltTglBtw_tgl2)) $arrKondisi[]= " tgl_daftar<='$fmFiltTglBtw_tgl2'";	
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " nama $Asc1 " ;break;
		}	
		 $arrOrders[] = " Id DESC " ;
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
	
	function FormDariPenerimaan($pekerjaan='', $kegiatannya='', $pekerjaan='', $tgl_kontrak='', $nomor_kontrak='', $penyedia_barang=''){
		global $DataPengaturan;
	
		return genFilterBar(
					array(
						$DataPengaturan->isiform(
							array(
								array(
									'label'=>'PROGRAM',
									'name'=>'program',
									'label-width'=>'200px;',
									'type'=>'text',
									'value'=>$pekerjaan,
									'parrams'=>"style='width:500px;' placeholder='PROGRAM' readonly",
								),
								array(
									'label'=>'KEGIATAN',
									'name'=>'kegiatan',
									'label-width'=>'200px;',
									'type'=>'text',
									'value'=>$kegiatannya,
									'parrams'=>"style='width:500px;' placeholder='KEGIATAN' readonly",
								),
								array(
									'label'=>'PEKERJAAN',
									'name'=>'pekerjaan',
									'label-width'=>'200px',
									'type'=>'text',
									'value'=>$pekerjaan,
									'parrams'=>"style='width:500px;' placeholder='PEKERJAAN' readonly",
								),
								array(
									'label'=>'TANGGAL DAN NOMOR KONTRAK',
									'name'=>'dokumensumber',
									'label-width'=>'200px;',
									'value'=>"<input readonly type='text' name='tgl_kontrak' id='tgl_kontrak' value='$tgl_kontrak' style='width:80px;' /> <input type='text' name='nomor_kontrak' id='nomor_kontrak' value='$nomor_kontrak' style='width:217px;' readonly /> "
											
									,						
								),	
								array(
									'label'=>'PENYEDIA BARANG',
									'name'=>'penyedia_barang',
									'label-width'=>'200px',
									'type'=>'text',
									'value'=>$penyedia_barang,
									'parrams'=>"style='width:300px;' placeholder='PENYEDIA BARANG' readonly",
								),
							)
						)
					)
				,'','','');
	}
	
	function PengecekanUbahSPP(){
		$cek="";$err="";$content='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
				
		$err = $this->GetStatusSPP($cbid[0]);
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function PengecekanUbahSPM(){
		$cek="";$err="";$content='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		
		
		
		if($err == "" && count($cbid) > 1)$err="Pilih Hanya 1 Data !";
		if($err == "" ){
			$qry = $this->Gen_QueryTabel_Spp(cekPOST_Arr($this->Prefix.'_cb', 0));
			$dt = $qry["content"]; $cek.=$qry["cek"];
			if($err == "" && $dt["status"] < 3)$err="Data Tidak Valid !";
			if($err == "" && $dt["status"] > 3)$err="Data Tidak Bisa di Rubah, Status Data SPM Sudah Berubah Menjadi ".$this->setKolomData_DataSurat_GetStatus($dt)." !";
		}		
		//$err = $this->GetStatusSPP($cbid[0]);
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function PengecekanUbahSP2D(){
		$cek="";$err="";$content='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
				
		//$err = $this->GetStatusSPP($cbid[0]);
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
		
	function GetStatusSPP($Id){
		$err = "";
		$data = $this->GetDataSPP($Id);		
		if($data['status'] != "1")$err = "Data Ini Tidak Bisa di Ubah. Status SPP Sudah Berubah Menjadi ".$this->arr_statusSPP2[$data["status"]]." !";
		
		return $err;
	}
	
	function GetTotalRekPenerimaan($IdSPP){
		global $DataPengaturan;
		
		$jml_rek = 0;
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_spp", "refid_terima", "WHERE Id='$IdSPP' ");
		$dt = $qry["hasil"];
		if($dt["refid_terima"] != NULL || $dt["refid_terima"] != ""){
			$qry_rek = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_rekening", "IFNULL(SUM(jumlah),0) as jml", "WHERE refid_terima='".$dt['refid_terima']."' AND sttemp='0' ");
			$dt_rek=$qry_rek["hasil"];
			$jml_rek = $dt_rek["jml"];
		}
		
		return $jml_rek;
		
	}
	
	function getTombolBaruNamaPejabat($jns,$name_form=''){
		return " <input type='button' value='BARU' onclick='".$this->Prefix.".BaruNamaPejabat($jns,`$name_form`)' />";
	}
	
	function BaruNamaPejabat(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['c1'] = cekPOST('c1nya');
		$dt['c'] = cekPOST('cnya');
		$dt['d'] = cekPOST('dnya');
		$dt['jns'] = cekPOST('jns');
		
		$fm = $this->setFormBaruNamaPejabat($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormBaruNamaPejabat($dt){	
	 global $SensusTmp, $DataOption, $DataPengaturan;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	s 	
	 $form_name = $this->Prefix.'_form';
	 
				
	 $this->form_width = 500;
	 $this->form_height = 160;
	 $this->form_caption = 'FORM BARU PEJABAT';
	 
	 $c1 = $dt['c1'];
	 $c = $dt['c'];
	 $d = $dt['d'];
	 
					
	 $queryJabatan = "SELECT nama,nama FROM ref_jabatan";
		
    	
	
	 //items ----------------------
	  $konten_Data = $DataPengaturan->GenViewSKPD6($c1,$c,$d,150,300);
	  array_push($konten_Data,	  	  	
			array( 
				'label'=>'NIP',
				'labelWidth'=>150, 
				'value'=>$DataPengaturan->InputTypeText("nip",$dt['nip'])),
			array( 
				'label'=>'NAMA PEGAWAI',
				'labelWidth'=>150, 
				'value'=>$DataPengaturan->InputTypeText("namapegawai","")),
			array( 
				'label'=>'JABATAN',
				'labelWidth'=>50, 
				'value'=>cmbQuery('fmJabatan',$dt['jabatan'],$queryJabatan," style='width:300px;'",'-------- Pilih --------')
			)				 			 
		);
		$this->form_fields = $konten_Data;
		//tombol
		$this->form_menubawah =
			"<input type='hidden' name='c1' id='c1' value='".$dt['c1']."'>".
			"<input type='hidden' name='c' id='c' value='".$dt['c']."'>".
			"<input type='hidden' name='d' id='d' value='".$dt['d']."'>".
			"<input type='hidden' name='jns' id='jns' value='".$dt['jns']."'>".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanNamaPejabat()' title='Simpan' >  &nbsp  ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function SimpanNamaPejabat(){
		global $Main, $DataPengaturan, $DataOption;
		$cek='';$err='';$content;
		
		$c1 = cekPOST("c1");
		$c = cekPOST("c");
		$d = cekPOST("d");
		$nip = cekPOST("nip");
		$namapegawai = cekPOST("namapegawai");
		$fmJabatan = cekPOST("fmJabatan");
		$jns = cekPOST("jns");
		
		if($err == "" & $nip=="")$err="NIP Belum di Isi !";
		if($err == "" & $namapegawai=="")$err="Nama Pegawai Belum di Isi !";
		
		if($err == ""){
			$data = array(
				array("c1",$c1),
				array("c",$c),
				array("d",$d),
				array("nip",$nip),
				array("nama",$namapegawai),
				array("jabatan",$fmJabatan),
				array("kategori_tandatangan",$jns),
			);
			
			$simpan = $DataPengaturan->QryInsData("ref_tandatangan", $data);
			$err = $simpan['errmsg'];$cek.=$simpan['cek'];
		}
		
		//Ambil Konten
		if($err == ""){
			$tukC1 = "";
			if($DataOption['skpd'] == 2)$tukC1 = "c1='$c1' AND ";
			
			//Pilih Nama Pejabat
			switch($jns){
				case $DataPengaturan->kat_PA_KPA : $form_pejabat = "refid_pa_kpa";break;
				case $DataPengaturan->kat_PPK:$form_pejabat = "refid_pejabat_pk";break;
				case $DataPengaturan->kat_PPTK:$form_pejabat = "refid_pptk";break;
				case $DataPengaturan->kat_BPP:$form_pejabat = "refid_bendahara_pp";break;
				case $DataPengaturan->kat_BP:$form_pejabat = "refid_bendahara_p";break;
			}
			
			//Ambil Id
			$isi_form_pejabat = $DataPengaturan->QyrTmpl1Brs2("ref_tandatangan","Id", $data, "ORDER BY Id DESC");
			$nm_pejabat_pilih = $isi_form_pejabat['hasil'];
			
			//Konten
			$qry = "SELECT Id, nama FROM ref_tandatangan WHERE $tukC1 c='$c' AND d='$d' AND kategori_tandatangan='$jns' ";
			
			$content['value'] = cmbQuery($form_pejabat,$nm_pejabat_pilih['Id'],$qry, "style='width:300px;' ","--- PILIH ---");
			$content['jns'] = $jns;			
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setForm_content_fields(){
		$content = '';
		
		
		
		foreach ($this->form_fields as $key=>$field){
			if(isset($field['labelWidth'])){
				$labelWidth = $field['labelWidth']==''? $this->formLabelWidth: $field['labelWidth'];
				$pemisah = $field['pemisah']==NULL? ':': $field['pemisah'];			
				$row_params = $field['row_params']==NULL? $this->row_params : $field['row_params'];
				if ($field['type'] == ''){
					$val = $field['value'];
					$content .= 
						"<tr $row_params>
							<td style='width:$labelWidth'>".$field['label']."</td>
							<td style='width:10'>$pemisah</td>
							<td>". $val."</td>
						</tr>";
				}else if ($field['type'] == 'merge' ){
					$val = $field['value'];
					$content .= 
						"<tr $row_params>
							<td colspan=3 >".$val."</td>
						</tr>";
				}else{
					$val = Entry($field['value'],$key,$field['param'],$field['type']);	
					$content .= 
						"<tr $row_params>
							<td style='width:$labelWidth'>".$field['label']."</td>
							<td style='width:10'>$pemisah</td>
							<td>". $val."</td>
						</tr>";
				}	
			}
		}
		//$content = 
		//	"<tr><td style='width:100'>field</td><td style='width:10'>:</td><td>value</td></tr>";
		return $content;	
	}
	
	function GetDataSPP($Id){
		global $DataPengaturan;
		$qry = $DataPengaturan->QyrTmpl1Brs($this->TblName,"*", "WHERE Id='$Id' ");
		$dt = $qry["hasil"];
		
		return $dt;
	}
	
	function Gen_QueryTabel_Spp($Id){
		global $DataPengaturan;
		
		$qry = $DataPengaturan->QyrTmpl1Brs($this->View_SPP, "*", "WHERE Id='$Id' ");
		$aqry = $qry["hasil"];
				
		$data = array("cek"=>$qry['cek'], "content"=>$aqry);
		return $data;
	}
	
	function Get_JenisTagihanSPP($refid_nomor_tagihan){
		global $DataPengaturan;
		
		$qry = $DataPengaturan->QyrTmpl1Brs("ref_tagihan a LEFT JOIN ref_jenis_tagihan b","b.nm_tagihan"," ON b.Id=a.refid_jns_tagihan WHERE a.Id='$refid_nomor_tagihan'"); $cek=$qry["cek"];
		
		$data = $qry["hasil"];
		
		return $data["nm_tagihan"];
	}
	
	function Gen_QueryTabel_ref_penyedia($Id){
		global $DataPengaturan;
		$content = array();
		
		$qry = $DataPengaturan->QyrTmpl1Brs("ref_penyedia","*", "WHERE id='$Id' ");
		$dt=$qry["hasil"];
		
		$content['nama']=$dt["nama_penyedia"];
		$content['bank']=$dt["nama_bank"];
		$content['no_rekening']=$dt["norek_bank"];
		$content['npwp']=$dt["no_npwp"];
		
		return $content;
	}
	
	function Gen_QueryTabel_ref_norek_bendahara($Id){
		global $DataPengaturan;
		$content = array();
		
		$qry = $DataPengaturan->QyrTmpl1Brs("ref_norek_bendahara","*", "WHERE Id='$Id' ");
		$dt=$qry["hasil"];
		
		$content['nama']=$dt["nama"];
		$content['bank']=$dt["bank"];
		$content['no_rekening']=$dt["no_rekening"];
		$content['npwp']=$dt["npwp"];
		
		return $content;
	}
	
	function Get_PenerimaUang($Id, $jns){
		global $DataPengaturan;
		$content = array();
		switch($jns){
			case "1":$content=$this->Gen_QueryTabel_ref_norek_bendahara($Id);
			break;
			case "2":$content=$this->Gen_QueryTabel_ref_penyedia($Id);
			break;
		}
		
		return $content;
	}
	
	function Gen_QueryTabel_ref_tandatangan($Id){
		global $DataPengaturan;
		$content = array();
		
		$qry = $DataPengaturan->QyrTmpl1Brs("ref_tandatangan","*", "WHERE Id='$Id' ");
		$content=$qry["hasil"];
		
		return $content;
	}
	
	function Gen_Query_viewRekSPP($IdSPP, $refid_nomor_spd=""){
		$where_refid_nospd = $refid_nomor_spd != ""?" AND a.refid_nomor_spd='$refid_nomor_spd'":"";
		return "SELECT a.*, b.nm_program, b.total as tot_pagu FROM v1_spp_rekening a LEFT JOIN v1_nomor_spd_det b ON a.refid_nomor_spd_det = b.Id AND a.refid_nomor_spd=b.refid_nomor_spd WHERE a.refid_spp='$IdSPP' AND a.status!='2' $where_refid_nospd ORDER BY Id DESC";
	}
	
	function Get_QueryTotalRekSPP($IdSPP){
		global $DataPengaturan;
		
		$qry_spp = $this->Gen_QueryTabel_Spp($IdSPP);
		$dt_spp = $qry_spp["content"];
		$where="";
		$qry_sppRek = $this->Gen_Query_viewRekSPP($dt_spp["Id"],$dt_spp["refid_nomor_spd"]);
		$qry_sppRek = "($qry_sppRek) a";
		if($dt_spp["jns_spp"] != "1" && $dt_spp["jns_spp"] != NULL){
			$qry_sppRek = $this->View_SPPRek2;
			$where = "WHERE refid_spp='$IdSPP' AND sttemp='0' ";
		}
		$aqry_sppRek = $DataPengaturan->QyrTmpl1Brs($qry_sppRek, "IFNULL(SUM(jumlah),0) as total",$where);
		$dt_sppRek = $aqry_sppRek["hasil"];
		
		return $dt_sppRek["total"];
		//return $aqry_sppRek["cek"];		
	}
	
	function Get_QueryTotalPotongan_SPP($IdSPP){
		global $DataPengaturan;
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_spp_potongan", "IFNULL(SUM(jumlah),0) as total", "WHERE refid_spp='$IdSPP' AND status='0' AND sttemp='0' ");
		$dt = $qry["hasil"];
		
		return $dt["total"];
	}
	
	function BersihkanData(){
		global $DataPengaturan;
		$cek='';
		
		$where = "WHERE tgl_update < DATE_SUB(NOW(), INTERVAL 2 HOUR)";
		
		//UPDATE -------------------------------------------------------------------------
		$data_upd = array(array("status","0"));
		$where_upd = $where." AND status!='0' AND sttemp='0'";
		$qry_pot = $DataPengaturan->QryUpdData("t_spp_potongan",$data_upd, $where_upd);$cek.=$qry_pot["cek"];
		$qry_rek = $DataPengaturan->QryUpdData("t_spp_rekening",$data_upd, $where_upd);$cek.=" | ".$qry_rek["cek"];
		//DELETE -------------------------------------------------------------------------
		$where_del = $where." AND sttemp!='0'";
		$del_pot = $DataPengaturan->QryDelData("t_spp_potongan",$where_del);$cek.=" | ".$del_pot["cek"];
		$del_rek = $DataPengaturan->QryDelData("t_spp_rekening",$where_del);$cek.=" | ".$del_rek["cek"];
		$del_spp = $DataPengaturan->QryDelData("t_spp","WHERE tgl_update < DATE_SUB(NOW(), INTERVAL 2 DAY) AND sttemp!='0'");
		$cek.=" | ".$del_spp["cek"];
		//--------------------------------------------------------------------------------
		
		return $cek;
	}
	
	function VerivikasiRekSPM_Valid(){
		global $DataPengaturan;
		$err="";
		
		return $err;
	}
	
	function VerivikasiRekSPM(){
		global $DataPengaturan;
		$cek='';$err="";$content="";
		
		$IdRek = cekPOST2("IdRek");
		$cb = cekPOST2("cb_valid_rek_".$IdRek,"TDK");
		
		$err = $this->VerivikasiRekSPM_Valid();
		if($err == ""){
			$stat = $cb == "OK"?1:0;			
			$jml = $cb == "OK"?"jumlah":"'0'";			
			$data_upd = array(array("status_valid",$stat),array("jumlah_spm=$jml","","",""));
			$qry = $DataPengaturan->QryUpdData($this->TblName_Rekening,$data_upd,"WHERE Id='$IdRek' ");$cek.=$qry["cek"];
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function formVerivikasiSPP(){
		global $DataPengaturan;
		$cek='';$err="";$content="";
		
		$t_spp_rek = $this->TblName_Rekening;
		
		$cb = $_REQUEST[$this->Prefix."_cb"];
		$idplh = cekPOST_Arr($this->Prefix."_cb",0);
		if($err == "" && count($cb) == 0)$err="Data Belum di Pilih !";
		if($err == "" && count($cb) > 1)$err="Pilih Hanya Dari 1 Nomor SPP !";
		if($err == ""){
			$qry = $this->Gen_QueryTabel_Spp($idplh);
			$dt = $qry["content"];
			if($dt["Id"] == NULL || $dt["Id"] == "")$err="Data Tidak Valid !";
			if($err == "" && $dt["sttemp"] == "1")$err="Data Tidak Valid !";
			if($err == "" && intval($dt["status"]) > 2)$err="Tidak Bisa Mengubah Verivikasi SPP, Data SPP Sudah Berubah Status Menjadi ".$this->arr_statusSPP2[$dt["status"]]." !";
		}
		if($err == ""){
			$qry_HitRek = $DataPengaturan->QryHitungData($t_spp_rek, "WHERE refid_spp='$idplh' AND sttemp='0' AND status_valid='0' ");
			if($qry_HitRek["hasil"] > 0)$err="Uraian Rekening SPP Belum di Verivikasi Seluruhnya !";
		}
		$dt["viewnyasaja"]="";		
		//if($err == "")$err="Belum Tersedia !";
		if($err == ""){
			$Get = $this->setformVerivikasiSPP($dt);
			$cek.= $Get["cek"];
			$err = $Get["err"];
			$content= $Get["content"];
		}
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setformVerivikasiSPP_Rek_PK($dtRek, $css_class){
		global $DataPengaturan;
		$content="";
		$row=$this->pid_urutan%2==0?"row1":"row0";				
		$program = $DataPengaturan->Gen_valProgram($dtRek);
		if($this->program != $program){
			$content.="
				<tr class='$row'>".
					Tbl_Td("", "left", $css_class, 2).
					Tbl_Td("<b>".$dtRek["nm_program"]."</b>", "left", $css_class).
					Tbl_Td("", "left", $css_class)
				."</tr>";
			$this->pid_urutan++;
		}		
		
		$row=$this->pid_urutan%2==0?"row1":"row0";
		$kegiatan = $DataPengaturan->Gen_valKegiatan($dtRek);
		if($this->kegiatan != $kegiatan){
			$content.="
				<tr class='$row'>".
					Tbl_Td("", "left", $css_class, 2).
					Tbl_Td(LabelSPan1("dtkeg",$dtRek["nm_kegiatan"],"style='margin-left:5px;font-weight:bold;'"), "left", $css_class).
					Tbl_Td("", "left", $css_class)
				."</tr>";
			$this->pid_urutan++;
		}
		
		
		$this->program = $program;
		
		return $content;
	}
	
	function setformVerivikasiSPP_Rek($dt){
		global $DataPengaturan;
		$content="";
		$css_class = "class='GarisDaftar'";		
		
		$tbl = $dt["jns_spp"] == 1?$this->View_SPPRek:$this->View_SPPRek2;
		
		$qry = "SELECT * FROM $tbl WHERE refid_spp='".$dt["Id"]."'";
		$aqry = mysql_query($qry);
		$isi="";
		$no=1;
		$this->pid_urutan=1;
		$subTotal=0;
		while($dtRek = mysql_fetch_assoc($aqry)){
			if($dt["jns_spp"] == 1)$isi.=$this->setformVerivikasiSPP_Rek_PK($dtRek, $css_class);
			
			$row=$this->pid_urutan%2==0?"row1":"row0";		
			$KodeRek = $DataPengaturan->Gen_valRekening($dtRek);	
			$isi.=
				"<tr class='$row'>".
					Tbl_Td($no, "right", $css_class).
					Tbl_Td($KodeRek, "center", $css_class).
					Tbl_Td(LabelSPan1("kdrek",$dtRek["nm_rekening"],"style='margin-left:10px;'"),"left", $css_class).
					Tbl_Td(FormatUang($dtRek["jumlah"]), "right", $css_class).
				"</tr>";
			$no++;
			$subTotal+=$dtRek["jumlah"];
			$this->pid_urutan++;
		}
		
		$row=$this->pid_urutan%2==0?"row1":"row0";
		$content = "
				<table class='koptable' style='min-width:100%;' border='1'>
					<tr>
						<th class='th01' width='25'>NO</th>
						<th class='th01' width='80'>REKENING</th>
						<th class='th01'>URAIAN</th>
						<th class='th01' width='25'>JUMLAH</th>					
					</tr>
					$isi
					<tr class='$row'>".
						Tbl_Td("<b>SUBTOTAL</b>", "right", $css_class." colspan='3'").
						Tbl_Td("<b>".FormatUang($subTotal)."</b>", "right", $css_class).
					"</tr>
				</table>
			";
		
		return $content;
	}
		
	function setformVerivikasiSPP($dt){	
	 global $SensusTmp, $DataOption, $DataPengaturan;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form'; 
				
	 $this->form_width = 1000;
	 $this->form_height = 500;
	 $this->form_caption = 'FORM VERIVIKASI SPP';	 	 
	$kontenTerima=array("kosong"=>"Y");				    	
	if($dt["refid_terima"] != 0){
		$qry_terima = $DataPengaturan->QyrTmpl1Brs($this->TblName_Terima, "*", "WHERE Id='".$dt["refid_terima"]."'");
		$dt_terima = $qry_terima["hasil"];
		$kontenTerima=
			array( 
				'label'=>'NOMOR PENERIMAAN',
				'value'=>$dt_terima["id_penerimaan"]);
	}
	
	switch($dt["refid_penyedia_jns"]){
		case "1":
			$qry_penyedia = $DataPengaturan->QyrTmpl1Brs("ref_norek_bendahara", "*", "WHERE Id='".$dt["refid_penyedia"]."'");
		break;
		case "2":
			$qry_penyedia = $DataPengaturan->QyrTmpl1Brs("ref_penyedia  ", "nama_penyedia as nama, alamat, nama_bank as bank, norek_bank as no_rekening, no_npwp as npwp", "WHERE id='".$dt["refid_penyedia"]."'");
		break;
	}
	$dt_penyedia = $qry_penyedia["hasil"];
	$style_pnrm="style='margin-left:10px;'";
	
	$checked=$dt["status"] > 1?"checked='checked'":"";
	 //items ----------------------
	$FM_VERIVIKASISPP = isset($dt["stat_viewnyasaja"])?"":
		$DataPengaturan->isiform(
			array(
				array(
					'label'=>'VERIVIKASI SPP',
					'label-width'=>'150',
					'value'=>InputTypeCheckbox("cb_verivikasi","OK",$checked)
				),
			)
		);
		
	$ARR_DATAFORM =
		array(
			array(
				'label'=>'JENIS SPP',
				'label-width'=>'150',
				'value'=>$DataPengaturan->Daftar_arr_pencairan_dana[$dt["jns_spp"]]
			),
			array( 
				'label'=>'NOMOR SPP',
				'value'=>$dt["nomor_spp"]),
			array( 
				'label'=>'TANGGAL SPP',
				'value'=>FormatTanggalnya($dt["tgl_spp"])),
			$kontenTerima,
			array( 
				'label'=>'NOMOR TAGIHAN',
				'value'=>$dt["no_tagihan"]),
			array( 
				'label'=>'TANGGAL TAGIHAN',
				'value'=>FormatTanggalnya($dt["tgl_tagihan"])),
			array( 
				'label'=>'URAIAN PEMBAYARAN',
				'value'=>$dt["uraian"]),
			array( 
				'label'=>'NAMA PPTK',
				'value'=>$dt["nama_pptk"]),
			array( 
				'label'=>"<b>PENERIMA</b>",
				'pemisah'=>""),
			array( 
				'label'=>LabelSPan1("nm_pnrm", "NAMA", $style_pnrm),
				'value'=>$dt_penyedia["nama"]),
			array( 
				'label'=>LabelSPan1("almt_pnrm", "ALAMAT", $style_pnrm),
				'value'=>$dt_penyedia["alamat"]),
			array( 
				'label'=>LabelSPan1("bank_pnrm", "BANK", $style_pnrm),
				'value'=>$dt_penyedia["bank"]),
			array( 
				'label'=>LabelSPan1("rek_pnrm", "REKENING", $style_pnrm),
				'value'=>$dt_penyedia["norek_bank"]),
			array( 
				'label'=>LabelSPan1("npwp_pnrm", "NPWP", $style_pnrm),
				'value'=>$dt_penyedia["npwp"]),			
		);
	
	 if($dt["jns_spp"] == "1"){
	 	array_push($ARR_DATAFORM,
		 	array( 
				'label'=>"<b>DASAR PEMBAYARAN</b>",
				'pemisah'=>""),
			array( 
				'label'=>LabelSPan1("nospd", "NOMOR SPD", $style_pnrm),
				'value'=>$dt["nomor_spd"]),
			array( 
				'label'=>LabelSPan1("nospd", "TANGGAL SPD", $style_pnrm),
				'value'=>FormatTanggalnya($dt["tanggal_spd"]))
		 );
	 }
		
	
	 array_push($ARR_DATAFORM,
	 	array( 
		'pemisah'=>"", 
		'label'=>"<b>REKENING</b>")
	 );
		
	 $this->form_fields_Konten=
	 	"<table width='100%'>
			<tr valign='top'>
				<td width='50%'>".
				$DataPengaturan->GenViewSKPD8($dt["c1"],$dt["c"],$dt["d"],150).
				"</td>
				<td valign='bottom'>
				".$FM_VERIVIKASISPP."
				</td>
			</tr>
		</table>".		
	 	"<table width='100%'>
			<tr valign='top'>
				<td width='40%'>".$DataPengaturan->isiform($ARR_DATAFORM)."</td>
				<td width='60%'><b>KELENGKAPAN DOKUMEN</b><br>".LabelSPan1("FormTUKDokumen","")."</td>
			</tr>
		</table>".
		$this->setformVerivikasiSPP_Rek($dt);
		
		$Btn = isset($dt["stat_viewnyasaja"])?InputTypeButton("btn_btl","TUTUP", "onclick ='".$this->Prefix.".Close()'" ):InputTypeButton("btn_simpan","SIMPAN", "onclick ='".$this->Prefix.".SimpanVerivikasiSPP()'" )." ".InputTypeButton("btn_btl","BATAL", "onclick ='".$this->Prefix.".BatalVerivikasiSPP()'" );
	 	
		$this->form_menubawah =
			$dt["viewnyasaja"].
			InputTypeHidden("c1",$dt['c1']).
			InputTypeHidden("c",$dt['c']).
			InputTypeHidden("d",$dt['d']).
			InputTypeHidden("Idnya",$dt['Id']).
			$Btn;
							
		$form = $this->genFormKhusus();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}		
	
	function genFormKhusus($withForm=TRUE, $params=NULL, $center=TRUE, $fullScreen=FALSE){	
		$form_name = $this->Prefix.'_form';	
		
		if ( $fullScreen ) $params->tipe=1;
		$form= createDialog(
			$form_name.'_div', 
			$this->form_fields_Konten,
			$this->form_width,
			$this->form_height,
			$this->form_caption,			
			'',
			$this->form_menubawah.
			"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
			 <input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
			,//$this->setForm_menubawah_content(),
			$this->form_menu_bawah_height,'',$params
		);						
		if($withForm) $form= "<form name='$form_name' id='$form_name' method='post' action=''>".$form."</form>";		
		if($center) $form = centerPage( $form );		
		return $form;
	}
	
	function formVerivikasiSPP_KelengkapanDok_CekData($dt){
		global $DataPengaturan;		
		$Idnya = cekPOST2("Idnya");
		$TblDok = $this->TblName_Dokumen;
		
		$qry_hit = $DataPengaturan->QryHitungData($TblDok, "WHERE refid_spp='$Idnya' AND refid_kelengkapan_dok='".$dt["Id"]."' AND status_spp='0' ");
		$checked=$qry_hit["hasil"]>0?"checked='checked'":"";
		
		return $checked;
	}	
	
	function formVerivikasiSPP_KelengkapanDok(){
		global $DataPengaturan;
		$cek="";$err="";$content="";
		
		$Idnya = cekPOST2("Idnya");
		$qry = $this->Gen_QueryTabel_Spp($Idnya);
		$dt = $qry["content"];$cek.=$qry["cek"];
		if($dt["Id"] == "")$err="Data Tidak Valid !";
		
		if($err ==""){		
			$qry_Dok = "SELECT * FROM ".$this->Tbl_Ref_KDok." WHERE jns='".$dt["jns_spp"]."' ";
			$aqry_Dok = mysql_query($qry_Dok);
			$isi="";	
			$no=1;
			
			$css_class = "class='GarisDaftar'";
			while($dt_Dok = mysql_fetch_assoc($aqry_Dok)){
				$ceked = $this->formVerivikasiSPP_KelengkapanDok_CekData($dt_Dok);	
				$comboBox=InputTypeCheckbox("cb_dok_".$dt_Dok["Id"], "OK", "onclick='".$this->Prefix.".SetDokumenSPP(".$dt_Dok["Id"].")' ".$ceked);
				if(isset($_REQUEST["viewnyasaja"])){
					$stat=$ceked!=""?"":"in";
					$comboBox="<img src='images/administrator/images/".$stat."valid.png' width='20px' heigh='20px' />";
				}
				
				$row=$no%2==0?"row1":"row0";			
				$isi.=
					"<tr class='$row'>".
					Tbl_Td($no, "right", $css_class).
					Tbl_Td($dt_Dok["syarat"], "left", $css_class).
					Tbl_Td($comboBox, "center", $css_class).
					"</tr>";
				$no++;
			}
			
			$content = "
				<table class='koptable' style='min-width:100%;' border='1'>
					<tr>
						<th class='th01' width='25'>NO</th>
						<th class='th01'>NAMA DOKUMEN</th>
						<th class='th01' width='25'></th>					
					</tr>
					$isi
				</table>
			";
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function SetDokumenSPP(){
		global $DataPengaturan;
		$cek="";$err="";$content="";
		
		$Tbl_Dok = $this->TblName_Dokumen;
		
		$IdDok = cekPOST2("IdDok");
		$Idnya = cekPOST2("Idnya");
		
		$qry_terima = $this->Gen_QueryTabel_Spp($Idnya);
		$dt_Terima = $qry_terima["content"];
		if($err == "" && $dt_Terima["Id"] == "")$err = "Data Tidak Valid !";		
		if($err == ""){
			$jnsDok = $dt_Terima["jns_spp"];
			//Cek KElengkapan Dokumen
			$qry = $DataPengaturan->QyrTmpl1Brs($this->Tbl_Ref_KDok, "*", "WHERE Id='$IdDok' AND jns='$jnsDok' ");
			$dt_Dok = $qry["hasil"];
			if($dt_Dok["Id"] == "")$err="Data Tidak Valid !";
		}
		
		if($err == ""){
			$where_spp = "WHERE refid_spp='$Idnya' AND refid_kelengkapan_dok='$IdDok' ";
			$cb = cekPOST2("cb_dok_".$IdDok, "TDK");
			if($cb == "OK"){
				$where_spp1 = $where_spp." AND sttemp='0'";
				$hit_SPPDok = $DataPengaturan->QryHitungData($Tbl_Dok,$where_spp1);$cek.=$hit_SPPDok["cek"];
				if($hit_SPPDok["hasil"] > 0){
					$qry_updDok = $DataPengaturan->QryUpdData($Tbl_Dok,array(array("status_spp","1")), $where_spp1);
				}
				
				
				$where_spp2=$where_spp." AND sttemp!='0' ";
				$hit_SPPDok1 = $DataPengaturan->QryHitungData($Tbl_Dok,$where_spp2);$cek.=$hit_SPPDok1["cek"];
				if($hit_SPPDok1["hasil"] > 0){
					$qry_updDok1 = $DataPengaturan->QryUpdData($Tbl_Dok,array(array("status_spp","0")), $where_spp2);
				}else{
					$data_ins = 
						array(
							array("refid_kelengkapan_dok", $IdDok),
							array("status_spp", "0"),
							array("refid_spp", $Idnya),
							array("sttemp", "1"),
						);
					$qryIns = $DataPengaturan->QryInsData($Tbl_Dok, $data_ins);$cek.=$qryIns["cek"];
				}
			}else{
				$qry_updDok1 = $DataPengaturan->QryUpdData($Tbl_Dok,array(array("status_spp","1")), $where_spp);
			}
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function SimpanVerivikasiSPP(){
		global $DataPengaturan;
		$cek="";$err="";$content="";
		
		$Tbl_Dok = $this->TblName_Dokumen;
		
		$Idnya = cekPOST2("Idnya");
		$cb_verivikasi = cekPOST2("cb_verivikasi", "TDK");
		
		$where = "WHERE refid_spp='$Idnya' ";
		$qrySPP = $this->Gen_QueryTabel_Spp($Idnya);
		$dtSPP = $qrySPP["content"];
		if($err == "" && $dtSPP["Id"] == "" )$err="Data Tidak Valid !";
		if($err == "" && $dtSPP["sttemp"] != "0")$err="Data Tidak Valid !";
		//Hitung Dokumen 
		if($err == ""){
			if($cb_verivikasi == "OK"){
				$HitDok = $DataPengaturan->QryHitungData($Tbl_Dok, $where." AND status_spp='0' ");
				if($HitDok["hasil"] < 1)$err="Kelengkapan Dokumen Belum Ada Yang di Pilih ";
				if($err == ""){
					//DELETE DOKUMEN status_spp=1
					$qry_del = $DataPengaturan->QryDelData($Tbl_Dok,$where." AND status_spp='1' ");
					//UPDATE Dokumen sttemp='0'
					$qry_upd = $DataPengaturan->QryUpdData($Tbl_Dok,array(array("sttemp","0")), $where. "AND status_spp='0' ");				
					$status="2";	
				}				
			}else{
				$qry_del = $DataPengaturan->QryDelData($Tbl_Dok,$where);
				$status="1";
			}			
			//UPDATE t_spp
			if($err == ""){
				$qry_upd_spp = $DataPengaturan->QryUpdData($this->TblName_N, array(array("status",$status)), "WHERE Id='$Idnya' ");$cek.=$qry_upd_spp["cek"];
			}
		}
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function BatalVerivikasiSPP(){
		global $DataPengaturan;
		$cek="";$err="";$content="";
		$Tbl_Dok = $this->TblName_Dokumen;
		
		$Idnya = cekPOST2("Idnya");
		$cb_verivikasi = cekPOST2("cb_verivikasi", "TDK");
		
		$where = "WHERE refid_spp='$Idnya' ";
		$qrySPP = $this->Gen_QueryTabel_Spp($Idnya);
		$dtSPP = $qrySPP["content"];
		if($err == "" && $dtSPP["Id"] == "" )$err="Data Tidak Valid !";
		if($err == "" && $dtSPP["sttemp"] != "0")$err="Data Tidak Valid !";
		//Hitung Dokumen 
		if($err == ""){
			//DELETE sttemp='1'
			$qry_del = $DataPengaturan->QryDelData($Tbl_Dok,$where." AND sttemp='1'");
			$qry_udp = $DataPengaturan->QryUpdData($Tbl_Dok,array(array("status_spp","0")),$where." AND sttemp='0'");
			
			$cek.=$qry_del["cek"]." | ".$qry_udp["cek"];
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Lihat_formVerivikasiSPP(){
		global $DataPengaturan;
		$cek="";$err="";$content="";
		$IdSPPnya = cekPOST2("IdSPPnya");
		$qry = $this->Gen_QueryTabel_Spp($IdSPPnya);
		$dt = $qry["content"];
		if($err == "" && $dt["Id"] == "")$err="Data Tidak Valid !";
		$dt["viewnyasaja"]=InputTypeHidden("viewnyasaja","1");
		$dt["stat_viewnyasaja"]=InputTypeHidden("viewnyasaja","1");
		if($err == ""){
			$Get = $this->setformVerivikasiSPP($dt);
			$cek.= $Get["cek"];
			$err = $Get["err"];
			$content= $Get["content"];
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Hapus_Validasi($id){//id -> multi id with space delimiter
		global $DataPengaturan;
		
		$cbid = $_REQUEST[$this->Prefix."_cb"];
		
		for($i=0;$i<count($cbid);$i++){
			if($errmsg == ""){
				$idplh = cekPOST_Arr($this->Prefix."_cb", $i);
				$qry = $this->Gen_QueryTabel_Spp($id);
				$dt = $qry["content"];
				
				if($dt["Id"] == "" && $errmsg == "")$errmsg="Data Tidak Valid";
				if($dt["status"] != "1" && $errmsg == "")$errmsg="Data SPP Dengan Nomor ".$dt["nomor_spp"]." Tidak Bisa di Hapus, Status SPP Sudah Berubah Menjadi ".$this->arr_statusSPP2[$dt["status"]]." !";
			}else{
				break;
			}
		}
		//if($errmsg=="")$errmsg="gfgfh";	
		
		return $errmsg;
	}
	
	function GrandTotal_Data($Label="TOTAL PER HALAMAN",$cols="", $cssclass="", $TotRek=0, $TotPot=0, $Jumlah=0){
		$Koloms="";
		
		$Koloms.=$this->pid_urutan%2==0?"<tr class='row0'>":"<tr class='row1'>";
		$Koloms.=
			Tbl_Td("<b>$Label</b>","center",$cssclass." colspan='$cols'").
			Tbl_Td("<b>".FormatUang($TotRek)."</b>","right",$cssclass);
		if($this->halman > 2){
			$Koloms.=Tbl_Td("<b>".FormatUang($TotPot)."</b>","right",$cssclass);
			$Koloms.=Tbl_Td("<b>".FormatUang($Jumlah)."</b>","right",$cssclass);
		}
		$Koloms.=Tbl_Td("","right",$cssclass)."</tr>";
		
		return $Koloms;
	}
	
	function GrandTotal_Semua(){
		global $DataPengaturan;
		
		$Tbl = $this->View_SPP_Total;
		
		$get = $this->getDaftarOpsi();
		$kondisi = $get["Kondisi"];
		$order = $get["Order"];
		
		$qry = $DataPengaturan->QyrTmpl1Brs($Tbl, "IFNULL(SUM(jumlah_rek),0) as jml_rek, IFNULL(SUM(jumlah_pot),0) as jml_pot", $kondisi." ".$order);
		$dt = $qry["hasil"];
		
		$dt["total"] = $dt["jml_rek"]-$dt["jml_pot"];
		
		return $dt;
		
	}
		
	function GrandTotal($Mode=1,$tuk_Kondisi=''){
		global $DataPengaturan;
		$Koloms='';
		$asal_usul=cekPOST("asal_usul");
		
		$cols	  = $this->halman == "4"?6:5;
		$cols 	  =	$Mode == 1?$cols:$cols-1;	
		$cssclass = $Mode == 1?'class="GarisDaftar"':'class="GarisCetak"';
		//TOTAL PERHALAMAN ---------------------------------------------------------------------------------
		$Koloms.=$this->GrandTotal_Data("TOTAL PER HALAMAN",$cols, $cssclass,$this->Total_Rekening, $this->Total_Potongan, $this->Total_Jumlah);
		$this->pid_urutan++;
		
		//TOTAL SEMUA ---------------------------------------------------------------------------------
		$Harga= $this->GrandTotal_Semua();
		$Koloms.=$this->GrandTotal_Data("TOTAL",$cols, $cssclass,$Harga["jml_rek"],$Harga["jml_pot"],$Harga["total"]);
		$this->pid_urutan++;
		
		return $Koloms;
	}
}
$daftarsuratpermohonan = new daftarsuratpermohonanObj();
?>