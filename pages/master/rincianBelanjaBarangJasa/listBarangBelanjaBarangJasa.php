<?php

class listBarangBelanjaBarangJasaObj  extends DaftarObj2{
	var $Prefix = 'listBarangBelanjaBarangJasa';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_barang'; //bonus
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
	var $PageTitle = 'RINCIAN TEMPLATE';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='listBarangBelanjaBarangJasa.xls';
	var $namaModulCetak='RINCIAN TEMPLATE';
	var $Cetak_Judul = 'RINCIAN TEMPLATE';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'listBarangBelanjaBarangJasaForm';
	var $noModul=14;
	var $TampilFilterColapse = 0; //0
	var $username = "";
	var $lastNomor = 0;



	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;

	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}

	function set_selector_other($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;

	  switch($tipe){




		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}

		case 'checkboxChanged':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			 }
			 if(mysql_num_rows(mysql_query("select * from temp_rincian_belanja_barang_jasa where concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1) ='$id' and username ='$this->username'"))){
				 if($jenis !="checked"){
				 		mysql_query("update temp_rincian_belanja_barang_jasa set status='' where concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1) ='$id' and username ='$this->username'");
				}else{
						mysql_query("update temp_rincian_belanja_barang_jasa set status='checked' where concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1) ='$id' and username ='$this->username'");
				}
			 }else{
			 	$explodeKodeBarang = explode('.', $id);
			 	$f1 = $explodeKodeBarang[0];
			 	$f2 = $explodeKodeBarang[1];
			 	$f = $explodeKodeBarang[2];
			 	$g = $explodeKodeBarang[3];
			 	$h = $explodeKodeBarang[4];
			 	$i = $explodeKodeBarang[5];
			 	$j = $explodeKodeBarang[6];
			 	$j1 = $explodeKodeBarang[7];
			 	$data = array(
								"username" => $this->username,
								'f1' => $f1,
								'f2' => $f2,
								'f' => $f,
								'g' => $g,
								'h' => $h,
								'i' => $i,
								'j' => $j,
								'j1' => $j1,
								'status' => "checked"
							  );
				mysql_query(VulnWalkerInsert("temp_rincian_belanja_barang_jasa",$data));
			 }

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
			<script type='text/javascript' src='js/master/rincianBelanjaBarangJasa/listBarangBelanjaBarangJasa.js' language='JavaScript' ></script>


			".

			$scriptload;
	}

	function setTopBar(){
	   	return '';
	}

	//form ==================================


	function setPage_HeaderOther(){

	}

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
  	   <th class='th01' width='5'>".$this->selectAllCheckBox()."</th>
  	   <th class='th01' width='100'>KODE BARANG</th>
  	   <th class='th01' width='400'>NAMA BARANG</th>
			 	$kolomHeadernya
	   </tr>
	   </thead>";

		return $headerTable;
	}
	function setCekBox($cb, $KeyValueStr, $isi){
		$hsl = '';
		/*if($KeyValueStr!=''){*/
			$hsl = "<input type='checkbox' $isi id='".$this->Prefix."_cb$cb' name='".$this->Prefix."_cb[]'
					value='".$KeyValueStr."' onchange = $this->Prefix.thisChecked('$KeyValueStr','".$this->Prefix."_cb$cb'); >";
		/*}*/
		return $hsl;
	}

	function selectAllCheckBox(){
	  $hsl = '';
		if(!isset($_REQUEST['jumlahData']) || empty($_REQUEST['jumlahData'])){
 		 $jumlahData = "25";
 	}else{
 		 $jumlahData = $_REQUEST['jumlahData'];
 	}
	    $hsl ="<input type='checkbox' name='listBarangBelanjaBarangJasa_toggle' id='listBarangBelanjaBarangJasa_toggle' value='' onclick=listBarangBelanjaBarangJasa.checkSemua($jumlahData,'listBarangBelanjaBarangJasa_cb','listBarangBelanjaBarangJasa_toggle','listBarangBelanjaBarangJasa_jmlcek')>";
	  /*}*/
	  return $hsl;
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

	 $TampilCheckBox =  $this->setCekBox($this->lastNomor, $kodeBarangLengkap, $status);
	 if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);

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

	 $Koloms[] = array('align="center"',$kodeBarang);
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


	function copyDataBarang($kondisiBarang){
		$getAllBarang = mysql_query("select * from ref_barang where j!='000' $kondisiBarang");
		while($rows = mysql_fetch_array($getAllBarang)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			 }
			 $kodeBarang =$f.".".$g.".".$h.".".$i.".".$j;
			 if(mysql_num_rows(mysql_query("select * from ref_barang where username = '$this->username' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'")) == 0){
			 		if(mysql_num_rows(mysql_query("select * from ref_std_kebutuhan where  concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' $this->kondisiSKPD")) != 0){
			 			$getData = mysql_fetch_array(mysql_query("select * from ref_std_kebutuhan where  concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' $this->kondisiSKPD"));
			 			$jumlahReal =$getData['jumlah'];
			 		}else{
			 			$jumlahReal = '0';
			 		}
			 		$data = array(
			 						"f" => $f,
			 						"g" => $g,
			 						"h" => $h,
			 						"i" => $i,
			 						"j" => $j,
			 						'jumlah' => $jumlahReal,
			 						'username' => $this->username
			 					  );
			 		$query = VulnWalkerInsert('ref_barang',$data);
			 		mysql_query($query);
			 }

		}
	}


}
$listBarangBelanjaBarangJasa = new listBarangBelanjaBarangJasaObj();
$listBarangBelanjaBarangJasa->username = $_COOKIE['coID'];
?>
