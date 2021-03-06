<?php
class rkaSKPD1LP_insObj  extends DaftarObj2{
	var $Prefix = 'rkaSKPD1LP_ins';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'temp_rka_21'; //bonus
	var $TblName_Hapus = 'temp_rka_21';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 0, 0, 0);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 2;
	var $PageTitle = 'RKA-SKPD 1 LP';
	var $PageIcon = 'images/perencanaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='rkbmd.xls';
	var $namaModulCetak='PERENCANAAN';
	var $Cetak_Judul = 'RKA-SKPD 1 LP';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'rkaSKPD1LP_insForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0
	var $modul = "RKA-SKPD";
	var $jenisForm = "";
	var $tahun = "";
	var $nomorUrut = "";
	var $jenisAnggaran = "";
	var $idTahap = "";

	function setTitle(){
	    $id = $_REQUEST['ID_RKA'];
	    //$getTahun = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$id'"));
		return 'RKA-SKPD 1 LP TAHUN '.$this->tahun ;
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

			case 'saveNewRekening':{
				foreach ($_REQUEST as $key => $value) {
					  $$key = $value;
				}
				if(empty($kodeRekening)){
					$err = "Pilih Rekening";
				}elseif(empty($sumberDana)){
					$err = "Pilih Sumber Dana";
				}elseif(mysql_num_rows(mysql_query("select * from temp_rekening_rka_pendapatan_lp where username = '$this->username' and concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening' ")) != 0){
					$err = "Rekening Sudah Ada !";
				}else{
					$explodeKodeRekening = explode('.', $kodeRekening);
					$k = $explodeKodeRekening[0];
					$l = $explodeKodeRekening[1];
					$m = $explodeKodeRekening[2];
					$n = $explodeKodeRekening[3];
					$o = $explodeKodeRekening[4];
					$data = array(
								'k' => $k,
								'l' => $l,
								'm' => $m,
								'n' => $n,
								'o' => $o,
								'username' => $this->username,
								'sumber_dana' => $sumberDana,
								);
					$query = VulnWalkerInsert("temp_rekening_rka_pendapatan_lp",$data);
					mysql_query($query);
					$cek = $query;
				}
				$content = $this->tabelRekening();
			break;
		}

		case 'saveEditRekening':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			if(empty($kodeRekening)){
				$err = "Pilih Rekening";
			}elseif(empty($sumberDana)){
				$err = "Pilih Sumber Dana";
			}elseif(mysql_num_rows(mysql_query("select * from temp_rekening_rka_pendapatan_lp where username = '$this->username' and concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening' and id !='$id'")) != 0){
				$err = "Rekening Sudah Ada ! select * from temp_rekening_rka_pendapatan_lp where username = '$this->username' and concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening' and id !='$id'";
			}else{
				$explodeKodeRekening = explode('.', $kodeRekening);
				$k = $explodeKodeRekening[0];
				$l = $explodeKodeRekening[1];
				$m = $explodeKodeRekening[2];
				$n = $explodeKodeRekening[3];
				$o = $explodeKodeRekening[4];
				$data = array(
							'k' => $k,
							'l' => $l,
							'm' => $m,
							'n' => $n,
							'o' => $o,
							'username' => $this->username,
							'sumber_dana' => $sumberDana,
							);
				$query = VulnWalkerUpdate("temp_rekening_rka_pendapatan_lp",$data,"id = '$id'");
				mysql_query($query);
			}



			$content = $this->tabelRekening();
		break;
		}

		case 'deleteRekening':{
			$getDataRekening = mysql_fetch_array(mysql_query("select * from temp_rekening_rka_pendapatan_lp where id ='".$_REQUEST['id']."'"));
			//mysql_query("insert into temp_remove_rka_1_lp values('".$getDataRekening['id_anggaran']."','$this->username')");
			mysql_query("delete from temp_rekening_rka_pendapatan_lp where id ='".$_REQUEST['id']."'");

			$getAllRincian = mysql_query("select * from temp_rincian_pendapatan_lp where id_rekening_belanja = '".$_REQUEST['id']."'");
			while ($dataRincian = mysql_fetch_array($getAllRincian)) {
					mysql_query("insert into temp_remove_rka_1_lp values('".$dataRincian['id_anggaran']."','$this->username')");
					mysql_query("delete from temp_rincian_pendapatan_lp where id ='".$dataRincian['id']."'");
					$getAllSubRincian =  mysql_query("select * from temp_sub_rincian_pendapatan_lp where id_rincian_belanja = '".$dataRincian['id']."'");
					while ($dataSubRincian = mysql_fetch_array($getAllSubRincian)) {
						  mysql_query("insert into temp_remove_rka_1_lp values('".$dataSubRincian['id_anggaran']."','$this->username')");
							mysql_query("delete from temp_sub_rincian_pendapatan_lp where id ='".$dataSubRincian['id']."'");
					}

			}

			$cek = '';
			$err = '';
			$content = $this->tabelRekening();
		break;
		}

		case 'cancelRekening':{

			$cek = '';
			$err = '';
			$content = $this->tabelRekening();
		break;
		}

		case 'addRekening':{

			$cek = '';
			$err = '';
			$content =array(
											'tabelRekening' =>  $this->addRekening(),
											'tabelRincianBelanja' => $this->tabelRincianBelanja(),
											'tabelSubRincianBelanja' => $this->tabelSubRincianBelanja(),
										 	);
		break;
		}
		case 'editRekening':{
			$cek = '';
			$err = '';
			$content = array('tabelRekening' => $this->editRekening($_REQUEST['id']) , 'tabelRincianBelanja' => $this->tabelRincianBelanja(), 'tabelSubRincianBelanja' => $this->tabelSubRincianBelanja());
		break;
		}

		case 'rincianBelanja':{
			$getData = mysql_fetch_array(mysql_query("select * from temp_rekening_rka_pendapatan_lp where id ='".$_REQUEST['id']."'"));
			$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k ='".$getData['k']."' and l ='".$getData['l']."' and m ='".$getData['m']."' and n ='".$getData['n']."' and o ='".$getData['o']."'"));
			$namaRekening = $getNamaRekening['nm_rekening'];

			$kalimatRincianBelanja = "<table id='kalimatRincianBelanja'>
				<tr>
					<td><table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
			<tbody>

			<tr valign='middle' align='left'>
			<td class='border:none'>
				<b>REKENING : $namaRekening</b>
			</td>
			</tr>
			</tbody></table>";
			$kalimatSubRincianBelanja = "				<table id='kalimatSubRincianBelanja' cellpadding='0' cellspacing='0' border='0' id='toolbar'>
							<tbody>
							</tr>
							<tr valign='middle' align='left'>
							<td class='border:none'>
								<b>REKENING : $namaRekening</b>
							</td>
							</tr>
							</tbody></table>";

			$content = array('tabelRekening' => $this->tabelRekeningSelectedRincian($_REQUEST['id']) , 'tabelRincianBelanja' => $this->tabelRincianBelanja($_REQUEST['id']), 'tabelSubRincianBelanja' => $this->tabelSubRincianBelanja(), "kalimatRincianBelanja" => $kalimatRincianBelanja , "kalimatSubRincianBelanja" => $kalimatSubRincianBelanja );
		break;
		}
		case 'addRincianBelanja':{

			$cek = '';
			$err = '';
			$content = array('tabelRincianBelanja' => $this->addRincianBelanja($_REQUEST['id']),'tabelSubRincianBelanja' => $this->tabelSubRincianBelanja());
		break;
		}
		case 'editRincianBelanja':{
			$cek = '';
			$err = '';
			$content = array('tabelRincianBelanja' => $this->editRincianBelanja($_REQUEST['idRekeningBelanja'],$_REQUEST['idEdit']), 'tabelSubRincianBelanja' => $this->tabelSubRincianBelanja());
		break;
		}
		case 'cancelRincianBelanja':{

			$cek = '';
			$err = '';
			$content = $this->tabelRincianBelanja($_REQUEST['id']);
		break;
		}
		case 'saveNewRincianBelanja':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			if(empty($uraianBelanja)){
				$err = "Isi Uraian !";
			}elseif(mysql_num_rows(mysql_query("select * from temp_rincian_pendapatan_lp where uraian = '$uraianBelanja' and id_rekening_belanja ='$idRekeningBelanja' ")) != 0){
				$err = "Uraian Sudah Ada !";
			}else{

				$data = array(
							'id_rekening_belanja' => $idRekeningBelanja,
							'uraian' => $uraianBelanja,
							'username' => $this->username

							);
				$query = VulnWalkerInsert("temp_rincian_pendapatan_lp",$data);
				mysql_query($query);
			}



			$content = $this->tabelRincianBelanja($idRekeningBelanja);
		break;
		}
		case 'saveEditRincianBelanja':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			if(empty($uraianBelanja)){
				$err = "Isi Uraian";
			}elseif(mysql_num_rows(mysql_query("select * from temp_rincian_pendapatan_lp where uraian = '$uraianBelanja' and id_rekening_belanja ='$idRekeningBelanja' and id !='$idEdit' ")) != 0){
				$err = "Uraian Sudah Ada !";
			} else{

				$data = array(
							'id_rekening_belanja' => $idRekeningBelanja,
							'uraian' => $uraianBelanja,

							);
				$query = VulnWalkerUpdate("temp_rincian_pendapatan_lp",$data,"id = '$idEdit'");
				mysql_query($query);
			}



			$content = $this->tabelRincianBelanja($idRekeningBelanja);
		break;
		}
		case 'deleteRincianBelanja':{
			$getDataRincian = mysql_fetch_array(mysql_query("select * from temp_rincian_pendapatan_lp where id ='".$_REQUEST['id']."'"));
			mysql_query("insert into temp_remove_rka_1_lp values('".$getDataRincian['id_anggaran']."','$this->username')");
			mysql_query("delete from temp_rincian_pendapatan_lp where id ='".$_REQUEST['id']."'");
			$getAllSubRincian =  mysql_query("select * from temp_sub_rincian_pendapatan_lp where id_rincian_belanja = '".$_REQUEST['id']."'");
			while ($dataSubRincian = mysql_fetch_array($getAllSubRincian)) {
					mysql_query("insert into temp_remove_rka_1_lp values('".$dataSubRincian['id_anggaran']."','$this->username')");
					mysql_query("delete from temp_sub_rincian_pendapatan_lp where id ='".$dataSubRincian['id']."'");
			}
			$cek = '';
			$err = '';
			$content = $this->tabelRincianBelanja($_REQUEST['idRekeningBelanja']);
		break;
		}

		case 'subRincianBelanja':{
			$cek = '';
			$err = '';
			$getData = mysql_fetch_array(mysql_query("select * from temp_rekening_rka_pendapatan_lp where id ='".$_REQUEST['idRekeningBelanja']."'"));
			$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k ='".$getData['k']."' and l ='".$getData['l']."' and m ='".$getData['m']."' and n ='".$getData['n']."' and o ='".$getData['o']."'"));
			$namaRekening = $getNamaRekening['nm_rekening'];

			$getDataRincianBelanja = mysql_fetch_array(mysql_query("select * from temp_rincian_pendapatan_lp where id = '".$_REQUEST['id']."'"));
			$rincianBelanja = $getDataRincianBelanja['uraian'];
			$kalimatSubRincianBelanja = "<table>
				<tr>
					<td><table id='kalimatSubRincianBelanja' cellpadding='0' cellspacing='0' border='0' id='toolbar'>
			<tbody>
			<tr valign='middle' align='left'>
			<td class='border:none'>
				<b>REKENING : $namaRekening</b>
			</td>
			</tr>
			<tr valign='middle' align='left'>
			<td class='border:none'>
				<b>RINCIAN REKENING : $rincianBelanja</b>
			</td>
			</tr>
			</tbody></table>";


			$content = array('tabelRincianBelanja' => $this->tabelRincianBelanjaSelected($_REQUEST['idRekeningBelanja'],$_REQUEST['id']),
												'tabelSubRincianBelanja' => $this->tabelSubRincianBelanja($_REQUEST['id']), 'kalimatSubRincianBelanja' => $kalimatSubRincianBelanja
												);
		break;
		}

		case 'addSubRincianBelanja':{

			$cek = '';
			$err = '';
			$content =array(
											'tabelSubRincianBelanja' => $this->addSubRincianBelanja($_REQUEST['id'],$_REQUEST['idRekeningBelanja'])
										 	);
		break;
		}
		case 'editSubRincianBelanja':{
			$cek = '';
			$err = '';
			$content = array('tabelSubRincianBelanja' => $this->editSubRincianBelanja($_REQUEST['idRekeningBelanja'],$_REQUEST['idRincianBelanja'],$_REQUEST['idEdit']));
		break;
		}


		case 'cancelSubRincianBelanja':{

			$cek = '';
			$err = '';
			$content = $this->tabelSubRincianBelanja($_REQUEST['id']);
		break;
		}
		case 'deleteSubRincianBelanja':{
			$getDataSubRincian = mysql_fetch_array(mysql_query("select * from temp_sub_rincian_pendapatan_lp where id ='".$_REQUEST['id']."'"));
			mysql_query("insert into temp_remove_rka_1_lp values('".$getDataSubRincian['id_anggaran']."','$this->username')");
			mysql_query("delete from temp_sub_rincian_pendapatan_lp where id ='".$_REQUEST['id']."'");
			$cek = '';
			$err = '';
			$content = $this->tabelSubRincianBelanja($_REQUEST['idRincianBelanja']);
		break;
		}

		case 'saveNewSubRincianBelanja':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			if(empty($uraianBelanja)){
				$err = "Isi Uraian !";
			}elseif(empty($hargaSatuan)){
				$err = "Isi Harga Satuan";
			}elseif(empty($volumeBarang)){
				$err = "Isi Volume";
			}else{

				if(empty($kodeBarang)){
						$f1 = '0';
						$f2 = '0';
						$f = '00';
						$g = '00';
						$h = '00';
						$i = '00';
						$j = '000';
				}else{
						$kodeBarang = explode(".",$kodeBarang);
						$f1 = $kodeBarang[0];
						$f2 = $kodeBarang[1];
						$f =  $kodeBarang[2];
						$g =  $kodeBarang[3];
						$h =  $kodeBarang[4];
						$i =  $kodeBarang[5];
						$j =  $kodeBarang[6];
				}
				$getUrutanPosisi = mysql_fetch_array(mysql_query("select max(urutan_posisi) from temp_sub_rincian_pendapatan_lp where username = '$this->username' and id_rincian_belanja = '$idRincianBelanja' order by urutan_posisi"));
				$urutanPosisi = $getUrutanPosisi['max(urutan_posisi)'] + 1;
				$data = array(
							'id_rincian_belanja' => $idRincianBelanja,
							'uraian' => $uraianBelanja,
							'harga_satuan' => $hargaSatuan,
							'rincian_volume' => $rincianVolume,
							'f1' => $f1,
							'f2' => $f2,
							'f' => $f,
							'g' => $g,
							'h' => $h,
							'i' => $i,
							'j' => $j,
							'volume1' => $volume1,
							'volume2' => $volume2,
							'volume3' => $volume3,
							'satuan1' => $satuan1,
							'satuan2' => $satuan2,
							'satuan3' => $satuan3,
							'username' => $_COOKIE['coID'],
							'urutan_posisi' => $urutanPosisi,

							);
				$query = VulnWalkerInsert("temp_sub_rincian_pendapatan_lp",$data);
				mysql_query($query);
				$cek = $query;
			}



			$content = $this->tabelSubRincianBelanja($idRincianBelanja);
		break;
		}


		case 'saveEditSubRincianBelanja':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			if(empty($uraianBelanja)){
				$err = "Isi Uraian !";
			}elseif(empty($hargaSatuan)){
				$err = "Isi Harga Satuan";
			}elseif(empty($volumeBarang)){
				$err = "Isi Volume";
			}else{

				if(empty($kodeBarang)){
						$f1 = '0';
						$f2 = '0';
						$f = '00';
						$g = '00';
						$h = '00';
						$i = '00';
						$j = '000';
				}else{
						$kodeBarang = explode(".",$kodeBarang);
						$f1 = $kodeBarang[0];
						$f2 = $kodeBarang[1];
						$f =  $kodeBarang[2];
						$g =  $kodeBarang[3];
						$h =  $kodeBarang[4];
						$i =  $kodeBarang[5];
						$j =  $kodeBarang[6];
				}

				$data = array(
							'id_rincian_belanja' => $idRincianBelanja,
							'uraian' => $uraianBelanja,
							'harga_satuan' => $hargaSatuan,
							'rincian_volume' => $rincianVolume,
							'f1' => $f1,
							'f2' => $f2,
							'f' => $f,
							'g' => $g,
							'h' => $h,
							'i' => $i,
							'j' => $j,
							'volume1' => $volume1,
							'volume2' => $volume2,
							'volume3' => $volume3,
							'satuan1' => $satuan1,
							'satuan2' => $satuan2,
							'satuan3' => $satuan3,

							);
				$query = VulnWalkerUpdate("temp_sub_rincian_pendapatan_lp",$data,"id = '$idEdit'");
				mysql_query($query);
				$cek = $query;
			}



			$content = $this->tabelSubRincianBelanja($idRincianBelanja);
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


		case 'finish':{
			foreach ($_REQUEST as $key => $value) {
			  	$$key = $value;
			 }

			$username = $_COOKIE['coID'];
			if($this->jenisForm != 'PENYUSUNAN'){
				$err = "TAHAP PENYUSUNAN TELAH HABIS";
			}

			$getRekeningKosong = mysql_query("select * from temp_rekening_rka_pendapatan_lp where username = '$this->username'");
			while($dataRekening = mysql_fetch_array($getRekeningKosong)){
					$dataRincianBelanjaKosong = mysql_query("select * from temp_rincian_pendapatan_lp where id_rekening_belanja = '".$dataRekening['id']."'");
					if(mysql_num_rows($dataRincianBelanjaKosong) == 0)$err = "Data belum lengkap !";
					while ($dataRincianBelanja = mysql_fetch_array($dataRincianBelanjaKosong)) {
							if(mysql_num_rows(mysql_query("select * from temp_sub_rincian_pendapatan_lp where username = '$this->username' and id_rincian_belanja ='".$dataRincianBelanja['id']."'")) == 0){
									$err = "Data belum lengkap !";
							}
					}
			}
			// elseif(mysql_num_rows(mysql_query("select * from temp_rka_221  where user ='$username' and delete_status = '0'")) == 0){
			// 	$err = "Data kosong";
			// }

			if(empty($err)){
				if(mysql_num_rows(mysql_query("select * from temp_sub_rincian_pendapatan_lp where username = '$this->username' and id_anggaran !=''")) == 0){
						$execute = mysql_query("select * from temp_sub_rincian_pendapatan_lp  where username ='$username' ");
						while($subRincianBelanja = mysql_fetch_array($execute)){
							$getRincianBelanja = mysql_fetch_array(mysql_query("select * from temp_rincian_pendapatan_lp where id = '".$subRincianBelanja['id_rincian_belanja']."'"));
							$getRekeningBelanja = mysql_fetch_array(mysql_query("select * from temp_rekening_rka_pendapatan_lp where id = '".$getRincianBelanja['id_rekening_belanja']."'"));
							if(mysql_num_rows(mysql_query("select * from rincian_belanja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$postUrusan' and c='$postBidang' and d='$postSKPD' and bk='$postBK' and ck='$postCK' and dk='$postDK' and p='$postP' and q='$postQ' and k='".$getRekeningBelanja['k']."' and l='".$getRekeningBelanja['l']."' and m='".$getRekeningBelanja['m']."' and n='".$getRekeningBelanja['n']."' and o='".$getRekeningBelanja['o']."' and sumber_dana = '".$getRekeningBelanja['sumber_dana']."' and nama_rincian_belanja = '".$getRincianBelanja['uraian']."'  ")) == 0){
									$dataRincianBelanja = array(
												'tahun' => $this->tahun,
												'jenis_anggaran' => $this->jenisAnggaran,
												'c1' => $postUrusan,
												'c' => $postBidang,
												'd' => $postSKPD,
												'bk' => $postBK,
												'ck' => $postCK,
												'dk' => $postDK,
												'p' => $postP,
												'q' => $postQ,
												'k' => $getRekeningBelanja['k'],
												'l' => $getRekeningBelanja['l'],
												'm' => $getRekeningBelanja['m'],
												'n' => $getRekeningBelanja['n'],
												'o' => $getRekeningBelanja['o'],
												'sumber_dana' => $getRekeningBelanja['sumber_dana'],
												'nama_rincian_belanja' => $getRincianBelanja['uraian']
									);
									mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));
							}


							$queryCekRekening = "select * from view_rka_1 where c1='0' and j = '000' and rincian_perhitungan = '' and bk ='".$postBK."' and ck ='".$postCK."' and dk='".$postDK."' and p ='".$postP."' and q='".$postQ."' and k ='".$getRekeningBelanja['k']."' and l ='".$getRekeningBelanja['l']."' and m ='".$getRekeningBelanja['m']."' and n ='".$getRekeningBelanja['n']."' and o ='".$getRekeningBelanja['o']."' and id_rincian_belanja='' and id_tahap='$this->idTahap' ";
							if(mysql_num_rows(mysql_query($queryCekRekening)) == 0){
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
														 'bk'=> $postBK,
				 										 'ck'=> $postCK,
				 										 'dk'=> $postDK,
				 										 'p' => $postP,
				 										 'q' => $postQ,
														 'k' => $getRekeningBelanja['k'],
														 'l' => $getRekeningBelanja['l'],
														 'm' => $getRekeningBelanja['m'],
														 'n' => $getRekeningBelanja['n'],
														 'o' => $getRekeningBelanja['o'],
														 'sumber_dana' => $getRekeningBelanja['sumber_dana'],
														 'jenis_rka' => '1',
														 'tahun' => $this->tahun,
														 'jenis_anggaran' => $this->jenisAnggaran,
														 'id_tahap' => $this->idTahap,
														 'nama_modul' => 'RKA-SKPD',
														 'id_rincian_belanja' => ""
															);
								$queryInsertRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
								mysql_query($queryInsertRekening);
							}

							$getUplineName = mysql_fetch_array(mysql_query("select * from temp_rincian_pendapatan_lp where id = '".$subRincianBelanja['id_rincian_belanja']."'"));

							$getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
							 ='$this->jenisAnggaran' and c1 ='".$postUrusan."' and c ='".$postBidang."' and d ='".$postSKPD."' and bk ='".$postBK."'  and ck ='".$postCK."' and dk ='".$postDK."' and p ='".$postP."' and q='".$postQ."' and k ='".$getRekeningBelanja['k']."' and l ='".$getRekeningBelanja['l']."' and m ='".$getRekeningBelanja['m']."' and n ='".$getRekeningBelanja['n']."' and o ='".$getRekeningBelanja['o']."' and nama_rincian_belanja = '".$getUplineName['uraian']."'  "));

							 $queryCekRincianBelaja = "select * from view_rka_1 where c1='$postUrusan' and c = '$postBidang' and d='$postSKPD' and  rincian_perhitungan = '' and bk ='".$postBK."' and ck ='".$postCK."' and dk='".$postDK."' and p ='".$postP."' and q='".$postQ."' and k ='".$getRekeningBelanja['k']."' and l ='".$getRekeningBelanja['l']."' and m ='".$getRekeningBelanja['m']."' and n ='".$getRekeningBelanja['n']."' and o ='".$getRekeningBelanja['o']."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'";
							 if(mysql_num_rows(mysql_query($queryCekRincianBelaja)) == 0){
								 $arrayRincianBelanja = array(
															'c1' => $postUrusan,
															'c' => $postBidang,
															'd' => $postSKPD,
															'e' => '00',
															'e1' => '000',
															'f1' => '0',
		 										  	  'f2' => '0',
		 										  	  'f' => '00',
		 										 		  'g' => '00',
		 										  	  'h' => '00',
		 												  'i' => '00',
		 												  'j' => '000',
															'bk'=> $postBK,
															'ck'=> $postCK,
															'dk'=> $postDK,
															'p' => $postP,
															'q' => $postQ,
															'k' => $getRekeningBelanja['k'],
															'l' => $getRekeningBelanja['l'],
															'm' => $getRekeningBelanja['m'],
															'n' => $getRekeningBelanja['n'],
															'o' => $getRekeningBelanja['o'],
															'jenis_rka' => '1',
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

							 $queryCekSubRincian = "select * from view_rka_1 where c1='$postUrusan' and c = '$postBidang' and d='$postSKPD' and  rincian_perhitungan = '".$subRincianBelanja['uraian']."' and bk ='".$postBK."' and ck ='".$postCK."' and dk='".$postDK."' and p ='".$postP."' and q='".$postQ."' and k ='".$getRekeningBelanja['k']."' and l ='".$getRekeningBelanja['l']."' and m ='".$getRekeningBelanja['m']."' and n ='".$getRekeningBelanja['n']."' and o ='".$getRekeningBelanja['o']."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='".$subRincianBelanja['f1']."' and f2='".$subRincianBelanja['f2']."' and f='".$subRincianBelanja['f']."' and g='".$subRincianBelanja['g']."' and h ='".$subRincianBelanja['h']."' and i ='".$subRincianBelanja['i']."' and j ='".$subRincianBelanja['j']."' and id_tahap='$this->idTahap'";
							 if(mysql_num_rows(mysql_query($queryCekSubRincian)) == 0){
								 	if($subRincianBelanja['volume3'] != ''){
											$hasilKaliVolume = $subRincianBelanja['volume1'] * $subRincianBelanja['volume2'] * $subRincianBelanja['volume3'];
											$satuanTotal = $subRincianBelanja['satuan1']." / ".$subRincianBelanja['satuan2']." / ".$subRincianBelanja['satuan3'];
									}elseif($subRincianBelanja['volume2'] != ''){
											$hasilKaliVolume = $subRincianBelanja['volume1'] * $subRincianBelanja['volume2'] ;
											$satuanTotal = $subRincianBelanja['satuan1']." / ".$subRincianBelanja['satuan2'];
									}elseif($subRincianBelanja['volume1'] != ''){
											$hasilKaliVolume = $subRincianBelanja['volume1']  ;
											$satuanTotal = $subRincianBelanja['satuan1'];
									}
									 $arraySubRincian = array(
																'c1' => $postUrusan,
																'c' => $postBidang,
																'd' => $postSKPD,
																'e' => '00',
																'e1' => '000',
																'f1' => $subRincianBelanja['f1'],
																'f2' => $subRincianBelanja['f2'],
																'f' => $subRincianBelanja['f'],
																'g' => $subRincianBelanja['g'],
																'h' => $subRincianBelanja['h'],
																'i' => $subRincianBelanja['i'],
																'j' => $subRincianBelanja['j'],
																'bk'=> $postBK,
																'ck'=> $postCK,
																'dk'=> $postDK,
																'p' => $postP,
																'q' => $postQ,
																'k' => $getRekeningBelanja['k'],
																'l' => $getRekeningBelanja['l'],
																'm' => $getRekeningBelanja['m'],
																'n' => $getRekeningBelanja['n'],
																'o' => $getRekeningBelanja['o'],
																'jenis_rka' => '1',
																'tahun' => $this->tahun,
																'jenis_anggaran' => $this->jenisAnggaran,
																'id_tahap' => $this->idTahap,
																'nama_modul' => 'RKA-SKPD',
																'id_rincian_belanja' => $getIdRincianBelanja['id'],
																'rincian_volume' => $subRincianBelanja['rincian_volume'],
																'volume_rek' => $hasilKaliVolume,
																'jumlah' => $subRincianBelanja['harga_satuan'],
																'jumlah_harga' => $hasilKaliVolume * $subRincianBelanja['harga_satuan'],
																'rincian_perhitungan' => $subRincianBelanja['uraian'],
																'jumlah1' => $this->generateNumber($subRincianBelanja['volume1']),
																'jumlah2' => $this->generateNumber($subRincianBelanja['volume2']),
																'jumlah3' => $this->generateNumber($subRincianBelanja['volume3']),
																'satuan1' => $subRincianBelanja['satuan1'],
																'satuan2' => $subRincianBelanja['satuan2'],
																'satuan3' => $subRincianBelanja['satuan3'],
																'satuan_total' => $satuanTotal,
																'urutan_posisi' => $subRincianBelanja['urutan_posisi']
																 );
									 $queryInsertSubRincian = VulnWalkerInsert('tabel_anggaran',$arraySubRincian);
									 mysql_query($queryInsertSubRincian);
							 }


						}
				}else{
					$this->editData();

				}

				$getAllRemoved = mysql_query("select * from temp_remove_rka_1_lp where username = '$this->username'");
				while($removeID = mysql_fetch_array($getAllRemoved)){
						mysql_query("delete from tabel_anggaran where id_anggaran  = '".$removeID['id_anggaran']."'");
				}

			}




		break;
		}

		case 'Simpan':{

			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}

			$c1 = explode(".",$urusan);
			$c1 = $c1[0];
			$c = explode(".",$bidang);
			$c = $c[0];
			$d = explode(".",$skpd);
			$d = $d[0];
			$e = explode(".",$unit);
			$e = $e[0];
			$e1 = explode(".",$subunit);
			$e1 = $e1[0];




		break;
	    }


		case 'SaveJob':{
			$username = $_COOKIE['coID'];
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 $kodeRekening2 = explode(".",$kodeRekening);
			 $k = $kodeRekening2[0];
			 $l = $kodeRekening2[1];
			 $m = $kodeRekening2[2];
			 $n = $kodeRekening2[3];
			 $o = $kodeRekening2[4];

			 $getMaxLeftUrut = mysql_fetch_array(mysql_query("select max(left_urut) from ref_pekerjaan where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and k='$k' and l='$l' and m='$m' and  n='$n' and o ='$o'"));
			 $left_urut = $getMaxLeftUrut['max(left_urut)'] + 1;

			 $data = array( 'nama_pekerjaan' => $namaPekerjaan,
			 				'c1' => $c1,
							'c' => $c,
							'd' => $d,
							'e' => $e,
							'e1' => $e1,
							'bk' => $bk,
							'ck' => $ck,
							'p' => $p,
							'q' => $q,
							'k' => $k,
							'l' => $l,
							'm' => $m,
							'n' => $n,
							'o' => $o,
							'left_urut' => $left_urut

			 				);
			 $query = VulnWalkerInsert("ref_pekerjaan",$data);

			 if(empty($namaPekerjaan)){
			 	$err = "input gagal";
			 }else{
				$execute = mysql_query($query);
			 }
			$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' ";
			$getCurrentInsert = mysql_fetch_array(mysql_query("select max(id) from ref_pekerjaan where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q'"));
			$cmbPekerjaan = cmbQuery('o1', $getCurrentInsert['max(id)'], $codeAndNamePekerjaan," onchange=$this->Prefix.setNoUrut(); ",'-- PEKERJAAN --');
			$getMaxUrut = mysql_fetch_array(mysql_query("select max(urut) from temp_rka_21 where user ='$username'"));
			$urut = $getMaxUrut['max(urut)'] + 1;
			$content = array('cmbPekerjaan' => $cmbPekerjaan, 'left_urut' => $left_urut, 'urut' => $urut );
		break;
	    }
		case 'SaveEditJob':{
			$username = $_COOKIE['coID'];
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 $kodeRekening2 = explode(".",$kodeRekening);
			 $k = $kodeRekening2[0];
			 $l = $kodeRekening2[1];
			 $m = $kodeRekening2[2];
			 $n = $kodeRekening2[3];
			 $o = $kodeRekening2[4];

			 $getMaxLeftUrut = mysql_fetch_array(mysql_query("select left_urut  from ref_pekerjaan where  id ='$o1'"));
			 $left_urut = $getMaxLeftUrut['left_urut'];

			 $data = array( 'nama_pekerjaan' => $namaPekerjaan

			 				);
			 $query = VulnWalkerUpdate("ref_pekerjaan",$data,"id = '$o1'");

			 if(empty($namaPekerjaan)){
			 	$err = "input gagal";
			 }else{
				$execute = mysql_query($query);
			 }
			$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' ";
			$getCurrentInsert = mysql_fetch_array(mysql_query("select max(id) from ref_pekerjaan where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q'"));
			$cmbPekerjaan = cmbQuery('o1', $getCurrentInsert['max(id)'], $codeAndNamePekerjaan," onchange=$this->Prefix.setNoUrut(); ",'-- PEKERJAAN --');

			$getUrut = mysql_fetch_array(mysql_query("select * from temp_rka_21 where o1='$o1'"));
			$urut = $getUrut['urut'];

			$content = array('cmbPekerjaan' => $cmbPekerjaan, 'left_urut' => $left_urut, 'urut' => $urut, 'query' => "select left_urut , urut as urut from ref_pekerjaan where  id ='$o1'" );
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

		case 'cekNoUrut':{
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 $username = $_COOKIE['coID'];
			 $cekRow = mysql_num_rows(mysql_query("select * from temp_rka_21 where o1 = '$noPekerjaan'   and user ='$username' "));
			 if($cekRow == 0){
			 	$get = mysql_fetch_array(mysql_query("select max(urut) from temp_rka_21 where  user ='$username' and delete_status !='1' and o1 !='0' "));
			 	$urut = $get['max(urut)'] + 1;
			 }else{
			 	 $get = mysql_fetch_array(mysql_query("select * from temp_rka_21 where o1 = '$noPekerjaan'   and user ='$username' "));
				 $urut = $get['urut'];
			 }

			 $getLeftUrut = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id ='$noPekerjaan'"));
			 $content = array('leftUrut' => $getLeftUrut['left_urut']  ,'noUrut' => $urut );

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

		case 'SaveSatuan':{
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }

			 $data = array( "satuan_rekening" => $namaPekerjaan,
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
		case 'hapus2':{
	    	 $id = $_REQUEST['id'];
			 $get = mysql_fetch_array(mysql_query("select * from temp_rka_21 where id='$id' "));
			 $username = $_COOKIE['coID'];
			 $noPekerjaan = $get['o1'];
			 $noUrutPekerjaan = $get['urut'];
			 mysql_query("update  temp_rka_21 set delete_status = '1', o1 ='0' where id='$id'");
			 $execute = mysql_query("select * from temp_rka_21  where user='$username' and o1='$noPekerjaan' and delete_status = '0 order by o1, rincian_perhitungan");
			 $angkaUrut = 1;
			 while($rows = mysql_fetch_array($execute)){
				if($rows['rincian_perhitungan'] == ''){
					$angkaUrut = '0';
				}
				$dataEditNoUrut = array('urut' => $noUrutPekerjaan,
			 						 	'o2' => $angkaUrut);
				$idTemp = $rows['id'];
				mysql_query(VulnWalkerUpdate("temp_rka_21",$dataEditNoUrut," id='$idTemp'"));
				$angkaUrut = $angkaUrut + 1;

				$content .= VulnWalkerUpdate("temp_rka_21",$dataEditNoUrut," id='$idTemp'");
			 }
		break;
	    }

		case 'saveEdit':{
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 $username = $_COOKIE['coID'];




			 $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
			 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
			 $getPaguIndikatif = mysql_fetch_array(mysql_query("select sum(jumlah) from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and id_tahap = '$idTahapRenja' "));
			 $sisaPagu = $getPaguIndikatif['sum(jumlah)'] - $paguYangTerpakaiDiTabelAnggaran - $paguYangTerpakaiDITemp;


			 //cek pagu

			 /*if($rincianVolume == ''){
			 	$err = "Lengkapi Rincian Volume";
			 }elseif($teralokasi == ""){
			 	$err = "Lengkapi Alokasi";
			 }else*/
			 if(empty($volumeRek)){
			 	$err = "Isi Volume";
			 }elseif(empty($satuanRek) && $kodeBarang == ''){
			 	$err = "Pilih Satuan";
			 }elseif($kodeRekening == '' ){
			 	$err = "Pilih Kode Rekening";
			 }elseif(empty($hargaSatuan)){
			 	$err = "Isi Harga Satuan";
			 }
			 $kodeRekening = explode('.',$kodeRekening);
			 $k = $kodeRekening[0];
			 $l = $kodeRekening[1];
			 $m = $kodeRekening[2];
			 $n = $kodeRekening[3];
			 $o = $kodeRekening[4];
			 if($err == ''){


			 $data = array(

							'k' => $k,
							'l' => $l,
							'm' => $m,
							'n' => $n,
							'o' => $o,
							'rincian_perhitungan' => $rincianPerhitungan,
							'volume_rek' => $volumeRek,
							'harga_satuan' => $hargaSatuan,
							'jumlah_harga' => $hargaSatuan * $volumeRek,
							'satuan' => $satuanRek,
			 				);
			 $query = VulnWalkerUpdate("temp_rka_21",$data,"id='$id'");
			 mysql_query($query);


			 }

			$content = array("kodeRekening" => $_REQUEST['kodeRekening'], "namaRekening" => $_REQUEST['namaRekening'], "o1Html" => $_REQUEST['o1Html']);

		break;
	    }

		case 'Simpan2':{
	    	foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 $username = $_COOKIE['coID'];






			 if(empty($volumeRek)){
			 	$err = "Isi Volume";
			 }elseif(empty($satuanRek)){
			 	$err = "Pilih Satuan";
			 }elseif($kodeRekening == '' ){
			 	$err = "Pilih Kode Rekening";
			 }elseif(empty($hargaSatuan)){
			 	$err = "Isi Harga Satuan";
			 }

			 /*elseif($teralokasi == ""){
			 	$err = "Lengkapi Alokasi";
			 }*/
			 $kodeRekening = explode('.',$kodeRekening);
			 $k = $kodeRekening[0];
			 $l = $kodeRekening[1];
			 $m = $kodeRekening[2];
			 $n = $kodeRekening[3];
			 $o = $kodeRekening[4];
			 if($err == ''){


			 $data = array(
			 				'c1' => $c1,
							 'c' => $c,
							   'd' => $d,
							   'e' => '00',
							   'e1' => '00',
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
							'rincian_perhitungan' => $rincianPerhitungan,
							'volume_rek' => $volumeRek,
							'harga_satuan' => $hargaSatuan,
							'jumlah_harga' => $hargaSatuan * $volumeRek,
							'satuan' => $satuanRek,
							'user' => $username
			 				);
			 $query = VulnWalkerInsert("temp_rka_21",$data);
			 mysql_query($query);

			 }


			$content = array("kodeRekening" => $_REQUEST['kodeRekening'], "namaRekening" => $_REQUEST['namaRekening'], "o1Html" => $_REQUEST['o1Html']);
		break;
	    }

		case 'newJob':{
				$fm = $this->newJob($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}

		case 'editJob':{
				$dt = $_REQUEST['o1'];
				$fm = $this->editJob($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}

		case 'newSatuanSatuan':{
				$fm = $this->newSatuanSatuan($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'newSatuanVolume':{
				$fm = $this->newSatuanVolume($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}

		case 'edit':{
				foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}
				$username = $_COOKIE['coID'];
				mysql_query("delete from temp_alokasi_rka_21_v2 where user = '$username'");
				$get = mysql_fetch_array(mysql_query("select * from temp_rka_21 where id = '$id'"));
				foreach ($get as $key => $value) {
				  $$key = $value;
				}


				$dataAlokasi = array(
										'jan' => $jan,
										'feb' => $feb,
										'mar' => $mar,
										'apr' => $apr,
										'mei' => $mei,
										'jun' => $jun,
										'jul' => $jul,
										'agu' => $agu,
										'sep' => $sep,
										'okt' => $okt,
										'nop' => $nop,
										'des' => $des,
										'jenis_alokasi_kas' => $jenis_alokasi_kas,
										'user' => $username

									);
				mysql_query(VulnWalkerInsert('temp_alokasi_rka_21_v2',$dataAlokasi));
				/*if($satuan_total == ''){
					$statusAlokasi = 'false';
				}else{*/
					$statusAlokasi = 'true';
				//}

				if($f == '00'){

					$kunci = '0';
				}else{
					$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' "));
					$rincianPerhitungan = $getNamaBarang['nm_barang'];
					$kunci = '1';
					$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;
				}

				$kodeRekening = $k.".".$l.".".$m.".".$n.".".$o;
				$codeAndNameProgram = "select p,concat(p,'. ',nama) from ref_program where bk='$bk' and ck='$ck' and dk='0' and p='$p' and q='0'";
				$cmbProgram = cmbQuery('p',$p,$codeAndNameProgram,'disabled','-- PROGRAM --');
				$codeAndNameKegiatan = "select q,concat(q,'. ',nama) from ref_program where bk='$bk' and ck='$ck' and dk='0' and p='$p' and q='$q'";
				$cmbKegiatan = cmbQuery('q',$q,$codeAndNameKegiatan,'disabled','-- KEGIATAN --');
				$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
				$namaRekening= $getNamaRekening['nm_rekening'];
				$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' ";
				$cmbPekerjaan = cmbQuery('o1', $o1, $codeAndNamePekerjaan," onchange=$this->Prefix.setNoUrut(); ",'-- PEKERJAAN --');
				$noUrut = $o1;
				$hargaSatuan = $harga_satuan;
				$content = array('bk' => $bk,
								 'ck' => $ck,
								 'p'=>$p,
								 'q' => $q,
								 'rincianPerhitungan' => $rincianPerhitungan,
								 'rincianPerhitungan2' => $rincian_perhitungan,
								 'kunci' => $kunci,
								 'volume' => $volume_rek,
								 'bk' => $bk,
								 'ck' => $ck,
								 'hiddenP' => $p,
								 'q' => $q,
								 'satuan' => $satuan,
								 'kodeRekening' => $kodeRekening,
								 'namaRekening' => $namaRekening,
								 'cmbProgram' => $cmbProgram,
								 'cmbKegiatan' => $cmbKegiatan,
								 'cmbPekerjaan' => $cmbPekerjaan,
								 'noUrut' => $noUrut,
								 'hargaSatuan' => $hargaSatuan,
								 'jumlahHarga' => $harga_satuan * $volume_rek,
								 'kodeBarang' => $kodeBarang,
								 'statusAlokasi' => $statusAlokasi,
								 'jenis_alokasi_kas' => $jenis_alokasi_kas
								    );

		break;
		}

		case 'formAlokasi':{
				$dt = $_REQUEST['jumlahHarga'];
				$fm = $this->formAlokasi($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


		break;
		}
		case 'formAlokasiTriwulan':{
				$dt = $_REQUEST['jumlahHarga'];
				$fm = $this->formAlokasiTriwulan($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


		break;
		}

		case 'formRincianVolume':{
				$dt = $_REQUEST['volumeRek'];
				$fm = $this->formRincianVolume($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


		break;
		}

		case 'setSatuanHarga':{
			foreach ($_REQUEST as $key => $value) {
				  		$$key = $value;
					 }

			$get = mysql_fetch_array(mysql_query("select * from ref_std_harga where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' "));

			if($get['standar_satuan_harga'] == NULL){
				$err = "Standar harga tidak di temukan !";
			}

			$content = array('harga' => $get['standar_satuan_harga'] , 'bantu' => "Rp. ".number_format($get['standar_satuan_harga'],0,',','.') );

		break;
		}

		case 'newSatuan':{
				$fm = $this->newSatuan($dt);
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

	 }

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

			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/rka/rkaSKPD1LP_ins.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/popup_rekening/popupRekening.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/popup_rekening/popupRekeningRka.js' language='JavaScript' ></script>



			".

			'
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>
			  <script>
			  $( function() {
			    $( "#tgl_dok" ).datepicker({ dateFormat: "dd-mm-yy" });

				$( "#datepicker2" ).datepicker({ dateFormat: "dd-mm-yy" });
			  } );
			  </script>
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
  	   <th class='th01' width='5'  colspan='1' >No.</th>
	   <th class='th01' width='800' colspan='1'>URAIAN</th>
	   <th class='th01' width='150' colspan='1'>VOLUME</th>
	   <th class='th01' width='150'  colspan='1'>SATUAN</th>
	   <th class='th01' width='150'  colspan='1'>HARGA SATUAN</th>
	   <th class='th01' width='150'  colspan='1'>JUMLAH HARGA</th>
	   <th class='th01' width='100'  colspan='1'>AKSI</th>
	   </tr>
	   </thead>";

		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	foreach ($isi as $key => $value) {
			  $$key = $value;
			}
    $username = $_COOKIE['coID'];
	$Koloms = array();

	$Koloms[] = array('align="center" width="10"', $no );
		if($f != '00' || $rincian_perhitungan != ''){
			$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
			$namaBarang = $getNamaBarang['nm_barang'];
			if($f !='00'){
				$Koloms[] = array(' align="left" ', "<span style='margin-left:5px;' >$namaBarang</span>" );
			}else{
				$Koloms[] = array(' align="left" ', "<span style='margin-left:5px;' >$rincian_perhitungan</span>" );
			}

			$aksi  = "<img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.hapus('$id');></img>&nbsp  &nbsp <img src='images/administrator/images/edit_f2.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.edit('$id');></img>";
			$Koloms[] = array(' align="right"', number_format($volume_rek ,0,',','.') );
			$Koloms[] = array(' align="left"', $satuan );
			$Koloms[] = array(' align="left"', number_format($harga_satuan ,2,',','.') );
			$Koloms[] = array(' align="left"', number_format($jumlah_harga ,2,',','.' ) );
		}else{
			$getNamaPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$o1' "));
			$namaPekerjaan = $getNamaPekerjaan['nama_pekerjaan'];
			$getTotal = mysql_fetch_array(mysql_query("select sum(volume_rek) as volRek, sum(jumlah_harga) as jumlahHarga from temp_rka_21 where o1 ='$o1' and user='$username' and delete_status !='1'"));
			$Koloms[] = array(' align="left" ',  "<span>$namaPekerjaan</span>" );
			$Koloms[] = array(' align="right"', number_format($getTotal['volRek'] ,0,',','.') );
			$Koloms[] = array(' align="left"', '' );
			$Koloms[] = array(' align="left"', '' );
			$Koloms[] = array(' align="left"', number_format($getTotal['jumlahHarga'] ,2,',','.' ) );
		}





	$Koloms[] = array(' align="center"', $aksi );

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

		$cbid = $_REQUEST['rkbmd_cb'];
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
					<input type='hidden' name='ID_RKA' value='".$_REQUEST['id']."' />
					<input type='hidden' name='concatSKPD' value='".$_REQUEST['skpd']."' />
					<input type='hidden' name='ID_rkbmd' value='".$_REQUEST['ID_rkbmd']."' />".
					"<input type='hidden' name='databaru' id='databaru' value='".$_REQUEST['YN']."' />".
					"<input type='hidden' name='idubah' id='idubah' value='".$cbid[0]."' />".

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
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

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

	function formAlokasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';
	 $jumlahHargaForm = $dt;
	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );

	 $username = $_COOKIE['coID'];
	 $getAlokasi = mysql_fetch_array(mysql_query("select * from temp_alokasi_rka_21_v2 where user='$username'"));
	 foreach ($getAlokasi as $key => $value) {
				  $$key = $value;
			}
	 $jenisAlokasi = $jenis_alokasi_kas;
	 $resultPenjumlahan = $jan + $feb + $mar + $apr + $mei + $jun + $jul + $agu + $sep + $okt + $nop + $des;
	 $selisih = $jumlahHargaForm - $resultPenjumlahan;
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


	 if($jenisAlokasi == "TRIWULAN"){
	 	$readOnly = "readOnly";
	 }
	 $cmbJenisAlokasi = cmbArray('jenisAlokasi','BULANAN',$arrayJenisAlokasi,'-- JENIS ALOKASI --',"onchange=$this->Prefix.jenisAlokasiChanged();") ;
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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi();' title='Simpan' >   ".
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
	 $jumlahHargaForm = $dt;
	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );

	 $username = $_COOKIE['coID'];
	 $getAlokasi = mysql_fetch_array(mysql_query("select * from temp_alokasi_rka_21_v2 where user='$username'"));
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
	 $cmbJenisAlokasi = cmbArray('jenisAlokasi','TRIWULAN',$arrayJenisAlokasi,'-- JENIS ALOKASI --',"onchange=$this->Prefix.jenisAlokasiChanged();") ;
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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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
	 $getRincianVolume = mysql_fetch_array(mysql_query("select * from temp_rincian_volume_v2 where user ='$username'"));
	 foreach ($getRincianVolume as $key => $value) {
				  $$key = $value;
		}
	//  $codeAndSatuanSatuan = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='satuan'";
	//  $cmbSatuanSatuan1 = cmbQuery('satuanSatuan1',$satuan1,$codeAndSatuanSatuan,'','-- SATUAN --');
	 //
	//  $codeAndSatuanSatuan = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='satuan'";
	//  $cmbSatuanSatuan2 = cmbQuery('satuanSatuan2',$satuan2,$codeAndSatuanSatuan,'','-- SATUAN --');
	 //
	//  $codeAndSatuanSatuan = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='satuan'";
	//  $cmbSatuanSatuan3 = cmbQuery('satuanSatuan3',$satuan3,$codeAndSatuanSatuan,'','-- SATUAN --');
	 //
	//  $codeAndSatuanVolume = "select satuan_rekening, satuan_rekening  from ref_satuan_rekening where type='volume'";
	//  $cmbSatuanVolume = cmbQuery('satuanVolume',$satuan_total,$codeAndSatuanVolume,'','-- SATUAN --');

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
						'value'=>"<input type='hidden' id='volumeRek' value='$dt'> JUMLAH 1 &nbsp<input type='text' id='jumlah1' value='$jumlah1' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder='JUMLAH'> &nbsp SATUAN 1   &nbsp&nbsp&nbsp&nbsp&nbsp  <input type='text' name ='satuan1' id ='satuan1'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 2 &nbsp<input type='text' id='jumlah2' placeholder='JUMLAH' value='$jumlah2' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp SATUAN 2  &nbsp&nbsp&nbsp&nbsp&nbsp    <input type='text' name ='satuan2' id ='satuan2'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 3 &nbsp<input type='text' id='jumlah3' placeholder='JUMLAH' value='$jumlah3' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp SATUAN 3  &nbsp&nbsp&nbsp&nbsp&nbsp  <input type='text' name ='satuan3' id ='satuan3'>",
						 ),
		 array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" VOLUME &nbsp &nbsp<input type='text' value='$totalResult' placeholder='JUMLAH' id='jumlah4' readonly >&nbsp SATUAN VOL &nbsp <input type='text' name ='satuanVolume' id ='satuanVolume' style='width:150px;'  value ='$satuanVolume' readonly> &nbsp &nbsp <span id='detailVolumeRincian'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"URAIAN VOLUME &nbsp <input type='text' value='$rincianVolume' placeholder=''  id='rincianVolumeTemp' style='width:330px;' >",
						 ),


			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveRincianVolume();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function newSatuan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'SATUAN BARU';


	 //items ----------------------
	  $this->form_fields = array(
			'satuan' => array(
						'label'=>'SATUAN',
						'labelWidth'=>130,
						'value'=>"<input type='text' name='namaSatuan' id='namaSatuan' style='width:210px;'>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveSatuan();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function genDaftarOpsi(){
	 global $Ref, $Main, $HTTP_COOKIE_VARS;

	$ID_RKA = $_REQUEST['ID_RKA'];
	$concatSKPD = $_REQUEST['concatSKPD'];
	$concatSKPD = explode('.',$concatSKPD);
	$c1 = $concatSKPD[0];
	$c = $concatSKPD[1];
	$d = $concatSKPD[2];
	$e = $concatSKPD[3];
	$e1 = $concatSKPD[4];
	$selectedC1 = $c1;
	$selectedC = $c;
	$selectedD = $d;

	foreach ($_REQUEST as $key => $value) {
				 	 	$$key = $value;

				 }


	$tujuan = "Simpan()";

	$arrayNameUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 ='$c1' and c='00' and d='00' and e='00' and e1='000'"));
	$namaUrusan = $arrayNameUrusan['nm_skpd'];

	$arrayNameBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 ='$c1' and c='$c' and d='00' and e='00' and e1='000'"));
	$namaBidang = $arrayNameBidang['nm_skpd'];

	$arrayNameSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 ='$c1' and c='$c' and d='$d' and e='00' and e1='000'"));
	$namaSKPD = $arrayNameSKPD['nm_skpd'];



	$arrayNameRincianPerhitungan = mysql_fetch_array(mysql_query("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
	$rincianPerhitungan = $arrayNameRincianPerhitungan['nm_barang'];



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


						)
					)

				),'','','').
						$this->genFilterBarVulnWalker(
				array(
						"					<table>
												<tr>
													<td><table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
											<tbody><tr valign='middle' align='center'>
											<td class='border:none'>
												<b>REKENING</b>
											</td>
											</tr>
											</tbody></table>".
						$this->tabelRekening()
						)
			,'','','').
			genFilterBar(
				array(
				"
				<table id='kalimatRincianBelanja'>
				</table>
						"
			),'','','').
			$this->genFilterBarVulnWalker(
					array(
						"	<table >
								<tr>
									<td><table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
							<tbody><tr valign='middle' align='center'>
							<td class='border:none'>
								<b>RINCIAN REKENING</b> <input type='hidden' name='currentRincianRekening' id = 'currentRincianRekening' >
							</td>
							</tr>
							</tbody></table>"
							.
							$this->tabelRincianBelanja()
						)
			,'','','').
			genFilterBar(
				array(
				"
				<table id='kalimatSubRincianBelanja' cellpadding='0' cellspacing='0' border='0' id='toolbar'>
				</table>
						"
			),'','','').
			$this->genFilterBarVulnWalker(
					array(
							"<table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
							<tbody><tr valign='middle' align='center'>
							<td class='border:none'>
								<b>SUB RINCIAN REKENING</b> <input type='hidden' name='currentRincianBelanja' id = 'currentRincianBelanja' >
							</td>
							</tr>
							</tbody></table>".
							$this->tabelSubRincianBelanja()
						)
			,'','','').


				genFilterBar(
				array(
					$this->isiform(
						array(

							// array(
							// 		'label'=>'KODE REKENING',
							// 		'label-width'=>'200px;',
							// 		'value'=>"<input type='text' name='kodeRekening'  id='kodeRekening' placeholder='KODE' style='width:80px;' value='".$dt['kodeRekening']."' readonly />
							// 			<input type='text' name='namaRekening' id='namaRekening' placeholder='NAMA REKENING' style='width:520px;' readonly value='".$dt['nm_rekening']."' />
							// 			<button type='button' id='findRekening' onclick=$this->Prefix.findRekening('1'); > Cari </button>
							// 		",
							// 	),
							// array(
							// 		'label'=>'RINCIAN PERHITUNGAN',
							// 		'label-width'=>'200px;',
							// 	    'value' => "<input type='hidden' id='kodeBarang' value='$kodeBarang'>   <input style='width:600px;' placeholder='RINCIAN PERHITUNGAN'  type='text' name='rincianPerhitungan' id='rincianPerhitungan'> &nbsp <span id='kolomButtonCariBarang'></span>"

							// 	),
							// array(
							// 		'label'=>'VOLUME',
							// 		'label-width'=>'200px;',
							// 	    'value' => "<input style='width:60px; text-align:right;' placeholder='VOLUME' $readonly type='text' name='volumeBarang' id='volumeBarang' value='$volumeBarang' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.resetRincian();'>  &nbsp  $pemicu
							// 					"

							// 	),
							// array(
							// 		'label'=>'SATUAN',
							// 		'label-width'=>'200px;',
							// 		'value'=>$cmbSatuan."&nbsp <button type='button' onclick='$this->Prefix.newSatuan();'>Baru</button>
							// 		",
							// 	),
							// array(
							// 		'label'=>'HARGA SATUAN',
							// 		'label-width'=>'200px;',
							// 		'value'=> "<input style='width:200px;' placeholder='HARGA SATUAN' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' > <input type='hidden' id='teralokasi'> &nbsp <button type='button' onclick='$this->Prefix.setSatuanHarga();'>SSH</button> &nbsp <span id='bantuSatuanHarga' style='color:red;'></span>"

							// 	),
							// array(
							// 		'label'=>'JUMLAH HARGA',
							// 		'label-width'=>'200px;',
							// 		'value'=> "<input style='width:200px;' placeholder='JUMLAH HARGA' type='text' name='jumlahHarga' id='jumlahHarga' value='$jumlahHarga' readonly>  &nbsp <span id='bantuJumlahHarga' style='color:red;'></span>"

							// 	),
						)
					)

				),'','','').
				genFilterBar(
					array(
					"
						<input type='hidden' name='".$this->Prefix."_idplh' id='".$this->Prefix."_idplh' value='$idplhnya' />
					<input type='hidden' name='refid_terimanya' id='refid_terimanya' value='".$dt['Id']."' />
					<input type='hidden' name='FMST_penerimaan_det' id='FMST_penerimaan_det' value='".$dt['FMST_penerimaan_det']."' />
					<table>
						<tr>
							<td><table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
					<tbody><tr valign='middle' align='center'>
					<td class='border:none'>
						<a class='toolbar' id='btsave' href='javascript:rkaSKPD1LP_ins.finish()'>
						<img src='images/administrator/images/save_f2.png' alt='BATAL' name='BATAL' width='32' height='32' border='0' align='middle' title='SIMPAN'> SIMPAN</a>
					</td>
					</tr>
					</tbody></table></td>
							<td><table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
					<tbody><tr valign='middle' align='center'>
					<td class='border:none'>
						<a class='toolbar' id='btcancel' href='javascript:rkaSKPD1LP_ins.closeTab()'>
						<img src='images/administrator/images/cancel_f2.png' alt='BATAL' name='BATAL' width='32' height='32' border='0' align='middle' title='SIMPAN'> BATAL</a>
					</td>
					</tr>
					</tbody></table></td>
					<input type='hidden' name='postUrusan' id ='postUrusan' value='$c1'>
					<input type='hidden' name='postBidang' id ='postBidang' value='$c'>
					<input type='hidden' name='postSKPD' id ='postSKPD' value='$d'>
						</tr>".
					"</table>"



				),'','','')

			;


		return array('TampilOpt'=>$TampilOpt);
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



	function tabelRekening(){
		$cek = '';
		$err = '';
		$jml_harga=0;
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_rekening_rka_pendapatan_lp where username = '$this->username' order by k,l,m,n,o ";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "addRekening()";
		$gambar = "datepicker/add-256.png";
		while($dt = mysql_fetch_array($aqry)){
				$id = $dt['id'];

		foreach ($dt as $key => $value) {
					$$key = $value;
		}

			$kodeRekening = $k.".".$l.".".$m.".".$n.".".$o;

			$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
			$namaRekening = $getNamaRekening['nm_rekening'];

			if(strlen($k) > 1){
					$kodeRekening = "x.x.x.xx.xxx";
					$namaRekening = "Belanja XXX";
			}
			$warna = "red";
			$getDataRincianBelanja = mysql_query("select * from temp_rincian_pendapatan_lp where id_rekening_belanja = '$id'");
			while ($dataRincianBelanja = mysql_fetch_array($getDataRincianBelanja)) {
					if(mysql_num_rows(mysql_query("select * from temp_sub_rincian_pendapatan_lp where id_rincian_belanja = '".$dataRincianBelanja['id']."'")) !=0){
							if($statusMerah == ''){
									$warna = "black";
							}
					}else{
						   $warna = "red";
							 $statusMerah = 1;
					}
			}

			$datanya.="

						<tr class='row0'>
							<td class='GarisDaftar' align='center'>$no</a></td>

							<td class='GarisDaftar' align='left'>
								<span style='color:$warna;cursor:pointer;'> $kodeRekening </span>
							</td>
							<td class='GarisDaftar'>
								$namaRekening
							</td>

							<td class='GarisDaftar' align='left'>
								<span id='spanSumberDana'>$sumber_dana</span>
							</td>
							<td class='GarisDaftar' align='center'>
								<input type='button' value='Rincian'  onclick = $this->Prefix.rincianBelanja($id); >
							</td>
							<td class='GarisDaftar' align='center'>
								<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editRekening($id); >
							</td>
						</tr>
			";
			$no = $no+1;
			$warna = "red";
			$statusMerah = "";
		}



		$content =
			"
					<div id='tabelRekening'>
					<table class='koptable'   width= 100% border='1'>
						<tr>
							<th class='th01' width='50px;'>NO</th>
							<th class='th01' width='100px;'>KODE REKENING  </th>
							<th class='th01' width='1000px;'>URAIAN</th>
							<th class='th01' width='150px;'>SUMBER DANA</th>
							<th class='th01' width='50px;'>RINCIAN</th>
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




	function tabelRekeningSelectedRincian($idSelected){
		$cek = '';
		$err = '';
		$jml_harga=0;
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_rekening_rka_pendapatan_lp where username = '$this->username' order by k,l,m,n,o";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "addRekening()";
		$gambar = "datepicker/add-256.png";
		while($dt = mysql_fetch_array($aqry)){
		    $id = $dt['id'];

		foreach ($dt as $key => $value) {
				  $$key = $value;
		}
		$warna = "red";
		$getDataRincianBelanja = mysql_query("select * from temp_rincian_pendapatan_lp where id_rekening_belanja = '$id'");
		while ($dataRincianBelanja = mysql_fetch_array($getDataRincianBelanja)) {
				if(mysql_num_rows(mysql_query("select * from temp_sub_rincian_pendapatan_lp where id_rincian_belanja = '".$dataRincianBelanja['id']."'")) !=0){
					if($statusMerah == ''){
							$warna = "black";
					}
			}else{
					$warna = "red";
					$statusMerah = 1;
			}
		}
			$kodeRekening = $k.".".$l.".".$m.".".$n.".".$o;
			$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
			$namaRekening = $getNamaRekening['nm_rekening'];
			if(strlen($k) > 1){
					$kodeRekening = "x.x.x.xx.xxx";
					$namaRekening = "Belanja XXX";
			}
			if($id == $idSelected){
				$datanya.="

							<tr class='row0' style='color:blue;'>
								<td class='GarisDaftar' align='center'>$no</a></td>
								<td class='GarisDaftar' align='left'>
									<span style='cursor:pointer;'> $kodeRekening </span>
								</td>
								<td class='GarisDaftar'>
									$namaRekening
								</td>
								<td class='GarisDaftar' align='left'>
									<span id='spanSumberDana'>$sumber_dana</span>
								</td>
								<td class='GarisDaftar' align='center'>
									<input type='button' value='Rincian'  onclick = $this->Prefix.rincianBelanja($id); >
								</td>
								<td class='GarisDaftar' align='center'>
									<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editRekening($id); >
								</td>
							</tr>
				";
			}else{
					$datanya.="

								<tr class='row0'>
									<td class='GarisDaftar' align='center'>$no</a></td>
									<td class='GarisDaftar' align='left'>
										<span style='color:$warna;cursor:pointer;'> $kodeRekening </span>
									</td>
									<td class='GarisDaftar'>
										$namaRekening
									</td>
									<td class='GarisDaftar' align='left'>
										<span id='spanSumberDana'>$sumber_dana</span>
									</td>
									<td class='GarisDaftar' align='center'>
										<input type='button' value='Rincian'  onclick = $this->Prefix.rincianBelanja($id); >
									</td>
									<td class='GarisDaftar' align='center'>
										<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editRekening($id); >
									</td>
								</tr>
					";

				}
				$no = $no+1;
				$warna = "red";
				$statusMerah = "";
			}




		$content =
			"
					<div id='tabelRekening'>
					<table class='koptable'  style='min-width:900px;' border='1'>
						<tr>
							<th class='th01' width='50px;'>NO</th>
							<th class='th01' width='100px;'>KODE REKENING  </th>
							<th class='th01' width='870px;'>URAIAN</th>
							<th class='th01' width='150px;'>SUMBER DANA</th>
							<th class='th01' width='50px;'>RINCIAN</th>
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




	function addRekening(){
	$cek = '';
	$err = '';
	$jml_harga=0;
	$datanya='';
	$username = $_COOKIE['coID'];
	$refid_terima = addslashes($_REQUEST[$this->Prefix."_idplh"]);
	$qry = "select * from temp_rekening_rka_pendapatan_lp where username = '$this->username' order by k,l,m,n,o ";$cek.=$qry;
	$aqry = mysql_query($qry);
	$no=1;
	$status =$_REQUEST['status'];


	$tujuan = "cancelRekening()";
	$gambar = "datepicker/cancel.png";
	$selectedSumberDana = "APBD";
	$comboBoxSumberDana = cmbQuery('cmbSumberDana', $selectedSumberDana, "select nama, nama from ref_sumber_dana",' '.$cmbRo.'','-- SUMBER DANA --');

	while($dt = mysql_fetch_array($aqry)){
			$id = $dt['id'];
		$codeAndNameJenisPemeliharaan = "select Id, jenis from ref_jenis_pemeliharaan";


		foreach ($dt as $key => $value) {
				$$key = $value;
		}
		$warna = "red";
		$kodeRekening = $k.".".$l.".".$m.".".$n.".".$o;
		$getDataRincianBelanja = mysql_query("select * from temp_rincian_pendapatan_lp where id_rekening_belanja = '$id'");
		while ($dataRincianBelanja = mysql_fetch_array($getDataRincianBelanja)) {
				if(mysql_num_rows(mysql_query("select * from temp_sub_rincian_pendapatan_lp where id_rincian_belanja = '".$dataRincianBelanja['id']."'")) !=0){
						$warna = "black";
				}
		}
		$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
		$namaRekening = $getNamaRekening['nm_rekening'];
		if(strlen($k) > 1){
				$kodeRekening = "x.x.x.xx.xxx";
				$namaRekening = "Belanja XXX";
		}


		$datanya.="

					<tr class='row0'>
						<td class='GarisDaftar' align='center'>$no</a></td>
						<td class='GarisDaftar' align='left'>
							<span style='color:$warna;' >$kodeRekening</span>
						</td>
						<td class='GarisDaftar' >
							$namaRekening
						</td>
						<td class='GarisDaftar' align='left'>
							<span id='spanSumberDana'>$sumber_dana</span>
						</td>
						<td class='GarisDaftar' align='center'>
							<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editRekening($id); >
						</td>
					</tr>
		";
		$no = $no+1;
	}


	$content ="

				<table class='koptable' style='min-width:900px;' border='1'>
					<tr>
						<th class='th01' width='50px;'>NO</th>
						<th class='th01' width='100px;'>KODE REKENING  </th>
						<th class='th01' width='1400px;'>URAIAN</th>
						<th class='th01' width='150px;'>SUMBER DANA</th>
						<th class='th01' width='50px;'>
							<span id='atasbutton'>
							<a href='javascript:$this->Prefix.cancelRekening()' id='linkAtasButton' /><img id='gambarAtasButton' src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>
							</span>
						</th>
					</tr>
					$datanya

					<tr class='row0'>
						<td class='GarisDaftar' align='center'>$no</a></td>
						<td class='GarisDaftar' align='left'>
							<input type='text' id='kodeRekening' name='kodeRekening' style='width:100px;' readonly > &nbsp <img src='datepicker/search.png'  onclick=$this->Prefix.findRekening(); style='width:20px;height:20px;margin-bottom:-5px; cursor:pointer;'>
						</td>
						<td class='GarisDaftar'>
							<span id='spanNamaRekening'><input type='hidden' id='namaRekening' name ='namaRekening'  > </span>
						</td>
						<td class='GarisDaftar' align='left'>
							<span id='spanSumberDana'>$comboBoxSumberDana</span>
						</td>
						<td class='GarisDaftar' align='center'>
							<img src='datepicker/save.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.saveNewRekening(); >
						</td>
					</tr>


				</table>
				"

	;

	return	$content;
}




	function editRekening($idEdit){
		$cek = '';
		$err = '';
		$jml_harga=0;
		$datanya='';
		$username = $_COOKIE['coID'];
		$refid_terima = addslashes($_REQUEST[$this->Prefix."_idplh"]);
		$qry = "select * from temp_rekening_rka_pendapatan_lp where username = '$this->username' order by k,l,m,n,o ";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];


		$tujuan = "cancelRekening()";
		$gambar = "datepicker/cancel.png";
		$selectedSumberDana = "APBD";


		while($dt = mysql_fetch_array($aqry)){
		    $id = $dt['id'];
			$codeAndNameJenisPemeliharaan = "select Id, jenis from ref_jenis_pemeliharaan";

			foreach ($dt as $key => $value) {
				  $$key = $value;
			}
			$kodeRekening = $k.".".$l.".".$m.".".$n.".".$o;
			$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
			$namaRekening = $getNamaRekening['nm_rekening'];
			if(strlen($k) > 1){
					$kodeRekening = "x.x.x.xx.xxx";
					$namaRekening = "Belanja XXX";
			}
			$warna = "red";
			$getDataRincianBelanja = mysql_query("select * from temp_rincian_pendapatan_lp where id_rekening_belanja = '$id'");
			while ($dataRincianBelanja = mysql_fetch_array($getDataRincianBelanja)) {
					if(mysql_num_rows(mysql_query("select * from temp_sub_rincian_pendapatan_lp where id_rincian_belanja = '".$dataRincianBelanja['id']."'")) !=0){
							if($statusMerah == ''){
									$warna = "black";
							}
					}else{
							$warna = "red";
							$statusMerah = 1;
					}
			}
			if($id == $idEdit){
				 $comboBoxSumberDana = cmbQuery('cmbSumberDana', $sumber_dana, "select nama, nama from ref_sumber_dana",' '.$cmbRo.'','-- SUMBER DANA --');
				$datanya.= "<tr class='row0'>
							<td class='GarisDaftar' align='center'>$no</a></td>
							<td class='GarisDaftar' align='left'>
								<input type='text' id='kodeRekening' style='width:80%;' name='kodeRekening' readonly value='$kodeRekening'> &nbsp <img src='datepicker/search.png'  onclick=$this->Prefix.findRekening(); style='width:20px;height:20px;margin-bottom:-5px; cursor:pointer;'>
							</td>
							<td class='GarisDaftar'>
								<span id='spanNamaRekening'><input type='hidden' id='namaRekening' name ='namaRekening'>$namaRekening</span>
							</td>
							<td class='GarisDaftar' align='left'>
								<span id='spanSumberDana'>$comboBoxSumberDana</span>
							</td>
							<td class='GarisDaftar' align='center'>
								<img src='datepicker/save.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.saveEditRekening($id); > &nbsp <img src='datepicker/remove2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.deleteRekening($id); >
							</td>
						</tr>";
			}else{
				$datanya.="

						<tr class='row0'>
							<td class='GarisDaftar' align='center'>$no</a></td>
							<td class='GarisDaftar' align='left'>
								<span style='color:$warna;'>$kodeRekening</span>
							</td>
							<td class='GarisDaftar'>
								$namaRekening
							</td>
							<td class='GarisDaftar' align='left'>
								<span id='spanSumberDana'>$sumber_dana</span>
							</td>
							<td class='GarisDaftar' align='center'>
								<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editRekening($id); >
							</td>
						</tr>
			";
			}


			$no = $no+1;
			$warna = "red";
		}



		$content ="

					<table class='koptable' style='min-width:900px;' border='1'>
						<tr>
							<th class='th01' width='50px;'>NO</th>
							<th class='th01' width='200px;'>KODE REKENING  </th>
							<th class='th01' width='1000px;'>URAIAN</th>
							<th class='th01' width='150px;'>SUMBER DANA</th>
							<th class='th01' width='100px;'>
								<span id='atasbutton'>
								<a href='javascript:$this->Prefix.$tujuan' id='linkAtasButton' /><img id='gambarAtasButton' src='$gambar' style='width:20px;height:20px;' /></a>
								</span>
							</th>
						</tr>
						$datanya




					</table>
					"

		;

		return	$content;
	}




	function tabelRincianBelanja($idRekeningBelanja){
		$cek = '';
		$err = '';
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_rincian_pendapatan_lp where id_rekening_belanja = '$idRekeningBelanja' and username = '$this->username' order by id ";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "addRincianBelanja()";
		$gambar = "datepicker/add-256.png";
		while($dt = mysql_fetch_array($aqry)){
		    $id = $dt['id'];

		foreach ($dt as $key => $value) {
				  $$key = $value;
		}
			$warna = "red";
			if(mysql_num_rows(mysql_query("select * from temp_sub_rincian_pendapatan_lp where username = '$this->username' and id_rincian_belanja = '$id'")) != 0 ){
				$warna = "black";
			}

			$datanya.="

						<tr class='row0'>
							<td class='GarisDaftar' align='center'>$no</a></td>
							<td class='GarisDaftar' align='left'>
								<span onclick = $this->Prefix.subRincianBelanja($id); style='color:$warna;cursor:pointer;'> $uraian </span>
							</td>
							<td class='GarisDaftar' align='center'><input type='button'  value='SUB RINCIAN' onclick = $this->Prefix.subRincianBelanja($id);> </td>
							<td class='GarisDaftar' align='center'>
								<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editRincianBelanja($id); >
							</td>
						</tr>
			";
			$no = $no+1;
		}



		$content =
			"
					<div id='tabelRincianBelanja'>
					<table class='koptable'  style='min-width:900px;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='1500px;'>URAIAN </th>
							<th class='th01' width='50px;'>SUB RINCIAN</th>
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





	function tabelSubRincianBelanja($idRincianBelanja){
		$cek = '';
		$err = '';
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_sub_rincian_pendapatan_lp where id_rincian_belanja = '$idRincianBelanja' order by urutan_posisi ";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "addSubRincianBelanja()";
		$gambar = "datepicker/add-256.png";
		while($dt = mysql_fetch_array($aqry)){
		    $id = $dt['id'];

		foreach ($dt as $key => $value) {
				  $$key = $value;
		}
			if(!empty($satuan3)){
				$satuanVolume = $satuan1." / "." ".$satuan2." / ".$satuan3;
				$hasilKali = $volume1 * $volume2 * $volume3;
			}elseif(!empty($satuan2)){
				$satuanVolume =$satuan1." / ".$satuan2;
				$hasilKali = $volume1 * $volume2 ;
			}elseif(!empty($satuan1)){
				$satuanVolume = $satuan1;
				$hasilKali = $volume1  ;
			}
			$datanya.="
						<tr class='row0'>
							<td class='GarisDaftar' align='center'>$no</a></td>
							<td class='GarisDaftar' align='left'>
								$uraian
							</td>
							<td class='GarisDaftar' align='right'>
							".number_format($hasilKali,0,',','.')."
							</td>
							<td class='GarisDaftar' align='left'>
								$satuanVolume
							</td>
							<td class='GarisDaftar' align='right'>
							".number_format($harga_satuan,2,',','.')."
							</td>


							<td class='GarisDaftar' align='right'>
								".number_format($hasilKali * $harga_satuan,2,',','.')."
							</td>
							<td class='GarisDaftar' align='center'>
								<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editSubRincianBelanja($id); >
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
							<th class='th01' width='700px;'>URAIAN </th>
							<th class='th01' width='60px;'>VOLUME </th>
							<th class='th01' width='200px;'>SATUAN </th>
							<th class='th01' width='100px;'>HARGA SATUAN </th>
							<th class='th01' width='100px;'>JUMLAH </th>
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



	function addSubRincianBelanja($idRincianBelanja,$idRekeningBelanja){
		$cek = '';
		$err = '';
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_sub_rincian_pendapatan_lp where id_rincian_belanja = '$idRincianBelanja'  order by urutan_posisi ";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "cancelSubRincianBelanja($idRincianBelanja)";
		$gambar = "datepicker/cancel.png";
		while($dt = mysql_fetch_array($aqry)){
		    $id = $dt['id'];

		foreach ($dt as $key => $value) {
				  $$key = $value;
		}

		if(!empty($satuan3)){
			$satuanVolume = $satuan1." / ".$satuan2." / ".$satuan3;
			$hasilKali = $volume1 * $volume2 * $volume3;
		}elseif(!empty($satuan2)){
			$satuanVolume = $satuan1." / ".$satuan2;
			$hasilKali = $volume1 * $volume2 ;
		}elseif(!empty($satuan1)){
			$satuanVolume = $satuan1;
			$hasilKali = $volume1  ;
		}
		$datanya.="
					<tr class='row0'>
						<td class='GarisDaftar' align='center'>$no</a></td>
						<td class='GarisDaftar' align='left'>
							$uraian
						</td>
						<td class='GarisDaftar' align='right'>
						".number_format($hasilKali,0,',','.')."
						</td>
						<td class='GarisDaftar' align='left'>
							$satuanVolume
						</td>
						<td class='GarisDaftar' align='right'>
						".number_format($harga_satuan,2,',','.')."
						</td>
						<td class='GarisDaftar' align='right'>
							".number_format($hasilKali* $harga_satuan,2,',','.')."
						</td>
						<td class='GarisDaftar' align='center'>
							<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editSubRincianBelanja($id); >
						</td>
					</tr>
		";
			$no = $no+1;
		}

		// $getKodeRekening = mysql_fetch_array(mysql_query("select * from temp_rekening_rka_pendapatan_lp where id ='$idRekeningBelanja'"));
		// if($getKodeRekening['k'] == '5' && $getKodeRekening['l'] == '2' && $getKodeRekening['m'] == '3'){
		// 	$findBarangBelanjaModal = "<input type='text' id='uraianBelanja' name='uraianBelanja' readonly style = 'width:450px;'> &nbsp <input type='button' value='Barang'  onclick=$this->Prefix.CariBarang(); style='cursor:pointer;'>  &nbsp <input type='button' value='Atribusi'  onclick=$this->Prefix.atribusi(); style='cursor:pointer;'>";
		// 	$kolomHargaSatuan = "<input style='width:50%;' placeholder='HARGA SATUAN' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' > <input type='hidden' id='teralokasi'> &nbsp <button type='button' onclick='$this->Prefix.setSatuanHarga();'>SSH</button>";// &nbsp <span id='bantuSatuanHarga' style='color:red;'></span>
    //
		// }elseif($getKodeRekening['k'] == '5' && $getKodeRekening['l'] == '2' && $getKodeRekening['m'] == '2'){
		// 	$findBarangBelanjaModal = "<input type='text' id='uraianBelanja' name='uraianBelanja' onkeyUp=$this->Prefix.clearBarang(); style = 'width:530px;'> &nbsp <input type='button' value='Barang'  onclick=$this->Prefix.CariBarang(); style='cursor:pointer;'> ";
		// 	$kolomHargaSatuan = "<input style='width:50%;' placeholder='HARGA SATUAN' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' > <input type='hidden' id='teralokasi'> &nbsp <button type='button' onclick='$this->Prefix.setSatuanHarga();'>SSH</button>";// &nbsp <span id='bantuSatuanHarga' style='color:red;'></span>
    //
		// }else{
		// 	$findBarangBelanjaModal = "<input type='text' id='uraianBelanja' name='uraianBelanja' style = 'width:100%;'>  ";
		// 	$kolomHargaSatuan = "<input style='width:100%;' placeholder='HARGA SATUAN' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' > <input type='hidden' id='teralokasi'>";
		// }

		$content =
			"
					<div id='tabelSubRincianBelanja'>
					<table class='koptable'  style='min-width:900px;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='600px;'>URAIAN </th>
							<th class='th01' width='250px;'>VOLUME </th>
							<th class='th01' width='200px;'>SATUAN </th>
							<th class='th01' width='300px;'>HARGA SATUAN </th>
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
								<input type='hidden' name='namaBarang' id ='namaBarang' >
								<input type='text' id='uraianBelanja' name='uraianBelanja' style = 'width:100%;'>
							</td>
							<td class='GarisDaftar' align='left'>
								<input style='width:30%; readonly text-align:right;' readonly placeholder='VOLUME'  type='text' name='volumeBarang' id='volumeBarang' value='$volumeBarang' onkeypress='return event.charCode >= 48 && event.charCode <= 57' >
								<input type='button' value='Detail Volume' onclick=$this->Prefix.formRincianVolume();>
								<input type='hidden' name='volume1Temp' id='volume1Temp'>
								<input type='hidden' name='volume2Temp' id='volume2Temp'>
								<input type='hidden' name='volume3Temp' id='volume3Temp'>
								<input type='hidden' name='satuan1Temp' id='satuan1Temp'>
								<input type='hidden' name='satuan2Temp' id='satuan2Temp'>
								<input type='hidden' name='satuan3Temp' id='satuan3Temp'>
								<input type='hidden' name ='rincianVolume' id='rincianVolume' >
							</td>
							<td class='GarisDaftar' align='left'>
								<span id='detailVolumeTemp' name='detailVolumeTemp' >
							</td>
							<td class='GarisDaftar' align='left'>
								<input style='width:50%;' placeholder='HARGA SATUAN' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' > <span id='bantuSatuanHarga'>
							</td>
							<td class='GarisDaftar' align='left'>
								<input style='width:100%;' placeholder='JUMLAH HARGA' type='text' name='jumlahHarga' id='jumlahHarga' value='$jumlahHarga' readonly>
							</td>

							<td class='GarisDaftar' align='center'>
								<img src='datepicker/save.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.saveNewSubRincianBelanja(); >
							</td>
						</tr>

					</table>
					</div>
					"
		;

		return	$content;
	}


	function editSubRincianBelanja($idRekeningBelanja,$idRincianBelanja,$idEdit){
		$cek = '';
		$err = '';
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_sub_rincian_pendapatan_lp where id_rincian_belanja = '$idRincianBelanja'  order by urutan_posisi ";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "cancelSubRincianBelanja($idRincianBelanja)";
		$gambar = "datepicker/cancel.png";
		while($dt = mysql_fetch_array($aqry)){
		    $id = $dt['id'];

		foreach ($dt as $key => $value) {
				  $$key = $value;
		}

		if(!empty($satuan3)){
			$satuanVolume = $satuan1." / ".$satuan2." / ".$satuan3;
			$hasilKali = $volume1 * $volume2 * $volume3;
		}elseif(!empty($satuan2)){
			$satuanVolume = $satuan1." / ".$satuan2;
			$hasilKali = $volume1 * $volume2 ;
		}elseif(!empty($satuan1)){
			$satuanVolume = $satuan1;
			$hasilKali = $volume1  ;
		}
		if($id == $idEdit){
			if($j !='000'){
				$statusReadOnly = 'readonly';
			}
			// $getKodeRekening = mysql_fetch_array(mysql_query("select * from temp_rekening_rka_pendapatan_lp where id ='$idRekeningBelanja'"));
			// if($getKodeRekening['k'] == '5' && $getKodeRekening['l'] == '2' && $getKodeRekening['m'] == '3'){
			// 	$findBarangBelanjaModal = "<input type='text' id='uraianBelanja' name='uraianBelanja' value='$uraian' $statusReadOnly style = 'width:450px;'> &nbsp <input type='button' value='Barang'  onclick=$this->Prefix.CariBarang(); style='cursor:pointer;'>  &nbsp <input type='button' value='Atribusi'  onclick=$this->Prefix.atribusi(); style='cursor:pointer;'>";
			// 	$kolomHargaSatuan = "<input style='width:50%;' placeholder='HARGA SATUAN' value='$harga_satuan' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' >  &nbsp <button type='button' onclick='$this->Prefix.setSatuanHarga();'>SSH</button>";// &nbsp <span id='bantuSatuanHarga' style='color:red;'></span>
      //
			// }elseif($getKodeRekening['k'] == '5' && $getKodeRekening['l'] == '2' && $getKodeRekening['m'] == '2'){
			// 	$findBarangBelanjaModal = "<input type='text' id='uraianBelanja' name='uraianBelanja' value='$uraian' onkeyUp=$this->Prefix.clearBarang(); style = 'width:500px;'> &nbsp <input type='button' value='Barang'  onclick=$this->Prefix.CariBarang(); style='cursor:pointer;'> ";
			// 	$kolomHargaSatuan = "<input style='width:50%;' placeholder='HARGA SATUAN' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='hargaSatuan' id='hargaSatuan'  value='$harga_satuan' > <input type='hidden' id='teralokasi'> &nbsp <button type='button' onclick='$this->Prefix.setSatuanHarga();'>SSH</button>";// &nbsp <span id='bantuSatuanHarga' style='color:red;'></span>
      //
			// }else{
			// 	$findBarangBelanjaModal = "<input type='text' id='uraianBelanja' name='uraianBelanja'  style = 'width:100%;' value='$uraian'>  ";
			// 	$kolomHargaSatuan = "<input style='width:100%;' placeholder='HARGA SATUAN' value='$harga_satuan'onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' > ";
			// }


			$jumlahHarga = $hasilKali * $harga_satuan;
			$kodeBarang = $f1.".".$f2.".".$f.".".$g.".".$h.".".$i.".".$j;
			$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j) ='$kodeBarang'"));
			$namaBarang = $getNamaBarang['nm_barang'];
			$datanya.= "<tr class='row0'>
				<td class='GarisDaftar' align='center'>$no</a></td>
				<td class='GarisDaftar' align='left'>
					<input type='hidden' name='kodeBarang' id ='kodeBarang' value='$kodeBarang' >
					<input type='hidden' name='namaBarang' id ='namaBarang' value='$namaBarang'>
					<input type='text' id='uraianBelanja' name='uraianBelanja'  style = 'width:100%;' value='$uraian'>
				</td>
				<td class='GarisDaftar' align='left'>
					<input style='width:40%; readonly text-align:right;' readonly placeholder='VOLUME'  type='text' name='volumeBarang' id='volumeBarang' value='$hasilKali' onkeypress='return event.charCode >= 48 && event.charCode <= 57' >
					<input type='button' value='Detail Volume' onclick=$this->Prefix.formRincianVolume();>
					<input type='hidden' name='volume1Temp' id='volume1Temp' value='$volume1'>
					<input type='hidden' name='volume2Temp' id='volume2Temp' value='$volume2'>
					<input type='hidden' name='volume3Temp' id='volume3Temp' value='$volume3'>
					<input type='hidden' name='satuan1Temp' id='satuan1Temp' value='$satuan1'>
					<input type='hidden' name='satuan2Temp' id='satuan2Temp' value='$satuan2'>
					<input type='hidden' name='satuan3Temp' id='satuan3Temp' value='$satuan3'>
					<input type='hidden' name ='rincianVolume' id='rincianVolume' value='$rincian_volume' >
				</td>
				<td class='GarisDaftar' align='left'>
					$satuanVolume
				</td>
				<td class='GarisDaftar' align='left'>
					<input style='width:50%;' placeholder='HARGA SATUAN' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='$this->Prefix.bantu();' type='text' name='hargaSatuan' id='hargaSatuan' value='".$this->removeKoma($harga_satuan)."' > <span id='bantuSatuanHarga'>
				</td>

				<td class='GarisDaftar' align='left'>
					<input style='width:100%;' placeholder='JUMLAH HARGA' type='text' name='jumlahHarga' id='jumlahHarga' value='".number_format($jumlahHarga,2,',','.')."' readonly>
				</td>

				<td class='GarisDaftar' align='center'>
				<img src='datepicker/save.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.saveEditSubRincianBelanja($idEdit); >
				 &nbsp <img src='datepicker/remove2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.deleteSubRincianBelanja($idEdit); >
				</td>
			</tr>";
		}else{
			$datanya.="
						<tr class='row0'>
							<td class='GarisDaftar' align='center'>$no</a></td>
							<td class='GarisDaftar' align='left'>
								$uraian
							</td>
							<td class='GarisDaftar' align='right'>
							".number_format($hasilKali,0,',','.')."
							</td>
							<td class='GarisDaftar' align='left'>
								$satuanVolume
							</td>
							<td class='GarisDaftar' align='right'>
							".number_format($harga_satuan,2,',','.')."
							</td>
							<td class='GarisDaftar' align='right'>
								".number_format($hasilKali* $harga_satuan,2,',','.')."
							</td>
							<td class='GarisDaftar' align='center'>
								<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editSubRincianBelanja($id); >
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
							<th class='th01' width='600px;'>URAIAN </th>
							<th class='th01' width='250px;'>VOLUME </th>
							<th class='th01' width='200px;'>SATUAN </th>
							<th class='th01' width='300px;'>HARGA SATUAN </th>
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



	function addRincianBelanja($idRekeningBelanja){
		$cek = '';
		$err = '';
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_rincian_pendapatan_lp where id_rekening_belanja = '$idRekeningBelanja' ";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "cancelRincianBelanja($idRekeningBelanja)";
		$gambar = "datepicker/cancel.png";
		while($dt = mysql_fetch_array($aqry)){
		    $id = $dt['id'];

		foreach ($dt as $key => $value) {
				  $$key = $value;
		}
		$warna = "red";
		if(mysql_num_rows(mysql_query("select * from temp_sub_rincian_pendapatan_lp where username = '$this->username' and id_rincian_belanja = '$id'")) != 0 ){
			$warna = "black";
		}
		$datanya.="

					<tr class='row0'>
						<td class='GarisDaftar' align='center'>$no</a></td>
						<td class='GarisDaftar' align='left'>
							<span  style='color:$warna;cursor:pointer;'> $uraian </span>
						</td>
						<td class='GarisDaftar' align='center'>
							<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editRincianBelanja($id); >
						</td>
					</tr>
		";
			$no = $no+1;
		}



		$content =
			"
					<div id='tabelRincianBelanja'>
					<table class='koptable'  style='min-width:900px;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='10000px;'>URAIAN </th>
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
								<input type='text' id='uraianBelanja' name='uraianBelanja' style = 'width:100%;' >
							</td>

							<td class='GarisDaftar' align='center'>
								<img src='datepicker/save.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.saveNewRincianBelanja(); >
							</td>
						</tr>

					</table>
					</div>
					"
		;

		return	$content;
	}



	function editRincianBelanja($idRekeningBelanja,$idEdit){
		$cek = '';
		$err = '';
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_rincian_pendapatan_lp where id_rekening_belanja = '$idRekeningBelanja' and username = '$this->username' order by id ";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "cancelRincianBelanja($idRekeningBelanja)";
		$gambar = "datepicker/cancel.png";
		while($dt = mysql_fetch_array($aqry)){
		    $id = $dt['id'];

		foreach ($dt as $key => $value) {
				  $$key = $value;
		}
		$warna = "red";
		if(mysql_num_rows(mysql_query("select * from temp_sub_rincian_pendapatan_lp where username = '$this->username' and id_rincian_belanja = '$id'")) != 0 ){
			$warna = "black";
		}
			if($id == $idEdit){
				$datanya.="

				<tr class='row0'>
					<td class='GarisDaftar' align='center'>$no</a></td>
					<td class='GarisDaftar' align='left'>
						<input type='text' id='uraianBelanja' name='uraianBelanja' value='$uraian' style = 'width:100%;' >
					</td>

					<td class='GarisDaftar' align='center'>
						<img src='datepicker/save.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.saveEditRincianBelanja($idEdit); >
						 &nbsp <img src='datepicker/remove2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.deleteRincianBelanja($idEdit); >
					</td>
				</tr>
				";
			}else{
				$datanya.="

							<tr class='row0'>
								<td class='GarisDaftar' align='center'>$no</a></td>
								<td class='GarisDaftar' align='left'>
									<span style='color:$warna;cursor:pointer;'> $uraian </span>
								</td>
								<td class='GarisDaftar' align='center'>
									<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editRincianBelanja($id); >
								</td>
							</tr>
				";
			}

			$no = $no+1;
		}



		$content =
			"
					<div id='tabelRincianBelanja'>
					<table class='koptable'  style='min-width:900px;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='1200px;'>URAIAN </th>
							<th class='th01' width='100px;'>
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



	function generateNumber($string){
			if(empty($string) || $string == NULL || $string == ''){
					$string = 0;
			}
			return $string;
	}
	function editData(){
		 foreach ($_REQUEST as $key => $value) {
				$$key = $value;
		 }
		 $execute = mysql_query("select * from temp_sub_rincian_pendapatan_lp  where username ='$this->username' ");
		 while($subRincianBelanja = mysql_fetch_array($execute)){
			 $getRincianBelanja = mysql_fetch_array(mysql_query("select * from temp_rincian_pendapatan_lp where id = '".$subRincianBelanja['id_rincian_belanja']."'"));
			 $getRekeningBelanja = mysql_fetch_array(mysql_query("select * from temp_rekening_rka_pendapatan_lp where id = '".$getRincianBelanja['id_rekening_belanja']."'"));
			 if($getRincianBelanja['id_anggaran'] == ''){
					 if(mysql_num_rows(mysql_query("select * from rincian_belanja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$postUrusan' and c='$postBidang' and d='$postSKPD' and bk='$postBK' and ck='$postCK' and dk='$postDK' and p='$postP' and q='$postQ' and k='".$getRekeningBelanja['k']."' and l='".$getRekeningBelanja['l']."' and m='".$getRekeningBelanja['m']."' and n='".$getRekeningBelanja['n']."' and o='".$getRekeningBelanja['o']."' and sumber_dana = '".$getRekeningBelanja['sumber_dana']."' and nama_rincian_belanja = '".$getRincianBelanja['uraian']."'  ")) == 0){
							 $dataRincianBelanja = array(
										 'tahun' => $this->tahun,
										 'jenis_anggaran' => $this->jenisAnggaran,
										 'c1' => $postUrusan,
										 'c' => $postBidang,
										 'd' => $postSKPD,
										 'bk' => $postBK,
										 'ck' => $postCK,
										 'dk' => $postDK,
										 'p' => $postP,
										 'q' => $postQ,
										 'k' => $getRekeningBelanja['k'],
										 'l' => $getRekeningBelanja['l'],
										 'm' => $getRekeningBelanja['m'],
										 'n' => $getRekeningBelanja['n'],
										 'o' => $getRekeningBelanja['o'],
										 'sumber_dana' => $getRekeningBelanja['sumber_dana'],
										 'nama_rincian_belanja' => $getRincianBelanja['uraian']
							 );
							 mysql_query(VulnWalkerInsert("rincian_belanja",$dataRincianBelanja));
					 }
			 }else{
				 		$dataRincianBelanja = array(
							 'tahun' => $this->tahun,
							 'jenis_anggaran' => $this->jenisAnggaran,
							 'c1' => $postUrusan,
							 'c' => $postBidang,
							 'd' => $postSKPD,
							 'bk' => $postBK,
							 'ck' => $postCK,
							 'dk' => $postDK,
							 'p' => $postP,
							 'q' => $postQ,
							 'k' => $getRekeningBelanja['k'],
							 'l' => $getRekeningBelanja['l'],
							 'm' => $getRekeningBelanja['m'],
							 'n' => $getRekeningBelanja['n'],
							 'o' => $getRekeningBelanja['o'],
							 'sumber_dana' => $getRekeningBelanja['sumber_dana'],
							 'nama_rincian_belanja' => $getRincianBelanja['uraian']
				 );
				 $getIdAwalRincianBelanja = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '".$getRincianBelanja['id_anggaran']."'"));
				 mysql_query(VulnWalkerUpdate("rincian_belanja",$dataRincianBelanja,"id = '".$getIdAwalRincianBelanja['id_rincian_belanja']."'"));
			 }



			 $queryCekRekening = "select * from view_rka_1 where c1='0' and j = '000' and rincian_perhitungan = '' and bk ='".$postBK."' and ck ='".$postCK."' and dk='".$postDK."' and p ='".$postP."' and q='".$postQ."' and k ='".$getRekeningBelanja['k']."' and l ='".$getRekeningBelanja['l']."' and m ='".$getRekeningBelanja['m']."' and n ='".$getRekeningBelanja['n']."' and o ='".$getRekeningBelanja['o']."' and id_rincian_belanja='' and id_tahap='$this->idTahap' ";
			 if($getRekeningBelanja['id_anggaran'] == ''){
					 if(mysql_num_rows(mysql_query($queryCekRekening)) == 0){
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
												 'bk'=> $postBK,
												 'ck'=> $postCK,
												 'dk'=> $postDK,
												 'p' => $postP,
												 'q' => $postQ,
												 'k' => $getRekeningBelanja['k'],
												 'l' => $getRekeningBelanja['l'],
												 'm' => $getRekeningBelanja['m'],
												 'n' => $getRekeningBelanja['n'],
												 'o' => $getRekeningBelanja['o'],
												 'sumber_dana' => $getRekeningBelanja['sumber_dana'],
												 'jenis_rka' => '1',
												 'tahun' => $this->tahun,
												 'jenis_anggaran' => $this->jenisAnggaran,
												 'id_tahap' => $this->idTahap,
												 'nama_modul' => 'RKA-SKPD',
												 'id_rincian_belanja' => ""
													);
						$queryInsertRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
						mysql_query($queryInsertRekening);
					}
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
											'bk'=> $postBK,
											'ck'=> $postCK,
											'dk'=> $postDK,
											'p' => $postP,
											'q' => $postQ,
											'k' => $getRekeningBelanja['k'],
											'l' => $getRekeningBelanja['l'],
											'm' => $getRekeningBelanja['m'],
											'n' => $getRekeningBelanja['n'],
											'o' => $getRekeningBelanja['o'],
											'sumber_dana' => $getRekeningBelanja['sumber_dana'],
											'jenis_rka' => '1',
											'tahun' => $this->tahun,
											'jenis_anggaran' => $this->jenisAnggaran,
											'id_tahap' => $this->idTahap,
											'nama_modul' => 'RKA-SKPD',
											'id_rincian_belanja' => ""
											 );
				 $queryInsertRekening = VulnWalkerUpdate('tabel_anggaran',$arrayRekening,"id_anggaran = '".$getRekeningBelanja['id_anggaran']."'");
				 mysql_query($queryInsertRekening);
			 }

			 $getUplineName = mysql_fetch_array(mysql_query("select * from temp_rincian_pendapatan_lp where id = '".$subRincianBelanja['id_rincian_belanja']."'"));

			 $getIdRincianBelanja = mysql_fetch_array(mysql_query("select * from rincian_belanja where tahun = '$this->tahun' and jenis_anggaran
				='$this->jenisAnggaran' and c1 ='".$postUrusan."' and c ='".$postBidang."' and d ='".$postSKPD."' and bk ='".$postBK."'  and ck ='".$postCK."' and dk ='".$postDK."' and p ='".$postP."' and q='".$postQ."' and k ='".$getRekeningBelanja['k']."' and l ='".$getRekeningBelanja['l']."' and m ='".$getRekeningBelanja['m']."' and n ='".$getRekeningBelanja['n']."' and o ='".$getRekeningBelanja['o']."' and nama_rincian_belanja = '".$getUplineName['uraian']."'  "));

				$queryCekRincianBelaja = "select * from view_rka_1 where c1='$postUrusan' and c = '$postBidang' and d='$postSKPD' and  rincian_perhitungan = '' and bk ='".$postBK."' and ck ='".$postCK."' and dk='".$postDK."' and p ='".$postP."' and q='".$postQ."' and k ='".$getRekeningBelanja['k']."' and l ='".$getRekeningBelanja['l']."' and m ='".$getRekeningBelanja['m']."' and n ='".$getRekeningBelanja['n']."' and o ='".$getRekeningBelanja['o']."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='0' and f2='0' and f='00' and g='00' and h ='00' and i ='00' and j ='000' and id_tahap='$this->idTahap'";
				if(mysql_num_rows(mysql_query($queryCekRincianBelaja)) == 0){
					$arrayRincianBelanja = array(
											 'c1' => $postUrusan,
											 'c' => $postBidang,
											 'd' => $postSKPD,
											 'e' => '00',
											 'e1' => '000',
											 'f1' => '0',
											 'f2' => '0',
											 'f' => '00',
											 'g' => '00',
											 'h' => '00',
											 'i' => '00',
											 'j' => '000',
											 'bk'=> $postBK,
											 'ck'=> $postCK,
											 'dk'=> $postDK,
											 'p' => $postP,
											 'q' => $postQ,
											 'k' => $getRekeningBelanja['k'],
											 'l' => $getRekeningBelanja['l'],
											 'm' => $getRekeningBelanja['m'],
											 'n' => $getRekeningBelanja['n'],
											 'o' => $getRekeningBelanja['o'],
											 'jenis_rka' => '1',
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

				$queryCekSubRincian = "select * from view_rka_1 where c1='$postUrusan' and c = '$postBidang' and d='$postSKPD' and  rincian_perhitungan = '".$subRincianBelanja['uraian']."' and bk ='".$postBK."' and ck ='".$postCK."' and dk='".$postDK."' and p ='".$postP."' and q='".$postQ."' and k ='".$getRekeningBelanja['k']."' and l ='".$getRekeningBelanja['l']."' and m ='".$getRekeningBelanja['m']."' and n ='".$getRekeningBelanja['n']."' and o ='".$getRekeningBelanja['o']."' and id_rincian_belanja = '".$getIdRincianBelanja['id']."'  and f1 ='".$subRincianBelanja['f1']."' and f2='".$subRincianBelanja['f2']."' and f='".$subRincianBelanja['f']."' and g='".$subRincianBelanja['g']."' and h ='".$subRincianBelanja['h']."' and i ='".$subRincianBelanja['i']."' and j ='".$subRincianBelanja['j']."' and id_tahap='$this->idTahap'";
				if($subRincianBelanja['id_anggaran'] == ''){
					if(mysql_num_rows(mysql_query($queryCekSubRincian)) == 0){
						 if($subRincianBelanja['volume3'] != ''){
								 $hasilKaliVolume = $subRincianBelanja['volume1'] * $subRincianBelanja['volume2'] * $subRincianBelanja['volume3'];
								 $satuanTotal = $subRincianBelanja['satuan1']." / ".$subRincianBelanja['satuan2']." / ".$subRincianBelanja['satuan3'];
						 }elseif($subRincianBelanja['volume2'] != ''){
								 $hasilKaliVolume = $subRincianBelanja['volume1'] * $subRincianBelanja['volume2'] ;
								 $satuanTotal = $subRincianBelanja['satuan1']." / ".$subRincianBelanja['satuan2'];
						 }elseif($subRincianBelanja['volume1'] != ''){
								 $hasilKaliVolume = $subRincianBelanja['volume1']  ;
								 $satuanTotal = $subRincianBelanja['satuan1'];
						 }
							$arraySubRincian = array(
													 'c1' => $postUrusan,
													 'c' => $postBidang,
													 'd' => $postSKPD,
													 'e' => '00',
													 'e1' => '000',
													 'f1' => $subRincianBelanja['f1'],
													 'f2' => $subRincianBelanja['f2'],
													 'f' => $subRincianBelanja['f'],
													 'g' => $subRincianBelanja['g'],
													 'h' => $subRincianBelanja['h'],
													 'i' => $subRincianBelanja['i'],
													 'j' => $subRincianBelanja['j'],
													 'bk'=> $postBK,
													 'ck'=> $postCK,
													 'dk'=> $postDK,
													 'p' => $postP,
													 'q' => $postQ,
													 'k' => $getRekeningBelanja['k'],
													 'l' => $getRekeningBelanja['l'],
													 'm' => $getRekeningBelanja['m'],
													 'n' => $getRekeningBelanja['n'],
													 'o' => $getRekeningBelanja['o'],
													 'jenis_rka' => '1',
													 'tahun' => $this->tahun,
													 'jenis_anggaran' => $this->jenisAnggaran,
													 'id_tahap' => $this->idTahap,
													 'nama_modul' => 'RKA-SKPD',
													 'id_rincian_belanja' => $getIdRincianBelanja['id'],
													 'rincian_volume' => $subRincianBelanja['rincian_volume'],
													 'volume_rek' => $hasilKaliVolume,
													 'jumlah' => $subRincianBelanja['harga_satuan'],
													 'jumlah_harga' => $hasilKaliVolume * $subRincianBelanja['harga_satuan'],
													 'rincian_perhitungan' => $subRincianBelanja['uraian'],
													 'jumlah1' => $this->generateNumber($subRincianBelanja['volume1']),
													 'jumlah2' => $this->generateNumber($subRincianBelanja['volume2']),
													 'jumlah3' => $this->generateNumber($subRincianBelanja['volume3']),
													 'satuan1' => $subRincianBelanja['satuan1'],
													 'satuan2' => $subRincianBelanja['satuan2'],
													 'satuan3' => $subRincianBelanja['satuan3'],
													 'satuan_total' => $satuanTotal,
													 'urutan_posisi' => $subRincianBelanja['urutan_posisi']
														);
							$queryInsertSubRincian = VulnWalkerInsert('tabel_anggaran',$arraySubRincian);
							mysql_query($queryInsertSubRincian);
					}
				}else{
						 if($subRincianBelanja['volume3'] != ''){
								 $hasilKaliVolume = $subRincianBelanja['volume1'] * $subRincianBelanja['volume2'] * $subRincianBelanja['volume3'];
								 $satuanTotal = $subRincianBelanja['satuan1']." / ".$subRincianBelanja['satuan2']." / ".$subRincianBelanja['satuan3'];
						 }elseif($subRincianBelanja['volume2'] != ''){
								 $hasilKaliVolume = $subRincianBelanja['volume1'] * $subRincianBelanja['volume2'] ;
								 $satuanTotal = $subRincianBelanja['satuan1']." / ".$subRincianBelanja['satuan2'];
						 }elseif($subRincianBelanja['volume1'] != ''){
								 $hasilKaliVolume = $subRincianBelanja['volume1']  ;
								 $satuanTotal = $subRincianBelanja['satuan1'];
						 }
							$arraySubRincian = array(
													 'c1' => $postUrusan,
													 'c' => $postBidang,
													 'd' => $postSKPD,
													 'e' => '00',
													 'e1' => '000',
													 'f1' => $subRincianBelanja['f1'],
													 'f2' => $subRincianBelanja['f2'],
													 'f' => $subRincianBelanja['f'],
													 'g' => $subRincianBelanja['g'],
													 'h' => $subRincianBelanja['h'],
													 'i' => $subRincianBelanja['i'],
													 'j' => $subRincianBelanja['j'],
													 'bk'=> $postBK,
													 'ck'=> $postCK,
													 'dk'=> $postDK,
													 'p' => $postP,
													 'q' => $postQ,
													 'k' => $getRekeningBelanja['k'],
													 'l' => $getRekeningBelanja['l'],
													 'm' => $getRekeningBelanja['m'],
													 'n' => $getRekeningBelanja['n'],
													 'o' => $getRekeningBelanja['o'],
													 'jenis_rka' => '1',
													 'tahun' => $this->tahun,
													 'jenis_anggaran' => $this->jenisAnggaran,
													 'id_tahap' => $this->idTahap,
													 'nama_modul' => 'RKA-SKPD',
													 'id_rincian_belanja' => $getIdRincianBelanja['id'],
													 'rincian_volume' => $subRincianBelanja['rincian_volume'],
													 'volume_rek' => $hasilKaliVolume,
													 'jumlah' => $subRincianBelanja['harga_satuan'],
													 'jumlah_harga' => $hasilKaliVolume * $subRincianBelanja['harga_satuan'],
													 'rincian_perhitungan' => $subRincianBelanja['uraian'],
													 'jumlah1' => $this->generateNumber($subRincianBelanja['volume1']),
													 'jumlah2' => $this->generateNumber($subRincianBelanja['volume2']),
													 'jumlah3' => $this->generateNumber($subRincianBelanja['volume3']),
													 'satuan1' => $subRincianBelanja['satuan1'],
													 'satuan2' => $subRincianBelanja['satuan2'],
													 'satuan3' => $subRincianBelanja['satuan3'],
													 'satuan_total' => $satuanTotal,
													 'urutan_posisi' => $subRincianBelanja['urutan_posisi']
														);
							$queryInsertSubRincian = VulnWalkerUpdate('tabel_anggaran',$arraySubRincian,"id_anggaran = '".$subRincianBelanja['id_anggaran']."'");
							mysql_query($queryInsertSubRincian);
				}


		 }

	}

	function removeKoma($angka){
			return str_replace(".00","",$angka);
	}

	function tabelRincianBelanjaSelected($idRekeningBelanja,$idSelected){
		$cek = '';
		$err = '';
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from temp_rincian_pendapatan_lp where id_rekening_belanja = '$idRekeningBelanja' and username = '$this->username' order by id ";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		$status =$_REQUEST['status'];
		$tujuan = "addRincianBelanja()";
		$gambar = "datepicker/add-256.png";
		while($dt = mysql_fetch_array($aqry)){
				$id = $dt['id'];

		foreach ($dt as $key => $value) {
					$$key = $value;
		}
		$warna = "red";
		if(mysql_num_rows(mysql_query("select * from temp_sub_rincian_pendapatan_lp where username = '$this->username' and id_rincian_belanja = '$id'")) != 0 ){
			$warna = "black";
		}
			if($id == $idSelected){
				$datanya.="

							<tr class='row0'>
								<td class='GarisDaftar' align='center'>$no</a></td>
								<td class='GarisDaftar' align='left'>
									<span onclick = $this->Prefix.subRincianBelanja($id); style='color:blue;cursor:pointer;'> $uraian </span>
								</td>
								<td class='GarisDaftar' align='center'><input type='button'  value='SUB RINCIAN' onclick = $this->Prefix.subRincianBelanja($id);> </td>
								<td class='GarisDaftar' align='center'>
									<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editRincianBelanja($id); >
								</td>
							</tr>
				";
			}else{
				$datanya.="

							<tr class='row0'>
								<td class='GarisDaftar' align='center'>$no</a></td>
								<td class='GarisDaftar' align='left'>
									<span onclick = $this->Prefix.subRincianBelanja($id); style='color:$warna;cursor:pointer;'> $uraian </span>
								</td>
								<td class='GarisDaftar' align='center'><input type='button'  value='SUB RINCIAN' onclick = $this->Prefix.subRincianBelanja($id);></td>
								<td class='GarisDaftar' align='center'>
									<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= $this->Prefix.editRincianBelanja($id); >
								</td>
							</tr>
				";
			}

			$no = $no+1;
		}



		$content =
			"
					<div id='tabelRincianBelanja'>
					<table class='koptable'  style='min-width:900px;' border='1'>
						<tr>
							<th class='th01' width='25px;'>NO</th>
							<th class='th01' width='1500px;'>URAIAN </th>
							<th class='th01' width='50px;'>SUB RINCIAN</th>
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







}
$rkaSKPD1LP_ins = new rkaSKPD1LP_insObj();

$arrayResult = VulnWalkerTahap_v2('RKA');
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$rkaSKPD1LP_ins->jenisForm = $jenisForm;
$rkaSKPD1LP_ins->nomorUrut = $nomorUrut;
$rkaSKPD1LP_ins->tahun = $tahun;
$rkaSKPD1LP_ins->jenisAnggaran = $jenisAnggaran;
$rkaSKPD1LP_ins->idTahap = $idTahap;
$rkaSKPD1LP_ins->username = $_COOKIE['coID'];

?>
