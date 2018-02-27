<?php

class ref_sp_potonganObj  extends DaftarObj2{	
	var $Prefix = 'ref_sp_potongan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_sp_potongan'; //bonus
	var $TblName_Hapus = 'ref_sp_potongan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('k','l','m','n','o');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi SP Potongan';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='Pangkat.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'ref_sp_potongan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_sp_potonganForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
			
	function setTitle(){
		if ($_REQUEST['hal']=='1'){
			$jns='Pajak';
			"<A href=\"pages.php?Pg=ref_sp_potongan&hal=1\" title='Potongan Pajak'style='color:blue'>Potongan Pajak</a>"; 
		}elseif($_REQUEST['hal']=='2'){
			$jns='Retensi & Denda keterlambatan ';
		}
		return 'Referensi Potongan '.$jns;
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
	 $kode_rekening = $_REQUEST['kode_rekening']; 
	 $nm_rekening = $_REQUEST['nm_rekening']; 
	 $jns = $_REQUEST['jns'];
	 $persen = $_REQUEST['persen'];
	 	 
	 if( $err=='' && $kode_rekening =='' ) $err= 'Kode Rekening Belum di Isi !!';
	 if( $err=='' && $persen =='' ) $err= 'Nilai Persen Belum Di Isi !!';
	 
	 
	 $kode_rekening = explode('.',$kode_rekening);
						 $k=$kode_rekening[0];	
						 $l=$kode_rekening[1];
						 $m=$kode_rekening[2];	
						 $n=$kode_rekening[3];
						 $o=$kode_rekening[4];
	 

			if($fmST == 0){
				if($err==''){
					$aqry = "INSERT into ref_sp_potongan (k,l,m,n,o,jns,nama_rekening,persen) values('$k','$l','$m','$n','$o','$jns','$nm_rekening','$persen')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{
				if($err==''){
					$aqry = "UPDATE ref_sp_potongan set k='$k',l='$l',m='$m',n='$n',o='$o',nama_rekening='$nm_rekening',persen='$persen' where concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry; 
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
		//for($i = 0; $i<count($ids); $i++)	{
		 $cbid = $_REQUEST[$this->Prefix.'_cb'];
		 $this->form_idplh = $cbid[0];
			if($err=='' ){
			
			for($i = 0; $i<count($ids); $i++){
		$idplh1 = explode(" ",$ids[$i]);
		$data_k= $idplh1[0];
	 	$data_l= $idplh1[1];
		$data_m= $idplh1[2];
		$data_n= $idplh1[3];
		$data_o= $idplh1[4];
		if($err=='' ){
					$qy = "DELETE FROM ref_sp_potongan WHERE k='$data_k' and l='$data_l' and m='$data_m'  and  n='$data_n' and o='$data_o' and  concat (k,' ',l,' ',m,' ',n,' ',o) ='".$ids[$i]."' ";$cek.=$qy;
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
		"<script src='js/skpd.js' type='text/javascript'></script>
		<script type='text/javascript' src='js/master/ref_rekening/ref_rekening3.js' language='JavaScript' ></script>
		<script type='text/javascript' src='js/pencarian/cariRekening.js' language='JavaScript' ></script>.
		<script type='text/javascript' src='js/master/ref_sp_potongan/ref_sp_potongan.js' language='JavaScript' ></script>".
			$scriptload;
	}
	
	//form ==================================
	function setFormBaru(){
		$dt=array();
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		
		$fm = $this->setForm($dt);	
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'].$err, 'content'=>$fm['content']);
	}
   
  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$k=$kode[0];
		$l=$kode[1];
		$m=$kode[2];
		$n=$kode[3];
		$o=$kode[4];
		$this->form_fmST = 1;					
		//get data 
		$aqry = "SELECT * FROM  ref_sp_potongan WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	s 	
	 $form_name = $this->Prefix.'_form';
	 
				
	 $this->form_width = 750;
	 $this->form_height = 100;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'FORM BARU POTONGAN';
	 	$jns = $_REQUEST['hal']; 
	 
		$cmbRo = '';
	  }else{
		$this->form_caption = 'FORM EDIT POTONGAN';	
		$dt['kode_rekening']=$dt['k'].'.'.$dt['l'].'.'.$dt['m'].'.'.$dt['n'].'.'.$dt['o'];
	  }
	    //ambil data trefditeruskan
		
			
	 //items ----------------------
	  $this->form_fields = array(
	  	  	
			'kode0' => array( 
						'label'=>'KODE REKENING',
						'labelWidth'=>110, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='kode_rekening' id='kode_rekening' value='".$dt['kode_rekening']."' placeholder='Kode' size='10px'readonly>&nbsp
						<input type='text' name='nm_rekening' id='nm_rekening' value='".$dt['nama_rekening']."' placeholder='Nama Rekening' size='70px'readonly>&nbsp
						<input type='button' value='Cari' onclick ='".$this->Prefix.".CariRekening()' title='Cari Rekening' >
						</div>", 
						 ),	
						 
			'persen' => array( 
						'label'=>'PERSEN(%)',
						'labelWidth'=>100, 
						'value'=>"<input type='number' name='persen' id='persen' value='".$dt['persen']."'style='width:50px;' onkeypress='return isNumberKey(event)' onChange=\"".$this->Prefix.".pers()\">%",
						 )	,
						 			 
									
			);
		//tombol
		$this->form_menubawah =
			"<input type='hidden' name='jns' id='jns' value='".$jns."'>".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >  &nbsp  ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	
	
	function setPage_HeaderOther(){
	$setnya = '';
	$setnya1 = '';
	if($_REQUEST['hal'] == '1')$setnya = "style='color:blue' ";
	if($_REQUEST['hal'] == '2')$setnya1 = "style='color:blue' ";
	
	if(!isset($_REQUEST['hal']))$setnya = "style='color:blue' ";
	return 
		"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
			<tr>
				<td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
					
					<A href=\"pages.php?Pg=ref_sp_potongan&hal=1\" title='Potongan Pajak' $setnya >Potongan Pajak</a> | 
					<A href=\"pages.php?Pg=ref_sp_potongan&hal=2\" title='Retensi & Denda Keterlambatan' $setnya1 >Retensi & Denda Keterlambatan</a>  
					&nbsp&nbsp&nbsp	
				</td>
			</tr>
		</table>";
	}
			
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='10' >No.</th>
  	   $Checkbox		
	   <th class='th01' width='200'>Kode Rekening</th>
	   <th class='th01' width='500'>Nama Rekening</th>
	   <th class='th01' width='100'>Persen(%)</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	 
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 
	// $skpd=mysql_fetch_array(mysql_query("select c1,c,d,nm_skpd from ref_skpd where c1='$c1' and c='$c' and d='$d'"));
	
	 $Koloms[] = array('align="left"',$isi['k'].'.'.$isi['l'].'.'.$isi['m'].'.'.$isi['n'].'.'.$isi['o']);
	 $Koloms[] = array('align="left"',$isi['nama_rekening']);
	 $Koloms[] = array('align="right"',$isi['persen'].' '.'%');
	
	 return $Koloms;
	}
	
		
	function setMenuView(){
		
			}
	
	function genDaftarOpsi(){

	global $Ref, $Main;
	 
	 $arrOrder = array(
	  	          	array('1','Jenis Jabatan'),		
					array('2','Nama Jabatan'),	
					array('3','Jumlah'),
					array('4','Status'),	
					);	
	 //data order ------------------------------
	
	/*$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	$baris = $_REQUEST['baris'];*/
	if ($baris == ''){
		$baris = "25";		
	}
	$TampilOpt = 
	"<div class='FilterBar' style='margin-top:10px;'><table style='width:100%'>".
			//CmbUrusanBidangSkpd('ref_nm_pejabat_sp').
"</table></div>".
			"</div>";
			
		return array('TampilOpt'=>$TampilOpt);
	}		
		
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
					
		$arrKondisi = array();		
		$hala = $_REQUEST['hal'];
		$arrKondisi[] = "jns=$hala";
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn
		$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];			
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
		
		if(!empty($fmFiltTglBtw_tgl1)) $arrKondisi[]= " tgl_daftar>='$fmFiltTglBtw_tgl1'";
		if(!empty($fmFiltTglBtw_tgl2)) $arrKondisi[]= " tgl_daftar<='$fmFiltTglBtw_tgl2'";	
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
		
				
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
	
	function pageShow(){
		global $app, $Main, $DataOption; 
		
		$navatas_ = $this->setNavAtas();
		$navatas = $navatas_==''? // '0': '20';
			'':
			"<tr><td height='20'>".
					$navatas_.
			"</td></tr>";
		$form1 = $this->withform? "<form name='$this->FormName' id='$this->FormName' method='post' action=''>" : '';
		$form2 = $this->withform? "</form >": '';
		
		$hal='1';
		if (isset($_REQUEST['hal'])) if ($_REQUEST['hal']!='') $hal=$_REQUEST['hal']; 
				
		return
							
		"<html>".
			$this->genHTMLHead().
			"<body >".
										
			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0' width='100%' height='100%' >".
				//header page -------------------		
				"<tr height='34'><td>".					
					
					$this->setPage_Header().
					"<div id='header' ></div>".
				"</td></tr>".	
				$navatas.			
				
				"<tr height='*' valign='top'> <td >".
					
					$this->setPage_HeaderOther().
					"<div align='center' class='centermain' >".
					"<div class='main' >".
					$form1.
					"<input type='hidden' name='hal' value='".$hal."' />".
					
											
						$this->setPage_Content().
						
						
					$form2.//"</form>".
					"</div></div>".
				"</td></tr>".
				//$OtherContentPage.				
				//Footer ------------------------
				"<tr><td height='29' >".	
					//$app->genPageFoot(FALSE).
					$Main->CopyRight.							
				"</td></tr>".
				$OtherFooterPage.
			"</table>".
			
			"</body>
		</html>"; 
	}	
	
}
$ref_sp_potongan = new ref_sp_potonganObj();
?>