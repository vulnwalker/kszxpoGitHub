<?php
 include "pages/pencarian/DataPengaturan.php";
 $DataOption = $DataPengaturan->DataOption();

class pemasukan_retensi_baruObj  extends DaftarObj2{	
	var $Prefix = 'pemasukan_retensi_baru';
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
	var $FormName = 'pemasukan_retensi_baruForm'; 


	var $arr_laporan = array(
			array('1', 'DAFTAR RETENSI PENERIMAAN BARANG'),
			array('2', 'REKAPITULASI RETENSI PENERIMAAN BARANG'),
			array('3', 'DAFTAR RETENSI PENGADAAN BARANG'),
			array('4', 'DAFTAR RETENSI PENERIMAAN BARANG BEDASARKAN PROGRAM & KEGIATAN'),
			array('5', 'DAFTAR RETENSI BELANJA BARANG BEDASARKAN PROGRAM & KEGIATAN'),
			array('6', 'DAFTAR REALISASI'),
			array('7', 'DAFTAR RETENSI REALISASI'),

	);

	var $arr_perolehan = array(
			array('1', 'PEMBELIAN'),
			array('2', 'HIBAH'),
			array('3', 'LAINYA'),
	);

	function setTitle(){
		return 'RETENSI BARANG';
	}
	
	/*function setMenuView(){
		return "";
	}*/
	
