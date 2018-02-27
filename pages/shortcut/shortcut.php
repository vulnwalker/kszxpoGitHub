<?php
class shortcutObj  extends DaftarObj2{
	var $Prefix = 'shortcut';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'shortcut'; //daftar
	var $TblName_Hapus = 'shortcut';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'SHORTCUT';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'SHORTCUT';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'shortcutForm';
	var $username = "";

	var $Status = array(
				array('1','AKTIF'),
				array('2','TIDAK AKTIF'),
		);
	var $arrayRow = array(
				array('1','1'),
				array('2','2'),
				array('3','3'),
				array('4','4'),
				array('5','5'),
				array('6','6'),
				array('7','7'),
				array('8','8'),
				array('9','9'),
				array('10','10'),
		);
	var $arrayKolom = array(
				array('1','1'),
				array('2','2'),
				array('3','3'),
				array('4','4'),
				array('5','5')
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
		return 'SHORTCUT';
	}
	function setPage_HeaderOther(){

		return
		"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
		<tr>
		<td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=generalSetting\"   > SETTING </a> |
		<A href=\"pages.php?Pg=onepage\"   > SYSTEM </a> |
		<A href=\"pages.php?Pg=menuBar\"  > MENU BAR </a> |
		<A href=\"pages.php?Pg=shortcut\"  style='color : blue;'  > SHORTCUT </a> |

		<A href=\"pages.php?Pg=footer\"   > FOOTER </a> |
		<A href=\"pages.php?Pg=ref_images\"   > IMAGES </a> |
		&nbsp&nbsp&nbsp
		</td>
		</tr>
		</table>"
		;
	}
	function setMenuView(){
		return "";
	}
	function setMenuEdit(){
		return
	/*	"<td>".genPanelIcon("javascript:".$this->Prefix.".PengaturanKolom()","sections.png","Pengaturan", 'Pengaturan')."</td>".*/
		"<td>".genPanelIcon("javascript:".$this->Prefix.".formURL()","sections.png","URL", 'URL')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Gambar()","sections.png","Gambar", 'Gambar')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
		;
	}

	function baseToImage($base64_string, $output_file) {

	    $ifp = fopen( $output_file, 'wb' );
	    $data = explode( ',', $base64_string );

	    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

	    fclose( $ifp );

	    return $output_file;
	}

