<?php
	include "pages/keuangan/daftarsuratpermohonan.php";
 	$DataPermohonan = $daftarsuratpermohonan;
	
class suratpermohonan_spmObj  extends DaftarObj2{	
	var $Prefix = 'suratpermohonan_spm';
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
	var $PageTitle = 'SURAT PERMOHONAN';
	var $PageIcon = 'images/order1.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='suratpermohonan_spm.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'suratpermohonan_spm';	
	var $Cetak_Mode=2;
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'suratpermohonan_spmForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	var $Ada_Status = 0;
	
	var $stat_barang = array(
		array("1", "SUDAH"),
		array("2", "BELUM"),
	);
	
	function setTitle(){
		return 'SURAT PERMOHONAN MEMBAYAR (SPM)';
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
	
	function SetQuerySyaratDokumen(){
		 global $Main, $DataPengaturan;
		 $IdSPPnya = cekPOST2("IdSPPnya");
		 $IdDokumen_syarat = $_REQUEST["IdDokumen_syarat"];
		 
		 for($i=0;$i<count($IdDokumen_syarat);$i++){
		 	$cb_spm = cekPOST2($this->Prefix."_cb_rkd_".$IdDokumen_syarat[$i],'');
			if($cb_spm != ''){
				$data = array(array("status_spm","1"));
				$qry = $DataPengaturan->QryUpdData("t_spp_kelengkapan_dok", $data,"WHERE Id='".$IdDokumen_syarat[$i]."' AND refid_spp='$IdSPPnya'");$cek.=$qry["cek"];
			}
		 }
		 
		 return	$cek;	
	}
	
	function SimpanSemua(){
	 global $HTTP_COOKIE_VARS, $Main, $DataPengaturan;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 
		
	$IdSPPnya = cekPOST2("IdSPPnya");
	$uraian_pembayaran = cekPOST2("uraian_pembayaran");
	$tgl_spm = cekPOST2("tgl_spm");
	$refid_bendahara_p = cekPOST2("refid_bendahara_p");
	
				
	if($err == "" && $IdSPPnya == "")$err = "Nomor SPP Belum di Pilih !";
		
	if($err == "" && $tgl_spm == ""){
		$err = "Tanggal SPM Belum di Isi !";
	}else{
		$ex_Get_tgl_spm = explode("-",$tgl_spm);
		$tgl_spm = $ex_Get_tgl_spm[2]."-".$ex_Get_tgl_spm[1]."-".$ex_Get_tgl_spm[0];
		if($err=='' && !cektanggal($tgl_spm)) $err= 'Tanggal SPM Tidak Valid'; 
	}
		
		if($err == ""){
			//Update t_spp_potongan
			$data_potongan = array(array("sttemp","0"));
			$qry_potongan = $DataPengaturan->QryUpdData("t_spp_potongan",$data_potongan,"WHERE refid_spp='$IdSPPnya' AND status='0' ");
			//Delete t_spp_potongan
			$qry_del_potongan = "DELETE FROM t_spp_potongan WHERE status!='0' AND refid_spp='$IdSPPnya' ";
			$aqry_del_potongan = mysql_query($qry_del_potongan);
			
			//Update Dokumen
			$cek.=$this->SetQuerySyaratDokumen();
			
			
			$Get_nomor_spm = $this->getNomorSPM();
			$data = array(
						array("uraian",$uraian_pembayaran),
						array("tgl_spm",$tgl_spm),
						array("uid_spm",$uid),
						array("nomor_spm",$Get_nomor_spm['content']),
						array("refid_bendahara_p",$refid_bendahara_p),
					);
			$qry_spp = $DataPengaturan->QryUpdData("t_spp",$data,"WHERE Id='$IdSPPnya'");		
			$cek.=$SimpanKelengkapanDok["cek"];
		}
					//$err='g';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
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
		
		case 'tabelPotonganPajak':{
			$get= $this->tabelPotonganPajak();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'tabelRetensiDenda':{
			$get= $this->tabelPotonganPajak("2");
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'BaruNamaPejabat':{
			$get= $this->BaruNamaPejabat();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'getNomorSPM':{
			$get= $this->getNomorSPM();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'SimpanNamaPejabat':{
			$get= $this->SimpanNamaPejabat();
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
		
		case 'PilihPotonganPajak':{
			$get= $this->PilihPotonganPajak();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		case 'InsertRekening':{
			$get= $this->InsertRekening();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'updKodeRek':{
			$get= $this->updKodeRek();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'HapusRekening':{
			$get= $this->HapusRekeningPajak();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'updData':{
			$get= $this->UpdateRekeningPajak();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'JumlahBiaya':{
			$get= $this->GetJumlahBiaya();
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
			"<script type='text/javascript' src='js/pencarian/DataPengaturan.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/pencarian/cariIdSPP.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/pencarian/cariRekeningPajak.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/keuangan/daftarsuratpermohonan.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/keuangan/suratpermohonan_spp.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/keuangan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
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
					"<input type='hidden' name='SKPDfmUrusan' value='".$c1input."' />".
					"<input type='hidden' name='SKPDfmSKPD' value='".$cinput."' />".
					"<input type='hidden' name='SKPDfmUNIT' value='".$dinput."' />".
					"<input type='hidden' name='SKPDfmSUBUNIT' value='".$einput."' />".
					"<input type='hidden' name='SKPDfmSEKSI' value='".$e1input."' />".
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
	 
	 if($c1 !='0' && $DataOption['skpd']!='1'){
		$qry4 = "SELECT concat(c1,'. ', nm_skpd) as nama FROM ref_skpd WHERE c1='$c1' AND c='00' AND d='00' AND e='00' AND e1='000'";$cek.=$qry4;
		$aqry4 = mysql_query($qry4);
		$data4 = mysql_fetch_array($aqry4);
		$URUSAN = array( 
						'label'=>'URUSAN',
						'labelWidth'=>150, 
						'type'=>'text',
						'value'=>$data4['nama'],
						'param'=>" style='width:300px;' readonly",
						);
		$UntukC1 = "c1 = '$c1' AND ";
		}else{
			$URUSAN = '';
			$UntukC1='';
			if($DataPengaturan->FieldC1 == 1)$UntukC1="c1='0' AND ";
		}
		
		$qry = "SELECT * FROM ref_skpd WHERE $UntukC1 c='$c' AND d='00' AND e='00' AND e1='000'";$cek.=$qry;
		$aqry = mysql_query($qry);
		$data = mysql_fetch_array($aqry);
		
		$qry1 = "SELECT * FROM ref_skpd WHERE $UntukC1 c='$c' AND d='$d' AND e='00' AND e1='000'";$cek.=$qry1;
		$aqry1 = mysql_query($qry1);
		$data1 = mysql_fetch_array($aqry1);
	 
				
	 $queryJabatan = "SELECT nama,nama FROM ref_jabatan";
		
    	
	
	 //items ----------------------
	  $this->form_fields = array(
	  	  	$URUSAN,
	  		'bidang' => array( 
						'label'=>'BIDANG',
						'labelWidth'=>150, 
						'type'=>'text',
						'value'=>$data['c'].". ".$data['nm_skpd'],
						'param'=>" style='width:300px;' readonly",
						),
			'skpd' => array( 
						'label'=>'SKPD',
						'labelWidth'=>150, 
						'type'=>'text',
						'value'=>$data1['d'].". ".$data1['nm_skpd'],
						'param'=>" style='width:300px;' readonly",
						),
			
			'nip' => array( 
						'label'=>'NIP',
						'labelWidth'=>150, 
						'type'=>'text',
						'value'=>$dt['nip'],
						'param'=>" style='width:300px;' ",),
			
			
			'namapegawai' => array( 
						'label'=>'NAMA PEGAWAI',
						'labelWidth'=>150, 
						'type'=>'text',
						'value'=>"",
						'param'=>" style='width:300px;'",
						),	
			
			'jabatan' => array( 
						'label'=>'JABATAN',
						'labelWidth'=>50, 
						'value'=>
						cmbQuery('fmJabatan',$dt['jabatan'],$queryJabatan," style='width:300px;'",'-------- Pilih --------')
					
					
						 ),					 			 
									
			);
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
		$c1 = cekPOST("SKPDfmUrusan");
		$c = cekPOST("SKPDfmSKPD");
		$d = cekPOST("SKPDfmUNIT");
		$e = cekPOST("SKPDfmSUBUNIT");
		$e1 = cekPOST("SKPDfmSEKSI");
		$tgl_spm = date("d-m-Y");
		$no_SP2D = "";
		
		$data_Simpan_SPP = array(
			array("c1", $c1),
			array("c", $c),
			array("d", $d),
			array("e", $e),
			array("e1", $e1),
			array("sttemp", "1"),
		);
		$jns_spm = "";
		$BTN_CR_no_spp ="<input type='button' name='cariIdPenerimaan' id='cariIdPenerimaan' $disableCariPenerimaan value='CARI' onclick='".$this->Prefix.".CariIdSPP()' /><span id='informasi_jmlTrsd'></span>";
		
		$program_kegiatan =$DataPermohonan->FormDariPenerimaan();
		
	}else{
		$Idplh = cekPOST("idubah");
		$qry_det = $DataPermohonan->GetTblSpp($Idplh);$cek.=$qry_det["cek"];
		$dt = $qry_det["content"];
		
		$c1 = $dt["c1"];
		$c = $dt["c"];
		$d = $dt["d"];
		$e = $dt["e"];
		$e1 = $dt["e1"];
		
		
		
		$BTN_CR_Id_penerimaan="";
		//DEKLARASI
		$no_spp = $dt['nomor_spp'];
		$jns_spp = $DataPengaturan->Daftar_arr_pencairan_dana[$dt['jns_spp']];
		$program = $DataPengaturan->GetProgKeg($dt["bk"],$dt["ck"],$dt["dk"],$dt["p"]);
		$kegiatan = $DataPengaturan->GetProgKeg($dt["bk"],$dt["ck"],$dt["dk"],$dt["p"], $dt["q"]);
				
		//ProgramKegiatan
		$program_kegiatan =$DataPermohonan->FormDariPenerimaan($program, $kegiatan, $dt["pekerjaan"],$dt["tgl_dok_kontrak"],$dt["no_dok_kontrak"],$dt["penyedia_barang"]);
		
		$no_SPD = $dt['no_spd'];
		
		$Datatgl_SPD = explode("-",$dt['tgl_spd']);
		$tgl_SPD = $Datatgl_SPD[2]."-".$Datatgl_SPD[1]."-".$Datatgl_SPD[0];
		
		$Datatgl_SPP = explode("-",$dt['tgl_spp']);
		$tgl_SPP = $Datatgl_SPP[2]."-".$Datatgl_SPP[1]."-".$Datatgl_SPP[0];
		
		$refid_bendahara_p = $dt['refid_bendahara_p'];
		$uraian = $dt['uraian'];
		$refid_terimanya = $dt['refid_terima'];
		
		$jns_spm = $DataPengaturan->Daftar_arr_pencairan_dana_SPM[$dt['jns_spp']];
		$tgl_spm = explode("-",$dt['tgl_spm']);
		if(isset($tgl_spm[2]) && $tgl_spm[2]!='0000'){
			$tgl_spm = $tgl_spm[2]."-".$tgl_spm[1]."-".$tgl_spm[0];
		}else{
			$tgl_spm = date("d-m-Y");
		}
		
	}	 
	
	$qrykegitan = "SELECT q,concat (IF(LENGTH(q)=1,concat('0',q), q),'. ',nama) as nama FROM ref_program WHERE bk='$bknya' AND ck='$cknya' AND dk='$dknya' AND p='$p' AND q!='0'";
	
	$qry_NamaPejabat = "SELECT Id, nama FROM ref_tandatangan WHERE $WHEREC1 c='$c' AND d='$d' ";
	
	$jns_BP = $DataPengaturan->kat_BP;
	$qry_bp = $qry_NamaPejabat." AND kategori_tandatangan='$jns_BP' ";
	
	$TampilOpt =
			
			
			$vOrder=
			$DataPengaturan->InputHidden("IdSPPnya", $Idplh).
			$DataPengaturan->GenViewHiddenSKPD($c1, $c, $d, $e, $e1).
			$DataPengaturan->GenViewSKPD($c1, $c, $d, $e, $e1).
				genFilterBar(
				array(
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>'NOMOR SPP',
								'name'=>'no_spp',
								'label-width'=>'200px;',
								'value'=>"
									<input type='text' name='no_spp' id='no_spp' value='$no_spp' readonly style='width:300px;' /> ".$BTN_CR_no_spp,
							),
							array(
								'label'=>'JENIS SPP',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='jns_spp' id='jns_spp' value='$jns_spp' readonly style='width:100px;' /> ",
							),
						)
					)
				
				),'','','').
				"<input type='hidden' name='jns_dari_rek' id='jns_dari_rek' value='2' />
				<div id='tbl_rekening' style='width:100%;'></div>".
				$program_kegiatan.				
				genFilterBar(
				array(
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>'URAIAN PEMBAYARAN',
								'name'=>'uraian_pembayaran',
								'label-width'=>'200px',
								'value'=>"<textarea name='uraian_pembayaran' id='uraian_pembayaran' placeholder='URAIAN PEMBAYARAN' style='width:300px;'>$uraian</textarea>",
							),
						)
					),
					
				
				),'','','').
				genFilterBar(array("<span><a href='#' onclick='".$this->Prefix.".tabelPotonganPajak()' style='color:black;font-size:14px;font-weight:bold;'>DATA POTONGAN SPM</a></span>",	),'','','').
				"<div id='tbl_potongan_pajak' style='width:100%;'></div>".
				/*genFilterBar(array("<span><a href='#' onclick='".$this->Prefix.".tabelRetensiDenda()' style='color:black;font-size:14px;font-weight:bold;'>DATA RETENSI DAN DENDA KETERLAMBATAN</a></span>",	),'','','').
				"<div id='tbl_retensiDenda' style='width:100%;'></div>".*/
				genFilterBar(
				array(
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>'JUMLAH YANG DIBAYAR',
								'name'=>'jml_yg_dibayar',
								'label-width'=>'200px',
								'value'=>"<input type='text' name='jml_yg_dibayar' id='jml_yg_dibayar' value='0' readonly style='width:150px;text-align:right;' /> ",
							),
							array(
								'label'=>'JENIS SPM',
								'name'=>'jns_spm',
								'label-width'=>'200px',
								'value'=>"<input type='text' name='jns_spm' id='jns_spm' value='$jns_spm' readonly style='width:80px;' /> ",
							),
							array(
								'label'=>'TANGGAL SPM',
								'name'=>'tgl_spm',
								'label-width'=>'200px',
								'value'=>"<input type='text' name='tgl_spm' class='datepicker' id='tgl_spm' value='$tgl_spm' style='width:80px;text-align:left;' /> ",
							),
							array(
								'label'=>'NOMOR SPM',
								'name'=>'no_spm',
								'label-width'=>'200px',
								'value'=>"<input type='text' name='no_spm' id='no_spm' value='' placeholder='NOMOR SPM' style='width:300px;text-align:left;' readonly /> ",
							),							
							array(
								'label'=>'BENDAHARA PENGELUARAN',
								'name'=>'bendahara_pengeluaran',
								'label-width'=>'200px',
								'value'=>"<span id='jns_".$jns_BP."'>".cmbQuery('refid_bendahara_p',$refid_bendahara_p,$qry_bp, "style='width:300px;' ","--- PILIH ---")."</span> ".$DataPermohonan->getTombolBaruNamaPejabat($jns_BP,$this->Prefix."Form"),
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
	
	function TabelDokumen(){
	 global $DataPermohonan;
	 
		$cek='';$err='';$content='';
		//DEFINISI
		$databaru = cekPOST("databaru");
		$IdSPPnya = cekPOST("IdSPPnya");
		
		if($err == ''){
			$qry = "SELECT b.* FROM t_spp a LEFT JOIN t_spp_kelengkapan_dok  b ON a.Id=b.refid_spp WHERE a.Id='$IdSPPnya' ";$cek.=$qry;	
			$aqry = mysql_query($qry);
			$datanya='';
			$no=1;
			$IdCekbox = array();
			while($dt = mysql_fetch_array($aqry)){
				$ceklis_CEKBOX = "";
				if($databaru != "1")if($dt['status_spm'] == "1")$ceklis_CEKBOX="checked";
				
				$datanya.= "
					<tr class='row0'>
						<td class='GarisDaftar' align='right' style='width:25px' >$no</td>
						<td class='GarisDaftar' align='left'>".$dt['syarat_dok']."</td>
						<td class='GarisDaftar' align='center' width='25px'><input type='checkbox' name='".$this->Prefix."_cb_rkd_".$dt['Id']."' id='".$this->Prefix."_cb_rkd_$no' $ceklis_CEKBOX/>
							<input type='hidden' name='IdDokumen_syarat[]' id='IdDokumen_syarat_no' value='".$dt['Id']."' />
						</td>
					</tr>";
				
				$no++;
			}
			
			$content = genFilterBar(
				array(
					"
					<div style='text-align:right;font-style:italic;' />CENTANG KELENGKAPAN DOKUMEN UNTUK VERIFIKASI SPM</div>
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
				array("jns",$jns),
			);
			
			$simpan = $DataPengaturan->QryInsData("ref_nm_pejabat_sp", $data);
			$err = $simpan['errmsg'];$cek.=$simpan['cek'];
		}
		
		//Ambil Konten
		if($err == ""){
			$tukC1 = "";
			if($DataOption['skpd'] == 2)$tukC1 = "c1='$c1' AND ";
			
			//Pilih Nama Pejabat
			switch($jns){
				case "1":$form_pejabat = "refid_pa_kpa";break;
				case "2":$form_pejabat = "refid_pejabat_pk";break;
				case "3":$form_pejabat = "refid_pptk";break;
				case "4":$form_pejabat = "refid_bendahara_pp";break;
			}
			
			//Ambil Id
			$isi_form_pejabat = $DataPengaturan->QyrTmpl1Brs2("ref_nm_pejabat_sp","Id", $data, "ORDER BY Id DESC");
			$nm_pejabat_pilih = $isi_form_pejabat['hasil'];
			
			//Konten
			$qry = "SELECT Id, nama FROM ref_nm_pejabat_sp WHERE $tukC1 c='$c' AND d='$d' AND jns='$jns' ";
			
			$content['value'] = cmbQuery($form_pejabat,$nm_pejabat_pilih['Id'],$qry, "style='width:300px;' ","--- PILIH ---")." ".$this->getTombolBaruNamaPejabat($jns);
			$content['jns'] = $jns;			
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function getNomorSPM(){
		global $DataPengaturan, $Main, $DataPermohonan;
		
		$no_spm = "";
		$cek='';$err='';$content='';
		$tgl_spm = cekPOST2("tgl_spm");
		$c1 = cekPOST2("c1nya");
		$c = cekPOST2("cnya");
		$d = cekPOST2("dnya");
		$IdSPPnya = cekPOST2("IdSPPnya");
		
		
		//Validasi Tgl SPP
		$Get_tgl_spm = cekPOST2("tgl_spm");
		if($err == "" && $Get_tgl_spm == ""){
			$err = "Tanggal SPM Belum di Isi !";
		}else{
			$ex_Get_tgl_spm = explode("-",$Get_tgl_spm);
			$tgl_spm = $ex_Get_tgl_spm[2]."-".$ex_Get_tgl_spm[1]."-".$ex_Get_tgl_spm[0];
			if($err=='' && !cektanggal($tgl_spm)) $err= 'Tanggal SPM Tidak Valid'; 
		}
		
		//Cek Apakah Data Edit
		if($err == ""){
			$qry_spp = $DataPengaturan->QyrTmpl1Brs("t_spp", "*", "WHERE Id='$IdSPPnya'");$cek.=$qry_spp["cek"];
			$dt_spp = $qry_spp["hasil"];
			if($dt_spp["nomor_spm"] != '')$no_spm = $dt_spp["nomor_spm"];
			$content = $no_spm;
		}	
		
		
		if($err == "" && $no_spm == ""){
			if($tgl_spm != ''){
				//DEFINISI
				$tgl_pilih = explode("-", $tgl_spm);
				
				
				$Kata_jns_spp = $DataPengaturan->Daftar_arr_pencairan_dana_SPM[$dt_spp["jns_spp"]];
					
				//Cari Data di t_spp
				$qry = $DataPengaturan->QyrTmpl1Brs("t_spp", "Id, nomor_spm", "WHERE c1='$c1' AND c='$c' AND d='$d' AND jns_spp='".$dt_spp["jns_spp"]."' AND Id!='$IdSPPnya' AND YEAR(tgl_spm)='".$tgl_pilih[0]."' ORDER BY Id DESC");$cek.=$qry["cek"];
				$aqry= $qry['hasil'];
				
				if($aqry['nomor_spm'] != NULL || $aqry['nomor_spm'] != ''){
					$ambil_no_spm = explode("/", $aqry['nomor_spm']);
					$no_spm_plh = intval($ambil_no_spm[0]);
					$hasil_no_spm = $no_spm_plh+1;
					if(strlen($hasil_no_spm) == 1)$hasil_no_spm="0000".$hasil_no_spm;
					if(strlen($hasil_no_spm) == 2)$hasil_no_spm="000".$hasil_no_spm;
					if(strlen($hasil_no_spm) == 3)$hasil_no_spm="00".$hasil_no_spm;
					if(strlen($hasil_no_spm) == 4)$hasil_no_spm="0".$hasil_no_spm;
					
					$no_spm = $hasil_no_spm;				
				}else{
					$no_spm = "00001";
				}
				$no_spm .= "/".$Kata_jns_spp."/".$c1.".".$c.".".$d."/".$tgl_pilih[0];
				$content=$no_spm;
				
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
		
		$hitung = $DataPengaturan->QryHitungData("t_spp", "WHERE c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' AND status='1' ");$cek.=$hitung['cek'];
		
		$content = "<div style='background-image:url(images/administrator/images/pemberitahuaan.png);width:40px;height:20px;float:right;text-align:center;color:white;font-weight:bold;font-size:14px;padding-top:2px;pading-left:15px;margin-top:-10px;position:static;'>".$hitung['hasil']."</div>";
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function tabelPotonganPajak($jns='1'){
		global $DataPengaturan;
			
		$cek = '';
		$err = '';
		$datanya='';
		$content=array();
		
		$Idplh = cekPOST2("IdSPPnya");
		$status_del = cekPOST2("status");
		
		if($status_del == 1){
			$qrydel = "DELETE FROM t_spp_potongan WHERE refid_spp='$Idplh' AND status='1' AND jns='$jns'";$cek.=$qrydel;
			$aqrydel = mysql_query($qrydel);
		}
		
		$qry = "SELECT a.*, b.nm_rekening FROM v1_spp_potongan a LEFT JOIN ref_rekening b ON a.k=b.k AND a.l=b.l AND a.m=b.m AND a.n=b.n AND a.o=b.o WHERE refid_spp='$Idplh' AND jns='$jns' AND a.status != '2'";$cek.=$qry;		
		$aqry = mysql_query($qry);
		
		
		
		$no=1;
		while($dt = mysql_fetch_array($aqry)){
			$nama_rekening= $dt["nm_rekening"] == "" ? "": $dt["nm_rekening"];
			$uraian_ket= $dt["nama_potongan"] == "" ? "": $dt['nama_potongan']."<br>".$dt['uraian_rek'];
			$jumlahnya= $dt['jumlah'] == 0 ? "":number_format($dt['jumlah'],2,",",".");
			
			
			if($dt['status'] == '0'){
				$kode = "
					<a href='javascript:".$this->Prefix.".jadiinput(`".$dt['Id']."`);' >
						".$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o']."
					</a>
					";
								
				$idrek = '';				
				$btn ="
				<a href='javascript:".$this->Prefix.".HapusRekening(`".$dt['Id']."`, $jns)' />
					<img src='datepicker/remove2.png' style='width:20px;height:20px;' />
				</a>";		
				
				$uraian_ket = $dt['nama_potongan']."<br>".$dt['uraian_rek'];
				$nama_rekening = $dt["nm_rekening"];		
			}
			
			if($dt['status'] == '1'){
			// DENGAN INPUTAN TEXT
				$this->Ada_Status=1;
				$kode = "<input type='text' name='koderek_$jns' id='koderek_$jns' value='".$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o']."' style='width:80px;' maxlength='12' />".$DataPengaturan->InputHidden("refid_potongan_spm_".$jns,$dt['refid_potongan_spm'])
				."<a href='javascript:".$this->Prefix.".CariPotongan($jns);'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>"
				;
						 
				$idrek = "<input type='hidden' name='idrek_$jns' id='idrek_$jns' value='".$dt['Id']."' />".
						"<input type='hidden' name='statidrek' id='statidrek' value='".$dt['status']."' />";
				
				$jumlahnya = "<span id='formatjumlah_$jns'>$jumlahnya</span>";
				
				$btn ="
						<a href='javascript:".$this->Prefix.".updKodeRek($jns)' />
							<img src='datepicker/save.png' style='width:20px;height:20px;' />
						</a>
						";
				$uraian_ket="<span id='uraian_ket_$jns'>$uraian_ket</span>";
				$nama_rekening = "<span id='namaakun_".$jns."'>$nama_rekening</span>";
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
					<td class='GarisDaftar'>$nama_rekening</td>
					<td class='GarisDaftar' align='left'>$uraian_ket</td>
					<td class='GarisDaftar' align='right'><span id='jumlanya_".$dt['Id']."'>$jumlahnya</span></td>
					$Kolom_BTN
				</tr>
			";
			$no = $no+1;
			$jml_harga = $jml_harga+floatval($dt['jumlah']);
		}
		
		$TombolBaru = "<a href='javascript:".$this->Prefix.".BaruRekeningPajak($jns)' /><img src='datepicker/add-256.png' style='width:20px;height:20px;' /></a>";
		
		if($this->Ada_Status == 1)$TombolBaru="<a href='javascript:".$this->Prefix.".CancelRekeningPajak($jns)' /><img src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>";
		
		$Kolom_BTN_TombolBaru = "<th class='th01'>
									<span id='atasbutton'>
									$TombolBaru
									</span>
								</th>";
		$content['tabel'] =
			genFilterBar(
				array("
					<table class='koptable' style='min-width:1024px;' border='1'>
						<tr>
							<th class='th01'>NO</th>
							<th class='th01' width='50px'>KODE REKENING</th>
							<th class='th01'>NAMA REKENING BELANJA</th>
							<th class='th01'>KETERANGAN</th>
							<th class='th01'>JUMLAH (Rp)</th>
							$Kolom_BTN_TombolBaru
						</tr>
						$datanya
						
					</table>"
				)
			,'','','')
		;
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
		
	function PilihPotonganPajak(){
		global $Main, $DataPengaturan,$DataPermohonan;
		$cek='';$err='';$content='';
		
		$IdSPPnya=cekPOST2("IdSPPnya");
		$nonya=cekPOST2("nonya");
		$pjk_1=$_REQUEST["pjk_1"];
		$jns="1";
		
		if($IdSPPnya == "" && $err=="")$err="NOMOR SPP Belum Di Pilih !";
		
		if($err == ""){
			if(isset($pjk_1[$nonya])){
				$kode_pajak = explode("_",$pjk_1[$nonya]);
				$kd_rek = explode(".",$kode_pajak[2]);
				
				$data = array(
							array("k",$kd_rek[0]),
							array("l",$kd_rek[1]),
							array("m",$kd_rek[2]),
							array("n",$kd_rek[3]),
							array("o",$kd_rek[4]),
							array("jns",$jns),
						);
				
				$jumlah = $DataPermohonan->GetTotalRekPenerimaan($IdSPPnya);
				
				$qry_sp = $DataPengaturan->QyrTmpl1Brs2("ref_sp_potongan", "persen", $data);
				$dt_sp = $qry_sp["hasil"];
				$biaya = $jumlah * ($dt_sp["persen"]/100) ;
				
				if($kode_pajak[0] != "0"){
					$data_upd = array(array("jumlah",$biaya),array("status","1"));
					$qry = $DataPengaturan->QryUpdData("t_spp_potongan", $data_upd,"WHERE Id='".$kode_pajak[0]."'");
				}else{					
					
					
				}
			}
		}
			
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function InsertRekening(){
		global $Main, $DataPengaturan,$DataPermohonan,$HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$jns = cekPOST2('jns');
		
		$IdSPP= $_REQUEST['IdSPPnya'];
		
		if($err == "" && $IdSPP == '')$err="Nomor SPP Belum di Isi !";
		if($err == ""){
			$qrydel = "DELETE FROM t_spp_potongan WHERE refid_spp='$IdSPP' AND status='1' AND uid='$uid' AND jns='$jns'";$cek.=$qrydel;
			$aqrydel = mysql_query($qrydel);
			
			if($aqrydel){
				$data = array(
							array("refid_spp",$IdSPP),
							array("status","1"),
							array("uid",$uid),
							array("jns",$jns),
							array("sttemp","1"),
							array("tahun",$coThnAnggaran),
						);
				$qry=$DataPengaturan->QryInsData("t_spp_potongan",$data);$cek.=$qry["cek"];
			}	
		}
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function updKodeRek(){
		global $Main, $DataPengaturan,$DataPermohonan,$HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
				
		$IdSPPnya = cekPOST2("IdSPPnya");
		$jns = cekPOST2("jns");
		$refid_potongan_spm = cekPOST2("refid_potongan_spm_".$jns);
		$idrek = cekPOST2("idrek_".$jns);
		
		$qry = $DataPengaturan->QyrTmpl1Brs("v1_ref_potongan_spm_rek", "*","WHERE Id='$refid_potongan_spm' ");$cek.=$qry["cek"];
		$dt = $qry["hasil"];
		
		if($err == "" && ($dt["Id"] == ''|| $dt["Id"] == NULL))$err="Rekening Tidak Valid ! Silahkan Pilih Ulang !";
		
		//if($err == "")$err="dffdg";		
		if($err == ""){
			$qry_SPP = $DataPengaturan->QyrTmpl1Brs("t_spp", "refid_terima", "WHERE Id='$IdSPPnya'");
			$dt_SPP = $qry_SPP["hasil"];
			
			if($dt_SPP["refid_terima"] != ""){
				$get = $this->updKodeRek_PenerimaanBarang($IdSPPnya,$jns, $dt_SPP["refid_terima"],$dt, $idrek);
				$cek.=" | ".$get["cek"];
				$err=$get["err"];
			}
					
			
			
		}		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function updKodeRek_PenerimaanBarang($IdSPPnya, $jns, $refid_terima,$dt_Potongan, $idrek=''){
		global $Main, $DataPengaturan,$DataPermohonan,$HTTP_COOKIE_VARS;
		$cek='';$err='';	
		
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		$qry_rek = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_rekening", "IFNULL(SUM(jumlah),0) as jml", "WHERE refid_terima='".$refid_terima."' AND sttemp='0' ");$cek.=$qry_rek["cek"];
		$dt_rek = $qry_rek["hasil"];
		
		$jml_harga = $dt_rek["jml"] * ($dt_Potongan["persen"] / 100);
		
		
		$data_upd = array(array("status","2"));
		$qry_upd = $DataPengaturan->QryUpdData("t_spp_potongan",$data_upd, "WHERE Id='$idrek'");$cek.=" | ".$qry_upd["cek"];
		
		$data_ins =
			array(
				array("jumlah", $jml_harga),
				array("jns", $jns),
				array("status", "0"),
				array("sttemp", "1"),
				array("tahun", $coThnAnggaran),
				array("refid_spp", $IdSPPnya),
				array("uid", $uid),
				array("refid_potongan_spm", $dt_Potongan["Id"]),
			);
		$qry_ins = $DataPengaturan->QryInsData("t_spp_potongan",$data_ins);$cek.=" | ".$qry_ins["cek"];
		
		
		return	array ('cek'=>$cek, 'err'=>$err);
	}
	
	function HapusRekeningPajak(){
		global $Main, $DataPengaturan,$DataPermohonan,$HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		
		$IdPotongan = cekPOST2("idrekei");
		$jns = cekPOST2("jnsnya");
		$IdSPPnya = cekPOST2("IdSPPnya");
		
		$qry_cek = $DataPengaturan->QyrTmpl1Brs("t_spp_potongan", "Id", "WHERE Id='$IdPotongan' AND jns='$jns' AND refid_spp='$IdSPPnya'");
		$dt_cek = $qry_cek["hasil"];$cek.=$qry_cek["cek"];
		
		if($err == "" && ($dt_cek["Id"] == "" ||$dt_cek["Id"] == NULL))$err="Data Tidak Valid !";
		if($err == ""){
			$data_upd = array(array("status","2"));
			$qry_upd = $DataPengaturan->QryUpdData("t_spp_potongan",$data_upd,"WHERE Id='".$dt_cek["Id"]."'");
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function UpdateRekeningPajak(){
		global $Main, $DataPengaturan;
		$cek='';$err='';$content='';
		
		$IdPotongan = cekPOST2("idna");
		$jns = cekPOST2("jnsnya");
		$IdSPPnya = cekPOST2("IdSPPnya");
		
		$qry_cek = $DataPengaturan->QyrTmpl1Brs("t_spp_potongan", "Id", "WHERE Id='$IdPotongan' AND refid_spp='$IdSPPnya'");
		$dt_cek = $qry_cek["hasil"];$cek.=$qry_cek["cek"];
		
		if($err == "" && ($dt_cek["Id"] == "" ||$dt_cek["Id"] == NULL))$err="Data Tidak Valid !";
		if($err == ""){
			$data_upd = array(array("status","1"));
			$qry_upd = $DataPengaturan->QryUpdData("t_spp_potongan",$data_upd,"WHERE Id='".$dt_cek["Id"]."'");
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function GetJumlahBiaya(){
		global $Main, $DataPengaturan;
		$cek='';$err='';$content='';
		$jumlah_biaya = 0;
		
		$IdSPPnya = cekPOST2("IdSPPnya");
		
		$qry_spp = $DataPengaturan->QyrTmpl1Brs("t_spp", "refid_terima", "WHERE Id='$IdSPPnya'");
		$dt_spp = $qry_spp["hasil"];
		
		if($dt_spp["refid_terima"] != '' && $dt_spp["refid_terima"] != NULL){
			$qry_rek = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_rekening", "IFNULL(SUM(jumlah),0) as jml", "WHERE refid_terima='".$dt_spp["refid_terima"]."' AND sttemp='0'");
			$dt_rek = $qry_rek["hasil"];
			
			$jumlah_biaya+=$dt_rek["jml"];
		}
		
		$qry_potongan = $DataPengaturan->QyrTmpl1Brs("t_spp_potongan","IFNULL(SUM(jumlah),0) as jml", "WHERE refid_spp='$IdSPPnya' AND status='0'");
		$dt_potongan = $qry_potongan["hasil"];
		$jumlah_biaya-=$dt_potongan["jml"];
		
		$content=number_format($jumlah_biaya,2,",",".");		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function BatalSemua(){
		global $Main, $DataPengaturan;
		$cek='';$err='';$content='';
		$IdSPPnya = cekPOST2("IdSPPnya");
		//DELETE  di t_spp_potongan
		$qry = "DELETE FROM t_spp_potongan WHERE refid_spp='$IdSPPnya' AND sttemp='1' ";$cek.=$qry;
		$aqry = mysql_query($qry);
		
		//UPDATE t_spp_potongan
		$data_upd = array(array("status",'0'));
		$qry_upd = $DataPengaturan->QryUpdData("t_spp_potongan",$data_upd,"WHERE refid_spp='$IdSPPnya' AND sttemp='0' ");
		$cek.=$qry_upd['cek'];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

}
$suratpermohonan_spm = new suratpermohonan_spmObj();
?>