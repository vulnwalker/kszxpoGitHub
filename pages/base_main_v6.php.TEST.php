<?php
$Group =$HTTP_COOKIE_VARS['coGroup'];

$MyModulKU = explode(".",$HTTP_COOKIE_VARS["coModul"]);
// $disModul01 = $MyModulKU[0] == "0" ?"disabled":""; //penerimaan
// $disModul02 = $MyModulKU[1] == "0" ?"disabled":""; //distribusi
// $disModul03 = $MyModulKU[2] == "0" ?"disabled":""; //cek fisik 
// $disModul04 = $MyModulKU[3] == "0" ?"disabled":""; //persediaan
// $disModul05 = $MyModulKU[4] == "0" ?"disabled":""; //about
// $disModul06 = $MyModulKU[5] == "0" ?"disabled":""; //saldo awal
// $disModul07 = $MyModulKU[6] == "0" ?"disabled":""; //
// $disModul08 = $MyModulKU[7] == "0" ?"disabled":""; //
// $disModul09 = $MyModulKU[8] == "0" ?"disabled":""; //
// $disModul10 = $MyModulKU[9] == "0" ?"disabled":""; //
// $disModul11 = $MyModulKU[10] == "0" ?"disabled":""; //
// $disModul12 = $MyModulKU[11] == "0" ?"disabled":""; //
// $disModul13 = $MyModulKU[12] == "0" ?"disabled":""; //
// $disModulref = $MyModulKU[13] == "0" ?"disabled":""; //
// $disModuladm = $MyModulKU[14] == "0" ?"disabled":""; //
// $disModul13 = $MyModulKU[12] == "0" ?"disabled":""; //
// $disModulref = $MyModulKU[13] == "0" ?"disabled":""; //master data
// $disModuladm = $MyModulKU[14] == "0" ?"disabled":""; //user manajemen
// $disModul14 = $MyModulKU[15] == "0" ?"disabled":"";
// $disModul15 = $MyModulKU[16] == "0" ?"disabled":"";
// $disModul16 = $MyModulKU[17] == "0" ?"disabled":"";
// $disModul17 = $MyModulKU[18] == "0" ?"disabled":"";
$disModul18 = $MyModulKU[19] == "0" ?"disabled":"";
$disModul19 = $MyModulKU[20] == "0" ?"disabled":"";
$disModul20 = $MyModulKU[21] == "0" ?"disabled":"";
$disModul21 = $MyModulKU[22] == "0" ?"disabled":"";
$disModul22 = $MyModulKU[23] == "0" ?"disabled":"";
$disModul23 = $MyModulKU[24] == "0" ?"disabled":"";
$disModul24 = $MyModulKU[25] == "0" ?"disabled":"";
$disModul25 = $MyModulKU[26] == "0" ?"disabled":"";
$disModul26 = $MyModulKU[27] == "0" ?"disabled":"";


// $ridModul01 = $MyModulKU[0] == "2" ?"ReadONLY":"";
// $ridModul02 = $MyModulKU[1] == "2" ?"ReadONLY":"";
// $ridModul03 = $MyModulKU[2] == "2" ?"ReadONLY":"";
// $ridModul04 = $MyModulKU[3] == "2" ?"ReadONLY":"";
// $ridModul05 = $MyModulKU[4] == "2" ?"ReadONLY":"";
// $ridModul06 = $MyModulKU[5] == "2" ?"ReadONLY":"";
// $ridModul07 = $MyModulKU[6] == "2" ?"ReadONLY":"";
// $ridModul08 = $MyModulKU[7] == "2" ?"ReadONLY":"";
// $ridModul09 = $MyModulKU[8] == "2" ?"ReadONLY":"";
// $ridModul10 = $MyModulKU[9] == "2" ?"ReadONLY":"";
// $ridModul11 = $MyModulKU[10] == "2" ?"ReadONLY":"";
// $ridModul12 = $MyModulKU[11] == "2" ?"ReadONLY":"";
// $ridModul13 = $MyModulKU[12] == "2" ?"ReadONLY":"";
// $ridModulref = $MyModulKU[13] == "2" ?"ReadONLY":"";
// $ridModuladm = $MyModulKU[14] == "2" ?"ReadONLY":"";
// $ridModul14 = $MyModulKU[15] == "2" ?"ReadONLY":"";
// $ridModul15 = $MyModulKU[16] == "2" ?"ReadONLY":"";
// $ridModul16 = $MyModulKU[17] == "2" ?"ReadONLY":"";
// $ridModul17 = $MyModulKU[18] == "2" ?"ReadONLY":"";
$ridModul18 = $MyModulKU[19] == "2" ?"ReadONLY":"";
$ridModul19 = $MyModulKU[20] == "2" ?"ReadONLY":"";
$ridModul20 = $MyModulKU[21] == "2" ?"ReadONLY":"";
$ridModul21 = $MyModulKU[22] == "2" ?"ReadONLY":"";
$ridModul22 = $MyModulKU[23] == "2" ?"ReadONLY":"";
$ridModul23 = $MyModulKU[24] == "2" ?"ReadONLY":"";
$ridModul24 = $MyModulKU[25] == "2" ?"ReadONLY":"";
$ridModul25 = $MyModulKU[26] == "2" ?"ReadONLY":"";
$ridModul26 = $MyModulKU[27] == "2" ?"ReadONLY":"";

 //penerimaan barang
