<?php

class popupBarangSSHObj  extends DaftarObj2{
	var $Prefix = 'popupBarangSSH';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_barang'; //daftar
	var $TblName_Hapus = 'ref_barang';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('f1','f2','f','g','h','i','j','j1');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = '';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = '';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'popupBarangSSHForm';
	var $jenisForm = "";
	var $tahun = "";
	var $nomorUrut = "";
	var $jenisAnggaran = "";
	var $idTahap = "";

	function setTitle(){
		return '';
	}
	function setMenuEdit(){
		return
			"";
	}
	  function setTopBar(){
	   	return '';
	}
	function setMenuView(){
		return "";
	}
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;

		return
			"";
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
		case 'Hapus':{
			$fm = $this->Hapus_data();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'windowshow':{
				$kodeRENJA = $_REQUEST['kodeRENJA'];
				$fm = $this->windowShow($kodeRENJA);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

	   	case 'getdata':{

		$ref_pilihbarang = $_REQUEST['id'];
		$kode_barang = explode('.',$ref_pilihbarang);

		$f=$kode_barang[0];
		$g=$kode_barang[1];
		$h=$kode_barang[2];
		$i=$kode_barang[3];
		$j=$kode_barang[4];
		$j1=$kode_barang[5];

		//query ambil data ref_program
		$get = mysql_fetch_array( mysql_query("select * from ref_barang where  f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='$j1'"));
		$kodeBarang=$get['f'].'.'.$get['g'].'.'.$get['h'].'.'.$get['i'].'.'.$get['j'].'.'.$get['j1'];
		$kodeRekening = $get['k11'].".".$get['l11'].".".$get['m11'].".".$get['n11'].".".$get['o11'];
		$getNamaKodeRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRekening'"));
		$namaRekening = $getNamaKodeRekening['nm_rekening'];
		$satuanBarang = $get['satuan'];

		$content = array("kodeBarang" => $kodeBarang, "namaBarang" => $get['nm_barang'],"kodeRekening" => $kodeRekening,"namaRekening"=>$namaRekening, "satuanBarang" => $satuanBarang);


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

	function windowShow($kodeRENJA){
		$cek = ''; $err=''; $content='';
		$json = TRUE;	//$ErrMsg = 'tes';
		$form_name = $this->FormName;



			$FormContent = $this->genDaftarInitial();
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div',
						$FormContent,
						1200,
						500,
						'PILIH BARANG',
						'',
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
						"<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >
						 <input type='hidden' id='kodeRENJA' name='RENJA' value='$kodeRENJA' >
						"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';


		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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

			 <script type='text/javascript' src='js/master/standarSatuanHarga/popupBarangSSH.js' language='JavaScript' ></script>
			 ".

			$scriptload;
	}

	function Hapus_Validasi($id){//id -> multi id with space delimiter
		$errmsg ='';
		$kode_barang = explode(' ',$id);
		$f1=$kode_barang[0];
		$f2=$kode_barang[1];
		$f=$kode_barang[2];
		$g=$kode_barang[3];
		$h=$kode_barang[4];
		$i=$kode_barang[5];
		$j=$kode_barang[6];


		if($j =='000'){
			$errmsg = "Data tidak dapat di hapus";
		}

/*		if($korong>0){

		$korong;
		$errmsg = "ada kode barang tidak bisa di edit/hapus, karena masih ada rinciannya !";
		}*/
/*		//&&
				mysql_num_rows(mysql_query(
					"select Id from buku_induk where f='$f' and g='$g' and h='$h' and i='$i' and j='$j' ")
				) >0*/
/*		if($errmsg=='' )

			{ $errmsg = "GAGAL HAPUS, Kode Barang Sudah Ada Di Buku Induk !!! ";}*/



		return $errmsg;

}


	//form ==================================
	function setFormBaru(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdSUBUNIT'];
		$cek =$cbid[0];

		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$dt['readonly']='';
		$fmBIDANG = $_REQUEST['fmBIDANG'];
		$fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
		$fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
		$fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];
		if(!empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.'.$fmSUBSUBKELOMPOK.'.';
		}
		$fm = $this->setForm($dt);

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

  	function setFormEdit(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdSUBUNIT'];
		$cek =$cbid[0];

		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		//get data
		$f1=$kode[0];
		$f2=$kode[1];
		$f=$kode[2];
		$g=$kode[3];
		$h=$kode[4];
		$i=$kode[5];
		$j=$kode[6];
		$bulan=date('Y-m-')."1";
		//query ambil data ref_barang
		$aqry = "select * from ref_barang where concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j)='".$f1.'.'.$f2.'.'.$f.'.'.$g.'.'.$h.'.'.$i.'.'.$j."'"; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));

		//$dt['readonly']='readonly';
		$fm = $this->setForm($dt);

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

	function setForm($dt){
	 global $SensusTmp, $Main;
	 $cek = ''; $err=''; $content='';

	 $json = TRUE;	//$ErrMsg = 'tes';

	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 900;
	 $this->form_height = 300;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU';
		$readonly='';
		$chmod644 = "";
		$f1 = $_REQUEST['cmbAkun'];
		$f2 = $_REQUEST['cmbKelompok'];
		$f = $_REQUEST['cmbJenis'];
		$g = $_REQUEST['cmbObyek'];
		$h = $_REQUEST['cmbRincianObyek'];
		$i = $_REQUEST['cmbSubRincianObyek'];
		$j = $_REQUEST['cmbSubSubRincianObyek'];
	  }else{
		$this->form_caption = 'EDIT';
		$chmod644 ="readonly";
		$f1 = $dt['f1'];
		$f2 = $dt['f2'];
		$f = $dt['f'];
		$g = $dt['g'];
		$h = $dt['h'];
		$i = $dt['i'];
		$j = $dt['j'];
		 $aqry_at = "select * from ref_jurnal where ka='".$dt['ka']."' and kb='".$dt['kb']."' and kc='".$dt['kc']."' and kd='".$dt['kd']."' and ke='".$dt['ke']."' and kf='".$dt['kf']."' ";
	 $na_at=mysql_fetch_array(mysql_query($aqry_at));

	 $kode_account_at=$dt['ka'].'.'.$dt['kb'].'.'.$dt['kc'].'.'.$dt['kd'].'.'.$dt['ke'].'.'.$dt['kf'];
	 $aqry_bm = "select * from ref_jurnal where ka='".$dt['m1']."' and kb='".$dt['m2']."' and kc='".$dt['m3']."' and kd='".$dt['m4']."' and ke='".$dt['m5']."' and kf='".$dt['m6']."' ";
	 $na_bm=mysql_fetch_array(mysql_query($aqry_bm));
	 $kode_account_bm=$dt['m1'].'.'.$dt['m2'].'.'.$dt['m3'].'.'.$dt['m4'].'.'.$dt['m5'].'.'.$dt['m6'];

	 $aqry_ap = "select * from ref_jurnal where ka='".$dt['l1']."' and kb='".$dt['l2']."' and kc='".$dt['l3']."' and kd='".$dt['l4']."' and ke='".$dt['l5']."' and kf='".$dt['l6']."' ";
	 $na_ap=mysql_fetch_array(mysql_query($aqry_ap));
	 $kode_account_ap=$dt['l1'].'.'.$dt['l2'].'.'.$dt['l3'].'.'.$dt['l4'].'.'.$dt['l5'].'.'.$dt['l6'];

	 //vw
	 $query_rek_bm = "select * from ref_rekening where k='".$dt['k11']."' and l='".$dt['l11']."' and m='".$dt['m11']."' and n='".$dt['n11']."' and o='".$dt['o11']."' ";
	 $na_rek_bm = mysql_fetch_array(mysql_query($query_rek_bm));
	 $kode_rek_bm=$dt['k11'].'.'.$dt['l11'].'.'.$dt['m11'].'.'.$dt['n11'].'.'.$dt['o11'];

	 $query_rek_bp = "select * from ref_rekening where k='".$dt['k12']."' and l='".$dt['l12']."' and m='".$dt['m12']."' and n='".$dt['n12']."' and o='".$dt['o12']."' ";
	 $na_rek_bp = mysql_fetch_array(mysql_query($query_rek_bp));
	 $kode_rek_bp=$dt['k12'].'.'.$dt['l12'].'.'.$dt['m12'].'.'.$dt['n12'].'.'.$dt['o12'];

	 $query_akun_pemeliharaan = "select * from ref_jurnal where ka='".$dt['o1']."' and kb='".$dt['o2']."' and kc='".$dt['o3']."' and kd='".$dt['o4']."' and ke='".$dt['o5']."' and kf='".$dt['o6']."' ";
	 $na_akun_pemeliharaan=mysql_fetch_array(mysql_query($query_akun_pemeliharaan));
	 $kode_account_pemeliharaan=$dt['o1'].'.'.$dt['o2'].'.'.$dt['o3'].'.'.$dt['o4'].'.'.$dt['o5'].'.'.$dt['o6'];

	 $query_akun_beban_penyusutan = "select * from ref_jurnal where ka='".$dt['n1']."' and kb='".$dt['n2']."' and kc='".$dt['n3']."' and kd='".$dt['n4']."' and ke='".$dt['n5']."' and kf='".$dt['n6']."' ";
	 $na_akun_beban_penyusutan=mysql_fetch_array(mysql_query($query_akun_beban_penyusutan));
	 $kode_account_beban_penyusutan=$dt['n1'].'.'.$dt['n2'].'.'.$dt['n3'].'.'.$dt['n4'].'.'.$dt['n5'].'.'.$dt['n6'];
		//$readonly='readonly';
	  }

 	    $username=$_REQUEST['username'];

		$lengthKodeBrg =  12 + $Main->KODEBARANGJ_DIGIT ;
		$sampleKodeBrg = "*1.0.0.00.00.00.000" ;

		//query ref_batal
		$queryKB = "SELECT f,nama_barang FROM ref_barang_persediaan where f !=0 and g=0";

/*		$dt['residu'] = $dt['residu'] == '' ?0: $dt['residu'];
		$dt['masa_manfaat'] = $dt['masa_manfaat'] == '' ?0: $dt['masa_manfaat'];*/


       //items ----------------------
		  $this->form_fields = array(
/*			'' => array(
								'label'=>'Kode barang',
								'labelWidth'=>100,
								'value'=>'<b>BIDANG/KELOMPOK/SUB KELOMPOK/SUB SUB KELOMPOK/BARANG</b>',
								'type'=>'merge',
							 ),	*/

			'kode_barang' => array(
								'label'=>'KODE BARANG',
								'labelWidth'=>350,
								'value'=>"<input type='text' id='f1' name='f1' style='width:20px;' maxlength='1' onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='$f1' $chmod644> &nbsp <input type='text' id='f2' name='f2' style='width:20px;' maxlength='1' onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='$f2' $chmod644> &nbsp <input type='text' id='f' name='f' style='width:25px;' maxlength='1' onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='$f' $chmod644> &nbsp <input type='text' id='g' name='g' style='width:25px;' maxlength='2' onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='$g' $chmod644> &nbsp <input type='text' id='h' name='h' style='width:25px;' maxlength='2' onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='$h' $chmod644> &nbsp <input type='text' id='i' name='i' style='width:25px;' maxlength='2' onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='$i' $chmod644> &nbsp <input type='text' id='j' name='j' style='width:30px;' maxlength='3' onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='$j' $chmod644> &nbsp
									<font color=red>$sampleKodeBrg</font>"
									 ),

			'nama_barang' => array(
								'label'=>'NAMA BARANG',
								'labelWidth'=>350,
								'value'=>$dt['nm_barang'],
								'type'=>'text',
								'id'=>'nama_barang',
								'param'=>"style='width:250ppx;' size=50px"
									 ),
			'satuan' => array(
								'label'=>'SATUAN',
								'labelWidth'=>350,
								'value'=>$dt['satuan'],
								'type'=>'text',
								'id'=>'satuan',
								'param'=>"style='width:250ppx;' size=50px"
									 ),

			'krbmp21' => array(
								'label'=>'KODE REKENING BELANJA MODAL PERMEN 21',
								'labelWidth'=>350,
								'value'=>"<input type='text' name='krbmp21' value='".$kode_rek_bm."' size='10px' id='krbmp21' readonly>&nbsp
										  <input type='text' name='nbmp21' value='".$na_rek_bm['nm_rekening']."' size='50px' id='nrbmp21' readonly>&nbsp
										  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikrbmp21()' title='Cari Jurnal Aset Tetap' >"
									 ),
			'krbpp21' => array(
								'label'=>'KODE REKENING BELANJA PEMELIHARAAN PERMEN 21',
								'labelWidth'=>350,
								'value'=>"<input type='text' name='krbpp21' value='".$kode_rek_bp."' size='10px' id='krbpp21' readonly>&nbsp
										  <input type='text' name='nrbpp21' value='".$na_rek_bp['nm_rekening']."' size='50px' id='nrbpp21' readonly>&nbsp
										  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikrbpp21()' title='Cari Jurnal Aset Tetap' >"
									 ),
			'kabmp64' => array(
								'label'=>'<font color=red>KODE AKUN BELANJA MODAL PERMEN 64</font>',
								'labelWidth'=>350,
								'value'=>"<input type='text' name='kabmp64' value='".$kode_account_bm."' size='10px' id='kabmp64' readonly>&nbsp
										  <input type='text' name='nabmp64' value='".$na_bm['nm_account']."' size='50px' id='nabmp64' readonly>&nbsp
										  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikabmp64()' title='Cari Jurnal Aset Tetap' >"
									 ),

			'kabpp64j' => array(
								'label'=>'KODE AKUN BELANJA PEMELIHARAAN PERMEN 64 ',
								'labelWidth'=>350,
								'value'=>"<input type='text' name='kabpp64j' value='".$kode_account_pemeliharaan."' size='10px' id='kabpp64j' readonly>&nbsp
										  <input type='text' name='nabpp64j' value='".$na_akun_pemeliharaan['nm_account']."' size='50px' id='nabpp64j' readonly>&nbsp
										  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikabpp64j()' title='Cari Jurnal Belanja Modal Pemeliharaan' >"
									 ),
			'kaap64' => array(
								'label'=>'<font color=red>KODE AKUN ASET PERMEN 64</font>',
								'labelWidth'=>350,
								'value'=>"<input type='text' name='kaap64' value='".$kode_account_at."' size='10px' id='kaap64' readonly>&nbsp
										  <input type='text' name='naap64' value='".$na_at['nm_account']."' size='50px' id='naap64' readonly>&nbsp
										  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikaap64()' title='Cari Aset Tetap' >"
									 ),
			'kaapp64' => array(
								'label'=>'<font color=red>KODE AKUN AKUMULASI PENYUSUTAN PERMEN 64</font>',
								'labelWidth'=>350,
								'value'=>"<input type='text' name='kaapp64' value='".$kode_account_ap."' size='10px' id='kaapp64' readonly>&nbsp
										  <input type='text' name='naapp64' value='".$na_ap['nm_account']."' size='50px' id='naapp64' readonly>&nbsp
										  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikaapp64()' title='Cari Akun Akumulasi Penyusutan' >"
									 ),
			'kabpp64' => array(
								'label'=>'KODE AKUN BEBAN PENYUSUTAN PERMEN 64',
								'labelWidth'=>350,
								'value'=>"<input type='text' name='kabpp64' value='".$kode_account_beban_penyusutan."' size='10px' id='kabpp64' readonly>&nbsp
										  <input type='text' name='nabpp64' value='".$na_akun_beban_penyusutan['nm_account']."' size='50px' id='nabpp64' readonly>&nbsp
										  <input type='button' value='Cari' onclick ='".$this->Prefix.".Carikabpp64()' title='Cari Jurnal Aset Tetap' >"
									 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Batal kunjungan' > &nbsp &nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
		 $NomorColSpan = $Mode==1? 2: 1;
		 if($_REQUEST['filterJenisBarang'] != '2'){
			 $kolomHeadernya = "  	   <th class='th01' width='400'>JENIS</th>
			   	   <th class='th01' width='400'>OBYEK</th>
			   	   <th class='th01' width='400'>RINCIAN OBYEK</th>
			   	   <th class='th01' width='400'>SUB RINCIAN OBYEK</th>";
		 }else{
			 $kolomHeadernya = "
						<th class='th01' width='400'>OBYEK</th>
						<th class='th01' width='400'>RINCIAN OBYEK</th>
						<th class='th01' width='400'>SUB RINCIAN OBYEK</th>
						<th class='th01' width='400'>SUB SUB RINCIAN OBYEK</th>";
		 }
		 $headerTable =
		  "<thead>
		   <tr>
	  	   <th class='th01' width='5'>No.</th>
	  	   <th class='th01' width='100'>KODE BARANG</th>
	  	   <th class='th01' width='400'>NAMA BARANG</th>
				 	$kolomHeadernya
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
		 $kodeBarang =$f.".".$g.".".$h.".".$i.".".$j.".".$j1;
		 $kodeBarangLengkap =$f1.".".$f2.".".$f.".".$g.".".$h.".".$i.".".$j.".".$j1;
		 $getStatusCheckBox = mysql_fetch_array(mysql_query("select * from temp_rincian_belanja_barang_jasa where concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1) = '$kodeBarangLengkap' and username = '$this->username'"));
		 $status = $getStatusCheckBox['status'];

		 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j,'.',j1) ='$kodeBarang'"));
		 $namaBarang = $getNamaBarang['nm_barang'];
		 $getJenisBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='00' and h='00' and i='00' and j='000' and j1='0000'"));
		 $jenisBarang = $getJenisBarang['nm_barang'];
		 $getObyekBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='00' and i='00' and j='000'  and j1='0000'"));
		 $obyekBarang = $getObyekBarang['nm_barang'];
		 $getRincianObyekBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='00' and j='000'  and j1='0000'"));
		 $rincianObyekBarang = $getRincianObyekBarang['nm_barang'];
		 $getSubRincianObyekBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='000'  and j1='0000'"));
		 $subRincianObyekBarang = $getSubRincianObyekBarang['nm_barang'];

		 $Koloms[] = array('align="center"',"<span style='cursor:pointer;color:red;' onclick=$this->Prefix.windowSave('$kodeBarang')>$kodeBarang</span>");
		 $Koloms[] = array('align="left"',$namaBarang);
		 if($_REQUEST['filterJenisBarang'] == '1'){
			 $Koloms[] = array('align="left"',$jenisBarang);
			 $Koloms[] = array('align="left"',$obyekBarang);
			 $Koloms[] = array('align="left"',$rincianObyekBarang);
			 $Koloms[] = array('align="left"',$subRincianObyekBarang);
		 }else{
			 $getNamaObyek = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h='00' and i='00' and j='000' and j1='0000'"));
				$getNamaRincianObyek = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h='$h' and i='00' and j='000' and j1='0000'"));
		  	$getNamaSubRincianObyek = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h='$h' and i='$i' and j='000' and j1='0000' "));
				$getNamaSubSubRincianObyek = mysql_fetch_array(mysql_query("select * from ref_barang where f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and j1='0000'"));
				$Koloms[] = array('align="left" ',$getNamaObyek['nm_barang']);
		 	  $Koloms[] = array('align="left" ',$getNamaRincianObyek['nm_barang']);
		 	  $Koloms[] = array('align="left" ',$getNamaSubRincianObyek['nm_barang']);
		 	  $Koloms[] = array('align="left" ',$getNamaSubSubRincianObyek['nm_barang']);
		 }

		 $this->lastNomor += 1;


		 return $Koloms;
		}

	function genDaftarOpsi(){
	 global $Ref, $Main;


	$cmbAkun = '0';
	$cmbKelompok = '0';
	$cmbJenis = $_REQUEST['cmbJenis'];
	$cmbObyek = $_REQUEST['cmbObyek'];
	$cmbRincianObyek = $_REQUEST['cmbRincianObyek'];
	$cmbSubRincianObyek = $_REQUEST['cmbSubRincianObyek'];
	$cmbSubSubRincianObyek = $_REQUEST['cmbSubSubRincianObyek'];
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

	 $arrayJenisbarang = array(
								array('1', 'ASET'),
								 array('2', 'PERSEDIAAN'),


								);
	$filterJenisBarang = $_REQUEST['filterJenisBarang'];
	 $comboJenisBarang = cmbArray('filterJenisBarang',$filterJenisBarang,$arrayJenisbarang,'-- JENIS BARANG --',"onchange = $this->Prefix.refreshList(true);");
	 if($filterJenisBarang == '1'){
		 	$filterItem = "<tr>
			<td style='width:170px;' >JENIS</td><td>:</td>
			<td>".
			cmbQuery1("cmbJenis",$cmbJenis,"select f as valueCmbJenis, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f != '00'  and f != '08'  and g ='00' and h ='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			<tr>
			<td style='width:170px;'>OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbObyek",$cmbObyek,"select g as valueCmbObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g !='00' and h ='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td style='width:170px;'>RINCIAN OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbRincianObyek",$cmbRincianObyek,"select h as valueCmbRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h !='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>
			<tr>
			<td style='width:170px;'>SUB RINCIAN OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbSubRincianObyek",$cmbSubRincianObyek,"select i as valueCmbSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i != '00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>
			<tr>
			<td style='width:170px;'>SUB-SUB RINCIAN OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbSubSubRincianObyek",$cmbSubSubRincianObyek,"select j as valueCmbSubSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j != '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>";
	 }elseif($filterJenisBarang == '2'){
		 $cmbSubSubSubRincianObyek = $_REQUEST['cmbSubSubSubRincianObyek'];
		 $filterItem = "<tr>
		 <td style='width:170px;' >JENIS</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbJenis",$cmbJenis,"select f as valueCmbJenis, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '08'  and g ='00' and h ='00' and i='00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
		 </tr>
		 <tr>
		 <td style='width:170px;'>OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbObyek",$cmbObyek,"select g as valueCmbObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g !='00' and h ='00' and i='00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
		 </tr><tr>
		 <td style='width:170px;'>RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbRincianObyek",$cmbRincianObyek,"select h as valueCmbRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h !='00' and i='00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			 </tr>
		 <tr>
		 <td style='width:170px;'>SUB RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbSubRincianObyek",$cmbSubRincianObyek,"select i as valueCmbSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i != '00' and j = '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			 </tr>
		 <tr>
		 <td style='width:170px;'>SUB-SUB RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbSubSubRincianObyek",$cmbSubSubRincianObyek,"select j as valueCmbSubSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j != '000' and j1 = '0000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			</tr>
		 <tr>
		 <td style='width:170px;'>SUB-SUB-SUB RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbSubSubSubRincianObyek",$cmbSubSubSubRincianObyek,"select j1 , nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j = '$cmbSubSubRincianObyek' and j1 != '0000' ","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			</tr>
			 ";
	 }else{
		 $filterItem = "<tr>
		 <td style='width:170px;' >JENIS</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbJenis",$cmbJenis,"select f as valueCmbJenis, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f != '00'  and g ='00' and h ='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
		 </tr>
		 <tr>
		 <td style='width:170px;'>OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbObyek",$cmbObyek,"select g as valueCmbObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g !='00' and h ='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
		 </tr><tr>
		 <td style='width:170px;'>RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbRincianObyek",$cmbRincianObyek,"select h as valueCmbRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h !='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			 </tr>
		 <tr>
		 <td style='width:170px;'>SUB RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbSubRincianObyek",$cmbSubRincianObyek,"select i as valueCmbSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i != '00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			 </tr>
		 <tr>
		 <td style='width:170px;'>SUB-SUB RINCIAN OBYEK</td><td>:</td>
		 <td>".
		 cmbQuery1("cmbSubSubRincianObyek",$cmbSubSubRincianObyek,"select j as valueCmbSubSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j != '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
		 "</td>
			 </tr>";
	 }

	$TampilOpt =
			"<div class='FilterBar'>".


			"<table style='width:100%'>
			<tr>
			<td style='width:170px;' >JENIS BARANG</td><td>:</td>
			<td>".
			$comboJenisBarang.
			"</td>
			</tr>
			$filterItem

			</table>".
			"</div>".
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Kode Barang : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' size=20px>&nbsp
				Nama Barang : <input type='text' id='fmBARANG' name='fmBARANG' value='".$fmBARANG."' size=30px>&nbsp
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
			</table>".
			"</div>".
			"<input type='hidden' id='fmORDER18' name='fmORDER18' value='".$fmORDER18."'>".
			"<input type='hidden' id='fmORDER19' name='fmORDER19' value='".$fmORDER19."'>";
		return array('TampilOpt'=>$TampilOpt);
	}

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;

		//kondisi -----------------------------------


		$arrKondisi = array();
		$fmPILCARI = $_REQUEST['fmPILCARI'];
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
			$cmbAkun = '0';
		$cmbKelompok = '0';
		$cmbJenis = $_REQUEST['cmbJenis'];
		$cmbObyek = $_REQUEST['cmbObyek'];
		$cmbRincianObyek = $_REQUEST['cmbRincianObyek'];
		$cmbSubRincianObyek = $_REQUEST['cmbSubRincianObyek'];
		$cmbSubSubRincianObyek = $_REQUEST['cmbSubSubRincianObyek'];
		$fmMERK = $_REQUEST['fmMERK'];
		$fmTYPE = $_REQUEST['fmTYPE'];
		$filterJenisBarang = $_REQUEST['filterJenisBarang'];

		switch($fmPILCARI){
			case 'selectfg': $arrKondisi[] = " concat(f,g) like '%$fmPILCARIvalue%'"; break;
			case 'selectbarang': $arrKondisi[] = " nama_barang like '%".$fmPILCARIvalue."%'"; break;
		}

		if(empty($cmbJenis)) {
			$cmbObyek='';
			$cmbRincianObyek='';
			$cmbSubRincianObyek = '';
			$cmbSubSubRincianObyek = '';
		}else{
			$arrKondisi[]= "f =$cmbJenis";
		}
		if(empty($cmbObyek)) {
			$cmbRincianObyek='';
			$cmbSubRincianObyek = '';
			$cmbSubSubRincianObyek = '';
		}else{
			$arrKondisi[]= "g =$cmbObyek";
		}
		if(empty($cmbRincianObyek)) {
			$cmbSubRincianObyek = '';
			$cmbSubSubRincianObyek = '';
		}else{
			$arrKondisi[]= "h =$cmbRincianObyek";
		}
		if(empty($cmbSubRincianObyek)) {
			$cmbSubSubRincianObyek = '';
		}else{
			$arrKondisi[]= "i =$cmbSubRincianObyek";
		}
		if(empty($cmbSubSubRincianObyek)) {
		}else{
			$arrKondisi[]= "j =$cmbSubSubRincianObyek";
		}
		if(!empty($filterJenisBarang)){
				if($filterJenisBarang == '1'){
						$arrKondisi[] = "f !='08'";
				}else{
					$arrKondisi[] = "f ='08'";
					$arrKondisi[] = "j1 !='0000'";
				}
				if($filterJenisBarang == '2' && !empty($_REQUEST['cmbSubSubSubRincianObyek'])){
						$arrKondisi[]= "j1 =".$_REQUEST['cmbSubSubSubRincianObyek']."";
				}
		}



		if(!empty($_POST['fmKODE'])) $arrKondisi[] = " concat(f1,f2,f,g,h,i,j) like '".str_replace('.','',$_POST['fmKODE'])."%'";
		if(!empty($_POST['fmBARANG'])) $arrKondisi[] = " nm_barang like '%".$_POST['fmBARANG']."%'";
		$arrKondisi[] = "j !='000' ";
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
			$arrOrders[] = " concat(f1,f2,f,g,h,i,j) ASC " ;
			$Order= join(',',$arrOrders);
			$OrderDefault = '';// Order By no_terima desc ';
			$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;

		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);

		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal;
		$Limit = $Mode == 3 ? '': $Limit;
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}


}
$popupBarangSSH = new popupBarangSSHObj();
$arrayResult = VulnWalkerTahap('RKA-SKPD');
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$popupBarangSSH->jenisForm = $jenisForm;
$popupBarangSSH->nomorUrut = $nomorUrut;
$popupBarangSSH->tahun = $tahun;
$popupBarangSSH->jenisAnggaran = $jenisAnggaran;
$popupBarangSSH->idTahap = $idTahap;
?>
