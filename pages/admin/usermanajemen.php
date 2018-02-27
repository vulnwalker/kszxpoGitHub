<?php

class UserManajemenObj  extends DaftarObj2{	
	var $Prefix = 'UserManajemen';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'admin'; //bonus
	var $TblName_Hapus = 'admin';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('uid');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
//	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp1 = array( 10);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'Administrasi';
	var $PageIcon = 'images/administrasi_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='usermanajemen.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'DAFTAR HAK AKSES';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'UserManajemenForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	function setTitle(){
		return 'Daftar Pengguna';
	}
	
	function setMenuEdit(){
		return
		
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".resetPass()","sections.png","Reset", 'Reset Password')."</td>".
			'';
	}
	
	
	function genDaftarInitial(){
		global $HTTP_COOKIE_VARS;
		$TampilOpt = $this->genDaftarOpsi();
		
		if($HTTP_COOKIE_VARS['coSKPD']=='00'){
			$skpd=$HTTP_COOKIE_VARS['cofmSKPD'];
			$unit=$HTTP_COOKIE_VARS['cofmUNIT'];
			$subunit=$HTTP_COOKIE_VARS['cofmSUBUNIT'];
		}
		else{
			$skpd=$HTTP_COOKIE_VARS['coSKPD'];
			$unit=$HTTP_COOKIE_VARS['coUNIT'];
			$subunit=$HTTP_COOKIE_VARS['coSUBUNIT'];
		}
		
		return		
			//$NavAtas.	
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_skpd' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 
			//$vOpsi['TampilOpt'].
			"<input type='hidden' id='thn' name='thn' value='".date('Y')."'>".
			"<input type='hidden' id='bln' name='bln' value='".date('m')."'>".
			"<input type='hidden' id='skpd_usermanajemenfmBidang' name='skpd_usermanajemenfmBidang' value='".$skpd."'>".
			"<input type='hidden' id='skpd_usermanajemenfmBagian' name='skpd_usermanajemenfmBagian' value='".$unit."'>".
			"<input type='hidden' id='skpd_usermanajemenfmSubBagian' name='skpd_usermanajemenfmSubBagian' value='".$subunit."'>".
			"</div>".					
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".					
			"</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
			"</div>";
	}
	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//  $urusan = $Main->URUSAN;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	
	 
	
	 $uid = $_REQUEST['uid'];
	 $nm_lengkap = $_REQUEST['nm_lengkap'];
	 $pwd = $_REQUEST['password'];
	 $md5_pwd=md5($pwd);
	 $urusan = $_REQUEST['fmc1']==''?'0':$_REQUEST['fmc1'];
     $bidang= $_REQUEST['fmc']==''?'00':$_REQUEST['fmc'];
	 $skpd= $_REQUEST['fmd']==''?'00':$_REQUEST['fmd'];
	 $unit= $_REQUEST['fme']==''?'00':$_REQUEST['fme'];
	 $subunit= $_REQUEST['fme1']==''?'000':$_REQUEST['fme1'];
	 
	 $bidang4= $_REQUEST['fmc4']==''?'00':$_REQUEST['fmc4'];
	 $skpd4= $_REQUEST['fmd4']==''?'00':$_REQUEST['fmd4'];
	 $unit4= $_REQUEST['fme4']==''?'00':$_REQUEST['fme4'];
	 $subunit4= $_REQUEST['fme14']==''?'000':$_REQUEST['fme14'];
	// if (empty($subsubunit)) $subsubunit='000'; 
	// $group = $skpd.'.'.$unit.'.'.$subunit.'.'.$subsubunit;
	if ($Main->URUSAN==0){
		$group = $bidang4.'.'.$skpd4.'.'.$unit4.'.'.$subunit4;
	}else{
		$group = $urusan.'.'.$bidang.'.'.$skpd.'.'.$unit.'.'.$subunit;
	}
	// $group = $urusan.'.'.$bidang.'.'.$skpd.'.'.$unit.'.'.$subunit;
	 $level = $_REQUEST['fmLEVELPENGGUNA'];
	 //$group = $_REQUEST['fmGROUPPENGGUNA'];
	 $modul01= $_REQUEST['fmMODUL01'];
	 $modul02= $_REQUEST['fmMODUL02'];
	 $modul03= $_REQUEST['fmMODUL03'];
	 $modul04= $_REQUEST['fmMODUL04'];
	 $modul05= $_REQUEST['fmMODUL05'];
	 $modul06= $_REQUEST['fmMODUL06'];
	 $modul07= $_REQUEST['fmMODUL07'];
	 $modul08= $_REQUEST['fmMODUL08'];
	 $modul09= $_REQUEST['fmMODUL09'];
	 $modul10= $_REQUEST['fmMODUL10'];
	 $modul11= $_REQUEST['fmMODUL11'];
	 $modul12= $_REQUEST['fmMODUL12'];
	 $modul13= $_REQUEST['fmMODUL13'];
	 $modul14= $_REQUEST['fmMODUL14'];
	 $modul15= $_REQUEST['fmMODUL15'];
	 $modul16= $_REQUEST['fmMODUL16'];
	 $status = $_REQUEST['fmStatus'];
	 $fmMODULref=$_REQUEST['fmMODULref'];  	  
	 $fmMODULadm=$_REQUEST['fmMODULadm'];  	  
	 $fmStatus=$_REQUEST['fmStatus'];  	  
	 
	if( $err=='' && $uid =='' ) $err= 'User Name Belum Di Isi !!';
	if( $err=='' && $pwd =='' ) $err= 'Password Belum Di Isi !!';
	// if( $err=='' && $nama =='' ) $err= 'Nama Pegawai Belum Di Isi !!';
	// if( $err=='' && $group =='' ) $err= 'Group Belum Di Isi !!';
	 if( $err=='' && $level =='' ) $err= 'Level Belum Di Pilih !!';
	 $old = mysql_fetch_array(mysql_query("SELECT uid FROM admin WHERE uid='$uid'"));
				
			if($fmST == 0){
				if($err==''){ 
				if($uid == $old['uid']){
				//if($uid==$old['uid']){
				       $get = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM admin WHERE uid='$uid' "));
					   if($get['cnt']>0 ) $err='User Name '.$uid.' Sudah Ada !';
					}
					$aqry = "INSERT into admin(
									uid,
									nama,
									password,
									level,
									`group`,
									modul01,
									modul02,
									modul03,
									modul04,
									modul05,
									modul06,
									modul07,
									modul08,
									modul09,
									modul10,
									modul11,
									modul12,
									modul13,
									modul14,
									modul15,
									modul16,
									modulref,
									moduladm,
									status)
							 values(
							 		'$uid',
									'$nm_lengkap',
									'$md5_pwd',
									'$level',
									'$group',
									'$modul01',
									'$modul02',
									'$modul03',
									'$modul04',
									'$modul05',
									'$modul06',
									'$modul07',
									'$modul08',
									'$modul09',
									'$modul10',
									'$modul11',
									'$modul12',
									'$modul13',
									'$modul14',
									'$modul15',
									'$modul16',
									'$fmMODULref',
							 		'$fmMODULadm',
							 		'$fmStatus'
								    )";	$cek.= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{			
				if($err==''){
				$aqry = "UPDATE admin 
				 		 set uid='$uid',
						 	 nama='$nm_lengkap',".
							 //password='$md5_pwd',
							 "level='$level',
							 `group`='$group',
							 modul01='$modul01',
							 modul02='$modul02',
							 modul03='$modul03',
							 modul04='$modul04',
							 modul05='$modul05',
							 modul06='$modul06',
							 modul07='$modul07',
							 modul08='$modul08',
							 modul09='$modul09',
							 modul10='$modul10',
							 modul11='$modul11',
							 modul12='$modul12',
							 modul13='$modul13',
							 modul14='$modul14',
							 modul15='$modul15',
							 modul16='$modul16',
							 modulref='$fmMODULref',
							 moduladm='$fmMODULadm',
							 status='$fmStatus'
						 WHERE uid='".$idplh."'";$cek.= $aqry;
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
	
	function resetPass(){
		$cek = ''; $err=''; $content=''; $json=TRUE;
		
		$cbid = $_REQUEST[$this->Prefix.'_cb'];				
		$idplh = $cbid[0];
		$newpass = rand(1000,9999); // 4digit
		$get = mysql_query("update admin set password=md5('$newpass') where uid='$idplh'  ");
		//$old = mysql_query("select * from admin where uid='$idplh'  ");
		$content->uid= $idplh;
		$content->pass = $newpass;
		
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
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
			
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$queryc="SELECT c, concat(c, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c!='00' and d='00' and e='00' and e1='000'" ;$cek.=$queryc;
			$content->c=cmbQuery('fmc',$fmc,$queryc,'style="width:360px;"onchange="'.$this->Prefix.'.pilihBidang()"','-------- Pilih Kode BIDANG ------------');
			
			$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d <> '00' and e='00' and e1='000'" ;$cek.=$queryd;
			$content->d=cmbQuery('fmd',$fmd,$queryd,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSKPD()"','-------- Pilih Kode SKPD ----------------');
			
			$querye="SELECT e, concat(e,' . ', nm_skpd) as vnama  FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e<>'00' and e1='000'" ;$cek.=$querye;
			$content->e=cmbQuery('fme',$fme,$querye,'style="width:360px;"onchange="'.$this->Prefix.'.pilihUnit()"','-------- Pilih Kode UNIT -----------------');
			
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->e1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSubUnit()"','-------- Pilih Kode SUB UNIT -----------------');
			
	 		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}
		
		case 'pilihBidang':{				
		global $Main;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
	 
			$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d !='00' and e='00' and e1='000'" ;$cek.=$queryd;
			$content->d=cmbQuery('fmd',$fmd,$queryd,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSKPD()"','-------- Pilih Kode SKPD ----------------');
			
			$querye="SELECT e, concat(e,' . ', nm_skpd) as vnama  FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e<>'00' and e1='000'" ;$cek.=$querye;
			$content->e=cmbQuery('fme',$fme,$querye,'style="width:360px;"onchange="'.$this->Prefix.'.pilihUnit()"','-------- Pilih Kode UNIT -----------------');
			
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->e1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSubUnit()"','-------- Pilih Kode SUB UNIT -----------------');
			
	 		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);											break;
			}
		
		case 'pilihBidang4':{				
		global $Main;
			
			$c = $_REQUEST['fmc4'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
	 
			$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='0' and c='$c' and d !='00' and e='00' and e1='000'" ;$cek.=$queryd;
			$content->d=cmbQuery('fmd4',$fmd,$queryd,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSKPD4()"','-------- Pilih Kode SKPD ----------------');
			
			$querye="SELECT e, concat(e,' . ', nm_skpd) as vnama  FROM ref_skpd WHERE c1='0' and c='$c' and d='$d' and e<>'00' and e1='000'" ;$cek.=$querye;
			$content->e=cmbQuery('fme4',$fme,$querye,'style="width:360px;"onchange="'.$this->Prefix.'.pilihUnit4()"','-------- Pilih Kode UNIT -----------------');
			
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='0' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->e1=cmbQuery('fme14',$fme1,$queryKE1,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSubUnit4()"','-------- Pilih Kode SUB UNIT -----------------');
			
	 		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);											break;
			}
			
		case 'pilihSKPD':{				
		global $Main;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		 
			$querye="SELECT e, concat(e,' . ', nm_skpd) as vnama  FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e!='00' and e1='000'" ;$cek.=$querye;
			$content->skp=cmbQuery('fme',$fme,$querye,'style="width:360px;"onchange="'.$this->Prefix.'.pilihUnit()"','-------- Pilih Kode UNIT -----------------');
			
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->e1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSubUnit()"','-------- Pilih Kode SUB UNIT -----------------');
				
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									
			break;
			}
		
		case 'pilihSKPD4':{				
		global $Main;
			
			$c = $_REQUEST['fmc4'];
			$d = $_REQUEST['fmd4'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		 
			$querye="SELECT e, concat(e,' . ', nm_skpd) as vnama  FROM ref_skpd WHERE c1='0' and c='$c' and d='$d' and e!='00' and e1='000'" ;$cek.=$querye;
			$content->skp=cmbQuery('fme4',$fme,$querye,'style="width:360px;"onchange="'.$this->Prefix.'.pilihUnit4()"','-------- Pilih Kode UNIT -----------------');
			
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='0' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->e1=cmbQuery('fme14',$fme1,$queryKE1,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSubUnit4()"','-------- Pilih Kode SUB UNIT -----------------');
				
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									
			break;
			}
			
		case 'pilihUnit':{				
		global $Main;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
			

			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$cek.="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1!='000'";
			$content->e1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSubUnit()"','-------- Pilih Kode SUB UNIT -----------------'); 
		 	
		 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}		
		
		case 'pilihUnit4':{				
		global $Main;
			
			$c = $_REQUEST['fmc4'];
			$d = $_REQUEST['fmd4'];
			$e = $_REQUEST['fme4'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
			

			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='0' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->e1=cmbQuery('fme14',$fme1,$queryKE1,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSubUnit4()"','-------- Pilih Kode SUB UNIT -----------------'); 
		 	
		 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}		
		
		case 'pilihSubUnit':{				
			global $Main;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		 
			$queryKE1="SELECT p, concat(p,' . ', nm_ruang) as vnama FROM ref_ruang WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and p!='000' and q='0000'" ;$cek.=$queryKE1;
			$content->unit=cmbQuery('p',$gd,$queryKE1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihGedung()"','-------- Pilih Kode Gedung -----------------')."&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruGedung()' title='Kode UNIT' >";$cek.=$queryJenis;
		 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									
			break;
			}	
		
		
		
		case 'resetPass' :{
			$fm = $this->resetPass();				
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
		
		case 'getdata_pegawai':{
			$Id = $_REQUEST['id_pegawai'];
			$cek = $Id;
			$aqry = "SELECT nip, toRoman(gol) as gol, ruang, pangkat, jabatan FROM ref_pegawai WHERE Id=$Id "; $cek .= $aqry;
			$dt=mysql_fetch_array(mysql_query($aqry));
				
			if($dt==FALSE) {
				$err="Pegawai Tidak Ada !";
			}
			else{
			
				$content = array(
					 'nip'=>$dt['nip'],
					 'gol'=>$dt['gol'],
					 'ruang'=>$dt['ruang'],
  					 'pangkat'=>$dt['pangkat'],
					 'jabatan'=>$dt['jabatan'],								 
					 );
			}
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
							document.getElementById('".$this->Prefix."_cont_skpd').innerHTML='<div id=\"skpd_usermanajemen\"></div>';
							skpd_usermanajemen.initial();
						});
					</script>";
		return 
			
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".	
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<script src='js/jquery.js' type='text/javascript'></script>".
			"<script src='js/jquery-ui.js' type='text/javascript'></script>".
			"<script type='text/javascript' src='js/admin/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			$scriptload;
	}
	
	function setCetak_footer($xls=FALSE){
		return 
				"<br>";
				//$this->PrintTTD($this->Cetak_WIDTH, $xls);
	}
	
	//form ==================================
	function setFormBaru(){
	
		
	
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		
		$dt['c1'] = $_REQUEST[$this->Prefix.'SkpdfmURUSAN'];
		$dt['c'] = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$dt['d'] = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$dt['e'] = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$dt['e1'] = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
		
		
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
   
  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  admin WHERE uid='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));

		$fm = $this->setFormDataEdit($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	

	function setForm($dt){	
	 global $SensusTmp,$Main;
	 $cek = ''; $err=''; $content='';		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 600;
	 $this->form_height = 500;
	 $var_urusan = $Main->URUSAN;
		$this->form_fmST==0;
	
		$this->form_caption = 'Baru';
		$username	 ="<input type='text' name='uid' id='uid' value='".$dt['uid']."' size='55' onChange='".$this->Prefix.".cek()'>
					";
						
		//$chkLevel2="checked";	
		$chkModul01_2="checked";	
		$chkModul02_2="checked";	
		$chkModul03_2="checked";	
		$chkModul04_2="checked";	
		$chkModul05_2="checked";	
		$chkModul06_2="checked";	
		$chkModul07_2="checked";	
		$chkModul08_2="checked";	
		$chkModul09_2="checked";	
		$chkModul10_2="checked";	
		$chkModul11_2="checked";	
		$chkModul12_2="checked";	
		$chkModul13_2="checked";	
		$chkModul14_2="checked";	
		$chkModul15_2="checked";	
		$chkModul16_2="checked";	
		$chkModulref_0="checked";	
		$chkModuladm_0="checked";
		$chkLevel2="checked";
		$chkStatus_1="checked";
		$readOnly='';
		
		//-----5 level------
		$queryc1="SELECT c1, concat(c1, '. ', nm_skpd) as vnama FROM ref_skpd where c1!='0' and c=00 and d=00 and e=00 and e1=000";
		$queryc="SELECT c,concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c!=00 and d=00 and e=00 and e1=000";
		$queryd="SELECT d,concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d!='00' and e=00 and e1=000";
		$querye="SELECT e,concat(e, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e!='00' and e1=000";
		$querye1="SELECT e1,concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'";
		
		//-----4 level------
		$queryc4="SELECT c,concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c1='0' and c!=00 and d=00 and e=00 and e1=000";
		$cek.="SELECT c,concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c!=00 and d=00 and e=00 and e1=000";
		$queryd4="SELECT d,concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c='".$dt['c']."' and d!='00' and e=00 and e1=000";
		$cek.="SELECT d,concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c='".$dt['c']."' and d!='00' and e=00 and e1=000";
		$querye4="SELECT e,concat(e, '. ', nm_skpd) as vnama FROM ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e!='00' and e1=000";
		$querye14="SELECT e1,concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1!=000";
		$cek.="SELECT e1, concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1!='000'";
	//	$querye1="SELECT e1, concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1!='000'";
	 if ($var_urusan==1){
		//	$dat_urusan= array('label'=>'URUSAN', 'value'=> $vls_urusan, 'labelWidth'=>120, 'type'=>'' );
			$dat_urusan= array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp URUSAN',
						'labelWidth'=>150, 
						'value'=>"<div id='cont_c1'>".cmbQuery('fmc1',$dt['c1'],$queryc1,'style="width:360px;"onchange="'.$this->Prefix.'.pilihUrusan()"','-------- Pilih Kode URUSAN ----------')."</div>",
						
						 );	
			$dat_bidang= array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp BIDANG',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_c'>".cmbQuery('fmc',$dt['c'],$queryc,'style="width:360px;"onchange="'.$this->Prefix.'.pilihBidang()"','-------- Pilih Kode BIDANG -----------')."</div>",
						 );
			$dat_skpd= array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp SKPD',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_d'>".cmbQuery('fmd',$dt['d'],$queryd,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSKPD()"','-------- Pilih Kode SKPD --------------')."</div>",
						 );	
			$dat_unit= array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e'>".cmbQuery('fme',$dt['e'],$querye,'style="width:360px;"onchange="'.$this->Prefix.'.pilihUnit()"','-------- Pilih Kode UNIT ---------------')."</div>",
						 );
			$dat_subunit= array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp SUB UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e1'>".cmbQuery('fme1',$dt['e1'],$querye1,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSubUnit()"','-------- Pilih Kode SUB UNIT --------')."</div>",
						 );		
		}else{
			$dat_urusan=array('pemisah'=>' ');
			$dat_bidang= array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp BIDANG',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_c'>".cmbQuery('fmc4',$dt['c'],$queryc4,'style="width:360px;"onchange="'.$this->Prefix.'.pilihBidang4()"','-------- Pilih Kode BIDANG -----------')."</div>",
						 );
			$dat_skpd= array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp SKPD',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_d'>".cmbQuery('fmd4',$dt['d'],$queryd4,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSKPD()"','-------- Pilih Kode SKPD --------------')."</div>",
						 );	
			$dat_unit= array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e'>".cmbQuery('fme4',$dt['e'],$querye4,'style="width:360px;"onchange="'.$this->Prefix.'.pilihUnit()"','-------- Pilih Kode UNIT ---------------')."</div>",
						 );
			$dat_subunit= array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp SUB UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e1'>".cmbQuery('fme14',$dt['e1'],$querye14,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSubUnit()"','-------- Pilih Kode SUB UNIT --------')."</div>",
						 );	
		}
	 
	 
	 //items ----------------------
	  $this->form_fields = array(
			'uid' => array( 
						'label'=>'User Name',
						//'labelWidth'=>200, 
						'value'=>$username, 
						'type'=>'',
						'param'=>""
						 ),
			
			'nm_lengkap' => array( 
						'label'=>'Nama Lengkap',
						//'labelWidth'=>150, 			 
						'value'=>"<input type='text' name='nm_lengkap' id='nm_lengkap' value='".$dt['nama']."' size='55'>
								 ",
						),
			'password' => array( 
				'label'=>'Password',
				//'labelWidth'=>200, 
				'value'=>
					"<input type='password' name='password' id='password' value='".$dt['password']."' size='55' $readOnly>".
					//"&nbsp;&nbsp;<input type='button' value='Ganti' totle='Ganti Password'>"
					''
					, 
			),
			
			'hak_akses3' => array( 
						'label'=>'',						
						'value'=>'Group',
						'type'=>'merge'
						 ),
			
			$dat_urusan,
			$dat_bidang,
			$dat_skpd,
			$dat_unit,
			$dat_subunit,
						
			'level' => array( 
				'label'=>'Level',
				//'labelWidth'=>200, 
				'value'=>
				"<INPUT $chkLevel1 TYPE='RADIO' NAME='fmLEVELPENGGUNA' ID='fmLEVELPENGGUNA' VALUE='1' onClick=\"".$this->Prefix.".LevelAdmin()\">&nbsp;Administrator &nbsp;&nbsp;&nbsp;&nbsp;
				<INPUT $chkLevel2 TYPE='RADIO' NAME='fmLEVELPENGGUNA' ID='fmLEVELOPERATOR' VALUE='2' onClick=\"".$this->Prefix.".LevelOperator()\">&nbsp;Operator &nbsp;&nbsp;&nbsp;&nbsp;
				",
				'type'=>'',
			),
			'status' => array( 
						'label'=>'Status User',
						//'labelWidth'=>200, 
						'value'=>
				"<INPUT $chkStatus_0 TYPE='RADIO' NAME='fmStatus' VALUE='0' >&nbsp;Disabled / Blocked&nbsp;&nbsp;&nbsp;&nbsp;
				<INPUT $chkStatus_1 TYPE='RADIO' NAME='fmStatus' VALUE='1' >&nbsp;Aktif &nbsp;&nbsp;&nbsp;&nbsp;",
						'type'=>'',
						 ),
			'modul' => array( 
				'label'=>'',						
				'value'=>"<div style='padding: 4 0 4 0;'>Hak Akses</div>",
				'type'=>'merge'
			),	
			'modult' => array( 
				'label'=>'',						
				'value'=>
					"<table width='100%'>".
						"<tr valign='top'><td>1.</td><td>Perencanaan dan Penganggaran</td><td>:</td>".
						"<td>
							<INPUT $chkModul01_0 TYPE='RADIO' NAME='fmMODUL01' ID='fmMODUL01_0' VALUE='0'>&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul01_1 TYPE='RADIO' NAME='fmMODUL01' ID='fmMODUL01_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul01_2 TYPE='RADIO' NAME='fmMODUL01' ID='fmMODUL01_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>2.</td><td>Pengadaan</td><td>:</td>".
						"<td>
							<INPUT $chkModul02_0 TYPE='RADIO' NAME='fmMODUL02' ID='fmMODUL02_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul02_1 TYPE='RADIO' NAME='fmMODUL02' ID='fmMODUL02_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul02_2 TYPE='RADIO' NAME='fmMODUL02' ID='fmMODUL02_2' VALUE='2' >&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>3.</td><td>Penerimaan dan Pengeluaran</td><td>:</td>".
						"<td>
							<INPUT $chkModul03_0 TYPE='RADIO' NAME='fmMODUL03' ID='fmMODUL03_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul03_1 TYPE='RADIO' NAME='fmMODUL03' ID='fmMODUL03_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul03_2 TYPE='RADIO' NAME='fmMODUL03' ID='fmMODUL03_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>4.</td><td>Penggunaan</td><td>:</td>".
						"<td>
							<INPUT $chkModul04_0 TYPE='RADIO' NAME='fmMODUL04' ID='fmMODUL04_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul04_1 TYPE='RADIO' NAME='fmMODUL04' ID='fmMODUL04_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul04_2 TYPE='RADIO' NAME='fmMODUL04'ID='fmMODUL04_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>5.</td><td>Penatausahaan</td><td>:</td>".
						"<td>
							<INPUT $chkModul05_0 TYPE='RADIO' NAME='fmMODUL05' ID='fmMODUL05_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul05_1 TYPE='RADIO' NAME='fmMODUL05' ID='fmMODUL05_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul05_2 TYPE='RADIO' NAME='fmMODUL05' ID='fmMODUL05_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>6.</td><td>Pemanfaatan</td><td>:</td>".
						"<td>
							<INPUT $chkModul06_0 TYPE='RADIO' NAME='fmMODUL06' ID='fmMODUL06_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul06_1 TYPE='RADIO' NAME='fmMODUL06' ID='fmMODUL06_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul06_2 TYPE='RADIO' NAME='fmMODUL06' ID='fmMODUL06_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>7.</td><td>Pengamanan dan Pemeliharaan</td><td>:</td>".
						"<td>
							<INPUT $chkModul07_0 TYPE='RADIO' NAME='fmMODUL07' ID='fmMODUL07_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul07_1 TYPE='RADIO' NAME='fmMODUL07' ID='fmMODUL07_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul07_2 TYPE='RADIO' NAME='fmMODUL07' ID='fmMODUL07_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"</tr>".
						"<tr valign='top'><td>8.</td><td>Penilaian</td><td>:</td>".
						"<td>
							<INPUT $chkModul08_0 TYPE='RADIO' NAME='fmMODUL08' ID='fmMODUL08_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul08_1 TYPE='RADIO' NAME='fmMODUL08' ID='fmMODUL08_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul08_2 TYPE='RADIO' NAME='fmMODUL08' ID='fmMODUL08_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>9.</td><td>Penghapusan</td><td>:</td>".
						"<td>
							<INPUT $chkModul09_0 TYPE='RADIO' NAME='fmMODUL09' ID='fmMODUL09_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul09_1 TYPE='RADIO' NAME='fmMODUL09' ID='fmMODUL09_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul09_2 TYPE='RADIO' NAME='fmMODUL09' ID='fmMODUL09_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"</tr>".
						"<tr valign='top'><td>10.</td><td>Pemindahtanganan</td><td>:</td>".
						"<td>
							<INPUT $chkModul10_0 TYPE='RADIO' NAME='fmMODUL10' ID='fmMODUL10_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul10_1 TYPE='RADIO' NAME='fmMODUL10' ID='fmMODUL10_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul10_2 TYPE='RADIO' NAME='fmMODUL10' ID='fmMODUL10_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>11.</td><td>Pembiayaan</td><td>:</td>".
						"<td>
							<INPUT $chkModul11_0 TYPE='RADIO' NAME='fmMODUL11' ID='fmMODUL11_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul11_1 TYPE='RADIO' NAME='fmMODUL11' ID='fmMODUL11_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul11_2 TYPE='RADIO' NAME='fmMODUL11' ID='fmMODUL11_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"</tr>".
						"<tr valign='top'><td>12.</td><td>Tuntutan Ganti Rugi</td><td>:</td>".
						"<td>
							<INPUT $chkModul12_0 TYPE='RADIO' NAME='fmMODUL12' ID='fmMODUL12_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul12_1 TYPE='RADIO' NAME='fmMODUL12' ID='fmMODUL12_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul12_2 TYPE='RADIO' NAME='fmMODUL12' ID='fmMODUL12_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>13.</td><td>Pengawasan dan Pengendalian</td><td>:</td>".
						"<td>
							<INPUT $chkModul13_0 TYPE='RADIO' NAME='fmMODUL13' ID='fmMODUL13_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul13_1 TYPE='RADIO' NAME='fmMODUL13' ID='fmMODUL13_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul13_2 TYPE='RADIO' NAME='fmMODUL13' ID='fmMODUL13_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"<tr valign='top'><td>14.</td><td>Penyusutan</td><td>:</td>".
						"<td>
							<INPUT $chkModul14_0 TYPE='RADIO' NAME='fmMODUL14' ID='fmMODUL14_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul14_1 TYPE='RADIO' NAME='fmMODUL14' ID='fmMODUL14_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul14_2 TYPE='RADIO' NAME='fmMODUL14' ID='fmMODUL14_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"<tr valign='top'><td>15.</td><td>Laporan</td><td>:</td>".
						"<td>
							<INPUT $chkModul15_0 TYPE='RADIO' NAME='fmMODUL15' ID='fmMODUL15_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul15_1 TYPE='RADIO' NAME='fmMODUL15' ID='fmMODUL15_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul15_2 TYPE='RADIO' NAME='fmMODUL15' ID='fmMODUL15_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"<tr valign='top'><td>16.</td><td>Inventaris dan sensus</td><td>:</td>".
						"<td>
							<INPUT $chkModul16_0 TYPE='RADIO' NAME='fmMODUL16' ID='fmMODUL16_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul16_1 TYPE='RADIO' NAME='fmMODUL16' ID='fmMODUL16_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul16_2 TYPE='RADIO' NAME='fmMODUL16' ID='fmMODUL16_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"<tr valign='top'><td>17.</td><td>Referensi</td><td>:</td>".
						"<td>
							<INPUT $chkModulref_0 TYPE='RADIO' NAME='fmMODULref' VALUE='0'>&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModulref_1 TYPE='RADIO' NAME='fmMODULref' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModulref_2 TYPE='RADIO' NAME='fmMODULref' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>18.</td><td>Administrasi</td><td>:</td>".
						"<td>
							<INPUT $chkModuladm_0 TYPE='RADIO' NAME='fmMODULadm' VALUE='0'>&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModuladm_1 TYPE='RADIO' NAME='fmMODULadm' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModuladm_2 TYPE='RADIO' NAME='fmMODULadm' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						
					"</table>",
				'type'=>'merge'
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
	
	function setFormDataEdit($dt){	
	 global $SensusTmp,$Main;
	 $cek = ''; $err=''; $content='';		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 600;
	 $this->form_height = 500;
	 $var_urusan = $Main->URUSAN;
	 
		$this->form_fmST==1;
		$this->form_caption = 'Edit';
		
		$fmGROUPPENGGUNA = $dt['group'];
		$arrGroup = explode('.',$fmGROUPPENGGUNA );
		if ($var_urusan==0){
			$urusan = $arrGroup[0];
			$bidang = $arrGroup[0];
			$skpd = $arrGroup[1];
			$unit = $arrGroup[2];
			$subunit = $arrGroup[3];
		}else{
			$urusan = $arrGroup[0];
			$bidang = $arrGroup[1];
			$skpd = $arrGroup[2];
			$unit = $arrGroup[3];
			$subunit = $arrGroup[4];
		}	
		
		
		$username	 ="<input type='text' name='uid' id='uid' value='".$dt['uid']."' size='55' onChange='".$this->Prefix.".cek()' readonly='1' >
						";
		$readOnly='readonly=1';
		$fmLEVELPENGGUNA = $dt['level'];
		$fmMODUL01 = $dt['modul01'];
		$fmMODUL02 = $dt['modul02'];
		$fmMODUL03 = $dt['modul03'];
		$fmMODUL04 = $dt['modul04'];
		$fmMODUL05 = $dt['modul05'];
		$fmMODUL06 = $dt['modul06'];
		$fmMODUL07 = $dt['modul07'];
		$fmMODUL08 = $dt['modul08'];
		$fmMODUL09 = $dt['modul09'];
		$fmMODUL10 = $dt['modul10'];
		$fmMODUL11 = $dt['modul11'];
		$fmMODUL12 = $dt['modul12'];
		$fmMODUL13 = $dt['modul13'];
		$fmMODUL14 = $dt['modul14'];
		$fmMODUL15 = $dt['modul15'];
		$fmMODUL16 = $dt['modul16'];
		$fmMODULref = $dt['modulref'];
		$fmMODULadm = $dt['moduladm'];
		$fmStatus = $dt['status'];
		
		$chkLevel1 = $fmLEVELPENGGUNA == "1" ? "checked":"";$chkLevel2 = $fmLEVELPENGGUNA == "2" ? "checked":"";$chkLevel3 = $fmLEVELPENGGUNA == "3" ? "checked":"";
		//$chkLevel1 = $fmLEVELPENGGUNA == "1" ? "checked":""; $chkLevel2 = $fmLEVELPENGGUNA == "2" ? "checked":""; $chkLevel3 = $fmLEVELPENGGUNA == "3" ? "checked":"";
		$chkStatus_0 = $fmStatus == "0" ? "checked":"";$chkStatus_1 = $fmStatus == "1" ? "checked":"";
		
		$chkModul01_0 = $fmMODUL01== "0" ? "checked":"";$chkModul01_1 = $fmMODUL01== "1" ? "checked":"";$chkModul01_2 = $fmMODUL01== "2" ? "checked":"";
		$chkModul02_0 = $fmMODUL02 == "0" ? "checked":"";$chkModul02_1 = $fmMODUL02 == "1" ? "checked":"";$chkModul02_2 = $fmMODUL02 == "2" ? "checked":"";
		$chkModul03_0 = $fmMODUL03 == "0" ? "checked":"";$chkModul03_1 = $fmMODUL03 == "1" ? "checked":"";$chkModul03_2 = $fmMODUL03 == "2" ? "checked":"";
		$chkModul04_0 = $fmMODUL04 == "0" ? "checked":"";$chkModul04_1 = $fmMODUL04 == "1" ? "checked":"";$chkModul04_2 = $fmMODUL04 == "2" ? "checked":"";
		$chkModul05_0 = $fmMODUL05 == "0" ? "checked":"";$chkModul05_1 = $fmMODUL05 == "1" ? "checked":"";$chkModul05_2 = $fmMODUL05 == "2" ? "checked":"";
		$chkModul06_0 = $fmMODUL06 == "0" ? "checked":"";$chkModul06_1 = $fmMODUL06 == "1" ? "checked":"";$chkModul06_2 = $fmMODUL06 == "2" ? "checked":"";
		$chkModul07_0 = $fmMODUL07 == "0" ? "checked":"";$chkModul07_1 = $fmMODUL07 == "1" ? "checked":"";$chkModul07_2 = $fmMODUL07 == "2" ? "checked":"";
		$chkModul08_0 = $fmMODUL08 == "0" ? "checked":"";$chkModul08_1 = $fmMODUL08 == "1" ? "checked":"";$chkModul08_2 = $fmMODUL08 == "2" ? "checked":"";
		$chkModul09_0 = $fmMODUL09 == "0" ? "checked":"";$chkModul09_1 = $fmMODUL09 == "1" ? "checked":"";$chkModul09_2 = $fmMODUL09 == "2" ? "checked":"";
		$chkModul10_0 = $fmMODUL10 == "0" ? "checked":"";$chkModul10_1 = $fmMODUL10 == "1" ? "checked":"";$chkModul10_2 = $fmMODUL10 == "2" ? "checked":"";
		$chkModul11_0 = $fmMODUL11 == "0" ? "checked":"";$chkModul11_1 = $fmMODUL11 == "1" ? "checked":"";$chkModul11_2 = $fmMODUL11 == "2" ? "checked":"";
		$chkModul12_0 = $fmMODUL12 == "0" ? "checked":"";$chkModul12_1 = $fmMODUL12 == "1" ? "checked":"";$chkModul12_2 = $fmMODUL12 == "2" ? "checked":"";			
		$chkModul13_0 = $fmMODUL13 == "0" ? "checked":"";$chkModul13_1 = $fmMODUL13 == "1" ? "checked":"";$chkModul13_2 = $fmMODUL13 == "2" ? "checked":"";
		$chkModul14_0 = $fmMODUL14 == "0" ? "checked":"";$chkModul14_1 = $fmMODUL14 == "1" ? "checked":"";$chkModul14_2 = $fmMODUL14 == "2" ? "checked":"";
		$chkModul15_0 = $fmMODUL15 == "0" ? "checked":"";$chkModul15_1 = $fmMODUL15 == "1" ? "checked":"";$chkModul15_2 = $fmMODUL15 == "2" ? "checked":"";
		$chkModul16_0 = $fmMODUL16 == "0" ? "checked":"";$chkModul16_1 = $fmMODUL16 == "1" ? "checked":"";$chkModul16_2 = $fmMODUL16 == "2" ? "checked":"";
		$chkModulref_0 = $fmMODULref == "0" ? "checked":"";$chkModulref_1 = $fmMODULref == "1" ? "checked":"";$chkModulref_2 = $fmMODULref == "2" ? "checked":"";
		$chkModuladm_0 = $fmMODULadm == "0" ? "checked":"";$chkModuladm_1 = $fmMODULadm == "1" ? "checked":"";$chkModuladm_2 = $fmMODULadm == "2" ? "checked":"";
		
	//}
	 
	
		
		$queryc1="SELECT c1, concat(c1, '. ', nm_skpd) as vnama FROM ref_skpd where c1!='0' and c=00 and d=00 and e=00 and e1=000";
		$queryc="SELECT c,concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$urusan' and c!=00 and d=00 and e=00 and e1=000";
		$queryd="SELECT d,concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$urusan' and c='$bidang' and d!='00' and e=00 and e1=000";
		$querye="SELECT e,concat(e, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$urusan' and c='$bidang' and d='$skpd' and e!='00' and e1=000";
		$querye1="SELECT e1,concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$urusan' and c='$bidang' and d='$skpd' and e='$unit' and e1='$subunit'" ;
		
		$queryc4="SELECT c,concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c1='0' and c!=00 and d=00 and e=00 and e1=000";
		$queryd4="SELECT d,concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c1='0' and c='$bidang' and d!='00' and e=00 and e1=000";
		$querye4="SELECT e,concat(e, '. ', nm_skpd) as vnama FROM ref_skpd where c1='0' and c='$bidang' and d='$skpd' and e!='00' and e1=000";
	//	$querye14="SELECT e1,concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c1='0' and c='$bidang' and d='$skpd' and e='$unit' and e1='$subunit'" ;	$cek.=$querye14;
		$querye14="SELECT e1,concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c1='0' and c='$bidang' and d='$skpd' and e='$unit' and e1='$subunit'" ;	$cek.=$querye14;
		
		
		
	if ($var_urusan==1){
		$dt_urusan = array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp URUSAN',
						'labelWidth'=>150, 
						'value'=>"<div id='cont_c1'>".cmbQuery('fmc1',$urusan,$queryc1,'style="width:360px;"onchange="'.$this->Prefix.'.pilihUrusan()"','-------- Pilih Kode URUSAN ----------')."</div>",);		
					 	
	$dt_skpd = array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp BIDANG',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_c'>".cmbQuery('fmc',$bidang,$queryc,'style="width:360px;"onchange="'.$this->Prefix.'.pilihBidang()"','-------- Pilih Kode BIDANG -----------')."</div>",
						 );
						 		 
	$dt_unit = array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp SKPD',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_d'>".cmbQuery('fmd',$skpd,$queryd,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSKPD()"','-------- Pilih Kode SKPD --------------')."</div>",
						 );	
						 
	$dt_subunit = array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e'>".cmbQuery('fme',$unit,$querye,'style="width:360px;"onchange="'.$this->Prefix.'.pilihUnit()"','-------- Pilih Kode UNIT ---------------')."</div>",
						 );		
				
	$dt_seksi = array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp SUB UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e1'>".cmbQuery('fme1',$subunit,$querye1,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSubUnit()"','-------- Pilih Kode SUB UNIT --------')."</div>",
						 );
	}else{
	
	$dt_urusan = array('pemisah'=>' ');	
					 	
	$dt_skpd = array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp BIDANG',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_c'>".cmbQuery('fmc4',$bidang,$queryc4,'style="width:360px;"onchange="'.$this->Prefix.'.pilihBidang4()"','-------- Pilih Kode BIDANG -----------')."</div>",
						 );
						 		 
	$dt_unit = array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp SKPD',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_d'>".cmbQuery('fmd4',$skpd,$queryd4,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSKPD4()"','-------- Pilih Kode SKPD --------------')."</div>",
						 );	
						 
	$dt_subunit = array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e'>".cmbQuery('fme4',$unit,$querye4,'style="width:360px;"onchange="'.$this->Prefix.'.pilihUnit4()"','-------- Pilih Kode UNIT ---------------')."</div>",
						 );		
				
	$dt_seksi = array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp SUB UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e1'>".cmbQuery('fme14',$subunit,$querye14,'style="width:360px;"onchange="'.$this->Prefix.'.pilihSubUnit4()"','-------- Pilih Kode SUB UNIT --------')."</div>",
						 );
	}
		 
	 //items ----------------------
	  $this->form_fields = array(
			'uid' => array( 
						'label'=>'User Name',
						//'labelWidth'=>200, 
						'value'=>$username, 
						'type'=>'',
						'param'=>""
						 ),
			
			'nm_lengkap' => array( 
						'label'=>'Nama Lengkap',
						//'labelWidth'=>150, 			 
						'value'=>"<input type='text' name='nm_lengkap' id='nm_lengkap' value='".$dt['nama']."' size='55'>
								 ",
						),
			'password' => array( 
				'label'=>'Password',
				//'labelWidth'=>200, 
				'value'=>
					"<input type='password' name='password' id='password' value='".$dt['password']."' size='55' $readOnly>".
					//"&nbsp;&nbsp;<input type='button' value='Ganti' totle='Ganti Password'>"
					''
					, 
			),
			
			'hak_akses3' => array( 
						'label'=>'',						
						'value'=>'Group',
						'type'=>'merge'
						 ),
			
			$dt_urusan,
			$dt_skpd,
			$dt_unit,
			$dt_subunit,
			$dt_seksi,	
		
			'level' => array( 
				'label'=>'Level', 
				'value'=>
				"<INPUT $chkLevel1 TYPE='RADIO' NAME='fmLEVELPENGGUNA' ID='fmLEVELPENGGUNA' VALUE='1' onClick=\"".$this->Prefix.".LevelAdmin()\">&nbsp;Administrator &nbsp;&nbsp;&nbsp;&nbsp;
				<INPUT $chkLevel2 TYPE='RADIO' NAME='fmLEVELPENGGUNA' ID='fmLEVELOPERATOR' VALUE='2' onClick=\"".$this->Prefix.".LevelOperator()\">&nbsp;Operator &nbsp;&nbsp;&nbsp;&nbsp;
				",
				'type'=>'',
			),
			'status' => array( 
						'label'=>'Status User',
						//'labelWidth'=>200, 
						'value'=>
				"<INPUT $chkStatus_0 TYPE='RADIO' NAME='fmStatus' VALUE='0' >&nbsp;Disabled / Blocked&nbsp;&nbsp;&nbsp;&nbsp;
				<INPUT $chkStatus_1 TYPE='RADIO' NAME='fmStatus' VALUE='1' >&nbsp;Aktif &nbsp;&nbsp;&nbsp;&nbsp;",
						'type'=>'',
						 ),
			'modul' => array( 
				'label'=>'',						
				'value'=>"<div style='padding: 4 0 4 0;'>Hak Akses</div>",
				'type'=>'merge'
			),	
			'modult' => array( 
				'label'=>'',						
				'value'=>
					"<table width='100%'>".
						"<tr valign='top'><td>1.</td><td>Perencanaan dan Penganggaran</td><td>:</td>".
						"<td>
							<INPUT $chkModul01_0 TYPE='RADIO' NAME='fmMODUL01' ID='fmMODUL01_0' VALUE='0'>&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul01_1 TYPE='RADIO' NAME='fmMODUL01' ID='fmMODUL01_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul01_2 TYPE='RADIO' NAME='fmMODUL01' ID='fmMODUL01_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>2.</td><td>Pengadaan</td><td>:</td>".
						"<td>
							<INPUT $chkModul02_0 TYPE='RADIO' NAME='fmMODUL02' ID='fmMODUL02_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul02_1 TYPE='RADIO' NAME='fmMODUL02' ID='fmMODUL02_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul02_2 TYPE='RADIO' NAME='fmMODUL02' ID='fmMODUL02_2' VALUE='2' >&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>3.</td><td>Penerimaan dan Pengeluaran</td><td>:</td>".
						"<td>
							<INPUT $chkModul03_0 TYPE='RADIO' NAME='fmMODUL03' ID='fmMODUL03_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul03_1 TYPE='RADIO' NAME='fmMODUL03' ID='fmMODUL03_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul03_2 TYPE='RADIO' NAME='fmMODUL03' ID='fmMODUL03_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>4.</td><td>Penggunaan</td><td>:</td>".
						"<td>
							<INPUT $chkModul04_0 TYPE='RADIO' NAME='fmMODUL04' ID='fmMODUL04_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul04_1 TYPE='RADIO' NAME='fmMODUL04' ID='fmMODUL04_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul04_2 TYPE='RADIO' NAME='fmMODUL04'ID='fmMODUL04_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>5.</td><td>Penatausahaan</td><td>:</td>".
						"<td>
							<INPUT $chkModul05_0 TYPE='RADIO' NAME='fmMODUL05' ID='fmMODUL05_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul05_1 TYPE='RADIO' NAME='fmMODUL05' ID='fmMODUL05_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul05_2 TYPE='RADIO' NAME='fmMODUL05' ID='fmMODUL05_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>6.</td><td>Pemanfaatan</td><td>:</td>".
						"<td>
							<INPUT $chkModul06_0 TYPE='RADIO' NAME='fmMODUL06' ID='fmMODUL06_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul06_1 TYPE='RADIO' NAME='fmMODUL06' ID='fmMODUL06_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul06_2 TYPE='RADIO' NAME='fmMODUL06' ID='fmMODUL06_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>7.</td><td>Pengamanan dan Pemeliharaan</td><td>:</td>".
						"<td>
							<INPUT $chkModul07_0 TYPE='RADIO' NAME='fmMODUL07' ID='fmMODUL07_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul07_1 TYPE='RADIO' NAME='fmMODUL07' ID='fmMODUL07_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul07_2 TYPE='RADIO' NAME='fmMODUL07' ID='fmMODUL07_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"</tr>".
						"<tr valign='top'><td>8.</td><td>Penilaian</td><td>:</td>".
						"<td>
							<INPUT $chkModul08_0 TYPE='RADIO' NAME='fmMODUL08' ID='fmMODUL08_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul08_1 TYPE='RADIO' NAME='fmMODUL08' ID='fmMODUL08_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul08_2 TYPE='RADIO' NAME='fmMODUL08' ID='fmMODUL08_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>9.</td><td>Penghapusan</td><td>:</td>".
						"<td>
							<INPUT $chkModul09_0 TYPE='RADIO' NAME='fmMODUL09' ID='fmMODUL09_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul09_1 TYPE='RADIO' NAME='fmMODUL09' ID='fmMODUL09_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul09_2 TYPE='RADIO' NAME='fmMODUL09' ID='fmMODUL09_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"</tr>".
						"<tr valign='top'><td>10.</td><td>Pemindahtanganan</td><td>:</td>".
						"<td>
							<INPUT $chkModul10_0 TYPE='RADIO' NAME='fmMODUL10' ID='fmMODUL10_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul10_1 TYPE='RADIO' NAME='fmMODUL10' ID='fmMODUL10_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul10_2 TYPE='RADIO' NAME='fmMODUL10' ID='fmMODUL10_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>11.</td><td>Pembiayaan</td><td>:</td>".
						"<td>
							<INPUT $chkModul11_0 TYPE='RADIO' NAME='fmMODUL11' ID='fmMODUL11_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul11_1 TYPE='RADIO' NAME='fmMODUL11' ID='fmMODUL11_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul11_2 TYPE='RADIO' NAME='fmMODUL11' ID='fmMODUL11_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"</tr>".
						"<tr valign='top'><td>12.</td><td>Tuntutan Ganti Rugi</td><td>:</td>".
						"<td>
							<INPUT $chkModul12_0 TYPE='RADIO' NAME='fmMODUL12' ID='fmMODUL12_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul12_1 TYPE='RADIO' NAME='fmMODUL12' ID='fmMODUL12_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul12_2 TYPE='RADIO' NAME='fmMODUL12' ID='fmMODUL12_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>13.</td><td>Pengawasan dan Pengendalian</td><td>:</td>".
						"<td>
							<INPUT $chkModul13_0 TYPE='RADIO' NAME='fmMODUL13' ID='fmMODUL13_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul13_1 TYPE='RADIO' NAME='fmMODUL13' ID='fmMODUL13_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul13_2 TYPE='RADIO' NAME='fmMODUL13' ID='fmMODUL13_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"<tr valign='top'><td>14.</td><td>Penyusutan</td><td>:</td>".
						"<td>
							<INPUT $chkModul14_0 TYPE='RADIO' NAME='fmMODUL14' ID='fmMODUL14_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul14_1 TYPE='RADIO' NAME='fmMODUL14' ID='fmMODUL14_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul14_2 TYPE='RADIO' NAME='fmMODUL14' ID='fmMODUL14_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"<tr valign='top'><td>15.</td><td>Laporan</td><td>:</td>".
						"<td>
							<INPUT $chkModul15_0 TYPE='RADIO' NAME='fmMODUL15' ID='fmMODUL15_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul15_1 TYPE='RADIO' NAME='fmMODUL15' ID='fmMODUL15_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul15_2 TYPE='RADIO' NAME='fmMODUL15' ID='fmMODUL15_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"<tr valign='top'><td>16.</td><td>Inventaris dan Sensus</td><td>:</td>".
						"<td>
							<INPUT $chkModul16_0 TYPE='RADIO' NAME='fmMODUL16' ID='fmMODUL16_0' VALUE='0' >&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul16_1 TYPE='RADIO' NAME='fmMODUL16' ID='fmMODUL16_1' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModul16_2 TYPE='RADIO' NAME='fmMODUL16' ID='fmMODUL16_2' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"<tr valign='top'><td>17.</td><td>Referensi</td><td>:</td>".
						"<td>
							<INPUT $chkModulref_0 TYPE='RADIO' NAME='fmMODULref' VALUE='0'>&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModulref_1 TYPE='RADIO' NAME='fmMODULref' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModulref_2 TYPE='RADIO' NAME='fmMODULref' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						"<tr valign='top'><td>18.</td><td>Administrasi</td><td>:</td>".
						"<td>
							<INPUT $chkModuladm_0 TYPE='RADIO' NAME='fmMODULadm' VALUE='0'>&nbsp;Disabled &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModuladm_1 TYPE='RADIO' NAME='fmMODULadm' VALUE='1'>&nbsp;Write &nbsp;&nbsp;&nbsp;&nbsp;
							<INPUT $chkModuladm_2 TYPE='RADIO' NAME='fmMODULadm' VALUE='2'>&nbsp;Read &nbsp;&nbsp;&nbsp;&nbsp;
						</td>".
						"</tr>".
						
					"</table>",
				'type'=>'merge'
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
	
	
	function setPage_HeaderOther(){
		
	return "";
		
	}
		
	//daftar =================================

	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th width='1%' class='th01'  rowspan=2 >No.</th>
  	   $Checkbox		
	   <th width='5%' class='th01' rowspan=2 align='center' width='5%'>User Name /<br> Nama Lengkap</th>
	   <th width='5%' class='th01' rowspan=2 align='center' width='5%'>Level /<br> Group<br><br></th>
	   <th width='5%' class='th01' rowspan=2 align='center' >Status<br><br><br></th>
	   <th width='5%' class='th02' colspan=18>Modul</th>
	   </tr>
	   <tr>
	   <th width='5%' class='th01' align='center' >Perencanaan <br>dan<br> Penganggaran</th>
	   <th width='5%' class='th01' align='center' >Pengadaan<br><br><br></th>
	   <th width='5%' class='th01' align='center' >Penerimaan<br> dan<br> Pengeluaran</th>
	   <th width='5%' class='th01' align='center' >Penggunaan<br><br><br></th>
	   <th width='5%' class='th01' align='center' >Penatausahaan<br><br><br></th>
	   <th width='5%' class='th01' align='center' >Pemanfaatan<br><br><br></th>
	   <th width='5%' class='th01' align='center' >Pengamanan<br> dan<br> Pemeliharaan</th>
	   <th width='5%' class='th01' align='center' >Penilaian<br><br><br></th>
	   <th width='5%' class='th01' align='center' >Penghapusan<br><br><br></th>
	   <th width='5%' class='th01' align='center' >Pemindah<br>tanganan<br><br></th>
	   <th width='5%' class='th01' align='center' >Pembiayaan<br><br><br></th>
	   <th width='5%' class='th01' align='center' >Tuntutan<br> Ganti Rugi</th>
	   <th width='5%' class='th01' align='center' >Pengawasan<br> dan<br> Pengendalian</th>
	   <th width='5%' class='th01' align='center' >Penyusutan<br><br><br></th>
	   <th width='5%' class='th01' align='center' >Laporan<br><br><br></th>
	   <th width='5%' class='th01' align='center' >Inventaris <br>dan <br>sensus</th>
	   <th width='5%' class='th01' align='center' >Referensi<br><br><br></th>
	   <th width='5%' class='th01' align='center' >Administrasi<br><br><br></th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 //Level
	 if($isi['level']==1){
	 	$isi['level']='Administrator';
	 }elseif($isi['level']==2){
	 	$isi['level']='Operator';
	 }else{
	 	$isi['level']='-';
	 }
	
	 //Modul 1
	 if($isi['modul01']==0){
	 	$isi['modul01']='Disable';
	 }elseif($isi['modul01']==1){
	 	$isi['modul01']='Write';
	 }else{
	 	$isi['modul01']='Read';
	 }
	 
	 //Modul 2
	 if($isi['modul02']==0){
	 	$isi['modul02']='Disable';
	 }elseif($isi['modul02']==1){
	 	$isi['modul02']='Write';
	 }else{
	 	$isi['modul02']='Read';
	 }
	 
	 //Modul 3
	if($isi['modul03']==0){
	 	$isi['modul03']='Disable';
	 }elseif($isi['modul03']==1){
	 	$isi['modul03']='Write';
	 }else{
	 	$isi['modul03']='Read';
	 }
	 
	 
	 //Modul 4
	 if($isi['modul04']==0){
	 	$isi['modul04']='Disable';
	 }elseif($isi['modul04']==1){
	 	$isi['modul04']='Write';
	 }else{
	 	$isi['modul04']='Read';
	 }
	 
	 //Modul 5
	 if($isi['modul05']==0){
	 	$isi['modul05']='Disable';
	 }elseif($isi['modul05']==1){
	 	$isi['modul05']='Write';
	 }else{
	 	$isi['modul05']='Read';
	 }
	 
	 //Modul 6
	 if($isi['modul06']==0){
	 	$isi['modul06']='Disable';
	 }elseif($isi['modul06']==1){
	 	$isi['modul06']='Write';
	 }else{
	 	$isi['modul06']='Read';
	 }
	 
	 //Modul 7
	 if($isi['modul07']==0){
	 	$isi['modul07']='Disable';
	 }elseif($isi['modul07']==1){
	 	$isi['modul07']='Write';
	 }else{
	 	$isi['modul07']='Read';
	 }
	 
	  //Modul 8
	 if($isi['modul08']==0){
	 	$isi['modul08']='Disable';
	 }elseif($isi['modul08']==1){
	 	$isi['modul08']='Write';
	 }else{
	 	$isi['modul08']='Read';
	 }
	
	  //Modul 9
	 if($isi['modul09']==0){
	 	$isi['modul09']='Disable';
	 }elseif($isi['modul09']==1){
	 	$isi['modul09']='Write';
	 }else{
	 	$isi['modul09']='Read';
	 }
	
	  //Modul 10
	 if($isi['modul10']==0){
	 	$isi['modul10']='Disable';
	 }elseif($isi['modul10']==1){
	 	$isi['modul10']='Write';
	 }else{
	 	$isi['modul10']='Read';
	 }
	 
	  //Modul 11
	 if($isi['modul11']==0){
	 	$isi['modul11']='Disable';
	 }elseif($isi['modul11']==1){
	 	$isi['modul11']='Write';
	 }else{
	 	$isi['modul11']='Read';
	 }
	 
	  //Modul 12
	 if($isi['modul12']==0){
	 	$isi['modul12']='Disable';
	 }elseif($isi['modul12']==1){
	 	$isi['modul12']='Write';
	 }else{
	 	$isi['modul12']='Read';
	 }
	  //Modul 13
	 if($isi['modul13']==0){
	 	$isi['modul13']='Disable';
	 }elseif($isi['modul13']==1){
	 	$isi['modul13']='Write';
	 }else{
	 	$isi['modul13']='Read';
	 }
	 
	 if($isi['modul14']==0){
	 	$isi['modul14']='Disable';
	 }elseif($isi['modul14']==1){
	 	$isi['modul14']='Write';
	 }else{
	 	$isi['modul14']='Read';
	 }
	 
	 if($isi['modul15']==0){
	 	$isi['modul15']='Disable';
	 }elseif($isi['modul15']==1){
	 	$isi['modul15']='Write';
	 }else{
	 	$isi['modul15']='Read';
	 }
	 
	 if($isi['modul16']==0){
	 	$isi['modul16']='Disable';
	 }elseif($isi['modul16']==1){
	 	$isi['modul16']='Write';
	 }else{
	 	$isi['modul16']='Read';
	 }
	  
	 //Modul Ref
	 if($isi['modulref']==0){
	 	$isi['modulref']='Disable';
	 }elseif($isi['modulref']==1){
	 	$isi['modulref']='Write';
	 }else{
	 	$isi['modulref']='Read';
	 }
	 //Modul Adm
	 if($isi['moduladm']==0){
	 	$isi['moduladm']='Disable';
	 }elseif($isi['moduladm']==1){
	 	$isi['moduladm']='Write';
	 }else{
	 	$isi['moduladm']='Read';
	 }
	 
	 //Status
	 if($isi['status']==1){
	 	$isi['status']='Aktif';
	 }else{
	 	$isi['status']='Disable';
	 }
	 
	  
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	 if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$isi['uid'].'/<br>'.$isi['nama']);
	// $Koloms[] = array('align="left"',$isi['nama']);	 
	 $Koloms[] = array('align="left"',$isi['level'].'/<br>'.$isi['group']);
	// $Koloms[] = array('align="center"',$isi['group']);
	  $Koloms[] = array('align="center"',$isi['status']);
	 $Koloms[] = array('align="center"',$isi['modul01']);
	 $Koloms[] = array('align="center"',$isi['modul02']);
	 $Koloms[] = array('align="center"',$isi['modul03']);
	 $Koloms[] = array('align="center"',$isi['modul04']);
	 $Koloms[] = array('align="center"',$isi['modul05']);
	 $Koloms[] = array('align="center"',$isi['modul06']);
	 $Koloms[] = array('align="center"',$isi['modul07']);
	 $Koloms[] = array('align="center"',$isi['modul08']);
	 $Koloms[] = array('align="center"',$isi['modul09']);
	 $Koloms[] = array('align="center"',$isi['modul10']);
	 $Koloms[] = array('align="center"',$isi['modul11']);
	 $Koloms[] = array('align="center"',$isi['modul12']);
	 $Koloms[] = array('align="center"',$isi['modul13']);
	 $Koloms[] = array('align="center"',$isi['modul14']);
	 $Koloms[] = array('align="center"',$isi['modul15']);
	 $Koloms[] = array('align="center"',$isi['modul16']);
	 $Koloms[] = array('align="center"',$isi['modulref']);
	 $Koloms[] = array('align="center"',$isi['moduladm']);
	
	 
	 return $Koloms;
	 
	}
	
	
	function genDaftarOpsi(){
		global $Ref, $Main;
		$fmFiltStatus2=$_REQUEST['fmFiltStatus2'];
		$fmFiltStatus3=$_REQUEST['fmFiltStatus3'];
		$arrStatus = array(
						array('selectUser','Username'),
			     		array('selectNama','Nama Pegawai'),
				);
		
		$arrStatus2 = array(
					array('1','Admin'),
					array('2','Operator'),
				);
				
		$arrStatus3 = array(
					array('1','Aktif'),
					array('2','Tidak Aktif'),
				);		
		
		
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		
		//tgl bulan dan tahun
		$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');	
		$uid = $_REQUEST['uid'];
		$nama = $_REQUEST['nama'];
		
		
			
		$TampilOpt =
			"<table width=\"100%\" class=\"adminform\">	<tr>		
			<td width=\"100%\" valign=\"top\">" . 
				WilSKPD_ajx3($this->Prefix.'Skpd') . 
			"</td>
			</tr>"."
			<tr><td></table>"."	
			<!--		
			<div class='FilterBar'>
			<table style='width:100%'><tbody><tr><td align='left'>
			<table cellspacing='0' cellpadding='0' border='0' style='height:28'>
			<tbody><tr valign='middle'>-->   						
				<!--<td align='left' style='padding:1 8 0 8; '>".
			"</td>-->				
			</tr>
			</tbody></table>
			</td></tr></tbody></table>
		    </div>".
			
			
			genFilterBar(
			array(
				"Level : "
				.cmbArray('fmFiltStatus2',$fmFiltStatus2,$arrStatus2,'-- Level --',''). //generate checkbox					
				"&nbsp&nbsp&nbsp&nbsp"
				
				.cmbArray('fmPILCARI',$fmPILCARI,$arrStatus,'-- Cari Data --',''). //generate checkbox					
				"&nbsp&nbsp<input type='text' value='".$fmPILCARIvalue."' name='fmPILCARIvalue' id='fmPILCARIvalue'>&nbsp&nbsp".
				"Status : "
				.cmbArray('fmFiltStatus3',$fmFiltStatus3,$arrStatus3,'--Status--','').
				""
					),
					$this->Prefix.".refreshList(true)"
					);
			"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>";
			
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		$urusan = $Main->URUSAN;
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		$fmLimit = $_REQUEST['baris'];
		$this->pagePerHal=$fmLimit;
		
		$c1 = $_REQUEST['UserManajemenSkpdfmURUSAN'];
		$c = $_REQUEST['UserManajemenSkpdfmSKPD'];
		$d = $_REQUEST['UserManajemenSkpdfmUNIT'];
		$e = $_REQUEST['UserManajemenSkpdfmSUBUNIT'];
		$e1 = $_REQUEST['UserManajemenSkpdfmSEKSI'];
		
		$c1 = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST($this->Prefix.'SkpdfmURUSAN');
		$c = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST($this->Prefix.'SkpdfmSKPD');
		$d = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST($this->Prefix.'SkpdfmUNIT');
		$e = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST($this->Prefix.'SkpdfmSUBUNIT');	
		$e1 = isset($HTTP_COOKIE_VARS['cofmSEKSI'])? $HTTP_COOKIE_VARS['cofmSEKSI']: cekPOST($this->Prefix.'SkpdfmSEKSI');			
		if($urusan==0){
			if($c =='00'){
			$kode = '';
			}
			elseif($c != '00' && $d =='00' && $e=='00' && $e1=='000'){
				$kode = $c.'%';
			}
			elseif($c != '00' && $d !='00' && $e=='00' && $e1=='000'){
				$kode = $c.'.'.$d.'%';
			}
			elseif($c != '00' && $d !='00' && $e != '00' && $e1=='000'){
				$kode = $c.'.'.$d.'.'.$e.'.%';
			}
			elseif($c != '00' && $d !='00' && $e != '00' && $e1 != '000'){
				$kode = $c.'.'.$d.'.'.$e.'.'.$e1;
			}
			
			$fmPILCARI = $_REQUEST['fmPILCARI'];
			//Cari 
			
			switch($fmPILCARI){			
				case 'selectUser': $arrKondisi[] = " uid like  '$fmPILCARIvalue%'"; break;
				case 'selectNama': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;					 	
			}
			
			switch($_REQUEST['fmFiltStatus2']){
				case '1': $fmFiltStatus2='(level =1)'; break;
				case '2': $fmFiltStatus2='(level =2)'; break;
				
			}
			
			switch($_REQUEST['fmFiltStatus3']){
				case '1': $fmFiltStatus3='(status =1)'; break;
				case '2': $fmFiltStatus3='(status =0)'; break;
				
			}
			
		}else{
			if($c1 =='0'){
				$kode = '';
			}
			if($c1!='0' && $c =='00' && $d=='00' && $e=='00' && $e1=='000'){
				$kode = $c1.'%';
			}
			if($c1!='0' && $c !='00' && $d=='00' && $e=='00' && $e1=='000'){
				$kode = $c1.'.'.$c.'%';
			}
			elseif($c1!='0' && $c !='00' && $d!='00' && $e=='00' && $e1=='000'){
				$kode = $c1.'.'.$c.'.'.$d.'.%';
			}
			elseif($c1!='0' && $c !='00' && $d!='00' && $e!='00' && $e1=='000'){
				$kode = $c1.'.'.$c.'.'.$d.'.'.$e.'.%';
			}
			elseif($c1!='0' && $c !='00' && $d!='00' && $e!='00' && $e1!='000'){
				$kode = $c1.'.'.$c.'.'.$d.'.'.$e.'.'.$e1;
			}
			
			$fmPILCARI = $_REQUEST['fmPILCARI'];
			//Cari 
			
			switch($fmPILCARI){			
				case 'selectUser': $arrKondisi[] = " uid like  '$fmPILCARIvalue%'"; break;
				case 'selectNama': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;					 	
			}
			
			switch($_REQUEST['fmFiltStatus2']){
				case '1': $fmFiltStatus2='(level =1)'; break;
				case '2': $fmFiltStatus2='(level =2)'; break;
				
			}
			
			switch($_REQUEST['fmFiltStatus3']){
				case '1': $fmFiltStatus3='(status =1)'; break;
				case '2': $fmFiltStatus3='(status =0)'; break;
				
			}	
		}
		
		if(!empty($_REQUEST['fmFiltStatus2'])) $arrKondisi[]= "$fmFiltStatus2";
		if(!empty($_REQUEST['fmFiltStatus3'])) $arrKondisi[]= "$fmFiltStatus3";
		if(!empty($kode)) $arrKondisi[]= " `group` like '$kode'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
			
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
			switch($fmORDER1){
				case '1': $arrOrders[] = " uid $Asc1 " ;break;
				case '2': $arrOrders[] = " nama $Asc1 " ;break;	
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
$UserManajemen = new UserManajemenObj();
?>