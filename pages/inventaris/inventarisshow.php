<?php

class InventarisShowObj extends DaftarObj2{
	var $Prefix = 'InventarisShow';
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_buku_induk2';//view2_sensus';
	var $TblName_Hapus = 'buku_induk';
	var $TblName_Edit = 'buku_induk';
	var $KeyFields = array('id');
	var $FieldSum = array();
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 9, 8, 8);
	var $FieldSum_Cp2 = array( 3, 3, 3);
	var $checkbox_rowspan = 2;
	var $FormName = 'InventarisShowForm';
	var $pagePerHal = '';
	//var $withSumAll = FALSE;
	//var $withSumHal = FALSE;
	//var $WITH_HAL = FALSE;
	var $PageTitle = 'Inventarisasi';
	var $PageIcon = 'images/penatausahaan_ico.gif';
	var $ico_width = '20';
	var $ico_height = '30';
	var $fileNameExcel='Inventarisasi.xls';
	var $Cetak_Judul = 'Inventarisasi';
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
		return 'Inventarisasi';

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
					"<input type='hidden' name='tgl_cek' id='tgl_cek' value='$tgl_cek'>
".
					"</div>".
					//"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>".					
					"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> ".
					"Gedung &nbsp; ".						
						"<span id='cbxGedung'>".
						genComboBoxQry2( 'fmPILGEDUNG', $fmPILGEDUNG, 
							"select c1,c,d,e,e1,p, concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',p,' ',nm_ruang) as nm_gedung from ref_ruang $Kondisigdg order by c1,c,d,e,e1,p,q ",
							array('c1','c','d','e','e1','p'), 'nm_gedung', '-- Semua Gedung --',"onChange=\"InventarisShow.pilihGedungOnchange()\"" ).
						"</span>".
					"</div>".
					"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>
					<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> ".
					"Ruang &nbsp".
						"<span id='cbxRuang'>".
						genComboBoxQry( 'fmPILRUANG', $fmPILRUANG, 
							"select * from ref_ruang  $KondisiRuang  order by c1,c,d,e,e1,p,q",
							'q', 'nm_ruang', '-- Semua Ruang --',"style='' onChange=\"InventarisShow.refreshList(true);InventarisShow.tampilPJRuang();\" "  ).
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
		
		if($cmbStatus==1){
			if(!empty($cmbStatus)) $arrKondisi[] = " id not in (select idbi from inventaris) ";
		}else{
			if(!empty($cmbStatus)) $arrKondisi[] = " id in (select idbi from inventaris) ";
		}		

		if(!empty($fmTahunBuku)) $arrKondisi[] = " year(tgl_buku) = '$fmTahunBuku' ";

		if(!empty($fmPILRUANG)){
			if(!empty($fmPILRUANG)) $arrKondisi[] = " ref_idruang in (select id from ref_ruang WHERE c1='".$kg[0]."' and c='".$kg[1]."' and d='".$kg[2]."' and e='".$kg[3]."' and e1='".$kg[4]."' and p='".$kg[5]."' and q='".$fmPILRUANG."') ";
		}else{
			if(!empty($fmPILGEDUNG)) $arrKondisi[] = " ref_idruang in (select id from ref_ruang WHERE c1='".$kg[0]."' and c='".$kg[1]."' and d='".$kg[2]."' and e='".$kg[3]."' and e1='".$kg[4]."' and p='".$kg[5]."') ";
		}
		
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
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

	function genDaftarInitial($fmId){
		$vOpsi = $this->genDaftarOpsi();
		$Id=explode("-",$fmId);
		$kdbarang=$fmId==""?"":$Id[0].".".$Id[1].".".$Id[2].".".$Id[3].".".$Id[4];
		if($Id[5]!=0){
			$c1R=substr($Id[5],1,1);
			$cR=substr($Id[5],2,2);
			$dR=substr($Id[5],4,2);
			$eR=substr($Id[5],6,2);
			$e1R=substr($Id[5],8,3);
			$pR=substr($Id[5],11,3);						
			$qR=substr($Id[5],14,4);
			$idgedung=$c1R." ".$cR." ".$dR." ".$eR." ".$e1R." ".$pR;
			$idruang=$qR;
			$hiddenruang="<input type='hidden' id='fmPILGEDUNG' name='fmPILGEDUNG' value='$idgedung'>".
						 "<input type='hidden' id='fmPILRUANG' name='fmPILRUANG' value='$idruang'>";				
		}else{
			$idgedung="";
			$idruang="";			
			$hiddenruang="";
		}
		
		return
			//"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>".
				"<input type='hidden' id='kdbarang' name='kdbarang' value='$kdbarang'>".
				$hiddenruang.		
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
				<script type='text/javascript' src='js/inventaris/inventarisrekap.js' language='JavaScript' ></script>				
				".'<link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>'.				
						$scriptload;
	}

	function setKolomHeader($Mode=1, $Checkbox='2'){
		$cetak = $Mode==2 || $Mode==3 ;


		$headerTable =
				"<tr>
				<th class='th01' width='20' rowspan=2>No.</th>
				$Checkbox
				<th class='th02'colspan=2>Nomor</th>
				<th class='th02'colspan=3>Spesifikasi Barang</th>
				<!--<th class='th01'rowspan=2>Bahan</th>
				<th class='th01'rowspan=2>Cara Perolehan/<br>Sumber Dana</th>-->
				<th class='th01'rowspan=2>Tahun <br> Perolehan</th>
				<th class='th01'rowspan=2>Gedung / <br> Ruang</th>
				<th class='th01'rowspan=2>Kondisi <br> (B,KB,RB)</th>
				<th class='th02'colspan=4>Inventarisasi</th>
				</tr>

				<tr>
				<th class='th01'>Kode Barang/ <br> ID Barang</th>
				<th class='th01'>Reg</th>
				<th class='th01'>Nama/ Jenis Barang</th>
				<th class='th01'>Merk/ Type/ Lokasi</th>
				<th class='th01'>No. Sertifikat/ <br>No. Polisi</th>
				<th class='th01' style='min-width:75px;'>Kondisi</th>
				<th class='th01' style='min-width:75px;'>Ada / Tidak</th>
				<th class='th01' style='min-width:75px;'>Status</th>
				<th class='th01' style='min-width:50px;'></th>
				</tr>

				";

		return $headerTable;
	}


	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref,$HTTP_COOKIE_VARS;
		$arrStatus = array ('','','', 'Batal','Dihapus');
		$thnskr=$HTTP_COOKIE_VARS['coThnAnggaran'];

		$kode_brg = $isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'];
		$kode_sotk = $isi['c1']==''? '' : $isi['c1'].'.'.$isi['c2'].'.'.$isi['d2'].'.'.$isi['e2'].'.'.$isi['e12'];

		$qry = "select nm_skpd from ref_skpd_baru where c1='".$isi['c1']."' and c2='00'";
		$get = mysql_fetch_array(mysql_query($qry));
		$urusan = $get['nm_skpd'];

		$qry = "select nm_skpd from ref_skpd_baru where c1='".$isi['c1']."' and c2='".$isi['c2']."' and d2='00'";
		$get = mysql_fetch_array(mysql_query($qry));
		$bidang2 = $get['nm_skpd'];

		$qry = "select nm_skpd from ref_skpd_baru where c1='".$isi['c1']."' and c2='".$isi['c2']."' and d2='".$isi['d2']."' and e2='00'";
		$get = mysql_fetch_array(mysql_query($qry));
		$skpd2 = $get['nm_skpd'];

		$qry = "select nm_skpd from ref_skpd_baru where c1='".$isi['c1']."' and c2='".$isi['c2']."' and d2='".$isi['d2']."' and e2='".$isi['e2']."' and e12='000'";
		$get = mysql_fetch_array(mysql_query($qry));
		$unit2 = $get['nm_skpd'];

		$qry = "select nm_skpd from ref_skpd_baru where c1='".$isi['c1']."' and c2='".$isi['c2']."' and d2='".$isi['d2']."' and e2='".$isi['e2']."' and e12='".$isi['e12']."'";
		$get = mysql_fetch_array(mysql_query($qry));
		$subunit2 = $get['nm_skpd'];

		$sotkbaru = $isi['c1']==''? '' : $kode_sotk.'/<br>'.$urusan.' - <br>'.$bidang2.' - <br>'.$skpd2.' - <br>'.$unit2.' - <br>'.$subunit2;
		$bastbaru = $isi['no_ba2']==''? '' : $isi['no_ba2'].'/<br>'.$isi['tgl_ba2'];

		//--- ambil data kib by noreg --------------------------------
		if ($isi['f'] == "01" || $isi['f'] == "02" || $isi['f'] == "03" || $isi['f'] == "04" || $isi['f'] == "05" || $isi['f'] == "06" || $isi['f'] == "07") {
			$KondisiKIB = "
			where
			a1= '{$isi['a1']}' and
			a = '{$isi['a']}' and
			b = '{$isi['b']}' and
			c = '{$isi['c']}' and
			d = '{$isi['d']}' and
			e = '{$isi['e']}' and
			e1 = '{$isi['e1']}' and
			f = '{$isi['f']}' and
			g = '{$isi['g']}' and
			h = '{$isi['h']}' and
			i = '{$isi['i']}' and
			j = '{$isi['j']}' and
			noreg = '{$isi['noreg']}' and
			tahun = '{$isi['tahun']}' ";
		}
		if ($isi['f'] == "01") {//KIB A
			//"concat(a1,a,b,c,d,e,f,g,h,i,j,noreg,tahun)='{$isi['a1']}{$isi['a']}{$isi['b']}{$isi['c']}{$isi['d']}{$isi['e']}{$isi['f']}{$isi['g']}{$isi['h']}{$isi['i']}{$isi['j']}{$isi['noreg']}{$isi['tahun']}'
			$QryKIB_A = mysql_query("select * from kib_a  $KondisiKIB  limit 0,1");
			while ($isiKIB_A = mysql_fetch_array($QryKIB_A)) {
				$isiKIB_A = array_map('utf8_encode', $isiKIB_A);

				//if($SPg == 'belumsensus'){
					$alm = '';
					$alm .= ifempty($isiKIB_A['alamat'],'-');
					$alm .= ($isi['rt'] && $isi['rw']) == ''? '' : '<br>RT/RW. '.$isi['rt'].'/'.$isi['rw'];
					$alm .= $isi['kampung'] == ''? '' : '<br>Kp/Komp. '.$isi['kampung'];
					$alm .= $isiKIB_A['alamat_kel'] != ''? '<br>Kel/Desa. '.$isiKIB_A['alamat_kel'] : '';
					$alm .= $isiKIB_A['alamat_kec'] != ''? '<br>Kec. '.$isiKIB_A['alamat_kec'] : '';
					$alm .= $isiKIB_A['alamat_kota'] != ''? '<br>'.$isiKIB_A['alamat_kota'] : '';
					$ISI5 = $alm;
				//}else{
				//	$ISI5 = '';
				//}
				$ISI6 = "{$isiKIB_A['sertifikat_no']}";  //$ISI10 = "{$isiKIB_A['luas']}";
				$ISI15 = "{$isiKIB_A['ket']}";
				$ISI10 = number_format($isiKIB_A['luas'],2,',','.');
			}
		}
		if ($isi['f'] == "02") {//KIB B;
			//"concat(a1,a,b,c,d,e,f,g,h,i,j,noreg,tahun)='{$isi['a1']}{$isi['a']}{$isi['b']}{$isi['c']}{$isi['d']}{$isi['e']}{$isi['f']}{$isi['g']}{$isi['h']}{$isi['i']}{$isi['j']}{$isi['noreg']}{$isi['tahun']}'";
			$QryKIB_B = mysql_query("select * from kib_b  $KondisiKIB limit 0,1");
			while ($isiKIB_B = mysql_fetch_array($QryKIB_B)) {
				$isiKIB_B = array_map('utf8_encode', $isiKIB_B);
				$ISI5 = "{$isiKIB_B['merk']}";
				$ISI6 = "{$isiKIB_B['no_pabrik']} /<br> {$isiKIB_B['no_rangka']} /<br> {$isiKIB_B['no_mesin']} /<br> {$isiKIB_B['no_polisi']}";
				$ISI7 = "{$isiKIB_B['bahan']}";
				$ISI15 = "{$isiKIB_B['ket']}";
			}
		}
		if ($isi['f'] == "03") {//KIB C;
			$QryKIB_C = mysql_query("select * from kib_c  $KondisiKIB limit 0,1");
			while ($isiKIB_C = mysql_fetch_array($QryKIB_C)) {
				$isiKIB_C = array_map('utf8_encode', $isiKIB_C);
				//if($SPg == 'belumsensus'){
					$alm = '';
					$alm .= ifempty($isiKIB_C['alamat'],'-');
					$alm .= ($isi['rt'] && $isi['rw']) == ''? '' : '<br>RT/RW. '.$isi['rt'].'/'.$isi['rw'];
					$alm .= $isi['kampung'] == ''? '' : '<br>Kp/Komp. '.$isi['kampung'];
					$alm .= $isiKIB_C['alamat_kel'] != ''? '<br>Kel/Desa. '.$isiKIB_C['alamat_kel'] : '';
					$alm .= $isiKIB_C['alamat_kec'] != ''? '<br>Kec. '.$isiKIB_C['alamat_kec'] : '';
					$alm .= $isiKIB_C['alamat_kota'] != ''? '<br>'.$isiKIB_C['alamat_kota'] : '';
					$ISI5 = $alm;
				//}else{
				//	$ISI5 = '';
				//}
				$ISI6 = "{$isiKIB_C['dokumen_no']}";
				$ISI10 = $Main->Bangunan[$isiKIB_C['kondisi_bangunan'] - 1][1];
				$ISI15 = "{$isiKIB_C['ket']}";
			}
		}
		if ($isi['f'] == "04") {//KIB D;
			$QryKIB_D = mysql_query("select * from kib_d  $KondisiKIB limit 0,1");
			while ($isiKIB_D = mysql_fetch_array($QryKIB_D)) {
				$isiKIB_D = array_map('utf8_encode', $isiKIB_D);
				//if($SPg == 'belumsensus'){
					$alm = '';
					$alm .= ifempty($isiKIB_D['alamat'],'-');
					$alm .= ($isi['rt'] && $isi['rw']) == ''? '' : '<br>RT/RW. '.$isi['rt'].'/'.$isi['rw'];
					$alm .= $isi['kampung'] == ''? '' : '<br>Kp/Komp. '.$isi['kampung'];
					$alm .= $isiKIB_D['alamat_kel'] != ''? '<br>Kel/Desa. '.$isiKIB_D['alamat_kel'] : '';
					$alm .= $isiKIB_D['alamat_kec'] != ''? '<br>Kec. '.$isiKIB_D['alamat_kec'] : '';
					$alm .= $isiKIB_D['alamat_kota'] != ''? '<br>'.$isiKIB_D['alamat_kota'] : '';
					$ISI5 = $alm;
				//}else{
				//	$ISI5 = '';
				//}
				$ISI6 = "{$isiKIB_D['dokumen_no']}";
				$ISI15 = "{$isiKIB_D['ket']}";
			}
		}
		if ($isi['f'] == "05") {//KIB E;
			$QryKIB_E = mysql_query("select * from kib_e  $KondisiKIB limit 0,1");
			while ($isiKIB_E = mysql_fetch_array($QryKIB_E)) {
				$isiKIB_E = array_map('utf8_encode', $isiKIB_E);
				$ISI7 = "{$isiKIB_E['seni_bahan']}";
				$ISI15 = "{$isiKIB_E['ket']}";
			}
		}
		if ($isi['f'] == "06") {//KIB F;
			$sQryKIB_F = "select * from kib_f  $KondisiKIB limit 0,1";
			$QryKIB_F = mysql_query($sQryKIB_F);
			//echo "<br>qrykibf= $sQryKIB_F";
			while ($isiKIB_F = mysql_fetch_array($QryKIB_F)) {
				$isiKIB_F = array_map('utf8_encode', $isiKIB_F);
				//if($SPg == 'belumsensus'){
					$alm = '';
					$alm .= ifempty($isiKIB_F['alamat'],'-');
					$alm .= ($isi['rt'] && $isi['rw']) == ''? '' : '<br>RT/RW. '.$isi['rt'].'/'.$isi['rw'];
					$alm .= $isi['kampung'] == ''? '' : '<br>Kp/Komp. '.$isi['kampung'];
					$alm .= $isiKIB_F['alamat_kel'] != ''? '<br>Kel/Desa. '.$isiKIB_F['alamat_kel'] : '';
					$alm .= $isiKIB_F['alamat_kec'] != ''? '<br>Kec. '.$isiKIB_F['alamat_kec'] : '';
					$alm .= $isiKIB_F['alamat_kota'] != ''? '<br>'.$isiKIB_F['alamat_kota'] : '';
					$ISI5 = $alm;
				//}else{
				//	$ISI5 = '';
				//}
				$ISI6 = "{$isiKIB_F['dokumen_no']}";
				$ISI10 = $Main->Bangunan[$isiKIB_F['bangunan'] - 1][1];
				$ISI15 = "{$isiKIB_F['ket']}";
			}
		}
		if ($isi['f'] == "07") {//KIB E;
			$QryKIB_E = mysql_query("select * from kib_g  $KondisiKIB limit 0,1");
			while ($isiKIB_E = mysql_fetch_array($QryKIB_E)) {
				$isiKIB_E = array_map('utf8_encode', $isiKIB_E);
				$ISI7 = "{$isiKIB_E['pencipta']}";
//							$ISI7 = "{$isiKIB_E['jenis']}";
				$ISI15 = "{$isiKIB_E['ket']}";
			}
		}
		$queryInv="select * from inventaris where idbi='".$isi['id']."' and tahun_sensus='".$thnskr."'";
		$dtInv=mysql_fetch_array(mysql_query($queryInv));
		
		//switch untuk kondisi awal buuku induk
		switch($isi['kondisi']){
			case 1 : $kondisiawl="Baik"; break;
			case 2 : $kondisiawl="Kurang Baik"; break;
			case 3 : $kondisiawl="Rusak Berat"; break;
			default : $kondisiawl="-"; 						
		}
		//switch untuk kondisi inventarisasi
		switch($dtInv['kondisi']){
			case 1 : $kondisi="Baik"; break;
			case 2 : $kondisi="Kurang Baik"; break;
			case 3 : $kondisi="Rusak Berat"; break;
			default : $kondisi="-"; 						
		}
		//switch untuk ada/tidak inventarisasi
		switch($dtInv['ada']){
			case 1 : $Ada="Ada"; break;
			case 2 : $Ada="Tidak Ada"; break;
			default : $Ada="-"; 						
		}
		
		$dtruang = mysql_fetch_array(mysql_query("select * from ref_ruang where id='".$isi['ref_idruang']."'"));
		$ruang= $dtruang['nm_ruang'];
		$dtgudang = mysql_fetch_array(mysql_query("select * from ref_ruang where concat(a1,a,b,c,d,e,e1,p,q)='".
				$dtruang['a1'].$dtruang['a'].$dtruang['b'].$dtruang['c'].$dtruang['d'].$dtruang['e'].$dtruang['e1'].$dtruang['p']."0000'"
			));
		$gedung= $dtgudang['nm_ruang'];	
		
		if($dtInv){
			$tmplKondisi="<span id='kondisi_".$isi['id']."'><a href='javascript:InventarisShow.ProsesInventaris(2,".$isi['id'].")' />$kondisi</a></span>";
			$tmplAda="<span id='ada_".$isi['id']."'><a href='javascript:InventarisShow.ProsesInventaris(2,".$isi['id'].")' />$Ada</a></span>";
			$tmplstatus="<span id='status_".$isi['id']."'><a href='javascript:InventarisShow.ProsesInventaris(2,".$isi['id'].")' style='color:#0000ff;'/>Sudah</a></span>";				
			$tmpltombol="<span id='tombol_".$isi['id']."'><a href='javascript:InventarisShow.ProsesInventaris(3,".$isi['id'].")' /><img src='datepicker/remove2.png' title='Hapus' style='width:20px;height:20px;' /></a></span>";	
		}else{
			$tmplKondisi="<span id='kondisi_".$isi['id']."'><a href='javascript:InventarisShow.ProsesInventaris(1,".$isi['id'].")' title='Baru'/>-</a></span>";
			$tmplAda="<span id='ada_".$isi['id']."'><a href='javascript:InventarisShow.ProsesInventaris(1,".$isi['id'].")' title='Baru'/>-</a></span>";
			$tmplstatus="<span id='status_".$isi['id']."'><a href='javascript:InventarisShow.ProsesInventaris(1,".$isi['id'].")' title='Baru'/>Belum</a></span>";
			$tmpltombol="<span id='tombol_".$isi['id']."'></span>";
		}
		
		$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['nilai_buku']/1000, 2, ',', '.') : number_format($isi['nilai_buku'], 2, ',', '.');
		$tampilAkumSusut = !empty($cbxDlmRibu)? number_format($isi['nilai_susut']/1000, 2, ',', '.') : number_format($isi['nilai_susut'], 2, ',', '.');
		$jns_hibah = $isi['jns_hibah'] == 0?'':$isi['jns_hibah'];
		$Koloms = array();
		$Koloms[] = array('align=right', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array('', $kode_brg.'/<br>'.$isi['id']);
		$Koloms[] = array('', $isi['noreg']);
		$Koloms[] = array('', $isi['nm_barang']);

		$Koloms[] = array('', $ISI5 );
		$Koloms[] = array('', $ISI6 );
		//$Koloms[] = array('', $ISI7 );
		//$Koloms[] = array('', $Main->AsalUsul[$isi['asal_usul']-1][1]."<br>/".$jns_hibah."<br>/".$Main->StatusBarang[$isi['status_barang']-1][1] );
		$Koloms[] = array('align=center', $isi['thn_perolehan'] );
		$Koloms[] = array('align=center', $gedung.' /<br> '.$ruang );
		$Koloms[] = array('align=center', $kondisiawl );
		$Koloms[] = array('align=center', $tmplKondisi );
		$Koloms[] = array('align=center', $tmplAda );
		$Koloms[] = array('align=center', $tmplstatus );
		$Koloms[] = array('align=center', $tmpltombol );

		return $Koloms;
	}
	
	function prosesInventaris(){ 
		global $Main, $HTTP_COOKIE_VARS;
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$mode=$_REQUEST['mode'];
			$idbi=$_REQUEST['idbi'];
			$idbiplh=$_REQUEST['idbiplh'];			
			$thnskr=$HTTP_COOKIE_VARS['coThnAnggaran'];			
			$ArrKondisi = array(
							array('1', 'Baik'),
							array('2', 'Kurang Baik'),
							array('3', 'Rusak Berat')
								);
			$ArrAda = array(
							array('1', 'Ada'),
							array('2', 'Tidak Ada'),
								);
								
			//get query Inventaris idbi dipilih
			$queryInv="select * from inventaris where idbi='".$idbi."' and tahun_sensus='".$thnskr."'";
			$dtInv=mysql_fetch_array(mysql_query($queryInv));			

			//get query buku induk idbi dipilih
			$queryBI="select * from buku_induk where id='".$idbi."'";
			$dtBI=mysql_fetch_array(mysql_query($queryBI));	
								
			if($mode==1){ //baru
				$content->kondisi=cmbArray('plhKondisi',$dtBI['kondisi'],$ArrKondisi,'- Pilih -','');
				$content->ada=cmbArray('plhAda',1,$ArrAda,'- Pilih -','');
				$content->status="Belum";
				$content->tombol="<a href='javascript:InventarisShow.Updinventaris(1,$idbi)' />
									<img src='datepicker/save.png' title='Simpan' style='width:20px;height:20px;' />
								</a>
								<a href='javascript:InventarisShow.ProsesInventaris(4,$idbi)' />
									<img src='datepicker/remove2.png' title='Batal' style='width:20px;height:20px;' />
								</a>
								<input type='hidden' id='idbiplh' name='idbiplh' value='$idbi'>";	
			}elseif($mode==2){ //edit
				$content->kondisi=cmbArray('plhKondisi',$dtInv['kondisi'],$ArrKondisi,'- Pilih -','');
				$content->ada=cmbArray('plhAda',$dtInv['ada'],$ArrAda,'- Pilih -','');
				$content->status="Sudah";
				$content->tombol="<a href='javascript:InventarisShow.Updinventaris(2,$idbi)' />
									<img src='datepicker/save.png' title='Simpan' style='width:20px;height:20px;' />
								</a>
								<a href='javascript:InventarisShow.ProsesInventaris(4,$idbi)' />
									<img src='datepicker/remove2.png' title='Batal' style='width:20px;height:20px;' />
								</a>								
								<input type='hidden' id='idbiplh' name='idbiplh' value='$idbi'>";	
			}elseif($mode==3){ //hapus
				$qrydel = "DELETE FROM inventaris where idbi='".$idbi."' and tahun_sensus='".$thnskr."'"; $cek.=$qrydel;
				$aqrydel = mysql_query($qrydel);			
				$content->kondisi="<a href='javascript:InventarisShow.ProsesInventaris(1,".$idbi.")' />-</a>";
				$content->ada="<a href='javascript:InventarisShow.ProsesInventaris(1,".$idbi.")' />-</a>";
				$content->status="<a href='javascript:InventarisShow.ProsesInventaris(1,".$idbi.")' />Belum</a>";
				$content->tombol="<input type='hidden' id='idbiplh' name='idbiplh' value='$idbi'>";						
			}else{ //batal		
				$content->kondisi="<a href='javascript:InventarisShow.ProsesInventaris(1,".$idbi.")' />-</a>";
				$content->ada="<a href='javascript:InventarisShow.ProsesInventaris(1,".$idbi.")' />-</a>";
				$content->status="<a href='javascript:InventarisShow.ProsesInventaris(1,".$idbi.")' />Belum</a>";
				$content->tombol="<input type='hidden' id='idbiplh' name='idbiplh' value='$idbi'>";	
			}
			
			//mengembalikan element HTML menjadi menjadi seperti asalnya 
			if($idbiplh != 0){ 
				//get query Inventaris idbi seblmnya
				$queryInvawl="select * from inventaris where idbi='".$idbiplh."' and tahun_sensus='".$thnskr."'";
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
					$content->kondisiawl="<a href='javascript:InventarisShow.ProsesInventaris(2,".$idbiplh.")' />$kondisi</a>";
					$content->adaawl="<a href='javascript:InventarisShow.ProsesInventaris(2,".$idbiplh.")' />$Ada</a>";
					$content->statusawl="<a href='javascript:InventarisShow.ProsesInventaris(2,".$idbiplh.")'  style='color:#0000ff;'/>Sudah</a>";				
					$content->tombolawl="<a href='javascript:InventarisShow.ProsesInventaris(3,".$idbiplh.")' /><img src='datepicker/remove2.png' style='width:20px;height:20px;' /></a>";	
				}else{
					$content->kondisiawl="<a href='javascript:InventarisShow.ProsesInventaris(1,".$idbiplh.")' />-</a>";
					$content->adaawl="<a href='javascript:InventarisShow.ProsesInventaris(1,".$idbiplh.")' />-</a>";
					$content->statusawl="<a href='javascript:InventarisShow.ProsesInventaris(1,".$idbiplh.")' />Belum</a>";
					$content->tombolawl="";
				}
			}
			//$content = $tmplInfo;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}	

	function updInventaris(){ 
		global $Main, $HTTP_COOKIE_VARS;
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$mode=$_REQUEST['mode'];
			$idbi=$_REQUEST['idbi'];
			$kondisi=$_REQUEST['plhKondisi'];
			$tgl_cek=date('Y-m-d',strtotime($_REQUEST['tgl_cek']));;
			$ada=$_REQUEST['plhAda'];
			//$tgl_cek=$_REQUEST['tgl_cek'];						
			$thnskr=$HTTP_COOKIE_VARS['coThnAnggaran'];	
			$UID = $HTTP_COOKIE_VARS['coID'];					
			//$tglskr=date("Y-m-d");	

			if($err=='' && $kondisi=='') $err = 'Kondisi belum dipilih!';
			if($err=='' && $ada=='') $err = 'Pilihan Ada/Tidak belum dipilih!';
								
			if($err==''){
				if($mode==1){ //baru
					$qry="INSERT INTO inventaris (tgl,idbi,kondisi,ada,tahun_sensus,uid,tgl_update) values ('$tgl_cek','$idbi','$kondisi','$ada','$thnskr','$uid',now())"; $cek.=$qry;
					$aqry = mysql_query($qry);
				}else{ //edit
					$qry = "UPDATE inventaris SET tgl ='$tgl_cek',  
							kondisi = '$kondisi', 
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
						$content->kondisi="<a href='javascript:Inventaris.ProsesInventaris(1,".$idbi.")' />-</a>";
						$content->ada="<a href='javascript:Inventaris.ProsesInventaris(1,".$idbi.")' />-</a>";
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
			//if($err=='' && $ada=='') $err = 'Pilihan Ada/Tidak belum dipilih!';
								
			if($err==''){
					$qry="INSERT INTO setting_inventaris (tgl_buku,data_barang,thn_buku1,thn_buku2,staset,metode,thn_sensus,uid,tgl_update) values ('$tgl_buku_inventaris','$databarang','$thnbuku1','$thnbuku2','$datastaset','$metode','$thnskr','$uid',now())"; $cek.=$qry;
					$aqry = mysql_query($qry);
			}	
			//$content = $tmplInfo;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}		

	function getData(){ 
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$Opsi = $this->getDaftarOpsi();	
		$id=$_REQUEST['id'];			
		$ID = explode("-",$_REQUEST['id']);
		$tglskr=date("Y-m-d");
		$thnskr=$HTTP_COOKIE_VARS['coThnAnggaran'];								

		//pengecekan data yg belum di edit
		$query = "select * from $this->TblName ".$Opsi['Kondisi']." AND f='".$ID[0]."' AND g='".$ID[1]."' AND h='".$ID[2]."' AND i='".$ID[3]."' AND j='".$ID[4]."' AND ref_idruang='".$ID[5]."' "; //$cek.=$query."<br>";
		$aqry=mysql_query($query);
		while($row=mysql_fetch_array($aqry)){
			$queryInventaris="select * from inventaris WHERE idbi='".$row['id']."'";
			$cntI=mysql_num_rows(mysql_query($queryInventaris));
			$dtI=mysql_fetch_array(mysql_query($queryInventaris));
			if($cntI==0){ //input ke inventaris jika belum ada di inventaris
				$qry="INSERT INTO inventaris (tgl,idbi,ada,kondisi,tahun_sensus,uid,tgl_update) values ('$tglskr','".$row['id']."','1','".$row['kondisi']."','$thnskr','$uid',now())"; //$cek.=$qry."<br>";
				mysql_query($qry);						
			}else{
				//$cek.="kondisi".$dtI['kondisi']."<br>";
				if(empty($dtI['kondisi'])){
					$qry="Update inventaris set kondisi='".$row['kondisi']."'  
							WHERE idbi='".$row['id']."'"; $cek.=$qry."<br>";
					mysql_query($qry);					
				}elseif(empty($dtI['ada'])){
					$qry="Update inventaris set ada='1'  
							WHERE idbi='".$row['id']."'"; $cek.=$qry."<br>";
					mysql_query($qry);					
				}elseif(empty($dtI['kondisi']) && empty($dtI['ada'])){
					$qry="Update inventaris set kondisi='".$row['kondisi']."', ada='1'   
							WHERE idbi='".$row['id']."'"; $cek.=$qry."<br>";
					mysql_query($qry);					
				}
			}
		}
		//===================================get status ada dan tidak====================================//
		$Group =" group by f,g,h,i,j, ref_idruang ";
		$KondisiBarangAll = " AND f='".$ID[0]."' AND g='".$ID[1]."' AND h='".$ID[2]."' AND i='".$ID[3]."' AND j='".$ID[4]."' AND ref_idruang='".$ID[5]."' ";
		
		$dtstall = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Group, '', $KondisiBarangAll)));

		$KondisiBarangAda = " AND f='".$ID[0]."' AND g='".$ID[1]."' AND h='".$ID[2]."' AND i='".$ID[3]."' AND j='".$ID[4]."' AND ref_idruang='".$ID[5]."' AND id in (select idbi from inventaris WHERE ada ='1')";
		$dtstada = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Group, '', $KondisiBarangAda)));
		
		$KondisiBarangTidakAda = " AND f='".$ID[0]."' AND g='".$ID[1]."' AND h='".$ID[2]."' AND i='".$ID[3]."' AND j='".$ID[4]."' AND ref_idruang='".$ID[5]."' AND id in (select idbi from inventaris WHERE ada ='2')";	
		$dtstTidak = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Group, '', $KondisiBarangTidakAda)));	
		
		$KondisiBarangBaik = " AND f='".$ID[0]."' AND g='".$ID[1]."' AND h='".$ID[2]."' AND i='".$ID[3]."' AND j='".$ID[4]."' AND ref_idruang='".$ID[5]."' AND id in (select idbi from inventaris WHERE kondisi ='1')";	
		$dtstBaik = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Group, '', $KondisiBarangBaik)));	
		
		$KondisiBarangKurang = " AND f='".$ID[0]."' AND g='".$ID[1]."' AND h='".$ID[2]."' AND i='".$ID[3]."' AND j='".$ID[4]."' AND ref_idruang='".$ID[5]."' AND id in (select idbi from inventaris WHERE kondisi ='2')";	
		$dtstKurang = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Group, '', $KondisiBarangKurang)));		
		
		$KondisiBarangRusak = " AND f='".$ID[0]."' AND g='".$ID[1]."' AND h='".$ID[2]."' AND i='".$ID[3]."' AND j='".$ID[4]."' AND ref_idruang='".$ID[5]."' AND id in (select idbi from inventaris WHERE kondisi ='3')";	
		$dtstRusak = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Group, '', $KondisiBarangRusak)));	
				
		$KondisiBarangBaikAwl = " AND f='".$ID[0]."' AND g='".$ID[1]."' AND h='".$ID[2]."' AND i='".$ID[3]."' AND j='".$ID[4]."' AND ref_idruang='".$ID[5]."' AND kondisi ='1'";	
		$dtstBaikAwl = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], "", $KondisiBarangBaikAwl)));	
		
		$KondisiBarangKurangAwl = " AND f='".$ID[0]."' AND g='".$ID[1]."' AND h='".$ID[2]."' AND i='".$ID[3]."' AND j='".$ID[4]."' AND ref_idruang='".$ID[5]."' AND kondisi ='2'";	
		$dtstKurangAwl = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], "", $KondisiBarangKurangAwl)));	
		
		$KondisiBarangRusakAwl = " AND f='".$ID[0]."' AND g='".$ID[1]."' AND h='".$ID[2]."' AND i='".$ID[3]."' AND j='".$ID[4]."' AND ref_idruang='".$ID[5]."' AND  kondisi ='3'";	
		$dtstRusakAwl = mysql_fetch_array(mysql_query($this->setInventaris_query($Opsi['Kondisi'],$Opsi['Order'], "", $KondisiBarangRusakAwl)));													
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
		$tmpljmlAda = "<a href='javascript:InventarisRekap.ProsesCaribarang(\"".$id."\")' style='color:$colorjml;text-decoration:none;' title='Cari Barang'/><div style='height:100%;width:100%'>$jmlAda</div></a>"; 						
		$tmpljmlTidak = "<a href='javascript:InventarisRekap.ProsesCaribarang(\"".$id."\")' style='color:$colorjml;text-decoration:none;' title='Cari Barang'/><div style='height:100%;width:100%'>$jmlTidak</div></a>";
		$tmpljmlBaik = "<a href='javascript:InventarisRekap.ProsesCaribarang(\"".$id."\")' style='color:$colorjml;text-decoration:none;' title='Cari Barang'/><div style='height:100%;width:100%'>$jmlBaik</div></a>";
		$tmpljmlKurang = "<a href='javascript:InventarisRekap.ProsesCaribarang(\"".$id."\")' style='color:$colorjml;text-decoration:none;' title='Cari Barang'/><div style='height:100%;width:100%'>$jmlKurang</div></a>";
		$tmpljmlRusak = "<a href='javascript:InventarisRekap.ProsesCaribarang(\"".$id."\")' style='color:$colorjml;text-decoration:none;' title='Cari Barang'/><div style='height:100%;width:100%'>$jmlRusak</div></a>";			
		$tmplstatus = "<a href='javascript:InventarisRekap.ProsesCaribarang(\"".$id."\")' style='color:$color;text-decoration:none;' title='Cari Barang'/><div style='height:100%;width:100%'>$status<input type='hidden' id='idplh_".$id."' name='idplh_".$id."' value='".$id."'></div></a>";	

		if($jmlBaikAwl==$jmlBaik && $jmlKurangAwl==$jmlKurang && $jmlRusakAwl==$jmlRusak){
			$statusBI="<img src='images/administrator/images/valid.png' width='20px' heigh='20px'>";	
		}else{
			$statusBI="<img src='images/administrator/images/invalid.png' width='20px' heigh='20px'>";	
		}	
						
		$content->ada=$tmpljmlAda;	
		$content->tidak=$tmpljmlTidak;			
		$content->status=$tmplstatus;
		$content->baik=$tmpljmlBaik;
		$content->kurang=$tmpljmlKurang;
		$content->rusak=$tmpljmlRusak;
		$content->statusBI=$statusBI;						
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}		

	function setInventaris_query($Kondisi='', $Order='', $Limit='', $KondisiBarang=''){
	
		$aqry = "select ifnull(count(*),0) as jml_bi from $this->TblName $Kondisi $KondisiBarang $Order $Limit ";	//echo $aqr			//return mysql_query($aqry);
		return $aqry;
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
			case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
			break;
			}
			case 'getdata':{
				$get= $this->getData();
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
	 $get = mysql_fetch_array(mysql_query("select * from pengaturan_mutasi"));
	 foreach ($get as $key => $value) {
				  $$key = $value;
				}
	 $cmbStatusSK = cmbArray('sk_penggunaan',$sk_penggunaan,$arrayStatus,'-- STATUS --',"");
	 $databarang = "<input type='checkbox' name='dtbarang[]' value='1' checked> KIB A
					 <input type='checkbox' name='dtbarang[]' value='2' checked> KIB B
					 <input type='checkbox' name='dtbarang[]' value='3' checked> KIB C
					 <input type='checkbox' name='dtbarang[]' value='4' checked> KIB D
					 <input type='checkbox' name='dtbarang[]' value='5' checked> KIB E
					 <input type='checkbox' name='dtbarang[]' value='6' checked> KIB F
					 <input type='checkbox' name='dtbarang[]' value='7' checked> KIB G";
	$qrythnbuku = "SELECT year(tgl_buku) as thn_buku, year(tgl_buku) as thn_buku from buku_induk group by year(tgl_buku)";
	$dtthnbuku=cmbQuery('thnbuku1',$thnbuku1,$qrythnbuku,"","--- PILIH ---")." s/d ".	cmbQuery('thnbuku2',$thnbuku2,$qrythnbuku,"","--- PILIH ---");
	 $datastaset = "<input type='checkbox' name='staset' value='1' checked> Intra
				 <input type='checkbox' name='staset[]' value='2' checked> Ekstra
				 <input type='checkbox' name='staset[]' value='3' checked> Aset Lain-lain 
				 <input type='checkbox' name='staset[]' value='4' checked> Pemanfaatan <br>
				 <input type='checkbox' name='staset[]' value='5' checked> Pemindahtanganan
				 <input type='checkbox' name='staset[]' value='6' checked> Pemusnahan";
	 $datametode = "<input type='radio' name='metode' value='1' checked> REGISTER
					 <input type='radio' name='metode' value='2'> REKAP
					 <input type='radio' name='metode' value='3'> BARCODE";			 
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
	
	function windowShow($withForm=TRUE){
		global $HTTP_COOKIE_VARS;		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';		
		$form_name = $this->FormName;
		
		$fmId = $_REQUEST['fmId'];
		$fmSKPD = $_REQUEST['fmSKPD'];
		$fmUNIT = $_REQUEST['fmUNIT'];
		$fmSUBUNIT = $_REQUEST['fmSUBUNIT'];
		$fmSEKSI = $_REQUEST['fmSEKSI'];
	    //setcookie("cofmURUSAN", $fmURUSAN);
	    //setcookie("cofmSKPD", $fmSKPD);
	    //setcookie("cofmUNIT", $fmUNIT);
		//setcookie("cofmSEKSI", $fmSEKSI);
	    //setcookie("cofmSUBUNIT", $fmSUBUNIT);

		//$FormContent = $this->genDaftarInitial($fmURUSAN,$fmSKPD,$fmUNIT,$fmSUBUNIT,$fmSEKSI);
		$FormContent = "<div style='height:2px;'>".$this->genDaftarInitial($fmId)."</div>";
		//$FormContent = "<div style='height:2px;'>".$this->genDaftarInitialForm($fmId)."</div>";
		if($withForm){
			$params->tipe=1;
			//$params ="style='overfl'";
			$form= "<form name='$form_name' id='$form_name' method='post' action=''>".
				createDialog(
					$form_name.'_div', 
					$FormContent,
					$this->form_width,
					$this->form_height,
					'Pilih Barang',
					'',
					"<input type='button' value='Simpan' onclick ='".$this->Prefix.".windowSave()' >".
					//"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$fmId' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height,
					'',$params
					).
				"</form>";
				
		}else{
			$form= 
				createDialog(
					$form_name.'_div', 
					$FormContent,
					$this->form_width,
					$this->form_height,
					'Pilih BIRM',
					'',
					"<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".
					"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$fmId' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height
				);
			
			
		}
		/*return $form;		
			$FormContent = $this->genDaftarInitial();
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						1400,
						600,
						'Pilih BIRM',
						'',
						"<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
						"<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);*/
			$content = $form;//$content = 'content';	
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	

}

$InventarisShow = new InventarisShowObj();
//$SOTKBaru->username = $_COOKIE['coID'];

?>
