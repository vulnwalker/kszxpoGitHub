<?php

class ref_jenis_tagihanObj  extends DaftarObj2{	
	var $Prefix = 'ref_jenis_tagihan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
//	var $TblName = 'ref_tandatangan'; //daftar
	var $TblName = 'ref_jenis_tagihan'; //daftar
	var $TblName_Hapus = 'ref_jenis_tagihan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Jenis Tagihan';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
//	var $fileNameExcel='ref_tim_anggaran.xls';
	var $Cetak_Judul = 'Referensi Jenis Tagihan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_jenis_tagihanForm'; 
	var $kdbrg = '';	
	
	var $arrGroup = array( 
		array('1','1.Tim Anggaran'),
		array('2','2.Di Teliti Oleh'),
		array('3','3.Tim Asistensi')
		);
	
			
	function setTitle(){
		return 'REFERENSI JENIS TAGIHAN';
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
		
		//$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD'); //echo 'fmskpd='.$fmSKPD;
		//$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		//$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
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
     $tagihan= $_REQUEST['tagihan'];
     $uraian= $_REQUEST['uraian'];
     
	//$dat=mysql_fetch_array(mysql_query("select * from ref_kategori_perda where kategori_perda='$kategori'"));
	
	//$oldy=mysql_fetch_array(mysql_query("select count(*) as cnt from ref_perda where no_urut='$urut'"));
	//$oldy2=mysql_fetch_array(mysql_query("select count(*) as cnt from ref_tim_anggaran where no_urut='$urut'"));
	 if( $err=='' && $tagihan =='' ) $err= 'Nama Tagihan Belum Di Isi !!';
	 /*if( $err=='' && $kategori =='' ) $err= 'Kategori Belum Di Pilih !!';
	 if( $err=='' && $no_peraturan =='' ) $err= 'No Peraturan Belum Di Isi !!';
	 if( $err=='' && $tgl_peraturan =='' ) $err= 'Tanggal Peraturan Belum Di Isi !!';*/
	// if( $err=='' && $jabatan =='' ) $err= 'Jabatan Belum Di Isi !!';
	
			if($fmST == 0){
			
		//	if($err=='' && $oldy['cnt']>0) $err="No Urut '$urut' Sudah Ada";
			
				if($err==''){
			
				$aqry = "INSERT into ref_jenis_tagihan (nm_tagihan,keterangan) values('$tagihan','$uraian')";	$cek .= $aqry;	
				$qry = mysql_query($aqry);
				}
			}else{
							
			if($err==''){
				$aqry = "UPDATE ref_jenis_tagihan SET nm_tagihan='$tagihan',keterangan='$uraian' WHERE Id='".$idplh."'";	$cek .= $aqry;
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
		
		$tagihan=mysql_query("select * from ref_tagihan where refid_jns_tagihan='".$ids[$i]."'"); 
		
		if($err==''){
			if (mysql_num_rows($tagihan)>0)$err='Nama Jenis Tagihan Tidak bisa di Hapus sudah ada di Referensi Tagihan !!';
		}
	
		if($err=='' ){
			$qy = "DELETE FROM ref_jenis_tagihan WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
			
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
			"<script type='text/javascript' src='js/master/ref_tagihan/ref_jenis_tagihan.js' language='JavaScript' ></script>".
			'
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>
			'.
			
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
		$aqry = "SELECT * FROM  ref_jenis_tagihan WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 650;
	 $this->form_height = 80;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU JENIS TAGIHAN';
		$nip	 = '';
		
	  }else{
		$this->form_caption = 'EDIT JENIS TAGIHAN';			
		$readonly='readonly';
			
	  }
	  $Id = $_REQUEST['Id'];
	 
		$this->form_fields = array(
		
			'nama_tagihan' => array( 
						'label'=>'NAMA TAGIHAN',
						'labelWidth'=>100, 
						'value'=>"
						<input type='text' name='tagihan' id='tagihan' value='".$dt['nm_tagihan']."' style='width:500px;'>
						", 
						 ),	
			
			'Urainan' => array( 
						'label'=>'URAIAN',
						'labelWidth'=>50, 
						'value'=>"
						<textarea name='uraian' id='uraian' style='margin: 0px; width: 500px; height: 25px;' >".$dt['keterangan']."</textarea>
					
						", 
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
	
	function setKolomHeader($Mode=1, $Checkbox=''){
	$NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox
	   <th class='th01' width='500' align='center'>Nama Tagihan</th>
	   <th class='th01' width='600' align='center'>Uraian</th>		
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	$kategori=mysql_fetch_array(mysql_query("select * from ref_kategori_perda where Id='".$isi['refid_kategori']."'"));	
	
	
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$isi['nm_tagihan']);
	 $Koloms[] = array('align="left"',$isi['keterangan']);	
	 return $Koloms;
	}
	
	function setMenuView(){
		
			}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	
	$nmTagihan = cekPOST('nmTagihan');
	
	/*$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	 
	$arrKategori = array(
					array('1','1.Tim Anggaran'),
					array('2','2.Di Teliti Oleh'),
					array('3','3.Tim Asistensi'),
				); 
	 
	$arr = array(
			//array('selectAll','Semua'),	
			array('selectNIP','NIP'),	
			array('selectNama','Nama'),		
			array('selectJabatan','Jabatan'),		
			);*/
	$TampilOpt = 
			
			
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Cari : <input type='text' id='nmTagihan' name='nmTagihan' value='".$nmTagihan."' size=50px placeholder='Nama Tagihan'>&nbsp
				
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
		/*$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		*/
		$nmTagihan = cekPOST('nmTagihan');
			/*switch($_REQUEST['fmFiltStatus2']){
				case '1': $fmFiltStatus2='(kategori =1)'; break;
				case '2': $fmFiltStatus2='(kategori =2)'; break;
				case '3': $fmFiltStatus2='(kategori =3)'; break;
				
			}*/
			
		//$isivalue=explode('.',$fmPILCARIvalue);
		/*switch($fmPILCARI){			
			case 'selectNIP': $arrKondisi[] = " nip like '$fmPILCARIvalue%'"; break;
			case 'selectNama': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;	
			case 'selectJabatan': $arrKondisi[] = " jabatan like '%$fmPILCARIvalue%'"; break;	
		}*/		
		
		if(!empty($_POST['nmTagihan'])) $arrKondisi[] = " nm_tagihan like '%".$_POST['nmTagihan']."%'";		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		/*switch($fmORDER1){
		
			case '1': $arrOrders[] = " nip $Asc1 " ;break;
			case '2': $arrOrders[] = " nama $Asc1 " ;break;
			case '3': $arrOrders[] = " jabatan $Asc1 " ;break;
			
		}*/	
			
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
$ref_jenis_tagihan = new ref_jenis_tagihanObj();
?>