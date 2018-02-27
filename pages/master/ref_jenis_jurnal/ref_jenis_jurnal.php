<?php

class ref_jenis_jurnalObj  extends DaftarObj2{	
	var $Prefix = 'ref_jenis_jurnal';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
//	var $TblName = 'ref_tandatangan'; //daftar
	var $TblName = 'ref_jns_jurnal'; //daftar
	var $TblName_Hapus = 'ref_jns_jurnal';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Jenis Jurnal';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
//	var $fileNameExcel='ref_tim_anggaran.xls';
	var $Cetak_Judul = 'Referensi Jenis Jurnal';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_jenis_jurnalForm'; 
	var $kdbrg = '';	
	
	function setTitle(){
		return 'REFERENSI JENIS JURNAL';
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
     $nm_jurnal= $_REQUEST['nm_jurnal'];
     $st_jurnal= $_REQUEST['st_jurnal'];
     
	 if( $err=='' && $nm_jurnal =='' ) $err= 'Nama Jurnal Belum Di Isi !!';
	 if( $err=='' && $st_jurnal =='' ) $err= 'Status Jurnal Belum Di Isi !!';
	
			if($fmST == 0){
				if($err==''){
				$aqry = "INSERT into ref_jns_jurnal (nm_jns_jurnal,st_pilih) values('$nm_jurnal','$st_jurnal')";	$cek .= $aqry;
				$qry = mysql_query($aqry);
				}
			}else{
							
			if($err==''){
				$aqry = "UPDATE ref_jns_jurnal SET nm_jns_jurnal='$nm_jurnal',st_pilih='$st_jurnal' WHERE Id='".$idplh."'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());
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
   
	function Hapus($ids){ 
	global $Main;		
	
		$err=''; $cek='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		
		if ($err ==''){
		for($i = 0; $i<count($ids); $i++){	
		/*$jurnal="select count(*) as cnt from t_jurnal_keuangan where jns_jurnal='".$dt['Id']."'";$cek.=$jurnal;
		$jurnal_keuangan=mysql_fetch_array(mysql_query($jurnal));
		
		if($jurnal_keuangan['cnt']>0){
		$fm['err']="Data Tidak Bisa di Edit, Sudah Digunakan Jurnal Keuangan !!";			
		*/
		
		$jurnal=mysql_query("select * from t_jurnal_keuangan where jns_jurnal='".$ids[$i]."'"); 
		
		if($err==''){
			if (mysql_num_rows($jurnal)>0)$err='Nama Jenis Jurnal Tidak bisa di Hapus sudah ada di Jurnal Keuangan !!';
		}
	
		if($err=='' ){
			$qy = "DELETE FROM ref_jns_jurnal WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		}
		}
		return array('err'=>$err,'cek'=>$cek);
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
			
			
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/upload_style.css' type='text/css'>".
			"<script src='js/jquery.js' type='text/javascript'></script>".			
			"<script src='js/jquery-ui.js' type='text/javascript'></script>".
			"<script src='js/jquery.min.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/jquery.form.js'></script> ".
			"<script src='js/jquery-ui.custom.js'></script>".
			"<script type='text/javascript' src='js/master/ref_jenis_jurnal/ref_jenis_jurnal.js' language='JavaScript' ></script>".
			$scriptload;
	}
	
	//form ==================================
	
	function setFormBaru(){
		global $Main;
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek =$cbid[0];				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		
		$dt=array();
		$this->form_fmST = 0;
			$fm = $this->setForm($dt);
			return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormEdit(){
	global $Main;	
	$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = $cbid[0];
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  ref_jns_jurnal WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		
		/*$jurnal="select count(*) as cnt from t_jurnal_keuangan where jns_jurnal='".$dt['Id']."'";$cek.=$jurnal;
		$jurnal_keuangan=mysql_fetch_array(mysql_query($jurnal));
		
		if($jurnal_keuangan['cnt']>0){
		$fm['err']="Data Tidak Bisa di Edit, Sudah Digunakan Jurnal Keuangan !!";			
		}else{
		$fm = $this->setForm($dt);	
		}*/
		
		
		$fm = $this->setForm($dt);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 70;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU JENIS JURNAL';
	  }else{
		$this->form_caption = 'EDIT JENIS JURNAL';			
	//	$readonly='readonly';
			
	  }
	  $Id = $_REQUEST['Id'];
	 
		$this->form_fields = array(
		
			'nama_jurnal' => array( 
						'label'=>'NAMA JURNAL',
						'labelWidth'=>100, 
						'value'=>"
						<input type='text' name='nm_jurnal' id='nm_jurnal' value='".$dt['nm_jns_jurnal']."' style='width:250px;'>
						", 
						 ),	
			'status_jurnal' => array( 
						'label'=>'STATUS JURNAL',
						'labelWidth'=>100, 
						'value'=>"
						<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength='1' name='st_jurnal' id='st_jurnal' value='".$dt['st_pilih']."' style='width:20px;' >
						", 
						 ),	
			);
		
		$this->form_menubawah =	
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setKolomHeader($Mode=1, $Checkbox=''){
	$NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox
	   <th class='th01' width='500' align='center'>Nama Jenis Jurnal</th>
	   <th class='th01' width='50' align='center'>Status Jurnal</th>		
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$isi['nm_jns_jurnal']);
	 $Koloms[] = array('align="left"',$isi['st_pilih']);	
	 return $Koloms;
	}
	
	function setMenuView(){
		
			}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	
	$nm_jurnal = cekPOST('nm_jurnal');
	$status_jurnal = cekPOST('status_jurnal');
	
	$TampilOpt = 
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Cari : <input type='text' id='nm_jurnal' name='nm_jurnal' value='".$nm_jurnal."' size=50px placeholder='Nama Jenis Jurnal'>&nbsp
				<input type='text' id='status_jurnal' name='status_jurnal' value='".$status_jurnal."' size=10px placeholder='Status Jurnal'>&nbsp		
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
			</table>".
			"</div>".
			"";
	
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$arrKondisi = array();	
		
		$nm_jurnal = cekPOST('nm_jurnal');
		$status_jurnal = cekPOST('status_jurnal');
				
		if(!empty($_POST['nm_jurnal'])) $arrKondisi[] = " nm_jns_jurnal like '%".$_POST['nm_jurnal']."%'";		
		if(!empty($_POST['status_jurnal'])) $arrKondisi[] = " st_pilih like '%".$_POST['status_jurnal']."%'";		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		$arrOrders[] = " Id asc $Asc1 ";			
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
}
$ref_jenis_jurnal = new ref_jenis_jurnalObj();
?>