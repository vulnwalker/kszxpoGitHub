<?php

class rkbmdPemeliharaanPerubahan_v3Obj  extends DaftarObj2{
	var $Prefix = 'rkbmdPemeliharaanPerubahan_v3';
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
	var $PageTitle = 'RKBMD PEMELIHARAAN KUASA PENGGUNA BARANG';
	var $PageIcon = 'images/perencanaan_ico.png';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'Daftar Standar Kebutuhan Barang Maksimal';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '33cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'rkbmdPemeliharaanPerubahan_v3Form';
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
	var $reportURL8 = "pages.php?Pg=rkbmdPemeliharaanPerubahan_v3&tipe=Pemeliharaan8";
	var $reportURL9 = "pages.php?Pg=rkbmdPemeliharaanPerubahan_v3&tipe=Pemeliharaan9";
	var $reportURL10 = "pages.php?Pg=rkbmdPemeliharaanPerubahan_v3&tipe=Pemeliharaan10";

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

	var $settingAnggaran = "";

	var $kondisiBarang = " and f!='06' and f!='07' and f!='08'";
	//untuk view
	function setTitle(){

		return "RKBMD $this->jenisAnggaran PEMELIHARAAN KUASA PENGGUNA BARANG";
	}
	function setPage_Header($IconPage='', $TitlePage=''){

		return createHeaderPage($this->PageIcon, "RKBMD $this->jenisAnggaran PEMELIHARAAN TAHUN $this->tahun");
	}
	function setMenuEdit(){
			if ($this->jenisForm == "PENYUSUNAN"){
			 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".InputBaru()","sections.png","Baru ", 'Baru ')."</td>".
							"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
							"<td>".genPanelIcon("javascript:".$this->Prefix.".remove()","delete_f2.png","Hapus", 'Hapus')."</td>
							<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
				 if($this->settingAnggaran == "MURNI"){
					$listMenu =

					"<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
				}
			 }elseif ($this->jenisForm == "VALIDASI"){
			 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Validasi()","validasi-menu.png","Validasi", 'Validasi')."</td>
				<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
			 }elseif ($this->jenisForm == "KOREKSI PENGGUNA"){
			 $listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
		     }elseif ($this->jenisForm == "KOREKSI PENGELOLA"){
			 $listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
		     }else{
		 	 $listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
			 }
		 	 $listMenu .=  "<td>".genPanelIcon("javascript:".$this->Prefix.".excel()","export_xls.png","Excell", 'Excell')."</td>";

