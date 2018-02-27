<?php

class listBarangMaxObj  extends DaftarObj2{	
	var $Prefix = 'listBarangMax';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'temp_standar_kebutuhan'; //bonus
	var $TblName_Hapus = 'temp_standar_kebutuhan';
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
	var $fileNameExcel='listBarangMax.xls';
	var $namaModulCetak='RINCIAN TEMPLATE';
	var $Cetak_Judul = 'RINCIAN TEMPLATE';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'listBarangMaxForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	var $username = "";

	
	
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
		
		case 'jumlahChanged': {
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			}
			$data = array(
							'jumlah' => $VALUE
							);
			$query = VulnWalkerUpdate('temp_standar_kebutuhan',$data,"id = '$ID'");
			mysql_query($query);
			$cek = $query;

			
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
			<script type='text/javascript' src='js/master/refstdbutuh/listBarangMax.js' language='JavaScript' ></script>
			
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
  	   <th class='th01' width='100'>KODE</th>	
  	   <th class='th01' width='900'>NAMA BARANG</th>	
	   <th class='th01' width='100'>JUMLAH</th>		
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 $idnya = $isi['id'];
	 foreach ($isi as $key => $value) { 
		  $$key = $value; 
	 } 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	 $kodeBarang =$f.".".$g.".".$h.".".$i.".".$j;
	 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) ='$kodeBarang'"));
	 $namaBarang = $getNamaBarang['nm_barang'];
	 $Koloms[] = array('align="center"',$kodeBarang); 
	 $Koloms[] = array('align="left"',$namaBarang); 
	 $Koloms[] = array('align="center"',"<input type='text' name='$idnya' id='$idnya'  align='center' style='text-align: right;  width:50px' value='".$isi['jumlah']."'onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup=$this->Prefix.jumlahChanged(this); >"); 


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
				
	$TampilOpt = 
			"<form id='listBarangMaxForm'><div class='FilterBar'>".

			
			"<table style='width:100%'>
			<tr>
			<td style='width:170px;' >JENIS</td><td>:</td>
			<td>".
			cmbQuery1("cmbJenis",$cmbJenis,"select f as valueCmbJenis, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f != '00'  and g ='00' and h ='00' and i='00' and j = '000'","onChange=listBarangMax.refreshList(true) ",'Pilih','').
			"</td>
			</tr><tr>
			<td style='width:170px;'>OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbObyek",$cmbObyek,"select g as valueCmbObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g !='00' and h ='00' and i='00' and j = '000'","onChange=\"listBarangMax.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td style='width:170px;'>RINCIAN OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbRincianObyek",$cmbRincianObyek,"select h as valueCmbRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h !='00' and i='00' and j = '000'","onChange=\"listBarangMax.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>
			<tr>
			<td style='width:170px;'>SUB RINCIAN OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbSubRincianObyek",$cmbSubRincianObyek,"select i as valueCmbSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i != '00' and j = '000'","onChange=\"listBarangMax.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>
			<tr>
			<td style='width:170px;'>SUB-SUB RINCIAN OBYEK</td><td>:</td>
			<td>".
			cmbQuery1("cmbSubSubRincianObyek",$cmbSubSubRincianObyek,"select j as valueCmbSubSubRincianObyek, nm_barang from ref_barang where f1 = '$cmbAkun' and f2 = '$cmbKelompok' and f = '$cmbJenis'  and g ='$cmbObyek' and h ='$cmbRincianObyek' and i='$cmbSubRincianObyek' and j != '000'","onChange=\"listBarangMax.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>
			
			</table>".
			"</div>".
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Kode Barang : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' size=20px>&nbsp
				Nama Barang : <input type='text' id='fmBARANG' name='fmBARANG' value='".$fmBARANG."' size=30px>&nbsp
				<input type='button' id='btTampil' value='Tampilkan' onclick='listBarangMax.refreshList(true)'>
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
		
		switch($fmPILCARI){
			case 'selectfg': $arrKondisi[] = " concat(f,g) like '%$fmPILCARIvalue%'"; break;		 	
			case 'selectbarang': $arrKondisi[] = " nama_barang like '%".$fmPILCARIvalue."%'"; break;					 	
		}
		$this->kondisiSKPD = " and c1='".$_REQUEST['c1']."' and c='".$_REQUEST['c']."' and d='".$_REQUEST['d']."' and e='".$_REQUEST['e']."'  and e1='".$_REQUEST['e1']."'";
		
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
			$this->copyDataBarang(" and f='$cmbJenis' and g = '$cmbObyek' and h ='$cmbRincianObyek'");	
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
			 if(mysql_num_rows(mysql_query("select * from temp_standar_kebutuhan where username = '$this->username' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'")) == 0){
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
			 		$query = VulnWalkerInsert('temp_standar_kebutuhan',$data);
			 		mysql_query($query);
			 }

		}
	}	
	

}
$listBarangMax = new listBarangMaxObj();
$listBarangMax->username = $_COOKIE['coID'];
?>
