<?php
class generalSettingObj  extends DaftarObj2{
	var $Prefix = 'generalSetting';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'general_setting'; //daftar
	var $TblName_Hapus = 'general_setting';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'GENERAL SETTING';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'System';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'generalSettingForm';
	var $username = "";

	var $Status = array(
				array('1','AKTIF'),
				array('2','TIDAK AKTIF'),
		);

    var $arrayVisible = array(
				array('true','TRUE'),
				array('false','FALSE'),
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
		return '';
	}

	function setMenuView(){
		return "";
	}
	function setMenuEdit(){
		return
			"";
		;
	}

function setPage_HeaderOther(){

		return
		"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
		<tr>
		<td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=generalSetting\"  style='color : blue;'' > SETTING </a> |
		<A href=\"pages.php?Pg=onepage\"   > SYSTEM </a> |

		<A href=\"pages.php?Pg=menuBar\"   > MENU BAR </a> |
		<A href=\"pages.php?Pg=shortcut\"   > SHORTCUT </a> |
		<A href=\"pages.php?Pg=ref_images\"   > IMAGES </a> |
		<A href=\"pages.php?Pg=ref_images\"   > FOOTER </a> |
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
									'title' => $title,
									'url' => $url,
									'hint' => $hint,
									'status' => $status,
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
									'title' => $title,
									'url' => $url,
									'hint' => $hint,
									'status' => $status,
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


		case 'saveKolom':{
			$data = array("row" => $_REQUEST['maxRow'], "kolom" => $_REQUEST['maxKolom']);
			$query = VulnWalkerUpdate("setting_kolom",$data,"1=1");
			mysql_query($query);

		break;
		}

		case 'saveFontMenubar':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $fontMenubar);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='font_menu_bar'"));

