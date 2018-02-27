<?php

class rkaSKPD1DPObj  extends DaftarObj2{
	var $Prefix = 'rkaSKPD1DP';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_rka_1'; //bonus
	var $TblName_Hapus = 'tabel_anggaran';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id_anggaran');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 2;
	var $PageTitle = 'RKA-SKPD';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='rkaSKPD1DP.xls';
	var $namaModulCetak='RKA';
	var $Cetak_Judul = 'RKA';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'rkaSKPD1DPForm';
	var $modul = "RKA-SKPD";
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
	var $wajibValidasi = "";

	var $sqlValidasi = "";
	//buatview
	var $TampilFilterColapse = 0; //0

	var $provinsi = "";
	var $kota = "";
	var $pengelolaBarang = "";
	var $pejabatPengelolaBarang = "";
	var $pengurusPengelolaBarang = "";
	var $nipPengelola = "";
	var $nipPejabat = "";
	var $nipPengurus ="";

	var $publicVar = "";

	var $kondisiRekening = " and l = '2'";

	function setTitle(){
		return 'RKA-SKPD 1 DP '.$this->jenisAnggaran.' TAHUN '.$this->tahun;
	}
	function setMenuView(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";

	}
	function setMenuEdit(){
	 	 $arrayResult = VulnWalkerTahap_v2('RKA');
		 $jenisForm = $arrayResult['jenisForm'];
		 $nomorUrut = $arrayResult['nomorUrut'];
		 $tahun = $arrayResult['tahun'];
		 $jenisAnggaran = $arrayResult['jenisAnggaran'];
		 $query = $arrayResult['query'];
	 if ($jenisForm == "PENYUSUNAN"){
	 	$listMenu =

					"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","edit_f2.png","Ubah ", 'Ubah ')."</td>".
					// "<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			//		"<td>".genPanelIcon("javascript:".$this->Prefix.".Remove()","delete_f2.png","Hapus", 'Hapus')."</td>".
				//	"<td>".genPanelIcon("javascript:".$this->Prefix.".Gruping()","publishdata.png","Gruping ", 'Gruping ')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>"
					;
	 }elseif ($jenisForm == "VALIDASI"){
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Validasi()","validasi-menu.png","Validasi", 'Validasi')."</td>
					<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
	 }elseif ($jenisForm == "KOREKSI"){
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
	 }else{
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
	 }

