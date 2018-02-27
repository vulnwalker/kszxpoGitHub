<?php
 include "pages/pencarian/DataPengaturan.php";
 $DataOption = $DataPengaturan->DataOption();
 
class cariIDBIObj  extends DaftarObj2{	
	var $Prefix = 'cariIDBI';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'v1_bi_skpd'; //bonus
	var $TblName_Hapus = 'buku_induk';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	//var $KeyFields = array('f1','f2','f','g','h','i','j');
	var $KeyFields = array('id');
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
	var $Cetak_Judul = 'cariIDBI';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'cariIDBIForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	function setTitle(){
		return 'DAFTAR BARANG';
	}
	
	function setMenuEdit(){
		return "";
	}
	
	function simpan(){
	 global $HTTP_COOKIE_VARS, $DataPengaturan;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 
	 $IdBI_plh = $_REQUEST['IdBI_plh'];
	 $nilai_kapitalisasi = $_REQUEST['nilai_kapitalisasi'];
	 $idTerima_det = $_REQUEST['idTerima_det'];
	 $jns_pemeliharaan = $_REQUEST['jns_pemeliharaan'];
	 
	  
	 if( $err=='' && $nilai_kapitalisasi =='' ) $err= 'Nilai Kapitalisasi Belum di Isi !!';
	 if( $err=='' && $jns_pemeliharaan =='' ) $err= 'Jenis Pemeliharaan Belum di Pilih !!';
	 
	 
	 if($err == ''){
	 //Ambil Data BI
	 	$qry_BI = $DataPengaturan->QyrTmpl1Brs("buku_induk","*", "WHERE id='$IdBI_plh' ");$cek.=' | '.$qry_BI['cek'];
		$dt_BI = $qry_BI['hasil'];
		
		$qry_pendet = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang_det","refid_terima", "WHERE Id='$idTerima_det' ");$cek.=' | '.$qry_pendet['cek'];
		$dt_pendet = $qry_pendet['hasil'];
		
		$data_input = array(
				array('c1', $dt_BI['c1']),
				array('c', $dt_BI['c']),
				array('d', $dt_BI['d']),
				array('e', $dt_BI['e']),
				array('e1', $dt_BI['e1']),
				array('f1', $dt_BI['f1']),
				array('f2', $dt_BI['f2']),
				array('f', $dt_BI['f']),
				array('g', $dt_BI['g']),
				array('h', $dt_BI['h']),
				array('i', $dt_BI['i']),
				array('j', $dt_BI['j']),
				array('jumlah', $nilai_kapitalisasi),
				array('refid_terima', $dt_pendet['refid_terima']),
				array('refid_penerimaan_det', $idTerima_det),
				array('status', '1'),
				array('jns_pemeliharaan', $jns_pemeliharaan),
				array('refid_buku_induk', $IdBI_plh),
				array('uid', $uid),
				array('sttemp', '1'),
				array('tahun', $coThnAnggaran),
			);
			
		$qry_inp = $DataPengaturan->QryInsData('t_distribusi',$data_input);
		if($qry_inp['errmsg'] != '')$err = $qry_inp['errmsg'];
		
		if($fmST == '1' && $err == ''){
			$IdDstr = $_REQUEST['IdDstr'];
			$data_upd = array(
					array("status","2"),
				);
			$qry_upd = $DataPengaturan->QryUpdData("t_distribusi", $data_upd, "WHERE Id='$IdDstr' ");
			if($qry_upd['errmsg'] != "")$err=$qry_upd['errmsg'];
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
	 global $Main, $DataOption;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	  
	  switch($tipe){	
			
		case 'PilBI':{				
			$fm = $this->setFormPilBI();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'PilBI2':{				
			$fm = $this->PilBI2();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'formEdit':{				
			$fm = $this->setFormEditPilBI();				
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
		
		case 'getid':{
				$cek = '';
				$err = '';
				$content = '';	
				
				$kodebarangambil = $_REQUEST['kodebarangambil'];
				if($idrekening == '' && $err == '')$err == "Data Belum Dipilih !";
				
				if($err == ''){
					$kode = explode(".",$kodebarangambil);
					
					if($DataOption['kode_barang'] == '1'){
						$where_kode = "concat(f,'.',g,'.',h,'.',i,'.',j)";
						$htng_stringKode = strlen($kode[4]);
						$kodei = $kode[4];
					}else{
						$where_kode = "concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j)";
						$htng_stringKode = strlen($kode[6]);
						$kodei = $kode[6];
					}
					
					$qry = "SELECT * FROM ref_barang WHERE $where_kode = '$kodebarangambil' ";$cek.=$qry;
					$aqry = mysql_query($qry);
					$daqry = mysql_fetch_array($aqry);
						
					
					if($htng_stringKode >= 3){
						if($kodei == '000' || $daqry['nm_barang'] == null){
							$err='Kode Tidak Valid !';
						}else{
							$content['kodebarang'] = $kodebarangambil;
							$content['namabarang'] = $daqry['nm_barang'];
							$content['satuan'] = $daqry['satuan'];
						}
					}else{
						$content['kodebarang'] = '';
						$content['namabarang'] = '';
						$content['satuan'] = '';
					}
					
					
		
				}
				
					
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
	
	function MaksimalKPTLS($refid_terima_det, $idDistribusi=''){
		global $DataPengaturan;
		//jumlah
		$where ='';
		$qry_pendet = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang_det", "*", "WHERE Id='$refid_terima_det' ");;
		$aqry_pendet = $qry_pendet['hasil'];
		
		$jml_brg = $aqry_pendet['jml_terima'] - $aqry_pendet['kuantitas'];
		
		$hartot = $jml_brg * ($aqry_pendet['dat_hargabeli1'] + $aqry_pendet['dat_atribusi1']);
		$hartot += ($aqry_pendet['kuantitas'] * ($aqry_pendet['dat_hargabeli2'] + $aqry_pendet['dat_atribusi2']));
		
		
		if($idDistribusi != '')$where = " AND Id !='$idDistribusi' ";
		$qry = $DataPengaturan->QyrTmpl1Brs("t_distribusi","IFNULL(SUM(jumlah),0) as jumlah", "WHERE refid_penerimaan_det='$refid_terima_det' AND status != '2' $where");
		$dt = $qry['hasil'];
		
		$maks = $hartot - $dt['jumlah'];
		return $maks;
	}
	
	//form ==================================
	function setFormPilBI(){
		global $DataPengaturan;
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		// Cek Harga Untuk Kapitalisasi
		$idTerima_det = cekPOST("idTerima_det");
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang_det", "*", "WHERE Id='$idTerima_det' ");;
		$aqry = $qry['hasil'];
		
		
		$qry_hit_KPTLS = $DataPengaturan->QryHitungData("t_distribusi", "WHERE refid_penerimaan_det='$idTerima_det' AND status!='2' ");
		$dt['jumlah'] = $aqry["dat_hargabeli2"] + $aqry["dat_atribusi2"];
		if($qry_hit_KPTLS['hasil'] > 0)$dt['jumlah'] = $aqry["dat_hargabeli1"] + $aqry["dat_atribusi1"];		
		
		if(($aqry['jml'] * $aqry['kuantitas']) != $aqry['kuantitas'])$dt['jumlah'] = $dt['jumlah'] * $aqry['kuantitas'];
		
		$dt["IDBI"] = $_REQUEST['IdBI'];
		$dt["jns_pemeliharaan"] = '';
		$dt['refid_terima_det'] = $_REQUEST['idTerima_det'];
		$dt['Id'] = '';
		$dt['kapitalisasikan'] = $aqry['barangdistribusi'];
		$dt['total_harga'] = $aqry['harga_total'];
		$dt['kuantitas'] = $aqry['kuantitas'];
		$dt['maks_kptls'] = $this->MaksimalKPTLS($idTerima_det);
		
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
   
  	function setFormEditPilBI(){
		global $DataPengaturan;
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;				
		//get data 
		$IdKPTLS = $_REQUEST['IdKPTLS'];
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_distribusi","*", "WHERE Id='$IdKPTLS' ");
		$dt = $qry['hasil'];
		
		$qry_terimaDet = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang_det", "*", "WHERE Id='".$dt['refid_penerimaan_det']."'");
		$dt_terimaDet = $qry_terimaDet['hasil'];
		
		
		$dt["IDBI"] = $dt['refid_buku_induk'];
		$dt["refid_terima_det"] = $dt['refid_penerimaan_det'];
		$dt['jumlah'] = intval($dt['jumlah']);
		$dt['kapitalisasikan'] = $dt_terimaDet['barangdistribusi'];
		$dt['total_harga'] = $dt_terimaDet['harga_total'];
		$dt['kuantitas'] = $dt_terimaDet['kuantitas'];
		$dt['maks_kptls'] = $this->MaksimalKPTLS($dt['refid_penerimaan_det'], $IdKPTLS);
		
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp, $DataPengaturan, $DataOption;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 550;
	 $this->form_height = 230;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARANG INVENTARIS YANG DIKAPITALISASI';
		$nip	 = '';
	  }else{
	  	$this->form_caption = 'BARANG INVENTARIS YANG DIKAPITALISASI';
	  }
	  if($dt['maks_kptls'] == 0)$dt['jumlah']=0;
	  $harga=number_format($dt['jumlah'],2,",",".");
	  
	  $IdBI = $dt["IDBI"];
	  $ambil_dtBI = $DataPengaturan->QyrTmpl1Brs("buku_induk", "*", "WHERE id='$IdBI' ");
	  $dt_BI = $ambil_dtBI['hasil'];
	  
	  $WHERE_C1 = '';
	  if($DataOption['skpd'] == '2')$WHERE_C1 = "c1='".$dt_BI['c1']."' AND";
	  $whereSKPD = "WHERE $WHERE_C1 c='".$dt_BI['c']."' AND d='".$dt_BI['d']."'  AND e='".$dt_BI['e']."' AND e1='".$dt_BI['e1']."'   ";
	  $qry_subunit = $DataPengaturan->QyrTmpl1Brs("ref_skpd", "concat(e1, '. ', nm_skpd) as isi", $whereSKPD);
	  $dt_subunit= $qry_subunit['hasil'];
	  
	  
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		$pmlhrn = "1";
		if($dt['kapitalisasikan'] == "0")$pmlhrn = "2";
		
		
		$qry_jns_pemeliharaan = "SELECT jenis, jenis FROM ref_jenis_pemeliharaan WHERE menambah_aset='$pmlhrn'";
		
	 //items ----------------------
	  $this->form_fields = array(
				'subunit' => array( 
					'label'=>'SUBUNIT',
					'labelWidth'=>140, 
					'value'=>$dt_subunit['isi'], 
					'type'=>'text',
					'param'=>"style='width:350px;' readonly"
					),
				'noreg' => array( 
					'label'=>'NOREG/ TAHUN',
					'labelWidth'=>140, 
					'value'=>"<input type='text' name='noreg' id='noreg' value='".$dt_BI['noreg']."' style='width:40px;text-align:right;' readonly /> / "."<input type='text' name='tahun' id='tahun' value='".$dt_BI['thn_perolehan']."' style='width:40px;text-align:right;' readonly />", 
					),
				'merk' => array( 
					'label'=>$this->PilihNamaLabel($dt_BI['f']),
					'labelWidth'=>140, 
					'value'=>"<textarea name='ket' id='ket' style='width:350px;height:40px;' readonly>".$DataPengaturan->AmbilUraianBarang($IdBI)."</textarea>",
					),	
				'jumlah_harga' => array( 
					'label'=>'JUMLAH HARGA',
					'labelWidth'=>140, 
					'value'=>number_format($dt['total_harga'],2,",","."), 
					'type'=>'text',
					'param'=>"style='width:150px;text-align:right;' readonly"
					),	
				'kuantitas' => array( 
					'label'=>'KUANTITAS',
					'labelWidth'=>140, 
					'value'=>number_format($dt['kuantitas'],0,".",","), 
					'type'=>'text',
					'param'=>"style='width:93px;text-align:right;' readonly"
					),
				'maxs_kptls' => array( 
					'label'=>'SISA KAPITALISASI',
					'labelWidth'=>140, 
					'value'=>number_format($dt['maks_kptls'],2,",","."), 
					'type'=>'text',
					'param'=>"style='width:150px;text-align:right;' readonly"
					),
				/*'hrg_perolehan' => array( 
					'label'=>"HARGA PEROLEHAN",
					'labelWidth'=>140, 
					'value'=>number_format($dt_BI['harga'],2,",","."), 
					'type'=>'text',
					'param'=>"style='width:150px;text-align:right;' readonly"
					),*/
				'nilai_kapitalisasi' => array( 
					'label'=>"NILAI KAPITALISASI",
					'labelWidth'=>140, 
					'value'=>"<input type='text' name='nilai_kapitalisasi' id='nilai_kapitalisasi' value='".$dt['jumlah']."' style='width:150px;text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = pemasukan_kapitalisasi.formatCurrency(this.value);' /> <span id='formatjumlah'>$harga</span>",
					),
				'jns_pemeliharaan' => array( 
					'label'=>"JENIS PEMELIHARAAN",
					'labelWidth'=>140, 
					'value'=>cmbQuery('jns_pemeliharaan',$dt['jns_pemeliharaan'],$qry_jns_pemeliharaan, "style='width:150px';", "PILIH"),
					),					
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='hidden' value='".$dt['refid_terima_det']."' name='idTerima_det' id='idTerima_det' >".
			"<input type='hidden' value='$IdBI' name='IdBI_plh' id='IdBI_plh' >".
			"<input type='hidden' value='".$dt['Id']."' name='IdDstr' id='IdDstr' >".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' > ".
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
	  	   <th class='th01' width='5'>NO.</th>".
	  	   /*$Checkbox*/"
		   <th class='th01'>NO REG/ TAHUN</th>
		   <th class='th01'>KODE/ NAMA BARANG</th>
		   <th class='th01'>MERK/TYPE/SPESIFIKASI/LOKASI</th>
		   <!--<th class='th01'>HARGA PEROLEHAN</th>-->
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref,$DataOption, $DataPengaturan;
	 
	 //KODE BARANG ----------------------------------------------------------------------------------------
	 $KodeBarang = $isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'];
	 if($DataOption['kode_barang'] == '2')$KodeBarang=$isi['f1'].".".$isi['f2'].$KodeBarang;
	 $ref_jenis = cekPOST2("ref_jenis");
	 $pilBI = "PilBI";
	 if($ref_jenis == "2")$pilBI.="2";
	 	
	 $Koloms = array();
	 $Koloms[] = array('valign="middle" align="center"', $no.'.' );
	  /*if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);*/
	 $Koloms[] = array('align="center" valign="middle" width="100"',"<a href='javascript:".$this->Prefix.".$pilBI(`".$isi['id']."`)' >".
	 	$isi['noreg']."/ ".$isi['thn_perolehan']."</a>");
	 $Koloms[] = array('align="left" ',$KodeBarang."/<br>".$isi['nm_barang']);
	 $Koloms[] = array('align="left"',$isi['e'].".".$isi['e1'].'. '.$isi['nm_skpd'].'/<br>'.$DataPengaturan->AmbilUraianBarang($isi['id']));
	 //$Koloms[] = array('align="right"',number_format($isi['harga'],2,",",'.'));
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main,$DataOption, $DataPengaturan, $HTTP_COOKIE_VARS;
	 $thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	
	$NOREG = $_REQUEST['NOREG'];	
	$cmbThn = cekPOST('cmbThn',$thn_anggaran);
	
	
	 $arr = array(
			//array('selectAll','Semua'),
			array('selectfg','Kode Barang'),
			array('selectbarang','Nama Barang'),	
			);
		
		
	//data order ------------------------------
	 $arrOrder = array(
	  	         array('1','Kode Barang'),
			     array('2','Nama Barang'),	
	 );	
	 
	 $c1 = $_REQUEST['c1nya'];
	 $c = $_REQUEST['cnya'];
	 $d = $_REQUEST['dnya'];
	 $e = $_REQUEST['enya'];
	 $ref_jenis = cekPOST2("ref_jenis");
	 
	 if($ref_jenis == "1"){
	 	 $idTerima_det = $_REQUEST['idTerima_det'];
	 
		 $qry_kode = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang_det","*", "WHERE Id='$idTerima_det' ");
		 $dt_kode = $qry_kode['hasil'];
		 
		 $inya = cekPOST("cmbSubRincianObyek");
		 $jnya = cekPOST("cmbSubSubRincianObyek"); 		 
		 $kode_barangFORM = $DataPengaturan->GenViewKode_Barang($dt_kode['f1'],$dt_kode['f2'],$dt_kode['f'],$dt_kode['g'], $dt_kode['h'], $inya, $jnya, "onchange='".$this->Prefix.".refreshList(true);' ", "200px");
	 }else{
	 	$f1 = cekPOST2("cmbAkun",'0');
	 	$f2 = cekPOST2("cmbKelompok",'0');
	 	$f = cekPOST2("cmbJenis",'00');
	 	$g = cekPOST2("cmbObyek",'00');
	 	$h = cekPOST2("cmbRincianObyek",'00');
	 	$i = cekPOST2("cmbSubRincianObyek",'00');
	 	$j = cekPOST2("cmbSubSubRincianObyek",'000');
		
	 	$kode_barangFORM = $DataPengaturan->GenViewKode_Barang2($f1,$f2,$f,$g, $h, $i, $j, "onchange='".$this->Prefix.".refreshList(true);' ", "200px");
	 }
	 $whereC1 = '';
	 $TampilC1 = '';
	 $qry_thn_BI = "SELECT thn_perolehan, thn_perolehan FROM buku_induk GROUP BY thn_perolehan ORDER BY thn_perolehan"; 
	
	 
				
	$TampilOpt = 
			//"<tr><td>".	
			"<div class='FilterBar'>".
				$kode_barangFORM.
			"<table style='width:100%'>
				<tr>
					<td width='200px'>NO REG</td>
					<td width='10px'>:</td>
					<td width='180px;'><input type='text' id='NOREG' name='NOREG' value='".$NOREG."' placeholder='NO REG' size=20px></td>
					<td width='130px'>TAHUN PEROLEHAN</td>
					<td width='10px'>:</td>
					<td width='80px'>".cmbQuery("cmbThn",$cmbThn,$qry_thn_BI,"" ,'Pilih','')."</td>
					<td><input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'></td>				
			</td></tr>
			</table>".
			"</div>".
			"<input type='hidden' id='fmORDER18' name='fmORDER18' value='".$fmORDER18."'>".
			"<input type='hidden' id='fmORDER19' name='fmORDER19' value='".$fmORDER19."'>";			
		return array('TampilOpt'=>$TampilOpt);
	}
	
	function PilihNamaLabel($f){
		if($f == '01' || $f == '03' || $f == '04'){
			$hasil = "LOKASI";
		}elseif($f == '02'){
			$hasil = "MERK";
		}elseif($f == '05' || $f == '07'){
			$hasil = "TYPE/SPESIFIKASI";
		}
			
		return $hasil;
	}				
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS,$DataOption, $DataPengaturan;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn
		
		$ref_jenis = cekPOST2("ref_jenis");
		
				
		$NOREG = $_REQUEST['NOREG'];	
		$cmbThn = $_REQUEST['cmbThn'];	
		$c1 = $_REQUEST['c1nya'];	
		$c = $_REQUEST['cnya'];	
		$d = $_REQUEST['dnya'];	
		$e = $_REQUEST['enya'];	
		
		$arrKondisi[] = " c1='$c1'";
		$arrKondisi[] = " c='$c'";
		$arrKondisi[] = " d='$d'";
		$arrKondisi[] = " e='$e'";
			
		if($ref_jenis == "1"){
			$idTerima_det = $_REQUEST['idTerima_det'];
			$inya = cekPOST("cmbSubRincianObyek");
			$jnya = cekPOST("cmbSubSubRincianObyek");	
		
			if($NOREG != '')$arrKondisi[] = " noreg='$NOREG'";
			if($cmbThn != '')$arrKondisi[] = " thn_perolehan='$cmbThn'";			
			
			//CEK DI t_penerimaan_barang
			$qry_kode = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang_det","*", "WHERE Id='$idTerima_det' ");
			$aqry_kode = $qry_kode['hasil'];
			
			$arrKondisi[] = " (status_barang='1' OR status_barang='2')";
			
			$arrKondisi[] = " f1='".$aqry_kode['f1']."'";
			$arrKondisi[] = " f2='".$aqry_kode['f2']."'";
			$arrKondisi[] = " f='".$aqry_kode['f']."'";
			$arrKondisi[] = " g='".$aqry_kode['g']."'";
			$arrKondisi[] = " h='".$aqry_kode['h']."'";
			if($inya != '')$arrKondisi[] = " i='$inya'";
			if($jnya != '')$arrKondisi[] = " j='$jnya'";
			$arrKondisi[] = " id NOT IN (SELECT refid_buku_induk FROM t_distribusi WHERE refid_penerimaan_det = '$idTerima_det' AND status!='2')";
		}else{
			$f1 = cekPOST2("cmbAkun",'0');
		 	$f2 = cekPOST2("cmbKelompok",'0');
		 	$f = cekPOST2("cmbJenis",'00');
		 	$g = cekPOST2("cmbObyek",'00');
		 	$h = cekPOST2("cmbRincianObyek",'00');
		 	$i = cekPOST2("cmbSubRincianObyek",'00');
		 	$j = cekPOST2("cmbSubSubRincianObyek",'000');
			
			if($f1 != '0')$arrKondisi[] = " f1='$f1' ";
			if($f2 != '0')$arrKondisi[] = " f2='$f2' ";
			if($f != '00')$arrKondisi[] = " f='$f' ";
			if($g != '00')$arrKondisi[] = " g='$g' ";
			if($h != '00')$arrKondisi[] = " h='$h' ";
			if($i != '00')$arrKondisi[] = " i='$i' ";
			if($j != '000')$arrKondisi[] = " j='$j' ";
		}		
		
		
		
		//$arrKondisi[] = " q='00'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		/*if($fmORDER1 == ''){
			$arrOrders[] = " p ";
			$arrOrders[] = " q ";
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
		$ref_jenis=cekPOST2('ref_jenis',1);
		//if($err==''){
			$FormContent = $this->genDaftarInitial($ref_jenis);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						1000,
						500,
						'Pilih Barang',
						'',
						/*"
						<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".*/
						"<input type='button' value='Tutup' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' value='' id='idrekeningnya1' >".
						"<input type='hidden' name='ref_jenis' value='$ref_jenis' id='ref_jenis' >".
						"<input type='hidden' id='cariIDBI_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
						"<input type='hidden' id='cariIDBI_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >".
						"<input type='hidden' id='idTerima_det' name='idTerima_det' value='".$_REQUEST['idTerima_det']."' >".
						"<input type='hidden' id='c1nya' name='c1nya' value='".$_REQUEST['c1nya']."' >".
						"<input type='hidden' id='cnya' name='cnya' value='".$_REQUEST['cnya']."' >".
						"<input type='hidden' id='dnya' name='dnya' value='".$_REQUEST['dnya']."' >".
						"<input type='hidden' id='enya' name='enya' value='".$_REQUEST['unitkerja']."' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
		//}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function PilBI2(){
		global $Main, $DataPengaturan;
		$cek='';$err='';$content='';
		$IdBI = cekPOST2("IdBI");
		$qry = $DataPengaturan->QyrTmpl1Brs("buku_induk", "id", "WHERE id='$IdBI' ");
		$dt=$qry["hasil"];
		
		if($dt["id"] == '' || $dt["id"] == NULL)$err = "Barang Tidak Bisa Di Pilih ";
		if($err == "")$content=$dt["id"];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
}
$cariIDBI = new cariIDBIObj();
?>