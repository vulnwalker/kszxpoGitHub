<?php
 include "pages/pencarian/DataPengaturan.php";
 $DataOption = $DataPengaturan->DataOption();

class pemasukan_retensi_insObj  extends DaftarObj2{	
	var $Prefix = 'pemasukan_retensi_ins';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_penerimaan_retensi'; //daftar 
	var $TblName_Hapus = 't_penerimaan_retensi';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $totalCol = 12; //total kolom daftar
	var $fieldSum_lokasi = array();
	var $FieldSum_Cp1 = array();//berdasar mode
	var $FieldSum_Cp2 = array();	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'PENGADAAN DAN PENERIMAAN';
	var $PageIcon = 'images/pengadaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'SKPD';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'pemasukan_retensi_insForm'; 
			
	function setTitle(){
		return 'RETENSI BARANG';
	}
	
	/*function setMenuView(){
		return "";
	}*/
	
	function pageShow(){
		global $app, $Main, $DataOption; 
		
		$navatas_ = $this->setNavAtas();
		$navatas = $navatas_==''? // '0': '20';
			'':
			"<tr><td height='20'>".
					$navatas_.
			"</td></tr>";
		$form1 = $this->withform? "<form name='$this->FormName' id='$this->FormName' method='post' action=''>" : '';
		$form2 = $this->withform? "</form >": '';
		
		$cbid = $_REQUEST['pemasukan_retensi_cb'];
		if(addslashes($_REQUEST['YN']) == '1')$cbid[0]='';
			$c1input = cekPOST2('pemasukan_retensiSKPD2fmURUSAN',0);
			$cinput = cekPOST2('pemasukan_retensiSKPD2fmSKPD');
			$dinput = cekPOST2('pemasukan_retensiSKPD2fmUNIT');
			$einput = cekPOST2('pemasukan_retensiSKPD2fmSUBUNIT');
			$e1input = cekPOST2('pemasukan_retensiSKPD2fmSEKSI');
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
					"<input type='hidden' name='pemasukanSKPDfmUrusan' value='".$c1input."' />".
					"<input type='hidden' name='pemasukanSKPDfmSKPD' value='".$cinput."' />".
					"<input type='hidden' name='pemasukanSKPDfmUNIT' value='".$dinput."' />".
					"<input type='hidden' name='pemasukanSKPDfmSUBUNIT' value='".$einput."' />".
					"<input type='hidden' name='pemasukanSKPDfmSEKSI' value='".$e1input."' />".
					"<input type='hidden' name='databaru' id='databaru' value='".$_REQUEST['YN']."' />".
					"<input type='hidden' name='idubah' id='idubah' value='".$cbid[0]."' />".
					"<input type='hidden' name='pil_jns_trans' id='pil_jns_trans' value='".$_REQUEST['halmannya']."' />".
					
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
			"</table>".
			/*'<script src="assets2/js/bootstrap.min.js"></script>'.
			'<script src="assets2/jquery.min.js"></script>'.*/
			"</body>
		</html>"; 
	}	
	
	function setMenuEdit(){		
		return "";
	}
	