		return $listMenu ;
	}
	function genRowSum($ColStyle, $Mode, $Total){
		foreach ($_REQUEST as $key => $value) {
		  	$$key = $value;
		 }
		 if($cmbSubUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
		}elseif($cmbUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
		}elseif($cmbSKPD != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
		}elseif($cmbBidang != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
		}elseif($cmbUrusan != ''){
			$kondisiSKPD = "and c1='$cmbUrusan'";
		}

		if ($this->jenisForm == "PENYUSUNAN" || $this->jenisForm == "KOREKSI" ){
			$idTahap = $this->idTahap;
		}else{
			$getIdTahapRKATerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from tabel_anggaran where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and jenis_rka !='' and o1 !='0' and (rincian_perhitungan !='' or f !='00' ) and nama_modul = 'RKA-SKPD' "));
		 	$idTahap = $getIdTahapRKATerakhir['max'];
		}


		if($this->wajibValidasi == TRUE)$tergantung = "<td class='GarisDaftar' align='center' ></td>";
		$ContentTotal =
		"<tr>
			<td class='$ColStyle' colspan='5' align='center'><b>Total </td>
			<td class='GarisDaftar' align='right'><b><div  >".number_format($this->total,2,',','.')."</div></td>

			$tergantung
		</tr>" ;


			if($Mode == 2){
				$ContentTotal = '';
			}else if($Mode == 3){
				$ContentTotalHal='';
			}

		return $ContentTotalHal.$ContentTotal;
	}
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];

	 foreach ($_REQUEST as $key => $value) {
		  $$key = $value;
	 }



	$user = $_COOKIE['coID'];
	$arrayKodeRekening = explode(".",$kodeRekening);
	$k = $arrayKodeRekening[0];
	$l = $arrayKodeRekening[1];
	$m = $arrayKodeRekening[2];
	$n = $arrayKodeRekening[3];
	$o = $arrayKodeRekening[4];

	$getJumlahBarang = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$rkaSKPD1DP_idplh'"));
	$jumlahBarang = $getJumlahBarang['volume_barang'];
	$total = $hargaSatuan * $jumlahBarang;

	/* $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja "));
  	 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
	$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and id_tahap = '$idTahapRenja' "));*/
	$getPaguYangTelahTerpakai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_1 where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and no_urut = '$this->nomorUrut' and id_anggaran!='$rkaSKPD1DP_idplh' "));
	$sisaPaguIndikatif = $paguIndikatif - $getPaguYangTelahTerpakai['paguYangTerpakai'];

	 if(mysql_num_rows(mysql_query("select * from view_rka_1 where c1='0' and f = '00' and k = '$k' and l ='$l' and m='$m' and n='$n' and o='$o'  and id_tahap='$this->idTahap' ")) > 0){

					}else{
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
											'k' => $k,
											'l' => $l,
											'm' => $m,
											'n' => $n,
											'o' => $o,
											'tahun' => $this->tahun,
											'jenis_anggaran' => $this->jenisAnggaran,
											'id_tahap' => $this->idTahap,
											'nama_modul' => 'RKA-SKPD'
											);
						$queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
						mysql_query($queryRekening);
					}

 	 if(empty($cmbJenisRKAForm) ){
	   	$err= 'Pilih Jenis RKA ';
	 }elseif(empty($kodeRekening)){
	 	$err = 'Pilih Rekening';
	 }elseif(empty($hargaSatuan) || $hargaSatuan == '0'){
	 	$err = 'Isi Harga Satuan';
	 }elseif($total > $sisaPaguIndikatif){
	 	$err = 'Tidak dapat Melebihi Pagu Indikatif';
	 }else{
	 	$data = array(
						'k' => $k,
						'l' => $l,
						'm' => $m,
						'n' => $n,
						'o' => $o,
						'satuan_rek' => $hargaSatuan,
						'jenis_rka' => $cmbJenisRKAForm,
						'jumlah_harga' => $total

					   );
		$query = VulnWalkerUpdate('tabel_anggaran',$data,"id_anggaran = '$rkaSKPD1DP_idplh'");
		mysql_query($query);
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
			case 'saveEditSubRincian':{
				foreach ($_REQUEST as $key => $value) {
					$$key = $value;
				}
				$dataUpdate = array(
														'jumlah1' => $volume1,
														'jumlah2' => $volume2,
														'jumlah3' => $volume3,
														'volume_rek' => $volumeRekening,
														'satuan1' => $satuan1,
														'satuan2' => $satuan2,
														'satuan3' => $satuan3,
														'satuan_total' => $satuanRekening,
														'jumlah' => $hargaSatuan,
														'jumlah_harga' => $volumeRekening * $hargaSatuan,
														'rincian_volume' => $uraianVolume
													);
				$query = VulnWalkerUpdate('tabel_anggaran',$dataUpdate,"id_anggaran ='$id'");
				mysql_query($query);
				$cek = $query;
			break;
			}
			case 'formRincianVolume':{
					$fm = $this->formRincianVolume($_REQUEST['id']);
					$cek = $fm['cek'];
					$err = $fm['err'];
					$content = $fm['content'];


			break;
			}
			case 'saveEditRincianBelanja':{
				foreach ($_REQUEST as $key => $value) {
					$$key = $value;
				}
				$dataUpdate = array(
														'nama_rincian_belanja' => $namaRincianBelanja,
													);
				$query = VulnWalkerUpdate('rincian_belanja',$dataUpdate,"id ='$id'");
				mysql_query($query);
				$cek = $query;
			break;
			}
			case 'editSubRincian':{
					foreach ($_REQUEST as $key => $value) {
						$$key = $value;
					}
					$getData = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id'"));
					foreach ($getData as $key => $value) {
						$$key = $value;
					}
					// $kuantitas = $volume_rek / $jumlah1;



					$inputanVolume = "<input style='width:25px;  text-align:right;' placeholder='VOLUME'  type='text' name='volumeRek$id' value='$volume_rek' id='volumeRek$id' onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly > &nbsp <input type='button' value='Detail Volume' onclick=$this->Prefix.formRincianVolume($id);>
					<input type='hidden' name='volume1Temp$id' id='volume1Temp$id' value='".$this->nullChecker($jumlah1)."'>
					<input type='hidden' name='volume2Temp$id' id='volume2Temp$id' value='".$this->nullChecker($jumlah2)."'>
					<input type='hidden' name='volume3Temp$id' id='volume3Temp$id' value='".$this->nullChecker($jumlah3)."'>
					<input type='hidden' name='satuan1Temp$id' id='satuan1Temp$id' value='$satuan1'>
					<input type='hidden' name='satuan2Temp$id' id='satuan2Temp$id' value='$satuan2'>
					<input type='hidden' name='satuan3Temp$id' id='satuan3Temp$id' value='$satuan3'>
					<input type='hidden' name ='rincianVolume$id' id='rincianVolume$id'  value='$rincian_volume'>";

					if(!empty($satuan_total)){
							$satuanRek = $satuan_total;
					}else{
							$satuanRek = $satuan1;
					}
					$eventKeyup = 'document.getElementById("formatjumlah'.$id.'").innerHTML = rkaSKPD1DP.formatCurrency(this.value); ';
					$inputanSatuan = "<input style='width:100%;  text-align:left;'   type='text' name='satuanRek$id' value='$satuanRek' id='satuanRek$id'  readonly > ";
					$inputanSatuanHarga = "<input style='width:50%;  text-align:right;' placeholder='JUMLAH'  type='text' name='hargaSatuan$id' value='".$this->removeKoma($jumlah)."' id='hargaSatuan$id' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$eventKeyup'> <span id='formatjumlah$id'>  ";

					$isiActionSpan = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.saveEditSubRincian($id_anggaran);></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.refreshList(true);></img> ";

					$arrayResult = VulnWalkerTahap_v2("RKA");
					$jenisForm = $arrayResult['jenisForm'];
					$nomorUrut = $arrayResult['nomorUrut'];
					$tahun = $arrayResult['tahun'];
					$jenisAnggaran = $arrayResult['jenisAnggaran'];
					$query = $arrayResult['query'];

					if($jenisForm !="PENYUSUNAN")$err = "Data telah di posting !";

					$content = array('isiSpanVolume' => $inputanVolume, 'isiSpanSatuan' => $inputanSatuan, 'isiSpanHargaSatuan' => $inputanSatuanHarga,'isiActionSpan' => $isiActionSpan);

			break;
			}
			case 'editRincianBelanja':{
					foreach ($_REQUEST as $key => $value) {
						$$key = $value;
					}
					$getData = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '$id'"));
					foreach ($getData as $key => $value) {
						$$key = $value;
					}

					$isiSpanRincianBelanja = "<input type='text' name='textRincianBelanja$id_anggaran' id = 'textRincianBelanja$id_anggaran' value= '$nama_rincian_belanja' style='width:90%;'>";
					$isiActionSpan = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.saveEditRincianBelanja($id_anggaran,$id);></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.refreshList(true);></img> ";
					$arrayResult = VulnWalkerTahap_v2("RKA");
					$jenisForm = $arrayResult['jenisForm'];
					$nomorUrut = $arrayResult['nomorUrut'];
					$tahun = $arrayResult['tahun'];
					$jenisAnggaran = $arrayResult['jenisAnggaran'];
					$query = $arrayResult['query'];

					if($jenisForm !="PENYUSUNAN")$err = "Data telah di posting !";
					$content = array('isiSpanRincianBelanja' => $isiSpanRincianBelanja,'isiActionSpan' => $isiActionSpan);

			break;
			}
			case 'editRekening':{
					foreach ($_REQUEST as $key => $value) {
						$$key = $value;
					}
					if(empty($c1)){
							$err = "Pilih Urusan";
					}elseif(empty($c)){
							$err = "Pilih Bidang";
					}elseif(empty($d)){
							$err = "Pilih SKPD";
					}
					$getData = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_anggaran'"));
					foreach ($getData as $key => $value) {
						$$key = $value;
					}
					$getNamaRekening  = mysql_fetch_array(mysql_query("select * from ref_rekening where k ='$k' and l ='$l' and m='$m' and n='$n' and o = '$o'"));
					$namaRekening = $getNamaRekening['nm_rekening'];
					$concatRekening = $k.".".$l.".".$m.".".$n.".".$o;
					$isiSpanRekening = "<input type='hidden' name='hiddenRekening$id_anggaran' id = 'hiddenRekening$id_anggaran' value='$concatRekening' ><input type='text' name='textRekening$id_anggaran' id = 'textRekening$id_anggaran' value= '$namaRekening' readonly style='width:80%;'> &nbsp <img src='datepicker/search.png'  onclick=$this->Prefix.findRekening($id_anggaran); style='width:20px;height:20px;margin-bottom:-5px; cursor:pointer;'>";
					$isiActionSpan = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.saveEditRekening($id_anggaran);></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.refreshList(true);></img> ";
					$arrayResult = VulnWalkerTahap_v2("RKA");
					$jenisForm = $arrayResult['jenisForm'];
					$nomorUrut = $arrayResult['nomorUrut'];
					$tahun = $arrayResult['tahun'];
					$jenisAnggaran = $arrayResult['jenisAnggaran'];
					$query = $arrayResult['query'];

					if($jenisForm !="PENYUSUNAN")$err = "Data telah di posting !";
					$content = array('isiSpanRekening' => $isiSpanRekening,'isiActionSpan' => $isiActionSpan);

			break;
			}

			case 'saveEditRekening':{
					foreach ($_REQUEST as $key => $value) {
						$$key = $value;
					}

					$getOldRekening = mysql_fetch_array(mysql_query("select * from view_rka_1 where id_anggaran	 = '$id'"));
					$oldKodeRekening = $getOldRekening['k'].".".$getOldRekening['l'].".".$getOldRekening['m'].".".$getOldRekening['n'].".".$getOldRekening['o'];
					$explodeNewKodeRekening = explode(".",$kodeRekening);
					$concatKondisi = $c1.".".$c.".".$d.".".$getOldRekening['bk'].".".$getOldRekening['ck'].".".$getOldRekening['dk'].".".$getOldRekening['p'].".".$getOldRekening['q'].".".$getOldRekening['k'].".".$getOldRekening['l'].".".$getOldRekening['m'].".".$getOldRekening['n'].".".$getOldRekening['o'];
					$concatKondisiNew = $getOldRekening['bk'].".".$getOldRekening['ck'].".".$getOldRekening['dk'].".".$getOldRekening['p'].".".$getOldRekening['q'].".".$explodeNewKodeRekening[0].".".$explodeNewKodeRekening[1].".".$explodeNewKodeRekening[2].".".$explodeNewKodeRekening[3].".".$explodeNewKodeRekening[4];
					$dataUpdate = array(
																	'k' => $explodeNewKodeRekening[0],
																	'l' => $explodeNewKodeRekening[1],
																	'm' => $explodeNewKodeRekening[2],
																	'n' => $explodeNewKodeRekening[3],
																	'o' => $explodeNewKodeRekening[4],
															);
					$query = VulnWalkerUpdate("tabel_anggaran",$dataUpdate," concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',k,'.',l,'.',m,'.',n,'.',o) = '$concatKondisi' and id_tahap = '$this->idTahap' ");
					mysql_query($query);
					$cek.=$query;

					if(mysql_num_rows(mysql_query("select * from view_rka_1 where c1 = '0' and concat(bk,'.',ck,'.',dk,'.',p,'.',q,'.',k,'.',l,'.',m,'.',n,'.',o) = '$concatKondisiNew'")) == 0){
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
												'bk' => $getOldRekening['bk'],
												'ck' => $getOldRekening['ck'],
												'dk' => $getOldRekening['dk'],
												'p' => $getOldRekening['p'],
												'q' => $getOldRekening['q'],
												'k' => $explodeNewKodeRekening[0],
												'l' => $explodeNewKodeRekening[1],
												'm' => $explodeNewKodeRekening[2],
												'n' => $explodeNewKodeRekening[3],
												'o' => $explodeNewKodeRekening[4],
												'jenis_rka' => '1',
												'tahun' => $this->tahun,
												'jenis_anggaran' => $this->jenisAnggaran,
												'id_tahap' => $this->idTahap,
												'nama_modul' => 'RKA-SKPD',
												'sumber_dana' => "APBD",
												'id_rincian_belanja' => ''
												);
							$queryRekening = VulnWalkerInsert("tabel_anggaran",$arrayRekening);
							mysql_query($queryRekening);
							$cek.=" input rekening ".$queryRekening;
					}







			break;
			}

			case 'editSubRincian':{
					foreach ($_REQUEST as $key => $value) {
						$$key = $value;
					}
					$getData = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id'"));
					foreach ($getData as $key => $value) {
						$$key = $value;
					}
					// $kuantitas = $volume_rek / $jumlah1;



					$inputanVolume = "<input style='width:25px;  text-align:right;' placeholder='VOLUME'  type='text' name='volumeRek$id' value='$volume_rek' id='volumeRek$id' onkeypress='return event.charCode >= 48 && event.charCode <= 57' readonly > &nbsp <input type='button' value='Detail Volume' onclick=$this->Prefix.formRincianVolume($id);>
					<input type='hidden' name='volume1Temp$id' id='volume1Temp$id' value='".$this->nullChecker($jumlah1)."'>
					<input type='hidden' name='volume2Temp$id' id='volume2Temp$id' value='".$this->nullChecker($jumlah2)."'>
					<input type='hidden' name='volume3Temp$id' id='volume3Temp$id' value='".$this->nullChecker($jumlah3)."'>
					<input type='hidden' name='satuan1Temp$id' id='satuan1Temp$id' value='$satuan1'>
					<input type='hidden' name='satuan2Temp$id' id='satuan2Temp$id' value='$satuan2'>
					<input type='hidden' name='satuan3Temp$id' id='satuan3Temp$id' value='$satuan3'>
					<input type='hidden' name ='rincianVolume$id' id='rincianVolume$id'  value='$rincian_volume'>";

					if(!empty($satuan_total)){
							$satuanRek = $satuan_total;
					}else{
							$satuanRek = $satuan1;
					}
					$eventKeyup = 'document.getElementById("formatjumlah'.$id.'").innerHTML = rkaSKPD1DP.formatCurrency(this.value); ';
					$inputanSatuan = "<input style='width:100%;  text-align:left;'   type='text' name='satuanRek$id' value='$satuanRek' id='satuanRek$id'  readonly > ";
					$inputanSatuanHarga = "<input style='width:80%;  text-align:right;' placeholder='JUMLAH'  type='text' name='hargaSatuan$id' value='".$this->removeKoma($jumlah)."' id='hargaSatuan$id' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$eventKeyup'> <span id='formatjumlah$id'>  ";

					$isiActionSpan = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.saveEditSubRincian($id_anggaran);></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.refreshList(true);></img> ";

					$arrayResult = VulnWalkerTahap_v2("RKA");
					$jenisForm = $arrayResult['jenisForm'];
					$nomorUrut = $arrayResult['nomorUrut'];
					$tahun = $arrayResult['tahun'];
					$jenisAnggaran = $arrayResult['jenisAnggaran'];
					$query = $arrayResult['query'];

					if($jenisForm !="PENYUSUNAN")$err = "Data telah di posting !";

					$content = array('isiSpanVolume' => $inputanVolume, 'isiSpanSatuan' => $inputanSatuan, 'isiSpanHargaSatuan' => $inputanSatuanHarga,'isiActionSpan' => $isiActionSpan);

			break;
			}
			case 'editRincianBelanja':{
					foreach ($_REQUEST as $key => $value) {
						$$key = $value;
					}
					$getData = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '$id'"));
					foreach ($getData as $key => $value) {
						$$key = $value;
					}

					$isiSpanRincianBelanja = "<input type='text' name='textRincianBelanja$id_anggaran' id = 'textRincianBelanja$id_anggaran' value= '$nama_rincian_belanja' style='width:90%;'>";
					$isiActionSpan = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.saveEditRincianBelanja($id_anggaran,$id);></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.refreshList(true);></img> ";
					$arrayResult = VulnWalkerTahap_v2("RKA");
					$jenisForm = $arrayResult['jenisForm'];
					$nomorUrut = $arrayResult['nomorUrut'];
					$tahun = $arrayResult['tahun'];
					$jenisAnggaran = $arrayResult['jenisAnggaran'];
					$query = $arrayResult['query'];

					if($jenisForm !="PENYUSUNAN")$err = "Data telah di posting !";
					$content = array('isiSpanRincianBelanja' => $isiSpanRincianBelanja,'isiActionSpan' => $isiActionSpan);

			break;
			}
			case 'editRekening':{
					foreach ($_REQUEST as $key => $value) {
						$$key = $value;
					}
					if(empty($c1)){
							$err = "Pilih Urusan";
					}elseif(empty($c)){
							$err = "Pilih Bidang";
					}elseif(empty($d)){
							$err = "Pilih SKPD";
					}
					$getData = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_anggaran'"));
					foreach ($getData as $key => $value) {
						$$key = $value;
					}
					$getNamaRekening  = mysql_fetch_array(mysql_query("select * from ref_rekening where k ='$k' and l ='$l' and m='$m' and n='$n' and o = '$o'"));
					$namaRekening = $getNamaRekening['nm_rekening'];
					$concatRekening = $k.".".$l.".".$m.".".$n.".".$o;
					$isiSpanRekening = "<input type='hidden' name='hiddenRekening$id_anggaran' id = 'hiddenRekening$id_anggaran' value='$concatRekening' ><input type='text' name='textRekening$id_anggaran' id = 'textRekening$id_anggaran' value= '$namaRekening' readonly style='width:80%;'> &nbsp <img src='datepicker/search.png'  onclick=$this->Prefix.findRekening($id_anggaran); style='width:20px;height:20px;margin-bottom:-5px; cursor:pointer;'>";
					$isiActionSpan = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.saveEditRekening($id_anggaran);></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.refreshList(true);></img> ";
					$arrayResult = VulnWalkerTahap_v2("RKA");
					$jenisForm = $arrayResult['jenisForm'];
					$nomorUrut = $arrayResult['nomorUrut'];
					$tahun = $arrayResult['tahun'];
					$jenisAnggaran = $arrayResult['jenisAnggaran'];
					$query = $arrayResult['query'];

					if($jenisForm !="PENYUSUNAN")$err = "Data telah di posting !";
					$content = array('isiSpanRekening' => $isiSpanRekening,'isiActionSpan' => $isiActionSpan);

			break;
			}


		case 'setGrup':{
				foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 	}


				if(mysql_num_rows(mysql_query("select * from tabel_anggaran where o1 = '$pekerjaan' and id_tahap = '$this->idTahap' and jenis_rka = '1' and nama_modul ='RKA-SKPD'")) == 0){
					$data = array(
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
												 'k' => '0',
												 'l' => '0',
												 'm' => '0',
												 'n' => '0',
												 'o' => '0',
												 'o1' => $pekerjaan,
												 'jenis_rka' => '1',
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'id_tahap' => $this->idTahap,
												 'nama_modul' => 'RKA-SKPD'
													);
					mysql_query(VulnWalkerInsert('tabel_anggaran',$data));
				}
				if(strpos($anggota, ',') !== false) {
				    $arrayRekening = explode(',',$anggota);
					$huge = sizeof($arrayRekening);

					for($i = 0 ; $i < $huge; $i++){

						$id_rekening =  $arrayRekening[$i];
						$getRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_rekening'"));
						/*foreach ($getRekening as $key => $value) {
						  $$key = $value;
					 	}*/

						$data = array('o1' => $pekerjaan);
						$query = VulnWalkerUpdate('tabel_anggaran',$data," k='".$getRekening['k']."' and l='".$getRekening['l']."' and m='".$getRekening['m']."' and n='".$getRekening['n']."' and o='".$getRekening['o']."' and id_tahap = '$this->idTahap'");
						mysql_query($query);

					}
				}else{
						$id_rekening =  $anggota;
						$getRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_rekening'"));
						foreach ($getRekening as $key => $value) {
						  $$key = $value;
					 	}

						$data = array('o1' => $pekerjaan);
						$query = VulnWalkerUpdate('tabel_anggaran',$data," k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$this->idTahap'");
						$content = "2";
						mysql_query($query);
				}




		break;
		}
		case 'SaveEditJob':{
			$username = $_COOKIE['coID'];
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			 $getMaxLeftUrut = mysql_fetch_array(mysql_query("select left_urut  from ref_pekerjaan where  id ='$o1'"));
			 $left_urut = $getMaxLeftUrut['left_urut'];

			 $data = array( 'nama_pekerjaan' => $namaPekerjaan

			 				);
			 $query = VulnWalkerUpdate("ref_pekerjaan",$data,"id = '$pekerjaan'");

			 if(empty($namaPekerjaan)){
			 	$err = "input gagal";
			 }else{
				$execute = mysql_query($query);
			 }
			$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan  ";
			$getCurrentInsert = mysql_fetch_array(mysql_query("select max(id) from ref_pekerjaan "));
			$cmbPekerjaan = cmbQuery('pekerjaan', $getCurrentInsert['max(id)'], $codeAndNamePekerjaan,"  ",'-- PEKERJAAN --');

			$getUrut = mysql_fetch_array(mysql_query("select * from temp_rka_221 where o1='$o1'"));
			$urut = $getUrut['urut'];

			$content = array('cmbPekerjaan' => $cmbPekerjaan, 'left_urut' => $left_urut, 'urut' => $urut, 'query' => "select left_urut , urut as urut from ref_pekerjaan where  id ='$o1'" );
		break;
	    }
		case 'editJob':{
				$dt = $_REQUEST['pekerjaan'];
				$fm = $this->editJob($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}

		case 'Gruping':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			if(!isset($rkaSKPD1DP_cb)){
				$err = "Pilih Data";
			}
			$dt = implode(',',$rkaSKPD1DP_cb);
			if($this->jenisForm !='PENYUSUNAN')$err = "Tahap Penyusunan Telah Habis";
				 if($err == ''){
						$fm = $this->Gruping($dt);
						$cek = $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
				 }

		break;
		}

		case 'newJob':{
				$fm = $this->newJob($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'SaveJob':{
			$username = $_COOKIE['coID'];
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }


			 $data = array( 'nama_pekerjaan' => $namaPekerjaan
			 				);
			 $query = VulnWalkerInsert("ref_pekerjaan",$data);

			 if(empty($namaPekerjaan)){
			 	$err = "input gagal";
			 }else{
				$execute = mysql_query($query);
			 }
			$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan ";
			$getCurrentInsert = mysql_fetch_array(mysql_query("select max(id) from ref_pekerjaan"));
			$cmbPekerjaan = cmbQuery('pekerjaan', $getCurrentInsert['max(id)'], $codeAndNamePekerjaan,"  ",'-- PEKERJAAN --');
			$getMaxUrut = mysql_fetch_array(mysql_query("select max(urut) from temp_rka_221 where user ='$username'"));
			$urut = $getMaxUrut['max(urut)'] + 1;
			$content = array('cmbPekerjaan' => $cmbPekerjaan, 'left_urut' => $left_urut, 'urut' => $urut );
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
			}else{
				if(mysql_num_rows(mysql_query("select * from skpd_report_rka_21 where username= '$this->username'")) == 0){
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD

								  );
					$query = VulnWalkerInsert('skpd_report_rka_21',$data);
					mysql_query($query);
				}else{
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD


								  );
					$query = VulnWalkerUpdate('skpd_report_rka_21',$data,"username = '$this->username'");
					mysql_query($query);
				}

			}
		break;
		}
		case 'Laporan':{
			$json = FALSE;
			$this->Laporan();
		break;
		}
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
			}elseif(empty($cmbJenisRKA)){
				$err = "Pilih Jenis RKA";
			}else{
				$fm = $this->setFormBaru();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			}


		break;
		}
		case 'Info':{
				$fm = $this->Info();
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'clearTemp':{
				$username =$_COOKIE['coID'];
				mysql_query("delete from temp_rekening_rka_pendapatan_dp where username ='$username'");
				mysql_query("delete from temp_rincian_pendapatan_dp where username ='$username'");
				mysql_query("delete from temp_sub_rincian_pendapatan_dp where username ='$username'");
				mysql_query("delete from temp_remove_rka_1_dp where username ='$username'");
				foreach ($_REQUEST as $key => $value) {
			 	 $$key = $value;
				}
				$getALlData = mysql_query("select * from view_rka_1 where id_tahap = '$this->idTahap' and c1 ='$cmbUrusan' and c ='$cmbBidang' and d='$cmbSKPD' and bk ='0' and ck='0' and dk='0' and p='0' and q='0' and rincian_perhitungan !='' and id_rincian_belanja !='' $this->kondisiRekening");
				while ($rows = mysql_fetch_array($getALlData)) {
						foreach ($rows as $key => $value) {
								$$key = $value;
						}
						$getMyIdRekening = mysql_fetch_array(mysql_query("select * from view_rka_1 where id_tahap = '$this->idTahap' and bk ='0' and ck='0' and dk='0' and p='0' and q='0' and k='$k'  and l ='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja ='' and rincian_perhitungan = '' "));
						$getDataRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '".$getMyIdRekening['id_anggaran']."'"));
						if(mysql_num_rows(mysql_query("select * from temp_rekening_rka_pendapatan_dp where username = '$this->username' and k='$k'  and l ='$l' and m='$m' and n='$n' and o='$o'")) == 0){
								$dataRekening = array(
																				'k'=> $k,
																				'l'=> $l,
																				'm'=> $m,
																				'n'=> $n,
																				'o'=> $o,
																				'username' => $this->username,
																				'sumber_dana' => $getDataRekening['sumber_dana'],
																				'id_anggaran' => $getDataRekening['id_anggaran']
								);
								$queryRekening = VulnWalkerInsert('temp_rekening_rka_pendapatan_dp',$dataRekening);
								mysql_query($queryRekening);
						}

						$getMyIdRincianBelanja = mysql_fetch_array(mysql_query("select * from view_rka_1 where id_tahap = '$this->idTahap' and c1='$c1' and c='$c' and d='$d' and bk ='0' and ck='0' and dk='0' and p='0' and q='0' and k='$k'  and l ='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja ='$id_rincian_belanja' and rincian_perhitungan = '' "));
						$getDataRincianBelanja =  mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '".$getMyIdRincianBelanja['id_anggaran']."'"));
						$getUraianRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '".$getDataRincianBelanja['id_rincian_belanja']."'"));
						$getIdRekeningBelanja = mysql_fetch_array(mysql_query("select * from temp_rekening_rka_pendapatan_dp where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and username = '$this->username'"));
						if(mysql_num_rows(mysql_query("select * from temp_rincian_pendapatan_dp where username = '$this->username' and id_rekening_belanja = '".$getIdRekeningBelanja['id']."' and uraian = '".$getUraianRincianBelanja['nama_rincian_belanja']."'")) == 0){
								$dataRincianBelanja = array(

																				'id_rekening_belanja'=> $getIdRekeningBelanja['id'],
																				'uraian'=> $getUraianRincianBelanja['nama_rincian_belanja'],
																				'username' => $this->username,
																				'id_anggaran' => $getDataRincianBelanja['id_anggaran']
								);
								$queryRincianBelanja = VulnWalkerInsert('temp_rincian_pendapatan_dp',$dataRincianBelanja);
								mysql_query($queryRincianBelanja);
						}
						$getUplineRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '$id_rincian_belanja'"));
						$getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from temp_rincian_pendapatan_dp where username = '$this->username' and uraian = '".$getUplineRincianBelanja['nama_rincian_belanja']."'"));

						$getDataCurrentID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_anggaran'"));


						$dataSubRincian = array(
																			'id_rincian_belanja' => $getIdRincianBelanja['id'],
																			'uraian' => $rincian_perhitungan,
																			'f1' => $f1,
																			'f2' => $f2,
																			'f' => $f,
																			'g' => $g,
																			'h' => $h,
																			'i' => $i,
																			'j' => $j,
																			'harga_satuan' => $jumlah,
																			'volume1' => $this->checkKosong($getDataCurrentID['jumlah1']),
																			'volume2' => $this->checkKosong($getDataCurrentID['jumlah2']),
																			'volume3' => $this->checkKosong($getDataCurrentID['jumlah3']),
																			'rincian_volume' => $rincian_volume,
																			'satuan1' => $getDataCurrentID['satuan1'],
																			'satuan2' => $getDataCurrentID['satuan2'],
																			'satuan3' => $getDataCurrentID['satuan3'],
																			'username' => $this->username,
																			'id_anggaran' => $id_anggaran,
																			'urutan_posisi' => $getDataCurrentID['urutan_posisi']
																		);
						$querySubRincian = VulnWalkerInsert("temp_sub_rincian_pendapatan_dp",$dataSubRincian);
						mysql_query($querySubRincian);

				}



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

		case 'simpan':{
			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }

		case 'sesuai':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
			$getrkaSKPD1DPnya = mysql_fetch_array(mysql_query($queryRows));
			foreach ($getrkaSKPD1DPnya as $key => $value) {
				  $$key = $value;
			}
			$cmbUrusanForm = $c1;
			$cmbBidangForm = $c;

			$cekUrusan =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='00' and d = '00' and e='00' and e1='000'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'"));
					if($cekUrusan > 0 ){

					}else{
						$data = array(
									    'c1' => $cmbUrusanForm,
										'c' => '00',
										'd' => '00',
										'e' => '00',
										'e1' => '000',
										'bk' => '0',
										'ck' => '0',
										'p' => '0',
										'q' => '0',
										'id_tahap' => $this->idTahap,
										'jenis_anggaran' => $this->jenisAnggaran,
										'tahun' => $this->tahun,
										"nama_modul" => $this->modul
										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= "mampir";
						mysql_query($query)	;
					}

					$cekBidang =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '00' and e='00' and e1='000'  and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					if($cekBidang > 0 ){

					}else{
						$data = array(
									    'c1' => $cmbUrusanForm,
										'c'  => $cmbBidangForm,
										'd'  => '00',
										'e'  => '00',
										'e1' => '000',
										'bk' => '0',
										'ck' => '0',
										'p' => '0',
										'q' => '0',
										'id_tahap' => $this->idTahap,
										'jenis_anggaran' => $this->jenisAnggaran,
										'tahun' => $this->tahun,
										"nama_modul" => $this->modul

										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= $query;
						mysql_query($query)	;
					}


			$dataSesuai = array("tahun" => $tahun,
								"c1" => $c1,
								"c" => $c,
								"d" => $d,
								"e" => $e,
								"e1" => $e1,
								"p" => '0',
								"q" => '0',
								"bk" => '0',
								"ck" => '0',
								'jumlah' => $jumlah,
								'id_tahap' => $this->idTahap,
								'jenis_anggaran' => $this->jenisAnggaran,
								'tahun' => $this->tahun,
								"nama_modul" => $this->modul

 								);
			$cekSKPD =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='00' and e1='000'  and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					if($cekSKPD > 0 ){
						$getID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='00' and e1='000'  and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					    $idnya = $getID['id_anggaran'];
						mysql_query("update tabel_anggaran set jumlah = '$jumlah' where id_anggaran='$idnya'");
					}else{
						mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));
						$content .=VulnWalkerInsert("tabel_anggaran", $dataSesuai);
					}


			/*$content = array("query" => $query, "sesuai" => number_format($jumlah,2,',','.'), "QUERY ROWS" => $queryData);*/

		break;
	    }

		case 'koreksi':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
			$getrkaSKPD1DPnya = mysql_fetch_array(mysql_query($queryRows));
			foreach ($getrkaSKPD1DPnya as $key => $value) {
				  $$key = $value;
			}

			 $hasilKali = $koreksiSatuanHarga * $koreksiVolumebarang ;
			 if($this->jenisForm !='KOREKSI'){
			 	$err = "Tahap Koreksi Talah Habis";
			 }else{
			 /*	if(isset($jenisAlokasi) && !empty($jenisAlokasi)){
							$alokasi_jan = $_REQUEST['jan'];
							$alokasi_feb = $_REQUEST['feb'];
							$alokasi_mar = $_REQUEST['mar'];
							$alokasi_apr = $_REQUEST['apr'];
							$alokasi_mei = $_REQUEST['mei'];
							$alokasi_jun = $_REQUEST['jun'];
							$alokasi_jul = $_REQUEST['jul'];
							$alokasi_agu = $_REQUEST['agu'];
							$alokasi_sep = $_REQUEST['sep'];
							$alokasi_okt = $_REQUEST['okt'];
							$alokasi_nop = $_REQUEST['nop'];
							$alokasi_des = $_REQUEST['des'];
							$jenis_alokasi_kas = $_REQUEST['jenisAlokasi'];
							if(empty($jenisAlokasi)){
									$err = "Pilih jenis alokasi";
								}elseif($jenisAlokasi == 'BULANAN'){
									if( $jan == '' || $feb == '' || $mar == '' || $apr == '' || $mei == '' || $jun == '' || $jul == '' || $agu == '' || $sep == '' || $okt == '' || $nop == '' || $des == ''   ){
										$err = "Lengkapi alokasi";
									}

								}elseif($jenisAlokasi == 'TRIWULAN'   ){
									if( $mar == '' ||  $jun == '' ||  $sep == '' ||  $des == ''   ){
										$err = "Lengkapi alokasi";
									}
								}elseif($jumlahHargaAlokasi != $jumlahHarga){
									$err = "Jumlah Alokasi Salah ";
								}else{
									//mysql_query($query);
								}
						}*/
			 	if($err == ""){
				 	if(mysql_num_rows(mysql_query("select * from view_rka_1 where  o1='$o1' and rincian_perhitungan='' and rincian_perhitungan ='' and id_tahap='$this->idTahap' ")) > 0){

						 }else{
							$arrayPekerjaan = array(
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
												 'k' => '0',
												 'l' => '0',
												 'm' => '0',
												 'n' => '0',
												 'o' => '0',
												 'o1' => $o1,
												 'jenis_rka' => '1',
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'id_tahap' => $this->idTahap,
												 'nama_modul' => 'RKA-SKPD'
												);
							$queryPekerjaan = VulnWalkerInsert('tabel_anggaran',$arrayPekerjaan);
							mysql_query($queryPekerjaan);
					}

				 	if(mysql_num_rows(mysql_query("select * from view_rka_1 where  rincian_perhitungan ='' and c1='0' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap='$this->idTahap'  ")) > 0){

					 }else{
						$data = array(
										"tahun" => $tahun,
										"c1" => '0',
										"c" => '00',
										"d" => '00',
										"e" => '00',
										"e1" => '000',
										"bk" => '0',
										"ck" => '0',
										"dk" => '0',
										"p" => '0',
										"q" => '0',
										"f1" => '0',
										"f2" => '0',
										"f" => '00',
										"g" => '00',
										"h" => '00',
										"i" => '00',
										"j" => '000',
										"k" => $k,
										"l" => $l,
										"m" => $m,
										"n" => $n,
										"o" => $o,
										'o1' => $o1,
										"jenis_rka" => '1',
										"jenis_anggaran" => $this->jenisAnggaran,
										"id_tahap" => $this->idTahap,
										"nama_modul" => $this->modul,
										"user_update" => $_COOKIE['coID'],
										"tanggal_update" => date("Y-m-d")

									);
							$query = VulnWalkerInsert('tabel_anggaran',$data);
							mysql_query($query);
					 }

					 $dataSesuai = array("tahun" => $tahun,
										 "c1" => $c1,
										 "c" => $c,
										 "d" => $d,
										 "e" => $e,
										 "e1" => $e1,
										 "f" => $f,
										 "g" => $g,
										 "h" => $h,
										 "i" => $i,
										 "j" => $j,
										 "id_jenis_pemeliharaan" => $id_jenis_pemeliharaan,
										 "uraian_pemeliharaan" => $uraian_pemeliharaan,
										 "k" => $k,
										 "l" => $l,
										 "m" => $m,
										 "n" => $n,
										 "o" => $o,
										 "o1" => $o1,
										 "rincian_perhitungan" => $rincian_perhitungan,
										 "jumlah" => $koreksiSatuanHarga,
										 "volume_rek" => $koreksiVolumebarang,
										 "satuan_rek" => $satuan_rek,
										 "jumlah_harga" => $hasilKali,
										 "jenis_anggaran" => $this->jenisAnggaran,
										 "jenis_rka" => '1',
										 "id_tahap" => $this->idTahap,
										 "nama_modul" => $this->modul,
										 "user_update" => $_COOKIE['coID'],
										 "tanggal_update" => date("Y-m-d"),

		 								);

					$cekRKA =  mysql_num_rows(mysql_query("select * from view_rka_1 where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1'  and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' and o1='$o1' and rincian_perhitungan = '$rincian_perhitungan'"));
							if($cekRKA > 0 ){
								$getID = mysql_fetch_array(mysql_query("select * from view_rka_1 where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1'  and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1 !='0' and rincian_perhitungan !='' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
							    $idnya = $getID['id_anggaran'];
								mysql_query(VulnWalkerUpdate("tabel_anggaran", $dataSesuai, "id_anggaran = '$idnya'"));
							}else{
								mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));
								$content.=VulnWalkerInsert("tabel_anggaran", $dataSesuai);
							}
			 }
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



			 $data = array( "status_validasi" => $status_validasi,
			 				'user_validasi' => $_COOKIE['coID'],
			 				'tanggal_validasi' => date("Y-m-d"),
							'id_tahap' => $this->idTahap
			 				);
			 $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$rkaSKPD1DP_idplh'");
			 mysql_query($query);

			$content .= $query;
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


		case 'editTab':{
			$id = $_REQUEST['rkaSKPD1DP_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			$username = $_COOKIE['coID'];

			$get = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$id[0]'"));
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;

			$getAll = mysql_query("select * from view_rka_1 where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and rincian_perhitungan !=''   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and status_validasi !='1'  order by o1, rincian_perhitungan");
			mysql_query("delete from temp_rka_21 where user='$username'");
			mysql_query("delete from temp_rincian_volume_21 where user='$username'");
		    mysql_query("delete from temp_alokasi_rka_21_v2 where user='$username'");
			$noUrutPekerjaan = 0;
			$angkaO2 = 0;
			$lastO1 = 0;
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) {
				  $$key = $value;
				}
				$getMaxID = mysql_fetch_array(mysql_query("select  max(id) as gblk from temp_rka_21 where user ='$username'"));
				$maxID = $getMaxID['gblk'];
				$lastO1 = $o1;

				$getLastO1 = mysql_fetch_array(mysql_query("select o1 from temp_rka_21 where id='$maxID' "));
				if($getLastO1['o1'] != $lastO1){
					$noUrutPekerjaan = $noUrutPekerjaan + 1;
					if($o1 == '0'){
						$noUrutPekerjaan = 0;
					}
					$angkaO2 = 1;
				}


				$data = array(
								'c1' => $c1,
								'c' => $c,
								'd' => $d,
								'e' => $e,
								'e1' => $e1,
								'f' => $f,
								'g' => $g,
								'h' => $h,
								'i' => $i,
								'j' => $j,
								'k' => $k,
								'l' => $l,
								'm' => $m,
								'n' => $n,
								'o' => $o,
								'o1' => $o1,
								'volume_rek' => $volume_rek,
								'satuan' => $satuan_rek,
								'user' => $username,
								'rincian_perhitungan' => $rincian_perhitungan,
								'harga_satuan' => $jumlah,
								'jumlah_harga' => $jumlah_harga,

								'id_awal' => $id_anggaran
								);
				$query = VulnWalkerInsert('temp_rka_21',$data);
				mysql_query($query);
				$angkaO2 = $angkaO2 + 1;

			}

				$content = array('kodeRek' => $kodeRek);
			break;
		}

		case 'Remove':{
			$id = $_REQUEST['rkaSKPD1DP_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			$username = $_COOKIE['coID'];

			$get = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$id[0]'"));
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;

			$getAll = mysql_query("select * from view_rka_1 where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and rincian_perhitungan !=''   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and status_validasi !='1' order by o1, rincian_perhitungan");
			mysql_query("delete from temp_rka_21 where user='$username'");
			mysql_query("delete from temp_rincian_volume_21 where user='$username'");
		    mysql_query("delete from temp_alokasi_rka_21_v2 where user='$username'");
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) {
				  $$key = $value;
				}
				mysql_query("delete from tabel_anggaran where id_anggaran = '$id_anggaran'");
				//mysql_query("delete from tabel_anggaran where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and o1 ='$o1' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and jenis_rka='1' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'");

			}

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


		 case 'Catatan':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			$getData = mysql_fetch_array(mysql_query("SELECT * FROM tabel_anggaran WHERE id_anggaran = '$idAwal'"));
			foreach ($getData as $key => $value) {
				  $$key = $value;
			}
			$getMaxID = mysql_fetch_array(mysql_query("select max(id_anggaran) as maxID from tabel_anggaran where tahun = '$tahun'  and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$p' and q='$q' and jenis_anggaran = '$jenis_anggaran'  "));
			$maxID = $getMaxID['maxID'];
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

		case 'formAlokasi':{
				$dt[] = $_REQUEST['jumlahHarga'];
				$dt[] = $_REQUEST['id'];
				$fm = $this->formAlokasi($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


		break;
		}
		case 'formAlokasiTriwulan':{
				$jumlahHargaForm = $_REQUEST['jumlahHarga'];
				$id = $_REQUEST['id'];
				$fm = $this->formAlokasiTriwulan($dt);
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
	 function setPage_HeaderOther(){

	 return
	 "<table width=\"100%\" class=\"menubar\" celldpding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	 <tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	 <A href=\"pages.php?Pg=rkaSKPD221\" title='BELANJA'  > BELANJA </a> |
	 <A href=\"pages.php?Pg=rkaSKPD1DP\" title='PENDAPATAN'  style='color:blue;'> PENDAPATAN </a> |
	 <A href=\"pages.php?Pg=rkaSKPD31\" title='RKA-SKPKD MURNI' > PEMBIAYAAN </a> |
	 <A href=\"pages.php?Pg=rkaSKPD\" title='RKA-SKPKD MURNI' > REKAP  </a>

	 &nbsp&nbsp&nbsp
	 </td></tr>

	 <tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	 <A href=\"pages.php?Pg=rkaSKPD1PAD\" title='PENDAPATAN ASLI DAERAH'  > PENDAPATAN ASLI DAERAH </a> |
	 <A href=\"pages.php?Pg=rkaSKPD1DP\" title='DANA PERIMBANGAN' style='color:blue;' > DANA PERIMBANGAN </a> |
	 <A href=\"pages.php?Pg=rkaSKPD1LP\" title='LAIN LAIN PENDAPATAN' > LAIN LAIN PENDAPATAN </a> 

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
			<script type='text/javascript' src='js/popup_rekening/popupRekening.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/rka/rkaSKPD1DP.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/rka/rkaSKPD1PADNew.js' language='JavaScript' ></script>
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
	 $this->form_caption = 'INFO RKA';


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
		 $arrayJenisRKA = array(
						array("1 DP","RKA-SKPD 1 DP"),
						array("1 DP","RKA-SKPD 1 DP")

						);
		 $jenis_rka = $jenis_rka;
		 $cmbJenisRKA = cmbArray('cmbJenisRKAForm',$jenis_rka,$arrayJenisRKA,'-- JENIS RKA --','onchange=rkaSKPD1DP.unlockFindRekening();');
	 	 if(empty($jenis_rka)){
		 	$tergantungJenis = "disabled";
		 }

		 $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
		 $getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and id_tahap = '$idTahapRenja' "));
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
						'label'=>'JENIS RKA',
						'labelWidth'=>150,
						'value'=> $cmbJenisRKA,
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
						 <button type='button' id='findRekening' onclick=rkaSKPD1DP.findRekening('$jenis_rka'); $tergantungJenis> CARI </button> "
						 ),
			'kode8' => array(
						'label'=>'HARGA SATUAN',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='rkaSKPD1DP.bantu();' > <span id='bantu' style='color:red;'> </span>"
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


	 if($this->jenisForm == "PENYUSUNAN"){
	 	if($this->wajibValidasi == TRUE)$tergantung = "<th class='th01' rowspan='2' width='100' >VALIDASI</th>";
		$headerTable =
		  "<thead>
		   <tr>

		   <th class='th01' width='100'  rowspan='2' >KODE REKENING </th>
		   <th class='th01' width='600'  rowspan='2' >URAIAN</th>
		   <th class='th02' colspan='3'  rowspan='1' width='900' >RINCIAN PENGHITUNGAN</th>
		   <th class='th01' width='120'  rowspan='2' >JUMLAH HARGA</th>

		   $tergantung

		   </tr>
		   <tr>
		   <th class='th01' width='120'  >VOLUME</th>
		   <th class='th01' >SATUAN</th>
		   <th class='th01' >HARGA SATUAN</th>


		   </tr>

		   </thead>";
	 }else{

		if($this->wajibValidasi == TRUE)$tergantung = "<th class='th01' rowspan='2' width='100' >VALIDASI</th>";
		$headerTable =
		  "<thead>
		   <tr>

		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='500'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='4'  rowspan='1' width='1000' >RINCIAN PENGHITUNGAN</th>
		   $tergantung

		   </tr>
		   <tr>

		   <th class='th01' >VOLUME</th>
		   <th class='th01' >SATUAN</th>
		   <th class='th01' >HARGA SATUAN</th>
		   <th class='th01' >JUMLAH</th>

		   </tr>
		   </thead>";

	 }
	 $NomorColSpan = $Mode==1? 2: 1;


		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) {
		  			$$key = $value;
	 }
	 foreach ($_REQUEST as $key => $value) {
		  			$$key = $value;
	 }
	 	if($cmbSubUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
		}elseif($cmbUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
		}elseif($cmbSKPD != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
		}elseif($cmbBidang != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
		}elseif($cmbUrusan != ''){
			$kondisiSKPD = "and c1='$cmbUrusan'";
		}

		$Koloms = array();
		// if( !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && empty($id_rincian_belanja) ){
		// 		 //Rekening
		// 		 $boldStatus = "bold";
		// 		 $marginStatus = "0px;";
		// 		 $kode = $k.".".$l.".".$m.".".$n.".".$o;
		// 		 $marginKode = "10px;";
		// 		 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
		// 		 $uraianList = $getNamaRekening['nm_rekening'];
		// 		 $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiRekening"));
		// 		 $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
		// 		 $TampilCheckBox = "";
		// }elseif( !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && empty($rincian_perhitungan)){
		// 		 //RincianBelanja
		// 		 $boldStatus = "";
		// 		 $marginStatus = "10px;";
		// 		 $kode = "";
		// 		 $getNamaRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '$id_rincian_belanja'"));
		// 		 $uraianList = $getNamaRincianBelanja['nama_rincian_belanja'];
		// 		 $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja='$id_rincian_belanja' $kondisiSKPD $kondisiRekening"));
		// 		 $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
		// 		 $TampilCheckBox = "";
		// }elseif( !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && !empty($rincian_perhitungan) ){
		// 		 //SubRincianBelanja
		// 		 $boldStatus = "";
		// 		 $marginStatus = "20px;";
		// 		 $kode = "";
		// 		 if($j !='000'){
		// 			 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
		// 			 $uraianList = " - ".$getNamaBarang['nm_barang'];
		// 		 }else{
		// 			 $uraianList = " - ".$rincian_perhitungan;
		// 		 }
		// 		 $volumeRekening = number_format($volume_rek ,0,',','.');
		// 		 $getSatuan = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_anggaran'"));
		// 		 $satuanRekening = $getSatuan['satuan_total'];
		// 		 $hargaSatuan = number_format($jumlah ,2,',','.');
		// 		 $jumlahHarga = number_format($jumlah_harga ,2,',','.');
		// 		 $this->total += $jumlah_harga;
		// 		 $TampilCheckBox = "";
		// }

		if( !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && empty($id_rincian_belanja) ){
				 //Rekening
				 $boldStatus = "bold";
				 // $marginStatus = "20px;";
				 //
				 // $marginKode = "10px;";
				 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
				 if(mysql_num_rows(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'")) == 0){
					 $uraianList = "<span style='color:red;cursor:pointer' class='uraianList' id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>Belanja xxx</span>";
					 $kode = "<span style='color:red;'>x.x.x.xx.xxx</span>";
				 }else{
					 $kode = $k.".".$l.".".$m.".".$n.".".$o;
					 // $uraianList = $getNamaRekening['nm_rekening'];
					 $uraianList = "<span style='cursor:pointer' class='uraianList'  id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>".$getNamaRekening['nm_rekening']."</span>";
				 }

				 $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_1 where id_tahap = '$this->idTahap' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiRekening"));
				 $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
				 $TampilCheckBox = "";
		}elseif(!empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && empty($rincian_perhitungan)){
				 //RincianBelanja
				 $boldStatus = "";
				 $marginStatus = "10px;";
				 $kode = "";
				 $getNamaRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '$id_rincian_belanja'"));
				 $uraianList = "<span style='cursor:pointer;' class='uraianList' onclick=$this->Prefix.editRincianBelanja($id_anggaran,$id_rincian_belanja); id ='spanEditRincianBelanja$id_anggaran'>".$getNamaRincianBelanja['nama_rincian_belanja']."</span>";
				 $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_1 where id_tahap = '$this->idTahap' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja='$id_rincian_belanja' $kondisiSKPD $kondisiRekening"));
				 $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
				 $TampilCheckBox = "";
		}elseif( !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && !empty($rincian_perhitungan) ){
				 //SubRincianBelanja
				 $boldStatus = "";
				 $marginStatus = "20px;";
				 $kode = "";
				 if(empty($jumlah) || $jumlah == '0.00'){
					 $colorList = "red";
				 }
				 if($j !='000'){
					 if($f == '08'){
						 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1'"));
						 $uraianList = "<span style='color:$colorList;cursor:pointer;' class='uraianList' onclick=$this->Prefix.editSubRincian($id_anggaran);> - ".$getNamaBarang['nm_barang']." </span>";
					 }else{
						 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' "));
						 $uraianList = "<span style='color:$colorList;cursor:pointer;' class='uraianList' onclick=$this->Prefix.editSubRincian($id_anggaran);> - ".$getNamaBarang['nm_barang']." </span>";
					 }
				 }else{
					 $uraianList = "<span style='color:$colorList;cursor:pointer;' class='uraianList'  onclick=$this->Prefix.editSubRincian($id_anggaran);> - ".$rincian_perhitungan."</span>";
				 }
				 $volumeRekening = "<span id='spanVolumeRekening$id_anggaran'>".number_format($volume_rek ,0,',','.')."</span>";
				 $getSatuan = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_anggaran'"));
				 $satuanRekening = "<span id='spanSatuan$id_anggaran'>".$getSatuan['satuan_total']."</span>";
				 if(empty($getSatuan['satuan_total'])){
						 $satuanRekening = "<span id='spanSatuan$id_anggaran'>".$satuan1."</span>";
				 }
				 $hargaSatuan = "<span id='spanHargaSatuan$id_anggaran'>".number_format($jumlah ,2,',','.')."</span>";
				 $jumlahHarga = "<span id='spanTotalJumlah$id_anggaran'>".number_format($jumlah_harga ,2,',','.')."</span>";
				 $TampilCheckBox = "";
		}

		$Koloms[] = array(' align="left"', "<span style='color:$warnaMapping;margin-left:$marginKode;'  >$kode</span>" );
		$Koloms[] = array(' align="left"', "<span style='font-weight:$boldStatus;margin-left:$marginStatus;'>$uraianList</span> <div style='float:right' id='uraianVolume$id_anggaran'>".$isi['rincian_volume']."</div>" );
		$Koloms[] = array(" align='right' id='tdVolumeRekening$id_anggaran'","<span  id='actionSpanRincianBelanja$id_anggaran'>" .$volumeRekening."</span>" );
		$Koloms[] = array(' align="left"', $satuanRekening );
		$Koloms[] = array(' align="right"', $hargaSatuan );
		$Koloms[] = array(' align="right"',  "<span style='font-weight:$boldStatus;' id='actionSpan$id_anggaran'>$jumlahHarga</span>" );

	 return $Koloms;
	}


	function Validasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI RKA-SKPD 1 DP';
	 $kode = $dt['c1'].".".$dt['c'].".".$dt['d'].".".$dt['e'].".".$dt['e1'].".".$dt['bk'].".".$dt['ck'].".".$dt['p'].".".$dt['q'].".".$dt['o1'];
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
						'label'=>'KODE',
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
			if($CurrentSKPD !='00' ){
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




	foreach ($_COOKIE as $key => $value) {
				  $$key = $value;
			}


		if($VulnWalkerSKPD != '00'){
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
		$urusan = cmbQuery('cmbUrusan',$selectedC1,$codeAndNameUrusan,'onchange=rkaSKPD1DP.refreshList(true);','-- URUSAN --');

		$codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c !='00' and d='00' and e='00' and e1='000' ";
		$bidang = cmbQuery('cmbBidang',$selectedC,$codeAndNameBidang,'onchange=rkaSKPD1DP.refreshList(true);','-- BIDANG --');

		$codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d!='00' and e='00' and e1='000' ";
		$skpd= cmbQuery('cmbSKPD',$selectedD,$codeAndNameSKPD,'onchange=rkaSKPD1DP.refreshList(true);','-- SKPD --');

		$codeAndNameUnit = "select e, concat(e, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e!='00' and e1='000' ";
		$unit = cmbQuery('cmbUnit',$selectedE,$codeAndNameUnit,'onchange=rkaSKPD1DP.refreshList(true);','-- UNIT --');


		$codeAndNameSubUnit = "select e1, concat(e1, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1!='000' ";
		$subunit = cmbQuery('cmbSubUnit',$selectedE1,$codeAndNameSubUnit,'onchange=rkaSKPD1DP.refreshList(true);','-- SUB UNIT --');



	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran) as max from view_rkbmd "));
	$maxID = $get1['max'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran = '$maxID' "));
	$nomorUrutSebelumnya =  $get2['no_urut'];

$jumlahData = $_REQUEST['jumlahData'];
if(empty($jumlahData))$jumlahData = 50;







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
			"</div>".

								"<div class='FilterBar' style='margin-top:5px;'>".
					"<table style='width:100%'>

					<tr>
					<td>JUMLAH DATA</td>
					<td>:</td>
					<td style='width:86%;'>
						<input type='text' name ='jumlahData' id='jumlahData' value ='$jumlahData' style='width:40px;'>  &nbsp <input type='button' onclick =$this->Prefix.refreshList(true); value='Tampilkan'>
					</td>
					</tr>


					</table></div>"

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

	  if(isset($cmbSKPD)){
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
	     if($CurrentSKPD !='00' ){
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
	   }elseif(isset($cmbBidang) && $cmbBidang== ''){
	    $cmbSKPD = "";

	   }elseif(isset($cmbSKPD) && $cmbSKPD== ''){
	   }

	    if($cmbSKPD != ''){
	      // $arrKondisi[] = "c1 = '$cmbUrusan'";
	      // $arrKondisi[] = "c = '$cmbBidang'";
	      // $arrKondisi[] = "d = '$cmbSKPD'";
	      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
	    }elseif($cmbBidang != ''){
	      // $arrKondisi[] = "c1 = '$cmbUrusan'";
	      // $arrKondisi[] = "c = '$cmbBidang'";
	      $kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
	    }elseif($cmbUrusan != ''){
	      //$arrKondisi[] = "c1 = '$cmbUrusan'";
	      $kondisiSKPD = "and c1='$cmbUrusan'";
	    }
	    $blackListSubRincian = array();
	    $getAllSubRincian = mysql_query("select * from view_rka_1 where id_tahap = '$this->idTahap' and (j!='000' or rincian_perhitungan !='' )");
	    while($subRincian = mysql_fetch_array($getAllSubRincian)){
	          if(mysql_num_rows(mysql_query("select * from view_rka_1 where id_tahap = '$this->idTahap' $this->kondisiRekening and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening")) == 0){
	              $blackListSubRincian[] = "id_anggaran != '".$subRincian['id_anggaran']."'";
	              $arrKondisi[] = "id_anggaran !='".$subRincian['id_anggaran']."'";
	              // $this->injectQuery = "select * from view_rka_1 where id_tahap = '$this->idTahap' and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening";
	          }
	    }
	    $kondisiBlackListSubRincian= join(' and ',$blackListSubRincian);
	    if(sizeof($blackListSubRincian) == 0){
	      $kondisiBlackListSubRincian = "";
	    }elseif(sizeof($blackListSubRincian) > 0){
	      $kondisiBlackListSubRincian = " and ".$kondisiBlackListSubRincian;
	    }

	    $blackListRincian = array();
	    $getAllRincian =  mysql_query("select * from view_rka_1 where id_tahap ='$this->idTahap'  and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja != '' and id_rincian_belanja !='0' and j='000' and rincian_perhitungan = '' ");
	    while($rincianBelanja = mysql_fetch_array($getAllRincian)){
	        if(mysql_num_rows(mysql_query("select  * from view_rka_1 where id_tahap = '$this->idTahap' $this->kondisiRekening and bk = '".$rincianBelanja['bk']."' and ck = '".$rincianBelanja['ck']."' and dk = '".$rincianBelanja['dk']."' and p = '".$rincianBelanja['p']."' and q = '".$rincianBelanja['q']."' and k = '".$rincianBelanja['k']."' and l = '".$rincianBelanja['l']."'  and m = '".$rincianBelanja['m']."'  and n = '".$rincianBelanja['n']."' and o = '".$rincianBelanja['o']."' and id_rincian_belanja = '".$rincianBelanja['id_rincian_belanja']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
	            $blackListRincian[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
	            $arrKondisi[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
	        }

	    }

	    $blackListRekening = array();
	    $getAllRekening =  mysql_query("select * from view_rka_1 where id_tahap ='$this->idTahap'  and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
	    while($rekeningBelanja = mysql_fetch_array($getAllRekening)){
	        if(mysql_num_rows(mysql_query("select  * from view_rka_1 where id_tahap = '$this->idTahap' $this->kondisiRekening and bk = '".$rekeningBelanja['bk']."' and ck = '".$rekeningBelanja['ck']."' and dk = '".$rekeningBelanja['dk']."' and p = '".$rekeningBelanja['p']."' and q = '".$rekeningBelanja['q']."' and k = '".$rekeningBelanja['k']."' and l = '".$rekeningBelanja['l']."'  and m = '".$rekeningBelanja['m']."'  and n = '".$rekeningBelanja['n']."' and o = '".$rekeningBelanja['o']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
	            $blackListRekening[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
	            $arrKondisi[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
	        }
	    }



	  $arrKondisi[] = "id_tahap = '$this->idTahap' ";
	  $arrKondisi[] = "tahun = '$this->tahun'";
	  $arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
	  $Kondisi= join(' and ',$arrKondisi);
	  $Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi ;


		$getTotalHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from $this->TblName $Kondisi"));
		$this->total = $getTotalHarga['sum(jumlah_harga)']."select sum(jumlah_harga) from $this->TblName $Kondisi";

	  //Order -------------------------------------
	  $fmORDER1 = cekPOST('fmORDER1');
	  $fmDESC1 = cekPOST('fmDESC1');
	  $Asc1 = $fmDESC1 ==''? '': 'desc';
	  $arrOrders = array();
	  $arrOrders[] = "urut, rincian_perhitungan  asc";
	  $Order= join(',',$arrOrders);
	  $OrderDefault = '';
	  $Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;

		if(empty($jumlahData))$jumlahData =50;
		$this->pagePerHal = $jumlahData;
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

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



		$arrKondisi = array();
		$grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_rka_21 where username='$this->username'"));
		foreach ($grabSKPD as $key => $value) {
				  $$key = $value;
			}
		$cmbUrusan = $c1;
		$cmbBidang = $c;
		$cmbSKPD = $d;
		$cmbUnit = $e;
		$cmbSubUnit = $e1;

		if($cmbSubUnit != ''){
			$arrKondisi[] = "c1 = '$cmbUrusan'";
			$arrKondisi[] = "c = '$cmbBidang'";
			$arrKondisi[] = "d = '$cmbSKPD'";
			$arrKondisi[] = "e = '$cmbUnit'";
			$arrKondisi[] = "e1 = '$cmbSubUnit'";
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";


			}elseif($cmbUnit != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$arrKondisi[] = "d = '$cmbSKPD'";
				$arrKondisi[] = "e = '$cmbUnit'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
			}elseif($cmbSKPD != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$arrKondisi[] = "d = '$cmbSKPD'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
			}elseif($cmbBidang != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
			}elseif($cmbUrusan != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$kondisiSKPD = "and c1='$cmbUrusan'";
			}
		$arrKondisi[] = "c1 != '0'";
		if($this->jenisForm == 'PENYUSUNAN'){
			$getAllParent = mysql_query("select * from view_rka_1 where id_tahap ='$this->idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) {
			 	 $$key = $value;
				}
				$cekPekerjaan = mysql_num_rows(mysql_query("select * from view_rka_1 where o1 = '$o1' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
				if($cekPekerjaan == 0){
					$arrKondisi[] = "o1 !='$o1'";
				}else{
					$arrKondisi[] = " id_tahap='$this->idTahap'  or id_anggaran = '$id_anggaran' ";
					$getAllRekening = mysql_query("select * from view_rka_1 where id_tahap = '$this->idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
					while($row2s = mysql_fetch_array($getAllRekening)){
						foreach ($row2s as $key => $value) {
					 	 $$key = $value;
						}
						$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$this->idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
						if($cekRekening == 0){
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
						}else{
							$arrKondisi[] = " id_tahap='$this->idTahap'  or id_anggaran = '$id_anggaran'  ";


						}
					}
				}
			}


				$grabNonMapingRekening= mysql_query("select * from view_rka_1 where id_tahap ='$this->idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonMapingRekening)){
					if(mysql_num_rows(mysql_query("select * from view_rka_1 where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!=''  $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}

				}
				$grabNonHostedRekening= mysql_query("select * from view_rka_1 where id_tahap ='$this->idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonHostedRekening)){
					if(mysql_num_rows(mysql_query("select * from view_rka_1 where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!=''  $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}

				}


			$arrKondisi[] = "id_tahap = '$this->idTahap' ";

		}elseif($this->jenisForm == 'KOREKSI'){
			$nomorUrutSebelumnya = $this->nomorUrut;
			$getRApbd = mysql_fetch_array(mysql_query("select * from view_rka_1 where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
			if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
				$nomorUrutSebelumnya = $nomorUrutSebelumnya - 1;
			}
			$getLastTahap = mysql_fetch_array(mysql_query("select * from view_rka_1 where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			$blackList = "";
			if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
				$getAllChild = mysql_query("select * from view_rka_1 where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");
				while($black = mysql_fetch_array($getAllChild)){
					$blackList .= " and id_anggaran !='".$black['id_anggaran']."'";
				}
			}

			$getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
			$idTahap = $getIDTahap['id_tahap'];
			$getAllParent = mysql_query("select * from view_rka_1 where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) {
			 	 $$key = $value;
				}
				$cekPekerjaan = mysql_num_rows(mysql_query("select * from view_rka_1 where o1 = '$o1' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
				if($cekPekerjaan == 0){
					$arrKondisi[] = "o1 !='$o1'";
				}else{
					$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran' ";
					$getAllRekening = mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
					while($row2s = mysql_fetch_array($getAllRekening)){
						foreach ($row2s as $key => $value) {
					 	 $$key = $value;
						}
						$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
						if($cekRekening == 0){
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
						}else{
							$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'  ";
							$getAllProgram = mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
							while($row3s = mysql_fetch_array($getAllProgram)){
								foreach ($row3s as $key => $value) {
							 	 $$key = $value;
								}
								$cekProgram = mysql_num_rows(mysql_query("select * from view_rka_1 where bk ='$bk' and ck='$ck' and p='$p' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
								if($cekProgram == 0){
									$concat = $bk.".".$ck.".".$p;
									$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
								}else{
									$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'   ";
									$getAllKegiatan = mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
									while($row4s = mysql_fetch_array($getAllKegiatan)){
										foreach ($row4s as $key => $value) {
									 	 $$key = $value;
										}
										$cekKegiatan = mysql_num_rows(mysql_query("select * from view_rka_1 where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD  $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
										if($cekKegiatan == 0){
											$concat = $bk.".".$ck.".".$p;
											$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
										}else{
											$arrKondisi[] = " id_tahap='$this->idTahap'  or id_anggaran = '$id_anggaran'   ";


										}
									}

								}
							}

						}
					}
				}
			}


				$grabNonMapingRekening= mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonMapingRekening)){
					if(mysql_num_rows(mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}

				}

				$grabNonHostedRekening= mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonHostedRekening)){
					if(mysql_num_rows(mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}

				}





			$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";


		}else{
			if($this->jenisFormTerakhir == "KOREKSI"){
				$nomorUrutSebelumnya = $this->urutTerakhir;
				$getRApbd = mysql_fetch_array(mysql_query("select * from view_rka_1 where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
				if($getRApbd['jenis_form_modul'] != "PENYUSUNAN" && $getRApbd['jenis_form_modul'] != "KOREKSI"){
					$nomorUrutSebelumnya = $nomorUrutSebelumnya - 1;
				}
				$getLastTahap = mysql_fetch_array(mysql_query("select * from view_rka_1 where no_urut = '$nomorUrutSebelumnya' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				$blackList = "";
				if($getLastTahap['jenis_form_modul'] == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
					$getAllChild = mysql_query("select * from view_rka_1 where id_tahap = '".$getLastTahap['id_tahap']."' and (rincian_perhitungan !='' or j !='000'  and status_validasi !='1' )");
					while($black = mysql_fetch_array($getAllChild)){
						$blackList .= " and id_anggaran !='".$black['id_anggaran']."'";
					}
				}

				$getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
				$idTahap = $getIDTahap['id_tahap'];
				$getAllParent = mysql_query("select * from view_rka_1 where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekPekerjaan = mysql_num_rows(mysql_query("select * from view_rka_1 where o1 = '$o1' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
					if($cekPekerjaan == 0){
						$arrKondisi[] = "o1 !='$o1'";
					}else{
						$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran' ";
						$getAllRekening = mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
						while($row2s = mysql_fetch_array($getAllRekening)){
							foreach ($row2s as $key => $value) {
						 	 $$key = $value;
							}
							$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
							if($cekRekening == 0){
								$concat = $k.".".$l.".".$m.".".$n.".".$o;
								$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
							}else{
								$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'  ";
								$getAllProgram = mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
								while($row3s = mysql_fetch_array($getAllProgram)){
									foreach ($row3s as $key => $value) {
								 	 $$key = $value;
									}
									$cekProgram = mysql_num_rows(mysql_query("select * from view_rka_1 where bk ='$bk' and ck='$ck' and p='$p' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
									if($cekProgram == 0){
										$concat = $bk.".".$ck.".".$p;
										$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
									}else{
										$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'   ";
										$getAllKegiatan = mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
										while($row4s = mysql_fetch_array($getAllKegiatan)){
											foreach ($row4s as $key => $value) {
										 	 $$key = $value;
											}
											$cekKegiatan = mysql_num_rows(mysql_query("select * from view_rka_1 where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahap' $kondisiRekening $kondisiSKPD  $blackList and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
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


					$grabNonMapingRekening= mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
					while($got = mysql_fetch_array($grabNonMapingRekening)){
						if(mysql_num_rows(mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
							$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
						}

					}

					$grabNonHostedRekening= mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
					while($got = mysql_fetch_array($grabNonHostedRekening)){
						if(mysql_num_rows(mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD $blackList")) != 0){
							$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
						}

					}





				$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
			}elseif($this->jenisFormTerakhir == "PENYUSUNAN"){
				$getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut ='$this->urutTerakhir' and tahun ='$this->tahun' and anggaran='$this->jenisAnggaran'"));
				$idTahap = $getIDTahap['id_tahap'];
				$getAllParent = mysql_query("select * from view_rka_1 where id_tahap ='$idTahap'  and o1 !='0' and k='0' and n='0' and rincian_perhitungan=''  ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekPekerjaan = mysql_num_rows(mysql_query("select * from view_rka_1 where o1 = '$o1' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
					if($cekPekerjaan == 0){
						$arrKondisi[] = "o1 !='$o1'";
					}else{
						$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran' ";
						$getAllRekening = mysql_query("select * from view_rka_1 where id_tahap = '$idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
						while($row2s = mysql_fetch_array($getAllRekening)){
							foreach ($row2s as $key => $value) {
						 	 $$key = $value;
							}
							$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
							if($cekRekening == 0){
								$concat = $k.".".$l.".".$m.".".$n.".".$o;
								$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
							}else{
								$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'  ";
								$getAllProgram = mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
								while($row3s = mysql_fetch_array($getAllProgram)){
									foreach ($row3s as $key => $value) {
								 	 $$key = $value;
									}
									$cekProgram = mysql_num_rows(mysql_query("select * from view_rka_1 where bk ='$bk' and ck='$ck' and p='$p' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
									if($cekProgram == 0){
										$concat = $bk.".".$ck.".".$p;
										$arrKondisi[] = "concat(bk,'.',ck,'.',p)  !='$concat'";
									}else{
										$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'   ";
										$getAllKegiatan = mysql_query("select * from view_rka_1 where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
										while($row4s = mysql_fetch_array($getAllKegiatan)){
											foreach ($row4s as $key => $value) {
										 	 $$key = $value;
											}
											$cekKegiatan = mysql_num_rows(mysql_query("select * from view_rka_1 where bk ='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap ='$idTahap' $kondisiRekening $kondisiSKPD and (rincian_perhitungan !='' or rincian_perhitungan!='') "));
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


				$grabNonMapingRekening= mysql_query("select * from view_rka_1 where id_tahap ='$idTahap' and (LENGTH(k) > 1) and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonMapingRekening)){
					if(mysql_num_rows(mysql_query("select * from view_rka_1 where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}

				}

				$grabNonHostedRekening= mysql_query("select * from view_rka_1 where id_tahap ='$idTahap' and (LENGTH(k) = 1 and k !='0') and rincian_perhitungan=''");
				while($got = mysql_fetch_array($grabNonHostedRekening)){
					if(mysql_num_rows(mysql_query("select * from view_rka_1 where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and rincian_perhitungan!='' $kondisiRekening $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}

				}



				$arrKondisi[] = "id_tahap = '$idTahap' ";
			}
		}






		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";

		$Kondisi= join(' and ',$arrKondisi);
		/*if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}*/
		$qry ="select * from view_rka_1 where $Kondisi ";
		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];

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
					RENCANA KERJA DAN ANGGARAN<br>
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




				</table>

				<br>


				";
		echo "
				<span style='font-size:16px;font-weight:bold;text-decoration: '>
					Rincian Anggaran Pendapatan Tidak Langsung Satuan Kerja Perangkat Daerah
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
		$getTotal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_1 where $Kondisi  "));
		$total = number_format($getTotal['sum(jumlah_harga)'],2,',','.');
		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
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
				$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_1 where  o1 ='$o1' $kondisiSKPD $kondisiFilter  "));
				$jumlah_harga = "<span style='font-weight:bold;'>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.') . "</span>";


			}elseif($c1 == '0'){
				$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
				$jarak = "0px";
				if($o1 !='0' && $o1 !='')$jarak = "10px";
				$uraian = "<span style='font-weight:bold;margin-left:$jarak;'>".$getNamaRekening['nm_rekening']."</b>";
				$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_1 where  k = '$k' and l='$l' and m='$m' and n='$n' and o='$o'  $kondisiSKPD $kondisiFilter"));
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
			$no++;




		}
		echo 				"<tr valign='top'>
									<td align='right' colspan='9' class='GarisCetak'>Jumlah</td>
									<td align='right' class='GarisCetak' ><b>".$total."</b></td>

								</tr>
							 </table>";
		$getDataPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatanganpenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and kategori = 'PENGGUNA' "));

		echo
						"<br><div class='ukurantulisan' style ='float:right;'>
						$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."<br>
						Kepala SKPD
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

function formAlokasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';
	 $jumlahHargaForm = $_REQUEST['jumlahHarga'];
	 $id = $_REQUEST['id'];
	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );


	 $jenisAlokasi = $jenis_alokasi_kas;
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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi($id);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function formAlokasiTriwulan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';
	 $jumlahHargaForm = $_REQUEST['jumlahHarga'];
	 $id = $_REQUEST['id'];
	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );

	 $username = $_COOKIE['coID'];
	 $getAlokasi = mysql_fetch_array(mysql_query("select * from temp_alokasi_rka_v2 where user='$username'"));
	 foreach ($getAlokasi as $key => $value) {
				  $$key = $value;
			}
	 $jenisAlokasi = $jenis_alokasi_kas;
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
						'label'=>'JUMLAH HARGA',
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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi($id);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


    function newJob($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'PEKERJAAN BARU';


	 //items ----------------------
	  $this->form_fields = array(
			'namaPekerjaan' => array(
						'label'=>'NAMA PEKERJAAN',
						'labelWidth'=>130,
						'value'=>"<input type='text' name='namaPekerjaan' id='namaPekerjaan' style='width:210px;'>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveJob();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function editJob($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'EDIT PEKERJAAN';

	 $getNamaPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$dt'"));
	 $namaPekerjaan = $getNamaPekerjaan['nama_pekerjaan'];

	 //items ----------------------
	  $this->form_fields = array(
			'namaPekerjaan' => array(
						'label'=>'NAMA PEKERJAAN',
						'labelWidth'=>130,
						'value'=>"<input type='text' name='namaPekerjaan' id='namaPekerjaan' value='$namaPekerjaan' style='width:210px;'>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveEditJob();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function Gruping($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
	 $this->form_width = 600;
	 $this->form_height = 80;
	 $this->form_caption = 'Gruping Pekerjaan';
	 $codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan  ";
	 $cmbPekerjaan = cmbQuery('pekerjaan', $pekerjaan, $codeAndNamePekerjaan,"  ",'-- PEKERJAAN --');

	 //items ----------------------
	  $this->form_fields = array(
			'pekerjaan' => array(
						'label'=>'PEKERJAAN',
						'labelWidth'=>100,
						'value'=>$cmbPekerjaan." &nbsp <button type='button' onclick=$this->Prefix.newJob(); >Tambah</button>  &nbsp <button type='button' onclick=$this->Prefix.editJob(); >Edit</button>
								<input type='hidden' name='anggota' id='anggota' value='$dt'>
								",
						 ),


			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".setGrup()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function checkKosong($jumlah){
			if($jumlah == 0 || $jumlah == ''){
					$jumlah = "";
			}
			return $jumlah;
	}

	function nullChecker($angka){
		if(empty($angka)){
				$angka = "";
		}
		return $angka;

	}

	function removeKoma($angka){
			return str_replace(".00","",$angka);
	}

	function formRincianVolume($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 180;
	 $this->form_caption = 'DETAIL VOLUME';
	 $jumlahHargaForm = $dt;
	 $username =$_COOKIE['coID'];
	//  $getRincianVolume = mysql_fetch_array(mysql_query("select * from view_rka_1 where id_anggaran ='$dt'"));
	//  foreach ($getRincianVolume as $key => $value) {
	// 			  $$key = $value;
	// 	}

	foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
	 }
	 if(empty($volume3Temp) && !empty($volume2Temp)){
	  $totalResult = $volume1Temp * $volume2Temp ;
	  $volume3Temp = "";
		 $satuanVolume = $satuan1Temp." / ".$satuan2Temp;

	}elseif(empty($volume2Temp)){
	 $totalResult = $volume1Temp  ;
	 $volume3Temp = "";
	 $volume2Temp = "";
	$satuanVolume = $satuan1Temp;
	}else{
	  $totalResult = $jumlah1 * $jumlah2 * $jumlah3 ;
		$satuanVolume = $satuan1Temp." / ".$satuan2Temp." / ".$satuan3Temp;
	 }
// <input type='hidden' id='volumeRek' value='$volume_rek'>
	 //items ----------------------
	  $this->form_fields = array(
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 1 &nbsp<input type='text' id='jumlah1' value='$volume1Temp' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder='JUMLAH'> &nbsp SATUAN 1   &nbsp&nbsp&nbsp&nbsp&nbsp  <input type='text' name ='satuan1' id ='satuan1' value='$satuan1Temp'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 2 &nbsp<input type='text' id='jumlah2' placeholder='JUMLAH' value='".$this->nullChecker($volume2Temp)."' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp SATUAN 2  &nbsp&nbsp&nbsp&nbsp&nbsp    <input type='text' value='$satuan2Temp' name ='satuan2' id ='satuan2'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 3 &nbsp<input type='text' id='jumlah3' placeholder='JUMLAH' value='".$this->nullChecker($volume3Temp)."' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp SATUAN 3  &nbsp&nbsp&nbsp&nbsp&nbsp  <input type='text' value='$satuan3Temp'name ='satuan3' id ='satuan3'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" VOLUME &nbsp &nbsp<input type='text' value='$totalResult' placeholder='JUMLAH' id='jumlah4' readonly >&nbsp SATUAN VOL &nbsp <input type='text' name ='satuanVolume' id ='satuanVolume' style='width:150px;'  value='$satuanVolume' readonly> &nbsp &nbsp <span id='detailVolumeRincian'>",
						 ),
			 array( 		'label' => '',
 						'labelWidth' => 1,
 						'pemisah' => ' ',
 						'value'=>"",
 						 ),
	 			array( 	'label' => '',
	 						'labelWidth' => 1,
	 						'pemisah' => ' ',
	 						'value'=>" URAIAN VOLUME &nbsp <input type='text' value='$uraianVolume' placeholder=''  id='rincianVolumeTemp' style='width:330px;' >",
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

}
$rkaSKPD1DP = new rkaSKPD1DPObj();

$arrayResult = VulnWalkerTahap_v2('RKA');
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$rkaSKPD1DP->jenisForm = $jenisForm;
$rkaSKPD1DP->nomorUrut = $nomorUrut;
$rkaSKPD1DP->urutTerakhir = $nomorUrut;
$rkaSKPD1DP->tahun = $tahun;
$rkaSKPD1DP->jenisAnggaran = $jenisAnggaran;
$rkaSKPD1DP->idTahap = $idTahap;
$rkaSKPD1DP->username = $_COOKIE['coID'];

$rkaSKPD1DP->wajibValidasi = $Main->wajibValidasi;
if($Main->wajibValidasi == TRUE){
	$rkaSKPD1DP->sqlValidasi = " and status_validasi ='1' ";
}else{
	$rkaSKPD1DP->sqlValidasi = " ";
}

if(empty($rkaSKPD1DP->tahun)){

	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_rka_1 "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rka_1 where id_anggaran = '$maxAnggaran'"));
	$rkaSKPD1DP->tahun  = $get2['tahun'];
	$rkaSKPD1DP->jenisAnggaran = $get2['jenis_anggaran'];
	$rkaSKPD1DP->urutTerakhir = $get2['no_urut'];
	$rkaSKPD1DP->jenisFormTerakhir = $get2['jenis_form_modul'];
	$rkaSKPD1DP->urutSebelumnya = $rkaSKPD1DP->urutTerakhir - 1;


	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$rkaSKPD1DP->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaSKPD1DP->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$rkaSKPD1DP->currentTahap = $arrayHasil['currentTahap'];
}else{
	$getCurrenttahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$rkaSKPD1DP->idTahap'"));
	$rkaSKPD1DP->currentTahap = $getCurrenttahap['nama_tahap'];

	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$rkaSKPD1DP->idTahap'"));
	$rkaSKPD1DP->jenisFormTerakhir =  $namaTahap['jenis_form_modul'];
	$rkaSKPD1DP->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaSKPD1DP->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
}


$setting = settinganPerencanaan_v2();
$rkaSKPD1DP->provinsi = $setting['provinsi'];
$rkaSKPD1DP->kota = $setting['kota'];
$rkaSKPD1DP->pengelolaBarang = $setting['pengelolaBarang'];
$rkaSKPD1DP->pejabatPengelolaBarang = $setting['pejabat'];
$rkaSKPD1DP->pengurusPengelolaBarang = $setting['pengurus'];
$rkaSKPD1DP->nipPengelola = $setting['nipPengelola'];
$rkaSKPD1DP->nipPengurus = $setting['nipPengurus'];
$rkaSKPD1DP->nipPejabat = $setting['nipPejabat'];


if($rkaSKPD1DP->jenisForm != "PENYUSUNAN"){
$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_rka_1 where jenis_form_modul = 'PENYUSUNAN' "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rka_1 where id_anggaran = '$maxAnggaran'"));
	$rkaSKPD1DP->tahun  = $get2['tahun'];
	$rkaSKPD1DP->jenisAnggaran = $get2['jenis_anggaran'];
	$rkaSKPD1DP->urutTerakhir = $get2['no_urut'];
	$rkaSKPD1DP->jenisFormTerakhir = $get2['jenis_form_modul'];
	$rkaSKPD1DP->urutSebelumnya = $rkaSKPD1DP->urutTerakhir - 1;


	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$rkaSKPD1DP->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaSKPD1DP->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$rkaSKPD1DP->currentTahap = $arrayHasil['currentTahap'];
			$rkaSKPD1DP->jenisForm = "";
			$rkaSKPD1DP->jenisFormTerakhir = "PENYUSUNAN";
			$rkaSKPD1DP->idTahap = $get2['id_tahap'];
			$rkaSKPD1DP->tahun = $get2['tahun'];
			$rkaSKPD1DP->nomorUrut = $get2['no_urut'];
			$rkaSKPD1DP->urutTerakhir = $get2['no_urut'];
}


?>
