<?php

class penetapanRKBMDPengadaanObj  extends DaftarObj2{
	var $Prefix = 'penetapanRKBMDPengadaan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = "view_rkbmd"; //daftar
	var $TblName_Hapus = 'tabel_anggaran';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id_anggaran');
	var $FieldSum = array();
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 3;
	var $PageTitle = 'PENETAPAN RKBMD PENGADAAN';
	var $PageIcon = 'images/perencanaan_ico.png';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'Daftar Standar Kebutuhan Barang Maksimal';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'penetapanRKBMDPengadaanForm';
	var $kode_skpd = '';
	var $modul = "RKBMD";
	var $jenisForm = "";
	var $tahun = "";
	var $nomorUrut = "";
	var $jenisAnggaran = "";
	var $idTahap = "";
	var $namaTahapTerakhir = "";
	var $masaTerakhir = "";
	var $currentTahap = "";
    //untuk view
	var $urutTerakhir = "";
	var $urutSebelumnya = "";
	var $jenisFormTerakhir = "";
	var $tahapTerakhir = "";
	var $username = "";

	var $wajibValidasi = "";

	var $sqlValidasi = "";

	var $provinsi = "";
	var $kota = "";
	var $pengelolaBarang = "";
	var $pejabatPengelolaBarang = "";
	var $pengurusPengelolaBarang = "";
	var $nipPengelola = "";
	var $nipPejabat = "";
	var $nipPengurus ="";
	var $kondisiBarang = "and f != '06' and f!='07' and f!='08'";
	var $reportURL7 = "pages.php?Pg=penetapanRKBMDPengadaan&tipe=Pengadaan7";

	//untuk view
	function setTitle(){
		return 'PENETAPAN RKBMD PENGADAAN';
	}
	function setPage_Header($IconPage='', $TitlePage=''){

		return createHeaderPage($this->PageIcon, "RKBMD PENGADAAN $this->jenisAnggaran TAHUN $this->tahun");
	}
	function setMenuEdit(){
			if ($this->jenisForm == "PENYUSUNAN"){
			 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".InputBaru()","sections.png","Baru ", 'Baru ')."</td>".
							"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
							"<td>".genPanelIcon("javascript:".$this->Prefix.".remove()","delete_f2.png","Hapus", 'Hapus')."</td>".

				"<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
			 }elseif ($this->jenisForm == "KOREKSI PENGGUNA"){
			 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
		     }elseif ($this->jenisForm == "KOREKSI PENGELOLA"){

			 $listMenu =  "<td>".genPanelIcon("javascript:".$this->Prefix.".tetapkanRKBMD()","publishdata.png","Tetapkan", 'Tetapkan RKBMD')."</td>";
		     }else{
		 	 	$listMenu =  "<td>".genPanelIcon("javascript:".$this->Prefix.".tetapkanRKBMD()","info.png","Tetapkan", 'Tetapkan RKBMD')."</td>"."<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
			 }
		 	  // $listMenu .=  "<td>".genPanelIcon("javascript:".$this->Prefix.".excel()","export_xls.png","Excell", 'Excell')."</td>";

