<?php

class ref_rekening_bendaharaObj  extends DaftarObj2{	
	var $Prefix = 'ref_rekening_bendahara';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_norek_bendahara'; //daftar
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
	var $PageTitle = 'Referensi Rekening Bendahara';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
//	var $fileNameExcel='ref_tim_anggaran.xls';
//	var $Cetak_Judul = 'Referensi Peraturan Daerah';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_rekening_bendaharaForm'; 
	var $kdbrg = '';	
	
	function setTitle(){
		return 'REFERENSI REKENING BENDAHARA';
	}
	function setMenuEdit(){		
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus').
			"</td>";
	}
	
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		
		//$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD'); //echo 'fmskpd='.$fmSKPD;
		//$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		//$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>";	
	}	
	
	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
     $kode0 = $_REQUEST['fmc1'];
     $kode1= $_REQUEST['fmc'];
	 $kode2= $_REQUEST['fmd'];
	 $npwp= $_REQUEST['npwp'];
	 $nip_pegawai= $_REQUEST['nip_pegawai'];
	 $nm_pegawai= $_REQUEST['nm_pegawai'];
	 $alamat= $_REQUEST['alamat'];
	 $rek_bank= $_REQUEST['rek_bank'];
	 $nm_bank= $_REQUEST['nm_bank'];
	 
     if( $err=='' && $kode0 =='' ) $err= 'Urusan Belum di Pilih !!';
	 if( $err=='' && $kode1 =='' ) $err= 'Bidang Belum Di Pilih !!';
	 if( $err=='' && $kode2 =='' ) $err= 'SKPD Belum Di Pilih !!';
	 if( $err=='' && $npwp =='' ) $err= 'No NPWP Belum Di Isi !!';
	 if( $err=='' && $nip_pegawai =='' ) $err= 'NIP Pegawai Belum Di Isi !!';
	 if( $err=='' && $nm_pegawai =='' ) $err= 'Nama Pegawai Belum Di Isi !!';
	 if( $err=='' && $alamat =='' ) $err= 'Alamat Belum Di Isi !!';
	 if( $err=='' && $rek_bank =='' ) $err= 'Rekening Bank Belum Di Isi !!';
	 if( $err=='' && $nm_bank =='' ) $err= 'Nama Bank Belum Di Isi !!';
	
	
			if($fmST == 0){
			
			if($err=='' && $oldy['cnt']>0) $err="No Tagihan '$noTagihan' Sudah Ada";
			
				if($err==''){
				$aqry = "INSERT into ref_norek_bendahara (c1,c,d,nama,nip,alamat,bank,no_rekening,npwp) values('$kode0','$kode1','$kode2','$nm_pegawai','$nip_pegawai','$alamat','$nm_bank','$rek_bank','$npwp')";	$cek .= $aqry;	
				$qry = mysql_query($aqry);
				}
			}else{
				
			if($err==''){
				$aqry = "UPDATE ref_norek_bendahara SET c1='$kode0',c='$kode1', d='$kode2',nama='$nm_pegawai', nip='$nip_pegawai', alamat='$alamat',bank='$nm_bank',no_rekening='$rek_bank',npwp='$npwp' WHERE Id='".$idplh."'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());
					}
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
		
		case 'pilihUrusan':{				
			global $Main;
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$queryc="SELECT c, concat(c, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c!='00' and d='00' and e='00' and e1='000'" ;$cek.=$queryc;
			$content->c=cmbQuery('fmc',$fmc,$queryc,'style="width:500px;"onchange="'.$this->Prefix.'.pilihBidang()"','-------- Pilih Kode BIDANG ------------');
			
			$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d <> '00' and e='00' and e1='000'" ;$cek.=$queryd;
			$content->d=cmbQuery('fmd',$fmd,$queryd,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSKPD()"','-------- Pilih Kode SKPD ----------------');
			
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}
		
		case 'pilihBidang':{				
		global $Main;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
	 
			$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d !='00' and e='00' and e1='000'" ;$cek.=$queryd;
			$content->d=cmbQuery('fmd',$fmd,$queryd,'style="width:500px;""','-------- Pilih Kode SKPD ----------------');
			
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									break;
			}
				
		
		case 'HapusKategori':{	
				$fm= $this->HapusKategori($pil);
				$err= $fm['err']; 
				$cek = $fm['cek'];
				$content = $fm['content'];
		break;
		}
		
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
	
	 function Hapus($ids){ 
	global $Main;		
	
		$err=''; $cek='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		
		if ($err ==''){
		for($i = 0; $i<count($ids); $i++){	
		
		$tagihan=mysql_query("select * from t_spp where refid_penyedia='".$ids[$i]."'"); 
		
		if($err==''){
			if (mysql_num_rows($tagihan)>0)$err='Nama Tagihan Tidak bisa di Hapus sudah ada di Surat Permohonan !!';
		}
	
		if($err=='' ){
			$qy = "DELETE FROM ref_norek_bendahara WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		}
		}
		return array('err'=>$err,'cek'=>$cek);
	}
	
	function setPage_OtherScript(){
		$scriptload = 

					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			
			
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/upload_style.css' type='text/css'>".
			"<script src='js/jquery.js' type='text/javascript'></script>".			
			"<script src='js/jquery-ui.js' type='text/javascript'></script>".
			"<script src='js/jquery.min.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/jquery.form.js'></script> ".
			"<script src='js/jquery-ui.custom.js'></script>".
			"<script type='text/javascript' src='js/master/ref_rekening_bendahara/ref_bank2.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/master/ref_rekening_bendahara/ref_pegawai.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/master/ref_rekening_bendahara/ref_rekening_bendahara.js' language='JavaScript' ></script>".
			'
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>
			'.
			
			$scriptload;
	}
	
	//form ==================================
	
	function setFormBaru(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c1 = $_REQUEST[$this->Prefix.'SkpdfmUrusan'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		
		$cek = $cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
			
		$dt=array();
		
		$this->form_fmST = 0;
		$dat_urusan= $_REQUEST['dat_urusan'];
		
			$dt['c1'] = $_REQUEST['fmUrusan'];
			$dt['c'] = $_REQUEST['fmBidang'];
			$dt['d'] = $_REQUEST['fmSkpd'];
			
			$fm = $this->setForm($dt);
		
			return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormEdit(){
	global $Main;	
	$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = $cbid[0];
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  ref_norek_bendahara WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 680;
	 $this->form_height = 180;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU REKENING BENDAHARA';
		$nip	 = '';
		
	  }else{
		$this->form_caption = 'EDIT REKENING BENDAHARA';			
		$readonly='readonly';
		$jenis=mysql_fetch_array(mysql_query("select * from ref_jenis_tagihan where Id='".$dt['refid_jns_tagihan']."'"));
			$cek.="select * from ref_jenis_tagihan where Id='".$dt['refid_jns_tagihan']."'";		
	  }
	  
	  	$fmc1 = $_REQUEST['fmc1'];
		$fmc = $_REQUEST['fmc'];
		$fmd = $_REQUEST['fmd'];
							
		$queryc1="SELECT c1, concat(c1, '. ', nm_skpd) as vnama FROM ref_skpd where c1!='0' and c=00 and d=00 and e=00 and e1=000";
		$queryc="SELECT c,concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c!=00 and d=00 and e=00 and e1=000";
		$queryd="SELECT d,concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d!='00' and e=00 and e1=000";
	//	$queryJenis="SELECT Id,concat(Id, '. ', nm_tagihan) as vnama FROM ref_jenis_tagihan";	
		$queryJenis="SELECT nm_tagihan, nm_tagihan FROM ref_jenis_tagihan";	
		
		$this->form_fields = array(
		
			'urusan' => array( 
						'label'=>'URUSAN',
						'labelWidth'=>100, 
						'value'=>"<div id='cont_c1'>".cmbQuery('fmc1',$dt['c1'],$queryc1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihUrusan()"','-------- Pilih Kode URUSAN ------------')."</div>",
						 ),		
						 	
			'bidang' => array( 
						'label'=>'BIDANG',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_c'>".cmbQuery('fmc',$dt['c'],$queryc,'style="width:500px;"onchange="'.$this->Prefix.'.pilihBidang()"','-------- Pilih Kode BIDANG -----------')."</div>",
						 ),
						 		 
			'skpd' => array( 
						'label'=>'SKPD',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_d'>".cmbQuery('fmd',$dt['d'],$queryd,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSKPD()"','-------- Pilih Kode SKPD ---------------')."</div>",
						 ),	
						 
			'npwp' =>array(
							'label'=>'NPWP',
							'label-width'=>'200px;',
							'value'=>"<input type='text' name='npwp' id='npwp'  value='".$dt['npwp']."' placeholder='No NPWP' style='width:150px;' />",						
								),
			
			
			'pegawai' => array( 
						'label'=>'NAMA PEGAWAI',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='nip_pegawai' id='nip_pegawai' value='".$dt['nip']."' placeholder='NIP Pegawai' style='width:150px;'>
						&nbsp&nbsp
						<input type='text' name='nm_pegawai' id='nm_pegawai' value='".$dt['nama']."' placeholder='Nama Pegawai' style='width:280px;'>
						&nbsp&nbsp
						<input type='button' value='Cari' onclick ='".$this->Prefix.".cariPegawai()' title='Cari Kode Rekening' >
						</div>", 
						 ),	
						 
			'alamat' => array( 
						'label'=>'ALAMAT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>			
						<input type='text' name='alamat' id='alamat' value='".$dt['alamat']."' placeholder='Alamat' style='width:500px;' >
						</div>", 
						 ),
	
			'bank' => array( 
						'label'=>'BANK',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='rek_bank' id='rek_bank' value='".$dt['no_rekening']."' placeholder='Rekening Bank' style='width:150px;'>
						&nbsp&nbsp
						<input type='text' name='nm_bank' id='nm_bank' value='".$dt['bank']."' placeholder='Nama Bank' style='width:280;'>
						&nbsp&nbsp
						<input type='button' value='Cari' onclick ='".$this->Prefix.".cariBank()' title='Cari Kode Rekening' >
						</div>", 
						 ),				 			 
			);
		//tombol
		$this->form_menubawah =	
		"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >"."&nbsp&nbsp".
		"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setKolomHeader($Mode=1, $Checkbox=''){
	$NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox
	   <th class='th01' width='200' align='center'>NPWP</th>
	   <th class='th01' width='500' align='center'>Nama Pegawai</th>
	   <th class='th01' width='200' align='center'>NIP Pegawai</th>		
	   <th class='th01' width='600' align='center'>Alamat</th>
	   <th class='th01' width='300' align='center'>Bank</th>
	   <th class='th01' width='200' align='center'>Rekening Bank</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	$jenis=mysql_fetch_array(mysql_query("select * from ref_jenis_tagihan where Id='".$isi['refid_jns_tagihan']."'"));	
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$isi['npwp']);
	 $Koloms[] = array('align="left"',$isi['nama']);
	 $Koloms[] = array('align="left"',$isi['nip']);	
	 $Koloms[] = array('align="left"',$isi['alamat']);
	 $Koloms[] = array('align="left"',$isi['bank']);
	 $Koloms[] = array('align="left"',$isi['no_rekening']);
	 return $Koloms;
	}
	
	function setMenuView(){
		
			}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	
	$fmORDER1 = cekPOST('fmORDER1');
	$arrOrder = array(
	  	        array('1','NPWP'),
			    array('2','Nama Pegawai'),
			    array('3','NIP Pegawai'),
			    array('4','Nama Bank'),
			    array('5','Rekening Bank'),
				);
	
	$arr = array(
				
			array('selectNPWP','NPWP'),	
			array('selectNama_pegawai','Nama Pegawai'),		
			array('selectNip_pegawai','NIP Pegawai'),		
			array('selectNama_bank','Nama Bank'),		
			array('selectRekening_bank','Rekening Bank'),		
			);		
	$fmUrusan = cekPOST('fmUrusan');
	$fmBidang = cekPOST('fmBidang');
	$fmSkpd = cekPOST('fmSkpd');
	$noTagihan = cekPOST('noTagihan');
	$tanggal = cekPOST('tanggal');
				
		$TampilOpt = 
			"<div class='FilterBar'>".	
			"<table style='width:100%'>
			<tr>
			<td style='width:100px'>URUSAN</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery1("fmUrusan",$fmUrusan,"select c1,nm_skpd from ref_skpd where c1!='0' and c ='00' and d = '00' and e='00' and e1='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>BIDANG</td><td>:</td>
			<td>".
			cmbQuery1("fmBidang",$fmBidang,"select c,nm_skpd from ref_skpd where c1='$fmUrusan' and c!='00' and d = '00' and e='00' and e1='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SKPD</td><td>:</td>
			<td>".
			cmbQuery1("fmSkpd",$fmSkpd,"select d,nm_skpd from ref_skpd where c1='$fmUrusan' and c ='$fmBidang' and d != '00' and e='00' and e1='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			</table>".
			"</div>".
			$vOrder=			
			genFilterBar(
				array(
				""					
					.cmbArray('fmPILCARI',$fmPILCARI,$arr,'-- Cari Data --',''). //generate checkbox					
					"&nbsp&nbsp<input type='text' value='".$fmPILCARIvalue."' name='fmPILCARIvalue' id='fmPILCARIvalue'>&nbsp&nbsp."
					//<input type='button' id='btTampil' value='Cari' onclick='".$this->Prefix.".refreshList(true)'>"
					
					.cmbArray('fmORDER1',$fmORDER1,$arrOrder,'--Urutkan--','').
					"<input $fmDESC1 type='checkbox' id='fmDESC1' name='fmDESC1' value='checked'>&nbspmenurun."
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
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
	 	$fmUrusan = cekPOST('fmUrusan');
	 	$fmBidang = cekPOST('fmBidang');
	    $fmSkpd = cekPOST('fmSkpd');
		$noTagihan = cekPOST('noTagihan');
		$tanggal = cekPOST("tanggal");
		$tgl_tagih = explode("-", $tanggal);
		$tgl_tagihan = $tgl_tagih[2]."-".$tgl_tagih[1]."-".$tgl_tagih[0];
	//	$tanggal = $_REQUEST['tanggal'];
		//Cari 
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			
			case 'selectNPWP': $arrKondisi[] = " npwp like '$fmPILCARIvalue%'"; break;
			case 'selectNama_pegawai': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;	
			case 'selectNip_pegawai': $arrKondisi[] = " nip like '%$fmPILCARIvalue%'"; break;	
			case 'selectNama_bank': $arrKondisi[] = " bank like '%$fmPILCARIvalue%'"; break;	
			case 'selectRekening_bank': $arrKondisi[] = " no_rekening like '%$fmPILCARIvalue%'"; break;	
							 	
		}	
		
		
		if(empty($fmUrusan)) {
			$fmBidang = '';
			$fmSkpd='';
		}
		
		if(empty($fmBidang)) {
			$fmSkpd='';
		}
		
		if(empty($fmUrusan) && empty($fmBidang) && empty($fmSkpd))
		{
			
		}
		elseif(!empty($fmUrusan) && empty($fmBidang) && empty($fmSkpd))
		{
			$arrKondisi[]= "c1 =$fmUrusan";			
		}
		elseif(!empty($fmUrusan) && !empty($fmBidang) && empty($fmSkpd))
		{
			$arrKondisi[]= "c1 =$fmUrusan and d=$fmBidang";
						
		}
		elseif(!empty($fmUrusan) && !empty($fmBidang) && !empty($fmSkpd))
		{
			$arrKondisi[]= "c1 =$fmUrusan and c=$fmBidang and d=$fmSkpd";
							
		}
		
		if(!empty($_POST['noTagihan'])) $arrKondisi[] = " no_tagihan like '".$_POST['noTagihan']."%'";					
		if($tanggal != '')$arrKondisi[] = "tgl_tagihan='$tgl_tagihan'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " npwp $Asc1 " ;break;
			case '2': $arrOrders[] = " nama $Asc1 " ;break;
			case '3': $arrOrders[] = " nip $Asc1 " ;break;
			case '4': $arrOrders[] = " bank $Asc1 " ;break;
			case '5': $arrOrders[] = " no_rekening $Asc1 " ;break;
			
		}	
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
}
$ref_rekening_bendahara = new ref_rekening_bendaharaObj();
?>