<?php
$fmWIL = cekPOST("fmWIL");
$fmSKPD = cekPOST("fmSKPD");
$fmUNIT = cekPOST("fmUNIT");
$fmSUBUNIT = cekPOST("fmSUBUNIT");
$fmIDBARANG = cekPOST("fmIDBARANG");
$fmNMBARANG = cekPOST("fmNMBARANG");
$fmMEREK = cekPOST("fmMEREK");
$fmJUMLAH = cekPOST("fmJUMLAH");
$fmSATUAN = cekPOST("fmSATUAN");
$fmHARGASATUAN = cekPOST("fmHARGASATUAN");
$fmIDREKENING = cekPOST("fmIDREKENING");
$fmNMREKENING = cekPOST("fmNMREKENING");
$fmKET = cekPOST("fmKET");
$Cari = cekPOST("Cari");
$CariBarang = cekGET("CariBarang");
$CariRekening = cekGET("CariRekening");
$fmTAHUNANGGARAN =cekPOST("fmTAHUNANGGARAN",date("Y"));
$Act = cekPOST("Act");
$Baru = cekPOST("Baru","1");
$Info = "";

//ProsesCekField
$MyField ="fmWIL,fmSKPD,fmUNIT,fmSUBUNIT,fmIDBARANG,fmNMBARANG,fmMEREK,fmJUMLAH,fmSATUAN,fmHARGASATUAN,fmIDREKENING,fmKET,fmTAHUNANGGARAN";
if($Act=="Simpan")
{
	if(ProsesCekField($MyField))
		{
		$ArBarang = explode(".",$fmIDBARANG);
		$ArRekening = explode(".",$fmIDREKENING);
		$JmlHARGA = $fmHARGASATUAN * $fmJUMLAH;
		$Simpan = false;
		if($Baru=="1")
		{
			//Simpan Baru
			$Qry = "insert into rkb (a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,merk_barang,jml_barang,harga,satuan,jml_harga,ket,tahun)
			values ('{$Main->Provinsi[0]}','$fmWIL','$fmSKPD','$fmUNIT','$fmSUBUNIT','{$ArBarang[0]}','{$ArBarang[1]}','{$ArBarang[2]}','{$ArBarang[3]}','{$ArBarang[4]}','{$ArRekening[0]}','{$ArRekening[1]}','{$ArRekening[2]}','{$ArRekening[3]}','{$ArRekening[4]}','$fmMEREK','$fmJUMLAH','$fmHARGASATUAN','$fmSATUAN','$JmlHARGA','$fmKET','$fmTAHUNANGGARAN')";
			$Simpan = mysql_query($Qry);
		}
		if($Baru=="0")
		{
			$Kriteria = "concat(a,b,c,d,e,f,g,h,i,j,tahun)='{$Main->Provinsi[0]}$fmWIL$fmSKPD$fmUNIT$fmSUBUNIT{$ArBarang[0]}{$ArBarang[1]}{$ArBarang[2]}{$ArBarang[3]}{$ArBarang[4]}$fmTAHUNANGGARAN'";
			$Qry = "
			update rkb set 
				k = '{$ArRekening[0]}',l = '{$ArRekening[1]}',m = '{$ArRekening[2]}',n = '{$ArRekening[3]}',o = '{$ArRekening[4]}',	merk_barang='$fmMEREK',jml_barang='$fmJUMLAH',harga='$fmHARGASATUAN',satuan='$fmSATUAN',jml_harga='$JmlHARGA',ket='$fmKET'
			where $Kriteria ";
			$Simpan = mysql_query($Qry);
		}
		if($Simpan)
		{
			$Info = "<script>alert('Data telah di simpan')</script>";
			$Baru="0";
		}
		else
		{
			$Info = "<script>alert('Data TIDAK dapat disimpan')</script>";
		}
	}
	else
	{
		$Info = "<script>alert('Data TIDAK Lengkap\\nLengkapi untuk dapat di simpan')</script>";
	}
	
}





$Qry = mysql_query("select * from ref_wilayah where b<>'00' order by nm_wilayah");
$Ops = "";
while($isi=mysql_fetch_array($Qry))
{
	$sel = $fmWIL == $isi['b'] ? "selected":"";
	$Ops .= "<option $sel value='{$isi['b']}'>{$isi['nm_wilayah']}</option>\n";
}
$ListKab = "<select name='fmWIL'  onChange=\"adminForm.submit()\"><option value=''>--- Pilih Kabupaten/Kota ---</option>$Ops</select>";

