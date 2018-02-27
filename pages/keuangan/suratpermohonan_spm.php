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
	
	var $program="";
	var $kegiatan="";
	var $pidurutan=0;
	
	var $stat_barang = array(
		array("1", "SUDAH"),
		array("2", "BELUM"),
	);
	
	function setTitle(){
		return 'SURAT PERINTAH MEMBAYAR (SPM)';
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
	 global $HTTP_COOKIE_VARS, $Main, $DataPengaturan, $DataPermohonan;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 
	 $t_spp = $DataPermohonan->TblName_N;
	 
		
	$IdSPPnya = cekPOST2("IdSPP");
	$uraian = cekPOST2("uraian");
	$tgl_spm = FormatTanggalnya(cekPOST2("tgl_spm")."-".$thn_anggaran);
	$refid_ttd_spm = cekPOST2("refid_ttd_spm");
	$nomor_spm_no = cekPOST2("nomor_spm_no");
	
	$Get_nomor_spm = $this->getNomorSPM();
	$DataNomorSPM = $Get_nomor_spm["content"];
	$nomor_spm = $nomor_spm_no.$DataNomorSPM["keterangan"];
	
				
	if($err == "" && $IdSPPnya == "")$err = "Nomor SPP Belum di Pilih !";
	if($err == "" && intval($nomor_spm_no) == 0)$err = "Nomor SPM Belum di Isi !";
	if($err=='' && !cektanggal($tgl_spm)) $err= 'Tanggal SPM Tidak Valid'; 
	if($err == "" && $refid_ttd_spm == "")$err = "Penandatangan Belum di Pilih !";
	
	//Cek Nomor SPM
	if($err == ""){
		$qry_cekSPM = $DataPengaturan->QryHitungData($t_spp,"WHERE nomor_spm!='' AND Id!='$IdSPPnya' AND nomor_spm='$nomor_spm'");
		if($qry_cekSPM["hasil"] > 0)$err="Nomor SPM Sudah di Gunakan !";
	}
	
		
	if($err == ""){
		//Update t_spp_potongan
		$data_potongan = array(array("sttemp","0"));
		$qry_potongan = $DataPengaturan->QryUpdData("t_spp_potongan",$data_potongan,"WHERE refid_spp='$IdSPPnya' AND status='0' ");
		//Delete t_spp_potongan
		$qry_del_potongan = "DELETE FROM t_spp_potongan WHERE status!='0' AND refid_spp='$IdSPPnya' ";
		$aqry_del_potongan = mysql_query($qry_del_potongan);
		
		
		
		$data = array(
					array("uraian_spm",$uraian),
					array("tgl_spm",$tgl_spm),
					array("uid_spm",$uid),
					array("nomor_spm",$nomor_spm),
					array("status","3"),
					array("status_spm","1"),
					array("refid_ttd_spm",$refid_ttd_spm),
				);
		$qry_spp = $DataPengaturan->QryUpdData("t_spp",$data,"WHERE Id='$IdSPPnya'");		
		$cek.=$qry_spp["cek"];
		$err = $qry_spp["errmsg"]!=''?$qry_spp["errmsg"]:"";
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
		case 'formBaru'					 : $fm = $this->setFormBaru();break;
		case 'formEdit'					 : $fm = $this->setFormEdit();break;
		case 'SimpanSemua'				 : $fm = $this->SimpanSemua();break;
		case 'BatalSemua'				 : $fm = $this->BatalSemua();break;
		case 'TabelDokumen'				 : $fm = $this->TabelDokumen();break;
		case 'tabelPotonganPajak'		 : $fm = $this->tabelPotonganPajak();break;
		case 'BaruNamaPejabat'		 	 : $fm = $this->BaruNamaPejabat();break;
		case 'getNomorSPM'		 	 	 : $fm = $this->getNomorSPM();break;
		case 'SimpanNamaPejabat'	 	 : $fm = $this->SimpanNamaPejabat();break;
		case 'getInformasi_jmlTrsd'	 	 : $fm = $this->getInformasi_jmlTrsd();break;
		case 'PilihPotonganPajak'	 	 : $fm = $this->PilihPotonganPajak();break;
		case 'BaruPotonganPajak'	 	 : $fm = $this->BaruPotonganPajak();break;
		case 'updKodeRek'	 	 		 : $fm = $this->updKodeRek();break;
		case 'HapusRekening'	 	 	 : $fm = $this->HapusRekeningPajak();break;
		case 'UpdateRekeningPajak'	 	 : $fm = $this->UpdateRekeningPajak();break;
		case 'JumlahBiaya'	 	 		 : $fm = $this->GetJumlahBiaya();break;
		case 'Get_DataSPP'	 	 		 : $fm = $this->Get_DataSPP();break;
		case 'Get_RincianSPM'	 	 	 : $fm = $this->Get_RincianSPM();break;
		case 'Get_DataPotonganSPM'	 	 : $fm = $this->Get_DataPotonganSPM();break;
		case 'Get_PenandatanganSPM'	 	 : $fm = $this->Get_PenandatanganSPM();break;		   
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
							setTimeout(function myFunction() {".$this->Prefix.".loading()},100);
						
						});
					</script>";
		return 	
			fn_TagScript("js/skpd.js").
			fn_TagScript("js/pencarian/DataPengaturan.js").
			fn_TagScript("js/pencarian/cariIdSPP.js").
			fn_TagScript("js/pencarian/cariRekeningPajak.js").
			fn_TagScript("js/keuangan/daftarsuratpermohonan.js").
			fn_TagScript("js/keuangan/".strtolower($this->Prefix).".js").
			$DataPengaturan->Gen_Script_DatePicker().
			$scriptload;
	}
	
	function setPage_Content(){
		global $DataPengaturan;
		$YN = cekPOST2("YN");
		
		$dskrp = "daftarsuratpermohonanSKPD2fm";
		$c1 = $YN == "1"?cekPOST2($dskrp."URUSAN",0):"";
		$c = $YN == "1"?cekPOST2($dskrp."SKPD"):"";
		$d = $YN == "1"?cekPOST2($dskrp."UNIT"):"";
		$e = $YN == "1"?cekPOST2($dskrp."SUBUNIT"):"";
		$e1 = $YN == "1"?cekPOST2($dskrp."SEKSI"):"";
		
		$Id=$_REQUEST["daftarsuratpermohonan_cb"];
		
		$data = InputTypeHidden("c1",$c1).
				InputTypeHidden("c",$c).
				InputTypeHidden("d",$d).
				InputTypeHidden("e",$e).
				InputTypeHidden("e1",$e1).
				InputTypeHidden("idubah",$Id[0]).
				InputTypeHidden("databaru",$YN).
				InputTypeHidden("haljns_sppnya",cekPOST2("jns_spp","1"));
		
		return $data.$this->genDaftarInitial();
		
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
	 $databaru = cekPOST2("databaru");
	 $thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 
	if($databaru == '2'){
		$Idplh = cekPOST("idubah");
		$qry_det = $DataPermohonan->Gen_QueryTabel_Spp($Idplh);$cek.=$qry_det["cek"];
		$dt = $qry_det["content"];
		
		$getTgl_SPM = $dt['tgl_spm'] == "" || $dt['tgl_spm'] == "0000-00-00"?date("Y-m-d"):$dt['tgl_spm'];
		
		$dt_penyedia = $DataPermohonan->Get_PenerimaUang($dt['refid_penyedia'], $dt["refid_penyedia_jns"]);
		
	}	
	
	//Deklarasi SKPD
	$c1 = $databaru == '2'?$dt["c1"]:cekPOST2("c1");
	$c = $databaru == '2'?$dt["c"]:cekPOST2("c");
	$d = $databaru == '2'?$dt["d"]:cekPOST2("d");
	$e = $databaru == '2'?$dt["e"]:cekPOST2("e");
	$e1 = $databaru == '2'?$dt["e1"]:cekPOST2("e1");
	
	$nomor_spp = $databaru == '2'?$dt["nomor_spp"]:"";	
	$IdSPP = $databaru == '2'?$dt["Id"]:"";	
	$BTN_CR_no_spp= $databaru=="1"?InputTypeButton("cariNoSPP","CARI","onclick='".$this->Prefix.".CariIdSPP()'"):""; 
	$jenis_tagihan = $databaru == '2'?$DataPermohonan->Get_JenisTagihanSPP($dt["refid_nomor_tagihan"]):"";	
	$nomor_spm = $databaru == '2'?$dt["nomor_spm"]:"";		
	$tgl_spm = $databaru == "2"?FormatTanggalBulan($getTgl_SPM):date("d-m");
	$thn_spm = $databaru == "2"?GetTahunFromDB($getTgl_SPM):$thn_anggaran;	
	
	$uraian = $dt["uraian_spm"]==""?$dt["uraian"]:$dt["uraian_spm"]; 	
	$uraian = $databaru == '2'?$uraian:"";
	
	$data_NmPenerima = $databaru == '2'?$dt_penyedia["nama"]:"";
	$data_BankPenerima = $databaru == '2'?$dt_penyedia["bank"]:"";
	$data_RekPenerima = $databaru == '2'?$dt_penyedia["no_rekening"]:"";
	$data_NpwpPenerima = $databaru == '2'?$dt_penyedia["npwp"]:"";
	
	$penandatanganan_nama=$databaru == '2'?$dt["refid_ttd_spm"]:"";
	$penandatanganan_nip="";
	$penandatanganan_jabatan="";
	
	//Query -------------------------------------------------------------------------------------------------
	$qry_ttd = "SELECT Id, nama FROM ref_tandatangan WHERE c1='$c1' AND c='$c' AND d='$d' AND kategori_tandatangan='$DataPengaturan->kat_TTD_SPM' ";
	
	//STYLE -------------------------------------------------------------------------------------------------
	$style1_RdOnly="readonly style='width:300px;'";
		
	$TampilOpt =
			$vOrder=
			$DataPengaturan->GenViewHiddenSKPD($c1, $c, $d, $e, $e1).
			$DataPengaturan->GenViewSKPD($c1, $c, $d, $e, $e1).
			genFilterBar(
			array(
				$DataPengaturan->isiform(
					array(
						array(
							'label'=>'NOMOR SPP',
							'label-width'=>'200px;',
							'value'=>InputTypeText("nomor_spp", $nomor_spp, $style1_RdOnly)." ".
									 $BTN_CR_no_spp.
									 InputTypeHidden("IdSPP",$IdSPP),
						),
						array(
							'label'=>'JENIS TAGIHAN',
							'value'=>InputTypeText("jenis_tagihan",$jenis_tagihan, $style1_RdOnly),
						),
						array(
							'label'=>'NOMOR SPM',
							'value'=>
								InputTypeText("nomor_spm_no","", "style='width:40px;text-align:right;' maxlength='4'")." ".
								InputTypeText("nomor_spm_ket","", "style='width:130px;' readonly"),
						),
						array(
							'label'=>'TANGGAL SPM',
							'value'=>
								InputTypeText("tgl_spm",$tgl_spm,"placeholder='TANGGAL' maxlength='5' style='width:40px;' class='datepicker2' " )." ".
								InputTypeText("thn_spm",$thn_spm,"placeholder='TAHUN' maxlength='4' style='width:40px;' readonly" ),
						),
						array(
							'label'=>'URAIAN',
							'label-width'=>'200px;',
							'value'=>InputTypeTextArea("uraian",$uraian," style='width:300px;height:50px;'"),
						),
						array(
							'label'=>'<b>PENERIMA</b>',
							'pemisah'=>'',
						),
						array(
							'label'=>'<span style="margin-left:10px;">NAMA</span>',
							'label-width'=>'200px',
							'value'=>
									InputTypeText("nama_penerima_uang",$data_NmPenerima,$style1_RdOnly." placeholder='NAMA'"),
						),
						array(
							'label'=>'<span style="margin-left:10px;">BANK</span>',
							'label-width'=>'200px',
							'value'=>
									InputTypeText("bank_penerima_uang",$data_BankPenerima,$style1_RdOnly." placeholder='BANK'"),
						),
						array(
							'label'=>'<span style="margin-left:10px;">REKENING</span>',
							'label-width'=>'200px',
							'value'=>
									InputTypeText("rek_penerima_uang",$data_RekPenerima,$style1_RdOnly." placeholder='REKENING'"),
						),
						array(
							'label'=>'<span style="margin-left:10px;">NPWP</span>',
							'label-width'=>'200px',
							'value'=>
									InputTypeText("npwp_penerima_uang",$data_NpwpPenerima,$style1_RdOnly." placeholder='NPWP'"),
						),
						array(
							'label'=>'<b>PENANDATAGANAN</b>',
							'pemisah'=>'',
						),
						array(
							'label'=>'<span style="margin-left:10px;">NAMA</span>',
							'label-width'=>'200px',
							'value'=>
									cmbQuery("refid_ttd_spm", $penandatanganan_nama, $qry_ttd," style='width:300px;' onchange='".$this->Prefix.".Get_PenandatanganSPM();'","--- PILIH PENANDATANGAN ---"),
						),
						array(
							'label'=>'<span style="margin-left:10px;">NIP</span>',
							'label-width'=>'200px',
							'value'=>
									InputTypeText("penandatanganan_nip",$penandatanganan_nip,$style1_RdOnly." placeholder='NIP'"),
						),
						array(
							'label'=>'<span style="margin-left:10px;">JABATAN</span>',
							'label-width'=>'200px',
							'parrams'=>"style='width:300px;' readonly placeholder='REKENING'",
							'value'=>
									InputTypeText("penandatanganan_jabatan",$penandatanganan_jabatan,$style1_RdOnly." placeholder='JABATAN'"),
						),
					)
				)
			
			),'','','').
			"<div id='rincian_spm'></div>".
			"<div id='tbl_potongan_pajak'></div>".
			genFilterBar(
			array(
				
				"<table>
					<tr>							
						<td>".$DataPengaturan->buttonnya($this->Prefix.'.SimpanSemua()','checkin.png','SIMPAN','SIMPAN','SIMPAN')."</td>
						<td>".$DataPengaturan->buttonnya($this->Prefix.'.BatalSemua()','cancel_f2.png','BATAL','BATAL','BATAL')."</td>
					</tr>".
				"</table>"
				
			
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
		global $DataPengaturan, $Main, $DataPermohonan, $HTTP_COOKIE_VARS;
		
		$proses=TRUE;
		$thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$no_spm = "";
		$cek='';$err='';$content='';
		$tgl_spm = FormatTanggalnya(cekPOST2("tgl_spm")."-".$thn_anggaran);
		$c1 = cekPOST2("c1nya");
		$c = cekPOST2("cnya");
		$d = cekPOST2("dnya");
		$IdSPP = cekPOST2("IdSPP");
		
		$qry_spp = $DataPermohonan->Gen_QueryTabel_Spp($IdSPP);$cek.=$qry_spp["cek"];
		$dt_spp = $qry_spp["content"];
		
		if($proses == TRUE && $IdSPP == "")$proses=FALSE;
		if($proses == TRUE && ($dt_spp["Id"] == "" && $dt_spp["Id"] == NULL))$proses=FALSE;
		if($proses == TRUE && !cektanggal($tgl_spm))$proses=FALSE;
		$content["nomor"]="";
		$content["keterangan"]="";
		if($proses == TRUE){			
			if($dt_spp["nomor_spm"] == "" ||$dt_spp["nomor_spm"] == NULL){
				$data_cari = array(
								array("Id", $dt_spp["Id"], "!="),
								array("sttemp", "0"),
								array("nomor_spm", "", "!="),
								array("c1", $c1),
								array("c", $c),
								array("d", $d),
								array("status", "2",">="),
								array("jns_spp", $dt_spp["jns_spp"]),
								array("tahun", $thn_anggaran),
							);
				$qry = $DataPengaturan->QyrTmpl1Brs2("t_spp", "Id, nomor_spm", $data_cari," ORDER BY substr(nomor_spm, 1, 4) DESC");$cek.=$qry["cek"];
				$dt = $qry["hasil"];
				
				$jenis_spp = $DataPengaturan->Daftar_arr_pencairan_dana_SPM2[$dt_spp["jns_spp"]];
				if($dt["Id"] == "" || $dt["Id"] == NULL){
					$NoSPM = "0001";
				}else{
					$getNoSPM = explode("/",$dt["nomor_spm"]);
					$NoSPM = intval($getNoSPM[0]) + 1;
					if(strlen($NoSPM) == 1)$NoSPM="000".$NoSPM;
					if(strlen($NoSPM) == 2)$NoSPM="00".$NoSPM;
					if(strlen($NoSPM) == 3)$NoSPM="0".$NoSPM;
				}
				$no_spm="$NoSPM/$c1.$c.$d/$jenis_spp/$thn_anggaran";
			}else{
				$no_spm=$dt_spp["nomor_spm"];
			}
			
			$data = explode("/",$no_spm);
			
			$content["nomor"]=$data[0];
			$content["keterangan"]="/".$data[1]."/".$data[2]."/".$data[3];
		}		
		
		//$err="";
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
	
	function tabelPotonganPajak(){
		global $DataPengaturan;
			
		$cek = '';
		$err = '';
		$datanya='';
		$content=array();
		
		$Idplh = cekPOST2("IdSPP");
		$status_del = cekPOST2("status");
		
		if($status_del == 1){
			$qrydel = "DELETE FROM t_spp_potongan WHERE refid_spp='$Idplh' AND status='1'";$cek.=$qrydel;
			$aqrydel = mysql_query($qrydel);
		}
		
		$qry = "SELECT a.*, b.nm_rekening FROM v1_spp_potongan a LEFT JOIN ref_rekening b ON a.k=b.k AND a.l=b.l AND a.m=b.m AND a.n=b.n AND a.o=b.o WHERE refid_spp='$Idplh' AND a.status != '2' ORDER BY Id DESC";$cek.=$qry;		
		$aqry = mysql_query($qry);
		
		$no=1;
		while($dt = mysql_fetch_array($aqry)){
			$nama_rekening= $dt["nm_rekening"] == "" ? "": $dt["nm_rekening"];
			$uraian_ket= $dt["nama_potongan"] == "" ? "": $dt['nama_potongan']."<br>".$dt['uraian_rek'];
			$jumlahnya= $dt['jumlah'] == 0 ? "":number_format($dt['jumlah'],2,",",".");
			$kodeRek = $DataPengaturan->Gen_valRekening($dt);
			
			$uraian_ket = LabelSPan1("uraian_ket_".$dt['Id'],$dt['nama_potongan']."<br>".$dt['uraian_rek']);
			$nama_rekening = LabelSPan1("uraian_rekening_".$dt['Id'], $dt["nm_rekening"]);
			$jumlahnya = LabelSPan1("jumlahnya_".$dt['Id'], $jumlahnya);
						
			if($dt['status'] == '1'){
				$this->Ada_Status=1;				
				$kode = 
					InputTypeText("koderek",$kodeRek,"style='width:80px;' maxlength='12'").
					InputTypeHidden("refid_potongan_spm",$dt['refid_potongan_spm']).
					InputTypeHidden("Id_spp_rek",$dt['Id']).
					BtnImg_Cari($this->Prefix.".CariPotongan();'");				
				$btn =BtnImgSave($this->Prefix.".updKodeRek($jns)");
			}else{
				$fm_uraian_rek = "uraian_rekening_".$dt['Id'];
				$kode = LabelSPan1("kd_RekPotongan_".$dt['Id'],BtnText($kodeRek,$this->Prefix.".UpdateRekeningPajak(`".$dt['Id']."`);'"));
				$btn =BtnImgDelete($this->Prefix.".HapusRekening(".$dt['Id'].")'");					
			}
			
			$Kolom_BTN = "<td class='GarisDaftar' align='center'>".LabelSPan1("option_".$dt['Id'],$btn)."</td>";
			$datanya.="
				<tr class='row0'>
					<td class='GarisDaftar' align='right'>$no</td>
					<td class='GarisDaftar' align='center' width='140px;'>$kode</td>
					<td class='GarisDaftar'>$nama_rekening</td>
					<td class='GarisDaftar' align='left'>$uraian_ket</td>
					<td class='GarisDaftar' align='right'>$jumlahnya</td>
					$Kolom_BTN
				</tr>
			";
			$no = $no+1;
			$jml_harga = $jml_harga+floatval($dt['jumlah']);
		}
				
		$TombolBaru=$this->Ada_Status == 1?BtnImgCancel($this->Prefix.".tabelPotonganPajak()"):BtnImgAdd($this->Prefix.".BaruPotonganPajak()");
		
		$Kolom_BTN_TombolBaru = "<th class='th01'>
									<span id='atasbutton'>
									$TombolBaru
									</span>
								</th>";
		$content['tabel'] =
			genFilterBar(array("<span style='color:black;font-size:14px;font-weight:bold;'/>POTONGAN SPM</span>"),'','','').
			genFilterBar(
				array("
					<table class='koptable' style='min-width:1024px;' border='1'>
						<tr>
							<th class='th01'>NO</th>
							<th class='th01'>REKENING</th>
							<th class='th01'>URAIAN REKENING POTONGAN</th>
							<th class='th01'>POTONGAN SPM</th>
							<th class='th01'>NILAI (Rp)</th>
							$Kolom_BTN_TombolBaru
						</tr>
						$datanya
						<tr class='row0'>
							<td class='GarisDaftar' colspan='4' align='center'><b>TOTAL</b></td>
							<td class='GarisDaftar' align='right'><b>".number_format($jml_harga,2,".",",")."</b></td>
							<th class='GarisDaftar'></th>
						</tr>
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
	
	function BaruPotonganPajak(){
		global $Main, $DataPengaturan,$DataPermohonan,$HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];		
		$IdSPP= cekPOST2('IdSPP');
		
		if($err == "" && $IdSPP == '')$err="Nomor SPP Belum di Isi !";
		if($err == ""){
			$qrydel = "DELETE FROM t_spp_potongan WHERE refid_spp='$IdSPP' AND status='1' AND uid='$uid'";$cek.=$qrydel;
			$aqrydel = mysql_query($qrydel);
			
			if($aqrydel){
				$data = array(
							array("refid_spp",$IdSPP),
							array("status","1"),
							array("uid",$uid),
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
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$uid = $HTTP_COOKIE_VARS['coID'];
				
		$IdSPPnya = cekPOST2("IdSPP");
		$jns = cekPOST2("jns");
		$refid_potongan_spm = cekPOST2("refid_potongan_spm");
		$idrek = cekPOST2("Id_spp_rek");
		
		$qry = $DataPengaturan->QyrTmpl1Brs("v1_ref_potongan_spm_rek", "*","WHERE Id='$refid_potongan_spm' ");$cek.=$qry["cek"];
		$dt = $qry["hasil"];		
		if($err == "" && ($dt["Id"] == ''|| $dt["Id"] == NULL))$err="Rekening Tidak Valid ! Silahkan Pilih Ulang !";
		
		//if($err == "")$err="dffdg";		
		if($err == ""){
			$jml_harga = ($DataPermohonan->Get_QueryTotalRekSPP($IdSPPnya) * $dt["persen"]) / 100;
			$data_upd = array(array("status","2"));
			$qry_upd = $DataPengaturan->QryUpdData("t_spp_potongan",$data_upd, "WHERE Id='$idrek'");$cek.=" | ".$qry_upd["cek"];
			
			$data_ins =
				array(
					array("jumlah", $jml_harga),
					array("status", "0"),
					array("sttemp", "1"),
					array("tahun", $coThnAnggaran),
					array("refid_spp", $IdSPPnya),
					array("uid", $uid),
					array("refid_potongan_spm", $dt["Id"]),
				);
			$qry_ins = $DataPengaturan->QryInsData("t_spp_potongan",$data_ins);$cek.=" | ".$qry_ins["cek"];			
		}		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function HapusRekeningPajak(){
		global $Main, $DataPengaturan,$DataPermohonan,$HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		
		$IdPotongan = cekPOST2("idrekei");
		$IdSPPnya = cekPOST2("IdSPP");
		
		$qry_cek = $DataPengaturan->QyrTmpl1Brs("t_spp_potongan", "Id", "WHERE Id='$IdPotongan' AND refid_spp='$IdSPPnya'");
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
		$cek='';$err='';$content=array();
		
		$IdPotongan = cekPOST2("idna");
		$IdSPPnya = cekPOST2("IdSPP");
		
		$qry_cek = $DataPengaturan->QyrTmpl1Brs("t_spp_potongan", "Id, k,l,m,n,o,refid_potongan_spm", "WHERE Id='$IdPotongan' AND refid_spp='$IdSPPnya'");
		$dt_cek = $qry_cek["hasil"];$cek.=$qry_cek["cek"];
		$kodeRek = $DataPengaturan->Gen_valRekening($dt_cek);
		
		$content['inputan'] =	
			InputTypeText("koderek",$kodeRek,"style='width:80px;' maxlength='13'").
			InputTypeHidden("refid_potongan_spm",$dt_cek['refid_potongan_spm']).
			InputTypeHidden("Id_spp_rek",$dt_cek['Id']).
			BtnImg_Cari($this->Prefix.".CariPotongan();'");	
		$content["atasbutton"] = BtnImgCancel($this->Prefix.".tabelPotonganPajak()");
		$content["option"] =BtnImgSave($this->Prefix.".updKodeRek($jns)");
		
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
		$qry = $DataPengaturan->QryDelData("t_spp_potongan", "WHERE refid_spp='$IdSPPnya' AND sttemp='1'");$cek.=$qry["cek"];
		
		//UPDATE t_spp_potongan
		$data_upd = array(array("status",'0'));
		$qry_upd = $DataPengaturan->QryUpdData("t_spp_potongan",$data_upd,"WHERE refid_spp='$IdSPPnya' AND sttemp='0' ");
		$cek.=$qry_upd['cek'];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_DataSPP(){
		global $DataPermohonan;
		$err="";$cek='';$content=array();
		
		$Idplh = cekPOST2("IdSPP");
		$qry_det = $DataPermohonan->Gen_QueryTabel_Spp($Idplh);$cek.=$qry_det["cek"];		
		$content = $qry_det["content"];		
		
		$content["jenis_tagihan"] = $DataPermohonan->Get_JenisTagihanSPP($content["refid_nomor_tagihan"]);
		
		$dt_penyedia = $DataPermohonan->Get_PenerimaUang($content['refid_penyedia'], $content["refid_penyedia_jns"]);
		$content["uraian"] = $content["uraian_spm"]==""?$content["uraian"]:$content["uraian_spm"];		
		$content["nama_penerima_uang"] = $dt_penyedia["nama"];
		$content["bank_penerima_uang"] = $dt_penyedia["bank"];
		$content["rek_penerima_uang"] = $dt_penyedia["no_rekening"];
		$content["npwp_penerima_uang"] = $dt_penyedia["npwp"];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_RincianSPM_GetProgKeg($dt, $cssclass){
		global $DataPengaturan;
		$content="";
		$Program = $DataPengaturan->Gen_valProgram($dt);
		if($this->program != $Program){
			$row=$this->pidurutan%2==0?"row1":"row0";
			$content.=
				"<tr class='$row'>".
					Tbl_Td("","right",$cssclass,2).
					Tbl_Td("<b>".$dt["nm_program"]."</b>","left",$cssclass).
					Tbl_Td("","right",$cssclass).
				"</tr>";
			$this->pidurutan++;
		}
		$this->program=$Program;
		
		$kegiatan = $DataPengaturan->Gen_valKegiatan($dt);
		if($this->kegiatan != $kegiatan){
			$row=$this->pidurutan%2==0?"row1":"row0";
			$content.=
				"<tr class='$row'>".
					Tbl_Td("","right",$cssclass,2).
					Tbl_Td(LabelSPan1("ket_",$dt["nm_kegiatan"],"style='margin-left:5px;font-weight:bold;'"),"left",$cssclass).
					Tbl_Td("","right",$cssclass).
				"</tr>";
			$this->pidurutan++;
		}
		$this->kegiatan=$kegiatan;
		
		return $content;
	}
	
	function Get_RincianSPM(){
		global $DataPermohonan, $DataPengaturan;
		$err="";$cek='';$content="";
		
		$datanya='';
		$IdSPP=cekPOST2("IdSPP");
		$qry_spp = $DataPermohonan->Gen_QueryTabel_Spp($IdSPP);
		$dt_spp = $qry_spp["content"];
		
		$qry = $DataPermohonan->Gen_Query_viewRekSPP($dt_spp["Id"],$dt_spp["refid_nomor_spd"]);		
		if($dt_spp["jns_spp"] != "1")$qry = "SELECT * FROM ".$DataPermohonan->View_SPPRek2." WHERE sttemp='0' AND refid_spp='".$dt_spp["Id"]."'";
		$aqry = mysql_query($qry);		
		$no=1;
		$this->pidurutan=1;
		$jml_rek=0;
		while($dt = mysql_fetch_array($aqry)){	
			$row=$this->pidurutan%2==0?"row1":"row0";
			$cssclass="class='GarisDaftar'";			
			$kodeRekening=$DataPengaturan->Gen_valRekening($dt);
			$namaKeterangan= $dt["nm_program"]."/ <br>".$dt["nm_kegiatan"]."/ <br>".$dt["nm_rekening"];		
			$dataProgKeg = $dt_spp["jns_spp"] == "1"?$this->Get_RincianSPM_GetProgKeg($dt, $cssclass):"";	
			
			$datanya.=
				$dataProgKeg.
				"<tr class='$row'>
					".Tbl_Td($no,"right",$cssclass."style='width:25px'")."	
					".Tbl_Td($kodeRekening,"center",$cssclass)."	
					".Tbl_Td(LabelSPan1("rek_",$dt["nm_rekening"],"style='margin-left:10px'"),"left",$cssclass)."	
					".Tbl_Td(FormatUang($dt['jumlah']),"right",$cssclass)."
					</tr>";
			$no++;
			$jml_rek+=$dt['jumlah'];
			$this->pidurutan++;
		}
		
		$row=$this->pidurutan%2==0?"row1":"row0";
		$content=
				genFilterBar(array("<span style='color:black;font-size:14px;font-weight:bold;'/>RINCIAN SPM</span>"),'','','').
				genFilterBar(array("
					<table class='koptable' style='min-width:1024px;' border='1'>
						<tr>
							<th class='th01'>NO</th>
							<th class='th01' width='100px'>REKENING</th>
							<th class='th01'>URAIAN</th>
							<th class='th01'>JUMLAH (Rp)</th>
						</tr>
						$datanya
						<tr class='$row'>".
							Tbl_Td("<b>TOTAL</b>","center",$cssclass." colspan='3'").
							Tbl_Td("<b>".FormatUang($jml_rek)."</b>","right",$cssclass).
						"
						</tr>
						
					</table>"
				),'','','');
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_PenandatanganSPM(){
		global $DataPermohonan;
		$err="";$cek='';$content=array();
		
		$refid_ttd_spm = cekPOST2("refid_ttd_spm", cekPOST2("refid_ttd_sp2d"));
		$getData = $DataPermohonan->Gen_QueryTabel_ref_tandatangan($refid_ttd_spm);
		
		$content["penandatanganan_nip"]=$getData["nip"];
		$content["penandatanganan_jabatan"]=$getData["jabatan"];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_DataPotonganSPM(){
		global $DataPengaturan, $DataPermohonan;
		$cek = ''; $err=''; $content='';
		
		$Id = cekPOST2("refid_potongan_spm"); 
		$IdSPP = cekPOST2("IdSPP");
		$Idplh = cekPOST2("Id_spp_rek");
		 
		$qry = $DataPengaturan->QyrTmpl1Brs("v1_ref_potongan_spm_rek", "*","WHERE Id='$Id' ");$cek.=$qry["cek"];
		$dt = $qry["hasil"];
		
		if($dt["Id"] == NULL || $dt["Id"] == "")$err="Data Tidak Valid !";
		if($err == ""){		
			$dt_sppRek = $DataPermohonan->Get_QueryTotalRekSPP($IdSPP);
			
			$jumlah = ($dt_sppRek * $dt["persen"])/100;
			$jumlah = FormatUang($jumlah);
					
			$content['Id']=$Idplh;					
			$content['koderek']=$DataPengaturan->Gen_valRekening($dt);					
			$content['uraian_rekening']=$dt["nm_rekening"];					
			$content['uraian_ket']=$dt["uraian_rek"]." ".$dt["persen"]."%";					
			$content['jumlahnya']=$jumlah;					
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

}
$suratpermohonan_spm = new suratpermohonan_spmObj();
?>