		break;
		}

		case 'saveFontStyle':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $fontStyle);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='font_style'"));

		break;
		}

		case 'saveContentJenisFont':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $fontStyle);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='content_font_style'"));

		break;
		}
		case 'saveSiteTitle':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $siteTitle);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='site_title'"));

		break;
		}

		case 'saveCopyright':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $copyrightTitle);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='copyright_title'"));

		break;
		}

		case 'saveFooter':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $footerText);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='footer_text'"));

		break;
		}

		case 'saveFooterFontSize':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $footerFontSize);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='footer_font_size'"));

		break;
		}

		case 'saveNavFontSize':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $navFontSize);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='navFontSize'"));

		break;
		}

		case 'saveFontSizeShortcut':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $fontSizeShortcut);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='fontSizeShortcut'"));

		break;
		}

		case 'saveShortcutContentFontSize':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $shortcutContentFontSize);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='shortcutContentFontSize'"));

		break;
		}

		case 'saveTableBorderSize':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $tableBorderSize);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='tableBorderSize'"));

		break;
		}

		case 'saveShortcutContentFontColor':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $shortcutContentFontColor);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='shortcutContentFontColor'"));

		break;
		}

		case 'saveShortcutContentFontColorHover':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $shortcutContentFontColorHover);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='shortcutContentFontColorHover'"));

		break;
		}

		case 'saveShortcutFontColor':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $shortcutFontColor);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='shortcutFontColor'"));

		break;
		}

		case 'saveTableBackgroundColor':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $tableBackgroundColor);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='tableBackgroundColor'"));

		break;
		}

		case 'saveTableBorderColor':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $tableBorderColor);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='tableBorderColor'"));

		break;
		}

		case 'saveShortcutFontType':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $shortcutFontType);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='shortcutFontType'"));

		break;
		}

		case 'saveShortcutContentFontType':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $shortcutContentFontType);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='shortcutContentFontType'"));

		break;
		}

		case 'saveMenuBarVisible':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $menuBarVisible);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='show_menu_bar'"));

		break;
		}
		case 'saveContentBackgroudActive':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $backgroundStatus);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='content_background_active'"));

		break;
		}
		case 'saveDateVisible':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $dateVisible);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='date_visible'"));

		break;
		}

		case 'saveCopyrightVisible':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $copyrightVisible);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='copyright_visible'"));

		break;
		}

		case 'saveFooterVisible':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $footerVisible);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='footer_visible'"));

		break;
		}
		case 'saveFooterImage':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $footerImage);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='footer_image'"));

		break;
		}
		case 'saveHeaderLogo':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $headerLogo);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='header_logo'"));

		break;
		}
		case 'saveHeaderImage':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $headerImage);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='header_image'"));

		break;
		}
		case 'saveSiteImages':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $siteImage);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='site_image'"));

		break;
		}
		case 'saveContentImage':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $contentImage);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='content_image'"));

		break;
		}
		case 'hapusContentImage':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $hapusContentImage);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='content_image'"));

		break;
		}
		case 'saveSiteUrl':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $siteUrl);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='site_url'"));

		break;
		}
		case 'saveHeaderTitle':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $headerTitle);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='header_title'"));

		break;
		}
		case 'saveHeightHeader':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $headerHeight);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='header_height'"));

		break;
		}
		case 'saveHeaderFontSize':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $headerFontSize);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='header_font_size'"));

		break;
		}
		case 'saveHeightLogo':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $logoHeight);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='height_logo'"));

		break;
		}
		case 'saveHeightMenubar':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $heightMenubar);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='height_menubar'"));

		break;
		}
		case 'saveMenubarFontSize':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $menubarFontSize);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='menubar_font_size'"));

		break;
		}
		case 'saveDropdownFontSize':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $dropdownFontSize);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='dropdown_font_size'"));

		break;
		}
		case 'saveWidthLogo':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $logoWidth);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='width_logo'"));

		break;
		}
		case 'saveHeaderColor':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $headerColor);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='header_color'"));

		break;
		}

		case 'saveDropDownBackGroundColor':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $dropDownColor);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='dropdown_background_color'"));

		break;
		}

		case 'saveColorHoverMenubar':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $menubarColorHover);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='color_hover_menubar'"));

		break;
		}

		case 'saveHoverMenubar':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $hoverMenubar);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='hoverMenubar'"));

		break;
		}

		case 'saveHeaderTextColor':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $headerTextColor);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='header_text_color'"));

		break;
		}

		case 'saveCopyrightColor':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $copyrightColor);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='copyright_color'"));

		break;
		}

		case 'saveWarnaBackground':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $warnaBackground);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='background_content'"));

		break;
		}

		case 'saveMenuBarColor':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $menuColor);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='menu_bar_color'"));

		break;
		}

		case 'saveColorTextMenubar':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $colorTextMenubar);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='font_color_menubar'"));

		break;
		}

		case 'saveColorBorder':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $colorBorder);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='color_border_menubar'"));

		break;
		}

		case 'saveFooterColor':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $footerColor);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='footer_color'"));

		break;
		}

		case 'saveFooterColorHover':{
			foreach ($_REQUEST as $key => $value) {
			  $$key = $value;
			}
			$data = array('option_value' => $footerColorHover);
			mysql_query(VulnWalkerUpdate($this->TblName,$data,"option_name ='footerColorHover'"));

		break;
		}

		case 'editSiteTitle':{
			$fm = $this->editSiteTitle();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editFontStyle':{
			$fm = $this->editFontStyle();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editContentJenisFont':{
			$fm = $this->editContentJenisFont();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editFontMenubar':{
			$fm = $this->editFontMenubar();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editCopyRightText':{
			$fm = $this->editCopyRightText();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editFooterFontSize':{
			$fm = $this->editFooterFontSize();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editNavFontSize':{
			$fm = $this->editNavFontSize();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editFontSizeShortcut':{
			$fm = $this->editFontSizeShortcut();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editShortcutContentFontSize':{
			$fm = $this->editShortcutContentFontSize();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editTableBackgroundColor':{
			$fm = $this->editTableBackgroundColor();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editTableBorderColor':{
			$fm = $this->editTableBorderColor();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editTableBorderSize':{
			$fm = $this->editTableBorderSize();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editShortcutFontColor':{
			$fm = $this->editShortcutFontColor();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editShortcutContentFontColor':{
			$fm = $this->editShortcutContentFontColor();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editShortcutContentFontColorHover':{
			$fm = $this->editShortcutContentFontColorHover();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editShortcutFontType':{
			$fm = $this->editShortcutFontType();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editShortcutContentFontType':{
			$fm = $this->editShortcutContentFontType();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editFooterText':{
			$fm = $this->editFooterText();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editSiteUrl':{
			$fm = $this->editSiteUrl();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editHeaderTitle':{
			$fm = $this->editHeaderTitle();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editHeightHeader':{
			$fm = $this->editHeightHeader();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editHeaderFontSize':{
			$fm = $this->editHeaderFontSize();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editHeightLogo':{
			$fm = $this->editHeightLogo();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editHeightMenubar':{
			$fm = $this->editHeightMenubar();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editMenubarFontSize':{
			$fm = $this->editMenubarFontSize();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editDropdownFontSize':{
			$fm = $this->editDropdownFontSize();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editWidthLogo':{
			$fm = $this->editWidthLogo();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editMenuBarVisible':{
			$fm = $this->editMenuBarVisible();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editContentBackGroundActive':{
			$fm = $this->editContentBackGroundActive();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editDateVisible':{
			$fm = $this->editDateVisible();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editCopyRightVisible':{
			$fm = $this->editCopyRightVisible();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editFooterVisible':{
			$fm = $this->editFooterVisible();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editHeaderLogo':{
			$fm = $this->editHeaderLogo();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editFooterImage':{
			$fm = $this->editFooterImage();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editHeaderImage':{
			$fm = $this->editHeaderImage();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editSiteImage':{
			$fm = $this->editSiteImage();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'editContentImage':{
			$fm = $this->editContentImage();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editHeaderColor':{
			$fm = $this->editHeaderColor();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editDropDownBackGroundColor':{
			$fm = $this->editDropDownBackGroundColor();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editColorHoverMenubar':{
			$fm = $this->editColorHoverMenubar();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editHoverMenubar':{
			$fm = $this->editHoverMenubar();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editHeaderTextColor':{
			$fm = $this->editHeaderTextColor();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editCopyRightColor':{
			$fm = $this->editCopyRightColor();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editWarnaBackground':{
			$fm = $this->editWarnaBackground();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editMenuBarColor':{
			$fm = $this->editMenuBarColor();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editColorTextMenubar':{
			$fm = $this->editColorTextMenubar();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editColorBorder':{
			$fm = $this->editColorBorder();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editFooterColor':{
			$fm = $this->editFooterColor();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'editFooterColorHover':{
			$fm = $this->editFooterColorHover();
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
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>
			<link rel='stylesheet' href='css/fontselect.css.css' type='text/css'>".
			"<script src='js/jquery.js' type='text/javascript'></script>".
			/*"<script src='js/jscolor.js' type='text/javascript'></script>".*/
			"<script src='js/spectrum/spectrum.js' type='text/javascript'></script>".
			"<link rel='stylesheet' href='js/spectrum/spectrum.css' type='text/css'>".
			 "<script type='text/javascript' src='js/generalSetting/generalSetting.js' language='JavaScript' ></script>".
			  "<script type='text/javascript' src='js/shortcut/popupImages.js' language='JavaScript' ></script>
			  <script type='text/javascript' src='js/jquery.fontselect.js' language='JavaScript' ></script>
			 <style>

						 .full-spectrum .sp-palette {
						max-width: 200px;
						}

			</style>


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
	 $this->form_height = 250;
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


			'title' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='title' id='title' value='".$title."' style='width:500px;'>",
						 ),

			'alamat_url' => array(
						'label'=>'URL',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='url' id='url' value='".$url."' style='width:500px;'>",
						 ),

			'hint' => array(
						'label'=>'HINT',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='hint' id='hint' value='$hint' style='width:500px;'>",
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


	function editSiteTitle(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 80;
	 $this->form_caption = 'SITE TITLE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='site_title'"));
		$siteTitle = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'SITE TITLE',
							'labelWidth'=>80,
							'value'=>"<input type='text' id='siteTitle' name='siteTitle' value='$siteTitle'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveSiteTitle()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

function editFontStyle(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 80;
	 $this->form_caption = 'FONT HEADER';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='font_style'"));
		$fontStyle = $get['option_value'];
		  $this->form_fields = array(



			'title' => array(
							'label'=>'FONT HEADER',
							'labelWidth'=>100,
							'value'=>"<input type='text' id='fontStyle' name='fontStyle' style='cursor:pointer;' value='$fontStyle'>
							",
						),





			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveFontStyle()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
function editContentJenisFont(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 80;
	 $this->form_caption = 'FONT STYLE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='content_font_style'"));
		$fontStyle = $get['option_value'];
		  $this->form_fields = array(



			'title' => array(
							'label'=>'FONT STYLE',
							'labelWidth'=>80,
							'value'=>"<input type='text' id='fontStyle' name='fontStyle' style='cursor:pointer;' value='$fontStyle'>
							",
						),





			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveContentJenisFont()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editFontMenubar(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 80;
	 $this->form_caption = 'FONT MENU BAR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='font_menu_bar'"));
		$fontMenubar = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FONT MENU BAR',
							'labelWidth'=>110,
							'value'=>"<input type='text' id='fontMenubar' name='fontMenubar' style='cursor:pointer;' value='$fontMenubar'>
							",
						),

			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveFontMenubar()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editCopyRightText(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 80;
	 $this->form_caption = 'COPYRIGHT TEXT';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='copyright_title'"));
		$copyrightTitle = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'COPYRIGHT TEXT',
							'labelWidth'=>140,
							'value'=>"<input type='text' id='copyrightTitle' name='copyrightTitle' value='$copyrightTitle'>
							",
						),

			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveCopyright()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editFooterFontSize(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 80;
	 $this->form_caption = 'COPYRIGHT FONT SIZE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='footer_font_size'"));
		$footerFontSize = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER FONT SIZE',
							'labelWidth'=>150,
							'value'=>"<input type='number' id='footerFontSize' name='footerFontSize' value='$footerFontSize'>
							",
						),

			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveFooterFontSize()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editNavFontSize(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 80;
	 $this->form_caption = 'FOOTER FONT SIZE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='navFontSize'"));
		$navFontSize = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER FONT SIZE',
							'labelWidth'=>150,
							'value'=>"<input type='number' id='navFontSize' name='navFontSize' value='$navFontSize'>
							",
						),

			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNavFontSize()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editFontSizeShortcut(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 80;
	 $this->form_caption = 'SHORTCUT FONT SIZE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='fontSizeShortcut'"));
		$fontSizeShortcut = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER FONT SIZE',
							'labelWidth'=>150,
							'value'=>"<input type='number' id='fontSizeShortcut' name='fontSizeShortcut' value='$fontSizeShortcut'>
							",
						),

			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveFontSizeShortcut()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editShortcutContentFontSize(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 80;
	 $this->form_caption = 'SHORTCUT FONT SIZE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='shortcutContentFontSize'"));
		$shortcutContentFontSize = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER FONT SIZE',
							'labelWidth'=>150,
							'value'=>"<input type='number' id='shortcutContentFontSize' name='shortcutContentFontSize' value='$shortcutContentFontSize'>
							",
						),

			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveShortcutContentFontSize()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editShortcutFontColor(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'FOOTER COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='shortcutFontColor'"));
		$shortcutFontColor = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER COLOR',
							'labelWidth'=>100,
							'value'=>"<input   id='shortcutFontColor' name='shortcutFontColor' value='$shortcutFontColor' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveShortcutFontColor()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$menuColor, 'err'=>$err, 'content'=>$content);
	}

	function editTableBackgroundColor(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'TABLE BACKGROUND COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='tableBackgroundColor'"));
		$tableBackgroundColor = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER COLOR',
							'labelWidth'=>100,
							'value'=>"<input   id='tableBackgroundColor' name='tableBackgroundColor' value='$tableBackgroundColor' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveTableBackgroundColor()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$menuColor, 'err'=>$err, 'content'=>$content);
	}

	function editTableBorderColor(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'TABLE BORDER COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='tableBorderColor'"));
		$tableBorderColor = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER COLOR',
							'labelWidth'=>100,
							'value'=>"<input   id='tableBorderColor' name='tableBorderColor' value='$tableBorderColor' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveTableBorderColor()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$menuColor, 'err'=>$err, 'content'=>$content);
	}

	function editTableBorderSize(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'TABLE BORDER COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='tableBorderSize'"));
		$tableBorderSize = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'TABLE BORDER SIZE',
							'labelWidth'=>150,
							'value'=>"<input type='number' id='tableBorderSize' name='tableBorderSize' value='$tableBorderSize'>
							",
						),

			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveTableBorderSize()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$menuColor, 'err'=>$err, 'content'=>$content);
	}

	function editShortcutContentFontColor(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'FOOTER COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='shortcutContentFontColor'"));
		$shortcutContentFontColor = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER COLOR',
							'labelWidth'=>100,
							'value'=>"<input   id='shortcutContentFontColor' name='shortcutContentFontColor' value='$shortcutContentFontColor' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveShortcutContentFontColor()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$menuColor, 'err'=>$err, 'content'=>$content);
	}

	function editShortcutContentFontColorHover(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'FOOTER COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='shortcutContentFontColorHover'"));
		$shortcutContentFontColorHover = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER COLOR',
							'labelWidth'=>100,
							'value'=>"<input   id='shortcutContentFontColorHover' name='shortcutContentFontColorHover' value='$shortcutContentFontColorHover' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveShortcutContentFontColorHover()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$menuColor, 'err'=>$err, 'content'=>$content);
	}

	function editShortcutFontType(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 80;
	 $this->form_caption = 'FONT MENU BAR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='shortcutFontType'"));
		$shortcutFontType = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FONT MENU BAR',
							'labelWidth'=>110,
							'value'=>"<input type='text' id='shortcutFontType' name='shortcutFontType' style='cursor:pointer;' value='$shortcutFontType'>
							",
						),

			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveShortcutFontType()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editShortcutContentFontType(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 80;
	 $this->form_caption = 'FONT MENU BAR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='shortcutContentFontType'"));
		$shortcutContentFontType = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FONT MENU BAR',
							'labelWidth'=>110,
							'value'=>"<input type='text' id='shortcutContentFontType' name='shortcutContentFontType' style='cursor:pointer;' value='$shortcutContentFontType'>
							",
						),

			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveShortcutContentFontType()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editFooterText(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 300;
	 $this->form_height = 80;
	 $this->form_caption = 'FOOTER TEXT';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='footer_text'"));
		$footerText = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER TEXT',
							'labelWidth'=>110,
							'value'=>"<input type='text' id='footerText' name='footerText' value='$footerText'>
							",
						),

			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveFooter()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editHeaderTitle(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'HEADER TITLE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='header_title'"));
		$headerTitle = $get['option_value'];
		  $this->form_fields = array(



			'title' => array(
							'label'=>'HEADER TITLE',
							'labelWidth'=>100,
							'value'=>"<input type='text' id='headerTitle' name='headerTitle' value='$headerTitle' style='width:250px;'>
							",
						),





			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveHeaderTitle()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editHeightHeader(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'HEADER HEIGHT';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='header_height'"));
		$headerHeight = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'HEADER HEIGHT',
							'labelWidth'=>100,
							'value'=>"<input type='number' id='headerHeight' name='headerHeight' value='$headerHeight'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveHeightHeader()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editHeaderFontSize(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'HEADER FONT SIZE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='header_font_size'"));
		$headerFontSize = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'HEADER FONT SIZE',
							'labelWidth'=>150,
							'value'=>"<input type='number' id='headerFontSize' name='headerFontSize' value='$headerFontSize'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveHeaderFontSize()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editHeightLogo(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'LOGO HEIGHT';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='height_logo'"));
		$logoHeight = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'LOGO HEIGHT',
							'labelWidth'=>100,
							'value'=>"<input type='number' id='logoHeight' name='logoHeight' value='$logoHeight'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveHeightLogo()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editHeightMenubar(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'HEIGHT MENU BAR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='height_menubar'"));
		$heightMenubar = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'HEIGHT MENU BAR',
							'labelWidth'=>150,
							'value'=>"<input type='number' id='heightMenubar' name='heightMenubar' value='$heightMenubar'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveHeightMenubar()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editMenubarFontSize(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'MENU BAR FONT SIZE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='menubar_font_size'"));
		$menubarFontSize = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'MENU BAR FONT SIZE',
							'labelWidth'=>150,
							'value'=>"<input type='number' id='menubarFontSize' name='menubarFontSize' value='$menubarFontSize'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveMenubarFontSize()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editDropdownFontSize(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'DROPDOWN FONT SIZE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='dropdown_font_size'"));
		$dropdownFontSize = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'DROPDOWN FONT SIZE',
							'labelWidth'=>150,
							'value'=>"<input type='number' id='dropdownFontSize' name='dropdownFontSize' value='$dropdownFontSize'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveDropdownFontSize()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editWidthLogo(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'LOGO WIDTH';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='width_logo'"));
		$logoWidth = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'LOGO WIDTH',
							'labelWidth'=>100,
							'value'=>"<input type='number' id='logoWidth' name='logoWidth' value='$logoWidth'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveWidthLogo()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editMenuBarVisible(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'MENU BAR VISIBLE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='show_menu_bar'"));
		$menuBarVisible = $get['option_value'];

		  $this->form_fields = array(



			'title' => array(
							'label'=>'BACKGROUND STATUS',
							'labelWidth'=>150,
							'value'=>cmbArray('menuBarVisible',$menuBarVisible,$this->arrayVisible,'-- PILIH --','style="width:95px;"')
							,
						),





			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveMenuBarVisible()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function editContentBackGroundActive(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'CONTENT BACKGROUND ACTIVE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='content_background_active'"));
		$backgroundStatus = $get['option_value'];
		$Status = array(
						array('COLOR' , "COLOR"),
						array('IMAGE' , "IMAGE"),
		);
		  $this->form_fields = array(



			'title' => array(
							'label'=>'BACKGROUND ACTIVE',
							'labelWidth'=>150,
							'value'=>cmbArray('backgroundStatus',$backgroundStatus,$Status,'-- PILIH --','style="width:95px;"')
							,
						),





			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveContentBackgroudActive()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function editDateVisible(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'DATE VISIBLE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='date_visible'"));
		$dateVisible = $get['option_value'];

		  $this->form_fields = array(
			'title' => array(
							'label'=>'DATE VISIBLE',
							'labelWidth'=>150,
							'value'=>cmbArray('dateVisible',$dateVisible,$this->arrayVisible,'-- PILIH --','style="width:95px;"')
							,
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveDateVisible()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function editCopyRightVisible(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'COPYRIGHT VISIBLE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='copyright_visible'"));
		$copyrightVisible = $get['option_value'];

		  $this->form_fields = array(
			'title' => array(
							'label'=>'COPYRIGHT VISIBLE',
							'labelWidth'=>150,
							'value'=>cmbArray('copyrightVisible',$copyrightVisible,$this->arrayVisible,'-- PILIH --','style="width:95px;"')
							,
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveCopyrightVisible()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editFooterVisible(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'FOOTER VISIBLE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='footer_visible'"));
		$footerVisible = $get['option_value'];

		  $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER VISIBLE',
							'labelWidth'=>150,
							'value'=>cmbArray('footerVisible',$footerVisible,$this->arrayVisible,'-- PILIH --','style="width:95px;"')
							,
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveFooterVisible()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editHeaderLogo(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 180;
	 $this->form_height = 210;
	 $this->form_caption = 'HEADER LOGO';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='header_logo'"));
		$headerLogo = $get['option_value'];
		$getDetailImage = mysql_fetch_array(mysql_query("select * from images where id ='$headerLogo'"));
		$getKategoriImage = mysql_fetch_array(mysql_query("select * from images_kategori where id ='".$getDetailImage['kategori']."'"));
		 $fileLocation = "Media/images/".$getKategoriImage['nama']."/".$getDetailImage['directory'];
		 $this->form_fields = array(



			'title' => array(
							'label'=>'HEADER TITLE',
							'labelWidth'=>100,
							'type'=>'merge',
							'value'=>"<img src='$fileLocation' id='imageView' name ='imageView' style='width:150px;height:150px;'></img><br><br><input type='button' value='GANTI' onclick=$this->Prefix.findImage();> <input type='hidden' id='headerLogo' name='headerLogo' value='$headerLogo' >
							",
						),





			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveHeaderLogo()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editFooterImage(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 180;
	 $this->form_height = 210;
	 $this->form_caption = 'FOOTER IMAGE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='footer_image'"));
		$footerImage = $get['option_value'];
		$getDetailImage = mysql_fetch_array(mysql_query("select * from images where id ='$footerImage'"));
		$getKategoriImage = mysql_fetch_array(mysql_query("select * from images_kategori where id ='".$getDetailImage['kategori']."'"));
		 $fileLocation = "Media/images/".$getKategoriImage['nama']."/".$getDetailImage['directory'];
		 $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER IMAGE',
							'labelWidth'=>100,
							'type'=>'merge',
							'value'=>"<img src='$fileLocation' id='imageView' name ='imageView' style='width:150px;height:150px;'></img><br><br><input type='button' value='GANTI' onclick=$this->Prefix.findFooterImage();> <input type='hidden' id='footerImage' name='footerImage' value='$footerImage' >
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveFooterImage()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editHeaderImage(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 180;
	 $this->form_height = 210;
	 $this->form_caption = 'HEADER IMAGE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='header_image'"));
		$headerImage = $get['option_value'];
		$getDetailImage = mysql_fetch_array(mysql_query("select * from images where id ='$headerImage'"));
		$getKategoriImage = mysql_fetch_array(mysql_query("select * from images_kategori where id ='".$getDetailImage['kategori']."'"));
		 $fileLocation = "Media/images/".$getKategoriImage['nama']."/".$getDetailImage['directory'];
		 $this->form_fields = array(

			'title' => array(
							'label'=>'HEADER IMAGE',
							'labelWidth'=>100,
							'type'=>'merge',
							'value'=>"<img src='$fileLocation' id='imageView' name ='imageView' style='width:150px;height:150px;'></img><br><br><input type='button' value='GANTI' onclick=$this->Prefix.findHeaderImage();> <input type='hidden' id='headerImage' name='headerImage' value='$headerImage' >
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveHeaderImage()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editSiteImage(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 180;
	 $this->form_height = 210;
	 $this->form_caption = 'SITE IMAGE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='site_image'"));
		$siteImage = $get['option_value'];
		$getDetailImage = mysql_fetch_array(mysql_query("select * from images where id ='$siteImage'"));
		$getKategoriImage = mysql_fetch_array(mysql_query("select * from images_kategori where id ='".$getDetailImage['kategori']."'"));
		 $fileLocation = "Media/images/".$getKategoriImage['nama']."/".$getDetailImage['directory'];
		 $this->form_fields = array(



			'title' => array(
							'label'=>'HEADER TITLE',
							'labelWidth'=>100,
							'type'=>'merge',
							'value'=>"<img src='$fileLocation' id='imageView' name ='imageView' style='width:150px;height:150px;'></img><br><br><input type='button' value='GANTI' onclick=$this->Prefix.findSiteImage();> <input type='hidden' id='siteImage' name='siteImage' value='$siteImage' >
							",
						),





			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveSiteImages()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function editContentImage(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 180;
	 $this->form_height = 210;
	 $this->form_caption = 'CONTENT IMAGE';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='content_image'"));
		$contentImage = $get['option_value'];
		$getDetailImage = mysql_fetch_array(mysql_query("select * from images where id ='$contentImage'"));
		$getKategoriImage = mysql_fetch_array(mysql_query("select * from images_kategori where id ='".$getDetailImage['kategori']."'"));
		 $fileLocation = "Media/images/".$getKategoriImage['nama']."/".$getDetailImage['directory'];
		 $this->form_fields = array(



			'title' => array(
							'label'=>'HEADER TITLE',
							'labelWidth'=>100,
							'type'=>'merge',
							'value'=>"<img src='$fileLocation' id='imageView' name ='imageView' style='width:150px;height:150px;'></img><br><br><input type='button' value='GANTI' onclick=$this->Prefix.findContentImage();> <input type='hidden' id='contentImage' name='contentImage' value='$contentImage' >
							",
						),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Hapus' onclick ='".$this->Prefix.".hapusContentImage()' title='Hapus' >"."&nbsp&nbsp".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveContentImage()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editHeaderColor(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'HEADER COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='header_color'"));
		$headerColor = $get['option_value'];
		  $this->form_fields = array(



			'title' => array(
							'label'=>'HEADER COLOR',
							'labelWidth'=>100,
							'value'=>"<input   id='headerColor' name='headerColor' value='$headerColor' style='width:250px;'>
							",
						),





			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveHeaderColor()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$headerColor, 'err'=>$err, 'content'=>$content);
	}


	function editDropDownBackGroundColor(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'DROP DOWN BACKGROUND COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='dropdown_background_color'"));
		$dropDownColor = $get['option_value'];
		  $this->form_fields = array(



			'title' => array(
							'label'=>'HEADER COLOR',
							'labelWidth'=>100,
							'value'=>"<input   id='dropDownColor' name='dropDownColor' value='$dropDownColor' style='width:250px;'>
							",
						),





			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveDropDownBackGroundColor()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$headerColor, 'err'=>$err, 'content'=>$content);
	}

	function editColorHoverMenubar(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'COLOR HOVER MENU BAR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='color_hover_menubar'"));
		$menubarColorHover = $get['option_value'];
		  $this->form_fields = array(



			'title' => array(
							'label'=>'COLOR FONT HOVER MENU BAR',
							'labelWidth'=>100,
							'value'=>"<input   id='menubarColorHover' name='menubarColorHover' value='$menubarColorHover' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveColorHoverMenubar()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$headerColor, 'err'=>$err, 'content'=>$content);
	}

	function editHoverMenubar(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'COLOR HOVER MENU BAR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='hoverMenubar'"));
		$hoverMenubar = $get['option_value'];
		  $this->form_fields = array(



			'title' => array(
							'label'=>'COLOR HOVER MENU BAR',
							'labelWidth'=>100,
							'value'=>"<input   id='hoverMenubar' name='hoverMenubar' value='$hoverMenubar' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveHoverMenubar()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$headerColor, 'err'=>$err, 'content'=>$content);
	}

	function editHeaderTextColor(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'HEADER TEXT COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='header_text_color'"));
		$headerTextColor = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'HEADER TEXT COLOR',
							'labelWidth'=>150,
							'value'=>"<input   id='headerTextColor' name='headerTextColor' value='$headerTextColor' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveHeaderTextColor()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$headerColor, 'err'=>$err, 'content'=>$content);
	}

	function editCopyRightColor(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'COPYRIGHT COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='copyright_color'"));
		$copyrightColor = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'COPYRIGHT COLOR',
							'labelWidth'=>150,
							'value'=>"<input   id='copyrightColor' name='copyrightColor' value='$copyrightColor' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveCopyrightColor()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$headerColor, 'err'=>$err, 'content'=>$content);
	}

	function editWarnaBackground(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'CONTENT BACKGROUND COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='background_content'"));
		$warnaBackground = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'CONTENT BACKGROUND COLOR',
							'labelWidth'=>200,
							'value'=>"<input   id='warnaBackground' name='warnaBackground' value='$warnaBackground' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveWarnaBackground()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$headerColor, 'err'=>$err, 'content'=>$content);
	}

	function editMenuBarColor(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'MENU BAR COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='menu_bar_color'"));
		$menuColor = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'MENU COLOR',
							'labelWidth'=>100,
							'value'=>"<input   id='menuColor' name='menuColor' value='$menuColor' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveMenuBarColor()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$menuColor, 'err'=>$err, 'content'=>$content);
	}

	function editColorTextMenubar(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'COLOR TEXT MENU BAR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='font_color_menubar'"));
		$colorTextMenubar = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'COLOR TEXT MENU BAR',
							'labelWidth'=>150,
							'value'=>"<input   id='colorTextMenubar' name='colorTextMenubar' value='$colorTextMenubar' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveColorTextMenubar()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$menuColor, 'err'=>$err, 'content'=>$content);
	}

	function editColorBorder(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'WARNA GARIS BAWAH';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='color_border_menubar'"));
		$colorBorder = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'WARNA GARIS BAWAH',
							'labelWidth'=>150,
							'value'=>"<input   id='colorBorder' name='colorBorder' value='$colorBorder' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveColorBorder()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$menuColor, 'err'=>$err, 'content'=>$content);
	}

	function editFooterColor(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'FOOTER COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='footer_color'"));
		$footerColor = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER COLOR',
							'labelWidth'=>100,
							'value'=>"<input   id='footerColor' name='footerColor' value='$footerColor' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveFooterColor()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$menuColor, 'err'=>$err, 'content'=>$content);
	}

	function editFooterColorHover(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'FOOTER COLOR';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='footerColorHover'"));
		$footerColorHover = $get['option_value'];
		  $this->form_fields = array(
			'title' => array(
							'label'=>'FOOTER COLOR',
							'labelWidth'=>100,
							'value'=>"<input   id='footerColorHover' name='footerColorHover' value='$footerColorHover' style='width:250px;'>
							",
						),
			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveFooterColorHover()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$menuColor, 'err'=>$err, 'content'=>$content);
	}

	function editSiteUrl(){
	 global $SensusTmp ,$Main;
	 global $Main;
	 global $HTTP_COOKIE_VARS;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'SITE URL';

	 	$get = mysql_fetch_array(mysql_query("select * from $this->TblName where option_name='site_url'"));
		$siteUrl = $get['option_value'];
		  $this->form_fields = array(



			'title' => array(
							'label'=>'SITE URL',
							'labelWidth'=>80,
							'value'=>"<input type='text' id='siteUrl' name='siteUrl' value='$siteUrl' style='width:300px;'>
							",
						),





			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveSiteUrl()' title='Simpan' >"."&nbsp&nbsp".
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
	 $Koloms[] = array('align="center"',$status);


	 return $Koloms;
	}


	function genDaftarOpsi(){
	 global $Ref, $Main;
	 $getSiteTitle = mysql_fetch_array(mysql_query("select * from general_setting where option_name='site_title'"));
	 $getSiteUrl = mysql_fetch_array(mysql_query("select * from general_setting where option_name='site_url'"));
	 $getHeaderTitle = mysql_fetch_array(mysql_query("select * from general_setting where option_name='header_title'"));
	 $getHeightHeader = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'header_height' "));
	 $getHeaderFontSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'header_font_size' "));
	 $getHeaderLogo = mysql_fetch_array(mysql_query("select * from general_setting where option_name='header_logo'"));
	 $getHeaderImage = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'header_image' "));
	 $getFooterImage = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'footer_image' "));
	 $getHeaderColor = mysql_fetch_array(mysql_query("select * from general_setting where option_name='header_color'"));
	 $getMenuBarVisible = mysql_fetch_array(mysql_query("select * from general_setting where option_name='show_menu_bar'"));
	 $getMenuBarColor = mysql_fetch_array(mysql_query("select * from general_setting where option_name='menu_bar_color'"));
	 $getCopyRightText = mysql_fetch_array(mysql_query("select * from general_setting where option_name='copyright_title'"));
	 $getFooterFontSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'footer_font_size' "));
	 $getNavFontSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'navFontSize' "));
	 $getCopyRightColor = mysql_fetch_array(mysql_query("select * from general_setting where option_name='copyright_color'"));
	 $getCopyRightVisible = mysql_fetch_array(mysql_query("select * from general_setting where option_name='copyright_visible'"));
	 $getFooterText = mysql_fetch_array(mysql_query("select * from general_setting where option_name='footer_text'"));
	 $getFooterColor = mysql_fetch_array(mysql_query("select * from general_setting where option_name='footer_color'"));
	 $getFooterColorHover = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'footerColorHover' "));
	 $getFooterVisible = mysql_fetch_array(mysql_query("select * from general_setting where option_name='footer_visible'"));
	 $getFontStyle = mysql_fetch_array(mysql_query("select * from general_setting where option_name='font_style'"));
	 $getHeaderTextColor = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'header_text_color' "));
	 $getDateVisible = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'date_visible' "));
	 $getHeightLogo = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'height_logo' "));
	 $getWidthLogo = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'width_logo' "));
	 $getFontMenubar = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'font_menu_bar' "));
	 $getColorTextMenubar = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'font_color_menubar' "));
	 $getColorBorder = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'color_border_menubar' "));
	 $getHeightMenubar = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'height_menubar' "));
	 $getMenubarFontSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'menubar_font_size' "));
	 $getDropdownFontSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'dropdown_font_size' "));
	 $getWarnaBackground = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'background_content' "));
	 $getColorHoverMenubar = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'color_hover_menubar' "));
	 $getHoverMenubar = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'hoverMenubar' "));
	 $getDropDownBackGroundColor = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'dropdown_background_color' "));
	 $getSiteImage = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'site_image' "));
	 $getContentImage = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'content_image' "));
	 $getContentBackGroundActive = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'content_background_active' "));
	 $getContentJenisFont = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'content_font_style' "));
	 $getFontSizeShortcut = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'fontSizeShortcut' "));
	 $getShortcutFontColor = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'shortcutFontColor' "));
	 $getShortcutFontType = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'shortcutFontType' "));

	 $getShortcutContentFontSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'shortcutContentFontSize' "));
	 $getShortcutContentFontColor = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'shortcutContentFontColor' "));
	 $getShortcutContentFontColorHover = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'shortcutContentFontColorHover' "));
	 $getShortcutContentFontType = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'shortcutContentFontType' "));

	 $getTableBackgroundColor = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'tableBackgroundColor' "));
	 $getTableBorderColor = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'tableBorderColor' "));
	 $getTableBorderSize = mysql_fetch_array(mysql_query("SELECT * from general_setting where option_name = 'tableBorderSize' "));

		$TampilOpt = "
				<link rel='stylesheet' type='text/css' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  			<script type='text/javascript' src='https://code.jquery.com/jquery-3.2.1.js'></script>
  			<script type='text/javascript' src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
  			<style>
  				a{
  					color: red;
  				}
  			</style>
  			
  			<table style='width:100%;' class='table table-hover'>
  				<h2 style='text-align:left;'>Site</h2>
  				<tr>
					<td width='20%'>
						<strong>SITE TITLE</strong>
					</td>
					<td width='80%'>
						".$getSiteTitle['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editSiteTitle() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>SITE URL</strong>
					</td>
					<td width='80%'>
						".$getSiteUrl['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editSiteUrl() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>



				<tr>
					<td width='20%'>
						<strong>SITE IMAGE</strong>
					</td>
					<td width='80%'>
						".$getSiteImage['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editSiteImage() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>
  			</table>

  			<table style='width:100%;' class='table table-hover'>
  				<h2 style='text-align:left;'>Header</h2>

  				<tr>
					<td width='20%'>
						<strong>NAMA TITLE</strong>
					</td>
					<td width='80%'>
						".$getHeaderTitle['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editHeaderTitle() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>HEIGHT HEADER</strong>
					</td>
					<td width='80%'>
						".$getHeightHeader['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editHeightHeader() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>HEADER FONT SIZE</strong>
					</td>
					<td width='80%'>
						".$getHeaderFontSize['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editHeaderFontSize() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>HEIGHT LOGO</strong>
					</td>
					<td width='80%'>
						".$getHeightLogo['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editHeightLogo() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>WIDTH LOGO</strong>
					</td>
					<td width='80%'>
						".$getWidthLogo['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editWidthLogo() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>HEADER LOGO</strong>
					</td>
					<td width='80%'>
						".$getHeaderLogo['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editHeaderLogo() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>JENIS HURUF</strong>
					</td>
					<td width='80%'>
						".$getFontStyle['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editFontStyle() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>BACKGROUND COLOR</strong>
					</td>
					<td width='80%'>
						".$getHeaderColor['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editHeaderColor() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>BACKGROUND IMAGE</strong>
					</td>
					<td width='80%'>
						".$getHeaderImage['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editHeaderImage() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>WARNA TULISAN</strong>
					</td>
					<td width='80%'>
						".$getHeaderTextColor['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editHeaderTextColor() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>



					<tr>
					<td width='20%'>
						<strong>DATE VISIBLE</strong>
					</td>
					<td width='80%'>
						".$getDateVisible['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editDateVisible() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>
  			</table>

  			<table style='width:100%;' class='table table-hover'>
  				<h2 style='text-align:left;'>Menu Bar</h2>

  				<tr>
					<td width='20%'>
						<strong>HEIGHT MENU BAR</strong>
					</td>
					<td width='80%'>
						".$getHeightMenubar['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editHeightMenubar() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>MENU BAR FONT SIZE</strong>
					</td>
					<td width='80%'>
						".$getMenubarFontSize['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editMenubarFontSize() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

  				<tr>
					<td width='20%'>
						<strong>MENU BAR VISIBLE</strong>
					</td>
					<td width='80%'>
						".$getMenuBarVisible['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editMenuBarVisible() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>MENU BAR BACKGROUND COLOR</strong>
					</td>
					<td width='80%'>
						".$getMenuBarColor['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editMenuBarColor() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>WARNA TUlISAN</strong>
					</td>
					<td width='80%'>
						".$getColorTextMenubar['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editColorTextMenubar() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>WARNA GARIS BAWAH</strong>
					</td>
					<td width='80%'>
						".$getColorBorder['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editColorBorder() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>JENIS HURUF MENU BAR</strong>
					</td>
					<td width='80%'>
						".$getFontMenubar['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editFontMenubar() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>DROP DOWN BACKGROUND COLOR</strong>
					</td>
					<td width='80%'>
						".$getDropDownBackGroundColor['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editDropDownBackGroundColor() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>COLOR FONT HOVER MENU BAR</strong>
					</td>
					<td width='80%'>
						".$getColorHoverMenubar['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editColorHoverMenubar() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>COLOR HOVER MENU BAR</strong>
					</td>
					<td width='80%'>
						".$getHoverMenubar['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editHoverMenubar() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr>
					<td width='20%'>
						<strong>DROPDOWN FONT SIZE</strong>
					</td>
					<td width='80%'>
						".$getDropdownFontSize['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editDropdownFontSize() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

  			</table>

  			<table style='width:100%;' class='table table-hover'>
  				<h2 style='float:left'>Content</h2>

  				<tr>
					<td width='20%'>
						<strong>WARNA BACKGROUND</strong>
					</td>
					<td width='80%'>
						".$getWarnaBackground['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editWarnaBackground() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

  				<tr hidden='hidden'>
					<td width='20%'>
						<strong>JENIS FONT</strong>
					</td>
					<td width='80%'>
						".$getContentJenisFont['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editContentJenisFont() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr hidden='hidden'>
					<td width='20%'>
						<strong>BACKGROUND IMAGE</strong>
					</td>
					<td width='80%'>
						".$getContentImage['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editContentImage() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

					<tr hidden='hidden'>
					<td width='20%'>
						<strong>BACKGROUND ACTIVE</strong>
					</td>
					<td width='80%'>
						".$getContentBackGroundActive['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editContentBackGroundActive() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>
  			</table>

				<table style='width:100%;' class='table table-hover'>
				<h2 style='float:left;'>Footer</h2>

				<tr>
					<td width='20%'>
						<strong>COPYRIGHT TEXT</strong>
					</td>
					<td width='80%'>
						".$getCopyRightText['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editCopyRightText() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>COPYRIGHT FONT SIZE</strong>
					</td>
					<td width='80%'>
						".$getFooterFontSize['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editFooterFontSize() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>FOOTER FONT SIZE</strong>
					</td>
					<td width='80%'>
						".$getNavFontSize['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editNavFontSize() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>FOOTER IMAGE</strong>
					</td>
					<td width='80%'>
						".$getFooterImage['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editFooterImage() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>COPYRIGHT COLOR</strong>
					</td>
					<td width='80%'>
						".$getCopyRightColor['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editCopyRightColor() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>COPYRIGHT VISIBLE</strong>
					</td>
					<td width='80%'>
						".$getCopyRightVisible['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editCopyRightVisible() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>FOOTER TEXT</strong>
					</td>
					<td width='80%'>
						".$getFooterText['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editFooterText() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>FOOTER COLOR</strong>
					</td>
					<td width='80%'>
						".$getFooterColor['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editFooterColor() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>FOOTER COLOR HOVER</strong>
					</td>
					<td width='80%'>
						".$getFooterColorHover['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editFooterColorHover() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>FOOTER VISIBLE</strong>
					</td>
					<td width='80%'>
						".$getFooterVisible['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editFooterVisible() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>
			</table>

			<table style='width:100%;' class='table table-hover'>
				<h2 style='float:left;'>TITLE SHORTCUT</h2>

				<tr>
					<td width='20%'>
						<strong>SHORTCUT FONT SIZE</strong>
					</td>
					<td width='80%'>
						".$getFontSizeShortcut['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editFontSizeShortcut() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>SHORTCUT FONT COLOR</strong>
					</td>
					<td width='80%'>
						".$getShortcutFontColor['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editShortcutFontColor() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>SHORTCUT FONT TYPE</strong>
					</td>
					<td width='80%'>
						".$getShortcutFontType['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editShortcutFontType() style='cursor:pointer;' >Sunting</a>
					</td>
					</tr>

			</table>

			<table style='width:100%;' class='table table-hover'>
				<h2 style='float:left;'>CONTENT SHORTCUT</h2>

				<tr>
					<td width='20%'>
						<strong>CONTENT FONT SIZE</strong>
					</td>
					<td width='80%'>
						".$getShortcutContentFontSize['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editShortcutContentFontSize() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>CONTENT FONT COLOR</strong>
					</td>
					<td width='80%'>
						".$getShortcutContentFontColor['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editShortcutContentFontColor() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>CONTENT FONT COLOR HOVER</strong>
					</td>
					<td width='80%'>
						".$getShortcutContentFontColorHover['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editShortcutContentFontColorHover() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>CONTENT FONT TYPE</strong>
					</td>
					<td width='80%'>
						".$getShortcutContentFontType['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editShortcutContentFontType() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>TABLE BACKGROUND COLOR</strong>
					</td>
					<td width='80%'>
						".$getTableBackgroundColor['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editTableBackgroundColor() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>TABLE BORDER COLOR</strong>
					</td>
					<td width='80%'>
						".$getTableBorderColor['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editTableBorderColor() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

				<tr>
					<td width='20%'>
						<strong>TABLE BORDER SIZE</strong>
					</td>
					<td width='80%'>
						".$getTableBorderSize['option_value']."
					</td>
					<td  style='float:right;'>
						<a onclick=$this->Prefix.editTableBorderSize() style='cursor:pointer;' >Sunting</a>
					</td>
				</tr>

			</table>
				";

			;
		return array('TampilOpt'=>$TampilOpt);
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
$generalSetting = new generalSettingObj();
$generalSetting->username =$_COOKIE['coID'];
?>