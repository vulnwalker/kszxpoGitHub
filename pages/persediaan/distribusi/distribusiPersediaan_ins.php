<?php
class distribusiPersediaan_insObj  extends DaftarObj2{
	var $Prefix = 'distribusiPersediaan_ins';
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
	var $PageTitle = 'DISTRIBUSI';
	var $PageIcon = 'images/perencanaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='renja.xls';
	var $namaModulCetak='PERENCANAAN';
	var $Cetak_Judul = 'DISTRIBUSI';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'distribusiPersediaan_insForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0
	var $modul = "DISTRIBUSI";
	var $jenisForm = "";
	var $tahun = "";
	var $nomorUrut = "";
	var $jenisAnggaran = "";
	var $idTahap = "";

	function setTitle(){
	    $id = $_REQUEST['ID_PLAFON'];
	    $getTahun = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id'"));
		return 'DISTRIBUSI' ;
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

			case 'gandakanBarang':{
				foreach ($_REQUEST as $key => $value) {
					 	 $$key = $value;
				}

				if(empty($err)){
						$getDataBarang = mysql_fetch_array(mysql_query("select * from temp_rincian_distribusi where id = '$id'"));
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
													'merk' => $merk,
													'username' => $this->username,
													);
						$query = VulnWalkerInsert('temp_rincian_distribusi',$data);
						mysql_query($query);
						$getIdRincianDistribusi = mysql_fetch_array(mysql_query("select max(id) from temp_rincian_distribusi where username = '$this->username'"));
						$explodeKodeSKPD = explode('.',$kodeSKPD);
						$c1 = $explodeKodeSKPD[0];
						$c = $explodeKodeSKPD[1];
						$d = $explodeKodeSKPD[2];
						$getUnitPelaksana = mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e1!='000'");
						while ($dataUnitPelaksana = mysql_fetch_array($getUnitPelaksana)) {
									$data = array(
													'c1' => $c1,
													'c' => $c,
													'd' => $d,
													'e' => $dataUnitPelaksana['e'],
													'e1' => $dataUnitPelaksana['e1'],
													'id_rincian_distribusi' => $getIdRincianDistribusi['max(id)'],
													'username' => $this->username,
									);
									if($dataUnitPelaksana['e'] == $explodeKodeSKPD[3] && $dataUnitPelaksana['e1'] ==  $explodeKodeSKPD[4] ){

									}else{
										mysql_query(VulnWalkerInsert("temp_detail_rincian_distribusi",$data));
										$cek .= VulnWalkerInsert("temp_detail_rincian_distribusi",$data);
									}

						}
				}

				$content =array('tabelBarang' => $this->tabelBarang());
			break;
			}
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
		case 'selectedTabelBarang':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}
			$getIdDetailRincianDistribusi = mysql_fetch_array(mysql_query("select * from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$idSelected' and id_detail_rincian_distribusi !=''"));
			$getDataPosting = mysql_fetch_array(mysql_query("select * from detail_rincian_distribusi where id = '".$getIdDetailRincianDistribusi['id_detail_rincian_distribusi']."'"));
			$getDataPengurangan = mysql_fetch_array(mysql_query("select sum(jumlah) from detail_rincian_distribusi where status = '1' and id_rincian_distribusi = '".$getDataPosting['id_rincian_distribusi']."'"));
			//police line

			$getData = mysql_fetch_array(mysql_query("select * from temp_rincian_distribusi where username = '$this->username' and id= '$idSelected'"));
			$getJumlahbarang = mysql_fetch_array(mysql_query("select sum(jumlah) from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$idSelected'"));

			$content = array(	'sisaBarang' => $getData['jumlah'] - $getJumlahbarang['sum(jumlah)'] - $getDataPengurangan['sum(jumlah)'],
												'tabelBarang' => $this->selectedTabelBarang($idSelected),
												'tabelDetailRincianBarang' => $this->tabelDetailRincianBarang($idSelected,1),
		 									);
		break;
		}
		case 'bantuDetailRincianDistribusi':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}
			$getIdDetailRincianDistribusi = mysql_fetch_array(mysql_query("select * from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$idSelected' and id_detail_rincian_distribusi !=''"));
			$getDataPosting = mysql_fetch_array(mysql_query("select * from detail_rincian_distribusi where id = '".$getIdDetailRincianDistribusi['id_detail_rincian_distribusi']."'"));
			$getDataPengurangan = mysql_fetch_array(mysql_query("select sum(jumlah) from detail_rincian_distribusi where status = '1' and id_rincian_distribusi = '".$getDataPosting['id_rincian_distribusi']."'"));
			//police line

			$getData = mysql_fetch_array(mysql_query("select * from temp_rincian_distribusi where username = '$this->username' and id= '$idSelected'"));
			$getJumlahbarang = mysql_fetch_array(mysql_query("select sum(jumlah) from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$idSelected' and id !='$idEdit'"));

			$content = array(	'sisaBarang' => $getData['jumlah'] - $getJumlahbarang['sum(jumlah)'] - $jumlahBarang - $getDataPengurangan['sum(jumlah)'],
		 									);
		break;
		}
		case 'editDetailRincianDistribusi':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}
			$explodeKodeSKPD = explode(".",$kodeSKPD);
			$c1 = $explodeKodeSKPD[0];
			$c = $explodeKodeSKPD[1];
			$d = $explodeKodeSKPD[2];
			if(!empty($filterSubUnit)){
				$this->kondisiSKPD = " and c1 = '$c1' and c='$c' and d='$d' and e='$filterUnit' and e1='$filterSubUnit' ";
			}elseif(!empty($filterUnit)){
				$this->kondisiSKPD = " and c1 = '$c1' and c='$c' and d='$d' and e='$filterUnit' ";
			}
			$content = array(
												'tabelDetailRincianBarang' => $this->editDetailRincianDistribusi($idRincianDistribusi,1,$idEdit),
		 									);
		break;
		}
		case 'filterUnitChanged':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}
			$getData = mysql_fetch_array(mysql_query("select * from temp_rincian_distribusi where username = '$this->username' and id= '$idSelected'"));
			$getJumlahbarang = mysql_fetch_array(mysql_query("select sum(jumlah) from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$idSelected'"));
			$explodeKodeSKPD = explode(".",$kodeSKPD);
			$c1 = $explodeKodeSKPD[0];
			$c = $explodeKodeSKPD[1];
			$d = $explodeKodeSKPD[2];
			if(!empty($filterUnit))$this->kondisiSKPD = " and c1 = '$c1' and c='$c' and d='$d' and e='$filterUnit' ";
			$comboFilterSubUnit =  cmbQuery('filterSubUnit',$filterSubUnit, "select e1,concat(e1,'. ',nm_skpd) from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$filterUnit' and e1!='000'","onchange=$this->Prefix.filterSubUnitChanged();",'-- SUB UNIT --');
			$content = array(	'sisaBarang' => $getData['jumlah'] - $getJumlahbarang['sum(jumlah)'],
												'filterSubUnit' => $comboFilterSubUnit,
												'tabelDetailRincianBarang' => $this->tabelDetailRincianBarang($idSelected,1),
		 									);
		break;
		}
		case 'filterSubUnitChanged':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}
			$getData = mysql_fetch_array(mysql_query("select * from temp_rincian_distribusi where username = '$this->username' and id= '$idSelected'"));
			$getJumlahbarang = mysql_fetch_array(mysql_query("select sum(jumlah) from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$idSelected'"));
			$explodeKodeSKPD = explode(".",$kodeSKPD);
			$c1 = $explodeKodeSKPD[0];
			$c = $explodeKodeSKPD[1];
			$d = $explodeKodeSKPD[2];
			if(!empty($filterSubUnit))$this->kondisiSKPD = " and c1 = '$c1' and c='$c' and d='$d' and e='$filterUnit' and e1='$filterSubUnit' ";
			$content = array(
												'tabelDetailRincianBarang' => $this->tabelDetailRincianBarang($idSelected,1),
												'sisaBarang' => $getData['jumlah'] - $getJumlahbarang['sum(jumlah)'],
		 									);
		break;
		}
		case 'saveEditDetailRincianDistribusi':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}
			$getIdDetailRincianDistribusi = mysql_fetch_array(mysql_query("select * from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$idRincianDistribusi' and id_detail_rincian_distribusi !=''"));
			$getDataPosting = mysql_fetch_array(mysql_query("select * from detail_rincian_distribusi where id = '".$getIdDetailRincianDistribusi['id_detail_rincian_distribusi']."'"));
			$getDataPengurangan = mysql_fetch_array(mysql_query("select sum(jumlah) from detail_rincian_distribusi where status = '1' and id_rincian_distribusi = '".$getDataPosting['id_rincian_distribusi']."'"));
			//police line

			$getData = mysql_fetch_array(mysql_query("select * from temp_rincian_distribusi where username = '$this->username' and id= '$idRincianDistribusi'"));
			$getJumlahbarang = mysql_fetch_array(mysql_query("select sum(jumlah) from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$idRincianDistribusi' and id!='$idEdit'"));
			$sisaBarang = $getData['jumlah'] - $getJumlahbarang['sum(jumlah)'] - $jumlahBarang - $getDataPengurangan['sum(jumlah)'];
			if($sisaBarang < 0 ){
					$err = "Jumlah Barang Melebihi Sisa Barang";
			}

			if(empty($err)){
					$dataUpdate = array(
								'jumlah' => $jumlahBarang
					);
					$query = VulnWalkerUpdate("temp_detail_rincian_distribusi",$dataUpdate,"id ='$idEdit'");
					$cek = $query;
					mysql_query($query);
			}
			$getData = mysql_fetch_array(mysql_query("select * from temp_rincian_distribusi where username = '$this->username' and id= '$idRincianDistribusi'"));
			$getJumlahbarang = mysql_fetch_array(mysql_query("select sum(jumlah) from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$idRincianDistribusi'"));
			$explodeKodeSKPD = explode(".",$kodeSKPD);
			$c1 = $explodeKodeSKPD[0];
			$c = $explodeKodeSKPD[1];
			$d = $explodeKodeSKPD[2];
			if(!empty($filterSubUnit)){
				$this->kondisiSKPD = " and c1 = '$c1' and c='$c' and d='$d' and e='$filterUnit' and e1='$filterSubUnit' ";
			}elseif(!empty($filterUnit)){
				$this->kondisiSKPD = " and c1 = '$c1' and c='$c' and d='$d' and e='$filterUnit' ";
			}
			$content = array(
												'tabelDetailRincianBarang' => $this->tabelDetailRincianBarang($idRincianDistribusi,1),
												'sisaBarang' => $getData['jumlah'] - $getJumlahbarang['sum(jumlah)'] - $getDataPengurangan['sum(jumlah)'],
		 									);
		break;
		}
		case 'cancelEditDetailRincianDistribusi':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}
			$getData = mysql_fetch_array(mysql_query("select * from temp_rincian_distribusi where username = '$this->username' and id= '$idRincianDistribusi'"));
			$getJumlahbarang = mysql_fetch_array(mysql_query("select sum(jumlah) from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$idRincianDistribusi'"));
			$explodeKodeSKPD = explode(".",$kodeSKPD);
			$c1 = $explodeKodeSKPD[0];
			$c = $explodeKodeSKPD[1];
			$d = $explodeKodeSKPD[2];
			if(!empty($filterSubUnit)){
				$this->kondisiSKPD = " and c1 = '$c1' and c='$c' and d='$d' and e='$filterUnit' and e1='$filterSubUnit' ";
			}elseif(!empty($filterUnit)){
				$this->kondisiSKPD = " and c1 = '$c1' and c='$c' and d='$d' and e='$filterUnit' ";
			}
			$content = array(
												'tabelDetailRincianBarang' => $this->tabelDetailRincianBarang($idRincianDistribusi,1),
												'sisaBarang' => $getData['jumlah'] - $getJumlahbarang['sum(jumlah)'],
		 									);
		break;
		}


		case 'addBarang':{

			$cek = '';
			$err = '';
			$content =array(
												'tabelBarang' => $this->addBarang(),
												'tabelDetailRincianBarang' => $this->tabelDetailRincianBarang()
											);
		break;
		}
		case 'editBarang':{

			$cek = '';
			$err = '';
			$content =array(
											'editBarang' => $this->editBarang($_REQUEST['id']),
											'tabelDetailRincianBarang' => $this->tabelDetailRincianBarang()
									);
		break;
		}
		case 'cancelBarang':{

			$cek = '';
			$err = '';
			$content =array('tabelBarang' => $this->tabelBarang(),'tabelDetailRincianBarang' => $this->tabelDetailRincianBarang());
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
			}
			// elseif(mysql_num_rows(mysql_query("select * from temp_rincian_distribusi where concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1) ='$kodeBarang' and username = '$this->username'"))){
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
												'merk' => $merk,
												'username' => $this->username,
												);
					$query = VulnWalkerInsert('temp_rincian_distribusi',$data);
					mysql_query($query);

					$getIdRincianDistribusi = mysql_fetch_array(mysql_query("select max(id) from temp_rincian_distribusi where username = '$this->username'"));
					$explodeKodeSKPD = explode('.',$kodeSKPD);
					$c1 = $explodeKodeSKPD[0];
					$c = $explodeKodeSKPD[1];
					$d = $explodeKodeSKPD[2];
					$getUnitPelaksana = mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e1!='000'");
					while ($dataUnitPelaksana = mysql_fetch_array($getUnitPelaksana)) {
								$data = array(
												'c1' => $c1,
												'c' => $c,
												'd' => $d,
												'e' => $dataUnitPelaksana['e'],
												'e1' => $dataUnitPelaksana['e1'],
												'id_rincian_distribusi' => $getIdRincianDistribusi['max(id)'],
												'username' => $this->username,
								);
								if($dataUnitPelaksana['e'] == $explodeKodeSKPD[3] && $dataUnitPelaksana['e1'] ==  $explodeKodeSKPD[4] ){

								}else{
									mysql_query(VulnWalkerInsert("temp_detail_rincian_distribusi",$data));
									$cek .= VulnWalkerInsert("temp_detail_rincian_distribusi",$data);
								}

					}
			}

			$content =array('tabelBarang' => $this->tabelBarang());
		break;
		}
		case 'saveEditBarang':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}
			$getIdDetailRincianDistribusi = mysql_fetch_array(mysql_query("select * from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$id' and id_detail_rincian_distribusi !=''"));
			$getDataPosting = mysql_fetch_array(mysql_query("select * from detail_rincian_distribusi where id = '".$getIdDetailRincianDistribusi['id_detail_rincian_distribusi']."' "));
			$getDataBarangPosting = mysql_fetch_array(mysql_query("select * from detail_rincian_distribusi where id_rincian_distribusi = '".$getDataPosting['id_rincian_distribusi']."'  and status = '1'"));
			$getDataPengurangan = mysql_fetch_array(mysql_query("select sum(jumlah) from detail_rincian_distribusi where status = '1' and id_rincian_distribusi = '".$getDataPosting['id_rincian_distribusi']."'"));
			$statusPosting = mysql_num_rows(mysql_query("select * from detail_rincian_distribusi where status = '1' and id_rincian_distribusi = '".$getDataPosting['id_rincian_distribusi']."'"));
			$getKodeBarangPosting = mysql_fetch_array(mysql_query("select * from t_kartu_persediaan where refid = '".$getDataBarangPosting['id']."' and jns='3' and jenis_persediaan = '1'"));
			$concatKodeBarangPosting = $getKodeBarangPosting['f1'].".".$getKodeBarangPosting['f2'].".".$getKodeBarangPosting['f'].".".$getKodeBarangPosting['g'].".".$getKodeBarangPosting['h'].".".$getKodeBarangPosting['i'].".".$getKodeBarangPosting['j'].".".$getKodeBarangPosting['j1'];

			//police line

			$getData = mysql_fetch_array(mysql_query("select sum(jumlah) from temp_detail_rincian_distribusi where id_rincian_distribusi = '$id'"));
			if(empty($kodeBarang)){
				$err = "Pilih Barang";
			}elseif(empty($jumlahBarang)){
				$err = "Isi Jumlah Barang";
			}elseif(($getData['sum(jumlah)'] + $getDataPengurangan['sum(jumlah)']) > $jumlahBarang){
				$err = "Jumlah Barang Kurang !";
			}elseif($kodeBarang != $concatKodeBarangPosting && $statusPosting != 0){
					$err = "Data sudah di posting tidak dapat di rubah kode barang nya";
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
												'username' => $this->username,
												);
					$query = VulnWalkerUpdate('temp_rincian_distribusi',$data,"id = '$id'");
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
			$getIdDetailRincianDistribusi = mysql_fetch_array(mysql_query("select * from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$id' and id_detail_rincian_distribusi !=''"));
			$getDataPosting = mysql_fetch_array(mysql_query("select * from detail_rincian_distribusi where id = '".$getIdDetailRincianDistribusi['id_detail_rincian_distribusi']."'"));
			$getDataPengurangan = mysql_num_rows(mysql_query("select * from detail_rincian_distribusi where status = '1' and id_rincian_distribusi = '".$getDataPosting['id_rincian_distribusi']."'"));
			if($getDataPengurangan != 0){
					$err = "Data yang sudah di posting tidak dapat di hapus !";
			}
			//police line

			if(empty($err)){
				$getData = mysql_fetch_array(mysql_query("select * from temp_rincian_distribusi where id = '$id'"));
				$data = array("username" => $this->username, 'id_rincian_distribusi' => $getData['id_rincian_distribusi'] );
				mysql_query(VulnWalkerInsert("delete_temp_rincian_distribusi",$data));
				mysql_query("delete from temp_rincian_distribusi where id = '$id'");
				$getAllDetailRincian = mysql_query("select * from temp_detail_rincian_distribusi where id_rincian_distribusi ='$id'");
				while ($detailRincian = mysql_fetch_array($getAllDetailRincian)) {
					$data = array("username" => $this->username, 'id_detail_rincian_distribusi' => $detailRincian['id_detail_rincian_distribusi'] );
					mysql_query(VulnWalkerInsert("delete_temp_detail_rincian_distribusi",$data));
					mysql_query("delete from temp_detail_rincian_distribusi where id = '".$detailRincian['id']."'");
				}
			}

			$content =array('tabelBarang' => $this->tabelBarang());
		break;
		}
		case 'saveDistribusi':{
			foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
			}
			if(empty($tanggalDistribusi)){
					$err = "Isi tanggal persediaan";
			}elseif(empty($untukKeperluan)){
					$err = "Isi keperluan";
			}elseif(empty($yangMenyerahkan)){
					$err = "Pilih yang menyerahkan";
			}elseif(substr($tanggalDistribusi, -4) !=$_COOKIE['coThnAnggaran']){
					$err = "Tahun harus sama dengan tahun login";
			}

			if(empty($err)){
						$dataDistribusi = array(
										'tanggal' => $this->generateDate($tanggalDistribusi),
										'bk' => $bk,
										'ck' => $ck,
										'dk' => $dk,
										'p' => $p,
										'q' => $q,
										'keperluan' => $untukKeperluan,
										'yang_menyerahkan' => $yangMenyerahkan,
										// 'tanggal_buku' => $this->generateDate($tanggalBuku),
										'status_temp' => "0",
						);
						$query = VulnWalkerUpdate("distribusi",$dataDistribusi,"nomor = '$nomorDistribusi'");
						mysql_query($query);
						$getDataDistribusi = mysql_fetch_array(mysql_query("select * from distribusi where nomor = '$nomorDistribusi'"));
						$getAllDeletedID = mysql_query("select * from delete_temp_rincian_distribusi where username = '$this->username'");

						while ($removeID = mysql_fetch_array($getAllDeletedID)) {
								mysql_query("delete from rincian_distribusi where id = '".$removeID['id_rincian_distribusi']."' ");

						}
						$getAllDetailDeletedID = mysql_query("select * from delete_temp_detail_rincian_distribusi where username = '$this->username'");
						while ($removeIDDetail = mysql_fetch_array($getAllDetailDeletedID)) {
								mysql_query("delete from detail_rincian_distribusi where id = '".$removeIDDetail['id_detail_rincian_distribusi']."' ");
						}

						$getAllTemp = mysql_query("select * from temp_rincian_distribusi where username = '$this->username'");
						while ($dataBarang = mysql_fetch_array($getAllTemp)) {
								foreach ($dataBarang as $key => $value) {
										 $$key = $value;
								}
								$dataRincianDistribusi = array(
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
											'id_distribusi' => $getDataDistribusi['id']
								);
								if(mysql_num_rows(mysql_query("select * from rincian_distribusi where id = '$id_rincian_distribusi'")) != 0){
										$query = VulnWalkerUpdate("rincian_distribusi",$dataRincianDistribusi,"id = '$id_rincian_distribusi'");
										$idRincianDistribusi = $id_rincian_distribusi;
								}else{
										$query = VulnWalkerInsert("rincian_distribusi",$dataRincianDistribusi);
										$idRincianDistribusi = "";
								}
								mysql_query($query);
								if(empty($idRincianDistribusi)){
									$getIdRincianDistribusi= mysql_fetch_array(mysql_query("select max(id) from rincian_distribusi"));
									$idRincianDistribusi = $getIdRincianDistribusi['max(id)'];
								}
								$getDetailRincianDistribusi = mysql_query("select * from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$id'");
								while ($detailRincianDistribusi = mysql_fetch_array($getDetailRincianDistribusi)) {
										$dataDetailRincianDistribusi = array(
													'c1' => $detailRincianDistribusi['c1'],
													'c' => $detailRincianDistribusi['c'],
													'd' => $detailRincianDistribusi['d'],
													'e' => $detailRincianDistribusi['e'],
													'e1' => $detailRincianDistribusi['e1'],
													'jumlah' => $detailRincianDistribusi['jumlah'],
													'id_rincian_distribusi' => $idRincianDistribusi
										);
										if(mysql_num_rows(mysql_query("select * from detail_rincian_distribusi where id = '".$detailRincianDistribusi['id_detail_rincian_distribusi']."'")) != 0){
												$queryDetail = VulnWalkerUpdate("detail_rincian_distribusi",$dataDetailRincianDistribusi,"id = '".$detailRincianDistribusi['id_detail_rincian_distribusi']."'");
										}else{
												$queryDetail = VulnWalkerInsert("detail_rincian_distribusi",$dataDetailRincianDistribusi);
										}
										mysql_query($queryDetail);

								}


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
			"<script type='text/javascript' src='js/persediaan/distribusi/distribusiPersediaan_ins.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/persediaan/popupProgram.js' language='JavaScript' ></script>
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
					<input type='hidden' name='nomorDistribusi' id='nomorDistribusi' value='".$_REQUEST['nomor']."' >
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




	$getDataDistribusi = mysql_fetch_array(mysql_query("select * from distribusi where nomor = '$nomorDistribusi'"));
	$tanggalDistribusi = $this->generateDate($getDataDistribusi['tanggal']);
	$bk = $getDataDistribusi['bk'];
	$ck = $getDataDistribusi['ck'];
	$dk = $getDataDistribusi['dk'];
	$p = $getDataDistribusi['p'];
	$q = $getDataDistribusi['q'];
	$getNamaProgram = mysql_fetch_array(mysql_query("select * from ref_program where bk = '$bk' and ck='$ck' and dk = '$dk' and p ='$p' and q='0'"));
	$program = $getNamaProgram['nama'];
	$comboYangMenyerahkan = cmbQuery('yangMenyerahkan', $getDataDistribusi['yang_menyerahkan'], "select id, nama from ref_penyerah_pengeluaran","",'-- YANG MENYERAHKAN --');
	$comboBoxKegiatan = cmbQuery('cmbKegiatan', $q, "select q, nama from  ref_program where bk = '$bk' and ck = '$ck' and dk='$dk' and p='$p' and q != '0'","",'-- KEGIATAN --');
	$untukKeperluan = $getDataDistribusi['keperluan'];
	if(empty($getDataDistribusi['tanggal_buku'])){
			$tanggalBuku = date("Y-m-d");
	}else{
			$tanggalBuku = $this->generateDate($getDataDistribusi['tanggal_buku']);
	}
	$comboFilterUnit =  cmbQuery('filterUnit',$filterUnit, "select e,concat(e,'. ',nm_skpd) from ref_skpd where c1='$c1' and c='$c' and d='$d' and e!='00' and e1='000' and e!='$e' and e1!='$e1'","onchange=$this->Prefix.filterUnitChanged();",'-- UNIT --');
	$comboFilterSubUnit =  cmbQuery('filterSubUnit',$filterSubUnit, "select e1,concat(e1,'. ',nm_skpd) from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='00' and e1!='000'","onchange=$this->Prefix.filterSubUnitChanged();",'-- SUB UNIT --');
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
								'name'=>'nomorDistribusi',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$nomorDistribusi,
								'parrams'=>"style='width:170px;' readonly",
							),
							array(
								'label'=>'TANGGAL',
								'name'=>'tanggalDistribusi',
								'label-width'=>'200px;',
								'type'=>'text',
								'value'=>$tanggalDistribusi,
								'parrams'=>"style='width:100px;'",
							),
							 array(
								'label'=>'PROGRAM',
								'labelWidth'=>250,
								'value'=>"<input type='hidden' name='bk' id='bk' value='$bk'><input type='hidden' name='ck' id='ck' value='$ck'><input type='hidden' name='p' id='p' value='$p'><input type='text' name='program' value='".$program."' style='width:600px;' id='program' readonly>&nbsp
								<input type='button' value='Cari' id='findProgram' onclick ='distribusiPersediaan_ins.findProgram()'  title='Cari Program dan Kegiatan' > &nbsp
								<input type='button' value='DPA' id='findProgram' onclick ='distribusiPersediaan_ins.findProgramDPA()'  title='Cari Program dan Kegiatan' >"
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
				$this->genFilterBarVulnWalker(
						array(
								"<table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
								<tbody><tr valign='middle' align='center'>
								<td class='border:none'>
									<b>Barang</b>
								</td>
								</tr>
								</tbody></table>".
								"<div id='tabelBarang'>".$this->tabelBarang()."</div>"
							)
				,'','','').
				$this->genFilterBarVulnWalker(
						array(
								"<table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
								<tbody><tr valign='middle' align='center'>
								<td class='border:none'>
									<b>Distribusi Pengguna</b> <input type='hidden' name='currentRincianDistribusi' id = 'currentRincianDistribusi' >
								</td>
								</tr>
								</tbody></table>".
								$this->genFilterBarVulnWalker(
									array(
									"
									<table>
									<tr>
										<td width='190px'>UNIT</td> <td>:</td> <td> $comboFilterUnit </td>
									</tr>
									<tr>
										<td width='190px'>SUB UNIT</td> <td>:</td> <td>$comboFilterSubUnit </td>
									</tr>
									<tr>
										<td width='190px'>&nbsp</td> <td>&nbsp</td> <td style='text-align:right;width:84%;'>SISA &nbsp<span style='float:right;'><input type='text' name='sisaBarang' id='sisaBarang' style='text-align:right;width:200px;' readonly></span></td>
									</tr>
									</table>

									"
								),'','','').
								$this->tabelDetailRincianBarang()
							)
				,'','','').
				genFilterBar(
					array(
					"
						<input type='hidden' name='".$this->Prefix."_idplh' id='".$this->Prefix."_idplh' value='$idplhnya' />
					<input type='hidden' name='refid_terimanya' id='refid_terimanya' value='".$dt['Id']."' />
					<input type='hidden' name='FMST_penerimaan_det' id='FMST_penerimaan_det' value='".$dt['FMST_penerimaan_det']."' />
					<table>
						<tr>
							<td>".$this->buttonnya($this->Prefix.'.saveDistribusi()','save_f2.png','simpan','simpan','SIMPAN')."</td>
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

		$qry = "select * from temp_rincian_distribusi where username = '$this->username' order by id ";
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
							<td class='GarisDaftar' align='center'><input type='checkbox' onchange=$this->Prefix.selectedTabelBarang($id)></td>
							<td class='GarisDaftar' align='left'>
								$namaBarang
							</td>
							<td class='GarisDaftar' align='left'>
								$merk
							</td>
							<td class='GarisDaftar' align='right'>
							".number_format($jumlah,0,',','.')."
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
					<div  style='width:100%;'>
					<table class='koptable'  style='width:100%;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='25px;'></th>
							<th class='th01' width='800px;'>NAMA BARANG </th>
							<th class='th01' width='200px;'>MERK/ TYPE/ SPESIFIKASI</th>
							<th class='th01' width='200px;'>JUMLAH </th>
							<th class='th01' width='50px;'>
								<span id='atasbutton'>
								<a onclick=$this->Prefix.$tujuan id='linkAtasButton' /><img id='gambarAtasButton' src='$gambar' style='width:20px;height:20px;cursor:pointer;' /></a>
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
	function selectedTabelBarang($idSelected){
		$cek = '';
		$err = '';
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_rincian_distribusi where username = '$this->username' order by id ";
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
			if($id == $idSelected){
				$datanya.="
							<tr class='row0'>
								<td class='GarisDaftar' align='center'>$no</a></td>
								<td class='GarisDaftar' align='center'><input type='checkbox' checked onchange=$this->Prefix.selectedTabelBarang($id)></td>
								<td class='GarisDaftar' align='left'>
									$namaBarang
								</td>
								<td class='GarisDaftar' align='left'>
									$merk
								</td>
								<td class='GarisDaftar' align='right'>
								".number_format($jumlah,0,',','.')."
								</td>
								<td class='GarisDaftar' align='center'>
									<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editBarang($id); >
								</td>
							</tr>
				";
			}else{
				$datanya.="
							<tr class='row0'>
								<td class='GarisDaftar' align='center'>$no</a></td>
								<td class='GarisDaftar' align='center'><input type='checkbox' onchange=$this->Prefix.selectedTabelBarang($id)></td>
								<td class='GarisDaftar' align='left'>
									$namaBarang
								</td>
								<td class='GarisDaftar' align='left'>
									$merk
								</td>
								<td class='GarisDaftar' align='right'>
								".number_format($jumlah,0,',','.')."
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
					<div  style='width:100%;'>
					<table class='koptable'  style='width:100%;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='25px;'></th>
							<th class='th01' width='800px;'>NAMA BARANG </th>
							<th class='th01' width='200px;'>MERK/ TYPE/ SPESIFIKASI</th>
							<th class='th01' width='200px;'>JUMLAH </th>
							<th class='th01' width='50px;'>
								<span id='atasbutton'>
							<img id='gambarAtasButton' src='$gambar' style='width:20px;height:20px;cursor:pointer;' onclick=$this->Prefix.$tujuan />
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
	function tabelDetailRincianBarang($idRincianDistribusi,$pageKe){
		$cek = '';
		$err = '';
		$datanya='';
		$username = $_COOKIE['coID'];
		$qry = "select * from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$idRincianDistribusi' $this->kondisiSKPD order by id ";
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "addBarang()";
		$gambar = "datepicker/add-256.png";
		while($dt = mysql_fetch_array($aqry)){

		foreach ($dt as $key => $value) {
					$$key = $value;
		}
			$getNamaSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
			$datanya.="
						<tr class='row0'>
							<td class='GarisDaftar' align='center'>$no</a></td>
							<td class='GarisDaftar' align='left'>
								".$getNamaSubUnit['nm_skpd']."
							</td>
							<td class='GarisDaftar' align='right'>
							".number_format($jumlah,0,',','.')."
							</td>
							<td class='GarisDaftar' align='center'>
								<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editDetailRincianDistribusi($id,$pageKe); >
							</td>
						</tr>
			";
			$no = $no+1;
		}



		$content =
			"
					<div id='tabelDetailRincianBarang' style='width:100%;'>
					<table class='koptable'  style='width:100%;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='1000px;'>NAMA SUB UNIT </th>
							<th class='th01' width='200px;'>JUMLAH </th>
							<th class='th01' width='50px;'>
							</th>
						</tr>
						$datanya

					</table>
					</div>
					"
		;

		return	$content;
	}
	function editDetailRincianDistribusi($idRincianDistribusi,$pageKe,$idEdit){
		$cek = '';
		$err = '';
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_detail_rincian_distribusi where username = '$this->username' and id_rincian_distribusi = '$idRincianDistribusi' $this->kondisiSKPD order by id ";
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "addBarang()";
		$gambar = "datepicker/add-256.png";
		while($dt = mysql_fetch_array($aqry)){

		foreach ($dt as $key => $value) {
					$$key = $value;
		}
			$getNamaSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
			if($id == $idEdit){
				if(empty($jumlah))$jumlah = "";
				$datanya.="
							<tr class='row0'>
								<td class='GarisDaftar' align='center'>$no</a></td>
								<td class='GarisDaftar' align='left'>
									".$getNamaSubUnit['nm_skpd']."
								</td>
								<td class='GarisDaftar' align='right'>
								<input style='width:50%;text-align:right' placeholder='Jumlah' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantuDetailRincianDistribusi($idEdit);' type='text' name='jumlahBarang' id='jumlahBarang'  value='$jumlah' > <span id='bantuJumlah'>
								</td>
								<td class='GarisDaftar' align='center'>
									<img src='datepicker/save.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.saveEditDetailRincianDistribusi($idEdit,$pageKe); >
								 &nbsp <img src='datepicker/remove2.png' style='width:20px;height:20px;cursor:pointer;' onclick= 	$this->Prefix.cancelEditDetailRincianDistribusi($idEdit.$pageKe); >
								</td>
							</tr>
				";
			}else{
				$datanya.="
							<tr class='row0'>
								<td class='GarisDaftar' align='center'>$no</a></td>
								<td class='GarisDaftar' align='left'>
									".$getNamaSubUnit['nm_skpd']."
								</td>
								<td class='GarisDaftar' align='right'>
								".number_format($jumlah,0,',','.')."
								</td>
								<td class='GarisDaftar' align='center'>
									<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editDetailRincianDistribusi($id,$pageKe); >
								</td>
							</tr>
				";
			}
			$no = $no+1;
		}



		$content =
			"
					<div id='tabelDetailRincianBarang' style='width:100%;'>
					<table class='koptable'  style='width:100%;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='1000px;'>NAMA SUB UNIT </th>
							<th class='th01' width='200px;'>JUMLAH </th>
							<th class='th01' width='50px;'>
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

		$qry = "select * from temp_rincian_distribusi where username = '$this->username' order by id ";
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
						<td class='GarisDaftar' align='left'>
							$merk
						</td>
						<td class='GarisDaftar' align='right'>
						".number_format($jumlah,0,',','.')."
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
							<th class='th01' width='800px;'>NAMA BARANG </th>
							<th class='th01' width='200px;'>MERK/ TYPE/ SPESIFIKASI</th>
							<th class='th01' width='200px;'>JUMLAH </th>
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
								<input style='width:100%;' placeholder='MERK/ TYPE/ SPESIFIKASI' type='text' name='merk' id='merk'  >
							</td>
							<td class='GarisDaftar' align='right'>
								<input style='width:50%;text-align:right' placeholder='Jumlah' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='jumlahBarang' id='jumlahBarang'  value='$jumlahBarang' > <span id='bantuJumlah'>
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

		$qry = "select * from temp_rincian_distribusi where username = '$this->username' order by id ";
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
								<td class='GarisDaftar' align='right'>
									<input style='width:50%;text-align:right' placeholder='Jumlah' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='jumlahBarang' id='jumlahBarang'  value='$jumlah' > <span id='bantuJumlah'>
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
							<th class='th01' width='800px;'>NAMA BARANG </th>
							<th class='th01' width='200px;'>MERK/ TYPE/ SPESIFIKASI</th>
							<th class='th01' width='200px;'>JUMLAH </th>
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

	function genFilterBarVulnWalker($Filters, $onClick, $withButton=TRUE, $TombolCaption='Tampilkan', $Style='FilterBar'){
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
				<table cellspacing='0' cellpadding='0' border='0' style='height:28;width:100%;'>
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

}
$distribusiPersediaan_ins = new distribusiPersediaan_insObj();
$distribusiPersediaan_ins->username = $_COOKIE['coID'];


?>
