<?php

class refprogramObj  extends DaftarObj2{	
	var $Prefix = 'refprogram';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_program'; //daftar
	var $TblName_Hapus = 'ref_program';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('bk','ck','dk','p','q');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Data';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='Ref Program.xls';
	var $Cetak_Judul = 'Daftar Program/Kegiatan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'refprogramForm';
	var $kd_urusan=''; 	
	
	var $arrayKategori = array( 
					 array('0','PENGADAAN DAN PEMELIHARAAN'),
					 array('1','PENGADAAN'),
					 array('2','PEMELIHARAAN')
		);
	
	
			
	function setTitle(){
		return 'Daftar Program/Kegiatan';
	}
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
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
	
	//function setPage_IconPage(){		return 'images/masterData_ico.gif';	}	
	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $bk = $_REQUEST['bk'];
     $ck= $_REQUEST['ck'];
	 $dk= $_REQUEST['dk'];
	 $program= $_REQUEST['fmprogram'];
	 $kegiatan= $_REQUEST['kegiatan'];
	 $nama = $_REQUEST['nama'];
	 $kategory = $_REQUEST['kategory'];
	 
	 if($bk==''){
	 	$bk='0';
	 }else{
	 	$bk=$bk;
	 }
	 
	 if($ck==''){
	 	$ck='0';
	 }else{
	 	$ck=$ck;
	 }	
	 
	 if($dk==''){
	 	$dk='0';
	 }else{
	 	$dk=$dk;
	 }		
		
	 if( $err=='' && $program =='' ) $err= 'Kode Program Belum Di Pilih !!';
	 if( $err=='' && $nama =='' ) $err= 'Nama Kegiatan Belum Di Isi !!';
	 