		 return $listMenu;
	}
	function setPage_HeaderOther(){
   		return
		"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
<!--		<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=renjaAset\" title='MURNI' style='color : blue;' > MURNI </a> |
		<A href=\"pages.php?Pg=renjaAsetPerubahan\" title='PERUBAHAN' > PERUBAHAN </a>

		&nbsp&nbsp&nbsp
		</td></tr>
-->
		<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=renjaAset\" title='RENJA'  > RENJA </a> |
		<A href=\"pages.php?Pg=rkbmdPengadaan_v3\" title='RKBMD'   > RKBMD </a> |
		<A href=\"pages.php?Pg=koreksiPengelolaPengadaan\" title='RKBMD PENGELOLA'  > RKBMD PENGELOLA </a> |
		<A href=\"pages.php?Pg=penetapanRKBMDPengadaan\" title='RKBMD PENGELOLA'  style='color : blue;'> PENETAPAN RKBMD </a>

		&nbsp&nbsp&nbsp
		</td></tr>

		<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=penetapanRKBMDPengadaan\" title='RKBMD'  style='color : blue;' > PENGADAAN </a> |
		<A href=\"pages.php?Pg=penetapanRKBMDPemeliharaan\" title='RKBMD PENGELOLA' > PEMELIHARAAN </a> |
		<A href=\"pages.php?Pg=penetapanRKBMDPersediaan\" title='RKBMD PERSEDIAAN' > PERSEDIAAN </a>

		&nbsp&nbsp&nbsp
		</td></tr>


		</table>";
	}


   	function setMenuView(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";

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
			/*"<table width=\"100%\" border=\"0\">
				<tr>
					<td class=\"subjudulcetak\">".PrintSKPD2($fmSKPD, $fmUNIT, $fmSUBUNIT)."</td>
				</tr>
			</table><br>";*/
	}

	//function setPage_IconPage(){		return 'images/masterData_ico.gif';	}

	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;

	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	function generateDate($tanggal){
			$tanggal = explode("-",$tanggal);
			$tanggal = $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];
			return $tanggal;
	}
	function set_selector_other($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;

	  switch($tipe){
	  case 'excel':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 /*if($penetapanRKBMDPengadaanSkpdfmUrusan =='0'){
			 	$err = "Pilih Urusan";
			 }elseif($penetapanRKBMDPengadaanSkpdfmSKPD =='00'){
			 	$err = "Pilih Bidang";
			 }elseif($penetapanRKBMDPengadaanSkpdfmUNIT =='00'){
			 	$err = "Pilih SKPD";
			 }elseif($penetapanRKBMDPengadaanSkpdfmSUBUNIT =='00'){
			 	$err = "Pilih Unit";
			 }elseif($penetapanRKBMDPengadaanSkpdfmSEKSI =='000'){
			 	$err = "Pilih Sub Unit";
			 }else{*/
			 	$fm = $this->excel($_REQUEST);
						$cek .= $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
			 /*}*/

			break;

		}
	case 'formBaru':{
			$fm = $this->setFormBaru();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'tetapkanRKBMD':{
			$fm = $this->tetapkanRKBMD();
			$cek .= $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
			break;
		}
		case 'newNomorPenetapan':{
			$fm = $this->newNomorPenetapan();
			$cek .= $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
			break;
		}

		case 'cancelPenetapanPengadaan':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			mysql_query("delete from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PENGADAAN' and c1= '$c1' and c='$c' and d='$d'");
			break;
		}
		case 'nomorPenetapanChanged':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$getData = mysql_fetch_array(mysql_query("select * from ref_data_penetapan where id = '$id'"));
			$content = array('tanggalPenetapan' => $this->generateDate($getData['tanggal']), 'namaPejabat' => $getData['nama_pejabat'], 'nip' => $getData['nip'] , 'jabatan' => $getData['jabatan'] );

			break;
		}


		case 'saveTetapkanRKBMD':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			if(empty($nomor)){
					$err = "Isi Nomor Penetapan";
			}

			if($err == ""){
				if(!empty($d) && $d !='00'){
						if(mysql_num_rows(mysql_query("select * from ref_data_penetapan where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 ='$c1' and c= '$c' and d='$d'")) == 0){
								$dataPenetapan = array(
																				"tahun" => $this->tahun,
																				"jenis_anggaran" => $this->jenisAnggaran,
																				"nomor" => $nomorPenetapan,
																				"nama_pejabat" => $namaPejabat,
																				"nip" => $nip,
																				"jabatan" => $jabatan,
																				"tanggal" => $this->generateDate($tanggalPenetapan),
																				"c1" => $c1,
																				"c" => $c,
																				"d" => $d,
																				);
								$query = VulnWalkerInsert("ref_data_penetapan",$dataPenetapan);
								mysql_query($query);
						}else{
							$dataPenetapan = array(
																			"tahun" => $this->tahun,
																			"jenis_anggaran" => $this->jenisAnggaran,
																			"nomor" => $nomorPenetapan,
																			"nama_pejabat" => $namaPejabat,
																			"nip" => $nip,
																			"jabatan" => $jabatan,
																			"tanggal" => $this->generateDate($tanggalPenetapan),
																			"c1" => $c1,
																			"c" => $c,
																			"d" => $d,
																			);
							$query = VulnWalkerUpdate("ref_data_penetapan",$dataPenetapan,"tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 ='$c1' and c= '$c' and d='$d'");
							mysql_query($query);
						}
						$getIdPenetapan = mysql_fetch_array(mysql_query("select * from ref_data_penetapan where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c ='$c' and d='$d'"));
						$idPenetapan = $getIdPenetapan['id'];
						if($statusPengadaan == "true"){
								if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PENGADAAN' and c1='$c1' and c='$c' and d='$d'"))== 0){
										$data = array(
														'tahun' => $this->tahun,
														'jenis_anggaran' => $this->jenisAnggaran,
														'jenis_rkbmd' => "PENGADAAN",
														'id_data_penetapan' => $idPenetapan,
														'c1' => $c1,
														'c' => $c,
														'd' => $d,
										);
										mysql_query(VulnWalkerInsert("penetapan_rkbmd",$data));
								}
						}else{
								mysql_query("delete from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PENGADAAN' and c1='$c1' and c='$c' and d='$d'");
						}

						if($statusPemeliharaan == "true"){
								if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PEMELIHARAAN' and c1='$c1' and c='$c' and d='$d'"))== 0){
										$data = array(
														'tahun' => $this->tahun,
														'jenis_anggaran' => $this->jenisAnggaran,
														'jenis_rkbmd' => "PEMELIHARAAN",
														'id_data_penetapan' => $idPenetapan,
														'c1' => $c1,
														'c' => $c,
														'd' => $d,
										);
										mysql_query(VulnWalkerInsert("penetapan_rkbmd",$data));
								}
						}else{
								mysql_query("delete from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PEMELIHARAAN' and c1='$c1' and c='$c' and d='$d'");
						}

						if($statusPersediaan == "true"){
								if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PERSEDIAAN' and c1='$c1' and c='$c' and d='$d'"))== 0){
										$data = array(
														'tahun' => $this->tahun,
														'jenis_anggaran' => $this->jenisAnggaran,
														'jenis_rkbmd' => "PERSEDIAAN",
														'id_data_penetapan' => $idPenetapan,
														'c1' => $c1,
														'c' => $c,
														'd' => $d,
										);
										mysql_query(VulnWalkerInsert("penetapan_rkbmd",$data));
								}
						}else{
								mysql_query("delete from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PERSEDIAAN' and c1='$c1' and c='$c' and d='$d'");
						}

				}else{
					if(mysql_num_rows(mysql_query("select * from ref_data_penetapan where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 ='".$c1."' and c= '".$c."' and d='".$d."'")) == 0){
						 $dataPenetapan = array(
																		 "tahun" => $this->tahun,
																		 "jenis_anggaran" => $this->jenisAnggaran,
																		 "nomor" => $nomorPenetapan,
																		 "nama_pejabat" => $namaPejabat,
																		 "nip" => $nip,
																		 "jabatan" => $jabatan,
																		 "tanggal" => $this->generateDate($tanggalPenetapan),
																		 "c1" => $c1,
																		 "c" => $c,
																		 "d" => $d,
																		 );
						 $query = VulnWalkerInsert("ref_data_penetapan",$dataPenetapan);
						 mysql_query($query);
				 }else{
					 $dataPenetapan = array(
																	 "tahun" => $this->tahun,
																	 "jenis_anggaran" => $this->jenisAnggaran,
																	 "nomor" => $nomorPenetapan,
																	 "nama_pejabat" => $namaPejabat,
																	 "nip" => $nip,
																	 "jabatan" => $jabatan,
																	 "tanggal" => $this->generateDate($tanggalPenetapan),
																	 "c1" => $c1,
																	 "c" => $c,
																	 "d" => $d,
																	 );
					 $query = VulnWalkerUpdate("ref_data_penetapan",$dataPenetapan,"tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 ='".$c1."' and c= '".$c."' and d='".$d."'");
					 mysql_query($query);
				 }
				 $getIdPenetapan = mysql_fetch_array(mysql_query("select * from ref_data_penetapan where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c ='$c' and d='$d'"));
				 $idPenetapan = $getIdPenetapan['id'];
				 if($statusPengadaan == "true"){
						 if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PENGADAAN' and c1='$c1' and c='$c' and d='$d'"))== 0){
								 $data = array(
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'jenis_rkbmd' => "PENGADAAN",
												 'id_data_penetapan' => $idPenetapan,
												 'c1' => $c1,
												 'c' => $c,
												 'd' => $d,
								 );
								 mysql_query(VulnWalkerInsert("penetapan_rkbmd",$data));
						 }
				 }else{
						 mysql_query("delete from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PENGADAAN' and c1='$c1' and c='$c' and d='$d'");
				 }

				 if($statusPemeliharaan == "true"){
						 if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PEMELIHARAAN' and c1='$c1' and c='$c' and d='$d'"))== 0){
								 $data = array(
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'jenis_rkbmd' => "PEMELIHARAAN",
												 'id_data_penetapan' => $idPenetapan,
												 'c1' => $c1,
												 'c' => $c,
												 'd' => $d,
								 );
								 mysql_query(VulnWalkerInsert("penetapan_rkbmd",$data));
						 }
				 }else{
						 mysql_query("delete from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PEMELIHARAAN' and c1='$c1' and c='$c' and d='$d'");
				 }

				 if($statusPersediaan == "true"){
						 if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PERSEDIAAN' and c1='$c1' and c='$c' and d='$d'"))== 0){
								 $data = array(
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'jenis_rkbmd' => "PERSEDIAAN",
												 'id_data_penetapan' => $idPenetapan,
												 'c1' => $c1,
												 'c' => $c,
												 'd' => $d,
								 );
								 mysql_query(VulnWalkerInsert("penetapan_rkbmd",$data));
						 }
				 }else{
						 mysql_query("delete from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PERSEDIAAN' and c1='$c1' and c='$c' and d='$d'");
				 }
				 	$getdataSKPD = mysql_query("select * from ref_skpd where d!='00' and e ='00'");
					 while($dataSKPD = mysql_fetch_array($getdataSKPD)){

					  if($statusPengadaan == "true"){
					      if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PENGADAAN' and c1='".$dataSKPD['c1']."' and c='".$dataSKPD['c']."' and d='".$dataSKPD['d']."'"))== 0){
					          $dataPenetapan = array(
					                  'tahun' => $this->tahun,
					                  'jenis_anggaran' => $this->jenisAnggaran,
					                  'jenis_rkbmd' => "PENGADAAN",
					                  'id_data_penetapan' => $idPenetapan,
					                  'c1' => $dataSKPD['c1'],
					                  'c' => $dataSKPD['c'],
					                  'd' => $dataSKPD['d'],
					          );
					          mysql_query(VulnWalkerInsert("penetapan_rkbmd",$dataPenetapan));
					      }
					  }else{
					      mysql_query("delete from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PENGADAAN' and c1='".$dataSKPD['c1']."' and c='".$dataSKPD['c']."' and d='".$dataSKPD['d']."'");
					  }

					  if($statusPemeliharaan == "true"){
					      if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PEMELIHARAAN' and c1='".$dataSKPD['c1']."' and c='".$dataSKPD['c']."' and d='".$dataSKPD['d']."'"))== 0){
					          $dataPenetapan = array(
					                  'tahun' => $this->tahun,
					                  'jenis_anggaran' => $this->jenisAnggaran,
					                  'jenis_rkbmd' => "PEMELIHARAAN",
					                  'id_data_penetapan' => $idPenetapan,
					                  'c1' => $dataSKPD['c1'],
					                  'c' => $dataSKPD['c'],
					                  'd' => $dataSKPD['d'],
					          );
					          mysql_query(VulnWalkerInsert("penetapan_rkbmd",$dataPenetapan));
					      }
					  }else{
					      mysql_query("delete from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PEMELIHARAAN' and c1='".$dataSKPD['c1']."' and c='".$dataSKPD['c']."' and d='".$dataSKPD['d']."'");
					  }

					  if($statusPersediaan == "true"){
					      if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PERSEDIAAN' and c1='".$dataSKPD['c1']."' and c='".$dataSKPD['c']."' and d='".$dataSKPD['d']."'"))== 0){
					          $dataPenetapan = array(
					                  'tahun' => $this->tahun,
					                  'jenis_anggaran' => $this->jenisAnggaran,
					                  'jenis_rkbmd' => "PERSEDIAAN",
					                  'id_data_penetapan' => $idPenetapan,
					                  'c1' => $dataSKPD['c1'],
					                  'c' => $dataSKPD['c'],
					                  'd' => $dataSKPD['d'],
					          );
					          mysql_query(VulnWalkerInsert("penetapan_rkbmd",$dataPenetapan));
					      }
					  }else{
					      mysql_query("delete from penetapan_rkbmd where tahun='$this->tahun' and jenis_anggaran = 'MURNI' and jenis_rkbmd = 'PERSEDIAAN' and c1='".$dataSKPD['c1']."' and c='".$dataSKPD['c']."' and d='".$dataSKPD['d']."'");
					  }
					 }
				}

			}
			break;
		}
		case 'saveNomorPenetapan':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			if(empty($nomor)){
					$err = "Isi Nomor Penetapan";
			}elseif(empty($tanggalPenetapan)){
					$err = "Isi Tanggal Penetapan";
			}elseif(empty($namaPejabat)){
					$err = "Isi Nama Pejabat";
			}elseif(empty($jabatan)){
					$err = "Isi Jabatan";
			}
			if($err == ""){

						$tanggalPenetapan = explode("-",$tanggalPenetapan);
						$tanggalPenetapan = $tanggalPenetapan[2]."-".$tanggalPenetapan[1]."-".$tanggalPenetapan[0];
						$data = array(
										'tahun' => $this->tahun,
										'jenis_anggaran' => $this->jenisAnggaran,
										'nomor' => $nomor,
										'nip' => $nip,
										'tanggal' => $tanggalPenetapan,
										'nama_pejabat' => $namaPejabat,
										'jabatan' => $jabatan,
						);
						if(mysql_num_rows(mysql_query("select * from ref_data_penetapan where nomor  ='$nomor'")) !=0){
								$err = "Nomor sudah ada !";
						}else{
								mysql_query(VulnWalkerInsert("ref_data_penetapan",$data));
								$getMaxIdPenetapan = mysql_fetch_array(mysql_query("select max(id) from ref_data_penetapan"));
								$content = array('comboNomorPenetapan' => cmbQuery('nomorPenetapan', $getMaxIdPenetapan['max(id)'], "select id,nomor from ref_data_penetapan","onchange=$this->Prefix.nomorPenetapanChanged();",'-- NOMOR PENETAPAN --'));

						}


			}
			break;
		}
		case 'Report':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$namaPemda = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'nama_pemda' "));
			if($jenisKegiatan==''){
					$err = "Pilih Format Laporan";
			}else{
			  	$data = array(
			 				'c1' => $c1,
							'c' => $c,
							'd' => $d,
							'e' => $e,
							'e1' => $e1,
							'username' => $this->username
			 				);
			if(mysql_num_rows(mysql_query("select * from skpd_report_rkbmd where username= '$this->username'")) == 0){
				$query = VulnWalkerInsert('skpd_report_rkbmd', $data);
			}else{
				$query = VulnWalkerUpdate('skpd_report_rkbmd', $data, "username = '$this->username'");
			}
			mysql_query($query);
			  }
			$content= array('to' => $jenisKegiatan,'cetakjang'=>$cetakjang,'namaPemda'=>$namaPemda[option_value]);
		break;
		}
		case 'Pengadaan1':{
			$json = FALSE;
			$this->Pengadaan1();
		break;
		}
		case 'Pengadaan2':{
			$json = FALSE;
			$this->Pengadaan2();
		break;
		}
		case 'Pengadaan3':{
			$json = FALSE;
			$this->Pengadaan3();
		break;
		}
		case 'Pengadaan4':{
			$json = FALSE;
			$this->Pengadaan4();
		break;
		}
		case 'Pengadaan5':{
			$json = FALSE;
			$this->Pengadaan5();
		break;
		}
		case 'Pengadaan6':{
			$json = FALSE;
			$this->Pengadaan6();
		break;
		}
		case 'Pengadaan7':{
			$json = FALSE;
			$this->Pengadaan7();
		break;
		}

		case 'Info':{
				$fm = $this->Info();
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'comboBoxPemenuhan':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			 $caraPemenuhan =  "select cara_pemenuhan ,cara_pemenuhan from ref_cara_pemenuhan" ;
			 $cmbCaraPemenuhan = cmbQuery('pemenuhan'.$id, "PEMBELIAN", $caraPemenuhan,' ','-- CARA PEMENUHAN --');
			 $content = array('caraPemenuhan' => $cmbCaraPemenuhan ,'tambahCaraPemenuhan' => "<img style='margin-top: 3px;cursor:pointer;' src='datepicker/add-button-md.png' width='20px' heigh='20px'  onclick='$this->Prefix.formPemenuhan($id);'></img>" );



		break;
		}
		case 'newTab':{
			 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 $nomorUrutSebelumnya = $this->nomorUrut - 1;
			 $cekKeberadaanMangkluk =  mysql_num_rows(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$penetapanRKBMDPengadaanSkpdfmUrusan' and c = '$penetapanRKBMDPengadaanSkpdfmSKPD' and d='$penetapanRKBMDPengadaanSkpdfmUNIT' and e = '$penetapanRKBMDPengadaanSkpdfmSUBUNIT' and e1='$penetapanRKBMDPengadaanSkpdfmSEKSI'  and q!='0' and no_urut ='$nomorUrutSebelumnya' "));
			 $getDatarenja = mysql_fetch_array(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$penetapanRKBMDPengadaanSkpdfmUrusan' and c = '$penetapanRKBMDPengadaanSkpdfmSKPD' and d='$penetapanRKBMDPengadaanSkpdfmUNIT' and e = '$penetapanRKBMDPengadaanSkpdfmSUBUNIT' and e1='$penetapanRKBMDPengadaanSkpdfmSEKSI' and q!='0' and no_urut = '$nomorUrutSebelumnya'"));
			 $lastID = $getDatarenja['id_anggaran'];
			 	if($cekKeberadaanMangkluk != 0){
					if($getDatarenja['jenis_form_modul']  == 'PENYUSUNAN' ){
						$getJumlahRenjaValidasi = mysql_num_rows(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$penetapanRKBMDPengadaanSkpdfmUrusan' and c = '$penetapanRKBMDPengadaanSkpdfmSKPD' and d='$penetapanRKBMDPengadaanSkpdfmUNIT' and e = '$penetapanRKBMDPengadaanSkpdfmSUBUNIT' and e1='$penetapanRKBMDPengadaanSkpdfmSEKSI' and q!='0' $this->sqlValidasi and no_urut = '$nomorUrutSebelumnya'"));
						if($getJumlahRenjaValidasi == 0){
							$err = "Renja Belum Di Validasi";
						}
					}

					$getParentpenetapanRKBMDPengadaan = mysql_fetch_array(mysql_query("select * from view_renja where id_anggaran = '$lastID'"));
					$parentC1 = $getParentpenetapanRKBMDPengadaan['c1'];
					$parentC = $getParentpenetapanRKBMDPengadaan['c'];
					$parentD = $getParentpenetapanRKBMDPengadaan['d'];
					$parentE = $getParentpenetapanRKBMDPengadaan['e'];
					$parentE1= $getParentpenetapanRKBMDPengadaan['e1'];
					$getIdRenja = mysql_fetch_array(mysql_query("select * from view_renja where tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$parentC1' and c = '$parentC' and d = '$parentD' and e = '$parentE' and e1 = '$parentE1' and p = '0' and q = '0' and no_urut = '$nomorUrutSebelumnya' "));
					$idrenja = $getIdRenja['id_anggaran'];
					if($cmbJenispenetapanRKBMDPengadaan == 'PENGADAAN'){
						$kemana = 'ins_v3';
					}else{
						$kemana = 'pemeliharaan_v3';
					}
					$username = $_COOKIE['coID'];
					mysql_query("delete from temp_rkbmd_pengadaan where user = '$username'");
					mysql_query("delete from temp_rkbmd_pemeliharaan where user = '$username'");
					mysql_query("delete from rkbmd_pemeliharaan where user = '$username'");
				}else{
					$err  = "Renja Belum ada atau belum di Koreksi";

				}


				$content = array('idrenja' => $idrenja, "kemana" =>$kemana);
			break;
		}
		case 'editTab':{
			 $id = $_REQUEST['penetapanRKBMDPengadaan_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
					$nomorUrutSebelumnya = $this->nomorUrut - 1;
					$getParentpenetapanRKBMDPengadaan = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran = '$id[0]'"));
					foreach ($getParentpenetapanRKBMDPengadaan as $key => $value) {
				 		 $$key = $value;
					 }
					$parentC1 = $getParentpenetapanRKBMDPengadaan['c1'];
					$parentC = $getParentpenetapanRKBMDPengadaan['c'];
					$parentD = $getParentpenetapanRKBMDPengadaan['d'];
					$parentE = $getParentpenetapanRKBMDPengadaan['e'];
					$parentE1= $getParentpenetapanRKBMDPengadaan['e1'];
					$getIdRenja = mysql_fetch_array(mysql_query("select * from view_renja where tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$parentC1' and c = '$parentC' and d = '$parentD' and e = '$parentE' and e1 = '$parentE1' and p = '0' and q = '0' and no_urut = '$nomorUrutSebelumnya' "));
					$idrenja = $getIdRenja['id_anggaran'];
					if($cmbJenispenetapanRKBMDPengadaan == 'PENGADAAN'){
						$kemana = 'ins_v3';
					}else{
						$kemana = 'pemeliharaan_v3';
					}
					$username = $_COOKIE['coID'];
					mysql_query("delete from temp_rkbmd_pengadaan where user = '$username'");
					mysql_query("delete from temp_rkbmd_pemeliharaan where user = '$username'");
					mysql_query("delete from rkbmd_pemeliharaan where user = '$username'");

					$execute = mysql_query("select * from view_rkbmd where  c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun='$this->tahun' and id_tahap ='$this->idTahap' and f !='00' ");
							while($rows = mysql_fetch_array($execute)){
							foreach ($rows as $key => $value) {
					 			 $$key = $value;
						 	}
							$data  = array(
							   "c1" => $c1,
							   "c" => $c,
							   "d" => $d,
							   "e" => $e,
							   "e1" => $e1,
							   "bk" => $bk,
							   "ck" => $ck,
							   "dk" => $dk,
							   "p" => $p,
							   "q" => $q,
							   "f" => $f,
							   "g" => $g,
							   "h" => $h,
							   "i" => $i,
							   "j" => $j,
							   "satuan" => $satuan_barang,
							   "jumlah" => $volume_barang,
							   "catatan" => $catatan,
							   "user" => $_COOKIE['coID']
							);
							if($status_validasi == '1'){
								//$err = "Data Telah Di Validasi !";
							}else{
								mysql_query(VulnWalkerInsert('temp_rkbmd_pengadaan',$data));
							}

						}




				$content = array('idrenja' => $idrenja, "kemana" =>$kemana, "qc" => "select * from view_rkbmd where id_anggaran = '$id[0]'");
			break;
		}
		case 'Laporan':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 /*if($penetapanRKBMDPengadaanSkpdfmUrusan =='0'){
			 	$err = "Pilih Urusan";
			 }elseif($penetapanRKBMDPengadaanSkpdfmSKPD =='00'){
			 	$err = "Pilih Bidang";
			 }elseif($penetapanRKBMDPengadaanSkpdfmUNIT =='00'){
			 	$err = "Pilih SKPD";
			 }elseif($penetapanRKBMDPengadaanSkpdfmSUBUNIT =='00'){
			 	$err = "Pilih Unit";
			 }elseif($penetapanRKBMDPengadaanSkpdfmSEKSI =='000'){
			 	$err = "Pilih Sub Unit";
			 }else{*/
			 	$fm = $this->Laporan($_REQUEST);
						$cek .= $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
			 /*}*/

			break;

		}

		case 'Validasi':{
				$dt = array();
				$err='';
				$content='';
				$uid = $HTTP_COOKIE_VARS['coID'];

				$cbid = $_REQUEST[$this->Prefix.'_cb'];
				$idplh = $_REQUEST['id_anggaran'];
				$this->form_idplh = $_REQUEST['id_anggaran'];


					$qry = "SELECT * FROM tabel_anggaran WHERE id_anggaran = '$idplh' ";$cek=$qry;
					$aqry = mysql_query($qry);
					$dt = mysql_fetch_array($aqry);
					$username = $_COOKIE['coID'];
					$user_validasi = $dt['user_validasi'];
					$user_update = $dt['user_update'];

					if ($username != $user_validasi && $dt['status_validasi'] == '1') {
						$getNamaOrang = mysql_fetch_array(mysql_query("select * from admin where uid = '$user_validasi'"));
						$err = "Data Sudah di Validasi, Perubahan Hanya Bisa Dilakukan oleh ".$getNamaOrang['nama']." !";
					}else{
						if($username == $user_update){
							$err = "User yang membuat tidak dapat melakukan VALIDASI";
						}
					}
					if($this->jenisForm !='PENYUSUNAN')$err = "Tahap Penyusunan Telah Habis";
					if($err == ''){
						$fm = $this->Validasi($dt);
						$cek .= $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
					}



			break;
		}
		case 'SaveValid':{
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 if ($validasi == 'on') {
			 	 $status_validasi = "1";
			 }else{
			 	$status_validasi = "0";
			 }
			 $getSKPD = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$penetapanRKBMDPengadaan_idplh'"));
			 $cmbUrusanForm = $getSKPD['c1'];
			 $cmbBidangForm = $getSKPD['c'];
			 $cmbSKPDForm = $getSKPD['d'];
			 $cmbUnitForm = $getSKPD['e'];
			 $cmbSubUnitForm = $getSKPD['e1'];
			 $bk= $getSKPD['bk'];
			 $ck = $getSKPD['ck'];
			 $dk = $getSKPD['dk'];
			 $p = $getSKPD['p'];
			 $q = $getSKPD['q'];


			 $data = array( "status_validasi" => $status_validasi,
			 				'user_validasi' => $_COOKIE['coID'],
			 				'tanggal_validasi' => date("Y-m-d")
			 				);
			 $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$penetapanRKBMDPengadaan_idplh'");
			 mysql_query($query);

			$content .= $query;
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
	   case 'remove':{
			$id = $_REQUEST['penetapanRKBMDPengadaan_cb'];
			for($i = 0 ; $i < sizeof($id) ; $i++ ){
				$getData = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran='$id[$i]'"));
				$c1 = $getData['c1'];
				$c = $getData['c'];
				$d = $getData['d'];
				$e = $getData['e'];
				$e1 = $getData['e1'];
				$bk = $getData['bk'];
				$ck = $getData['ck'];
				$dk = $getData['dk'];
				$p = $getData['p'];
				$q = $getData['q'];

				$get = mysql_query("select * from tabel_anggaran where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun='$this->tahun' and id_tahap ='$this->idTahap' and ((id_jenis_pemeliharaan = '0' and f !='00') or uraian_pemeliharaan = 'RKBMD PENGADAAN') and id_anggaran!='$id[$i]' ");
				while($rows= mysql_fetch_array($get)){
					foreach ($rows as $key => $value) {
					  $$key = $value;
					}
					if($status_validasi == '1'){
					}else{

						if($j !='000'){
							mysql_query("delete from tabel_anggaran where id_anggaran ='$id_anggaran' ");
						}
					}
				}

			}

		break;
		}
		case 'koreksi':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
			$getpenetapanRKBMDPengadaannya = mysql_fetch_array(mysql_query($queryRows));
			foreach ($getpenetapanRKBMDPengadaannya as $key => $value) {
				  $$key = $value;
			}


			$nextNomorUrut = $this->nomorUrut + 2;
			if($this->jenisForm !='KOREKSI PENGGUNA' && $this->jenisForm !='KOREKSI PENGELOLA'){
				$err = "Tahap Koreksi Telah Habis";
			}elseif(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '3' and tahun ='$this->tahun' and jenis_anggaran ='PERUBAHAN' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan'")) != 0){
				$err = "Data Yang Telah Masuk RKBMD PERUBAHAN";
			}else{
				$cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '0' and ck = '0' and dk = '0' and p = '0' and q= '0' and id_tahap='$this->idTahap'"));
				if($cekSKPD < 1){
					$data = array('jenis_anggaran' => $this->jenisAnggaran,
								  'tahun' => $this->tahun,
								  'c1' => $c1,
								  'c' => $c,
								  'd' => $d,
								  'e' => $e,
								  'e1' => $e1,
								  'bk' => '0',
								  'ck' => '0',
								  'dk' => '0',
								  'p' => '0',
								  'q' => '0',
								  'f1' => '0',
							  				'f2' => '0',
							  				'f' => '00',
							 			    'g' => '00',
							  			    'h' => '00',
										    'i' => '00',
										    'j' => '000',
								  'id_tahap' => $this->idTahap,
								  'nama_modul' => "RKBMD",
								  'tanggal_update' => date('Y-m-d'),
								  'user_update' => $_COOKIE['coID']
									);
						mysql_query(VulnWalkerInsert('tabel_anggaran',$data));
				}
				$cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q= '0' and id_tahap='$this->idTahap'"));
				if($cekProgram < 1){
					$data = array('jenis_anggaran' => $this->jenisAnggaran,
								  'tahun' => $this->tahun,
								  'c1' => $c1,
								  'c' => $c,
								  'd' => $d,
								  'e' => $e,
								  'e1' => $e1,
								  'bk' => $bk,
								  'ck' => $ck,
								  'dk' => $dk,
								  'p' => $p,
								  'q' => '0',
								  'f1' => '0',
							  				'f2' => '0',
							  				'f' => '00',
							 			    'g' => '00',
							  			    'h' => '00',
										    'i' => '00',
										    'j' => '000',
								  'id_tahap' => $this->idTahap,
								  'nama_modul' => "RKBMD",
								  'tanggal_update' => date('Y-m-d'),
								  'user_update' => $_COOKIE['coID']
									);
						mysql_query(VulnWalkerInsert('tabel_anggaran',$data));
				}

				$cekKegiatanPengadaan = mysql_num_rows(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q= '$q' and  f='00' and id_tahap='$this->idTahap' and uraian_pemeliharaan = 'RKBMD PENGADAAN'"));
				if($cekKegiatanPengadaan < 1){
					$data = array('jenis_anggaran' => $this->jenisAnggaran,
								  'tahun' => $this->tahun,
								  'c1' => $c1,
								  'c' => $c,
								  'd' => $d,
								  'e' => $e,
								  'e1' => $e1,
								  'bk' => $bk,
								  'ck' => $ck,
								  'dk' => $dk,
								  'p' => $p,
								  'q' => $q,
								  'f1' => '0',
							  				'f2' => '0',
							  				'f' => '00',
							 			    'g' => '00',
							  			    'h' => '00',
										    'i' => '00',
										    'j' => '000',
								  'id_tahap' => $this->idTahap,
								  'nama_modul' => "RKBMD",
								  'tanggal_update' => date('Y-m-d'),
								  'user_update' => $_COOKIE['coID'],
								  'uraian_pemeliharaan' => 'RKBMD PENGADAAN'
									);
						mysql_query(VulnWalkerInsert('tabel_anggaran',$data));
				}






			 $dataSesuai = array(           'jenis_anggaran' => $this->jenisAnggaran,
											'tahun' => $this->tahun,
											'c1' => $c1,
											'c' => $c,
											'd' => $d,
											'e' => $e,
											'e1' => $e1,
											'bk' => $bk,
											'ck' => $ck,
											'dk' => $dk,
											'p' => $p,
											'q' => $q,
											'f1' => $f1,
											'f2' => $f2,
											'f' => $f,
											'g' => $g,
											'h' => $h,
											'i' => $i,
											'j' => $j,
											'cara_pemenuhan' => $caraPemenuhan,
											'volume_barang' => $angkaKoreksi,
											'id_tahap' => $this->idTahap,
											'nama_modul' => $this->modul,
											'satuan_barang' => $satuan_barang,
											'uraian_pemeliharaan' => $uraian_pemeliharaan,
											'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
											'user_update' => $_COOKIE['coID'],
											'tanggal_update' => date('Y-m-d'),
											'catatan' => $catatan


 								);

			  $kodeBarang =$f1.".".$f2.".".$f.".".$g.".".$h.".".$i.".".$j ;
			  $kodeSKPD = $c1.".".$c.".".$d.".".$e.".".$e1;
			  $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
			  $concat = $kodeSKPD.".".$kodeBarang;

				  $getKebutuhanMax = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat'"));
				  $kebutuhanMax = $getKebutuhanMax['jumlah'];
				  $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' "));
				  $jumlahOptimal = $getKebutuhanOptimal['kebutuhanOptimal'];
				  $kebutuhanRiil = $kebutuhanMax - $jumlahOptimal;
				  $melebihi = "Kebutuhan Riil";




			  $cekKoreksi =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
			  if($cekKoreksi > 0 ){
			   	 $getID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					    $idnya = $getID['id_anggaran'];
						if($angkaKoreksi <= $kebutuhanRiil || (empty($jumlahOptimal) && empty($kebutuhanMax) && $getpenetapanRKBMDPengadaannya['volume_barang'] >= $angkaKoreksi )  ){
							mysql_query("update tabel_anggaran set volume_barang = '$angkaKoreksi' , cara_pemenuhan = '$caraPemenuhan' where id_anggaran='$idnya'");
						}elseif($getpenetapanRKBMDPengadaannya['volume_barang'] < $angkaKoreksi){
							$err = "Jumlah Koreksi Tidak Melebihi Pengajuan";
						}else{
							$err = "Tidak dapat melebihi $melebihi";
						}

			}else{
						if($angkaKoreksi <= $kebutuhanRiil || (empty($jumlahOptimal) && empty($kebutuhanMax) ) && $getpenetapanRKBMDPengadaannya['volume_barang'] >= $angkaKoreksi ){
							mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));
							/*$dugDung = array('status_validasi' => '1');
							mysql_query(VulnWalkerUpdate("tabel_anggaran",$dugDung, " id_anggaran = '$idAwal'" ));*/
						}elseif($getpenetapanRKBMDPengadaannya['volume_barang'] < $angkaKoreksi){
							$err = "Jumlah Koreksi Tidak Melebihi Pengajuan";
						}else{
							$err = "Tidak dapat melebihi $melebihi";

						}

			}

			}







		break;
	    }
		case 'Catatan':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			$getData = mysql_fetch_array(mysql_query("SELECT * FROM tabel_anggaran WHERE id_anggaran = '$idAwal'"));
			foreach ($getData as $key => $value) {
				  $$key = $value;
			}
			$getMaxID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
			$maxID = $getMaxID['id_anggaran'];
			$aqry = "select * from tabel_anggaran where id_anggaran ='$maxID' ";
			$dt = mysql_fetch_array(mysql_query($aqry));
			if($dt['id_tahap'] != $this->idTahap){
				$err = "Data Belum Di Koreksi ";
			}
			if($err == ''){
				$fm = $this->Catatan($dt);
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			}


		break;
		}

		case 'formPemenuhan':{
				$dt = $_REQUEST['id'];
				$fm = $this->formPemenuhan($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


		break;
		}
		case 'SaveCatatan':{
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			 $data = array( "catatan" => $catatan
			 				);
			 $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$id'");
			 mysql_query($query);

			$content .= $query;
		break;
	    }
		case 'SaveCaraPemenuhan':{
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			 $data = array( "cara_pemenuhan" => $caraPemenuhan
			 				);
			 $query = VulnWalkerInsert("ref_cara_pemenuhan",$data);
			 $execute = mysql_query($query);
			 if($execute){

			 }else{
			 	$err = "input gagal";
			 }

			$content .= $query;
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
		$noUrutKoreksi = $this->nomorUrut - 1;
		$angka = mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap'"));
	   if($this->jenisForm == "KOREKSI"){
	   	 $noUrutKoreksi  = $this->nomorUrut - 1;
	   	 $angka = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$noUrutKoreksi'"));
	   }
	   if(empty($angka))$angka = 25;
		$scriptload =

					"<script>
						$(document).ready(function(){

							".$this->Prefix.".loading();

						});

					function checkAll4( n, fldName ,elHeaderChecked, elJmlCek) {

			  if (!fldName) {
			     fldName = 'cb';
			  }
			   if (!elHeaderChecked) {
			     elHeaderChecked = 'toggle';
			  }
				var c = document.getElementById(elHeaderChecked).checked;
				var n2 = 0;
				for (i=0; i < ".$angka."; i++) {
					cb = document.getElementById(fldName+i);
					if (cb) {
						cb.checked = c;
						n2++;
					}
				}
				if (c) {
					document.getElementById(elJmlCek).value = n2;
				} else {
					document.getElementById(elJmlCek).value = 0;
				}
		}


					</script>";

		return
			"

			<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/perencanaan_v3/rkbmd/penetapanRKBMDPengadaan.js' language='JavaScript' ></script>
			 	<script type='text/javascript' src='js/perencanaan_v3/rkbmd/penetapanRKBMDPengadaanNew.js' language='JavaScript' ></script>".
			 '<link rel="stylesheet" href="datepicker/jquery-ui.css">
			 <script src="datepicker/jquery-1.12.4.js"></script>
			 <script src="datepicker/jquery-ui.js"></script>'.
			$scriptload;
	}

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
/*		$nomorUrutSebelumnya = $this-> -1;*/

			$nomorUrutSebelumnya = $this->nomorUrut - 1;
			$getJenisFormSebelumnya = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran = '$this->jenisAnggaran'"));
			$jenisFormSebelumnya = $getJenisFormSebelumnya['jenis_form_modul'];

					$headerTable =
					 "<thead>
					 <tr>
					 	   <th class='th01' align='center' rowspan='2' colspan='1' width='20'>NO</th>
					     <th class='th01' align='center' rowspan='2' colspan='1' width='200'>SKPD/PROGRAM/KEGIATAN/OUTPUT</th>
				   	   <th class='th02' align='center' rowspan='1' colspan='4' width='200'>PENETAPAN BMD</th>


					   </tr>
					   <tr>
					      <th class='th01' align='center'  width='1000'>NAMA BARANG</th>
						    <th class='th01' align='center'  width='80'>JML</th>
					      <th class='th01' align='center'  width='100'>SATUAN</th>
					      <th class='th01' align='center'  width='100'>CARA PEMENUHAN</th>

					   </tr>
					   </thead>";










		return $headerTable;
	}
	function tetapkanRKBMD($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 270;
	 $this->form_caption = 'PENETAPAN RKBMD PENGADAAN';
	 $catatan = $dt['catatan'];
	 $idnya = $dt['id_anggaran'];

	 if(!empty($_REQUEST['penetapanRKBMDPengadaanSkpdfmUrusan']) && $_REQUEST['penetapanRKBMDPengadaanSkpdfmUrusan'] !='0' ){

		 if(empty($_REQUEST['penetapanRKBMDPengadaanSkpdfmSKPD']) || $_REQUEST['penetapanRKBMDPengadaanSkpdfmSKPD'] =='00'){
				$err = "Pilih Bidang";
		 }elseif(empty($_REQUEST['penetapanRKBMDPengadaanSkpdfmUNIT']) || $_REQUEST['penetapanRKBMDPengadaanSkpdfmUNIT'] =='00'){
				$err = "Pilih SKPD";
		 }else{
			 $getNamaUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1= '".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUrusan']."' and c= '00' and d= '00'"));
			 $namaUrusan = $_REQUEST['penetapanRKBMDPengadaanSkpdfmUrusan'].". ".$getNamaUrusan['nm_skpd'];
			 $getNamaBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1= '".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUrusan']."' and c= '".$_REQUEST['penetapanRKBMDPengadaanSkpdfmSKPD']."' and d= '00'"));
			 $namaBidang = $_REQUEST['penetapanRKBMDPengadaanSkpdfmSKPD'].". ".$getNamaBidang['nm_skpd'];
			 $getNamaSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1= '".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUrusan']."' and c= '".$_REQUEST['penetapanRKBMDPengadaanSkpdfmSKPD']."' and d= '".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUNIT']."'"));
			 $namaSKPD = $_REQUEST['penetapanRKBMDPengadaanSkpdfmUNIT'].". ".$getNamaSKPD['nm_skpd'];
		 }
	 }else{
		  $namaUrusan = "SEMUA URUSAN";
		  $namaBidang = "SEMUA BIDANG";
		  $namaSKPD = "SEMUA SKPD";
	 }





	 if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  and c1 ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUrusan']."' and c ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmSKPD']."' and d ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUNIT']."'  ")) !=0){
		 		$batalkanPenetapan = "<input type='button' value='Batalkan Penetapan' onclick ='".$this->Prefix.".cancelPenetapanPengadaan()' title='Batalkan Penetapan' > ";
				$getData = mysql_fetch_array(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and  c1 ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUrusan']."' and c ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmSKPD']."' and d ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUNIT']."' "));

				if(mysql_num_rows(mysql_query("select * from ref_data_penetapan where tahun = '$this->tahun' and jenis_anggaran ='MURNI' and c1 ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUrusan']."' and c ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmSKPD']."' and d ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUNIT']."'")) == 0){
				    $getDataPenetapan = mysql_fetch_array(mysql_query("select * from ref_data_penetapan where id ='".$getData['id_data_penetapan']."'"));
				}else{
				    $getDataPenetapan = mysql_fetch_array(mysql_query("select * from ref_data_penetapan where tahun = '$this->tahun' and jenis_anggaran ='MURNI' and c1 ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUrusan']."' and c ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmSKPD']."' and d ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUNIT']."'"));
				}

				foreach ($getDataPenetapan as $key => $value) {
					  $$key = $value;
				 }
				 $tanggalPenetapan = explode('-',$tanggal);
				 $tanggalPenetapan = $tanggalPenetapan[2]."-".$tanggalPenetapan[1]."-".$tanggalPenetapan[0];
				 $nomorPenetapan = $nomor;

				 $notice = "<span style='color:red;'>* Batalkan penetapan RKBMD agar dapat membuka proses input dan koreksi RKBMD.</span>";
				 $comboNomor =  "<input type='text' name = 'nomorPenetapan' id ='nomorPenetapan' value='$nomorPenetapan' style='width:350px;' > ";
				 if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PENGADAAN' and c1='$c1' and c='$c' and d='$d'"))!=0 )$statusCheckedPengadaan = "checked";
				 if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PEMELIHARAAN' and c1='$c1' and c='$c' and d='$d'"))!=0 )$statusCheckedPemeliharaan = "checked";
				 if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PERSEDIAAN' and c1='$c1' and c='$c' and d='$d'"))!=0 )$statusCheckedPersediaan = "checked";

	 }else{
		   	$batalkanPenetapan = "<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveTetapkanRKBMD()' title='Simpan' >  ";
				$notice = "<span style='color:red;'>* Penetapan RKBMD maka proses input dan koreksi RKBMD tidak dapat dilakukan / dinonaktifkan.</span>";

				$getIdPenetapan = mysql_fetch_array(mysql_query("select * from ref_data_penetapan where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUrusan']."' and c ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmSKPD']."' and d ='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUNIT']."'"));
				$getDataPenetapan = mysql_fetch_array(mysql_query("select * from ref_data_penetapan where id ='".$getIdPenetapan['id']."'"));
				foreach ($getDataPenetapan as $key => $value) {
					  $$key = $value;
				}
				if(mysql_num_rows(mysql_query("select * from ref_data_penetapan where id ='".$getIdPenetapan['id']."'")) !=0){
					$tanggalPenetapan = explode('-',$tanggal);
				 $tanggalPenetapan = $tanggalPenetapan[2]."-".$tanggalPenetapan[1]."-".$tanggalPenetapan[0];
				 $nomorPenetapan = $nomor;
				}
				$comboNomor =  "<input type='text' name = 'nomorPenetapan' id ='nomorPenetapan' value='$nomorPenetapan' style='width:350px;' > ";

	 }

	 $batalkanPenetapan = "<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveTetapkanRKBMD()' title='Simpan' >  ";

	 //items ----------------------
 $this->form_fields = array(
			'kolomUrusan' => array(
						'label'=>'URUSAN',
						'labelWidth'=>150,
						'value'=>$namaUrusan,
						 ),
			'kolomBidang' => array(
						'label'=>'BIDANG',
						'labelWidth'=>150,
						'value'=>$namaBidang,
						 ),
			'kolomSKPD' => array(
						'label'=>'SKPD',
						'labelWidth'=>150,
						'value'=>$namaSKPD,
						 ),
			'nomor' => array(
						'label'=>'NOMOR',
						'labelWidth'=>150,
						'value'=>$comboNomor,
						 ),
			'nomor' => array(
						'label'=>'NOMOR',
						'labelWidth'=>150,
						'value'=>$comboNomor,
						 ),
			'tanggalPenetapan' => array(
						'label'=>'TANGGAL',
						'labelWidth'=>100,
						'value'=>"<input type='text' name ='tanggalPenetapan' id='tanggalPenetapan' value='$tanggalPenetapan' style='width:320px;'>",
						 ),
			'namaPejabat' => array(
						'label'=>'NAMA PEJABAT',
						'labelWidth'=>100,
						'value'=>"<input type='text' name ='namaPejabat'  id='namaPejabat' value='$nama_pejabat' style='width:350px;'>",
						 ),
			'nip' => array(
						'label'=>'NIP',
						'labelWidth'=>100,
						'value'=>"<input type='text' name ='nip' id='nip'  value='$nip' style='width:350px;'>",
						 ),
			'jabatan' => array(
						'label'=>'JABATAN',
						'labelWidth'=>100,
						'value'=>"<input type='text' name ='jabatan'  id='jabatan' value='$jabatan' style='width:350px;'>",
						 ),
			'asdxzcxzasd' => array(
						'label'=>'',
						'labelWidth'=>100,
						'value'=>"<input type='checkbox' name='checkBoxPengadaan'  id='checkBoxPengadaan' $statusCheckedPengadaan> PENGADAAN &nbsp <input type='checkbox' name='checkboxPemeliharaan'  id='checkboxPemeliharaan' $statusCheckedPemeliharaan> PEMELIHARAAN  &nbsp <input type='checkbox' name='checkboxPersediaan'  id='checkboxPersediaan' $statusCheckedPersediaan> PERSEDIAAN",
						'type' => "merge"
						 ),
			'asdas' => array(
						'label'=>'',
						'labelWidth'=>100,
						'value'=>$notice,
						'type' => "merge"
						 ),

			);
		//tombol
		$this->form_menubawah =
			"
			<input type='hidden' name='c1' id='c1' value='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUrusan']."'>
			<input type='hidden' name='c' id='c' value='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmSKPD']."'>
			<input type='hidden' name='d' id='d' value='".$_REQUEST['penetapanRKBMDPengadaanSkpdfmUNIT']."'>

			".
      // 			"<input type='button' value='Baru' onclick ='".$this->Prefix.".newNomorPenetapan()' >&nbsp".
			$batalkanPenetapan.
			"<input type='button' value='Tutup' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function newNomorPenetapan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 160;
	 $this->form_caption = 'NOMOR PENETAPAN BARU';
	 $catatan = $dt['catatan'];
	 $idnya = $dt['id_anggaran'];
	 if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PENGADAAN' ")) !=0){
		 		$batalkanPenetapan = "<input type='button' value='Batalkan Penetapan' onclick ='".$this->Prefix.".cancelPenetapanPengadaan()' title='Batalkan Penetapan' > ";
				$getData = mysql_fetch_array(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PENGADAAN' "));
				foreach ($getData as $key => $value) {
					  $$key = $value;
				 }
				 $tanggalPenetapan = explode('-',$tanggal);
				 $tanggalPenetapan = $tanggalPenetapan[2]."-".$tanggalPenetapan[1]."-".$tanggalPenetapan[0];

	 }else{
		   	$batalkanPenetapan = "<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveTetapkanRKBMD()' title='Simpan' >  ";
	 }

	 //items ----------------------
	 $comboNomor = cmbQuery('nomorPenetapan', $id_data_penetapan, "select * from ref_data_penetapan where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'","onchange=$this->Prefix.nomorPenetapanChanged();",'-- NOMOR PENETAPAN --');
	  $this->form_fields = array(
			'nomor' => array(
						'label'=>'NOMOR',
						'labelWidth'=>150,
						'value'=>"<input type='text' name='newNomorPenetapan' id='newNomorPenetapan'>",
						 ),
			'tanggalPenetapan' => array(
						'label'=>'TANGGAL PENETAPAN',
						'labelWidth'=>100,
						'value'=>"<input type='text' name ='newTanggalPenetapan'  id='newTanggalPenetapan'>",
						 ),
			'namaPejabat' => array(
						'label'=>'NAMA PEJABAT',
						'labelWidth'=>100,
						'value'=>"<input type='text' name ='newNamaPejabat'  id='newNamaPejabat' >",
						 ),
			'nip' => array(
						'label'=>'NIP',
						'labelWidth'=>100,
						'value'=>"<input type='text' name ='newNIP' id='newNIP' >",
						 ),
			'jabatan' => array(
						'label'=>'JABATAN',
						'labelWidth'=>100,
						'value'=>"<input type='text' name ='newJabatan'  id='newJabatan'>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			" ".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNomorPenetapan()' >&nbsp".
			"<input type='button' value='Tutup' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function formPemenuhan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'CARA PEMENUHAN BARU';


	 //items ----------------------
	  $this->form_fields = array(
			'catatan' => array(
						'label'=>'CARA PEMENUHAN',
						'labelWidth'=>130,
						'value'=>"<input type='text' name='caraPemenuhan' id='caraPemenuhan' style='width:210px;'>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveCaraPemenuhan($dt);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) {
		  $$key = $value;
	 }
		$status_validasi = $isi['status_validasi'];


					if($f == '00' && $q =='0')$TampilCheckBox = "";
				   	  if($p =='0'){
						$this->urutanSKPD += 1;
					 	$kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".00.000";
						$getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
					 	$header = $getSubUnit['nm_skpd'];
						$style = "style='font-weight:bold;'";
						$Koloms.= "<td class='$cssclass' align='center'>$this->urutanSKPD</td>";
						$tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
						//$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
						$Koloms.= $tampilHeader;
						$Koloms.= "<td class='$cssclass' align='left'></td>";
						//$Koloms.= "<td class='$cssclass' align='left'></td>";

					 }elseif($p!= '0' && $q=='0'){
					 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".'0';
						$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
						$header = genNumber($ck).".".genNumber($bk).".".genNumber($dk).".".genNumber($p).". ".$getNamaPrgoram['nama'];
						$style = "style='margin-left:5px;'";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
						//$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
						$Koloms.= $tampilHeader;
						$Koloms.= "<td class='$cssclass' align='left'></td>";
						//$Koloms.= "<td class='$cssclass' align='left'></td>";

					 }elseif($f == '00' && $q!='0'){
					 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".$q;
						$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
						$header = genNumber($ck).".".genNumber($bk).".".genNumber($dk).".".genNumber($p).".".genNumber($q).". ".$getNamaPrgoram['nama'];
						$style = "style='margin-left:10px;'";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$tampilHeader = "<td class='$cssclass' align='left' colspan='4'><span $style>".$header."</span></td>";
						//$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
						$Koloms.= $tampilHeader;
						$Koloms.= "<td class='$cssclass' align='left'></td>";

					//	$Koloms.= "<td class='$cssclass' align='left'></td>";

					 }else{
						 $Koloms.= "<td class='$cssclass' align='center'></td>";
						 $tampilHeader = "<td class='$cssclass' align='left' colspan='1'><span $style>".$header."</span></td>";
						 $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
						 $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
						 $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
						 $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
						 $getBarang = mysql_fetch_array(mysql_query($syntax));
						 $namaBarang = $getBarang['nm_barang'];

						 $concat = $kodeSKPD.".".$kodeBarang;
						 $getKebutuhanMax = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat'"));
						 $kebutuhanMax = $getKebutuhanMax['jumlah'];
						 $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' "));
						 $jumlahOptimal = $getKebutuhanOptimal['kebutuhanOptimal'];
						 $kebutuhanRiil = $kebutuhanMax - $jumlahOptimal;

						 $getDataKoreksi = mysql_fetch_array(mysql_query("select sum(volume_barang) from view_rkbmd where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "));
						 $kondisiWarna = "red";

						 if(mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "))  > 0){
						 	$jumlahKoreksi = number_format($getDataKoreksi['sum(volume_barang)'],0,',','.');
						 	$align = "right";
							$tanggalKoreksi = explode("-",$getDataKoreksi['tanggal_update']);
							$tanggalKoreksi = $tanggalKoreksi[2]."-".$tanggalKoreksi[1]."-".$tanggalKoreksi[0];
							$caraPemenuhan = $getDataKoreksi['cara_pemenuhan'];
							$keteranganKoreksi =  $getDataKoreksi['user_update']."/".$tanggalKoreksi;
							$kondisiWarna = "black";
						 }

						 $satuan = $getBarang['satuan'];
						 //$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
						 $Koloms.= $tampilHeader;
						 $Koloms.= "<td class='$cssclass' align='left' valign='middle' ><span style='color:$kondisiWarna;'>$namaBarang</span></td>";

						 $nomorUrutDuaTahapSebelumnya = $this->nomorUrut - 2;
						 $getIsiBarangTahapSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutDuaTahapSebelumnya' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan'"));
						 $isiBarangTahapSebelumnya = $getIsiBarangTahapSebelumnya['volume_barang'];
						 $catatan = $getIsiBarangTahapSebelumnya['catatan'];
						 $Koloms.= "<td class='$cssclass' align='right' valign='middle'>".$jumlahKoreksi."</td>";

						 $Koloms.= "<td class='$cssclass' align='left' valign='middle'>$satuan_barang</td>";

						// $Koloms.= "<td class='$cssclass' align='left'>$catatan</td>";


						 $tanggal_update = explode("-",$tanggal_update);
					 	 $tanggal_update = $tanggal_update[2]."-".$tanggal_update[1]."-".$tanggal_update[0];

						 $Koloms.= "<td class='$cssclass' align='left' valign='middle'><span id='spanCaraPemenuhan$id_anggaran'>$cara_pemenuhan</span> </td>";


					 }



				$Koloms = array(
						 	array("Y", $Koloms),
						 );

	 return $Koloms;

	}
	 function Validasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI RKBMD PENGADAAN';
	 $kode = $dt['c1'].".".$dt['c'].".".$dt['d'].".".$dt['e'].".".$dt['e1'].".".genNumber($dt['bk']).".".genNumber($dt['ck']).".".genNumber($dt['dk']).".".genNumber($dt['p']).".".$dt['q'].".".$dt['f1'].".".$dt['f2'].".".$dt['f'].".".$dt['g'].".".$dt['h'].".".$dt['i'].".".$dt['j'].".".$dt['id_jenis_pemeliharaan'];
	  if ($dt['status_validasi'] == '1') {
		$arrayTanggalValidasi = explode("-", $dt['tanggal_validasi']);

		$tglvalid = $arrayTanggalValidasi[2]."-".$arrayTanggalValidasi[1]."-".$arrayTanggalValidasi[0];
		$username = $dt['user_validasi'];
		$checked = "checked='checked'";
	  }else{
		$tglvalid = date("d-m-Y");
		$checked = "";
		$username = $_COOKIE['coID'];
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);

	 //items ----------------------
	  $this->form_fields = array(
			'kode' => array(
						'label'=>'KODE RKBMD',
						'labelWidth'=>100,
						'value'=>$kode,
						'type'=>'text',
						'param'=>"style='width:300px;' readonly"
						 ),
			'tgl_validasi' => array(
						'label'=>'TANGGAL',
						'labelWidth'=>100,
						'value'=>$tglvalid,
						'type'=>'text',
						'param'=>"style='width:125px;' readonly"
						 ),

			'username' => array(
						'label'=>'USERNAME',
						'labelWidth'=>100,
						'value'=>$username ,
						'type'=>'text',
						'param'=>"style='width:300px;' readonly"
						 ),
			'validasi' => array(
						'label'=>'VALIDASI DATA',
						'labelWidth'=>100,
						'value'=>"<input type='checkbox' name='validasi' $checked style='margin-left:-1px;' />",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveValid()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function Laporan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 800;
	 $this->form_height = 80;
	 $this->form_caption = 'LAPORAN RKBMD PENGADAAN';

	 $c1 = $dt['penetapanRKBMDPengadaanSkpdfmUrusan'];
	 $c = $dt['penetapanRKBMDPengadaanSkpdfmSKPD'];
	 $d = $dt['penetapanRKBMDPengadaanSkpdfmUNIT'];
	 $e = $dt['penetapanRKBMDPengadaanSkpdfmSUBUNIT'];
	 $e1 = $dt['penetapanRKBMDPengadaanSkpdfmSEKSI'];


	 /*if($e1 != '000'){
	 	 $arrayJenisLaporan = array(
	 						   array('Pengadaan1', 'USULAN RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG'),
							   array('Pengadaan2', 'HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGGUNA BARANG'),
							   array('Pengadaan3', 'RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG'),
							   );
	 }elseif($d !='00'){
	 	 $arrayJenisLaporan = array(
							   array('Pengadaan4', 'USULAN RKBMD PENGADAAN PADA PENGGUNA BARANG'),
							   array('Pengadaan5', 'HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGELOLA BARANG'),
							   array('Pengadaan6', 'RKBMD PENGADAAN PADA PENGGUNA BARANG'),


							   );
	 }else{*/
	 	$arrayJenisLaporan = array(
							   array('Pengadaan7', 'RKBMD PENGADAAN PROVINSI/KABUPATEN/KOTA'),

							   );
	 /*}*/

	/* $arrayJenisLaporan = array(
	 						   array('Pengadaan1', 'USULAN RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG'),
							   array('Pengadaan2', 'HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGGUNA BARANG'),
							   array('Pengadaan3', 'RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG'),
							   array('Pengadaan4', 'USULAN RKBMD PENGADAAN PADA PENGGUNA BARANG'),
							   array('Pengadaan5', 'HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGELOLA BARANG'),
							   array('Pengadaan6', 'RKBMD PENGADAAN PADA PENGGUNA BARANG'),
							   array('Pengadaan7', 'RKBMD PENGADAAN PROVINSI/KABUPATEN/KOTA'),

							   );*/

	  $cmbJenisLaporan = cmbArray('jenisKegiatan','',$arrayJenisLaporan,'-- JENIS LAPORAN --',"onchange = $this->Prefix.jenisChanged();");
	  $this->form_fields = array(
			'jenisLaporan' => array(
						'label'=>'JENIS LAPORAN',
						'labelWidth'=>100,
						'value'=> $cmbJenisLaporan
						 ),
			'Cetakjang' => array(
									'label'=>'TANGGAL CETAK',
									'labelWiidth'=>100,
									'value'=>"<input type='date' name='cetakjang' id='cetakjang' value='".date('Y-m-d')."'>
									",
								),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Report()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function genDaftarOpsi(){
	 global $Ref, $Main,  $HTTP_COOKIE_VARS;


	$fmKODE = $_REQUEST['fmKODE'];
	$fmBARANG = $_REQUEST['fmBARANG'];
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



	$TampilOpt =
			//"<tr><td>".
			"<table width=\"100%\" class=\"adminform\">	<tr>
			<td width=\"100%\" valign=\"top\">" .
				WilSKPD_ajxVWSKPD("penetapanRKBMDPengadaanSkpd") .
			"
			<input type='hidden' id='penetapanRKBMDPengadaanSkpdfmSUBUNIT' name='penetapanRKBMDPengadaanfmSUBUNIT' >
			<input type='hidden' id='penetapanRKBMDPengadaanSkpdfmSEKSI' name='penetapanRKBMDPengadaanfmSEKSI' >
			<input type='hidden' id='penetapanRKBMDPengadaanSkpdCbxSubUnit' name='penetapanRKBMDPengadaanfmSUBUNIT' >
			<input type='hidden' id='penetapanRKBMDPengadaanSkpdCbxSeksi' name='penetapanRKBMDPengadaanfmSEKSI' >
			</td>
			<td >" .
			"</td></tr>
			<tr><td>
			<input type='hidden' name='cmbJenispenetapanRKBMDPengadaan' id='cmbJenispenetapanRKBMDPengadaan' value='PENGADAAN'>
			</td></tr>
			</table>";
		return array('TampilOpt'=>$TampilOpt);
	}
	function Info(){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 100;
	 $this->form_caption = 'INFO RKBMD';


	 if($this->jenisFormTerakhir == "VALIDASI"){
	 	$getJumlahSKPDYangMengisiPlafon = mysql_num_rows(mysql_query("select * from view_plafon where tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$this->noUrutTerakhirPlafon' and d!='00' and status_validasi = '1' "));
	 }else{
	 	$getJumlahSKPDYangMengisiPlafon = mysql_num_rows(mysql_query("select * from view_plafon where tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$this->noUrutTerakhirPlafon' and d!='00' "));
	 }



	 //items ----------------------
	  $this->form_fields = array(
			'1' => array(
						'label'=>'ANGGARAN',
						'labelWidth'=>150,
						'value'=>$this->jenisAnggaran. " TAHUN  ". $this->tahun,
						 ),
			'2' => array(
						'label'=>'NAMA TAHAP TERAKHIR',
						'labelWidth'=>150,
						'value'=>$this->namaTahapTerakhir,
						 ),
			'3' => array(
						'label'=>'WAKTU',
						'labelWidth'=>150,
						'value'=>$this->masaTerakhir,
						 ),
			'4' => array(
						'label'=>'TAHAP SEKARANG',
						'labelWidth'=>150,
						'value'=>$this->currentTahap,
						 )


			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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

		if($this->jenisForm =="PENYUSUNAN" || $this->jenisForm =="VALIDASI" || $this->jenisFormTerakhir == "PENYUSUNAN" || $this->jenisFormTerakhir == "VALIDASI" ){
			$tergantung = "100";
		}else{
			$tergantung = "100";
		}
		return

		//"<html xmlns='http://www.w3.org/1999/xhtml'>".
		"<html>".
			$this->genHTMLHead().
			"<body >".
			/*"<div id='pageheader'>".$this->setPage_Header()."</div>".
			"<div id='pagecontent'>".$this->setPage_Content()."</div>".
			$Main->CopyRight.*/

			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0'  height='100%' >".
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
			"</body>
		</html>
		<style>
			#kerangkaHal {
						width:$tergantung%;
			}

		</style>
		";
	}

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID  = $_COOKIE['coID'];
		$c1   = $_REQUEST['penetapanRKBMDPengadaanSkpdfmUrusan'];
		$c    = $_REQUEST['penetapanRKBMDPengadaanSkpdfmSKPD'];
		$d    = $_REQUEST['penetapanRKBMDPengadaanSkpdfmUNIT'];
		if(isset($d)){
			$data = array("CurrentUrusan" => $c1,
					  "CurrentBidang" => $c,
					  "CurrentSKPD" => $d,

					  );
		}elseif(isset($c)){
			$data = array("CurrentUrusan" => $c1,
					  "CurrentBidang" => $c,

					  );
		}elseif(isset($c1)){
			$data = array("CurrentUrusan" => $c1

			 );
		}

		mysql_query(VulnWalkerUpdate("current_filter",$data,"username='$this->username'"));


	    if(!isset($c1) ){
	   		$arrayData = mysql_fetch_array(mysql_query("select * from current_filter where username ='".$_COOKIE['coID']."'"));
			foreach ($arrayData as $key => $value) {
			  $$key = $value;
			 }
			 if($CurrentSubUnit !='000' ){
			 	$e1 = $CurrentSubUnit;
			 	$e = $CurrentUnit;
				$d = $CurrentSKPD;
				$c = $CurrentBidang;
				$c1 = $CurrentUrusan;

			}elseif($CurrentUnit !='00' ){
			 	$e = $CurrentUnit;
				$d = $CurrentSKPD;
				$c = $CurrentBidang;
				$c1 = $CurrentUrusan;

			}elseif($CurrentSKPD !='00' ){
				$d = $CurrentSKPD;
				$c = $CurrentBidang;
				$c1 = $CurrentUrusan;

			}elseif($CurrentBidang !='00'){
				$c = $CurrentBidang;
				$c1 = $CurrentUrusan;

			}elseif($CurrentUrusan !='0'){
				$c1 = $CurrentUrusan;
			}
	   }

		foreach ($HTTP_COOKIE_VARS as $key => $value) {
		  			$$key = $value;
	 	}

		if($VulnWalkerSubUnit != '000'){
			$e1 = $VulnWalkerSubUnit;
			$e = $VulnWalkerUnit;
			$d = $VulnWalkerSKPD;
			$c = $VulnWalkerBidang;
			$c1 = $VulnWalkerUrusan;
		}elseif($VulnWalkerUnit != '00'){
			$e = $VulnWalkerUnit;
			$d = $VulnWalkerSKPD;
			$c = $VulnWalkerBidang;
			$c1 = $VulnWalkerUrusan;
		}elseif($VulnWalkerSKPD != '00'){
			$d = $VulnWalkerSKPD;
			$c = $VulnWalkerBidang;
			$c1 = $VulnWalkerUrusan;
		}elseif($VulnWalkerBidang != '00'){
			$c = $VulnWalkerBidang;
			$c1 = $VulnWalkerUrusan;
		}elseif($VulnWalkerUrusan != '0'){
			$c1 = $VulnWalkerUrusan;
		}
		if(isset($c1) && (empty($c1) || $c1 =="0")){
			$c1 = "";
			$c = "";
			$d = "";
			$e = "";
			$e1 = "";
		}elseif(isset($c) && (empty($c) || $c =="00")){
			$c = "";
			$d = "";
			$e = "";
			$e1 = "";
		}elseif(isset($d) && (empty($d) || $d =="00")){
			$d = "";
			$e = "";
			$e1 = "";
		}elseif(isset($e) && (empty($e) || $e =="00")){
			$e = "";
			$e1 = "";
		}elseif(isset($e1) && (empty($e1) || $e1 =="000")){
			$e1 = "";
		}
		$fmKODE = $_REQUEST['fmKODE'];
		$fmBARANG = $_REQUEST['fmBARANG'];
		$cmbJenispenetapanRKBMDPengadaan = $_REQUEST['cmbJenispenetapanRKBMDPengadaan'];

		$arrKondisi = array();

		if(!empty($c1) && $c1!="0" ){
			$this->kondisiSKPD = " and c1='$c1' ";
		}
		if(!empty($c) && $c!="00"){
			$this->kondisiSKPD = " and c1='$c1' and c='$c' ";
		}
		if(!empty($d) && $d!="00"){
			$this->kondisiSKPD = " and c1='$c1' and c='$c' and d='$d' ";
		}


		$arrKondisi[] = "id_jenis_pemeliharaan = '0'  and uraian_pemeliharaan != 'RKBMD PEMELIHARAAN' and uraian_pemeliharaan != 'RKBMD PERSEDIAAN' ";


		$getAllBarangFromRKBMD = mysql_query("select * from view_rkbmd where id_tahap ='$this->idTahap'  and j!='000' " );
		while($dataBarang = mysql_fetch_array($getAllBarangFromRKBMD)){
					if(mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap = '$this->idTahap' $this->kondisiBarang $this->kondisiSKPD and c1='".$dataBarang['c1']."' and c='".$dataBarang['c']."' and d='".$dataBarang['d']."' and ck='".$dataBarang['ck']."' and dk='".$dataBarang['dk']."'  and dk='".$dataBarang['dk']."' and p='".$dataBarang['p']."' and q='".$dataBarang['q']."' and f='".$dataBarang['f']."' and g='".$dataBarang['g']."' and h='".$dataBarang['h']."' and i='".$dataBarang['i']."' and j='".$dataBarang['j']."' and volume_barang !='0' and id_jenis_pemeliharaan = '0'")) == 0){
							$blackListBarang[] = "id_anggaran !='".$dataBarang['id_anggaran']."'";
							$arrKondisi[] = "id_anggaran !='".$dataBarang['id_anggaran']."'";

					}
		}
		$kondisiBlackListBarang= join(' and ',$blackListBarang);
		if(sizeof($blackListBarang) == 0){
			$kondisiBlackListBarang = "";
		}elseif(sizeof($blackListBarang) > 0){
			$kondisiBlackListBarang = " and ".$kondisiBlackListBarang;
		}

		$getAllKegiatan = mysql_query("select * from view_rkbmd where id_tahap = '$this->idTahap' and j='000' and q!='0' ");
		while($dataKegiatan = mysql_fetch_array($getAllKegiatan)){
				if(mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap ='$this->idTahap' $this->kondisiSKPD and c1='".$dataKegiatan['c1']."' and c='".$dataKegiatan['c']."' and d='".$dataKegiatan['d']."' and ck='".$dataKegiatan['ck']."' and bk='".$dataKegiatan['bk']."' and ck='".$dataKegiatan['ck']."' and dk='".$dataKegiatan['dk']."' and p='".$dataKegiatan['p']."' and q='".$dataKegiatan['q']."' and j!='000' $kondisiBlackListBarang ")) == 0){
						$blackListKegiatan[] = "id_anggaran !='".$dataKegiatan['id_anggaran']."'";
						$arrKondisi[] = "id_anggaran !='".$dataKegiatan['id_anggaran']."'";
				}
		}

		$kondisiBlackListKegiatan= join(' and ',$blackListKegiatan);
		if(sizeof($blackListKegiatan) == 0){
			$kondisiBlackListKegiatan = "";
		}elseif(sizeof($blackListKegiatan) > 0){
			$kondisiBlackListKegiatan = " and ".$kondisiBlackListKegiatan;
		}

		$getAllProgram = mysql_query("select * from view_rkbmd where id_tahap = '$this->idTahap' and j='000' and p!='0' and q='0' ");
		while($dataProgram = mysql_fetch_array($getAllProgram)){
				if(mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap ='$this->idTahap' $this->kondisiSKPD and c1='".$dataProgram['c1']."' and c='".$dataProgram['c']."' and d='".$dataProgram['d']."' and ck='".$dataProgram['ck']."' and bk='".$dataProgram['bk']."' and ck='".$dataProgram['ck']."' and dk='".$dataProgram['dk']."' and p='".$dataProgram['p']."'  and j!='000' $kondisiBlackListBarang ")) == 0){
						$blackListProgram[] = "id_anggaran !='".$dataProgram['id_anggaran']."'";
						$arrKondisi[] = "id_anggaran !='".$dataProgram['id_anggaran']."'";
				}
		}

		$kondisiBlackListProgram= join(' and ',$blackListProgram);
		if(sizeof($blackListProgram) == 0){
		  $kondisiBlackListProgram = "";
		}elseif(sizeof($blackListProgram) > 0){
		  $kondisiBlackListProgram = " and ".$kondisiBlackListProgram;
		}
		$getAllSKPD = mysql_query("select * from view_rkbmd where id_tahap = '$this->idTahap' and j='000' and p='0' and q='0' ");
		while($dataSKPD = mysql_fetch_array($getAllSKPD)){

		    if(mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap ='$this->idTahap' $this->kondisiSKPD and c1='".$dataSKPD['c1']."' and c='".$dataSKPD['c']."' and d='".$dataSKPD['d']."'   and j!='000' $kondisiBlackListBarang ")) == 0){
		        $arrKondisi[] = "id_anggaran !='".$dataSKPD['id_anggaran']."' ";
		    }
		}

		$kondisiBlackListSKPD= join(' and ',$blackListSKPD);
		if(sizeof($blackListSKPD) == 0){
		  $kondisiBlackListSKPD = "";
		}elseif(sizeof($blackListSKPD) > 0){
		  $kondisiBlackListSKPD = " and ".$kondisiBlackListSKPD;
		}


		$arrKondisi[] = "id_tahap = '$this->idTahap'";
		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
		$arrKondisi[] = "f != '06' and f!='07' and f!='08'";


		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi." group by c1,c,d,bk,ck,dk,p,q,f,g,h,i,j";

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		$arrOrders[] = "concat(convert(c1 using utf8),'.',convert(c using utf8),'.',convert(d using utf8),'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',convert(f1 using utf8),'.',convert(f2 using utf8),'.',convert(f using utf8),'.',convert(g using utf8),'.',convert(h using utf8),'.',convert(i using utf8),'.',convert(j using utf8),'.',convert(right((100 + id_jenis_pemeliharaan),2) using utf8)) ASC " ;




			$Order= join(',',$arrOrders);
			$OrderDefault = '';// Order By no_terima desc ';
			$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;


		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}

	function LaporanTmplSKPD($c1, $c, $d, $e, $e1){
		global $Main, $DataPengaturan, $DataOption;

		$get = mysql_fetch_array(mysql_query("select * from skpd_report_rkbmd where username = '$this->username'"));
		foreach ($get as $key => $value) {
		  $$key = $value;
	 	}
		$grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'"));
		$urusan = $grabUrusan['nm_skpd'];
		$grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
		$bidang = $grabBidang['nm_skpd'];
		$grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
		$skpd = $grabSkpd['nm_skpd'];
		$grabUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
		$unit = $grabUnit['nm_skpd'];
		$grabSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$subunit = $grabSubUnit['nm_skpd'];



		$data = "
				<table width=\"100%\" border=\"0\" class='subjudulcetak'>
					<tr>
						<td width='10%' valign='top'>PEMERINTAH PROVINSI</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$this->provinsi."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>KABUPATEN / KOTA</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$this->kota."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>PENGGUNA BARANG</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$skpd."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>URUSAN</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$urusan."</td>
					</tr>
					<tr>
						<td width='10%' valign='top' >BIDANG</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$bidang."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SKPD</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$skpd."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>UNIT</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$unit."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SUB UNIT</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$subunit."</td>
					</tr>

				</table>";

		return $data;
	}

	function TandaTanganFooter($c1,$c,$d,$e,$e1){
		global $Main, $DataPengaturan,$HTTP_COOKIE_VARS;




		return "<br><div class='ukurantulisan'>
					<table width='100%'>
						<tr>
							<td class='ukurantulisan' valign='top' ></td>
							<td class='ukurantulisan' valign='top' width='70%' ></td>
							<td class='ukurantulisan' valign='top'><span style='margin-left:5px;'>Bandung, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</span></td>
						</tr>
						<tr>
							<td class='ukurantulisan' valign='top' ><span style='margin-left:5px;'>&nbsp
<br><br><br><br><br></span></td>
							<td class='ukurantulisan' valign='top' width='50%' ></td>
							<td class='ukurantulisan' valign='top' ><span style='margin-left:5px;'>Tanda Tangan Dua
</span></td>
						</tr>
						<tr>
							<td class='ukurantulisan'>
								<table width='100%'>
									<tr>
										<td class='ukurantulisan' width='75px'>&nbsp</td>
										<td class='ukurantulisan'>&nbsp</td>
										<td class='ukurantulisan'>&nbsp</td>
									</tr>
									<tr>
										<td class='ukurantulisan'>&nbsp</td>
										<td class='ukurantulisan'> &nbsp </td>
										<td class='ukurantulisan'>&nbsp</td>
									</tr>
								</table>
							</td>
							<td class='ukurantulisan'></td>
							<td class='ukurantulisan'>
								<table width='100%'>
									<tr>
										<td class='ukurantulisan' width='75px'>Nama</td>
										<td class='ukurantulisan'> : </td>
										<td class='ukurantulisan'>Nama Tanda Tangan Dua</td>
									</tr>
									<tr>
										<td class='ukurantulisan'>NIP</td>
										<td class='ukurantulisan'> : </td>
										<td class='ukurantulisan'>NIP Tanda Tangan Dua</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>";
	}
function Pengadaan1($xls =FALSE){
		global $Main;

		$this->fileNameExcel = "USULAN RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG";
		$align = "right";
		$xls = $_GET['xls'];
		$pisah = "<td width='1%' valign='top'> : </td>";
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$align = 'center';
			$pisah = "";
		}



		$grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_rkbmd where username='$this->username'"));
		foreach ($grabSKPD as $key => $value) {
				  $$key = $value;
			}
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
		$getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul !='KOREKSI PENGGUNA' and jenis_form_modul !='KOREKSI PENGELOLA' "));
		$lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
		$getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
		$lastNomorUrut = $getLastTahap['no_urut'];
		$getMinJenisForm = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran'"));
		if($getMinJenisForm['jenis_form_modul'] == 'PENYUSUNAN' && $this->wajibValidasi == TRUE){
				$kondisiValid = " and status_validasi = '1'";
		}

		$arrKondisi = array();
		$grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and p !='0' and q='0'");
		while($rows = mysql_fetch_array($grabProgram)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			}
			if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000' $kondisiValid")) == 0){
				$concat = $bk.".".$ck.".".$dk.".".$p;
				$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
			}else{
				if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' $kondisiValid")) == 0){
					if($q != '0'){
						$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
						$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
					}
				}else{
						$concat = $f.".".$g.".".$h.".".$i.".".$j;
					if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' $kondisiValid")) == 0){
						if($j != '000'){
							$arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
						}
					}
				}
			}
		}


		$Kondisi= join(' and ',$arrKondisi);
		if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}

		$grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'"));
		$urusan = $grabUrusan['nm_skpd'];
		$grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
		$bidang = $grabBidang['nm_skpd'];
		$grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
		$skpd = $grabSkpd['nm_skpd'];
		$grabUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
		$unit = $grabUnit['nm_skpd'];
		$grabSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$subunit = $grabSubUnit['nm_skpd'];
		$qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' $Kondisi order by urut";
		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo
			"<html>".
				"<head>
					<title>$Main->Judul</title>
					$css
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan{
							font-size:17px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width:33cm;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
				<span style='font-size:18px;font-weight:bold;text-decoration: '>
					USULAN RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH<br>
					(RENCANA PENGADAAN)<br>
					KUASA PENGUNA BARANG $kuasaPenggunaBarang
				</span><br>
				<span class='ukurantulisanIdPenerimaan'>TAHUN : $this->tahun </span></div><br>".
								"
								<table width=\"100%\" border=\"0\" class='subjudulcetak'>
					<tr>
						<td width='10%' valign='top'>PEMERINTAH PROVINSI</td>
						$pisah
						<td valign='top'>".$this->provinsi."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>KABUPATEN / KOTA</td>
						$pisah
						<td valign='top'>".$this->kota."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>PENGGUNA BARANG</td>
						$pisah
						<td valign='top'>".$skpd."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>URUSAN</td>
						$pisah
						<td valign='top'>".$urusan."</td>
					</tr>
					<tr>
						<td width='10%' valign='top' >BIDANG</td>
						$pisah
						<td valign='top'>".$bidang."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SKPD</td>
						$pisah
						<td valign='top'>".$skpd."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>UNIT</td>
						$pisah
						<td valign='top'>".$unit."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SUB UNIT</td>
						$pisah
						<td valign='top'>".$subunit."</td>
					</tr>

				</table>
								";
		echo "
								<br>
								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
										<th class='th01' rowspan='2' style='width:20px;' >NO</th>
										<th class='th01' rowspan='2' >PROGRAM/KEGIATAN/OUTPUT</th>
										<th class='th02' rowspan='1' colspan='4' >USULAN BMD</th>
										<th class='th02' rowspan='1' colspan='2' >KEBUTUHAN MAKSIMUM</th>
										<th class='th02' rowspan='1' colspan='4' >DATA DAFTAR BARANG YANG DAPAT DI OPTIOMALISASIKAN</th>
										<th class='th02' rowspan='1' colspan='2' >KEBUTUHAN RIIL BMD</th>
										<th class='th01' rowspan='2' >KETERANGAN</th>
									</tr>
									<tr>
										<th class='th01' >KODE BARANG</th>
										<th class='th01' >NAMA BARANG</th>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>
										<th class='th01' >KODE BARANG</th>
										<th class='th01' >NAMA BARANG</th>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>
									</tr>

		";

		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
			}
			$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
			if($q == '0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='0'"));
				$programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='$q'"));
				$programKegiatan = "<span style='font-weight:bold; margin-left :10px;'>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j !='000'){
				$programKegiatan = "";
				$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
				$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
				$namaBarang = $getNamaBarang['nm_barang'];
				$volBar = number_format($volume_barang,0,'.',',');
				$getKebutuhanMaksimum = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
				$kebutuhanMaksimum = $getKebutuhanMaksimum['jumlah'];
				$getJumlahOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and status_barang = '1' and (kondisi = '1' or kondisi ='2')"));
				$jumlahOptimal = $getJumlahOptimal['sum(jml_barang)'];
				$kebutuhanRiil = $getKebutuhanMaksimum['jumlah'] - $getJumlahOptimal['sum(jml_barang)'];
				$kebutuhanMaksimum = number_format($kebutuhanMaksimum,0,'.',',');
				$jumlahOptimal = number_format($jumlahOptimal,0,'.',',');
				$kebutuhanRill = number_format($kebutuhanRiil,0,'.',',');
			}
			echo "
								<tr valign='top'>
									<td align='$align' class='GarisCetak'>$no</td>
									<td align='left' class='GarisCetak' >".$programKegiatan."</td>
									<td align='left' class='GarisCetak' >".$kodeBarang."</td>
									<td align='left' class='GarisCetak' >".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$volBar</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='right' class='GarisCetak'>$kebutuhanMaksimum</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='left' class='GarisCetak' >".$kodeBarang."</td>
									<td align='left' class='GarisCetak' >".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$jumlahOptimal</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='right' class='GarisCetak'>$kebutuhanRill</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='left' class='GarisCetak' >".$catatan."</td>
								</tr>
			";
			$no++;
			$volBar = "";
			$jumlahBarangSebelumnya = "";
			$kebutuhanMaksimum = "";
			$jumlahOptimal = "";
			$kebutuhanRill = "";





		}
		echo 				"</table>";

		$getDataKuasaPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatangankuasapenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and e='$e' and e1 ='$e1'"));
		if($xls){
			echo
						"<br><div class='ukurantulisan' align='right'>
						<table align='right'>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>Kuasa Pengguna Barang</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>NIP	".$getDataKuasaPenggunaBarang['nip']."</td>
						</tr>
						</table>
						</div>
				</body>
			</html>";
		}else{
			echo
						"<br><div class='ukurantulisan' style ='float:right;'>
						$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."<br>
						Kuasa Pengguna Barang
						<br>
						<br>
						<br>
						<br>
						<br>

						<u>".$getDataKuasaPenggunaBarang['nama']."</u><br>
						NIP	".$getDataKuasaPenggunaBarang['nip']."


						</div>
			</body>
		</html>";
		}

	}
