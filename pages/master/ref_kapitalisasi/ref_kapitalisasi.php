<?php

class ref_kapitalisasiObj  extends DaftarObj2{	
	var $Prefix = 'ref_kapitalisasi';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'v_ref_kapitalisasi'; //daftar
	var $TblName_Hapus = 'ref_kapitalisasi';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('f','g','h','i','j');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Kapitalisasi';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='Kapitalisasi.xls';
	var $Cetak_Judul = 'Kapitalisasi';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_kapitalisasiForm'; 
	var $kdbrg = '';	
			
	function setTitle(){
		return 'KAPITALISASI';
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
	$cek_buku = $Main->REF_KAPITAL_CEK;
	
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
     $kode1= $_REQUEST['fmf'];
	 $kode2= $_REQUEST['fmg'];
	 $kode3= $_REQUEST['fmh'];
	 $kode4= $_REQUEST['fmi'];
	 $kode5= $_REQUEST['fmj'];
	 
	 $kd1= $_REQUEST['f1'];
	 $kd2= $_REQUEST['g1'];
	 $kd3= $_REQUEST['h1'];
	 $kd4= $_REQUEST['i1'];
	 $kd5= $_REQUEST['j1'];
	 
	// $nama_barang = $_REQUEST['nm_barang'];
	 $nama_barang = $_REQUEST['nm_barang'];
	 $min_kapital = $_REQUEST['min_kapital'];
	 $tahun = $_REQUEST['tahun'];
	
	 
	 if( $err=='' && $kode1 =='' ) $kode1='00';
	 if( $err=='' && $kode2 =='' ) $kode2='00';
	 if( $err=='' && $kode3 =='' ) $kode3='00';
	 if( $err=='' && $kode4 =='' ) $kode4='00';
	 if( $err=='' && $kode5 =='' ) $kode5='000';
	 if( $err=='' && $min_kapital =='' ) $err= 'Minimal Kapitalisasi (Rp) Belum Di Isi !!';
	
		if($fmST == 0){
			if($cek_buku==1){
				
			$ck_baru5=mysql_fetch_array(mysql_query("Select count(*) as cnt from buku_induk where f='$kode1' and g ='$kode2' and h ='$kode3' and i='$kode4' and j='$kode5' and thn_perolehan ='$tahun'"));	
			$ck_baru6=mysql_fetch_array(mysql_query("Select count(*) as cnt from buku_induk where f='$kode1' and g ='$kode2' and h ='$kode3' and i='$kode4' and j='$kode5' and thn_perolehan >='$tahun'"));	
			if ($ck_baru5['cnt']>0){
				$err= 'Gagal Simpan kode barang sudah ada di PENATAUSAHAAN'.mysql_error();
			}elseif ($ck_baru5['cnt']>0 && $ck_baru5['g']=$kode2){
				$err= 'Gagal Simpan kode barang sudah ada di PENATAUSAHAAN'.mysql_error();	
			}elseif ($ck_baru5['cnt']>0 && $ck_baru5['g']=$kode2 && $ck_baru5['h']=$kode3 ) {
				$err= 'Gagal Simpan kode barang sudah ada di PENATAUSAHAAN'.mysql_error();	
			}elseif ($ck_baru5['cnt']>0 && $ck_baru5['g']=$kode2 && $ck_baru5['h']=$kode3  && $ck_baru5['i']=$kode4 ){
				$err= 'Gagal Simpan kode barang sudah ada di PENATAUSAHAAN'.mysql_error();	
			}elseif ($ck_baru5['cnt']>0 && $ck_baru5['g']=$kode2 && $ck_baru5['h']=$kode3  && $ck_baru5['i']=$kode4  && $ck_baru5['j']=$kode5 ){
				$err= 'Gagal Simpan kode barang sudah ada di PENATAUSAHAAN'.mysql_error();	
			}
			
			if ($ck_baru6['cnt']>0){
				$err= 'Gagal Simpan kode barang sudah ada di PENATAUSAHAAN
						Tahun Berlaku > Tahun Perolehan !!'.mysql_error();
			}
			
				
			$ck1=mysql_fetch_array(mysql_query("Select * from ref_kapitalisasi where f='$kode1' and g ='$kode2' and h ='$kode3' and i='$kode4' and j='$kode5' and tahun='$tahun'"));
			if ($ck1>=1)$err= 'Gagal Simpan kode barang sudah ada di tahun yang sama'.mysql_error();
			if($err==''){
					$aqry = "INSERT into ref_kapitalisasi (f,g,h,i,j,min_kapital,tahun) values('$kode1','$kode2','$kode3','$kode4','$kode5','$min_kapital','$tahun')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{
				
				if($err==''){
					$aqry = "INSERT into ref_kapitalisasi (f,g,h,i,j,min_kapital,tahun) values('$kode1','$kode2','$kode3','$kode4','$kode5','$min_kapital','$tahun')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}
			
			}else{
			if($cek_buku==1){
				/*$ck_Edit1=mysql_fetch_array(mysql_query("Select count(*) as cnt from buku_induk where f='$kode1' and thn_perolehan >='$tahun'")); $cek.="Select count(*) as cnt from buku_induk where f='$kode1' and thn_perolehan >='$tahun'";
				$ck_Edit2=mysql_fetch_array(mysql_query("Select count(*) as cnt from buku_induk where f='$kode1' and g ='$kode2' and thn_perolehan >='$tahun'"));
				$ck_Edit3=mysql_fetch_array(mysql_query("Select count(*) as cnt from buku_induk where f='$kode1' and g ='$kode2' and h ='$kode3' and thn_perolehan >='$tahun'"));
				$ck_Edit4=mysql_fetch_array(mysql_query("Select count(*) as cnt from buku_induk where f='$kode1' and g ='$kode2' and h ='$kode3' and i='$kode4' and thn_perolehan >='$tahun'"));
				$ck_Edit5=mysql_fetch_array(mysql_query("Select count(*) as cnt from buku_induk where f='$kode1' and g ='$kode2' and h ='$kode3' and i='$kode4' and j='$kode5' and thn_perolehan >='$tahun'"));
				if ($ck_Edit1['cnt']>0)$err= 'Gagal Edit kode barang sudah ada di PENATAUSAHAAN'.mysql_error();	
				if ($ck_Edit2['cnt']>0)$err= 'Gagal Edit kode barang sudah ada di PENATAUSAHAAN'.mysql_error();	
				if ($ck_Edit3['cnt']>0)$err= 'Gagal Edit kode barang sudah ada di PENATAUSAHAAN'.mysql_error();	
				if ($ck_Edit4['cnt']>0)$err= 'Gagal Edit kode barang sudah ada di PENATAUSAHAAN'.mysql_error();	
				if ($ck_Edit5['cnt']>0)$err= 'Gagal Edit kode barang sudah ada di PENATAUSAHAAN'.mysql_error();
			
				$ck1=mysql_fetch_array(mysql_query("Select * from ref_kapitalisasi where f='$kode1' and g ='$kode2' and h ='$kode3' and i='$kode4' and j='$kode5' and tahun='$tahun' and min_kapital='$min_kapital'"));
			if ($ck1>=1)$err= 'Gagal Simpan kode barang sudah ada di tahun yang sama'.mysql_error();*/
			
			$ck_baru5=mysql_fetch_array(mysql_query("Select count(*) as cnt from buku_induk where f='$kode1' and g ='$kode2' and h ='$kode3' and i='$kode4' and j='$kode5' and thn_perolehan ='$tahun'"));	
			$ck_baru6=mysql_fetch_array(mysql_query("Select count(*) as cnt from buku_induk where f='$kode1' and g ='$kode2' and h ='$kode3' and i='$kode4' and j='$kode5' and thn_perolehan >='$tahun'"));	
			if ($ck_baru5['cnt']>0){
				$err= 'Gagal Simpan kode barang sudah ada di PENATAUSAHAAN'.mysql_error();
			}elseif ($ck_baru5['cnt']>0 && $ck_baru5['g']=$kode2){
				$err= 'Gagal Simpan kode barang sudah ada di PENATAUSAHAAN'.mysql_error();	
			}elseif ($ck_baru5['cnt']>0 && $ck_baru5['g']=$kode2 && $ck_baru5['h']=$kode3 ) {
				$err= 'Gagal Simpan kode barang sudah ada di PENATAUSAHAAN'.mysql_error();	
			}elseif ($ck_baru5['cnt']>0 && $ck_baru5['g']=$kode2 && $ck_baru5['h']=$kode3  && $ck_baru5['i']=$kode4 ){
				$err= 'Gagal Simpan kode barang sudah ada di PENATAUSAHAAN'.mysql_error();	
			}elseif ($ck_baru5['cnt']>0 && $ck_baru5['g']=$kode2 && $ck_baru5['h']=$kode3  && $ck_baru5['i']=$kode4  && $ck_baru5['j']=$kode5 ){
				$err= 'Gagal Simpan kode barang sudah ada di PENATAUSAHAAN 5'.mysql_error();	
			}
			
			if ($ck_baru6['cnt']>0){
				$err= 'Gagal Simpan kode barang sudah ada di PENATAUSAHAAN
						Tahun Berlaku > Tahun Perolehan !!'.mysql_error();
			}
			
				
			$ck1=mysql_fetch_array(mysql_query("Select * from ref_kapitalisasi where f='$kode1' and g ='$kode2' and h ='$kode3' and i='$kode4' and j='$kode5' and tahun='$tahun'"));
			if ($ck1>=1)$err= 'Gagal Simpan kode barang sudah ada di tahun yang sama'.mysql_error();
			
				if($err==''){
				$aqry = "UPDATE ref_kapitalisasi SET f='$kode1' ,g ='$kode2' ,h ='$kode3' ,i='$kode4' ,j='$kode5' ,min_kapital='$min_kapital', tahun='$tahun' WHERE f='$kd1' and g='$kd2' and h='$kd3' and i='$kd4' and j='$kd5'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());
			
					}
			}else{
				if($err==''){
				$aqry = "UPDATE ref_kapitalisasi SET f='$kode1' ,g ='$kode2' ,h ='$kode3' ,i='$kode4' ,j='$kode5' ,min_kapital='$min_kapital', tahun='$tahun' WHERE f='$kd1' and g='$kd2' and h='$kd3' and i='$kd4' and j='$kd5' and concat (f,' ',g,' ',h,' ',i,' ',j)='".$idplh."'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());
			
					}
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
		
		case 'pilihBidang':{				
			global $Main;
			$f = $_REQUEST['fmf'];
			$g = $_REQUEST['fmg'];
			$h = $_REQUEST['fmh'];
			$i = $_REQUEST['fmi'];
			$j = $_REQUEST['fmj'];
			
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$queryg="SELECT g, concat(g, '. ', nm_barang) as vnama FROM ref_barang WHERE f='$f' and g!='00' and h='00' and i='00' and j='000'" ;$cek.=$queryg;
			$content->g=cmbQuery('fmg',$fmg,$queryg,'style="width:500px;"onchange="'.$this->Prefix.'.pilihKelompok()"','-------- Pilih Kode Kelompok ------------');
			
			$queryh="SELECT h, concat(h, '. ', nm_barang) as vnama FROM ref_barang WHERE f='$f' and g='$g' and h!='00' and i='00' and j='000'" ;$cek.=$queryh;
			$content->h=cmbQuery('fmh',$fmh,$queryh,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubKelompok()"','-------- Pilih Kode Sub Kelompok ----------------');
			
			$queryi="SELECT i, concat(i,' . ', nm_barang) as vnama  FROM ref_barang WHERE f='$f' and g='$g' and h='$h' and i!='00' and j='000'" ;$cek.=$querye;
			$content->i=cmbQuery('fmi',$fmi,$queryi,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubSubKelompok()"','-------- Pilih Kode Sub Sub Kelompok -----------------');
			
			$queryj="SELECT j, concat(j,' . ', nm_barang) as vnama FROM ref_skpd WHERE f='$f' and g='$g' and h = '$h' and i='$i' and j!='000'" ;$cek.=$queryj;
		
		$content->j=cmbQuery('fmj',$fmj,$queryj,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubSubSubKelompok()"','-------- Pilih Kode Sub Sub Sub Kelompok -----------------');
	
		/*$content->min_kapital='';
		$content->rp_kapital='0,00';*/
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}
			
		case 'pilihKelompok':{				
		global $Main;
			
			$f = $_REQUEST['fmf'];
			$g = $_REQUEST['fmg'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
	 
			$queryh="SELECT h, concat(h, '. ', nm_barang) as vnama FROM ref_barang WHERE f='$f' and g='$g' and h!='00' and i='00' and j='000'" ;$cek.=$queryh;
			$content->h=cmbQuery('fmh',$fmh,$queryh,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubKelompok()"','-------- Pilih Kode Sub Kelompok ----------------');
			
			$queryi="SELECT i, concat(i,' . ', nm_barang) as vnama  FROM ref_barang WHERE f='$f' and g='$g' and h='$h' and i!='00' and j='000'" ;$cek.=$queryi;
			$content->i=cmbQuery('fmi',$fmi,$queryi,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubSubKelompok()"','-------- Pilih Kode Sub Sub Kelompok -----------------');
			
			$queryj="SELECT j, concat(j,' . ', nm_barang) as vnama FROM ref_barang WHERE f='$f' and g='$g' and h='$h' and i='$i' and j!='000'" ;$cek.=$queryj;
			$content->j=cmbQuery('fmj',$fmj,$queryj,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubSubSubKelompok()"','-------- Pilih Kode Sub Sub Sub Kelompok -----------------');
			/*$content->min_kapital='';
			$content->rp_kapital='0,00';*/
	 		
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);											break;
			}	
			
			
		case 'pilihSubKelompok':{				
		global $Main;
			
			$f = $_REQUEST['fmf'];
			$g = $_REQUEST['fmg'];
			$h = $_REQUEST['fmh'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
	 
			$queryi="SELECT i, concat(i,' . ', nm_barang) as vnama  FROM ref_barang WHERE f='$f' and g='$g' and h='$h' and i!='00' and j='000'" ;$cek.=$queryi;
			$content->i=cmbQuery('fmi',$fmi,$queryi,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubSubKelompok()"','-------- Pilih Kode Sub Sub Kelompok -----------------');
			
			$queryj="SELECT j, concat(j,' . ', nm_barang) as vnama FROM ref_barang WHERE f='$f' and g='$g' and h='$h' and i='$i' and j!='000'" ;$cek.=$queryj;
			$content->j=cmbQuery('fmj',$fmj,$queryj,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubSubSubKelompok()"','-------- Pilih Kode Sub Sub Sub Kelompok -----------------');
			/*$content->min_kapital='';
			$content->rp_kapital='0,00';*/
			
	 		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);											break;
			}			
		
		case 'pilihSubSubKelompok':{				
		global $Main;
			
			$f = $_REQUEST['fmf'];
			$g = $_REQUEST['fmg'];
			$h = $_REQUEST['fmh'];
			$i = $_REQUEST['fmi'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
	 
			$queryj="SELECT j, concat(j,' . ', nm_barang) as vnama FROM ref_barang WHERE f='$f' and g='$g' and h='$h' and i='$i' and j!='000'" ;$cek.=$queryj;
			$content->j=cmbQuery('fmj',$fmj,$queryj,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubSubSubKelompok()"','-------- Pilih Kode Sub Sub Sub Kelompok -----------------');
			/*$content->min_kapital='';
			$content->rp_kapital='0,00';*/
			
	 		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);											break;
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
			 <script type='text/javascript' src='js/master/ref_kapitalisasi/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
			 ".
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".
			
			$scriptload;
	}
	
	//form ==================================
	function setFormBaru(){
		
	$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek =$cbid[0];				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$dt['readonly']='';
		$fmURUSAN = $_REQUEST['fmURUSAN'];
		$fmBIDANG = $_REQUEST['fmBIDANG'];
		$fmDINAS = $_REQUEST['fmDINAS'];
		$dt['f']=$_REQUEST['fmBIDANG'];
		$dt['g']=$_REQUEST['fmKELOMPOK'];
		$dt['h']=$_REQUEST['fmSUBKELOMPOK'];
		$dt['i']=$_REQUEST['fmSUBSUBKELOMPOK'];
		$dt['dk']='0';//$fmDINAS;
		
		$fm = $this->setForm($dt);		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormEdit(){
	global $Main;
	$cek_buku = $Main->REF_KAPITAL_CEK;	
	$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$f=$kode[0];
		$g=$kode[1];
		$h=$kode[2];
		$i=$kode[3];
		$j=$kode[4];
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  ref_kapitalisasi WHERE f='$f' and g='$g' and h='$h' and i='$i' and j='$j' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		
		if($cek_buku==1){
		$buku=mysql_fetch_array(mysql_query("Select count(*) as cnt from buku_induk where f='$f' and g ='$g' and h ='$h' and i='$i' and j='$j' and thn_perolehan >='".$dt['tahun']."'"));	
			$cek.="Select count(*) as cnt from buku_induk where f='$f' and g ='$g' and h ='$h' and i='$i' and j='$j' and thn_perolehan >='".$dt['tahun']."'";
				
			/*if($buku_induk=mysql_num_rows($buku)>0){
				$err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';	
			}elseif(mysql_num_rows($buku)>0 && $buku['g']=$dt['g']){
				$err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';	
			}elseif(mysql_num_rows($buku)>0 && $buku['g']=$dt['g'] && $buku['h']=$dt['h']){
				$err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';
			}elseif (mysql_num_rows($buku)>0 && $buku['g']=$dt['g'] && $buku['h']=$dt['h'] && $buku['i']=$dt['i']){
				$err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';
			}elseif (mysql_num_rows($buku)>0 && $buku['g']=$dt['g'] && $buku['h']=$dt['h'] && $buku['i']=$dt['i'] && $buku['j']=$dt['j']){
				$err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';
			}*/
			
			/*if($buku_induk=mysql_num_rows($buku)>0){
				$err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';	
			}elseif(mysql_num_rows($buku)>0 && $buku['g']=$dt['g']){
				$err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';	
			}elseif(mysql_num_rows($buku)>0 && $buku['g']=$dt['g'] && $buku['h']=$dt['h']){
				$err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';
			}elseif (mysql_num_rows($buku)>0 && $buku['g']=$dt['g'] && $buku['h']=$dt['h'] && $buku['i']=$dt['i']){
				$err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';
			}elseif (mysql_num_rows($buku)>0 && $buku['g']=$dt['g'] && $buku['h']=$dt['h'] && $buku['i']=$dt['i'] && $buku['j']=$dt['j']){
				$err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';
			}*/
			
			if ($buku['cnt']>0){
				$err= "Data tidak dapat di Edit kode barang '$f.$g.$h.$i.$j' sudah ada di PENATAUSAHAAN !!";
			}elseif ($buku['cnt']>0 && $buku['g']=$kode2){
				$err= "Data tidak dapat di Edit kode barang '$f.$g.$h.$i.$j' sudah ada di PENATAUSAHAAN !!";
			}elseif ($buku['cnt']>0 && $buku['g']=$kode2 && $buku['h']=$kode3 ) {
				$err= "Data tidak dapat di Edit kode barang '$f.$g.$h.$i.$j' sudah ada di PENATAUSAHAAN !!";
			}elseif ($buku['cnt']>0 && $buku['g']=$kode2 && $buku['h']=$kode3  && $buku['i']=$kode4 ){
				$err= "Data tidak dapat di Edit kode barang '$f.$g.$h.$i.$j' sudah ada di PENATAUSAHAAN !!";
			}elseif ($buku['cnt']>0 && $buku['g']=$kode2 && $buku['h']=$kode3  && $buku['i']=$kode4  && $buku['j']=$kode5 ){
				$err= "Data tidak dapat di Edit kode barang '$f.$g.$h.$i.$j' sudah ada di PENATAUSAHAAN !!";
			} 			
			
		
				/*$buku=mysql_query("select * from buku_induk where f='".$dt['f']."' and g='".$dt['g']."' and thn_perolehan >='".$dt['tahun']."'");
			if(mysql_num_rows($buku)>0) 
			
	
				$buku=mysql_query("select * from buku_induk where f='".$dt['f']."' and g='".$dt['g']."' and h='".$dt['h']."' and thn_perolehan >='".$dt['tahun']."'");
			if $err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';
			
	
				$buku=mysql_query("select * from buku_induk where f='".$dt['f']."' and g='".$dt['g']."' and h='".$dt['h']."' and i='".$dt['i']."' and thn_perolehan >='".$dt['tahun']."'");
			if(mysql_num_rows($buku)>0) $err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';
			
		
				$buku=mysql_query("select * from buku_induk where f='".$dt['f']."' and g='".$dt['g']."' and h='".$dt['h']."' and i='".$dt['i']."' and j='".$dt['j']."' and thn_perolehan='".$dt['tahun']."'");
			if(mysql_num_rows($buku)>0) $err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';*/
			
		
			
			if($err==''){
				$fm = $this->setForm($dt);
			}
			
			}else{
				$fm = $this->setForm($dt);	
			}
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
		
	}
	
	/*function setFormEdit(){
	global $Main;
	$cek_buku = $Main->REF_KAPITAL_CEK;	
	$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$f=$kode[0];
		$g=$kode[1];
		$h=$kode[2];
		$i=$kode[3];
		$j=$kode[4];
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  ref_kapitalisasi WHERE f='$f' and g='$g' and h='$h' and i='$i' and j='$j' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		
		if($cek_buku==1){
			$buku=mysql_query("select * from buku_induk where f='".$dt['f']."' and thn_perolehan >='".$dt['tahun']."'");
			$cek.="select * from buku_induk where f='".$dt['f']."' and thn_perolehan >='".$dt['tahun']."'";
				
			if($buku_induk=mysql_num_rows($buku)>0)	$err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';
			
			if($err==''){
				$buku=mysql_query("select * from buku_induk where f='".$dt['f']."' and g='".$dt['g']."' and thn_perolehan >='".$dt['tahun']."'");
			if(mysql_num_rows($buku)>0) $err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';
			
			}
			
			if($err==''){
				$buku=mysql_query("select * from buku_induk where f='".$dt['f']."' and g='".$dt['g']."' and h='".$dt['h']."' and thn_perolehan >='".$dt['tahun']."'");
			if(mysql_num_rows($buku)>0) $err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';
			
			}
			
			if($err==''){
				$buku=mysql_query("select * from buku_induk where f='".$dt['f']."' and g='".$dt['g']."' and h='".$dt['h']."' and i='".$dt['i']."' and thn_perolehan >='".$dt['tahun']."'");
			if(mysql_num_rows($buku)>0) $err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';
			
			}
			
			if($err==''){
				$buku=mysql_query("select * from buku_induk where f='".$dt['f']."' and g='".$dt['g']."' and h='".$dt['h']."' and i='".$dt['i']."' and j='".$dt['j']."' and thn_perolehan='".$dt['tahun']."'");
			if(mysql_num_rows($buku)>0) $err='Kode Barang Tidak bisa Edit sudah ada di PENATAUSAHAAN !!';
			
			}
			
			if($err==''){
				$fm = $this->setForm($dt);
			}
			
			}else{
				$fm = $this->setForm($dt);	
			}
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
		
	}*/
  	
	
	function Hapus($ids){ //validasi hapus tbl_sppd
	global $HTTP_COOKIE_VARS, $Main;;		
	$cek_buku = $Main->REF_KAPITAL_CEK;	
	
		$err=''; $cek='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		
		$co_c1=$HTTP_COOKIE_VARS['coURUSAN'];
		$co_c=$HTTP_COOKIE_VARS['coSKPD'];
		$co_d=$HTTP_COOKIE_VARS['coUNIT'];
		$co_e=$HTTP_COOKIE_VARS['coSUBUNIT'];
		$co_e1=$HTTP_COOKIE_VARS['coSEKSI'];
		
		if ($err ==''){
		for($i = 0; $i<count($ids); $i++){	
		//	05 17 01 01 001
		$t1 = substr($ids[$i], 0,2);
		$t2 = substr($ids[$i], 3,2);
		$t3 = substr($ids[$i], 6,2);
		$t4 = substr($ids[$i], 9,2);
		$t5 = substr($ids[$i], 12,3);
	
		if($cek_buku==1){
		$ck4=mysql_fetch_array(mysql_query("Select * from ref_kapitalisasi where f='$t1' and g ='$t2' and h ='$t3' and i='$t4' and j='$t5'"));
		$cek.="Select * from ref_kapitalisasi where f='$t1' and g ='$t2' and h ='$t3' and i='$t4' and j='$t5'";
		$buku=mysql_fetch_array(mysql_query("Select count(*) as cnt from buku_induk where f='".$ck4['f']."' and g ='".$ck4['g']."' and h ='".$ck4['h']."' and i='".$ck4['i']."' and j='".$ck4['j']."' and thn_perolehan >='".$ck4['tahun']."'"));
		$cek.="Select count(*) as cnt from buku_induk where f='".$ck4['f']."' and g ='".$ck4['g']."' and h ='".$ck4['h']."' and i='".$ck4['i']."' and j='".$ck4['j']."' and thn_perolehan >='".$ck4['tahun']."'";	
		
		if ($buku['cnt']>0){
				$err="Kode Barang '".$ck4['f'].'.'.$t2.'.'.$t3.'.'.$t4.'.'.$t5."'Tidak bisa Hapus sudah ada di PENATAUSAHAAN !!";
			}elseif ($buku['cnt']>0 && $buku['g']=$kode2){
				$err="Kode Barang '".$ck4['f'].'.'.$ck4['g'].'.'.$t3.'.'.$t4.'.'.$t5."'Tidak bisa Hapus sudah ada di PENATAUSAHAAN !!";
			}elseif ($buku['cnt']>0 && $buku['g']=$kode2 && $buku['h']=$kode3 ) {
				$err="Kode Barang '".$ck4['f'].'.'.$ck4['g'].'.'.$ck4['h'].'.'.$t4.'.'.$t5."'Tidak bisa Hapus sudah ada di PENATAUSAHAAN !!";
			}elseif ($buku['cnt']>0 && $buku['g']=$kode2 && $buku['h']=$kode3  && $buku['i']=$kode4 ){
				$err="Kode Barang '".$ck4['f'].'.'.$ck4['g'].'.'.$ck4['h'].'.'.$ck4['i'].'.'.$t5."'Tidak bisa Hapus sudah ada di PENATAUSAHAAN !!";
			}elseif ($buku['cnt']>0 && $buku['g']=$kode2 && $buku['h']=$kode3  && $buku['i']=$kode4  && $buku['j']=$kode5 ){
				$err="Kode Barang '".$ck4['f'].'.'.$ck4['g'].'.'.$ck4['h'].'.'.$ck4['i'].'.'.$ck4['j']."'Tidak bisa Hapus sudah ada di PENATAUSAHAAN !!";
			}else{
				if($err=='' ){
					$qy = "DELETE FROM ref_kapitalisasi WHERE f='$t1' and g='$t2' and h='$t3'  and  i='$t4' and j='$t5'";$cek.=$qy;
					$qry = mysql_query($qy);		
					}else{
						break;
					}
			}
			
			
			
			}else{
				if($err=='' ){
					$qy = "DELETE FROM ref_kapitalisasi WHERE f='$t1' and g='$t2' and h='$t3'  and  i='$t4' and j='$t5'";$cek.=$qy;
					$qry = mysql_query($qy);		
					}else{
						break;
					}	
			}
	
		}//for
		}
		return array('err'=>$err,'cek'=>$cek);
	}	
			
	function setForm($dt){	
	global $SensusTmp;
	
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 700;
	 $this->form_height = 180;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
		$tahun=$_COOKIE['coThnAnggaran'];
		$nip	 = '';
	  }else{
		$this->form_caption = 'Edit';			
		$readonly='readonly';
		$tahun=$dt['tahun'];	
					
	  }	
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		$kode1=genNumber($dt['f'],2);
		$kode2=genNumber($dt['g'],2);
		$kode3=genNumber($dt['h'],2);
		$kode4=genNumber($dt['i'],2);
		$kode5=genNumber($dt['j'],3);
		$nama_barang=$dt['nm_barang'];
		$min_kapital=$dt['min_kapital'];
	//	$tahun=$_COOKIE['coThnAnggaran'];
		
		$queryf="SELECT f, concat(f, '. ', nm_barang) as vnama FROM ref_barang where f!='00' and g='00' and h='00' and i='00' and j='000'";// $cek.=$queryf;
		$queryg="SELECT g,concat(g, '. ', nm_barang) as vnama FROM ref_barang where f='".$dt['f']."' and g!='00' and h='00' and i='00' and j='000'";
		$queryh="SELECT h,concat(h, '. ', nm_barang) as vnama FROM ref_barang where f='".$dt['f']."' and g='".$dt['g']."' and h!='00' and i='00' and j='000'";
		$queryi="SELECT i,concat(i, '. ', nm_barang) as vnama FROM ref_barang where f='".$dt['f']."' and g='".$dt['g']."' and h='".$dt['h']."' and i!='00' and j='000'";
		$queryj="SELECT j,concat(j, '. ', nm_barang) as vnama FROM ref_barang where f='".$dt['f']."' and g='".$dt['g']."' and h='".$dt['h']."' and i='".$dt['i']."' and j!='000'";
		
		
       //items ----------------------
		 $this->form_fields = array(
			'tahun' => array( 
						'label'=>'Tahun Berlaku',
						'labelWidth'=>200, 
						'value'=>"<input type='text' name='tahun' id='tahun' size='4' maxlength='4' value='".$tahun."'$readonly>",
						'row_params'=>"valign='top'",
						'type'=>'' 
									 ),				
		 
			'bidang' => array( 
						'label'=>'Bidang1',
						'labelWidth'=>120, 
						'value'=>"<div id='cont_f'>".cmbQuery('fmf',$dt['f'],$queryf,'style="width:500px;"onchange="'.$this->Prefix.'.pilihBidang()"','-------- Pilih Kode Bidang ------------')."</div>",
						 ),		
						 	
			'KELOMPOK' => array( 
						'label'=>'Kelompok',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_g'>".cmbQuery('fmg',$dt['g'],$queryg,'style="width:500px;"onchange="'.$this->Prefix.'.pilihKelompok()"','-------- Pilih Kode Kelompok -----------')."</div>",
						 ),
						 		 
			'SUBKELOMPOK' => array( 
						'label'=>'Sub Kelompok',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_h'>".cmbQuery('fmh',$dt['h'],$queryh,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubKelompok()"','-------- Pilih Kode Sub Kelompok ---------------')."</div>",
						 ),	
						 
			'SUBSUBKELOMPOK' => array( 
						'label'=>'Sub Sub Kelompok',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_i'>".cmbQuery('fmi',$dt['i'],$queryi,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubSubKelompok()"','-------- Pilih Kode Sub Sub Kelompok -----------------')."</div>",
						 ),		
			
			'SUBSUBSUBKELOMPOK' => array( 
						'label'=>'Sub Sub Sub Kelompok',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_j'>".cmbQuery('fmj',$dt['j'],$queryj,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubSubSubKelompok()"','-------- Pilih Kode Sub Sub Sub Kelompok -----------------')."</div>",
						 ),
						 
			'min_kapital' => array( 
						'label'=>'Minimal Kapitalisasi (Rp)',
						'labelWidth'=>120, 
						'value'=>"<input type='text' name='min_kapital' align='right' value='".floatval($dt['min_kapital'])."' id='min_kapital'   style='width:100px;text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`rp_kapital`).innerHTML = ref_kapitalisasi.formatCurrency(this.value);' /> Rp <span id='rp_kapital'>".number_format($dt['min_kapital'],2,",",".")."</span>"
						),
			);
		//tombol
		$this->form_menubawah =	
			"<input type='hidden' name='Id_skpd' id='Id_skpd'  value='".$Id."'>".
			"<input type=hidden id='f1' name='f1' value='".$kode1."'> ".
			"<input type=hidden id='g1' name='g1' value='".$kode2."'> ".
			"<input type=hidden id='h1' name='h1' value='".$kode3."'> ".
			"<input type=hidden id='i1' name='i1' value='".$kode4."'> ".
			"<input type=hidden id='j1' name='j1' value='".$kode5."'> ".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >".
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
	   <th class='th01' width='150' colspan='5'>Kode Barang</th>
	   <th class='th01' width='450' align='center'>Nama Barang</th>
	   <th class='th01' width='250' align='center'>Minimal Kapitalisasi (Rp.)</th>
	   <th class='th01' width='150' align='center'>Tahun Berlaku</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 if($isi['f']=='00' && $isi['g']=='00' && $isi['h']=='00' && $isi['i']=='00' && $isi['j']=='000'){
	 	$nama_barang='Semua Barang';
	 }else{
	 	$nama_barang=$isi['nm_barang'];
	 }
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $Koloms[] = array('align="center"',genNumber($isi['f'],2));
	 $Koloms[] = array('align="center"',genNumber($isi['g'],2));
	 $Koloms[] = array('align="center"',genNumber($isi['h'],2));
	 $Koloms[] = array('align="center"',genNumber($isi['i'],2));
	 $Koloms[] = array('align="center"',genNumber($isi['j'],3));
	 $Koloms[] = array('align="left"',$nama_barang);
	 $Koloms[] = array('align="right"',number_format($isi['min_kapital'],2,',','.'));
	 $Koloms[] = array('align="center"',$isi['tahun']);
	 
	 return $Koloms;
	}
	
	
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 

	$fmBIDANG = cekPOST('fmBIDANG');
	$fmKELOMPOK = cekPOST('fmKELOMPOK');
	$fmSUBKELOMPOK = cekPOST('fmSUBKELOMPOK');
	$fmSUBSUBKELOMPOK = cekPOST('fmSUBSUBKELOMPOK');
	$fmKODE = cekPOST('fmKODE');
	$fmBARANG = cekPOST('fmBARANG');
	$fmTAHUN = cekPOST('fmTAHUN');			
		
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
		
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr>
			<td style='width:150px'>BIDANG</td><td style='width:10px'>:</td>
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
			"</div>".
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Kode Barang : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' size=20px>&nbsp
				Nama Barang : <input type='text' id='fmBARANG' name='fmBARANG' value='".$fmBARANG."' size=30px>&nbsp
				Tahun : <input type='text' id='fmTAHUN' name='fmTAHUN' value='".$fmTAHUN."' maxlength='4' size=7px>&nbsp
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
			</table>".
			"</div>".
			"<input type='hidden' id='fmORDER18' name='fmORDER18' value='".$fmORDER18."'>".
			"<input type='hidden' id='fmORDER19' name='fmORDER19' value='".$fmORDER19."'>";			
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];			
		$fmBIDANG = $_REQUEST['fmBIDANG'];
		$fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
		$fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
		$fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];				
		$fmMERK = $_REQUEST['fmMERK'];
		$fmTYPE = $_REQUEST['fmTYPE'];		
		
		switch($fmPILCARI){
			case 'selectfg': $arrKondisi[] = " concat(f,g) like '%$fmPILCARIvalue%'"; break;		 	
			case 'selectbarang': $arrKondisi[] = " nama_barang like '%".$fmPILCARIvalue."%'"; break;
			case 'selecttahun': $arrKondisi[] = " tahun like '%".$fmPILCARIvalue."%'"; break;					 	
			
		}
		
		if(empty($fmBIDANG)) {
			$fmKELOMPOK = '';
			$fmSUBKELOMPOK='';
			$fmSUBSUBKELOMPOK='';
		}
		if(empty($fmKELOMPOK)) {
			$fmSUBKELOMPOK='';
			$fmSUBSUBKELOMPOK='';
		}
		if(empty($fmSUBKELOMPOK)) {		
			$fmSUBSUBKELOMPOK='';
		}		
		
		if(empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			//$arrKondisi[]= "f !=00 and g=00 and h=00 and i=00 and j=00";
		}
		elseif(!empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "f =$fmBIDANG"; //$arrKondisi[]= "f =$fmBIDANG and g!=00 and h=00 and i=00 and j=00";			
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "f =$fmBIDANG and g=$fmKELOMPOK";//$arrKondisi[]= "f =$fmBIDANG and g=$fmKELOMPOK and h!=00 and i=00 and j=00";			
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "f =$fmBIDANG and g=$fmKELOMPOK and h=$fmSUBKELOMPOK";//$arrKondisi[]= "f =$fmBIDANG and g=$fmKELOMPOK and h=$fmSUBKELOMPOK and i!=00 and j=00";				
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "f =$fmBIDANG and g=$fmKELOMPOK and h=$fmSUBKELOMPOK and i=$fmSUBSUBKELOMPOK";//$arrKondisi[]= "f =$fmBIDANG and g=$fmKELOMPOK and h=$fmSUBKELOMPOK and i=$fmSUBSUBKELOMPOK and j!=00";			
		}						
		if(!empty($_POST['fmKODE'])) $arrKondisi[] = " concat(f,g,h,i,j) like '%".str_replace('.','',$_POST['fmKODE'])."%'";					
		if(!empty($_POST['fmBARANG'])) $arrKondisi[] = " nm_barang like '%".$_POST['fmBARANG']."%'";
		
		if(!empty($_POST['fmTAHUN'])) $arrKondisi[] = " tahun like '%".$_POST['fmTAHUN']."%'";	

		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '': $arrOrders[] = " concat(f,g,h,i,j) ASC " ;break;
			case '1': $arrOrders[] = " concat(f,g,h,i,j) $Asc1 " ;break;
			case '2': $arrOrders[] = " nama_barang $Asc1 " ;break;
		
		}

			$Order= join(',',$arrOrders);	
			$OrderDefault = '';// Order By no_terima desc ';
			$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//}
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
$ref_kapitalisasi = new ref_kapitalisasiObj();

?>