<?php
class BIRMObj  extends DaftarObj2{	
	var $Prefix = 'BIRM';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_birm'; //daftar
	var $TblName_Hapus = 't_birm';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('pid');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'BIRMS';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'BIRM';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'BIRMForm'; 	
	var $PID = '';
			
	function setTitle(){
		return 'BIRMS';
	}
	function setMenuEdit(){		
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".formSinkron()","reload_f2.png","Sinkron",'Sinkronisasi dengan aplikasi BIRMS')."</td>".
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus').
			"</td>";
	}
	
	function setMenuView(){
		return "";
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
	/*function Simpan_Validasi($id){//id -> multi id with space delimiter
		$err ='';
		$kode_barang = explode(' ',$id);
		$f=$kode_barang[0];	
		$g=$kode_barang[1];
		$h=$kode_barang[2];	
		$i=$kode_barang[3];
		$j=$kode_barang[4];
				
		$quricoy="select count(*) as cnt from ref_barang where f='$f' and g='$g' and h<>'00' and i<>'00' and j<>'000'";
		$dt3 = mysql_fetch_array(mysql_query($quricoy));
		$korong = $dt3 ['cnt'];
		
		if($korong>0){
		
		$korong;
		$err = "ada kode barang tidak bisa di edit/hapus, karena masih ada rinciannya !";
		}
		
		if($err=='' && 
				mysql_num_rows(mysql_query(
					"select Id from buku_induk where f='$f' and g='$g' and h='$h' and i='$i' and j='$j' ")
				) >0 )
				
			{ $err = "GAGAL SIMPAN, Kode Barang Sudah Ada Di Buku Induk !!! ";}
			
				//$errmsg = "select Id from buku_induk where f='$f' and g='$g' and h='$h' and i='$j' and i='$j' ";
			
		return $err;
		
}*/
	function simpan(){
	 global $HTTP_COOKIE_VARS;
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
	 $nama_barang = $_REQUEST['nama_barang'];
	 $kode_account_at = $_REQUEST['kode_account_at'];
	 $kode_account_bm = $_REQUEST['kode_account_bm'];
	 $kode_account_ap = $_REQUEST['kode_account_ap'];
	 $nama_account = $_REQUEST['nama_account'];
	 $masa_manfaat = $_REQUEST['masa_manfaat'];	 
	 $residu = str_replace(",",".",$_REQUEST['residu']);
	 $cb=explode('.',$kode_barang);
	 $jml_data=count($cb);
	
	 //Mendapatkan kondisi untuk update 
	for($i=0;$cb[$i]!='00' && $i<$jml_data;$i++){
	 	switch($i){
			case '0': $kondisi="concat(f,g,h,i,j) Like '%".$cb[0]."%'"; break;
			case '1': $kondisi="concat(f,g,h,i,j) Like '%".$cb[0].$cb[1]."%'"; break;
			case '2': $kondisi="concat(f,g,h,i,j) Like '%".$cb[0].$cb[1].$cb[2]."%'"; break;
			case '3': $kondisi="concat(f,g,h,i,j) Like '%".$cb[0].$cb[1].$cb[2].$cb[3]."%'"; break;
			case '4': $kondisi="concat(f,g,h,i,j) Like '%".$cb[0].$cb[1].$cb[2].$cb[3].$cb[4]."%'"; break;		
		}
	 }
	 $kondisi="concat(f,g,h,i,j) Like '%".$cb[0].$cb[1].$cb[2].$cb[3].$cb[4]."%'";
	 $cek_barang=mysql_fetch_array(mysql_query("select count(*) as jml_barang from ref_barang where concat(f,g,h,i,j) = '".$cb[0].$cb[1].$cb[2].$cb[3].$cb[4]."'"));
	 if($err='' && $cek_barang>0) $err = 'Kode Barang yang sama/Sudah ada tidak bisa di simpan';
	 if($err=='' && $kode_barang =='' ) $err= 'Kode Barang belum diisi';
	  $kondisi="concat(f,g,h,i,j) Like '%".$cb[0].$cb[1].$cb[2].$cb[3].$cb[4]."%'";
	 $cek_barang=mysql_fetch_array(mysql_query("select count(*) as jml_barang from ref_barang where concat(f,g,h,i,j) = '".$cb[0].$cb[1].$cb[2].$cb[3].$cb[4]."'"));
	 if($err='' && $cek_barang>1) $err = 'Kode Barang yang sama/Sudah ada tidak bisa di simpan';
	 if($err=='' && $kode_barang =='' ) $err= 'Kode Barang Sudah ada di Penatausahaan';
	 	 
	 if(strlen($cb[0])!=2 || strlen($cb[1])!=2 || strlen($cb[2])!=2 || strlen($cb[3])!=2 || strlen($cb[4])!=$Main->KODEBARANGJ_DIGIT) $err= 'Format Kode barang salah';	 
	 //cek parent
	 /*if($err==''){
	 	$parent = '';
		for($j=0;$j<$jml_data;$j++){
			$parent .= ($parent<>'') ? '.'.$cb[$j] : $cb[$j];
		}
		$get = mysql_fetch_array(mysql_query("select count(*) as cnt where concat()='$parent'"))
	 }
	 */
	 
	 /*---------------------check validasi format kode barang---------------------*/
	 /*for($j=0;$j<$jml_data;$j++){
	 	if($j==0){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_barang where f!='00' and g ='00' and h ='00' and i ='00' and j ='$Main->KODEBARANGJ' Order By f DESC limit 1"));
			$kdakhir = sprintf("%02s",$ck['f']+1);
			if($cb[0]=='00') {
				$err= 'Format Kode barang salah';
			}
			elseif($cb[0]> $kdakhir ){ $err= "Format Kode Barang level 1 Harus berurutan ($kdakhir)";}
		}elseif($j==1){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_barang where f='".$cb[0]."' and g !='00' and h ='00' and i ='00' and j ='$Main->KODEBARANGJ' Order By g DESC limit 1"));			
			$kdakhir = sprintf("%02s",$ck['g']+1);
			if($cb[1]>$kdakhir) $err= "Format Kode Barang level 2 Harus berurutan ($kdakhir)";		
		}elseif($j==2){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_barang where f='".$cb[0]."' and g ='".$cb[1]."' and h !='00' and i ='00' and j ='$Main->KODEBARANGJ' Order By h DESC limit 1"));			
			$kdakhir = sprintf("%02s",$ck['h']+1);
			if($cb[0]!='00' && $cb[1]=='00' && $cb[2]!='00') {$err= 'Format Kode barang salah';}
			elseif($cb[2]>$kdakhir) {$err= "Format Kode Barang level 3 Harus berurutan ($kdakhir)";}		
		}elseif($j==3){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_barang where f='".$cb[0]."' and g ='".$cb[1]."' and h ='".$cb[2]."' and i !='00' and j ='$Main->KODEBARANGJ' Order By i DESC limit 1"));			
			$kdakhir = sprintf("%02s",$ck['i']+1);
			if($cb[0]!='00' && $cb[1]=='00' && $cb[2]=='00' && $cb[3]!='00') {$err= 'Format Kode barang salah';	}
			elseif($cb[0]!='00' && $cb[1]!='00' && $cb[2]=='00' && $cb[3]!='00') {$err= 'Format Kode barang salah';}
			elseif($cb[3]>$kdakhir) {$err= "Format Kode Barang level 4 Harus berurutan ($kdakhir)";}		
		}elseif($j==4){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_barang where f='".$cb[0]."' and g ='".$cb[1]."' and h ='".$cb[2]."' and i ='".$cb[2]."' and j !='$Main->KODEBARANGJ' Order By j DESC limit 1"));			
			$kdakhir = sprintf("%0".$Main->KODEBARANGJ_DIGIT."s",$ck['j']+1);
			//$kdakhir = sprintf("%02s",$ck['j']+1);
			if($cb[0]!='00' && $cb[1]=='00' && $cb[2]=='00' && $cb[3]=='00' && $cb[4]!=$Main->KODEBARANGJ) {$err= 'Format Kode barang salah';	}
			elseif($cb[0]!='00' && $cb[1]!='00' && $cb[2]=='00' && $cb[3]=='00' && $cb[4]!=$Main->KODEBARANGJ) {$err= 'Format Kode barang salah';}
			elseif($cb[0]!='00' && $cb[1]!='00' && $cb[2]!='00' && $cb[3]=='00' && $cb[4]!=$Main->KODEBARANGJ) {$err= 'Format Kode barang salah';}
			elseif($cb[4]>$kdakhir) {$err= "Format Kode Barang level 5 Harus berurutan ($kdakhir) !";}		
		}
	 }*/
 	 if($err=='' && $nama_barang =='' ) $err= 'Nama Barang belum diisi';	 	 
 	 //if($err=='' && $masa_manfaat =='' ) $err= 'Masa Manfaat belum diisi';
 	 //if($err=='' && $residu =='' ) $err= 'Residu belum diisi';	
 	 //if($err=='' && $kode_account_at =='' ) $err= 'Kode Aset Tetap belum diisi';	 	 	 
 	 //if($err=='' && $kode_account_bm =='' ) $err= 'Kode Belanja Modal belum diisi';	 	 	 
 	 //if($err=='' && $kode_account_ap =='' ) $err= 'Kode Akum Penyusutan belum diisi';	 	 	 
	 /*---------------------------------------------------------------------------*/
	 	 $cek .= "kondisi = ".$ck['f']."";	
	 
	 /*if($cb[0]=='00') $err= 'Format Kode barang salah';
	 if($cb[0]!='00' && $cb[1]=='00' && $cb[2]!='00') $err= 'Format Kode barang salah';
	 if($cb[0]!='00' && $cb[1]=='00' && $cb[2]=='00' && $cb[3]!='00') $err= 'Format Kode barang salah';
	 if($cb[0]!='00' && $cb[1]=='00' && $cb[2]=='00' && $cb[3]!='00' && $cb[4]!='00') $err= 'Format Kode barang salah';
	 if($cb[0]!='00' && $cb[1]=='00' && $cb[2]!='00' && $cb[3]=='00' && $cb[4]=='00') $err= 'Format Kode barang salah';
	 if($cb[0]!='00' && $cb[1]=='00' && $cb[2]!='00' && $cb[3]!='00' && $cb[4]=='00') $err= 'Format Kode barang salah';
	 if($cb[0]!='00' && $cb[1]=='00' && $cb[2]!='00' && $cb[3]!='00' && $cb[4]!='00') $err= 'Format Kode barang salah';
	 if($cb[0]!='00' && $cb[1]!='00' && $cb[2]=='00' && $cb[3]=='00' && $cb[4]!='00') $err= 'Format Kode barang salah';
	 if($cb[0]!='00' && $cb[1]!='00' && $cb[2]=='00' && $cb[3]!='00' && $cb[4]=='00') $err= 'Format Kode barang salah';
	 if($cb[0]!='00' && $cb[1]!='00' && $cb[2]=='00' && $cb[3]!='00' && $cb[4]!='00') $err= 'Format Kode barang salah';
	 if($cb[0]!='00' && $cb[1]!='00' && $cb[2]!='00' && $cb[3]=='00' && $cb[4]!='00') $err= 'Format Kode barang salah';*/
 	 	 	 	 	 	 
			if($fmST == 0){ //input ref_barang
				if($err==''){ 
						//memecah kode barang
						 $kode_barang = explode('.',$kode_barang);
						 $f=$kode_barang[0];	
						 $g=($kode_barang[1]=='')?"00":$kode_barang[1];
						 $h=($kode_barang[2]=='')?"00":$kode_barang[2];	
						 $i=($kode_barang[3]=='')?"00":$kode_barang[3];
						 $j=($kode_barang[4]=='')?"00":$kode_barang[4];
						 //memecah kode jurnal aset tetap
						 $kode_jurnal_at = explode('.',$kode_account_at);
						 $ka=$kode_jurnal_at[0];	
						 $kb=$kode_jurnal_at[1];
						 $kc=$kode_jurnal_at[2];	
						 $kd=$kode_jurnal_at[3];
						 $ke=$kode_jurnal_at[4];
						 //memecah kode jurnal belanja modal
						 $kode_jurnal_bm = explode('.',$kode_account_bm);
						 $m1=$kode_jurnal_bm[0];	
						 $m2=$kode_jurnal_bm[1];
						 $m3=$kode_jurnal_bm[2];	
						 $m4=$kode_jurnal_bm[3];
						 $m5=$kode_jurnal_bm[4];			 	 	  
						 $m6=$kode_jurnal_bm[5];
						 //memecah kode jurnal akum penyusutan
						 $kode_jurnal_ap = explode('.',$kode_account_ap);
						 $l1=$kode_jurnal_ap[0];	
						 $l2=$kode_jurnal_ap[1];
						 $l3=$kode_jurnal_ap[2];	
						 $l4=$kode_jurnal_ap[3];
						 $l5=$kode_jurnal_ap[4];			 	 	  
						 $l6=$kode_jurnal_ap[5];				 	 	  
						$aqry1 = "INSERT into ref_barang (f,g,h,i,j,nm_barang,ka,kb,kc,kd,ke,l1,l2,l3,l4,l5,l6,m1,m2,m3,m4,m5,m6,masa_manfaat,residu)
						"."values('$f','$g','$h','$i','$j','$nama_barang','$ka','$kb','$kc','$kd','$ke','$l1','$l2','$l3','$l4','$l5','$l6','$m1','$m2','$m3','$m4','$m5','$m6','$masa_manfaat','$residu')";	$cek .= $aqry1;	
						$qry = mysql_query($aqry1);						
						if($qry==FALSE)
						{ 
							$err="Kode Barang yang sama/Sudah ada tidak bisa di simpan";
						}else{
							$aqry2 = "UPDATE ref_barang
				        			  set ".
									  //" masa_manfaat ='$masa_manfaat',
									  
									  "
									  ka='$ka',
									  kb='$kb',
									  kc='$kc',
									  kd='$kd',
									  ke='$ke',
									  l1='$l1',
									  l2='$l2',
									  l3='$l3',
									  l4='$l4',
									  l5='$l5',
									  l6='$l6',
									  m1='$m1',
									  m2='$m2',
									  m3='$m3',
									  m4='$m4',
									  m5='$m5',
									  m6='$m6'".
									  //residu='$residu'".
						 			 "WHERE $kondisi";	$cek .= $aqry2;						
							$qry2 = mysql_query($aqry2);
						}
														
				}/*else{else{
					$err="Gagal menyimpan barang";
				}*/
			}elseif($fmST == 1){
			$quricoy="select count(*) as cnt from ref_barang where f='$f' and g='$g' and h='$h' and i='$i' and j='$j'";
		$dt3 = mysql_num_rows(mysql_query($quricoy));
		$queryold = "select * from ref_barang where concat(f,g,h,i,j) = '".$cb[0].$cb[1].$cb[2].$cb[3].$cb[4]."'";
		$old = mysql_fetch_array(mysql_query($queryold));
		if($old['nm_barang']!=$nama_barang){
		if($dt3 >0){
		$err = "ada kode barang tidak bisa di edit/hapus, Kode Barang Sudah Ada Di Buku Induk !";
		}	
	}
		if($err=='' && 
				mysql_num_rows(mysql_query(
					"select Id from buku_induk where f='$f' and g='$g' and h='$h' and i='$i' and j='$j'")
				) >0 )
				
			{ $err = "GAGAL SIMPAN, Kode Barang Sudah Ada Di Buku Induk !!! ";}
				if($err==''){
						 //memecah kode barang
						 $kode_barang = explode(' ',$idplh);
						 $f=$kode_barang[0];	
						 $g=$kode_barang[1];
						 $h=$kode_barang[2];	
						 $i=$kode_barang[3];
						 $j=$kode_barang[4];
						 //memecah kode jurnal aset tetap
						 $kode_jurnal_at = explode('.',$kode_account_at);
						 $ka=$kode_jurnal_at[0];	
						 $kb=$kode_jurnal_at[1];
						 $kc=$kode_jurnal_at[2];	
						 $kd=$kode_jurnal_at[3];
						 $ke=$kode_jurnal_at[4];
						 //memecah kode jurnal belanja modal
						 $kode_jurnal_bm = explode('.',$kode_account_bm);
						 $m1=$kode_jurnal_bm[0];	
						 $m2=$kode_jurnal_bm[1];
						 $m3=$kode_jurnal_bm[2];	
						 $m4=$kode_jurnal_bm[3];
						 $m5=$kode_jurnal_bm[4];			 	 	  
						 $m6=$kode_jurnal_bm[5];
						 //memecah kode jurnal akum penyusutan
						 $kode_jurnal_ap = explode('.',$kode_account_ap);
						 $l1=$kode_jurnal_ap[0];	
						 $l2=$kode_jurnal_ap[1];
						 $l3=$kode_jurnal_ap[2];	
						 $l4=$kode_jurnal_ap[3];
						 $l5=$kode_jurnal_ap[4];			 	 	  
						 $l6=$kode_jurnal_ap[5];				 	 	  
						$aqry2 = "UPDATE ref_barang
			        			  set nm_barang = '$nama_barang',".
								  //masa_manfaat ='$masa_manfaat',
								  " f='$f',
								  g='$g',
								  h='$h',
								  i='$i',
								  j='$j',
								  ka='$ka',
								  kb='$kb',
								  kc='$kc',
								  kd='$kd',
								  ke='$ke',
								  l1='$l1',
								  l2='$l2',
								  l3='$l3',
								  l4='$l4',
								  l5='$l5',
								  l6='$l6',
								  m1='$m1',
								  m2='$m2',
								  m3='$m3',
								  m4='$m4',
								  m5='$m5',
								  m6='$m6'".
								  //"	  residu='$residu'".
					 			 "WHERE concat(f,g,h,i,j)='".$f.$g.$h.$i.$j."'";	$cek .= $aqry2;
						$qry = mysql_query($aqry2);
						if($qry==FALSE)
						{ 
							$err="Gagal menyimpan barang";
						}else{
							/*$aqry2 = "UPDATE ref_barang
				        			  set ".
									  //" masa_manfaat ='$masa_manfaat',
									  "ka='$ka',
									  kb='$kb',
									  kc='$kc',
									  kd='$kd',
									  ke='$ke',
									  l1='$l1',
									  l2='$l2',
									  l3='$l3',
									  l4='$l4',
									  l5='$l5',
									  l6='$l6',
									  m1='$m1',
									  m2='$m2',
									  m3='$m3',
									  m4='$m4',
									  m5='$m5',
									  m6='$m6'".
									  //residu='$residu'".
						 			 "WHERE $kondisi";	$cek .= $aqry2;						
							$qry2 = mysql_query($aqry2);*/
						}
					}
		//return $errmsg;
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
		
		case 'formSinkron':{
			$get = $this->genFormSinkron();
			$err = $get['err'];
			$cek = $get['cek'];
			$content = $get['content'];				
			$json=TRUE;
			break;
		}		
		
		case 'formEdit':{				
			$fm = $this->setFormEdit();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		case 'Hapus':{				
			$fm = $this->Hapus_data();				
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

		case 'Sinkron':{
			//$content='tes';				
			$get = $this->Sinkron();
			//$get = $this->susut();
			$err = $get['err'];
			$cek = $get['cek'];
			$content = $get['content'];				
			$json=TRUE;
			break;
		}

	   	/*case 'Sinkron':{
		$cek='';	
		
		$json = file_get_contents("https://birms.bandung.go.id/api/pekerjaan/2017:2.10.01.01:1:10");
 		//$json = file_get_contents("http://123.231.253.228/atis/tesbirm.php");
		$obj = json_decode($json,true);
	    //$query_dlt = "TRUNCATE TABLE t_birm"; $cek.=$query_dlt;	
		mysql_query('delete from t_birm');
		mysql_query('delete from t_birm_pekerjaan');
		foreach($obj['data'] as $item) {
			$BIRMUnitID=explode('.',$item['unitID']);
			$c1 = $BIRMUnitID[0];		
			$c = $BIRMUnitID[1];
			$d = $BIRMUnitID[2];
			if($Main->URUSAN == 0){
				$GetSU = mysql_fetch_array(mysql_query("select * from ref_skpd_urusan where bk='$c1' and ck='$c' and dk='$d'"));
				$cek.="select * from ref_skpd_urusan where c='$c' and d='$d'";
				$BIRMC1= $GetSU['bk'];
				$BIRMC= $GetSU['ck'];
				$BIRMD= $GetSU['dk'];
			}else{
				$BIRMC1= $c1;
				$BIRMC= $c;
				$BIRMD= $d;			
			}		
       		$query = "INSERT INTO t_birm(pid,unitID,bast_no,bast_tgl,kode_pekerjaan,
						kontrak_no,kontrak_tgl,nama_unit_kerja,namakegiatan,namapekerjaan,
						namaprogram,nilaikontrak,sumberdana,sumberdanaid,suratpesanan_no,
						suratpesanan_tgl,c1,c,d) 
			       		VALUES ('".$item['pid']."', '".$item['unitID']."', '".$item['bast_no']."',
						'".$item['bast_tgl']."', '".$item['kodepekerjaan']."', '".$item['kontrak_no']."', 
						'".$item['kontrak_tgl']."', '".$item['nama_unit_kerja']."', '".$item['namakegiatan']."', 
						'".$item['namapekerjaan']."', '".$item['namaprogram']."', '".$item['nilaikontrak']."',
						'".$item['sumberdana']."', '".$item['sumberdanaid']."', '".$item['suratpesanan_no']."', 
						'".$item['suratpesanan_tgl']."', '$BIRMC1', '$BIRMC', '$BIRMD')";
			$cek.=$query;			
			mysql_query($query);
			
			$uraian=$item['uraian_pekerjaan'];
			foreach($uraian as $item2) {
				$query2 = "INSERT INTO t_birm_pekerjaan(ref_idbirm,id,nama,
							jumlah_barang_vol1,jumlah_barang_vol2,harga,satuan) 
				       		VALUES ('".$item['pid']."', '".$item2['id']."', '".$item2['nama']."',
							'".$item2['jumlah_barang_vol1']."', '".$item2['jumlah_barang_vol2']."', 
							'".$item2['harga']."', '".$item2['satuan']."')";
				$cek.=$query2;			
				mysql_query($query2);				
			}
	    }
		break;
	   }*/
	   
	   	case 'getdata':{
		$geterr='';

		$ref_pilihID = $_REQUEST['id'];
		
		//query cek ref penerimaan
		$get = mysql_fetch_array( mysql_query("select * from t_birm where pid='$ref_pilihID'"));
		if($get['ref_idterima']<>0 or $get['ref_idterima']<>"" or !empty($get['ref_idterima'])) {
			$geterr= "Tidak bisa dipilih, karena sudah Penerimaan";	
		}	
		/*$kode_barang=$get['f'].'.'.$get['g'].'.'.$get['h'].'.'.$get['i'].'.'.$get['j'];
		
		$fmThnAnggaran=  $_COOKIE['coThnAnggaran'];
			$kueri1="select max(thn_akun) as thn_akun from ref_jurnal where thn_akun <= '$fmThnAnggaran'";
			$tmax = mysql_fetch_array(mysql_query($kueri1));
			$kueri="select * from ref_jurnal 
					where thn_akun = '".$tmax['thn_akun']."' 
					and ka='".$get['m1']."' and kb='".$get['m2']."' 
					and kc='".$get['m3']."' and kd='".$get['m4']."'
					and ke='".$get['m5']."' and kf='".$get['m6']."'"; //echo "$kueri";
			$row=mysql_fetch_array(mysql_query($kueri));
						
			$kode_account =$row['ka'].".".$row['kb'].".".$row['kc'].".".$row['kd'].".".$row['ke'].".".$row['kf'];*/
						
		$content = array('ID'=>$ref_pilihID);
		$err = $geterr;	
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
	
	function windowShow($withForm=TRUE){
		global $HTTP_COOKIE_VARS;		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';		
		$form_name = $this->FormName;
		
		$fmURUSAN = $_REQUEST['fmURUSAN'];
		$fmSKPD = $_REQUEST['fmSKPD'];
		$fmUNIT = $_REQUEST['fmUNIT'];
		$fmSUBUNIT = $_REQUEST['fmSUBUNIT'];
		$fmSEKSI = $_REQUEST['fmSEKSI'];
	    setcookie("cofmURUSAN", $fmURUSAN);
	    setcookie("cofmSKPD", $fmSKPD);
	    setcookie("cofmUNIT", $fmUNIT);
		setcookie("cofmSEKSI", $fmSEKSI);
	    setcookie("cofmSUBUNIT", $fmSUBUNIT);

		//$FormContent = $this->genDaftarInitial($fmURUSAN,$fmSKPD,$fmUNIT,$fmSUBUNIT,$fmSEKSI);
		$FormContent = "<div style='height:2px;'>".$this->genDaftarInitial()."</div>";
		if($withForm){
			$params->tipe=1;
			//$params ="style='overfl'";
			$form= "<form name='$form_name' id='$form_name' method='post' action=''>".
				createDialog(
					$form_name.'_div', 
					$FormContent,
					$this->form_width,
					$this->form_height,
					'Pilih BIRM',
					'',
					"<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".
					"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height,
					'',$params
					).
				"</form>";
				
		}else{
			$form= 
				createDialog(
					$form_name.'_div', 
					$FormContent,
					$this->form_width,
					$this->form_height,
					'Pilih BIRM',
					'',
					"<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".
					"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height
				);
			
			
		}
		/*return $form;		
			$FormContent = $this->genDaftarInitial();
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						1400,
						600,
						'Pilih BIRM',
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
			);*/
			$content = $form;//$content = 'content';	
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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
			 <script type='text/javascript' src='js/birm/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			
			$scriptload;
	}
	
	function genDaftarInitial(){
		global $HTTP_COOKIE_VARS;
	
		$vOpsi = $this->genDaftarOpsi();
		$BIRMSkpdfmURUSAN = $_REQUEST['BIRMSkpdfmURUSAN']==''?$HTTP_COOKIE_VARS['cofmURUSAN']:$_REQUEST['BIRMSkpdfmURUSAN'];
		$BIRMSkpdfmSKPD = $_REQUEST['BIRMSkpdfmSKPD']==''?$HTTP_COOKIE_VARS['cofmSKPD']:$_REQUEST['BIRMSkpdfmSKPD'];
		$BIRMSkpdfmUNIT = $_REQUEST['BIRMSkpdfmUNIT']==''?$HTTP_COOKIE_VARS['cofmUNIT']:$_REQUEST['BIRMSkpdfmUNIT'];
		$BIRMSkpdfmSUBUNIT = $_REQUEST['BIRMSkpdfmSUBUNIT']==''?$HTTP_COOKIE_VARS['cofmSUBUNIT']:$_REQUEST['BIRMSkpdfmSUBUNIT'];
		$BIRMSkpdfmSEKSI = $_REQUEST['BIRMSkpdfmSEKSI']==''?$HTTP_COOKIE_VARS['cofmSEKSI']:$_REQUEST['BIRMSkpdfmSEKSI'];
		
		$divHal = "<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
							"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
						"</div>";
		switch($this->daftarMode){						
			case '1' :{ //detail horisontal
				$vdaftar = 
					"<table width='100%'><tr valign=top>
					<td style='width:$this->containWidth;'>".
						"<div id='{$this->Prefix}_cont_daftar' style='position:relative;width:$this->containWidth;overflow:auto' >"."</div>".
						$divHal.
					"</td>".
					"<td>".
						"<div id='{$this->Prefix}_cont_daftar_det' style=''>".$this->genTableDetail()."</div>".
					"</td>".
					"</tr></table>";
				break;
			}
			default :{
				$vdaftar = 
					"<div id='{$this->Prefix}_cont_daftar' style='position:relative;' >"."</div>".
					$divHal;					
				break;
			}
		}
		
		return		
			//$NavAtas.	
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>".
			"<input type='hidden' id='BIRMSkpdfmURUSAN' name='BIRMSkpdfmURUSAN' value='$BIRMSkpdfmURUSAN'>". 
			"<input type='hidden' id='BIRMSkpdfmSKPD' name='BIRMSkpdfmSKPD' value='$BIRMSkpdfmSKPD'>". 
			"<input type='hidden' id='BIRMSkpdfmUNIT' name='BIRMSkpdfmUNIT' value='$BIRMSkpdfmUNIT'>". 
			"<input type='hidden' id='BIRMSkpdfmSUBUNIT' name='BIRMSkpdfmSUBUNIT' value='$BIRMSkpdfmSUBUNIT'>". 
			"<input type='hidden' id='BIRMSkpdfmSEKSI' name='BIRMSkpdfmSEKSI' value='$BIRMSkpdfmSEKSI'>".
			"<input type='hidden' id='fmPenerimaan' name='fmPenerimaan' value='selectBelum'>".
			 				
				//$vOpsi['TampilOpt'].
			"</div>".	
			//"<div style='position:relative'>".
			$vdaftar.
			//"</div>".
			'';
	}	

	function Hapus_Data_After($id){
		$err = ''; $content=''; $cek='';
		$aqry= "delete from t_birm_pekerjaan where ref_idbirm not in (select pid from t_birm)"; $cek.=$aqry;
		$aqry2= "delete from t_birm_rekening where ref_idbirm not in (select pid from t_birm)"; $cek.=$aqry2;
		$qry = mysql_query($aqry);
		$qry2 = mysql_query($aqry2);
		if ($qry==FALSE){
			$err = 'Gagal Hapus Data';
		}		
		return array('err'=>$err, 'content'=>$content, 'cek'=>$cek);
	}
	
	function Hapus_Validasi($id){//id -> multi id with space delimiter
		$errmsg ='';
				
		if($errmsg=='' && 
				mysql_num_rows(mysql_query(
					"select pid from t_birm where pid='$id' and ref_idterima <> 0 and ref_idterima <> '' and ref_idterima is not null")
				) >0 )
				
			{ $errmsg = "GAGAL HAPUS, Data BIRM sudah ada penerimaan !!! ";}
			
				//$errmsg = "select Id from buku_induk where f='$f' and g='$g' and h='$h' and i='$j' and i='$j' ";
			
		return $errmsg;
		
}
 
	function genFormSinkron(){
		global $Main,$HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json = TRUE;	
		
		$form_name = $this->Prefix.'_form';				
		$this->form_width = 660;
		$this->form_height = 280;
		if ($this->form_fmST==0) {
			$this->form_caption = 'Sinkronisasi BIRMS';
			$nip = '';
		}else{
			$this->form_caption = 'Edit';			
			$nip = $dt['nip'];			
		}
					
		$arrKondisi = array();
		$Kondisi = '';
		$fmTahun = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$fmURUSAN = $_REQUEST['BIRMSkpdfmURUSAN'];
		$fmSKPD = $_REQUEST['BIRMSkpdfmSKPD'];
		$fmUNIT = $_REQUEST['BIRMSkpdfmUNIT'];
		$fmSUBUNIT = $_REQUEST['BIRMSkpdfmSUBUNIT'];
		//$fmSEKSI = $_REQUEST['BIRMSkpdfmSEKSI'];
		$fmLimit = 2;
		if($Main->URUSAN == 0){
			$GetSU = mysql_fetch_array(mysql_query("select * from ref_skpd_urusan where c='$fmSKPD' and d='$fmUNIT'"));
			$BIRMC1= $GetSU['bk'];
			$BIRMC= $GetSU['ck'];
			$BIRMD= $GetSU['dk'];
			$BIRME= '';	
		}else{
			$BIRMC1= $fmURUSAN;
			$BIRMC= $fmSKPD;
			$BIRMD= $fmUNIT;
			$BIRME= $fmUNIT;			
		}
					
		$arrUnit=array();
		if($BIRMC1!='00' and $BIRMC1 !='') $arrUnit[]= $BIRMC1;
		if($BIRMC!='00' and $BIRMC !='') $arrUnit[]= $BIRMC;
		if($BIRMD!='00' and $BIRMD !='') $arrUnit[]= $BIRMD;			
		if($BIRME!='00' and $BIRME !='') $arrUnit[]= $BIRME;	
		//if($fmSEKSI!='00' and $arrUnit !='') $arrUnit[]= $fmSEKSI;	
		$Unit= join('.',$arrUnit);	
		//$cek.=htmlspecialchars($Main->BIRMS_URL).":$Unit:0:100";
		//$get = mysql_fetch_array(mysql_query($aqry['content']));
		$cek.="url=".htmlspecialchars($Main->BIRMS_URL)."$fmTahun:$Unit:0:1:0";
		$json = file_get_contents(htmlspecialchars($Main->BIRMS_URL)."$fmTahun:$Unit:0:1:0");
 		//$json = file_get_contents(htmlspecialchars($Main->BIRMS_URL));
		$obj = json_decode($json,true);
		//$jmldata=0;
		//foreach($obj['data'] as $item) {
		//	$GetJD = mysql_fetch_array(mysql_query("select count(*) as jmlData from t_birm where pid='".$item['pid']."'"));	
		//	if($GetJD['jmlData']==0){
		//		$jmldata=$jmldata+1;
		//	}
		//}
		//$jmldata = $jmldata;//$obj['jmldata'];
		$jmldata = $obj['total'];
		//mysql_query('delete from t_birm');
		//mysql_query('delete from t_birm_pekerjaan');
		
		if($Main->URUSAN == 1){
			//urusan		
			if($fmURUSAN != '' && $fmURUSAN != NULL && $fmURUSAN !='0') {
				$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$fmURUSAN."' and c='00' "));
				$urusan = $get['nm_skpd'];	
			}
			//bidang		
			if($fmSKPD != '' && $fmSKPD != NULL && $fmSKPD !='00') {
				$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$fmURUSAN."' and c='".$fmSKPD."' and d='00' "));
				$bidang = $get['nm_skpd'];	
			}
			if($fmUNIT !='' && $fmUNIT != NULL && $fmUNIT !='00') {
				$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$fmURUSAN."' and c='".$fmSKPD."' and d='".$fmUNIT."' and e='00' "));
				$unit = $get['nm_skpd'];
			}
			if($fmSUBUNIT !='' && $fmSUBUNIT != NULL && $fmSUBUNIT !='00') {
				$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$fmURUSAN."' and c='".$fmSKPD."' and d='".$fmUNIT."' and e='".$fmSUBUNIT."' and e1='000' "));
				$subunit = $get['nm_skpd'];
			}
			if($fmSEKSI !='' && $fmSEKSI != NULL && $fmSEKSI !='000') {
				$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$fmURUSAN."' and c='".$fmSKPD."' and d='".$fmUNIT."' and e='".$fmSUBUNIT."' and e1='$fmSEKSI' "));
				$seksi = $get['nm_skpd'];
			}	
			$this->form_fields['urusan'] =  array(  'label'=>'URUSAN', 'value'=> $urusan, 'labelWidth'=>120, 'type'=>'' );
		}else{
			//bidang		
			if($fmSKPD != '' && $fmSKPD != NULL && $fmSKPD !='00') {
				$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$fmSKPD."' and d='00' "));
				$bidang = $get['nm_skpd'];	
			}
			if($fmUNIT !='' && $fmUNIT != NULL && $fmUNIT !='00') {
				$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$fmSKPD."' and d='".$fmUNIT."' and e='00' "));
				$unit = $get['nm_skpd'];
			}
			if($fmSUBUNIT !='' && $fmSUBUNIT != NULL && $fmSUBUNIT !='00') {
				$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$fmSKPD."' and d='".$fmUNIT."' and e='".$fmSUBUNIT."' and e1='000' "));
				$subunit = $get['nm_skpd'];
			}
			if($fmSEKSI !='' && $fmSEKSI != NULL && $fmSEKSI !='000') {
				$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$fmSKPD."' and d='".$fmUNIT."' and e='".$fmSUBUNIT."' and e1='$fmSEKSI' "));
				$seksi = $get['nm_skpd'];
			}			
			$this->form_fields['urusan'] =  array('label'=>'','value'=>'', 'type'=>'merge' );
		}
			
		//progress
		$progress = 
			"<div id='progressbox' style='display:none;'>".
			"<div id='progressbck' style='display:block;width:300px;height:4px;background-color:silver; margin: 6 5 0 0;float:left;border-radius: 3px;'>".
			"<div id='progressbar' style='height:2px;margin:1;width:0%;border-radius: 3px;background-color: green;'></div>".
			"</div>".
			"<div id ='progressloading' name='progressloading' style='float:left;'></div>".
			"<div id ='progressmsg' name='progressmsg' style='float:left;'></div>".
			"</div>".
			"<div id='daftaropsisusuterror_div' style='height: 0px; overflow-y: hidden;float:left;'>".
			"<div id ='progreserror' name='progreserror'></div>".
			"</div>".			
			"<input type='hidden' id='jmldata' name='jmldata' value='".$jmldata."'> ".
			"<input type='hidden' id='progbirm' name='progbirm' value='0'> ";
		
		$this->form_fields = array(				
			
			$this->form_fields['urusan'],
			'bidang' => array(  'label'=>'BIDANG', 'value'=> $bidang, 'labelWidth'=>120, 'type'=>'' ),
			'unit' => array(  'label'=>'SKPD', 'value'=> $unit, 'labelWidth'=>120, 'type'=>'' ),
			'subunit' => array(  'label'=>'UNIT', 'value'=> $subunit, 'labelWidth'=>120, 'type'=>'' ),
			//'seksi' => array(  'label'=>'SUBUNIT', 'value'=> $seksi, 'labelWidth'=>120, 'type'=>'' ),
			'tgl' => array(  'label'=>'Tahun Anggaran', 'value'=> $fmTahun, 'type'=>'' ),		
			'jml_data' => array( 'label'=>'Data BIRMS', 'value'=> "<span id='vjmldata' >". number_format( $jmldata ,0,',','.') ."</span> data", 'type'=>'' ),	
			'limit' => array(  'label'=>' Sinkronisasi per ', 'value'=> "<input type=number id='fmLimit' name='fmLimit' value='".$fmLimit."' style='width:50px;'> Data", 'type'=>'' ),
			'progress' => array( 'label'=>'', 'value'=> $progress, 'type'=>'merge' ),
			'error' => array( 'label'=>'', 'value'=> "Pesan Kesalahan<br> <textarea id='tmplpiderror' name='tmplpiderror' rows='6' cols='100' readonly></textarea>", 'type'=>'merge' ),			
			//'nip' => array( 'label'=>'NIP', 'value'=> $nip, 'labelWidth'=>120, 'type'=>'text' ),
			//'nama' => array( 'label'=>'Nama Pegawai', 'value'=>$dt['nama'], 'type'=>'text'  ),	
			//'jabatan' => array( 'label'=>'Jabatan', 'value'=>$dt['jabatan'], 'type'=>'text')	
		);
			
		//tombol
		$this->form_menubawah =
			"<input type=hidden id='c1' name='c1' value='".$fmURUSAN."'> ".
			"<input type=hidden id='c' name='c' value='".$fmSKPD."'> ".
			"<input type=hidden id='d' name='d' value='".$fmUNIT."'> ".
			"<input type=hidden id='e' name='e' value='".$fmSUBUNIT."'> ".
			"<input type=hidden id='e' name='e1' value='".$fmSEKSI."'> ".
			"<input type=hidden id='fmTahun' name='fmTahun' value='".$fmTahun."'> ".				
			
			"<input type='button' id='btproses' value='Proses' onclick ='".$this->Prefix.".Sinkron()' >&nbsp;".
			"<input type='button' id='btbatal' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		
		
		$form = $this->genForm();		
				
		$content = $form;//$content = 'content';
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}

	//form ==================================
	function setFormBaru(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdSUBUNIT'];
		$cek =$cbid[0];
				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$dt['readonly']='';
		$fmBIDANG = $_REQUEST['fmBIDANG'];
		$fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
		$fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
		$fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];		
		if(!empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.'.$fmSUBSUBKELOMPOK.'.';
		}		
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
   
  	function setFormEdit(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdSUBUNIT'];
		$cek =$cbid[0];
				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		//get data
		$f=$kode[0];
		$g=$kode[1]; 
		$h=$kode[2]; 
		$i=$kode[3]; 
		$j=$kode[4]; 
		$bulan=date('Y-m-')."1";
		//query ambil data ref_barang
		$aqry = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j)='".$f.'.'.$g.'.'.$h.'.'.$i.'.'.$j."'"; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$na_at=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='".$dt['ka']."' and kb='".$dt['kb']."' and kc='".$dt['kc']."' and kd='".$dt['kd']."' and ke='".$dt['ke']."'"));
		$na_bm=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='".$dt['m1']."' and kb='".$dt['m2']."' and kc='".$dt['m3']."' and kd='".$dt['m4']."' and ke='".$dt['m5']."'"));
		$na_ap=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='".$dt['l1']."' and kb='".$dt['l2']."' and kc='".$dt['l3']."' and kd='".$dt['l4']."' and ke='".$dt['l5']."'"));
		$dt['kode_barang']=$f.'.'.$g.'.'.$h.'.'.$i.'.'.$j;
		$dt['kode_account_at']=$dt['ka'].'.'.$dt['kb'].'.'.$dt['kc'].'.'.$dt['kd'].'.'.$dt['ke'].'.'.$dt['kf']; 
		$dt['kode_account_bm']=$dt['m1'].'.'.$dt['m2'].'.'.$dt['m3'].'.'.$dt['m4'].'.'.$dt['m5'].'.'.$dt['m6']; 
		$dt['kode_account_ap']=$dt['l1'].'.'.$dt['l2'].'.'.$dt['l3'].'.'.$dt['l4'].'.'.$dt['l5'].'.'.$dt['l6']; 
		$dt['nama_account_at']=$na_at['nm_account'];
		$dt['nama_account_bm']=$na_bm['nm_account'];
		$dt['nama_account_ap']=$na_ap['nm_account'];
		//$dt['readonly']='readonly';
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setForm($dt){	
	 global $SensusTmp, $Main;
	 $cek = ''; $err=''; $content=''; 
		
	 $json = TRUE;	//$ErrMsg = 'tes';
	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 650;
	 $this->form_height = 200;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU';
		$readonly='';
	  }else{
		$this->form_caption = 'EDIT';
		//$readonly='readonly';
	  }
	  				
 	    $username=$_REQUEST['username'];
		
		$lengthKodeBrg =  12 + $Main->KODEBARANGJ_DIGIT ;
		$sampleKodeBrg = "*00.00.00.00.".$Main->KODEBARANGJ ;
		
		//query ref_batal
		$queryKB = "SELECT f,nama_barang FROM ref_barang_persediaan where f !=0 and g=0";
		
		$dt['residu'] = $dt['residu'] == '' ?0: $dt['residu'];
		$dt['masa_manfaat'] = $dt['masa_manfaat'] == '' ?0: $dt['masa_manfaat'];
		
		
       //items ----------------------
		  $this->form_fields = array(
			'' => array( 
								'label'=>'Kode barang',
								'labelWidth'=>100, 
								'value'=>'<b>BIDANG/KELOMPOK/SUB KELOMPOK/SUB SUB KELOMPOK/BARANG</b>', 
								'type'=>'merge',
							 ),	

			'kode_barang' => array( 
								'label'=>'Kode barang',
								'labelWidth'=>100, 
								'value'=>"<input type='text' name='kode_barang' value='".$dt['kode_barang']."' maxlength='$lengthKodeBrg' size='17px' id='kode_barang'>&nbsp&nbsp  
									<font color=red>$sampleKodeBrg</font>" 
									 ),	
									 
			'nama_barang' => array( 
								'label'=>'Nama Barang',
								'labelWidth'=>100, 
								'value'=>$dt['nm_barang'], 
								'type'=>'text',
								'id'=>'nama_barang',
								'param'=>"style='width:250ppx;' size=50px"
									 ),	
/*
			'masa_manfaat' => array( 
								'label'=>'Masa Manfaat',
								'labelWidth'=>100, 
								'value'=>"<input type='text' name='masa_manfaat' value='".$dt['masa_manfaat']."' maxlength='4' size='8px' id='masa_manfaat' >&nbsp&nbsp  <font color=red>*tahun</font>" 
									 ),
									 

			'residu' => array( 
								'label'=>'Residu',
								'labelWidth'=>100, 
								'value'=>"<input type='text' name='residu' value='".str_replace(".",",",$dt['residu'])."' maxlength='6' size='5px' id='residu' onkeypress='return isNumberKey(event);'>&nbsp&nbsp  <font color=red>*percent (%)</font>" 
									 ),
*/									 										 										 
			'kode_at' => array( 
								'label'=>'Kode Aset Tetap',
								'labelWidth'=>100, 
								'value'=>"<input type='text' name='kode_account_at' value='".$dt['kode_account_at']."' size='10px' id='kode_account_at' readonly>&nbsp
										  <input type='text' name='nama_account_at' value='".$dt['nama_account_at']."' size='50px' id='nama_account_at' readonly>&nbsp
										  <input type='button' value='Cari' onclick ='".$this->Prefix.".CariJurnalAT()' title='Cari Jurnal Aset Tetap' >" 
									 ),	
			'kode_bm' => array( 
								'label'=>'Kode Belanja Modal',
								'labelWidth'=>100, 
								'value'=>"<input type='text' name='kode_account_bm' value='".$dt['kode_account_bm']."' size='10px' id='kode_account_bm' readonly>&nbsp
										  <input type='text' name='nama_account_bm' value='".$dt['nama_account_bm']."' size='50px' id='nama_account_bm' readonly>&nbsp
										  <input type='button' value='Cari' onclick ='".$this->Prefix.".CariJurnalBM()' title='Cari Jurnal Belanja Modal' >" 
									 ),
			'kode_ap' => array( 
								'label'=>'Kode Akum Penyusutan',
								'labelWidth'=>130, 
								'value'=>"<input type='text' name='kode_account_ap' value='".$dt['kode_account_ap']."' size='10px' id='kode_account_ap' readonly>&nbsp
										  <input type='text' name='nama_account_ap' value='".$dt['nama_account_ap']."' size='50px' id='nama_account_ap' readonly>&nbsp
										  <input type='button' value='Cari' onclick ='".$this->Prefix.".CariJurnalAP()' title='Cari Jurnal Akum Penyusutan' >" 
									 ),
			);
		//tombol
		$this->form_menubawah =	
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Batal kunjungan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function Sinkron(){
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;

		$fmTahun = $_REQUEST['fmTahun'];		
		$fmURUSAN = $_REQUEST['c1'];
		$fmSKPD = $_REQUEST['c'];
		$fmUNIT = $_REQUEST['d'];
		$fmSUBUNIT = $_REQUEST['e'];		
		//$fmSEKSI = $_REQUEST['e1'];	
		$prog = $_REQUEST['progbirm']; 
		$fmLimit = $_REQUEST['fmLimit'];
		$pidprevall = explode(",",$_REQUEST['pidprev']);
		$piderrorall = explode(",",$_REQUEST['piderror']);
		$piddball = $_REQUEST['piddb']==""?array():explode(",",$_REQUEST['piddb']);
		$pidsuccessall = $_REQUEST['pidsuccess']==""?array():explode(",",$_REQUEST['pidsuccess']);		

		//get SKPD
		if($Main->URUSAN == 0){
			$GetSU = mysql_fetch_array(mysql_query("select * from ref_skpd_urusan where c='$fmSKPD' and d='$fmUNIT'"));
			$BIRMC1= $GetSU['bk'];
			$BIRMC= $GetSU['ck'];
			$BIRMD= $GetSU['dk'];
			$BIRME= '';	
		}else{
			$BIRMC1= $fmURUSAN;
			$BIRMC= $fmSKPD;
			$BIRMD= $fmUNIT;
			$BIRME= $fmUNIT;			
		}
					
		$arrUnit=array();
		if($BIRMC1!='00' and $BIRMC1 !='') $arrUnit[]= $BIRMC1;
		if($BIRMC!='00' and $BIRMC !='') $arrUnit[]= $BIRMC;
		if($BIRMD!='00' and $BIRMD !='') $arrUnit[]= $BIRMD;			
		if($BIRME!='00' and $BIRME !='') $arrUnit[]= $BIRME;	
		//if($fmSEKSI!='00' and $arrUnit !='') $arrUnit[]= $fmSEKSI;	
		$Unit= join('.',$arrUnit);	
			
		$jml=$fmLimit;
		$cek.="url=".htmlspecialchars($Main->BIRMS_URL)."$fmTahun:$Unit:$prog:$fmLimit:0";
		//$cek.="url=".htmlspecialchars($Main->BIRMS_URL)."?get=$prog";
		//$json = file_get_contents(htmlspecialchars($Main->BIRMS_URL)."?get=$prog");
		$json = file_get_contents(htmlspecialchars($Main->BIRMS_URL)."$fmTahun:$Unit:$prog:$fmLimit:0");
 		//$json = file_get_contents("http://123.231.253.228/atis/tesbirm.php");
		$obj = json_decode($json,true);
	    //$query_dlt = "TRUNCATE TABLE t_birm"; $cek.=$query_dlt;
		$pidprev=array();
		$piderror=array();
		$piddb=array();
		$pidsuccess=array();
		$jml_data=0;	
		foreach($obj['data'] as $item) {			
			$BIRMUnitID=explode('.',$item['unitID']);
			$c1 = $BIRMUnitID[0];		
			$c = $BIRMUnitID[1];
			$d = $BIRMUnitID[2];
			$e = $BIRMUnitID[3];
			$GetJD = mysql_fetch_array(mysql_query("select count(*) as jmlData from t_birm where pid='".$item['pid']."'"));
			$kodepekerjaan=$item['kodepekerjaan'];

			//get nilai pada rincian rekening
			$jmlRekening=sizeof($kodepekerjaan);
			$get_jml_rekening=$item['nilaikontrak'];
			if($jmlRekening==1){
				$nilaikontrak=$item['nilaikontrak'];				
			}elseif(is_array($kodepekerjaan)){
				$cnt_nilai=0;
				$cnt_kode=0;
				$cnt_nama=0;
				$nilaikontrak=0;
				foreach($kodepekerjaan as $item4) {								
					if($item4['nilaispm']==""){
						$cnt_nilai++;		
					}
					$nilaikontrak+=$item4['nilaispm'];
				}
					
			}else{
				$nilaikontrak=$item['nilaikontrak'];
			}
			
			//simpan error ke tabel error birm
			$error_birm=array();
			if(in_array($item['pid'], $pidprevall)){
				$error_birm[]="PID double ";
			}
			if(empty($item['bast_no']) || empty($item['bast_tgl'])){
				$error_birm[]="bast_no null ";			
			}
			if(empty($item['kontrak_no']) || empty($item['kontrak_tgl'])){
				$error_birm[]="kontrak_no null ";				
			}
			if($cnt_nilai>0){
				$error_birm[]="nilai masih kosong ";
			}

			if($nilaikontrak != $item['nilaikontrak'] && is_array($kodepekerjaan)){
				$error_birm[]="nilai kontrak tidak sesuai ";			
			}
			$data_error_birm= join(',',$error_birm);
			
			//jika tidak ada error, pid akan di delete jika sudah ada di t_birm_error
			if(sizeof($error_birm)>0){
				$queryInsError = "INSERT INTO t_birm_error (urusan,pid,error) 
						       		VALUES ('".$BIRMC1."', '".$item['pid']."', '".$data_error_birm."')";
				mysql_query($queryInsError);				
			}else{
				//$queryDelError = "delete from t_birm_error where pid='".$item['pid']."'";
				//mysql_query($queryDelError);					
			}
							
			if(in_array($item['pid'], $pidprevall)){
				$piderror[]="PID ".$item['pid'].", sudah ada (double), ".$item['kontrak_no'].",$fmTahun:$Unit:$prog:$fmLimit \r\n";
				$jml_data--;
			}elseif(empty($item['bast_no']) || empty($item['bast_tgl'])){
				$piderror[]="PID ".$item['pid'].", belum ada tanggal/nomor BAST, ".$item['kontrak_no'].",$fmTahun:$Unit:$prog:$fmLimit \r\n";
			}elseif(empty($item['kontrak_no']) || empty($item['kontrak_tgl'])){
				$piderror[]="PID ".$item['pid'].", belum ada tanggal/nomor Kontrak, ".$item['kontrak_no'].", $fmTahun:$Unit:$prog:$fmLimit \r\n";
			}elseif($cnt_nilai>0){
				$piderror[]="PID ".$item['pid'].", nilai masih kosong pada salah satu kode pekerjaan, ".$item['kontrak_no'].", $fmTahun:$Unit:$prog:$fmLimit \r\n";
			}elseif($nilaikontrak != $item['nilaikontrak'] && is_array($kodepekerjaan)){
				$piderror[]="PID ".$item['pid'].", terdapat perbedaan nilai kontrak dengan jumlah nilai di rincian kode pekerjaan, ".$item['kontrak_no'].", ".$item['kontrak_no'].", $fmTahun:$Unit:$prog:$fmLimit \r\n";
			}elseif($GetJD['jmlData']>0){
				$piddb[]=$item['pid'];
				array_push($piddball,$item['pid']);
			}else{	
				if(is_array($kodepekerjaan)){
					$kdpekejaanbirm=$kodepekerjaan[0]['kode'];
				}else{
					$kdpekejaanbirm=$item['kodepekerjaan'];
				}
				
				if(empty($item['nilai_bast'])){
					$nilaibast = $item['nilaikontrak'];
				}else{
					$nilaibast = $item['nilai_bast'];
				}
				
	       		$query = "INSERT INTO t_birm(pid,unitID,bast_no,bast_tgl,kode_pekerjaan,
							kontrak_no,kontrak_tgl,nama_unit_kerja,namakegiatan,namapekerjaan,
							namaprogram,nilaikontrak,bast_nilai,sumberdana,sumberdanaid,suratpesanan_no,
							suratpesanan_tgl,c1,c,d,e,
							penyedia_id,nama_penyedia,alamat,kota,nama_pimpinan,no_npwp,
							nama_bank,norek_bank,atasnama_bank,penyedia_jabatan,
							nip,nama,jabatan,pangkat,gol,ruang,eselon,tgl_create,parameter) 
				       		VALUES ('".$item['pid']."', '".$item['unitID']."', '".$item['bast_no']."',
							'".$item['bast_tgl']."', '".$kdpekejaanbirm."', '".$item['kontrak_no']."', 
							'".$item['kontrak_tgl']."', '".$item['nama_unit_kerja']."', '".$item['namakegiatan']."', 
							'".$item['namapekerjaan']."', '".$item['namaprogram']."', '".$item['nilaikontrak']."','".$nilaibast."',
							'".$item['sumberdana']."', '".$item['sumberdanaid']."', '".$item['suratpesanan_no']."', 
							'".$item['suratpesanan_tgl']."', '$c1', '$c', '$d', '$e', 
							'".$item['penyedia_id']."','".$item['penyedia_nama']."', '".$item['penyedia_alamat']."', '".$item['penyedia_kotakabupaten']."', 
							'".$item['penyedia_pimpinan']."', '".$item['penyedia_npwp']."', '".$item['penyedia_banknama']."', 
							'".$item['penyedia_banknorekening']."', '', '".$item['penyedia_jabatan']."', '".$item['penerima_nip']."', 
							'".$item['penerima_nama']."', '".$item['penyedia_jabatan']."', '', 
							'', '', '',now(),'$fmTahun:$Unit:$prog:$fmLimit')";
				//$cek.=$query;			
				mysql_query($query);
				
				//get rincian pekerjaan
				$uraian=$item['uraian_pekerjaan'];
				foreach($uraian as $item2) {
					$query2 = "INSERT INTO t_birm_pekerjaan(ref_idbirm,id,nama,
								jumlah_barang_vol1,jumlah_barang_vol2,harga,satuan) 
					       		VALUES ('".$item['pid']."', '".$item2['id']."', '".$item2['nama']."',
								'".$item2['jumlah_barang_vol1']."', '".$item2['jumlah_barang_vol2']."', 
								'".$item2['harga']."', '".$item2['satuan']."')";
					//$cek.=$query2;			
					mysql_query($query2);				
				}
				
				//get rincian rekening
				$jml_rekening=$item['nilaikontrak'];
				if(is_array($kodepekerjaan)){
					foreach($kodepekerjaan as $item3) {								
						$kode=explode('.',$item3['kode']);
						$k=$kode[8];
						$l=$kode[9];
						$m=$kode[10];
						$n=$kode[11];
						$o=$kode[12];
						$query3 = "INSERT INTO t_birm_rekening(k,l,m,n,o,jumlah,ref_idbirm,rincian) 
						       		VALUES ('$k','$l','$m','$n','$o','".$item3['nilaispm']."', '".$item['pid']."', '".$item3['rincian']."')";
						//$cek.=$query3;		
						//$cek.="jml rekening = ".$jml_rekening."&".$item['nilaikontrak'];
						mysql_query($query3);				
						$jml_rekening=0;
					}					
				}else{
						$kode=explode('.',$kodepekerjaan);
						$k=$kode[8];
						$l=$kode[9];
						$m=$kode[10];
						$n=$kode[11];
						$o=$kode[12];
						$query3 = "INSERT INTO t_birm_rekening(k,l,m,n,o,jumlah,ref_idbirm,rincian) 
						       		VALUES ('$k','$l','$m','$n','$o','".$jml_rekening."', '".$item['pid']."', '".$item3['rincian']."')";
						//$cek.=$query3;		
						//$cek.="jml rekening = ".$jml_rekening."&".$item['nilaikontrak'];
						mysql_query($query3);									
				}					
			//$jml=$jml+1;		
			$pidsuccess[]=$item['pid'];		
			array_push($pidsuccessall,$item['pid']);
			}
		$jml_data++;
		$pidprev[]=$item['pid'];
		array_push($pidprevall,$item['pid']);
	    }
	
		$content->jml=$jml;//$jml;
		$content->pidprev=$pidprev; //pid sebelumnya
		$content->piderror=$piderror; //pid error sekarang
		$content->piddb=$piddb; //pid sebelumnya
		$content->pidsuccess=$pidsuccess; //pid error sekarang
		$content->pidprevall=$pidprevall; //array pid
		$content->piddball=sizeof($piddball);		
		$content->pidsuccessall=sizeof($pidsuccessall);
		return array('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}

		
	//daftar =================================	
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	 "<thead>
	 <tr>
	   <th class='th01' width='20' rowspan='2'>No.</th>
	   $Checkbox		
	   <th class='th01' align='center' rowspan='2' width='100'>Paket ID / <br>Unit Kerja</th>
   	   <th class='th01' align='center' rowspan='2' width='100'>No Bast /<br> Tgl Bast /<br> No Kontrak /<br> Tgl Kontrak /<br> No SP /<br> Tgl SP</th>	  
	   <!--<th class='th01' align='center' rowspan='2' width='100'>No Kontrak /<br> Tgl Kontrak</th>	  
	   <th class='th01' align='center' rowspan='2' width='100'>No SP /<br> Tgl SP</th>	-->
	   <th class='th01' align='center' rowspan='2' width='400'>Kode / <br>Nama Program / <br>Nama Kegiatan / <br>Nama Pekerjaan / <br>Sumber dana</th>
   	   <th class='th01' align='center' rowspan='2' width='100'>Nilai Kontrak</th>
   	   <th class='th01' align='center' rowspan='2' width='300'>Nama Barang</th>
   	   <th class='th01' align='center' rowspan='2' width='50'>Jumlah Barang vol 1</th>
   	   <th class='th01' align='center' rowspan='2' width='50'>Jumlah Barang vol 2</th>	 
   	   <th class='th01' align='center' rowspan='2' width='100'>Harga Satuan</th>
   	   <th class='th01' align='center' rowspan='2' width='100'>Jumlah Harga</th>
   	   <th class='th01' align='center' rowspan='2' width='50'>Satuan</th>	   
	 </tr>
	 <!--<tr>    
   	   <th class='th01' align='center'>No </th>	   	   	   	   	   
   	   <th class='th01' align='center'>Tanggal </th>		   
   	   <th class='th01' align='center'>No </th>	   	   	   	   	   
   	   <th class='th01' align='center'>Tanggal </th>		   
   	   <th class='th01' align='center'>No </th>	   	   	   	   	   
   	   <th class='th01' align='center'>Tanggal </th>		   
     </tr>-->
	   </thead>";
	
		return $headerTable;
	}	
	
	/*function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 global $Main;
	 
	 if($this->PID!=$isi['pid']){
		 $Koloms = array();
		 $Koloms[] = array('align="center" width="20"', $no.'.' );
		 if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 	 $Koloms[] = array('align="left" width="100"',$isi['unitID'].'</br> /'.$isi['nama_unit_kerja']);	 	 	 	 
	 	 $Koloms[] = array('align="left" width="75"',$isi['bast_no']);	 	 	 	 
	 	 $Koloms[] = array('align="center" width="50"',TglInd($isi['bast_tgl']));	 	 	 	 
	 	 $Koloms[] = array('align="left" width="75"',$isi['kontrak_no']);	 	 	 	 
	 	 $Koloms[] = array('align="center" width="50"',TglInd($isi['kontrak_tgl']));	
	  	 $Koloms[] = array('align="left" width="75"',$isi['suratpesanan_no']);	 	 	 	 
	 	 $Koloms[] = array('align="center" width="50"',TglInd($isi['suratpesanan_tgl']));	
	 	 $Koloms[] = array('align="left" width="75"',$isi['kode_pekerjaan']);	 	 	 	 	 	 	 
	 	 $Koloms[] = array('align="left" width="500"',$isi['namakegiatan'].'/<br>'.$isi['namaprogram'].'/<br>'.$isi['namapekerjaan']);	
	 	 $Koloms[] = array('align="right" width="100"',number_format($isi['nilaikontrak'],2,',','.' ));	 	 	 	 
	 	 $Koloms[] = array('align="left" width="50"',$isi['sumberdana']);	
	 	 $Koloms[] = array('align="left" width="200"',$isi['nama']);	 	
	  	 $Koloms[] = array('align="right" width="50"',$isi['jml_barang_vol1']);	 
	  	 $Koloms[] = array('align="right" width="50"',$isi['jml_barang_vol2']);	 
	 	 $Koloms[] = array('align="right" width="100"',number_format($isi['harga'],2,',','.' ));	 	
	 	 $Koloms[] = array('align="center" width="50"',$isi['satuan']);	 	 	
	 }else{
		 $Koloms = array();
		 $Koloms[] = array('align="center" width="20"', '' );
		 if ($Mode == 1) $Koloms[] = array(" align='center'  ", '');
	 	 $Koloms[] = array('align="left" width="100"','');	 	 	 	 
	 	 $Koloms[] = array('align="left" width="75"','');	 	 	 	 
	 	 $Koloms[] = array('align="center" width="50"','');	 	 	 	 
	 	 $Koloms[] = array('align="left" width="75"','');	 	 	 	 
	 	 $Koloms[] = array('align="center" width="50"','');	
	  	 $Koloms[] = array('align="left" width="75"','');	 	 	 	 
	 	 $Koloms[] = array('align="center" width="50"','');	
	 	 $Koloms[] = array('align="left" width="75"','');	 	 	 	 	 	 	 
	 	 $Koloms[] = array('align="left" width="500"','');	 	 	 	 	 	 	  	 	 
	 	 $Koloms[] = array('align="right" width="100"','');	 	 	 	 
	 	 $Koloms[] = array('align="left" width="50"','');	
	 	 $Koloms[] = array('align="left" width="200"',$isi['nama']);	 	
	  	 $Koloms[] = array('align="right" width="50"',$isi['jml_barang_vol1']);	 
	  	 $Koloms[] = array('align="right" width="50"',$isi['jml_barang_vol2']);	 
	 	 $Koloms[] = array('align="right" width="100"',number_format($isi['harga'],2,',','.' ));	 	
	 	 $Koloms[] = array('align="center" width="50"',$isi['satuan']);
	 	 	
	 }	
	 	 	  	 	 	 
 	 $this->PID=$isi['pid'];	 	 

	 return $Koloms;
	}*/

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 global $Main;
	 $noakhir = $this->noakhirnya;
	 $queryBIRM="select * from v1_birms where pid='".$isi['pid']."'";
	 $aqryBIRM=mysql_query($queryBIRM);
	 $Koloms='';
	 while ($isi2=mysql_fetch_array($aqryBIRM)){
		$totalHarga = $isi2['jumlah_barang_vol1']*$isi2['jumlah_barang_vol2']*$isi2['harga'];

		if($noakhir%2 == 0){
			$Koloms.='<tr class="row1" >';
		}else{
			$Koloms.='<tr class="row0" >';
		}
		 
		$cssclass = 'GarisCetak';
		if($Mode == 1)$cssclass = 'GarisDaftar';
		
		$queryBIRMR="select * from t_birm_rekening where ref_idbirm='".$isi['pid']."'";
		$aqryBIRMR=mysql_query($queryBIRMR);
		$jmlKdPekerjaan=mysql_num_rows($aqryBIRMR);  
		$KdPekerjaan = "";
		$jml=1;
		while($isi3=mysql_fetch_array($aqryBIRMR)){		
			if($jml==$jmlKdPekerjaan){
				$KdPekerjaan.= substr($isi2['kode_pekerjaan'],0,4).".".$isi2['unitID'].".".substr($isi2['kode_pekerjaan'],16,5).".".$isi3['k'].".".$isi3['l'].".".$isi3['m'].".".$isi3['n'].".".$isi3['o']."/";			
			}else{
				$KdPekerjaan.= substr($isi2['kode_pekerjaan'],0,4).".".$isi2['unitID'].".".substr($isi2['kode_pekerjaan'],16,5).".".$isi3['k'].".".$isi3['l'].".".$isi3['m'].".".$isi3['n'].".".$isi3['o']."<br>";							
			}
		$jml++;	
		} 
	 	if($this->PID!=$isi2['pid']){
			$Koloms.= "<td class='$cssclass'  width='20' align='center'>$no</td>";
			if($Mode == 1)$Koloms.= "<td class='$cssclass' width='20' align='center'>$TampilCheckBox</td>";
			$Koloms.= "<td class='$cssclass' width='100' align='left'>".$isi2['pid'].' /</br> '.$isi2['unitID'].' /</br> '.$isi2['nama_unit_kerja']."</td>";
			$Koloms.= "<td class='$cssclass' width='100' align='left'>".$isi2['bast_no'].' /</br> '.TglInd($isi2['bast_tgl']).' /</br> '.$isi2['kontrak_no'].'/</br> '.TglInd($isi2['kontrak_tgl']).' /</br> '.$isi2['suratpesanan_no'].'/</br> '.TglInd($isi2['suratpesanan_tgl'])."</td>";
			//$Koloms.= "<td class='$cssclass' width='100' align='left'>".$isi2['kontrak_no'].'/</br> '.TglInd($isi2['kontrak_tgl'])."</td>";
			//$Koloms.= "<td class='$cssclass' width='100' align='left'>".$isi2['suratpesanan_no'].'/</br> '.TglInd($isi2['suratpesanan_tgl'])."</td>";
			$Koloms.= "<td class='$cssclass' width='400' align='left'>".$KdPekerjaan.'<br>'.$isi2['namaprogram'].'/<br>'.$isi2['namakegiatan'].'/<br>'.$isi2['namapekerjaan'].'/<br>'.$isi2['sumberdana']."</td>";
			$Koloms.= "<td class='$cssclass' width='100' align='right'>".number_format($isi2['nilaikontrak'],2,',','.' )."</td>";
		}else{
			$Koloms.= "<td class='$cssclass' width='20' align='center'></td>";
			if($Mode == 1)$Koloms.= "<td class='$cssclass' width='20' align='center'></td>";			
			$Koloms.= "<td class='$cssclass' width='100' align='left'></td>";
			//$Koloms.= "<td class='$cssclass' width='100' align='left'></td>";
			//$Koloms.= "<td class='$cssclass' width='100' align='left'></td>";
			$Koloms.= "<td class='$cssclass' width='100' align='left'></td>";
			$Koloms.= "<td class='$cssclass' width='400' align='left'></td>";
			$Koloms.= "<td class='$cssclass' width='100' align='right'></td>";	
		}
		$Koloms.= "<td class='$cssclass' width='300' align='left'>".$isi2['nama']."</td>";	
		$Koloms.= "<td class='$cssclass' width='50' width='100' align='right'>".$isi2['jumlah_barang_vol1']."</td>";	
		$Koloms.= "<td class='$cssclass' width='50' align='right'>".$isi2['jumlah_barang_vol2']."</td>";	
		$Koloms.= "<td class='$cssclass' width='100' align='right'>".number_format($isi2['harga'],2,',','.' )."</td>";	
		$Koloms.= "<td class='$cssclass' width='100' align='right'>".number_format($totalHarga,2,',','.' )."</td>";
		$Koloms.= "<td class='$cssclass' width='50' align='center'>".$isi2['satuan']."</td>";	

		$Koloms.='</tr>';	
		$noakhir=$noakhir+1;
		$this->PID=$isi['pid']; 	 	
	 }
	 $this->noakhirnya=$noakhir;
 	 $this->PID="";	 	 
	 $Koloms = array(
	 	array("Y", $Koloms),
	 );

	 return $Koloms;
	}

	function genDaftar($Kondisi='', $Order='', $Limit='', $noAwal = 0, $Mode=1, $vKondisi_old=''){
		//$Mode -> 1. daftar, 2. cetak hal, 3.cetak all
		$cek =''; $err='';
					
		$MaxFlush=$this->MaxFlush;		
		$headerTable = $this->genDaftarHeader($Mode);		
		$TblStyle =	$this->TblStyle[$Mode-1];//$Mode ==1 ? 'koptable': 'cetak';
		$ListData = 
			"<table class='$TblStyle' border='1'   style='margin:4 0 0 0;width:100%'>".
			$headerTable.
			"<tbody>";
				
		$ColStyle = $this->ColStyle[$Mode-1];//$Mode==1? 'GarisDaftar':'GariCetak';			
		$no=$noAwal; $cb=0; $jmlDataPage =0;
		$TotalHalRp = 0;
		
		//$aqry = "select * from $this->TblName $Kondisi $Order $Limit ";	//echo $aqry;
		//$qry = mysql_query($aqry);
		$aqry = $this->setDaftar_query($Kondisi, $Order, $Limit); $cek .= $aqry.'<br>';
		$qry = mysql_query($aqry);
		$numrows = mysql_num_rows($qry); $cek.= " jmlrow = $numrows ";
		if( $numrows> 0 ) {
					
		while ( $isi=mysql_fetch_array($qry)){
			if ( $isi[$this->KeyFields[0]] != '' ){
				$isi = array_map('utf8_encode', $isi);	
				
				$no++;
				$jmlDataPage++;
				if($Mode == 1) $RowAtr = $no % 2 == 1? "class='row0'" : "class='row1'";
				
				$KeyValue = array();
				for ($i=0; $i< sizeof($this->KeyFields) ; $i++) {
					$KeyValue[$i] = $isi[$this->KeyFields[$i]];
				}
				$KeyValueStr = join($this->pemisahID,$KeyValue);
				$TampilCheckBox =  $this->setCekBox($cb, $KeyValueStr, $isi);//$Cetak? '' : 
					
				
				
				//sum halaman
				for ($i=0; $i< sizeof($this->FieldSum) ; $i++) {
					$this->SumValue[$i] += $isi[$this->FieldSum[$i]];
				}
				
				//---------------------------
				$rowatr_ = $RowAtr." valign='top' id='$cb' value='".$isi['Id']."'";
				$bef= $this->setDaftar_before_getrow(
						$no,$isi,$Mode, $TampilCheckBox,  
						$rowatr_,
						$ColStyle
						);
				$ListData .= $bef['ListData'];
				$no = $bef['no'];
				//get row
				$Koloms = $this->setKolomData($no,$isi,$Mode, $TampilCheckBox);	$cek .= $Koloms;		
				
				if($Koloms != NULL){
					
				
					$list_row = genTableRow($Koloms, 
								$rowatr_,
								$ColStyle);		
					
					
					$ListData .= $this->setDaftar_after_getrow($list_row, $isi , $no, $Mode, $TampilCheckBox,
						$RowAtr, $ColStyle);
					
					$cb++;
					
					if( ($Mode == 3 ) && ($cb % $MaxFlush==0) && $cb >0 ){				
						echo $ListData;
						ob_flush();
						flush();
						$ListData='';
						//sleep(2); //tes
					}
				}
			}
		}
		
		}
		
		$ListData .= $this->setDaftar_After($no, $ColStyle);
		//total -----------------------		
		if ($Mode==3) {	//flush
			echo $ListData;
			ob_flush();
			flush();
			$ListData='';			
			$SumHal = $this->genSumHal($Kondisi); 			
		}
		//$SumHal = $this->genSumHal($Kondisi);
		$ContentSum = $this->genRowSum($ColStyle,  $Mode, 
			$SumHal['sums']
		);
		/*$TampilTotalHalRp = number_format($TotalHalRp,2, ',', '.');		
		$TotalColSpan = $this->FieldSum_Cp1[$Mode-1];//$Mode ==1 ? 5 : 4;
		$ContentTotalHal =
			"<tr>
				<td class='$ColStyle' colspan='$TotalColSpan' align='center'><b>Total per Halaman</td>
				<td class='$ColStyle' align='right'><b>$TampilTotalHalRp</td>
				<td class='$ColStyle' colspan='4'></td>
			</tr>" ;
			
		$ContentTotal = 
				"<tr>
					<td class='$ColStyle' colspan='$TotalColSpan' align='center'><b>Total</td>
					<td class='$ColStyle' align='right'><b><div  id='cntDaftarTotal'>".$SumHal['sum']."</div></td>
					<td class='$ColStyle' colspan='4'></td>
				</tr>" ;
		
		if($Mode == 2){			
			$ContentTotal = '';
		}else if($Mode == 3){
			$ContentTotalHal='';			
		}
		$ContentSum=$ContentTotalHal.$ContentTotal;
		*/
		
		$ListData .= 
				//$ContentTotalHal.$ContentTotal.
				
				$ContentSum.
				"</tbody>".
			"</table>				
			<input type='hidden' id='".$this->Prefix."_jmldatapage' name='".$this->Prefix."_jmldatapage' value='$jmlDataPage'>
			<input type='hidden' id='".$this->Prefix."_jmlcek' name='".$this->Prefix."_jmlcek' value=''>"
			.$vKondisi_old
			;
		if ($Mode==3) {	//flush
			echo $ListData;	
		}
					
		return array('cek'=>$cek,'content'=>$ListData, 'err'=>$err);
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 

	$fmNoBAST = $_REQUEST['fmNoBAST'];	
	$fmNoKontrak = $_REQUEST['fmNoKontrak'];	
	$fmNoSP = $_REQUEST['fmNoSP'];
	$fmPenerimaan = $_REQUEST['fmPenerimaan'];				
	//$fmPILCARI = $_REQUEST['fmPILCARI'];	
	//$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//$fmORDER1 = cekPOST('fmORDER1');
	//$fmDESC1 = cekPOST('fmDESC1');
	
	
	 $arr = array(
			//array('selectAll','Semua'),
			array('selectfg','Kode Barang'),
			array('selectbarang','Nama Barang'),	
			);
			
	
	 $arrStatusPenerimaaan = array(
			//array('selectAll','Semua'),
			array('selectBelum','Belum Penerimaan'),
			array('selectSudah','Sudah Penerimaan'),	
			);			
		
		
	//data order ------------------------------
	 $arrOrder = array(
	  	         array('1','Kode Barang'),
			     array('2','Nama Barang'),	
	 );	
				
		$TampilOpt =
			"<table width=\"100%\" class=\"adminform\">	<tr>		
			<td width=\"100%\" valign=\"top\">			
				" . WilSKPD_ajx3($this->Prefix.'Skpd'). 
			"</td>
			<td style='padding:6'>
			</td>
			</tr>
			<tr><td>
			</td></tr></table>".
			"<table width=\"100%\" class=\"adminform\">	<tr>		
			<td width=\"100%\" valign=\"top\">			
			<input type='text' name='fmNoBAST' id='fmNoBAST' value='$fmNoBAST' placeholder='No BAST'>
			<input type='text' name='fmNoKontrak' id='fmNoKontrak' value='$fmNoKontrak' placeholder='No Kontrak'>
			<input type='text' name='fmNoSP' id='fmNoSP' value='$fmNoSP' placeholder='No SP'> Status Penerimaan : ".
			cmbArray('fmPenerimaan',$fmPenerimaan,$arrStatusPenerimaaan,'-- Semua --',''). //generate checkbox	
			"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td>
			<td style='padding:6'>
			</td>
			</tr>
			</table>";
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];			
		$fmNoBAST = htmlspecialchars($_REQUEST['fmNoBAST']);	
		$fmNoKontrak = htmlspecialchars($_REQUEST['fmNoKontrak']);	
		$fmNoSP = htmlspecialchars($_REQUEST['fmNoSP']);
		$fmPenerimaan = $_REQUEST['fmPenerimaan'];				
		
		switch($fmPILCARI){
			case 'selectfg': $arrKondisi[] = " concat(f,g) like '%$fmPILCARIvalue%'"; break;		 	
			case 'selectbarang': $arrKondisi[] = " nama_barang like '%".$fmPILCARIvalue."%'"; break;					 	
		}

		$BIRMSkpdfmURUSAN = $_REQUEST['BIRMSkpdfmURUSAN'];//ref_skpdSkpdfmSKPD		
		$BIRMSkpdfmSKPD = $_REQUEST['BIRMSkpdfmSKPD'];//ref_skpdSkpdfmSKPD
		$BIRMSkpdfmUNIT = $_REQUEST['BIRMSkpdfmUNIT'];
		$BIRMSkpdfmSUBUNIT = $_REQUEST['BIRMSkpdfmSUBUNIT'];
		$BIRMSkpdfmSEKSI = $_REQUEST['BIRMSkpdfmSEKSI'];
		
		
		if($BIRMSkpdfmURUSAN!='00' and $BIRMSkpdfmURUSAN !='')$arrKondisi[]= "c1='$BIRMSkpdfmURUSAN'";
		if($BIRMSkpdfmSKPD!='00' and $BIRMSkpdfmSKPD !='')$arrKondisi[]= "c='$BIRMSkpdfmSKPD'";
		if($BIRMSkpdfmUNIT!='00' and $BIRMSkpdfmUNIT !='')$arrKondisi[]= "d='$BIRMSkpdfmUNIT'";			
		if($fmNoBAST!='00' and $fmNoBAST !='')$arrKondisi[]= "bast_no LIKE '%$fmNoBAST%'";	
		if($fmNoKontrak!='00' and $fmNoKontrak !='')$arrKondisi[]= "kontrak_no LIKE '%$fmNoKontrak%'";	
		if($fmNoSP!='00' and $fmNoSP !='')$arrKondisi[]= "sp_no LIKE '%$fmNoSP%'";			
		switch($fmPenerimaan){			
			case 'selectBelum': $arrKondisi[] = " (ref_idterima=0 or ref_idterima='' or ref_idterima is null)"; break;
			case 'selectSudah': $arrKondisi[] = " ref_idterima <> 0 and ref_idterima <> '' and ref_idterima is not null"; break;	
								 	
		}
		//if($ref_skpdSkpdfmSUBUNIT!='00' and $ref_skpdSkpdfmSUBUNIT !='')$arrKondisi[]= "e='$ref_skpdSkpdfmSUBUNIT'";
		//if($ref_skpdSkpdfmSEKSI!='00' and $ref_skpdSkpdfmSEKSI !='')$arrKondisi[]= "e1='$ref_skpdSkpdfmSEKSI'";

		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			//case '': $arrOrders[] = " concat(f,g,h,i,j) ASC " ;break;
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
$BIRM = new BIRMObj();

?>