// if ($MyModulKU[0] == "1" || $MyModulKU[0] == "2" ){
// 	$modulku[0]->link="pages.php?Pg=penerimaanbarang";
// 	$modulku[0]->style="";
// 	$modulku[0]->data_page="r-page";
// } else {
// 	$modulku[0]->link="";
// 	$modulku[0]->style="tile_disable";
// 	$modulku[0]->data_page="d-page";
// }

//distribusi barang
// if ($MyModulKU[1] == "1" || $MyModulKU[1] == "2" ){
// 	$modulku[1]->link="pages.php?Pg=pengeluaran";
// 	$modulku[1]->style="";
// 	$modulku[1]->data_page="r-page";
// } else {
// 	$modulku[1]->link="";
// 	$modulku[1]->style="tile_disable";
// 	$modulku[1]->data_page="d-page";
// }

//cekfisik
// if ($MyModulKU[2] == "1" || $MyModulKU[2] == "2" ){
// 	$modulku[2]->link="pages.php?Pg=cek_fisik";
// 	$modulku[2]->style="";
// 	$modulku[2]->data_page="r-page";
// } else {
// 	$modulku[2]->link="";
// 	$modulku[2]->style="tile_disable";
// 	$modulku[2]->data_page="d-page";
// }

//persediaan barang
// if ($MyModulKU[3] == "1" || $MyModulKU[3] == "2" ){	
//     $modulku[3]->link="pages.php?Pg=persediaan";
// 	$modulku[3]->style="";
// 	$modulku[3]->data_page="r-page";
// } else {
// 	$modulku[3]->link="";
// 	$modulku[3]->style="tile_disable";
// 	$modulku[3]->data_page="d-page";
// }

//about
// if ($MyModulKU[4] == "1" || $MyModulKU[4] == "2" ){	
//     $modulku[4]->link="pages.php?Pg=saldoawal";
// 	$modulku[4]->style="";
// 	$modulku[4]->data_page="r-page";
// } else {
// 	$modulku[4]->link="";
// 	$modulku[4]->style="tile_disable";
// 	$modulku[4]->data_page="d-page";
// }

//saldo awal
// if ($MyModulKU[5] == "1" || $MyModulKU[5] == "2" ){ 
//     $modulku[5]->link="pages.php?Pg=saldoAwal";
//   $modulku[5]->style="";
//   $modulku[5]->data_page="r-page";
// } else {
//   $modulku[5]->link="";
//   $modulku[5]->style="tile_disable";
//   $modulku[5]->data_page="d-page";
// }

// if ($MyModulKU[7] == "1" || $MyModulKU[7] == "2"  ){
//   if ($Group <> '0.00.00.00.000'){
//     $modulku[7]->link="pages.php?Pg=";
//   }else{
//     $modulku[7]->link="pages.php?Pg=";
//   }
  
//   $modulku[7]->style="";
//   $modulku[7]->data_page="r-page";
// }else{
//   $modulku[7]->link="";
//   $modulku[7]->style="tile_disable";
//   $modulku[7]->data_page="d-page";
// }

// if ($MyModulKU[8] == "1" || $MyModulKU[8] == "2"  ){
//   if ($Group <> '0.00.00.00.000'){
//     $modulku[8]->link="pages.php?Pg=";
//   }else{
//     $modulku[8]->link="pages.php?Pg=";
//   }
  
