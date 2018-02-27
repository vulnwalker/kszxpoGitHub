<?php

class setting_saldo_awal_keuObj  extends DaftarObj2{	
	var $Prefix = 'setting_saldo_awal_keu';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
//	var $TblName = 'ref_tandatangan'; //daftar
	var $TblName = 'setting_saldo_awal_keu'; //daftar
	var $TblName_Hapus = 'setting_saldo_awal_keu';
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
//	var $Cetak_Judul = 'setting_saldo_awal_keu';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'setting_saldo_awal_keuForm'; 
	var $kdbrg = '';	
	
	function setTitle(){
		return 'SETTING SALDO AWAL KEUANGAN';
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
     $tgl_saldo= $_REQUEST['tgl_saldo'];
     $tgl_saldo_tahun= $_REQUEST['tgl_saldo_tahun'];
     $tgl_anggaran= $_REQUEST['tgl_anggaran'];
     $tgl_anggaran_tahun= $_REQUEST['tgl_anggaran_tahun'];
     
	 if( $err=='' && $tgl_saldo =='' ) $err= 'Tanggal Saldo Awal Keuangan Belum Di Isi !!';
	 if( $err=='' && $tgl_anggaran =='' ) $err= 'Tanggal Anggaran Belum Di Isi !!';
	 
	 $tgl_saldo = explode("-",$tgl_saldo);
	 $tgl_saldo2 = $tgl_saldo_tahun.'-'.$tgl_saldo[1].'-'.$tgl_saldo[0];
	 $tgl_anggaran = explode("-",$tgl_anggaran);
	 $tgl_anggaran2 = $tgl_anggaran_tahun.'-'.$tgl_anggaran[1].'-'.$tgl_anggaran[0];
	
			if($fmST == 0){
				if($err==''){
				$aqry = "INSERT into setting_saldo_awal_keu(tgl_saldo_awal,tgl_anggaran) values('$tgl_saldo2','$tgl_anggaran2')";	$cek .= $aqry;
				$qry = mysql_query($aqry);
				}
			}else{
							
			if($err==''){
				$aqry = "UPDATE setting_saldo_awal_keu SET tgl_saldo_awal='$nm_jurnal',st_pilih='$st_jurnal' WHERE Id='".$idplh."'";	$cek .= $aqry;
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
			"<script type='text/javascript' src='js/saldo_awal_keuangan/setting_saldo_awal_keu.js' language='JavaScript' ></script>".
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
		$aqry = "SELECT * FROM  setting_saldo_awal_keu WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $Main, $HTTP_COOKIE_VARS;
	 $coThnAnggaran = $_COOKIE['coThnAnggaran'];
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 300;
	 $this->form_height = 70;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU SETTING SALDO AWAL';
	  }else{
		$this->form_caption = 'EDIT SETTING SALDO AWAL';			
		
		$tgl_saldo=$dt['tgl_saldo_awal'];
		$tgl_saldo1 = explode("-",$tgl_saldo);
		$tgl_saldo_thn = $tgl_saldo1[0];
		$tgl_saldo2 = $tgl_saldo1[2].'-'.$tgl_saldo1[1];
		
		$tgl_anggaran=$dt['tgl_anggaran'];
		$tgl_anggaran1 = explode("-",$tgl_anggaran);
		$tgl_anggaran_thn = $tgl_anggaran1[0];
		$tgl_anggaran2 = $tgl_anggaran1[2].'-'.$tgl_anggaran1[1];
			
	  }
	  $Id = $_REQUEST['Id'];
	 
		$this->form_fields = array(
		
			'tgl_saldo' => array( 
						'label'=>'TANGGAL SALDO AWAL',
						'labelWidth'=>150, 
						'value'=>"
						<input type='text' name='tgl_saldo' id='tgl_saldo' class='datepicker2' value='$tgl_saldo2' style='width:40px;'>
						<input type='text' id='tgl_saldo_tahun' name='tgl_saldo_tahun' value='$coThnAnggaran' size=2px readonly>
						", 
						 ),	
			'tgl_anggaran' => array( 
						'label'=>'TANGGAL ANGGARAN',
						'labelWidth'=>150, 
						'value'=>"
						<input type='text' name='tgl_anggaran' id='tgl_anggaran' class='datepicker2' value='$tgl_anggaran2' style='width:40px;'>
						<input type='text' id='tgl_anggaran_tahun' name='tgl_anggaran_tahun' value='$coThnAnggaran' size=2px readonly>
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
	   <th class='th01' width='500' align='center'>TANGGAL SALDO AWAL</th>
	   <th class='th01' width='500' align='center'>TANGGAL ANGGARAN</th>		
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	
	 $tgl_saldo = explode("-",$isi['tgl_saldo_awal']);
	 $tgl_saldo_awal = $tgl_saldo[2]."-".$tgl_saldo[1]."-".$tgl_saldo[0];
	 $tgl_anggaran = explode("-",$isi['tgl_anggaran']);
	 $tgl_anggaran2 = $tgl_anggaran[2]."-".$tgl_anggaran[1]."-".$tgl_anggaran[0];
	
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$tgl_saldo_awal);
	 $Koloms[] = array('align="left"',$tgl_anggaran2);	
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
$setting_saldo_awal_keu = new setting_saldo_awal_keuObj();
?>