<?php
 include "pages/pengadaanpenerimaan/pemasukan.php";
 $DataPemasukan = $pemasukan;
 
class cariBarangObj  extends DaftarObj2{	
	var $Prefix = 'cariBarang';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_barang'; //bonus
	var $TblName_Hapus = 'ref_barang';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	//var $KeyFields = array('f1','f2','f','g','h','i','j');
	var $KeyFields = array('f1','f2','f','g','h','i','j');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'ADMINISTRASI SYSTEM';
	var $PageIcon = 'images/pengadaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pemasukan.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'cariBarang';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'cariBarangForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	var $Id_Terima = '';
	var $status_dpa = 0;
	
	function setTitle(){
		return 'DAFTAR BARANG';
	}
	
	function setMenuEdit(){
		return "";
	}
		
	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
		
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function set_selector_other($tipe){
	 global $Main, $DataOption;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	  
	  switch($tipe){				
	    case 'windowshow'			: $fm = $this->windowShow();break;
		case 'getid'				: $fm = $this->Get_AmbilId();break;	   
		case 'GetData_pemasukan_v2'	: $fm = $this->GetData_pemasukan_v2();break;	   
		default:{
			$other = $this->set_selector_other2($tipe);
			$cek = $other['cek'];
			$err = $other['err'];
			$content=$other['content'];
			$json=$other['json'];
		break;
		}
		 
	 }//end switch
	 
	 if($json){
		$cek = $fm['cek'];
		$err = $fm['err'];
		$content = $fm['content'];	
	 }
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }
   