//   $modulku[8]->style="";
//   $modulku[8]->data_page="r-page";
// }else{
//   $modulku[8]->link="";
//   $modulku[8]->style="tile_disable";
//   $modulku[8]->data_page="d-page";
// }

// if ($MyModulKU[9] == "1" || $MyModulKU[9] == "2"  ){
//   if ($Group <> '0.00.00.00.000'){
//     $modulku[9]->link="pages.php?Pg=";
//   }else{
//     $modulku[9]->link="pages.php?Pg=";
//   }
  
//   $modulku[9]->style="";
//   $modulku[9]->data_page="r-page";
// }else{
//   $modulku[9]->link="";
//   $modulku[9]->style="tile_disable";
//   $modulku[9]->data_page="d-page";
// }

// if ($MyModulKU[10] == "1" || $MyModulKU[10] == "2"  ){
//   if ($Group <> '0.00.00.00.000'){
//     $modulku[10]->link="pages.php?Pg=";
//   }else{
//     $modulku[10]->link="pages.php?Pg=";
//   }
  
//   $modulku[10]->style="";
//   $modulku[10]->data_page="r-page";
// }else{
//   $modulku[10]->link="";
//   $modulku[10]->style="tile_disable";
//   $modulku[10]->data_page="d-page";
// }

// if ($MyModulKU[11] == "1" || $MyModulKU[11] == "2"  ){
//   if ($Group <> '0.00.00.00.000'){
//     $modulku[11]->link="pages.php?Pg=";
//   }else{
//     $modulku[11]->link="pages.php?Pg=";
//   }
  
//   $modulku[11]->style="";
//   $modulku[11]->data_page="r-page";
// }else{
//   $modulku[11]->link="";
//   $modulku[11]->style="tile_disable";
//   $modulku[11]->data_page="d-page";
// }

// if ($MyModulKU[12] == "1" || $MyModulKU[12] == "2"  ){
//   if ($Group <> '0.00.00.00.000'){
//     $modulku[12]->link="pages.php?Pg=";
//   }else{
//     $modulku[12]->link="pages.php?Pg=";
//   }
  
//   $modulku[12]->style="";
//   $modulku[12]->data_page="r-page";
// }else{
//   $modulku[12]->link="";
//   $modulku[12]->style="tile_disable";
//   $modulku[12]->data_page="d-page";
// }

// //master data
// if ($MyModulKU[13] == "1" || $MyModulKU[13] == "2"  ){
// 	if ($Group <> '0.00.00.00.000'){
// 		$modulku[13]->link="pages.php?Pg=refpegawai";
// 	}else{
// 		$modulku[13]->link="pages.php?Pg=barang";
// 	}
	
// 	$modulku[13]->style="";
// 	$modulku[13]->data_page="r-page";
// }else{
// 	$modulku[13]->link="";
// 	$modulku[13]->style="tile_disable";
// 	$modulku[13]->data_page="d-page";
// }

// //usermanajemen
// if ($MyModulKU[14] == "1" || $MyModulKU[14] == "2" ){
//   if ($Group <> '0.00.00.00.000') {
//     $modulku[14]->link="pages.php?Pg=usermanajemen";
//   }else{
//     $modulku[14]->link="pages.php?Pg=";
//   }
	
// 	$modulku[14]->style="";
// 	$modulku[14]->data_page="r-page";	
// } else {
// 	$modulku[14]->link="";
// 	$modulku[14]->style="tile_disable";
// 	$modulku[14]->data_page="d-page";
// }

// if ($MyModulKU[15] == "1" || $MyModulKU[15] == "2"  ){
//   if ($Group <> '0.00.00.00.000'){
//     $modulku[15]->link="pages.php?Pg=";
//   }else{
//     $modulku[15]->link="pages.php?Pg=";
//   }
  
//   $modulku[15]->style="";
//   $modulku[15]->data_page="r-page";
// }else{
//   $modulku[15]->link="";
//   $modulku[15]->style="tile_disable";
//   $modulku[15]->data_page="d-page";
// }

// if ($MyModulKU[16] == "1" || $MyModulKU[16] == "2"  ){
//   if ($Group <> '0.00.00.00.000'){
//     $modulku[16]->link="pages.php?Pg=";
//   }else{
//     $modulku[16]->link="pages.php?Pg=";
//   }
  
//   $modulku[16]->style="";
//   $modulku[16]->data_page="r-page";
// }else{
//   $modulku[16]->link="";
//   $modulku[16]->style="tile_disable";
//   $modulku[16]->data_page="d-page";
// }

