<?php

class popupStrukturObj  extends DaftarObj2{	
	var $Prefix = 'popupStruktur';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'system'; //daftar
	var $TblName_Hapus = 'system';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Data';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'REKENING';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'popupStrukturForm'; 
	var $WHERE_O = "";	
			
	function setTitle(){
		return '';
	}
	function setMenuEdit(){
		return
			"";
	}
	function setMenuView(){
		return "";
	}
	function setTopBar(){
		return "";
	}
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		
		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>";	
			
	}		
	
		function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
     $kode1= $_REQUEST['k'];	
	 $kode2= $_REQUEST['l'];
	 $kode3= $_REQUEST['m'];
	 $kode4= $_REQUEST['n'];
	 $kode5= $_REQUEST['o'];
	 $nama_rekening = $_REQUEST['nama_rekening'];
	
	 
	 if( $err=='' && $kode1 =='' ) $err= 'Kode 1 Belum Di Isi !!';
	 if( $err=='' && $kode2 =='' ) $err= 'Kode 2 Belum Di Isi !!';
	 if( $err=='' && $kode3 =='' ) $err= 'Kode 3 Belum Di Isi !!';
	 if( $err=='' && $kode4 =='' ) $err= 'Kode 4 Belum Di Isi !!';
	 if( $err=='' && $kode5 =='' ) $err= 'Kode 5 Belum Di Isi !!';
	 if( $err=='' && $nama_rekening =='' ) $err= 'nama rekening Belum Di Isi !!';
	 	
	
	// if($err=='' && $kode_skpd =='' ) $err= 'Kode Skpd belum diisi';	 
	 if(strlen($kode1)!=1 || strlen($kode2)!=1 || strlen($kode3)!=1 || strlen($kode4)!=2 ||strlen($kode5)!=2) $err= 'Format KODE salah';	
			for($j=0;$j<5;$j++){
	//urutan kode skpd 	
		if($j==0){
			$ck=mysql_fetch_array(mysql_query("Select * from system where k!='0' and l ='0' and m ='0' and n ='00' and o ='00' Order By k DESC limit 1"));
			if($kode1=='0') {$err= 'Format Kode Akun salah';}
			elseif($kode1!=5){ $err= 'Format Kode Akun salah';}
				
		}elseif($j==1){
			$ck=mysql_fetch_array(mysql_query("Select * from system where k='".$kode1."' and l !='0' and m ='0' and n ='00' and o ='00' Order By l DESC limit 1"));	
			if ($kode2>sprintf("%02s",$ck['l']+1)) {$err= 'Format Kode Kelompok Belanja Harus berurutan';}		
			
		}elseif($j==2){
			$ck=mysql_fetch_array(mysql_query("Select * from system where k='".$kode1."' and l ='".$kode2."' and m !='0' and n ='00' and o ='00' Order By m DESC limit 1"));			
			if ($kode3>sprintf("%02s",$ck['m']+1)) {$err= 'Format Kode Jenis Belanja Salah';}		
				
		}elseif($j==3){
			$ck=mysql_fetch_array(mysql_query("Select * from system where k='".$kode1."' and l ='".$kode2."' and m ='".$kode3."' and n!='00' and o='$this->WHERE_O' Order By n DESC limit 1"));	
			if ($kode4>sprintf("%02s",$ck['n']+1)) {$err= 'Format Kode Objek Belanja Harus berurutan';}
		
		}elseif($j==4){
			$ck=mysql_fetch_array(mysql_query("Select * from system where k='".$kode1."' and l ='".$kode2."' and m ='".$kode3."' and n ='".$kode4."' and o!='00' Order By o DESC limit 1"));	
			if ($kode5>sprintf("%02s",$ck['o']+1)) {$err= 'Format Kode SubObjek Belanja Harus berurutan';}
				
				
		}
	 }
	 
			
			
			if($fmST == 0){
			$ck1=mysql_fetch_array(mysql_query("Select * from system where k='$kode1' and l ='$kode2' and m ='$kode3' and n='$kode4' and o='$kode5'"));
			if ($ck1>=1)$err= 'Gagal Simpan'.mysql_error();
				if($err==''){
					$aqry = "INSERT into system (k,l,m,n,o,nm_rekening) values('$kode1','$kode2','$kode3','$kode4','$kode5','$nama_rekening')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{						
				if($err==''){
				$aqry = "UPDATE system SET nm_rekening='$nama_rekening' WHERE k='$kode1' and l='$kode2' and m='$kode3' and n='$kode4' and o='$kode5'";	$cek .= $aqry;
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
		
		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
			break;
		}

	   	case 'getdata':{
		foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
		}
		$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
		$content = array("nama" => $getData['nama'],"url" => $getData['url']);
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
			 "<script type='text/javascript' src='js/menuBar/popupStruktur.js' language='JavaScript' ></script>".		
			$scriptload;
	}
	function Hapus_Validasi($id){//id -> multi id with space delimiter
		$errmsg ='';
		$kode_rekening = explode(' ',$id);
		$ka=$kode_rekening[0];	
		$kb=$kode_rekening[1];
		$kc=$kode_rekening[2];	
		$kd=$kode_rekening[3];
		$ke=$kode_rekening[4];
		$kf=$kode_rekening[5];
		
		$quricoy="select count(*) as cnt from ref_barang where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and kf='$kf'";
		$dt3 = mysql_fetch_array(mysql_query($quricoy));
		$korong = $dt3 ['cnt'];
		
		if($korong>0){
		
		$korong;
		$errmsg = "ada kode barang tidak bisa di edit/hapus, karena masih ada rinciannya !";
		}
		
		if($errmsg=='' && 
				mysql_num_rows(mysql_query(
					"select Id from buku_induk where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and kf='$kf' ")
				) >0 )
			{ $errmsg = 'Gagal Hapus! KODE AKUN Sudah ada di Buku Induk!';}
		return $errmsg;
	}
	//form ==================================
	function setFormBaru(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
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
		$aqry = "SELECT * FROM  system WHERE k='$k' and l='$l' and m='$m' and n='$n' and o='$o' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 500;
	 $this->form_height = 100;
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
		$kode1=genNumber($dt['k'],1);
		$kode2=genNumber($dt['l'],1);
		$kode3=genNumber($dt['m'],1);
		$kode4=genNumber($dt['n'],2);
		$kode5=genNumber($dt['o'],2);
		$nama_rekening=$dt['nm_rekening'];
		
	 //items ----------------------
	  $this->form_fields = array(
			'kode' => array( 
						'label'=>'Kode Rekening',
						'labelWidth'=>100, 
						//'value'=>$dt['kode'],
						//'type'=>'text',
						'value'=>
						"<input type='text' name='k' id='k' size='5' maxlength='1' value='".$kode1."' $readonly>&nbsp
						<input type='text' name='l' id='l' size='5' maxlength='1' value='".$kode2."' $readonly>&nbsp
						<input type='text' name='m' id='m' size='5' maxlength='1' value='".$kode3."' $readonly>&nbsp
						<input type='text' name='n' id='n' size='5' maxlength='2' value='".$kode4."' $readonly>&nbsp
						<input type='text' name='o' id='o' size='5' maxlength='2' value='".$kode5."' $readonly>"
						 ),
			
			'nama' => array( 
						'label'=>'Nama Rekening',
						'labelWidth'=>100, 
						
						
						'value'=>"<input type='text' name='nama_rekening' id='nama_rekening' size='50' maxlength='100' value='".$nama_rekening."'>",
						'row_params'=>"valign='top'",
						'type'=>'' 
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

	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';		
		$form_name = $this->FormName;
		

			$FormContent = $this->genDaftarInitial($fmSKPD, $fmUNIT, $fmSUBUNIT,$tahun_anggaran);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						800,
						500,
						'Pilih Menu',
						'',
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
		//}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function genDaftarInitial($nm_account='', $height=''){
		setcookie('VWfilrek',$_REQUEST['filterAkun']);

		$vOpsi = $this->genDaftarOpsi();
		return			
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 		

				"<input type='hidden' id='".$this->Prefix."nm_account' name='".$this->Prefix."nm_account' value='$nm_account'>".
				"<input type='hidden' id='filterAkun' name='filterAkun' value='".$filterAkun."'>".
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
  	   <th class='th01' width='5' >No.</th>	
	   <th class='th01' width='50' align='center'>KODE</th>
	   <th class='th01' width='500' align='center'>NAMA</th>
	   <th class='th01' width='200' align='center'>TITLE</th>
	   <th class='th01' width='200' align='center'>HINT</th>
	   <th class='th01' width='200' align='center'>URL</th>
	   <th class='th01' width='50' align='center'>STATUS</th>

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
	 $Koloms[] = array('align="center"',"<span style='color:red;cursor:pointer;' onclick=$this->Prefix.windowSave($id)>".$id_system.".".$id_modul.".".$id_sub_modul.".".$id_sub_sub_modul.".".$id_sub_sub_sub_modul."</span>");
	 if($id_sub_sub_sub_modul != '0' ){
	 	$margin = "<span style='margin-left:40px;'>";
	 }elseif($id_sub_sub_modul != '0' ){
	 	$margin = "<span style='margin-left:30px;'>";
	 }elseif($id_sub_modul != '0' ){
	 	$margin = "<span style='margin-left:20px;'>";
	 }elseif($id_modul != '0' ){
	 	$margin = "<span style='margin-left:10px;'>";
	 }
	 $Koloms[] = array('align="left"',$margin.$nama);
	 $Koloms[] = array('align="left"',$margin.$title);
	 $Koloms[] = array('align="left"',$margin.$hint);
	 $Koloms[] = array('align="left"',$url);

	 if($status == "1"){
	 	$status = "AKTIF";
	 }else{
	 	$status = "TIDAK AKTIF";
	 }
	 $Koloms[] = array('align="center"',$status);
	 

	 return $Koloms;
	}
	
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
	 
	  
	  $queryCmbSystem = "select id_system, nama from $this->TblName where id_system != '0' and id_modul = '0' and id_sub_modul = '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
	  $comboSystem = cmbQuery('filterSystem',$filterSystem,$queryCmbSystem,"' onchange =$this->Prefix.refreshList(true); ",'-- Semua System --');
	  $queryCmbModul = "select id_modul, nama from $this->TblName where id_system = '$filterSystem' and id_modul != '0' and id_sub_modul = '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
	  $comboModul = cmbQuery('filterModul',$filterModul,$queryCmbModul,"' onchange=$this->Prefix.refreshList(true);",'-- Semua Modul --');
	  
	  $querySubModul = "select id_sub_modul, nama from $this->TblName where id_system = '$filterSystem' and id_modul = '$filterModul' and id_sub_modul != '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
	  $comboSubModul = cmbQuery('filterSubModul',$filterSubModul,$querySubModul,"' onchange=$this->Prefix.refreshList(true);",'-- Semua Sub Modul --');
	  
	  $querySubSubModul = "select id_sub_sub_modul, nama from $this->TblName where id_system = '$filterSystem' and id_modul = '$filterModul' and id_sub_modul = '$filterSubModul' and id_sub_sub_modul != '0' and id_sub_sub_sub_modul = '0'";
	  $comboSubSubModul = cmbQuery('filterSubSubModul',$filterSubSubModul,$querySubSubModul,"' onchange=$this->Prefix.refreshList(true);",'-- Semua Sub Sub Modul --');
	  
	  $querySubSubSubModul = "select id_sub_sub_sub_modul, nama from $this->TblName where id_system = '$filterSystem' and id_modul = '$filterModul' and id_sub_modul = '$filterSubModul' and id_sub_sub_modul = '$filterSubSubModul' and id_sub_sub_sub_modul != '0'";
	  $comboSubSubSubModul = cmbQuery('filterSubSubSubModul',$filterSubSubSubModul,$querySubSubSubModul,"' onchange=$this->Prefix.refreshList(true);",'-- Semua Sub Sub Sub Modul --');
	  
	  
	 if(empty($jumlahPerHal))$jumlahPerHal = "25";
	  $arr = array(	
	  		array('1','AKTIF'),		
			array('0','TIDAK'),		
			
			);
		$comboStatus = cmbArray('statusFilter',$statusFilter,$arr,'-- SEMUA STATUS --',"onchange= $this->Prefix.refreshList(true)");  		
	$TampilOpt = 
			"<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td style='width:20%;'>SYSTEM </td>
			<td>: </td>
			<td style='width:80%;'>$comboSystem </td>
			</tr>
			<tr>
			<td style='width:20%;'>MODUL </td>
			<td>: </td>
			<td style='width:80%;'>$comboModul </td>
			</tr>
			<tr>
			<td style='width:20%;'>SUB MODUL </td>
			<td>: </td>
			<td style='width:80%;'>$comboSubModul </td>
			</tr>
			<tr>
			<td style='width:20%;'>SUB SUB MODUL </td>
			<td>: </td>
			<td style='width:80%;'>$comboSubSubModul </td>
			</tr>
			
			<tr>
			<td style='width:20%;'>SUB SUB MODUL </td>
			<td>: </td>
			<td style='width:80%;'>$comboSubSubSubModul </td>
			</tr>

		
			
			
			
			
			
			</table>".
			"</div>".
			"<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<td>JUMLAH/HAL </td>
			<td>: </td>
			<td style='width:90%;'><input type= 'text' id='jumlahPerHal' name='jumlahPerHal' value='$jumlahPerHal' style='width:40px;'> <input type='button' value='Tampilkan' onclick=$this->Prefix.refreshList(true) id='buttonRefresh'></td>
			</tr>
		
			
			
			
			
			
			</table>".
			"</div>"
			
			;
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
		$this->pagePerHal = $jumlahPerHal;
		$arrKondisi = array();		
		if(!empty($filterSystem))$arrKondisi[]="id_system ='$filterSystem'";
		if(!empty($filterModul))$arrKondisi[]="id_modul ='$filterModul'";
		if(!empty($filterSubModul))$arrKondisi[]="id_sub_modul ='$filterSubModul'";
		if(!empty($filterSubSubModul))$arrKondisi[]="id_sub_sub_modul ='$filterSubSubModul'";
		if(!empty($filterSubSubSubModul))$arrKondisi[]="id_sub_sub_sub_modul ='$filterSubSubSubModul'";
	    $arrKondisi[]="status ='1'";
		
		

		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		$arrOrders[] = "concat(right((100 +id_system),2),'.',right((100 +id_modul),2),'.',right((1000 +id_sub_modul),3),'.',right((1000 +id_sub_sub_modul),3),'.',right((1000 +id_sub_sub_sub_modul),3))";
		$Order= join(',',$arrOrders);	
		$OrderDefault = " ";// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	
}
$popupStruktur = new popupStrukturObj();
if($Main->REK_DIGIT_O == 0){
	$popupStruktur->WHERE_O = "00";
}else{
	$popupStruktur->WHERE_O = "000";
}

?>