<?php
class pengeluaranPersediaan_insObj  extends DaftarObj2{
	var $Prefix = 'pengeluaranPersediaan_ins';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_penerimaan_barang'; //bonus
	var $TblName_Hapus = 't_penerimaan_barang';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 2;
	var $PageTitle = 'PENGELUARAN';
	var $PageIcon = 'images/perencanaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='renja.xls';
	var $namaModulCetak='PERENCANAAN';
	var $Cetak_Judul = 'PENGELUARAN';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'pengeluaranPersediaan_insForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0
	var $modul = "PENGELUARAN";
	var $jenisForm = "";
	var $tahun = "";
	var $nomorUrut = "";
	var $jenisAnggaran = "";
	var $idTahap = "";

	function setTitle(){
	    $id = $_REQUEST['ID_PLAFON'];
	    $getTahun = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id'"));
		return 'PENGELUARAN' ;
	}

	function setMenuEdit(){
		return "";

	}

	function setMenuView(){
		return "";
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

		case 'getYearRange':{
			$yearRange = $_COOKIE['coThnAnggaran'] - date("Y");
			$content = array(
												'yearRange' => $yearRange.":".$yearRange
			);
		break;
		}
		case 'formBaru':{
			$fm = $this->setFormBaru();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}


		case 'hapus':{
			$content = array("test" => 'test');
		break;
		}

		case 'newPenyerah':{
			$fm = $this->newPenyerah();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editPenyerah':{
			$fm = $this->editPenyerah($_REQUEST['idEdit']);
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'saveNewPenyerah':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}
			if(empty($namaPenyerah)){
					$err = "Isi nama yang menyerahkan !";
			}elseif(empty($jabatanPenyerah)){
					$err = "Isi jabatan yang menyerahkan !";
			}elseif(empty($nipPenyerah)){
					$err = "Isi NIP yang menyerahkan !";
			}

			if(empty($err)){
					$data = array(
													'nama'=> $namaPenyerah,
													'jabatan'=> $jabatanPenyerah,
													'nip'=> $nipPenyerah,
							);
					$query = VulnWalkerInsert("ref_penyerah_pengeluaran",$data);
					mysql_query($query);
					$getMaxID = mysql_fetch_array(mysql_query("select max(id) from ref_penyerah_pengeluaran"));
					$comboYangMenyerahkan = cmbQuery('yangMenyerahkan', $getMaxID['max(id)'], "select id, nama from ref_penyerah_pengeluaran","",'-- YANG MENYERAHKAN --');
					$content = array('yangMenyerahkan' => $comboYangMenyerahkan);
			}

		break;
		}
		case 'saveEditPenyerah':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}
			if(empty($namaPenyerah)){
					$err = "Isi nama yang menyerahkan !";
			}elseif(empty($jabatanPenyerah)){
					$err = "Isi jabatan yang menyerahkan !";
			}elseif(empty($nipPenyerah)){
					$err = "Isi NIP yang menyerahkan !";
			}

			if(empty($err)){
					$data = array(
													'nama'=> $namaPenyerah,
													'jabatan'=> $jabatanPenyerah,
													'nip'=> $nipPenyerah,
							);
					$query = VulnWalkerUpdate("ref_penyerah_pengeluaran",$data,"id = '$idEdit'");
					mysql_query($query);
					$comboYangMenyerahkan = cmbQuery('yangMenyerahkan', $idEdit, "select id, nama from ref_penyerah_pengeluaran","",'-- YANG MENYERAHKAN --');
					$content = array('yangMenyerahkan' => $comboYangMenyerahkan);
			}

		break;
		}
		case 'deletePenyerah':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}


			if(empty($err)){
					mysql_query("delete from ref_penyerah_pengeluaran where id = '$idEdit'");
					$comboYangMenyerahkan = cmbQuery('yangMenyerahkan', $sad, "select id, nama from ref_penyerah_pengeluaran","",'-- YANG MENYERAHKAN --');
					$content = array('yangMenyerahkan' => $comboYangMenyerahkan);
			}

		break;
		}


		case 'addBarang':{

			$cek = '';
			$err = '';
			$content =array('tabelBarang' => $this->addBarang());
		break;
		}
		case 'editBarang':{

			$cek = '';
			$err = '';
			$content =array('editBarang' => $this->editBarang($_REQUEST['id']));
		break;
		}
		case 'cancelBarang':{

			$cek = '';
			$err = '';
			$content =array('tabelBarang' => $this->tabelBarang());
		break;
		}
		case 'saveNewBarang':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}

			if(empty($kodeBarang)){
				$err = "Pilih Barang";
			}elseif(empty($jumlahBarang)){
				$err = "Isi Jumlah Barang";
			}elseif(empty($merk)){
				$err = "Isi MERK/ TYPE/ SPESIFIKASI";
			}
			// elseif(mysql_num_rows(mysql_query("select * from temp_pengeluaran where concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1) ='$kodeBarang' and username = '$this->username'"))){
			// 	$err = "Barang sudah ada";
			// }
			if(empty($err)){
					$explodeKodeBarang = explode(".",$kodeBarang);
					$f1 = $explodeKodeBarang[0];
					$f2 = $explodeKodeBarang[1];
					$f = $explodeKodeBarang[2];
					$g = $explodeKodeBarang[3];
					$h = $explodeKodeBarang[4];
					$i = $explodeKodeBarang[5];
					$j = $explodeKodeBarang[6];
					$j1 = $explodeKodeBarang[7];
					$data = array(
												'f1' => $f1,
												'f2' => $f2,
												'f' => $f,
												'g' => $g,
												'h' => $h,
												'i' => $i,
												'j' => $j,
												'j1' => $j1,
												'jumlah' => $jumlahBarang,
												'keterangan' => $keterangan,
												'merk' => $merk,
												'username' => $this->username,
												);
					$query = VulnWalkerInsert('temp_pengeluaran',$data);
					mysql_query($query);
					$cek = $query;
			}

			$content =array('tabelBarang' => $this->tabelBarang());
		break;
		}
		case 'gandakanBarang':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}

			if(empty($err)){
					$getDataBarang = mysql_fetch_array(mysql_query("select * from temp_pengeluaran where id = '$id'"));
					foreach ($getDataBarang as $key => $value) {
						 	 $$key = $value;
					}
					$data = array(
												'f1' => $f1,
												'f2' => $f2,
												'f' => $f,
												'g' => $g,
												'h' => $h,
												'i' => $i,
												'j' => $j,
												'j1' => $j1,
												'jumlah' => $jumlah,
												'keterangan' => $keterangan,
												'merk' => $merk,
												'username' => $this->username,
												);
					$query = VulnWalkerInsert('temp_pengeluaran',$data);
					mysql_query($query);
					$cek = $query;
			}

			$content =array('tabelBarang' => $this->tabelBarang());
		break;
		}
		case 'saveEditBarang':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}

			if(empty($kodeBarang)){
				$err = "Pilih Barang";
			}elseif(empty($jumlahBarang)){
				$err = "Isi Jumlah Barang";
			}elseif(empty($merk)){
				$err = "Isi MERK/ TYPE/ SPESIFIKASI";
			}
			if(empty($err)){
					$explodeKodeBarang = explode(".",$kodeBarang);
					$f1 = $explodeKodeBarang[0];
					$f2 = $explodeKodeBarang[1];
					$f = $explodeKodeBarang[2];
					$g = $explodeKodeBarang[3];
					$h = $explodeKodeBarang[4];
					$i = $explodeKodeBarang[5];
					$j = $explodeKodeBarang[6];
					$j1 = $explodeKodeBarang[7];
					$data = array(
												'f1' => $f1,
												'f2' => $f2,
												'f' => $f,
												'g' => $g,
												'h' => $h,
												'i' => $i,
												'j' => $j,
												'j1' => $j1,
												'jumlah' => $jumlahBarang,
												'merk' => $merk,
												'keterangan' => $keterangan,
												'username' => $this->username,
												);
					$query = VulnWalkerUpdate('temp_pengeluaran',$data,"id = '$id'");
					mysql_query($query);
					$cek = $query;
			}

			$content =array('tabelBarang' => $this->tabelBarang());
		break;
		}
		case 'deleteBarang':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}
			$getData = mysql_fetch_array(mysql_query("select * from temp_pengeluaran where id = '$id'"));
			$data = array("username" => $this->username, 'id_pengeluaran' => $getData['id_pengeluaran'] );
			mysql_query(VulnWalkerInsert("delete_temp_pengeluaran",$data));
			mysql_query("delete from temp_pengeluaran where id = '$id'");
			$content =array('tabelBarang' => $this->tabelBarang());
		break;
		}
		case 'savePengeluaran':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}
			if(empty($tanggalPengeluaran)){
					$err = "Isi tanggal persediaan";
			}elseif(empty($untukKeperluan)){
					$err = "Isi keperluan";
			}elseif(empty($yangMenyerahkan)){
					$err = "Pilih yang menyerahkan";
			}elseif(substr($tanggalPengeluaran, -4) !=$_COOKIE['coThnAnggaran']){
					$err = "Tahun harus sama dengan tahun login";
			}

			if(empty($err)){
						$dataPengeluaran = array(
										'tanggal' => $this->generateDate($tanggalPengeluaran),
										'bk' => $bk,
										'ck' => $ck,
										'dk' => $dk,
										'p' => $p,
										'q' => $q,
										'keperluan' => $untukKeperluan,
										'yang_menyerahkan' => $yangMenyerahkan,
										'status_temp' => "0",
						);
						$query = VulnWalkerUpdate("pengeluaran",$dataPengeluaran,"nomor = '$nomorPengeluaran'");
						mysql_query($query);
						$getDataPengeluaran = mysql_fetch_array(mysql_query("select * from pengeluaran where nomor = '$nomorPengeluaran'"));

						$getAllDeletedID = mysql_query("select * from delete_temp_pengeluaran where username = '$this->username'");
						while ($removeID = mysql_fetch_array($getAllDeletedID)) {
								mysql_query("delete from detail_pengeluaran where id = '".$removeID['id_pengeluaran']."' ");
						}

						$getAllTemp = mysql_query("select * from temp_pengeluaran where username = '$this->username'");
						while ($dataBarang = mysql_fetch_array($getAllTemp)) {
								foreach ($dataBarang as $key => $value) {
										 $$key = $value;
								}
								$dataDetailPengeluaran = array(
											'f1' => $f1,
											'f2' => $f2,
											'f' => $f,
											'g' => $g,
											'h' => $h,
											'i' => $i,
											'j' => $j,
											'j1' => $j1,
											'jumlah' => $jumlah,
											'merk' => $merk,
											'keterangan' => $keterangan,
											'id_pengeluaran' => $getDataPengeluaran['id']
								);
								if(mysql_num_rows(mysql_query("select * from detail_pengeluaran where id = '$id_pengeluaran'")) != 0){
										$query = VulnWalkerUpdate("detail_pengeluaran",$dataDetailPengeluaran,"id = '$id_pengeluaran'");
								}else{
										$query = VulnWalkerInsert("detail_pengeluaran",$dataDetailPengeluaran);
								}
								mysql_query($query);

								$cek.= $query;

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

	 }

		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }



   function setPage_OtherScript(){
		$scriptload =
					"<script>
						$(document).ready(function(){
							".$this->Prefix.".loading();
							setTimeout(function myFunction() {".$this->Prefix.".setDatePicker()},1000);
						});


					</script>";
		return

			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/persediaan/pengeluaran/pengeluaranPersediaan_ins.js' language='JavaScript' ></script>".
			"
			<script type='text/javascript' src='js/persediaan/popupProgram.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/persediaan/popupProgramREF.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/rka/popupBarangPersediaan.js' language='JavaScript' ></script>

			".

			'
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>

			'.
			$scriptload;
	}

	//form ==================================

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
	  	   <th class='th01' width='5' rowspan='2'>No.</th>
	  	   $Checkbox
		   <th class='th01' rowspan='2'>TANGGAL BAST/ BUKU</th>
		   <th class='th01' rowspan='2'>NO BAST/ID PENERIMAAN</th>
		   <th class='th02' colspan='2'>DOKUMEN SUMBER</th>
		   <th class='th01' rowspan='2'>SUMBER DANA/ KODE AKUN / PENYEDIA BARANG</th>
		   <th class='th01' rowspan='2'>NAMA BARANG</th>
		   <th class='th01' rowspan='2'>MERK / TYPE/ SPESIFIKASI/ LOKASI</th>
		   <th class='th01' rowspan='2'>JUMLAH</th>
		   <th class='th01' rowspan='2'>HARGA SATUAN</th>
		   <th class='th01' rowspan='2'>JUMLAH HARGA</th>
		   <th class='th01' rowspan='2'>HARGA ATRIBUSI</th>
		   <th class='th01' rowspan='2'>HARGA PEROLEHAN</th>
		   <th class='th01' rowspan='2'>ADA ATRIBUSI</th>
		   <th class='th02' colspan='2'>DISTRIBUSI</th>
		   <th class='th01' rowspan='2'>VALIDASI</th>
		   <th class='th01' rowspan='2'>POSTING</th>
		   <th class='th01' rowspan='2'>KET.</th>
	   </tr>
	   <tr>
	   		<th class='th01'>DOKUMEN</th>
	   		<th class='th01'>TANGGAL DAN NOMOR</th>
	   		<th class='th01'>Y/T</th>
	   		<th class='th01'>SESUAI</th>
	   </tr>
	   </thead>";

		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;

	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$isi['tgl_buku']."<br>".$isi['tgl_bast']);
	 $Koloms[] = array('align="left"',$isi['no_bast']."/".$isi['id_penerimaan']);
	 $Koloms[] = array('align="left"',$isi['id_dok_sumber']);
	 $Koloms[] = array('align="left"',$isi['nomor_dok']);
	 $Koloms[] = array('align="left"',$isi['sumber_dana']."<br>".$isi['ka'].".".$isi['kb'].".".$isi['kc'].".".$isi['kd'].".".$isi['ke'].".".$isi['kf']."<br>".$isi['id_penyedia']);
	 $Koloms[] = array('align="left"',"Nama Barang");
	 $Koloms[] = array('align="left"',"Keterangan Barang");
	 $Koloms[] = array('align="left"',"Jumlah");
	 $Koloms[] = array('align="left"',"Harga Satuan");
	 $Koloms[] = array('align="left"',"Jumlah Harga");
	 $Koloms[] = array('align="left"',"Harga Atribusi");
	 $Koloms[] = array('align="left"',"Harga Perolehan");
	 $Koloms[] = array('align="left"',"ada atribusi");
	 $Koloms[] = array('align="left"',"");
	 $Koloms[] = array('align="left"',"");
	 $Koloms[] = array('align="left"',"");
	 $Koloms[] = array('align="left"',"");
	 $Koloms[] = array('align="left"',"");
	 return $Koloms;
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

		$cbid = $_REQUEST['pemasukan_cb'];
		 setcookie("coUrusanProgram", "", time()-3600);
		 setcookie('coBidangProgram', "", time()-3600);
		 unset($_COOKIE['coProgram']);

		return


		"<html>".
			$this->genHTMLHead().
			"<body >".
			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0' width='100%' height='100%' >".
				"<tr height='34'><td>".
					$this->setPage_Header().
					"<div id='header' ></div>".
				"</td></tr>".
				$navatas.
				"<tr height='*' valign='top'> <td >".

					$this->setPage_HeaderOther().
					"<div align='center' class='centermain' >".
					"<div class='main' >".
					$form1.
					"
					<input type='hidden' name='kodeSKPD' id='kodeSKPD' value='".$_REQUEST['skpd']."' >
					<input type='hidden' name='nomorPengeluaran' id='nomorPengeluaran' value='".$_REQUEST['nomor']."' >
					".

						$this->setPage_Content().

					$form2.
					"</div></div>".
				"</td></tr>".
				"<tr><td height='29' >".
					$Main->CopyRight.
				"</td></tr>".
				$OtherFooterPage.
			"</table>".
			"</body>
		</html>";
	}

	function genDaftarOpsi(){
	 global $Ref, $Main, $HTTP_COOKIE_VARS;

	 foreach ($_REQUEST as $key => $value) {
			 $$key = $value;
	 }

	 $explodeKodeSKPD = explode(".",$kodeSKPD);
	 $c1 = $explodeKodeSKPD[0];
	 $c = $explodeKodeSKPD[1];
	 $d = $explodeKodeSKPD[2];
	 $e = $explodeKodeSKPD[3];
	 $e1 = $explodeKodeSKPD[4];

	 $getNamaUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1= '$c1' and c='00'"));
	 $namaUrusan = $getNamaUrusan['nm_skpd'];
	 $getNamaBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1= '$c1' and c='$c' and d='00'"));
	 $namaBidang = $getNamaBidang['nm_skpd'];
	 $getNamaSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1= '$c1' and c='$c' and d='$d' and e='00'"));
	 $namaSKPD = $getNamaSKPD['nm_skpd'];
	 $getUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
	 $namaUnit = $getUnit['nm_skpd'];
	 $getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
	 $namaSubUnit = $getSubUnit['nm_skpd'];




	$getDataPengeluaran = mysql_fetch_array(mysql_query("select * from pengeluaran where nomor = '$nomorPengeluaran'"));
	$tanggalPengeluaran = $this->generateDate($getDataPengeluaran['tanggal']);
	$bk = $getDataPengeluaran['bk'];
	$ck = $getDataPengeluaran['ck'];
	$dk = $getDataPengeluaran['dk'];
	$p = $getDataPengeluaran['p'];
	$q = $getDataPengeluaran['q'];
	$getNamaProgram = mysql_fetch_array(mysql_query("select * from ref_program where bk = '$bk' and ck='$ck' and dk = '$dk' and p ='$p' and q='0'"));
	$program = $getNamaProgram['nama'];
	$comboYangMenyerahkan = cmbQuery('yangMenyerahkan', $getDataPengeluaran['yang_menyerahkan'], "select id, nama from ref_penyerah_pengeluaran","",'-- YANG MENYERAHKAN --');
	$comboBoxKegiatan = cmbQuery('cmbKegiatan', $q, "select q, nama from  ref_program where bk = '$bk' and ck = '$ck' and dk='$dk' and p='$p' and q != '0'","",'-- KEGIATAN --');
	$untukKeperluan = $getDataPengeluaran['keperluan'];
	if(empty($getDataPengeluaran['tanggal_buku'])){
			$tanggalBuku = date("Y-m-d");
	}else{
			$tanggalBuku = $this->generateDate($getDataPengeluaran['tanggal_buku']);
	}
	$TampilOpt =


	$vOrder=
			genFilterBar(
				array(
					$this->isiform(
						array(
							array(
								'label'=>'URUSAN',
								'name'=>'urusan',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$c1.". ".$namaUrusan,
								'align'=>'left',
								'parrams'=>"style='width:600px;' readonly",
							),
							array(
								'label'=>'BIDANG',
								'name'=>'bidang',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$c.'. '.$namaBidang,
								'align'=>'left',
								'parrams'=>"style='width:600px;' readonly",
							),
							array(
								'label'=>'SKPD',
								'name'=>'skpd',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$d.'. '.$namaSKPD,
								'align'=>'left',
								'parrams'=>"style='width:600px;' readonly",
							),
							array(
								'label'=>'UNIT',
								'name'=>'skpd',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$e.'. '.$namaUnit,
								'align'=>'left',
								'parrams'=>"style='width:600px;' readonly",
							),
							array(
								'label'=>'SUB UNIT',
								'name'=>'skpd',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$e1.'. '.$namaSubUnit,
								'align'=>'left',
								'parrams'=>"style='width:600px;' readonly",
							)
						)
					)

				),'','','').

				genFilterBar(
				array(
					$this->isiform(
						array(
							array(
								'label'=>'NOMOR',
								'name'=>'nomorPengeluaran',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$nomorPengeluaran,
								'parrams'=>"style='width:170px;' readonly",
							),
							array(
								'label'=>'TANGGAL',
								'name'=>'tanggalPengeluaran',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$tanggalPengeluaran,
								'parrams'=>"style='width:100px;'",
							),
							 array(
								'label'=>'PROGRAM',
								'labelWidth'=>250,
								'value'=>"<input type='hidden' name='bk' id='bk' value='$bk'><input type='hidden' name='ck' id='ck' value='$ck'><input type='hidden' name='p' id='p' value='$p'><input type='text' name='program' value='".$program."' style='width:600px;' id='program' readonly>&nbsp
								<input type='button' value='Cari' id='findProgram' onclick ='pengeluaranPersediaan_ins.findProgram()'  title='Cari Program dan Kegiatan' > &nbsp
								<input type='button' value='DPA' id='findProgram' onclick ='pengeluaranPersediaan_ins.findProgramDPA()'  title='Cari Program dan Kegiatan' >"
							  ),
							  array(
								'label'=>'KEGIATAN',
								'labelWidth'=>150,
								'value'=>$comboBoxKegiatan
								 ),
							array(
								'label'=>'UNTUK KEPERLUAN',
								'labelWidth'=>150,
								'value'=>"<textarea id='untukKeperluan' name='untukKeperluan' style='width:400px;height:50px;'>$untukKeperluan</textarea>"
								 ),
							array(
								'label'=>'YANG MENYERAHKAN',
								'labelWidth'=>150,
								'value'=>$comboYangMenyerahkan." &nbsp <input type='button' onclick=$this->Prefix.newPenyerah(); value='Baru'> &nbsp <input type='button' onclick=$this->Prefix.editPenyerah(); value='Edit'> &nbsp <input type='button' onclick=$this->Prefix.deletePenyerah(); value='Hapus'>"
							),
							// array(
							// 	'label'=>'TANGGAL BUKU',
							// 	'name'=>'tanggalBuku',
							// 	'label-width'=>'200px;',
							// 	'type'=>'text',
							// 	'value'=>$tanggalBuku,
							// 	'parrams'=>"style='width:100px;'",
							// ),

						)
					)

				),'','','').

				"<div id='tabelBarang'>".$this->tabelBarang()."</div>".
				genFilterBar(
					array(
					"
						<input type='hidden' name='".$this->Prefix."_idplh' id='".$this->Prefix."_idplh' value='$idplhnya' />
					<input type='hidden' name='refid_terimanya' id='refid_terimanya' value='".$dt['Id']."' />
					<input type='hidden' name='FMST_penerimaan_det' id='FMST_penerimaan_det' value='".$dt['FMST_penerimaan_det']."' />
					<table>
						<tr>
							<td>".$this->buttonnya($this->Prefix.'.savePengeluaran()','save_f2.png','simpan','simpan','SIMPAN')."</td>
							<td>".$this->buttonnya($this->Prefix.'.closeTab()','cancel_f2.png','batal','batal','BATAL')."</td>

						</tr>".
					"</table>"



				),'','','')
			;


		return array('TampilOpt'=>$TampilOpt);
	}



	function isiform($value){
		$isinya = '';
		$tbl ='<table width="100%">';
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

			$tbl .= "
				<tr>
					<td width='".$value[$i]['label-width']."' valign='top'>".$value[$i]['label']."</td>
					<td width='10px' valign='top'>:<br></td>
					<td align='".$value[$i]['align']."' valign='".$value[$i]['valign']."'> $isinya</td>
				</tr>
			";
		}
		$tbl .= '</table>';

		return $tbl;
	}



	function tampilarrnya($value, $width='12'){
		$gabung = '<div class="col-lg-'.$width.' form-horizontal well bs-component"><fieldset>';
		for($i=0;$i<count($value);$i++){

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

			$gabung .='<div class="form-group">
				<label for="'.$value[$i]['name'].'" class="col-lg-'.$value[$i]['label-width'].' control-label" style="text-align:left;font-size:15px;font-weight: bold;">'.$value[$i]['label'].' </label>
				<label class="col-lg-1 control-label" style="text-align:center;">:</label>
      			<div class="col-lg-'.$value[$i]['isi-width'].'">
					'.$isinya.'
				</div>
    		</div>';
		}
		$gabung .= '</fieldset></div>';
		return $gabung;
	}


	function newPenyerah(){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 100;
	 $this->form_caption = 'YANG MENYERAHKAN';



	 //items ----------------------
	  $this->form_fields = array(
			'1' => array(
						'label'=>'NAMA',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='namaPenyerah' style='width:220px;' id='namaPenyerah'>"
						 ),
			'2' => array(
						'label'=>'NIP',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='nipPenyerah' style='width:220px;'id='nipPenyerah'>"
						 ),
		 '3' => array(
						'label'=>'JABATAN',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='jabatanPenyerah' style='width:220px;' id='jabatanPenyerah'>"
						 )
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNewPenyerah()' > &nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >"
			;

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function editPenyerah($idEdit){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 100;
	 $this->form_caption = 'YANG MENYERAHKAN';

	 $getData = mysql_fetch_array(mysql_query("select * from ref_penyerah_pengeluaran where id = '$idEdit'"));
	 foreach ($getData as $key => $value) {
				 $$key = $value;
	 }
	 //items ----------------------
	  $this->form_fields = array(
			'1' => array(
						'label'=>'NAMA',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='namaPenyerah' style='width:220px;' id='namaPenyerah' value = '$nama'>"
						 ),
			'2' => array(
						'label'=>'NIP',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='nipPenyerah' style='width:220px;'id='nipPenyerah' value='$nip'>"
						 ),
		 '3' => array(
						'label'=>'JABATAN',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='jabatanPenyerah' style='width:220px;' id='jabatanPenyerah' value='$jabatan'>"
						 )
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveEditPenyerah($idEdit)' > &nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >"
			;

		$form = $this->genForm();
		$content = $form;//$content = 'content';
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

	function tabelBarang(){
		$cek = '';
		$err = '';
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_pengeluaran where username = '$this->username' order by id ";
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "addBarang()";
		$gambar = "datepicker/add-256.png";
		while($dt = mysql_fetch_array($aqry)){

		foreach ($dt as $key => $value) {
					$$key = $value;
		}
			$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h='$h' and i ='$i' and j='$j' and j1='$j1' "));
			$namaBarang = $getNamaBarang['nm_barang'];
			$datanya.="
						<tr class='row0'>
							<td class='GarisDaftar' align='center'>$no</a></td>
							<td class='GarisDaftar' align='left'>
								$namaBarang
							</td>
							<td class='GarisDaftar' align='left'>
							$merk
							</td>
							<td class='GarisDaftar' align='right'>
							".number_format($jumlah,0,',','.')."
							</td>
							<td class='GarisDaftar' align='left'>
								$keterangan
							</td>
							<td class='GarisDaftar' align='center'>
								<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editBarang($id); >
								<img src='images/administrator/images/move_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.gandakanBarang($id); >
							</td>
						</tr>
			";
			$no = $no+1;
		}



		$content =
			"
					<div id='tabelSubRincianBelanja' style='width:100%;'>
					<table class='koptable'  style='width:100%;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='700px;'>NAMA BARANG </th>
							<th class='th01' width='200px;'>MERK/ TYPE/ SPESIFIKASI</th>
							<th class='th01' width='200px;'>JUMLAH </th>
							<th class='th01' width='300px;'>KETERANGAN </th>
							<th class='th01' width='50px;'>
								<span id='atasbutton'>
								<a href='javascript:$this->Prefix.$tujuan' id='linkAtasButton' /><img id='gambarAtasButton' src='$gambar' style='width:20px;height:20px;' /></a>
								</span>
							</th>
						</tr>
						$datanya

					</table>
					</div>
					"
		;

		return	$content;
	}

	function addBarang(){
		$cek = '';
		$err = '';
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_pengeluaran where username = '$this->username' order by id ";
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "cancelBarang()";
		$gambar = "datepicker/cancel.png";
		while($dt = mysql_fetch_array($aqry)){
				$id = $dt['id'];

		foreach ($dt as $key => $value) {
					$$key = $value;
		}


		$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h='$h' and i ='$i' and j='$j' and j1='$j1' "));
		$namaBarang = $getNamaBarang['nm_barang'];
		$datanya.="
					<tr class='row0'>
						<td class='GarisDaftar' align='center'>$no</a></td>
						<td class='GarisDaftar' align='left'>
							$namaBarang
						</td>
						<td class='GarisDaftar' align='right'>
						".number_format($jumlah,0,',','.')."
						</td>
						<td class='GarisDaftar' align='left'>
							$merk
						</td>
						<td class='GarisDaftar' align='left'>
							$keterangan
						</td>
						<td class='GarisDaftar' align='center'>
							<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editBarang($id); >
						</td>
					</tr>
		";
			$no = $no+1;
		}

		$content =
			"
					<div id='tabelSubRincianBelanja'>
					<table class='koptable'  style='min-width:900px;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='700px;'>NAMA BARANG </th>
							<th class='th01' width='200px;'>MERK / TYPE /JENIS </th>
							<th class='th01' width='200px;'>JUMLAH </th>
							<th class='th01' width='300px;'>KETERANGAN </th>
							<th class='th01' width='50px;'>
								<span id='atasbutton'>
								<a href='javascript:$this->Prefix.$tujuan' id='linkAtasButton' /><img id='gambarAtasButton' src='$gambar' style='width:20px;height:20px;' /></a>
								</span>
							</th>
						</tr>
						$datanya
						<tr class='row0'>
							<td class='GarisDaftar' align='center'>$no</a></td>
							<td class='GarisDaftar' align='left'>
								<input type='hidden' name='kodeBarang' id ='kodeBarang' >
								<input type='text' readonly name='namaBarang' id ='namaBarang' style='width:95%;' >&nbsp <img src='datepicker/search.png'  onclick=$this->Prefix.findBarang(); style='width:20px;height:20px;margin-bottom:-5px; cursor:pointer;'>
							</td>
							<td class='GarisDaftar' align='left'>
							<input style='width:100%;' placeholder='MERK / TYPE /JENIS' type='text' name='merk' id='merk'  >
							</td>

							<td class='GarisDaftar' align='left'>
								<input style='width:50%;text-align:right' placeholder='Jumlah' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='jumlahBarang' id='jumlahBarang'  value='$jumlahBarang' > <span id='bantuJumlah'>
							</td>
							<td class='GarisDaftar' align='left'>
								<input style='width:100%;' placeholder='KETERANGAN' type='text' name='keterangan' id='keterangan'  >
							</td>

							<td class='GarisDaftar' align='center'>
								<img src='datepicker/save.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.saveNewBarang(); >
							</td>
						</tr>

					</table>
					</div>
					"
		;

		return	$content;
	}
	function editBarang($idEdit){
		$cek = '';
		$err = '';
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_pengeluaran where username = '$this->username' order by id ";
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "cancelBarang()";
		$gambar = "datepicker/cancel.png";
		while($dt = mysql_fetch_array($aqry)){
				$id = $dt['id'];

		foreach ($dt as $key => $value) {
					$$key = $value;
		}


		$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h='$h' and i ='$i' and j='$j' and j1='$j1' "));
		$namaBarang = $getNamaBarang['nm_barang'];

		if($id == $idEdit){
			$kodeBarang = $f1.".".$f2.".".$f.".".$g.".".$h.".".$i.".".$j.".".$j1;
			$datanya.="
							<tr class='row0'>
								<td class='GarisDaftar' align='center'>$no</a></td>
								<td class='GarisDaftar' align='left'>
									<input type='hidden' name='kodeBarang' id ='kodeBarang' value='$kodeBarang' >
									<input type='text' readonly name='namaBarang' id ='namaBarang' value='$namaBarang' style='width:95%;' >&nbsp <img src='datepicker/search.png'  onclick=$this->Prefix.findBarang(); style='width:20px;height:20px;margin-bottom:-5px; cursor:pointer;'>
								</td>
								<td class='GarisDaftar' align='left'>
								<input style='width:100%;' placeholder='MERK/ TYPE/ SPESIFIKASI' type='text' name='merk' id='merk' value='$merk'  >
								</td>
								<td class='GarisDaftar' align='left'>
									<input style='width:50%;text-align:right' placeholder='Jumlah' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='jumlahBarang' id='jumlahBarang'  value='$jumlah' > <span id='bantuJumlah'>
								</td>
								<td class='GarisDaftar' align='left'>
									<input style='width:100%;' placeholder='KETERANGAN' type='text' name='keterangan' id='keterangan' value='$keterangan'  >
								</td>

								<td class='GarisDaftar' align='center'>
									<img src='datepicker/save.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.saveEditBarang($idEdit); >
								 &nbsp <img src='datepicker/remove2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.deleteBarang($idEdit); >
								</td>
							</tr>
			";
		}else{
			$datanya.="
						<tr class='row0'>
							<td class='GarisDaftar' align='center'>$no</a></td>
							<td class='GarisDaftar' align='left'>
								$namaBarang
							</td>
							<td class='GarisDaftar' align='left'>
							$merk
							</td>
							<td class='GarisDaftar' align='right'>
							".number_format($jumlah,0,',','.')."
							</td>
							<td class='GarisDaftar' align='left'>
								$keterangan
							</td>
							<td class='GarisDaftar' align='center'>
								<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editBarang($id); >
							</td>
						</tr>
			";
		}

			$no = $no+1;
		}

		$content =
			"
					<div id='tabelSubRincianBelanja'>
					<table class='koptable'  style='min-width:900px;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='700px;'>NAMA BARANG </th>
							<th class='th01' width='200px;'>MERK/ TYPE/ SPESIFIKASI </th>
							<th class='th01' width='200px;'>JUMLAH </th>
							<th class='th01' width='200px;'>KETERANGAN </th>
							<th class='th01' width='50px;'>
								<span id='atasbutton'>
								<a href='javascript:$this->Prefix.$tujuan' id='linkAtasButton' /><img id='gambarAtasButton' src='$gambar' style='width:20px;height:20px;' /></a>
								</span>
							</th>
						</tr>
						$datanya


					</table>
					</div>
					"
		;

		return	$content;
	}

	function generateDate($tanggal){
			$tanggal = explode('-',$tanggal);
			$tanggal = $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];
			return $tanggal;
	}

}
$pengeluaranPersediaan_ins = new pengeluaranPersediaan_insObj();
$pengeluaranPersediaan_ins->username = $_COOKIE['coID'];


?>
