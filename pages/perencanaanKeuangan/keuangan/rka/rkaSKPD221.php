<?php

class rkaSKPD221Obj  extends DaftarObj2{
	var $Prefix = 'rkaSKPD221';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_rka_2_2_1'; //bonus
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
	var $PageTitle = 'RKA-SKPD';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='rkaSKPD221.xls';
	var $namaModulCetak='RKA';
	var $Cetak_Judul = 'RKA';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'rkaSKPD221Form';
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


	var $publicVar = "";
	var $publicKondisi = "";
	var $publicExcept = array();
	var $publicGrupId = array();


	var $provinsi = "";
	var $kota = "";
	var $pengelolaBarang = "";
	var $pejabatPengelolaBarang = "";
	var $pengurusPengelolaBarang = "";
	var $nipPengelola = "";
	var $nipPejabat = "";
	var $nipPengurus ="";

	function setTitle(){
		return 'RKA-SKPD 2.2.1 '.$this->jenisAnggaran.' TAHUN '.$this->tahun;
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
			<td class='$ColStyle' colspan='5' align='center'><b>Total </td>
			<td class='GarisDaftar' align='right'><b><div  >".number_format($this->total,2,',','.')."</div></td>

			$tergantung
		</tr>"
		 ;

			if($Mode == 2){
				$ContentTotal = '';
			}else if($Mode == 3){
				$ContentTotalHal='';
			}

		return $ContentTotalHal.$ContentTotal;
	}
	function setMenuEdit(){
	 	 $arrayResult = VulnWalkerTahap_v2("RKA");
		 $jenisForm = $arrayResult['jenisForm'];
		 $nomorUrut = $arrayResult['nomorUrut'];
		 $tahun = $arrayResult['tahun'];
		 $jenisAnggaran = $arrayResult['jenisAnggaran'];
		 $query = $arrayResult['query'];
	 if ($jenisForm == "PENYUSUNAN"){
	 	$listMenu =
					"<td>".genPanelIcon("javascript:".$this->Prefix.".noticeSync()","sync.png","Sync", 'Sync ')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","edit_f2.png","Ubah ", 'Ubah ')."</td>"
					//. "<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Ubah", 'Ubah')."</td>"
				//	"<td>".genPanelIcon("javascript:".$this->Prefix.".Remove()","delete_f2.png","Hapus", 'Hapus')."</td>".
				//	"<td>".genPanelIcon("javascript:".$this->Prefix.".Gruping()","publishdata.png","Gruping ", 'Gruping ')."</td>".
				 // "<td>".genPanelIcon("javascript:".$this->Prefix.".Posting()","publishdata.png","Posting ", 'Posting ')."</td>".
				//	"<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>"
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
	function setMenuView(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";

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

	$getJumlahBarang = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$rkaSKPD221_idplh'"));
	$jumlahBarang = $getJumlahBarang['volume_barang'];
	$total = $hargaSatuan * $jumlahBarang;

	/* $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja "));
  	 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
	$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));*/
	$getPaguYangTelahTerpakai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and no_urut = '$this->nomorUrut' and id_anggaran!='$rkaSKPD221_idplh' "));
	$sisaPaguIndikatif = $paguIndikatif - $getPaguYangTelahTerpakai['paguYangTerpakai'];

	 if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='0' and f = '00' and k = '$k' and l ='$l' and m='$m' and n='$n' and o='$o'  and id_tahap='$this->idTahap' ")) > 0){

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
		$query = VulnWalkerUpdate('tabel_anggaran',$data,"id_anggaran = '$rkaSKPD221_idplh'");
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

		case 'getDataSSH':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$getKodeBarang = mysql_fetch_array(mysql_query("select * from $this->TblName where id_anggaran = '$id'"));
			$kodeBarang = $getKodeBarang['f'].".".$getKodeBarang['g'].".".$getKodeBarang['h'].".".$getKodeBarang['i'].".".$getKodeBarang['j'].".".$getKodeBarang['j1'];
			$kodeRekening = $getKodeBarang['k'].".".$getKodeBarang['l'].".".$getKodeBarang['m'].".".$getKodeBarang['n'].".".$getKodeBarang['o'];
			$content = array('kodeRekening' => $kodeRekening, 'kodeBarang' => $kodeBarang);
		break;
		}
		case 'Info':{
				$fm = $this->Info();
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'noticeSync':{
				$fm = $this->noticeSync();
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
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
				$eventKeyup = 'document.getElementById("formatjumlah'.$id.'").innerHTML = rkaSKPD221.formatCurrency(this.value); ';
				$inputanSatuan = "<input style='width:100%;  text-align:left;'   type='text' name='satuanRek$id' value='$satuanRek' id='satuanRek$id'  readonly > ";
				$inputanSatuanHarga = "<input style='width:50%;  text-align:right;' placeholder='JUMLAH'  type='text' name='hargaSatuan$id' value='".$this->removeKoma($jumlah)."' id='hargaSatuan$id' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$eventKeyup'> &nbsp <button type='button' onclick='$this->Prefix.findSSH($id);'>SSH</button> <span id='formatjumlah$id'>  ";

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

				$getOldRekening = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where id_anggaran	 = '$id'"));
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

				if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1 = '0' and concat(bk,'.',ck,'.',dk,'.',p,'.',q,'.',k,'.',l,'.',m,'.',n,'.',o) = '$concatKondisiNew'")) == 0){
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
											'jenis_rka' => '2.2.1',
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
		case 'sync':{
			  $fm = $this->syncDataRKBMD();
				$cek = $this->syncDataRekening();
				$err = $fm['err'];
				$content = $fm['content'];

		break;
		}

		case 'infoSKPD':{
				$fm = $this->infoSKPD($_REQUEST['id_anggaran']);
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'setGrup':{
				foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 	}


				if(mysql_num_rows(mysql_query("select * from tabel_anggaran where o1 = '$pekerjaan' and id_tahap = '$this->idTahap' and jenis_rka = '2.2.1' and nama_modul ='RKA-SKPD'")) == 0){
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
												 'jenis_rka' => '2.2.1',
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
				if(mysql_num_rows(mysql_query("select * from skpd_report_rka_221 where username= '$this->username'")) == 0){
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD,
								  'bk' => $bk,
								  'ck' => $ck,
								  'dk' => $dk,
								  'p' => $hiddenP,
								  'q' => $q,

								  );
					$query = VulnWalkerInsert('skpd_report_rka_221',$data);
					mysql_query($query);
				}else{
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD,
								  'e' => $cmbUnit,
								  'e1' => $cmbSubUnit,
								  'bk' => $bk,
								  'ck' => $ck,
								  'dk' => $dk,
								  'p' => $hiddenP,
								  'q' => $q,

								  );
					$query = VulnWalkerUpdate('skpd_report_rka_221',$data,"username = '$this->username'");
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
		case 'clearTemp':{
				foreach ($_REQUEST as $key => $value) {
						$$key = $value;
				}
				$username =$_COOKIE['coID'];
				mysql_query("delete from temp_rekening_rka_belanja_langsung where username ='$username'");
				mysql_query("delete from temp_rincian_belanja_langsung where username ='$username'");
				mysql_query("delete from temp_sub_rincian_belanja_langsung where username ='$username'");
				mysql_query("delete from temp_remove_rka_221 where username ='$username'");

				$getALlData = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and c1 ='$cmbUrusan' and c ='$cmbBidang' and d='$cmbSKPD' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q='$q' and rincian_perhitungan !='' and id_rincian_belanja !=''");
				while ($rows = mysql_fetch_array($getALlData)) {
						foreach ($rows as $key => $value) {
								$$key = $value;
						}
						$getMyIdRekening = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k'  and l ='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja ='' and rincian_perhitungan = '' "));
						$getDataRekening = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '".$getMyIdRekening['id_anggaran']."'"));
						if(mysql_num_rows(mysql_query("select * from temp_rekening_rka_belanja_langsung where username = '$this->username' and k='$k'  and l ='$l' and m='$m' and n='$n' and o='$o'")) == 0){
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
								$queryRekening = VulnWalkerInsert('temp_rekening_rka_belanja_langsung',$dataRekening);
								mysql_query($queryRekening);
						}

						$getMyIdRincianBelanja = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and c1='$c1' and c='$c' and d='$d' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k'  and l ='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja ='$id_rincian_belanja' and rincian_perhitungan = '' "));
						$getDataRincianBelanja =  mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '".$getMyIdRincianBelanja['id_anggaran']."'"));
						$getUraianRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '".$getDataRincianBelanja['id_rincian_belanja']."'"));
						$getIdRekeningBelanja = mysql_fetch_array(mysql_query("select * from temp_rekening_rka_belanja_langsung where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and username = '$this->username'"));
						if(mysql_num_rows(mysql_query("select * from temp_rincian_belanja_langsung where username = '$this->username' and id_rekening_belanja = '".$getIdRekeningBelanja['id']."' and uraian = '".$getUraianRincianBelanja['nama_rincian_belanja']."'")) == 0){
								$dataRincianBelanja = array(

																				'id_rekening_belanja'=> $getIdRekeningBelanja['id'],
																				'uraian'=> $getUraianRincianBelanja['nama_rincian_belanja'],
																				'username' => $this->username,
																				'id_anggaran' => $getDataRincianBelanja['id_anggaran']
								);
								$queryRincianBelanja = VulnWalkerInsert('temp_rincian_belanja_langsung',$dataRincianBelanja);
								mysql_query($queryRincianBelanja);
						}
						$getUplineRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '$id_rincian_belanja'"));
						$getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from temp_rincian_belanja_langsung where username = '$this->username' and uraian = '".$getUplineRincianBelanja['nama_rincian_belanja']."'"));

						$getDataCurrentID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_anggaran'"));


						if($getDataCurrentID['jumlah1'] == '0'){
							if(empty($getDataCurrentID['satuan_rek']))$getDataCurrentID['satuan_rek'] = "-";
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
																			 'j1' => $j1,
																			 'harga_satuan' => $jumlah,
																			 'volume1' => $this->checkKosong($getDataCurrentID['volume_rek']),
																			 'volume2' => $this->checkKosong($getDataCurrentID['jumlah2']),
																			 'volume3' => $this->checkKosong($getDataCurrentID['jumlah3']),
																			 'rincian_volume' => $rincian_volume,
																			 'satuan1' => $getDataCurrentID['satuan_rek'],
																			 'satuan2' => $getDataCurrentID['satuan2'],
																			 'satuan3' => $getDataCurrentID['satuan3'],
																			 'username' => $this->username,
																			 'id_anggaran' => $id_anggaran,
																			 'urutan_posisi' => $getDataCurrentID['urutan_posisi']
																		 );
						}else{
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
																				'j1' => $j1,
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
																				'jenis_atribusi' => $jenis_atribusi,
																				'urutan_posisi' => $getDataCurrentID['urutan_posisi']
																			);
						}
						$querySubRincian = VulnWalkerInsert("temp_sub_rincian_belanja_langsung",$dataSubRincian);
						mysql_query($querySubRincian);

				}

				$cek = $queryRincianBelanja;





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
		case 'Gruping':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			if(!isset($rkaSKPD221_cb)){
				$err = "Pilih Data";
			}
			$dt = implode(',',$rkaSKPD221_cb);
			if($this->jenisForm !='PENYUSUNAN')$err = "Tahap Penyusunan Telah Habis";
				 if($err == ''){
						$fm = $this->Gruping($dt);
						$cek = $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
				 }

		break;
		}
		case 'formRincianVolume':{
				$fm = $this->formRincianVolume($_REQUEST['id']);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


		break;
		}
		case 'Posting':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			if($this->jenisForm !='PENYUSUNAN')$err = "Tahap Penyusunan Telah Habis";
				 if($err == ''){
						$fm = $this->Posting();
						$cek = $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
				 }

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

		case 'Remove':{
			$id = $_REQUEST['rkaSKPD221_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			mysql_query("delete from tabel_anggaran where id_tahap = '$this->idTahap' and jenis_rka = '2.2.1' and c1='$cmbUrusan' and c = '$cmbBidang' and d='$cmbSKPD' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$hiddenP' and q='$q' and rincian_perhitungan != '' ");
			$cek = "delete from tabel_anggaran where id_tahap = '$this->idTahap' and jenis_rka = '2.2.1' and c1='$cmbUrusan' and c = '$cmbBidang' and d='$cmbSKPD' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$hiddenP' and q='$q' and rincian_perhitungan != ''";



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
			$getrkaSKPD221nya = mysql_fetch_array(mysql_query($queryRows));
			foreach ($getrkaSKPD221nya as $key => $value) {
				  $$key = $value;
			}
			$cmbUrusanForm = $c1;
			$cmbBidangForm = $c;

			$cekUrusan =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='00' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and dk='0' and p = '0' and q='0'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'"));
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
										'dk' => '0',
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

					$cekBidang =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and dk='0' and p = '0' and q='0' and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
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
										'dk' => '0',
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
								"dk" => '0',
								'jumlah' => $jumlah,
								'id_tahap' => $this->idTahap,
								'jenis_anggaran' => $this->jenisAnggaran,
								'tahun' => $this->tahun,
								"nama_modul" => $this->modul

 								);
			$cekSKPD =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='00' and e1='000' and bk='0' and ck='0' and dk='0' and p = '0' and q='0' and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					if($cekSKPD > 0 ){
						$getID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='00' and e1='000' and bk='0' and ck='0' and dk='0' and p = '0' and q='0' and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
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
			$getrkaSKPD221nya = mysql_fetch_array(mysql_query($queryRows));
			foreach ($getrkaSKPD221nya as $key => $value) {
				  $$key = $value;
			}

			 $hasilKali = $koreksiSatuanHarga * $koreksiVolumebarang ;

			 $getNomorUrutRenja = mysql_fetch_array(mysql_query("select max(no_urut) as nomor_urut from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' ")) ;
			 $nomorUrutRenja = $getNomorUrutRenja['nomor_urut'];
			 $getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutRenja'"));
			 $paguIndikatif = $getPaguIndikatif['jumlah'];
			 $content .=  "pagu : ". $paguIndikatif;
			 $content .= "HASIL KALI : ".$hasilKali;

			 $filterPagu = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q.".".$f.".".$g.".".$h.".".$i.".".$j.".".$id_jenis_pemeliharaan.".".$k.".".$l.".".$m.".".$n.".".$o;
			 $getSisaPagu = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai  from view_rka_2_2_1 where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and id_tahap='$this->idTahap' and concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',id_jenis_pemeliharaan,'.',k,'.',l,'.',m,'.',n,'.',o) != '$filterPagu'  and o1 !='0' and rincian_perhitungan !=''"));

			 if(mysql_num_rows(mysql_query("select * from view_renja where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutRenja'")) == 0){
			 	$filterPagu = $c1.".".$c.".".$d.".".$bk.".".$ck.".".$dk.".".$p.".".$q.".".$f.".".$g.".".$h.".".$i.".".$j.".".$id_jenis_pemeliharaan.".".$k.".".$l.".".$m.".".$n.".".$o;

				$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutRenja'"));
				$getSisaPagu =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from vview_rka_2_2_1 where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and id_tahap='$this->idTahap' and concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',id_jenis_pemeliharaan,'.',k,'.',l,'.',m,'.',n,'.',o) != '$filterPagu'  and o1 !='0' and rincian_perhitungan !='' "));
				$paguIndikatif = $getPaguIndikatif['jumlah'];
			}

			 $sisaPagu = $paguIndikatif - $getSisaPagu['paguYangTerpakai'];
			 $content .= "Sisa PAGU : ".$sisaPagu;
			 $content .= "getSIsaPAGU nya : "."select sum(jumlah_harga) as paguYangTerpakai  from view_rka_2_2_1 where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and id_tahap='$this->idTahap' and concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',id_jenis_pemeliharaan,'.',k,'.',l,'.',m,'.',n,'.',o) != '$filterPagu' ";
			 if($this->jenisForm != 'KOREKSI'){
			 	$err = "Tahap Koreksi Telah Habis";
			 }elseif($hasilKali > $sisaPagu){
			 	$err = "Tidak dapat melebihi Pagu Indikatif";
			 }

			 /*if(isset($jenisAlokasi) && !empty($jenisAlokasi)){
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
									mysql_query($query);
								}
						}*/
			 if($err == ""){

					if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where  o1='$o1' and j='000' and rincian_perhitungan ='' and id_tahap='$this->idTahap' ")) > 0){

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
												 'jenis_rka' => '2.2.1',
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'id_tahap' => $this->idTahap,
												 'nama_modul' => 'RKA-SKPD'
												);
							$queryPekerjaan = VulnWalkerInsert('tabel_anggaran',$arrayPekerjaan);
							mysql_query($queryPekerjaan);
					}

				 	if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where  rincian_perhitungan ='' and c1='0' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap='$this->idTahap'  ")) > 0){

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
										"jenis_rka" => '2.2.1',
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
										 "bk" => $bk,
										 "ck" => $ck,
										 "dk" => $dk,
										 "f" => $f,
										 "g" => $g,
										 "h" => $h,
										 "i" => $i,
										 "j" => $j,
										 "id_jenis_pemeliharaan" => $id_jenis_pemeliharaan,
										 "uraian_pemeliharaan" => $uraian_pemeliharaan,
										 "p" => $p,
									   	 "q" => $q,
										 "k" => $k,
										 "l" => $l,
										 "m" => $m,
										 "n" => $n,
										 "o" => $o,
										 "o1" => $o1,
										 "catatan" => $catatan,
										 "rincian_perhitungan" => $rincian_perhitungan,
										 "jumlah" => $koreksiSatuanHarga,
										 "volume_rek" => $koreksiVolumebarang,
										 "satuan_rek" => $satuan_rek,
										 "jumlah_harga" => $hasilKali,
										 "jenis_anggaran" => $this->jenisAnggaran,
										 "jenis_rka" => '2.2.1',
										 "id_tahap" => $this->idTahap,
										 "nama_modul" => $this->modul,
										 "user_update" => $_COOKIE['coID'],
										 "tanggal_update" => date("Y-m-d"),
		 								);

					$cekRKA =  mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' and o1='$o1' and rincian_perhitungan = '$rincian_perhitungan'"));
							if($cekRKA > 0 ){
								$getID = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
							    $idnya = $getID['id_anggaran'];
								mysql_query(VulnWalkerUpdate("tabel_anggaran", $dataSesuai, "id_anggaran = '$idnya'"));
							}else{
								mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));
								$content.=VulnWalkerInsert("tabel_anggaran", $dataSesuai);
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
			 $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$rkaSKPD221_idplh'");
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
			$id = $_REQUEST['rkaSKPD221_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			$username = $_COOKIE['coID'];

			$get = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$id[0]'"));
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;

			$getAll = mysql_query("select * from view_rka_2_2_1 where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and (rincian_perhitungan !='' or f!='00' )   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q='$q' and status_validasi !='1' order by o1, rincian_perhitungan");
			mysql_query("delete from temp_rka_221 where user='$username'");
			mysql_query("delete from temp_rincian_volume where user='$username'");
		    mysql_query("delete from temp_alokasi_rka where user='$username'");
			$noUrutPekerjaan = 0;
			$angkaO2 = 0;
			$lastO1 = 0;
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) {
				  $$key = $value;
				}
				$getMaxID = mysql_fetch_array(mysql_query("select  max(id) as gblk from temp_rka_221 where user ='$username'"));
				$maxID = $getMaxID['gblk'];
				$lastO1 = $o1;

				$getLastO1 = mysql_fetch_array(mysql_query("select o1 from temp_rka_221 where id='$maxID' "));
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
								'bk' => $bk,
								'ck' => $ck,
								'dk' => $dk,
								'p' => $p,
								'q' => $q,
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
								'catatan' => $catatan,
								'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
								'volume_rek' => $volume_rek,
								'satuan' => $satuan_rek,
								'user' => $username,
								'rincian_perhitungan' => $rincian_perhitungan,
								'harga_satuan' => $jumlah,
								'jumlah_harga' => $jumlah_harga,
								'id_awal' => $id_anggaran
								);
				$query = VulnWalkerInsert('temp_rka_221',$data);
				mysql_query($query);



			}

