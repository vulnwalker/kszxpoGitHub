<?php

class popupRekeningRkaObj  extends DaftarObj2{
	var $Prefix = 'popupRekeningRka';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_rekening'; //daftar
	var $TblName_Hapus = 'ref_rekening';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('k','l','m','n','o');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Data';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'REKENING';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'popupRekeningRkaForm';
	var $WHERE_O = "";
	var $differentRekening = "";

	function setTitle(){
		return '';
	}
	function setMenuEdit(){
		return
			"";
	}
	function setMenuView(){
		return "";
	}
	function setTopBar(){
		return "";
	}
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;

		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>";

	}

		function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
     $kode1= $_REQUEST['k'];
	 $kode2= $_REQUEST['l'];
	 $kode3= $_REQUEST['m'];
	 $kode4= $_REQUEST['n'];
	 $kode5= $_REQUEST['o'];
	 $nama_rekening = $_REQUEST['nama_rekening'];


	 if( $err=='' && $kode1 =='' ) $err= 'Kode 1 Belum Di Isi !!';
	 if( $err=='' && $kode2 =='' ) $err= 'Kode 2 Belum Di Isi !!';
	 if( $err=='' && $kode3 =='' ) $err= 'Kode 3 Belum Di Isi !!';
	 if( $err=='' && $kode4 =='' ) $err= 'Kode 4 Belum Di Isi !!';
	 if( $err=='' && $kode5 =='' ) $err= 'Kode 5 Belum Di Isi !!';
	 if( $err=='' && $nama_rekening =='' ) $err= 'nama rekening Belum Di Isi !!';


	// if($err=='' && $kode_skpd =='' ) $err= 'Kode Skpd belum diisi';
	 if(strlen($kode1)!=1 || strlen($kode2)!=1 || strlen($kode3)!=1 || strlen($kode4)!=2 ||strlen($kode5)!=2) $err= 'Format KODE salah';
			for($j=0;$j<5;$j++){
	//urutan kode skpd
		if($j==0){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_rekening where k!='0' and l ='0' and m ='0' and n ='00' and o ='00' Order By k DESC limit 1"));
			if($kode1=='0') {$err= 'Format Kode Akun salah';}
			elseif($kode1!=5){ $err= 'Format Kode Akun salah';}

		}elseif($j==1){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_rekening where k='".$kode1."' and l !='0' and m ='0' and n ='00' and o ='00' Order By l DESC limit 1"));
			if ($kode2>sprintf("%02s",$ck['l']+1)) {$err= 'Format Kode Kelompok Belanja Harus berurutan';}

		}elseif($j==2){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_rekening where k='".$kode1."' and l ='".$kode2."' and m !='0' and n ='00' and o ='00' Order By m DESC limit 1"));
			if ($kode3>sprintf("%02s",$ck['m']+1)) {$err= 'Format Kode Jenis Belanja Salah';}

		}elseif($j==3){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_rekening where k='".$kode1."' and l ='".$kode2."' and m ='".$kode3."' and n!='00' and o='$this->WHERE_O' Order By n DESC limit 1"));
			if ($kode4>sprintf("%02s",$ck['n']+1)) {$err= 'Format Kode Objek Belanja Harus berurutan';}

		}elseif($j==4){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_rekening where k='".$kode1."' and l ='".$kode2."' and m ='".$kode3."' and n ='".$kode4."' and o!='00' Order By o DESC limit 1"));
			if ($kode5>sprintf("%02s",$ck['o']+1)) {$err= 'Format Kode SubObjek Belanja Harus berurutan';}


		}
	 }



			if($fmST == 0){
			$ck1=mysql_fetch_array(mysql_query("Select * from ref_rekening where k='$kode1' and l ='$kode2' and m ='$kode3' and n='$kode4' and o='$kode5'"));
			if ($ck1>=1)$err= 'Gagal Simpan'.mysql_error();
				if($err==''){
					$aqry = "INSERT into ref_rekening (k,l,m,n,o,nm_rekening) values('$kode1','$kode2','$kode3','$kode4','$kode5','$nama_rekening')";	$cek .= $aqry;
					$qry = mysql_query($aqry);
				}
			}else{
				if($err==''){
				$aqry = "UPDATE ref_rekening SET nm_rekening='$nama_rekening' WHERE k='$kode1' and l='$kode2' and m='$kode3' and n='$kode4' and o='$kode5'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());

					}
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

		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}
		case 'saveSelected':{
			foreach ($_REQUEST as $key => $value) {
						$$key = $value;
			}
			if($jenisRKA == "RKA 2.2.1"){
				$tempTableRekening = "temp_rekening_rka_belanja_langsung";
				$tempRincianBelanja = "temp_rincian_belanja_langsung";
				$tempSubRincianBelanja = "temp_sub_rincian_belanja_langsung";
				$rkaPrefix= "rkaSKPD221_ins";
			}elseif($jenisRKA == "RKA 2.1"){
				$tempTableRekening = "temp_rekening_rka_belanja_tidak_langsung";
				$tempRincianBelanja = "temp_rincian_belanja_tidak_langsung";
				$tempSubRincianBelanja = "temp_sub_rincian_belanja_tidak_langsung";
				$rkaPrefix= "rkaSKPD21_ins";
			}elseif($jenisRKA == "RKA 1 PAD"){
				$tempTableRekening = "temp_rekening_rka_pendapatan_pad";
				$tempRincianBelanja = "temp_rincian_pendapatan_pad";
				$tempSubRincianBelanja = "temp_sub_rincian_pendapatan_pad";
				$rkaPrefix= "rkaSKPD1PAD_ins";
			}elseif($jenisRKA == "RKA 1 DP"){
				$tempTableRekening = "temp_rekening_rka_pendapatan_dp";
				$tempRincianBelanja = "temp_rincian_pendapatan_dp";
				$tempSubRincianBelanja = "temp_sub_rincian_pendapatan_dp";
				$rkaPrefix= "rkaSKPD1DP_ins";
			}elseif($jenisRKA == "RKA 1 LP"){
				$tempTableRekening = "temp_rekening_rka_pendapatan_lp";
				$tempRincianBelanja = "temp_rincian_pendapatan_lp";
				$tempSubRincianBelanja = "temp_sub_rincian_pendapatan_lp";
				$rkaPrefix= "rkaSKPD1LP_ins";
			}elseif($jenisRKA == "RKA 3.1"){
				$tempTableRekening = "temp_rekening_rka_pembiayaan_penerimaan";
				$tempRincianBelanja = "=temp_rincian_pembiayaan_penerimaan";
				$tempSubRincianBelanja = "temp_sub_rincian_pembiayaan_penerimaan";
				$rkaPrefix= "rkaSKPD31_ins";
			}elseif($jenisRKA == "RKA 3.2"){
				$tempTableRekening = "temp_rekening_rka_pembiayaan_pengeluaran";
				$tempRincianBelanja = "=temp_rincian_pembiayaan_pengeluaran";
				$tempSubRincianBelanja = "temp_sub_rincian_pembiayaan_pengeluaran";
				$rkaPrefix= "rkaSKPD32_ins";
			}
			for ($i=0; $i < sizeof($popupRekeningRka_cb) ; $i++) {
					if(mysql_num_rows(mysql_query("select * from $tempTableRekening where concat(k,' ',l,' ',m,' ',n,' ',o) ='".$popupRekeningRka_cb[$i]."' and username ='$this->username'")) == 0){
							$explodeKodeRekening = explode(' ',$popupRekeningRka_cb[$i]);
							$k=$explodeKodeRekening[0];
							$l=$explodeKodeRekening[1];
							$m=$explodeKodeRekening[2];
							$n=$explodeKodeRekening[3];
							$o=$explodeKodeRekening[4];
							$data = array(
												'k' => $k,
												'l' => $l,
												'm' => $m,
												'n' => $n,
												'o' => $o,
												'sumber_dana' => "APBD",
												'username' => $this->username
							);
							$query = VulnWalkerInsert($tempTableRekening,$data);
							mysql_query($query);
					}
			}

			$content = array('tabelRekening' => $this->tabelRekening($tempTableRekening,$tempRincianBelanja,$tempSubRincianBelanja,$rkaPrefix));
			break;
		}

	   	case 'getdata':{
		foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
		}
		$ref_pilihrekening = $_REQUEST['id'];
		$getRekening = mysql_fetch_array(mysql_query("select concat(k,'.',l,'.',m,'.',n,'.',o) as kode_rekening, nm_rekening from ref_rekening where concat(k,'.',l,'.',m,'.',n,'.',o)  = '$ref_pilihrekening' "));
		$kode_rekening = $getRekening['kode_rekening'];
		$nama_rekening = $getRekening['nm_rekening'];

		$codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kode_rekening' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' ";
		$cmbPekerjaan = cmbQuery('o1', $o1, $codeAndNamePekerjaan," onchange=$this->Prefix.setNoUrut(); ",'-- PEKERJAAN --');
		$content = array('kode_rekening' => $kode_rekening, 'nama_rekening' => $nama_rekening, 'cmbPekerjaan' => $cmbPekerjaan, 'kolomButtonCariBarang' => "<input type='button' id='findBarang' value='CARI' onclick='formRkaSkpd221_v2.CariBarang();'/>");
		break;
	   }


		case 'simpan':{
			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
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
			 "<script type='text/javascript' src='js/perencanaan/rka/popupRekeningRka.js' language='JavaScript' ></script>".
			$scriptload;
	}
	function tabelRekening($tempTableRekening,$tempRincianBelanja,$tempSubRincianBelanja,$rkaPrefix){
		$cek = '';
		$err = '';
		$jml_harga=0;
		$datanya='';
		$username = $_COOKIE['coID'];

		$qry = "select * from $tempTableRekening where username = '$this->username' order by k,l,m,n,o ";$cek.=$qry;
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
			$warna = "red";
			if(strlen($k) > 1){
					$kodeRekening = "x.x.x.xx.xxx";
					$namaRekening = "Belanja XXX";
			}
			$getDataRincianBelanja = mysql_query("select * from $tempRincianBelanja where id_rekening_belanja = '$id'");
			while ($dataRincianBelanja = mysql_fetch_array($getDataRincianBelanja)) {
					if(mysql_num_rows(mysql_query("select * from $tempSubRincianBelanja where id_rincian_belanja = '".$dataRincianBelanja['id']."'")) !=0){
							if($statusMerah == ""){
								$warna = "black";
							}else{
								$warna = "red";
								$statusMerah = 1;
							}
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
								<input type='button' value='Rincian'  onclick = $rkaPrefix.rincianBelanja($id); >
							</td>
							<td class='GarisDaftar' align='center'>
								<img src='images/administrator/images/edit_f2.png' style='width:20px;height:20px;cursor:pointer;' onclick= rkaSKPD221_ins.editRekening($id); >
							</td>
						</tr>
			";
			$no = $no+1;
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
								<a href='javascript:rkaSKPD221_ins.$tujuan' id='linkAtasButton' /><img id='gambarAtasButton' src='$gambar' style='width:20px;height:20px;' /></a>
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
	function Hapus_Validasi($id){//id -> multi id with space delimiter
		$errmsg ='';
		$kode_rekening = explode(' ',$id);
		$ka=$kode_rekening[0];
		$kb=$kode_rekening[1];
		$kc=$kode_rekening[2];
		$kd=$kode_rekening[3];
		$ke=$kode_rekening[4];
		$kf=$kode_rekening[5];

		$quricoy="select count(*) as cnt from ref_barang where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and kf='$kf'";
		$dt3 = mysql_fetch_array(mysql_query($quricoy));
		$korong = $dt3 ['cnt'];

		if($korong>0){

		$korong;
		$errmsg = "ada kode barang tidak bisa di edit/hapus, karena masih ada rinciannya !";
		}

		if($errmsg=='' &&
				mysql_num_rows(mysql_query(
					"select Id from buku_induk where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and kf='$kf' ")
				) >0 )
			{ $errmsg = 'Gagal Hapus! KODE AKUN Sudah ada di Buku Induk!';}
		return $errmsg;
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
		$k=$kode[0];
		$l=$kode[1];
		$m=$kode[2];
		$n=$kode[3];
		$o=$kode[4];
		$this->form_fmST = 1;
		//get data
		$aqry = "SELECT * FROM  ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

	function setForm($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 100;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
		$nip	 = '';
	  }else{
		$this->form_caption = 'Edit';
		$readonly='readonly';

	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		$kode1=genNumber($dt['k'],1);
		$kode2=genNumber($dt['l'],1);
		$kode3=genNumber($dt['m'],1);
		$kode4=genNumber($dt['n'],2);
		$kode5=genNumber($dt['o'],2);
		$nama_rekening=$dt['nm_rekening'];

	 //items ----------------------
	  $this->form_fields = array(
			'kode' => array(
						'label'=>'Kode Rekening',
						'labelWidth'=>100,
						//'value'=>$dt['kode'],
						//'type'=>'text',
						'value'=>
						"<input type='text' name='k' id='k' size='5' maxlength='1' value='".$kode1."' $readonly>&nbsp
						<input type='text' name='l' id='l' size='5' maxlength='1' value='".$kode2."' $readonly>&nbsp
						<input type='text' name='m' id='m' size='5' maxlength='1' value='".$kode3."' $readonly>&nbsp
						<input type='text' name='n' id='n' size='5' maxlength='2' value='".$kode4."' $readonly>&nbsp
						<input type='text' name='o' id='o' size='5' maxlength='2' value='".$kode5."' $readonly>"
						 ),

			'nama' => array(
						'label'=>'Nama Rekening',
						'labelWidth'=>100,


						'value'=>"<input type='text' name='nama_rekening' id='nama_rekening' size='50' maxlength='100' value='".$nama_rekening."'>",
						'row_params'=>"valign='top'",
						'type'=>''
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

	function windowShow(){
		$cek = ''; $err=''; $content='';
		$json = TRUE;	//$ErrMsg = 'tes';
		$form_name = $this->FormName;

			$jenisRKA = $_REQUEST['filterAkun'];
			$FormContent = $this->genDaftarInitial($fmSKPD, $fmUNIT, $fmSUBUNIT,$tahun_anggaran);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div',
						$FormContent,
						800,
						500,
						'Pilih Rekening',
						'',
						"
						<input type='hidden' name='jenisRKA' id = 'jenisRKA' value='$jenisRKA'>
						<input type='button' value='Pilih' onclick ='".$this->Prefix.".saveSelected()' >&nbsp&nbsp".
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' > ".
						"<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';
		//}

		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function genDaftarInitial($nm_account='', $height=''){

		if($_REQUEST['filterAkun'] != $_COOKIE['VWfilrek']){
			$this->differentRekening = "1";
			setcookie('VWMRekening','');
			setcookie('VWNRekening','');
		}
		setcookie('VWfilrek',$_REQUEST['filterAkun']);

		$vOpsi = $this->genDaftarOpsi();
		return
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>".

				"<input type='hidden' id='".$this->Prefix."nm_account' name='".$this->Prefix."nm_account' value='$nm_account'>".
				"<input type='hidden' id='filterAkun' name='filterAkun' value='".$filterAkun."'>".
			"</div>".
			"<div id=garis style='height:1;border-bottom:1px solid #E5E5E5;'></div>".
			"<div id=contain style='overflow:auto;height:$height;'>".
			//"<div id=contain style='overflow:auto;height:256;'>".
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".
			"</div>
			</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".
				"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
			"</div>";
	}

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
	   <th class='th01' width='20' ></th>
	   <th class='th01' width='400' colspan='5'>Kode</th>
	   <th class='th01' width='900' align='cente'>Nama</th>
	   </tr>
	   </thead>";

		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;

	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	 $Koloms[] = array('align="center"', $TampilCheckBox );
	 $Koloms[] = array('align="center"',genNumber($isi['k'],1));
	 $Koloms[] = array('align="center"',genNumber($isi['l'],1));
	 $Koloms[] = array('align="center"',genNumber($isi['m'],1));
	 $Koloms[] = array('align="center"',genNumber($isi['n'],2));
	 $Koloms[] = array('align="center"',$isi['o']);
	 $kode_rekening = $isi['k'].".".$isi['l'].".".$isi['m'].".".$isi['n'].".".$isi['o'];
	 $Koloms[] = array('align="left"',$isi["nm_rekening"] );

	 return $Koloms;
	}


	function genDaftarOpsi(){
	 global $Ref, $Main;



	$fmBIDANG = '5';
	$fmKELOMPOK = '2';

	if($this->differentRekening == ''){
		if(isset($_REQUEST['fmSUBKELOMPOK'])){
			$fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
			setcookie('VWMRekening',$fmSUBKELOMPOK);
		}else{
			$fmSUBKELOMPOK = $_COOKIE['VWMRekening'];
		}

		if(isset($_REQUEST['fmSUBSUBKELOMPOK'])){
			$fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];
			setcookie('VWNRekening',$fmSUBSUBKELOMPOK);
		}else{
			$fmSUBSUBKELOMPOK = $_COOKIE['VWNRekening'];
		}
	}else{
		$fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
		$fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];
	}

	$filterAkun = $_COOKIE['VWfilrek'];

	$fmKODE = $_REQUEST['fmKODE'];
	$fmREKENING = $_REQUEST['fmREKENING'];
/*	$_REQUEST['filterAkun'] = $filterAkun;*/

	//$fmPILCARI = $_REQUEST['fmPILCARI'];
	//$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
	//$fmORDER1 = cekPOST('fmORDER1');
	//$fmDESC1 = cekPOST('fmDESC1');


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
	 $kondisiRka = "disabled";
	 if($filterAkun == "RKA 2.2.1"){
	 	$fmBIDANG = "5";
		$fmKELOMPOK = "2";
	 }elseif($filterAkun == "RKA 2.1"){
	 	$fmBIDANG = "5";
		$fmKELOMPOK = "1";
		}
	elseif($filterAkun == "RKA-PPKD 3.1"){
	 	$fmBIDANG = "6";
		$fmKELOMPOK = "1";
		}elseif($filterAkun == "RKA-PPKD 3.2"){
	 	$fmBIDANG = "6";
		$fmKELOMPOK = "2";
		}
	elseif($filterAkun == "RKA 1"){
	 	$fmBIDANG = "4";
		$fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
		 $kondisiRka = "";
	}
	elseif($filterAkun == "RKA 1 PAD"){
	 	$fmBIDANG = "4";
		$kondisiRka = "disabled";
		$fmKELOMPOK = "1";
	}
	elseif($filterAkun == "RKA 1 DP"){
	 	$fmBIDANG = "4";
		$kondisiRka = "disabled";
		$fmKELOMPOK = "2";
	}
	elseif($filterAkun == "RKA 1 LP"){
	 	$fmBIDANG = "4";
		$kondisiRka = "disabled";
		$fmKELOMPOK = "3";
	}
	elseif($filterAkun == "RKA 3.1"){
	 	$fmBIDANG = "6";
		$kondisiRka = "disabled";
		$fmKELOMPOK = "1";
	}
	elseif($filterAkun == "RKA 3.2"){
	 	$fmBIDANG = "6";
		$kondisiRka = "disabled";
		$fmKELOMPOK = "2";
	}
	elseif($filterAkun == "BELANJA MODAL"){
	 	$fmBIDANG = "5";
		$fmKELOMPOK = "2";
		$fmSUBKELOMPOK = "3";
		 $kondisiRka = "disabled";
		 $kondisiBelanjaModal = "disabled";
	}
	elseif($filterAkun == "BELANJA BARANG JASA"){
	 	$fmBIDANG = "5";
		$fmKELOMPOK = "2";
		$fmSUBKELOMPOK = "2";
		 $kondisiRka = "disabled";
		 $kondisiBelanjaModal = "disabled";
	}

	$TampilOpt =
			//"<tr><td>".
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr>
			<td style='width:150px'>BIDANG</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery1("fmBIDANG",$fmBIDANG,"select k,nm_rekening from ref_rekening where k!='0' and l ='0' and m = '0' and n='00' and o='$this->WHERE_O'","onChange=\"$this->Prefix.refreshList(true)\" disabled",'Pilih','').
			"</td>
			</tr><tr>
			<td>KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmKELOMPOK",$fmKELOMPOK,"select l,nm_rekening from ref_rekening where k='$fmBIDANG' and l !='0' and m = '0' and n='00' and o='$this->WHERE_O'","onChange=\"$this->Prefix.refreshList(true)\"$kondisiRka",'Pilih','').
			"</td>
			</tr><tr>
			<td>SUB KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBKELOMPOK",$fmSUBKELOMPOK,"select m,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m != '0' and n='00' and o='$this->WHERE_O'","$kondisiBelanjaModal onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SUB SUB KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBSUBKELOMPOK",$fmSUBSUBKELOMPOK,"select n,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m = '$fmSUBKELOMPOK' and n!='00' and o='$this->WHERE_O'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>

			</table>".
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Kode Rekening : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' size=20px>&nbsp
				Nama Rekening : <input type='text' id='fmREKENING' name='fmREKENING' value='".$fmREKENING."' size=30px>&nbsp
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
			</table>".
			"</div>"
			;
		return array('TampilOpt'=>$TampilOpt);
	}

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
		//kondisi -----------------------------------
		$arrKondisi = array();
		$fmPILCARI = $_REQUEST['fmPILCARI'];
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
	 	$fmBIDANG =  $_REQUEST['fmBIDANG'];
	    $fmKELOMPOK =  $_REQUEST['fmKELOMPOK'];
			$fmKODE = $_REQUEST['fmKODE'];
			$fmREKENING = $_REQUEST['fmREKENING'];


			if($this->differentRekening == ''){
				if(isset($_REQUEST['fmSUBKELOMPOK'])){
					$fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
					setcookie('VWMRekening',$fmSUBKELOMPOK);
				}else{
					$fmSUBKELOMPOK = $_COOKIE['VWMRekening'];
				}

				if(isset($_REQUEST['fmSUBSUBKELOMPOK'])){
					$fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];
					setcookie('VWNRekening',$fmSUBSUBKELOMPOK);
				}else{
					$fmSUBSUBKELOMPOK = $_COOKIE['VWNRekening'];
				}
			}else{
				$fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
				$fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];
			}
		//Cari
		$isivalue=explode('.',$fmPILCARIvalue);
		$filterAkun = $_COOKIE['VWfilrek'];
		if($filterAkun == "RKA 2.2.1"){
	 	$fmBIDANG = "5";
		$fmKELOMPOK = "2";
		}elseif($filterAkun == "RKA 2.1"){
	 	$fmBIDANG = "5";
		$fmKELOMPOK = "1";
		}elseif($filterAkun == "RKA-PPKD 3.1"){
	 	$fmBIDANG = "6";
		$fmKELOMPOK = "1";
		}elseif($filterAkun == "RKA-PPKD 3.2"){
	 	$fmBIDANG = "6";
		$fmKELOMPOK = "2";
		}
		elseif($filterAkun == "RKA 1"){
	 	$fmBIDANG = "4";
		$fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
		}
		elseif($filterAkun == "RKA 1 PAD"){
		 	$fmBIDANG = "4";
			$kondisiRka = "";
			$fmKELOMPOK = "1";
		}
		elseif($filterAkun == "RKA 1 DP"){
		 	$fmBIDANG = "4";
			$kondisiRka = "";
			$fmKELOMPOK = "2";
		}
		elseif($filterAkun == "RKA 1 LP"){
		 	$fmBIDANG = "4";
			$kondisiRka = "";
			$fmKELOMPOK = "3";
		}
		elseif($filterAkun == "RKA 3.1"){
		 	$fmBIDANG = "6";
			$kondisiRka = "disabled";
			$fmKELOMPOK = "1";
		}
		elseif($filterAkun == "RKA 3.2"){
		 	$fmBIDANG = "6";
			$kondisiRka = "disabled";
			$fmKELOMPOK = "2";
		}
		elseif($filterAkun == "BELANJA MODAL"){
	 	$fmBIDANG = "5";
		$fmKELOMPOK = "2";
		$fmSUBKELOMPOK = "3";
	}
		elseif($filterAkun == "BELANJA BARANG JASA"){
	 	$fmBIDANG = "5";
		$fmKELOMPOK = "2";
		$fmSUBKELOMPOK = "2";
	}

		$arrKondisi[]= "k ='$fmBIDANG'";

		if(!empty($fmKELOMPOK)){
			$arrKondisi[]= "l ='$fmKELOMPOK'";
		}


		if(empty($fmSUBKELOMPOK)) {
		}else{
			$arrKondisi[]= "m =$fmSUBKELOMPOK";
		}
		if(empty($fmSUBSUBKELOMPOK) ) {
		}else{
			$arrKondisi[]= "n =$fmSUBSUBKELOMPOK";
		}


		if(empty($fmREKENING)){

		}else{
			$arrKondisi[]= "nm_rekening like '%$fmREKENING%'";
		}
		$arrKondisi[]= "o !=00";
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " k,l,m,n,o $Asc1 " ;break;
			case '2': $arrOrders[] = " nm_skpd $Asc1 " ;break;

		}
		$Order= join(',',$arrOrders);
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;

		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}

}
$popupRekeningRka = new popupRekeningRkaObj();
if($Main->REK_DIGIT_O == 0){
	$popupRekeningRka->WHERE_O = "00";
}else{
	$popupRekeningRka->WHERE_O = "000";
}
$popupRekeningRka->username = $_COOKIE['coID'];

?>