function Pengadaan2($xls =FALSE){
		global $Main;

		$this->fileNameExcel = "HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGGUNA BARANG";
		$align = "right";
		$xls = $_GET['xls'];
		$pisah = "<td width='1%' valign='top'> : </td>";
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$align = 'center';
			$pisah = "";
		}



		$grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_rkbmd where username='$this->username'"));
		foreach ($grabSKPD as $key => $value) {
				  $$key = $value;
			}
		$getPenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='00' and e1='000'"));
		$penggunaBarang = $getPenggunaBarang['nm_skpd'];
		$getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul ='KOREKSI PENGGUNA'"));
		$lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
		$getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
		$lastNomorUrut = $getLastTahap['no_urut'];
		$arrKondisi = array();
		$grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and p !='0' and q='0'");
		while($rows = mysql_fetch_array($grabProgram)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			}
			if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000' ")) == 0){
				$concat = $bk.".".$ck.".".$dk.".".$p;
				$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
			}else{
				if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' ")) == 0){
					if($q != '0'){
						$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
						$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
					}
				}else{
						$concat = $f.".".$g.".".$h.".".$i.".".$j;
					if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' ")) == 0){
						if($j != '000'){
							$arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
						}
					}
				}
			}
		}


		$Kondisi= join(' and ',$arrKondisi);
		if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}

		$grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'"));
		$urusan = $grabUrusan['nm_skpd'];
		$grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
		$bidang = $grabBidang['nm_skpd'];
		$grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
		$skpd = $grabSkpd['nm_skpd'];
		$grabUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
		$unit = $grabUnit['nm_skpd'];
		$grabSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$subunit = $grabSubUnit['nm_skpd'];

		$qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' $Kondisi order by urut";
		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];

		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo
			"<html>".
				"<head>
					<title>$Main->Judul</title>
					$css
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan{
							font-size:17px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width:33cm;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
				<span style='font-size:18px;font-weight:bold;text-decoration: '>
					HASIL PENELAAHAN RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH<br>
					(RENCANA PENGADAAN)<br>
					KUASA PENGUNA BARANG $kuasaPenggunaBarang
				</span><br>
				<span class='ukurantulisanIdPenerimaan'>TAHUN : $this->tahun </span></div><br>".
								"	<table width=\"100%\" border=\"0\" class='subjudulcetak'>
					<tr>
						<td width='10%' valign='top'>PEMERINTAH PROVINSI</td>
						$pisah
						<td valign='top'>".$this->provinsi."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>KABUPATEN / KOTA</td>
						$pisah
						<td valign='top'>".$this->kota."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>PENGGUNA BARANG</td>
						$pisah
						<td valign='top'>".$skpd."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>URUSAN</td>
						$pisah
						<td valign='top'>".$urusan."</td>
					</tr>
					<tr>
						<td width='10%' valign='top' >BIDANG</td>
						$pisah
						<td valign='top'>".$bidang."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SKPD</td>
						$pisah
						<td valign='top'>".$skpd."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>UNIT</td>
						$pisah
						<td valign='top'>".$unit."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SUB UNIT</td>
						$pisah
						<td valign='top'>".$subunit."</td>
					</tr>

				</table>";
		echo "
								<br>
								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
										<th class='th01' rowspan='3' style='width:20px;' >NO</th>
										<th class='th02' rowspan='1' colspan='5' >USULAN RKBMD</th>
										<th class='th02' rowspan='1' colspan='2' >KEBUTUHAN MAKSIMUM</th>
										<th class='th02' rowspan='1' colspan='4' >DATA DAFTAR BARANG YANG DAPAT DIOPTIMALKAN</th>
										<th class='th02' rowspan='1' colspan='2' >KEBUTUHAN RILL BARANG MILIK DAERAH</th>
										<th class='th02' rowspan='2' colspan='2' >RENCANA KEBUTUHAN PENGADAAN BMD YANG DISETUJUI</th>
										<th class='th01' rowspan='3'  >CARA PEMENUHAN</th>
										<th class='th01' rowspan='3'  >KETERANGAN</th>
									</tr>
									<tr>
										<th class='th01' rowspan='2'>PROGRAM/KEGIATAN/OUTPUT</th>
										<th class='th01' rowspan='2'>KODE BARANG</th>
										<th class='th01' rowspan='2'>NAMA BARANG</th>
										<th class='th01' rowspan='2'>JUMLAH</th>
										<th class='th01' rowspan='2'>SATUAN</th>
										<th class='th01' rowspan='2'>JUMLAH</th>
										<th class='th01' rowspan='2'>SATUAN</th>
										<th class='th01' rowspan='2'>KODE BARANG</th>
										<th class='th01' rowspan='2'>NAMA BARANG</th>
										<th class='th01' rowspan='2'>JUMLAH</th>
										<th class='th01' rowspan='2'>SATUAN</th>
										<th class='th01' rowspan='2'>JUMLAH</th>
										<th class='th01' rowspan='2'>SATUAN</th>
									</tr>
									<tr>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>
									</tr>


		";

		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
			}
			$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
			if($q == '0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='0'"));
				$programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='$q'"));
				$programKegiatan = "<span style='font-weight:bold; margin-left :10px;'>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j !='000'){
				$programKegiatan = "";
				$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
				$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
				$namaBarang = $getNamaBarang['nm_barang'];
				$volBar = number_format($volume_barang,0,'.',',');
				$getKebutuhanMaksimum = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
				$kebutuhanMaksimum = $getKebutuhanMaksimum['jumlah'];
				$getJumlahOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and status_barang = '1' and (kondisi = '1' or kondisi ='2')"));
				$jumlahOptimal = $getJumlahOptimal['sum(jml_barang)'];
				$kebutuhanRiil = $getKebutuhanMaksimum['jumlah'] - $getJumlahOptimal['sum(jml_barang)'];
				$kebutuhanMaksimum = number_format($kebutuhanMaksimum,0,'.',',');
				$jumlahOptimal = number_format($jumlahOptimal,0,'.',',');
				$kebutuhanRill = number_format($kebutuhanRiil,0,'.',',');
				$nomorUrutSebelumnya = $lastNomorUrut - 1;
				$getDataSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'"));
				$jumlahBarangSebelumnya = $getDataSebelumnya['volume_barang'];

			}
			echo "
								<tr valign='top'>
									<td align='$align' class='GarisCetak'>$no</td>
									<td align='left' class='GarisCetak' >".$programKegiatan."</td>
									<td align='left' class='GarisCetak' >".$kodeBarang."</td>
									<td align='left' class='GarisCetak' >".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$jumlahBarangSebelumnya</td>
									<td align='left' class='GarisCetak' >$satuan_barang</td>
									<td align='right' class='GarisCetak'>$kebutuhanMaksimum</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='left' class='GarisCetak' >".$kodeBarang."</td>
									<td align='left' class='GarisCetak' >".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$jumlahOptimal</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='right' class='GarisCetak'>$kebutuhanRill</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='right' class='GarisCetak'>$volBar</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='left' class='GarisCetak' >".$cara_pemenuhan."</td>
									<td align='left' class='GarisCetak' >".$catatan."</td>
								</tr>
			";
			$no++;
			$volBar = "";
			$jumlahBarangSebelumnya = "";
			$kebutuhanMaksimum = "";
			$jumlahOptimal = "";
			$kebutuhanRill = "";



		}
		echo 				"</table>";
		$getDataKuasaPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatangankuasapenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and e='$e' and e1 ='$e1'"));
		$getDataPejabatPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PEJABAT'"));
		$getDataPengurusPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PENGURUS'"));

		if($xls){
				echo
						"<br><div class='ukurantulisan' align='right'>
						<table align='right'>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>Kuasa Pengguna Barang</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>NIP	".$getDataKuasaPenggunaBarang['nip']."</td>
						</tr>
						</table>
						</div>
				";
				echo "	<div >
					<div  >Telah Diperiksa : </div>
					<table table width='100%' class='cetak' border='1' style='margin-left:90px;width:50%;'>
						<tr>
							<th class='th01'>No</th>
							<th class='th01'>Nama</th>
							<th class='th01'>Jabatan</th>
							<th class='th01'>TTD / Paraf</th>
							<th class='th01' >Tanggal</th>
						</tr>
						<tr>
							<td align='center' class='GarisCetak' >1.</td>
							<td align='left' class='GarisCetak' >".$getDataPejabatPenggunaBarang['nama']."</td>
							<td align='left' class='GarisCetak' >Pejabat Penatausahaan Pengguna Barang</td>
							<td align='left' class='GarisCetak' >&nbsp</td>
							<td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
							<td align='center' class='GarisCetak' >2.</td>
							<td align='left' class='GarisCetak' >".$getDataPengurusPenggunaBarang['nama']."</td>
							<td align='left' class='GarisCetak' >Pengurus Barang Pengguna</td>
							<td align='left' class='GarisCetak' >&nbsp</td>
							<td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
					</tabel>
				</div>
			</body>
		</html>";
		}else{
			echo
						"<br><div class='ukurantulisan' style ='float:right;'>
						$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."<br>
						Kuasa Pengguna Barang
						<br>
						<br>
						<br>
						<br>
						<br>

						<u>".$getDataKuasaPenggunaBarang['nama']."</u><br>
						NIP	".$getDataKuasaPenggunaBarang['nip']."


						</div>
			";
			echo "	<br><br><br><br><br><br><br><br><br><br><br><div >
					<div style='margin-left:90px;width:50%;' >Telah Diperiksa : </div>
					<table table width='100%' class='cetak' border='1' style='margin-left:90px;width:50%;'>
						<tr>
							<th class='th01'>No</th>
							<th class='th01'>Nama</th>
							<th class='th01'>Jabatan</th>
							<th class='th01'>TTD / Paraf</th>
							<th class='th01' >Tanggal</th>
						</tr>
						<tr>
							<td align='right' class='GarisCetak' >1.</td>
							<td align='left' class='GarisCetak' >".$getDataPejabatPenggunaBarang['nama']."</td>
							<td align='left' class='GarisCetak' >Pejabat Penatausahaan Pengguna Barang</td>
							<td align='left' class='GarisCetak' >&nbsp</td>
							<td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
							<td align='right' class='GarisCetak' >2.</td>
							<td align='left' class='GarisCetak' >".$getDataPengurusPenggunaBarang['nama']."</td>
							<td align='left' class='GarisCetak' >Pengurus Barang Pengguna</td>
							<td align='left' class='GarisCetak' >&nbsp</td>
							<td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
					</tabel>
				</div>
			</body>
		</html>";
		}

	}
	function Pengadaan3($xls =FALSE){
		global $Main;

		$this->fileNameExcel = "RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG";
		$align = "right";
		$xls = $_GET['xls'];
		$pisah = "<td width='1%' valign='top'> : </td>";
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$align = 'center';
			$pisah = "";
		}



		$grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_rkbmd where username='$this->username'"));
		foreach ($grabSKPD as $key => $value) {
				  $$key = $value;
			}
		$getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul ='KOREKSI PENGGUNA'"));
		$lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
		$getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
		$lastNomorUrut = $getLastTahap['no_urut'];
		$arrKondisi = array();
		$grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and p !='0' and q='0'");
		while($rows = mysql_fetch_array($grabProgram)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			}
			if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000' ")) == 0){
				$concat = $bk.".".$ck.".".$dk.".".$p;
				$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
			}else{
				if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' ")) == 0){
					if($q != '0'){
						$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
						$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
					}
				}else{
						$concat = $f.".".$g.".".$h.".".$i.".".$j;
					if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' ")) == 0){
						if($j != '000'){
							$arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
						}
					}
				}
			}
		}

		$grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'"));
		$urusan = $grabUrusan['nm_skpd'];
		$grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
		$bidang = $grabBidang['nm_skpd'];
		$grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
		$skpd = $grabSkpd['nm_skpd'];
		$grabUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
		$unit = $grabUnit['nm_skpd'];
		$grabSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$subunit = $grabSubUnit['nm_skpd'];


		$Kondisi= join(' and ',$arrKondisi);
		if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}
		$qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' $Kondisi order by urut";
		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];

		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo
			"<html>".
				"<head>
					<title>$Main->Judul</title>
					$css
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan{
							font-size:17px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width:33cm;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
				<span style='font-size:18px;font-weight:bold;text-decoration: '>
					RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH<br>
					(RENCANA PENGADAAN)<br>
					KUASA PENGUNA BARANG $kuasaPenggunaBarang
				</span><br>
				<span class='ukurantulisanIdPenerimaan'>TAHUN : $this->tahun </span></div><br>".
									"	<table width=\"100%\" border=\"0\" class='subjudulcetak'>
					<tr>
						<td width='10%' valign='top'>PEMERINTAH PROVINSI</td>
						$pisah
						<td valign='top'>".$this->provinsi."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>KABUPATEN / KOTA</td>
						$pisah
						<td valign='top'>".$this->kota."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>PENGGUNA BARANG</td>
						$pisah
						<td valign='top'>".$skpd."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>URUSAN</td>
						$pisah
						<td valign='top'>".$urusan."</td>
					</tr>
					<tr>
						<td width='10%' valign='top' >BIDANG</td>
						$pisah
						<td valign='top'>".$bidang."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SKPD</td>
						$pisah
						<td valign='top'>".$skpd."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>UNIT</td>
						$pisah
						<td valign='top'>".$unit."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SUB UNIT</td>
						$pisah
						<td valign='top'>".$subunit."</td>
					</tr>

				</table>";
		echo "
								<br>
								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
										<th class='th01' rowspan='2' style='width:20px;' >NO</th>
										<th class='th01' rowspan='2' >PROGRAM/KEGIATAN/OUTPUT</th>
										<th class='th02' rowspan='1' colspan='4' >RENCANA KEBUTUHAN BARANG MILIK DAERAH (YANG DISETUJUI)</th>
										<th class='th01' rowspan='2' >CARA PEMENUHAN</th>
										<th class='th01' rowspan='2' >KETERANGAN</th>
									</tr>
									<tr>
										<th class='th01' >KODE BARANG</th>
										<th class='th01' >NAMA BARANG</th>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>
									</tr>


		";

		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
			}
			$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
			if($q == '0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='0'"));
				$programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='$q'"));
				$programKegiatan = "<span style='font-weight:bold; margin-left :10px;'>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j !='000'){
				$programKegiatan = "";
				$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
				$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
				$namaBarang = $getNamaBarang['nm_barang'];
				$volBar = number_format($volume_barang,0,'.',',');
				$getKebutuhanMaksimum = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
				$kebutuhanMaksimum = $getKebutuhanMaksimum['jumlah'];
				$getJumlahOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and status_barang = '1' and (kondisi = '1' or kondisi ='2')"));
				$jumlahOptimal = $getJumlahOptimal['sum(jml_barang)'];
				$kebutuhanRiil = $getKebutuhanMaksimum['jumlah'] - $getJumlahOptimal['sum(jml_barang)'];
				$kebutuhanMaksimum = number_format($kebutuhanMaksimum,0,'.',',');
				$jumlahOptimal = number_format($jumlahOptimal,0,'.',',');
				$kebutuhanRill = number_format($kebutuhanRiil,0,'.',',');
				$nomorUrutSebelumnya = $lastNomorUrut - 1;
				$getDataSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'"));
				$jumlahBarangSebelumnya = $getDataSebelumnya['volume_barang'];

			}
			echo "
								<tr valign='top'>
									<td align='$align' class='GarisCetak'>$no</td>
									<td align='left' class='GarisCetak' >".$programKegiatan."</td>
									<td align='left' class='GarisCetak' >".$kodeBarang."</td>
									<td align='left' class='GarisCetak' >".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$volBar</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='left' class='GarisCetak' >".$cara_pemenuhan."</td>
									<td align='left' class='GarisCetak' >".$catatan."</td>
								</tr>
			";
			$no++;
			$volBar = "";
			$jumlahBarangSebelumnya = "";
			$kebutuhanMaksimum = "";
			$jumlahOptimal = "";
			$kebutuhanRill = "";



		}
		echo 				"</table>";
		$getDataKuasaPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatangankuasapenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and e='$e' and e1 ='$e1'"));

		if($xls){
			echo
						"<br><div class='ukurantulisan' align='right'>
						<table align='right'>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>Kuasa Pengguna Barang</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>NIP	".$getDataKuasaPenggunaBarang['nip']."</td>
						</tr>
						</table>
						</div>
				</body>
			</html>";
		}else{
			echo
						"<br><div class='ukurantulisan' style ='float:right;'>
						$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."<br>
						Kuasa Pengguna Barang
						<br>
						<br>
						<br>
						<br>
						<br>

						<u>".$getDataKuasaPenggunaBarang['nama']."</u><br>
						NIP	".$getDataKuasaPenggunaBarang['nip']."


						</div>
			</body>
		</html>";
		}
	}
	function Pengadaan4($xls =FALSE){
	global $Main;
		$this->fileNameExcel = "USULAN RKBMD PENGADAAN PADA PENGGUNA BARANG";
		$align = "right";
		$xls = $_GET['xls'];
		$pisah = "<td width='1%' valign='top'> : </td>";
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$align = 'center';
			$pisah = "";
		}



		$grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_rkbmd where username='$this->username'"));
		foreach ($grabSKPD as $key => $value) {
				  $$key = $value;
			}

		$grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'"));
		$urusan = $grabUrusan['nm_skpd'];
		$grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
		$bidang = $grabBidang['nm_skpd'];
		$grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
		$skpd = $grabSkpd['nm_skpd'];
		$grabUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
		$unit = $grabUnit['nm_skpd'];
		$grabSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$subunit = $grabSubUnit['nm_skpd'];
		$getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul !='KOREKSI PENGGUNA' and jenis_form_modul !='KOREKSI PENGELOLA' "));
		$lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
		$getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
		$lastNomorUrut = $getLastTahap['no_urut'];
		$getMinJenisForm = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran'"));
		if($getMinJenisForm['jenis_form_modul'] == 'PENYUSUNAN' && $this->wajibValidasi == TRUE){
				$kondisiValid = " and status_validasi = '1'";
		}

		$arrKondisi = array();
		$grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and q='0'");
		while($rows = mysql_fetch_array($grabProgram)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			}
			if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000' $kondisiValid")) == 0){
				if($p !='0'){
					$concat = $bk.".".$ck.".".$dk.".".$p;
					$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
				}
			}else{
				if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' $kondisiValid")) == 0){
					if($q != '0'){
						$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
						$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
					}
				}else{
						$concat = $f.".".$g.".".$h.".".$i.".".$j;
					if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' $kondisiValid")) == 0){
						if($j != '000'){
							$arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
						}
					}
				}
			}
		}


		$Kondisi= join(' and ',$arrKondisi);
		if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}
		$qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  $Kondisi order by urut";
		$aqry = mysql_query($qry);
		$getPenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='00' and e1='000'"));
		$penggunaBarang = $getPenggunaBarang['nm_skpd'];
		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo
			"<html>".
				"<head>
					<title>$Main->Judul</title>
					$css
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan{
							font-size:17px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width:33cm;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
				<span style='font-size:18px;font-weight:bold;text-decoration: '>
					USULAN RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH<br>
					(RENCANA PENGADAAN)<br>
					 PENGUNA BARANG $penggunaBarang
				</span><br>
				<span class='ukurantulisanIdPenerimaan'>TAHUN : $this->tahun </span></div><br>
				<table width=\"100%\" border=\"0\" class='subjudulcetak'>
					<tr>
						<td width='10%' valign='top'>PEMERINTAH PROVINSI</td>
						$pisah
						<td valign='top'>".$this->provinsi."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>KABUPATEN / KOTA</td>
						$pisah
						<td valign='top'>".$this->kota."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>PENGGUNA BARANG</td>
						$pisah
						<td valign='top'>".$skpd."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>URUSAN</td>
						$pisah
						<td valign='top'>".$urusan."</td>
					</tr>
					<tr>
						<td width='10%' valign='top' >BIDANG</td>
						$pisah
						<td valign='top'>".$bidang."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SKPD</td>
						$pisah
						<td valign='top'>".$skpd."</td>
					</tr>


				</table>";
		echo "
								<br>
								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
										<th class='th01' rowspan='2' style='width:20px;' >NO</th>
										<th class='th01' rowspan='2' >PROGRAM/KEGIATAN/OUTPUT</th>
										<th class='th02' rowspan='1' colspan='4' >USULAN BMD</th>
										<th class='th02' rowspan='1' colspan='2' >KEBUTUHAN MAKSIMUM</th>
										<th class='th02' rowspan='1' colspan='4' >DATA DAFTAR BARANG YANG DAPAT DI OPTIOMALISASIKAN</th>
										<th class='th02' rowspan='1' colspan='2' >KEBUTUHAN RIIL BMD</th>
										<th class='th01' rowspan='2' >KETERANGAN</th>
									</tr>
									<tr>
										<th class='th01' >KODE BARANG</th>
										<th class='th01' >NAMA BARANG</th>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>
										<th class='th01' >KODE BARANG</th>
										<th class='th01' >NAMA BARANG</th>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>
									</tr>

		";

		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
			}
			$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
			if($p == '0'){
				$getNamaSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
				$programKegiatan = "<span style='font-weight:bold; '>".$getNamaSkpd['nm_skpd']."</span>";

			}elseif($p !='0' && $q == '0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='0'"));
				$programKegiatan = "<span style='font-weight:bold; margin-left :10px;'>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='$q'"));
				$programKegiatan = "<span style='font-weight:bold; margin-left :15px;'>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j !='000'){
				$programKegiatan = "";
				$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
				$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
				$namaBarang = $getNamaBarang['nm_barang'];
				$volBar = number_format($volume_barang,0,'.',',');
				$getKebutuhanMaksimum = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
				$kebutuhanMaksimum = $getKebutuhanMaksimum['jumlah'];
				$getJumlahOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and status_barang = '1' and (kondisi = '1' or kondisi ='2')"));
				$jumlahOptimal = $getJumlahOptimal['sum(jml_barang)'];
				$kebutuhanRiil = $getKebutuhanMaksimum['jumlah'] - $getJumlahOptimal['sum(jml_barang)'];
				$kebutuhanMaksimum = number_format($kebutuhanMaksimum,0,'.',',');
				$jumlahOptimal = number_format($jumlahOptimal,0,'.',',');
				$kebutuhanRill = number_format($kebutuhanRiil,0,'.',',');
			}
			echo "
								<tr valign='top'>
									<td align='$align' class='GarisCetak'>$no</td>
									<td align='left' class='GarisCetak' >".$programKegiatan."</td>
									<td align='left' class='GarisCetak' >".$kodeBarang."</td>
									<td align='left' class='GarisCetak' >".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$volBar</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='right' class='GarisCetak'>$kebutuhanMaksimum</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='left' class='GarisCetak' >".$kodeBarang."</td>
									<td align='left' class='GarisCetak' >".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$jumlahOptimal</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='right' class='GarisCetak'>$kebutuhanRill</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='left' class='GarisCetak' >".$catatan."</td>
								</tr>
			";
			$no++;
			$volBar = "";
			$jumlahBarangSebelumnya = "";
			$kebutuhanMaksimum = "";
			$jumlahOptimal = "";
			$kebutuhanRill = "";



		}
		echo 				"</table>";
		$getDataPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PENGGUNA' "));

		if($xls){
			echo
						"<br><div class='ukurantulisan' align='right'>
						<table align='right'>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>Kuasa Pengguna Barang</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'><u>".$getDataPenggunaBarang['nama']."</u></td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>NIP	".$getDataPenggunaBarang['nip']."</td>
						</tr>
						</table>
						</div>
				</body>
			</html>";
		}else{
			echo
						"<br><div class='ukurantulisan' style ='float:right;'>
						$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."<br>
						Pengguna Barang
						<br>
						<br>
						<br>
						<br>
						<br>

						<u>".$getDataPenggunaBarang['nama']."</u><br>
						NIP	".$getDataPenggunaBarang['nip']."


						</div>
			</body>
		</html>";
		}
	}
	function Pengadaan5($xls =FALSE){
		global $Main;
		$this->fileNameExcel = "HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGELOLA BARANG";
		$align = "right";
		$xls = $_GET['xls'];
		$pisah = "<td width='1%' valign='top'> : </td>";
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$align = 'center';
			$pisah = "";
		}



		$grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_rkbmd where username='$this->username'"));
		foreach ($grabSKPD as $key => $value) {
				  $$key = $value;
			}
		$grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'"));
		$urusan = $grabUrusan['nm_skpd'];
		$grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
		$bidang = $grabBidang['nm_skpd'];
		$grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
		$skpd = $grabSkpd['nm_skpd'];
		$grabUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
		$unit = $grabUnit['nm_skpd'];
		$grabSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$subunit = $grabSubUnit['nm_skpd'];
		$getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul ='KOREKSI PENGGUNA'"));
		$lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
		$getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
		$lastNomorUrut = $getLastTahap['no_urut'];
		$arrKondisi = array();
		$grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and p !='0' and q='0'");
		while($rows = mysql_fetch_array($grabProgram)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			}
			if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000' ")) == 0){
				$concat = $bk.".".$ck.".".$dk.".".$p;
				$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
			}else{
				if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' ")) == 0){
					if($q != '0'){
						$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
						$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
					}
				}else{
						$concat = $f.".".$g.".".$h.".".$i.".".$j;
					if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' ")) == 0){
						if($j != '000'){
							$arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
						}
					}
				}
			}
		}


		$Kondisi= join(' and ',$arrKondisi);
		if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}
		$qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  $Kondisi order by urut";
		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];

		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo
			"<html>".
				"<head>
					<title>$Main->Judul</title>
					$css
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan{
							font-size:17px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width:33cm;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
				<span style='font-size:18px;font-weight:bold;text-decoration: '>
					HASIL PENELAAHAN RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH<br>
					(RENCANA PENGADAAN)<br>
					PENGUNA BARANG $skpd
				</span><br>
				<span class='ukurantulisanIdPenerimaan'>TAHUN : $this->tahun </span></div><br>
				<table width=\"100%\" border=\"0\" class='subjudulcetak'>
					<tr>
						<td width='10%' valign='top'>PEMERINTAH PROVINSI</td>
						$pisah
						<td valign='top'>".$this->provinsi."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>KABUPATEN / KOTA</td>
						$pisah
						<td valign='top'>".$this->kota."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>PENGGUNA BARANG</td>
						$pisah
						<td valign='top'>".$skpd."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>URUSAN</td>
						$pisah
						<td valign='top'>".$urusan."</td>
					</tr>
					<tr>
						<td width='10%' valign='top' >BIDANG</td>
						$pisah
						<td valign='top'>".$bidang."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SKPD</td>
						$pisah
						<td valign='top'>".$skpd."</td>
					</tr>


				</table>"
								;
		echo "
								<br>
								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
										<th class='th01' rowspan='3' style='width:20px;' >NO</th>
										<th class='th02' rowspan='1' colspan='5' >USULAN RKBMD</th>
										<th class='th02' rowspan='1' colspan='2' >KEBUTUHAN MAKSIMUM</th>
										<th class='th02' rowspan='1' colspan='4' >DATA DAFTAR BARANG YANG DAPAT DIOPTIMALKAN</th>
										<th class='th02' rowspan='1' colspan='2' >KEBUTUHAN RILL BARANG MILIK DAERAH</th>
										<th class='th02' rowspan='2' colspan='2' >RENCANA KEBUTUHAN PENGADAAN BMD YANG DISETUJUI</th>
										<th class='th01' rowspan='3'  >CARA PEMENUHAN</th>
										<th class='th01' rowspan='3'  >KETERANGAN</th>
									</tr>
									<tr>
										<th class='th01' rowspan='2'>PROGRAM/KEGIATAN/OUTPUT</th>
										<th class='th01' rowspan='2'>KODE BARANG</th>
										<th class='th01' rowspan='2'>NAMA BARANG</th>
										<th class='th01' rowspan='2'>JUMLAH</th>
										<th class='th01' rowspan='2'>SATUAN</th>
										<th class='th01' rowspan='2'>JUMLAH</th>
										<th class='th01' rowspan='2'>SATUAN</th>
										<th class='th01' rowspan='2'>KODE BARANG</th>
										<th class='th01' rowspan='2'>NAMA BARANG</th>
										<th class='th01' rowspan='2'>JUMLAH</th>
										<th class='th01' rowspan='2'>SATUAN</th>
										<th class='th01' rowspan='2'>JUMLAH</th>
										<th class='th01' rowspan='2'>SATUAN</th>
									</tr>
									<tr>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>
									</tr>


		";

		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
			}
			$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
			if($p == '0'){
				$getNamaSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
				$programKegiatan = "<span style='font-weight:bold; '>".$getNamaSkpd['nm_skpd']."</span>";

			}elseif($p !='0' && $q == '0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='0'"));
				$programKegiatan = "<span style='font-weight:bold; margin-left :10px;'>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='$q'"));
				$programKegiatan = "<span style='font-weight:bold; margin-left :15px;'>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j !='000'){
				$programKegiatan = "";
				$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
				$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
				$namaBarang = $getNamaBarang['nm_barang'];
				$volBar = number_format($volume_barang,0,'.',',');
				$getKebutuhanMaksimum = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
				$kebutuhanMaksimum = $getKebutuhanMaksimum['jumlah'];
				$getJumlahOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and status_barang = '1' and (kondisi = '1' or kondisi ='2')"));
				$jumlahOptimal = $getJumlahOptimal['sum(jml_barang)'];
				$kebutuhanRiil = $getKebutuhanMaksimum['jumlah'] - $getJumlahOptimal['sum(jml_barang)'];
				$kebutuhanMaksimum = number_format($kebutuhanMaksimum,0,'.',',');
				$jumlahOptimal = number_format($jumlahOptimal,0,'.',',');
				$kebutuhanRill = number_format($kebutuhanRiil,0,'.',',');
				$nomorUrutSebelumnya = $lastNomorUrut - 1;
				$getDataSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'"));
				$jumlahBarangSebelumnya = $getDataSebelumnya['volume_barang'];

			}
			echo "
								<tr valign='top'>
									<td align='$align' class='GarisCetak'>$no</td>
									<td align='left' class='GarisCetak' >".$programKegiatan."</td>
									<td align='left' class='GarisCetak' >".$kodeBarang."</td>
									<td align='left' class='GarisCetak' >".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$jumlahBarangSebelumnya</td>
									<td align='left' class='GarisCetak' >$satuan_barang</td>
									<td align='right' class='GarisCetak'>$kebutuhanMaksimum</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='left' class='GarisCetak' >".$kodeBarang."</td>
									<td align='left' class='GarisCetak' >".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$jumlahOptimal</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='right' class='GarisCetak'>$kebutuhanRill</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>


									<td align='right' class='GarisCetak'>$volBar</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='left' class='GarisCetak' >".$cara_pemenuhan."</td>
									<td align='left' class='GarisCetak' >".$catatan."</td>
								</tr>
			";
			$no++;
			$volBar = "";
			$jumlahBarangSebelumnya = "";
			$kebutuhanMaksimum = "";
			$jumlahOptimal = "";
			$kebutuhanRill = "";




		}
		echo 				"</table>";
		if($xls){
			echo
						"<br><div class='ukurantulisan' align='right'>
						<table align='right'>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>Kuasa Pengguna Barang</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'><u>".$getDataPenggunaBarang['nama']."</u></td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>NIP	".$getDataPenggunaBarang['nip']."</td>
						</tr>
						</table>
						</div>
				";

		echo "
					<div >Telah Diperiksa : </div>
					<table table width='100%' class='cetak' border='1' style='margin-left:90px;width:50%;'>
						<tr>
							<th class='th01'>No</th>
							<th class='th01'>Nama</th>
							<th class='th01'>Jabatan</th>
							<th class='th01'>TTD / Paraf</th>
							<th class='th01'>Tanggal</th>
						</tr>
						<tr>
							<td align='right' class='GarisCetak' >1.</td>
							<td align='left' class='GarisCetak' >$this->pejabatPengelolaBarang</td>
							<td align='left' class='GarisCetak' >Pejabat Penatausahaan Barang</td>
							<td align='left' class='GarisCetak' >&nbsp</td>
							<td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
							<td align='right' class='GarisCetak' >2.</td>
							<td align='left' class='GarisCetak' >$this->pengurusPengelolaBarang</td>
							<td align='left' class='GarisCetak' >Pengurus Barang Pengelola</td>
							<td align='left' class='GarisCetak' >&nbsp</td>
							<td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
					</tabel>
			</body>
		</html>";

		}else{
			echo
						"<br><div class='ukurantulisan' style ='float:right;'>
						$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."<br>
						Pengelola Barang
						<br>
						<br>
						<br>
						<br>
						<br>

						<u>$this->pengelolaBarang</u><br>
						NIP	$this->nipPengelola


						</div>
			<br><br><br><br><br><br><br><br><br><br><br>
			";

		echo "
					<div style='margin-left:90px;width:50%;' >Telah Diperiksa : </div>
					<table table width='100%' class='cetak' border='1' style='margin-left:90px;width:50%;'>
						<tr>
							<th class='th01'>No</th>
							<th class='th01'>Nama</th>
							<th class='th01'>Jabatan</th>
							<th class='th01'>TTD / Paraf</th>
							<th class='th01'>Tanggal</th>
						</tr>
						<tr>
							<td align='right' class='GarisCetak' >1.</td>
							<td align='left' class='GarisCetak' >$this->pejabatPengelolaBarang</td>
							<td align='left' class='GarisCetak' >Pejabat Penatausahaan Barang</td>
							<td align='left' class='GarisCetak' >&nbsp</td>
							<td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
							<td align='right' class='GarisCetak' >2.</td>
							<td align='left' class='GarisCetak' >$this->pengurusPengelolaBarang</td>
							<td align='left' class='GarisCetak' >Pengurus Barang Pengelola</td>
							<td align='left' class='GarisCetak' >&nbsp</td>
							<td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
					</tabel>
			</body>
		</html>";
		}
	}
	function Pengadaan6($xls =FALSE){
		global $Main;
		$this->fileNameExcel = "RKBMD PENGADAAN PADA PENGGUNA BARANG";
		$align = "right";
		$xls = $_GET['xls'];
		$pisah = "<td width='1%' valign='top'> : </td>";
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$align = 'center';
			$pisah = "";
		}



		$grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_rkbmd where username='$this->username'"));
		foreach ($grabSKPD as $key => $value) {
				  $$key = $value;
			}
		$grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'"));
		$urusan = $grabUrusan['nm_skpd'];
		$grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
		$bidang = $grabBidang['nm_skpd'];
		$grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
		$skpd = $grabSkpd['nm_skpd'];
		$grabUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
		$unit = $grabUnit['nm_skpd'];
		$grabSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$subunit = $grabSubUnit['nm_skpd'];
		$getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d'  and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul ='KOREKSI PENGELOLA'"));
		$lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
		$getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
		$lastNomorUrut = $getLastTahap['no_urut'];
		$arrKondisi = array();
		$grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and p !='0' and q='0'");
		while($rows = mysql_fetch_array($grabProgram)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			}
			if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000' ")) == 0){
				$concat = $bk.".".$ck.".".$dk.".".$p;
				$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
			}else{
				if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' ")) == 0){
					if($q != '0'){
						$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
						$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
					}
				}else{
						$concat = $f.".".$g.".".$h.".".$i.".".$j;
					if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' ")) == 0){
						if($j != '000'){
							$arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
						}
					}
				}
			}
		}


		$Kondisi= join(' and ',$arrKondisi);
		if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}
		$qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  $Kondisi order by urut";
		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];

		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo
			"<html>".
				"<head>
					<title>$Main->Judul</title>
					$css
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan{
							font-size:17px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width:33cm;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
				<span style='font-size:18px;font-weight:bold;text-decoration: '>
					RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH<br>
					(RENCANA PENGADAAN)<br>
					PENGUNA BARANG $skpd
				</span><br>
				<span class='ukurantulisanIdPenerimaan'>TAHUN : $this->tahun </span></div><br>
				<table width=\"100%\" border=\"0\" class='subjudulcetak'>
					<tr>
						<td width='10%' valign='top'>PEMERINTAH PROVINSI</td>
						$pisah
						<td valign='top'>".$this->provinsi."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>KABUPATEN / KOTA</td>
						$pisah
						<td valign='top'>".$this->kota."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>PENGGUNA BARANG</td>
						$pisah
						<td valign='top'>".$skpd."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>URUSAN</td>
						$pisah
						<td valign='top'>".$urusan."</td>
					</tr>
					<tr>
						<td width='10%' valign='top' >BIDANG</td>
						$pisah
						<td valign='top'>".$bidang."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SKPD</td>
						$pisah
						<td valign='top'>".$skpd."</td>
					</tr>


				</table>";
		echo "
								<br>
								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
										<th class='th01' rowspan='2' style='width:20px;' >NO</th>
										<th class='th01' rowspan='2' >KUASA PENGGUNA BARANG/PROGRAM/KEGIATAN/OUTPUT</th>
										<th class='th02' rowspan='1' colspan='4' >RENCANA KEBUTUHAN BARANG MILIK DAERAH (YANG DISETUJUI)</th>
										<th class='th01' rowspan='2' >CARA PEMENUHAN</th>
										<th class='th01' rowspan='2' >KETERANGAN</th>

									</tr>
									<tr>
										<th class='th01' >KODE BARANG</th>
										<th class='th01' >NAMA BARANG</th>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>

									</tr>


		";

		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
			}
			$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
			if($p == '0'){
				$getNamaSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
				$programKegiatan = "<span style='font-weight:bold; '>".$getNamaSkpd['nm_skpd']."</span>";

			}elseif($p !='0' && $q == '0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='0'"));
				$programKegiatan = "<span style='font-weight:bold; margin-left :10px;'>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='$q'"));
				$programKegiatan = "<span style='font-weight:bold; margin-left :15px;'>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j !='000'){
				$programKegiatan = "";
				$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
				$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
				$namaBarang = $getNamaBarang['nm_barang'];
				$volBar = number_format($volume_barang,0,'.',',');
				$getKebutuhanMaksimum = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
				$kebutuhanMaksimum = $getKebutuhanMaksimum['jumlah'];
				$getJumlahOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and status_barang = '1' and (kondisi = '1' or kondisi ='2')"));
				$jumlahOptimal = $getJumlahOptimal['sum(jml_barang)'];
				$kebutuhanRiil = $getKebutuhanMaksimum['jumlah'] - $getJumlahOptimal['sum(jml_barang)'];
				$kebutuhanMaksimum = number_format($kebutuhanMaksimum,0,'.',',');
				$jumlahOptimal = number_format($jumlahOptimal,0,'.',',');
				$kebutuhanRill = number_format($kebutuhanRiil,0,'.',',');
				$nomorUrutSebelumnya = $lastNomorUrut - 1;
				$getDataSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'"));
				$jumlahBarangSebelumnya = $getDataSebelumnya['volume_barang'];

			}
			echo "
								<tr valign='top'>
									<td align='$align' class='GarisCetak'>$no</td>
									<td align='left' class='GarisCetak' >".$programKegiatan."</td>
									<td align='left' class='GarisCetak' >".$kodeBarang."</td>
									<td align='left' class='GarisCetak' >".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$volBar</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='left' class='GarisCetak' >".$cara_pemenuhan."</td>
									<td align='left' class='GarisCetak' >".$catatan."</td>
								</tr>
			";
			$volBar = "";
			$jumlahBarangSebelumnya = "";
			$no++;




		}
		echo 				"</table>";
		$getDataPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PENGGUNA' "));

		if($xls){
			echo
						"<br><div class='ukurantulisan' align='right'>
						<table align='right'>
						<tr>
						<td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
						<td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>Kuasa Pengguna Barang</td>
						</tr>
						<tr>
						<td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td>&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
						</tr>
						<tr>
						<td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
						</tr>
						<tr>
						<td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'><u>".$getDataPenggunaBarang['nama']."</u></td>
						</tr>
						<tr>
						<td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>NIP	".$getDataPenggunaBarang['nip']."</td>
						</tr>
						</table>
						</div>
				";
		}else{
			echo
						"<br><div class='ukurantulisan' style ='float:right;'>
						$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."<br>
						Pengguna Barang
						<br>
						<br>
						<br>
						<br>
						<br>

						<u>".$getDataPenggunaBarang['nama']."</u><br>
						NIP	".$getDataPenggunaBarang['nip']."


						</div>
			</body>

		</html>";
		}
	}


	function Pengadaan7($xls =FALSE){
		global $Main;
		$getJenisReport7 = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL7' "));
		$getJenisUkuran = $getJenisReport7['jenis'];
		if ($getJenisUkuran == 'L') {
			$trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
			$width = "33cm";
			$height = "21.5cm";
		}else{
			$trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
			$width = "21.5cm";
			$height = "33cm";
		}
		$arrayTandaTangan7 = explode(';', $getJenisReport7['tanda_tangan']);

		$this->fileNameExcel = "RKBMD PENGADAAN PROVINSI/KABUPATEN/KOTA";
		$align = "center";
		$xls = $_GET['xls'];
		$pisah = "<td width='1%' valign='top'> : </td>";
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			$align = 'center';
			$pisah = "";
		}



		$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
		$getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and j!='000' and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN') and jenis_form_modul ='KOREKSI PENGELOLA'"));
		$lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
		$getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
		$lastNomorUrut = $getLastTahap['no_urut'];
		$arrKondisi = array();
		$grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and p !='0' and q='0'");
		while($rows = mysql_fetch_array($grabProgram)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			}
			if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000' $this->kondisiBarang ")) == 0){
				$concat = $bk.".".$ck.".".$dk.".".$p;
				$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
			}else{
				if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' $this->kondisiBarang")) == 0){
					if($q != '0'){
						$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
						$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
					}
				}else{
						$concat = $f.".".$g.".".$h.".".$i.".".$j;
					if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' )  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' ")) == 0){
						if($j != '000'){
							$arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
						}
					}
				}
			}
		}


		$Kondisi= join(' and ',$arrKondisi);
		if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}
		$qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'  and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PENGADAAN' ) and uraian_pemeliharaan !='RKBMD PERSEDIAAN'  $this->kondisiBarang $Kondisi order by urut";
		$aqry = mysql_query($qry);

		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo
			"<html>
			<link rel='stylesheet' type='text/css' href='assets/css/bootstrap.min.css'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontFamily[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$fontMenubar[option_value]'>
  		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=$ContentFontStyle[option_value]'>
  		<link rel='stylesheet' type='text/css' href='css/pageNumber.css'>
  		<script type='text/javascript' src='assets/js/jquery-3.2.1.min.js'></script>
  		".$trChild."
  		<script type='text/javascript' src='assets/js/bootstrap.min.js'></script>".
				"<head>
					<title>$Main->Judul</title>
					$css
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan{
							font-size:15px;
							margin-bottom: 3%;

						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
						thead { display: table-header-group; }
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width: $width; height: $height; font-family: sans-serif; margin-left: 1.5cm; margin-top: 1.5cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
							<table style='width: 100%; border: none; margin-bottom: 1%;'>
								<tr>
									<td>
										<img src='".getImageReport()."' style='width: 100px; height: 100px;'>
									</td>
									<td style='text-align: center;'>
										<span style='font-size:18px;font-weight:bold;text-decoration: '>
											RENCANA KEBUTUHAN PENGADAAN BARANG MILIK DAERAH<br>
											(RENCANA PENGADAAN)<br>
											PROVINSI/KABUPATEN/KOTA
										</span>
									</td>
									<td style: width: 9%;>
										<span class='ukurantulisanIdPenerimaan' style='font-weight: bold;'>TAHUN : $this->tahun </span></div><br>
									</td>
								</tr>
							</table>


				<table width=\"100%\" border=\"0\" class='subjudulcetak' style='font-family: sans-serif;'>




				</table>";
		echo "
								<br>
								<table table width='100%' class='cetak' border='1' style='width:100%;'>
								<thead>
									<tr>
										<th class='th01' rowspan='2' style='width:20px;' >NO</th>
										<th class='th01' rowspan='2' >PENGGUNA BARANG/PROGRAM/KEGIATAN/OUTPUT</th>
										<th class='th02' rowspan='1' colspan='4' >RENCANA KEBUTUHAN BARANG MILIK DAERAH</th>
										<th class='th02' rowspan='1' colspan='2' >PEMENUHAN KEBUTUHAN BMD</th>
										<th class='th01' rowspan='2' >CARA PEMENUHAN</th>
										<th class='th01' rowspan='2' >KETERANGAN</th>
									</tr>
									<tr>
										<th class='th01' colspan='2'>KODE / NAMA BARANG</th>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>
										<th class='th01' >JUMLAH</th>
										<th class='th01' >SATUAN</th>
									</tr>
								</thead>

		";
		$arrayPenggunaBarang = array();
		$arrayExcept = array();
		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
			}
			$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
			$konket = $c1.".".$c.".".$d;
			if($p == '0'){
				$getNamaSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='00' and e1='000'"));
				$programKegiatan = "<span style='font-weight:bold; '>".$getNamaSkpd['nm_skpd']."</span>";

				if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and uraian_pemeliharaan =''  and c1='$c1' and c='$c' and d='$d' and j!='000' ")) == 0){
					$arrayExcept[] = $konket;
				}else{
					if(array_search($konket,$arrayPenggunaBarang) == ''){
						$arrayPenggunaBarang[] = $konket;
					}
				}

			}elseif($p !='0' && $q == '0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='0'"));
				$programKegiatan = "<span style='font-weight:bold;'>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j =='000'){
				$getProgramKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q='$q'"));
				$programKegiatan = "<span style='font-weight:bold; '>".$getProgramKegiatan['nama']."</span>";
				$kodeBarang = "";
				$namaBarang = "";
			}elseif($q !='0' && $j !='000'){
				$programKegiatan = "";
				$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
				$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'"));
				$namaBarang = $getNamaBarang['nm_barang'];
				$volBar = number_format($volume_barang,0,'.',',');
				$nomorUrutSebelumnya = $lastNomorUrut - 1;
				$getDataSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck ='$ck' and dk ='$dk' and p = '$p' and q= '$q' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and bk ='$bk' and ck='$ck' and p='$p' and q='$q'"));
				$jumlahBarangSebelumnya = $getDataSebelumnya['volume_barang'];

			}


			if ($p == '0') {
				$namaProgram = "<td align='left' class='GarisCetak' colspan='5'>".$programKegiatan."</td>";

			}elseif($p !='0' && $q == '0' && $j =='000'){
				$getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
				$getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
				$outputan = $getDetailRenja[output];

				$namaKegiatan = "<td align='left' style='padding-left: 10px;' class='GarisCetak' colspan='5'>".$programKegiatan." </td>";

			}elseif($q !='0' && $j =='000'){
				$getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
				$getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
				$outputan = $getDetailRenja[output];

				$namaKegiatan2 = "<td align='left' style='padding-left: 15px;' class='GarisCetak' colspan='5'>".$programKegiatan."</br>OUTPUT : $outputan </td>";
			}
			if ($p =='0' && $q == '0' && $j =='000') {
				$naonkitu =
				"
								<tr valign='top'>
									<td align='$align' class='GarisCetak'>$no</td>
									".$namaProgram."
									<td align='left' class='GarisCetak' >".$kodeBarang."</td>
									<td align='left' class='GarisCetak' >".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$jumlahBarangSebelumnya</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
								</tr>
			";
			}elseif ($p !='0' && $q == '0' && $j =='000') {
				$naonkitu =
				"
								<tr valign='top'>
									<td align='$align' class='GarisCetak'>$no</td>
									".$namaKegiatan."
									<td align='left' class='GarisCetak' >".$kodeBarang."</td>
									<td align='left' class='GarisCetak' >".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$jumlahBarangSebelumnya</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
								</tr>
			";
			}elseif($q !='0' && $j =='000'){
				$naonkitu =
				"
								<tr valign='top'>
									<td align='$align' class='GarisCetak'>$no</td>
									".$namaKegiatan2."
									<td align='left' class='GarisCetak' >".$kodeBarang."</td>
									<td align='left' class='GarisCetak' >".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$jumlahBarangSebelumnya</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
								</tr>
			";
			}else{
				$naonkitu =
				"
								<tr valign='top'>
									<td align='$align' class='GarisCetak'>$no</td>
									<td align='left' class='GarisCetak' colspan='1'></td>
									<td align='left' class='GarisCetak' colspan='2'>".$kodeBarang."</br>".$namaBarang."</td>
									<td align='right' class='GarisCetak'>$jumlahBarangSebelumnya</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='right' class='GarisCetak'>$volBar</td>
									<td align='left' class='GarisCetak' >".$satuan_barang."</td>
									<td align='left' class='GarisCetak' >".$cara_pemenuhan."</td>
									<td align='left' class='GarisCetak' >".$catatan."</td>
								</tr>
			";
			}

			echo $naonkitu;
			$naonkitu = "";
			$no++;
			$volBar = "";
			$jumlahBarangSebelumnya = "";
			$kebutuhanMaksimum = "";
			$jumlahOptimal = "";
			$kebutuhanRill = "";
			$namaBarang = "";
			$kodeBarang = "";



		}
		echo 				"</table>";

		if($xls){
			echo
						"<br><div class='ukurantulisan' align='right'>
						<table align='right'>
						<tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."
						</td>
						</tr>
						<tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						Pengelola Barang
						</td>
						</tr>
						<tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						&nbsp
						</td>
						</tr><tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						&nbsp
						</td>
						</tr><tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						&nbsp
						</td>
						</tr>
						<tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						<u>$this->pengelolaBarang</u>
						</td>
						</tr><tr>
						<td >
						&nbsp
						</td>
						<td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td><td >
						&nbsp
						</td>
						<td colspan='2'>
						NIP	$this->nipPengelola
						</td>
						</tr>





						</table>
						</div>
				</body>
			</html>";
		}else{
			if (sizeof($arrayTandaTangan7)==1) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport7['posisi'];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$arrayPosisi' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$arrayPosisi' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$_GET['kota'].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            $queryKategori1[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$queryNama1['nama']."</u><br>
            NIP ".$queryNama1['nip']."


            </div>";

          }elseif (sizeof($arrayTandaTangan7)==2) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport7['posisi']);
            $panjangArrayPosisi = sizeof($arrayPosisi);
            $kategoriKanan = $arrayPosisi[$panjangArrayPosisi-1];
            $kategoriKiri = $arrayPosisi[$panjangArrayPosisi-3];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKanan' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $queryNama2 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKiri' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKanan' "));
            $queryKategori2 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKiri' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$_GET['kota'].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            $queryKategori1[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$queryNama1['nama']."</u><br>
            NIP ".$queryNama1['nip']."


            </div>

            <div class='ukurantulisan' style ='float:left; text-align:center;'>
            $queryKategori2[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$queryNama2['nama']."</u><br>
            NIP ".$queryNama2['nip']."


            </div>";

          }elseif (sizeof($arrayTandaTangan7)==3) {
            $c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport7['posisi']);
            $panjangArrayPosisi = sizeof($arrayPosisi);
            $kategoriKanan = $arrayPosisi[$panjangArrayPosisi-1];
            $kategoriKiri = $arrayPosisi[$panjangArrayPosisi-3];
            $kategoriTengah = $arrayPosisi[$panjangArrayPosisi-2];

            $queryNama1 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKanan' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $queryNama2 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandatangan = '$kategoriKiri' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));
            $queryNama3 = mysql_fetch_array(mysql_query("SELECT * from ref_tandatangan where kategori_tandangan = '$kategoriTengah' and c1 = '$c1' and c = '$c' and d = '$d' and e = '$e' and e1 = '$e1' "));

            $queryKategori1 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKanan' "));
            $queryKategori2 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriKiri' "));
            $queryKategori3 = mysql_fetch_array(mysql_query("SELECT * from ref_kategori_tandatangan where id = '$kategoriTengah' "));

            $tandaTanganna .= "<br><br><br>
            <div class='ukurantulisan' style ='float:right; text-align:center;'>
            ".$_GET['kota'].", ".VulnWalkerTitiMangsa($_GET['tanggalCetak'])."<br>
            $queryKategori1[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$queryNama1['nama']."</u><br>
            NIP ".$queryNama1['nip']."


            </div>

            <div class='ukurantulisan' style ='float:left; text-align:center;'>
            $queryKategori2[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$queryNama2['nama']."</u><br>
            NIP ".$queryNama2['nip']."


            </div>

            <div class='ukurantulisan' style ='float:right; text-align:center; position: relative; left: -25%;'>
            $queryKategori3[kategori_tandatangan]
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <u>".$queryNama3['nama']."</u><br>
            NIP ".$queryNama3['nip']."


            </div>";

          }
			echo
						"
						".$tandaTanganna."
						<h5 class='pag pag1'>
							<span style='bottom: -10px; position: absolute; left:0;'>".date('d-m-Y')." / ".date('h:i')." / ".$this->username."</span>
						</h5>
  					<div class='insert'></div>
				</body>
			</html>";
		}



	}

