<?php

class standarSatuanHargaObj  extends DaftarObj2{
	var $Prefix = 'standarSatuanHarga';
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
	var $fileNameExcel='Standar Satuan Harga.xls';
	var $Cetak_Judul = 'Standar Satuan Harga';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'standarSatuanHargaForm';
	var $kdbrg = '';
	var $pemisahID = ';';
	var $WHERE_O = "";

	function setTitle(){
		return 'Standar Satuan Harga';
	}
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus').
			"</td>";
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

	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;

	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 foreach ($_REQUEST as $key => $value) {
			$$key = $value;
	 }
	 if(empty($namaRekening)){
		 $err = "Pilih Rekening";
	 }elseif(empty($satuan)){
		 $err = "Isi Satuan";
	 }elseif(empty($uraian)){
		 $err = "Isi Uraian";
	 }elseif(empty($hargaSatuan)){
		 $err = "Isi Harga Satuan";
	 }elseif(empty($tahunBerlaku)){
		 $err = "Isi Tahun Belaku";
	 }
	 $f1 = "0";
	 $f2 = "0";
	 $f = "00";
	 $g = "00";
	 $h = "00";
	 $i = "00";
	 $j = "000";
	 $j1 = "0000";
	 $explodeKodeRekening = explode(".",$kodeRekening);

		if($fmST == 0){
				if($err==''){

						if(!empty($kodeBarang)){
								$explodeKodeBarang = explode(".",$kodeBarang);
								$f = $explodeKodeBarang[0];
								$g = $explodeKodeBarang[1];
								$h = $explodeKodeBarang[2];
								$i = $explodeKodeBarang[3];
								$j = $explodeKodeBarang[4];
								$j1 = $explodeKodeBarang[5];
						}
						$data = array(
												'k' => $explodeKodeRekening[0],
												'l' => $explodeKodeRekening[1],
												'm' => $explodeKodeRekening[2],
												'n' => $explodeKodeRekening[3],
												'o' => $explodeKodeRekening[4],
												'f1' => $f1,
												'f2' => $f2,
												'f' => $f,
												'g' => $g,
												'h' => $h,
												'i' => $i,
												'j' => $j,
												'j1' => $j1,
												'satuan' => $satuan,
												'uraian' => $uraian,
												'harga_satuan' => $hargaSatuan,
												'tahun_mulai_berlaku' => $tahunBerlaku,
												'keterangan' => $keterangan,
						);
						$query = VulnWalkerInsert("ref_standar_satuan_harga",$data);
						mysql_query($query);
						$cek = $query;

				}
			}elseif($fmST == 1){
				if($err==''){

					if(!empty($kodeBarang)){
							$explodeKodeBarang = explode(".",$kodeBarang);
							$f = $explodeKodeBarang[0];
							$g = $explodeKodeBarang[1];
							$h = $explodeKodeBarang[2];
							$i = $explodeKodeBarang[3];
							$j = $explodeKodeBarang[4];
							$j1 = $explodeKodeBarang[5];
					}
					$data = array(
											'k' => $explodeKodeRekening[0],
											'l' => $explodeKodeRekening[1],
											'm' => $explodeKodeRekening[2],
											'n' => $explodeKodeRekening[3],
											'o' => $explodeKodeRekening[4],
											'f1' => $f1,
											'f2' => $f2,
											'f' => $f,
											'g' => $g,
											'h' => $h,
											'i' => $i,
											'j' => $j,
											'j1' => $j1,
											'satuan' => $satuan,
											'uraian' => $uraian,
											'harga_satuan' => $hargaSatuan,
											'tahun_mulai_berlaku' => $tahunBerlaku,
											'keterangan' => $keterangan,
					);
					$query = VulnWalkerUpdate("ref_standar_satuan_harga",$data,"id = '$idplh'");
					mysql_query($query);
					$cek = $query;

				}
			}else{
			if($err==''){

				}
			}

			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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

		$ref_pilihbarang = $_REQUEST['id'];
		$kode_barang = explode(' ',$ref_pilihbarang);
		$f=$kode_barang[0];
		$g=$kode_barang[1];
		$h=$kode_barang[2];
		$i=$kode_barang[3];
		$j=$kode_barang[4];

		//query ambil data ref_program
		$get = mysql_fetch_array( mysql_query("select * from ref_barang where f=$f and g=$g and h=$h and i=$i and j=$j"));
		$kode_barang=$get['f'].'.'.$get['g'].'.'.$get['h'].'.'.$get['i'].'.'.$get['j'];

