<?php

class ref_tim_anggaranObj  extends DaftarObj2{	
	var $Prefix = 'ref_tim_anggaran';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
//	var $TblName = 'ref_tandatangan'; //daftar
	var $TblName = 'ref_tim_anggaran'; //daftar
	var $TblName_Hapus = 'ref_tim_anggaran';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Tim Anggaran';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='ref_tim_anggaran.xls';
	var $Cetak_Judul = 'TIM ANGGARAN';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_tim_anggaranForm'; 
	var $kdbrg = '';	
	
	var $arrGroup = array( 
		array('1','1.Tim Anggaran'),
		array('2','2.Di Teliti Oleh'),
		array('3','3.Tim Asistensi')
		);
	
			
	function setTitle(){
		return 'TIM ANGGARAN';
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
			/*"<table width=\"100%\" border=\"0\">
				<tr>
					<td class=\"subjudulcetak\">".PrintSKPD2($fmSKPD, $fmUNIT, $fmSUBUNIT)."</td>
				</tr>
			</table><br>";*/
	}	
	
	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
     $urut= $_REQUEST['urut'];
     $group= $_REQUEST['group_akhir'];
	 $nama= $_REQUEST['nama'];
	 $nip= $_REQUEST['nip'];
	 $jabatan= $_REQUEST['jabatan'];
	
	
	$oldy=mysql_fetch_array(mysql_query("select count(*) as cnt from ref_tim_anggaran where nip='$nip'"));
	$oldy2=mysql_fetch_array(mysql_query("select count(*) as cnt from ref_tim_anggaran where no_urut='$urut'"));
	 if( $err=='' && $urut =='' ) $err= 'No Urut Belum Di Isi !!';
	 if( $err=='' && $group =='' ) $err= 'Group Belum Di Pilih !!';
	 if( $err=='' && $nama =='' ) $err= 'Nama Belum Di Isi !!';
	 if( $err=='' && $nip =='' ) $err= 'NIP Belum Di Isi !!';
	 if( $err=='' && $jabatan =='' ) $err= 'Jabatan Belum Di Isi !!';
	
			if($fmST == 0){
			
			if($err=='' && $oldy['cnt']>0) $err="NIP '$nip' Sudah Ada";
			if($err=='' && $oldy2['cnt']>0) $err="No Urut '$urut' Sudah Ada";
				if($err==''){
			
				$aqry = "INSERT into ref_tim_anggaran (no_urut,kategori,nama,nip,jabatan) values('$urut','$group','$nama','$nip','$jabatan')";	$cek .= $aqry;	
				$qry = mysql_query($aqry);
				}
			}else{
				$old = mysql_fetch_array(mysql_query("select * from ref_tim_anggaran where id='$idplh'"));								if($nip!=$old['nip'] ){
							$get = mysql_fetch_array(mysql_query(
								"select count(*) as cnt from ref_tim_anggaran where nip='$nip' "
							));
							if($get['cnt']>0 ) $err="NIP '$nip' Sudah Ada!";
						}
			
			if($err==''){
				$aqry = "UPDATE ref_tim_anggaran SET no_urut='$urut',nama='$nama', kategori='$group',nip='$nip', jabatan='$jabatan' WHERE id='".$idplh."'";	$cek .= $aqry;
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
		
		case 'pilihPangkat':{				
			global $Main;
			$cek = ''; $err=''; $content=''; $json=TRUE;
			
			$idpangkat = $_REQUEST['pangkatakhir'];
			
			$query = "select concat(gol,'/',ruang)as nama FROM ref_pangkat WHERE nama='$idpangkat'" ;
			$get=mysql_fetch_array(mysql_query($query));$cek.=$query;
			$content=$get['nama'];											
			break;
		}
			
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
	
	function setPage_OtherScript(){
		$scriptload = 

					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			 "<script src='js/skpd.js' type='text/javascript'></script>
			 <script type='text/javascript' src='js/master/ref_tim_anggaran/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
			 ".
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".
			
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
		//$this->form_idplh ='';
		$this->form_fmST = 0;
	//	$dat_urusan= $_REQUEST['dat_urusan'];
		/*$urusan = $Main->URUSAN;
		if ($urusan=='0'){
			$dt['c'] = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
			$dt['d'] = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
			$dt['e'] = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
			$dt['e1'] = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
			$fm = $this->setForm4($dt);
		}else{*/
			/*$dt['c1'] = $_REQUEST['ref_tandatanganSkpdfmURUSAN'];
			$dt['c'] = $_REQUEST['ref_tandatanganSkpdfmSKPD'];
			$dt['d'] = $_REQUEST['ref_tandatanganSkpdfmUNIT'];
			$dt['e'] = $_REQUEST['ref_tandatanganSkpdfmSUBUNIT'];
			$dt['e1'] = $_REQUEST['ref_tandatanganSkpdfmSEKSI'];*/
			$fm = $this->setForm($dt);
	//	}
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
		$aqry = "SELECT * FROM  ref_tim_anggaran WHERE id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
			$fm = $this->setForm($dt);
		
		
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 150;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU TIM ANGGARAN';
		$nip	 = '';
		
	  }else{
		$this->form_caption = 'EDIT TIM ANGGARAN';			
		$readonly='readonly';
					
	  }
	  
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		$nama=$dt['nama'];
		$nip=$dt['nip'];
		$jabatan=$dt['jabatan'];
				
		$this->form_fields = array(
		
			'urut' => array( 
						'label'=>'No.URUT',
						'labelWidth'=>50, 
						'value'=>"<div style='float:left;'>			
						<input type='text' name='urut' id='urut' value='".$dt['no_urut']."' style='width:40px;' $readonly>
						</div>", 
						 ),
			
			'group' => array( 
						'label'=>'GROUP',
						'labelWidth'=>50, 
						'value'=>cmbArray('group_akhir',$dt['kategori'],$this->arrGroup,'--PILIH--','style=width:150px;'),
						),
			
			'nama' => array( 
						'label'=>'NAMA',
						'labelWidth'=>50, 
						'value'=>"
						<input type='text' name='nama' id='nama' value='".$dt['nama']."' style='width:300px;'>
						", 
						 ),	
			
			'nip' => array( 
						'label'=>'NIP',
						'labelWidth'=>50, 
						'value'=>"
						<input type='text' name='nip' id='nip' onkeypress='return event.charCode >= 48 && event.charCode <= 57'value='".$dt['nip']."' style='width:300px;'>
						", 
						 ),	
						 
			'jabatan' => array( 
						'label'=>'JABATAN',
						'labelWidth'=>50, 
						'value'=>"
						<input type='text' name='jabatan' id='jabatan' value='".$dt['jabatan']."' style='width:300px;'>
						", 
						 ),				 			 			 
													 
			);
		//tombol
		$this->form_menubawah =	
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >".
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
	   <th class='th01' width='100' align='center'>No.URUT</th>
	   <th class='th01' width='200' align='center'>GROUP</th>		
	   <th class='th01' width='500' align='center'>NAMA</th>
	   <th class='th01' width='200' align='center'>NIP</th>
	   <th class='th01' width='500' align='center'>JABATAN</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
		
	if($isi['kategori']==1){
		$group='Tim Anggaran';
	}elseif($isi['kategori']==2){
		$group='Di Teliti Oleh';
	}else{
		$group='Tim Asistensi';
	}	
	
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$isi['no_urut']);
	 $Koloms[] = array('align="left"',$group);	
	 $Koloms[] = array('align="left"',$isi['nama']);
	 $Koloms[] = array('align="left"',$isi['nip']);
	 $Koloms[] = array('align="left"',$isi['jabatan']); 
	 return $Koloms;
	}
	
