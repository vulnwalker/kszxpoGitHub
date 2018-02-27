<?php
class settingDevObj  extends DaftarObj2{
	var $Prefix = 'settingDev';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'settingperencanaan'; //bonus
	var $TblName_Hapus = 'settingperencanaan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'PENGATURAN';
	var $PageIcon = 'images/administrator/images/InformationSetting.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='settingDev.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'settingDev';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'settingDevForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0
	var $FieldC1 = 0;
	var $arrEselon = array(
		array('1','ESELON I'),
		array('2','ESELON II'),
		array('3','ESELON III'),
		array('4','ESELON IV'),
		array('5','ESELON V')
		);

	var $jns_trans = array(
			//array('selectAll','Semua'),
			array('1','PENGADAAN BARANG'),
			array('2','PEMELIHARAAN BARANG'),
			);

	var $arr_pencairan_dana = array(
			array('1', "SPP-LS"),
			array('2', "SPP-UP"),
			array('3', "SPP-GU"),
			array('4', "SPP-TU"),
			);

	var $arr_cara_bayar = array(
			//array('selectAll','Semua'),
			array('1','UANG MUKA'),
			array('2','TERMIN'),
			array('3','PELUNASAN'),
			);

	var $CekDistribusi = 1; //1=Ya, 0=Tidak

	function setTitle(){
		return 'PENGATURAN DEVELOPMENT';
	}

	function setMenuEdit(){
		return "";
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

	 if( $err=='' && $nama =='' ) $err= 'Satuan Belum Di Isi !!';

			if($fmST == 0){
				if($err==''){
					$aqry = "INSERT into ref_satuan (nama)values('$nama')";	$cek .= $aqry;
					$qry = mysql_query($aqry);
				}
			}else{
				if($err==''){
				$aqry = "UPDATE ref_satuan set nama='$nama' WHERE Id='".$idplh."'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());
					}
			} //end else

			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
    }

		function baseToImage($base64_string, $output_file) {
			$ifp = fopen( $output_file, 'wb' );
			$data = explode( ',', $base64_string );
			fwrite( $ifp, base64_decode( $data[ 1 ] ) );
			fclose( $ifp );
			return $output_file;
	 }