			$cek = "select * from view_rka_2_2_1 where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and (rincian_perhitungan !='' or f!='00' )   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q='$q' and status_validasi !='1' order by o1, rincian_perhitungan";

			$content = array('kodeRek' => $kodeRek   );
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
		case 'newJob':{
				$fm = $this->newJob($dt);
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
	"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=rkaSKPD221\" title='BELANJA' style='color:blue;' > BELANJA </a> |
	<A href=\"pages.php?Pg=rkaSKPD1PAD\" title='PENDAPATAN' > PENDAPATAN </a> |
	<A href=\"pages.php?Pg=rkaSKPD31\" title='RKA-SKPKD MURNI' > PEMBIAYAAN </a> |
	<A href=\"pages.php?Pg=rkaSKPD\" title='RKA-SKPKD MURNI' > RKA-SKPD  </a>

	&nbsp&nbsp&nbsp
	</td></tr>

	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=rkaSKPD221\" title='BELANJA LANGSUNG' style='color:blue;' > LANGSUNG </a> |
	<A href=\"pages.php?Pg=rkaSKPD21\" title='BELANJA TIDAK LANGSUNG' > TIDAK LANGSUNG </a>

	&nbsp&nbsp&nbsp
	</td></tr>
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=rkaSKPD221\" title='INPUT' style='color:blue;' > INPUT </a> |
	<A href=\"pages.php?Pg=rkaSKPD22\" title='REKAP' > REKAP </a>

	&nbsp&nbsp&nbsp
	</td></tr>
	</table>";
	}
	function removeKoma($angka){
			return str_replace(".00","",$angka);
	}
   function setPage_OtherScript(){

		$scriptload =
					"
					<style type='text/css'>
							.uraianList:hover{
									color:blue;
							}
					</style>

					<script>
						$(document).ready(function(){
							".$this->Prefix.".loading();
						});
					</script>";
		return
			"
			<script src='js/skpd.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/popup_rekening/popupRekening.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/rka/rkaSKPD221.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/rka/rkaSKPD221New.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/master/standarSatuanHarga/popupSSH.js' language='JavaScript' ></script>
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
	function noticeSync(){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 100;
	 $this->form_caption = 'SYNC DATA';


	 if(!empty($_REQUEST['c1'])){
 			if(empty($_REQUEST['c'])){
 					$err = "Pilih Bidang" ;
 			}elseif(empty($_REQUEST['d'])){
 					$err = "Pilih SKPD" ;
 			}else{
 					if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PENGADAAN' and c1 ='".$_REQUEST['c1']."' and c ='".$_REQUEST['c']."' and d ='".$_REQUEST['d']."'")) !=0 && mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PEMELIHARAAN' and c1 ='".$_REQUEST['c1']."' and c ='".$_REQUEST['c']."' and d ='".$_REQUEST['d']."'")) !=0 && mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PERSEDIAAN' and c1 ='".$_REQUEST['c1']."' and c ='".$_REQUEST['c']."' and d ='".$_REQUEST['d']."'")) !=0 ){
 							$kondisiSKPD = " and c1 = '".$_REQUEST['c1']."' and c = '".$_REQUEST['c']."' and d = '".$_REQUEST['d']."'";

							$notice = "Data RKBMD sudah ditetapkan, proses sinkronisasi sudah tidak dapat merubah data RKBMD. Yakin ?";
							$noticeErr = 0;
 					}else{
 							if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PENGADAAN' and c1 ='".$_REQUEST['c1']."' and c ='".$_REQUEST['c']."' and d ='".$_REQUEST['d']."'")) ==0 ){
 								//	$err = "RKBMD PENGADAAN BELUM DI TETAPKAN";
 							}

 							if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PEMELIHARAAN' and c1 ='".$_REQUEST['c1']."' and c ='".$_REQUEST['c']."' and d ='".$_REQUEST['d']."'")) ==0 ){
 							//		$err = "RKBMD PEMELIHARAAN BELUM DI TETAPKAN";
 							}

 							if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PERSEDIAAN' and c1 ='".$_REQUEST['c1']."' and c ='".$_REQUEST['c']."' and d ='".$_REQUEST['d']."'")) ==0 ){
 								//	$err = "RKBMD PERSEDIAAN BELUM DI TETAPKAN";
 							}
							$notice = "Data RKBMD belum ditetapkan, proses sikronisasi data tidak dapat dilakukan. Silahkan tetapkan RKBMD terlebih dahulu.";
							$noticeErr = 1;
 					}
					$getDataUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '".$_REQUEST['c1']."' and c = '00'"));
					$getDataBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '".$_REQUEST['c1']."' and c = '".$_REQUEST['c']."' and d = '00'"));
					$getDataSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '".$_REQUEST['c1']."' and c = '".$_REQUEST['c']."' and d = '".$_REQUEST['d']."'"));
					$namaUrusan = $_REQUEST['c1'].". ".$getDataUrusan['nm_skpd'];
					$namaBidang = $_REQUEST['c'].". ".$getDataUrusan['nm_skpd'];
					$namaSKPD = $_REQUEST['d'].". ".$getDataUrusan['nm_skpd'];
 			}
 	}else{
			$namaUrusan = "SEMUA URUSAN";
			$namaBidang = "SEMUA BIDANG";
			$namaSKPD = "SEMUA SKPD";
			$notice = "Data RKBMD sudah ditetapkan, proses sinkronisasi sudah tidak dapat merubah data RKBMD. Yakin ?";
			$noticeErr = 0;
	}

if(empty($noticeErr)){
	$buttonSync = "<input type='button' value='Sync' onclick ='".$this->Prefix.".closeNotice()' > &nbsp ".
	"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
}else{
	$buttonSync =
	"<input type='button' value='OK' onclick ='".$this->Prefix.".Close()' >";
}
	 //items ----------------------
	  $this->form_fields = array(
			'1' => array(
						'label'=>'URUSAN',
						'labelWidth'=>100,
						'value'=>$namaUrusan
						 ),
			'2' => array(
						'label'=>'BIDANG',
						'labelWidth'=>100,
						'value'=>$namaBidang,
						 ),
			'3' => array(
						'label'=>'SKPD',
						'labelWidth'=>100,
						'value'=>$namaSKPD,
						 ),
			'4' => array(
						'label'=>'',
						'labelWidth'=>150,
						'value'=>"<span style='color:red;'>* $notice</span>",
						'type' => 'merge'
						 )


			);
		//tombol
		$this->form_menubawah =
			$buttonSync
			;

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

