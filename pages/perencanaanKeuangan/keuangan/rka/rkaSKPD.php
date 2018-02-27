<?php

class rkaSKPDObj  extends DaftarObj2{
	var $Prefix = 'rkaSKPD';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'tabel_anggaran'; //bonus
	var $TblName_Hapus = 'tabel_anggaran';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id_anggaran');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 4, 4, 4);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 2;
	var $PageTitle = 'RKA-SKPD';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='rkaSKPD.xls';
	var $namaModulCetak='RKA';
	var $Cetak_Judul = 'RKA';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'rkaSKPDForm';
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

	function setTitle(){
		return 'RKA-SKPD  '.$this->jenisAnggaran.' TAHUN '.$this->tahun ;
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

	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";


		return $listMenu ;
	}
	function genRowSum($ColStyle, $Mode, $Total){
		foreach ($_REQUEST as $key => $value) {
		  	$$key = $value;
		 }
		if($cmbSKPD != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
		}elseif($cmbBidang != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
		}elseif($cmbUrusan != ''){
			$kondisiSKPD = "and c1='$cmbUrusan'";
		}
	 	/*if(!empty($cmbBelanja)){
				if($cmbBelanja == "BELANJA PEGAWAI"){
					$kondisiRekening = "and k='5' and l ='2' and m ='1'";
				}elseif($cmbBelanja == "BELANJA BELANJA BARANG & JASA"){
					$kondisiRekening = "and k='5' and l ='2' and m ='2'";
				}elseif($cmbBelanja == "BELANJA MODAL"){
					$kondisiRekening = "and k='5' and l ='2' and m ='3'";
				}

		}*/

		if(!empty($this->jenisForm)){
			$idTahap = $this->idTahap;
		}else{
			$getIdTahapRKATerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from tabel_anggaran where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and jenis_rka !=''  and (rincian_perhitungan !='' or j !='000' ) and nama_modul = 'RKA-SKPD' "));
		 	$idTahap = $getIdTahapRKATerakhir['max'];
		}

		$getData = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or j !='000' ) and id_tahap='$idTahap' and tahun ='$this->tahun' and nama_modul='RKA-SKPD' and jenis_anggaran = '$this->jenisAnggaran' $kondisiSKPD $kondisiRekening"));
		$Total = $getData['sum(jumlah_harga)'];
		$ContentTotalHal=''; $ContentTotal='';
			$TampilTotalHalRp = number_format($this->SumValue[0],2, ',', '.');
			$TotalColSpan1 = $this->FieldSum_Cp1[$Mode-1];//$Mode ==1 ? 5 : 4;
			$TotalColSpan2 = $this->FieldSum_Cp2[$Mode-1];//$Mode ==1 ? 5 : 4;
			$Kiri2 = $TotalColSpan1 > 0 ? "<td class='$ColStyle' colspan='2' align='center'><b>Total</td>": '';
				$ContentTotal =
				"<tr>
					$Kiri2
					<td class='GarisDaftar' align='right'><b><div >".number_format($this->totalSum,2,',','.')."</div></td>
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

	$getJumlahBarang = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$rkaSKPD_idplh'"));
	$jumlahBarang = $getJumlahBarang['volume_barang'];
	$total = $hargaSatuan * $jumlahBarang;

	/* $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja "));
  	 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
	$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));*/
	$getPaguYangTelahTerpakai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and no_urut = '$this->nomorUrut' and id_anggaran!='$rkaSKPD_idplh' "));
	$sisaPaguIndikatif = $paguIndikatif - $getPaguYangTelahTerpakai['paguYangTerpakai'];

