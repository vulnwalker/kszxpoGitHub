<?php
class onepageObj  extends DaftarObj2{	
	var $Prefix = 'onepage';
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
	var $PageTitle = 'System';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'System';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'onepageForm'; 
	var $username = "";

	var $Status = array(
				array('1','AKTIF'), 
				array('2','TIDAK AKTIF'), 
		);	
		
	var $Level = array(
				array('1','1'), 
				array('2','2'), 
				array('3','3'), 
		);		
		
	var $Posisi = array(
				array('1','HEADER'), 
				array('2','FOOTER'), 
		);	
		
	var $Jenis = array(
				array('1','A'), 
				array('2','B'), 
				array('3','C'), 
				array('4','D'), 
		);			
	
	var $Typelink = array(
				array('1','TEKS'), 
				array('2','BUTTON'), 
		);	
			
	function setTitle(){
		return 'System';
	}
	
	function setMenuView(){
		return "";
	}
	function setMenuEdit(){
		return
	//	"<td>".genPanelIcon("javascript:".$this->Prefix.".PengaturanKolom()","sections.png","Pengaturan", 'Pengaturan')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".selectEdit()","edit_f2.png","Edit", 'Edit')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
		;
	}
	function setPage_HeaderOther(){
   		
		return 
		"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
		<tr>
		<td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=generalSetting\"   > SETTING </a> |
		<A href=\"pages.php?Pg=onepage\"  style='color : blue;'' > SYSTEM </a> |
		<A href=\"pages.php?Pg=menuBar\"   > MENU BAR </a> |
		<A href=\"pages.php?Pg=shortcut\"   > SHORTCUT </a> |
		<A href=\"pages.php?Pg=footer\"   > FOOTER </a> |
		<A href=\"pages.php?Pg=ref_images\"   > IMAGES </a> |
		&nbsp&nbsp&nbsp	
		</td>
		</tr>
		</table>"
		;
	}	
	function baseToImage($base64_string, $output_file) {

	    $ifp = fopen( $output_file, 'wb' ); 
	    $data = explode( ',', $base64_string );

	    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

	    fclose( $ifp ); 
	
	    return $output_file; 
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
	 if(empty($id_system)){
	 	$err = "Pilih System";
	 }elseif(empty($id_modul)){
	 	$err = "Pilih Modul";
	 }elseif(empty($id_sub_modul)){
	 	$err = "Pilih Sub Modul";
	 }elseif(empty($id_sub_sub_modul)){
	 	$err = "Pilih Sub Sub Modul";
	 }elseif(empty($nama)){
	 	$err = "Isi Nama";
	 }elseif(empty($nama)){
	 	$err = "Isi Nama";
	 }
		if($fmST == 0){
			if($err==''){
					$getMaxKodeSubSubSubModul = mysql_fetch_array(mysql_query("select max(id_sub_sub_sub_modul) from $this->TblName where id_system ='$id_system' and id_modul ='$id_modul' and id_sub_modul ='$id_sub_modul' and id_sub_sub_modul ='$id_sub_sub_modul'"));
					$id_sub_sub_sub_modul = $getMaxKodeSubSubSubModul['max(id_sub_sub_sub_modul)'] + 1;
					$data = array(
									'id_system' => $id_system,
								  	'id_modul' => $id_modul,
									'id_sub_modul' => $id_sub_modul,
									'id_sub_sub_modul' => $id_sub_sub_modul,
									'id_sub_sub_sub_modul' => $id_sub_sub_sub_modul,
									'nama'=> $nama,
									'url' => $url,
									'status' => "AKTIF",
									'user_create' => $this->username,
									'tanggal_create' => date("Y-m-d"),
									'user_update' => "",
									'tanggal_update' => "",
								  );
						mysql_query(VulnWalkerInsert("system",$data));
						$cek = VulnWalkerInsert("system",$data);
					
					
				}
			}else{				
				if($err==''){
					$getMaxKodeSubSubSubModul = mysql_fetch_array(mysql_query("select max(id_sub_sub_sub_modul) from $this->TblName where id_system ='$id_system' and id_modul ='$id_modul' and id_sub_modul ='$id_sub_modul' and id_sub_sub_modul ='$id_sub_sub_modul' and id !='$idEdit'"));
					$id_sub_sub_sub_modul = $getMaxKodeSubSubSubModul['max(id_sub_sub_sub_modul)'] + 1;
					$data = array(
									'id_system' => $id_system,
								  	'id_modul' => $id_modul,
									'id_sub_modul' => $id_sub_modul,
									'id_sub_sub_modul' => $id_sub_sub_modul,
									'id_sub_sub_sub_modul' => $id_sub_sub_sub_modul,
									'nama'=> $nama,
									'url' => $url,
									'user_create' => $this->username,
									'tanggal_create' => date("Y-m-d"),
									'user_update' => "",
									'tanggal_update' => "",
								  );
					$query = VulnWalkerUpdate($this->TblName,$data,"id ='$idEdit'");
					mysql_query($query);
					$cek = $query;
				}
			} 
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	function Hapus_Validasi($id){
		$errmsg ='';
		$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
		foreach ($getData as $key => $value) { 
				  $$key = $value; 
				}
		if($id_sub_sub_modul != '0' && $id_sub_sub_sub_modul =='0'){
			$errmsg = "Delete semua downline dari $nama ?";

		}elseif($id_sub_modul != '0' && $id_sub_sub_modul =='0'){
			$errmsg = "Delete semua downline dari $nama ?";


		}elseif($id_modul != '0' && $id_sub_modul =='0'){
			$errmsg = "Delete semua downline dari $nama ?";


		}elseif($id_system != '0' && $id_modul =='0'){
				$errmsg = "Delete semua downline dari $nama ?";

		}
		if(empty($errmsg)){
			mysql_query("delete from $this->TblName where id ='$id'");
		}

			
		return $errmsg;
		
}	

function formStatus($idStatus){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
	 
	 $this->form_caption = 'STATUS';
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$idStatus'"));
	 foreach ($get as $key => $value) { 
				  $$key = $value; 
				}

		
	 //items ----------------------
	  $this->form_fields = array(
			'213' => array( 
						'label'=>'STATUS',
						'labelWidth'=>100, 
						'value'=>cmbArray('status',$status,$this->Status,'-- PILIH STATUS --',''),
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveStatus($idStatus)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
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
		case 'saveStatus':{				
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}	
				$data = array("status" => $status);	
				$query = VulnWalkerUpdate($this->TblName,$data,"id ='$id'");
				mysql_query($query);

				$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
				foreach ($getData as $key => $value) { 
				  $$key = $value; 
				}

				if($id_sub_sub_modul != '0' && $id_sub_sub_sub_modul =='0'){
					mysql_query("update $this->TblName set status='".$_REQUEST['status']."' where id_system = '$id_system' and id_modul ='$id_modul' and id_sub_modul='$id_sub_modul' and id_sub_sub_modul='$id_sub_sub_modul'");
				

				}elseif($id_sub_modul != '0' && $id_sub_sub_modul =='0'){
					mysql_query("update $this->TblName set status='".$_REQUEST['status']."' where id_system = '$id_system' and id_modul ='$id_modul' and id_sub_modul='$id_sub_modul' ");
					
				}elseif($id_modul != '0' && $id_sub_modul =='0'){
					mysql_query("update $this->TblName set status='".$_REQUEST['status']."' where id_system = '$id_system' and id_modul ='$id_modul'  ");
					

				}elseif($id_system != '0' && $id_modul =='0'){
						mysql_query("update $this->TblName set status='".$_REQUEST['status']."' where id_system = '$id_system'  ");
						
				}


		break;
		}

		case 'formStatus':{				
			$fm = $this->formStatus($_REQUEST['idStatus']);				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'deleteDownline':{				
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}	
				$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$onepage_cb[0]'"));
				foreach ($getData as $key => $value) { 
				  $$key = $value; 
				}

				if($id_sub_sub_modul != '0' && $id_sub_sub_sub_modul =='0'){
					mysql_query("delete from $this->TblName where id_system = '$id_system' and id_modul ='$id_modul' and id_sub_modul='$id_sub_modul' and id_sub_sub_modul='$id_sub_sub_modul'");
					$cek = "delete from $this->TblName where id_system = '$id_system' and id_modul ='$id_modul' and id_sub_modul='$id_sub_modul' and id_sub_sub_modul='$id_sub_sub_modul'";

				}elseif($id_sub_modul != '0' && $id_sub_sub_modul =='0'){
					mysql_query("delete from $this->TblName where id_system = '$id_system' and id_modul ='$id_modul' and id_sub_modul='$id_sub_modul' ");
					$cek = "delete from $this->TblName where id_system = '$id_system' and id_modul ='$id_modul' and id_sub_modul='$id_sub_modul'";

				}elseif($id_modul != '0' && $id_sub_modul =='0'){
					mysql_query("delete from $this->TblName where id_system = '$id_system' and id_modul ='$id_modul'  ");
					$cek = "delete from $this->TblName where id_system = '$id_system' and id_modul ='$id_modul' ";

				}elseif($id_system != '0' && $id_modul =='0'){
						mysql_query("delete from $this->TblName where id_system = '$id_system'  ");
						$cek = "delete from $this->TblName where id_system = '$id_system' ";
				}

				


				


		break;
		}
		case 'Hapus':{				
			$fm = $this->Hapus_data();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'checkEdit':{				
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			}
			
			$idEdit = $onepage_cb[0];
			$getKategori = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$idEdit'"));
			if($getKategori['id_sub_sub_sub_modul'] !='0'){
				$kategori = "SUB SUB SUB MODUL";
			}elseif($getKategori['id_sub_sub_modul'] !='0'){
				$kategori = "SUB SUB MODUL";
			}elseif($getKategori['id_sub_modul'] !='0'){
				$kategori = "SUB MODUL";
			}elseif($getKategori['id_modul'] !='0'){
				$kategori = "MODUL";
			}else{
				$kategori = "SYSTEM";
			}
			
			$content = array("kategori" => $kategori, 'id' => $idEdit);
			
															
		break;
		}
		case 'newSystem':{			
				$fm = $this->newSystem();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
		}
		case 'newModul':{			
				$fm = $this->newModul();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
		}
		
		case 'newSubModul':{			
				$fm = $this->newSubModul();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
		}
		
		case 'editSubModul':{			
				$fm = $this->editSubModul($_REQUEST['id']);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
		}
		
		case 'editModul':{			
				$fm = $this->editModul($_REQUEST['id']);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
		}
		
		case 'editSystem':{			
				$fm = $this->editSystem($_REQUEST['id']);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
		}
		case 'editSubSubModul':{			
				$fm = $this->editSubSubModul($_REQUEST['id']);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
		}
		
		case 'newSubSubModul':{			
				$fm = $this->newSubSubModul();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
		}
		
		case 'saveNewSystem':{			
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}	
				
				$getMaxKodeSystem = mysql_fetch_array(mysql_query("select max(id_system) from system"));	
				$myNomorUrut = $getMaxKodeSystem['max(id_system)'] + 1;
				$data = array(
								'id_system'=> $myNomorUrut,
								'id_modul' => '0',
								'id_sub_modul' => '0',
								'id_sub_sub_modul' => '0',
								'id_sub_sub_sub_modul' => '0',
								'nama' => $namaSystem,
								'url' => $urlSystem,
								'user_create' => $this->username,
								'tanggal_create' => date('Y-m-d'),
								'status' => '1'
								);		
				$query = VulnWalkerInsert($this->TblName,$data);
				mysql_query($query);
				
				$getMaxCurrentIdSystem = mysql_fetch_array(mysql_query("select max(id_system) from $this->TblName"));
				$queryCmbSystem = "select id_system, nama from $this->TblName where id_system != '0' and id_modul = '0' and id_sub_modul = '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
				$comboSystem = cmbQuery('id_system',$getMaxCurrentIdSystem['max(id_system)'],$queryCmbSystem,"' onchange =$this->Prefix.systemChanged(); ",'-- Pilih System --');
	 			
				$queryCmbModul = "select id_modul, nama from $this->TblName where id_system = '".$getMaxCurrentIdSystem['max(id_system)']."' and id_modul != '0' and id_sub_modul = '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
	 			$comboModul = cmbQuery('id_modul',$id_modul,$queryCmbModul,"' onchange =$this->Prefix.modulChanged(); ",'-- Pilih Modul --');
				
				$queryCmbSubModul = "select id_sub_modul, nama from $this->TblName where id_system = '".$getMaxCurrentIdSystem['max(id_system)']."' and id_modul = '$id_modul' and id_sub_modul != '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
	 			$comboSubModul = cmbQuery('id_sub_modul',$id_sub_modul,$queryCmbSubModul,"' onchange =$this->Prefix.subModulChanged(); ",'-- Pilih Sub Modul --');
			  	
				$queryCmbSubSubModul = "select id_sub_sub_modul, nama from $this->TblName where id_system = '".$getMaxCurrentIdSystem['max(id_system)']."' and id_modul = '$id_modul' and id_sub_modul = '$id_sub_modul' and id_sub_sub_modul != '0' and id_sub_sub_sub_modul = '0'";
	 			$comboSubSubModul = cmbQuery('id_sub_sub_modul',$id_sub_sub_modul,$queryCmbSubSubModul,"' onchange =$this->Prefix.subSubModulChanged(); ",'-- Pilih Sub Sub Modul --');
			  
				
				$content = array(
								 "cmbSystem" => $comboSystem,
								 'cmbModul' => $comboModul,
								 'cmbSubModul' => $cmbSubModul,
								 'cmbSubSubModul' => $comboSubSubModul
								);
										
			break;
		}
		
		
		
		case 'saveNewModul':{			
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}	
				
				$getMaxKodeModul = mysql_fetch_array(mysql_query("select max(id_modul) from system where id_system ='$id_system' and id_sub_modul ='0'"));	
				$myNomorUrut = $getMaxKodeModul['max(id_modul)'] + 1;
				$data = array(
								'id_system'=> $id_system,
								'id_modul' => $myNomorUrut,
								'id_sub_modul' => '0',
								'id_sub_sub_modul' => '0',
								'id_sub_sub_sub_modul' => '0',
								'nama' => $namaModul,
								'url' => $urlModul,
								'user_create' => $this->username,
								'tanggal_create' => date('Y-m-d'),
								'status' => '1'
								);		
				$query = VulnWalkerInsert($this->TblName,$data);
				mysql_query($query);
				
				$getMaxCurrentIdModul = mysql_fetch_array(mysql_query("select max(id_modul) from $this->TblName where id_system ='$id_system'"));

				$queryCmbModul = "select id_modul, nama from $this->TblName where id_system = '".$id_system."' and id_modul != '0' and id_sub_modul = '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
	 			$comboModul = cmbQuery('id_modul',$getMaxCurrentIdModul['max(id_modul)'],$queryCmbModul,"' onchange =$this->Prefix.modulChanged(); ",'-- Pilih Modul --');
				
				$queryCmbSubModul = "select id_sub_modul, nama from $this->TblName where id_system = '".$id_system."' and id_modul = '".$getMaxCurrentIdModul['max(id_modul)']."' and id_sub_modul != '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
	 			$comboSubModul = cmbQuery('id_sub_modul',$id_sub_modul,$queryCmbSubModul,"' onchange =$this->Prefix.subModulChanged(); ",'-- Pilih Sub Modul --');
			  	
				$queryCmbSubSubModul = "select id_sub_sub_modul, nama from $this->TblName where id_system = '".$id_system."' and id_modul = '$id_modul' and id_sub_modul = '$id_sub_modul' and id_sub_sub_modul != '0' and id_sub_sub_sub_modul = '0'";
	 			$comboSubSubModul = cmbQuery('id_sub_sub_modul',$id_sub_sub_modul,$queryCmbSubSubModul," onchange =$this->Prefix.subSubModulChanged(); ",'-- Pilih Sub Sub Modul --');
			  
				
				$content = array(
								 "cmbSystem" => $comboSystem,
								 'cmbModul' => $comboModul,
								 'cmbSubModul' => $comboSubModul,
								 'cmbSubSubModul' => $comboSubSubModul
								);
										
			break;
		}
		
		case 'saveNewSubModul':{			
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}	
				
				$getMaxKodeSubModul = mysql_fetch_array(mysql_query("select max(id_sub_modul) from system where id_system ='$id_system' and id_modul ='$id_modul' and id_sub_sub_modul ='0' "));	
				$myNomorUrut = $getMaxKodeSubModul['max(id_sub_modul)'] + 1;
				$data = array(
								'id_system'=> $id_system,
								'id_modul' => $id_modul,
								'id_sub_modul' => $myNomorUrut,
								'id_sub_sub_modul' => '0',
								'id_sub_sub_sub_modul' => '0',
								'nama' => $namaSubModul,
								'url' => $urlSubModul,
								'user_create' => $this->username,
								'tanggal_create' => date('Y-m-d'),
								'status' => '1'
								);		
				$query = VulnWalkerInsert($this->TblName,$data);
				mysql_query($query);
				
				$getMaxCurrentIdSubModul = mysql_fetch_array(mysql_query("select max(id_sub_modul) from $this->TblName where id_system ='$id_system' and id_modul ='$id_modul' and id_sub_sub_modul ='0'"));


				$queryCmbSubModul = "select id_sub_modul, nama from $this->TblName where id_system = '$id_system' and id_modul = '$id_modul' and id_sub_modul != '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
	 			$comboSubModul = cmbQuery('id_sub_modul',$getMaxCurrentIdSubModul['max(id_sub_modul)'],$queryCmbSubModul," onchange =$this->Prefix.subModulChanged(); ",'-- Pilih Sub Modul --');
			  	
				$queryCmbSubSubModul = "select id_sub_sub_modul, nama from $this->TblName where id_system = '".$id_system."' and id_modul = '$id_modul' and id_sub_modul = '".$getMaxCurrentIdSubModul['max(id_sub_modul)']."' and id_sub_sub_modul != '0' and id_sub_sub_sub_modul = '0'";
	 			$comboSubSubModul = cmbQuery('id_sub_sub_modul',$id_sub_sub_modul,$queryCmbSubSubModul," onchange =$this->Prefix.subSubModulChanged(); ",'-- Pilih Sub Sub Modul --');
			  
				
				$content = array(
								 "cmbSystem" => $comboSystem,
								 'cmbModul' => $comboModul,
								 'cmbSubModul' => $comboSubModul,
								 'cmbSubSubModul' => $comboSubSubModul
								);
										
			break;
		}
		
		
		case 'saveNewSubSubModul':{			
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}	
				
