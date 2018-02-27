<?php

class listRegisterBukuIndukObj  extends DaftarObj2{
	var $Prefix = 'listRegisterBukuInduk';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'buku_induk'; //bonus
	var $TblName_Hapus = 'buku_induk';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'RINCIAN TEMPLATE';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='listRegisterBukuInduk.xls';
	var $namaModulCetak='RINCIAN TEMPLATE';
	var $Cetak_Judul = 'RINCIAN TEMPLATE';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'listRegisterBukuIndukForm';
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
			 if( mysql_num_rows(mysql_query("select * from temp_list_select_rkbmd_pemeliharaan where id_buku_induk ='$id'")) !=0 ){
				 if($jenis !="checked"){
					 	mysql_query("update temp_list_select_rkbmd_pemeliharaan set status='' where id_buku_induk='$id' and username ='$this->username'");
				 }else{
					 mysql_query("update temp_list_select_rkbmd_pemeliharaan set status='checked' where id_buku_induk='$id' and username ='$this->username'");
				 }


			 }else{
			 	$explodeKodeBarang = explode('.', $id);

			 	$data = array(
								'id_buku_induk' => $id,
								'status' => "checked",
								'username' => $this->username
							  );
				mysql_query(VulnWalkerInsert("temp_list_select_rkbmd_pemeliharaan",$data));
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
			<script type='text/javascript' src='js/perencanaan_v3/rkbmd/listRegisterBukuInduk.js' language='JavaScript' ></script>


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
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5'>No.</th>
  	   <th class='th01' width='5'>".$this->selectAllCheckBox()."</th>

  	   <th class='th01' width='600'>KODE BARANG/ NO REG/ TAHUN </th>
  	   <th class='th01' width='300'>MERK/ TYPE/ ALAMAT</th>
  	   <th class='th01' width='50'>KONDISI</th>
  	   <th class='th01' width='200'>KETERANGAN</th>
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
		$jumlahData = $_REQUEST['jumlahData'];
		if(empty($jumlahData))$jumlahData = "25";
		/*if($KeyValueStr!=''){*/
			$hsl ="<input type='checkbox' name='listRegisterBukuInduk_toggle' id='listRegisterBukuInduk_toggle' value='' onclick=listRegisterBukuInduk.checkSemua($jumlahData,'listRegisterBukuInduk_cb','listRegisterBukuInduk_toggle','listRegisterBukuInduk_jmlcek')>";
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
	 $kodeBarang =$f.".".$g.".".$h.".".$i.".".$j;
	 $kodeBarangLengkap =$f1.".".$f2.".".$f.".".$g.".".$h.".".$i.".".$j;
	 $getStatusCheckBox = mysql_fetch_array(mysql_query("select * from temp_list_select_rkbmd_pemeliharaan where id_buku_induk= '$id' and username = '$this->username'"));
	 $status = $getStatusCheckBox['status'];

	 $TampilCheckBox =  $this->setCekBox($this->lastNomor, $id, $status);
	 if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);

	 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) ='$kodeBarang'"));
	 $namaBarang = $getNamaBarang['nm_barang'];
	 $Koloms[] = array('align="left"',$kodeBarang." /".$noreg. " /". $thn_perolehan."<br>".$namaBarang);
	 if($f == "01"){
		 $getDataKIB = mysql_fetch_array(mysql_query("select * from kib_a where idbi = '$id'"));
		 $keteranganKIB = $getDataKIB['alamat'];
	 }elseif($f == "02"){
		 $getDataKIB = mysql_fetch_array(mysql_query("select * from kib_b where idbi = '$id'"));
		 $keteranganKIB = $getDataKIB['merk']."&nbsp".$getDataKIB['no_polisi'];
	 }elseif($f == "03"){
		 $getDataKIB = mysql_fetch_array(mysql_query("select * from kib_c where idbi = '$id'"));
		 $keteranganKIB = $getDataKIB['alamat'];
	 }elseif($f == "04"){
		 $getDataKIB = mysql_fetch_array(mysql_query("select * from kib_d where idbi = '$id'"));
		 $keteranganKIB = $getDataKIB['alamat'];
	 }elseif($f == "05"){
		  $getDataKIB = mysql_fetch_array(mysql_query("select * from kib_e where idbi = '$id'"));
	  	$keteranganKIB = $getDataKIB['alamat'];
	 }
	 $Koloms[] = array('align="left"',$keteranganKIB);
	 if($kondisi == '1'){
		 	$kondisiBarang = "BAIK";
	 }elseif($kondisi == '2'){
		 	$kondisiBarang = "KURANG BAIK";
	 }elseif($kondisi == '3'){
		 	$kondisiBarang = "RUSAK BERAT";
	 }
	 $Koloms[] = array('align="CENTER"',$kondisiBarang);
	 $Koloms[] = array('align="left"',$getDataKIB['ket']);
	 $this->jumlahRow += 1;
	 $this->lastNomor += 1;



	 return $Koloms;
	}



	function genDaftarOpsi(){
	 global $Ref, $Main;


	 $jumlahData = $_REQUEST['jumlahData'];


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
	 if(empty($jumlahData) )$jumlahData = "25";

	$TampilOpt =
			"<div class='FilterBar'>".

			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Jumlah Data : <input type='text' id='jumlahData' name='jumlahData' value='".$jumlahData."' size=6px>&nbsp
				<input type='button'  value='Tampilkan' onclick='listRegisterBukuInduk.refreshList(true);'>
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

		$this->kondisiSKPD = " and c1='".$_REQUEST['c1']."' and c='".$_REQUEST['c']."' and d='".$_REQUEST['d']."' and e='".$_REQUEST['e']."'  and e1='".$_REQUEST['e1']."'";
		$kodeBarang = $_REQUEST['kodeBarang'];
		$arrKondisi[] = " 1 = 1 $this->kondisiSKPD and concat(f,'.',g,'.',h,'.',i,'.',j) = '".$_REQUEST['kodeBarang']."' ";



		if(!empty($_POST['fmKODE'])) $arrKondisi[] = " concat(f,g,h,i,j) like '".str_replace('.','',$_POST['fmKODE'])."%'";
		if(!empty($_POST['fmBARANG'])) $arrKondisi[] = " nm_barang like '%".$_POST['fmBARANG']."%'";
		$arrKondisi[] = "j !='000' ";
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
			$arrOrders[] = " concat(f,g,h,i,j) ASC " ;
			$Order= join(',',$arrOrders);
			$OrderDefault = '';// Order By no_terima desc ';
			$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		$this->pagePerHal = $_REQUEST['jumlahData'];
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);

		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal;
		$Limit = $Mode == 3 ? '': $Limit;
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}


	function copyDataBarang($kondisiBarang){
		$getAllBarang = mysql_query("select * from buku_induk where j!='000' $kondisiBarang");
		while($rows = mysql_fetch_array($getAllBarang)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			 }
			 $kodeBarang =$f.".".$g.".".$h.".".$i.".".$j;
			 if(mysql_num_rows(mysql_query("select * from buku_induk where username = '$this->username' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'")) == 0){
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
			 		$query = VulnWalkerInsert('buku_induk',$data);
			 		mysql_query($query);
			 }

		}
	}


}
$listRegisterBukuInduk = new listRegisterBukuIndukObj();
$listRegisterBukuInduk->username = $_COOKIE['coID'];
?>
