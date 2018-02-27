<?php

class linkerObj  extends DaftarObj2{	
	var $Prefix = 'linker';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'link'; //bonus
	var $TblName_Hapus = 'link';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'LINK';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='linker.xls';
	var $namaModulCetak='MASTER DATA';
	var $Cetak_Judul = 'LINK';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'linkerForm';
	var $noModul=9; 
	var $TampilFilterColapse = 0; //0
	
	function setTitle(){
		return 'LINK';
	}
	
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";		
	}
	
	function setMenuView(){
		return "";
			
	}
	
	function simpanKB(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
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
			if($err==''){
				$aqry = "INSERT into linker (k,l,m,n,o,nm_LINK) values('$ka01','$kb','0','00','00','$nama')";	
				$cek .= $aqry;	
				$qry = mysql_query($aqry);
				$content=$kb;	
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
	$nama= $_REQUEST['nm_LINK'];
	

	//$ke = substr($ke,1,1);
	
								
	if($err==''){						
		
	$aqry = "UPDATE linker set k='$dk',l='$dl',m='$dm',n='$dn',o='$do',nm_LINK='$nama' where concat (k,' ',l,' ',m,' ',n,' ',o)='".$idplh."'";$cek .= $aqry;
						$qry = mysql_query($aqry);
				}
								
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function simpanKD(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
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
			if($err==''){
				$aqrykd = "INSERT into linker (k,l,m,n,o,nm_LINK) values('$ka01','$kb','$kc','$kd','00','$nama')";	
				$cek .= $aqrykd;	
				$qry = mysql_query($aqrykd);
				$content=$kd;	
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
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
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
			if($err==''){
				$aqry = "INSERT into linker (k,l,m,n,o,nm_LINK) values('$ka01','$kb','$kc','00','00','$nama')";	
				$cek .= $aqry;	
				$qry = mysql_query($aqry);
				$content=$kc;	
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
    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
		if(empty($cmbPemda))$err = "Pilih Pemda";
		if(empty($atisisbada))$err = "Isi URL ATISISBADA";
		if(empty($penerimaan))$err = "Isi URL PENERIMAAN";
		if(empty($sotk_baru))$err = "Isi URL SOTK BARU";
		if(empty($perencanaan))$err = "Isi URL PERENCANAAN";
		if(empty($integrasi))$err = "Isi URL INTEGRASI";
		if(empty($persediaan))$err = "Isi URL PERSEDIAAN";
		
			
			if($fmST == 0){
				if($err == ''){
					$data = array(
								  'id_pemda' => $cmbPemda,
								  'atisisbada' => $atisisbada,
								  'penerimaan' => $penerimaan,
								  'sotk_baru' => $sotk_baru,
								  'perencanaan' => $perencanaan,
								  'integrasi' => $integrasi,
								  'persediaan' => $persediaan,
								
								);
					mysql_query(VulnWalkerInsert('link',$data));
					$cek = VulnWalkerInsert('link',$data);
				}
			}else{						
				$data = array(
								  'id_pemda' => $cmbPemda,
								  'atisisbada' => $atisisbada,
								  'penerimaan' => $penerimaan,
								  'sotk_baru' => $sotk_baru,
								  'perencanaan' => $perencanaan,
								  'integrasi' => $integrasi,
								  'persediaan' => $persediaan,
								
								);
				mysql_query(VulnWalkerUpdate('link',$data,"id='$hubla'"));
				$cek = VulnWalkerUpdate('link',$data,"id='$hubla'");
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

		case 'getdata':{
				$Id = $_REQUEST['id'];
				$k = substr($Id, 0,1);
				$l = substr($Id, 2,1);
				$m = substr($Id, 4,1);
				$n = substr($Id, 6,2);
				$o = substr($Id, 9,2);
				$get = mysql_fetch_array( mysql_query("select *, concat(k,'.',l,'.',m,'.',n,'.',o) as kodeLINK  from linker where k='$k' AND l='$l' AND m='$m' AND n='$n' AND o='$o'"));
			
				
				$content = array('kode_LINK' => $get['kodeLINK'], 'nm_LINK' => $get['nm_LINK']);
					
				
		break;
	    }


		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
		break;
		}
		case 'simpanPemda':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				if(mysql_num_rows(mysql_query("select * from ref_pemda where nama_pemda = '$namaPemda'")) > 0){
					$err = "Pemda Sudah Ada";
				}else{
					$data = array('nama_pemda' => $namaPemda);
					mysql_query(VulnWalkerInsert('ref_pemda',$data));
					$idnya = mysql_fetch_array(mysql_query("select * from ref_pemda where nama_pemda = '$namaPemda'"));
					$content = array('replacer' => cmbQuery('cmbPemda',$idnya['id'],"select id,nama_pemda from ref_pemda",'style="width:500;"','-- Pilih Pemda --') );
				}
		break;
		}
		
		case 'editPemda':{
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
				$data = array('nama_pemda' => $namaPemda);
				mysql_query(VulnWalkerUpdate("ref_pemda",$data,"id='$id'"));
				$idnya = mysql_fetch_array(mysql_query("select * from ref_pemda where nama_pemda = '$namaPemda'"));
				$content = array('replacer' => cmbQuery('cmbPemda',$idnya['id'],"select id,nama_pemda from ref_pemda",'style="width:500;"','-- Pilih Pemda --') );
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
		
		
		case 'formBaruPemda':{			
				$idPemda = $_REQUEST['idPemda'];
				$fm = $this->setFormBaruPemda($idPemda);				
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
	
	 function setFormBaruPemda($idPemda){
		
		$this->form_fmST = 0;
		
		$fm = $this->BaruPemda($idPemda);
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
	
		$ka = $_REQUEST['fmKA'];
		$kb = $_REQUEST['fmKB'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$queryl="SELECT l, concat(l, '. ', nm_LINK) as vnama FROM linker WHERE k='$ka' and l<>'0' and m = '0' and n='00' and o='00'" ;$cek.=$queryl;
		$content->unit=cmbQuery('fmKB',$fmkb,$queryl,'style="width:500;"onchange="'.$this->Prefix.'.pilihKB()"','&nbsp&nbsp----- Pilih Kode Kelompok -----')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKB()' title='Baru' >";
	
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function pilihKB(){
	global $Main;
		$ka = $_REQUEST['fmKA']; 
		$kb = $_REQUEST['fmKB'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
	 
		$queryKC="SELECT m, concat(m, '. ', nm_LINK) as vnama FROM linker WHERE k='$ka' and l='$kb' and m <> '0' and n='00' and o='00'" ;//$cek.=$queryKC;
		$content->unit=cmbQuery('fmKC',$fmkc,$queryKC,'style="width:500;"onchange="'.$this->Prefix.'.pilihKC()"','&nbsp&nbsp-------- Pilih Jenis --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKC()' title='Baru' >";$cek.=$queryJenis;
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function pilihKC(){
	global $Main;
		$ka = $_REQUEST['fmKA']; 
		$kb = $_REQUEST['fmKB'];
		$kc = $_REQUEST['fmKC'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
	 
		$queryKD="SELECT n, concat(n, '. ', nm_LINK) as vnama FROM linker WHERE k='$ka' and l='$kb' and m = '$kc' and n <> '00' and o='00'" ;$cek.=$queryKD;
		$content->unit=cmbQuery('fmKD',$fmkd,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Sub Objek --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";$cek.=$queryJenis;
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	/*function pilihKD(){
	global $Main;
		$ka = $_REQUEST['fmKA']; 
		$kb = $_REQUEST['fmKB'];
		$kc = $_REQUEST['fmKC'];
		$kd = $_REQUEST['fmKD'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
	 
		$queryKE="SELECT o, concat(o, '. ', nm_LINK) as vnama FROM linker WHERE k='$ka' and l='$kb' and m = '$kc' and n='$kd' and o='00'" ;$cek.=$queryKD;
		$content->unit=cmbQuery('fmKD',$fmkd,$queryKD,'style="width:210;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Sub Objek --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";$cek.=$queryJenis;
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}*/
	
	function pilihKD(){
	global $Main;
	
		$ka = $_REQUEST['fmKA']; 
		$kb = $_REQUEST['fmKB'];
		$kc = $_REQUEST['fmKC'];
		$kd = $_REQUEST['fmKD'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
	 
	//	$queryKE="SELECT max(o) as o, nm_LINK FROM linker WHERE k='$ka' and l='$kb' and m = '$kc' and n='$kd' and n <> '0' and o='0'" ;$cek.=$queryKE;
		$queryKE="SELECT max(o) as o, nm_LINK FROM linker WHERE k='$ka' and l='$kb' and m = '$kc' and n='$kd'" ;$cek.=$queryKE;
		/*$content->unit=cmbQuery('fmKE',$fmke,$queryKE,'style="width:210;"onchange="'.$this->Prefix.'.pilihKE()"','&nbsp&nbsp-------- Pilih Sub Rincian Objek --------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruJenis()' title='Baru' >";$cek.=$queryJenis;*/
	 
		$get=mysql_fetch_array(mysql_query($queryKE));
		$lastkode=$get['o'] + 1;	
		$kode_o = sprintf("%02s", $lastkode);
		$content->ke=$kode_o;
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function refreshKB(){
	global $Main;
	 
		$ka02 = $_REQUEST['fmKA'];	 
		$kb02 = $_REQUEST['fmKB'];
	//	$fmJenis2 = $_REQUEST['fmJenis2'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kbnew= $_REQUEST['id_KBBaru'];
	 
		$queryKB="SELECT l, concat(l, '. ', nm_LINK) as vnama FROM linker WHERE k='$ka02' and l <> '0' and m='0' and n='00' and o='00'" ;
		//$cek.="SELECT kb,nm_account FROM ref_jurnal WHERE ka='$ka02' and kb <> '0' and kc='0' and kd='0' and ke='0' and kf='0'";
		$cek.="SELECT l, concat(l, '. ', nm_LINK) as vnama FROM linker WHERE k='$ka02' and l <> '0' and m='0' and n='00' and o='00'";
		$content->unit=cmbQuery('fmKB',$kbnew,$queryKB,'style="width:500;"onchange="'.$this->Prefix.'.pilihKB()"','&nbsp&nbsp-------- Pilih Kelompok -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKB()' title='Baru' >";
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}	
	
	function refreshKC(){
	global $Main;
	 
		$ka02 = $_REQUEST['fmKA'];	 
		$kb02 = $_REQUEST['fmKB'];
		$kc02 = $_REQUEST['fmKC'];
	//	$fmJenis2 = $_REQUEST['fmJenis2'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kcnew= $_REQUEST['id_KCBaru'];
	 
		$queryKC="SELECT m, concat(m, '. ', nm_LINK) as vnama FROM linker WHERE k='$ka02' and l='$kb02' and m<>'0' and n='00' and o='00'" ;
		//$cek.="SELECT kb,nm_account FROM ref_jurnal WHERE ka='$ka02' and kb <> '0' and kc='0' and kd='0' and ke='0' and kf='0'";
		$cek.="SELECT m, concat(m, '. ', nm_LINK) as vnama FROM linker WHERE k='$ka02' and l='$kc02' and m<>'0' and n='00' and o='00'";
		$content->unit=cmbQuery('fmKC',$kcnew,$queryKC,'style="width:500;"onchange="'.$this->Prefix.'.pilihKC()"','&nbsp&nbsp-------- Pilih Jenis -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKC()' title='Baru' >";
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}	
	
	function refreshKD(){
	global $Main;
	 
		$ka02 = $_REQUEST['fmKA'];	 
		$kb02 = $_REQUEST['fmKB'];
		$kc02 = $_REQUEST['fmKC'];
		$kd02 = $_REQUEST['fmKD'];
	//	$fmJenis2 = $_REQUEST['fmJenis2'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kdnew= $_REQUEST['id_KDBaru'];
	 
	 $queryKD="SELECT n, concat(n,' . ', nm_LINK) as vnama  FROM linker WHERE k='$ka02' and l='$kb02' and m='$kc02' and n<>'00' and o='00'" ;
	 
		$koden=$queryKD['kd'];
		$new = sprintf("%02s", $koden);
		$kode_n=$new.".".$queryKD['nm_LINK'];
	
		$content->unit=cmbQuery('fmKD',$kdnew,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Objek -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function getKode_o(){
	 global $Main;
	 
	 	$ka02 = $_REQUEST['fmKA'];	 
		$kb02 = $_REQUEST['fmKB'];
		$kc02 = $_REQUEST['fmKC'];
		$kd02 = $_REQUEST['fmKD'];
		$ke02 = $_REQUEST['fmKE'];
	//	$ke02 = $_REQUEST['ke'];
	//	$fmJenis2 = $_REQUEST['fmJenis2'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kenew= $_REQUEST['id_KEBaru'];
	 
	 	$aqry5="SELECT MAX(o) AS maxno FROM linker WHERE k='$ka02' and l='$kb02' and m='$kc02' and n='$kd02'";
	 	$cek.="SELECT MAX(o) AS maxno FROM linker WHERE k='$ka02' and l='$kb02' and m='$kc02' and n='$kd02'";
		$get=mysql_fetch_array(mysql_query($aqry5));
		$newke=$get['maxno'] + 1;
		$newke1 = sprintf("%02s", $newke);
		$content->ke=$newke1;	
	
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
	 
		$queryKD="SELECT n, concat(n, '. ', nm_LINK) as vnama FROM linker WHERE k='$ka02' and l='$kb02' and m'$kc02' and n<>'00' and o='00'" ;
		//$cek.="SELECT kb,nm_account FROM ref_jurnal WHERE ka='$ka02' and kb <> '0' and kc='0' and kd='0' and ke='0' and kf='0'";
		$cek.="SELECT n, concat(n, '. ', nm_LINK) as vnama FROM linker WHERE k='$ka02' and l='$kb02' and m='$kc02' and n<>'00' and o='00'";
		$content->unit=cmbQuery('fmKD',$kdnew,$queryKD,'style="width:210;"onchange="'.$this->Prefix.'.pilihKD()"','&nbsp&nbsp-------- Pilih Objek -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKD()' title='Baru' >";
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}	*/
	
	function BaruKB($dt){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 500;
	 $this->form_height = 100;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru Kode Kelompok';
		$nip	 = '';
		$KA1 = $_REQUEST ['fmKA'];
			
		$aqry2="SELECT MAX(l) AS maxno FROM linker WHERE k='$KA1'";
		//$cek.="SELECT MAX(l) AS maxno FROM linker WHERE k='$KA1'";
		$get=mysql_fetch_array(mysql_query($aqry2));
//		$lastkode=$get['maxno'] + 1;
		$newkb=$get['maxno'] + 1;
		
	//	 if( $err=='' && $k =='' ) $err= 'Kode LINK Belum Di Isi !!';
		/*$kode = (int) substr($lastkode, 1, 3);
		$kode++;
		$no_ba = sprintf("%1s", $kode);*/
		$queryKA1=mysql_fetch_array(mysql_query("SELECT k, nm_LINK FROM linker where l=0 and m=0 and n=00 and o=00"));  

		$datak1=$queryKA1['k'].".".$queryKA1['nm_LINK'];
		
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
						<input type='text' name='LINK' id='LINK' value='".$datak1."' style='width:255px;' readonly>
						
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
	
	function BaruPemda($dt){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 500;
	 $this->form_height = 80;
	 
	 if(!empty($dt)){
	 	$this->form_caption = 'Edit Pemda';
		$kemana = "EditPemda($dt)";
		$namaPemda = mysql_fetch_array(mysql_query("select * from ref_pemda where id='$dt'"));
		$namaPemda = $namaPemda['nama_pemda'];
	 }else{
	 	if ($this->form_fmST==0) {
		$this->form_caption = 'Baru Pemda';
		$nip	 = '';
		$KA1 = $_REQUEST ['fmKA'];
			
		$kemana = 'SimpanPemda()';
		
	  }
	 }
	  
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		
	 //items ----------------------
	  $this->form_fields = array(
			
			'Kelompok' => array( 
						'label'=>'Nama Pemda',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='namaPemda' id='namaPemda' value='$namaPemda' style='width:255px;' >

						</div>", 
						 ),	
									 			
				
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".$kemana' title='Simpan' >"."&nbsp&nbsp".
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
		
	
		$aqry4="SELECT MAX(n) AS maxno FROM linker WHERE k='$KA1' and l='$KB1' and m='$KC1'";
		$cek.="SELECT MAX(n) AS maxno FROM linker WHERE k='$KA1' and l='$KB1' and m='$KC1'";
		$get=mysql_fetch_array(mysql_query($aqry4));

		$newkm=$get['maxno'] + 1;
		$newkm1 = sprintf("%02s", $newkm);
		$queryKA1=mysql_fetch_array(mysql_query("SELECT k, nm_LINK FROM linker where l=0 and m=0 and n=00 and o=00"));  
		$queryKB1=mysql_fetch_array(mysql_query("SELECT l, nm_LINK FROM linker where k='$KA1' and l='$KB1' and m=0 and n=00 and o=00"));  
		$queryKC1=mysql_fetch_array(mysql_query("SELECT m, nm_LINK FROM linker where k='$KA1' and l='$KB1' and m='$KC1' and n=00 and o=00"));  
		$cek.="SELECT m, nm_LINK FROM linker where k='$KA1' and l='$KB1' and m='$KC1' and n=00 and o=00";
//		
		$datak1=$queryKA1['k'].".".$queryKA1['nm_LINK'];
		$datak2=$queryKB1['l'].".".$queryKB1['nm_LINK'];
		$datak3=$queryKC1['m'].".".$queryKC1['nm_LINK'];
		
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
		
	
		$aqry3="SELECT MAX(m) AS maxno FROM linker WHERE k='$KA1' and l='$KB1'";
		$cek.="SELECT MAX(m) AS maxno FROM linker WHERE k='$KA1' and l='$KB1'";
		$get=mysql_fetch_array(mysql_query($aqry3));

		$newkm=$get['maxno'] + 1;
		$queryKA1=mysql_fetch_array(mysql_query("SELECT k, nm_LINK FROM linker where l=0 and m=0 and n=00 and o=00"));  
		$queryKB1=mysql_fetch_array(mysql_query("SELECT l, nm_LINK FROM linker where k='$KA1' and l='$KB1' and m=0 and n=00 and o=00"));  
		$cek.="SELECT l, nm_LINK FROM linker where k='$KA1' and l='$KB1' and m=0 and n=00 and o=00";
//		
		$datak1=$queryKA1['k'].".".$queryKA1['nm_LINK'];
		$datak2=$queryKB1['l'].".".$queryKB1['nm_LINK'];
	//	$datakelompok=$queryKelompok['g'].".".$queryKelompok['nama'];
	//	$dataobjek=$queryObjek['h'].".".$queryObjek['nama'];
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
			 <script type='text/javascript' src='js/linker/linker.js' language='JavaScript' ></script>
			 ".
			
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
		$cek ='';
		
		foreach ($_REQUEST as $key => $value) { 
			  $$key = $value; 
			}
		$this->form_fmST = 1;
		
		$fm = $this->setForm($linker_cb[0]);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	
	function setFormEditdata($dt){	
	 global $SensusTmp ,$Main;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 490;
	 $this->form_height = 150;
	  if ($this->form_fmST==1) {
		$this->form_caption = 'FORM EDIT KODE LINK';
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
		
		
		
		$queryKAedit=mysql_fetch_array(mysql_query("SELECT k, nm_LINK FROM linker WHERE k='$k' and l = '0' and m='0' and n='00' and o='00'")) ;
		$cek.=$queryKAedit;
		$queryKBedit=mysql_fetch_array(mysql_query("SELECT l, nm_LINK FROM linker WHERE k='$k' and l='$l' and m= '0' and n='00' and o='00'")) ;
		$queryKCedit=mysql_fetch_array(mysql_query("SELECT m, nm_LINK FROM linker WHERE k='$k' and l='$l' and m='$m' and n='00' and o='00'")) ;
		$queryKDedit=mysql_fetch_array(mysql_query("SELECT n, nm_LINK FROM linker WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='00'")) ;
		$queryKEedit=mysql_fetch_array(mysql_query("SELECT o, nm_LINK FROM linker WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o'")) ;
	//	$cek.="SELECT ke, nm_account FROM ref_jurnal WHERE ka='$data_ka' and kb='$data_kb' and kc='$data_kc' and kd='$data_kd' and ke='$data_ke' and kf='0'";
					
	
		$datka=$queryKAedit['k'].".  ".$queryKAedit['nm_LINK'];
		$datkb=$queryKBedit['l'].". ".$queryKBedit['nm_LINK'];
		$datkc=$queryKCedit['m']." .  ".$queryKCedit['nm_LINK'];
		$datkd=$queryKDedit['n'].". ".$queryKDedit['nm_LINK'];
		$datke=$queryKEedit['o'];
	//	$datke=sprintf("%02s",$queryKEedit['ke'])." .  ".$queryKEedit['nm_account'];
		
       //items ----------------------
		  $this->form_fields = array(
		  
		  'kode_Akun' => array( 
						'label'=>'kode LINK',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='ek' id='ek' value='".$datka."' style='width:270px;' readonly>
						<input type ='hidden' name='k' id='k' value='".$queryKAedit['k']."'>
						</div>", 
						 ),
			'kode_kelompok' => array( 
						'label'=>'Kode Kelompok',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='el' id='el' value='".$datkb."' style='width:270px;' readonly>
						<input type ='hidden' name='l' id='l' value='".$queryKBedit['l']."'>
						</div>", 
						 ),
			'kode_Jenis' => array( 
						'label'=>'kode Jenis',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='em' id='em' value='".$datkc."' style='width:270px;' readonly>
						<input type ='hidden' name='m' id='m' value='".$queryKCedit['m']."'>
						</div>", 
						 ),
			'kode_Objek' => array( 
						'label'=>'kode Objek',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='en' id='en' value='".$datkd."' style='width:270px;' readonly>
						<input type ='hidden' name='n' id='n' value='".$queryKDedit['n']."'>
						</div>", 
						 ),
			'Kode_Rincian_Objek' => array( 
						'label'=>'Kode Rincian Objek',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='eo' id='eo' value='".$datke."' style='width:20px;' readonly>
						<input type ='hidden' name='o' id='o' value='".$queryKEedit['o']."'>
						<input type='text' name='nm_LINK' id='nm_LINK' value='".$dt['nm_LINK']."' size='36px'>
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
	 			
	$this->form_width = 720;
	 $this->form_height = 200;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
		
	//	$nip	 = '';
	  }else{
		$this->form_caption = 'Edit';			
		$readonly='readonly';
		$get = mysql_fetch_array(mysql_query("select * from link where id ='$dt'"));
		foreach ($get as $key => $value) { 
			  $$key = $value; 
			}	
					
	  }
	    //ambil data trefditeruskan
	  $cmbPemda = cmbQuery('cmbPemda',$id_pemda,"select id,nama_pemda from ref_pemda",'style="width:400;"','-- Pilih Pemda --');
	 //items ----------------------
	  $this->form_fields = array(
			
			'nama_pemda' => array( 
						'label'=>'NAMA PEMDA',
						'labelWidth'=>120, 
						'value'=> $cmbPemda."&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".PemdaBaru()' title='Kode Kelompok' >" ."&nbsp&nbsp&nbsp"."<input type='button' value='Edit' onclick ='".$this->Prefix.".PemdaEdit()' title='Kode Kelompok' >" 
						 ),	
						 	
			
			'atisisbada' => array( 
						'label'=>'URL ATISISBADA',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='atisisbada' id='atisisbada' value='".$atisisbada."' placeholder='URL ATISISBADA' style='width:500px;'>
						</div>", 
						 ),	
			'penerimaan' => array( 
						'label'=>'URL PENERIMAAN',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='penerimaan' id='penerimaan' value='".$penerimaan."' placeholder='URL PENERIMAAN' style='width:500px;'>
						</div>", 
						 ),		
			'sotk_baru' => array( 
						'label'=>'URL SOTK BARU',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='sotk_baru' id='sotk_baru' value='".$sotk_baru."' placeholder='URL SOTK BARU' style='width:500px;'>
						</div>", 
						 ),
			'perencanaan' => array( 
						'label'=>'URL PERENCANAAN',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='perencanaan' id='perencanaan' value='".$perencanaan."' placeholder='URL PERENCANAAN' style='width:500px;'>
						</div>", 
						 ),	
			 'integrasi' => array( 
						'label'=>'URL INTEGRASI',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='integrasi' id='integrasi' value='".$integrasi."' placeholder='URL INTEGRASI' style='width:500px;'>
						</div>", 
						 ),	
			'persediaan' => array( 
						'label'=>'URL PERSEDIAAN',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='persediaan' id='persediaan' value='".$persediaan."' placeholder='URL PERSEDIAAN' style='width:500px;'>
						</div>", 
						 ),		
			
			);
		//tombol
		$this->form_menubawah =
			
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan($dt)' title='Simpan' > &nbsp".
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
	<A href=\"pages.php?Pg=linker\" title='LINK' style='color:blue'  >LINK</a> |
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
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox		
	   <th class='th01' width='500' >NAMA PEMDA</th>
	   <th class='th01' width='100' align='center'>ATISISBADA</th>
	   <th class='th01' width='100' align='center'>PENERIMAAN</th>
	   <th class='th01' width='100' align='center'>PERENCANAAN</th>
	   <th class='th01' width='100' align='center'>SOTK BARU</th>
	   <th class='th01' width='100' align='center'>INTEGRASI</th>
	   <th class='th01' width='100' align='center'>PERSEDIAAN</th>
	   
	   
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) { 
			  $$key = $value; 
			}
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $nama_pemda = mysql_fetch_array(mysql_query("select * from ref_pemda where id = '$id_pemda'"));
	 $Koloms[] = array('align="left"',$nama_pemda['nama_pemda']);
	 $Koloms[] = array('align="center"',"<a target='_blank' href ='$atisisbada'>URL</a>");
	 $Koloms[] = array('align="center"',"<a target='_blank' href ='$penerimaan'>URL</a>");
	 $Koloms[] = array('align="center"',"<a target='_blank' href ='$perencanaan'>URL</a>");
	 $Koloms[] = array('align="center"',"<a target='_blank' href ='$sotk_baru'>URL</a>");
	 $Koloms[] = array('align="center"',"<a target='_blank' href ='$integrasi'>URL</a>");
	 $Koloms[] = array('align="center"',"<a target='_blank' href ='$persediaan'>URL</a>");
	 
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
	 
		
	
				
	$TampilOpt = 
			"<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td>CARI </td>
			<td>:</td>
			<td style='width:90%;'> 
			<input type = 'text' name ='cariPemda' id ='cariPemda' value ='$cariPemda'> <input type='button' value ='Cari' onclick =$this->Prefix.refreshList(true);>
			</td>
			</tr>
			<tr>

			
			
			
			
			
			</table>".
			"</div>";
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$arrKondisi = array();	
		
		
		$cariPemda = $_REQUEST['cariPemda'];
		if(!empty($cariPemda)){
			$exc = mysql_query("select id from ref_pemda where nama_pemda like '%$cariPemda%'");
			$connn = array();
			while($rows = mysql_fetch_array($exc)){
				$connn[] = " id_pemda = '$rows[0]'";
			}
			
			if(sizeof($jsjs) != 1){
				$jsjs = join(' or ',$connn);
				$arrKondisi[] = "( $jsjs )";
			}else{
				$arrKondisi[] = $connn[0];
			}
			
			
			
		}

		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();

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
$linker = new linkerObj();
?>