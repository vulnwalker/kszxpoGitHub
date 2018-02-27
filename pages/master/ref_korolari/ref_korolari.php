<?php

class ref_korolariObj  extends DaftarObj2{	
	var $Prefix = 'ref_korolari';
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
	var $PageTitle = 'Referensi Korolari';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	//var $fileNameExcel='ref_rekening.xls';
	var $namaModulCetak='MASTER DATA';
	var $Cetak_Judul = 'REFERENSI KOROLARI';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_korolariForm';
	var $noModul=9; 
	var $TampilFilterColapse = 0; //0
	var $WHERE_O = "";
	
	function setTitle(){
		return 'REFERENSI KOROLARI';
	}
	
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
			
				
	}
	
	function setMenuView(){
		return 
		"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png",'Halaman',"Cetak Daftar per Halaman")."</td>".			
		"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakAll(\"$Op\")","print_f2.png",'Semua',"Cetak Semua Daftar")."</td>";
			
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
	
	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
     $nama_rekening = $_REQUEST['nama'];
	
	$kode_rekening= $_REQUEST['kode_rekening'];
	$kode_debet= $_REQUEST['kode_debet'];
	$kode_kredit= $_REQUEST['kode_kredit'];
	/*$n= $_REQUEST['fmKD'];
	$o= $_REQUEST['ke'];*/
	
	 if( $err=='' && $kode_rekening =='' ) $err= 'Kode Korolasi Belum Di Isi !!';
	 if( $err=='' && $kode_debet =='' ) $err= 'Kode Rekening Debet Belum Di Isi !!';
	 if( $err=='' && $kode_kredit =='' ) $err= 'Kode Rekening Kredit Belum Di Isi !!';
	
	$kode_rekening_1 = explode('.',$kode_rekening);
						 $k=$kode_rekening_1[0];
						 $l=$kode_rekening_1[1];
						 $m=$kode_rekening_1[2];
						 $n=$kode_rekening_1[3];
						 $o=$kode_rekening_1[4];
						 
	$kode_debet_1 = explode('.',$kode_debet);
						 $dk=$kode_debet_1[0];
						 $dl=$kode_debet_1[1];
						 $dm=$kode_debet_1[2];
						 $dn=$kode_debet_1[3];
						 $do=$kode_debet_1[4];
						 
	$kode_kredit_1 = explode('.',$kode_kredit);
						 $kk=$kode_kredit_1[0];
						 $kl=$kode_kredit_1[1];
						 $km=$kode_kredit_1[2];
						 $kn=$kode_kredit_1[3];
						 $ko=$kode_kredit_1[4];
	 	
	
	if($fmST == 0){
		if($err==''){
		$aqry = "UPDATE ref_rekening SET debet_k='$dk',debet_l='$dl',debet_m='$dm',debet_n='$dn',debet_o='$do',kredit_k='$kk',kredit_l='$kl',kredit_m='$km',kredit_n='$kn',kredit_o='$ko' WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o'";	$cek .= $aqry;
		$qry = mysql_query($aqry);
				}
			}else{						
				if($err==''){
				$aqry = "UPDATE ref_rekening SET debet_k='$dk',debet_l='$dl',debet_m='$dm',debet_n='$dn',debet_o='$do',kredit_k='$kk',kredit_l='$kl',kredit_m='$km',kredit_n='$kn',kredit_o='$ko' WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());				
					}
			} 
					
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
		
		case 'simpanEdit':{
			$get= $this->simpanEdit();
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

	function setPage_OtherScript(){
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
					</script>";
		return 
			 "<script src='js/skpd.js' type='text/javascript'></script>
			 <script type='text/javascript' src='js/master/ref_korolari/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
			 <script type='text/javascript' src='js/master/ref_korolari/filter_rekening.js' language='JavaScript' ></script>
			 <script type='text/javascript' src='js/master/ref_rekening/cari_rekening.js' language='JavaScript' ></script>
			 ".
			$scriptload;
	}
	
	//form ==================================
		
	function setFormBaru(){
		
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek = $cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$dt=array();
		$this->form_fmST = 0;
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
   
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
	
	function setFormEditdata($dt){	
	global $SensusTmp, $Main;
	 $cek = ''; $err=''; $content='';

	 $json = TRUE;	//$ErrMsg = 'tes';

	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 800;
	 $this->form_height = 120;
	
	 	$this->form_caption = 'EDIT REFERENSI KOROLARI ';
		
		$kode_rekening=$dt['k'].'.'.$dt['l'].'.'.$dt['m'].'.'.$dt['n'].'.'.$dt['o'];
		$nm_rekening=mysql_fetch_array(mysql_query("select * from ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m='".$dt['m']."' and n='".$dt['n']."' and o='".$dt['o']."'"));
		$kode_debet=$dt['debet_k'].'.'.$dt['debet_l'].'.'.$dt['debet_m'].'.'.$dt['debet_n'].'.'.$dt['debet_o'];
		$kode_kredit=$dt['kredit_k'].'.'.$dt['kredit_l'].'.'.$dt['kredit_m'].'.'.$dt['kredit_n'].'.'.$dt['kredit_o'];
		$debet=mysql_fetch_array(mysql_query("select * from ref_rekening where k='".$dt['debet_k']."' and l='".$dt['debet_l']."' and m='".$dt['debet_m']."' and n='".$dt['debet_n']."' and o='".$dt['debet_o']."'"));
		$kredit=mysql_fetch_array(mysql_query("select * from ref_rekening where k='".$dt['kredit_k']."' and l='".$dt['kredit_l']."' and m='".$dt['kredit_m']."' and n='".$dt['kredit_n']."' and o='".$dt['kredit_o']."'"));
	
       //items ----------------------
		   $this->form_fields = array(
		
		'kdRekening' => array(
		'label'=>'REKENING KOROLARI',
		'labelWidth'=>150,
		'value'=>"<input type='text' name='kode_rekening' value='".$kode_rekening."' size='10px' id='kode_rekening' readonly>&nbsp
					<input type='text' name='nama_rekening' value='".$nm_rekening['nm_rekening']."' size='73px' id='nama_rekening' readonly>"
									 ),
		'kd_akun' => array(
		'label'=>'REKENING DEBET',
		'labelWidth'=>100,
		'value'=>"
			<input type='text' name='kode_debet' value='".$kode_debet."' size='10px' id='kode_debet' readonly>&nbsp
			<input type='text' name='nama_debet' value='".$debet['nm_rekening']."' size='73px' id='nama_debet' readonly>&nbsp
			<input type='button' value='Cari' onclick ='".$this->Prefix.".cari_debet()'  title='Cari Kode Akun' >"
									 ),
		'mapping1' => array(
		'label'=>'REKENING KREDIT',
		'labelWidth'=>100,
		'value'=>"
			<input type='text' name='kode_kredit' value='".$kode_kredit."' size='10px' id='kode_kredit' readonly>&nbsp
			<input type='text' name='nm_kredit' value='".$kredit['nm_rekening']."' size='73px' id='nm_kredit' readonly>&nbsp
			<input type='button' value='Cari' onclick ='".$this->Prefix.".cari_kredit()'  title='Cari Kode Akun Mapping 1' >"
									 ),
		
		);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' > &nbsp &nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
		
	function setForm($dt){	
	 global $SensusTmp, $Main;
	 $cek = ''; $err=''; $content='';

	 $json = TRUE;	//$ErrMsg = 'tes';

	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 800;
	 $this->form_height = 120;
	
	 if ($this->form_fmST==0){
	 	$this->form_caption = 'BARU REFERENSI KOROLARI ';
	 }else{
	 	$this->form_caption = 'EDIT REFERENSI KOROLARI ';
		
		$kode_rekening=$dt['k'].'.'.$dt['l'].'.'.$dt['m'].'.'.$dt['n'].'.'.$dt['o'];
		$nm_rekening=mysql_fetch_array(mysql_query("select * from ref_rekening where k='".$dt['k']."' and l='".$dt['l']."' and m='".$dt['m']."' and n='".$dt['n']."' and o='".$dt['o']."'"));
		$kode_debet=$dt['debet_k'].'.'.$dt['debet_l'].'.'.$dt['debet_m'].'.'.$dt['debet_n'].'.'.$dt['debet_o'];
		$kode_kredit=$dt['kredit_k'].'.'.$dt['kredit_l'].'.'.$dt['kredit_m'].'.'.$dt['kredit_n'].'.'.$dt['kredit_o'];
		$debet=mysql_fetch_array(mysql_query("select * from ref_rekening where k='".$dt['debet_k']."' and l='".$dt['debet_l']."' and m='".$dt['debet_m']."' and n='".$dt['debet_n']."' and o='".$dt['debet_o']."'"));
		$kredit=mysql_fetch_array(mysql_query("select * from ref_rekening where k='".$dt['kredit_k']."' and l='".$dt['kredit_l']."' and m='".$dt['kredit_m']."' and n='".$dt['kredit_n']."' and o='".$dt['kredit_o']."'"));
	 }
	
		
       //items ----------------------
		  $this->form_fields = array(
		
		'kdRekening' => array(
		'label'=>'REKENING KOROLARI',
		'labelWidth'=>150,
		'value'=>"<input type='text' name='kode_rekening' value='".$kode_rekening."' size='10px' id='kode_rekening' readonly>&nbsp
					<input type='text' name='nama_rekening' value='".$nm_rekening['nm_rekening']."' size='73px' id='nama_rekening' readonly>&nbsp
				
					<input type='button' value='Cari' onclick ='".$this->Prefix.".cr_rekening()'  title='Cari Kode Rekening' >"
									 ),
		'kd_akun' => array(
		'label'=>'REKENING DEBET',
		'labelWidth'=>100,
		'value'=>"
			<input type='text' name='kode_debet' value='".$kode_debet."' size='10px' id='kode_debet' readonly>&nbsp
			<input type='text' name='nama_debet' value='".$debet['nm_rekening']."' size='73px' id='nama_debet' readonly>&nbsp
			<input type='button' value='Cari' onclick ='".$this->Prefix.".cari_debet()'  title='Cari Kode Akun' >"
									 ),
		'mapping1' => array(
		'label'=>'REKENING KREDIT',
		'labelWidth'=>100,
		'value'=>"
			<input type='text' name='kode_kredit' value='".$kode_kredit."' size='10px' id='kode_kredit' readonly>&nbsp
			<input type='text' name='nm_kredit' value='".$kredit['nm_rekening']."' size='73px' id='nm_kredit' readonly>&nbsp
			<input type='button' value='Cari' onclick ='".$this->Prefix.".cari_kredit()'  title='Cari Kode Akun Mapping 1' >"
									 ),
		
		);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' > &nbsp &nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $margin =  'style="margin-left:20px;"';
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox		
	
	   <th class='th01' width='900' align='cente'>REKENING KOROLARI</th>
	   <th class='th01' width='900' align='cente'>REKENING DEBET</th>
	   <th class='th01' width='900' align='cente'>REKENING KREDIT</th>
	  
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
	
	 $dat_rekening=$isi['k'].'.'.$isi['l'].'.'.$isi['m'].'.'.$isi['n'].'.'.$nilai_o;
	 $nm_rekening=$isi['nm_rekening'];
	 
	 $data_rekening=$dat_rekening.'<br>'.$nm_rekening;
	 if($isi['debet_k']==''){
	 	 $kode='';
	 }else{
	 	 $kode=$isi['debet_k'].'.'.$isi['debet_l'].'.'.$isi['debet_m'].'.'.$isi['debet_n'].'.'.$isi['debet_o'];
	 }
	 
	 if($isi['kredit_k']==''){
	 	$kode1='';
	 }else{
	 	$kode1=$isi['kredit_k'].'.'.$isi['debet_l'].'.'.$isi['debet_m'].'.'.$isi['debet_n'].'.'.$isi['debet_o'];
	 }
	 
	$nm_rekening1=mysql_fetch_array(mysql_query("select * from ref_rekening where k='".$isi['debet_k']."' and l='".$isi['debet_l']."' and m='".$isi['debet_m']."' and n='".$isi['debet_n']."' and o='".$isi['debet_o']."'"));
	$nm_rekening2=mysql_fetch_array(mysql_query("select * from ref_rekening where k='".$isi['kredit_k']."' and l='".$isi['kredit_l']."' and m='".$isi['kredit_m']."' and n='".$isi['kredit_n']."' and o='".$isi['kredit_o']."'"));

	$data_jurnal1=$kode.' <br>'.$nm_rekening1['nm_rekening'];
	$data_jurnal2=$kode2.' <br> '.$nm_rekening2['nm_rekening'];
	
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',"<span style='color:black;font-size:12px;font-weight:bold;'>".$dat_rekening."</span>".'<br>'.$nm_rekening);
	 $Koloms[] = array('align="left"',"<span style='color:black;font-size:12px;font-weight:bold;'>".$kode."</span>".'<br>'.$nm_rekening1['nm_rekening']);
	 $Koloms[] = array('align="left"',"<span style='color:black;font-size:12px;font-weight:bold;'>".$kode1."</span>".'<br>'.$nm_rekening2['nm_rekening']);
	 
		 
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
		
	$arrayRekening = array(
								array('5', '5.BELANJA'),
								array('7', '7.PERHITUNGAN FIHAK KETIGA (PFK)'),
								);
	$filterRekening = $_REQUEST['filterRekening'];					
	$comboJenisBarang = cmbArray('filterRekening',$filterRekening,$arrayRekening,'Pilih',"onchange = $this->Prefix.refreshList(true);");	
	
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
			cmbQuery1("fmKELOMPOK",$fmKELOMPOK,"select l,nm_rekening from ref_rekening where k='$filterRekening' and l !='0' and m = '0' and n='00' and o='00'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SUB KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBKELOMPOK",$fmSUBKELOMPOK,"select m,nm_rekening from ref_rekening where k='$filterRekening' and l ='$fmKELOMPOK' and m != '0' and n='00' and o='00'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
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
			cmbQuery1("fmKELOMPOK",$fmKELOMPOK,"select l,nm_rekening from ref_rekening where k='$filterRekening' and l !='0' and m = '0' and n='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SUB KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBKELOMPOK",$fmSUBKELOMPOK,"select m,nm_rekening from ref_rekening where k='$filterRekening' and l ='$fmKELOMPOK' and m != '0' and n='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SUB SUB KELOMPOK</td><td>:</td>
			<td>".
			cmbQuery1("fmSUBSUBKELOMPOK",$fmSUBSUBKELOMPOK,"select n,nm_rekening from ref_rekening where k='$filterRekening' and l ='$fmKELOMPOK' and m = '$fmSUBKELOMPOK' and n!='00' and o='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
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
	 	$filterRekening = $_REQUEST['filterRekening'];
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
		
		if(empty($filterRekening)) {
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
		
		if(empty($filterRekening) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k in(5,7) and l!=0 and m!=0 and n!=0 and o!=0";	
		}
		elseif(!empty($filterRekening) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k =$filterRekening and l!=0 and m!=0 and n!=0 and o!=0";			
		}
		elseif(!empty($filterRekening) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k =$filterRekening and l=$fmKELOMPOK and m!=0 and n!=0 and o!=0";
						
		}
		elseif(!empty($filterRekening) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k =$filterRekening and l=$fmKELOMPOK and m=$fmSUBKELOMPOK and n!=0 and o!=0";
							
		}
		elseif(!empty($filterRekening) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "k =$filterRekening and l=$fmKELOMPOK and m=$fmSUBKELOMPOK and n=$fmSUBSUBKELOMPOK and o!=0";
			
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
$ref_korolari = new ref_korolariObj();
?>