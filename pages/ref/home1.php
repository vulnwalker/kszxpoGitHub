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

$Main->Isi="
<table border=0 cellspacing=4 width=60%>
	<tr>
	<td valign=top>
		<table border=0 cellspacing=0 width=100% class=\"adminform\">
			<tr><th colspan=8>REFERENSI</th></tr>
			<tr><td width=10% valign=top>
				".
				//PanelIcon($Link="?Pg=$Pg&SPg=01#ISIAN",$Image="sections.png",$Isi="Referensi Barang").
				"
				".//PanelIcon($Link="?Pg=$Pg&SPg=02#ISIAN",$Image="sections.png",$Isi="Input Gudang").
				PanelIcon($Link="pages.php?Pg=ruang",$Image="module.png",$Isi="Referensi Ruang").
				PanelIcon($Link="pages.php?Pg=refKotaKec",$Image="module.png",$Isi="Referensi Kota/Kecamatan").
				//PanelIcon($Link="?Pg=$Pg&SPg=09#ISIAN",$Image="sections.png",$Isi="Referensi Ruang")
				//PanelIcon($Link="?Pg=$Pg&SPg=03#ISIAN",$Image="sections.png",$Isi="Input Rekening").
				//PanelIcon($Link="?Pg=$Pg&SPg=04#ISIAN",$Image="sections.png",$Isi="Input SKPD").
				PanelIcon($Link="pages.php?Pg=pegawai",$Image="module.png",$Isi="Referensi Pegawai").
				PanelIcon($Link="pages.php?Pg=refjurnal",$Image="module.png",$Isi="Referensi Akun").
				PanelIcon($Link="pages.php?Pg=ref_jenis_peneliharaan",$Image="module.png",$Isi="Referensi Jenis Pemeliharaan").
				
				"</td>
				<td width=5% valign=top>
				".
				
				"</td>
		<td width=10% valign=top>
		".PanelIcon($Link="pages.php?Pg=ref_skpd",$Image="module.png",$Isi="Referensi SKPD").
		PanelIcon($Link="pages.php?Pg=refskpd_urusan",$Image="module.png",$Isi="Referensi Mapping SKPD").
		//PanelIcon($Link="pages.php?Pg=refSKPD_Keuangan",$Image="module.png",$Isi="SKPD Keuangan").
		PanelIcon($Link="pages.php?Pg=refprogram",$Image="module.png",$Isi="Referensi Program Kegiatan").
		PanelIcon($Link="pages.php?Pg=ref_skpd_keuangan",$Image="module.png",$Isi="Referensi SKPD Keuangan").
		
			"</td>
				<td width=5% valign=top>
				".	
				//PanelIcon($Link="?Pg=$Pg&SPg=07#ISIAN",$Image="module.png",$Isi="Referensi Rekening").
				//PanelIcon($Link="?Pg=$Pg&SPg=08#ISIAN",$Image="module.png",$Isi="Referensi SKPD").
				
				
				
				
				//PanelIcon($Link="pages.php?Pg=$Pg&SPg=06#ISIAN",$Image="module.png",$Isi="Referensi Gudang").
				//"".
				//PanelIcon($Link="?Pg=$Pg&SPg=10#ISIAN",$Image="sections.png",$Isi="Referensi Pejabat").
				//PanelIcon($Link="?Pg=$Pg&SPg=05#ISIAN",$Image="module.png",$Isi="Referensi Barang").
		
		"
		".
		$Vref_urusan.
		$Vrefskpd_urusan.
        
		
		"</td>
		<td width=10% valign=top>
		".
		PanelIcon($Link="pages.php?Pg=ref_rekening",$Image="module.png",$Isi="Referensi Rekening").
		PanelIcon($Link="pages.php?Pg=refbarang",$Image="module.png",$Isi="Referensi Barang").
		PanelIcon($Link="pages.php?Pg=ref_penyusutan",$Image="module.png",$Isi="Referensi Penyusutan").
		PanelIcon($Link="pages.php?Pg=ref_gudang",$Image="module.png",$Isi="Referensi Gudang").
		//PanelIcon($Link="pages.php?Pg=refMapping_SKPD",$Image="module.png",$Isi="Mapping SKPD").
		
		
		"</td>
		<td width=10% valign=top>
		".
		PanelIcon($Link="pages.php?Pg=lra",$Image="module.png",$Isi="Referensi LRA").
		PanelIcon($Link="pages.php?Pg=refstandarharga",$Image="module.png",$Isi="Referensi Standar Harga").
		PanelIcon($Link="pages.php?Pg=ref_tandatangan",$Image="module.png",$Isi="Referensi Tanda Tangan").
		PanelIcon($Link="pages.php?Pg=reftambahmanfaat",$Image="module.png",$Isi="Referensi Tambah Manfaat").
		"</td>
		<td width=10% valign=top>
		".
		
		PanelIcon($Link="pages.php?Pg=ref_std_butuh",$Image="module.png",$Isi="Referensi Standar Kebutuhan Barang").
		PanelIcon($Link="pages.php?Pg=ref_kapitalisasi",$Image="module.png",$Isi="Referensi Kapitalisasi").
		PanelIcon($Link="pages.php?Pg=ref_sumberdana",$Image="module.png",$Isi="Referensi Sumber Dana").
		PanelIcon($Link="pages.php?Pg=ref_template",$Image="module.png",$Isi="Template Distribusi Barang").
		"</td>
		<td width=10% valign=top>
		".
		//PanelIcon($Link="pages.php?Pg=ref_skpd",$Image="module.png",$Isi="SKPD").
		
		"
		</td>
		</tr>
		</table>
	</td>
	</tr>
</table>


		";
?>