	function setMenuView(){
		return "";
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
	
	function cek_DataRekening(){
		global $DataPengaturan;
		$err='';
		$content=0;
		$Id_Retensi = cekPOST2($this->Prefix."_idplh");
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi_rekening", "IFNULL(SUM(jumlah),0) as jml", "WHERE refid_retensi='$Id_Retensi' AND status != '2' ");
		$dt = $qry["hasil"];
		 
		if($dt['jml'] < 1)$err="Rekening Retensi Belum Di Masukan !";
		$content=$dt['jml'];
		 
		return array("err"=>$err,"content"=>$content);
	}
	
	function cek_DataRetensi_det(){
		global $DataPengaturan;
		$err='';
		$content=0;
		$Id_Retensi = cekPOST2($this->Prefix."_idplh");
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi_det", "IFNULL(SUM(harga_total),0) as jml", "WHERE refid_retensi='$Id_Retensi' AND status != '2' ");
		$dt = $qry["hasil"];
		 
		if($dt['jml'] < 1)$err="Rincian Retensi Barang Belum Di Masukan !";
		$content=$dt['jml'];
		 
		return array("err"=>$err,"content"=>$content);
	}
	
	function cek_DataSesuai(){
		$stat = FALSE;
		$retensi = $this->cek_DataRetensi_det();
		$rekening = $this->cek_DataRekening();
		if($retensi['content'] == $rekening['content'] && $rekening['content'] != 0)$stat = TRUE;
		
		return array("jml_rek"=>$rekening['content'], "status"=>$stat);
	}
	
	function simpanUpdData($val="rekening"){
		global $DataPengaturan;
		$idplh = cekPOST2($this->Prefix.'_idplh');
		$cek='';
		//Update 
		$data = array(array("sttemp","0"),);
		$qry_upd = $DataPengaturan->QryUpdData("t_penerimaan_retensi_$val", $data, "WHERE refid_retensi='$idplh' AND status!='2' ");$cek.=$qry_upd["cek"]." | ";
		
		$del = "DELETE FROM t_penerimaan_retensi_$val WHERE refid_retensi='$idplh' AND status='2'";$cek.=$del;
		$qry_del = mysql_query($del);
		
		return $cek;
		
	}
	
	
	function simpan(){
	  global $Ref, $Main, $HTTP_COOKIE_VARS,$DataOption, $DataPengaturan;
		
		$cek = '';$err='';$content='';
		
	 	$uid = $HTTP_COOKIE_VARS['coID'];
	 	$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		
		$idplh = cekPOST2($this->Prefix.'_idplh');
		$FMST = cekPOST2($this->Prefix.'_fmST');
		
		$c1nya = cekPOST2('c1nya');
		$cnya = cekPOST2('cnya');
		$dnya = cekPOST2('dnya');
		$enya = cekPOST2('enya');
		$e1nya = cekPOST2('e1nya');
		
		$pencairan_dana = cekPOST2('pencairan_dana');
		$prog = cekPOST2('prog');
		$kegiatan = cekPOST2('kegiatan');
		$pekerjaan = cekPOST2('pekerjaan');
		$nomdok = cekPOST2('nomdok');
		
		$dokumen_sumber = cekPOST2('dokumen_sumber');
		$tgl_dokumen_bast = cekPOST2('tgl_dokumen_bast');
		$nomor_dokumen_bast = cekPOST2('nomor_dokumen_bast');
		
		$penyedian = cekPOST2('penyedian');
		$penerima = cekPOST2('penerima');
		$tgl_buku = cekPOST2('tgl_buku');
		$keterangan_penerimaan = cekPOST2('keterangan_penerimaan');
		
		$qry_TMPL = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi", "*", "WHERE Id='$idplh' ");
		$dt_TMPL = $qry_TMPL["hasil"];
		if($dt_TMPL["sttemp"] == 1){
			$tgl_buku.="-".$coThnAnggaran;
		}else{
			$tgl_buku.="-".substr($dt_TMPL["tgl_buku"],0,4);
		}
		
		if($err == "" && $pencairan_dana == "")$err="Metode Pencarian Dana Belum di Pilih !";
		if($err == "" && $prog == "")$err="Program Kegiatan Dana Belum di Isi !";
		if($err == "" && $kegiatan == "")$err="Kegiatan Belum di Pilih !";
		if($err == "" && $pekerjaan == "")$err="Pekerjaan Belum di Isi !";
		//Cek Program -----------------------------------------------------------------------------------------
		if($err == ""){
			$qry_prog = $DataPengaturan->QryHitungData("ref_program", "WHERE concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '".$prog.".$kegiatan'");
			if($qry_prog["hasil"] == 0)$err="Program Kegiatan Tidak Valid !";
		}
		if($err == "" && $nomdok == "")$err="Dokumen Kontrak Belum di Pilih !";
		//Cek Dokumen Kontrak ---------------------------------------------------------------------------------
		if($err == ""){
			$qry_nomdok = $DataPengaturan->QyrTmpl1Brs("ref_nomor_dokumen","*", "WHERE nomor_dok='$nomdok' AND c1='$c1nya' AND c='$cnya' AND d='$dnya' ");
			$dt_nomdok = $qry_nomdok["hasil"];
			if($dt_nomdok['Id'] == "" || $dt_nomdok['Id'] == NULL)$err="Dokumen Kontrak Tidak Valid !";
		}
		//Cek Rekening ---------------------------------------------------------------------------------
		if($err == ""){
			$dt_Rek = $this->cek_DataRekening();
			$err=$dt_Rek["err"];
		}
		if($err == "" && $dokumen_sumber=="")$err="Dokumen Sumber Belum di Pilih !";
		if($err == "" && $tgl_dokumen_bast=="")$err="Tanggal Dokumen Sumber Belum di Pilih !";
		if($err == ""){
			$tgl_dokumen_bast = explode("-",$tgl_dokumen_bast);
			$tgl_dokumen_bast = $tgl_dokumen_bast[2]."-".$tgl_dokumen_bast[1]."-".$tgl_dokumen_bast[0];
			if($err=='' && !cektanggal($tgl_dokumen_bast)) $err= 'Tanggal Dokumen Sumber Tidak Valid';
		}
		if($err == "" && $nomor_dokumen_bast=="")$err="Nomor Dokumen Sumber Belum di Isi !";
		
		if($err == "" && $penyedian=="")$err="Penyedia Barang Belum di Pilih !";
		if($err == "" && $penerima=="")$err="Penerima Barang Belum di Pilih !";
		if($err == "" && $tgl_buku=="")$err="Tanggal Buku Belum di Isi !";
		if($err == ""){
			$tgl_buku = explode("-",$tgl_buku);
			$tgl_buku = $tgl_buku[2]."-".$tgl_buku[1]."-".$tgl_buku[0];
			if($err=='' && !cektanggal($tgl_buku)) $err= 'Tanggal Buku Tidak Valid';
		}
		
		//Cek Detail Retensi ---------------------------------------------------------------------------------
		if($err == ""){
			$dt_Retensi = $this->cek_DataRetensi_det();
			$err=$dt_Retensi["err"];
		}
		
		//Cek Harga Sesuai -----------------------------------------------------------------------------------
		if($err == "" && $dt_Rek["content"] != $dt_Retensi["content"])$err="Total Belanja dan Rincian Retensi Barang Belum Sesuai !";
				
		//if($err=='')$err='dgdfg';
		if($err == ""){
			//Update Rekening
			$cek.=$this->simpanUpdData("rekening");			
			//Update Retensi Detail
			$cek.=$this->simpanUpdData("det");
			$program = explode(".",$prog);
			
			//Kode Retensi
			$Get_IdRetensi = $this->Get_IdRetensi();
			$id_retensi = $Get_IdRetensi["content"]; 
			
			$data_upd = array(
							array("pencairan_dana",$pencairan_dana),
							array("bk",$program[0]),
							array("ck",$program[1]),
							array("dk",$program[2]),
							array("p",$program[3]),
							array("q",$kegiatan),
							array("pekerjaan",$pekerjaan),
							array("nomor_kontrak",$nomdok),
							array("tgl_kontrak",$dt_nomdok['tgl_dok']),
							array("dokumen_sumber",$dokumen_sumber),
							array("tgl_dokumen_sumber",$tgl_dokumen_bast),
							array("no_dokumen_sumber",$nomor_dokumen_bast),
							array("tgl_buku",$tgl_buku),
							array("id_retensi",$id_retensi),
							array("refid_penyedia",$penyedian),
							array("refid_penerima",$penerima),
							array("keterangan_penerimaan",$keterangan_penerimaan),
							array("sttemp","0"),
							array("tahun",$coThnAnggaran),
							array("uid",$uid),
						);
			$qry_upd = $DataPengaturan->QryUpdData("t_penerimaan_retensi", $data_upd, "WHERE Id='$idplh' AND c1='$c1nya' AND c='$cnya' AND d='$dnya' AND e='$enya' AND e1='$e1nya'");$cek.=$qry_upd["cek"];
			
		}
					
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	/*function setTopBar(){
	   	return '';
	}*/
	
	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
		
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function set_selector_other($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	  
	  switch($tipe){
	  			
		case 'SimpanSemua':{
			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }		
			
		case 'BatalSemua':{
			$get= $this->BatalSemua();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'TotalBelanja':{
			$get= $this->TotalBelanja();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'DetailRetensi_Form':{
			$get= $this->DetailRetensi_Form();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'HapusRincianRetensi':{
			$get= $this->HapusRincianRetensi();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'Edit_DetailRetensi_Form':{
			$IdRetensi = cekPOST2("IdRetensi");
			
			$get= $this->DetailRetensi_Form($IdRetensi, 1);
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'getDataBI':{
			$get= $this->getDataBI();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'SimpanDet':{
			$get= $this->SimpanDet();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'Tabel_DetailRetensi_Form':{
			$get= $this->Tabel_DetailRetensi_Form();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
	   
		case 'tabelRekening':{
			$idplh = cekPOST2($this->Prefix.'_idplh');
			
			if(addslashes($_REQUEST['HapusData'])==1){	
				$qrydel1 = "DELETE FROM t_penerimaan_retensi_rekening WHERE refid_retensi='$idplh' AND status='1' ";
				$aqrydel1 = mysql_query($qrydel1);
			}
			$get= $this->tabelRekening();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'InsertRekening':{
			$get= $this->Rek_InsertRekening();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];	
		break;
	    }
		
		case 'updKodeRek':{
			$get= $this->Rek_updKodeRek();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];	
		break;
	    }
		
		case 'HapusRekening':{
			$get= $this->Rek_HapusRekening();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];					
		break;
	    }
		
		case 'jadiinput':{
			$get= $this->Rek_jadiinput();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];					
		break;
	    }
		
		case 'Get_IdRetensi':{
			$get= $this->Get_IdRetensi();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];					
		break;
	    }
			
		case 'namarekening':{
			$cek = '';
			$err = '';
			$content = '';
			$idrek = $_REQUEST['idrek'];
			$koderek = addslashes($_REQUEST['koderek']);
			
			$qry = "SELECT nm_rekening FROM ref_rekening WHERE concat(k,'.',l,'.',m,'.',n,'.',o) = '$koderek' AND k<>'0' AND l<>'0' AND m<>'0' AND n<>'00' AND o<>'00'"; $cek.=$qry;
			$aqry = mysql_query($qry);
			$daqry = mysql_fetch_array($aqry);
			$content['namarekening'] = $daqry['nm_rekening'];
			$content['idrek'] = $idrek;
			
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
			 "<script src='js/skpd.js' type='text/javascript'></script>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/pencarian/cariprogram.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/pencarian/cariRekening.js' language='JavaScript' ></script>".
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/upload_style.css' type='text/css'>".
			"<script src='js/jquery.js' type='text/javascript'></script>".			
			"<script src='js/jquery-ui.js' type='text/javascript'></script>".
			"<script src='js/jquery.min.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/jquery.form.js'></script> ".
			"<script src='js/jquery-ui.custom.js'></script>".
			"<script type='text/javascript' src='js/master/ref_dokumen_kontrak/ref_dokumen_kontrak.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/pencarian/cariIDBI.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/pengadaanpenerimaan/pemasukan_ins.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/pengadaanpenerimaan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
			 ".
			 '
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>
			'.
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".
			
			$scriptload;
	}
	
	
	
	function genDaftarOpsi(){
	 global $Ref, $Main, $HTTP_COOKIE_VARS, $DataOption, $DataPengaturan;
	 $coThnAnggaran = $_COOKIE['coThnAnggaran']; 
	 
	$arr = array(
			//array('selectAll','Semua'),	
			array('selectSatuan','Satuan'),		
			);
		
	$cara_perolehan = array(
			//array('selectAll','Semua'),	
			array('1','PEMBELIAN'),	
			array('2','HIBAH'),			
			array('3','LAINNYA'),			
			);
	
	
	
	$arr_dokumen_sumber = array(
			array('1', "BAST"),
			array('2', "BAKF"),
			array('3', "BA HIBAH"),
			array('4', "SURAT KEPUTUSAN"),
			);
			
	$arr_biayaatribusi = array(
			//array('selectAll','Semua'),	
			array('1','YA'),		
			array('0','TDK'),		
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
	$fmORDER1 = cekPOST2('fmORDER1');
	$fmDESC1 = cekPOST2('fmDESC1');
	
	if(isset($_REQUEST['databaru'])){
		if(addslashes($_REQUEST['databaru'] == '1')){
			$c1input = cekPOST2('pemasukanSKPDfmUrusan');
			$cinput = cekPOST2('pemasukanSKPDfmSKPD');
			$dinput = cekPOST2('pemasukanSKPDfmUNIT');
			$einput = cekPOST2('pemasukanSKPDfmSUBUNIT');
			$e1input = cekPOST2('pemasukanSKPDfmSEKSI');
			
			if($c1input == '' && $DataOption['skpd'] == 1)$c1input=0;
			
			$uid = $HTTP_COOKIE_VARS['coID'];
			
			$qrybarupenerimaan = "INSERT INTO t_penerimaan_retensi (c1,c,d,e,e1,uid,sttemp) values ('$c1input', '$cinput', '$dinput', '$einput', '$e1input', '$uid', '1')";
			$aqrybarupenerimaan = mysql_query($qrybarupenerimaan);
			
			$tmpl = "SELECT * FROM t_penerimaan_retensi WHERE c1='$c1input' AND c='$cinput' AND d='$dinput' AND e='$einput' AND e1='$e1input' AND uid = '$uid' AND sttemp='1' ORDER BY Id DESC ";
			$qrytmpl = mysql_query($tmpl);
			$dataqrytmpl = mysql_fetch_array($qrytmpl);
			
			//Tambahan 
			$pekerjaan="";
			$program='';
			
			$cara_bayar = '3';
			$dokumen_sumber = 'SP2D';
			$tgl_dokumen_bast = date('d-m-Y');
			$nomor_dokumen_bast = '';
			$keterangan_penerimaan = '';
			$penyedia = '';
			$penerima = $HTTP_COOKIE_VARS['CoPenerima'];
			//$tgl_buku = date('d-m-Y');
			$tgl_buku = date('d-m');
			$thn_buku = $coThnAnggaran;
			$biayaatribusi = $DataOption['harga_atribusi'];
			$pencairan_dana = "1";
		}else{
			
			$IDUBAH = $_REQUEST['idubah'];
			$qrytmpl = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi","*"," WHERE Id='$IDUBAH' ORDER BY Id DESC ");
			$dataqrytmpl = $qrytmpl["hasil"];
			
			$pekerjaan=$dataqrytmpl['pekerjaan'];
			$nomdok=$dataqrytmpl['nomor_kontrak'];
			$tgl_dok=$dataqrytmpl['tgl_kontrak'];
			$tgl_dokcopy=explode("-",$tgl_dok);
			$tgl_dokcopy=$tgl_dokcopy[2]."-".$tgl_dokcopy[1]."-".$tgl_dokcopy[0];
			
			$bknya=$dataqrytmpl['bk'];
			$cknya=$dataqrytmpl['ck'];
			$dknya=$dataqrytmpl['dk'];
			$p=$dataqrytmpl['p'];
			$kegiatan=$dataqrytmpl['q'];
			
			$programnya = $DataPengaturan->GetProgKeg2($bknya,$cknya,$dknya,$p);
			$prog = $bknya.".".$cknya.".".$dknya.".".$p;
			
			$cara_bayar = $dataqrytmpl['cara_bayar'];
			$dokumen_sumber = $dataqrytmpl['dokumen_sumber'];
			$tgl_dokumen_bast = explode("-",$dataqrytmpl['tgl_dokumen_sumber']);
			$tgl_dokumen_bast = $tgl_dokumen_bast[2]."-".$tgl_dokumen_bast[1]."-".$tgl_dokumen_bast[0];
			$nomor_dokumen_bast = $dataqrytmpl['no_dokumen_sumber'];
			$penyedia = $dataqrytmpl['refid_penyedia'];
			$penerima = $dataqrytmpl['refid_penerima'];
			$tgl_buku = explode("-",$dataqrytmpl['tgl_buku']);
			//$tgl_buku = $tgl_buku[2]."-".$tgl_buku[1]."-".$tgl_buku[0];
			$thn_buku = $tgl_buku[0];
			$tgl_buku = $tgl_buku[2]."-".$tgl_buku[1];
			$biayaatribusi = $dataqrytmpl['biayaatribusi'];
			$keterangan_penerimaan = $dataqrytmpl['keterangan_penerimaan'];
			$pencairan_dana = $dataqrytmpl['pencairan_dana'];			
		}
		
	}
	
	
	
	$idplhnya = $dataqrytmpl['Id'];
	$c1 = $dataqrytmpl['c1'];
	$c = $dataqrytmpl['c'];
	$d = $dataqrytmpl['d'];
	$e = $dataqrytmpl['e'];
	$e1 = $dataqrytmpl['e1'];
		
	$qrysumber_dn = "SELECT nama,nama FROM ref_sumber_dana";$cek.=$qrysumber_dn;
	
	$qrypenyedia = "SELECT id,nama_penyedia FROM ref_penyedia WHERE c1= '$c1' AND c='$c' AND d='$d'";
	
	$qrypenerima = "SELECT Id,nama FROM ref_tandatangan WHERE c1= '$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1'";$cek.=$qrypenerima;
	
	$qry_dokumen_sumber = "SELECT nama_dokumen,nama_dokumen FROM ref_dokumensumber ";
		
	
	$qrykegitan = "SELECT q,concat (IF(LENGTH(q)=1,concat('0',q), q),'. ',nama) as nama FROM ref_program WHERE bk='$bknya' AND ck='$cknya' AND dk='$dknya' AND p='$p' AND q!='0'";
	$qrynomdok = "SELECT nomor_dok,nomor_dok FROM ref_nomor_dokumen  WHERE c1='$c1' AND c='$c' AND d='$d' AND tgl_dok < '".$coThnAnggaran."-01-01' ";
		
	$TampilOpt =
			
			
			$vOrder="<input type='hidden' name='".$this->Prefix.".idplh' id='".$this->Prefix.".idplh' value='$dataqrytmpl' />".
				$DataPengaturan->GenViewHiddenSKPD($c1, $c, $d, $e, $e1).
				$DataPengaturan->GenViewSKPD($c1, $c, $d, $e, $e1).				
				genFilterBar(
				array(
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>'TRANSAKSI',
								'name'=>'transaksi',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='jns_trans' name='jns_transaksi' value='RETENSI BARANG' readonly style='width:300px;' />"
							),
							array(
								'label'=>'CARA PEROLEHAN',
								'name'=>'asalusul',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='asalusul' name='asalusul' value='PEMBELIAN' readonly style='width:300px;' />",
							),
							array(
								'label'=>'SUMBER DANA',
								'name'=>'sumberdana',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='sumberdana' name='sumberdana' value='APBD' readonly style='width:300px;' />",
							),
							array(
								'label'=>'METODE PENGADAAN',
								'name'=>'metodepengadaan',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='metodepengadaan' name='metodepengadaan' value='PIHAK KE 3' readonly style='width:300px;' />",
							),
							array(
								'label'=>'MEKANISME PENCAIRAN DANA',
								'name'=>'pencairan_dana',
								'label-width'=>'200px;',
								'value'=>cmbArray('pencairan_dana',$pencairan_dana,$DataPengaturan->arr_pencairan_dana,"--- PILIH MEKANISME PENCAIRAN DANA ---", "style='width:300px;'"),
							),
							array(
								'label'=>'PROGRAM',
								'name'=>'program',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='program' value='$programnya' readonly id='program' style='width:500px;' /> "."<input type='button' name='progcar' id='progcar' value='CARI' onclick='pemasukan_ins.CariProgram()' />"."
									
									<input type='hidden' name='prog' value='$prog' id='prog' />
								",
							),
							array(
								'label'=>'KEGIATAN',
								'name'=>'kegiatan',
								'label-width'=>'200px;',
								'value'=>"<div id='dafkeg'>".cmbQuery('kegiatan1',$kegiatan,$qrykegitan,"$kegiatanDSBL style='width:500px;' onchange='document.getElementById(`kegiatan`).value=this.value;' ",'--- PILIH KEGIATAN ---')."<input type='hidden' name='kegiatan' value='$kegiatan' id='kegiatan' /></div>"
										
								,
							),
							array(
								'label'=>'PEKERJAAN',
								'name'=>'pekerjaan',
								'label-width'=>'140px',
								'type'=>'text',
								'value'=>$pekerjaan,
								'parrams'=>"style='width:500px;' placeholder='PEKERJAAN'",
							),	
							array(
								'label'=>'DOKUMEN KONTRAK',
								'name'=>'dokumensumber',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='tgl_dokcopy' value='$tgl_dokcopy' id='tgl_dokcopy' readonly style='width:100px;' /> "."<input type='text' name='nomdok_copy' value='$nomdok' id='nomdok_copy' readonly style='width:397px;' /> ".
								
								"<input type='hidden' name='tgl_dok' id='tgl_dok' value='$tgl_dok' /> ".
								"<input type='hidden' name='nomdok' id='nomdok' value='$nomdok' /> ".
								"
								<span id='TombolPilih'></span>
								</span> ".
								"<input type='button' name='cari_dokumen' id='cari_dokumen' value='CARI' onclick='".$this->Prefix.".CariDokumenKontrak()' />"
										
								,
							),			
						)
					).
					'<span id="pilCaraPerolehan"></span>'
				
				),'','','').
				
					"
					<input type='hidden' name='jns_dari_rek' id='jns_dari_rek' value='1' />
					<div id='tbl_rekening' style='width:100%;'></div>".
								
				genFilterBar(
				array(
					"<span id='totalbelanja23'></span>".
					$DataPengaturan->isiform(
						array(
								array(
									'label'=>'PEMBAYARAN',
									'label-width'=>'200px;',
									'type'=>'text',
									'value'=>"LUNAS",
									'parrams'=>"style='width:150px;text-align:left' readonly"
								),
								array(
									'label'=>'ID RETENSI',
									'label-width'=>'200px;',
									'type'=>'text',
									'name'=>'idretensi',
									'value'=>'',
									'parrams'=>"style='width:300px;text-align:left' readonly"
									,
								),
								array(
								'label'=>'DOKUMEN SUMBER',
								'name'=>'dokumensumber',
								'label-width'=>'200px;',
								'value'=>cmbQuery('dokumen_sumber',$dokumen_sumber,$qry_dokumen_sumber," style='width:303px;' ",'--- PILIH DOKUMEN SUMBER ---')."<span id='UntukDokumenSumber'></span>"
										
								,						
								),
								array(
								'label'=>'TANGGAL DAN NOMOR',
								'name'=>'dokumensumber',
								'label-width'=>'200px;',
								'value'=>"<span id='UntukTanggalBAST'><input type='text' name='tgl_dokumen_bast' id='tgl_dokumen_bast' class='datepicker' value='$tgl_dokumen_bast' style='width:80px;' /></span> <input type='text' name='nomor_dokumen_bast' placeholder='NOMOR' id='nomor_dokumen_bast' value='$nomor_dokumen_bast' style='width:258px;' /> "
										
								,						
								),
								array(
									'label'=>'PENYEDIA BARANG',
									'label-width'=>'200px;',
									'value'=>"<span id='det_dafpenyedia'><span id='dafpenyedia'>".cmbQuery('penyedian',$penyedia,$qrypenyedia," style='width:303px;' onchange='".$this->Prefix.".OptionPenyedia();'",'--- PILIH PENYEDIA BARANG ---')."</span> ".
											"<input type='button' id='BaruPenyedia' name='BaruPenyedia' value='BARU' onclick='pemasukan_ins.BaruPenyedia()' /></span><span id='OptPenyedia'></span>"
									,
								),
								array(
									'label'=>'PENERIMA BARANG',
									'label-width'=>'200px;',
									'value'=>"<span id='det_dafpenerima'><span id='dafpenerima'>".cmbQuery('penerima',$penerima,$qrypenerima," style='width:303px;' onchange='".$this->Prefix.".SetPenerima();'",'--- PILIH PENERIMA BARANG ---')."</span> ".
											"<input type='button' onclick='pemasukan_ins.BaruPenerima()' name='BaruPenerima' value='BARU' /></span><span id='OptPenerima'></span>"
									,					
								),
								array(
								'label'=>'TANGGAL BUKU',
								'name'=>'dokumensumber',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='tgl_buku' id='tgl_buku' value='$tgl_buku' style='width:40px;' class='datepicker2'  />"." <input type='text' name='thn_buku' id='thn_buku' value='$thn_buku' style='width:40px;' readonly />"
										
								,						
								),
								array(
								'label'=>'KETERANGAN',
								'name'=>'keterangan_penerimaan',
								'label-width'=>'200px;',
								'value'=>"<textarea name='keterangan_penerimaan' style='width:300px;height:50px;' placeholder='KETERANGAN'>".$keterangan_penerimaan."</textarea>
								",
							),
								
						)
					)
				
				),'','','').
				
				genFilterBar(
				array(
					"<span id='inputpenerimaanbarang' style='color:black;font-size:14px;font-weight:bold;'/>INPUT RETENSI BARANG</span>",
					
				
				),'','','').
				"<div id='databarangnya'></div>".
				genFilterBar(
				array(
					"<a href='javascript:".$this->Prefix.".Tabel_DetailRetensi_Form();'><span id='rincianpenerimaanbarang' style='color:black;font-size:14px;font-weight:bold;' />RINCIAN RETENSI BARANG</span></a>",
					
				
				),'','','').
				"<div id='rinciandatabarangnya'></div>".
				genFilterBar(
				array(
					"
					<input type='hidden' name='KodeTemplateBarang' id='KodeTemplateBarang' value='' />
					<input type='hidden' name='".$this->Prefix."_idplh' id='".$this->Prefix."_idplh' value='$idplhnya' />".
					"<table>
						<tr>
							<td><span id='selesaisesuai'>".$DataPengaturan->buttonnya($this->Prefix.'.SimpanSemua()','save_f2.png','SIMPAN','SIMPAN','SIMPAN')."</span></td>
							<td>".$DataPengaturan->buttonnya($this->Prefix.'.BatalSemua()','cancel_f2.png','BATAL','BATAL','BATAL')."</td>
						</tr>".
					"</table>",
					
				
				),'','','')
								
			;
			
			
		return array('TampilOpt'=>$TampilOpt);
	}				
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$arrKondisi = array();	
		$fmJns = $_REQUEST['fmJns'];
		$crSyarat = $_REQUEST['syarat'];
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		$pemasukan_ins_idplh = cekPOST("pemasukan_ins_idplh");
		
		
		switch($fmPILCARI){			
			
			case 'selectNama': $arrKondisi[] = " nama_rek like '%$fmPILCARIvalue%'"; break;	
			case 'selectRuang': $arrKondisi[] = " syarat like '%$fmPILCARIvalue%'"; break;	
								 	
		}	
		//$arrKondisi[] = " refid_terima = '$pemasukan_ins_idplh'" ;
		$arrKondisi[] = " sttemp = '0'" ;
		
		
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
	
	function setPage_HeaderOther(){
		return "";
	}
	
	function tabelRekening(){
		global $DataPengaturan, $Main;
		$cek = '';
		$err = '';
		$jml_harga=0;
		$datanya='';
		
		$refid = addslashes($_REQUEST[$this->Prefix."_idplh"]);			
		
		$qry = "SELECT a.*,b.nm_rekening FROM t_penerimaan_retensi_rekening a LEFT JOIN ref_rekening b ON a.k=b.k AND a.l=b.l AND a.m=b.m AND a.n=b.n AND a.o=b.o WHERE a.refid_retensi = '$refid' AND status != '2' ORDER BY Id DESC";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		while($dt = mysql_fetch_array($aqry)){
			if($dt['status'] == '0'){
				$kode = "
					<a href='javascript:".$this->Prefix.".jadiinput(`".$dt['Id']."`,`".$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o']."`);' />
						".$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o']."
					</a>
					";
					
				if($kode_account_ap != "" && $Main->BIRMS == 1 && $olahBIRM == FALSE)$kode=$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o'];
				
				$idrek = '';
				
				$jumlahnya = number_format($dt['jumlah'],2,",",".");
				$btn ="
				<a href='javascript:".$this->Prefix.".HapusRekening(`".$dt['Id']."`)' />
					<img src='datepicker/remove2.png' style='width:20px;height:20px;' />
				</a>";
				
				
			}
			
			if($dt['status'] == '1'){
			// DENGAN INPUTAN TEXT
				$kode = "<input type='text' onkeyup='setTimeout(function myFunction() {".$this->Prefix.".namarekening();},100);' name='koderek' id='koderek' value='".$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o']."' style='width:80px;' maxlength='12' />"
				."<a href='javascript:cariRekening.windowShow(".$dt['Id'].");'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>"
				;
						 
				$idrek = "<input type='hidden' name='idrek' id='idrek' value='".$dt['Id']."' />".
						"<input type='hidden' name='statidrek' id='statidrek' value='".$dt['status']."' />";
				
				$jumlahnya = "
					
							<input type='text' name='jumlahharga' id='jumlahharga' value='".floatval($dt['jumlah'])."' style='text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = pemasukan_ins.formatCurrency(this.value);' />
							<span id='formatjumlah'></span>
							
						";
				
				$btn ="
						<a href='javascript:".$this->Prefix.".updKodeRek()' />
							<img src='datepicker/save.png' style='width:20px;height:20px;' />
						</a>
						";
			}
			
			$Kolom_BTN = "<td class='GarisDaftar' align='center'>
								<span id='option_".$dt['Id']."'>$btn</span>
							</td>";
			if($kode_account_ap != "" && $Main->BIRMS == 1 && $olahBIRM == FALSE)$Kolom_BTN='';
			$datanya.="
				<tr class='row0'>
					<td class='GarisDaftar' align='right'>$no</td>
					<td class='GarisDaftar' align='center'>
						<span id='koderekeningnya_".$dt['Id']."' >
							$kode $idrek
						</span>
					</td>
					<td class='GarisDaftar'>
						<span id='namaakun_".$dt['Id']."'>".$dt['nm_rekening']."</span>
					</td>
					<td class='GarisDaftar' align='right'>
						<span id='jumlanya_".$dt['Id']."'>$jumlahnya</span>
					</td>
					$Kolom_BTN
				</tr>
			";
			$no = $no+1;
			$jml_harga = $jml_harga+floatval($dt['jumlah']);
		}
		
		// KodeBIRM 
		$TombolBaru = "<a href='javascript:".$this->Prefix.".BaruRekening()' /><img src='datepicker/add-256.png' style='width:20px;height:20px;' /></a>";
		
		$Kolom_BTN_TombolBaru = "<th class='th01'>
									<span id='atasbutton'>
									$TombolBaru
									</span>
								</th>";
								
		if($kode_account_ap != "" && $Main->BIRMS == 1 && $olahBIRM == FALSE)$Kolom_BTN_TombolBaru='';				
					
		$content['tabel'] =
			genFilterBar(
				array("
					<table class='koptable' style='min-width:780px;' border='1'>
						<tr>
							<th class='th01'>NO</th>
							<th class='th01' width='50px'>KODE REKENING</th>
							<th class='th01'>NAMA REKENING BELANJA</th>
							<th class='th01'>JUMLAH (Rp)</th>
							$Kolom_BTN_TombolBaru
						</tr>
						$datanya
						
					</table>"
				)
			,'','','')
		;
		
		$content['atasbutton'] = "<a href='javascript:".$this->Prefix.".tabelRekening()' /><img src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>";
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function TotalBelanja(){
		global $DataPengaturan, $Main;
		$cek = '';
		$err = '';
		
		$refid = cekPOST2($this->Prefix."_idplh");
		
		$totbel = "<span style='font-weight:bold;color:red;'>TOTAL HARGA BELUM SESUAI</span>";
		$checked = "";
		$cek_DataSesuai = $this->cek_DataSesuai();
		if($cek_DataSesuai["status"] == TRUE){
			$totbel = "<span style='font-weight:bold;color:black;'>TOTAL HARGA SESUAI</span>";
			$checked=" CHECKED ";
		}
		
		
		$jml_harga=$cek_DataSesuai["jml_rek"];
		$content['jumlah'] = 
				$DataPengaturan->isiform(
						array(
								array(
									'label'=>'TOTAL BELANJA',
									'label-width'=>'200px;',
									'name'=>'totalbelanja',
									'value'=>"<input type='text' name='totalbelanja' id='totalbelanja' value='".number_format($jml_harga,2,",",".")."' style='width:150px;text-align:right' readonly /><span id='jumlahsudahsesuai'><input type='checkbox' name='jumlah_sesuai' value='1' id='jumlah_sesuai' style='margin-left:20px;' disabled $checked />$totbel</span>",
									
								),
						)
				);
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Rek_InsertRekening(){
		global $HTTP_COOKIE_VARS;
		
		$cek = '';$err = '';$content = '';		
		$uid = $HTTP_COOKIE_VARS['coID'];
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$idplh = cekPOST2($this->Prefix.'_idplh');
		
		$qrydel = "DELETE FROM t_penerimaan_retensi_rekening WHERE refid_retensi='$idplh' AND status='1' AND uid='$uid'";
		$aqrydel = mysql_query($qrydel);
		
		if($aqrydel){
			$qry="INSERT INTO t_penerimaan_retensi_rekening (refid_retensi, status,uid, sttemp,tahun) values ('$idplh','1','$uid','1','$coThnAnggaran')";$cek.=$qry;
			$aqry = mysql_query($qry);
			if($aqry){
				$content = 1;
			}else{
				$err= 'Gagal !';
			}
		}	
			
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function Rek_updKodeRek(){
		global $HTTP_COOKIE_VARS;
		
		$cek = '';$err = '';$content = '';
		$uid = $HTTP_COOKIE_VARS['coID'];
		$idplh = cekPOST2($this->Prefix.'_idplh');
		$idrek = $_REQUEST['idrek'];
		$koderek = $_REQUEST['koderek'];
		$jumlahharga = $_REQUEST['jumlahharga'];
		if($jumlahharga < 1 && $err=='')$err='Jumlah Harga Belum Di Isi !';
		
		$qry = "SELECT nm_rekening FROM ref_rekening WHERE concat(k,'.',l,'.',m,'.',n,'.',o) = '$koderek' AND k != '0' AND l != '0' AND m != '0' AND n != '00' AND o != '00'"; $cek.=$qry;
		$aqry = mysql_query($qry);
		
		if(mysql_num_rows($aqry) == 0 && $err=='')$err = "KODE REKENING TIDAK VALID !";
		
		if($err==''){
			$kode = explode(".",$koderek);
			$knya = $kode[0];
			$lnya = $kode[1];
			$mnya = $kode[2];
			$nnya = $kode[3];
			$onya = $kode[4];
			if($_REQUEST['statidrek'] == '1'){
				$qryupd="UPDATE t_penerimaan_retensi_rekening SET k='$knya',l = '$lnya',m = '$mnya', n= '$nnya',o= '$onya', jumlah='$jumlahharga', status='0' WHERE refid_retensi='$idplh' AND Id='$idrek'";
			}else{
				$qryupd="INSERT INTO t_penerimaan_retensi_rekening (k,l,m,n,o,status,refid_retensi,sttemp,uid,jumlah)values('$knya','$lnya','$mnya','$nnya','$onya','0','$idplh','0','$uid','$jumlahharga')";
				$updq = "UPDATE t_penerimaan_retensi_rekening SET status = '2' WHERE Id='$idrek'";
				$aupdq = mysql_query($updq); 
			}
			$cek.=" | ".$qryupd;
			$aqryupd = mysql_query($qryupd);
			if($aqryupd){
				$content['koderek'] = "<a href='javascript:".$this->Prefix.".jadiinput(`".$idrek."`);' />".$koderek."</a>";
				$content['jumlahnya'] = number_format($jumlahharga,2,",",".");
				$content['idrek'] = $idrek;
				$content['option'] = "
			<a href='javascript:".$this->Prefix.".HapusRekening(`$idrek`)' />
				<img src='datepicker/remove2.png' style='width:20px;height:20px;' />
			</a>";
			}else{
				$err= 'Gagal !';
			}
		}
			
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);			
	}
	
	function Rek_HapusRekening(){
		global $HTTP_COOKIE_VARS;
		
		$cek = '';$err = '';$content = '';
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		$idrekei = $_REQUEST['idrekei'];
		$idplh = cekPOST2($this->Prefix.'_idplh');
		
		$qrydel = "UPDATE t_penerimaan_retensi_rekening SET status='2' WHERE Id='$idrekei'";$cek.=$qrydel;
		$aqrydel = mysql_query($qrydel);
		
		$qrydel1 = "DELETE FROM t_penerimaan_retensi_rekening WHERE refid_retensi='$idplh' AND status='1' AND uid='$uid'";
		$aqrydel1 = mysql_query($qrydel1);
		
		if(!$aqrydel)$err='Gagal Menghapus Data Rekening';
		if(!$aqrydel1)$err='Gagal Menghapus Data Rekening';
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Rek_jadiinput(){
		global $HTTP_COOKIE_VARS;
		
		$cek = '';$err = '';$content = '';
		$uid = $HTTP_COOKIE_VARS['coID'];
		$idrek = $_REQUEST['idrekeningnya'];
		
		$qry = "SELECT * FROM t_penerimaan_retensi_rekening WHERE Id='$idrek'";$cek.=$qry;
		$aqry = mysql_query($qry);
		$dt = mysql_fetch_array($aqry);
		
		$content['koderek'] = "
			<input type='text' onkeyup='setTimeout(function myFunction() {".$this->Prefix.".namarekening();},100);' name='koderek' id='koderek' value='".$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o']."' style='width:80px;' maxlength='11' />
			"."<input type='hidden' name='idrek' id='idrek' value='".$idrek."' />".
			"<input type='hidden' name='statidrek' id='statidrek' value='".$dt['status']."' />
			<a href='javascript:cariRekening.windowShow(".$dt['Id'].");'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>
			";
		
		$content['jumlahnya'] = "<input type='text' name='jumlahharga' id='jumlahharga' value='".floatval($dt['jumlah'])."' style='text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = pemasukan_ins.formatCurrency(this.value);' />
						<span id='formatjumlah'></span>";
		$content['idrek'] = $idrek;
		$content['option'] = "
			<a href='javascript:".$this->Prefix.".updKodeRek()' />
				<img src='datepicker/save.png' style='width:20px;height:20px;' />
			</a>";
		$content['atasbutton'] = "<a href='javascript:".$this->Prefix.".tabelRekening()' /><img src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>";
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
			
	}
	
	function DetailRetensi_Form($Id_retensi_det='', $fmst=0){
		global $Main, $DataPengaturan,$DataOption;
		
		$cek='';$err='';$content='';
		
		$Id_retensi = cekPOST2($this->Prefix."_idplh");
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi","*", "WHERE Id='$Id_retensi' ");
		$dt = $qry["hasil"];	
		
		$c1 = $dt['c1'];
		$c = $dt['c'];
		$d = $dt['d'];
		$e = $dt['e'];
		$e1 = $dt['e1'];
		$WHEREC1 = '';
		if($DataOption['skpd'] != '1')$WHEREC1 = "c1='$c1' AND";
		$qry_unitkerja = "SELECT e, concat(e,'.',nm_skpd) as nm_skpd FROM ref_skpd WHERE $WHEREC1 c='$c' AND d='$d' AND e!='00' GROUP BY e";
		
		
		
		$unitkerja='';
		$subUnit='';
		$dt_det['kodebarangnya']='';
		$dt_det['nm_barang']='';
		$dt_det['noreg']='';
		$dt_det['thn_perolehan']='';
		$dt_det['ket_barang']='';
		$dt_det['harga_total']=0;
		$dt_det['keterangan']='';
		$dt_det['ket_barang']='';
		//SELECT a.*,b.nm_skpd, b.e as skpd_e, b.e1 as skpd_e1, b.nm_barang,b.noreg, b.thn_perolehan FROM t_penerimaan_retensi_det a LEFT JOIN v1_bi_skpd b ON a.id_bi=b.id WHERE a.refid_retensi='$idRetensi' AND status!='2' 
		if($fmst != 0 && $Id_retensi_det != ''){
			$qry_det = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi_det a LEFT JOIN v1_bi_skpd b ON a.id_bi=b.id", "a.*,b.nm_skpd, b.e as skpd_e, b.e1 as skpd_e1, b.nm_barang,b.noreg, b.thn_perolehan", "WHERE a.refid_retensi='$Id_retensi' AND status!='2' AND a.Id='$Id_retensi_det' ");
			$dt_det=$qry_det["hasil"];
			$subUnit=$dt_det['e'].".".$dt_det['e1'].". ".$dt_det['nm_skpd'];
			$unitkerja=$dt_det['e'];
			$dt_det['ket_barang']=$DataPengaturan->AmbilUraianBarang($dt_det['id_bi']);
			$dt_det['kodebarangnya']=$dt_det['f'].'.'.$dt_det['g'].'.'.$dt_det['h'].'.'.$dt_det['i'].'.'.$dt_det['j'];
			if($DataOption['kode_barang'] == 2)$dt_det['kodebarangnya']=$dt_det['f1'].'.'.$dt_det['f2'].'.'.$dt_det['kodebarangnya'];
			
		}
		
		$style1 = "style='width:70px;text-align:right;' readonly";
		
		$content = genFilterBar(
				array(
					"<span id='totalbelanja23'></span>".
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>'UNIT KERJA',
								'label-width'=>'200px;',
								'value'=>cmbQuery('unitkerja',$unitkerja,$qry_unitkerja, "style='width:455px;'","--- UNIT KERJA ---","-")." <input type='button' name='caribarang' id='caribarang' value='CARI' onclick='".$this->Prefix.".cariBarangBI();'/> ",
							),
							array( 
								'label'=>'SUBUNIT',
								'name'=>'SUBUNIT',
								'value'=>$subUnit, 
								'type'=>'text',
								'parrams'=>"style='width:503px;' readonly"
							),
							array(
								'label'=>'KODE BARANG',
								'value'=>
									InputTypeText("kodebarang", $dt_det['kodebarangnya'], "onkeyup='cariBarang.pilBar2(this.value)' placeholder='KODE BARANG' style='width:150px;' readonly")." ".
									InputTypeText("namabarang", $dt_det['nm_barang'], "style='width:350px;' readonly"),
							),
							array( 
								'label'=>'NOREG/ TAHUN PEROLEHAN',
								'name'=>'noreg',
								'value'=>
									InputTypeText("noreg",$dt_det['noreg'], "$style1 placeholder='NOREG'")." / ".InputTypeText("tahun", $dt_det['thn_perolehan'], "$style1 placeholder='TAHUN'"), 
							),	
							array(
								'label'=>'MERK / TYPE/ SPESIFIKASI/ JUDUL/ LOKASI',
								'label-width'=>'200px;',
								'value'=>
									InputTypeTextArea("keteranganbarang", $dt_det['ket_barang'], "style='width:300px;height:50px;' placeholder='MERK / TYPE/ SPESIFIKASI/ JUDUL/ LOKASI' readonly"),
							),	
							array(
								'label'=>'BIAYA RETENSI',
								'value'=>
									InputTypeText("harga_satuan", floatval($dt_det['harga_total']), "style='width:150px;text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`harga_satuannya`).innerHTML = pemasukan_ins.formatCurrency(this.value);pemasukan_ins.hitungjumlahHarga();'")." Rp ".
									LabelSPan1("harga_satuannya", FormatUang($dt_det['harga_total'])),
							),	
							array(
								'label'=>'URAIAN',
								'value'=>InputTypeTextArea("uraian_retensi", $dt_det['keterangan'], "style='width:300px;height:50px;' placeholder='URAIAN RETENSI' "),
							),
							array(
								'label'=>'',
								'pemisah'=>"",
								'value'=>
									InputTypeButton("SIMPAN_DET", "SIMPAN", "onclick='".$this->Prefix.".SimpanDet()' title='Simpan Rincian Retensi'")." ".
									InputTypeButton("CLEAR_DET", "CLEAR", "onclick='".$this->Prefix.".DetailRetensi_Form()' title='Bersihkan Form Rincian Retensi'")
								,
							),					
						)
					)
				
				),'','','').
				InputTypeHidden("id_bukuinduk", $dt_det['id_bi']).
				InputTypeHidden("idplh_retensi_det", $dt_det['Id']).
				InputTypeHidden("FMST_retensi_det", $fmst);
				
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function getDataBI(){
		global $DataPengaturan,$DataOption;
		$cek='';$err='';$content=array();
		
		$id_bukuinduk = cekPOST2("id_bukuinduk");
		
		$qry = $DataPengaturan->QyrTmpl1Brs("v1_bi_skpd", "*", "WHERE id='$id_bukuinduk' ");
		$dt = $qry["hasil"];
		
		$content['subunit']=$dt["e"].".".$dt["e1"].". ".$dt["nm_skpd"];
		$content['kode_barang']=$dt["f"].".".$dt['g'].".".$dt['h'].".".$dt['i'].".".$dt['j'];
		if($DataOption['kode_barang'] != 1)$content['kode_barang']=$dt["f1"].".".$dt['f2'].".".$content['kode_barang'];
		$content['nm_barang']=$dt["nm_barang"];
		$content['noreg']=$dt["noreg"];
		$content['thn_perolehan']=$dt["thn_perolehan"];
		$content['keteragan']=$DataPengaturan->AmbilUraianBarang($id_bukuinduk);
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function SimpanDet(){
		global $DataPengaturan,$DataOption,$HTTP_COOKIE_VARS;
		$cek='';$err='';$content=array();
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		
		$fmst = cekPOST2("FMST_retensi_det");
		$idplh = cekPOST2("idplh_retensi_det");
		$idRetensi = cekPOST2($this->Prefix."_idplh");
		
		$id_bukuinduk = cekPOST2("id_bukuinduk");
		$harga_total = cekPOST2("harga_satuan");
		$uraian_retensi = cekPOST2("uraian_retensi");
		
		if($id_bukuinduk == "" && $err == "")$err="Barang Yang di Retensikan Belum di Isi !";
		if(($harga_total == "" || $harga_total < 1) && $err == "")$err="Biaya Retensi Belum di Isi !";
				
		//if($err == "")$err='dgffghl';
		
		if($err==""){
			if($fmst == 1){
				$data_upd = array(array("status","2"));
				$qry_upd = $DataPengaturan->QryUpdData("t_penerimaan_retensi_det",$data_upd,"WHERE Id='$idplh' AND refid_retensi='$idRetensi' ");		
			}
		
			$qry_rtns = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi","*","WHERE Id='$idRetensi' ");
			$dt_rtns = $qry_rtns["hasil"];
			
			$qry_bi = $DataPengaturan->QyrTmpl1Brs("v1_bi_skpd","*","WHERE id='$id_bukuinduk' ");
			$dt_bi = $qry_bi["hasil"];
			
			$data_ins = array(
							array('id_bi', $id_bukuinduk),
							array('c1', $dt_rtns["c1"]),
							array('c', $dt_rtns["c"]),
							array('d', $dt_rtns["d"]),
							array('e', $dt_rtns["e"]),
							array('e1', $dt_rtns["e1"]),
							array('f1', $dt_bi["f1"]),
							array('f2', $dt_bi["f2"]),
							array('f', $dt_bi["f"]),
							array('g', $dt_bi["g"]),
							array('h', $dt_bi["h"]),
							array('i', $dt_bi["i"]),
							array('j', $dt_bi["j"]),
							array('harga_total', $harga_total),
							array('keterangan', $uraian_retensi),
							array('status', "1"),
							array('tahun', $coThnAnggaran),
							array('refid_retensi', $idRetensi),
							array('uid', $uid),
							array('sttemp', "1"),
						);
			$qry_ins = $DataPengaturan->QryInsData("t_penerimaan_retensi_det",$data_ins);
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Tabel_DetailRetensi_Form(){
		global $DataPengaturan, $Main;
		$cek='';$err='';$content="";
		$data='';
		
		$idRetensi = cekPOST2($this->Prefix."_idplh");
		
		$qry = "SELECT a.*,b.nm_skpd, b.e as skpd_e, b.e1 as skpd_e1, b.nm_barang,b.noreg, b.thn_perolehan FROM t_penerimaan_retensi_det a LEFT JOIN v1_bi_skpd b ON a.id_bi=b.id WHERE a.refid_retensi='$idRetensi' AND status!='2' ";
		$aqry = mysql_query($qry);$cek.=$qry;
		
		$no = 1;
		$total_retensi=0;
		while($dt = mysql_fetch_array($aqry)){
			$row = "row1";
			if($no%2 == 1)$row = "row0";
			$skpd = $dt['e'].".".$dt['e1'].". ".$dt['nm_skpd'];
			$biaya = number_format($dt['harga_total'], 2,',', '.');
			$data .= 
				"<tr class='$row'>
					<td class='GarisDaftar' align='right' width='20px'>$no</td>
					<td class='GarisDaftar'><a href='javascript:".$this->Prefix.".UbahRincianRetensi(`".$dt['Id']."`)' >".$dt['nm_barang']."</a></td>
					<td class='GarisDaftar' align='center' width='120px'>".$dt['noreg']."/ ".$dt["thn_perolehan"]."</td>
					<td class='GarisDaftar'  align='right' >$biaya</td>
					<td class='GarisDaftar'>$skpd <br>".$dt['keterangan']."</td>
					<td class='GarisDaftar' align='center'><a href='javascript:".$this->Prefix.".HapusRincianRetensi(`".$dt['Id']."`)' ><img src='datepicker/remove2.png' style='width:20px;height:20px;' title='Hapus Data' /></a></td>
				</tr>
				";
			$total_retensi =$total_retensi+$dt['harga_total']; 
			$no++;
		}
		
		$data = 
			"<div class='FilterBar' style='padding:10px;'>
				<table class='koptable' style='width:100%;' border='1'>
					<tr>
						<th class='th01'>NO</th>
						<th class='th01'>NAMA BARANG</th>
						<th class='th01' width='120px'>NOREG/ TAHUN</th>
						<th class='th01'>BIAYA RETENSI</th>
						<th class='th01'>URAIAN</th>
						<th class='th01' width='25px'>HAPUS</th>
					</tr>
					$data
					<tr class='row1'>
						<td class='GarisDaftar' colspan='3' align='center'><b>TOTAL</b></td>
						<td class='GarisDaftar' align='right'><b>".number_format($total_retensi, 2,',', '.')."</b></td>
						<td class='GarisDaftar'></td>
						<td class='GarisDaftar'></td>
					</tr>
				</table>
			</div>
			";
		$content = $data;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);		
	}
	
	function HapusRincianRetensi(){
		global $DataPengaturan, $Main;
		$cek='';$err='';$content="";
		
		$IdDet = cekPOST2("IdDet");
		$idRetensi = cekPOST2($this->Prefix."_idplh");
		
		$data_upd = array(array("status","2"));
		$qry = $DataPengaturan->QryUpdData("t_penerimaan_retensi_det",$data_upd,"WHERE Id='$IdDet' AND refid_retensi='$idRetensi' ");
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function BatalSemua(){
	 global $HTTP_COOKIE_VARS, $DataPengaturan;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $c1= $_REQUEST['c1nya'];
	 $c= $_REQUEST['cnya'];
	 $d= $_REQUEST['dnya'];
	 $e= $_REQUEST['enya'];
	 $e1= $_REQUEST['e1nya'];
	 
	 	$qry = "SELECT * FROM t_penerimaan_barang WHERE Id='$idplh'";$cek.=$qry;
	 	$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi","*"," WHERE Id='$idplh'");$cek.=$qry["cek"];
		$daqry = $qry["hasil"];
		
		if($daqry['sttemp'] == '1'){
			//Penerimaan Rekening
			$hapusrek = "DELETE FROM t_penerimaan_retensi_rekening WHERE refid_retensi='$idplh'"; $cek.="| ".$hapusrek;
			$qry_hapusrek = mysql_query($hapusrek);
								
			//Retensi Detail -----------------------------------------------------------------------------------
			$hapuspenerimaan_det = "DELETE FROM t_penerimaan_retensi_det WHERE refid_retensi='$idplh'"; $cek.="| ".$hapuspenerimaan_det;
			$qry_hapuspenerimaan_det = mysql_query($hapuspenerimaan_det);	
						
			//Retensi  ------------------------------------------------------------------------------------------
			$hapus_penerimaan = "DELETE FROM t_penerimaan_retensi WHERE Id='$idplh'"; $cek.="| ".$hapus_penerimaan;		
			$qry_hapus_penerimaan = mysql_query($hapus_penerimaan);
		}else{
			//Penerimaan Rekening
			$hapusrek = "DELETE FROM t_penerimaan_retensi_rekening WHERE refid_retensi='$idplh' AND sttemp='1'"; $cek.="| ".$hapusrek;
			$qry_hapusrek = mysql_query($hapusrek);
			
			$updrek = "UPDATE t_penerimaan_retensi_rekening SET status='0' WHERE refid_retensi='$idplh' AND sttemp='0'";$cek.="| ".$updrek;
			$qry_updrek = mysql_query($updrek);		
						
						
			//Penerimaan Detail -----------------------------------------------------------------------------------
			$hapuspenerimaan_det = "DELETE FROM t_penerimaan_retensi_det WHERE refid_retensi='$idplh' AND sttemp='1'"; $cek.="| ".$hapuspenerimaan_det;
			$qry_hapuspenerimaan_det = mysql_query($hapuspenerimaan_det);
			
			$updpenerimaan_det =  "UPDATE t_penerimaan_retensi_det SET status='0' WHERE refid_retensi='$idplh' AND sttemp='0'"; $cek.='| '.$updpenerimaan_det;
			
			$qry_updpenerimaan_det = mysql_query($updpenerimaan_det);
		}
			//$err='dgfd';
	  
						
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function Get_IdRetensi(){
		global $DataPengaturan, $Main,$HTTP_COOKIE_VARS;
		
		$uid = $HTTP_COOKIE_VARS['coID'];
	 	$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$cek='';$err='';$content="";
			
		$cekSesuai = $this->cek_DataSesuai();
		if($cekSesuai["status"]){
			$idRetensi = cekPOST2($this->Prefix."_idplh");
			//Cek Apakah sttemp='0'
			$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi","*","WHERE Id='$idRetensi'");
			$dt = $qry["hasil"];
			
			$tgl_buku_ambil = explode("-",$dt["tgl_buku"]);
			
			$tgl_buku = explode("-", cekPOST2("tgl_buku",date("d-m")));
			$bln = $tgl_buku[1];
			
			if($dt["sttemp"] == "0" && $dt["id_retensi"] != '' && $bln == $tgl_buku_ambil[1]){
				$content=$dt["id_retensi"];
			}else{
				$qry_kode = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi","Id, tgl_buku, id_retensi","WHERE c='".$dt['c']."' AND d='".$dt['d']."' AND tahun='$coThnAnggaran' ORDER BY Id DESC");
				$dt_kode = $qry_kode["hasil"];
				if($dt_kode["Id"] != NULL || $dt_kode["Id"] != ''){
					$kode_retensi = substr($dt_kode["id_retensi"],0,3);
					$kode_retensi = intval($kode_retensi)+1;
				}else{
					$kode_retensi = 1;
				}
				
				
				$bulanRomawi = $Main->BulanRomawi[$bln];
				
				if(strlen($kode_retensi) == 1)$kode_retensi="00".$kode_retensi;
				if(strlen($kode_retensi) == 2)$kode_retensi="0".$kode_retensi;
				$content=$kode_retensi."/".$dt['c'].".".$dt['d']."/RTNS/APBD/$bulanRomawi/$coThnAnggaran";
			}
		}	
				
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
}
$pemasukan_retensi_ins = new pemasukan_retensi_insObj();
?>