   function Get_AmbilId(){
   		global $DataOption, $Main;
   		$cek = '';
		$err = '';
		$content = array();	
				
		$kodebarangambil = cekPOST2('kodebarangambil');
		if($idrekening == '' && $err == '')$err == "Data Belum Dipilih !";
		
		if($err == ''){
			$kode = explode(".",$kodebarangambil);
			
			if($DataOption['kode_barang'] == '1'){
				$where_kode = "concat(f,'.',g,'.',h,'.',i,'.',j";
				$htng_stringKode = strlen($kode[4]);
				$kodei = $kode[4];
				if($kode[0] == "07"){
					if($kode[1] != $Main->ASET_TDK_BERWUJUD) $err = "Kode Barang ini Tidak Bisa di Pilih !";
				}
			}else{
				$where_kode = "concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j";
				$htng_stringKode = strlen($kode[6]);
				$kodei = $kode[6];
				if($kode[2] == "07"){
					if($kode[3] != $Main->ASET_TDK_BERWUJUD) $err = "Kode Barang ini Tidak Bisa di Pilih !";
				}
			}
			
			$where_kode .= cekPOST2("jns_transaksi")=="3"?",'.',j1)":")";
			
			
			if($err == ''){
				$qry = "SELECT * FROM ref_barang WHERE $where_kode = '$kodebarangambil' ";$cek.=$qry;
				$aqry = mysql_query($qry);
				$daqry = mysql_fetch_array($aqry);
					
				
				if($htng_stringKode >= 3){
					if($kodei == '000' || $daqry['nm_barang'] == null){
						$err='Kode Tidak Valid !';
					}else{
						$content['kodebarang'] = $kodebarangambil;
						$content['namabarang'] = $daqry['nm_barang'];
						$content['satuan'] = $daqry['satuan'];
					}
				}else{
					$content['kodebarang'] = '';
					$content['namabarang'] = '';
					$content['satuan'] = '';
				}
			}
						
		}
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
			"<script type='text/javascript' src='js/pencarian/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			$scriptload;
	}
	
	
	function setPage_HeaderOther(){
		return "";
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
	  	   <th class='th01' width='5'>NO.</th>".
	  	   /*$Checkbox*/"		
		   <th class='th01'>KODE BARANG</th>
		   <th class='th01'>NAMA BARANG</th>
		   <th class='th01'>KETERANGAN</th>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function AmbilKetBarang($dt){
		global $DataPengaturan, $DataOption;
		
		$cmbAkun = cekPOST("cmbAkun");
		$cmbKelompok = cekPOST("cmbKelompok");
		$cmbJenis = cekPOST("cmbJenis");
		$cmbObyek = cekPOST("cmbObyek");
		$cmbRincianObyek = cekPOST("cmbRincianObyek");
		$cmbSubRincianObyek = cekPOST("cmbSubRincianObyek");
		
		$tbl = "ref_barang";
		$WHERE = "WHERE f1='".$dt["f1"]."' ";		
		$qry_f1 = $DataPengaturan->QyrTmpl1Brs("ref_barang", "concat(f1,'. ', nm_barang) as nama", $WHERE." AND f2='0' AND f='00' AND g='00' AND h='00' AND i='00' AND j='000' ");
		$dt_f1 = $qry_f1["hasil"];
		
		$WHERE .= " AND f2='".$dt["f2"]."' ";
		$qry_f2 = $DataPengaturan->QyrTmpl1Brs("ref_barang", "concat(f2,'. ', nm_barang) as nama", $WHERE." AND f='00' AND g='00' AND h='00' AND i='00' AND j='000' ");
		$dt_f2 = $qry_f2["hasil"];
		
		$WHERE .= " AND f='".$dt["f"]."' ";
		$qry_f = $DataPengaturan->QyrTmpl1Brs("ref_barang", "concat(f,'. ', nm_barang) as nama", $WHERE." AND g='00' AND h='00' AND i='00' AND j='000' ");
		$dt_F = $qry_f["hasil"];
		
		$WHERE .= " AND g='".$dt["g"]."' ";
		$qry_g = $DataPengaturan->QyrTmpl1Brs("ref_barang", "concat(g,'. ', nm_barang) as nama", $WHERE." AND h='00' AND i='00' AND j='000' ");
		$dt_g = $qry_g["hasil"];
		
		$WHERE .= " AND h='".$dt["h"]."' ";
		$qry_h = $DataPengaturan->QyrTmpl1Brs("ref_barang", "concat(h,'. ', nm_barang) as nama", $WHERE." AND i='00' AND j='000' ");
		$dt_h = $qry_h["hasil"];
		
		$WHERE .= " AND i='".$dt["i"]."' ";
		$qry_i = $DataPengaturan->QyrTmpl1Brs("ref_barang", "concat(i,'. ', nm_barang) as nama", $WHERE." AND j='000' ");
		$dt_i = $qry_i["hasil"];
		
		$ket="";
		$ktBRG = $dt_i["nama"];
		if($cmbSubRincianObyek == "")$ket="SUB RINCIAN OBYEK : ".$ktBRG;
			$ktBRG = $dt_h["nama"]." - ".$ktBRG;
		if($cmbRincianObyek == "")$ket="RINCIAN OBYEK :".$ktBRG;
			$ktBRG = $dt_g["nama"]." - ".$ktBRG;
		if($cmbObyek == "")$ket="OBYEK :".$ktBRG;
			$ktBRG = $dt_f["nama"]." - ".$ktBRG;
		if($cmbJenis == "")$ket="JENIS :".$ktBRG;
		
		if($DataOption['kode_barang'] == "2"){
			$ktBRG = $dt_f2["nama"]." - ".$ktBRG;
			if($cmbKelompok == "")$ket="KELOMPOK : ".$ktBRG;
			$ktBRG = $dt_f1["nama"]." - ".$ktBRG;
			if($cmbAkun == "")$ket="AKUN : ".$ktBRG;
		}
		
		return "<span style='font-size:9px;'>".$ket."</span>";
		
	}
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref,$DataOption;
	 $F1F2 = '';
	 if($DataOption['kode_barang'] == '2')$F1F2=$isi['f1'].".".$isi['f2'].".";
		
	 
	 $kodebarang = $F1F2.$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'];
	 $kodebarang = cekPOST2("jns_transaksi") == "3"?$kodebarang.".".$isi['j1']:$kodebarang;
	 //$kodebarang = $isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'];
	 
	 $OptionKdBrg = BtnText($kodebarang,$this->Prefix.".pilBar(`".$kodebarang."`)");
	 $OptionKdBrg = cekPOST2("Darinya")=="pemasukan_v2"?BtnText($kodebarang,$this->Prefix.".GetData_pemasukan_v2(`".$kodebarang."`)"):$OptionKdBrg;
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  /*if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);*/
	 $Koloms[] = array('align="center" width="150"',$OptionKdBrg);
	 $Koloms[] = array('align="left"',$isi['nm_barang']);
	 $Koloms[] = array('align="left" width="250"',$this->AmbilKetBarang($isi));
	 return $Koloms;
	}
	
