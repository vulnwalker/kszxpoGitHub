
<?php

class pengaturanPersediaanObj  extends DaftarObj2{
	var $Prefix = 'pengaturanPersediaan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'pengaturanPersediaan'; //bonus
	var $TblName_Hapus = 'pengaturanPersediaan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'PERSEDIAAN';
	var $PageIcon = 'images/perencanaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pengaturanPersediaan.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'pengaturanPersediaan';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'pengaturanPersediaanForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0
	var $FieldC1 = 0;
	var $arrEselon = array(
		array('1','ESELON I'),
		array('2','ESELON II'),
		array('3','ESELON III'),
		array('4','ESELON IV'),
		array('5','ESELON V')
		);

	var $jns_trans = array(
			//array('selectAll','Semua'),
			array('1','PENGADAAN BARANG'),
			array('2','PEMELIHARAAN BARANG'),
			);

	var $arr_pencairan_dana = array(
			array('1', "SPP-LS"),
			array('2', "SPP-UP"),
			array('3', "SPP-GU"),
			array('4', "SPP-TU"),
			);

	var $arr_cara_bayar = array(
			//array('selectAll','Semua'),
			array('1','UANG MUKA'),
			array('2','TERMIN'),
			array('3','PELUNASAN'),
			);

	var $CekDistribusi = 1; //1=Ya, 0=Tidak

	function setTitle(){
		return 'PENGATURAN PERSEDIAAN';
	}

	function setMenuEdit(){
		return "";
	}

	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $nama= $_REQUEST['nama'];

	 if( $err=='' && $nama =='' ) $err= 'Satuan Belum Di Isi !!';

