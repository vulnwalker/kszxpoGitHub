<?php

class ref_jenis_pemeliharaanObj  extends DaftarObj2{	
	var $Prefix = 'ref_jenis_pemeliharaan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_jenis_pemeliharaan'; //bonus
	var $TblName_Hapus = 'ref_jenis_pemeliharaan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Jenis Pemeliharaan';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='Pangkat.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'Jenis Pemeliharaan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_jenis_pemeliharaanForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	var $stAset = array(
			array('1','YA'), 
			array('2','TIDAK'),
		);
		
	var $stManfaat = array(
			array('1','YA'), 
			array('2','TIDAK'),
		);
	
	function setTitle(){
		return 'Jenis Pemeliharaan';
	}
	
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
	}
	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];	 
	 
	 $jenis = $_REQUEST['jenis'];
	 $aset = $_REQUEST['aset'];
	 $manfaat = $_REQUEST['manfaat'];
	 
	 if( $err=='' && $jenis =='' ) $err= 'Jenis Pemeliharaan Belum di isi !!';
	 if( $err=='' && $aset =='' ) $err= 'Menambahaan Nilai Aset Belum Di Pilih !!';
	 if( $err=='' && $manfaat =='' ) $err= 'Menambah Masa Manfaat Belum Di Pilih !!';
	
	 		
				
			if($fmST == 0){
			$cekjenis=mysql_num_rows(mysql_query("select jenis from ref_jenis_pemeliharaan where jenis='$jenis'"));
			$cek.=$cekjenis;
			if($cekjenis > 0 )$err='Nama Jenis Pemeliharaan Sudah ada';
			
			
			
			
				if($err==''){
					$aqry = "INSERT into ref_jenis_pemeliharaan (jenis,menambah_aset,menambah_manfaat) values('$jenis','$aset','$manfaat')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{
				if($err==''){
						$aqry = "UPDATE ref_jenis_pemeliharaan set jenis='$jenis',menambah_aset='$aset',menambah_manfaat='$manfaat' where Id='".$idplh."'";	$cek .= $aqry;
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
		case 'hapus':{ //untuk ref_kota
					$idplh= $_REQUEST['Id'];		
					$get= $this->Hapus();
					$err= $get['err']; 
					$cek = $get['cek'];
					$json=TRUE;	
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
   
   function Hapus($ids){ //validasi hapus ref_kota
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++)	{
			if($err=='' ){
					$qy = "DELETE FROM ref_jenis_pemeliharaan WHERE Id='".$ids[$i]."' ";$cek.=$qy;
					$qry = mysql_query($qy);
						
			}else{
				break;
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
		"<script src='js/skpd.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/master/ref_jenis_pemeliharaan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			$scriptload;
	}
	
	//form ==================================
	function setFormBaru(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
   
  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  ref_jenis_pemeliharaan WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	s 	
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 100;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'FORM BARU JENIS PEMELIHARAAN';
		$cmbRo = '';
	  }else{
		$this->form_caption = 'FORM EDIT JABATAN';	
		


	  }
	    //ambil data trefditeruskan


	
	 //items ----------------------
	  $this->form_fields = array(
	  	  	
			'jenis' => array( 
						'label'=>'Jenis Pemeliharaan',
						'labelWidth'=>150, 
					//	'value'=>inputFormatRibuan('jumlah','size=33', $dt['jumlah'],'')
						'value'=>"<input type='text' name='jenis' id='jenis' value='".$dt['jenis']."' style='width:220px;'>",
						
						 ),	
			'aset' => array( 
						'label'=>'Menambah Nilai Aset',
						'labelWidth'=>100, 
						'value'=>cmbArray('aset',$dt['menambah_aset'],$this->stAset,'--PILIH--',''), 
						 ),	 	
			'manfaat' => array( 
						'label'=>'Menambah Masa Manfaat',
						'labelWidth'=>100, 
						'value'=>cmbArray('manfaat',$dt['menambah_manfaat'],$this->stManfaat,'--PILIH--',''), 
						 ),	 	
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >  &nbsp  ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setNavAtas(){
		global $Main;
		return
		
			'<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td class="menudottedline" width="60%" height="20" style="text-align:right"><b>
				
			</tr>
			</table>';
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='10' >No.</th>
  	   $Checkbox		
	   <th class='th01' width='900'>Jenis</th>
	   <th class='th01' width='900'>Menambahan Nilai Aset</th>
	   <th class='th01' width='900'>Menambahan Masa Manfaat</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 
	 if($isi['menambah_aset']==1){
	 	$aset='YA';
	 }elseif($isi['menambah_aset']==2){
	 	$aset='TIDAK';
	 }
	 
	 if($isi['menambah_manfaat']==1){
	 	$manfaat='YA';
	 }elseif($isi['menambah_manfaat']==2){
	 	$manfaat='TIDAK';
	 }
	 $skpd=mysql_fetch_array(mysql_query("select c1,c,d,nm_skpd from ref_skpd where c1='$c1' and c='$c' and d='$d'"));
	 $cek.=$skpd;
	 
	 
	 $Koloms[] = array('align="left"',$isi['jenis']);
	 $Koloms[] = array('align="left"',$aset);
	 $Koloms[] = array('align="left"',$manfaat);
	
	 return $Koloms;
	}
	
	
	function setMenuView(){
		
			}
	
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	
	 $arr = array(
			//array('selectAll','Semua'),
			array('selectfg','Kode Barang'),
			array('selectbarang','Nama Barang'),	
			);
		
		
	//data order ------------------------------
	 $arrOrder = array(
	  	         array('1','Kode Barang'),
			    // array('2','Nama Barang'),	
	 );	
				
	$TampilOpt = 
				
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Jenis Pemeliharaan : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' size=20px>&nbsp
				
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
			</table>".
			"</div>".
			"<input type='hidden' id='fmORDER18' name='fmORDER18' value='".$fmORDER18."'>".
			"<input type='hidden' id='fmORDER19' name='fmORDER19' value='".$fmORDER19."'>";	
			"";
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$arrKondisi = array();	
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
	 	$fmBIDANG = cekPOST('fmBIDANG');
	    $fmKELOMPOK = cekPOST('fmKELOMPOK');
		$fmSUBKELOMPOK = cekPOST('fmSUBKELOMPOK');
		$fmSUBSUBKELOMPOK = cekPOST('fmSUBSUBKELOMPOK');
		$fmKODE = cekPOST('fmKODE');
		$fmBARANG = cekPOST('fmBARANG');
		//Cari 
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			
			case 'selectKode': $arrKondisi[] = " jenis like '$fmPILCARIvalue%'"; break;
			case 'selectNama': $arrKondisi[] = " nm_rekening like '%$fmPILCARIvalue%'"; break;	
				
								 	
		}	
				
		if(!empty($_POST['fmKODE'])) $arrKondisi[] = " jenis like '".$_POST['fmKODE']."%'";					
		if(!empty($_POST['fmBARANG'])) $arrKondisi[] = " nm_rekening like '%".$_POST['fmBARANG']."%'";
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " jenis $Asc1 " ;break;
			case '2': $arrOrders[] = " nm_skpd $Asc1 " ;break;
			
		}	
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
$ref_jenis_pemeliharaan = new ref_jenis_pemeliharaanObj();
?>