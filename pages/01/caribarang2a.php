<?php
error_reporting(0);
include("../../common/vars.php");
include("../../config.php");
//include("../../common/fnfile.php");

$Cari = isset($HTTP_GET_VARS['Cari'])?$HTTP_GET_VARS['Cari']:"";
$objID = isset($HTTP_GET_VARS['objID'])?$HTTP_GET_VARS['objID']:"";$cek .= '<br> objid='.$objID;
$objNM = isset($HTTP_GET_VARS['objNM'])?$HTTP_GET_VARS['objNM']:"";

$Act = $_GET['Act']; $cek .= '<br> act ='.$Act;
$kdBrgOld = $_GET['kdBrgOld']; $cek .= '<br> id barang old ='.$kdBrgOld;
$fmBIDANG = $_GET["fmBIDANG"];$cek .= '<br> bidang='.$fmBIDANG;
$fmKELOMPOK = $_GET["fmKELOMPOK"];
$fmSUBKELOMPOK = $_GET["fmSUBKELOMPOK"];
$fmSUBSUBKELOMPOK = $_GET["fmSUBSUBKELOMPOK"];
 
$c = $_GET['c'];
$d = $_GET['d'];
$e = $_GET['e'];
$e1 = $_GET['e1'];

 
$Cari1 = isset($HTTP_GET_VARS['Cari1'])?$HTTP_GET_VARS['Cari1']:"";
$cek .= '<br> cari1='.$Cari1;

$Kondisi = " where nm_barang like '%$Cari1%' and j <> '00' and j <> '000' ";


//BIDANG
if ($Act == 'Edit') {
	$kdbid = substr($kdBrgOld, 0, 2);
	$nmbid = table_get_value("select nm_barang from ref_barang where f='".$kdbid."' and g ='00' and h = '00' and i='00' and (j='00' or j='000')", "nm_barang");
	$cek .= '<br> nm bid = '.$nmbid;
	$fmBIDANG = $kdbid;
	$ListBidang = '
		<input type="hidden" name ="fmBIDANG" value="'.$fmBIDANG.'">
		<input type="text" readonly="" value="'.$nmbid.'" style="width:400">';
}else{
	$ListBidang = cmbQuery("fmBIDANG",$fmBIDANG,"select f,nm_barang from ref_barang where f!='00' and g ='00' and h = '00' and i='00' and (j='00' or j='000')","onChange=\"adminForm.submit()\"",'Pilih','');	
}

$ListKelompok = cmbQuery("fmKELOMPOK",$fmKELOMPOK,"select g,nm_barang from ref_barang where f='$fmBIDANG' and g !='00' and h = '00' and i='00' and (j='00' or j='000')","onChange=\"adminForm.submit()\"",'Pilih','');
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

$sqry = "select * from ref_barang ".$Kondisi." order by f,g,h,i,j limit 0,200 "; //echo"$sqry";
$cek .= '<br> sqry='.$sqry;
$Qry = mysql_query($sqry);

