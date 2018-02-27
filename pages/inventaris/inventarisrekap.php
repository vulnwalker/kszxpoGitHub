<?php

class InventarisRekapObj extends DaftarObj2{
	var $Prefix = 'InventarisRekap';
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_buku_induk2';//view2_sensus';
	var $TblName_Hapus = 'buku_induk';
	var $TblName_Edit = 'buku_induk';
	var $KeyFields = array('f','g','h','i','j','ref_idruang');
	var $FieldSum = array();
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 9, 8, 8);
	var $FieldSum_Cp2 = array( 3, 3, 3);
	var $checkbox_rowspan = 3;
	var $FormName = 'InventarisRekapForm';
	var $pagePerHal = '';
	//var $withSumAll = FALSE;
	//var $withSumHal = FALSE;
	//var $WITH_HAL = FALSE;

	var $PageTitle = 'Inventarisasi';
	var $PageIcon = 'images/penatausahaan_ico.gif';
	var $ico_width = '20';
	var $ico_height = '30';

	var $fileNameExcel='InventarisRekap.xls';
	var $Cetak_Judul = 'Inventaris Rekap';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $fmST = 0;
	var $idpilih = '';
	var $username = "";
	var $versi = "ngaco";
	var $reportBast = "bogor";
	//var $row_params= " valign='top'";


	function setTitle(){
		global $Main;
		return 'Inventarisasi Rekap';

	}

	function setNavAtas(){
		return
			/*'<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td class="menudottedline" width="60%" height="20" style="text-align:right"><b>
				<a href="pages.php?Pg=lra" title="Daftar LRA">DAFTAR LRA</a>
				  &nbsp;&nbsp;&nbsp;
			</b></td>
			</tr>
			</table>';	*/"";
	}

	function setMenuEdit(){
		$uid = $_COOKIE['coID'];
		return "<td>".genPanelIcon("javascript:".$this->Prefix.".formPengaturan()","Setting2_24.png","Pengaturan", 'Pengaturan')."</td>";
			/*"<td>".genPanelIcon("javascript:".$this->Prefix.".Batal()","delete_f2.png","Batal", 'Batal')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Report(\"$uid\")","edit_f2.png","Report", 'Report')."</td>"
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".pengaturan()","edit_f2.png","Pengaturan", 'Pengaturan')."</td>"
			;*/
	}

	function setMenuView(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png",'Halaman',"Cetak Daftar per Halaman")."</td>".
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakAll(\"$Op\")","print_f2.png",'Cetak',"Cetak Daftar")."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".exportXls(\"$Op\")","export_xls.png",'Excel',"Export Excel")."</td>";

	}

	function genDaftarOpsi(){
		global $Main,$fmFiltThnBuku;
		Global $fmSKPDBidang,$fmSKPDskpd;
		$Opsi = $this->getDaftarOpsi();			
		$fmURUSAN = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST($this->Prefix.'SkpdfmURUSAN');
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST($this->Prefix.'SkpdfmSKPD');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		$fmSEKSI = isset($HTTP_COOKIE_VARS['cofmSEKSI'])? $HTTP_COOKIE_VARS['cofmSEKSI']: cekPOST($this->Prefix.'SkpdfmSEKSI');
		$tgl_cek = date('d-m-Y');
		$fmKdBarang = cekPOST('kdbarang');
		$fmIdBarang = cekPOST('idbarang');
		$fmTahunBuku = cekPOST('fmTahunBuku');
		//$fmTahunBuku2 = cekPOST('fmTahunBuku2');
		$fmStMutasi=  cekPOST('stmutasi');
		$fmStAset=  cekPOST('staset');
		$fmPILGEDUNG=  cekPOST('fmPILGEDUNG');
		$fmPILRUANG=  cekPOST('fmPILRUANG');	
		$cmbStatus=  cekPOST('cmbStatus'); 			
		$jmPerHal = $_REQUEST['jmPerHal']==''?$Main->PagePerHal:$_REQUEST['jmPerHal'];
				
		$c1= $fmURUSAN; $c= $fmSKPD; $d= $fmUNIT; $e= $fmSUBUNIT;$e1= $fmSEKSI;
		//-- kondisi gedung
		$arrkondgdg = array();			
		if(!($c1=='' || $c =='00')) $arrkondgdg[] = " c1 = '$c1' ";
		if(!($c=='' || $c =='00')) $arrkondgdg[] = " c = '$c' ";
		if(!($d=='' || $d =='00')) $arrkondgdg[] = " d = '$d' ";
		if(!($e=='' || $e =='00')) $arrkondgdg[] = " e = '$e' ";						
		if(!($e1=='' || $e1 =='00' || $e1 =='000')) $arrkondgdg[] = " e1 = '$e1' ";						
		$arrkondgdg[] =  "q='0000'";
		$Kondisigdg = join(' and ',$arrkondgdg);
		if($Kondisigdg != '') $Kondisigdg = ' where '.$Kondisigdg;
		
		//-- kondisi ruang
		if(!($fmPILGEDUNG=='' )) {
			$arrkondgdg = array();
			//$arrkondgdg[] =  "q<>'0000'";	
			$arrkondgdg = explode(' ',$fmPILGEDUNG);	
			$c1 = $arrkondgdg[0]; $c = $arrkondgdg[1]; $d = $arrkondgdg[2]; 
			$e = $arrkondgdg[3]; $e1 = $arrkondgdg[4];$p = $arrkondgdg[5];
			
			$arrkondgdg = array();
			if(!($c1=='' || $c =='00')) $arrkondgdg[] = " c1 = '$c1' ";
			if(!($c=='' || $c =='00')) $arrkondgdg[] = " c = '$c' ";
			if(!($d=='' || $d =='00')) $arrkondgdg[] = " d = '$d' ";
			if(!($e=='' || $e =='00')) $arrkondgdg[] = " e = '$e' ";
			if(!($e1=='' || $e1 =='00' || $e1 =='000')) $arrkondgdg[] = " e1 = '$e1' ";
		
			$arrkondgdg[] = " p = '$p' ";
			$arrkondgdg[] =  "q<>'0000'";			
			$KondisiRuang = join(' and ',$arrkondgdg);
			if($KondisiRuang != '') $KondisiRuang = ' where '.$KondisiRuang;
		}else{
			$KondisiRuang = ' where 1= 0 ';
		}
		
		//kondisi untuk tgl Buku
		$KondisiTglbuku= join(' and ',$this->getKondisiSetting());
		
		$arrayStatus = array(
			array('1','Belum'),
			array('2','Sudah'),
			);		
				
		$OptCari =  //$Main->ListData->OptCari =
			"<table width=\"100%\" height=\"100%\" class=\"adminform\" style='margin: 4 0 0 0;'>
			<tr >
			<td align='Left'> &nbsp;&nbsp;".
			"<div style='float:left'>".
				CariCombo4($ArFieldCari, $fmCariComboField, $fmCariComboIsi,"SOTKBaru.refreshList(true)" ).
			"</div>".
			"<div id='".$this->prefix."_pilihan_msg' style='float:right;padding: 4 4 4 8;'></div>".
			"</td>".
			"<td width='375'>".
				/*"<span style='color:red'>BARCODE</span><br>
				<input type='TEXT' value=''
					id='barcodeSensus_input' name='barcodeSensus_input'
					style='font-size:24;width: 379px;'
					size='28' maxlength='28'>
				<span id='barcodeSensus_msg' name='barcodeSensus_msg' ></span>".
				*/
				$barcodeCari.


				//<input type='TEXT' value='' 	style='	font-weight:bold' 	size='50'	>-->
			"</td>
			</tr>
		</table>";

		$BarisPerHalaman =
			"<div style='float:left;padding: 2 8 0 0;height:20;padding: 4 4 0 0'> ".
			" Baris per halaman <input type=text name='jmPerHal' id='jmPerHal' size=4 value='$jmPerHal'> </div>"
			;

		$TampilOpt =
			genFilterBar(array(WilSKPD_ajx3($this->Prefix.'Skpd')),'','','').
			genFilterBar(
				array(
					
					"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> ".
					"Tgl Cek : <input type='text' name='tgl_cek' id='tgl_cek' value='$tgl_cek'>
".
					"</div>".
					"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>".					
					"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> ".
					"Gedung &nbsp; ".						
						"<span id='cbxGedung'>".
						genComboBoxQry2( 'fmPILGEDUNG', $fmPILGEDUNG, 
							"select c1,c,d,e,e1,p, concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',p,' ',nm_ruang) as nm_gedung from ref_ruang $Kondisigdg order by c1,c,d,e,e1,p,q ",
							array('c1','c','d','e','e1','p'), 'nm_gedung', '-- Semua Gedung --',"onChange=\"InventarisRekap.pilihGedungOnchange()\"" ).
						"</span>".
					"</div>".
					"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>
					<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> ".
					"Ruang &nbsp".
						"<span id='cbxRuang'>".
						genComboBoxQry( 'fmPILRUANG', $fmPILRUANG, 
							"select * from ref_ruang  $KondisiRuang  order by c1,c,d,e,e1,p,q",
							'q', 'nm_ruang', '-- Semua Ruang --',"style=''"  ).
						"</span>".
					"</div>".
					"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>".										
					"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> ".
					"Kode barang : <input type='text' id='kdbarang' name='kdbarang' size='14' value='$fmKdBarang' placeholder='kode Barang' >".
					"</div>".
					"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>
					<div style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
						genComboBoxQry('fmTahunBuku',$fmTahunBuku,
							"select  year(tgl_buku) as thn_buku, year(tgl_buku) as thn_buku from $this->TblName Where ".$KondisiTglbuku." group by year(tgl_buku) order by year(tgl_buku) DESC",
							'thn_buku', 'thn_buku','-- Tahun Buku --').
					"</div>".
					"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>
					<div style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
						cmbArray('cmbStatus',$cmbStatus,$arrayStatus,'-- Status --','').
					"</div>"

					/*"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>".
					"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
					cmb2D_v2('staset', $staset, $Main->StatusAsetView, '','Semua Status Aset').
					"</div>".*/
					//"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>".
					//$BarisPerHalaman
	
				),$this->Prefix.".refreshList(true)",TRUE
			)		
			;

		return array('TampilOpt'=>$TampilOpt);


	}
	
	function getKondisiSetting(){
		$arrKondisi=array();
		$arrKondisi[] = "status_barang <> '3' and status_barang <> '4' and status_barang <> '5'";
		//=================================kondisi sesuai setting inventais======================//		
		//set kondisi sesuai setting inventaris
		$dtsetting = mysql_fetch_array(mysql_query("select * from setting_inventaris order by thn_sensus,Id DESC limit 0,1 "));
		//set kondisi kib
		if(!empty($dtsetting['data_barang'])){
			//get data Kib
			$dtbarang=explode(',',$dtsetting['data_barang']);
			$valuedb=array();
			for($i=0;$i<sizeof($dtbarang);$i++){
				if($dtbarang[$i]==1){
					$valuedb[]="0".$i+1;				
				}
			}
			$databarang= join(',',$valuedb);
			$arrKondisi[] = " f in ($databarang) ";
		}
		//set kondisi staset
		if(!empty($dtsetting['staset'])) $arrKondisi[] = " staset in (".$dtsetting['staset'].") ";		
		
		//kondisi tgl buku
		if (!empty($dtsetting['thn_buku1']) && !empty($dtsetting['thn_buku2']) ) {
			$arrKondisi[] = " year(tgl_buku) >= '".$dtsetting['thn_buku1']."'  and year(tgl_buku) <= '".$dtsetting['thn_buku2']."'  ";
		}else if (!empty($dtsetting['thn_buku1']) && empty($dtsetting['thn_buku2']) ) {
			$arrKondisi[] = " year(tgl_buku) >= '".$dtsetting['thn_buku1']."'  ";
		}else if (empty($dtsetting['thn_buku1']) && !empty($dtsetting['thn_buku2']) ) {
			$arrKondisi[] = " year(tgl_buku) <= '".$dtsetting['thn_buku2']."'  ";
		}
		//======================================================================================//
		return $arrKondisi;
	}

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		global $fmPILCARI;
		$UID = $_COOKIE['coID'];
		//kondisi -----------------------------------

		$arrKondisi = array();
		
		$fmURUSAN = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST($this->Prefix.'SkpdfmURUSAN');
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST($this->Prefix.'SkpdfmSKPD');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		$fmSEKSI = isset($HTTP_COOKIE_VARS['cofmSEKSI'])? $HTTP_COOKIE_VARS['cofmSEKSI']: cekPOST($this->Prefix.'SkpdfmSEKSI');

		$arrKondisi[] =
		//$tes =
		getKondisiSKPD3(
			$Main->DEF_KEPEMILIKAN,
			$Main->Provinsi[0],
			$Main->DEF_WILAYAH,
			$fmSKPD,
			$fmUNIT,
			$fmSUBUNIT,
			$fmSEKSI,
			$fmURUSAN
		);
 
		//$arrKondisi[]=array_merge($this->getKondisiSetting(),$arrKondisi);					
		//sizeof($this->getKondisiSetting())
		$KondisiSetting = $this->getKondisiSetting();
		for($i=0;$i<sizeof($KondisiSetting);$i++){
			$arrKondisi[] = $KondisiSetting[$i];
		}
		
		$fmKdBarang = cekPOST('kdbarang');
		$fmIdBarang = cekPOST('idbarang');
		$fmTahunBuku = cekPOST('fmTahunBuku');
		//$fmTahunBuku2 = cekPOST('fmTahunBuku2');
		$fmStMutasi=  cekPOST('stmutasi');
		$fmStAset=  cekPOST('staset');
		$fmThn2=  cekPOST('fmThn2');
		$fmSemester = cekPOST('fmSemester');
		$fmPILGEDUNG=  cekPOST('fmPILGEDUNG');
		$fmPILRUANG=  cekPOST('fmPILRUANG');
		$cmbStatus=  cekPOST('cmbStatus'); 			
		$kg=explode(" ",$fmPILGEDUNG);	
		
		if($fmKdBarang != '') $arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j,'.') like '$fmKdBarang%' ";
		if($fmIdBarang != '') $arrKondisi[] = " id='$fmIdBarang' ";

		/*if($fmStAset==1){
			if(!empty($fmStAset)) $arrKondisi[] = " staset <= '9' ";
		}else{
			if(!empty($fmStAset)) $arrKondisi[] = " staset = '$fmStAset' ";
		}*/
		
		if($cmbStatus==1){
			if(!empty($cmbStatus)) $arrKondisi[] = " id not in (select idbi from inventaris) ";
		}else{
			if(!empty($cmbStatus)) $arrKondisi[] = " id in (select idbi from inventaris) ";
		}		

		if(!empty($fmPILRUANG)){
			if(!empty($fmPILRUANG)) $arrKondisi[] = " ref_idruang in (select id from ref_ruang WHERE c1='".$kg[0]."' and c='".$kg[1]."' and d='".$kg[2]."' and e='".$kg[3]."' and e1='".$kg[4]."' and p='".$kg[5]."' and q='".$fmPILRUANG."') ";
		}else{
			if(!empty($fmPILGEDUNG)) $arrKondisi[] = " ref_idruang in (select id from ref_ruang WHERE c1='".$kg[0]."' and c='".$kg[1]."' and d='".$kg[2]."' and e='".$kg[3]."' and e1='".$kg[4]."' and p='".$kg[5]."') ";
		}
		
		if(!empty($fmTahunBuku)) $arrKondisi[] = " year(tgl_buku) = '$fmTahunBuku' ";		
		
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		/*$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
			switch($fmORDER1){
				//case '': $arrOrders[] = " tgl DESC " ;break;
				case '1': $arrOrders[] = " thn_perolehan $Asc1 " ;break;
				case '2': $arrOrders[] = " kondisi $Asc1 " ;break;
				case '3': $arrOrders[] = " year(tgl_buku) $Asc1 " ;break;

			}
			$arrOrders [] = " a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg";
			$Order= join(',',$arrOrders);
			$OrderDefault = '';// Order By no_terima desc ';
			$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//}*/
		//$Order =" group by f,g,h,i,j, ref_idruang ";
		//limit --------------------------------------
		/**$HalDefault=cekPOST($this->Prefix.'_hal',1);	//Cat:Settingan Lama
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;
		**/
		$jmPerHal = cekPOST("jmPerHal");
		$Main->PagePerHal = !empty($jmPerHal) ? $jmPerHal : $Main->PagePerHal;
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

	function genDaftarInitial(){
		$vOpsi = $this->genDaftarOpsi();
		$fmFiltThnAnggaran=$_COOKIE['coThnAnggaran'];
		return
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>".
				//"<input type='hidden' id='fmFiltThnAnggaran' name='fmFiltThnAnggaran' value='$fmFiltThnAnggaran'>".
				//"<input type='hidden' id='fmNMBARANG' name='fmNMBARANG' value='$fmNMBARANG'>".
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

	function setPage_OtherScript(){
		$scriptload =
					"<script>

						$(document).ready(function(){
							".$this->Prefix.".loading();

						});


					</script>";
		return "<script src='js/skpd.js' type='text/javascript'></script>
				<script src='js/barcode.js' type='text/javascript'></script>
				<script type='text/javascript' src='js/inventaris/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
				<script type='text/javascript' src='js/inventaris/inventarisshow.js' language='JavaScript' ></script>
				".'<link rel="stylesheet" href="datepicker/jquery-ui.css">
			  	<script src="datepicker/jquery-1.12.4.js"></script>
			  	<script src="datepicker/jquery-ui.js"></script>'.				
						$scriptload;
	}

	function setKolomHeader($Mode=1, $Checkbox='3'){
		$cetak = $Mode==2 || $Mode==3 ;


		$headerTable =
				"<tr>
				<th class='th01' width='20' rowspan=3>No.</th>
				$Checkbox
				<th class='th01' rowspan=3>Kode Barang</th>
				<th class='th01' rowspan=3>Nama Barang</th>
				<th class='th01' rowspan=3>Gedung / Ruang</th>
				<th class='th02' rowspan=2 colspan=3>Kondisi Awal</th>
				<th class='th01' rowspan=3 style='min-width:50px'>Jumlah</th>
				<th class='th02' colspan=5>Inventarisasi</th>
				<th class='th01' rowspan=3>Status</th>
				<th class='th01' rowspan=3>Sesuai <br> Buku Induk</th>
				</tr>
				<tr>
				<th class='th02' colspan=2>Ada / Tidak</th>
				<th class='th02' colspan=3>kondisi</th>
				</tr>
				<tr>
				<th class='th01' style='min-width:50px'>Baik</th>
				<th class='th01' style='min-width:50px'>Kurang baik</th>
				<th class='th01' style='min-width:50px'>Rusak Berat</th>				
				<th class='th01' style='min-width:50px'>Ada</th>
				<th class='th01' style='min-width:50px'>Tidak Ada</th>
				<th class='th01' style='min-width:50px'>Baik</th>
				<th class='th01' style='min-width:50px'>Kurang baik</th>
				<th class='th01' style='min-width:50px'>Rusak Berat</th>
				</tr>

				";

		return $headerTable;
	}

	function setDaftar_query($Kondisi='', $Order='', $Limit=''){
		$aqry = "select *, count(*) as jml_bi from $this->TblName $Kondisi $Order group by f,g,h,i,j, ref_idruang $Limit ";	//echo $aqry;
		//return mysql_query($aqry);
		return $aqry;
	}
	
	function setSumHal_query($Kondisi, $fsum){
		return "select $fsum from (select * from $this->TblName $Kondisi group by f,g,h,i,j, ref_idruang) as aa "; //echo $aqry;
		
		//return " select "
	}	

	function setInventaris_query($Kondisi='', $Order='', $Limit='', $KondisiBarang=''){
	
		$aqry = "select ifnull(count(*),0) as jml_bi from $this->TblName $Kondisi $KondisiBarang $Order $Limit ";	//echo $aqr			//return mysql_query($aqry);
		return $aqry;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref,$HTTP_COOKIE_VARS;
		$arrStatus = array ('','','', 'Batal','Dihapus');
		$thnskr=$HTTP_COOKIE_VARS['coThnAnggaran'];

		$kode_brg = $isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'];
		$id = $isi['f'].'-'.$isi['g'].'-'.$isi['h'].'-'.$isi['i'].'-'.$isi['j'].'-'.$isi['ref_idruang'];

		//get inventaris
		$queryInv="select * from inventaris where idbi='".$isi['id']."' and tahun_sensus='".$thnskr."'";
		$dtInv=mysql_fetch_array(mysql_query($queryInv));

		//===================================get status ada dan tidak====================================//
		$Opsi = $this->getDaftarOpsi();		
		$KondisiBarangAda = " AND f='".$isi['f']."' AND g='".$isi['g']."' AND h='".$isi['h']."' AND i='".$isi['i']."' AND j='".$isi['j']."' AND ref_idruang='".$isi['ref_idruang']."' AND id in (select idbi from inventaris WHERE ada ='1')";
		$dtstada = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], "", $KondisiBarangAda)));
		
		$KondisiBarangTidakAda = " AND f='".$isi['f']."' AND g='".$isi['g']."' AND h='".$isi['h']."' AND i='".$isi['i']."' AND j='".$isi['j']."' AND ref_idruang='".$isi['ref_idruang']."' AND id in (select idbi from inventaris WHERE ada ='2')";	
		$dtstTidak = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], "", $KondisiBarangTidakAda)));	
		
		$KondisiBarangBaik = " AND f='".$isi['f']."' AND g='".$isi['g']."' AND h='".$isi['h']."' AND i='".$isi['i']."' AND j='".$isi['j']."' AND ref_idruang='".$isi['ref_idruang']."' AND id in (select idbi from inventaris WHERE kondisi ='1')";	
		$dtstBaik = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], "", $KondisiBarangBaik)));	
		
		$KondisiBarangKurang = " AND f='".$isi['f']."' AND g='".$isi['g']."' AND h='".$isi['h']."' AND i='".$isi['i']."' AND j='".$isi['j']."' AND ref_idruang='".$isi['ref_idruang']."' AND id in (select idbi from inventaris WHERE kondisi ='2')";	
		$dtstKurang = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], "", $KondisiBarangKurang)));	
		
		$KondisiBarangRusak = " AND f='".$isi['f']."' AND g='".$isi['g']."' AND h='".$isi['h']."' AND i='".$isi['i']."' AND j='".$isi['j']."' AND ref_idruang='".$isi['ref_idruang']."' AND id in (select idbi from inventaris WHERE kondisi ='3')";	
		$dtstRusak = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], "", $KondisiBarangRusak)));	
		
		$KondisiBarangBaikAwl = " AND f='".$isi['f']."' AND g='".$isi['g']."' AND h='".$isi['h']."' AND i='".$isi['i']."' AND j='".$isi['j']."' AND ref_idruang='".$isi['ref_idruang']."' AND kondisi ='1'";	
		$dtstBaikAwl = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], "", $KondisiBarangBaikAwl)));	
		
		$KondisiBarangKurangAwl = " AND f='".$isi['f']."' AND g='".$isi['g']."' AND h='".$isi['h']."' AND i='".$isi['i']."' AND j='".$isi['j']."' AND ref_idruang='".$isi['ref_idruang']."' AND kondisi ='2'";	
		$dtstKurangAwl = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], "", $KondisiBarangKurangAwl)));	
		
		$KondisiBarangRusakAwl = " AND f='".$isi['f']."' AND g='".$isi['g']."' AND h='".$isi['h']."' AND i='".$isi['i']."' AND j='".$isi['j']."' AND ref_idruang='".$isi['ref_idruang']."' AND  kondisi ='3'";	
		$dtstRusakAwl = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], "", $KondisiBarangRusakAwl)));													
		//==============================================================================================//
		
		//untuk set kondisi awal buuku induk
		switch($isi['kondisi']){
			case 1 : $kondisiawl="Baik"; break;
			case 2 : $kondisiawl="Kurang Baik"; break;
			case 3 : $kondisiawl="Rusak Berat"; break;
			default : $kondisiawl="-"; 						
		}
		//untuk set kondisi inventarisasi
		switch($dtInv['kondisi']){
			case 1 : $kondisi="Baik"; break;
			case 2 : $kondisi="Kurang Baik"; break;
			case 3 : $kondisi="Rusak Berat"; break;
			default : $kondisi="-"; 						
		}
		//untuk set ada/tidak inventarisasi
		switch($dtInv['ada']){
			case 1 : $Ada="Ada"; break;
			case 2 : $Ada="Tidak Ada"; break;
			default : $Ada="-"; 						
		}
		
		//==================================mengambil data gedung dan ruang==============================//
		$dtruang = mysql_fetch_array(mysql_query("select * from ref_ruang where id='".$isi['ref_idruang']."'"));
		$ruang= $dtruang['nm_ruang'];
		$dtgudang = mysql_fetch_array(mysql_query("select * from ref_ruang where concat(a1,a,b,c,d,e,e1,p,q)='".
				$dtruang['a1'].$dtruang['a'].$dtruang['b'].$dtruang['c'].$dtruang['d'].$dtruang['e'].$dtruang['e1'].$dtruang['p']."0000'"
			));
		$gedung= $dtgudang['nm_ruang'];	
		//==============================================================================================//		
		$jmlBaikAwl = empty($dtstBaikAwl['jml_bi']) ? "-" : $dtstBaikAwl['jml_bi'];
		$jmlKurangAwl = empty($dtstKurangAwl['jml_bi']) ? "-" : $dtstKurangAwl['jml_bi'];
		$jmlRusakAwl = empty($dtstRusakAwl['jml_bi']) ? "-" : $dtstRusakAwl['jml_bi'];
		$jmlAda = empty($dtstada['jml_bi']) ? "-" : $dtstada['jml_bi'];
		$jmlTidak = empty($dtstTidak['jml_bi']) ? "-" : $dtstTidak['jml_bi'];
		$jmlBaik = empty($dtstBaik['jml_bi']) ? "-" : $dtstBaik['jml_bi'];
		$jmlKurang = empty($dtstKurang['jml_bi']) ? "-" : $dtstKurang['jml_bi'];
		$jmlRusak = empty($dtstRusak['jml_bi']) ? "-" : $dtstRusak['jml_bi'];
		$colorjml = "#000000";
		if(($dtstada['jml_bi']+$dtstTidak['jml_bi'])<$isi['jml_bi'] || ($dtstBaik['jml_bi']+$dtstKurang['jml_bi']+$dtstRusak['jml_bi'])<$isi['jml_bi']){
			$status="Belum";
			$color="#ff0000";				
		}else{
			$status="Sudah";			
			$color="#0000ff";				
		}
		
		$tmpljmlAda = "<span id='ada_".$id."'><a href='javascript:InventarisRekap.ProsesCaribarang(\"".$id."\")' style='color:$colorjml;text-decoration:none;' title='Cari Barang'/><div style='height:100%;width:100%'>$jmlAda</div></a></span>"; 						
		$tmpljmlTidak = "<span id='tidak_".$id."'><a href='javascript:InventarisRekap.ProsesCaribarang(\"".$id."\")' style='color:$colorjml;text-decoration:none;' title='Cari Barang'/><div style='height:100%;width:100%'>$jmlTidak</div></a></span>";
		$tmpljmlBaik = "<span id='baik_".$id."'><a href='javascript:InventarisRekap.ProsesCaribarang(\"".$id."\")' style='color:$colorjml;text-decoration:none;' title='Cari Barang'/><div style='height:100%;width:100%'>$jmlBaik</div></a></span>";
		$tmpljmlKurang = "<span id='kurang_".$id."'><a href='javascript:InventarisRekap.ProsesCaribarang(\"".$id."\")' style='color:$colorjml;text-decoration:none;' title='Cari Barang'/><div style='height:100%;width:100%'>$jmlKurang</div></a></span>";
		$tmpljmlRusak = "<span id='rusak_".$id."'><a href='javascript:InventarisRekap.ProsesCaribarang(\"".$id."\")' style='color:$colorjml;text-decoration:none;' title='Cari Barang'/><div style='height:100%;width:100%'>$jmlRusak</div></a></span>";			
		$tmplstatus = "<span id='status_".$id."' title='Status'><a href='javascript:InventarisRekap.ProsesCaribarang(\"".$id."\")' style='color:$color;text-decoration:none;' title='Cari Barang'/><div style='height:100%;width:100%'>$status<input type='hidden' id='idplh_".$id."' name='idplh_".$id."' value='".$id."'></div></a></span>";
		
		if($jmlBaikAwl==$jmlBaik && $jmlKurangAwl==$jmlKurang && $jmlRusakAwl==$jmlRusak){
			$statusBI="<span id='statusbi_".$id."' title='Status'><img src='images/administrator/images/valid.png' width='20px' heigh='20px'></span>";	
		}else{
			$statusBI="<span id='statusbi_".$id."' title='Status'><img src='images/administrator/images/invalid.png' width='20px' heigh='20px'></span>";	
		}	

			
		$Koloms = array();
		$Koloms[] = array('align=right', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array('', $kode_brg);
		$Koloms[] = array('', $isi['nm_barang']);
		$Koloms[] = array('align=center', $gedung.' /<br> '.$ruang );
		$Koloms[] = array('align=center', $jmlBaikAwl );
		$Koloms[] = array('align=center', $jmlKurangAwl );				
		$Koloms[] = array('align=center', $jmlRusakAwl );
		$Koloms[] = array('align=center', $isi['jml_bi'] );
		$Koloms[] = array('align=center', $tmpljmlAda );
		$Koloms[] = array('align=center', $tmpljmlTidak );
		$Koloms[] = array('align=center', $tmpljmlBaik );
		$Koloms[] = array('align=center', $tmpljmlKurang );				
		$Koloms[] = array('align=center', $tmpljmlRusak );
		$Koloms[] = array('align=center', $tmplstatus );
		$Koloms[] = array('align=center', $statusBI );

		return $Koloms;
	}
	
	function prosesInventaris(){ 
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$mode=$_REQUEST['mode'];
		$id=explode("-",$_REQUEST['id']);
		$idplh=explode("-",$_REQUEST['idplh']);
					
		$thnskr=$HTTP_COOKIE_VARS['coThnAnggaran'];	
			
		//===================================get status ada dan tidak====================================//
		$Opsi = $this->getDaftarOpsi();		
		$KondisiBarangAll = " AND f='".$id[0]."' AND g='".$id[1]."' AND h='".$id[2]."' AND i='".$id[3]."' AND j='".$id[4]."' AND ref_idruang='".$id[5]."' ";
		$dtstall = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], $Opsi['Limit'], $KondisiBarangAll)));

		$KondisiBarangAda = " AND f='".$id[0]."' AND g='".$id[1]."' AND h='".$id[2]."' AND i='".$id[3]."' AND j='".$id[4]."' AND ref_idruang='".$id[5]."' AND id in (select idbi from inventaris WHERE ada ='1')";
		$dtstada = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], $Opsi['Limit'], $KondisiBarangAda)));
		
		$KondisiBarangTidakAda = " AND f='".$id[0]."' AND g='".$id[1]."' AND h='".$id[2]."' AND i='".$id[3]."' AND j='".$id[4]."' AND ref_idruang='".$id[5]."' AND id in (select idbi from inventaris WHERE ada ='2')";	
		$dtstTidak = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], $Opsi['Limit'], $KondisiBarangTidakAda)));					
		//==============================================================================================//
														
			//$content->ada="<input type='hidden' id='idbiplh' name='idbiplh' value='$idbi'>";			
			$content->tidak="<a href='javascript:InventarisRekap.ProsesCaribarang(\"".join("-",$id)."\")' title='Cari Barang'/><img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'></a>";			
			$content->status="<input type='hidden' id='idplh' name='idplh' value='".join("-",$id)."'>";			
			//mengembalikan element HTML menjadi menjadi seperti asalnya 
			if($idplh != 0){ 								
				//===================================get status ada dan tidak====================================//
				$Opsi = $this->getDaftarOpsi();		
				$KondisiBarangAll = " AND f='".$idplh[0]."' AND g='".$idplh[1]."' AND h='".$idplh[2]."' AND i='".$idplh[3]."' AND j='".$idplh[4]."' AND ref_idruang='".$idplh[5]."' ";
				$dtstall2 = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], $Opsi['Limit'], $KondisiBarangAll)));
		
				$KondisiBarangAda = " AND f='".$idplh[0]."' AND g='".$idplh[1]."' AND h='".$idplh[2]."' AND i='".$idplh[3]."' AND j='".$idplh[4]."' AND ref_idruang='".$idplh[5]."' AND id in (select idbi from inventaris WHERE ada ='1')";
				$dtstada2 = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], $Opsi['Limit'], $KondisiBarangAda)));
				
				$KondisiBarangTidakAda = " AND f='".$idplh[0]."' AND g='".$idplh[1]."' AND h='".$idplh[2]."' AND i='".$idplh[3]."' AND j='".$idplh[4]."' AND ref_idruang='".$idplh[5]."' AND id in (select idbi from inventaris WHERE ada ='2')";	
				$dtstTidak2 = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], $Opsi['Limit'], $KondisiBarangTidakAda)));					
				//==============================================================================================//
				
			$jmlTidak = empty($dtstTidak2['jml_bi']) ? "-" : $dtstTidak2['jml_bi'];
			
			//kondisi set inventaris
			if(($dtstada2['jml_bi']+$dtstTidak2['jml_bi'])<$dtstall2['jml_bi']){
				$tmplstatus="<a href='javascript:InventarisRekap.ProsesInventaris(\"$id\")' title='Baru'/>Belum</a>";			
			}else{
				$tmplstatus="<a href='javascript:InventarisRekap.ProsesInventaris(\"$id\")' style='color:#0000ff;'/>Sudah</a>";				
			}				
				$content->tidakawl=$jmlTidak;			
				$content->statusawl=$tmplstatus;				}
			//$content = $tmplInfo;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}	

	function updInventaris(){ 
		global $Main, $HTTP_COOKIE_VARS;
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$mode=$_REQUEST['mode'];
			$idbi=$_REQUEST['idbi'];
			$kondisi=$_REQUEST['plhKondisi'];
			$ada=$_REQUEST['plhAda'];			
			$thnskr=$HTTP_COOKIE_VARS['coThnAnggaran'];	
			$UID = $HTTP_COOKIE_VARS['coID'];					
			$tglskr=date("Y-m-d");	

			if($err=='' && $kondisi=='') $err = 'Kondisi belum dipilih!';
			if($err=='' && $ada=='') $err = 'Pilihan Ada/Tidak belum dipilih!';
								
			if($err==''){
				if($mode==1){ //baru
					$qry="INSERT INTO inventaris (tgl,idbi,kondisi,ada,tahun_sensus,uid,tgl_update) values ('$tglskr','$idbi','$kondisi','$ada','$thnskr','$uid',now())"; $cek.=$qry;
					$aqry = mysql_query($qry);
				}else{ //edit
					$qry = "UPDATE inventaris SET kondisi = '$kondisi', 
							ada = '$ada',
							tahun_sensus = '$thnskr',
							uid = '$uid',
							tgl_update = now() 
							WHERE idbi='$idbi'"; $cek.=$qry;
					$aqry = mysql_query($qry); 		
				}
				
				if($aqry){
					//get query Inventaris idbi seblmnya
					$queryInvawl="select * from inventaris where idbi='".$idbi."' and tahun_sensus='".$thnskr."'";
					$dtInvawl=mysql_fetch_array(mysql_query($queryInvawl));					
					switch($dtInvawl['kondisi']){
						case 1 : $kondisi="Baik"; break;
						case 2 : $kondisi="Kurang Baik"; break;
						case 3 : $kondisi="Rusak Berat"; break;
						default : $kondisi="-"; 						
					}
					switch($dtInvawl['ada']){
						case 1 : $Ada="Ada"; break;
						case 2 : $Ada="Tidak Ada"; break;
						default : $Ada="-"; 						
					}		
					
					if($dtInvawl){
						$content->kondisi="<a href='javascript:Inventaris.ProsesInventaris(2,".$idbi.")' />$kondisi</a>";
						$content->ada="<a href='javascript:Inventaris.ProsesInventaris(2,".$idbi.")' />$Ada</a>";
						$content->status="<a href='javascript:Inventaris.ProsesInventaris(2,".$idbi.")'  style='color:#0000ff;'/>Sudah</a>";				
						$content->tombol="<a href='javascript:Inventaris.ProsesInventaris(3,".$idbi.")' /><img src='datepicker/remove2.png' style='width:20px;height:20px;' /></a>";	
					}else{
						$content->kondisi="-";
						$content->ada="-";
						$content->status="<a href='javascript:Inventaris.ProsesInventaris(1,".$idbi.")' />Belum</a>";
						$content->tombol="";
					}
				}
			}	
			//$content = $tmplInfo;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}		

	function savePengaturan(){ 
		global $Main, $HTTP_COOKIE_VARS;
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$tgl_buku_inventaris=date('Y-m-d',strtotime($_REQUEST['tgl_buku_inventaris']));;
			$dtbarang=$_REQUEST['dtbarang'];
			$thnbuku1=$_REQUEST['thnbuku1'];
			$thnbuku2=$_REQUEST['thnbuku2'];			
			$staset=$_REQUEST['staset'];
			$metode=$_REQUEST['metode'];			
			$thnskr=$HTTP_COOKIE_VARS['coThnAnggaran'];					
			$uid = $HTTP_COOKIE_VARS['coID'];					
			$tglskr=date("Y-m-d");	
			$jmldtbarang=count($dtbarang);
			$jmldtbarang=count($dtbarang);
			
			//get data barang
			$valuedb=array();
			for($i=1;$i<=7;$i++){
				if(in_array($i,$dtbarang)){
					$valuedb[]=1;				
				}else{
					$valuedb[]=0;									
				}
			}
			$databarang= join(',',$valuedb);
			
			$dtstaset=array();
			foreach($staset as $valuestaset){
				$dtstaset[] = $valuestaset;
			}
			$datastaset = join(',',$dtstaset);

			//if($err=='' && $kondisi=='') $err = 'Kondisi belum dipilih!';
			 $querySetting = "select * from setting_inventaris WHERE thn_sensus='".$thnskr."'"; $cek.=$querySetting;
			 $get = mysql_fetch_array(mysql_query($querySetting));
			 $cntS=mysql_num_rows(mysql_query($querySetting));			 
								
			if($err==''){
				if($cntS>0){
					$qry = "UPDATE setting_inventaris 
							SET data_barang = '$databarang', 
							thn_buku1 = '$thnbuku1',
							thn_buku2 = '$thnbuku2',
							staset = '$datastaset',
							metode = '$metode',							
							uid = '$uid',
							tgl_update = now() 
							WHERE Id='".$get['Id']."'"; $cek.=$qry;
					$aqry = mysql_query($qry);											
				}else{
					$qry="INSERT INTO setting_inventaris (tgl_buku,data_barang,thn_buku1,thn_buku2,staset,metode,thn_sensus,uid,tgl_update) values ('$tgl_buku_inventaris','$databarang','$thnbuku1','$thnbuku2','$datastaset','$metode','$thnskr','$uid',now())"; $cek.=$qry;
					$aqry = mysql_query($qry);					
				}
			}	
			//$content = $tmplInfo;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}		


	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){	
			case 'prosesInventaris':{
				$get = $this->prosesInventaris();
				$err = $get['err'];
				$cek = $get['cek'];
				$content = $get['content'];				
				break;
			}			
			case 'updInventaris':{
				$get = $this->updInventaris();
				$err = $get['err'];
				$cek = $get['cek'];
				$content = $get['content'];				
				break;
			}
			case 'pilihRuang':{
				$fmPILGEDUNG = $_REQUEST['fmPILGEDUNG'];
				
				$arrkond = array();
				$arrkond = explode(' ',$fmPILGEDUNG);	
				$c1 = $arrkond[0];
				$c = $arrkond[1]; $d = $arrkond[2]; 
				$e = $arrkond[3];$e1 = $arrkond[4]; $p = $arrkond[5];
				
				$arrkond = array();
				$arrkond[] =  "q<>'0000'";
				$arrkond[] = " c1 = '$c1' ";
				$arrkond[] = " c = '$c' ";
				$arrkond[] = " d = '$d' ";
				$arrkond[] = " e = '$e' ";
				$arrkond[] = " e1 = '$e1' ";
				$arrkond[] = " p = '$p' ";
				$Kondisi = join(' and ',$arrkond);
				
				if($Kondisi != '') $Kondisi = ' where '.$Kondisi;
				$aqry = "select * from ref_ruang $Kondisi";
				$cek .= $aqry;
				$content = genComboBoxQry( 'fmPILRUANG', $fmPILRUANG, $aqry,
						'q', 'nm_ruang', '-- Semua Ruang --',"style=''  onChange=\"Penatausaha.refreshList(true);Penatausaha.tampilPJRuang();\" " );				
				break;
			}					
			case 'formPengaturani':{
				$fm = $this->SetFormPengaturan();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
				break;
			}
			case 'savePengaturan':{
				$get= $this->savePengaturan();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }			
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}

	function Batal($ids){ //validasi hapus ref_pegawai
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;

		if($err == ''){
			for($i = 0; $i<count($ids); $i++){

				//Batalkan SOTK Baru
				$batal = "UPDATE buku_induk set ".
				"c1 = '',".
				"c2 = '',".
				"d2 = '',".
				"e2 = '',".
				"e12 = '',".
				"no_ba2 = '',".
				"tgl_ba2 = NULL,".

				"sk_penggunaan = '',".
				"tanggal_sk_penggunaan = '',".
				"uid = '$UID',".
				"tgl_update = now() ".
				"WHERE id='".$ids[$i]."'";
				$cek.="| ".$batal;
				$qry = mysql_query($batal);

			}
		}

		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function SetFormPengaturan(){
	 global $SensusTmp, $Ref, $Main, $HTTP_COOKIE_VARS;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 600;
	 $this->form_height = 200;
	 $thnskr=$HTTP_COOKIE_VARS['coThnAnggaran'];			
 	 $tgl_buku_inventaris = "31-12-".$thnskr;	 

		$this->form_caption = 'PENGATURAN INVENTARIS / SENSUS';

  	$query = "" ;$cek .=$query;
  	$res = mysql_query($query);

	 $arrayStatus = array(
			array('YA','YA'),
			array('TIDAK','TIDAK'),
			);
	 
	 $querySetting = "select * from setting_inventaris order by thn_sensus,Id DESC limit 0,1"; 
	 $get = mysql_fetch_array(mysql_query($querySetting));
	 $cntS=mysql_num_rows(mysql_query($querySetting));
	
	//set checked data barang
	$dtbarang=explode(',',$get['data_barang']);
	$checkdb=array();
	if($cntS==0){
		for($i=0;$i<7;$i++){
			$checkdb[$i]="checked";	
		}	
	}else{
		for($i=0;$i<sizeof($dtbarang);$i++){
			if($dtbarang[$i]==1){
				$checkdb[$i]="checked";				
			}else{
				$checkdb[$i]="";				
			}
		}
	}

	//set checked staset
	$dtstaset=explode(',',$get['staset']);
	$checkstaset=array();
	for($i=0;$i<6;$i++){
		if($cntS==0){
			$checkstaset[$i]="checked";			
		}else{
			if(in_array(($i+1),$dtstaset)){
				$checkstaset[$i]="checked";				
			}else{
				$checkstaset[$i]="";				
			}			
		}
	}

	//set checked metode
	$checkmetode=array();
	if($cntS==0){
		$checkmetode[0]="checked";			
	}else{
		for($i=0;$i<3;$i++){
			if($get['metode']==($i+1)){
				$checkmetode[$i]="checked";				
			}else{
				$checkmetode[$i]="";
			}			
		}	
	}				
	
	 $cmbStatusSK = cmbArray('sk_penggunaan',$sk_penggunaan,$arrayStatus,'-- STATUS --',"");
	 $databarang = "<input type='checkbox' name='dtbarang[]' value='1' ".$checkdb[0]."> KIB A
					 <input type='checkbox' name='dtbarang[]' value='2' ".$checkdb[1]."> KIB B
					 <input type='checkbox' name='dtbarang[]' value='3' ".$checkdb[2]."> KIB C
					 <input type='checkbox' name='dtbarang[]' value='4' ".$checkdb[3]."> KIB D
					 <input type='checkbox' name='dtbarang[]' value='5' ".$checkdb[4]."> KIB E
					 <input type='checkbox' name='dtbarang[]' value='6' ".$checkdb[5]."> KIB F
					 <input type='checkbox' name='dtbarang[]' value='7' ".$checkdb[6]."> KIB G";
	$qrythnbuku = "SELECT year(tgl_buku) as thn_buku, year(tgl_buku) as thn_buku from buku_induk group by year(tgl_buku)";
	$dtthnbuku=cmbQuery('thnbuku1',$get['thn_buku1'],$qrythnbuku,"","--- PILIH ---")." s/d ".	cmbQuery('thnbuku2',$get['thn_buku2'],$qrythnbuku,"","--- PILIH ---");
	 $datastaset = "<input type='checkbox' name='staset[]' value='1' ".$checkstaset[0]."> Intra
				 <input type='checkbox' name='staset[]' value='2' ".$checkstaset[1]."> Ekstra
				 <input type='checkbox' name='staset[]' value='3' ".$checkstaset[2]."> Aset Lain-lain 
				 <input type='checkbox' name='staset[]' value='4' ".$checkstaset[3]."> Pemanfaatan <br>
				 <input type='checkbox' name='staset[]' value='5' ".$checkstaset[4]."> Pemindahtanganan
				 <input type='checkbox' name='staset[]' value='6' ".$checkstaset[5]."> Pemusnahan";
	 $datametode = "<input type='radio' name='metode' value='1' ".$checkmetode[0]."> REGISTER
					 <input type='radio' name='metode' value='2' ".$checkmetode[1]."> REKAP
					 <input type='radio' name='metode' value='3' ".$checkmetode[2]."> BARCODE";			 
	 //items ----------------------
	  $this->form_fields = array(
			'tgl_buku_inventaris' => array('label'=>'TGL BUKU INVENTARIS',
							   'value'=> "<input type='text' name='tgl_buku_inventaris' id='tgl_buku_inventaris' value='$tgl_buku_inventaris' readonly>",
							   'type'=>'' ,
							   'param'=> "",
							 ),
			'data_barang' => array(
						'label'=>'DATA BARANG',
						'labelWidth'=>150,
						'value'=>$databarang,
						 ),
			'periode_thn_buku' => array(
						'label'=>'TAHUN BUKU',
						'labelWidth'=>150,
						'value'=>$dtthnbuku,
						 ),

			'status_aset' => array(
						'label'=>'STATUS ASET',
						'labelWidth'=>150,
						'value'=>$datastaset,
						'row_params'=>"valign='top'",
						 ),				 
			'metode' => array(
						'label'=>'METODE',
						'labelWidth'=>150,
						'value'=>$datametode,
						'row_params'=>"valign='top'",
						 ),

			);
		//tombol
		$this->form_menubawah =

			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".savePengaturan()' title='Simpan' >&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


}

$InventarisRekap = new InventarisRekapObj();
//$SOTKBaru->username = $_COOKIE['coID'];

?>