	function setMenuView(){
		
			}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	$fmFiltStatus2=$_REQUEST['fmFiltStatus2'];
	
	$fmKategori = $_REQUEST['fmKategori'];
	
	
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
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
			);
	$TampilOpt =
			
			"<tr><td>".
			"<div id='skpd_pegawai' ></div>".
			$vOrder=			
			genFilterBar(
				array(
				"Group : "
				.cmbArray('fmFiltStatus2',$fmFiltStatus2,$arrKategori,'-- Group --',''). 
				"&nbsp&nbsp&nbsp&nbsp"	
					.cmbArray('fmPILCARI',$fmPILCARI,$arr,'-- Cari Data --',''). //generate checkbox					
					"&nbsp&nbsp<input type='text' value='".$fmPILCARIvalue."' name='fmPILCARIvalue' id='fmPILCARIvalue'>"
					//<input type='button' id='btTampil' value='Cari' onclick='".$this->Prefix.".refreshList(true)'>"
					
					
					),			
				$this->Prefix.".refreshList(true)");
			"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>";
			
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$arrKondisi = array();	
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		
			switch($_REQUEST['fmFiltStatus2']){
				case '1': $fmFiltStatus2='(kategori =1)'; break;
				case '2': $fmFiltStatus2='(kategori =2)'; break;
				case '3': $fmFiltStatus2='(kategori =3)'; break;
				
			}
			
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			case 'selectNIP': $arrKondisi[] = " nip like '$fmPILCARIvalue%'"; break;
			case 'selectNama': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;	
			case 'selectJabatan': $arrKondisi[] = " jabatan like '%$fmPILCARIvalue%'"; break;	
		}		
		
		if(!empty($_REQUEST['fmFiltStatus2'])) $arrKondisi[]= "$fmFiltStatus2";
				
		if(!empty($_POST['fmKategori']) ) $arrKondisi[] = " kategori_ttd like '%".$_POST['fmKategori']."%'";
				
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
		
			case '1': $arrOrders[] = " nip $Asc1 " ;break;
			case '2': $arrOrders[] = " nama $Asc1 " ;break;
			case '3': $arrOrders[] = " jabatan $Asc1 " ;break;
			
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
$ref_tim_anggaran = new ref_tim_anggaranObj();
?>