				$getMaxKodeSubSubModul = mysql_fetch_array(mysql_query("select max(id_sub_modul) from system where id_system ='$id_system' and id_modul ='$id_modul' and id_sub_modul ='$id_sub_modul' and id_sub_sub_sub_modul ='0' "));	
				$myNomorUrut = $getMaxKodeSubSubModul['max(id_sub_sub_modul)'] + 1;
				$data = array(
								'id_system'=> $id_system,
								'id_modul' => $id_modul,
								'id_sub_modul' => $id_sub_modul,
								'id_sub_sub_modul' => $myNomorUrut,
								'id_sub_sub_sub_modul' => '0',
								'nama' => $namaSubSubModul,
								'url' => $urlSubSubModul,
								'user_create' => $this->username,
								'tanggal_create' => date('Y-m-d'),
								'status' => '1'
								);		
				$query = VulnWalkerInsert($this->TblName,$data);
				mysql_query($query);
				
				$getMaxCurrentIdSubSubModul = mysql_fetch_array(mysql_query("select max(id_sub_sub_modul) from $this->TblName where id_system ='$id_system' and id_modul ='$id_modul' and id_sub_modul ='$id_sub_modul'   and id_sub_sub_sub_modul ='0'"));


				$queryCmbSubSubModul = "select id_sub_sub_modul, nama from $this->TblName where id_system = '".$id_system."' and id_modul = '$id_modul' and id_sub_modul = '$id_sub_modul' and id_sub_sub_modul != '0' and id_sub_sub_sub_modul = '0'";
	 			$comboSubSubModul = cmbQuery('id_sub_sub_modul',$getMaxCurrentIdSubSubModul['max(id_sub_sub_modul)'],$queryCmbSubSubModul," onchange =$this->Prefix.subSubModulChanged(); ",'-- Pilih Sub Sub Modul --');
			  
				
				$content = array(
								 "cmbSystem" => $comboSystem,
								 'cmbModul' => $comboModul,
								 'cmbSubModul' => $comboSubModul,
								 'cmbSubSubModul' => $comboSubSubModul
								);
										
