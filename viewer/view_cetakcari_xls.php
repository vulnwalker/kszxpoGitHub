<?phpinclude ('viewerfn_xls.php');function list_footer($XXTMPTGL='',$XXJABATAN1='',$XXNAMA1='',$XXNIP1='',$XXJABATAN2='',$XXNAMA2='',$XXNIP2=''){$isix='<table style="width:30cm" border=0> 				<tr> 				<td align=center colspan=5 >&nbsp;</td>				<td >&nbsp;</td> 				<td align=center colspan=5 >&nbsp;</td>				</tr>				<tr> 				<td align=center colspan=5 style="font-weight:bold;font-size:9pt"><B>MENGETAHUI</B> </td>				<td>&nbsp;</td> 				<td align=center colspan=5 style="font-weight:bold;font-size:9pt"><B>'.$XXTMPTGL.'</B> </td>				</tr>				<tr> 				<td align=center colspan=5 style="font-weight:bold;font-size:9pt"><B>'.$XXJABATAN1.'</B> </td>				<td >&nbsp;</td> 				<td align=center colspan=5 style="font-weight:bold;font-size:9pt"><B>'.$XXJABATAN2.'</B> </td>				</tr>				<tr> 				<td align=center colspan=5 >&nbsp;</td>				<td >&nbsp;</td> 				<td align=center colspan=5 >&nbsp;</td>				</tr>				<tr> 				<td align=center colspan=5 >&nbsp;</td>				<td >&nbsp;</td> 				<td align=center colspan=5 >&nbsp;</td>				</tr>				<tr> 				<td align=center colspan=5 style="font-weight:bold;font-size:9pt"><B>( '.$XXNAMA1.' )</B> </td>				<td >&nbsp;</td> 				<td align=center colspan=5 style="font-weight:bold;font-size:9pt"><B>( '.$XXNAMA2.' )</B> </td>				</tr>				<tr> 				<td align=center colspan=5 style="font-weight:bold;font-size:9pt"><B>NIP. '.$XXNIP1.'</B> </td>				<td >&nbsp;</td> 				<td align=center colspan=5 style="font-weight:bold;font-size:9pt"><B>NIP. '.$XXNIP2.'</B> </td>				</tr>				</table></body></html>';return $isix;	}$fmWIL = cekPOST("fmWIL");	$fmSKPD = $_POST['fmSKPD'];//cekPOST("fmSKPD");	$fmUNIT = cekPOST("fmUNIT");	$fmSUBUNIT = cekPOST("fmSUBUNIT");	$fmTahunPerolehan = $_POST["fmTahunPerolehan"];	$selKondisiBrg = $_POST["selKondisiBrg"];	$kode_barang = $_POST["kode_barang"];		$nm_barang = $_POST["nm_barang"];		$selStatusBrg = $_POST["selStatusBrg"];	$keterangan = $_POST["keterangan"];	//kibA	$selHakPakai= $_POST['selHakPakai'];	$alamat 	= $_POST['alamat'];	$selKabKota	= $_POST['selKabKota'];	$bersertifikat = $_POST['bersertifikat'];	$noSert 	= $_POST['noSert'];			//kibB	$merk 		= $_POST["merk"];	$bahan 		= $_POST["bahan"];	$noPabrik 	= $_POST["noPabrik"];	$noRangka 	= $_POST["noRangka"];	$noMesin	= $_POST["noMesin"];	$noPolisi 	= $_POST["noPolisi"];	$noBPKB 	= $_POST["noBPKB"];		//kibc	$konsTingkat= $_POST['konsTingkat'];	$konsBeton	= $_POST['konsBeton'];	$dokumen_no	= $_POST['dokumen_no'];	$kode_tanah	= $_POST['kode_tanah'];	//$nodokumen	= $_POST['nodokumen'];	//$nokodetanah= $_POST['nokodetanah'];		//kibd	$konstruksi	= $_POST['konstruksi'];		$status_tanah	= $_POST['status_tanah'];		//kib e	$buku_judul			= $_POST['buku_judul'];	$buku_spesifikasi	= $_POST['buku_spesifikasi'];	$seni_asal_daerah	= $_POST['seni_asal_daerah'];	$seni_pencipta		= $_POST['seni_pencipta'];	$seni_bahan			= $_POST['seni_bahan'];	$hewan_jenis		= $_POST['hewan_jenis'];	$hewan_ukuran		= $_POST['hewan_ukuran'];	//kibf	$bangunan	= $_POST['bangunan'];$fmKEPEMILIKAN 	= $Main->DEF_KEPEMILIKAN; $fmWIL 			= $Main->DEF_WILAYAH ;$HalDefault = cekPOST("HalDefault",1);$HalBI = cekPOST("HalBI",1);$HalKIB_A = cekPOST("HalKIB_A",1);$HalKIB_B = cekPOST("HalKIB_B",1);$HalKIB_C = cekPOST("HalKIB_C",1);$HalKIB_D = cekPOST("HalKIB_D",1);$HalKIB_E = cekPOST("HalKIB_E",1);$HalKIB_F = cekPOST("HalKIB_F",1);$cbxDlmRibu = cekPOST("cbxDlmRibu");$cbAscDsc = $_POST['cbAscDsc']; //$cek .= '<br> ascdsc='.$cbAscDsc;//$cbAscDsc_checked = !empty($cbAscDsc)? " checked ":"";$selUrut = $_POST["selUrut"];//$selUrut = 'nmopd';		$all = $_GET['all'];$jmPerHal = cekPOST("jmPerHal");//echo "jmPerHal = $jmPerHal<br>";$Main->PagePerHal = !empty($jmPerHal) ? $jmPerHal : $Main->PagePerHal; PrintTTD(30);$title = getTitleKib($SPg);$page_width = '30cm';$stylexls ='	<style>table.rangkacetak {	background-color: #FFFFFF;	margin: 0cm;	padding: 0px;	border: 0px;	width: 30cm;	border-collapse: collapse;	font-family : Arial,  sans-serif;}table.cetak {	background-color: #FFFFFF;	font-family : Arial,  sans-serif;	margin: 0px;	border: 0px;	width: 30cm;	border-collapse: collapse;	color: #000000;	font-size : 9pt;}table.cetak th.th01 {	color: #000000;	text-align: center;	background-color: #DBDBDB;}table.cetak th.th02 {	color: #000000;	text-align: center;	background-color: #DBDBDB;}table.cetak tr.row0 {	background-color: #DBDBDB;	text-align: left;}table.cetak tr.row1 {	background-color: #FFF;	text-align: left;}table.cetak input {	font-size: 9pt;}/* untuk repeat header */thead { 	display: table-header-group; }/* untuk repeat footer */tfoot { 	display: table-footer-group; }.judulcetak {	width: 30cm;	font-size: 16px;	font-weight: bold;}.subjudulcetak {	font-size: 12px;	font-weight: bold;}.GCTK {	background-color: white;	vertical-align: middle;}.GCTK1 {	background-color: white;	vertical-align: middle;	border-right: 0;}.GCTK2 {	background-color: white;	vertical-align: middle;	border-left: 0;	}.GCTK3 {	background-color: white;	vertical-align: middle;	border-right: 0;	border-left: 0;	}.nfmt1 {	mso-number-format:"\#\,\#\#0_\)\;\[Red\]\\\(\#\,\#\#0\\\)";	}.nfmt2 {	mso-number-format:"0\.00_";	}.nfmt3 {	mso-number-format:"0000";	}.nfmt4 {	mso-number-format:"\#\,\#\#0.00_\)\;\[Red\]\\\(\#\,\#\#0\\\)";}table	{mso-displayed-decimal-separator:"\.";	mso-displayed-thousand-separator:"\,";}	br {mso-data-placement:same-cell;}	</style>';$isi_data_xls ="<head>	<title>$Main->Judul</title>".$stylexls."</head><body><table class='rangkacetak'> <tr valign=top> <td ><!--- judul --->";switch ($SPg){case '03':{$isi_data_xls.="<table border=0 style='width: $page_width;'><tr><td class='judulcetak' colspan=".( $ViewStatus == TRUE? "16":"11" )."><div align='center'>		 $title</div></td></tr></table>";break;}case '04':{$isi_data_xls.="<table border=0 style='width: $page_width;'><tr><td class='judulcetak' colspan=".( $ViewStatus == TRUE? "17":"12" )."><div align='center'>		 $title</div></td></tr></table>";break;}case '05':{$isi_data_xls.="<table border=0 style='width: $page_width;'><tr><td class='judulcetak' colspan=".( $ViewStatus == TRUE? "19":"14" )."><div align='center'>		 $title</div></td></tr></table>";break;}case '06':{$isi_data_xls.="<table border=0 style='width: $page_width;'><tr><td class='judulcetak' colspan=".( $ViewStatus == TRUE? "21":"16" )."><div align='center'>		 $title</div></td></tr></table>";break;}case '07':{$isi_data_xls.="<table border=0 style='width: $page_width;'><tr><td class='judulcetak' colspan=".( $ViewStatus == TRUE? "21":"16" )."><div align='center'>		 $title</div></td></tr></table>";break;}case '08':{$isi_data_xls.="<table border=0 style='width: $page_width;'><tr><td class='judulcetak' colspan=".( $ViewStatus == TRUE? "21":"16" )."><div align='center'>		 $title</div></td></tr></table>";break;}}$isi_data_xls.="<table class='cetak' border=1 style='width: $page_width;'> ";header("Content-Type: application/force-download");header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );header( 'Cache-Control: no-store, no-cache, must-revalidate' );header( 'Cache-Control: post-check=0, pre-check=0', false );header( 'Pragma: no-cache' ); header('Content-disposition: attachment; filename="'.$title.' - Cari.xls"');header("Content-Transfer-Encoding: Binary");echo $isi_data_xls;ob_flush();flush(); 	Viewer_Cari_GetList_XLS2(TRUE);$isi_data_xls="	$cari->listdata.$cari->totalharga.$cari->footer.	</tbody></table></td></tr></table></body>";$isi_data_xls.=list_footer($TITIMANGSA,$JABATANSKPD,$NAMASKPD,$NIPSKPD,$JABATANSKPD1,$NAMASKPD1,$NIPSKPD1)." ";echo $isi_data_xls;ob_flush();flush(); ?>