	function setMenuEdit(){	

	$cetak = "Laporan";	
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Validasi()","validasi-menu.png","Validasi", 'Validasi')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".PostingForm()","publishdata.png","Posting", 'Posting')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".$cetak()","print_f2.png",'Laporan',"Laporan")."</td>";
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
	
	function simpan(){
	  global $Ref, $Main, $HTTP_COOKIE_VARS,$DataOption, $DataPengaturan;
		
		$cek = '';$err='';$content='';
		
	 	$uid = $HTTP_COOKIE_VARS['coID'];
	 	$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		
		$idplh = cekPOST($this->Prefix.'_idplh');
		$FMST = cekPOST($this->Prefix.'_fmST');
		$validasi=cekPOST2("validasi");
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi", "*", "WHERE Id='$idplh' ");
		$dt = $qry["hasil"];
		
		if($validasi == "" && $dt["status_validasi"] == "0")$err="Validasi Data, Belum Di Ceklis !";
		if($validasi == "" && $dt["status_posting"] == "1")$err="Tidak Bisa Membatalkan Validasi Data, Data Telah Di Posting!";
		//if($err == "")$err="dfgh";
		
		if($err == ""){
			if($dt["status_validasi"] == "1"){
				$data_upd = array(
								array("uid_validasi",""),
								array("status_validasi","0"),
								array("tgl_validasi",""),
							);
				$content=0;
			}else{
				$data_upd = array(
								array("uid_validasi",$uid),
								array("status_validasi","1"),
								array("tgl_validasi",date("Y-m-d H:i:s")),
							);
				$content=1;
			}
			$qry_upd = $DataPengaturan->QryUpdData("t_penerimaan_retensi", $data_upd,"WHERE Id='$idplh' ");
			
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
	  	
		case 'formBaru':{				
			$fm = $this->setFormBaru();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'getYearRange':{
			$yearRange = $_COOKIE['coThnAnggaran'] - date("Y");
			$content = array(
			'yearRange' => $yearRange.":".$yearRange
			);
		break;
		}

		case 'BuatLaporan':{				
			$fm = $this->setBuatLaporan();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
	              case 'TandaTanda':{	
global $DataPengaturan;
	              	

			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
			

			$wherenya = " WHERE c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' ";
			$data = array(
						array('refid_penerima',$id_penerima),
						array('refid_mengetahui',$id_mengetahui),
					);
			$qry = $DataPengaturan->QryUpdData('ref_penerimaan_tandatangan',$data, $wherenya);
			$cek.=$qry['cek'];
		
		break;
		}

		case 'Perolehan':{		
		            foreach ($_REQUEST as $key => $value) { 
		               $$key = $value; 
			}
		break;
		}
		case 'PrintLaporan':{				
			$json=FALSE;		
			$this->PrintLaporan();										
		break;
		}
		
		case 'SetNama':{				
			$fm = $this->SetNama();				
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
		
		case 'CekEdit':{				
			$fm = $this->CekEdit();				
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
		
		case 'Validasi':{
			$fm = $this->setValidasi();				
			$cek .= $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];													
		break;
		}
		
	    case 'DataCopy':{
			$get= $this->DataCopy();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'PostingForm':{				
			$fm = $this->PostingForm();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'SimpanPosting':{				
			$fm = $this->SavePosting();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'UpdatePosting':{				
			$fm = $this->UpdatePosting();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'Cek_SimpanPosting':{				
			$fm = $this->Cek_SimpanPosting();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'BatalkanPosting':{				
			$fm = $this->BatalkanPosting();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}

				case 'LaporanTTD':{				
			$fm = $this->setLaporanTTD();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
	    			
	   
	  /* case 'hapus':{	
				$fm= $this->Hapus($pil);
				$err= $fm['err']; 
				$cek = $fm['cek'];
				$content = $fm['content'];
		break;
		}	*/		
	   
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
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/upload_style.css' type='text/css'>".
			"<script src='js/jquery.js' type='text/javascript'></script>".			
			"<script src='js/jquery-ui.js' type='text/javascript'></script>".
			"<script src='js/jquery.min.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/jquery.form.js'></script> ".
			"<script src='js/jquery-ui.custom.js'></script>".
			"<script type='text/javascript' src='js/pencarian/cariBarang.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/pengadaanpenerimaan/pemasukan_retensi_ins.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/pengadaanpenerimaan/Laporan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
			 ".
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".
			
			$scriptload;
	}

	   function setBuatLaporan(){
   		global $DataOption;
   
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		
		$dt['c1'] = '0';
		$dt['c'] = '00';
		$dt['d'] = '00';
		$dt['e'] = '00';
		$dt['e1'] = '000';
			
		//if($DataOption['skpd'] == 1){
			$dt['c1'] = $_REQUEST['pemasukan_retensiSKPD2fmURUSAN'];
			$dt['c'] = $_REQUEST['pemasukan_retensiSKPD2fmSKPD'];
			$dt['d'] = $_REQUEST['pemasukan_retensiSKPD2fmUNIT'];
			$dt['e'] = $_REQUEST['pemasukan_retensiSKPD2fmSUBUNIT'];
			$dt['e1'] = $_REQUEST['pemasukan_retensiSKPD2fmSEKSI'];
		/*}else{
			$dt['c1'] = $_REQUEST['pemasukan_baruSKPDfmUrusan'];
			if($dt['c1'] != '00' && $dt['c1'] != '0' && $dt['c1'] != ''){
				$dt['c'] = $_REQUEST['pemasukan_baruSKPDfmSKPD'];
				if($dt['c'] != '00' && $dt['c'] != ''){
					$dt['d'] = $_REQUEST['pemasukan_baruSKPDfmUNIT'];
					if($dt['d'] != '00' && $dt['d'] != ''){
						$dt['e'] = $_REQUEST['pemasukan_baruSKPDfmSUBUNIT'];
						if($dt['e'] != '00' && $dt['e'] != '')$dt['e1'] = $_REQUEST['pemasukan_baruSKPDfmSEKSI'];
					}
				}
			}else{
				$dt['c1'] = '0';	
			}
			
		}*/
		 
		$fm = $this->setFormBuatLaporan($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormBuatLaporan($dt){	
	 global $SensusTmp,$HTTP_COOKIE_VARS ;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';						
	 $this->form_width = 610;
	 $this->form_height = 230;
	$halamanNyo = $_REQUEST['halmannya'] ; 
	 $UID = $_COOKIE['coNama']; 
	 //$namauid = $_COOKIE['coNama'];
	 $tgl = date('d-m-Y');
	 $query = "" ;$cek .=$query;
	 $res = mysql_query($query);
	 $qrysumberDana = "SELECT nama,nama FROM ref_sumber_dana";
 


               $dataTandatangan = mysql_fetch_array(mysql_query("SELECT * from ref_penerimaan_tandatangan where c1='$dt[c1]' AND  c='$dt[c]' and d='$dt[d]' AND e='$dt[e]' AND e1='$dt[e1]'"));



              
              $getNamaTandatanggan = "SELECT id,nama FROM ref_tandatangan where c1='$dt[c1]' AND  c='$dt[c]' and d='$dt[d]' AND e='$dt[e]' AND e1='$dt[e1]'";


              $tandatangganPenerima = cmbQuery('cmb_penerima',$dataTandatangan['refid_penerima'], $getNamaTandatanggan,"style='width:280px;' onchange='".$this->Prefix.".TandaTanda();'","--- Pilih Penerima--");

              $tandatangganMengetahui = cmbQuery('cmb_mengetahui',$dataTandatangan['refid_mengetahui'], $getNamaTandatanggan,"style='width:280px;' onchange='".$this->Prefix.".TandaTanda();'","--- Pilih Penerima--");
   $tahunCookies = $_COOKIE['coThnAnggaran'];

		 $this->form_caption = 'LAPORAN RETENSI';

		 $this->form_fields = array(
			'nama' => array( 
						'label'=>'NAMA LAPORAN',
						'labelWidth'=>120, 
						'value'=>cmbArray('nama_laporan','1',$this->arr_laporan, '--- PILIH LAPORAN ---',"style='width:429px;' onchange='".$this->Prefix.".Perolehan();'"),
						 ),	
			'perolehan' => array( 
						'label'=>'CARA PEROLEHAN',
						'labelWidth'=>120, 
						'value'=>"<input type='text' readonly value='PEMBELIAN'>"),

			'sumberdana' => array( 
						'label'=>'SUMBER DANA',
						'labelWidth'=>120, 
						'value'=>"<input type='text' readonly value='APBD'>"),

			'periode' => array( 
						'label'=>'PERIODE',
						'labelWidth'=>120, 
						'value'=>"<input type='text' name='dari' value='01-01-".$tahunCookies ."' style='width:105px;margin-right:7px;' id='dari' class='datepicker' /> s.d <input type='text' name='sampai' id='sampai' style='width:105px; margin-left:7px; margin-right:2px;' class='datepicker' value='31-12-".$tahunCookies."'  />", 
						
						 ),	
			'tanggal' => array( 
						'label'=>'TANGGAL CETAK',
						'labelWidth'=>120, 
						'value'=>$tgl, 
						'type'=>'text',
						'param'=>"class='datepicker' style='margin-right:8px; width:105px;' "
						 ),

			'user' => array( 
						'label'=>'USER',
						'labelWidth'=>120, 
						'value'=>$UID, 
						'type'=>'text',
						'param'=>"style='width:280px;' readonly"
						 ),	

			'penerima' => array( 
						'label'=>'PENERIMA',
						'labelWidth'=>120, 
						'value'=> $tandatangganPenerima,
						 ),


			'mengetahui' => array( 
						'label'=>'MENGETAHUI',
						'labelWidth'=>120, 
						'value'=>$tandatangganMengetahui,
						 ),	

			
			);
		
	    //ambil data trefditeruskan

	 //items ----------------------
               

		//tombol
		$this->form_menubawah =
			"<input type='hidden' name='c1nya' id='c1' value='".$dt['c1']."' />".
			"<input type='hidden' name='cnya' id='c' value='".$dt['c']."' />".
			"<input type='hidden' name='dnya' id='d' value='".$dt['d']."' />".
			"<input type='hidden' name='enya' id='e' value='".$dt['e']."' />".
			"<input type='hidden' name='e1nya' id='e1' value='".$dt['e1']."' />".
			"<input type='button' value='TTD' onclick ='".$this->Prefix.".LaporanTTD()' title='TTD' > ".
			"<input type='button' value='CETAK' onclick ='".$this->Prefix.".PrintLaporan()' title='CETAK' > ".
			"<input type='button' value='BATAL' title='BATAL' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

		function setLaporanTTD(){
		global $DataOption, $DataPengaturan;
		$cek='';
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$dt['c1'] = '0';
		$dt['c'] = '00';
		$dt['d'] = '00';
		$dt['e'] = '00';
		$dt['e1'] = '000';
			
		if($DataOption['skpd'] == 1){
			$dt['c'] = $_REQUEST['cnya'];
			$dt['d'] = $_REQUEST['dnya'];
			$dt['e'] = $_REQUEST['enya'];
			$dt['e1'] = $_REQUEST['e1nya'];
		}else{
			$dt['c1'] = $_REQUEST['c1nya'];
			if($dt['c1'] != '00' && $dt['c1'] != '0' && $dt['c1'] != ''){
				$dt['c'] = $_REQUEST['cnya'];
				if($dt['c'] != '00' && $dt['c'] != ''){
					$dt['d'] = $_REQUEST['dnya'];
					if($dt['d'] != '00' && $dt['d'] != ''){
						$dt['e'] = $_REQUEST['enya'];
						if($dt['e'] != '00' && $dt['e'] != '')$dt['e1'] = $_REQUEST['e1nya'];
					}
				}
			}else{
				$dt['c1'] = '0';	
			}
			
		}
		
		$wherenya = " WHERE c1='".$dt['c1']."' AND c='".$dt['c']."' AND d='".$dt['d']."' AND e='".$dt['e']."' AND e1='".$dt['e1']."' ";
		$datanya = $DataPengaturan->QyrTmpl1Brs('ref_penerimaan_tandatangan','*', $wherenya);$cek.=$datanya['cek'];
		$data = $datanya['hasil'];
		$dt['Id_penerima'] = $data['refid_penerima'];
		$dt['Id_mengetahui'] = $data['refid_mengetahui'];
		
		$fm = $this->setFormLaporanTTD($dt);
		return	array ('cek'=>$fm['cek'].$cek, 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	

	function SetNama(){
		global $DataPengaturan;
		$cek='';$err='';$content=array();
		
		$pilihan = $_REQUEST['pilihan'];
		
		$Idplh_nama = $_REQUEST['nama_penerima'];
		if($pilihan == 'mengetahui')$Idplh_nama = $_REQUEST['nama_mengetahui'];
		
		$qry = "SELECT * FROM ref_tandatangan WHERE Id='$Idplh_nama' ";
		$aqry = mysql_query($qry);
		$daqry = mysql_fetch_array($aqry);
		
		$content['nip'] = $daqry['nip'];
		$content['pangkat'] = $daqry['pangkat']."/".$daqry['gol'];
		$content['eselon'] = $DataPengaturan->arrEselon[$daqry['eselon']][1];
		$content['jabatan'] = $daqry['jabatan'];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function setFormLaporanTTD($dt){	
	 global $SensusTmp,$HTTP_COOKIE_VARS ;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form_TTD';				
	 $this->form_width = 420;
	 $this->form_height = 300;
	 $this->form_caption = 'TANDA TANGAN';
	 
	 $UID = $_COOKIE['coID']; 
	 $tgl = date('d-m-Y');
		
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	$qry_ref_ttd = "SELECT Id, nama FROM ref_tandatangan WHERE c1='".$dt['c1']."' AND c='".$dt['c']."' AND d='".$dt['d']."' AND e='".$dt['e']."' AND e1='".$dt['e1']."' ";$cek.=$qry_ref_ttd;
		
	 //items ----------------------""
	  $this->form_fields = array(
			'nama_penerima' => array( 
						'label'=>'NAMA PENERIMA',
						'labelWidth'=>120, 
						'value'=>cmbQuery('nama_penerima', $dt['Id_penerima'], $qry_ref_ttd,"style='width:250px;' onchange='".$this->Prefix.".SetNama(`penerima`);'","--- PILIH PENERIMA ---"),
						 ),	
			'nip_penerima' => array( 
						'label'=>'NIP',
						'labelWidth'=>120, 
						'value'=>'', 
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),	
			'pangkat_penerima' => array( 
						'label'=>'PANGKAT/GOL',
						'labelWidth'=>120, 
						'value'=>'', 
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),	
			'eselon_penerima' => array( 
						'label'=>'ESELON',
						'labelWidth'=>120, 
						'value'=>'', 
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),	
			'jabatan_penerima' => array( 
						'label'=>'JABATAN',
						'labelWidth'=>120, 
						'value'=>'', 
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),	
			'Enter' => array( 
						'label'=>' ',
						'labelWidth'=>120, 
						'pemisah' =>' ',
						'value'=>'<br><br>', 
						
						 ),	
			'nama_mengetahui' => array( 
						'label'=>'NAMA MENGETAHUI',
						'labelWidth'=>120, 
						'value'=>cmbQuery('nama_mengetahui', $dt['Id_mengetahui'], $qry_ref_ttd,"style='width:250px;' onchange='".$this->Prefix.".SetNama(`mengetahui`);'","--- PILIH PENERIMA ---"),
						 ),	
			'nip_mengetahui' => array( 
						'label'=>'NIP',
						'labelWidth'=>120, 
						'value'=>'', 
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),	
			'pangkat_mengetahui' => array( 
						'label'=>'PANGKAT/GOL',
						'labelWidth'=>120, 
						'value'=>'', 
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),	
			'eselon_mengetahui' => array( 
						'label'=>'ESELON',
						'labelWidth'=>120, 
						'value'=>'', 
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),	
			'jabatan_mengetahui' => array( 
						'label'=>'JABATAN',
						'labelWidth'=>120, 
						'value'=>'', 
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),	
							
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='hidden' name='c1nya' value='".$dt['c1']."' />".
			"<input type='hidden' name='cnya' value='".$dt['c']."' />".
			"<input type='hidden' name='dnya' value='".$dt['d']."' />".
			"<input type='hidden' name='enya' value='".$dt['e']."' />".
			"<input type='hidden' name='e1nya' value='".$dt['e1']."' />".
			// "<input type='button' value='BARU' onclick ='".$this->Prefix.".BaruTTD()' title='BARU' > ".
			"<input type='button' value='BARU' onclick ='pemasukan_ins.BaruPenerima(`#pemasukan_retensi_baru_form`)' title='BARU' > ".
			"<input type='button' value='SIMPAN' onclick ='".$this->Prefix.".SimpanTTD()' title='SIMPAN' > ".
			"<input type='button' value='BATAL' title='BATAL' onclick ='".$this->Prefix.".TutupForm(`".$this->Prefix."_formcover_TTD`)' >";
							
		$form = $this->genForm($form_name);		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function TandaTanganFooter($c1,$c,$d,$e,$e1){
		global $Main, $DataPengaturan,$HTTP_COOKIE_VARS, $DataOption;
		$DATE = date("Y-m-d");
		$tgl_cetak = VulnwalkerTitiMangsa($DATE);	


		$daqry_pengaturan = $DataOption;
		
		$qry_atasnama = $DataPengaturan->QyrTmpl1Brs('ref_penerimaan_tandatangan','*',"WHERE c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' ");
		$atasnama = $qry_atasnama['hasil'];
		
		$qry_penerima = $DataPengaturan->QyrTmpl1Brs('ref_tandatangan','nip, nama',"WHERE Id='".$atasnama['refid_penerima']."' ");
		$penerima = $qry_penerima['hasil'];
		
		$qry_mengetahui = $DataPengaturan->QyrTmpl1Brs('ref_tandatangan','nip, nama',"WHERE Id='".$atasnama['refid_mengetahui']."' ");
		$mengetahui = $qry_mengetahui['hasil'];
		
		$dataJabatan = mysql_fetch_array(mysql_query("SELECT * FROM ref_tandatangan where Id='".$atasnama['refid_penerima']."'"));
		$dataJabatanMengetahui = mysql_fetch_array(mysql_query("SELECT * FROM ref_tandatangan where Id='".$atasnama['refid_mengetahui']."'"));
		
		return "<br><div class='ukurantulisan'>
					<table width='100%'>
						<tr>
							<td class='ukurantulisan' valign='top' ></td>
							<td class='ukurantulisan' valign='top' width='30%' ></td>
							<td class='ukurantulisan' valign='top' width='30%' ></td>
							<td class='ukurantulisan' valign='top'><span style='margin-left:5px;'>".$daqry_pengaturan['titimangsa_surat'].", ".$tgl_cetak."</span></td>
						</tr>
						<tr>
							<td class='ukurantulisan' valign='top'  style='margin-left:15px;'><br><span style='margin-left:15px;'>".$dataJabatan['jabatan']."
<br><br><br><br><br></span></td>
							<td class='ukurantulisan' valign='top' width='30%' ></td>
								<td class='ukurantulisan' valign='top' width='30%' ></td>

							<td class='ukurantulisan' valign='top' >
							<span style='margin-left:5px;'>Mengetahui</span>
							<br>
							<span style='margin-left:5px;'>".$dataJabatanMengetahui['jabatan']."</span></td>
						</tr>
						<tr>
							<td class='ukurantulisan'>
								<table width='100%' style='margin-left:15px;'>
									<tr>
										<td class='ukurantulisan' width='75px'>Nama</td>
										<td class='ukurantulisan'> : </td>

										<td class='ukurantulisan'>".$penerima['nama']."</td>
									</tr>
									<tr>
										<td class='ukurantulisan'>NIP</td>
										<td class='ukurantulisan'> : </td>

										<td class='ukurantulisan'>".$penerima['nip']."</td>
									</tr>
								</table>
							</td>
							<td class='ukurantulisan'></td>
							<td class='ukurantulisan'>
								<table width='100%' style='margin-left:102%;'>
									<tr>
										<td class='ukurantulisan' width='75px'>Nama</td>
										<td class='ukurantulisan'> : </td>
										<td class='ukurantulisan'>".$mengetahui['nama']."</td>
									</tr>
									<tr>
										<td class='ukurantulisan'>NIP</td>
										<td class='ukurantulisan'> : </td>
										<td class='ukurantulisan'>".$mengetahui['nip']."</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>";
	}
	

		function TandaTanganFooterP($c1,$c,$d,$e,$e1){
		global $Main, $DataPengaturan,$HTTP_COOKIE_VARS, $DataOption;
		$DATE = date("Y-m-d");
		$tgl_cetak = VulnwalkerTitiMangsa($DATE);	


		$daqry_pengaturan = $DataOption;
		
		$qry_atasnama = $DataPengaturan->QyrTmpl1Brs('ref_penerimaan_tandatangan','*',"WHERE c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' ");
		$atasnama = $qry_atasnama['hasil'];
		
		$qry_penerima = $DataPengaturan->QyrTmpl1Brs('ref_tandatangan','nip, nama',"WHERE Id='".$atasnama['refid_penerima']."' ");
		$penerima = $qry_penerima['hasil'];
		
		$qry_mengetahui = $DataPengaturan->QyrTmpl1Brs('ref_tandatangan','nip, nama',"WHERE Id='".$atasnama['refid_mengetahui']."' ");
		$mengetahui = $qry_mengetahui['hasil'];
		
		$dataJabatan = mysql_fetch_array(mysql_query("SELECT * FROM ref_tandatangan where Id='".$atasnama['refid_penerima']."'"));
		$dataJabatanMengetahui = mysql_fetch_array(mysql_query("SELECT * FROM ref_tandatangan where Id='".$atasnama['refid_mengetahui']."'"));
		
		return "<br><div class='ukurantulisan'>
					<table width='100%'>
						<tr>
							<td class='ukurantulisan' valign='top' ></td>
							<td class='ukurantulisan' valign='top' width='30%' ></td>
							<td class='ukurantulisan' valign='top' width='30%' ></td>
							<td class='ukurantulisan' valign='top'><span style='margin-left:5px;'>".$daqry_pengaturan['titimangsa_surat'].", ".$tgl_cetak."</span></td>
						</tr>
						<tr>
							<td class='ukurantulisan' valign='top'  style='margin-left:15px;'><br><span style='margin-left:15px;'>".$dataJabatan['jabatan']."
<br><br><br><br><br></span></td>
							<td class='ukurantulisan' valign='top' width='30%' ></td>
								<td class='ukurantulisan' valign='top' width='30%' ></td>

							<td class='ukurantulisan' valign='top' >
							<span style='margin-left:5px;'>Mengetahui</span>
							<br>
							<span style='margin-left:5px;'>".$dataJabatanMengetahui['jabatan']."</span></td>
						</tr>
						<tr>
							<td class='ukurantulisan'>
								<table width='100%' style='margin-left:15px;'>
									<tr>
										<td class='ukurantulisan' width='75px'>Nama</td>
										<td class='ukurantulisan'> : </td>

										<td class='ukurantulisan'>".$penerima['nama']."</td>
									</tr>
									<tr>
										<td class='ukurantulisan'>NIP</td>
										<td class='ukurantulisan'> : </td>

										<td class='ukurantulisan'>".$penerima['nip']."</td>
									</tr>
								</table>
							</td>
							<td class='ukurantulisan'></td>
							<td class='ukurantulisan'>
								<table width='100%' style='margin-left:102%;'>
									<tr>
										<td class='ukurantulisan' width='75px'>Nama</td>
										<td class='ukurantulisan'> : </td>
										<td class='ukurantulisan'>".$mengetahui['nama']."</td>
									</tr>
									<tr>
										<td class='ukurantulisan'>NIP</td>
										<td class='ukurantulisan'> : </td>
										<td class='ukurantulisan'>".$mengetahui['nip']."</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>";
	}
	
	function LaporanTmplSKPD($c1, $c, $d, $e, $e1){
		global $Main, $DataPengaturan, $DataOption;
		
		$tukdepan = '';
		$urusan = '';
		if($DataOption['skpd'] != '1'){
			$qry1 = $DataPengaturan->QyrTmpl1Brs("ref_skpd","CONCAT (c1,'. ', nm_skpd) as nm_skpd ", "WHERE c1='$c1' AND c='00' AND d='00' AND e='00' AND e1='000'");
			$qry1 = $qry1['hasil'];
			$tukdepan = "c1='$c1' AND ";
			
			$urusan = "
					<tr>
						<td width='10%' valign='top'>URUSAN</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$qry1['nm_skpd']."</td>
					</tr>
			";
		}
		
			$qry2 = $DataPengaturan->QyrTmpl1Brs("ref_skpd","CONCAT (c,'. ', nm_skpd) as nm_skpd ", "WHERE $tukdepan c='$c' AND d='00' AND e='00' AND e1='000'");
			$qry2 = $qry2['hasil'];
			if($qry2['nm_skpd'] == NULL OR $qry2['nm_skpd'] == '')$qry2['nm_skpd'] = "";
			if($c == '00')$qry2['nm_skpd'] = "";
			
			
			$qry3 = $DataPengaturan->QyrTmpl1Brs("ref_skpd","CONCAT (d,'. ', nm_skpd) as nm_skpd ", "WHERE $tukdepan c='$c' AND d='$d' AND e='00' AND e1='000'");
			$qry3 = $qry3['hasil'];
			if($qry3['nm_skpd'] == NULL OR $qry3['nm_skpd'] == '')$qry3['nm_skpd'] = "";
			if($d == '00')$qry3['nm_skpd'] = "";
			
			$qry4 = $DataPengaturan->QyrTmpl1Brs("ref_skpd","CONCAT (e,'. ', nm_skpd) as nm_skpd ", "WHERE $tukdepan c='$c' AND d='$d' AND e='$e' AND e1='000'");
			$qry4 = $qry4['hasil'];
			if($qry4['nm_skpd'] == NULL OR $qry4['nm_skpd'] == '')$qry4['nm_skpd'] = "";
			if($e == '00')$qry4['nm_skpd'] = "";
			
			$qry5 = $DataPengaturan->QyrTmpl1Brs("ref_skpd","CONCAT (e1,'. ', nm_skpd) as nm_skpd ", "WHERE $tukdepan c='$c' AND d='$d' AND e='$e' AND e1='$e1'");
			$qry5 = $qry5['hasil'];
			if($qry5['nm_skpd'] == NULL OR $qry5['nm_skpd'] == '')$qry5['nm_skpd'] = "";
			if($e1 == '000')$qry5['nm_skpd'] = "";

		
		
		$data = "
				<table width=\"100%\" border=\"0\" class='subjudulcetak'>
					$urusan
					<tr>
						<td width='10%' valign='top' >BIDANG</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$qry2['nm_skpd']."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SKPD</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$qry3['nm_skpd']."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>UNIT</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$qry4['nm_skpd']."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SUBUNIT</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$qry5['nm_skpd']."</td>
					</tr>
				</table>";
		
		return $data;
	}
		function JudulLaporan($dari='', $sampai='',$judul=''){
		return "<div style='text-align:center;'>
				<span style='font-size:18px;font-weight:bold;'>
					$judul
				</span><br>
				<span class='ukurantulisanIdPenerimaan'>PERIODE : $dari S/D $sampai </span></div><br>";
	}

		function PrintLaporan(){
		global $Main, $DataPengaturan,$HTTP_COOKIE_VARS;
		
		$nama_laporan = $_REQUEST['nama_laporan'];
		$tgl_cetak = date('m-d-Y');
		$dari = $_REQUEST['dari'];
		$sampai = $_REQUEST['sampai'];
		$namauid = $_COOKIE['coNama'];
		switch($nama_laporan){
			case '1':
				$this->LaporanRetensiPenerimaanBarang();
			break;
			case '2':
				$this->RekapitulasiRetensiPenerimaanBarang();
			break;
			case '3':
				$this->LaporanRetensiPengadaanBarang();
			break;
			case '4':
				$this->LaporanRetensiBelanjaBarangProgkeg();
			break;
			case '5':
				$this->LaporanRetensiPenerimaanBarangProgkeg();
			break;
			case '6':
				$this->LaporanRealisasiRetensi();
			break;
			case '7':
				$this->LaporanDaftarRealisasiRetensi();
			break;
		}
	}
		function BacaTotal($c1,$c,$d,$e,$e1,$bk,$ck,$dk,$p,$q,$querySql)
	{
		global $Main, $DataPengaturan,$HTTP_COOKIE_VARS, $DataOption;
		$daqry_pengaturan = $DataOption;
		$concatNormal = $bk.'.'.$ck.'.'.$dk.'.'.$p.'.'.$q;
		$getData = mysql_query($querySql);
		$naonweh = mysql_num_rows($getData);
		while ($dataTot=mysql_fetch_array($getData)) {
			$concatTot = $dataTot['bk'].'.'.$dataTot['ck'].'.'.$dataTot['dk'].'.'.$dataTot['p'].'.'.$dataTot['q'];
			if ($concatTot == $concatNormal) {
			     $totalJumlah += $dataTot['jml'];
			     $totalharga += $dataTot['harga_total'];
			}

			
		}

		return array($totalJumlah,$totalharga,$querySql,$concatNormal,$naonweh
		 );
	}
	function LaporanRetensiPenerimaanBarang($xls =FALSE){
		global $Main, $DataPengaturan,$HTTP_COOKIE_VARS, $DataOption;
		$nama_laporan = $_REQUEST['nama_laporan'];
		$tgl_cetak = date('m-d-Y');
		$dari = $_REQUEST['dari'];
		$dari_tgl = explode("-",$_REQUEST['dari']);
		$sampai = $_REQUEST['sampai'];
		$sampai_tgl = explode("-",$_REQUEST['sampai']);
		$perolehan = $_REQUEST['perolehan'];
		$sumber_Danas = $_REQUEST['sumber_Danas'];
		if ($perolehan == 1) {
			$namaPerolehan = "PEMBELIAN";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND aa.asal_usul='1'";
		}elseif ($perolehan == 2) {
			$namaPerolehan = "HIBAH";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND aa.asal_usul='2'";
		}elseif ($perolehan == 3) {
			$namaPerolehan = "LAINNYA";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND aa.asal_usul='3'";
		}else{
			$queryPerolehan = " ";
			$Perolehans = "";
		}

                         if ($sumber_Danas == "") {
                         	$querySumber = " ";
                         }
		else if ($nama_laporan == 1 || $nama_laporan == 2 || $nama_laporan == 3) {
		      $querySumber = "AND aa.sumber_dana='$sumber_Danas'";
		}else{
                             $querySumber = "AND aa.sumber_dana='APBD'";
		}

		$tgl_dari = $dari_tgl[2]."-".$dari_tgl[1]."-".$dari_tgl[0];
		$tgl_sampai = $sampai_tgl[2]."-".$sampai_tgl[1]."-".$sampai_tgl[0];
		$namauid = $_COOKIE['coNama'];
		$c1 = $_REQUEST['c1nya'];
		$c = $_REQUEST['cnya'];
		$d = $_REQUEST['dnya'];
		$e = $_REQUEST['enya'];
		$e1 = $_REQUEST['e1nya'];
		
		$whereskpd = '';
		if($DataOption["skpd"] == 1){
			$whereskpd .= "aa.c1='$c1' AND";
		}else{
			if($c1!='0'){
				$whereskpd .= "aa.c1='$c1' AND";
			}
		}		
		if($c != "00")$whereskpd.= " aa.c='$c'";
		if($d != '00')$whereskpd.=" AND aa.d='$d'";
		if($e != '00')$whereskpd.=" AND aa.e='$e'";
		if($e1 != '000')$whereskpd.=" AND aa.e1='$e1'";
		
		if($whereskpd != '')$whereskpd.=" AND ";
		
		
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		
		$daqry_pengaturan = $DataOption;


				if ($e == "00") {
		   $querysE = "";
		}else{
			$querysE = "AND t_penerimaan_retensi.e='$e'";
		}


	     if ($e1 == "000") {
		   $querysE1 = "";
		}else{
			$querysE1 = "AND t_penerimaan_retensi.e1='$e1'";
		}


		
		/*$qry = "SELECT tpb.*, hit.cnt FROM (SELECT aa.Id, aa.tgl_buku, aa.no_dokumen_sumber, aa.tgl_dokumen_sumber, aa.dokumen_sumber, aa.refid_penyedia, aa.nomor_kontrak, aa.tgl_kontrak, aa.id_penerimaan, bb.nm_barang, bb.ket_barang, bb.jml, bb.harga_satuan, bb.harga_total, bb.keterangan FROM ".$this->TblName." aa RIGHT JOIN ".$DataPengaturan->VPenerima_det()." bb ON aa.Id=bb.refid_terima WHERE $whereskpd AND aa.sttemp='0' AND bb.sttemp='0' AND aa.tgl_dokumen_sumber >= '$tgl_dari' AND aa.tgl_dokumen_sumber <= '$tgl_sampai' AND aa.jns_trans='1' GROUP BY bb.Id) tpb
LEFT JOIN (SELECT refid_terima, COUNT(Id) as cnt FROM ".$DataPengaturan->VPenerima_det()." GROUP BY refid_terima) hit ON tpb.Id=hit.refid_terima ";*/
		$qry = "SELECT * from t_penerimaan_retensi Where sttemp ='0' AND c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1'";
		$qry = "SELECT  t_penerimaan_retensi.Id , t_penerimaan_retensi_det.refid_retensi,ref_barang.nm_barang,t_penerimaan_retensi_det.harga_total,t_penerimaan_retensi_det.keterangan,t_penerimaan_retensi.tgl_dokumen_sumber,t_penerimaan_retensi.dokumen_sumber
			FROM ((t_penerimaan_retensi
			INNER JOIN t_penerimaan_retensi_det ON t_penerimaan_retensi.Id = t_penerimaan_retensi_det.refid_retensi)
			INNER JOIN ref_barang ON ref_barang.f1 = t_penerimaan_retensi_det.f1 AND ref_barang.f2 = t_penerimaan_retensi_det.f2 AND 
			ref_barang.f = t_penerimaan_retensi_det.f AND ref_barang.g = t_penerimaan_retensi_det.g AND  ref_barang.h = t_penerimaan_retensi_det.h AND 
			 ref_barang.i = t_penerimaan_retensi_det.i AND ref_barang.j = t_penerimaan_retensi_det.j) WHERE  (tgl_buku BETWEEN '$tgl_dari' AND '$tgl_sampai') AND t_penerimaan_retensi.sttemp ='0' $querySumber  AND t_penerimaan_retensi.c1='$c1' AND t_penerimaan_retensi.c='$c' AND t_penerimaan_retensi.d='$d' $querysE $querysE1";
		$aqry = mysql_query($qry);
		
		$tglMulai = date("d M Y", strtotime($dari));
		$tglSampai = date("d M Y", strtotime($sampai));
				
		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------ 
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo 
				"<html>
			<link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontFamily[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontMenubar[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$ContentFontStyle[option_value]'>
  		<link rel='stylesheet' type='text/css' href='js/pengadaanpenerimaan/PageNumber/pageNumber.css'>
  		<script type='text/javascript' src='assets/js/jquery-3.2.1.min.js'></script>
  		<script type='text/javascript' src='js/pengadaanpenerimaan/PageNumber/pageNumber.js'></script>
  		<script type='text/javascript' src='assets/js/bootstrap.min.js'></script>".
				"<head>
					<title>$Main->Judul</title>
					$css					
					$this->Cetak_OtherHTMLHead
					<style>
					
						
						.ukurantulisan {
						    font-size: 14px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
						thead{ 
						       display:table-header-group; 
						}

						@page { 
							    size: auto; 

							    margin: 1.5cm 1cm 1.4cm 1.5cm;  
							} 


							body  
							{ 
							   counter-reset: section;    
							    margin: 0px;  
							} 
					</style>
				</head>".
			"$body 
			<div style='width:100%;'>
			      <table class=\"rangkacetak\" style='width: 33cm; font-family: sans-serif; >
						<tr>
							<td valign=\"top\"> <div style='text-align:left;'>
							<table style='width: 100%; border: none; margin-bottom: 0.5%;'>
							   <tbody style='vertical-align: -webkit-baseline-middle;'>
								<tr>
								<td style='width: 10%;text-align:left;max-width: 130px;max-height: 80.59px;''>
										<img src='".getImageReport()."' style='max-width: 102.02px;max-height: 84.59px;'>
									</td>
									<td style='text-align:center;'>
										<span style='font-size:18px;font-weight:bold;text-decoration: '>
		".$this->JudulLaporan($tglMulai , $tglSampai, 'DAFTAR RETENSI PENERIMAAN BARANG '.$Perolehans.'')."
										</span>
									</td>
									<td style='width: 10%; text-align:center;''>
										<img style='height: 10%;'>
									</td>
								</tr>
							        </tbody>
							</table>"."
					<table width=\"100%\" border=\"0\" class='subjudulcetak' style='margin-top:15px;'>

				".$this->LaporanTmplSKPD($c1,$c,$d,$e,$e1)."
					
					
				</table>";
								
		//echo $qry;
		echo "
								<br>
								<table table width='100%' class='cetak' border='1' style='margin:-3px 0 0 0;width:100%;'>
								<thead>
									<tr>
										<th class='th01' rowspan='2'>NO</th>
										<th class='th01' rowspan='2'>TANGGAL</th>
										<th class='th01' rowspan='2'>NAMA BARANG</th>
										<th class='th01' rowspan='2' style='width:10%;'>JUMLAH HARGA (Rp)</th>
										<th class='th01' rowspan='2' style='width:7%;'>SUMBER DANA</th>
										<th class='th01' rowspan='2'>DOKUMEN SUMBER</th>
										<th class='th01' rowspan='2'>ID PENERIMAAN/ KETERANGAN</th>
									</tr>
								</thead>

		";
		
	$pid = '';
		$no_cek = 0;
		$no = 1;
		$tot_hrg = 0;
		while($daqry = mysql_fetch_array($aqry)){
			if($pid != $daqry['Id'])$no_cek=0;
			
			$tgl_dokumen_sumber = explode("-",$daqry['tgl_dokumen_sumber']);
			$tgl_kontrak = explode("-",$daqry['tgl_kontrak']);
			if($pid != $daqry['Id']){
				if($daqry['cnt'] == 1){
					$dokumen = "KONTRAK<br>".$daqry['dokumen_sumber'];
					$no_dokumen = $daqry['nomor_kontrak']."<br>".$daqry['no_dokumen_sumber'];
					$tgl_dokumen = $tgl_kontrak[2]."-".$tgl_kontrak[1]."-".$tgl_kontrak[0]."<br>".$tgl_dokumen_sumber[2]."-".$tgl_dokumen_sumber[1]."-".$tgl_dokumen_sumber[0];
					$no_cek = 0;
				}else{
					$dokumen = "KONTRAK";
					$no_dokumen = $daqry['nomor_kontrak'];
					$tgl_dokumen = $tgl_kontrak[2]."-".$tgl_kontrak[1]."-".$tgl_kontrak[0];
				}				
			}else{
				if($no_cek == 1){
					$dokumen = $daqry['dokumen_sumber'];
					$no_dokumen = $daqry['no_dokumen_sumber'];
					$tgl_dokumen = $tgl_dokumen_sumber[2]."-".$tgl_dokumen_sumber[1]."-".$tgl_dokumen_sumber[0];
				}else{
					$dokumen='';
					$no_dokumen='';
					$tgl_dokumen='';
				}
				
			}
			$pid = $daqry['Id'];
			$dataSumber =  mysql_fetch_array(mysql_query("SELECT * from t_penerimaan_barang where Id = '$pid'"));
			// PENYEDIA
			$penyedia = $DataPengaturan->QyrTmpl1Brs('ref_penyedia', 'nama_penyedia', "WHERE id='".$daqry['refid_penyedia']."'");
			$nm_penyedia = $penyedia['hasil'];
			//TGL BUKU & NO BAST
			if($no_cek == 0){
				$tgl_buku_nya = explode("-", $daqry['tgl_buku']);
				$tgl_buku = $tgl_buku_nya[2]."-".$tgl_buku_nya[1]."-".$tgl_buku_nya[0];
				$no_bast = $daqry['no_dokumen_sumber']; 
				$id_penerimaan = $dataSumber['id_penerimaan']."<br>";
			}else{
				$tgl_buku='';
				$no_bast='';
				$id_penerimaan='';
			}
			$tgl_buku = $dataSumber['tgl_buku'];
			$tgl_buku = explode('-', $tgl_buku);
			$month = $tgl_buku[0];
			$day   = $tgl_buku[1];
			$year  = $tgl_buku[2];


			$tgl_dokumen = $daqry['tgl_dokumen_sumber'];
			$tgl_dokumen = explode('-', $tgl_dokumen);
			$years = $tgl_dokumen[0];
			$months   = $tgl_dokumen[1];
			$days  = $tgl_dokumen[2];
			
			echo "
					                                 <tr valign='top'>
									<td align='center' class='GarisCetak'>$no</td>
									<td align='center' class='GarisCetak' style='width:75px;'>".$year.'-'.$day.'-'.$month."</td>
									<td class='GarisCetak'>".$daqry['nm_barang']."</td>
									<td align='right' class='GarisCetak'>".number_format($daqry['harga_total'],2,',','.')."</td>
									<td align='center' class='GarisCetak'>".$dataSumber['sumber_dana']."</td>
									<td class='GarisCetak'>".$daqry['dokumen_sumber']." / 
									".$days."-".$months."-".$years."
									<br><span><b>".$dataSumber['no_dokumen_sumber']."  </b></span></td>
									<td class='GarisCetak'>".$id_penerimaan.$daqry['keterangan']."</td>
								</tr>
			";
			
			$no++;
			$no_cek++;
			
			$tot_hrg = $tot_hrg+intval($daqry['harga_total']);
		}
			echo "<tr>
				<td align='right' class='GarisCetak' colspan='3'><b>TOTAL</b></td>
				
				<td align='right' class='GarisCetak' colspan='1'><b>".number_format($tot_hrg,2,',','.')."</b></td>
				<td align='right' class='GarisCetak' colspan='3'><b></b></td>
									</tr>
								</table>";	
		echo  $this->TandaTanganFooter($c1,$c,$d,$e,$e1).
		  "<footer>
				<h5 class='pag pag1' style='bottom:-10px; font-size: 9px;'>
				   <span style='bottom: 0px; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
			            </h5>
		                <div class='insert'></div>
		    </footer>

			</body>	
		</html>";
	}

	function RekapitulasiRetensiPenerimaanBarang($xls =FALSE){
		global $Main, $DataPengaturan,$HTTP_COOKIE_VARS, $DataOption;
		
		$nama_laporan = $_REQUEST['nama_laporan'];
		$tgl_cetak = date('m-d-Y');
		$dari = $_REQUEST['dari'];
		$dari_tgl = explode("-",$_REQUEST['dari']);
		$sampai = $_REQUEST['sampai'];
		$sampai_tgl = explode("-",$_REQUEST['sampai']);
		$perolehan = $_REQUEST['perolehan'];
		if ($perolehan == 1) {
			$namaPerolehan = "PEMBELIAN";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND tpd.asal_usul='$perolehan'";
		}elseif ($perolehan == 2) {
			$namaPerolehan = "HIBAH";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND tpd.asal_usul='$perolehan'";
		}elseif ($perolehan == 3) {
			$namaPerolehan = "LAINNYA";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND tpd.asal_usul='$perolehan'";
		}else{
			$queryPerolehan = " ";
			$Perolehans = "";
		}

		$sumber_Danas = $_REQUEST['sumber_Danas'];
		if ($sumber_Danas =="") {
		      $querySumber = " ";
		}else if ($nama_laporan == 1 || $nama_laporan == 2 || $nama_laporan == 3) {
		      $querySumber = "AND tpd.sumber_dana='$sumber_Danas'";
		}else{
                             $querySumber = "AND tpd.sumber_dana='APBD'";
		}

		$tgl_dari = $dari_tgl[2]."-".$dari_tgl[1]."-".$dari_tgl[0];
		$tgl_sampai = $sampai_tgl[2]."-".$sampai_tgl[1]."-".$sampai_tgl[0];
		$namauid = $_COOKIE['coNama'];
		$c1 = $_REQUEST['c1nya'];
		$c = $_REQUEST['cnya'];
		$d = $_REQUEST['dnya'];
		$e = $_REQUEST['enya'];
		$e1 = $_REQUEST['e1nya'];
		
		$whereskpd = '';
		if($DataOption["skpd"] == 1){
			$whereskpd .= "aa.c1='$c1' AND";
		}else{
			if($c1!='0'){
				$whereskpd .= "aa.c1='$c1' AND";
			}
		}		
		if($c != "00")$whereskpd.= " aa.c='$c'";
		if($d != '00')$whereskpd.=" AND aa.d='$d'";
		if($e != '00')$whereskpd.=" AND aa.e='$e'";
		if($e1 != '000')$whereskpd.=" AND aa.e1='$e1'";
		
		if($whereskpd != '')$whereskpd=" AND ".$whereskpd;
		
		$wherekodbar = '';
		if($DataOption['kode_barang'] == '1')$wherekodbar = "AND f1='0' AND f2='0' ";	
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		
		$daqry_pengaturan = $DataOption;
		/*$qry = "SELECT * FROM (SELECT vtpdet.*, tpd.tgl_dokumen_sumber, tpd.jns_trans FROM ".$DataPengaturan->VPenerima_det()." vtpdet LEFT JOIN t_penerimaan_barang tpd ON vtpdet.refid_terima=tpd.Id WHERE tpd.sttemp='0' AND vtpdet.sttemp='0' AND tpd.jns_trans='1') aa WHERE tgl_dokumen_sumber>='$tgl_dari' AND tgl_dokumen_sumber<='$tgl_sampai' AND $whereskpd $wherekodbar";*/
		// $qry = "SELECT * FROM (SELECT vtpdet.*, tpd.tgl_dokumen_sumber,tpd.sumber_dana , tpd.asal_usul, tpd.jns_trans FROM ".$DataPengaturan->VPenerima_det()." vtpdet LEFT JOIN t_penerimaan_retensi tpd ON vtpdet.refid_terima=tpd.Id WHERE tpd.sttemp='0'  $querySumber $queryPerolehan AND vtpdet.sttemp='0' AND tpd.jns_trans='1') aa WHERE (tgl_dokumen_sumber BETWEEN '$tgl_dari' AND '$tgl_sampai') $whereskpd $wherekodbar ORDER BY f1,f2,f,g,h,i,j";

		if ($e == "00") {
		   $querysE = "";
		}else{
			$querysE = "AND t_penerimaan_retensi.e='$e'";
		}


	     if ($e1 == "000") {
		   $querysE1 = "";
		}else{
			$querysE1 = "AND t_penerimaan_retensi.e1='$e1'";
		}


		$qry = "SELECT  t_penerimaan_retensi.Id , t_penerimaan_retensi_det.refid_retensi,ref_barang.nm_barang,t_penerimaan_retensi_det.f1,t_penerimaan_retensi_det.f2,t_penerimaan_retensi_det.f,t_penerimaan_retensi_det.g,t_penerimaan_retensi_det.h,t_penerimaan_retensi_det.i,t_penerimaan_retensi_det.j,t_penerimaan_retensi_det.harga_total,t_penerimaan_retensi_det.keterangan,t_penerimaan_retensi.tgl_dokumen_sumber,t_penerimaan_retensi.dokumen_sumber
			FROM ((t_penerimaan_retensi
			INNER JOIN t_penerimaan_retensi_det ON t_penerimaan_retensi.Id = t_penerimaan_retensi_det.refid_retensi)
			INNER JOIN ref_barang ON ref_barang.f1 = t_penerimaan_retensi_det.f1 AND ref_barang.f2 = t_penerimaan_retensi_det.f2 AND 
			ref_barang.f = t_penerimaan_retensi_det.f AND ref_barang.g = t_penerimaan_retensi_det.g AND  ref_barang.h = t_penerimaan_retensi_det.h AND 
			 ref_barang.i = t_penerimaan_retensi_det.i AND ref_barang.j = t_penerimaan_retensi_det.j) WHERE  (tgl_buku BETWEEN '$tgl_dari' AND '$tgl_sampai') AND t_penerimaan_retensi.sttemp ='0' $querySumber  AND t_penerimaan_retensi.c1='$c1' AND t_penerimaan_retensi.c='$c' AND t_penerimaan_retensi.d='$d'  $querysE $querysE1";

		$aqry = mysql_query($qry);
		$tglMulai = date("d M Y", strtotime($dari));
		$tglSampai = date("d M Y", strtotime($sampai));
		
				
		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------ 
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
				echo 
			"<html>
			<link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontFamily[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontMenubar[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$ContentFontStyle[option_value]'>
  		<script type='text/javascript' src='js/pengadaanpenerimaan/pageNumber/pageNumber.css'></script>
  		<script type='text/javascript' src='assets/js/jquery-3.2.1.min.js'></script>
  		<script type='text/javascript' src='js/pengadaanpenerimaan/pageNumber/pageNumber2.js'></script>
  		<script type='text/javascript' src='assets/js/bootstrap.min.js'></script>".
				"<head>
					<title>$Main->Judul</title>
					$css					
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan {
						    font-size: 14px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
						thead{ 
						       display:table-header-group; 
						}

						@page { 
							    size: auto; 

							    margin: 1.5cm 1cm 1.4cm 1.5cm;  
							} 


							body  
							{ 
							   counter-reset: section;    
							    margin: 0px;  
							} 
					</style>
				</head>".
			"<body >
	<div style='width:28.6cm;'>
			      <table class=\"rangkacetak\" style='width:100%; font-family: sans-serif; '>

							<td valign=\"top\"> <div style='text-align:center;'>
							<table style='width: 100%; border: none; margin-bottom: 0.5%;'>
							<tbody style='vertical-align: -webkit-baseline-middle;'>
								<tr>
								<td style='width: 10%;text-align:left;max-width: 130px;max-height: 80.59px;''>
										<img src='".getImageReport()."' style='max-width: 102.02px;max-height: 84.59px;'>
									</td>
									<td style='text-align:center;'>
										<span style='font-size:18px;font-weight:bold;text-decoration: '>".
								$this->JudulLaporan($tglMulai , $tglSampai, 'REKAPITULASI RETENSI PENERIMAAN BARANG '.$Perolehans.'')."

										</span>
									</td>
									<td style='width: 10%; text-align:center;''>
										<img style='height: 10%;'>
									</td>
								</tr>
							   <tbody>
							</table>"."
					<table width=\"100%\" border=\"0\" class='subjudulcetak' style='margin-bottom: -4px; margin-top:1%;'>

				".$this->LaporanTmplSKPD($c1,$c,$d,$e,$e1)."
					
					
				</table>"."

								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<thead>
									<tr>
										<th class='th01' style='width:3%; text-align:center;'>NO</th>
										<th class='th01' style='width:9%;'>KODE BARANG</th>
										<th class='th01'>NAMA BARANG</th>
										<th class='th01' style='width:14%;'>JUMLAH HARGA (Rp)</th>
									</tr>
									</thead>
							";
		$no=1;	
		$jml_brg = 0;
		$tot_hrg = 0;					
		while($daqry = mysql_fetch_array($aqry)){
			$kodebarang = $daqry['f'].".".$daqry['g'].".".$daqry['h'].".".$daqry['i'].".".$daqry['j'];
			if($DataOption['kode_barang'] != '1')$kodebarang = $daqry['f1'].'.'.$daqry['f2'].$kodebarang;
			echo				"
									<tr>
										<td align='right' class='GarisCetak' style=' text-align:center;'>$no</td>
										<td align='center' class='GarisCetak'>$kodebarang</td>
										<td class='GarisCetak'>".$daqry['nm_barang']."</td>
										<td align='right' class='GarisCetak'>".number_format($daqry['harga_total'],2,',','.')."</td>
									</tr>
			";
			$jml_brg = $jml_brg+intval($daqry['jml']);
			$tot_hrg = $tot_hrg+intval($daqry['harga_total']);
			$no++;					
		}
		
		echo 
								"	<tr>
										<td align='center' class='GarisCetak' colspan='3'><b>TOTAL</b></td>
										<td align='right' class='GarisCetak'><b>".number_format($tot_hrg,2,',','.')."</b></td>
									</tr>
								</table>".
							$this->TandaTanganFooterP($c1,$c,$d,$e,$e1).
						"<footer>
				<h5 class='pag pag1' style='bottom:-10px; font-size: 9px;'>
				   <span style='bottom: 0px; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
			            </h5>
		                <div class='insert'></div>
		    </footer>

			</body>	
		</html>";
	}

function LaporanDaftarRealisasiRetensi($xls =FALSE){
		global $Main, $DataPengaturan,$HTTP_COOKIE_VARS, $DataOption;
		
		$nama_laporan = $_REQUEST['nama_laporan'];
		$tgl_cetak = date('m-d-Y');
		$dari = $_REQUEST['dari'];
		$dari_tgl = explode("-",$_REQUEST['dari']);
		$sampai = $_REQUEST['sampai'];
		$sampai_tgl = explode("-",$_REQUEST['sampai']);
		$perolehan = $_REQUEST['perolehan'];
		if ($perolehan == 1) {
			$namaPerolehan = "PEMBELIAN";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND tpd.asal_usul='$perolehan'";
		}elseif ($perolehan == 2) {
			$namaPerolehan = "HIBAH";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND tpd.asal_usul='$perolehan'";
		}elseif ($perolehan == 3) {
			$namaPerolehan = "LAINNYA";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND tpd.asal_usul='$perolehan'";
		}else{
			$queryPerolehan = " ";
			$Perolehans = "";
		}

		$sumber_Danas = $_REQUEST['sumber_Danas'];
		if ($sumber_Danas =="") {
		      $querySumber = " ";
		}else if ($nama_laporan == 1 || $nama_laporan == 2 || $nama_laporan == 3) {
		      $querySumber = "AND tpd.sumber_dana='$sumber_Danas'";
		}else{
                             $querySumber = "AND tpd.sumber_dana='APBD'";
		}

		$tgl_dari = $dari_tgl[2]."-".$dari_tgl[1]."-".$dari_tgl[0];
		$tgl_sampai = $sampai_tgl[2]."-".$sampai_tgl[1]."-".$sampai_tgl[0];
		$namauid = $_COOKIE['coNama'];
		$c1 = $_REQUEST['c1nya'];
		$c = $_REQUEST['cnya'];
		$d = $_REQUEST['dnya'];
		$e = $_REQUEST['enya'];
		$e1 = $_REQUEST['e1nya'];
		
$whereskpd = '';
		if($DataOption["skpd"] == 1){
			$whereskpd .= "c1='$c1' AND";
		}else{
			if($c1!='0'){
				$whereskpd .= "c1='$c1' AND";
			}
		}		
		if($c != "00")$whereskpd.= " c='$c'";
		if($d != '00')$whereskpd.=" AND d='$d'";
		if($e != '00')$whereskpd.=" AND e='$e'";
		if($e1 != '000')$whereskpd.=" AND e1='$e1'";
		
		if($whereskpd != '')$whereskpd=" AND ".$whereskpd;
		
		$wherekodbar = '';
		if($DataOption['kode_barang'] == '1')$wherekodbar = "AND f1='0' AND f2='0' ";	
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		
		$daqry_pengaturan = $DataOption;
		/*$qry = "SELECT * FROM (SELECT vtpdet.*, tpd.tgl_dokumen_sumber, tpd.jns_trans FROM ".$DataPengaturan->VPenerima_det()." vtpdet LEFT JOIN t_penerimaan_barang tpd ON vtpdet.refid_terima=tpd.Id WHERE tpd.sttemp='0' AND vtpdet.sttemp='0' AND tpd.jns_trans='1') aa WHERE tgl_dokumen_sumber>='$tgl_dari' AND tgl_dokumen_sumber<='$tgl_sampai' AND $whereskpd $wherekodbar";*/
		$qry = "SELECT a.*,b.nm_rekening, ifnull(sum(jumlah),0) as totalJumlah FROM t_penerimaan_rek_biaya a LEFT JOIN ref_rekening b on a.k=b.k and a.l=b.l and a.m=b.m and a.n=b.n and a.o=b.o WHERE   jns_trans='4' and  (tgl_buku BETWEEN '$tgl_dari' AND '$tgl_sampai') $whereskpd  GROUP BY k,l,m,n,o ORDER BY k,l,m,n,o";
		$aqry = mysql_query($qry);
		$tglMulai = date("d M Y", strtotime($dari));
		$tglSampai = date("d M Y", strtotime($sampai));
		
				
		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------ 
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
				echo 
			"<html>
			<link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontFamily[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontMenubar[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$ContentFontStyle[option_value]'>
  		<script type='text/javascript' src='js/pengadaanpenerimaan/pageNumber/pageNumber.css'></script>
  		<script type='text/javascript' src='assets/js/jquery-3.2.1.min.js'></script>
  		<script type='text/javascript' src='js/pengadaanpenerimaan/pageNumber/pageNumber2.js'></script>
  		<script type='text/javascript' src='assets/js/bootstrap.min.js'></script>".
				"<head>
					<title>$Main->Judul</title>
					$css					
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan {
						    font-size: 14px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
						thead{ 
						       display:table-header-group; 
						}

						@page { 
							    size: auto; 

							    margin: 1.5cm 1cm 1.4cm 1.5cm;  
							} 


							body  
							{ 
							   counter-reset: section;    
							    margin: 0px;  
							} 
					</style>
				</head>".
			"<body >
	<div style='width:28.6cm;'>
			      <table class=\"rangkacetak\" style='width:100%; font-family: sans-serif; '>

							<td valign=\"top\"> <div style='text-align:center;'>
							<table style='width: 100%; border: none; margin-bottom: 0.5%;'>
							   <tbody style='vertical-align: -webkit-baseline-middle;'>

								<tr>
								<td style='width: 10%;text-align:left;max-width: 130px;max-height: 80.59px;''>
										<img src='".getImageReport()."' style='max-width: 102.02px;max-height: 84.59px;'>
									</td>
									<td style='text-align:center;'>
										<span style='font-size:18px;font-weight:bold;text-decoration: '>".
								$this->JudulLaporan($tglMulai , $tglSampai, 'LAPORAN REALISASI RETENSI'.$Perolehans.'')."

										</span>
									</td>
									<td style='width: 10%; text-align:center;''>
										<img style='height: 10%;'>
									</td>
								</tr>
							   </tbody>
							</table>"."
					<table width=\"100%\" border=\"0\" class='subjudulcetak' style='margin-bottom: -4px; margin-top:1%;'>

				".$this->LaporanTmplSKPD($c1,$c,$d,$e,$e1)."
					
					
				</table>"."

								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<thead>
									<tr>
										<th class='th01'>NO</th>
										<th class='th01'>KODE REKENING</th>
										<th class='th01'>URAIAN REKENING</th>
										<th class='th01'>HARGA (Rp)</th>
									</tr>
									</thead>
							";
		$no=1;	
		$jmlRek = 0;
		$tot_hrg = 0;			
		while($daqry = mysql_fetch_array($aqry)){
		$perolehan = $_REQUEST['perolehan'];
		if ($perolehan == 1) {
			
			$queryPerolehan = "AND asal_usul='$perolehan'";
		}elseif ($perolehan == 2) {
			
			$queryPerolehan = "AND asal_usul='$perolehan'";
		}elseif ($perolehan == 3) {
			
			$queryPerolehan = "AND asal_usul='$perolehan'";
		}else{
			$queryPerolehan = " ";
		}

		$sumber_Danas = $_REQUEST['sumber_Danas'];
		if ($sumber_Danas =="") {
		      $querySumber = " ";
		}else if ($nama_laporan == 1 || $nama_laporan == 2 || $nama_laporan == 3) {
		      $querySumber = "AND sumber_dana='$sumber_Danas'";
		}else{
                             $querySumber = "AND sumber_dana='APBD'";
		}


		$whereskpd = '';
		if($DataOption["skpd"] == 1){
			$whereskpd .= "c1='$c1' AND";
		}else{
			if($c1!='0'){
				$whereskpd .= "c1='$c1' AND";
			}
		}		
		if($c != "00")$whereskpd.= " c='$c'";
		if($d != '00')$whereskpd.=" AND d='$d'";
		if($e != '00')$whereskpd.=" AND e='$e'";
		if($e1 != '000')$whereskpd.=" AND e1='$e1'";
		
		if($whereskpd != '')$whereskpd=" AND ".$whereskpd;


		$koderekening = $daqry['k'].".".$daqry['l'].".".$daqry['m'].".".$daqry['n'].".".$daqry['o'];
	


		$echo ="
									<tr>
										<td align='center' class='GarisCetak' style='border-bottom:hidden;'>$no</td>
										<td align='center' class='GarisCetak' style='width:12%; border-bottom:hidden;'>$koderekening</td>
										<td class='GarisCetak'  style='border-bottom:hidden;'>".$daqry['nm_rekening']."</td>
										<td align='right' class='GarisCetak' style='border-bottom:hidden;'>".number_format($daqry['totalJumlah'],2,',','.')."</td>
									</tr>
			";
		if (in_array($koderekening, $this->arrayRekening)) {
			  $echo = "";
		}else{
			 
$no++;	
			
		}
			
			$jmlRek = $jmlRek+intval($daqry['totalJumlah']);
			echo $echo;	
			$this->arrayRekening[] = $daqry['k'].".".$daqry['l'].".".$daqry['m'].".".$daqry['n'].".".$daqry['o'];			
		}
	
		
		echo 
								"	<tr>
										
									</tr>
									<tr>
										<td align='center' class='GarisCetak' colspan='3' ><b>TOTAL</b></td>
										
										<td align='right' class='GarisCetak' ><b>".number_format($jmlRek,2,',','.')."</b></td>
									</tr>
								</table>".
							$this->TandaTanganFooterP($c1,$c,$d,$e,$e1).
						"<footer>
				<h5 class='pag pag1' style='bottom:-10px; font-size: 9px;'>
				   <span style='bottom: 0px; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
			            </h5>
		                <div class='insert'></div>
		    </footer>

			</body>	
		</html>";
	}


function LaporanRealisasiRetensi($xls =FALSE){
		global $Main, $DataPengaturan,$HTTP_COOKIE_VARS, $DataOption;
		
		$nama_laporan = $_REQUEST['nama_laporan'];
		$tgl_cetak = date('m-d-Y');
		$dari = $_REQUEST['dari'];
		$dari_tgl = explode("-",$_REQUEST['dari']);
		$sampai = $_REQUEST['sampai'];
		$sampai_tgl = explode("-",$_REQUEST['sampai']);
		$perolehan = $_REQUEST['perolehan'];
		if ($perolehan == 1) {
			$namaPerolehan = "PEMBELIAN";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND tpd.asal_usul='$perolehan'";
		}elseif ($perolehan == 2) {
			$namaPerolehan = "HIBAH";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND tpd.asal_usul='$perolehan'";
		}elseif ($perolehan == 3) {
			$namaPerolehan = "LAINNYA";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND tpd.asal_usul='$perolehan'";
		}else{
			$queryPerolehan = " ";
			$Perolehans = "";
		}

		$sumber_Danas = $_REQUEST['sumber_Danas'];
		if ($sumber_Danas =="") {
		      $querySumber = " ";
		}else if ($nama_laporan == 1 || $nama_laporan == 2 || $nama_laporan == 3) {
		      $querySumber = "AND tpd.sumber_dana='$sumber_Danas'";
		}else{
                             $querySumber = "AND tpd.sumber_dana='APBD'";
		}

		$tgl_dari = $dari_tgl[2]."-".$dari_tgl[1]."-".$dari_tgl[0];
		$tgl_sampai = $sampai_tgl[2]."-".$sampai_tgl[1]."-".$sampai_tgl[0];
		$namauid = $_COOKIE['coNama'];
		$c1 = $_REQUEST['c1nya'];
		$c = $_REQUEST['cnya'];
		$d = $_REQUEST['dnya'];
		$e = $_REQUEST['enya'];
		$e1 = $_REQUEST['e1nya'];
		
$whereskpd = '';
		if($DataOption["skpd"] == 1){
			$whereskpd .= "c1='$c1' AND";
		}else{
			if($c1!='0'){
				$whereskpd .= "c1='$c1' AND";
			}
		}		
		if($c != "00")$whereskpd.= " c='$c'";
		if($d != '00')$whereskpd.=" AND d='$d'";
		if($e != '00')$whereskpd.=" AND e='$e'";
		if($e1 != '000')$whereskpd.=" AND e1='$e1'";
		
		if($whereskpd != '')$whereskpd=" AND ".$whereskpd;
		
		$wherekodbar = '';
		if($DataOption['kode_barang'] == '1')$wherekodbar = "AND f1='0' AND f2='0' ";	
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		
		$daqry_pengaturan = $DataOption;
		/*$qry = "SELECT * FROM (SELECT vtpdet.*, tpd.tgl_dokumen_sumber, tpd.jns_trans FROM ".$DataPengaturan->VPenerima_det()." vtpdet LEFT JOIN t_penerimaan_barang tpd ON vtpdet.refid_terima=tpd.Id WHERE tpd.sttemp='0' AND vtpdet.sttemp='0' AND tpd.jns_trans='1') aa WHERE tgl_dokumen_sumber>='$tgl_dari' AND tgl_dokumen_sumber<='$tgl_sampai' AND $whereskpd $wherekodbar";*/
		$qry = "SELECT a.*,b.nm_rekening, ifnull(sum(jumlah),0) as totalJumlah FROM t_penerimaan_rek_biaya a LEFT JOIN ref_rekening b on a.k=b.k and a.l=b.l and a.m=b.m and a.n=b.n and a.o=b.o WHERE     (tgl_buku BETWEEN '$tgl_dari' AND '$tgl_sampai') $whereskpd  GROUP BY k,l,m,n,o ORDER BY k,l,m,n,o";
		$aqry = mysql_query($qry);
		$tglMulai = date("d M Y", strtotime($dari));
		$tglSampai = date("d M Y", strtotime($sampai));
		
				
		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------ 
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
				echo 
			"<html>
			<link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontFamily[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontMenubar[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$ContentFontStyle[option_value]'>
  		<script type='text/javascript' src='js/pengadaanpenerimaan/pageNumber/pageNumber.css'></script>
  		<script type='text/javascript' src='assets/js/jquery-3.2.1.min.js'></script>
  		<script type='text/javascript' src='js/pengadaanpenerimaan/pageNumber/pageNumber2.js'></script>
  		<script type='text/javascript' src='assets/js/bootstrap.min.js'></script>".
				"<head>
					<title>$Main->Judul</title>
					$css					
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan {
						    font-size: 14px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
						thead{ 
						       display:table-header-group; 
						}

						@page { 
							    size: auto; 

							    margin: 1.5cm 1cm 1.4cm 1.5cm;  
							} 


							body  
							{ 
							   counter-reset: section;    
							    margin: 0px;  
							} 
					</style>
				</head>".
			"<body >
	<div style='width:28.6cm;'>
			      <table class=\"rangkacetak\" style='width:100%; font-family: sans-serif; '>

							<td valign=\"top\"> <div style='text-align:center;'>
							<table style='width: 100%; border: none; margin-bottom: 0.5%;'>
							   <tbody style='vertical-align: -webkit-baseline-middle;'>

								<tr>
								<td style='width: 10%;text-align:left;max-width: 130px;max-height: 80.59px;''>
										<img src='".getImageReport()."' style='max-width: 102.02px;max-height: 84.59px;'>
									</td>
									<td style='text-align:center;'>
										<span style='font-size:18px;font-weight:bold;text-decoration: '>".
								$this->JudulLaporan($tglMulai , $tglSampai, 'LAPORAN REALISASI '.$Perolehans.'')."

										</span>
									</td>
									<td style='width: 10%; text-align:center;''>
										<img style='height: 10%;'>
									</td>
								</tr>
							   </tbody>
							</table>"."
					<table width=\"100%\" border=\"0\" class='subjudulcetak' style='margin-bottom: -4px; margin-top:1%;'>

				".$this->LaporanTmplSKPD($c1,$c,$d,$e,$e1)."
					
					
				</table>"."

								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<thead>
									<tr>
										<th class='th01'>NO</th>
										<th class='th01'>KODE REKENING</th>
										<th class='th01'>URAIAN REKENING</th>
										<th class='th01'>HARGA (Rp)</th>
									</tr>
									</thead>
							";
		$no=1;	
		$jmlRek = 0;
		$tot_hrg = 0;			
		while($daqry = mysql_fetch_array($aqry)){
		$perolehan = $_REQUEST['perolehan'];
		if ($perolehan == 1) {
			
			$queryPerolehan = "AND asal_usul='$perolehan'";
		}elseif ($perolehan == 2) {
			
			$queryPerolehan = "AND asal_usul='$perolehan'";
		}elseif ($perolehan == 3) {
			
			$queryPerolehan = "AND asal_usul='$perolehan'";
		}else{
			$queryPerolehan = " ";
		}

		$sumber_Danas = $_REQUEST['sumber_Danas'];
		if ($sumber_Danas =="") {
		      $querySumber = " ";
		}else if ($nama_laporan == 1 || $nama_laporan == 2 || $nama_laporan == 3) {
		      $querySumber = "AND sumber_dana='$sumber_Danas'";
		}else{
                             $querySumber = "AND sumber_dana='APBD'";
		}


		$whereskpd = '';
		if($DataOption["skpd"] == 1){
			$whereskpd .= "c1='$c1' AND";
		}else{
			if($c1!='0'){
				$whereskpd .= "c1='$c1' AND";
			}
		}		
		if($c != "00")$whereskpd.= " c='$c'";
		if($d != '00')$whereskpd.=" AND d='$d'";
		if($e != '00')$whereskpd.=" AND e='$e'";
		if($e1 != '000')$whereskpd.=" AND e1='$e1'";
		
		if($whereskpd != '')$whereskpd=" AND ".$whereskpd;


		$koderekening = $daqry['k'].".".$daqry['l'].".".$daqry['m'].".".$daqry['n'].".".$daqry['o'];
	


		$echo ="
									<tr>
										<td align='center' class='GarisCetak' style='border-bottom:hidden;'>$no</td>
										<td align='center' class='GarisCetak' style='width:12%; border-bottom:hidden;'>$koderekening</td>
										<td class='GarisCetak'  style='border-bottom:hidden;'>".$daqry['nm_rekening']."</td>
										<td align='right' class='GarisCetak' style='border-bottom:hidden;'>".number_format($daqry['totalJumlah'],2,',','.')."</td>
									</tr>
			";
		if (in_array($koderekening, $this->arrayRekening)) {
			  $echo = "";
		}else{
			 
$no++;	
			
		}
			
			$jmlRek = $jmlRek+intval($daqry['totalJumlah']);
			echo $echo;	
			$this->arrayRekening[] = $daqry['k'].".".$daqry['l'].".".$daqry['m'].".".$daqry['n'].".".$daqry['o'];			
		}
	
		
		echo 
								"	<tr>
										
									</tr>
									<tr>
										<td align='center' class='GarisCetak' colspan='3' ><b>TOTAL</b></td>
										
										<td align='right' class='GarisCetak' ><b>".number_format($jmlRek,2,',','.')."</b></td>
									</tr>
								</table>".
							$this->TandaTanganFooterP($c1,$c,$d,$e,$e1).
						"<footer>
				<h5 class='pag pag1' style='bottom:-10px; font-size: 9px;'>
				   <span style='bottom: 0px; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
			            </h5>
		                <div class='insert'></div>
		    </footer>

			</body>	
		</html>";
	}

              function LaporanRetensiPengadaanBarang($xls =FALSE){
		global $Main, $DataPengaturan,$HTTP_COOKIE_VARS, $DataOption;
		
		$nama_laporan = $_REQUEST['nama_laporan'];
		$tgl_cetak = date('m-d-Y');
		$dari = $_REQUEST['dari'];
		$dari_tgl = explode("-",$_REQUEST['dari']);
		$sampai = $_REQUEST['sampai'];
		$sampai_tgl = explode("-",$_REQUEST['sampai']);
		$perolehan = $_REQUEST['perolehan'];
		$sumber_Danas = $_REQUEST['sumber_Danas'];
		if ($perolehan == 1) {
			$namaPerolehan = "PEMBELIAN";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND aa.asal_usul='1'";
		}elseif ($perolehan == 2) {
			$namaPerolehan = "HIBAH";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND aa.asal_usul='2'";
		}elseif ($perolehan == 3) {
			$namaPerolehan = "LAINNYA";
			$Perolehans = "<br> <span style=font-size:15px; font-weight:62px;>CARA PEROLEHAN: $namaPerolehan </span>";
			$queryPerolehan = "AND aa.asal_usul='3'";
		}else{
			$queryPerolehan = " ";
			$Perolehans = "";
		}

		if ($sumber_Danas == "") {
		      $querySumber = " ";
		}else if ($nama_laporan == 1 || $nama_laporan == 2 || $nama_laporan == 3) {
		      $querySumber = "AND aa.sumber_dana='$sumber_Danas'";
		}else{
                             $querySumber = "AND aa.sumber_dana='APBD'";
		}

		$tgl_dari = $dari_tgl[2]."-".$dari_tgl[1]."-".$dari_tgl[0];
		$tgl_sampai = $sampai_tgl[2]."-".$sampai_tgl[1]."-".$sampai_tgl[0];
		$namauid = $_COOKIE['coNama'];
		$c1 = $_REQUEST['c1nya'];
		$c = $_REQUEST['cnya'];
		$d = $_REQUEST['dnya'];
		$e = $_REQUEST['enya'];
		$e1 = $_REQUEST['e1nya'];
		$whereskpd = '';
		if($DataOption["skpd"] == 1){
			$whereskpd .= "aa.c1='$c1' AND";
		}else{
			if($c1!='0'){
				$whereskpd .= "aa.c1='$c1' AND";
			}
		}		
		if($c != "00")$whereskpd.= " aa.c='$c'";
		if($d != '00')$whereskpd.=" AND aa.d='$d'";
		if($e != '00')$whereskpd.=" AND aa.e='$e'";
		if($e1 != '000')$whereskpd.=" AND aa.e1='$e1'";
		
		if($whereskpd != '')$whereskpd.=" AND ";
		
		
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		
		$daqry_pengaturan = $DataOption;

				if ($e == "00") {
		   $querysE = "";
		}else{
			$querysE = "AND t_penerimaan_retensi.e='$e'";
		}


	     if ($e1 == "000") {
		   $querysE1 = "";
		}else{
			$querysE1 = "AND t_penerimaan_retensi.e1='$e1'";
		}


		
		/*$qry = "SELECT tpb.*, hit.cnt FROM (SELECT aa.Id, aa.tgl_buku, aa.no_dokumen_sumber, aa.tgl_dokumen_sumber, aa.dokumen_sumber, aa.refid_penyedia, aa.nomor_kontrak, aa.tgl_kontrak, aa.id_penerimaan, bb.nm_barang, bb.ket_barang, bb.jml, bb.harga_satuan, bb.harga_total, bb.keterangan FROM ".$this->TblName." aa RIGHT JOIN ".$DataPengaturan->VPenerima_det()." bb ON aa.Id=bb.refid_terima WHERE $whereskpd AND aa.sttemp='0' AND bb.sttemp='0' AND aa.tgl_dokumen_sumber >= '$tgl_dari' AND aa.tgl_dokumen_sumber <= '$tgl_sampai' AND aa.jns_trans='1' GROUP BY bb.Id) tpb
LEFT JOIN (SELECT refid_terima, COUNT(Id) as cnt FROM ".$DataPengaturan->VPenerima_det()." GROUP BY refid_terima) hit ON tpb.Id=hit.refid_terima ";*/
		$qry = "SELECT  t_penerimaan_retensi.refid_penyedia,t_penerimaan_retensi.nomor_kontrak,t_penerimaan_retensi.tgl_kontrak, t_penerimaan_retensi.Id , t_penerimaan_retensi_det.refid_retensi,ref_barang.nm_barang,t_penerimaan_retensi_det.harga_total,t_penerimaan_retensi_det.keterangan,t_penerimaan_retensi.tgl_dokumen_sumber,t_penerimaan_retensi.dokumen_sumber
			FROM ((t_penerimaan_retensi
			INNER JOIN t_penerimaan_retensi_det ON t_penerimaan_retensi.Id = t_penerimaan_retensi_det.refid_retensi)
			INNER JOIN ref_barang ON ref_barang.f1 = t_penerimaan_retensi_det.f1 AND ref_barang.f2 = t_penerimaan_retensi_det.f2 AND 
			ref_barang.f = t_penerimaan_retensi_det.f AND ref_barang.g = t_penerimaan_retensi_det.g AND  ref_barang.h = t_penerimaan_retensi_det.h AND 
			 ref_barang.i = t_penerimaan_retensi_det.i AND ref_barang.j = t_penerimaan_retensi_det.j) WHERE  (tgl_buku BETWEEN '$tgl_dari' AND '$tgl_sampai') AND t_penerimaan_retensi.sttemp ='0' $querySumber  AND t_penerimaan_retensi.c1='$c1' AND t_penerimaan_retensi.c='$c' AND t_penerimaan_retensi.d='$d' $querysE $querysE1";
		$aqry = mysql_query($qry);
		
		$tglMulai = date("d M Y", strtotime($dari));
		$tglSampai = date("d M Y", strtotime($sampai));
				
		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------ 
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo 
				"<html>
			<link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontFamily[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontMenubar[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$ContentFontStyle[option_value]'>
  		<link rel='stylesheet' type='text/css' href='js/pengadaanpenerimaan/PageNumber/pageNumber.css'>
  		<script type='text/javascript' src='assets/js/jquery-3.2.1.min.js'></script>
  		<script type='text/javascript' src='js/pengadaanpenerimaan/PageNumber/pageNumber.js'></script>
  		<script type='text/javascript' src='assets/js/bootstrap.min.js'></script>".
				"<head>
					<title>$Main->Judul</title>
					$css					
					$this->Cetak_OtherHTMLHead
					<style>
					
						
						.ukurantulisan {
						    font-size: 14px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
						thead{ 
						       display:table-header-group; 
						}

						@page { 
							    size: auto; 

							    margin: 1.5cm 1cm 1.4cm 0.5cm;  
							} 


							body  
							{ 
							   counter-reset: section;    
							    margin: 0px;  
							} 
					</style>
				</head>".
			"$body 
			<div style='width:100%;'>
			      <table class=\"rangkacetak\" style='width: 33cm; font-family: sans-serif; >
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
							<table style='width: 100%; border: none; margin-bottom: 0.5%;'>
							<tbody style='vertical-align: -webkit-baseline-middle;'>
								<tr>
								<td style='width: 10%;text-align:left;max-width: 130px;max-height: 80.59px;''>
										<img src='".getImageReport()."' style='max-width: 102.02px;max-height: 84.59px;'>
									</td>
									<td style='text-align:center;'>
										<span style='font-size:18px;font-weight:bold;text-decoration: '>".
								$this->JudulLaporan($tglMulai , $tglSampai, 'DAFTAR RETENSI PENGADAAN BARANG '.$Perolehans.'')."
										</span>
									</td>
									<td style='width: 10%; text-align:center;''>
										<img style='height: 10%;'>
									</td>
								</tr>
							</tbody>
							</table>"."
					<table width=\"100%\" border=\"0\" class='subjudulcetak' style='margin-top:15px;'>

				".$this->LaporanTmplSKPD($c1,$c,$d,$e,$e1)."
					
					
				</table>";
								
		//echo $qry;
		echo "
								<br>
								<table table width='100%' class='cetak' border='1' style='margin:-3px 0 0 0;width:100%;'>
								<thead>
									<tr>
										<th class='th01' rowspan='2'>NO</th>
										<th class='th02' rowspan='1' colspan='2'>KONTRAK / SPK</th>
										<th class='th01' rowspan='2' style='width: 25%;'>PENYEDIA BARANG</th>
										<th class='th01' rowspan='2' style='width: 31%;'>NAMA BARANG / NOMOR</th>
										<th class='th01' rowspan='2' style='width:12%'>JUMLAH HARGA (Rp)</th>
										<th class='th01' rowspan='2' style='width: 18%;'>KETERANGAN</th>
									</tr>
									<tr>
										<th class='th01' style='width:6%'>TANGGAL</th>
										<th class='th01' >NOMOR</th>
									</tr>
								</thead>

		";
		
	$pid = '';
		$no_cek = 0;
		$no = 0;
		$tot_hrg = 0;
		$tot_jumlah = 0;
		while($daqry = mysql_fetch_array($aqry)){
			if($pid != $daqry['Id'])$no_cek=0;
			
			$tgl_dokumen_sumber = explode("-",$daqry['tgl_dokumen_sumber']);
			$tgl_kontrak = explode("-",$daqry['tgl_kontrak']);
			if($pid != $daqry['Id']){
				if($daqry['cnt'] == 1){
					$dokumen = "KONTRAK<br>".$daqry['dokumen_sumber'];
					$no_dokumen = $daqry['nomor_kontrak']."<br>".$daqry['no_dokumen_sumber'];
					$tgl_dokumen = $tgl_kontrak[2]."-".$tgl_kontrak[1]."-".$tgl_kontrak[0]."<br>".$tgl_dokumen_sumber[2]."-".$tgl_dokumen_sumber[1]."-".$tgl_dokumen_sumber[0];
					$no_cek = 0;
				}else{
					$dokumen = "KONTRAK";
					$no_dokumen = $daqry['nomor_kontrak'];
					$tgl_dokumen = $tgl_kontrak[2]."-".$tgl_kontrak[1]."-".$tgl_kontrak[0];
				}				
			}else{
				if($no_cek == 1){
					$dokumen = $daqry['dokumen_sumber'];
					$no_dokumen = $daqry['no_dokumen_sumber'];
					$tgl_dokumen = $tgl_dokumen_sumber[2]."-".$tgl_dokumen_sumber[1]."-".$tgl_dokumen_sumber[0];
				}else{
					$dokumen='';
					$no_dokumen='';
					$tgl_dokumen='';
				}
				
			}
			$pid = $daqry['Id'];
			$dataSumber =  mysql_fetch_array(mysql_query("SELECT * from t_penerimaan_barang where Id = '$pid'"));
			// PENYEDIA
			$penyedia = $DataPengaturan->QyrTmpl1Brs('ref_penyedia', 'nama_penyedia', "WHERE id='".$daqry['refid_penyedia']."'");
			$nm_penyedia = $penyedia['hasil'];
			
			if ($this->idPenyedia != $daqry['refid_penyedia']) {
			  $dataPenyedia =  mysql_fetch_array(mysql_query("SELECT * from ref_penyedia WHERE id='".$daqry['refid_penyedia']."'"));
			  $no++;
			  $urutan=$no;
			  $tgl_kontrak = date("d M Y", strtotime($dataSumber['tgl_kontrak']));
			}else{
				$dataPenyedia =  "";
                                         $urutan="";
                                          $tgl_kontrak = "";
			}
			
			//TGL BUKU & NO BAST
			if($no_cek == 0){
				$tgl_buku_nya = explode("-", $daqry['tgl_buku']);
				$tgl_buku = $tgl_buku_nya[2]."-".$tgl_buku_nya[1]."-".$tgl_buku_nya[0];
				$no_bast = $daqry['no_dokumen_sumber']; 
				$id_penerimaan = $daqry['id_penerimaan']."<br>";
				$kontraks = $daqry['nomor_kontrak'];
			}else{
				$tgl_buku='';
				$no_bast='';
				$id_penerimaan='';
				$kontraks ="";
			}
			$tgl_buku = $dataSumber['tgl_buku'];
			$tgl_buku = explode('-', $tgl_buku);
			$month = $tgl_buku[0];
			$day   = $tgl_buku[1];
			$year  = $tgl_buku[2];
			
			
			echo "
					                                 <tr valign='top'>
									<td align='center' class='GarisCetak'>$urutan</td>
									<td align='center' class='GarisCetak' style='width:75px;'>".
									date( "d-m-Y", strtotime($daqry['tgl_kontrak']))."</td>
									<td class='GarisCetak'>".$daqry['nomor_kontrak']."</td>
									<td class='GarisCetak'>".$dataPenyedia['nama_penyedia']."</td>
									<td align='left' class='GarisCetak'> - ".$daqry['nm_barang']."</td>
									
									<td align='right' class='GarisCetak'>".number_format($daqry['harga_total'],2,',','.')."</td>
									<td class='GarisCetak'>".$daqry['keterangan']."</td>
								</tr>
			";
			$this->idPenyedia = $daqry['refid_penyedia'];
			$no_cek++;
			
			$tot_hrg = $tot_hrg+intval($daqry['harga_total']);
			$tot_jumlah = $tot_jumlah+intval($daqry['jml']);
		}
			echo "<tr>
				<td align='right' class='GarisCetak' colspan='5'><b>TOTAL</b></td>
				
				<td align='right' class='GarisCetak' colspan='1'><b>".number_format($tot_hrg,2,',','.')."</b></td>
				<td align='center' class='GarisCetak' colspan='1' ></td>
									</tr>
								</table>";	
		echo  $this->TandaTanganFooter($c1,$c,$d,$e,$e1).
		  "<footer>
				<h5 class='pag pag1' style='bottom:-10px; font-size: 9px;'>
				   <span style='bottom: 0px; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
			            </h5>
		                <div class='insert'></div>
		    </footer>

			</body>	
		</html>";
	}

	function LaporanRetensiBelanjaBarangProgkeg($xls =FALSE){
		global $Main, $DataPengaturan,$HTTP_COOKIE_VARS, $DataOption;
		
		$nama_laporan = $_REQUEST['nama_laporan'];
		$tgl_cetak = date('m-d-Y');
		$dari = $_REQUEST['dari'];
		$dari_tgl = explode("-",$_REQUEST['dari']);
		$sampai = $_REQUEST['sampai'];
		$sampai_tgl = explode("-",$_REQUEST['sampai']);
		$perolehan = $_REQUEST['perolehan'];
		if ($perolehan == 1) {
			$namaPerolehan = "PEMBELIAN";
		}elseif ($perolehan == 2) {
			$namaPerolehan = "HIBAH";
		}elseif ($perolehan == 3) {
			$namaPerolehan = "LAINNYA";
		}else{
			$namaPerolehan = " ";
		}


		

		$tgl_dari = $dari_tgl[2]."-".$dari_tgl[1]."-".$dari_tgl[0];
		$tgl_sampai = $sampai_tgl[2]."-".$sampai_tgl[1]."-".$sampai_tgl[0];
		$namauid = $_COOKIE['coNama'];
		$c1 = $_REQUEST['c1nya'];
		$c = $_REQUEST['cnya'];
		$d = $_REQUEST['dnya'];
		$e = $_REQUEST['enya'];
		$e1 = $_REQUEST['e1nya'];
		
		$whereskpd = '';
		if($DataOption["skpd"] == 1){
			$whereskpd .= "aa.c1='$c1' AND";
		}else{
			if($c1!='0'){
				$whereskpd .= "aa.c1='$c1' AND";
			}
		}		
		if($c != "00")$whereskpd.= " aa.c='$c'";
		if($d != '00')$whereskpd.=" AND aa.d='$d'";
		if($e != '00')$whereskpd.=" AND aa.e='$e'";
		if($e1 != '000')$whereskpd.=" AND aa.e1='$e1'";
		
		if($whereskpd != '')$whereskpd.=" AND ";
		
		
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		
		$daqry_pengaturan = $DataOption;
		
				if ($e == "00") {
		   $querysE = "";
		}else{
			$querysE = "AND t_penerimaan_retensi.e='$e'";
		}


	     if ($e1 == "000") {
		   $querysE1 = "";
		}else{
			$querysE1 = "AND t_penerimaan_retensi.e1='$e1'";
		}


		/*$qry = "SELECT tpb.*, hit.cnt FROM (SELECT aa.Id, aa.tgl_buku, aa.no_dokumen_sumber, aa.tgl_dokumen_sumber, aa.dokumen_sumber, aa.refid_penyedia, aa.nomor_kontrak, aa.tgl_kontrak, aa.id_penerimaan, bb.nm_barang, bb.ket_barang, bb.jml, bb.harga_satuan, bb.harga_total, bb.keterangan FROM ".$this->TblName." aa RIGHT JOIN ".$DataPengaturan->VPenerima_det()." bb ON aa.Id=bb.refid_terima WHERE $whereskpd AND aa.sttemp='0' AND bb.sttemp='0' AND aa.tgl_dokumen_sumber >= '$tgl_dari' AND aa.tgl_dokumen_sumber <= '$tgl_sampai' AND aa.jns_trans='1' GROUP BY bb.Id) tpb
LEFT JOIN (SELECT refid_terima, COUNT(Id) as cnt FROM ".$DataPengaturan->VPenerima_det()." GROUP BY refid_terima) hit ON tpb.Id=hit.refid_terima ";*/
	$qry = "SELECT  t_penerimaan_retensi.q,t_penerimaan_retensi.p,t_penerimaan_retensi.bk,t_penerimaan_retensi.ck,t_penerimaan_retensi.dk,t_penerimaan_retensi.refid_penyedia,t_penerimaan_retensi.nomor_kontrak,t_penerimaan_retensi.tgl_kontrak, t_penerimaan_retensi.Id , t_penerimaan_retensi_det.refid_retensi,ref_barang.nm_barang,t_penerimaan_retensi_det.harga_total,t_penerimaan_retensi_det.keterangan,t_penerimaan_retensi.tgl_dokumen_sumber,t_penerimaan_retensi.dokumen_sumber
			FROM ((t_penerimaan_retensi
			INNER JOIN t_penerimaan_retensi_det ON t_penerimaan_retensi.Id = t_penerimaan_retensi_det.refid_retensi)
			INNER JOIN ref_barang ON ref_barang.f1 = t_penerimaan_retensi_det.f1 AND ref_barang.f2 = t_penerimaan_retensi_det.f2 AND 
			ref_barang.f = t_penerimaan_retensi_det.f AND ref_barang.g = t_penerimaan_retensi_det.g AND  ref_barang.h = t_penerimaan_retensi_det.h AND 
			 ref_barang.i = t_penerimaan_retensi_det.i AND ref_barang.j = t_penerimaan_retensi_det.j) WHERE  (tgl_buku BETWEEN '$tgl_dari' AND '$tgl_sampai') AND t_penerimaan_retensi.sttemp ='0' $querySumber  AND t_penerimaan_retensi.c1='$c1' AND t_penerimaan_retensi.c='$c' AND t_penerimaan_retensi.d='$d' $querysE $querysE1";
		$aqry = mysql_query($qry);
		
		$tglMulai = date("d M Y", strtotime($dari));
		$tglSampai = date("d M Y", strtotime($sampai));
				
		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------ 
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo 
				"<html>
			<link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontFamily[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontMenubar[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$ContentFontStyle[option_value]'>
  		<link rel='stylesheet' type='text/css' href='js/pengadaanpenerimaan/PageNumber/pageNumber.css'>
  		<script type='text/javascript' src='assets/js/jquery-3.2.1.min.js'></script>
  		<script type='text/javascript' src='js/pengadaanpenerimaan/PageNumber/pageNumber.js'></script>
  		<script type='text/javascript' src='assets/js/bootstrap.min.js'></script>".
				"<head>
					<title>$Main->Judul</title>
					$css					
					$this->Cetak_OtherHTMLHead
					<style>
					
						
						.ukurantulisan {
						    font-size: 14px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
						thead{ 
						       display:table-header-group; 
						}

						@page { 
							    size: auto; 

							    margin: 1.5cm 1cm 0.5cm 1.5cm;  
							} 


							body  
							{ 
							   counter-reset: section;    
							    margin: 0px;  
							} 
					</style>
				</head>".
			"$body 
	<div style='width:28.6cm;'>
			      <table class=\"rangkacetak\" style='width:100%; font-family: sans-serif; '>

						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
							<table style='width: 100%; border: none; margin-bottom: 0.5%;'>
							<tbody style='vertical-align: -webkit-baseline-middle;'>
								<tr>
								<td style='width: 10%;text-align:left;max-width: 130px;max-height: 80.59px;''>
										<img src='".getImageReport()."' style='max-width: 102.02px;max-height: 84.59px;'>
									</td>
									<td style='text-align:center;'>
										<span style='font-size:18px;font-weight:bold;text-decoration: '>".
								$this->JudulLaporan($tglMulai , $tglSampai, "DAFTAR RETENSI BELANJA BARANG
									<br>
								 <span style='font-size:18px;font-weight:bold;text-decoration: '>BERDASARKAN PROGRAM & KEGIATAN
								 <br>
								 CARA PEROLEHAN PEMBELIAN
										</span>")."
										</span>
										<br>

									</td>
									<td style='width: 10%; text-align:center;''>
										<img  style='height: 10%;'>
									</td>
								</tr>
								</tbody>
							</table>"."
					<table width=\"100%\" border=\"0\" class='subjudulcetak' style='margin-top:15px;'>

				".$this->LaporanTmplSKPD($c1,$c,$d,$e,$e1)."
					
					
				</table>";
								
		//echo $qry;
		echo "
								<br>
								<table table width='100%' class='cetak' border='1' style='margin:-3px 0 0 0;width:100%;'>
																<thead>
									<tr>
										<th class='th01' rowspan='2'>NO</th>
					   				   <th class='th01' colspan='2'>URAIAN </th>
										<th class='th01' rowspan='2' style='width:15%'>JUMLAH  (Rp)</th>
									</tr>
					
								</thead>

		";
		
	$pid = '';
		$no_cek = 0;
		$no = 0;
		$tot_hrg = 0;
		$tot_jumlah = 0;
		$sub_hrg = 0;
		$sub_jumlah = 0;
		$variableAnyarJangnomor = 1;
		$jlmhData = mysql_num_rows($aqry);
		while($daqry = mysql_fetch_array($aqry)){
                                    
                                    
			if($pid != $daqry['Id'])$no_cek=0;
			
			$tgl_dokumen_sumber = explode("-",$daqry['tgl_dokumen_sumber']);
			$tgl_kontrak = explode("-",$daqry['tgl_kontrak']);
			if($pid != $daqry['Id']){
				if($daqry['cnt'] == 1){
					$dokumen = "KONTRAK<br>".$daqry['dokumen_sumber'];
					$no_dokumen = $daqry['nomor_kontrak']."<br>".$daqry['no_dokumen_sumber'];
					$tgl_dokumen = $tgl_kontrak[2]."-".$tgl_kontrak[1]."-".$tgl_kontrak[0]."<br>".$tgl_dokumen_sumber[2]."-".$tgl_dokumen_sumber[1]."-".$tgl_dokumen_sumber[0];
					$no_cek = 0;
				}else{
					$dokumen = "KONTRAK";
					$no_dokumen = $daqry['nomor_kontrak'];
					$tgl_dokumen = $tgl_kontrak[2]."-".$tgl_kontrak[1]."-".$tgl_kontrak[0];
				}				
			}else{
				if($no_cek == 1){
					$dokumen = $daqry['dokumen_sumber'];
					$no_dokumen = $daqry['no_dokumen_sumber'];
					$tgl_dokumen = $tgl_dokumen_sumber[2]."-".$tgl_dokumen_sumber[1]."-".$tgl_dokumen_sumber[0];
				}else{
					$dokumen='';
					$no_dokumen='';
					$tgl_dokumen='';
				}
				
			}
			$dataProgram =  mysql_fetch_array(mysql_query("SELECT * from ref_program where q = '0' AND p = '$daqry[p]' AND dk = '$daqry[dk]'  AND ck = '$daqry[ck]'  AND  bk = '$daqry[bk]'"));
			$dataKegiatan =  mysql_fetch_array(mysql_query("SELECT * from ref_program where q = '$daqry[q]' AND p = '$daqry[p]' AND dk = '$daqry[dk]'  AND ck = '$daqry[ck]'  AND  bk = '$daqry[bk]'"));

			

			$pid = $daqry['Id'];
			$dataSumber =  mysql_fetch_array(mysql_query("SELECT * from t_penerimaan_retensi where Id = '$pid'"));
			// PENYEDIA
			$penyedia = $DataPengaturan->QyrTmpl1Brs('ref_penyedia', 'nama_penyedia', "WHERE id='".$daqry['refid_penyedia']."'");
			$nm_penyedia = $penyedia['hasil'];
			//TGL BUKU & NO BAST
			if($no_cek == 0){
				$tgl_buku_nya = explode("-", $daqry['tgl_buku']);
				$tgl_buku = $tgl_buku_nya[2]."-".$tgl_buku_nya[1]."-".$tgl_buku_nya[0];
				$no_bast = $daqry['no_dokumen_sumber']; 
				$id_penerimaan = $daqry['id_penerimaan']."<br>";
			}else{
				$tgl_buku='';
				$no_bast='';
				$id_penerimaan='';
			}


			$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$daqry['bk'].".".$daqry['ck'].".".$daqry['dk'].".".$daqry['p'].".".$daqry['q'];
			$dataBarangs = mysql_fetch_array(mysql_query("SELECT * from t_penerimaan_retensi_det where refid_terima = '".$daqry['Id']."'"));

			$subTotalJumlah += $lastJumlah;
			$subTotalHarga += $lastHarga;
			if ($this->idPenyedia !=  $concat) {
			  $dataProgram =  mysql_fetch_array(mysql_query("SELECT * from ref_program where q = '0' AND p = '$daqry[p]' AND dk = '$daqry[dk]'  AND ck = '$daqry[ck]'  AND  bk = '$daqry[bk]'"));
			$dataKegiatan =  mysql_fetch_array(mysql_query("SELECT * from ref_program where q = '$daqry[q]' AND p = '$daqry[p]' AND dk = '$daqry[dk]'  AND ck = '$daqry[ck]'  AND  bk = '$daqry[bk]'"));
                                     $br = "<br>";
			 $no++;
			 $urutan=$no;
                                    
   //                                  $sub_hrg = $sub_hrg + $daqry['harga_total'];
			// $sub_jumlah = $sub_jumlah + $daqry['jml'];
			$subtotal = "<tr>

				<td align='center' class='GarisCetak' colspan='1'><b></b></td>
				<td align='right' class='GarisCetak' colspan='2'><b>SUBTOTAL</b></td>
				<td align='right' class='GarisCetak' colspan='1'><b>".number_format($subTotalHarga,0,',','.')."</b></td>
				
									</tr>";
			$programKegiatan = "<tr valign='top'>
									<td align='center' class='GarisCetak'>$urutan</td>
									<td class='GarisCetak' colspan='2'><span style='margin-left:6px'>PROGRAM ".$dataProgram['nama']."</span><br><span style='margin-left:24px'>KEGIATAN ".$dataKegiatan['nama']."</span></td>
									<td align='center' colspan='1' class='GarisCetak'></td>
			         </tr>";
				$subTotalJumlah = 0;
				$subTotalHarga = 0;
			}else{
				$dataProgram =  "";
				$dataKegiatan = "";      
		                        $urutan="";
                                                  $subtotal = "";
                                                  $br = "";
                                                  $programKegiatan ="";
			}

			$dataBarang = mysql_fetch_array(mysql_query("SELECT * from t_penerimaan_retensi_det where refid_terima = '".$daqry['Id']."'"));
			$dataBarangR = mysql_fetch_array(mysql_query("SELECT * from t_penerimaan_rekening where refid_terima = '".$daqry['Id']."'"));
                                    
                                    $namaRekening = mysql_fetch_array(mysql_query("SELECT * from ref_rekening  where k = '$dataBarangR[k]' AND l = '$dataBarangR[l]' AND m = '$dataBarangR[m]' AND n = '$dataBarangR[n]' AND o = '$dataBarangR[o]'"));

                                    $kodebarang = ".$dataBarang ['f'].".".$dataBarang ['g'].".".$dataBarang ['h'].".".$dataBarang ['i'].".".$dataBarang ['j'].";

			$tgl_buku = $dataSumber['tgl_buku'];
			$tgl_buku = explode('-', $tgl_buku);
			$month = $tgl_buku[0];
			$day   = $tgl_buku[1];
			$year  = $tgl_buku[2];
			$tgl_bukus = date("d M Y", strtotime($dataSumber['tgl_buku']));
			if ($no == 1) {
				$subtotal="";
			}
			if ($variableAnyarJangnomor == $jlmhData ) {
				$lol = $this->BacaTotal($c1,$c,$d,$e,$e1,$daqry['bk'],$daqry['ck'],$daqry['dk'],$daqry['p'],$daqry['q'],$qry);
				$subtotalAkhir = "<tr>

				<td align='center' class='GarisCetak' colspan='1'><b></b></td>
				<td align='right' class='GarisCetak' colspan='2'><b>SUBTOTAL</b></td>
					<td align='right' class='GarisCetak' colspan='1'><b>".number_format($lol[1],0,',','.')."</b></td>
				
									</tr>";
			}
			echo "  $subtotal
			            $programKegiatan
					                                 <tr valign='top'>
									<td align='center' class='GarisCetak' style='border-top:hidden;'> </td>
									<td class='GarisCetak' colspan='2' style='border-top:hidden;'><b><span style='margin-left:5%; '>".$dataBarangR['k'].".".$dataBarangR['l'].".".$dataBarangR['m'].".".$dataBarangR['n'].".".$dataBarangR['o']."</span>
									</b>  <span>".$namaRekening['nm_rekening']."<span></td>
									<td align='right' class='GarisCetak' style='border-top:hidden;'>".$br.number_format($daqry['harga_total'],0,'.',',')."</td>
								</tr>
							$subtotalAkhir
			";
			$no_cek++;
			$variableAnyarJangnomor++;
			$this->idPenyedia =  $concat;
			$tot_hrg = $tot_hrg+intval($daqry['harga_total']);
			$tot_jumlah = $tot_jumlah+intval($daqry['jml']);
			$lastJumlah = $daqry['jml'];
			$lastHarga = $daqry['harga_total'];
		}
			echo "<tr>
			<td align='center' class='GarisCetak'  colspan='2' style='border-right:hidden;'><b></b></td>
				<td align='right' class='GarisCetak' colspan='1'><b>GRAND TOTAL</b></td>
				<td align='right' class='GarisCetak' colspan='1'><b>".number_format($tot_hrg,2,',','.')."</b></td>
				
									</tr>
								</table>";	
		echo  $this->TandaTanganFooterP($c1,$c,$d,$e,$e1).
		  "<footer>
				<h5 class='pag pag1' style='bottom:-10px; font-size: 9px;'>
				   <span style='bottom: 0px; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
			            </h5>
		                <div class='insert'></div>
		    </footer>

			</body>	
		</html>";
	}

		function LaporanRetensiPenerimaanBarangProgkeg($xls =FALSE){
		global $Main, $DataPengaturan,$HTTP_COOKIE_VARS, $DataOption;
		
		$nama_laporan = $_REQUEST['nama_laporan'];
		$tgl_cetak = date('m-d-Y');
		$dari = $_REQUEST['dari'];
		$dari_tgl = explode("-",$_REQUEST['dari']);
		$sampai = $_REQUEST['sampai'];
		$sampai_tgl = explode("-",$_REQUEST['sampai']);
		
		$tgl_dari = $dari_tgl[2]."-".$dari_tgl[1]."-".$dari_tgl[0];
		$tgl_sampai = $sampai_tgl[2]."-".$sampai_tgl[1]."-".$sampai_tgl[0];
		$namauid = $_COOKIE['coNama'];
		$c1 = $_REQUEST['c1nya'];
		$c = $_REQUEST['cnya'];
		$d = $_REQUEST['dnya'];
		$e = $_REQUEST['enya'];
		$e1 = $_REQUEST['e1nya'];
		
		$whereskpd = '';
		if($DataOption["skpd"] == 1){
			$whereskpd .= "aa.c1='$c1' AND";
		}else{
			if($c1!='0'){
				$whereskpd .= "aa.c1='$c1' AND";
			}
		}		
		if($c != "00")$whereskpd.= " aa.c='$c'";
		if($d != '00')$whereskpd.=" AND aa.d='$d'";
		if($e != '00')$whereskpd.=" AND aa.e='$e'";
		if($e1 != '000')$whereskpd.=" AND aa.e1='$e1'";
		
		if($whereskpd != '')$whereskpd.=" AND ";
		
		
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		
		$daqry_pengaturan = $DataOption;
		
				if ($e == "00") {
		   $querysE = "";
		}else{
			$querysE = "AND t_penerimaan_retensi.e='$e'";
		}


	     if ($e1 == "000") {
		   $querysE1 = "";
		}else{
			$querysE1 = "AND t_penerimaan_retensi.e1='$e1'";
		}


		/*$qry = "SELECT tpb.*, hit.cnt FROM (SELECT aa.Id, aa.tgl_buku, aa.no_dokumen_sumber, aa.tgl_dokumen_sumber, aa.dokumen_sumber, aa.refid_penyedia, aa.nomor_kontrak, aa.tgl_kontrak, aa.id_penerimaan, bb.nm_barang, bb.ket_barang, bb.jml, bb.harga_satuan, bb.harga_total, bb.keterangan FROM ".$this->TblName." aa RIGHT JOIN ".$DataPengaturan->VPenerima_det()." bb ON aa.Id=bb.refid_terima WHERE $whereskpd AND aa.sttemp='0' AND bb.sttemp='0' AND aa.tgl_dokumen_sumber >= '$tgl_dari' AND aa.tgl_dokumen_sumber <= '$tgl_sampai' AND aa.jns_trans='1' GROUP BY bb.Id) tpb
LEFT JOIN (SELECT refid_terima, COUNT(Id) as cnt FROM ".$DataPengaturan->VPenerima_det()." GROUP BY refid_terima) hit ON tpb.Id=hit.refid_terima ";*/
		$qry = "SELECT  t_penerimaan_retensi_det.f, t_penerimaan_retensi_det.g, t_penerimaan_retensi_det.h,t_penerimaan_retensi_det.i,t_penerimaan_retensi_det.j,t_penerimaan_retensi.q,t_penerimaan_retensi.p,t_penerimaan_retensi.bk,t_penerimaan_retensi.ck,t_penerimaan_retensi.dk,t_penerimaan_retensi.refid_penyedia,t_penerimaan_retensi.nomor_kontrak,t_penerimaan_retensi.tgl_kontrak, t_penerimaan_retensi.Id , t_penerimaan_retensi_det.refid_retensi,ref_barang.nm_barang,t_penerimaan_retensi_det.harga_total,t_penerimaan_retensi_det.keterangan,t_penerimaan_retensi.tgl_dokumen_sumber,t_penerimaan_retensi.dokumen_sumber
			FROM ((t_penerimaan_retensi
			INNER JOIN t_penerimaan_retensi_det ON t_penerimaan_retensi.Id = t_penerimaan_retensi_det.refid_retensi)
			INNER JOIN ref_barang ON ref_barang.f1 = t_penerimaan_retensi_det.f1 AND ref_barang.f2 = t_penerimaan_retensi_det.f2 AND 
			ref_barang.f = t_penerimaan_retensi_det.f AND ref_barang.g = t_penerimaan_retensi_det.g AND  ref_barang.h = t_penerimaan_retensi_det.h AND 
			 ref_barang.i = t_penerimaan_retensi_det.i AND ref_barang.j = t_penerimaan_retensi_det.j) WHERE  (tgl_buku BETWEEN '$tgl_dari' AND '$tgl_sampai') AND t_penerimaan_retensi.sttemp ='0' $querySumber  AND t_penerimaan_retensi.c1='$c1' AND t_penerimaan_retensi.c='$c' AND t_penerimaan_retensi.d='$d' $querysE $querysE1";
			   $dataProgram =  mysql_fetch_array(mysql_query("SELECT * from ref_program where q = '0' AND p = '$daqry[p]' AND dk = '$daqry[dk]'  AND ck = '$daqry[ck]'  AND  bk = '$daqry[bk]'"));
			$dataKegiatan =  mysql_fetch_array(mysql_query("SELECT * from ref_program where q = '$daqry[q]' AND p = '$daqry[p]' AND dk = '$daqry[dk]'  AND ck = '$daqry[ck]'  AND  bk = '$daqry[bk]'"));
		$aqry = mysql_query($qry);
		$tglMulai = date("d M Y", strtotime($dari));
		$tglSampai = date("d M Y", strtotime($sampai));


				
		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------ 
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo 
				"<html>
			<link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontFamily[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontMenubar[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$ContentFontStyle[option_value]'>
  		<link rel='stylesheet' type='text/css' href='js/pengadaanpenerimaan/PageNumber/pageNumber.css'>
  		<script type='text/javascript' src='assets/js/jquery-3.2.1.min.js'></script>
  		<script type='text/javascript' src='js/pengadaanpenerimaan/PageNumber/pageNumber.js'></script>
  		<script type='text/javascript' src='assets/js/bootstrap.min.js'></script>".
				"<head>
					<title>$Main->Judul</title>
					$css					
					$this->Cetak_OtherHTMLHead
					<style>
					
						
						.ukurantulisan {
						    font-size: 14px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
						thead{ 
						       display:table-header-group; 
						}

						@page { 
							    size: auto; 

							    margin: 1.5cm 1cm 0.5cm 1.5cm;  
							} 


							body  
							{ 
							   counter-reset: section;    
							    margin: 0px;  
							} 
					</style>
				</head>".
			"$body 
	<div style='width:28.6cm;'>
			      <table class=\"rangkacetak\" style='width:100%; font-family: sans-serif; '>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
							<table style='width: 100%; border: none; margin-bottom: 0.5%;'>
							<tbody style='vertical-align: -webkit-baseline-middle;'>
								<tr>
								<td style='width: 10%;text-align:left;max-width: 130px;max-height: 80.59px;''>
										<img src='".getImageReport()."' style='max-width: 102.02px;max-height: 84.59px;'>
									</td>
									<td style='text-align:center;'>
										<span style='font-size:18px;font-weight:bold;text-decoration: '>".
								$this->JudulLaporan($tglMulai , $tglSampai, "DAFTAR RETENSI PENERIMAAN BARANG<br>
								 <span style='font-size:18px;font-weight:bold;text-decoration: '>BERDASARKAN PROGRAM & KEGIATAN
								 <br>	CARA PEROLEHAN PEMBELIAN
										</span>")."
										</span>
									</td>
									<td style='width: 10%; text-align:center;''>
										<img style='height: 10%;'>
									</td>
								</tr>
								</tbody>
							</table>"."
					<table width=\"100%\" border=\"0\" class='subjudulcetak' style='margin-top:15px;'>

				".$this->LaporanTmplSKPD($c1,$c,$d,$e,$e1)."
					
					
				</table>";
								
		//echo $qry;
		echo "
								<br>
								<table table width='100%' class='cetak' border='1' style='margin:-3px 0 0 0;width:100%;'>
								
								<thead>
									<tr>
										<th class='th01' rowspan='2'>NO</th>
					   				   <th class='th01' colspan='2'>URAIAN </th>
										<th class='th01' rowspan='2' style='width:15%'>JUMLAH (Rp)</th>
									</tr>
					
								</thead>

		";
		
	$pid = '';
		$no_cek = 0;
		$no = 0;
		$tot_hrg = 0;
		$tot_jumlah = 0;
		$sub_hrg = 0;
		$sub_jumlah = 0;
		$variableAnyarJangnomor = 1;
		$jlmhData = mysql_num_rows($aqry);
		while($daqry = mysql_fetch_array($aqry)){
                                    
                                    
			if($pid != $daqry['Id'])$no_cek=0;
			
			$tgl_dokumen_sumber = explode("-",$daqry['tgl_dokumen_sumber']);
			$tgl_kontrak = explode("-",$daqry['tgl_kontrak']);
			if($pid != $daqry['Id']){
				if($daqry['cnt'] == 1){
					$dokumen = "KONTRAK<br>".$daqry['dokumen_sumber'];
					$no_dokumen = $daqry['nomor_kontrak']."<br>".$daqry['no_dokumen_sumber'];
					$tgl_dokumen = $tgl_kontrak[2]."-".$tgl_kontrak[1]."-".$tgl_kontrak[0]."<br>".$tgl_dokumen_sumber[2]."-".$tgl_dokumen_sumber[1]."-".$tgl_dokumen_sumber[0];
					$no_cek = 0;
				}else{
					$dokumen = "KONTRAK";
					$no_dokumen = $daqry['nomor_kontrak'];
					$tgl_dokumen = $tgl_kontrak[2]."-".$tgl_kontrak[1]."-".$tgl_kontrak[0];
				}				
			}else{
				if($no_cek == 1){
					$dokumen = $daqry['dokumen_sumber'];
					$no_dokumen = $daqry['no_dokumen_sumber'];
					$tgl_dokumen = $tgl_dokumen_sumber[2]."-".$tgl_dokumen_sumber[1]."-".$tgl_dokumen_sumber[0];
				}else{
					$dokumen='';
					$no_dokumen='';
					$tgl_dokumen='';
				}
				
			}
			$dataProgram =  mysql_fetch_array(mysql_query("SELECT * from ref_program where q = '0' AND p = '$daqry[p]' AND dk = '$daqry[dk]'  AND ck = '$daqry[ck]'  AND  bk = '$daqry[bk]'"));
			$dataKegiatan =  mysql_fetch_array(mysql_query("SELECT * from ref_program where q = '$daqry[q]' AND p = '$daqry[p]' AND dk = '$daqry[dk]'  AND ck = '$daqry[ck]'  AND  bk = '$daqry[bk]'"));

			

			$pid = $daqry['Id'];
			$dataSumber =  mysql_fetch_array(mysql_query("SELECT * from t_penerimaan_retensi where Id = '$pid'"));
			// PENYEDIA
			$penyedia = $DataPengaturan->QyrTmpl1Brs('ref_penyedia', 'nama_penyedia', "WHERE id='".$daqry['refid_penyedia']."'");
			$nm_penyedia = $penyedia['hasil'];
			//TGL BUKU & NO BAST
			if($no_cek == 0){
				$tgl_buku_nya = explode("-", $daqry['tgl_buku']);
				$tgl_buku = $tgl_buku_nya[2]."-".$tgl_buku_nya[1]."-".$tgl_buku_nya[0];
				$no_bast = $daqry['no_dokumen_sumber']; 
				$id_penerimaan = $daqry['id_penerimaan']."<br>";
			}else{
				$tgl_buku='';
				$no_bast='';
				$id_penerimaan='';
			}


			$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$daqry['bk'].".".$daqry['ck'].".".$daqry['dk'].".".$daqry['p'].".".$daqry['q'];
			$dataBarangs = mysql_fetch_array(mysql_query("SELECT * from t_penerimaan_retensi_det where refid_terima = '".$daqry['Id']."'"));

			$subTotalJumlah += $lastJumlah;
			$subTotalHarga += $lastHarga;
			if ($this->idPenyedia !=  $concat) {
			  $dataProgram =  mysql_fetch_array(mysql_query("SELECT * from ref_program where q = '0' AND p = '$daqry[p]' AND dk = '$daqry[dk]'  AND ck = '$daqry[ck]'  AND  bk = '$daqry[bk]'"));
			$dataKegiatan =  mysql_fetch_array(mysql_query("SELECT * from ref_program where q = '$daqry[q]' AND p = '$daqry[p]' AND dk = '$daqry[dk]'  AND ck = '$daqry[ck]'  AND  bk = '$daqry[bk]'"));
                                     $br = "";
			 $no++;
			 $urutan=$no;
                                    
   //                                  $sub_hrg = $sub_hrg + $daqry['harga_total'];
			// $sub_jumlah = $sub_jumlah + $daqry['jml'];
			$subtotal = "<tr>

				<td align='center' class='GarisCetak' colspan='1'><b></b></td>
				<td align='right' class='GarisCetak' colspan='2'><b>SUBTOTAL</b></td>
				
				<td align='right' class='GarisCetak' colspan='1'><b>".number_format($subTotalHarga,2,',','.')."</b></td>
				
									</tr>";
			$programKegiatan = "<tr valign='top'>
									<td align='center' class='GarisCetak'>$urutan</td>
									<td class='GarisCetak' colspan='2'><span style='margin-left:6px'>PROGRAM ".$dataProgram['nama']."</span><br><span style='margin-left:24px'>KEGIATAN ".$dataKegiatan['nama']."</span></td>
									<td align='center' class='GarisCetak' colspan='1'></td>
			         </tr>";
				$subTotalJumlah = 0;
				$subTotalHarga = 0;
			}else{
				$dataProgram =  "";
				$dataKegiatan = "";      
		                        $urutan="";
                                                  $subtotal = "";
                                                  $br = "";
                                                  $programKegiatan ="";
			}

			$dataBarang = mysql_fetch_array(mysql_query("SELECT * from t_penerimaan_retensi_det where refid_terima = '".$daqry['Id']."'"));
                                    

                                    $kodebarang = ".$dataBarang ['f'].".".$dataBarang ['g'].".".$dataBarang ['h'].".".$dataBarang ['i'].".".$dataBarang ['j'].";

			$tgl_buku = $dataSumber['tgl_buku'];
			$tgl_buku = explode('-', $tgl_buku);
			$month = $tgl_buku[0];
			$day   = $tgl_buku[1];
			$year  = $tgl_buku[2];
			$tgl_bukus = date("d M Y", strtotime($dataSumber['tgl_buku']));
			if ($no == 1) {
				$subtotal="";
			}
			if ($variableAnyarJangnomor == $jlmhData ) {
				$lol = $this->BacaTotal($c1,$c,$d,$e,$e1,$daqry['bk'],$daqry['ck'],$daqry['dk'],$daqry['p'],$daqry['q'],$qry);
				$subtotalAkhir = "<tr>

				<td align='center' class='GarisCetak' colspan='1'><b></b></td>
				<td align='right' class='GarisCetak' colspan='2'><b>SUBTOTAL</b></td>
				
				<td align='right' class='GarisCetak' colspan='1'><b>".number_format($lol[1],2,',','.')."</b></td>
				
									</tr>";
			}
			echo "  $subtotal
			            $programKegiatan
					                                 <tr valign='top'>
									<td align='center' class='GarisCetak' style='border-top:hidden;'> </td>
									<td class='GarisCetak' colspan=2' style='border-top:hidden;'><b><span style='margin-left:5%; '>".$daqry ['f'].".".$daqry ['g'].".".$daqry ['h'].".".$daqry ['i'].".".$daqry ['j']."</span>
									</b>  <span>".$daqry['nm_barang']."<span></td>
									
									<td align='right' class='GarisCetak' style='border-top:hidden;'>".$br.number_format($daqry['harga_total'],2,',','.')."</td>
								</tr>
							$subtotalAkhir
			";
			$no_cek++;
			$variableAnyarJangnomor++;
			$this->idPenyedia =  $concat;
			$tot_hrg = $tot_hrg+intval($daqry['harga_total']);
			$tot_jumlah = $tot_jumlah+intval($daqry['jml']);
			$lastJumlah = $daqry['jml'];
			$lastHarga = $daqry['harga_total'];
		}
			echo "<tr>
			<td align='center' class='GarisCetak'  colspan='2' style='border-right:hidden;'><b></b></td>
				<td align='right' class='GarisCetak' colspan='1'><b>GRAND TOTAL</b></td>
				
				<td align='right' class='GarisCetak' colspan='1'><b>".number_format($tot_hrg,2,',','.')."</b></td>
				
									</tr>
								</table>";	
		echo  $this->TandaTanganFooter($c1,$c,$d,$e,$e1).
		  "<footer>
				<h5 class='pag pag1' style='bottom:-10px; font-size: 9px;'>
				   <span style='bottom: 0px; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
			            </h5>
		                <div class='insert'></div>
		    </footer>

			</body>	
		</html>";
	}

	function setFormBaru(){
		global $DataOption;
		$err="";$content="";$cek=''; 
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek = $cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$dt=array();
		$this->form_fmST = 0;
		
		$c1 = cekPOST("c1nya");
		$c = cekPOST("cnya");
		$d = cekPOST("dnya");
		$e = cekPOST("enya");
		$e1 = cekPOST("e1nya");
		$jns_transaksi = cekPOST("jns_transaksi");
		
		if($err == ""){
			$dt["c1"] = $c1;
			$dt["c"] = $c;
			$dt["d"] = $d;
			$dt["e"] = $e;
			$dt["e1"] = $e1;
			$dt['ket_kuantitas']='KALI';
				
			$dt['jns_transaksi'] = cekPOST("jns_transaksi");	
			$dt['refid_templatebarang']=cekPOST("IdPilih");
			
			$fm = $this->setForm($dt);
			$cek.=$fm['cek'];
			$err=$fm['err'];
			$content=$fm['content'];
		}
		
			
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
  	function setFormEdit(){
		global $DataOption;
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = $cbid[0];
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT rtd.*, rb.nm_barang FROM  pemasukan_retensi_baru rtd LEFT JOIN ref_barang rb ON (rtd.f1=rb.f1 AND rtd.f2=rb.f2 AND rtd.f=rb.f AND rtd.g=rb.g AND rtd.h=rb.h AND rtd.i=rb.i AND rtd.j=rb.j) WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$dt['jns_transaksi'] = cekPOST("jns_transaksi");
		$dt['kodebarangnya'] = $dt["f"].".".$dt["g"].".".$dt["h"].".".$dt["i"].".".$dt["j"];
		if($DataOption["kode_barang"] == "2")$dt['kodebarangnya']= $dt["f1"].".".$dt["f2"].".".$dt['kodebarangnya'];
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp ,$Main,$DataPengaturan;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 800;
	 $this->form_height = 320;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'FORM BARU TEMPLATE BARANG DETAIL';
	  }else{
		$this->form_caption = 'FORM UBAH TEMPLATE BARANG DETAIL';			
		$readonly='readonly';
					
	  }
	  $checDistri = "";
	  if($dt['barangdistribusi'] == "1")$checDistri=" checked";
	  
	  if($dt['jns_transaksi'] == 2){
	  		$volume = $dt['jml'] * $dt['kuantitas'];
			
	  		$ket_barang = "URAIAN PEMELIHARAAN";
			$kuantitas = array(
							'label'=>"KUANTITAS",
							'labelWidth'=>200,
							'value'=>
								"<input type='text' name='kuantitas' value='".floatval($dt['kuantitas'])."' id='kuantitas2' style='width:75px;text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='pemasukan_ins.hitungjumlahHarga(`2`);' onkeyup='pemasukan_ins.hitungjumlahHarga(`2`);' /> ".
								"<input type='text' name='ket_kuantitas' id='ket_kuantitas' value='".$dt['ket_kuantitas']."' style='width:75px;' />",
						);
			$volume = array(
							'label'=>"VOLUME",
							'labelWidth'=>200,
							'value'=>"<input type='text' name='volume' id='volume2' value='".$volume."' style='width:75px;'  readonly/>",
						);
					
			$biayatambahan = "<input type='checkbox' name='barang_didistribusi' value='1' id='barang_didistribusi' style='margin-left:20px;' $checDistri />HARGA DI KAPITALISASI";
			$barangDistribusi='';
			$satuan = "<input type='text name='satuan' id='satuan2' value='".$dt['satuan']."' style='width:75px;' readonly />";
			$arr_satuan = array("lewat"=>"");
	  }else{
	  	$ket_barang = "MERK / TYPE/ SPESIFIKASI/ JUDUL/ LOKASI";
		$biayatambahan = '';
		$kuantitas = array("lewat"=>"");
		$volume = array("lewat"=>"");
		$barangDistribusi = "<input type='checkbox' name='barang_didistribusi' value='1' id='barang_didistribusi' style='margin-left:90px;' $checDistri />BARANG AKAN DIDISTRIBUSIKAN.";
		$satuan = "";
		$arr_satuan=array(
						'label'=>'SATUAN',
						'labelWidth'=>200,
						'value'=>"<input type='text name='satuan' id='satuan2' value='".$dt['satuan']."' style='width:150px;' $satuan_readonly />",
					);
	  }
	  
	  if($dt['ppn'] != 0){
			$ppn_readonly = "";
			$ppn_chechked= "checked";
		}else{
			$ppn_readonly = "readonly";
			$ppn_chechked= "";
			$dt['ppn']='';
		}
	  
	  $message=$dt['syarat'];
		//items ----------------------
			$this->form_fields = array(
			'kode_barang' => array( 
							'label'=>'KODE BARANG',
							'labelWidth'=>200, 
							'value'=>
								"<input type='text' name='kodebarang' onkeyup='cariBarang.pilBar2(this.value, `2`)' id='kodebarang2' placeholder='KODE BARANG' style='width:150px;' value='".$dt['kodebarangnya']."' /> ".
								"<input type='text' name='namabarang' id='namabarang2' placeholder='NAMA BARANG' style='width:350px;' readonly value='".$dt['nm_barang']."' /> ".
								"<input type='button' name='caribarang' id='caribarang' value='CARI' onclick='".$this->Prefix.".CariBarang();'/>", 
							 ),
			'ket_barang'=> array(
							'label'=>$ket_barang,
							'labelWidth'=>200,
							'value'=>"<textarea name='keteranganbarang' style='width:300px;height:50px;' placeholder='$ket_barang'>".$dt['ket_barang']."</textarea>
							",
						),
			'jml_barang'=>array(
							'label'=>'JUMLAH',
							'labelWidth'=>200,
							'value'=>"<input type='text' name='jumlah_barang' value='".floatval($dt['jml'])."' id='jumlah_barang2' style='width:75px;text-align:right;' onkeypress='return isNumberKey(event)'  onkeyup='pemasukan_ins.hitungjumlahHarga(`2`);' $title_jumlah /><span id='MSG_Jumlah'></span> $barangDistribusi $satuan",
						),
			'kuantitas'=>$kuantitas,
			'volume'=>$volume,
			'satuan'=>$arr_satuan,
			'hrg_satuan'=>array(
							'label'=>'HARGA SATUAN',
							'labelWidth'=>200,
							'value'=>"<input type='text' name='harga_satuan' align='right' value='".floatval($dt['harga_satuan'])."' id='harga_satuan2' style='width:150px;text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`harga_satuannya2`).innerHTML = pemasukan_ins.formatCurrency(this.value);pemasukan_ins.hitungjumlahHarga(`2`);' /> Rp <span id='harga_satuannya2'>".number_format($dt['harga_satuan'],2,",",".")."</span>
								",
						),
			'ppn'=>array(
							'label'=>'PPN (%)',
							'name'=>'ppn',
							'labelWidth'=>200,
							'value'=>
							"<input type='checkbox' name='ppn_ok' value='1' id='ppn_ok2' onclick='pemasukan_ins.Cek_PPN(`2`);' $ppn_chechked />".
							"<input type='number' min='0' name='jml_ppn' value='".$dt['ppn']."' id='jml_ppn2' style='width:54;text-align:right;' onkeyup='pemasukan_ins.hitungjumlahHarga(`2`);' $ppn_readonly /> %",								
						),
			'jml_harga'=>array(
							'label'=>'JUMLAH HARGA',
							'labelWidth'=>200,
							'value'=>"<input type='text' name='jumlah_harga' value='".number_format($dt['harga_total'],2,",",".")."' id='jumlah_harga2' style='width:150;text-align:right;' readonly />".$biayatambahan,
								
						),
			'keterangan'=>array(
							'label'=>'KETERANGAN',
							'labelWidth'=>200,
							'value'=>"<textarea name='keterangan' style='width:300px;height:50px;' placeholder='KETERANGAN'>".$dt['keterangan']."</textarea>",
						),						
			
			);
		//tombol
		$this->form_menubawah =	
			$DataPengaturan->GenViewHiddenSKPD($dt["c1"],$dt["c"],$dt["d"],$dt["e"],$dt["e1"]).
			"<input type='hidden' name='refid_templatebarang' value='".$dt["refid_templatebarang"]."' />".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
			
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function genForm2($withForm=TRUE){	
		$form_name = $this->Prefix.'_form';	
				
		if($withForm){
			$params->tipe=1;
			$form= "<form name='$form_name' id='$form_name' method='post' action=''>".
				createDialog(
					$form_name.'_div', 
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height,
					'',$params
					).
				"</form>";
				
		}else{
			$form= 
				createDialog(
					$form_name.'_div', 
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height
				);
			
			
		}
		return $form;
	}	
	
	
	
		
	//daftar =================================	
	function setKolomHeader($Mode=1, $Checkbox=''){
		$this->BersihkanData();
		$jns_transaksi = cekPOST("jns_transaksi");
		$dstr = "DISTR";
		if($jns_transaksi == "2")$dstr="KPTLS";
		
	$NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox	
	   <th class='th01'>TANGGAL</th>
	   <th class='th01'>NOMOR</th>
	   <th class='th01'>NAMA REKENING/ BARANG</th>
	   <th class='th01'>HARGA REKENING<br>BELANJA</th>
	   <th class='th01'>HARGA RETENSI<br>BARANG</th>
	   <th class='th01'>VALID</th>
	   <th class='th01'>POST</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
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
		/*$TampilTotalHalRp = number_format($TotalHalRp,2, ',', '.');		
		$TotalColSpan = $this->FieldSum_Cp1[$Mode-1];//$Mode ==1 ? 5 : 4;
		$ContentTotalHal =
			"<tr>
				<td class='$ColStyle' colspan='$TotalColSpan' align='center'><b>Total per Halaman</td>
				<td class='$ColStyle' align='right'><b>$TampilTotalHalRp</td>
				<td class='$ColStyle' colspan='4'></td>
			</tr>" ;
			
		$ContentTotal = 
				"<tr>
					<td class='$ColStyle' colspan='$TotalColSpan' align='center'><b>Total</td>
					<td class='$ColStyle' align='right'><b><div  id='cntDaftarTotal'>".$SumHal['sum']."</div></td>
					<td class='$ColStyle' colspan='4'></td>
				</tr>" ;
		
		if($Mode == 2){			
			$ContentTotal = '';
		}else if($Mode == 3){
			$ContentTotalHal='';			
		}
		$ContentSum=$ContentTotalHal.$ContentTotal;
		*/
		
		$ListData .= 
				//$ContentTotalHal.$ContentTotal.
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
	
	function QueryRekening($Id){
		$qry_rek = "SELECT a.*, b.nm_rekening FROM t_penerimaan_retensi_rekening a LEFT JOIN ref_rekening b ON a.k=b.k AND a.l=b.l AND a.m=b.m AND a.n=b.n AND a.o=b.o WHERE a.sttemp='0' AND a.refid_retensi='$Id'";
		
		return $qry_rek;
	}
	
	function QueryRetensiDet($Id){
		$qry_rek = "SELECT a.*, b.nm_barang FROM t_penerimaan_retensi_det a LEFT JOIN ref_barang b ON a.f1=b.f1 AND a.f2=b.f2 AND a.f=b.f AND a.g=b.g AND a.h=b.h AND a.i=b.i AND a.j=b.j WHERE a.sttemp='0' AND a.refid_retensi='$Id'";
		
		return $qry_rek;
	}
	
	function KolomSingkat($cssclass, $i){
		$Koloms='';
		for($x=0;$x<$i;$x++)$Koloms.="<td class='$cssclass' align='left' ></td>";
		return $Koloms;		
	}
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 $no2=0;	 
	 $jns_transaksi = cekPOST("jns_transaksi");
	 $jml = $isi['jml'];
	 if($jns_transaksi == "2")$jml = $jml*$isi['kuantitas'];
	 
	 $barangDistribusi = "TDK";
	 if($isi["barangdistribusi"] == "1")$barangDistribusi="YA";
	 
	 $cssclass = 'GarisCetak';
	 if($Mode == 1)$cssclass = 'GarisDaftar';
	 	 
	 $Koloms= "<tr class='row0'>";
	 	$Koloms.="<td class='$cssclass' align='center' >$no</td>";
	  	if ($Mode == 1) $Koloms.="<td class='$cssclass' align='center' >$TampilCheckBox</td>";
		$Koloms.="<td class='$cssclass' align='center' >".$isi['tgl_kontrak']."</td>";
		$Koloms.="<td class='$cssclass' align='left' >".$isi['nomor_kontrak']."</td>";
		// Data Rekening -----------------------------------------------------------------------------------------	
		$subTotalRek=0;	
		$aqry_rek = mysql_query($this->QueryRekening($isi["Id"]));
		while($dt_rek = mysql_fetch_array($aqry_rek)){
			if($no2!=0){
				$rowrek="row1";
				if($no2%2==0)$rowrek="row0";
				if($no2!=0)$Koloms.="<tr class='$rowrek'>";
					$Koloms.=$this->KolomSingkat($cssclass,4);
			}
			
			$Koloms.="<td class='$cssclass' align='left' >".$dt_rek['nm_rekening']."</td>";
			$Koloms.="<td class='$cssclass' align='right' >".number_format($dt_rek["jumlah"], 2,",",".")."</td>";
			$Koloms.=$this->KolomSingkat($cssclass,3)."</tr>";			
			$no2++;
			$subTotalRek+=$dt_rek["jumlah"];
		}
		
		//Status Valid
		$valid="invalid";
		if($isi["status_validasi"] == "1")$valid="valid";
		//Status Posting
		$post="invalid";
		if($isi["status_posting"] == "1")$post="valid";
		
		//Data Detail Retensi ---------------------------------------------------------------------------------
		$subTotalDet=0;	
		$no3=0;
		$aqry_retensi_det = mysql_query($this->QueryRetensiDet($isi["Id"]));
		
		while($dt_ret_det = mysql_fetch_array($aqry_retensi_det)){
			if($no2%2==0){
				$rowrek="row0";
			}else{
				$rowrek="row1";
			}
			$Koloms.="<tr class='$rowrek'>";
			$Koloms.=$this->KolomSingkat($cssclass,2);
			if($no3==0){	
				$tgl_buku='';
				$id_retensi='';
				if(mysql_num_rows($aqry_retensi_det) == 1){
					$tgl_buku = explode("-",$isi['tgl_buku']);
					$tgl_buku = "<br>".$tgl_buku[2]."-".$tgl_buku[1]."-".$tgl_buku[0];
					$id_retensi = "<br>".$isi['id_retensi'];
				}
				$Koloms.="<td class='$cssclass' align='center' >".$isi['tgl_dokumen_sumber'].$tgl_buku."</td>";
				$Koloms.="<td class='$cssclass' align='left' >".$isi['no_dokumen_sumber'].$id_retensi."</td>";
				
			}else{
				if($no3==1){
					$tgl_buku = explode("-",$isi['tgl_buku']);
					$tgl_buku = $tgl_buku[2]."-".$tgl_buku[1]."-".$tgl_buku[0];
					$Koloms.="<td class='$cssclass' align='center' >".$tgl_buku."</td>";
					$Koloms.="<td class='$cssclass' align='left' >".$isi['id_retensi']."</td>";
				}else{
					$Koloms.=$this->KolomSingkat($cssclass,2);	
				}
				
			}
			
			$Koloms.="<td class='$cssclass' align='left' ><span style='margin-left:25px;'>".$dt_ret_det['nm_barang']."</span></td>";
			$Koloms.=$this->KolomSingkat($cssclass,1);
			$Koloms.="<td class='$cssclass' align='right' >".number_format($dt_ret_det["harga_total"], 2,",",".")."</td>";
			$Koloms.="<td class='$cssclass' align='center' ><img src='images/administrator/images/$valid.png' width='20px' height='20px' /></td>";
			$Koloms.="<td class='$cssclass' align='center' ><img src='images/administrator/images/$post.png' width='20px' height='20px' /></td>";		
			$no2++;
			$no3++;
			$subTotalDet+=$dt_ret_det["harga_total"];
		}
		
		//SUB TOTAL ---------------------------------------------------------------------------------------
		$Koloms.=
			"<tr class='row1'>
				<td class='$cssclass' align='right' colspan='5'><b>SUB TOTAL</b></td>
				<td class='$cssclass' align='right' ><b>".number_format($subTotalRek, 2,",",".")."</b></td>
				<td class='$cssclass' align='right' ><b>".number_format($subTotalDet, 2,",",".")."</b></td>
				<td class='$cssclass' align='left' colspan='2'></td>
			</tr>";
			
	  
	 $Koloms = array(
	 	array("Y", $Koloms),
	 );
	 
	 return $Koloms;
	}
		
	function genDaftarOpsi(){
	 global $Ref, $Main, $DataPengaturan, $DataOption;
	
	$fmJns = $_REQUEST['fmJns'];	
	$crSyarat = $_REQUEST['crSyarat'];	
	
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	
	
	$TampilOpt = "<input type='hidden' id='ver_skpd' value='".$DataOption['skpd']."' />".
				genFilterBar(array(WilSKPD_ajx3($this->Prefix.'SKPD2','100%','145px')),'','','');
			
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
	
	function DataCopy(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		$err=''; $cek=''; $content = '';
		
		$Idplh = cekPOST("ref_templatebarang_idplh");
		$IdDet = addslashes($_REQUEST['datakopi']);
		
		$qry = $DataPengaturan->QyrTmpl1Brs("pemasukan_retensi_baru", "*", "WHERE Id='$IdDet' AND refid_templatebarang='$Idplh' AND status!='2'");$cek.=$qry["cek"];
		$dt = $qry["hasil"];
		
		if($dt['Id'] == "" || $dt["Id"] == NULL){
			$err='Gagal Menggandakan Data !';
		}else{
			$data = array(
						array("c1",$dt["c1"]),
						array("c",$dt["c"]),
						array("d",$dt["d"]),
						array("e",$dt["e"]),
						array("e1",$dt["e1"]),
						array("f1",$dt["f1"]),
						array("f2",$dt["f2"]),
						array("f",$dt["f"]),
						array("g",$dt["g"]),
						array("h",$dt["h"]),
						array("i",$dt["i"]),
						array("j",$dt["j"]),
						array("ket_barang",$dt["ket_barang"]),
						array("jml",$dt["jml"]),
						array("ket_kuantitas",$dt["ket_kuantitas"]),
						array("satuan",$dt["satuan"]),
						array("harga_satuan",$dt["harga_satuan"]),
						array("harga_total",$dt["harga_total"]),
						array("keterangan",$dt["keterangan"]),
						array("barangdistribusi",$dt["barangdistribusi"]),
						array("refid_templatebarang",$dt["refid_templatebarang"]),
						array("uid",$UID),
						array("pajak",$dt["pajak"]),
						array("sttemp","1"),
						array("status","1"),
					);
			for($i=0;$i<=1000;$i++){
				$qry_ins = $DataPengaturan->QryInsData("pemasukan_retensi_baru", $data);$cek.=" | ".$qry_ins["cek"];
			}
			
		}
		
		
		
		return array('err'=>$err,'cek'=>$cek, 'content' => $content);
		
	}
	
	function genSum_setTampilValue($i, $value){
		if($i == 0){
			$a = number_format($value, 0, '.' ,',');
		}else{
			$a = number_format($value, 2, ',' ,'.');
		}
		
		return $a;
	}
	
	function genRowSum_setTampilValue($i, $value){
		
		if($i == 0){
			$a = number_format($value, 0, '.' ,',');
		}else{
			$a = number_format($value, 2, ',' ,'.');
		}
		
		return $a;	
	}
	
	function setPage_HeaderOther(){	
	
	return 
			"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=pemasukan&halman=1\" title='PENGADAAN' >PENGADAAN</a> | 
	<A href=\"pages.php?Pg=pemasukan&halman=2\" title='PEMELIHARAAN' >PEMELIHARAAN</a> |
	<A href=\"pages.php?Pg=pemasukan_retensi_baru\" title='RETENSI' style='color:blue'  >RETENSI</a> 
	&nbsp&nbsp&nbsp	
	</td></tr></table>";
	}
	
	function setValidasi(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$idplh = $cbid[0];
		$this->form_idplh = $cbid[0];
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi","*"," WHERE Id = '$idplh' ");$cek=$qry["cek"];
		$dt = $qry["hasil"];
		
		$qryvalid =  $DataPengaturan->QyrTmpl1Brs("admin","nama","WHERE uid='".$dt['uid_validasi']."'");
		$aqry_namavalid = $qryvalid["hasil"];
		
		$prosesValid = TRUE;
		if($Main->ADMIN_BATAL_VALIDASI == 1){
			$qry_LevelLogin = $DataPengaturan->QyrTmpl1Brs("admin", "level", "WHERE uid='$uid' ");
			$dt_LvlLogin = $qry_LevelLogin["hasil"];
			
			if($dt_LvlLogin["level"] == "1")$prosesValid = FALSE;				 
		}
		
		if($prosesValid){
			if($dt['status_validasi'] == '1')if($dt['uid_validasi'] != '' || $dt['uid_validasi'] != null)if($dt['uid_validasi'] != $uid)$err = "Data Sudah di Validasi, Perubahan Hanya Bisa Dilakukan oleh ".$aqry_namavalid['nama']." !";
		}
		
		if($err == ""){
			$get = $this->setFormValidasi($dt);
			$cek.=$get["cek"];
			$err=$get["err"];
			$content=$get["content"];
		}
		
		
		return array('err'=>$err,'cek'=>$cek, 'content' => $content);	
	}
	
	function setFormValidasi($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 450;
	 $this->form_height = 110;
	 $this->form_caption = 'VALIDASI RETENSI';
	  if ($dt['status_validasi'] == '1') {
	  	//2017-03-30 17:12:16
		$tglvalidnya = $dt['tgl_validasi'];
		$thn1 = substr($tglvalidnya,0,4); 
		$bln1 = substr($tglvalidnya,5,2); 
		$tgl1 = substr($tglvalidnya,8,2); 
		$jam1 = substr($tglvalidnya,11,8);
		
		$tglvalid = $tgl1."-".$bln1."-".$thn1." ".$jam1;
		
		$checked = "checked='checked'";			
	  }else{			
		$tglvalid = date("d-m-Y H:i:s");
		$checked = "";	
	  }
	  
	  $tgl_kontrak = explode("-",$dt['tgl_kontrak']);
	  $tgl_kontrak=$tgl_kontrak[2]."-".$tgl_kontrak[1]."-".$tgl_kontrak[0];
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			'nomor_kontrak' => array( 
						'label'=>'NOMOR KONTRAK',
						'labelWidth'=>150, 
						'value'=>$dt['nomor_kontrak'], 
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),
			'tgl_kontrak' => array( 
						'label'=>'TANGGAL KONTRAK',
						'labelWidth'=>150, 
						'value'=>$tgl_kontrak, 
						'type'=>'text',
						'param'=>"style='width:80px;' readonly"
						 ),
			'tgl_validasi' => array( 
						'label'=>'TANGGAL',
						'labelWidth'=>150, 
						'value'=>$tglvalid, 
						'type'=>'text',
						'param'=>"style='width:125px;' readonly"
						 ),
			'validasi' => array( 
						'label'=>'VALIDASI DATA',
						'labelWidth'=>150, 
						'value'=>"<input type='checkbox' name='validasi' $checked style='margin-left:-1px;' />",
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
	
	function Hapus_Validasi($id){
		global $DataPengaturan;
		
		$errmsg ='';		
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi", "*", "WHERE Id='$id' ");
		$dt = $qry["hasil"];
		
		//Hitung di pemeliharaan
		$qry_pemeliharaan = $DataPengaturan->QryHitungData("pemeliharaan","WHERE refid_retensi='$id'");
		if($errmsg == "" && $qry_pemeliharaan["hasil"] > 0)$errmsg="Data Sudah di Posting, Tidak Bisa di Hapus !";
		if($errmsg == "" && $dt["status_posting"] == "1")$errmsg="Data Sudah di Posting, Tidak Bisa di Hapus !";		
		if($errmsg == "" && $dt["status_validasi"] == "1")$errmsg="Data Sudah di Validasi, Tidak Bisa di Hapus !";
		
		return $errmsg;
	}
	
	function PostingForm(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$idplh = $cbid[0];
		$this->form_idplh = $cbid[0];
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi","*"," WHERE Id = '$idplh' ");$cek=$qry["cek"];
		$dt = $qry["hasil"];
		
		if($err==""){
			$dt['persen']=0;
			$qry_det = "SELECT * FROM t_penerimaan_retensi_det WHERE refid_retensi='$idplh' AND sttemp='0' ";
			$aqry_det = mysql_query($qry_det);
			while($dt_det = mysql_fetch_array($aqry_det)){
				$dt['barangnya'][] = $dt_det["Id"];
			}
			
			$hitung_pmlhrn = $DataPengaturan->QryHitungData("pemeliharaan","WHERE refid_retensi='$idplh'");
			if($hitung_pmlhrn["hasil"] != 0)$dt['persen']=intval((mysql_num_rows($aqry_det)/$hitung_pmlhrn['hasil'])*100);
						
			$get = $this->setFormPosting($dt);
			$cek.=$get["cek"];
			$err=$get["err"];
			$content=$get["content"];			
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
		
	function setFormPosting($dt){	
	 global $SensusTmp, $DataPengaturan;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 500;
	 $this->form_height = 230;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'POSTING DATA RETENSI';
		//$nip	 = '';
		$disabled = FALSE;
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		$checked = $dt['status_posting']=="1"?"checked":"";
		
		$BARANGNYA = '';
		for($i=0;$i<count($dt['barangnya']);$i++){
			$BARANGNYA .= "<input type='hidden' id='id_barangnya_$i' name='id_barangnya_$i' value='".$dt['barangnya'][$i]."' />";
		}
		
		$tgl_kontrak = explode("-",$dt['tgl_kontrak']);
		$tgl_kontrak = $tgl_kontrak[2]."-".$tgl_kontrak[1]."-".$tgl_kontrak[0];
		
		$tgl_post=$dt['tgl_posting'];
		//2017-01-02
		$tgl_posting = $dt['status_posting'] == "1"?substr($tgl_post,8,2)."-".substr($tgl_post,5,2)."-".substr($tgl_post,0,4):date("d-m-Y");
		
		//Hitung Jumlah Barang
		$qry_hitRetensi = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi_det", "IFNULL(SUM(harga_total),0) as harga_total, count(*) as jml_brg", "WHERE refid_retensi='".$dt["Id"]."' AND sttemp='0' ");
		$dt_hitRetensi = $qry_hitRetensi["hasil"];
		
		
	 //items ----------------------
	  $this->form_fields = array(
	  		'nomor_kontrak'=>array(
				'label'=>'NOMOR KONTRAK',
				'labelWidth'=>150, 
				'type'=>'text', 
				'value'=>$dt['nomor_kontrak'],
				'param'=>"readonly style='width:300px;'",
			),	
			'tgl_kontrak'=>array(
				'label'=>'TANGGAL KONTRAK',
				'labelWidth'=>150, 
				'type'=>'text', 
				'value'=>$tgl_kontrak,
				'param'=>"readonly style='width:80px;'",
			),		
			'jml_retensi'=>array(
				'label'=>'JUMLAH BARANG',
				'labelWidth'=>150, 
				'type'=>'text', 
				'value'=>number_format($dt_hitRetensi['jml_brg'],0,'.',','),
				'param'=>"readonly style='width:80px;text-align:right;'",
			),				
			'total_retensi'=>array(
				'label'=>'TOTAL BIAYA RETENSI',
				'labelWidth'=>150, 
				'type'=>'text', 
				'value'=>number_format($dt_hitRetensi['harga_total'],2,',','.'),
				'param'=>"readonly style='width:160px;text-align:right;'",
			),			
			'tgl_posting'=>array(
				'label'=>'TANGGAL POSTING',
				'labelWidth'=>150, 
				'type'=>'text', 
				'value'=>$tgl_posting,
				'param'=>"readonly style='width:80px;'",
			),	
			'stat_posing'=>array(
				'label'=>'POSTING DATA ?',
				'labelWidth'=>150, 
				'value'=>"<input type='checkbox' name='posting' id='posting' value='postingkan' $checked />",
			),	
			'progress' => array(
				'label'=>'',
				'labelWidth'=>1, 
				'type'=>'merge',
				'value'=>				
					"<br><div id='progressbox1' style='background:#fffbf0;border-radius:5px;border:1px solid;height:10px;'>
						<div id='progressbar1'></div >
						<div id='statustxt1' style='width:".$dt["persen"]."%;background:green;height:10px;text-align:right;color:white;font-size:8px;'>".$dt["persen"]."%</div>						
						<div id='output1'></div>
					</div><br>"
				),
			'peringatan' => array( 
				'label'=>'',
				'labelWidth'=>1, 
				'type'=>'merge',
				'value'=>"<div id='pemisah' style='color:red;font-size:11px;'></div>",
			),
			);
		//tombol
		$this->form_menubawah =
			$BARANGNYA.
			"<input type='hidden' name='tot_jmlbarang' id='tot_jmlbarang' value='".$dt_hitRetensi['jml_brg']."'>".
			"<input type='hidden' name='c1' id='c1' value='".$dt['c1']."'>".
			"<input type='hidden' name='c' id='c' value='".$dt['c']."'>".
			"<input type='hidden' name='d' id='d' value='".$dt['d']."'>".
			"<input type='hidden' name='e' id='e' value='".$dt['e']."'>".
			"<input type='hidden' name='e1' id='e1' value='".$dt['e1']."'>".
			"<input type='hidden' name='tahun' id='tahun' value='".$dt['tahun']."'>".
			"<input type='button' value='Posting' onclick ='".$this->Prefix.".SimpanPosting()' title='Posting' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Cek_SimpanPosting(){
		global $Main, $DataPengaturan;
		$err='';$cek='';$content=array();$pesan='';
		
		$idplh = cekPOST2($this->Prefix."_idplh");
		$posting = cekPOST2("posting");
		//Cek Di Pemliharaan 
		$qry_pmlhrn = $DataPengaturan->QryHitungData("pemeliharaan", "WHERE refid_retensi='$idplh' ");
		
		//Cek Jumlah di t_penerimaan_retensi_det
		$qry_ret_det = $DataPengaturan->QryHitungData("t_penerimaan_retensi_det", "WHERE refid_retensi='$idplh' AND sttemp='0' ");		
		
		if($err == "" && $posting == '' && $qry_pmlhrn["hasil"] == 0)$err="Posting Data Belum di Ceklis !";		
		if($err == "" && $posting != '' && $qry_pmlhrn["hasil"] == $qry_ret_det["hasil"])$err="Data Sudah di Posting !";
		
		if($err == ""){
			if($posting == '' && $qry_pmlhrn["hasil"] > 0){
				$content['pesan']="Batalkan Posting Data ?";
				$content['tanya']="3";
			}	
			
			if($posting != '' && $qry_pmlhrn["hasil"] < $qry_ret_det["hasil"] && $qry_pmlhrn["hasil"] != 0){
				$content['pesan']="Lanjutkan Posting Data ?";
				$content['tanya']="2";
			}
			
			if($content['pesan'] == "" && $content['tanya']==""){
				$content['pesan']="Posting Data ?";
				$content['tanya']="1";
			}
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function PersenPostingRetensi($Id){
		global $DataPengaturan;
		$Persen=0;
		$qry_retensi_det = $DataPengaturan->QryHitungData("t_penerimaan_retensi_det","WHERE refid_retensi='$Id' AND sttemp='0' ");
		$qry_pmlhrn = $DataPengaturan->QryHitungData("pemeliharaan", "WHERE refid_retensi='$Id'");
		
		if($qry_retensi_det["hasil"] != 0)$Persen = ($qry_pmlhrn["hasil"]/$qry_retensi_det["hasil"])*100;		
		return intval($Persen);
		
	}
	
	function SavePosting(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		//Cek Dulu Di Pemeliharaan;
		$IdRetensiDet = cekPOST2("IdRetensiDet");
		$Id = cekPOST2($this->Prefix."_idplh");
		
		$qry_pmlhrn = $DataPengaturan->QryHitungData("pemeliharaan", "WHERE refid_retensi='$Id' AND refid_retensi_det='$IdRetensiDet'");
		if($qry_pmlhrn["hasil"] == 0){
			$qry_retensi = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi a LEFT JOIN t_penerimaan_retensi_det b", "a.tgl_buku, a.nomor_kontrak, a.tgl_kontrak,a.tgl_dokumen_sumber, a.no_dokumen_sumber,  b.*", "ON a.Id=b.refid_retensi WHERE b.Id='$IdRetensiDet' AND b.refid_retensi='$Id' ");$cek.=$qry_retensi["cek"];
			$dt_retensi = $qry_retensi['hasil'];
			
			//Cek Kode Belanja
			$qry_rek = $DataPengaturan->QryHitungData("t_penerimaan_retensi_rekening", "WHERE concat(k,'.',l,'.',m) = '".$Main->KODE_BELANJA_MODAL."'");
			$cara_perolehan = 2;
			if($qry_rek['hasil'] > 0)$cara_perolehan=1;
			
			$data = 
				array(
					array("id_bukuinduk", $dt_retensi["id_bi"]),
					array("tgl_pemeliharaan", $dt_retensi["tgl_buku"]),
					array("surat_no", $dt_retensi["nomor_kontrak"]),
					array("surat_tgl", $dt_retensi["tgl_kontrak"]),
					array("jenis_pemeliharaan", "RETENSI"),
					array("biaya_pemeliharaan", $dt_retensi['harga_total']),
					array("uid", $uid),
					array("tgl_perolehan", $dt_retensi["tgl_buku"]),
					array("no_bast", $dt_retensi["no_dokumen_sumber"]),
					array("tgl_bast", $dt_retensi["tgl_dokumen_sumber"]),
					array("refid_retensi", $Id),
					array("refid_retensi_det", $IdRetensiDet),
					array("cara_perolehan", $cara_perolehan),
					array("tambah_aset", "1"),
					//array("tambah_masamanfaat", "1"),
				);
				
			$qry_Inp = $DataPengaturan->QryInsData("pemeliharaan", $data);
			$cek.=$qry_Inp["cek"];
		}
			$content['maxpersen']=$this->PersenPostingRetensi($Id);
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function UpdatePosting(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		$Id = cekPOST2($this->Prefix."_idplh");
		$kondisi=cekPOST2("kondisi");
		
		$status_posting=0;
		$tgl_posting='';
		$uid_posting='';
		
		if($kondisi == "1"){
			$status_posting=1;
			$tgl_posting=date("Y-m-d H:i:s");
			$uid_posting=$uid;
		}
		
		$data_upd = array(
						array("status_posting",$status_posting),
						array("tgl_posting",$tgl_posting),
						array("uid_posting",$uid_posting),
					);
		$qry = $DataPengaturan->QryUpdData("t_penerimaan_retensi",$data_upd, "WHERE Id='$Id' ");$cek.=$qry["cek"];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function BatalkanPosting(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		$Id = cekPOST2($this->Prefix."_idplh");
		
		$qry="DELETE FROM pemeliharaan WHERE refid_retensi='$Id' LIMIT 100";$cek.=$qry;
		$aqry = mysql_query($qry);
		
		$Persen = $this->PersenPostingRetensi($Id);
		
		$content['next']=0;
		if($Persen > 0)$content['next']=1;
		$content['maxpersen']=$Persen;
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function CekEdit(){
		global $DataPengaturan;
		$cek='';$err='';$content='';$errmsg='';
		
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$idplh = $cbid[0];	
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi", "*", "WHERE Id='$idplh' ");
		$dt = $qry["hasil"];
		
		//Hitung di pemeliharaan
		$qry_pemeliharaan = $DataPengaturan->QryHitungData("pemeliharaan","WHERE refid_retensi='$idplh'");
		if($errmsg == "" && $qry_pemeliharaan["hasil"] > 0)$errmsg="Data Sudah di Posting, Tidak Bisa di Ubah !";
		if($errmsg == "" && $dt["status_posting"] == "1")$errmsg="Data Sudah di Posting, Tidak Bisa di Ubah !";		
		if($errmsg == "" && $dt["status_validasi"] == "1")$errmsg="Data Sudah di Validasi, Tidak Bisa di Ubah !";
		
		
		return	array ('cek'=>$cek, 'err'=>$errmsg, 'content'=>$content);
	}
	
	function BersihkanData(){
		$cek='';
		//Retensi Rekening
		$hapusrek = "DELETE FROM t_penerimaan_retensi_rekening WHERE tgl_update < DATE_SUB(NOW(), INTERVAL 3 HOURS) AND sttemp!='0'"; $cek.="| ".$hapusrek;
		$qry_hapusrek = mysql_query($hapusrek);
		
		$updrek = "UPDATE t_penerimaan_retensi_rekening SET status='0' WHERE tgl_update < DATE_SUB(NOW(), INTERVAL 15 MINUTE) AND sttemp='0'";$cek.="| ".$updrek;
		$qry_updrek = mysql_query($updrek);		
					
					
		//Retensi Detail -----------------------------------------------------------------------------------
		$hapuspenerimaan_det = "DELETE FROM t_penerimaan_retensi_det WHERE tgl_update < DATE_SUB(NOW(), INTERVAL 30 MINUTE) AND sttemp!='0'"; $cek.="| ".$hapuspenerimaan_det;
		$qry_hapuspenerimaan_det	= mysql_query($hapuspenerimaan_det);
		
		$updpenerimaan_det =  "UPDATE t_penerimaan_retensi_det SET status='0' WHERE tgl_update < DATE_SUB(NOW(), INTERVAL 15 MINUTE) AND sttemp='0'"; $cek.='| '.$updpenerimaan_det;
		
		$qry_updpenerimaan_det = mysql_query($updpenerimaan_det);		
					
		//Retensi ------------------------------------------------------------------------------------------
		$hapus_penerimaan = "DELETE FROM t_penerimaan_retensi WHERE tgl_create < DATE_SUB(NOW(), INTERVAL 2 DAY) AND sttemp!='0'"; $cek.="| ".$hapus_penerimaan;		
		$qry_hapus_penerimaan = mysql_query($hapus_penerimaan);
				
		return $cek;
	}
}
$pemasukan_retensi_baru = new pemasukan_retensi_baruObj();
?>