function infoSKPD($id_anggaran){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 200;
	 $this->form_caption = 'INFO SKPD';

	 $getData = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id_anggaran'"));
	 foreach ($getData as $key => $value) {
			 	 $$key = $value;
	 }

	 $urusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 ='$c1' and c ='00' and d = '00' and e='00' and e1='000'"));
	 $urusan = $c1.". ".$urusan['nm_skpd'];
	 $bidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 ='$c1' and c ='$c' and d = '00' and e='00' and e1='000'"));
	 $bidang = $c.". ".$bidang['nm_skpd'];
	 $skpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 ='$c1' and c ='$c' and d = '$d' and e='00' and e1='000'"));
	 $skpd = $d.". ".$skpd['nm_skpd'];
	 $unit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 ='$c1' and c ='$c' and d = '$d' and e='$e' and e1='000'"));
	 $unit = $e.". ".$unit['nm_skpd'];
	 $subUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 ='$c1' and c ='$c' and d = '$d' and e='$e' and e1='$e1'"));
	 $subUnit = $e1.". ".$subUnit['nm_skpd'];
	 $program = mysql_fetch_array(mysql_query("select * from ref_program where ck = '$ck' and bk = '$bk' and dk = '$dk' and p='$p' and q='0'"));
	 $program = $p.". ".$program['nama'];
	 $kegiatan = mysql_fetch_array(mysql_query("select * from ref_program where ck = '$ck' and bk = '$bk' and dk = '$dk' and p='$p' and q='0'"));
	 $kegiatan = $q.". ".$kegiatan['nama'];
	 if($catatan == "PEMELIHARAAN"){
	 	$jenisRKBMD = "PEMELIHARAAN";
		$catatan = "-";
	 }else{
	 	$jenisRKBMD = "PENGADAAN";
	 }

	 $jenisPemeliharaan = mysql_fetch_array(mysql_query("select * from ref_jenis_pemeliharaan where Id = '$id_jenis_pemeliharaan'"));
	 $jenisPemeliharaan = $jenisPemeliharaan['jenis'];
		if($j !='000'){
			if($id_jenis_pemeliharaan == "0"){
				$this->form_fields = array(
			'1' => array(
						'label'=>'URUSAN',
						'labelWidth'=>150,
						'value'=>$urusan,
						 ),
			'2' => array(
						'label'=>'BIDANG',
						'labelWidth'=>150,
						'value'=>$bidang,
						 ),
			'3' => array(
						'label'=>'SKPD',
						'labelWidth'=>150,
						'value'=>$skpd,
						 ),
			'4' => array(
						'label'=>'UNIT',
						'labelWidth'=>150,
						'value'=>$unit,
						 ),
			'5' => array(
						'label'=>'SUB UNIT',
						'labelWidth'=>150,
						'value'=>$subUnit,
						 ),
			'6' => array(
						'label'=>'PROGRAM',
						'labelWidth'=>150,
						'value'=>$program,
						 ),
			'7' => array(
						'label'=>'KEGIATAN',
						'labelWidth'=>150,
						'value'=> $kegiatan,
						 ),
			 '8' => array(
						'label'=>'JENIS RKBMD',
						'labelWidth'=>150,
						'value'=> $jenisRKBMD,
						 ),
			'9' => array(
						'label'=>'CARA PEMENUHAN',
						'labelWidth'=>150,
						'value'=> $catatan,
						 ),
			);
			}else{
				$this->form_fields = array(
			'1' => array(
						'label'=>'URUSAN',
						'labelWidth'=>150,
						'value'=>$urusan,
						 ),
			'2' => array(
						'label'=>'BIDANG',
						'labelWidth'=>150,
						'value'=>$bidang,
						 ),
			'3' => array(
						'label'=>'SKPD',
						'labelWidth'=>150,
						'value'=>$skpd,
						 ),
			'4' => array(
						'label'=>'UNIT',
						'labelWidth'=>150,
						'value'=>$unit,
						 ),
			'5' => array(
						'label'=>'SUB UNIT',
						'labelWidth'=>150,
						'value'=>$subUnit,
						 ),
			'6' => array(
						'label'=>'PROGRAM',
						'labelWidth'=>150,
						'value'=>$program,
						 ),
			'7' => array(
						'label'=>'KEGIATAN',
						'labelWidth'=>150,
						'value'=> $kegiatan,
						 ),
			 '8' => array(
						'label'=>'JENIS RKBMD',
						'labelWidth'=>150,
						'value'=> $jenisRKBMD,
						 ),
			'9' => array(
						'label'=>'JENIS PEMELIHARAAN',
						'labelWidth'=>150,
						'value'=> $jenisPemeliharaan,
						 ),
			);
			}

		}else{
			$this->form_fields = array(
			'1' => array(
						'label'=>'URUSAN',
						'labelWidth'=>150,
						'value'=>$urusan,
						 ),
			'2' => array(
						'label'=>'BIDANG',
						'labelWidth'=>150,
						'value'=>$bidang,
						 ),
			'3' => array(
						'label'=>'SKPD',
						'labelWidth'=>150,
						'value'=>$skpd,
						 ),
			'6' => array(
						'label'=>'PROGRAM',
						'labelWidth'=>150,
						'value'=>$program,
						 ),
			'7' => array(
						'label'=>'KEGIATAN',
						'labelWidth'=>150,
						'value'=> $kegiatan,
						 ),
			);
		}


		$this->form_menubawah =
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;
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

		 $getProgram = mysql_fetch_array(mysql_query("select concat(p,'. ',nama) as nama from ref_program where bk='$bk' and ck='$ck' and dk = '$dk' and p = '$p' and q= '0'"));
		 $namaProgram = $getProgram['nama'];
		 $program = "<input type ='hidden' name='bk' id='bk' value = '$bk' > <input type ='hidden' name='ck' id='ck' value = '$ck' ><input type ='hidden' name='dk' id='dk' value = '$dk' > <input type ='hidden' name='p' id='p' value = '$p' > <input type ='text'  value = '$namaProgram' style='width:400px;' readonly>";

		 $getKegiatan = mysql_fetch_array(mysql_query("select concat(q,'. ',nama) as nama from ref_program where bk='$bk' and ck='$ck' and dk = '$dk' and p = '$p' and q= '$q'"));
		 $namaKegiatan = $getKegiatan['nama'];
		 $kegiatan = "<input type ='hidden' name='q' id='q' value = '$q' > <input type ='text'  value = '$namaKegiatan' style='width:400px;' readonly>";

		 $kodeRENJA = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
		 $hargaSatuan = $satuan_rek;
		 $kodeBarang = $f.".".$g.".".$h.".".$i.".".$j ;
		 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
		 $namaBarang = $getNamaBarang['nm_barang'];
		 $kodeRekening = $k.".".$l.".".$m.".".$n.".".$o ;
		 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
		 $namaRekening = $getNamaRekening['nm_rekening'];
		 $arrayJenisRKA = array(
						array("2.2.1","RKA-SKPD 2.2.1"),
						array("2.1","RKA-SKPD 2.1")

						);
		 $jenis_rka = $jenis_rka;
		 $cmbJenisRKA = cmbArray('cmbJenisRKAForm',$jenis_rka,$arrayJenisRKA,'-- JENIS RKA --','onchange=rkaSKPD221.unlockFindRekening();');
	 	 if(empty($jenis_rka)){
		 	$tergantungJenis = "disabled";
		 }

		 $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
		 $getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));
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
						'value'=> "<input type='hidden' name = 'bk' id = 'bk' value='$bk'> <input type='hidden' name = 'ck' id = 'ck' value='$ck'> <input type='hidden' name = 'dk' id = 'dk' value='$dk'>".$program
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
						 <button type='button' id='findRekening' onclick=rkaSKPD221.findRekening('$jenis_rka'); $tergantungJenis> CARI </button> "
						 ),
			'kode8' => array(
						'label'=>'HARGA SATUAN',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='rkaSKPD221.bantu();' > <span id='bantu' style='color:red;'> </span>"
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



	 if ($this->jenisForm == "PENYUSUNAN"){
	 	if($this->wajibValidasi == TRUE)$tergantung = "<th class='th01' rowspan='2' width='100' >VALIDASI</th>";
		$headerTable =
		  "<thead>
		   <tr>


		   <th class='th01' width='100'  rowspan='2' >KODE REKENING </th>
		   <th class='th01' width='700'  id='headerUraian'  rowspan='2' >URAIAN</th>
		   <th class='th02' colspan='3'  rowspan='1' width='800' >RINCIAN PENGHITUNGAN</th>
		   <th class='th01' width='120'  rowspan='2' >JUMLAH HARGA</th>

		   $tergantung

		   </tr>
		   <tr>
		   <th class='th01' id='headerVolume' >VOLUME</th>
		   <th class='th01' >SATUAN</th>
		   <th class='th01' >HARGA SATUAN</th>


		   </tr>

		   </thead>";
	 }elseif ($this->jenisForm == "KOREKSI"){
	 	$Checkbox = "";
	 	$tergantungJenisForm = "
		<th class='th02' rowspan='1' colspan='3' width='600'>KOREKSI</th>
		<th class='th02' rowspan='1' colspan='3' width='600'>BERTAMBAH/(BERKURANG)</th>
		<th class='th01' rowspan='2' width='200'>AKSI</th>
		";
		$headerTable =
		  "<thead>
		   <tr>
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='900'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='600' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' width='80'  rowspan='2' >JUMLAH HARGA</th>
		   $tergantungJenisForm

		   </tr>
		   <tr>
		   <th class='th01'  >VOLUME</th>
		   <th class='th01'  >SATUAN</th>
		   <th class='th01' width='200' >HARGA SATUAN</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >HARGA SATUAN</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >HARGA SATUAN</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   </tr>
		   </thead>";
	 }else{
	    // $Checkbox = "";
		if($this->jenisFormTerakhir == "PENYUSUNAN"){
			if($this->wajibValidasi == TRUE)$tergantung = "<th class='th01' rowspan='2' width='100' >VALIDASI</th>";
			$headerTable =
			  "<thead>
			   <tr>


			   <th class='th01' width='100'  rowspan='2' >KODE REKENING </th>
			   <th class='th01' width='700'  rowspan='2' >URAIAN</th>
			   <th class='th02' colspan='3'  rowspan='1' width='800' >RINCIAN PENGHITUNGAN</th>
			   <th class='th01' width='120'  rowspan='2' >JUMLAH HARGA</th>

			   $tergantung

			   </tr>
			   <tr>
			   <th class='th01' >VOLUME</th>
			   <th class='th01' >SATUAN</th>
			   <th class='th01' >HARGA SATUAN</th>


			   </tr>

			   </thead>";
		}elseif($this->jenisFormTerakhir == "KOREKSI"){
			$Checkbox = "";
	 	$tergantungJenisForm = "
		<th class='th02' rowspan='1' colspan='3' width='600'>KOREKSI</th>
		<th class='th02' rowspan='1' colspan='3' width='600'>BERTAMBAH/(BERKURANG)</th>
		";
		$headerTable =
		  "<thead>
		   <tr>
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='900'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='600' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' width='200'  rowspan='2' >JUMLAH HARGA</th>
		   $tergantungJenisForm

		   </tr>
		   <tr>
		   <th class='th01'  >VOLUME</th>
		   <th class='th01'  >SATUAN</th>
		   <th class='th01' width='200' >HARGA SATUAN</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >HARGA SATUAN</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >HARGA SATUAN</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   </tr>
		   </thead>";
		}

	 }
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
			 if(!empty($p) && $q== '0'){
				 		//Program
						$boldStatus = "bold";
						$kode = $bk.".".$ck.".".$dk.".".$p;
						$getNamaKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='0'"));
						$uraianList = $getNamaKegiatan['nama'];
				 		$kodeRekening = "";
						$TampilCheckBox = "";
						$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' $kondisiSKPD $kondisiRekening"));
						$jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
			 }elseif(!empty($p) && !empty($q) && empty($k) && empty($l) && empty($m)  && empty($n)  && empty($o)  && empty($id_rincian_belanja) ){
				 		//Kegiatan
						$boldStatus = "bold";
						$marginStatus = "10px;";
						$kode = $bk.".".$ck.".".$dk.".".$p.".".$q;
						$getNamaKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'"));
						$uraianList = $getNamaKegiatan['nama'];
						$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' $kondisiSKPD $kondisiRekening"));
						$jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
					//	$kodeRekening = $this->injectQuery;
			 }elseif(!empty($p) && !empty($q) && !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && empty($id_rincian_belanja) ){
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

						$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiRekening"));
						$jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
						$TampilCheckBox = "";
			 }elseif(!empty($p) && !empty($q) && !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && empty($rincian_perhitungan)){
				 		//RincianBelanja
						$boldStatus = "";
						$marginStatus = "10px;";
						$kode = "";
						$getNamaRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where id = '$id_rincian_belanja'"));
						$uraianList = "<span style='cursor:pointer;' class='uraianList' onclick=$this->Prefix.editRincianBelanja($id_anggaran,$id_rincian_belanja); id ='spanEditRincianBelanja$id_anggaran'>".$getNamaRincianBelanja['nama_rincian_belanja']."</span>";
						$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja='$id_rincian_belanja' $kondisiSKPD $kondisiRekening"));
						$jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');
						$TampilCheckBox = "";
			 }elseif(!empty($p) && !empty($q) && !empty($k) && !empty($l) && !empty($m)  && !empty($n)  && !empty($o)  && !empty($id_rincian_belanja)  && !empty($rincian_perhitungan) ){
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
						$this->subTotal += $jumlah_harga;
						$TampilCheckBox = "";
			 }

			//  $Koloms[] = array(' align="left"', "<span style='color:$warnaMapping;margin-left:$marginKode;' id='actionSpan$id_anggaran'>$kode</span>" );
			 $Koloms[] = array(' align="left"', "<span style='color:$warnaMapping;margin-left:$marginKode;'  >$kode</span>" );
			 $Koloms[] = array(' align="left"', "<span style='font-weight:$boldStatus;margin-left:$marginStatus;'>$uraianList</span> <div style='float:right' id='uraianVolume$id_anggaran'>".$isi['rincian_volume']."</div>" );
			 $Koloms[] = array(" align='right' id='tdVolumeRekening$id_anggaran'","<span  id='actionSpanRincianBelanja$id_anggaran'>" .$volumeRekening."</span>" );
			 $Koloms[] = array(' align="left"', $satuanRekening );
			 $Koloms[] = array(' align="right"', $hargaSatuan );
			 $Koloms[] = array(' align="right"',  "<span style='font-weight:$boldStatus;' id='actionSpan$id_anggaran'>$jumlahHarga</span>" );
			 //$Koloms[] = array(' align="right"', $catatan );


			// if(!empty($cmbSKPD) && empty($cmbUnit)){
			// 	if(in_array($id_anggaran, $this->publicExcept)) {
			//
			// 	}elseif($j != '000' && mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',k,'.',l,'.',m,'.',n,'.',o,'.',catatan,'.',id_jenis_pemeliharaan) = '$grubId' and id_tahap = '$this->idTahap' ")) > 1 ){
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
	 $this->form_caption = 'VALIDASI RKA-SKPD 2.2.1';
	 $kode = $dt['c1'].".".$dt['c'].".".$dt['d'].".".$dt['e'].".".$dt['e1'].".".$dt['bk'].".".$dt['ck'].".".$dt['dk'].".".$dt['p'].".".$dt['q'].".".$dt['o1'];
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


	function Posting(){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
	 $this->form_width = 300;
	 $this->form_height = 50;
	 $this->form_caption = 'POSTING';
	 $arrayPosting = array(
		 										array('9','DPA'),
	 										);
	 $cmbPosting =  cmbArray('cmbPosting',"DPA",$arrayPosting,'-- POSTING --',"onchange=$this->Prefix.tujuanPostingChanged();");

	 //items ----------------------
	  $this->form_fields = array(
			's' => array(
						'label'=>'POSTING KE',
						'labelWidth'=>100,
						'value'=>$cmbPosting."<input type='hidden' name='jenisForm' id='jenisForm' >
						 <input type='hidden' name='namaTahap' id='namaTahap'>
						 <input type='hidden' name='namaModul' id='namaModul'>
						<input type='hidden' name='tahunAnggaran' id='tahunAnggaran' value='$this->tahun'>
						",
						 ),


			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='POST' onclick ='".$this->Prefix.".postDataRka()' title='POST' >   ".
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
		$urusan = cmbQuery('cmbUrusan',$selectedC1,$codeAndNameUrusan,'onchange=rkaSKPD221.refreshList(true);','-- URUSAN --');

		$codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c !='00' and d='00' and e='00' and e1='000' ";
		$bidang = cmbQuery('cmbBidang',$selectedC,$codeAndNameBidang,'onchange=rkaSKPD221.refreshList(true);','-- BIDANG --');

		$codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d!='00' and e='00' and e1='000' ";
		$skpd= cmbQuery('cmbSKPD',$selectedD,$codeAndNameSKPD,'onchange=rkaSKPD221.refreshList(true);','-- SKPD --');

		$codeAndNameUnit = "select e, concat(e, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e!='00' and e1='000' ";
		$unit = cmbQuery('cmbUnit',$selectedE,$codeAndNameUnit,'onchange=rkaSKPD221.refreshList(true);','-- UNIT --');


		$codeAndNameSubUnit = "select e1, concat(e1, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1!='000' ";
		$subunit = cmbQuery('cmbSubUnit',$selectedE1,$codeAndNameSubUnit,'onchange=rkaSKPD221.refreshList(true);','-- SUB UNIT --');



	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran) as max from view_renja where tahun='$this->tahun' and jenis_anggaran = 'MURNI' "));
	$maxID = $get1['max'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_renja where id_anggaran = '$maxID' "));
	$nomorUrutSebelumnya =  $get2['no_urut'];




		$codeAndNameProgram = mysql_query("select tabel_anggaran.bk, tabel_anggaran.ck, tabel_anggaran.dk, tabel_anggaran.p as pFromProgram, tabel_anggaran.q  , ref_program.nama from tabel_anggaran  inner join ref_program on tabel_anggaran.bk = ref_program.bk and tabel_anggaran.ck = ref_program.ck and tabel_anggaran.dk = ref_program.dk and tabel_anggaran.p = ref_program.p and tabel_anggaran.q = ref_program.q  inner join ref_tahap_anggaran on tabel_anggaran.id_tahap = ref_tahap_anggaran.id_tahap where ref_tahap_anggaran.no_urut = '$nomorUrutSebelumnya' and tabel_anggaran.tahun ='$this->tahun' and tabel_anggaran.jenis_anggaran = '$this->jenisAnggaran' and tabel_anggaran.c1 = '$selectedC1' and tabel_anggaran.c = '$selectedC' and tabel_anggaran.d = '$selectedD'  and tabel_anggaran.q='0' and concat(tabel_anggaran.bk,'.',tabel_anggaran.ck,'.',tabel_anggaran.dk,'.',tabel_anggaran.p) !='0.0.0.0'  ");

	$pSama = "";
	$arrayP = array() ;
	while($rows = mysql_fetch_array($codeAndNameProgram)){
		foreach ($rows as $key => $value) {
				  $$key = $value;
		}

			$concat = $bk.".".$ck.".".$dk.".".$pFromProgram ;
			if($concat != ".."){
				if($concat == $pSama){
				}else{
					if(mysql_num_rows(mysql_query("select * from view_renja where q !='0' and concat(bk,'.',ck,'.',dk,'.',p) ='$concat' and tahun ='$this->tahun' and jenis_anggaran ='MURNI'")) != 0){
						array_push($arrayP,
							array($concat,$nama  )
						);
					}

				}
			}






		$pSama = $concat;
	}

	$program = "<input type='hidden' id='bk' name='bk' value='$selectedBK'> <input type='hidden' id='ck' name='ck' value='$selectedCK'> <input type='hidden' id='dk' name='dk' value='$selectedDK'> <input type='hidden' id='hiddenP' name='hiddenP' value='$selectedP'>".cmbArray('p',$_REQUEST['p'],$arrayP,'-- PROGRAM --','onchange=rkaSKPD221.programChanged();');


		$codeAndNameKegiatan = mysql_query("select tabel_anggaran.bk, tabel_anggaran.ck, tabel_anggaran.dk, tabel_anggaran.p, tabel_anggaran.q, ref_program.nama from tabel_anggaran  inner join ref_program on tabel_anggaran.bk = ref_program.bk and tabel_anggaran.ck = ref_program.ck and tabel_anggaran.dk = ref_program.dk and tabel_anggaran.p = ref_program.p and tabel_anggaran.q = ref_program.q  inner join ref_tahap_anggaran on tabel_anggaran.id_tahap = ref_tahap_anggaran.id_tahap where  ref_tahap_anggaran.no_urut = '$nomorUrutSebelumnya' and tabel_anggaran.tahun ='$this->tahun' and tabel_anggaran.jenis_anggaran = '$this->jenisAnggaran' and tabel_anggaran.c1 = '$selectedC1' and tabel_anggaran.c = '$selectedC' and tabel_anggaran.d = '$selectedD' and tabel_anggaran.q !='0' and tabel_anggaran.bk='$selectedBK' and tabel_anggaran.ck='$selectedCK' and tabel_anggaran.dk='$selectedDK' and tabel_anggaran.p='$selectedP'  ");

	$qSama = "";
	$arrayQ = array() ;
	while($rows = mysql_fetch_array($codeAndNameKegiatan)){
		foreach ($rows as $key => $value) {
				  $$key = $value;
		}
		if($q != 0) {
			if($q == $qSama){
			}else{
				array_push($arrayQ,
				   array($q,$nama)
				);
			}
		}




		$qSama = $q;
	}

	$kegiatan = cmbArray('q',$_REQUEST['q'],$arrayQ,'-- KEGIATAN --','onchange=rkaSKPD221.refreshList(true);');


	if($this->jenisForm == "KOREKSI" || $this->jenisForm == "PENYUSUNAN" || $this->jenisForm == "VALIDASI"){
		$getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		$idTahapRenja = $getIdTahapRenjaTerakhir['max'];

		$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
		$getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$this->idTahap'  "));
		$cekDulu=mysql_num_rows(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja'"));
		if($cekDulu == 0){
			$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD'  and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
			$getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD'  and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$this->idTahap'  "));

		}
		$angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');

		$sisaPagu = $getPaguIndikatif['jumlah'] - $getPaguYangTerpakai['paguYangTerpakai'];
		$sisaPagu =  number_format($sisaPagu ,2,',','.');
		$paguIndikatif = "<input type='text' value='$angkaPaguIndikatif' readonly> &nbsp &nbsp &nbsp SISA PAGU  :  <input type='text' value='$sisaPagu' readonly>";

	}else{
		$getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		$idTahapRenja = $getIdTahapRenjaTerakhir['max'];
		$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
		$cekDulu = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
		$getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and no_urut = '$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  "));

		if($cekDulu ==0){
			$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD'  and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
			$getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD'  and bk='$selectedBK' and ck='$selectedCK' and dk='$selectedDK' and p='$selectedP' and q='$selectedQ' and no_urut = '$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  "));

		}
		$angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');

		$sisaPagu = $getPaguIndikatif['jumlah'] - $getPaguYangTerpakai['paguYangTerpakai'];
		$sisaPagu =  number_format($sisaPagu ,2,',','.');
		$paguIndikatif = "<input type='text' value='$angkaPaguIndikatif' readonly> &nbsp &nbsp &nbsp SISA PAGU  :  <input type='text' value='$sisaPagu' readonly>";

	}
	$arrayBelanja = array(
						   array('BELANJA PEGAWAI','BELANJA PEGAWAI'),
						   array('BELANJA BELANJA BARANG & JASA','BELANJA BARANG & JASA'),
						   array('BELANJA MODAL','BELANJA MODAL'),
					);
	$cmbBelanja = cmbArray('cmbBelanja',$_REQUEST['cmbBelanja'],$arrayBelanja,'-- JENIS BELANJA--','onchange=rkaSKPD221.refreshList(true);');

	$jumlahData = $_REQUEST['jumlahData'];
	if(empty($jumlahData)){
			$jumlahData = 50;
	}
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
			<td>PROGRAM</td>
			<td>:</td>
			<td style='width:86%;'>$this->injectQuery
			<input type='hidden' name='tahun' id='tahun' value='$this->tahun' style='width:40px;' > <input type='hidden' name ='cmbJenisRKA' id='cmbJenisRKA' value='2.2.1'>
			".$program."
			</td>
			</tr>
			<tr>
			<td>KEGIATAN</td>
			<td>:</td>
			<td style='width:86%;'>
			".$kegiatan."
			</td>
			</tr>
			</table>".
			"</div>"."<div class='FilterBar' style='margin-top:5px;'>"."
			<table style='width:100%'>
			<tr>
			<td>PAGU INDIKATIF</td>
			<td>:</td>
			<td style='width:86%;'>
			".$paguIndikatif."&nbsp &nbsp JENIS BELANJA &nbsp : $cmbBelanja "."
			</td>
			</tr>
			<tr>
			<td>JUMLAH DATA</td>
			<td>:</td>
			<td style='width:86%;'>
				<input type='text' name ='jumlahData' id='jumlahData' value ='$jumlahData' style='width:40px;'>  &nbsp <input type='button' onclick =$this->Prefix.refreshList(true); value='Tampilkan'>
			</td>
			</tr>


			</table>"

			;
			// <tr>
			// <td>UNIT</td>
			// <td>:</td>
			// <td style='width:86%;'>
			// ".$unit."&nbsp&nbsp SUB UNIT &nbsp".$subunit."
			// </td>
			// </tr>
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

		$blackListSubRincian = array();
		$getAllSubRincian = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and (j!='000' or rincian_perhitungan !='' )");
		while($subRincian = mysql_fetch_array($getAllSubRincian)){
					if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening")) == 0){
							$blackListSubRincian[] = "id_anggaran != '".$subRincian['id_anggaran']."'";
							$arrKondisi[] = "id_anggaran !='".$subRincian['id_anggaran']."'";
							// $this->injectQuery = "select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening";
					}
		}
		$kondisiBlackListSubRincian= join(' and ',$blackListSubRincian);
		if(sizeof($blackListSubRincian) == 0){
			$kondisiBlackListSubRincian = "";
		}elseif(sizeof($blackListSubRincian) > 0){
			$kondisiBlackListSubRincian = " and ".$kondisiBlackListSubRincian;
		}

		$blackListRincian = array();
		$getAllRincian =  mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja != '' and id_rincian_belanja !='0' and j='000' and rincian_perhitungan = '' ");
		while($rincianBelanja = mysql_fetch_array($getAllRincian)){
				if(mysql_num_rows(mysql_query("select  * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk = '".$rincianBelanja['bk']."' and ck = '".$rincianBelanja['ck']."' and dk = '".$rincianBelanja['dk']."' and p = '".$rincianBelanja['p']."' and q = '".$rincianBelanja['q']."' and k = '".$rincianBelanja['k']."' and l = '".$rincianBelanja['l']."'  and m = '".$rincianBelanja['m']."'  and n = '".$rincianBelanja['n']."' and o = '".$rincianBelanja['o']."' and id_rincian_belanja = '".$rincianBelanja['id_rincian_belanja']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
						$blackListRincian[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
						$arrKondisi[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
				}

		}

		$blackListRekening = array();
		$getAllRekening =  mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
		while($rekeningBelanja = mysql_fetch_array($getAllRekening)){
				if(mysql_num_rows(mysql_query("select  * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk = '".$rekeningBelanja['bk']."' and ck = '".$rekeningBelanja['ck']."' and dk = '".$rekeningBelanja['dk']."' and p = '".$rekeningBelanja['p']."' and q = '".$rekeningBelanja['q']."' and k = '".$rekeningBelanja['k']."' and l = '".$rekeningBelanja['l']."'  and m = '".$rekeningBelanja['m']."'  and n = '".$rekeningBelanja['n']."' and o = '".$rekeningBelanja['o']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
						$blackListRekening[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
						$arrKondisi[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
				}
		}


		// $blackListKegiatan = array();
		// $getAllKegiatan =  mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k ='0' and l ='0'  and m ='0'   and n ='0'  and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
		// while($kegiatanBelanja = mysql_fetch_array($getAllKegiatan)){
		// 		if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and bk = '".$kegiatanBelanja['bk']."' and ck = '".$kegiatanBelanja['ck']."' and dk = '".$kegiatanBelanja['dk']."' and p = '".$kegiatanBelanja['p']."' and q = '".$kegiatanBelanja['q']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
		// 				$blackListKegiatan[] = "id_anggaran !='".$kegiatanBelanja['id_anggaran']."'";
		// 				$arrKondisi[] = "id_anggaran !='".$kegiatanBelanja['id_anggaran']."'";
		// 		}
		// }
    //
		// $blackListKegiatan = array();
		// $getAllProgram =  mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and p != '0' and q ='0'  ");
		// while($programBelanja = mysql_fetch_array($getAllProgram)){
		// 		if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and bk = '".$programBelanja['bk']."' and ck = '".$programBelanja['ck']."' and dk = '".$programBelanja['dk']."' and p = '".$programBelanja['p']."'  and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
		// 				$arrKondisi[] = "id_anggaran !='".$programBelanja['id_anggaran']."'";
		// 				$arrKondisi[] = "id_anggaran !='".$programBelanja['id_anggaran']."'";
		// 		}
		// }


		$arrKondisi[] = "k !='' and k !='0'";






		$arrKondisi[] = "id_tahap = '$this->idTahap' ";
		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi ;
		$this->publicKondisi = $Kondisi;

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




		$grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_rka_221 where username='$this->username'"));
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
		$hublaDK = $dk;
		$hublaP = $p;
		$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and bk='$bk' and ck='$ck' and dk='$dk' and p='$hiddenP' and q='$q'";
		$arrKondisi[] = "c1 = '$cmbUrusan'";
					$arrKondisi[] = "c = '$cmbBidang'";
					$arrKondisi[] = "d = '$cmbSKPD'";
					$arrKondisi[] = "ck = '$ck' ";
					$arrKondisi[] = "bk = '$bk' ";
					$arrKondisi[] = "dk = '$dk' ";
					$arrKondisi[] = " p = '$hiddenP'  ";


		$arrKondisi[] = "c1 != '0'";
		if($this->jenisForm == 'PENYUSUNAN'){
			$cekCopy = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where jenis_form_modul ='PENYUSUNAN' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			$nomorUrutSebelumnya = $this->nomorUrut;
			$getAllParent = mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap'  and o1 !='0' and k='0' and n='0' and j='000'  ");
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) {
			 	 $$key = $value;
				}
				$cekPekerjaan = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where o1 = '$o1' and id_tahap ='$this->idTahap'  $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
				if($cekPekerjaan == 0){
					$arrKondisi[] = "o1 !='$o1'";
				}else{
					$arrKondisi[] = " id_tahap='$this->idTahap'  or id_anggaran = '$id_anggaran' ";
					$getAllRekening = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
					while($row2s = mysql_fetch_array($getAllRekening)){
						foreach ($row2s as $key => $value) {
					 	 $$key = $value;
						}
						$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$this->idTahap'  $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
						if($cekRekening == 0){
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
						}else{
							$arrKondisi[] = " id_tahap='$this->idTahap'  or id_anggaran = '$id_anggaran'  ";
							$getAllProgram = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
							while($row3s = mysql_fetch_array($getAllProgram)){
								foreach ($row3s as $key => $value) {
							 	 $$key = $value;
								}
								$cekProgram = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and id_tahap ='$this->idTahap'  $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
								if($cekProgram == 0){
									$concat = $bk.".".$ck.".".$dk.".".$p;
									$arrKondisi[] = "concat(bk,'.',ck,'.',dk,'.',p)  !='$concat'";
								}else{
									$arrKondisi[] = " id_tahap='$this->idTahap'  or id_anggaran = '$id_anggaran'   ";
									$getAllKegiatan = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
									while($row4s = mysql_fetch_array($getAllKegiatan)){
										foreach ($row4s as $key => $value) {
									 	 $$key = $value;
										}
										$cekKegiatan = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and id_tahap ='$this->idTahap'  $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
										if($cekKegiatan == 0){
											$concat = $bk.".".$ck.".".$dk.".".$p;
											$arrKondisi[] = "concat(bk,'.',ck,'.',dk,'.',p)  !='$concat'";
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


				$grabNonMapingRekening= mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and (LENGTH(k) > 1) and j='000'");
				while($got = mysql_fetch_array($grabNonMapingRekening)){
					if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and ( rincian_perhitungan !='' or  j!='000' )  $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}

				}

				$grabNonHostedRekening= mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and (LENGTH(k) = 1 and k !='0') and j='000'");
				while($got = mysql_fetch_array($grabNonHostedRekening)){
					if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap ='$this->idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and ( rincian_perhitungan !='' or  j!='000' )  $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}

				}


			$arrKondisi[] = "id_tahap = '$this->idTahap' ";

		}elseif($this->jenisForm == 'KOREKSI'){
			$nomorUrutSebelumnya = $this->nomorUrut;
			$getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
			$idTahap = $getIDTahap['id_tahap'];
			$getAllParent = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and j='000'  ");
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) {
			 	 $$key = $value;
				}
				$cekPekerjaan = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where o1 = '$o1' and id_tahap = '$idTahap'  $kondisiSKPD $blackList and (rincian_perhitungan !='' or j!='000') "));
				if($cekPekerjaan == 0){
					$arrKondisi[] = "o1 !='$o1'";
				}else{
					$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran' ";
					$getAllRekening = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
					while($row2s = mysql_fetch_array($getAllRekening)){
						foreach ($row2s as $key => $value) {
					 	 $$key = $value;
						}
						$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap'  $kondisiSKPD $blackList and (rincian_perhitungan !='' or j!='000') "));
						if($cekRekening == 0){
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
						}else{
							$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'  ";
							$getAllProgram = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
							while($row3s = mysql_fetch_array($getAllProgram)){
								foreach ($row3s as $key => $value) {
							 	 $$key = $value;
								}
								$cekProgram = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and id_tahap = '$idTahap'  $kondisiSKPD $blackList and (rincian_perhitungan !='' or j!='000') "));
								if($cekProgram == 0){
									$concat = $bk.".".$ck.".".$dk.".".$p;
									$arrKondisi[] = "concat(bk,'.',ck,'.',dk,'.',p)  !='$concat'";
								}else{
									$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'   ";
									$getAllKegiatan = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
									while($row4s = mysql_fetch_array($getAllKegiatan)){
										foreach ($row4s as $key => $value) {
									 	 $$key = $value;
										}
										$cekKegiatan = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and id_tahap = '$idTahap'  $kondisiSKPD  $blackList and (rincian_perhitungan !='' or j!='000') "));
										if($cekKegiatan == 0){
											$concat = $bk.".".$ck.".".$dk.".".$p;
											$arrKondisi[] = "concat(bk,'.',ck,'.',dk,'.',p)  !='$concat'";
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


				$grabNonMapingRekening= mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and (LENGTH(k) > 1) and j='000'");
				while($got = mysql_fetch_array($grabNonMapingRekening)){
					if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and ( rincian_perhitungan !='' or  j!='000' )  $kondisiSKPD $blackList")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}

				}

				$grabNonHostedRekening= mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and j='000'");
				while($got = mysql_fetch_array($grabNonHostedRekening)){
					if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and ( rincian_perhitungan !='' or  j!='000' )  $kondisiSKPD $blackList")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}

				}





			$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";


		}else{
			if($this->jenisFormTerakhir == "KOREKSI"){
				$nomorUrutSebelumnya = $this->urutTerakhir;
				$getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran ='$this->jenisAnggaran'"));
				$idTahap = $getIDTahap['id_tahap'];
				$getAllParent = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap'  and o1 !='0' and k='0' and n='0' and j='000'  ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekPekerjaan = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where o1 = '$o1' and id_tahap = '$idTahap'  $kondisiSKPD $blackList and (rincian_perhitungan !='' or j!='000') "));
					if($cekPekerjaan == 0){
						$arrKondisi[] = "o1 !='$o1'";
					}else{
						$arrKondisi[] = " id_tahap = '$idTahap'   or id_anggaran = '$id_anggaran' ";
						$getAllRekening = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
						while($row2s = mysql_fetch_array($getAllRekening)){
							foreach ($row2s as $key => $value) {
						 	 $$key = $value;
							}
							$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap = '$idTahap'  $kondisiSKPD $blackList and (rincian_perhitungan !='' or j!='000') "));
							if($cekRekening == 0){
								$concat = $k.".".$l.".".$m.".".$n.".".$o;
								$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
							}else{
								$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'  ";
								$getAllProgram = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
								while($row3s = mysql_fetch_array($getAllProgram)){
									foreach ($row3s as $key => $value) {
								 	 $$key = $value;
									}
									$cekProgram = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and id_tahap = '$idTahap'  $kondisiSKPD $blackList and (rincian_perhitungan !='' or j!='000') "));
									if($cekProgram == 0){
										$concat = $bk.".".$ck.".".$dk.".".$p;
										$arrKondisi[] = "concat(bk,'.',ck,'.',dk,'.',p)  !='$concat'";
									}else{
										$arrKondisi[] = " id_tahap = '$idTahap'  or id_anggaran = '$id_anggaran'   ";
										$getAllKegiatan = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
										while($row4s = mysql_fetch_array($getAllKegiatan)){
											foreach ($row4s as $key => $value) {
										 	 $$key = $value;
											}
											$cekKegiatan = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and id_tahap = '$idTahap'  $kondisiSKPD  $blackList and (rincian_perhitungan !='' or j!='000') "));
											if($cekKegiatan == 0){
												$concat = $bk.".".$ck.".".$dk.".".$p;
												$arrKondisi[] = "concat(bk,'.',ck,'.',dk,'.',p)  !='$concat'";
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


					$grabNonMapingRekening= mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and (LENGTH(k) > 1) and j='000'");
					while($got = mysql_fetch_array($grabNonMapingRekening)){
						if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and ( rincian_perhitungan !='' or  j!='000' )  $kondisiSKPD $blackList")) != 0){
							$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
						}

					}

					$grabNonHostedRekening= mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and (LENGTH(k) = 1 and k !='0') and j='000'");
					while($got = mysql_fetch_array($grabNonHostedRekening)){
						if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and ( rincian_perhitungan !='' or  j!='000' )  $kondisiSKPD $blackList")) != 0){
							$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
						}

					}





				$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
			}elseif($this->jenisFormTerakhir == "PENYUSUNAN"){
				$getIDTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut ='$this->urutTerakhir' and tahun ='$this->tahun' and anggaran='$this->jenisAnggaran'"));
				$idTahap = $getIDTahap['id_tahap'];
				$getAllParent = mysql_query("select * from view_rka_2_2_1 where id_tahap ='$idTahap'  and o1 !='0' and k='0' and n='0' and j='000'  ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekPekerjaan = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where o1 = '$o1' and id_tahap ='$idTahap'  $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
					if($cekPekerjaan == 0){
						$arrKondisi[] = "o1 !='$o1'";
					}else{
						$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran' ";
						$getAllRekening = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap'  and c1 = '0' and j ='000' and rincian_perhitungan = '' and k!='0' and n !='0'  ");
						while($row2s = mysql_fetch_array($getAllRekening)){
							foreach ($row2s as $key => $value) {
						 	 $$key = $value;
							}
							$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where k ='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap ='$idTahap'  $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
							if($cekRekening == 0){
								$concat = $k.".".$l.".".$m.".".$n.".".$o;
								$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o)  !='$concat'";
							}else{
								$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'  ";
								$getAllProgram = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and p != '0' and q ='0' and j ='000' and rincian_perhitungan = ''   ");
								while($row3s = mysql_fetch_array($getAllProgram)){
									foreach ($row3s as $key => $value) {
								 	 $$key = $value;
									}
									$cekProgram = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and id_tahap ='$idTahap'  $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
									if($cekProgram == 0){
										$concat = $bk.".".$ck.".".$dk.".".$p;
										$arrKondisi[] = "concat(bk,'.',ck,'.',dk,'.',p)  !='$concat'";
									}else{
										$arrKondisi[] = " id_tahap='$idTahap'  or id_anggaran = '$id_anggaran'   ";
										$getAllKegiatan = mysql_query("select * from view_rka_2_2_1 where id_tahap = '$idTahap' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q != '0'  and j ='000' and rincian_perhitungan = ''   ");
										while($row4s = mysql_fetch_array($getAllKegiatan)){
											foreach ($row4s as $key => $value) {
										 	 $$key = $value;
											}
											$cekKegiatan = mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and id_tahap ='$idTahap'  $kondisiSKPD and (rincian_perhitungan !='' or j!='000') "));
											if($cekKegiatan == 0){
												$concat = $bk.".".$ck.".".$dk.".".$p;
												$arrKondisi[] = "concat(bk,'.',ck,'.',dk,'.',p)  !='$concat'";
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


				$grabNonMapingRekening= mysql_query("select * from view_rka_2_2_1 where id_tahap ='$idTahap' and (LENGTH(k) > 1) and j='000'");
				while($got = mysql_fetch_array($grabNonMapingRekening)){
					if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and ( rincian_perhitungan !='' or  j!='000' )  $kondisiSKPD ")) != 0){
						$arrKondisi[] = "id_tahap = '$idTahap' or id_anggaran ='".$got['id_anggaran']."'";
					}

				}

				$grabNonHostedRekening= mysql_query("select * from view_rka_2_2_1 where id_tahap ='$idTahap' and (LENGTH(k) = 1 and k !='0') and j='000'");
				while($got = mysql_fetch_array($grabNonHostedRekening)){
					if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap ='$idTahap' and k ='".$got['k']."' and l ='".$got['l']."' and m ='".$got['m']."' and n ='".$got['n']."' and o ='".$got['o']."' and ( rincian_perhitungan !='' or  j!='000' )  $kondisiSKPD ")) != 0){
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
		$qry ="select * from view_rka_2_2_1 where $Kondisi order by urut ";
		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];


		//Get Id Awal Renja

		$getIdRenja = mysql_fetch_array(mysql_query("select min(id_anggaran) from view_renja where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and bk='$hublaBK' and ck='$hublaCK' and dk='$hublaDK' and p='$hiddenP' and q='$hublaQ' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
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
		$getProgram = mysql_fetch_array(mysql_query("select * from ref_program where bk='$hublaBK' and ck='$hublaCK' and dk='$hublaDK' and p='$hublaP' and q='0'"));
		$program = $getProgram['nama'];
		$getKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$hublaBK' and ck='$hublaCK' and dk='$hublaDK' and p='$hublaP' and q='$hublaQ'"));
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
					<tr>
						<td width='10%' valign='top'>PROGRAM</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.".".$cmbBidang.".".$cmbSKPD.".".genNumber($hublaBK).".".genNumber($hublaCK).".".genNumber($hublaDK).".".genNumber($hublaP).".  </td>
						<td valign='top'>$program</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>KEGIATAN</td>
						<td width='1%' valign='top'> : </td>
						<td width='1%' valign='top'> ".$cmbUrusan.".".$cmbBidang.".".$cmbSKPD.".".genNumber($hublaBK).".".genNumber($hublaCK).".".genNumber($hublaDK).".".genNumber($hublaP).".".genNumber($hublaQ)." </td>
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
					Indikator & Tolak Ukur Kinerja Belanja Langsung
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
					Rincian Anggaran Belanja Langsung menurut Program Dan Per Kegiatan Satuan Kerja Perangkat Daerah
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
		$getTotal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_2_1 where $Kondisi  "));
		$total = number_format($getTotal['sum(jumlah_harga)'],2,',','.');
		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
			}



			 	$grabWihtCondition = mysql_query("select * from view_rka_2_2_1 where $Kondisi group by c1,c,d,bk,ck,dk,p,q,k,l,m,n,o,catatan,id_jenis_pemeliharaan");
				while($rows = mysql_fetch_array($grabWihtCondition)){
					if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where id_tahap ='$idTahap' and c1 = '".$rows['c1']."' and c='".$rows['c']."' and d='".$rows['d']."' and bk = '".$rows['bk']."' and ck ='".$rows['ck']."' and dk ='".$rows['dk']."' and p='".$rows['p']."' and q='".$rows['q']."' and f='".$rows['f']."' and g='".$rows['g']."' and h ='".$rows['h']."' and i ='".$rows['i']."' and j ='".$rows['j']."' and k='".$rows['k']."' and l = '".$rows['l']."' and m = ".$rows['m']." and n ='".$rows['n']."' and o='".$rows['o']."' and catatan = '".$rows['catatan']."' and id_jenis_pemeliharaan = '".$rows['id_jenis_pemeliharaan']."' ")) >= 2 && $rows['j'] !='000'){
						$this->publicExcept[] = $rows['id_anggaran'];
						$this->publicGrupId[] = $rows['c1'].".".$rows['c'].".".$rows['d'].".".$rows['bk'].".".$rows['ck'].".".$rows['dk'].".".$rows['p'].".".$rows['q'].".".$rows['f'].".".$rows['g'].".".$rows['h'].".".$rows['i'].".".$rows['j'].".".$rows['k'].".".$rows['l'].".".$rows['m'].".".$rows['n'].".".$rows['o'].".".$rows['catatan'].".".$rows['id_jenis_pemeliharaan'];
					}
				}


			 	$grubId = $daqry['c1'].".".$daqry['c'].".".$daqry['d'].".".$daqry['bk'].".".$daqry['ck'].".".$daqry['dk'].".".$daqry['p'].".".$daqry['q'].".".$daqry['f'].".".$daqry['g'].".".$daqry['h'].".".$daqry['i'].".".$daqry['j'].".".$daqry['k'].".".$daqry['l'].".".$daqry['m'].".".$daqry['n'].".".$daqry['o'].".".$daqry['catatan'].".".$daqry['id_jenis_pemeliharaan'];
			 	if(in_array($grubId, $this->publicGrupId)) {
					    $jumlah_harga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_2_1 where concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',k,'.',l,'.',m,'.',n,'.',o,'.',catatan,'.',id_jenis_pemeliharaan) = '$grubId' and id_tahap = '$idTahap' "));
				 		$jumlah_harga= $jumlah_harga['sum(jumlah_harga)'];
						$volume_rek  = mysql_fetch_array(mysql_query("select sum(volume_rek) from view_rka_2_2_1 where concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',k,'.',l,'.',m,'.',n,'.',o,'.',catatan,'.',id_jenis_pemeliharaan) = '$grubId' and id_tahap = '$idTahap' "));
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
				$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_2_1 where  o1 ='$o1' $kondisiSKPD $kondisiFilter  "));
				$jumlah_harga = "<span style='font-weight:bold;'>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.') . "</span>";


			}elseif($c1 == '0'){
				$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
				$jarak = "0px";
				if($o1 !='0' && $o1 !='')$jarak = "10px";
				$uraian = "<span style='font-weight:bold;margin-left:$jarak;'>".$getNamaRekening['nm_rekening']."</b>";
				$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_2_1 where  k = '$k' and l='$l' and m='$m' and n='$n' and o='$o'  $kondisiSKPD $kondisiFilter"));
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
				}elseif($j != '000' && mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j,'.',k,'.',l,'.',m,'.',n,'.',o,'.',catatan,'.',id_jenis_pemeliharaan) = '$grubId' and id_tahap = '$idTahap' ")) > 1 ){
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

				//echo json_encode($this->publicExcept);


			$no++;
			$k = "";
			$l = "";
		    $m = "";
			$n = "";
			$o = "";
			$uraian = "";
			$volume_rek = "";
			$satuan_rek = "";
			$jumlah = "";
			$jumlah_harga = "";

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
	 $selisih = $jumlahHargaForm - $resultPenjumlahan;
	 if($jenisAlokasi == "TRIWULAN"){
	 	$readOnly = "readOnly";
	 }
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
	function checkKosong($jumlah){
			if($jumlah == 0 || $jumlah == ''){
					$jumlah = "";
			}
			return $jumlah;
	}


	function syncDataRKBMD(){
			$err = "";
			$cek = "";
			$content= "";
	  $nomorUrutSebelumnya = $this->nomorUrut - 1;
	  // $getAllBarang = mysql_query("select tabel_anggaran.id_anggaran,tabel_anggaran.satuan_barang, tabel_anggaran.cara_pemenuhan ,tabel_anggaran.c1, tabel_anggaran.c, tabel_anggaran.d, tabel_anggaran.e, tabel_anggaran.e1, tabel_anggaran.bk, tabel_anggaran.ck, tabel_anggaran.dk, tabel_anggaran.p, tabel_anggaran.q, tabel_anggaran.f, tabel_anggaran.g, tabel_anggaran.h, tabel_anggaran.i, tabel_anggaran.j, tabel_anggaran.id_jenis_pemeliharaan, tabel_anggaran.uraian_pemeliharaan, tabel_anggaran.catatan, ref_barang.k11, ref_barang.l11, ref_barang.m11, ref_barang.n11, ref_barang.o11, ref_barang.k12, ref_barang.l12, ref_barang.m12, ref_barang.n12, ref_barang.o12, ref_barang.nm_barang, tabel_anggaran.volume_barang, tabel_anggaran.tahun, tabel_anggaran.jenis_anggaran, tabel_anggaran.k, tabel_anggaran.l, tabel_anggaran.m, tabel_anggaran.n, tabel_anggaran.o, tabel_anggaran.satuan1, tabel_anggaran.satuan2, tabel_anggaran.jumlah1, tabel_anggaran.jumlah2, tabel_anggaran.j1 from tabel_anggaran inner join ref_barang on  tabel_anggaran.f = ref_barang.f and tabel_anggaran.g = ref_barang.g and tabel_anggaran.h = ref_barang.h and tabel_anggaran.i = ref_barang.i and tabel_anggaran.j = ref_barang.j INNER JOIN ref_tahap_anggaran on tabel_anggaran.id_tahap = ref_tahap_anggaran.id_tahap where tabel_anggaran.tahun = '$this->tahun' and tabel_anggaran.jenis_anggaran = '$this->jenisAnggaran' and ref_tahap_anggaran.no_urut = '$nomorUrutSebelumnya' and tabel_anggaran.j !='000' and volume_barang !='0' order by tabel_anggaran.id_jenis_pemeliharaan  ");

		if(!empty($_REQUEST['c1'])){
				if(empty($_REQUEST['c'])){
						$err = "Pilih Bidang" ;
				}elseif(empty($_REQUEST['d'])){
						$err = "Pilih SKPD" ;
				}else{
					 	if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PENGADAAN' and c1 ='".$_REQUEST['c1']."' and c ='".$_REQUEST['c']."' and d ='".$_REQUEST['d']."'")) !=0 && mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PEMELIHARAAN' and c1 ='".$_REQUEST['c1']."' and c ='".$_REQUEST['c']."' and d ='".$_REQUEST['d']."'")) !=0 && mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PERSEDIAAN' and c1 ='".$_REQUEST['c1']."' and c ='".$_REQUEST['c']."' and d ='".$_REQUEST['d']."'")) !=0 ){
								$kondisiSKPD = " and c1 = '".$_REQUEST['c1']."' and c = '".$_REQUEST['c']."' and d = '".$_REQUEST['d']."'";
						}else{
								if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PENGADAAN' and c1 ='".$_REQUEST['c1']."' and c ='".$_REQUEST['c']."' and d ='".$_REQUEST['d']."'")) ==0 ){
										$err = "RKBMD PENGADAAN BELUM DI TETAPKAN";
								}

								if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PEMELIHARAAN' and c1 ='".$_REQUEST['c1']."' and c ='".$_REQUEST['c']."' and d ='".$_REQUEST['d']."'")) ==0 ){
										$err = "RKBMD PEMELIHARAAN BELUM DI TETAPKAN";
								}

								if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PERSEDIAAN' and c1 ='".$_REQUEST['c1']."' and c ='".$_REQUEST['c']."' and d ='".$_REQUEST['d']."'")) ==0 ){
										$err = "RKBMD PERSEDIAAN BELUM DI TETAPKAN";
								}
						}
				}
		}else{
			$getAllSKPD = mysql_query("select * from ref_skpd where d!='00' and e='00'");
			while($dataSKPD = mysql_fetch_array($getAllSKPD)){
					if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PENGADAAN' and c1 = '".$dataSKPD['c1']."' and c = '".$dataSKPD['c']."' and d = '".$dataSKPD['d']."'")) == 0){
							$concatSKPD = $dataSKPD['c1'].".".$dataSKPD['c'].".".$dataSKPD['d'];
							$arrayExcept[] = " concat(c1,'.',c,'.',d) !='$concatSKPD'";
					}

					if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PEMELIHARAAN' and c1 = '".$dataSKPD['c1']."' and c = '".$dataSKPD['c']."' and d = '".$dataSKPD['d']."'")) == 0){
							$concatSKPD = $dataSKPD['c1'].".".$dataSKPD['c'].".".$dataSKPD['d'];
							$arrayExcept[] = " concat(c1,'.',c,'.',d) !='$concatSKPD'";
					}

					if(mysql_num_rows(mysql_query("select * from penetapan_rkbmd where tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rkbmd = 'PERSEDIAAN' and c1 = '".$dataSKPD['c1']."' and c = '".$dataSKPD['c']."' and d = '".$dataSKPD['d']."'")) == 0){
							$concatSKPD = $dataSKPD['c1'].".".$dataSKPD['c'].".".$dataSKPD['d'];
							$arrayExcept[] = " concat(c1,'.',c,'.',d) !='$concatSKPD'";
					}
			}

			$joinExcept = join(" and ",$arrayExcept);
			if(sizeof($arrayExcept) != 0){
					$exceptSKPD = " and ".$joinExcept;
			}else{
					$exceptSKPD = "";
			}

		}
	  if(empty($err)){
			$getAllBarang = mysql_query("select * from view_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' and j!='000' and volume_barang !='0' and volume_barang !='' $kondisiSKPD $exceptSKPD");
			$cek = "select * from view_rkbmd where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' and j!='000' and volume_barang !='0' and volume_barang !='' $kondisiSKPD $exceptSKPD";
		}
	  while($rows = mysql_fetch_array($getAllBarang) ){
	      foreach ($rows as $key => $value) {
	        $$key = $value;
	      }
				if($f == "08"){
					$getRekeningRKBMD = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h='$h' and i ='$i' and j='$j' and j1='$j1'"));
				}else{
					$getRekeningRKBMD = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h='$h' and i ='$i' and j='$j' "));
				}
				$k11 = $getRekeningRKBMD['k11'];
				$l11 = $getRekeningRKBMD['l11'];
				$m11 = $getRekeningRKBMD['m11'];
				$n11 = $getRekeningRKBMD['n11'];
				$o11 = $getRekeningRKBMD['o11'];

				$k12 = $getRekeningRKBMD['k12'];
				$l12 = $getRekeningRKBMD['l12'];
				$m12 = $getRekeningRKBMD['m12'];
				$n12 = $getRekeningRKBMD['n12'];
				$o12 = $getRekeningRKBMD['o12'];

				$nm_barang = $getRekeningRKBMD['nm_barang'];



	      if(mysql_num_rows(mysql_query("select * from sync_rka where id_anggaran = '$id_anggaran'")) == 0 ){
	        $dataSync = array('id_anggaran' => $id_anggaran,'tanggal' => date("Y-m-d"));
	        mysql_query(VulnWalkerInsert("sync_rka",$dataSync));
	        //Program
	        if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='0' and id_tahap = '$this->idTahap' ")) == 0){
	            $dataProgram = array(
	                                    'c1' => '0',
	                                    'c' => '00',
	                                    'd' => '00',
	                                    'e' => '00',
	                                    'e1' => '000',
	                                    'bk' => $bk,
	                                    'ck' => $ck,
	                                    'dk' => $dk,
	                                    'p' => $p,
	                                    'q' => '0',
	                                    'tahun' => $this->tahun,
	                                    'jenis_anggaran' => $this->jenisAnggaran,
	                                    'id_tahap' => $this->idTahap,
	                                    'id_jenis_pemeliharaan' => '0',
	                                    'jenis_rka' => '2.2.1',
	                                    'nama_modul' => 'RKA-SKPD',
	                                    'f1' => '0',
	                                    'f2' => '0',
	                                    'f' => '00',
	                                    'g' => '00',
	                                    'h' => '00',
	                                    'i' => '00',
	                                    'j' => '000',
	                                  );
	                  $queryInsertProgram = VulnWalkerInsert("tabel_anggaran",$dataProgram);
	                  mysql_query($queryInsertProgram);
	        }
	        //Program
	        if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='0' and l='0' and m='0' and n='0' and o='0' and id_tahap = '$this->idTahap' ")) == 0){
	            $dataKegiatan = array(
	                                    'c1' => '0',
	                                    'c' => '00',
	                                    'd' => '00',
	                                    'e' => '00',
	                                    'e1' => '000',
	                                    'bk' => $bk,
	                                    'ck' => $ck,
	                                    'dk' => $dk,
	                                    'p' => $p,
	                                    'q' => $q,
	                                    'tahun' => $this->tahun,
	                                    'jenis_anggaran' => $this->jenisAnggaran,
	                                    'id_tahap' => $this->idTahap,
	                                    'id_jenis_pemeliharaan' => '0',
	                                    'jenis_rka' => '2.2.1',
	                                    'nama_modul' => 'RKA-SKPD',
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
	                                  );
	                  $queryInsertKegiatan = VulnWalkerInsert("tabel_anggaran",$dataKegiatan);
	                  mysql_query($queryInsertKegiatan);
	        }

	        //Rekening
	        if($id_jenis_pemeliharaan !='0'){
	          $catatan = "PEMELIHARAAN";
	        }else{
	          if($cara_pemenuhan == "SEWA"){
	            $catatan = "SEWA";
	          }else{
	            $catatan = "PEMBELIAN";
	          }
	        }
	        $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j'")) ;
	        $rincian_perhitungan = $getNamaBarang['nm_barang'];
	        //Jenis Barang Pengadaan
	        if($f !='08' && $id_jenis_pemeliharaan == 0){
	            //PEMBELIAN
	              if($cara_pemenuhan == "PEMBELIAN"){
	                //NON MAPPING
	                if(empty($k11)){
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
	                              'bk' => $bk,
	                              'ck' => $ck,
	                              'dk' => $dk,
	                              'p' => $p,
	                              'q' => $q,
	                              'k' => $f,
	                              'l' => $g,
	                              'm' => $h,
	                              'n' => $i,
	                              'o' => $j,
	                              'jenis_rka' => '2.2.1',
	                              'tahun' => $this->tahun,
	                              'jenis_anggaran' => $this->jenisAnggaran,
	                              'id_tahap' => $this->idTahap,
	                              'nama_modul' => 'RKA-SKPD',
																'sumber_dana' => 'APBD',
	                              'id_rincian_belanja' => ''
	                              );
	                    $queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
	                    if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and id_rincian_belanja=''")) == 0 ){
	                      mysql_query($queryRekening);
	                    }
	                    //Data Rincian Belanja Tidak Ada
	                    if(mysql_num_rows(mysql_query("select * from rincian_belanja where c1 = '$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and nama_rincian_belanja ='Pengadaan Barang'")) == 0){
	                      $dataRincianBelanja = array(
	                            'tahun' => $this->tahun,
	                            'jenis_anggaran' => $this->jenisAnggaran,
	                            'c1' => $c1,
	                            'c' => $c,
	                            'd' => $d,
	                            'bk' => $bk,
	                            'ck' => $ck,
	                            'dk' => $dk,
	                            'p' => $p,
	                            'q' => $q,
	                            'k' => $f,
	                            'l' => $g,
	                            'm' => $h,
	                            'n' => $i,
	                            'o' => $j,
	                            'sumber_dana' => "APBD",
	                            'nama_rincian_belanja' => "Pengadaan Barang"
	                      );
	                      mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));
	                    }
	                    //Generate Id Data Rincian Belanja
	                     $getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
	                     ='$this->jenisAnggaran' and c1 ='".$c1."' and c ='".$c."' and d ='".$d."' and bk ='".$bk."'  and ck ='".$ck."' and dk ='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$f."' and l ='".$g."' and m ='".$h."' and n ='".$i."' and o ='".$j."' and nama_rincian_belanja = 'Pengadaan Barang'  "));
	                     //Rincian Belanja
	                     if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='$c1' and c = '$c' and d='$d' and  rincian_perhitungan = '' and bk ='".$bk."' and ck ='".$ck."' and dk='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$f."' and l ='".$g."' and m ='".$h."' and n ='".$i."' and o ='".$j."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'")) ==0)
	                     {
	                      $arrayRincianBelanja = array(
	                                   'c1' => $c1,
	                                   'c' => $c,
	                                   'd' => $d,
	                                   'e' => '00',
	                                   'e1' => '000',
	                                   'f1' => '0',
	                                   'f2' => '0',
	                                   'f' => '00',
	                                   'g' => '00',
	                                   'h' => '00',
	                                   'i' => '00',
	                                   'j' => '000',
	                                   'bk'=> $bk,
	                                   'ck'=> $ck,
	                                   'dk'=> $dk,
	                                   'p' => $p,
	                                   'q' => $q,
	                                   'k' => $f,
	                                   'l' => $g,
	                                   'm' => $h,
	                                   'n' => $i,
	                                   'o' => $j,
	                                   'jenis_rka' => '2.2.1',
	                                   'tahun' => $this->tahun,
	                                   'jenis_anggaran' => $this->jenisAnggaran,
	                                   'id_tahap' => $this->idTahap,
	                                   'nama_modul' => 'RKA-SKPD',
	                                   'id_rincian_belanja' => $getIdRincianBelanja['id'],
	                                   'rincian_perhitungan' => '',
	                                    );
	                      $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
	                      mysql_query($queryRincianBelanja);
	                 }
	                    //Data Barang
											if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' ")) == 0){
	                          $data = array( 'tahun' => $this->tahun,
	                             'jenis_anggaran' => $this->jenisAnggaran,
	                             'id_tahap' => $this->idTahap,
	                             'c1' => $c1,
	                             'c'	=> $c,
	                             'd' => $d,
	                             'e' => '00',
	                             'e1' => '000',
	                             'bk' => $bk,
	                             'ck' => $ck,
	                             'dk' => $dk,
	                             'p' => $p,
	                             'q' => $q,
	                             'f' => $f,
	                             'g' => $g,
	                             'h' => $h,
	                             'i' => $i,
	                             'j' => $j,
	                             'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
	                             'catatan' => $catatan,
	                             'jenis_rka' => '2.2.1',
	                             'k' => $f,
	                             'l' => $g,
	                             'm' => $h,
	                             'n' => $i,
	                             'o' => $j,
	                             'satuan_rek' => $satuan_barang,
	                             'volume_rek' => $volume_barang,
															 'jumlah1' => $volume_barang,
															 'satuan1' => $satuan_barang,
	                             'rincian_perhitungan' => $rincian_perhitungan,
	                             'nama_modul' => 'RKA-SKPD',
	                             'id_rincian_belanja' => $getIdRincianBelanja['id'],
															 'jenis_rekening' => "BELANJA MODAL"
	                            );
	                          $query = VulnWalkerInsert('tabel_anggaran', $data);
	                          mysql_query($query);
	                    }else{
	                          $getIdSubRincian = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and id_rincian_belanja = '".$getIdRincianBelanja['id']."' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan'"));
	                          mysql_query("update tabel_anggaran set volume_rek = volume_rek + $volume_barang, jumlah1 = jumlah1 + $volume_barang  where id_anggaran = '".$getIdSubRincian['id_anggaran']."'");
	                    }

	                }
	                //MAPPING
	                else{

	                  if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and c1='0' and f = '00' and k = '$k11' and l ='$l11' and m='$m11' and n='$n11' and o='$o11' and id_rincian_belanja ='' and id_tahap='$this->idTahap' ")  ) == 0 ){
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
	                                    'bk' => $bk,
	                                    'ck' => $ck,
	                                    'dk' => $dk,
	                                    'p' => $p,
	                                    'q' => $q,
	                                    'k' => $k11,
	                                    'l' => $l11,
	                                    'm' => $m11,
	                                    'n' => $n11,
	                                    'o' => $o11,
	                                    'jenis_rka' => '2.2.1',
	                                    'tahun' => $this->tahun,
	                                    'jenis_anggaran' => $this->jenisAnggaran,
	                                    'id_tahap' => $this->idTahap,
	                                    'nama_modul' => 'RKA-SKPD',
																			'sumber_dana' => 'APBD',
	                                    'id_rincian_belanja' => ''
	                                    );
	                          $queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
	                          mysql_query($queryRekening);
	                        }
	                        //Data Rincian Belanja Tidak Ada


	                        if(mysql_num_rows(mysql_query("select * from rincian_belanja where c1 = '$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k11' and l='$l11' and m='$m11' and n='$n11' and o='$o11' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and nama_rincian_belanja = 'Pengadaan Barang'  ")) == 0){

	                          $dataRincianBelanja = array(
	                                'tahun' => $this->tahun,
	                                'jenis_anggaran' => $this->jenisAnggaran,
	                                'c1' => $c1,
	                                'c' => $c,
	                                'd' => $d,
	                                'bk' => $bk,
	                                'ck' => $ck,
	                                'dk' => $dk,
	                                'p' => $p,
	                                'q' => $q,
	                                'k' => $k11,
	                                'l' => $l11,
	                                'm' => $m11,
	                                'n' => $n11,
	                                'o' => $o11,
	                                'sumber_dana' => "APBD",
	                                'nama_rincian_belanja' => "Pengadaan Barang"
	                          );
	                          mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));

	                        }
	                        //Generate Id Data Rincian Belanja
	                         $getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
	                         ='$this->jenisAnggaran' and c1 ='".$c1."' and c ='".$c."' and d ='".$d."' and bk ='".$bk."'  and ck ='".$ck."' and dk ='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k11."' and l ='".$l11."' and m ='".$m11."' and n ='".$n11."' and o ='".$o11."' and nama_rincian_belanja = 'Pengadaan Barang'  "));
	                         //Rincian Belanja
	                         if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='$c1' and c = '$c' and d='$d' and  rincian_perhitungan = '' and bk ='".$bk."' and ck ='".$ck."' and dk='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k11."' and l ='".$l11."' and m ='".$m11."' and n ='".$n11."' and o ='".$o11."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'")) ==0)
	                         {
	                          $arrayRincianBelanja = array(
	                                       'c1' => $c1,
	                                       'c' => $c,
	                                       'd' => $d,
	                                       'e' => '00',
	                                       'e1' => '000',
	                                       'f1' => '0',
	                                       'f2' => '0',
	                                       'f' => '00',
	                                       'g' => '00',
	                                       'h' => '00',
	                                       'i' => '00',
	                                       'j' => '000',
	                                       'bk'=> $bk,
	                                       'ck'=> $ck,
	                                       'dk'=> $dk,
	                                       'p' => $p,
	                                       'q' => $q,
	                                       'k' => $k11,
	                                       'l' => $l11,
	                                       'm' => $m11,
	                                       'n' => $n11,
	                                       'o' => $o11,
	                                       'jenis_rka' => '2.2.1',
	                                       'tahun' => $this->tahun,
	                                       'jenis_anggaran' => $this->jenisAnggaran,
	                                       'id_tahap' => $this->idTahap,
	                                       'nama_modul' => 'RKA-SKPD',
	                                       'id_rincian_belanja' => $getIdRincianBelanja['id'],
	                                       'rincian_perhitungan' => '',
	                                        );
	                          $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
	                          mysql_query($queryRincianBelanja);
	                        }
	                        //Data Barang
													 if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k11' and l='$l11' and m='$m11' and n='$n11' and o='$o11' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' ")) == 0){
																 $data = array( 'tahun' => $this->tahun,
																			'jenis_anggaran' => $this->jenisAnggaran,
																			'id_tahap' => $this->idTahap,
																			'c1' => $c1,
																			'c'	=> $c,
																			'd' => $d,
																			'e' => $e,
																			'e1' => $e1,
																			'bk' => $bk,
																			'ck' => $ck,
																			'dk' => $dk,
																			'p' => $p,
																			'q' => $q,
																			'f' => $f,
																			'g' => $g,
																			'h' => $h,
																			'i' => $i,
																			'j' => $j,
																			'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
																			'catatan' => $catatan,
																			'jenis_rka' => '2.2.1',
																			'k' => $k11,
																			'l' => $l11,
																			'm' => $m11,
																			'n' => $n11,
																			'o' => $o11,
																			'satuan_rek' => $satuan_barang,
																			'volume_rek' => $volume_barang,
																			'jumlah1' => $volume_barang,
			 															  'satuan1' => $satuan_barang,
																			'rincian_perhitungan' => $rincian_perhitungan,
																			'nama_modul' => 'RKA-SKPD',
																			'id_rincian_belanja' => $getIdRincianBelanja['id'],
			 															  'jenis_rekening' => "BELANJA MODAL"
																		 );
															 $query = VulnWalkerInsert('tabel_anggaran', $data);
															 mysql_query($query);
													 }else{
															 $getIdSubRincian = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k11' and l='$l11' and m='$m11' and n='$n11' and o='$o11' and id_rincian_belanja = '".$getIdRincianBelanja['id']."' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan'"));
															 mysql_query("update tabel_anggaran set volume_rek = volume_rek + $volume_barang, jumlah1 = jumlah1 + $volume_barang  where id_anggaran = '".$getIdSubRincian['id_anggaran']."'");
													 }

	                  }
	              }elseif($cara_pemenuhan == "SEWA"){
	                //NON MAPPING
	                if(empty($k13)){
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
	                              'bk' => $bk,
	                              'ck' => $ck,
	                              'dk' => $dk,
	                              'p' => $p,
	                              'q' => $q,
	                              'k' => $f,
	                              'l' => $g,
	                              'm' => $h,
	                              'n' => $i,
	                              'o' => $j,
	                              'jenis_rka' => '2.2.1',
	                              'tahun' => $this->tahun,
	                              'jenis_anggaran' => $this->jenisAnggaran,
	                              'id_tahap' => $this->idTahap,
	                              'nama_modul' => 'RKA-SKPD',
																'sumber_dana' => 'APBD',
	                              'id_rincian_belanja' => ''
	                              );
	                    $queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
	                    if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and id_rincian_belanja=''")) == 0 ){
	                      mysql_query($queryRekening);
	                    }
	                    //Data Rincian Belanja Tidak Ada
	                    if(mysql_num_rows(mysql_query("select * from rincian_belanja where c1 = '$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and nama_rincian_belanja ='Penyewaan Barang' ")) == 0){
	                      $dataRincianBelanja = array(
	                            'tahun' => $this->tahun,
	                            'jenis_anggaran' => $this->jenisAnggaran,
	                            'c1' => $c1,
	                            'c' => $c,
	                            'd' => $d,
	                            'bk' => $bk,
	                            'ck' => $ck,
	                            'dk' => $dk,
	                            'p' => $p,
	                            'q' => $q,
	                            'k' => $f,
	                            'l' => $g,
	                            'm' => $h,
	                            'n' => $i,
	                            'o' => $j,
	                            'sumber_dana' => "APBD",
	                            'nama_rincian_belanja' => "Penyewaan Barang"
	                      );
	                      mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));
	                    }
	                    //Generate Id Data Rincian Belanja
	                     $getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
	                     ='$this->jenisAnggaran' and c1 ='".$c1."' and c ='".$c."' and d ='".$d."' and bk ='".$bk."'  and ck ='".$ck."' and dk ='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$f."' and l ='".$g."' and m ='".$h."' and n ='".$i."' and o ='".$j."' and nama_rincian_belanja = '"."Penyewaan Barang"."'  "));
	                     //Rincian Belanja
	                     if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='$c1' and c = '$c' and d='$d' and  rincian_perhitungan = '' and bk ='".$bk."' and ck ='".$ck."' and dk='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$f."' and l ='".$g."' and m ='".$h."' and n ='".$i."' and o ='".$j."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'")) ==0)
	                     {
	                      $arrayRincianBelanja = array(
	                                   'c1' => $c1,
	                                   'c' => $c,
	                                   'd' => $d,
	                                   'e' => '00',
	                                   'e1' => '000',
	                                   'f1' => '0',
	                                   'f2' => '0',
	                                   'f' => '00',
	                                   'g' => '00',
	                                   'h' => '00',
	                                   'i' => '00',
	                                   'j' => '000',
	                                   'bk'=> $bk,
	                                   'ck'=> $ck,
	                                   'dk'=> $dk,
	                                   'p' => $p,
	                                   'q' => $q,
	                                   'k' => $f,
	                                   'l' => $g,
	                                   'm' => $h,
	                                   'n' => $i,
	                                   'o' => $j,
	                                   'jenis_rka' => '2.2.1',
	                                   'tahun' => $this->tahun,
	                                   'jenis_anggaran' => $this->jenisAnggaran,
	                                   'id_tahap' => $this->idTahap,
	                                   'nama_modul' => 'RKA-SKPD',
	                                   'id_rincian_belanja' => $getIdRincianBelanja['id'],
	                                   'rincian_perhitungan' => '',
	                                    );
	                      $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
	                      mysql_query($queryRincianBelanja);
	                 }

	                    //Data Barang
											if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' ")) == 0){
														$data = array( 'tahun' => $this->tahun,
																'jenis_anggaran' => $this->jenisAnggaran,
																'id_tahap' => $this->idTahap,
																'c1' => $c1,
																'c'	=> $c,
																'd' => $d,
																'e' => $e,
																'e1' => $e1,
																'bk' => $bk,
																'ck' => $ck,
																'dk' => $dk,
																'p' => $p,
																'q' => $q,
																'f' => $f,
																'g' => $g,
																'h' => $h,
																'i' => $i,
																'j' => $j,
																'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
																'catatan' => $catatan,
																'jenis_rka' => '2.2.1',
																'k' => $f,
																'l' => $g,
																'm' => $h,
																'n' => $i,
																'o' => $j,
																'satuan_rek' => $satuan_barang,
																'volume_rek' => $volume_barang,
																'jumlah1' => $volume_barang,
 															  'satuan1' => $satuan_barang,
																'rincian_perhitungan' => $rincian_perhitungan,
																'nama_modul' => 'RKA-SKPD',
																'id_rincian_belanja' => $getIdRincianBelanja['id'],
																'jenis_rekening' => "BELANJA SEWA"
															 );
												 $query = VulnWalkerInsert('tabel_anggaran', $data);
												 mysql_query($query);

											}else{
												$getIdSubRincian = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and id_rincian_belanja = '".$getIdRincianBelanja['id']."' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan'"));
												mysql_query("update tabel_anggaran set volume_rek = volume_rek + $volume_barang, jumlah1 = jumlah1 + $volume_barang  where id_anggaran = '".$getIdSubRincian['id_anggaran']."'");
											}

	                }
	                //MAPPING
	                else{

	                  if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and c1='0' and f = '00' and k = '$k13' and l ='$l13' and m='$m13' and n='$n13' and o='$o13' and id_rincian_belanja ='' and id_tahap='$this->idTahap' ")  ) == 0 ){
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
	                                    'bk' => $bk,
	                                    'ck' => $ck,
	                                    'dk' => $dk,
	                                    'p' => $p,
	                                    'q' => $q,
	                                    'k' => $k13,
	                                    'l' => $l13,
	                                    'm' => $m13,
	                                    'n' => $n13,
	                                    'o' => $o13,
	                                    'jenis_rka' => '2.2.1',
	                                    'tahun' => $this->tahun,
	                                    'jenis_anggaran' => $this->jenisAnggaran,
	                                    'id_tahap' => $this->idTahap,
	                                    'nama_modul' => 'RKA-SKPD',
																			'sumber_dana' => 'APBD',
	                                    'id_rincian_belanja' => ''
	                                    );
	                          $queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
	                          mysql_query($queryRekening);
	                        }
	                        //Data Rincian Belanja Tidak Ada


	                        if(mysql_num_rows(mysql_query("select * from rincian_belanja where c1 = '$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k13' and l='$l13' and m='$m13' and n='$n13' and o='$o13' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and nama_rincian_belanja='Penyewaan Barang' ")) == 0){

	                          $dataRincianBelanja = array(
	                                'tahun' => $this->tahun,
	                                'jenis_anggaran' => $this->jenisAnggaran,
	                                'c1' => $c1,
	                                'c' => $c,
	                                'd' => $d,
	                                'bk' => $bk,
	                                'ck' => $ck,
	                                'dk' => $dk,
	                                'p' => $p,
	                                'q' => $q,
	                                'k' => $k13,
	                                'l' => $l13,
	                                'm' => $m13,
	                                'n' => $n13,
	                                'o' => $o13,
	                                'sumber_dana' => "APBD",
	                                'nama_rincian_belanja' => "Penyewaan Barang"
	                          );
	                          mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));

	                        }
	                        //Generate Id Data Rincian Belanja
	                         $getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
	                         ='$this->jenisAnggaran' and c1 ='".$c1."' and c ='".$c."' and d ='".$d."' and bk ='".$bk."'  and ck ='".$ck."' and dk ='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k13."' and l ='".$l13."' and m ='".$m13."' and n ='".$n13."' and o ='".$o13."' and nama_rincian_belanja = '"."Penyewaan Barang"."'  "));
	                         //Rincian Belanja
	                         if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='$c1' and c = '$c' and d='$d' and  rincian_perhitungan = '' and bk ='".$bk."' and ck ='".$ck."' and dk='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k13."' and l ='".$l13."' and m ='".$m13."' and n ='".$n13."' and o ='".$o13."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'")) ==0)
	                         {
	                          $arrayRincianBelanja = array(
	                                       'c1' => $c1,
	                                       'c' => $c,
	                                       'd' => $d,
	                                       'e' => '00',
	                                       'e1' => '000',
	                                       'f1' => '0',
	                                       'f2' => '0',
	                                       'f' => '00',
	                                       'g' => '00',
	                                       'h' => '00',
	                                       'i' => '00',
	                                       'j' => '000',
	                                       'bk'=> $bk,
	                                       'ck'=> $ck,
	                                       'dk'=> $dk,
	                                       'p' => $p,
	                                       'q' => $q,
	                                       'k' => $k13,
	                                       'l' => $l13,
	                                       'm' => $m13,
	                                       'n' => $n13,
	                                       'o' => $o13,
	                                       'jenis_rka' => '2.2.1',
	                                       'tahun' => $this->tahun,
	                                       'jenis_anggaran' => $this->jenisAnggaran,
	                                       'id_tahap' => $this->idTahap,
	                                       'nama_modul' => 'RKA-SKPD',
	                                       'id_rincian_belanja' => $getIdRincianBelanja['id'],
	                                       'rincian_perhitungan' => '',
	                                        );
	                          $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
	                          mysql_query($queryRincianBelanja);
	                        }

	                        //Data Barang

													if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k13' and l='$l13' and m='$m13' and n='$n13' and o='$o13' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' ")) == 0){
																$data = array( 'tahun' => $this->tahun,
																		'jenis_anggaran' => $this->jenisAnggaran,
																		'id_tahap' => $this->idTahap,
																		'c1' => $c1,
																		'c'	=> $c,
																		'd' => $d,
																		'e' => $e,
																		'e1' => $e1,
																		'bk' => $bk,
																		'ck' => $ck,
																		'dk' => $dk,
																		'p' => $p,
																		'q' => $q,
																		'f' => $f,
																		'g' => $g,
																		'h' => $h,
																		'i' => $i,
																		'j' => $j,
																		'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
																		'catatan' => $catatan,
																		'jenis_rka' => '2.2.1',
																		'k' => $k13,
																		'l' => $l13,
																		'm' => $m13,
																		'n' => $n13,
																		'o' => $o13,
																		'satuan_rek' => $satuan_barang,
																		'volume_rek' => $volume_barang,
																		'jumlah1' => $volume_barang,
		 															  'satuan1' => $satuan_barang,
																		'rincian_perhitungan' => $rincian_perhitungan,
																		'nama_modul' => 'RKA-SKPD',
																		'id_rincian_belanja' => $getIdRincianBelanja['id'],
																		'jenis_rekening' => "BELANJA SEWA"
																	 );
														 $query = VulnWalkerInsert('tabel_anggaran', $data);
														 mysql_query($query);

													}else{
														$getIdSubRincian = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k13' and l='$l13' and m='$m13' and n='$n13' and o='$o13' and id_rincian_belanja = '".$getIdRincianBelanja['id']."' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan'"));
														mysql_query("update tabel_anggaran set volume_rek = volume_rek + $volume_barang, jumlah1 = jumlah1 + $volume_barang  where id_anggaran = '".$getIdSubRincian['id_anggaran']."'");


													}

	                  }
	              }
	        }elseif($id_jenis_pemeliharaan !='0'){
	          //NON MAPPING VULNWALKER
	            if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and c1='0' and f = '00' and k = '$k' and l ='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja ='' and id_tahap='$this->idTahap' ")  ) == 0 ){
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
	                              'bk' => $bk,
	                              'ck' => $ck,
	                              'dk' => $dk,
	                              'p' => $p,
	                              'q' => $q,
	                              'k' => $k,
	                              'l' => $l,
	                              'm' => $m,
	                              'n' => $n,
	                              'o' => $o,
	                              'jenis_rka' => '2.2.1',
	                              'tahun' => $this->tahun,
	                              'jenis_anggaran' => $this->jenisAnggaran,
	                              'id_tahap' => $this->idTahap,
	                              'nama_modul' => 'RKA-SKPD',
																'sumber_dana' => 'APBD',
	                              'id_rincian_belanja' => ''
	                              );
	                    $queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
	                    mysql_query($queryRekening);
	                  }
	                  //Data Rincian Belanja Tidak Ada


	                  if(mysql_num_rows(mysql_query("select * from rincian_belanja where c1 = '$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and nama_rincian_belanja='Pemeliharaan Barang'  ")) == 0){

	                    $dataRincianBelanja = array(
	                          'tahun' => $this->tahun,
	                          'jenis_anggaran' => $this->jenisAnggaran,
	                          'c1' => $c1,
	                          'c' => $c,
	                          'd' => $d,
	                          'bk' => $bk,
	                          'ck' => $ck,
	                          'dk' => $dk,
	                          'p' => $p,
	                          'q' => $q,
	                          'k' => $k,
	                          'l' => $l,
	                          'm' => $m,
	                          'n' => $n,
	                          'o' => $o,
	                          'sumber_dana' => "APBD",
	                          'nama_rincian_belanja' => "Pemeliharaan Barang"
	                    );
	                    mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));

	                  }
	                  //Generate Id Data Rincian Belanja
	                   $getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
	                   ='$this->jenisAnggaran' and c1 ='".$c1."' and c ='".$c."' and d ='".$d."' and bk ='".$bk."'  and ck ='".$ck."' and dk ='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k."' and l ='".$l."' and m ='".$m."' and n ='".$n."' and o ='".$o."' and nama_rincian_belanja = 'Pemeliharaan Barang'  "));
	                   //Rincian Belanja
	                   if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='$c1' and c = '$c' and d='$d' and  rincian_perhitungan = '' and bk ='".$bk."' and ck ='".$ck."' and dk='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k."' and l ='".$l."' and m ='".$m."' and n ='".$n."' and o ='".$o."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'")) ==0)
	                   {
	                    $arrayRincianBelanja = array(
	                                 'c1' => $c1,
	                                 'c' => $c,
	                                 'd' => $d,
	                                 'e' => '00',
	                                 'e1' => '000',
	                                 'f1' => '0',
	                                 'f2' => '0',
	                                 'f' => '00',
	                                 'g' => '00',
	                                 'h' => '00',
	                                 'i' => '00',
	                                 'j' => '000',
	                                 'bk'=> $bk,
	                                 'ck'=> $ck,
	                                 'dk'=> $dk,
	                                 'p' => $p,
	                                 'q' => $q,
	                                 'k' => $k,
	                                 'l' => $l,
	                                 'm' => $m,
	                                 'n' => $n,
	                                 'o' => $o,
	                                 'jenis_rka' => '2.2.1',
	                                 'tahun' => $this->tahun,
	                                 'jenis_anggaran' => $this->jenisAnggaran,
	                                 'id_tahap' => $this->idTahap,
	                                 'nama_modul' => 'RKA-SKPD',
	                                 'id_rincian_belanja' => $getIdRincianBelanja['id'],
	                                 'rincian_perhitungan' => '',
	                                  );
	                    $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
	                    mysql_query($queryRincianBelanja);
	                  }
	                  //Data Barang Pemeliharaan

										if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' ")) == 0){
												$data = array( 'tahun' => $this->tahun,
														 'jenis_anggaran' => $this->jenisAnggaran,
														 'id_tahap' => $this->idTahap,
														 'c1' => $c1,
														 'c'	=> $c,
														 'd' => $d,
														 'e' => $e,
														 'e1' => $e1,
														 'bk' => $bk,
														 'ck' => $ck,
														 'dk' => $dk,
														 'p' => $p,
														 'q' => $q,
														 'f' => $f,
														 'g' => $g,
														 'h' => $h,
														 'i' => $i,
														 'j' => $j,
														 'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
														 'catatan' => $catatan,
														 'jenis_rka' => '2.2.1',
														 'k' => $k,
														 'l' => $l,
														 'm' => $m,
														 'n' => $n,
														 'o' => $o,
														 'satuan_rek' => $satuan_barang,
														 'satuan_total' => $satuan_barang,
														 'satuan1' => $satuan1,
														 'satuan2' => $satuan2,
														 'jumlah1' => $jumlah1,
														 'jumlah2' => $volume_barang / $jumlah1,
														 'volume_rek' => $volume_barang,
														 'rincian_perhitungan' => $rincian_perhitungan,
														 'nama_modul' => 'RKA-SKPD',
														 'id_rincian_belanja' => $getIdRincianBelanja['id'],
														);
											$query = VulnWalkerInsert('tabel_anggaran', $data);
											mysql_query($query);
										}else{

											$getIdSubRincian = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan'"));
											mysql_query("update tabel_anggaran set volume_rek = volume_rek + $volume_barang, jumlah1 = jumlah1 + $jumlah1   where id_anggaran = '".$getIdSubRincian['id_anggaran']."'");

											$getDataBagiKuantitias = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran  ='".$getIdSubRincian['id_anggaran']."'"));
											$hasilBagiVolume = $getDataBagiKuantitias['volume_rek'] / $getDataBagiKuantitias['jumlah1'];
											mysql_query("update tabel_anggaran set jumlah2 = $hasilBagiVolume   where id_anggaran = '".$getIdSubRincian['id_anggaran']."'");
										}


	        }elseif($id_jenis_pemeliharaan == '0' && $f=='08'){
	          //PEMBELIAN PERSEDIAAN
	              //NON MAPPING
	              if(empty($k12)){
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
	                            'bk' => $bk,
	                            'ck' => $ck,
	                            'dk' => $dk,
	                            'p' => $p,
	                            'q' => $q,
	                            'k' => $f,
	                            'l' => $g,
	                            'm' => $h,
	                            'n' => $i,
	                            'o' => $j,
	                            'jenis_rka' => '2.2.1',
	                            'tahun' => $this->tahun,
	                            'jenis_anggaran' => $this->jenisAnggaran,
	                            'id_tahap' => $this->idTahap,
	                            'nama_modul' => 'RKA-SKPD',
															'sumber_dana' => 'APBD',
	                            'id_rincian_belanja' => 'NON MAPPING'
	                            );
	                  $queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
	                  if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and id_rincian_belanja=''")) == 0 ){
	                    mysql_query($queryRekening);
	                  }
	                  //Data Rincian Belanja Tidak Ada
	                  if(mysql_num_rows(mysql_query("select * from rincian_belanja where c1 = '$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and nama_rincian_belanja='Pengadaan Barang Persediaan' ")) == 0){
	                    $dataRincianBelanja = array(
	                          'tahun' => $this->tahun,
	                          'jenis_anggaran' => $this->jenisAnggaran,
	                          'c1' => $c1,
	                          'c' => $c,
	                          'd' => $d,
	                          'bk' => $bk,
	                          'ck' => $ck,
	                          'dk' => $dk,
	                          'p' => $p,
	                          'q' => $q,
	                          'k' => $f,
	                          'l' => $g,
	                          'm' => $h,
	                          'n' => $i,
	                          'o' => $j,
	                          'sumber_dana' => "APBD",
	                          'nama_rincian_belanja' => "Pengadaan Barang Persediaan"
	                    );
	                    mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));
	                  }
	                  //Generate Id Data Rincian Belanja
	                   $getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
	                   ='$this->jenisAnggaran' and c1 ='".$c1."' and c ='".$c."' and d ='".$d."' and bk ='".$bk."'  and ck ='".$ck."' and dk ='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$f."' and l ='".$g."' and m ='".$h."' and n ='".$i."' and o ='".$j."' and nama_rincian_belanja = 'Pengadaan Barang Persediaan'  "));
	                   //Rincian Belanja
	                   if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='$c1' and c = '$c' and d='$d' and  rincian_perhitungan = '' and bk ='".$bk."' and ck ='".$ck."' and dk='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$f."' and l ='".$g."' and m ='".$h."' and n ='".$i."' and o ='".$j."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'")) ==0)
	                   {
	                    $arrayRincianBelanja = array(
	                                 'c1' => $c1,
	                                 'c' => $c,
	                                 'd' => $d,
	                                 'e' => '00',
	                                 'e1' => '000',
	                                 'f1' => '0',
	                                 'f2' => '0',
	                                 'f' => '00',
	                                 'g' => '00',
	                                 'h' => '00',
	                                 'i' => '00',
	                                 'j' => '000',
	                                 'bk'=> $bk,
	                                 'ck'=> $ck,
	                                 'dk'=> $dk,
	                                 'p' => $p,
	                                 'q' => $q,
	                                 'k' => $f,
	                                 'l' => $g,
	                                 'm' => $h,
	                                 'n' => $i,
	                                 'o' => $j,
	                                 'jenis_rka' => '2.2.1',
	                                 'tahun' => $this->tahun,
	                                 'jenis_anggaran' => $this->jenisAnggaran,
	                                 'id_tahap' => $this->idTahap,
	                                 'nama_modul' => 'RKA-SKPD',
	                                 'id_rincian_belanja' => $getIdRincianBelanja['id'],
	                                 'rincian_perhitungan' => '',
	                                  );
	                    $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
	                    mysql_query($queryRincianBelanja);
	               }
	                  //Data Barang
										if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' ")) == 0){
													$data = array( 'tahun' => $this->tahun,
															'jenis_anggaran' => $this->jenisAnggaran,
															'id_tahap' => $this->idTahap,
															'c1' => $c1,
															'c'	=> $c,
															'd' => $d,
															'e' => $e,
															'e1' => $e1,
															'bk' => $bk,
															'ck' => $ck,
															'dk' => $dk,
															'p' => $p,
															'q' => $q,
															'f' => $f,
															'g' => $g,
															'h' => $h,
															'i' => $i,
															'j' => $j,
															'j1' => $j1,
															'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
															'catatan' => $catatan,
															'jenis_rka' => '2.2.1',
															'k' => $f,
															'l' => $g,
															'm' => $h,
															'n' => $i,
															'o' => $j,
															'satuan_rek' => $satuan_barang,
															'volume_rek' => $volume_barang,
															'jumlah1' => $volume_barang,
															'satuan1' => $satuan_barang,
															'rincian_perhitungan' => $rincian_perhitungan,
															'nama_modul' => 'RKA-SKPD',
															'id_rincian_belanja' => $getIdRincianBelanja['id'],
															'jenis_rekening' => "BELANJA BARANG JASA"
														 );
											 $query = VulnWalkerInsert('tabel_anggaran', $data);
											 mysql_query($query);
										}else{
											$getIdSubRincian = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and id_rincian_belanja = '".$getIdRincianBelanja['id']."' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan'"));
											mysql_query("update tabel_anggaran set volume_rek = volume_rek + $volume_barang, jumlah1 = jumlah1 + $volume_barang  where id_anggaran = '".$getIdSubRincian['id_anggaran']."'");
										}

	              }
	              //MAPPING
	              else{

	                if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and c1='0' and f = '00' and k = '$k12' and l ='$l12' and m='$m12' and n='$n12' and o='$o12' and id_rincian_belanja ='' and id_tahap='$this->idTahap' ")  ) == 0 ){
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
	                                  'bk' => $bk,
	                                  'ck' => $ck,
	                                  'dk' => $dk,
	                                  'p' => $p,
	                                  'q' => $q,
	                                  'k' => $k12,
	                                  'l' => $l12,
	                                  'm' => $m12,
	                                  'n' => $n12,
	                                  'o' => $o12,
	                                  'jenis_rka' => '2.2.1',
	                                  'tahun' => $this->tahun,
	                                  'jenis_anggaran' => $this->jenisAnggaran,
	                                  'id_tahap' => $this->idTahap,
	                                  'nama_modul' => 'RKA-SKPD',
																		'sumber_dana' => 'APBD',
	                                  'id_rincian_belanja' => ''
	                                  );
	                        $queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
	                        mysql_query($queryRekening);
	                      }
	                      //Data Rincian Belanja Tidak Ada


	                      if(mysql_num_rows(mysql_query("select * from rincian_belanja where c1 = '$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k12' and l='$l12' and m='$m12' and n='$n12' and o='$o12' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and sumber_dana = 'APBD' and nama_rincian_belanja='Pengadaan Barang Persediaan'")) == 0){

	                        $dataRincianBelanja = array(
	                              'tahun' => $this->tahun,
	                              'jenis_anggaran' => $this->jenisAnggaran,
	                              'c1' => $c1,
	                              'c' => $c,
	                              'd' => $d,
	                              'bk' => $bk,
	                              'ck' => $ck,
	                              'dk' => $dk,
	                              'p' => $p,
	                              'q' => $q,
	                              'k' => $k12,
	                              'l' => $l12,
	                              'm' => $m12,
	                              'n' => $n12,
	                              'o' => $o12,
	                              'sumber_dana' => "APBD",
	                              'nama_rincian_belanja' => "Pengadaan Barang Persediaan"
	                        );
	                        mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));

	                      }
	                      //Generate Id Data Rincian Belanja
	                       $getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
	                       ='$this->jenisAnggaran' and c1 ='".$c1."' and c ='".$c."' and d ='".$d."' and bk ='".$bk."'  and ck ='".$ck."' and dk ='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k12."' and l ='".$l12."' and m ='".$m12."' and n ='".$n12."' and o ='".$o12."' and nama_rincian_belanja = 'Pengadaan Barang Persediaan'  "));
	                       //Rincian Belanja
	                       if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='$c1' and c = '$c' and d='$d' and  rincian_perhitungan = '' and bk ='".$bk."' and ck ='".$ck."' and dk='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k12."' and l ='".$l12."' and m ='".$m12."' and n ='".$n12."' and o ='".$o12."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap' ")) ==0)
	                       {
	                        $arrayRincianBelanja = array(
	                                     'c1' => $c1,
	                                     'c' => $c,
	                                     'd' => $d,
	                                     'e' => '00',
	                                     'e1' => '000',
	                                     'f1' => '0',
	                                     'f2' => '0',
	                                     'f' => '00',
	                                     'g' => '00',
	                                     'h' => '00',
	                                     'i' => '00',
	                                     'j' => '000',
	                                     'bk'=> $bk,
	                                     'ck'=> $ck,
	                                     'dk'=> $dk,
	                                     'p' => $p,
	                                     'q' => $q,
	                                     'k' => $k12,
	                                     'l' => $l12,
	                                     'm' => $m12,
	                                     'n' => $n12,
	                                     'o' => $o12,
	                                     'jenis_rka' => '2.2.1',
	                                     'tahun' => $this->tahun,
	                                     'jenis_anggaran' => $this->jenisAnggaran,
	                                     'id_tahap' => $this->idTahap,
	                                     'nama_modul' => 'RKA-SKPD',
	                                     'id_rincian_belanja' => $getIdRincianBelanja['id'],
	                                     'rincian_perhitungan' => '',
	                                      );
	                        $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
	                        mysql_query($queryRincianBelanja);
	                      }
	                      //Data Barang
													if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k12' and l='$l12' and m='$m12' and n='$n12' and o='$o12' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' ")) == 0){
																$data = array( 'tahun' => $this->tahun,
																		'jenis_anggaran' => $this->jenisAnggaran,
																		'id_tahap' => $this->idTahap,
																		'c1' => $c1,
																		'c'	=> $c,
																		'd' => $d,
																		'e' => $e,
																		'e1' => $e1,
																		'bk' => $bk,
																		'ck' => $ck,
																		'dk' => $dk,
																		'p' => $p,
																		'q' => $q,
																		'f' => $f,
																		'g' => $g,
																		'h' => $h,
																		'i' => $i,
																		'j' => $j,
																		'j1' => $j1,
																		'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
																		'catatan' => $catatan,
																		'jenis_rka' => '2.2.1',
																		'k' => $k12,
																		'l' => $l12,
																		'm' => $m12,
																		'n' => $n12,
																		'o' => $o12,
																		'satuan_rek' => $satuan_barang,
																		'volume_rek' => $volume_barang,
																		'jumlah1' => $volume_barang,
		 														    'satuan1' => $satuan_barang,
																		'rincian_perhitungan' => $rincian_perhitungan,
																		'nama_modul' => 'RKA-SKPD',
																		'id_rincian_belanja' => $getIdRincianBelanja['id'],
																		'jenis_rekening' => "BELANJA BARANG JASA"
																	 );
														 $query = VulnWalkerInsert('tabel_anggaran', $data);
														 mysql_query($query);
													}else{
														$getIdSubRincian = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k12' and l='$l12' and m='$m12' and n='$n12' and o='$o12' and id_rincian_belanja = '".$getIdRincianBelanja['id']."' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan'"));
														mysql_query("update tabel_anggaran set volume_rek = volume_rek + $volume_barang, jumlah1 = jumlah1 + $volume_barang  where id_anggaran = '".$getIdSubRincian['id_anggaran']."'");
													}


	                }

	        }









	      }

	  }

	  return array('cek' => $cek , 'err'=> $err, 'content' => $content);
	}
	function syncDataRekening(){

			$getDataRKA = mysql_query("select * from view_rka_2_2_1 where j!='000' ");
			while ($dataRKA = mysql_fetch_array($getDataRKA)) {
				foreach ($dataRKA as $key => $value) {
						$$key = $value;
				 }



				 if($f == '08'){
					  $getDataBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h ='$h' and i='$i' and j='$j' and j1='$j1'"));
				 }else{
					  $getDataBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h ='$h' and i='$i' and j='$j'"));
				 }
				 $k11= $getDataBarang['k11'];
				 $l11= $getDataBarang['l11'];
				 $m11= $getDataBarang['m11'];
				 $n11= $getDataBarang['n11'];
				 $o11= $getDataBarang['o11'];
				 $k12= $getDataBarang['k12'];
				 $l12= $getDataBarang['l12'];
				 $m12= $getDataBarang['m12'];
				 $n12= $getDataBarang['n12'];
				 $o12= $getDataBarang['o12'];
				 $k13= $getDataBarang['k13'];
				 $l13= $getDataBarang['l13'];
				 $m13= $getDataBarang['m13'];
				 $n13= $getDataBarang['n13'];
				 $o13= $getDataBarang['o13'];
				 if($jenis_rekening == "BELANJA MODAL"){
					 if(empty($getDataBarang['k11'])){
						 if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and c1='0' and f = '00' and k = '$f' and l ='$g' and m='$h' and n='$i' and o='$j' and id_rincian_belanja ='' and id_tahap='$this->idTahap' ")  ) == 0 ){
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
															 'bk' => $bk,
															 'ck' => $ck,
															 'dk' => $dk,
															 'p' => $p,
															 'q' => $q,
															 'k' => $f,
															 'l' => $g,
															 'm' => $h,
															 'n' => $i,
															 'o' => $j,
															 'jenis_rka' => '2.2.1',
															 'tahun' => $this->tahun,
															 'jenis_anggaran' => $this->jenisAnggaran,
															 'id_tahap' => $this->idTahap,
															 'nama_modul' => 'RKA-SKPD',
															 'sumber_dana' => "APBD",
															 'id_rincian_belanja' => ''
															 );
										 $queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
										 mysql_query($queryRekening);
									 }
									 //Data Rincian Belanja Tidak Ada


									 if(mysql_num_rows(mysql_query("select * from rincian_belanja where c1 = '$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and nama_rincian_belanja = 'Pengadaan Barang'  ")) == 0){

										 $dataRincianBelanja = array(
													 'tahun' => $this->tahun,
													 'jenis_anggaran' => $this->jenisAnggaran,
													 'c1' => $c1,
													 'c' => $c,
													 'd' => $d,
													 'bk' => $bk,
													 'ck' => $ck,
													 'dk' => $dk,
													 'p' => $p,
													 'q' => $q,
													 'k' => $f,
													 'l' => $g,
													 'm' => $h,
													 'n' => $i,
													 'o' => $j,
													 'sumber_dana' => "APBD",
													 'nama_rincian_belanja' => "Pengadaan Barang"
										 );
										 mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));

									 }
									 //Generate Id Data Rincian Belanja
										$getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
										='$this->jenisAnggaran' and c1 ='".$c1."' and c ='".$c."' and d ='".$d."' and bk ='".$bk."'  and ck ='".$ck."' and dk ='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$f."' and l ='".$g."' and m ='".$h."' and n ='".$i."' and o ='".$j."' and nama_rincian_belanja = 'Pengadaan Barang'  "));
										//Rincian Belanja
										if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='$c1' and c = '$c' and d='$d' and  rincian_perhitungan = '' and bk ='".$bk."' and ck ='".$ck."' and dk='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$f."' and l ='".$g."' and m ='".$h."' and n ='".$i."' and o ='".$j."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'")) ==0)
										{
										 $arrayRincianBelanja = array(
																	'c1' => $c1,
																	'c' => $c,
																	'd' => $d,
																	'e' => '00',
																	'e1' => '000',
																	'f1' => '0',
																	'f2' => '0',
																	'f' => '00',
																	'g' => '00',
																	'h' => '00',
																	'i' => '00',
																	'j' => '000',
																	'bk'=> $bk,
																	'ck'=> $ck,
																	'dk'=> $dk,
																	'p' => $p,
																	'q' => $q,
																	'k' => $f,
																	'l' => $g,
																	'm' => $h,
																	'n' => $i,
																	'o' => $j,
																	'jenis_rka' => '2.2.1',
																	'tahun' => $this->tahun,
																	'jenis_anggaran' => $this->jenisAnggaran,
																	'id_tahap' => $this->idTahap,
																	'nama_modul' => 'RKA-SKPD',
																	'id_rincian_belanja' => $getIdRincianBelanja['id'],
																	'rincian_perhitungan' => '',
																	 );
										 $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
										 mysql_query($queryRincianBelanja);
									 }
									 //Data Barang

													$data = array(
														   'tahun' => $this->tahun,
															 'jenis_anggaran' => $this->jenisAnggaran,
															 'id_tahap' => $this->idTahap,
															 'c1' => $c1,
															 'c'	=> $c,
															 'd' => $d,
															 'e' => $e,
															 'e1' => $e1,
															 'bk' => $bk,
															 'ck' => $ck,
															 'dk' => $dk,
															 'p' => $p,
															 'q' => $q,
															 'f' => $f,
															 'g' => $g,
															 'h' => $h,
															 'i' => $i,
															 'j' => $j,
															 'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
															 'catatan' => $catatan,
															 'jenis_rka' => '2.2.1',
															 'k' => $f,
															 'l' => $g,
															 'm' => $h,
															 'n' => $i,
															 'o' => $j,
															 'nama_modul' => 'RKA-SKPD',
															 'id_rincian_belanja' => $getIdRincianBelanja['id'],
															 'jenis_rekening' => "BELANJA MODAL"
															);
												$query = VulnWalkerUpdate('tabel_anggaran', $data,"id_anggaran = '$id_anggaran'");
												mysql_query($query);
					 }else{
						// //  if($id_anggaran == '5430'){
						// 	 	$cek = "sedan di sini ". $id_anggaran;
						// //  }
						 if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and c1='0' and f = '00' and k = '$k11' and l ='$l11' and m='$m11' and n='$n11' and o='$o11' and id_rincian_belanja ='' and id_tahap='$this->idTahap' ")  ) == 0 ){
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
															 'bk' => $bk,
															 'ck' => $ck,
															 'dk' => $dk,
															 'p' => $p,
															 'q' => $q,
															 'k' => $k11,
															 'l' => $l11,
															 'm' => $m11,
															 'n' => $n11,
															 'o' => $o11,
															 'jenis_rka' => '2.2.1',
															 'tahun' => $this->tahun,
															 'jenis_anggaran' => $this->jenisAnggaran,
															 'id_tahap' => $this->idTahap,
															 'nama_modul' => 'RKA-SKPD',
															 'sumber_dana' => "APBD",
															 'id_rincian_belanja' => ''
															 );
										 $queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
										 mysql_query($queryRekening);
									 }
									 //Data Rincian Belanja Tidak Ada


									 if(mysql_num_rows(mysql_query("select * from rincian_belanja where c1 = '$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k11' and l='$l11' and m='$m11' and n='$n11' and o='$o11' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and nama_rincian_belanja = 'Pengadaan Barang'  ")) == 0){

										 $dataRincianBelanja = array(
													 'tahun' => $this->tahun,
													 'jenis_anggaran' => $this->jenisAnggaran,
													 'c1' => $c1,
													 'c' => $c,
													 'd' => $d,
													 'bk' => $bk,
													 'ck' => $ck,
													 'dk' => $dk,
													 'p' => $p,
													 'q' => $q,
													 'k' => $k11,
													 'l' => $l11,
													 'm' => $m11,
													 'n' => $n11,
													 'o' => $o11,
													 'sumber_dana' => "APBD",
													 'nama_rincian_belanja' => "Pengadaan Barang"
										 );
										 mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));

									 }
									 //Generate Id Data Rincian Belanja
										$getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
										='$this->jenisAnggaran' and c1 ='".$c1."' and c ='".$c."' and d ='".$d."' and bk ='".$bk."'  and ck ='".$ck."' and dk ='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k11."' and l ='".$l11."' and m ='".$m11."' and n ='".$n11."' and o ='".$o11."' and nama_rincian_belanja = 'Pengadaan Barang'  "));
										//Rincian Belanja
										if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='$c1' and c = '$c' and d='$d' and  rincian_perhitungan = '' and bk ='".$bk."' and ck ='".$ck."' and dk='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k11."' and l ='".$l11."' and m ='".$m11."' and n ='".$n11."' and o ='".$o11."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'")) ==0)
										{
										 $arrayRincianBelanja = array(
																	'c1' => $c1,
																	'c' => $c,
																	'd' => $d,
																	'e' => '00',
																	'e1' => '000',
																	'f1' => '0',
																	'f2' => '0',
																	'f' => '00',
																	'g' => '00',
																	'h' => '00',
																	'i' => '00',
																	'j' => '000',
																	'bk'=> $bk,
																	'ck'=> $ck,
																	'dk'=> $dk,
																	'p' => $p,
																	'q' => $q,
																	'k' => $k11,
																	'l' => $l11,
																	'm' => $m11,
																	'n' => $n11,
																	'o' => $o11,
																	'jenis_rka' => '2.2.1',
																	'tahun' => $this->tahun,
																	'jenis_anggaran' => $this->jenisAnggaran,
																	'id_tahap' => $this->idTahap,
																	'nama_modul' => 'RKA-SKPD',
																	'id_rincian_belanja' => $getIdRincianBelanja['id'],
																	'rincian_perhitungan' => '',
																	 );
										 $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
										 mysql_query($queryRincianBelanja);
									 }
									 //Data Barang

													$data = array( 'tahun' => $this->tahun,
															 'jenis_anggaran' => $this->jenisAnggaran,
															 'id_tahap' => $this->idTahap,
															 'c1' => $c1,
															 'c'	=> $c,
															 'd' => $d,
															 'e' => $e,
															 'e1' => $e1,
															 'bk' => $bk,
															 'ck' => $ck,
															 'dk' => $dk,
															 'p' => $p,
															 'q' => $q,
															 'f' => $f,
															 'g' => $g,
															 'h' => $h,
															 'i' => $i,
															 'j' => $j,
															 'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
															 'catatan' => $catatan,
															 'jenis_rka' => '2.2.1',
															 'k' => $k11,
															 'l' => $l11,
															 'm' => $m11,
															 'n' => $n11,
															 'o' => $o11,
															 'nama_modul' => 'RKA-SKPD',
															 'id_rincian_belanja' => $getIdRincianBelanja['id'],
															 'jenis_rekening' => "BELANJA MODAL"
															);
												$query = VulnWalkerUpdate('tabel_anggaran', $data,"id_anggaran = '$id_anggaran'");
												mysql_query($query);
					  }

				 }elseif($jenis_rekening == "BELANJA BARANG JASA"){
					 if(empty($k12)){
					 if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and c1='0' and f = '00' and k = '$f' and l ='$g' and m='$h' and n='$i' and o='$j' and id_rincian_belanja ='' and id_tahap='$this->idTahap' ")  ) == 0 ){
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
														 'bk' => $bk,
														 'ck' => $ck,
														 'dk' => $dk,
														 'p' => $p,
														 'q' => $q,
														 'k' => $f,
														 'l' => $g,
														 'm' => $h,
														 'n' => $i,
														 'o' => $j,
														 'jenis_rka' => '2.2.1',
														 'tahun' => $this->tahun,
														 'jenis_anggaran' => $this->jenisAnggaran,
														 'id_tahap' => $this->idTahap,
														 'nama_modul' => 'RKA-SKPD',
														 'sumber_dana' => "APBD",
														 'id_rincian_belanja' => ''
														 );
									 $queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
									 mysql_query($queryRekening);
								 }
								 //Data Rincian Belanja Tidak Ada


								 if(mysql_num_rows(mysql_query("select * from rincian_belanja where c1 = '$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and nama_rincian_belanja = 'Pengadaan Barang'  ")) == 0){

									 $dataRincianBelanja = array(
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'c1' => $c1,
												 'c' => $c,
												 'd' => $d,
												 'bk' => $bk,
												 'ck' => $ck,
												 'dk' => $dk,
												 'p' => $p,
												 'q' => $q,
												 'k' => $f,
												 'l' => $g,
												 'm' => $h,
												 'n' => $i,
												 'o' => $j,
												 'sumber_dana' => "APBD",
												 'nama_rincian_belanja' => "Pengadaan Barang"
									 );
									 mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));

								 }
								 //Generate Id Data Rincian Belanja
									$getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
									='$this->jenisAnggaran' and c1 ='".$c1."' and c ='".$c."' and d ='".$d."' and bk ='".$bk."'  and ck ='".$ck."' and dk ='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$f."' and l ='".$g."' and m ='".$h."' and n ='".$i."' and o ='".$j."' and nama_rincian_belanja = 'Pengadaan Barang'  "));
									//Rincian Belanja
									if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='$c1' and c = '$c' and d='$d' and  rincian_perhitungan = '' and bk ='".$bk."' and ck ='".$ck."' and dk='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$f."' and l ='".$g."' and m ='".$h."' and n ='".$i."' and o ='".$j."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'")) ==0)
									{
									 $arrayRincianBelanja = array(
																'c1' => $c1,
																'c' => $c,
																'd' => $d,
																'e' => '00',
																'e1' => '000',
																'f1' => '0',
																'f2' => '0',
																'f' => '00',
																'g' => '00',
																'h' => '00',
																'i' => '00',
																'j' => '000',
																'bk'=> $bk,
																'ck'=> $ck,
																'dk'=> $dk,
																'p' => $p,
																'q' => $q,
																'k' => $f,
																'l' => $g,
																'm' => $h,
																'n' => $i,
																'o' => $j,
																'jenis_rka' => '2.2.1',
																'tahun' => $this->tahun,
																'jenis_anggaran' => $this->jenisAnggaran,
																'id_tahap' => $this->idTahap,
																'nama_modul' => 'RKA-SKPD',
																'id_rincian_belanja' => $getIdRincianBelanja['id'],
																'rincian_perhitungan' => '',
																 );
									 $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
									 mysql_query($queryRincianBelanja);
								 }
								 //Data Barang

												$data = array( 'tahun' => $this->tahun,
														 'jenis_anggaran' => $this->jenisAnggaran,
														 'id_tahap' => $this->idTahap,
														 'c1' => $c1,
														 'c'	=> $c,
														 'd' => $d,
														 'e' => $e,
														 'e1' => $e1,
														 'bk' => $bk,
														 'ck' => $ck,
														 'dk' => $dk,
														 'p' => $p,
														 'q' => $q,
														 'f' => $f,
														 'g' => $g,
														 'h' => $h,
														 'i' => $i,
														 'j' => $j,
														 'j1' => $j1,
														 'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
														 'catatan' => $catatan,
														 'jenis_rka' => '2.2.1',
														 'k' => $f,
														 'l' => $g,
														 'm' => $h,
														 'n' => $i,
														 'o' => $j,
														 'nama_modul' => 'RKA-SKPD',
														 'id_rincian_belanja' => $getIdRincianBelanja['id'],
														 'jenis_rekening' => "BELANJA BARANG JASA"
														);
											$query = VulnWalkerUpdate('tabel_anggaran', $data,"id_anggaran = '$id_anggaran'");
											mysql_query($query);
					 }else{

					 if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and c1='0' and f = '00' and k = '$k12' and l ='$l12' and m='$m12' and n='$n12' and o='$o12' and id_rincian_belanja ='' and id_tahap='$this->idTahap' ")  ) == 0 ){
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
														 'bk' => $bk,
														 'ck' => $ck,
														 'dk' => $dk,
														 'p' => $p,
														 'q' => $q,
														 'k' => $k12,
														 'l' => $l12,
														 'm' => $m12,
														 'n' => $n12,
														 'o' => $o12,
														 'jenis_rka' => '2.2.1',
														 'tahun' => $this->tahun,
														 'jenis_anggaran' => $this->jenisAnggaran,
														 'id_tahap' => $this->idTahap,
														 'nama_modul' => 'RKA-SKPD',
														 'sumber_dana' => "APBD",
														 'id_rincian_belanja' => ''
														 );
									 $queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
									 mysql_query($queryRekening);
								 }
								 //Data Rincian Belanja Tidak Ada


								 if(mysql_num_rows(mysql_query("select * from rincian_belanja where c1 = '$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k12' and l='$l12' and m='$m12' and n='$n12' and o='$o12' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and nama_rincian_belanja = 'Pengadaan Barang'  ")) == 0){

									 $dataRincianBelanja = array(
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'c1' => $c1,
												 'c' => $c,
												 'd' => $d,
												 'bk' => $bk,
												 'ck' => $ck,
												 'dk' => $dk,
												 'p' => $p,
												 'q' => $q,
												 'k' => $k12,
												 'l' => $l12,
												 'm' => $m12,
												 'n' => $n12,
												 'o' => $o12,
												 'sumber_dana' => "APBD",
												 'nama_rincian_belanja' => "Pengadaan Barang"
									 );
									 mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));

								 }
								 //Generate Id Data Rincian Belanja
									$getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
									='$this->jenisAnggaran' and c1 ='".$c1."' and c ='".$c."' and d ='".$d."' and bk ='".$bk."'  and ck ='".$ck."' and dk ='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k12."' and l ='".$l12."' and m ='".$m12."' and n ='".$n12."' and o ='".$o12."' and nama_rincian_belanja = 'Pengadaan Barang'  "));
									//Rincian Belanja
									if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='$c1' and c = '$c' and d='$d' and  rincian_perhitungan = '' and bk ='".$bk."' and ck ='".$ck."' and dk='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k12."' and l ='".$l12."' and m ='".$m12."' and n ='".$n12."' and o ='".$o12."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'")) ==0)
									{
									 $arrayRincianBelanja = array(
																'c1' => $c1,
																'c' => $c,
																'd' => $d,
																'e' => '00',
																'e1' => '000',
																'f1' => '0',
																'f2' => '0',
																'f' => '00',
																'g' => '00',
																'h' => '00',
																'i' => '00',
																'j' => '000',
																'bk'=> $bk,
																'ck'=> $ck,
																'dk'=> $dk,
																'p' => $p,
																'q' => $q,
																'k' => $k12,
																'l' => $l12,
																'm' => $m12,
																'n' => $n12,
																'o' => $o12,
																'jenis_rka' => '2.2.1',
																'tahun' => $this->tahun,
																'jenis_anggaran' => $this->jenisAnggaran,
																'id_tahap' => $this->idTahap,
																'nama_modul' => 'RKA-SKPD',
																'id_rincian_belanja' => $getIdRincianBelanja['id'],
																'rincian_perhitungan' => '',
																 );
									 $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
									 mysql_query($queryRincianBelanja);
								 }
								 //Data Barang

												$data = array( 'tahun' => $this->tahun,
														 'jenis_anggaran' => $this->jenisAnggaran,
														 'id_tahap' => $this->idTahap,
														 'c1' => $c1,
														 'c'	=> $c,
														 'd' => $d,
														 'e' => $e,
														 'e1' => $e1,
														 'bk' => $bk,
														 'ck' => $ck,
														 'dk' => $dk,
														 'p' => $p,
														 'q' => $q,
														 'f' => $f,
														 'g' => $g,
														 'h' => $h,
														 'i' => $i,
														 'j' => $j,
														 'j1' => $j1,
														 'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
														 'catatan' => $catatan,
														 'jenis_rka' => '2.2.1',
														 'k' => $k12,
														 'l' => $l12,
														 'm' => $m12,
														 'n' => $n12,
														 'o' => $o12,
														 'nama_modul' => 'RKA-SKPD',
														 'id_rincian_belanja' => $getIdRincianBelanja['id'],
														 'jenis_rekening' => "BELANJA BARANG JASA"
														);
											$query = VulnWalkerUpdate('tabel_anggaran', $data,"id_anggaran = '$id_anggaran'");
											mysql_query($query);
					 }
				 }elseif($jenis_rekening == "BELANJA SEWA"){
					 if(empty($k13)){
					 if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and c1='0' and f = '00' and k = '$f' and l ='$g' and m='$h' and n='$i' and o='$j' and id_rincian_belanja ='' and id_tahap='$this->idTahap' ")  ) == 0 ){
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
														 'bk' => $bk,
														 'ck' => $ck,
														 'dk' => $dk,
														 'p' => $p,
														 'q' => $q,
														 'k' => $f,
														 'l' => $g,
														 'm' => $h,
														 'n' => $i,
														 'o' => $j,
														 'jenis_rka' => '2.2.1',
														 'tahun' => $this->tahun,
														 'jenis_anggaran' => $this->jenisAnggaran,
														 'id_tahap' => $this->idTahap,
														 'nama_modul' => 'RKA-SKPD',
														 'id_rincian_belanja' => ''
														 );
									 $queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
									 mysql_query($queryRekening);
								 }
								 //Data Rincian Belanja Tidak Ada


								 if(mysql_num_rows(mysql_query("select * from rincian_belanja where c1 = '$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$f' and l='$g' and m='$h' and n='$i' and o='$j' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and nama_rincian_belanja = 'Pengadaan Barang'  ")) == 0){

									 $dataRincianBelanja = array(
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'c1' => $c1,
												 'c' => $c,
												 'd' => $d,
												 'bk' => $bk,
												 'ck' => $ck,
												 'dk' => $dk,
												 'p' => $p,
												 'q' => $q,
												 'k' => $f,
												 'l' => $g,
												 'm' => $h,
												 'n' => $i,
												 'o' => $j,
												 'sumber_dana' => "APBD",
												 'nama_rincian_belanja' => "Pengadaan Barang"
									 );
									 mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));

								 }
								 //Generate Id Data Rincian Belanja
									$getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
									='$this->jenisAnggaran' and c1 ='".$c1."' and c ='".$c."' and d ='".$d."' and bk ='".$bk."'  and ck ='".$ck."' and dk ='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$f."' and l ='".$g."' and m ='".$h."' and n ='".$i."' and o ='".$j."' and nama_rincian_belanja = 'Pengadaan Barang'  "));
									//Rincian Belanja
									if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='$c1' and c = '$c' and d='$d' and  rincian_perhitungan = '' and bk ='".$bk."' and ck ='".$ck."' and dk='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$f."' and l ='".$g."' and m ='".$h."' and n ='".$i."' and o ='".$j."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'")) ==0)
									{
									 $arrayRincianBelanja = array(
																'c1' => $c1,
																'c' => $c,
																'd' => $d,
																'e' => '00',
																'e1' => '000',
																'f1' => '0',
																'f2' => '0',
																'f' => '00',
																'g' => '00',
																'h' => '00',
																'i' => '00',
																'j' => '000',
																'bk'=> $bk,
																'ck'=> $ck,
																'dk'=> $dk,
																'p' => $p,
																'q' => $q,
																'k' => $f,
																'l' => $g,
																'm' => $h,
																'n' => $i,
																'o' => $j,
																'jenis_rka' => '2.2.1',
																'tahun' => $this->tahun,
																'jenis_anggaran' => $this->jenisAnggaran,
																'id_tahap' => $this->idTahap,
																'nama_modul' => 'RKA-SKPD',
																'id_rincian_belanja' => $getIdRincianBelanja['id'],
																'rincian_perhitungan' => '',
																 );
									 $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
									 mysql_query($queryRincianBelanja);
								 }
								 //Data Barang

												$data = array( 'tahun' => $this->tahun,
														 'jenis_anggaran' => $this->jenisAnggaran,
														 'id_tahap' => $this->idTahap,
														 'c1' => $c1,
														 'c'	=> $c,
														 'd' => $d,
														 'e' => $e,
														 'e1' => $e1,
														 'bk' => $bk,
														 'ck' => $ck,
														 'dk' => $dk,
														 'p' => $p,
														 'q' => $q,
														 'f' => $f,
														 'g' => $g,
														 'h' => $h,
														 'i' => $i,
														 'j' => $j,
														 'j1' => $j,
														 'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
														 'catatan' => $catatan,
														 'jenis_rka' => '2.2.1',
														 'k' => $f,
														 'l' => $g,
														 'm' => $h,
														 'n' => $i,
														 'o' => $j,
														 'nama_modul' => 'RKA-SKPD',
														 'id_rincian_belanja' => $getIdRincianBelanja['id'],
														 'jenis_rekening' => "BELANJA SEWA"
														);
											$query = VulnWalkerUpdate('tabel_anggaran', $data,"id_anggaran = '$id_anggaran'");
											mysql_query($query);
					 }else{

					 if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and c1='0' and f = '00' and k = '$k13' and l ='$l13' and m='$m13' and n='$n13' and o='$o13' and id_rincian_belanja ='' and id_tahap='$this->idTahap' ")  ) == 0 ){
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
														 'bk' => $bk,
														 'ck' => $ck,
														 'dk' => $dk,
														 'p' => $p,
														 'q' => $q,
														 'k' => $k13,
														 'l' => $l13,
														 'm' => $m13,
														 'n' => $n13,
														 'o' => $o13,
														 'jenis_rka' => '2.2.1',
														 'tahun' => $this->tahun,
														 'jenis_anggaran' => $this->jenisAnggaran,
														 'id_tahap' => $this->idTahap,
														 'nama_modul' => 'RKA-SKPD',
														 'sumber_dana' => "APBD",
														 'id_rincian_belanja' => ''
														 );
									 $queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
									 mysql_query($queryRekening);
								 }
								 //Data Rincian Belanja Tidak Ada


								 if(mysql_num_rows(mysql_query("select * from rincian_belanja where c1 = '$c1' and c='$c' and d='$d' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and k='$k13' and l='$l13' and m='$m13' and n='$n13' and o='$o13' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and nama_rincian_belanja = 'Pengadaan Barang'  ")) == 0){

									 $dataRincianBelanja = array(
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'c1' => $c1,
												 'c' => $c,
												 'd' => $d,
												 'bk' => $bk,
												 'ck' => $ck,
												 'dk' => $dk,
												 'p' => $p,
												 'q' => $q,
												 'k' => $k13,
												 'l' => $l13,
												 'm' => $m13,
												 'n' => $n13,
												 'o' => $o13,
												 'sumber_dana' => "APBD",
												 'nama_rincian_belanja' => "Pengadaan Barang"
									 );
									 mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));

								 }
								 //Generate Id Data Rincian Belanja
									$getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
									='$this->jenisAnggaran' and c1 ='".$c1."' and c ='".$c."' and d ='".$d."' and bk ='".$bk."'  and ck ='".$ck."' and dk ='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k13."' and l ='".$l13."' and m ='".$m13."' and n ='".$n13."' and o ='".$o13."' and nama_rincian_belanja = 'Pengadaan Barang'  "));
									//Rincian Belanja
									if(mysql_num_rows(mysql_query("select * from view_rka_2_2_1 where c1='$c1' and c = '$c' and d='$d' and  rincian_perhitungan = '' and bk ='".$bk."' and ck ='".$ck."' and dk='".$dk."' and p ='".$p."' and q='".$q."' and k ='".$k13."' and l ='".$l13."' and m ='".$m13."' and n ='".$n13."' and o ='".$o13."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'")) ==0)
									{
									 $arrayRincianBelanja = array(
																'c1' => $c1,
																'c' => $c,
																'd' => $d,
																'e' => '00',
																'e1' => '000',
																'f1' => '0',
																'f2' => '0',
																'f' => '00',
																'g' => '00',
																'h' => '00',
																'i' => '00',
																'j' => '000',
																'bk'=> $bk,
																'ck'=> $ck,
																'dk'=> $dk,
																'p' => $p,
																'q' => $q,
																'k' => $k13,
																'l' => $l13,
																'm' => $m13,
																'n' => $n13,
																'o' => $o13,
																'jenis_rka' => '2.2.1',
																'tahun' => $this->tahun,
																'jenis_anggaran' => $this->jenisAnggaran,
																'id_tahap' => $this->idTahap,
																'nama_modul' => 'RKA-SKPD',
																'id_rincian_belanja' => $getIdRincianBelanja['id'],
																'rincian_perhitungan' => '',
																 );
									 $queryRincianBelanja = VulnWalkerInsert('tabel_anggaran',$arrayRincianBelanja);
									 mysql_query($queryRincianBelanja);
								 }
								 //Data Barang

												$data = array( 'tahun' => $this->tahun,
														 'jenis_anggaran' => $this->jenisAnggaran,
														 'id_tahap' => $this->idTahap,
														 'c1' => $c1,
														 'c'	=> $c,
														 'd' => $d,
														 'e' => $e,
														 'e1' => $e1,
														 'bk' => $bk,
														 'ck' => $ck,
														 'dk' => $dk,
														 'p' => $p,
														 'q' => $q,
														 'f' => $f,
														 'g' => $g,
														 'h' => $h,
														 'i' => $i,
														 'j' => $j,
														 'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
														 'catatan' => $catatan,
														 'jenis_rka' => '2.2.1',
														 'k' => $k13,
														 'l' => $l13,
														 'm' => $m13,
														 'n' => $n13,
														 'o' => $o13,
														 'nama_modul' => 'RKA-SKPD',
														 'id_rincian_belanja' => $getIdRincianBelanja['id'],
														 'jenis_rekening' => "BELANJA SEWA"
														);
											$query = VulnWalkerUpdate('tabel_anggaran', $data,"id_anggaran = '$id_anggaran'");
											mysql_query($query);

					 }
				 }

			}

			return $cek;
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
	//  $getRincianVolume = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where id_anggaran ='$dt'"));
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
						'value'=>" VOLUME &nbsp &nbsp<input type='text' value='$totalResult' placeholder='JUMLAH' id='jumlah4' readonly >&nbsp SATUAN VOL &nbsp <input type='text' name ='satuanVolume' id ='satuanVolume' style='width:150px;' value='$satuanVolume' readonly> &nbsp &nbsp <span id='detailVolumeRincian'>",
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

	function nullChecker($angka){
		if(empty($angka)){
				$angka = "";
		}
		return $angka;

	}

}
$rkaSKPD221 = new rkaSKPD221Obj();


