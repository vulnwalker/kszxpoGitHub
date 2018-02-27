<?php

class popupSourceObj  extends DaftarObj2{
	var $Prefix = 'popupSource';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_kategori_tandatangan'; //daftar
	var $TblName_Hapus = 'ref_kategori_tandatangan';
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
	var $pagePerHal ='25';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'BARANG';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'popupSourceForm';
	var $username = "";

	function setTitle(){
		return 'MODUL';
	}
	function setMenuEdit(){
		return
			"";
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

	   	case 'getdata':{
                                        
                         

	 $cekTemp = mysql_num_rows(mysql_query("SELECT * from temp_jabatan where posisi =' ' and username = '$this->username'"));

			 if ($cekTemp > 0 ) {
			 	$err = 'DATA ADA YANG KOSONG ';
			 }else{

	               foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			 }

					$arrayKategoriFunction = array();

					$arrayKategoriFunction = array();
				
		
			 $arrayList = array();
			  $arrayPosisi = array();

                                         
                                         $listArray = $popupSource_cb;

                                         for ($i=0; $i < sizeof($listArray); $i++) { 
                                         	$getListItem = mysql_fetch_array(mysql_query("select * from ref_kategori_tandatangan where id ='$listArray[$i]'"));

                                         	 $namaSource = $getListItem['kategori_tandatangan'];
                                                     $arrayKategoriFunction[] = "&nbsp - ".$namaSource;

				 $arrayList[] = $listArray[$i];

				 $getListPosisi = mysql_fetch_array(mysql_query("select * from temp_jabatan where id_jabatan='$listArray[$i]'"));

				 $arrayPosisi[] = $getListPosisi['posisi'];
			
		
			

                                         }

			$listUpdate = "<br><b>JABATAN</b> : "."<br>".implode("<br>",$arrayKategoriFunction);	
	
			$content = array('listUpdate' => $listUpdate,"arrayList" => implode(';',$arrayList),"arrayPosisi" => implode(';',$arrayPosisi));
                                      }
			break;
	   }
	   
