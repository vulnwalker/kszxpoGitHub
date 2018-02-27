<?php
//$Main->REF_URUSAN = 1;




$Main->Isi="
<table border=0 cellspacing=4 width=60%>
	<tr>
	<td valign=top>
		<table border=0 cellspacing=0 width=100% class=\"adminform\">
			<tr><th colspan=8>PERENCANAAN</th></tr>
			<tr><td width=10% valign=top>
				".
				PanelIcon($Link="pages.php?Pg=settingperencanaan",$Image="module.png",$Isi="PENGATURAN").
				
				PanelIcon($Link="pages.php?Pg=renjaAset",$Image="module.png",$Isi="RENJA").
				PanelIcon($Link="pages.php?Pg=renjaAsetPerubahan",$Image="module.png",$Isi="RENJA PERUBAHAN").
				
				"</td>
				<td width=5% valign=top>
				".
				
				"</td>
		<td width=10% valign=top>
		".
		PanelIcon($Link="pages.php?Pg=tandaTanganKuasaPenggunaBarang_v3",$Image="module.png",$Isi="TANDA TANGAN").
		PanelIcon($Link="pages.php?Pg=rkbmdPengadaan_v3",$Image="module.png",$Isi="RKBMD KUASA/PENGGUNA").
		PanelIcon($Link="pages.php?Pg=rkbmdPengadaanPerubahan_v3",$Image="module.png",$Isi="RKBMD PERUBAHAN KUASA/PENGGUNA").
		
		
				
			"</td>
				<td width=5% valign=top>
				".	
		
		"
		".
		$Vref_urusan.
		$Vrefskpd_urusan.
        
		
		"</td>
		<td width=10% valign=top>
		".
		PanelIcon($Link="pages.php?Pg=ref_std_butuh",$Image="module.png",$Isi="STANDAR KEBUTUHAN MAKSIMAL").
		PanelIcon($Link="pages.php?Pg=koreksiPengelolaPengadaan",$Image="module.png",$Isi="RKBMD PENGELOLA").
		PanelIcon($Link="pages.php?Pg=koreksiPengelolaPengadaanPerubahan",$Image="module.png",$Isi="RKBMD PERUBAHAN PENGELOLA").
		
		"</td>
		

		
		

		
		
		

		</tr>
		<tr>
			<td width=10% valign=top>
		".
		PanelIcon($Link="index.php?Pg=perencanaan_v2",$Image="module.png",$Isi="KEUANGAN").
		
		"</td>
		
		</tr>
		</table>
	</td>
	</tr>
</table>


		";
?>