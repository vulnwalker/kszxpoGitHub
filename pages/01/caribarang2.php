<?php
error_reporting(0);
include("../../common/vars.php");
include("../../config.php");
//include("../../common/fnfile.php");

$Cari = isset($HTTP_GET_VARS['Cari'])?$HTTP_GET_VARS['Cari']:"";
$objID = isset($HTTP_GET_VARS['objID'])?$HTTP_GET_VARS['objID']:"";$cek .= '<br> objid='.$objID;
$objNM = isset($HTTP_GET_VARS['objNM'])?$HTTP_GET_VARS['objNM']:"";

$Act = $_GET['Act']; //echo '<br> act ='.$Act;
$kdBrgOld = $_GET['kdBrgOld']; //echo '<br> kdBrgOld='.$kdBrgOld;
$fmBIDANG = $_GET["fmBIDANG"]; //echo '<br> bidang='.$fmBIDANG;
$fmKELOMPOK = $_GET["fmKELOMPOK"];
$fmSUBKELOMPOK = $_GET["fmSUBKELOMPOK"];
$fmSUBSUBKELOMPOK = $_GET["fmSUBSUBKELOMPOK"];
$SPg= $_GET['SPg']; //echo "<br>SPg=$SPg";
$KIB= $_GET['KIB']; // echo '<br> KIB='.$KIB;
$Baru = $_GET['Baru']; //echo '<br> Baru='.$Baru;
 
$Cari1 = isset($HTTP_GET_VARS['Cari1'])?$HTTP_GET_VARS['Cari1']:"";
$Cari2 = isset($HTTP_GET_VARS['Cari2'])?$HTTP_GET_VARS['Cari2']:"";
$Kondisi = '';
$arrKondisi = array("j <> '00'","j <> '000'");
if($Cari1 != '') $arrKondisi[] = "nm_barang like '%$Cari1%' "; 
if($Cari2 != '') $arrKondisi[] = " concat(f,'.',g,'.',h,'.',i,'.',j) like '$Cari2%' "; 

$cek .= '<br> cari1='.$Cari1;
if 	($KIB== 'kibg') $fmKELOMPOK='24';
//$Kondisi = " where nm_barang like '%$Cari1%' and j <> '00' ";
$Kondisi = join(' and ',$arrKondisi);
if($Kondisi != '') $Kondisi = 'where '.$Kondisi;

//BIDANG
//if ($Act == 'Edit') {
if ($Baru == 0){

	$kdbid = substr($kdBrgOld, 0, 2);

	//$kdbid = $KIB;
	$nmbid = table_get_value("select nm_barang from ref_barang where f='".$kdbid."' and g ='00' and h = '00' and i='00' and (j='00' or j='000')", "nm_barang");
	$cek .= '<br> nm bid = '.$nmbid;
	$fmBIDANG = $kdbid;
	$ListBidang = '
		<input type="hidden" name ="fmBIDANG" value="'.$fmBIDANG.'">
		<input type="text" readonly="" value="'.$nmbid.'" style="width:400">';
}else{
	if ($KIB == '03' || $KIB == ''){
		$ListBidang = cmbQuery("fmBIDANG",$fmBIDANG,"select f,nm_barang from ref_barang where f!='00' and g ='00' and h = '00' and i='00' and (j='00' or j='000')","onChange=\"adminForm.submit()\"",'Pilih','');		
	}else{	
	
		switch($KIB){		
			case '04': $kdbid = '01'; break;
			case '05': $kdbid = '02'; break;
			case '06': $kdbid = '03'; break;
			case '07': $kdbid = '04'; break;
			case '08': $kdbid = '05'; break;
			case '09': $kdbid = '06'; break;


		}
	
		$nmbid = table_get_value("select nm_barang from ref_barang where f='".$kdbid."' and g ='00' and h = '00' and i='00' (j='00' or j='000')", "nm_barang");
		$fmBIDANG = $kdbid;
		$ListBidang = '
			<input type="hidden" name ="fmBIDANG" value="'.$fmBIDANG.'">
			<input type="text" readonly="" value="'.$nmbid.'" style="width:400">			
			';
	}
	$ListBidang .= '<input type="hidden" name ="SPg" value="'.$SPg.'" >';
	
}