	 if(mysql_num_rows(mysql_query("select * from view_rka where c1='0' and f1 = '0' and k = '$k' and l ='$l' and m='$m' and n='$n' and o='$o'  and id_tahap='$this->idTahap' ")) > 0){

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
		$query = VulnWalkerUpdate('tabel_anggaran',$data,"id_anggaran = '$rkaSKPD_idplh'");
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
				if(mysql_num_rows(mysql_query("select * from skpd_report_rka where username= '$this->username'")) == 0){
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD

								  );
					$query = VulnWalkerInsert('skpd_report_rka',$data);
					mysql_query($query);
				}else{
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD


								  );
					$query = VulnWalkerUpdate('skpd_report_rka',$data,"username = '$this->username'");
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
 <A href=\"pages.php?Pg=rkaSKPD221\" title='BELANJA' > BELANJA </a> |
 <A href=\"pages.php?Pg=rkaSKPD1PAD\" title='PENDAPATAN' > PENDAPATAN </a> |
 <A href=\"pages.php?Pg=rkaSKPD31\" title='RKA-SKPKD MURNI' > PEMBIAYAAN </a> |
 <A href=\"pages.php?Pg=rkaSKPD\" title='RKA-SKPKD MURNI' style='color:blue;'  > RKA-SKPD  </a>
 &nbsp&nbsp&nbsp
 </td></tr>
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
			<script type='text/javascript' src='js/perencanaan_v2/rka/popupBarang.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaan_v2/rka/popupRekening.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/rka/rkaSKPD.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/rka/rkaSKPDNew.js' language='JavaScript' ></script>
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
		 $kodeBarang = $f1.".".$f2.".".$f.".".$g.".".$h.".".$i.".".$j ;
		 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
		 $namaBarang = $getNamaBarang['nm_barang'];
		 $kodeRekening = $k.".".$l.".".$m.".".$n.".".$o ;
		 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
		 $namaRekening = $getNamaRekening['nm_rekening'];
		 $arrayJenisRKA = array(
						array(".1","RKA-SKPD "),
						array("2.1","RKA-SKPD 2.1")

						);
		 $jenis_rka = $jenis_rka;
		 $cmbJenisRKA = cmbArray('cmbJenisRKAForm',$jenis_rka,$arrayJenisRKA,'-- JENIS RKA --','onchange=rkaSKPD.unlockFindRekening();');
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
						 <button type='button' id='findRekening' onclick=rkaSKPD.findRekening('$jenis_rka'); $tergantungJenis> CARI </button> "
						 ),
			'kode8' => array(
						'label'=>'HARGA SATUAN',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='rkaSKPD.bantu();' > <span id='bantu' style='color:red;'> </span>"
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


		 $arrayResult = VulnWalkerTahap_v2($this->modul);
		 $jenisForm = $arrayResult['jenisForm'];
		 $nomorUrut = $arrayResult['nomorUrut'];
		 $tahun = $arrayResult['tahun'];
		 $jenisAnggaran = $arrayResult['jenisAnggaran'];
		 $id_tahap = $arrayResult['id_tahap'];

		$headerTable =
		  "<thead>
		   <tr>
		   <th class='th01' width='50'  rowspan='1' >KODE</th>
		   <th class='th01' width='1200'  rowspan='1' >URAIAN</th>
		   <th class='th01'  rowspan='1' width='150' >JUMLAH</th>
		   $tergantungJenisForm

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
	if(!empty($this->idTahap)){
			    $kondisiFilter = " and id_tahap = '$this->idTahap' ";
				if($this->jenisForm == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
					$kondisiFilter = $kondisiFilter." and status_validasi ='1' ";
				}
			}else{
				 $getIdTahapTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) from tabel_anggaran where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'RKA-SKPD'"));
				 $idTahapTerakhir = $getIdTahapTerakhir['max(id_tahap)'];
				 $kondisiFilter = " and id_tahap = '$idTahapTerakhir' ";
					if($this->jenisFormTerakhir == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
						$kondisiFilter = $kondisiFilter." and status_validasi ='1' ";
					}
			}
	$getTotalPerrekening = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'RKA-SKPD'"));
	$total = $getTotalPerrekening['sum(jumlah_harga)'];

	$getTotalLevel4 = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where k='$k' and l='$l' and m='$m' and n='$n'  $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'RKA-SKPD'"));
	$totalLevel4 = $getTotalLevel4['sum(jumlah_harga)'];

	$getTotalLevel3 = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where k='$k' and l='$l' and m='$m'  $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'RKA-SKPD'"));
	$totalLevel3 = $getTotalLevel3['sum(jumlah_harga)'];

	$getTotalLevel2 = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where k='$k' and l='$l'  $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'RKA-SKPD'"));
	$totalLevel2 = $getTotalLevel2['sum(jumlah_harga)'];


	$getTotalLevel1 = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where k='$k'  $kondisiSKPD $kondisiFilter  and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'RKA-SKPD'"));
	$totalLevel1 = $getTotalLevel1['sum(jumlah_harga)'];

	 // $Koloms = array();
   //
		//  $Koloms[] = array('align="center"', $no.'.' );
		//  $kodeRekekening = $k.".".$l.".".$m.".".$n.".".$o;
		//  $Koloms[] = array('align="center"', $kodeRekekening );
		//  $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening  where k = '$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
		//  $Koloms[] = array('align="left"', $getNamaRekening['nm_rekening'] );
   //
   //
		//  $Koloms[] = array('align="right"', number_format($total,2,',','.') );
		//  $this->sumTotal += $total;
   //
   //
   //
   //
	 // return $Koloms;



					 $boldStatus = "bold";
					 $marginStatus = "20px;";

					 $marginKode = "10px;";
					 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l = '0' and m='0' and n='00' and o='000'"));
					 $getNamaRekening2 = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l = '$l' and m='0' and n='00' and o='000'"));
					 $getNamaRekening3 = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l = '$l' and m='$m' and n='00' and o='000'"));
					 $getNamaRekening4 = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l = '$l' and m='$m' and n='$n' and o='000'"));
					 $getNamaRekening5 = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l = '$l' and m='$m' and n='$n' and o='$o'"));
					 if(mysql_num_rows(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'")) == 0){
						 $uraianList = "<span style='color:red;cursor:pointer' class='uraianList' id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>Belanja xxx</span>";
						 $kode = "<span style='color:red;'>x.x.x.xx.xxx</span>";
					 }else{
						 $kode = $k.".".$l.".".$m.".".$n.".".$o;
						 // $uraianList = $getNamaRekening['nm_rekening'];
						 $uraianList = "<span style='cursor:pointer' class='uraianList'  id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>".$getNamaRekening['nm_rekening']."</span>";
						 $uraianList2 = "<span style='cursor:pointer' class='uraianList'  id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>".$getNamaRekening2['nm_rekening']."</span>";
						 $uraianList3 = "<span style='cursor:pointer' class='uraianList'  id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>".$getNamaRekening3['nm_rekening']."</span>";
						 $uraianList4 = "<span style='cursor:pointer' class='uraianList'  id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>".$getNamaRekening4['nm_rekening']."</span>";
						 $uraianList5 = "<span style='cursor:pointer' class='uraianList'  id='spanEditRekening$id_anggaran' onclick=$this->Prefix.editRekening($id_anggaran);>".$getNamaRekening5['nm_rekening']."</span>";
					 }

					 $TampilCheckBox = "";

					 // $getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_2_2_1 where id_tahap = '$this->idTahap' and bk='$bk' and ck='$ck' and dk='$dk' and p='$p' $kondisiSKPD $kondisiRekening"));
					 // $jumlahHarga = number_format($getSumJumlahHarga['sum(jumlah_harga)'] ,2,',','.');



						 $rekeningLevel1 = "
							 <tr class='row0' valign='top'>
								 <td align='left' class='GarisDaftar'  ><b>".$k."</td>
								 <td align='left' class='GarisDaftar'  style='font-weight: bold; padding-left: 10px;'>".$uraianList."</td>
								 <td align='right' class='GarisDaftar'  ><b>".number_format($totalLevel1,2,',','.')."</td>
							 </tr>
						 ";

						 $rekeningLevel2 = "
										 <tr class='row0'  valign='top'>
											 <td align='left' class='GarisDaftar' ><b>".$k.".".$l."</td>
											 <td align='left' class='GarisDaftar' style='font-weight: bold; padding-left: 15px;'>".$uraianList2."</td>
											 <td align='right' class='GarisDaftar' ><b>".number_format($totalLevel2,2,',','.')."</td>
										 </tr>
						 ";

						 $rekeningLevel3 = "
										 <tr class='row0'  valign='top'>
											 <td align='left' class='GarisDaftar' ><b>".$k.".".$l.".".$m."</td>
											 <td align='left' class='GarisDaftar' style='font-weight: bold; padding-left: 20px;'>".$uraianList3."</td>
											 <td align='right' class='GarisDaftar' ><b>".number_format($totalLevel3,2,',','.')."</td>
										 </tr>
						 ";

						 $rekeningLevel4 = "
										 <tr class='row0'  valign='top'>
											 <td align='left' class='GarisDaftar' ><b>".$k.".".$l.".".$m.".".$n."</td>
											 <td align='left' class='GarisDaftar' style='font-weight: bold; padding-left: 25px;'>".$uraianList4."</td>
											 <td align='right' class='GarisDaftar' ><b>".number_format($totalLevel4,2,',','.')."</td>
										 </tr>
						 ";

						 if (in_array($k, $this->arrayRekening1)) {
							 $rekeningLevel1 = "";
						 }
						 $concatRekeningLevel2 = $k.".".$l;
						 if (in_array($concatRekeningLevel2, $this->arrayRekening2)) {
							 $rekeningLevel2 = "";
						 }
						 $concatRekeningLevel3 = $k.".".$l.".".$m;
						 if (in_array($concatRekeningLevel3, $this->arrayRekening3)) {
							 $rekeningLevel3 = "";
						 }
						 $concatRekeningLevel4 = $k.".".$l.".".$m.".".$n;
						 if (in_array($concatRekeningLevel4, $this->arrayRekening4)) {
							 $rekeningLevel4 = "";
						 }

						 $naonkitu = "
										 <tr class='row0'  valign='top'>
											 <td align='left' class='GarisDaftar' >".$kode."</td>
											 <td align='left' class='GarisDaftar' style=' padding-left: 30px;'>".$uraianList5."</td>
											 <td align='right' class='GarisDaftar' >".number_format($total,2,',','.')."</td>
										 </tr>
						 ";
						 $this->totalSum += $total;








	$Koloms = array(
		array("VulnWalker", $rekeningLevel1.$rekeningLevel2.$rekeningLevel3.$rekeningLevel4.$naonkitu),
	 );
	 $this->arrayRekening1[] = $k;
	 $this->arrayRekening2[] = $k.".".$l;
	 $this->arrayRekening3[] = $k.".".$l.".".$m;
	 $this->arrayRekening4[] = $k.".".$l.".".$m.".".$n;

	 return $Koloms;
	}


	function Validasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI RKA-SKPD ';
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
						'label'=>'KODE rkaSKPD',
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
		$urusan = cmbQuery('cmbUrusan',$selectedC1,$codeAndNameUrusan,'onchange=rkaSKPD.refreshList(true);','-- URUSAN --');

		$codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c !='00' and d='00' and e='00' and e1='000' ";
		$bidang = cmbQuery('cmbBidang',$selectedC,$codeAndNameBidang,'onchange=rkaSKPD.refreshList(true);','-- BIDANG --');

		$codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d!='00' and e='00' and e1='000' ";
		$skpd= cmbQuery('cmbSKPD',$selectedD,$codeAndNameSKPD,'onchange=rkaSKPD.refreshList(true);','-- SKPD --');

		$codeAndNameUnit = "select e, concat(e, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e!='00' and e1='000' ";
		$unit = cmbQuery('cmbUnit',$selectedE,$codeAndNameUnit,'onchange=rkaSKPD.refreshList(true);','-- UNIT --');


		$codeAndNameSubUnit = "select e1, concat(e1, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1!='000' ";
		$subunit = cmbQuery('cmbSubUnit',$selectedE1,$codeAndNameSubUnit,'onchange=rkaSKPD.refreshList(true);','-- SUB UNIT --');






	if($this->jenisForm == "KOREKSI" || $this->jenisForm == "PENYUSUNAN" || $this->jenisForm == "VALIDASI"){
		$getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		$idTahapRenja = $getIdTahapRenjaTerakhir['max'];
		$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
		$angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');

		$getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$this->idTahap'  "));
		$sisaPagu = $getPaguIndikatif['jumlah'] - $getPaguYangTerpakai['paguYangTerpakai'];
		$sisaPagu =  number_format($sisaPagu ,2,',','.');
		$paguIndikatif = "<input type='text' value='$angkaPaguIndikatif' readonly> &nbsp &nbsp &nbsp SISA PAGU  :  <input type='text' value='$sisaPagu' readonly>";

	}else{
		$getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		$idTahapRenja = $getIdTahapRenjaTerakhir['max'];
		$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
		$angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');

		$getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and no_urut = '$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  "));
		$sisaPagu = $getPaguIndikatif['jumlah'] - $getPaguYangTerpakai['paguYangTerpakai'];
		$sisaPagu =  number_format($sisaPagu ,2,',','.');
		$paguIndikatif = "<input type='text' value='$angkaPaguIndikatif' readonly> &nbsp &nbsp &nbsp SISA PAGU  :  <input type='text' value='$sisaPagu' readonly>";

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

			<input type='hidden' name='tahun' id='tahun' value='$this->tahun' style='width:40px;' > <input type='hidden' name ='cmbJenisRKA' id='cmbJenisRKA' value=''>



			</table>"

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
		$blackListSubRincian = array();
		$getAllSubRincian = mysql_query("select * from tabel_anggaran where id_tahap = '$this->idTahap' and (j!='000' or rincian_perhitungan !='' )");
		while($subRincian = mysql_fetch_array($getAllSubRincian)){
					if(mysql_num_rows(mysql_query("select * from tabel_anggaran where id_tahap = '$this->idTahap' and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening")) == 0){
							$blackListSubRincian[] = "id_anggaran != '".$subRincian['id_anggaran']."'";
							$arrKondisi[] = "id_anggaran !='".$subRincian['id_anggaran']."'";
							// $this->injectQuery = "select * from tabel_anggaran where id_tahap = '$this->idTahap' and id_anggaran='".$subRincian['id_anggaran']."' and (j!='000' or rincian_perhitungan !='' ) $kondisiSKPD $kondisiRekening";
					}
		}
		$kondisiBlackListSubRincian= join(' and ',$blackListSubRincian);
		if(sizeof($blackListSubRincian) == 0){
			$kondisiBlackListSubRincian = "";
		}elseif(sizeof($blackListSubRincian) > 0){
			$kondisiBlackListSubRincian = " and ".$kondisiBlackListSubRincian;
		}
		$blackListRincian = array();
		$getAllRincian =  mysql_query("select * from tabel_anggaran where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja != '' and id_rincian_belanja !='0' and j='000' and rincian_perhitungan = '' ");
		while($rincianBelanja = mysql_fetch_array($getAllRincian)){
				if(mysql_num_rows(mysql_query("select  * from tabel_anggaran where id_tahap = '$this->idTahap' and bk = '".$rincianBelanja['bk']."' and ck = '".$rincianBelanja['ck']."' and dk = '".$rincianBelanja['dk']."' and p = '".$rincianBelanja['p']."' and q = '".$rincianBelanja['q']."' and k = '".$rincianBelanja['k']."' and l = '".$rincianBelanja['l']."'  and m = '".$rincianBelanja['m']."'  and n = '".$rincianBelanja['n']."' and o = '".$rincianBelanja['o']."' and id_rincian_belanja = '".$rincianBelanja['id_rincian_belanja']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
						$blackListRincian[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
						$arrKondisi[] = "id_anggaran !='".$rincianBelanja['id_anggaran']."'";
				}

		}

		$blackListRekening = array();
		$getAllRekening =  mysql_query("select * from tabel_anggaran where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k !='0' and k!=''  and l !='0' and l!=''  and m !='0' and m!=''  and n !='0' and n !='' and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
		while($rekeningBelanja = mysql_fetch_array($getAllRekening)){
				if(mysql_num_rows(mysql_query("select  * from tabel_anggaran where id_tahap = '$this->idTahap' and bk = '".$rekeningBelanja['bk']."' and ck = '".$rekeningBelanja['ck']."' and dk = '".$rekeningBelanja['dk']."' and p = '".$rekeningBelanja['p']."' and q = '".$rekeningBelanja['q']."' and k = '".$rekeningBelanja['k']."' and l = '".$rekeningBelanja['l']."'  and m = '".$rekeningBelanja['m']."'  and n = '".$rekeningBelanja['n']."' and o = '".$rekeningBelanja['o']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
						$blackListRekening[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
						$arrKondisi[] = "id_anggaran !='".$rekeningBelanja['id_anggaran']."'";
				}
		}
		$blackListKegiatan = array();
		$getAllKegiatan =  mysql_query("select * from tabel_anggaran where id_tahap ='$this->idTahap' and p != '0' and q !='0' and k ='0' and l ='0'  and m ='0'   and n ='0'  and id_rincian_belanja ='' and j='000' and rincian_perhitungan = '' ");
		while($kegiatanBelanja = mysql_fetch_array($getAllKegiatan)){
				if(mysql_num_rows(mysql_query("select * from tabel_anggaran where id_tahap ='$this->idTahap' and bk = '".$kegiatanBelanja['bk']."' and ck = '".$kegiatanBelanja['ck']."' and dk = '".$kegiatanBelanja['dk']."' and p = '".$kegiatanBelanja['p']."' and q = '".$kegiatanBelanja['q']."' and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
						$blackListKegiatan[] = "id_anggaran !='".$kegiatanBelanja['id_anggaran']."'";
						$arrKondisi[] = "id_anggaran !='".$kegiatanBelanja['id_anggaran']."'";
				}
		}
		$blackListKegiatan = array();
		$getAllProgram =  mysql_query("select * from tabel_anggaran where id_tahap ='$this->idTahap' and p != '0' and q ='0'  ");
		while($programBelanja = mysql_fetch_array($getAllProgram)){
				if(mysql_num_rows(mysql_query("select * from tabel_anggaran where id_tahap ='$this->idTahap' and bk = '".$programBelanja['bk']."' and ck = '".$programBelanja['ck']."' and dk = '".$programBelanja['dk']."' and p = '".$programBelanja['p']."'  and (j!='000' or rincian_perhitungan !='') $kondisiBlackListSubRincian ")) == 0){
						$arrKondisi[] = "id_anggaran !='".$programBelanja['id_anggaran']."'";
						$arrKondisi[] = "id_anggaran !='".$programBelanja['id_anggaran']."'";
				}
		}

		$arrKondisi[] = "id_rincian_belanja ='' and rincian_perhitungan = ''";
		$arrKondisi[] = "k !='0' and k!=''";
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
		//$arrOrders[] = "urut, rincian_perhitungan  asc";
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



		$arrKondisi = array();
		$grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_rka where username='$this->username'"));
		foreach ($grabSKPD as $key => $value) {
				  $$key = $value;
			}
		$cmbUrusan = $c1;
		$cmbBidang = $c;
		$cmbSKPD = $d;
		$cmbUnit = $e;
		$cmbSubUnit = $e1;

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



		if(!empty($this->idTahap)){
			    $kondisiFilter = " and id_tahap = '$this->idTahap' ";
				if($this->jenisForm == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
					$kondisiFilter = $kondisiFilter." and status_validasi ='1' ";
				}
			}else{
				 $getIdTahapTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) from tabel_anggaran where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'RKA-SKPD'"));
				 $idTahapTerakhir = $getIdTahapTerakhir['max(id_tahap)'];
				 $kondisiFilter = " and id_tahap = '$idTahapTerakhir' ";
					if($this->jenisFormTerakhir == "PENYUSUNAN" && $this->wajibValidasi == TRUE){
						$kondisiFilter = $kondisiFilter." and status_validasi ='1' ";
					}
			}







		$grabAll = mysql_query("select * from view_rka where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'");
		while($rows = mysql_fetch_array($grabAll)){
			foreach ($rows as $key => $value) {
		  		$$key = $value;
		 	}
			$getTotalPerrekening = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiFilter and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'RKA-SKPD'"));
		 	$total = $getTotalPerrekening['sum(jumlah_harga)'];
		 	if($total == 0){
				$arrKondisi[] = "id_anggaran !='$id_anggaran'";
			}
		}



		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";

		$Kondisi= join(' and ',$arrKondisi);
		$qry ="select * from view_rka where $Kondisi  ";
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
					Ringkasan Anggaran Pendapatan, Belanja dan Pembiayaan Satuan Kerja Perangkat Daerah
				</span><br>
								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
										<th class='th01' rowspan='1' colspan='5' >KODE REKENING</th>
										<th class='th01' rowspan='1' >URAIAN</th>
										<th class='th01' rowspan='1' >JUMLAH (Rp)</th>

									</tr>



		";
		$getTotal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where 1=1 $kondisiSKPD $kondisiFilter  and nama_modul = 'RKA-SKPD' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		$total = number_format($getTotal['sum(jumlah_harga)'],2,',','.');
		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
			}

				$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
				$uraian = "<b>".$getNamaRekening['nm_rekening']."</b>";
				$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD $kondisiFilter and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'RKA-SKPD'"));
				$jumlah_harga = "<b>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.');


			echo "
								<tr valign='top'>
									<td align='center' class='GarisDaftar' >".$k."</td>
									<td align='center' class='GarisDaftar' >".$l."</td>
									<td align='center' class='GarisDaftar' >".$m."</td>
									<td align='center' class='GarisDaftar' >".$n."</td>
									<td align='center' class='GarisDaftar' >".$o."</td>
									<td align='left' class='GarisDaftar' >".$uraian."</td>
									<td align='right' class='GarisDaftar' >".$jumlah_harga."</td>
								</tr>
			";
			$no++;




		}
		echo 				"<tr valign='top'>
									<td align='right' colspan='6' class='GarisDaftar'>Jumlah</td>
									<td align='right' class='GarisDaftar' ><b>".$total."</b></td>

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

}
$rkaSKPD = new rkaSKPDObj();

$arrayResult = VulnWalkerTahap_v2('RKA');
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$rkaSKPD->jenisForm = $jenisForm;
$rkaSKPD->nomorUrut = $nomorUrut;
$rkaSKPD->tahun = $tahun;
$rkaSKPD->jenisAnggaran = $jenisAnggaran;
$rkaSKPD->idTahap = $idTahap;

$rkaSKPD->username = $_COOKIE['coID'];

$rkaSKPD->wajibValidasi = $Main->wajibValidasi;
if($Main->wajibValidasi == TRUE){
	$rkaSKPD->sqlValidasi = " and status_validasi ='1' ";
}else{
	$rkaSKPD->sqlValidasi = " ";
}

if(empty($rkaSKPD->tahun)){

	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_rka "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rka where id_anggaran = '$maxAnggaran'"));
	/*$rkaSKPD->tahun = "select max(id_anggaran) as max from view_rka where nama_modul = 'rkaSKPD'";*/
	$rkaSKPD->tahun  = $get2['tahun'];
	$rkaSKPD->jenisAnggaran = $get2['jenis_anggaran'];
	$rkaSKPD->idTahap = $get2['id_tahap'];
	$rkaSKPD->urutTerakhir = $get2['no_urut'];
	$rkaSKPD->jenisFormTerakhir = $get2['jenis_form_modul'];
	$rkaSKPD->urutSebelumnya = $rkaSKPD->urutTerakhir - 1;


	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$rkaSKPD->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaSKPD->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$rkaSKPD->currentTahap = $arrayHasil['currentTahap'];
}else{
	$getCurrenttahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$rkaSKPD->idTahap'"));
	$rkaSKPD->currentTahap = $getCurrenttahap['nama_tahap'];

	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$rkaSKPD->idTahap'"));
	$rkaSKPD->jenisFormTerakhir =  $namaTahap['jenis_form_modul'];
	$rkaSKPD->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaSKPD->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
}

$setting = settinganPerencanaan_v2();
$rkaSKPD->provinsi = $setting['provinsi'];
$rkaSKPD->kota = $setting['kota'];
$rkaSKPD->pengelolaBarang = $setting['pengelolaBarang'];
$rkaSKPD->pejabatPengelolaBarang = $setting['pejabat'];
$rkaSKPD->pengurusPengelolaBarang = $setting['pengurus'];
$rkaSKPD->nipPengelola = $setting['nipPengelola'];
$rkaSKPD->nipPengurus = $setting['nipPengurus'];
$rkaSKPD->nipPejabat = $setting['nipPejabat'];


if($rkaSKPD->jenisForm != "PENYUSUNAN"){
$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from tabel_anggaran where jenis_form_modul = 'PENYUSUNAN' "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$maxAnggaran'"));
	$rkaSKPD->tahun  = $get2['tahun'];
	$rkaSKPD->jenisAnggaran = $get2['jenis_anggaran'];
	$rkaSKPD->urutTerakhir = $get2['no_urut'];
	$rkaSKPD->jenisFormTerakhir = $get2['jenis_form_modul'];
	$rkaSKPD->urutSebelumnya = $rkaSKPD->urutTerakhir - 1;


	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$rkaSKPD->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaSKPD->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];

	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$rkaSKPD->currentTahap = $arrayHasil['currentTahap'];
			$rkaSKPD->jenisForm = "";
			$rkaSKPD->jenisFormTerakhir = "PENYUSUNAN";
			$rkaSKPD->idTahap = $get2['id_tahap'];
			$rkaSKPD->nomorUrut = $get2['no_urut'];
			$rkaSKPD->urutTerakhir = $get2['no_urut'];
}





?>