	function Query_ref_barang($fld, $WHERE){
		return "SELECT $fld, nm_barang from ref_barang $WHERE";
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main,$DataOption, $DataPengaturan;
	 
	 $cmbAkun = cekPOST2('cmbAkun','0');
	 $cmbKelompok = cekPOST2('cmbKelompok','0');
	 $cmbJenis = cekPOST2('cmbJenis');
	 $cmbObyek = cekPOST2('cmbObyek');
	 $cmbRincianObyek = cekPOST2('cmbRincianObyek');
	 $cmbSubRincianObyek = cekPOST2('cmbSubRincianObyek');
	 $cmbSubSubRincianObyek = cekPOST2('cmbSubSubRincianObyek');
		
	 $data_array = array();
	 $style = "onChange=\"$this->Prefix.refreshList(true)\" style='width:300px;'";
	 
	$fmKODE = $_REQUEST['fmKODE'];	
	$fmBARANG = $_REQUEST['fmBARANG'];			
	//$fmPILCARI = $_REQUEST['fmPILCARI'];	
	//$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//$fmORDER1 = cekPOST('fmORDER1');
	//$fmDESC1 = cekPOST('fmDESC1');
	$cara_bayar = cekPOST2('cara_bayar');
	$status_kdp = cekPOST2('status_kdp');
	
	$jns_transaksi = cekPOST2("jns_transaksi");
	$where_FJNS='';
	
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
	 
	 if($DataOption['kode_barang'] == '2'){
		 $data_array[] =
			array(
				'label'=>'AKUN',
				'label-width'=>'200px;',
				'value'=>cmbQuery1("cmbAkun",$cmbAkun,$this->Query_ref_barang("f1","where f1 != '0' and f2 = '0' and f = '00' and g ='00' and h ='00' and i='00' and j = '000'  "),$style,'SEMUA AKUN',''),
			);
		 $whereKodeBarang = "WHERE f1='$cmbAkun' ";
		 $data_array[] =
			array(
				'label'=>'KELOMPOK',
				'label-width'=>'200px;',
				'value'=>cmbQuery1("cmbKelompok",$cmbKelompok,$this->Query_ref_barang("f2","$whereKodeBarang and f2!= '0' and f = '00' and g ='00' and h ='00' and i='00' and j = '000'  "),$style,'SEMUA KELOMPOK',''),
			);
		 $whereKodeBarang.= " and f2 = '$cmbKelompok' ";
	}else{
		$whereKodeBarang.= "WHERE f1='$cmbAkun' and f2 = '$cmbKelompok' ";
	}
	
	if($jns_transaksi == "1" && ($cara_bayar == "1" || $cara_bayar =="2") && $status_kdp=="1"){
		$whereKodeBarang.=" and f='$Main->KIB_F'"; 
		$cmbJenis=$Main->KIB_F;
	}
	if($jns_transaksi == "3"){
		$whereKodeBarang.=" and $Main->f_Persedian ";
		$cmbJenis = $Main->f_KodePersedian;
	}
	$data_array[] =
		array(
			'label'=>'JENIS',
			'label-width'=>'200px;',
			'value'=>cmbQuery1("cmbJenis",$cmbJenis,$this->Query_ref_barang("f","$whereKodeBarang and f!='00' and g='00' and h ='00' and i='00' and j= '000' "),$style,'SEMUA JENIS',''),
		);	 
	$whereKodeBarang.= " and f = '$cmbJenis' ";	 
	
	$data_array[] =
		array(
			'label'=>'OBYEK',
			'label-width'=>'200px;',
			'value'=>cmbQuery1("cmbObyek",$cmbObyek,$this->Query_ref_barang("g","$whereKodeBarang and g!='00' and h ='00' and i='00' and j= '000' "),$style,'SEMUA OBYEK',''),
		);	 
	 $whereKodeBarang.= " and g = '$cmbObyek' ";

	 $data_array[] =
		array(
			'label'=>'RINCIAN OBYEK',
			'label-width'=>'200px;',
			'value'=>cmbQuery1("cmbRincianObyek",$cmbRincianObyek,$this->Query_ref_barang("h","$whereKodeBarang and h!='00' and i='00' and j= '000' "),$style,'SEMUA RINCIAN OBYEK',''),
		);
	 
	 $whereKodeBarang.= " and h = '$cmbRincianObyek' ";
	 $data_array[] =
		array(
			'label'=>'SUB RINCIAN OBYEK',
			'label-width'=>'200px;',
			'value'=>cmbQuery1("cmbSubRincianObyek",$cmbSubRincianObyek,$this->Query_ref_barang("i","$whereKodeBarang and i!='00' and j= '000' "),$style,'SEMUA SUB RINCIAN OBYEK',''),
		);
		
	if($jns_transaksi == "3"){
		 $whereKodeBarang.= " and i = '$cmbSubRincianObyek' ";
		 $data_array[] =
			array(
				'label'=>'SUB SUB RINCIAN OBYEK',
				'label-width'=>'200px;',
				'value'=>cmbQuery1("cmbSubSubRincianObyek",$cmbSubSubRincianObyek,$this->Query_ref_barang("j","$whereKodeBarang and j!= '000' AND j1='0000' "),$style,'SEMUA SUB SUB RINCIAN OBYEK',''),
			);
	}
				
	$TampilOpt = 
		genFilterBar(
				array(
					$DataPengaturan->isiform($data_array)
		),'','','').
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
		global $Main, $HTTP_COOKIE_VARS,$DataOption;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		
		$fmPILCARI = cekPOST2('fmPILCARI');	
		$fmPILCARIvalue = cekPOST2('fmPILCARIvalue');	
		//cari tgl,bln,thn
		$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];			
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
		
