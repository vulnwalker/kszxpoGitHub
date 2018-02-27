<?php

class SOTKBaruObj extends DaftarObj2{
	var $Prefix = 'SOTKBaru';
	var $SHOW_CEK = TRUE;	
	var $TblName = 'view_buku_induk2';//view2_sensus';
	var $TblName_Hapus = 'buku_induk';
	var $TblName_Edit = 'buku_induk';
	var $KeyFields = array('f');
	var $FieldSum = array('nilai_buku');
	var $SumValue = array('nilai_buku');
	var $FieldSum_Cp1 = array( 11, 8, 8);
	var $FieldSum_Cp2 = array( 3, 3, 3);	
	var $FormName = 'SOTKBaruForm';
	var $pagePerHal = 25;
	//var $withSumAll = FALSE;
	//var $withSumHal = FALSE;
	//var $WITH_HAL = FALSE;
	
	var $PageTitle = 'SOTK Baru';
	var $PageIcon = 'images/penatausahaan_ico.gif';
	var $ico_width = '20';
	var $ico_height = '30';
	
	var $fileNameExcel='Daftar SOTK Baru.xls';
	var $Cetak_Judul = 'MUTASI BARANG KE SOTK BARU';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $fmST = 0;
	var $idpilih = '';
	//var $row_params= " valign='top'";
	
	
	function setTitle(){
		global $Main;
		return 'MUTASI BARANG KE SOTK BARU';	

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
		return 
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Mutasi()","mutasi.png","Mutasi", 'Mutasi')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Batal", 'Batal')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Report()","edit_f2.png","Report", 'Report')."</td>";
	}
	
	function setMenuView(){		
		return 			
			"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png",'Halaman',"Cetak Daftar per Halaman")."</td>".			
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakAll(\"$Op\")","print_f2.png",'Cetak',"Cetak Daftar")."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".exportXls(\"$Op\")","export_xls.png",'Excel',"Export Excel")."</td>";					

	}
	
	function genDaftarOpsi(){
		global $Main,$fmFiltThnBuku;
		
		$fmTahun = $_REQUEST['fmTahun'];
		$fmTriwulan1 = $_REQUEST['fmTriwulan1'];
		$fmTriwulan2 = $_REQUEST['fmTriwulan2'];
		$arrMutasi = array(
					array("1","Belum Mutasi"),
					array("2","Sudah Mutasi"),
				);
		
		$ArFieldCari = array(
				array('nm_barang', 'Nama Barang'),
				array('thn_perolehan', 'Tahun Perolehan'),
				//array('alamat', 'Letak/Alamat'),
				//array('ket', 'Keterangan')
					);
		
		$arrOrder = array(
			array('1','Tahun Anggaran'),
			array('2','Kode Barang'),	
			array('3','Nama Barang'),		
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
			" Baris per halaman <input type=text name='jmPerHal' id='jmPerHal' size=4 value='$Main->PagePerHal'> </div>"
			;
		
		$TampilOpt =
			"<table width=\"100%\" class=\"adminform\">	<tr>		
			<td width=\"50%\" valign=\"top\"><h2>SOTK LAMA</h2>		
				" . WilSKPD_ajx3($this->Prefix.'Skpd') . 
			"</td>
			<td width=\"50%\" valign=\"top\"><h2>SOTK BARU</h2>			
				" . WilSKPD_ajxVW($this->Prefix.'Skpd2') . 
			"</td>
			</tr></table>".
			$OptCari.
			genFilterBar(
				array(	
					"<div style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
					cmb2D_v2('stmutasi', $stmutasi, $arrMutasi, '', 'Status Mutasi', '').
					"</div>".
					"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
					cmb2D_v2('staset', $staset, $Main->StatusAsetView, '','Semua Status Aset').
					"</div>".
					$BarisPerHalaman.
					'Urutkan : '.
					cmbArray('fmORDER1',$fmORDER1,$arrOrder,'--','').
					"<input type='checkbox' $fmDESC1 id='fmDESC1' name='fmDESC1' value='checked'>Desc."
				),$this->Prefix.".refreshList(true)",TRUE
			)
			;
		
		return array('TampilOpt'=>$TampilOpt);
		
	
	}
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		global $fmPILCARI;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST('fmSKPDBidang');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST('fmSKPDskpd');
		$fmThnAnggaran=  cekPOST('fmThnAnggaran');
		$fmThn1=  cekPOST('fmThn1');
		$fmThn2=  cekPOST('fmThn2');
		$fmSemester = cekPOST('fmSemester');
		
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
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
				<script type='text/javascript' src='js/sotkbaru/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
				".
						$scriptload;
	}
	
	function setKolomHeader($Mode=1, $Checkbox=''){
		$cetak = $Mode==2 || $Mode==3 ;
		
			
		$headerTable =
				"<tr>
				<th class='th02'colspan=4>Nomor</th>
				<th class='th02'colspan=3>Spesifikasi Barang</th>
				<th class='th01'rowspan=2>Bahan</th>
				<th class='th01'rowspan=2>Cara Perolehan/<br>Sumber Dana</th>
				<th class='th01'rowspan=2>Tahun <br> Perolehan</th>
				<th class='th02'colspan=2>Jumlah</th>
				<th class='th02'colspan=2>Mutasi ke SOTK Baru</th>
				</tr>
				
				<tr>
				<th class='th01' width='20' rowspan=2>No.</th>
  	  			$Checkbox 		
				<th class='th01'>Kode Barang/ <br> ID Barang</th>
				<th class='th01'>Reg</th>
				<th class='th01'>Nama/ Jenis Barang</th>
				<th class='th01'>Merk/ Type/ Lokasi</th>
				<th class='th01'>No. Sertifikat/ <br>No. Pabrik</th>
				<th class='th01'>Barang</th>
				<th class='th01'>Harga</th>
				<th class='th01'>Kode/Nama</th>
				<th class='th01'>BAST</th>
				</tr>
				
				";
				
		return $headerTable;
	}
	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref;
		$arrStatus = array ('','','', 'Batal','Dihapus');
		
		$kode_brg = $isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'];
		
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
		$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['nilai_buku']/1000, 2, ',', '.') : number_format($isi['nilai_buku'], 2, ',', '.');
		$jns_hibah = $isi['jns_hibah'] == 0?'':$isi['jns_hibah'];
		$Koloms = array();
		$Koloms[] = array('align=right', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array('', $kode_brg);		
		$Koloms[] = array('', $isi['noreg']);		
		$Koloms[] = array('', $isi['nm_barang']);
		
		$Koloms[] = array('', $ISI5 );
		$Koloms[] = array('', $ISI6 );
		$Koloms[] = array('', $ISI7 );
		$Koloms[] = array('', $Main->AsalUsul[$isi['asal_usul']-1][1]."<br>/".$jns_hibah."<br>/".$Main->StatusBarang[$isi['status_barang']-1][1] );
		
		$Koloms[] = array('', $isi['thn_perolehan'] );
		$Koloms[] = array('', $isi['jml_barang']." ".$isi['satuan'] );
		$Koloms[] = array('align=right', $tampilHarga );
		$Koloms[] = array('', );
		$Koloms[] = array('',  );
		
		return $Koloms;
	}	
	
	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){
			case 'formBaru2':{				
				//echo 'tes';
				$this->setFormBaru();				
				//$cek = $fm['cek'];
				//$err = $fm['err'];
				//$content = $fm['content'];
				$json = FALSE;				
				break;
			}
			
			case 'formEdit2':{								
				$this->setFormEdit();				
				$json = FALSE;				
				break;
			}
			case 'simpan2' : {
				$get = $this->simpan2();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 
				break;
			}
						
			case 'hapus':{
				$cbid= $_POST[$this->Prefix.'_cb'];				
				$get= $this->Hapus($cbid);
				$err= $get['err']; 
				$cek = $get['cek'];
				$json=TRUE;	
				break;
			}			
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	
	
}
$SOTKBaru = new SOTKBaruObj();

?>