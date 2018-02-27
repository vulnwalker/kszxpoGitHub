<?php

class ref_potongan_spmObj  extends DaftarObj2{	
	var $Prefix = 'ref_potongan_spm';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_potongan_spm'; //daftar 
	var $TblName_Hapus = 'ref_potongan_spm';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'REFERNSI POTONGAN SPM';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'Referensi Potongan SPM';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_potongan_spmForm'; 
	var $kdbrg = '';	
			
	function setTitle(){
		return 'REFERENSI POTONGAN SPM';
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
	 $kode_rekening = $_REQUEST['kode_rekening']; 
	 $nm_potongan = $_REQUEST['nm_potongan']; 
	 $id_potongan = $_REQUEST['id_potongan']; 
	 $nama_potongan = $_REQUEST['nama_potongan']; 
	 
	 	
	 if( $err=='' && $kode_rekening =='' ) $err= 'Kode Rekening & Nama Rekening Belum Di Isi !!';
	 if( $err=='' && $nm_potongan =='' ) $err= 'Uraian Potongan Belum Di Isi !!';
	 if( $err=='' && $nama_potongan =='' ) $err= 'Nama Potongan & Persen Belum Di Isi !!';
	 
	 $kode_rekening = explode('.',$kode_rekening);
						 $k=$kode_rekening[0];	
						 $l=$kode_rekening[1];
						 $m=$kode_rekening[2];	
						 $n=$kode_rekening[3];
						 $o=$kode_rekening[4];
						 					 
			if($fmST == 0){
			
				if($err==''){
					$aqry = "INSERT into ref_potongan_spm (k,l,m,n,o,keterangan,refid_potongan) values('$k','$l','$m','$n','$o','$nm_potongan','$id_potongan')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{		
										
				if($err==''){
				$aqry = "UPDATE ref_potongan_spm SET k='$k',l='$l',m='$m',n='$n',o='$o',keterangan='$nm_potongan', refid_potongan='$id_potongan' WHERE Id='".$idplh."'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());	
					}
			
			} //end else
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function setPage_HeaderOther(){
	return 
		"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
			<tr>
				<td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
					
					<A href=\"pages.php?Pg=ref_potongan\" title='Referensi Potongan' >Referensi Potongan</a> | 
					<A href=\"pages.php?Pg=ref_potongan_spm\" title='Referensi Potongan SPM' style='color:blue'>Referensi Potongan SPM</a>   
					&nbsp&nbsp&nbsp	
				</td>
			</tr>
		</table>";
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
			"<script type='text/javascript' src='js/master/ref_potongan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/master/ref_potongan/ref_potongan2.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/master/ref_rekening/ref_rekening3.js' language='JavaScript' ></script>
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
		$aqry = "SELECT * FROM  ref_potongan_spm WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	
	function setForm($dt){	
	 global $SensusTmp ,$Main;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 680;
	 $this->form_height = 100;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU REFERENSI POTONGAN';
	  }else{
		$this->form_caption = 'EDIT REFERENSI POTONGAN';			
		$readonly='readonly';
		$dt['kode_rekening']=$dt['k'].'.'.$dt['l'].'.'.$dt['m'].'.'.$dt['n'].'.'.$dt['o'];
		$namarekening=mysql_fetch_array(mysql_query("select * from ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m='".$dt['m']."' and n='".$dt['n']."' and o='".$dt['o']."'"));
		$namapotongan=mysql_fetch_array(mysql_query("select * from ref_potongan where Id='".$dt['refid_potongan']."'"));
		$cek.="select * from ref_potongan where Id='".$dt['refid_potongan']."'";
	//	$dt['kode_rekening']=$dt['k'].'.'.$dt['l'].'.'.$dt['m'].'.'.$dt['n'].'.'.$dt['o'];
	
	  }
	  
		//items ----------------------
		  $this->form_fields = array(
		  	
			'koderek' => array( 
						'label'=>'KODE REKENING',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='kode_rekening' id='kode_rekening' value='".$dt['kode_rekening']."' placeholder='Kode Rekening' style='width:100px;'readonly>
						&nbsp&nbsp
						<input type='text' name='nm_rekening' id='nm_rekening' value='".$namarekening['nm_rekening']."' placeholder='Nama Rekening' style='width:300px;' readonly>
						&nbsp&nbsp
						<input type='button' value='Cari' onclick ='".$this->Prefix.".cariRekening()' title='Cari Kode Rekening' >
						</div>", 
						 ),	
			
						 
		  	'kodepotongan' => array( 
						'label'=>'KODE POTONGAN',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='hidden' name='id_potongan' id='id_potongan' value='".$namapotongan['Id']."' placeholder='Kode Potongan' style='width:100px;'readonly>
						
						<input type='text' name='nama_potongan' id='nama_potongan' value='".$namapotongan['nama_potongan']."' placeholder='Nama Potongan' style='width:340px;' readonly>
						&nbsp&nbsp
						<input type='text' name='persen' id='persen' value='".$namapotongan['persen']."' placeholder='Persen'  style='width:50px ;align='right';' readonly>%
						&nbsp&nbsp
						<input type='button' value='Cari' onclick ='".$this->Prefix.".cariPotongan()' title='Cari Kode Rekening' >
						</div>", 
						 ),	
			
			'ket' => array( 
						'label'=>'Keterangan',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='nm_potongan' id='nm_potongan' value='".$dt['keterangan']."' placeholder='Keterangan' style='width:500px;'>
						</div>", 
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
	   <th class='th01' width='200' >Rekening</th>
	   <th class='th01' width='200' >Nama Rekening</th>
	   <th class='th01' width='200' >Potongan</th>
	   <th class='th01' width='200' >Persen(%)</th>
	   <th class='th01' width='200' >Keterangan</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 $nama_potongan=mysql_fetch_array(mysql_query("select * from ref_potongan where Id='".$isi['refid_potongan']."'"));	 
	 $nama_rek=mysql_fetch_array(mysql_query("select * from ref_rekening where k='".$isi['k']."' and l='".$isi['l']."' and m='".$isi['m']."' and n='".$isi['n']."' and o='".$isi['o']."'"));	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	  $Koloms[] = array('align="left"',$isi['k'].'.'.$isi['l'].'.'.$isi['m'].'.'.$isi['n'].'.'.$isi['o']);
	  $Koloms[] = array('align="left"',$nama_rek['nm_rekening']);
	  $Koloms[] = array('align="left"',$nama_potongan['nama_potongan']);
	  $Koloms[] = array('align="right"',$nama_potongan['persen'].' '.'%');
	  $Koloms[] = array('align="left"',$isi['keterangan']);
	 return $Koloms;
	}
		
	function genDaftarOpsi(){
	 global $Ref, $Main;
	
	/*$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];*/
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	 $arrOrder = array(
	  	         array('1','Nama Rekening'),
			     array('2','Nama Saldo'),
			    
					);
	$arr = array(
			//array('selectAll','Semua'),	
			array('selectKode','Nama Rekening'),	
			array('selectNama','Saldo'),		
			);
	/*$TampilOpt =
			//<table width=\"100%\" class=\"adminform\">
			"<table width=\"100%\" class=\"adminform\">	<tr>		
			</tr>
			<!--<tr><td>
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>			-->
			</table>".
			"<tr><td>".
			"<div id='skpd_pegawai' ></div>".
			$vOrder=			
			genFilterBar(
				array(							
					cmbArray('fmPILCARI',$fmPILCARI,$arr,'-- Cari Data --',''). //generate checkbox					
					"&nbsp&nbsp<input type='text' value='".$fmPILCARIvalue."' name='fmPILCARIvalue' id='fmPILCARIvalue'>&nbsp&nbsp"
					//<input type='button' id='btTampil' value='Cari' onclick='".$this->Prefix.".refreshList(true)'>"
					
					.cmbArray('fmORDER1',$fmORDER1,$arrOrder,'--Urutkan--','').
					"<input $fmDESC1 type='checkbox' id='fmDESC1' name='fmDESC1' value='checked'>&nbspmenurun."
					),			
				$this->Prefix.".refreshList(true)");
			"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>";*/
			
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$arrKondisi = array();	
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		
		//Cari 
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			
			case 'selectNama': $arrKondisi[] = " nama_rek like '%$fmPILCARIvalue%'"; break;	
			case 'selectRuang': $arrKondisi[] = " saldo like '%$fmPILCARIvalue%'"; break;	
								 	
		}	
		
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " nama_rek $Asc1 " ;break;
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
$ref_potongan_spm = new ref_potongan_spmObj();
?>