			if($fmST == 0){
				if($err==''){
					$aqry = "INSERT into ref_satuan (nama)values('$nama')";	$cek .= $aqry;
					$qry = mysql_query($aqry);
				}
			}else{
				if($err==''){
				$aqry = "UPDATE ref_satuan set nama='$nama' WHERE Id='".$idplh."'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());
					}
			} //end else

			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
    }

	function SimpanUbah(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 foreach ($_REQUEST as $key => $value) {
		 $$key = $value;
	 }

	if(substr($tanggalPersediaanAwal, -4) !=$_COOKIE['coThnAnggaran']){
			 $err = "Tahun harus sama dengan tahun login ";
	 }
	 if($err == ""){
		 $dataUpdate =array(
											 'tanggal' => $this->generateDate($tanggalPersediaanAwal),
											 'asal_data_barang' => $asalData,
											 'metode_perhitungan' => $metodePerhitungan,
											 'tanggal_cek' => $this->generateDate($tanggalCekFisik),
											 'stock_of_name' => $metodeStokOfName,
		 );
		 $query = VulnWalkerUpdate("pengaturan_persediaan",$dataUpdate,"tahun = '".$_COOKIE['coThnAnggaran']."'");
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

		case 'UbahPengaturan':{
			$fm = $this->UbahData();
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
			case 'getYearRange':{
				$yearRange = $_COOKIE['coThnAnggaran'] - date("Y");
				$content = array(
													'yearRange' => $yearRange.":".$yearRange
				);
			break;
			}
		case 'SimpanUbah':{
			$get= $this->SimpanUbah();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }

		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}

		case 'pilihan':{
				$fm = $this->setTemplate();
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

   function setPage_OtherScript(){
		$scriptload =
					"<script>
						$(document).ready(function(){
							".$this->Prefix.".loading();
						});
					</script>";
		return
			"<script type='text/javascript' src='js/persediaan/saldoAwal/pengaturanPersediaan.js' language='JavaScript' ></script>".
			'
				<link rel="stylesheet" href="datepicker/jquery-ui.css">
				<script src="datepicker/jquery-1.12.4.js"></script>
				<script src="datepicker/jquery-ui.js"></script>
			'.
			$scriptload;
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
		$this->form_fmST = 1;
		//get data
		$aqry = "SELECT * FROM  ref_satuan WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);

		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

	function setForm($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 50;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
		$nip	 = '';
	  }else{
		$this->form_caption = 'Edit';
		$Id = $dt['Id'];
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);

	 //items ----------------------
	  $this->form_fields = array(
			'nama' => array(
						'label'=>'Satuan',
						'labelWidth'=>100,
						'value'=>$dt['nama'],
						'type'=>'text',
						'param'=>"style='width:200px;'"
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

	function setPage_HeaderOther(){

return
"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>

<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>

<A href=\"pages.php?Pg=saldoAwal\" title='SALDO AWAL'  > SALDO AWAL </a> |
<A href=\"pages.php?Pg=pengaturanPersediaan\" title='PENGATURAN' style='color : blue;' > PENGATURAN </a>

&nbsp&nbsp&nbsp
</td></tr>
</table>";
}

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
	  	   <th class='th01' width='5'>No.</th>".
	  	   /*$Checkbox*/"
		   <th class='th01'>NAMA</th>
		   <th class='th01'>JUMLAH</th>
	   </thead>";

		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;

	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  /*if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);*/
	 $Koloms[] = array('align="left" width="15%"',"<a href='javascript:".$this->Prefix.".pilihan(`".$isi['id']."`)' >".$isi['nama']."</a>");
	 $Koloms[] = array('align="right"',number_format($isi['jumlah'],0,'.',','));
	 return $Koloms;
	}

	function setMenuView(){
		return

			"";

	}

	function genDaftarOpsi(){
	 global $Ref, $Main;


	 $getData = mysql_fetch_array(mysql_query("select * from pengaturan_persediaan"));
	 foreach ($getData as $key => $value) {
			 $$key = $value;
		}
		if($asal_data_barang =='1'){
				$asalBarang = "Barang dari referensi. ";
		}elseif($asal_data_barang =='2'){
				$asalBarang = "Barang dari persediaan. ";
		}
		// if($program_kegiatan =='1'){
		// 		$programKegiatan = "YA";
		// }elseif($program_kegiatan =='2'){
		// 		$programKegiatan = "TIDAK";
		// }
		$tanggalCekFisik = $this->generateDate($tanggal_cek);
		if($metode_perhitungan =='1'){
				$metodePerhitungan = "Metode FIFO.  ";
		}elseif($metode_perhitungan =='2'){
				$metodePerhitungan = "Metode Harga Pembelian Terakhir.";
		}
		if($stock_of_name =='1'){
				$metodeStokOfName = "Tahunan.  ";
		}elseif($stock_of_name =='2'){
				$metodeStokOfName = "Semesteran.";
		}elseif($stock_of_name =='3'){
				$metodeStokOfName = "Triwulan.";
		}
	$TampilOpt =
			//<table width=\"100%\" class=\"adminform\">
			"<tr><td>".
			$vOrder=
			"<div id='DaftarPengaturan'>".
			genFilterBar(
				array(

					$this->isiform(
						array(


							array(
								'label'=>'<b>TANGGAL PERSEDIAAN AWAL</b>',
								'name'=>'tahun',
								'label-width'=>'230px;',
								'value'=>$this->generateDate($tanggal),
							),
							array(
								'label'=>'<b>TANGGAL CEK FISIK</b>',
								'name'=>'sad',
								'label-width'=>'230px;',
								'value'=>$tanggalCekFisik,
							),
							array(
								'label'=>'<b>PENGELUARAN BARANG</b>',
								'name'=>'sad',
								'label-width'=>'230px;',
								'value'=>$asalBarang,
													),
							array(
								'label'=>'<b>METODE PERHITUNGAN PERSEDIAAN</b>',
								'name'=>'sad',
								'label-width'=>'230px;',
								'value'=>$metodePerhitungan,
							),
							array(
								'label'=>'<b>METODE STOK OF NAME</b>',
								'name'=>'asd',
								'label-width'=>'230px;',
								'value'=>$metodeStokOfName,
							),

						)
					).
					"<table>
						<tr>
							<td>".$this->buttonnya($this->Prefix.'.UbahData()','edit_f2.png','UBAH','UBAH','UBAH')."</td>

						</tr>".
					"</table>"
				),
				'','').
				"</div>"
				;


		return array('TampilOpt'=>$TampilOpt);
	}
  function generateDate($tanggal){
      $tanggal = explode("-",$tanggal);
      return $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];
  }
	function UbahData(){
		global $Ref, $Main;

    $getData = mysql_fetch_array(mysql_query("select * from pengaturan_persediaan"));
    foreach ($getData as $key => $value) {
        $$key = $value;
     }
		 // if($program_kegiatan == '1'){
			//  	$checkedYaProgramKegiatan = "checked";
		 // }elseif($program_kegiatan == '2'){
			//  	$checkedTidakProgramKegiatan = "checked";
		 // }
		 $tanggalCekFisik = $tanggal_cek;
		 if($asal_data_barang == '1'){
			 	$checkedStatusDataReferensi = "checked";
		 }elseif($asal_data_barang == '2'){
			 	$checkedStatusPersediaan = "checked";
		 }
		 if($metode_perhitungan == '1'){
			 	$checkedFifo = "checked";
		 }elseif($metode_perhitungan == '2'){
			 	$checkedPembelianTerakhir = "checked";
		 }
		 if($stock_of_name == '1'){
			 	$checkedTahunan = "checked";
		 }elseif($stock_of_name == '2'){
			 	$checkedSemesteran = "checked";
		 }elseif($stock_of_name == '3'){
			 	$checkedTriwulan = "checked";
		 }
		$cek='';$err='';
		$content =
			genFilterBar(
				array(

					$this->isiform(
						array(

							array(
								'label'=>'<b>TANGGAL PERSEDIAAN AWAL</b>',
								'name'=>'tahun',
								'label-width'=>'230px;',
								'value'=>"<input type ='text' id='tanggalPersediaanAwal' name='tanggalPersediaanAwal' value='".$this->generateDate($tanggal)."' style='width:200px;'>",
							),
							array(
								'label'=>'<b>TANGGAL CEK</b>',
								'name'=>'jenisAnggaran',
								'label-width'=>'230px;',
								'value'=>"<input type ='text' id='tanggalCekFisik' name='tanggalCekFisik' value='".$this->generateDate($tanggalCekFisik)."' style='width:200px;'>",
							),
							array(
								'label'=>'<b>PENGELUARAN BARANG</b>',
								'name'=>'jenisAnggaran',
								'label-width'=>'230px;',
								'value'=>"",
							),
							array(
								'label'=>"<input type='radio' name='asalData' id='dataReferensi' value='1' $checkedStatusDataReferensi> Barang dari referensi. <br>
                          <input type='radio' name='asalData' id='dataPersediaan' value='2'  $checkedStatusPersediaan> Barang dari persediaan.",
								'name'=>'asdasd',
								'value'=>"",
                'pemisah' => ''
							),
							array(
								'label'=>'<b>METODE PERHITUNGAN</b>',
								'name'=>'asd',
								'label-width'=>'230px;',
								'value'=>"",
							),
							array(
								'label'=>"<input type='radio' name='metodePerhitungan' value='1' id='metodeFifo' $checkedFifo> Metode FIFO. <br>
                          <input type='radio' name='metodePerhitungan' value='2' id='metodePembelianTerakhir' $checkedPembelianTerakhir> Metode Harga Pembelian Terakhir.",
								'name'=>'asdasd',
								'value'=>"",
								'pemisah' => ''
							),
							array(
								'label'=>'<b>METODE STOK OF NAME</b>',
								'name'=>'asd',
								'label-width'=>'230px;',
								'value'=>"",
							),
							array(
								'label'=>"<input type='radio' name='metodeStokOfName' value='1' id='tahunan' $checkedTahunan> Tahunan. <br>
                          <input type='radio' name='metodeStokOfName' value='2' id='semesteran' $checkedSemesteran> Semesteran <br>
                          <input type='radio' name='metodeStokOfName' value='3' id='triwulan' $checkedTriwulan> Triwulan <br>
													.",
								'name'=>'asdasd',
								'value'=>"",
                'pemisah' => ''
							),

						)
					).
					"
					<input type='hidden' name='IDNYA' id='IDNYA' value='".$daqry['Id']."'/>
					<table>
						<tr>
							<td>".$this->buttonnya($this->Prefix.'.SimpanUbahData()','save_f2.png','SIMPAN','SIMPAN','SIMPAN')."</td>
							<td>".$this->buttonnya($this->Prefix.'.loading()','cancel_f2.png','BATAL','BATAL','BATAL')."</td>

						</tr>".
					"</table>"
				),
				'','')
				;

		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
		//kondisi -----------------------------------

		$arrKondisi = array();

		$fmPILCARI = $_REQUEST['fmPILCARI'];
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn
		$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];


		if($fmPILCARIvalue !='')$arrKondisi[] = " nama like '%$fmPILCARIvalue%' ";
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();

		/*if($fmORDER1 == ''){
			$arrOrders[] = " bk ";
			$arrOrders[] = " ck ";
			$arrOrders[] = " dk ";
			$arrOrders[] = " p ";
		}
		switch($fmORDER1){
			case '1': $arrOrders[] = " p $Asc1 " ;break;
		}	*/
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

	/*function setTopBar(){
	   	return '';
	}	*/



	function isiform($value, $parram=''){
		$isinya = '';
		$tbl ='<table width="100%" '.$parram.'>';
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

			$pemisah = ':';
			if(isset($value[$i]['pemisah']))$pemisah = $value[$i]['pemisah'];

			$tbl .= "
				<tr>
					<td width='".$value[$i]['label-width']."' valign='top'>".$value[$i]['label']."</td>
					<td width='10px' valign='top'>$pemisah<br></td>
					<td align='".$value[$i]['align']."' valign='".$value[$i]['valign']."'> $isinya</td>
				</tr>
			";
		}
		$tbl .= '</table>';

		return $tbl;
	}

	function buttonnya($js,$img,$name,$alt,$judul){
		return "<table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
					<tbody><tr valign='middle' align='center'>
					<td class='border:none'>
						<a class='toolbar' id='btsave'
							href='javascript:$js'>
						<img src='images/administrator/images/$img' alt='$alt' name='$name' width='32' height='32' border='0' align='middle' title='$judul'> $judul</a>
					</td>
					</tr>
					</tbody></table> ";
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

		if(!isset($_REQUEST['halman']))$_REQUEST['halman']='1';
		return

		//"<html xmlns='http://www.w3.org/1999/xhtml'>".
		"<html>".
			$this->genHTMLHead().
			"<body >".
			/*"<div id='pageheader'>".$this->setPage_Header()."</div>".
			"<div id='pagecontent'>".$this->setPage_Content()."</div>".
			$Main->CopyRight.*/

			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0' width='100%' height='100%' >".
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
//

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
			"</table>

			".
			/*'<script src="assets2/js/bootstrap.min.js"></script>'.
			'<script src="assets2/jquery.min.js"></script>'.*/
			"</body>
		</html>";
	}




}
$pengaturanPersediaan = new pengaturanPersediaanObj();
?>
