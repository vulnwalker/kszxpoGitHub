<?php

class anggaranKasSKPD32Obj  extends DaftarObj2{
	var $Prefix = 'anggaranKasSKPD32';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_dpa_3_2'; //bonus
	var $TblName_Hapus = 'tabel_anggaran';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id_anggaran');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 7, 7, 7);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 2;
	var $PageTitle = 'ANGGARAN KAS';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='anggaranKasSKPD32.xls';
	var $namaModulCetak='DPA';
	var $Cetak_Judul = 'DPA';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'anggaranKasSKPD32Form';
	var $modul = "DPA";
	var $jenisForm = "";
	var $tahun = "";
	var $nomorUrut = "";
	var $jenisAnggaran = "";
	var $idTahap = "";
	var $currentTahap = "";
	var $namaTahapTerakhir = "";
	var $masaTerakhir = "";
	//buatview
	var $urutTerakhir = "";
	var $urutSebelumnya = "";
	var $jenisFormTerakhir = "";

	var $username = "";
	var $provinsi = "";
	var $kota = "";
	var $pengelolaBarang = "";
	var $pejabatPengelolaBarang = "";
	var $pengurusPengelolaBarang = "";
	var $nipPengelola = "";
	var $nipPejabat = "";
	var $nipPengurus ="";

	var $publicVar = "";
	var $publicKondisi = "";
	var $publicExcept = array();
	var $publicGrupId = array();

	var $publicSum = '';

	//buatview
	var $TampilFilterColapse = 0; //0