//SKPD
$Qry = mysql_query("select * from ref_skpd where d='00' order by nm_skpd");
$Ops = "";
while($isi=mysql_fetch_array($Qry))
{
	$sel = $fmSKPD == $isi['c'] ? "selected":"";
	$Ops .= "<option $sel value='{$isi['c']}'>{$isi['nm_skpd']}</option>\n";
}
$ListSKPD = "<select name='fmSKPD' onChange=\"adminForm.submit()\"><option value=''>--- Pilih SKPD ---</option>$Ops</select>";

//UNIT
$Qry = mysql_query("select * from ref_skpd where c='$fmSKPD' and d <> '00' and e = '00' order by nm_skpd");
$Ops = "";
while($isi=mysql_fetch_array($Qry))
{
	$sel = $fmUNIT == $isi['d'] ? "selected":"";
	$Ops .= "<option $sel value='{$isi['d']}'>{$isi['nm_skpd']}</option>\n";
}
$ListUNIT = "<select name='fmUNIT' onChange=\"adminForm.submit()\"><option value='00'>--- Semua UNIT ---</option>$Ops</select>";


//Sub UNIT
$Qry = mysql_query("select * from ref_skpd where c='$fmSKPD' and d = '$fmUNIT' and e <> '00' order by nm_skpd");
$Ops = "";
while($isi=mysql_fetch_array($Qry))
{
	$sel = $fmSUBUNIT == $isi['e'] ? "selected":"";
	$Ops .= "<option $sel value='{$isi['e']}'>{$isi['nm_skpd']}</option>\n";
}
$ListSUBUNIT = "<select name='fmSUBUNIT' onChange=\"adminForm.submit()\"><option value='00'>--- Semua SUB UNIT ---</option>$Ops</select>";


$Main->Isi = "
<A Name=\"ISIAN\"></A>
$Info
<form name=\"adminForm\" id=\"adminForm\" method=\"post\" action=\"?Pg=$Pg&SPg=$SPg#ISIAN\">
<table class=\"adminheading\">
<tr>
  <th height=\"47\" class=\"user\">Input Daftar Kebutuhan Pemeliharaan Barang </th>
</tr>
</table>
<table width=\"100%\">
<tr>
<td width=\"60%\" valign=\"top\">
<table width=\"100%\" height=\"100%\" class=\"adminform\">
	<tr>
	<td>TAHUN ANGGARAN</td>
		<td>:</td>
		<td><b><INPUT type=text name='fmTAHUNANGGARAN' value='$fmTAHUNANGGARAN' size='6'></b></td>
	</tr>

	<tr>
	<td>PROVINSI</td>
		<td>:</td>
		<td><b>{$Main->Provinsi[1]}</b></td>
	</tr>
	<tr valign=\"top\">
	<td width=\"184\">KABUPATEN / KOTA</td>
		<td width=\"33\">:</td>
		<td width=\"804\">$ListKab</td>
	</tr>
	<tr valign=\"top\">
	  <td>SKPD</td>
	  <td>:</td>
	  <td>$ListSKPD</td>
	</tr>
<!-- katanya dihilangkan..
	<tr valign=\"top\">   
	<td>UNIT</td>
	<td>:</td>
	<td>$ListUNIT</td>
	</tr>

	<tr valign=\"top\">   
	<td>SUB UNIT</td>
	<td>:</td>
	<td>$ListSUBUNIT</td>
	</tr>
-->
	<tr valign=\"top\">   
	<td colspan=3><hr></td>
	</tr>

	<tr valign=\"top\">
	  <td>Kode Lokasi </td>
	  <td>:</td>
	  <td><input readonly type=\"text\" name=\"fmKODELOKASI\" value=\"$fmKODELOKASI\" /></td>
	</tr>

	<tr valign=\"top\">
	  <td>Kode Barang </td>
	  <td>:</td>
	  <td><input readonly type=\"text\" name=\"fmKODEBARANG\" value=\"$fmKODEBARANG\" /></td>
	</tr>
<!-- katanya dihilangkan..
	<tr valign=\"top\">
	  <td>Nama Barang </td>
	  <td>:</td>
	  <td><input readonly type=\"text\" name=\"fmNAMABARANG\" value=\"$fmNAMABARANG\" /></td>
	</tr>
