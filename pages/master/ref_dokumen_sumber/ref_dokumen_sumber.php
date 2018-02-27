<?php
 
class ref_dokumen_sumberObj  extends DaftarObj2{	
	var $Prefix = 'ref_dokumen_sumber';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_dokumensumber'; //daftar 
	var $TblName_Hapus = 'ref_dokumensumber';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Dokumen Sumber';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = '';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_dokumen_sumberForm'; 
			
	function setTitle(){
		return 'Referensi Dokumen Sumber';
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
	 $dokumen = $_REQUEST['dokumen'];
		
	if( $err=='' && $dokumen =='' ) $err= 'Nama Dokumen Belum Di Isi !!';
	 
			if($fmST == 0){
			 	
				if($err==''){
					$aqry = "INSERT into ref_dokumensumber (nama_dokumen) values('$dokumen')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{						
				if($err==''){
				$aqry = "UPDATE ref_dokumensumber SET nama_dokumen='$dokumen' WHERE id='".$idplh."'";	$cek .= $aqry;
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
			 "<script type='text/javascript' src='js/master/ref_dokumen_sumber/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
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
	global $Main;
	$cek_retensi = $Main->HAL_RETENSI;		
	$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = $cbid[0];
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  ref_dokumensumber WHERE id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$penerimaan=mysql_query("select * from t_penerimaan_barang where dokumen_sumber='".$dt['nama_dokumen']."'"); 
		$penerimaan_retensi=mysql_query("select * from t_penerimaan_retensi where dokumen_sumber='".$dt['nama_dokumen']."'"); 
		$penerimaan_atribusi=mysql_query("select * from t_atribusi where dokumen_sumber='".$dt['nama_dokumen']."'"); 
	//	$cek.="select * from t_penerimaan_barang where dokumen_sumber='".$dt['nama_dokumen']."'";
		if($err==''){
			if (mysql_num_rows($penerimaan)>0)$err='Nama Dokumen Tidak bisa di Edit sudah ada di PENERIMAAN BARANG !!';
		}
		if($err=='' && $cek_retensi==1){
			if (mysql_num_rows($penerimaan_retensi)>0)$err='Nama Dokumen Tidak bisa di Edit, sudah ada di PENERIMAAN RETENSI !!';
		}
		
		if($err==''){
			if (mysql_num_rows($penerimaan_atribusi)>0)$err='Nama Dokumen Tidak bisa di Edit, sudah ada di  ARTIBUSI !!';
		}
	
		if($err==''){
		$fm = $this->setForm($dt);
		}
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}	
	
	function Hapus($ids){ 
	global $Main;		
	$cek_retensi = $Main->HAL_RETENSI;	
	
		$err=''; $cek='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		
		if ($err ==''){
		for($i = 0; $i<count($ids); $i++){	
		$dta=mysql_fetch_array(mysql_query("select * from ref_dokumensumber where id='".$ids[$i]."'"));
		$cek.="select * from ref_dokumensumber where id='".$ids[$i]."'";
		
		$penerimaan=mysql_query("select * from t_penerimaan_barang where dokumen_sumber='".$dta['nama_dokumen']."'"); 
		$penerimaan_retensi=mysql_query("select * from t_penerimaan_retensi where dokumen_sumber='".$dta['nama_dokumen']."'"); 
		$penerimaan_atribusi=mysql_query("select * from t_atribusi where dokumen_sumber='".$dta['nama_dokumen']."'"); 
	//	$cek.="select * from t_penerimaan_barang where dokumen_sumber='".$dt['nama_dokumen']."'";
		if($err==''){
			if (mysql_num_rows($penerimaan)>0)$err='Nama Dokumen Tidak bisa di Hapus sudah ada di PENERIMAAN BARANG !!';
		}
		if($err=='' && $cek_retensi==1){
			if (mysql_num_rows($penerimaan_retensi)>0)$err='Nama Dokumen Tidak bisa di Hapus, sudah ada di PENERIMAAN RETENSI !!';
		}
		
		if($err==''){
			if (mysql_num_rows($penerimaan_atribusi)>0)$err='Nama Dokumen Tidak bisa di Hapus, sudah ada di  ARTIBUSI !!';
		}
	
		if($err=='' ){
			$qy = "DELETE FROM ref_dokumensumber WHERE id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		
		
	
	
	
		}//for
		}
		return array('err'=>$err,'cek'=>$cek);
	}
	
	function setForm($dt){	
	 global $SensusTmp ,$Main,$DataPengaturan;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 350;
	 $this->form_height = 50;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU DOKUMEN SUMBER';
	  }else{
		$this->form_caption = 'EDIT DOKUMEN SUMBER';		
		$readonly='readonly';
					
	  }
	
	 
		
		//items ----------------------
		  $this->form_fields = array(
		  
		  	'dokumen' => array( 
						'label'=>'Nama Dokumen',
						'labelWidth'=>100, 
						'value'=>"
						<input type='text' name='dokumen' id='dokumen' value='".$dt['nama_dokumen']."' style='width:200px;'>"	
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
	   <th class='th01' width='450' >Dokumen</th>
	   </tr>
	   </thead>";
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	
	 	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	  $Koloms[] = array('align="left"',$isi['nama_dokumen']);
	 return $Koloms;
	}
		
	function genDaftarOpsi(){
	 global $Ref, $Main;
	
	$fmDokumen = $_REQUEST['fmKODE'];
	
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	
	$TampilOpt = 
	"<tr><td>".
			$vOrder=
			genFilterBar(
				array("<table style='width:100%'>
			<tr><td>
				Nama Dokumen : <input type='text' id='fmKODE' name='fmKODE' value='".$fmDokumen."' size=20px>&nbsp
&nbsp
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
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
		$fmDokumen = $_REQUEST['fmKODE'];
		
		
		if(!empty($_POST['fmKODE']) ) $arrKondisi[] = " nama_dokumen like '%".$_POST['fmKODE']."%'";
		//Cari 
				
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
$ref_dokumen_sumber = new ref_dokumen_sumberObj();
?>