if ($MyModulKU[19] == "1" || $MyModulKU[19] == "2"  ){
    $modulku[19]->link="pages.php?Pg=saldoAwal";
  $modulku[19]->style="";
  $modulku[19]->data_page="r-page";
}else{
  $modulku[19]->link="";
  $modulku[19]->style="tile_disable";
  $modulku[19]->data_page="d-page";
}

if ($MyModulKU[20] == "1" || $MyModulKU[20] == "2"  ){
    $modulku[20]->link="pages.php?Pg=renjaAset&modul=persediaan";
  $modulku[20]->style="";
  $modulku[20]->data_page="r-page";
}else{
  $modulku[20]->link="";
  $modulku[20]->style="tile_disable";
  $modulku[20]->data_page="d-page";
}

if ($MyModulKU[21] == "1" || $MyModulKU[21] == "2"  ){
    $modulku[21]->link="pages.php?Pg=pemasukan&halman=3";
  $modulku[21]->style="";
  $modulku[21]->data_page="r-page";
}else{
  $modulku[21]->link="";
  $modulku[21]->style="tile_disable";
  $modulku[21]->data_page="d-page";
}

if ($MyModulKU[22] == "1" || $MyModulKU[22] == "2"  ){
    $modulku[22]->link="pages.php?Pg=pengeluaranPersediaan";
  $modulku[22]->style="";
  $modulku[22]->data_page="r-page";
}else{
  $modulku[22]->link="";
  $modulku[22]->style="tile_disable";
  $modulku[22]->data_page="d-page";
}

if ($MyModulKU[23] == "1" || $MyModulKU[23] == "2"  ){
    $modulku[23]->link="pages.php?Pg=distribusiPersediaan";
  $modulku[23]->style="";
  $modulku[23]->data_page="r-page";
}else{
  $modulku[23]->link="";
  $modulku[23]->style="tile_disable";
  $modulku[23]->data_page="d-page";
}

if ($MyModulKU[24] == "1" || $MyModulKU[24] == "2"  ){
    $modulku[24]->link="pages.php?Pg=cekFisik";
  $modulku[24]->style="";
  $modulku[24]->data_page="r-page";
}else{
  $modulku[24]->link="";
  $modulku[24]->style="tile_disable";
  $modulku[24]->data_page="d-page";
}

if ($MyModulKU[25] == "1" || $MyModulKU[25] == "2"  ){
    $modulku[25]->link="pages.php?Pg=pemusnahanPersediaan";
  $modulku[25]->style="";
  $modulku[25]->data_page="r-page";
}else{
  $modulku[25]->link="";
  $modulku[25]->style="tile_disable";
  $modulku[25]->data_page="d-page";
}

if ($MyModulKU[26] == "1" || $MyModulKU[26] == "2"  ){
    $modulku[26]->link="pages.php?Pg=daftarPersediaanBarang";
  $modulku[26]->style="";
  $modulku[26]->data_page="r-page";
}else{
  $modulku[26]->link="";
  $modulku[26]->style="tile_disable";
  $modulku[26]->data_page="d-page";
}

if ($MyModulKU[27] == "1" || $MyModulKU[27] == "2"  ){
    $modulku[27]->link="pages.php?Pg=pelaporanPersediaan";
  $modulku[27]->style="";
  $modulku[27]->data_page="r-page";
}else{
  $modulku[27]->link="";
  $modulku[27]->style="tile_disable";
  $modulku[27]->data_page="d-page";
}

