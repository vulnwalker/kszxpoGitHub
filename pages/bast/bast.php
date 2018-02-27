<?php

class bastObj  extends DaftarObj2{	
	var $Prefix = 'bast';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'v1_bast'; //daftar
	var $TblName_Hapus = 'bast';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('tgl_ba','no_ba','no_spk','tgl_spk','bk','ck','dk','bk_p','ck_p','dk_p','p','q','m1','m2','m3','m4','m5');
	var $FieldSum = array('jml_barang', 'harga_beli', 'harga_atribusi');//array('jml_harga');
	var $totalCol = 12; //total kolom daftar
	var $fieldSum_lokasi = array( 10,11,12);  //lokasi sumary di kolom ke
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Daftar BAST';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='bast.xls';
	var $Cetak_Judul = 'Daftar BAST';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'bastForm'; 
	var $kdbrg = '';	
			
	function setTitle(){
		return  'Daftar BAST';
	}
	function setMenuEdit(){		
		return
			/**
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus').
			"</td>"**/
			'';
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
	 /*global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $a1 = $Main->DEF_KEPEMILIKAN;
	 $a = $Main->Provinsi[0];
	 $b = '00';
	 $c = $_REQUEST['c'];
	 $d = $_REQUEST['d'];
	 $e = $_REQUEST['e'];
	 $kode_barang = $_REQUEST['kode_barang'];
	 //memecah kode barang
	 $kode_barang = explode('.',$kode_barang);
	 $f=$kode_barang[0];	
	 $g=($kode_barang[1]=='')?"00":$kode_barang[1];
	 $h=($kode_barang[2]=='')?"00":$kode_barang[2];	
	 $i=($kode_barang[3]=='')?"00":$kode_barang[3];
	 $j=($kode_barang[4]=='')?"00":$kode_barang[4];
	 $nama_barang = $_REQUEST['nama_barang'];
	 $masa_manfaat = $_REQUEST['masa_manfaat'];	 
	 $persen1 = str_replace(",",".",$_REQUEST['persen1']);
	 $persen2 = str_replace(",",".",$_REQUEST['persen2']);
	
	 if($err=='' && $kode_barang =='' ) $err= 'Kode Barang belum diisi';	 
 	 if($err=='' && $nama_barang =='' ) $err= 'Nama Barang belum diisi';	 	 
 	 if($err=='' && $persen1 =='' ) $err= 'Persentase harus di isi semua';	
 	 if($err=='' && $persen2 =='' ) $err= 'Persentase harus di isi semua';	
 	 if($err=='' && $masa_manfaat =='' ) $err= 'Masa Manfaat belum diisi';*/
 
 	 /*---------------------------------------------------------------------------*/

	
			/*if($fmST == 0){ //input ref_skpd
				if($err==''){ 

						$aqry1 = "INSERT into ref_skpd (f,g,h,i,j,persen1,persen2,masa_manfaat)
								 "."values('$f','$g','$h','$i','$j','$persen1','$persen2','$masa_manfaat')";	
						$cek .= $aqry1;	
						$qry = mysql_query($aqry1);						
													
				}
			}elseif($fmST == 1){						
				if($err==''){
							 						 
						$aqry2 = "UPDATE ref_skpd
			        			  set "." 
								  persen1 ='$persen1',
								  persen2 ='$persen2',
								  masa_manfaat='$masa_manfaat'".
					 			 "WHERE Id='$idplh'";	
						$cek .= $aqry2;
						$qry = mysql_query($aqry2);
						
				}
			}else{
			if($err==''){ 

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
		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
			break;
		}

	   	case 'getdata':{

		$ref_pilihbarang = $_REQUEST['id'];
		$kode_barang = explode(' ',$ref_pilihbarang);
		$f=$kode_barang[0];	
		$g=$kode_barang[1];
		$h=$kode_barang[2];	
		$i=$kode_barang[3];
		$j=$kode_barang[4];
		
		//query ambil data ref_program
		$get = mysql_fetch_array( mysql_query("select * from ref_barang where f=$f and g=$g and h=$h and i=$i and j=$j"));
		$kode_barang=$get['f'].'.'.$get['g'].'.'.$get['h'].'.'.$get['i'].'.'.$get['j'];
		
		$fmThnAnggaran=  $_COOKIE['coThnAnggaran'];
			$kueri1="select max(thn_akun) as thn_akun from ref_jurnal where thn_akun <= '$fmThnAnggaran'";
			$tmax = mysql_fetch_array(mysql_query($kueri1));
			$kueri="select * from ref_jurnal 
					where thn_akun = '".$tmax['thn_akun']."' 
					and ka='".$get['m1']."' and kb='".$get['m2']."' 
					and kc='".$get['m3']."' and kd='".$get['m4']."'
					and ke='".$get['m5']."' and kf='".$get['m6']."'"; //echo "$kueri";
			$row=mysql_fetch_array(mysql_query($kueri));
						
			$kode_account =$row['ka'].".".$row['kb'].".".$row['kc'].".".$row['kd'].".".$row['ke'].".".$row['kf'];
						
		$content = array('IDBARANG'=>$kode_barang, 'NMBARANG'=>$get['nm_barang'], 'kode_account'=>$kode_account, 'nama_account'=>$row['nm_account'], 'tahun_account'=>$row['thn_akun']);	
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
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';		
		$form_name = $this->FormName;
		
		
		
			$FormContent = $this->genDaftarInitial();
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						800,
						500,
						'Pilih Barang',
						'',
						"<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
						"<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}*/
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
     $kode1= $_REQUEST['c'];
	 $kode2= $_REQUEST['d'];
	 $kode3= $_REQUEST['e'];
	 $kode4= $_REQUEST['e1'];
	 $nama_skpd = $_REQUEST['nama_skpd'];
	 $nama_barcode = $_REQUEST['nama_barcode'];
	 
		
	 
	
	 
	 if( $err=='' && $kode1 =='' ) $err= 'Kode 1 Belum Di Isi !!';
	 if( $err=='' && $kode2 =='' ) $err= 'Kode 2 Belum Di Isi !!';
	 if( $err=='' && $kode3 =='' ) $err= 'Kode 3 Belum Di Isi !!';
	 if( $err=='' && $kode4 =='' ) $err= 'Kode 4 Belum Di Isi !!';
	 if( $err=='' && $nama_skpd =='' ) $err= 'nama skpd Belum Di Isi !!';
	 if( $err=='' && $nama_barcode =='') $err= 'nama barcode Belum Di Isi !!';
	 	
	
	// if($err=='' && $kode_skpd =='' ) $err= 'Kode Skpd belum diisi';	 
	/* if(strlen($kode1)!=2 || strlen($kode2)!=2 || strlen($kode3)!=2 || strlen($kode4)!=3) $err= 'Format Kode SKPD salah bro';	
			for($j=0;$j<4;$j++){
	//urutan kode skpd 	
		if($j==0){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_skpd where c ='00' and d ='00' and e ='00' and e1 ='000' Order By c DESC limit 1"));
			if($kode1=='00') {$err= 'Format Kode Bidang salah';}
			elseif($kode1>sprintf("%02s",$ck['c']+1)){ $err= 'Format Kode Bidang Harus berurutan';}
				
		}elseif($j==1){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_skpd where c='".$kode1."' and d !='00' and e ='00' and e1 ='000' Order By d DESC limit 1"));	
			if ($kode2>sprintf("%02s",$ck['d']+1)) {$err= 'Format Kode SKPD Harus berurutan';}		
			
		}elseif($j==2){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_skpd where c='".$kode1."' and d ='".$kode2."' and e !='00' and e1 ='000' Order By e DESC limit 1"));			
			if ($kode3>sprintf("%02s",$ck['e']+1)) {$err= 'Format Kode Unit SKPD Harus berurutan';}		
				
		}elseif($j==3){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_skpd where c='".$kode1."' and d ='".$kode2."' and e ='".$kode3."' and e1 !='000' Order By e1 DESC limit 1"));	
			if ($kode4>sprintf("%02s",$ck['e1']+1)) {$err= 'Format Kode Sub Unit SKPD Harus berurutan';}
		
					
		}
	 }*/
	 
			if($fmST == 0){
			$ck1=mysql_fetch_array(mysql_query("Select * from ref_skpd where c='$kode1' and d ='$kode2' and e ='$kode3' and e1='$kode4'"));
			if ($ck1>=1)$err= 'Gagal Simpan'.mysql_error();
				if($err==''){
					$aqry = "INSERT into ref_skpd (c,d,e,e1,nm_skpd,nm_barcode) values('$kode1','$kode2','$kode3','$kode4','$nama_skpd','$nama_barcode')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{						
				if($err==''){
				$aqry = "UPDATE ref_skpd SET nm_skpd='$nama_skpd', nm_barcode='$nama_barcode' WHERE c='$kode1' and d='$kode2' and e='$kode3' and e1='$kode4'";	$cek .= $aqry;
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
			 <script type='text/javascript' src='js/bast/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
			 ".
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".
			
			$scriptload;
	}
	function Hapus_Validasi($id){//id -> multi id with space delimiter
		$errmsg ='';
		$kode_skpd = explode(' ',$id);
		$c=$kode_skpd[0];	
		$d=$kode_skpd[1];
		$e=$kode_skpd[2];	
		$e1=$kode_skpd[3];
		if($errmsg=='' && 
				mysql_num_rows(mysql_query(
					"select Id from buku_induk where c='$c' and d='$d' and e='$e' and e1='$e1' ")
				) >0 )
			{ $errmsg = 'Gagal Hapus! SKPD Sudah ada di Buku Induk!';}
		return $errmsg;
	}
	//form ==================================
	
	function setFormBaru(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$cek = $cbid[0];
				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		/*$fmBIDANG = $_REQUEST['fmBIDANG'];
		$fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
		$fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
		$fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];		
		if(!empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.'00'.'.'.'00'.'.'.'00'.'.'.'000';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.'00'.'.'.'00'.'.'.'000';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.'.'00'.'.'.'000';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.'.$fmSUBSUBKELOMPOK.'.'.'000';
		}	
		
		$ck=mysql_fetch_array(mysql_query("select * from ref_skpd where concat(f,'.',g,'.',h,'.',i,'.',j)='".$dt['kode_barang']."' order by persen1 desc limit 0,1"));
		if($ck['Id'] != ''){
			$dt['persen1'] = $ck['persen2'];
			$dt['readonly'] = 'readonly';
		}else{
			$dt['persen1'] = '';
			$dt['readonly'] = '';
		}
		
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}*/
	$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$dt['c'] = $c; 
		$dt['d'] = $d; 
		$dt['e'] = $e; 
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
  	function setFormEdit(){
		/*$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$dt['c'] = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$dt['d'] = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$dt['e'] = $_REQUEST[$this->Prefix.'SkpdSUBUNIT'];
		$cek =$cbid[0];
				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		//query ambil data ref_tambah_manfaat
		$aqry = "select * from ref_skpd where Id='".$this->form_idplh."'"; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$dt['kode_barang']=$dt['f'].'.'.$dt['g'].'.'.$dt['h'].'.'.$dt['i'].'.'.$dt['j'];
		$dt['readonly'] = '';
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}*/
	$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$c=$kode[0];
		$d=$kode[1];
		$e=$kode[2];
		$e1=$kode[3];
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  ref_skpd WHERE c='$c' and d='$d' and e='$e' and e1='$e1' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	/* global $SensusTmp, $Main;
	 $cek = ''; $err=''; $content=''; 
		
	 $json = TRUE;	//$ErrMsg = 'tes';
	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 510;
	 $this->form_height = 120;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU';
	  }else{
		$this->form_caption = 'EDIT';
	  }
	  	$readonly = '';//$dt['readonly'];
		$lengthKodeBrg =  12 + $Main->KODEBARANGJ_DIGIT ;
		$sampleKodeBrg = "*00.00.00.00.".$Main->KODEBARANGJ ;
		
		//query ref_batal
		$queryKB = "SELECT f,nama_barang FROM ref_barang_persediaan where f !=0 and g=0";
		
		//query nm_barang
		$brg = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '".$dt['kode_barang']."'"));
		
		$dt['persen1'] = $dt['persen1'] == '' ?0: $dt['persen1'];
		$dt['persen2'] = $dt['persen2'] == '' ?0: $dt['persen2'];
		$dt['masa_manfaat'] = $dt['masa_manfaat'] == '' ?0: $dt['masa_manfaat'];*/
		global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 450;
	 $this->form_height = 100;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
		$nip	 = '';
	  }else{
		$this->form_caption = 'Edit';			
		$readonly='readonly';
					
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		$kode1=genNumber($dt['c'],2);
		$kode2=genNumber($dt['d'],2);
		$kode3=genNumber($dt['e'],2);
		$kode4=genNumber($dt['e1'],3);
		$nama_skpd=$dt['nm_skpd'];
		$nama_barcode=$dt['nm_barcode'];
		
       //items ----------------------
		 $this->form_fields = array(
			'kode' => array( 
						'label'=>'Kode SKPD',
						'labelWidth'=>150, 
						//'value'=>$dt['kode'],
						//'type'=>'text',
						'value'=>
						"<input type='text' name='c' id='c' size='5' maxlength='2' value='".$kode1."' $readonly>&nbsp
						<input type='text' name='d' id='d' size='5' maxlength='2' value='".$kode2."' $readonly>&nbsp
						<input type='text' name='e' id='e' size='5' maxlength='2' value='".$kode3."' $readonly>&nbsp
						<input type='text' name='e1' id='e1' size='5' maxlength='3' value='".$kode4."' $readonly>"
						 ),
			
			'nama' => array( 
						'label'=>'Nama SKPD',
						'labelWidth'=>200, 
						
						
						'value'=>"<input type='text' name='nama_skpd' id='nama_skpd' size='50' maxlength='100' value='".$nama_skpd."'>",
						'row_params'=>"valign='top'",
						'type'=>'' 
									 ),
			'barcode' => array( 
						'label'=>'Nama Barcode',
						'labelWidth'=>200, 
						
						
						'value'=>"<input type='text' name='nama_barcode' id='nama_barcode' size='50' maxlength='100' value='".$nama_barcode."'>",
						'row_params'=>"valign='top'",
						'type'=>'' 
									 ),					 
			);
		//tombol
		$this->form_menubawah =	
			"<input type='hidden' name='Id_skpd' id='Id_skpd'  value='".$Id."'>".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
		
	//daftar =================================	
	function setKolomHeader($Mode=1, $Checkbox=''){
		$NomorColSpan = $Mode==1? 2: 1;
		//harga_atribusi,harga_beli,jml_barang,m5,m4,m3,m2,m1,q,p,dk_p,ck_p,bk_p,dk,ck,bk,tgl_spk,no_spk,no_ba,tgl_ba
	 	$headerTable =
	  	"<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox		
	   <th class='th01' width='80' >Tgl. BAST</th>
	   <th class='th01'  >No. BAST</th>
	   <th class='th01'  >No. SPK</th>	   
	   <th class='th01' width='80'  >Tgl. SPK</th>	   
	   <th class='th01'  >Urusan</th>
	   <th class='th01'  >Program/Kegiatan</th>
	   <th class='th01'  >Akun</th>
	   <th class='th01'  >Jml. Barang</th>
	   <th class='th01'  >Harga Beli</th>
	   <th class='th01'  >Atribusi</th>
	   
	   
	  
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	function genSum_setTampilValue($i, $value){
		if ($i==0) {
			return number_format($value, 0, ',' ,'.');
		}else{
			return number_format($value, 2, ',' ,'.');	
		}
		
	}
	function genRowSum_setTampilValue($i, $value){
		
		if ($i==0) {
			return number_format($value, 0, ',' ,'.');
		}else{
			return number_format($value, 2, ',' ,'.');	
		}	
	}
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 /**
	 //harga_atribusi,harga_beli,jml_barang,m5,m4,m3,m2,m1,q,p,dk_p,ck_p,bk_p,dk,ck,bk,tgl_spk,no_spk,no_ba,tgl_ba
	 	$headerTable =
	  	"<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox		
	   <th class='th01'  >Tgl. BAST</th>
	   <th class='th01'  >No. BAST</th>
	   <th class='th01'  >No. SPK</th>	   
	   <th class='th01'  >Tgl. SPK</th>	   
	   <th class='th01'  >Urusan</th>
	   <th class='th01'  >Program/Kegiatan</th>
	   <th class='th01'  >Akun</th>
	   <th class='th01'  >Jml. Barang</th>
	   <th class='th01'  >Harga Beli</th>
	   <th class='th01'  >Atribusi</th>
	   
	   
	  **/
	  
	  $get = mysql_fetch_array(mysql_query(
	  	"select * from ref_urusan where bk='".$isi['bk']."' and  ck='0' "
	  ));
	  $nmUrusan = $get['nm_urusan'];
	  $get = mysql_fetch_array(mysql_query(
	  	"select * from ref_urusan where bk='".$isi['bk']."' and  ck='".$isi['ck']."' and dk='0' "
	  ));
	  $nmBidang = $get['nm_urusan'];
	  $get = mysql_fetch_array(mysql_query(
	  	"select * from ref_urusan where bk='".$isi['bk']."' and   ck='".$isi['ck']."' and dk='".$isi['dk']."' "
	  ));
	  $nmDinas = $get['nm_urusan'];
	  
	  $get = mysql_fetch_array(mysql_query(
	  	"select * from ref_program where bk='".$isi['bk_p']."' and   ck='".$isi['ck_p']."' and dk='".$isi['dk_p']."' and p='".$isi['p']."' and q='0' "
	  ));
	  $nmProgram = $get['nama'];
	  $get = mysql_fetch_array(mysql_query(
	  	"select * from ref_program where bk='".$isi['bk_p']."' and   ck='".$isi['ck_p']."' and dk='".$isi['dk_p']."' and p='".$isi['p']."' and q='".$isi['q']."' "
	  ));
	  $nmKegiatan = $get['nama'];
	  
	  $get = mysql_fetch_array(mysql_query(
	  	"select * from ref_jurnal where ka='".$isi['m1']."' and kb='".$isi['m2']."' and kc='".$isi['m3']."' and kd='".$isi['m4']."' and ke='".$isi['m5']."' and kf='0' "
	  ));
	  $nmAkun = $get['nm_account'];
	  
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $Koloms[] = array('', TglInd($isi['tgl_ba']) );
	 $Koloms[] = array('', $isi['no_ba'] );
	 $Koloms[] = array('', $isi['no_spk'] );
	 $Koloms[] = array('', TglInd($isi['tgl_spk']) );	 
	 $Koloms[] = array('', $isi['bk'].'.'.$isi['ck'].'.'.$isi['dk'] .'<br>'.$nmUrusan.'/<br>'.$nmBidang.'/<br>'.$nmDinas  );
	 $Koloms[] = array('', $isi['bk_p'].'.'.$isi['ck_p'].'.'.$isi['dk_p'].'.'.$isi['p'].'.'.$isi['q'] .'<br>'.$nmProgram.'/<br>'.$nmKegiatan  );
	 $Koloms[] = array('', $isi['m1'].'.'.$isi['m2'].'.'.$isi['m3'].'.'.$isi['m4'].'.'. $isi['m5'] .'<br>'. $nmAkun );
	 $Koloms[] = array("align='right'", number_format($isi['jml_barang'],0,',','.') );
	 $Koloms[] = array("align='right'", number_format($isi['harga_beli'],2,',','.') );
	 $Koloms[] = array("align='right'", number_format($isi['harga_atribusi'],2,',','.') );
	 
	 return $Koloms;
	}
	
	
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 

	/*$fmBIDANG = cekPOST('fmBIDANG');
	$fmKELOMPOK = cekPOST('fmKELOMPOK');
	$fmSUBKELOMPOK = cekPOST('fmSUBKELOMPOK');
	$fmSUBSUBKELOMPOK = cekPOST('fmSUBSUBKELOMPOK');
	$fmKODE = cekPOST('fmKODE');
	$fmBARANG = cekPOST('fmBARANG');			
	//$fmPILCARI = $_REQUEST['fmPILCARI'];	
	//$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//$fmORDER1 = cekPOST('fmORDER1');
	//$fmDESC1 = cekPOST('fmDESC1');
	
	
	 $arr = array(
			//array('selectAll','Semua'),
			array('selectfg','Kode Barang'),
			array('selectbarang','Nama Barang'),	
			);
		
		
	//data order ------------------------------
	 $arrOrder = array(
	  	         array('1','Kode Barang'),
			     array('2','Nama Barang'),	
	 );	
				
	$TampilOpt = 
			//"<tr><td>".	
			"<div class='FilterBar'>".
			//<table style='width:100%'><tbody><tr><td align='left'>
			//<table cellspacing='0' cellpadding='0' border='0' style='height:28'>
			//<tbody><tr valign='middle'>   						
			//	<td align='left' style='padding:1 8 0 8; '>".
			//"<div style='float:left;padding: 2 8 0 0;height:20;padding: 4 4 0 0'>Urutkan : </div>".
			
			"<table style='width:100%'>
			<tr>
			<td style='width:120px'>BIDANG</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery1("fmBIDANG",$fmBIDANG,"select f,nm_barang from ref_barang where f!='00' and g ='00' and h = '00' and i='00' and j='$Main->KODEBARANGJ'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmKELOMPOK",$fmKELOMPOK,"select g,nm_barang from ref_barang where f='$fmBIDANG' and g !='00' and h = '00' and i='00' and j='$Main->KODEBARANGJ'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SUB KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBKELOMPOK",$fmSUBKELOMPOK,"select h,nm_barang from ref_barang where f='$fmBIDANG' and g ='$fmKELOMPOK' and h != '00' and i='00' and j='$Main->KODEBARANGJ'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SUB SUB KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBSUBKELOMPOK",$fmSUBSUBKELOMPOK,"select i,nm_barang from ref_barang where f='$fmBIDANG' and g ='$fmKELOMPOK' and h = '$fmSUBKELOMPOK' and i!='00' and j='$Main->KODEBARANGJ'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>
			
			</table>".
			"</div>";
			/*"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Kode Barang : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' maxlength='14' size=20px>&nbsp
				Nama Barang : <input type='text' id='fmBARANG' name='fmBARANG' value='".$fmBARANG."' size=30px>&nbsp
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
			</table>".
			"</div>".
			"<input type='hidden' id='fmORDER18' name='fmORDER18' value='".$fmORDER18."'>".
			"<input type='hidden' id='fmORDER19' name='fmORDER19' value='".$fmORDER19."'>";	*/		
	
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	 $arrOrder = array(
	  	          array('1','Tgl. BAST'),
			     	array('2','No. BAST'),
					);
	$arr = array(
			//array('selectAll','Semua'),	
			array('selectKode','Kode SKPD'),	
			array('selectNama','Nama SKPD'),		
			);
	$no_ba = $_REQUEST['no_ba'];
	$kd_urusan = $_REQUEST['kd_urusan'];
	$kd_kegiatan = $_REQUEST['kd_kegiatan'];
	$kd_akun = $_REQUEST['kd_akun'];
	$cbxCekProgram = $_REQUEST["cbxCekProgram"];				
	$cbxCekBAST = $_REQUEST["cbxCekBAST"];	
	
	$cbxCekNoSPK = $_REQUEST["cbxCekNoSPK"];		
	$cbxCekTglSPK = $_REQUEST["cbxCekTglSPK"];		
	
	
	$cekProgram = " <input $cbxCekProgram id='cbxCekProgram' type='checkbox' value='checked' name='cbxCekProgram' > Program Belum Diisi ";				
	$cekBAST = " <input $cbxCekBAST id='cbxCekBAST' type='checkbox' value='checked' name='cbxCekBAST' > No BAST Belum Diisi ";
	$cekTglSPK = " <input $cbxCekTglSPK id='cbxCekTglSPK' type='checkbox' value='checked' name='cbxCekTglSPK' > Tgl SPK Belum Diisi ";
	$cekNoSPK = " <input $cbxCekNoSPK id='cbxCekNoSPK' type='checkbox' value='checked' name='cbxCekNoSPK' > No SPK Belum Diisi ";
	
	$fmURUSAN = cekPOST('fmURUSAN');
	$fmBIDANG = cekPOST('fmBIDANG');
	$fmDINAS = cekPOST('fmDINAS');
	$fmKODE = cekPOST('fmKODE');
	$fmNMURUSAN = cekPOST('fmNMURUSAN');
	
	$filtUrusan = 
			//"<tr><td>".	
			"<div class='FilterBar'>".			
			"<table style='width:100%'>
			<tr>
			<td style='width:120px'>URUSAN</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery1("fmURUSAN",$fmURUSAN,"select bk,nm_urusan from ref_urusan where bk<>'0' and ck='0' ","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>BIDANG</td><td>:</td>
			<td>".
			cmbQuery1("fmBIDANG",$fmBIDANG,"select ck,nm_urusan from ref_urusan where bk='$fmURUSAN' and ck<>'0' and dk='0' ","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>DINAS</td><td>:</td>
			<td>".
			cmbQuery1("fmDINAS",$fmDINAS,"select dk,nm_urusan from ref_urusan where bk='$fmURUSAN' and ck ='$fmBIDANG' and dk<>'0'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			
			</table>".
			"</div>"/*.
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Kode Akun : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' maxlength='9' size=10px>&nbsp
				Nama Akun : <input type='text' id='fmAKUN' name='fmAKUN' value='".$fmAKUN."' size=30px>&nbsp
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
			</table>".
			"</div>"*/;	
	
	$TampilOpt =
			//<table width=\"100%\" class=\"adminform\">
			/**
			"<table width=\"100%\" class=\"adminform\">	<tr>		
			<td width=\"100%\" valign=\"top\">" . 
				WilSKPD_ajx3($this->Prefix.'Skpd') . 
			"</td>
			<td >" . 		
			"</td></tr>
			<!--<tr><td>
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>			-->
			</table>"
			"<tr><td>".
			"<div id='skpd_pegawai' ></div>".**/
			$filtUrusan.
			genFilterBar(
				array(
					"Tanggal BAST ",	
					createEntryTglBeetwen('fmFiltTglBtw',$fmFiltTglBtw_tgl1, $fmFiltTglBtw_tgl2,'','','adminForm',1),
				),
				"",FALSE).
			genFilterBar(
				array(
					//"Filter ",
					"<input type='text' id='no_ba' name='no_ba' value='$no_ba' placeholder='No. BAST'>",
					"<input type='text' id='kd_urusan' name='kd_urusan' value='$kd_urusan' placeholder='Kode Urusan'>",
					"<input type='text' id='kd_kegiatan' name='kd_kegiatan' value='$kd_kegiatan' placeholder='Kode Kegiatan'>",
					"<input type='text' id='kd_akun' name='kd_akun' value='$kd_akun' placeholder='Kode Akun'>",					
				),
				"",FALSE).
			genFilterBar(
				array(
					
					$cekBAST,
					$cekNoSPK,
					$cekTglSPK,
					$cekProgram,
				),
				"",FALSE).
			genFilterBar(
				array(							
					
					"Urutkan ",
					cmbArray('fmORDER1',$fmORDER1,$arrOrder,'--Urutkan--','').
					"<input $fmDESC1 type='checkbox' id='fmDESC1' name='fmDESC1' value='checked'>&nbspmenurun."
					),			
				$this->Prefix.".refreshList(true)");
			//"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>";
			
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$Kondisi = array();	
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		
		$ref_skpdSkpdfmSKPD = $_REQUEST['ref_skpdSkpdfmSKPD'];//ref_skpdSkpdfmSKPD
		$ref_skpdSkpdfmUNIT = $_REQUEST['ref_skpdSkpdfmUNIT'];
		$ref_skpdSkpdfmSUBUNIT = $_REQUEST['ref_skpdSkpdfmSUBUNIT'];
		$ref_skpdSkpdfmSEKSI = $_REQUEST['ref_skpdSkpdfmSEKSI'];
		//Cari 
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			//case 'selectKode': $arrKondisi[] = " c='".$isivalue[0]."' and d='".$isivalue[1]."' and e='".$isivalue[2]."' and e1='".$isivalue[3]."'"; break;
			case 'selectKode': $arrKondisi[] = " concat(c,'.',d,'.',e,'.',e1) like '$fmPILCARIvalue%'"; break;
			case 'selectNama': $arrKondisi[] = " nm_skpd like '%$fmPILCARIvalue%'"; break;	
								 	
		}	
		if($ref_skpdSkpdfmSKPD!='00' and $ref_skpdSkpdfmSKPD !='')$arrKondisi[]= "c='$ref_skpdSkpdfmSKPD'";
		if($ref_skpdSkpdfmUNIT!='00' and $ref_skpdSkpdfmUNIT !='')$arrKondisi[]= "d='$ref_skpdSkpdfmUNIT'";
		if($ref_skpdSkpdfmSUBUNIT!='00' and $ref_skpdSkpdfmSUBUNIT !='')$arrKondisi[]= "e='$ref_skpdSkpdfmSUBUNIT'";
		if($ref_skpdSkpdfmSEKSI!='00' and $ref_skpdSkpdfmSEKSI !='')$arrKondisi[]= "e1='$ref_skpdSkpdfmSEKSI'";
		
		$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
		
		$no_ba = $_REQUEST['no_ba'];
		$kd_urusan = $_REQUEST['kd_urusan'];
		$kd_kegiatan = $_REQUEST['kd_kegiatan'];
		$kd_akun = $_REQUEST['kd_akun'];
		
		
		if(!empty($no_ba)) $arrKondisi[] = " no_ba like '$no_ba%'";
		if(!empty($kd_urusan)) $arrKondisi[] = " kd_urusan like '$kd_urusan%'";
		if(!empty($kd_kegiatan)) $arrKondisi[] = " kd_kegiatan like '$kd_kegiatan%'";
		if(!empty($kd_akun)) $arrKondisi[] = " kd_akun like '$kd_akun%'";
		
		if( !empty($fmFiltTglBtw_tgl1)   ) $arrKondisi[] = " tgl_ba>='$fmFiltTglBtw_tgl1'";
		if( !empty($fmFiltTglBtw_tgl2)   ) $arrKondisi[] = " tgl_ba<='$fmFiltTglBtw_tgl2'";
		
		$cbxCekProgram = $_REQUEST["cbxCekProgram"];
		if($cbxCekProgram)	 $arrKondisi[] = " (p is null or p=0) ";
				
		$cbxCekBAST = $_REQUEST["cbxCekBAST"];		
		if($cbxCekBAST)	 $arrKondisi[] = " (no_ba is null or no_ba='' or no_ba = '-')  ";
		
		$cbxCekNoSPK = $_REQUEST["cbxCekNoSPK"];		
		if($cbxCekNoSPK)	 $arrKondisi[] = " (no_spk is null or no_spk='' or no_spk = '-')  ";
		
		$cbxCekTglSPK = $_REQUEST["cbxCekTglSPK"];		
		if($cbxCekTglSPK)	 $arrKondisi[] = " (tgl_spk is null or tgl_spk='' or tgl_spk = '0000-00-00')  ";
		
		$fmURUSAN = cekPOST('fmURUSAN');
		$fmBIDANG = cekPOST('fmBIDANG');
		$fmDINAS = cekPOST('fmDINAS');
		$fmKODE = cekPOST('fmKODE');
		$fmNMURUSAN = cekPOST('fmNMURUSAN');
		if(empty($fmURUSAN)) {
			$fmBIDANG = '0';
			$fmDINAS='0';
		}
		if(empty($fmBIDANG)) {
			$fmDINAS='0';
		}
		
		if(empty($fmURUSAN) && empty($fmBIDANG) && empty($fmDINAS))
		{
			
		}
		elseif(!empty($fmURUSAN) && empty($fmBIDANG) && empty($fmDINAS))
		{
			$arrKondisi[]= "bk =$fmURUSAN";
		}
		elseif(!empty($fmURUSAN) && !empty($fmBIDANG) && empty($fmDINAS))
		{
			$arrKondisi[]= "bk =$fmURUSAN and ck=$fmBIDANG";
		}
		elseif(!empty($fmURUSAN) && !empty($fmBIDANG) && !empty($fmDINAS))
		{
			$arrKondisi[]= "bk =$fmURUSAN and ck=$fmBIDANG and dk=$fmDINAS";		
		}
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " tgl_ba $Asc1 " ;break;
			case '2': $arrOrders[] = " no_ba $Asc1 " ;break;
			
		}	
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//$Order ="";
		//limit --------------------------------------
		/**$HalDefault=cekPOST($this->Prefix.'_hal',1);	//Cat:Settingan Lama				
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		**/
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
$bast = new bastObj();
?>