$ListKelompok = cmbQuery("fmKELOMPOK",$fmKELOMPOK,
	"select g,nm_barang from ref_barang where f='$fmBIDANG' and g !='00' and h = '00' and i='00' and (j='00' or j='000')",
	"onChange=\"adminForm.submit()\"",'Pilih','');
$ListSubKelompok = cmbQuery("fmSUBKELOMPOK",$fmSUBKELOMPOK,"select h,nm_barang from ref_barang where f='$fmBIDANG' and g ='$fmKELOMPOK' and h != '00' and i='00' and (j='00' or j='000')","onChange=\"adminForm.submit()\"",'Pilih','');
$ListSubSubKelompok = cmbQuery("fmSUBSUBKELOMPOK",$fmSUBSUBKELOMPOK,"select i,nm_barang from ref_barang where f='$fmBIDANG' and g ='$fmKELOMPOK' and h = '$fmSUBKELOMPOK' and i!='00' and (j='00' or j='000')","onChange=\"adminForm.submit()\"",'Pilih','');

if ($fmBIDANG==''){	$fmBIDANG ='00';}
if ($fmKELOMPOK==''){	$fmKELOMPOK ='00';}
if ($fmSUBKELOMPOK==''){	$fmSUBKELOMPOK ='00';}
if ($fmSUBSUBKELOMPOK==''){	$fmSUBSUBKELOMPOK ='00';}
if (!(($fmBIDANG == '' ||$fmBIDANG =='00') && ($fmKELOMPOK == '' ||$fmKELOMPOK =='00') 
 	&& ($fmSUBKELOMPOK == '' ||$fmSUBKELOMPOK =='00') && ($fmSUBSUBKELOMPOK == '' ||$fmSUBSUBKELOMPOK =='00')) ){
	
	if ($fmBIDANG != 00 ){ $Kondisi .= " and f ='$fmBIDANG'";}
	if ($fmKELOMPOK != 00 ){ $Kondisi .= " and g ='$fmKELOMPOK'";}
	if ($fmSUBKELOMPOK != 00 ){ $Kondisi .= " and h ='$fmSUBKELOMPOK'";}
	if ($fmSUBSUBKELOMPOK != 00 ){ $Kondisi .= " and i ='$fmSUBSUBKELOMPOK'";}

}

$sqry = "select * from ref_barang ".$Kondisi." order by f,g,h,i,j limit 0,200 ";
$cek .= '<br> sqry='.$sqry;
$Qry = mysql_query($sqry);
$numRow = mysql_num_rows($Qry);
$List = "";
$no=0;
while($isi=mysql_fetch_array($Qry))
{
	$nmF = mysql_fetch_array(mysql_query("select nm_barang from ref_barang where f='{$isi['f']}' and g='00' and h='00' and i='00' and (j='00' or j='000')"));
	$nmG = mysql_fetch_array(mysql_query("select nm_barang from ref_barang where f='{$isi['f']}' and g='{$isi['g']}' and h='00' and i='00' and (j='00' or j='000')"));
	$nmH = mysql_fetch_array(mysql_query("select nm_barang from ref_barang where f='{$isi['f']}' and g='{$isi['g']}' and h='{$isi['h']}' and i='00' and (j='00' or j='000')"));
	$nmI = mysql_fetch_array(mysql_query("select nm_barang from ref_barang where f='{$isi['f']}' and g='{$isi['g']}' and h='{$isi['h']}' and i='{$isi['i']}' and (j='00' or j='000')"));
	$no++;
	$Isi1 = $isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'];
	$Isi2 = $isi['nm_barang'];
	$List.= "
		<tr>
		<td>$no. </td>
		<td>$Isi1</td>
		<td><a href='#' cursor='hand' onClick=\"KlikGunakan('$Isi1','$Isi2')\">$Isi2 </a></td>
		<td>{$nmF[0]}</td>
		<td>{$nmG[0]}</td>
		<td>{$nmH[0]}</td>
		<td>{$nmI[0]}</td>
		</tr>";
}

$Main->Isi = "
<HTML>
<HEAD>
	<link rel=\"stylesheet\" href=\"../../css/template_css.css\" type=\"text/css\" />
	<link rel=\"stylesheet\" href=\"../../css/theme.css\" type=\"text/css\" /> 
