<?php

class ref_tagihanObj  extends DaftarObj2{	
	var $Prefix = 'ref_tagihan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
//	var $TblName = 'ref_tandatangan'; //daftar
	var $TblName = 'ref_tagihan'; //daftar
	var $TblName_Hapus = 'ref_tagihan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Tagihan';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
//	var $fileNameExcel='ref_tim_anggaran.xls';
//	var $Cetak_Judul = 'Referensi Peraturan Daerah';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_tagihanForm'; 
	var $kdbrg = '';	
	
	var $arrGroup = array( 
		array('1','1.Tim Anggaran'),
		array('2','2.Di Teliti Oleh'),
		array('3','3.Tim Asistensi')
		);
	
			
	function setTitle(){
		return 'REFERENSI TAGIHAN';
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
     $kode0 = $_REQUEST['fmc1'];
     $kode1= $_REQUEST['fmc'];
	 $kode2= $_REQUEST['fmd'];
	 $noTagihan= $_REQUEST['noTagihan'];
	 $tgl_tagihan= $_REQUEST['tgl_tagihan'];
	 $fmJenis= $_REQUEST['fmJenis'];
	// $id_jenis_tagihan= $_REQUEST['id_jenis_tagihan'];
     $urainan= $_REQUEST['urainan'];
     /*$id_kategori= $_REQUEST['id_kategori'];
	 $no_peraturan= $_REQUEST['no_peraturan'];
	 $tgl_peraturan= $_REQUEST['tgl_peraturan'];
	 $Urainan= $_REQUEST['Urainan'];*/
	
	$tgl_tagihan = explode("-",$tgl_tagihan);
	$tgl_tagihan2 = $tgl_tagihan[2].'-'.$tgl_tagihan[1].'-'.$tgl_tagihan[0];
	$id_jenis=mysql_fetch_array(mysql_query("select * from ref_jenis_tagihan where nm_tagihan='$fmJenis'"));
	$cek.="select * from ref_jns_tagihan where nm_tagihan='$fmJenis'";
	/*$dat=mysql_fetch_array(mysql_query("select * from ref_kategori_perda where kategori_perda='$kategori'"));
	*/
	$oldy=mysql_fetch_array(mysql_query("select count(*) as cnt from ref_tagihan where no_tagihan='$noTagihan'"));
//	$oldy2=mysql_fetch_array(mysql_query("select count(*) as cnt from ref_tim_anggaran where no_urut='$urut'"));
	 if( $err=='' && $kode0 =='' ) $err= 'Urusan Belum di Pilih !!';
	 if( $err=='' && $kode1 =='' ) $err= 'Bidang Belum Di Pilih !!';
	 if( $err=='' && $kode2 =='' ) $err= 'SKPD Belum Di Pilih !!';
	 if( $err=='' && $noTagihan =='' ) $err= 'No Tagihan Belum Di Isi !!';
	 if( $err=='' && $tgl_tagihan[2] =='' ) $err= 'Tanggal Tagihan Belum Di Isi !!';
	 if( $err=='' && $fmJenis =='' ) $err= 'Jenis Tagihan Belum Di Pilih !!';
	
	
			if($fmST == 0){
			
			if($err=='' && $oldy['cnt']>0) $err="No Tagihan '$noTagihan' Sudah Ada";
			
				if($err==''){
			
				$aqry = "INSERT into ref_tagihan (c1,c,d,no_tagihan,tgl_tagihan,refid_jns_tagihan,keterangan) values('$kode0','$kode1','$kode2','$noTagihan','$tgl_tagihan2','".$id_jenis['Id']."','$urainan')";	$cek .= $aqry;	
				$qry = mysql_query($aqry);
				}
			}else{
				$old = mysql_fetch_array(mysql_query("select * from ref_tagihan where Id='$idplh'"));								if($noTagihan!=$old['no_tagihan'] ){
							$get = mysql_fetch_array(mysql_query(
								"select count(*) as cnt from ref_tagihan where no_tagihan='$noTagihan' "
							));
							if($get['cnt']>0 ) $err="No Tagihan '$noTagihan' Sudah Ada";
						}
			
			if($err==''){
				$aqry = "UPDATE ref_tagihan SET c1='$kode0',c='$kode1', d='$kode2',no_tagihan='$noTagihan', tgl_tagihan='$tgl_tagihan2', refid_jns_tagihan='".$id_jenis['Id']."',keterangan='$urainan' WHERE Id='".$idplh."'";	$cek .= $aqry;
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
		
		case 'pilihUrusan':{				
			global $Main;
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$queryc="SELECT c, concat(c, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c!='00' and d='00' and e='00' and e1='000'" ;$cek.=$queryc;
			$content->c=cmbQuery('fmc',$fmc,$queryc,'style="width:500px;"onchange="'.$this->Prefix.'.pilihBidang()"','-------- Pilih Kode BIDANG ------------');
			
			$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d <> '00' and e='00' and e1='000'" ;$cek.=$queryd;
			$content->d=cmbQuery('fmd',$fmd,$queryd,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSKPD()"','-------- Pilih Kode SKPD ----------------');
			
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}
		
		case 'pilihBidang':{				
		global $Main;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
	 
			$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d !='00' and e='00' and e1='000'" ;$cek.=$queryd;
			$content->d=cmbQuery('fmd',$fmd,$queryd,'style="width:500px;""','-------- Pilih Kode SKPD ----------------');
			
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									break;
			}
			
			
			
		
		
		
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
		
		//Update Syfa-----------------------------------------
		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
		break;
		}
		//----------------------------------------------------
	   
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
		
		$tagihan=mysql_query("select * from t_spp where refid_nomor_tagihan='".$ids[$i]."'"); 
		
		if($err==''){
			if (mysql_num_rows($tagihan)>0)$err='Nama Tagihan Tidak bisa di Hapus sudah ada di Surat Permohonan !!';
		}
	
		if($err=='' ){
			$qy = "DELETE FROM ref_tagihan WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		}
		}
		return array('err'=>$err,'cek'=>$cek);
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
			"<script type='text/javascript' src='js/master/ref_tagihan/ref_tagihan.js' language='JavaScript' ></script>".
			'
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>
			'.
			
			$scriptload;
	}
	
	//form ==================================
	
	function setFormBaru(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c1 = $_REQUEST[$this->Prefix.'SkpdfmUrusan'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		
		$cek = $cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
			
		$dt=array();
		
		$this->form_fmST = 0;
		$dat_urusan= $_REQUEST['dat_urusan'];
		
			$dt['c1'] = $_REQUEST['fmUrusan'];
			$dt['c'] = $_REQUEST['fmBidang'];
			$dt['d'] = $_REQUEST['fmSkpd'];
			
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
		$aqry = "SELECT * FROM  ref_tagihan WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
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
	 $this->form_height = 200;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU TAGIHAN';
		$nip	 = '';
		
	  }else{
		$this->form_caption = 'EDIT TAGIHAN';			
		$readonly='readonly';
		$jenis=mysql_fetch_array(mysql_query("select * from ref_jenis_tagihan where Id='".$dt['refid_jns_tagihan']."'"));
			$cek.="select * from ref_jenis_tagihan where Id='".$dt['refid_jns_tagihan']."'";		
	  }
	  
	  	$fmc1 = $_REQUEST['fmc1'];
		$fmc = $_REQUEST['fmc'];
		$fmd = $_REQUEST['fmd'];
							
		$queryc1="SELECT c1, concat(c1, '. ', nm_skpd) as vnama FROM ref_skpd where c1!='0' and c=00 and d=00 and e=00 and e1=000";
		$queryc="SELECT c,concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c!=00 and d=00 and e=00 and e1=000";
		$queryd="SELECT d,concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d!='00' and e=00 and e1=000";
	//	$queryJenis="SELECT Id,concat(Id, '. ', nm_tagihan) as vnama FROM ref_jenis_tagihan";	
		$queryJenis="SELECT nm_tagihan, nm_tagihan FROM ref_jenis_tagihan";	
		
		$this->form_fields = array(
		
			'urusan' => array( 
						'label'=>'URUSAN',
						'labelWidth'=>130, 
						'value'=>"<div id='cont_c1'>".cmbQuery('fmc1',$dt['c1'],$queryc1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihUrusan()"','-------- Pilih Kode URUSAN ------------')."</div>",
						 ),		
						 	
			'bidang' => array( 
						'label'=>'BIDANG',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_c'>".cmbQuery('fmc',$dt['c'],$queryc,'style="width:500px;"onchange="'.$this->Prefix.'.pilihBidang()"','-------- Pilih Kode BIDANG -----------')."</div>",
						 ),
						 		 
			'skpd' => array( 
						'label'=>'SKPD',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_d'>".cmbQuery('fmd',$dt['d'],$queryd,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSKPD()"','-------- Pilih Kode SKPD ---------------')."</div>",
						 ),	
						 
			'noTagihan' => array( 
						'label'=>'No.TAGIHAN',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>			
						<input type='text' name='noTagihan' id='noTagihan' value='".$dt['no_tagihan']."' style='width:150px;' >
						</div>", 
						 ),
			
			'tgl_tagihan' =>array(
							'label'=>'TANGGAL TAGIHAN',
							'name'=>'expired_date',
							'label-width'=>'200px;',
							'value'=>"<input type='text' name='tgl_tagihan' id='tgl_tagihan' class='datepicker' value='".TglInd($dt['tgl_tagihan'])."' style='width:150px;' />",						
								),
								
			'jenisTagihan' => array(
								'label'=>'JENIS TAGIHAN',
								'name'=>'tagihan',
								'label-width'=>'100px;',
								'value'=>"<div id='cont_jnsTagihan'>
								".cmbQuery('fmJenis',$jenis['nm_tagihan'],$queryJenis,'style="width:500px;""','-------- Pilih Jenis Tagihan ------------')."
						
						</div>" ,
								
							),
			'Urainan' => array( 
						'label'=>'URAIAN',
						'labelWidth'=>50, 
						'value'=>"
						<textarea name='urainan' id='urainan' style='margin: 0px; width: 500px; height: 30px;' >".$dt['keterangan']."</textarea>
					
						", 
						 ),											 
			);
		//tombol
		$this->form_menubawah =	
		//	"<input type=hidden id='id_jenis_tagihan' name='id_jenis_tagihan' value='".$$queryJenis['Id']."'> ".
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
	   <th class='th01' width='100' align='center'>No.Tagihan</th>
	   <th class='th01' width='200' align='center'>Tanggal Peraturan</th>
	   <th class='th01' width='500' align='center'>Jenis Tagihan</th>		
	   <th class='th01' width='500' align='center'>Uraian</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	$jenis=mysql_fetch_array(mysql_query("select * from ref_jenis_tagihan where Id='".$isi['refid_jns_tagihan']."'"));	
	
	//UPDATE SYFA -----------
		$no_tagihan = $isi['no_tagihan'];
		if(isset($_REQUEST['pencarian_data']))$no_tagihan = "<a href='javascript:".$this->Prefix.".Get_PilData(`".$isi['Id']."`)' >$no_tagihan</a>";
	//-----------------------
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$no_tagihan);
	 $Koloms[] = array('align="left"',TglInd($isi['tgl_tagihan']));
	 $Koloms[] = array('align="left"',$jenis['nm_tagihan']);	
	 $Koloms[] = array('align="left"',$isi['keterangan']);
	 return $Koloms;
	}
	
	function setMenuView(){
		
			}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
			
	$fmUrusan = cekPOST('fmUrusan');
	$fmBidang = cekPOST('fmBidang');
	$fmSkpd = cekPOST('fmSkpd');
	$noTagihan = cekPOST('noTagihan');
	$tanggal = cekPOST('tanggal');
//	$tanggal = $_REQUEST['tanggal'];

	$data_skpd = "<div class='FilterBar'>".	
		"<table style='width:100%'>
			<tr>
			<td style='width:100px'>URUSAN</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery1("fmUrusan",$fmUrusan,"select c1,nm_skpd from ref_skpd where c1!='0' and c ='00' and d = '00' and e='00' and e1='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>BIDANG</td><td>:</td>
			<td>".
			cmbQuery1("fmBidang",$fmBidang,"select c,nm_skpd from ref_skpd where c1='$fmUrusan' and c!='00' and d = '00' and e='00' and e1='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SKPD</td><td>:</td>
			<td>".
			cmbQuery1("fmSkpd",$fmSkpd,"select d,nm_skpd from ref_skpd where c1='$fmUrusan' and c ='$fmBidang' and d != '00' and e='00' and e1='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
		</table>"."</div>";	
	if(isset($_REQUEST["pencarian_data"]))$data_skpd='';	
				
		$TampilOpt = $data_skpd.			
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				No Tagihan : <input type='text' id='noTagihan' name='noTagihan' value='".$noTagihan."' size=20px>&nbsp
				Tanggal Tagihan :<input type='text' name='tanggal' id='tanggal' class='datepicker' placeholder='Tanggal' style='width:80px;' value='".$tanggal."' />
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td>
			
			
			</tr>
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
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
	 	$fmUrusan = cekPOST('fmUrusan');
	 	$fmBidang = cekPOST('fmBidang');
	    $fmSkpd = cekPOST('fmSkpd');
		$noTagihan = cekPOST('noTagihan');
		$tanggal = cekPOST("tanggal");
		$pencarian_data = cekPOST("pencarian_data");
		$tgl_tagih = explode("-", $tanggal);
		$tgl_tagihan = $tgl_tagih[2]."-".$tgl_tagih[1]."-".$tgl_tagih[0];
	//	$tanggal = $_REQUEST['tanggal'];
		//Cari 
		$isivalue=explode('.',$fmPILCARIvalue);
		/*switch($fmPILCARI){			
			
			case 'selectKode': $arrKondisi[] = " concat(k,'.',l,'.',m,'.',n,'.',o) like '$fmPILCARIvalue%'"; break;
			case 'selectNama': $arrKondisi[] = " nm_rekening like '%$fmPILCARIvalue%'"; break;	
				
								 	
		}*/	
		
		//UPDATE Syfa	
		if($pencarian_data == "1"){
			$arrKondisi[]= "c1 ='$fmUrusan'";
			$arrKondisi[]= "c ='$fmBidang'";
			$arrKondisi[]= "d ='$fmSkpd'";
		}
		
		
		if(empty($fmUrusan)) {
			$fmBidang = '';
			$fmSkpd='';
		}
		
		if(empty($fmBidang)) {
			$fmSkpd='';
		}
		
		if(empty($fmUrusan) && empty($fmBidang) && empty($fmSkpd))
		{
			
		}
		elseif(!empty($fmUrusan) && empty($fmBidang) && empty($fmSkpd))
		{
			$arrKondisi[]= "c1 =$fmUrusan";			
		}
		elseif(!empty($fmUrusan) && !empty($fmBidang) && empty($fmSkpd))
		{
			$arrKondisi[]= "c1 =$fmUrusan and d=$fmBidang";
						
		}
		elseif(!empty($fmUrusan) && !empty($fmBidang) && !empty($fmSkpd))
		{
			$arrKondisi[]= "c1 =$fmUrusan and c=$fmBidang and d=$fmSkpd";
							
		}
		
		if(!empty($_POST['noTagihan'])) $arrKondisi[] = " no_tagihan like '".$_POST['noTagihan']."%'";					
	//	if(!empty($_POST['tanggal'])) $arrKondisi[] = " tgl_tagihan>='".$_POST['tanggal']."'";
	//	if(!empty($tanggal)) $arrKondisi[]= " tgl_tagihan>='$tanggal'";
		if($tanggal != '')$arrKondisi[] = "tgl_tagihan='$tgl_tagihan'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		/*switch($fmORDER1){
			case '1': $arrOrders[] = " k,l,m,n,o $Asc1 " ;break;
			case '2': $arrOrders[] = " nm_skpd $Asc1 " ;break;
			
		}	*/
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	
	//UPDATE SYFA -------------------------
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
				
		$form_name = $this->FormName;
		$ref_jenis=cekPOST('ref_jenis',1);
		
		//if($err==''){
			$FormContent = $this->genDaftarInitial();
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						1000,
						500,
						'Pilih Tagihan',
						'',
						/*"
						<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".*/
						"<input type='button' value='Tutup' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >".
						"<input type='hidden' id='idTerima_det' name='idTerima_det' value='".$_REQUEST['idTerima_det']."' >".
						"<input type='hidden' id='fmUrusan' name='fmUrusan' value='".$_REQUEST['c1nya']."' >".
						"<input type='hidden' id='fmBidang' name='fmBidang' value='".$_REQUEST['cnya']."' >".
						"<input type='hidden' id='fmSkpd' name='fmSkpd' value='".$_REQUEST['dnya']."' >".
						"<input type='hidden' id='pencarian_data' name='pencarian_data' value='1' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
		//}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
}
$ref_tagihan = new ref_tagihanObj();
?>