<?php

class ref_nm_pejabat_spObj  extends DaftarObj2{	
	var $Prefix = 'ref_nm_pejabat_sp';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_nm_pejabat_sp'; //bonus
	var $TblName_Hapus = 'ref_nm_pejabat_sp';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Nama Pejabat';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='Pangkat.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'ref_nm_jabatan_sp';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ref_nm_pejabat_spForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	var $stGol = array(
			array('1','I'), 
			array('2','II'),
			array('3','III'),
			array('4','IV'),
		);
		
	var $stJabatan = array(
			array('1','STRUKTURAL'), 
			array('2','FUNGNSIONAL'),
			array('3','FUNGNSIONAL UMUM'),
		);
		
	var $stStatus = array(
			array('1','Aktif'), 
			array('2','Tidak Aktif'),
		);	
		
	var $stRuang = array(
			array('a','a'), 
			array('b','b'),
			array('c','c'),
			array('d','d'),
			array('e','e'),
		);
		
	function setTitle(){
		if ($_REQUEST['hal']=='1'){
			$jns='PA/KPA';
		}elseif($_REQUEST['hal']=='2'){
			$jns='Pembuat Komitmen';
		}elseif($_REQUEST['hal']=='3'){
			$jns='PPTK';
		}elseif($_REQUEST['hal']=='4'){
			$jns='Bendahara Pengeluaran Pembantu';
		}elseif($_REQUEST['hal']=='5'){
			$jns='Bendahara Pengeluaran';
		}elseif($_REQUEST['hal']=='6'){
			$jns='Bendahara Umum Daerah';
		}
		return 'Referensi Nama Pejabat '.$jns;
	}
	
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
	}
	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];	 
	 $c1 = $_REQUEST['c1']; 
	 $c = $_REQUEST['c'];
	 $d = $_REQUEST['d'];
	 $nama = $_REQUEST['nama'];
	 $nip = $_REQUEST['nip'];
	 $fmJabatan = $_REQUEST['fmJabatan'];
	 $jns = $_REQUEST['jns'];
	 	 
	 if( $err=='' && $nip =='' ) $err= 'NIP Belum di Isi !!';
	 if( $err=='' && $nama =='' ) $err= 'Nama Belum Di Isi !!';
	 if( $err=='' && $fmJabatan =='' ) $err= 'Jabatan Belum Di Pilih !!';
	
	 		
				
			if($fmST == 0){
			
				/*$get2=mysql_fetch_array(mysql_query("SELECT toRoman(gol) as gol,ruang FROM ref_pangkat  WHERE gol='$gol' and ruang='$ruang'"));
				$get = mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ref_pangkat WHERE gol='$gol' and ruang='$ruang'"));
				if($get['cnt']>0 ) $err='Golongan "'.$get2['gol'].'" Ruang "'.$get2['ruang'].'" Sudah Ada !';*/
			
				if($err==''){
					$aqry = "INSERT into ref_nm_pejabat_sp (c1,c,d,nip,nama,jabatan,jns) values('$c1','$c','$d','$nip','$nama','$fmJabatan','$jns')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{
			
				

						if($err==''){
					//	$aqry = "UPDATE ref_jabatan set c1='$c1',c='$c',d='$d',jns_jabatan='$jns_jbt',nama='$ruang',nama='$nm_jbt',jumlah='$jumlah',status='$status' where Id='".$idplh."'";	$cek .= $aqry;
						$aqry = "UPDATE ref_nm_pejabat_sp set jabatan='$fmJabatan',nama='$nama',nip='$nip' where Id='".$idplh."'";	$cek .= $aqry;
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
		
		case 'BidangAfterForm':{
			 $kondisiBidang = "";
			 $selectedUrusan = $_REQUEST['fmSKPDUrusan'];
			 $selectedBidang = $_REQUEST['fmSKPDBidang'];
			 
			 $codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) as vnama from ref_skpd where d='00' and c ='00' order by c1";
		
		     $codeAndNameBidang = "SELECT c, concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where d = '00' and e = '00' and c!='00'and c1 = '$selectedUrusan'  and e1='000'";	
		
		     $codeAndNameskpd = "SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd  where c='$selectedBidang' and c1='$selectedUrusan' and d != '00' and  e = '00' and e1='000' ";
			
			
				$bidang =  cmbQuery('cmbBidangForm', $selectedBidang, $codeAndNameBidang,' '.$cmbRo.' onChange=\''.$this->Prefix.'.BidangAfterform()\'','-- Pilih Semua --');	
				$skpd = cmbQuery('cmbSKPDForm', $selectedskpd, $codeAndNameskpd,''.$cmbRo.'','-- Pilih Semua --');
				$content = array('bidang' => $bidang, 'skpd' =>$skpd ,'queryGetBidang' => $kondisiBidang);
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
		case 'hapus':{ //untuk ref_kota
					$idplh= $_REQUEST['Id'];		
					$get= $this->Hapus();
					$err= $get['err']; 
					$cek = $get['cek'];
					$json=TRUE;	
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
   
   function Hapus($ids){ //validasi hapus ref_kota
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++)	{
			if($err=='' ){
					$qy = "DELETE FROM ref_nm_pejabat_sp WHERE Id='".$ids[$i]."' ";$cek.=$qy;
					$qry = mysql_query($qy);
						
			}else{
				break;
			}			
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
			<script type='text/javascript' src='js/master/ref_nm_pejabat_sp/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			$scriptload;
	}
	
	//form ==================================
	function setFormBaru(){
	
		global $HTTP_COOKIE_VARS;
		global $Main;
	
	 $err=''; 
	 
		$fmURUSAN = $_REQUEST['fmURUSAN'];
	 	$fmBIDANG = $_REQUEST['fmBIDANG'];
     	$fmSKPD = $_REQUEST['fmSKPD'];
		
		
		if( $err=='' && $fmURUSAN =='' ) $err= 'Urusan Belum Dipilih !!';
	 	if( $err=='' && $fmBIDANG =='' ) $err= 'Bidang Belum Dipilih !!';
	 	if( $err=='' && $fmSKPD =='' ) $err= 'SKPD Belum Dipilih !!';
		
		if($err=='' ){
			$dt=array();
			$this->form_fmST = 0;
			$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		
		$fm = $this->setForm($dt);	
		}
		
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'].$err, 'content'=>$fm['content']);
	}
   
  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  ref_nm_pejabat_sp WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	s 	
	 $form_name = $this->Prefix.'_form';
	 
				
	 $this->form_width = 450;
	 $this->form_height = 160;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'FORM BARU PEJABAT';
		
	 $fmURUSAN = $_REQUEST['fmURUSAN'];
	 $fmBIDANG = $_REQUEST['fmBIDANG'];
     $fmSKPD = $_REQUEST['fmSKPD'];
	 $jns = $_REQUEST['hal']; 
	 
		$cmbRo = '';
	  }else{
		$this->form_caption = 'FORM EDIT JABATAN';	
		$kode = $dt['kode'];				
		$namapenyedia = $dt['nama_program_kegiatan'];
		$dt['urusan'] = $dt['c1'];	
		$dt['bidang'] = $dt['c'];	
		$dt['skpd'] = $dt['d'];
		$cmbRo = 'disabled';	
		$fmURUSAN = $dt['c1'];
		$fmBIDANG = $dt['c'];
     	$fmSKPD =  $dt['d'];


	  }
	    //ambil data trefditeruskan
		
		$query_c1=mysql_fetch_array(mysql_query("SELECT c1, nm_skpd FROM ref_skpd WHERE c1='$fmURUSAN' and c='00' and d='00'")) ;
		$query_c=mysql_fetch_array(mysql_query("SELECT c, nm_skpd FROM ref_skpd WHERE c1='$fmURUSAN' and c='$fmBIDANG' and d='00'")) ;
		$query_d=mysql_fetch_array(mysql_query("SELECT d, nm_skpd FROM ref_skpd WHERE c1='$fmURUSAN' and c='$fmBIDANG' and d='$fmSKPD'")) ;
		
		$dat_c1=$query_c1['c1'].".  ".$query_c1['nm_skpd'];
		$dat_c=$query_c['c'].".  ".$query_c['nm_skpd'];
		$dat_d=$query_d['d'].".  ".$query_d['nm_skpd'];
		
		$queryJabatan = "SELECT nama,nama FROM ref_jabatan";
		
    	
	
	 //items ----------------------
	  $this->form_fields = array(
	  	  	'kode0' => array(
	  					'label'=>'URUSAN',
						'labelWidth'=>50, 
						'value'=> "<input type='text' name='nm_jbt' id='nm_jbt' value='$dat_c1' style='width:350px; 'readonly>
						<input type='hidden' name='c1' id='c1' value='".$query_c1['c1']."' style='width:350px;'>",
						 ),
	  		'kode1' => array(
	  					'label'=>'BIDANG',
						'labelWidth'=>50, 
						'value'=> "<input type='text' name='nm_jbt' id='nm_jbt' value='$dat_c' style='width:350px; 'readonly>
						<input type='hidden' name='c' id='c' value='".$query_c['c']."' style='width:350px;'>",
						 ),
			'kode2' => array( 
						'label'=>'SKPD',
						'labelWidth'=>50, 
						'value'=> "<input type='text' name='nm_jbt' id='nm_jbt' value='$dat_d' style='width:350px; 'readonly>
						<input type='hidden' name='d' id='d' value='".$query_d['d']."' style='width:350px;'>",
						 ),
			
			'nip' => array( 
						'label'=>'NIP',
						'labelWidth'=>50, 
						'value'=> "<input type='text' name='nip' id='nip' value='".$dt['nip']."' style='width:250px; '>",
						 ),
			
			
			'nama' => array( 
						'label'=>'NAMA',
						'labelWidth'=>50, 
						'value'=>"<input type='text' name='nama' id='nama' value='".$dt['nama']."' style='width:250px;'>",
					
						 ),		
			
			'jabatan' => array( 
						'label'=>'JABATAN',
						'labelWidth'=>50, 
						'value'=>
						cmbQuery('fmJabatan',$dt['jabatan'],$queryJabatan,'','-------- Pilih --------')
					
					
						 ),					 			 
									
			);
		//tombol
		$this->form_menubawah =
			"<input type='hidden' name='jns' id='jns' value='".$jns."'>".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >  &nbsp  ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setPage_HeaderOther(){
	$setnya = '';
	$setnya1 = '';
	$setnya2 = '';
	$setnya3 = '';
	$setnya4 = '';
	$setnya5 = '';
	if($_REQUEST['hal'] == '1')$setnya = "style='color:blue' ";
	if($_REQUEST['hal'] == '2')$setnya1 = "style='color:blue' ";
	if($_REQUEST['hal'] == '3')$setnya2 = "style='color:blue' ";
	if($_REQUEST['hal'] == '4')$setnya3 = "style='color:blue' ";
	if($_REQUEST['hal'] == '5')$setnya4 = "style='color:blue' ";
	if($_REQUEST['hal'] == '6')$setnya5 = "style='color:blue' ";
	
	if(!isset($_REQUEST['hal']))$setnya = "style='color:blue' ";
	return 
		"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
			<tr>
				<td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
					
					<A href=\"pages.php?Pg=ref_nm_pejabat_sp&hal=1\" title='PA/KPA' $setnya >PA/KPA</a> | 
					<A href=\"pages.php?Pg=ref_nm_pejabat_sp&hal=2\" title='Pembuat Komitmen' $setnya1 >Pembuat Komitmen</a>  |
					<A href=\"pages.php?Pg=ref_nm_pejabat_sp&hal=3\" title='PPTK' $setnya2 >PPTK</a> |
					<A href=\"pages.php?Pg=ref_nm_pejabat_sp&hal=4\" title='Bendahara Pengeluaran Pembantu' $setnya3 >Bendahara Pengeluaran Pembantu</a> |
					<A href=\"pages.php?Pg=ref_nm_pejabat_sp&hal=5\" title='Bendahara Pengeluaran' $setnya4 >Bendahara Pengeluaran</a> |
					<A href=\"pages.php?Pg=ref_nm_pejabat_sp&hal=6\" title='Bendahara Umum Daerah' $setnya5 >Bendahara Umum Daerah</a> 
					&nbsp&nbsp&nbsp	
				</td>
			</tr>
		</table>";
	}
			
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='10' >No.</th>
  	   $Checkbox		
	   <th class='th01' width='900'>SKPD</th>
	   <th class='th01' width='300'>NIP</th>
	   <th class='th01' width='800'>Nama</th>
	   <th class='th01' width='900'>Jabatan</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 $c1=$isi['c1'];
	 $c=$isi['c'];
	 $d=$isi['d'];
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 
	 $skpd=mysql_fetch_array(mysql_query("select c1,c,d,nm_skpd from ref_skpd where c1='$c1' and c='$c' and d='$d'"));
	
	 $Koloms[] = array('align="left"',$skpd['nm_skpd']);
	 $Koloms[] = array('align="left"',$isi['nip']);
	 $Koloms[] = array('align="left"',$isi['nama']);
	 $Koloms[] = array('align="left"',$isi['jabatan']);
	
	 return $Koloms;
	}
	
		
	function setMenuView(){
		
			}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;	 
	
	$fmURUSAN = cekPOST('fmURUSAN');
	$fmBIDANG = cekPOST('fmBIDANG');
	$fmSKPD = cekPOST('fmSKPD');
	$fmKODE = cekPOST('fmKODE');
	$fmNMURUSAN = cekPOST('fmNMURUSAN');		
		
		
	$TampilOpt = 
			//"<tr><td>".	
			"<div class='FilterBar'>".			
			"<table style='width:100%'>
			<tr>
			<td style='width:120px'>URUSAN</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery1("fmURUSAN",$fmURUSAN,"select c1,nm_skpd from ref_skpd where c1<>'0' and c='00' ","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>BIDANG</td><td>:</td>
			<td>".
			cmbQuery1("fmBIDANG",$fmBIDANG,"select c,nm_skpd from ref_skpd where c1='$fmURUSAN' and c<>'00' and d='00' ","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SKPD</td><td>:</td>
			<td>".
			cmbQuery1("fmSKPD",$fmSKPD,"select d,nm_skpd from ref_skpd where c1='$fmURUSAN' and c ='$fmBIDANG' and d!='00' and e='00' and e1='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			
			</table>".
			"</div>".
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			
			</table>".
			"</div>";		
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		$hala = $_REQUEST['hal'];
		$arrKondisi[] = "jns=$hala";	
		$fmURUSAN = cekPOST('fmURUSAN');
		$fmBIDANG = cekPOST('fmBIDANG');
		$fmSKPD = cekPOST('fmSKPD');
		$fmKODE = cekPOST('fmKODE');
		$fmNMURUSAN = cekPOST('fmNMURUSAN');
		
		if(empty($fmURUSAN)) {
			$fmBIDANG = '';
			$fmSKPD='';
		}
		if(empty($fmBIDANG)) {
			$fmSKPD='';
		}
		
		/*if(empty($fmURUSAN) && empty($fmBIDANG) && empty($fmSKPD))
		{
			
		}
		elseif(!empty($fmURUSAN) && empty($fmBIDANG) && empty($fmSKPD))
		{
			$arrKondisi[]= "c1 =$fmURUSAN";
		}
		elseif(!empty($fmURUSAN) && !empty($fmBIDANG) && empty($fmSKPD))
		{
			$arrKondisi[]= "c1 =$fmURUSAN and c=$fmBIDANG";
		}
		elseif(!empty($fmURUSAN) && !empty($fmBIDANG) && !empty($fmSKPD))
		{
			$arrKondisi[]= "c1 =$fmURUSAN and c=$fmBIDANG and d=$fmSKPD and e='00' and e1='000'";		
		}*/
		
		/*if(!empty($_POST['fmKODE'])) $arrKondisi[] = " concat(bk,ck,dk) like '".str_replace('.','',$_POST['fmKODE'])."%'";					
		if(!empty($_POST['fmAKUN'])) $arrKondisi[] = " nm_urusan like '%".$_POST['fmAKUN']."%'";*/

 			
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			/*case '': $arrOrders[] = " concat(bk,ck,dk) ASC " ;break;
			case '1': $arrOrders[] = " concat(bk,ck,dk) $Asc1 " ;break;
			case '2': $arrOrders[] = " nm_urusan $Asc1 " ;break;*/
		
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
	
	function pageShow(){
		global $app, $Main, $DataOption; 
		
		$navatas_ = $this->setNavAtas();
		$navatas = $navatas_==''? // '0': '20';
			'':
			"<tr><td height='20'>".
					$navatas_.
			"</td></tr>";
		$form1 = $this->withform? "<form name='$this->FormName' id='$this->FormName' method='post' action=''>" : '';
		$form2 = $this->withform? "</form >": '';
		
		$hal='1';
		if (isset($_REQUEST['hal'])) if ($_REQUEST['hal']!='') $hal=$_REQUEST['hal']; 
				
		
		return
		
					
		"<html>".
			$this->genHTMLHead().
			"<body >".
			
							
			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0' width='100%' height='100%' >".
				//header page -------------------		
				"<tr height='34'><td>".					
					
					$this->setPage_Header().
					"<div id='header' ></div>".
				"</td></tr>".	
				$navatas.			
				
				"<tr height='*' valign='top'> <td >".
					
					$this->setPage_HeaderOther().
					"<div align='center' class='centermain' >".
					"<div class='main' >".
					$form1.
					"<input type='hidden' name='hal' value='".$hal."' />".
					
											
						$this->setPage_Content().
						
						
					$form2.//"</form>".
					"</div></div>".
				"</td></tr>".
				//$OtherContentPage.				
				//Footer ------------------------
				"<tr><td height='29' >".	
					//$app->genPageFoot(FALSE).
					$Main->CopyRight.							
				"</td></tr>".
				$OtherFooterPage.
			"</table>".
			
			"</body>
		</html>"; 
	}	
	
}
$ref_nm_pejabat_sp = new ref_nm_pejabat_spObj();
?>