	   	case 'posisiChanged':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			 }

			if(mysql_num_rows(mysql_query("SELECT * FROM temp_jabatan where id_jabatan !='$idSource' and username ='$this->username' and posisi = '$posisi'")) == 0){
			 	mysql_query("UPDATE temp_jabatan set posisi ='$posisi' where id_jabatan='$idSource'");
			 	
			 	$cek = "SELECT * FROM temp_jabatan where id_jabatan !='$idSource' and username ='$this->username' and posisi = '$posisi";

			 }else if (mysql_num_rows(mysql_query("SELECT * FROM temp_jabatan where posisi ='$posisi' and username ='$this->username' and id_jabatan !='$idSource'")) >= 1 ) {
			              
			              $err = "DATA UNTUK POSISI:$posisi SUDAH ADA!";
			            
			 }

			 else{
			 	$data = array( 
					"username" => $this->username,
					"id_jabatan" => $idSource,
					'status' => "checked"
					 );
				mysql_query(VulnWalkerInsert("temp_jabatan",$data));
			 }
			
			break;
	   }

	   case 'checkboxChanged':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			 }

			 if($jenis !="checked"){
			 	mysql_query("delete from temp_jabatan where id_jabatan ='$id' and username ='$this->username'");
			 }else{
			 	$data = array( 
								"username" => $this->username,
								"id_jabatan" => $id,
								'status' => "checked"
							  );
				mysql_query(VulnWalkerInsert("temp_jabatan",$data));
			 }
			
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
			 "<script type='text/javascript' src='js/rencana_pengembangan/popupSource.js' language='JavaScript' ></script>".

			$scriptload;
	}

	//form ==================================

	function genDaftarInitial($fmSKPD='', $fmUNIT='', $fmSUBUNIT='',$tahun_anggaran='', $height=''){
		$vOpsi = $this->genDaftarOpsi();
		return
			//"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>".
			"</div>".
			"<div id=garis style='height:1;border-bottom:1px solid #E5E5E5;'></div>".
			"<div id=contain style='overflow:auto;height:$height;'>".
			//"<div id=contain style='overflow:auto;height:256;'>".
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".
			"</div>
			</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".
				"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
			"</div>";
	}

	function windowShow(){
		$cek = ''; $err=''; $content='';
		$json = TRUE;	//$ErrMsg = 'tes';
		$form_name = $this->FormName;

			$FormContent = $this->genDaftarInitial($fmSKPD, $fmUNIT, $fmSUBUNIT,$tahun_anggaran);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div',
						$FormContent,
						1200,
						400,
						'Pilih Jenis Jabatan',
						'',
						"<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' > &nbsp ".
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
						"<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';
		//}

		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	//daftar =================================
function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' rowspan='2' >No.</th>
  	   	<th class='th01' width='5'></th>	
		   <th class='th01' width='150'>JENIS KATEGORI</th>
		   <th class='th01' width='150'>POSISI</th>

	   </tr>
	   	 	

	   </thead>";
	 
		return $headerTable;
	}
	function setCekBox($cb, $KeyValueStr, $isi){
		$hsl = '';
		/*if($KeyValueStr!=''){*/
			$hsl = "<input type='checkbox' $isi id='".$this->Prefix."_cb$cb' name='".$this->Prefix."_cb[]' 
					value='".$KeyValueStr."' onchange = $this->Prefix.thisChecked($KeyValueStr,'".$this->Prefix."_cb$cb'); >";					
		/*}*/
		return $hsl;
	}
		function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 global $Ref;
	 foreach ($isi as $key => $value) { 
			  $$key = $value; 
			}
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
               
                 $dataTmp = mysql_fetch_array(mysql_query("SELECT * FROM temp_jabatan where id_jabatan='$id' and username='$this->username'"));
	 $TampilCheckBox =  $this->setCekBox($id, $id,$dataTmp['status']);
	 
	 if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 
	 $Koloms[] = array('align="left"',$kategori_tandatangan);

		$arrayJenis = array(
				                 array('1' , 'KIRI'),
				                 array('2' , 'TENGAH'),
				                 array('3' , 'KANAN'),
						
				       );

	if (mysql_num_rows(mysql_query("SELECT * FROM temp_jabatan where id_jabatan='$id' and username='$this->username'")) != 0) {
		$disabled = " ";
		$cmbStatus = $dataTmp['posisi'];
	}else{
		$disabled = "disabled";
	}

	$cmbStatus = cmbArray("cmbStatus$id",$cmbStatus,$arrayJenis,'-- Posisi --',"$disabled onchange ='$this->Prefix.thisPosisi($id);'");

	$Koloms[] = array('align="left"',$cmbStatus);


	$this->lastIdAplikasi = $id_aplikasi;
	$this->concatAplikasiModul =  $id_aplikasi.".".$id_modul;

	 
	 return $Koloms;
	}


	function genDaftarOpsi(){

	global $Ref, $Main;
	 Global $fmSKPDBidang,$fmSKPDskpd, $fmSKPDUrusan;
	$baris = $_REQUEST['baris'];
	$id_aplikasi = $_REQUEST['filterAplikasi'];
	$cmbProgramer = $_REQUEST['filterProgramer'];
	$cmbStatus = $_REQUEST['cmbStatus'];
	$filterTarget = $_REQUEST['filterTarget'];
	$filterModul = $_REQUEST['filterModul'];
	$filterKategori = $_REQUEST['filterKategori'];
	$filterUrut = $_REQUEST['filterUrut'];
	$filterNamaFile = $_REQUEST['filterNamaFile'];
	$fmDESC1 = cekPOST('fmDESC1');
	
		 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 $queryCmbModul = "select id, jenis_jabatan from ref_kategori_tandatangan";
	 $comboModul =  cmbQuery('filterModul',$filterModul,$queryCmbModul,"onchange = $this->Prefix.refreshList(true)",'-- Semua Modul --');
	$TampilOpt = 
			"<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td style='width:6%;'>SEMUA KATEGORI </td>
			<td style='width:1%;'>: </td>
			<td style='width:90%;' >$comboModul </td>
			</tr>
			
			
			</table>".
			"</div>".
			"<div class='FilterBar' style='margin-top:5px;'>";
			
		return array('TampilOpt'=>$TampilOpt);
	}			

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		foreach ($_REQUEST as $key => $value) { 
		  $$key = $value; 
	   }  
                          
                      
		if(!empty($filterModul))$arrKondisi[] = "id = '$filterModul'";

		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		

			$Order= join(',',$arrOrders);	
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
$popupSource = new popupSourceObj();
$popupSource->username = $_COOKIE['coID'];

?>
