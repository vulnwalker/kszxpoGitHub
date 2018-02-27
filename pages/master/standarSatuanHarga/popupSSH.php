<?php

class popupSSHObj  extends DaftarObj2{
	var $Prefix = 'popupSSH';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_standar_satuan_harga'; //daftar
	var $TblName_Hapus = 'ref_standar_satuan_harga';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
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
	var $FormName = 'popupSSHForm';
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
			$ck=mysql_fetch_array(mysql_query("Select * from ref_standar_satuan_harga where k!='0' and l ='0' and m ='0' and n ='00' and o ='00' Order By k DESC limit 1"));
			if($kode1=='0') {$err= 'Format Kode Akun salah';}
			elseif($kode1!=5){ $err= 'Format Kode Akun salah';}

		}elseif($j==1){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_standar_satuan_harga where k='".$kode1."' and l !='0' and m ='0' and n ='00' and o ='00' Order By l DESC limit 1"));
			if ($kode2>sprintf("%02s",$ck['l']+1)) {$err= 'Format Kode Kelompok Belanja Harus berurutan';}

		}elseif($j==2){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_standar_satuan_harga where k='".$kode1."' and l ='".$kode2."' and m !='0' and n ='00' and o ='00' Order By m DESC limit 1"));
			if ($kode3>sprintf("%02s",$ck['m']+1)) {$err= 'Format Kode Jenis Belanja Salah';}

		}elseif($j==3){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_standar_satuan_harga where k='".$kode1."' and l ='".$kode2."' and m ='".$kode3."' and n!='00' and o='$this->WHERE_O' Order By n DESC limit 1"));
			if ($kode4>sprintf("%02s",$ck['n']+1)) {$err= 'Format Kode Objek Belanja Harus berurutan';}

		}elseif($j==4){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_standar_satuan_harga where k='".$kode1."' and l ='".$kode2."' and m ='".$kode3."' and n ='".$kode4."' and o!='00' Order By o DESC limit 1"));
			if ($kode5>sprintf("%02s",$ck['o']+1)) {$err= 'Format Kode SubObjek Belanja Harus berurutan';}


		}
	 }



			if($fmST == 0){
			$ck1=mysql_fetch_array(mysql_query("Select * from ref_standar_satuan_harga where k='$kode1' and l ='$kode2' and m ='$kode3' and n='$kode4' and o='$kode5'"));
			if ($ck1>=1)$err= 'Gagal Simpan'.mysql_error();
				if($err==''){
					$aqry = "INSERT into ref_standar_satuan_harga (k,l,m,n,o,nm_rekening) values('$kode1','$kode2','$kode3','$kode4','$kode5','$nama_rekening')";	$cek .= $aqry;
					$qry = mysql_query($aqry);
				}
			}else{
				if($err==''){
				$aqry = "UPDATE ref_standar_satuan_harga SET nm_rekening='$nama_rekening' WHERE k='$kode1' and l='$kode2' and m='$kode3' and n='$kode4' and o='$kode5'";	$cek .= $aqry;
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

	   	case 'getdata':{
		foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
		}
		$getStandarSatuanHarga = mysql_fetch_array(mysql_query("select * from ref_standar_satuan_harga where id = '$id'"));
		$content = array("hargaSatuan" => $getStandarSatuanHarga['harga_satuan']);
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
			 "<script type='text/javascript' src='js/perencanaan/rka/popupSSH.js' language='JavaScript' ></script>".
			$scriptload;
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
		$aqry = "SELECT * FROM  ref_standar_satuan_harga WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o' "; $cek.=$aqry;
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


			$FormContent = $this->genDaftarInitial($fmSKPD, $fmUNIT, $fmSUBUNIT,$tahun_anggaran);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div',
						$FormContent,
						800,
						500,
						'Pilih Standar Satuan Harga',
						'',
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
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

		$vOpsi = $this->genDaftarOpsi();
		return
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>".

				"<input type='hidden' id='".$this->Prefix."nm_account' name='".$this->Prefix."nm_account' value='$nm_account'>".
				"<input type='hidden' id='filterKodeRekening' name='filterKodeRekening' value='".$_REQUEST['kodeRekening']."'>".
				"<input type='hidden' id='filterKodeBarang' name='filterKodeBarang' value='".$_REQUEST['kodeBarang']."'>".
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
	   <th class='th01' width='1000' >Uraian</th>
	   <th class='th01' width='200' align='cente'>Harga Satuan</th>
	   </tr>
	   </thead>";

		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) {
 			  $$key = $value;
 			}
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	 $Koloms[] = array('align="left"',"<span style='cursor:pointer;color:red;' onclick=$this->Prefix.windowSave($id)>$uraian</span>");
	 $Koloms[] = array('align="right"',number_format($harga_satuan ,2,',','.') );

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
	$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where concat(k,'.',l,'.',m,'.',n,'.',o) = '".$_REQUEST['filterKodeRekening']."'"));
	$TampilOpt =

	"
	<input type='hidden' name='filterKodeRekening' id = 'filterKodeRekening' value='".$_REQUEST['filterKodeRekening']."'>
	<input type='hidden' name='filterKodeBarang' id = 'filterKodeBarang' value='".$_REQUEST['filterKodeBarang']."'>
	<table style='width:100%'>
	<tr><td>
	Rekening  &nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp: &nbsp&nbsp".$getNamaRekening['nm_rekening']."
	</td></tr>
	<tr><td>
	Uraian  &nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp: &nbsp&nbsp<input type='text' id='filterUraian' name='filterUraian' value='".$filterUraian."' size=40px>
		<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
	</td></tr>
	</table>"
			;
		return array('TampilOpt'=>$TampilOpt);
	}

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
		//kondisi -----------------------------------
		$arrKondisi = array();
		foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
		}
		$tahun =date('Y');
		$arrKondisi[] = "tahun_mulai_berlaku >= $tahun ";
		$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) = '$filterKodeRekening'";
		if(!empty($filterKodeBarang) && $filterKodeBarang != '.....'){
				$explodeKodeBarang = explode('.',$filterKodeBarang);
				$f = $explodeKodeBarang[0];
				$g = $explodeKodeBarang[1];
				$h = $explodeKodeBarang[2];
				$i = $explodeKodeBarang[3];
				$j = $explodeKodeBarang[4];
				$j1 = $explodeKodeBarang[5];
				if($j1 == '')$j1 = '0000';
				$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j.".".$j1;
				$arrKondisi[] = "concat(f,'.',g,'.',h,'.',i,'.',j,'.',j1) = '$kodeBarang'";
		}else{
				$arrKondisi[] = "concat(f,'.',g,'.',h,'.',i,'.',j,'.',j1) = '00.00.00.00.000.0000'";
		}
		if(!empty($filterUraian)){
				$arrKondisi[] = "uraian like '%$filterUraian%'";
		}

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
$popupSSH = new popupSSHObj();
if($Main->REK_DIGIT_O == 0){
	$popupSSH->WHERE_O = "00";
}else{
	$popupSSH->WHERE_O = "000";
}

?>