		$cmbAkun = $_REQUEST['cmbAkun'];
		$cmbKelompok = $_REQUEST['cmbKelompok'];
		$cmbJenis = $_REQUEST['cmbJenis'];
		$cmbObyek = $_REQUEST['cmbObyek'];
		$cmbRincianObyek = $_REQUEST['cmbRincianObyek'];
		$cmbSubRincianObyek = $_REQUEST['cmbSubRincianObyek'];
		$cmbSubSubRincianObyek = $_REQUEST['cmbSubSubRincianObyek'];
		
		$status_kdp = cekPOST2("status_kdp");
		
		$fmKODE = $_REQUEST['fmKODE'];	
		$fmBARANG = $_REQUEST['fmBARANG'];	
		
		$fmKODE = $_REQUEST['fmKODE'];
		$kodebar = explode(".",$fmKODE);
		
		$cara_bayar = cekPOST("cara_bayar");
		$jns_transaksi = cekPOST("jns_transaksi");
		
		$status_dpa = cekPOST2("status_dpa");
		if($status_dpa == "1"){
			$kode_rekening_DPA = cekPOST2("kode_rekening_DPA");
			$WHERE_REK = "(concat(ka,'.',kb,'.',kc,'.',kd,'.',ke) = '$kode_rekening_DPA' OR";			
			$WHERE_REK.= " concat(l1,'.',l2,'.',l3,'.',l4,'.',l5) = '$kode_rekening_DPA' OR";			
			$WHERE_REK.= " concat(m1,'.',m2,'.',m3,'.',m4,'.',m5) = '$kode_rekening_DPA' OR";			
			$WHERE_REK.= " concat(n1,'.',n2,'.',n3,'.',n4,'.',n5) = '$kode_rekening_DPA' OR";			
			$WHERE_REK.= " concat(o1,'.',o2,'.',o3,'.',o4,'.',o5) = '$kode_rekening_DPA' OR";			
			$WHERE_REK.= " concat(k11,'.',l11,'.',m11,'.',n11,'.',o11) = '$kode_rekening_DPA' OR";			
			$WHERE_REK.= " concat(k12,'.',l12,'.',m12,'.',n12,'.',o12) = '$kode_rekening_DPA' OR";			
			$WHERE_REK.= " concat(k13,'.',l13,'.',m13,'.',n13,'.',o13) = '$kode_rekening_DPA')";
			$arrKondisi[] = $WHERE_REK;			
		}
		
