<?php
set_time_limit(300);
include('kiba_xls.php');
$AcsDsc1 = cekPOST("AcsDsc1");
$AcsDsc2 = cekPOST("AcsDsc2");
$Asc1 = !empty($AcsDsc1)? " desc ":"";
$Asc2 = !empty($AcsDsc2)? " desc ":"";
$jmPerHal = cekPOST("jmPerHal");
$Main->PagePerHal = !empty($jmPerHal) ? $jmPerHal : $Main->PagePerHal;
$odr1 = cekPOST("odr1");
$odr2 = cekPOST("odr2");
$Urutkan = "";
if(!empty($odr1) && empty($odr2))
{$Urutkan = " $odr1 $Asc1, ";}
if(!empty($odr2) && empty($odr1))
{$Urutkan = " $odr2 $Asc2, ";}
if(!empty($odr2) && !empty($odr1))
{$Urutkan = " $odr1 $Asc1, $odr2 $Asc2, ";}

$HalKIB_A = cekPOST("HalKIB_A",1);
$ctk = cekGET("ctk");
$Main->PagePerHal = !empty($ctk)?0:$Main->PagePerHal;
$LimitHalKIB_A = " limit ".(($HalKIB_A	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal;
$LimitHalKIB_A = !empty($ctk)?"":$LimitHalKIB_A;


$cbxDlmRibu = cekPOST("cbxDlmRibu");

/*
$HalBI = cekPOST("HalBI",1);
$HalKIB_A = cekPOST("HalKIB_A",1);
$LimitHalBI = " limit ".(($HalBI*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal;
$LimitHalKIB_A = " limit ".(($HalKIB_A*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal;
*/
$cidBI = cekPOST("cidBI");
$cidKIB_A = cekPOST("cidKIB_A");

$fmTahunPerolehan = cekPOST("fmTahunPerolehan","");
$fmID = cekPOST("fmID",0);
$fmKEPEMILIKAN =  $Main->DEF_KEPEMILIKAN;
$fmWIL = cekPOST("fmWIL");
$fmSKPD = cekPOST("fmSKPD");
$fmUNIT = cekPOST("fmUNIT");
$fmSUBUNIT = cekPOST("fmSUBUNIT");
$fmTAHUNANGGARAN =cekPOST("fmTAHUNANGGARAN",$fmTahunPerolehan);
setWilSKPD();

$Cari = cekPOST("Cari");
$CariBarang = cekGET("CariBarang");
$CariRekening = cekGET("CariRekening");

$fmCariComboIsi = cekPOST("fmCariComboIsi");
$fmCariComboField = cekPOST("fmCariComboField");

$Act = cekPOST("Act");
$Baru = cekPOST("Baru","1");
$Info = "";

//LIST KIB_A
$KondisiD = $fmUNIT == "00" ? "":" and d='$fmUNIT' ";
$KondisiE = $fmSUBUNIT == "00" ? "":" and e='$fmSUBUNIT' ";
//$Kondisi = "a1='$fmKEPEMILIKAN' and a='{$Main->Provinsi[0]}' and b='$fmWIL' and c='$fmSKPD' $KondisiD $KondisiE ";
$Kondisi = "a1='$fmKEPEMILIKAN' and a='{$Main->Provinsi[0]}'  and c='$fmSKPD' $KondisiD $KondisiE ";

//$fmWIL,$fmSKPD,$fmUNIT,$fmSUBUNIT,$fmTAHUNANGGARAN,$fmKEPEMILIKAN
//$KODELOKASI = $fmKEPEMILIKAN.".".$fmWIL . "." .$fmSKPD . "." .$fmUNIT . "." . substr($fmTAHUNANGGARAN,2,2) . "." .$fmSUBUNIT;
$KODELOKASI = $fmKEPEMILIKAN.".".$Main->Provinsi[0].".00.".$fmSKPD . "." .$fmUNIT . "."  .$fmSUBUNIT;


if(!empty($fmCariComboIsi) && !empty($fmCariComboField)){
	$Kondisi .= " and $fmCariComboField like '%$fmCariComboIsi%' ";
}
if(!empty($fmTahunPerolehan)){
	$Kondisi .= " and thn_perolehan = '$fmTahunPerolehan' ";
}

//$Kondisi.= " and status_barang=1 ";
$Kondisi .=  ' and status_barang <> 3 ';


$KondisiTotal = $Kondisi;
$jmlTotalHarga = mysql_query("select sum(jml_harga) as total  from view_kib_a where $KondisiTotal ");
if($jmlTotalHarga = mysql_fetch_array($jmlTotalHarga)){
	$jmlTotalHarga = $jmlTotalHarga[0];
}else{$jmlTotalHarga=0;}



$Qry = mysql_query("select * from view_kib_a where $Kondisi order by $Urutkan a1,a,b,c,d,e,f,g,h,i,j,tahun,noreg ");
$jmlDataKIB_A = mysql_num_rows($Qry);
$Qry = mysql_query("select * from view_kib_a where $Kondisi order by $Urutkan a1,a,b,c,d,e,f,g,h,i,j,tahun,noreg  $LimitHalKIB_A");

$no=$Main->PagePerHal * (($HalKIB_A*1) - 1);
$cb=0;
$jmlTampilKIB_A = 0;
$JmlTotalHargaListKIB_A = 0;
$ListBarangKIB_A = "";
PrintSKPD();
PrintTTD();

$ListBarangKIB_A =list_header($SKPD,$UNIT,$SUBUNIT,$WILAYAH,'JAWA BARAT',$KODELOKASI).
list_tableheader($cbxDlmRibu);
if ($jmlDataKIB_A<1) {
$ListBarangKIB_A .= list_table();	
}

$maxrow=1000;
$tmpfile=0;

if ($jmlData>$maxrow) {
$tmpfname = tempnam(sys_get_temp_dir(), 'Tux');	
$handle = fopen($tmpfname, "w+");
fwrite($handle, $ListBarangKIB_A);

$tmpfile=1;
$bufftmp="";
$ListBarangKIB_A = "";

// echo $temp_file;

}


while ($isi = mysql_fetch_array($Qry))
{
	$kota='';
	if (!($isi['alamat_b'] == '' || $isi['alamat_b'] =='00' )){
		$sidBi = 'select nm_wilayah from ref_wilayah where a="'.$isi['alamat_a'].'" and b="'.$isi['alamat_b'].'"'; $cek .= '<br> qrkota='.$sidBi;
		$kota = '<br>'.table_get_value( $sidBi, 'nm_wilayah');
	}
	$Kec = table_get_value('select alamat_kec from kib_a where concat(a1,a,b,c,d,e,f,g,h,i,j,noreg) = "'.
			$isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['noreg'].'"','alamat_kec');
	$Kel = table_get_value('select alamat_kel from kib_a where concat(a1,a,b,c,d,e,f,g,h,i,j,noreg) = "'.
			$isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['noreg'].'"','alamat_kel');
	if($Kec != ''){ $Kec='<br>Kec. '.$Kec;}
	if($Kel != ''){ $Kel='<br>Kel. '.$Kel;}
	
	
	$ISI1 = $Main->StatusHakPakai[$isi['status_hak']-1][1];
	$ISI2 = TglInd($isi['sertifikat_tgl']);
	$ISI3 = $isi['sertifikat_no']; 
	$ISI4 = $isi['penggunaan'];
	$ISI5 = $Main->AsalUsul[$isi['asal_usul']-1][1];
	$ISI6 = $Main->StatusBarang[$isi['status_barang']-1][1];
	$ISI8 = $isi['ket'];
	$ISI9 = $dok;
	$ISI10 = $isi['alamat'];
	
	$ISI1 	= !empty($ISI1)?$ISI1:"-";
	$ISI2 	= !($ISI2=='00-00-0000')?$ISI2:"-";
	$ISI3 	= !empty($ISI3)?$ISI3:"-";
	$ISI4 	= !empty($ISI4)?$ISI4:"-";
	$ISI5 	= !empty($ISI5)?$ISI5:"-";
	$ISI6 	= !empty($ISI6)?$ISI6:"-";
	$ISI7 	= !empty($ISI7)?$ISI7:"-";
	$ISI8 	= !empty($ISI8)?$ISI8:"-";
	$ISI9 	= !empty($ISI9)?$ISI9:"-";
	$ISI10 = !empty($ISI10)?$ISI10:"-";
	
	$jmlTampilKIB_A++;
	$JmlTotalHargaListKIB_A += $isi['jml_harga'];
	$no++;
	$clRow = $no % 2 == 0 ?"row1":"row0";
	
	$tampilHarga = !empty($cbxDlmRibu)? $isi['jml_harga']/1000 : $isi['jml_harga'];
	
	if ($tmpfile==1)
	{

	$bufftmp .= list_table($no,$isi['id_barang'],$isi['noreg'],$isi['nm_barang'],$isi['luas'],
	$isi['thn_perolehan'],	$ISI10.$Kel.$Kec.$kota,$ISI1,$ISI2,$ISI3,$ISI4,$ISI5,
	$tampilHarga,$ISI8);
		
	} else {
	
	$ListBarangKIB_A .= list_table($no,$isi['id_barang'],$isi['noreg'],$isi['nm_barang'],$isi['luas'],
	$isi['thn_perolehan'],	$ISI10.$Kel.$Kec.$kota,$ISI1,$ISI2,$ISI3,$ISI4,$ISI5,
	$tampilHarga,$ISI8);	
	}
	$cb++;
	if (($cb % $maxrow ==1) & ($cb != 1) & ($tmpfile==1)){
	fwrite($handle, $bufftmp);
	$bufftmp ="";	
	}
		
}

$tampilTotalHal =  !empty($cbxDlmRibu)? number_format(($JmlTotalHargaListKIB_A/1000), 0, ',', '.'):number_format(($JmlTotalHargaListKIB_A), 0, ',', '.');
$tampilTotal = !empty($cbxDlmRibu)? number_format(($jmlTotalHarga/1000), 0, ',', '.'): number_format(($jmlTotalHarga), 0, ',', '.');

$tampilTotal = !empty($cbxDlmRibu)? $JmlTotalHargaListKIB_A/1000 : $JmlTotalHargaListKIB_A;

$ArFieldCari = array(
array('nm_barang','Nama Barang'),
array('thn_perolehan','Tahun Pengadaan'),
array('alamat','Letak/Alamat'),
array('ket','Keterangan')
);

if ($tmpfile==1){
$bufftmp .= listbi_tablefooter($tampilTotal,$cbxDlmRibu).listbi_footer($TITIMANGSA,$JABATANSKPD,$NAMASKPD,$NIPSKPD,$JABATANSKPD1,$NAMASKPD1,$NIPSKPD1);
fwrite($handle, $bufftmp);
fclose($handle);
$sdata = intval(sprintf("%u", filesize($tmpfname)));

// $sdata = filesize($tmpfname);
header('Content-length: $sdata');
if ($sdata < 2 * 1024*1024){
header("Content-Type: application/vnd.ms-excel"); 	
}
header('Content-disposition: attachment; filename="Kartu Inventaris Barang (KIB) A - TANAH.xls"');


// If it's a large file, readfile might not be able to do it in one go, so:
$chunksize = 1 * (1024 * 1024); // how many bytes per chunk
if ($sdata > $chunksize) {
  $handle = fopen($tmpfname, 'rb');
  $bufftmp = '';
  while (!feof($handle)) {
    $bufftmp = fread($handle, $chunksize);
    echo $bufftmp;
    ob_flush();
    flush();
  }
  fclose($handle);
} 
		
} else {

$ListBarangKIB_A  .= list_tablefooter($tampilTotal,$cbxDlmRibu);
$ListBarangKIB_A .= list_footer($TITIMANGSA,$JABATANSKPD,$NAMASKPD,$NIPSKPD,$JABATANSKPD1,$NAMASKPD1,$NIPSKPD1);


$Main->Isi = $ListBarangKIB_A;
$sdata = sizeof($Main->Isi);
    header('Content-length: $sdata');
	header("Content-Type: application/vnd.ms-excel"); 
    header('Content-disposition: attachment; filename="Kartu Inventaris Barang (KIB) A - TANAH.xls"');
}
?>