	function setTitle(){
		return 'ANGGARAN KAS SKPD PEMBIAYAAN PENGELUARAN '.$this->jenisAnggaran.' TAHUN '.$this->tahun;
	}
	function genRowSum($ColStyle, $Mode, $Total){
		foreach ($_REQUEST as $key => $value) {
		  	$$key = $value;
		 }
		 if($cmbSubUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
		if(!empty($hiddenP)){
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP'";
					if(!empty($q)){
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q='$q'";
		}
		}
		}elseif($cmbUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
		}elseif($cmbSKPD != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
		}elseif($cmbBidang != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
		}elseif($cmbUrusan != ''){
			$kondisiSKPD = "and c1='$cmbUrusan'";
		}
	 	if(!empty($cmbBelanja)){
				if($cmbBelanja == "BELANJA PEGAWAI"){
					$kondisiRekening = "and k='5' and l ='2' and m ='1'";
				}elseif($cmbBelanja == "BELANJA BELANJA BARANG & JASA"){
					$kondisiRekening = "and k='5' and l ='2' and m ='2'";
				}elseif($cmbBelanja == "BELANJA MODAL"){
					$kondisiRekening = "and k='5' and l ='2' and m ='3'";
				}

		}
		if($this->wajibValidasi == TRUE)$tergantung = "<td class='GarisDaftar' align='center' ></td>";
		$ContentTotal =
		"<tr>
			<td class='$ColStyle' colspan='3' align='center'><b>Total </td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->total,2,',','.')."</div></td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalJan,2,',','.')."</div></td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalFeb,2,',','.')."</div></td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalMar,2,',','.')."</div></td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalApr,2,',','.')."</div></td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalMei,2,',','.')."</div></td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalJun,2,',','.')."</div></td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalJul,2,',','.')."</div></td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalAgu,2,',','.')."</div></td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalSep,2,',','.')."</div></td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalOkt,2,',','.')."</div></td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalNop,2,',','.')."</div></td>
			<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalDes,2,',','.')."</div></td>

			$tergantung
		</tr>" ;

			if($Mode == 2){
				$ContentTotal = '';
			}else if($Mode == 3){
				$ContentTotalHal='';
			}

		return $ContentTotalHal.$ContentTotal;
	}
	function setMenuEdit(){
	 if ($this->jenisForm == "READ"){
	 	$listMenu =
		 // "<td>".genPanelIcon("javascript:".$this->Prefix.".Sync()","sync.png","Sync", 'Sync ')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".checkAlokasi()","alokasi.jpg","Alokasi", 'Alokasi')."</td>"
					// "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>"

					;
	 }else{
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
	 }

		return $listMenu ;
	}
	function setMenuView(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";

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
			foreach ($_REQUEST as $key => $value) {
			 	 $$key = $value;
			}

			if(empty($cmbUrusan)){
				$err = "Pilih Urusan";
			}elseif(empty($cmbBidang)){
				$err = "Pilih Bidang";
			}elseif(empty($cmbSKPD)){
				$err = "Pilih SKPD";
			}elseif(empty($cmbUnit)){
				$err = "Pilih Unit";
			}elseif(empty($cmbBidang)){
				$err = "Pilih Bidang";
			}elseif(empty($q)){
				$err = "Pilih Kegiatan";
			}elseif(empty($cmbJenisDPA)){
				$err = "Pilih Jenis DPA";
			}else{
				$fm = $this->setFormBaru();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			}


		break;
		}
		case 'formRincianVolume':{
				$dt = $_REQUEST['id'];
				$fm = $this->formRincianVolume($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


		break;
		}
		case 'sync':{
				if($this->jenisForm == 'READ'){
						$nomorUrutRka = $this->nomorUrut - 1;
						$getIdTahapRka = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '".$nomorUrutRka."' and tahun ='$this->tahun' and anggaran='$this->jenisAnggaran'"));
						$this->idTahapRka = $getIdTahapRka['id_tahap'];
						$cek = "select * from view_rka_2_1 where id_tahap = '$this->idTahapRka' and rincian_perhitungan !=''";
						$getAllSubRincian = mysql_query("select * from view_rka_2_1 where id_tahap = '$this->idTahapRka' and rincian_perhitungan !=''");
						while($subRincian = mysql_fetch_array($getAllSubRincian)){
									$queryCekProgram = "select * from view_dpa_3_2 where c1='0' and j = '000' and rincian_perhitungan = '' and bk ='".$subRincian['bk']."' and ck ='".$subRincian['ck']."' and dk='".$subRincian['dk']."' and p ='".$subRincian['p']."' and q='0' and id_tahap='$this->idTahap' ";
									if(mysql_num_rows(mysql_query($queryCekProgram)) == 0){
										$arrayProgram = array(
																 'c1' => '0',
																 'c' => '00',
																 'd' => '00',
																 'e' => '00',
																 'e1' => '000',
																 'f1' => '0',
														  	 'f2' => '0',
														  	 'f' => '00',
														 		 'g' => '00',
														  	 'h' => '00',
																 'i' => '00',
																 'j' => '000',
																 'bk'=> $subRincian['bk'],
						 										 'ck'=> $subRincian['ck'],
						 										 'dk'=> $subRincian['dk'],
						 										 'p' => $subRincian['p'],
						 										 'q' => '0',
																 'jenis_rka' => '3.2',
																 'tahun' => $this->tahun,
																 'jenis_anggaran' => $this->jenisAnggaran,
																 'id_tahap' => $this->idTahap,
																 'nama_modul' => 'DPA-SKPD',
																 'id_rincian_belanja' => ""
																	);
										$queryInsertProgram = VulnWalkerInsert('tabel_anggaran',$arrayProgram);
										mysql_query($queryInsertProgram);
									}

									$queryCekKegiatan= "select * from view_dpa_3_2 where c1='0' and j = '000' and rincian_perhitungan = '' and bk ='".$subRincian['bk']."' and ck ='".$subRincian['ck']."' and dk='".$subRincian['dk']."' and p ='".$subRincian['p']."' and q='".$subRincian['q']."' and id_tahap='$this->idTahap' ";
									if(mysql_num_rows(mysql_query($queryCekKegiatan)) == 0){
										$arrayKegiatan = array(
																 'c1' => '0',
																 'c' => '00',
																 'd' => '00',
																 'e' => '00',
																 'e1' => '000',
																 'f1' => '0',
														  	 'f2' => '0',
														  	 'f' => '00',
														 		 'g' => '00',
														  	 'h' => '00',
																 'i' => '00',
																 'j' => '000',
																 'bk'=> $subRincian['bk'],
						 										 'ck'=> $subRincian['ck'],
						 										 'dk'=> $subRincian['dk'],
						 										 'p' => $subRincian['p'],
						 										 'q' => $subRincian['q'],
																 'k' => '0',
																 'l' => '0',
																 'm' => '0',
																 'n' => '0',
																 'o' => '0',
																 'jenis_rka' => '3.2',
																 'tahun' => $this->tahun,
																 'jenis_anggaran' => $this->jenisAnggaran,
																 'id_tahap' => $this->idTahap,
																 'nama_modul' => 'DPA-SKPD',
																 'id_rincian_belanja' => ""
																	);
										$queryInsertKegiatan = VulnWalkerInsert('tabel_anggaran',$arrayKegiatan);
										mysql_query($queryInsertKegiatan);
									}

									$queryCekRekening = "select * from view_dpa_3_2 where c1='0' and j = '000' and rincian_perhitungan = '' and bk ='".$subRincian['bk']."' and ck ='".$subRincian['ck']."' and dk='".$subRincian['dk']."' and p ='".$subRincian['p']."' and q='".$subRincian['q']."' and k ='".$subRincian['k']."' and l ='".$subRincian['l']."' and m ='".$subRincian['m']."' and n ='".$subRincian['n']."' and o ='".$subRincian['o']."' and id_rincian_belanja='' and id_tahap='$this->idTahap' ";
									if(mysql_num_rows(mysql_query($queryCekRekening)) == 0){
										$getRekening = mysql_fetch_array(mysql_query("select * from view_rka_2_1 where id_tahap = '$this->idTahapRka' and c1='0' and j = '000' and rincian_perhitungan = '' and bk ='".$subRincian['bk']."' and ck ='".$subRincian['ck']."' and dk='".$subRincian['dk']."' and p ='".$subRincian['p']."' and q='".$subRincian['q']."' and k ='".$subRincian['k']."' and l ='".$subRincian['l']."' and m ='".$subRincian['m']."' and n ='".$subRincian['n']."' and o ='".$subRincian['o']."' and id_rincian_belanja='' "));
										$arrayRekening = array(
																 'c1' => '0',
																 'c' => '00',
																 'd' => '00',
																 'e' => '00',
																 'e1' => '000',
																 'f1' => '0',
														  	 'f2' => '0',
														  	 'f' => '00',
														 		 'g' => '00',
														  	 'h' => '00',
																 'i' => '00',
																 'j' => '000',
																 'bk'=> $subRincian['bk'],
						 										 'ck'=> $subRincian['ck'],
						 										 'dk'=> $subRincian['dk'],
						 										 'p' => $subRincian['p'],
						 										 'q' => $subRincian['q'],
																 'k' => $subRincian['k'],
																 'l' => $subRincian['l'],
																 'm' => $subRincian['m'],
																 'n' => $subRincian['n'],
																 'o' => $subRincian['o'],
																 'sumber_dana' => $getRekening['sumber_dana'],
																 'jenis_rka' => '3.2',
																 'tahun' => $this->tahun,
																 'jenis_anggaran' => $this->jenisAnggaran,
																 'id_tahap' => $this->idTahap,
																 'nama_modul' => 'DPA-SKPD',
																 'id_rincian_belanja' => ""
																	);
										$queryInsertRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
										mysql_query($queryInsertRekening);
									}

									$queryCekRincianBelaja = "select * from view_dpa_3_2 where c1='".$subRincian['c1']."' and c = '".$subRincian['c']."' and d='".$subRincian['d']."' and  rincian_perhitungan = '' and bk ='".$subRincian['bk']."' and ck ='".$subRincian['ck']."' and dk='".$subRincian['dk']."' and p ='".$subRincian['p']."' and q='".$subRincian['q']."' and k ='".$subRincian['k']."' and l ='".$subRincian['l']."' and m ='".$subRincian['m']."' and n ='".$subRincian['n']."' and o ='".$subRincian['o']."' and id_rincian_belanja = '".$subRincian['id_rincian_belanja']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'";
	 							 if(mysql_num_rows(mysql_query($queryCekRincianBelaja)) == 0){
	 								 $arrayRincianBelanja = array(
	 															'c1' => $subRincian['c1'],
	 															'c' => $subRincian['c'],
	 															'd' => $subRincian['d'],
	 															'e' => '00',
	 															'e1' => '000',
	 															'f1' => '0',
	 		 										  	  'f2' => '0',
	 		 										  	  'f' => '00',
	 		 										 		  'g' => '00',
	 		 										  	  'h' => '00',
	 		 												  'i' => '00',
	 		 												  'j' => '000',
	 															'bk'=> $subRincian['bk'],
	 															'ck'=> $subRincian['ck'],
	 															'dk'=> $subRincian['dk'],
	 															'p' => $subRincian['p'],
	 															'q' => $subRincian['q'],
	 															'k' => $subRincian['k'],
	 															'l' => $subRincian['l'],
	 															'm' => $subRincian['m'],
	 															'n' => $subRincian['n'],
	 															'o' => $subRincian['o'],
	 															'jenis_rka' => '3.2',
	 															'tahun' => $this->tahun,
	 															'jenis_anggaran' => $this->jenisAnggaran,
	 															'id_tahap' => $this->idTahap,
	 															'nama_modul' => 'DPA-SKPD',
	 															'id_rincian_belanja' => $subRincian['id_rincian_belanja'],
	 															'rincian_perhitungan' => '',
	 															 );
	 								 $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
	 								 mysql_query($queryRincianBelanja);
	 							 }


								 $queryCekSubRincian = "select * from view_dpa_3_2 where c1='".$subRincian['c1']."' and c = '".$subRincian['c']."' and d='".$subRincian['d']."' and  rincian_perhitungan = '".$subRincian['rincian_perhitungan']."' and bk ='".$subRincian['bk']."' and ck ='".$subRincian['ck']."' and dk='".$subRincian['dk']."' and p ='".$subRincian['p']."' and q='".$subRincian['q']."' and k ='".$subRincian['k']."' and l ='".$subRincian['l']."' and m ='".$subRincian['m']."' and n ='".$subRincian['n']."' and o ='".$subRincian['o']."' and id_rincian_belanja = '".$subRincian['id_rincian_belanja']."'  and f1 ='".$subRincian['f1']."' and f2='".$subRincian['f2']."' and f='".$subRincian['f']."' and g='".$subRincian['g']."' and h ='".$subRincian['h']."' and i ='".$subRincian['i']."' and j ='".$subRincian['j']."' and id_tahap='$this->idTahap'";
								 if(mysql_num_rows(mysql_query($queryCekSubRincian)) == 0){

										 $arraySubRincian = array(
																	'c1' => $subRincian['c1'],
																	'c' => $subRincian['c'],
																	'd' => $subRincian['d'],
																	'e' => '00',
																	'e1' => '000',
																	'f1' => $subRincian['f1'],
																	'f2' => $subRincian['f2'],
																	'f' => $subRincian['f'],
																	'g' => $subRincian['g'],
																	'h' => $subRincian['h'],
																	'i' => $subRincian['i'],
																	'j' => $subRincian['j'],
																	'bk'=> $subRincian['bk'],
																	'ck'=> $subRincian['ck'],
																	'dk'=> $subRincian['dk'],
																	'p' => $subRincian['p'],
																	'q' => $subRincian['q'],
																	'k' => $subRincian['k'],
																	'l' => $subRincian['l'],
																	'm' => $subRincian['m'],
																	'n' => $subRincian['n'],
																	'o' => $subRincian['o'],
																	'jenis_rka' => '3.2',
																	'tahun' => $this->tahun,
																	'jenis_anggaran' => $this->jenisAnggaran,
																	'id_tahap' => $this->idTahap,
																	'nama_modul' => 'DPA-SKPD',
																	'id_rincian_belanja' => $subRincian['id_rincian_belanja'],
																	'rincian_volume' => $subRincian['rincian_volume'],
																	'volume_rek' => $subRincian['volume_rek'],
																	'jumlah' => $subRincian['jumlah'],
																	'jumlah_harga' => $subRincian['jumlah_harga'],
																	'rincian_perhitungan' => $subRincian['rincian_perhitungan'],
																	'jumlah1' => $subRincian['jumlah1'],
																	'jumlah2' => $subRincian['jumlah2'],
																	'jumlah3' => $subRincian['jumlah3'],
																	'satuan1' => $subRincian['satuan1'],
																	'satuan2' => $subRincian['satuan2'],
																	'satuan3' => $subRincian['satuan3'],
																	'satuan_total' => $subRincian['satuan_total'],
																	 );
										 $queryInsertSubRincian = VulnWalkerInsert('tabel_anggaran',$arraySubRincian);
										 mysql_query($queryInsertSubRincian);
								 }






			  }

  }

		break;
		}
		case 'newSatuanSatuan':{
				$fm = $this->newSatuanSatuan($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'SaveSatuanSatuan':{
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			 $data = array( "satuan_rekening" => $namaSatuan,
			 				"type" => 'satuan'
			 				);
			 $query = VulnWalkerInsert("ref_satuan_rekening",$data);
			 $execute = mysql_query($query);
			 if($execute){

			 }else{
			 	$err = "input gagal";
			 }

			$content .= $query;
		break;
	    }
		case 'newSatuanVolume':{
				$fm = $this->newSatuanVolume($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'Info':{
				$fm = $this->Info();
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'SaveSatuanVolume':{
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			 $data = array( "satuan_rekening" => $namaSatuan,
			 				"type" => 'volume'
			 				);
			 $query = VulnWalkerInsert("ref_satuan_rekening",$data);
			 $execute = mysql_query($query);
			 if($execute){

			 }else{
			 	$err = "input gagal";
			 }

			$content .= $query;
		break;
	    }
		case  'SaveRincianVolume':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			$grabVolume = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id'"));

			$volumeRek = $grabVolume['volume_rek'];
			$data = array( 'jumlah1' => $jumlah1,
						   'satuan1' => $satuan1,
						   'jumlah2' => $jumlah2,
						   'satuan2' => $satuan2,
						   'jumlah3' => $jumlah3,
						   'satuan3' => $satuan3,
						   'jumlah4' => $jumlahTotal,
						   'satuan_total' => $satuanTotal,
						  );

			$query = VulnWalkerUpdate('tabel_anggaran',$data,"id_anggaran = '$id' ");
			if($volumeRek != $jumlahTotal ){
				$err = "Total Rincian Tidak Sama";
			}elseif( (!empty($jumlah1) && empty($satuan1) ) || (!empty($jumlah2) && empty($satuan2) || (!empty($jumlah3) && empty($satuan3)  || (!empty($jumlahTotal) && empty($satuanTotal) ) ) )  ){
				$err = "Pilih satuan";
			}else{
				mysql_query($query);
			}

			$content = array('query' => $query,"volumeRek" => $volumeRek);



			break;
		}

		case 'Report':{
			foreach ($_REQUEST as $key => $value) {
			 	 $$key = $value;
			}
			if(empty($cmbUrusan)){
				$err = "Pilih Urusan";
			}elseif(empty($cmbBidang)){
				$err = "Pilih Bidang";
			}elseif(empty($cmbSKPD)){
				$err = "Pilih SKPD";
			}elseif(empty($hiddenP)){
				$err = "Pilih Program";
			}elseif(empty($q)){
				$err = "Pilih Kegiatan";
			}else{
				if(mysql_num_rows(mysql_query("select * from skpd_report_dpa_2_1 where username= '$this->username'")) == 0){
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD,
								  'bk' => $bk,
								  'ck' => $ck,
								  'p' => $hiddenP,
								  'q' => $q,

								  );
					$query = VulnWalkerInsert('skpd_report_dpa_2_1',$data);
					mysql_query($query);
				}else{
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD,
								  'bk' => $bk,
								  'ck' => $ck,
								  'p' => $hiddenP,
								  'q' => $q,

								  );
					$query = VulnWalkerUpdate('skpd_report_dpa_2_1',$data,"username = '$this->username'");
					mysql_query($query);
				}

			}
		break;
		}
		case 'Laporan':{
			$json = FALSE;
			$this->Laporan($dt);
		break;
		}
		case 'clearTemp':{
				$username =$_COOKIE['coID'];
				mysql_query("delete from temp_rka_221 where user ='$username'");
		break;
		}
		case 'BidangAfterForm':{
			 $kondisiBidang = "";
			 $cmbUrusan = $_REQUEST['fmSKPDUrusan'];
			 $cmbBidang = $_REQUEST['fmSKPDBidang'];

			 $codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) as vnama from ref_skpd where d='00' and c ='00' order by c1";

		     $codeAndNameBidang = "SELECT c, concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where d = '00' and e = '00' and c!='00'and c1 = '$cmbUrusan'  and e1='000'";

		     $codeAndNameskpd = "SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd  where c='$cmbBidang' and c1='$cmbUrusan' and d != '00' and  e = '00' and e1='000' ";


				$bidang =  cmbQuery('cmbBidangForm', $cmbBidang, $codeAndNameBidang,' '.$cmbRo.' onChange=\''.$this->Prefix.'.BidangAfterform()\'','-- Pilih Semua --');
				$skpd = cmbQuery('cmbSKPDForm', $cmbSKPD, $codeAndNameskpd,''.$cmbRo.'','-- Pilih Semua --');
				$content = array('bidang' => $bidang, 'skpd' =>$skpd ,'queryGetBidang' => $kondisiBidang);
			break;
			}
		case 'formEdit':{
			$fm = $this->setFormEdit();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'Remove':{
			$id = $_REQUEST['anggaranKasSKPD32_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			$username = $_COOKIE['coID'];

			$get = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$id[0]'"));
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;

			$getAll = mysql_query("select * from view_dpa_3_2 where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and (rincian_perhitungan !='' or f!='00' )   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and p='$hiddenP' and q='$q' order by o1, rincian_perhitungan");
			mysql_query("delete from temp_rincian_volume where user='$username'");
		    mysql_query("delete from temp_alokasi_rka where user='$username'");
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) {
				  $$key = $value;
				}
				mysql_query("delete from tabel_anggaran where id_anggaran = '$id_anggaran'");
				mysql_query("delete from tabel_anggaran where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and o1 ='$o1' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and jenis_rka='3.2' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'");
			}

			break;
		}




		case 'formAlokasi':{

				$fm = $this->formAlokasi();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


		break;
		}
		case 'formAlokasiTriwulan':{
				$fm = $this->formAlokasiTriwulan();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


		break;
		}

		case 'checkAlokasi':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$c1 = $cmbUrusan;
			$c = $cmbBidang;
			$d = $cmbSKPD;
			$p = $hiddenP;
			$terpilih = $anggaranKasSKPD32_cb[0];



			if($this->jenisForm != "READ"){
				$err = "Tahap Telah Habis";
			}else{
				$getKodeRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$terpilih'"));
				$k = $getKodeRekening['k'];
				$l = $getKodeRekening['l'];
				$m = $getKodeRekening['m'];
				$n = $getKodeRekening['n'];
				$o = $getKodeRekening['o'];
				$jenisAlokasi = "";
				if(mysql_num_rows(mysql_query("select * from anggaran_kas where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c='$c' and d ='$d' and bk ='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' and jenis_rka = '3.2' and jenis_dpa = 'DPA-SKPD'")) != 0){
					$getAlokasi = mysql_fetch_array(mysql_query("select * from anggaran_kas where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c='$c' and d ='$d' and bk ='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' and jenis_rka = '3.2' and jenis_dpa = 'DPA-SKPD'"));
					foreach ($getAlokasi as $key => $value) {
						  $$key = $value;
					}
					$jenisAlokasi = $jenis_alokasi_kas;
				}
			}

			$content = array("jenis" => $jenisAlokasi)	;

		break;
		}
		case 'saveAlokasi' : {
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			if($this->jenisForm != "READ"){
				$err = "Tahap Telah Habis";
			}else{

				if(empty($jenisAlokasi)){
					$err = "Pilih jenis alokasi";
				}
				if($jenisAlokasi == 'BULANAN'){
					if( $jan == '' || $feb == '' || $mar == '' || $apr == '' || $mei == '' || $jun == '' || $jul == '' || $agu == '' || $sep == '' || $okt == '' || $nop == '' || $des == ''   ){
						$err = "Lengkapi alokasi";
					}
				}
				if($jenisAlokasi == 'TRIWULAN'   ){
					if( $mar == '' ||  $jun == '' ||  $sep == '' ||  $des == ''   ){
						$err = "Lengkapi alokasi";
					}
				}
				if($jumlahHargaAlokasi != $jumlahHarga){
					$err = "Jumlah Alokasi Salah ";
				}

				if($err == ""){
					$getKodeRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$idRekening'"));
					$k = $getKodeRekening['k'];
					$l = $getKodeRekening['l'];
					$m = $getKodeRekening['m'];
					$n = $getKodeRekening['n'];
					$o = $getKodeRekening['o'];
					if(mysql_num_rows(mysql_query("select * from anggaran_kas where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c='$c' and d ='$d' and bk ='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o'  and jenis_rka ='3.2'  and jenis_dpa = 'DPA-SKPD'")) == 0){
						$data = array(
									'c1' => $c1,
									'c' => $c,
									'd' => $d,
									'bk' => $bk,
									'ck' => $ck,
									'dk' => $dk,
									'p' => $p,
									'q' => $q,
									'q' => $q,
									'k' => $k,
									'l' => $l,
									'm' => $m,
									'n' => $n,
									'o' => $o,
									'total' => $jumlahHarga,
									'jenis_alokasi_kas' => $jenisAlokasi,
									"alokasi_jan" => $jan,
									"alokasi_feb" => $feb,
									"alokasi_mar" => $mar,
									"alokasi_apr" => $apr,
									"alokasi_mei" => $mei,
									"alokasi_jun" => $jun,
									"alokasi_jul" => $jul,
									"alokasi_agu" => $agu,
									"alokasi_sep" => $sep,
								    "alokasi_okt" => $okt,
									"alokasi_nop" => $nop,
									"alokasi_des" => $des,
									"jenis_rka" => '3.2',
									"jenis_dpa" => 'DPA-SKPD',
									"tahun" => $this->tahun,
									"jenis_anggaran" => $this->jenisAnggaran
									);
						$cek = VulnWalkerInsert('anggaran_kas',$data);
						mysql_query(VulnWalkerInsert('anggaran_kas',$data));
					}else{
						$grepId = mysql_fetch_array(mysql_query("select * from anggaran_kas where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c='$c' and d ='$d' and bk ='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o'  and jenis_dpa = 'DPA-SKPD' and jenis_rka = '3.2'"));
						$id = $grepId['id'];
						$data = array(
										'jenis_alokasi_kas' => $jenisAlokasi,
										"alokasi_jan" => $jan,
										"alokasi_feb" => $feb,
										"alokasi_mar" => $mar,
										"alokasi_apr" => $apr,
										"alokasi_mei" => $mei,
										"alokasi_jun" => $jun,
										"alokasi_jul" => $jul,
										"alokasi_agu" => $agu,
										"alokasi_sep" => $sep,
									    "alokasi_okt" => $okt,
										"alokasi_nop" => $nop,
										"alokasi_des" => $des,

										);
						$cek = VulnWalkerUpdate('anggaran_kas',$data, "id = '$id' ");
						mysql_query(VulnWalkerUpdate('anggaran_kas',$data, "id = '$id' "));
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

	 }//end switch

		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }
	 function setPage_HeaderOther(){

		 return
		 "<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
		 <tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		 <A href=\"pages.php?Pg=anggaranKasSKPD221\" title='BELANJA' > BELANJA </a> |
		 <A href=\"pages.php?Pg=anggaranKasSKPD1PAD\" title='PENDAPATAN' > PENDAPATAN </a> |
		 <A href=\"pages.php?Pg=anggaranKasSKPD32\" title='PEMBIAYAAN'  style='color:blue;' > PEMBIAYAAN </a>

		 &nbsp&nbsp&nbsp
		 </td></tr>

		 <tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		 <A href=\"pages.php?Pg=anggaranKasSKPD31\" title='PENERIMAAN' > PENERIMAAN </a> |
		 <A href=\"pages.php?Pg=anggaranKasSKPD32\" title='PENGELUARAN' style='color:blue;'  > PENGELUARAN </a>

		 &nbsp&nbsp&nbsp
		 </td></tr>

		 </table>";
 }
   function setPage_OtherScript(){
		$scriptload =
					"<script>
						$(document).ready(function(){
							".$this->Prefix.".loading();
						});
					</script>";
		return
			"
			<script src='js/skpd.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/perencanaan/rka/popupBarang.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/popup_rekening/popupRekening.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/anggaranKas/anggaranKasSKPD32.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaan_v2/dpa/alokasi/alokasiDpaSkpd221.js' language='JavaScript'></script>
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
			$aqry = "SELECT * FROM  tabel_anggaran WHERE id_anggaran='".$this->form_idplh."' "; $cek.=$aqry;
			$dt = mysql_fetch_array(mysql_query($aqry));
			$fm = $this->setForm($dt);
		}

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}
	function Info(){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 100;
	 $this->form_caption = 'INFO ALOKASI DPA-SKPD 3.2';






	 //items ----------------------
	   $this->form_fields = array(
			'listDetailVolume' => array(
						'label'=>'',
						'value'=>"

						<div id='listAlokasiDpaSkpd221'  width=10px></div>",

						'type'=>'merge'
					 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Tutup' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm2();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function setForm($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 700;
	 $this->form_height = 400;
	  if ($this->form_fmST==0) {


	  }else{
		$this->form_caption = 'Edit';
		foreach ($dt as $key => $value) {
			 	 $$key = $value;
		 }
		 $getNamaUrusan = mysql_fetch_array(mysql_query("select concat(c1,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='00' and d='00' and e='00' and e1 = '000'"));
		 $namaUrusan = $getNamaUrusan['nama'];
		 $urusan = "<input type ='hidden' name='c1' id='c1' value = '$c1' > <input type ='text'  value = '$namaUrusan' style='width:400px;' readonly>";

		 $getNamaBidang = mysql_fetch_array(mysql_query("select concat(c,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='00' and e='00' and e1 = '000'"));
		 $namaBidang = $getNamaBidang['nama'];
		 $bidang = "<input type ='hidden' name='c' id='c' value = '$c' > <input type ='text'  value = '$namaBidang' style='width:400px;' readonly>";

		 $getNamaSKPD = mysql_fetch_array(mysql_query("select concat(d,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='$d' and e='00' and e1 = '000'"));
		 $namaSKPD = $getNamaSKPD['nama'];
		 $skpd = "<input type ='hidden' name='d' id='d' value = '$d' > <input type ='text'  value = '$namaSKPD' style='width:400px;' readonly>";

		 $getNamaUnit = mysql_fetch_array(mysql_query("select concat(e,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='$e' and e='$e' and e1 = '000'"));
		 $namaUnit = $getNamaUnit['nama'];
		 $unit = "<input type ='hidden' name='e' id='e' value = '$e' > <input type ='text'  value = '$namaUnit' style='width:400px;' readonly>";

		 $getNamaSubUnit = mysql_fetch_array(mysql_query("select concat(e1,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='$d' and e='$e' and e1 = '$e1'"));
		 $namaSubUnit = $getNamaSubUnit['nama'];
		 $subunit = "<input type ='hidden' name='e1' id='e1' value = '$e1' > <input type ='text'  value = '$namaSubUnit' style='width:400px;' readonly>";

		 $getProgram = mysql_fetch_array(mysql_query("select concat(p,'. ',nama) as nama from ref_program where bk='$bk' and ck='$ck' and dk = '0' and p = '$p' and q= '0'"));
		 $namaProgram = $getProgram['nama'];
		 $program = "<input type ='hidden' name='bk' id='bk' value = '$bk' > <input type ='hidden' name='ck' id='ck' value = '$ck' > <input type ='hidden' name='p' id='p' value = '$p' > <input type ='text'  value = '$namaProgram' style='width:400px;' readonly>";

		 $getKegiatan = mysql_fetch_array(mysql_query("select concat(q,'. ',nama) as nama from ref_program where bk='$bk' and ck='$ck' and dk = '0' and p = '$p' and q= '$q'"));
		 $namaKegiatan = $getKegiatan['nama'];
		 $kegiatan = "<input type ='hidden' name='q' id='q' value = '$q' > <input type ='text'  value = '$namaKegiatan' style='width:400px;' readonly>";

		 $kodeRENJA = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$p.".".$q;
		 $hargaSatuan = $satuan_rek;
		 $kodeBarang = $f.".".$g.".".$h.".".$i.".".$j ;
		 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
		 $namaBarang = $getNamaBarang['nm_barang'];
		 $kodeRekening = $k.".".$l.".".$m.".".$n.".".$o ;
		 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
		 $namaRekening = $getNamaRekening['nm_rekening'];
		 $arrayJenisDPA = array(
						array("3.2","DPA-SKPD 3.2"),
						array("3.2","DPA-SKPD 3.2")

						);
		 $jenis_rka = $jenis_rka;
		 $cmbJenisDPA = cmbArray('cmbJenisDPAForm',$jenis_rka,$arrayJenisDPA,'-- JENIS DPA --','onchange=anggaranKasSKPD32.unlockFindRekening();');
	 	 if(empty($jenis_rka)){
		 	$tergantungJenis = "disabled";
		 }

		 $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
		 $getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));
		 $angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');

		 $formPaguIndikatif  = " <input type='hidden' id='paguIndifkatif' name='paguIndikatif' value='".$getPaguIndikatif['jumlah']."' ><input type='text' value='$angkaPaguIndikatif' readonly >";
	  }



	 //items ----------------------
	  $this->form_fields = array(
	  	  	'kode0' => array(
	  					'label'=>'URUSAN',
						'labelWidth'=>150,
						'value'=> $urusan
						 ),
	  		'kode1' => array(
	  					'label'=>'BIDANG',
						'labelWidth'=>150,
						'value'=> $bidang
						 ),
			'kode2' => array(
						'label'=>'SKPD',
						'labelWidth'=>150,
						'value'=> $skpd
						 ),
			'kode3' => array(
						'label'=>'UNIT',
						'labelWidth'=>150,
						'value'=> $unit
						 ),
			'kode4' => array(
						'label'=>'SUB UNIT',
						'labelWidth'=>150,
						'value'=> $subunit
						 ),
			'kode5' => array(
						'label'=>'PROGRAM',
						'labelWidth'=>150,
						'value'=> "<input type='hidden' name = 'bk' id = 'bk' value='$bk'> <input type='hidden' name = 'ck' id = 'ck' value='$ck'>".$program
						 ),
			'kode6' => array(
						'label'=>'KEGIATAN',
						'labelWidth'=>150,
						'value'=> $kegiatan
						 ),
			'kode12' => array(
						'label'=>'PAGU INDIKATIF',
						'labelWidth'=>150,
						'value'=> $formPaguIndikatif
						 ),
			'kode11' => array(
						'label'=>'JENIS DPA',
						'labelWidth'=>150,
						'value'=> $cmbJenisDPA,
						 ),
			'kode9' => array(
						'label'=>'BARANG',
						'labelWidth'=>150,
						'value'=> "<input type='text' id='kodeBarang' name='kodeBarang' style='width:120px;' readonly value = '$kodeBarang'> &nbsp&nbsp
						 <input type='text' id='namaBarang' name='namaBarang' style='width:300px;' readonly value = '$namaBarang'> "
						 ),
			'kode7' => array(
						'label'=>'REKENING',
						'labelWidth'=>150,
						'value'=> "<input type='text' id='kodeRekening' name='kodeRekening' style='width:120px;' readonly value = '$kodeRekening'> &nbsp&nbsp
						 <input type='text' id='namaRekening' name='namaRekening' style='width:300px;' readonly value = '$namaRekening'>
						 <button type='button' id='findRekening' onclick=anggaranKasSKPD32.findRekening('$jenis_rka'); $tergantungJenis> CARI </button> "
						 ),
			'kode8' => array(
						'label'=>'HARGA SATUAN',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='anggaranKasSKPD32.bantu();' > <span id='bantu' style='color:red;'> </span>"
						 ),


			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >  &nbsp  ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}



	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){


/*		 $arrayResult = VulnWalkerTahap_v2('RKA');
		 $jenisForm = $arrayResult['jenisForm'];
		 $nomorUrut = $arrayResult['nomorUrut'];
		 $tahun = $arrayResult['tahun'];
		 $jenisAnggaran = $arrayResult['jenisAnggaran'];
		 $id_tahap = $arrayResult['id_tahap'];*/

	 	if($this->wajibValidasi == TRUE)$tergantung = "<th class='th01' rowspan='2' width='100' >VALIDASI</th>";
		$headerTable =
		  "<thead>
		   <tr>

		   <th class='th01' width='20'   > </th>
		   <th class='th01' width='100'   >KODE REKENING </th>
		   <th class='th01' width='200'   >URAIAN</th>
		   <th class='th01' width='120'   >ANGGARAN</th>
		   <th class='th01' width='120'  >JANUARI</th>
		   <th class='th01' width='120'  >FEBRUARI</th>
		   <th class='th01' width='120'   >MARET</th>
		   <th class='th01' width='120'   >APRIL</th>
		   <th class='th01' width='120'   >MEI</th>
		   <th class='th01' width='120'   >JUNI</th>
		   <th class='th01' width='120'   >JULI</th>
		   <th class='th01' width='120'  >AGUSTUS</th>
		   <th class='th01' width='120'   >SEPTEMBER</th>
		   <th class='th01' width='120'   >OKTOBER</th>
		   <th class='th01' width='120'  >NOVEMBER</th>
		   <th class='th01' width='120'   >DESEMBER</th>

		   $tergantung

		   </tr>


		   </thead>";


	 $NomorColSpan = $Mode==1? 2: 1;


		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) {
		  			$$key = $value;
	 }
	//  foreach ($_REQUEST as $key => $value) {
	// 	  			$$key = $value;
	//  }

	if(isset($_REQUEST['cmbUrusan']) && $_REQUEST['cmbUrusan']== ''){
		$_REQUEST['cmbBidang'] = "";
		$_REQUEST['cmbSKPD'] = "";
		$_REQUEST['hiddenP'] = "";
		$_REQUEST['cmbUnit'] = "";
		$_REQUEST['cmbSubUnit'] = "";
	 }elseif(isset($_REQUEST['cmbBidang']) && $_REQUEST['cmbBidang']== ''){
		$_REQUEST['cmbSKPD'] = "";
		$_REQUEST['hiddenP'] = "";
		$_REQUEST['cmbUnit'] = "";
		$_REQUEST['cmbSubUnit'] = "";
	 }elseif(isset($_REQUEST['cmbSKPD']) && $_REQUEST['cmbSKPD']== ''){
		$_REQUEST['hiddenP'] = "";
		$_REQUEST['cmbUnit'] = "";
		$_REQUEST['cmbSubUnit'] = "";
	 }elseif(isset($_REQUEST['cmbUnit']) && $_REQUEST['cmbUnit']== ''){
		$_REQUEST['cmbSubUnit'] = "";
	 }

	 if(isset($_REQUEST['hiddenP']) && $_REQUEST['hiddenP'] == ''){
			$_REQUEST['q'] = "";
	 }

	if($_REQUEST['cmbSubUnit'] != ''){
		$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."' and c='".$_REQUEST['cmbBidang']."' and d='".$_REQUEST['cmbSKPD']."' and e='".$_REQUEST['cmbUnit']."' and e1='".$_REQUEST['cmbSubUnit']."'";
	if(!empty($_REQUEST['hiddenP'])){
			$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."' and c='".$_REQUEST['cmbBidang']."' and d='".$_REQUEST['cmbSKPD']."' and e='".$_REQUEST['cmbUnit']."' and e1='".$_REQUEST['cmbSubUnit']."' and bk='".$_REQUEST['bk']."' and ck='".$_REQUEST['ck']."' and dk='".$_REQUEST['dk']."' and p='".$_REQUEST['hiddenP']."'";
				if(!empty($_REQUEST['q'])){
			$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."' and c='".$_REQUEST['cmbBidang']."' and d='".$_REQUEST['cmbSKPD']."' and e='".$_REQUEST['cmbUnit']."' and e1='".$_REQUEST['cmbSubUnit']."' and bk='".$_REQUEST['bk']."' and ck='".$_REQUEST['ck']."' and dk='".$_REQUEST['dk']."' and p='".$_REQUEST['hiddenP']."' and q='".$_REQUEST['q']."'";
	}
	}
	}elseif($_REQUEST['cmbUnit'] != ''){
		$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."' and c='".$_REQUEST['cmbBidang']."' and d='".$_REQUEST['cmbSKPD']."' and e='".$_REQUEST['cmbUnit']."' ";
	}elseif($_REQUEST['cmbSKPD'] != ''){
		$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."' and c='".$_REQUEST['cmbBidang']."' and d='".$_REQUEST['cmbSKPD']."'  ";
	}elseif($_REQUEST['cmbBidang'] != ''){
		$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."' and c='".$_REQUEST['cmbBidang']."'  ";
	}elseif($_REQUEST['cmbUrusan'] != ''){
		$kondisiSKPD = "and c1='".$_REQUEST['cmbUrusan']."'";
	}
	if(!empty($_REQUEST['cmbBelanja'])){
			if($_REQUEST['cmbBelanja'] == "BELANJA PEGAWAI"){
				$kondisiBelanja = "and k='5' and l ='2' and m ='1'";
			}elseif($_REQUEST['cmbBelanja'] == "BELANJA BELANJA BARANG & JASA"){
				$kondisiBelanja = "and k='5' and l ='2' and m ='2'";
			}elseif($_REQUEST['cmbBelanja'] == "BELANJA MODAL"){
				$kondisiBelanja = "and k='5' and l ='2' and m ='3'";
			}

		}



	// if($this->jenisForm == 'PENYUSUNAN'){



	$Koloms = array();

			 $boldStatus = "bold";
			// $marginStatus = "20px;";
			 $kode = $k.".".$l.".".$m.".".$n.".".$o;
			 //$marginKode = "10px;";
			 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
			 $uraianList = $getNamaRekening['nm_rekening'];
			 $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_dpa_3_2 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiRekening"));
			 $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
			 $this->total += $getSumJumlahHarga['sum(jumlah_harga)'];
			 $getDataAnggaranKas = mysql_fetch_array(mysql_query("select * from anggaran_kas where tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and jenis_dpa = 'DPA-SKPD' $kondisiSKPD and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' "));
			 $alokasiJanuari = $getDataAnggaranKas['alokasi_jan'];
			 $alokasiFebruari= $getDataAnggaranKas['alokasi_feb'];
			 $alokasiMaret = $getDataAnggaranKas['alokasi_mar'];
			 $alokasiApril = $getDataAnggaranKas['alokasi_apr'];
			 $alokasiMei = $getDataAnggaranKas['alokasi_mei'];
			 $alokasiJuni = $getDataAnggaranKas['alokasi_jun'];
			 $alokasiJuli = $getDataAnggaranKas['alokasi_jul'];
			 $alokasiAgustus = $getDataAnggaranKas['alokasi_agu'];
			 $alokasiSeptember = $getDataAnggaranKas['alokasi_sep'];
			 $alokasiOktober = $getDataAnggaranKas['alokasi_okt'];
			 $alokasiNopember = $getDataAnggaranKas['alokasi_nop'];
			 $alokasiDesember = $getDataAnggaranKas['alokasi_des'];
			 $this->totalJan += $alokasiJanuari;
			 $this->totalFeb += $alokasiFebruari;
			 $this->totalMar += $alokasiMaret;
			 $this->totalApr += $alokasiApril;
			 $this->totalMei += $alokasiMei;
			 $this->totalJun += $alokasiJuni;
			 $this->totalJul += $alokasiJuli;
			 $this->totalAgu += $alokasiAgustus;
			 $this->totalSep += $alokasiSeptember;
			 $this->totalOkt += $alokasiOktober;
			 $this->totalNop += $alokasiNopember;
			 $this->totalDes += $alokasiDesember;


	$Koloms[] = array(' align="left"', $TampilCheckBox );
	$Koloms[] = array(' align="left"', "<span style='color:$warnaMapping;margin-left:$marginKode;'>$kode</span>" );
	$Koloms[] = array(' align="left"', "<span style='font-weight:$boldStatus;margin-left:$marginStatus'>$uraianList</span> <div style='float:right'>".$isi['rincian_volume']."</div>" );
	$Koloms[] = array(' align="right"',  "<span style='font-weight:$boldStatus;'>$jumlahHarga </span>" );



	$Koloms[] = array(' align="right"', number_format($alokasiJanuari,2,',','.') );
	$Koloms[] = array(' align="right"', number_format($alokasiFebruari ,2,',','.') );
	$Koloms[] = array(' align="right"', number_format($alokasiMaret ,2,',','.') );
	$Koloms[] = array(' align="right"', number_format($alokasiApril ,2,',','.') );
	$Koloms[] = array(' align="right"', number_format($alokasiMei,2,',','.') );
	$Koloms[] = array(' align="right"', number_format($alokasiJuni ,2,',','.') );
	$Koloms[] = array(' align="right"', number_format($alokasiJuli ,2,',','.') );
	$Koloms[] = array(' align="right"', number_format($alokasiAgustus ,2,',','.') );
	$Koloms[] = array(' align="right"', number_format($alokasiSeptember ,2,',','.') );
	$Koloms[] = array(' align="right"', number_format($alokasiOktober ,2,',','.') );
	$Koloms[] = array(' align="right"', number_format($alokasiNopember ,2,',','.') );
	$Koloms[] = array(' align="right"', number_format($alokasiDesember ,2,',','.') );
			 //$Koloms[] = array(' align="right"', $catatan );


			// if(!empty($cmbSKPD) && empty($cmbUnit)){
			// 	if(in_array($id_anggaran, $this->publicExcept)) {
			//
			// 	}elseif($j != '000' && mysql_num_rows(mysql_query("select * from view_rka_2_1 where concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',k,'.',l,'.',m,'.',n,'.',o,'.',catatan,'.',id_jenis_pemeliharaan) = '$grubId' and id_tahap = '$this->idTahap' ")) > 1 ){
			// 		$Koloms = array();
			// 	}
			// }







	// }

	 return $Koloms;
	}



	function Validasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI DPA-SKPD 3.2';
	 $kode = $dt['c1'].".".$dt['c'].".".$dt['d'];
	  if ($dt['status_validasi'] == '1') {
	  	//2017-03-30 17:12:16
		// $tglvalidnya = $dt['tgl_validasi'];
		// $thn1 = substr($tglvalidnya,0,4);
		// $bln1 = substr($tglvalidnya,5,2);
		// $tgl1 = substr($tglvalidnya,8,2);
		// $jam1 = substr($tglvalidnya,11,8);
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
						'label'=>'KODE anggaranKasSKPD32',
						'labelWidth'=>100,
						'value'=>$kode,
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
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
						'param'=>"style='width:250px;' readonly"
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

	function Catatan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'CATATAN';
	 $catatan = $dt['catatan'];
	 $idnya = $dt['id_anggaran'];

	 //items ----------------------
	  $this->form_fields = array(
			'catatan' => array(
						'label'=>'CATATAN',
						'labelWidth'=>100,
						'value'=>"<textarea id='catatan' name='catatan' style='width:100%; height : 100px;'>".$catatan."</textarea>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveCatatan($idnya)' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function genDaftarOpsi(){
	 global $Ref, $Main;


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

	$selectedC1 = $_REQUEST['cmbUrusan'];
	$selectedC  = $_REQUEST['cmbBidang'];
	$selectedD = $_REQUEST['cmbSKPD'];
	$selectedE = $_REQUEST['cmbUnit'];
	$selectedE1 = $_REQUEST['cmbSubUnit'];




	if(!isset($selectedC1) ){
	      $arrayData = mysql_fetch_array(mysql_query("select * from current_filter where username ='".$_COOKIE['coID']."'"));
	    foreach ($arrayData as $key => $value) {
	      $$key = $value;
	     }
	     if($CurrentQ !='' ){
	      $_REQUEST['p'] = $CurrentBK.".".$CurrentCK.".".$CurrentDK.".".$CurrentP;
	      $_REQUEST['q'] =  $CurrentQ;
	      $selectedE1 = $CurrentSubUnit;
	      $selectedE = $CurrentUnit;
	      $selectedD = $CurrentSKPD;
	      $selectedC = $CurrentBidang;
	      $selectedC1 = $CurrentUrusan;

	    }elseif($CurrentP !='' ){
	      $_REQUEST['p'] = $CurrentBK.".".$CurrentCK.".".$CurrentDK.".".$CurrentP;
	      $selectedE1 = $CurrentSubUnit;
	      $selectedE = $CurrentUnit;
	      $selectedD = $CurrentSKPD;
	      $selectedC = $CurrentBidang;
	      $selectedC1 = $CurrentUrusan;

	    }elseif($CurrentSubUnit !='000' ){
	      $selectedE1 = $CurrentSubUnit;
	      $selectedE = $CurrentUnit;
	      $selectedD = $CurrentSKPD;
	      $selectedC = $CurrentBidang;
	      $selectedC1 = $CurrentUrusan;

	    }elseif($CurrentUnit !='00' ){
	      $selectedE = $CurrentUnit;
	      $selectedD = $CurrentSKPD;
	      $selectedC = $CurrentBidang;
	      $selectedC1 = $CurrentUrusan;

	    }elseif($CurrentSKPD !='00' ){
	      $selectedD = $CurrentSKPD;
	      $selectedC = $CurrentBidang;
	      $selectedC1 = $CurrentUrusan;

	    }elseif($CurrentBidang !='00'){
	      $selectedC = $CurrentBidang;
	      $selectedC1 = $CurrentUrusan;

	    }elseif($CurrentUrusan !='0'){
	      $selectedC1 = $CurrentUrusan;
	    }
	   }

	$arrayProgram = explode(".",$_REQUEST['p']);
	$selectedBK = $arrayProgram[0];
	$selectedCK = $arrayProgram[1];
	$selectedDK = $arrayProgram[2];
	$selectedP = $arrayProgram[3];
	$selectedQ = $_REQUEST['q'];

	foreach ($_COOKIE as $key => $value) {
	        $$key = $value;
	    }


	  if($VulnWalkerSubUnit != '000'){
	    $selectedE1 = $VulnWalkerSubUnit;
	    $selectedE = $VulnWalkerUnit;
	    $selectedD = $VulnWalkerSKPD;
	    $selectedC = $VulnWalkerBidang;
	    $selectedC1 = $VulnWalkerUrusan;
	  }elseif($VulnWalkerUnit != '00'){
	    $selectedE = $VulnWalkerUnit;
	    $selectedD = $VulnWalkerSKPD;
	    $selectedC = $VulnWalkerBidang;
	    $selectedC1 = $VulnWalkerUrusan;
	  }elseif($VulnWalkerSKPD != '00'){
	    $selectedD = $VulnWalkerSKPD;
	    $selectedC = $VulnWalkerBidang;
	    $selectedC1 = $VulnWalkerUrusan;
	  }elseif($VulnWalkerBidang != '00'){
	    $selectedC = $VulnWalkerBidang;
	    $selectedC1 = $VulnWalkerUrusan;
	  }elseif($VulnWalkerUrusan != '0'){
	    $selectedC1 = $VulnWalkerUrusan;
	  }



	  $codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) from ref_skpd where c='00' and d='00' and e='00' and e1='000' ";
	  $urusan = cmbQuery('cmbUrusan',$selectedC1,$codeAndNameUrusan,'onchange=anggaranKasSKPD32.refreshList(true);','-- URUSAN --');

	  $codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c !='00' and d='00' and e='00' and e1='000' ";
	  $bidang = cmbQuery('cmbBidang',$selectedC,$codeAndNameBidang,'onchange=anggaranKasSKPD32.refreshList(true);','-- BIDANG --');

	  $codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d!='00' and e='00' and e1='000' ";
	  $skpd= cmbQuery('cmbSKPD',$selectedD,$codeAndNameSKPD,'onchange=anggaranKasSKPD32.refreshList(true);','-- SKPD --');




	$TampilOpt =
	    "<div class='FilterBar' style='margin-top:5px;'>".
	    "<table style='width:100%'>
	    <tr>
	    <td>URUSAN </td>
	    <td>:</td>
	    <td style='width:86%;'>
	    ".$urusan."
	    </td>
	    </tr>
	    <tr>
	    <td>BIDANG</td>
	    <td>:</td>
	    <td style='width:86%;'>
	    ".$bidang."
	    </td>
	    </tr>
	    <tr>
	    <td>SKPD</td>
	    <td>:</td>
	    <td style='width:86%;'>
	    ".$skpd."
	    </td>
	    </tr>





	    </table>".
	    "</div>"
			// <tr>
	    // <td>UNIT</td>
	    // <td>:</td>
	    // <td style='width:86%;'>
	    // ".$unit."&nbsp&nbsp SUB UNIT &nbsp".$subunit."
	    // </td>
	    // </tr>
	    ;

	  return array('TampilOpt'=>$TampilOpt);


	}

	function getDaftarOpsi($Mode=1){
	  global $Main, $HTTP_COOKIE_VARS;
	  $UID = $_COOKIE['coID'];
	  //kondisi -----------------------------------
	  $nomorUrutSebelumnya = $this->nomorUrut - 1;
	  $arrKondisi = array();
	  $arrKondisi[] = ' 1 = 1';
	  $fmPILCARI = $_REQUEST['fmPILCARI'];
	  $fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
	  //cari tgl,bln,thn


	  $cmbJenisRKA = $_REQUEST['cmbJenisRKA'];

	  foreach ($_REQUEST as $key => $value) {
	        $$key = $value;
	     }
	  if(isset($q)){
	    $data = array("CurrentUrusan" => $cmbUrusan,
	          "CurrentBidang" => $cmbBidang,
	          "CurrentSKPD" => $cmbSKPD,
	           "CurrentUnit" => $cmbUnit,
	            "CurrentSubUnit" => $cmbSubUnit,
	          "CurrentBK" => $bk,
	          "CurrentCK" => $ck,
	          "CurrentDK" => $dk,
	          "CurrentP" => $hiddenP,
	          "CurrentQ" => $q,

	          );
	  }elseif(isset($hiddenP)){
	    $data = array("CurrentUrusan" => $cmbUrusan,
	          "CurrentBidang" => $cmbBidang,
	          "CurrentSKPD" => $cmbSKPD,
	           "CurrentUnit" => $cmbUnit,
	            "CurrentSubUnit" => $cmbSubUnit,
	          "CurrentBK" => $bk,
	          "CurrentCK" => $ck,
	          "CurrentDK" => $dk,
	          "CurrentP" => $hiddenP,

	          );
	  }elseif(isset($cmbSubUnit)){
	    $data = array("CurrentUrusan" => $cmbUrusan,
	          "CurrentBidang" => $cmbBidang,
	          "CurrentSKPD" => $cmbSKPD,
	           "CurrentUnit" => $cmbUnit,
	            "CurrentSubUnit" => $cmbSubUnit,

	          );
	  }elseif(isset($cmbUnit)){
	    $data = array("CurrentUrusan" => $cmbUrusan,
	          "CurrentBidang" => $cmbBidang,
	          "CurrentSKPD" => $cmbSKPD,
	           "CurrentUnit" => $cmbUnit,

	          );
	  }elseif(isset($cmbSKPD)){
	    $data = array("CurrentUrusan" => $cmbUrusan,
	          "CurrentBidang" => $cmbBidang,
	          "CurrentSKPD" => $cmbSKPD,

	          );
	  }elseif(isset($cmbBidang)){
	    $data = array("CurrentUrusan" => $cmbUrusan,
	          "CurrentBidang" => $cmbBidang,

	          );
	  }elseif(isset($cmbUrusan)){
	    $data = array("CurrentUrusan" => $cmbUrusan

	     );
	  }

	  mysql_query(VulnWalkerUpdate("current_filter",$data,"username='$this->username'"));

	  if(!isset($cmbUrusan) ){
	      $arrayData = mysql_fetch_array(mysql_query("select * from current_filter where username ='".$_COOKIE['coID']."'"));
	    foreach ($arrayData as $key => $value) {
	      $$key = $value;
	     }
	     if($CurrentQ !='' ){
	      $_REQUEST['q'] = $CurrentQ;
	      $_REQUEST['hiddenP'] = $CurrentP;
	      $_REQUEST['bk'] = $CurrentBK;
	      $_REQUEST['ck'] = $CurrentCK;
	      $_REQUEST['dk'] = $CurrentDK;
	      $selectedQ =  $CurrentQ;
	      $cmbSubUnit = $CurrentSubUnit;
	      $cmbUnit = $CurrentUnit;
	      $cmbSKPD = $CurrentSKPD;
	      $cmbBidang = $CurrentBidang;
	      $cmbUrusan = $CurrentUrusan;

	    }elseif($CurrentP !='' ){
	      $_REQUEST['hiddenP'] = $CurrentP;
	      $_REQUEST['bk'] = $CurrentBK;
	      $_REQUEST['ck'] = $CurrentCK;
	      $_REQUEST['dk'] = $CurrentDK;
	      $cmbSubUnit = $CurrentSubUnit;
	      $cmbUnit = $CurrentUnit;
	      $cmbSKPD = $CurrentSKPD;
	      $cmbBidang = $CurrentBidang;
	      $cmbUrusan = $CurrentUrusan;

	    }elseif($CurrentSubUnit !='000' ){
	      $cmbSubUnit = $CurrentSubUnit;
	      $cmbUnit = $CurrentUnit;
	      $cmbSKPD = $CurrentSKPD;
	      $cmbBidang = $CurrentBidang;
	      $cmbUrusan = $CurrentUrusan;

	    }elseif($CurrentUnit !='00' ){
	      $cmbUnit = $CurrentUnit;
	      $cmbSKPD = $CurrentSKPD;
	      $cmbBidang = $CurrentBidang;
	      $cmbUrusan = $CurrentUrusan;

	    }elseif($CurrentSKPD !='00' ){
	      $cmbSKPD = $CurrentSKPD;
	      $cmbBidang = $CurrentBidang;
	      $cmbUrusan = $CurrentUrusan;

	    }elseif($CurrentBidang !='00'){
	      $cmbBidang = $CurrentBidang;
	      $cmbUrusan = $CurrentUrusan;

	    }elseif($CurrentUrusan !='0'){
	      $cmbUrusan = $CurrentUrusan;
	    }
	   }

	   if(isset($cmbUrusan) && $cmbUrusan== ''){
	      $cmbBidang = "";
	    $cmbSKPD = "";
	    $hiddenP = "";
	    $cmbUnit = "";
	    $cmbSubUnit = "";
	   }elseif(isset($cmbBidang) && $cmbBidang== ''){
	    $cmbSKPD = "";
	    $hiddenP = "";
	    $cmbUnit = "";
	    $cmbSubUnit = "";
	   }elseif(isset($cmbSKPD) && $cmbSKPD== ''){
	    $hiddenP = "";
	    $cmbUnit = "";
	    $cmbSubUnit = "";
	    if(isset($hiddenP) && $hiddenP == ''){
	          $q = "";
	     }
	   }elseif(isset($cmbUnit) && $cmbUnit== ''){
	    $cmbSubUnit = "";
	   }




	   if($cmbSubUnit != ''){
	    // $arrKondisi[] = "c1 = '$cmbUrusan'";
	    // $arrKondisi[] = "c = '$cmbBidang'";
	    // $arrKondisi[] = "d = '$cmbSKPD'";
	    // $arrKondisi[] = "e = '$cmbUnit'";
	    // $arrKondisi[] = "e1 = '$cmbSubUnit'";
	    $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
	    if(!empty($hiddenP)){
	        $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' $kondisiRekening";

	        // $arrKondisi[] = "ck = '$ck' ";
	        // $arrKondisi[] = "bk = '$bk' ";
	        // $arrKondisi[] = "dk = '$dk' ";
	        // $arrKondisi[] = " p = '$hiddenP'  ";
	        if(!empty($q)){
	          $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q= '$q' $kondisiRekening";
	          //$arrKondisi[] = "q = '$q' ";
	        }
	    }
	    }elseif($cmbUnit != ''){
	      // $arrKondisi[] = "c1 = '$cmbUrusan'";
	      // $arrKondisi[] = "c = '$cmbBidang'";
	      // $arrKondisi[] = "d = '$cmbSKPD'";
	      // $arrKondisi[] = "e = '$cmbUnit'";
	      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
	      if(!empty($hiddenP)){
	        $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' $kondisiRekening";

	        // $arrKondisi[] = "ck = '$ck' ";
	        // $arrKondisi[] = "bk = '$bk' ";
	        // $arrKondisi[] = "dk = '$dk' ";
	        // $arrKondisi[] = " p = '$hiddenP'  ";
	        if(!empty($q)){
	          $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q= '$q' $kondisiRekening";
	          //$arrKondisi[] = "q = '$q' ";
	        }
	    }
	    }elseif($cmbSKPD != ''){
	      // $arrKondisi[] = "c1 = '$cmbUrusan'";
	      // $arrKondisi[] = "c = '$cmbBidang'";
	      // $arrKondisi[] = "d = '$cmbSKPD'";
	      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
	      if(!empty($hiddenP)){
	        $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' $kondisiRekening";
	        if(!empty($cmbUnit)){
	          $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' $kondisiRekening";
	          if(!empty($cmbSubUnit)){
	            $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' $kondisiRekening";


	          }
	        }
	        // $arrKondisi[] = "ck = '$ck' ";
	        // $arrKondisi[] = "bk = '$bk' ";
	        // $arrKondisi[] = "dk = '$dk' ";
	        // $arrKondisi[] = " p = '$hiddenP'  ";
	  if(!empty($q)){
	        $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q='$q' $kondisiRekening";
	        if(!empty($cmbUnit)){
	          $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q='$q' $kondisiRekening";
	          if(!empty($cmbSubUnit)){
	            $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q='$q' $kondisiRekening";
	          }
	        }
	        //$arrKondisi[] = "q = '$q' ";
	      }
	  }
	    }elseif($cmbBidang != ''){
	      // $arrKondisi[] = "c1 = '$cmbUrusan'";
	      // $arrKondisi[] = "c = '$cmbBidang'";
	      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
	    }elseif($cmbUrusan != ''){
	      // $arrKondisi[] = "c1 = '$cmbUrusan'";
	      $kondisiSKPD = "and c1='$cmbUrusan'";
	    }
	    if(!empty($cmbBelanja)){
	      if($cmbBelanja == "BELANJA PEGAWAI"){
	        // $arrKondisi[] = "k = '5'";
	        // $arrKondisi[] = "l = '2'";
	        // $arrKondisi[] = "m = '1'";
	        $kondisiRekening = " and k='5' and l ='2' and m ='1'";
	      }elseif($cmbBelanja == "BELANJA BELANJA BARANG & JASA"){
	        // $arrKondisi[] = "k = '5'";
	        // $arrKondisi[] = "l = '2'";
	        // $arrKondisi[] = "m = '2'";
	        $kondisiRekening = " and k='5' and l ='2' and m ='2'";
	      }elseif($cmbBelanja == "BELANJA MODAL"){
	        // $arrKondisi[] = "k = '5'";
	        // $arrKondisi[] = "l = '2'";
	        // $arrKondisi[] = "m = '3'";
	        $kondisiRekening = " and k='5' and l ='2' and m ='3'";
	      }

	    }

	  $bk = $_REQUEST['bk'];
	  $ck= $_REQUEST['ck'];
	  $dk= $_REQUEST['dk'];
	  $hiddenP = $_REQUEST['hiddenP'];
	  $q = $_REQUEST['q'];
	  $hublaBK = $_REQUEST['bk'];
	  $hublaCK = $_REQUEST['ck'];
	  $hublaDK = $_REQUEST['dk'];
	  $hublaP = $_REQUEST['hiddenP'];
	  $hublaQ = $_REQUEST['q'];




	  $blackListRekening = array();
	  $getAllRekening =  mysql_query("select * from view_dpa_3_2 where id_tahap ='$this->idTahap' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
	  while($rekeningBelanja = mysql_fetch_array($getAllRekening)){
	      if(mysql_num_rows(mysql_query("select  * from view_dpa_3_2 where id_tahap = '$this->idTahap' $kondisiSKPD and bk = '".$rekeningBelanja['bk']."' and ck = '".$rekeningBelanja['ck']."' and dk = '".$rekeningBelanja['dk']."' and p = '".$rekeningBelanja['p']."' and q = '".$rekeningBelanja['q']."' and k = '".$rekeningBelanja['k']."' and l = '".$rekeningBelanja['l']."'  and m = '".$rekeningBelanja['m']."'  and n = '".$rekeningBelanja['n']."' and o = '".$rekeningBelanja['o']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
	          $blackListRekening[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
	          $arrKondisi[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
	      }
	  }











		$arrKondisi[] = "id_rincian_belanja = ''";
		$arrKondisi[] = "rincian_perhitungan = ''";
	  $arrKondisi[] = "id_tahap = '$this->idTahap' ";
	  $arrKondisi[] = "tahun = '$this->tahun'";
	  $arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
	  $Kondisi= join(' and ',$arrKondisi);
	  $Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi ;
	  $this->publicKondisi = $Kondisi;

	  //Order -------------------------------------
	  $fmORDER1 = cekPOST('fmORDER1');
	  $fmDESC1 = cekPOST('fmDESC1');
	  $Asc1 = $fmDESC1 ==''? '': 'desc';
	  $arrOrders = array();
	  $arrOrders[] = "urut, rincian_perhitungan  asc";
	  $Order= join(',',$arrOrders);
	  $OrderDefault = '';
	  $Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;

	  return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal );

	}
	function Hapus($ids){ //validasi hapus ref_kota
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++)	{


			$qy = "DELETE FROM $this->TblName_Hapus WHERE id_anggaran='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);

		}
		return array('err'=>$err,'cek'=>$cek);
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

		"<html>".
			$this->genHTMLHead().
			"<body >".

			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0'  height='100%' >".
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
		</html>
		<style>
			#kerangkaHal {
						width:$tergantung%;
			}

		</style>
		";
	}
function Laporan($xls =FALSE){
		global $Main;



		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}




		$grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_dpa_2_1 where username='$this->username'"));
		foreach ($grabSKPD as $key => $value) {
				  $$key = $value;
			}
		$cmbUrusan = $c1;
		$cmbBidang = $c;
		$cmbSKPD = $d;
		$cmbUnit = $e;
		$cmbSubUnit = $e1;
		$hiddenP = $p;
		$hublaQ = $q;
		$hublaBK = $bk;
		$hublaCK = $ck;
		$hublaP = $p;
		$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and bk='$bk' and ck='$ck' and p='$hiddenP' and q='$q'";
		$arrKondisi[] = "c1 = '$cmbUrusan'";
					$arrKondisi[] = "c = '$cmbBidang'";
					$arrKondisi[] = "d = '$cmbSKPD'";
					$arrKondisi[] = "ck = '$ck' ";
					$arrKondisi[] = "bk = '$bk' ";
					$arrKondisi[] = " p = '$hiddenP'  ";


  		$arrKondisi[] = "c1 != '0'";
			$getMaxIdTahapDPA= mysql_fetch_array(mysql_query("select max(id_tahap) from view_dpa_3_2 where tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'"));
			$idTahap = $getMaxIdTahapDPA['max(id_tahap)'];

			$getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut ='$this->urutTerakhir' and tahun ='$this->tahun' and anggaran='$this->jenisAnggaran'"));
				$idTahap = $getIDTahap['id_tahap'];
				$getAllParent = mysql_query("select * from view_dpa_3_2 where id_tahap ='$idTahap'  and o1 !='0' and k='0' and n='0' and j='000'  ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekPekerjaan = mysql_num_rows(mysql_query("select * from view_dpa_3_2 where o1 = '$o1' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
					if($cekPekerjaan == 0){
						$arrKondisi[] = "o1 !='$o1'";
					}else{
						$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran' ";
						$getAllRekening = mysql_query("select * from view_dpa_3_2 where id_tahap = '$idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
						while($row2s = mysql_fetch_array($getAllRekening)){
							foreach ($row2s as $key => $value) {
						 	 $$key = $value;
							}
							$cekRekening = mysql_num_rows(mysql_query("select * from view_dpa_3_2 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
							if($cekRekening == 0){
								$concat = $k.".".$l.".".$m.".".$n.".".$o;
								$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
							}else{
								$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'  ";
								$getAllProgram = mysql_query("select * from view_dpa_3_2 where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
								while($row3s = mysql_fetch_array($getAllProgram)){
									foreach ($row3s as $key => $value) {
								 	 $$key = $value;
									}
									$cekProgram = mysql_num_rows(mysql_query("select * from view_dpa_3_2 where bk ='$bk' and ck='$ck' and p='$p' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
									if($cekProgram == 0){
										$concat = $bk.".".$ck.".".$p;
										$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
									}else{
										$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'   ";
										$getAllKegiatan = mysql_query("select * from view_dpa_3_2 where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
										while($row4s = mysql_fetch_array($getAllKegiatan)){
											foreach ($row4s as $key => $value) {
										 	 $$key = $value;
											}
											$cekKegiatan = mysql_num_rows(mysql_query("select * from view_dpa_3_2 where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
											if($cekKegiatan == 0){
												$concat = $bk.".".$ck.".".$p;
												$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
											}else{
												$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'   ";


											}
										}

									}
								}

							}
						}
					}
				}


				$grabNonMapingRekening= mysql_query("select * from view_dpa_3_2 where id_tahap ='$idTahap' and (LENGTH(k) > 1) and j='000'");
				while($got = mysql_fetch_array($grabNonMapingRekening)){
					if(mysql_num_rows(mysql_query("select * from view_dpa_3_2 where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and ( rincian_perhitungan !='' or  j!='000' ) $kondisiRekening $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}

				}

				$grabNonHostedRekening= mysql_query("select * from view_dpa_3_2 where id_tahap ='$idTahap' and (LENGTH(k) = 1 and k !='0') and j='000'");
				while($got = mysql_fetch_array($grabNonHostedRekening)){
					if(mysql_num_rows(mysql_query("select * from view_dpa_3_2 where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and ( rincian_perhitungan !='' or  j!='000' ) $kondisiRekening $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}

				}



				$arrKondisi[] = "id_tahap = '$idTahap' ";





		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";

		$Kondisi= join(' and ',$arrKondisi);
		/*if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}*/
		$qry ="select * from view_dpa_3_2 where $Kondisi ";
		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];


		//Get Id Awal Renja

		$getIdRenja = mysql_fetch_array(mysql_query("select min(id_anggaran) from view_renja where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and bk='$hublaBK' and ck='$hublaCK' and p='$hiddenP' and q='$hublaQ' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		$idRenja = $getIdRenja['min(id_anggaran)'];
		$getDetailRenja = mysql_fetch_array(mysql_query("select * from detail_renja where id_anggaran = '$idRenja'"));
		$getUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$cmbUrusan' and c='00'"));
		$urusan = $getUrusan['nm_skpd'];
		$getBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='00'"));
		$bidang = $getBidang['nm_skpd'];
		$getSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='00'"));
		$skpd = $getSKPD['nm_skpd'];
		$getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' "));
		$subUnit = $getSubUnit['nm_skpd'];
		$getProgram = mysql_fetch_array(mysql_query("select * from ref_program where bk='$hublaBK' and ck='$hublaCK' and dk='0' and p='$hublaP' and q='0'"));
		$program = $getProgram['nama'];
		$getKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$hublaBK' and ck='$hublaCK' and dk='0' and p='$hublaP' and q='$hublaQ'"));
		$kegiatan = $getKegiatan['nama'];


		//

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
					RINCIAN DOKUMEN PELAKSANAAN ANGGARAN<br>
					SATUAN KERJA PERANGKAT DAERAH
				</span><br>
				<span style='font-size:14px;font-weight:text-decoration: '>
					PROVINSI/Kabupaten/Kota $this->kota<br>
					Tahun Anggaran $this->tahun
					<br>
				</span><br>
				<table width=\"100%\" border=\"0\" class='subjudulcetak'>
					<tr>
						<td width='15%' valign='top'>URUSAN PEMERINTAHAN</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.". </td>
						<td valign='top'>$urusan</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>BIDANG</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.".".$cmbBidang.". </td>
						<td valign='top'>$bidang</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SKPD</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.".".$cmbBidang.".".$cmbSKPD.". </td>
						<td valign='top'>$skpd</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>PROGRAM</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.".".$cmbBidang.".".$cmbSKPD.genNumber($hublaBK).genNumber($hublaCK).genNumber($hublaP).".  </td>
						<td valign='top'>$program</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>KEGIATAN</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.".".$cmbBidang.".".$cmbSKPD.genNumber($hublaBK).genNumber($hublaCK).genNumber($hublaP).".".genNumber($hublaQ)." </td>
						<td valign='top'>$kegiatan</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>LOKASI KEGIATAN</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top' colspan='2'>".$getDetailRenja['lokasi_kegiatan']."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>JUMLAH TAHUN n - 1</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top' colspan='2'> Rp. ".number_format($getDetailRenja['min'],2,',','.')."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>JUMLAH PAGU INDIKATIF</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top' colspan='2'> Rp. ".number_format($getDetailRenja['pagu_indikatif'],2,',','.')."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>JUMLAH TAHUN n + 1</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top' colspan='2'> Rp. ".number_format($getDetailRenja['plus'],2,',','.')."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>KELOMPOK SASARAN KEGIATAN</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top' colspan='2'>".$getDetailRenja['kelompok_sasaran_kegiatan']."</td>
					</tr>


				</table>

				<br>
				<span style='font-size:16px;font-weight:bold;text-decoration: '>
					Indikator & Tolak Ukur Kinerja BELANJA TIDAK LANGSUNG
				</span><br>
				<table width='100%' border='1' class='cetak' style='margin:4 0 0 0;width:100%;'>
					<tr>
						<th class='th01' width = '200' >INDIKATOR</th>
						<th class='th01' >Tolak Ukur Kinerja</th>
						<th class='th01' >Target Kinerja</th>
					</tr>
					<tr>
						<td  valign='top' class = 'GarisCetak'>CAPAIAN PROGRAM</td>
						<td  valign='top' class = 'GarisCetak'>".$getDetailRenja['capaian_program_tuk']."</td>
						<td  valign='top' class = 'GarisCetak'>".$getDetailRenja['capaian_program_tk']."</td>
					</tr>
					<tr>
						<td  valign='top' class = 'GarisCetak'>MASUKAN</td>
						<td  valign='top' class = 'GarisCetak'>".$getDetailRenja['masuk_tuk']."</td>
						<td  valign='top' class = 'GarisCetak'>".$getDetailRenja['masuk_tk']."</td>
					</tr>
					<tr>
						<td  valign='top' class = 'GarisCetak'>KELUARAN</td>
						<td  valign='top' class = 'GarisCetak'>".$getDetailRenja['keluaran_tuk']."</td>
						<td  valign='top' class = 'GarisCetak'>".$getDetailRenja['keluaran_tk']."</td>
					</tr>
					<tr>
						<td valign='top' class = 'GarisCetak'>HASIL</td>
						<td  valign='top' class = 'GarisCetak'>".$getDetailRenja['hasil_tuk']."</td>
						<td  valign='top' class = 'GarisCetak'>".$getDetailRenja['hasil_tk']."</td>
					</tr>


				</table>
				<br>
				";
		echo "
				<span style='font-size:16px;font-weight:bold;text-decoration: '>
					Rincian Dokumen Pelaksanaan Anggaran BELANJA TIDAK LANGSUNG <br>
					Program dan Per Kegiatan Satuan Kerja Perangkat Daerah
				</span><br>
								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
										<th class='th01' rowspan='2' colspan='5' >KODE REKENING</th>
										<th class='th01' rowspan='2' >URAIAN</th>
										<th class='th02' rowspan='1' colspan='3' >Rincian Perhitungan</th>
										<th class='th01' rowspan='2' >JUMLAH (Rp)</th>

									</tr>
									<tr>
										<th class='th01' >VOLUME</th>
										<th class='th01' >SATUAN</th>
										<th class='th01' >HARGA SATUAN</th>
									</tr>


		";
		$getTotal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_dpa_3_2 where $Kondisi  "));
		$total = number_format($getTotal['sum(jumlah_harga)'],2,',','.');
		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
			}

			$grabWihtCondition = mysql_query("select * from view_dpa_3_2 where $Kondisi group by c1,c,d,bk,ck,p,q,k,l,m,n,o,catatan,id_jenis_pemeliharaan");
				while($rows = mysql_fetch_array($grabWihtCondition)){
					if(mysql_num_rows(mysql_query("select * from view_dpa_3_2 where id_tahap ='$idTahap' and c1 = '".$rows['c1']."' and c='".$rows['c']."' and d='".$rows['d']."' and bk = '".$rows['bk']."' and ck ='".$rows['ck']."' and p='".$rows['p']."' and q='".$rows['q']."' and f='".$rows['f']."' and g='".$rows['g']."' and h ='".$rows['h']."' and i ='".$rows['i']."' and j ='".$rows['j']."' and k='".$rows['k']."' and l = '".$rows['l']."' and m = ".$rows['m']." and n ='".$rows['n']."' and o='".$rows['o']."' and catatan = '".$rows['catatan']."' and id_jenis_pemeliharaan = '".$rows['id_jenis_pemeliharaan']."' ")) >= 2 && $rows['j'] !='000'){
						$this->publicExcept[] = $rows['id_anggaran'];
						$this->publicGrupId[] = $rows['c1'].".".$rows['c'].".".$rows['d'].".".$rows['bk'].".".$rows['ck'].".".$rows['p'].".".$rows['q'].".".$rows['f'].".".$rows['g'].".".$rows['h'].".".$rows['i'].".".$rows['j'].".".$rows['k'].".".$rows['l'].".".$rows['m'].".".$rows['n'].".".$rows['o'].".".$rows['catatan'].".".$rows['id_jenis_pemeliharaan'];
					}
				}


			 	$grubId = $daqry['c1'].".".$daqry['c'].".".$daqry['d'].".".$daqry['bk'].".".$daqry['ck'].".".$daqry['p'].".".$daqry['q'].".".$daqry['f'].".".$daqry['g'].".".$daqry['h'].".".$daqry['i'].".".$daqry['j'].".".$daqry['k'].".".$daqry['l'].".".$daqry['m'].".".$daqry['n'].".".$daqry['o'].".".$daqry['catatan'].".".$daqry['id_jenis_pemeliharaan'];
			 	if(in_array($grubId, $this->publicGrupId)) {
					    $jumlah_harga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_dpa_3_2 where concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',k,'.',l,'.',m,'.',n,'.',o,'.',catatan,'.',id_jenis_pemeliharaan) = '$grubId' and id_tahap = '$idTahap' "));
				 		$jumlah_harga= $jumlah_harga['sum(jumlah_harga)'];
						$volume_rek  = mysql_fetch_array(mysql_query("select sum(volume_rek) from view_dpa_3_2 where concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',k,'.',l,'.',m,'.',n,'.',o,'.',catatan,'.',id_jenis_pemeliharaan) = '$grubId' and id_tahap = '$idTahap' "));
				 		$volume_rek = $volume_rek['sum(volume_rek)'];
				}

			$kondisiFilter = "and no_urut = '$this->urutTerakhir' and tahun  ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'";
			if($k == '0' && $n =='0' ){
				$k = "";
				$l = "";
			    $m = "";
				$n = "";
				$o = "";
				$this->publicVar += 1;
				$getPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$o1' "));
				$uraian = "<span style='font-weight:bold;'>$this->publicVar.". $getPekerjaan['nama_pekerjaan'] . "</span>";
				$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_dpa_3_2 where  o1 ='$o1' $kondisiSKPD $kondisiFilter  "));
				$jumlah_harga = "<span style='font-weight:bold;'>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.') . "</span>";


			}elseif($c1 == '0'){
				$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
				$jarak = "0px";
				if($o1 !='0' && $o1 !='')$jarak = "10px";
				$uraian = "<span style='font-weight:bold;margin-left:$jarak;'>".$getNamaRekening['nm_rekening']."</b>";
				$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_dpa_3_2 where  k = '$k' and l='$l' and m='$m' and n='$n' and o='$o'  $kondisiSKPD $kondisiFilter"));
				$jumlah_harga = "<b>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.');
			}else{
				$k = "";
				$l = "";
			    $m = "";
				$n = "";
				$o = "";
				if($j != '000'){
					$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
					$uraian = "<span style='margin-left:20px;'> ". $getNamaBarang['nm_barang'] . "</span>";
				}else{
					$uraian = "<span style='margin-left:20px;'> ". $rincian_perhitungan . "</span>";
				}
				$jumlah = number_format($jumlah,2,',','.');
				$jumlah_harga = number_format($jumlah_harga,2,',','.');
				$volume_rek = number_format($volume_rek,0,',','.');

			}

			if(in_array($id_anggaran, $this->publicExcept)) {
					echo "
								<tr valign='top'>
									<td align='center' class='GarisCetak' >".$k."</td>
									<td align='center' class='GarisCetak' >".$l."</td>
									<td align='center' class='GarisCetak' >".$m."</td>
									<td align='center' class='GarisCetak' >".$n."</td>
									<td align='center' class='GarisCetak' >".$o."</td>
									<td align='left' class='GarisCetak' >".$uraian."</td>
									<td align='right' class='GarisCetak' >".$volume_rek."</td>
									<td align='left' class='GarisCetak'>$satuan_rek</td>
									<td align='right' class='GarisCetak' >".$jumlah."</td>
									<td align='right' class='GarisCetak' >".$jumlah_harga."</td>
								</tr>
				";
				}elseif($j != '000' && mysql_num_rows(mysql_query("select * from view_dpa_3_2 where concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',k,'.',l,'.',m,'.',n,'.',o,'.',catatan,'.',id_jenis_pemeliharaan) = '$grubId' and id_tahap = '$idTahap' ")) > 1 ){
					echo "";
				}else{
					echo "
								<tr valign='top'>
									<td align='center' class='GarisCetak' >".$k."</td>
									<td align='center' class='GarisCetak' >".$l."</td>
									<td align='center' class='GarisCetak' >".$m."</td>
									<td align='center' class='GarisCetak' >".$n."</td>
									<td align='center' class='GarisCetak' >".$o."</td>
									<td align='left' class='GarisCetak' >".$uraian."</td>
									<td align='right' class='GarisCetak' >".$volume_rek."</td>
									<td align='left' class='GarisCetak'>$satuan_rek</td>
									<td align='right' class='GarisCetak' >".$jumlah."</td>
									<td align='right' class='GarisCetak' >".$jumlah_harga."</td>
								</tr>
					";
				}




		}
		echo 				"<tr valign='top'>
									<td align='right' colspan='9' class='GarisCetak'>Jumlah</td>
									<td align='right' class='GarisCetak' ><b>".$total."</b></td>

								</tr>
							 </table>";
		$getSumAlokasi = mysql_fetch_array(mysql_query("select  sum(alokasi_jan), sum(alokasi_feb) , sum(alokasi_mar) , sum(alokasi_apr) , sum(alokasi_mei) , sum(alokasi_jun) , sum(alokasi_jul) , sum(alokasi_agu) , sum(alokasi_sep) , sum(alokasi_okt) , sum(alokasi_nop), sum(alokasi_des) from anggaran_kas where anggaran='$this->jenisAnggaran' and tahun ='$this->tahun' $kondisiSKPD"));
		$triwulanI = $getSumAlokasi['sum(alokasi_jan)'] + $getSumAlokasi['sum(alokasi_feb)'] + $getSumAlokasi['sum(alokasi_mar)'];
		$totalAlokasi += $triwulanI;

		$triwulanI = number_format($triwulanI,2,',','.');

		$triwulanII = $getSumAlokasi['sum(alokasi_apr)'] + $getSumAlokasi['sum(alokasi_mei)'] + $getSumAlokasi['sum(alokasi_jun)'];
		$totalAlokasi += $triwulanII;
		$triwulanII = number_format($triwulanII,2,',','.');

		$triwulanIII = $getSumAlokasi['sum(alokasi_jul)'] + $getSumAlokasi['sum(alokasi_agu)'] + $getSumAlokasi['sum(alokasi_sep)'];
		$totalAlokasi += $triwulanIII;
		$triwulanIII = number_format($triwulanIII,2,',','.');

		$triwulanIV = $getSumAlokasi['sum(alokasi_okt)'] + $getSumAlokasi['sum(alokasi_nop)'] + $getSumAlokasi['sum(alokasi_des)'];
		$totalAlokasi += $triwulanIV;
		$triwulanIV = number_format($triwulanIV,2,',','.');

		$totalAlokasi = number_format($totalAlokasi,2,',','.');
		echo
						"<br><div class='ukurantulisan' style ='float:right;'>
						$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."<br>
						Mengesahkan
						<br>
						Pejabat Pengelola Keuangan Daerah
						<br>
						<br>
						<br>
						<br>

						<u>".$this->pejabatPengelolaBarang."</u><br>
						NIP	".$this->nipPejabat."


						</div>
						<div class='ukurantulisan' style ='float:left;'>
						<table class='ukurantulisan' >
						 <tr>
						 	<td class='ukurantulisan'>Triwulan I</td>
							<td class='ukurantulisan'>Rp</td>
							<td class='ukurantulisan' align='right'>$triwulanI</td>
						 </tr>
						 <tr>
						 	<td class='ukurantulisan'>Triwulan II</td>
							<td class='ukurantulisan'>Rp</td>
							<td class='ukurantulisan' align='right'>$triwulanII</td>
						 </tr>
						 <tr>
						 	<td class='ukurantulisan'>Triwulan III</td>
							<td class='ukurantulisan'>Rp</td>
							<td class='ukurantulisan' align='right'>$triwulanIII</td>
						 </tr>
						 <tr>
						 	<td class='ukurantulisan'>Triwulan IV</td>
							<td class='ukurantulisan'>Rp</td>
							<td class='ukurantulisan' align='right'>$triwulanIV</td>
						 </tr>
						 <tr>
						 	<td class='ukurantulisan'>Jumlah</td>
							<td class='ukurantulisan'>Rp</td>
							<td class='ukurantulisan' align='right'>$totalAlokasi</td>
						 </tr>

						</table>

						</div>
			</body>
		</html>";
	}

function formAlokasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';

	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

	 if(empty($cmbUrusan)){
	 	$err = "Pilih Urusan";
	 }elseif(empty($cmbBidang)){
	 	$err = "Pilih Bidang";
	 }elseif(empty($cmbSKPD)){
	 	$err = "Pilih SKPD";
	 }

	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';

	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );

	 $terpilih = $anggaranKasSKPD32_cb[0];
	 $getKodeRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$terpilih'"));
				$k = $getKodeRekening['k'];
				$l = $getKodeRekening['l'];
				$m = $getKodeRekening['m'];
				$n = $getKodeRekening['n'];
				$o = $getKodeRekening['o'];

	 $this->publicSum = "select sum(jumlah_harga) from tabel_anggaran where (rincian_perhitungan !='' or f !='00' ) and id_tahap='$this->idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka ='3.2' and nama_modul = 'DPA-SKPD' and c1= '$cmbUrusan' and c ='$cmbBidang' and d='$cmbSKPD' and bk = '$bk' and ck ='$ck' and dk ='$dk' and p = '$hiddenP' and q='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' ";
	 $getSumJumlah = mysql_fetch_array(mysql_query($this->publicSum));
	 $jumlahHargaForm =$getSumJumlah['sum(jumlah_harga)'];
	 if(mysql_num_rows(mysql_query("select * from anggaran_kas where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$cmbUrusan' and c='$cmbBidang' and d ='$cmbSKPD' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' and jenis_rka ='3.2' and jenis_dpa = 'DPA-SKPD'")) != 0 ){
	 	$grabSPD = mysql_fetch_array(mysql_query("select * from anggaran_kas where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$cmbUrusan' and c='$cmbBidang' and d ='$cmbSKPD' and  k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' and jenis_rka ='3.2' and jenis_dpa = 'DPA-SKPD'"));
		foreach ($grabSPD as $key => $value) {
				  $$key = $value;
		}
		$jan = $alokasi_jan;
		$feb = $alokasi_feb;
		$mar = $alokasi_mar;
		$apr = $alokasi_apr;
		$mei = $alokasi_mei;
		$jun = $alokasi_jun;
		$jul = $alokasi_jul;
		$agu = $alokasi_agu;
		$sep = $alokasi_sep;
		$okt = $alokasi_okt;
		$nop = $alokasi_nop;
		$des = $alokasi_des;
		$jenisAlokasi = $jenis_alokasi_kas;
	 }

	 $resultPenjumlahan = $jan + $feb + $mar + $apr + $mei + $jun + $jul + $agu + $sep + $okt + $nop + $des;
	 if(empty($jenisPerhitungan))$jenisPerhitungan = "MANUAL";
	 if(empty($jan))$jan="0";
	 if(empty($feb))$feb="0";
	 if(empty($mar))$mar="0";
	 if(empty($apr))$apr="0";
	 if(empty($mei))$mei="0";
	 if(empty($jun))$jun="0";
	 if(empty($jul))$jul="0";
	 if(empty($agu))$agu="0";
	 if(empty($sep))$sep="0";
	 if(empty($okt))$okt="0";
	 if(empty($nop))$nop="0";
	 if(empty($des))$des="0";
	 $selisih = $jumlahHargaForm - $resultPenjumlahan;
	 /*if($jenisAlokasi == "TRIWULAN"){
	 	$readOnly = "readOnly";
	 }*/
	 $cmbJenisAlokasi = cmbArray('jenisAlokasi','BULANAN',$arrayJenisAlokasi,'-- JENIS ALOKASI --',"onchange=$this->Prefix.jenisAlokasiChanged($id);") ;
	 $cmbJenisPerhitungan = cmbArray('jenisPerhitungan',$jenisPerhitungan,$arrayJenisPerhitungan,'-- JENIS PERHITUNGAN --',"onchange=$this->Prefix.jenisPerhitunganChanged();") ;
	 //items ----------------------
	  $this->form_fields = array(
			'1' => array(
						'label'=>'JUMLAH HARGA ',
						'labelWidth'=>150,
						'value'=>"<input type='hidden' name='jumlahHargaForm' id ='jumlahHargaForm'  value='$jumlahHargaForm'>
						<input type='text' value='Rp. ".number_format($jumlahHargaForm,2,',','.')."' readonly style='width:210px;'> ",

						 ),
			'2' => array(
						'label'=>'JENIS ALOKASI',
						'labelWidth'=>150,
						'value'=>$cmbJenisAlokasi,
						 ),
			'3' => array(
						'label'=>'SISTEM PERHITUNGAN',
						'labelWidth'=>150,
						'value'=>$cmbJenisPerhitungan." &nbsp <button type='button' id='buttonHitung' onclick='$this->Prefix.hitung();' disabled >HITUNG</button> ",
						 ),
			'4' => array(
						'label'=>'JANUARI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jan' id='jan' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='$jan' onkeyup=$this->Prefix.hitungSelisih('bantuJan'); > &nbsp <span id='bantuJan' style='color:red;'>".number_format($jan ,2,',','.')."</span> ",

						 ),
			'5' => array(
						'label'=>'FEBRUARI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='feb' id='feb' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$feb' onkeyup=$this->Prefix.hitungSelisih('bantuFeb'); > &nbsp <span id='bantuFeb' style='color:red;'>".number_format($feb ,2,',','.')."</span> ",

						 ),
			'6' => array(
						'label'=>'MARET',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='mar' id='mar' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$mar' onkeyup=$this->Prefix.hitungSelisih('bantuMar');> &nbsp <span id='bantuMar' style='color:red;'>".number_format($mar ,2,',','.')."</span> ",

						 ),
			'7' => array(
						'label'=>'APRIL',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='apr' id='apr' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$apr' onkeyup=$this->Prefix.hitungSelisih('bantuApr');> &nbsp <span id='bantuApr' style='color:red;'>".number_format($apr ,2,',','.')."</span> ",

						 ),
			'22' => array(
						'label'=>'MEI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='mei' id='mei' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$mei' onkeyup=$this->Prefix.hitungSelisih('bantuMei');> &nbsp <span id='bantuMei' style='color:red;'>".number_format($mei ,2,',','.')."</span> ",

						 ),
			'8' => array(
						'label'=>'JUNI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jun' id='jun' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$jun' onkeyup=$this->Prefix.hitungSelisih('bantuJun');> &nbsp <span id='bantuJun' style='color:red;'>".number_format($jun ,2,',','.')."</span> ",

						 ),
			'9' => array(
						'label'=>'JULI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jul' id='jul' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$jul' onkeyup=$this->Prefix.hitungSelisih('bantuJul');> &nbsp <span id='bantuJul' style='color:red;'>".number_format($jul,2,',','.')."</span> ",

						 ),
			'10' => array(
						'label'=>'AGUSTUS',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='agu' id='agu' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$agu' onkeyup=$this->Prefix.hitungSelisih('bantuAgu');> &nbsp <span id='bantuAgu' style='color:red;'>".number_format($agu ,2,',','.')."</span> ",

						 ),

			'11' => array(
						'label'=>'SEPTEMBER',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='sep' id='sep'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$sep' onkeyup=$this->Prefix.hitungSelisih('bantuSep');> &nbsp <span id='bantuSep' style='color:red;'>".number_format($sep ,2,',','.')."</span> ",

						 ),
			'12' => array(
						'label'=>'OKTOBER',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='okt' id='okt' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$okt' onkeyup=$this->Prefix.hitungSelisih('bantuOkt');> &nbsp <span id='bantuOkt' style='color:red;'>".number_format($okt ,2,',','.')."</span> ",

						 ),
			'13' => array(
						'label'=>'NOPEMBER',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='nop' id='nop' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$nop' onkeyup=$this->Prefix.hitungSelisih('bantuNop');> &nbsp <span id='bantuNop' style='color:red;'>".number_format($nop ,2,',','.')."</span> ",

						 ),
			'14' => array(
						'label'=>'DESEMBER',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='des' id='des' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$des' onkeyup=$this->Prefix.hitungSelisih('bantuDes');> &nbsp <span id='bantuDes' style='color:red;'>".number_format($des ,2,',','.')."</span> ",

						 ),
			'15' => array(
						'label'=>'JUMLAH HARGA ALOKASI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jumlahHargaAlokasi' id='jumlahHargaAlokasi' value='$resultPenjumlahan' readonly > &nbsp <span id='bantuPenjumlahan' style='color:red;'>".number_format($resultPenjumlahan ,2,',','.')."</span>",

						 ),
			'16' => array(
						'label'=>'SELISIH (+/-)',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='selisih' id='selisih' value='$selisih' readonly > &nbsp <span id='bantuSelisih' style='color:red;'>".number_format($selisih ,2,',','.')."</span>",

						 ),

			);
		//tombol

		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi($terpilih);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

function formAlokasiTriwulan(){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';
	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
	 $terpilih = $anggaranKasSKPD32_cb[0];
	 $getKodeRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$terpilih'"));
				$k = $getKodeRekening['k'];
				$l = $getKodeRekening['l'];
				$m = $getKodeRekening['m'];
				$n = $getKodeRekening['n'];
				$o = $getKodeRekening['o'];
	 $this->publicSum = "select sum(jumlah_harga) from tabel_anggaran where (rincian_perhitungan !='' or f !='00' ) and id_tahap='$this->idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka ='3.2' and nama_modul = 'DPA-SKPD' and c1= '$cmbUrusan' and c ='$cmbBidang' and d='$cmbSKPD' and bk = '$bk' and ck ='$ck' and dk ='$dk' and p = '$hiddenP' and q='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' ";
	 $getSumJumlah = mysql_fetch_array(mysql_query($this->publicSum));
	 $jumlahHargaForm =$getSumJumlah['sum(jumlah_harga)'];

	 if(mysql_num_rows(mysql_query("select * from anggaran_kas where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$cmbUrusan' and c='$cmbBidang' and d ='$cmbSKPD' and bk ='$bk' and ck ='$ck' and dk ='$dk' and p='$hiddenP' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' and jenis_rka ='3.2' and jenis_dpa = 'DPA-SKPD'")) != 0 ){
	 	$grabSPD = mysql_fetch_array(mysql_query("select * from anggaran_kas where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$cmbUrusan' and c='$cmbBidang' and d ='$cmbSKPD' and bk ='$bk' and ck ='$ck' and dk ='$dk' and p='$hiddenP' and q ='$q' and k='$k' and l='$l' and m='$m' and n ='$n' and o ='$o' and jenis_rka ='3.2' and jenis_dpa = 'DPA-SKPD'"));
		foreach ($grabSPD as $key => $value) {
				  $$key = $value;
		}
		$jan = $alokasi_jan;
		$feb = $alokasi_feb;
		$mar = $alokasi_mar;
		$apr = $alokasi_apr;
		$mei = $alokasi_mei;
		$jun = $alokasi_jun;
		$jul = $alokasi_jul;
		$agu = $alokasi_agu;
		$sep = $alokasi_sep;
		$okt = $alokasi_okt;
		$nop = $alokasi_nop;
		$des = $alokasi_des;

	 }
	 $resultPenjumlahan = $jan + $feb + $mar + $apr + $mei + $jun + $jul + $agu + $sep + $okt + $nop + $des;
	 if(empty($jenisPerhitungan))$jenisPerhitungan = "MANUAL";
	 if(empty($jan))$jan="0";
	 if(empty($feb))$feb="0";
	 if(empty($mar))$mar="0";
	 if(empty($apr))$apr="0";
	 if(empty($mei))$mei="0";
	 if(empty($jun))$jun="0";
	 if(empty($jul))$jul="0";
	 if(empty($agu))$agu="0";
	 if(empty($sep))$sep="0";
	 if(empty($okt))$okt="0";
	 if(empty($nop))$nop="0";
	 if(empty($des))$des="0";
	 $selisih = $jumlahHargaForm - $resultPenjumlahan;
	 if($jenisAlokasi == "TRIWULAN"){
	 	$readOnly = "readOnly";
	 }
	 $cmbJenisAlokasi = cmbArray('jenisAlokasi','TRIWULAN',$arrayJenisAlokasi,'-- JENIS ALOKASI --',"onchange=$this->Prefix.jenisAlokasiChanged($id);") ;
	 $cmbJenisPerhitungan = cmbArray('jenisPerhitungan',$jenisPerhitungan,$arrayJenisPerhitungan,'-- JENIS PERHITUNGAN --',"onchange=$this->Prefix.jenisPerhitunganChanged();") ;
	 //items ----------------------
	  $this->form_fields = array(
			'1' => array(
						'label'=>'JUMLAH HARGA ',
						'labelWidth'=>150,
						'value'=>"<input type='hidden' name='jumlahHargaForm' id ='jumlahHargaForm'  value='$jumlahHargaForm'> <input type='text' value='Rp. ".number_format($jumlahHargaForm,2,',','.')."' readonly style='width:210px;'>",
						 ),
			'2' => array(
						'label'=>'JENIS ALOKASI',
						'labelWidth'=>150,
						'value'=>$cmbJenisAlokasi,
						 ),
			'3' => array(
						'label'=>'SISTEM PERHITUNGAN',
						'labelWidth'=>150,
						'value'=>$cmbJenisPerhitungan." &nbsp <button type='button' id='buttonHitung' onclick='$this->Prefix.hitung();' disabled >HITUNG</button>  <input type='hidden' name='jan' id='jan'><input type='hidden' name='feb' id='feb'> <input type='hidden' name='apr' id='apr'> <input type='hidden' name='mei' id='mei'> <input type='hidden' name='jul' id='jul'> <input type='hidden' name='agu' id='agu'> <input type='hidden' name='okt' id='okt'> <input type='hidden' name='nop' id='nop'> ",
						 ),
			'6' => array(
						'label'=>'TRIWULAN 1',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='mar' id='mar' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$mar' onkeyup=$this->Prefix.hitungSelisih('bantuMar');> &nbsp <span id='bantuMar' style='color:red;'>".number_format($mar ,2,',','.')."</span> ",

						 ),
			'8' => array(
						'label'=>'TRIWULAN 2',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jun' id='jun' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$jun' onkeyup=$this->Prefix.hitungSelisih('bantuJun');> &nbsp <span id='bantuJun' style='color:red;'>".number_format($jun ,2,',','.')."</span> ",

						 ),
			'11' => array(
						'label'=>'TRIWULAN 3',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='sep' id='sep'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$sep' onkeyup=$this->Prefix.hitungSelisih('bantuSep');> &nbsp <span id='bantuSep' style='color:red;'>".number_format($sep ,2,',','.')."</span> ",

						 ),
			'14' => array(
						'label'=>'TRIWULAN 4',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='des' id='des' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$des' onkeyup=$this->Prefix.hitungSelisih('bantuDes');> &nbsp <span id='bantuDes' style='color:red;'>".number_format($des ,2,',','.')."</span> ",

						 ),
			'15' => array(
						'label'=>'JUMLAH HARGA ALOKASI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jumlahHargaAlokasi' id='jumlahHargaAlokasi' value='$resultPenjumlahan' readonly > &nbsp <span id='bantuPenjumlahan' style='color:red;'>".number_format($resultPenjumlahan ,2,',','.')."</span>",

						 ),
			'16' => array(
						'label'=>'SELISIH (+/-)',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='selisih' id='selisih' value='$selisih' readonly > &nbsp <span id='bantuSelisih' style='color:red;'>".number_format($selisih ,2,',','.')."</span>",

						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi($terpilih);' title='Simpan' >   ".
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

function formRincianVolume($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 230;
	 $this->form_caption = 'RINCIAN VOLUME';
	 $jumlahHargaForm = $dt;
	 $username =$_COOKIE['coID'];
	 $getRincianVolume = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$dt'"));
	 foreach ($getRincianVolume as $key => $value) {
				  $$key = $value;
		}
	 $codeAndSatuanSatuan = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='satuan'";
	 $cmbSatuanSatuan1 = cmbQuery('satuanSatuan1',$satuan1,$codeAndSatuanSatuan,'','-- SATUAN --');

	 $codeAndSatuanSatuan = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='satuan'";
	 $cmbSatuanSatuan2 = cmbQuery('satuanSatuan2',$satuan2,$codeAndSatuanSatuan,'','-- SATUAN --');

	 $codeAndSatuanSatuan = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='satuan'";
	 $cmbSatuanSatuan3 = cmbQuery('satuanSatuan3',$satuan3,$codeAndSatuanSatuan,'','-- SATUAN --');

	 $codeAndSatuanVolume = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='volume'";
	 $cmbSatuanVolume = cmbQuery('satuanVolume',$satuan_total,$codeAndSatuanVolume,'','-- SATUAN --');

	 if($jumlah3 == 0 && $satuan3 == ""){
	 	$totalResult = $jumlah1 * $jumlah2 ;
		$jumlah3 = "";
	 }else{
	 	$totalResult = $jumlah1 * $jumlah2 * $jumlah3 ;
	 }


	 //items ----------------------
	  $this->form_fields = array(
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"<input type='hidden' id='volumeRek' value='$dt'>  <input type='text' id='jumlah1' value='$jumlah1' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder='JUMLAH'> &nbsp &nbsp ".$cmbSatuanSatuan1. " &nbsp &nbsp <button type='button' onclick='$this->Prefix.newSatuanSatuan();'>Baru</button>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"KALI (X)",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"<input type='text' id='jumlah2' placeholder='JUMLAH' value='$jumlah2' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp &nbsp ".$cmbSatuanSatuan2. " ",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"KALI (X)",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"<input type='text' id='jumlah3' placeholder='JUMLAH' value='$jumlah3' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp &nbsp ".$cmbSatuanSatuan3. " ",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"KALI (X)",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"<input type='text' value='$totalResult' placeholder='JUMLAH' id='jumlah4' readonly > &nbsp &nbsp ".$cmbSatuanVolume. " &nbsp &nbsp <button type='button' onclick='$this->Prefix.newSatuanVolume();'>Baru</button>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveRincianVolume($dt);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

function newSatuanSatuan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form2';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'SATUAN BARU';


	 //items ----------------------
	  $this->form_fields = array(
			'' => array(
						'label'=>'NAMA SATUAN',
						'labelWidth'=>130,
						'value'=>"<input type='text' name='namaSatuan' id='namaSatuan' style='width:210px;'>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveSatuanSatuan();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function newSatuanVolume($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form2';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'SATUAN BARU';


	 //items ----------------------
	  $this->form_fields = array(
			'' => array(
						'label'=>'NAMA SATUAN',
						'labelWidth'=>130,
						'value'=>"<input type='text' name='namaSatuan' id='namaSatuan' style='width:210px;'>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveSatuanVolume();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

}
$anggaranKasSKPD32 = new anggaranKasSKPD32Obj();


$arrayResult = VulnWalkerTahap_v2($anggaranKasSKPD32->modul);
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$anggaranKasSKPD32->jenisForm = $jenisForm;
$anggaranKasSKPD32->nomorUrut = $nomorUrut;
$anggaranKasSKPD32->urutTerakhir = $nomorUrut;
$anggaranKasSKPD32->tahun = $tahun;
$anggaranKasSKPD32->jenisAnggaran = $jenisAnggaran;
$anggaranKasSKPD32->idTahap = $idTahap;

$anggaranKasSKPD32->username = $_COOKIE['coID'];


if(empty($anggaranKasSKPD32->tahun)){

	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_dpa_3_2 "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_dpa_3_2 where id_anggaran = '$maxAnggaran'"));
	/*$anggaranKasSKPD32->tahun = "select max(id_anggaran) as max from view_dpa_3_2 where nama_modul = 'anggaranKasSKPD32'";*/
	$anggaranKasSKPD32->tahun  = $get2['tahun'];
	$anggaranKasSKPD32->jenisAnggaran = $get2['jenis_anggaran'];
	$anggaranKasSKPD32->urutTerakhir = $get2['no_urut'];
	$anggaranKasSKPD32->jenisFormTerakhir = $get2['jenis_form_modul'];
	$anggaranKasSKPD32->urutSebelumnya = $anggaranKasSKPD32->urutTerakhir - 1;


	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$anggaranKasSKPD32->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$anggaranKasSKPD32->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$anggaranKasSKPD32->currentTahap = $arrayHasil['currentTahap'];
}else{
	$getCurrenttahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$anggaranKasSKPD32->idTahap'"));
	$anggaranKasSKPD32->currentTahap = $getCurrenttahap['nama_tahap'];

	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$anggaranKasSKPD32->idTahap'"));
	$anggaranKasSKPD32->jenisFormTerakhir =  $namaTahap['jenis_form_modul'];
	$anggaranKasSKPD32->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$anggaranKasSKPD32->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
}

$setting = settinganPerencanaan_v2();
$anggaranKasSKPD32->provinsi = $setting['provinsi'];
$anggaranKasSKPD32->kota = $setting['kota'];
$anggaranKasSKPD32->pengelolaBarang = $setting['pengelolaBarang'];
$anggaranKasSKPD32->pejabatPengelolaBarang = $setting['pejabat'];
$anggaranKasSKPD32->pengurusPengelolaBarang = $setting['pengurus'];
$anggaranKasSKPD32->nipPengelola = $setting['nipPengelola'];
$anggaranKasSKPD32->nipPengurus = $setting['nipPengurus'];
$anggaranKasSKPD32->nipPejabat = $setting['nipPejabat'];


?>