		if($jns_transaksi == 1){
			if(($cara_bayar == '1' || $cara_bayar == '2') && $status_kdp=="1"){
				$arrKondisi[] = " f = '".$Main->KIB_F."'";
			}
		}
		
		if($jns_transaksi == 3 && $Main->Kode_j1 == 1){
			$arrKondisi[] = " j1 != '0000'";
		}
		
		//Cari 
		/*switch($fmPILCARI){			
			case 'selectSatuan': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;						 	
		}
		if(!empty($fmFiltTglBtw_tgl1)) $arrKondisi[]= " tgl_daftar>='$fmFiltTglBtw_tgl1'";
		if(!empty($fmFiltTglBtw_tgl2)) $arrKondisi[]= " tgl_daftar<='$fmFiltTglBtw_tgl2'";	*/
		/*$arrKondisi[] = " k != '0'";
		$arrKondisi[] = " l != '0'";
		$arrKondisi[] = " m != '0'";
		$arrKondisi[] = " n != '00'";
		$arrKondisi[] = " o != '00'";*/
	
		$arrKondisi[] = " f != '00'";
		$arrKondisi[] = " g != '00'";
		$arrKondisi[] = " h != '00'";
		$arrKondisi[] = " i != '00'";
		$arrKondisi[] = " j != '000'";
		if($jns_transaksi == "3")$arrKondisi[] = " j1 != '0000'";
		
		if($cmbAkun != '')$arrKondisi[] = " f1 = '$cmbAkun'";
		if($cmbKelompok != '')$arrKondisi[] = " f2 = '$cmbKelompok'";
		if($cmbJenis != '')$arrKondisi[] = " f = '$cmbJenis'";
		if($cmbObyek != '')$arrKondisi[] = " g = '$cmbObyek'";
		if($cmbRincianObyek != '')$arrKondisi[] = " h = '$cmbRincianObyek'";
		if($cmbSubRincianObyek != '')$arrKondisi[] = " i = '$cmbSubRincianObyek'";
		if($jns_transaksi == "3" && $cmbSubSubRincianObyek != '')$arrKondisi[] = " j = '$cmbSubSubRincianObyek'";
		
		if($fmBARANG != '')$arrKondisi[] = " nm_barang like '%$fmBARANG%'";
		