		$fmThnAnggaran=  $_COOKIE['coThnAnggaran'];
			$kueri1="select max(thn_akun) as thn_akun from ref_jurnal where thn_akun <= '$fmThnAnggaran'";
			$tmax = mysql_fetch_array(mysql_query($kueri1));
			$kueri="select * from ref_jurnal
					where thn_akun = '".$tmax['thn_akun']."'
					and ka='".$get['m1']."' and kb='".$get['m2']."'
					and kc='".$get['m3']."' and kd='".$get['m4']."'
					and ke='".$get['m5']."' and kf='".$get['m6']."'"; //echo "$kueri";
			$row=mysql_fetch_array(mysql_query($kueri));

			$kode_account =$row['ka'].".".$row['kb'].".".$row['kc'].".".$row['kd'].".".$row['ke'].".".$row['kf'];

		$content = array('IDBARANG'=>$kode_barang, 'NMBARANG'=>$get['nm_barang'], 'kode_account'=>$kode_account, 'nama_account'=>$row['nm_account'], 'tahun_account'=>$row['thn_akun']);
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
			 "<script src='js/skpd.js' type='text/javascript'></script>
			 <script type='text/javascript' src='js/master/standarSatuanHarga/".$this->Prefix.".js' language='JavaScript' ></script>
			 <script type='text/javascript' src='js/master/standarSatuanHarga/popupBarangSSH.js' language='JavaScript' ></script>
			 <script type='text/javascript' src='js/popup_rekening/popupRekening.js' language='JavaScript' ></script>
			 ".
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".

