<?php
include "pages/pencarian/DataPengaturan.php";
$DataOption = $DataPengaturan->DataOption();

class daftarsuratpermohonanObj  extends DaftarObj2{	
	var $Prefix = 'daftarsuratpermohonan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'v1_spp_penerimaan_barang'; //bonus
	var $TblName_Hapus = 't_spp';
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
	
	function setTitle(){
		return 'DAFTAR SURAT PERMOHONAN';
	}
	
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".BaruSPP()","spp.png","SPP", 'SPP')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".BaruSPM()","spm.png","SPM", 'SPM')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".BaruSP2D()","spd.png","SP2D", 'SP2D')."</td>".
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Ubah", 'Ubah')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
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
	
	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
		
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function set_selector_other($tipe){
	 global $Main;
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
					
		case 'simpan':{
			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'PengecekanUbahSPP':{
			$get= $this->PengecekanUbahSPP();
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
		
		case 'SimpanNamaPejabat':{
			$get= $this->SimpanNamaPejabat();
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
							".$this->Prefix.".loading();
						});
					</script>";
		return 	"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".	
			"<script type='text/javascript' src='js/keuangan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".'
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
		$a = "SELECT count(*) as cnt, aa.daftarsuratpermohonan_terbesar, aa.daftarsuratpermohonan_terkecil, bb.nama, aa.f, aa.g, aa.h, aa.i, aa.j FROM ref_barang aa INNER JOIN ref_daftarsuratpermohonan bb ON aa.daftarsuratpermohonan_terbesar = bb.nama OR aa.daftarsuratpermohonan_terkecil = bb.nama WHERE bb.nama='".$this->form_idplh."' "; $cek .= $a;
		$aq = mysql_query($a);
		$cnt = mysql_fetch_array($aq);
		
		if($cnt['cnt'] > 0) $err = "daftarsuratpermohonan Tidak Bisa Diubah ! Sudah Digunakan Di Ref Barang.";
		if($err == ''){
			$aqry = "SELECT * FROM  ref_daftarsuratpermohonan WHERE nama='".$this->form_idplh."' "; $cek.=$aqry;
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
						'label'=>'daftarsuratpermohonan',
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
			/*"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=barang\" title='Barang'>Ref Barang</a> |
	<A href=\"pages.php?Pg=daftarsuratpermohonan\" title='Ref daftarsuratpermohonan' style='color:blue' >Ref daftarsuratpermohonan</a> |
	<A href=\"pages.php?Pg=akun\" title='Akun' >Ref Akun </a> |
	<A href=\"pages.php?Pg=mapingbarangakun\" title='Ref Mapping Akun'>Ref Mapping Akun</a> |
	<A href=\"pages.php?Pg=refpegawai\" title='Ref Pegawai'>Ref Pegawai</a>
	&nbsp&nbsp&nbsp	
	</td></tr></table>";*/
		"";
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' rowspan='2'>No.</th>
  	   $Checkbox		
	   <th class='th01' width='60px' rowspan='2'>JENIS SPP</th>
	   <th class='th01' width='80px' rowspan='2'>TANGGAL SPP</th>
	   <th class='th01' width='180px' rowspan='2'>NOMOR SURAT PERMOHONAN</th>
	   <th class='th01' rowspan='2'>NOMOR PENERIMAAN</th>
	   <th class='th01' width='80px' rowspan='2'>TANGGAL</th>
	   <th class='th01' rowspan='2'>NOMOR KONTRAK</th>
	   <th class='th01' width='80px' rowspan='2'>TANGGAL SPD</th>
	   <th class='th01' rowspan='2'>NOMOR SPD</th>
	   <th class='th01' rowspan='2'>PENYEDIA BARANG</th>
	   <th class='th01' rowspan='2'>URAIAN</th>
	   <th class='th02' colspan='2'>STATUS</th>
	   </tr>
	   <tr>
	   <th class='th01'>SPP</th>
	   <th class='th01'>SPM</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref, $DataPengaturan;
	 
	 //Status SPP
	 switch($isi['status']){
	 	case "1" : $status_spp = $this->ImgStat("permohonan.png", "Permohonan");break;
	 	case "2" : $status_spp = $this->ImgStat("diterima.png", "Di Terima");break;
	 	case "3" : $status_spp = $this->ImgStat("ditolak.png", "Di Tolak");break;
		default : $status_spp = $this->ImgStat("tunggu.png", "Tunggu");break;
	 }
	 
	 //Status SPM
	 switch($isi['status_spm']){
	 	case "1" : $status_spm = $this->ImgStat("permohonan.png", "Permohonan");break;
	 	case "2" : $status_spm = $this->ImgStat("diterima.png", "Di Terima");break;
	 	case "3" : $status_spm = $this->ImgStat("ditolak.png", "Di Tolak");break;
		default : $status_spm = $this->ImgStat("tunggu.png", "Tunggu");break;
	 }
	 
	 //SPM
	 $no_spm = "";
	 $jns_spm_nya = "";
	 if($isi['nomor_spm'] != '' || $isi['nomor_spm'] != NULL){
	 	$no_spm = "<br>".$isi['nomor_spm'];
		$jns_spm_nya = "<br>".$DataPengaturan->Daftar_arr_pencairan_dana_SPM[$isi['jns_spp']];
	 }
	 
	 //SP2D
	 $no_sp2d = "";
	 if($isi['no_sp2d'] != '' || $isi['no_sp2d'] != NULL)$no_spm = "<br>".$isi['no_sp2d'];
	 
	 //Tanggal SPM
	 $tanggal_sp = FormatTanggalnya($isi['tgl_spp']);
	 $tanggal_sp .= $isi['tgl_spm'] != '' || $isi['tgl_spm'] != '0000-00-00' ? "<br />".FormatTanggalnya($isi['tgl_spp']):"";
	 
	 
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="center" width="60px"',$DataPengaturan->Daftar_arr_pencairan_dana[$isi['jns_spp']].$jns_spm_nya);
	 $Koloms[] = array('align="center" width="80px"',$tanggal_sp);
	 $Koloms[] = array('align="left" width="180px"',$isi['nomor_spp'].$no_spm.$no_sp2d);
	 $Koloms[] = array('align="left" ',$isi['id_penerimaan']);
	 $Koloms[] = array('align="center" width="80px"',FormatTanggalnya($isi['tgl_dok_kontrak']));
	 $Koloms[] = array('align="left"',$isi['no_dok_kontrak']);
	 $Koloms[] = array('align="center" width="80px"',FormatTanggalnya($isi['tgl_spd']));
	 $Koloms[] = array('align="left"',$isi['no_spd']);
	 $Koloms[] = array('align="left"',$isi['penyedia_barang']);
	 $Koloms[] = array('align="left"',$isi['uraian']);
	 $Koloms[] = array('align="center"',$status_spp);
	 $Koloms[] = array('align="center"',$status_spm);
	 return $Koloms;
	}
	
	function ImgStat($img, $title, $width='20px', $height='20px'){
		return "<img src='images/administrator/images/$img' title='$title' width='$width' height='$height' />";
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main, $DataOption;
	 
	 $arr = array(
			//array('selectAll','Semua'),	
			array('selectdaftarsuratpermohonan','daftarsuratpermohonan'),		
			);
		
	 //data order ------------------------------
	 $arrOrder = array(
			     	array('1','daftarsuratpermohonan'),
					);
	 
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	
	$DataSKPD = WilSKPD_ajx3($this->Prefix.'SKPD2');
	
	$TampilOpt =
			//<table width=\"100%\" class=\"adminform\">
			"<input type='hidden' id='ver_skpd' value='".$DataOption['skpd']."' />".
			//<table width=\"100%\" class=\"adminform\">
			"<tr><td>".
				"<table width=\"100%\" class=\"adminform\">	<tr>		
				<td width=\"100%\" valign=\"top\">" . 
					 $DataSKPD. 
				"</td>
				<td valign='top'>" . 		
				"</td>	
				</table>";
			
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
		$cek="";$err="";$content;
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		
		
		$err = $this->GetStatusSPP($cbid[0]);
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function GetTblSpp($Id){
		global $DataPengaturan;
		
		$qry = $DataPengaturan->QyrTmpl1Brs("v1_penerimaan_spp", "*", "WHERE Id='$Id' ");
		$aqry = $qry["hasil"];
				
		$data = array("cek"=>$qry['cek'], "content"=>$aqry);
		return $data;
	}
	
	function GetStatusSPP($Id){
		$err = "";
		$data_ambil = $this->GetTblSpp($Id);
		$data = $data_ambil['content'];
		//$err = $data_ambil['cek'];
		
		if($data['status'] != "1")$err = "Data Ini Tidak Bisa di Ubah !".$data_ambil['cek'].$data['status'];
		
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
	
	
}
$daftarsuratpermohonan = new daftarsuratpermohonanObj();
?>