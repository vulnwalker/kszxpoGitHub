<?php

class refclosingdataPenyusutanObj  extends DaftarObj2{	
	var $Prefix = 'refclosingdataPenyusutan';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_closing'; //bonus
	var $TblName_Hapus = 't_closing';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('c1','c','d','e','e1');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Data';
	var $PageIcon = 'images/administrasi_ico.png';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='refclosingdataPenyusutan.xls';
	var $namaModulCetak='REFERENSI DATA';
	var $Cetak_Judul = 'CLOSING DATA PENYUSUTAN';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'refclosingdataPenyusutanForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	function setTitle(){
		return 'CLOSING DATA PENYUSUTAN';
	}

	
	function setMenuEdit(){		
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Closing()","new_f2.png","Closing",'Closing')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Batal", 'Batal').
			"</td>";
	}
	
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		
		//$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD'); //echo 'fmskpd='.$fmSKPD;
		//$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		//$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD');// echo 'fmskpd='.$fmSKPD;
		$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		$fmSEKSI = cekPOST($this->Prefix.'SkpdfmSEKSI');
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
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 	 $c1= $_REQUEST['c1']; 
	 $c= $_REQUEST['c']; 
 	 $d= $_REQUEST['d'];
	 $e= $_REQUEST['e']; 
 	 $e1= $_REQUEST['e1']; 
 	 //$dk= $_REQUEST['dk'];
	 $keterangan= $_REQUEST['keterangan'];
	
	 $status= $_REQUEST['status'];
	 $data= $_REQUEST['data'];
	 // $tgl_update= $_REQUEST['tgl_update']; 	
        
      // if ($status == 1) {
      // 	 $tahun= $_REQUEST['tahun'];
      // }else{
      // 	 $tahun= $_REQUEST['tahun'];
      // }	 


	  $tahun= $_COOKIE['coThnAnggaran'];
		$tahunAnggaranRequest = $_REQUEST['tahun'];
	  $explodeTahun = explode('-', $_REQUEST['tahun']);
	  
	  $tanggalUpdate = date('Y-m-d H:i:s');
      
  //     if ($data == 1) {
		// $dataQuery =",'$tahun-12-31','$keterangan','$tanggalUpdate','',''";
  //     }else{
		// $dataQuery =",'','$keterangan','$tanggalUpdate','$tahun-12-31',''";
  //     }

	  $dataQuery =",'','$keterangan','$tanggalUpdate','$tahunAnggaranRequest-12-31',''";
      
      $userId = $_COOKIE['coID'];

	 //query cek c,d sudah ada
	 if(empty($c1)) $c1='0';
	 if(empty($c)) $c='00';
	 if(empty($d)) $d='00';
	 if(empty($e)) $e='00';
	 if(empty($e1)) $e1='000';
 $c_d=mysql_fetch_array(mysql_query("select * from t_closing where c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' and tgl_susut != '0000-00-00'"));	 
	  
	// if( $err=='' && $bk =='' ) $err= 'Urusan Belum Di Isi !!';
	 //if( $err=='' && $ck =='' ) $err= 'Bidang Belum Di Isi !!';
 	// if( $err=='' && $dk =='' ) $err= 'Dinas Belum Di Isi !!';
	 //if( $err=='' && $dk =='' ) $err= 'Sub Belum Di Isi !!';
	 //if($err=='' && $ket =='' ) $err= 'Keterangan Belum Di Isi';	