	function SimpanUbah(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;

		$Idplh = addslashes($_REQUEST['IDNYA']);
	 	$bypassJadwal = 'MURNI';
		$wajibValidasi = $_REQUEST['wajibValidasi'];
		$tahun = $_REQUEST['tahun'];
		$provinsi = $_REQUEST['provinsi'];
		$kota = $_REQUEST['kota'];
		$pejabat = $_REQUEST['pejabatPengelolaBarang'];
		$pengelola = $_REQUEST['pengelolaBarang'];
		$pengurus = $_REQUEST['pengurusBarangPengelola'];
		$bidang = $_REQUEST['bidang'];
		$namaSKPD = $_REQUEST['namaSKPD'];
		$alamat = $_REQUEST['alamat'];
		$kotakab = $_REQUEST['kotakab'];
		$titimangsa = $_REQUEST['titimangsa'];
		$namaAplikasi = $_REQUEST['namaAplikasi'];
		$def_atrib = addslashes($_REQUEST['def_atrib']);

		$logo = $this->baseToImage($_REQUEST['siteImage'],"Media/".md5(date("Y-m-d")).md5(date("H:i:s")));
		mysql_query("UPDATE general_setting set option_value ='$kota' where option_name = 'nama_pemda'");
		$updateTPengaturan = mysql_query("UPDATE t_pengaturan set nama_bidang='$bidang', nama_skpd='$namaSKPD', alamat='$alamat', kota='$kotakab', titimangsa_surat='$titimangsa', nama_aplikasi='$namaAplikasi', harga_atribusi='$def_atrib' where id=1	 ");;
		

	 $qry = "UPDATE settingDev  SET  jenis_anggaran = '".$_REQUEST['cmbJenisAnggaran']."',  tahun = '$tahun', logo = '$logo'";$cek.=$qry;
	 $aqry = mysql_query($qry);
	//wajib_validasi = '$wajibValidasi',
	 $getDataTahap = mysql_num_rows(mysql_query("select * from ref_tahap_anggaran where tahun = '$tahun' and anggaran = '$bypassJadwal'"));
	 if($getDataTahap == 0){
		$data1 = array( 'anggaran' => $bypassJadwal,
						'tahun' => $tahun,
						'no_urut' => '1',
						'id_modul' => '1',
						'jenis_form_modul' => 'PENYUSUNAN',
						 );
		mysql_query(VulnWalkerInsert('ref_tahap_anggaran',$data1));
	 	$data1 = array( 'anggaran' => $bypassJadwal,
						'tahun' => $tahun,
						'no_urut' => '2',
						'id_modul' => '2',
						'jenis_form_modul' => 'PENYUSUNAN',
						 );
		mysql_query(VulnWalkerInsert('ref_tahap_anggaran',$data1));
		$data1 = array( 'anggaran' => $bypassJadwal,
						'tahun' => $tahun,
						'no_urut' => '3',
						'id_modul' => '3',
						'jenis_form_modul' => 'PENYUSUNAN',
						 );
		mysql_query(VulnWalkerInsert('ref_tahap_anggaran',$data1));
		$data1 = array( 'anggaran' => $bypassJadwal,
						'tahun' => $tahun,
						'no_urut' => '4',
						'id_modul' => 'KOREKSI PENGGUNA',
						'jenis_form_modul' => 'KOREKSI PENGGUNA',
						 );
		mysql_query(VulnWalkerInsert('ref_tahap_anggaran',$data1));
		$data1 = array( 'anggaran' => $bypassJadwal,
						'tahun' => $tahun,
						'no_urut' => '5',
						'id_modul' => 'KOREKSI PENGELOLA',
						'jenis_form_modul' => 'KOREKSI PENGELOLA',
						 );
		mysql_query(VulnWalkerInsert('ref_tahap_anggaran',$data1));

		}


	if($_REQUEST['cmbJenisAnggaran'] == "PERUBAHAN"){

			 $getDataTahap2 = mysql_num_rows(mysql_query("select * from ref_tahap_anggaran where tahun = '$tahun' and anggaran = 'PERUBAHAN'"));
				 if($getDataTahap2 == 0){
				 	$data1 = array( 'anggaran' => 'PERUBAHAN',
									'tahun' => $tahun,
									'no_urut' => '1',
									'id_modul' => '1',
									'jenis_form_modul' => 'PENYUSUNAN',
									 );
					mysql_query(VulnWalkerInsert('ref_tahap_anggaran',$data1));
				 	$data1 = array( 'anggaran' => 'PERUBAHAN',
									'tahun' => $tahun,
									'no_urut' => '2',
									'id_modul' => '2',
									'jenis_form_modul' => 'PENYUSUNAN',
									 );
					mysql_query(VulnWalkerInsert('ref_tahap_anggaran',$data1));
					$data1 = array( 'anggaran' => 'PERUBAHAN',
									'tahun' => $tahun,
									'no_urut' => '3',
									'id_modul' => '3',
									'jenis_form_modul' => 'PENYUSUNAN',
									 );
					mysql_query(VulnWalkerInsert('ref_tahap_anggaran',$data1));
					$data1 = array( 'anggaran' => 'PERUBAHAN',
									'tahun' => $tahun,
									'no_urut' => '4',
									'id_modul' => 'KOREKSI PENGGUNA',
									'jenis_form_modul' => 'KOREKSI PENGGUNA',
									 );
					mysql_query(VulnWalkerInsert('ref_tahap_anggaran',$data1));
					$data1 = array( 'anggaran' => 'PERUBAHAN',
									'tahun' => $tahun,
									'no_urut' => '5',
									'id_modul' => 'KOREKSI PENGELOLA',
									'jenis_form_modul' => 'KOREKSI PENGELOLA',
									 );
					mysql_query(VulnWalkerInsert('ref_tahap_anggaran',$data1));
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

	  case 'changeidSetting':{
	  	$id = $_REQUEST['idSetting'];
	  	$getLabel = mysql_fetch_array(mysql_query("SELECT * from setting where id = '$id' "));
	  	$content = array('label'=>$getLabel[label],'nilai'=>$getLabel[nilai],'urut'=>$getLabel[urut]);

	  	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	  break;
	  }

	  case 'SimpanData':{
	  	foreach ($_REQUEST as $key => $value) {
        $$key = $value;
       }
      $updateSetting = mysql_query("UPDATE setting set label = '".$label."', nilai = '".$nilai."', urut = '".$urut."', uid = '".$uid."', tgl_update = '".$tgl_update."' WHERE Id = '".$Id."' ");
	  	$content = $this->munculTable();

	  	break;
	  }

	  case 'jaditd':{
	  	$Id = $_REQUEST['Id'];
	  	$content = $this->munculTable();
		break;
	  }

	  case 'jadiinput':{
	  	$Id = $_REQUEST['Id'];
	  	$dataSetting = mysql_fetch_array(mysql_query("SELECT * from setting where status >= 1 and Id = '".$Id."' "));
	  	$isiTable = "
				<tr id=".$dataSetting[Id].">
					<td align='center' class='GarisDaftar'>$no</td>
					<td align='left' class='GarisDaftar'><input type='text' id='Id".$dataSetting[Id]."' value='".$dataSetting[Id]."' readonly></td>
					<td align='left' class='GarisDaftar'><input type='text' id='label".$dataSetting[Id]."' style='width: 100%;' value='".$dataSetting[label]."'></td>
					<td align='left' class='GarisDaftar'><input type='text' id='nilai".$dataSetting[Id]."' style='width: 100%;' value='".$dataSetting[nilai]."'></td>
					<td align='left' class='GarisDaftar'><input type='text' id='urut".$dataSetting[Id]."' value='".$dataSetting[urut]."' readonly></td>
					<td align='left' class='GarisDaftar'><input type='text' id='uid".$dataSetting[Id]."' value='".$_COOKIE[coID]."' readonly></td>
					<td align='left' class='GarisDaftar'><input type='text' id='tgl_update".$dataSetting[Id]."' value='".date('Y-m-d h:i:s')."' readonly></td>
					<td align='left' class='GarisDaftar'><input type='button' value='Simpan' onclick=".$this->Prefix.".SimpanData('".$dataSetting[Id]."')>&nbsp<input type='button' value='Batal' onclick=".$this->Prefix.".BatalData('".$dataSetting[Id]."')></td>
				</tr>
			";
			$content = $isiTable;
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

		case 'UbahPengaturan':{
			$fm = $this->UbahData();
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

		case 'SimpanUbah':{
			$get= $this->SimpanUbah();
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

		case 'pilihan':{
				$fm = $this->setTemplate();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
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
			"<script type='text/javascript' src='js/admin/settingDev.js' language='JavaScript' ></script>".
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
		$aqry = "SELECT * FROM  ref_satuan WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
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
		$Id = $dt['Id'];
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
	return "
";
	}

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
		  "<thead>
		   <tr>
	  	   <th class='th01' width='5' >No.</th>
	  	   $Checkbox
	  	   <th class='th01' >ID</th>
			   <th class='th01' >LABEL</th>
			   <th class='th01' >NILAI</th>
			   <th class='th01' >URUT</th>
			   <th class='th01' >UID</th>
			   <th class='th01' >TANGGAL UPDATE</th>
		   </tr>
		   </thead>";

		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;

	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  /*if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);*/
	 $Koloms[] = array('align="left" width="15%"',"<a href='javascript:".$this->Prefix.".pilihan(`".$isi['id']."`)' >".$isi['nama']."</a>");
	 $Koloms[] = array('align="right"',number_format($isi['jumlah'],0,'.',','));

	 return $Koloms;
	}

	function setMenuView(){
		return

			"";

	}

	function genFilterBarbar($Filters, $onClick, $withButton=TRUE, $TombolCaption='Tampilkan', $Style='FilterBar'){
	$Content=''; $i=0;
	while( $i < count($Filters) ){
		$border	= $i== count($Filters)-1 ? '' : "border-right:1px solid #E5E5E5;";		
		$Content.= "<td  align='left' style='padding:1 8 0 8; $border'>".
						$Filters[$i].
					"</td>";
		$i++;
	}
	//tombol
	if($withButton){
		$Content.= "<td  align='left' style='padding:1 8 0 8;'>
					<input type=button id='btTampil' value='$TombolCaption' 
						onclick=\"$onClick\">
				</td>";		
	}
		
	/*return  "
		<table class='$Style' width='100%' style='margin: 4 0 0 0' cellspacing='0' cellpadding='0' border='0'>
		<tr><td>
			<table cellspacing='0' cellpadding='0' border='0'>
			<tr valign='middle'>   						
				$Content				
			</tr>
			</table>
		</td><td width='*'>&nbsp</td></tr>		
		</table>";	*/
	return  "
		<!--<table class='$Style' width='100%' style='margin: 4 0 0 0' cellspacing='0' cellpadding='0' border='0'>
		<tr><td> -->
		<div class='$Style' >
			<table style='width:100%'><tr><td align=left>
			<table cellspacing='0' cellpadding='0' border='0' style='height:28; width: 100%;'>
			<tr valign='middle'>   						
				$Content				
			</tr>
			</table>
			</td></tr></table>
		</div>
		<!--</td><td width='*'>&nbsp</td>
		</tr>		
		</table>-->
		
		";	
}

	function genDaftarOpsi(){
	 global $Ref, $Main;

	$fmPILCARI = $_REQUEST['fmPILCARI'];
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');


	$daqry =$this->DataOption();



	if($daqry['wajib_validasi'] == '1'){
		$wajibValidasi = "YA";
	}else{
		$wajibValidasi = "TIDAK";
	}

	$jenisAnggaran = $daqry['jenis_anggaran'];
	$tahun = $daqry['tahun'];
	$provinsi = $daqry['provinsi'];
	$logo = $daqry['logo'];
	$getNamaKota = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'nama_pemda'"));
	$kota = $getNamaKota['option_value'];

	$queryTPengaturan = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan"));
	$idTPengaturan = $queryTPengaturan[Id];
	if ($queryTPengaturan[harga_atribusi] == 0) {
		$setelanOtomatis = "Tidak";
	}else{
		$setelanOtomatis = "Ya";
	}

	$TampilOpt =
			//<table width=\"100%\" class=\"adminform\">
			"<tr><td>".
			$vOrder=
			"<div id='DaftarPengaturan'>".
			$this->genFilterBarbar(
				array(

					$this->isiform(
						array(
							array(
								'label'=>'<h1>ANGGARAN</h1><hr>',
								'pemisah'=>'',
							),
							array(
								'label'=>'<b>Nama Pemda</b>',
								'name'=>'kota',
								'label-width'=>'230px;',
								'value'=>$kota,
							),
							array(
								'label'=>'<b>LOGO</b>',
								'name'=>'s',
								'label-width'=>'230px;',
								'value'=>"<img src='$logo' id='imageView' name ='imageView' style='width:150px;height:150px;'></img>",
							),

						)
					).
					$this->isiform(
						array(
							array(
								'label'=>'<h1>PENERIMAAN</h1><hr>',
								'pemisah'=>'',
							),
							array(
								'label'=>'<b>KEPADA YTH</b>',
								'pemisah'=>'',
							),
						)
					).
					$this->isiform(
						array(
							array(
								'label'=>'Nama Bidang/bagian',
								'name'=>'nama_bidang',
								'label-width'=>'210px;',
								'value'=>$queryTPengaturan['nama_bidang'],
							),
							array(
								'label'=>'Nama SKPD',
								'name'=>'nama_skpd',
								'label-width'=>'210px;',
								'value'=>$queryTPengaturan['nama_skpd'],
							),
							array(
								'label'=>'Alamat',
								'name'=>'alamat',
								'label-width'=>'210px;',
								'value'=>$queryTPengaturan['alamat'],
							),
							array(
								'label'=>'Kota/Kab',
								'name'=>'kota',
								'label-width'=>'210px;',
								'value'=>$daqry['kota'],
							),
						), "style='margin-left:20px;'"
					).
					$this->isiform(
						array(
							array(
								'label'=>'<b>TITIMANGSA SURAT</b>',
								'name'=>'titimangsa_surat',
								'label-width'=>'230px;',
								'value'=>$queryTPengaturan['titimangsa_surat'],
							),
							array(
								'label'=>'<b>NAMA APLIKASI</b>',
								'name'=>'nama_aplikasi',
								'label-width'=>'230px;',
								'value'=>$queryTPengaturan['nama_aplikasi'],
							),
							array(
								'label'=>'<b>SETELAN OTOMATIS BIAYA ATRIBUSI</b>',
								'name'=>'harga_atribusi',
								'label-width'=>'230px;',
								'value'=>$setelanOtomatis,
							),
						)
					).
					$this->isiform(
						array(
							array(
								'label'=>'<h1>PENATAUSAHAAN</h1><hr>',
								'pemisah'=>'',
							),
						)
					).
						$this->munculTable()				
					.
					// $this->isiform(
					// 	array(
					// 		array(
					// 			'label'=>'<b>ID</b>',
					// 			'name'=>'id',
					// 			'label-width'=>'230px;',
					// 			'value'=>$querySetting[Id],
					// 		),
					// 		array(
					// 			'label'=>'<b>LABEL</b>',
					// 			'name'=>'label',
					// 			'label-width'=>'230px;',
					// 			'value'=>$querySetting[label],
					// 		),
					// 		array(
					// 			'label'=>'<b>NILAI</b>',
					// 			'name'=>'nilai',
					// 			'label-width'=>'230px;',
					// 			'value'=>$querySetting[nilai],
					// 		),
					// 		array(
					// 			'label'=>'<b>URUT</b>',
					// 			'name'=>'urut',
					// 			'label-width'=>'230px;',
					// 			'value'=>$querySetting[urut],
					// 		),
					// 		array(
					// 			'label'=>'<b>UID</b>',
					// 			'name'=>'uid',
					// 			'label-width'=>'230px;',
					// 			'value'=>$_COOKIE[coID],
					// 		),
					// 		array(
					// 			'label'=>'<b>TANGGAL UPDATE</b>',
					// 			'name'=>'tanggal_update',
					// 			'label-width'=>'230px;',
					// 			'value'=>date('d-m-Y'),
					// 		),
					// 	)
					// ).
					"<table>
						<tr>
							<td>".$this->buttonnya($this->Prefix.'.UbahData()','edit_f2.png','UBAH','UBAH','UBAH')."</td>

						</tr>".
					"</table>"
				),
				'','').
				"</div>"
				;


		return array('TampilOpt'=>$TampilOpt);
	}
	function munculTable(){
		$querySetting = mysql_query("SELECT * from setting where status >= 1 order by isnull(urut), urut asc");
		$no = 1;
		while ($dataSetting = mysql_fetch_array($querySetting)) {
			$isiTable .= "
			<tbody>
				<tr id=".$dataSetting[Id].">
					<td align='center' class='GarisDaftar'>$no</td>
					<td align='left' class='GarisDaftar' id='Id'>".$dataSetting[Id]."</td>
					<td align='left' class='GarisDaftar' id='label'>".$dataSetting[label]."</td>
					<td align='left' class='GarisDaftar' id='nilai'>".$dataSetting[nilai]."</td>
					<td align='left' class='GarisDaftar' id='urut' style='width: 10%;'>".$dataSetting[urut]."</td>
					<td align='left' class='GarisDaftar' id='uid' style='width: 10%;'>".$dataSetting[uid]."</td>
					<td align='left' class='GarisDaftar' id='tgl_update' style='width: 10%;'>".$dataSetting[tgl_update]."</td>
					<td align='left' class='GarisDaftar'><input type='button' value='Edit' onclick=".$this->Prefix.".ChangeType('".$dataSetting[Id]."')></td>
				</tr>
			</tbody>
			";
			$no++;	
		}
		$table = "
					<table class='koptable' id='TablePenatausahaan'>
						<thead>
							<th class='th01' width='5' >No.</th>
	  	   			<th class='th01' style='width: 10%;'>ID</th>
	  	   			<th class='th01' >LABEL</th>
	  	   			<th class='th01' >NILAI</th>
	  	   			<th class='th01' >URUT</th>
	  	   			<th class='th01' >UID</th>
	  	   			<th class='th01' >TANGGAL UPDATE</th>
	  	   			<th class='th01' style='width: 8%;'>AKSI</th>
						</thead>".
						$isiTable
						."


						
					</table>
					";
					return $table;
	}
	function imageToBase($gambar){
				$type = pathinfo($gambar, PATHINFO_EXTENSION);
              $data = file_get_contents($gambar);
              $baseOfFile = 'data:image/' . $type . ';base64,' . base64_encode($data);
							return $baseOfFile;
	}
	function UbahData(){
		global $Ref, $Main;

		$arr_ver = array(
			//array('selectAll','Semua'),
			array('1','YA'),
			array('0','TIDAK'),
			);

		$arr_def = array(
			//array('selectAll','Semua'),
			array('1','YA'),
			array('0','TIDAK'),
			);

		$arrayJenisAnggaran = array(
			array('MURNI','MURNI'),
			array('PERUBAHAN','PERUBAHAN'),
			);


		$daqry = $this->DataOption();
		$tahun = $daqry['tahun'];
		$provinsi = $daqry['provinsi'];
		$getNamaKota = mysql_fetch_array(mysql_query("select * from general_setting where option_name = 'nama_pemda'"));
		$kota = $getNamaKota['option_value'];
		$fileLocation = $daqry['logo'];
		$siteImage = $this->imageToBase($fileLocation);

		$queryTPengaturan = mysql_fetch_array(mysql_query("SELECT * from t_pengaturan"));
		$idTPengaturan = $queryTPengaturan[Id];

		if ($queryTPengaturan[harga_atribusi] == 0) {
			$setelanOtomatis = 0;
		}else{
			$setelanOtomatis = 1;
		}

		$queryIdSetting = mysql_fetch_array(mysql_query("SELECT * from setting where status >= 1 order by isnull(urut), urut asc"));
		$queryLabelSetting = mysql_fetch_array(mysql_query("SELECT * from setting where id = '' "));

		$cek='';$err='';
		$content =
			genFilterBar(
				array(

					$this->isiform(
						array(

							array(
								'label'=>'<h1>ANGGARAN</h1>',
								'pemisah'=>'',
							),
							array(
								'label'=>'<b>Nama Pemda</b>',
								'name'=>'kota',
								'label-width'=>'230px;',
								'value'=>"<input type ='text' id='kota' name='kota' value='$kota' style='width:200px;'>",
							),
							array(
								'label'=>'<b>Logo</b>',
								'name'=>'Logo',
								'label-width'=>'230px;',
								'value'=>"<img src='$fileLocation' id='imageView' name ='imageView' style='width:150px;height:150px;'></img><br><br>
								<input type='file' accept='image/x-png,image/gif,image/jpeg' onchange=$this->Prefix.imageChanged(); id='imageFile' name='imageFile'> <input type='hidden' id='siteImage' name='siteImage' value='$siteImage' >",
							),

						)
					).
					$this->isiform(
						array(
							array(
								'label'=>'<h1>PENERIMAAN</h1>',
								'pemisah'=>'',
							),
							array(
								'label'=>'<b>KEPADA YTH</b>',
								'pemisah'=>'',
							),
						)
					).						
					$this->isiform(
						array(
							array(
								'label'=>'Nama Bidang/bagian',
								'name'=>'nama_bidang',
								'label-width'=>'210px;',
								'value'=>"<input type='text' id='bidang' name='bidang' value='$queryTPengaturan[nama_bidang]' style='width: 200px;'> ",
							),
							array(
								'label'=>'Nama SKPD',
								'name'=>'nama_skpd',
								'label-width'=>'210px;',
								'value'=>"<input type='text' id='namaSKPD' name='namaSKPD' value='$queryTPengaturan[nama_skpd]' style='width: 200px;'>",
							),
							array(
								'label'=>'Alamat',
								'name'=>'alamat',
								'label-width'=>'210px;',
								'value'=>"<input type='text' id='alamat' name='alamat' value='$queryTPengaturan[alamat]' style='width: 200px;'>",
							),
							array(
								'label'=>'Kota/Kab',
								'name'=>'kota',
								'label-width'=>'210px;',
								'value'=>"<input type='text' id='kotakab' name='kotakab' value='$daqry[kota]' style='width: 200px;'>",
							),
						), "style='margin-left:20px;'"
					).
					$this->isiform(
						array(
							array(
								'label'=>'<b>TITIMANGSA SURAT</b>',
								'name'=>'titimangsa_surat',
								'label-width'=>'230px;',
								'value'=>"<input type='text' id='titimangsa' name='titimangsa' value='$queryTPengaturan[titimangsa_surat]' style='width: 200px;'>",
							),
							array(
								'label'=>'<b>NAMA APLIKASI</b>',
								'name'=>'nama_aplikasi',
								'label-width'=>'230px;',
								'value'=>"<input type='text' id='namaAplikasi' name='namaAplikasi' value='$queryTPengaturan[nama_aplikasi]' style='width: 200px;'>",
							),
							array(
								'label'=>'<b>SETELAN OTOMATIS BIAYA ATRIBUSI</b>',
								'name'=>'harga_atribusi',
								'label-width'=>'230px;',
								'value'=>cmbArray('def_atrib',$setelanOtomatis, $arr_def,'--- PILIH ---',"style='width:200px;'"),
							),
						)
					).
					// $this->isiform(
					// 	array(
					// 		array(
					// 			'label'=>'<h1>PENATAUSAHAAN</h1><hr>',
					// 			'pemisah'=>'',
					// 		),
					// 	)
					// ).
					// $this->isiform(
					// 	array(
					// 		array(
					// 			'label'=>'<b>ID</b>',
					// 			'name'=>'id',
					// 			'label-width'=>'230px;',
					// 			'value'=>cmbQuery('idSetting',$queryIdSetting[id], 'SELECT id,id from setting where status >= 1 order by isnull(urut), urut asc','onchange="'.$this->Prefix.'.changeidSetting();" ','--- PILIH ---'),
					// 		),
					// 		array(
					// 			'label'=>'<b>LABEL</b>',
					// 			'name'=>'label',
					// 			'label-width'=>'230px;',
					// 			'value'=>"<input type='text' readonly='readonly' id='labelSetting' name='labelSetting' value='$queryLabelSetting[label]' style='width: 200px;'>",
					// 		),
					// 		array(
					// 			'label'=>'<b>NILAI</b>',
					// 			'name'=>'nilai',
					// 			'label-width'=>'230px;',
					// 			'value'=>"<input type='text' readonly='readonly' id='nilaiSetting' name='nilaiSetting' value='$queryLabelSetting[nilai]' style='width: 200px;'>",
					// 		),
					// 		array(
					// 			'label'=>'<b>URUT</b>',
					// 			'name'=>'urut',
					// 			'label-width'=>'230px;',
					// 			'value'=>"<input type='text' readonly='readonly' id='urutSetting' name='urutSetting' value='$queryLabelSetting[urut]' style='width: 200px;'>",
					// 		),
					// 		array(
					// 			'label'=>'<b>UID</b>',
					// 			'name'=>'uid',
					// 			'label-width'=>'230px;',
					// 			'value'=>"<input type='text' readonly='readonly' id='uidSetting' name='uidSetting' value='".$_COOKIE[coID]."' style='width: 200px;'>",
					// 		),
					// 		array(
					// 			'label'=>'<b>TANGGAL UPDATE</b>',
					// 			'name'=>'tanggal_update',
					// 			'label-width'=>'230px;',
					// 			'value'=>"<input type='text' readonly='readonly' id='tglSetting' name='tglSetting' value='".date('d-m-Y')."' style='width: 200px;'>",
					// 		),
					// 	)
					// ).
					"
					<input type='hidden' name='IDNYA' id='IDNYA' value='".$daqry['Id']."'/>
					<table>
						<tr>
							<td>".$this->buttonnya($this->Prefix.'.SimpanUbahData()','save_f2.png','SIMPAN','SIMPAN','SIMPAN')."</td>
							<td>".$this->buttonnya($this->Prefix.'.loading()','cancel_f2.png','BATAL','BATAL','BATAL')."</td>
						</tr>".
					"</table>"
				),
				'','')
				;

		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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


		if($fmPILCARIvalue !='')$arrKondisi[] = " nama like '%$fmPILCARIvalue%' ";
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();

		/*if($fmORDER1 == ''){
			$arrOrders[] = " bk ";
			$arrOrders[] = " ck ";
			$arrOrders[] = " dk ";
			$arrOrders[] = " p ";
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

	/*function setTopBar(){
	   	return '';
	}	*/

	function DataOption(){
		global $Main, $HTTP_COOKIE_VARS;
		$qry = "SELECT * FROM $this->TblName ";
		$aqry = mysql_query($qry);

		$data = mysql_fetch_array($aqry);

		return $data;
	}

	function VPenerima_det(){
		$Data = $this->DataOption();
		if($Data['skpd'] == '1'){
			$tbl = 'v_penerimaan_barang_det';
		}else{
			$tbl = 'v1_penerimaan_barang_det';
		}

		return $tbl;
	}

	function isiform($value, $parram=''){
		$isinya = '';
		$tbl ='<table width="100%" '.$parram.'>';
		for($i=0;$i<count($value);$i++){
			if(!isset($value[$i]['align']))$value[$i]['align'] = "left";
			if(!isset($value[$i]['valign']))$value[$i]['valign'] = "top";

			if(isset($value[$i]['type'])){
				switch ($value[$i]['type']){
					case "text" :
						$isinya = "<input type='text' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
					break;
					case "hidden" :
						$isinya = "<input type='hidden' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
					break;
					case "password" :
						$isinya = "<input type='password' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
					break;
					default:
						$isinya = $value[$i]['value'];
					break;
				}
			}else{
				$isinya = $value[$i]['value'];
			}

			$pemisah = ':';
			if(isset($value[$i]['pemisah']))$pemisah = $value[$i]['pemisah'];

			if ($value[$i]['label'] == "<h1>ANGGARAN</h1><hr>") {
				$tbl .= "
				<tr>
					<td width='".$value[$i]['label-width']."' valign='top' colspan='3'>".$value[$i]['label']."</td>
					<td width='10px' valign='top'>$pemisah<br></td>
					<td align='".$value[$i]['align']."' valign='".$value[$i]['valign']."'> $isinya</td>
				</tr>
			";
			}elseif ($value[$i]['label'] == "<h1>PENERIMAAN</h1><hr>") {
				$tbl .= "
				<tr>
					<td width='".$value[$i]['label-width']."' valign='top' colspan='3'>".$value[$i]['label']."</td>
					<td width='10px' valign='top'>$pemisah<br></td>
					<td align='".$value[$i]['align']."' valign='".$value[$i]['valign']."'> $isinya</td>
				</tr>
			";
			}elseif ($value[$i]['label'] == "<h1>PENATAUSAHAAN</h1><hr>") {
				$tbl .= "
				<tr>
					<td width='".$value[$i]['label-width']."' valign='top' colspan='3'>".$value[$i]['label']."</td>
					<td width='10px' valign='top'>$pemisah<br></td>
					<td align='".$value[$i]['align']."' valign='".$value[$i]['valign']."'> $isinya</td>
				</tr>
			";
			}else{
				$tbl .= "
				<tr>
					<td width='".$value[$i]['label-width']."' valign='top'>".$value[$i]['label']."</td>
					<td width='10px' valign='top'>$pemisah<br></td>
					<td align='".$value[$i]['align']."' valign='".$value[$i]['valign']."'> $isinya</td>
				</tr>
			";
			}
			// $tbl .= "
			// 	<tr>
			// 		<td width='".$value[$i]['label-width']."' valign='top'>".$value[$i]['label']."</td>
			// 		<td width='10px' valign='top'>$pemisah<br></td>
			// 		<td align='".$value[$i]['align']."' valign='".$value[$i]['valign']."'> $isinya</td>
			// 	</tr>
			// ";
		}
		$tbl .= '</table>';

		return $tbl;
	}

	function buttonnya($js,$img,$name,$alt,$judul){
		return "<table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
					<tbody><tr valign='middle' align='center'>
					<td class='border:none'>
						<a class='toolbar' id='btsave'
							href='javascript:$js'>
						<img src='images/administrator/images/$img' alt='$alt' name='$name' width='32' height='32' border='0' align='middle' title='$judul'> $judul</a>
					</td>
					</tr>
					</tbody></table> ";
	}

	function pageShow(){
		global $app, $Main;

		$navatas_ = $this->setNavAtas();
		$navatas = $navatas_==''? // '0': '20';
			'':
			"<tr><td height='20'>".
					$navatas_.
			"</td></tr>";

		$form1 = $this->withform? "<form name='$this->FormName' id='$this->FormName' method='post' action=''>" : '';
		$form2 = $this->withform? "</form >": '';

		if(!isset($_REQUEST['halman']))$_REQUEST['halman']='1';
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
//

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
			"</table>

			".
			/*'<script src="assets2/js/bootstrap.min.js"></script>'.
			'<script src="assets2/jquery.min.js"></script>'.*/
			"</body>
		</html>";
	}


	function QyrTmpl1Brs($tablenya, $field='*',$where = '') {
		$qry = "SELECT $field FROM $tablenya $where";
		$aqry = mysql_query($qry);
		$hasil = mysql_fetch_array($aqry);

		return array('hasil'=>$hasil, 'cek'=>$qry);
	}

	function QryHitungData($tablenya, $where = ''){
		$qry = "SELECT * FROM $tablenya $where";
		$aqry = mysql_query($qry);
		$hasil = mysql_num_rows($aqry);

		return array('hasil'=>$hasil, 'cek'=>$qry);
	}

	function QryInsData($tbl, $values){
		$cek='';
		$field = '';
		$isifield = '';
		$errmsg = '';
		for($i=0;$i<count($values);$i++){
			if($i != 0){
				$field .= ',';
				$isifield .= ', ';
			}
			$field .= $values[$i][0];
			$isifield .= "'".$values[$i][1]."'";
		}

		$qry = "INSERT INTO $tbl ($field) values ($isifield)";$cek.=$qry;
		$aqry = mysql_query($qry);

		if(!$aqry)$errmsg = mysql_error();

		return array('hasil'=>$aqry, 'cek'=>$qry, 'errmsg'=>$errmsg);
	}

	function QryUpdData($tbl, $values, $where){
		$cek='';
		$isifield = '';
		for($i=0;$i<count($values);$i++){
			if($i != 0){
				$isifield .= ',';
			}
			$isifield .= $values[$i][0]."='".$values[$i][1]."'";
		}

		$qry = "UPDATE $tbl SET $isifield $where ";$cek.=$qry;
		$aqry = mysql_query($qry);

		if(!$aqry)$errmsg = mysql_error();

		return array('hasil'=>$aqry, 'cek'=>$qry, 'errmsg'=>$errmsg);
	}

	function HargaPerolehanAtribusi($idTerima,$idTerima_det){
		$qry_cek_pendet = $this->QyrTmpl1Brs("t_penerimaan_barang_det", "harga_total", "WHERE Id='$idTerima_det' AND refid_terima='$idTerima' AND barangdistribusi='1' " );
		$aqry_cek_pendet = $qry_cek_pendet['hasil'];

		$qry_cek_distri = $this->QyrTmpl1Brs("t_distribusi", "SUM(jumlah) as jumlah", "WHERE refid_penerimaan_det='$idTerima_det' AND refid_terima='$idTerima' AND status='1' ");
		$aqry_cek_distri = $qry_cek_distri['hasil'];


	  	//Harga Perolehan Barang
	 	$tot_pmlhrn = $this->QyrTmpl1Brs("t_penerimaan_barang_det", "IFNULL(SUM(harga_total),0) as harga_total", "WHERE refid_terima='".$idTerima."' AND sttemp='0' AND barangdistribusi='1' ");
	 	$qry_pmlhrn = $tot_pmlhrn['hasil'];//$hsl = $tot_pmlhrn['cek'];

	 	$tot_attribusi = $this->QyrTmpl1Brs("t_atribusi_rincian", "IFNULL(SUM(jumlah),0) as tot_atr", "WHERE refid_terima='".$idTerima."' AND sttemp='0' ");
		 $qry_tot_attr = $tot_attribusi['hasil'];$hsl = $tot_attribusi['cek'];

	 //Hitung Harga Perolehan -------------------------------------------------------------------------------------------
	 //$hrg_perolehan = (($dt['harga_total']/$qry_pmlhrn['harga_total'])*$qry_tot_attr['tot_atr'])+$dt['harga_total'];
	 	$hrg1brg = round(intval($aqry_cek_pendet['harga_total']));
	 	$hrg_tot_bar = round(intval($qry_pmlhrn['harga_total']));

	 	$hrg = @($hrg1brg/$hrg_tot_bar);
	 	$hrg_perolehan = round(($hrg*$qry_tot_attr['tot_atr'])+$aqry_cek_pendet['harga_total']);

		return $hrg_perolehan;
	}

	function CekBiayaAtribusi($Idplh){
		$err = '';
		$qry_Penerimaan = $this->QyrTmpl1Brs("t_penerimaan_barang", "*", " WHERE Id='$Idplh'" );
		$daqry_Penerimaan = $qry_Penerimaan['hasil'];

		if($daqry_Penerimaan['biayaatribusi'] == '1'){
			$aqry_attribusi = $this->QryHitungData("t_atribusi", "WHERE refid_terima='$Idplh' AND sttemp='0'");

			if($aqry_attribusi['hasil'] < 1)$err = "Biaya Atribusi Belum Di Masukan !";
		}

		return $err;


	}

	function AmbilUraianBarang($IdBI){

		$qry = "SELECT * FROM buku_induk WHERE id='$IdBI'";
		$daqry = mysql_query($qry);
		$dt=mysql_fetch_array($daqry);

		$wherenya = "WHERE idbi='$IdBI' ";
		$content = $qry;

		$ada_alm = '';
		$ada_alm .= ($dt['rt'] && $dt['rw']) == ''? '' : '<br>RT/RW. '.$dt['rt'].'/'.$dt['rw'];
		$ada_alm .= $dt['kampung'] == ''? '' : '<br>Kp/Komp. '.$dt['kampung'];

		switch($dt['f']){
			case "01":
				$data_kib = "SELECT * FROM view_kib_a $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));

				$alm = '';
				$alm .= ifempty($qry_data_kib['alamat'],'-');
				$alm .= $ada_alm;
				$alm .= $qry_data_kib['alamat_kel'] != ''? '<br>Kel/Desa. '.$qry_data_kib['alamat_kel'] : '';
				$alm .= $qry_data_kib['alamat_kec'] != ''? '<br>Kec. '.$qry_data_kib['alamat_kec'] : '';
				$alm .= $qry_data_kib['alamat_kota'] != ''? '<br>'.$qry_data_kib['alamat_kota'] : '';

			break;
			case "02":
				$data_kib = "SELECT * FROM view_kib_b $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));

				$qry_data_kib = array_map('utf8_encode', $qry_data_kib);
				$alm = $qry_data_kib['merk'];
				$alm .= $alm == ''?$qry_data_kib['ket'] : '';

			break;
			case "03":
				$data_kib = "SELECT * FROM view_kib_c $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));

				$alm = '';
				$alm .= ifempty($qry_data_kib['alamat'],'-');
				$alm .= $ada_alm;
				$alm .= $qry_data_kib['alamat_kel'] != ''? '<br>Kel/Desa. '.$qry_data_kib['alamat_kel'] : '';
				$alm .= $qry_data_kib['alamat_kec'] != ''? '<br>Kec. '.$qry_data_kib['alamat_kec'] : '';
				$alm .= $qry_data_kib['alamat_kota'] != ''? '<br>'.$qry_data_kib['alamat_kota'] : '';

			break;
			case "04":
				$data_kib = "SELECT * FROM view_kib_d $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));

				$alm = '';
				$alm .= ifempty($qry_data_kib['alamat'],'-');
				$alm .= $ada_alm;
				$alm .= $qry_data_kib['alamat_kel'] != ''? '<br>Kel/Desa. '.$qry_data_kib['alamat_kel'] : '';
				$alm .= $qry_data_kib['alamat_kec'] != ''? '<br>Kec. '.$qry_data_kib['alamat_kec'] : '';
				$alm .= $qry_data_kib['alamat_kota'] != ''? '<br>'.$qry_data_kib['alamat_kota'] : '';
			break;
			case "05":
				$data_kib = "SELECT * FROM view_kib_e $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));

				$alm = $qry_data_kib['ket'] != ''? $qry_data_kib['ket'] : '-';


			break;
			case "06":
				$data_kib = "SELECT * FROM view_kib_f $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));

				$alm = '';
				$alm .= ifempty($qry_data_kib['alamat'],'-');
				$alm .= $ada_alm;
				$alm .= $qry_data_kib['alamat_kel'] != ''? '<br>Kel/Desa. '.$qry_data_kib['alamat_kel'] : '';
				$alm .= $qry_data_kib['alamat_kec'] != ''? '<br>Kec. '.$qry_data_kib['alamat_kec'] : '';
				$alm .= $qry_data_kib['alamat_kota'] != ''? '<br>'.$qry_data_kib['alamat_kota'] : '';

			break;
			case "07":
				$data_kib = "SELECT * FROM view_kib_g $wherenya ";
				$qry_data_kib = mysql_fetch_array(mysql_query($data_kib));

				$alm = $qry_data_kib['ket'] != ''? $qry_data_kib['ket'] : '-';
			break;
		}


		return $alm;

	}


}
$settingDev = new settingDevObj();
?>
