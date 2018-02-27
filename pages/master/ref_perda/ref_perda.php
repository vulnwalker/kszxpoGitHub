<?php

class ref_perdaObj  extends DaftarObj2{	
	var $Prefix = 'ref_perda';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
//	var $TblName = 'ref_tandatangan'; //daftar
	var $TblName = 'ref_perda'; //daftar
	var $TblName_Hapus = 'ref_perda';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Peraturan Daerah';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='ref_tim_anggaran.xls';
	var $Cetak_Judul = 'Referensi Peraturan Daerah';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_perdaForm'; 
	var $kdbrg = '';	
	
	var $arrGroup = array( 
		array('1','1.Tim Anggaran'),
		array('2','2.Di Teliti Oleh'),
		array('3','3.Tim Asistensi')
		);
	
			
	function setTitle(){
		return 'REFERENSI PERATURAN DAERAH';
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
     $urut= $_REQUEST['urut'];
     $kategori= $_REQUEST['fmKategori'];
     $id_kategori= $_REQUEST['id_kategori'];
	 $no_peraturan= $_REQUEST['no_peraturan'];
	 $tgl_peraturan= $_REQUEST['tgl_peraturan'];
	 $Urainan= $_REQUEST['Urainan'];
	
	$tgl_peraturan = explode("-",$tgl_peraturan);
	$tgl_peraturan2 = $tgl_peraturan[2].'-'.$tgl_peraturan[1].'-'.$tgl_peraturan[0];
	
	$dat=mysql_fetch_array(mysql_query("select * from ref_kategori_perda where kategori_perda='$kategori'"));
	
	$oldy=mysql_fetch_array(mysql_query("select count(*) as cnt from ref_perda where no_urut='$urut'"));
	$oldy2=mysql_fetch_array(mysql_query("select count(*) as cnt from ref_tim_anggaran where no_urut='$urut'"));
	 if( $err=='' && $urut =='' ) $err= 'No Urut Belum Di Isi !!';
	 if( $err=='' && $kategori =='' ) $err= 'Kategori Belum Di Pilih !!';
	 if( $err=='' && $no_peraturan =='' ) $err= 'No Peraturan Belum Di Isi !!';
	 if( $err=='' && $tgl_peraturan =='' ) $err= 'Tanggal Peraturan Belum Di Isi !!';
	// if( $err=='' && $jabatan =='' ) $err= 'Jabatan Belum Di Isi !!';
	
			if($fmST == 0){
			
			if($err=='' && $oldy['cnt']>0) $err="No Urut '$urut' Sudah Ada";
			
				if($err==''){
			
				$aqry = "INSERT into ref_perda (no_urut,refid_kategori,no_peraturan,tgl_peraturan,uraian) values('$urut','".$dat['Id']."','$no_peraturan','$tgl_peraturan2','$Urainan')";	$cek .= $aqry;	
				$qry = mysql_query($aqry);
				}
			}else{
				$old = mysql_fetch_array(mysql_query("select * from ref_perda where Id='$idplh'"));								if($urut!=$old['no_urut'] ){
							$get = mysql_fetch_array(mysql_query(
								"select count(*) as cnt from ref_perda where no_urut='$urut' "
							));
							if($get['cnt']>0 ) $err="No Urut '$urut' Sudah Ada";
						}
			
			if($err==''){
				$aqry = "UPDATE ref_perda SET no_urut='$urut',refid_kategori='".$dat['Id']."', no_peraturan='$no_peraturan',tgl_peraturan='$tgl_peraturan2', uraian='$Urainan' WHERE Id='".$idplh."'";	$cek .= $aqry;
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
		
		case 'HapusKategori':{	
				$fm= $this->HapusKategori($pil);
				$err= $fm['err']; 
				$cek = $fm['cek'];
				$content = $fm['content'];
		break;
		}
		
		case 'BaruKategori':{				
				$fm = $this->setFormBaruKategori();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}
			
		case 'EditKategori':{				
				$fm = $this->setFormEditKategori();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}	
		
		case 'simpanKategori':{
				$get= $this->simpanKategori();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    }
		
		case 'refreshKategori':{
				$get= $this->refreshKategori();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
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
	
	function HapusKategori($ids){ //validasi hapus tbl_sppd
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kat = $_REQUEST['fmKategori'];
		$id_kategori = $_REQUEST['id_kategori'];
		if ($err ==''){
		$dt1=mysql_fetch_array(mysql_query("select * from ref_kategori_perda where kategori_perda='$kat'"));
		$hapus_kategori1=mysql_query("select * from ref_perda where refid_kategori='".$dt1['Id']."'"); 
	//	$hapus_kategori=mysql_query("select * from ref_kategori_perda where refid_kategori='".$hapus_kategori1['Id']."'"); 
		
		if($err==''){
			if (mysql_num_rows($hapus_kategori1)>0)$err='Nama Kategori Tidak bisa di Hapus sudah ada di Refensi Peraturan Daerah !!';
		}
		
		if($err=='' ){
					$qy = "DELETE FROM ref_kategori_perda WHERE Id='".$dt1['Id']."' ";$cek.=$qy;
					$qry = mysql_query($qy);
					$content = cmbQuery('fmKategori',$dt['c1'],$queryKategori,'style="width:300px;"onchange="'.$this->Prefix.'.pilihUrusan()"','-------- Pilih Kategori ------------')."
						<input type='hidden' name='id_kategori' id='id_kategori' value='".$queryKategori['Id']."' >
						"."&nbsp&nbsp&nbsp"."	
						<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKategori()' title='Baru' >
						"."&nbsp&nbsp&nbsp"."
						<input type='button' value='Edit' onclick ='".$this->Prefix.".EditKategori()' title='Edit' >
						"."&nbsp&nbsp&nbsp"."
						<input type='button' value='Hapus' onclick ='".$this->Prefix.".HapusKategori()' title='Hapus' >";
			}		
	
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}	  
	
	function refreshKategori(){
	global $Main;
	 
		$Kategori2 = $_REQUEST['fmKategori'];	 
		$Id = $_REQUEST['Id'];	 
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$Kategori_new= $_REQUEST['id_KategoriBaru'];
	 	
		$queryKategori="SELECT kategori_perda,kategori_perda FROM ref_kategori_perda" ;$cek.=$queryKategori;
		$content->Kategori=cmbQuery('fmKategori',$Kategori_new,$queryKategori,'style="width:300px;"onchange="'.$this->Prefix.'.pilihUrusan()"','-------- Pilih Kategori ------------')."
						<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKategori()' title='Baru' >
						"."&nbsp&nbsp&nbsp"."
						<input type='button' value='Edit' onclick ='".$this->Prefix.".EditKategori()' title='Edit' >
						"."&nbsp&nbsp&nbsp"."
						<input type='button' value='Hapus' onclick ='".$this->Prefix.".HapusKategori()' title='Hapus' >";
	
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	
	function simpanKategori(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$Id= $_REQUEST['Id'];
		$Kategori= $_REQUEST['kategori'];
	//	$barcode= $_REQUEST['barcode'];
		if( $err=='' && $Kategori =='' ) $err= 'Nama Kategori Belum Di Isi !!';
	
		if($fmST == 0){
			if($err==''){
				$aqry = "INSERT into ref_kategori_perda (kategori_perda) values('$Kategori')";	
				$cek .= $aqry;	
				$qry = mysql_query($aqry);
				$content=$Kategori;	
				}
			}else{
				$aqry = "UPDATE ref_kategori_perda set kategori_perda='$Kategori' where Id='".$Id."'";$cek .= $aqry;
			$qry = mysql_query($aqry);
			$content=$Kategori;
			}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }		
	
	function setFormBaruKategori(){
		$dt=array();
		$this->form_fmST = 0;
		$fm = $this->BaruKategori($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormEditKategori(){
		$dt=array();
		$this->form_fmST = 1;
		$fm = $this->BaruKategori($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);	
	}
	
	function BaruKategori($dt){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKA';				
	 $this->form_width = 650;
	 $this->form_height = 50;
	
	 $kat = $_REQUEST['fmKategori'];
	 
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU KODE KATEGORI PERATURAN DAERAH';
	  }else{
	  	$this->form_caption = 'EDIT KODE KATEGORI PERATURAN DAERAH';
		$dat_kategeori=mysql_fetch_array(mysql_query("select * from ref_kategori_perda where kategori_perda='$kat'"));
		$cek.="select * from ref_kategori_penda where kategori_penda='$c'";
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		$aqry2="SELECT MAX(Id) AS maxno FROM ref_kategori_perda";
		$cek.=$aqry2;
		$get=mysql_fetch_array(mysql_query($aqry2));
		$newc=$get['maxno'] + 1;
	 //items ----------------------
	  $this->form_fields = array(
							 			
			'kategori' => array( 
						'label'=>'KATEGORI',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='kategori' id='kategori' value='".$dat_kategeori['kategori_perda']."' placeholder='Nama Kategori Peraturan Daerah' style='width:480px;'>
						<input type='hidden' name='Id' id='Id' value='".$dat_kategeori['Id']."' placeholder='Nama Kategori Peraturan Daerah' style='width:480px;'>
						</div>", 
						 ),		
			
						 
			'Add' => array( 
						'label'=>'',
						'value'=>"<div id='Add'></div>",
						'type'=>'merge'
					 )			
			);
		//tombol
		$this->form_menubawah =
		"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanKategori()' title='Simpan' >"."&nbsp&nbsp".
		"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close1()' >";
		$form = $this->genFormKategori();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function genFormKategori($withForm=TRUE, $params=NULL, $center=TRUE){	
		$form_name = $this->Prefix.'_KAform';	
		
		if($withForm){
			$form= "<form name='$form_name' id='$form_name' method='post' action=''>".
				createDialog(
					$form_name.'_div', 
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
					$this->form_menu_bawah_height,'',$params).
				"</form>";
				
		}else{
			$form= 
				createDialog(
					$form_name.'_div', 
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
					$this->form_menu_bawah_height,'',$params
				);
		}
		
		if($center){
			$form = centerPage( $form );	
		}
		return $form;
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
			"<script type='text/javascript' src='js/master/ref_perda/ref_perda.js' language='JavaScript' ></script>".
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
		$aqry = "SELECT * FROM  ref_perda WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 680;
	 $this->form_height = 150;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU PERATURAN DAERAH';
		$nip	 = '';
		
	  }else{
		$this->form_caption = 'EDIT PERATURAN DAERAH';			
		$readonly='readonly';
		$kategori=mysql_fetch_array(mysql_query("select * from ref_kategori_perda where Id='".$dt['refid_kategori']."'"));
			$cek.="select * from ref_kategori_perda where Id='".$dt['refid_kategori']."'";		
	  }
	  $Id = $_REQUEST['Id'];
	  $queryKategori="SELECT kategori_perda,kategori_perda FROM ref_kategori_perda"; $cek.=$queryKategori;
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		$nama=$dt['nama'];
		$nip=$dt['nip'];
		$jabatan=$dt['jabatan'];		
		$this->form_fields = array(
		
			'urut' => array( 
						'label'=>'No.URUT',
						'labelWidth'=>170, 
						'value'=>"<div style='float:left;'>			
						<input type='text' name='urut' id='urut' value='".$dt['no_urut']."' style='width:40px;' $readonly>
						</div>", 
						 ),
			
			'kategori' => array(
								'label'=>'KATEGORI',
								'name'=>'ppn',
								'label-width'=>'100px;',
								'value'=>"<div id='cont_kategori'>
								".cmbQuery('fmKategori',$kategori['kategori_perda'],$queryKategori,'style="width:300px;"onchange="'.$this->Prefix.'.pilihUrusan()"','-------- Pilih Kategori ------------')."
						"."&nbsp&nbsp"."	
						<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKategori()' title='Baru' >
						"."&nbsp&nbsp"."
						<input type='button' value='Edit' onclick ='".$this->Prefix.".EditKategori()' title='Edit' >
						"."&nbsp&nbsp"."
						<input type='button' value='Hapus' onclick ='".$this->Prefix.".HapusKategori()' title='Hapus' >
						</div>" ,
								
							),
			'no_peraturan' => array( 
						'label'=>'No, PERATURAN',
						'labelWidth'=>50, 
						'value'=>"
						<input type='text' name='no_peraturan' id='no_peraturan' value='".$dt['no_peraturan']."' style='width:300px;'>
						", 
						 ),	
			
			'tgl_peraturan' =>array(
							'label'=>'TANGGAL PENGATURAN',
							'name'=>'expired_date',
							'label-width'=>'200px;',
							'value'=>"<input type='text' name='tgl_peraturan' id='tgl_peraturan' class='datepicker' value='".TglInd($dt['tgl_peraturan'])."' style='width:80px;' />",						
								),			 			 			 			 
			
			'Urainan' => array( 
						'label'=>'URAIAN',
						'labelWidth'=>50, 
						'value'=>"
						<textarea name='Urainan' id='Urainan' style='margin: 0px; width: 300px; height: 25px;' >".$dt['uraian']."</textarea>
					
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
	   <th class='th01' width='500' align='center'>Kategori</th>		
	   <th class='th01' width='200' align='center'>Nomor Peraturan</th>
	   <th class='th01' width='200' align='center'>Tanggal Peraturan</th>
	   <th class='th01' width='500' align='center'>Uraian</th>
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
	 $Koloms[] = array('align="left"',$isi['no_urut']);
	 $Koloms[] = array('align="left"',$kategori['kategori_perda']);	
	 $Koloms[] = array('align="left"',$isi['no_peraturan']);
	  $Koloms[] = array('align="left"',TglInd($isi['tgl_peraturan']));
	 $Koloms[] = array('align="left"',$isi['uraian']); 
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
	/*$TampilOpt =
			
			"<tr><td>".
			"<div id='skpd_pegawai' ></div>".
			$vOrder=			
			genFilterBar(
				array(*/
				/*"Group : "
				.cmbArray('fmFiltStatus2',$fmFiltStatus2,$arrKategori,'-- Group --',''). 
				"&nbsp&nbsp&nbsp&nbsp"	
					.cmbArray('fmPILCARI',$fmPILCARI,$arr,'-- Cari Data --',''). //generate checkbox					
					"&nbsp&nbsp<input type='text' value='".$fmPILCARIvalue."' name='fmPILCARIvalue' id='fmPILCARIvalue'>"
				*/	//<input type='button' id='btTampil' value='Cari' onclick='".$this->Prefix.".refreshList(true)'>"
					
					
				//	),			
			//	$this->Prefix.".refreshList(true)");
			//	'');
		//	"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>";
			
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
$ref_perda = new ref_perdaObj();
?>