$arrayResult = VulnWalkerTahap_v2('RKA');
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];

$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$rkaSKPD221->jenisForm = $jenisForm;
$rkaSKPD221->nomorUrut = $nomorUrut;
$rkaSKPD221->urutTerakhir = $nomorUrut;
$rkaSKPD221->tahun = $tahun;
$rkaSKPD221->jenisAnggaran = $jenisAnggaran;
$rkaSKPD221->idTahap = $idTahap;

$rkaSKPD221->username = $_COOKIE['coID'];

$rkaSKPD221->wajibValidasi = $Main->wajibValidasi;
if($Main->wajibValidasi == TRUE){
	$rkaSKPD221->sqlValidasi = " and status_validasi ='1' ";
}else{
	$rkaSKPD221->sqlValidasi = " ";
}


if(empty($rkaSKPD221->tahun)){

	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_rka_2_2_1 "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where id_anggaran = '$maxAnggaran'"));
	/*$rkaSKPD221->tahun = "select max(id_anggaran) as max from view_rka_2_2_1 where nama_modul = 'rkaSKPD221'";*/
	$rkaSKPD221->tahun  = $get2['tahun'];
	$rkaSKPD221->jenisAnggaran = $get2['jenis_anggaran'];
	$rkaSKPD221->urutTerakhir = $get2['no_urut'];
	$rkaSKPD221->jenisFormTerakhir = $get2['jenis_form_modul'];
	$rkaSKPD221->urutSebelumnya = $rkaSKPD221->urutTerakhir - 1;


	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$rkaSKPD221->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaSKPD221->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$rkaSKPD221->currentTahap = $arrayHasil['currentTahap'];
}else{
	$getCurrenttahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$rkaSKPD221->idTahap'"));
	$rkaSKPD221->currentTahap = $getCurrenttahap['nama_tahap'];

	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$rkaSKPD221->idTahap'"));
	$rkaSKPD221->jenisFormTerakhir =  $namaTahap['jenis_form_modul'];
	$rkaSKPD221->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaSKPD221->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
}