			$scriptload;
	}
	function Hapus_Validasi($id){//id -> multi id with space delimiter
		$errmsg ='';
		$kode_skpd = explode($this->pemisahID,$id);
		$c=$kode_skpd[0];
		$d=$kode_skpd[1];
		$e=$kode_skpd[2];
		$e1=$kode_skpd[3];
		if($errmsg=='' &&
				mysql_num_rows(mysql_query(
					"select Id from buku_induk where c='$c' and d='$d' and e='$e' and e1='$e1' ")
				) >0 )
			{ $errmsg = 'Gagal Hapus! SKPD Sudah ada di Buku Induk!';}
		return $errmsg;
	}
	//form ==================================

	function setFormBaru(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		//$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		//$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		//$e = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$cek = $cbid[0];

		$this->form_idplh = $cbid[0];
		//$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		/*$fmBIDANG = $_REQUEST['fmBIDANG'];
		$fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
		$fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
		$fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];
		if(!empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.'00'.'.'.'00'.'.'.'00'.'.'.'000';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.'00'.'.'.'00'.'.'.'000';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.'.'00'.'.'.'000';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.'.$fmSUBSUBKELOMPOK.'.'.'000';
		}

		$ck=mysql_fetch_array(mysql_query("select * from ref_skpd where concat(f,'.',g,'.',h,'.',i,'.',j)='".$dt['kode_barang']."' order by persen1 desc limit 0,1"));
		if($ck['Id'] != ''){
			$dt['persen1'] = $ck['persen2'];
			$dt['readonly'] = 'readonly';
		}else{
			$dt['persen1'] = '';
			$dt['readonly'] = '';
		}

		$fm = $this->setForm($dt);

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}*/
	$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		//$dt['c'] = $c;
	//	$dt['d'] = $d;
		//$dt['e'] = $e;
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
  	function setFormEdit(){
		/*$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$dt['c'] = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$dt['d'] = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$dt['e'] = $_REQUEST[$this->Prefix.'SkpdSUBUNIT'];
		$cek =$cbid[0];

		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		//query ambil data ref_tambah_manfaat
		$aqry = "select * from ref_skpd where Id='".$this->form_idplh."'"; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$dt['kode_barang']=$dt['f'].'.'.$dt['g'].'.'.$dt['h'].'.'.$dt['i'].'.'.$dt['j'];
		$dt['readonly'] = '';
		$fm = $this->setForm($dt);

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}*/
	$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		//$kode = explode(' ',$this->form_idplh);
		//$c=$kode[0];
		//$d=$kode[1];
		//$e=$kode[2];
		//$e1=$kode[3];
		$this->form_fmST = 1;
		//get data


		$fm = $this->setForm($cbid[0]);

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

	function setForm($dt){

		global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 550;
	 $this->form_height = 240;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
		$tahunBerlaku = date("Y");
	  }else{
		$this->form_caption = 'Edit';
		$readonly='readonly';
		$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id = '$dt'"));
			foreach ($getData as $key => $value) {
	 		 	$$key = $value;
	 	 	}
			$kodeRekening = $k.".".$l.".".$m.".".$n.".".$o;
			$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening'"));
			$namaRekening = $getNamaRekening['nm_rekening'];
			$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j.".".$j1;
			$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j,'.',j1) ='$kodeBarang'"));
			$namaBarang = $getNamaBarang['nm_barang'];
			$hargaSatuan = $harga_satuan;
			$tahunBerlaku = $tahun_mulai_berlaku;


	  }
	    //ambil data trefditeruskan

		//$kode1=genNumber($dt['c'],2);
		//$kode2=genNumber($dt['d'],2);
		//$kode3=genNumber($dt['e'],2);
		//$kode4=genNumber($dt['e1'],3);
		$nama=$dt['nama'];
		//$nama_barcode=$dt['nm_barcode'];

       //items ----------------------
		 $this->form_fields = array(

			'rekening' => array(
						'label'=>'REKENING',
						'labelWidth'=>100,
						'value'=>"
								<input type='hidden' name='kodeRekening' id = 'kodeRekening' value='$kodeRekening'>
								<input type='text' name='namaRekening' id='namaRekening' size='50' readonly value='".$namaRekening."'> &nbsp <input type='button' value='Cari' onclick=$this->Prefix.findRekening();>",
						'row_params'=>"valign='top'",
						'type'=>''
									 ),
			'barang' => array(
						'label'=>'BARANG',
						'labelWidth'=>100,
						'value'=>"
								<input type='hidden' name='kodeBarang' id = 'kodeBarang' value='$kodeBarang'>
								<input type='text' name='namaBarang' id='namaBarang' size='42' readonly value='".$namaBarang."'> &nbsp <input type='button' value='Cari' onclick=$this->Prefix.findBarang();> &nbsp <input type='button' value='Clear' onclick=$this->Prefix.clearBarang();>",
						'row_params'=>"valign='top'",
						'type'=>''
									 ),
			'satuabn' => array(
						'label'=>'SATUAN',
						'labelWidth'=>100,
						'value'=>"
								<input type='text' name='satuan' id='satuan' size='25'  value='".$satuan."'>",
						'row_params'=>"valign='top'",
						'type'=>''
									 ),
			'uraian' => array(
						'label'=>'URAIAN',
						'labelWidth'=>100,
						'value'=>"
								<input type='text' name='uraian' id='uraian' size='50'  value='".$uraian."'>",
						'row_params'=>"valign='top'",
						'type'=>''
									 ),
			'hargaSatuan' => array(
						'label'=>'HARGA SATUAN',
						'labelWidth'=>100,
						'value'=>"
								<input type='text' name='hargaSatuan' id='hargaSatuan' onkeypress='return event.charCode >= 48 && event.charCode <= 57' size='20'  value='".$hargaSatuan."' onkeyup='$this->Prefix.bantu();'> <span id='bantuSatuanHarga'>",
						'row_params'=>"valign='top'",
						'type'=>''
									 ),
			'tahunBerlaku' => array(
						'label'=>'TAHUN BERLAKU',
						'labelWidth'=>100,
						'value'=>"
								<input type='text' name='tahunBerlaku' id='tahunBerlaku' size='6' onkeypress='return event.charCode >= 48 && event.charCode <= 57' size='50'  value='".$tahunBerlaku."'>",
						'row_params'=>"valign='top'",
						'type'=>''
									 ),
			'keterangan' => array(
						'label'=>'KETERANGAN',
						'labelWidth'=>100,
						'value'=>"
								<textarea type='text' name='keterangan' id='keterangan' style='margin: 0px; width: 360px; height: 77px;'>$keterangan</textarea> ",
						'row_params'=>"valign='top'",
						'type'=>''
									 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' > &nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	$NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='20' >No.</th>
  	   $Checkbox

	   <th class='th01' width='200' align='center'>KODE REKENING</th>
	   <th class='th01' width='200' align='center'>BARANG</th>
	   <th class='th01' width='200' align='center'>SATUAN</th>
	   <th class='th01' width='200' align='center'>URAIAN</th>
	   <th class='th01' width='200' align='center'>HARGA SATUAN</th>

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
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $kodeRekening = $k.".".$l.".".$m.".".$n.".".$o;
	 $kodeBarang = $f.".".$g.".".$h.".".$i.".".$j.".".$j1;


	 $getDataRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening'"));
	 $getDataBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j,'.',j1) = '$kodeBarang'"));
	 $textSpanKodeRekening = $kodeRekening."<br>".$getDataRekening['nm_rekening'];
	 $textSpanKodeBarang = $getDataBarang['nm_barang'];
	 $hargaSatuan = number_format($harga_satuan,2,',','.');
	 if($kodeRekening == $this->lastKodeRekening){
		 	$textSpanKodeRekening = "";
	 }
	 $Koloms[] = array('align="left"',$textSpanKodeRekening);
	 $Koloms[] = array('align="left"',$textSpanKodeBarang);
	 $Koloms[] = array('align="left"',$satuan);
	 $Koloms[] = array('align="left"',$uraian);
	 $Koloms[] = array('align="right"',$hargaSatuan);
	 $this->lastKodeRekening = $kodeRekening;


	 return $Koloms;
	}



	function genDaftarOpsi(){
	 global $Ref, $Main;

	 foreach ($_REQUEST as $key => $value) {
	 	 $$key = $value;
	 }
	 $fmBIDANG ="5";
 $fmKELOMPOK = "2";
 $fmSUBKELOMPOK =cekPOST('fmSUBKELOMPOK');
 $fmSUBSUBKELOMPOK = cekPOST('fmSUBSUBKELOMPOK');
 $fmSUBSUBSUBKELOMPOK = cekPOST('fmSUBSUBSUBKELOMPOK');
	if(empty($jumlahData))$jumlahData="25";
	 $TampilOpt =

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
 			cmbQuery1("fmKELOMPOK",$fmKELOMPOK,"select l,nm_rekening from ref_rekening where k='$fmBIDANG' and l !='0' and m = '0' and n='00' and o='$this->WHERE_O'","onChange=\"$this->Prefix.refreshList(true)\" disabled",'Pilih','').
 			"</td>
 			</tr><tr>
 			<td>SUB KELOMPOK</td><td>:</td>
 			<td>".
 			cmbQuery1("fmSUBKELOMPOK",$fmSUBKELOMPOK,"select m,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m != '0' and n='00' and o='$this->WHERE_O'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
 			"</td>
 			</tr>
			<tr>
 			<td>SUB SUB KELOMPOK</td><td>:</td>
 			<td>".
 			cmbQuery1("fmSUBSUBKELOMPOK",$fmSUBSUBKELOMPOK,"select n,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m = '$fmSUBKELOMPOK' and n!='00' and o='$this->WHERE_O'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
 			"</td>
 				</tr>
			<tr>
 			<td>SUB SUB KELOMPOK</td><td>:</td>
 			<td>".
			cmbQuery1("fmSUBSUBSUBKELOMPOK",$fmSUBSUBSUBKELOMPOK,"select o,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m = '$fmSUBKELOMPOK' and n='$fmSUBSUBKELOMPOK' and o!='$this->WHERE_O'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
 				</tr>

 			</table>".
 			"</div>".
 			"<div class='FilterBar'>".
 			"<table style='width:100%'>
 			<tr><td>
			Uraian  &nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp &nbsp&nbsp: &nbsp&nbsp<input type='text' id='filterUraian' name='filterUraian' value='".$filterUraian."' size=40px> &nbsp Jumlah Data : <input type='text' name='jumlahData' id = 'jumlahData' style='width:30px;' value='$jumlahData'>
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
		$UID = $_COOKIE['coID'];

		foreach ($_REQUEST as $key => $value) {
 			$$key = $value;
 	 	}
	 //kondisi -----------------------------------
		$arrKondisi = array();

					$arrKondisi[] = "k = '5'";



					$arrKondisi[] = "l = '2'";



					$arrKondisi[]  = "o!='$this->WHERE_O'";


				if(!empty($fmSUBKELOMPOK)){
					$arrKondisi[] = "m = '$fmSUBKELOMPOK'";
				}
				if(!empty($fmSUBSUBKELOMPOK)){
					$arrKondisi[] = "n = '$fmSUBSUBKELOMPOK'";
				}
				if(!empty($fmSUBSUBSUBKELOMPOK)){
					$arrKondisi[] = "o = '$fmSUBSUBSUBKELOMPOK'";
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
		$arrOrders[] = "concat(k,'.',l,'.',m,'.',n,'.',o,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1)";
		switch($fmORDER1){
			//case '1': $arrOrders[] = " k,l,m,n,o $Asc1 " ;break;
			case '1': $arrOrders[] = " nama $Asc1 " ;break;

		}
		$Order= join(',',$arrOrders);
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//$Order ="";
		//limit --------------------------------------
		/**$HalDefault=cekPOST($this->Prefix.'_hal',1);	//Cat:Settingan Lama
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;
		**/
		$this->pagePerHal = $jumlahData;
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}
}
$standarSatuanHarga = new standarSatuanHargaObj();
$standarSatuanHarga->username = $_COOKIE['coID'];
if($Main->REK_DIGIT_O == 0){
	$standarSatuanHarga->WHERE_O = "00";
}else{
	$standarSatuanHarga->WHERE_O = "000";
}
?>
