<?php
class menuBarObj  extends DaftarObj2{
	var $Prefix = 'menuBar';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'menu_bar'; //daftar
	var $TblName_Hapus = 'menu_bar';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Menu Bar';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'Menu Bar';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'menuBarForm';
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
		return 'Menu Bar';
	}
	function setPage_HeaderOther(){

		return
		"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
		<tr>
		<td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		<A href=\"pages.php?Pg=generalSetting\"   > SETTING </a> |
		<A href=\"pages.php?Pg=onepage\"   > SYSTEM </a> |
		<A href=\"pages.php?Pg=menuBar\"  style='color : blue;' > MENU BAR </a> |
		<A href=\"pages.php?Pg=shortcut\"   > SHORTCUT </a> |
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
		"<td>".genPanelIcon("javascript:".$this->Prefix.".formURL()","sections.png","URL", 'URL')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Urut()","sections.png","Urut", 'Urut')."</td>".
		// "<td>".genPanelIcon("javascript:".$this->Prefix.".formStatus()","sections.png","Status", 'Status')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".selectEdit()","edit_f2.png","Edit", 'Edit')."</td>".
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
	if(empty($cmbMenuBar)){
		$err = "Pilih Menu Bar";
	}elseif(empty($cmbMenu)){
		$err = "Pilih Menu";
	}elseif(empty($cmbSubMenu)){
		$err = "Pilih Sub Menu";
	}elseif(empty($cmbSubSubMenu)){
		$err = "Pilih Sub Sub Menu";
	}elseif(empty($cmbLevel5)){
		$err = "Pilih Level 5";
	}elseif(empty($title)){
		$err = "Isi Title";
	}

		if($fmST == 0){
			if($err==''){
					$getKode = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$cmbLevel5'"));
					$kodeMenuBar = $getKode['menu_bar'];
					$kodeMenu = $getKode['menu'];
					$kodeSubMenu = $getKode['sub_menu'];
					$kodeSubSubMenu = $getKode['sub_sub_menu'];
					$kodeLevel5 = $getKode['level_5'];
					$getMaxLevel6 = mysql_fetch_array(mysql_query("select max(level_6), max(nomor_urut) from $this->TblName where upline ='$cmbLevel5'"));
					$maxLevel6 = $getMaxLevel6['max(level_6)'] + 1;
					$maxNomorUrut = $getMaxLevel6['max(nomor_urut)'] + 1;
					$data = array(
									"menu_bar" => $kodeMenuBar,
									'menu' => $kodeMenu,
									'sub_menu' => $kodeSubMenu,
									'sub_sub_menu' => $kodeSubSubMenu,
									'level_5' => $kodeLevel5,
									'level_6' => $maxLevel6,
									"level" => '6',
									'upline' => $cmbLevel5,
									'nomor_urut' => $maxNomorUrut,
									'title' => $title,
									'status' => '1'
								 );
					$query = VulnWalkerInsert($this->TblName,$data);
					mysql_query($query);
				}
			}else{
				if($err==''){
					$data = array(
									"menu_bar" => $cmbMenuBar,
									'menu' => $cmbMenu,
									'sub_menu' => $cmbSubMenu,
									'sub_sub_menu' => $maxSubMenu,
									'title' => $title,
								 );
					$query = VulnWalkerUpdate($this->TblName,$data,"id='$idEdit'");
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

		case 'formBaru':{
			$fm = $this->setFormBaru();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}
		case 'Hapus':{
			$fm = $this->Hapus_data();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'deleteDownline':{
				foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}
				$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$menuBar_cb[0]'"));
				foreach ($getData as $key => $value) {
				  $$key = $value;
				}


				if($level == '1'){
					mysql_query("delete from $this->TblName where  menu_bar ='$menu_bar'");

				}elseif($level == '2'){
					mysql_query("delete from $this->TblName where  menu_bar ='$menu_bar' and menu ='$menu'");
				}elseif($level == '3'){
					mysql_query("delete from $this->TblName where  menu_bar ='$menu_bar' and menu ='$menu' and sub_menu ='$sub_menu'");

				}elseif($level == '4'){
					mysql_query("delete from $this->TblName where  menu_bar ='$menu_bar' and menu ='$menu' and sub_menu ='$sub_menu' and sub_sub_menu ='$sub_sub_menu'");
				}elseif($level == '5'){
					mysql_query("delete from $this->TblName where  menu_bar ='$menu_bar' and menu ='$menu' and sub_menu ='$sub_menu' and sub_sub_menu ='$sub_sub_menu' and level_5 ='$level_5'");
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

		case 'formURL':{
			$fm = $this->formURL();
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];
		break;
		}

		case 'Urut':{
			foreach ($_REQUEST as $key => $value) {
				$$key = $value;
			}
			if(!empty($filterLevel6)){
					$err  = "Pilih upline untuk mengurutkan";
			}elseif(!empty($filterLevel5)){
					$upline = $filterLevel5;
			}elseif(!empty($filterSubSubMenu)){
					$upline = $filterSubSubMenu;
			}elseif(!empty($filterSubMenu)){
					$upline = $filterSubMenu;
			}elseif(!empty($filterMenu)){
					$upline = $filterMenu;
			}elseif(!empty($filterMenuBar)){
					$upline = $filterMenuBar;
			}else{
					$upline = 0;
			}
			mysql_query("delete from temp_urutan where username  = '$this->username'");
			$nomorUrut = 1;
			$getAllDownline = mysql_query("select * from menu_bar where upline = '$upline' order by nomor_urut");
			while ($dataDownline = mysql_fetch_array($getAllDownline)) {
					$dataTemp = array(
									'upline' => $upline,
									'username' => $this->username,
									'no_urut' => $nomorUrut,
									'id_menu' => $dataDownline['id'],
					);
					mysql_query(VulnWalkerInsert("temp_urutan",$dataTemp));
					$nomorUrut+=1;
			}
			$content = array('upline' => $upline);
		break;
		}
    // 
		// case 'saveNomorUrut':{
		// 		foreach ($_REQUEST as $key => $value) {
		// 		  $$key = $value;
		// 		}
		// 		$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
		// 		foreach ($getData as $key => $value) {
		// 		  $$key = $value;
		// 		}
		// 		if(mysql_num_rows(mysql_query("select * from $this->TblName where upline='$upline' and nomor_urut = '$nomorUrut' and id!='$id'")) != 0){
		// 			$err = "Nomor Urut Sudah Ada";
		// 		}elseif(empty($nomorUrut)){
		// 			$err = "Isis nomor urut";
		// 		}else{
    //
		// 			$getKode = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
    //
		// 			if($getKode['level_6'] !='0'){
		// 				$dataLevel6 = array('level_6' => $nomorUrut);
		// 				mysql_query(VulnWalkerUpdate($this->TblName,$dataLevel6," menu_bar = '".$getKode['menu_bar']."' and menu = '".$getKode['menu']."' and sub_menu = '".$getKode['sub_menu']."' and sub_sub_menu = '".$getKode['sub_sub_menu']."' and  level_5 = '".$getKode['level_5']."' and level_6 = '".$getKode['level_6']."'"));
		// 			}elseif($getKode['level_5'] !='0'){
		// 				$dataLevel5 = array('level_5' => $nomorUrut);
		// 				mysql_query(VulnWalkerUpdate($this->TblName,$dataLevel5," menu_bar = '".$getKode['menu_bar']."' and menu = '".$getKode['menu']."' and sub_menu = '".$getKode['sub_menu']."' and sub_sub_menu = '".$getKode['sub_sub_menu']."' and  level_5 = '".$getKode['level_5']."' "));
		// 			}elseif($getKode['sub_sub_menu'] !='0'){
		// 				$dataSubSubMenu = array('sub_sub_menu' => $nomorUrut);
		// 				mysql_query(VulnWalkerUpdate($this->TblName,$dataSubSubMenu,"menu_bar = '".$getKode['menu_bar']."' and menu = '".$getKode['menu']."' and sub_menu = '".$getKode['sub_menu']."' and sub_sub_menu = '".$getKode['sub_sub_menu']."' "));
		// 			}elseif($getKode['sub_menu'] !='0'){
		// 				$dataSubMenu = array('sub_menu' => $nomorUrut);
		// 				mysql_query(VulnWalkerUpdate($this->TblName,$dataSubMenu,"menu_bar = '".$getKode['menu_bar']."' and menu = '".$getKode['menu']."' and sub_menu = '".$getKode['sub_menu']."' "));
		// 			}elseif($getKode['menu'] !='0'){
		// 				$dataMenu = array('menu' => $nomorUrut);
		// 				mysql_query(VulnWalkerUpdate($this->TblName,$dataMenu,"menu_bar = '".$getKode['menu_bar']."' and menu = '".$getKode['menu']."'  "));
		// 			}elseif($getKode['menu_bar'] !='0'){
		// 				// $dataMenuBar = array('menu_bar' => $nomorUrut);
		// 				// mysql_query(VulnWalkerUpdate($this->TblName,$dataMenuBar,"menu_bar = '".$getKode['menu_bar']."'"));
		// 				$this->menuBarUrutan($id,$nomorUrut);
		// 			}
    //
		// 			$data = array("nomor_urut" => $nomorUrut);
		// 			$query = VulnWalkerUpdate($this->TblName,$data,"id ='$id'");
		// 			mysql_query($query);
		// 		}
    //
		// break;
		// }

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
				if($level == '1'){
					$dataDownline = array("status" => $_REQUEST['status']);
					$queryDownline = VulnWalkerUpdate($this->TblName,$dataDownline,"menu_bar ='$menu_bar'");

				}elseif($level == '2'){
					$dataDownline = array("status" => $_REQUEST['status']);
					$queryDownline = VulnWalkerUpdate($this->TblName,$dataDownline,"menu_bar ='$menu_bar' and menu ='$menu'");

				}elseif($level == '3'){
					$dataDownline = array("status" => $_REQUEST['status']);
					$queryDownline = VulnWalkerUpdate($this->TblName,$dataDownline,"menu_bar ='$menu_bar' and menu ='$menu' and sub_menu ='$sub_menu'");

				}elseif($level == '4'){
					$dataDownline = array("status" => $_REQUEST['status']);
					$queryDownline = VulnWalkerUpdate($this->TblName,$dataDownline,"menu_bar ='$menu_bar' and menu ='$menu' and sub_menu ='$sub_menu' and sub_sub_menu ='$sub_sub_menu'");

				}elseif($level == '5'){
					$dataDownline = array("status" => $_REQUEST['status']);
					$queryDownline = VulnWalkerUpdate($this->TblName,$dataDownline,"menu_bar ='$menu_bar' and menu ='$menu' and sub_menu ='$sub_menu' and sub_sub_menu ='$sub_sub_menu' and level_5 ='$level_5'");
				}
				mysql_query($queryDownline);


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

		case 'checkEdit':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			$idEdit = $menuBar_cb[0];
			$getKategori = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$idEdit'"));
			if($getKategori['level'] =='6'){
				$kategori = "6";
			}elseif($getKategori['level'] =='5'){
				$kategori = "5";
			}elseif($getKategori['level'] =='4'){
				$kategori = "4";
			}elseif($getKategori['level'] =='3'){
				$kategori = "3";
			}elseif($getKategori['level'] =='2'){
				$kategori = "2";
			}elseif($getKategori['level'] =='1'){
				$kategori = "1";
			}

			$content = array("kategori" => $kategori, 'id' => $idEdit);


		break;
		}
		case 'newMenuBar':{
				$fm = $this->newMenuBar();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}
		case 'newMenu':{
				$fm = $this->newMenu();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'newSubMenu':{
				$fm = $this->newSubMenu();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'newSubSubMenu':{
				$fm = $this->newSubSubMenu();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'newLevel5':{
				$fm = $this->newLevel5();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'editMenuBar':{
				$fm = $this->editMenuBar();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'editMenu':{
				$fm = $this->editMenu();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'editSubMenu':{
				$fm = $this->editSubMenu();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'editSubSubMenu':{
				$fm = $this->editSubSubMenu();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'editLevel5':{
				$fm = $this->editLevel5();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'formEditSubMenu':{
				$fm = $this->formEditSubMenu();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'formEditSubSubMenu':{
				$fm = $this->formEditSubSubMenu();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'formEditLevel5':{
				$fm = $this->formEditLevel5();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}


		case 'formEditLevel6':{
				$fm = $this->formEditLevel6();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'formEditMenu':{
				$fm = $this->formEditMenu();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'formEditMenuBar':{
				$fm = $this->formEditMenuBar();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			break;
		}

		case 'saveNewMenuBar':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}
			$getMaxKodeMenuBar = mysql_fetch_array(mysql_query("select max(menu_bar) from $this->TblName where level = '1' "));
			$getMaxUrut = mysql_fetch_array(mysql_query("select max(nomor_urut) as maxURUT from $this->TblName where level = '1' "));
			$maxNomorUrut = $getMaxUrut['maxURUT'] + 1;
			$maxMenuBarKode =$getMaxKodeMenuBar['max(menu_bar)'] ;


			$myKodeMenuBar = $maxMenuBarKode['max(menu_bar)'] + 1;

			$data = array(
							'level' => '1',
							'status' => '1',
							'upline' => '0',
							'nomor_urut' => $maxNomorUrut,
							'title' => $titleMenuBar,
							'menu_bar' => $myKodeMenuBar,
							'menu' => '0',
							'sub_menu' => '0',
							'sub_sub_menu' => '0',
							'level_5' => '0',
							'level_6' => '0',
									);
			$query = VulnWalkerInsert($this->TblName,$data);
			mysql_query($query);

			$getMaxKodeMenuBar = mysql_fetch_array(mysql_query("select max(id) from $this->TblName where level='1'"));
			$queryCmbMenuBar = "select id, title from $this->TblName where level ='1'";
			$comboMenuBar = cmbQuery('cmbMenuBar',$getMaxKodeMenuBar['max(id)'],$queryCmbMenuBar," onchange =$this->Prefix.menuBarChanged(); style='width:400px;'",'-- Pilih Menu Bar --');


			$queryCmbMenu = "select id, title from $this->TblName where level ='2' and upline='$menuBar'";
			$comboMenu = cmbQuery('cmbMenu',$menu,$queryCmbMenu," onchange =$this->Prefix.menuChanged(); style='width:400px;'",'-- Pilih Menu --');


			$queryCmbSubMenu = "select id, title from $this->TblName where level ='3' and upline='$menu'";
			$comboSubMenu = cmbQuery('cmbSubMenu',$sub_menu,$queryCmbSubMenu," onchange =$this->Prefix.subMenuChanged(); style='width:400px;'",'-- Pilih Sub Menu --');

			$queryCmbSubSubMenu = "select id, title from $this->TblName where level ='4' and upline='$sub_menu'";
			$comboSubSubMenu = cmbQuery('cmbSubSubMenu',$sub_sub_menu,$queryCmbSubSubMenu," onchange =$this->Prefix.subSubMenuChanged(); style='width:400px;'",'-- Pilih Sub Sub Menu --');

			$content = array('cmbMenuBar' => $comboMenuBar,'cmbMenu' => $comboMenu, 'cmbSubMenu' => $comboSubMenu, 'cmbSubSubMenu' => $comboSubSubMenu );

			break;
		}

		case 'saveNewMenu':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

			$getKodeMenuBar = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$menuBar' "));
			$kodeMenuBar = $getKodeMenuBar['menu_bar'];


			$getMaxKodeMenu = mysql_fetch_array(mysql_query("select max(menu),max(nomor_urut) from $this->TblName where upline='$menuBar' and menu_bar ='$kodeMenuBar' and menu !='0' and sub_menu ='0' "));
			$maxMenuKode =$getMaxKodeMenu['max(menu)'] ;
			$myKodeMenu = $maxMenuKode['max(menu)'] + 1;
			$maxNomorUrut = $maxMenuKode['max(nomor_urut)'] + 1;

			$data = array(
							'level' => '2',
							'status' => '1',
							'nomor_urut' => $maxNomorUrut,
							'upline' => $menuBar,
							'title' => $titleMenu,
							'menu_bar' => $kodeMenuBar,
							'menu' => $myKodeMenu,
							'sub_menu' => '0',
							'sub_sub_menu' => '0',
							'level_5' => '0',
							'level_6' => '0',
									);
			$query = VulnWalkerInsert($this->TblName,$data);
			mysql_query($query);
			$getMaxKodeMenu = mysql_fetch_array(mysql_query("select max(id) from $this->TblName where level='2' and upline='$menuBar'"));


			$queryCmbMenu = "select id, title from $this->TblName where level ='2' and upline='$menuBar'";
			$comboMenu = cmbQuery('cmbMenu',$getMaxKodeMenu['max(id)'],$queryCmbMenu," onchange =$this->Prefix.menuChanged(); style='width:400px;'",'-- Pilih Menu --');


			$queryCmbSubMenu = "select id, title from $this->TblName where level ='3' and upline='".$getMaxKodeMenu['max(id)']."'";
			$comboSubMenu = cmbQuery('cmbSubMenu',$sub_menu,$queryCmbSubMenu," onchange =$this->Prefix.subMenuChanged(); style='width:400px;'",'-- Pilih Sub Menu --');

			$queryCmbSubSubMenu = "select id, title from $this->TblName where level ='4' and upline='$sub_menu'";
			$comboSubSubMenu = cmbQuery('cmbSubSubMenu',$sub_sub_menu,$queryCmbSubSubMenu," onchange =$this->Prefix.subSubMenuChanged(); style='width:400px;'",'-- Pilih Sub Sub Menu --');

			$content = array('cmbMenuBar' => $comboMenuBar,'cmbMenu' => $comboMenu, 'cmbSubMenu' => $comboSubMenu, 'cmbSubSubMenu' => $comboSubSubMenu );

			break;
		}

		case 'saveNewSubMenu':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}



			$getKodeMenu = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$menu'"));
			$kodeMenuBar = $getKodeMenu['menu_bar'];
			$kodeMenu = $getKodeMenu['menu'];


			$getMaxKodeSubMenu = mysql_fetch_array(mysql_query("select max(sub_menu),max(nomor_urut) from $this->TblName where upline='$menu' and menu_bar ='$kodeMenuBar' and menu ='$kodeMenu' and sub_menu != '0' and sub_sub_menu ='0' "));
			$maxMenuSubKode = $getMaxKodeSubMenu['max(sub_menu)'] ;
			$myKodeSubMenu = $maxMenuSubKode['max(sub_menu)'] + 1;
			$maxNomorUrut = $maxMenuSubKode['max(nomor_urut)'] + 1;

			$data = array(
							'level' => '3',
							'status' => '1',
							'nomor_urut' => $maxNomorUrut,
							'upline' => $menu,
							'title' => $titleSubMenu,
							'menu_bar' => $kodeMenuBar,
							'menu' => $kodeMenu,
							'sub_menu' => $myKodeSubMenu,
							'sub_sub_menu' => '0',
							'level_5' => '0',
							'level_6' => '0',
									);
			$query = VulnWalkerInsert($this->TblName,$data);
			mysql_query($query);
			$getMaxKodeSubMenu = mysql_fetch_array(mysql_query("select max(id) from $this->TblName where level='3' and upline='$menu'"));



			$queryCmbSubMenu = "select id, title from $this->TblName where level ='3' and upline='".$menu."'";
			$comboSubMenu = cmbQuery('cmbSubMenu',$getMaxKodeSubMenu['max(id)'],$queryCmbSubMenu," onchange =$this->Prefix.subMenuChanged(); style='width:400px;'",'-- Pilih Sub Menu --');

			$queryCmbSubSubMenu = "select id, title from $this->TblName where level ='4' and upline='$sub_menu'";
			$comboSubSubMenu = cmbQuery('cmbSubSubMenu',$sub_sub_menu,$queryCmbSubSubMenu," onchange =$this->Prefix.subSubMenuChanged(); style='width:400px;'",'-- Pilih Sub Sub Menu --');

			$content = array('cmbSubMenu' => $comboSubMenu, 'cmbSubSubMenu' => $comboSubSubMenu );

			break;
		}


		case 'saveNewSubSubMenu':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}



			$getKodeMenu = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$subMenu'"));
			$kodeMenuBar = $getKodeMenu['menu_bar'];
			$kodeMenu = $getKodeMenu['menu'];
			$kodeSubMenu = $getKodeMenu['sub_menu'];


			$getMaxKodeSubSubMenu = mysql_fetch_array(mysql_query("select max(sub_sub_menu),max(nomor_urut) from $this->TblName where upline='$subMenu' and level='4'  "));
			$maxMenuSubSubKode = $getMaxKodeSubSubMenu['max(sub_sub_menu)'] ;
			$myKodeSubSubMenu = $maxMenuSubSubKode['max(sub_sub_menu)'] + 1;
			$maxNomorUrut = $maxMenuSubSubKode['max(nomor_urut)'] + 1;

			$data = array(
							'level' => '4',
							'status' => '1',
							'nomor_urut' => $maxNomorUrut,
							'upline' => $subMenu,
							'title' => $titleSubSubMenu,
							'menu_bar' => $kodeMenuBar,
							'menu' => $kodeMenu,
							'sub_menu' => $kodeSubMenu,
							'sub_sub_menu' => $myKodeSubSubMenu,
							'level_5' => '0',
							'level_6' => '0',
									);
			$query = VulnWalkerInsert($this->TblName,$data);
			mysql_query($query);
			$getMaxKodeSubMenu = mysql_fetch_array(mysql_query("select max(id) from $this->TblName where level='4' and upline='$subMenu'"));




			$queryCmbSubSubMenu = "select id, title from $this->TblName where level ='4' and upline='$subMenu'";
			$comboSubSubMenu = cmbQuery('cmbSubSubMenu',$getMaxKodeSubMenu['max(id)'],$queryCmbSubSubMenu," onchange =$this->Prefix.subSubMenuChanged(); style='width:400px;'",'-- Pilih Sub Sub Menu --');

			$content = array( 'cmbSubSubMenu' => $comboSubSubMenu );

			break;
		}


		case 'saveNewLevel5':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}



			$getKodeMenu = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$subSubMenu'"));
			$kodeMenuBar = $getKodeMenu['menu_bar'];
			$kodeMenu = $getKodeMenu['menu'];
			$kodeSubMenu = $getKodeMenu['sub_menu'];
			$kodeSubSubMenu = $getKodeMenu['sub_sub_menu'];


			$getMaxKodeLevel5 = mysql_fetch_array(mysql_query("select max(level_5),max(nomor_urut) from $this->TblName where upline='$subSubMenu' and level='5' "));
			$maxMenuLevel5 = $getMaxKodeLevel5['max(level_5)'] ;
			$myKodeLevel5 = $maxMenuLevel5['max(level_5)'] + 1;
			$maxNomorUrut = $maxMenuLevel5['max(nomor_urut)'] + 1;

			$data = array(
							'level' => '5',
							'status' => '1',
							'nomor_urut' => $maxNomorUrut,
							'upline' => $subSubMenu,
							'title' => $titleLevel5,
							'menu_bar' => $kodeMenuBar,
							'menu' => $kodeMenu,
							'sub_menu' => $kodeSubMenu,
							'sub_sub_menu' => $kodeSubSubMenu,
							'level_5' => $myKodeLevel5,
							'level_6' => '0',
									);
			$query = VulnWalkerInsert($this->TblName,$data);
			mysql_query($query);
			$getMaxKodeSubMenu = mysql_fetch_array(mysql_query("select max(id) from $this->TblName where level='5' and upline='$subSubMenu'"));




			$queryCmbSubSubMenu = "select id, title from $this->TblName where level ='5' and upline='$subSubMenu'";
			$comboSubSubMenu = cmbQuery('cmbLevel5',$getMaxKodeSubMenu['max(id)'],$queryCmbSubSubMenu," onchange =$this->Prefix.level5Changed(); style='width:400px;'",'-- Pilih Level 5 --');

			$content = array( 'cmbLevel5' => $comboSubSubMenu );

			break;
		}

		case 'saveEditSubMenu':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}



			$getKodeMenu = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$menu'"));
			$kodeMenuBar = $getKodeMenu['menu_bar'];
			$kodeMenu = $getKodeMenuBar['menu'];


			$getMaxKodeSubMenu = mysql_fetch_array(mysql_query("select max(sub_menu) from $this->TblName where upline='$menu' and menu_bar ='$kodeMenuBar' and menu ='$menu' and sub_menu != '0' and sub_sub_menu ='0' "));
			$maxMenuSubKode = $getMaxKodeSubMenu['max(sub_menu)'] ;
			$myKodeSubMenu = $maxMenuSubKode['max(sub_menu)'] + 1;

			$data = array(

							'title' => $titleSubMenu,

									);
			$query = VulnWalkerUpdate($this->TblName,$data,"id='$id'");
			mysql_query($query);
			$getMaxKodeSubMenu = mysql_fetch_array(mysql_query("select max(id) from $this->TblName where level='3' and upline='$menu'"));



			$queryCmbSubMenu = "select id, title from $this->TblName where level ='3' and upline='".$menu."'";
			$comboSubMenu = cmbQuery('cmbSubMenu',$id,$queryCmbSubMenu," onchange =$this->Prefix.subMenuChanged(); style='width:400px;'",'-- Pilih Sub Menu --');

			$queryCmbSubSubMenu = "select id, title from $this->TblName where level ='4' and upline='$sub_menu'";
			$comboSubSubMenu = cmbQuery('cmbSubSubMenu',$sub_sub_menu,$queryCmbSubSubMenu," onchange =$this->Prefix.subSubMenuChanged(); style='width:400px;'",'-- Pilih Sub Sub Menu --');

			$content = array('cmbSubMenu' => $comboSubMenu, 'cmbSubSubMenu' => $comboSubSubMenu );

			break;
		}


		case 'saveEditSubSubMenu':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}



			$getKodeMenu = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$id'"));
			$upline = $getKodeMenu['upline'];

			$data = array(

							'title' => $titleSubSubMenu,

									);
			$query = VulnWalkerUpdate($this->TblName,$data,"id='$id'");
			mysql_query($query);


			$queryCmbSubSubMenu = "select id, title from $this->TblName where level ='4' and upline='$upline'";
			$comboSubSubMenu = cmbQuery('cmbSubSubMenu',$id,$queryCmbSubSubMenu," onchange =$this->Prefix.subSubMenuChanged(); style='width:400px;'",'-- Pilih Sub Sub Menu --');

			$content = array( 'cmbSubSubMenu' => $comboSubSubMenu );

			break;
		}

		case 'saveEditLevel5':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}



			$getKodeMenu = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$id'"));
			$upline = $getKodeMenu['upline'];

			$data = array(

							'title' => $titleLevel5,

									);
			$query = VulnWalkerUpdate($this->TblName,$data,"id='$id'");
			mysql_query($query);


			$queryCmbSubSubMenu = "select id, title from $this->TblName where level ='5' and upline='$upline'";
			$comboSubSubMenu = cmbQuery('cmbLevel5',$id,$queryCmbSubSubMenu," onchange =$this->Prefix.level5Changed(); style='width:400px;'",'-- Pilih Level 5 --');

			$content = array( 'cmbLevel5' => $comboSubSubMenu );

			break;
		}
		case 'saveEditFormSubMenu':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

			$data = array(

							'title' => $titleSubMenu,

									);
			$query = VulnWalkerUpdate($this->TblName,$data,"id='$id'");
			mysql_query($query);

			break;
		}

		case 'saveEditFormSubSubMenu':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

			$data = array(

							'title' => $titleSubSubMenu,

									);
			$query = VulnWalkerUpdate($this->TblName,$data,"id='$id'");
			mysql_query($query);

			break;
		}


		case 'saveEditFormLevel5':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

			$data = array(

							'title' => $titleLevel5,

									);
			$query = VulnWalkerUpdate($this->TblName,$data,"id='$id'");
			mysql_query($query);

			break;
		}

			case 'saveEditFormLevel6':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

			$data = array(

							'title' => $titleLevel6,

									);
			$query = VulnWalkerUpdate($this->TblName,$data,"id='$id'");
			mysql_query($query);

			break;
		}

		case 'saveEditFormMenu':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

			$data = array(

							'title' => $titleMenu,

									);
			$query = VulnWalkerUpdate($this->TblName,$data,"id='$id'");
			mysql_query($query);

			break;
		}


		case 'saveEditFormMenuBar':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

			$data = array(

							'title' => $titleMenuBar,

									);
			$query = VulnWalkerUpdate($this->TblName,$data,"id='$id'");
			mysql_query($query);

			break;
		}


		case 'saveEditMenuBar':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}
			$getMaxKodeMenuBar = mysql_fetch_array(mysql_query("select max(menu_bar) from $this->TblName "));
			$maxMenuBarKode =$getMaxKodeMenuBar['max(menu_bar)'] ;
			$myKodeMenuBar = $maxMenuBarKode['max(menu_bar)'] + 1;

			$data = array(

							'title' => $titleMenuBar,
									);
			$query = VulnWalkerUpdate($this->TblName,$data,"id ='$id'");
			mysql_query($query);
			$queryCmbMenuBar = "select id, title from $this->TblName where level ='1'";
			$comboMenuBar = cmbQuery('cmbMenuBar',$id,$queryCmbMenuBar," onchange =$this->Prefix.menuBarChanged(); style='width:400px;'",'-- Pilih Menu Bar --');


			$queryCmbMenu = "select id, title from $this->TblName where level ='2' and upline='$menuBar'";
			$comboMenu = cmbQuery('cmbMenu',$menu,$queryCmbMenu," onchange =$this->Prefix.menuChanged(); style='width:400px;'",'-- Pilih Menu --');


			$queryCmbSubMenu = "select id, title from $this->TblName where level ='3' and upline='$menu'";
			$comboSubMenu = cmbQuery('cmbSubMenu',$sub_menu,$queryCmbSubMenu," onchange =$this->Prefix.subMenuChanged(); style='width:400px;'",'-- Pilih Sub Menu --');

			$queryCmbSubSubMenu = "select id, title from $this->TblName where level ='4' and upline='$sub_menu'";
			$comboSubSubMenu = cmbQuery('cmbSubSubMenu',$sub_sub_menu,$queryCmbSubSubMenu," onchange =$this->Prefix.subSubMenuChanged(); style='width:400px;'",'-- Pilih Sub Sub Menu --');





			$content = array('cmbMenuBar' => $comboMenuBar,'cmbMenu' => $comboMenu, 'cmbSubMenu' => $comboSubMenu, 'cmbSubSubMenu' => $comboSubSubMenu , 'cmbLevel5' => $comboLevel5 );

			break;
		}


		case 'saveEditMenu':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

			$getKodeMenuBar = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$menuBar'"));
			$kodeMenuBar = $getKodeMenuBar['menu_bar'];


			$getMaxKodeMenu = mysql_fetch_array(mysql_query("select max(menu) from $this->TblName where upline='$menuBar' and menu_bar ='$kodeMenuBar' and menu ='0' "));
			$maxMenuKode =$getMaxKodeMenu['max(menu)'] ;
			$myKodeMenu = $maxMenuKode['max(menu)'] + 1;

			$data = array(

							'title' => $titleMenu,

									);
			$query = VulnWalkerUpdate($this->TblName,$data,"id='$id'");
			mysql_query($query);
			$cek = $query;
			$getMaxKodeMenu = mysql_fetch_array(mysql_query("select max(id) from $this->TblName where level='2' and upline='$menuBar'"));


			$queryCmbMenu = "select id, title from $this->TblName where level ='2' and upline='$menuBar'";
			$comboMenu = cmbQuery('cmbMenu',$id,$queryCmbMenu," onchange =$this->Prefix.menuChanged(); style='width:400px;'",'-- Pilih Menu --');


			$queryCmbSubMenu = "select id, title from $this->TblName where level ='3' and upline='".$getMaxKodeMenu['max(id)']."'";
			$comboSubMenu = cmbQuery('cmbSubMenu',$sub_menu,$queryCmbSubMenu," onchange =$this->Prefix.subMenuChanged(); style='width:400px;'",'-- Pilih Sub Menu --');

			$queryCmbSubSubMenu = "select id, title from $this->TblName where level ='4' and upline='$sub_menu'";
			$comboSubSubMenu = cmbQuery('cmbSubSubMenu',$sub_sub_menu,$queryCmbSubSubMenu," onchange =$this->Prefix.subSubMenuChanged(); style='width:400px;'",'-- Pilih Sub Sub Menu --');

			$content = array('cmbMenuBar' => $comboMenuBar,'cmbMenu' => $comboMenu, 'cmbSubMenu' => $comboSubMenu, 'cmbSubSubMenu' => $comboSubSubMenu );

			break;
		}



		case 'menuBarChanged':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}
			$queryCmbMenu = "select id, title from $this->TblName where level ='2' and upline='$menuBar'";
			$comboMenu = cmbQuery('cmbMenu',$menu,$queryCmbMenu," onchange =$this->Prefix.menuChanged(); style='width:400px;'",'-- Pilih Menu --');


			$queryCmbSubMenu = "select id, title from $this->TblName where level ='3' and upline='$menu'";
			$comboSubMenu = cmbQuery('cmbSubMenu',$sub_menu,$queryCmbSubMenu," onchange =$this->Prefix.subMenuChanged(); style='width:400px;'",'-- Pilih Sub Menu --');

			$queryCmbSubSubMenu = "select id, title from $this->TblName where level ='4' and upline='$sub_menu'";

			$comboSubSubMenu = cmbQuery('cmbSubSubMenu',$sub_sub_menu,$queryCmbSubSubMenu," onchange =$this->Prefix.subSubMenuChanged(); style='width:400px;'",'-- Pilih Sub Sub Menu --');

			$queryCmbLevel5 = "select id, title from $this->TblName where level ='5' and upline='$sub_sub_menu'";
	 		$comboLevel5 = cmbQuery('cmbLevel5',$level_5,$queryCmbLevel5," onchange =$this->Prefix.level5Changed(); style='width:400px;'",'-- Pilih Level 5 --');

			$content = array('cmbMenu' => $comboMenu, 'cmbSubMenu' => $comboSubMenu, 'cmbSubSubMenu' => $comboSubSubMenu , 'cmbLevel5' => $comboLevel5 );
		break;
		}

		case 'menuChanged':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}


			$queryCmbSubMenu = "select id, title from $this->TblName where level ='3' and upline='$menu'";
			$comboSubMenu = cmbQuery('cmbSubMenu',$sub_menu,$queryCmbSubMenu," onchange =$this->Prefix.subMenuChanged(); style='width:400px;'",'-- Pilih Sub Menu --');

			$queryCmbSubSubMenu = "select id, title from $this->TblName where level ='4' and upline='$sub_menu'";
			$comboSubSubMenu = cmbQuery('cmbSubSubMenu',$sub_sub_menu,$queryCmbSubSubMenu," onchange =$this->Prefix.subSubMenuChanged(); style='width:400px;'",'-- Pilih Sub Sub Menu --');

			$queryCmbLevel5 = "select id, title from $this->TblName where level ='5' and upline='$sub_sub_menu'";
	 		$comboLevel5 = cmbQuery('cmbLevel5',$level_5,$queryCmbLevel5," onchange =$this->Prefix.level5Changed(); style='width:400px;'",'-- Pilih Level 5 --');


			$content = array( 'cmbSubMenu' => $comboSubMenu, 'cmbSubSubMenu' => $comboSubSubMenu , 'cmbLevel5' => $comboLevel5  );
		break;
		}


		case 'subMenuChanged':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}



			$queryCmbSubSubMenu = "select id, title from $this->TblName where level ='4' and upline='$subMenu'";
			$comboSubSubMenu = cmbQuery('cmbSubSubMenu',$sub_sub_menu,$queryCmbSubSubMenu," onchange =$this->Prefix.subSubMenuChanged(); style='width:400px;'",'-- Pilih Sub Sub Menu --');

			$queryCmbLevel5 = "select id, title from $this->TblName where level ='5' and upline='$sub_sub_menu'";
	 		$comboLevel5 = cmbQuery('cmbLevel5',$level_5,$queryCmbLevel5," onchange =$this->Prefix.level5Changed(); style='width:400px;'",'-- Pilih Level 5 --');


			$content = array(  'cmbSubSubMenu' => $comboSubSubMenu , 'cmbLevel5' => $comboLevel5  );
		break;
		}

		case 'subSubMenuChanged':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}




			$queryCmbLevel5 = "select id, title from $this->TblName where level ='5' and upline='$subSubMenu'";
	 		$comboLevel5 = cmbQuery('cmbLevel5',$level_5,$queryCmbLevel5," onchange =$this->Prefix.level5Changed(); style='width:400px;'",'-- Pilih Level 5 --');


			$content = array(  'cmbLevel5' => $comboLevel5  );
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
		 $getDataUpline = mysql_query("select * from menu_bar where level = '$levelUpline'");
		 while($rows = mysql_fetch_array($getDataUpline)){
		 	$getNamaStrukturUpline = mysql_fetch_array(mysql_query("select * from system where id='".$rows['id_struktur']."'"));
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
			 "<script type='text/javascript' src='js/menuBar/menuBar.js' language='JavaScript' ></script>".
			  "
				<script type='text/javascript' src='js/menuBar/popupStruktur.js' language='JavaScript' ></script>
				<script type='text/javascript' src='js/menuBar/popupShortcut.js' language='JavaScript' ></script>
				<script type='text/javascript' src='js/menuBar/popupUrutan.js' language='JavaScript' ></script>
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
		$this->form_caption = 'Menu Bar - Baru';
		$menu_bar = $_REQUEST['filterMenuBar'];
		$menu = $_REQUEST['filterMenu'];
		$sub_menu = $_REQUEST['filterSubMenu'];
		$sub_sub_menu = $_REQUEST['filterSubSubMenu'];
		$level_5 = $_REQUEST['filterLevel5'];
		$status = "1";

	  }else{
		$this->form_caption = 'Menu Bar - Edit';
		$get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$dt'"));
		foreach ($get as $key => $value) {
			  $$key = $value;
			}
		$getNamaStruktur = mysql_fetch_array(mysql_query("select * from system where id='$id_struktur'"));
		$namaStruktur = $getNamaStruktur['nama'];
	  }

	  $arrayLevel = array(
	  						array('1','1 (MENU BAR)'),
	  						array('2','2 (MENU)'),
	  						array('3','3 (SUB MENU)'),
	  						array('4','4 (SUB SUB MENU)'),
						);

	 $comboLevel = cmbArray('cmbLevel',$level,$arrayLevel,'-- PILIH LEVEL --',"onchange=$this->Prefix.levelChanged();");

	 $arrayUpline = array();
	 $levelUpline = $level - 1;
	 $getDataUpline = mysql_query("select * from menu_bar where level = '$levelUpline'");
	 while($rows = mysql_fetch_array($getDataUpline)){
	 	$getNamaStrukturUpline = mysql_fetch_array(mysql_query("select * from system where id='".$rows['id_struktur']."'"));
		$arrayUpline[] = array($rows['id'],$getNamaStrukturUpline['nama']);
	 }

	 $comboUpline = cmbArray('cmbUpline',$upline,$arrayUpline,'-- PILIH UPLINE --',"onchange= $this->Prefix.uplineChanged();");


	 $queryCmbMenuBar = "select id, title from $this->TblName where level ='1'";
	 $comboMenuBar = cmbQuery('cmbMenuBar',$menu_bar,$queryCmbMenuBar," onchange =$this->Prefix.menuBarChanged(); style='width:400px;'",'-- Pilih Menu Bar --');

	 $queryCmbMenu = "select id, title from $this->TblName where level ='2' and upline='$menu_bar'";
	 $comboMenu = cmbQuery('cmbMenu',$menu,$queryCmbMenu," onchange =$this->Prefix.menuChanged(); style='width:400px;'",'-- Pilih Menu --');


	 $queryCmbSubMenu = "select id, title from $this->TblName where level ='3' and upline='$menu'";
	 $comboSubMenu = cmbQuery('cmbSubMenu',$sub_menu,$queryCmbSubMenu," onchange =$this->Prefix.subMenuChanged(); style='width:400px;'",'-- Pilih Sub Menu --');


	 $queryCmbSubSubMenu = "select id, title from $this->TblName where level ='4' and upline='$sub_menu'";
	 $comboSubSubMenu = cmbQuery('cmbSubSubMenu',$sub_sub_menu,$queryCmbSubSubMenu," onchange =$this->Prefix.subSubMenuChanged(); style='width:400px;'",'-- Pilih Sub Sub Menu --');


	 $queryCmbLevel5 = "select id, title from $this->TblName where level ='5' and upline='$sub_sub_menu'";
	 $comboLevel5 = cmbQuery('cmbLevel5',$level_5,$queryCmbLevel5," onchange =$this->Prefix.level5Changed(); style='width:400px;'",'-- Pilih Level 5 --');



       //items ----------------------
		  $this->form_fields = array(



			'menu_bar' => array(
						'label'=>'MENU BAR',
						'labelWidth'=>130,
						'value'=>$comboMenuBar." &nbsp <input type='button' value='Baru' onclick=$this->Prefix.newMenuBar();> &nbsp <input type='button' value='Edit' onclick=$this->Prefix.editMenuBar();>",
						 ),
			'menu' => array(
						'label'=>'MENU',
						'labelWidth'=>130,
						'value'=>$comboMenu." &nbsp <input type='button' value='Baru' onclick=$this->Prefix.newMenu();> &nbsp <input type='button' value='Edit' onclick=$this->Prefix.editMenu();>",
						 ),
			'sub_menu' => array(
						'label'=>'SUB MENU',
						'labelWidth'=>130,
						'value'=>$comboSubMenu." &nbsp <input type='button' value='Baru' onclick=$this->Prefix.newSubMenu();> &nbsp <input type='button' value='Edit' onclick=$this->Prefix.editSubMenu();>",
						 ),
			'sub_sub_menu' => array(
						'label'=>'SUB SUB MENU',
						'labelWidth'=>130,
						'value'=>$comboSubSubMenu." &nbsp <input type='button' value='Baru' onclick=$this->Prefix.newSubSubMenu();> &nbsp <input type='button' value='Edit' onclick=$this->Prefix.editSubSubMenu();>",
						 ),
			'level_5' => array(
						'label'=>'LEVEL 5',
						'labelWidth'=>130,
						'value'=>$comboLevel5." &nbsp <input type='button' value='Baru' onclick=$this->Prefix.newLevel5();> &nbsp <input type='button' value='Edit' onclick=$this->Prefix.editLevel5();>",
						 ),

			'title' => array(
						'label'=>'LEVEL 6',
						'labelWidth'=>130,
						'value'=>"<input type='text' name='title' id='title'  value='".$title."' style='width:500px;'> ",
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
		$this->form_caption = 'Menu Bar - Baru';
	  }else{
		$this->form_caption = 'Menu Bar - Edit';
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
	   <th class='th01' width='700' align='center'>TITLE</th>
	   <th class='th01' width='400' align='center'>URL</th>
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
	 $kode = $menu_bar.".".$menu.".".$sub_menu.".".$sub_sub_menu.".".$level_5.".".$level_6;
	 $Koloms[] = array('align="center"',$kode);
	 if($level == '2'){
	 	$margin = "<span style='margin-left:10px;'>";
	 }elseif($level == '3'){
	 	$margin = "<span style='margin-left:20px;'>";
	 }elseif($level == '4'){
	 	$margin = "<span style='margin-left:30px;'>";
	 }elseif($level == '5'){
	 	$margin = "<span style='margin-left:40px;'>";
	 }elseif($level == '6'){
	 	$margin = "<span style='margin-left:50px;'>";
	 }

	  $Koloms[] = array('align="left"',$margin.$title);
	  $Koloms[] = array('align="left"',"<a href='$url' target='_blank'>$url</a>");
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


	 if(empty($jumlahPerHal))$jumlahPerHal = "25";
	  $arr = array(
	  		array('1','AKTIF'),
			array('0','TIDAK AKTIF'),

			);
		$comboStatus = cmbArray('statusFilter',$statusFilter,$arr,'-- SEMUA STATUS --',"onchange= $this->Prefix.refreshList(true)");



	 $queryCmbMenuBar = "select id, title from $this->TblName where level ='1' order by  concat(right((100 +menu_bar),2),'.',right((100 +menu),2),'.',right((100 +sub_menu),2),'.',right((100 +sub_sub_menu),2),'.',right((100 +level_5),2),'.',right((100 +level_6),2))";
	 $comboMenuBar = cmbQuery('filterMenuBar',$filterMenuBar,$queryCmbMenuBar," onchange =$this->Prefix.refreshList(true); style='width:400px;'",'-- Pilih Menu Bar --');

	 $queryCmbMenu = "select id, title from $this->TblName where level ='2' and upline='$filterMenuBar' order by  concat(right((100 +menu_bar),2),'.',right((100 +menu),2),'.',right((100 +sub_menu),2),'.',right((100 +sub_sub_menu),2),'.',right((100 +level_5),2),'.',right((100 +level_6),2))";
	 $comboMenu = cmbQuery('filterMenu',$filterMenu,$queryCmbMenu," onchange =$this->Prefix.refreshList(true); style='width:400px;'",'-- Pilih Menu --');


	 $queryCmbSubMenu = "select id, title from $this->TblName where level ='3' and upline='$filterMenu' order by  concat(right((100 +menu_bar),2),'.',right((100 +menu),2),'.',right((100 +sub_menu),2),'.',right((100 +sub_sub_menu),2),'.',right((100 +level_5),2),'.',right((100 +level_6),2))";
	 $comboSubMenu = cmbQuery('filterSubMenu',$filterSubMenu,$queryCmbSubMenu," onchange =$this->Prefix.refreshList(true); style='width:400px;'",'-- Pilih Sub Menu --');

	  $queryCmbSubSubMenu = "select id, title from $this->TblName where level ='4' and upline='$filterSubMenu' order by  concat(right((100 +menu_bar),2),'.',right((100 +menu),2),'.',right((100 +sub_menu),2),'.',right((100 +sub_sub_menu),2),'.',right((100 +level_5),2),'.',right((100 +level_6),2))";
	  $comboSubSubMenu = cmbQuery('filterSubSubMenu',$filterSubSubMenu,$queryCmbSubSubMenu," onchange =$this->Prefix.refreshList(true); style='width:400px;'",'-- Pilih Sub Sub Menu --');


	  $queryCmbLevel5 = "select id, title from $this->TblName where level ='5' and upline='$filterSubSubMenu' order by  concat(right((100 +menu_bar),2),'.',right((100 +menu),2),'.',right((100 +sub_menu),2),'.',right((100 +sub_sub_menu),2),'.',right((100 +level_5),2),'.',right((100 +level_6),2))";
	  $comboLevel5 = cmbQuery('filterLevel5',$filterLevel5,$queryCmbLevel5," onchange =$this->Prefix.refreshList(true); style='width:400px;'",'-- Pilih Level 5 --');


	  $queryCmbLevel6 = "select id, title from $this->TblName where level ='6' and upline='$filterLevel5' order by  concat(right((100 +menu_bar),2),'.',right((100 +menu),2),'.',right((100 +sub_menu),2),'.',right((100 +sub_sub_menu),2),'.',right((100 +level_5),2),'.',right((100 +level_6),2))";
	  $comboLevel6 = cmbQuery('filterLevel6',$filterLevel6,$queryCmbLevel6," onchange =$this->Prefix.refreshList(true); style='width:400px;'",'-- Pilih Level 6 --');


	 $TampilOpt =
			"<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td>MENU BAR </td>
			<td>: </td>
			<td style='width:90%;'>$comboMenuBar </td>
			</tr>
			<tr>
			<td>MENU </td>
			<td>: </td>
			<td style='width:90%;'>$comboMenu</td>
			</tr>
			<tr>
			<td>SUB MENU </td>
			<td>: </td>
			<td style='width:90%;'>$comboSubMenu</td>
			</tr>

			<tr>
			<td>SUB SUB MENU </td>
			<td>: </td>
			<td style='width:90%;'>$comboSubSubMenu</td>
			</tr>

			<tr>
			<td>MENU LEVEL 5 </td>
			<td>: </td>
			<td style='width:90%;'>$comboLevel5</td>
			</tr>

			<tr>
			<td>MENU LEVEL 6 </td>
			<td>: </td>
			<td style='width:90%;'>$comboLevel6</td>
			</tr>


			<tr>
			<td>STATUS </td>
			<td>: </td>
			<td style='width:90%;'>$comboStatus</td>
			</tr>
			<tr>







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
		if(!empty($filterMenuBar)){
			$getKodeMenuBar = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$filterMenuBar'"));
			$arrKondisi[] = "menu_bar ='".$getKodeMenuBar['menu_bar']."'";
		}
		if(!empty($filterMenu)){
			$getKodeMenu = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$filterMenu'"));
			$arrKondisi[] = "menu ='".$getKodeMenu['menu']."'";
		}
		if(!empty($filterSubMenu)){
			$getKodeSubMenu = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$filterSubMenu'"));
			$arrKondisi[] = "sub_menu ='".$getKodeSubMenu['sub_menu']."'";
		}
		if(!empty($filterSubSubMenu)){
			$getKodeSubSubMenu = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$filterSubSubMenu'"));
			$arrKondisi[] = "sub_sub_menu ='".$getKodeSubSubMenu['sub_sub_menu']."'";
		}

		if(!empty($filterLevel5)){
			$getKodeLevel5 = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$filterLevel5'"));
			$arrKondisi[] = "level_5 ='".$getKodeLevel5['level_5']."'";
		}

		if(!empty($filterLevel6)){
			$getKodeLevel6 = mysql_fetch_array(mysql_query("select * from $this->TblName where id='$filterLevel6'"));
			$arrKondisi[] = "level_6 ='".$getKodeLevel6['level_6']."'";
		}


		if($statusFilter !='')$arrKondisi[]="status ='$statusFilter'";

/*		$this->arrayMember = json_encode($arrayMember);*/


		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		$arrOrders[] = "concat(right((100 +menu_bar),2),'.',right((100 +menu),2),'.',right((100 +sub_menu),2),'.',right((100 +sub_sub_menu),2),'.',right((100 +level_5),2),'.',right((100 +level_6),2))";
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
	function newMenuBar(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 	$this->form_caption = 'MENU BAR BARU';


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleMenuBar' id='titleMenuBar' style='width:250px;' value=''>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNewMenuBar()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function newMenu(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 	$this->form_caption = 'MENU BARU';


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleMenu' id='titleMenu' style='width:250px;' value=''>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNewMenu()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function newSubMenu(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 	$this->form_caption = 'SUB MENU BARU';


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleSubMenu' id='titleSubMenu' style='width:250px;' value=''>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNewSubMenu()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function newSubSubMenu(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 	$this->form_caption = 'SUB SUB MENU BARU';


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleSubSubMenu' id='titleSubSubMenu' style='width:250px;' value=''>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNewSubSubMenu()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function newLevel5(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 	$this->form_caption = 'MENU LEVEL 5';


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleLevel5' id='titleLevel5' style='width:250px;' value=''>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNewLevel5()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editMenuBar(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 $this->form_caption = 'MENU BAR EDIT';
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$menuBar'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleMenuBar' id='titleMenuBar' style='width:250px;' value='$title'>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveEditMenuBar($menuBar)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editMenu(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 $this->form_caption = 'MENU EDIT';
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$menu'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleMenu' id='titleMenu' style='width:250px;' value='$title'>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveEditMenu($menu)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$menuBar_cb[0]'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'URL',
						'labelWidth'=>4,
						'value'=>"<input type='text' name='url' id ='url' value='$url' style='width:200px;'> &nbsp <input type='button' value='Cari' onclick=popupStruktur.windowShow();> &nbsp <input type='button' value='Shortcut' onclick=popupShortcut.windowShow();> ",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveURL($menuBar_cb[0])' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function Urut(){
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
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$menuBar_cb[0]'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'NOMOR URUT',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='nomorUrut' id='nomorUrut' value='$nomor_urut'>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveNomorUrut($menuBar_cb[0])' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function editSubMenu(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 $this->form_caption = 'SUB MENU EDIT';
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$subMenu'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleSubMenu' id='titleSubMenu' style='width:250px;' value='$title'>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveEditSubMenu($subMenu)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}



	function editSubSubMenu(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 $this->form_caption = 'SUB SUB MENU EDIT';
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$subSubMenu'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleSubSubMenu' id='titleSubSubMenu' style='width:250px;' value='$title'>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveEditSubSubMenu($subSubMenu)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function editLevel5(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 $this->form_caption = 'EDIT MENU LEVEL 5';
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleLevel5' id='titleLevel5' style='width:250px;' value='$title'>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveEditLevel5($id)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function formEditSubMenu(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 $this->form_caption = 'SUB MENU EDIT';
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleSubMenu' id='titleSubMenu' style='width:250px;' value='$title'>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveEditFormSubMenu($id)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function formEditSubSubMenu(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 $this->form_caption = 'SUB SUB MENU EDIT';
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleSubSubMenu' id='titleSubSubMenu' style='width:250px;' value='$title'>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveEditFormSubSubMenu($id)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function formEditLevel5(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 $this->form_caption = 'MENU LEVEL 5';
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleLevel5' id='titleLevel5' style='width:250px;' value='$title'>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveEditFormLevel5($id)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function formEditLevel6(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 $this->form_caption = 'MENU LEVEL 6';
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleLevel6' id='titleLevel6' style='width:250px;' value='$title'>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveEditFormLevel6($id)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function formEditMenu(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 $this->form_caption = 'MENU EDIT';
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleMenu' id='titleMenu' style='width:250px;' value='$title'>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveEditFormMenu($id)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


	function formEditMenuBar(){
	 global $SensusTmp, $Main;

	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_formKB';
	 $this->form_width = 400;
	 $this->form_height = 60;
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
				}

	 $this->form_caption = 'MENU BAR EDIT';
	 $get = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}


	 //items ----------------------
	  $this->form_fields = array(
			'213' => array(
						'label'=>'TITLE',
						'labelWidth'=>100,
						'value'=>"<input type = 'text' name='titleMenuBar' id='titleMenuBar' style='width:250px;' value='$title'>",
						 ),
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveEditFormMenuBar($id)' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genFormKB();
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

 function Hapus_Validasi($id){
		$errmsg ='';
		$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where id ='$id'"));
		foreach ($getData as $key => $value) {
				  $$key = $value;
				}
		if($level == '1'){
			$errmsg = "Delete semua downline dari $title ?";

		}elseif($level == '2'){
			$errmsg = "Delete semua downline dari $title ?";


		}elseif($level == '3'){
			$errmsg = "Delete semua downline dari $title ?";


		}elseif($level == '4'){
				$errmsg = "Delete semua downline dari $title ?";

		}elseif($level == '5'){
				$errmsg = "Delete semua downline dari $title ?";

		}
		if(empty($errmsg)){
			mysql_query("delete from $this->TblName where id ='$id'");
		}


		return $errmsg;

}



}
$menuBar = new menuBarObj();
$menuBar->username =$_COOKIE['coID'];
?>