$setting = settinganPerencanaan_v2();
$rkaSKPD221->provinsi = $setting['provinsi'];
$rkaSKPD221->kota = $setting['kota'];
$rkaSKPD221->pengelolaBarang = $setting['pengelolaBarang'];
$rkaSKPD221->pejabatPengelolaBarang = $setting['pejabat'];
$rkaSKPD221->pengurusPengelolaBarang = $setting['pengurus'];
$rkaSKPD221->nipPengelola = $setting['nipPengelola'];
$rkaSKPD221->nipPengurus = $setting['nipPengurus'];
$rkaSKPD221->nipPejabat = $setting['nipPejabat'];


if($rkaSKPD221->jenisForm != "PENYUSUNAN"){
$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_rka_2_2_1 where jenis_form_modul = 'PENYUSUNAN' "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rka_2_2_1 where id_anggaran = '$maxAnggaran'"));
	$rkaSKPD221->tahun  = $get2['tahun'];
	$rkaSKPD221->jenisAnggaran = $get2['jenis_anggaran'];
	$rkaSKPD221->urutTerakhir = $get2['no_urut'];
	$rkaSKPD221->jenisFormTerakhir = $get2['jenis_form_modul'];
	$rkaSKPD221->urutSebelumnya = $rkaSKPD221->urutTerakhir - 1;


	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$rkaSKPD221->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaSKPD221->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$rkaSKPD221->currentTahap = $arrayHasil['currentTahap'];
			$rkaSKPD221->jenisForm = "";
			$rkaSKPD221->jenisFormTerakhir = "PENYUSUNAN";
			$rkaSKPD221->idTahap = $get2['id_tahap'];
			$rkaSKPD221->nomorUrut = $get2['no_urut'];
			$rkaSKPD221->urutTerakhir = $get2['no_urut'];
			$rkaSKPD221->idTahap = $idtahapTerakhir;
			$rkaSKPD221->tahun = $get2['tahun'];
}

?>