		 return $listMenu;
	}
	function setPage_HeaderOther(){
   		return
		"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
		<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=renjaAset\" title='MURNI'  > MURNI </a> |
		<A href=\"pages.php?Pg=renjaAsetPerubahan\" title='PERUBAHAN' style='color : blue;'> PERUBAHAN </a>

		&nbsp&nbsp&nbsp
		</td></tr>
		<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=renjaAsetPerubahan\" title='RENJA'  > RENJA </a> |
		<A href=\"pages.php?Pg=rkbmdPemeliharaanPerubahan_v3\" title='RKBMD'  style='color : blue;' > RKBMD </a> |
		<A href=\"pages.php?Pg=koreksiPengelolaPemeliharaanPerubahan\" title='RKBMD PENGELOLA' > RKBMD PENGELOLA </a>

		&nbsp&nbsp&nbsp
		</td></tr>

		<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=rkbmdPengadaanPerubahan_v3\" title='RKBMD'  > PENGADAAN </a> |
		<A href=\"pages.php?Pg=rkbmdPemeliharaanPerubahan_v3\" title='RKBMD PENGELOLA' style='color : blue;'  > PEMELIHARAAN </a> |
		<A href=\"pages.php?Pg=rkbmdPersediaanPerubahan_v3\" title='RKBMD PERSEDIAAN' > PERSEDIAAN </a>

		&nbsp&nbsp&nbsp
		</td></tr>

		<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=rkbmdPemeliharaanPerubahan_v3\" title='RKBMD'  style='color : blue;' > INPUT </a> |
		<A href=\"pages.php?Pg=koreksiPenggunaPemeliharaanPerubahan\" title='RKBMD PENGELOLA' > KOREKSI </a>

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
	 if($kodeBarang == '')$err='Barang Belum Di Pilih';

	 if(empty($jumlah))$err="Isi Jumlah";
	 $arrayKodeBarang = explode(".",$kodeBarang);
	 $f  = $arrayKodeBarang[0];
	 $g  = $arrayKodeBarang[1];
	 $h  = $arrayKodeBarang[2];
	 $i  = $arrayKodeBarang[3];
	 $j  = $arrayKodeBarang[4];

			if($fmST == 0){
				 if(empty($cmbUrusanForm) || empty($cmbBidangForm) || empty($cmbSKPDForm) || empty($cmbUnitForm) || empty($cmbSubUnitForm))$err="Lengkapi SKPD";
				if($err==''){
						$data = array ('c1' => $cmbUrusanForm,
									   'c' => $cmbBidangForm,
									   'd' => $cmbSKPDForm,
									   'e' => $cmbUnitForm,
									   'e1' => $cmbSubUnitForm,
									   'f' => $f,
									   'g' => $g,
									   'h' => $h,
									   'i' => $i,
									   'j' => $j,
									   'jumlah' => $jumlah
									   );
						 $cek .= VulnWalkerInsert("ref_std_kebutuhan",$data);
						$input =  mysql_query(VulnWalkerInsert("ref_std_kebutuhan",$data));
						if($input){

						}else{
							$err="Gagal Simpan";
						}

				}
			}elseif($fmST == 1){
			 			$data= array('jumlah' => $jumlah);
						$cek .= VulnWalkerUpdate("ref_std_kebutuhan",$data,"concat(c1,' ',c,' ',d,' ',e,' ',e1,' ',f,' ',g,' ',h,' ',i,' ',j) = '$idplh'");
						mysql_query(VulnWalkerUpdate("ref_std_kebutuhan",$data,"concat(c1,' ',c,' ',d,' ',e,' ',e1,' ',f,' ',g,' ',h,' ',i,' ',j) = '$idplh'"));

			}else{
			/*if($err==''){
						$kode_barang = explode(' ',$idplh);
						 $f=$kode_barang[0];
						 $g=$kode_barang[1];
						 $h=$kode_barang[2];
						 $i=$kode_barang[3];
						 $j=$kode_barang[4];

						$aqry1 = "INSERT into ref_hargabarang_persediaan (f,g,h,i,j,tahun_anggaran,harga)
						"."values('$f','$g','$h','$i','$j','$tahun_anggaran','$harga')";	$cek .= $aqry1;
						$qry = mysql_query($aqry1);

				}*/
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
	  	case 'koreksiAlasanPerubahan':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
			$getrkbmdPemeliharaanPerubahan_v3nya = mysql_fetch_array(mysql_query($queryRows));
			foreach ($getrkbmdPemeliharaanPerubahan_v3nya as $key => $value) {
				  $$key = $value;
			}
			  $kodeBarang =$f.".".$g.".".$h.".".$i.".".$j ;
			  $kodeSKPD = $c1.".".$c.".".$d.".".$e.".".$e1;
			  $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
			  $concat = $kodeSKPD.".".$kodeBarang;


				  $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' "));
				  $jumlahOptimal = $getKebutuhanOptimal['kebutuhanOptimal'];

				  $nextNomorUrut = $this->nomorUrut + 1;
			   	  $getID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					    $idnya = $getID['id_anggaran'];
						if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$nextNomorUrut' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan'")) != 0){
							$err = "Data Yang Telah Disetujui Pengguna Barang Tidak Dapat Diubah";
						}elseif($angkaKoreksi <= $jumlahOptimal || empty($jumlahOptimal)   ){
							mysql_query("update tabel_anggaran set volume_barang = '$angkaKoreksi' , alasan_perubahan = '$alasanPerubahan'  where id_anggaran='$idnya'");
						}else{
							$err = "Tidak dapat melebihi jumlah optimal";
						}
		break;
	    }

		case 'formBaru':{
			$fm = $this->setFormBaru();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'excel':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 if($rkbmdPengadaan_v2SkpdfmUrusan =='0'){
			 	$err = "Pilih Urusan";
			 }elseif($rkbmdPengadaan_v2SkpdfmSKPD =='00'){
			 	$err = "Pilih Bidang";
			 }elseif($rkbmdPengadaan_v2SkpdfmUNIT =='00'){
			 	$err = "Pilih SKPD";
			 }elseif($rkbmdPengadaan_v2SkpdfmSUBUNIT =='00'){
			 	$err = "Pilih Unit";
			 }elseif($rkbmdPengadaan_v2SkpdfmSEKSI =='000'){
			 	$err = "Pilih Sub Unit";
			 }else{
			 	$fm = $this->excel($_REQUEST);
						$cek .= $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
			}

			break;

		}
		case 'Laporan':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 if($rkbmdPemeliharaanPerubahan_v3SkpdfmUrusan =='0'){
			 	$err = "Pilih Urusan";
			 }elseif($rkbmdPemeliharaanPerubahan_v3SkpdfmSKPD =='00'){
			 	$err = "Pilih Bidang";
			 }elseif($rkbmdPemeliharaanPerubahan_v3SkpdfmUNIT =='00'){
			 	$err = "Pilih SKPD";
			 }elseif($rkbmdPemeliharaanPerubahan_v3SkpdfmSUBUNIT =='00'){
			 	$err = "Pilih Unit";
			 }elseif($rkbmdPemeliharaanPerubahan_v3SkpdfmSEKSI =='000'){
			 	$err = "Pilih Sub Unit";
			 }else{
			 	$fm = $this->Laporan($_REQUEST);
						$cek .= $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
			 }

			break;

		}


		case 'Report':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

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
			$content= array('to' => $jenisKegiatan);
		break;
		}
		case 'Pemeliharaan8':{
			$json = FALSE;
			$this->Pemeliharaan8();
		break;
		}
		case 'Pemeliharaan9':{
			$json = FALSE;
			$this->Pemeliharaan9();
		break;
		}

		case 'Pemeliharaan10':{
			$json = FALSE;
			$this->Pemeliharaan10();
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
			 $cmbCaraPemenuhan = cmbQuery('pemenuhan'.$id, $pemenuhan, $caraPemenuhan,' ','-- CARA PEMENUHAN --');
			 $content = array('caraPemenuhan' => $cmbCaraPemenuhan ,'tambahCaraPemenuhan' => "<img style='margin-top: 3px;cursor:pointer;' src='datepicker/add-button-md.png' width='20px' heigh='20px'  onclick='$this->Prefix.formPemenuhan($id);'></img>" );



		break;
		}
		case 'newTab':{
			 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 $nomorUrutSebelumnya = $this->nomorUrut - 1;
			 $cekKeberadaanMangkluk =  mysql_num_rows(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$rkbmdPemeliharaanPerubahan_v3SkpdfmUrusan' and c = '$rkbmdPemeliharaanPerubahan_v3SkpdfmSKPD' and d='$rkbmdPemeliharaanPerubahan_v3SkpdfmUNIT' and e = '$rkbmdPemeliharaanPerubahan_v3SkpdfmSUBUNIT' and e1='$rkbmdPemeliharaanPerubahan_v3SkpdfmSEKSI'  and q!='0' and no_urut ='$nomorUrutSebelumnya' "));
			 $getDatarenja = mysql_fetch_array(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$rkbmdPemeliharaanPerubahan_v3SkpdfmUrusan' and c = '$rkbmdPemeliharaanPerubahan_v3SkpdfmSKPD' and d='$rkbmdPemeliharaanPerubahan_v3SkpdfmUNIT' and e = '$rkbmdPemeliharaanPerubahan_v3SkpdfmSUBUNIT' and e1='$rkbmdPemeliharaanPerubahan_v3SkpdfmSEKSI' and q!='0' and no_urut = '$nomorUrutSebelumnya'"));
			 $lastID = $getDatarenja['id_anggaran'];
			 $parentC1 = $rkbmdPemeliharaanPerubahan_v3SkpdfmUrusan;
		     $parentC = $rkbmdPemeliharaanPerubahan_v3SkpdfmSKPD;
			 $parentD = $rkbmdPemeliharaanPerubahan_v3SkpdfmUNIT;
			 $parentE = $rkbmdPemeliharaanPerubahan_v3SkpdfmSUBUNIT;
			 $parentE1= $rkbmdPemeliharaanPerubahan_v3SkpdfmSEKSI;
			 if($cekKeberadaanMangkluk == 0){
			 	 $cekKeberadaanMangkluk =  mysql_num_rows(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$rkbmdPemeliharaanPerubahan_v3SkpdfmUrusan' and c = '$rkbmdPemeliharaanPerubahan_v3SkpdfmSKPD' and d='$rkbmdPemeliharaanPerubahan_v3SkpdfmUNIT' and e = '00' and e1='000'  and q!='0' and no_urut ='$nomorUrutSebelumnya' "));
				 $getDatarenja = mysql_fetch_array(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$rkbmdPemeliharaanPerubahan_v3SkpdfmUrusan' and c = '$rkbmdPemeliharaanPerubahan_v3SkpdfmSKPD' and d='$rkbmdPemeliharaanPerubahan_v3SkpdfmUNIT' and e = '00' and e1='000' and q!='0' and no_urut = '$nomorUrutSebelumnya'"));
				 $lastID = $getDatarenja['id_anggaran'];
				 $parentE = '00';
			 	 $parentE1= '000';
			 }

			 	if($cekKeberadaanMangkluk != 0){
					if($getDatarenja['jenis_form_modul']  == 'PENYUSUNAN' && $this->wajibValidasi == TRUE ){
						$getJumlahRenjaValidasi = mysql_num_rows(mysql_query("select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$rkbmdPemeliharaanPerubahan_v3SkpdfmUrusan' and c = '$rkbmdPemeliharaanPerubahan_v3SkpdfmSKPD' and d='$rkbmdPemeliharaanPerubahan_v3SkpdfmUNIT' and e = '$parentE' and e1='$parentE1' and q!='0' $this->sqlValidasi and no_urut = '$nomorUrutSebelumnya'"));
						if($getJumlahRenjaValidasi == 0){
							$err = "Renja Belum Di Validasi";
						}
					}

					$getParentrkbmdPemeliharaanPerubahan_v3 = mysql_fetch_array(mysql_query("select * from view_renja where id_anggaran = '$lastID'"));

					$getIdRenja = mysql_fetch_array(mysql_query("select * from view_renja where tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$parentC1' and c = '$parentC' and d = '$parentD' and e = '$parentE' and e1 = '$parentE1' and p != '0' and q != '0' and no_urut = '$nomorUrutSebelumnya' "));
					$idrenja = $getIdRenja['id_anggaran'];

					$kemana = 'pemeliharaan_v3';
					$username = $_COOKIE['coID'];
					mysql_query("delete from temp_rkbmd_pemeliharaan where user = '$username'");
					mysql_query("delete from temp_rkbmd_pemeliharaan where user = '$username'");
					mysql_query("delete from rkbmd_pemeliharaan where user = '$username'");
				}else{
					$err  = "Renja Belum ada atau belum di Koreksi";

				}


				$content = array('idrenja' => $idrenja, "kemana" =>$kemana);
			break;
		}
		case 'editTab':{
			 $id = $_REQUEST['rkbmdPemeliharaanPerubahan_v3_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
					$nomorUrutSebelumnya = $this->nomorUrut - 1;
					$getParentrkbmdPemeliharaanPerubahan_v3 = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran = '$id[0]'"));
					foreach ($getParentrkbmdPemeliharaanPerubahan_v3 as $key => $value) {
				 		 $$key = $value;
					 }
					$parentC1 = $getParentrkbmdPemeliharaanPerubahan_v3['c1'];
					$parentC = $getParentrkbmdPemeliharaanPerubahan_v3['c'];
					$parentD = $getParentrkbmdPemeliharaanPerubahan_v3['d'];
					$parentE = $getParentrkbmdPemeliharaanPerubahan_v3['e'];
					$parentE1= $getParentrkbmdPemeliharaanPerubahan_v3['e1'];
					$getIdRenja = mysql_fetch_array(mysql_query("select * from view_renja where tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$parentC1' and c = '$parentC' and d = '$parentD' and e = '$parentD' and e1 = '$parentE1' and p = '0' and q = '0' and no_urut = '$nomorUrutSebelumnya' "));
					$idrenja = $getIdRenja['id_anggaran'];
					if($idrenja == 0){
						$parentE = '00';
						$parentE1= '000';
						$getIdRenja = mysql_fetch_array(mysql_query("select * from view_renja where tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 = '$parentC1' and c = '$parentC' and d = '$parentD' and e = '$parentE' and e1 = '$parentE1' and p = '0' and q = '0' and no_urut = '$nomorUrutSebelumnya' "));
						$idrenja = $getIdRenja['id_anggaran'];
					}
					$kemana = 'pemeliharaan_v3';

					$username = $_COOKIE['coID'];
					mysql_query("delete from temp_rkbmd_pengadaan where user = '$username'");
					mysql_query("delete from temp_rkbmd_pemeliharaan where user = '$username'");
					mysql_query("delete from rkbmd_pemeliharaan where user = '$username'");


					$nextUrut = $this->nomorUrut + 1;
					$arrayExcept = array();
					$grabExceptID = mysql_query("select * from view_rkbmd where no_urut = '$nextUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and j!='000' and id_jenis_pemeliharaan !='0' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'");
					while($getKoreksi = mysql_fetch_array($grabExceptID)){
						foreach ($getKoreksi as $key => $value) {
					 			 $$key = $value;
						 }
						 $getIDawal = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_tahap = '$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and $q='$q' and f='$f' and g='$g' and h = '$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan'"));
						 $arrayExcept[] = "id_anggaran !='".$getIDawal['id_anggaran']."'";
					}
					$exceptID= join(' and ',$arrayExcept);
				    $exceptID = $exceptID =='' ? '':' and '.$exceptID;
					foreach ($_REQUEST as $key => $value) {
						  $$key = $value;
					 }
					$execute = mysql_query("select * from view_rkbmd where  c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun='$this->tahun' and id_tahap ='$this->idTahap' and f !='00' and id_jenis_pemeliharaan !='0' $exceptID ");
							while($rows = mysql_fetch_array($execute)){
							foreach ($rows as $key => $value) {
					 			 $$key = $value;
						 	}
							$data = array(
									'c1' => $c1,
									'c' => $c,
									'd' => $d,
									'e' => $e,
									'e1' => $e1,
									'bk' => $bk,
									'ck' => $ck,
									'dk' =>$dk,
									'p' => $p,
									'q' => $q,
									'f' => $f,
									'g' => $g,
									'h' => $h,
									'i' => $i,
									'j' => $j,
									'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
									'keterangan' => $catatan,
									'satuan' => $satuan_barang,
									'uraian_pemeliharaan' => $uraian_pemeliharaan,
									'volume_barang' => $volume_barang,
									'user' => $username
								  );
							if($id_jenis_pemeliharaan != '0'){
							if($status_validasi == '1'){
								//$err = "Data Telah Di Validasi !";
							}else{
							mysql_query(VulnWalkerInsert('rkbmd_pemeliharaan',$data));
							}

							}
						}

					if(mysql_num_rows($execute) == 0){
						$err = "Data sudah dikoreksi oleh pengguna";
					}




				$content = array('idrenja' => $idrenja, "kemana" =>$kemana, "qc" => "select * from view_rkbmd where id_anggaran = '$id[0]'");
			break;
		}
		case 'Validasi':{
				$dt = array();
				$err='';
				$content='';
				$uid = $HTTP_COOKIE_VARS['coID'];

				$cbid = $_REQUEST[$this->Prefix.'_cb'];
				$idplh = $_REQUEST['id_anggaran'];
				$this->form_idplh =$_REQUEST['id_anggaran'];


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
			 $getSKPD = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$rkbmdPemeliharaanPerubahan_v3_idplh'"));
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
			 				'tanggal_validasi' => date("Y-m-d"),
							'id_tahap' => $this->idTahap
			 				);
			 $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$rkbmdPemeliharaanPerubahan_v3_idplh'");
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
			$id = $_REQUEST['rkbmdPemeliharaanPerubahan_v3_cb'];
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
				$nextUrut = $this->nomorUrut + 1;
					$arrayExcept = array();
					$grabExceptID = mysql_query("select * from view_rkbmd where no_urut = '$nextUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and j!='000' and id_jenis_pemeliharaan !='0' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'");
					while($getKoreksi = mysql_fetch_array($grabExceptID)){
						foreach ($getKoreksi as $key => $value) {
					 			 $$key = $value;
						 }
						 $getIDawal = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_tahap = '$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck ='$ck' and dk ='$dk' and p='$p' and $q='$q' and f='$f' and g='$g' and h = '$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan'"));
						 $arrayExcept[] = "id_anggaran !='".$getIDawal['id_anggaran']."'";
					}
					$exceptID= join(' and ',$arrayExcept);
				    $exceptID = $exceptID =='' ? '':' and '.$exceptID;
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
				$get = mysql_query("select * from tabel_anggaran where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun='$this->tahun' and id_tahap ='$this->idTahap' and ((id_jenis_pemeliharaan != '0' and f !='00') or uraian_pemeliharaan = 'RKBMD PEMELIHARAAN') and id_anggaran!='$id[$i]' $exceptID ");
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
			$getrkbmdPemeliharaanPerubahan_v3nya = mysql_fetch_array(mysql_query($queryRows));
			foreach ($getrkbmdPemeliharaanPerubahan_v3nya as $key => $value) {
				  $$key = $value;
			}



			if($this->jenisForm !='KOREKSI PENGGUNA' && $this->jenisForm !='KOREKSI PENGELOLA'){
				$err = "Tahap Koreksi Telah Habis";
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

				$cekKegiatanPemeliharaan = mysql_num_rows(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q= '$q' and  f='00' and id_tahap='$this->idTahap' and uraian_pemeliharaan = 'RKBMD PEMELIHARAAN'"));
				if($cekKegiatanPemeliharaan < 1){
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
								  'uraian_pemeliharaan' => 'RKBMD PEMELIHARAAN'
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
											'f' => $f,
											'g' => $g,
											'h' => $h,
											'i' => $i,
											'j' => $j,
											'cara_pemenuhan' => $caraPemenuhan,
											'volume_barang' => $angkaKoreksi,
											'satuan_barang' => $satuan_barang,
											'id_tahap' => $this->idTahap,
											'nama_modul' => $this->modul,
											'uraian_pemeliharaan' => $uraian_pemeliharaan,
											'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
											'user_update' => $_COOKIE['coID'],
											'tanggal_update' => date('Y-m-d'),
											'catatan' => $catatan


 								);

			  $kodeBarang =$f.".".$g.".".$h.".".$i.".".$j ;
			  $kodeSKPD = $c1.".".$c.".".$d.".".$e.".".$e1;
			  $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
			  $concat = $kodeSKPD.".".$kodeBarang;

				  $getKebutuhanMax = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat'"));
				  $kebutuhanMax = $getKebutuhanMax['jumlah'];
				  $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' "));
				  $jumlahOptimal = $getKebutuhanOptimal['kebutuhanOptimal'];
				  $kebutuhanRiil = $kebutuhanMax - $jumlahOptimal;
				  $melebihi = "Kebutuhan Riil";




			  $cekKoreksi =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
			  if($cekKoreksi > 0 ){
			   	 $getID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					    $idnya = $getID['id_anggaran'];

						if( $getrkbmdPemeliharaanPerubahan_v3nya['volume_barang'] >= $angkaKoreksi ) {
							mysql_query("update tabel_anggaran set volume_barang = '$angkaKoreksi' , cara_pemenuhan = '$caraPemenuhan' where id_anggaran='$idnya'");
						}elseif($getrkbmdPemeliharaanPerubahan_v3nya['volume_barang'] < $angkaKoreksi){
							$err = "Jumlah Koreksi Tidak Melebihi Pengajuan";
						}

			}else{
						if( $getrkbmdPemeliharaanPerubahan_v3nya['volume_barang'] >= $angkaKoreksi )  {
							mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));
						}elseif($getrkbmdPemeliharaanPerubahan_v3nya['volume_barang'] < $angkaKoreksi){
							$err = "Jumlah Koreksi Tidak Melebihi Pengajuan";
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
			$getMaxID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
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
			"

			<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/perencanaan_v3/rkbmd/rkbmdPemeliharaanPerubahan.js' language='JavaScript' ></script>".
			$scriptload;
	}

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
/*		$nomorUrutSebelumnya = $this-> -1;*/
		if($this->jenisForm == "PENYUSUNAN"){
						if($this->wajibValidasi == TRUE){
						$tergantung = "<th class='th01' align='center' rowspan='3' colspan='1' width='200'>VALIDASI</th>	";
					}
					$headerTable =
					 "<thead>
					 <tr>
				  	   $Checkbox
					   <th class='th01' align='center' rowspan='3' colspan='1' width='200'>PROGRAM/KEGIATAN/OUTPUT</th>
				   	   <th class='th02' align='center' rowspan='1' colspan='8' width='200'>BARANG YANG DIPELIHARA</th>
					   <th class='th02' align='center' rowspan='1' colspan='5' width='200'>USULAN KEBUTUHAN PEMELIHARAAN</th>
					   <th class='th01' align='center' rowspan='3' colspan='1' width='100'>AKSI</th>
					   $tergantung
					   </tr>
					   <tr>
					      <th class='th01' align='center' rowspan='2' colspan='1' width='100'>KODE BARANG</th>
						  <th class='th01' align='center' rowspan='2' colspan='1' width='1000'>NAMA BARANG</th>
					      <th class='th01' align='center' rowspan='2' colspan='1' width='50'>JML</th>
						  <th class='th01' align='center' rowspan='2' colspan='1' width='50'>SATUAN</th>
						  <th class='th01' align='center' rowspan='2' colspan='1' width='50'>STATUS BARANG</th>
						  <th class='th02' align='center' rowspan='1' colspan='3' width='50'>KONDISI</th>
						  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JENIS PEMELIHARAAN</th>
						  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>URAIAN PEMELIHARAAN</th>
						  <th class='th02' align='center' rowspan='1' colspan='1' width='50'>SEMULA</th>
						  <th class='th02' align='center' rowspan='1' colspan='2' width='50'>MENJADI</th>
					   </tr>
					   <tr>
					   <th class='th01' align='center' rowspan=1' colspan='1' width='50'>B</th>
					   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>KB</th>
					   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>RB</th>
					   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>JML</th>
					   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>JML</th>
					   <th class='th01' align='center' rowspan='1' colspan='1' width='100'>ALASAN PERUBAHAN</th>
					   </tr>

					   </thead>";

		}elseif($this->jenisForm == "KOREKSI PENGGUNA"){
			$nomorUrutSebelumnya = $this->nomorUrut - 1;
			$getJenisFormSebelumnya = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran = '$this->jenisAnggaran'"));
			$jenisFormSebelumnya = $getJenisFormSebelumnya['jenis_form_modul'];
					$headerTable =
						 "<thead>
						 <tr>
					  	   <th class='th01'  rowspan='3' colspan='1' width='20' >No.</th>
						   <th class='th01' align='center' rowspan='3' colspan='1' width='500'>PROGRAM/KEGIATAN/OUTPUT</th>
					   	   <th class='th02' align='center' rowspan='1' colspan='7' width='200'>BARANG YANG DIPELIHARA</th>
						   <th class='th02' align='center' rowspan='1' colspan='3' width='200'>USULAN KEBUTUHAN PEMELIHARAAN</th>
						   <th class='th01' align='center' rowspan='3' colspan='1' width='200'>KETERANGAN</th>
						   <th class='th02' align='center' rowspan='2' colspan='1' width='200'>DISETUJUI PENGGUNA</th>
					       <th class='th01' align='center' rowspan='3' colspan='1' width='500'>AKSI</th>
						   </tr>
						   <tr>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='500'>NAMA BARANG</th>
						      <th class='th01' align='center' rowspan='2' colspan='1' width='50'>JUMLAH</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>SATUAN</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>STATUS BARANG</th>
							  <th class='th02' align='center' rowspan='1' colspan='3' width='100'>KONDISI</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JENIS PEMELIHARAAN</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>URAIAN PEMELIHARAAN</th>

							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JUMLAH</th>

						   </tr>
						   <tr>
						   <th class='th01' align='center' rowspan=1' colspan='1' width='50'>B</th>
						   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>KB</th>
						   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>RB</th>
						   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>JUMLAH</th>
						   </tr>

						   </thead>";





		}

		elseif($this->jenisForm == "KOREKSI PENGELOLA"){
			$nomorUrutSebelumnya = $this->nomorUrut - 1;
			$getJenisFormSebelumnya = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where no_urut = '$nomorUrutSebelumnya' and tahun ='$this->tahun' and anggaran = '$this->jenisAnggaran'"));
			$jenisFormSebelumnya = $getJenisFormSebelumnya['jenis_form_modul'];

					$headerTable =
						 "<thead>
						 <tr>
					  	   <th class='th01'  rowspan='3' colspan='1' width='20' >No.</th>
						   <th class='th01' align='center' rowspan='3' colspan='1' width='500'>PROGRAM/KEGIATAN/OUTPUT</th>
					   	   <th class='th02' align='center' rowspan='1' colspan='7' width='200'>BARANG YANG DIPELIHARA</th>
						   <th class='th02' align='center' rowspan='1' colspan='3' width='200'>USULAN KEBUTUHAN PEMELIHARAAN</th>
						   <th class='th01' align='center' rowspan='3' colspan='1' width='200'>KETERANGAN</th>
						   <th class='th02' align='center' rowspan='2' colspan='1' width='200'>DISETUJUI PENGGUNA</th>
						   <th class='th02' align='center' rowspan='2' colspan='1' width='200'>DISETUJUI PENGELOLA</th>
					       <th class='th01' align='center' rowspan='3' colspan='1' width='500'>AKSI</th>
						   </tr>
						   <tr>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='600'>NAMA BARANG</th>
						      <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JUMLAH</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>SATUAN</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>STATUS BARANG</th>
							  <th class='th02' align='center' rowspan='1' colspan='3' width='100'>KONDISI</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JENIS PEMELIHARAAN</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>URAIAN PEMELIHARAAN</th>

							  <th class='th01' align='center' rowspan='2' colspan='1'  width='200'>JUMLAH</th>

						   </tr>
						   <tr>
						   <th class='th01' align='center' rowspan=1' colspan='1' width='50'>B</th>
						   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>KB</th>
						   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>RB</th>
						   <th class='th01' align='center' rowspan='1' colspan='1' width='100'>JUMLAH</th>
						   <th class='th01' align='center' rowspan='1' colspan='1' width='200'>JUMLAH</th>
						   </tr>

						   </thead>";




		}
		//KOREKSI PENGGUNA
		//view
		else{
			if($this->jenisFormTerakhir == "PENYUSUNAN"){
					if($this->wajibValidasi == TRUE){
						$tergantung = "<th class='th01' align='center' rowspan='3' colspan='1' width='200'>VALIDASI</th>	";
					}
					$headerTable =
					 "<thead>
					 <tr>
				  	   <th class='th01'  rowspan='3' colspan='1' width='20' >No.</th>
					   <th class='th01' align='center' rowspan='3' colspan='1' width='500'>PROGRAM/KEGIATAN/OUTPUT</th>
				   	   <th class='th02' align='center' rowspan='1' colspan='8' width='200'>BARANG YANG DIPELIHARA</th>
					   <th class='th02' align='center' rowspan='1' colspan='3' width='200'>USULAN KEBUTUHAN PEMELIHARAAN</th>
					   <th class='th01' align='center' rowspan='3' colspan='1' width='200'>KETERANGAN</th>
					   $tergantung
					   </tr>
					   <tr>
					      <th class='th01' align='center' rowspan='2' colspan='1' width='100'>KODE BARANG</th>
						  <th class='th01' align='center' rowspan='2' colspan='1' width='600'>NAMA BARANG</th>
					      <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JUMLAH</th>
						  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>SATUAN</th>
						  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>STATUS BARANG</th>
						  <th class='th02' align='center' rowspan='1' colspan='3' width='100'>KONDISI</th>
						  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JENIS PEMELIHARAAN</th>
						  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>URAIAN PEMELIHARAAN</th>
						  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JUMLAH</th>
					   </tr>
					   <tr>
					   <th class='th01' align='center' rowspan=1' colspan='1' width='50'>B</th>
					   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>KB</th>
					   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>RB</th>
					   </tr>

					   </thead>";

			}elseif($this->jenisFormTerakhir == "KOREKSI PENGGUNA"){
					$headerTable =
						 "<thead>
						 <tr>
					  	   <th class='th01'  rowspan='3' colspan='1' width='20' >No.</th>
						   <th class='th01' align='center' rowspan='3' colspan='1' width='500'>PROGRAM/KEGIATAN/OUTPUT</th>
					   	   <th class='th02' align='center' rowspan='1' colspan='7' width='200'>BARANG YANG DIPELIHARA</th>
						   <th class='th02' align='center' rowspan='1' colspan='3' width='200'>USULAN KEBUTUHAN PEMELIHARAAN</th>
						   <th class='th01' align='center' rowspan='3' colspan='1' width='200'>KETERANGAN</th>
						   <th class='th02' align='center' rowspan='2' colspan='1' width='200'>DISETUJUI PENGGUNA</th>
						   </tr>
						   <tr>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='400'>NAMA BARANG</th>
						      <th class='th01' align='center' rowspan='2' colspan='1' width='50'>JUMLAH</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='50'>SATUAN</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>STATUS BARANG</th>
							  <th class='th02' align='center' rowspan='1' colspan='3' width='100'>KONDISI</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JENIS PEMELIHARAAN</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>URAIAN PEMELIHARAAN</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JUMLAH</th>

						   </tr>
						   <tr>
						   <th class='th01' align='center' rowspan=1' colspan='1' width='50'>B</th>
						   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>KB</th>
						   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>RB</th>
						   <th class='th01' align='center' rowspan='1' colspan='1' width='100'>JUMLAH</th>
						   </tr>

						   </thead>";

			}
			elseif($this->jenisFormTerakhir =="KOREKSI PENGELOLA"){
					$headerTable =
						 "<thead>
						 <tr>
					  	   <th class='th01'  rowspan='3' colspan='1' width='20' >No.</th>
						   <th class='th01' align='center' rowspan='3' colspan='1' width='200'>PROGRAM/KEGIATAN/OUTPUT</th>
					   	   <th class='th02' align='center' rowspan='1' colspan='7' width='200'>BARANG YANG DIPELIHARA</th>
						   <th class='th02' align='center' rowspan='1' colspan='3' width='200'>USULAN KEBUTUHAN PEMELIHARAAN</th>
						   <th class='th01' align='center' rowspan='3' colspan='1' width='200'>KETERANGAN</th>
						   <th class='th02' align='center' rowspan='2' colspan='1' width='200'>DISETUJUI PENGGUNA</th>
						   <th class='th02' align='center' rowspan='2' colspan='1' width='200'>DISETUJUI PENGELOLA</th>
						   </tr>
						   <tr>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='200'>NAMA BARANG</th>
						      <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JUMLAH</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>SATUAN</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>STATUS BARANG</th>
							  <th class='th02' align='center' rowspan='1' colspan='3' width='100'>KONDISI</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JENIS PEMELIHARAAN</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>URAIAN PEMELIHARAAN</th>
							  <th class='th01' align='center' rowspan='2' colspan='1' width='100'>JUMLAH</th>


						   </tr>
						   <tr>
						   <th class='th01' align='center' rowspan=1' colspan='1' width='50'>B</th>
						   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>KB</th>
						   <th class='th01' align='center' rowspan='1' colspan='1' width='50'>RB</th>
						   <th class='th01' align='center' rowspan='1' colspan='1' width='200'>JUMLAH</th>
						   <th class='th01' align='center' rowspan='1' colspan='1'  width='200'>JUMLAH</th>
						   </tr>

						   </thead>";


			}

		}





		return $headerTable;
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


	   if($this->jenisForm=="PENYUSUNAN"){

				if($f == '00' && $q =='0')$TampilCheckBox = "";
			   	  if($p =='0'){
				 	$kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
					$getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
				 	$header = $e1.". ".$getSubUnit['nm_skpd'];
					$style = "style='font-weight:bold;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					//$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= "<td class='$cssclass' align='center'></td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					if($this->wajibValidasi == TRUE)$Koloms.= "<td class='$cssclass' align='left'></td>";
				 }elseif($p!= '0' && $q=='0'){
				 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".'0';
					$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
					$header = genNumber($p).". ".$getNamaPrgoram['nama'];
					$style = "style='margin-left:5px;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					//$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= "<td class='$cssclass' align='center'></td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					if($this->wajibValidasi == TRUE)$Koloms.= "<td class='$cssclass' align='left'></td>";
				 }elseif($f == '00' && $q!='0'){
				 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".$q;
					$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
					$header = genNumber($q).". ".$getNamaPrgoram['nama'];
					$style = "style='margin-left:10px;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					//$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= "<td class='$cssclass' align='center'>$TampilCheckBox</td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					if($this->wajibValidasi == TRUE)$Koloms.= "<td class='$cssclass' align='left'></td>";
				 }else{

					 $tampilHeader = "<td class='$cssclass' align='left' colspan='1'><span $style>".$header."</span></td>";
					 $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
					 $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
					 $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
					 $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
					 $getBarang = mysql_fetch_array(mysql_query($syntax));
					 $namaBarang = $getBarang['nm_barang'];
					 $getJenisPemeliharaan = mysql_fetch_array(mysql_query("select * from ref_jenis_pemeliharaan where Id = '$id_jenis_pemeliharaan'"));
					 $jenisPemeliharaan = $getJenisPemeliharaan['jenis'];
					 $concat = $kodeSKPD.".".$kodeBarang;
					 $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='1' "));
					 $baik = $getKebutuhanOptimal['kebutuhanOptimal'];
					 $getKurangBaik = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='2' "));
					 $kurangBaik = $getKurangBaik['kebutuhanOptimal'];
					 $getRusakBerat = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='3' "));
					 $rusakBerat = $getRusakBerat['kebutuhanOptimal'];
					 $satuan = $getBarang['satuan_barang'];
					 $customConcat = $kodeSKPD.".".$bk.".".$ck.".".$dk.".".$p.".".$q.".".$kodeBarang;
					 $getMinID = mysql_fetch_array(mysql_query("select min(urut) as min from view_rkbmd where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j) ='$customConcat' and id_jenis_pemeliharaan != '0'"));
					 $getSumVolumeBarang = mysql_fetch_array(mysql_query("select sum(volume_barang) as jumlah from view_rkbmd where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j) ='$customConcat' and id_jenis_pemeliharaan != '0' and id_tahap = '$this->idTahap'"));
					 $sumVolume = $getSumVolumeBarang['jumlah'];
					 //$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					 $Koloms.= "<td class='$cssclass' align='center'></td>";
					 $Koloms.= $tampilHeader;
					 if($urut == $getMinID['min']){
					 	$Koloms.= "<td class='$cssclass' align='center'>$kodeBarang</td>";
					 	$Koloms.= "<td class='$cssclass' align='left'>$namaBarang</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($sumVolume,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='left'>$satuan_barang</td>";
					 	$Koloms.= "<td class='$cssclass' align='CENTER'>MILIK</td>";
						$Koloms.= "<td class='$cssclass' align='right'>".number_format($baik,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($kurangBaik,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($rusakBerat,0,',','.')."</td>";
					 }else{
					 	$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
					 }


					 $Koloms.= "<td class='$cssclass' align='left'>$jenisPemeliharaan</td>";
					 $Koloms.= "<td class='$cssclass' align='left'>$uraian_pemeliharaan</td>";
					 $getJumlahSemula = mysql_fetch_array(mysql_query("select * from view_rkbmd where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun='$this->tahun' and jenis_anggaran = 'MURNI' and no_urut = '5' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan'"));
					 $Koloms.= "<td class='$cssclass' align='right'>".number_format($getJumlahSemula['volume_barang'],0,',','.')."<input type='hidden' id='volumeBarang$id_anggaran' value ='".$getJumlahSemula['volume_barang']."'></td>";
					 $Koloms.= "<td class='$cssclass' align='right'><span id='spanJumlahPerubahan$id_anggaran'>".number_format($volume_barang,0,',','.')."</span></td>";
					 $Koloms.= "<td class='$cssclass' align='left'><span id='spanAlasanPerubahan$id_anggaran'>$alasan_perubahan</span></td>";

					// $Koloms.= "<td class='$cssclass' align='left'>$catatan</td>";
					 $aksi  = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.sesuaiAlasanPerubahan('$id_anggaran');></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=$this->Prefix.koreksiAlasanPerubahan('$id_anggaran');></img> ";
					 $Koloms.= "<td class='$cssclass' align='center'><span id='save$id_anggaran'>$aksi</span></td>";
					 if($status_validasi == '1'){
						 	$validnya = "valid.png";
					 }else{
						 	$validnya = "invalid.png";
					 }
					if($this->wajibValidasi == TRUE)$Koloms.= "<td class='$cssclass' align='center'>"."<img src='images/administrator/images/$validnya' width='20px' heigh='20px' style='cursor:pointer;'  onclick=$this->Prefix.Validasi('$id_anggaran');> "."</td>";

				 }

					$Koloms = array(
					 	array("Y", $Koloms),
					 );
	 	 }

	   elseif($this->jenisForm=="KOREKSI PENGGUNA"){
				if($f == '00' && $q =='0')$TampilCheckBox = "";
			   	  if($p =='0'){
				 	$kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
					$getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
				 	$header = $e1.". ".$getSubUnit['nm_skpd'];
					$style = "style='font-weight:bold;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
				 }elseif($p!= '0' && $q=='0'){
				 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".'0';
					$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
					$header = genNumber($p).". ".$getNamaPrgoram['nama'];
					$style = "style='margin-left:5px;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
				 }elseif($f == '00' && $q!='0'){
				 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".$q;
					$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
					$header = genNumber($q).". ".$getNamaPrgoram['nama'];
					$style = "style='margin-left:10px;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";

				 }else{

					 $tampilHeader = "<td class='$cssclass' align='left' colspan='1'><span $style>".$header."</span></td>";
					 $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
					 $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
					 $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
					 $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
					 $getBarang = mysql_fetch_array(mysql_query($syntax));
					 $namaBarang = $getBarang['nm_barang'];
					 $getJenisPemeliharaan = mysql_fetch_array(mysql_query("select * from ref_jenis_pemeliharaan where Id = '$id_jenis_pemeliharaan'"));
					 $jenisPemeliharaan = $getJenisPemeliharaan['jenis'];
					 $concat = $kodeSKPD.".".$kodeBarang;
					 $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='1' "));
					 $baik = $getKebutuhanOptimal['kebutuhanOptimal'];
					 $getKurangBaik = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='2' "));
					 $kurangBaik = $getKurangBaik['kebutuhanOptimal'];
					 $getRusakBerat = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='3' "));
					 $rusakBerat = $getRusakBerat['kebutuhanOptimal'];
					 $satuan = $getBarang['satuan_barang'];
					 $customConcat = $kodeSKPD.".".$bk.".".$ck.".".$dk.".".$p.".".$q.".".$kodeBarang;
					 $nomorUrutSebelumnya = $this->nomorUrut -1 ;
					 $getMinID = mysql_fetch_array(mysql_query("select min(urut) as min from view_rkbmd where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j) ='$customConcat' and id_jenis_pemeliharaan != '0'"));
					 $getSumVolumeBarang = mysql_fetch_array(mysql_query("select sum(volume_barang) as jumlah from view_rkbmd where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j) ='$customConcat' and id_jenis_pemeliharaan != '0' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya'"));
					 $sumVolume = $getSumVolumeBarang['jumlah'];
					 $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					 $Koloms.= $tampilHeader;
					 if($urut == $getMinID['min']){
					 	$Koloms.= "<td class='$cssclass' align='left'>$namaBarang</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($sumVolume,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='left'>$satuan_barang</td>";
					 	$Koloms.= "<td class='$cssclass' align='CENTER'>MILIK</td>";
						$Koloms.= "<td class='$cssclass' align='right'>".number_format($baik,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($kurangBaik,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($rusakBerat,0,',','.')."</td>";
					 }else{
					 	$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
					 }
					 $getDataKoreksi = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "));
					 $kondisiWarna = "red";

						 if(mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "))  > 0){
						 	$jumlahKoreksi = number_format($getDataKoreksi['volume_barang'],0,',','.');
						 	$align = "right";
							$tanggalKoreksi = explode("-",$getDataKoreksi['tanggal_update']);
							$tanggalKoreksi = $tanggalKoreksi[2]."-".$tanggalKoreksi[1]."-".$tanggalKoreksi[0];
							$caraPemenuhan = $getDataKoreksi['cara_pemenuhan'];
							$keteranganKoreksi =  $getDataKoreksi['user_update']."/".$tanggalKoreksi;
							$kondisiWarna = "black";
						 }

					 $Koloms.= "<td class='$cssclass' style='color:$kondisiWarna ;' align='left'>$jenisPemeliharaan</td>";
					 $Koloms.= "<td class='$cssclass' align='left'>$uraian_pemeliharaan</td>";
					 $Koloms.= "<td class='$cssclass' align='right'><input type='hidden' id='volumeBarang$id_anggaran' value='$volume_barang'>".number_format($volume_barang,0,',','.')."</td>";
					 $Koloms.= "<td class='$cssclass' align='left'>$catatan</td>";
					 $Koloms.= "<td class='$cssclass' id='alignKoreksi' align='$align'><span id='spanJumlah$id_anggaran'>$jumlahKoreksi</span> <span style='color:red;' id='bantuJumlah$id_anggaran'><span> </td>";
					 $aksi  = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=rkbmdPemeliharaanPerubahan_v3.sesuai('$id_anggaran');></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=rkbmdPemeliharaanPerubahan_v3.koreksi('$id_anggaran');></img> ";
					 $Koloms.= "<td class='$cssclass'  id='updatePengguna$id_anggaran' align='center'><span id='save$id_anggaran'>$aksi</span></td>";
				 }
					$Koloms = array(
						 	array("Y", $Koloms),
						 );

			}

	   elseif($this->jenisForm=="KOREKSI PENGELOLA"){

					if($f == '00' && $q =='0')$TampilCheckBox = "";
			   	  if($p =='0'){
				 	$kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
					$getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
				 	$header = $e1.". ".$getSubUnit['nm_skpd'];
					$style = "style='font-weight:bold;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";

				 }elseif($p!= '0' && $q=='0'){
				 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".'0';
					$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
					$header = genNumber($p).". ".$getNamaPrgoram['nama'];
					$style = "style='margin-left:5px;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";

				 }elseif($f == '00' && $q!='0'){
				 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".$q;
					$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
					$header = genNumber($q).". ".$getNamaPrgoram['nama'];
					$style = "style='margin-left:10px;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
				 }else{
				 	 $nomorUrutSebelumnya = $this->nomorUrut -1;
					 $tampilHeader = "<td class='$cssclass' align='left' colspan='1'><span $style>".$header."</span></td>";
					 $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
					 $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
					 $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
					 $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
					 $getBarang = mysql_fetch_array(mysql_query($syntax));
					 $namaBarang = $getBarang['nm_barang'];
					 $getJenisPemeliharaan = mysql_fetch_array(mysql_query("select * from ref_jenis_pemeliharaan where Id = '$id_jenis_pemeliharaan'"));
					 $jenisPemeliharaan = $getJenisPemeliharaan['jenis'];
					 $concat = $kodeSKPD.".".$kodeBarang;
					 $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='1' "));
					 $baik = $getKebutuhanOptimal['kebutuhanOptimal'];
					 $getKurangBaik = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='2' "));
					 $kurangBaik = $getKurangBaik['kebutuhanOptimal'];
					 $getRusakBerat = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='3' "));
					 $rusakBerat = $getRusakBerat['kebutuhanOptimal'];
					 $satuan = $getBarang['satuan_barang'];
					 $customConcat = $kodeSKPD.".".$bk.".".$ck.".".$dk.".".$p.".".$q.".".$kodeBarang;
					  $nomorurutkurang2 = $this->nomorUrut - 2;
					 $getMinID = mysql_fetch_array(mysql_query("select min(urut) as min from view_rkbmd where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j) ='$customConcat' and id_jenis_pemeliharaan != '0'"));
					 $getSumVolumeBarang = mysql_fetch_array(mysql_query("select sum(volume_barang) as jumlah from view_rkbmd where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j) ='$customConcat' and id_jenis_pemeliharaan != '0' and tahun = '$this->tahun' and jenis_anggaran='$this->jenisAnggaran' and no_urut = '$nomorurutkurang2'"));
					 $sumVolume = $getSumVolumeBarang['jumlah'];
					 $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					 $Koloms.= $tampilHeader;
					 if($urut == $getMinID['min']){
					 	$Koloms.= "<td class='$cssclass' align='left'>$namaBarang</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($sumVolume,0,',','.')."</td>";
						$Koloms.= "<td class='$cssclass' align='left'>$satuan_barang</td>";
					 	$Koloms.= "<td class='$cssclass' align='CENTER'>MILIK</td>";
						$Koloms.= "<td class='$cssclass' align='right'>".number_format($baik,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($kurangBaik,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($rusakBerat,0,',','.')."</td>";
					 }else{
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
					 }
					 $getDataKoreksi = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "));
					 $kondisiWarna = "red";

						 if(mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "))  > 0){
						 	$jumlahKoreksi = number_format($getDataKoreksi['volume_barang'],0,',','.');
						 	$align = "right";
							$tanggalKoreksi = explode("-",$getDataKoreksi['tanggal_update']);
							$tanggalKoreksi = $tanggalKoreksi[2]."-".$tanggalKoreksi[1]."-".$tanggalKoreksi[0];
							$caraPemenuhan = $getDataKoreksi['cara_pemenuhan'];
							$keteranganKoreksi =  $getDataKoreksi['user_update']."/".$tanggalKoreksi;
							$kondisiWarna = "black";
						 }

					 $Koloms.= "<td class='$cssclass' style='color:$kondisiWarna ;' align='left'>$jenisPemeliharaan</td>";
					 $Koloms.= "<td class='$cssclass' align='left'>$uraian_pemeliharaan</td>";

					 $getJumlahBarangPertama = mysql_fetch_array(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorurutkurang2'"));
					 $jumlahBarangPertama = $getJumlahBarangPertama['volume_barang'];
					 $catatan = $getJumlahBarangPertama['catatan'];
					 $tanggal_update = explode("-",$tanggal_update);
					 $tanggal_update = $tanggal_update[2]."-".$tanggal_update[1]."-".$tanggal_update[0];
					 $Koloms.= "<td class='$cssclass' align='right'>".number_format($jumlahBarangPertama,0,',','.')."</td>";
					 $Koloms.= "<td class='$cssclass' align='left'>$catatan</td>";
					 $Koloms.= "<td class='$cssclass' align='right'><input type='hidden' id='volumeBarang$id_anggaran' value='$volume_barang'>".number_format($volume_barang,0,',','.')."</td>";
					 $Koloms.= "<td class='$cssclass' id='alignKoreksi' align='$align'><span id='spanJumlah$id_anggaran'>$jumlahKoreksi</span> <span style='color:red;' id='bantuJumlah$id_anggaran'><span> </td>";
					 $aksi  = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=rkbmdPemeliharaanPerubahan_v3.sesuai('$id_anggaran');></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=rkbmdPemeliharaanPerubahan_v3.koreksi('$id_anggaran');></img>";
					 $Koloms.= "<td class='$cssclass' id='updatePengguna$id_anggaran' align='center'><span id='save$id_anggaran'>$aksi</span></td>";
				 }



				$Koloms = array(
						 	array("Y", $Koloms),
						 );
			}
	   else{
	   		if($this->jenisFormTerakhir == "PENYUSUNAN"){

					if($f == '00' && $q =='0')$TampilCheckBox = "";
				   	  if($p =='0'){
					 	$kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
						$getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
					 	$header = $e1.". ".$getSubUnit['nm_skpd'];
						$style = "style='font-weight:bold;'";
						$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
						$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
						$Koloms.= $tampilHeader;
						$Koloms.= "<td class='$cssclass' align='left'></td>";
						$Koloms.= "<td class='$cssclass' align='right'></td>";
						$Koloms.= "<td class='$cssclass' align='left'></td>";
						$Koloms.= "<td class='$cssclass' align='left'></td>";
						if($this->wajibValidasi == TRUE)$Koloms.= "<td class='$cssclass' align='left'></td>";
					 }elseif($p!= '0' && $q=='0'){
					 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".'0';
						$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
						$header = genNumber($p).". ".$getNamaPrgoram['nama'];
						$style = "style='margin-left:5px;'";
						$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
						$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
						$Koloms.= $tampilHeader;
						$Koloms.= "<td class='$cssclass' align='left'></td>";
						$Koloms.= "<td class='$cssclass' align='right'></td>";
						$Koloms.= "<td class='$cssclass' align='left'></td>";
						$Koloms.= "<td class='$cssclass' align='left'></td>";
						if($this->wajibValidasi == TRUE)$Koloms.= "<td class='$cssclass' align='left'></td>";
					 }elseif($f == '00' && $q!='0'){
					 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".$q;
						$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
						$header = genNumber($q).". ".$getNamaPrgoram['nama'];
						$style = "style='margin-left:10px;'";
						$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
						$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
						$Koloms.= $tampilHeader;
						$Koloms.= "<td class='$cssclass' align='left'></td>";
						$Koloms.= "<td class='$cssclass' align='right'></td>";
						$Koloms.= "<td class='$cssclass' align='left'></td>";
						$Koloms.= "<td class='$cssclass' align='left'></td>";
						if($this->wajibValidasi == TRUE)$Koloms.= "<td class='$cssclass' align='left'></td>";
					 }else{

						 $tampilHeader = "<td class='$cssclass' align='left' colspan='1'><span $style>".$header."</span></td>";
						 $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
						 $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
						 $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
						 $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
						 $getBarang = mysql_fetch_array(mysql_query($syntax));
						 $namaBarang = $getBarang['nm_barang'];
						 $getJenisPemeliharaan = mysql_fetch_array(mysql_query("select * from ref_jenis_pemeliharaan where Id = '$id_jenis_pemeliharaan'"));
						 $jenisPemeliharaan = $getJenisPemeliharaan['jenis'];
						 $concat = $kodeSKPD.".".$kodeBarang;
						 $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='1' "));
						 $baik = $getKebutuhanOptimal['kebutuhanOptimal'];
						 $getKurangBaik = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='2' "));
						 $kurangBaik = $getKurangBaik['kebutuhanOptimal'];
						 $getRusakBerat = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='3' "));
						 $rusakBerat = $getRusakBerat['kebutuhanOptimal'];
						 $satuan = $getBarang['satuan_barang'];
						 $customConcat = $kodeSKPD.".".$bk.".".$ck.".".$dk.".".$p.".".$q.".".$kodeBarang;
						 $getMinID = mysql_fetch_array(mysql_query("select min(urut) as min from view_rkbmd where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j) ='$customConcat' and id_jenis_pemeliharaan != '0'"));
						 $getSumVolumeBarang = mysql_fetch_array(mysql_query("select sum(volume_barang) as jumlah from view_rkbmd where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j) ='$customConcat' and id_jenis_pemeliharaan != '0'"));
						 $sumVolume = $getSumVolumeBarang['jumlah'];
						 $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
						 $Koloms.= $tampilHeader;
						 if($urut == $getMinID['min']){
						 	$Koloms.= "<td class='$cssclass' align='center'>$kodeBarang</td>";
						 	$Koloms.= "<td class='$cssclass' align='left'>$namaBarang</td>";
						 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($sumVolume,0,',','.')."</td>";
						 	$Koloms.= "<td class='$cssclass' align='left'>$satuan_barang</td>";
						 	$Koloms.= "<td class='$cssclass' align='CENTER'>MILIK</td>";
							$Koloms.= "<td class='$cssclass' align='right'>".number_format($baik,0,',','.')."</td>";
						 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($kurangBaik,0,',','.')."</td>";
						 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($rusakBerat,0,',','.')."</td>";
						 }else{
						 	$Koloms.= "<td class='$cssclass' align='center'></td>";
							$Koloms.= "<td class='$cssclass' align='center'></td>";
							$Koloms.= "<td class='$cssclass' align='center'></td>";
							$Koloms.= "<td class='$cssclass' align='center'></td>";
							$Koloms.= "<td class='$cssclass' align='center'></td>";
							$Koloms.= "<td class='$cssclass' align='center'></td>";
							$Koloms.= "<td class='$cssclass' align='center'></td>";
							$Koloms.= "<td class='$cssclass' align='center'></td>";
						 }


						 $Koloms.= "<td class='$cssclass' align='left'>$jenisPemeliharaan</td>";
						 $Koloms.= "<td class='$cssclass' align='left'>$uraian_pemeliharaan</td>";
						 $Koloms.= "<td class='$cssclass' align='right'>".number_format($volume_barang,0,',','.')."</td>";
						 $Koloms.= "<td class='$cssclass' align='left'>$catatan</td>";
						 	  if($status_validasi == '1'){
						 	$validnya = "valid.png";
					 }else{
						 	$validnya = "invalid.png";
					 }
					if($this->wajibValidasi == TRUE)$Koloms.= "<td class='$cssclass' align='center'>"."<img src='images/administrator/images/$validnya' width='20px' heigh='20px' style='cursor:pointer;'  > "."</td>";


					 }

						$Koloms = array(
						 	array("Y", $Koloms),
						 );

			}
			elseif($this->jenisFormTerakhir == "KOREKSI PENGGUNA"){
				if($f == '00' && $q =='0')$TampilCheckBox = "";
			   	  if($p =='0'){
				 	$kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
					$getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
				 	$header = $e1.". ".$getSubUnit['nm_skpd'];
					$style = "style='font-weight:bold;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
				 }elseif($p!= '0' && $q=='0'){
				 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".'0';
					$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
					$header = genNumber($p).". ".$getNamaPrgoram['nama'];
					$style = "style='margin-left:5px;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
				 }elseif($f == '00' && $q!='0'){
				 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".$q;
					$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
					$header = genNumber($q).". ".$getNamaPrgoram['nama'];
					$style = "style='margin-left:10px;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
				 }else{

					 $tampilHeader = "<td class='$cssclass' align='left' colspan='1'><span $style>".$header."</span></td>";
					 $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
					 $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
					 $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
					 $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
					 $getBarang = mysql_fetch_array(mysql_query($syntax));
					 $namaBarang = $getBarang['nm_barang'];
					 $getJenisPemeliharaan = mysql_fetch_array(mysql_query("select * from ref_jenis_pemeliharaan where Id = '$id_jenis_pemeliharaan'"));
					 $jenisPemeliharaan = $getJenisPemeliharaan['jenis'];
					 $concat = $kodeSKPD.".".$kodeBarang;
					 $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='1' "));
					 $baik = $getKebutuhanOptimal['kebutuhanOptimal'];
					 $getKurangBaik = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='2' "));
					 $kurangBaik = $getKurangBaik['kebutuhanOptimal'];
					 $getRusakBerat = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='3' "));
					 $rusakBerat = $getRusakBerat['kebutuhanOptimal'];
					 $satuan = $getBarang['satuan_barang'];
					 $customConcat = $kodeSKPD.".".$bk.".".$ck.".".$dk.".".$p.".".$q.".".$kodeBarang;
					 $nomorUrutSebelumnya = $this->nomorUrut -1 ;
					 $nomorUrut2TahapSebelumnya = $this->urutTerakhir - 1;
					 $getMinID = mysql_fetch_array(mysql_query("select min(urut) as min from view_rkbmd where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j) ='$customConcat' and id_jenis_pemeliharaan != '0'"));
					 $getSumVolumeBarang = mysql_fetch_array(mysql_query("select sum(volume_barang) as  jumlah  , catatan from view_rkbmd where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j) ='$customConcat' and id_jenis_pemeliharaan != '0' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrut2TahapSebelumnya'"));
					 $sumVolume = $getSumVolumeBarang['jumlah'];
					 $catatan = $getSumVolumeBarang['catatan'];
					 $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					 $Koloms.= $tampilHeader;
					 if($urut == $getMinID['min']){
					 	$Koloms.= "<td class='$cssclass' align='left'>$namaBarang</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($sumVolume,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='left'>$satuan_barang</td>";
					 	$Koloms.= "<td class='$cssclass' align='CENTER'>MILIK</td>";
						$Koloms.= "<td class='$cssclass' align='right'>".number_format($baik,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($kurangBaik,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($rusakBerat,0,',','.')."</td>";
					 }else{
					 	$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
					 }
					 $getDataKoreksi = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "));
					 $kondisiWarna = "red";

						 if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "))  > 0){
						 	$jumlahKoreksi = number_format($getDataKoreksi['volume_barang'],0,',','.');
						 	$align = "right";
							$tanggalKoreksi = explode("-",$getDataKoreksi['tanggal_update']);
							$tanggalKoreksi = $tanggalKoreksi[2]."-".$tanggalKoreksi[1]."-".$tanggalKoreksi[0];
							$caraPemenuhan = $getDataKoreksi['cara_pemenuhan'];
							$keteranganKoreksi =  $getDataKoreksi['user_update']."/".$tanggalKoreksi;
							$kondisiWarna = "black";
						 }

					 $Koloms.= "<td class='$cssclass' style='color:black ;' align='left'>$jenisPemeliharaan</td>";
					 $Koloms.= "<td class='$cssclass' align='left'>$uraian_pemeliharaan</td>";
					 $Koloms.= "<td class='$cssclass' align='right'>".number_format($volume_barang,0,',','.')."</td>";
					 $Koloms.= "<td class='$cssclass' align='left'>$catatan</td>";
					 $Koloms.= "<td class='$cssclass'  align='right'>$jumlahKoreksi </td>";

				 }

				$Koloms = array(
						 	array("Y", $Koloms),
						 );

			}
			elseif($this->jenisFormTerakhir == "KOREKSI PENGELOLA"){
					if($f == '00' && $q =='0')$TampilCheckBox = "";
			   	  if($p =='0'){
				 	$kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
					$getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
				 	$header = $e1.". ".$getSubUnit['nm_skpd'];
					$style = "style='font-weight:bold;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
				 }elseif($p!= '0' && $q=='0'){
				 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".'0';
					$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
					$header = genNumber($p).". ".$getNamaPrgoram['nama'];
					$style = "style='margin-left:5px;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
				 }elseif($f == '00' && $q!='0'){
				 	$kodeProgram = $bk.".".$ck.".".$dk.".".$p.".".$q;
					$getNamaPrgoram = mysql_fetch_array(mysql_query("select * from ref_program where concat(bk,'.',ck,'.',dk,'.',p,'.',q) = '$kodeProgram'"));
					$header = genNumber($q).". ".$getNamaPrgoram['nama'];
					$style = "style='margin-left:10px;'";
					$tampilHeader = "<td class='$cssclass' align='left' colspan='9'><span $style>".$header."</span></td>";
					$Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					$Koloms.= $tampilHeader;
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='right'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
					$Koloms.= "<td class='$cssclass' align='left'></td>";
				 }else{
				 	 $nomorUrutSebelumnya = $this->nomorUrut -1;
					 $tampilHeader = "<td class='$cssclass' align='left' colspan='1'><span $style>".$header."</span></td>";
					 $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
					 $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
					 $kodeKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
					 $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
					 $getBarang = mysql_fetch_array(mysql_query($syntax));
					 $namaBarang = $getBarang['nm_barang'];
					 $getJenisPemeliharaan = mysql_fetch_array(mysql_query("select * from ref_jenis_pemeliharaan where Id = '$id_jenis_pemeliharaan'"));
					 $jenisPemeliharaan = $getJenisPemeliharaan['jenis'];
					 $concat = $kodeSKPD.".".$kodeBarang;
					 $getKebutuhanOptimal = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='1' "));
					 $baik = $getKebutuhanOptimal['kebutuhanOptimal'];
					 $getKurangBaik = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='2' "));
					 $kurangBaik = $getKurangBaik['kebutuhanOptimal'];
					 $getRusakBerat = mysql_fetch_array(mysql_query("select sum(jml_barang) as kebutuhanOptimal from buku_induk where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$concat' and status_barang = '1' and kondisi ='3' "));
					 $rusakBerat = $getRusakBerat['kebutuhanOptimal'];
					 $satuan = $getBarang['satuan_barang'];
					 $customConcat = $kodeSKPD.".".$bk.".".$ck.".".$dk.".".$p.".".$q.".".$kodeBarang;
					 $getMinID = mysql_fetch_array(mysql_query("select min(urut) as min from view_rkbmd where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j) ='$customConcat' and id_jenis_pemeliharaan != '0'"));
					 $nomorUrut3TahapSebelumnya = $this->urutTerakhir -2;
					 $getSumVolumeBarang = mysql_fetch_array(mysql_query("select sum(volume_barang) as jumlah from view_rkbmd where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q,'.',f,'.',g,'.',h,'.',i,'.',j) ='$customConcat' and id_jenis_pemeliharaan != '0' and tahun = '$this->tahun' and jenis_anggaran='$this->jenisAnggaran' and no_urut = '$nomorUrut3TahapSebelumnya'"));
					 $sumVolume = $getSumVolumeBarang['jumlah'];
					 $Koloms.= "<td class='$cssclass' align='center'>$no</td>";
					 $Koloms.= $tampilHeader;
					 if($urut == $getMinID['min']){
					 	$Koloms.= "<td class='$cssclass' align='left'>$namaBarang</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($sumVolume,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='left'>$satuan_barang</td>";
					 	$Koloms.= "<td class='$cssclass' align='CENTER'>MILIK</td>";
						$Koloms.= "<td class='$cssclass' align='right'>".number_format($baik,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($kurangBaik,0,',','.')."</td>";
					 	$Koloms.= "<td class='$cssclass' align='right'>".number_format($rusakBerat,0,',','.')."</td>";
					 }else{
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
						$Koloms.= "<td class='$cssclass' align='center'></td>";
					 }
					 $getDataKoreksi = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "));
					 $kondisiWarna = "red";

						 if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' "))  > 0){
						 	$jumlahKoreksi = number_format($getDataKoreksi['volume_barang'],0,',','.');
						 	$align = "right";
							$tanggalKoreksi = explode("-",$getDataKoreksi['tanggal_update']);
							$tanggalKoreksi = $tanggalKoreksi[2]."-".$tanggalKoreksi[1]."-".$tanggalKoreksi[0];
							$caraPemenuhan = $getDataKoreksi['cara_pemenuhan'];
							$keteranganKoreksi =  $getDataKoreksi['user_update']."/".$tanggalKoreksi;
							$kondisiWarna = "black";

						 }

					 $Koloms.= "<td class='$cssclass' style='color:black ;' align='left'>$jenisPemeliharaan</td>";
					 $Koloms.= "<td class='$cssclass' align='left'>$uraian_pemeliharaan</td>";
					 $getJumlahBarangPertama = mysql_fetch_array(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrut3TahapSebelumnya'"));
					 $jumlahBarangPertama = $getJumlahBarangPertama['volume_barang'];
					 $catatan = $getJumlahBarangPertama['catatan'];
					 $tanggal_update = explode("-",$tanggal_update);
					 $tanggal_update = $tanggal_update[2]."-".$tanggal_update[1]."-".$tanggal_update[0];
					 $Koloms.= "<td class='$cssclass' align='right'>".number_format($jumlahBarangPertama,0,',','.')."</td>";
					 $nomorUrut2TahapSebelumnya = $this->urutTerakhir -1;
					 $getDataTahapPengguna = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrut2TahapSebelumnya' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' "));
					 $cara_pemenuhan = $getDataTahapPengguna['cara_pemenuhan'];
					 $user_update = $getDataTahapPengguna['user_update'];
					 $tanggal_update = $getDataTahapPengguna['tanggal_update'];
					 $noKurang2 = $no_urut - 1;
					 $getKoreksiPengguna = mysql_fetch_array(mysql_query("select * from view_rkbmd where tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$noKurang2' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' "));
					 $koreksiPengguna = $getKoreksiPengguna['volume_barang'];
					 $Koloms.= "<td class='$cssclass' align='left'>$catatan</td>";
					 $Koloms.= "<td class='$cssclass' align='right'>".number_format($koreksiPengguna,0,',','.')."</td>";

					 $Koloms.= "<td class='$cssclass' id='alignKoreksi' align='right'>$jumlahKoreksi  </td>";

				 }


				$Koloms = array(
						 	array("Y", $Koloms),
						 );

			}
	   }
	 return $Koloms;

	}
	 function Validasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI RKBMD PEMELIHARAAN';
	 $kode = $dt['c1'].".".$dt['c'].".".$dt['d'].".".$dt['e'].".".$dt['e1'].".".genNumber($dt['bk']).".".genNumber($dt['ck']).".".genNumber($dt['dk']).".".genNumber($dt['p']).".".genNumber($dt['q']).".".$dt['f'].".".$dt['g'].".".$dt['h'].".".$dt['i'].".".$dt['j'].".".$dt['id_jenis_pemeliharaan'];
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
				WilSKPD_ajxVW("rkbmdPemeliharaanPerubahan_v3Skpd") .
			"</td>
			<td >" .
			"</td></tr>
			<tr><td>
			<input type='hidden' name='cmbJenisrkbmdPemeliharaanPerubahan_v3' id='cmbJenisrkbmdPemeliharaanPerubahan_v3' value='PEMELIHARAAN'>
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

		//grabFromKoreksiPengelola
			$getAll = mysql_query("select * from view_rkbmd where no_urut = '5' and tahun ='$this->tahun' and jenis_anggaran='MURNI'  and j!='000' and id_jenis_pemeliharaan != '0' ");
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) {
				  $$key = $value;
				 }
				if(mysql_num_rows(mysql_query("select * from pindah_rkbmd_v3 where id_anggaran = '$id_anggaran'")) != 0){

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

				$cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q= '$q' and  f='00' and id_tahap='$this->idTahap' and uraian_pemeliharaan = 'RKBMD PEMELIHARAAN'"));
				if($cekKegiatan < 1){
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
								  'uraian_pemeliharaan' => 'RKBMD PEMELIHARAAN'
									);
						mysql_query(VulnWalkerInsert('tabel_anggaran',$data));
				}

				$data = array(    'jenis_anggaran' => $this->jenisAnggaran,
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
								  'f' => $f,
								  'g' => $g,
								  'h' => $h,
								  'i' => $i,
								  'j' => $j,
								  'volume_barang'=> $volume_barang,
								  'catatan' => $catatan,
								  'satuan_barang' => $satuan_barang,
								  'id_jenis_pemeliharaan' => $id_jenis_pemeliharaan,
								  'uraian_pemeliharaan' => $uraian_pemeliharaan,
								  'id_tahap' => $this->idTahap,
								  'nama_modul' => "RKBMD",
								  'tanggal_update' => date('Y-m-d'),
								  'user_update' => $_COOKIE['coID'],
								  );
						mysql_query(VulnWalkerInsert("tabel_anggaran",$data));
						$dataPindah = array(
											'id_anggaran' => $id_anggaran,
											'tanggal' => date("Y-m-d")
											);
						mysql_query(VulnWalkerInsert('pindah_rkbmd_v3',$dataPindah));
				}

			}



		$UID  = $_COOKIE['coID'];
		$c1   = $_REQUEST['rkbmdPemeliharaanPerubahan_v3SkpdfmUrusan'];
		$c    = $_REQUEST['rkbmdPemeliharaanPerubahan_v3SkpdfmSKPD'];
		$d    = $_REQUEST['rkbmdPemeliharaanPerubahan_v3SkpdfmUNIT'];
		$e    = $_REQUEST['rkbmdPemeliharaanPerubahan_v3SkpdfmSUBUNIT'];
		$e1   = $_REQUEST['rkbmdPemeliharaanPerubahan_v3SkpdfmSEKSI'];
		$fmKODE = $_REQUEST['fmKODE'];
		$fmBARANG = $_REQUEST['fmBARANG'];
		$cmbJenisrkbmdPemeliharaanPerubahan_v3 = $_REQUEST['cmbJenisrkbmdPemeliharaanPerubahan_v3'];
		$arrKondisi = array();

		if(isset($e1)){
			$data = array("CurrentUrusan" => $c1,
					  "CurrentBidang" => $c,
					  "CurrentSKPD" => $d,
					   "CurrentUnit" => $e,
					    "CurrentSubUnit" => $e1,

					  );
		}elseif(isset($e)){
			$data = array("CurrentUrusan" => $c1,
					  "CurrentBidang" => $c,
					  "CurrentSKPD" => $d,
					   "CurrentUnit" => $e,

					  );
		}elseif(isset($d)){
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

		if(!empty($c1) && $c1!="0" ){
			$arrKondisi[] = "c1 = $c1";
		}
		if(!empty($c) && $c!="00"){
			$arrKondisi[] = "c = $c";
		}
		if(!empty($d) && $d!="00"){
			$arrKondisi[] = "d = $d";
		}
		if(!empty($e) && $e!="00"){
			$arrKondisi[] = "e = $e";
		}
		if(!empty($e1) && $e1!="000"){
			$arrKondisi[] = "e1 = $e1";
		}

		$arrKondisi[] = "( id_jenis_pemeliharaan != 0 OR (id_jenis_pemeliharaan = 0 and f = '00' and uraian_pemeliharaan != 'RKBMD PENGADAAN' and uraian_pemeliharaan != 'RKBMD PERSEDIAAN' ) ) ";

		if($this->jenisForm == "PENYUSUNAN"){

			$getAllParent = mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap' and f='00' and q = '0' and e1 !='000' ");
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) {
			 	 $$key = $value;
				}
				$cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap ='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan !='0' "));
				if($cekSKPD == 0){
					$concat = $c1.".".$c.".".$d.".".$e.".".$e1;
					$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
				}else{
					$concat = $c1.".".$c.".".$d.".".$e.".".$e1;
					$getAllProgram = mysql_query("select * from view_rkbmd where id_tahap='$this->idTahap' and f ='00'  and concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$concat'  and p !='0' and q ='0'");
					while($rows = mysql_fetch_array($getAllProgram)){
						foreach ($rows as $key => $value) {
					 	 $$key = $value;
						}
						$cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where id_tahap ='$this->idTahap' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and bk='$bk' and ck= '$ck' and dk= '$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan !='0' "));
						if($cekProgram == 0){
							$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
							$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
						}
					}

				}


			}

			$arrKondisi[] = "id_tahap = '$this->idTahap'";
		}elseif($this->jenisForm == "KOREKSI PENGGUNA"){
			$nomorUrutSebelumnya = $this->nomorUrut -1;
			$getJenisTahapSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'"));
			$jenisTahapSebelumnya = $getJenisTahapSebelumnya['jenis_form_modul'];
			$getAll = mysql_query("select * from view_rkbmd where f != '00' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya'");
			$arrayID = array();
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) {
			 	 $$key = $value;
				}
				if( $jenisTahapSebelumnya == "PENYUSUNAN" && $status_validasi != '1' && $this->wajibValidasi == TRUE ){
						$arrKondisi[] = " id_anggaran !='$id_anggaran' ";
						$arrayID[] = " id_anggaran !='$id_anggaran' ";
						array_push($arrayID,$id_anggaran);
						$Condition= join(' and ',$arrayID);
						if(sizeof($arrayID) == 0){
							$Condition = "";
						}else{
							$Condition = $Condition." and";
						}
						$resultKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where $Condition  f !='00' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
						if($resultKegiatan  == 0){
						    $concat =  $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.'.'.$ck.'.'.$dk.'.'.$p.'.'.$q;
							$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat' ";
							$resultProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where $Condition  f !='00' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk = '$bk' and ck='$ck' and dk='$dk' and p='$p'  and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
							if($resultProgram == 0){
								$concat =  $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.'.'.$ck.'.'.$dk.'.'.$p;
								$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat' ";
								$resultSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where $Condition  f !='00' and c1='$c1' and c='$c' and d='$d' and e='$e' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
								if($resultSKPD == 0){
									$concat =  $c1.".".$c.".".$d.".".$e.".".$e1;
									$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat' ";
								}
							}

						}
				}




			}
			$getAllParent = mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and f='00' and q !='0' ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c'  and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'  and f != '00' and id_jenis_pemeliharaan !='0'  "));
					if($cekKegiatan == 0){
						$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
						$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat'";
						$cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan !='0' "));
						if($cekProgram == 0){
							$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
							$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
							$cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan !='0' "));
							if($cekSKPD == 0){
								$concat = $c1.".".$c.".".$d.".".$e.".".$e1;
								$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
							}
						}
					}


				}
			$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya'";
		}elseif($this->jenisForm == "KOREKSI PENGELOLA"){
			$nomorUrutSebelumnya = $this->nomorUrut -1;
			$getJenisTahapSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$nomorUrutSebelumnya'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'"));
			$jenisTahapSebelumnya = $getJenisTahapSebelumnya['jenis_form_modul'];

			$getAllParent = mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and f='00' and q !='0' ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c'  and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'  and f != '00' and id_jenis_pemeliharaan !='0'  "));
					if($cekKegiatan == 0){
						$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
						$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat'";
						$cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan !='0' "));
						if($cekProgram == 0){
							$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
							$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
							$cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan !='0' "));
							if($cekSKPD == 0){
								$concat = $c1.".".$c.".".$d.".".$e.".".$e1;
								$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
							}
						}
					}


				}
			$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya'";
		}else{
			if($this->jenisFormTerakhir =="PENYUSUNAN"){
				    $getAllParent = mysql_query("select * from view_rkbmd where no_urut = '$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran' and f='00' and q = '0' and e1 !='000' ");
					while($rows = mysql_fetch_array($getAllParent)){
						foreach ($rows as $key => $value) {
					 	 $$key = $value;
						}
						$cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan !='0' "));
						if($cekSKPD == 0){
							$concat = $c1.".".$c.".".$d.".".$e.".".$e1;
							$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
						}else{
							$concat = $c1.".".$c.".".$d.".".$e.".".$e1;
							$getAllProgram = mysql_query("select * from view_rkbmd where no_urut = '$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran' and f ='00'  and concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$concat'  and p !='0' and q ='0'");
							while($rows = mysql_fetch_array($getAllProgram)){
								foreach ($rows as $key => $value) {
							 	 $$key = $value;
								}
								$cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and bk='$bk' and ck= '$ck' and dk= '$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan !='0' "));
								if($cekProgram == 0){
									$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
									$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
								}
							}

						}


					}
				$arrKondisi[] =  "no_urut = '$this->urutTerakhir'";
			}elseif($this->jenisFormTerakhir == "VALIDASI"){
				$getAllParent = mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and f='00' and q !='0' ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c'  and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'  and f != '00' and id_jenis_pemeliharaan !='0'  "));
					if($cekKegiatan == 0){
						$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
						$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat'";
						$cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan !='0' "));
						if($cekProgram == 0){
							$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
							$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
							$cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan !='0' "));
							if($cekSKPD == 0){
								$concat = $c1.".".$c.".".$d.".".$e.".".$e1;
								$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
							}
						}
					}


				}
				$arrKondisi[] =  "no_urut = '$this->urutTerakhir'";
			}elseif($this->jenisFormTerakhir == "KOREKSI PENGGUNA"){
				$getAllParent = mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and f='00' and q !='0' ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c'  and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'  and f != '00' and id_jenis_pemeliharaan !='0'  "));
					if($cekKegiatan == 0){
						$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
						$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat'";
						$cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan !='0' "));
						if($cekProgram == 0){
							$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
							$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
							$cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan !='0' "));
							if($cekSKPD == 0){
								$concat = $c1.".".$c.".".$d.".".$e.".".$e1;
								$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
							}
						}
					}


				}
				$arrKondisi[] =  "no_urut = '$this->urutTerakhir'";
			}elseif($this->jenisFormTerakhir == "KOREKSI PENGELOLA"){
				$getAllParent = mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and f='00' and q !='0' ");
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) {
				 	 $$key = $value;
					}
					$cekKegiatan = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c'  and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'  and f != '00' and id_jenis_pemeliharaan !='0'  "));
					if($cekKegiatan == 0){
						$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p.".".$q;
						$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p,'.',q) != '$concat'";
						$cekProgram = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and f !='00' and id_jenis_pemeliharaan !='0' "));
						if($cekProgram == 0){
							$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$dk.".".$p;
							$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat'";
							$cekSKPD = mysql_num_rows(mysql_query("select * from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$this->urutTerakhir' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  and f !='00' and id_jenis_pemeliharaan !='0' "));
							if($cekSKPD == 0){
								$concat = $c1.".".$c.".".$d.".".$e.".".$e1;
								$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat'";
							}
						}
					}


				}
				$arrKondisi[] =  "no_urut = '$this->urutTerakhir'";
			}



		}



		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
		$arrKondisi[] = "f!='06' and f!='07' and f!='08'";


		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();

		$arrOrders[] = "urut ASC " ;




			$Order= join(',',$arrOrders);
			$OrderDefault = '';// Order By no_terima desc ';
			$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;


		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}
	function Laporan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 800;
	 $this->form_height = 80;
	 $this->form_caption = 'LAPORAN RKBMD PEMELIHARAAN';
	 $c1 = $dt['rkbmdPemeliharaanPerubahan_v3SkpdfmUrusan'];
	 $c = $dt['rkbmdPemeliharaanPerubahan_v3SkpdfmSKPD'];
	 $d = $dt['rkbmdPemeliharaanPerubahan_v3SkpdfmUNIT'];
	 $e = $dt['rkbmdPemeliharaanPerubahan_v3SkpdfmSUBUNIT'];
	 $e1 = $dt['rkbmdPemeliharaanPerubahan_v3SkpdfmSEKSI'];


	 	 $arrayJenisLaporan = array(
	 						   array('Pemeliharaan8', 'PERUBAHAN USULAN RKBMD PEMELIHARAAN PADA KUASA PENGGUNA BARANG'),
							   array('Pemeliharaan10', 'PERUBAHAN HASIL PENELAAHAN RKBMD PEMELIHARAAN OLEH PENGGUNA BARANG'),
							   array('Pemeliharaan9', 'PERUBAHAN RKBMD PEMELIHARAAN PADA KUASA PENGGUNA BARANG'),


							   );




	  $cmbJenisLaporan = cmbArray('jenisKegiatan','',$arrayJenisLaporan,'-- JENIS LAPORAN --',"onchange = $this->Prefix.jenisChanged();");
	  $this->form_fields = array(
			'jenisLaporan' => array(
						'label'=>'JENIS LAPORAN',
						'labelWidth'=>100,
						'value'=> $cmbJenisLaporan
						 )

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='View' onclick ='".$this->Prefix.".Report()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function LaporanTmplSKPD($c1, $c, $d, $e, $e1,$pisah){
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




function Pemeliharaan8($xls =FALSE){
		global $Main;

	             $getJenisReport8 = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL8' "));
		$getJenisUkuran = $getJenisReport8['jenis'];
		if ($getJenisUkuran == 'L') {
			$trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
			$width = "33cm";
			$height = "21.5cm";
		}else{
			$trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
			$width = "21.5cm";
			$height = "33cm";
		}
		$arrayTandaTangan8 = explode(';', $getJenisReport8['tanda_tangan']);

		$this->fileNameExcel = "PERUBAHAN USULAN RKBMD PEMELIHARAAN PADA KUASA PENGGUNA BARANG";
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

		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
		$getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j!='000' and (uraian_pemeliharaan !='' or uraian_pemeliharaan ='RKBMD PEMELIHARAAN') and jenis_form_modul !='KOREKSI PENGGUNA' and jenis_form_modul !='KOREKSI PENGELOLA' "));
		$lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
		$getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
		$lastNomorUrut = "3";
		$getMinJenisForm = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran'"));
		if($getMinJenisForm['jenis_form_modul'] == 'PENYUSUNAN' && $this->wajibValidasi == TRUE){
				$kondisiValid = " and status_validasi = '1'";
		}

		$arrKondisi = array();
		$jenisSKPD = " and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' ";
		$grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PEMELIHARAAN' )  and p !='0' and q='0' $jenisSKPD");
		while($rows = mysql_fetch_array($grabProgram)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			}
			if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'  and uraian_pemeliharaan !=''  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000'  $jenisSKPD")) == 0){
				$concat = $bk.".".$ck.".".$dk.".".$p;
				$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
			}else{
			$grabKegiatan = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and uraian_pemeliharaan !='RKBMD PENGADAAN'  and uraian_pemeliharaan !='RKBMD PERSEDIAAN' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q!='0' and j='000'");
				while($row2s = mysql_fetch_array($grabKegiatan)){
					foreach ($row2s as $key => $value) {
						  $$key = $value;
					}
					if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and uraian_pemeliharaan !=''  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' $jenisSKPD ")) == 0){
						if($q != '0'){
							$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
							$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
						}
					}else{
						$grabBarang = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and uraian_pemeliharaan !='RKBMD PENGADAAN'  and uraian_pemeliharaan !='RKBMD PERSEDIAAN' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000'");
						while($row3s = mysql_fetch_array($grabBarang)){
							foreach ($row3s as $key => $value) {
								  $$key = $value;
							}
							$concat = $f.".".$g.".".$h.".".$i.".".$j;
							if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'  and uraian_pemeliharaan !=''  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' $jenisSKPD ")) == 0){
								if($j != '000'){
									$arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
								}
							}
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
		$qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and  uraian_pemeliharaan !='RKBMD PENGADAAN' and  uraian_pemeliharaan !='RKBMD PERSEDIAAN' $this->kondisiBarang and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' $Kondisi order by urut";

		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
				if ($_GET['cetak'] == "ok") {
			$body = "<body onload='window.print()'>";
		}else if ($_GET['cetak'] == "no") {
			$body = "<body>";
		}else{
			$body = "<body>";
		}

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
							font-size:17px;
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
			"$body
				<div style='width:$this->Cetak_WIDTH_Landscape;'>

<table class=\"rangkacetak\" style='width:33cm;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
							<table style='width: 100%; border: none; margin-bottom: 1%;'>
								<tr>
									<td>
										<img src='assets/images/kabupaten-bandung.jpeg' style='width: 100px; height: 100px;'>
									</td>
									<td style='text-align: center;'>
										<span style='font-size:18px;font-weight:bold;text-decoration: '>
PERUBAHAN USULAN RENCANA KEBUTUHAN PEMELIHARAAN BARANG MILIK DAERAH<br>
					(PERUBAHAN RENCANA PEMELIHARAAN)<br>
					KUASA PENGUNA BARANG ".strtoupper($kuasaPenggunaBarang)."
										</span>
									</td>
									<td style='width: 9%;'>
							<span class='ukurantulisanIdPenerimaan'>TAHUN : $this->tahun </span></div><br>
									</td>
								</tr>
							</table>


					        <table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
					        <thead>
									<tr>
										<th class='th01' rowspan='3' style='width:20px;' >NO</th>
										<th class='th01' rowspan='3' >PROGRAM/KEGIATAN/OUTPUT</th>
										<th class='th02' rowspan='1' colspan='8' >BARANG YANG DIPELIHARA</th>
										<th class='th01' rowspan='3' >NAMA PEMELIHARAAN</th>
										<th class='th02' rowspan='1' colspan='2' >SEMULA</th>
										<th class='th02' rowspan='1' colspan='2' >MENJADI</th>
										<th class='th01' rowspan='3' >ALASAN PERUBAHAN</th>
										<th class='th01' rowspan='3' >KETERANGAN</th>
									</tr>
									<tr>
										<th class='th01' rowspan='2' colspan='2'>KODE / NAMA BARANG</th>
										<th class='th01' rowspan='2' >JUMLAH</th>
										<th class='th01' rowspan='2' >SATUAN</th>
										<th class='th01' rowspan='2' >STATUS BARANG</th>
										<th class='th02' rowspan='1' colspan='3' >KONDISI BARANG</th>
										<th class='th01' rowspan='2' >JUMLAH</th>
										<th class='th01' rowspan='2' >SATUAN</th>
										<th class='th01' rowspan='2' >JUMLAH</th>
										<th class='th01' rowspan='2' >SATUAN</th>



									</tr>
									<tr>
										<th class='th01' rowspan='1' >B</th>
										<th class='th01' rowspan='1' >KB</th>
										<th class='th01' rowspan='1' >RB</th>
									</tr>
						</thead>

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
				$getNamaPemeliharaan = mysql_fetch_array(mysql_query("select * from ref_jenis_pemeliharaan where Id = '$id_jenis_pemeliharaan'"));
				$namaPemeliharaan = $getNamaPemeliharaan['jenis'];
				$getJumlahB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='1'"));
				$b =  number_format($getJumlahB['jml_barang'],0,'.',',');
				$getJumlahKB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='2'"));
				$kb =  number_format($getJumlahKB['jml_barang'],0,'.',',');
				$getJumlahRB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='3'"));
				$rb =  number_format($getJumlahRB['jml_barang'],0,'.',',');
				$jumlahBarangDiBukuInduk = $getJumlahB['jml_barang'] + $getJumlahKB['jml_barang'] + $getJumlahRB['jml_barang'];
				$status_barang = "MILIK";
				$getJumlahSemula = mysql_fetch_array(mysql_query("select * from view_rkbmd where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' and tahun = '$this->tahun' and no_urut = '5' and jenis_anggaran ='MURNI'  "));
				$jumlahSemula = number_format($getJumlahSemula['volume_barang'],0,'.',',');
			}
						if ($q != "0") {
				$getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
				$getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
				$outputan = $getDetailRenja[output];

				$namaKegiatan = "<td align='left' style='padding-left: 20px;' class='GarisCetak' colspan='5'>".$programKegiatan;
			}else{
				$namaProgram = "<td align='left' class='GarisCetak' colspan='5'>".$programKegiatan."</td>";
			}

			if ($q != "0") {
				$getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
				$getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
				$outputan = $getDetailRenja[output];

				$namaKegiatan = "<td align='left' style='padding-left: 20px;' class='GarisCetak' colspan='5'>".$programKegiatan;
			}else{
				$namaProgram = "<td align='left' class='GarisCetak' colspan='5'>".$programKegiatan."</td>";
			}

			if ($q == '0') {
				$naonkitu ="
				<tr valign='top'>
				    <td align='$align' class='GarisCetak'>$no</td>
				    $namaProgram
				    <td align='center' class='GarisCetak' >$status_barang</td>
				    <td align='right' class='GarisCetak'>$b</td>
				    <td align='right' class='GarisCetak'>$kb</td>
				    <td align='right' class='GarisCetak'>$rb</td>
				    <td align='left' class='GarisCetak'>$namaPemeliharaan</td>
				    <td align='right' class='GarisCetak'>$jumlahSemula</td>
				    <td align='left' class='GarisCetak'>$satuan_barang</td>
				    <td align='right' class='GarisCetak'>$volBar</td>
				    <td align='left' class='GarisCetak'>$satuan_barang</td>
				    <td align='left' class='GarisCetak'>$alasan_perubahan</td>
				    <td align='left' class='GarisCetak'>$catatan</td>
			             </tr>
			";
			}elseif ($q != '0' && $f == '00') {
			$naonkitu ="
				<tr valign='top'>
				    <td align='$align' class='GarisCetak'>$no</td>
				    $namaKegiatan
				    <td align='center' class='GarisCetak' >$status_barang</td>
				    <td align='right' class='GarisCetak'>$b</td>
				    <td align='right' class='GarisCetak'>$kb</td>
				    <td align='right' class='GarisCetak'>$rb</td>
				    <td align='left' class='GarisCetak'>$namaPemeliharaan</td>
				    <td align='right' class='GarisCetak'>$jumlahSemula</td>
				    <td align='left' class='GarisCetak'>$satuan_barang</td>
				    <td align='right' class='GarisCetak'>$volBar</td>
				    <td align='left' class='GarisCetak'>$satuan_barang</td>
				    <td align='left' class='GarisCetak'>$alasan_perubahan</td>
				    <td align='left' class='GarisCetak'>$catatan</td>
			             </tr>
			";
			}else{
				$naonkitu ="
				<tr valign='top'>
				    <td align='$align' class='GarisCetak'>$no</td>
				    <td align='left' class='GarisCetak' >".$programKegiatan."</td>
                                                        <td align='left' class='GarisCetak' colspan='2'>".$kodeBarang." <br> ".$namaBarang."  </td>
				    <td align='left' class='GarisCetak' >".$jumlahBarangDiBukuInduk."</td>
				    <td align='left' class='GarisCetak' >".$satuan_barang."</td>
				    <td align='center' class='GarisCetak' >$status_barang</td>
				    <td align='right' class='GarisCetak'>$b</td>
				    <td align='right' class='GarisCetak'>$kb</td>
				    <td align='right' class='GarisCetak'>$rb</td>
				    <td align='left' class='GarisCetak'>$namaPemeliharaan</td>
				    <td align='right' class='GarisCetak'>$jumlahSemula</td>
				    <td align='left' class='GarisCetak'>$satuan_barang</td>
				    <td align='right' class='GarisCetak'>$volBar</td>
				    <td align='left' class='GarisCetak'>$satuan_barang</td>
				    <td align='left' class='GarisCetak'>$alasan_perubahan</td>
				    <td align='left' class='GarisCetak'>$catatan</td>
			             </tr>
			";
			}
			echo $naonkitu;


			$no++;
			$volBar = "";
			$jumlahBarangSebelumnya = "";
			$rb = "";
			$b = "";
			$kb = "";
			$satuan_barang = "";
			$jumlahBarangDiBukuInduk = "";
			$catatan = "";
			$volBar= "";
			$status_barang= "";
			$volBar = "";
			$jumlahBarangSebelumnya = "";
			$jumlahSemula = "";
			$jumlahMenjadi = "";
			$alasan_perubahan = "";
			$programKegiatan = "";
			$kodeBarang = "";
			$namaBarang = "";
			$satuan_barang = "";
			$cara_pemenuhan = "";
			$catatan = "";
			$jumlahSemua = "";
			$jumlahBarangSemula = "";
			$cara_pemenuhanStuju = "";
			$jumlahYangDisetujui = "";
			$jumlahBarangYangDisetujui = "";
			$namaPemeliharaan = "";
		}
		echo 				"</table>";
		$getDataKuasaPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatangankuasapenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and e='$e' and e1 ='$e1'"));

		if($xls){
			echo
						"<br><div class='ukurantulisan' align='right'>
						<table align='right'>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>Kuasa Pengguna Barang</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>NIP	".$getDataKuasaPenggunaBarang['nip']."</td>
						</tr>
						</table>
						</div>
				</body>
			</html>";
					}else{
	if (sizeof($arrayTandaTangan8)==1) {
						$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport2['posisi'];

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

					}elseif (sizeof($arrayTandaTangan8)==2) {
						$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport2['posisi']);
            $panjangArrayPosisi = sizeof($arrayPosisi);
            $kategoriKanan = $arrayPosisi[$panjangArrayPosisi-1];
            $kategoriKiri = $arrayPosisi[$panjangArrayPosisi-2];

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

	}elseif (sizeof($arrayTandaTangan8)==3) {
						$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport2['posisi']);
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

function Pemeliharaan9($xls =FALSE){
		global $Main;

		$getJenisReport9 = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL9' "));
		$getJenisUkuran = $getJenisReport9['jenis'];
		if ($getJenisUkuran == 'L') {
			$trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
			$width = "33cm";
			$height = "21.5cm";
		}else{
			$trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
			$width = "21.5cm";
			$height = "33cm";
		}
		$arrayTandaTangan9 = explode(';', $getJenisReport9['tanda_tangan']);

		$this->fileNameExcel = "PERUBAHAN RKBMD PEMELIHARAAN PADA KUASA PENGGUNA BARANG";
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

		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
		$getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j!='000' and (uraian_pemeliharaan !='' or uraian_pemeliharaan ='RKBMD PEMELIHARAAN') and jenis_form_modul !='KOREKSI PENGGUNA' and jenis_form_modul !='KOREKSI PENGELOLA' "));
		$lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
		$getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
		$lastNomorUrut = "3";
		$getMinJenisForm = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran'"));
		if($getMinJenisForm['jenis_form_modul'] == 'PENYUSUNAN' && $this->wajibValidasi == TRUE){
				$kondisiValid = " and status_validasi = '1'";
		}

		$arrKondisi = array();
		$jenisSKPD = " and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' ";
		$grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PEMELIHARAAN' )  and p !='0' and q='0' $jenisSKPD");
		while($rows = mysql_fetch_array($grabProgram)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			}
			if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'  and uraian_pemeliharaan !=''  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000'  $jenisSKPD")) == 0){
				$concat = $bk.".".$ck.".".$dk.".".$p;
				$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
			}else{
			$grabKegiatan = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and uraian_pemeliharaan !='RKBMD PENGADAAN'  and uraian_pemeliharaan !='RKBMD PERSEDIAAN' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q!='0' and j='000'");
				while($row2s = mysql_fetch_array($grabKegiatan)){
					foreach ($row2s as $key => $value) {
						  $$key = $value;
					}
					if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and uraian_pemeliharaan !=''  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' $jenisSKPD ")) == 0){
						if($q != '0'){
							$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
							$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
						}
					}else{
						$grabBarang = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and uraian_pemeliharaan !='RKBMD PENGADAAN'  and uraian_pemeliharaan !='RKBMD PERSEDIAAN' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000'");
						while($row3s = mysql_fetch_array($grabBarang)){
							foreach ($row3s as $key => $value) {
								  $$key = $value;
							}
							$concat = $f.".".$g.".".$h.".".$i.".".$j;
							if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'  and uraian_pemeliharaan !=''  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' $jenisSKPD ")) == 0){
								if($j != '000'){
									$arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
								}
							}
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
		$qry ="select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and  uraian_pemeliharaan !='RKBMD PENGADAAN' and  uraian_pemeliharaan !='RKBMD PERSEDIAAN' $this->kondisiBarang  and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' $Kondisi order by urut";

		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";

	             if ($_GET['cetak'] == "ok") {
			$body = "<body onload='window.print()'>";
		}else if ($_GET['cetak'] == "no") {
			$body = "<body>";
		}else{
			$body = "<body>";
		}

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
							font-size:17px;
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
					</style>
				</head>".
			"$body
				<div style='width:$this->Cetak_WIDTH_Landscape;'>

                         <table class=\"rangkacetak\" style='width:33cm;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
							<table style='width: 100%; border: none; margin-bottom: 1%;'>
								<tr>
									<td>
										<img src='assets/images/kabupaten-bandung.jpeg' style='width: 100px; height: 100px;'>
									</td>
									<td style='text-align: center;'>
										<span style='font-size:18px;font-weight:bold;text-decoration: '>
                                                                 PERUBAHAN RENCANA KEBUTUHAN PEMELIHARAAN BARANG MILIK DAERAH<br>
					(PERUBAHAN RENCANA PEMELIHARAAN)<br>
					KUASA PENGUNA BARANG ".strtoupper($kuasaPenggunaBarang)."
										</span>
									</td>
									<td style='width: 9%;'>
							<span class='ukurantulisanIdPenerimaan'>TAHUN : $this->tahun </span></div><br>
									</td>
								</tr>
							</table>


					<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
										<th class='th01' rowspan='3' style='width:20px;' >NO</th>
										<th class='th01' rowspan='3' >PROGRAM/KEGIATAN/OUTPUT</th>
										<th class='th02' rowspan='1' colspan='8' >BARANG YANG DIPELIHARA</th>
										<th class='th01' rowspan='3' >NAMA PEMELIHARAAN</th>
										<th class='th02' rowspan='1' colspan='2' >SEMULA</th>
										<th class='th02' rowspan='1' colspan='2' >MENJADI</th>
										<th class='th01' rowspan='3' >ALASAN PERUBAHAN</th>
										<th class='th02' rowspan='1' colspan='2' >PERUBAHAN RENCANA KEBUTUHAN PEMELIHARAAN BMD YANG DISETUJUI</th>

										<th class='th01' rowspan='3' >KETERANGAN</th>
									</tr>
									<tr>
										<th class='th01' rowspan='2' colspan='2'>KODE / NAMA BARANG</th>
										<th class='th01' rowspan='2' >JUMLAH</th>
										<th class='th01' rowspan='2' >SATUAN</th>
										<th class='th01' rowspan='2' >STATUS BARANG</th>
										<th class='th02' rowspan='1' colspan='3' >KONDISI BARANG</th>
										<th class='th01' rowspan='2' >JUMLAH</th>
										<th class='th01' rowspan='2' >SATUAN</th>
										<th class='th01' rowspan='2' >JUMLAH</th>
										<th class='th01' rowspan='2' >SATUAN</th>
										<th class='th01' rowspan='2' >JUMLAH</th>
										<th class='th01' rowspan='2' >SATUAN</th>



									</tr>
									<tr>
										<th class='th01' rowspan='1' >B</th>
										<th class='th01' rowspan='1' >KB</th>
										<th class='th01' rowspan='1' >RB</th>
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
				$getNamaPemeliharaan = mysql_fetch_array(mysql_query("select * from ref_jenis_pemeliharaan where Id = '$id_jenis_pemeliharaan'"));
				$namaPemeliharaan = $getNamaPemeliharaan['jenis'];
				$getJumlahB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='1'"));
				$b =  number_format($getJumlahB['jml_barang'],0,'.',',');
				$getJumlahKB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='2'"));
				$kb =  number_format($getJumlahKB['jml_barang'],0,'.',',');
				$getJumlahRB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='3'"));
				$rb =  number_format($getJumlahRB['jml_barang'],0,'.',',');
				$jumlahBarangDiBukuInduk = $getJumlahB['jml_barang'] + $getJumlahKB['jml_barang'] + $getJumlahRB['jml_barang'];
				$status_barang = "MILIK";
				$getJumlahSemula = mysql_fetch_array(mysql_query("select * from view_rkbmd where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' and tahun = '$this->tahun' and no_urut = '5' and jenis_anggaran ='MURNI' "));
				$jumlahSemula = number_format($getJumlahSemula['volume_barang'],0,'.',',');
				$getJumlahSetuju = mysql_fetch_array(mysql_query("select * from view_rkbmd where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and id_jenis_pemeliharaan = '$id_jenis_pemeliharaan' and tahun = '$this->tahun' and no_urut = '4' and jenis_anggaran ='PERUBAHAN' "));
				$jumlahYangDiSetujui = number_format($getJumlahSetuju['volume_barang'],0,'.',',');
			}

			if ($q != "0") {
				$getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
				$getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
				$outputan = $getDetailRenja[output];

				$namaKegiatan = "<td align='left' style='padding-left: 20px;' class='GarisCetak' colspan='6'>".$programKegiatan;
			}else{
				$namaProgram = "<td align='left' class='GarisCetak' colspan='6'>".$programKegiatan."</td>";
			}

			if ($q != "0") {
				$getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
				$getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
				$outputan = $getDetailRenja[output];

				$namaKegiatan = "<td align='left' style='padding-left: 20px;' class='GarisCetak' colspan='6'>".$programKegiatan;
			}else{
				$namaProgram = "<td align='left' class='GarisCetak' colspan='6'>".$programKegiatan."</td>";
			}

			if ($q == '0') {
				$naonkitu ="
                                                            <tr valign='top'>
					<td align='$align' class='GarisCetak'>$no</td>
					$namaProgram

					<td align='right' class='GarisCetak'>$b</td>
					<td align='right' class='GarisCetak'>$kb</td>
					<td align='right' class='GarisCetak'>$rb</td>
					<td align='left' class='GarisCetak'>$namaPemeliharaan</td>
					<td align='right' class='GarisCetak'>$jumlahSemula</td>
					<td align='left' class='GarisCetak'>$satuan_barang</td>
					<td align='right' class='GarisCetak'>$volBar</td>
					<td align='left' class='GarisCetak'>$satuan_barang</td>
					<td align='left' class='GarisCetak'>$alasan_perubahan</td>
					<td align='left' class='GarisCetak'>$jumlahYangDiSetujui</td>
					<td align='left' class='GarisCetak'>$satuan_barang</td>
					<td align='left' class='GarisCetak'>$catatan</td>
				    </tr>
			";
			}elseif ($q != '0' && $f == '00') {
			$naonkitu ="
                                                            <tr valign='top'>
					<td align='$align' class='GarisCetak'>$no</td>
					$namaKegiatan

					<td align='right' class='GarisCetak'>$b</td>
					<td align='right' class='GarisCetak'>$kb</td>
					<td align='right' class='GarisCetak'>$rb</td>
					<td align='left' class='GarisCetak'>$namaPemeliharaan</td>
					<td align='right' class='GarisCetak'>$jumlahSemula</td>
					<td align='left' class='GarisCetak'>$satuan_barang</td>
					<td align='right' class='GarisCetak'>$volBar</td>
					<td align='left' class='GarisCetak'>$satuan_barang</td>
					<td align='left' class='GarisCetak'>$alasan_perubahan</td>
					<td align='left' class='GarisCetak'>$jumlahYangDiSetujui</td>
					<td align='left' class='GarisCetak'>$satuan_barang</td>
					<td align='left' class='GarisCetak'>$catatan</td>
				    </tr>
			";
			}else{
				$naonkitu ="
                                                            <tr valign='top'>
					<td align='$align' class='GarisCetak'>$no</td>
					<td align='left' class='GarisCetak' >".$programKegiatan."</td>
					<td align='left' class='GarisCetak' colspan='2'>".$kodeBarang." <br> ".$namaBarang."</td>
					<td align='left' class='GarisCetak' >".$jumlahBarangDiBukuInduk."</td>
					<td align='left' class='GarisCetak' >".$satuan_barang."</td>
					<td align='center' class='GarisCetak' >$status_barang</td>
					<td align='right' class='GarisCetak'>$b</td>
					<td align='right' class='GarisCetak'>$kb</td>
					<td align='right' class='GarisCetak'>$rb</td>
					<td align='left' class='GarisCetak'>$namaPemeliharaan</td>
					<td align='right' class='GarisCetak'>$jumlahSemula</td>
					<td align='left' class='GarisCetak'>$satuan_barang</td>
					<td align='right' class='GarisCetak'>$volBar</td>
					<td align='left' class='GarisCetak'>$satuan_barang</td>
					<td align='left' class='GarisCetak'>$alasan_perubahan</td>
					<td align='left' class='GarisCetak'>$jumlahYangDiSetujui</td>
					<td align='left' class='GarisCetak'>$satuan_barang</td>
					<td align='left' class='GarisCetak'>$catatan</td>
				    </tr>
			";
			}
			echo $naonkitu;



			$no++;
			$volBar = "";
			$jumlahBarangSebelumnya = "";
			$rb = "";
			$b = "";
			$kb = "";
			$satuan_barang = "";
			$jumlahBarangDiBukuInduk = "";
			$catatan = "";
			$volBar= "";
			$status_barang= "";
			$volBar = "";
			$jumlahBarangSebelumnya = "";
			$jumlahSemula = "";
			$jumlahMenjadi = "";
			$alasan_perubahan = "";
			$programKegiatan = "";
			$kodeBarang = "";
			$namaBarang = "";
			$satuan_barang = "";
			$cara_pemenuhan = "";
			$catatan = "";
			$jumlahSemua = "";
			$jumlahBarangSemula = "";
			$cara_pemenuhanStuju = "";
			$jumlahYangDisetujui = "";
			$jumlahBarangYangDisetujui = "";
			$jumlahYangDiSetujui = "";
			$namaPemeliharaan = "";
		}
		echo 				"</table>";
		$getDataKuasaPenggunaBarang = mysql_fetch_array(mysql_query("select * from tandatangankuasapenggunabarang_v3 where c1= '$c1' and c='$c' and  d='$d' and e='$e' and e1 ='$e1'"));

		if($xls){
			echo
						"<br><div class='ukurantulisan' align='right'>
						<table align='right'>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>Kuasa Pengguna Barang</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='2'>NIP	".$getDataKuasaPenggunaBarang['nip']."</td>
						</tr>
						</table>
						</div>
				</body>
			</html>";
}else{
	if (sizeof($arrayTandaTangan9)==1) {
						$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport2['posisi'];

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

					}elseif (sizeof($arrayTandaTangan9)==2) {
						$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport2['posisi']);
            $panjangArrayPosisi = sizeof($arrayPosisi);
            $kategoriKanan = $arrayPosisi[$panjangArrayPosisi-1];
            $kategoriKiri = $arrayPosisi[$panjangArrayPosisi-2];

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

	}elseif (sizeof($arrayTandaTangan9)==3) {
						$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport2['posisi']);
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

function Pemeliharaan10($xls =FALSE){
		global $Main;

		$getJenisReport10 = mysql_fetch_array(mysql_query("SELECT * from report where url = '$this->reportURL10' "));
		$getJenisUkuran = $getJenisReport10['jenis'];
		if ($getJenisUkuran == 'L') {
			$trChild = "<script type='text/javascript' src='js/pageNumber.js'></script>";
			$width = "33cm";
			$height = "21.5cm";
		}else{
			$trChild = "<script type='text/javascript' src='js/pageNumber2.js'></script>";
			$width = "21.5cm";
			$height = "33cm";
		}
		$arrayTandaTangan10 = explode(';', $getJenisReport10['tanda_tangan']);

		$this->fileNameExcel = "HASIL PENELAAHAN RKBMD PEMELIHARAAN OLEH PENGGUNA BARANG";
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
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
		$getLastTahap = mysql_fetch_array(mysql_query("select max(id_anggaran) from view_rkbmd where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and j!='000' and (uraian_pemeliharaan !='' or uraian_pemeliharaan ='RKBMD PEMELIHARAAN') and jenis_form_modul ='KOREKSI PENGGUNA'  "));
		$lastIdAnggaran = $getLastTahap['max(id_anggaran)'];
		$getLastTahap = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran ='$lastIdAnggaran'"));
		$lastNomorUrut = "3";
		$getMinJenisForm = mysql_fetch_array(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran'"));
		if($getMinJenisForm['jenis_form_modul'] == 'PENYUSUNAN' && $this->wajibValidasi == TRUE){
				$kondisiValid = " and status_validasi = '1'";
		}

		$arrKondisi = array();
		$jenisSKPD = " and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' ";
		$grabProgram = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and (uraian_pemeliharaan ='' or uraian_pemeliharaan ='RKBMD PEMELIHARAAN' )  and p !='0' and q='0' $jenisSKPD");
		while($rows = mysql_fetch_array($grabProgram)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			}
			if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'  and uraian_pemeliharaan !=''  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and j!='000'  $jenisSKPD")) == 0){
				$concat = $bk.".".$ck.".".$dk.".".$p;
				$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p) !='$concat'";
			}else{
			$grabKegiatan = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and uraian_pemeliharaan !='RKBMD PENGADAAN'  and uraian_pemeliharaan !='RKBMD PERSEDIAAN' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q!='0' and j='000'");
				while($row2s = mysql_fetch_array($grabKegiatan)){
					foreach ($row2s as $key => $value) {
						  $$key = $value;
					}
					if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and uraian_pemeliharaan !=''  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000' $jenisSKPD ")) == 0){
						if($q != '0'){
							$concat = $bk.".".$ck.".".$dk.".".$p.".".$q;
							$arrKondisi[] = " concat(bk,'.',ck,'.',dk,'.',p,'.',q) !='$concat'";
						}
					}else{
						$grabBarang = mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'   and uraian_pemeliharaan !='RKBMD PENGADAAN'  and uraian_pemeliharaan !='RKBMD PERSEDIAAN' and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and j!='000'");
						while($row3s = mysql_fetch_array($grabBarang)){
							foreach ($row3s as $key => $value) {
								  $$key = $value;
							}
							$concat = $f.".".$g.".".$h.".".$i.".".$j;
							if(mysql_num_rows(mysql_query("select * from view_rkbmd where no_urut = '$lastNomorUrut' and jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun'  and uraian_pemeliharaan !=''  and bk='$bk' and ck='$ck' and dk='$dk' and p ='$p' and q='$q' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$concat' $jenisSKPD ")) == 0){
								if($j != '000'){
									$arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) !='$concat' ";
								}
							}
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
		$qry ="select * from view_rkbmd where id_tahap ='$this->idTahap' and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and  uraian_pemeliharaan !='RKBMD PENGADAAN' and  uraian_pemeliharaan !='RKBMD PERSEDIAAN' $this->kondisiBarang  and urut !='$c1.$c.$d.$e.$e1.0.0.0.0.0.0.00.00.00.00.000.00' $Kondisi order by urut";

		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];
		$getPenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='00' and e1='000'"));
		$penggunaBarang = $getPenggunaBarang['nm_skpd'];
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
							font-size:17px;
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

				<table class=\"rangkacetak\" style='width:33cm;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
							<table style='width: 100%; border: none; margin-bottom: 1%;'>
								<tr>
									<td>
										<img src='assets/images/kabupaten-bandung.jpeg' style='width: 100px; height: 100px;'>
									</td>
									<td style='text-align: center;'>
										<span style='font-size:18px;font-weight:bold;text-decoration: '>
					PERUBAHAAN HASIL PENELAAHAN RENCANA KEBUTUHAN PEMELIHARAAN BARANG MILIK DAERAH<br>
					(PERUBAHAAN RENCANA PEMELIHARAAN)<br>
					KUASA PENGUNA BARANG ".strtoupper($kuasaPenggunaBarang)."
										</span>
									</td>
									<td style='width: 9%;'>
							<span class='ukurantulisanIdPenerimaan'>TAHUN : $this->tahun </span></div><br>
									</td>
								</tr>
							</table>

					<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
								<thead>
									<tr>
										<th class='th01' rowspan='3' style='width:20px;' >NO</th>
										<th class='th01' rowspan='3' >PROGRAM/KEGIATAN/OUTPUT</th>
										<th class='th02' rowspan='1' colspan='8' >BARANG YANG DIPELIHARA</th>
										<th class='th01' rowspan='3' >NAMA PEMELIHARAAN</th>
										<th class='th02' rowspan='1' colspan='2' >SEMULA</th>
										<th class='th02' rowspan='1' colspan='2' >MENJADI</th>
										<th class='th02' rowspan='1' colspan='2' >RENCANA KEBUTUHAN PEMELIHARAAN BMD YANG DISETUJUI</th>
										<th class='th01' rowspan='3' >KETERANGAN</th>
									</tr>
									<tr>
										<th class='th01' rowspan='2' colspan='2'>KODE / NAMA BARANG</th>
										<th class='th01' rowspan='2' >JUMLAH</th>
										<th class='th01' rowspan='2' >SATUAN</th>
										<th class='th01' rowspan='2' >STATUS BARANG</th>
										<th class='th02' rowspan='1' colspan='3' >KONDISI BARANG</th>

										<th class='th01' rowspan='2' >JUMLAH</th>
										<th class='th01' rowspan='2' >SATUAN</th>
										<th class='th01' rowspan='2' >JUMLAH</th>
										<th class='th01' rowspan='2' >SATUAN</th>
										<th class='th01' rowspan='2' >JUMLAH</th>
										<th class='th01' rowspan='2' >SATUAN</th>


									</tr>
									<tr>
										<th class='th01' rowspan='1' >B</th>
										<th class='th01' rowspan='1' >KB</th>
										<th class='th01' rowspan='1' >RB</th>
									</tr>
							</thead>
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
				$getNamaPemeliharaan = mysql_fetch_array(mysql_query("select * from ref_jenis_pemeliharaan where Id = '$id_jenis_pemeliharaan'"));
				$namaPemeliharaan = $getNamaPemeliharaan['jenis'];
				$getJumlahB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='1'"));
				$b =  number_format($getJumlahB['jml_barang'],0,'.',',');
				$getJumlahKB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='2'"));
				$kb =  number_format($getJumlahKB['jml_barang'],0,'.',',');
				$getJumlahRB = mysql_fetch_array(mysql_query("select * from buku_induk where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j'  and status_barang ='1' and kondisi='3'"));
				$rb =  number_format($getJumlahRB['jml_barang'],0,'.',',');
				$jumlahBarangDiBukuInduk = $getJumlahB['jml_barang'] + $getJumlahKB['jml_barang'] + $getJumlahRB['jml_barang'];
				$status_barang = "MILIK";
				$nomorurutSebelumnya = $lastNomorUrut -1 ;
				$getJumlahBarangSebelumnya = mysql_fetch_array(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and uraian_pemeliharaan = '$uraian_pemeliharaan' and no_urut='$nomorurutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
				$jumlahBarangSebelumnya = number_format($getJumlahBarangSebelumnya['volume_barang'],0,'.',',');
				//$jumlahBarangSebelumnya = "select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and uraian_pemeliharaan = '$uraian_pemeliharaan' and no_urut='$nomorurutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'";
				$getJumlahSemula = mysql_fetch_array(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and no_urut = '5' and jenis_anggaran ='MURNI' and tahun ='$this->tahun' "));
				$jumlahSemula = number_format($getJumlahSemula['volume_barang'],0,'.',',');
				$getJumlahSetuju = mysql_fetch_array(mysql_query("select * from view_rkbmd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk ='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' and f='$f' and g='$g' and h='$h' and i='$i' and j ='$j' and id_jenis_pemeliharaan ='$id_jenis_pemeliharaan' and no_urut = '4' and jenis_anggaran ='PERUBAHAN' and tahun ='$this->tahun' "));
				$jumlahSetuju = number_format($getJumlahSetuju['volume_barang'],0,'.',',');
			}


						if ($q != "0") {
				$getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
				$getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
				$outputan = $getDetailRenja[output];

				$namaKegiatan = "<td align='left' style='padding-left: 20px;' class='GarisCetak' colspan='5'>".$programKegiatan;
			}else{
				$namaProgram = "<td align='left' class='GarisCetak' colspan='5'>".$programKegiatan."</td>";
			}

			if ($q != "0") {
				$getIdRenja = mysql_fetch_array(mysql_query("SELECT * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$c1' and c = '$c' and d = '$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and q = '$q' "));
				$getDetailRenja = mysql_fetch_array(mysql_query("SELECT * from detail_renja where id_anggaran = '".$getIdRenja[id_anggaran]."' "));
				$outputan = $getDetailRenja[output];

				$namaKegiatan = "<td align='left' style='padding-left: 20px;' class='GarisCetak' colspan='5'>".$programKegiatan;
			}else{
				$namaProgram = "<td align='left' class='GarisCetak' colspan='5'>".$programKegiatan."</td>";
			}

			if ($q == '0') {
				$naonkitu ="
					<tr valign='top'>
						<td align='$align' class='GarisCetak'>$no</td>
						$namaProgram
						<td align='center' class='GarisCetak' >$status_barang</td>
						<td align='right' class='GarisCetak'>$b</td>
						<td align='right' class='GarisCetak'>$kb</td>
						<td align='right' class='GarisCetak'>$rb</td>
						<td align='left' class='GarisCetak'>$namaPemeliharaan</td>
						<td align='right' class='GarisCetak'>$jumlahSemula</td>
						<td align='left' class='GarisCetak'>$satuan_barang</td>
						<td align='right' class='GarisCetak'>$volBar</td>
						<td align='left' class='GarisCetak'>$satuan_barang</td>
						<td align='right' class='GarisCetak'>$jumlahSetuju</td>
						<td align='left' class='GarisCetak'>$satuan_barang</td>
						<td align='left' class='GarisCetak'>$catatan</td>
					</tr>
			";
			}elseif ($q != '0' && $f == '00') {
			$naonkitu ="
					<tr valign='top'>
						<td align='$align' class='GarisCetak'>$no</td>
						$namaKegiatan
						<td align='center' class='GarisCetak' >$status_barang</td>
						<td align='right' class='GarisCetak'>$b</td>
						<td align='right' class='GarisCetak'>$kb</td>
						<td align='right' class='GarisCetak'>$rb</td>
						<td align='left' class='GarisCetak'>$namaPemeliharaan</td>
						<td align='right' class='GarisCetak'>$jumlahSemula</td>
						<td align='left' class='GarisCetak'>$satuan_barang</td>
						<td align='right' class='GarisCetak'>$volBar</td>
						<td align='left' class='GarisCetak'>$satuan_barang</td>
						<td align='right' class='GarisCetak'>$jumlahSetuju</td>
						<td align='left' class='GarisCetak'>$satuan_barang</td>
						<td align='left' class='GarisCetak'>$catatan</td>
					</tr>
			";
			}else{
				$naonkitu ="
					<tr valign='top'>
						<td align='$align' class='GarisCetak'>$no</td>
						<td align='left' class='GarisCetak' >".$programKegiatan."</td>
						<td align='left' class='GarisCetak' colspan='2'>".$kodeBarang." <br> ".$namaBarang."</td>
						<td align='left' class='GarisCetak' >".$jumlahBarangDiBukuInduk."</td>
						<td align='left' class='GarisCetak' >".$satuan_barang."</td>
						<td align='center' class='GarisCetak' >$status_barang</td>
						<td align='right' class='GarisCetak'>$b</td>
						<td align='right' class='GarisCetak'>$kb</td>
						<td align='right' class='GarisCetak'>$rb</td>
						<td align='left' class='GarisCetak'>$namaPemeliharaan</td>
						<td align='right' class='GarisCetak'>$jumlahSemula</td>
						<td align='left' class='GarisCetak'>$satuan_barang</td>
						<td align='right' class='GarisCetak'>$volBar</td>
						<td align='left' class='GarisCetak'>$satuan_barang</td>
						<td align='right' class='GarisCetak'>$jumlahSetuju</td>
						<td align='left' class='GarisCetak'>$satuan_barang</td>
						<td align='left' class='GarisCetak'>$catatan</td>
					</tr>
			";
			}
			echo $naonkitu;



			$no++;

			$volBar = "";
			$jumlahBarangSebelumnya = "";
			$rb = "";
			$b = "";
			$kb = "";
			$satuan_barang = "";
			$jumlahBarangDiBukuInduk = "";
			$catatan = "";
			$volBar= "";
			$status_barang= "";
			$namaPemeliharaan = "";
			$jumlahSemula = "";
			$jumlahSetuju = "";





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
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>Kuasa Pengguna Barang</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>&nbsp</td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'><u>".$getDataKuasaPenggunaBarang['nama']."</u></td>
						</tr>
						<tr>
						<td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td >&nbsp</td><td colspan='3'>NIP	".$getDataKuasaPenggunaBarang['nip']."</td>
						</tr>
						</table>
						</div>
				";
		echo "	<div >
					<div>Telah Diperiksa : </div>
					<table table width='100%' class='cetak' border='1' style='margin-left:90px;width:50%;'>
						<tr>
							<th class='th01'>No</th>
							<th class='th01'>Nama</th>
							<th class='th01'>Jabatan</th>
							<th class='th01'>TTD / Paraf</th>
							<th class='th01' >Tanggal</th>
						</tr>
						<tr>
							<td align='$align' class='GarisCetak' >1.</td>
							<td align='left' class='GarisCetak' >".$getDataPejabatPenggunaBarang['nama']."</td>
							<td align='left' class='GarisCetak' >Pejabat Penatausahaan Pengguna Barang</td>
							<td align='left' class='GarisCetak' >&nbsp</td>
							<td align='left' class='GarisCetak' >".VulnWalkerTitiMangsa(date('Y-m-d'))."</td>
						</tr>
						<tr>
							<td align='$align' class='GarisCetak' >2.</td>
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
	if (sizeof($arrayTandaTangan10)==1) {
						$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = $getJenisReport2['posisi'];

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

	}elseif (sizeof($arrayTandaTangan10)==2) {
						$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport2['posisi']);
            $panjangArrayPosisi = sizeof($arrayPosisi);
            $kategoriKanan = $arrayPosisi[$panjangArrayPosisi-1];
            $kategoriKiri = $arrayPosisi[$panjangArrayPosisi-2];

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

	}elseif (sizeof($arrayTandaTangan10)==3) {
						$c1 = $_GET[urusan]; $c = $_GET[bidang]; $d = $_GET[skpd]; $e = $_GET[unit]; $e1 = $_GET[subunit];
            $arrayPosisi = explode(';', $getJenisReport2['posisi']);
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
                                                                   <br><br><br><br><br><br><br><br><br><br><br><div >
					<div style='margin-left:-453px;width:50%;text-align: right;' >Telah Diperiksa : </div>
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

function excel($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 800;
	 $this->form_height = 80;
	 $this->form_caption = 'LAPORAN RKBMD PEMELIHARAAN';
	 $c1 = $dt['rkbmdPemeliharaanPerubahan_v3SkpdfmUrusan'];
	 $c = $dt['rkbmdPemeliharaanPerubahan_v3SkpdfmSKPD'];
	 $d = $dt['rkbmdPemeliharaanPerubahan_v3SkpdfmUNIT'];
	 $e = $dt['rkbmdPemeliharaanPerubahan_v3SkpdfmSUBUNIT'];
	 $e1 = $dt['rkbmdPemeliharaanPerubahan_v3SkpdfmSEKSI'];


	 	 $arrayJenisLaporan = array(
	 						   array('Pemeliharaan8', 'PERUBAHAN USULAN RKBMD PEMELIHARAAN PADA KUASA PENGGUNA BARANG'),
							   array('Pemeliharaan10', 'PERUBAHAN HASIL PENELAAHAN RKBMD PEMELIHARAAN OLEH PENGGUNA BARANG'),
							   array('Pemeliharaan9', 'PERUBAHAN RKBMD PEMELIHARAAN PADA KUASA PENGGUNA BARANG'),

							   );


	  $cmbJenisLaporan = cmbArray('jenisKegiatan','',$arrayJenisLaporan,'-- JENIS LAPORAN --',"onchange = $this->Prefix.jenisChanged();");
	  $this->form_fields = array(
			'jenisLaporan' => array(
						'label'=>'JENIS LAPORAN',
						'labelWidth'=>100,
						'value'=> $cmbJenisLaporan
						 )

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
$rkbmdPemeliharaanPerubahan_v3 = new rkbmdPemeliharaanPerubahan_v3Obj();
$arrayResult = tahapPerencanaanV3($rkbmdPemeliharaanPerubahan_v3->modul,"PERUBAHAN");
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = "PERUBAHAN";
$idTahap = $arrayResult['idTahap'];

$rkbmdPemeliharaanPerubahan_v3->jenisForm = $jenisForm;
$rkbmdPemeliharaanPerubahan_v3->nomorUrut = $nomorUrut;
$rkbmdPemeliharaanPerubahan_v3->urutTerakhir = $nomorUrut;
$rkbmdPemeliharaanPerubahan_v3->tahun = $tahun;
$rkbmdPemeliharaanPerubahan_v3->jenisAnggaran = $jenisAnggaran;
$rkbmdPemeliharaanPerubahan_v3->idTahap = $idTahap;
$rkbmdPemeliharaanPerubahan_v3->username = $_COOKIE['coID'];
$rkbmdPemeliharaanPerubahan_v3->wajibValidasi =  $arrayResult['wajib_validasi'];
if($rkbmdPemeliharaanPerubahan_v3->wajibValidasi == TRUE){
	$rkbmdPemeliharaanPerubahan_v3->sqlValidasi = " and status_validasi ='1' ";
}else{
	$rkbmdPemeliharaanPerubahan_v3->sqlValidasi = " ";
}

$rkbmdPemeliharaanPerubahan_v3->provinsi = $arrayResult['provinsi'];
$rkbmdPemeliharaanPerubahan_v3->kota = $arrayResult['kota'];
$rkbmdPemeliharaanPerubahan_v3->pengelolaBarang = $arrayResult['pengelolaBarang'];
$rkbmdPemeliharaanPerubahan_v3->pejabatPengelolaBarang = $arrayResult['pejabat'];
$rkbmdPemeliharaanPerubahan_v3->pengurusPengelolaBarang = $arrayResult['pengurus'];
$rkbmdPemeliharaanPerubahan_v3->nipPengelola = $arrayResult['nipPengelola'];
$rkbmdPemeliharaanPerubahan_v3->nipPengurus = $arrayResult['nipPengurus'];
$rkbmdPemeliharaanPerubahan_v3->nipPejabat = $arrayResult['nipPejabat'];
$rkbmdPemeliharaanPerubahan_v3->settingAnggaran = $arrayResult['settingAnggaran'];


?>
