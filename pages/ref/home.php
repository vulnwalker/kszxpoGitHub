<?php
//$Main->REF_URUSAN = 1;
//if ($Main->REF_URUSAN == 1){
$Vref_urusan= PanelIcon($Link="pages.php?Pg=refurusan",$Image="module.png",$Isi="Referensi Urusan");
//} else{
//	$Vref_urusan = '';
//}
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
			<tr><th colspan=8>REFERENSI GENERAL</th></tr>
			<tr><td width=10% valign=top>".

				"
				".
				PanelIcon($Link="pages.php?Pg=ref_skpd",$Image="module.png",$Isi="Referensi SKPD").
				PanelIcon($Link="pages.php?Pg=ref_sumberdana",$Image="module.png",$Isi="Referensi Sumber Dana").


				"</td>
				<td width=5% valign=top>
				".

				"</td>
		<td width=10% valign=top>
		".
		PanelIcon($Link="pages.php?Pg=ref_rekening",$Image="module.png",$Isi="Referensi Rekening").
		PanelIcon($Link="pages.php?Pg=ref_dokumen_sumber",$Image="module.png",$Isi="Referensi Dokumen Sumber").


			"</td>
				<td width=5% valign=top>
				".


		"
		".
		$Vref_urusan.
		$Vrefskpd_urusan.
		PanelIcon($Link="pages.php?Pg=ref_perda",$Image="module.png",$Isi="Referensi Peraturan Daerah").


		"</td>
		<td width=10% valign=top>
		".
		PanelIcon($Link="pages.php?Pg=refakun",$Image="module.png",$Isi="Referensi Akun").
		PanelIcon($Link="pages.php?Pg=ref_korolari",$Image="module.png",$Isi="Referensi Korolari").



		"</td>
		<td width=10% valign=top>
		".

		PanelIcon($Link="pages.php?Pg=ref_masa_manfaat",$Image="module.png",$Isi="Referensi Masa Manfaat").
		PanelIcon($Link="pages.php?Pg=refprogram",$Image="module.png",$Isi="Referensi Program Kegiatan").
		

		"</td>".

		"<td width=10% valign=top>
		".

		"</td>
		<td width=10% valign=top>
		".

		//PanelIcon($Link="pages.php?Pg=ref_skpd",$Image="module.png",$Isi="SKPD").

		"
		</td>
		</tr>
		</table>

		<br>

		<table border=0 cellspacing=0 width=100% class=\"adminform\">
			<tr><th colspan=8>REFERENSI ASET</th></tr>
			<tr><td width=10% valign=top>
				".
				//PanelIcon($Link="?Pg=$Pg&SPg=01#ISIAN",$Image="sections.png",$Isi="Referensi Barang").
				"
				".//PanelIcon($Link="?Pg=$Pg&SPg=02#ISIAN",$Image="sections.png",$Isi="Input Gudang").
				PanelIcon($Link="pages.php?Pg=ref_penyusutan",$Image="module.png",$Isi="Referensi Penyusutan").
				PanelIcon($Link="pages.php?Pg=ref_std_butuh",$Image="module.png",$Isi="Referensi Standar Kebutuhan Barang").
				PanelIcon($Link="pages.php?Pg=ref_dokumen_kontrak",$Image="module.png",$Isi="Referensi Dokumen Kontrak").



				"</td>
				<td width=5% valign=top>
				".

				"</td>
		<td width=10% valign=top>
		".
		PanelIcon($Link="pages.php?Pg=ref_kapitalisasi",$Image="module.png",$Isi="Referensi Kapitalisasi").
		PanelIcon($Link="pages.php?Pg=ref_template",$Image="module.png",$Isi="Referensi Distribusi Barang").
		PanelIcon($Link="pages.php?Pg=ref_kategori_tandatangan",$Image="module.png",$Isi="Referensi Kategori Tanda Tangan").

			"</td>
				<td width=5% valign=top>
				".


		"
		".
		//$Vref_urusan.
		//$Vrefskpd_urusan.


		"</td>
		<td width=10% valign=top>
		".
		PanelIcon($Link="pages.php?Pg=ref_jenis_peneliharaan",$Image="module.png",$Isi="Referensi Jenis Pemeliharaan").
		PanelIcon($Link="pages.php?Pg=pegawai",$Image="module.png",$Isi="Referensi Pegawai").
		PanelIcon($Link="pages.php?Pg=refbarang",$Image="module.png",$Isi="Referensi Barang").



		"</td>
		<td width=10% valign=top>
		".
		PanelIcon($Link="pages.php?Pg=reftambahmanfaat",$Image="module.png",$Isi="Referensi Tambah Manfaat").
		PanelIcon($Link="pages.php?Pg=ref_tandatangan",$Image="module.png",$Isi="Referensi Tanda Tangan").
		PanelIcon($Link="pages.php?Pg=mappingBarangAset",$Image="module.png",$Isi="Mapping Barang").

		"</td>
		<td width=10% valign=top>
		".
		PanelIcon($Link="pages.php?Pg=ruang",$Image="module.png",$Isi="Referensi Ruang").
		PanelIcon($Link="pages.php?Pg=refKotaKec",$Image="module.png",$Isi="Referensi Kota/Kecamatan").

		"</td>
		<td width=10% valign=top>
		".
		//PanelIcon($Link="pages.php?Pg=ref_skpd",$Image="module.png",$Isi="SKPD").

		"
		</td>
		</tr>
		</table>

		<br>

		<table border=0 cellspacing=0 width=100% class=\"adminform\">
			<tr><th colspan=8>REFERENSI KEUANGAN</th></tr>
			<tr><td width=10% valign=top>
				".
				//PanelIcon($Link="?Pg=$Pg&SPg=01#ISIAN",$Image="sections.png",$Isi="Referensi Barang").
				"
				".

			//	PanelIcon($Link="pages.php?Pg=ref_rekening_daerah",$Image="module.png",$Isi="Referensi Rekening Daerah").
				PanelIcon($Link="pages.php?Pg=ref_bank",$Image="module.png",$Isi="Referensi Bank").
				PanelIcon($Link="pages.php?Pg=ref_nm_pejabat_sp",$Image="module.png",$Isi="Referensi Nama Pejabat").
				PanelIcon($Link="pages.php?Pg=rincianBelanjaModal",$Image="module.png",$Isi="Referensi Rincian Belanja Modal").
				"</td>
				<td width=5% valign=top>
				".

				"</td>
		<td width=10% valign=top>
		".

		PanelIcon($Link="pages.php?Pg=ref_kelengkapan_dokumen",$Image="module.png",$Isi="Referensi Kelengkapan Dokumen").
		PanelIcon($Link="pages.php?Pg=ref_tim_anggaran",$Image="module.png",$Isi="Referensi Tim Anggaran").
		PanelIcon($Link="pages.php?Pg=rincianBelanjaBarangJasa",$Image="module.png",$Isi="Referensi Rincian Belanja Barang Jasa").

			"</td>
				<td width=5% valign=top>
				".


		"
		".
		//$Vref_urusan.
		//$Vrefskpd_urusan.


		"</td>
		<td width=10% valign=top>
		".

	//	PanelIcon($Link="pages.php?Pg=ref_sp_potongan",$Image="module.png",$Isi="Referensi Potongan").
		PanelIcon($Link="pages.php?Pg=ref_potongan",$Image="module.png",$Isi="Referensi Potongan").
		PanelIcon($Link="pages.php?Pg=ref_tagihan",$Image="module.png",$Isi="Referensi Tagihan").
		PanelIcon($Link="pages.php?Pg=ref_jenis_jurnal",$Image="module.png",$Isi="Referensi Jenis Jurnal").
		"</td>
		<td width=10% valign=top>
		".

		PanelIcon($Link="pages.php?Pg=standarSatuanHarga",$Image="module.png",$Isi="Referensi Standar Harga").
		PanelIcon($Link="pages.php?Pg=ref_jenis_tagihan",$Image="module.png",$Isi="Referensi Jenis Tagihan").
		PanelIcon($Link="pages.php?Pg=refBarangPersediaan",$Image="module.png",$Isi="Referensi Barang Persediaan").

		"</td>
		<td width=10% valign=top>
		".

		PanelIcon($Link="pages.php?Pg=lra",$Image="module.png",$Isi="Referensi LRA").
		PanelIcon($Link="pages.php?Pg=ref_rekening_bendahara",$Image="module.png",$Isi="Referensi Rekening Bendahara").
		PanelIcon($Link="pages.php?Pg=mappingBarangPersediaan",$Image="module.png",$Isi="Mapping Barang Persediaan").

		"</td>
		<td width=10% valign=top>
		".
		//PanelIcon($Link="pages.php?Pg=ref_skpd",$Image="module.png",$Isi="SKPD").

		/*PanelIcon($Link="pages.php?Pg=ref_gudang",$Image="module.png",$Isi="Referensi Gudang").
		PanelIcon($Link="pages.php?Pg=refskpd_urusan",$Image="module.png",$Isi="Referensi Mapping SKPD").
		PanelIcon($Link="pages.php?Pg=ref_skpd_keuangan",$Image="module.png",$Isi="Referensi SKPD Keuangan").*/

		"
		</td>
		</tr>
		</table>







	</td>
	</tr>
</table>


		";
?>