		if($DataOption['kode_barang'] == '2'){
			$arrKondisi[] = " f1 != '0'";
			$arrKondisi[] = " f2 != '0'";
			if(isset($kodebar[0]))if($kodebar[0] != '')$arrKondisi[] = " f1 = '".$kodebar[0]."'";
			if(isset($kodebar[1]))if($kodebar[1] != '')$arrKondisi[] = " f2 = '".$kodebar[1]."'";
			if(isset($kodebar[2]))if($kodebar[2] != '')$arrKondisi[] = " f = '".$kodebar[2]."'";
			if(isset($kodebar[3]))if($kodebar[3] != '')$arrKondisi[] = " g = '".$kodebar[3]."'";
			if(isset($kodebar[4]))if($kodebar[4] != '')$arrKondisi[] = " h = '".$kodebar[4]."'";
			if(isset($kodebar[5]))if($kodebar[5] != '')$arrKondisi[] = " i = '".$kodebar[5]."'";
			if(isset($kodebar[6]))if($kodebar[6] != '')$arrKondisi[] = " j = '".$kodebar[6]."'";	
		}else{
			if(isset($kodebar[2]))if($kodebar[2] != '')$arrKondisi[] = " f = '".$kodebar[0]."'";
			if(isset($kodebar[3]))if($kodebar[3] != '')$arrKondisi[] = " g = '".$kodebar[1]."'";
			if(isset($kodebar[4]))if($kodebar[4] != '')$arrKondisi[] = " h = '".$kodebar[2]."'";
			if(isset($kodebar[5]))if($kodebar[5] != '')$arrKondisi[] = " i = '".$kodebar[3]."'";
			if(isset($kodebar[6]))if($kodebar[6] != '')$arrKondisi[] = " j = '".$kodebar[4]."'";
		}
		
		//$arrKondisi[] = " q='00'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		/*if($fmORDER1 == ''){
			$arrOrders[] = " p ";
			$arrOrders[] = " q ";
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
	
	function setTopBar(){
	   	return '';
	}
	
