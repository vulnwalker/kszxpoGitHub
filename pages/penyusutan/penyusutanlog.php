<?php

class PenyusutanLogObj  extends DaftarObj2{	
	var $Prefix = 'PenyusutanLog';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'penyusutan_log'; //daftar
	var $TblName_Hapus = 'penyusutan_log';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('sesi');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'PENYUSUTAN LOG';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal =10;
	var $cetak_xls=TRUE ;
	var $fileNameExcel='Penyusutan.xls';
	var $Cetak_Judul = 'Penyusutan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'PenyusutanLogForm'; 
	var $kdbrg = '';
			
	function setTitle(){
		return 'PENYUSUTAN LOG';
	}
	function setMenuEdit(){		
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus').
			"</td>";
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
	
	function simpan(){
	
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
     $kode1= $_REQUEST['f'];
	 $kode2= $_REQUEST['g'];
	 $kode3= $_REQUEST['h'];
	 $kode4= $_REQUEST['i'];
	 $kode5= $_REQUEST['j'];
	// $nama_barang = $_REQUEST['nm_barang'];
	 $residu = $_REQUEST['residu'];
	 $masa_manfaat = $_REQUEST['masa_manfaat'];
	 $tahun = $_REQUEST['tahun'];
	
	 
	 if( $err=='' && $kode1 =='' ) $err= 'Kode 1 Belum Di Isi !!';
	 if( $err=='' && $kode2 =='' ) $err= 'Kode 2 Belum Di Isi !!';
	 if( $err=='' && $kode3 =='' ) $err= 'Kode 3 Belum Di Isi !!';
	 if( $err=='' && $kode4 =='' ) $err= 'Kode 4 Belum Di Isi !!';
	 if( $err=='' && $kode5 =='' ) $err= 'Kode 5 Belum Di Isi !!';
	// if( $err=='' && $nama_barang =='' ) $err= 'Nama Barang Belum Di Isi !!';
	// if( $err=='' && $nilai_sisa =='' ) $err= 'Estimasi nilai sisa Belum Di Isi !!';
	// if( $err=='' && $masa_manfaat =='') $err= 'Estimasi masa manfaat Belum Di Isi !!';
	 	
	
	/*if(strlen($kode1)!=2 || strlen($kode2)!=2 || strlen($kode3)!=2 || strlen($kode4)!=2 ||strlen($kode5)!=3) $err= 'Format Kode SKPD salah bro';	
			for($j=0;$j<5;$j++){
	//urutan kode skpd 	
		if($j==0){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_penyusutan where f!='00' and g ='00' and h ='00' and i ='00' and j ='000' Order By f DESC limit 1"));
			if($kode1=='00') {$err= 'Format Kode salah';}
			elseif($kode1>sprintf("%02s",$ck['f']+1)){ $err= 'Format Kode berurutan';}
				
		}elseif($j==1){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_penyusutan where f='".$kode1."' and g !='00' and h ='00' and i ='00' and j ='000' Order By g DESC limit 1"));	
			if ($kode2>sprintf("%02s",$ck['g']+1)) {$err= 'Format Kode bidang Harus berurutan';}		
			
		}elseif($j==2){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_penyusutan where f='".$kode1."' and g ='".$kode2."' and h !='00' and i ='00' and j ='000' Order By h DESC limit 1"));			
			if ($kode3>sprintf("%02s",$ck['h']+1)) {$err= 'Format Kode kelompok Harus berurutan';}		
				
		}elseif($j==3){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_penyusutan where f='".$kode1."' and g ='".$kode2."' and h ='".$kode3."' and i!='00' and j='000' Order By i DESC limit 1"));	
			if ($kode4>sprintf("%02s",$ck['i']+1)) {$err= 'Format Kode sub kelompok Harus berurutan';}
		
		}elseif($j==4){
			$ck=mysql_fetch_array(mysql_query("Select * from ref_penyusutan where f='".$kode1."' and g ='".$kode2."' and h ='".$kode3."' and i ='".$kode4."' and j!='000' Order By j DESC limit 1"));	
			if ($kode5>sprintf("%02s",$ck['j']+1)) {$err= 'Format Kode Sub sub kelompok Harus berurutan';}
				
				
		}
	 }*/
	 
			
			
			if($fmST == 0){
			$ck1=mysql_fetch_array(mysql_query("Select * from ref_penyusutan where f='$kode1' and g ='$kode2' and h ='$kode3' and i='$kode4' and j='$kode5'"));
			if ($ck1>=1)$err= 'Gagal Simpan'.mysql_error();
				if($err==''){
					$aqry = "INSERT into ref_penyusutan (f,g,h,i,j,residu,masa_manfaat,tahun) values('$kode1','$kode2','$kode3','$kode4','$kode5','$residu','$masa_manfaat','$tahun')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{						
				if($err==''){
				$aqry = "UPDATE ref_penyusutan SET residu='$residu', masa_manfaat='$masa_manfaat', tahun='$tahun' WHERE f='$kode1' and g='$kode2' and h='$kode3' and i='$kode4' and j='$kode5'";	$cek .= $aqry;
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
			 "<script src='js/skpd.js' type='text/javascript'></script>
			 <script type='text/javascript' src='js/penyusutan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
			 ".
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".
			
			$scriptload;
	}
	
	//form ==================================
	function setFormBaru(){
		/*$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdSUBUNIT'];
		$cek = $cbid[0];
				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$fmBIDANG = $_REQUEST['fmBIDANG'];
		$fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
		$fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
		$fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];		
		if(!empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.'00'.'.'.'00'.'.'.'00'.'.'.'000';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.'00'.'.'.'00'.'.'.'000';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.'.'00'.'.'.'000';
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
		{
			$dt['kode_barang']=$fmBIDANG.'.'.$fmKELOMPOK.'.'.$fmSUBKELOMPOK.'.'.$fmSUBSUBKELOMPOK.'.'.'000';
		}	
		
		$ck=mysql_fetch_array(mysql_query("select * from Ref_skpd2 where concat(f,'.',g,'.',h,'.',i,'.',j)='".$dt['kode_barang']."' order by persen1 desc limit 0,1"));
		if($ck['Id'] != ''){
			$dt['persen1'] = $ck['persen2'];
			$dt['readonly'] = 'readonly';
		}else{
			$dt['persen1'] = '';
			$dt['readonly'] = '';
		}
		
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}*/
	/*$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}*/	
	$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek =$cbid[0];				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$dt['readonly']='';
		$fmURUSAN = $_REQUEST['fmURUSAN'];
		$fmBIDANG = $_REQUEST['fmBIDANG'];
		$fmDINAS = $_REQUEST['fmDINAS'];
		$dt['f']=$_REQUEST['fmBIDANG'];
		$dt['g']=$_REQUEST['fmKELOMPOK'];
		$dt['h']=$_REQUEST['fmSUBKELOMPOK'];
		$dt['i']=$_REQUEST['fmSUBSUBKELOMPOK'];
		$dt['dk']='0';//$fmDINAS;
		
		$fm = $this->setForm($dt);		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
  	function setFormEdit(){
		/*$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdSUBUNIT'];
		$cek =$cbid[0];
				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		//query ambil data ref_tambah_manfaat
		$aqry = "select * from Ref_skpd2 where Id='".$this->form_idplh."'"; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$dt['kode_barang']=$dt['f'].'.'.$dt['g'].'.'.$dt['h'].'.'.$dt['i'].'.'.$dt['j'];
		$dt['readonly'] = '';
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}*/
	$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$f=$kode[0];
		$g=$kode[1];
		$h=$kode[2];
		$i=$kode[3];
		$j=$kode[4];
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  ref_penyusutan WHERE f='$f' and g='$g' and h='$h' and i='$i' and j='$j' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
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
	 $this->form_width = 620;
	 $this->form_height = 150;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
		$nip	 = '';
	  }else{
		$this->form_caption = 'Edit';			
		$readonly='readonly';
					
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		$kode1=genNumber($dt['f'],2);
		$kode2=genNumber($dt['g'],2);
		$kode3=genNumber($dt['h'],2);
		$kode4=genNumber($dt['i'],2);
		$kode5=genNumber($dt['j'],3);
		$residu=$dt['residu'];
		$masa_manfaat=$dt['masa_manfaat'];
		$tahun=$_COOKIE['coThnAnggaran'];
		
       //items ----------------------
		 $this->form_fields = array(
			'tahun' => array( 
						'label'=>'Tahun Berlaku',
						'labelWidth'=>60, 
						
						
						'value'=>"<input type='text' name='tahun' id='tahun' size='4' maxlength='4' value='".$tahun."'$readonly>",
						'row_params'=>"valign='top'",
						'type'=>'' 
									 ),				
		 
			'kode' => array( 
						'label'=>'Kode Barang',
						'labelWidth'=>80, 
						//'value'=>$dt['kode'],
						//'type'=>'text',
						'value'=>
						"<input type='text' name='f' id='f' size='3' maxlength='2' value='".$kode1."' $readonly>&nbsp
						<input type='text' name='g' id='g' size='3' maxlength='2' value='".$kode2."' $readonly>&nbsp
						<input type='text' name='h' id='h' size='3' maxlength='2' value='".$kode3."' $readonly>&nbsp
						<input type='text' name='i' id='i' size='3' maxlength='2' value='".$kode4."' $readonly>&nbsp
						<input type='text' name='j' id='j' size='4' maxlength='3' value='".$kode5."' $readonly>"
						 ),
						 
			/*'nama' => array(
						'label'=>'Nama Barang',
						'labelWidth'=>60, 
						
						
						'value'=>"<input type='text' name='nm_barang' id='nm_barang' size='35' maxlength='50' value='".$nama_barang."'>",
						'row_params'=>"valign='top'",
						'type'=>''
									 ),*/
			
			'nilai' => array( 
						'label'=>'Estimasi nilai sisa (%)',
						'labelWidth'=>120, 
						
						
						'value'=>
						inputFormatRibuan3("residu")
						//"<input type='text' name='nilai_sisa' id='nilai_sisa' size='35' maxlength='50' value='".$nilai_sisa."'>"
						,
						'row_params'=>"valign='top'",
						'type'=>'' 
									 ),
			'masa' => array( 
						'label'=>'Estimasi masa manfaat (Thn)',
						'labelWidth'=>170,
						
						
						'value'=>
						 inputFormatRibuan3("masa_manfaat")
						//"<input type='text' name='masa_manfaat' id='masa_manfaat' size='35' maxlength='50' value='".$masa_manfaat."'>"
						,
						'row_params'=>"valign='top'",
						'type'=>'' 
						/*onkeypress='returnisNumberKey(event)'onkeyup=\"".$this->Prefix."minimum_kapitalisasi()\"
						<div id='minimum_kapitalisasi' style=width:400px;color:red;font-weight:bold;font-size:14px;'></div>
						</div>";*/
									 ),	
			  
			);
		//tombol
		$this->form_menubawah =	
			"<input type='hidden' name='Id_skpd' id='Id_skpd'  value='".$Id."'>".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >".
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
  	   <th class='th01' width='5' >No.</th>
	   <th class='th01' width='200' >ID Barang</th>
	   <th class='th01' width='350' align='center'>Keterangan</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	 $Koloms[] = array('align="center"',$isi['idbi']);
	 $Koloms[] = array('align="center"',$isi['ket']);
	 
	 return $Koloms;
	}
	
	function genDaftarInitial(){
		$vOpsi = $this->genDaftarOpsi();
		$fmSesi = $_REQUEST['fmSesi'];		
		
		$divHal = "<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
							"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
						"</div>";
		switch($this->daftarMode){						
			case '1' :{ //detail horisontal
				$vdaftar = 
					"<table width='100%'><tr valign=top>
					<td style='width:$this->containWidth;'>".
						"<div id='{$this->Prefix}_cont_daftar' style='position:relative;width:$this->containWidth;overflow:auto' >"."</div>".
						$divHal.
					"</td>".
					"<td>".
						"<div id='{$this->Prefix}_cont_daftar_det' style=''>".$this->genTableDetail()."</div>".
					"</td>".
					"</tr></table>";
				break;
			}
			default :{
				$vdaftar = 
					"<div id='{$this->Prefix}_cont_daftar' style='position:relative;' >"."</div>".
					$divHal;					
				break;
			}
		}
		
		return		
			//$NavAtas.	
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 
				//$vOpsi['TampilOpt'].
				"<input type='hidden' id='fmSesi' name='fmSesi' value='".$fmSesi."'>".		
			"</div>".	
			//"<div style='position:relative'>".
			$vdaftar.
			//"</div>".
			'';
	}
	
	
	function genDaftarOpsi(){
	 global $Ref, $Main;

	$fmSesi = $_REQUEST['fmSesi'];		

	//data order ------------------------------
	 $arrOrder = array(
	  	         array('1','Kode Barang'),
			     array('2','Nama Barang'),	
	 );	
				
	$TampilOpt = "<input type='hidden' id='fmSesi' name='fmSesi' value='".$fmSesi."'>";			
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		$fmSesi = $_REQUEST['fmSesi'];		
		
		if(!empty($fmSesi)) $arrKondisi[] = " sesi = '$fmSesi'";	

		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			//case '': $arrOrders[] = " concat(f,g,h,i,j) ASC " ;break;
			//case '1': $arrOrders[] = " concat(f,g,h,i,j) $Asc1 " ;break;
			//case '2': $arrOrders[] = " nama_barang $Asc1 " ;break;
		
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
$PenyusutanLog = new PenyusutanLogObj();

?>