	function formURL(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 $this->form_caption = 'URL';
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$shortcut_cb[0]'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'URL',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='url' id ='url' value='$url' style='width:200px;'> &nbsp <input type='button' value='Cari' onclick=popupStruktur.windowShow();> ",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveURL($shortcut_cb[0])' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
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
	 foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
	 if(empty($cmbUpline))$cmbUpline = "0";
	 $getMaxRowAndKolom = mysql_fetch_array(mysql_query("select * from setting_kolom"));
	 if(empty($cmbGrup)){
	 	$err = "Pilih Grup";
	 }elseif(empty($title)){
	 	$err = "Isi title";
	 }elseif(!empty($row) && !empty($kolom) && mysql_num_rows(mysql_query("select * from $this->TblName where grup = '$cmbGrup'  and row='$row' and kolom ='$kolom' and id!='$idEdit'")) !=0){
	 	$err = "Posisi sudah ada";
	 }
		if($fmST == 0){
			if($err==''){
					$data = array(
									'grup' => $cmbGrup,
									'title' => $title,
									'hint' => $hint,
									'row' => $row,
									'kolom' => $kolom,
									'image_aktif' => '',
									'image_pasif' => '',
									'status' => $status,
								 );
					$query = VulnWalkerInsert($this->TblName,$data);
					$cek = $query;
					mysql_query($query);
				}
			}else{
				if($err==''){
					$data = array(
									'grup' => $cmbGrup,
									'title' => $title,
									'hint' => $hint,
									'row' => $row,
									'kolom' => $kolom,
									'status' => $status,
								 );
					$query = VulnWalkerUpdate($this->TblName,$data,"id='$idEdit'");
					$cek = $query;
					mysql_query($query);
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
		case 'saveKolom':{
			$data = array("row" => $_REQUEST['maxRow'], "kolom" => $_REQUEST['maxKolom']);
			$query = VulnWalkerUpdate("setting_kolom",$data,"1=1");
			mysql_query($query);

		break;
		}
		case 'saveURL':{
				foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}
				$data = array("url" => $url);
				$query = VulnWalkerUpdate($this->TblName,$data,"id ='$id'");
				mysql_query($query);
		break;
		}
		case 'formURL':{
			$fm = $this->formURL();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'showImage':{
			$fm = $this->showImage($_REQUEST['id']);
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'saveGambar':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}
			$data = array(
									'image_pasif' => $imagePasif,
									'image_aktif' => $imageAktif,
								 );
					$query = VulnWalkerUpdate($this->TblName,$data,"id='$idEdit'");
					$cek = $query;
					mysql_query($query);

		break;
		}
		case 'grupChanged':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}
			$getMaxPosisi = mysql_fetch_array(mysql_query("select * from grup where id ='$idKategori'"));
			for($i = 1;$i <= $getMaxPosisi['max_row'];$i++ ){
				$arrayRow[] = array($i,$i);
			}

			for($a = 1;$a <= $getMaxPosisi['max_kolom'];$a++ ){
				$arrayKolom[] = array($a,$a);
			}

			$comboRow=  cmbArray('row',$row,$arrayRow,'-- ROW --','');
			$comboKolom=  cmbArray('kolom',$kolom,$arrayKolom,'-- KOLOM --','');
			$content = array('comboRow' => $comboRow, 'comboKolom' => $comboKolom);

		break;
		}
		case 'saveNewGrup':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}
			 if(empty($title)){
			 	$err = "Isi Title";
			 }elseif(empty($maxRow)){
			 	$err = "Pilih Maksimal Row";
			 }elseif(empty($maxKolom)){
			 	$err = "Pilih Maksimal Kolom";
			 }else{
			 	$data = array(

								"title" => $title,
								"height" => $contentHeight,
								"content_background" => $contentBackground,
								"max_row" => $maxRow,
								"max_kolom" => $maxKolom,
								);
				$query = VulnWalkerInsert("grup",$data);
				mysql_query($query);
				$getMaxId = mysql_fetch_array(mysql_query("select max(id) from grup"));
				$comboGrup = cmbQuery('cmbGrup',$getMaxId['max(id)'],"select id, title from grup"," onchange=$this->Prefix.grupChanged();",'-- PILIH KATEGORI --');

			 }
				$content = array("cmbGrup"=> $comboGrup);
		break;
		}

		case 'saveEditGrup':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}
			 if(empty($title)){
			 	$err = "Isi Title";
			 }elseif(empty($maxRow)){
			 	$err = "Pilih Maksimal Row";
			 }elseif(empty($maxKolom)){
			 	$err = "Pilih Maksimal Kolom";
			 }else{
			 	$data = array(
								"height" => $contentHeight,
								"content_background" => $contentBackground,
								"title" => $title,
								"max_row" => $maxRow,
								"max_kolom" => $maxKolom,
								);
				$query = VulnWalkerUpdate("grup",$data,"id ='$id'");
				mysql_query($query);
				$comboGrup = cmbQuery('cmbGrup',$id,"select id, title from grup"," onchange=$this->Prefix.grupChanged();",'-- PILIH KATEGORI --');

			 }
				$content = array("cmbGrup"=> $comboGrup);
		break;
		}

		case 'formBaru':{
			$fm = $this->setFormBaru();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'Gambar':{
			$id = $_REQUEST['shortcut_cb'];

			$fm = $this->Gambar($id[0]);
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'newGrup':{
			$fm = $this->newGrup();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editGrup':{

			$fm = $this->editGrup($_REQUEST['id']);
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'formPengaturan':{
			$fm = $this->formPengaturan();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'uplineChanged':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}
			$getMaxNomorUrut = mysql_fetch_array(mysql_query("select max(nomor_urut) from $this->TblName where level ='$level' and upline='$upline'"));
			$nomorUrut = $getMaxNomorUrut['max(nomor_urut)'] + 1;
			$content = array("nomorUrut" => $nomorUrut);
		break;
		}

		case 'levelChanged':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}
		 $arrayUpline = array();
		 $levelUpline = $cmbLevel - 1;
		 $getDataUpline = mysql_query("select * from shortcut where level = '$levelUpline'");
		 while($rows = mysql_fetch_array($getDataUpline)){
		 	$getNamaStrukturUpline = mysql_fetch_array(mysql_query("select * from system where id='".$rows['id_system']."'"));
			$arrayUpline[] = array($rows['id'],$getNamaStrukturUpline['nama']);
		 }
		 $comboUpline = cmbArray('cmbUpline',$upline,$arrayUpline,'-- PILIH UPLINE --',"onchange = $this->Prefix.uplineChanged();");
		 $content = array("cmbUpline" => $comboUpline);


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

		case 'simpanUpload':{
			$get= $this->simpanUpload();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
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
 	function formPengaturan(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 250;
	 $this->form_height = 100;
	 $this->form_caption = 'PENGATURAN';

	 	$get = mysql_fetch_array(mysql_query("select * from setting_kolom "));
		$row = $get['row'];
		$kolom = $get['kolom'];

       //items ----------------------
	   $comboRow = cmbArray('maxRow',$row,$this->arrayRow,'-- MAX ROW --',"");
	   $comboKolom = cmbArray('maxKolom',$kolom,$this->arrayKolom,'-- MAX KOLOM --',"");
		  $this->form_fields = array(



			'row' => array(
							'label'=>'MAX ROW',
							'labelWidth'=>100,
							'value'=> $comboRow,
						),
			'kolom' => array(
							'label'=>'MAX KOLOM',
							'labelWidth'=>100,
							'value'=>$comboKolom,
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
			 "<script type='text/javascript' src='js/shortcut/shortcut.js' language='JavaScript' ></script>".
			  "<script type='text/javascript' src='js/shortcut/popupImages.js' language='JavaScript' ></script>
			  <script type='text/javascript' src='js/menuBar/popupStruktur.js' language='JavaScript' ></script>

			 ".			"<script src='js/spectrum/spectrum.js' type='text/javascript'></script>".
			 			"<link rel='stylesheet' href='js/spectrum/spectrum.css' type='text/css'>".
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
	 $this->form_width = 600;
	 $this->form_height = 150;
	 $tgl_update = date('d-m-Y');
	  if ($this->form_fmST==0) {
		$this->form_caption = 'SHORTCUT - Baru';
		$grup = $_REQUEST['filterGrup'];

		$status = "1";

	  }else{
		$this->form_caption = 'SHORTCUT - Edit';
		$get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$dt'"));
		foreach ($get as $key => $value) {
			  $$key = $value;
			}

		$getImagePasif = mysql_fetch_array(mysql_query("select * from images where id ='$image_pasif'"));
		$getKategoriImagePasif = mysql_fetch_array(mysql_query("select *  from images_kategori where id ='".$getImagePasif['kategori']."'"));
		$namaImagePasif = $getImagePasif['nama'];
		$fileLocationPasif = "Media/images/".$getKategoriImagePasif['nama']."/".$getImagePasif['directory'];
		$imageViewPasif = "<img src ='$fileLocationPasif' style='width:40px;height:40px;'></img>";

		$getImageAktif = mysql_fetch_array(mysql_query("select * from images where id ='$image_aktif'"));
		$getKategoriImageAktif = mysql_fetch_array(mysql_query("select *  from images_kategori where id ='".$getImageAktif['kategori']."'"));
		$namaImageAktif = $getImageAktif['nama'];
		$fileLocationAktif = "Media/images/".$getKategoriImageAktif['nama']."/".$getImageAktif['directory'];
		$imageViewAktif = "<img src ='$fileLocationAktif' style='width:40px;height:40px;'></img>";

		$getNamaStruktur = mysql_fetch_array(mysql_query("select * from system where id='$id_system'"));
		$namaStruktur = $getNamaStruktur['nama'];
	  }

	    $comboGrup = cmbQuery('cmbGrup',$grup,"select id, title from grup"," onchange=$this->Prefix.grupChanged(); ",'-- Pilih Kategori --');
		$arrayRow = array();
		$arrayKolom = array();
		$getMaxPosisi = mysql_fetch_array(mysql_query("select * from grup where id ='$grup'"));
		for($i = 1;$i <= $getMaxPosisi['max_row'];$i++ ){
			$arrayRow[] = array($i,$i);
		}

		for($a = 1;$a <= $getMaxPosisi['max_kolom'];$a++ ){
			$arrayKolom[] = array($a,$a);
		}

		$comboRow=  cmbArray('row',$row,$arrayRow,'-- ROW --','');
		$comboKolom=  cmbArray('kolom',$kolom,$arrayKolom,'-- KOLOM --','');



       //items ----------------------
		  $this->form_fields = array(




			'grup' => array(
						'label'=>'KATEGORI',
						'labelWidth'=>100,
						'value'=>$comboGrup." &nbsp <input type='button' value='Baru' onclick=$this->Prefix.newGrup(); >  &nbsp <input type='button' value='Edit' onclick=$this->Prefix.editGrup(); >",
						 ),
			'title' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='title' id='title'  value='".$title."' style='width:500px;'> ",
						 ),
			'hint' => array(
						'label'=>'HINT',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='hint' id='hint'  value='".$hint."' style='width:500px;'> ",
						 ),
			'kolom' => array(
						'label'=>'ROW',
						'labelWidth'=>100,
						'value'=>"$comboRow &nbsp KOLOM &nbsp&nbsp $comboKolom ",
						 ),
			'status' => array(
						'label'=>'STATUS',
						'labelWidth'=>100,
						'value'=>cmbArray('status',$status,$this->Status,'-- PILIH --','style="width:95px;"'),
						 ),


			);
		//tombol
		$this->form_menubawah =

			"<input type='hidden' name='idEdit' id='idEdit' value='$dt'><input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function Gambar($id){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 250;

		$this->form_caption = 'SHORTCUT - GAMBAR';
		$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));





		if(empty($getData['image_pasif'])){
			$imageViewPasif = "<img style='width:80px;height:80px;'  src='Media/default.jpg' />";
		}else{
			$idImagePasif = $getData['image_pasif'];
			$getImagePasif = mysql_fetch_array(mysql_query("select * from images where id ='$idImagePasif'"));
			$namaImagePasif = $getImagePasif['nama'];
			$getDirPasif = mysql_fetch_array(mysql_query("select * from images_kategori where id='".$getImagePasif['kategori']."'"));
			$imagePasifLocation = "Media/images/".$getDirPasif['nama']."/".$getImagePasif['directory'];
			$imageViewPasif = "<img style='width:80px;height:80px; ' src='$imagePasifLocation'/>";
		}
		if(empty($getData['image_aktif'])){
			$imageViewAktif = "<img style='width:80px;height:80px;'  src='Media/default.jpg' />";
		}else{
			$idImageAktif = $getData['image_aktif'];
			$getImageAktif = mysql_fetch_array(mysql_query("select * from images where id ='$idImageAktif'"));
			$namaImageAktif = $getImageAktif['nama'];
			$getDirAktif = mysql_fetch_array(mysql_query("select * from images_kategori where id='".$getImageAktif['kategori']."'"));
			$imageAktifLocation = "Media/images/".$getDirAktif['nama']."/".$getImageAktif['directory'];
			$imageViewAktif = "<img style='width:80px;height:80px; ' src='$imageAktifLocation'/>";
		}


       //items ----------------------
		  $this->form_fields = array(




			'imagePasif' => array(
						'label'=>'IMAGE PASIF',
						'labelWidth'=>100,
						'value'=>"<input type='hidden' name='imagePasif' id='imagePasif' value='".$getData['image_pasif']."'><input type='text' name='namaImagePasif' readonly id='namaImagePasif' value='".$namaImagePasif."' style='width:100px;'> &nbsp <input type='button' value='Pilih' onclick=$this->Prefix.findImage('pasif');>
						",
						 ),
			'asd' => array(
						'label'=>'IMAGE PASIF',
						'labelWidth'=>100,
						'value'=>"<span id='spanImagePasif'>$imageViewPasif </span> ",
						'type' => 'merge'
						 ),

			'imageAktif' => array(
						'label'=>'IMAGE AKTIF',
						'labelWidth'=>100,
						'value'=>"<input type='hidden' name='imageAktif' id='imageAktif' value='".$getData['image_aktif']."'><input type='text' name='namaImageAktif' readonly id='namaImageAktif' value='".$namaImageAktif."' style='width:100px;'> &nbsp <input type='button' value='Pilih' onclick=$this->Prefix.findImage('aktif');>
						 ",
						 ),
			'asdas' => array(
						'label'=>'IMAGE AKTIF',
						'labelWidth'=>100,
						'value'=>"<span id='spanImageAktif'>$imageViewAktif</span> ",
						'type' => 'merge'
						 ),

			);
		//tombol
		$this->form_menubawah =

			"<input type='hidden' name='idEdit' id='idEdit' value='$dt'><input type='button' value='Simpan' onclick ='".$this->Prefix.".saveGambar($id)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function showImage($id){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 250;

		$this->form_caption = 'SHORTCUT - GAMBAR';
		$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));





		if(empty($getData['image_pasif'])){
			$imageViewPasif = "<img style='width:80px;height:80px;'  src='Media/default.jpg' />";
		}else{
			$idImagePasif = $getData['image_pasif'];
			$getImagePasif = mysql_fetch_array(mysql_query("select * from images where id ='$idImagePasif'"));
			$namaImagePasif = $getImagePasif['nama'];
			$getDirPasif = mysql_fetch_array(mysql_query("select * from images_kategori where id='".$getImagePasif['kategori']."'"));
			$imagePasifLocation = "Media/images/".$getDirPasif['nama']."/".$getImagePasif['directory'];
			$imageViewPasif = "<img style='width:80px;height:80px; ' src='$imagePasifLocation'/>";
		}
		if(empty($getData['image_aktif'])){
			$imageViewAktif = "<img style='width:80px;height:80px;'  src='Media/default.jpg' />";
		}else{
			$idImageAktif = $getData['image_aktif'];
			$getImageAktif = mysql_fetch_array(mysql_query("select * from images where id ='$idImageAktif'"));
			$namaImageAktif = $getImageAktif['nama'];
			$getDirAktif = mysql_fetch_array(mysql_query("select * from images_kategori where id='".$getImageAktif['kategori']."'"));
			$imageAktifLocation = "Media/images/".$getDirAktif['nama']."/".$getImageAktif['directory'];
			$imageViewAktif = "<img style='width:80px;height:80px; ' src='$imageAktifLocation'/>";
		}


       //items ----------------------
		  $this->form_fields = array(




			'imagePasif' => array(
						'label'=>'IMAGE PASIF',
						'labelWidth'=>100,
						'value'=>"
						",
						 ),
			'asd' => array(
						'label'=>'IMAGE PASIF',
						'labelWidth'=>100,
						'value'=>"<span id='spanImagePasif'>$imageViewPasif </span> ",
						'type' => 'merge'
						 ),

			'imageAktif' => array(
						'label'=>'IMAGE AKTIF',
						'labelWidth'=>100,
						'value'=>"
						 ",
						 ),
			'asdas' => array(
						'label'=>'IMAGE AKTIF',
						'labelWidth'=>100,
						'value'=>"<span id='spanImageAktif'>$imageViewAktif</span> ",
						'type' => 'merge'
						 ),

			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Close' onclick ='".$this->Prefix.".Close()' >";
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
		$this->form_caption = 'SHORTCUT - Baru';
	  }else{
		$this->form_caption = 'SHORTCUT - Edit';
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
	   <th class='th01' width='50' align='center'>KATEGORI</th>
	   <th class='th01' width='50' align='center'>ROW/KOLOM</th>
	   <th class='th01' width='500' align='center'>TITLE</th>
	   <th class='th01' width='200' align='center'>HINT</th>
	   <th class='th01' width='200' align='center'>URL</th>
	   <th class='th01' width='50' align='center'>GAMBAR</th>
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
	 $getNamaGrup = mysql_fetch_array(mysql_query("select * from grup where id ='$grup'"));
	 $namaGrup = $getNamaGrup['title'];
	 $Koloms[] = array('align="left"',$namaGrup);


	 $Koloms[] = array('align="left"',$margin.$row.".".$kolom);
	 $Koloms[] = array('align="left"',$margin.$title);
	  $Koloms[] = array('align="left"',$margin.$hint);
	  $Koloms[] = array('align="left"',$margin."<a href='$url' target='_blank' >$url</a>");
	 if($status == "1"){
	 	$status = "AKTIF";
	 }else{
	 	$status = "TIDAK AKTIF";
	 }
	 $Koloms[] = array('align="center"',"<span style='color:red;cursor:pointer;' onclick=$this->Prefix.showImage($id)>SHOW</span>");
	 $Koloms[] = array('align="left"',$status);


	 return $Koloms;
	}


	function genDaftarOpsi(){
	 global $Ref, $Main;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}


	 if(empty($jumlahPerHal))$jumlahPerHal = "25";
	  $arr = array(
	  		array('1','AKTIF'),
			array('0','TIDAK AKTIF'),

			);
		$comboStatus = cmbArray('statusFilter',$statusFilter,$arr,'-- SEMUA STATUS --',"onchange= $this->Prefix.refreshList(true)");


	 $queryCmbGrup = "select id, title from grup ";
	 $comboGrup = cmbQuery('filterGrup',$filterGrup,$queryCmbGrup," onchange =$this->Prefix.refreshList(true); style='width:400px;'",'-- Semua Kategori --');




	 $TampilOpt =
			"<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td>KATEGORI </td>
			<td>: </td>
			<td style='width:90%;'>$comboGrup </td>
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
			<td style='width:90%;'><input type= 'text' id='jumlahPerHal' name='jumlahPerHal' value='$jumlahPerHal' style='width:40px;'> <input type='button' value='Tampilkan' onclick=$this->Prefix.refreshList(true) </td>
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
		if(!empty($filterGrup))$arrKondisi[] = "grup = '$filterGrup'";
		if($statusFilter !='')$arrKondisi[]="status ='$statusFilter'";


		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		$arrOrders[] = "concat(right((100 +grup),2),'.',right((100 +row),2),'.',right((100 +kolom),2))";
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


	function newGrup(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 150;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 	$this->form_caption = 'BARU';

	 $queryCmbMenuBar = "select id, title from menu_bar where level = '1' and status = '1' ";
	 $comboMenuBar = cmbQuery('cmbMenuBar',$cmbMenuBar,$queryCmbMenuBar," ",'-- PILIH MENU BAR --');
	  $comboRow = cmbArray('maxRow',$row,$this->arrayRow,'-- MAX ROW --',"");
	   $comboKolom = cmbArray('maxKolom',$kolom,$this->arrayKolom,'-- MAX KOLOM --',"");

	 //items ----------------------
	  $this->form_fields = array(


			// 'menuBar' => array(
			// 			'label'=>'MENU BAR',
			// 			'labelWidth'=>100,
			// 			'value'=>$comboMenuBar,
			// 			 ),
			'asd' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleKategori' id='titleKategori' style='width:250px;' value=''>",
						 ),
			'height' => array(
						'label'=>'CONTENT HEIGHT',
						'labelWidth'=>100,
						'value'=>"<input type = 'number' name='contentHeight' id='contentHeight' style='width:250px;' value='48'>",
						 ),
			'backgroundColor' => array(
						'label'=>'CONTENT BACKGROUND',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='contentBackground' id='contentBackground' style='width:250px;' >",
						 ),

			// '12' => array(
			// 			'label'=>'URL',
			// 			'labelWidth'=>100,
			// 			'value'=>"<input type = 'text' name='urlKategori' id='urlKategori' style='width:250px;' value=''>",
			// 			 ),
			'maxRow' => array(
						'label'=>'MAX ROW',
						'labelWidth'=>100,
						'value'=>$comboRow,
						 ),
			'maxKolom' => array(
						'label'=>'MAX KOLOM',
						'labelWidth'=>100,
						'value'=>$comboKolom,
						 ),





			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNewGrup()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editGrup($id){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 150;


	 	$this->form_caption = 'EDIT';
		$getData = mysql_fetch_array(mysql_query("select * from grup where id ='$id'"));
		foreach ($getData as $key => $value) {
				  $$key = $value;
				}
	 	$queryCmbMenuBar = "select id, title from menu_bar where level = '1' ";
		$comboMenuBar = cmbQuery('cmbMenuBar',$id_menu_bar,$queryCmbMenuBar," ",'-- PILIH MENU BAR --');
	    $comboRow = cmbArray('maxRow',$max_row,$this->arrayRow,'-- MAX ROW --',"");
	    $comboKolom = cmbArray('maxKolom',$max_kolom,$this->arrayKolom,'-- MAX KOLOM --',"");

	 //items ----------------------
	  $this->form_fields = array(


			// 'menuBar' => array(
			// 			'label'=>'MENU BAR',
			// 			'labelWidth'=>100,
			// 			'value'=>$comboMenuBar,
			// 			 ),
			'asd' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleKategori' id='titleKategori' style='width:250px;' value='$title'>",
						 ),
			// '12' => array(
			// 			'label'=>'URL',
			// 			'labelWidth'=>100,
			// 			'value'=>"<input type = 'text' name='urlKategori' id='urlKategori' style='width:250px;' value='$url'>",
			// 			 ),
			'height' => array(
						'label'=>'CONTENT HEIGHT',
						'labelWidth'=>100,
						'value'=>"<input type = 'number' name='contentHeight' id='contentHeight' style='width:250px;' value='$height'>",
						 ),
			'backgroundColor' => array(
						'label'=>'CONTENT BACKGROUND',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='contentBackground' id='contentBackground' style='width:250px;' value='$content_background' >",
						 ),
			'maxRow' => array(
						'label'=>'MAX ROW',
						'labelWidth'=>100,
						'value'=>$comboRow,
						 ),
			'maxKolom' => array(
						'label'=>'MAX KOLOM',
						'labelWidth'=>100,
						'value'=>$comboKolom,
						 ),





			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveEditGrup($id)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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

}
$shortcut = new shortcutObj();
$shortcut->username =$_COOKIE['coID'];
?>