	 	if($fmST == 0){
			$ck1=mysql_fetch_array(mysql_query("Select * from ref_program where bk= '$bk' and ck='$ck' and dk ='$dk' and p ='$program' and q='$kegiatan' and nama='$nama'"));
			if ($ck1>=1)$err= 'Gagal Simpan'.mysql_error();
				if($err==''){
					$aqry = "INSERT into ref_program (bk,ck,dk,p,q,nama,kategori) values('$bk','$ck','$dk','$program','$kegiatan','$nama','$kategory')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	
	function simpan1(){
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
	  
	  if($fmST == 0){ 
	   if(empty($cmbProgram))$err = "Program Belum Di Pilih";
	   if(empty($nama_kegiatan))$err = "Nama Kegiatan Belum Di Isi";
	   if(empty($fmbk) || $fmbk == "0"){
	   	  $fmck = "0";
		  $fmdk = "0";	
	   }else{
	   	  if(empty($fmdk) || $fmdk == 'NULL'){
		  	$fmdk = "0";
		  }
	   }
	   
	   $data = array("bk" => $fmbk,
	   				 "ck" => $fmck,
					 "dk" => $fmdk,
					 "p" => $cmbProgram,
					 "nama" => $nama_kegiatan,
					 "q" => $kegiatan,
					 "kategori" => $kategori
					 );
	  $query = VulnWalkerInsert("ref_program",$data);
	  mysql_query($query);
	  $content = array("query" => $query);
	   
	  	
			
	  }elseif($fmST == 1){
										

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
		
		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
			break;
		}
		
		case 'refreshProgram':{
				$get= $this->refreshProgram();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    	}
		case 'getProgram':{
			$get= $this->getProgram();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
	   	case 'getdata':{

		$ref_pilihprogram = $_REQUEST['id'];
		$kode_program = explode(' ',$ref_pilihprogram);
		$bk=$kode_program[0];	
		$ck=$kode_program[1];
		$dk=$kode_program[2];	
		$p=$kode_program[3];
		$q=$kode_program[4];
		if($q==0 && $p<>0) $err='Pilih Kode Kegiatan yang tidak sama dengan 0 !';
		if($err == ''&& $q==0) $err='Kegiatan belum dipilih!';
		if ($err=='' ){
			
		
			//query ambil data ref_program
			$get = mysql_fetch_array( mysql_query("select * from ref_program where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q=0"));
			if($Main->VERSI_NAME=='PANDEGLANG'){
				$kode_program=$get['bk'].'.'.$get['ck'].'.'.$get['p'];
			}else{
				$kode_program=$get['bk'].'.'.$get['ck'].'.'.$get['dk'].'.'.$get['p'];	
			}
			$nm_program = $get['nama'];
			
			$get = mysql_fetch_array( mysql_query("select * from ref_program where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'"));
			if($Main->VERSI_NAME=='PANDEGLANG'){
				$kode_kegiatan=$get['bk'].'.'.$get['ck'].'.'.$get['p'].'.'.$get['q'];
			}else{
				$kode_kegiatan=$get['bk'].'.'.$get['ck'].'.'.$get['dk'].'.'.$get['p'].'.'.$get['q'];
			}
			$nm_kegiatan = $get['nama'];
			
			$content = array('kode_program'=>$kode_program, 'nama_program'=>$nm_program, 
				'kode_kegiatan'=>$kode_kegiatan, 'nama_kegiatan'=>$nm_kegiatan,
				'bk'=>$bk, 'ck'=>$ck, 'dk'=>$dk, 'p'=>$p, 'q'=>$q, );	
		}
		break;
	   }
	   
	   case 'programBaru' : {	
				$fm = $this->programBaru($dt);				
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
				break;
	   }
       case 'simpanProgram':{
				$get= $this->simpanProgram();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    }
	   
	    case 'pilihProgram':{				
		global $Main;
			
			$bk = $_REQUEST['bk'];
			$ck = $_REQUEST['ck'];
			$dk = $_REQUEST['dk'];
			$p = $_REQUEST['fmprogram'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
			 
		 	$queryKE="SELECT max(q) as program FROM ref_program WHERE bk='$bk' and ck='$ck' and dk = '$dk' and p='$p' " ;$cek.=$queryKE;
			$get=mysql_fetch_array(mysql_query($queryKE));
			$lastkode=$get['program'] + 1;	
		//	$kode_kegiatan = sprintf("%03s", $lastkode);
			$content->kegiatan=$lastkode;
		 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}		
	   
	   /*case 'saveProgram' : {	
		     foreach ($_REQUEST as $key => $value) { 
			  $$key = $value; 
			 }
			 if($fmURUSAN == 0){
			 

						$fmDINAS = "0";
						$fmBIDANG = "0";
			 	$getlastProgram = "select max(p) as lastProgram from ref_program where bk = '$fmURUSAN' and ck = '0' and dk ='0' and q = '00'  ";
				$geMaxProgram = mysql_fetch_array(mysql_query($getlastProgram));
				$id = $geMaxProgram['lastProgram'] + 1;
				$data = array("bk" => $fmURUSAN,
							  "ck" => '0',
							  "dk" => '0',
							  "p" => $id,
							  "q" => '00',
							  "nama" => $namaProgram	
								 );
			 }else{
			 	if(empty($fmDINAS)){
					$fmDINAS = "0";
				}			 
			 	$getlastProgram = "select max(p) as lastProgram from ref_program where bk = '$fmURUSAN' and ck = '$fmBIDANG' and dk ='$fmDINAS' and q = '00'  ";
				$geMaxProgram = mysql_fetch_array(mysql_query($getlastProgram));
				$id = $geMaxProgram['lastProgram'] + 1;
				$data = array("bk" => $fmURUSAN,
							  "ck" => $fmBIDANG,
							  "dk" => $fmDINAS,
							  "p" => $id,
							  "q" => '00',
							  "nama" => $namaProgram	
								 );
			 }
			 $query = VulnWalkerInsert("ref_program", $data);
			 	mysql_query($query);
			$codeAndNameProgram = "select p, concat(p, '. ', nama) as vnama from ref_program where bk = '$fmURUSAN' and ck = '$fmBIDANG' and dk ='$fmDINAS' and q='00'";
			$cmbProgram  = cmbQuery('cmbProgram', $selectedProgram, $codeAndNameProgram,''.$cmbRo.'onChange=\''.$this->Prefix.'.comboForm()\'','-- Pilih Program --');
		
			 
			 $content= array("query" => $query , "cmbProgram" => $cmbProgram, "query2" => $codeAndNameProgram) ;
			 
			 
				break;
	   }*/
	    case 'comboForm': {
			
			 foreach ($_REQUEST as $key => $value) { 
			  $$key = $value; 
			 }
			 if($fmURUSAN == 0){
			 	$getLastKegiatan  = "select max(q) as lastKegiatan from ref_program  where bk = '$fmURUSAN' and ck ='0' and dk='0' and p='$p'";
			    $getMaxKegiatan = mysql_fetch_array(mysql_query($getLastKegiatan));
				$id = $getMaxKegiatan['lastKegiatan'] + 1;
			
 			 }else{
				 if(empty($fmDINAS)){
						$fmDINAS = "0";
					}
			 	$getLastKegiatan  = "select max(q) as lastKegiatan from ref_program  where bk = '$fmURUSAN' and ck ='$fmBIDANG' and dk='$fmDINAS' and p='$p'";
			    $getMaxKegiatan = mysql_fetch_array(mysql_query($getLastKegiatan));
				$id = $getMaxKegiatan['lastKegiatan'] + 1;
			 }

			  $content = array("query" => $getLastKegiatan , "IDKEGIATAN" => $id);
			break;
		}
					
		case 'simpan':{
			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	   }
	   case 'saveEdit':{
		     foreach ($_REQUEST as $key => $value) { 
			  $$key = $value; 
			 }
			 $data = array("nama" => $nama,
			 			   "kategori" => $kategori);
			 $query = VulnWalkerUpdate("ref_program",$data," concat(bk,' ',ck,' ',dk,' ',p,' ',q) = '$refprogram_cb[0]' ");
			 mysql_query($query);
			 $content = $query;
			 
		break;
	   }
	   
	   case 'hapus':{	
				$fm= $this->Hapus($pil);
				$err= $fm['err']; 
				$cek = $fm['cek'];
				$content = $fm['content'];
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
	
	function refreshProgram(){
	global $Main;
	 
		$c1 = $_REQUEST['bk'];	 
		$c = $_REQUEST['ck'];
		$d = $_REQUEST['dk'];
		$p = $_REQUEST['fmprogram'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kdnew= $_REQUEST['id_ProgramBaru'];
	 
	 $queryKD="SELECT p, concat(p,' . ', nama) as vnama  FROM ref_program WHERE bk='$c1' and ck='$c' and dk='$d' and p!='0' and q='0'" ;
	 $cek.="SELECT p, concat(p,' . ', nama) as vnama  FROM ref_program WHERE bk='$c1' and ck='$c' and dk='$d' and p!='0' and q='0'";
		$koden=$queryKD['p'];
		$new = sprintf("%02s", $koden);
		$kode_n=$new.".".$queryKD['nm_urusan'];
	
		$content->p=cmbQuery('fmprogram',$kdnew,$queryKD,'style="width:500;"onchange="'.$this->Prefix.'.comboForm()"','&nbsp&nbsp-------- Pilih Program -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".programBaru()' title='Baru' >";
	 
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function getProgram(){
	 global $Main;
	 
	 	$bk = $_REQUEST['bk'];	 
		$ck = $_REQUEST['ck'];
		$dk = $_REQUEST['dk'];
		$kd02 = $_REQUEST['cmbProgram'];
	//	$ke02 = $_REQUEST['fme1'];
	
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kenew= $_REQUEST['id_ProgramBaru'];
	 
	 	$aqry5="SELECT MAX(q) AS maxno FROM ref_program WHERE bk='$bk' and ck='$ck' and dk='$dk' and p='$kd02'";
		$get=mysql_fetch_array(mysql_query($aqry5));
		$newke=$get['maxno'] + 1;
	//	$newke1 = sprintf("%03s", $newke);
		$content->kegiatan=$newke;	
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function simpanProgram(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$dtc1= $_REQUEST['c1'];
		$dtc= $_REQUEST['c'];
		$dtd= $_REQUEST['d'];
		$dt_p= $_REQUEST['p'];
		$nama= $_REQUEST['nama'];
		
		
			if($err==''){
				$aqrykd = "INSERT into ref_program (bk,ck,dk,p,q,nama) values('$dtc1','$dtc','$dtd','$dt_p','00','$nama')";	
				$cek .= $aqrykd;	
				$qry = mysql_query($aqrykd);
				$content=$dt_p;	
				}
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
			 "<script type='text/javascript' src='js/master/refprogram/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".		
			$scriptload;
	}
	
	function programBaru($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	
	 $form_name = $this->Prefix.'_formKD';				
	 $this->form_width = 500;
	 $this->form_height = 120;
	 $this->form_caption = 'PROGRAM BARU';
	 	
		$c1= $_REQUEST['bk'];
		$c= $_REQUEST['ck'];
		$d= $_REQUEST['dk'];
		$nm_urusan='Semua URUSAN';		
		$nm_bidang='Semua BIDANG';		
		$nm_skpd='Semua SKPD';		
		if($c1==''){
			$c1='0';
		}else{
			$c1=$c1;
		}
	 	
		if($c==''){
			$c='0';
		}else{
			$c=$c;
		}
		
		if($d==''){
			$d='0';
		}else{
			$d=$d;
		}
		
		$aqry4="SELECT MAX(p) AS maxno FROM ref_program WHERE bk='$c1' and ck='$c' and dk='$d'";
		$cek.="SELECT MAX(p) AS maxno FROM ref_urusan WHERE bk='$c1' and ck='$c' and dk='$d'";
		$get=mysql_fetch_array(mysql_query($aqry4));

		$newkm=$get['maxno'] + 1;
		
	 	$get1=mysql_fetch_array(mysql_query("select * from ref_urusan where bk='$c1' and ck='0' "));
		if($get1['bk']==''){
			$urusan = $nm_urusan;
		}else{
			$urusan = $get1['bk'].'.'.$get1['nm_urusan'];
		}
	//	$urusan = $get1['bk'].'.'.$get1['nm_urusan'];
		$get2=mysql_fetch_array(mysql_query("select * from ref_urusan where bk='$c1' and ck='$c' and dk='0' "));
		
		if($get2['ck']==''){
			$bidang = $nm_bidang;
		}else{
			$bidang = $get2['ck']==0?'-':$get2['ck'].'.'.$get2['nm_urusan'];
		}
	//	$bidang = $get2['ck'].'.'.$get2['nm_urusan'];
		$get3=mysql_fetch_array(mysql_query("select * from ref_urusan where bk='$c1' and ck='$c' and dk='$d' "));
		if($get3['dk']==''){
			$dinas = $nm_skpd;
		}else{
			$dinas = $get3['dk']==0?'-':$get3['dk'].'.'.$get3['nm_urusan'];
		}
	//	$dinas = $get3['dk']==0?'-':$get3['dk'].'.'.$get3['nm_urusan'];
		
	 //items ----------------------
	  $this->form_fields = array(
			'urusan' => array( 'label'=>'Urusan', 
								'labelWidth'=>100,
								'value'=>$urusan, 
								'type'=>'', 'row_params'=>"height='21'"
							),
			'bidang' => array( 'label'=>'Bidang', 
								'value'=>$bidang, 
								'type'=>'', 'row_params'=>"height='21'"
							),
			'dinas' => array( 'label'=>'SKPD', 
								'value'=>$dinas, 
								'type'=>'', 'row_params'=>"height='21'"
							),
			
			'Program' => array( 
						'label'=>'Nama Program',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='p' id='p' value='".$newkm."' style='width:30px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Program' style='width:300px;'>
						</div>", 
						 ),		
			
			);
		//tombol
		$this->form_menubawah =
			"<input type ='hidden' name='c1' id='c1' value='".$get1['bk']."'>".
			"<input type ='hidden' name='c' id='c' value='".$get2['ck']."'>".
			"<input type ='hidden' name='d' id='d' value='".$get3['dk']."'>".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveProgram()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close4()' >";
							
		$form = $this->genFormProgram();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function genFormProgram($withForm=TRUE, $params=NULL, $center=TRUE){	
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
	
	
	
	
	
	/*function Hapus_Validasi($id){//id -> multi id with space delimiter
		$err=''; $cek='';
	//	$errmsg ='';
		$kode_validasi = explode(' ',$id);
		$bk=$kode_validasi[0];	
		$ck=$kode_validasi[1];
		$dk=$kode_validasi[2];	
		$p=$kode_validasi[3];
		$q=$kode_validasi[4];
		
		$qry1=mysql_query("select count(*) as cnt,bk,kc,p,q from t_penerimaan_barang bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'");
		$cek.="select count(*) as cnt,bk,kc,p,q from t_penerimaan_barang bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'";
		$penerimaan_brg=mysql_fetch_array($qry1);
		if($penerimaan_brg['cnt'] > 0 )$err ="Data tidak dapat di hapus sudah ada di Penerimaan Barang !!";
		
		if($errmsg=='' && 
				mysql_num_rows(mysql_query(
					"select Id from buku_induk where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q' ")
				) >0 )
				
			{ $errmsg = "GAGAL HAPUS, Kode Barang Sudah Ada Di Buku Induk !!! ";}
			
				//$errmsg = "select Id from buku_induk where f='$f' and g='$g' and h='$h' and i='$j' and i='$j' ";
			
		return $errmsg;
		
}*/

 		function Hapus($ids){ //validasi hapus tbl_sppd
		 $err=''; $cek='';
		 $cbid = $_REQUEST[$this->Prefix.'_cb'];
		 $this->form_idplh = $cbid[0];
		
		if ($err ==''){
			
		for($i = 0; $i<count($ids); $i++){
		$idplh1 = explode(" ",$ids[$i]);
		$bk= $idplh1[0];
	 	$ck= $idplh1[1];
		$dk= $idplh1[2];
		$p= $idplh1[3];
		$q= $idplh1[4];
		
		$qry1=mysql_query("select count(*) as cnt,bk,ck,dk,p,q from t_penerimaan_barang where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'");
		$qry2=mysql_query("select count(*) as cnt,bk,ck,dk,p,q from t_penerimaan_barang_det where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'");
		$qry3=mysql_query("select count(*) as cnt,bk,ck,dk,p,q from t_penerimaan_barang_retensi where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'");
		$qry4=mysql_query("select count(*) as cnt,bk,ck,dk,p,q from t_spp where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'");
		$qry5=mysql_query("select count(*) as cnt,bk,ck,dk,p,q from t_atribusi where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'");
		$qry6=mysql_query("select count(*) as cnt,bk,ck,dk,p,q from tabel_dpa where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'");
		$qry7=mysql_query("select count(*) as cnt,bk,ck,dk,p,q from tabel_anggaran where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'");
		$qry8=mysql_query("select count(*) as cnt,bk,ck,dk,p,q from pengeluaran where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'");
		$qry9=mysql_query("select count(*) as cnt,bk,ck,dk,p,q from distribusi where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'");
		$qry10=mysql_query("select count(*) as cnt,bk,ck,dk,p,q from anggaran_kas where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'");
		$qry11=mysql_query("select count(*) as cnt,bk,ck,dk,p,q from tabel_spd where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'");
		$qry12=mysql_query("select count(*) as cnt,bk,ck,dk,p,q from t_kartu_persediaan where bk='$bk' and ck='$ck' and dk='$dk' and p='$p' and q='$q'");
		
		$penerimanaan_brg=mysql_fetch_array($qry1);
		$penerimanaan_brg_det=mysql_fetch_array($qry2);
		$penerimanaan_retensi=mysql_fetch_array($qry3);
		$t_spp=mysql_fetch_array($qry4);
		$atribusi=mysql_fetch_array($qry5);
		$dpa=mysql_fetch_array($qry6);
		$anggaran=mysql_fetch_array($qry7);
		$pengeluaran=mysql_fetch_array($qry8);
		$distribusi=mysql_fetch_array($qry9);
		$anggaran_kas=mysql_fetch_array($qry10);
		$spd=mysql_fetch_array($qry11);
		$kartu_persediaan=mysql_fetch_array($qry12);
	
		if($penerimanaan_brg['cnt'] > 0 )$err ="Data tidak dapat dihapus, Sudah di gunakan di Penerimaan Barang !!";		
		if($penerimanaan_brg_det['cnt'] > 0 )$err ="Data tidak dapat dihapus, Sudah di gunakan di Penerimaan Barang !!";
		if($penerimanaan_retensi['cnt'] > 0 )$err ="Data tidak dapat dihapus, Sudah di gunakan di Penerimaan Barang !!";
		if($t_spp['cnt'] > 0 )$err ="Data tidak dapat dihapus, Sudah di gunakan di Surat Permohonan !!";
		if($atribusi['cnt'] > 0 )$err ="Data tidak dapat dihapus, Sudah di gunakan di Penerimaan Barang !!";
		if($dpa['cnt'] > 0 )$err ="Data tidak dapat dihapus, Sudah di gunakan di DPA !!";
		if($anggaran['cnt'] > 0 )$err ="Data tidak dapat dihapus, Sudah di gunakan di Penerimaan Barang !!";
	//	if($pengeluaran['cnt'] > 0 )$err ="Data tidak dapat dihapus, Sudah di gunakan di Persediaan !!";
		if($distribusi['cnt'] > 0 )$err ="Data tidak dapat dihapus, Sudah di gunakan di Persediaan !!";
		if($anggaran_kas['cnt'] > 0 )$err ="Data tidak dapat dihapus, Sudah di gunakan di Perencanaan !!";
		if($spd['cnt'] > 0 )$err ="Data tidak dapat dihapus, Sudah di gunakan di Perencanaan !!";
	//	if($kartu_persediaan['cnt'] > 0 )$err ="Data tidak dapat dihapus, Sudah di gunakan di Persediaan !!";
				
		if ($bk != '0'){
			$sk1="select bk,ck,dk,p,q from ref_program where bk='$bk' and ck!='0'";
		}
		
		if ($ck != '0'){
			$sk1="select bk,ck,dk,p,q from ref_program where bk='$bk' and ck='$ck' and dk!='0'";
		}
		
		if ($dk != '0'){
			$sk1="select bk,ck,dk,p,q from ref_program where bk='$bk'  and ck='$ck' and dk='$dk' and p!='0'";
		}
		if ($p != '0'){
			$sk1="select bk,ck,dk,p,q from ref_program where bk='$bk'  and ck='$ck' and dk='$dk' and p='$p' and q!='0'";
		}
	
		if ($q=='0'){
			$qrycek=mysql_query($sk1);$cek.=$sk1;
			if(mysql_num_rows($qrycek)>0)$err='data tidak bisa di hapus';
		}
		
		
		if($err=='' ){
					$qy = "DELETE FROM ref_program WHERE bk='$bk' and ck='$ck' and dk='$dk'  and  p='$p' and q='$q' and  concat (bk,' ',ck,' ',dk,' ',p,' ',q) ='".$ids[$i]."' ";$cek.=$qy;
					$qry = mysql_query($qy);
					
			}else{
				break;
			}			
		}
		}
		return array('err'=>$err,'cek'=>$cek);
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
		$dt['bk']=$fmURUSAN;
		$dt['ck']=$fmBIDANG==''?'NULL':$fmBIDANG;
		$dt['dk']=$fmDINAS==''?'NULL':$fmDINAS;;
		$dt['p']='1';
		$dt['q']='0';
		
		$fm = $this->setForm($dt);		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
   
  	function setFormEdit(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek =$cbid[0];				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		//get data
		$bk=$kode[0];
		$ck=$kode[1]; 
		$dk=$kode[2];
		$p=$kode[3]; 
		$q=$kode[4];
		 
		//query ambil data ref_program
		$aqry = "select * from ref_program where concat(bk,' ',ck,' ',dk,' ',p,' ',q)='$this->form_idplh'"; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		
		$fm = $this->formEdit($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setForm($dt){	
	 global $SensusTmp ,$Main;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 750;
	 $this->form_height = 170;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Referensi Program - Baru';
	  }
	  	
		$bk = $_REQUEST['fmURUSAN'];
		$ck = $_REQUEST['fmBIDANG'];
		$dk = $_REQUEST['fmDINAS'];
		$nm_urusan='Semua URUSAN';		
		$nm_bidang='Semua BIDANG';		
		$nm_skpd='Semua SKPD';		
		$query_program="select p, concat(p, '. ', nama) as vnama from ref_program where bk = '$bk' and ck = '$ck' and dk ='$dk' and q='00'";
			
		$queryKE="SELECT max(e1) as e1, nm_skpd FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e'" ;$cek.=$queryKE;
		$get1=mysql_fetch_array(mysql_query("select * from ref_urusan where bk='".$dt['bk']."' and ck='0' "));
		if($get1['bk']==''){
			$urusan = $nm_urusan;
		}else{
			$urusan = $get1['bk'].'.'.$get1['nm_urusan'];
		}
	//	$urusan = $get1['bk'].'.'.$get1['nm_urusan'];
		$get2=mysql_fetch_array(mysql_query("select * from ref_urusan where bk='".$dt['bk']."' and ck='".$dt['ck']."' and dk='0' "));
		if($get2['ck']==''){
			$bidang = $nm_bidang;
		}else{
			$bidang = $get2['ck']==0?'-':$get2['ck'].'.'.$get2['nm_urusan'];
		//	$bidang = $get2['ck'].'.'.$get2['nm_urusan'];
		//	$get2['ck'].'.'.$get2['nm_urusan'];
		}
	//	$bidang = $get2['ck'].'.'.$get2['nm_urusan'];
		$get3=mysql_fetch_array(mysql_query("select * from ref_urusan where bk='".$dt['bk']."' and ck='".$dt['ck']."' and dk='".$dt['dk']."' "));
		if($get3['dk']==''){
			$dinas = $nm_skpd;
		}else{
			$dinas = $get3['dk']==0?'-':$get3['dk'].'.'.$get3['nm_urusan'];
		}
		
		
	//	$dinas = $get3['dk']==0?'-':$get3['dk'].'.'.$get3['nm_urusan'];
		
		$dat_urusan= array('label'=>'Urusan', 'value'=> $urusan, 'labelWidth'=>120, 'type'=>'' );
		$dat_bidang= array('label'=>'Bidang', 'value'=> $bidang, 'labelWidth'=>120, 'type'=>'' );
		$dat_skpd= array('label'=>'SKPD', 'value'=> $dinas, 'labelWidth'=>120, 'type'=>'' );
		$dataaktif=0;		
       //items ----------------------
		  $this->form_fields = array(
		  $dat_urusan,
		  $dat_bidang,
		  $dat_skpd,
		  	
			'program' => array( 
						'label'=>'Kode Program',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_program'>".cmbQuery('fmprogram',$dt['e'],$query_program,'style="width:500px;"onchange="'.$this->Prefix.'.pilihProgram()"','-------- Pilih Program -----------------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".programBaru()' title='Baru' ></div>",
						 ),		
				
			'setkegiatan' => array( 
						'label'=>'Kode Kegiatan',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='kegiatan' id='kegiatan' value='".$newke."' style='width:50px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kegiatan' style='width:449px;'>
						</div>", 
						 ),		
			
			'setkategory' => array( 
						'label'=>'Kategory',
						'labelWidth'=>150, 
						'value'=>cmbArray('kategory',$dataaktif,$this->arrayKategori,'--PILIH--','style=width:250px;'),
						)
			);
		//tombol
		$this->form_menubawah =	
		"<input type=hidden id='bk' name='bk' value='".$get1['bk']."'> ".
		"<input type=hidden id='ck' name='ck' value='".$get2['ck']."'> ".
		"<input type=hidden id='dk' name='dk' value='".$get3['dk']."'> ".
		"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >"."&nbsp&nbsp".
		"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	
	function setForm1($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 
		
	 $json = TRUE;	//$ErrMsg = 'tes';
	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 480;
	 $this->form_height = 180;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU';
	  }else{
		$this->form_caption = 'EDIT';
	  }
	  	foreach ($dt as $key => $value) { 
			  $$key = $value; 
		} 
		$get1=mysql_fetch_array(mysql_query("select * from ref_urusan where bk='".$dt['bk']."' and ck='0' "));
		$urusan = $get1['bk'].'.'.$get1['nm_urusan'];
		$get2=mysql_fetch_array(mysql_query("select * from ref_urusan where bk='".$dt['bk']."' and ck='".$dt['ck']."' and dk='0' "));
		$bidang = $get2['ck'].'.'.$get2['nm_urusan'];
		$get3=mysql_fetch_array(mysql_query("select * from ref_urusan where bk='".$dt['bk']."' and ck='".$dt['ck']."' and dk='".$dt['dk']."' "));
		$dinas = $get3['dk']==0?'-':$get3['dk'].'.'.$get3['nm_urusan'];
		
		$codeAndNameProgram = "select p, concat(p, '. ', nama) as vnama from ref_program where bk = '$bk' and ck = '$ck' and dk ='$dk' and q='00'";
		$cmbProgram  = cmbQuery('cmbProgram', $selectedProgram, $codeAndNameProgram,'style="width:280px;"'.$cmbRo.'onChange=\''.$this->Prefix.'.comboForm()\'','-- Pilih Program --');
		
		$arrayKategori = array(
							

							array('1','PENGADAAN'),
							array('2','PEMELIHARAAN')
						 
						 );
						 
		$cmbKategori = 	cmbArray('kategori',$kategori,$arrayKategori,'PENGADAAN DAN PEMELIHARAAN','');
		
		if ($dt['stpakai']==1)	$readonly="readonly=''";
		
       //items ----------------------
		  $this->form_fields = array(
			
			
			'urusan' => array( 'label'=>'Urusan', 
								'labelWidth'=>100,
								'value'=>$urusan, 
								'type'=>'', 'row_params'=>"height='21'"
							),
			'bidang' => array( 'label'=>'Bidang', 
								'value'=>$bidang, 
								'type'=>'', 'row_params'=>"height='21'"
							),
			'dinas' => array( 'label'=>'SKPD', 
								'value'=>$dinas, 
								'type'=>'', 'row_params'=>"height='21'"
							),
			'kode_program' => array( 
								'label'=>'Kode Program',
								'labelWidth'=>100, 
								'value'=>$cmbProgram." <button type='button' onclick='refprogram.programBaru()' > Baru </button>"
									 ),
			'kode_kegiatan' => array( 
								'label'=>'Kode Kegiatan',
								'labelWidth'=>100, 
								'value'=>
								"<div id='cont_e'>"."<input type='text' id ='kegiatan' name='kegiatan' style='width:40px;' readonly></div>",
									 ),
									 
			'nama_kegiatan' => array( 
								'label'=>'Nama',
								'labelWidth'=>100,
								'value'=>$dt['nama'], 
								'type'=>'text',
								'id'=>'nama_program',
								'param'=>"style='width:250ppx;text-transform: uppercase;' size=50ppx"
									 ),
			'kategori' => array( 
								'label'=>'Kategori',
								'labelWidth'=>100,
								'value'=>$cmbKategori, 
									 ),	
								 
			);
		//tombol
		$this->form_menubawah =	
			"<input type=hidden id='fmbk' name='fmbk' value='".$dt['bk']."'> ".
			"<input type=hidden id='fmck' name='fmck' value='".$dt['ck']."'> ".
			"<input type=hidden id='fmdk' name='fmdk' value='".$dt['dk']."'> ".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Batal kunjungan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function formEdit($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 
		
	 $json = TRUE;	//$ErrMsg = 'tes';
	 	
	 $form_name = $this->Prefix.'_formEdit';				
	 $this->form_width = 1000;
	 $this->form_height = 160;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU';
	  }else{
		$this->form_caption = 'EDIT';
	  }
	  	foreach ($dt as $key => $value) { 
			  $$key = $value; 
		}
		$ROU = "readonly";
		$ROB = "readonly"; 
		$ROD = "readonly";
		$ROP = "readonly";
		$ROK = "readonly";
		
		$nm_urusan='Semua URUSAN';		
		$nm_bidang='Semua BIDANG';		
		$nm_skpd='Semua SKPD';	
		
		$get1=mysql_fetch_array(mysql_query("select * from ref_urusan where bk='".$dt['bk']."' and ck='0' "));
		if($get1['bk']==''){
			$urusan = $nm_urusan;
		}else{
			$urusan = $get1['bk'].'.'.$get1['nm_urusan'];
		}
		
	//	$urusan = $get1['nm_urusan'];
		$get2=mysql_fetch_array(mysql_query("select * from ref_urusan where bk='".$dt['bk']."' and ck='".$dt['ck']."' and dk='0' "));
		if($get2['ck']==''){
			$bidang = $nm_bidang;
		}else{
			$bidang = $get2['ck']==0?'-':$get2['ck'].'.'.$get2['nm_urusan'];
		}
	//	$bidang = $get2['ck']==0?'-':$get2['nm_urusan'];
		$get3=mysql_fetch_array(mysql_query("select * from ref_urusan where bk='".$dt['bk']."' and ck='".$dt['ck']."' and dk='".$dt['dk']."' "));
		if($get3['dk']==''){
			$dinas = $nm_skpd;
		}else{
			$dinas = $get3['dk']==0?'-':$get3['dk'].'.'.$get3['nm_urusan'];
		}
		
	//	$dinas = $get3['dk']==0?'-':$get3['nm_urusan'];
		$get4=mysql_fetch_array(mysql_query("select * from ref_program where bk='".$dt['bk']."' and ck='".$dt['ck']."' and dk='".$dt['dk']."' and p='".$dt['p']."' and q='00'"));
		$program = $get4['nama'];
		if($q == '0'){
			
		}else{
			$get5=mysql_fetch_array(mysql_query("select * from ref_program where bk='".$dt['bk']."' and ck='".$dt['ck']."' and dk='".$dt['dk']."' and p='".$dt['p']."' and  q='".$dt['q']."'"));
			$kegiatan = $get5['nama'];
		}
		
		$codeAndNameProgram = "select p, concat(p, '. ', nama) as vnama from ref_program where bk = '$bk' and ck = '$ck' and dk ='$dk' and q='00'";
		$cmbProgram  = cmbQuery('cmbProgram', $selectedProgram, $codeAndNameProgram,''.$cmbRo.'onChange=\''.$this->Prefix.'.comboForm()\'','-- Pilih Program --');
		if($q != '0'){
			$ROK = "";
		}else{
			$ROP = "";
		}			
		
		$arrayKategori =	array(
							array('1','PENGADAAN'),
							array('2','PEMELIHARAAN')
						 );
		
		$kategori = $dt['kategori'];				 
		$cmbKategori = 	cmbArray('kategori',$kategori,$arrayKategori,'PENGADAAN DAN PEMELIHARAAN','');
		if ($dt['stpakai']==1)	$readonly="readonly=''";
		
       //items ----------------------
		  $this->form_fields = array(
			'urusan' => array( 'label'=>'Urusan', 
								'labelWidth'=>50,
								'value'=>$urusan, 
								'type'=>'text',
								'param' => "style='width:900px;' $ROU"
							),
			'bidang' => array( 'label'=>'Bidang', 
								'value'=>$bidang, 
								'type'=>'text',
								'param' => "style='width:900px;' $ROB"
							),
			'dinas' => array( 'label'=>'Dinas', 
								'type'=>'text',
								'value'=> $dinas,
								'param' => "style='width:900px;' $ROD"
							),
			'program' => array( 'label'=>'Program', 
								'value'=>$program, 
								'type'=>'text',
								'param' => "style='width:900px;' $ROP"
							),
			'kegiatan' => array( 'label'=>'Kegiatan', 
								'value'=>$kegiatan, 
								'type'=>'text',
								'param' => "style='width:900px;' $ROK"
							),
			'kategori' => array( 
								'label'=>'Kategori',
								'labelWidth'=>100,
								'value'=>$cmbKategori, 
									 ),	
								 
			);
		//tombol
		$this->form_menubawah =	
			"<input type=hidden id='fmbk' name='fmbk' value='".$dt['bk']."'> ".
			"<input type=hidden id='fmck' name='fmck' value='".$dt['ck']."'> ".
			"<input type=hidden id='fmdk' name='fmdk' value='".$dt['dk']."'> ".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveEdit()' title='Batal kunjungan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".CloseEdit()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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
						1570,
						695,
						'Pilih Program',
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
	}
	
	function genDaftarInitial( $height=''){
		$vOpsi = $this->genDaftarOpsi();
		return			
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 		
				
			"</div>".					
			"<div id=garis style='height:1;border-bottom:1px solid #E5E5E5;'></div>".
			"<div id=contain style='overflow:auto;height:$height;'>".
			//"<div id=contain style='overflow:auto;height:256;'>".
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".					
			"</div>
			</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
				"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
			"</div>";
	}
		
	//daftar =================================	
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 			 
	 $headerTable =
	 "<thead>
	  <tr>
  	   <th class='th01' width='20' rowspan='2'>No.</th>
  	   $Checkbox		
       <th class='th01' align='center' width='100'>KODE</th>
	   <th class='th01' align='center' width='900'>NAMA</th>   
	   <th class='th01' align='center' width='300'>KATEGORI</th> 
	   <th class='th01' align='center' width='100'>STATUS</th> 
	 
	   </tr>
	  </thead>";
	
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 global $Main;
	 foreach ($isi as $key => $value) { 
		  $$key = $value; 
	 }
	 $kode = $bk.".".genNumber($ck).".".genNumber($dk).".".genNUmber($p).".".genNumber($q);
	 $Koloms = array();
	 $Koloms[] = array('align="center" width="20"', $no.'.' );
	 if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="left"  ',$kode);
 	 $Koloms[] = array('align="left" ',$nama);
	 if($kategori == 0 ){
	 	$kategori = "PENGADAAN DAN PEMELIHARAAN";
	 }elseif($kategori == 1){
	 	$kategori = "PENGADAAN";
	 }elseif($kategori == 2){
	 	$kategori = "PEMELIHARAAN";
	 }
	 $Koloms[] = array('align="left" ',$kategori);
	 if($stpakai =='1'){
	 	$stpakai = "TIDAK AKTIF";
	 }else{
	 	$stpakai = "AKTIF";
	 }
	 $Koloms[] = array('align="center" ',$stpakai);
	 /*$Koloms[] = array('align="left" ',$pagu);	*/ 	 	 
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;	 
	
	$fmURUSAN = cekPOST('fmURUSAN');
	$fmBIDANG = cekPOST('fmBIDANG');
	$fmDINAS = cekPOST('fmDINAS');
	$fmPROGRAM = cekPOST('fmPROGRAM');
	$fmKEGIATAN = cekPOST('fmKEGIATAN');
	$fmKODE = cekPOST('fmKODE');
	$fmNMURUSAN = cekPOST('fmNMURUSAN');
	
	if($fmURUSAN=='' && $fmBIDANG=='' &&  $fmDINAS==''){
		$qry_program="select p,nama from ref_program where bk='0' and ck ='0' and dk='0' and p<>'0' and q='0'";		
	}elseif($fmURUSAN!='' && $fmBIDANG=='' &&  $fmDINAS==''){
		$qry_program="select p,nama from ref_program where bk='$fmURUSAN' and ck ='0' and dk='0' and p<>'0' and q='0'";	
	}elseif($fmURUSAN!='' && $fmBIDANG!='' &&  $fmDINAS==''){
		$qry_program="select p,nama from ref_program where bk='$fmURUSAN' and ck ='$fmBIDANG' and dk='0' and p<>'0' and q='0'";	
	}elseif($fmURUSAN!='' && $fmBIDANG!='' &&  $fmDINAS!=''){
		$qry_program="select p,nama from ref_program where bk='$fmURUSAN' and ck ='$fmBIDANG' and dk='$fmDINAS' and p<>'0' and q='0'";	
	}

	if($fmURUSAN=='' && $fmBIDANG=='' &&  $fmDINAS=='' && $fmPROGRAM!==''){
		$qry_kegiatan="select q,nama from ref_program where bk='0' and ck ='0' and dk='0' and p='$fmPROGRAM' and q<>'0'";	
	//}elseif($fmURUSAN!='' && $fmBIDANG=='' &&  $fmDINAS=='' && $fmPROGRAM!=='' && $fmKEGIATAN!==''){
	}elseif($fmURUSAN!='' && $fmBIDANG=='' &&  $fmDINAS=='' && $fmPROGRAM!==''){
	//	$qry_kegiatan="select q,nama from ref_program where bk='$fmURUSAN' and ck='0' and dk='0' and p='$fmPROGRAM' and q='$fmKEGIATAN'";	
		$qry_kegiatan="select q,nama from ref_program where bk='$fmURUSAN' and ck='0' and dk='0' and p='$fmPROGRAM' and q<>'0'";	
	}elseif($fmURUSAN!='' && $fmBIDANG!='' &&  $fmDINAS=='' && $fmPROGRAM!==''){
		$qry_kegiatan="select q,nama from ref_program where bk='$fmURUSAN' and ck ='$fmBIDANG' and p='$fmPROGRAM' and q<>'0'";
	}elseif($fmURUSAN!='' && $fmBIDANG!='' &&  $fmDINAS!='' && $fmPROGRAM!==''){
		$qry_kegiatan="select q,nama from ref_program where bk='$fmURUSAN' and ck ='$fmBIDANG' and dk='$fmDINAS' and p='$fmPROGRAM' and q<>'0'";	
	}
		
	$TampilOpt = 
			//"<tr><td>".	
			"<div class='FilterBar'>".			
			"<table style='width:100%'>
			<tr>
			<td style='width:120px'>URUSAN</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery1("fmURUSAN",$fmURUSAN,"select bk,nm_urusan from ref_urusan where  ck='0'","onChange='document.getElementById(`fmBIDANG`).value=``;document.getElementById(`fmDINAS`).value=``;".$this->Prefix.".Refesh();'",'Pilih','').
		
			"</td>
			</tr><tr>
			<td>BIDANG</td><td>:</td>
			<td>".
			cmbQuery1("fmBIDANG",$fmBIDANG,"select ck,nm_urusan from ref_urusan where bk='$fmURUSAN' and ck<>'0' and dk='0' ","onChange=\"$this->Prefix.Refesh()\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SKPD</td><td>:</td>
			<td>".
			cmbQuery1("fmDINAS",$fmDINAS,"select dk,nm_urusan from ref_urusan where bk='$fmURUSAN' and ck ='$fmBIDANG' and dk <> '0'","onChange=\"$this->Prefix.Refesh()\"",'Pilih','').
			"</td>
			</tr>
			
			<tr>
			<td style='width:120px'>PROGRAM</td><td style='width:10px'>:</td>
			<td colspan='2'>".
		//	cmbQuery1("fmPROGRAM",$fmPROGRAM,$qry_program,"onChange=\"$this->Prefix.Refesh()\"",'Pilih','').
			cmbQuery1("fmPROGRAM",$fmPROGRAM,$qry_program,"onChange='document.getElementById(`fmKEGIATAN`).value=``;".$this->Prefix.".Refesh();'",'Pilih','').
			"</td>
			</tr><tr>
			<td>KEGIATAN</td><td>:</td>
			<td>".
			cmbQuery1("fmKEGIATAN",$fmKEGIATAN,$qry_kegiatan,"onChange=\"$this->Prefix.Refesh()\"",'Pilih','').
			"</td><td>
			</td>
			</tr>
			</table>".
			"</div>";		
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		$fmURUSAN = cekPOST('fmURUSAN');
		$fmBIDANG = cekPOST('fmBIDANG');
		$fmDINAS = cekPOST('fmDINAS');
		$fmPROGRAM = cekPOST('fmPROGRAM');
		$fmKEGIATAN = cekPOST('fmKEGIATAN');
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
			if(!empty($fmURUSAN) && empty($fmBIDANG) && empty($fmDINAS)){
				$arrKondisi[]= "bk =$fmURUSAN";	
			}
			if(!empty($fmURUSAN) && empty($fmBIDANG) && empty($fmDINAS) && !empty($fmPROGRAM)){
			//	$arrKondisi[]= "p =$fmPROGRAM";	
				
		//	if(!empty($fmURUSAN) && empty($fmBIDANG) && empty($fmDINAS) && !empty($fmPROGRAM)){
			$arrKondisi[]= " ck=0 and dk=$fmDINAS and p =$fmPROGRAM";	
			}
			if(!empty($fmURUSAN) && empty($fmBIDANG) && empty($fmDINAS) && !empty($fmPROGRAM)  && !empty($fmKEGIATAN)){
				$arrKondisi[]= "q=$fmKEGIATAN";	
			}
			
		}
		
		/*elseif(!empty($fmURUSAN) && empty($fmBIDANG) && empty($fmDINAS) && !empty($fmPROGRAM))
		{
			$arrKondisi[]= "bk =$fmURUSAN and ck=0 and dk=$fmDINAS and p =$fmPROGRAM";
		}*/
		elseif(!empty($fmURUSAN) && !empty($fmBIDANG) && empty($fmDINAS))
		{
			if(!empty($fmURUSAN) && !empty($fmBIDANG) && empty($fmDINAS)){
				$arrKondisi[]= "bk =$fmURUSAN and ck=$fmBIDANG ";	
			}
			if(!empty($fmURUSAN) && !empty($fmBIDANG) && empty($fmDINAS) && !empty($fmPROGRAM)){
				$arrKondisi[]= "dk=0 and p =$fmPROGRAM";	
			}
			if(!empty($fmURUSAN) && !empty($fmBIDANG) && empty($fmDINAS) && !empty($fmPROGRAM) && !empty($fmKEGIATAN)){
				$arrKondisi[]= "q=$fmKEGIATAN";	
			}
			
		}
		elseif(!empty($fmURUSAN) && !empty($fmBIDANG) && !empty($fmDINAS))
		{
			if(!empty($fmURUSAN) && !empty($fmBIDANG) && !empty($fmDINAS)){
				$arrKondisi[]= "bk =$fmURUSAN and ck=$fmBIDANG and dk=$fmDINAS";	
			}
			if(!empty($fmURUSAN) && !empty($fmBIDANG) && !empty($fmDINAS) && !empty($fmPROGRAM)){
				$arrKondisi[]= "p=$fmPROGRAM";	
			}
			if(!empty($fmURUSAN) && !empty($fmBIDANG) && !empty($fmDINAS) && !empty($fmPROGRAM) && !empty($fmKEGIATAN)){
				$arrKondisi[]= "q=$fmKEGIATAN";		
			}
					
		}
		elseif(!empty($fmURUSAN) && !empty($fmBIDANG) && !empty($fmDINAS) && !empty($fmPROGRAM))
		{
			$arrKondisi[]= "bk=$fmURUSAN and ck=$fmBIDANG and dk=$fmDINAS and p=$fmPROGRAM";		
		}
		
		if(empty($fmPROGRAM) && empty($fmKEGIATAN))
		{
			
		}
		elseif(empty($fmURUSAN) && empty($fmBIDANG) && empty($fmDINAS) && !empty($fmPROGRAM) && empty($fmKEGIATAN))		
		{
			$arrKondisi[]= "bk =0 and ck=$fmBIDANG and dk=$fmDINAS and p =$fmPROGRAM";
		//	$arrKondisi[]= "bk =0 and ck=$fmBIDANG and dk=$fmDINAS and p =$fmPROGRAM";
		}
		elseif(empty($fmURUSAN) && empty($fmBIDANG) && empty($fmDINAS) && !empty($fmPROGRAM) && !empty($fmKEGIATAN))		
		{
			$arrKondisi[]= "bk =0 and ck=$fmBIDANG and dk=$fmDINAS and p =$fmPROGRAM and q=$fmKEGIATAN";
		//	$arrKondisi[]= "bk =0 and ck=$fmBIDANG and dk=$fmDINAS and p =$fmPROGRAM";
		}
		
		/*elseif(!empty($fmPROGRAM) && empty($fmKEGIATAN))		
		{
		//	$arrKondisi[]= "bk =0 and ck=$fmBIDANG and dk=$fmDINAS and p =$fmPROGRAM";
			$arrKondisi[]= "ck=0 and dk=$fmDINAS and p =$fmPROGRAM";
		}*/
		/*elseif(!empty($fmPROGRAM) && !empty($fmKEGIATAN))
		{
			$arrKondisi[]= "bk =0 and ck=$fmBIDANG and dk=$fmDINAS and p =$fmPROGRAM and q=$fmKEGIATAN";
		}*/
		
		if(!empty($_POST['fmKODE'])) $arrKondisi[] = " concat(bk,ck,dk) like '%".str_replace('.','',$_POST['fmKODE'])."%'";					
		if(!empty($_POST['fmNMURUSAN'])) $arrKondisi[] = " nm_urusan like '%".$_POST['fmNMURUSAN']."%'";

 			
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		

			$Order= join(',',$arrOrders);	
			$OrderDefault = ' Order By bk,ck,dk,p,q ';// Order By no_terima desc ';
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
$refprogram = new refprogramObj();

?>