<?php

class bypassTahap_v2Obj  extends DaftarObj2{	
	var $Prefix = 'bypassTahap_v2';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_tahap_anggaran'; //bonus
	var $TblName_Hapus = 'ref_tahap_anggaran';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id_tahap');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'TAHAP';
	var $PageIcon = 'images/perencanaan_ico.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='bypassTahap_v2.xls';
	var $namaModulCetak='TAHAP';
	var $Cetak_Judul = 'TAHAP';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'bypassTahap_v2Form';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	function setTitle(){
		return 'TAHAP';
	}
	 function setPage_HeaderOther(){
   		
	return 
	"";
	}
	function setMenuEdit(){
		return
			
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru ", 'Baru ')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
	}
	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];

	 foreach ($_REQUEST as $key => $value) { 
		  $$key = $value; 
	 } 
	
	
	if(empty($tahun))$err ="ISI TAHUN";
	if(empty($idModul))$err = "PILIH MODUL";
	if(empty($anggaran))$err = "PILIH ANGGARAN";
	if(empty($tahun))$err = "ISI TAHUN";
	if(empty($jenisForm))$err = "PILIH JENIS TAHAP";
	if(empty($nama_tahap))$err = "ISI NAMA TAHAP";
	
	
	$user = $_COOKIE['coID'];
	
	
	 if( $err=='' && $nama_tahap =='' ) $err= 'NAMA TAHAP ANGGARAN Belum Di Isi !!';
	 
	
	 
	 
	 if($fmST == 0){
	 
	 				
					
					if(mysql_num_rows(mysql_query("select * from ref_tahap_anggaran where tahun ='$tahun' and anggaran='$anggaran'")) != 0){
						$getIdModul = mysql_fetch_array(mysql_query("select max(id_modul) from ref_tahap_anggaran where tahun ='$tahun' and anggaran = '$anggaran' and id_modul !='KOREKSI PENGGUNA' and id_modul !='KOREKSI PENGELOLA'"));
						$maxIdModul = $getIdModul['max(id_modul)'];
						$concatKoreksiRka = $maxIdModul.".".$idModul;
						if( $idModul < $maxIdModul && $concatKoreksiRka != "7.4" ){
							$err = "Tidak dapat kembali menginputkan tahap modul sebelumnya";
							/*if($maxIdModul == "KOREKSI PENGGUNA" || $maxIdModul="KOREKSI PENGELOLA"){
								$getIdModul = mysql_fetch_array(mysql_query("select max(id_modul) from ref_tahap_anggaran where tahun ='$tahun' and anggaran = '$anggaran' and id_modul !='KOREKSI PENGGUNA' and id_modul !='KOREKSI PENGELOLA'"));
								$maxIdModul = $getIdModul['max(id_modul)'];
									$err = "Tidak dapat kembali menginputkan tahap modul sebelumnya";
								
							}else{
									
							}*/
								
							
							
						}
						$cek = "id modul = $idModul maxId = $maxIdModul";
					}
					if($jenisForm == "PENYUSUNAN"){
						if(mysql_num_rows(mysql_query("select * from ref_tahap_anggaran where tahun = '$tahun' and jenis_form_modul = '$jenisForm' and id_modul = '$idModul' and anggaran='$anggaran' ")) != 0){
							$err = "Tahap Sudah Ada ";
						}
					}

				if($err==''){
									
					 if($status == "AKTIF"){
					 	mysql_query("update ref_tahap_anggaran set status_penyusunan = 'TIDAK AKTIF'");
					 }
					
					
					
					$data = array(
								   'anggaran' => $anggaran,
								   'tahun' => $tahun,
								   'nama_tahap' => $nama_tahap,
								   'id_modul' => $idModul,
								   'no_urut' => $nomor_urut,
								   'jenis_form_modul' =>$jenisForm,
								   'status_penyusunan' => $status,
								   'tgl_update'=> date("Y-m-d"),
								   'user' => $user
								  );
								  
					mysql_query(VulnWalkerInsert("ref_tahap_anggaran",$data));
					$nomor_urut = 1;
								$execute = mysql_query("select * from ref_tahap_anggaran where  anggaran='$anggaran' and  tahun = '$tahun' ORDER BY id_tahap");
								while($rows = mysql_fetch_array($execute)){
									$dataUpdateAll = array("no_urut" => $nomor_urut);
									$currentIdTahap = $rows['id_tahap'];
									mysql_query(VulnWalkerUpdate('ref_tahap_anggaran',$dataUpdateAll," id_tahap = '$currentIdTahap'") );
								   $nomor_urut = $nomor_urut + 1;
								}
					
				}
			}else{		

				if($err==''){
							 if($status == "AKTIF"){
							 	mysql_query("update ref_tahap_anggaran set status_penyusunan = 'TIDAK AKTIF'");
							 }
							
						    $data = array(
								   'anggaran' => $anggaran,
								   'tahun' => $tahun,
								   'nama_tahap' => $nama_tahap,
								   'id_modul' => $idModul,
								   'jenis_form_modul' =>$jenisForm,
								   'status_penyusunan' => $status,
								   'tgl_update'=> date("Y-m-d"),
								   'user' => $user
								  );
						mysql_query(VulnWalkerUpdate('ref_tahap_anggaran',$data, "id_tahap = '$idplh'"))	;
						
						$nomor_urut = 1;
								$execute = mysql_query("select * from ref_tahap_anggaran where  anggaran='$anggaran' and  tahun = '$tahun' ORDER BY id_tahap");
								while($rows = mysql_fetch_array($execute)){
									$dataUpdateAll = array("no_urut" => $nomor_urut);
									$currentIdTahap = $rows['id_tahap'];
									mysql_query(VulnWalkerUpdate('ref_tahap_anggaran',$dataUpdateAll," id_tahap = '$currentIdTahap'") );
								   $nomor_urut = $nomor_urut + 1;
								}
				
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
			"<script type='text/javascript' src='js/perencanaan_v2/bypassTahap/bypassTahap.js' language='JavaScript' ></script> 
			<script type='text/javascript' src='js/master/ref_tahap_anggaran/popupModul.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/master/ref_tahap_anggaran/popupHistori.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/master/ref_jadwal_v2/popupJadwal.js' language='JavaScript' ></script>
			  <link rel='stylesheet' href='datepicker/jquery-ui.css'>
			  <script src='datepicker/jquery-1.12.4.js'></script>
			  <script src='datepicker/jquery-ui.js'></script>
			  
			".
			$scriptload;
	}
	
	function setFormBaru(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d");
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
   
  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;				
		if($err == ''){
			$aqry = "SELECT * FROM  ref_tahap_anggaran WHERE id_tahap='".$this->form_idplh."' "; $cek.=$aqry;
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
	 $this->form_width = 600;
	 $this->form_height = 200;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
		/*$username = $_COOKIE['coID'];
		$cekRows = mysql_num_rows(mysql_query("select * from default_tahap where user = '$username'"));
		if($cekRows > 0){
			$getDefault = mysql_fetch_array(mysql_query("select * from default_tahap where user = '$username'"));
			$tahun = $getDefault['tahun'];
			$anggaran = $getDefault['jenis_anggaran'];
		}*/
		$getTahunSetting = mysql_fetch_array(mysql_query("select * from settingperencanaan"));
		$tahun = $getTahunSetting['tahun'];
		//-------------------
		$status = "PASIF";
		$getMaxNomorAku = mysql_fetch_array(mysql_query("select max(id_tahap) max from ref_tahap_anggaran"));
		$maxNomorAku = $getMaxNomorAku['max'];
		$getNomorAku = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$maxNomorAku'"));
		$nomor_aku = $getNomorAku['no_urut'];
		$maxJenisAnggaran = $getNomorAku['anggaran'];
		$maxTahun = $getNomorAku['tahun'];
		$maxNoUrutSesudahnya = $nomor_aku + 1;
		$waktu_aktif = explode("-",$getNomorAku['tanggal_selesai']);
		$waktu_aktif = $waktu_aktif[2]."-".$waktu_aktif[1]."-".$waktu_aktif[0];
		$jamMulai = explode(':',$getNomorAku['jam_selesai']);
		$jamM = $jamMulai[0]; 
		$menitM = $jamMulai[1] + 1;
	  }else{
		$this->form_caption = 'Edit';			
		$nama_tahap = $dt['nama_tahap']	;
		$modul = $dt['modul'];	
		$waktu_aktif = explode("-",$dt['tanggal_mulai']);
		$waktu_aktif = $waktu_aktif[2]."-".$waktu_aktif[1]."-".$waktu_aktif[0];
		$waktu_pasif = explode("-",$dt['tanggal_selesai']);
		$waktu_pasif = $waktu_pasif[2]."-".$waktu_pasif[1]."-".$waktu_pasif[0];
		$status = $dt['status'];	
		$tahun = $dt['tahun'];
		$anggaran = $dt['anggaran'];
		$jenisForm = $dt['jenis_form_modul'];
		$maxJenisAnggaran = $dt['anggaran'];
		$maxTahun = $dt['tahun'];
		$jamMulai = explode(':',$dt['jam_mulai']);
		$jamM = $jamMulai[0]; 
		$menitM = $jamMulai[1];
		$jamSelesai = explode(':',$dt['jam_selesai']);
		$jamA = $jamSelesai[0]; 
		$menitA = $jamSelesai[1]; 
		$status = $dt['status_penyusunan'];
		$idModul = $dt['id_modul'];
		$nomor_aku = $dt['no_urut'] - 1;
		$arrayIdModule = explode(';',$dt['id_modul']);
		$maxNoUrutSesudahnya = $nomor_aku + 2;
		$arrayJenisForm = "";
		$namaModul = "";
		 for ($i = 0 ; $i < sizeof($arrayIdModule); $i ++){
		 	$getModul = mysql_fetch_array(mysql_query("select * from ref_modul where id_modul = '$arrayIdModule[$i]' "));
			
			$namaModul .= $getModul['nama_modul'].$pemisah; 		
		 }
		$idTahap = $dt['id_tahap'];
		if(mysql_num_rows(mysql_query("select * from tabel_anggaran where id_tahap = '$idTahap'")) != 0){
		$adaGak = "disabled";
	}	
	  }
	    //ambil data trefditeruskan
	  	$query = "select *from " ;$cek .=$query;
	  	$res = mysql_query($query);
		   $jamMulai = "<input type ='text' class = 'clockpicker'>";
		   $arrayJam = array(array('00','00'),
		   					 array('01','01'),
							 array('02','02'),
							 array('03','03'),
							 array('04','04'),
							 array('05','05'),
							 array('06','06'),
							 array('07','07'),
							 array('08','08'),
							 array('09','09'),
							 array('10','10'),
							 array('11','11'),
							 array('12','12'),
							 array('13','13'),
							 array('14','14'),
							 array('15','15'),
							 array('16','16'),
							 array('17','17'),
							 array('18','18'),
							 array('19','19'),
							 array('20','20'),
							 array('21','21'),
							 array('22','22'),
							 array('23','23'));
			$arrayMenit = array();			 
			for ($i = 0; $i <= 59 ; $i ++){
				if($i < 10){
					$menit = "0".$i;
				}else{
					$menit = $i;
				}
				array_push($arrayMenit, array($menit,$menit));
			}
			 
	$cmbJamMulai = cmbArray('jamM',$jamM,$arrayJam, '-- JAM MULAI --',$adaGak);
	$cmbMenitMulai = cmbArray('menitM',$menitM,$arrayMenit,'-- MENIT MULAI --',$adaGak);
	$cmbJamAkhir = cmbArray('jamA',$jamA,$arrayJam, '-- JAM SELESAI --');
	$cmbMenitAkhir = cmbArray('menitA',$menitA,$arrayMenit,'-- MENIT SELESAI --');
	$jamMulai = $cmbJamMulai." : ".$cmbMenitMulai;
	$jamSelesai = $cmbJamAkhir." : ".$cmbMenitAkhir;
		
	$mulai = "<input type ='text' id='waktu_aktif' name='waktu_aktif' value='$waktu_aktif' class='datepicker' $adaGak> ";
	if($adaGak != ''){
		$mulai = "<input type ='text' id='waktu_aktif' name='waktu_aktif' value='$waktu_aktif'  $adaGak> ";
	}	
	$selesai = "<input type ='text' id='waktu_pasif' name='waktu_pasif' value='$waktu_pasif' class='datepicker'> ";
	$tanggal = $mulai." S/D ".$selesai;
   
   $arrayStatus = array(array('AKTIF' , 'AKTIF'),
					  	array('TIDAK AKTIF' , 'TIDAK AKTIF'));
   $cmbStatus = cmbArray('status',$status,$arrayStatus,'-- STATUS --');
   $arrayAnggaran = array(	array('MURNI','MURNI'),
							array("PERUBAHAN","PERUBAHAN"),
							array("PERGESERAN","PERGESERAN")
							) ;
							
	if($namaModul =="RKBMD"){
				$arrayJenisForm = array(array('PENYUSUNAN' , 'PENYUSUNAN'),
							 				array('KOREKSI PENGGUNA' , 'KOREKSI PENGGUNA'),
							 			    array('KOREKSI PENGELOLA' , 'KOREKSI PENGELOLA'),
							                );
			}else{
				if($namaModul == "R-APBD" || $namaModul == "APBD" || $namaModul == "DPA"){
					$arrayJenisForm = array(array('READ' , 'READ')
							                );
				}
				else{
					$arrayJenisForm = array(array('PENYUSUNAN' , 'PENYUSUNAN'),
							 				array('KOREKSI' , 'KOREKSI'),
							                );
				}
				
			}
								
	$cmbJenisForm = cmbArray('jenisForm',$jenisForm,$arrayJenisForm,'-- JENIS TAHAP --');
	
  	$cmbAnggaran = cmbArray('anggaran',$anggaran,$arrayAnggaran,'-- ANGGARAN --'); 
    $findModul = "<input type='text' id ='namaModul' name = 'namaModul' value='$namaModul' style='width : 300px;' readonly > <input type='hidden' name='idModul' id='idModul' value='$idModul'>  <button type='button' onclick='bypassTahap_v2.CariModul()'>CARI </button>";
   
	$maxNoUrut = $nomor_aku ;
	$getDataMax = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$maxNoUrut' and anggaran = '$maxJenisAnggaran' and tahun = '$maxTahun'  " ));
	$arrayTanggalMulaiBefore = explode("-",$getDataMax['tanggal_mulai']);
	$mulaiBefore =  $arrayTanggalMulaiBefore[2]."-".$arrayTanggalMulaiBefore[1]."-".$arrayTanggalMulaiBefore[0]. "  JAM : ".$getDataMax['jam_mulai'];
	$arrayTanggalSelesaiBefore = explode("-",$getDataMax['tanggal_selesai']);
	$mulaiAfter =  $arrayTanggalSelesaiBefore[2]."-".$arrayTanggalSelesaiBefore[1]."-".$arrayTanggalSelesaiBefore[0]. "  JAM : ".$getDataMax['jam_selesai'];
	
$getDataMaxSetelah = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$maxNoUrutSesudahnya' and anggaran = '$maxJenisAnggaran' and tahun = '$maxTahun' " ));
	$arrayTanggalMulaiSetelah = explode("-",$getDataMaxSetelah['tanggal_mulai']);
	$mulaiSetelahnya =  $arrayTanggalMulaiSetelah[2]."-".$arrayTanggalMulaiSetelah[1]."-".$arrayTanggalMulaiSetelah[0]. "  JAM : ".$getDataMaxSetelah['jam_mulai'];
	$arrayTanggalSelesaiSetelah = explode("-",$getDataMaxSetelah['tanggal_selesai']);
	$selesaiSetelahnya=  $arrayTanggalSelesaiSetelah[2]."-".$arrayTanggalSelesaiSetelah[1]."-".$arrayTanggalSelesaiSetelah[0]. "  JAM : ".$getDataMaxSetelah['jam_selesai'];
	
	
	
	 //items ----------------------
	  $this->form_fields = array(
	  		'tahun' => array( 
						'label'=>'TAHUN',
						'labelWidth'=>100, 
						'value'=>$tahun, 
						'type'=>'text',
						'param'=>"style='width:100px;' placeholder = 'TAHUN' readonly"
						 ),
	  		'anggaran' => array( 
						'label'=>'ANGGARAN',
						'labelWidth'=>100, 
						'value'=>$cmbAnggaran
						 ),
			'modul' => array( 
						'label'=>'MODUL',
						'labelWidth'=>100, 
						'value'=>$findModul
						 ),	
			'jenisForm' => array( 
						'label'=>'JENIS TAHAP',
						'labelWidth'=>100, 
						'value'=>$cmbJenisForm
						 ),		
			'nama_tahap' => array( 
						'label'=>'NAMA TAHAP',
						'labelWidth'=>100, 
						'value'=>$nama_tahap, 
						'type'=>'text',
						'param'=>"style='width:300px;' placeholder = 'NAMA TAHAP'"
						 ),
			'status' => array( 
						'label'=>'STATUS PENYUSUNAN',
						'labelWidth'=>100, 
						'value'=>$cmbStatus
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' > &nbsp ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	

		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' rowspan='2' colspan='1' >No.</th>
  	   $Checkbox		
	   <th class='th01' width='100' rowspan='2' colspan='1'>ANGGARAN </th>
	   <th class='th01' width='100' rowspan='2' colspan='1'>TAHUN</th>
	   	   <th class='th01' width='100' rowspan='2' colspan='1'>NO URUT</th>
	   <th class='th01' width='100' rowspan='2' colspan='1'>JENIS TAHAP</th>
	   <th class='th01' width='900' rowspan='2' colspan='1'>TAHAP</th>

	   <th class='th01' width='300' rowspan='2' colspan='1'>AKTIFASI MODUL</th>
	   
	   <th class='th01' width='200' rowspan='2' colspan='1'>STATUS TAHAP</th>
	   <th class='th01' width='200' rowspan='2' colspan='1'>TANGGAL UPDATE</th>
	   <th class='th01' width='100' rowspan='2' colspan='1'>USER</th>
	   </tr>

	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$isi['anggaran']);
	 $Koloms[] = array('align="center"',$isi['tahun']);
	 	 $Koloms[] = array('align="right"',$isi['no_urut']);
	 $Koloms[] = array('align="left"',$isi['jenis_form_modul']);
	 $Koloms[] = array('align="left"',$isi['nama_tahap']);

	 $arrayIdModule = explode(';',$isi['id_modul']);
	 $arrayNamaModule = array();
	 for ($i = 0 ; $i < sizeof($arrayIdModule); $i ++){
	 	$getModul = mysql_fetch_array(mysql_query("select * from ref_modul where id_modul = '$arrayIdModule[$i]' "));
		
		$arrayNamaModule[] = $getModul['nama_modul'];
	 }
	 
	 $namaModul = join($arrayNamaModule,", ");
	 $Koloms[] = array('align="left"',$namaModul);

	 $waktu_aktif = explode('-',$isi['tanggal_mulai']) ;
	 $waktu_aktif = $waktu_aktif[2]."-".$waktu_aktif[1]."-".$waktu_aktif[0];
	 $jam_mulai = $isi['jam_mulai'];
	 $jam_selesai = $isi['jam_selesai'];
	 $waktu_pasif = explode('-',$isi['tanggal_selesai']) ;
	 $waktu_pasif = $waktu_pasif[2]."-".$waktu_pasif[1]."-".$waktu_pasif[0];
	 $ID_TAHAP = $isi['id_tahap'];
	 $Koloms[] = array('align="left"',$isi['status_penyusunan']);
	 $tanggalUpdate = explode("-",$isi['tgl_update']);
	 $tanggalUpdate = $tanggalUpdate[2]."-".$tanggalUpdate[1]."-".$tanggalUpdate[0];
	 $Koloms[] = array('align="center"',$tanggalUpdate);
	 $Koloms[] = array('align="center"',$isi['user']);

	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 
		
	 //data order ------------------------------
	 
	  $arr = array(
						array('nama_tahap','NAMA TAHAP'),		
						array('waktu_aktif','WAKTU AKTIF'),	
						array('waktu_pasif','WAKTU PASIF'),
						array('modul','MODUL'),
						array('status','STATUS')			
			);
	 
	 $arrOrder = array(
				     	array('nama_tahap','NAMA TAHAP'),		
						array('waktu_aktif','WAKTU AKTIF'),	
						array('waktu_pasif','WAKTU PASIF'),
						array('modul','MODUL'),
						array('status','STATUS')			
					);
	 
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];			
$fmORDER1 = $_REQUEST['fmORDER1'];


	$fmDESC1 = cekPOST('fmDESC1');
	$baris = $_REQUEST['baris'];
	if($baris == ''){
		$baris = "25";
	}
	$tahunCari = $_REQUEST['tahunCari'];
	$getTahunSetting = mysql_fetch_array(mysql_query("select * from settingperencanaan"));
		$tahunCari = $getTahunSetting['tahun'];
		//-------------------
	$TampilOpt = 
			"<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td style='width:100px;'> TAHUN </td><td><input type='text' value='$tahunCari' name='tahunCari' id='tahunCari' readonly>  </td>
			 </tr>
			</table>".
			"</div>"."<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td style='width:100px;'> ".cmbArray('fmORDER1',$fmORDER1,$arrOrder,'--Urutkan--','')."  </td>
			<td style='width:200px;' ><input $fmDESC1 type='checkbox' id='fmDESC1' name='fmDESC1' value='checked'> menurun &nbsp Jumlah Data : <input type='text' name='baris' value='$baris' id='baris' style='width:30px;'>  </td><td align='left' ><input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'></td>
			 </tr>
			</table>".
			"</div>"
			
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


		$fmLimit = $_REQUEST['baris'];
		$this->pagePerHal=$fmLimit;

			
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn
		$fmLimit = $_REQUEST['baris'];
		$this->pagePerHal=$fmLimit;

		//Cari 
		switch($fmPILCARI){			
			case 'nama_tahap': $arrKondisi[] = " $fmPILCARI like '%$fmPILCARIvalue%'"; break;						 
			case 'waktu_aktif': $arrKondisi[] = " $fmPILCARI like '%$fmPILCARIvalue%'"; break;	
			case 'waktu_pasif': $arrKondisi[] = " $fmPILCARI like '%$fmPILCARIvalue%'"; break;	
			case 'modul': $arrKondisi[] = " $fmPILCARI like '%$fmPILCARIvalue%'"; break;	
			case 'status': $arrKondisi[] = " $fmPILCARI like '%$fmPILCARIvalue%'"; break;			
		}
		$tahunCari = $_REQUEST['tahunCari'];
		$arrKondisi[] = "no_urut > 5 ";
		if(!empty($tahunCari))$arrKondisi[]="tahun ='$tahunCari'";
		
		
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case 'nama_tahap': $arrOrders[] = " $fmORDER1 $Asc1 " ;break;
			case 'waktu_aktif': $arrOrders[] = " $fmORDER1 $Asc1 " ;break;
			case 'waktu_pasif': $arrOrders[] = " $fmORDER1 $Asc1 " ;break;
			case 'modul': $arrOrders[] = " $fmORDER1 $Asc1 " ;break;
			case 'status': $arrOrders[] = " $fmORDER1 $Asc1 " ;break;
		}	
		if(empty($fmPILCARI))$arrOrders[] = " id_tahap $Asc1";
		/*$arrOrders[] = " no_urut $Asc1 " ;*/
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
	
	function Hapus($ids){ //validasi hapus ref_kota
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++)	{
		
			$cekAdaData = mysql_num_rows(mysql_query("select * from tabel_anggaran where id_tahap = '$ids[$i]'"));
			if($cekAdaData != 0){
				//$err = "Tidak Dapat Menghapus Tahap";
				mysql_query("delete from tabel_anggaran where id_tahap = '$ids[$i]'");
			}
			
			
			if($err=='' ){
					
					$queryGet = "select * FROM $this->TblName_Hapus WHERE id_tahap='".$ids[$i]."'";
					$getInfo = mysql_fetch_array(mysql_query($queryGet));
					$qy = "DELETE FROM $this->TblName_Hapus WHERE id_tahap='".$ids[$i]."' ";$cek.=$qy;
					$qry = mysql_query($qy);
					$anggaran = $getInfo['anggaran'];
					$tahun = $getInfo['tahun'];
					$nomor_urut = 1;
					$execute = mysql_query("select * from ref_tahap_anggaran where status_penyusunan ='AKTIF' and anggaran='$anggaran' and  tahun = '$tahun' ORDER BY id_tahap");
					while($rows = mysql_fetch_array($execute)){
					      $dataUpdateAll = array("no_urut" => $nomor_urut);
						  $currentIdTahap = $rows['id_tahap'];
						  mysql_query(VulnWalkerUpdate('bypassTahap_v2',$dataUpdateAll," id_tahap = '$currentIdTahap'") );
						  $nomor_urut = $nomor_urut + 1;
					}
					$cek .= $queryGet;	
					
					$nomor_urut = 1;
								$execute = mysql_query("select * from ref_tahap_anggaran where  anggaran='$anggaran' and  tahun = '$tahun' ORDER BY id_tahap");
								while($rows = mysql_fetch_array($execute)){
									$dataUpdateAll = array("no_urut" => $nomor_urut);
									$currentIdTahap = $rows['id_tahap'];
									mysql_query(VulnWalkerUpdate('ref_tahap_anggaran',$dataUpdateAll," id_tahap = '$currentIdTahap'") );
								   $nomor_urut = $nomor_urut + 1;
								}
			}else{
				break;
			}			
		}
		return array('err'=>$err,'cek'=>$cek);
	}
}
$bypassTahap_v2 = new bypassTahap_v2Obj();
?>