<?php$Main->PagePerHal = 100;$HalDefault = cekPOST("HalDefault",1);$LimitHal = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal;$cidBI = cekPOST("cidBI");$cbxDlmRibu = cekPOST("cbxDlmRibu");$fmTahunPerolehan = cekPOST("fmTahunPerolehan","");$fmID 	= cekPOST("fmID",0);$fmKEPEMILIKAN = $Main->DEF_KEPEMILIKAN;//$fmWIL 	= cekPOST("fmWIL");$fmSKPD = cekPOST("fmSKPD");$fmUNIT = cekPOST("fmUNIT");$fmSUBUNIT = cekPOST("fmSUBUNIT");$fmTAHUNANGGARAN = cekPOST("fmTAHUNANGGARAN",$fmTahunPerolehan);setWilSKPD();$fmBIDANG 	= cekPOST("fmBIDANG","");$fmKELOMPOK = cekPOST("fmKELOMPOK","");$fmSUBKELOMPOK = cekPOST("fmSUBKELOMPOK","");$fmSUBSUBKELOMPOK = cekPOST("fmSUBSUBKELOMPOK","");$Act = cekPOST('Act');$fmSemester = cekPOST('fmSemester','0');$fmTahun = cekPOST('fmTahun',date('Y'));$Info = "";$cbxSemester = $_REQUEST['cbxSemester'];//echo date('Y-m-j', strtotime ( (2040+1)."-01-01 -1 day"  )); if ($Act=='Tampil' ){if ($cbxSemester){	list($tglAwal, $tglAkhir) = SemesterToTgl($fmSemester, $fmTahun);	}else{	$tglAwal = $fmTahun.'-01-01';	$tglAkhir = $fmTahun.'-12-31';		}//list($tglAwal, $tglAkhir) = SemesterToTgl($fmSemester, $fmTahun);list($ListData, $jmlData) = 	Mutasi_RekapByBrg_GetList2($fmKEPEMILIKAN, $fmSKPD, $fmUNIT, $fmSUBUNIT, 			$Main->PagePerHal * (($HalDefault*1) - 1),0,			'', !empty($cbxDlmRibu), FALSE, 2			);	//$tampilHeaderHarga =  !empty($cbxDlmRibu) ? "Jumlah Harga <br>dalam Ribuan <br>(Rp)" : " Jumlah Harga <br>(Rp) ";	$headerTglAwal =  (substr( $tglAwal, 8, 2 )+0)." ".$Ref->NamaBulan[(substr($tglAwal,5,2)-1)]." ".substr($tglAwal, 0,4);  $headerTglAkhir =  (substr( $tglAkhir, 8, 2 )+0)." ".$Ref->NamaBulan[(substr($tglAkhir,5,2)-1)]." ".substr($tglAkhir, 0,4);  $ListHeader = 	"<tr>		<th class=\"th02\" rowspan='3' width=\"30\" >No.</th>		<th class=\"th02\" colspan=2 >Kode Barang</th>		<th class=\"th02\" rowspan='3' >Nama Bidang Barang</th>				<th class=\"th02\" colspan='2' >Keadaan per <br> $headerTglAwal</th>		<th class=\"th02\" colspan='8' >Mutasi Perubahan Selama  <br> $headerTglAwal s/d $headerTglAkhir </th>		<th class=\"th02\" colspan='2' >Keadaan per <br> $headerTglAkhir</th>	</tr>		<tr>		<th class=\"th02\" rowspan='2' width=\"30\">Gol.</th>		<th class=\"th02\" rowspan='2' width=\"30\">Bid.</th>				<th class=\"th02\" rowspan='2' width=\"20\">Jumlah Barang</th>		<th class=\"th02\" rowspan='2' width=\"120\">Jumlah Harga <br>(Rp.)</th>		<th class=\"th02\" colspan='4' width=\"20\">Berkurang</th>		<th class=\"th02\" colspan='4' width=\"120\">Bertambah</th>		<th class=\"th02\" rowspan='2' width=\"20\">Jumlah Barang</th>		<th class=\"th02\" rowspan='2' width=\"120\">Jumlah Harga <br>(Rp.)</th>	</tr>	<tr>		<th class=\"th02\" width=\"20\">Jumlah Barang</th>				<th class=\"th02\" width=\"120\">Pemeliharaan <br>(Rp.)</th>				<th class=\"th02\" width=\"120\">Pengamanan <br>(Rp.)</th>		<th class=\"th02\" width=\"120\">Perolehan <br>(Rp.)</th>		<th class=\"th02\" width=\"20\">Jumlah Barang</th>		<th class=\"th02\" width=\"120\">Pemeliharaan <br>(Rp.)</th>		<th class=\"th02\" width=\"120\">Pengamanan <br>(Rp.)</th>		<th class=\"th02\" width=\"120\">Perolehan <br>(Rp.)</th>	</tr>	<tr>		<th class=\"th03\" >1</td>		<th class=\"th03\" >2</td>		<th class=\"th03\" >3</td>		<th class=\"th03\" >4</td>		<th class=\"th03\" >5</td>		<th class=\"th03\" >6</td>		<th class=\"th03\" >7</td>		<th class=\"th03\" >8</td>		<th class=\"th03\" >9</td>		<th class=\"th03\" >10</td>		<th class=\"th03\" >11</td>		<th class=\"th03\" >12</td>		<th class=\"th03\" >13</td>		<th class=\"th03\" >14</td>		<th class=\"th03\" >15</td>		<th class=\"th03\" >16</td>			</tr>		";		$Main->ListData->ToolbarBawah =	"<!--<table width=\"100%\" class=\"menudottedline\">	<tr><td>-->		<table width=\"50\"><tr>		<!--<td>".PanelIcon1("javascript:adminForm.action='?Pg=PR&SPg=rekap_bi_cetak';adminForm.target='_blank';adminForm.submit();","print_f2.png","Halaman")."</td>-->		<td>".PanelIcon1("javascript:adminForm.action='?Pg=PR&SPg=rekap_mutasi_cetak2&ctk=$jmlData';adminForm.target='_blank';adminForm.submit();","print_f2.png","Cetak")."</td>		<td>".		PanelIcon1("javascript:adminForm.action='?Pg=PR&SPg=rekap_mutasi_cetak2&ctk=$jmlData&xls=1';adminForm.target='_blank';adminForm.submit();","export_xls.png","Excel").		//PanelIcon1("javascript:adminForm.action='?Pg=PR&SDest=XLS&SPg=rekap_mutasi_cetak2&ctk=$jmlData';adminForm.target='_blank';adminForm.submit();","export_xls.png","Excel").		"</td>		</tr></table>	<!--</td></tr>	</table>-->";}//$dalamRibuan = "<div style='float:left;padding:0 8 0 8;'> <input $cbxDlmRibu id='cbxDlmRibu' type='checkbox' value='checked' name='cbxDlmRibu'> Dalam Ribuan </div>";//$tombolTampil= "<input type=button onClick=\"adminForm.action='?Pg=$Pg&SPg=$SPg';adminForm.target='_self';adminForm.submit();\" value='Tampilkan'>";$dalamRibuan = "<div style='float:left;padding:0 8 0 0; '> 		<table ><tr>		<td style='padding:0;'> Tampilkan : </td>		<td width='10' style='padding:0;'> <input $cbxDlmRibu id='cbxDlmRibu' type='checkbox' value='checked' name='cbxDlmRibu'> </td>		<td style='padding:0;'>Dalam Ribuan </td>		</tr></table>	</div>";//$Semester = "<div style='float:left;padding:0 8 0 8; border-left:1px solid #E5E5E5;'> Semester ".cmb2D_v2('fmSemester',$fmSemester,$Main->ArSemester,'','Semester I')."</div>";//$Tahun= "<div style='float:left;padding:0 8 0 0;'> Tahun <input type=text name='fmTahun' size=4 value='$fmTahun'></div>";if($cbxSemester){	$stylefmSemester = 'display:block';	$cbxSemesterChecked = 'checked=true';	}else{	$stylefmSemester = 'display:none';	$cbxSemesterChecked = '';}$Semester = 	"<script>	function cbxSemesterClick(th){		if( th.checked){			document.getElementById('fmSemester').style.display='block'; 					}else{ 			document.getElementById('fmSemester').style.display='none';		}	}	</script>". 	"<div style='float:left;padding:0 8 0 8; border-left:1px solid #E5E5E5;'> ".		"<input type='checkbox' id='cbxSemester' name='cbxSemester' onclick=\"cbxSemesterClick(this)\" $cbxSemesterChecked> Semester ".		"</div>".	"<div style='float:left;padding:2 8 2 8; border-left:1px solid #E5E5E5;'>".		cmb2D_v2('fmSemester',$fmSemester,$Main->ArSemester," style='$stylefmSemester' ",'Semester I').	"</div>";$Tahun= "<div style='float:left;padding:0 8 0 0;'> Tahun <input type=text name='fmTahun' size=4 value='$fmTahun'></div>";$tombolTampil = "<input type=button 		onClick=\"adminForm.Act.value='Tampil'; adminForm.action='?Pg=$Pg&SPg=$SPg';adminForm.target='_self';adminForm.submit();\" value='Tampilkan'>";$optTampil="	<table width=\"100%\" class=\"adminform\" style='margin:4 0 4 0;'>	<tr>			<td width=\"100%\" valign=\"top\">	$dalamRibuan $Semester $Tahun $BarisPerHalaman $tombolTampil	</td></tr>	</table>	";//echo "<br>dlm ribu=".$cbxDlmRibu;	$cek='';$Main->Isi = "<form action=\"\" method=\"post\" name=\"adminForm\" id=\"adminForm\"><input type=hidden name='Act' value=''>		<table class=\"adminheading\">	<tr>	  <th height=\"47\" class=\"user\">Rekapitulasi Mutasi Barang - Detail </th>	  <th>".$Main->ListData->ToolbarBawah."</th>	</tr>	</table>".WilSKPD2b()."$optTampil<table border=\"1\" class=\"koptable\">	$ListHeader	$ListData	<!--<tr>			<td colspan=13 align=center>".Halaman($jmlData,$Main->PagePerHal,"HalDefault")."</td>	</tr>--></table><br>".$cek;?>