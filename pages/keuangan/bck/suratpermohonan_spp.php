<?php
	include "pages/keuangan/daftarsuratpermohonan.php";
 	$DataPermohonan = $daftarsuratpermohonan;
	
class suratpermohonan_sppObj  extends DaftarObj2{	
	var $Prefix = 'suratpermohonan_spp';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_satuan'; //bonus
	var $TblName_Hapus = 'ref_satuan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('nama');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'SURAT PERMOHONAN PEMBAYARAN (SPP)';
	var $PageIcon = 'images/order1.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='suratpermohonan_spp.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'suratpermohonan_spp';	
	var $Cetak_Mode=2;
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'suratpermohonan_sppForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	var $stat_barang = array(
		array("1", "SUDAH"),
		array("2", "BELUM"),
	);
	
	function setTitle(){
		return 'SURAT PERMOHONAN PEMBAYARAN (SPP)';
	}
	
	function setMenuEdit(){
		return "";
		/*return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","new_f2.png","Atribusi", 'Atribusi')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","new_f2.png","Distribusi", 'Distribusi')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","new_f2.png","Validasi", 'Validasi')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","new_f2.png","Posting", 'Posting')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","export_xls.png","Excel", 'Excel')."</td>";*/
	}
	
	function setMenuView(){
		return "";
	}
	
	function SimpanSemua(){
	 global $HTTP_COOKIE_VARS, $Main, $DataPengaturan;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 
		 //GetData SKPD
		$c1= cekPOST('c1nya');
		$c= cekPOST('cnya');
		$d= cekPOST('dnya');
		$e= cekPOST('enya');
		$e1= cekPOST('e1nya');
		$e1= cekPOST('e1nya');
		
		$databaru = cekPOST("databaru");
		$jns_spp = cekPOST("jns_spp");
		$refid_terima = cekPOST("refid_terima");
		$refid_terima_sebelumnya = cekPOST("refid_terima_sebelumnya");
		$nomor_spd = cekPOST("nomor_spd");
		
		//Tanggal
		$Get_tgl_spd = cekPOST("tgl_spd");
		$Get_tgl_spp = cekPOST("tgl_spp");
		
		$refid_pa_kpa = cekPOST("refid_pa_kpa");
		$refid_pejabat_pk = cekPOST("refid_pejabat_pk");
		$refid_pptk = cekPOST("refid_pptk");
		$refid_bendahara_pp = cekPOST("refid_bendahara_pp");
		
		$uraian_pembayaran = cekPOST("uraian_pembayaran");
				
		if($err == "" && $jns_spp == "")$err = "Jenis SPP Belum di Pilih !";
		if($err == "" && $refid_terima == "")$err = "ID Penerimaan Belum di Pilih !";
		
		if($err == "" && $Get_tgl_spd == ""){
			$err = "Tanggal SPD Belum di Isi !";
		}else{
			$ex_Get_tgl_spd = explode("-",$Get_tgl_spd);
			$tgl_spd = $ex_Get_tgl_spd[2]."-".$ex_Get_tgl_spd[1]."-".$ex_Get_tgl_spd[0];
			if($err=='' && !cektanggal($tgl_spd)) $err= 'Tanggal SPD Tidak Valid'; 
		}
		
		if($err == "" && $Get_tgl_spp == ""){
			$err = "Tanggal SPP Belum di Isi !";
		}else{
			$ex_Get_tgl_spp = explode("-",$Get_tgl_spp);
			$tgl_spp = $ex_Get_tgl_spp[2]."-".$ex_Get_tgl_spp[1]."-".$ex_Get_tgl_spp[0];
			if($err=='' && !cektanggal($tgl_spp)) $err= 'Tanggal SPP Tidak Valid'; 
		}
		
		if($err == "" && $nomor_spd == "")$err = "Nomor SPD Belum di Isi !";
		if($err == "" && $refid_pa_kpa == "")$err = "PA/KPA Belum di Pilih !";
		if($err == "" && $refid_pejabat_pk == "")$err = "Pejabat Pembuat Komitmen Belum di Pilih !";
		if($err == "" && $refid_pptk == "")$err = "PPTK Belum di Pilih !";
		if($err == "" && $refid_bendahara_pp == "")$err = "Bendahara Pengeluaran Pembantu Belum di Pilih !";
		
		
		if($err == ""){
			$Get_nomor_spp = $this->getNomorSPP();
			if($databaru == "1"){				
				$data_input = array(
							array("c1",$c1),
							array("c",$c),
							array("d",$d),
							array("e",$e),
							array("e1",$e1),
							array("refid_terima",$refid_terima),
							array("jns_spp",$jns_spp),
							array("no_spd",$nomor_spd),
							array("tgl_spd",$tgl_spd),
							array("tgl_spp",$tgl_spp),
							array("nomor_spp",$Get_nomor_spp['content']),
							array("refid_pa_kpa",$refid_pa_kpa),
							array("refid_pejabat_pk",$refid_pejabat_pk),
							array("refid_pptk",$refid_pptk),
							array("refid_bendahara_pp",$refid_bendahara_pp),
							array("uraian",$uraian_pembayaran),
							array("uid_spp",$uid),
							array("status","1"),
						);
				$qry = $DataPengaturan->QryInsData("t_spp", $data_input);	
				
				//Tampil Id t_spp
				$qry_Tmpl1 = $DataPengaturan->QyrTmpl1Brs2("t_spp", "Id", $data_input, " ORDER BY Id DESC");
				$aqry_Tmpl1 = $qry_Tmpl1['hasil'];
				
			}else{
				// Id t_spp
				$id_ubah = cekPOST("idubah");
				
				//Hapus Data t_spp_kelengkapan_dok
				$qry_hps_t_spp = "DELETE FROM t_spp_kelengkapan_dok WHERE refid_spp = '$id_ubah' ";
				$aqry_hps_tSppDok = mysql_query($qry_hps_t_spp);
					
				$data_input = array(
							array("refid_terima",$refid_terima),
							array("jns_spp",$jns_spp),
							array("no_spd",$nomor_spd),
							array("tgl_spd",$tgl_spd),
							array("tgl_spp",$tgl_spp),
							array("nomor_spp",$Get_nomor_spp['content']),
							array("refid_pa_kpa",$refid_pa_kpa),
							array("refid_pejabat_pk",$refid_pejabat_pk),
							array("refid_pptk",$refid_pptk),
							array("refid_bendahara_pp",$refid_bendahara_pp),
							array("uraian",$uraian_pembayaran),
							array("uid_spp",$uid),
							array("status","1"),
						);
				$qry = $DataPengaturan->QryUpdData("t_spp", $data_input, "WHERE Id='$id_ubah' ");
				$aqry_Tmpl1['Id'] = $id_ubah;				
				
			}
			
			if($qry["errmsg"] != "")$err=$qry["errmsg"];
			
			// Masukan Ke t_spp_kelengkapan_dok
			if($err == ""){
									
				$ins_KelengkapanDok = $this->SimpanKelengkapanDok($aqry_Tmpl1['Id']);
				$cek.=$ins_KelengkapanDok['cek'];
				$err.=$ins_KelengkapanDok['err'];
					
			}
			
			$cek.=$qry['cek'];
		}
			
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function SimpanKelengkapanDok($Id){
		global $DataPengaturan;
		$cek = ""; $err = "";
		
		//DOKUMEN KELENGKAPAN
		$IdDokumen_syarat = cekPOST("IdDokumen_syarat");
		
		for($i=0;$i<count($IdDokumen_syarat);$i++){
		
			$status_spp = "1";
			if(!isset($_REQUEST["suratpermohonan_spp_cb_rkd_".$IdDokumen_syarat[$i]]))$status_spp='0';
			if($err == ""){
				$data_inputDok = 
					array(
						array("refid_kelengkapan_dok", $IdDokumen_syarat[$i]),
						array("status_spp", $status_spp),
						array("refid_spp", $Id),
					);
				$qry = $DataPengaturan->QryInsData("t_spp_kelengkapan_dok", $data_inputDok);
				$cek.= $suratpermohonan." | ".$qry['cek']; $err=$qry['errmsg'];
			}else{
				break;
			}
			
			
		}
		
		return	array ('cek'=>$cek, 'err'=>$err,);
					
	}
	
	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
		
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function set_selector_other($tipe){
	 global $Main,$HTTP_COOKIE_VARS;
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
					
		case 'SimpanSemua':{
			$get= $this->SimpanSemua();
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
		
		case 'TabelDokumen':{
			$get= $this->TabelDokumen();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'tabelRekening':{
			$get= $this->tabelRekening();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'getNomorSPP':{
			$get= $this->getNomorSPP();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }		
		case 'getInformasi_jmlTrsd':{
			$get= $this->getInformasi_jmlTrsd();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
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
							setTimeout(function myFunction() {".$this->Prefix.".loading()},100);
						
						});
					</script>";
		return 	
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/keuangan/daftarsuratpermohonan.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/keuangan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".	
			"<script type='text/javascript' src='js/pencarian/DataPengaturan.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/pencarian/cariRekening.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/pencarian/cariprogram.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/pencarian/cariIdPenerima.js' language='JavaScript' ></script>".
			'
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>
			'.
			$scriptload;
	}
	
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
		
		$cbid = $_REQUEST['daftarsuratpermohonan_cb'];
		if(addslashes($_REQUEST['YN']) == '1')$cbid[0]='';
			$c1input = $_REQUEST['daftarsuratpermohonanSKPD2fmURUSAN'];
			$cinput = $_REQUEST['daftarsuratpermohonanSKPD2fmSKPD'];
			$dinput = $_REQUEST['daftarsuratpermohonanSKPD2fmUNIT'];
			$einput = $_REQUEST['daftarsuratpermohonanSKPD2fmSUBUNIT'];
			$e1input = $_REQUEST['daftarsuratpermohonanSKPD2fmSEKSI'];
		
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
					//"<input type='hidden' name='pil_jns_trans' id='pil_jns_trans' value='".$_REQUEST['halmannya']."' />".
					
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
	
	//form ==================================
	
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
		$a = "SELECT count(*) as cnt, aa.satuan_terbesar, aa.satuan_terkecil, bb.nama, aa.f, aa.g, aa.h, aa.i, aa.j FROM ref_barang aa INNER JOIN ref_satuan bb ON aa.satuan_terbesar = bb.nama OR aa.satuan_terkecil = bb.nama WHERE bb.nama='".$this->form_idplh."' "; $cek .= $a;
		$aq = mysql_query($a);
		$cnt = mysql_fetch_array($aq);
		
		if($cnt['cnt'] > 0) $err = "Satuan Tidak Bisa Diubah ! Sudah Digunakan Di Ref Barang.";
		if($err == ''){
			$aqry = "SELECT * FROM  ref_satuan WHERE nama='".$this->form_idplh."' "; $cek.=$aqry;
			$dt = mysql_fetch_array(mysql_query($aqry));
			$fm = $this->setForm($dt);
		}
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
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
		$Id = $dt['nama'];			
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
	return 
			"";
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox		
	   <th class='th01' width='900'>Satuan</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$isi['nama']);
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main, $HTTP_COOKIE_VARS, $DataPengaturan,$DataOption, $DataPermohonan;
	 $databaru = cekPOST("databaru");
	 
	if($databaru == '1'){
		$c1 = cekPOST("pemasukanSKPDfmUrusan");
		$c = cekPOST("pemasukanSKPDfmSKPD");
		$d = cekPOST("pemasukanSKPDfmUNIT");
		$e = cekPOST("pemasukanSKPDfmSUBUNIT");
		$e1 = cekPOST("pemasukanSKPDfmSEKSI");
		
		$data_Simpan_SPP = array(
			array("c1", $c1),
			array("c", $c),
			array("d", $d),
			array("e", $e),
			array("e1", $e1),
			array("sttemp", "1"),
		);
		
		$BTN_CR_Id_penerimaan ="<input type='button' name='cariIdPenerimaan' id='cariIdPenerimaan' $disableCariPenerimaan value='CARI' onclick='".$this->Prefix.".CariIdPenerimaan()' /><span id='informasi_jmlTrsd'></span>";
		//$qry_Simpan_SPP = $DataPengaturan->QryInsData();
		
		//DEKLARASI
		$id_penerimaan = "";
		$jns_spp = '1';
		$no_SPD = "";
		$tgl_SPD = date("d-m-Y");
		$tgl_SPP = date("d-m-Y");
		$nomor_spp = "";
		$refid_pa_kpa = "";
		$refid_pejabat_pk = "";
		$refid_pptk = "";
		$refid_bendahara_pp = "";
		$uraian="";
		$refid_terimanya="";
		
		$program_kegiatan =$DataPermohonan->FormDariPenerimaan();
		
	}else{
		$idplh = cekPOST("idubah");
		$qry_det = $DataPermohonan->GetTblSpp($idplh);$cek.=$qry_det["cek"];
		$dt = $qry_det["content"];
		
		$c1 = $dt["c1"];
		$c = $dt["c"];
		$d = $dt["d"];
		$e = $dt["e"];
		$e1 = $dt["e1"];
		
		$qry_Penerimaan = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang", "*", "WHERE Id='".$dt['refid_terima']."'");
		$dt_penerimaan = $qry_Penerimaan["hasil"];
		
		$BTN_CR_Id_penerimaan="";
		//DEKLARASI
		$id_penerimaan = $dt_penerimaan['id_penerimaan'];
		$jns_spp = $dt['jns_spp'];
		$no_SPD = $dt['no_spd'];
		
		$Datatgl_SPD = explode("-",$dt['tgl_spd']);
		$tgl_SPD = $Datatgl_SPD[2]."-".$Datatgl_SPD[1]."-".$Datatgl_SPD[0];
		
		$Datatgl_SPP = explode("-",$dt['tgl_spp']);
		$tgl_SPP = $Datatgl_SPP[2]."-".$Datatgl_SPP[1]."-".$Datatgl_SPP[0];
		
		$nomor_spp = $dt['nomor_spp'];
		$refid_pa_kpa = $dt['refid_pa_kpa'];
		$refid_pejabat_pk = $dt['refid_pejabat_pk'];
		$refid_pptk = $dt['refid_pptk'];
		$refid_bendahara_pp = $dt['refid_bendahara_pp'];
		$uraian = $dt['uraian'];
		$refid_terimanya = $dt['refid_terima'];
		
		$program_kegiatan ="";
		
	}	 
	
	$qrykegitan = "SELECT q,concat (IF(LENGTH(q)=1,concat('0',q), q),'. ',nama) as nama FROM ref_program WHERE bk='$bknya' AND ck='$cknya' AND dk='$dknya' AND p='$p' AND q!='0'";
	
	$qry_NamaPejabat = "SELECT Id, nama FROM ref_tandatangan WHERE $WHEREC1 c='$c' AND d='$d' ";
	
	$jns_PA_KPA = $DataPengaturan->kat_PA_KPA;
	$jns_PPK = $DataPengaturan->kat_PPK;
	$jns_PPTK = $DataPengaturan->kat_PPTK;
	$jns_BPP = $DataPengaturan->kat_BPP;
	
	$qry_pakpa = $qry_NamaPejabat." AND kategori_tandatangan='$jns_PA_KPA' ";
	$qry_ppk = $qry_NamaPejabat." AND kategori_tandatangan='$jns_PPK' ";
	$qry_pptk = $qry_NamaPejabat." AND kategori_tandatangan='$jns_PPTK' ";
	$qry_bpp = $qry_NamaPejabat." AND kategori_tandatangan='$jns_BPP' ";
	
	$TampilOpt =
			
			
			$vOrder=
			$DataPengaturan->GenViewHiddenSKPD($c1, $c, $d, $e, $e1).
			$DataPengaturan->GenViewSKPD($c1, $c, $d, $e, $e1).
				genFilterBar(
				array(
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>'ID PENERIMAAN BARANG',
								'name'=>'id_penerimaan',
								'label-width'=>'200px;',
								'value'=>"
									<input type='text' name='id_penerimaan' id='id_penerimaan' value='$id_penerimaan' readonly style='width:300px;' /> ".$BTN_CR_Id_penerimaan,
							),
							array(
								'label'=>'JENIS SPP',
								'label-width'=>'200px;',
								'value'=>cmbArray('jns_spp',$jns_spp,$DataPengaturan->arr_pencairan_dana,"--- PILIH ---", "style='width:150px;' onchange='".$this->Prefix.".TabelDokumen();' "),
							),
						)
					)
				
				),'','','').
				"<input type='hidden' name='jns_dari_rek' id='jns_dari_rek' value='2' />
				<div id='tbl_rekening' style='width:100%;'></div>".
				$DataPermohonan->FormDariPenerimaan().				
				genFilterBar(
				array(
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>'<b>DASAR PEMBAYARAN</b>',
								'pemisah'=>'',
							),
							array(
								'label'=>'<span style="margin-left:10px;">NOMOR SPD</span>',
								'name'=>'nomor_spd',
								'label-width'=>'200px',
								'type'=>'text',
								'value'=>$no_SPD,
								'parrams'=>"style='width:300px;' placeholder='NOMOR SPD'",
							),
							array(
								'label'=>'<span style="margin-left:10px;">TANGGAL SPD</span>',
								'name'=>'tgl_spd',
								'label-width'=>'200px',
								'type'=>'text',
								'value'=>$tgl_SPD,
								'parrams'=>"style='width:80px;' class='datepicker'",
							),
							array(
								'label'=>'TANGGAL SPP',
								'name'=>'tgl_spp',
								'label-width'=>'200px',
								'type'=>'text',
								'value'=>$tgl_SPP,
								'parrams'=>"style='width:80px;' class='datepicker'",
							),
							array(
								'label'=>'NOMOR SPP',
								'name'=>'nomor_spp',
								'label-width'=>'200px',
								'type'=>'text',
								'value'=>$nomor_spp,
								'parrams'=>"style='width:300px;' readonly ",
							),
							array(
								'label'=>'PA/KPA',
								'name'=>'pakpa',
								'label-width'=>'200px',
								'value'=>"<span id='jns_".$jns_PA_KPA."'>".cmbQuery('refid_pa_kpa',$refid_pa_kpa,$qry_pakpa, "style='width:300px;' ","--- PILIH ---")."</span> ".$DataPermohonan->getTombolBaruNamaPejabat($jns_PA_KPA,$this->Prefix."Form"),
							),
							array(
								'label'=>'PEJABAT PEMBUAT KOMITMEN',
								'name'=>'ppk',
								'label-width'=>'200px',
								'value'=>"<span id='jns_".$jns_PPK."'>".cmbQuery('refid_pejabat_pk',$refid_pejabat_pk,$qry_ppk, "style='width:300px;' ","--- PILIH ---")."</span> ".$DataPermohonan->getTombolBaruNamaPejabat($jns_PPK,$this->Prefix."Form"),
							),
							array(
								'label'=>'PPTK',
								'name'=>'pptk',
								'label-width'=>'200px',
								'value'=>"<span id='jns_".$jns_PPTK."'>".cmbQuery('refid_pptk',$refid_pptk,$qry_pptk, "style='width:300px;' ","--- PILIH ---")."</span> ".$DataPermohonan->getTombolBaruNamaPejabat($jns_PPTK,$this->Prefix."Form"),
							),
							array(
								'label'=>'BENDAHARA PENGELUARAN PEMBANTU',
								'name'=>'ppp',
								'label-width'=>'200px',
								'value'=>"<span id='jns_".$jns_BPP."'>".cmbQuery('refid_bendahara_pp',$refid_bendahara_pp,$qry_bpp, "style='width:300px;' ","--- PILIH ---")."</span> ".$DataPermohonan->getTombolBaruNamaPejabat($jns_BPP,$this->Prefix."Form"),
							),
							array(
								'label'=>'URAIAN PEMBAYARAN',
								'name'=>'uraian_pembayaran',
								'label-width'=>'200px',
								'value'=>"<textarea name='uraian_pembayaran' id='uraian_pembayaran' placeholder='URAIAN PEMBAYARAN' style='width:300px;'>$uraian</textarea>",
							),
						)
					),
					
				
				),'','','').
				genFilterBar(array("<span style='color:black;font-size:14px;font-weight:bold;'/>KELENGKAPAN DOKUMEN</span>",	),'','','').
				"<div id='tbl_dokumen' style='width:100%;'></div>".
				"
				<input type='hidden' name='fmURUSAN' id='fmURUSAN' value='$c1' />
				<input type='hidden' name='fmBIDANG' id='fmBIDANG' value='$c' />
				<input type='hidden' name='fmSKPD' id='fmSKPD' value='$d' />".
				genFilterBar(
				array(
					
					"<table>
						<tr>							
							<td><span id='selesaisesuai'>".$DataPengaturan->buttonnya($this->Prefix.'.SimpanSemua()','checkin.png','SIMPAN','SIMPAN','SIMPAN')."</span></td>
							<td>".$DataPengaturan->buttonnya($this->Prefix.'.BatalSemua()','cancel_f2.png','BATAL','BATAL','BATAL')."</td>
						</tr>".
					"</table>"
					
				
				),'','','').
				genFilterBar(
				array(
					"<input type='hidden' name='".$this->Prefix."_idplh' id='".$this->Prefix."_idplh' value='".$dt['Id']."' />".
					"<input type='hidden' name='refid_terima' id='refid_terima' value='$refid_terimanya' />".		
					"<input type='hidden' name='refid_terima_sebelumnya' id='refid_terima_sebelumnya' value='$refid_terimanya' />"		
				),'','','')
							;
			
		return array('TampilOpt'=>$TampilOpt);
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
		//Cari 
		switch($fmPILCARI){			
			case 'selectSatuan': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;						 	
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
	
	function tabelRekening(){
		global $DataPengaturan;
			
		$cek = '';
		$err = '';
		$datanya='';
		$content=array();
		
		$Idplh = cekPOST("refid_terima");
		$qry = "SELECT * FROM v1_penerimaan_barang_rekening WHERE refid_terima='$Idplh' AND sttemp='0' AND status='0' ";$cek.=$qry;
		$aqry = mysql_query($qry);
		
		$no=1;
		$jml_rek=0;
		while($dt = mysql_fetch_array($aqry)){
			$row="row0";
			if($no%2==0)$row="row1";
			$datanya.="<tr class='$row'>
						<td class='GarisDaftar' align='right' style='width:25px' >$no</td>
						<td class='GarisDaftar' align='center'>".$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o']."</td>
						<td class='GarisDaftar' align='left'>".$dt['nm_rekening']."</td>
						<td class='GarisDaftar' align='right'>".number_format($dt['jumlah'],2,",",".")."</td>
						<td class='GarisDaftar' align='center'></td>
					</tr>";
			$no++;
			$jml_rek+=$dt['jumlah'];
		}
		
		$content['tabel'] =
			genFilterBar(
				array("
					<table class='koptable' style='min-width:780px;' border='1'>
						<tr>
							<th class='th01'>NO</th>
							<th class='th01' width='100px'>KODE REKENING</th>
							<th class='th01'>NAMA REKENING BELANJA</th>
							<th class='th01'>JUMLAH (Rp)</th>
							<th class='th01'>PAGU (Rp)</th>
						</tr>
						$datanya
						<tr class='row0'>
							<td class='GarisDaftar' align='center' colspan='3'><b>TOTAL</b></td>
							<td class='GarisDaftar' align='right'><b>".number_format($jml_rek,2,",",".")."</b></td>
							<td class='GarisDaftar'></td>
						</tr>
						
					</table>"
				)
			,'','','');
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function TabelDokumen(){
	 global $DataPermohonan;
	 
		$cek='';$err='';$content='';
		//DEFINISI
		$databaru = cekPOST("databaru");
		
		$jns_spp = cekPOST('jns_spp');
		if($jns_spp == '' && $err =='')$err = "Jenis SPP Belum di Pilih !";
		
		if($err == ''){
			$qry = "SELECT * FROM ref_kelengkapan_dokumen WHERE jns='$jns_spp' ";
			$ceklis_CEKBOX = "";
			
			if($databaru != "1"){
				$idplh = cekPOST("idubah");
				$ambil_tSpp = $DataPermohonan->GetTblSpp($idplh);
				$dt_TSpp = $ambil_tSpp["content"];
				
				if($dt_TSpp['jns_spp'] == $jns_spp)$qry = "SELECT * FROM v1_spp_dokumen WHERE jns='$jns_spp' AND refid_spp='".$dt_TSpp['Id']."' ";		
			}
			$aqry = mysql_query($qry);$cek.=$qry;
			$datanya='';
			$no=1;
			$IdCekbox = array();
			while($dt = mysql_fetch_array($aqry)){
				$ceklis_CEKBOX = "";
				if($databaru != "1")if($dt['status_spp'] == "1")$ceklis_CEKBOX="checked";
				
				$datanya.= "
					<tr class='row0'>
						<td class='GarisDaftar' align='right' style='width:25px' >$no</td>
						<td class='GarisDaftar' align='left'>".$dt['syarat']."</td>
						<td class='GarisDaftar' align='center' width='25px'><input type='checkbox' name='".$this->Prefix."_cb_rkd_".$dt['Id']."' id='".$this->Prefix."_cb_rkd_$no' $ceklis_CEKBOX/>
							<input type='hidden' name='IdDokumen_syarat[]' id='IdDokumen_syarat_no' value='".$dt['Id']."' />
						</td>
					</tr>";
				
				$no++;
			}
			
			$content = genFilterBar(
				array(
					"
					<div style='text-align:right;font-style:italic;' />CENTANG KELENGKAPAN DOKUMEN UNTUK VERIFIKASI SPP</div>
					<table class='koptable' style='min-width:780px;' border='1'>
						<tr>
							<th class='th01' style='width:25px'>NO</th>
							<th class='th01'>NAMA DOKUMEN</th>
							<th class='th01'></th>							
						</tr>
						$datanya
						
					</table>"				
				),'','','');
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function getTombolBaruNamaPejabat($jns){
		return " <input type='button' value='BARU' onclick='".$this->Prefix.".BaruNamaPejabat($jns)' />";
	}
		
	function getNomorSPP(){
		global $DataPengaturan, $Main, $DataPermohonan;
		
		$no_spp = "";
		$cek='';$err='';$content;
		$jns_spp = cekPOST("jns_spp");
		$tgl_spp = cekPOST("tgl_spp");
		$c1 = cekPOST("c1nya");
		$c = cekPOST("cnya");
		$d = cekPOST("dnya");
		
		
		//Validasi Tgl SPP
		$Get_tgl_spp = cekPOST("tgl_spp");
		if($err == "" && $Get_tgl_spp == ""){
			$err = "Tanggal SPP Belum di Isi !";
		}else{
			$ex_Get_tgl_spp = explode("-",$Get_tgl_spp);
			$tgl_spp = $ex_Get_tgl_spp[2]."-".$ex_Get_tgl_spp[1]."-".$ex_Get_tgl_spp[0];
			if($err=='' && !cektanggal($tgl_spp)) $err= 'Tanggal SPP Tidak Valid'; 
		}
		
		//Cek Apakah Data Edit
		if($err == ""){
			$DataBaru = cekPOST("databaru");
			$BlnThn_SPP = $ex_Get_tgl_spp[2]."-".$ex_Get_tgl_spp[1];
			
			if($DataBaru == "2"){
				$refid_terima = cekPOST("refid_terima");
				$Ambildata_spp = $DataPermohonan->GetTblSpp($refid_terima);
				$data_spp = $Ambildata_spp["content"];
				$BlnThn_SPP_DataAmbil = explode("-", $data_spp['tgl_spp']);
				$BlnThn_SPP_Ambil = $BlnThn_SPP_DataAmbil[0]."-".$BlnThn_SPP_DataAmbil[1];
				
				if($data_spp["jns_spp"] == $jns_spp && $BlnThn_SPP == $BlnThn_SPP_Ambil)$no_spp=$data_spp['nomor_spp'];
				
			}
		}
		
		
		
		
		if($err == "" && $no_spp == ""){
			if($tgl_spp != '' && $jns_spp != ''){
				//DEFINISI
				$tgl_pilih = explode("-", $tgl_spp);
				$bln_thn_spp = $tgl_pilih[0]."-".$tgl_pilih[1];
				
				$Kata_jns_spp = $DataPengaturan->Daftar_arr_pencairan_dana[$jns_spp];
				//$Bulan_romawi = $Main->BulanRomawi[$tgl_pilih[1]];
					
				//Cari Data di t_spp
				$qry = $DataPengaturan->QyrTmpl1Brs("t_spp", "Id, nomor_spp", "WHERE c1='$c1' AND c='$c' AND d='$d' AND tgl_spp = YEAR('".$tgl_pilih[0]."') AND jns_spp='$jns_spp' ORDER BY Id DESC");$cek.=$qry["cek"];
				$aqry= $qry['hasil'];
				
				if($aqry['nomor_spp'] != NULL || $aqry['nomor_spp'] != ''){
					$ambil_no_spp = explode("/", $aqry['nomor_spp']);
					$no_spp_plh = intval($ambil_no_spp[0]);
					$hasil_no_spp = $no_spp_plh+1;
					if(strlen($hasil_no_spp) == 1)$hasil_no_spp="0000".$hasil_no_spp;
					if(strlen($hasil_no_spp) == 2)$hasil_no_spp="000".$hasil_no_spp;
					if(strlen($hasil_no_spp) == 3)$hasil_no_spp="00".$hasil_no_spp;
					if(strlen($hasil_no_spp) == 4)$hasil_no_spp="0".$hasil_no_spp;
					
					$no_spp = $hasil_no_spp;
					
					
				}else{
					$no_spp = "00001";
				}
				$no_spp .= "/".$Kata_jns_spp."/".$c1.".".$c.".".$d."/".$tgl_pilih[0];
				$content=$no_spp;
				
			}
		}
		
		$err="";
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function getInformasi_jmlTrsd(){
		global $DataPengaturan, $Main;
		
		$cek='';$err='';$content;
		$c1 = cekPOST("c1nya");
		$c = cekPOST("cnya");
		$d = cekPOST("dnya");
		$e = cekPOST("enya");
		$e1 = cekPOST("e1nya");
		
		$hitung = $DataPengaturan->QryHitungData("t_penerimaan_barang", "WHERE pencairan_dana='1' AND sttemp='0' AND c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' AND Id NOT IN (SELECT refid_terima FROM t_spp)");
		
		$content = "<div style='background-image:url(images/administrator/images/pemberitahuaan.png);width:40px;height:20px;float:right;text-align:center;color:white;font-weight:bold;font-size:14px;padding-top:2px;pading-left:15px;margin-top:-10px;position:static;'>".$hitung['hasil']."</div>";
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function BatalSemua(){
		$cek='';$err="";$content='';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
}
$suratpermohonan_spp = new suratpermohonan_sppObj();
?>