<script>
	function tutup()
	{
		parent.document.body.style.overflow = 'visible';
		parent.document.all.cariiframe$objID.style.visibility='hidden';
	}
	function KlikGunakan(isi1,isi2)
	{
		parent.document.adminForm.$objID.value=isi1;
		parent.document.adminForm.$objNM.value=isi2;
		parent.document.adminForm.submit(); //refresh page utk show detail
		//tutup();
	}
</script>
</HEAD>
<BODY>
<table class=\"adminheading\">
	<tr>
		<th height=\"47\" class=\"searchtext\">Pencarian Nama Barang</th>
		<td align=\"right\"><input align=right type=submit value=Tutup onClick=\"tutup()\"></td>
	</tr>
</table>

<form name=\"adminForm\" id=\"adminForm\"  method=get action='?Cari=$Cari&fmBIDANG=$fmBIDANG&fmKELOMPOK=$fmKELOMPOK&fmSUBKELOMPOK=$fmSUBKELOMPOK&fmSUBSUBKELOMPOK=$fmSUBSUBKELOMPOK' class=\"adminform\">
<!--<form name=\"adminForm\" id=\"adminForm\"  method=\"post\" action='?Cari=$Cari' class=\"adminform\">-->
<!--Kel barang-->
<table width=\"100%\">
<tr>
	<td width=\"60%\" valign=\"top\">
		<table width=\"100%\" height=\"100%\" class=\"adminform\">
		<tr>
		<td WIDTH='10%'>BIDANG</td>
			<td WIDTH='1%'>:</td>
			<td WIDTH='89%'>$ListBidang</td>
		</tr>
		<tr>
		<td WIDTH='10%'>KELOMPOK</td>
			<td WIDTH='1%'>:</td>
			<td WIDTH='89%'>$ListKelompok</td>
		</tr>
		<td WIDTH='10%'>SUB KELOMPOK</td>
			<td WIDTH='1%'>:</td>
			<td WIDTH='89%'>$ListSubKelompok</td>
		</tr>
		<td WIDTH='10%'>SUB SUB KELOMPOK</td>
			<td WIDTH='1%'>:</td>
			<td WIDTH='89%'>$ListSubSubKelompok</td>
		</tr>
		</table>

<input type=hidden name='KIB' value='$KIB'>
<input type=hidden name='Baru' value='$Baru'>
<input type=hidden name='kdBrgOld' value='$kdBrgOld'>
<input type=hidden name='Act' value='$Act'>
<input type=hidden name='objID' value='$objID'>
<input type=hidden name='objNM' value='$objNM'>
<br>
<div style='float:left;padding:4 8 4 8'>Nama Barang </div>
<div style='float:left'><input type=text value='$Cari1' name='Cari1' style='width:200px'> </div>
<div style='float:left;padding:4 8 4 8'>Kode Barang</div>
<div style='float:left;'><input type=text value='$Cari2' name='Cari2' style='width:200px'></div>
<div style='float:left;'> <input type=submit value='Cari'> </div>
<div style='float:left;padding:4 8 4 8'>Maksimal ditampilkan 200 data.</div>
</form>
<table width=\"100%\" height=\"100%\">
	<tr>
		<td vAlign=top>
			<table align=center class=\"adminlist\">	
				<tr>
					<td colspan=7 align=\"center\">$fmKELOMPOK  
					Ditemukan <font color=red>$numRow</font> data barang yang sesuai dengan kata kunci <b>'$Cari1'</b>, <b>'$Cari2'</b>. Pilih nama barang yang akan diinput.
					</td>
				</tr>
				<tr>
					<th align='left'>No.</th>
					<th align='left'>Kode Barang</th>
					<th align='left'>Nama Barang</th>
					<th align='left'>Bidang</th>
					<th align='left'>Kelompok</th>
					<th align='left'>Sub Kelompok</th>
					<th align='left'>Sub Sub Kelompok</th>
				</tr>
				$List
			</table>
</td></tr>
</table>
</BODY>
</HTML>
";

$cek = '';
echo $Main->Isi.$cek;
?>
