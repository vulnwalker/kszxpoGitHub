<?php
 include "pages/pencarian/DataPengaturan.php";
 $DataOption = $DataPengaturan->DataOption();

class ref_kelengkapan_dokumenObj  extends DaftarObj2{	
	var $Prefix = 'ref_kelengkapan_dokumen';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_kelengkapan_dokumen'; //daftar 
	var $TblName_Hapus = 'ref_kelengkapan_dokumen';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Kelengkapan Dokumen';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'SKPD';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_kelengkapan_dokumenForm'; 
			
	function setTitle(){
		return 'Referensi Kelengkapan Dokumen';
	}
	
	function setMenuView(){
		return "";
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
		
		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>";	
	}	
	
	function simpan(){
	  global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $jns = $_REQUEST['jns'];
	 $syarat = $_REQUEST['syarat'];
		
	if( $err=='' && $jns =='' ) $err= 'Jenis Belum Di Pilih !!';
	 			if( $err=='' && $syarat =='' ) $err= 'Syarat Belum Di Isi !!';
	 
			if($fmST == 0){
			 	
				if($err==''){
					$aqry = "INSERT into ref_kelengkapan_dokumen (jns,syarat) values('$jns','$syarat')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{						
				if($err==''){
				$aqry = "UPDATE ref_kelengkapan_dokumen SET jns='$jns', syarat='$syarat' WHERE Id='".$idplh."'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());	
					}
			
			} //end else
					
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
		
		case 'simpan':{
			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
	   
	    			
	   
	  /* case 'hapus':{	
				$fm= $this->Hapus($pil);
				$err= $fm['err']; 
				$cek = $fm['cek'];
				$content = $fm['content'];
		break;
		}	*/		
	   
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
			 "<script src='js/skpd.js' type='text/javascript'></script>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/upload_style.css' type='text/css'>".
			"<script src='js/jquery.js' type='text/javascript'></script>".			
			"<script src='js/jquery-ui.js' type='text/javascript'></script>".
			"<script src='js/jquery.min.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/jquery.form.js'></script> ".
			"<script src='js/jquery-ui.custom.js'></script>".
			 "<script type='text/javascript' src='js/master/ref_kelengkapan_dokumen/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
			 ".
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".
			
			$scriptload;
	}
	
	function setFormBaru(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek = $cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$dt=array();
		$this->form_fmST = 0;
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
  	function setFormEdit(){
		
	$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = $cbid[0];
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  ref_kelengkapan_dokumen WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	
	function setForm($dt){	
	 global $SensusTmp ,$Main,$DataPengaturan;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 520;
	 $this->form_height = 70;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'FORM BARU KELENGKAPAN DOKUMEN';
	  }else{
		$this->form_caption = 'FORM EDIT KELENGKAPAN DOKUMEN';			
		$readonly='readonly';
					
	  }
	  $message=$dt['syarat'];
		//items ----------------------
		  $this->form_fields = array(
		  
		  	'jns' => array( 
						'label'=>'JENIS',
						'labelWidth'=>50, 
						'value'=>cmbArray('jns',$dt['jns'],$DataPengaturan->arr_pencairan_dana,"--- PILIH JENIS ---", "style='width:120px;'"),
						 ),	
						 
			'syarat' => array( 
						'label'=>'SYARAT',
						'labelWidth'=>50, 
						'value'=>"<input type='text' name='syarat' id='syarat' value='".$dt['syarat']."' placeholder='Syarat' style='width:420px;'>"
						
						 ),						 
			);
		//tombol
		$this->form_menubawah =	
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >"."&nbsp&nbsp".
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
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox		
	   <th class='th01' width='100' >Jenis</th>
	   <th class='th01' width='450' align='center'>Syarat</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 if($isi['jns']==1){
	 	$jns='SPP - LS';
	 }elseif($isi['jns']==2){
	 	$jns='SPP - UP';
	 }elseif($isi['jns']==3){
	 	$jns='SPP - GU';
	 }elseif($isi['jns']==4){
	 	$jns='SPP - TU';
	 }
	 	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	  $Koloms[] = array('align="left"',$jns);
	  $Koloms[] = array('align="left"',$isi['syarat']);
	 return $Koloms;
	}
		
	function genDaftarOpsi(){
	 global $Ref, $Main;
	
	$fmJns = $_REQUEST['fmJns'];	
	$crSyarat = $_REQUEST['crSyarat'];	
	
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	
	$arr = array(	
			array('1','SPP-LS'),	
			array('2','SPP-UP'),
			array('3','SPP-GU'),	
			array('4','SPP-TU'),	
		
			);
	$TampilOpt = 
	"<tr><td>".
			$vOrder=
			genFilterBar(
				array("<table>
						<tr>
						<td>
						<td>".cmbArray('fmJns',$fmJns,$arr,'-- Cari Jenis --','')."&nbsp".
						"<input type='text' value='".$crSyarat."' name='crSyarat' id='crSyarat' placeholder='Syarat'>
						<input type='button' id='btTampil' value='Cari' onclick='".$this->Prefix.".refreshList(true)'>
							</td>
						</tr>
						</table>
				"),'',''
			);
			
		return array('TampilOpt'=>$TampilOpt);
	}				
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$arrKondisi = array();	
		$fmJns = $_REQUEST['fmJns'];
		$crSyarat = $_REQUEST['syarat'];
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		
		if(empty($fmJns)) {
			
		}
		elseif(!empty($fmJns))
		{
			$arrKondisi[]= "jns =$fmJns";
		}
		if(!empty($_POST['fmJns']) ) $arrKondisi[] = " jns like '%".$_POST['fmJns']."%'";
		if(!empty($_POST['crSyarat']) ) $arrKondisi[] = " syarat like '%".$_POST['crSyarat']."%'";
		//Cari 
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			
			case 'selectNama': $arrKondisi[] = " nama_rek like '%$fmPILCARIvalue%'"; break;	
			case 'selectRuang': $arrKondisi[] = " syarat like '%$fmPILCARIvalue%'"; break;	
								 	
		}	
		
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " jns $Asc1 " ;break;
			case '2': $arrOrders[] = " saldo $Asc1 " ;break;
			
		}	
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		
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
$ref_kelengkapan_dokumen = new ref_kelengkapan_dokumenObj();
?>