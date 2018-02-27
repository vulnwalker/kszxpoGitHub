<?php

class popupBarangBelanjaModalObj  extends DaftarObj2{
	var $Prefix = 'popupBarangBelanjaModal';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_barang'; //daftar
	var $TblName_Hapus = 'ref_barang';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('f1','f2','f','g','h','i','j');
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
	var $FormName = 'popupBarangBelanjaModalForm';
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
				$kodeRekening = $_REQUEST['kodeRekening'];
				$fm = $this->windowShow($kodeRekening);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

	   	case 'getdata':{

		$ref_pilihbarang = $_REQUEST['id'];
		$kode_barang = explode('.',$ref_pilihbarang);
		$f1=$kode_barang[0];
		$f2=$kode_barang[1];
		$f=$kode_barang[2];
		$g=$kode_barang[3];
		$h=$kode_barang[4];
		$i=$kode_barang[5];
		$j=$kode_barang[6];

		//query ambil data ref_program
		$get = mysql_fetch_array( mysql_query("select * from ref_barang where f1=$f1 and f2=$f2 and  f=$f and g=$g and h=$h and i=$i and j=$j"));
		$kode_barang=$get['f1'].'.'.$get['f2'].'.'.$get['f'].'.'.$get['g'].'.'.$get['h'].'.'.$get['i'].'.'.$get['j'];

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
			if($f !='08'){
				$jenisBarang = "MODAL";
			}





		$content = array('jenisBarang' => $jenisBarang,'kodeBarang'=>$kode_barang, 'namaBarang'=>$get['nm_barang'],'satuanBarang'=>$get['satuan'] , 'kode_account'=>$kode_account, 'nama_account'=>$row['nm_account'], 'tahun_account'=>$row['thn_akun']  );
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

	function windowShow($kodeRekening){
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
						 <input type='hidden' id='kodeRekening' name='kodeRekening' value='$kodeRekening' >
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
			 <script type='text/javascript' src='js/perencanaanKeuangan/keuangan/rka/popupBarangBelanjaModal.js' language='JavaScript' ></script>".

			$scriptload;
	}




	//form ==================================


	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $fmBIDANG = $_REQUEST['fmBIDANG'];
	 $fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
	 $fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
	 $fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];
	if(empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
	{
		$nama_barang="NAMA BIDANG";
	}
	elseif(!empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK) || empty($fmKELOMPOK))
	{
		$nama_barang="NAMA KELOMPOK";
	}
	elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK) || empty($fmSUBKELOMPOK))
	{
		$nama_barang="NAMA SUB KELOMPOK";
	}
	elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
	{
		$nama_barang="NAMA SUB SUB KELOMPOK";
	}
	elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
	{
		$nama_barang="NAMA BARANG";
	}
	 $headerTable =
	 "<thead>
	 <tr>
	   <th class='th01' width='20' >No.</th>
	   <th class='th01' align='left' width='100'>KODE BARANG</th>
	   <th class='th01' align='left' width='800'>NAMA BARANG</th>
	   <th class='th01' align='left' width='100'>SATUAN</th>



	   </tr>
	   </thead>";

		return $headerTable;
	}
	/*	   <th class='th01' align='left' width='100'>MASA MANFAAT (TAHUN)</th>
	   <th class='th01' align='left' width='100'>RESIDU (%)</th>	 */

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 global $Main;
	 $aqry_at = "select * from ref_jurnal where ka='".$isi['ka']."' and kb='".$isi['kb']."' and kc='".$isi['kc']."' and kd='".$isi['kd']."' and ke='".$isi['ke']."' and kf='".$isi['kf']."' ";
	 $na_at=mysql_fetch_array(mysql_query($aqry_at));

	 $kode_account_at=$isi['ka'].'.'.$isi['kb'].'.'.$isi['kc'].'.'.$isi['kd'].'.'.$isi['ke'].'.'.$isi['kf'];
	 $aqry_bm = "select * from ref_jurnal where ka='".$isi['m1']."' and kb='".$isi['m2']."' and kc='".$isi['m3']."' and kd='".$isi['m4']."' and ke='".$isi['m5']."' and kf='".$isi['m6']."' ";
	 $na_bm=mysql_fetch_array(mysql_query($aqry_bm));
	 $kode_account_bm=$isi['m1'].'.'.$isi['m2'].'.'.$isi['m3'].'.'.$isi['m4'].'.'.$isi['m5'].'.'.$isi['m6'];

	 $aqry_ap = "select * from ref_jurnal where ka='".$isi['l1']."' and kb='".$isi['l2']."' and kc='".$isi['l3']."' and kd='".$isi['l4']."' and ke='".$isi['l5']."' and kf='".$isi['l6']."' ";
	 $na_ap=mysql_fetch_array(mysql_query($aqry_ap));
	 $kode_account_ap=$isi['l1'].'.'.$isi['l2'].'.'.$isi['l3'].'.'.$isi['l4'].'.'.$isi['l5'].'.'.$isi['l6'];

	 //vw
	 $query_rek_bm = "select * from ref_rekening where k='".$isi['k11']."' and l='".$isi['l11']."' and m='".$isi['m11']."' and n='".$isi['n11']."' and o='".$isi['o11']."' ";
	 $na_rek_bm = mysql_fetch_array(mysql_query($query_rek_bm));
	 $kode_rek_bm=$isi['k11'].'.'.$isi['l11'].'.'.$isi['m11'].'.'.$isi['n11'].'.'.$isi['o11'];

	 $query_rek_bp = "select * from ref_rekening where k='".$isi['k12']."' and l='".$isi['l12']."' and m='".$isi['m12']."' and n='".$isi['n12']."' and o='".$isi['o12']."' ";
	 $na_rek_bp = mysql_fetch_array(mysql_query($query_rek_bp));
	 $kode_rek_bp=$isi['k12'].'.'.$isi['l12'].'.'.$isi['m12'].'.'.$isi['n12'].'.'.$isi['o12'];

	 $query_akun_pemeliharaan = "select * from ref_jurnal where ka='".$isi['o1']."' and kb='".$isi['o2']."' and kc='".$isi['o3']."' and kd='".$isi['o4']."' and ke='".$isi['o5']."' and kf='".$isi['o6']."' ";
	 $na_akun_pemeliharaan=mysql_fetch_array(mysql_query($query_akun_pemeliharaan));
	 $kode_account_pemeliharaan=$isi['o1'].'.'.$isi['o2'].'.'.$isi['o3'].'.'.$isi['o4'].'.'.$isi['o5'].'.'.$isi['o6'];

	 $query_akun_beban_penyusutan = "select * from ref_jurnal where ka='".$isi['n1']."' and kb='".$isi['n2']."' and kc='".$isi['n3']."' and kd='".$isi['n4']."' and ke='".$isi['n5']."' and kf='".$isi['n6']."' ";
	 $na_akun_beban_penyusutan=mysql_fetch_array(mysql_query($query_akun_beban_penyusutan));
	 $kode_account_beban_penyusutan=$isi['n1'].'.'.$isi['n2'].'.'.$isi['n3'].'.'.$isi['n4'].'.'.$isi['n5'].'.'.$isi['n6'];


	 $kode_barang=$isi['f1'].".".$isi['f2'].".".$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'].'.'.$isi['j1'];
	 $Koloms = array();
	 $Koloms[] = array('align="center" width="20"', $no.'.' );
	 if($isi['j'] == '000'){
	 	$Koloms[] = array('align="left" width="100" style="font-weight : bold;" ',$kode_barang);
	 }else{
	 	$Koloms[] = array('align="left" width="100" style="border-left-style: none;"',$kode_barang);
	 }

 	 $Koloms[] = array('align="left" width="200"',"<a style='cursor:pointer;' onclick = popupBarangBelanjaModal.windowSave('$kode_barang')>". $isi['nm_barang']. "</a>");
	 $Koloms[] = array('align="left" width="100"',$isi['satuan']);

