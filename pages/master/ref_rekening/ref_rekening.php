<?php

class ref_rekeningObj  extends DaftarObj2{	
	var $Prefix = 'ref_rekening';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_rekening'; //bonus
	var $TblName_Hapus = 'ref_rekening';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('k','l','m','n','o');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Rekening';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='ref_rekening.xls';
	var $namaModulCetak='MASTER DATA';
	var $Cetak_Judul = 'REKENING';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_rekeningForm';
	var $noModul=9; 
	var $TampilFilterColapse = 0; //0
	var $WHERE_O = "";
	
	function setTitle(){
		return 'REKENING';
	}
	
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Mapping()","publishdata.png","Mapping", 'Mapping')."</td>";
				
	}
	
	function setMenuView(){
		return 
		"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png",'Halaman',"Cetak Daftar per Halaman")."</td>".			
		"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakAll(\"$Op\")","print_f2.png",'Semua',"Cetak Semua Daftar")."</td>";
			
	}
	
	function simpanKB(){
	global $HTTP_COOKIE_VARS,$Main;
	$REK_DIGIT_O=$Main->REK_DIGIT_O;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$ka01= $_REQUEST['k'];
		$kb= $_REQUEST['l'];
		
		
		$nama= $_REQUEST['nama'];
	if( $err=='' && $nama =='' ) $err= 'Nama Kode Kelompok Belum Di Isi !!';
	if( $err=='' && $kb ==10 ) $err= 'Kode kelompok tidak bisa tambah baru !!';
		if($fmST == 0){
		if($REK_DIGIT_O==0){
			
			if($err==''){
				$aqry = "INSERT into ref_rekening (k,l,m,n,o,nm_rekening) values('$ka01','$kb','0','00','00','$nama')";	
				$cek .= $aqry;	
				$qry = mysql_query($aqry);
				$content=$kb;	
				}
			
		}else{
			
			if($err==''){
				$aqry = "INSERT into ref_rekening (k,l,m,n,o,nm_rekening) values('$ka01','$kb','0','00','000','$nama')";	
				$cek .= $aqry;	
				$qry = mysql_query($aqry);
				$content=$kb;	
				}
			
		}
			
			}
				
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function simpanEdit(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	
	$dk= $_REQUEST['k'];
	$dl= $_REQUEST['l'];
	$dm= $_REQUEST['m'];
	$dn= $_REQUEST['n'];
	$do= $_REQUEST['o'];
	$nama= $_REQUEST['nm_rekening'];
	
//Pengeluaran PFK - Beras (BULOG)
	//$ke = substr($ke,1,1);
	if( $err=='' && $nama =='' ) $err= 'Nama RINCIAN OBJEK Belum Di Isi !!';							
	if($err==''){						
		
	$aqry = "UPDATE ref_rekening set k='$dk',l='$dl',m='$dm',n='$dn',o='$do',nm_rekening='$nama' where concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
						$qry = mysql_query($aqry);
				}
								
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function simpanKD(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	
	$REK_DIGIT_O=$Main->REK_DIGIT_O;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$ka01= $_REQUEST['k'];
		$kb= $_REQUEST['l'];
		$kc= $_REQUEST['m'];
		$kd= $_REQUEST['n'];
		$nama= $_REQUEST['nama'];
		
	//	$kd = substr($kd,1,1);
	if( $err=='' && $nama =='' ) $err= 'Nama Kode Objek Belum Di Isi !!';
		if($fmST == 0){
		if($REK_DIGIT_O==0){
			if($err==''){
				$aqrykd = "INSERT into ref_rekening (k,l,m,n,o,nm_rekening) values('$ka01','$kb','$kc','$kd','00','$nama')";	
				$cek .= $aqrykd;	
				$qry = mysql_query($aqrykd);
				$content=$kd;	
				}
		}else{
			if($err==''){
				$aqrykd = "INSERT into ref_rekening (k,l,m,n,o,nm_rekening) values('$ka01','$kb','$kc','$kd','000','$nama')";	
				$cek .= $aqrykd;	
				$qry = mysql_query($aqrykd);
				$content=$kd;	
				}
		}
			
			}else{						
				if($err==''){
				$aqry = "UPDATE ref_jurnal set nama='$nama',ref_idjenis='$ref_idjenis',ref_idsatuan='$ref_idsatuan',merk='$merk' WHERE Id='".$idplh."'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());
				}
			} //end else
				
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function simpanKC(){
	global $HTTP_COOKIE_VARS,$Main;
	 
	 $REK_DIGIT_O=$Main->REK_DIGIT_O;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$ka01= $_REQUEST['k'];
		$kb= $_REQUEST['l'];
		$kc= $_REQUEST['m'];
		
		
		$nama= $_REQUEST['nama'];
	if( $err=='' && $nama =='' ) $err= 'Nama Kode Kelompok Belum Di Isi !!';
	if( $err=='' && $kc ==10 ) $err= 'Kode Jenis tidak bisa tambah baru !!';
		if($fmST == 0){
		
		if($REK_DIGIT_O==0){
				if($err==''){
				$aqry = "INSERT into ref_rekening (k,l,m,n,o,nm_rekening) values('$ka01','$kb','$kc','00','00','$nama')";	
				$cek .= $aqry;	
				$qry = mysql_query($aqry);
				$content=$kc;	
				}
		}else{
			if($err==''){
				$aqry = "INSERT into ref_rekening (k,l,m,n,o,nm_rekening) values('$ka01','$kb','$kc','00','000','$nama')";	
				$cek .= $aqry;	
				$qry = mysql_query($aqry);
				$content=$kc;	
				}
		}
			
			}
				
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
    /* $kode1= $_REQUEST['k'];	
	 $kode2= $_REQUEST['l'];
	 $kode3= $_REQUEST['m'];
	 $kode4= $_REQUEST['n'];
	 $kode5= $_REQUEST['o'];*/
	// $nama_rekening = $_REQUEST['nama_rekening'];
	 $nama_rekening = $_REQUEST['nama'];
	
	$k= $_REQUEST['fmKA'];
	$l= $_REQUEST['fmKB'];
	$m= $_REQUEST['fmKC'];
	$n= $_REQUEST['fmKD'];
	$o= $_REQUEST['ke'];
	 if( $err=='' && $k =='' ) $err= 'Kode Rekening Belum Di Isi !!';
	 if( $err=='' && $l =='' ) $err= 'Kode Kelompok Belum Di Isi !!';
	 if( $err=='' && $m =='' ) $err= 'Kode Jenis Belum Di Isi !!';
	 if( $err=='' && $n =='' ) $err= 'Kode Objek Belum Di Isi !!';
	 if( $err=='' && $o =='' ) $err= 'Kode Rincian Objek Belum Di Isi !!';
	 if( $err=='' && $nama_rekening =='' ) $err= 'nama rekening Belum Di Isi !!';
	 	
	
	// if($err=='' && $kode_skpd =='' ) $err= 'Kode Skpd belum diisi';	 
	// if(strlen($kode1)!=1 || strlen($kode2)!=1 || strlen($kode3)!=1 || strlen($kode4)!=2 ||strlen($kode5)!=2) $err= 'Format KODE salah';	
			/*for($j=0;$j<5;$j++){
	//urutan kode skpd 	
		if($j==0){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_rekening where k!='0' and l ='0' and m ='0' and n ='00' and o ='00' Order By k DESC limit 1"));
			if($kode1=='0') {$err= 'Format Kode Akun salah';}
			elseif($kode1!=5){ $err= 'Format Kode Akun salah';}
				
		}elseif($j==1){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_rekening where k='".$kode1."' and l !='0' and m ='0' and n ='00' and o ='00' Order By l DESC limit 1"));	
			if ($kode2>sprintf("%02s",$ck['l']+1)) {$err= 'Format Kode Kelompok Belanja Harus berurutan';}		
			
		}elseif($j==2){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_rekening where k='".$kode1."' and l ='".$kode2."' and m !='0' and n ='00' and o ='00' Order By m DESC limit 1"));			
			if ($kode3>sprintf("%02s",$ck['m']+1)) {$err= 'Format Kode Jenis Belanja Salah';}		
				
		}elseif($j==3){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_rekening where k='".$kode1."' and l ='".$kode2."' and m ='".$kode3."' and n!='00' and o='000' Order By n DESC limit 1"));	
			if ($kode4>sprintf("%02s",$ck['n']+1)) {$err= 'Format Kode Objek Belanja Harus berurutan';}
		
		}elseif($j==4){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_rekening where k='".$kode1."' and l ='".$kode2."' and m ='".$kode3."' and n ='".$kode4."' and o!='00' Order By o DESC limit 1"));	
			if ($kode5>sprintf("%02s",$ck['o']+1)) {$err= 'Format Kode SubObjek Belanja Harus berurutan';}
				
				
		}
	 }*/
	 
			
			
			if($fmST == 0){
		//	$ck1=mysql_fetch_array(mysql_query("Select * from ref_rekening where k='$kode1' and l ='$kode2' and m ='$kode3' and n='$kode4' and o='$kode5'"));
		//	if ($ck1>=1)$err= 'Gagal Simpan'.mysql_error();
				if($err==''){
		//			$aqry = "INSERT into ref_rekening (k,l,m,n,o,nm_rekening) values('$kode1','$kode2','$kode3','$kode4','$kode5','$nama_rekening')";	$cek .= $aqry;	
					$aqry = "INSERT into ref_rekening (k,l,m,n,o,nm_rekening) values('$k','$l','$m','$n','$o','$nama_rekening')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{						
				if($err==''){
				$aqry = "UPDATE ref_rekening SET nm_rekening='$nama_rekening' WHERE k='$kode1' and l='$kode2' and m='$kode3' and n='$kode4' and o='$kode5'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());
						
					}
			} //end else
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function simpanMapping(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
     $nama_rekening = $_REQUEST['nama'];
	
	$kode_rekening= $_REQUEST['kode_rekening'];
	$nm_rekening= $_REQUEST['nm_rekening'];
	$kode_akun= $_REQUEST['kode_akun'];
	$kode_mapping1= $_REQUEST['kode_mapping1'];
	$kode_mapping2= $_REQUEST['kode_mapping2'];
	
	 if( $err=='' && $kode_rekening =='' ) $err= 'Kode Rekening Belum Di Isi !!';
	 if( $err=='' && $kode_akun =='' ) $err= 'Kode Akun Belum Di Isi !!';
	 if( $err=='' && $kode_mapping1 =='' ) $err= 'Kode Mapping 1 Belum Di Isi !!';
	 if( $err=='' && $kode_mapping2 =='' ) $err= 'Kode Mapping 2 Belum Di Isi !!';
	
	$kode_rekening_at = explode('.',$kode_rekening);
						 $k=$kode_rekening_at[0];
						 $l=$kode_rekening_at[1];
						 $m=$kode_rekening_at[2];
						 $n=$kode_rekening_at[3];
						 $o=$kode_rekening_at[4];
						 
	$kode_jurnal1 = explode('.',$kode_akun);
						 $ka=$kode_jurnal1[0];
						 $kb=$kode_jurnal1[1];
						 $kc=$kode_jurnal1[2];
						 $kd=$kode_jurnal1[3];
						 $ke=$kode_jurnal1[4];
						 $kf=$kode_jurnal1[5];
						 
	$kode_jurnal2 = explode('.',$kode_mapping1);
						 $ka1=$kode_jurnal2[0];
						 $kb1=$kode_jurnal2[1];
						 $kc1=$kode_jurnal2[2];
						 $kd1=$kode_jurnal2[3];
						 $ke1=$kode_jurnal2[4];
						 $kf1=$kode_jurnal2[5];
						 
	$kode_jurnal3 = explode('.',$kode_mapping2);
						 $ka2=$kode_jurnal3[0];
						 $kb2=$kode_jurnal3[1];
						 $kc2=$kode_jurnal3[2];
						 $kd2=$kode_jurnal3[3];
						 $ke2=$kode_jurnal3[4];					 					 					 
						 $kf2=$kode_jurnal3[5];					 					 					 
	 	
	/*if($fmST == 0){
		if($err==''){
			$aqry = "INSERT into ref_rekening (k,l,m,n,o,nm_rekening) values('$k','$l','$m','$n','$o','$nama_rekening')";	$cek .= $aqry;	
			$qry = mysql_query($aqry);
				}*/
		//	}else{						
				if($err==''){
				$aqry = "UPDATE ref_rekening SET k='$k',l='$l',m='$m',n='$n',o='$o',ka='$ka',kb='$kb',kc='$kc',kd='$kd',ke='$ke',kf='$kf',ka1='$ka1',kb1='$kb1',kc1='$kc1',kd1='$kd1',ke1='$ke1',kf1='$kf1',ka2='$ka2',kb2='$kb2',kc2='$kc2',kd2='$kd2',ke2='$ke2',kf2='$kf2' WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());			
					}
		//	} 		
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

		case 'getdata':{
				$Id = $_REQUEST['id'];
				$k = substr($Id, 0,1);
				$l = substr($Id, 2,1);
				$m = substr($Id, 4,1);
				$n = substr($Id, 6,2);
				$o = substr($Id, 9,2);
				$get = mysql_fetch_array( mysql_query("select *, concat(k,'.',l,'.',m,'.',n,'.',o) as koderekening  from ref_rekening where k='$k' AND l='$l' AND m='$m' AND n='$n' AND o='$o'"));
		
				$content = array('kode_rekening' => $get['koderekening'], 'nm_rekening' => $get['nm_rekening']);	
		break;
	    }

		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
		break;
		}

		case 'pilihKA':{				
				$fm = $this->pilihKA();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}
		
		case 'pilihKB':{				
				$fm = $this->pilihKB();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}
			
		case 'pilihKC':{				
				$fm = $this->pilihKC();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}	
			
		case 'pilihKD':{				
				$fm = $this->pilihKD();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}					
				
		case 'formBaru':{				
			$fm = $this->setFormBaru();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'formBaruKB':{				
				$fm = $this->setFormBaruKB();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}	
		
		case 'formBaruKC':{				
				$fm = $this->setFormBaruKC();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}
		
		case 'formBaruKD':{				
				$fm = $this->setFormBaruKD();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}
		
		case 'getKode_o':{
			$get= $this->getKode_o();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		case 'formEdit':{				
			$fm = $this->setFormEdit();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'formMapping':{				
			$fm = $this->setFormMapping();				
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
		
		case 'simpanMapping':{
			$get= $this->simpanMapping();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'simpanKB':{
				$get= $this->simpanKB();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    	}
		
		case 'simpanKC':{
				$get= $this->simpanKC();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    	}
			
		case 'simpanKD':{
				$get= $this->simpanKD();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    	}
			
		case 'simpanEdit':{
			$get= $this->simpanEdit();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	   }	
				
		case 'refreshKB':{
				$get= $this->refreshKB();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    	}	
	   
	    case 'refreshKC':{
				$get= $this->refreshKC();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    	}
			
		case 'refreshKD':{
				$get= $this->refreshKD();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    	}		
	   	
		case 'simpan_k':{
				$get= $this->simpan_k();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    }
	
		case 'simpan_l':{
				$get= $this->simpan_l();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    }
		
		case 'simpan_m':{
				$get= $this->simpan_m();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    }
		
		case 'simpan_n':{
				$get= $this->simpan_n();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    }
		
		case 'simpan_o':{
				$get= $this->simpan_o();
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
		$idplh1 = explode(" ",$ids[$i]);	
		$data_k= $idplh1[0];
	 	$data_l= $idplh1[1];
		$data_m= $idplh1[2];
		$data_n= $idplh1[3];
		$data_o= $idplh1[4];
	//	$dta=mysql_fetch_array(mysql_query("select * from ref_potongan_spm where refid_potongan='".$ids[$i]."'"));
		
		$ref_bank=mysql_query("select * from ref_bank where k='".$data_k."' and l='".$data_l."' and m='".$data_m."' and n='".$data_n."' and o='".$data_o."'"); 
		$ref_potongan_spm=mysql_query("select * from ref_potongan_spm where k='".$data_k."' and l='".$data_l."' and m='".$data_m."' and n='".$data_n."' and o='".$data_o."'"); 
		
		if($err==''){
			if (mysql_num_rows($ref_bank)>0)$err='Kode Rekening Tidak bisa di Hapus sudah ada di Refensi Bank !!';
		}
		if($err==''){
			if (mysql_num_rows($ref_potongan_spm)>0)$err='Kode Rekening Tidak bisa di Hapus sudah ada di Refensi Potongan SPM !!';
		}
		
		if ($data_k != '0'){
			$sk1="select k,l,m,n,o from ref_rekening where k='$data_k' and l!='0'";
		}
		
		if ($data_l != '0'){
			$sk1="select k,l,m,n,o from ref_rekening where k='$data_k' and l='$data_l' and m!='0'";
		}
		
		if ($data_m != '0'){
			$sk1="select k,l,m,n,o from ref_rekening where k='$data_k'  and l='$data_l' and m='$data_m' and n!='00'";
		}
		if ($data_n != '00'){
			$sk1="select k,l,m,n,o from ref_rekening where k='$data_k'  and l='$data_l' and m='$data_m' and n='$data_n' and o!='000'";
		}
	//	$err='tes';
		if ($data_o=='000'){
			$qrycek=mysql_query($sk1);$cek.=$sk1;
			if(mysql_num_rows($qrycek)>0)$err='data tidak bisa di hapus';
		}
	
		if($err=='' ){
			$qy = "DELETE FROM ref_rekening WHERE k ='".$data_k."' and l='".$data_l."' and m='".$data_m."' and n='".$data_n."' and o='".$data_o."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		
		}//for
		}
		return array('err'=>$err,'cek'=>$cek);
	}
	
	function simpan_k(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	
	$REK_DIGIT_O=$Main->REK_DIGIT_O; 
	$uid = $HTTP_COOKIE_VARS['coID'];
	$cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	$fmST = $_REQUEST[$this->Prefix.'_fmST'];
 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
	$k= $_REQUEST['k'];
	$nama= $_REQUEST['nama'];
	
	if( $err=='' && $nama =='' ) $err= 'Nama Rekening Belum Di Isi !!';
	if($REK_DIGIT_O==0){
	if($err==''){
		$aqry = "UPDATE ref_rekening set nm_rekening='$nama' where k='$k' and l='0' and m='0' and n='00' and o='00' and concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
		$qry = mysql_query($aqry);
		}	
	
	}else{
	
	if($err==''){
		$aqry = "UPDATE ref_rekening set nm_rekening='$nama' where k='$k' and l='0' and m='0' and n='00' and o='000' and concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
		$qry = mysql_query($aqry);
		}	
	}	
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function simpan_l(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	
	$REK_DIGIT_O=$Main->REK_DIGIT_O; 
	$uid = $HTTP_COOKIE_VARS['coID'];
	$cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	$fmST = $_REQUEST[$this->Prefix.'_fmST'];
 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
	$k= $_REQUEST['k'];
	$l= $_REQUEST['l'];
	$nama= $_REQUEST['nama'];
	
	if( $err=='' && $nama =='' ) $err= 'Nama Kelompok Belum Di Isi !!';
	if($REK_DIGIT_O==0){	
	if($err==''){
		$aqry = "UPDATE ref_rekening set nm_rekening='$nama' where k='$k' and l='$l' and m='0' and n='00' and o='00' and concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
		$qry = mysql_query($aqry);
		}
	}else{
		if($err==''){
		$aqry = "UPDATE ref_rekening set nm_rekening='$nama' where k='$k' and l='$l' and m='0' and n='00' and o='000' and concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
		$qry = mysql_query($aqry);
		}
	}	
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function simpan_m(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	
	$REK_DIGIT_O=$Main->REK_DIGIT_O; 
	$uid = $HTTP_COOKIE_VARS['coID'];
	$cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	$fmST = $_REQUEST[$this->Prefix.'_fmST'];
 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
	$k= $_REQUEST['k'];
	$l= $_REQUEST['l'];
	$m= $_REQUEST['m'];
	$nama= $_REQUEST['nama'];
	
	if( $err=='' && $nama =='' ) $err= 'Nama Jenis Belum Di Isi !!';
	if($REK_DIGIT_O==0){	
	if($err==''){
		$aqry = "UPDATE ref_rekening set nm_rekening='$nama' where k='$k' and l='$l' and m='$m' and n='00' and o='00' and concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
		$qry = mysql_query($aqry);
		}
	}else{
		if($err==''){
		$aqry = "UPDATE ref_rekening set nm_rekening='$nama' where k='$k' and l='$l' and m='$m' and n='00' and o='000' and concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
		$qry = mysql_query($aqry);
		}
	}	
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function simpan_n(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	
	$REK_DIGIT_O=$Main->REK_DIGIT_O; 
	$uid = $HTTP_COOKIE_VARS['coID'];
	$cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	$fmST = $_REQUEST[$this->Prefix.'_fmST'];
 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
	$k= $_REQUEST['k'];
	$l= $_REQUEST['l'];
	$m= $_REQUEST['m'];
	$n= $_REQUEST['n'];
	$nama= $_REQUEST['nama'];
	
	if( $err=='' && $nama =='' ) $err= 'Nama Objek Belum Di Isi !!';
	if($REK_DIGIT_O==0){	
	if($err==''){
		$aqry = "UPDATE ref_rekening set nm_rekening='$nama' where k='$k' and l='$l' and m='$m' and n='$n' and o='00' and concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
		$qry = mysql_query($aqry);
		}
	}else{
		if($err==''){
		$aqry = "UPDATE ref_rekening set nm_rekening='$nama' where k='$k' and l='$l' and m='$m' and n='$n' and o='000' and concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
		$qry = mysql_query($aqry);
		}
	}	
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function simpan_o(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	
	$REK_DIGIT_O=$Main->REK_DIGIT_O; 
	$uid = $HTTP_COOKIE_VARS['coID'];
	$cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	$fmST = $_REQUEST[$this->Prefix.'_fmST'];
 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
	$k= $_REQUEST['k'];
	$l= $_REQUEST['l'];
	$m= $_REQUEST['m'];
	$n= $_REQUEST['n'];
	$o= $_REQUEST['o'];
	$nama= $_REQUEST['nama'];
	
	if( $err=='' && $nama =='' ) $err= 'Nama Rincian Objek Belum Di Isi !!';
	if($REK_DIGIT_O==0){	
	if($err==''){
		$aqry = "UPDATE ref_rekening set nm_rekening='$nama' where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
		$qry = mysql_query($aqry);
		}
	}else{
		if($err==''){
		$aqry = "UPDATE ref_rekening set nm_rekening='$nama' where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
		$qry = mysql_query($aqry);
		}
	}	
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	/*function simpan_l(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
	$uid = $HTTP_COOKIE_VARS['coID'];
	$cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	$fmST = $_REQUEST[$this->Prefix.'_fmST'];
 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
	$k= $_REQUEST['k'];
	$l= $_REQUEST['l'];
	$nama= $_REQUEST['nama'];
	
	 if( $err=='' && $nama =='' ) $err= 'Nama Kelompok Belum Di Isi !!';
		
	if($err==''){
		$aqry = "UPDATE ref_rekening set nm_rekening='$nama' where k='$k' and l='$l' and m='0' and n='00' and o='000' and concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
		$qry = mysql_query($aqry);
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }*/

	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';		
		$form_name = $this->FormName;
		$ref_jenis=$_GET['status_filter'];
		$status_filter=1;
		//if($err==''){
			$FormContent = $this->genDaftarInitial(1);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						900,
						500,
						'Pilih Barang',
						'',
						"<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='CariBarang_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
						"<input type='hidden' id='CariBarang_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
		//}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

   function setFormBaruKB(){
		$dt=array();
		$this->form_fmST = 0;
		
		$fm = $this->BaruKB($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormBaruKC(){
		$dt=array();
		$this->form_fmST = 0;
		
		$fm = $this->BaruKC($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormBaruKD(){
		$dt=array();
		$this->form_fmST = 0;
		
		$fm = $this->BaruKD($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
   
  function pilihKA(){
	global $Main;	 
	$REK_DIGIT_O=$Main->REK_DIGIT_O;
	
	$ka = $_REQUEST['fmKA'];
	$kb = $_REQUEST['fmKB'];
	$cek = ''; $err=''; $content=''; $json=TRUE;
		
	if($REK_DIGIT_O==0){
		$queryl="SELECT l, concat(l, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l!='0' and m = '0' and n='00' and o='00'" ;$cek.=$queryl;
		$content->kb=cmbQuery('fmKB',$fmkb,$queryl,'style="width:500;"onchange="'.$this->Prefix.'.pilihKB()"','&nbsp&nbsp----- Pilih Kode Kelompok -----')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKB()' title='Baru' >";
		
		$queryKC="SELECT m, concat(m, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l='$kb' and m <> '0' and n='00' and o='00'" ;//$cek.=$queryKC;
		$content->kc=cmbQuery('fmKC',$fmkc,$queryKC,'style="width:500;"onchange="'.$this->Prefix.'.pilihKC()"','&nbsp&nbsp-------- Pilih Jenis --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKC()' title='Baru' >";$cek.=$queryJenis;
		
		$queryKD="SELECT n, concat(n, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l='$kb' and m = '$kc' and n <> '00' and o='00'" ;$cek.=$queryKD;
		$content->kd=cmbQuery('fmKD',$fmkd,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Sub Objek --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";$cek.=$queryJenis;
	
	}else{
	
		$queryl="SELECT l, concat(l, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l<>'0' and m = '0' and n='00' and o='000'" ;$cek.=$queryl;
		$content->kb=cmbQuery('fmKB',$fmkb,$queryl,'style="width:500;"onchange="'.$this->Prefix.'.pilihKB()"','&nbsp&nbsp----- Pilih Kode Kelompok -----')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKB()' title='Baru' >";
		
		$queryKC="SELECT m, concat(m, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l='$kb' and m <> '0' and n='00' and o='000'" ;//$cek.=$queryKC;
		$content->kc=cmbQuery('fmKC',$fmkc,$queryKC,'style="width:500;"onchange="'.$this->Prefix.'.pilihKC()"','&nbsp&nbsp-------- Pilih Jenis --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKC()' title='Baru' >";$cek.=$queryJenis;
		
		$queryKD="SELECT n, concat(n, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l='$kb' and m = '$kc' and n <> '00' and o='000'" ;$cek.=$queryKD;
		$content->kd=cmbQuery('fmKD',$fmkd,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Sub Objek --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";$cek.=$queryJenis;
	}	
		/*$queryl="SELECT l, concat(l, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l<>'0' and m = '0' and n='00' and o='000'" ;$cek.=$queryl;
		$content->kb=cmbQuery('fmKB',$fmkb,$queryl,'style="width:500;"onchange="'.$this->Prefix.'.pilihKB()"','&nbsp&nbsp----- Pilih Kode Kelompok -----')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKB()' title='Baru' >";
		
		$queryKC="SELECT m, concat(m, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l='$kb' and m <> '0' and n='00' and o='000'" ;//$cek.=$queryKC;
		$content->kc=cmbQuery('fmKC',$fmkc,$queryKC,'style="width:500;"onchange="'.$this->Prefix.'.pilihKC()"','&nbsp&nbsp-------- Pilih Jenis --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKC()' title='Baru' >";$cek.=$queryJenis;
		
		$queryKD="SELECT n, concat(n, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l='$kb' and m = '$kc' and n <> '00' and o='000'" ;$cek.=$queryKD;
		$content->kd=cmbQuery('fmKD',$fmkd,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Sub Objek --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";$cek.=$queryJenis;
*/	
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function pilihKB(){
	global $Main;
	$REK_DIGIT_O=$Main->REK_DIGIT_O;
	
		$ka = $_REQUEST['fmKA']; 
		$kb = $_REQUEST['fmKB'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
	 	
		if($REK_DIGIT_O==0){
			$queryKC="SELECT m, concat(m, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l='$kb' and m <> '0' and n='00' and o='00'" ;//$cek.=$queryKC;
		$content->kc=cmbQuery('fmKC',$fmkc,$queryKC,'style="width:500;"onchange="'.$this->Prefix.'.pilihKC()"','&nbsp&nbsp-------- Pilih Jenis --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKC()' title='Baru' >";$cek.=$queryJenis;
		
		$queryKD="SELECT n, concat(n, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l='$kb' and m = '$kc' and n <> '00' and o='00'" ;$cek.=$queryKD;
		$content->kd=cmbQuery('fmKD',$fmkd,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Sub Objek --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";$cek.=$queryJenis;
		
		}else{
		
			$queryKC="SELECT m, concat(m, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l='$kb' and m <> '0' and n='00' and o='000'" ;//$cek.=$queryKC;
		$content->kc=cmbQuery('fmKC',$fmkc,$queryKC,'style="width:500;"onchange="'.$this->Prefix.'.pilihKC()"','&nbsp&nbsp-------- Pilih Jenis --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKC()' title='Baru' >";$cek.=$queryJenis;
		
		$queryKD="SELECT n, concat(n, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l='$kb' and m = '$kc' and n <> '00' and o='000'" ;$cek.=$queryKD;
		$content->kd=cmbQuery('fmKD',$fmkd,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Sub Objek --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";$cek.=$queryJenis;	
		}
		
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function pilihKC(){
	global $Main;
	$REK_DIGIT_O=$Main->REK_DIGIT_O;
	
		$ka = $_REQUEST['fmKA']; 
		$kb = $_REQUEST['fmKB'];
		$kc = $_REQUEST['fmKC'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
	 
	 if($REK_DIGIT_O==0){
	 
	 	$queryKD="SELECT n, concat(n, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l='$kb' and m = '$kc' and n <> '00' and o='00'" ;$cek.=$queryKD;
		$content->unit=cmbQuery('fmKD',$fmkd,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Sub Objek --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";$cek.=$queryJenis;
		
	 }else{
	 
	 	$queryKD="SELECT n, concat(n, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l='$kb' and m = '$kc' and n <> '00' and o='000'" ;$cek.=$queryKD;
		$content->unit=cmbQuery('fmKD',$fmkd,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Sub Objek --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";$cek.=$queryJenis;
		
	 }
	 
		
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	/*function pilihKD(){
	global $Main;
		$ka = $_REQUEST['fmKA']; 
		$kb = $_REQUEST['fmKB'];
		$kc = $_REQUEST['fmKC'];
		$kd = $_REQUEST['fmKD'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
	 
		$queryKE="SELECT o, concat(o, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka' and l='$kb' and m = '$kc' and n='$kd' and o='000'" ;$cek.=$queryKD;
		$content->unit=cmbQuery('fmKD',$fmkd,$queryKD,'style="width:210;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Sub Objek --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";$cek.=$queryJenis;
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}*/
	
	function pilihKD(){
	global $Main;
	$REK_DIGIT_O=$Main->REK_DIGIT_O;
		$ka = $_REQUEST['fmKA']; 
		$kb = $_REQUEST['fmKB'];
		$kc = $_REQUEST['fmKC'];
		$kd = $_REQUEST['fmKD'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
	 
	
		$queryKE="SELECT max(o) as o, nm_rekening FROM ref_rekening WHERE k='$ka' and l='$kb' and m = '$kc' and n='$kd'" ;$cek.=$queryKE;
		
		if($REK_DIGIT_O==0){
			$get=mysql_fetch_array(mysql_query($queryKE));
			$lastkode=$get['o'] + 1;	
			$kode_o = sprintf("%02s", $lastkode);
			$content->ke=$kode_o;
			
		}else{
			
			$get=mysql_fetch_array(mysql_query($queryKE));
			$lastkode=$get['o'] + 1;	
			$kode_o = sprintf("%03s", $lastkode);
			$content->ke=$kode_o;
		}	 
		
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function refreshKB(){
	global $Main;
	 $REK_DIGIT_O=$Main->REK_DIGIT_O;
	 
		$ka02 = $_REQUEST['fmKA'];	 
		$kb02 = $_REQUEST['fmKB'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kbnew= $_REQUEST['id_KBBaru'];
	 
	 if($REK_DIGIT_O==0){
	 	
		$queryKB="SELECT l, concat(l, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka02' and l!= '0' and m='0' and n='00' and o='00'" ;
		$content->kb=cmbQuery('fmKB',$kbnew,$queryKB,'style="width:500;"onchange="'.$this->Prefix.'.pilihKB()"','&nbsp&nbsp-------- Pilih Kelompok -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKB()' title='Baru' >";
		$queryKC="SELECT m, concat(m, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka02' and l='$kbnew' and m!='0' and n='00' and o='00'" ;
		$content->kc=cmbQuery('fmKC',$kcnew,$queryKC,'style="width:500;"onchange="'.$this->Prefix.'.pilihKC()"','&nbsp&nbsp-------- Pilih Jenis -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKC()' title='Baru' >";
		$queryKD="SELECT n, concat(n,' . ', nm_rekening) as vnama  FROM ref_rekening WHERE k='$ka02' and l='$kb02' and m='$kc02' and n!='00' and o='00'" ;
	 
		$koden=$queryKD['kd'];
		$new = sprintf("%02s", $koden);
		$kode_n=$new.".".$queryKD['nm_rekening'];
	
		$content->kd=cmbQuery('fmKD',$kdnew,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Objek -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";
		
	 }else{
	 	
		$queryKB="SELECT l, concat(l, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka02' and l!='0' and m='0' and n='00' and o='000'" ;
		
		$cek.="SELECT l, concat(l, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka02' and l!='0' and m='0' and n='00' and o='000'";
		$content->kb=cmbQuery('fmKB',$kbnew,$queryKB,'style="width:500;"onchange="'.$this->Prefix.'.pilihKB()"','&nbsp&nbsp-------- Pilih Kelompok -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKB()' title='Baru' >";
		
		$queryKC="SELECT m, concat(m, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka02' and l='$kbnew' and m!='0' and n='00' and o='000'" ;
		$cek.="SELECT m, concat(m, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka02' and l='$kbnew' and m!='0' and n='00' and o='000'";
		$content->kc=cmbQuery('fmKC',$kcnew,$queryKC,'style="width:500;"onchange="'.$this->Prefix.'.pilihKC()"','&nbsp&nbsp-------- Pilih Jenis -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKC()' title='Baru' >";
		
		$queryKD="SELECT n, concat(n,' . ', nm_rekening) as vnama  FROM ref_rekening WHERE k='$ka02' and l='$kb02' and m='$kc02' and n!='00' and o='000'" ;
	 
		$koden=$queryKD['kd'];
		$new = sprintf("%02s", $koden);
		$kode_n=$new.".".$queryKD['nm_rekening'];
	
		$content->kd=cmbQuery('fmKD',$kdnew,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Objek -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";
		
	 }
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}	
	
	function refreshKC(){
	global $Main;
	$REK_DIGIT_O=$Main->REK_DIGIT_O;
 
		$ka02 = $_REQUEST['fmKA'];	 
		$kb02 = $_REQUEST['fmKB'];
		$kc02 = $_REQUEST['fmKC'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kcnew= $_REQUEST['id_KCBaru'];
	 
	 if($REK_DIGIT_O==0){
	 	$queryKC="SELECT m, concat(m, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka02' and l='$kb02' and m<>'0' and n='00' and o='00'" ;
		
		$cek.="SELECT m, concat(m, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka02' and l='$kc02' and m<>'0' and n='00' and o='00'";
		$content->unit=cmbQuery('fmKC',$kcnew,$queryKC,'style="width:500;"onchange="'.$this->Prefix.'.pilihKC()"','&nbsp&nbsp-------- Pilih Jenis -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKC()' title='Baru' >";
	 }else{
	 	$queryKC="SELECT m, concat(m, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka02' and l='$kb02' and m<>'0' and n='00' and o='000'" ;
		
		$cek.="SELECT m, concat(m, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka02' and l='$kc02' and m<>'0' and n='00' and o='000'";
		$content->unit=cmbQuery('fmKC',$kcnew,$queryKC,'style="width:500;"onchange="'.$this->Prefix.'.pilihKC()"','&nbsp&nbsp-------- Pilih Jenis -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKC()' title='Baru' >";
	 }
		
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}	
	
	function refreshKD(){
	global $Main;
	$REK_DIGIT_O=$Main->REK_DIGIT_O;
	 
		$ka02 = $_REQUEST['fmKA'];	 
		$kb02 = $_REQUEST['fmKB'];
		$kc02 = $_REQUEST['fmKC'];
		$kd02 = $_REQUEST['fmKD'];
	//	$fmJenis2 = $_REQUEST['fmJenis2'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kdnew= $_REQUEST['id_KDBaru'];
	 
	 if($REK_DIGIT_O==0){
	 
	 	$queryKD="SELECT n, concat(n,' . ', nm_rekening) as vnama  FROM ref_rekening WHERE k='$ka02' and l='$kb02' and m='$kc02' and n<>'00' and o='00'" ;
	 
		$koden=$queryKD['kd'];
		$new = sprintf("%02s", $koden);
		$kode_n=$new.".".$queryKD['nm_rekening'];
	
		$content->unit=cmbQuery('fmKD',$kdnew,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Objek -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";	
	 
	 }else{
	 	$queryKD="SELECT n, concat(n,' . ', nm_rekening) as vnama  FROM ref_rekening WHERE k='$ka02' and l='$kb02' and m='$kc02' and n<>'00' and o='000'" ;
	 
		$koden=$queryKD['kd'];
		$new = sprintf("%02s", $koden);
		$kode_n=$new.".".$queryKD['nm_rekening'];
	
		$content->unit=cmbQuery('fmKD',$kdnew,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Objek -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";
	 }
	 
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function getKode_o(){
	 global $Main;
	 $REK_DIGIT_O=$Main->REK_DIGIT_O;
	 
	 	$ka02 = $_REQUEST['fmKA'];	 
		$kb02 = $_REQUEST['fmKB'];
		$kc02 = $_REQUEST['fmKC'];
		$kd02 = $_REQUEST['fmKD'];
		$ke02 = $_REQUEST['fmKE'];
	//	$ke02 = $_REQUEST['ke'];
	//	$fmJenis2 = $_REQUEST['fmJenis2'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kenew= $_REQUEST['id_KEBaru'];
	
	if($REK_DIGIT_O==0){
	
		$aqry5="SELECT MAX(o) AS maxno FROM ref_rekening WHERE k='$ka02' and l='$kb02' and m='$kc02' and n='$kd02'";
	 	$cek.="SELECT MAX(o) AS maxno FROM ref_rekening WHERE k='$ka02' and l='$kb02' and m='$kc02' and n='$kd02'";
		$get=mysql_fetch_array(mysql_query($aqry5));
		$newke=$get['maxno'] + 1;
		$newke1 = sprintf("%02s", $newke);
		$content->ke=$newke1;
	
	}else{
	
		$aqry5="SELECT MAX(o) AS maxno FROM ref_rekening WHERE k='$ka02' and l='$kb02' and m='$kc02' and n='$kd02'";
	 	$cek.="SELECT MAX(o) AS maxno FROM ref_rekening WHERE k='$ka02' and l='$kb02' and m='$kc02' and n='$kd02'";
		$get=mysql_fetch_array(mysql_query($aqry5));
		$newke=$get['maxno'] + 1;
		$newke1 = sprintf("%03s", $newke);
		$content->ke=$newke1;
	}
	 
	 	
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
		
	/*function refreshKD(){
	global $Main;
	 
		$ka02 = $_REQUEST['fmKA'];	 
		$kb02 = $_REQUEST['fmKB'];
		$kc02 = $_REQUEST['fmKC'];
		$kd02 = $_REQUEST['fmKD'];
	//	$fmJenis2 = $_REQUEST['fmJenis2'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kdnew= $_REQUEST['id_KDBaru'];
	 
		$queryKD="SELECT n, concat(n, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka02' and l='$kb02' and m'$kc02' and n<>'00' and o='000'" ;
		//$cek.="SELECT kb,nm_account FROM ref_jurnal WHERE ka='$ka02' and kb <> '0' and kc='0' and kd='0' and ke='0' and kf='0'";
		$cek.="SELECT n, concat(n, '. ', nm_rekening) as vnama FROM ref_rekening WHERE k='$ka02' and l='$kb02' and m='$kc02' and n<>'00' and o='000'";
		$content->unit=cmbQuery('fmKD',$kdnew,$queryKD,'style="width:210;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Objek -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}	*/
	
	function BaruKB($dt){	
	 global $SensusTmp, $Main;
	 $REK_DIGIT_O=$Main->REK_DIGIT_O;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 650;
	 $this->form_height = 80;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru Kode Kelompok';
		$nip	 = '';
		$KA1 = $_REQUEST ['fmKA'];
			
		$aqry2="SELECT MAX(l) AS maxno FROM ref_rekening WHERE k='$KA1'";$cek.=$aqry2;
		$get=mysql_fetch_array(mysql_query($aqry2));
		$newkb=$get['maxno'] + 1;
		
		if($REK_DIGIT_O==0){
			
			$queryKA1=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where k='$KA1' and l=0 and m=0 and n=00 and o=00"));  $cek.="SELECT k, nm_rekening FROM ref_rekening where l=0 and m=0 and n=00 and o=00";
			$datak1=$queryKA1['k'].".".$queryKA1['nm_rekening'];
			
		}else{
			$queryKA1=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where k='$KA1' and l=0 and m=0 and n=00 and o=000"));  
			$cek.="SELECT k, nm_rekening FROM ref_rekening where l=0 and m=0 and n=00 and o=000";
			$datak1=$queryKA1['k'].".".$queryKA1['nm_rekening'];	
		}
		
		
	  }else{
	  	$this->form_caption = 'Edit Kode Kelompok';
		$dt['k'];
		$datak1=$dt['k'];

		
		
		
		
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		
	 //items ----------------------
	  $this->form_fields = array(
			
			'Kelompok' => array( 
						'label'=>'Kode Akun',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='rekening' id='rekening' value='".$datak1."' style='width:500px;' readonly>
						
						<input type ='hidden' name='k' id='k' value='".$queryKA1['k']."'>
						</div>", 
						 ),	
									 			
			'kode_kelompok' => array( 
						'label'=>'Kode Kelompok',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='l' id='l' value='".$newkb."' style='width:30px;' readonly>
					
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Kelompok' style='width:470px;'>
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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanKB()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function genFormKB($withForm=TRUE, $params=NULL, $center=TRUE){	
		$form_name = $this->Prefix.'_KBform';	
		
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
	
	function BaruKD($dt){	
	 global $SensusTmp, $Main;
	 $REK_DIGIT_O=$Main->REK_DIGIT_O;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKD';				
	 $this->form_width = 650;
	 $this->form_height = 120;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru Kode Objek';
		$nip	 = '';
		$KA1 = $_REQUEST['fmKA'];
		$KB1 = $_REQUEST['fmKB'];
		$KC1 = $_REQUEST['fmKC'];
		$KD1 = $_REQUEST['fmKD'];
		
		if($REK_DIGIT_O){
			
		$aqry4="SELECT MAX(n) AS maxno FROM ref_rekening WHERE k='$KA1' and l='$KB1' and m='$KC1'";
		$get=mysql_fetch_array(mysql_query($aqry4));

		$newkm=$get['maxno'] + 1;
		$newkm1 = sprintf("%02s", $newkm);
		$queryKA1=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where k='$KA1' and l=0 and m=0 and n=00 and o=00"));  
		$queryKB1=mysql_fetch_array(mysql_query("SELECT l, nm_rekening FROM ref_rekening where k='$KA1' and l='$KB1' and m=0 and n=00 and o=00"));  
		$queryKC1=mysql_fetch_array(mysql_query("SELECT m, nm_rekening FROM ref_rekening where k='$KA1' and l='$KB1' and m='$KC1' and n=00 and o=00"));
			
		}else{
		
		$aqry4="SELECT MAX(n) AS maxno FROM ref_rekening WHERE k='$KA1' and l='$KB1' and m='$KC1'";
		$get=mysql_fetch_array(mysql_query($aqry4));

		$newkm=$get['maxno'] + 1;
		$newkm1 = sprintf("%02s", $newkm);
		$queryKA1=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where k='$KA1' and l=0 and m=0 and n=00 and o=000"));  
		$queryKB1=mysql_fetch_array(mysql_query("SELECT l, nm_rekening FROM ref_rekening where k='$KA1' and l='$KB1' and m=0 and n=00 and o=000"));  
		$queryKC1=mysql_fetch_array(mysql_query("SELECT m, nm_rekening FROM ref_rekening where k='$KA1' and l='$KB1' and m='$KC1' and n=00 and o=000"));
			
		}
		  
		
		$datak1=$queryKA1['k'].".".$queryKA1['nm_rekening'];
		$datak2=$queryKB1['l'].".".$queryKB1['nm_rekening'];
		$datak3=$queryKC1['m'].".".$queryKC1['nm_rekening'];
		
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		
	 //items ----------------------
	  $this->form_fields = array(
			
			'kode_akun' => array( 
						'label'=>'Kode Akun',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='Akun' id='Akun' value='".$datak1."' style='width:500px;' readonly>
						
						<input type ='hidden' name='k' id='k' value='".$queryKA1['k']."'>
						</div>", 
						 ),	
			
			'kode_Kelompok' => array( 
						'label'=>'Kode Kelompok',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='Kelompok' id='Kelompok' value='".$datak2."' style='width:500px;' readonly>
						
						<input type ='hidden' name='l' id='l' value='".$queryKB1['l']."'>
						</div>", 
						 ),	
						 
			'kode_jenis' => array( 
						'label'=>'Kode Jenis',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='jenis' id='jenis' value='".$datak3."' style='width:500px;' readonly>
						<input type ='hidden' name='m' id='m' value='".$queryKC1['m']."'>
						</div>", 
						 ),				 
									 		
			'kode_objek' => array( 
						'label'=>'Kode Objek',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='n' id='n' value='".$newkm1."' style='width:30px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Objek' style='width:470px;'>
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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanKD()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close4()' >";
							
		$form = $this->genFormKD();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function genFormKD($withForm=TRUE, $params=NULL, $center=TRUE){	
		$form_name = $this->Prefix.'_KDform';	
		
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
	
	
	
	function BaruKC($dt){	
	 global $SensusTmp, $Main;
	 $REK_DIGIT_O=$Main->REK_DIGIT_O;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKC';				
	 $this->form_width = 650;
	 $this->form_height = 100;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru Kode Jenis';
		$nip	 = '';
		$KA1 = $_REQUEST['fmKA'];
		$KB1 = $_REQUEST['fmKB'];
		$KC1 = $_REQUEST['fmKC'];
		
	if($REK_DIGIT_O==0){
		
		$aqry3="SELECT MAX(m) AS maxno FROM ref_rekening WHERE k='$KA1' and l='$KB1'";
		$cek.="SELECT MAX(m) AS maxno FROM ref_rekening WHERE k='$KA1' and l='$KB1'";
		$get=mysql_fetch_array(mysql_query($aqry3));

		$newkm=$get['maxno'] + 1;
		$queryKA1=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where k='$KA1' and l=0 and m=0 and n=00 and o=00"));  
		$queryKB1=mysql_fetch_array(mysql_query("SELECT l, nm_rekening FROM ref_rekening where k='$KA1' and l='$KB1' and m=0 and n=00 and o=00"));  
		
		$datak1=$queryKA1['k'].".".$queryKA1['nm_rekening'];
		$datak2=$queryKB1['l'].".".$queryKB1['nm_rekening'];
		
		
	}else{
		
		$aqry3="SELECT MAX(m) AS maxno FROM ref_rekening WHERE k='$KA1' and l='$KB1'";
		$cek.="SELECT MAX(m) AS maxno FROM ref_rekening WHERE k='$KA1' and l='$KB1'";
		$get=mysql_fetch_array(mysql_query($aqry3));

		$newkm=$get['maxno'] + 1;
		$queryKA1=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where k='$KA1' and l=0 and m=0 and n=00 and o=000"));  
		$queryKB1=mysql_fetch_array(mysql_query("SELECT l, nm_rekening FROM ref_rekening where k='$KA1' and l='$KB1' and m=0 and n=00 and o=000"));  
		
		$datak1=$queryKA1['k'].".".$queryKA1['nm_rekening'];
		$datak2=$queryKB1['l'].".".$queryKB1['nm_rekening'];
		
	}
		
	
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		
	 //items ----------------------
	  $this->form_fields = array(
			
			'kode_akun' => array( 
						'label'=>'Kode Akun',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='Akun' id='Akun' value='".$datak1."' style='width:500px;' readonly>
						
						<input type ='hidden' name='k' id='k' value='".$queryKA1['k']."'>
						</div>", 
						 ),	
			
			'kode_Kelompok' => array( 
						'label'=>'Kode Kelompok',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='Kelompok' id='Kelompok' value='".$datak2."' style='width:500px;' readonly>
						<input type ='hidden' name='l' id='l' value='".$queryKB1['l']."'>
						</div>", 
						 ),	
									 			
			'kode_jenis' => array( 
						'label'=>'Kode Jenis',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='m' id='m' value='".$newkm."' style='width:30px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Kelompok' style='width:470px;'>
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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanKC()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close3()' >";
							
		$form = $this->genFormKC();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function genFormKC($withForm=TRUE, $params=NULL, $center=TRUE){	
		$form_name = $this->Prefix.'_KCform';	
		
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
			 "<script src='js/skpd.js' type='text/javascript'></script>
			 <script type='text/javascript' src='js/master/ref_rekening/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
			  <script type='text/javascript' src='js/master/ref_rekening/cari_akun.js' language='JavaScript' ></script>
			 <script type='text/javascript' src='js/master/ref_rekening/cari_rekening.js' language='JavaScript' ></script>
			 
			 ".
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".
			
			$scriptload;
	}
	
	//form ==================================
	/*function setFormBaru(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}*/
	
	function setFormBaru(){
		//$cbid = $_REQUEST[$this->Prefix.'_cb'];
		//$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		//$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		//$e = $_REQUEST[$this->Prefix.'SkpdSUBUNIT'];
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
			$dt['kode_jurnal']=$fmBIDANG.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_jurnal']=$fmBIDANG.'.'.$fmKELOMPOK.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_jurnal']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_jurnal']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.'.$fmSUBSUBKELOMPOK.'.';
		}
		$fm = $this->setForm($dt);		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
   
  	function setFormEdit(){
	global $HTTP_COOKIE_VARS,$Main;
	
	
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
		$aqry = "SELECT * FROM  ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		
		if($dt['k']!='0' && $dt['l']=='0' && $dt['m']=='0' && $dt['n']=='00' && $dt['o']=='000'){
			$fm = $this->Edit_K($dt);
		}elseif($dt['k']!='0' && $dt['l']!='0' && $dt['m']=='0' && $dt['n']=='00' && $dt['o']=='000'){
			$fm = $this->Edit_L($dt);
		}elseif($dt['k']!='0' && $dt['l']!='0' && $dt['m']!='0' && $dt['n']=='00' && $dt['o']=='000'){
			$fm = $this->Edit_M($dt);
		}elseif($dt['k']!='0' && $dt['l']!='0' && $dt['m']!='0' && $dt['n']!='00' && $dt['o']=='000'){
			$fm = $this->Edit_N($dt);
		}else{
			$fm = $this->Edit_O($dt);
		}
		
		
	//	$fm = $this->setFormEditdata($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	
	function Edit_K($dt){	
	global $SensusTmp, $Main;
	 
	 $REK_DIGIT_O=$Main->REK_DIGIT_O;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 700;
	 $this->form_height = 50;
	  if ($this->form_fmST==1) {
		$this->form_caption = 'EDIT KODE REKENING';
	  }
	
	$k=$dt['k']; 
	$nama=$dt['nm_rekening']; 
		
	$query = "" ;$cek .=$query;
	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
												 			
			'kode_urusan' => array( 
				'label'=>'KODE REKENING',
				'labelWidth'=>120, 
				'value'=>"<div style='float:left;'>
				<input type='text' name='k' id='k' value='".$k."' style='width:50px;' readonly>
				<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Rekening' style='width:480px;'></div>", 
						 ),	
						 				 
			'Add' => array( 
						'label'=>'',
						'value'=>"<div id='Add'></div>",
						'type'=>'merge'
					 )			
			);
		//tombol
		$this->form_menubawah =
		"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan_k()' title='Simpan' >"."&nbsp&nbsp".
		"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Edit_L($dt){	
	global $SensusTmp, $Main;
	 
	 $REK_DIGIT_O=$Main->REK_DIGIT_O; 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 670;
	 $this->form_height = 100;
	  if ($this->form_fmST==1) 
		$this->form_caption = 'EDIT KODE KELOMPOK';
		
	  
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		$query_k=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l=0 and m=0 and n=00 and o=000")); 
		$query_k1=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l=0 and m=0 and n=00 and o=00")); 
		$query_l=mysql_fetch_array(mysql_query("SELECT l, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m=0 and n=00 and o=000")); $cek.=$queryc; 
		$query_l1=mysql_fetch_array(mysql_query("SELECT l, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m=0 and n=00 and o=00")); $cek.=$queryc; 
	if($REK_DIGIT_O==0){
		$data_k=$query_k1['k'].".".$query_k1['nm_rekening'];
		$nama=$query_l1['nm_rekening'];
	}else{
		$data_k=$query_k['k'].".".$query_k['nm_rekening'];
		$nama=$query_l['nm_rekening'];
	}
	
	//	$data_k=$query_k['k'].".".$query_k['nm_rekening'];
	//	$datc=$query_l['l'];
	//	$nama=$query_l['nm_rekening'];
	 //items ----------------------
	  $this->form_fields = array(
			
			'urusan' => array( 
						'label'=>'KODE REKENING',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='kx' id='kx' value='".$data_k."' style='width:480px;' readonly>
						<input type ='hidden' name='k' id='k' value='".$dt['k']."'>
						</div>", 
						 ),	
									 			
			'bidang' => array( 
						'label'=>'KODE KELOMPOK',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='l' id='l' value='".$dt['l']."' style='width:40px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Bidang' style='width:440px;'>
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
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan_l()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Edit_M($dt){	
	global $SensusTmp, $Main;
	 
	 $REK_DIGIT_O=$Main->REK_DIGIT_O; 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 670;
	 $this->form_height = 120;
	  if ($this->form_fmST==1) {
		$this->form_caption = 'EDIT KODE JENIS';
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		$query_k=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l='0' and m='0' and n=00 and m=000"));
		$query_k0=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l='0' and m='0' and n=00 and m=00"));
		
		$query_l=mysql_fetch_array(mysql_query("SELECT l, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m=0 and n=00 and o=000"));
		$query_l0=mysql_fetch_array(mysql_query("SELECT l, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m=0 and n=00 and o=00"));
		
		$qrym=mysql_fetch_array(mysql_query("SELECT m, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m='".$dt['m']."' and n=00 and o=000"));
		$qrym0=mysql_fetch_array(mysql_query("SELECT m, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m='".$dt['m']."' and n=00 and o=00"));
	
	if($REK_DIGIT_O==0){
		$data_k=$query_k0['k'].".".$query_k0['nm_rekening'];
		$data_l=$query_l0['l'].".".$query_l0['nm_rekening'];
		$nama=$qrym0['nm_rekening'];
	}else{
		$data_k=$query_k['k'].".".$query_k['nm_rekening'];
		$data_l=$query_l['l'].".".$query_l['nm_rekening'];
		$nama=$qrym['nm_rekening'];
	}
	
/*	
		$data_k=$query_k['k'].".".$query_k['nm_rekening'];
		$data_l=$query_l['l'].".".$query_l['nm_rekening'];
		$nama=$qrym['nm_rekening'];*/

	 //items ----------------------
	  $this->form_fields = array(
		
		'REKENING' => array( 
			'label'=>'KODE REKENING',
			'labelWidth'=>120, 
			'value'=>"<div style='float:left;'>
			<input type='text' name='kx' id='kx' value='".$data_k."' style='width:480px;' readonly>
			<input type ='hidden' name='k' id='k' value='".$dt['k']."'></div>", 
						 ),	
						 
		'KELOMPOK' => array( 
			'label'=>'KODE KELOMPOK',
			'labelWidth'=>100, 
			'value'=>"<div style='float:left;'>
			<input type='text' name='lx' id='lx' value='".$data_l."' style='width:480px;' readonly>
			<input type ='hidden' name='l' id='l' value='".$dt['l']."'></div>", 
						 ),				 
									 			
		'JENIS' => array( 
			'label'=>'KODE JENIS',
			'labelWidth'=>100, 
			'value'=>"<div style='float:left;'>
			<input type='text' name='m' id='m' value='".$dt['m']."' style='width:40px;' readonly>
			<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode JENIS' style='width:440px;'></div>", 
			),	
						 	
		'Add' => array( 
			'label'=>'',
			'value'=>"<div id='Add'></div>",
			'type'=>'merge'
				 )			
			);
			
		$this->form_menubawah =
		"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan_m()' title='Simpan' >"."&nbsp&nbsp".
		"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";	
		$form = $this->genForm();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Edit_N($dt){	
	global $SensusTmp, $Main;
	 
	 $REK_DIGIT_O=$Main->REK_DIGIT_O;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 670;
	 $this->form_height = 120;
	  
	  if ($this->form_fmST==1) {
		$this->form_caption = 'EDIT KODE OBJEK';
		}
		
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		$query_k=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l=0 and m=0 and n=00 and o=000"));  
		$query_k0=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l=0 and m=0 and n=00 and o=00"));  
		$query_l=mysql_fetch_array(mysql_query("SELECT l, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m=0 and n=00 and o=000"));  
		$query_l0=mysql_fetch_array(mysql_query("SELECT l, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m=0 and n=00 and o=00"));  
		$query_m=mysql_fetch_array(mysql_query("SELECT m, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m='".$dt['m']."' and n=00 and o=000"));  
		$query_m0=mysql_fetch_array(mysql_query("SELECT m, nm_rekening FROM ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m='".$dt['m']."' and n=00 and o=00"));  
		
	if($REK_DIGIT_O==0){
		$data_k=$query_k0['k'].".".$query_k['nm_rekening'];
		$data_l=$query_l0['l'].".".$query_l['nm_rekening'];
		$data_m=$query_m0['m'].".".$query_m['nm_rekening'];
		$n=$dt['n'];
		$nama=$dt['nm_rekening'];
	}else{
		$data_k=$query_k['k'].".".$query_k['nm_rekening'];
		$data_l=$query_l['l'].".".$query_l['nm_rekening'];
		$data_m=$query_m['m'].".".$query_m['nm_rekening'];
		$n=$dt['n'];
		$nama=$dt['nm_rekening'];
	}
	
		/*$data_k=$query_k['k'].".".$query_k['nm_rekening'];
		$data_l=$query_l['l'].".".$query_l['nm_rekening'];
		$data_m=$query_m['m'].".".$query_m['nm_rekening'];
		$n=$dt['n'];
		$nama=$dt['nm_rekening'];*/ 
		
	 //items ----------------------
	  $this->form_fields = array(
			
			'REKENING' => array( 
						'label'=>'KODE REKENING',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='rekening' id='rekening' value='".$data_k."' style='width:480px;' readonly>
						<input type ='hidden' name='k' id='k' value='".$query_k['k']."'>
						</div>", 
						 ),	
			
			'KELOMPOK' => array( 
						'label'=>'KODE KELOMPOK',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='Kelompok' id='Kelompok' value='".$data_l."' style='width:480px;' readonly>
						<input type ='hidden' name='l' id='l' value='".$query_l['l']."'>
						</div>", 
						 ),	
						 
			'JENIS' => array( 
						'label'=>'KODE JENIS',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='jenis' id='jenis' value='".$data_m."' style='width:480px;' readonly>
						<input type ='hidden' name='m' id='m' value='".$query_m['m']."'>
						</div>", 
						 ),				 
									 		
			'OBJEK' => array( 
						'label'=>'KODE OBJEK',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='n' id='n' value='".$n."' style='width:50px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Objek' style='width:426px;'>
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
		"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan_n()' title='Simpan' >"."&nbsp&nbsp".
		"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function setFormMapping(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
			$kode = explode(' ',$this->form_idplh);
			$k=$kode[0];
			$l=$kode[1];
			$m=$kode[2];
			$n=$kode[3];
			$o=$kode[4];
			
		
		$ceklvl4=mysql_query("SELECT * FROM  ref_rekening WHERE k='".$kode[0]."' and l='".$kode[1]."' and m='".$kode[2]."' and n='".$kode[3]."' and o='".$kode[4]."'");
		$cek.=$ceklvl4;
		$ceklevl4=mysql_fetch_array($ceklvl4);
		
		if ($ceklevl4['k'] <>'0' && $ceklevl4['l'] =='0' ){
		$fm['err']="Data Tidak Bisa di Mapping !!";	
		}elseif($ceklevl4['k'] <> '0' && $ceklevl4['l'] <>'0' && $ceklevl4['m'] =='0'){
		$fm['err']="Data Tidak Bisa di Mapping !!";		
		}elseif($ceklevl4['k'] <> '0' && $ceklevl4['l'] <>'0' && $ceklevl4['m'] <>'0' && $ceklevl4['n'] =='00'){
		$fm['err']="Data Tidak Bisa di Mapping !!";	
		}elseif($ceklevl4['k'] <> '0' && $ceklevl4['l'] <>'0' && $ceklevl4['m'] <>'0' && $ceklevl4['n'] <> '00' && $ceklevl4['o'] =='000'){
		$fm['err']="Data Tidak Bisa di Mapping !!";	
		}else{
			$aqry = "SELECT * FROM  ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o' "; $cek.=$aqry;
			$dt = mysql_fetch_array(mysql_query($aqry));
			$fm = $this->setFormMappingData($dt);
		}
		//get data 
			/*$aqry = "SELECT * FROM  ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o' "; $cek.=$aqry;
			$dt = mysql_fetch_array(mysql_query($aqry));
			$fm = $this->setFormMappingData($dt);*/
			
	//	return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}	
	
		
	function setFormMappingData($dt){
	 global $SensusTmp, $Main;
	 $cek = ''; $err=''; $content='';

	 $json = TRUE;	//$ErrMsg = 'tes';

	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 800;
	 $this->form_height = 120;
	//  if ($this->form_fmST==3) {
	$tambah_mapping = $_REQUEST['tambah_mapping'];

		$this->form_caption = 'MAPPING REKENING ';
		
		$kode_rekening=$dt['k'].'.'.$dt['l'].'.'.$dt['m'].'.'.$dt['n'].'.'.$dt['o'];
		$nm_rekening=mysql_fetch_array(mysql_query("select * from ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m='".$dt['m']."' and n='".$dt['n']."' and o='".$dt['o']."'"));
		if($dt['ka']=='0'){
			$kode_jurnal1='';
		}else{
			$kode_jurnal1=$dt['ka'].'.'.$dt['kb'].'.'.$dt['kc'].'.'.$dt['kd'].'.'.$dt['ke'].'.'.$dt['kf'];
		}
	//	$kode_jurnal1=$dt['ka'].'.'.$dt['kb'].'.'.$dt['kc'].'.'.$dt['kd'].'.'.$dt['ke'].'.'.$dt['kf'];
		if($dt['ka1']=='0'){
			$kode_jurnal2='';
		}else{
			$kode_jurnal2=$dt['ka1'].'.'.$dt['kb1'].'.'.$dt['kc1'].'.'.$dt['kd1'].'.'.$dt['ke1'].'.'.$dt['kf1'];
		}
		
		if($dt['ka2']=='0'){
			$kode_jurnal3='';
		}else{
			$kode_jurnal3=$dt['ka2'].'.'.$dt['kb2'].'.'.$dt['kc2'].'.'.$dt['kd2'].'.'.$dt['ke2'].'.'.$dt['kf2'];
		}
		
		$jurnal1=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='".$dt['ka']."' and kb='".$dt['kb']."' and kc='".$dt['kc']."' and kd='".$dt['kd']."' and ke='".$dt['ke']."' and kf='".$dt['kf']."'"));
		$jurnal2=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='".$dt['ka1']."' and kb='".$dt['kb1']."' and kc='".$dt['kc1']."' and kd='".$dt['kd1']."' and ke='".$dt['ke1']."' and kf='".$dt['kf1']."'"));
		$jurnal3=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='".$dt['ka2']."' and kb='".$dt['kb2']."' and kc='".$dt['kc2']."' and kd='".$dt['kd2']."' and ke='".$dt['ke2']."' and kf='".$dt['kf2']."'"));
		
       //items ----------------------
		  $this->form_fields = array(
		
		'kdRekening' => array(
		'label'=>'KODE REKENING',
		'labelWidth'=>120,
		'value'=>"<input type='text' name='kode_rekening' value='".$kode_rekening."' size='10px' id='kode_rekening' readonly>&nbsp
					<input type='text' name='nm_rekening' value='".$nm_rekening['nm_rekening']."' size='73px' id='nm_rekening' readonly>&nbsp
				
					<input type='button' value='Cari' onclick ='".$this->Prefix.".cari_rekening()'  title='Cari Kode Rekening' >"
									 ),
		'kd_akun' => array(
		'label'=>'KODE AKUN',
		'labelWidth'=>100,
		'value'=>"
			<input type='text' name='kode_akun' value='".$kode_jurnal1."' size='10px' id='kode_akun' readonly>&nbsp
			<input type='text' name='nama_akun' value='".$jurnal1['nm_account']."' size='73px' id='nama_akun' readonly>&nbsp
			<input type='button' value='Cari' onclick ='".$this->Prefix.".cari_akun_1()'  title='Cari Kode Akun' >"
									 ),
		'mapping1' => array(
		'label'=>'MAPPING 1',
		'labelWidth'=>100,
		'value'=>"
			<input type='text' name='kode_mapping1' value='".$kode_jurnal2."' size='10px' id='kode_mapping1' readonly>&nbsp
			<input type='text' name='nm_mapping1' value='".$jurnal2['nm_account']."' size='73px' id='nm_mapping1' readonly>&nbsp
			<input type='button' value='Cari' onclick ='".$this->Prefix.".cari_akun_2()'  title='Cari Kode Akun Mapping 1' >"
									 ),
		'mapping2' => array(
		'label'=>'MAPPING 2',
		'labelWidth'=>100,
		'value'=>"
			<input type='text' name='kode_mapping2' value='".$kode_jurnal3."' size='10px' id='kode_mapping2' readonly>&nbsp
			<input type='text' name='nm_mapping2' value='".$jurnal3['nm_account']."' size='73px' id='nm_mapping2' readonly>&nbsp
			<input type='button' value='Cari' onclick ='".$this->Prefix.".cari_akun_3()'  title='Cari Kode Akun Mapping 2' >"
				),
		);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanMapping()' title='Simpan' > &nbsp &nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Edit_O($dt){	
	 global $SensusTmp ,$Main;
	 
	 
	 $REK_DIGIT_O=$Main->REK_DIGIT_O;
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 700;
	 $this->form_height = 150;
	  if ($this->form_fmST==1) {
		$this->form_caption = 'EDIT KODE REKENING';
	  }
	 
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;	
		$k=$kode[0];
		$l=$kode[1];
		$m=$kode[2];
		$n=$kode[3];
		$o=$kode[4];
		
		if($REK_DIGIT_O==0){
		$queryKAedit=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening WHERE k='$k' and l = '0' and m='0' and n='00' and o='00'")) ;
		$cek.=$queryKAedit;
		$queryKBedit=mysql_fetch_array(mysql_query("SELECT l, nm_rekening FROM ref_rekening WHERE k='$k' and l='$l' and m= '0' and n='00' and o='00'")) ;
		$queryKCedit=mysql_fetch_array(mysql_query("SELECT m, nm_rekening FROM ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='00' and o='00'")) ;
		$queryKDedit=mysql_fetch_array(mysql_query("SELECT n, nm_rekening FROM ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='00'")) ;
		$queryKEedit=mysql_fetch_array(mysql_query("SELECT o, nm_rekening FROM ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o'")) ;
	//	$cek.="SELECT ke, nm_account FROM ref_jurnal WHERE ka='$data_ka' and kb='$data_kb' and kc='$data_kc' and kd='$data_kd' and ke='$data_ke' and kf='0'";
					
	
		$datka=$queryKAedit['k'].". ".$queryKAedit['nm_rekening'];
		$datkb=$queryKBedit['l'].". ".$queryKBedit['nm_rekening'];
		$datkc=$queryKCedit['m'].". ".$queryKCedit['nm_rekening'];
		$datkd=$queryKDedit['n'].". ".$queryKDedit['nm_rekening'];
		$datke=$queryKEedit['o'];
			
		}else{
			
			$queryKAedit=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening WHERE k='$k' and l = '0' and m='0' and n='00' and o='000'")) ;
		$cek.=$queryKAedit;
		$queryKBedit=mysql_fetch_array(mysql_query("SELECT l, nm_rekening FROM ref_rekening WHERE k='$k' and l='$l' and m= '0' and n='00' and o='000'")) ;
		$queryKCedit=mysql_fetch_array(mysql_query("SELECT m, nm_rekening FROM ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='00' and o='000'")) ;
		$queryKDedit=mysql_fetch_array(mysql_query("SELECT n, nm_rekening FROM ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='000'")) ;
		$queryKEedit=mysql_fetch_array(mysql_query("SELECT o, nm_rekening FROM ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o'")) ;
	//	$cek.="SELECT ke, nm_account FROM ref_jurnal WHERE ka='$data_ka' and kb='$data_kb' and kc='$data_kc' and kd='$data_kd' and ke='$data_ke' and kf='0'";
					
	
		$datka=$queryKAedit['k'].". ".$queryKAedit['nm_rekening'];
		$datkb=$queryKBedit['l'].". ".$queryKBedit['nm_rekening'];
		$datkc=$queryKCedit['m'].". ".$queryKCedit['nm_rekening'];
		$datkd=$queryKDedit['n'].". ".$queryKDedit['nm_rekening'];
		$datke=$queryKEedit['o'];
			
		}
		/*$queryKAedit=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening WHERE k='$k' and l = '0' and m='0' and n='00' and o='000'")) ;
		$cek.=$queryKAedit;
		$queryKBedit=mysql_fetch_array(mysql_query("SELECT l, nm_rekening FROM ref_rekening WHERE k='$k' and l='$l' and m= '0' and n='00' and o='000'")) ;
		$queryKCedit=mysql_fetch_array(mysql_query("SELECT m, nm_rekening FROM ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='00' and o='000'")) ;
		$queryKDedit=mysql_fetch_array(mysql_query("SELECT n, nm_rekening FROM ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='000'")) ;
		$queryKEedit=mysql_fetch_array(mysql_query("SELECT o, nm_rekening FROM ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o'")) ;
	//	$cek.="SELECT ke, nm_account FROM ref_jurnal WHERE ka='$data_ka' and kb='$data_kb' and kc='$data_kc' and kd='$data_kd' and ke='$data_ke' and kf='0'";
					
	
		$datka=$queryKAedit['k'].".  ".$queryKAedit['nm_rekening'];
		$datkb=$queryKBedit['l'].". ".$queryKBedit['nm_rekening'];
		$datkc=$queryKCedit['m']." .  ".$queryKCedit['nm_rekening'];
		$datkd=$queryKDedit['n'].". ".$queryKDedit['nm_rekening'];
		$datke=$queryKEedit['o'];*/
	//	$datke=sprintf("%02s",$queryKEedit['ke'])." .  ".$queryKEedit['nm_account'];
		
       //items ----------------------
		  $this->form_fields = array(
		  
		  'kode_Akun' => array( 
						'label'=>'KODE REKENING',
						'labelWidth'=>150, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='ek' id='ek' value='".$datka."' style='width:500px;' readonly>
						<input type ='hidden' name='k' id='k' value='".$queryKAedit['k']."'>
						</div>", 
						 ),
			'kode_kelompok' => array( 
						'label'=>'KODE KELOMPOK',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='el' id='el' value='".$datkb."' style='width:500px;' readonly>
						<input type ='hidden' name='l' id='l' value='".$queryKBedit['l']."'>
						</div>", 
						 ),
			'kode_Jenis' => array( 
						'label'=>'KODE JENIS',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='em' id='em' value='".$datkc."' style='width:500px;' readonly>
						<input type ='hidden' name='m' id='m' value='".$queryKCedit['m']."'>
						</div>", 
						 ),
			'kode_Objek' => array( 
						'label'=>'KODE OBJEK',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='en' id='en' value='".$datkd."' style='width:500px;' readonly>
						<input type ='hidden' name='n' id='n' value='".$queryKDedit['n']."'>
						</div>", 
						 ),
			'Kode_Rincian_Objek' => array( 
						'label'=>'KODE RINCIAN OBJEK',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='eo' id='eo' value='".$datke."' style='width:30px;' readonly>
						<input type ='hidden' name='o' id='o' value='".$queryKEedit['o']."'>
						<input type='text' name='nm_rekening' id='nm_rekening' value='".$dt['nm_rekening']."' size='73px'>
						</div>", 
						 ),			 			 			 
						 			 
		 
			
			/*'Nama' => array( 
						'label'=>'Nama',
						//'id'=>'cont_object',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'><input type='text' name='nm_account' id='nm_account' value='".$dt['nm_account']."' size='40px'>
						</div>", 
						 ),		*/				 
			);
		//tombol
		$this->form_menubawah =	
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanEdit()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
			"<input type='hidden' name='ka' id='ka' value='".$dt['ka']."'>".
			"<input type='hidden' name='kb' id='kb' value='".$dt['kb']."'>".
			"<input type='hidden' name='kc' id='kc' value='".$dt['kc']."'>".
			"<input type='hidden' name='kd' id='kd' value='".$dt['kd']."'>".
			"<input type='hidden' name='ke' id='ke' value='".$dt['ke']."'>".
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
		
	function setForm($dt){	
	 global $SensusTmp ,$Main;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	$this->form_width = 750;
	 $this->form_height = 150;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'FORM BARU KODE REKENING';
	//	$nip	 = '';
	  }/*else{
		$this->form_caption = 'Edit';			
		$readonly='readonly';
					
	  }*/
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		$fmKA = $_REQUEST['fmka'];
		$fmKB = $_REQUEST['fmkb'];
		$fmKC = $_REQUEST['fmkc'];
		$fmKD = $_REQUEST['fmkd'];
		$fmKE = $_REQUEST['fmke'];
		$fmKF = $_REQUEST['fmkf'];
		
		$queryKA="SELECT k, concat(k, '. ', nm_rekening) as vnama FROM ref_rekening where l=0 and m=0 and n=00 and o=00"; 
		$queryKB="SELECT l,nm_rekening FROM ref_rekening where k='$fmKA' and  m=0 and n=00 and o=00";
		$queryKC="SELECT m,nm_rekening FROM ref_rekening where k='$fmKA' and  l='$fmKB' and n=00 and o=00";
		$queryKD="SELECT n,nm_rekening FROM ref_rekening where k='$fmKA' and  l='$fmKB' and m='$fmKC' and o=00";
		$queryKE="SELECT o,nm_rekening FROM ref_rekening where k='$fmKA' and  l='$fmKB' and m='$fmKC' and o='$fmKD'";
	 //items ----------------------
	  $this->form_fields = array(
			
			'kode_Akun' => array( 
						'label'=>'KODE REKENING',
						'labelWidth'=>150, 
						'value'=>
						"<div id='cont_ka'>".cmbQuery('fmKA',$ka,$queryKA,'style="width:500;"onchange="'.$this->Prefix.'.pilihKA()"','-------- Pilih Kode Rekening ------------------')."</div>",
						 ),	
						 	
			'kode_kelompok' => array( 
						'label'=>'KODE KELOMPOK',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_kb'>".cmbQuery('fmKB',$kb,$queryKB,'style="width:500;"onchange="'.$this->Prefix.'.pilihKB()"','-------- Pilih Kode Kelompok ------------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKB()' title='Kode Kelompok' ></div>",
						 ),
			
			'kode_Jenis' => array( 
						'label'=>'KODE JENIS',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_kc'>".cmbQuery('fmKC',$kc,$queryKC,'style="width:500;"onchange="'.$this->Prefix.'.pilihKC()"','-------- Pilih Kode Jenis --------------------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKC()' title='kode jenis' ></div>",
						 ),	
			
			'kode_Objek' => array( 
						'label'=>'KODE OBJEK',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_kd'>".cmbQuery('fmKD',$kd,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','-------- Pilih Kode Objek ---------------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Kode Objek' ></div>",
						 ),		
			'Kode_Rincian_Objek' => array( 
						'label'=>'KODE RINCIAN OBJEK',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='ke' id='ke' value='".$newke."' style='width:50px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Rincian Objek' style='width:450px;'>
						</div>", 
						 ),		
			/*'Kode_Rincian_Objek' => array( 
						'label'=>'Kode Rincian Objek',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='ke' id='ke' value='".$newke."' style='width:50px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Rincian Objek' style='width:220px;'>
						</div>", 
						 ),	*/
						 			 
			/*'1kode' => array( 
						'label'=>'Kode Rekening',
						'labelWidth'=>100, 
						//'value'=>$dt['kode'],
						//'type'=>'text',
						'value'=>
						"<input type='text' name='k' id='k' size='5' maxlength='1' value='".$kode1."' $readonly>&nbsp
						<input type='text' name='l' id='l' size='5' maxlength='1' value='".$kode2."' $readonly>&nbsp
						<input type='text' name='m' id='m' size='5' maxlength='1' value='".$kode3."' $readonly>&nbsp
						<input type='text' name='n' id='n' size='5' maxlength='2' value='".$kode4."' $readonly>&nbsp
						<input type='text' name='o' id='o' size='5' maxlength='2' value='".$kode5."' $readonly>"
						 ),
			
			'nama' => array( 
						'label'=>'Nama Rekening',
						'labelWidth'=>100, 
						
						
						'value'=>"<input type='text' name='nama_rekening' id='nama_rekening' size='50' maxlength='100' value='".$nama_rekening."'>",
						'row_params'=>"valign='top'",
						'type'=>'' 
									 ),*/
			);
		//tombol
		$this->form_menubawah =
			
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	/*function setPage_HeaderOther(){
	return 
			"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=ref_skpd\" title='Skpd'  >Skpd</a> |	
	<A href=\"pages.php?Pg=ref_rekening\" title='Rekening' style='color:blue'  >Rekening</a> |
	<A href=\"pages.php?Pg=ref_satuan\" title='Satuan'  >Satuan</a> |
	<A href=\"pages.php?Pg=ref_kepala_skpd\" title='Kepala Skpd'  >Kepala Skpd</a> |
	<A href=\"pages.php?Pg=ref_pengesahan\" title='Pengesahan'   >Pengesahan</a> |
	<A href=\"pages.php?Pg=ref_tapd\" title='Tapd'   >Tapd</a> |
	<A href=\"pages.php?Pg=ref_program\" title='Program & Kegiatan'   >Program & Kegiatan</a> |
	<A href=\"pages.php?Pg=ref_sumber_dana\" title='Sumber Dana'   >Sumber Dana</a> |
	
	</td></tr></table>";
	"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>";
	
	}*/
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $margin =  'style="margin-left:20px;"';
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox		
	
	   <th class='th01' width='900' align='cente'>KODE REKENING / <br>NAMA REKENING</th>
	   <th class='th01' width='900' align='cente'>KODE AKUN / <br>NAMA AKUN</th>
	   <th class='th01' width='900' align='cente'>KODE MAPPING 1 / <br>NAMA MAPPING 1</th>
	   <th class='th01' width='900' align='cente'>KODE MAPPING 2 / <br>NAMA MAPPING 2</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref, $Main;
	  $margin =  'style="margin-left:20px;"';
	if($Main->REK_DIGIT_O == 0){
		$nilai_o=genNumber($isi['o'],2);
	}else{
		$nilai_o=genNumber($isi['o'],3);
	}
	
	 $dat_rekening=genNumber($isi['k'],1).'.'.genNumber($isi['l'],1).'.'.genNumber($isi['m'],1).'.'.genNumber($isi['n'],2).'.'.$nilai_o;
	 $nm_rekening=$isi['nm_rekening'];
	 $data_rekening=$dat_rekening.'<br>'.$nm_rekening;
	 if($isi['ka']=='0'){
	 	 $kode='';
	 }else{
	 	 $kode=$isi['ka'].'.'.$isi['kb'].'.'.$isi['kc'].'.'.genNumber($isi['kd'],2).'.'.genNumber($isi['ke'],2);
	 }
	 
	 if($isi['ka1']=='0'){
	 	$kode2='';
	 }else{
	 	$kode2=$isi['ka1'].'.'.$isi['kb1'].'.'.$isi['kc1'].'.'.genNumber($isi['kd1'],2).'.'.genNumber($isi['ke1'],2);
	 }
	 
	 if($isi['ka2']=='0'){
	 	$kode3='';
	 }else{
	 	$kode3=$isi['ka2'].'.'.$isi['kb2'].'.'.$isi['kc2'].'.'.genNumber($$isi['kd2'],2).'.'.genNumber($$isi['ke2'],2);
	 }
	 
	 /*$kode=$isi['ka'].'.'.$isi['kb'].'.'.$isi['kc'].'.'.$isi['kd'].'.'.$isi['ke'].'.'.$isi['kf'];
	 $kode2=$isi['ka1'].'.'.$isi['kb1'].'.'.$isi['kc1'].'.'.$isi['kd1'].'.'.$isi['ke1'].'.'.$isi['kf1'];
	 $kode3=$isi['ka2'].'.'.$isi['kb2'].'.'.$isi['kc2'].'.'.$isi['kd2'].'.'.$isi['ke2'].'.'.$isi['kf2'];*/
	$nm_jurnal1=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='".$isi['ka']."' and kb='".$isi['kb']."' and kc='".$isi['kc']."' and kd='".$isi['kd']."' and ke='".$isi['ke']."' and kf='".$isi['kf']."'"));
	$nm_jurnal2=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='".$isi['ka1']."' and kb='".$isi['kb1']."' and kc='".$isi['kc1']."' and kd='".$isi['kd1']."' and ke='".$isi['ke1']."' and kf='".$isi['kf1']."'"));
	$nm_jurnal3=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='".$isi['ka2']."' and kb='".$isi['kb2']."' and kc='".$isi['kc2']."' and kd='".$isi['kd2']."' and ke='".$isi['ke2']."' and kf='".$isi['kf2']."'"));
	$data_jurnal1=$kode.' <br>'.$nm_jurnal1['nm_account'];
	$data_jurnal2=$kode2.' <br> '.$nm_jurnal2['nm_account'];
	$data_jurnal3=$kode3.' <br> '.$nm_jurnal3['nm_account'];
	
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',"<span style='color:black;font-size:12px;font-weight:bold;'>".$dat_rekening."</span>".'<br>'.$nm_rekening);
	 
	 $Koloms[] = array('align="left"',"<span style='color:black;font-size:12px;font-weight:bold;'>".$kode."</span>".'<br>'.$nm_jurnal1['nm_account']);
	 $Koloms[] = array('align="left"',"<span style='color:black;font-size:12px;font-weight:bold;'>".$kode2."</span>".'<br>'.$nm_jurnal2['nm_account']);
	 $Koloms[] = array('align="left"',"<span style='color:black;font-size:12px;font-weight:bold;'>".$kode3."</span>".'<br>'.$nm_jurnal3['nm_account']);
		 
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	$REK_DIGIT_O=$Main->REK_DIGIT_O; 
	 
		
	$fmBIDANG = cekPOST('fmBIDANG');
	$fmKELOMPOK = cekPOST('fmKELOMPOK');
	$fmSUBKELOMPOK = cekPOST('fmSUBKELOMPOK');
	$fmSUBSUBKELOMPOK = cekPOST('fmSUBSUBKELOMPOK');
	$fmKODE = cekPOST('fmKODE');
	$fmBARANG = cekPOST('fmBARANG');			

	
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
				
	if($REK_DIGIT_O==0){
		$TampilOpt = 
			
			"<div class='FilterBar'>".	
			"<table style='width:100%'>
			<tr>
			<td style='width:150px'>BIDANG</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery1("fmBIDANG",$fmBIDANG,"select k,nm_rekening from ref_rekening where k!='0' and l ='0' and m = '0' and n='00' and o='00'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmKELOMPOK",$fmKELOMPOK,"select l,nm_rekening from ref_rekening where k='$fmBIDANG' and l !='0' and m = '0' and n='00' and o='00'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>JENIS</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBKELOMPOK",$fmSUBKELOMPOK,"select m,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m != '0' and n='00' and o='00'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>OBJEK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBSUBKELOMPOK",$fmSUBSUBKELOMPOK,"select n,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m = '$fmSUBKELOMPOK' and n!='00' and o='00'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>
			
			</table>".
			"</div>".
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Kode Rekening : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' size=20px>&nbsp
				Nama Rekening : <input type='text' id='fmBARANG' name='fmBARANG' value='".$fmBARANG."' size=30px>&nbsp
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
			</table>".
			"</div>".
			"<input type='hidden' id='fmORDER18' name='fmORDER18' value='".$fmORDER18."'>".
			"<input type='hidden' id='fmORDER19' name='fmORDER19' value='".$fmORDER19."'>";	
			"";
	}else{
		
		$TampilOpt = 
			
			"<div class='FilterBar'>".	
			"<table style='width:100%'>
			<tr>
			<td style='width:150px'>BIDANG</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery1("fmBIDANG",$fmBIDANG,"select k,nm_rekening from ref_rekening where k!='0' and l ='0' and m = '0' and n='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmKELOMPOK",$fmKELOMPOK,"select l,nm_rekening from ref_rekening where k='$fmBIDANG' and l !='0' and m = '0' and n='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>JENIS</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBKELOMPOK",$fmSUBKELOMPOK,"select m,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m != '0' and n='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>OBJEK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBSUBKELOMPOK",$fmSUBSUBKELOMPOK,"select n,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m = '$fmSUBKELOMPOK' and n!='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>
			
			</table>".
			"</div>".
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Kode Rekening : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' size=20px>&nbsp
				Nama Rekening : <input type='text' id='fmBARANG' name='fmBARANG' value='".$fmBARANG."' size=30px>&nbsp
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
			</table>".
			"</div>".
			"<input type='hidden' id='fmORDER18' name='fmORDER18' value='".$fmORDER18."'>".
			"<input type='hidden' id='fmORDER19' name='fmORDER19' value='".$fmORDER19."'>".	
			"<input type='hidden' id='mapping' name='mapping' value=''>";	
			"";
		
	}
	/*$TampilOpt = 
			
			"<div class='FilterBar'>".	
			"<table style='width:100%'>
			<tr>
			<td style='width:150px'>BIDANG</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery1("fmBIDANG",$fmBIDANG,"select k,nm_rekening from ref_rekening where k!='0' and l ='0' and m = '0' and n='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmKELOMPOK",$fmKELOMPOK,"select l,nm_rekening from ref_rekening where k='$fmBIDANG' and l !='0' and m = '0' and n='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SUB KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBKELOMPOK",$fmSUBKELOMPOK,"select m,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m != '0' and n='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SUB SUB KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBSUBKELOMPOK",$fmSUBSUBKELOMPOK,"select n,nm_rekening from ref_rekening where k='$fmBIDANG' and l ='$fmKELOMPOK' and m = '$fmSUBKELOMPOK' and n!='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
				</tr>
			
			</table>".
			"</div>".
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Kode Rekening : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' size=20px>&nbsp
				Nama Rekening : <input type='text' id='fmBARANG' name='fmBARANG' value='".$fmBARANG."' size=30px>&nbsp
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
			</table>".
			"</div>".
			"<input type='hidden' id='fmORDER18' name='fmORDER18' value='".$fmORDER18."'>".
			"<input type='hidden' id='fmORDER19' name='fmORDER19' value='".$fmORDER19."'>";	
			"";*/
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$arrKondisi = array();	
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
	 	$fmBIDANG = cekPOST('fmBIDANG');
	    $fmKELOMPOK = cekPOST('fmKELOMPOK');
		$fmSUBKELOMPOK = cekPOST('fmSUBKELOMPOK');
		$fmSUBSUBKELOMPOK = cekPOST('fmSUBSUBKELOMPOK');
		$fmKODE = cekPOST('fmKODE');
		$fmBARANG = cekPOST('fmBARANG');
		//Cari 
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			
			case 'selectKode': $arrKondisi[] = " concat(k,'.',l,'.',m,'.',n,'.',o) like '$fmPILCARIvalue%'"; break;
			case 'selectNama': $arrKondisi[] = " nm_rekening like '%$fmPILCARIvalue%'"; break;	
				
								 	
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
			
		}
		elseif(!empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k =$fmBIDANG";			
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k =$fmBIDANG and l=$fmKELOMPOK";
						
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k =$fmBIDANG and l=$fmKELOMPOK and m=$fmSUBKELOMPOK";
							
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k =$fmBIDANG and l=$fmKELOMPOK and m=$fmSUBKELOMPOK and n=$fmSUBSUBKELOMPOK";
			
		}
		if(!empty($_POST['fmKODE'])) $arrKondisi[] = " concat(k,'.',l,'.',m,'.',n,'.',o) like '".$_POST['fmKODE']."%'";					
		if(!empty($_POST['fmBARANG'])) $arrKondisi[] = " nm_rekening like '%".$_POST['fmBARANG']."%'";
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " k,l,m,n,o $Asc1 " ;break;
			case '2': $arrOrders[] = " nm_skpd $Asc1 " ;break;
			
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
$ref_rekening = new ref_rekeningObj();

/*if($Main->REK_DIGIT_O == 0){
	$ref_rekening->WHERE_O = "00";
}else{
	$ref_rekening->WHERE_O = "000";
}*/
?>