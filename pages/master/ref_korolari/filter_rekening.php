<?php

class filter_rekeningObj  extends DaftarObj2{	
	var $Prefix = 'filter_rekening';
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
	var $FormName = 'filter_rekeningForm';
	var $noModul=9; 
	var $TampilFilterColapse = 0; //0
	var $WHERE_O = "";
	
	function setTitle(){
		return 'REKENING';
	}
	
	function setMenuEdit(){
		return "";
			
	}
	
	function setMenuView(){
		return "";	
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
	

	//$ke = substr($ke,1,1);
	
								
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
	 	
	
	
	 
			
			
			if($fmST == 0){
		
				if($err==''){
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
		$ref_pilihrekening = $_REQUEST['id'];
		//query ambil data ref_rekening
		$getRekening = mysql_fetch_array(mysql_query("select concat(k,'.',l,'.',m,'.',n,'.',o) as kode_rekening, nm_rekening from ref_rekening where concat(k,'.',l,'.',m,'.',n,'.',o)  = '$ref_pilihrekening' "));
		
		$kode_rekening = $getRekening['kode_rekening'];	
		$nama_rekening = $getRekening['nm_rekening'];
			
		$content = array('kode_rekening' => $kode_rekening, 'nm_rekening' => $nama_rekening);
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

	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';		
		$form_name = $this->FormName;
		$ref_jenis=$_GET['status_filter'];
		$filterRekening = $_REQUEST['filterRekening'];
		$status_filter=1;
		//if($err==''){
			$FormContent = $this->genDaftarInitial();
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						900,
						500,
						'Pilih Rekening',
						'',
					//	"<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".
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
	 $this->form_width = 400;
	 $this->form_height = 80;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru Kode Kelompok';
		$nip	 = '';
		$KA1 = $_REQUEST ['fmKA'];
			
		$aqry2="SELECT MAX(l) AS maxno FROM ref_rekening WHERE k='$KA1'";$cek.=$aqry2;
		$get=mysql_fetch_array(mysql_query($aqry2));
		$newkb=$get['maxno'] + 1;
		
		if($REK_DIGIT_O==0){
			
			$queryKA1=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where l=0 and m=0 and n=00 and o=00"));  $cek.="SELECT k, nm_rekening FROM ref_rekening where l=0 and m=0 and n=00 and o=00";
			$datak1=$queryKA1['k'].".".$queryKA1['nm_rekening'];
			
		}else{
			$queryKA1=mysql_fetch_array(mysql_query("SELECT k, nm_rekening FROM ref_rekening where l=0 and m=0 and n=00 and o=000"));  
			$cek.="SELECT k, nm_rekening FROM ref_rekening where l=0 and m=0 and n=00 and o=000";
			$datak1=$queryKA1['k'].".".$queryKA1['nm_rekening'];	
		}
		
		
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
						<input type='text' name='rekening' id='rekening' value='".$datak1."' style='width:255px;' readonly>
						
						<input type ='hidden' name='k' id='k' value='".$queryKA1['k']."'>
						</div>", 
						 ),	
									 			
			'kode_kelompok' => array( 
						'label'=>'Kode Kelompok',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='l' id='l' value='".$newkb."' style='width:50px;' readonly>
					
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Kelompok' style='width:200px;'>
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
	 $this->form_width = 500;
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
						<input type='text' name='Akun' id='Akun' value='".$datak1."' style='width:255px;' readonly>
						
						<input type ='hidden' name='k' id='k' value='".$queryKA1['k']."'>
						</div>", 
						 ),	
			
			'kode_Kelompok' => array( 
						'label'=>'Kode Kelompok',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='Kelompok' id='Kelompok' value='".$datak2."' style='width:255px;' readonly>
						
						<input type ='hidden' name='l' id='l' value='".$queryKB1['l']."'>
						</div>", 
						 ),	
						 
			'kode_jenis' => array( 
						'label'=>'Kode Jenis',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='jenis' id='jenis' value='".$datak3."' style='width:255px;' readonly>
						<input type ='hidden' name='m' id='m' value='".$queryKC1['m']."'>
						</div>", 
						 ),				 
									 		
			'kode_objek' => array( 
						'label'=>'Kode Objek',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='n' id='n' value='".$newkm1."' style='width:50px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Objek' style='width:200px;'>
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
	 $this->form_width = 500;
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
						<input type='text' name='Akun' id='Akun' value='".$datak1."' style='width:255px;' readonly>
						
						<input type ='hidden' name='k' id='k' value='".$queryKA1['k']."'>
						</div>", 
						 ),	
			
			'kode_Kelompok' => array( 
						'label'=>'Kode Kelompok',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='Kelompok' id='Kelompok' value='".$datak2."' style='width:255px;' readonly>
						<input type ='hidden' name='l' id='l' value='".$queryKB1['l']."'>
						</div>", 
						 ),	
									 			
			'kode_jenis' => array( 
						'label'=>'Kode Jenis',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='m' id='m' value='".$newkm."' style='width:50px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Kelompok' style='width:200px;'>
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
			 <script type='text/javascript' src='js/master/ref_korolari/filter_rekening.js' language='JavaScript' ></script>
			
			 ".
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".
			
			$scriptload;
	}
	
	//form ==================================
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
		$aqry = "SELECT * FROM  ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setFormEditdata($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
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
		$this->form_fmST = 3;				
		//get data 
		$aqry = "SELECT * FROM  ref_rekening WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setFormMappingData($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	
	
	
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>		
	   <th class='th01' width='400' colspan='5'>Kode</th>
	   <th class='th01' width='900' align='cente'>Nama</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref, $Main;
	 
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	 
	 $Koloms[] = array('align="center"',genNumber($isi['k'],1));
	 $Koloms[] = array('align="center"',genNumber($isi['l'],1));
	 $Koloms[] = array('align="center"',genNumber($isi['m'],1));
	 $Koloms[] = array('align="center"',genNumber($isi['n'],2));
	 if($Main->REK_DIGIT_O == 0){
	 	$Koloms[] = array('align="center"',genNumber($isi['o'],2));
	 }else{
	 	$Koloms[] = array('align="center"',genNumber($isi['o'],3));
	 }
	 $kode_rekening = $isi['k'].".".$isi['l'].".".$isi['m'].".".$isi['n'].".".$isi['o'];
	 $Koloms[] = array('align="left" width="" ',"<a style='cursor:pointer;' onclick=filter_rekening.windowSave('$kode_rekening')>".$isi['nm_rekening']."</a>");
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	$REK_DIGIT_O=$Main->REK_DIGIT_O; 
	$fmKELOMPOK = cekPOST('fmKELOMPOK');
	$fmSUBKELOMPOK = cekPOST('fmSUBKELOMPOK');
	$fmSUBSUBKELOMPOK = cekPOST('fmSUBSUBKELOMPOK');
	$fmKODE = cekPOST('fmKODE');
	$fmBARANG = cekPOST('fmBARANG');			
	
	 $arr = array(
			array('selectfg','Kode Barang'),
			array('selectbarang','Nama Barang'),	
			);
		
	$arrayJenisbarang = array(
								array('5', '5.BELANJA'),
								array('7', '7.PERHITUNGAN FIHAK KETIGA (PFK)'),
								);
	$filterJenisBarang = $_REQUEST['filterRekening'];					
	$comboJenisBarang = cmbArray('filterRekening',$filterJenisBarang,$arrayJenisbarang,'Pilih',"onchange = $this->Prefix.refreshList(true);");	
	
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
			<td style='width:150px'>BIDANG </td><td style='width:10px'>:</td>
			<td>".
			$comboJenisBarang.
			"</td>
			</tr><tr>
			<td>KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmKELOMPOK",$fmKELOMPOK,"select l,nm_rekening from ref_rekening where k='$filterJenisBarang' and l !='0' and m = '0' and n='00' and o='00'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SUB KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBKELOMPOK",$fmSUBKELOMPOK,"select m,nm_rekening from ref_rekening where k='$filterJenisBarang' and l ='$fmKELOMPOK' and m != '0' and n='00' and o='00'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SUB SUB KELOMPOK</td><td>:</td>
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
			"<input type='hidden' id='filterRekening' name='filterRekening' value='".$filterRekening."'>".
			"<input type='hidden' id='fmORDER19' name='fmORDER19' value='".$fmORDER19."'>";	
			"";
	}else{
		
		$TampilOpt = 
			
			"<div class='FilterBar'>".	
			"<table style='width:100%'>
			<tr>
			<td style='width:150px'>BIDANG </td><td style='width:10px'>:</td>
			<td>".
			$comboJenisBarang.
			"</td>
			</tr>
			<tr>
			<td>KELOMPOK </td><td>:</td>
			<td>".
			cmbQuery1("fmKELOMPOK",$fmKELOMPOK,"select l,nm_rekening from ref_rekening where k='$filterJenisBarang' and l !='0' and m = '0' and n='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SUB KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBKELOMPOK",$fmSUBKELOMPOK,"select m,nm_rekening from ref_rekening where k='$filterJenisBarang' and l ='$fmKELOMPOK' and m != '0' and n='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SUB SUB KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBSUBKELOMPOK",$fmSUBSUBKELOMPOK,"select n,nm_rekening from ref_rekening where k='$filterJenisBarang' and l ='$fmKELOMPOK' and m = '$fmSUBKELOMPOK' and n!='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
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
		
	}
	
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$arrKondisi = array();	
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
	 	$filterJenisBarang = $_REQUEST['filterRekening'];
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
		
		if(empty($filterJenisBarang)) {
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
		
		if(empty($filterJenisBarang) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k in(5,7) and l!=0 and m!=0 and n!=0 and o!=0";	
		}
		elseif(!empty($filterJenisBarang) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k =$filterJenisBarang and l!=0 and m!=0 and n!=0 and o!=0";			
		}
		elseif(!empty($filterJenisBarang) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k =$filterJenisBarang and l=$fmKELOMPOK and m!=0 and n!=0 and o!=0";
						
		}
		elseif(!empty($filterJenisBarang) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k =$filterJenisBarang and l=$fmKELOMPOK and m=$fmSUBKELOMPOK and n!=0 and o!=0";
							
		}
		elseif(!empty($filterJenisBarang) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k =$filterJenisBarang and l=$fmKELOMPOK and m=$fmSUBKELOMPOK and n=$fmSUBSUBKELOMPOK and o!=0";
			
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
$filter_rekening = new filter_rekeningObj();

/*if($Main->REK_DIGIT_O == 0){
	$ref_rekening->WHERE_O = "00";
}else{
	$ref_rekening->WHERE_O = "000";
}*/
?>