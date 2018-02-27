<?php

class rincianBelanjaBarangJasaObj  extends DaftarObj2{
	var $Prefix = 'rincianBelanjaBarangJasa';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = "ref_rekening "; //daftar
	var $TblName_Hapus = 'ref_std_kebutuhan_barang_jasa';
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
	var $Cetak_Judul = 'DAFTAR RINCIAN BELANJA BARANG JASA';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'rincianBelanjaBarangJasaForm';
	var $kode_skpd = '';
	var $username = '';
	var $WHERE_O = "";

	function setTitle(){
		return 'DAFTAR RINCIAN BELANJA BARANG JASA';
	}
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".editData()","publishdata.png","Mapping ", 'Mapping ')."</td>"
			// .
			// "<td>".genPanelIcon("javascript:".$this->Prefix.".editData()","edit_f2.png","Edit", 'Edit')."</td>".
			// // "<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus').
			// "</td>"
			;
	}
	function setMenuView(){
		return "";
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
	 if(mysql_num_rows(mysql_query("select * from temp_rincian_belanja_barang_jasa where username = '$this->username' and status ='checked'")) == 0){
	 	$err ="Pilih Barang !";
	 }elseif(empty($kodeRekening)){
	 	$err ="Pilih Kode Rekening !";
	 }



				if($err==''){
						$explodingKodeRekening = explode('.', $kodeRekening);
						$k = $explodingKodeRekening[0];
						$l = $explodingKodeRekening[1];
						$m = $explodingKodeRekening[2];
						$n = $explodingKodeRekening[3];
						$o = $explodingKodeRekening[4];
						$getData = mysql_query("select * from temp_rincian_belanja_barang_jasa where username = '$this->username' ");
						while($rows = mysql_fetch_array($getData)){
							foreach ($rows as $key => $value) {
								 $$key = $value;
							}
							if($status == ''){
								$data = array(
												'k12' => '',
												'l12' => '',
												'm12' => '',
												'n12' => '',
												'o12' => '',
											);
							}else{
								$data = array(
												'k12' => $k,
												'l12' => $l,
												'm12' => $m,
												'n12' => $n,
												'o12' => $o,
											);
							}

							$query = VulnWalkerUpdate("ref_barang",$data,"f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' ");
							mysql_query($query);

						}


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
			mysql_query("delete from temp_rincian_belanja_barang_jasa where username ='$this->username'");
			$fm = $this->setFormBaru();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'saveData':{
			foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
			}
			$data = array('jumlah' => $jumlahBarang);
			$query = VulnWalkerUpdate($this->TblName,$data,"concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$kode'");
			mysql_query($query);

		break;
		}
		case 'editData':{
			foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
				}
			$kodeRekening = explode(" ",  $rincianBelanjaBarangJasa_cb[0]);
			$k = $kodeRekening[0];
			$l = $kodeRekening[1];
			$m = $kodeRekening[2];
			$n = $kodeRekening[3];
			$o = $kodeRekening[4];

			mysql_query("delete from temp_rincian_belanja_barang_jasa where username ='$this->username'");
			$getData = mysql_query("select * from ref_barang where k12='".$k."' and l12='".$l."' and m12='".$m."' and n12='".$n."' and o12='".$o."' ");
			$kodeRekening	= $k.".".$l.".".$m.".".$n.".".$o;
			while ($rows = mysql_fetch_array($getData)) {
				foreach ($rows as $key => $value) {
				 $$key = $value;
				}
				$data = array(
								'f1' => $f1,
								'f2' => $f2,
								'f' => $f,
								'g' => $g,
								'h' => $h,
								'i' => $i,
								'j' => $j,
								'username' => $_COOKIE['coID'],
								'status' => 'checked',
							);
				$query = VulnWalkerInsert("temp_rincian_belanja_barang_jasa",$data);
				mysql_query($query);
			}


			$fm = $this->setFormEdit($kodeRekening);
			$cek = "select * from ref_barang where concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j) ='$kodeBarang'";
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
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/master/rincianBelanjaBarangJasa/rincianBelanjaBarangJasa.js' language='JavaScript' ></script>
			 <script type='text/javascript' src='js/popup_rekening/popupRekening.js' language='JavaScript' ></script>
			 ".
			 "<script type='text/javascript' src='js/master/rincianBelanjaBarangJasa/listBarangBelanjaBarangJasa.js' language='JavaScript' ></script>".
			$scriptload;
	}

	//form ==================================
	function setFormBaru(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$dt=array();

		$c1 = $_REQUEST[$this->Prefix.'SkpdfmUrusan'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$e1 = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];

		$dt['c1'] = $c1;
		$dt['c'] = $c;
		$dt['d'] = $d;
		$dt['e'] = $e;
		$dt['e1'] = $e1;
		//if(mysql_num_rows(mysql_query("select * from temp_standar_kebutuhan where username = '$this->username'")) == 0){
			//	$this->copyDataBarang();
		//	}
		mysql_query("delete from temp_standar_kebutuhan where username = '$this->username'");

		$cek =$cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$fm = $this->setForm($dt);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

  	function setFormEdit($kodeRekening){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek =$cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;

		$aqry = "select * from ref_std_kebutuhan_barang_jasa where concat(c1,' ',c,' ',d,' ',e,' ',e1,' ',f,' ',g,' ',h,' ',i,' ',j) ='".$this->form_idplh."' "; $cek.=$aqry;


		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($kodeRekening);


		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

	function setForm($kodeRekening){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';

	 $json = TRUE;	//$ErrMsg = 'tes';

	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 900;
	 $this->form_height = 200;
		$this->form_caption = 'BARU';


		foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where concat(k,'.',l,'.',m,'.',n,'.',o) = '$kodeRekening'"));
			$namaRekening = $getNamaRekening['nm_rekening'];

       //items ----------------------
		  $this->form_fields = array(

		   	'infoSKPD' => array(
						'label'=>'',
						'value'=>
								"<div class='FilterBar'><table style='width:100%'>
								<tbody>
								<tr>
								<td style='width:170px;'>KODE REKENING</td>
								<td style='
								    width: 20px;
								    height: 20px;
								'>:</td>
								<td><input type='text' name='kodeRekening' id='kodeRekening' value='$kodeRekening' style='width:100px;' readonly> &nbsp <input type='text' value='$namaRekening' name ='namaRekening' style='width:1000px;' id='namaRekening' readonly> </td>
								</tr>

								</tbody></table></div>"
							,

						'type'=>'merge'
					 ),
			'asdas' => array(
						'label'=>'',
						'value'=>"

						<div id='listBarang' style='height:5px'>
							"."<div id='listBarangBelanjaBarangJasa_cont_title' style='position:relative'></div>".
			"<div id='listBarangBelanjaBarangJasa_cont_opsi' style='position:relative'>".
			"</div>".
			"<div id='listBarangBelanjaBarangJasa_cont_daftar' style='position:relative'></div>".
			"<div id='listBarangBelanjaBarangJasa_cont_hal' style='position:relative'></div>"."
						</div>",

						'type'=>'merge'
					 ),
			);
		//tombol
		$this->form_menubawah =
			"
			<input type='hidden' id ='c1' name ='c1' value='$rincianBelanjaBarangJasaSkpdfmUrusan'>
			<input type='hidden' id ='c' name ='c' value='$rincianBelanjaBarangJasaSkpdfmSKPD'>
			<input type='hidden' id ='d' name ='d' value='$rincianBelanjaBarangJasaSkpdfmUNIT'>
			<input type='hidden' id ='e' name ='e' value='$rincianBelanjaBarangJasaSkpdfmSUBUNIT'>
			<input type='hidden' id ='e1' name ='e1' value='$rincianBelanjaBarangJasaSkpdfmSEKSI'>

			<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Batal kunjungan' >&nbsp &nbsp ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm2();
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


			$tergantung = "100";

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
	function genForm2($withForm=TRUE){
		$form_name = 'listBarangBelanjaBarangJasaForm';

		if($withForm){
			$params->tipe=1;
			$form= "<form name='$form_name' id='$form_name' method='post' action=''>".
				createDialog(
					$form_name.'_div',
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height,
					'',$params
					).
				"</form>";

		}else{
			$form=
				createDialog(
					$form_name.'_div',
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height
				);


		}
		return $form;
	}

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	 "<thead>
	 <tr>
  	   <th class='th01' width='20' >No.</th>
  	   $Checkbox

	   <th class='th01' align='center' width='300'>NAMA REKENING</th>
   	   <th class='th01' align='center' width='20'>NO</th>
   	   <th class='th01' align='center' width='80'>KODE BARANG</th>
	   <th class='th01' align='center' width='700'>NAMA BARANG</th>
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

	  $kodeRekening = $isi['k'].".".$isi['l'].".".$isi['m'].".".$isi['n'].".".$isi['o'];

	 $Koloms[] = array('align="center" width="20"', $no.'.' );
	 if($kodeRekening == $this->lastKodeRekening){
	  $this->nomorUrut += 1;
	 }else{
	  $this->nomorUrut = 1;
	 }
	  $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
	 $namaRekening = $getNamaRekening['nm_rekening'];
	 $this->lastKodeRekening = $kodeRekening;
	 if($this->nomorUrut == 1){
	  $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 }else{
	  $Koloms[] = array(" align='center'  ", "");
	  $namaRekening = "";
	  $kodeRekening = "";
	 }
	 if(mysql_num_rows(mysql_query("select * from ref_barang where k12='$k' and l12='$l' and m12='$m' and n12='$n' and o12='$o'")) == 0){
	    $warnaStatus="red";
	    $listKodebarang = "";
	    $listNomorUrut = "";
	    $listNamaBarang = "";
	 }else{
	    $getAllBarangFromRekening = mysql_query("select * from ref_barang where k12='$k' and l12='$l' and m12='$m' and n12='$n' and o12='$o'");
	    $nomorUrut = 1;
	    while($dataBarang = mysql_fetch_array($getAllBarangFromRekening)){
	        $listKodebarang .= $dataBarang['f'].".".$dataBarang['g'].".".$dataBarang['h'].".".$dataBarang['i'].".".$dataBarang['j']."<br>";
	        $listNomorUrut .= $nomorUrut."<br>";
	        $kodeBarang = $dataBarang['f'].".".$dataBarang['g'].".".$dataBarang['h'].".".$dataBarang['i'].".".$dataBarang['j'];
	        $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
	        $getBarang = mysql_fetch_array(mysql_query($syntax));
	        $listNamaBarang.=$getBarang['nm_barang']."<br>";
	        $nomorUrut += 1;
	    }
	 }


	 $Koloms[] = array('align="left" " ',"<span style='color:$warnaStatus;'>".$kodeRekening."</span><br>".$namaRekening );
	 $Koloms[] = array('align="right"  ',$listNomorUrut );


	 $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;

	 $Koloms[] = array('align="center" ',$listKodebarang);

	 $Koloms[] = array('align="left"',$listNamaBarang);

	 return $Koloms;
	}

	function genDaftarOpsi(){
	 global $Ref, $Main,  $HTTP_COOKIE_VARS;

	 $cmbAkun = '0';
	 $cmbKelompok = '0';
	 $cmbJenis = $_REQUEST['cmbJenis'];
	 $cmbObyek = $_REQUEST['cmbObyek'];
	 $cmbRincianObyek = $_REQUEST['cmbRincianObyek'];
	 $cmbSubRincianObyek = $_REQUEST['cmbSubRincianObyek'];
	 $cmbSubSubRincianObyek = $_REQUEST['cmbSubSubRincianObyek'];
	$fmKODE = $_REQUEST['fmKODE'];
	$fmBARANG = $_REQUEST['fmBARANG'];
	  $fmBIDANG ="5";
	$fmKELOMPOK = "2";
	$fmSUBKELOMPOK ="2";
	$fmSUBSUBKELOMPOK = cekPOST('fmSUBSUBKELOMPOK');
	$fmSUBSUBSUBKELOMPOK = cekPOST('fmSUBSUBSUBKELOMPOK');
	$fmKODE = cekPOST('fmKODE');
	$fmBARANG = cekPOST('fmBARANG');
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

	$TampilOpt =
	    //"<tr><td>".
	    "<div class='FilterBar'>".
	    //<table style='width:100%'><tbody><tr><td align='left'>
	    //<table cellspacing='0' cellpadding='0' border='0' style='height:28'>
	    //<tbody><tr valign='middle'>
	    //	<td align='left' style='padding:1 8 0 8; '>".
	    //"<div style='float:left;padding: 2 8 0 0;height:20;padding: 4 4 0 0'>Urutkan : </div>".

	    "".
	    "</div>".
	    "<div class='FilterBar'>".

	    "<div class='FilterBar'>".
	    "<table style='width:100%'>

	    </table>".
	    "</div>";


	    $TampilOpt =
	      "<table width=\"100%\" class=\"adminform\">	<tr>
	      <td width=\"60%\" valign=\"top\"><h2>REKENING</h2>
	        " ."<table style='width:100%'>
	        <tr>
	        <td style='width:150px'>BIDANG</td><td style='width:5px;'>:</td>
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
	        cmbQuery1("fmSUBKELOMPOK",$fmSUBKELOMPOK,"select m,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m != '0' and n='00' and o='$this->WHERE_O'","onChange=\"$this->Prefix.refreshList(true)\" disabled",'Pilih','').
	        "</td>
	        </tr><tr>
	        <td>SUB SUB KELOMPOK</td><td>:</td>
	        <td>".
	        cmbQuery1("fmSUBSUBKELOMPOK",$fmSUBSUBKELOMPOK,"select n,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m = '$fmSUBKELOMPOK' and n!='00' and o='$this->WHERE_O'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
	        "</td>
	          </tr>
	      <tr>
	          <td>SUB SUB SUB KELOMPOK</td><td>:</td>
	          <td>".
	          cmbQuery1("fmSUBSUBSUBKELOMPOK",$fmSUBSUBSUBKELOMPOK,"select o,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m = '$fmSUBKELOMPOK' and n='$fmSUBSUBKELOMPOK' and o!='$this->WHERE_O'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
	          "</td>
	        </tr>

	        </table>".
	      "</td>
	      <td width=\"40%\" valign=\"top\"><h2>BARANG</h2>
	        <table>
	          <tr>".
	            "<table style='width:100%'>
	            <tr>
	            <td style='width:170px;' >JENIS</td><td>:</td>
	            <td>".
	            cmbQuery1("cmbJenis",$cmbJenis,"select f as valueCmbJenis, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f != '00'  and g ='00' and h ='00' and i='00' and j = '000' and f ='08'","onChange=$this->Prefix.refreshList(true) ",'Pilih','').
	            "</td>
	            </tr><tr>
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
	              </tr>

	            </table>"."</td></tr>
	          ".
	        "</table>".
	      "</td>
	      </tr></table>"
	      // <tr><td>
	      // 	Kode Barang
	      // </td><td> :</td><td> <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' maxlength='' size=20px></td></tr>
	      // <tr><td>
	      // 	Nama Barang  </td> <td> :</td> <td> <input type='text' id='fmBARANG' name='fmBARANG' value='".$fmBARANG."' size=30px>&nbsp <input type='hidden' id='filterAkun' name='filterAkun' value='".$filterAkun."'><input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'></td>  ".
	      // 	"".
	      // 	"
	      // </tr>
	      ;
	  return array('TampilOpt'=>$TampilOpt);
	}

	function getDaftarOpsi($Mode=1){
	  global $Main, $HTTP_COOKIE_VARS;
	  $UID  = $_COOKIE['coID'];

	  // $arrKondisi[] = "concat(k12,'.',l12,'.',m12,'.',n12,'.',o12) !='....'";
	  // $arrKondisi[] = "concat(k12,'.',l12,'.',m12,'.',n12,'.',o12) !='0.0.0.0.0'";


	  foreach ($_REQUEST as $key => $value) {
	        $$key = $value;
	  }
	  //$arrKondisi[] = "f != '06' and f!='07' and f!='08' ";

	    $arrKondisi[] = "k = '5'";



	    $arrKondisi[] = "l = '2'";



	    $arrKondisi[] = "m = '2'";
	    $arrKondisi[]  = "o!='$this->WHERE_O'";


	  if(!empty($fmSUBSUBKELOMPOK)){
	    $arrKondisi[] = "n = '$fmSUBSUBKELOMPOK'";
	  }
	  if(!empty($fmSUBSUBSUBKELOMPOK)){
	    $arrKondisi[] = "o = '$fmSUBSUBSUBKELOMPOK'";
	  }

		if(!empty($cmbSubSubRincianObyek)){
				$this->kondisiBarang = " and f='$cmbJenis' and g='$cmbObyek' and h='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j='$cmbSubSubRincianObyek'";
		}elseif(!empty($cmbSubRincianObyek)){
			 $this->kondisiBarang = " and f='$cmbJenis' and g='$cmbObyek' and h='$cmbRincianObyek' and i='$cmbSubRincianObyek' ";
		}elseif(!empty($cmbRincianObyek)){
			 $this->kondisiBarang = " and f='$cmbJenis' and g='$cmbObyek' and h='$cmbRincianObyek' ";
		}elseif(!empty($cmbObyek)){
			 $this->kondisiBarang = " and f='$cmbJenis' and g='$cmbObyek'  ";
		}elseif(!empty($cmbJenis)){
			 $this->kondisiBarang = " and f='$cmbJenis' ";
		}

		if(!empty($this->kondisiBarang)){
		    $getBarang = mysql_query("select * from ref_barang where j!='000' and k12='5' and l12='2' and m12='2' $this->kondisiBarang");
		    while($dataBarang = mysql_fetch_array($getBarang)){
		          $concatRekeningBarang = $dataBarang['k12'].".".$dataBarang['l12'].".".$dataBarang['m12'].".".$dataBarang['n12'].".".$dataBarang['o12'];
		          $arrayExceptRekening[]= "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concatRekeningBarang'";
		    }
		    $kondisiExcept = join(' and ',$arrayExceptRekening);
		    if(sizeof($arrayExceptRekening) > 0 ){
		        $getAllRekening = mysql_query("select * from ref_rekening where k='5' and l='2' and m='2' and  $kondisiExcept ");
		        while($dataRekening = mysql_fetch_array($getAllRekening)){
		            $concatRekening = $dataRekening['k'].".".$dataRekening['l'].".".$dataRekening['m'].".".$dataRekening['n'].".".$dataRekening['o'];
		            $arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concatRekening'";
		        }
		    }else{
		        $arrKondisi[] = "err";
		    }

		}
	  // if(!empty($_POST['fmKODE'])) $arrKondisi[] = " concat(f,g,h,i,j) like '".str_replace('.','',$_POST['fmKODE'])."%'";
	  // if(!empty($_POST['fmBARANG'])) $arrKondisi[] = " nm_barang like '%".$_POST['fmBARANG']."%'";
	  //$arrKondisi[] = "j !='000' ";
	  $Kondisi= join(' and ',$arrKondisi);
	  $Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

	  //Order -------------------------------------
	  $fmORDER1 = cekPOST('fmORDER1');
	  $fmDESC1 = cekPOST('fmDESC1');
	  $Asc1 = $fmDESC1 ==''? '': 'desc';
	  $arrOrders = array();

	  //$arrOrders[] = "k12,l12,m12,n12,o12,f,g,h,i,j ASC " ;


	    $Order= join(',',$arrOrders);
	    $OrderDefault = '';// Order By no_terima desc ';
	    $Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
	  //}
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

	function copyDataBarang(){
		$getAllBarang = mysql_query("select * from ref_barang where j!='000'");
		while($rows = mysql_fetch_array($getAllBarang)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			 }
			 $kodeBarang =$f.".".$g.".".$h.".".$i.".".$j;
			 if(mysql_num_rows(mysql_query("select * from temp_standar_kebutuhan where username = '$this->username' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'")) == 0){
			 		$data = array(
			 						"f" => $f,
			 						"g" => $g,
			 						"h" => $h,
			 						"i" => $i,
			 						"j" => $j,
			 						'jumlah' => '0',
			 						'username' => $this->username
			 					  );
			 		$query = VulnWalkerInsert('temp_standar_kebutuhan',$data);
			 		mysql_query($query);
			 }

		}
	}

	function editData($id){

	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 900;
	 $this->form_height = 200;

		$this->form_caption = 'Edit';
		$kode = explode(' ', $id);
		$c1 = $kode[0];
		$c = $kode[1];
		$d = $kode[2];
		$e = $kode[3];
		$e1 = $kode[4];

		$f = $kode[5];
		$g = $kode[6];
		$h = $kode[7];
		$i = $kode[8];
		$j = $kode[9];

		$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;

		$getNamaBarang =  mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' "));
		$namaBarang = $getNamaBarang['nm_barang'];
		$satuanBarang = $getNamaBarang['satuan'];

		$getNamaUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='00' and d='00' and e='00' and e1='000'"));
		$getNamaBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='00' and e='00' and e1='000'"));
		$getNamaSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='00' and e1='000'"));
		$getNamaUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
		$getNamaSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));

		$urusan = $getNamaUrusan['nm_skpd'];
		$bidang = $getNamaBidang['nm_skpd'];
		$skpd = $getNamaSKPD['nm_skpd'];
		$unit = $getNamaUnit['nm_skpd'];
		$subUnit = $getNamaSubUnit['nm_skpd'];

		$primaryKey = $c1.".".$c.".".$d.".".$e.".".$e1.".".$f.".".$g.".".$h.".".$i.".".$j;

		$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) ='$primaryKey'"));
		$jumlahBarang = $getData['jumlah'];

       //items ----------------------
		 $this->form_fields = array(
			'urusan' => array(
								'label'=>'URUSAN',
								'labelWidth'=>200,
								'value'=>"$urusan"
									 ),

			'bidang' => array(
								'label'=>'BIDANG',
								'labelWidth'=>200,
								'value'=>"$bidang"
									 ),
			'skpd' => array(
								'label'=>'SKPD',
								'labelWidth'=>200,
								'value'=>"$skpd"
									 ),
			'skpd' => array(
								'label'=>'SKPD',
								'labelWidth'=>200,
								'value'=>"$skpd"
									 ),
			'unit' => array(
								'label'=>'UNIT',
								'labelWidth'=>200,
								'value'=>"$unit"
									 ),
			'subUnit' => array(
								'label'=>'SUB UNIT',
								'labelWidth'=>200,
								'value'=>"$subUnit"
									 ),
			'kodeBarang' => array(
								'label'=>'KODE BARANG',
								'labelWidth'=>200,
								'value'=>"$kodeBarang"
									 ),
			'namaBarang' => array(
								'label'=>'NAMA BARANG',
								'labelWidth'=>200,
								'value'=>"$namaBarang"
									 ),
			'satuanBarang' => array(
								'label'=>'SATUAN',
								'labelWidth'=>200,
								'value'=>"$satuanBarang"
									 ),
			'jumlahBarang' => array(
								'label'=>'JUMLAH BARANG',
								'labelWidth'=>200,
								'value'=>"<input type='text' name='jumlahBarang' id='jumlahBarang' value='$jumlahBarang' onkeypress='return event.charCode >= 48 && event.charCode <= 57'>"
									 ),

			);
		//tombol
		$this->form_menubawah =
			"
			<input type='hidden' id ='c1' name ='c1' value='$c1'>
			<input type='hidden' id ='c' name ='c' value='$c'>
			<input type='hidden' id ='d' name ='d' value='$d'>
			<input type='hidden' id ='e' name ='e' value='$e'>
			<input type='hidden' id ='e1' name ='e1' value='$e1'>

			".
			"<input type='button' value='Simpan' onclick =$this->Prefix.saveData('$primaryKey') title='Simpan' > &nbsp &nbsp ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

}
$rincianBelanjaBarangJasa = new rincianBelanjaBarangJasaObj();
$rincianBelanjaBarangJasa->username = $_COOKIE['coID'];
if($Main->REK_DIGIT_O == 0){
	$rincianBelanjaBarangJasa->WHERE_O = "00";
}else{
	$rincianBelanjaBarangJasa->WHERE_O = "000";
}
?>
