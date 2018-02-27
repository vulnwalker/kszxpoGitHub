<?php

class refurusanObj  extends DaftarObj2{	
	var $Prefix = 'refurusan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_urusan'; //daftar
	var $TblName_Hapus = 'ref_urusan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('bk','ck','dk');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Data';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='Ref Urusan.xls';
	var $Cetak_Judul = 'Urusan Pemerintahan dan Organisasi';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'refurusanForm'; 	
			
	function setTitle(){
		return 'Urusan Pemerintahan Daerah dan Organisasi';
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
		$kode = explode(' ',$idplh);
		$oldbk=$kode[0];
		$oldck=$kode[1]; 
		$olddk=$kode[2]; 
	 $bk = $_REQUEST['fmbk'];
	 $ck = $_REQUEST['fmck'];
	 $dk = $_REQUEST['dk'];	 
	 $nama_urusan = strtoupper($_REQUEST['nama_urusan']);
 	 
	 if($err=='' && $bk =='' ) $err= 'Kode Urusan belum diisi';
 	 if($err=='' && $ck =='' ) $err= 'Kode Bidang belum diisi';
 	 if($err=='' && $dk =='' ) $err= 'Kode Dinas belum diisi';
 	 if($err=='' && $nama_urusan =='' ) $err= 'Nama Urusan belum diisi';	 	 	 	 	 
	// $kondisi1=" concat(bk,ck,dk)='".$bk.$ck.$dk."' ";$cek.=$kondisi1;
			if($fmST == 0){ //input ref_urusan
			$ck_urusan = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ref_urusan WHERE $kondisi1 "));
				if($ck_urusan['cnt']>0 && $err=="") $err="Kode Urusan Sudah Ada!";
		
				if($err==''){ 
					$aqry1 = "INSERT into ref_urusan (bk,ck,dk,nm_urusan,stpakai)
							 "."values('$bk','$ck','$dk','$nama_urusan',0)";	$cek .= $aqry1;	
					$qry = mysql_query($aqry1);
					if($qry==FALSE) $err="Gagal menyimpan Urusan";
							
				}
			}elseif($fmST == 1){						
				if($err==''){
					$aqry2 = "UPDATE ref_urusan
			        		 set ".
							 " bk = '$bk',ck = '$ck',dk = '$dk',".
							 " nm_urusan = '$nama_urusan'".
					 		 "WHERE concat(bk,ck,dk)='".$oldbk.$oldck.$olddk."'";	$cek .= $aqry2;
					$qry = mysql_query($aqry2);
					if($qry==FALSE) $err="Gagal Edit Urusan";							
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
		$bk= $_REQUEST['bk'];
		$ck= $_REQUEST['ck'];
		$dk= $_REQUEST['dk'];
		$nama= $_REQUEST['nm_urusan'];
		$isi= $_REQUEST['isi'];
		
		if($isi=='0'){
			if( $err=='' && $nama =='' ) $err= 'Nama Urusan Belum Di Isi !!';
			
			if($err==''){
				$aqry = "UPDATE ref_urusan set nm_urusan='$nama' where bk='$bk' and ck='$ck' and dk='$dk' and concat (bk,' ',ck,' ',dk)='".$idplh."'";$cek .= $aqry;
				$qry = mysql_query($aqry);
			}
			
		}elseif($isi=='1'){
			if( $err=='' && $nama =='' ) $err= 'Nama Bidang Belum Di Isi !!';
			
			if($err==''){
				$aqry = "UPDATE ref_urusan set nm_urusan='$nama' where bk='$bk' and ck='$ck' and dk='$dk' and concat (bk,' ',ck,' ',dk)='".$idplh."'";$cek .= $aqry;
				$qry = mysql_query($aqry);
			}
			
		}else{
			if( $err=='' && $nama =='' ) $err= 'Nama Dinas Belum Di Isi !!';
		
			if($err==''){
				$aqry = "UPDATE ref_urusan set nm_urusan='$nama' where bk='$bk' and ck='$ck' and dk='$dk' and concat (bk,' ',ck,' ',dk)='".$idplh."'";$cek .= $aqry;
				$qry = mysql_query($aqry);
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
		
		case 'hapus':{	
				$fm= $this->Hapus($pil);
				$err= $fm['err']; 
				$cek = $fm['cek'];
				$content = $fm['content'];
		break;
		}
		
		case 'refreshUrusan':{
				
		global $Main;
	 
		$bk = $_REQUEST['bk'];	 
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$bknew= $_REQUEST['id_UrusanBaru'];
	 
		$querybk="SELECT bk, concat(bk, '. ', nm_urusan) as vnama FROM ref_urusan WHERE bk!='000' and ck = '000' and dk='000'" ;
		$content->bk=cmbQuery('fmbk',$bknew,$querybk,'style="width:400px;"onchange="'.$this->Prefix.'.pilihUrusan()"','&nbsp&nbsp-------- Pilih Urusan -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruUrusan()' title='Baru' >";
	
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
		break;
	    }
		
		case 'pilihUrusan':{				
			global $Main;
			$bk = $_REQUEST['fmbk'];
			$ck = $_REQUEST['fmck'];
			
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$queryck="SELECT ck, concat(ck, '. ', nm_urusan) as vnama FROM ref_urusan WHERE bk='$bk' and ck!='000' and dk='000'" ;$cek.=$queryck;
			$content->ck=cmbQuery('fmck',$fmc,$queryck,'style="width:400px;"onchange="'.$this->Prefix.'.pilihBidang()"','-------- Pilih Kode BIDANG ------------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruBidang()' title='Baru' >";
			
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}
			
		case 'pilihBidang':{				
		global $Main;
			
			$bk = $_REQUEST['fmbk'];
			$ck = $_REQUEST['fmck'];
			
			$cek = ''; $err=''; $content=''; $json=TRUE;
			 
		 	$querydk="SELECT max(dk) as dk, nm_urusan FROM ref_urusan WHERE bk='$bk' and ck='$ck'" ;$cek.=$querydk;
			$get=mysql_fetch_array(mysql_query($querydk));
			$lastkode=$get['dk'] + 1;	
			//$kode_e1 = sprintf("%03s", $lastkode);
			$content->dk=$lastkode;
		 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}			
		
		case 'getKode_dk':{
			$get= $this->getKode_dk();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
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

		$ref_pilihurusan = $_REQUEST['id'];
		$kode_urusan = explode(' ',$ref_pilihurusan);
		$bk=$kode_urusan[0];	
		$ck=$kode_urusan[1];
		$dk=$kode_urusan[2];
		
		//query ambil data ref_urusan
		$get = mysql_fetch_array( mysql_query("select * from ref_urusan where bk=$bk and ck=$ck and dk=$dk"));
		$kode_urusan=$get['bk'].'.'.$get['ck'].'.'.$get['dk'];
		
		$content = array('kode_urusan'=>$kode_urusan, 'nama_urusan'=>$get['nm_urusan']);	
		break;
	   }

					
		case 'simpan':{
			$get= $this->simpan();
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
	   
	   case 'simpanUrusan':{
				$get= $this->simpanUrusan();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    }
		
		case 'simpanBidang':{
				$get= $this->simpanBidang();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    }
		
		case 'refreshBidang':{
				$get= $this->refreshBidang();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    	}
	   
	   case 'BaruUrusan':{				
				$fm = $this->setFormBaruUrusan();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}	
			
		case 'BaruBidang':{				
				$fm = $this->setFormBaruBidang();				
				$cek = $fm['cek'];
				$err = $fm['err'];
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
   
   function Hapus($ids){ //validasi hapus tbl_sppd
		 $err=''; $cek='';
		 $cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		
		if ($err ==''){
			
		for($i = 0; $i<count($ids); $i++){
		$idplh1 = explode(" ",$ids[$i]);
		$data_bk= $idplh1[0];
	 	$data_ck= $idplh1[1];
		$data_dk= $idplh1[2];
		$program=mysql_query("select count(*) as cnt,bk,ck,dk from ref_program where bk='$data_bk' and ck='$data_ck' and dk='$data_dk'"); $cek.="select count(*) as cnt,bk,ck,dk from ref_program where bk='$data_bk' and ck='$data_ck' and dk='$data_dk'";
		$ref_program=mysql_fetch_array($program);
		if($ref_program['cnt'] > 0 )$err ="Gagal Hapus! Data URUSAN Sudah ada di Program / Kegiatan !!";		
		if ($data_bk != '0'){
			$sk1="select bk,ck,dk from ref_urusan where bk='$data_bk' and ck!='0'";
		}
		
		if ($data_ck != '0'){
			$sk1="select bk,ck,dk from ref_urusan where bk='$data_bk' and ck='$data_ck' and dk!='0'";
		}
	
	//	$err='tes';
		if ($data_dk=='0'){
			$qrycek=mysql_query($sk1);$cek.=$sk1;
			if(mysql_num_rows($qrycek)>0)$err='data tidak bisa di hapus';
		}
		
		
		if($err=='' ){
					$qy = "DELETE FROM ref_urusan WHERE bk='$data_bk' and ck='$data_ck' and dk='$data_dk'  and  concat (bk,' ',ck,' ',dk) ='".$ids[$i]."' ";$cek.=$qy;
					$qry = mysql_query($qy);
					
			}else{
				break;
			}			
		}
		}
		return array('err'=>$err,'cek'=>$cek);
	}
   
   function getKode_dk(){
	 global $Main;
	 
	 	$bk = $_REQUEST['fmbk'];	 
		$ck = $_REQUEST['ck'];
		
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kenew= $_REQUEST['id_BidangBaru'];
	 
	 	$aqry5="SELECT MAX(dk) AS maxno FROM ref_urusan WHERE bk='$bk' and ck='$ck'"; $cek.=$aqry5;
		$get=mysql_fetch_array(mysql_query($aqry5));
		$newke=$get['maxno'] + 1;
		
		$content->dk=$newke;	
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
   
   
   function refreshBidang(){
	global $Main;
	 
		$bk = $_REQUEST['bk'];	 
		$ck = $_REQUEST['ck'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$kcnew= $_REQUEST['id_BidangBaru'];
	 
		$querybk="SELECT ck, concat(ck, '. ', nm_urusan) as vnama FROM ref_urusan WHERE bk='$bk' and ck!='000' and dk='000'" ;
		$content->ck=cmbQuery('fmck',$kcnew,$querybk,'style="width:400;"onchange="'.$this->Prefix.'.pilihBidang()"','&nbsp&nbsp-------- Pilih Bidang -------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruBidang()' title='Baru' >";
	 
	 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}	

	
	function setFormBaruUrusan(){
		$dt=array();
		$this->form_fmST = 0;
		
		$fm = $this->BaruUrusan($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormBaruBidang(){
		$dt=array();
		$this->form_fmST = 0;
		
		$fm = $this->BaruBidang($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function simpanUrusan(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$dtbk= $_REQUEST['bk'];
		$nama= $_REQUEST['nama'];
		$barcode= $_REQUEST['barcode'];
		if( $err=='' && $nama =='' ) $err= 'Nama Kode Bidang Belum Di Isi !!';
	
		if($fmST == 0){
			if($err==''){
				$aqry = "INSERT into ref_urusan (bk,ck,dk,nm_urusan,stpakai) values('$dtbk','0','0','$nama','0')";	
				$cek .= $aqry;	
				$qry = mysql_query($aqry);
				$content=$dtbk;	
				}
			}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }		
	
	function simpanBidang(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
	$uid = $HTTP_COOKIE_VARS['coID'];
	$cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	$fmST = $_REQUEST[$this->Prefix.'_fmST'];
 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
	$dtbk= $_REQUEST['bk'];
	$dtck= $_REQUEST['ck'];
	$nama= $_REQUEST['nama'];
	
	if( $err=='' && $nama =='' ) $err= 'Nama Kode Bidang Belum Di Isi !!';
	if($fmST == 0){
		if($err==''){
			$aqry = "INSERT into ref_urusan (bk,ck,dk,nm_urusan,stpakai) values('$dtbk','$dtck','0','$nama','0')";	
		$cek .= $aqry;	
		$qry = mysql_query($aqry);
		$content=$dtck;	
			}
		}		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	
	function BaruUrusan($dt){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKA';				
	 $this->form_width = 570;
	 $this->form_height = 50;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru Kode URUSAN';
		$nip	 = '';
		$bk = $_REQUEST ['fmbk'];
			
		$aqry2="SELECT MAX(bk) AS maxno FROM ref_urusan where ck='000' and dk='000'";
		$cek.=$aqry2;
		$get=mysql_fetch_array(mysql_query($aqry2));
		$newbk=$get['maxno'] + 1;
	 
		
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
							 			
			'kode_urusan' => array( 
						'label'=>'KODE URUSAN',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='bk' id='bk' value='".$newbk."' style='width:30px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Urusan' style='width:400px;'>
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
		"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanUrusan()' title='Simpan' >"."&nbsp&nbsp".
		"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close1()' >";
		$form = $this->genFormUrusan();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function genFormUrusan($withForm=TRUE, $params=NULL, $center=TRUE){	
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
	
		
	function BaruBidang($dt){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 720;
	 $this->form_height = 90;
		$bk = $_REQUEST ['fmbk'];
	
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru Kode BIDANG';
		$nip	 = '';
		
		$aqry2="SELECT MAX(ck) AS maxno FROM ref_urusan WHERE bk='$bk' and dk='000'";
		$cek.=$aqry2;
		$querybk=mysql_fetch_array(mysql_query("SELECT bk, nm_urusan FROM ref_urusan where bk='$bk' and ck='000' and dk='000'")); 
		$cek.="SELECT bk, nm_urusan FROM ref_urusan where bk='$bk' and ck='000' and dk='000'";
		$get=mysql_fetch_array(mysql_query($aqry2));
		$newck=$get['maxno'] + 1;
		
	//	$newdtc1 = sprintf("%02s", $newc);
		$databk=$querybk['bk'].".".$querybk['nm_urusan'];		
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			
			'urusan' => array( 
						'label'=>'KODE URUSAN',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='urusan' id='urusan' value='".$databk."' style='width:510px;' readonly>
						<input type ='hidden' name='bk' id='bk' value='".$querybk['bk']."'>
						</div>", 
						 ),	
									 			
			'bidang' => array( 
						'label'=>'KODE BIDANG',
						'labelWidth'=>120, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='ck' id='ck' value='".$newck."' style='width:30px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Bidang' style='width:480px;'>
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
		"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanBidang()' title='Simpan' >"."&nbsp&nbsp".
		"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()'>";
		$form = $this->genFormBidang();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function genFormBidang($withForm=TRUE, $params=NULL, $center=TRUE){	
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
	
	function setPage_OtherScript(){
		$scriptload = 

					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			 "<script type='text/javascript' src='js/master/refurusan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".		
			$scriptload;
	}
	
	function Hapus_Validasi($ids){
		$errmsg ='';
		$arrKondisi = array();
		$KeyValue = explode(' ',$ids);
		for($i=0;$i<sizeof($this->KeyFields);$i++){
			$arrKondisi[] = $this->KeyFields[$i]."='".$KeyValue[$i]."'";
		}
		$Kondisi = join(' and ',$arrKondisi);
				
		if($errmsg=='' && 
				mysql_num_rows(mysql_query(
					"select * from ref_urusan where ".$Kondisi." and stpakai=1")
				) >0 )
			{ $errmsg = 'Gagal Hapus! Urusan Sudah Dipakai!';}
		return $errmsg;
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
	//	$dt['bk']='1';//$fmURUSAN;
		$dt['bk']='0';//$fmURUSAN;
		$dt['ck']='0';//$fmBIDANG;
		$dt['dk']='0';//$fmDINAS;
		
		$fm = $this->setForm($dt);		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
   
//  	/*function setFormEdit(){
//*/		$cbid = $_REQUEST[$this->Prefix.'_cb'];
//		$cek =$cbid[0];				
//		$this->form_idplh = $cbid[0];
//		$kode = explode(' ',$this->form_idplh);
//		$this->form_fmST = 1;
//		//get data
//		$bk=$kode[0];
//		$ck=$kode[1]; 
//		$dk=$kode[2]; 
//		//query ambil data ref_urusan
//		$aqry = "select * from ref_urusan where concat(bk,ck,dk)='".$bk.$ck.$dk."'"; $cek.=$aqry;
//		$dt = mysql_fetch_array(mysql_query($aqry));
//		
//		$fm = $this->setForm($dt);
//		
//		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
//	}
//	

	function setFormEdit(){
	$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$bk=$kode[0];
		$ck=$kode[1];
		$dk=$kode[2];
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  ref_urusan WHERE bk= '$bk' and ck='$ck' and dk='$dk'"; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		
		if($dt['bk']!='0' && $dt['ck']=='0' && $dt['dk']=='0'){
			$fm = $this->setFormEditUrusandata($dt);
		}elseif($dt['bk']!='0' && $dt['ck']!='0' && $dt['dk']=='0'){
			$fm = $this->setFormEditBidangdata($dt);
		}else{
			$fm = $this->setFormEditdata($dt);
		}
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

	function setFormEditUrusandata($dt){	
	 global $SensusTmp ,$Main;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 600;
	 $this->form_height = 50;
	  if ($this->form_fmST==1) {
		$this->form_caption = 'FORM EDIT URUSAN';
	  }
	 
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;	
		$bk=$kode[0];
		$ck=$kode[1];
		$dk=$kode[2];
		
		
		$querybkedit=mysql_fetch_array(mysql_query("SELECT bk, nm_urusan FROM ref_urusan WHERE bk='$bk' and ck = '0' and dk='0'")) ;
		$datbk=$querybkedit['bk'];
		
       //items ----------------------
		$this->form_fields = array(
		  
			'URUSAN' => array( 
						'label'=>'URUSAN',
						'labelWidth'=>50, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='bk' id='bk' value='".$datbk."' style='width:30px;' readonly>
						<input type='text' name='nm_urusan' id='nm_urusan' value='".$dt['nm_urusan']."' size='71px'>
						</div>", 
						 )			 
			);
		//tombol
		$this->form_menubawah =	
		"<input type ='hidden' name='ck' id='ck' value='".$ck."'>".
		"<input type ='hidden' name='dk' id='dk' value='".$dk."'>".
		"<input type ='hidden' name='isi' id='isi' value='0'>".
		"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanEdit()' title='Simpan' >"."&nbsp&nbsp".
		"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";					
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setFormEditBidangdata($dt){	
	 global $SensusTmp ,$Main;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 600;
	 $this->form_height = 70;
	  if ($this->form_fmST==1) {
		$this->form_caption = 'FORM EDIT BIDANG';
	  }
	 
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;	
		$bk=$kode[0];
		$ck=$kode[1];
		$dk=$kode[2];
		
		
		$querybkedit=mysql_fetch_array(mysql_query("SELECT bk, nm_urusan FROM ref_urusan WHERE bk='$bk' and ck = '0' and dk='0'")) ;
		$queryckedit=mysql_fetch_array(mysql_query("SELECT ck, nm_urusan FROM ref_urusan WHERE bk='$bk' and ck = '$ck' and dk= '0'")) ; 
		
		$datbk=$querybkedit['bk'].".  ".$querybkedit['nm_urusan'];
		$datck=$queryckedit['ck'];
		
       //items ----------------------
		$this->form_fields = array(
		  
		'URUSAN' => array( 
						'label'=>'URUSAN',
						'labelWidth'=>50, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='databk' id='databk' value='".$datbk."' style='width:490px;' readonly>
						<input type ='hidden' name='bk' id='bk' value='".$querybkedit['bk']."'>
						</div>", 
						 ),
						 
		'BIDANG' => array( 
						'label'=>'BIDANG',
						'labelWidth'=>50, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='ck' id='ck' value='".$datck."' style='width:30px;' readonly>
						<input type='text' name='nm_urusan' id='nm_urusan' value='".$dt['nm_urusan']."' size='71px'>
						</div>", 
						 )
						 	 
			);
		//tombol
		$this->form_menubawah =	
		"<input type ='hidden' name='dk' id='dk' value='".$dk."'>".
		"<input type ='hidden' name='isi' id='isi' value='1'>".
		"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanEdit()' title='Simpan' >"."&nbsp&nbsp".
		"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";					
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setFormEditdata($dt){	
	 global $SensusTmp ,$Main;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 600;
	 $this->form_height = 100;
	  if ($this->form_fmST==1) {
		$this->form_caption = 'FORM EDIT DINAS';
	  }
	 
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;	
		$bk=$kode[0];
		$ck=$kode[1];
		$dk=$kode[2];
				
		$querybkedit=mysql_fetch_array(mysql_query("SELECT bk, nm_urusan FROM ref_urusan WHERE bk='$bk' and ck = '0' and dk='0'")) ;
		$queryckedit=mysql_fetch_array(mysql_query("SELECT ck, nm_urusan FROM ref_urusan WHERE bk='$bk' and ck='$ck' and dk= '0'"));
		$querydkedit=mysql_fetch_array(mysql_query("SELECT dk, nm_urusan FROM ref_urusan WHERE bk='$bk' and ck='$ck' and dk='$dk'")) ;$cek.="SELECT dk, nm_skpd FROM ref_skpd WHERE bk='$bk' and ck='$ck' and dk='$dk'";
		
		$datbk=$querybkedit['bk'].".  ".$querybkedit['nm_urusan'];
		$datcb=$queryckedit['ck'].". ".$queryckedit['nm_urusan'];
		$datdk=$querydkedit['dk'];
		
       //items ----------------------
		  $this->form_fields = array(
		  
		 'URUSAN' => array( 
						'label'=>'URUSAN',
						'labelWidth'=>50, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='databk' id='databk' value='".$datbk."' style='width:490px;' readonly>
						<input type ='hidden' name='bk' id='bk' value='".$querybkedit['bk']."'>
						</div>", 
						 ),
						 
			'BIDANG' => array( 
						'label'=>'BIDANG',
						'labelWidth'=>50, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='datack' id='datack' value='".$datcb."' style='width:490px;' readonly>
						<input type ='hidden' name='ck' id='ck' value='".$queryckedit['ck']."'>
						</div>", 
						 ),
						 
			'DINAS' => array( 
						'label'=>'DINAS',
						'labelWidth'=>50, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='dk' id='dk' value='".$datdk."' style='width:30px;' readonly>
						<input type='text' name='nm_urusan' id='nm_urusan' value='".$dt['nm_urusan']."' size='71px'>
						</div>", 
						 )			 			 			 
			
									 	 
			);
		//tombol
		$this->form_menubawah =	
		"<input type ='hidden' name='isi' id='isi' value='2'>".
		"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanEdit()' title='Simpan' >"."&nbsp&nbsp".
		"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";					
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 
		
	 $json = TRUE;	//$ErrMsg = 'tes';
	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 570;
	 $this->form_height = 100;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU';
	  }else{
		$this->form_caption = 'EDIT';
	  }
	  	$querybk="SELECT bk, concat(bk, '. ', nm_urusan) as vnama FROM ref_urusan where bk!='000' and ck='000' and dk='000'";
		$queryck="SELECT ck,concat(ck, '. ', nm_urusan) as vnama FROM ref_urusan where bk='".$dt['bk']."' and ck!='000' and dk='000'";
		
		if ($dt['stpakai']==1)	$readonly="readonly=''";
       //items ----------------------
		  $this->form_fields = array(
			'urusan' => array( 
						'label'=>'URUSAN',
						'labelWidth'=>60, 
						'value'=>"<div id='cont_bk'>".cmbQuery('fmbk',$dt['bk'],$querybk,'style="width:400px;"onchange="'.$this->Prefix.'.pilihUrusan()"','-------- Pilih Kode URUSAN ------------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruUrusan()' title='Baru' ></div>",
						 ),		
						 	
			'bidang' => array( 
						'label'=>'BIDANG',
						'labelWidth'=>60, 
						'value'=>
						"<div id='cont_ck'>".cmbQuery('fmck',$dt['ck'],$queryck,'style="width:400px;"onchange="'.$this->Prefix.'.pilihBidang()"','-------- Pilih Kode BIDANG -----------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruBidang()' title='Baru' ></div>",
						 ),
						 		 
			'dinas' => array( 
						'label'=>'DINAS',
						'labelWidth'=>60, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='dk' id='dk' value='".$newke."' style='width:30px;' readonly>
						<input type='text' name='nama_urusan' id='nama_urusan' value='".$nama."' placeholder='Nama DINAS' style='width:430px;'>
						</div>", 
						 ),		
//			/*'kode_urusan' => array( 
//								'label'=>'Kode Urusan',
//								'labelWidth'=>100, 
//								'value'=>"<input type='text' name='fmbk' id='fmbk' value='".$dt['bk']."' size='4' onkeypress='return isNumberKey(event)' $readonly>"
//									 ),
//			'kode_bidang' => array( 
//								'label'=>'Kode Bidang',
//								'labelWidth'=>100, 
//								'value'=>"<input type='text' name='fmck' id='fmck' value='".$dt['ck']."' size='4' onkeypress='return isNumberKey(event)' $readonly>"
//								'value'=>"<input type='text' name='fmck' id='fmck' value='".$dt['ck']."' size='4' onkeypress='return isNumberKey(event)' $readonly>"
//									 ),
//			'kode_dinas' => array( 
//								'label'=>'Kode Dinas',
//								'labelWidth'=>100, 
//								'value'=>"<input type='text' name='fmdk' id='fmdk' value='".$dt['dk']."' size='4' onkeypress='return isNumberKey(event)' $readonly>"
//									 ),						 						 
//			'nama_urusan' => array( 
//								'label'=>'Nama',
//								'labelWidth'=>100, 
//								'value'=>$dt['nm_urusan'], 
//								'type'=>'text',
//								'id'=>'nama_urusan',
//								'param'=>"style='width:250ppx;text-transform: uppercase;' size=50px"
//									 ),	
//			*/					 
			);
		//tombol
		$this->form_menubawah =	
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Batal kunjungan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
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
						800,
						500,
						'Pilih Urusan',
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
  	   <th class='th01' width='20' >No.</th>
  	   $Checkbox		
   	   <th class='th01' align='left' width='100'>Kode</th>
	   <th class='th01' align='left' width='800'>Urusan Pemerintahan Daerah</th>	   	   	   
	   </tr>
	   </thead>";
	
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 global $Main;
		$isi = array_map('utf8_encode', $isi);

	 $kode_urusan=$isi['bk'].'.'.$isi['ck'].'.'.$isi['dk'];
	 $Koloms = array();
	 $Koloms[] = array('align="center" width="20"', $no.'.' );
	 if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="left" width="100" ',$kode_urusan);
 	 $Koloms[] = array('align="left" width="200"',$isi['nm_urusan']);	 	 	 	 
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;	 
	
	$fmURUSAN = cekPOST('fmURUSAN');
	$fmBIDANG = cekPOST('fmBIDANG');
	$fmDINAS = cekPOST('fmDINAS');
	$fmKODE = cekPOST('fmKODE');
	$fmNMURUSAN = cekPOST('fmNMURUSAN');		
		
		
	$TampilOpt = 
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
		
		if(!empty($_POST['fmKODE'])) $arrKondisi[] = " concat(bk,ck,dk) like '%".str_replace('.','',$_POST['fmKODE'])."%'";					
		if(!empty($_POST['fmNMURUSAN'])) $arrKondisi[] = " nm_urusan like '%".$_POST['fmNMURUSAN']."%'";

 			
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '': $arrOrders[] = " concat(bk,ck,dk) ASC " ;break;
			case '1': $arrOrders[] = " concat(bk,ck,dk) $Asc1 " ;break;
			case '2': $arrOrders[] = " nm_urusan $Asc1 " ;break;
		
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
$refurusan = new refurusanObj();

?>