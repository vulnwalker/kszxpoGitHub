<?php

class PegawaiObj  extends DaftarObj2{	
	var $Prefix = 'Pegawai';
	var $elCurrPage="HalDefault";
	var $TblName = 'ref_pegawai'; //daftar
	var $TblName_Hapus = 'ref_pegawai';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');//('p','q'); //daftar/hapus
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Data';
	var $PageIcon = 'images/masterdata_ico.gif';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pegawai.xls';
	var $Cetak_Judul = 'DAFTAR PEGAWAI';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	
	
	function setTitle(){
		return 'Daftar Pegawai';
	}
	function setCetak_Header(){
		global $Main, $HTTP_COOKIE_VARS;
		
		$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD');// echo 'fmskpd='.$fmSKPD;
		$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		$fmSEKSI = cekPOST($this->Prefix.'SkpdfmSEKSI');
		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\"><DIV ALIGN=CENTER>$this->Cetak_Judul</td>
			</tr>
			</table>	
			<table width=\"100%\" border=\"0\">
				<tr>
					<td class=\"subjudulcetak\">".PrintSKPD2($fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI)."</td>
				</tr>
			</table><br>";
	}
	//function setPage_IconPage(){		return 'images/masterData_ico.gif';	}	
	function simpan(){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$var_urusan = $Main->URUSAN;				
				$fmST = $_REQUEST[$this->Prefix.'_fmST'];
				$idplh = $_REQUEST[$this->Prefix.'_idplh'];
				$a = $Main->Provinsi[0];
				$b = $Main->DEF_WILAYAH;
				$c1 = $_REQUEST['c1'];
				$c = $_REQUEST['c'];
				$d = $_REQUEST['d'];
				$e = $_REQUEST['e'];
				$e1 = $_REQUEST['e1'];
				
				$nip= $_REQUEST['nip'];
				$nama= $_REQUEST['nama'];
				$jabatan= $_REQUEST['jabatan'];
				
				if( $err=='' && $nip =='' ) $err= 'NIP belum diisi!';
				if( $err=='' && $nama =='' ) $err= 'Nama belum diisi!';
				if( $err=='' && $jabatan =='' ) $err= 'Jabatan belum diisi!';
				
				if($fmST == 0){
					//cek 
					if( $err=='' ){
						$get = mysql_fetch_array(mysql_query(
							"select count(*) as cnt from ref_pegawai where nip='$nip' "
						));
						if($get['cnt']>0 ) $err='NIP Sudah Ada!';
					}
					if($err==''){
					if($var_urusan==0){
						$aqry = "insert into ref_pegawai (a,b,c,d,e,e1,nip,nama,jabatan)"."values('$a','$b','$c','$d','$e','$e1','$nip','$nama','$jabatan')";	$cek .= $aqry;	
						$qry = mysql_query($aqry);
					}else{
						$aqry = "insert into ref_pegawai (a,b,c1,c,d,e,e1,nip,nama,jabatan)"."values('$a','$b','$c1','$c','$d','$e','$e1','$nip','$nama','$jabatan')";	$cek .= $aqry;	
						$qry = mysql_query($aqry);
					}
					
					}
					
				}else{
					$old = mysql_fetch_array(mysql_query("select * from ref_pegawai where Id='$idplh'"));
					if( $err=='' ){
						if($nip!=$old['nip'] ){
							$get = mysql_fetch_array(mysql_query(
								"select count(*) as cnt from ref_pegawai where nip='$nip' "
							));
							if($get['cnt']>0 ) $err='NIP Sudah Ada!';
						}
					}
					if($err==''){
						
						if($var_urusan==0){
							$aqry = "update ref_pegawai set ".
							" a='$a', b='$b', c='$c',d='$d',e='$e',e1='$e1',
							nip='$nip',nama='$nama', jabatan='$jabatan'".
							"where id='".$idplh."'";	$cek .= $aqry;
						$qry = mysql_query($aqry);
						}else{
							$aqry = "update ref_pegawai set ".
							"a='$a', b='$b', c1='$c1',c='$c',d='$d',e='$e',e1='$e1',
							nip='$nip',nama='$nama', jabatan='$jabatan'".
							"where id='".$idplh."'";	$cek .= $aqry;
						$qry = mysql_query($aqry);
						}
						
					}
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
			case 'cbxgedung':{
				$c= $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
				$d= $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
				$e= $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
				$e1= $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
				if($c=='' || $c =='00') {
					$kondC='';
				}else{
					$kondC = "and c = '$c'";
				}
				if($d=='' || $d =='00') {
					$kondD='';
				}else{
					$kondD = "and d = '$d'";
				}
				if($e=='' || $e =='00') {
					$kondE='';
				}else{
					$kondE = "and e = '$e'";
				}
				if($e1=='' || $e1 =='00' || $e1 =='000') {
					$kondE1='';
				}else{
					$kondE1 = "and e1 = '$e1'";
				}

				$aqry = "select * from ref_ruang where q='0000' $kondC $kondD $kondE $kondE1";
				$cek .= $aqry;
				$content = genComboBoxQry( 'fmPILGEDUNG', $fmPILGEDUNG, 
						$aqry,
						'p', 'nm_ruang', '-- Semua Gedung --',"style='width:140'" );
				break;
			}		
			case 'formBaru':{				
				$fm = $this->setFormBaru();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
				break;
			}case 'formBaruMaster':{				
				$fm = $this->setFormBaruMaster();				
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
			
			case 'hapus':{	
				$fm= $this->Hapus($pil);
				$err= $fm['err']; 
				$cek = $fm['cek'];
				$content = $fm['content'];
				break;
			}
			
			case 'getdata':{
				$id = $_REQUEST['id'];
				$aqry = "select * from ref_pegawai where id='$id' "; $cek .= $aqry;
				$get = mysql_fetch_array( mysql_query($aqry));
				if($get==FALSE) $err= "Gagal ambil data!"; 
				$content = array('nip'=>$get['nip'],'nama'=>$get['nama'],'jabatan'=>$get['jabatan']);
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
			/*default:{
				$err = 'tipe tidak ada!';
				break;
			}*/
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	//form ==================================
	
	
	function Hapus($ids){ 
	global $Main, $HTTP_COOKIE_VARS;	
		
		$urusan = $Main->URUSAN;
		$err=''; $cek='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		
		
		$c1 = $_REQUEST['c1'];
		$c = $_REQUEST['c'];
		$d = $_REQUEST['d'];
		$e = $_REQUEST['e'];
		$e1 = $_REQUEST['e1'];
		
		if ($c1==''){
		$c1 = $_REQUEST['PegawaiSkpdfmURUSAN'];
		$c = $_REQUEST['PegawaiSkpdfmSKPD'];
		$d = $_REQUEST['PegawaiSkpdfmUNIT'];
		$e = $_REQUEST['PegawaiSkpdfmSUBUNIT'];
		$e1 = $_REQUEST['PegawaiSkpdfmSEKSI'];
		}
		
		$master = $_REQUEST['master'];
		
		
		$co_c1=$HTTP_COOKIE_VARS['coURUSAN'];
		$co_c=$HTTP_COOKIE_VARS['coSKPD'];
		$co_d=$HTTP_COOKIE_VARS['coUNIT'];
		$co_e=$HTTP_COOKIE_VARS['coSUBUNIT'];
		$co_e1=$HTTP_COOKIE_VARS['coSEKSI'];
		
		if ($err ==''){
		for($i = 0; $i<count($ids); $i++){	
		
		if($urusan==0){
		
				if ($master==0){
					if($err=='' ){
						$qy = "DELETE FROM ref_pegawai WHERE Id='".$ids[$i]."' ";$cek.=$qy;
						$qry = mysql_query($qy);
						
					}else{
					break;
					}	
				}else{
						
			//	$c1 = $_REQUEST['c1'];
				$c = $_REQUEST['c'];
				$d = $_REQUEST['d'];
				$e = $_REQUEST['e'];
				$e1 = $_REQUEST['e1'];
				
				if ($c==''){
			//	$c1 = $_REQUEST['PegawaiSkpdfmURUSAN'];
				$c = $_REQUEST['PegawaiSkpdfmSKPD'];
				$d = $_REQUEST['PegawaiSkpdfmUNIT'];
				$e = $_REQUEST['PegawaiSkpdfmSUBUNIT'];
				$e1 = $_REQUEST['PegawaiSkpdfmSEKSI'];
				}
				
				
					if($co_c == 00 && $co_d == 00 && $co_e==00 && $co_e1==000){
						
					if($err=='' ){
						$qy = "DELETE FROM ref_pegawai WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
						$qry = mysql_query($qy);		
						}else{
							break;
						}			
					}elseif($co_c ==$c && $co_d!=$d && $co_e!=$e && $co_e1!=$e1){
					
					if($err=='' ){
						$qy = "DELETE FROM ref_pegawai WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
						$qry = mysql_query($qy);		
						}else{
							break;
						}
					
					}elseif($co_c ==$c && $co_d==$d && $co_e!=$e && $co_e1!=$e1){
					
					if($err=='' ){
						$qy = "DELETE FROM ref_pegawai WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
						$qry = mysql_query($qy);		
						}else{
							break;
						}
					
					}elseif($co_c ==$c && $co_d==$d && $co_e==$e && $co_e1!=$e1){
					
					if($err=='' ){
						$qy = "DELETE FROM ref_pegawai WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
						$qry = mysql_query($qy);		
						}else{
							break;
						}
					
					}elseif($co_c ==$c && $co_d==$d && $co_e==$e && $co_e1==$e1){
					
					if($err=='' ){
						$qy = "DELETE FROM ref_pegawai WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
						$qry = mysql_query($qy);		
						}else{
							break;
						}
					
					}else{
						$err="Data Tidak Bisa di Hapus Hak Akses SKPD '".$co_c.'.'.$c."'!!";	
						
						
					}	
					}
		
		//=/	
		}else{
		
		
				if ($master==0){
			if($err=='' ){
					$qy = "DELETE FROM ref_pegawai WHERE Id='".$ids[$i]."' ";$cek.=$qy;
					$qry = mysql_query($qy);
						
			}else{
				break;
			}	
		}else{
		if($co_c1 == 0 && $co_c == 00 && $co_d == 00 && $co_e==00 && $co_e1==000){
			
		if($err=='' ){
			$qy = "DELETE FROM ref_pegawai WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}			
		}elseif($co_c1 ==$c1 && $co_c !=$c && $co_d!=$d && $co_e!=$e && $co_e1!=$e1){
		
		if($err=='' ){
			$qy = "DELETE FROM ref_pegawai WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		
		}elseif($co_c1 ==$c1 && $co_c ==$c && $co_d!=$d && $co_e!=$e && $co_e1!=$e1){
		
		if($err=='' ){
			$qy = "DELETE FROM ref_pegawai WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		
		}elseif($co_c1 ==$c1 && $co_c ==$c && $co_d==$d && $co_e!=$e && $co_e1!=$e1){
		
		if($err=='' ){
			$qy = "DELETE FROM ref_pegawai WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		
		}elseif($co_c1 ==$c1 && $co_c ==$c && $co_d==$d && $co_e==$e && $co_e1!=$e1){
		
		if($err=='' ){
			$qy = "DELETE FROM ref_pegawai WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		
		}elseif($co_c1 ==$c1 && $co_c !=$c && $co_d==$d && $co_e==$e && $co_e1==$e1){
		
		if($err=='' ){
			$qy = "DELETE FROM ref_pegawai WHERE Id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		
		}else{
			$err="Data Tidak Bisa di Hapus Hak Akses SKPD !!";	
			
			
		}	
		}	
		}
		
		
		
		
		}//for
		}
		return array('err'=>$err,'cek'=>$cek);
	}	
	
	function setFormBaruMaster(){
	global $Main;
		$dat_p19=$Main->PENERIMAAN_P19;
		
		
		
		$dt=array();
		$dt['c1'] = $_REQUEST[$this->Prefix.'SkpdfmURUSAN'];
		$dt['c'] = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$dt['d'] = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$dt['e'] = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$dt['e1'] = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
		
		$dt['p'] = '';
		$dt['q'] = '';
	
		$fm = $this->setForm($dt);		
		
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	
	
	function setFormBaru(){
	global $Main;
		$dat_p19=$Main->PENERIMAAN_P19;
		$master= $_REQUEST['master'];
		
		$dt=array();
		$dt['c1'] = $_REQUEST['fmURUSAN'];
		$dt['c'] = $_REQUEST['fmSKPD'];
		$dt['d'] = $_REQUEST['fmUNIT'];
		$dt['e'] = $_REQUEST['fmSUBUNIT'];
		$dt['e1'] = $_REQUEST['fmSUBSEKSI'];
		
		$dt['p'] = '';
		$dt['q'] = '';

		$fm = $this->setFormPil($dt);		
		
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	function setFormEdit(){
	global $Main, $HTTP_COOKIE_VARS;
		$urusan = $Main->URUSAN;
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		
		$c1 = $_REQUEST[$this->Prefix.'SkpdfmURUSAN'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$e1 = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
		
		$co_c1=$HTTP_COOKIE_VARS['coURUSAN'];
		$co_c=$HTTP_COOKIE_VARS['coSKPD'];
		$co_d=$HTTP_COOKIE_VARS['coUNIT'];
		$co_e=$HTTP_COOKIE_VARS['coSUBUNIT'];
		$co_e1=$HTTP_COOKIE_VARS['coSEKSI'];
				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		
		$aqry = "select * from ref_pegawai where id ='".$this->form_idplh."'  "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		if($urusan==0){
			if($co_c1 == 0 && $co_c == 00 && $co_d == 00 && $co_e==00 && $co_e1==000){
			//Admin
				$fm = $this->setForm($dt);	
			
			}elseif($co_c==$dt['c'] && $co_d!=$dt['d'] && $co_e!=$dt['e'] && $co_e1!=$dt['e1']){
			// skpd
				$fm = $this->setForm($dt);
					
			}elseif($co_c==$dt['c'] && $co_d==$dt['d'] && $co_e!=$dt['e'] && $co_e1!=$dt['e1']){
				//unit
				$fm = $this->setForm($dt);
			
			}elseif($co_c==$dt['c'] && $co_d==$dt['d'] && $co_e==$dt['e'] && $co_e1!=$dt['e1']){
			//subunit
				$fm = $this->setForm($dt);
			
			}elseif($co_c==$dt['c'] && $co_d==$dt['d'] && $co_e==$dt['e'] && $co_e1==$dt['e1']){
			//seksi
				$fm = $this->setForm($dt);
				
			}else{
				$fm['err']="Data Tidak Bisa di Edit Berdasar Hak Akses SKPD !!";
			}
		}else{
			if($co_c1 == 0 && $co_c == 00 && $co_d == 00 && $co_e==00 && $co_e1==000){
			//Admin
				$fm = $this->setForm($dt);	
			
			}elseif($co_c1==$dt['c1'] && $co_c!=$dt['c'] && $co_d!=$dt['d'] && $co_e!=$dt['e'] && $co_e1!=$dt['e1']){
			// Urusan
				$fm = $this->setForm($dt);
					
			}elseif($co_c1==$dt['c1'] && $co_c==$dt['c'] && $co_d!=$dt['d'] && $co_e!=$dt['e'] && $co_e1!=$dt['e1']){
				//Bidang
				$fm = $this->setForm($dt);
			
			}elseif($co_c1==$dt['c1'] && $co_c==$dt['c'] && $co_d==$dt['d'] && $co_e!=$dt['e'] && $co_e1!=$dt['e1']){
			//Skpd
				$fm = $this->setForm($dt);
			
			}elseif($co_c1==$dt['c1'] && $co_c==$dt['c'] && $co_d==$dt['d'] && $co_e==$dt['e'] && $co_e1!=$dt['e1']){
			//Unit
				$fm = $this->setForm($dt);
				
			}elseif($co_c1==$dt['c1'] && $co_c==$dt['c'] && $co_d==$dt['d'] && $co_e==$dt['e'] && $co_e1==$dt['e1']){
			//Seksi
				$fm = $this->setForm($dt);
			
			}else{
				$fm['err']="Data Tidak Bisa di Edit Berdasar Hak Akses SKPD!!";
			}
		}
		
		//set form
	//	$fm = $this->setForm($dt);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormPil($dt){	
		global $SensusTmp,$Main;
		$cek = ''; $err=''; $content=''; 
		
		$json = TRUE;	//$ErrMsg = 'tes';
		
		$dat_c1=$Main->PENERIMAAN_P19;	
		$var_urusan = $Main->URUSAN;
		
		$form_name = $this->Prefix.'_form';				
		$this->form_width = 500;
		$this->form_height = 180;
		if ($this->form_fmST==0) {
			$this->form_caption = 'Baru';
			$nip	 = '';
		}else{
			$this->form_caption = 'Edit';			
			$nip = $dt['nip'];			
		}
			$kdSubUnit0 = genNumber(0, $Main->SUBUNIT_DIGIT );
		//items ----------------------
		
		$get1=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='00'"));
		
		$vls_urusan = $get1['c1'].'.'.$get1['nm_skpd'];
		
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='00' "));
		$get2=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='00' "));
		$bidang = $get['c'].'.'.$get['nm_skpd'];
		$bidang2 = $get2['c'].'.'.$get2['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='00' "));
		$get2=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='00' "));
		$unit = $get['d'].'.'.$get['nm_skpd'];
		$unit2 = $get2['d'].'.'.$get2['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'  and e1='000'"));
		$get2=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'  and e1='000'"));
	//	$cek.="select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'  and e1='000'";
		$subunit = $get['e'].'.'.$get['nm_skpd'];		
		$subunit2 = $get2['e'].'.'.$get2['nm_skpd'];		

		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'  and e1='".$dt['e1']."'"));
		$get2=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'  and e1='".$dt['e1']."'"));
		$seksi = $get['e1'].'.'.$get['nm_skpd'];		
		$seksi2 = $get2['e1'].'.'.$get2['nm_skpd'];		
		
		if ($var_urusan==1){
			$dat_urusan= array('label'=>'URUSAN', 'value'=> $vls_urusan, 'labelWidth'=>120, 'type'=>'' );
			$dat_bidang= array('label'=>'BIDANG', 'value'=> $bidang, 'labelWidth'=>120, 'type'=>'' );
			$dat_skpd= array('label'=>'SKPD', 'value'=> $unit, 'labelWidth'=>120, 'type'=>'' );
			$dat_unit= array('label'=>'UNIT', 'value'=> $subunit, 'labelWidth'=>120, 'type'=>'' );
			$dat_seksi= array('label'=>'SUB UNIT', 'value'=> $seksi, 'labelWidth'=>120, 'type'=>'' );
		}else{
			$dat_urusan=array('pemisah'=>' ');
			$dat_bidang= array('label'=>'BIDANG', 'value'=> $bidang2, 'labelWidth'=>120, 'type'=>'' );
			$dat_skpd= array('label'=>'SKPD', 'value'=> $unit2, 'labelWidth'=>120, 'type'=>'' );
			$dat_unit= array('label'=>'UNIT', 'value'=> $subunit2, 'labelWidth'=>120, 'type'=>'' );
			$dat_seksi= array('label'=>'SUB UNIT', 'value'=> $seksi2, 'labelWidth'=>120, 'type'=>'' );
		}
		
		$this->form_fields = array(				
			$dat_urusan,
			$dat_bidang,
			$dat_skpd,
			$dat_unit,
			$dat_seksi,
			'nip' => array( 'label'=>'NIP', 'value'=> $nip, 'labelWidth'=>120, 'type'=>'text' ),
			'nama' => array( 'label'=>'Nama Pegawai', 'value'=>$dt['nama'], 'type'=>'text'  ),	
			'jabatan' => array( 'label'=>'Jabatan', 'value'=>$dt['jabatan'], 'type'=>'text')	
		);
		
				
		//tombol
		$this->form_menubawah =
			"<input type=hidden id='c1' name='c1' value='".$dt['c1']."'> ".
			"<input type=hidden id='c' name='c' value='".$dt['c']."'> ".
			"<input type=hidden id='d' name='d' value='".$dt['d']."'> ".
			"<input type=hidden id='e' name='e' value='".$dt['e']."'> ".
			"<input type=hidden id='e1' name='e1' value='".$dt['e1']."'> ".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		
		
		$form = $this->genForm();		
				
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
		
	function setForm($dt){	
		global $SensusTmp,$Main;
		$cek = ''; $err=''; $content=''; 
		
		$json = TRUE;	//$ErrMsg = 'tes';
		
		$dat_c1=$Main->PENERIMAAN_P19;	
		$var_urusan = $Main->URUSAN;
		
		$form_name = $this->Prefix.'_form';				
		$this->form_width = 500;
		$this->form_height = 180;
		if ($this->form_fmST==0) {
			$this->form_caption = 'Baru';
			$nip	 = '';
		}else{
			$this->form_caption = 'Edit';			
			$nip = $dt['nip'];			
		}
			$kdSubUnit0 = genNumber(0, $Main->SUBUNIT_DIGIT );
		//items ----------------------
		//$sesi = gen_table_session('sensus','uid');
		//style='width: 318px;text-transform: uppercase;'
		$get1=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='00'"));
		$vls_urusan = $get1['c1'].'.'.$get1['nm_skpd'];
		
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='00' "));
		$get2=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='00' "));
		
		$bidang = $get['c'].'.'.$get['nm_skpd'];
		$bidang2 = $get2['c'].'.'.$get2['nm_skpd'];
		
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='00' "));
		$get2=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='00' "));
		$unit = $get['d'].'.'.$get['nm_skpd'];
		$unit2 = $get2['d'].'.'.$get2['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'  and e1='$kdSubUnit0'  "));
		$get2=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'  and e1='$kdSubUnit0'  "));
		$subunit = $get['e'].'.'.$get['nm_skpd'];		
		$subunit2 = $get2['e'].'.'.$get2['nm_skpd'];		

		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'  and e1='".$dt['e1']."'"));
		$get2=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."'  and e1='".$dt['e1']."'"));
		$seksi = $get['e1'].'.'.$get['nm_skpd'];		
		$seksi2 = $get2['e1'].'.'.$get2['nm_skpd'];		
		
		if ($var_urusan==1){
			$dat_urusan= array('label'=>'URUSAN', 'value'=> $vls_urusan, 'labelWidth'=>100, 'type'=>'' );
			$dat_bidang= array('label'=>'BIDANG', 'value'=> $bidang, 'labelWidth'=>120, 'type'=>'' );
			$dat_unit= array('label'=>'SKPD', 'value'=> $unit, 'labelWidth'=>120, 'type'=>'' );
			$dat_subunit= array('label'=>'UNIT', 'value'=> $subunit, 'labelWidth'=>120, 'type'=>'' );
			$dat_seksi= array('label'=>'SUB UNIT', 'value'=> $seksi, 'labelWidth'=>120, 'type'=>'' );
		}else{
			$dat_urusan=array('pemisah'=>' ');
			$dat_bidang= array('label'=>'BIDANG', 'value'=> $bidang2, 'labelWidth'=>120, 'type'=>'' );
			$dat_unit= array('label'=>'SKPD', 'value'=> $unit2, 'labelWidth'=>120, 'type'=>'' );
			$dat_subunit= array('label'=>'UNIT', 'value'=> $subunit2, 'labelWidth'=>120, 'type'=>'' );
			$dat_seksi= array('label'=>'SUB UNIT', 'value'=> $seksi2, 'labelWidth'=>120, 'type'=>'' );
		}
		
		$this->form_fields = array(				
			$dat_urusan,
		//	'urusan' => array(  'label'=>'URUSAN', 'value'=> $vls_urusan, 'labelWidth'=>120, 'type'=>'' ),
			$dat_bidang,
		//	'bidang' => array(  'label'=>'BIDANG', 'value'=> $bidang, 'labelWidth'=>120, 'type'=>'' ),
			$dat_unit,
		//	'unit' => array(  'label'=>'SKPD', 'value'=> $unit, 'labelWidth'=>120, 'type'=>'' ),
			$dat_subunit,
		//	'subunit' => array(  'label'=>'UNIT', 'value'=> $subunit, 'labelWidth'=>120, 'type'=>'' ),
			$dat_seksi,
		//	'seksi' => array(  'label'=>'SUB UNIT', 'value'=> $seksi, 'labelWidth'=>120, 'type'=>'' ),
			'nip' => array( 'label'=>'NIP', 'value'=> $nip, 'labelWidth'=>120, 'type'=>'text' ),
			'nama' => array( 'label'=>'Nama Pegawai', 'value'=>$dt['nama'], 'type'=>'text'  ),	
			'jabatan' => array( 'label'=>'Jabatan', 'value'=>$dt['jabatan'], 'type'=>'text')	
		);
		
				
		//tombol
		$this->form_menubawah =
			"<input type=hidden id='c1' name='c1' value='".$dt['c1']."'> ".
			"<input type=hidden id='c' name='c' value='".$dt['c']."'> ".
			"<input type=hidden id='d' name='d' value='".$dt['d']."'> ".
			"<input type=hidden id='e' name='e' value='".$dt['e']."'> ".
			"<input type=hidden id='e1' name='e1' value='".$dt['e1']."'> ".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' >".
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
				
				<th class='th01' width='40'>No.</th>
				$Checkbox		
				<th class='th01' width=150>NIP</th>
				<th class='th01' >NAMA </th>
				<th class='th01' >JABATAN </th>								
				
				</tr>
				
			</thead>";
		return $headerTable;
	}
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref;
		$Koloms = array();
		$Koloms[] = array('align=right', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array('', $isi['nip']);		
		$Koloms[] = array('', $isi['nama'] );
		$Koloms[] = array('', $isi['jabatan']);				
		return $Koloms;
	}
	function genDaftarOpsi(){
	global $Ref, $Main;
	 
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	 $arrOrder = array(
	  	         array('1','Nip'),
			     array('2','Nama'),
					);
	$arr = array(
			//array('selectAll','Semua'),	
			array('selectNip','Nip'),	
			array('selectNama','Nama'),		
			);
	$TampilOpt =
			//<table width=\"100%\" class=\"adminform\">
			"<table width=\"100%\" class=\"adminform\">	<tr>		
			<td width=\"100%\" valign=\"top\">" . 
				WilSKPD_ajx3($this->Prefix.'Skpd') . 
			"</td>
			<td >" . 		
			"</td></tr>
			<!--<tr><td>
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>			-->
			</table>".
			"<tr><td>".
			"<div id='skpd_pegawai' ></div>".
			$vOrder=			
			genFilterBar(
				array(							
					cmbArray('fmPILCARI',$fmPILCARI,$arr,'-- Cari Data --',''). //generate checkbox					
					"&nbsp&nbsp<input type='text' value='".$fmPILCARIvalue."' name='fmPILCARIvalue' id='fmPILCARIvalue'>&nbsp&nbsp"
					//<input type='button' id='btTampil' value='Cari' onclick='".$this->Prefix.".refreshList(true)'>"
					
					.cmbArray('fmORDER1',$fmORDER1,$arrOrder,'--Urutkan--','').
					"<input $fmDESC1 type='checkbox' id='fmDESC1' name='fmDESC1' value='checked'>&nbspmenurun.
					<input type='hidden'  name='dat_urusan' id='dat_urusan' value='".$Main->URUSAN."' >
					<input type='hidden'  name='master' id='master' value='0' >"
					),			
				$this->Prefix.".refreshList(true)");
			"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>";
			
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
	global $Main, $HTTP_COOKIE_VARS;
	
		$cek='';
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$urusan = $Main->URUSAN;
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		
		$c1 = $_REQUEST['PegawaiPilihSkpdfmURUSAN'];
		
		if ($urusan=='0'){
		//------level 4
		$arrKondisi = array();
			$arrKondisi[] = getKondisiSKPD2( 
			
			$Main->DEF_KEPEMILIKAN, 
			$Main->Provinsi[0], 
			$Main->DEF_WILAYAH,
			cekPOST($this->Prefix.'SkpdfmSKPD'), 
			cekPOST($this->Prefix.'SkpdfmUNIT'), 
			cekPOST($this->Prefix.'SkpdfmSUBUNIT'),
			cekPOST($this->Prefix.'SkpdfmSEKSI'),
			cekPOST($this->Prefix.'SkpdfmURUSAN')
			
			);
			
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			case 'selectNip': $arrKondisi[] = " nip like '$fmPILCARIvalue%'"; break;
			case 'selectNama': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;	
		}				
			
		}else{
		
		$arrKondisi = array();
			$arrKondisi[] = getKondisiSKPD2( 
			
			$Main->DEF_KEPEMILIKAN, 
			$Main->Provinsi[0], 
			$Main->DEF_WILAYAH,
			cekPOST($this->Prefix.'SkpdfmSKPD'), 
			cekPOST($this->Prefix.'SkpdfmUNIT'), 
			cekPOST($this->Prefix.'SkpdfmSUBUNIT'),
			cekPOST($this->Prefix.'SkpdfmSEKSI'),
			cekPOST($this->Prefix.'SkpdfmURUSAN'),
			1
		);	
		
		
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			case 'selectNip': $arrKondisi[] = " nip like '$fmPILCARIvalue%'"; break;
			case 'selectNama': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;	
		}			
			
		}
				
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		if ($urusan==0){
			switch($fmORDER1){
			case '1': $arrOrders[] = " a,b,c,d,e,e1,nip $Asc1 " ;break;
			case '2': $arrOrders[] = " nama $Asc1 " ;break;
			
		}	
		}else{
			switch($fmORDER1){
			case '1': $arrOrders[] = " a,b,c1,c,d,e,e1,nip $Asc1 " ;break;
			case '2': $arrOrders[] = " nama $Asc1 " ;break;
			
		}	
		}
		
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//limit --------------------------------------
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal, 'cek'=>$cek);
		
	}
	
}
$Pegawai = new PegawaiObj();


class PegawaiPilihObj  extends PegawaiObj{
	var $Prefix = 'PegawaiPilih';
	var $elCurrPage="HalDefault";
	var $TblName = 'ref_pegawai'; //daftar
	var $TblName_Hapus = 'ref_pegawai';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');//('p','q'); //daftar/hapus
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Data';
	var $PageIcon = 'images/masterdata_ico.gif';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pegawai.xls';
	var $Cetak_Judul = 'DAFTAR PEGAWAI';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	
	/*function setPage_TitleDaftar(){
		return 'Daftar Pegawai';
	}*/	
	//function setPage_TitlePage(){		return 'Referensi Data';			}
	function setTitle(){
		return 'Pilih Pegawai ';
	}
	
	function setMenuView(){
		return '';
	}	
	
	function setMenuEdit(){
	global $Pegawai;
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".BaruPil()","sections.png","Baru", 'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
	}	
	
	function genDaftarOpsi(){
	global $Ref, $Main;
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	 $arrOrder = array(
	  	         array('1','Nip'),
			     array('2','Nama'),
					);
	$arr = array(
			//array('selectAll','Semua'),	
			array('selectNip','Nip'),	
			array('selectNama','Nama'),		
			);
		
	
		$c1 = $_REQUEST['PegawaiPilihSkpdfmURUSAN'];
		$c = $_REQUEST['PegawaiPilihSkpdfmSKPD'];
		$d = $_REQUEST['PegawaiPilihSkpdfmUNIT'];
		$e = $_REQUEST['PegawaiPilihSkpdfmSUBUNIT'];
		$e1 = $_REQUEST['PegawaiPilihSkpdfmSEKSI'];
		$dafSKPD=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		if ($Main->URUSAN!='1'){
		if ($c==''){
			
			$c = $_REQUEST['fmSKPD'];
			$d = $_REQUEST['fmUNIT'];
			$e = $_REQUEST['fmSUBUNIT'];
			$e1 = $_REQUEST['fmSUBSEKSI'];
		}else{
			
			$c = $_REQUEST['PegawaiPilihSkpdfmSKPD'];
			$d = $_REQUEST['PegawaiPilihSkpdfmUNIT'];
			$e = $_REQUEST['PegawaiPilihSkpdfmSUBUNIT'];
			$e1 = $_REQUEST['PegawaiPilihSkpdfmSEKSI'];
		}
		
		
		
			$pil="<table width=\"100%\" class=\"adminform\">
			
			<tr>
			<td style='width:75px'>BIDANG</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery("fmSKPD",$c,"SELECT c,concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c!=00 and d=00 and e=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			<tr>
			<td style='width:50px'>SKPD</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery("fmUNIT",$d,"SELECT d,concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c='$c' and d!=00 and e=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			<tr>
			<td style='width:50px'>UNIT</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery("fmSUBUNIT",$e,"SELECT e,concat(e, '. ', nm_skpd) as vnama FROM ref_skpd where c='$c' and d='$d' and e!=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			<tr>
			<td style='width:50px'>SUB UNIT</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery("fmSUBSEKSI",$e1,"SELECT e1,concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c='$c' and d='$d' and e='$e' and e1!='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			</table>".
			genFilterBar(
			array(cmbArray('fmPILCARI',$fmPILCARI,$arr,'-- Cari Data --',''). //generate checkbox					
					"&nbsp&nbsp<input type='text' value='".$fmPILCARIvalue."' name='fmPILCARIvalue' id='fmPILCARIvalue'>&nbsp&nbsp"
					.cmbArray('fmORDER1',$fmORDER1,$arrOrder,'--Urutkan--','').
					"<input $fmDESC1 type='checkbox' id='fmDESC1' name='fmDESC1' value='checked'>&nbspmenurun
					<input type='hidden'  name='dat_urusan' id='dat_urusan' value='".$Main->URUSAN."' >
					<input type='hidden'  name='master' id='master' value='1' >
						<input type='hidden'  name='c' id='c' value='".$c."' >
						<input type='hidden'  name='d' id='d' value='".$d."' >
						<input type='hidden'  name='e' id='e' value='".$e."' >
						<input type='hidden'  name='e1' id='e1' value='".$e1."' >"
					),
					$this->Prefix.".refreshList(true)"
					);
			"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>";
			
			
		}else{
		
		
		
		if ($c1==''){
			$c1 = $_REQUEST['fmURUSAN'];
			$c = $_REQUEST['fmSKPD'];
			$d = $_REQUEST['fmUNIT'];
			$e = $_REQUEST['fmSUBUNIT'];
			$e1 = $_REQUEST['fmSUBSEKSI'];
		}else{
			$c1 = $_REQUEST['PegawaiPilihSkpdfmURUSAN'];
			$c = $_REQUEST['PegawaiPilihSkpdfmSKPD'];
			$d = $_REQUEST['PegawaiPilihSkpdfmUNIT'];
			$e = $_REQUEST['PegawaiPilihSkpdfmSUBUNIT'];
			$e1 = $_REQUEST['PegawaiPilihSkpdfmSEKSI'];
		}
		$cek.="SELECT e1,concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'";
	
			$pil="<table width=\"100%\" class=\"adminform\">
			<tr>		
			<td width=\"50%\" valign=\"top\">		
			 <table style='width:100%'>
			<tr>
			<td style='width:75px'>URUSAN</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery("fmURUSAN",$c1,"SELECT c1,concat(c1,'.',nm_skpd) as vnama FROM ref_skpd where c1!='0' and c=00 and d=00 and e=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			<tr>
			<td style='width:50px'>BIDANG</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery("fmSKPD",$c,"SELECT c,concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$c1' and c!=00 and d=00 and e=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			<tr>
			<td style='width:50px'>SKPD</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery("fmUNIT",$d,"SELECT d,concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$c1' and c='$c' and d!=00 and e=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			<tr>
			<td style='width:50px'>UNIT</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery("fmSUBUNIT",$e,"SELECT e,concat(e, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e!=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			<tr>
			<td style='width:50px'>SUB UNIT</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery("fmSUBSEKSI",$e1,"SELECT e1,concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1!='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			</table>".
			genFilterBar(
			array(
			cmbArray('fmPILCARI',$fmPILCARI,$arr,'-- Cari Data --',''). //generate checkbox					
					"&nbsp&nbsp<input type='text' value='".$fmPILCARIvalue."' name='fmPILCARIvalue' id='fmPILCARIvalue'>&nbsp&nbsp"
					.cmbArray('fmORDER1',$fmORDER1,$arrOrder,'--Urutkan--','').
					"<input $fmDESC1 type='checkbox' id='fmDESC1' name='fmDESC1' value='checked'>&nbspmenurun
					<input type='hidden'  name='dat_urusan' id='dat_urusan' value='".$Main->URUSAN."' >
					<input type='hidden'  name='master' id='master' value='1' >
					<input type='hidden'  name='c1' id='c1' value='".$c1."' >
					<input type='hidden'  name='c' id='c' value='".$c."' >
					<input type='hidden'  name='d' id='d' value='".$d."' >
					<input type='hidden'  name='e' id='e' value='".$e."' >
					<input type='hidden'  name='e1' id='e1' value='".$e1."' >"
					
				),
				$this->Prefix.".refreshList(true)");
			"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>";
	}
				
		$TampilOpt =$pil;
		return array('TampilOpt'=>$TampilOpt);
	}
	
	
				
	function getDaftarOpsi($Mode=1){
	global $Main, $HTTP_COOKIE_VARS;
	
		$cek='';
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$urusan = $Main->URUSAN;
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		
		$c1 = $_REQUEST['PegawaiPilihSkpdfmURUSAN'];
		
		if ($urusan!='1'){
		//------level 4
		
			
			$c = $_REQUEST['PegawaiPilihSkpdfmSKPD'];
			$d = $_REQUEST['PegawaiPilihSkpdfmUNIT'];
			$e = $_REQUEST['PegawaiPilihSkpdfmSUBUNIT'];
			$e1 = $_REQUEST['PegawaiPilihSkpdfmSEKSI'];
		
		if ($c==''){	
			$c = $_REQUEST['fmSKPD'];
			$d = $_REQUEST['fmUNIT'];
			$e = $_REQUEST['fmSUBUNIT'];
			$e1 = $_REQUEST['fmSUBSEKSI'];
		}
		
		
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			case 'selectNip': $arrKondisi[] = " nip like '$fmPILCARIvalue%'"; break;
			case 'selectNama': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;	
		}
		
		if(empty($c)) {
			$d='';
			$e='';
			$e1='';
		}
		
		if(empty($d)) {
			$e='';
			$e1='';
		}
		
		if(empty($e)) {
			$e1='';
		}
		
		if(empty($c) && empty($d) && empty($e)  && empty($e1))
		{
			$arrKondisi[]= "a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."'";
		}
		
		elseif(!empty($c) && empty($d) && empty($e) && empty($e1))
		{
			$arrKondisi[]= "a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c='$c'";		
		}
		
		elseif(!empty($c) && !empty($d) && empty($e) && empty($e1))
		{
			$arrKondisi[]= "a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c='$c' and d='$d'";		
		}
		
		elseif(!empty($c) && !empty($d) && !empty($e) && empty($e1))
		{
			$arrKondisi[]= "a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c='$c' and d='$d' and e='$e'";		
		}
		
		elseif(!empty($c) && !empty($d) && !empty($e) && !empty($e1))
		{
			$arrKondisi[]= "a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c='$c' and d='$d' and e='$e' and e1='$e1'";		
		}
		
	
		}else{
			
			if ($c1==''){
			$c1 = $_REQUEST['fmURUSAN'];
			$c = $_REQUEST['fmSKPD'];
			$d = $_REQUEST['fmUNIT'];
			$e = $_REQUEST['fmSUBUNIT'];
			$e1 = $_REQUEST['fmSUBSEKSI'];
		}else{
			$c1 = $_REQUEST['PegawaiPilihSkpdfmURUSAN'];
			$c = $_REQUEST['PegawaiPilihSkpdfmSKPD'];
			$d = $_REQUEST['PegawaiPilihSkpdfmUNIT'];
			$e = $_REQUEST['PegawaiPilihSkpdfmSUBUNIT'];
			$e1 = $_REQUEST['PegawaiPilihSkpdfmSEKSI'];
		}
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			case 'selectNip': $arrKondisi[] = " nip like '$fmPILCARIvalue%'"; break;
			case 'selectNama': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;	
		}			
		if(empty($c1)) {
			$c= '';
			$d='';
			$e='';
			$e1='';
		}
		
		if(empty($c)) {
			$d='';
			$e='';
			$e1='';
		}
		
		if(empty($d)) {
			$e='';
			$e1='';
		}
		
		if(empty($e)) {
			$e1='';
		}
		
		if(empty($c1) && empty($c) && empty($d) && empty($e)  && empty($e1))
		{
			$arrKondisi[]= "a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."'";
		}
		
		elseif(!empty($c1) && empty($c) && empty($d) && empty($e) && empty($e1))
		{
			$arrKondisi[]= "a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='$c1'";		
		}
		
		elseif(!empty($c1) && !empty($c) && empty($d) && empty($e) && empty($e1))
		{
			$arrKondisi[]= "a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='$c1' and c='$c'";		
		}
		
		elseif(!empty($c1) && !empty($c) && !empty($d) && empty($e) && empty($e1))
		{
			$arrKondisi[]= "a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='$c1' and c='$c' and d='$d'";		
		}
		
		elseif(!empty($c1) && !empty($c) && !empty($d) && !empty($e) && empty($e1))
		{
			$arrKondisi[]= "a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='$c1' and c='$c' and d='$d' and e='$e'";		
		}
		
		elseif(!empty($c1) && !empty($c) && !empty($d) && !empty($e) && !empty($e1))
		{
			$arrKondisi[]= "a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'";		
		}
			
		}
				
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		if ($urusan==0){
			switch($fmORDER1){
			case '1': $arrOrders[] = " a,b,c,d,e,e1,nip $Asc1 " ;break;
			case '2': $arrOrders[] = " nama $Asc1 " ;break;
			
		}	
		}else{
			switch($fmORDER1){
			case '1': $arrOrders[] = " a,b,c1,c,d,e,e1,nip $Asc1 " ;break;
			case '2': $arrOrders[] = " nama $Asc1 " ;break;
			
		}	
		}
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//limit --------------------------------------
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal, 'cek'=>$cek);
		
	}
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';		
		$form_name = $this->Prefix.'_Form';
		
		$fmURUSAN = $_REQUEST['fmURUSAN'];
		$fmSKPD = $_REQUEST['fmSKPD'];
		$fmUNIT = $_REQUEST['fmUNIT'];
		$fmSUBUNIT = $_REQUEST['fmSUBUNIT'];
		$fmSEKSI = $_REQUEST['fmSEKSI'];
				
		$FormContent = $this->genDaftarInitial($fmURUSAN, $fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI);
		$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						600,
						400,
						'Pilih Pegawai',
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
	
	function set_selector_other2($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){				
			case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
				break;
			}
			default:{
				$err = 'tipe tidak ada!';
				break;
			}
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function genDaftarInitial($fmURUSAN='', $fmSKPD='', $fmUNIT='', $fmSUBUNIT='', $fmSEKSI=''){
		$vOpsi = $this->genDaftarOpsi();
		return			
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 	
			"<input type='hidden' id='PegawaiPilihSkpdfmURUSAN' name='PegawaiPilihSkpdfmURUSAN' value='$fmURUSAN'>".	
			"<input type='hidden' id='".$this->Prefix."SkpdfmSKPD' name='".$this->Prefix."SkpdfmSKPD' value='$fmSKPD'>".
			"<input type='hidden' id='".$this->Prefix."SkpdfmUNIT' name='".$this->Prefix."SkpdfmUNIT' value='$fmUNIT'>".
			"<input type='hidden' id='".$this->Prefix."SkpdfmSUBUNIT' name='".$this->Prefix."SkpdfmSUBUNIT' value='$fmSUBUNIT'>".
			"<input type='hidden' id='".$this->Prefix."SkpdfmSEKSI' name='".$this->Prefix."SkpdfmSEKSI' value='$fmSEKSI'>".
			"</div>".					
			"<div id=garis style='height:1;border-bottom:1px solid #E5E5E5;'></div>".
			"<div id=contain style='overflow:auto;height:256;'>".
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".					
			"</div>
			</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
				"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
			"</div>";
	}
	
}
$PegawaiPilih = new PegawaiPilihObj();


?>