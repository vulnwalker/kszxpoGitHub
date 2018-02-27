<?php

class listKartuKunciObj  extends DaftarObj2{
	var $Prefix = 'listKartuKunci';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'rincian_lock_barang'; //bonus
	var $TblName_Hapus = 'rincian_lock_barang';
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
	var $fileNameExcel='listKartuKunci.xls';
	var $namaModulCetak='RINCIAN TEMPLATE';
	var $Cetak_Judul = 'RINCIAN TEMPLATE';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'listKartuKunciForm';
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

		case 'Simpantmp':{
                                   foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
	                        }
	           			$explodeKodeBarang = explode('.', $id);
			 	$f = $explodeKodeBarang[0];
			 	$g = $explodeKodeBarang[1];
			 	$h = $explodeKodeBarang[2];
			 	$i = $explodeKodeBarang[3];
			 	$j = $explodeKodeBarang[4];
			 	$j1 = $explodeKodeBarang[5];
		$cek = mysql_num_rows(mysql_query("SELECT * from tmp_saldoawal where user ='$this->username' and f ='$f' and g ='$g' and h = '$h' and i='$i' and j='$j' and j1='$j1'"));
	  	if($cek == 1){
		   mysql_query("UPDATE  tmp_saldoawal set jumlah='$jumlah',satuan='$satuan',harga_satuan='$harga' where user ='$this->username' and f ='$f' and g ='$g' and h = '$h' and i='$i' and j='$j' and j1='$j1'");
		}else{

		  mysql_query("INSERT Into tmp_saldoawal values('','$f','$g','$h','$i','$j','$j1','$jumlah','$satuan','$harga','$this->username')");

		}


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

			<script type='text/javascript' src='js/persediaan/listKartuKunci.js' language='JavaScript' ></script>


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

  	   <th class='th01' width='100'>TANGGAL</th>
  	   <th class='th01' width='500'>URAIAN</th>
   	   <th class='th01' width='100'>MASUK</th>
   	   <th class='th01' width='100'>KELUAR</th>
   	   <th class='th01' width='100'>SALDO</th>
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
	    $hsl ="<input type='checkbox' name='listKartuKunci_toggle' id='listKartuKunci_toggle' value='' onclick=listKartuKunci.checkSemua($jumlahData,'listKartuKunci_cb','listKartuKunci_toggle','listKartuKunci_jmlcek')>";
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
	 $Koloms[] = array('align="center"', $this->generateDate($tanggal));
	 if($type == '2'){
		 	$uraian = "<span style='cursor:pointer;color:black;margin:10px;' onclick=daftarPersediaanBarang.detailPengeluaran($id_t_kartu_persediaan)>$uraian</span>";
	 }
	 $Koloms[] = array('align="left"', $uraian);
	 $Koloms[] = array('align="right"', number_format($masuk,0,',','.'));
	 $Koloms[] = array('align="right"', number_format($keluar,0,',','.'));
	 $Koloms[] = array('align="right"', number_format($saldo,0,',','.'));