-->
	<tr valign=\"top\">   
	<td>Nama Barang</td>
	<td>:</td>
	<td>
	<i>pencarian barang dari data inventaris</i>
	<input type=text name=CariBarang value='$CariBarang'><input type=button value='Cari' onClick=\"popUpCari('?Pg=$Pg&SPg=caribarang&Cari='+adminForm.CariBarang.value+'',adminForm.fmIDBARANG,adminForm.fmNMBARANG)\"><br>
	<input type=text name='fmIDBARANG' value='$fmIDBARANG' size='15' readonly>
	<input type=text name='fmNMBARANG' value='$fmNMBARANG' size='60' readonly>
	</td>
	</tr>


	<tr valign=\"top\">
		<td>Jumlah Barang </td>
		<td>:</td>
		<td><input name=\"fmJUMLAH\" type=\"text\" value=\"$fmJUMLAH\" />
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Satuan&nbsp;&nbsp;
		  <input name=\"fmSATUAN\" type=\"text\" size=\"10\" value=\"$fmSATUAN\" /></td>
	</tr>


<tr valign=\"top\">
  <td>Harga Satuan </td>
  <td>:</td>
  <td>Rp. 
    <input type=\"text\" name=\"fmHARGASATUAN\" value=\"$fmHARGASATUAN\" /></td>
</tr>



<tr valign=\"top\">
  <td>Jumlah Biaya </td>
  <td>:</td>
  <td>Rp. 
    <input type=\"text\" name=\"fmJMLBIAYA\" value=\"$fmJMLBIAYA\" /></td>
</tr>

	<tr valign=\"top\">   
	<td>Kode Rekening</td>
	<td>:</td>
	<td>
	<i>pencarian rekening</i>
	<input type=text name=CariRekening value='$CariRekening'><input type=button value='Cari' onClick=\"popUpCari('?Pg=$Pg&SPg=carirekening&Cari='+adminForm.CariRekening.value+'',adminForm.fmIDREKENING,adminForm.fmNMREKENING)\"><br>
	<input type=text name='fmIDREKENING' value='$fmIDREKENING' size='15' readonly>
	<input type=text name='fmNMREKENING' value='$fmNMREKENING' size='60' readonly>
	</td>
	</tr>

<tr valign=\"top\">
  <td>Uraian Pemeliharaan</td>
  <td>:</td>
  <td><textarea name=\"fmURAIAN\" cols=\"60\" >$fmURAIAN</textarea></td>
</tr>

<tr valign=\"top\">
  <td>Keterangan</td>
  <td>:</td>
  <td><textarea name=\"fmKET\" cols=\"60\" >$fmKET</textarea></td>
</tr>


</table>
<input type=hidden name='Act'>
<input type=hidden name='Baru' value='$Baru'>

<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
	<tr><td class=\"menudottedline\">
			<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
			<tr>
			<td class=\"menudottedline\" height=\"52\" align=right>
			".PanelIcon1("javascript:prosesBaru()","new_f2.png","Baru")."
			</td>
			<td class=\"menudottedline\" height=\"52\">
			".PanelIcon1("javascript:adminForm.Act.value='Simpan';adminForm.submit()","save_f2.png","Simpan")."
			</td>
			<td align=right  class=\"menudottedline\" >
			".PanelIcon1("?Pg=$Pg","cancel_f2.png","Tutup")."
			</td>
			</tr>
			</table>
	</td></tr>
</table>
<script language='javascript'>
function prosesBaru()
{
	//fmWIL,fmSKPD,fmUNIT,fmSUBUNIT,fmIDBARANG,fmNMBARANG,fmMEREK,fmJUMLAH,fmSATUAN,fmHARGASATUAN,fmIDREKENING,fmKET,fmTAHUNANGGARAN
	adminForm.Baru.value = '1';
	adminForm.CariBarang.value = '';
	adminForm.fmIDBARANG.value = '';
	adminForm.fmNMBARANG.value = '';
	adminForm.fmMEREK.value = '';
	adminForm.fmJUMLAH.value = '';
	adminForm.fmSATUAN.value = '';
	adminForm.fmHARGASATUAN.value = '';
	adminForm.fmIDREKENING.value = '';
	adminForm.fmNMREKENING.value = '';
	adminForm.fmKET.value = '';
	//adminForm.Submit()
}
</script>
</td></tr></table>
</form>



";
?>