$Main->Base = 
"<html>
<head>
  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\" />
  <meta name='format-detection' content='telephone=no' />
  <META NAME='ROBOTS' CONTENT='NOINDEX, NOFOLLOW' />  
  <title><!--JUDUL--> {$HTTP_COOKIE_VARS['coNama']}</title>
  <style>
	body {
		background-image: url(imagess/pattern_abu.jpg);
	}
	.text {
		font-family: Verdana;
		font-size: 11px;
		font-style: normal;
		color: #FFF;
	}
  </style>	
  <script type=\"text/javascript\">
  	function MM_preloadimagess() { //v3.0
	  	var d=document; if(d.imagess){ if(!d.MM_p) d.MM_p=new Array();
	    var i,j=d.MM_p.length,a=MM_preloadimagess.arguments; for(i=0; i<a.length; i++)
	    if (a[i].indexOf(\"#\")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
	}
	function MM_swapImgRestore() { //v3.0
  		var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
	}
	function MM_findObj(n, d) { //v4.01
		var p,i,x;  if(!d) d=document; if((p=n.indexOf(\"?\"))>0&&parent.frames.length) {
		d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
		if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
		for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
		if(!x && d.getElementById) x=d.getElementById(n); return x;
	}
	function MM_swapImage() { //v3.0
		var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
		if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
	}	
   </script>
</head>
<body onload=\"MM_preloadimagess('imagess/index2_14.jpg','imagess/index2_10.jpg','imagess/index2_20.jpg','imagess/index2_22.jpg','imagess/index2_31.jpg','imagess/index2_32.jpg','imagess/index2_24.jpg')\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<tr>
	<td width=\"1367\">
	<table table width=\"1000\" border=\"0\" align=\"center\">
		<tr>
			<td colspan=\"3\" valign=\"bottom\"><img src=\"imagess/index_07.png\" width=\"598\" height=\"82\"></td> 
			<td>&nbsp;</td>
			<td > <!-- <img src=\"imagess/logo.png\" alt=\"\"  width=\"101\" height=\"113\" /> -->	</td>
		</tr>
		<tr>
      <td>
        <a href=\"".$modulku[19]->link."\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('bt_about','','imagess/index2_24.jpg',1)\">
          <img src=\"imagess/index_24.jpg\" id=\"bt_about\" />
        </a>
      </td>
      <td colspan=\"2\">
        <a href=\"".$modulku[20]->link."\" onmouseout=\"MM_swapImgRestore()\" )\">
          <img src=\"imagess/index_12-1.jpg\" width=\"397\" height=\"164\" />
        </a>
      </td>
      <td rowspan=\"2\">
        <a href=\"".$modulku[21]->link."\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('bt_penerimaan','','imagess/index2_10.jpg',1)\"><img src=\"imagess/index_10.jpg\" id=\"bt_penerimaan\" />
        </a>
      </td>
      <td>
        <img src=\"imagess/index_14-1.jpg\" id=\"bt_master\" />
      </td>
    </tr>

  	<tr>
      <td>
        <a href=\"".$modulku[22]->link."\" onmouseout=\"MM_swapImgRestore()\">
          <img src=\"imagess/index_23-1.jpg\" width=\"196\" height=\"163\" />
        </a>
      </td>
  		<td rowspan=\"2\">
        <a href=\"".$modulku[23]->link."\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('bt_distribusi','','imagess/index2_20.jpg',1)\">
          <img src=\"imagess/index_20.jpg\" id=\"bt_distribusi\" />
        </a>
      </td>		
    	<td>
        <a href=\"".$modulku[24]->link."\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('bt_cek','','imagess/index2_22.jpg',1)\">
          <img src=\"imagess/index_22.jpg\" id=\"bt_cek\" />
        </a>
      </td>
      <td>
        <a href=\"".$modulku[25]->link."\" onmouseout=\"MM_swapImgRestore()\">
          <img src=\"imagess/index_29-1.jpg\" width=\"196\" height=\"164\" />
        </a>
      </td>
  	</tr>

  	<tr>
	    <td>
        <img src=\"imagess/index_31-1.png\" id=\"bt_user\">
      </td>
      <td>
        <a href=\"".$modulku[26]->link."\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('bt_persediaan','','imagess/index2_30.jpg',1)\">
          <img src=\"imagess/index_30.jpg\" id=\"bt_persediaan\" />
        </a>
      </td>
      <td>
        <a href=\"".$modulku[27]->link."\" onmouseout=\"MM_swapImgRestore()\" >
          <img src=\"imagess/index_16-1.jpg\" width=\"196\" height=\"164\" />
        </a>
      </td>
      <td>
        <a href=\"?Pg=LogOut\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('bt_logout','','imagess/index2_32.jpg',1)\">
          <img src=\"imagess/index_32.jpg\" id=\"bt_logout\" />
        </a>
      </td>
  	</tr>
  	<tr>
    	<td colspan=\"5\" class=\"text\"><marquee scrollamount=\"3\">Copyright © 2016. SIAP (Sistem Informasi Aplikasi Persediaan) PT Pilar Wahana Artha Bandung. </marquee></td>
    </tr>
</table>
	</td>
</tr>
</table>
  <!--<script src=\"js/jquery-1.8.2.min.js\"></script>
  <script src=\"js/scripts.js\"></script>-->
</body>
</html>
";
?>