			break;
		}
		
		case 'saveeditSubSubModul':{			
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}	
				

				$data = array(

								'nama' => $namaSubSubModul,
								'url' => $urlSubSubModul,
								'user_update' => $this->username,
								'tanggal_update' => date('Y-m-d'),
								// 'status' => $status
								);		
				$query = VulnWalkerUpdate($this->TblName,$data,"id ='$id'");
				mysql_query($query);
				

										
			break;
		}
		
		case 'saveeditSubModul':{			
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}	
				

				$data = array(

								'nama' => $namaSubModul,
								'url' => $urlSubModul,
								'user_update' => $this->username,
								'tanggal_update' => date('Y-m-d'),
								// 'status' => $status
								);		
				$query = VulnWalkerUpdate($this->TblName,$data,"id ='$id'");
				mysql_query($query);
				

										
			break;
		}
		
		case 'saveeditModul':{			
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}	
				

				$data = array(

								'nama' => $namaModul,
								'url' => $urlModul,
								'user_update' => $this->username,
								'tanggal_update' => date('Y-m-d'),
								// 'status' => $status
								);		
				$query = VulnWalkerUpdate($this->TblName,$data,"id ='$id'");
				mysql_query($query);
				

										
			break;
		}
		
		case 'saveeditSystem':{			
				foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}	
				

				$data = array(

								'nama' => $namaSystem,
								'url' => $urlSystem,
								'user_update' => $this->username,
								'tanggal_update' => date('Y-m-d'),
								'status' => $status
								);		
				$query = VulnWalkerUpdate($this->TblName,$data,"id ='$id'");
				mysql_query($query);
				

										
			break;
		}
		
		case 'saveKolom':{				
			$data = array("row" => $_REQUEST['maxRow'], "kolom" => $_REQUEST['maxKolom']);	
			$query = VulnWalkerUpdate("setting_kolom",$data,"1=1");
			mysql_query($query);
													
		break;
		}
		
		case 'formPengaturan':{				
			$fm = $this->formPengaturan();				
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
			$get= $this->Hapus();
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
		
		case 'systemChanged':{
			foreach ($_REQUEST as $key => $value) { 
			  $$key = $value; 
			}
			 $queryCmbModul = "select id_modul, nama from $this->TblName where id_system = '$id_system' and id_modul != '0' and id_sub_modul = '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0' ";
	 		 $comboModul = cmbQuery('id_modul',$id_modul,$queryCmbModul,"' onchange =$this->Prefix.modulChanged(); style='width:500px;'",'-- Pilih Modul --');


				$queryCmbSubModul = "select id_sub_modul, nama from $this->TblName where id_system = '$id_system' and id_modul = '$id_modul' and id_sub_modul != '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
	 			$comboSubModul = cmbQuery('id_sub_modul',$id_sub_modul,$queryCmbSubModul,"' onchange =$this->Prefix.subModulChanged(); style='width:500px;'",'-- Pilih Sub Modul --');
			  	
				$queryCmbSubSubModul = "select id_sub_sub_modul, nama from $this->TblName where id_system = '$id_system' and id_modul = '$id_modul' and id_sub_modul = '$id_sub_modul' and id_sub_sub_modul != '0' and id_sub_sub_sub_modul = '0'";
	 			$comboSubSubModul = cmbQuery('id_sub_sub_modul',$id_sub_sub_modul,$queryCmbSubSubModul,"' onchange =$this->Prefix.subSubModulChanged(); style='width:500px;'",'-- Pilih Sub Sub Modul --');
			  
			  
			 $content = array("cmbModul" => $comboModul,'cmbSubModul' => $comboSubModul ,'cmbSubSubModul' => $comboSubSubModul);
			
			
		break;
	    }
		
		case 'modulChanged':{
			foreach ($_REQUEST as $key => $value) { 
			  $$key = $value; 
			}

			$queryCmbSubModul = "select id_sub_modul, nama from $this->TblName where id_system = '$id_system' and id_modul = '$id_modul' and id_sub_modul != '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
	 		$comboSubModul = cmbQuery('id_sub_modul',$id_sub_modul,$queryCmbSubModul,"' onchange =$this->Prefix.subModulChanged(); style='width:500px;'",'-- Pilih Sub Modul --');
			  	
			$queryCmbSubSubModul = "select id_sub_sub_modul, nama from $this->TblName where id_system = '$id_system' and id_modul = '$id_modul' and id_sub_modul = '$id_sub_modul' and id_sub_sub_modul != '0' and id_sub_sub_sub_modul = '0'";
	 		$comboSubSubModul = cmbQuery('id_sub_sub_modul',$id_sub_sub_modul,$queryCmbSubSubModul,"' onchange =$this->Prefix.subSubModulChanged(); style='width:500px;' ",'-- Pilih Sub Sub Modul --');
			  
			  
			 $content = array('cmbSubModul' => $comboSubModul ,'cmbSubSubModul' => $comboSubSubModul);
			
		break;
	    }
		
		case 'subModulChanged':{
			foreach ($_REQUEST as $key => $value) { 
			  $$key = $value; 
			}


			$queryCmbSubSubModul = "select id_sub_sub_modul, nama from $this->TblName where id_system = '$id_system' and id_modul = '$id_modul' and id_sub_modul = '$id_sub_modul' and id_sub_sub_modul != '0' and id_sub_sub_sub_modul = '0'";
	 		$comboSubSubModul = cmbQuery('id_sub_sub_modul',$id_sub_sub_modul,$queryCmbSubSubModul,"",'-- Pilih Sub Sub Modul --');
			  
			  
			 $content = array('cmbSubSubModul' => $comboSubSubModul);
			
		break;
	    }
		
		case 'batal':{
			$get= $this->batal();
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
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/upload_style.css' type='text/css'>".
			"<script src='js/jquery.js' type='text/javascript'></script>".			
			"<script src='js/jquery-ui.js' type='text/javascript'></script>".
			"<script src='js/jquery.min.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/jquery.form.js'></script> ".
			"<script src='js/jquery-ui.custom.js'></script>".
			 "<script type='text/javascript' src='js/onepage/onepage.js' language='JavaScript' ></script>".
			  "<script type='text/javascript' src='js/admin/ManagementModulSystem/ManagementModulSystem2.js' language='JavaScript' ></script>
			 ".
			$scriptload;
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
		
		$this->form_fmST = 1;				

		$fm = $this->setForm($cbid[0]);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
		
	function setForm($dt){	
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];	
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 700;
	 $this->form_height = 180;
	 $tgl_update = date('d-m-Y');	
	  if ($this->form_fmST==0) {
		$this->form_caption = 'System - Baru';
		$id_system = $_REQUEST['filterSystem'];
		$id_modul = $_REQUEST['filterModul'];
		$id_sub_modul = $_REQUEST['filterSubModul'];
		$id_sub_sub_modul = $_REQUEST['filterSubSubModul'];
		$status = "1";
		
	  }else{
		$this->form_caption = 'System - Edit';			
		$get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$dt'"));
		foreach ($get as $key => $value) { 
			  $$key = $value; 
			}			
	  }
	  	
		
		
	 $queryCmbSystem = "select id_system, nama from $this->TblName where id_system != '0' and id_modul = '0' and id_sub_modul = '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
	 $comboSystem = cmbQuery('id_system',$id_system,$queryCmbSystem,"' onchange =$this->Prefix.systemChanged(); style='width:500px;'",'-- Pilih System --');
	 
	 $queryCmbModul = "select id_modul, nama from $this->TblName where id_system = '$id_system' and id_modul != '0' and id_sub_modul = '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
	 $comboModul = cmbQuery('id_modul',$id_modul,$queryCmbModul,"' onchange =$this->Prefix.modulChanged(); style='width:500px;' ",'-- Pilih Modul --');
	 
	 $queryCmbSubModul = "select id_sub_modul, nama from $this->TblName where id_system = '$id_system' and id_modul = '$id_modul' and id_sub_modul != '0' and id_sub_sub_modul = '0' and id_sub_sub_sub_modul = '0'";
	 $comboSubModul = cmbQuery('id_sub_modul',$id_sub_modul,$queryCmbSubModul,"' onchange =$this->Prefix.subModulChanged(); style='width:500px;'",'-- Pilih Sub Modul --');
	
	 $queryCmbSubSubModul = "select id_sub_sub_modul, nama from $this->TblName where id_system = '$id_system' and id_modul = '$id_modul' and id_sub_modul = '$id_sub_modul' and id_sub_sub_modul != '0' and id_sub_sub_sub_modul = '0'";
	 $comboSubSubModul = cmbQuery('id_sub_sub_modul',$id_sub_sub_modul,$queryCmbSubSubModul," style='width:500px;' ",'-- Pilih Sub Sub Modul --');
	

       //items ----------------------
		  $this->form_fields = array(
		  

						 
			'system' => array( 
						'label'=>'SYSTEM',
						'labelWidth'=>100, 
						'value'=> $comboSystem."&nbsp <input type='button' onclick = $this->Prefix.newSystem(); value='Baru'>"
						),
			'modul' => array( 
						'label'=>'MODUL',
						'labelWidth'=>100, 
						'value'=> $comboModul."&nbsp <input type='button' onclick = $this->Prefix.newModul(); value='Baru'>"
						),
			'submodul' => array( 
						'label'=>'SUB MODUL',
						'labelWidth'=>100, 
						'value'=> $comboSubModul."&nbsp <input type='button' onclick = $this->Prefix.newSubModul(); value='Baru'>"
						),
			'subsubmodul' => array( 
						'label'=>'SUB SUB MODUL',
						'labelWidth'=>100, 
						'value'=> $comboSubSubModul."&nbsp <input type='button' onclick = $this->Prefix.newSubSubModul(); value='Baru'>"
						),
									 
			'nama' => array( 
						'label'=>'NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nama' id='nama' value='".$nama."' style='width:500px;'>",
						 ),	

						 
			'alamat_url' => array( 
						'label'=>'URL',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='url' id='url' value='".$url."' style='width:500px;'>",
						 ),				 
						 			 			 		
			// 'status' => array( 
			// 			'label'=>'STATUS',
			// 			'labelWidth'=>100,
			// 			'value'=>cmbArray('status',$status,$this->Status,'-- PILIH --','style="width:95px;"'),
			// 			 ),	
			

			);
		//tombol
		$this->form_menubawah =	
			
			"<input type='hidden' name='idEdit' id='idEdit' value='$dt'><input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function formPengaturan(){	
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];	
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 200;
	 $this->form_height = 100;
	 $this->form_caption = 'PENGATURAN';
	 
	 	$get = mysql_fetch_array(mysql_query("select * from setting_kolom "));
		$row = $get['row'];
		$kolom = $get['kolom'];
		
       //items ----------------------
		  $this->form_fields = array(
		  

						 
			'row' => array( 
							'label'=>'MAX ROW',
							'labelWidth'=>100, 
							'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='maxRow' id='maxRow' maxlength='3' value='$row' style='width:30px;maxlength='3'>
							",
						),	
			'kolom' => array( 
							'label'=>'MAX KOLOM',
							'labelWidth'=>100, 
							'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='maxKolom' id='maxKolom' maxlength='3' value='$kolom' style='width:30px;maxlength='3'>
							",
						),	
									 
			
			

			);
		//tombol
		$this->form_menubawah =	
			
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveKolom()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setFormeditdata($dt){	
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];	
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 770;
	 $this->form_height = 370;
	 $tgl_update = date('d-m-Y');	
	  if ($this->form_fmST==0) {
		$this->form_caption = 'System - Baru';
	  }else{
		$this->form_caption = 'System - Edit';			
		$Id = $dt['id'];			
	  }
	  
		$id = $_REQUEST['Id_system'];
		$fmc = $_REQUEST['fmc'];
		$fmd = $_REQUEST['fmd'];
		$fme = $_REQUEST['fme'];
		$fme1 = $_REQUEST['fme1'];
		$gedung = $_REQUEST['gedung'];
					
	$akt=mysql_fetch_array(mysql_query("select nmfile_asli from gambar_upload where id_upload='".$dt['Id_menu']."'  and jns_upload='2'"));
	$pas=mysql_fetch_array(mysql_query("select nmfile_asli from gambar_upload where id_upload='".$dt['Id_menu']."'  and jns_upload='3'"));
	$datalevel=1;
	$datatipe=1;
	$datajenis=1;
	$dataposisi=1;
	$dataaktif=1;
	$kdx=$dt['kode'];
	$datasys=mysql_fetch_array(mysql_query("select nm_system from system where Id_system='".$dt['Id_system']."'"));
	$datamod=mysql_fetch_array(mysql_query("select nm_system,nm_modul from system_modul where Id_modul='".$dt['Id_modul']."'"));
	
				$l = substr($kdx, 0,2);
				$m = substr($kdx, 3,2);
				$n = substr($kdx, 6,2);
		
       //items ----------------------
		  $this->form_fields = array(
		  
		  	'no_urut' => array( 
						'label'=>'NO.URUT',
						'labelWidth'=>180, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='nourut' id='nourut' maxlength='3' value='".$dt['no_urut']."' style='width:30px;maxlength='3'>",
						 ),
						 
			'kode' => array( 
						'label'=>'KODE',
						'labelWidth'=>100, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='kode_x' id='kode_x' maxlength='2' value='$l' style='width:30px;maxlength='3'>&nbsp
						<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='kode_y' id='kode_y' maxlength='2' value='$m' style='width:30px;maxlength='3'>&nbsp
						<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='kode_z' id='kode_z' maxlength='2' value='$n' style='width:30px;maxlength='3'> * 01.02.03",
						 ),	
						 
			'level' => array( 
						'label'=>'LEVEL',
						'labelWidth'=>100,
						'value'=>cmbArray('level',$dt['level'],$this->Level,'-- PILIH --','style="width:95px;"'),
						 ),			 		 		 
						 
		  	'nm_system' => array( 
						'label'=>'NAMA SYSTEM / MODUL',
						'labelWidth'=>120, 
						'value'=>"
						<input type='hidden' name='id' value='".$dt['Id_modul']."' placeholder='Kode' size='5px' id='id' readonly>
						<input type='hidden' name='id_system' value='".$dt['Id_system']."' placeholder='Kode' size='5px' id='id_system' readonly>
						<input type='text' name='nm_system' value='".$datasys['nm_system']."' placeholder='Nama System' style='width:245px' id='nm_system' readonly>&nbsp
						<input type='text' name='nm_modul' value='".$datamod['nm_modul']."' placeholder='Nama Modul' style='width:250px' id='nm_modul' readonly>&nbsp
						<input type='button' value='Cari' onclick ='".$this->Prefix.".Cari()' title='Cari' >" 
									 ),
				 
			'title' => array( 
						'label'=>'TITLE',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='title' id='title' value='".$dt['title']."' style='width:500px;'>",
						 ),	
						 
			'alamat_url' => array( 
						'label'=>'ALAMAT URL',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='alamat_url' id='alamat_url' value='".$dt['alamat_url']."' style='width:500px;'>",
						 ),				 
			
			'hint' => array( 
						'label'=>'HINT',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='hint' id='hint' value='".$dt['hint']."' style='width:500px;'>",
						 ),	
						 
			'AKTIF' => array( 
						'label'=>'FILE IMAGES AKTIF','labelWidth'=>150, 
						'value'=>$akt['nmfile_asli'],
			 ),
			
			'PASIF' => array( 
						'label'=>'FILE IMAGES PASIF','labelWidth'=>150, 
						'value'=>$pas['nmfile_asli'],
			 ),
			
				
			'type_link' => array( 
						'label'=>'TIPE LINK',
						'labelWidth'=>100,
						'value'=>cmbArray('typelink',$dt['type_link'],$this->Typelink,'-- PILIH --','style="width:95px;"'),
						 ),	
			
			'jenis' => array( 
						'label'=>'JENIS',
						'labelWidth'=>100,
						'value'=>cmbArray('jenis',$dt['jenis'],$this->Jenis,'-- PILIH --','style="width:95px;"'),
						 ),	
						 
			'posisi' => array( 
						'label'=>'POSISI',
						'labelWidth'=>100,
						'value'=>cmbArray('posisi',$dt['posisi'],$this->Posisi,'-- PILIH --','style="width:95px;"'),
						 ),				 
						 			 			 		
			'status' => array( 
						'label'=>'STATUS',
						'labelWidth'=>100,
						'value'=>cmbArray('status',$dt['status_menu'],$this->Status,'-- PILIH --','style="width:95px;"'),
						 ),	
			
			'tgl_update' =>	array(
						'label'=>'TANGGAL UPDATE',
						'name'=>'dokumensumber',
						'label-width'=>100,
						'value'=>"<input type='text' name='tgl_update' id='tgl_update' class='' value='$tgl_update' style='width:80px;'readonly />  ",						
								),				 
			'username' => array( 
						'label'=>'USER NAME',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='username' id='username' value='$uid' style='width:250px;'readonly>",
						 ),	
			);
		//tombol
		$this->form_menubawah =	
			
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >"."&nbsp&nbsp".
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
  	   $Checkbox		
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
	  if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	 $Koloms[] = array('align="center"',$id_system.".".$id_modul.".".$id_sub_modul.".".$id_sub_sub_modul.".".$id_sub_sub_sub_modul);
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
	 $Koloms[] = array('align="left"',"<span style='color:red;cursor:pointer;' onclick=$this->Prefix.formStatus($id); >$status</span>");
	 

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
			<td>SYSTEM </td>
			<td>: </td>
			<td style='width:90%;'>$comboSystem </td>
			</tr>
			<tr>
			<td>MODUL </td>
			<td>: </td>
			<td style='width:90%;'>$comboModul </td>
			</tr>
			<tr>
			<td>SUB MODUL </td>
			<td>: </td>
			<td style='width:90%;'>$comboSubModul </td>
			</tr>
			<tr>
			<td>SUB SUB MODUL </td>
			<td>: </td>
			<td style='width:90%;'>$comboSubSubModul </td>
			</tr>
			
			<tr>
			<td>SUB SUB SUB MODUL </td>
			<td>: </td>
			<td style='width:90%;'>$comboSubSubSubModul </td>
			</tr>
			<tr>
			<td>STATUS </td>
			<td>: </td>
			<td style='width:90%;'>$comboStatus </td>
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
		if($statusFilter !='')$arrKondisi[]="status ='$statusFilter'";
		
		

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
	
	function newSystem(){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 400;
	 $this->form_height = 100;
	 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
	 
	 	$this->form_caption = 'BARU';

		
	 //items ----------------------
	  $this->form_fields = array(



			'asd' => array( 
						'label'=>'NAMA SYSTEM',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='namaSystem' id='namaSystem' style='width:250px;' value=''>", 
						 ),
			
			'123as' => array( 
						'label'=>'URL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='urlSystem' id='urlSystem' style='width:250px;' value=''>", 
						 ),

			
							 			
				
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNewSystem()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function newModul(){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 400;
	 $this->form_height = 100;
	 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
	 
	 	$this->form_caption = 'BARU';

		
	 //items ----------------------
	  $this->form_fields = array(



			'asd' => array( 
						'label'=>'NAMA MODUL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='namaModul' id='namaModul' style='width:250px;' value=''>", 
						 ),
			'123as' => array( 
						'label'=>'URL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='urlModul' id='urlModul' style='width:250px;' value=''>", 
						 ),

			
							 			
				
			);
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNewModul()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function newSubModul(){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 400;
	 $this->form_height = 100;
	 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
	 
	 	$this->form_caption = 'BARU';

		
	 //items ----------------------
	  $this->form_fields = array(



			'asd' => array( 
						'label'=>'NAMA SUB MODUL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='namaSubModul' id='namaSubModul' style='width:250px;' value=''>", 
						 ),
			'123as' => array( 
						'label'=>'URL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='urlSubModul' id='urlSubModul' style='width:250px;' value=''>", 
						 ),

			
							 			
				
			);
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNewSubModul()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function newSubSubModul(){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 400;
	 $this->form_height = 100;
	 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
				}
	 
	 	$this->form_caption = 'BARU';

		
	 //items ----------------------
	  $this->form_fields = array(



			'asd' => array( 
						'label'=>'NAMA SUB SUB MODUL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='namaSubSubModul' id='namaSubSubModul' style='width:250px;' value=''>", 
						 ),
			'123as' => array( 
						'label'=>'URL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='urlSubSubModul' id='urlSubSubModul' style='width:250px;' value=''>", 
						 ),
			
							 			
				
			);
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNewSubSubModul()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function editSubSubModul($idEdit){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 400;
	 $this->form_height = 100;
	 
	 $getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$idEdit'"));
	 foreach ($getData as $key => $value) { 
				  $$key = $value; 
				}
	 
	 	$this->form_caption = 'EDIT';

		
	 //items ----------------------
	  $this->form_fields = array(



			'asd' => array( 
						'label'=>'NAMA SUB SUB MODUL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='namaSubSubModul' id='namaSubSubModul' style='width:250px;' value='$nama'>", 
						 ),
			'123as' => array( 
						'label'=>'URL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='urlSubSubModul' id='urlSubSubModul' style='width:250px;' value='$url'>", 
						 ),
			// 'status' => array( 
			// 			'label'=>'STATUS',
			// 			'labelWidth'=>100,
			// 			'value'=>cmbArray('status',$status,$this->Status,'-- PILIH --','style="width:95px;"'),
			// 			 ),	
			
			
							 			
				
			);
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveeditSubSubModul($idEdit)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function editSubModul($idEdit){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 400;
	 $this->form_height = 100;
	 
	 $getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$idEdit'"));
	 foreach ($getData as $key => $value) { 
				  $$key = $value; 
				}
	 
	 	$this->form_caption = 'EDIT';

		
	 //items ----------------------
	  $this->form_fields = array(



			'asd' => array( 
						'label'=>'NAMA SUB SUB MODUL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='namaSubModul' id='namaSubModul' style='width:250px;' value='$nama'>", 
						 ),
			'123as' => array( 
						'label'=>'URL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='urlSubModul' id='urlSubModul' style='width:250px;' value='$url'>", 
						 ),
			// 'status' => array( 
			// 			'label'=>'STATUS',
			// 			'labelWidth'=>100,
			// 			'value'=>cmbArray('status',$status,$this->Status,'-- PILIH --','style="width:95px;"'),
			// 			 ),	
			
			
							 			
				
			);
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveeditSubModul($idEdit)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function editModul($idEdit){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 400;
	 $this->form_height = 100;
	 
	 $getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$idEdit'"));
	 foreach ($getData as $key => $value) { 
				  $$key = $value; 
				}
	 
	 	$this->form_caption = 'EDIT';

		
	 //items ----------------------
	  $this->form_fields = array(



			'asd' => array( 
						'label'=>'NAMA   MODUL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='namaModul' id='namaModul' style='width:250px;' value='$nama'>", 
						 ),
			'123as' => array( 
						'label'=>'URL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='urlModul' id='urlModul' style='width:250px;' value='$url'>", 
						 ),
			// 'status' => array( 
			// 			'label'=>'STATUS',
			// 			'labelWidth'=>100,
			// 			'value'=>cmbArray('status',$status,$this->Status,'-- PILIH --','style="width:95px;"'),
			// 			 ),	
			
			
							 			
				
			);
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveeditModul($idEdit)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function editSystem($idEdit){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 400;
	 $this->form_height = 100;
	 
	 $getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$idEdit'"));
	 foreach ($getData as $key => $value) { 
				  $$key = $value; 
				}
	 
	 	$this->form_caption = 'EDIT';

		
	 //items ----------------------
	  $this->form_fields = array(



			'asd' => array( 
						'label'=>'NAMA   System',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='namaSystem' id='namaSystem' style='width:250px;' value='$nama'>", 
						 ),
			'123as' => array( 
						'label'=>'URL',
						'labelWidth'=>100, 
						'value'=>"<input type = 'text' name='urlSystem' id='urlSystem' style='width:250px;' value='$url'>", 
						 ),
			'status' => array( 
						'label'=>'STATUS',
						'labelWidth'=>100,
						'value'=>cmbArray('status',$status,$this->Status,'-- PILIH --','style="width:95px;"'),
						 ),	
			
			
							 			
				
			);
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveeditSystem($idEdit)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormKB();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	
}
$onepage = new onepageObj();
$onepage->username =$_COOKIE['coID'];
?>