function excel($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 800;
	 $this->form_height = 80;
	 $this->form_caption = 'LAPORAN RKBMD PENGADAAN';

	 $c1 = $dt['penetapanRKBMDPengadaanSkpdfmUrusan'];
	 $c = $dt['penetapanRKBMDPengadaanSkpdfmSKPD'];
	 $d = $dt['penetapanRKBMDPengadaanSkpdfmUNIT'];
	 $e = $dt['penetapanRKBMDPengadaanSkpdfmSUBUNIT'];
	 $e1 = $dt['penetapanRKBMDPengadaanSkpdfmSEKSI'];


	 /*if($e1 != '000'){
	 	 $arrayJenisLaporan = array(
	 						   array('Pengadaan1', 'USULAN RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG'),
							   array('Pengadaan2', 'HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGGUNA BARANG'),
							   array('Pengadaan3', 'RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG'),
							   );
	 }elseif($d !='00'){
	 	 $arrayJenisLaporan = array(
							   array('Pengadaan4', 'USULAN RKBMD PENGADAAN PADA PENGGUNA BARANG'),
							   array('Pengadaan5', 'HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGELOLA BARANG'),
							   array('Pengadaan6', 'RKBMD PENGADAAN PADA PENGGUNA BARANG'),


							   );
	 }else{*/
	 	$arrayJenisLaporan = array(
							   array('Pengadaan7', 'RKBMD PENGADAAN PROVINSI/KABUPATEN/KOTA'),

							   );
	 /*}*/

	/* $arrayJenisLaporan = array(
	 						   array('Pengadaan1', 'USULAN RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG'),
							   array('Pengadaan2', 'HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGGUNA BARANG'),
							   array('Pengadaan3', 'RKBMD PENGADAAN PADA KUASA PENGGUNA BARANG'),
							   array('Pengadaan4', 'USULAN RKBMD PENGADAAN PADA PENGGUNA BARANG'),
							   array('Pengadaan5', 'HASIL PENELAAHAN RKBMD PENGADAAN OLEH PENGELOLA BARANG'),
							   array('Pengadaan6', 'RKBMD PENGADAAN PADA PENGGUNA BARANG'),
							   array('Pengadaan7', 'RKBMD PENGADAAN PROVINSI/KABUPATEN/KOTA'),

							   );*/

	  $cmbJenisLaporan = cmbArray('jenisKegiatan','',$arrayJenisLaporan,'-- JENIS LAPORAN --',"onchange = $this->Prefix.jenisChanged();");
	  $this->form_fields = array(
			'jenisLaporan' => array(
						'label'=>'JENIS LAPORAN',
						'labelWidth'=>100,
						'value'=> $cmbJenisLaporan
						 ),
			'Cetakjang' => array(
									'label'=>'TANGGAL CETAK',
									'labelWiidth'=>100,
									'value'=>"<input type='date' name='cetakjang' id='cetakjang' value='".date('Y-m-d')."'>
									",
								),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Download' onclick ='".$this->Prefix.".DownloadExcel()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
}
$penetapanRKBMDPengadaan = new penetapanRKBMDPengadaanObj();
$arrayResult = tahapKoreksi("KOREKSI PENGELOLA","MURNI");
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = "MURNI";
$idTahap = $arrayResult['idTahap'];

$penetapanRKBMDPengadaan->jenisForm = $jenisForm;
$penetapanRKBMDPengadaan->nomorUrut = $nomorUrut;
$penetapanRKBMDPengadaan->urutTerakhir = $nomorUrut;
$penetapanRKBMDPengadaan->tahun = $tahun;
$penetapanRKBMDPengadaan->jenisAnggaran = $jenisAnggaran;
$penetapanRKBMDPengadaan->idTahap = $idTahap;
$penetapanRKBMDPengadaan->username = $_COOKIE['coID'];
$penetapanRKBMDPengadaan->wajibValidasi = $arrayResult['wajib_validasi'];
if($penetapanRKBMDPengadaan->wajibValidasi == TRUE){
	$penetapanRKBMDPengadaan->sqlValidasi = " and status_validasi ='1' ";
}else{
	$penetapanRKBMDPengadaan->sqlValidasi = " ";
}

$penetapanRKBMDPengadaan->provinsi = $arrayResult['provinsi'];
$penetapanRKBMDPengadaan->kota = $arrayResult['kota'];
$penetapanRKBMDPengadaan->pengelolaBarang = $arrayResult['pengelolaBarang'];
$penetapanRKBMDPengadaan->pejabatPengelolaBarang = $arrayResult['pejabat'];
$penetapanRKBMDPengadaan->pengurusPengelolaBarang = $arrayResult['pengurus'];
$penetapanRKBMDPengadaan->nipPengelola = $arrayResult['nipPengelola'];
$penetapanRKBMDPengadaan->nipPengurus = $arrayResult['nipPengurus'];
$penetapanRKBMDPengadaan->nipPejabat = $arrayResult['nipPejabat'];

?>