	function windowShow_Konten_PenerimaanDPA(){
		global $DataPemasukan;
		$cek = ''; $err=''; $content='';
		
		$kd_rekPilBarang = cekPOST2("kd_rekPilBarang");
		$CekRekeningDPA = $DataPemasukan->Cek_DataDPA($this->Id_Terima,$this->status_dpa,$kd_rekPilBarang);
		if($err == "" && $CekRekeningDPA != 1)$err="Rekening Dari DPA Tidak Valid Atau Belum Di Pilih !"; 
		if($err == ""){
			$content = 
				InputTypeHidden("status_dpa",$this->status_dpa).
				InputTypeHidden("kode_rekening_DPA",$kd_rekPilBarang);
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function windowShow_Konten(){
		global $DataPemasukan;
		$cek = ''; $err=''; $content='';		
		$idplh = cekPOST2("pemasukan_ins_idplh");
		$status_dpa = cekPOST2("status_dpa");
		
		//Cek Apakah DPA
		$CekDataDPA = $DataPemasukan->Cek_DataDPA($idplh,$status_dpa); 
		if($CekDataDPA == 1){
			$this->Id_Terima=$idplh;
			$this->status_dpa=$status_dpa;
			$DataDPA=$this->windowShow_Konten_PenerimaanDPA();
			$cek.= $DataDPA["cek"];
			$err = $DataDPA["err"];
			$content = $DataDPA["content"];
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
		
		
		$cara_bayar = cekPOST2("cara_bayar");
		$jns_transaksi = cekPOST2("jns_transaksi",cekPOST2("Kdjns_tran"));
		$Darinya = cekPOST2("Darinya");
		$status_kdp = cekPOST2("status_kdp");
		
		$DataHidden=
			InputTypeHidden("status_kdp",$status_kdp).
			InputTypeHidden("Darinya",$Darinya).
			InputTypeHidden("idrekeningnya1","").
			InputTypeHidden("cara_bayar",$cara_bayar).
			InputTypeHidden("jns_transaksi",$jns_transaksi).
			InputTypeHidden($this->Prefix."_idplh",$this->form_idplh).
			InputTypeHidden($this->Prefix."_fmST",$this->form_fmST).
			InputTypeHidden("sesi",$sesi);
		
		if($Darinya == "pemasukan_v2"){
			$asalusul = cekPOST2("asalusul");
			$IdPenerimaan = cekPOST2("IdPenerimaan");
			$Kdjns_tran = cekPOST2("Kdjns_tran");
			if($err == ""&& $asalusul=="")$err="Cara Perolehan Belum di Pilih !";
			if($err == ""){
				$DataHidden.=
					InputTypeHidden("IdPenerimaan",$IdPenerimaan).
					InputTypeHidden("asal_usul",$asalusul).
					InputTypeHidden("Kdjns_tran",$Kdjns_tran);
			}
		}
		
		if($err == ""){
			$GetKonten = $this->windowShow_Konten();
			$cek.= $GetKonten["cek"];
			$err = $GetKonten["err"];
		}		
		
		if($err == ""){
			$form_name = $this->FormName;
			$FormContent = $this->genDaftarInitial($ref_jenis);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						1000,
						500,
						'Pilih Barang',
						'',
						/*"
						<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".*/
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						$DataHidden.
						$GetKonten["content"]
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';
		}
				
			
		//}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function GetData_pemasukan_v2(){
		global $Main, $HTTP_COOKIE_VARS,$DataPengaturan;
		$uid = $HTTP_COOKIE_VARS['coID']; 
		$cek = ''; $err=''; $content='';
		
		$kode = explode(".",cekPOST2("kode"));
		$IdPenerimaan = cekPOST2("IdPenerimaan");		
		$asal_usul = cekPOST2("asal_usul");		
		$Kdjns_tran = cekPOST2("Kdjns_tran");
		
		if($DataOption['kode_barang'] == '2'){
			$data_brg = 
				array(
					array("f1",$kode[0]),
					array("f2",$kode[1]),
					array("f",$kode[2]),
					array("g",$kode[3]),
					array("h",$kode[4]),
					array("i",$kode[5]),
					array("j",$kode[6]),
				);
			if($Kdjns_tran == "3")array_push($data_brg, array("j1",$kode[7]));
		}else{
			$data_brg = 
				array(
					array("f1","0"),
					array("f2","0"),
					array("f",$kode[0]),
					array("g",$kode[1]),
					array("h",$kode[2]),
					array("i",$kode[3]),
					array("j",$kode[4]),
				);
			if($Kdjns_tran == "3" && $Main->Kode_j1 == 1)array_push($data_brg, array("j1",$kode[5]));
		}
		if($Kdjns_tran != "3")array_push($data_brg, array("j1","0000"));
		
		$qry_hit = $DataPengaturan->QryHitungData2($this->TblName,$data_brg);$cek.=$qry["cek"];
		if($err == "" && $qry_hit["hasil"] < 1)$err="Kode Barang Tidak Valid !";
		
		//if($err == "")$err="gfd";
		if($err == ""){
			$qry_tmpl = $DataPengaturan->QyrTmpl1Brs2($this->TblName,"*", $data_brg);
			$dt_tmpl = $qry_tmpl["hasil"];
			$data_ins = 
				array(
					array("f1",$dt_tmpl["f1"]),
					array("f2",$dt_tmpl["f2"]),
					array("f",$dt_tmpl["f"]),
					array("g",$dt_tmpl["g"]),
					array("h",$dt_tmpl["h"]),
					array("i",$dt_tmpl["i"]),
					array("j",$dt_tmpl["j"]),
					array("j1",$dt_tmpl["j1"]),
					array("satuan",$dt_tmpl["satuan"]),
					array("refid_terima",$IdPenerimaan),
					array("status","1"),
					array("sttemp","1"),
					array("status_sblm","1"),
					array("uid",$uid),
					array("asal_usul",$asal_usul),
				);
			$qry_ins = $DataPengaturan->QryInsData("t_penerimaan_barang_det_v2",$data_ins);
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
}
$cariBarang = new cariBarangObj();
?>