	 return $Koloms;
	}



	function genDaftarOpsi(){
	 global $Ref, $Main;

	 foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
	 }
	 $getDataLock = mysql_fetch_array(mysql_query("select * from t_persediaan_lock_barang where id = '$idLock'"));
	 $getNamaUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$getDataLock['c1']."' and c='00'"));
	 $getNamaBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$getDataLock['c1']."' and c='".$getDataLock['c']."' and d='00'"));
	 $getNamaSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$getDataLock['c1']."' and c='".$getDataLock['c']."' and d='".$getDataLock['d']."' and e='00'"));
	 $getNamaUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$getDataLock['c1']."' and c='".$getDataLock['c']."' and d='".$getDataLock['d']."' and e='".$getDataLock['e']."' and e1='000'"));
	 $getNamaSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$getDataLock['c1']."' and c='".$getDataLock['c']."' and d='".$getDataLock['d']."' and e='".$getDataLock['e']."' and e1='".$getDataLock['e1']."'"));
	 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='".$getDataLock['f1']."' and f2='".$getDataLock['f2']."' and f='".$getDataLock['f']."' and g='".$getDataLock['g']."' and h='".$getDataLock['h']."' and i='".$getDataLock['i']."' and j='".$getDataLock['j']."' and j1='".$getDataLock['j1']."'"));

	 $getMaxData = mysql_fetch_array(mysql_query("select max(id) from rincian_lock_barang where id_lock = '$idLock'"));
	 $getSaldo = mysql_fetch_array(mysql_query("select * from rincian_lock_barang where id = '".$getMaxData['max(id)']."'"));

	 	 $filterItem = "
	 	 <tr>
	 	 <td style='width:170px;'>URUSAN</td><td style='width:10px;'>:</td>
	 	 <td>".
		 $getNamaUrusan['nm_skpd'].
		 "</td>
	 	 </tr>
	 	 <tr>
	 	 <td style='width:170px;'>BIDANG</td><td>:</td>
	 	 <td>".
		 $getNamaBidang['nm_skpd'].
		 "</td>
	 	 </tr>
	 	 <tr>
	 	 <td style='width:170px;'>SKPD</td><td>:</td>
	 	 <td>".
		 $getNamaSKPD['nm_skpd'].
		 "</td>
	 	 </tr>
	 	 <tr>
	 	 <td style='width:170px;'>UNIT</td><td>:</td>
	 	 <td>".
		 $getNamaUnit['nm_skpd'].
		 "</td>
	 	 </tr>
	 	 <tr>
	 	 <td style='width:170px;'>SUB UNIT</td><td>:</td>
	 	 <td>".
		 $getNamaSubUnit['nm_skpd'].
		 "</td>
	 	 </tr>
	 	 <tr>
	 	 <td style='width:170px;'>NAMA BARANG</td><td>:</td>
	 	 <td>".
		 $getNamaBarang['nm_barang'].
		 "</td>
	 	 </tr>
	 	 <tr>
	 	 <td style='width:170px;'>SALDO</td><td>:</td>
	 	 <td>".
		 number_format($getSaldo['saldo'],2,',','.')." &nbsp
		 </td>
	 	 </tr>
	 		 ";


	 $TampilOpt =
	 		"<div class='FilterBar'>".


	 		"<table style='width:100%'>

	 		$filterItem

	 		</table>".
	 		"</div>"
	 		;
      //
			// "<div class='FilterBar'>".
	 		// "<table style='width:100%'>
	 		// <tr><td>
	 		// 	Kode Barang : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' size=20px>&nbsp
	 		// 	Nama Barang : <input type='text' id='fmBARANG' name='fmBARANG' value='".$fmBARANG."' size=30px>&nbsp
	 		// 	<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
	 		// </td></tr>
	 		// </table>".
	 		// "</div>".
	 		// "<input type='hidden' id='fmORDER18' name='fmORDER18' value='".$fmORDER18."'>".
	 		// "<input type='hidden' id='fmORDER19' name='fmORDER19' value='".$fmORDER19."'>"
		return array('TampilOpt'=>$TampilOpt);
	}



	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;

		//kondisi -----------------------------------
		foreach ($_REQUEST as $key => $value) {
 				 $$key = $value;
 	 }

		$arrKondisi = array();

		$arrKondisi[] = "id_lock = '$idLock'";
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
			$arrOrders[] = " id " ;
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

	function generateDate($tanggal){
			$tanggal = explode('-',$tanggal);
			$tanggal = $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];
			return $tanggal;
	}
	function copyDataBarang($kondisiBarang){
		$getAllBarang = mysql_query("select * from rincian_lock_barang where j!='000' $kondisiBarang");
		while($rows = mysql_fetch_array($getAllBarang)){
			foreach ($rows as $key => $value) {
				  $$key = $value;
			 }
			 $kodeBarang =$f.".".$g.".".$h.".".$i.".".$j;
			 if(mysql_num_rows(mysql_query("select * from rincian_lock_barang where username = '$this->username' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'")) == 0){
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
			 		$query = VulnWalkerInsert('rincian_lock_barang',$data);
			 		mysql_query($query);
			 }

		}
	}


}
$listKartuKunci = new listKartuKunciObj();
$listKartuKunci->username = $_COOKIE['coID'];
?>
