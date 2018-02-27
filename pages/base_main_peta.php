<?php
//$Main->REF_URUSAN = 1;
if ($Main->REF_URUSAN == 1){
$Vref_urusan= PanelIcon($Link="pages.php?Pg=ref_urusan",$Image="module.png",$Isi="Referensi Urusan");
} else{
	$Vref_urusan = '';
}
//$Main->REFSKPD_URUSAN = 1;
if ($Main->REF_URUSAN == 1){
$Vrefskpd_urusan= PanelIcon($Link="pages.php?Pg=refskpd_urusan",$Image="module.png",$Isi="Mapping SKPD Keuangan");
} else{
	$Vrefskpd_urusan = '';
}

$Main->Isi=
"<table border=0  width=500>
	<tr>
	<td valign=top>".
		
		"<table border=0 cellspacing=0 width=100% class=\"adminform\" style='margin:10'>
			<tr><th colspan=2 style='height:35'>REFERENSI</th></tr>
			<tr>
				<td  valign=top style='padding:10'>".				
					PanelIcon($Link="index.php?Pg=Admin",$Image="module.png",$Isi="Administrasi").
					"</td><td style='padding:10'>".
					PanelIcon($Link="index.php?Pg=ref",$Image="module.png",$Isi="Master Data").									
				"</td>
				
			</tr>
		</table>".
	"</td>
	</tr>
	<tr>
	<td>".
		"<table border=0 cellspacing=0 width=100% class=\"adminform\" style='margin:10'>
			<tr><th colspan=2 style='height:35'>PENATAUSAHAAN<br></th></tr>
			<tr>
				<td  valign=top style='padding:10'>".				
					PanelIcon($Link="index.php?Pg=05&SPg=04",$Image="module.png",$Isi="KIB A").
					"</td><td style='padding:10'>".
					PanelIcon($Link="index.php?Pg=05&SPg=06",$Image="module.png",$Isi="KIB C").									
				"</td>
				</tr>
		</table>".
	"</td>
	</tr>
	<tr>
	<td>".
		"<table border=0 cellspacing=0 width=100% class=\"adminform\" style='margin:10'>
			<tr><th colspan='' style='height:35'>PETA SEBARAN</th></tr>
			<tr>
				<td  valign=top style='padding:10'>".				
					PanelIcon($Link="pages.php?Pg=map&SPg=03",$Image="module.png",$Isi="Peta").
					//PanelIcon($Link="pages.php?Pg=ref_sumberdana",$Image="module.png",$Isi="KIB C").									
				"</td>
				</tr>
		</table>".
		
	"</td>
	</tr>
</table>";
/**
"<table border=0 cellspacing=4 width=60%>
	<tr>
	<td valign=top>".
		
		"<table border=0 cellspacing=0 width=100% class=\"adminform\">
			<tr><th colspan=>ADMINISTRASI <br>& MASTER DATA</th></tr>
			<tr>
				<td width=10% valign=top>".				
					PanelIcon($Link="pages.php?Pg=ref_skpd",$Image="module.png",$Isi="Administrasi").
					PanelIcon($Link="pages.php?Pg=ref_sumberdana",$Image="module.png",$Isi="Master Data").									
				"</td>
				<td width=5% valign=top>".				
				"</td>
			</tr>
		</table>".
	"</td>
	<td>".
		"<table border=0 cellspacing=0 width=100% class=\"adminform\">
			<tr><th colspan=>PENATAUSAHAAN<br></th></tr>
			<tr>
				<td width=10% valign=top>".				
					PanelIcon($Link="pages.php?Pg=ref_skpd",$Image="module.png",$Isi="KIB A").
					PanelIcon($Link="pages.php?Pg=ref_sumberdana",$Image="module.png",$Isi="KIB C").									
				"</td>
				</tr>
		</table>".
	"</td>
	<td>".
		"<table border=0 cellspacing=0 width=100% class=\"adminform\">
			<tr><th colspan=>PETA <br>SEBARAN</th></tr>
			<tr>
				<td width=10% valign=top>".				
					PanelIcon($Link="pages.php?Pg=ref_skpd",$Image="module.png",$Isi="").
					//PanelIcon($Link="pages.php?Pg=ref_sumberdana",$Image="module.png",$Isi="KIB C").									
				"</td>
				</tr>
		</table>".
		
	"</td>
	</tr>
</table>";
**/
?>