if ($explodeTahun[0] > $tahun) {$err = 'Tahun tidak boleh melebihi Tahun Anggaran';}
	  		if($err=='' && $explodeTahun[0] < $tahun-1 ) $err = 'Tahun tidak boleh lebih kecil dari '.($tahun-1);
			//cek sudah closing perolehan
			$tglClosePerolehan = getTglClosing($c, $d, $e, $e1, $c1);
			if($err=='' &&  $tglClosePerolehan < $tahun.'-12-31' ) $err = 'Belum Closing Perolehan!';


			if($fmST == 0){
				if($err==''){
					//if(empty($c_d['c1']) && empty($c_d['c']) && empty($c_d['d']) && empty($c_d['e']) && empty($c_d['e1'])){
					$aqry = "select count(*) as cnt  from t_closing where c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' ";	$cek .= $aqry;
					$cnt =mysql_fetch_array(mysql_query($aqry));
					if($cnt['cnt']==0){
						$aqry = "INSERT into t_closing (c1,c,d,e,e1,uid,ket,tgl_update_susut,tgl_susut) ".
							" values('$c1','$c','$d','$e','$e1','$userId', '$keterangan',now(),'$tahunAnggaranRequest-12-31'  )";
						$cek .= $aqry;		
					}else{
						$aqry = "UPDATE t_closing set tgl_update_susut = '$tanggalUpdate', tgl_susut = '$tahunAnggaranRequest-12-31', ket='$keterangan'".
							"WHERE c1='".$c1."' AND c='".$c."' AND d='".$d."' AND e='".$e."' AND e1='".$e1."'";
						
						$cek .= $aqry;
						}
						
						$qry = mysql_query($aqry);
				}
			}elseif($fmST == 1){				
				if($err==''){
					if(empty($c_d['c1']) && empty($c_d['c']) && empty($c_d['d']) && empty($c_d['e']) && empty($c_d['e1'])){
						$aqry = "INSERT into t_closing (c1,c,d,e,e1,uid,tgl,ket,tgl_update,tgl_susut,tgl_persediaan) values('$c1','$c','$d','$e','$e1' $dataQuery)";

						$cek .= $aqry;						
					}else{
						$aqry = "UPDATE t_closing set tgl_update = '$tanggalUpdate', tgl_susut = '$tahunAnggaranRequest-12-31', ket='$keterangan'".
							"WHERE c1='".$c1."' AND c='".$c."' AND d='".$d."' AND e='".$e."' AND e1='".$e1."'";
							$cek .= $aqry;
				     	$cek .= $aqry;
					}	

					$qry = mysql_query($aqry);
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
			
		case 'formClosing':{				
			$fm = $this->setFormClosing();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}	
		case 'formClosing 1':{				
			$fm = $this->setFormClosing();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}	
		
	  	case 'fmskpd':{
			$fmBidang = $_REQUEST['fmBidang'];

				$query = "SELECT d,nm_skpd FROM ref_skpd WHERE c='$fmBidang' AND d!='00' AND e='00' AND e1='000'"; $cek .= $query2;
				$hasil = mysql_query($query);
				$fmskpd = "<option value=''>-- PILIH SKPD--</option>";
				while ($dt = mysql_fetch_array($hasil))
				{
					$fmskpd.="<option value='".$dt['d']."'>".$dt['nm_skpd']."</option>";
				}
		$content = "<select name='fmSKPD' id='fmSKPD'>".$fmskpd."</select>";
				
		break;
	   } 	
	   
	  	case 'urusan':{
			$urusan = $_REQUEST['urusan'];

				$query = "SELECT ck,nm_urusan FROM ref_urusan WHERE bk='".$urusan."' AND ck!='0' AND dk='0'"; $cek .= $query;
				$hasil = mysql_query($query);
				$div_bidang = "<option value=''>-- PILIH Bidang--</option>";
				while ($dt = mysql_fetch_array($hasil))
				{
					$div_bidang.="<option value='".$dt['ck']."'>".$dt['nm_urusan']."</option>";
				}
		$content = "<select name='ck' id='ck' onChange='".$this->Prefix.".Bidang()'>".$div_bidang."</select>";
				
		break;
	   }
	   
	  	case 'bidang':{
			$urusan = $_REQUEST['urusan'];
			$bidang = $_REQUEST['bidang'];

				$query = "SELECT dk,nm_urusan FROM ref_urusan WHERE bk='".$urusan."' AND ck='$bidang' AND dk!='0'"; $cek .= $query;
				$hasil = mysql_query($query);
				$div_dinas = "<option value=''>-- PILIH Dinas--</option>";
				while ($dt = mysql_fetch_array($hasil))
				{
					$div_dinas.="<option value='".$dt['dk']."'>".$dt['nm_urusan']."</option>";
				}
		$content = "<select name='dk' id='dk'>".$div_dinas."</select>";
				
		break;
	   }	   	   		
				
		case 'edit':{				
			$fm = $this->edit();				
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
		
		case 'test':{
			$cek = "cek";
			$err = "test";
			$json = FALSE;
			
			echo"<html>
				<head>
				<link type='text/css' href='css/menu.css' rel='stylesheet'></link>
				<link type='text/css' href='css/template_css.css' rel='stylesheet'></link>
				<link type='text/css' href='css/theme.css' rel='stylesheet'></link>
				<link type='text/css' href='dialog/dialog.css' rel='stylesheet'></link>
				<link type='text/css' href='lib/chatx/chatx.css' rel='stylesheet'></link>
				<link type='text/css' href='css/base.css' rel='stylesheet'></link>
				<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>			
				<script type='text/javascript' src='lib/js/JSCookMenu_mini.js' language='JavaScript'></script>	
				<script type='text/javascript' src='lib/js/ThemeOffice/theme.js' language='JavaScript'></script>	
				<script type='text/javascript' src='lib/js/joomla.javascript.js' language='JavaScript'>	</script>		
				<script type='text/javascript' src='js/jquery.js' language='JavaScript' ></script>	
				<script type='text/javascript' src='js/ajaxc2.js' language='JavaScript' ></script>
				<script type='text/javascript' src='dialog/dialog.js' language='JavaScript'></script>
				<script type='text/javascript' src='js/global.js' language='JavaScript'></script>
				<script type='text/javascript' src='js/base.js' language='JavaScript'></script>
				<script type='text/javascript' src='js/encoder.js' language='JavaScript'></script>
				<script type='text/javascript' src='lib/chatx/chatx.js' language='JavaScript'>	</script>				
				<script type='text/javascript' src='js/daftarobj.js' language='JavaScript' ></script>
				<script type='text/javascript' src='js/pageobj.js'></script>		
				<script type='text/javascript' src='js/master/refstatusbarang/refstatusbarang.js' language='JavaScript' ></script>
			<script src='js/jquery-ui.custom.js'></script>
			<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>	
				<script>
			 	$(document).ready(function(){
					RefStatusBarang.autocomplete_initial();
				});
				</script>
				</head>
				<body>
				<form action='' method='post' id='ref_status_barang_form' name='ref_status_barang_form'>				
				<div id='tampil_status_barang'>
				<input type='text' name='status_barang' id='status_barang' value='".$dt['nama']."' style='width:200px'>
				<input type='hidden' id='id_status_barang' name='id_status_barang' value='".$dt['Id']."' title='penyedia_barang'>
				<input type='button' name='reset' value='Reset' onClick='document.getElementById(\"status_barang\").value=\"\";document.getElementById(\"id_status_barang\").value=\"\";'>
				<input type='button' value='Cari' id='cari' onclick ='".$this->Prefix.".Cari()' title='Cari' >
				</div>
				</form>
				</body>
				</html>";
			
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
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".		
			"<script type='text/javascript' src='js/admin/refclosingdata/refclosingdataPenyusutan.js' language='JavaScript' ></script>".
			$scriptload;
	}
	
	//form ==================================
	function setFormClosing(){
		/*$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['mode'] = $_REQUEST['mode'];
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}*/
	$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		
		$dt['c1'] = '0';
		$dt['c'] = '00';
		$dt['d'] = '00';
		$dt['e'] = '00';
		$dt['e1'] = '000';
			
		//if($DataOption['skpd'] == 1){
			$dt['c1'] = $_REQUEST['refclosingdataPenyusutanSKPD2fmURUSAN'];
			$dt['c'] = $_REQUEST['refclosingdataPenyusutanSKPD2fmSKPD'];
			$dt['d'] = $_REQUEST['refclosingdataPenyusutanSKPD2fmUNIT'];
			$dt['e'] = $_REQUEST['refclosingdataPenyusutanSKPD2fmSUBUNIT'];
			$dt['e1'] = $_REQUEST['refclosingdataPenyusutanSKPD2fmSEKSI'];

		$cek =$cbid[0];				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$fm = $this->setForm($dt);		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	function setFormClosing1(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['mode'] = $_REQUEST['mode'];
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	function setFormHistory(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['mode'] = $_REQUEST['mode'];
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
   
  	function setFormBatal(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode=explode(" ",$this->form_idplh);
		$this->form_fmST = 1;						
		//get data 
		$aqry = "SELECT * FROM  v1_refclosingdataPenyusutan WHERE c='".$kode[0]."' AND d='".$kode[1]."'"; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		//query skpd
		$c=mysql_fetch_array(mysql_query("select * from ref_skpd where c=".$dt['c']." and d=00 and e=00 and e1=00"));
		$d=mysql_fetch_array(mysql_query("select * from ref_skpd where c=".$dt['c']." and d=".$dt['d']." and e=00 and e1=00"));
		$dt['bidang']=$c['nm_skpd'];
		$dt['skpd']=$d['nm_skpd'];

		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function genForm($mode){	
		$form_name = $mode==1 ? $this->Prefix.'_form': $this->Prefix.'_form';	
		$form = 
			centerPage(
				"<form name='$form_name' id='$form_name' method='post' action='' >".
				createDialog(
					$form_name.'_div', 
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height).
				"</form>"
			);
		return $form;
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
	 $this->form_height = 300;


	$cekRequest = count($_REQUEST['refclosingdataPenyusutan_cb']);

if ($cekRequest > 1) {
   $err = "PILIH DATA HANYA 1";
}

	  if ($_REQUEST['refclosingdataPenyusutan_cb'] == "") {
		$this->form_caption = 'Closing';
		$c1CB = $dt['c1'];
		$cCB = $dt['c'];
		$dCB = $dt['d'];
		$eCB = $dt['e'];
		$e1CB = $dt['e1'];
	  }else{
		$this->form_caption = 'Closing EDIT';
		$readonly='readonly';
		$dataCB = $_REQUEST['refclosingdataPenyusutan_cb'];
        $CBdata = explode(' ', $dataCB[0]);
        
		$c1CB = $CBdata[0];
		$cCB =  $CBdata[1];
		$dCB =  $CBdata[2];
		$eCB =  $CBdata[3];
		$e1CB = $CBdata[4];			
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		//$kode1=genNumber($dt['c'],2);
		//$kode2=genNumber($dt['d'],2);
		//$kode3=genNumber($dt['e'],2);
		//$kode4=genNumber($dt['e1'],3);
		$ket=$dt['ket'];
		$tahun=$_COOKIE['coThnAnggaran'];

		
		//$nama_barcode=$dt['nm_barcode'];
		$status=$dt['status'];
		$Arrjbt = array(
						array('1',"Closing"),
						array('2','Open'),
		);
		
		if(empty($c1CB) || $c1CB=='00' )$c1CB = '0';
		if(empty($cCB))$cCB = '00';
		if(empty($dCB))$dCB = '00';
		if(empty($eCB))$eCB = '00';
		if(empty($e1CB))$e1CB = '000';
	
		if ($c1CB != '0') {
			$c1 = mysql_fetch_array(mysql_query("select c1, nm_skpd from ref_skpd where c1 =".$c1CB." and c =00 and d=00 and e=00 and e1=000"));

			//$dataClosing = mysql_fetch_array(mysql_query("select * from t_closing where c1 =".$c1CB." and c =00 and d=00 and e=00 and e1=000 and tgl_susut != '0000-00-00'"));
		}

		if($cCB != "00"){
			 $c = mysql_fetch_array(mysql_query("select c, nm_skpd from ref_skpd where c1 =".$c1CB." and c =".$cCB." and d=00 and e=00 and e1=000"));

			 //$dataClosing = mysql_fetch_array(mysql_query("select * from t_closing where c1 =".$c1CB." and c =".$cCB." and d=00 and e=00 and e1=000 and tgl_susut != '0000-00-00'"));
		}

		if($dCB != '00'){
			 $d = mysql_fetch_array(mysql_query("select d, nm_skpd from ref_skpd where c1 =".$c1CB." and c =".$cCB." and d=".$dCB." and e=00 and e1=000"));

			 //$dataClosing = mysql_fetch_array(mysql_query("select * from t_closing  where c1 =".$c1CB." and c =".$cCB." and d=".$dCB." and e=00 and e1=000 and tgl_susut != '0000-00-00'"));
		}
		if($eCB != '00'){
			$e = mysql_fetch_array(mysql_query("select e, nm_skpd from ref_skpd where c1 =".$c1CB." and c =".$cCB." and d=".$dCB." and e=".$eCB." and e1=000"));

			//$dataClosing = mysql_fetch_array(mysql_query("select * from t_closing  where c1 =".$c1CB." and c =".$cCB." and d=".$dCB." and e=".$eCB." and e1=000 and tgl_susut != '0000-00-00'"));
		}
		if($e1CB != '000'){
			$e1 = mysql_fetch_array(mysql_query("select e1, nm_skpd from ref_skpd where c1 =".$c1CB." and c =".$cCB." and d=".$dCB." and e=".$eCB." and e1=".$e1CB.""));
			//$dataClosing = mysql_fetch_array(mysql_query("select * from t_closing where c1 =".$c1CB." and c =".$cCB." and d=".$dCB." and e=".$eCB." and e1=".$e1CB."  and tgl_susut != '0000-00-00'"));

		}

	$aqry = "select * from t_closing where c1 ='$c1CB' and c ='$cCB' and d='$dCB' and e='$eCB' and e1='$e1CB' "; $cek .= $aqry;
	$dataClosing = mysql_fetch_array(mysql_query($aqry));

if ($dataClosing['tgl_susut'] == "") {
     	$tahunAnggaran = $tahun;
   }else{
   	  $explodeTahun = explode('-', $dataClosing['tgl_susut']);
   	  $tahunAnggaran = $explodeTahun[0];
   }     
				
	
	$arrThn = array();
	$arrThn = array(array($tahun -1, $tahun -1),array($tahun,$tahun));
	
	$vthn = cmbArray('tahun', $tahunAnggaran, $arrThn, 'Tahun' );

       //items ----------------------
		 $this->form_fields = array(
			/*'kode' => array( 
						'label'=>'Kode SKPD',
						'labelWidth'=>150, 
						//'value'=>$dt['kode'],
						//'type'=>'text',
						'value'=>
						"<input type='text' name='c' id='c' size='5' maxlength='2' value='".$kode1."' $readonly>&nbsp
						<input type='text' name='d' id='d' size='5' maxlength='2' value='".$kode2."' $readonly>&nbsp
						<input type='text' name='e' id='e' size='5' maxlength='2' value='".$kode3."' $readonly>&nbsp
						<input type='text' name='e1' id='e1' size='5' maxlength='3' value='".$kode4."' $readonly>"
						 ),*/
			 'skpd' => array( 
							'label'=>'skpd',
								'labelWidth'=>75, 
								'value'=>"<table cellspacing=0 width=100%>
										<td style='width: 27%;padding-bottom: 1%;'>URUSAN</td>
										<td style='padding-bottom: 1%;'>:</td>
										<td style='padding-bottom: 1%;'>".
										"<input type='text' value='".$c1['nm_skpd']."' readonly style='width: 100%;'> ".
										"<input type='hidden' id='c1' name='c1' value='".$c1CB."' $readonly> ".
										//cmbQuery('fmSKPD',$fmSKPD,"select c, concat(c,'. ',nm_skpd) from ref_skpd where c !=00 and d=00 and e=00",'onChange=\''.$this->Prefix.'.PilihFilter()\'','--- Semua BIDANG ---','').
										"</td>
										</tr>
										<tr>
										<td style='width: 27%;padding-bottom: 1%;'>BIDANG</td>
										<td style='padding-bottom: 1%;'>:</td>
										<td style='padding-bottom: 1%;'>".
										"<input type='text' value='".$c['nm_skpd']."' readonly style='width: 100%;'> ".
										"<input type='hidden' id='c' name='c' value='".$cCB."' $readonly> ".
										//cmbQuery('fmSKPD',$fmSKPD,"select c, concat(c,'. ',nm_skpd) from ref_skpd where c !=00 and d=00 and e=00",'onChange=\''.$this->Prefix.'.PilihFilter()\'','--- Semua BIDANG ---','').
										"</td>
										</tr>
										<tr>
										<td style='width: 27%;padding-bottom: 1%;'>SKPD</td>
										<td style='padding-bottom: 1%;'>:</td>
										<td style='padding-bottom: 1%;'>".
										"<input type='text' value='".$d['nm_skpd']."' readonly style='width: 100%;'> ".
										"<input type='hidden' id='d' name='d' value='".$dCB."'> ".
					
										//cmbQuery('fmUNIT',$fmUNIT,"select d, concat(d,'. ',nm_skpd) from ref_skpd where c =$fmSKPD and d!=00 and e=00",'onChange=\''.$this->Prefix.'.PilihFilter()\'','--- Semua ASISTEN / OPD ---','').
										"</td>
										</tr>
										<tr>
										<td style='width: 27%;padding-bottom: 1%;'>UNIT</td>
										<td style='padding-bottom: 1%;'>:</td>
										<td style='padding-bottom: 1%;'>".
									    "<input type='text' value='".$e['nm_skpd']."' readonly style='width: 100%;'> ".
										"<input type='hidden' id='e' name='e' value='".$eCB."'> ".
					
										//cmbQuery('fmSUBUNIT',$fmSUBUNIT,"select e, concat(e,'. ',nm_skpd) from ref_skpd where c =$fmSKPD and d=$fmUNIT and e!=00",'onChange=\''.$this->Prefix.'.PilihFilter()\'','--- Semua BIRO / UPTD/B ---','').
										"</td></tr>
										<tr>
										<td style='width: 27%;padding-bottom: 1%;'>SUB UNIT</td>
										<td style='padding-bottom: 1%;'>:</td>
										<td style='padding-bottom: 1%;'>".
										"<input type='hidden' id='e1' name='e1' value='".$e1CB."' > ".
										"<input type='text'  value='".$e1['nm_skpd']."' readonly style='width: 100%;'> ".
					
										//cmbQuery('fmSUBUNIT',$fmSUBUNIT,"select e, concat(e,'. ',nm_skpd) from ref_skpd where c =$fmSKPD and d=$fmUNIT and e!=00",'onChange=\''.$this->Prefix.'.PilihFilter()\'','--- Semua BIRO / UPTD/B ---','').
										"</td></tr></table>",	
								'type'=>'merge',
						),
			'tahun2' => array( 
						'label'=>'TAHUN NERACA',
						'labelWidth'=>"27%", 
						
						
						'value'=>$_COOKIE['coThnAnggaran'],
						'row_params'=>"valign='top'",
						'type'=>'' 
									 ),
			'tahun' => array( 
						'label'=>'TAHUN CLOSING',
						'labelWidth'=>"27%", 
						
						
						'value'=>$vthn,
						'row_params'=>"valign='top'",
						'type'=>'' 
									 ),
			/*'tahun' => array( 
						'label'=>'TAHUN CLOSING',
						'labelWidth'=>"27%", 
						
						
						'value'=>"<input type='text' name='tahun'  id='tahun' size='4' maxlength='4' value='".$tahunAnggaran."'style='margin-left: -3px; padding-left: 3px;width: 17%;'>",
						'row_params'=>"valign='top'",
						'type'=>'' 
									 ),
									 
				*/				

			// 'status' => array( 
			// 			'label'=>'STATUS',
			// 			'labelWidth'=>"27%", 
			// 			'value'=>cmbArray('status','',$Arrjbt,'-- Pilih Status --','style="width:100%;margin-left: -3px;"'),
						
			// 			'row_params'=>"valign='top'",
			// 			'type'=>'' 
			// 						 ),

			// 'data' => array( 
			// 			'label'=>'DATA',
			// 			'labelWidth'=>"27%", 
			// 			'value'=>'<input id="data" type="radio" name="data" value="1"><span>PEROLEHAN</span> <input id="data" type="radio" name="data" value="2"><span>PENYUSUTAN</span>',
						
			// 			'row_params'=>"valign='top'",
			// 			'type'=>'' 
			// 						 ),
			'ket' => array( 
						'label'=>'KETERANGAN',
						'labelWidth'=>"27%", 
						
						
						'value'=>"<textarea name='keterangan' id='keterangan' style='width: 100%;resize:  none;height: 80px;margin-left: -3px;'>".$dataClosing['ket']."</textarea>",
						'row_params'=>"valign='top'",
						'type'=>'' 
									 ),
			/*'barcode' => array( 
						'label'=>'Nama Barcode',
						'labelWidth'=>200, 
						
						
						'value'=>"<input type='text' name='nama_barcode' id='nama_barcode' size='50' maxlength='100' value='".$nama_barcode."'>",
						'row_params'=>"valign='top'",
						'type'=>'' 
									 ),	*/				 
			);
		//tombol
		$this->form_menubawah =	
			"<input type='hidden' name='Id_skpd' id='Id_skpd'  value='".$Id."'>".
			"<input type='hidden' name='c1nya' id='c1' value='".$c1CB."' />".
			"<input type='hidden' name='cnya' id='c' value='".$cCB."' />".
			"<input type='hidden' name='dnya' id='d' value='".$dCB."' />".
			"<input type='hidden' name='enya' id='e' value='".$eCB."' />".
			"<input type='hidden' name='e1nya' id='e1' value='".$e1CB."' />".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
			
	function setPage_HeaderOther(){
		global $Main;

	
	
	return 
			"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=refclosingdata\" title='PEROLEHAN' >PEROLEHAN</a> | 
	<A href=\"pages.php?Pg=refclosingdataPenyusutan\" title='PENYUSUTAN' style='color:blue;'>PENYUSUTAN</a>  
	|
		<A href=\"pages.php?Pg=refclosingdataHistory\" title='HISTORY'>HISTORY</a> 
	$retensi
	&nbsp&nbsp&nbsp	
	</td></tr></table>";
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox		
  	   <th class='th01' width='300' style='width: 7%;'>KODE SKPD </th>
	   <th class='th01' width='300'>Nama SKPD </th>
	   <th class='th01' width='300'>CLOSING </th>
   	   <th class='th01' width='300' style='WIDTH: 12%;'>TGL.UPDATE</th>
	   <th class='th01' width='300' style='WIDTH: 12%;'>USER ID</th>
	   <th class='th01' width='300'>KETERANGAN</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;

	 $bk = sprintf("%02s", $isi['bk']);
	 $ck = sprintf("%02s", $isi['ck']);
	 $dk = sprintf("%02s", $isi['dk']);
		


	  $c1 = mysql_fetch_array(mysql_query("select c1, nm_skpd from ref_skpd where c1 =".$isi['c1']." and c =00 and d=00 and e=00 and e1=000"));
     
     $c = mysql_fetch_array(mysql_query("select c, nm_skpd from ref_skpd where c1 =".$isi['c1']." and c =".$isi['c']." and d=00 and e=00 and e1=000"));				
	 $d = mysql_fetch_array(mysql_query("select d, nm_skpd from ref_skpd where c1 =".$isi['c1']." and c =".$isi['c']." and d=".$isi['d']." and e=00 and e1=000"));
	 $e = mysql_fetch_array(mysql_query("select e, nm_skpd from ref_skpd where c1 =".$isi['c1']." and c =".$isi['c']." and d=".$isi['d']." and e=".$isi['e']." and e1=000"));
	 $e1 = mysql_fetch_array(mysql_query("select e1, nm_skpd from ref_skpd where c1 =".$isi['c1']." and c =".$isi['c']." and d=".$isi['d']." and e=".$isi['e']." and e1=".$isi['e1'].""));
    
    if ($isi['c1'] != "0" && $isi['c'] != "00" && $isi['d'] != "00" && $isi['e'] != "00" && $isi['e1'] != "000") {
    	$kode_skpd = '<b><span style="margin-left: 2px;">'.$isi['c1'].'.'.$isi['c'].'.'.$isi['d'].'.'.$isi['e'].'.'.$isi['e1'].'</span></b>';

    	    $kd_skpd= '<b><span >'.$e1['nm_skpd'].'</span></b> 
	 			';
    }elseif ($isi['c1'] != "0" && $isi['c'] != "00" && $isi['d'] != "00" && $isi['e'] != "00") {
    	$kode_skpd = '<b><span style="margin-left: 2px;">'.$isi['c1'].'.'.$isi['c'].'.'.$isi['d'].'.'.$isi['e'].'</span></b>';

    	    $kd_skpd= '<b><span >'.$e['nm_skpd'].'</span></b> 
	 			';
    }elseif ($isi['c1'] != "0" && $isi['c'] != "00" && $isi['d'] != "00") {
    	$kode_skpd = '<b><span style="margin-left: 2px;">'.$isi['c1'].'.'.$isi['c'].'.'.$isi['d'].'</span></b>';

    	    $kd_skpd= '<b><span >'.$d['nm_skpd'].'</span></b> 
	 			';

    }elseif ($isi['c1'] != "0" && $isi['c'] != "00") {
    	$kode_skpd = '<b><span style="margin-left: 2px;">'.$isi['c1'].'.'.$isi['c'].'</span></b>';

    	    $kd_skpd= '<b><span >'.$c['nm_skpd'].'</span></b> 
	 			';
    }elseif ($isi['c1'] != "0") {
    	$kode_skpd = '<b><span style="margin-left: 2px;">'.$isi['c1'].'</span></b>';

    	    $kd_skpd= '<b><span >'.$c1['nm_skpd'].'</span></b>';
    }
    else{
    	     $kd_skpd= ''; 
    }




	 $kd_urusan=$bk.'.'.$ck.'.'.$dk;

	 $date=date_create($isi['tgl_update_susut']);	
	 $vtglUpdate = $isi['tgl_update_susut']=='' || $isi['tgl_update_susut']=='0000-00-00 00:00:00' ? '' : date_format($date,"d , M Y  -  H:i:s"); 
	$arrtgl=explode('-',$isi['tgl_susut']);
	$vthnClosing = $arrtgl[0];

 	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$kode_skpd);
	 $Koloms[] = array('align="left"',$kd_skpd);
	 $Koloms[] = array('align="left"',$vthnClosing );
	 $Koloms[] = array('align="center"',$vtglUpdate);
	 $Koloms[] = array('align="left"',$isi['uid']);
	 $Koloms[] = array('align="left"',$isi['ket']);
	 return $Koloms;
	}
	
	function genDaftarInitial($height=''){
		$vOpsi = $this->genDaftarOpsi();
		return			
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 		
				"<input type='hidden' id='RefStatusBarangMode' name='RefStatusBarangMode' value='1'>".
				//"<input type='hidden' id='".$this->Prefix."SkpdfmSKPD' name='".$this->Prefix."SkpdfmSKPD' value='$fmSKPD'>".
				//"<input type='hidden' id='".$this->Prefix."SkpdfmUNIT' name='".$this->Prefix."SkpdfmUNIT' value='$fmUNIT'>".
				//"<input type='hidden' id='".$this->Prefix."SkpdfmSUBUNIT' name='".$this->Prefix."SkpdfmSUBUNIT' value='$fmSUBUNIT'>".
				//"<input type='hidden' id='".$this->Prefix."tahun_anggaran' name='".$this->Prefix."tahun_anggaran' value='$tahun_anggaran'>".
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
	
	function genDaftarOpsi(){
	 global $Ref, $Main, $HTTP_COOKIE_VARS;
	 
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
				genFilterBar(array(WilSKPD_ajx3($this->Prefix.'SKPD2','100%','145px')),'','','').
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
					"<input $fmDESC1 type='checkbox' id='fmDESC1' name='fmDESC1' value='checked'>&nbspmenurun."
					),			
				$this->Prefix.".refreshList(true)");
			"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>";
			
		return array('TampilOpt'=>$TampilOpt);
	}				
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$arrKondisi = array();	
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		/*$ref_skpdSkpdfmSEKSI = $_REQUEST['ref_skpdSkpdfmSEKSI'];//ref_skpdSkpdfmSKPD
		$ref_skpdSkpdfmSKPD = $_REQUEST['ref_skpdSkpdfmSKPD'];
		$ref_skpdSkpdfmUNIT = $_REQUEST['ref_skpdSkpdfmUNIT'];
		$ref_skpdSkpdfmSUBUNIT = $_REQUEST['ref_skpdSkpdfmSUBUNIT'];*/
		//Cari 
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			//case 'selectKode': $arrKondisi[] = " c='".$isivalue[0]."' and d='".$isivalue[1]."' and e='".$isivalue[2]."' and e1='".$isivalue[3]."'"; break;
			case 'selectNip': $arrKondisi[] = " nip like '$fmPILCARIvalue%'"; break;
			case 'selectNama': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;	
								 	
		}	
		/*if($ref_skpdSkpdfmSKPD!='00' and $ref_skpdSkpdfmSKPD !='')$arrKondisi[]= "c='$ref_skpdSkpdfmSKPD'";
		if($ref_skpdSkpdfmUNIT!='00' and $ref_skpdSkpdfmUNIT !='')$arrKondisi[]= "d='$ref_skpdSkpdfmUNIT'";
		if($ref_skpdSkpdfmSUBUNIT!='00' and $ref_skpdSkpdfmSUBUNIT !='')$arrKondisi[]= "e='$ref_skpdSkpdfmSUBUNIT'";
		if($ref_skpdSkpdfmSEKSI!='00' and $ref_skpdSkpdfmSEKSI !='')$arrKondisi[]= "e1='$ref_skpdSkpdfmSEKSI'";*/
		/*$arrKondisi = array();		
		
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn
		$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];			
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
		//Cari 
		switch($fmPILCARI){			
			case 'selectNama': $arrKondisi[] = " nama_pasien like '%$fmPILCARIvalue%'"; break;
			case 'selectAlamat': $arrKondisi[] = " alamat like '%$fmPILCARIvalue%'"; break;						 	
		}
		if(!empty($fmFiltTglBtw_tgl1)) $arrKondisi[]= " tgl_daftar>='$fmFiltTglBtw_tgl1'";
		if(!empty($fmFiltTglBtw_tgl2)) $arrKondisi[]= " tgl_daftar<='$fmFiltTglBtw_tgl2'";	*/

		$c1input = $_COOKIE['cofmURUSAN'];
		$cinput = $_COOKIE['cofmSKPD'];
		$dinput = $_COOKIE['cofmUNIT'];
		$einput = $_COOKIE['cofmSUBUNIT'];
		$e1input = $_COOKIE['cofmSEKSI'];
		
		if($c1input != '' && $c1input != '0')$arrKondisi[] = "c1='$c1input'";
		if($cinput != '' && $cinput != '00')$arrKondisi[] = "c='$cinput'";
		if($dinput != '' && $dinput != '00')$arrKondisi[] = "d='$dinput'";
		if($einput != '' && $einput != '00')$arrKondisi[] = "e='$einput'";
		if($e1input != '' && $e1input != '000')$arrKondisi[] = "e1='$e1input'";

				$arrKondisi[] = "tgl_susut != '0000-00-00'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		$arrOrders[] = " c1,c,d,e,e1 ";
		switch($fmORDER1){
			case '1': $arrOrders[] = " nip $Asc1 " ;break;
			case '2': $arrOrders[] = " nama $Asc1 " ;break;
			
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
$refclosingdataPenyusutan = new refclosingdataPenyusutanObj();
?>