/* 	 $Koloms[] = array('align="left" width="200"',$isi['masa_manfaat']);
 	 $Koloms[] = array('align="left" width="200"',str_replace(".",",",$isi['residu']));
*/
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
			array('selectfg','Kode Barang'),
			array('selectbarang','Nama Barang'),
			);


	//data order ------------------------------
	 $arrOrder = array(
	  	         array('1','Kode Barang'),
			     array('2','Nama Barang'),
	 );

	$TampilOpt =
			"<div class='FilterBar'>".


			"<table style='width:100%'>
			<tr>
			<td style='width:170px;' >JENIS</td><td>:</td>
			<td>".
			cmbQuery1("cmbJenis",$cmbJenis,"select f as valueCmbJenis, nm_barang from ref_barang where f != '00'  and g ='00' and h ='00' and i='00' and f != '06' and f!='07' and f!='08' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td style='width:170px;'>OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbObyek",$cmbObyek,"select g as valueCmbObyek, nm_barang from ref_barang where f = '$cmbJenis'  and g !='00' and h ='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td style='width:170px;'>RINCIAN OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbRincianObyek",$cmbRincianObyek,"select h as valueCmbRincianObyek, nm_barang from ref_barang where  f = '$cmbJenis'  and g ='$cmbObyek' and h !='00' and i='00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>
			<tr>
			<td style='width:170px;'>SUB RINCIAN OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbSubRincianObyek",$cmbSubRincianObyek,"select i as valueCmbSubRincianObyek, nm_barang from ref_barang where  f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i != '00' and j = '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>
			<tr>
			<td style='width:170px;'>SUB-SUB RINCIAN OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbSubSubRincianObyek",$cmbSubSubRincianObyek,"select j as valueCmbSubSubRincianObyek, nm_barang from ref_barang where  f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j != '000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>

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
		$UID = $_COOKIE['coID'];
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
		$arrKondisi[]= "j !=000";


		$getRekening = mysql_fetch_array(mysql_query("select * from temp_rekening_rka_belanja_langsung where id = '".$_REQUEST['kodeRekening']."'"));
		$concatKodeRekening = $getRekening['k'].".".$getRekening['l'].".".$getRekening['m'].".".$getRekening['n'].".".$getRekening['o'];
		if($getRekening['m'] == '3'){
			$arrKondisi[] = "concat(k11,'.',l11,'.',m11,'.',n11,'.',o11) = '$concatKodeRekening'";
			$arrKondisi[] = "f != '06' and f!='07' and f!='08' ";
		}else{
			$arrKondisi[] = "concat(k12,'.',l12,'.',m12,'.',n12,'.',o12) = '$concatKodeRekening'";
			$arrKondisi[] = "f='08' ";
		}


		if(!empty($_POST['fmKODE'])) $arrKondisi[] = " concat(f,g,h,i,j) like '".str_replace('.','',$_POST['fmKODE'])."%'";
		if(!empty($_POST['fmBARANG'])) $arrKondisi[] = " nm_barang like '%".$_POST['fmBARANG']."%'";

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

		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);

		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal;
		$Limit = $Mode == 3 ? '': $Limit;
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}
}
$popupBarangBelanjaModal = new popupBarangBelanjaModalObj();
?>