//$kondskpd = " and c='$c' and d='$d' and e='$e' and e1='$e1'  ";
$numRow = mysql_num_rows($Qry);
$List = "";
$no=0;
while($isi=mysql_fetch_array($Qry))
{
	//$nmF = mysql_fetch_array(mysql_query("select nm_barang from ref_barang where f='{$isi['f']}' and g='00' and h='00' and i='00' and (j='00' or j='000')"));
	//$nmG = mysql_fetch_array(mysql_query("select nm_barang from ref_barang where f='{$isi['f']}' and g='{$isi['g']}' and h='00' and i='00' and (j='00' or j='000')"));
	//$nmH = mysql_fetch_array(mysql_query("select nm_barang from ref_barang where f='{$isi['f']}' and g='{$isi['g']}' and h='{$isi['h']}' and i='00' and (j='00' or j='000')"));
	//$nmI = mysql_fetch_array(mysql_query("select nm_barang from ref_barang where f='{$isi['f']}' and g='{$isi['g']}' and h='{$isi['h']}' and i='{$isi['i']}' and (j='00' or j='000')"));
	$no++;
	$Isi1 = $isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'];
	$Isi2 = $isi['nm_barang'];
	
	/** ditutup heula berat tampil na
	//cari jumlah barang
	$jum=mysql_fetch_array(mysql_query("select sum(jml_barang) as jml_barang from buku_induk 
										where f='{$isi[f]}' and g='{$isi[g]}' 
										and h='{$isi[h]}' and i='{$isi[i]}'
										and j='{$isi[j]}' $kondskpd  "));
	$Isi3 = $jum['jml_barang']==''?'0':$jum['jml_barang'];
	**/
	
	$tmax = mysql_fetch_array(mysql_query("select max(thn_akun) as thn_akun from ref_jurnal where thn_akun <= '".$HTTP_COOKIE_VARS['coThnAnggaran']."'"));
	$kueri="select * from ref_jurnal 
			where thn_akun = '".$tmax['thn_akun']."' 
			and ka='{$isi[m1]}' and kb='{$isi[m2]}' 
			and kc='{$isi[m3]}' and kd='{$isi[m4]}'
			and ke='{$isi[m5]}' and kf='{$isi[m6]}'"; //echo "$kueri";
	$isi4 = '';
	$isi5 = '';
	$qry2 = mysql_query($kueri);
	while ($row=mysql_fetch_array($qry2)){
		$Isi4 = $row['ka'].".".$row['kb'].".".$row['kc'].".".$row['kd'].".".$row['ke'].".".$row['kf'];
		$Isi5 = $row['nm_account'];	
	}
	
	
	$List.= "
		<tr>
		<td>$no. </td>
		<td>$Isi1</td>
		<td><a href='#' cursor='hand' onClick=\"KlikGunakan('$Isi1','$Isi2','$Isi4','$Isi5')\">$Isi2 </a></td>
		<!--<td>$Isi3</td>-->
		<!--<td>{$nmF[0]}</td>
		<td>{$nmG[0]}</td>
		<td>{$nmH[0]}</td>
		<td>{$nmI[0]}</td>-->
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
		parent.document.all.cariiframe$objID.style.visibility='hidden';
	}
	function KlikGunakan(isi1,isi2,isi3,isi4)
	{
		parent.document.adminForm.$objID.value=isi1;
		parent.document.adminForm.$objNM.value=isi2;
		if(isi3 != '' && isi3 != '.....'){
			parent.document.adminForm.fmIDREKENING.value=isi3;
			parent.document.adminForm.fmNMREKENING.value=isi4;	
		}
		
		tutup();
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


<input type=hidden name='kdBrgOld' value='$kdBrgOld'>
<input type=hidden name='Act' value='$Act'>
<input type=hidden name='objID' value='$objID'>
<input type=hidden name='objNM' value='$objNM'>
Ketik nama barang /jenis barang yang akan dicari&nbsp;&nbsp;&nbsp;<input type=text value='$Cari1' name='Cari1' style='width:200px'><input type=submit value='Cari'> 
<br>Maksimal ditampilkan 200 data.
</form>
<table width=\"100%\" height=\"100%\">
	<tr>
		<td vAlign=top>
			<table align=center class=\"adminlist\">	
				<tr>
					<td colspan=7 align=\"center\"> 
					Ditemukan <font color=red>$numRow</font> data barang yang sesuai dengan kata kunci <b>$Cari1</b>. Pilih nama barang yang akan diinput.
					</td>
				</tr>
				<tr>
					<th align='left' width='50'>No.</th>
					<th align='left' width='200'>Kode Barang</th>
					<th align='left'>Nama Barang</th>
					<!--<th align='left'>Jumlah Barang</th>-->
					<!--<th align='left'>Bidang</th>
					<th align='left'>Kelompok</th>
					<th align='left'>Sub Kelompok</th>
					<th align='left'>Sub Sub Kelompok</th>-->
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
