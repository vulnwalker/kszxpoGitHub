<?php
if($Main->MODUL_PEMBUKUAN){
	$menuLogImport = PanelIcon($Link="pages.php?Pg=DaftarImport",$Image="sections.png",$Isi="Daftar Import");	
}
$Main->Isi="
<table border=0 cellspacing=4 width=50%>
	<tr>
	<td valign=top>
		<table border=0 cellspacing=0 width=100% class=\"adminform\">
			<tr><th colspan=4>INPUT DATA</th></tr>
			<tr><td valign=top>
				".
				//PanelIcon($Link="?Pg=$Pg&SPg=01#ISIAN",$Image="sections.png",$Isi="Administrasi User").
				PanelIcon($Link="pages.php?Pg=usermanajemen",$Image="module.png",$Isi="Administrasi User").
				PanelIcon($Link="pages.php?Pg=useraktivitas",$Image="sections.png",$Isi="User Online").
				PanelIcon($Link="pages.php?Pg=refmigrasi",$Image="sections.png",$Isi="Migrasi").
				PanelIcon($Link="pages.php?Pg=settingDev",$Image="sections.png",$Isi="Pengaturan Development")."			
				</td>
				<td valign=top>
				".PanelIcon($Link="pages.php?Pg=backup",$Image="sections.png",$Isi="Export/Backup Data").
				PanelIcon($Link="pages.php?Pg=refclosingdata",$Image="sections.png",$Isi="Closing Data").
				PanelIcon($Link="pages.php?Pg=refperbandinganhasil",$Image="sections.png",$Isi="Perbandingan Hasil")."
				
				<td>
				<td valign=top>
				".PanelIcon($Link="pages.php?Pg=refdatalra",$Image="sections.png",$Isi="Data LRA").
				PanelIcon($Link="pages.php?Pg=ManagementPengguna",$Image="sections.png",$Isi="Management Pengguna").
				"
				$menuLogImport
				</td>
			</tr>
		</table>
	</td>
	</tr>
</table>

		";
// 				".PanelIcon($Link="?Pg=$Pg&SPg=03#ISIAN",$Image="sections.png",$Isi="Import/Restore Data")."

?>