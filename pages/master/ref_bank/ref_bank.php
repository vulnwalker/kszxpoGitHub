<?php

class ref_bankObj  extends DaftarObj2{	
	var $Prefix = 'ref_bank';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_bank'; //daftar 
	var $TblName_Hapus = 'ref_bank';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'REFERNSI BANK';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'Referensi Bank';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_bankForm'; 
	var $kdbrg = '';	
			
	function setTitle(){
		return 'REFERENSI BANK';
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
	 $kode = $_REQUEST['kode']; 
	 $nama_bank = $_REQUEST['nama_bank']; 
	 $no_rekening = $_REQUEST['no_rekening'];
	 $kode_rekening = $_REQUEST['kode_rekening']; 
	 $nm_rekening = $_REQUEST['nm_rekening'];
	 $saldo = $_REQUEST['saldo'];
	
	 $oldy=mysql_fetch_array(mysql_query("select count(*) as cnt from ref_bank where kode='$kode'"));
	 $oldy2=mysql_fetch_array(mysql_query("select count(*) as cnt from ref_bank where no_rekening='$no_rekening'"));
		
	 if( $err=='' && $kode =='' ) $err= 'Kode Bank Rekening Belum Di Isi !!';
	 if( $err=='' && $nama_bank =='' ) $err= 'Nama Bank Belum Di Isi !!';
	 if( $err=='' && $no_rekening =='' ) $err= 'No Rekening Belum Di Isi !!';
	 if( $err=='' && $kode_rekening =='' ) $err= 'Kode Rekening & Nama Rekening Belum Di Isi !!';
	 if( $err=='' && $saldo =='' ) $err= 'Saldo Belum Di Isi !!';
	  
	  $kode_rekening = explode('.',$kode_rekening);
						 $k=$kode_rekening[0];	
						 $l=$kode_rekening[1];
						 $m=$kode_rekening[2];	
						 $n=$kode_rekening[3];
						 $o=$kode_rekening[4];
						 
			if($fmST == 0){
			
			if($err=='' && $oldy['cnt']>0) $err="Kode Referensi Bank '$kode' Sudah Ada";
			if($err=='' && $oldy2['cnt']>0) $err="No Rekening '$no_rekening' Sudah Ada";
			
				if($err==''){
					$aqry = "INSERT into ref_bank (kode,nm_bank,no_rekening,k,l,m,n,o,saldo) values('$kode','$nama_bank','$no_rekening','$k','$l','$m','$n','$o','$saldo')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{		
			
				$old = mysql_fetch_array(mysql_query("select * from ref_bank where id='$idplh'"));													if($no_rekening!=$old['no_rekening'] ){
							$get = mysql_fetch_array(mysql_query(
								"select count(*) as cnt from ref_bank where no_rekening='$no_rekening' "
							));
							if($get['cnt']>0 ) $err="No Rekening '$no_rekening' Sudah Ada!";
						}
							
				if($err==''){
				$aqry = "UPDATE ref_bank SET kode='$kode', nm_bank='$nama_bank' ,no_rekening='$no_rekening' ,k='$k' ,l='$l' ,m='$m',n='$n',o='$o',saldo='$saldo' WHERE Id='".$idplh."'";	$cek .= $aqry;
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
			"<script type='text/javascript' src='js/master/ref_bank/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
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
		$aqry = "SELECT * FROM  ref_bank WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	
	function setForm($dt){	
	 global $SensusTmp ,$Main;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 780;
	 $this->form_height = 150;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU REFERENSI BANK';
	  }else{
		$this->form_caption = 'EDIT REFERENSI BANK';			
		$readonly='readonly';
		$dt['kode_rekening']=$dt['k'].'.'.$dt['l'].'.'.$dt['m'].'.'.$dt['n'].'.'.$dt['o'];	
		$nm_rekening=mysql_fetch_array(mysql_query("select nm_rekening from ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m='".$dt['m']."' and n='".$dt['n']."' and o='".$dt['o']."'"));		
	  /*	$d1="select * from ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m='".$dt['m']."' and n='".$dt['n']."' and o='".$dt['o']."'";
		$nm_rekening=msql_fetch_array()*/
	  $cek.="select nm_rekening from ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m='".$dt['m']."' and n='".$dt['n']."' and o='".$dt['o']."'";
	  }
	  
		//items ----------------------
		  $this->form_fields = array(
		  
		  	'kode' => array( 
						'label'=>'KODE',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='kode' id='kode' value='".$dt['kode']."' placeholder='Kode' style='width:100px;' $readonly>
						</div>", 
						 ),	
						 
			'namaBank' => array( 
						'label'=>'NAMA BANK',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='nama_bank' id='nama_bank' value='".$dt['nm_bank']."' placeholder='Nama Bank' style='width:250px;'>
						</div>", 
						 ),	
						 
			'norek' => array( 
						'label'=>'NO REKENING',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='no_rekening' id='no_rekening' value='".$dt['no_rekening']."' placeholder='No Rekening' style='width:100px;'>
						</div>", 
						 ),				 			 
			
			'koderek' => array( 
						'label'=>'KODE REKENING',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='kode_rekening' id='kode_rekening' value='".$dt['kode_rekening']."' placeholder='Kode Rekening' style='width:100px;'readonly>
						&nbsp&nbsp
						<input type='text' name='nm_rekening' id='nm_rekening' value='".$nm_rekening['nm_rekening']."' placeholder='Nama Rekening' style='width:450px;' readonly>
						&nbsp&nbsp
						<input type='button' value='Cari' onclick ='".$this->Prefix.".cariRekening()' title='Cari Kode Rekening' >
						</div>", 
						 ),	
						 
			'saldo' => array( 
						'label'=>'SALDO (Rp)',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='saldo' align='right' value='".$dt['saldo']."' id='saldo'   style='width:150px;text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`rp_saldo`).innerHTML = ref_bank.formatCurrency(this.value);' /> Rp <span id='rp_saldo'>".number_format($dt['saldo'],2,",",".")."</span>"
						
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
	   <th class='th01' width='100' >Kode</th>
	   <th class='th01' width='200' >Nama Bank</th>
	   <th class='th01' width='200' >No Rekening Bank</th>
	   <th class='th01' width='200' >Kode Rekening</th>
	   <th class='th01' width='450' >Nama Rekening</th>
	   <th class='th01' width='200' align='center'>Saldo</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	  $nama_rek=mysql_fetch_array(mysql_query("select * from ref_rekening where k='".$isi['k']."' and l='".$isi['l']."' and m='".$isi['m']."' and n='".$isi['n']."' and o='".$isi['o']."'"));	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	  $Koloms[] = array('align="left"',$isi['kode']);
	  $Koloms[] = array('align="left"',$isi['nm_bank']);
	  $Koloms[] = array('align="left"',$isi['no_rekening']);
	  $Koloms[] = array('align="left"',$isi['k'].'.'.$isi['l'].'.'.$isi['m'].'.'.$isi['n'].'.'.$isi['o']);
	  $Koloms[] = array('align="left"',$nama_rek['nm_rekening']); 
	  $Koloms[] = array('align="right"',number_format($isi['saldo'],2, ',', '.'));
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
$ref_bank = new ref_bankObj();
?>