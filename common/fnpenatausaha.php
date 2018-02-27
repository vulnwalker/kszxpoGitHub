<?php



/************************************************************
* parameter $Pg $SPg $Opt
* - tanpa nav atas &notnavatas=1 --> lihat pages/navatas.php
* - $tampilCbxKeranjang
* - $tampilBidang

**************************************************************/
class PenatausahaObj {
	var $prefix = 'penatausaha';
	var $elContentHal ='penatausaha_cont_hal';
	var $elContentDaftar ='penatausaha_cont_list';
	//var $tampilCbxKeranjang = TRUE;
	//var $tampilBidang = TRUE;
	
	function GetListDet2($idBI, $fmKIB, 
		$hrg_perolehan, $cetak=FALSE, 
		$cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox, $cp2=1, $kondTglAkhir='', $susut=FALSE)
	{
		//global $jmlTotalHargaDisplay;//, $ListData;
		$fmFiltTglBtw_tgl2 = cekPOST('fmFiltTglBtw_tgl2');
		$fmFiltThnSensus = cekPOST('$fmFiltThnSensus');
		if ($fmFiltTglBtw_tgl2!='' && $kondTglAkhir=='') $kondTglAkhir=$fmFiltTglBtw_tgl2;
		if ($fmFiltThnSensus!='') {
			$tgl_sensus=($fmFiltThnSensus-1).'-12-31';
			if ($fmFiltTglBtw_tgl2=='' || $fmFiltTglBtw_tgl2>$tgl_sensus) {
				$kondTglAkhir=$tgl_sensus;
			} 
		} 
		$txls = $_REQUEST['xls']=="1"?"1":"";
		$ListData ='';
		$no2=0; 
		$tot=0;
		
		$tahun_susut = $_REQUEST['tahun_susut'];
		if ($tahun_susut != '' &&  $tahun_susut != '0000-00-00'){
			 $kondTglAkhir = $tahun_susut.'-12-31'; //sementara filter tgl, tdk pengaruh kalau di set tahun susut
		}
		
		
		$k1= $kondTglAkhir==''? '': " and tgl_pemeliharaan <='$kondTglAkhir' ";
		$k1a= $kondTglAkhir==''? '': " and tgl_pengamanan <='$kondTglAkhir' ";
		$k1b= $kondTglAkhir==''? '': " and tgl_penghapusan <='$kondTglAkhir' ";
		$k1c= $kondTglAkhir==''? '': " and tgl_penilaian <='$kondTglAkhir' ";
		$k1d= $kondTglAkhir==''? '': " and tgl <='$kondTglAkhir' ";
		//$k2= $kondTglAkhir2==''? '': " and year(tgl_pemeliharaan) <= year('$kondTglAkhir2') ";
		$clGaris = $cetak? "GarisCetak2": "GarisDaftar2";				
		//$aqry2 = "select *, year(tgl_pemeliharaan) as thn_pelihara  from pemeliharaan where id_bukuinduk='$idBI' and tambah_aset=1 order by tgl_pemeliharaan" ;
		$aqry2 = "select id as id, 1 as jenis, jenis_pemeliharaan as uraian, year(tgl_perolehan) as thn_perolehan, 
				year(tgl_pemeliharaan) as thn_buku, biaya_pemeliharaan as harga, tgl_perolehan as tgl_perolehan, tgl_pemeliharaan as tgl_buku  from pemeliharaan where idbi_awal='$idBI' $k1 and tambah_aset=1
				union
				select id as id, 2 as jenis, jenis_pengamanan as uraian, year(tgl_perolehan) as thn_perolehan, 
				year(tgl_pengamanan) as thn_buku, biaya_pengamanan as harga, tgl_perolehan as tgl_perolehan, tgl_pengamanan as tgl_buku from pengamanan where idbi_awal='$idBI' $k1a and tambah_aset=1
				union
				select Id as id, 3 as jenis, uraian as uraian, year(tgl_perolehan) as thn_perolehan, 
				year(tgl_penghapusan) as thn_buku, harga_hapus as harga, tgl_perolehan as tgl_perolehan, tgl_penghapusan as tgl_buku  from penghapusan_sebagian where idbi_awal='$idBI' $k1b
				union
				select id as id, 4 as jenis, '' as uraian, year(tgl_perolehan) as thn_perolehan,
				year(tgl_penilaian) as thn_buku, (nilai_barang-nilai_barang_asal) as harga, tgl_perolehan as tgl_perolehan, tgl_penilaian as tgl_buku  from penilaian where idbi_awal='$idBI' $k1c
				union
				select Id as id, 5 as jenis, '' as uraian, year(tgl_perolehan) as thn_perolehan,
				year(tgl) as thn_buku, (harga_baru-harga) as harga, tgl_perolehan as tgl_perolehan, tgl as tgl_buku  from t_koreksi where idbi_awal='$idBI' $k1d
				order by tgl_perolehan" ;
		$Qry2 = mysql_query($aqry2); $i=0;	$thn=''; $hrg=''; $totHrgPerThn='';					
		while($isi2=mysql_fetch_array($Qry2)){
			$isi2 = array_map('utf8_encode', $isi2);						
		if ($i==0){	$clGaris = $cetak? "GarisCetak3": "GarisDaftar3";}else{	$clGaris = $cetak? "GarisCetak2": "GarisDaftar2";			}
			$harga = $isi2['jenis']=='3'? -$isi2['harga']:$isi2['harga'];
			$tot +=$harga;
			
			//total per thn_perolehan -----------------------------------------------------------------------------
			if($isi2['thn_perolehan']!=$thn && $thn <>''){
				$clGariss = $cetak? "GarisCetak": "GarisDaftar";
				switch ($fmKIB){
					case '01': $colspan = $cetak ? 12: 13; break;
					case '02': $colspan = $cetak ? 14: 15; break;
					case '03': $colspan = $cetak ? 15: 16; break;
					case '04': $colspan = $cetak ? 16: 17; break;
					case '05': $colspan = $cetak ? 14: 15; break;
					case '06': $colspan = $cetak ? 16: 17; break;
					case '07': $colspan = $cetak ? 10: 11; break;
					case 'sensusAda' : $colspan = $cetak ? 8: 9; break;
					default: $colspan = $cetak ? 12: 13; break;
				}	
				if($susut)  $colspan = $cetak ? 10: 11;	
				if ($txls=="1"){
					$tampilHrg = !empty($cbxDlmRibu)? number_format($hrg/1000, 2, '.', '') : number_format($hrg, 2, '.', '');
					
				} else {
					$tampilHrg = !empty($cbxDlmRibu)? number_format($hrg/1000, 2, ',', '.') : number_format($hrg, 2, ',', '.');
					
				}
					$ListData .=Penatausahaan_genTableRowJml($clRow, $clGariss, $colspan, 
					array("<span style='font-style:italic;float:right'>Total $thn (Rp)</span>",
					"<span style='font-style:italic;float:right'>$tampilHrg</span>" ), $susut ,$fmKIB, $idBI, TRUE, $cetak);
					
					$ListData .=Penatausahaan_genTableRowJml($clRow, $clGariss, $colspan, 
					array("<span style='font-style:italic;float:right'>Total s/d $thn (Rp)</span>",
					"<span style='font-style:italic;float:right'>".number_format($totHrgPerThn, 2, ',', '.')."</span>" ), 
					$susut ,$fmKIB, $idBI, TRUE,  $cetak);
				//$totHrgPerThn+=$totHrgPerThn;
				$hrg='';
				
				
			}
			
			//daftar detail -----------------------------------------------------------------------------------------
			if ($txls=="1"){
				$tampilHarga = !empty($cbxDlmRibu)? number_format($harga/1000, 2, '.', '') : number_format($harga, 2, '.', '');
				
			} else {
				$tampilHarga = !empty($cbxDlmRibu)? number_format($harga/1000, 2, ',', '.') : number_format($harga, 2, ',', '.');
				
			}
			
			switch($isi2['jenis']){
				case'1': $jenis=' Pemeliharaan '; break;
				case'2': $jenis=' Pengamanan '; break;
				case'3': $jenis=' Penghapusan Sebagian '; break;
				case'4': $jenis=' Penilaian '; break;
				case'5': $jenis=' Koreksi '; break;
			}
			$tampilCheckbox = $cetak ? "": "<td class=\"$clGaris\" align=center></td>";
			$no2++;					
				$ListData .= 
					Penatausahaan_genTableRowDet($fmKIB, $clRow, $clGaris, $tampilCheckbox, 
					array($no2.'.','#'.$isi2['id'],$jenis,$isi2['uraian'],$isi2['thn_perolehan'],
					$isi2['thn_buku'],$tampilHarga,TglInd($isi2['tgl_perolehan']),TglInd($isi2['tgl_buku']) ),
					$susut, $idBI, TRUE, $cetak);
			
				
			$thn=$isi2['thn_perolehan'];	
			$hrg +=$harga;		
			$totHrgPerThn +=$harga;	
			$i++;				
		}
		
		if($thn <>''){
			$clGaris = $cetak? "GarisCetak": "GarisDaftar";
				switch ($fmKIB){
					case '01': $colspan = $cetak ? 12: 13; break;
					case '02': $colspan = $cetak ? 14: 15; break;
					case '03': $colspan = $cetak ? 15: 16; break;
					case '04': $colspan = $cetak ? 16: 17; break;
					case '05': $colspan = $cetak ? 14: 15; break;
					case '06': $colspan = $cetak ? 16: 17; break;
					case '07': $colspan = $cetak ? 10: 11; break;
					case 'sensusAda' : $colspan = $cetak ? 8: 9; break;
					default: $colspan = $cetak ? 12: 13; break;
				}	
				if($susut)  $colspan = $cetak ? 10: 11;	
			if ($txls=="1"){
				$tampilHrga = !empty($cbxDlmRibu)? number_format($hrg/1000, 2, '.', '') : number_format($hrg, 2, '.', '');
				$tampilTot = !empty($cbxDlmRibu)? number_format($tot/1000, 2, '.', '') : number_format($tot, 2, '.', '');
				
			} else {
				$tampilHrga = !empty($cbxDlmRibu)? number_format($hrg/1000, 2, ',', '.') : number_format($hrg, 2, ',', '.');
				$tampilTot = !empty($cbxDlmRibu)? number_format($tot/1000, 2, ',', '.') : number_format($tot, 2, ',', '.');
				
			}
			$clGaris = $cetak? "GarisCetak": "GarisDaftar";
			$ListData .=Penatausahaan_genTableRowJml($clRow, $clGaris, $colspan, 
						array("<span style='font-style:italic;float:right'>Total $thn (Rp)</span>",
						"<span style='font-style:italic;float:right'>$tampilHrga</span>" ), $susut ,$fmKIB, $idBI,  TRUE, $cetak);
						
			$ListData .=Penatausahaan_genTableRowJml($clRow, $clGaris, $colspan, 
						array("<span style='font-style:italic;float:right'>Total s/d $thn (Rp)</span>",
						"<span style='font-style:italic;float:right'>".number_format($totHrgPerThn, 2, ',', '.')."</span>" ),
						 $susut ,$fmKIB , $idBI, TRUE,  $cetak);
			
		}
		
		//---------------------------------------------------------------------------------------------------------------------
		
		//pemeliharaan ---------------
		/*$k1= $kondTglAkhir==''? '': "and tgl_pemeliharaan <='$kondTglAkhir' ";
		$clGaris = $cetak? "GarisCetak2": "GarisDaftar2";				
		//$aqry2 = "select *, year(tgl_pemeliharaan) as thn_pelihara  from pemeliharaan where id_bukuinduk='$idBI' and tambah_aset=1 order by tgl_pemeliharaan" ;
		$aqry2 = "select *, year(tgl_pemeliharaan) as thn_pelihara  from pemeliharaan where idbi_awal='$idBI' $k1 and tambah_aset=1 order by tgl_pemeliharaan" ;
		$Qry2 = mysql_query($aqry2); $i=0;								
		while($isi2=mysql_fetch_array($Qry2)){
			$isi2 = array_map('utf8_encode', $isi2);						
		if ($i==0){	$clGaris = $cetak? "GarisCetak3": "GarisDaftar3";}else{	$clGaris = $cetak? "GarisCetak2": "GarisDaftar2";			}
			$tot +=$isi2['biaya_pemeliharaan'];
			if ($txls=="1"){
				$tampilHarga = !empty($cbxDlmRibu)? number_format($isi2['biaya_pemeliharaan']/1000, 2, '.', '') : number_format($isi2['biaya_pemeliharaan'], 2, '.', '');
				
			} else {
				$tampilHarga = !empty($cbxDlmRibu)? number_format($isi2['biaya_pemeliharaan']/1000, 2, ',', '.') : number_format($isi2['biaya_pemeliharaan'], 2, ',', '.');
				
			}
			$tampilCheckbox = $cetak ? "": "<td class=\"$clGaris\" align=center></td>";
			$no2++;					
				$ListData .= 
					Penatausahaan_genTableRowDet($fmKIB, $clRow, $clGaris, $tampilCheckbox, 
					array($no2.'.','Pemeliharaan '.$isi2['jenis_pemeliharaan'],$isi2['thn_pelihara'],$tampilHarga,$isi2['ket'] ),$susut);
			
			
			$i++;				
		}	*/
				
		//pengamanan ---------------
		/*$k1= $kondTglAkhir==''? '': "and tgl_pengamanan <='$kondTglAkhir' ";
		
		$clGaris = $cetak? "GarisCetak2": "GarisDaftar2";				
		//$aqry3 = "select *, year(tgl_pengamanan) as thn_pengamanan  from pengamanan where id_bukuinduk='$idBI' and tambah_aset=1 order by tgl_pengamanan" ;
		$aqry3 = "select *, year(tgl_pengamanan) as thn_pengamanan  from pengamanan where idbi_awal='$idBI' $k1 and tambah_aset=1 order by tgl_pengamanan" ;
		$Qry3 = mysql_query($aqry3); $i=0;
		while($isi3=mysql_fetch_array($Qry3)){
			$isi3 = array_map('utf8_encode', $isi3);	
			if ($i==0){	$clGaris = $cetak? "GarisCetak3": "GarisDaftar3";}else{	$clGaris = $cetak? "GarisCetak2": "GarisDaftar2";}
			$tot +=$isi3['biaya_pengamanan'];
			if ($txls=="1"){			
			$tampilHarga = !empty($cbxDlmRibu)? number_format($isi3['biaya_pengamanan']/1000, 2, '.', '') : number_format($isi3['biaya_pengamanan'], 2, '.', '');
			} else {
			$tampilHarga = !empty($cbxDlmRibu)? number_format($isi3['biaya_pengamanan']/1000, 2, ',', '.') : number_format($isi3['biaya_pengamanan'], 2, ',', '.');
				
			}
			$tampilCheckbox = $cetak ? "": "<td class=\"$clGaris\" align=center></td>";
			$no2++;
			$ListData .= Penatausahaan_genTableRowDet($fmKIB,$clRow, $clGaris, $tampilCheckbox, 
				array($no2.'.','Pengamanan '.$isi3['uraian_kegiatan'],$isi3['thn_pengamanan'],$tampilHarga,$isi3['ket'] ), $susut);
			
			$i++;
		}*/
		
		//total rehab --------------------------------
		$tot_rehab = $tot;//penagmanan+ pemeihara
		$jmlTotalHargaDisplay+=$tot;
		$clGaris = $cetak? "GarisCetak": "GarisDaftar";
		//if (mysql_num_rows($Qry2)>0 || mysql_num_rows($Qry3)>0) {
		if (mysql_num_rows($Qry2)>0 ) {
			$tot += $hrg_perolehan;

			if ($txls=="1"){					
				$tampilHarga = !empty($cbxDlmRibu)? number_format($tot/1000, 2, '.', '') : number_format($tot, 2, '.', '');			
				$tampilHarga_rehab = !empty($cbxDlmRibu)? number_format($tot_rehab/1000, 2, '.', '') : 
					number_format($tot_rehab, 2, '.', '');
			} else {
				$tampilHarga = !empty($cbxDlmRibu)? number_format($tot/1000, 2, ',', '.') : number_format($tot, 2, ',', '.');			
				$tampilHarga_rehab = !empty($cbxDlmRibu)? number_format($tot_rehab/1000, 2, ',', '.') : 
					number_format($tot_rehab, 2, ',', '.');
					
			}
			
			switch ($fmKIB){
				case '01': $colspan = $cetak ? 12: 13; break;
				case '02': $colspan = $cetak ? 14: 15; break;
				case '03': $colspan = $cetak ? 15: 16; break;
				case '04': $colspan = $cetak ? 16: 17; break;
				case '05': $colspan = $cetak ? 14: 15; break;
				case '06': $colspan = $cetak ? 16: 17; break;
				case '07': $colspan = $cetak ? 10: 11; break;
				case 'sensusAda' : $colspan = $cetak ? 8: 9; break;
				default: $colspan = $cetak ? 12: 13; break;
			}	
			if($susut)  $colspan = $cetak ? 10: 11;	
			$ListData .= 
				Penatausahaan_genTableRowJml($clRow, $clGaris, $colspan, 
					array("<span style='font-style:italic;float:right'>Total (Perolehan + Rehab) (Rp)</span>",
					"<span style='font-style:italic;float:right'>$tampilHarga</span>" )
					, $susut ,$fmKIB, $idBI, FALSE, $cetak
				);

		}
		$tot=0;//$no2=0;
		//penghapusan sebagian ---------------
		/*$k1= $kondTglAkhir==''? '': "and tgl_penghapusan <='$kondTglAkhir' ";

		$clGaris = $cetak? "GarisCetak2": "GarisDaftar2";				
		//$aqry2 = "select *, year(tgl_pemeliharaan) as thn_pelihara  from pemeliharaan where id_bukuinduk='$idBI' and tambah_aset=1 order by tgl_pemeliharaan" ;
		$aqry2 = "select *, year(tgl_penghapusan) as thn_penghapusan  from penghapusan_sebagian where idbi_awal='$idBI' $k1 order by tgl_penghapusan" ;
		$Qry2 = mysql_query($aqry2); $i=0;								
		while($isi2=mysql_fetch_array($Qry2)){
			$isi2 = array_map('utf8_encode', $isi2);						
		if ($i==0){	$clGaris = $cetak? "GarisCetak3": "GarisDaftar3";}else{	$clGaris = $cetak? "GarisCetak2": "GarisDaftar2";			}
			$tot +=-$isi2['harga_hapus'];
			if ($txls=="1"){
			$tampilHarga = !empty($cbxDlmRibu)? number_format(-$isi2['harga_hapus']/1000, 2, '.', '') : number_format(-$isi2['harga_hapus'], 2, '.', '');
				
			} else {
			$tampilHarga = !empty($cbxDlmRibu)? number_format(-$isi2['harga_hapus']/1000, 2, ',', '.') : number_format(-$isi2['harga_hapus'], 2, ',', '.');
				
			}
			$tampilCheckbox = $cetak ? "": "<td class=\"$clGaris\" align=center></td>";
			$no2++;			
			$ListData .= 
				Penatausahaan_genTableRowDet($fmKIB, $clRow, $clGaris, $tampilCheckbox, 
					array($no2.'.','Penghapusan Sebagian '.$isi2['uraian'],$isi2['thn_penghapusan'],$tampilHarga,$isi2['ket'] ));
			
			$i++;				
		}	*/
		
		
		//total hps
		/*$tot_susut = $tot;//penagmanan+ pemeihara
		$jmlTotalHargaDisplay+=$tot;
		$clGaris = $cetak? "GarisCetak": "GarisDaftar";
		if (mysql_num_rows($Qry2)>0 ) {
			$tot = $hrg_perolehan+$tot_rehab+$tot_susut;

			if ($txls=="1"){					
				$tampilHarga = !empty($cbxDlmRibu)? number_format($tot/1000, 2, '.', '') : number_format($tot, 2, '.', '');			
				$tampilHarga_susut = !empty($cbxDlmRibu)? number_format($tot_susut/1000, 2, '.', '') : number_format($tot_susut, 2, '.', '');
			} else {
				$tampilHarga = !empty($cbxDlmRibu)? number_format($tot/1000, 2, ',', '.') : number_format($tot, 2, ',', '.');			
				$tampilHarga_susut = !empty($cbxDlmRibu)? number_format($tot_susut/1000, 2, ',', '.') : number_format($tot_susut, 2, ',', '.');
					
			}
			
			switch ($fmKIB){
				case '01': $colspan = $cetak ? 12: 13; break;
				case '02': $colspan = $cetak ? 14: 15; break;
				case '03': $colspan = $cetak ? 15: 16; break;
				case '04': $colspan = $cetak ? 16: 17; break;
				case '05': $colspan = $cetak ? 14: 15; break;
				case '06': $colspan = $cetak ? 16: 17; break;
				case '06': $colspan = $cetak ? 16: 17; break;
				case '07': $colspan = $cetak ? 10: 11; break;
				default: $colspan = $cetak ? 12: 13; break;
			}		
			if($susut)  $colspan = $cetak ? 9: 10;
			$ListData .= 
			Penatausahaan_genTableRowJml($clRow, $clGaris, $colspan, 
				array("<span style='font-style:italic;float:right'>Jumlah Penghapusan Sebagian (Rp)</span>",
				"<span style='font-style:italic;float:right'>$tampilHarga_susut</span>" ), $susut, $fmKIB);
			
		}*/
		
		/*if ($tot_rehab>0 || $tot_susut>0 ) {
			if($susut)  $colspan = $cetak ? 10: 11;
			$ListData .=Penatausahaan_genTableRowJml($clRow, $clGaris, $colspan, 
				array("<span style='font-style:italic;float:right'>Jumlah (Rp)</span>",
				"<span style='font-style:italic;float:right'>$tampilHarga</span>" ), $susut ,$fmKIB);
		
		}*/
		
		//penilaian ---------------
		/*$k1= $kondTglAkhir==''? '': "and tgl_penilaian <='$kondTglAkhir' ";
		$clGaris = $cetak? "GarisCetak2": "GarisDaftar2";				
		$aqry2 = "select *, year(tgl_penilaian) as thn  from penilaian where idbi_awal='$idBI' $k1 order by tgl_penilaian" ;
		$Qry2 = mysql_query($aqry2); $i=0;	$tot_nilai=0;							
		while($isi2=mysql_fetch_array($Qry2)){	
			$isi2 = array_map('utf8_encode', $isi2);					
		if ($i==0){	$clGaris = $cetak? "GarisCetak3": "GarisDaftar3";}else{	$clGaris = $cetak? "GarisCetak2": "GarisDaftar2";			}
			$tot_nilai +=($isi2['nilai_barang']-$isi2['nilai_barang_asal']);
			if ($txls=="1"){
			$tampilHarga = !empty($cbxDlmRibu)? number_format(($isi2['nilai_barang']-$isi2['nilai_barang_asal'])/1000, 2, '.', '') : number_format(($isi2['nilai_barang']-$isi2['nilai_barang_asal']), 2, '.', '');
				
			} else {
			$tampilHarga = !empty($cbxDlmRibu)? number_format(($isi2['nilai_barang']-$isi2['nilai_barang_asal'])/1000, 2, ',', '.') : number_format(($isi2['nilai_barang']-$isi2['nilai_barang_asal']), 2, ',', '.');
				
			}
			$tampilCheckbox = $cetak ? "": "<td class=\"$clGaris\" align=center></td>";
			$no2++;		
			
			switch ($fmKIB){
				case '01': $colspan = $cetak ? 12: 13; break;
				case '02': $colspan = $cetak ? 14: 15; break;
				case '03': $colspan = $cetak ? 15: 16; break;
				case '04': $colspan = $cetak ? 16: 17; break;
				case '05': $colspan = $cetak ? 14: 15; break;
				case '06': $colspan = $cetak ? 16: 17; break;
				case '06': $colspan = $cetak ? 16: 17; break;
				case '07': $colspan = $cetak ? 10: 11; break;
				default: $colspan = $cetak ? 12: 13; break;
			}		
			if($susut)  $colspan = $cetak ? 10: 11;	
			$ListData .= 
				Penatausahaan_genTableRowDet($fmKIB, $clRow, $clGaris, $tampilCheckbox, 
					array($no2.'.','Penilaian ',$isi2['thn'],$tampilHarga,$isi2['ket'] ));
			
			$i++;				
		}*/	
		
		//koreksi ------------------------------
		/*$aqry2 = "select *  from t_koreksi where idbi_awal='$idBI' ";
		$Qry2 = mysql_query($aqry2); $i=0;	$tot_koreksi=0; //$no2=0;							
		while($isi2=mysql_fetch_array($Qry2)){	
			$isi2 = array_map('utf8_encode', $isi2);					
		if ($i==0){	$clGaris = $cetak? "GarisCetak3": "GarisDaftar3";}else{	$clGaris = $cetak? "GarisCetak2": "GarisDaftar2";			}
			$tot_koreksi +=($isi2['harga_baru']-$isi2['harga']);
			if ($txls=="1"){
				$tampilHarga = !empty($cbxDlmRibu)? number_format(($isi2['harga_baru']-$isi2['harga'])/1000, 2, '.', '') : number_format(($isi2['harga_baru']-$isi2['harga']), 2, '.', '');
				
			} else {
				$tampilHarga = !empty($cbxDlmRibu)? number_format(($isi2['harga_baru']-$isi2['harga'])/1000, 2, ',', '.') : number_format(($isi2['harga_baru']-$isi2['harga']), 2, ',', '.');
				
			}
			$tampilCheckbox = $cetak ? "": "<td class=\"$clGaris\" align=center></td>";
			$no2++;	
			
			switch ($fmKIB){
				case '01': $colspan = $cetak ? 12: 13; break;
				case '02': $colspan = $cetak ? 14: 15; break;
				case '03': $colspan = $cetak ? 15: 16; break;
				case '04': $colspan = $cetak ? 16: 17; break;
				case '05': $colspan = $cetak ? 14: 15; break;
				case '06': $colspan = $cetak ? 16: 17; break;
				case '06': $colspan = $cetak ? 16: 17; break;
				case '07': $colspan = $cetak ? 10: 11; break;
				default: $colspan = $cetak ? 12: 13; break;
			}		
			if($susut)  $colspan = $cetak ? 10: 11;		
			$ListData .= 
				Penatausahaan_genTableRowDet($fmKIB, $clRow, $clGaris, $tampilCheckbox, 
					array($no2.'.','Koreksi ','',$tampilHarga,$isi2['ket'] ));
			
			$i++;				
		}*/	
		
		
		//if ( $tot_nilai != 0  || $tot_koreksi !=0) {
		/*if ( $tot_nilai != 0  || $tot_koreksi !=0 || $tot_rehab!=0 || $tot_susut!=0) {
			
			$jmlTotalHargaDisplay=$tot_koreksi+$tot_nilai+$tot_rehab+$tot_susut+$hrg_perolehan;
			switch ($fmKIB){
				case '01': $colspan = $cetak ? 12: 13; break;
				case '02': $colspan = $cetak ? 14: 15; break;
				case '03': $colspan = $cetak ? 15: 16; break;
				case '04': $colspan = $cetak ? 16: 17; break;
				case '05': $colspan = $cetak ? 14: 15; break;
				case '06': $colspan = $cetak ? 16: 17; break;
				case '07': $colspan = $cetak ? 10: 11; break;
				default: $colspan = $cetak ? 12: 13; break;
			}	
		
		//if ($tot_rehab>0 || $tot_susut>0 ) {
			//if($susut)  $colspan = $cetak ? 10: 11;
			if ($txls=="1"){
				$vtot = !empty($cbxDlmRibu)? number_format(($jmlTotalHargaDisplay)/1000, 2, '.', '') : number_format(($jmlTotalHargaDisplay), 2, '.', '');
				
			} else {
				$vtot = !empty($cbxDlmRibu)? number_format(($jmlTotalHargaDisplay)/1000, 2, ',', '.') : number_format(($jmlTotalHargaDisplay), 2, ',', '.');
				
			}
			$ListData .=Penatausahaan_genTableRowJml($clRow, $clGaris, $colspan, 
				array("<span style='font-style:italic;float:right'>Jumlah (Rp)</span>",
				"<span style='font-style:italic;float:right'>".$vtot."</span>"  ),
				$susut,$fmKIB);
		
		}*/
		
		//$jmlTotalHargaDisplay_=$tot_koreksi+$tot_nilai+$tot_rehab+$tot_susut;//+$hrg_perolehan;
		$jmlTotalHargaDisplay_=$tot_rehab;//+$hrg_perolehan;
		
		return array('jmlTotalHargaDisplay'=>$jmlTotalHargaDisplay_,'ListData'=>$ListData,'tot_rehab'=>$tot_rehab);
	}	



	function Proses($isMutasi=FALSE){
		global $errmsg, $Act, $Baru, $cidBI;
		global $MyField, $MyFieldKIB, $Main, $Sukses, $Info;		
		global $fmKEPEMILIKAN, $fmWIL, $fmURUSAN, $fmSKPD, $fmUNIT, $fmSUBUNIT, $fmTAHUNANGGARAN, $fmTAHUNPEROLEHAN, 
		$fmREGISTER, 
		$fmSKPD_old, $fmUNIT_old, $fmSUBUNIT_old, $fmREGISTER_old, $fmTAHUNANGGARAN_old, $fmTAHUNPEROLEHAN_old, $fmREGISTER_old,
		$ArBarang, $ArBarang_old, $fmIDBARANG, $fmIDBARANG_old,
		$fmJUMLAHBARANG, $fmSATUAN,
		$fmHARGABARANG, $fmJUMLAHHARGA, $fmASALUSUL, $fmTGLUPDATE, $tgl_sensus, $fmJENISHIBAH,
		$fmKONDISIBARANG, $nilai_appraisal, $gambar, $dokumen_ket, $dokumen,
	$dokumen_file, $tgl_buku, $UID,  $fmIDLama; //{$idBI,}
		
		global $alamat_kel, $alamat_kec, $alamat_a, $alamat_b, $koordinat_gps, $koord_bidang;
		global $alamat_kota, $alamat_c;
		
		global $kampung, $rt, $rw;
		
		global $fmLUAS_KIB_A, $fmLETAK_KIB_A, 
		$fmHAKPAKAI_KIB_A, $bersertifikat, $fmTGLSERTIFIKAT_KIB_A, $fmNOSERTIFIKAT_KIB_A,		
		$fmPENGGUNAAN_KIB_A, $fmKET_KIB_A, $fmBLOK_KIB_A, $fmPERSIL_KIB_A;
		global $fmMERK_KIB_B, $fmUKURAN_KIB_B, $fmBAHAN_KIB_B, $fmPABRIK_KIB_B, $fmRANGKA_KIB_B, 
		$fmMESIN_KIB_B, $fmPOLISI_KIB_B, $fmBPKB_KIB_B,	$fmKET_KIB_B;
		global $fmKONDISI_KIB_C, $fmTINGKAT_KIB_C, $fmBETON_KIB_C, $fmLUASLANTAI_KIB_C,
		$fmLETAK_KIB_C, $fmTGLGUDANG_KIB_C, $fmNOGUDANG_KIB_C, $fmLUAS_KIB_C, $fmSTATUSTANAH_KIB_C,
		$fmNOKODETANAH_KIB_C, $fmNOGEDUNG_KIB_C, $fmKET_KIB_C;
		global $fmKONSTRUKSI_KIB_D, $fmPANJANG_KIB_D, $fmLEBAR_KIB_D, $fmLUAS_KIB_D,
		$fmALAMAT_KIB_D, $fmTGLDOKUMEN_KIB_D, $fmNODOKUMEN_KIB_D, $fmSTATUSTANAH_KIB_D,
		$fmNOKODETANAH_KIB_D, $fmNORUASJALAN_KIB_D, $fmKONDISI_KIB_D, $fmKET_KIB_D;
		global $fmJUDULBUKU_KIB_E, $fmSPEKBUKU_KIB_E, $fmSENIBUDAYA_KIB_E, $fmSENIPENCIPTA_KIB_E, 
		$fmSENIBAHAN_KIB_E, $fmJENISHEWAN_KIB_E, $fmUKURANHEWAN_KIB_E, $fmKET_KIB_E;
		global $fmBANGUNAN_KIB_F, $fmTINGKAT_KIB_F, $fmBETON_KIB_F, $fmLUAS_KIB_F,
		$fmLETAK_KIB_F, $fmTGLDOKUMEN_KIB_F, $fmNODOKUMEN_KIB_F, $fmTGLMULAI_KIB_F,
		$fmSTATUSTANAH_KIB_F, $fmNOKODETANAH_KIB_F, $fmKET_KIB_F;
		global $fmURAIAN_KIB_G,$fmPENCIPTA_KIB_G,$fmJENIS_KIB_G, $fmKET_KIB_G;
		global $gambar_old, $dokumen_file_old;
		global $tgl_sensus, $fmIdAwal;
		global $HTTP_COOKIE_VARS;
		global $fmSTATUSASET,$fmHARGABARANGBELI,$fmHARGABARANGATRIBUSI,$ref_idatribusi;
		global $no_ba, $tgl_ba, $no_spk, $tgl_spk, $penggunabi;
		global $fmPROGRAM, $fmKEGIATAN, $bk, $ck, $dk, $bk_p, $ck_p, $dk_p;
				
		$cek = '';
		$UID = $HTTP_COOKIE_VARS['coID'];
		$fmSEKSI = $_REQUEST['fmSEKSI'];
		$ref_idpemegang = $_REQUEST['ref_idpemegang'];  
		$ref_idpemegang2 = $_REQUEST['ref_idpemegang2'];  
		$ref_idpenanggung = $_REQUEST['ref_idpenanggung']; 		
		$ref_idruang = $_REQUEST['ref_idruang'];
		$ref_idatribusi=$_REQUEST['ref_idatribusi']; 		
		$fmWIL = $Main->DEF_WILAYAH ;
		
		//--- tidak boleh petik
		//, , , $fmTGLUPDATE, ,		
		if ($errmsg=='' &&  preg_match("/'/",$fmKEPEMILIKAN)  == 1){	$errmsg = 'Kode Kepemilikan tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmWIL)  == 1){	$errmsg = 'Kode Wilayah tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmSKPD)  == 1){	$errmsg = 'Kode Bidang tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmUNIT)  == 1){	$errmsg = 'Kode Asisten/OPD tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmSUBUNIT)  == 1){	$errmsg = 'Kode BIRO / UPTD/B tidak boleh tanda petik!';	}		
		if ($errmsg=='' &&  preg_match("/'/",$fmREGISTER)  == 1){	$errmsg = 'No. Register tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmTAHUNPEROLEHAN)  == 1){	$errmsg = 'Tahun Perolehan tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmTAHUNANGGARAN)  == 1){	$errmsg = 'Tahun Anggaran tidak boleh tanda petik!';	}		
		if ($errmsg=='' &&  preg_match("/'/",$fmHARGABARANG)  == 1){	$errmsg = 'Harga Perolehan tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmIDBARANG)  == 1){	$errmsg = 'ID Barang tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmJUMLAHBARANG)  == 1){	$errmsg = 'Jumlah Barang tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmASALUSUL)  == 1){	$errmsg = 'Asal Usul tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$tgl_sensus)  == 1){	$errmsg = 'Tanggal Sensus tidak boleh tanda petik!';	}		
		if ($errmsg=='' &&  preg_match("/'/",$fmKONDISIBARANG)  == 1){	$errmsg = 'Kondisi tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$tgl_buku)  == 1){	$errmsg = 'Tanggal Buku tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmIDLama)  == 1){	$errmsg = 'ID Lama tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$koordinat_gps)  == 1){	$errmsg = 'Kooordinat Lokasi tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$koord_bidang)  == 1){	$errmsg = 'Koordinat Bidang tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmHAKPAKAI_KIB_A)  == 1){	$errmsg = 'Hak Pakai tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$bersertifikat)  == 1){	$errmsg = 'Bersertifikat tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmTGLSERTIFIKAT_KIB_A)  == 1){	$errmsg = 'Tanggal Sertifikat tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmLUAS_KIB_A)  == 1){	$errmsg = 'Luas tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmKONDISI_KIB_C)  == 1){	$errmsg = 'Kondisi tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmTINGKAT_KIB_C)  == 1){	$errmsg = 'Tingkat tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmBETON_KIB_C)  == 1){	$errmsg = 'Beton tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmTGLGUDANG_KIB_C)  == 1){	$errmsg = 'Tanggal Gudang tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmLUAS_KIB_C)  == 1){	$errmsg = 'Luas tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmSTATUSTANAH_KIB_C)  == 1){	$errmsg = 'Status Tanah tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmLUASLANTAI_KIB_C)  == 1){	$errmsg = 'Luas Lantai tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmNOKODETANAH_KIB_C)  == 1){	$errmsg = 'Kode Tanah tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmKONSTRUKSI_KIB_D)  == 1){	$errmsg = 'Konstruksi tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmPANJANG_KIB_D)  == 1){	$errmsg = 'Panjang tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmLEBAR_KIB_D)  == 1){	$errmsg = 'Lebar tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmLUAS_KIB_D)  == 1){	$errmsg = 'Luas tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmTGLDOKUMEN_KIB_D)  == 1){	$errmsg = 'Tanggal Dokumen tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmSTATUSTANAH_KIB_D)  == 1){	$errmsg = 'Status Tanah tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmNOKODETANAH_KIB_D)  == 1){	$errmsg = 'Kode Tanah tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmKONDISI_KIB_D)  == 1){	$errmsg = 'Kondisi tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmUKURANHEWAN_KIB_E)  == 1){	$errmsg = 'Ukuran Hewan tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmBANGUNAN_KIB_F)  == 1){	$errmsg = 'Bangunan tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmTINGKAT_KIB_F)  == 1){	$errmsg = 'Tingkat tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmBETON_KIB_F)  == 1){	$errmsg = 'Beton tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmLUAS_KIB_F)  == 1){	$errmsg = 'Luas tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmTGLMULAI_KIB_F)  == 1){	$errmsg = 'Tanggal Mulai tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmTGLDOKUMEN_KIB_F)  == 1){	$errmsg = 'Tanggal Dokumen tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmSTATUSTANAH_KIB_F)  == 1){	$errmsg = 'Status Tanah tidak boleh tanda petik!';	}
		if ($errmsg=='' &&  preg_match("/'/",$fmNOKODETANAH_KIB_F)  == 1){	$errmsg = 'Kode Tanah tidak boleh tanda petik!';	}
	
		//--- replace tanda petik jika ada
		//&#8482; tm
		$fmKET_KIB_A = preg_replace("/'/",'&#39;',$fmKET_KIB_A);
		$fmKET_KIB_B = preg_replace("/'/",'&#39;',$fmKET_KIB_B);
		$fmKET_KIB_C = preg_replace("/'/",'&#39;',$fmKET_KIB_C);
		$fmKET_KIB_D = preg_replace("/'/",'&#39;',$fmKET_KIB_D);
		$fmKET_KIB_E = preg_replace("/'/",'&#39;',$fmKET_KIB_E);
		$fmKET_KIB_F = preg_replace("/'/",'&#39;',$fmKET_KIB_F);		
		$fmLETAK_KIB_A = preg_replace("/'/",'&#39;',$fmLETAK_KIB_A);
		$fmLETAK_KIB_C = preg_replace("/'/",'&#39;',$fmLETAK_KIB_C);
		$fmLETAK_KIB_D = preg_replace("/'/",'&#39;',$fmLETAK_KIB_D);
		$fmLETAK_KIB_F = preg_replace("/'/",'&#39;',$fmLETAK_KIB_F);				
		$alamat_kel = preg_replace("/'/",'&#39;',$alamat_kel);
		$alamat_kec = preg_replace("/'/",'&#39;',$alamat_kec);
		$fmPENGGUNAAN_KIB_A = preg_replace("/'/",'&#39;',$fmPENGGUNAAN_KIB_A);		
		$fmSATUAN = preg_replace("/'/",'&#39;',$fmSATUAN);
		$fmNOSERTIFIKAT_KIB_A = preg_replace("/'/",'&#39;',$fmNOSERTIFIKAT_KIB_A);
		$fmPENGGUNAAN_KIB_A = preg_replace("/'/",'&#39;',$fmPENGGUNAAN_KIB_A);		
		$fmMERK_KIB_B = //htmlspecialchars($fmMERK_KIB_B);
			//htmlentities($fmMERK_KIB_B, ENT_QUOTES);
			//preg_replace
			 //preg_replace(array("/'/",'/'.chr(8482).'/'), array('&#39;','&#8482;'), $fmMERK_KIB_B);
			 //preg_replace(array('/'.chr(39).'/','/'.chr(8482).'/'), array('&#39;','&#8482;'), $fmMERK_KIB_B);
			 preg_replace(array('/'.chr(8482).'/','/'.chr(39).'/'), array('&#8482;','&#39;'), $fmMERK_KIB_B);
		$fmUKURAN_KIB_B = preg_replace("/'/",'&#39;',$fmUKURAN_KIB_B);
		$fmBAHAN_KIB_B = preg_replace("/'/",'&#39;',$fmBAHAN_KIB_B);
		$fmPABRIK_KIB_B = preg_replace("/'/",'&#39;',$fmPABRIK_KIB_B);
		$fmRANGKA_KIB_B = preg_replace("/'/",'&#39;',$fmRANGKA_KIB_B);
		$fmMESIN_KIB_B = preg_replace("/'/",'&#39;',$fmMESIN_KIB_B);
		$fmPOLISI_KIB_B = preg_replace("/'/",'&#39;',$fmPOLISI_KIB_B);
		$fmBPKB_KIB_B = preg_replace("/'/",'&#39;',$fmBPKB_KIB_B);				
		$fmNOGUDANG_KIB_C = preg_replace("/'/",'&#39;',$fmNOGUDANG_KIB_C);		
		$fmALAMAT_KIB_D = preg_replace("/'/",'&#39;',$fmALAMAT_KIB_D);
		$fmNODOKUMEN_KIB_D = preg_replace("/'/",'&#39;',$fmNODOKUMEN_KIB_D);		
		$fmJUDULBUKU_KIB_E = preg_replace("/'/",'&#39;',$fmJUDULBUKU_KIB_E);
		$fmSPEKBUKU_KIB_E = preg_replace("/'/",'&#39;',$fmSPEKBUKU_KIB_E);
		$fmSENIBUDAYA_KIB_E = preg_replace("/'/",'&#39;',$fmSENIBUDAYA_KIB_E);
		$fmSENIPENCIPTA_KIB_E = preg_replace("/'/",'&#39;',$fmSENIPENCIPTA_KIB_E);		
		$fmSENIBAHAN_KIB_E = preg_replace("/'/",'&#39;',$fmSENIBAHAN_KIB_E);
		$fmJENISHEWAN_KIB_E = preg_replace("/'/",'&#39;',$fmJENISHEWAN_KIB_E);				
		$fmNODOKUMEN_KIB_F = preg_replace("/'/",'&#39;',$fmNODOKUMEN_KIB_F);
		
		/*$fmMERK_KIB_B = preg_replace("/(™|®|©|&trade;|&reg;|&copy;|&#8482;|&#174;|&#169;)/", "", $fmMERK_KIB_B);
		$fmKET_KIB_A = preg_replace("/(™|®|©|&trade;|&reg;|&copy;|&#8482;|&#174;|&#169;)/", "", $fmKET_KIB_A);
		$fmKET_KIB_B = preg_replace("/(™|®|©|&trade;|&reg;|&copy;|&#8482;|&#174;|&#169;)/", "", $fmKET_KIB_B);
		$fmKET_KIB_C = preg_replace("/(™|®|©|&trade;|&reg;|&copy;|&#8482;|&#174;|&#169;)/", "", $fmKET_KIB_C);
		$fmKET_KIB_D = preg_replace("/(™|®|©|&trade;|&reg;|&copy;|&#8482;|&#174;|&#169;)/", "", $fmKET_KIB_D);
		$fmKET_KIB_E = preg_replace("/(™|®|©|&trade;|&reg;|&copy;|&#8482;|&#174;|&#169;)/", "", $fmKET_KIB_E);
		$fmKET_KIB_F = preg_replace("/(™|®|©|&trade;|&reg;|&copy;|&#8482;|&#174;|&#169;)/", "", $fmKET_KIB_F);	
		*/
		
		
		$fmMERK_KIB_B = forbiddenChar($fmMERK_KIB_B);
		$fmKET_KIB_A = forbiddenChar($fmKET_KIB_A);
		$fmKET_KIB_B = forbiddenChar($fmKET_KIB_B);
		$fmKET_KIB_C = forbiddenChar($fmKET_KIB_C);
		$fmKET_KIB_D = forbiddenChar($fmKET_KIB_D);
		$fmKET_KIB_E = forbiddenChar($fmKET_KIB_E);
		$fmKET_KIB_F = forbiddenChar($fmKET_KIB_F);
		
		if(!get_magic_quotes_gpc()) {	
			$fmKET_KIB_A 	= addslashes($fmKET_KIB_A);
			$fmKET_KIB_B 	= addslashes($fmKET_KIB_B);
			$fmKET_KIB_C 	= addslashes($fmKET_KIB_C);
			$fmKET_KIB_D 	= addslashes($fmKET_KIB_D);
			$fmKET_KIB_E 	= addslashes($fmKET_KIB_E);
			$fmKET_KIB_F 	= addslashes($fmKET_KIB_F);
			$fmLETAK_KIB_A 	= addslashes($fmLETAK_KIB_A);
			$fmLETAK_KIB_C 	= addslashes($fmLETAK_KIB_C);
			$fmLETAK_KIB_D 	= addslashes($fmLETAK_KIB_D);
			$fmLETAK_KIB_F 	= addslashes($fmLETAK_KIB_F);
			$alamat_kel 	= addslashes($alamat_kel);
			$alamat_kec 	= addslashes($alamat_kec);
			$fmPENGGUNAAN_KIB_A = addslashes($fmPENGGUNAAN_KIB_A);
			$fmSATUAN 		= addslashes($fmSATUAN);
			$fmNOSERTIFIKAT_KIB_A = addslashes($fmNOSERTIFIKAT_KIB_A);
			$fmPENGGUNAAN_KIB_A = addslashes($fmPENGGUNAAN_KIB_A);
			$fmMERK_KIB_B 	= addslashes($fmMERK_KIB_B);
			$fmUKURAN_KIB_B	= addslashes($fmUKURAN_KIB_B);
			$fmBAHAN_KIB_B	= addslashes($fmBAHAN_KIB_B);
			$fmPABRIK_KIB_B = addslashes($fmPABRIK_KIB_B);
			$fmRANGKA_KIB_B = addslashes($fmRANGKA_KIB_B);
			$fmMESIN_KIB_B	= addslashes($fmMESIN_KIB_B);
			$fmPOLISI_KIB_B = addslashes($fmPOLISI_KIB_B);
			$fmBPKB_KIB_B 	= addslashes($fmBPKB_KIB_B);
			$fmNOGUDANG_KIB_C 	= addslashes($fmNOGUDANG_KIB_C);
			$fmALAMAT_KIB_D 	= addslashes($fmALAMAT_KIB_D);
			$fmNODOKUMEN_KIB_D 	= addslashes($fmNODOKUMEN_KIB_D);
			$fmJUDULBUKU_KIB_E 	= addslashes($fmJUDULBUKU_KIB_E);
			$fmSPEKBUKU_KIB_E 	=	addslashes($fmSPEKBUKU_KIB_E);
			$fmSENIBUDAYA_KIB_E = addslashes($fmSENIBUDAYA_KIB_E);
			$fmSENIPENCIPTA_KIB_E = addslashes($fmSENIPENCIPTA_KIB_E);
			$fmSENIBAHAN_KIB_E 	= addslashes($fmSENIBAHAN_KIB_E);
			$fmJENISHEWAN_KIB_E = addslashes($fmJENISHEWAN_KIB_E);
			$fmNODOKUMEN_KIB_F 	= addslashes($fmNODOKUMEN_KIB_F);
		}
		
		if ($fmSTATUSASET<='3' && $ArBarang[0]=='07' && $ArBarang[1]=='24' && $Baru==1){
			$fmSTATUSASET=='8';
		} 	
		switch ($Act){		
			case 'Simpan' :{
				//prosedure ini dipakai di penatausahaan dan mutasi!!
				$getdate = mysql_fetch_array(mysql_query("select YEAR(now()) as thn "));
						
				//validasi	
				$errmsg='';	
				if ($errmsg=='' && $fmHARGABARANG != $fmHARGABARANGBELI+$fmHARGABARANGATRIBUSI){	$errmsg = 'Harap dicek kembali, Harga Beli + Atribusi tidak sama dengan Harga Perolehan!';	}
//				$errmsg=Penatausahaan_CekdataCutoff('edit',$xid,$tgl_buku);
//				$errmsg=' lkjafls'.$tgl_buku.' cek';								
				if ($errmsg=='' && $fmKONDISIBARANG == ''){	$errmsg = 'Kondisi Barang belum dipilih!';	}
				if ($errmsg=='' && strlen($fmREGISTER) != $Main->NOREG_SIZE){ $errmsg = 'No. Register salah!';	}
				if ($errmsg=='' && ( strlen($fmREGISTER) < $Main->NOREG_SIZE ) ){ $errmsg = 'No. Register harus '.$Main->NOREG_SIZE.' digit!';	}
															
				//cek thn perolehan
				if ($errmsg=='' && strlen($fmTAHUNPEROLEHAN) != 4){	$errmsg = 'Tahun Perolehan salah!';	}
				if ($errmsg=='' && $fmTAHUNPEROLEHAN < '1900' ) { $errmsg = 'Tahun Perolehan tidak lebih kecil dari 1900!'; }
				if ($errmsg=='' && $fmTAHUNPEROLEHAN >  $getdate['thn'] ) { $errmsg = 'Tahun Perolehan tidak lebih besar dari tahun sekarang!'; }
				
				//cek tgk bast dan tgl spk
				$tgl_ba= $tgl_ba=='0000-00-00' ? '': $tgl_ba;
				$tgl_spk= $tgl_spk=='0000-00-00' ? '': $tgl_spk;
				if ($errmsg=='' && $tgl_ba!='' && !cektanggal($tgl_ba)){ $errmsg = 'Tanggal BAST salah!'; }
				if ($errmsg=='' && $tgl_spk!='' && !cektanggal($tgl_spk)){ $errmsg = 'Tanggal SPK salah!'; }
				
				//cek tgl buku all
				$tgls = explode('-',$tgl_buku);
				$thnTglBuku = $tgls[0]; //echo $thnTglBuku;
				if ($errmsg=='' && !cektanggal($tgl_buku)){ $errmsg = 'Tanggal Buku salah!'; }
				if ($errmsg =='' && compareTanggal($tgl_buku, date('Y-m-d'))==2  ) $errmsg = 'Tanggal Buku tidak lebih besar dari Hari ini!';
				//if ($errmsg=='' && $thnTglBuku < 2009 ){ $errmsg = 'Tahun Tanggal Buku tidak lebih kecil dari 2009!'; }				
				if ($errmsg=='' && $thnTglBuku < $Main->TAHUN_CUTOFF ){ $errmsg = 'Tahun Tanggal Buku tidak lebih kecil dari '.$Main->TAHUN_CUTOFF.'!'; }				
				 
				if ($errmsg=='' && $thnTglBuku <  $fmTAHUNPEROLEHAN ) $errmsg = 'Tahun Tanggal Buku tidak lebih kecil dari Tahun Perolehan!';
								
				//cek tgl sensus			
				$tgl_sensus= $tgl_sensus=='0000-00-00 00:00:00' ? '': $tgl_sensus;	
				$arr = explode('-',$tgl_sensus); //$errmsg = ($tgl_sensus != '').$tgl_sensus;
				$thnTglSensus = $arr[0];								
				if ($errmsg=='' && $tgl_sensus!='' && !cektanggal($tgl_sensus)) $errmsg = "Tanggal Sensus salah  !"; 
				if ($errmsg =='' && $tgl_sensus!='' && compareTanggal($tgl_sensus, date('Y-m-d'))==2  ) $errmsg = 'Tanggal Sensus tidak lebih besar dari Hari ini!';
				if ($errmsg=='' && $tgl_sensus!='' && $thnTglSensus <  $fmTAHUNPEROLEHAN ) $errmsg = 'Tahun Tanggal Sensus tidak lebih kecil dari Tahun Perolehan!';
				
				
				

				if($isMutasi == FALSE){
					//cek tgl buku										
					/*if ($errmsg=='' && $fmTAHUNPEROLEHAN<=2009 && $thnTglBuku > 2009 ){ 
						$errmsg = 'Untuk Tahun perolehan lebih kecil dari 2010. Tahun Tanggal Buku tidak lebih besar dari 2009!'; 
					}
					if ($errmsg=='' && $fmTAHUNPEROLEHAN>2009 && $thnTglBuku != $fmTAHUNPEROLEHAN && $Baru!=0){ 
						$errmsg = 'Tahun Tanggal Buku harus sama dengan Tahun Perolehan!'; 
					}*/				
					if ($errmsg=='' && $fmTAHUNPEROLEHAN<=$Main->TAHUN_CUTOFF && $thnTglBuku > $Main->TAHUN_CUTOFF ){ 
						$errmsg = 'Untuk Tahun perolehan lebih kecil dari '.($Main->TAHUN_CUTOFF+1).'. Tahun Tanggal Buku tidak lebih besar dari '.$Main->TAHUN_CUTOFF.'!'; 
					}
/*					
					if ($errmsg=='' && $fmTAHUNPEROLEHAN>$Main->TAHUN_CUTOFF && $thnTglBuku != $fmTAHUNPEROLEHAN && $Baru!=0){ 
						$errmsg = 'Tahun Tanggal Buku harus sama dengan Tahun Perolehan!'; 
					}
*/					
					if ($errmsg =='' && $tgl_sensus!='' && compareTanggal($tgl_buku, $tgl_sensus )==2 && $Baru!=0) $errmsg = 'Tanggal Sensus tidak lebih kecil dari Tanggal Buku !';

					if ($errmsg=='' && $Baru==0){
						$idbi = $_POST['idbi'];
							$errmsg=Penatausahaan_CekdataCutoff('edit',$idbi,'');
					} 
					elseif ($errmsg=='')
					{
							$errmsg=Penatausahaan_CekdataCutoff('insert',$idbi,$tgl_buku);
						
					}
					
					if ($errmsg=='' && $Baru==0){ //edit	
						
											
						$idbi = $_POST['idbi'];
						$old =  mysql_fetch_array( mysql_query (
							"select * from buku_induk where id = '$idbi'"
						));//echo  'id='.$idbi .' idlama='.$old['id_lama']. '<br>';
						
						
						
						// $errmsg.=' halo';
						//cek tgl pemeliharaan, pengamanan						
						$pelihara = mysql_fetch_array( mysql_query (
							"select min(tgl_pemeliharaan) as mintgl from pemeliharaan where id_bukuinduk = '$idbi'"
						));
						if ($errmsg =='' && compareTanggal($tgl_buku, $pelihara['mintgl'])==2 && $pelihara['mintgl']!='' ) $errmsg = 'Tanggal Buku tidak lebih besar dari Tanggal Pemeliharaan!';
						$pengaman = mysql_fetch_array( mysql_query (
							"select min(tgl_pengamanan) as mintgl from pengamanan where id_bukuinduk = '$idbi'"
						));
						if ($errmsg =='' && compareTanggal($tgl_buku, $pengaman['mintgl'])==2  && $pengaman['mintgl']!='' ) $errmsg = 'Tanggal Buku tidak lebih besar dari Tanggal Pengamanan!';//.$idbi.' '. $tgl_buku.' '.$pengaman['mintgl'];
						$pemanfaat = mysql_fetch_array( mysql_query (
							"select min(tgl_pemanfaatan) as mintgl from pemanfaatan where id_bukuinduk = '$idbi'"
						));
						if ($errmsg =='' && compareTanggal($tgl_buku, $pemanfaat['mintgl'])==2 && $pemanfaat['mintgl']!=''  ) $errmsg = 'Tanggal Buku tidak lebih besar dari Tanggal Pemanfaatan!';											
						
						if ($old['status_barang']==3) $errmsg = "Gagal Simpan, Data Sudah di Penghapusan!";
						if ($old['status_barang']==4) $errmsg = "Gagal Simpan, Data Sudah di Pemindah Tanganan!";
						if ($old['status_barang']==5) $errmsg = "Gagal Simpan, Data Sudah di Ganti Rugi!";
						
						if($old['id_lama'] != '' || $old['id_lama'] != NULL){ //hasil mutasi
							$hapus = mysql_fetch_array( mysql_query (
								"select tgl_penghapusan from penghapusan where id_bukuinduk = '{$old['id_lama']}'"
							));
							$bilama = mysql_fetch_array( mysql_query (
								"select * from buku_induk where id = '{$old['id_lama']}'"
							)); 
							if ( compareTanggal($tgl_buku, $hapus['tgl_penghapusan'])==0) 
								$errmsg = 'Tanggal Buku tidak lebih kecil dari Tanggal Penghapusan!';									
						}else{//bukan hasil mutasi							
							if ($errmsg =='' && $tgl_sensus!='' && compareTanggal($tgl_buku, $tgl_sensus )==2 ) $errmsg = 'Tanggal Sensus tidak lebih kecil dari Tanggal Buku !';				
							
						}	
																
					}
					else{//baru
						// $errmsg=Penatausahaan_CekdataCutoff('insert',$idbi,$tgl_buku);
						if ($errmsg =='' && $tgl_sensus!='' && compareTanggal($tgl_buku, $tgl_sensus )==2 ) $errmsg = 'Tanggal Sensus tidak lebih kecil dari Tanggal Buku !';																	
					}
						
				}
				//cek mutasi ----------------------------------------------------------
				else{ 
					$idbi = $_POST['idbi'];
					$old =  mysql_fetch_array( mysql_query (
						"select * from buku_induk where id = '$fmIDLama'"
					));
					//cek skpd baru tidak boleh samaa skpd lama
					//$errmsg  = 'idbi='.$fmIDLama.', '.$old['c'].$old['d'].$old['e'].$old['e1']."<>$fmSKPD$fmUNIT$fmSUBUNIT$fmSEKSI" ;
					if($Main->MODUL_SUBUNIT){
						if($errmsg=='' && ($old['c'].$old['d'].$old['e'].$old['e1']==$fmSKPD.$fmUNIT.$fmSUBUNIT.$fmSEKSI ) ) $errmsg = "Tujuan Mutasi harus beda !";	
					}else{
						if($errmsg=='' && ($old['c'].$old['d'].$old['e']==$fmSKPD.$fmUNIT.$fmSUBUNIT ) ) $errmsg = "Tujuan Mutasi harus beda !";	
					}
					
					if($errmsg=='' && sudahClosing($tgl_buku, $old['c'], $old['d'], $old['e'], $old['e1'], $old['c1']) ) $errmsg = 'Barang Sudah Closing !';					
					
					//cek tgl 
					//if ($errmsg=='' ){
						
					
						if ($errmsg==''){
							$hapus = mysql_fetch_array( mysql_query (
								"select tgl_penghapusan from penghapusan where id_bukuinduk = '$fmIDLama'"
							));
							if ( compareTanggal($tgl_buku, $hapus['tgl_penghapusan'])==0) 
								$errmsg = 'Tanggal Buku tidak lebih kecil dari Tanggal Penghapusan!';	
						}
					//}
				}
				if($Main->URUSAN == 1){
					if ($errmsg=='' && ($fmURUSAN =='' || $fmURUSAN =='00') ){ $errmsg='URUSAN belum dipilih';	}	
				}	
				if ($errmsg=='' && ($fmSKPD =='' || $fmSKPD =='00') ){ $errmsg='BIDANG belum dipilih';	}	
				if ($errmsg=='' && ($fmUNIT =='' || $fmUNIT =='00') ){ $errmsg='SKPD belum dipilih';	}	
				if ($errmsg=='' && ($fmSUBUNIT =='' || $fmSUBUNIT =='00') ){ $errmsg='UNIT belum dipilih';	}	
				if ($errmsg=='' && ($fmSEKSI =='' || $fmSEKSI =='00' || $fmSEKSI =='000') ){ $errmsg='SUB UNIT belum dipilih';	}	
				if ($errmsg=='' ){ $errmsg= ProsesCekField2($MyField);}
				if ($errmsg=='' ){ $errmsg= ProsesCekField2($MyFieldKIB);}	
				//cek tgl sertifikat
				if ($errmsg=='' && ($bersertifikat =='1' ) ){
					$tgl = $fmTGLSERTIFIKAT_KIB_A;
					$nosert = $fmNOSERTIFIKAT_KIB_A;
					if($tgl == '0000-00-00' || $tgl=='' ){ $errmsg = 'Tanggal Sertifikat belum diisi!';	}
					if(!cektanggal($tgl)){ $errmsg = 'Tanggal Sertifikat Salah!';}
					if ($errmsg =='' && compareTanggal($tgl, date('Y-m-d'))==2  ) $errmsg = 'Tanggal Sertifikat tidak lebih besar dari Hari ini!';
				
					if($nosert =='' ){ $errmsg = 'No. Sertifikat belum diisi!';	} 
				}	
				if ($errmsg=='' && $fmJUMLAHBARANG>99 ){ $errmsg='jumlah Barang lebih dari 99!'; }
				if ($errmsg==''){ //noreg + jumlah <= 9999
					//fmREGISTER, fmJUMLAHBARANG
				if ($fmREGISTER+ $fmJUMLAHBARANG >$Main->NOREG_MAX){ $errmsg='No Register dan jumlah Barang tidak lebih dari '.$Main->NOREG_MAX.'!'; }
				}
				//cek tgl_ba
				if ($errmsg=='' && ($tgl_ba == '' || $tgl_ba == '0000-00-00')){	$errmsg = 'Tanggal BAST belum diisi!';	}
				//cek tahun closing
				if($Baru==1){//baru
					if($errmsg=='' && sudahClosing($tgl_buku, $fmSKPD, $fmUNIT, $fmSUBUNIT, $fmSEKSI, $fmURUSAN) ) $errmsg = 'Tanggal Buku harus lebih besar dari Tanggal Closing !';					
				}else{//edit
					$idbi = $_POST['idbi'];
					$old =  mysql_fetch_array( mysql_query (
						"select * from buku_induk where id = '$idbi'"
					));
					if($errmsg=='' && $tgl_buku!=$old['tgl_buku'] && (sudahClosing($tgl_buku, $fmSKPD, $fmUNIT, $fmSUBUNIT, $fmSEKSI, $fmURUSAN) || ($old['id']<>$old['idawal']) || ($old['status_barang']=='2' || $old['staset']=='7') || ($old['refid_terima']<>'' || $old['refid_terima']<>'0')) ){
						
							$errmsg='Data sudah closing tidak bisa diedit !';
							
							$fmURUSAN = $old['c1'];
							$fmSKPD = $old['c'];
							$fmUNIT = $old['d'];
							$fmSUBUNIT = $old['e'];
							$fmSEKSI = $old['e1'];
							$fmIDBARANG = $old['f'].".".$old['g'].".".$old['h'].".".$old['i'].".".$old['j'];
							$fmTAHUNPEROLEHAN = $old['thn_perolehan'];
							$fmREGISTER = $old['noreg'];
							$fmHARGABARANGBELI = $old['harga_beli'];
							$fmHARGABARANGATRIBUSI = $old['harga_atribusi'];
							$fmHARGABARANG = $old['harga']; //harga_satuan
							$fmJUMLAHBARANG = $old['jml_barang'];
							$fmSATUAN = $old['satuan'];
							$fmASALUSUL = $old['asal_usul'];
							$fmJENISHIBAH = $old['jns_hibah'];
							$fmSTATUSASET = $old['staset'];
							$fmKONDISIBARANG = $old['kondisi'];
							$tgl_buku = $old['tgl_buku'];
							if($old['tgl_ba']==''){
								$no_ba = $old['no_ba'];
								$tgl_ba = $old['tgl_ba'];
							}
							if($old['tgl_spk']==''){
								$no_spk = $old['no_spk'];
								$tgl_spk = $old['tgl_spk'];
							}
							$bk = $old['bk'];
							$ck = $old['ck'];
							$dk = $old['dk'];
							$bk_p = $old['bk_p'];
							$ck_p = $old['ck_p'];
							$dk_p = $old['dk_p'];
							$fmPROGRAM = $old['p'];
							$fmKEGIATAN = $old['q'];
							
					}					
					if($errmsg=='' && $tgl_buku!=$old['tgl_buku'] && sudahClosing($tgl_buku, $fmSKPD, $fmUNIT, $fmSUBUNIT, $fmSEKSI, $fmURUSAN) ) $errmsg = 'Tanggal Buku harus lebih besar dari Tanggal Closing !';
				}
				$cek .= '<br> errmsg = '.$errmsg;
				if ($errmsg==''){	
					$cek .= '<br> cidBI= '.$cidBI;
					$cek .= '<br> Act= '.$Act;
					$cek .= '<br> Baru= '.$Baru;
					$cek .= '<br>idbarang ='.$fmIDBARANG;
					$ArBarang = explode(".",$fmIDBARANG);	
					$ArBarang_old = explode(".",$fmIDBARANG_old);	$cek .= '<br>idbarang_old ='.$fmIDBARANG_old;
						 
					if($Main->CekIntraEkstra == TRUE && $isMutasi == FALSE) //jika simpan mutasi , staset barang baru hasil mutasi harus sama dengan staset brg lama
					{
						if ($fmSTATUSASET==10)
						{
							$errmsg=cekektra($ArBarang[0],$ArBarang[1],$ArBarang[2],$ArBarang[3],$ArBarang[4],$fmHARGABARANG);
						}
						if ($fmSTATUSASET<>10 && $fmSTATUSASET<>9)
						{
							// $fmSTATUSASET=make_to_ektra($ArBarang_old[0],$ArBarang_old[1],$ArBarang_old[2],$ArBarang_old[3],$ArBarang_old[4],$fmHARGABARANG,$fmSTATUSASET);
							 //$fmSTATUSASET=make_to_ektra($ArBarang[0],$ArBarang[1],$ArBarang[2],$ArBarang[3],$ArBarang[4],$fmHARGABARANG,$fmSTATUSASET);
						}
						// $errmsg=$ArBarang[0].'zz';
					}
					
				$fmJUMLAHHARGA = $fmJUMLAHBARANG * $fmHARGABARANG;
				$Sukses = false;
				
				//set staset $fmSTATUSASET ----------------------------------------------------
				//$errmsg = "$Main->VERSI_NAME, $fmSTATUSASET, ".$ArBarang[0].", $fmHARGABARANG";
				//if($fmSTATUSASET==3 || $fmSTATUSASET==10){
				//$fmSTATUSASET = getStatusAset($fmSTATUSASET, $fmKONDISIBARANG, $fmHARGABARANG,  $ArBarang[0], $ArBarang[1], $ArBarang[2], $ArBarang[3], $ArBarang[4], $fmTAHUNPEROLEHAN );
				
				if($ArBarang[0]=="02"){
					//cek no polisi tidak boleh sama
					$cekfmPOLISI_KIB_B= str_replace(' ','',$fmPOLISI_KIB_B);
					if($cekfmPOLISI_KIB_B != "" && $cekfmPOLISI_KIB_B != "-"){
						$cekpol = mysql_fetch_array(mysql_query("select count(*) as cnt from kib_b where replace(no_polisi,' ','')='$cekfmPOLISI_KIB_B' and idbi <> '$idbi' and idbi <> '$fmIdAwal';"));
						if ($errmsg=='' && $cekpol['cnt']>0) {$errmsg = 'No Polisi Tidak boleh sama !';}
					}
					
					//cek no pabrik tidak boleh sama
					$cekfmPABRIK_KIB_B= str_replace(' ','',$fmPABRIK_KIB_B);
					if($cekfmPABRIK_KIB_B != "" && $cekfmPABRIK_KIB_B != "-"){
						$cekpab = mysql_fetch_array(mysql_query("select count(*) as cnt from kib_b where replace(no_pabrik,' ','')='$cekfmPABRIK_KIB_B' and idbi <> '$idbi' and idbi <> '$fmIdAwal';"));
						if ($errmsg=='' && $cekpab['cnt']>0) {$errmsg = 'No Pabrik Tidak boleh sama !';}
					}
					
					//cek no mesin tidak boleh sama
					$cekfmMESIN_KIB_B= str_replace(' ','',$fmMESIN_KIB_B);
					if($cekfmMESIN_KIB_B != "" && $cekfmMESIN_KIB_B != "-"){
						$cekmes = mysql_fetch_array(mysql_query("select count(*) as cnt from kib_b where replace(no_mesin,' ','')='$cekfmMESIN_KIB_B' and idbi <> '$idbi' and idbi <> '$fmIdAwal';"));
						if ($errmsg=='' && $cekmes['cnt']>0) {$errmsg = 'No Mesin Tidak boleh sama !';}
					}
					
					//cek no rangka tidak boleh sama
					$cekfmRANGKA_KIB_B= str_replace(' ','',$fmRANGKA_KIB_B);
					if($cekfmRANGKA_KIB_B != "" && $cekfmRANGKA_KIB_B != "-"){
						$cekrang = mysql_fetch_array(mysql_query("select count(*) as cnt from kib_b where replace(no_rangka,' ','')='$cekfmRANGKA_KIB_B' and idbi <> '$idbi' and idbi <> '$fmIdAwal';"));
						if ($errmsg=='' && $cekrang['cnt']>0) {$errmsg = 'No Rangka Tidak boleh sama !';}
					}
					
					//cek no bpkb tidak boleh sama
					$cekfmBPKB_KIB_B= str_replace(' ','',$fmBPKB_KIB_B);
					if($cekfmBPKB_KIB_B != "" && $cekfmBPKB_KIB_B != "-"){
						$cekbpkb = mysql_fetch_array(mysql_query("select count(*) as cnt from kib_b where replace(no_bpkb,' ','')='$cekfmBPKB_KIB_B' and idbi <> '$idbi' and idbi <> '$fmIdAwal';"));
						if ($errmsg=='' && $cekbpkb['cnt']>0) {$errmsg = 'No BPKB Tidak boleh sama !';}
					}
				}
				
				
				
				//$errmsg .= " , $fmSTATUSASET"; 
				if($errmsg == ''){
					
			
					switch($Baru){
						case '0':{//edit ------------------------------------------------------------------	
								$idbi_ = $_REQUEST['idbi'];
								$old= mysql_fetch_array(mysql_query(
									"select * from buku_induk where id='$idbi_'"
								));
								
								//if($fmKONDISIBARANG == 3 ) $fmSTATUSASET = getStatusAset($fmSTATUSASET, $fmKONDISIBARANG, $fmHARGABARANG,  $ArBarang[0], $ArBarang[1], $ArBarang[2], $ArBarang[3], $ArBarang[4] );			
								//$fmSTATUSASET = getStatusAset($fmSTATUSASET, $fmKONDISIBARANG, $fmHARGABARANG,  $ArBarang[0], $ArBarang[1], $ArBarang[2], $ArBarang[3], $ArBarang[4] );			
								if($errmsg=='' && $fmSTATUSASET=='' && $Main->STASET_OTOMATIS==FALSE) $errmsg ='Status Aset belum dipilih!';
								
								//cek sudah ada transaksi lain
								if($errmsg==''){
									$jmltrans = mysql_fetch_array(mysql_query(
										"select count(*) as cnt from t_transaksi where idbi = '$idbi_' "
									));
								}
								if($errmsg=='' && $old['staset']!= $fmSTATUSASET && $jmltrans['cnt']>1 ) $errmsg = 'Status Aset tidak bisa di ganti, sudah ada transaksi lain!';
									//"select count(*) as cnt from t_transaksi where idbi = '$idbi_' ". 
									//' old= '.$old['staset'].'$fmSTATUSASET='.$fmSTATUSASET.' jmltrans='.$jmltrans['cnt'];
								
			
								$fmSEKSI_old = $old['e1'];//$_REQUEST['fmSEKSI_old'];
								
								//else if($Baru==0){
								$cek .='<br>$idbi_ = '.$idbi_;
								$cek .='<br>fmSubunit before_simpan = '.$fmSUBUNIT;
								$cek .='<br>fmSubunit_old before_simpan = '.$fmSUBUNIT_old;
								$cek .='<br>fmUNIT_old before_simpan = '.$fmUNIT_old;
								$cek .='<br>fmSKPD_old before_simpan = '.$fmSKPD_old;			
								$cek .='<br>fmSEKSI_old before_simpan = '.$fmSEKSI_old;
								$cek .='<br>fmSEKSI = '.$fmSEKSI;			
								$cek .='<br>fmWIL before_simpan = '.$old['b'];
								$cek .='<br>fmWIL  = '.$fmWIL;
								//$errmsg = $cek;
								if ($alamat_b !=''){$alamat_a = $Main->DEF_PROPINSI;}
									
								//$Kriteria = "concat(a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg)=	'$fmKEPEMILIKAN{$Main->Provinsi[0]}$fmWIL$fmSKPD_old$fmUNIT_old$fmSUBUNIT_old$fmSEKSI_old{$ArBarang_old[0]}{$ArBarang_old[1]}{$ArBarang_old[2]}{$ArBarang_old[3]}{$ArBarang_old[4]}$fmTAHUNANGGARAN_old$fmREGISTER_old'";
								$KriteriaKIB =  " idbi= $idbi_";
																
								if ($nilai_appraisal==''){$nilai_appraisal=0;}		//$cek .= '<br> nil appraisal3= '.$nilai_appraisal;
																
								//cek no baru --------------------	
								if( ($fmSKPD_old != $fmSKPD)|| ($fmUNIT_old != $fmUNIT)|| ($fmSUBUNIT_old != $fmSUBUNIT)||
									($fmREGISTER != $fmREGISTER_old) || ($fmTAHUNPEROLEHAN != $fmTAHUNPEROLEHAN_old ) || 
									($fmIDBARANG != $fmIDBARANG_old) || ($fmTAHUNANGGARAN != $fmTAHUNANGGARAN_old) || $fmSEKSI !=$fmSEKSI_old )
								{							
										$CekBaru = mysql_num_rows(mysql_query(
											"select * from buku_induk where concat(a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg)=
											'$fmKEPEMILIKAN{$Main->Provinsi[0]}$fmWIL$fmSKPD$fmUNIT$fmSUBUNIT$fmSEKSI{$ArBarang[0]}{$ArBarang[1]}{$ArBarang[2]}{$ArBarang[3]}{$ArBarang[4]}$fmTAHUNPEROLEHAN$fmREGISTER'")
										);
								}
								//$cek .= '<br> cekregister'.$CekBaru;
								if($errmsg == '' && $CekBaru){
									$errmsg = "Data TIDAK dapat disimpan \\n Nomor Register $fmREGISTER tahun $fmTAHUNPEROLEHAN sudah ada!!!";
								}
								
								//cek sudah dihapus -----------------
								if($errmsg=='' ){
									//$get = mysql_fetch_array( mysql_query("select * from buku_induk where ") );
									if ($old['status_barang'] == 3){
										$errmsg = 'Data Sudah Penghapusan Tidak Bisa Di Edit!';
									}
								}
								
																
								//cek sudah koreksi
								if( $errmsg=='' &&  $old['jml_harga'] <> $fmHARGABARANG ){
									$get = mysql_fetch_array(mysql_query("select count(*) as cnt from t_koreksi where  idbi ='$idbi_' "));
									if($get['cnt']>0) $errmsg = "Harga Perolehan tidak dapat diganti, sudah ada Koreksi !  ";
								}
								
								//cek sudah penilaian
								if( $errmsg=='' &&  $old['jml_harga'] <> $fmHARGABARANG ){
									$get = mysql_fetch_array(mysql_query("select count(*) as cnt from penilaian where  id_bukuinduk ='$idbi_' "));
									if($get['cnt']>0) $errmsg = "Harga Perolehan tidak dapat diganti, sudah ada Penilaian !";
								}
								
								
								//cek staset  ------------------
								/*if( $errmsg=='' && ( $old['staset'] == 9  ) &&  $old['staset'] != $fmSTATUSASET ){
									$get = mysql_fetch_array(mysql_query("select count(*) as cnt from t_asetlainlain where staset is not null and idbi ='$idbi_' "));
									if($get['cnt']>0) $errmsg = "Status aset bukan saat perolehan tidak dapat diganti!";
									//$errmsg = 'Untuk mengganti Status Aset, gunakan tombol Reklas Aset Lain-lain!';
								}
								if( $errmsg=='' && ( $old['staset'] == 10  ) &&  $old['staset'] != $fmSTATUSASET){
									$get = mysql_fetch_array(mysql_query("select count(*) as cnt from t_kapitalisasi where staset is not null and idbi ='$idbi_' "));
									if($get['cnt']>0) $errmsg = "Status aset bukan saat perolehan tidak dapat diganti!";
									//$errmsg = 'Untuk mengganti Status Aset, gunakan tombol Reklas Aset Lain-lain!';
								}
								*/
								if($errmsg=='' && $old['staset'] <> $fmSTATUSASET && ($old['id'] <> $old['idawal']) ){
									$errmsg = "Status Aset untuk barang hasil mutasi atau reklass tidak bisa di ganti!";
								}
								
								
								//cek staset  ------------------
								if( $errmsg=='' && ( $old['staset'] == 9  ) &&  $old['staset'] != $fmSTATUSASET ){
									$get = mysql_fetch_array(mysql_query("select count(*) as cnt from t_asetlainlain where staset is not null and idbi ='{$old['id']}' "));
									if($get['cnt']>1) $errmsg = "Status aset bukan saat perolehan tidak dapat diganti!";
									//$errmsg = 'Untuk mengganti Status Aset, gunakan tombol Reklas Aset Lain-lain!';
								}
								if( $errmsg=='' && ( $old['staset'] == 10  ) &&  $old['staset'] != $fmSTATUSASET){
									$get = mysql_fetch_array(mysql_query("select count(*) as cnt from t_kapitalisasi where staset is not null and idbi ='{$old['id']}' "));
									if($get['cnt']>1) $errmsg = "Status aset bukan saat perolehan tidak dapat diganti!";
									//$errmsg = 'Untuk mengganti Status Aset, gunakan tombol Reklas Aset Lain-lain!';
								}
								if( $errmsg=='' && $old['staset'] != $fmSTATUSASET){
									$get = mysql_fetch_array(mysql_query("select count(*) as cnt from t_history_aset where idbi = '{$old['id']}' "));
									if($get['cnt']>1) $errmsg = "Status aset bukan saat perolehan tidak dapat diganti!";
								}
								
								//cek asal usul ---------------------
								if($errmsg=='' ){
									//$old = mysql_fetch_array(mysql_query("select * from buku_induk where "));
									//if( ( $old['asal_usul']!=$fmASALUSUL && $old['asal_usul']>3 ) || ($old['asal_usul']<=3 && $fmASALUSUL>3) ) 
									if( ( $old['asal_usul']!=$fmASALUSUL && $old['asal_usul']>3 ) || ($old['asal_usul']<=3 && ($fmASALUSUL==4 || $fmASALUSUL==5 || $fmASALUSUL==7)) ) 
										$errmsg = 'Asal Usul yang diperbolehkan diedit hanya Pembelian, Hadiah/Hibah dan Lainnya!';									
								}
								
								
								
								$fmHARGABARANG = $fmHARGABARANGBELI + $fmHARGABARANGATRIBUSI;
								$fmJUMLAHHARGA = $fmHARGABARANG;
								
								//cek harga
								if($fmHARGABARANG <> $old['jml_harga']){
									//jika sudah reklas aset lainlain/kapitalisasi harga tidak bisa diganti
									$get = mysql_fetch_array(mysql_query("select count(*) as cnt from t_history_aset where idbi = '{$old['id']}' "));
									if($get['cnt']>1) $errmsg = "Sudah ada perubahan status aset, Harga perolehan tidak dapat diganti!";									
								}
								
								//cek -> jumlah harga tidak bisa di edit jika :								
								if( $errmsg =='' && $old['jml_harga'] <> $fmJUMLAHHARGA  ) {
									//staset sudah berubah
									//14. penghapsuan, 15.mutasi, 16.reklas, 17.pemindahtangan, 18.tgr, 19.kemitraan, 
									//21. reklas aset lainlain, 22.kapitalisasi, 
									//26. pemidahtangan hibah, 27.Pemindahtanganan Tukar Menukar, 32. pemindahtangan penyertaan modal,
									//30. penysuutan									
									$trans = mysql_fetch_array(mysql_query( "select count(*) as cnt from t_transaksi where idbi='".$old['id']."' and jns_trans2=14 ;"));
									if( $errmsg =='' && $trans['cnt'] > 0  ) $errmsg = " Harga tidak bisa diedit sudah penghapusan! ";
									$trans = mysql_fetch_array(mysql_query( "select count(*) as cnt from t_transaksi where idbi='".$old['id']."' and jns_trans2=15 ;"));
									if( $errmsg =='' && $trans['cnt'] > 0  ) $errmsg = " Harga tidak bisa diedit sudah pindah antar skpd! ";
									$trans = mysql_fetch_array(mysql_query( "select count(*) as cnt from t_transaksi where idbi='".$old['id']."' and jns_trans2=16 ;"));
									if( $errmsg =='' && $trans['cnt'] > 0  ) $errmsg = " Harga tidak bisa diedit sudah reklas! ";
									$trans = mysql_fetch_array(mysql_query( "select count(*) as cnt from t_transaksi where idbi='".$old['id']."' and jns_trans2=17 ;"));
									if( $errmsg =='' && $trans['cnt'] > 0  ) $errmsg = " Harga tidak bisa diedit sudah pemindahtangan penjualan! ";
									$trans = mysql_fetch_array(mysql_query( "select count(*) as cnt from t_transaksi where idbi='".$old['id']."' and jns_trans2=18 ;"));
									if( $errmsg =='' && $trans['cnt'] > 0  ) $errmsg = " Harga tidak bisa diedit sudah Tuntutan Ganti Rugi! ";
									$trans = mysql_fetch_array(mysql_query( "select count(*) as cnt from t_transaksi where idbi='".$old['id']."' and jns_trans2=19 ;"));
									if( $errmsg =='' && $trans['cnt'] > 0  ) $errmsg = " Harga tidak bisa diedit sudah Pemanfaatan! ";
									$trans = mysql_fetch_array(mysql_query( "select count(*) as cnt from t_transaksi where idbi='".$old['id']."' and jns_trans2=21 ;"));
									if( $errmsg =='' && $trans['cnt'] > 0  ) $errmsg = " Harga tidak bisa diedit sudah reklas aset lain lain! ";
									$trans = mysql_fetch_array(mysql_query( "select count(*) as cnt from t_transaksi where idbi='".$old['id']."' and jns_trans2=22 ;"));
									if( $errmsg =='' && $trans['cnt'] > 0  ) $errmsg = " Harga tidak bisa diedit sudah kapitalisasi! ";
									$trans = mysql_fetch_array(mysql_query( "select count(*) as cnt from t_transaksi where idbi='".$old['id']."' and jns_trans2=26 ;"));
									if( $errmsg =='' && $trans['cnt'] > 0  ) $errmsg = " Harga tidak bisa diedit sudah pemindahtanganan hibah! ";
									$trans = mysql_fetch_array(mysql_query( "select count(*) as cnt from t_transaksi where idbi='".$old['id']."' and jns_trans2=27 ;"));
									if( $errmsg =='' && $trans['cnt'] > 0  ) $errmsg = " Harga tidak bisa diedit sudah pemindahtanganan tukar menukar! ";
									$trans = mysql_fetch_array(mysql_query( "select count(*) as cnt from t_transaksi where idbi='".$old['id']."' and jns_trans2=32 ;"));
									if( $errmsg =='' && $trans['cnt'] > 0  ) $errmsg = " Harga tidak bisa diedit sudah pemindahtanganan penyertaan modal! ";
									//$trans = mysql_fetch_array(mysql_query( "select count(*) as cnt from t_transaksi where idbi='".$old['id']."' and jns_trans2=30 ;"));
									//if( $errmsg =='' && $trans['cnt'] > 0  ) $errmsg = " Harga tidak bisa diedit sudah penyusutan! ";
									
									
								}
								
								// cek sudah penyusutan
								if($errmsg=='' ){
									$susut = mysql_fetch_array(mysql_query("select count(*) as cnt from penyusutan where idbi = '".$old['id']."' "));
									if($errmsg=='' && $susut['cnt']>0 &&  $old['jml_harga'] <> $fmJUMLAHHARGA ) $errmsg = 'Harga tidak bisa diedit sudah penyusutan!';
									if($errmsg=='' && $susut['cnt']>0 &&  $old['tgl_buku'] <> $tgl_buku ) $errmsg = 'Tanggal Buku tidak bisa diedit sudah penyusutan!';	
									if($errmsg=='' && $susut['cnt']>0 &&  $old['thn_perolehan'] <> $fmTAHUNPEROLEHAN ) $errmsg = 'Tahun Perolehan tidak bisa diedit sudah penyusutan!';	
									
								}
								
								if($tgl_buku!=$old['tgl_buku'] && (sudahClosing($tgl_buku, $fmSKPD, $fmUNIT, $fmSUBUNIT, $fmSEKSI, $fmURUSAN) || ($old['id']<>$old['idawal']) || ($old['status_barang']=='2' || $old['staset']=='7')) ){
									$update="";
									$update2="";
									
									if($old['tgl_ba']==$tgl_ba){
										$upTglBA = "";
									}else{
										$upTglBA = "tgl_ba='$tgl_ba', 
													no_ba='$no_ba',";
									}
									
									if($old['tgl_spk']==$tgl_spk){
										$upTglSPK = "";
									}else{
										$upTglSPK = "no_spk='$no_spk', 
													tgl_spk='$tgl_spk',";
									}
								}else{
									$update="
											c ='$fmSKPD',
											d ='$fmUNIT',
											e ='$fmSUBUNIT',
											e1 ='$fmSEKSI',					
											f ='{$ArBarang[0]}',
											g ='{$ArBarang[1]}',
											h ='{$ArBarang[2]}',
											i ='{$ArBarang[3]}',
											j ='{$ArBarang[4]}',
											";
									$update2="
											thn_perolehan='$fmTAHUNPEROLEHAN',
											harga_beli='$fmHARGABARANGBELI',
											harga_atribusi='$fmHARGABARANGATRIBUSI',
											harga='$fmHARGABARANG',
											jml_barang=1,
											satuan='$fmSATUAN',
											asal_usul='$fmASALUSUL',
											jns_hibah='$fmJENISHIBAH',
											staset='$fmSTATUSASET',
											tgl_buku='".$tgl_buku."',
											noreg ='$fmREGISTER',
											kondisi='$fmKONDISIBARANG',
											bk='$bk',
											ck='$ck',
											dk='$dk',
											bk_p='$bk_p',
											ck_p='$ck_p',
											dk_p='$dk_p',
											p='$fmPROGRAM',
											q='$fmKEGIATAN',
											";
									$upTglBA="tgl_ba='$tgl_ba', 
											  no_ba='$no_ba',";
									$upTglSPK="no_spk='$no_spk', 
											   tgl_spk='$tgl_spk',";
								}
								if($ArBarang[0]=="03"){
									$no_barang = $fmNOGEDUNG_KIB_C;
								}elseif($ArBarang[0]=="04"){
									$no_barang = $fmNORUASJALAN_KIB_D;
								}else{
									$no_barang = "";
								}
								
								//$errmsg = 'tes';
								if($errmsg ==''){
									$old=mysql_fetch_array(mysql_query(
										"select * from buku_induk where id= '$idbi_' "
									));
									//UPDATE BI ------------------------------------------------------
									$Qry = 
									"update buku_induk set ".									
									$update.
									
									"ref_idpemegang='$ref_idpemegang',  
									ref_idpemegang2='$ref_idpemegang2',  
									ref_idpenanggung='$ref_idpenanggung', 
									ref_idruang='$ref_idruang',".
									
									"penggunaan='$penggunabi',".
									
									$update2.
									$upTglBA.
									$upTglSPK.
									"tahun='$fmTAHUNANGGARAN', ".
									
									"jml_harga='$fmJUMLAHHARGA',
									ref_idatribusi='$ref_idatribusi',".
											
									"tgl_update=now(),
									nilai_appraisal=".$nilai_appraisal.",							
									
									tgl_sensus='".$tgl_sensus."',
									no_barang='".$no_barang."',
									kampung='".$kampung."',
									rt='".$rt."',
									rw='".$rw."',
									uid ='".$UID."'					
									where id= '$idbi_' ";
									
									$cek .= '<br>qrybi updt='.$Qry;
									//$errmsg = $cek;
									$Sukses = mysql_query($Qry);
									$idbukuinduk = $idbi_;//mysql_fetch_array(mysql_query("select id as id from buku_induk where $Kriteria"));					
									
									if($Sukses){
										
										/**$InsertHistory = mysql_query("insert into history_barang (a,b,c,d,e,e1,f,g,h,i,j,id_bukuinduk,tahun,noreg,tgl_update,kejadian,kondisi)".
											"values('{$Main->Provinsi[0]}','$fmWIL','$fmSKPD','$fmUNIT','$fmSUBUNIT','$fmSEKSI','{$ArBarang[0]}','{$ArBarang[1]}','{$ArBarang[2]}',".
												"'{$ArBarang[3]}','{$ArBarang[4]}','{$idbukuinduk[0]}','$fmTAHUNANGGARAN','$fmREGISTER',now(),'Update Inventaris',".
												"'$fmKONDISIBARANG')");
										**/
									
										//if($Main->MODUL_HISTORY) insertIntoHistory( 2, $idbi_, $old, $UID, $ket_koreksi );
										//if($Main->MODUL_JURNAL) $jurnal= jurnalKoreksi($old,$idbi,$UID);
										
										//update history aset lainlain ------------------------------------
										if( $Sukses && $fmSTATUSASET <> $old['staset'] && ($fmSTATUSASET ==9 || $old['staset'] == 9 )){												
											//if( $old['id_lama'] == '') {//perolehan baru	
											$get = mysql_fetch_array(mysql_query("select count(*) as cnt from t_asetlainlain where idbi = '$idbi' "));
											if( $get['cnt'] <= 1 ){	
												mysql_query("delete from t_asetlainlain  where idbi='$idbi' and (staset is null or staset='') ");	
												if($fmSTATUSASET==9){
													$Sukses = mysql_query( "insert into t_asetlainlain ".
														"(tgl,idbi,uid,tgl_update,staset,staset_baru,ket,kondisi,kondisi_baru,idbi_awal) values ".
														"('$tgl_buku','$idbi','$UID',now(),null,'$fmSTATUSASET', '', null, '$fmKONDISIBARANG','".$old['idawal']."') "
													);	
												}	
																
											}	
										}
										//update extra berubah dari / ke staset 10 ------------------------------------
										if( $Sukses && $fmSTATUSASET <> $old['staset'] && ($fmSTATUSASET ==10 || $old['staset'] == 10 ) ){
											$get = mysql_fetch_array(mysql_query("select count(*) as cnt from t_kapitalisasi where idbi = '$idbi' "));
											if( $get['cnt'] <= 1 ){											
												mysql_query("delete from t_kapitalisasi  where idbi='$idbi' and (staset is null or staset='') ");										
												if($fmSTATUSASET ==10){
													$Sukses = mysql_query( "insert into t_kapitalisasi ".
														"(tgl,idbi,uid,tgl_update,staset,staset_baru,ket,idbi_awal) values ".
														"('$tgl_buku','$idbi','$UID',now(),null,'$fmSTATUSASET', '','".$old['idawal']."' ) "
													);
												}
												
											}
										}
									
										//update history aset -----------------------------------------------------
										if($Sukses && $fmSTATUSASET <> $old['staset'] && ($fmSTATUSASET ==3 || $fmSTATUSASET ==9 || $fmSTATUSASET ==10 ) ){
											$get = mysql_fetch_array(mysql_query("select count(*) as cnt from t_history_aset where idbi = '$idbi' "));
											if( $get['cnt'] <= 1 ){											
											
												if( $fmSTATUSASET==9  ){
													$jns_ = 2;	
													$refid= mysql_insert_id();														
												}else if( $fmSTATUSASET==10 ){
													$jns_ = 3;	
													$refid= mysql_insert_id();											
												}else{
													$jns_ = 1;
													$refid = $idbi;
												} 
												//***
												mysql_query("delete from t_history_aset  where idbi='$idbi' and (staset is null or staset='0') ");																				
												mysql_query(
													"insert into t_history_aset ".
													"(tgl,idbi,uid,tgl_update,staset,staset_baru,div_staset,idbi_awal,jns,refid, uid_create, tgl_create) ".
													" values ".
													"('$tgl_buku','$idbi','$UID',now(),0,'$fmSTATUSASET','".$fmSTATUSASET."','".$old['idawal']."',$jns_,'$refid', '".$old['uid_create']."', '".$old['tgl_create']."' )"
												);
												//**/
												//mysql_query("update t_history_aset ".
												//	" set  ".
												//	" where idbi='$idbi' and (staset is null or staset='0')  ");
												
											}
										}
										
										//update kondisi ----------------------------------------
										
										if($Sukses){
										
											if($old['kondisi'] <> $fmKONDISIBARANG || $old['tgl_buku']<>$tgl_buku ){
												
												
												$Sukses = mysql_query(" delete from t_kondisi where idbi = '$idbi' and kond_awal=0 ; ");
												//$Sukses = FALSE; $errmsg = 'tes saja, update kondisi gagal!';
												if($Sukses) {
													$qrykondisi = "insert into t_kondisi ".
														"(tgl, idbi, idbi_awal,kond_awal,kond_akhir,dif_kondisi,ket,tgl_update,uid,uid_create,tgl_create )".
														" values('$tgl_buku', '$idbi', '$idbi', 0, '$fmKONDISIBARANG', '$fmKONDISIBARANG',
														'',now(), '$UID', '".$old['uid_create']."', '".$old['tgl_create']."' ) ; ";
													$Sukses= mysql_query($qrykondisi);
												}											
												if($Sukses == FALSE) $errmsg = 'update kondisi gagal!'.$qrykondisi;
											}	
										}
										
										
									
										//update jurnal ------------------------------------------ 
										if($Sukses){
											//1=pembelian, 2=hibah, 3=lainnya, 7=koreksi pembukuan, 8=Perolehan Extrakomptable, 28=Perolehan Aset Lain-lain											
											//$trns = mysql_fetch_array(mysql_query(" select count(*) as cnt from t_transaksi where idawal='".$old['idawal']."' ")); 											
											//if( $old['idawal'] == $old['id'] && $trns['cnt']==1  ){
											//if( $trns['cnt']==1  ){
												//if ($Main->VERSI_NAME != 'GARUT'){
												/**if($old['tgl_buku']!=$tgl_buku || $old['jml_harga'] !=$fmJUMLAHHARGA ||
													$old['staset'] != $fmSTATUSASET || $old['asal_usul'] !=$fmASALUSUL || 
													$old['thn_perolehan']!=$fmTAHUNPEROLEHAN
													
												){**/
												if($old['tgl_buku']!=$tgl_buku || $old['jml_harga'] !=$fmJUMLAHHARGA ||
													$old['harga_beli'] !=$fmHARGABARANGBELI || $old['harga_atribusi'] !=$fmHARGABARANGATRIBUSI ||
													$old['staset'] != $fmSTATUSASET || $old['asal_usul'] !=$fmASALUSUL || 
													$old['thn_perolehan']!=$fmTAHUNPEROLEHAN ||
													$old['f'] != $ArBarang[0] || 
													$old['g'] != $ArBarang[1] || 
													$old['h'] != $ArBarang[2] || 
													$old['i'] != $ArBarang[3] || 
													$old['j'] != $ArBarang[4] ||
													$old['c'] != $fmSKPD||
													$old['d'] != $fmUNIT ||
													$old['e'] != $fmSUBUNIT ||
													$old['e1'] != $fmSEKSI
												){
													mysql_query(
														" delete from t_transaksi where (jns_trans2=1 or jns_trans2=2 or jns_trans2=3 ".
														" or jns_trans2=4 or jns_trans2=5 or jns_trans2=6 ".
		      											" or jns_trans2=7 or jns_trans2=8 or jns_trans2=28 ) and refid='$idbi'; "
													);		    
													mysql_query(" call sp_jurnal_bi('$idbi') ; ");
													//	mysql_query(" select sf_jurnal_bi($idbi) as cek ; ");
												}
												//}												
											//}
										}
										
									if ($Sukses){
									//UPDATE KIB A			
									if($ArBarang[0]=="01"){
											//sertifikat_tgl='".TglSQL($fmTGLSERTIFIKAT_KIB_A)."', 
										if ($alamat_b !=''){$alamat_a = $Main->DEF_PROPINSI;}
											$Qry = 
											"update kib_a set ".
											"c ='$fmSKPD',d ='$fmUNIT',e ='$fmSUBUNIT',e1 ='$fmSEKSI',	
											f ='{$ArBarang[0]}',g ='{$ArBarang[1]}',h ='{$ArBarang[2]}',i ='{$ArBarang[3]}',j ='{$ArBarang[4]}',
											tahun='$fmTAHUNANGGARAN',	noreg ='$fmREGISTER',".
											
											"luas='$fmLUAS_KIB_A', 											
											alamat='$fmLETAK_KIB_A', 
											alamat_kel='$alamat_kel', 
											alamat_kec='$alamat_kec', 
											alamat_a='$alamat_a', 
											alamat_b='$alamat_b', 
											alamat_c='$alamat_c', 
											kota='$alamat_kota', 

											koordinat_gps='$koordinat_gps',
											koord_bidang='$koord_bidang', 
											
											status_hak='$fmHAKPAKAI_KIB_A', 
											bersertifikat = '$bersertifikat',					
											sertifikat_tgl='".$fmTGLSERTIFIKAT_KIB_A."', 
											sertifikat_no='$fmNOSERTIFIKAT_KIB_A',
											penggunaan='$fmPENGGUNAAN_KIB_A', 
											blok='$fmBLOK_KIB_A',
											persil='$fmPERSIL_KIB_A',
											ket='$fmKET_KIB_A' where $KriteriaKIB";
											
											$cek.='<br> qry udt kiba='.$Qry; //$errmsg.=$cek;
											$Sukses = mysql_query($Qry);
										}
									//UPDATE KIB B
									else if($ArBarang[0]=="02"){					
											$Qry = "update kib_b set ".
											"c ='$fmSKPD',
											d ='$fmUNIT',
											e ='$fmSUBUNIT',
											e1 ='$fmSEKSI',	
											f ='{$ArBarang[0]}',
											g ='{$ArBarang[1]}',
											h ='{$ArBarang[2]}',
											i ='{$ArBarang[3]}',
											j ='{$ArBarang[4]}',
											
											tahun='$fmTAHUNANGGARAN',	noreg ='$fmREGISTER',".
											"merk = '$fmMERK_KIB_B', ukuran = '$fmUKURAN_KIB_B', bahan = '$fmBAHAN_KIB_B', no_pabrik = '$fmPABRIK_KIB_B', no_rangka = '$fmRANGKA_KIB_B', no_mesin = '$fmMESIN_KIB_B', no_polisi = '$fmPOLISI_KIB_B', no_bpkb = '$fmBPKB_KIB_B', ket = '$fmKET_KIB_B' 
											where $KriteriaKIB";
											//echo $Qry ;
											$Sukses = mysql_query($Qry);
										}
									//UPDATE KIB C
									else if($ArBarang[0]=="03"){
											if ($alamat_b !=''){$alamat_a = $Main->DEF_PROPINSI;}
											$Qry = "update kib_c set ".
											"c ='$fmSKPD',
											d ='$fmUNIT',
											e ='$fmSUBUNIT',
											e1 ='$fmSEKSI',	
											f ='{$ArBarang[0]}',
											g ='{$ArBarang[1]}',
											h ='{$ArBarang[2]}',
											i ='{$ArBarang[3]}',
											j ='{$ArBarang[4]}',
											
											tahun='$fmTAHUNANGGARAN',	noreg ='$fmREGISTER',
											".
											"kondisi = '$fmKONDISI_KIB_C', 
											konstruksi_tingkat = '$fmTINGKAT_KIB_C', 
											konstruksi_beton = '$fmBETON_KIB_C', 
											luas_lantai = '$fmLUASLANTAI_KIB_C', 
											alamat = '$fmLETAK_KIB_C', 
											alamat_kel='$alamat_kel', 
											alamat_kec='$alamat_kec', 
											alamat_a='$alamat_a', 
											alamat_b='$alamat_b',
											alamat_c='$alamat_c', 
											kota='$alamat_kota', 
											 
											koordinat_gps='$koordinat_gps', 
											koord_bidang='$koord_bidang', 
											dokumen_tgl = '".$fmTGLGUDANG_KIB_C."', dokumen_no = '$fmNOGUDANG_KIB_C', 
											luas = '$fmLUAS_KIB_C', status_tanah = '$fmSTATUSTANAH_KIB_C', 
											kode_tanah = '$fmNOKODETANAH_KIB_C', 
											
											ket = '$fmKET_KIB_C' 
											where $KriteriaKIB";
											$Sukses = mysql_query($Qry);
										}
									//UPDATE KIB D
									else if($ArBarang[0]=="04"){
										if ($alamat_b !=''){$alamat_a = $Main->DEF_PROPINSI;}
											$Qry = "update kib_d set 
											c ='$fmSKPD',
											d ='$fmUNIT',
											e ='$fmSUBUNIT',
											e1 ='$fmSEKSI',	
											f ='{$ArBarang[0]}',
											g ='{$ArBarang[1]}',
											h ='{$ArBarang[2]}',
											i ='{$ArBarang[3]}',
											j ='{$ArBarang[4]}',
											
											tahun='$fmTAHUNANGGARAN',	noreg ='$fmREGISTER',
											konstruksi = '$fmKONSTRUKSI_KIB_D', panjang = '$fmPANJANG_KIB_D', lebar = '$fmLEBAR_KIB_D', luas = '$fmLUAS_KIB_D', 
											alamat = '$fmALAMAT_KIB_D', 
											alamat_kel='$alamat_kel', 
											alamat_kec='$alamat_kec', 
											alamat_a='$alamat_a', 
											alamat_b='$alamat_b', 
											alamat_c='$alamat_c', 
											kota='$alamat_kota', 

											koordinat_gps='$koordinat_gps',
											koord_bidang='$koord_bidang',  
											dokumen_tgl = '".$fmTGLDOKUMEN_KIB_D."', dokumen_no = '$fmNODOKUMEN_KIB_D', status_tanah = '$fmSTATUSTANAH_KIB_D', kode_tanah = '$fmNOKODETANAH_KIB_D', kondisi = '$fmKONDISI_KIB_D', ket = '$fmKET_KIB_D' 
											where $KriteriaKIB";
											$Sukses = mysql_query($Qry);
											}
									//UPDATE KIB E
									else if($ArBarang[0]=="05"){
											$Qry = "update kib_e set
											c ='$fmSKPD',
											d ='$fmUNIT',
											e ='$fmSUBUNIT',
											e1 ='$fmSEKSI',	
											f ='{$ArBarang[0]}',
											g ='{$ArBarang[1]}',
											h ='{$ArBarang[2]}',
											i ='{$ArBarang[3]}',
											j ='{$ArBarang[4]}',
											
											tahun='$fmTAHUNANGGARAN',	noreg ='$fmREGISTER',
											buku_judul = '$fmJUDULBUKU_KIB_E', buku_spesifikasi = '$fmSPEKBUKU_KIB_E', seni_asal_daerah = '$fmSENIBUDAYA_KIB_E', seni_pencipta = '$fmSENIPENCIPTA_KIB_E', seni_bahan = '$fmSENIBAHAN_KIB_E', hewan_jenis = '$fmJENISHEWAN_KIB_E', hewan_ukuran = '$fmUKURANHEWAN_KIB_E', ket = '$fmKET_KIB_E' 
											where $KriteriaKIB";
											//echo $Qry;
											$Sukses = mysql_query($Qry);
										}
									//UPDATE KIB F
									else if($ArBarang[0]=="06"){
										if ($alamat_b !=''){$alamat_a = $Main->DEF_PROPINSI;}
											$Qry = "update kib_f set 
											c ='$fmSKPD',
											d ='$fmUNIT',
											e ='$fmSUBUNIT',
											e1 ='$fmSEKSI',	
											f ='{$ArBarang[0]}',
											g ='{$ArBarang[1]}',
											h ='{$ArBarang[2]}',
											i ='{$ArBarang[3]}',
											j ='{$ArBarang[4]}',
											
											tahun='$fmTAHUNANGGARAN',	noreg ='$fmREGISTER',
											bangunan = '$fmBANGUNAN_KIB_F', konstruksi_tingkat = '$fmTINGKAT_KIB_F', konstruksi_beton = '$fmBETON_KIB_F', luas = '$fmLUAS_KIB_F', 
											alamat = '$fmLETAK_KIB_F', 
											alamat_kel='$alamat_kel', 
											alamat_kec='$alamat_kec', 
											alamat_a='$alamat_a', 
											alamat_b='$alamat_b',
											alamat_c='$alamat_c', 
											kota='$alamat_kota', 
											 
											koordinat_gps='$koordinat_gps', 
											koord_bidang='$koord_bidang', 
											dokumen_tgl = '".$fmTGLDOKUMEN_KIB_F."', dokumen_no = '$fmNODOKUMEN_KIB_F', 
											tmt = '".$fmTGLMULAI_KIB_F."', status_tanah = '$fmSTATUSTANAH_KIB_F', kode_tanah = '$fmNOKODETANAH_KIB_F', ket = '$fmKET_KIB_F' 
											where $KriteriaKIB";
											//
											$Sukses = mysql_query($Qry);
									} 
									else if($ArBarang[0]=="07"){
										$Qry = "update kib_g set
											c ='$fmSKPD',
											d ='$fmUNIT',
											e ='$fmSUBUNIT',
											e1 ='$fmSEKSI',	
											f ='{$ArBarang[0]}',
											g ='{$ArBarang[1]}',
											h ='{$ArBarang[2]}',
											i ='{$ArBarang[3]}',
											j ='{$ArBarang[4]}',
											
											tahun='$fmTAHUNANGGARAN', noreg ='$fmREGISTER',
											uraian = '$fmURAIAN_KIB_G', pencipta= '$fmPENCIPTA_KIB_G' ,
											jenis = '$fmJENIS_KIB_G', ket = '$fmKET_KIB_G' 
										where $KriteriaKIB";
											//echo $Qry;
										$Sukses = mysql_query($Qry);
									}
									$cek .= '<br> qrykib Sukses edit='.$Qry;
									}
									
									}
									
									if (!$Sukses){
										$errmsg =$errmsg==''? 'Data Gagal Disimpan!' : $errmsg ;
									}
								}//else{
								//	$Info = "<script>alert('$errmsg')</script>";
								//}
								break;
							}
						case '1':{	//simpan baru ------------------------------------------------------------																	
							if($Main->STASET_OTOMATIS  && $isMutasi == FALSE){ //jika simpan mutasi , staset barang baru hasil mutasi sama dengan staset brg lama
								
							
							   $fmSTATUSASET = getStatusAset($fmSTATUSASET, $fmKONDISIBARANG, $fmHARGABARANG,  $ArBarang[0], $ArBarang[1], $ArBarang[2], $ArBarang[3], $ArBarang[4] , $fmTAHUNPEROLEHAN);
							  }
							if($fmSTATUSASET=='') $errmsg ='Status Aset belum dipilih!';
							
							if($errmsg==''){
								
							
							
								$fmWIL = $Main->DEF_WILAYAH;	
								if ($nilai_appraisal==''){$nilai_appraisal=0;}
								$Kriteria = "concat(a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg)='$fmKEPEMILIKAN{$Main->Provinsi[0]}$fmWIL$fmSKPD$fmUNIT$fmSUBUNIT$fmSEKSI{$ArBarang[0]}{$ArBarang[1]}{$ArBarang[2]}{$ArBarang[3]}{$ArBarang[4]}$fmTAHUNPEROLEHAN$fmREGISTER'";
								$str = "select *  from buku_induk where concat(a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg)=
								'$fmKEPEMILIKAN{$Main->Provinsi[0]}$fmWIL$fmSKPD$fmUNIT$fmSUBUNIT$fmSEKSI{$ArBarang[0]}{$ArBarang[1]}{$ArBarang[2]}{$ArBarang[3]}{$ArBarang[4]}$fmTAHUNPEROLEHAN$fmREGISTER'";
								
								$CekBaru = mysql_num_rows(mysql_query( $str ));							
								//echo "<br>str=$str cek=".$CekBaru;							
								//$errmsg = " kriteria= $str";
								if($CekBaru == 0){
									if ($alamat_b !=''){$alamat_a = $Main->DEF_PROPINSI;}
									$Mulai = $fmREGISTER*1;
									$Sampai = $Mulai + ($fmJUMLAHBARANG*1);
									//set idawal & idlama -----------------------------------								
									if($isMutasi == FALSE){
										$fmIdAwal = 'null';
										$fmIDLama = 'null';
									}else{
										$fmIdAwal = "'".$fmIdAwal."'";
										$fmIDLama = "'".$fmIDLama."'";
									}
									
									for ($noREG = $Mulai;$noREG < $Sampai;$noREG++){
										$fmJUMLAHHARGA = $fmHARGABARANG*1;						
										$fmN = ($noREG+pow(10,$Main->NOREG_SIZE))."";
										$fmREGISTER = substr($fmN,1,$Main->NOREG_SIZE);	
										/*
										if ($Main->NILAI_EXTRACOMPATIBLE>0 and $fmHARGABARANG<Main->NILAI_EXTRACOMPATIBLE)
										{
											if ($ArBarang[0]=='02' || $ArBarang[0]=='05')
											{
											$fmSTATUSASET=10;
											}
										}
										*/					
										if($ArBarang[0]=="03"){
											$no_barang = $fmNOGEDUNG_KIB_C;
										}elseif($ArBarang[0]=="04"){
											$no_barang = $fmNORUASJALAN_KIB_D;
										}else{
											$no_barang = "";
										}
										
										$Qry = "insert into buku_induk 
											(a1,a,b,c1,c,d,e,e1,f,g,h,i,j,tahun,noreg,thn_perolehan,jml_barang,satuan,harga,
											jml_harga,asal_usul,status_barang,tgl_update,kondisi, 
											nilai_appraisal, gambar, 								
											tgl_buku, tgl_sensus, idawal,ref_idruang,
											ref_idpemegang,ref_idpemegang2,ref_idpenanggung,
											uid, id_lama, jml_barang_tmp,staset,harga_beli,harga_atribusi,ref_idatribusi, 
											no_ba,tgl_ba,no_spk, tgl_spk, penggunaan, jns_hibah, no_barang, kampung, rt, rw,
											bk, ck, dk, bk_p, ck_p, dk_p, p, q)
												values ('$fmKEPEMILIKAN','{$Main->Provinsi[0]}','$fmWIL','$fmURUSAN','$fmSKPD','$fmUNIT','$fmSUBUNIT','$fmSEKSI',
											'{$ArBarang[0]}','{$ArBarang[1]}','{$ArBarang[2]}','{$ArBarang[3]}','{$ArBarang[4]}',
											'$fmTAHUNANGGARAN','$fmREGISTER','$fmTAHUNPEROLEHAN',1,'$fmSATUAN',
											'$fmHARGABARANG','$fmJUMLAHHARGA','$fmASALUSUL','1',now(),
											'$fmKONDISIBARANG','$nilai_appraisal', '$gambar',
											'".$tgl_buku."','".$tgl_sensus."', $fmIdAwal,'$ref_idruang',
											'$ref_idpemegang','$ref_idpemegang2','$ref_idpenanggung',
											'".$UID."', $fmIDLama, '$fmJUMLAHBARANG','$fmSTATUSASET',
											'$fmHARGABARANGBELI','$fmHARGABARANGATRIBUSI','$ref_idatribusi',
											'$no_ba','$tgl_ba','$no_spk','$tgl_spk', '$penggunabi', '$fmJENISHIBAH', '$no_barang', '$kampung', '$rt', '$rw',
											'$bk', '$ck', '$dk', '$bk_p', '$ck_p', '$dk_p', '$fmPROGRAM', '$fmKEGIATAN')";//, '".$POST['sesi']."$noREG') ";					
										//echo '<br> qry simpan baru bi= '.$Qry;
										
										$Sukses = mysql_query($Qry);//echo "sukses simpan=$Sukses";
										$newid = mysql_insert_id();
										//mysql_query("insert into t_log (log) values ('1')");
										
										
										if ($Sukses== FALSE){
											$errmsg = "Gagal simpan BI!";
										}else{
											//if($Main->MODUL_HISTORY) insertIntoHistory( 1, $newid, $old, $UID, $ket_koreksi );
											//if($Main->MODUL_JURNAL) $jurnal= jurnalPerolehan($newid,$UID);
											//echo $jurnal['cek'];
											
											//history aset di triger buku_induk_aft_ins -----------------------
											/*
											//perolehan lain lain -------------------------------------
											if( $fmSTATUSASET==9  ){
												$aqry = "insert into t_asetlainlain ".
													"(tgl,idbi,uid,tgl_update,staset,staset_baru,ket,kondisi,kondisi_baru,idbi_awal) values ".
													"('$tgl_buku',$newid,'$UID',now(),null,'$fmSTATUSASET', '', null, '$fmKONDISIBARANG','$newid') ";
												$Sukses = mysql_query( $aqry );
												//mysql_query('insert into t_log (log) values ("'.$aqry.'")');
											}
											//perolehan extra -----------------------------------------																				
											if( $fmSTATUSASET==10 ){	
												$aqry =  "insert into t_kapitalisasi ".
													"(tgl,idbi,uid,tgl_update,staset,staset_baru,ket,idbi_awal) values ".
													"('$tgl_buku','$newid','$UID',now(),null,'$fmSTATUSASET', '','$newid' ) ";										
												$Sukses = mysql_query( $aqry );
												//mysql_query("insert into t_log (log) values ('$aqry')");
											}										
											//insert history aset ---------------------------------------
											if($Sukses){											
												if( $fmSTATUSASET==9  ){
													$jns_ = 2;
													$refid= mysql_insert_id();
												}else if( $fmSTATUSASET==10 ){
													$jns_ = 3;
													$refid= mysql_insert_id();
												}else{
													$jns_ = 1;
													$refid = $idBI;
												} 
												$aqry = "insert into t_history_aset ".
													"(tgl,idbi,uid,tgl_update,staset,staset_baru,div_staset,idbi_awal,jns,refid) ".
													" values ".
													"('$tgl_buku','$newid','$UID',now(),0,'$fmSTATUSASET','".$fmSTATUSASET."','".$newid."',$jns_,'$refid' )";
												$Sukses= mysql_query($aqry);											
												//mysql_query('insert into t_log (log) values ("'.$aqry.'")');
											}
											*/
											
											if ($isMutasi == TRUE ){
												//mysql_query("update penghapusan set sudahmutasi=1 where id_bukuinduk ='$fmIDLama' ");
												
												//$binew = mysql_fetch_array(mysql_query("select * from buku_induk where id_lama='$fmIDLama'"));
			
												$aqry = " insert into penyusutan ".
														" (tgl,tahun,sem,bulan,idbi,idbi_awal,harga,uid,tgl_update,thn_perolehan,hrg_perolehan,hrg_rehab,masa_manfaat,residu,akum_nilai_buku, ".
														" nilai_buku_stlh_susut,akum_susut,akum_masa_manfaat,thn_ke,sisa_masa_manfaat,masa_manfaat_rehab,sisa_masa_manfaat_thn,stat,bulan_awl,staset, ".
														" c,d,e,e1,f,g,h,i,j,ket,jns_trans2,id_koreksi,tgl_create,uid_create,id_koreksi_tambah) ".
														" select ".
														" tgl,tahun,sem,bulan,$newid ,idbi_awal,harga,uid,tgl_update,thn_perolehan,hrg_perolehan,hrg_rehab,masa_manfaat,residu,akum_nilai_buku, ".
														" nilai_buku_stlh_susut,akum_susut,akum_masa_manfaat,thn_ke,sisa_masa_manfaat,masa_manfaat_rehab,sisa_masa_manfaat_thn,stat,bulan_awl, staset, ".
														" c,d,e,e1,f,g,h,i,j,ket,15 ,id_koreksi,tgl_create,uid_create,id_koreksi_tambah ".
														" from penyusutan where idbi = $fmIDLama ";
												$ins = mysql_query($aqry);
												//$err = mysql_error();
												
												//salin data penyusutan di buku_induk id lama
												
												if($ins){
													$bi_old = mysql_fetch_array(mysql_query("select masa_manfaat,nilai_sisa,thn_susut_aw,thn_susut_ak,
																		bln_susut_aw,bln_susut_ak,masa_manfaat_tot,stop_susut
																		from buku_induk where id='$fmIDLama'"));
													//salin data penyusutan buku_induk lama ke baru
													$qqry="update buku_induk set masa_manfaat='".$bi_old['masa_manfaat']."',
															nilai_sisa='".$bi_old['nilai_sisa']."',
															thn_susut_aw='".$bi_old['thn_susut_aw']."',
															thn_susut_ak='{$bi_old['thn_susut_ak']}',
															masa_manfaat_tot='".$bi_old['masa_manfaat_tot']."',
															stop_susut='".$bi_old['stop_susut']."'
															where id='".$binew['id']."'
															";
															
													$qry2=mysql_query($qqry);
													
													if($qry2){
												
														//update sudah mutasi -------
														$sqry = "update penghapusan set sudahmutasi=1 where id_bukuinduk =  $fmIDLama ";
														//echo '<br>qry update penghapusan= '.$sqry;
														$qry = mysql_query($sqry);
														if ($qry==FALSE) $errmsg = "Gagal update sudah mutasi ";
													}else{
														
														$errmsg = "Gagal Update data penyusutan ke barang baru ";//".mysql_errno($qry2) . " ".mysql_error($qry2)."
													}
												}else{
													
													$errmsg = "Gagal Salin Penyusutan ";
												}
												
											}
																			
											$Kriteria = "concat(a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg)=
												'$fmKEPEMILIKAN{$Main->Provinsi[0]}$fmWIL$fmSKPD$fmUNIT$fmSUBUNIT$fmSEKSI{$ArBarang[0]}{$ArBarang[1]}{$ArBarang[2]}{$ArBarang[3]}{$ArBarang[4]}$fmTAHUNANGGARAN$fmREGISTER'";
											$idBI = table_get_value('select id from buku_induk where '.$Kriteria,'id');																				
											
											//update idawal	--------------------------------------------------------------
											mysql_query(
												"update buku_induk set idawal = id 
												where id='$idBI' and (idawal is null or idawal='' or idawal=0 )"
											);
											
											/***$InsertHistory = mysql_query(
												"insert into history_barang (a,b,c,d,e,e1,f,g,h,i,j,
												id_bukuinduk,
												tahun,noreg,tgl_update,kejadian,kondisi,status_barang)
												values('{$Main->Provinsi[0]}','$fmWIL','$fmSKPD','$fmUNIT','$fmSUBUNIT','$fmSEKSI','{$ArBarang[0]}','{$ArBarang[1]}','{$ArBarang[2]}','{$ArBarang[3]}','{$ArBarang[4]}',
												'$idBI',
												'$fmTAHUNANGGARAN','$fmREGISTER',
												now(),'Entry Inventaris',
												'$fmKONDISIBARANG','1')"
											);
											***/
											
										
												
																						
											//SIMPAN KIB A
											if($ArBarang[0]=="01"){						
													if ($alamat_b !=''){$alamat_a = $Main->DEF_PROPINSI;}
														$Qry = 
														"insert into kib_a (a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg,luas,
														alamat, alamat_kel, alamat_kec, alamat_a, alamat_b, koordinat_gps, koord_bidang, 
														status_hak,bersertifikat, sertifikat_tgl,sertifikat_no,penggunaan,ket,idbi,alamat_c,kota,blok,persil)
															values ('$fmKEPEMILIKAN','{$Main->Provinsi[0]}','$fmWIL','$fmSKPD','$fmUNIT','$fmSUBUNIT','$fmSEKSI',	
														'{$ArBarang[0]}','{$ArBarang[1]}','{$ArBarang[2]}','{$ArBarang[3]}','{$ArBarang[4]}',
														'$fmTAHUNANGGARAN','$fmREGISTER','$fmLUAS_KIB_A',
														'$fmLETAK_KIB_A', '$alamat_kel','$alamat_kec','$alamat_a','$alamat_b','$koordinat_gps','$koord_bidang', 
														'$fmHAKPAKAI_KIB_A','$bersertifikat','".$fmTGLSERTIFIKAT_KIB_A."','$fmNOSERTIFIKAT_KIB_A','$fmPENGGUNAAN_KIB_A','$fmKET_KIB_A','$idBI','$alamat_c','$alamat_kota',
														'$fmBLOK_KIB_A','$fmPERSIL_KIB_A')";
														$Sukses = mysql_query($Qry);
													if ($Sukses== FALSE){$errmsg = "Gagal simpan KIB A!";}
													}
											//SIMPAN KIB B
											else if($ArBarang[0]=="02"){						
														$Qry = "insert into kib_b (a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg,merk,ukuran,bahan,no_pabrik,
														no_rangka,no_mesin,no_polisi,no_bpkb,ket,idbi)
															values ('$fmKEPEMILIKAN','{$Main->Provinsi[0]}','$fmWIL','$fmSKPD','$fmUNIT','$fmSUBUNIT','$fmSEKSI',
														'{$ArBarang[0]}','{$ArBarang[1]}','{$ArBarang[2]}','{$ArBarang[3]}','{$ArBarang[4]}',
														'$fmTAHUNANGGARAN','$fmREGISTER','$fmMERK_KIB_B','$fmUKURAN_KIB_B','$fmBAHAN_KIB_B',
														'$fmPABRIK_KIB_B','$fmRANGKA_KIB_B','$fmMESIN_KIB_B','$fmPOLISI_KIB_B','$fmBPKB_KIB_B',
														'$fmKET_KIB_B','$idBI')";
														$Sukses = mysql_query($Qry);
													}
											//SIMPAN KIB C
											else if($ArBarang[0]=="03"){		
														if ($alamat_b !=''){$alamat_a = $Main->DEF_PROPINSI;}				
														$Qry = "insert into kib_c 						
														(a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg,
														kondisi_bangunan,konstruksi_tingkat,konstruksi_beton,luas_lantai,
														alamat, alamat_kel, alamat_kec, alamat_a, alamat_b, koordinat_gps,koord_bidang,
														dokumen_tgl,dokumen_no,luas,status_tanah,kode_tanah,ket,idbi,alamat_c,kota)
															values ('$fmKEPEMILIKAN','{$Main->Provinsi[0]}','$fmWIL','$fmSKPD','$fmUNIT','$fmSUBUNIT','$fmSEKSI',
															'{$ArBarang[0]}','{$ArBarang[1]}','{$ArBarang[2]}','{$ArBarang[3]}','{$ArBarang[4]}','$fmTAHUNANGGARAN','$fmREGISTER',
														'$fmKONDISI_KIB_C','$fmTINGKAT_KIB_C','$fmBETON_KIB_C','$fmLUASLANTAI_KIB_C',
														'$fmLETAK_KIB_C', '$alamat_kel','$alamat_kec','$alamat_a','$alamat_b','$koordinat_gps','$koord_bidang',
														'".$fmTGLGUDANG_KIB_C."','$fmNOGUDANG_KIB_C','$fmLUAS_KIB_C','$fmSTATUSTANAH_KIB_C',
														'$fmNOKODETANAH_KIB_C','$fmKET_KIB_C','$idBI','$alamat_c','$alamat_kota')";
														//echo "<br> qry simpan kibc=$Qry";
														$Sukses = mysql_query($Qry); //echo " sukses simpan=$Qry"; $Sukses=FALSE;
													if ($Sukses== FALSE){$errmsg = "Gagal simpan KIB C!";}
													}
											//SIMPAN KIB D
											else if($ArBarang[0]=="04"){	
														if ($alamat_b !=''){$alamat_a = $Main->DEF_PROPINSI;}					
														$Qry = "insert into kib_d (a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg,konstruksi,
														panjang,lebar,luas,
														alamat,alamat_kel, alamat_kec, alamat_a, alamat_b, koordinat_gps,koord_bidang,
														dokumen_tgl,dokumen_no,status_tanah,kode_tanah,kondisi,ket,idbi,alamat_c,kota)
															values ('$fmKEPEMILIKAN','{$Main->Provinsi[0]}','$fmWIL','$fmSKPD','$fmUNIT','$fmSUBUNIT','$fmSEKSI',
															'{$ArBarang[0]}','{$ArBarang[1]}','{$ArBarang[2]}','{$ArBarang[3]}','{$ArBarang[4]}','$fmTAHUNANGGARAN','$fmREGISTER','$fmKONSTRUKSI_KIB_D','$fmPANJANG_KIB_D','$fmLEBAR_KIB_D','$fmLUAS_KIB_D',
														'$fmALAMAT_KIB_D', '$alamat_kel','$alamat_kec','$alamat_a','$alamat_b','$koordinat_gps','$koord_bidang',
														'".$fmTGLDOKUMEN_KIB_D."','$fmNODOKUMEN_KIB_D','$fmSTATUSTANAH_KIB_D',
														'$fmNOKODETANAH_KIB_D','$fmKONDISI_KIB_D','$fmKET_KIB_D','$idBI','$alamat_c','$alamat_kota')";
														//echo $Qry;
														$Sukses = mysql_query($Qry);
													if ($Sukses== FALSE){$errmsg = "Gagal simpan KIB D!";}
													}
											//SIMPAN KIB E
											else if($ArBarang[0]=="05"){						
														$Qry = "insert into kib_e (a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg,buku_judul,buku_spesifikasi,
														seni_asal_daerah,seni_pencipta,seni_bahan,hewan_jenis,hewan_ukuran,ket,idbi)
															values ('$fmKEPEMILIKAN','{$Main->Provinsi[0]}','$fmWIL','$fmSKPD','$fmUNIT','$fmSUBUNIT','$fmSEKSI',
														'{$ArBarang[0]}','{$ArBarang[1]}','{$ArBarang[2]}','{$ArBarang[3]}','{$ArBarang[4]}',
														'$fmTAHUNANGGARAN','$fmREGISTER','$fmJUDULBUKU_KIB_E','$fmSPEKBUKU_KIB_E','$fmSENIBUDAYA_KIB_E',
														'$fmSENIPENCIPTA_KIB_E','$fmSENIBAHAN_KIB_E','$fmJENISHEWAN_KIB_E','$fmUKURANHEWAN_KIB_E',
														'$fmKET_KIB_E','$idBI')";
														//echo $Qry;
														$Sukses = mysql_query($Qry);
													if ($Sukses== FALSE){$errmsg = "Gagal simpan KIB E!";}
													}
											//SIMPAN KIB F
											else if($ArBarang[0]=="06"){						
														$Qry = "insert into kib_f (a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg,
														bangunan,konstruksi_tingkat,konstruksi_beton,luas,
														alamat, alamat_kel, alamat_kec, alamat_a, alamat_b, koordinat_gps,koord_bidang,
														dokumen_tgl,dokumen_no,tmt,status_tanah,kode_tanah,ket,idbi,alamat_c,kota)
															values ('$fmKEPEMILIKAN','{$Main->Provinsi[0]}','$fmWIL','$fmSKPD','$fmUNIT','$fmSUBUNIT','$fmSEKSI',
														'{$ArBarang[0]}','{$ArBarang[1]}','{$ArBarang[2]}','{$ArBarang[3]}','{$ArBarang[4]}',
														'$fmTAHUNANGGARAN','$fmREGISTER','$fmBANGUNAN_KIB_F','$fmTINGKAT_KIB_F','$fmBETON_KIB_F','$fmLUAS_KIB_F',
														'$fmLETAK_KIB_F', '$alamat_kel','$alamat_kec','$alamat_a','$alamat_b','$koordinat_gps','$koord_bidang',
														'".$fmTGLDOKUMEN_KIB_F."','$fmNODOKUMEN_KIB_F','".$fmTGLMULAI_KIB_F."','$fmSTATUSTANAH_KIB_F',
														'$fmNOKODETANAH_KIB_F','$fmKET_KIB_F','$idBI','$alamat_c','$alamat_kota')";
														//echo $Qry;
														$Sukses = mysql_query($Qry);
													if ($Sukses== FALSE){$errmsg = "Gagal simpan KIB F!";}
											}
											//kib g
											else if($ArBarang[0]=="07"){						
												$Qry = "insert into kib_g (a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg,
													uraian,pencipta,jenis, ket, idbi)
													values ('$fmKEPEMILIKAN','{$Main->Provinsi[0]}','$fmWIL','$fmSKPD','$fmUNIT','$fmSUBUNIT','$fmSEKSI',
													'{$ArBarang[0]}','{$ArBarang[1]}','{$ArBarang[2]}','{$ArBarang[3]}','{$ArBarang[4]}',
													'$fmTAHUNANGGARAN','$fmREGISTER',												
													'$fmURAIAN_KIB_G','$fmPENCIPTA_KIB_G', '$fmJENIS_KIB_G', '$fmKET_KIB_G','$idBI')";
													//echo $Qry;
												$Sukses = mysql_query($Qry);
												if ($Sukses== FALSE){$errmsg = "Gagal simpan KIB G!";}
											}
													
											$cek .= '<br> qrykib simpan baru='.$Qry;
										}
									}
									
								}else{
									//$Info = "<script>alert('Data TIDAK dapat disimpan \\n Nomor Register $fmREGISTER tahun $fmTAHUNPEROLEHAN sudah ada!!!')</script>";
									$errmsg = "Data TIDAK dapat disimpan \\n Nomor Register $fmREGISTER tahun $fmTAHUNPEROLEHAN sudah ada!!!";
								}
							
							}
							break;
						}	
					}
							//echo "<br>Sukses=$Sukses";
							
					}
					//if($Sukses){
					if($errmsg==''){
						/*
						//pindahkan gambar --------------------				
						if ($gambar != $gambar_old){
							if (copy('tmp/'.$gambar,'gambar/'.$gambar)){
								unlink('tmp/'.$gambar);
							if($gambar_old!=''){ unlink('gambar/'.$gambar_old);}
								}else{
								echo 'gagal copy file';
							}
							}			
						//pindahkan dokumen --------------------
						if ($dokumen_file != $dokumen_file_old){
							if (copy('tmp/'.$dokumen_file,'dokum/'.$dokumen_file)){
								unlink('tmp/'.$dokumen_file);
							if($dokumen_file_old!=''){ unlink('dokum/'.$dokumen_file_old);}
								}else{
								echo 'gagal copy file';
							}
						}
						*/			
						$Info = "<script>alert('Data telah di simpan');</script>";
						$Baru='';//$Baru="0"; 
						//$cek .= '<br> baru after simpan ='.$Baru;
						$Act='';//'<br> Act after simpan ='.$Act;
						//$fmIDLama = '';
					}else{
						//$Info = "<script>alert('Data TIDAK dapat disimpan \\n Nomor Register $fmREGISTER tahun $fmTAHUNPEROLEHAN sudah ada!!!')</script>";
						$Info = "<script>alert('$errmsg')</script>";
					}	
							
				}else{
					$Info = "<script>alert('".$errmsg."')</script>";
					$Act = "Edit";
				}
				break;
			}	
				
			case 'Hapus':{
				if($Act=="Hapus" && count($cidBI) > 0){
					for($i = 0; $i<count($cidBI); $i++)	{
						$aqry = "select * from buku_induk where id='{$cidBI[$i]}'";
						//echo $aqry.' '.$cidBI[$i] ;
						$Qry = mysql_query($aqry);		
						
							
						//*

											
						if($isi = mysql_fetch_array($Qry))	{
							$xid=$isi['id'];
							if ($errmsg=='') $errmsg=Penatausahaan_CekdataCutoff('hapus',$xid,'');								
							$e1 =$Main->SUB_UNIT ? $isi['e1'].'.' : '';
								$kdbrg= $isi['a1'].'.'.$isi['a'].'.'.$isi['b'].'.'.$isi['c'].'.'.$isi['d'].'.'.$isi['e'].'.'.$e1.
								$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'].'.'.
								$isi['noreg'].'.'.$isi['thn_perolehan'];
							if($isi['status_barang']!=1){$errmsg = 'Hanya barang dengan status Inventaris yang dapat dihapus!';}
								//$idawal = $isi['idawal'] == ''? $isi['id'] : $isi['idawal'];
								//if ($isi['idawal'] == ''){
							
							if ( $errmsg=='' && table_get_value("select count(*) as cnt from pemeliharaan where id_bukuinduk =".$isi['id'],'cnt')>0 ){
								$errmsg = 'Data Pemeliharaan masih ada!';
							}
							
							if ( $errmsg=='' && table_get_value("select count(*) as cnt from gambar where idbi =".$isi['id'],'cnt')>0 ){
								$errmsg = 'Data Gambar masih ada!';
							}
							if ( $errmsg=='' && table_get_value("select count(*) as cnt from dokum where idbi =".$isi['id'],'cnt')>0 ){
								$errmsg = 'Data Dokumen masih ada!';
							}
									
								
							
							if ( $errmsg=='' && table_get_value("select count(*) as cnt from pengamanan where id_bukuinduk =".$isi['id'],'cnt')>0 ){
								$errmsg = 'Data Pengamanan masih ada!';
							}
							if ( $errmsg=='' && table_get_value("select count(*) as cnt from pemanfaatan where id_bukuinduk =".$isi['id'],'cnt')>0 ){
								$errmsg = 'Data Pemanfaatan masih ada!';
							}
							if($errmsg=='' && table_get_value("select count(*) as cnt from t_koreksi where idbi =".$isi['id'],'cnt')>0 ){
								$errmsg = 'Data koreksi masih ada!';
							}
							//$errmsg = 'tes';
							if($errmsg=='' && table_get_value("select count(*) as cnt from penghapusan_sebagian where id_bukuinduk =".$isi['id'],'cnt')>0 ){
								$errmsg = 'Data penghapusan sebagian masih ada!';
							}
							if($errmsg=='' && table_get_value("select count(*) as cnt from penilaian where id_bukuinduk =".$isi['id'],'cnt')>0 ){
								$errmsg = 'Data penilaian masih ada!';
							}
							if($errmsg=='' && sudahClosing($isi['tgl_buku'], $isi['c'], $isi['d'], $isi['e'], $isi['e1'], $isi['c1']) ) $errmsg = 'Barang Sudah Closing !';					
							if($errmsg=='' && ($isi['refid_terima']!='' || $isi['refid_terima']!=0) ) $errmsg = 'Barang tidak dapat dihapus karena data dari penerimaan !';
							
							if($errmsg == ''){
								
								$e1_2 = $Main->SUB_UNIT ? " e1 = '{$isi['e1']}' and ": ''; 
								$KondisiEditKIB =		"
									a1= '{$isi['a1']}' and 
									a = '{$isi['a']}' and 
									b = '{$isi['b']}' and 
									c = '{$isi['c']}' and 
									d = '{$isi['d']}' and 
									e = '{$isi['e']}' and
									$e1_2 
									f = '{$isi['f']}' and 
									g = '{$isi['g']}' and 
									h = '{$isi['h']}' and 
									i = '{$isi['i']}' and 
									j = '{$isi['j']}' and 
									noreg = '{$isi['noreg']}' and 
									tahun = '{$isi['tahun']}' 
									";			
									//hapus gambar & dokumen ---------------------	
									//if ($isi['gambar'] != ''){	unlink('gambar/'.$isi['gambar']);	}						
								//if ($isi['dokumen_file'] != ''){ unlink('dokum/'.$isi['dokumen_file']);	}
									//Dok_HapusByIdBI($isi['id']);
								//*	
									//hapus detail kib 
								if($isi['f']=="01"){$DelKIB = mysql_query("delete from kib_a where $KondisiEditKIB limit 1");}
								if($isi['f']=="02"){$DelKIB = mysql_query("delete from kib_b where $KondisiEditKIB limit 1");}
								if($isi['f']=="03"){$DelKIB = mysql_query("delete from kib_c where $KondisiEditKIB limit 1");}
								if($isi['f']=="04"){$DelKIB = mysql_query("delete from kib_d where $KondisiEditKIB limit 1");}
								if($isi['f']=="05"){$DelKIB = mysql_query("delete from kib_e where $KondisiEditKIB limit 1");}
								if($isi['f']=="06"){$DelKIB = mysql_query("delete from kib_f where $KondisiEditKIB limit 1");}			
								
								$old = mysql_fetch_array(mysql_query("select * from buku_induk where id='{$cidBI[$i]}' "));
								
								mysql_query( mysql_fetch_array(
									" update buku_induk set uid = '$UID' where id='{$cidBI[$i]}'  "
								)); 
								
								
								//hapus bi
								$Del = mysql_query("delete from buku_induk where id='{$cidBI[$i]}' limit 1");
								
								//hapus histroy_aset di triger buku_induk_aft_del --------------
								
								/*mysql_query("delete from t_history_aset where idbi='{$cidBI[$i]}' ");
								//hapus t_asetlainlain
								mysql_query("delete from t_asetlainlain where idbi='{$cidBI[$i]}' ");
								//hapus kapitalisasi
								mysql_query("delete from t_kapitalisasi where idbi='{$cidBI[$i]}' ");
								*/
								if($Del==FALSE) $errmsg = 'Gagal delete BI';
								if($isi['id_lama'] !=''){
										
									
									if($errmsg==''){
										
									
										$hps = 	mysql_fetch_array(mysql_query("select * from penghapusan where id_bukuinduk='".$isi['id_lama']."' "));
										$bilama = mysql_fetch_array(mysql_query("select * from buku_induk where id='".$isi['id_lama']."' ")) ;
										if ( sudahClosing($hps['tgl_penghapusan'], $bilama['c'], $bilama['d'], $bilama['e'], $bilama['e1'], $bilama['c1']) ){
											$errmsg = 'Gagal hapus barang dengan asal usul reklas/mutasi, karena barang asal sudah closing !';	
										}else{
																			
											switch($hps['mutasi']){
											case 1 : {//mutasi
												//set belum mutasi di Penghapusan 								
												$Del = mysql_query("update penghapusan set sudahmutasi=0 where id_bukuinduk='".$isi['id_lama']."' and mutasi=1");								
												if($Del==FALSE) $errmsg = 'Gagal update penghapusan';
												/**
												//batal jurnal
												if($Main->VERSI_NAME !='GARUT'){
													
												
												$aqry = "delete from t_jurnal where jns_trans2 = 7 and refid='{$cidBI[$i]}' ";
												mysql_query($aqry);
												}**/
												break;
											}
											case 2 : {//reclass
												//batalkan reclass											
												$Del = mysql_query("delete from penghapusan where id_bukuinduk='".$isi['id_lama']."' and mutasi=2");
												if($Del==FALSE) $errmsg = 'Gagal hapus penghapusan';
												if($errmsg){
													$Del = mysql_query("update buku_induk set status_barang=1 where id='".$isi['id_lama']."' ");												
												}
												if($Del==FALSE) $errmsg = 'Gagal update buku';	
												
												/**if($Main->VERSI_NAME !='GARUT'){
													//batal jurnal penghapusan bi lama
													mysql_query("delete from t_jurnal where jns_trans2=6 and refid='{$hps['id']}' ");
													//batal jurnal reclass bi baru
													mysql_query("delete from t_jurnal where jns_trans2=8 and refid='{$cidBI[$i]}' ");		
												}**/
												break;
											}
											case 0 :{//pembelian & hibah
												/**if($Main->VERSI_NAME !='GARUT'){
												switch($old['asal_usul']){
													case 1:{ //perolehan pembelian
														mysql_query("delete from t_jurnal where jns_trans2=1 and refid='{$cidBI[$i]}' ");		
														break;
													}
													case 2:{ //hibah
														mysql_query("delete from t_jurnal where jns_trans2=2 and refid='{$cidBI[$i]}' ");		
														break;
													}
													case 3: {
														//lainnya
														mysql_query("delete from t_jurnal where jns_trans2=9 and refid='{$cidBI[$i]}' ");
														break;
													}
												}
												}**/
												
											}
										}
									
									}																																																								
										
										//if($Main->MODUL_HISTORY) insertIntoHistory( 3, $cidBI[$i], $old, $UID, $ket_koreksi );
										
										
										
										
										
										//insert history
										/*$sqry = "insert into history_barang (a1, a,b,c,d,e,e1,f,g,h,i,j,
											id_bukuinduk,tahun,noreg,tgl_update,kejadian,kondisi,uid)
												values('".$isi['a1']."', 
											'".$isi['a']."','".$isi['b']."','".$isi['c']."','".$isi['d']."','".$isi['e']."','".$isi['e1']."',
											'".$isi['f']."','".$isi['g']."','".$isi['h']."','".$isi['i']."','".$isi['j']."',
											'".$isi['id']."','".$isi['thn_perolehan']."','".$isi['noreg']."',
											now(),'Delete Inventaris','','".$UID."')"; 	//echo $sqry;
										$InsertHistory = mysql_query($sqry);
										*/
									}
								}
								$Info = $Del? "<script>alert('Data telah di hapus!'  )</script>" : "<script>alert('$errmsg')</script>";
								
							}else{
									//$Act = '';
									$Info = "<script>alert('Gagal Hapus No. $kdbrg. $errmsg')</script>";
									break;
							}
						}
							//*/
							
					}
					$Act ="";
				}
				break;
			}	
			//*	
			case 'barcode':{
				$err = genBarcode();
				
				break;
			}//*/	
				
		}
		//$Sukses = FALSE;
	}

				
	function genEntryScriptJS(){
		global $Main, $SPg, $Pg,$jns;
		if ($SPg == '') {
			$SPg = '03';
		}	
		if($Main->PENYUSUTAN) $vsusut = "<script language='JavaScript' src='js/penyusutan.js' type='text/javascript'></script>"."<script language='JavaScript' src='js/penyusutan/penyusutanlog.js' type='text/javascript'></script>";
		//if($Main->MODUL_ASETLAINLAIN) $vasetlainlain = "<script type=\"text/javascript\" src=\"js/asetlainlain.js\" language=\"JavaScript\"></script>";
		return "
		$vsusut		
	<script type=\"text/javascript\" src=\"js/wilayah.js\" language=\"JavaScript\"></script>
	
		<script language='javascript'>
		
		function prosesBaru(){
			//alert('Tes');
			//fmWIL,fmSKPD,fmUNIT,fmSUBUNIT,fmIDBARANG,fmNMBARANG,fmMEREK,fmJUMLAH,fmSATUAN,fmHARGASATUAN,fmIDREKENING,fmKET,fmTAHUNANGGARAN
			//adminForm.action = '?Pg=$Pg&SPg=$SPg';
			//adminForm.action='?Pg=$Pg&SPg=barangProses';
			adminForm.action='index.php?Pg=05&KIB=$SPg&SPg=barangProses&jns=$jns';
			adminForm.Baru.value = '1';
			adminForm.Act.value = 'Baru';
			adminForm.target = '_blank';
			adminForm.submit();
			adminForm.Baru.value = '';
			adminForm.Act.value='';
			adminForm.target = '';
		}
		function prosesEdit_(id){
			//alert(id);
			adminForm.Act.value='Edit';
							document.getElementById('fmIDLama').value=id;//box.value;
							//adminForm.action='index.php?Pg=05&SPg=barangProses&byId='+id;				
							adminForm.action='index.php?Pg=05&KIB=$SPg&SPg=barangProses';
							adminForm.target = '_blank';
							adminForm.submit();
		}
		function prosesEdit(){
			//alert(adminForm.fmSUBUNIT.value);
			errmsg = '';			
			if((errmsg=='') && (adminForm.boxchecked.value >1 )){
				//errmsg= 'Pilih Hanya Satu Data!';
			}
			if((errmsg=='') && (adminForm.boxchecked.value == 0 )){
				errmsg= 'Data belum dipilih!';
			}
			
			if(errmsg ==''){	
				for(var i=0; i < ".$Main->PagePerHal."; i++){
				
					var str = 'document.adminForm.cb' + i; 					
					if (eval(str)){
						box = eval( str );	//alert( i+' '+ box.value);
						
						if( box.checked){			
							//total += box.value + ' ';	
							
							//--- open blank di chrome ga bisa, nunggu looping beres 
							adminForm.Act.value='Edit';
							document.getElementById('fmIDLama').value=box.value;
							//adminForm.action='index.php?Pg=05&SPg=barangProses&byId='+box.value;				
							adminForm.action='index.php?Pg=05&KIB=$SPg&SPg=barangProses&jns=$jns';
							adminForm.target = '_blank';
							adminForm.submit();
							
							//setTimeout(  'prosesEdit_('+box.value+')', 1000);
							//alert(i+' ' +box.value);
						}
					}
				}
				
				/*
				//var total='';
				for(var i=0; i < 25; i++){
					box = eval( 'document.adminForm.cb' + i );
					if( box.checked){						
						//total += box.value + ' ';	
						adminForm.Act.value='Edit';
						adminForm.target = '_blank';
						adminForm.submit();
					}
					
				}
				*/
				//alert( total ); 			
				
				/*adminForm.Act.value='Edit';				
				adminForm.action='?Pg=$Pg&SPg=$SPg';
				adminForm.target = '_blank';
				adminForm.submit();*/
				adminForm.Act.value='';
				adminForm.target = '';
				
				/*adminForm.action='?Pg=05&SPg=barangProses';				
				adminForm.target = '_blank';*/
				
				/*
				//post to iframe -> frameedit
				adminForm.action='?Pg=05&SPg=barangProses';
				adminForm.target='frameedit';*/
				
				
				}else{
				alert(errmsg);
			}
		}
		
		function prosesHapus(){
			
			if (adminForm.boxchecked.value >0 ){
				if(confirm('Yakin '+adminForm.boxchecked.value+' data akan di hapus??')){
					document.body.style.overflow='hidden';
					addCoverPage('coverpage',100);
					adminForm.action = '?Pg=$Pg&SPg=$SPg';
					adminForm.Act.value='Hapus';
					adminForm.target = '';
					adminForm.submit();
				}
			}
		}
		function cetakBrg(){
			//alert(adminForm.fmSUBUNIT.value);
			errmsg = '';
			
			if((errmsg=='') && (adminForm.boxchecked.value >1 )){
				errmsg= 'Pilih Hanya Satu Data!';
			}
			if((errmsg=='') && (adminForm.boxchecked.value == 0 )){
				errmsg= 'Data belum dipilih!';
			}
			/*
			var spg_ = get_url_param('SPg');
			if (spg_ =='04' || spg_=='06'){
				var spg= 'brg_cetak2';
			}else{
				var spg= 'brg_cetak';
			}
			*/
			var spg= 'brg_cetak2';
			
			if(errmsg ==''){				
				//adminForm.action='?Pg=PR&SPg=brg_cetak';
				if (document.getElementById('cbxDlmRibu').checked ){
					//adminForm.action = 'index.php?Pg=PR&SPg=brg_cetak&cbxDlmRibu=1';
					adminForm.action = 'index.php?Pg=PR&SPg='+spg+'&cbxDlmRibu=1';
				}else{
					//adminForm.action = 'index.php?Pg=PR&SPg=brg_cetak';
					adminForm.action = 'index.php?Pg=PR&SPg='+spg;
				}
				
				//adminForm.Act.value='Edit';
				adminForm.target = '_blank';
				adminForm.submit();
				
				
				}else{
				alert(errmsg);
			}
		}
		function checkedMM(){						
			//alert('TES !');
			if(document.getElementById('fmTAMBAHMasaManfaat').checked==true){
				document.getElementById('fmTAMBAHASET').checked = true;
			}else{
				document.getElementById('fmTAMBAHASET').checked = false;
			}
		}
		function GetNilaiScarp(){
			var hrg_awal = document.getElementById('fmHARGA_AWAL').value; 
			var hrg_hapus = document.getElementById('fmHARGA_HAPUS').value;
			var num =  hrg_awal - hrg_hapus;
			num = num.toString().replace(/\$|\,/g,'');
			if(isNaN(num))
			num = '0';
			sign = (num == (num = Math.abs(num)));
			num = Math.floor(num*100+0.50000000001);
			cents = num%100;
			num = Math.floor(num/100).toString();
			if(cents<10)
			cents = '0' + cents;
			for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
			num = num.substring(0,num.length-(4*i+3))+'.'+
			num.substring(num.length-(4*i+3));
			//return (((sign)?'':'-') + '' + num + ',' + cents);
			document.getElementById('fmHARGA_SCRAP').value = hrg_awal - hrg_hapus;
			document.getElementById('fmHARGA_SCRAP2').innerHTML = (((sign)?'':'-') + '' + num);
						
		}
		</script>";
		
	}
	function genHidden(){
		$Pg = $_GET['Pg'];
		$SPg = $_GET['SPg']; if ($SPg =='') $SPg = '03';
		$Act2 = $_POST['Act2'];
		$fmIDLama = $_POST['fmIDLama'];
		$ViewList = $_POST['ViewList'];
		$ViewEntry = $_POST['ViewEntry'];
		//$tipebi	= $_REQUEST['tipebi'];
		
		return		
		"<input type=hidden id='PrevPageParam' name='PrevPageParam' value='index.php?Pg=$Pg&SPg=$SPg'>
		<input type=hidden id='Act' name='Act' value=''>
		<input type=hidden id='Act2' name='Act2' value=$Act2>
		<input type=hidden id='Baru' name='Baru' value='$Baru'>
		<input type=hidden id='boxchecked' name='boxchecked' value=\"0\" />
		<input type=hidden name='fmIDLama' id='fmIDLama' value='$fmIDLama'>
		<input type=hidden id='ViewList' name='ViewList' value='$ViewList' >
		<input type=hidden id='ViewEntry' name='ViewEntry' value='$ViewEntry' >
		<input type=hidden id='GetSPg' name='GetSPg' value='$SPg' >";
		//<input type=hidden id='tipebi' name='tipebi' value='$tipebi' >";
	}
	
	function genTitleCetak($SPg='listbi_cetak', $fmKONDBRG=3, $tipe=''){
		global $Main;
		//$fmKONDBRG = $_POST['fmKONDBRG'];//
		$tipe = $_REQUEST['tipe'];
		switch ($SPg) {    		
			case "kib_a_cetak": 
				if($tipe=='kertaskerja'){
					$titleCaption = "KERTAS KERJA SENSUS BMD <br> KARTU INVENTARIS BARANG (KIB) A";		
				}else{
					$titleCaption = $fmKONDBRG==3?
						'ASET LAINNYA - KIB A':
						'KARTU INVENTARIS BARANG (KIB) A <br> TANAH';					
				}
				if ($jns=='tetap') $titleCaption = 'ASET TETAP TANAH';				
			break;
			case "kib_b_cetak": 
				if($tipe=='kertaskerja'){
					$titleCaption = "KERTAS KERJA SENSUS BMD <br> KARTU INVENTARIS BARANG (KIB) B";		
				}else{
					$titleCaption = $fmKONDBRG==3?
					'ASET LAINNYA  - KIB B':
					'KARTU INVENTARIS BARANG (KIB) B <br> PERALATAN DAN MESIN';		 
				}
				if ($jns=='tetap') $titleCaption = 'ASET TETAP PERALATAN DAN MESIN';
			break;
			case "kib_c_cetak": 
				if($tipe=='kertaskerja'){
					$titleCaption = "KERTAS KERJA SENSUS BMD <br> KARTU INVENTARIS BARANG (KIB) C";		
				}else{
					$titleCaption = $fmKONDBRG==3?
					'ASET LAINNYA  - KIB C':
					'KARTU INVENTARIS BARANG (KIB) C <BR> GEDUNG DAN BANGUNAN';		 				 
				}
				if ($jns=='tetap') $titleCaption = 'ASET TETAP GEDUNG DAN BANGUNAN'; 
			break;
			case "kib_d_cetak": 
				if($tipe=='kertaskerja'){
					$titleCaption = "KERTAS KERJA SENSUS BMD <br> KARTU INVENTARIS BARANG (KIB) D";		
				}else{
					$titleCaption = $fmKONDBRG==3?
					'ASET LAINNYA  - KIB D':
					'KARTU INVENTARIS BARANG (KIB) D <BR>JALAN, IRIGASI, DAN JARINGAN';		 
				}
				if ($jns=='tetap') $titleCaption = 'ASET TETAP JALAN, IRIGASI, DAN JARINGAN';
			break;
			case "kib_e_cetak": 
				if($tipe=='kertaskerja'){
					$titleCaption = "KERTAS KERJA SENSUS BMD <br> KARTU INVENTARIS BARANG (KIB) E";		
				}else{
					$titleCaption = $fmKONDBRG==3?
					'ASET LAINNYA  - KIB E':
					'KARTU INVENTARIS BARANG (KIB) E <BR>ASET TETAP LAINNYA';		
				}
				if ($jns=='tetap') $titleCaption = 'ASET TETAP LAINNYA';
			break;
			case "kib_f_cetak": $titleCaption = $fmKONDBRG==3?
			'ASET LAINNYA  - KIB F':
			'KARTU INVENTARIS BARANG (KIB) F <BR>KONSTRUKSI DALAM PENGERJAAN';		
			break;
			case "kib_g_cetak": 
				if($tipe=='kertaskerja'){
					$titleCaption = "KERTAS KERJA SENSUS BMD <br> KARTU INVENTARIS BARANG ASET TAK BERWUJUD";		
				}else{
					$titleCaption = $fmKONDBRG==3?
						'ASET TAK BERWUJUD':
						'KARTU INVENTARIS BARANG <br> ASET TAK BERWUJUD';					
				}
				
				
			break;			  
			case "belumsensus": 
				
				if($tipe=='kertaskerja'){
					//require_once('daftarobj.php');
					//require_once('fnsensus.php');
					if($Main->SETTING['SENSUS_VERSI'] == 2){
						$tahun_sensus = $Main->SETTING['THN_SENSUS'];
					}else{
						$thnskr = date('Y');		
						$tahun_sensus = $Main->thnsensus_default;
						while ( ($tahun_sensus+ $Main->periode_sensus) <= $thnskr  ){
							$tahun_sensus+= $Main->periode_sensus;
						}
					}
					
					
					if ($Man-VERSI_NAME=='JABAR') {
						$titleCaption = "KERTAS KERJA <br> SENSUS BARANG MILIK PEMERINTAH <br>PROVINSI JAWA BARAT TAHUN $tahun_sensus";		
					}else{
						$titleCaption = "KERTAS KERJA <br> SENSUS BARANG MILIK PEMERINTAH DAERAH <br> $tahun_sensus";
					}
					//$titleCaption = "KERTAS KERJA SENSUS BMD <br> KARTU INVENTARIS BARANG ";		
				}else{
					$titleCaption = 'Sensus - Belum Cek';			
				}
				
			break; 
			case "KIR": 
				$titleCaption = 'Kartu Inventaris Ruang';			
			break; 
			case "KIP": 
				$titleCaption = 'Kartu Inventaris Pegawai';			
			break; 
			default: $titleCaption = $fmKONDBRG==3?
			'ASET LAINNYA ':
			'Buku Inventaris Barang';					        
			break;
		}
		return $titleCaption;
	}
	
	function genTitleCaption($SPg='03', $tipebi=''){
		global $Main;
		$fmKONDBRG = $_POST['fmKONDBRG'];
		$jns = $_REQUEST['jns'];
		//$tipebi = $_REQUEST['tipebi'];
		switch ($SPg) {   
			case 'KIP':
				$titleCaption = 'Kartu Inventaris Pegawai';						
			break;
			case 'KIR':
				$titleCaption = "Kartu Inventaris Ruang";						
			break;
			case "belumsensus": 
				if($Main->SETTING['SENSUS_VERSI']==2){
					$titleCaption = "Sensus ".$Main->SETTING['THN_SENSUS']." - Belum Cek (<span id='titleBelumSensus' name='titleBelumSensus'></span>)";						
				}else{
					$titleCaption = "Sensus $Main->thnsensus_default - Belum Cek (<span id='titleBelumSensus' name='titleBelumSensus'></span>)";						
				}
				
			break;
			case "04": 
				//$titleCaption = $fmKONDBRG==3?	'Aset Lainnya - KIB A':	'KIB A Tanah';		
				$titleCaption = 'KIB A Tanah';		
				//$titleCaption = $tipe =='pilih'? 'Pilihan - '.$titleCaption : $titleCaption ;		
			break;
			case "05": 
				//$titleCaption = $fmKONDBRG==3?	'Aset Lainnya - KIB B':	'KIB B Peralatan dan Mesin'; 
				$titleCaption =  'KIB B Peralatan dan Mesin'; 
				
			break;
			case "06": 
				//$titleCaption = $fmKONDBRG==3? 'Aset Lainnya - KIB C':	'KIB C Gedung dan Bangunan'; 				 
				$titleCaption = 'KIB C Gedung dan Bangunan'; 				 
			break;
			case "07": 
				//$titleCaption = $fmKONDBRG==3?	'Aset Lainnya - KIB D':	'KIB D JALAN, IRIGASI, DAN JARINGAN'; 
				$titleCaption =  'KIB D Jalan, Irigasi dan Jaringan'; 
			break;
			case "08": 
				//$titleCaption = $fmKONDBRG==3?'Aset Lainnya - KIB E':	'KIB E ASET TETAP LAINNYA'; 
				$titleCaption = 'KIB E Aset Tetap Lainnya'; 
			break;
			case "09": 
				//$titleCaption = $fmKONDBRG==3? 'Aset Lainnya - KIB F':	'KIB F KONSTRUKSI DALAM PENGERJAAN'; 
				$titleCaption = 'KIB F Konstruksi Dalam Pengerjaan'; 
			break;   
			case "kibg": 
				//$titleCaption = $fmKONDBRG==3?'Aset Tak Berwujud':	'Aset Tak Berwujud'; 
				$titleCaption = 'Aset Tak Berwujud'; 
			break;   
			default: 
				$titleCaption = $fmKONDBRG==3?	'Aset Lainnya':	'Buku Inventaris Barang';	
				if($jns=='penyusutan' && $Main->PENYUSUTAN) $titleCaption = 'Penyusutan';					        
				//$titleCaption .= $_REQUEST['tipe'];
				//$titleCaption = $tipe =='pilih'? 'Pilihan - '.$titleCaption: $titleCaption ;		
			break;
		}
		//$titleCaption = $tipebi =='pilih'? 'Pilihan - '.$titleCaption : $titleCaption ;		
		if ($SPg=='03')
		{
			if ($jns=='intra')
			{
				$titleCaption = $titleCaption.' (Intrakomptabel) ';
			} else if ($jns=='ekstra')
			{
				$titleCaption = $titleCaption.' (Ekstrakomptabel) ';
			}  else if ($jns=='lain')
			{
				$titleCaption = "Aset Lain - lain";
			} 	
		}
		
		switch($jns){
			case 'pindah': $titleCaption = 'Pemindahtanganan'; break;
			case 'tgr': $titleCaption = 'Tuntutan Ganti Rugi'; break;
			case 'mitra': $titleCaption = 'Kemitraan'; break;
		}
		return $titleCaption;
	}
	
	function genTitle($SPg = '03', $ToolbarAtas=''){
		//$tipebi= $_REQUEST['tipebi'];
		//$ToolbarAtas =  $tipebi==''? $ToolbarAtas: '';
		$titleCaption= $this->genTitleCaption($SPg);
		
		return 
		"<table class=\"adminheading\">
		<tr>
		<th height=\"47\" class=\"user\">" . $titleCaption . "</th>
		<th>" . 
		$ToolbarAtas . 
		" </th>
		</tr>
		</table>";
		
	}
	function genPanelIcon($Link="",$Image="save2.png",$Isi="Isinya",$hint='',$id="",$ReadOnly="",$Disabled=FALSE,$Rid="",$aparams='') { 
		global $Pg; $RidONLY = "";
		global $PATH_IMG; 
		//if(!Empty($ReadOnly)){$Link="#FORMENTRY";} 
		if ($Disabled) {
			$Link ='';
			$DisAbled = "disabled='true'";
		}
		$Ret = " <table cellpadding='0' cellspacing='0' border='0' id='toolbar'> 
				<tr valign='middle' align='center'> 
				<td class='border:none'> 
					<a$ReadOnly class='toolbar' id='$id' href='$Link' $DisAbled title='$hint' $aparams> 					
						<img src='".$PATH_IMG."images/administrator/images/$Image'  alt='button' name='save' 
						width='32' height='32' border='0' align='middle'  /> 
						<br>$Isi
					</a> 
				</td> 
				</tr> 
				</table> "; 
		return $Ret; 
	}	
	function genToolbarAtas(){
		global $ridModul05,$Main , $HTTP_COOKIE_VARS;
		$jns = $_REQUEST['jns'];
		switch ($_GET['SPg']) {
			case "KIP": $spg = 'KIP'; break;
			case "KIR": $spg = 'KIR'; break;
			case "belumsensus": $spg = 'belumsensus'; break;
			case "03": $spg = 'listbi_cetak'; break;
			case "04": $spg = 'kib_a_cetak'; $cetak_kk = "<td>" . PanelIcon1("javascript:Penatausahaan_CetakKertasKerja()", "print_f2.png", "<br>K. Kerja", '', '', '', '', 'Cetak Kertas Kerja KIB A ') . "</td>";break;
			case "05": $spg = 'kib_b_cetak'; $cetak_kk = "<td>" . PanelIcon1("javascript:Penatausahaan_CetakKertasKerja()", "print_f2.png", "<br>K. Kerja", '', '', '', '', 'Cetak Kertas Kerja KIB B ') . "</td>";break;
			case "06":$spg = 'kib_c_cetak'; $cetak_kk = "<td>" . PanelIcon1("javascript:Penatausahaan_CetakKertasKerja()", "print_f2.png", "<br>K. Kerja", '', '', '', '', 'Cetak Kertas Kerja KIB C ') . "</td>";break;
			case "07":$spg = 'kib_d_cetak'; $cetak_kk = "<td>" . PanelIcon1("javascript:Penatausahaan_CetakKertasKerja()", "print_f2.png", "<br>K. Kerja", '', '', '', '', 'Cetak Kertas Kerja KIB D ') . "</td>";break;
			case "08":$spg = 'kib_e_cetak'; $cetak_kk = "<td>" . PanelIcon1("javascript:Penatausahaan_CetakKertasKerja()", "print_f2.png", "<br>K. Kerja", '', '', '', '', 'Cetak Kertas Kerja KIB E ') . "</td>";break;
			case "09":$spg = 'kib_f_cetak'; break;    		
			case "kibg":$spg = 'kib_g_cetak'; break;    
			case "11":$spg = 'rekap_bi_cetak'; break;
			default : $spg = 'listbi_cetak'; break;
		}
		$cetak_kk ='';
		
		//--- set toolbar atas edit
		$PnlBarcode= $Main->BARCODE_ENABLE ? "<td>" . PanelIcon1("javascript:barcode.cetak()", "barcode.png", "Barcode") . "</td>":"";
		$PnlReclass= $Main->MODUL_RECLASS ? "<td>" . PanelIcon1("javascript:Reclass.reClass()", "mutasi.png", "Reclass") . "</td>":"";
		$pnlAsetLainLain =  $Main->MODUL_ASETLAINLAIN ? "<td>" . PanelIcon1("javascript:AsetLainLain.BaruBI()", "edit_f2.png", "<br>Aset Lain") . "</td>": "";
		//$pnlKapitalisasi =  $Main->MODUL_KAPITALISASI ? "<td>" . PanelIcon1("javascript:Kapitalisasi.BaruBI()", "edit_f2.png", "Kapitalisasi") . "</td>": "";
		$pnlKapitalisasi =  $Main->MODUL_KAPITALISASI ? "<td>" . genPanelIcon1("javascript:Kapitalisasi.BaruBI()", "edit_f2.png", "Kapitalisasi","Kapitalisasi","","","","","style=width:75px") . "</td>":"";
		$PnlMutasi = $Main->MODUL_MUTASI ? "<td>" . PanelIcon1("?Pg=05&SPg=setmutasi", "mutasi.png", "Mutasi",'','','','','Mutasi Bertambah') ."</td>":"";
		//if($Main->VERSI_NAME == 'KOTA_BANDUNG' && $HTTP_COOKIE_VARS['coGroup']<>'00.00.00.000' ){
		//if($Main->URUSAN==1){
			if ($Main->VERSI_NAME == 'KOTA_BANDUNG' && $HTTP_COOKIE_VARS['coLevel']!='1'  ){
				$PnlReclass = ''; 
				$PnlMutasi = '';	
			}
		/**}else{
			if ($Main->VERSI_NAME == 'KOTA_BANDUNG' && !( ($HTTP_COOKIE_VARS['coGroup']=='00.00.00.000' || $HTTP_COOKIE_VARS['coGroup']=='08.01.00.000' ) && $HTTP_COOKIE_VARS['coLevel']=='1')  ){
				$PnlReclass = '';
				$PnlMutasi ='';	
			}
		}**/
		
		
		$pnlKoreksi =  $Main->MODUL_KOREKSI ? "<td>" . PanelIcon1("javascript:Koreksi.BaruBI()", "edit_f2.png", "Koreksi") . "</td>": "";
		$PnlStSurvey= $Main->STATUS_SURVEY==1?"<td>" . genPanelIcon1("javascript:RefStatusBarang.StSurvey()", "new_f2.png", "Status Recon","Status Recon","","","","","style=width:75px") . "</td>":"";		
		$PnlKondisi= $Main->MODUL_KONDISI ? "<td>" . genPanelIcon1("javascript:Kondisi.BaruKondisi()", "edit_f2.png", "Kondisi","Kondisi","","","","","style=width:75px") . "</td>" : "";		
		$PnlMutasiv2= "<td>" . genPanelIcon1("javascript:MutasiBaru_ins.mutasibaru()", "mutasi.png", "Mutasi","Mutasi","","","","","style=width:75px") . "</td>";		
		$PnlUpdate= "<td>" . genPanelIcon1("javascript:updatebarang.formUpdate()", "edit_f2.png", "Update","Update","","","","","style=width:75px") . "</td>";		
		$PnlKIR= "<td>" . genPanelIcon1("javascript:kir.kirBaru()", "new_f2.png", "Baru","Baru","","","","","style=width:75px") . "</td>";		
		if (empty($ridModul05)) {
			switch ($_GET['SPg']) {
				case 'belumsensus':{
					if($Main->SETTING['SENSUS_VERSI']==2){
						//$PnlSensusManual = $Main->MODUL_SENSUS_MANUAL ? "<td>" . PanelIcon1("javascript:Sensus.CekBarang()", "sections.png", "Sensus", '', '', '', '', 'Sensus Barang') . "</td>" :
						//	"<td>" . PanelIcon1("javascript:Sensus.Baru()", "new_f2.png", "Baru", '', '', '', '', 'Sensus Baru') . "</td>";
						$ToolbarAtas_edit = 
							//"<td>" . PanelIcon1("", "new_f2.png", "Sensus", '', '', '', '', 'Sensus Tanpa Barcode Scanner') . "</td>".
							
							//"<td>" . PanelIcon1("javascript:Sensus.Baru()", "new_f2.png", "Scan", '', '', '', '', 'Sensus Dengan Barcode Scanner') . "</td>".
							"<td>" . genPanelIcon1("", "Setting2_32.png", "Pengaturan","Set Tahun Sensus","","","","","style=width:65px") . "</td>".
							"<td>" . genPanelIcon1("javascript:Sensus.Baru()", "new_f2.png", "Sensus","Sensus Tanpa Barcode Scanner","","","","","style=width:55px") . "</td>".
							"<td>" . genPanelIcon1("javascript:Sensus.Baru()", "new_f2.png", "Sensus Scan","Sensus Dengan Barcode Scanner","","","","","style=width:75px") . "</td>".
							
							$PnlBarcode .
							"<td>" . genPanelIcon1("javascript:Sensus.formCetakKKShow('1')", "print_f2.png", "K. K KIB A","Cetak Kertas Kerja KIB A Semua","","","","","style=width:75px") . "</td>".
							"<td>" . genPanelIcon1("javascript:Sensus.formCetakKKShow('2')", "print_f2.png", "K. K KIB B","Cetak Kertas Kerja KIB B Semua","","","","","style=width:75px") . "</td>".
							"<td>" . genPanelIcon1("javascript:Sensus.formCetakKKShow('3')", "print_f2.png", "K. K KIB C","Cetak Kertas Kerja KIB C Semua","","","","","style=width:75px") . "</td>".
							"<td>" . genPanelIcon1("javascript:Sensus.formCetakKKShow('4')", "print_f2.png", "K. K KIB D","Cetak Kertas Kerja KIB D Semua","","","","","style=width:75px") . "</td>".						
							"<td>" . genPanelIcon1("javascript:Sensus.formCetakKKShow('5')", "print_f2.png", "K. K KIB E","Cetak Kertas Kerja KIB E Semua","","","","","style=width:75px") . "</td>".
							"";
							
					}else{
						$PnlSensusManual = $Main->MODUL_SENSUS_MANUAL ? "<td>" . PanelIcon1("javascript:Sensus.CekBarang()", "sections.png", "Sensus", '', '', '', '', 'Sensus Barang') . "</td>" :"<td>" . PanelIcon1("javascript:Sensus.Baru()", "new_f2.png", "Baru", '', '', '', '', 'Sensus Baru') . "</td>";
						$ToolbarAtas_edit = $PnlSensusManual.$PnlBarcode .
							//"<td>" . PanelIcon1("javascript:Sensus.formCetakKKShow('1')", "print_f2.png", "<br>K. K KIB A", '', '', '', '', 'Cetak Kertas Kerja KIB A Semua') . "</td>".
							"<td>" . genPanelIcon1("javascript:Sensus.formCetakKKShow('1')", "print_f2.png", "K. K KIB A","Cetak Kertas Kerja KIB A Semua","","","","","style=width:75px") . "</td>".
							//"<td>" . PanelIcon1("javascript:Sensus.formCetakKKShow('2')", "print_f2.png", "<br>K. K KIB B", '', '', '', '', 'Cetak Kertas Kerja KIB B Semua') . "</td>".
							"<td>" . genPanelIcon1("javascript:Sensus.formCetakKKShow('2')", "print_f2.png", "K. K KIB B","Cetak Kertas Kerja KIB B Semua","","","","","style=width:75px") . "</td>".
							//"<td>" . PanelIcon1("javascript:Sensus.formCetakKKShow('3')", "print_f2.png", "<br>K. K KIB C", '', '', '', '', 'Cetak Kertas Kerja KIB C Semua') . "</td>".
							"<td>" . genPanelIcon1("javascript:Sensus.formCetakKKShow('3')", "print_f2.png", "K. K KIB C","Cetak Kertas Kerja KIB C Semua","","","","","style=width:75px") . "</td>".
							//"<td>" . PanelIcon1("javascript:Sensus.formCetakKKShow('4')", "print_f2.png", "<br>K. K KIB D", '', '', '', '', 'Cetak Kertas Kerja KIB D Semua') . "</td>".						
							"<td>" . genPanelIcon1("javascript:Sensus.formCetakKKShow('4')", "print_f2.png", "K. K KIB D","Cetak Kertas Kerja KIB D Semua","","","","","style=width:75px") . "</td>".						
							//"<td>" . PanelIcon1("javascript:Sensus.formCetakKKShow('5')", "print_f2.png", "<br>K. K KIB E", '', '', '', '', 'Cetak Kertas Kerja KIB E Semua') . "</td>";
							"<td>" . genPanelIcon1("javascript:Sensus.formCetakKKShow('5')", "print_f2.png", "K. K KIB E","Cetak Kertas Kerja KIB E Semua","","","","","style=width:75px") . "</td>";
	/*						
							"<td>" . PanelIcon1("javascript:Sensus.cetakKertasKerja(0)", "print_f2.png", "<br>K. K BI", '', '', '', '', 'Cetak Kertas Kerja BI per Halaman') . "</td>".
							"<td>" . PanelIcon1("javascript:Sensus.cetakKertasKerja(1)", "print_f2.png", "<br>K. K BI", '', '', '', '', 'Cetak Kertas Kerja BI Semua') . "</td>"
							//"<td>" . PanelIcon1("javascript:Penatausahaab_exportXls()", "export_xls.png", "Excel") . "</td>"
	*/						
					}
					
					break;
				}
				case 'KIR':{
					$ToolbarAtas_edit =
						
						//"<td>" . PanelIcon1("javascript:prosesEdit()", "edit_f2.png", "Ubah") . "</td>".
						/*$PnlBarcode.
						$PnlReclass.
						$PnlUpdate.
						$PnlMutasiv2.*/
						//$PnlMutasi.
						$PnlKIR.
						"<td>" . PanelIcon1("javascript:prosesHapus()", "delete_f2.png", "Delete") . "</td>".
						//"<td>" . PanelIcon1("javascript:prosesBaru()", "new_f2.png", "Baru") . "</td>".
						"<td>" . PanelIcon1("javascript:cetakBrg()", "print_f2.png", "Barang") . "</td>".
						"<td>" . PanelIcon1("javascript:Penatausahaan_CetakHal()", "print_f2.png", "Halaman") . "</td>".
						"<td>" . PanelIcon1("javascript:Penatausahaan_CetakAll()", "print_f2.png", "Semua") . "</td>".					
									
						"<td>" . PanelIcon1("javascript:Penatausahaab_exportXls()", "export_xls.png", "Excel") . "</td>".
						$cetak_kk;	
					break;	
					
				}
				default:
					$PnlBaru=$Main->PENERIMAAN_P19==1?"":"<td>" . PanelIcon1("javascript:prosesBaru()", "new_f2.png", "Baru") . "</td>";
					$PnlDelete=$Main->PENERIMAAN_P19==1? "" : "<td>" . PanelIcon1("javascript:prosesHapus()", "delete_f2.png", "Delete") . "</td>";
					//$PnlDelete="<td>" . PanelIcon1("javascript:prosesHapus()", "delete_f2.png", "Batal", "", "", "", "", "Batal Mutasi dan Reklass") . "</td>"; //batal mutasi dan reklas
					$pnlJnsEkstra = '';
					if ($jns=='pindah' || $jns=='mitra' || $jns=='tgr' )
					{
						$PnlBaru='';
						$PnlDelete='';
						$PnlMutasi='';
						$PnlMutasiv2='';
						$PnlUpdate='';
						$pnlKoreksi = '';
						$pnlKapitalisasi='';
						$pnlAsetLainLain='';
						
					}else if($jns=='lain'){
						$PnlBaru='';
						$pnlJnsLain = $Main->JNS_LAINLAIN==1?"<td>" . genPanelIcon1("javascript:JnsBarang.jenisLain()", "new_f2.png", "Jenis Lain-lain","Jenis Lain-lain","","","","","style=width:75px") . "</td>":"";								
					}else if($jns=='ekstra'){
						$pnlJnsEkstra = $Main->JNS_EKSTRA==1?"<td>" . genPanelIcon1("javascript:JnsBarang.jenisEkstra()", "new_f2.png", "Jenis Ekstra","Jenis Ekstra","","","","","style=width:75px") . "</td>":"";		
						//$pnlJnsEkstra = "<td>" . genPanelIcon1("javascript:Penatausahaan.jenisEkstra()", "new_f2.png", "Jenis Ekstra","Jenis Ekstra","","","","","style=width:75px") . "</td>";		
					}
					
					//$jns = $_REQUEST['jns'];
					if($jns=='penyusutan' && $Main->PENYUSUTAN){
						if($Main->TOMBOL_PENYUSUTAN==1){
							$tmblPenyusutan=
							"<td>" . PanelIcon1("javascript:Penyusutan.formSusut()", "new_f2.png", "Penyusutan") . "</td>".
							"<td>" . PanelIcon1("javascript:Penyusutan.formSusutSatu()", "new_f2.png", "Susut 1") . "</td>".
							"<td>" . PanelIcon1("javascript:Penyusutan.formSusutKoreksi()", "edit_f2.png", "Koreksi") . "</td>";			
						}
						$ToolbarAtas_edit =
							"<td>" . PanelIcon1("javascript:Penyusutan.formInformasi()", "info.png", "Informasi") . "</td>".
							"<td>" . PanelIcon1("javascript:Penyusutan.formRincian()", "properties_f2.png", "Rincian") . "</td>".
							$tmblPenyusutan.
							//"<td>" . PanelIcon1("javascript:Penyusutan.formSusutKoreksi()", "new_f2.png", "Koreksi") . "</td>".
							"<td>" . PanelIcon1("javascript:Penyusutan.formBatal()", "delete_f2.png", "Batal") . "</td>".
							"<td>" . PanelIcon1("javascript:Penatausahaan_CetakHal()", "print_f2.png", "Halaman") . "</td>".
							"<td>" . PanelIcon1("javascript:Penatausahaan_CetakAll()", "print_f2.png", "Semua") . "</td>".					
										
							"<td>" . PanelIcon1("javascript:Penatausahaab_exportXls()", "export_xls.png", "Excel") . "</td>".
							$cetak_kk;	
					}else{
						$ToolbarAtas_edit =	
							"<td>" . PanelIcon1("javascript:prosesEdit()", "edit_f2.png", "Ubah") . "</td>".
							$PnlBarcode.
							$PnlReclass.
							$PnlUpdate.
							$PnlMutasiv2.
							//$PnlMutasi.
							$PnlDelete.
							$PnlBaru.
							$pnlJnsLain.
							$pnlJnsEkstra.						
							$PnlStSurvey.
							/*$pnlKoreksi.
							$PnlKondisi.
							$pnlKapitalisasi.
							$pnlAsetLainLain.*/
							"<td>" . PanelIcon1("javascript:cetakBrg()", "print_f2.png", "Barang") . "</td>".
							"<td>" . PanelIcon1("javascript:Penatausahaan_CetakHal()", "print_f2.png", "Halaman") . "</td>".
							"<td>" . PanelIcon1("javascript:Penatausaha.formCetakKKShow('".$spg."')", "print_f2.png", "Semua") . "</td>".					
										
							"<td>" . PanelIcon1("javascript:Penatausahaab_exportXls()", "export_xls.png", "Excel") . "</td>".
							$cetak_kk;	
					}
			}
			
		}
		if($jns=='tgr' || $jns=='pindah' || $jns=='mitra' || $jns=='lain' ){
			$ToolbarAtas_edit =						
				"<td>" . PanelIcon1("javascript:barcode.cetak()", "barcode.png", "Barcode") . "</td>".
				
				"<td>" . PanelIcon1("javascript:cetakBrg()", "print_f2.png", "Barang") . "</td>".
				"<td>" . PanelIcon1("javascript:Penatausahaan_CetakHal()", "print_f2.png", "Halaman") . "</td>".
				"<td>" . PanelIcon1("javascript:Penatausahaan_CetakAll()", "print_f2.png", "Semua") . "</td>".					
							
				"<td>" . PanelIcon1("javascript:Penatausahaab_exportXls()", "export_xls.png", "Excel") . "</td>".
				$cetak_kk;	
		}
		if($jns=='ekstra'){
			$ToolbarAtas_edit =
				"<td>" . PanelIcon1("javascript:prosesEdit()", "edit_f2.png", "Ubah") . "</td>".				
				//$pnlKoreksi.
				//$pnlKapitalisasi.
				//$pnlAsetLainLain.
				$PnlBarcode.								
				$PnlUpdate.								
				//$PnlReclass.
				$PnlMutasiv2.
				//$PnlMutasi.
				//"<td>" . genPanelIconLama("javascript:MutasiUsulan.usulanbi()", "mutasi.png", "Usulan Mutasi",'Usulan Mutasi','','','','',"style='width:80'") ."</td>".
				//"<td>" . genPanelIconLama("javascript:MutasiUsulan.beritaAcaraBi()", "mutasi.png", "Mutasi Balai",'Mutasi Balai','','','','',"style='width:80'") ."</td>".							
				$PnlDelete.
				$PnlBaru.
				"<td>" . PanelIcon1("javascript:cetakBrg()", "print_f2.png", "Barang") . "</td>".
				"<td>" . PanelIcon1("javascript:Penatausahaan_CetakHal()", "print_f2.png", "Halaman") . "</td>".				
				"<td>" . PanelIcon1("javascript:Penatausahaan_CetakAll()", "print_f2.png", "Semua") . "</td>".	
				"<td>" . PanelIcon1("javascript:Penatausahaab_exportXls()", "export_xls.png", "Excel") . "</td>".
				$cetak_kk;	
		} 
		
		
		//--- set toolbar atas 
		
		
		$applet_z= $Main->BARCODE_ENABLE ?
			"<applet id='qz' name='QZ Print Plugin' code='qz.PrintApplet.class' archive='./qz-print.jar' width='0px' height='0px'>
 	  			<param name='jnlp_href' value='qz-print_jnlp.jnlp'>
          		<param name='cache_option' value='plugin'>
  
			      <!-- Optional, searches for printer with 'zebra' in the name on load -->
			      <!-- Note:  It is recommended to use applet.findPrinter() instead for ajax heavy applications -->
			      <param name='printer' value='PRINTER BARCODE'>
			      <!-- Optional, these 'cache_' params enable faster loading 'caching' of the applet -->
			      <param name='cache_option' value='plugin'>
			      <!-- Change 'cache_archive' to point to relative URL of jzebra.jar -->
			      <param name='cache_archive' value='./qz-print.jar'>
			      <!-- Change 'cache_version' to reflect current jZebra version -->
			      <param name='cache_version' value='1.4.8.0'>
				  
				 
    			
				<param name=\"disable_logging\" value=\"false\">
				<param name=\"initial_focus\" value=\"false\">
			</applet>":"";		
				
				
		return
					"<!-- toolbar atas -->
					<div style='float:right;'>
					<script>
					function Penatausahaan_CetakHal(){
						adminForm.action='?Pg=PR&SPg=$spg';
						adminForm.target='_blank';
						adminForm.submit();		
						adminForm.target='';
						
					}
					function Penatausahaan_CetakAll(){
						adminForm.action='?Pg=PR&SPg=$spg&ctk=1';
						adminForm.target='_blank';
						adminForm.submit();
						adminForm.target='';
					}
					function Penatausahaan_CetakKertasKerja(){
						adminForm.action='?Pg=PR&SPg=$spg&ctk=1&tipe=kertaskerja';
						adminForm.target='_blank';
						adminForm.submit();		
						adminForm.target='';
					}
					function Penatausahaab_exportXls(){
					    var xls= document.createElement('input'); 						
						xls.setAttribute('type', 'hidden');
						xls.setAttribute('name', 'xls');xls.setAttribute('id', 'xls');
						xls.setAttribute('value', '1');adminForm.appendChild(xls);
						
						var SPg= document.createElement('input');  					
						SPg.setAttribute('type', 'hidden');
						SPg.setAttribute('name', 'SPg');SPg.setAttribute('id', 'SPg');
						SPg.setAttribute('value', '$spg');adminForm.appendChild(SPg);
						
						var ctk= document.createElement('input');  
						ctk.setAttribute('type', 'hidden');
						ctk.setAttribute('name', 'ctk');ctk.setAttribute('id', 'Pg');
						ctk.setAttribute('value', '1');adminForm.appendChild(ctk);
						
						var Pg= document.createElement('input');  
						Pg.setAttribute('type', 'hidden');
						Pg.setAttribute('name', 'Pg');Pg.setAttribute('id', 'Pg');
						Pg.setAttribute('value', 'PR');adminForm.appendChild(Pg);
						
						adminForm.action='index.php?Pg=PR&SPg=$spg&ctk=1&xls=1';
						adminForm.target='_blank';
						adminForm.method='GET';
						adminForm.enctype='multipart/form-data'
						adminForm.submit();
						adminForm.target='';
						adminForm.enctype='';
						adminForm.method='POST';
						
						delElem('xls');
						delElem('SPg');
						delElem('ctk');
						delElem('Pg');
						
					}
					</script>		

					<table width='125'><tr>".$applet_z
					.
					$ToolbarAtas_edit.
					
					"</tr></table>			
					</div>";
			
		
		
	}
	function genToolbarBawah(){
		
		global $ridModul09, $disModul09, $SPg, $Pg,$Main,$jns, $HTTP_COOKIE_VARS;
		
		$PnlPengaman = $Main->MODUL_PENGAMANPELIHARA ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:setPengamanan()", "PENGAMANAN", $ridModul07, $disModul07,'',2,90) . 
					"</td></tr></table>":"";
		$PnlPelihara = $Main->MODUL_PENGAMANPELIHARA && $Main->PENERIMAAN_P19 ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:setPemeliharaan()", "PEMELIHARAAN", $ridModul07, $disModul07,'',2,110) . 
					"</td></tr></table>":"";
		$PnlPemanfaatan = $Main->MODUL_PEMANFAATAN ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:setPemanfaatan()", "PEMANFAATAN", $ridModul06, $disModul06,'',2,90) . 
					"</td></tr></table>":"";
		/*$PnlPenghapusan = $Main->MODUL_PENGAPUSAN ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:setPenghapusan()", "PENGHAPUSAN", $ridModul09, $disModul09,'',2,90) . 
					"</td></tr></table>":"";*/
		$PnlPenghapusan = $Main->MODUL_PENGAPUSAN ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:penghapusan_ins.penghapusanbaru(1)", "PENGHAPUSAN", $ridModul09, $disModul09,'',2,90) . 
					"</td></tr></table>":"";		
		$PnlKondisi = $Main->MODUL_KONDISI ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:kondisi_ins.kondisibaru()", "RECLASS RB", '', '','',2,90) . 
					"</td></tr></table>":"";
		/*$PnlPenggabungan = $Main->MODUL_PENGAPUSAN ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:setPenggabungan()", "PENGGABUNGAN", $ridModul09, $disModul09,'',2,110) . 
					"</td></tr></table>":"";*/
		/*$PnlMutasi = $Main->MODUL_PENGAPUSAN ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:setMutasi()", "MUTASI", $ridModul09, $disModul09,'',2,90) . 
					"</td></tr></table>":"";
		*/
		$PnlPenggabungan = "";
		$PnlMutasi = "";
		$PnlKoreksi = "";
		$PnlPenghapusanSebagian = "";
		/*$PnlKoreksi = $Main->MODUL_PENGAPUSAN ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:setKoreksi()", "KOREKSI", $ridModul09, $disModul09,'',2,90) . 
					"</td></tr></table>":"";*/
		/*$PnlPenghapusanSebagian = ($Main->MODUL_PENGAPUSAN_SEBAGIAN ) ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:setHapusSebagian()", "PENGHAPUSAN<br>SEBAGIAN", $ridModul09, $disModul09,'',1,90) . 
					"</td></tr></table>":"";*/
						
/* 
"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:setPenghapusan()", "PENGHAPUSAN", $ridModul09, $disModul09,'',2) . 			"</td></tr></table>"
*/
		/*$PnlPemindahtangan = $Main->MODUL_PEMINDAHTANGAN ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:setPindahtangan()", "PEMINDAH<br>TANGANAN", $ridModul10, $disModul10,'',1) . 
					"</td></tr></table>":"";*/
		$PnlPemindahtangan = $Main->MODUL_PEMINDAHTANGAN ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:pemindahtanganan_ins.pemindahtangananbaru()()", "PEMINDAH<br>TANGANAN", $ridModul10, $disModul10,'',1) . 
					"</td></tr></table>":"";
		$PnlGantirugi = $Main->MODUL_GANTIRUGI ?"<table width=\"70\"><tr><td>" . 
		PanelIcon3("javascript:setGantiRugi()", "TUNTUTAN<br>GANTI RUGI", $ridModul12, $disModul12,'',1) ."</td></tr></table>":"";
		
		$PnlPemusnahan = $Main->MODUL_PEMUSNAHAN ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:pemusnahan_ins.pemusnahanbaru()", "PEMUSNAHAN", $ridModul10, $disModul10,'',2) . 
					"</td></tr></table>":"";
		/*if(($Main->MODUL_KAPITALISASI) && ($jns=='ekstra' || $jns=='tetap')){
			$PnlKapitalisasi="<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:kapitalisasi_ins.kapitalisasibaru()", "KAPITALISASI",'','','',2,90) . 
					"</td></tr></table>";
		}else{
			$PnlKapitalisasi="";
		}*/
		$PnlKapitalisasi="<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:kapitalisasi_ins.kapitalisasibaru()", "RECLASS EXTRA",'','','',2,110) . 
					"</td></tr></table>";
			
		switch($jns){
			case 'pindah':{
				$PnlPelihara='';
				$PnlPengaman='';
				$PnlPenghapusanSebagian='';
				$PnlPemanfaatan='';
				$PnlGantirugi='';
				$PnlPemindahtangan='';
				
				$PnlMutasi='';
				$PnlKoreksi='';
				$PnlPenggabungan='';
				$PnlKapitalisasi='';
				$PnlKondisi='';
				break;
			}
			case 'mitra':{
				$PnlPelihara='';
				$PnlPengaman='';
				$PnlPenghapusanSebagian='';
				$PnlPemanfaatan='';
				$PnlGantirugi='';
				$PnlPemindahtangan='';
				$PnlKondisi='';
				
				$PnlMutasi='';
				$PnlKoreksi='';
				$PnlPenggabungan='';
				$PnlKapitalisasi='';
				$PnlKondisi='';
				
				break;
			}
			case 'tgr':{
				$PnlPelihara='';
				$PnlPengaman='';
				$PnlPenghapusanSebagian='';
				$PnlPemanfaatan='';
				$PnlGantirugi='';
				$PnlPemindahtangan='';
				
				$PnlMutasi='';
				$PnlKoreksi='';
				$PnlPenggabungan='';
				$PnlPenghapusan='';
				$PnlKapitalisasi='';
				$PnlKondisi='';
				break;
			}
			case 'tgr':{
				$PnlPelihara='';
				$PnlPengaman='';
				$PnlPenghapusanSebagian='';
				$PnlPemanfaatan='';
				$PnlGantirugi='';
				$PnlPemindahtangan='';
				$PnlKondisi='';
				
				$PnlMutasi='';
				$PnlKoreksi='';
				$PnlPenggabungan='';
				$PnlPenghapusan='';
				$PnlKapitalisasi='';
				$PnlKondisi='';
				break;
			}
		}
	
		//if($Main->URUSAN==1){
			//if($Main->VERSI_NAME == 'KOTA_BANDUNG' && !($HTTP_COOKIE_VARS['coGroup']=='0.00.00.00.000' && $HTTP_COOKIE_VARS['coLevel']=='1') ){
			if($Main->VERSI_NAME == 'KOTA_BANDUNG' &&  $HTTP_COOKIE_VARS['coLevel']!='1' ){
				$PnlMutasi='';
				$PnlKoreksi='';
				$PnlPenggabungan='';
			}	
		/**
		}else{
			if($Main->VERSI_NAME == 'KOTA_BANDUNG' && !($HTTP_COOKIE_VARS['coGroup']=='00.00.00.000' && $HTTP_COOKIE_VARS['coLevel']=='1') ){
				$PnlMutasi='';
				$PnlKoreksi='';
				$PnlPenggabungan='';
			}
		}**/
		
		
		$ToolBarBawah="<input type=hidden name=idbi id=idbi value=''>
					<input type=hidden name=idbi_awal id=idbi_awal value=''>".
					//Pelihara_createScriptJs().
					"<table width=\"100%\" class=\"menudottedline\" ><tr>
					<td>
					
					</td><td>".$PnlPelihara."
					
					</td><td>".$PnlPengaman."
					
					</td><td>".$PnlPemanfaatan."		

					</td><td>".$PnlPemindahtangan."		
					
					</td><td>".$PnlPenghapusanSebagian."
					
					</td><td>".$PnlPemusnahan."

					</td><td>".$PnlPenghapusan."
					
					</td><td>".$PnlKapitalisasi."
					
					</td><td>".$PnlKondisi."
					
					</td><td>".$PnlPenggabungan."
					
					</td><td>".$PnlMutasi."
					
					</td><td>".$PnlKoreksi."
					
					</td><td>".$PnlGantirugi."
					
					
					</td><td width=\"80%\"></td></tr>
					</table>
					</td>
					<td align='right'>
						$tampilCbxKeranjangDaftar
					</td>
					</tr>
					</table> 
					
					<script language='javascript'>
					PeliharaRefresh= new AjxRefreshObj(
						'PeliharaList','Pelihara_cover', 'divPeliharaList', 
						new Array('idbi_awal') 
					);
					PeliharaSimpan= new AjxSimpanObj(
						'PeliharaSimpan','PeliharaSimpan_cover',
						new Array('fmTANGGALPEMELIHARAAN','fmJENISPEMELIHARAAN','fmPEMELIHARAINSTANSI',
							'fmPEMELIHARAALAMAT','fmSURATNOMOR','fmSURATTANGGAL','fmBIAYA',
							'fmKET','fmTAMBAHASET','fmTAMBAHMasaManfaat','cara_perolehan','fmTANGGALPerolehan','fmNOMORba','idbi','idbi_awal','idplh','fmst'
						),
						\"PeliharaForm.Close();document.getElementById('boxchecked').value='';Penatausaha.refreshList(false);\"
					);
					PeliharaForm= new AjxFormObj('PeliharaForm','Pelihara_cover','Pelihara_checkbox','jmlTampilPLH', 
						'cbPLH', new Array('idbi','idbi_awal'), 'document.getElementById(\'fmTANGGALPEMELIHARAAN_tgl\').focus()');
					PeliharaHapus= new AjxHapusObj('PeliharaHapus',  'Pelihara_cover', 'Pelihara_checkbox', 'jmlTampilPLH', 
						'cbPLH', 'cidPLH', 'PeliharaRefresh.Refresh();');
					//------------	
					PengamanRefresh= new AjxRefreshObj('PengamanList','Pengaman_cover', 'divPengamanList', new Array('idbi_awal') );
					PengamanSimpan= new AjxSimpanObj(
						'PengamanSimpan','PengamanSimpan_cover',
						new Array('fmTANGGALPENGAMANAN','fmJENISPENGAMANAN','fmURAIANKEGIATAN',
							'fmPENGAMANINSTANSI','fmPENGAMANALAMAT', 'fmSURATNOMOR', 'fmSURATTANGGAL', 
							'fmBIAYA', 'fmKET','fmTAMBAHASET','fmTANGGALPEROLEHAN','idbi','idbi_awal','idplh','fmst'
						),
						\"PengamanForm.Close();document.getElementById('boxchecked').value='';Penatausaha.refreshList(false);\" 
					);
					PengamanForm= new AjxFormObj('PengamanForm','Pengaman_cover','Pengaman_checkbox','jmlTampilPGN', 
						'cbPGN', new Array('idbi','idbi_awal'), 'document.getElementById(\'fmTANGGALPENGAMANAN_tgl\').focus()');
					PengamanHapus= new AjxHapusObj('PengamanHapus',  'Pengaman_cover', 'Pengaman_checkbox', 'jmlTampilPGN', 
						'cbPGN', 'cidPGN','PengamanRefresh.Refresh();');
					//------------
					HapusSebagianRefresh= new AjxRefreshObj(
						'HapusSebagianList','HapusSebagian_cover', 'divHapusSebagianList', 
						new Array('idbi_awal') 
					);
					HapusSebagianSimpan= new AjxSimpanObj(
						'HapusSebagianSimpan','HapusSebagianSimpan_cover',
						new Array('fmTANGGALPENGHAPUSAN','fmURAIAN',
							'fmSURATNOMOR','fmSURATTANGGAL','fmHARGA_AWAL','fmHARGA_HAPUS','fmHARGA_SCRAP',
							'fmKET','idbi','idbi_awal','idplh','fmst','fmTANGGALPEROLEHAN'
						),
						\"HapusSebagianForm.Close();document.getElementById('boxchecked').value='';Penatausaha.refreshList(false);\"
					);
					HapusSebagianForm= new AjxFormObj('HapusSebagianForm','HapusSebagian_cover','HapusSebagian_checkbox','jmlTampilPLH', 
						'cbPLH', new Array('idbi','idbi_awal'), 'document.getElementById(\'fmTANGGALPENGHAPUSAN_tgl\').focus()');
					HapusSebagianHapus= new AjxHapusObj('HapusSebagianHapus',  'HapusSebagian_cover', 'HapusSebagian_checkbox', 'jmlTampilPLH', 
						'cbPLH', 'cidPLH', 'HapusSebagianRefresh.Refresh();');					
									
					//------------
					PemanfaatRefresh= new AjxRefreshObj('PemanfaatList','Pemanfaat_cover', 'divPemanfaatList', new Array('idbi_awal') );
					PemanfaatSimpan= new AjxSimpanObj(
						'PemanfaatSimpan','PemanfaatSimpan_cover',
						new Array('fmTANGGALPEMANFAATAN', 'fmBENTUKPEMANFAATAN', 'fmKEPADAINSTANSI',
							'fmKEPADAALAMAT', 'fmKEPADANAMA', 'fmKEPADAJABATAN', 'fmSURATNOMOR',
							'fmSURATTANGGAL', 'fmJANGKAWAKTU', 'fmBIAYA', 'fmKET', 'fmTANGGALPEMANFAATAN_akhir',
							'fmURAIAN',	'idbi', 'idbi_awal', 'idplh', 'fmst'
						),
						\"PemanfaatForm.Close();document.getElementById('boxchecked').value='';Penatausaha.refreshList(false);\" 
					);
					PemanfaatForm= new AjxFormObj('PemanfaatForm','Pemanfaat_cover','Pemanfaat_checkbox','jmlTampilPMF', 
						'cbPMF', new Array('idbi','idbi_awal'), 'document.getElementById(\'fmTANGGALPEMANFAATAN_tgl\').focus()');
					PemanfaatHapus= new AjxHapusObj('PemanfaatHapus',  'Pemanfaat_cover', 'Pemanfaat_checkbox', 'jmlTampilPMF', 'cbPMF', 'cidPMF','PemanfaatRefresh.Refresh();');		
					
						
					function setPemeliharaan(){
						errmsg = '';
						if((errmsg=='') && (adminForm.boxchecked.value >1 )){errmsg= 'Pilih Hanya Satu Data!';}
						if((errmsg=='') && (adminForm.boxchecked.value == 0 )){	errmsg= 'Data belum dipilih!';}
						if(errmsg ==''){
							
							document.getElementById('idbi').value = getCbxCheckedValue('cidBI[]');		
							PeliharaForm.Baru();								
						}else{
							alert(errmsg);
						}			
					}

					function setHapusSebagian(){
						errmsg = '';
						if((errmsg=='') && (adminForm.boxchecked.value >1 )){errmsg= 'Pilih Hanya Satu Data!';}
						if((errmsg=='') && (adminForm.boxchecked.value == 0 )){	errmsg= 'Data belum dipilih!';}
						if(errmsg ==''){
							
							document.getElementById('idbi').value = getCbxCheckedValue('cidBI[]');		
							HapusSebagianForm.Baru();								
						}else{
							alert(errmsg);
						}			
					}
										
					function setGantiRugi(){
						document.getElementById('idbi').value = getCbxCheckedValue('cidBI[]');		
						if(document.getElementById('idbi').value!='')
							Gantirugi.Baru2();								
					}
					function setPengamanan(){
						document.getElementById('idbi').value = getCbxCheckedValue('cidBI[]');		
						if(document.getElementById('idbi').value!='')
							PengamanForm.Baru();				
					}
					function setPindahtangan(){
						document.getElementById('idbi').value = getCbxCheckedValue('cidBI[]');		
						if(document.getElementById('idbi').value!='')
							Pindahtangan.Baru2();				
							//Pindahtangan.formbaru.Baru();
							//alert('tes');
					}
					function setPemanfaatan(){
						document.getElementById('idbi').value = getCbxCheckedValue('cidBI[]');		
						if(document.getElementById('idbi').value!='')
							PemanfaatForm.Baru();				
					}
					function setPenghapusan(){
						errmsg = '';
					if((errmsg=='') && (adminForm.boxchecked.value >1 )){errmsg= 'Pilih Hanya Satu Data!';}
					if((errmsg=='') && (adminForm.boxchecked.value == 0 )){	errmsg= 'Data belum dipilih!';}
						if(errmsg ==''){						
							adminForm.action='?Pg=09&SPg=03';
							adminForm.target='_blank';				
							adminForm.Act.value='Penghapusan_TambahEdit';				
							adminForm.Penghapusan_Baru.value='1';				
							adminForm.submit();
							adminForm.target='';
							}else{
							alert(errmsg);
							}			
					}
					function setPenggabungan(){
						errmsg = '';
					if((errmsg=='') && (adminForm.boxchecked.value >1 )){errmsg= 'Pilih Hanya Satu Data!';}
					if((errmsg=='') && (adminForm.boxchecked.value == 0 )){	errmsg= 'Data belum dipilih!';}
						if(errmsg ==''){						
							adminForm.action='?Pg=09&SPg=03&kriteria=4';
							adminForm.target='_blank';				
							adminForm.Act.value='Penghapusan_TambahEdit';				
							adminForm.Penghapusan_Baru.value='1';				
							adminForm.submit();
							adminForm.target='';
							}else{
							alert(errmsg);
							}			
					}
					function setMutasi(){
						errmsg = '';
					if((errmsg=='') && (adminForm.boxchecked.value >1 )){errmsg= 'Pilih Hanya Satu Data!';}
					if((errmsg=='') && (adminForm.boxchecked.value == 0 )){	errmsg= 'Data belum dipilih!';}
						if(errmsg ==''){						
							adminForm.action='?Pg=09&SPg=03&kriteria=1';
							adminForm.target='_blank';				
							adminForm.Act.value='Penghapusan_TambahEdit';				
							adminForm.Penghapusan_Baru.value='1';				
							adminForm.submit();
							adminForm.target='';
							}else{
							alert(errmsg);
							}			
					}
					function setKoreksi(){
						errmsg = '';
					if((errmsg=='') && (adminForm.boxchecked.value >1 )){errmsg= 'Pilih Hanya Satu Data!';}
					if((errmsg=='') && (adminForm.boxchecked.value == 0 )){	errmsg= 'Data belum dipilih!';}
						if(errmsg ==''){						
							adminForm.action='?Pg=09&SPg=03&kriteria=5';
							adminForm.target='_blank';				
							adminForm.Act.value='Penghapusan_TambahEdit';				
							adminForm.Penghapusan_Baru.value='1';				
							adminForm.submit();
							adminForm.target='';
							}else{
							alert(errmsg);
							}			
					}
					/*function setPemanfaatan(){
						errmsg = '';
					if((errmsg=='') && (adminForm.boxchecked.value >1 )){errmsg= 'Pilih Hanya Satu Data!';}
					if((errmsg=='') && (adminForm.boxchecked.value == 0 )){	errmsg= 'Data belum dipilih!';}
						if(errmsg ==''){
							adminForm.action='?Pg=$Pg&SPg=$SPg'; adminForm.target='';adminForm.Act.value='Pemanfaatan_TambahEdit';				
							adminForm.Baru.value='1'; adminForm.submit();
						}else{
							alert(errmsg);
						}
					}*/
					</script>";

		//tampil link daftar pilihan
		if($SPg=='belumsensus'){
			return  '';
		}else{
		
			
				return	$ToolBarBawah;	
					
			//	break;
		//	}
		//}
		
		}
	}
	
	function BIGetKib($f, $KondisiKIB){
		//get data detil kib untuk BI
		global $Main;//, $sort1;
		//global $ISI5, $ISI6, $ISI7, $ISI10, $ISI12, $ISI15;
		$ISI5=''; $ISI6=''; $ISI7=''; $ISI10=''; $ISI12=''; $ISI15='';
		//echo"<br>f=".$f;
		//*
		switch($f){
			case '01':{//KIB A			
				
				$sqryKIBA = "select sertifikat_no, luas, ket from kib_a  $KondisiKIB limit 0,1";
				//$sqryKIBA = "select * from view_kib_a  $KondisiKIB limit 0,1";
				//echo '<br> qrykibA = '.$sqryKIBA;
				$QryKIB_A = mysql_query($sqryKIBA);
				while($isiKIB_A = mysql_fetch_array($QryKIB_A))	{
					//$ISI5 = $isiKIB_A['alamat'].'<br>'.$isiKIB_A['alamat_kel'].'<br>'.$isiKIB_A['alamat_kec'].'<br>'.$isiKIB_A['alamat_kota'] ;
					$ISI6 = $isiKIB_A['sertifikat_no'];
					
					$ISI10 = number_format($isiKIB_A['luas'],2,',','.');//$cek .= '<br> luas A = '.$isiKIB_A['luas'];
					$ISI15 = "{$isiKIB_A['ket']}";
				}
				break;
			}
			case '02':{//KIB B;			
				//"concat(a1,a,b,c,d,e,f,g,h,i,j,noreg,tahun)='{$isi['a1']}{$isi['a']}{$isi['b']}{$isi['c']}{$isi['d']}{$isi['e']}{$isi['f']}{$isi['g']}{$isi['h']}{$isi['i']}{$isi['j']}{$isi['noreg']}{$isi['tahun']}'";
				$aqry="select ukuran, merk,no_pabrik,no_rangka,no_mesin,bahan,ket  from kib_b  $KondisiKIB limit 0,1";
				//echo"<br>qrkbb=".$aqry;
				
				$QryKIB_B = mysql_query($aqry);
				
				//echo "<br>qrkibb=".$aqry;
				while($isiKIB_B = mysql_fetch_array($QryKIB_B))	{
					
					$ISI5 = "{$isiKIB_B['merk']}";
					$ISI6 = "{$isiKIB_B['no_pabrik']} / {$isiKIB_B['no_rangka']} / {$isiKIB_B['no_mesin']}";
					$ISI7 = "{$isiKIB_B['bahan']}";
					$ISI10 = "{$isiKIB_B['ukuran']}";
					$ISI15 = "{$isiKIB_B['ket']}";
				}
				break;
				}	
			case '03':{//KIB C;
				$QryKIB_C = mysql_query("select dokumen_no, kondisi_bangunan, ket from kib_c  $KondisiKIB limit 0,1");
				//$QryKIB_C = mysql_query("select dokumen_no, kondisi_bangunan, ket, alamat_kota, alamat_kec, alamat_kel, alamat from view_kib_c  $KondisiKIB limit 0,1");
				while($isiKIB_C = mysql_fetch_array($QryKIB_C))	{
					//$ISI5 = $isiKIB_C['alamat'].'<br>'.$isiKIB_C['alamat_kel'].'<br>'.$isiKIB_C['alamat_kec'].'<br>'.$isiKIB_C['alamat_kota'] ;
					$ISI6 = "{$isiKIB_C['dokumen_no']}";
					$ISI10 = $Main->Bangunan[$isiKIB_C['kondisi_bangunan']-1][1];
					$ISI15 = "{$isiKIB_C['ket']}";
				}
				break;
			}
			case '04':{//KIB D;
				//$QryKIB_D = mysql_query("select dokumen_no, ket, alamat_kota, alamat_kec, alamat_kel, alamat from view_kib_d  $KondisiKIB limit 0,1");
				$QryKIB_D = mysql_query("select dokumen_no, ket  from kib_d  $KondisiKIB limit 0,1");
				while($isiKIB_D = mysql_fetch_array($QryKIB_D))	{
					//$ISI5 = $isiKIB_D['alamat'].'<br>'.$isiKIB_D['alamat_kel'].'<br>'.$isiKIB_D['alamat_kec'].'<br>'.$isiKIB_D['alamat_kota'] ;
					$ISI6 = "{$isiKIB_D['dokumen_no']}";
					$ISI15 = "{$isiKIB_D['ket']}";
				}
				break;
			}
			case '05':{//KIB E;		
				$QryKIB_E = mysql_query("select seni_bahan, ket from kib_e  $KondisiKIB limit 0,1");
				while($isiKIB_E = mysql_fetch_array($QryKIB_E))	{
					$ISI7 = "{$isiKIB_E['seni_bahan']}";
					$ISI15 = "{$isiKIB_E['ket']}";
				}
				break;
			}
			case '06':{//KIB F;
				//$cek.='<br> F = '.$isi['f'];
				//$sqrykibF = "select dokumen_no, bangunan, ket, alamat_kota, alamat_kec, alamat_kel, alamat  from view_kib_f  $KondisiKIB limit 0,1";
				$sqrykibF = "select dokumen_no, bangunan, ket from kib_f  $KondisiKIB limit 0,1";
				$QryKIB_F = mysql_query($sqrykibF);
				$cek.='<br> qrykibF = '.$sqrykibF;
				while($isiKIB_F = mysql_fetch_array($QryKIB_F))	{
					//$ISI5 = $isiKIB_F['alamat'].'<br>'.$isiKIB_F['alamat_kel'].'<br>'.$isiKIB_F['alamat_kec'].'<br>'.$isiKIB_F['alamat_kota'] ;
					$ISI6 = "{$isiKIB_F['dokumen_no']}";
					$ISI10 = $Main->Bangunan[$isiKIB_F['bangunan']-1][1];
					$ISI15 = "{$isiKIB_F['ket']}";
				}
				break;
			}
		}
		//*/	
				
		$ISI5 = !empty($ISI5) ? $ISI5 : "-";
		$ISI6 = !empty($ISI6) ? $ISI6 : "-";
		$ISI7 = !empty($ISI7) ? $ISI7 : "-";
		$ISI10 = !empty($ISI10) ? $ISI10 : "-";
		$ISI12 = !empty($ISI12) ? $ISI12 : "-";
		$ISI15 = !empty($ISI15) ? $ISI15 : "-";
		return array('ISI5'=>$ISI5, 'ISI6'=>$ISI6, 
		'ISI'=>$ISI7, 'ISI10'=>$ISI10, 'ISI15'=>$ISI15);
	}
	
	function getDaftarOpsi(){
		global $Main, $Pg, $SPg, $HTTP_COOKIE_VARS; 
		$cek = '';
		$formcaribi = $_REQUEST['formcaribi'];
		// urutan --------------------------------------------------------------------------
		$Urutkan='';
		switch ($SPg){			
			case '04': case '06': case '07': case '09' :{
				// urutan --------------------------------------------------------------------------
				$AcsDsc1 = cekPOST("AcsDsc1");
				$AcsDsc2 = cekPOST("AcsDsc2");
				$AcsDsc3 = cekPOST("AcsDsc3");
				$Asc1 = !empty($AcsDsc1)? " desc ":"";
				$Asc2 = !empty($AcsDsc2)? " desc ":"";
				$Asc3 = !empty($AcsDsc3)? " desc ":"";
				$odr1 = cekPOST("odr1");
				$odr2 = cekPOST("odr2");
				$odr3 = cekPOST("odr3");
				
				if(!empty($odr1) ){	//echo "<br>odr1='$odr1' ".strcmp($odr1,'alamat_kota, alamat_kec, alamat_kel' );
					if (strcmp($odr1,'alamat_kota, alamat_kec, alamat_kel, alamat' )==0 &&  !empty($AcsDsc1)){
						" $Urutkan alamat_kota desc, alamat_kec desc, alamat_kel desc, alamat desc,";
						}else{
						$Urutkan = " $Urutkan $odr1 $Asc1, ";
					}
				}
				if(!empty($odr2) ){
					if (strcmp($odr2,'alamat_kota, alamat_kec, alamat_kel, alamat' )==0 &&  !empty($AcsDsc2)){
						$Urutkan = " $Urutkan alamat_kota desc, alamat_kec desc, alamat_kel desc, alamat desc,";
						}else{
						$Urutkan = " $Urutkan $odr2 $Asc2, ";
						}	
				}
				if(!empty($odr3) ){
					if (strcmp($odr3,'alamat_kota, alamat_kec, alamat_kel, alamat' )==0 &&  !empty($AcsDsc3)){
						$Urutkan = " $Urutkan alamat_kota desc, alamat_kec desc, alamat_kel desc,  alamat desc,";
						}else{
						$Urutkan = " $Urutkan $odr3 $Asc3, ";
					}
				}

				$Urutkan = $SPg=='07' ? "jns,ref_ruas_jalan,nm_jembatan, $Urutkan " : "$Urutkan";

				//tampil ----------------------------------------------------------------------------------------
				$selTahun1 = $odr1 == "tahun" ? " selected " :  "";
				$selTahun2 = $odr2 == "tahun" ? " selected " :  "";
				$selTahun3 = $odr3 == "tahun" ? " selected " :  "";
				$selKondisi1 = $odr1 == "kondisi" ? " selected " :  "";
				$selKondisi2 = $odr2 == "kondisi" ? " selected " :  "";
				$selKondisi3 = $odr3 == "kondisi" ? " selected " :  "";
				$selWilayah1 = $odr1 == "alamat_kota, alamat_kec, alamat_kel, alamat" ? " selected " :  "";
				$selWilayah2 = $odr2 == "alamat_kota, alamat_kec, alamat_kel, alamat" ? " selected " :  "";
				$selWilayah3 = $odr3 == "alamat_kota, alamat_kec, alamat_kel, alamat" ? " selected " :  "";
				$selWilayah1a = $odr1 == "alamat_c" ? " selected " :  "";
				$selWilayah2a = $odr2 == "alamat_c" ? " selected " :  "";
				$selWilayah3a = $odr3 == "alamat_c" ? " selected " :  "";
				$Odr1  = "<option value=''>--</option>
				<option $selTahun1 value='tahun'>Tahun Perolehan</option>
				<option $selKondisi1 value='kondisi'>Keadaan Barang</option>
				<option $selWilayah1 value='alamat_kota, alamat_kec, alamat_kel, alamat'>Letak/Alamat</option>
				<option $selWilayah1a value='alamat_c'>Kecamatan</option>";
				$Odr2  = "<option value=''>--</option>
				<option $selTahun2 value='tahun'>Tahun Perolehan</option>
				<option $selKondisi2 value='kondisi'>Keadaan Barang</option>
				<option $selWilayah2 value='alamat_kota, alamat_kec, alamat_kel, alamat'>Letak/Alamat</option>
				<option $selWilayah2a value='alamat_c'>Kecamatan</option>";
				$Odr3  = "<option value=''>--</option>
				<option $selTahun3 value='tahun'>Tahun Perolehan</option>
				<option $selKondisi3 value='kondisi'>Keadaan Barang</option>
				<option $selWilayah3 value='alamat_kota, alamat_kec, alamat_kel, alamat'>Letak/Alamat</option>
				<option $selWilayah3a value='alamat_c'>Kecamatan</option>";
				$TampilOrder = "&nbsp Urutkan berdasar : 
				<select name=odr1>$Odr1</select><input $AcsDsc1 type=checkbox name=AcsDsc1 value='checked'>Desc. 
				<select name=odr2>$Odr2</select><input $AcsDsc2 type=checkbox name=AcsDsc2 value='checked'>Desc.
				<select name=odr3>$Odr3</select><input $AcsDsc3 type=checkbox name=AcsDsc3 value='checked'>Desc.";
				break;
			}
			default :{
				$sort1 = $_GET['sort1'];
				$AcsDsc1 = cekPOST("AcsDsc1"); //echo $AcsDsc1.'<br>';
				$AcsDsc2 = cekPOST("AcsDsc2");
				$AcsDsc3 = cekPOST("AcsDsc3");
				$odr1 = cekPOST("odr1"); //echo "odr1=$odr1";
				$odr2 = cekPOST("odr2");// echo "odr2=$odr2";
				$odr3 = cekPOST("odr3");		
				$Asc1 = !empty($AcsDsc1) ? " desc " : "";
				$Asc2 = !empty($AcsDsc2) ? " desc " : "";
				$Asc3 = !empty($AcsDsc3) ? " desc " : "";		
				//$Urutkan = "";
				if (!empty($odr1)) $Urutkan .= " $odr1 $Asc1, ";		
				if (!empty($odr2)) $Urutkan .= " $odr2 $Asc2, ";		
				if (!empty($odr3)) $Urutkan .= " $odr3 $Asc3, ";
				if ($sort1 == 1) {
					$Urutkan = ' id desc, ' . $Urutkan; //' tgl_update desc, '.$Urutkan;
					} else if ($sort1 == 2) {
					$Urutkan = ' tgl_update desc, ' . $Urutkan;
				}
				//tampil urut ----------------------------------------
				$selTahun1 = $odr1 == "tahun" ? " selected " : "";
				$selTahun2 = $odr2 == "tahun" ? " selected " : "";
				$selTahun3 = $odr3 == "tahun" ? " selected " : "";
				$selKondisi1 = $odr1 == "kondisi" ? " selected " : "";
				$selKondisi2 = $odr2 == "kondisi" ? " selected " : "";
				$selKondisi3 = $odr3 == "kondisi" ? " selected " : "";
				$selThnBuku1 = $odr1 == "year(tgl_buku)" ? " selected " : "";
				$selThnBuku2 = $odr2 == "year(tgl_buku)" ? " selected " : "";
				$selThnBuku3 = $odr3 == "year(tgl_buku)" ? " selected " : "";
				$Odr1 = "<option value=''>--</option><option $selTahun1 value='tahun'>Tahun Perolehan</option><option $selKondisi1 value='kondisi'>Keadaan Barang</option><option $selThnBuku1 value='year(tgl_buku)'>Tahun Buku</option>";
				$Odr2 = "<option value=''>--</option><option $selTahun2 value='tahun'>Tahun Perolehan</option><option $selKondisi2 value='kondisi'>Keadaan Barang</option><option $selThnBuku2 value='year(tgl_buku)'>Tahun Buku</option>";
				$Odr3 = "<option value=''>--</option><option $selTahun3 value='tahun'>Tahun Perolehan</option><option $selKondisi3 value='kondisi'>Keadaan Barang</option><option $selThnBuku3 value='year(tgl_buku)'>Tahun Buku</option>";		
				$TampilOrder = 
				" &nbsp&nbsp Urutkan berdasar : 
				<select name=odr1>$Odr1</select><input $AcsDsc1 type=checkbox name=AcsDsc1 value='checked'>Desc. 
				<select name=odr2>$Odr2</select><input $AcsDsc2 type=checkbox name=AcsDsc2 value='checked'>Desc.
				<select name=odr3>$Odr3</select><input $AcsDsc3 type=checkbox name=AcsDsc3 value='checked'>Desc. 
				";
				break;
			}
		}
		
		//create kondisi ------------------------------------------------------------------
		$fmFiltTglBtw_tgl1 = cekPOST('fmFiltTglBtw_tgl1');
		$fmFiltTglBtw_tgl2 = cekPOST('fmFiltTglBtw_tgl2');
		$tahun_susut = $_REQUEST['tahun_susut'];
		if ($tahun_susut != '' &&  $tahun_susut != '0000-00-00'){
			 $fmFiltTglBtw_tgl2 = $tahun_susut.'-12-31'; //sementara filter tgl buku 2 tdk pengaruh kalau di set tahun susut
		}
		$fmKEPEMILIKAN = $Main->DEF_KEPEMILIKAN;
		$a = $Main->Provinsi[0];
		$b = $Main->DEF_WILAYAH;//'00';
		$fmURUSAN = cekPOST('fmURUSAN'); //echo  '<br> fmSKPD  = '.$fmSKPD;//? 
		$fmSKPD = cekPOST('fmSKPD'); //echo  '<br> fmSKPD  = '.$fmSKPD;//? 
		$fmUNIT = cekPOST('fmUNIT'); //echo  '<br> fmUNIT  = '.$fmUNIT;//?
		$fmSUBUNIT = cekPOST('fmSUBUNIT');  //echo  '<br> fmSUBUNIT  = '.$fmSUBUNIT;//?		
		$fmSEKSI = cekPOST('fmSEKSI');  //echo  '<br> fmSEKSI  = '.$fmSEKSI;//?		
		if($formcaribi=='gantirugi_cari'){
			$fmURUSAN = cekPOST('gantirugiCariSkpdfmURUSAN'); //echo  '<br> fmURUSAN  = '.$fmURUSAN;//? 
			$fmSKPD = cekPOST('gantirugiCariSkpdfmSKPD'); //echo  '<br> fmSKPD  = '.$fmSKPD;//? 
			$fmUNIT = cekPOST('gantirugiCariSkpdfmUNIT'); //echo  '<br> fmUNIT  = '.$fmUNIT;//?
			$fmSUBUNIT = cekPOST('gantirugiCariSkpdfmSUBUNIT');  //echo  '<br> fmSUBUNIT  = '.$fmSUBUNIT;//?		
			$fmSEKSI = cekPOST('gantirugiCariSkpdfmSEKSI');  //echo  '<br> fmSEKSI  = '.$fmSEKSI;//?	
		}
		$Kondisi = getKondisiSKPD2($fmKEPEMILIKAN, $a, $b, $fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI,$fmURUSAN);
		$fmCariComboIsi = $_POST['fmCariComboIsi'];// cekPOST('fmCariComboIsi');
		$fmCariComboField = //$_POST['fmCariComboField'];//
		cekPOST('fmCariComboField');
		if (!empty($fmCariComboIsi) && !empty($fmCariComboField)) {
			//if ($fmCariComboField != 'ket' && $fmCariComboField != 'Cari Data') {
			if ($fmCariComboField != 'Cari Data') {
			//if(  $fmCariComboField == 'nm_barang'){
				
			//	$Kondisi .=  " and  concat(f,g,h,i,j) in (  select concat(f,g,h,i,j) from ref_barang where nm_barang like '%$fmCariComboIsi%' ) ";
			//}else{
				$Kondisi .= " and $fmCariComboField like '%$fmCariComboIsi%' ";
			//}
				
			}
		}
		$fmTahunPerolehan = cekPOST('fmTahunPerolehan', '');
		$fmTahunPerolehan2 = cekPOST('fmTahunPerolehan2', '');
		$fmTahunPerolehan3 = cekPOST('fmTahunPerolehan3', '');
		if (!empty($fmTahunPerolehan) && !empty($fmTahunPerolehan2) ) {
			$Kondisi .= " and thn_perolehan >= '$fmTahunPerolehan'  and thn_perolehan <= '$fmTahunPerolehan2'  ";
		}else if (!empty($fmTahunPerolehan) && empty($fmTahunPerolehan2) ) {
			$Kondisi .= " and thn_perolehan >= '$fmTahunPerolehan'  ";
		}else if (empty($fmTahunPerolehan) && !empty($fmTahunPerolehan2) ) {
			$Kondisi .= " and thn_perolehan <= '$fmTahunPerolehan2'  ";
		}		
		
		if (!empty($fmTahunPerolehan3)) {
			$Kondisi .= " and thn_perolehan = '$fmTahunPerolehan3'  ";
		}
		
		$fmTglBuku = cekPOST('fmTglBuku');
		$fmFiltThnBuku = cekPOST('fmFiltThnBuku');
		$Kondisi .= empty($fmTglBuku) ? "" : " and tgl_buku ='$fmTglBuku' "; //echo $Kondisi;
		$Kondisi .= empty($fmFiltThnBuku) ? "" : " and Year(tgl_buku) ='$fmFiltThnBuku' ";
		$jns= $_REQUEST['jns'];
				
		//kondisi belum sensus -----------------------------//Kondisi cari bi di usulan hapus
		
		if( $_GET['SPg']=='belumsensus'){
			if($Main->SETTING['SENSUS_VERSI']==2){
				$Kondisi .= " and year(tgl_buku)< ".$Main->SETTING['THN_SENSUS']."  and id not in 
					(select id_bukuinduk FROM penghapusan where year(tgl_penghapusan) <'$Main->thnsensus_default')
					and id not in 
					(select id_bukuinduk from pemindahtanganan where year(tgl_pemindahtanganan) <'$Main->thnsensus_default' )
					and id not in 
					(select id_bukuinduk from gantirugi where year(tgl_gantirugi) <'$Main->thnsensus_default' )";	
			}else{
				$Kondisi .= " and year(tgl_buku)<$Main->thnsensus_default  and id not in 
					(select id_bukuinduk FROM penghapusan where year(tgl_penghapusan) <'$Main->thnsensus_default')
					and id not in 
					(select id_bukuinduk from pemindahtanganan where year(tgl_pemindahtanganan) <'$Main->thnsensus_default' )
					and id not in 
					(select id_bukuinduk from gantirugi where year(tgl_gantirugi) <'$Main->thnsensus_default' )";	
			}
				
		}else if( $_GET['SPg']=='KIR'){ 
			$Kondisi .= " and status_barang <> '3' and status_barang <> '5' and f in(02,05) and g not in(02,03,19)";//kondisi daftar kir datanya kib b dan kib e
		}else if( $jns<>''){
			if ($fmFiltTglBtw_tgl2 =='' || $fmFiltTglBtw_tgl2 =='0000-00-00' ){//kalau filter tgl di set, status barang terakhir tidak pengaruh, brg yg sudah dihapus atau status_barang <> 1 akan tampil lagi jka tgl hapus > tgl flter
				$Kondisi .= "  and status_barang <> '3' ";
			}
		}else{
			if($formcaribi =="rencana_pemanfaatan"){
				$Kondisi .= " and status_barang = '1' ";
			}else if($formcaribi =="rphbmd"){
				$Kondisi .= " and status_barang = '1' and (staset=9 or kondisi=3) ";
			}else if($formcaribi =="rkpb"){
				$Kondisi .= " and status_barang = '1'";
			}else if($formcaribi =="tgr"){
				$Kondisi .= " and status_barang = '1' ";
			}else if($formcaribi =="penilaian"){
				$Kondisi .= " and status_barang = '1' ";
			
			}else if($formcaribi =="daftar_pemanfaatan"){
				$Kondisi .= " and status_barang = '1' ";
			
			}else if($formcaribi =="daftar_pemanfaatan_sebagian"){
				$Kondisi .= " and status_barang = '1' and f<>'02' and f<>'05' and f<>'06' and f<>'07' ";
			
			}else if($formcaribi =="pemeliharaan"){
				$Kondisi .= " and (staset=3 or staset=8) and status_barang = 1 ";
			
			}else if($formcaribi =="daftar_pemindahtangan"){
				$Kondisi .= " and status_barang = '1' and staset = 3 ";
			
			}else if($formcaribi =="penghapusan"){
				$Kondisi .= " and status_barang = '1' ";
			
			}elseif($formcaribi =='MutasiKurang'){
				$Kondisi .= " and (staset=3 or staset=8 or staset=9) and status_barang='1'";			
			
			}elseif($formcaribi =='pemusnahan'){
				$Kondisi .= " and status_barang = '1'";			
			}elseif($formcaribi <>''){
				$Kondisi .= " and status_barang = '1'";	
			}else{
				//if ($fmFiltTglBtw_tgl2 =='' || $fmFiltTglBtw_tgl2 =='0000-00-00' ){//kalau filter tgl di set, status barang terakhir tidak pengaruh
					//$Kondisi .= " and status_barang <> '3' and  status_barang <> '4' and status_barang <> '5'";
					if($Main->STATUS_INVENTARIS==1){
						$Kondisi .= " and status_barang <> '3' and status_barang <> '5'";
					}else{
						$Kondisi .= " and status_barang <> '3' and  status_barang <> '4' and status_barang <> '5'";
					}
				//}
			}
		}		
		if($formcaribi=='gantirugi_cari'){
			$Kondisi .= " and stusul = 0 ";
		}		
		$fmkode = cekPOST('barcode_input');
		if (strlen($fmkode)>=28){			
			$Kondisi .= " and idall2 ='$fmkode' ";				
		}
		
		$filterBrg = $_GET['filterBrg'];
		$filterHrg = $_GET['filterHrg'];
		if (isset($filterBrg)) {
			$Kondisi .= " and concat(f,'.',g,'.',h,'.',i,'.',j,'.',tahun,'.',noreg) like '$filterBrg%' ";
		}
		if (isset($filterHrg)) {
			$Kondisi .= " and jml_harga = '$filterHrg%' ";
		}		
				
		$fmKONDBRG = cekPOST('fmKONDBRG');
		if ($fmKONDBRG>='80')
		{
			$Kondisi .= $fmKONDBRG =='80'? " and kondisi<3	":"";
			$Kondisi .= $fmKONDBRG =='81'? " and kondisi<4	":"";
		} else {
		$Kondisi .= $fmKONDBRG ==''? '' : " and kondisi='$fmKONDBRG' ";			
			
		}		
		//kondisi status survey
		$fmSTSURVEY = $_REQUEST['fmSTSURVEY']; 
		//if(!empty($fmSTSURVEY)) $Kondisi .= " and ref_idstatussurvey = '$fmSTSURVEY'";
		$tnp_strecon = $_REQUEST['tnp_strecon']; 
		/*if(!empty($fmSTSURVEY) && !empty($tnp_strecon)) $Kondisi .= " and ref_idstatussurvey in(0,$fmSTSURVEY)";
		if(!empty($fmSTSURVEY) && empty($tnp_strecon)) $Kondisi .= " and ref_idstatussurvey = '$fmSTSURVEY'";
		if(!empty($tnp_strecon) && empty($fmSTSURVEY)) $Kondisi .= " and (ref_idstatussurvey = '0' or ref_idstatussurvey is null)";
		*/
		if(!empty($tnp_strecon) ) {
			$Kondisi .= " and (ref_idstatussurvey = '0' or ref_idstatussurvey is null)";
		}else{
			if(!empty($fmSTSURVEY))  $Kondisi .= " and ref_idstatussurvey = '$fmSTSURVEY'";
		}
				
		$jnsEkstra = $_REQUEST['jnsEkstra']; 
		if($jnsEkstra !='') $Kondisi .= " and jns_ekstra = '$jnsEkstra'";
		
		$jnsLain = $_REQUEST['jnsLain']; 
		if($jnsLain !='') $Kondisi .= " and jns_lain = '$jnsLain'";

		//$fmFiltTglBtw_tgl1 = cekPOST('fmFiltTglBtw_tgl1');
		//$fmFiltTglBtw_tgl2 = cekPOST('fmFiltTglBtw_tgl2');
		if( !empty($fmFiltTglBtw_tgl1)   ) $Kondisi .= " and tgl_buku>='$fmFiltTglBtw_tgl1'";
		//if( !empty($fmFiltTglBtw_tgl2)   ) $Kondisi .= " and tgl_buku<='$fmFiltTglBtw_tgl2'";
		
		$idbi_ = $_GET['SPg'] == '03' || $_GET['SPg']=='' || $_GET['SPg']=='listbi_cetak' ? 'id' : 'idbi';
		if( !empty($fmFiltTglBtw_tgl2)   ){
			$Kondisi .= " and tgl_buku<='$fmFiltTglBtw_tgl2' and $idbi_ not in 
				(select id_bukuinduk FROM penghapusan where tgl_penghapusan <='$fmFiltTglBtw_tgl2' and id_bukuinduk is not null )
				and $idbi_ not in 
				(select id_bukuinduk from pemindahtanganan where tgl_pemindahtanganan <='$fmFiltTglBtw_tgl2' and id_bukuinduk is not null  )
				and $idbi_ not in 
				(select id_bukuinduk from gantirugi where tgl_gantirugi <='$fmFiltTglBtw_tgl2'  and id_bukuinduk is not null  )";	
				
		}
		
				
		if( $_GET['SPg']=='belumsensus'){
			if( empty($fmFiltTglBtw_tgl1) && empty($fmFiltTglBtw_tgl2)   )  $fmFiltTglBtw_tgl2=$Main->defTglBukuBelumSensus;
		}
				
		//kondisi sertifikat -------------------------------
		switch ($_GET['SPg']){
			case '04':{
				$selSertifikat = $_POST['selSertifikat'];
				switch ($selSertifikat){
					case '1': $Kondisi .= ' and bersertifikat ="1" '; break;
					case '2': $Kondisi .= ' and bersertifikat ="2" '; break;
					case '3': $Kondisi .= ' and bersertifikat ="" '; break;
				}
				$TampilFilterSertifikat = 
					"<div style='float:left;margin: 0 4 0 0;border-left: 1px solid #E5E5E5;height:22'></div>".
					//"<div style='float:left;padding: 2 4 0 4'> Bersertifikat </div>".
					"<div style='float:left;padding: 0 4 0 0'>".
					cmb2D_v3('selSertifikat', $selSertifikat, $Main->bersertifikat, '','Status Sertifikat ').
					"</div>";
				$FiltID = $_POST['FiltID'];
				$FiltVal = $_POST['FiltVal'];
				switch ($FiltID ){
					case 1: {	$Kondisi .= " and luas = $FiltVal "; break;	}
				}
				break;
			}	
		}
		
		//Kondisi cari bi di usulan hapus ------------------------------------------------
		$formcaribi = $_REQUEST['formcaribi'];
		if($formcaribi ==1){
			$Kondisi .= " and (kondisi=3 or kondisi=2 or kondisi=4) ";			
			//kondisi bukan usulan
			/*$aqry = "select id_bukuinduk from v1_penghapusan_usul_det_bi ".
				"where c='04' and d='01' ".
				"and e='01' and sesi ='' ".
				"and id>0 and tahun_sensus = '2013' ";*/
			//$qry = mysql_query($aqry);			
			/*
			$Kondisi .= " and tahun_sensus<>'' and tahun_sensus is not NULL and id NOT IN (".
				"select id_bukuinduk as id from v1_penghapusan_usul_det_bi ".
				"where c='$fmSKPD' and d='$fmUNIT' ".
				"and e='$fmSUBUNIT' and sesi ='' ".
				"and id>0 and tahun_sensus = '2013') ";
			*/
			$Kondisi .= //" and tahun_sensus<>'' and tahun_sensus is not NULL 
			 	" and id NOT IN (".
				"select id_bukuinduk as id from v1_penghapusan_usul_det_bi ".
				"where c='$fmSKPD' and d='$fmUNIT' ".
				"and e='$fmSUBUNIT' and e1='$fmSEKSI' and sesi ='' ".
				"and id>0 ) ";
		}
		
		//kondisi BarCode barcodeSensusBaru_input
		$barcodeCariBarang_input = $_REQUEST['barcodeCariBarang_input'];
		if (!empty($barcodeCariBarang_input)) $Kondisi .= " and idall2='$barcodeCariBarang_input' ";
				
		//kondisi skpd readonly pembukuan
		$f= $_REQUEST['f']=='00' || $_REQUEST['f']=='' ? '' : $_REQUEST['f'];
		$g= $_REQUEST['g']=='00' || $_REQUEST['g']=='' ? '' : $_REQUEST['g'];		
		
		if($f!='' || $g!='') {
			$kode_barang = "$f.$g" ;
		}else{
			$kode_barang = $_REQUEST['kode_barang'];	
		}

		switch ($jns){
			case 'lancar' :$Kondisi .= " and concat(f,g)='0519' and harga>=500000 and kondisi<>3 "; break;  
			//case 'tetap' : $Kondisi .= " and kondisi<>3 and (staset=3 or staset=1) "; break;			
			case 'tetap' : $Kondisi .= " and (staset=3 or staset=1) "; break;
			case 'pindah' : $Kondisi .= " and status_barang=4 "; break;//$Kondisi .= " and (staset=5 or staset=11 or staset=12 or staset=13) "; break; //aset pemindahtanganan
			case 'tgr' : $Kondisi .= " and staset=6 "; break; //aset tgr
			case 'mitra' : $Kondisi .= " and staset=7 "; break; //aset kemitraan
			case 'atb' : $Kondisi .= " and staset=8 and status_barang<='1'"; break; //aset tak berwujud
			case 'lain' : $Kondisi .= " and staset=9 and status_barang<='1' "; break; //aset lain lain
			case 'lainx' : $Kondisi .= " and (kondisi=3 or status_penguasaan=2) and harga>=500000 "; break;
			case 'intra' : $Kondisi .= " and staset<=9 "; break;
			case 'bawahkap' : $Kondisi .= " and harga<$Main->MIN_INTRA "; break;
			case 'ekstra' : $Kondisi .= " and staset=10 "; break;
			case 'penyusutan' : 
					$tahun_susut = $_REQUEST['tahun_susut'];
					$fmCekSusut = $_REQUEST['fmCekSusut'];
					//kondisi cek penyusutan
					if($fmCekSusut==1){
						//$Kondisi .= " and id not in(select idbi from penyusutan where tahun = '$tahun_susut') ";
						$Kondisi .= " and id not IN(select idbi from penyusutan where tahun = '$tahun_susut') and ( thn_susut_aw + masa_manfaat-1 >= $tahun_susut or thn_susut_aw=0 )  ";					
					}elseif($fmCekSusut==2){
						$Kondisi .= " and id IN (select idbi from penyusutan where tahun = '$tahun_susut') ";	
					}else{
						$Kondisi .= "";
					}
								
					if($Main->SUSUT_MODE==2 ){//serang
						//$Kondisi .= " and year(tgl_buku) < '$tahun_susut' ";	
						//$Kondisi .= " and f in('02','03','04','05','07') and (status_barang='1' or status_barang='2') and (staset<=3 or staset=8 or staset=10)  "; 	
						$Kondisi .= " and year(tgl_buku) <= '$tahun_susut' ";	
						$Kondisi .= " and f in('02','03','04','05','07')  "; 
						$Kondisi .= " and (staset<=3 or staset=8) ";
						if ($fmFiltTglBtw_tgl2 =='' || $fmFiltTglBtw_tgl2 =='0000-00-00'  ){
							$Kondisi .= "  and (status_barang=1 or status_barang=2)  "; 
						}
					}elseif($Main->VERSI_NAME=='TASIKMALAYA_KAB' ){
						//$Kondisi .= " and year(tgl_buku) < '$tahun_susut' ";	
						//$Kondisi .= " and f in('02','03','04','05','07') and (status_barang='1' or status_barang='2') and (staset<=3 or staset=8 or staset=10)  "; 	
						$Kondisi .= " and year(tgl_buku) <= '$tahun_susut' ";	
						$Kondisi .= " and f in('02','03','04','05','07')  "; 
						$Kondisi .= " and (staset<=3 or staset=8 or staset=9) ";
						if ($fmFiltTglBtw_tgl2 =='' || $fmFiltTglBtw_tgl2 =='0000-00-00'  ){
							$Kondisi .= "  and (status_barang=1 or status_barang=2)  "; 
						}						
					}elseif($Main->VERSI_NAME=='BOGOR'){
						//$Kondisi .= " and year(tgl_buku) <= '$tahun_susut' ";	
						//$Kondisi .= " and f in('02','03','04','07') and (status_barang='1' or status_barang='2') and (staset<=3 or staset=8) and kondisi<>3 "; 
						$Kondisi .= " and year(tgl_buku) <= '$tahun_susut' ";	
						$Kondisi .= " and f in('02','03','04','07')  "; 
						$Kondisi .= " and (staset<=3 or staset=8)  ";
						if ($fmFiltTglBtw_tgl2 =='' || $fmFiltTglBtw_tgl2 =='0000-00-00'  ){
							$Kondisi .= "  and (status_barang=1 or status_barang=2)  "; 
						}
					}elseif($Main->VERSI_NAME=='GARUT' ){
						//$Kondisi .= " and year(tgl_buku) <= '$tahun_susut' ";	
						//$Kondisi .= " and f in('02','03','04','07') and (status_barang='1' or status_barang='2') and (staset<=3 or staset=8) and kondisi<>3 "; 
						$Kondisi .= " and year(tgl_buku) <= '$tahun_susut' ";	
						$Kondisi .= " and f in('02','03','04','07')  "; 
						$Kondisi .= " and (staset<=3 or staset=8) and kondisi<>3  ";
						if ($fmFiltTglBtw_tgl2 =='' || $fmFiltTglBtw_tgl2 =='0000-00-00'  ){
							$Kondisi .= "  and (status_barang=1 or status_barang=2)  "; 
						}
					}elseif($Main->VERSI_NAME=='KARAWANG'){
						//$Kondisi .= " and year(tgl_buku) <= '$tahun_susut' ";	
						//$Kondisi .= " and f in('02','03','04','07') and (status_barang='1' or status_barang='2') and (staset<=3 or staset=8) and kondisi<>3 "; 
						$Kondisi .= " and year(tgl_buku) <= '$tahun_susut' ";	
						$Kondisi .= " and (f in('02','03','04','07') OR (f=05 AND g=20))  "; 
						//$Kondisi .= " and f in('02','03','04','05','07')  "; 
						$Kondisi .= " and (staset<=3 or staset=8) and kondisi<>3  ";
						if ($fmFiltTglBtw_tgl2 =='' || $fmFiltTglBtw_tgl2 =='0000-00-00'  ){
							$Kondisi .= "  and (status_barang=1 or status_barang=2)  "; 
						}
					}elseif($Main->VERSI_NAME=='PANDEGLANG'){
						//$Kondisi .= " and year(tgl_buku) <= '$tahun_susut' ";	
						//$Kondisi .= " and f in('02','03','04','07') and (status_barang='1' or status_barang='2') and (staset<=3 or staset=8) and kondisi<>3 "; 
						$Kondisi .= " and year(tgl_buku) <= '$tahun_susut' ";	
						$Kondisi .= " and (f in('02','03','04','07') OR (f='05' AND g='20'))  "; 
						$Kondisi .= " and (staset<=3 or staset=8 or staset=9)  ";
						if ($fmFiltTglBtw_tgl2 =='' || $fmFiltTglBtw_tgl2 =='0000-00-00'  ){
							$Kondisi .= "  and (status_barang=1 or status_barang=2)  "; 
						}
					}else{
						//$Kondisi .= " or year(tgl_buku) <= '$tahun_susut' ";	??
						//$Kondisi .= " and f in('02','03','04','05','07') and (status_barang='1' or status_barang='2') and (staset<=3 or staset=8) "; 	
						
						$Kondisi .= " and year(tgl_buku) <= '$tahun_susut' ";	
						$Kondisi .= " and f in('02','03','04','05','07')  "; 
						$Kondisi .= " and (staset<=3 or staset=8) ";
						if ($fmFiltTglBtw_tgl2 =='' || $fmFiltTglBtw_tgl2 =='0000-00-00'  ){
							$Kondisi .= "  and (status_barang=1 or status_barang=2)  "; 
						}
					}
				break;
			#$Kondisi .= " and staset=3 and status_barang=1 and f in('02','03','04','05') "; break;
			
		}
		
				
		//kondisi 2 --------------
		//if(!empty($barcodeSensus_input)) $Kondisi .= " and concat(f,'.',g,'.',h,'.',i,'.',j) like '$barcodeSensus_input%'";
		if($Main->KD_BARANG_P108){
			if(!empty($kode_barang)) $Kondisi .= " and concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j) like '$kode_barang%'";
		}else{
			if(!empty($kode_barang)) $Kondisi .= " and concat(f,'.',g,'.',h,'.',i,'.',j) like '$kode_barang%'";
		}
		
		$nama_barang = $_REQUEST['nama_barang'];
		if(!empty($nama_barang)) $Kondisi .= " and nm_barang like '%$nama_barang%'";
		$jml_harga1 = $_REQUEST['jml_harga1'];
		$jml_harga2 = $_REQUEST['jml_harga2'];
		if(!empty($jml_harga1)) $Kondisi .= " and jml_harga >= '$jml_harga1' ";
		if(!empty($jml_harga2)) $Kondisi .= " and jml_harga <= '$jml_harga2' ";
		$alamat = $_REQUEST['alamat'];
		if(!empty($alamat)) $Kondisi .= " and alamat like '%$alamat%'  ";
//		$selKabKota = $_REQUEST['selKabKota'];
//		if(!empty($selKabKota)) $Kondisi .= " and alamat_b='$selKabKota'  ";
		$noSert = $_REQUEST['noSert'];
		if(!empty($noSert)) $Kondisi .= " and sertifikat_no like '%$noSert%'  ";
		$selHakPakai = $_REQUEST['selHakPakai'];
		if(!empty($selHakPakai)) $Kondisi .= " and status_hak='$selHakPakai' ";
		
		$konsTingkat = $_REQUEST['konsTingkat'];
		if(!empty($konsTingkat)) $Kondisi .= " and konstruksi_tingkat = '$konsTingkat'  ";
		$konsBeton = $_REQUEST['konsBeton'];
		if(!empty($konsBeton)) $Kondisi .= " and konstruksi_beton = '$konsBeton'  ";
		$status_tanah = $_REQUEST['status_tanah'];
		if(!empty($status_tanah)) $Kondisi .= " and status_tanah = '$status_tanah'  ";
								
		$merk = $_REQUEST['merk'];
		if(!empty($merk)) $Kondisi .= " and merk like '%$merk%' ";				
		$bahan = $_REQUEST['bahan'];
		if(!empty($bahan)) $Kondisi .= " and bahan like '%$bahan%' ";
		$nopabrik = $_REQUEST['nopabrik'];
		if(!empty($nopabrik)) $Kondisi .= " and no_pabrik like '%$nopabrik%' ";		
		$norangka = $_REQUEST['norangka'];
		if(!empty($norangka)) $Kondisi .= " and no_rangka like '%$norangka%' ";		
		$nomesin = $_REQUEST['nomesin'];
		if(!empty($nomesin)) $Kondisi .= " and no_mesin like '%$nomesin%' ";		
		$nopolisi = $_REQUEST['nopolisi'];
		if(!empty($nopolisi)) $Kondisi .= " and no_polisi like '%$nopolisi%' ";		
		$nobpkb = $_REQUEST['nobpkb'];
		if(!empty($nobpkb)) $Kondisi .= " and no_bpkb like '%$nobpkb%' ";
		
		$dokumen_no = $_REQUEST['dokumen_no'];
		if(!empty($dokumen_no)) $Kondisi .= " and dokumen_no like '%$dokumen_no%' ";
		$kode_tanah = $_REQUEST['kode_tanah'];
		if(!empty($kode_tanah)) $Kondisi .= " and kode_tanah like '%$kode_tanah%' ";		
		$konstruksi = $_REQUEST['konstruksi'];
		if(!empty($konstruksi)) $Kondisi .= " and konstruksi like '%$konstruksi%' ";
		
		$judul = $_REQUEST['judul'];
		if(!empty($judul)) $Kondisi .= " and buku_judul like '%$judul%' ";
		$spesifikasi = $_REQUEST['spesifikasi'];
		if(!empty($spesifikasi)) $Kondisi .= " and buku_spesifikasi like '%$spesifikasi%' ";
		$seni_asal_daerah = $_REQUEST['seni_asal_daerah'];
		if(!empty($seni_asal_daerah)) $Kondisi .= " and seni_asal_daerah like '%$seni_asal_daerah%' ";
		$seni_pencipta = $_REQUEST['seni_pencipta'];
		if(!empty($seni_pencipta)) $Kondisi .= " and seni_pencipta like '%$seni_pencipta%' ";
		$seni_bahan = $_REQUEST['seni_bahan'];
		if(!empty($seni_bahan)) $Kondisi .= " and seni_bahan like '%$seni_bahan%' ";
		$hewan_jenis = $_REQUEST['hewan_jenis'];
		if(!empty($hewan_jenis)) $Kondisi .= " and hewan_jenis like '%$hewan_jenis%' ";
		$hewan_ukuran = $_REQUEST['hewan_ukuran'];
		if(!empty($hewan_ukuran)) $Kondisi .= " and hewan_ukuran like '%$hewan_ukuran%' ";		
		$bangunan = $_REQUEST['bangunan'];
		if(!empty($bangunan)) $Kondisi .= " and bangunan = '$bangunan' ";
		
		$uraian= $_REQUEST['uraian'];
		if(!empty($uraian)) $Kondisi .= " and uraian like '%$uraian%' ";
		$luas1 = $_REQUEST['luas1'];
		$luas2 = $_REQUEST['luas2'];
		if(!empty($luas1)) $Kondisi .= " and luas >= '$luas1' ";
		if(!empty($luas2)) $Kondisi .= " and luas <= '$luas2' ";
		$luas_lantai1 = $_REQUEST['luas_lantai1'];
		$luas_lantai2 = $_REQUEST['luas_lantai2'];
		if(!empty($luas_lantai1)) $Kondisi .= " and luas_lantai >= '$luas_lantai1' ";
		if(!empty($luas_lantai2)) $Kondisi .= " and luas_lantai <= '$luas_lantai2' ";
		
		$tipe = $_REQUEST['tipe'];
		$tahun_sensus = $_REQUEST['tahun_sensus'];
		if(!empty($tahun_sensus)) {
		//if($tahun_sensus != '') {
			if ($tahun_sensus=='belum_sensus') {
				//$Kondisi .= " and (tahun_sensus ='' or tahun_sensus is null)";
				require_once('daftarobj.php');
				require_once('fnsensus.php');
				//global $SensusTmp;
				if($tipe!='kertaskerja'){
					$thnsensusskr = $SensusTmp->getTahunSensus();
					$Kondisi .= " and (tahun_sensus <> $thnsensusskr or tahun_sensus='' or tahun_sensus is null)";	
				}
				
				
			}else{
				$Kondisi .= " and tahun_sensus ='$tahun_sensus'";
			}			
		}
		
		//kondisi penyusutan -------------------------
		if($jns == 'penyusutan' && $Main->PENYUSUTAN){
			$tahun_susut = $_REQUEST['tahun_susut'];
			if(empty($tahun_susut)) $tahun_susut = $HTTP_COOKIE_VARS['coThnAnggaran'];//date('Y');//2016
			$vtahun_susut = " Tahun Laporan &nbsp;<input type=text name='tahun_susut' id='tahun_susut' size=4 maxlength=4 onkeypress='return isNumberKey(event)' value='$tahun_susut' readonly> ";	
		 	//kondisi cek penyusutan
			$fmCekSusut = $_REQUEST['fmCekSusut'];
			$arrStBatal = array(
         				  array('1','Belum Penyusutan'),
	     				  array('2','Sudah Penyusutan')
			);
			$vcek_susut = cmb2D_v2('fmCekSusut',$fmCekSusut,$arrStBatal,'','-- Status Penyusutan --','');
		}			
		
		//kondisi lain -----------------------		
		$jmPerHal = cekPOST("jmPerHal"); 
		$Main->PagePerHal = !empty($jmPerHal) ? $jmPerHal : $Main->PagePerHal;
		$cbxDlmRibu = $_POST["cbxDlmRibu"];		
		$cbxCekProgram = $_REQUEST["cbxCekProgram"];
		if($cbxCekProgram){
			$Kondisi .= " and (p is null or p=0) ";
		}		
		$cbxCekBAST = $_REQUEST["cbxCekBAST"];		
		if($cbxCekBAST){
			$Kondisi .= " and (no_ba is null or no_ba='' or no_ba = '-')  ";
		}
		
		
		
//		$alamat_kec = $_REQUEST['alamat_kec'];
		$alamat_b=$_REQUEST['WilayahfmxKotaKab'];
		$alamat_c=$_REQUEST['WilayahfmxKecamatan'];
		
		$alamat_kota=$_REQUEST['WilayahfmxKotaKabtxt'];
		$alamat_kec=$_REQUEST['WilayahfmxKecamatantxt'];
		if(!empty($alamat_b)){
		if ($alamat_b != '0' )
		{
//			$alamat_kota='';
			if(!empty($alamat_b)) $Kondisi .= " and alamat_b='$alamat_b' ";
		}
		}
		if(!empty($alamat_c)){
		if ($alamat_c != '0' )
		{
			$alamat_kec='';
			 $Kondisi .= " and alamat_c='$alamat_c' ";

		}
		}
		
		if(!empty($alamat_kec)) $Kondisi .= " and alamat_kec like '%$alamat_kec%' ";
		$alamat_kel = $_REQUEST['alamat_kel'];
		if(!empty($alamat_kel)) $Kondisi .= " and alamat_kel like '%$alamat_kel%' ";
		
		
		

		/*//kondisi pilih --------------------- teu kapake?
		$tipebi = $_REQUEST['tipebi'];
		if($tipebi=='pilih'){
			$idpilihan = $HTTP_COOKIE_VARS['Keranjang'];
			if($idpilihan != ''){
				$Kondisi .= $Kondisi ==''? '':' and ';	//$arridpilih = explode(',',$idpilihan);
				
				$Kondisi .= $SPg=='03' ? " id in ($idpilihan) ": " idbi in ($idpilihan) ";
			}
			
			
		}
		*/
		//kondisi pilihan banyak ----------------
		$cbxpilihfilter = $_REQUEST['cbxpilihfilter'];
		if($cbxpilihfilter==1){
			$idpilihan = $HTTP_COOKIE_VARS['penatausaha_DaftarPilih'];
			if($idpilihan != ''){
				$Kondisi .= $Kondisi ==''? '':' and ';	//$arridpilih = explode(',',$idpilihan);				
				$Kondisi .= $SPg=='03' ? " id in ($idpilihan) ": " idbi in ($idpilihan) ";
			}
		}
		
		//kondisi gambar ------------------------------
		if($Main->MODUL_JMLGAMBAR){
			$gambar = $_REQUEST['gambar'];
			if(!empty($gambar)) {
				switch ($gambar){
					case '1': $Kondisi .= " and (jml_gambar > 0) "; break;
					case '2': $Kondisi .= " and (jml_gambar = 0  or jml_gambar is null)"; break;
				}
			}
			$vgambar =
				"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> Gambar ".
				cmb2D_v2('gambar', $gambar, $Main->StatusGambar, '','Semua').
				"</div>".			
				'';
		}
		
		if($Main->MODUL_PROGRAM){
		//Program & Kegiatan
		$nmprogram = $_REQUEST['nmprogram'];
		if($nmprogram != '') $Kondisi .= " and nmprogram like '%$nmprogram%' ";
		$vprogram = 
				"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>".
				"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> ".
				"<input type='text' id='nmprogram' name='nmprogram' value='$nmprogram' placeholder='Program' size='16'>".
				"</div>".			
				'';
				
		$nmkegiatan = $_REQUEST['nmkegiatan'];
		if($nmkegiatan != '') $Kondisi .= " and nmkegiatan like '%$nmkegiatan%' ";
		$vkegiatan = 
				"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>".
				"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> ".
				"<input type='text' id='nmkegiatan' name='nmkegiatan' value='$nmkegiatan' placeholder='Kegiatan' size='16'>".
				"</div>".			
				'';
		}
		
		//kondisi bast spk penggunaan -----------------------
		if($Main->MODUL_BAST){
			$no_ba = $_REQUEST['no_ba'];
			if($no_ba != '') $Kondisi .= " and no_ba like '%$no_ba%' ";
			$vbast = 
				$batas.
				"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> ".
				"<input type='text' id='no_ba' name='no_ba' value='$no_ba' placeholder='No. BAST' size='16'>".
				"</div>".			
				'';
		}
		
		if($Main->MODUL_SPK){
			$no_spk = $_REQUEST['no_spk'];
			if($no_spk != '') $Kondisi .= " and no_spk like '%$no_spk%' ";
			$vspk = 
				$batas.
				"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>  ".
				"<input type='text' id='no_spk' name='no_spk' value='$no_spk' placeholder='No. SPK/Kontrak' size='15'>".
				"</div>".			
				'';
		}
		if($Main->MODUL_PENGGUNAAN){
			$penggunaanbi = $_REQUEST['penggunaanbi'];
			if($penggunaanbi != '') $Kondisi .= " and penggunaan like '%$penggunaanbi%' ";		
			$vpenggunaanbi =
				"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>  ".
				"<input type='text' id='penggunaanbi' name='penggunaanbi' value='$penggunaanbi' placeholder='Penggunaan' >".
				"</div>".			
				'';
		}
		
		//kondisi idbi
		if($Main->MODUL_IDBARANG){
			$nodata = $_REQUEST['nodata'];
			$fidbi = $SPg=='03' || $SPg=='' || $SPg=='belumsensus' ? 'id' : 'idbi';
			if($nodata != '') $Kondisi .= " and $fidbi='$nodata' ";
			$vnodata = 
				"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>  ".
				"<input type='text' id='nodata' name='nodata' size='8' value='$nodata' placeholder='ID Barang' >".
				"</div>".			
				'';
		}
		
		$fmThnSusut = $_REQUEST['fmThnSusut'];
		$fmThnSusut = $fmThnSusut==NULL ? $_COOKIE['coThnAnggaran'] : $fmThnSusut;
		
		if($Main->TAMPIL_SUSUT==1){
			$vthn_susut = 
				"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>  ".
				"Tahun Laporan&nbsp;:&nbsp;<input type='text' id='fmThnSusut' name='fmThnSusut' value='$fmThnSusut' placeholder='ID Barang' size='4'>".
				"</div>".			
			'';
		}else{
			$vthn_susut="";	
		}	
		
		$idawal = $_REQUEST['idawal'];
			if($idawal != '') $Kondisi .= " and idawal = '$idawal' ";		
			$vidawal =
				"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>  ".
				"<input type='text' id='idawal' name='idawal' size='8' value='$idawal' placeholder='ID Awal' >".
				"</div>".			
				'';
		//tampil cari ----------------------------------------------------------------	
		//$FilterStatus = ''; //cmb2D_v3('selStatusBrg', $selStatusBrg, $Main->StatusBarang, $disStatusBrg,'Semua Status ');
		switch($_GET['SPg']){			
			case '03': case '04': case '05' : case'06': case'07': case'08': case'09' :{
				$ArFieldCari = array(
				array('nm_barang','Nama Barang'),
				array('thn_perolehan','Tahun Perolehan'),
				array('alamat','Letak/Alamat'),
				array('ket','Keterangan')
					);				
				break;
			}
			default:{
				$ArFieldCari = array(
				array('nm_barang', 'Nama Barang'),
				array('thn_perolehan', 'Tahun Perolehan'),
				//array('alamat', 'Letak/Alamat'),
				//array('ket', 'Keterangan')
					);					
				break;			
			}
			
		}
		
		if($formcaribi ==1){
			$barcodeCari = $Main->BARCODE_ENABLE?

				"<span style='color:red'>BARCODE</span><br>
				<input type='TEXT' value='' id='barcodeCariBarang_input' name='barcodeCariBarang_input' 
				style='font-size:24;width: 369px;' ".
				//style='font-size:24;width: 369px;' size='32' maxlength='32' ".
				//onchange='barcodeCariBarangExec()'
				">".
				"<span id='barcodeCariBarang_msg' name='barcodeCariBarang_msg'>
					<a style='color:red;' href='javascript:barcodeCariBarang.setInputReady()'>Not Ready! (click for ready)</a>".
				"</span>":"";
		}else{
			$barcodeCari = '';
		}
		
		$OptCari =  //$Main->ListData->OptCari =
			"<table width=\"100%\" height=\"100%\" class=\"adminform\" style='margin: 4 0 0 0;'>
			<tr > 
			<td align='Left'> &nbsp;&nbsp;".
			"<div style='float:left'>".
				CariCombo4($ArFieldCari, $fmCariComboField, $fmCariComboIsi,"Penatausaha.refreshList(true)" ).
			"</div>".
			"<div id='".$this->prefix."_pilihan_msg' style='float:right;padding: 4 4 4 8;'></div>".
			"</td>".
			"<td width='375'>".
				/*"<span style='color:red'>BARCODE</span><br>			
				<input type='TEXT' value='' 
					id='barcodeSensus_input' name='barcodeSensus_input'
					style='font-size:24;width: 379px;' 
					size='28' maxlength='28'>
				<span id='barcodeSensus_msg' name='barcodeSensus_msg' ></span>". 
				*/
				$barcodeCari.
				
					
				//<input type='TEXT' value='' 	style='	font-weight:bold' 	size='50'	>-->
			"</td>
			</tr>
		</table>";
		
		//tampil filter ==============================================================================================================
		switch($SPg){
			case "03" : case "listbi_cetak" :{ $tblname = ' buku_induk'; break; }
			case "04" : case "kib_a_cetak" :{ $tblname = " buku_induk where f='01' ";	break; }
			case "05" : case "kib_b_cetak" :{ $tblname = " buku_induk where f='02' ";	break; }
			case "06" : case "kib_c_cetak" :{ $tblname = " buku_induk where f='03' ";	break; }
			case "07" : case "kib_d_cetak": { $tblname = " buku_induk where f='04' ";	break; }
			case "08" : case "kib_e_cetak": { $tblname = " buku_induk where f='05' ";	break; }
			case "09" : case "kib_f_cetak": { $tblname = " buku_induk where f='06' "; break; }
			case "kibg" : case "kib_g_cetak": { $tblname = " buku_induk where f='07' "; break; }
			default : $tblname = ' buku_induk'; break;
		}	
		
		$filtTgl = $SPg == '03'? 
			"<div style='float:left;padding: 0 4 0 0'> ".
			genComboBoxQry('fmTglBuku',$fmTglBuku,
				"select tgl_buku from $tblname group by tgl_buku order by tgl_buku desc",
				'tgl_buku', 'tgl_buku','Semua Tgl. Buku').
			"</div>"
			: '';		
		$BarisPerHalaman = 		
			"<div style='float:left;padding: 2 8 0 0;height:20;padding: 4 4 0 0'> ".	
			" Baris per halaman <input type=text name='jmPerHal' id='jmPerHal' size=4 value='$Main->PagePerHal'> </div>"
			;
		$dalamRibuan = " <input $cbxDlmRibu id='cbxDlmRibu' type='checkbox' value='checked' name='cbxDlmRibu' > ".
			" Dalam Ribuan ";				
		if($Main->PENATUSAHAAN_FILT_CEKPROGRAM ) $cekProgram = " <input $cbxCekProgram id='cbxCekProgram' type='checkbox' value='checked' name='cbxCekProgram' > Program Belum Diisi ";				
		if($Main->PENATUSAHAAN_FILT_CEKNOBAST ==1)$cekBAST = " <input $cbxCekBAST id='cbxCekBAST' type='checkbox' value='checked' name='cbxCekBAST' > No BAST Belum Diisi ";				
		
		$batas = $Main->batas;//"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>";
		$baris = $Main->baris;//"<div style='border-top: 1px solid #E5E5E5;height:1'></div>";
		
		if($Main->FILT_TGL_BUKU) $vtgl_buku = 
			"<div style='float:left;padding: 2 8 0 0;height:20;padding: 4 4 0 0'> Tgl. Buku </div>".				
			createEntryTglBeetwen('fmFiltTglBtw',$fmFiltTglBtw_tgl1, $fmFiltTglBtw_tgl2,'','','adminForm',1);
		if($Main->FILT_THN_BUKU) $vthn_buku = 
			"<div style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
				genComboBoxQry('fmFiltThnBuku',$fmFiltThnBuku,
					"select year(tgl_buku)as thnbuku from $tblname group by thnbuku desc",
					'thnbuku', 'thnbuku','Tahun Buku'). 
			"</div>";
		$fmThnSensus = $_REQUEST['fmThnSensus'];
		if ($fmThnSensus=='1')
		{
			 $Kondisi .=" and tahun_sensus <>'".$Main->thnsensus_default."' ";
		} else {
			
		
			
		$aqry = "select tahun_sensus from view_buku_induk where tahun_sensus<>'' group by tahun_sensus desc ";
		$qry = mysql_query($aqry);
		$Input = "<option value=''>Tahun Sensus</option><option value='belum_sensus'>Belum Sensus</option>"; 
		while ($Hasil=mysql_fetch_array($qry)) { 
			//$Sel = $Hasil['tahun_sensus']==$value?"selected":""; 
			$Input .= "<option $Sel value='{$Hasil['tahun_sensus']}'>{$Hasil['tahun_sensus']}</option>"; 
		} 
		$Input  = "<select $param name='tahun_sensus' id='tahun_sensus'>$Input</select>"; 

		$vthn_sensus = 
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				$Input.
			"</div>";
		}
		$vthn_perolehan =
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				genComboBoxQry('fmTahunPerolehan',$fmTahunPerolehan,
					"select thn_perolehan from $tblname group by thn_perolehan order by thn_perolehan desc",
					'thn_perolehan', 'thn_perolehan','Dari Tahun'). 
			"</div>" .
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> s/d </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				genComboBoxQry('fmTahunPerolehan2',$fmTahunPerolehan2,
					"select thn_perolehan from $tblname group by thn_perolehan order by thn_perolehan desc",
					'thn_perolehan', 'thn_perolehan','Tahun'). 
			"</div>" ;
		$formcaribi = $_REQUEST['formcaribi'];
		if($formcaribi ==1){
			$vkondisi_barang = '';// "<input type='hidden' id='fmKONDBRG' name='fmKONDBRG' value='3'>";
		}else{
			// $ArBarang=$Main->KondisiBarang;
			$ArBarang=array_merge($Main->KondisiBarang,$Main->KondisiBarangLainnya);
			$vkondisi_barang = 
				"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
					cmb2D_v2('fmKONDBRG',$fmKONDBRG, $ArBarang,'','Kondisi Barang','').
				"</div>";
				
		}
		
		if($Main->STATUS_SURVEY==1){
			$vstatus_survey="<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>
							<div style='float:left;padding: 0 4 0 4;height:22;'>".
								"Status Recon : <input type='text' name='fmNAMASURVEY' id='fmNAMASURVEY' value='".$fmNAMASURVEY."' style='width:200px'>
								<input type='hidden' id='fmSTSURVEY' name='fmSTSURVEY' value='".$fmSTSURVEY."'>
								<input type='button' name='reset' value='Reset' onClick='document.getElementById(\"fmNAMASURVEY\").value=\"\";document.getElementById(\"fmSTSURVEY\").value=\"\";'>
								<input type='checkbox' name='tnp_strecon' id='tnp_strecon'>Tanpa Status Recon".								
							"</div>";
		}else{
			$vstatus_survey="";
		}	
		
		if($Main->JNS_EKSTRA==1 && $jns =='ekstra'){
			//$jnsEkstra = $_REQUEST['jnsEkstra'];
			$vjnsEkstra = "<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>".
				"<div style='float:left;padding: 0 4 0 4;height:22;'>".
					cmb2D_v2('jnsEkstra',$jnsEkstra, $Main->arrJnsEkstra,'','Jenis Ekstra','').
				"</div>";
		}	
		if($Main->JNS_LAINLAIN==1 && $jns =='lain'){
			//$jnsLain = $_REQUEST['jnsLain'];
			$vjnsLain = "<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>".
				"<div style='float:left;padding: 0 4 0 4;height:22;'>".
					cmb2D_v2('jnsLain',$jnsLain, $Main->arrJnsLain,'','Jenis Lain-lain','').
				"</div>";
		}	
		/*
		//==============hasil auocompleate===============//
		$a_json = array();
		$a_json_row = array();
		$name_startsWith = $_REQUEST['name_startsWith'];
		$maxRows = $_REQUEST['maxRows'];
		//echo $name_startsWith
		$sql = "select Id,nama from ref_statusbarang2 where nama like '%".$name_startsWith."%' limit 0,$maxRows ";$cek.=$sql;		
		$rs = mysql_query($sql);
		while($row = mysql_fetch_assoc($rs)) {
				$a_json_row["id"] = $row['Id'];
				$a_json_row["value"] = $row['nama'];//.' '.$row['uraian'];
				$a_json_row["label"] =  $row['nama'];
					array_push($a_json, $a_json_row);
		}
		//$a_json = apply_highlight($a_json, $parts);
		$json = json_encode($a_json);
		echo $json;
		//===============================================//
		*/
				
		$vkode_barang =
			//"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0 ' > Kode Barang </div>".				
			"<div style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
				"<input id='kode_barang' name='kode_barang' value='$kode_barang' title='Cari Kode Barang (ex: 01.02.01.01.01)' placeholder='Kode Barang'>".
				"<input type='hidden' id='jns' name='jns' value='$jns' >".
			"</div>";
		$vnm_barang = 
			//"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0 '> Nama Barang </div>".				
			"<div style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
				"<input id='nama_barang' name='nama_barang' value='' title='Cari Nama Barang (ex: Meja Kayu)' placeholder='Nama Barang' style='width:250'>".
			"</div>" ;
		$vhrg_perolehan=
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> Harga Perolehan Rp </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				"<input type='text' name='jml_harga1' id='jml_harga1' value='' onkeydown='oldValue=this.value;' onkeypress='return isNumberKey(event); ' onkeyup='TampilUang('TampilfmJMLHARGA2',this.value);'
				title = 'Cari Barang dengan harga perolehan lebih dari atau sama dengan (ex: 1000000)'
				>".
			"</div>" .	
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> s/d </div>".			
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				"<input type='text' name='jml_harga2' id='jml_harga2' value='' onkeydown='oldValue=this.value;' onkeypress='return isNumberKey(event); ' onkeyup='TampilUang('TampilfmJMLHARGA2',this.value);'
				title = 'Cari Barang dengan harga perolehan kurang dari atau sama dengan (ex: 1000000)'
				>".
			"</div>";
		$vstatus_hakpakai =
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				cmb2D_v2('selHakPakai', $selHakPakai, $Main->StatusHakPakai, '','Status Tanah').
			"</div>" ;
		$valamat =
			//"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> Alamat </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				"<input id='alamat' name='alamat' type='text' value='$alamat' style='width:300' placeholder='Alamat'>".
			"</div>" ;
		$vkota =selKabKota_txt_div($alamat_b,$alamat_kota,'',1,'Wilayah').selKecamatan_txt_div($alamat_c,$alamat_kec,'',$alamat_b,1,'Wilayah');
/*
			"
			<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				selKabKota(selKabKota, $selKabKota).
			"</div>".
*/					
		$vnosertifikat = 
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> No. Sertifikat </div>".			
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				'<input name="noSert" type="text" value="'.$noSert.'">'.
			"</div>" ;
		$vmerk =
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0 '> Merk </div>".				
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				"<input id='merk' name='merk' type='text' value='$merk' style=''>".
			"</div>";
		$vbahan = 
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> Bahan </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				"<input id='bahan' name='bahan' type='text' value='$bahan' style=''>".
			"</div>" ;
		$vnopabrik=
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> No. Pabrik </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				"<input id='nopabrik' name='nopabrik' type='text' value='$nopabrik' style=''>".
			"</div>" ;
		$vnorangka =
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> No. Rangka </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				"<input id='norangka' name='norangka' type='text' value='$norangka' style=''>".
			"</div>" ;
		$vnomesin =
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> No. Mesin </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				"<input id='nomesin' name='nomesin' type='text' value='$nomesin' style=''>".
			"</div>" ;
		$vnopolisi = 
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> No. Polisi </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				"<input id='nopolisi' name='nopolisi' type='text' value='$nopolisi' style=''>".
			"</div>" ;
		$vnobpkb = 
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> No. BPKB </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				"<input id='nobpkb' name='nobpkb' type='text' value='$nobpkb' style=''>".
			"</div>" ;
		$vkonst_bertingkat = 
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				cmb2D_v2('konsTingkat', $konsTingkat, $Main->Tingkat, '','-- Bertingkat/Tidak --').
			"</div>";
		$vkonst_beton=
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				cmb2D_v2('konsBeton', $konsBeton, $Main->Beton, '','-- Beton/Tidak --').
			"</div>";
		$vnodokumen =
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>  </div>".			
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				'<input name="dokumen_no" type="text" value="'.$dokumen_no.'" placeholder="No. Dokumen"> '.
			"</div>";
		$vstatus_tanah =
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				cmb2D_v2('status_tanah', $status_tanah, $Main->StatusTanah, '','-- Status Tanah --').
			"</div>" ;
		$vkode_tanah =
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>  </div>".			
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				'<input name="kode_tanah" type="text" value="'.$kode_tanah.'" style="width: 214px;" placeholder="No. Kode Tanah"> '.
			"</div>" ;
		$vkonstruksi =
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>  </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				'<input name="konstruksi" type="text" value="'.$konstruksi.'" placeholder="Konstruksi"> '.
			"</div>" ;
		$vjudul = 														
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>Judul Buku</div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				'<input id="judul" name="judul" type="text" value="'.$judul.'" title="Judul Buku Perpustakaan"> '.
			"</div>" ;
		$vspesifikasi = 
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> Spesifikasi </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				'<input id="spesifikasi" name="spesifikasi" type="text" value="'.$spesifikasi.'" title="Spesifikasi Buku Perpustakaan"> '.
			"</div>" ;
		$vseni_asal_daerah = 
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>Kesenian Asal Daerah </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				'<input id="seni_asal_daerah" name="seni_asal_daerah" type="text" value="'.$seni_asal_daerah.'" title="Asal Daerah Kesenian/Kebudayaan"> '.
			"</div>" ;
		$vseni_pencipta = 
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> Pencipta </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				'<input id="seni_pencipta" name="seni_pencipta" type="text" value="'.$seni_pencipta.'" title="Pencipta Kesenian/Kebudayaan"> '.
			"</div>" ;			
		$vseni_bahan = 
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'> Bahan </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				'<input id="seni_bahan" name="seni_bahan" type="text" value="'.$seni_bahan.'" title="Bahan Kesenian/Kebudayaan"> '.
			"</div>" ;
		$vhewan_jenis = 
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>Hewan Ternak Jenis</div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				'<input id="hewan_jenis" name="hewan_jenis" type="text" value="'.$hewan_jenis.'" title="Jenis Hewan Ternak"> '.
			"</div>" ;
		$vhewan_ukuran = 
			"<div  style='float:left;height:22;padding: 4 4 0 0'>Ukuran</div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				'<input id="hewan_ukuran" name="hewan_ukuran" type="text" value="'.$hewan_ukuran.'" title="Ukuran Hewan Ternak"> '.
			"</div>" ;
			
		$vbangunan =			
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				cmb2D_v2('bangunan', $bangunan, $Main->Bangunan, '','Tipe Bangunan').	
			"</div>" ;
			
		$vuraian_kibg =
			"<div  style='float:left;height:22;padding: 4 4 0 0'>Uraian</div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				'<input id="uraian" name="uraian" type="text" value="'.$uraian.'" title=""> '.
			"</div>" ;
		$vluas =
			"<div  style='float:left;height:22;padding: 4 4 0 0'> Luas Tanah (m2) </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				"<input type='text' name='luas1' id='luas1' size='7' value='' onkeydown='oldValue=this.value;' onkeypress='return isNumberKey(event); ' onkeyup='TampilUang('TampilfmJMLHARGA2',this.value);'				
				title = 'Cari Barang dengan luas tanah lebih dari atau sama dengan (ex: 1000000)'
				
				>".
			"</div>" .	
			"<div  style='float:left;height:22;padding: 4 4 0 0'> s/d </div>".			
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				"<input type='text' name='luas2' id='luas2' size='7' value='' onkeydown='oldValue=this.value;' onkeypress='return isNumberKey(event); ' onkeyup='TampilUang('TampilfmJMLHARGA2',this.value);'				
				title = 'Cari Barang dengan luas tanah kurang dari atau sama dengan (ex: 1000000)'
				
				>".
			"</div>";	
		$vluas_lantai =
			"<div  style='float:left;height:22;padding: 4 4 0 0'> Luas Lantai (m2) </div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				"<input type='text' name='luas_lantai1' id='luas_lantai1' value='' onkeydown='oldValue=this.value;' onkeypress='return isNumberKey(event); ' onkeyup='TampilUang('TampilfmJMLHARGA2',this.value);'				
				title = 'Cari Barang dengan luas lantai lebih dari atau sama dengan (ex: 1000000)'
				
				>".
			"</div>" .	
			"<div  style='float:left;height:22;padding: 4 4 0 0'> s/d </div>".			
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".						
				"<input type='text' name='luas_lantai2' id='luas_lantai2' value='' onkeydown='oldValue=this.value;' onkeypress='return isNumberKey(event); ' onkeyup='TampilUang('TampilfmJMLHARGA2',this.value);'				
				title = 'Cari Barang dengan luas lantai kurang dari atau sama dengan (ex: 1000000)'
				
				>".
			"</div>";	
			
		$valamat_kec = 
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>Kecamatan</div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				'<input id="alamat_kec" name="alamat_kec" type="text" value="'.$alamat_kec.'" title=""> '.
			"</div>" ;
		$valamat_kel = 
			"<div  style='float:left;height:22;padding: 4 4 0 0'>Kelurahan</div>".
			"<div style='float:left;padding: 0 4 0 0;height:22;'>".
				'<input id="alamat_kel" name="alamat_kel" type="text" value="'.$alamat_kel.'" title=""> '.
			"</div>" ;
		
		$asal_usul = $_REQUEST['asal_usul'];
		if(!empty($asal_usul)) $Kondisi .= " and asal_usul = '$asal_usul' ";
		/**$vasal_usul =
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
			cmb2D_v2('asal_usul', $asal_usul, $Main->AsalUsul, '','Semua Asal Usul').
			"</div>".			
			'';
		**/
		$vasal_usul =
			"<div  style='float:left;height:22;padding: 4 4 0 0'>".
			cmb2D_v2('asal_usul', $asal_usul, $Main->AsalUsul2, '','Semua Cara Perolehan').
			"</div>".			
			'';
		
		$upd_perolehan = $_REQUEST['upd_perolehan'];
		if(!empty($upd_perolehan)) $Kondisi .= " and asal_usul = '$upd_perolehan' ";
		$vupd_perolehan =
			"<div  style='float:left;height:22;padding: 4 4 0 0'>".
			cmb2D_v2('upd_perolehan', $upd_perolehan, $Main->AsalUsul3, '','Semua Update Perolehan').
			"</div>".			
			'';
		
		$jenis_hibah = $_REQUEST['jenis_hibah'];
		if(!empty($jenis_hibah)) $Kondisi .= " and jns_hibah = '$jenis_hibah' ";
		$vjenis_hibah =
			"<div  style='float:left;height:22;padding: 4 4 0 0'>".
			//cmb2D_v2('jenis_hibah', $jenis_hibah, $Main->JenisHibah, '','Sumber Dana').
			genComboBoxQry('jenis_hibah',$jenis_hibah,
					"select nama from ref_sumber_dana",
					'nama', 'nama','Sumber Dana').
			"</div>".			
			'';
		
		$staset = $_REQUEST['staset'];
		if($staset==1){
			if(!empty($staset)) $Kondisi .= " and staset <= '9' ";
		}else{
			if(!empty($staset)) $Kondisi .= " and staset = '$staset' ";	
		}
		
		$vstaset =
			"<div  style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
			cmb2D_v2('staset', $staset, $Main->StatusAsetView, '','Semua Status Aset').
			"</div>".			
			'';
		
		$status_barang = $_REQUEST['status_barang'];
		if(!empty($status_barang)) $Kondisi .= " and status_barang = '$status_barang' ";
		$vstatus_barang =
			"<div  style='float:left;height:22;padding: 4 4 0 0'>".
			cmb2D_v2('status_barang', $status_barang, $Main->StatusBarang, '','Semua Status Barang').
			"</div>".			
			'';
		
		$noRuasJalan = $_REQUEST['noruasjalan'];
		if(!empty($noRuasJalan)) $Kondisi .= " and no_barang like '$noRuasJalan%' and f='04' ";
		$vNoRuasJalan =
			"<div style='float:left;height:22;padding: 4 4 0 0'>".
				"<input id='noruasjalan' name='noruasjalan' value='$noRuasJalan' title='No Ruas Jalan' placeholder='No Ruas Jalan'>".
			"</div>";
			
		$ruasJalan = $_REQUEST['ruasjalan'];
		if(!empty($ruasJalan)) $Kondisi .= " and ref_ruas_jalan = '$ruasJalan' and jns='1'";
		$vRuasJalan =
			"<div  style='float:left;height:22;padding: 4 4 0 0'>".
			genComboBoxQry('ruasjalan',$ruasJalan,
					"select Id,nama from ref_ruas_jalan where jns='1'",
					'Id', 'nama','--Ruas Jalan--').
			"</div>".			
			'';
			
		$daerahIrigasi = $_REQUEST['daerahIrigasi'];
		if(!empty($daerahIrigasi)) $Kondisi .= " and ref_ruas_jalan = '$daerahIrigasi' and jns='2' and f='04' ";
		$vDaerahIrigasi =
			"<div  style='float:left;height:22;padding: 4 4 0 0'>".
			genComboBoxQry('daerahIrigasi',$daerahIrigasi,
					"select Id,nama from ref_ruas_jalan where jns='2'",
					'Id', 'nama','--Daerah Irigasi--').
			"</div>".			
			'';
		
		$namaJembatan = $_REQUEST['namaJembatan'];
		if(!empty($namaJembatan)) $Kondisi .= " and nm_jembatan like '$namaJembatan%' and f='04' ";
		$vNamaJembatan =
			"<div style='float:left;height:22;padding: 4 4 0 0'>".
				"<input id='namaJembatan' name='namaJembatan' value='$namaJembatan' title='Nama Jembatan' placeholder='Nama Jembatan' style='width:250'>".
			"</div>";
		
		$noGedung = $_REQUEST['nogedung'];
		if(!empty($noGedung)) $Kondisi .= " and no_barang like '$noGedung%' and f='03' ";
		$vNoGedung =
			"<div style='float:left;height:22;padding: 4 4 0 0'>".
				"<input id='nogedung' name='nogedung' value='$noGedung' title='No Gedung' placeholder='No Gedung'>".
			"</div>";
		
		$merkbi = $_REQUEST['merkbi'];
		if(!empty($merkbi)) $Kondisi .= " and id in (select idbi from kib_b where merk like '%$merkbi%' ) ";
		$vmerkbi =
			"<div style='float:left;height:22;padding: 4 4 0 0'>".
				"<input id='merkbi' name='merkbi' value='$merkbi' title='Merk' placeholder='Merk'>".
			"</div>";
		
		$alamatbi = $_REQUEST['alamatbi'];
		if(!empty($alamatbi)) $Kondisi .= " and ( id in (select idbi from kib_a where alamat like '%$alamatbi%' ) 
											or id in (select idbi from kib_c where alamat like '%$alamatbi%' ) 
											or id in (select idbi from kib_d where alamat like '%$alamatbi%' )
											or id in (select idbi from kib_f where alamat like '%$alamatbi%') ) ";
		$valamatbi =
			"<div style='float:left;height:22;padding: 4 4 0 0'>".
				"<input id='alamatbi' name='alamatbi' value='$alamatbi' title='Alamat' placeholder='Alamat' style='width:250'>".
			"</div>";
		
		if($Main->VERSI_NAME == 'CIREBON_KAB'){
			$cariblok = $_REQUEST['blok'];
			if(!empty($cariblok)) $Kondisi .= " and blok like '$cariblok%' ";
			$vblok = 
				"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>
				<div style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
					"<input id='blok' name='blok' value='$cariblok' title='Blok' placeholder='Blok'>".
				"</div>";
				
			$caripersil = $_REQUEST['persil'];
			if(!empty($caripersil)) $Kondisi .= " and persil = '$caripersil' ";
			$vpersil =
				"<div style='float:left;margin: 0 8 0 4;border-left: 1px solid #E5E5E5;height:22'></div>
				<div style='float:left;height:22;padding: 4 4 0 0'>".
					"<input id='persil' name='persil' value='$cariblok' title='Persil' placeholder='No. Persil'>".
				"</div>";
		}
		
		$cbxTanpaOrder = cekPOST("cbxTanpaOrder");
		$vTanpaOrder = 
				"<div style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0' title='Daftar ditampilkan lebih cepat tanpa order ' >".					
					" <input $cbxTanpaOrder id='cbxTanpaOrder' type='checkbox' value='checked' name='cbxTanpaOrder' >  ".
				"</div>".
				"<div style='float:left;height:22;padding: 7 4 0 0' title='Daftar ditampilkan tanpa urutan' >".					
					" Tanpa Urutan ".
				"</div>"
				;
		
		
		$tombolTampil = "<input type=button onClick=\"Penatausaha.refreshList(true)\" value='Tampilkan'> ";
		
		
		//detail filter		
		$opsi_height=100;
		switch($SPg){						
			case 'belumsensus':{				
				$opsi_height = 130;
				$OptDetail = '';
					/*"<table width=100%><tr><td>".
						//$vthn_perolehan. $batas.					
						//$vkondisi_barang. $batas.
						//$vthn_sensus.						
						//$TampilFilterSertifikat. 
						//$batas. $vstatus_hakpakai.				
					"</td></tr></table>".
					$baris.
					"<table width=100%><tr><td>".						
						$vkode_barang. $batas.	
						$vnm_barang. $batas.	
						$vhrg_perolehan.
					"</td></tr></table>".*/
					
				break;
			}			 
			case '04':{
				$opsi_height =155;
				$OptDetail =
					"<table width=100%><tr><td>".
						$vthn_perolehan. $batas.					
						$vkondisi_barang.
						$TampilFilterSertifikat. 
						$batas. $vstatus_hakpakai.	$batas.$vgambar.
						$vbast.$batas.$vspk.$batas.$vpenggunaanbi.
						$vprogram.$vkegiatan.
						$vstatus_survey.
						//$batas.$vidawal.
					"</td></tr></table>".
					$baris.
					"<table width=100%><tr><td>".
						$vkode_barang. $batas.	
						$vnm_barang. $batas.	
						$vhrg_perolehan. $batas. 
						$vnosertifikat. $batas.
						$vluas.
						// $valamat_kec. $batas. $valamat_kel.
					"</td></tr></table>".
					$baris. 
					"<table width=100%><tr><td>".						 
						$valamat. $batas.
						$vkota.	//$batas.
						$vblok.
						$vpersil.
						$batas. $vstatus_barang.
						$batas. $vTanpaOrder.
					"</td></tr></table>".
					'';
					/*$baris. 
					"<table width=100%><tr><td>".						 
						$vnosertifikat. $batas.
						$vluas.
					"</td></tr></table>";*/
				break;
			}
			case '05':{
				$opsi_height =190;
				$OptDetail =
					"<table width=100%><tr><td>".
						$vthn_perolehan. $batas.					
						$vkondisi_barang.
						$TampilFilterSertifikat.$batas.$vgambar.	
						$vbast.$batas.$vspk.$batas.$vpenggunaanbi.	
						$vprogram.$vkegiatan.
						$vstatus_survey.
						//$batas.$vidawal.	
					"</td></tr></table>".
					$baris.
					"<table width=100%><tr><td>".
						$vkode_barang. $batas.	
						$vnm_barang. $batas.	
						$vhrg_perolehan.
					"</td></tr></table>".					
					$baris. 
					"<table width=100%><tr><td>".
						$vmerk.	$batas.
						$vbahan. $batas.
						$vnopabrik.	$batas.
						$vnorangka.
					"</td></tr></table>".	
					$baris.
					"<table width=100%><tr><td>".
						$vnomesin. $batas.
						$vnopolisi.	$batas.
						$vnobpkb.$batas. $vstatus_barang.
						$batas. $vTanpaOrder.
					"</td></tr></table>";
				break;
			}			
			case '06':{ //c
				$opsi_height =190;
				$OptDetail =
					"<table width=100%><tr><td>".
						$vthn_perolehan. $batas.					
						$vkondisi_barang.
						$TampilFilterSertifikat.				
						$batas. $vkonst_bertingkat.	
						$batas. $vkonst_beton. 						
						$batas. $vstatus_tanah.	$batas.$vgambar. 
						$vbast.$batas.$vspk.$batas.$vpenggunaanbi.	
						$vprogram.$vkegiatan.
						$vstatus_survey.
						//$batas.$vidawal.
					"</td></tr></table>".
					$baris.
					"<table width=100%><tr><td>".
						$vkode_barang. $batas.	
						$vnm_barang. $batas.	
						$vhrg_perolehan. 
					"</td></tr></table>".					
					$baris. 
					"<table width=100%><tr><td>".
						$valamat. $batas.
						$vkota. $batas.	
					"</td></tr></table>".
					$baris. 
					"<table width=100%><tr><td>".
						$vluas. $batas.
						$vluas_lantai.$batas.					
						$vnodokumen. $batas.
						$vkode_tanah. $batas.
						$vNoGedung.$batas. $vstatus_barang.						
					"</td></tr></table>".
					$baris.
					"<table width=100%><tr><td>".
						
						 $vTanpaOrder.
					"</td></tr></table>";					
				break;
			}
			case '07':{
				$opsi_height =190;
				$OptDetail =
					"<table width=100%><tr><td>".
						$vthn_perolehan. $batas.					
						$vkondisi_barang.
						$TampilFilterSertifikat.				
						$batas.	$vstatus_tanah.
						$batas.	$vkode_tanah.$batas.$vgambar.
						$vbast.$batas.$vspk.$batas.$vpenggunaanbi.	
						$vprogram.$vkegiatan.
						 $vstatus_survey.
						 //$batas.$vidawal.
					"</td></tr></table>".
					$baris.
					"<table width=100%><tr><td>".
						$vkode_barang. $batas.	
						$vnm_barang. $batas.	
						$vhrg_perolehan.  
					"</td></tr></table>".					
					$baris. 
					"<table width=100%><tr><td>".
						$valamat.
						$batas.	$vkota.
					"</td></tr></table>".
					$baris. 
					"<table width=100%><tr><td>".
						$vkonstruksi.
						$batas. $vnodokumen. $batas.
						$vNoRuasJalan.$batas.
						$vRuasJalan.$batas.
						$vDaerahIrigasi.$batas.
						$vNamaJembatan.
						$batas. $vstatus_barang.
						$batas. $vTanpaOrder.
					"</td></tr></table>";
					
				break;
			}
			case '08':{
				$opsi_height =190;
				$OptDetail =
					"<table width=100%><tr><td>".
						$vthn_perolehan. $batas.					
						$vkondisi_barang.
						$TampilFilterSertifikat.$batas.$vgambar.
						 $vbast.$batas.$vspk.$batas.$vpenggunaanbi.	
						$vprogram.$vkegiatan.
						 $vstatus_survey.
						 //$batas.$vidawal.			
					"</td></tr></table>".
					$baris.
					"<table width=100%><tr><td>".
						$vkode_barang. $batas.	
						$vnm_barang. $batas.	
						$vhrg_perolehan. 
					"</td></tr></table>".
					$baris.
					"<table width=100%><tr><td>".
						$vjudul. $batas.					
						$vspesifikasi. $batas.
						$vhewan_jenis. $batas.
						$vhewan_ukuran. 
					"</td></tr></table>".
					$baris.
					"<table width=100%><tr><td>".
						$vseni_asal_daerah. $batas.
						$vseni_pencipta. $batas.
						$vseni_bahan. $batas. $vstatus_barang.	
						$batas. $vTanpaOrder.				
					"</td></tr></table>";
				break;
			}
			case '09':{
				$opsi_height =190;
				$OptDetail =
					"<table width=100%><tr><td>".
						$vthn_perolehan. $batas.					
						$vkondisi_barang.
						$TampilFilterSertifikat.
						$batas. $vbangunan.	
						$batas. $vkonst_bertingkat.	
						$batas. $vkonst_beton. 						
						$batas. $vstatus_tanah.$batas.$vgambar.
						$vbast.$batas.$vspk.$batas.$vpenggunaanbi.	
						$vprogram.$vkegiatan.
						$vstatus_survey.
						//$batas.$vidawal.		
					"</td></tr></table>".
					$baris.
					"<table width=100%><tr><td>".
						$vkode_barang. $batas.	
						$vnm_barang. $batas.	
						$vhrg_perolehan.  $batas. $valamat_kec. $batas. $valamat_kel.
					"</td></tr></table>".
					$baris. 
					"<table width=100%><tr><td>".
						$valamat. $batas.
						$vkota. $batas.	
					"</td></tr></table>".
					$baris. 
					"<table width=100%><tr><td>".
						$vnodokumen. $batas.
						$vkode_tanah.					
						$batas. $vstatus_barang.
						$batas. $vTanpaOrder.
					"</td></tr></table>";					;
				break;
			}
			case 'kibg':{
				$opsi_height =130;
				$OptDetail =
					"<table width=100%><tr><td>".
						$vthn_perolehan. $batas.					
						$vkondisi_barang.
						$TampilFilterSertifikat.$batas.$vgambar.
						$vbast.$batas.$vspk.$batas.$vpenggunaanbi.	
						$vprogram.$vkegiatan.
						$vstatus_survey.
						//$batas.$vidawal.
					"</td></tr></table>".
					$baris.
					"<table width=100%><tr><td>".
						$vkode_barang. $batas.	
						$vnm_barang. $batas.	
						$vhrg_perolehan.
					"</td></tr></table>".					
					$baris. 
					"<table width=100%><tr><td>".
						$vuraian_kibg.	
						$batas. $vstatus_barang.
						$batas. $vTanpaOrder.
					"</td></tr></table>"	
					;
				break;
			}			
			default:{//03
				$opsi_height = 130;
				$OptDetail =
					"<table width=100%><tr><td>".
						$vthn_perolehan. $batas.					
						$vkondisi_barang. $batas.
						$vthn_sensus.$batas.$vtahun_susut.$vcek_susut.
						$TampilFilterSertifikat. $vgambar.
						$vjnsEkstra.$vjnsLain.
						$vbast.$batas.$vspk.$batas.$vpenggunaanbi.	
						$vprogram.$vkegiatan.
						$vstatus_survey.
						//$batas.$vidawal.
						//$batas. $vstatus_hakpakai.				
					"</td></tr></table>".
					$baris.
					"<table width=100%><tr><td>".
						$vkode_barang. $batas.	
						$vnm_barang. $batas.	
						$vhrg_perolehan. $batas.
						$valamatbi. $batas.
						$vmerkbi.
						$batas. $vstatus_barang.
						
					"</td></tr></table>".
					$baris.
					"<table width=100%><tr><td>".
						
						 $vTanpaOrder.
					"</td></tr></table>";
				break;
			}
		}	
		
		//--- KIR -----------------------------------------------------------
		//if($SPg == 'KIR'){
			$cek = '';
			$fmPILGEDUNG = $_REQUEST['fmPILGEDUNG'];
			$fmPILRUANG = $_REQUEST['fmPILRUANG'];
			if (empty($fmURUSAN)) {
		        if (isset($HTTP_COOKIE_VARS['cofmURUSAN'])) { $fmURUSAN = $HTTP_COOKIE_VARS['cofmURUSAN']; }
		    }
			if (empty($fmSKPD)) {
		        if (isset($HTTP_COOKIE_VARS['cofmSKPD'])) { $fmSKPD = $HTTP_COOKIE_VARS['cofmSKPD']; }
		    }		   
		    if (empty($fmUNIT)) {
		        if (isset($HTTP_COOKIE_VARS['cofmUNIT'])) { $fmUNIT = $HTTP_COOKIE_VARS['cofmUNIT']; }
		    }
		    if (empty($fmSUBUNIT)) {
		        if (isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])) { $fmSUBUNIT = $HTTP_COOKIE_VARS['cofmSUBUNIT']; }
		    }		   	    
		    if (empty($fmSEKSI)) {
		        if (isset($HTTP_COOKIE_VARS['cofmSEKSI'])) { $fmSEKSI = $HTTP_COOKIE_VARS['cofmSEKSI']; }
		    }		   	    
			$c1= $fmURUSAN; $c= $fmSKPD; $d= $fmUNIT; $e= $fmSUBUNIT;$e1= $fmSEKSI;
			
			//-- kondisi gedung
			$arrkondgdg = array();			
			if(!($c1=='' || $c1 =='00'|| $c1 =='0')) $arrkondgdg[] = " c1 = '$c1' ";
			if(!($c=='' || $c =='00')) $arrkondgdg[] = " c = '$c' ";
			if(!($d=='' || $d =='00')) $arrkondgdg[] = " d = '$d' ";
			if(!($e=='' || $e =='00')) $arrkondgdg[] = " e = '$e' ";						
			if(!($e1=='' || $e1 =='00' || $e1 =='000')) $arrkondgdg[] = " e1 = '$e1' ";						
			$arrkondgdg[] =  "q='0000'";
			$Kondisigdg = join(' and ',$arrkondgdg);
			if($Kondisigdg != '') $Kondisigdg = ' where '.$Kondisigdg;
			
			//-- kondisi ruang
			if(!($fmPILGEDUNG=='' )) {
				$arrkondgdg = array();
				//$arrkondgdg[] =  "q<>'0000'";	
				$arrkondgdg = explode(' ',$fmPILGEDUNG);	
				$c1 = $arrkondgdg[0]; $c = $arrkondgdg[1]; $d = $arrkondgdg[2]; 
				$e = $arrkondgdg[3]; $e1 = $arrkondgdg[4];$p = $arrkondgdg[5];
				
				$arrkondgdg = array();
				if(!($c1=='' || $c1 =='00')) $arrkondgdg[] = " c1 = '$c1' ";
				if(!($c=='' || $c =='00')) $arrkondgdg[] = " c = '$c' ";
				if(!($d=='' || $d =='00')) $arrkondgdg[] = " d = '$d' ";
				if(!($e=='' || $e =='00')) $arrkondgdg[] = " e = '$e' ";
				if(!($e1=='' || $e1 =='00' || $e1 =='000')) $arrkondgdg[] = " e1 = '$e1' ";
			
				$arrkondgdg[] = " p = '$p' ";
				$KondisiRuang = join(' and ',$arrkondgdg);
				if($KondisiRuang != '') $KondisiRuang = ' where '.$KondisiRuang;
			}else{
				$KondisiRuang = ' where 1= 0 ';
			}
			
			
			//-- kondisi KIR
			if(!($fmPILGEDUNG=='' )) {
				
				$arrkondgdg = array();							
				if(!($fmPILRUANG=='' )) {
					$arrkondgdg = explode(' ',$fmPILRUANG);	
					$c1 = $arrkondgdg[0]; $c = $arrkondgdg[1]; $d = $arrkondgdg[2]; 
					$e = $arrkondgdg[3]; $e1 = $arrkondgdg[4]; $p = $arrkondgdg[5];
					$q = $arrkondgdg[6];
					$arrkondgdg = array();
					$arrkondgdg[] =  "q<>'0000'";
					$arrkondgdg[] = " c1 = '$c1' ";
					$arrkondgdg[] = " c = '$c' ";
					$arrkondgdg[] = " d = '$d' ";
					$arrkondgdg[] = " e = '$e' ";
					$arrkondgdg[] = " e1 = '$e1' ";
					$arrkondgdg[] = " p = '$p' ";	
					$arrkondgdg[] = " q = '$q' ";	
				}else{
					$arrkondgdg = array();
					$arrkondgdg[] =  "q<>'0000'";
					$arrkondgdg[] = " c1 = '$c1' ";
					$arrkondgdg[] = " c = '$c' ";
					$arrkondgdg[] = " d = '$d' ";
					$arrkondgdg[] = " e = '$e' ";
					$arrkondgdg[] = " e1 = '$e1' ";
					$arrkondgdg[] = " p = '$p' ";	
				}
				$KondisiRuang = join(' and ',$arrkondgdg);
				if($KondisiRuang != '') $KondisiRuang = ' where '.$KondisiRuang;
				
				$arruang = array();
				$aqry = "select * from ref_ruang $KondisiRuang"; $cek .= $aqry;
				$qry = mysql_query($aqry);
				while($isi=mysql_fetch_array($qry)){
					$arruang[] = $isi['id'];
				}
				$kondkir = join(',',$arruang);
				
				if($kondkir != '') {
					$kondkir = ' ref_idruang in('.$kondkir.')';	
				}else{ //tidak ada data
					$kondkir = ' 1=0 ';				
				}
				$Kondisi = $Kondisi == '' ? ' where '.$kondkir : $Kondisi. ' and '. $kondkir;
			}
			
			if($SPg == 'KIR'){
				//-- tampil filter KIR
				$OptKIR = //'tes' ;	
					genFilterBarfn(
						array( 						
							' Gedung &nbsp; '.						
							"<span id='cbxGedung'>".
							genComboBoxQry2( 'fmPILGEDUNG', $fmPILGEDUNG, 
								//"select * from ref_ruang $Kondisigdg order by c1,c,d,e,e1,p,q ",
								"select id,a1,a,b,c1,c,d,e,e1,p,q, concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',p, ' ',nm_ruang) as  nm_ruang,
								ref_idpegawai,nm_pendek,nm_penanggung_jawab,nip_penanggung_jawab from ref_ruang $Kondisigdg order by c1,c,d,e,e1,p,q ",
								array('c1','c','d','e','e1','p'), 'nm_ruang', '-- Semua Gedung --',"style='width:140' onChange=\"Penatausaha.pilihGedungOnchange()\"" ).
							"</span>".//.$Kondisigdg.
							'&nbsp;&nbsp;Ruang &nbsp;'.
							"<span id='cbxRuang'>".
							genComboBoxQry( 'fmPILRUANG', $fmPILRUANG, 
								"select * from ref_ruang  $KondisiRuang  order by c1,c,d,e,e1,p,q",
								array('c1','c','d','e','e1','p','q'), 'nm_ruang', '-- Semua Ruang --',"style='' onChange=\"Penatausaha.refreshList(true);Penatausaha.tampilPJRuang();\" "  ).
							"</span>"//.$aqry//.$KondisiRuang
							."&nbsp;&nbsp;<b>Penanggung Jawab Ruangan: </b><span id='pjruang' name='pjruang'></span>"
						)				
						,'',FALSE, ''
					);
			}
			
		//}
		
		
		//--- KIP
		if($SPg == 'KIP'){
			$arrJnsPegawai = array(				
				array('1','Penanggung Jawab Barang'),	
				array('2','Pengurus Barang'),		
				array('3','Pengguna/Kuasa Pengguna Barang')
			);
			$arrNIPNama = array(				
				array('1','NIP'),	
				array('2','Nama')
			);
			$KondKIP = '';
			
			//kondisi kip --------------------------------------------------			
			$fmPILNIPNAMA = $_REQUEST['fmPILNIPNAMA'];
			$fmPILJNSPEGAWAI = $_REQUEST['fmPILJNSPEGAWAI'];
			$fmEntryNIPNAMA = $_REQUEST['fmEntryNIPNAMA'];
			if($fmEntryNIPNAMA !='' && $fmPILNIPNAMA != ''){
				switch($fmPILNIPNAMA){
					case '1': 
						switch($fmPILJNSPEGAWAI){
							case '1': $Kond = " nip_pemegang like '%$fmEntryNIPNAMA%' "; break;
							case '2': $Kond = " nip_pengurus like '%$fmEntryNIPNAMA%' "; break;
							case '3': $Kond = " nip_pengguna like '%$fmEntryNIPNAMA%' "; break;
							default : $Kond = " (nip_pemegang like '%$fmEntryNIPNAMA%' or nip_pengurus like '%$fmEntryNIPNAMA%' or nip_pengguna like '%$fmEntryNIPNAMA%' )"; 
						}
						//$aqry = "select * from v1_buku_induk_pegawai left join ref_pegawai  where nip ='$fmEntryNIPNAMA'";
						$aqry = "select * from v1_buku_induk_pegawai where $Kond";	
					break;
					case 2:
						switch($fmPILJNSPEGAWAI){
							case '1': $Kond = " nm_pemegang like '%$fmEntryNIPNAMA%' "; break;
							case '2': $Kond = " nm_pengurus like '%$fmEntryNIPNAMA%' "; break;
							case '3': $Kond = " nm_pengguna like '%$fmEntryNIPNAMA%' "; break;
							default : $Kond = " (nm_pemegang like '%$fmEntryNIPNAMA%' or nm_pengurus like '%$fmEntryNIPNAMA%' or nm_pengguna like '%$fmEntryNIPNAMA%' )"; 
						}
						$aqry = "select * from v1_buku_induk_pegawai where $Kond";												
					break;
					
				}
				$cek .= ' qry kir='.$aqry;
				$pgw=mysql_query($aqry);
				$arrkondKIP = array();
				while($isipgw = mysql_fetch_array($pgw) ){
					$arrkondKIP[] = $isipgw['id'];
				}
				$kondKIP = join(',',$arrkondKIP);
				if($kondKIP != '') {
					$kondKIP = ' id in('.$kondKIP.')';
				}else{ //tidak ada data
					$kondKIP = ' 1=0 ';
				}
				$Kondisi = $Kondisi == '' ? ' where '.$kondKIP : $Kondisi. ' and '. $kondKIP;
				
			}
			
				
			//tampil kip --------------------------------------------------------			
			$OptKIP = //'tes' ;	
				genFilterBarfn(
					array( 						
						' Jenis Pegawai &nbsp; '.						
						"<span id='cbxJnsPegawai'>".						
							cmb2D_v2('fmPILJNSPEGAWAI',$fmPILJNSPEGAWAI,$arrJnsPegawai,'','-- Semua --','').
						"</span>".
						'&nbsp;&nbsp;Cari &nbsp;'.
						"<span id='cbxPilNipNama'>".
							cmb2D_v2('fmPILNIPNAMA',$fmPILNIPNAMA,$arrNIPNama,'', '-- Pilih --','').
							"&nbsp;&nbsp;<input type='text' id='fmEntryNIPNAMA' name='fmEntryNIPNAMA' value='' style='width:300'>".
							
						"</span>".
						"<input type='button' onclick='Sensus.pilihPemegang()' value='Pilih' title='Pilih Pegawai'>"
						//"<input type='button' onclick=\"document.getElementById('fmEntryNIPNAMA').value='';\" value='Clear' title='Reset Pegawai'>"
					)				
					,'',FALSE, ''
				);
				
			
		}
				
		//--- FILTER 
		if($SPg == 'belumsensus'){
			$vthn_buku2 = 
				"<div style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
					genComboBoxQry('fmFiltThnBuku',$fmFiltThnBuku,
						"select year(tgl_buku)as thnbuku from $tblname group by thnbuku desc",
						'thnbuku', 'thnbuku','Tahun Buku'). 
				"</div>";
			$vthn_perolehan2 =
				"<div style='float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0'>".
					genComboBoxQry('fmTahunPerolehan3',$fmTahunPerolehan3,
						"select thn_perolehan from $tblname group by thn_perolehan order by thn_perolehan desc",
						'thn_perolehan', 'thn_perolehan','Tahun Perolehan'). 
				"</div>" ;
			$TampilOpt =
				"<input type='hidden' id='tahun_sensus' name='tahun_sensus' value='belum_sensus'>".
				"<table width=\"100%\" height=\"100%\" class=\"adminform\" style='margin: 4 0 0 0;'>
				<tr valign=\"top\">   		
				<td> ".
				
				
					"<table width=100%><tr><td>".
						//"<div style='float:left;padding: 2 8 0 0;height:20;padding: 4 4 0 0'> Tampilkan : </div>".					
						//$vtgl_buku.
						$vkode_barang.	
						$vnodata.
						$vthn_buku2.
						$vthn_perolehan2.
						$vstaset.
						$BarisPerHalaman.
						
						
						
						//'</div>'.
					"</td></tr></table>".
					
					
				"</td>
				</tr>
				</table>".
				"<table width=\"100%\" height=\"100%\" class=\"adminform\" style='margin: 4 0 0 0;'>
				<tr valign=\"top\"><td> ".
					'<div style="float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0">'.
							' Gedung &nbsp; '.						
							"<span id='cbxGedung'>".
							genComboBoxQry2( 'fmPILGEDUNG', $fmPILGEDUNG, 
								"select id,a1,a,b,c1,c,d,e,e1,p,q, concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',p, ' ',nm_ruang) as  nm_ruang,
								ref_idpegawai,nm_pendek,nm_penanggung_jawab,nip_penanggung_jawab from ref_ruang $Kondisigdg order by c1,c,d,e,e1,p,q ", //$Kondisigdg= lihat di bagian KIR diatas
								array('c1','c','d','e','e1','p'), 'nm_ruang', '-- Semua Gedung --',"style='' onChange=\"Penatausaha.pilihGedungOnchange()\"" ).
							"</span>".//.$Kondisigdg.
							'&nbsp;&nbsp;Ruang &nbsp;'.
							"<span id='cbxRuang'>".
							genComboBoxQry( 'fmPILRUANG', $fmPILRUANG, 
								"select * from ref_ruang  $KondisiRuang  order by c1,c,d,e,e1,p,q",
								array('c1','c','d','e','e1','p','q'), 'nm_ruang', '-- Semua Ruang --',"style='' onChange=\"Penatausaha.refreshList(true);Penatausaha.tampilPJRuang();\" "  ).
							"</span>"//.$aqry//.$KondisiRuang
							."&nbsp;&nbsp;<b>Penanggung Jawab Ruangan: </b><span id='pjruang' name='pjruang'></span>".
						"</div>".
						'<div style="float:left;padding: 0 4 0 0;height:22;padding: 4 4 0 0">'.
						$tombolTampil.
				"</td></tr></table>".
				"";
		}else{
		//$vasal_usul.$vstaset.
			$TampilOpt =
				$OptKIR.
				$OptKIP.
				$OptCari.			
				"<table width=\"100%\" height=\"100%\" class=\"adminform\" style='margin: 4 0 0 0;'>
				<tr valign=\"top\">   		
				<td> ".
				"<div id='' style='float:right; padding: 2 0 0 0' >
					<img id='daftaropsi_slide_img' src='images/tumbs/down_2.png' onclick=\"daftaropsi_click($opsi_height)\" style='cursor:pointer'>
				</div>".
				"<div id='daftaropsi_div' style='height:64;overflow-y:hidden;'>".				
					"<table width=100%><tr><td>".
						"<div style='float:left;padding: 2 8 0 0;height:20;padding: 4 4 0 0'> Tampilkan : </div>".					
						$vtgl_buku.$batas.
						$vthn_buku.$batas.$vasal_usul.$batas.$vupd_perolehan.$batas.$vstaset.$batas.$vjenis_hibah.$batas.$vthn_susut.$batas.$vnodata.$batas.$vidawal.
					"</td></tr></table>".
					$baris.				
					$OptDetail.
				"</div>".					
					
				"</td>
				</tr>
				</table>".
				"<table width=\"100%\" height=\"100%\" class=\"adminform\" style='margin: 4 0 0 0;'>
				<tr valign=\"top\"><td> ".
					"<div style='float:left'>".
					//$FilterStatus . "&nbsp;&nbsp" .
					$TampilOrder . "&nbsp;&nbsp;" .			
					$dalamRibuan . "&nbsp;&nbsp;" .
					$cekProgram . "&nbsp;&nbsp;" .
					$cekBAST . "&nbsp;&nbsp;" .
					$BarisPerHalaman . "&nbsp;&nbsp;" .$tombolTampil.
					"</div>".
				"</td></tr></table>"
				;//*/	
			}
		
		
		//limit --------------
		/*$limitdata = $_REQUEST['limitdata'];
		$limitstart = $_REQUEST['limitstart'];
		$limitbanyak = $_REQUEST['limitbanyak'];
		if ($limitdata==1){
			$LimitHal = " limit ".$limitstart.", ".$limitbanyak;
		}else{*/
			$HalDefault = isset($_REQUEST['HalDefault'])? $_REQUEST['HalDefault'] : 1 ; //cekPOST("HalDefault", 1); //echo "HalDefault=$HalDefault";
			$LimitHal = " limit " . (($HalDefault * 1) - 1) * $Main->PagePerHal . "," . $Main->PagePerHal;	
		//}
		
		
		//$cek ='';		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Urutkan, 'Limit'=>$LimitHal, 'NoAwal'=>$NoAwal, 
		'TampilOpt'=>$TampilOpt, 'OptWil'=>$OptWil, 'TampilOrder'=>'tbl='.$tblname.$TampilOrder, 'cek'=>$cek  );
	}
	function getTableName($spg){
		
		//get table ---------------------------
		switch($spg){
			case "KIP" :{ $tblNameList = 'view_buku_induk2'; break; }
			case "KIR" :{ $tblNameList = 'view_buku_induk2'; break; }
			case "belumsensus" :{ $tblNameList = 'view_buku_induk2'; break; }
			case "03" : case "listbi_cetak" :{ $tblNameList = 'view_buku_induk2'; break; }
			case "04" : case "kib_a_cetak" :{ $tblNameList = 'view_kib_a2';	break; }
			case "05" : case "kib_b_cetak" :{ $tblNameList = 'view_kib_b2';	break; }
			case "06" : case "kib_c_cetak" :{ $tblNameList = 'view_kib_c2';	break; }
			case "07" : case "kib_d_cetak": { $tblNameList = 'view_kib_d2';	break; }
			case "08" : case "kib_e_cetak": { $tblNameList = 'view_kib_e2';	break; }
			case "09" : case "kib_f_cetak": { $tblNameList = 'view_kib_f2'; break; }
			case "kibg" : case "kib_g_cetak": { $tblNameList = 'view_kib_g'; break; }


			default : $tblNameList = 'view_buku_induk2'; break;
		}	
		return $tblNameList;
	}
		
	function genList($Kondisi='', $Urutkan='',$LimitHal, $cetak = FALSE, $AllData=0,$SPg_='', $tipe=''){
		/*******************************
		* fungsi : untuk gen row buku_induk, kib_a ... f
		* Proses :
		* digunakan pada:
		* - listbi_cetak.php
		* - listbi_cetak_xls.php
		* - listbi.php
		****************************/
		global $Main ; 
		//$tipebi = $_REQUEST['tipebi'];
		$cek ='';
		$jns=$_REQUEST['jns'];
		
		$MaxFlush = 10;
		
		$cbxDlmRibu = $_POST['cbxDlmRibu'];
		$txls = $_REQUEST['xls']=="1"?"1":"";
		$SPg = $SPg_ ==''? $_GET['SPg'] : $SPg_; $cek .= "SPg = $SPg";
		$fmThnLaporan = $_POST['fmThnSusut'];
		//get table ---------------------------		
		//$tblNameList = $this->getTableName($SPg);		
		switch($SPg){
			case "belumsensus" :{ $tblNameList = 'view_buku_induk2'; 
				if($_REQUEST['fmCariComboField' ] <> 'nm_barang' || $_REQUEST['nama_barang']<>'')  $tblNameList = 'buku_induk';
				break; }
			case "03" : case "listbi_cetak" :{ $tblNameList = 'view_buku_induk2'; 
				if($_REQUEST['fmCariComboField' ] <> 'nm_barang' || $_REQUEST['nama_barang']<>'')  $tblNameList = 'buku_induk';
				break; }
			case "04" : case "kib_a_cetak" :{ $tblNameList = 'view_kib_a';	break; }
			case "05" : case "kib_b_cetak" :{ $tblNameList = 'view_kib_b2';	break; }
			case "06" : case "kib_c_cetak" :{ $tblNameList = 'view_kib_c';	break; }
			case "07" : case "kib_d_cetak": { $tblNameList = 'view_kib_d2';	break; }
			case "08" 	: case "kib_e_cetak": { $tblNameList = 'view_kib_e2';	break; }
			case "09" 	: case "kib_f_cetak": { $tblNameList = 'view_kib_f2'; break; }
			case "kibg" : case "kib_g_cetak": { $tblNameList = 'view_kib_g'; break; }
			case "03b" 	: case "listbi_cetak" :{ $tblNameList = 'view_buku_induk2'; 
				if($_REQUEST['fmCariComboField' ] <> 'nm_barang' || $_REQUEST['nama_barang']<>'')  $tblNameList = 'buku_induk';
				break; }

			default : $tblNameList = 'view_buku_induk2'; 
				if($_REQUEST['fmCariComboField' ] <> 'nm_barang' || $_REQUEST['nama_barang']<>'')  $tblNameList = 'buku_induk';
				break;
		}

	
		// $Kondisi .= $KondisiInEx;
		//noawal ----------------------------------
		$limitdata = $_REQUEST['limitdata'];
		$limitstart = $_REQUEST['limitstart']>0 ? $_REQUEST['limitstart']-1 : 0;
		$limitend = $_REQUEST['limitend']>0? $_REQUEST['limitend']: 1;
		if ($limitdata==1){
			$limitbanyak =  $limitend - $limitstart;
			$LimitHal = " limit ".$limitstart.", ".$limitbanyak;
			$no = $limitstart;
		}else{
			$HalDefault = cekPOST('HalDefault',1);
			if ($AllData ==1){
				$no = 0;
				$LimitHal = '';
			}else{
				$no=  $Main->PagePerHal * (($HalDefault*1) - 1);	
			}	
		}
		
		//--- listdata -----------------------------	
		//$Urutkan2 = $SPg=='07' ? ",jns,ref_ruas_jalan,nm_jembatan" : "";
		$Kondisi = $Kondisi==''? '' : " where $Kondisi ";
		$clGaris = $cetak? "GarisCetak": "GarisDaftar";	
		//$sqry= "select * from $tblNameList $Kondisi  order by $Urutkan a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg ";
		$tanpaOrder = cekPOST("cbxTanpaOrder");
		$Urutkan = $tanpaOrder ? '' : "  order by $Urutkan thn_perolehan desc, a1,a,b,c,d,e,e1,f,g,h,i,j,noreg" ;
		$sqry= "select * from $tblNameList $Kondisi  $Urutkan  "; 
		$sqrysum= "select count(*) as jml,sum(jml_barang) as jml_barang,sum(jml_harga) as jml_harga from $tblNameList $Kondisi "; 

		 //echo $sqry;
		
		$Qry = mysql_query($sqry ." $LimitHal");
		$cek .= "<br>sqry= $sqry $LimitHal";
		//echo "<br>sqry= $sqry $LimitHal";
		
		$cb=0; $jmlTotalHargaDisplay = 0; $totLuasTanahHal = 0;
		$ListData = "";
		$no_spk = '';
		while($isi=mysql_fetch_array($Qry)){ //20 detik
			$isi = array_map('utf8_encode', $isi);	
						
			if($isi['nm_barang'] == ''){
				$NmBrg = mysql_fetch_array(mysql_query("select nm_barang from ref_barang where f='".$isi['f']."' and g='".$isi['g']."' and h='".$isi['h']."' and i='".$isi['i']."' and j='".$isi['j']."'"));
				$isi['nm_barang'] =$NmBrg['nm_barang'];
				$nmbarang= $isi['nm_barang'];
			}
			if($Main->KD_BARANG_P108){
				$isi['id_barang']= $isi['f1'].'.'.$isi['f2'].'.'.$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'];
			}else{
				$isi['id_barang']= $isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'];
			}
			$jnshibah = $isi['jns_hibah'] == '0' ? '' : $isi['jns_hibah'];
			//tampil pilihan			
			/*if($this->tampilCbxKeranjang && $tipebi==''){
				$id = $SPg=='03'   ?  $isi['id'] : $isi['idbi'];
				$tampilCbxKeranjang =  $cetak ? "" : 
					"<td class=\"$clGaris\" align=center>
						<div id='cbk".($cb+1)."' value='".$id."'></div>
					</td>";	
			}
			*/	
			//**	
				
			if($cetak && $Main->SETTING['CETAK_TIDAK_TAMPIL_SKPD']==1) $Main->TAMPIL_BIDANG = FALSE;
			if($Main->TAMPIL_BIDANG ){				
				$nmopdarr=array();	
				$isi['vBidang']='';	
				$konc1 = "";
				if($Main->URUSAN==1){
					$konc1 = " c1='".$isi['c1']."' and ";
					$fmURUSAN = $_REQUEST['fmURUSAN'];
					if($fmURUSAN==''||$fmURUSAN=='0'){
						$get = mysql_fetch_array(mysql_query(
							"select * from ref_skpd where c1='".$isi['c1']."' and c='00' "
						));		
						if($get['nm_skpd']<>'') $nmopdarr[] = $get['c1'].'. '. $get['nm_skpd'];
					}
				}
				$fmSKPD = $_REQUEST['fmSKPD'];
				if($fmSKPD==''||$fmSKPD=='00'){
					$aqry = "select * from v_bidang where $konc1 c='".$isi['c']."' ";// die($aqry);
					$get = mysql_fetch_array(mysql_query(
						$aqry
					));		
					
					if($get['nmbidang']<>'') $nmopdarr[] = $get['c'].'. '. $get['nmbidang'];
				}
				$fmUNIT = $_REQUEST['fmUNIT'];
				if($fmUNIT==''||$fmUNIT=='00'){
					$get = mysql_fetch_array(mysql_query(
						"select * from v_opd where $konc1 c='".$isi['c']."' and d='".$isi['d']."' "
					));		
					if($get['nmopd']<>'') $nmopdarr[] =  $get['d'].'. '. $get['nmopd'];
				}	
				$fmSUBUNIT = $_REQUEST['fmSUBUNIT'];
				if($fmSUBUNIT==''||$fmSUBUNIT=='00'){			
					$get = mysql_fetch_array(mysql_query(
						"select * from v_unit where $konc1 c='".$isi['c']."' and d='".$isi['d']."' and e='".$isi['e']."'"
					));		
					if($get['nmunit']<>'') $nmopdarr[] =  $get['e'].'. '. $get['nmunit'];
				}
				
				$fmSEKSI = $_REQUEST['fmSEKSI'];
				if($fmSEKSI==''||$fmSEKSI=='000'){		
					$get = mysql_fetch_array(mysql_query(
						"select * from ref_skpd where $konc1 c='".$isi['c']."' and d='".$isi['d']."' and e='".$isi['e']."' and e1='".$isi['e1']."'"
					));		
					if($get['nm_skpd']<>'') $nmopdarr[] =  $get['e1'].'. '. $get['nm_skpd'];
				}
				
				//$isi['vBidang'] = "<td class=\"$clGaris\">".join(' / ', $nmopdarr )."</td>";
				//$isi['vBidang'] = "<td class=\"$clGaris\">".join(' - ', $nmopdarr )."</td>";
				$isi['vBidang'] = join(' - ', $nmopdarr );
				if($isi['vBidang']<>'') $isi['vBidang'] = 'SKPD: '.$isi['vBidang'];				
			}
			//**/
			//get info dinas
			$get = mysql_fetch_array(mysql_query(
				"select * from ref_skpd where c='".$isi['c']."'  and d='00' and e='00'"
			));		
			if($get['nm_barcode']<>'') $nm = $get['nm_barcode'];			
			$infobrg = "  bidang='$nm' thn_perolehan='".$isi['thn_perolehan']."'";			
			//get opd
			$get = mysql_fetch_array(mysql_query(
				"select * from ref_skpd where c='".$isi['c']."'  and d='".$isi['d']."' and e='00'"
			));		
			if($get['nm_barcode']<>'') $nm = $get['nm_barcode'];
			$infobrg .= "  opd='$nm' ";
			//get biro
			$get = mysql_fetch_array(mysql_query(
				"select * from ref_skpd where c='".$isi['c']."'  and d='".$isi['d']."' and e='".$isi['e']."'"
			));		
			if($get['nm_barcode']<>'') $nm = $get['nm_barcode'];
			$infobrg .= "  biro='$nm' ";
			//get biro
			$get = mysql_fetch_array(mysql_query(
				"select * from ref_skpd where c='".$isi['c']."'  and d='".$isi['d']."' and e='".$isi['e']."' and e1='".$isi['e1']."'"
			));		
			if($get['nm_barcode']<>'') $nm = $get['nm_barcode'];
			$infobrg .= "  seksi='$nm' ";
			
			if($Main->TAMPIl_SUSUT){
				//get residu ---------------------------------------
				$get_residu = mysql_fetch_array(mysql_query(
					"select residu from ref_barang where f='".$isi['f']."'  and g='".$isi['g']."' and h='".$isi['h']."' and i='".$isi['i']."' and j='".$isi['j']."'"
				));
				$residu =$get_residu['residu'];
				$isi['nilai_sisa']=$residu*$isi['jml_harga']/100;		
				$isi['nilai_ekonomis']=$isi['masa_manfaat'];
				if($isi['masa_manfaat']==NULL || $isi['masa_manfaat']==0){
					$isi['nilai_susutpertahun']='-';
				}else{
					$nilaisusutpertahun=$isi['jml_harga']-$isi['nilai_sisa']/$isi['masa_manfaat'];
					$isi['nilai_susutpertahun']=number_format($nilaisusutpertahun,2,',','.');
				}	
				if($Main->TAHUN_MULAI_SUSUT<=$isi['thn_perolehan']){
					$isi['lama_penggunaan']=$fmThnLaporan-1-$isi['thn_perolehan'];
				}else{
					$isi['lama_penggunaan']=$fmThnLaporan-1-$Main->TAHUN_MULAI_SUSUT;
				}
				//get harga susut --------------------------------			
				$aqry = "select sum(harga)as harga from penyusutan where tahun<$fmThnLaporan and idbi='".$isi['id']."' and id_koreksi=0"; //echo $aqry;
				$get_susut = mysql_fetch_array(mysql_query($aqry));
				$get_susut2 = mysql_fetch_array(mysql_query("select sum(harga)as harga from penyusutan where tahun=$fmThnLaporan and idbi='".$isi['id']."' and id_koreksi=0"));
				$isi['nilai_susut_sd']=$get_susut['harga'];
				$isi['nilai_susut_tahun']=$get_susut2['harga'];	
				$tgl_nilaibuku = $fmThnLaporan.'-12-31';
				$nbts=getNilaiBuku($isi['id'],"$tgl_nilaibuku",0);
				$isi['nilai_buku']=$nbts-($isi['nilai_susut_sd']+$isi['nilai_susut_tahun']);
				$totalSusutPrevHal2+=$isi['nilai_susut_sd'];
				$totalSusutSkrHal2+=$isi['nilai_susut_tahun'];
				$totalNilaiBukuHal2+=$isi['nilai_buku'];
			}
			
			//get kode
			$infobrg .= " kode='".$isi['idall2']."'";			
			$infobrg .= " idbarang='".$isi['id']."'";			
			$infobrg .= " nmbarang='".$isi['nm_barang']."'";
			$ruang = mysql_fetch_array(mysql_query("select * from ref_ruang where id='".$isi['ref_idruang']."'"));
			$infobrg .= " nm_ruang='".$ruang['nm_pendek']."'";
			$ruang = mysql_fetch_array(mysql_query("select * from ref_ruang where concat(a1,a,b,c,d,e,e1,p,q)='".
					$ruang['a1'].$ruang['a'].$ruang['b'].$ruang['c'].$ruang['d'].$ruang['e'].$ruang['e1'].$ruang['p']."0000'"
				));
			$infobrg .= " nm_gedung='".$ruang['nm_pendek']."'";
		
			$kondisi = $isi['kondisi'];
			
			//$tipe=$_REQUEST['tipe'];
			$kondisi_kk =
				"<img src='images/checkbox.png'> B<br>".
				"<img src='images/checkbox.png'> KB<br>".
				"<img src='images/checkbox.png'> RB<br>".
				"<img src='images/checkbox.png'> TD<br>".							
				"";
			$status_penguasaan = 
				"<img src='images/checkbox.png'> Digunakan<br>".
				"<img src='images/checkbox.png'> Dimanfaatkan<br>".
				"<img src='images/checkbox.png'> Iddle<br>".
				"<img src='images/checkbox.png'> Dikuasai Pihak Ketiga<br>".
				"<img src='images/checkbox.png'> Sengketa<br>".
				"";
			$ketskpd="";
/*
					if ($isi['nmopd']<>'')  $ketskpd=$isi['nmopd'];
					if ($isi['nmunit']<>'' && $isi['nmunit']<>$ketskpd ) $ketskpd="$ketskpd/<br>".$isi['nmunit'];
					if ($isi['nmseksi']<>'' && $isi['nmseksi']<>$ketskpd ) $ketskpd="$ketskpd/<br>".$isi['nmseksi'];
					if ($ketskpd<>'')  $ketskpd="/<br>$ketskpd";
*/			
			
			
			//get nama gedung dan ruang
			$get = table_get_rec("select aa.*, bb.nm_ruang as nm_gedung from ref_ruang aa 
					left join ref_ruang bb on aa.a1=bb.a1 and aa.a=bb.a and aa.b=bb.b 
					and aa.c=bb.c and aa.d=bb.d and aa.e=bb.e and aa.e1=bb.e1 
					and aa.p=bb.p and bb.q='0000'
					where aa.id='".$isi['ref_idruang']."'");
			$nm_gedung = $get['nm_gedung'];
			$nm_ruang = $get['nm_ruang'];
			//------------------------------------
			if($Main->VERSI_NAME != 'TASIKMALAYA_KAB'){
				$pgw = mysql_fetch_array(mysql_query(
					"select * from ref_pegawai where id ='".$isi['ref_idpemegang2']."'"
				));
				$ketpenanggungjawab = '<br>Nip. '.$pgw['nip'].' / '.$pgw['nama'];
			}
			
				
			if($Main->MODUL_JMLGAMBAR ){
				$gbr = mysql_fetch_array(mysql_query("select count(*) as cnt from gambar where idbi='".$isi['idawal']."' "));
				$ketgbr = '<br>Gambar : '.$gbr['cnt'];
			}
			if($Main->MODUL_SPK){
				$no_spk = $isi['no_spk'];
				$tgl_spk = TglInd( $isi['tgl_spk'] );
				$vspk = "";
				//$vspk = "<td class=\"$clGaris\">$no_spk/<br>$tgl_spk</td>";
			}
			if($Main->MODUL_BAST){
				$no_ba = $isi['no_ba'];
				$keg = $isi['bk_p'].'.'.$isi['ck_p'].'.'.$isi['dk_p'].'.'.$isi['p'].'.'.$isi['q'];
				$vkegiatan = $isi['p']==0 ? '' : "$keg";
				$tgl_ba = TglInd( $isi['tgl_ba'] );
				//$vbast = "<td class=\"$clGaris\">$no_ba/<br>$tgl_ba/<br>$vkegiatan</td>";
				$vbast = $SPg=='KIR'?"<td class=\"$clGaris\">$nm_gedung/<br>$nm_ruang</td>":
					"<td class=\"$clGaris\">$no_ba/<br>$tgl_ba/<br>$no_spk/<br>$tgl_spk</td>";
			}
			
			if($Main->MODUL_PENGGUNAAN){
				$penggunabi = $isi['penggunaan'];
				$vpenggunabi= "/<br>".$isi['penggunaan'];
			}
			
			//$gbr = mysql_fetch_array(mysql_query("select count(*) as cnt from gambar where idbi='".$isi['idawal']."' "));
			//$ketgbr = '<br>Gambar : '.$gbr['cnt'];	
			
			
								 				
			switch($SPg){
				case "03" : case "listbi_cetak" : case 'belumsensus': case 'KIR' : case 'KIP' :{				
					
					if($Main->KD_BARANG_P108){
						$kdBarang = $isi['f1'].'.'.$isi['f2'].'.'.$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'];
					}else{
						$kdBarang = $isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'];	//$kdKelBarang = $isi['f'].$isi['g']."00";
					}
					
					$AsalUsul = $isi['asal_usul'];	
					$ISI5 = "";	$ISI6 = "";	$ISI7 = "";	$ISI10 = ""; $ISI15='';

					$check_ =  "<input type=\"checkbox\" $Checked $infobrg id=\"cb$cb\" name=\"cidBI[]\" value=\"{$isi['id']}\" 
					     onClick=\"isChecked(this.checked);"."Penatausaha.cbxPilih(this)\" />"; //<td class=\"$clGaris\" align=center><input type=\"checkbox\" $Checked  id=\"cb$cb\" name=\"cidBI[]\" value=\"{$isi['id']}\" onClick=\"isChecked(this.checked);\" />";
					$tampilCheckbox = $cetak ? "":
						"<td class=\"$clGaris\" align=center>$check_</td>";
											
					//--- ambil data kib by noreg --------------------------------				
					if ($isi['f'] == "01" || $isi['f'] == "02" || $isi['f'] == "03" || $isi['f'] == "04" || $isi['f'] == "05" || $isi['f'] == "06" || $isi['f'] == "07") {
						$KondisiKIB = "
						where 
						idbi= '{$isi['id']}' ";
						/*$KondisiKIB = "
						where 
						a1= '{$isi['a1']}' and 
						a = '{$isi['a']}' and 
						b = '{$isi['b']}' and 
						c = '{$isi['c']}' and 
						d = '{$isi['d']}' and 
						e = '{$isi['e']}' and 
						e1 = '{$isi['e1']}' and 
						f = '{$isi['f']}' and 
						g = '{$isi['g']}' and 
						h = '{$isi['h']}' and 
						i = '{$isi['i']}' and 
						j = '{$isi['j']}' and 
						noreg = '{$isi['noreg']}' and 
						tahun = '{$isi['tahun']}' ";*/
					}
					if ($isi['f'] == "01") {//KIB A
						//"concat(a1,a,b,c,d,e,f,g,h,i,j,noreg,tahun)='{$isi['a1']}{$isi['a']}{$isi['b']}{$isi['c']}{$isi['d']}{$isi['e']}{$isi['f']}{$isi['g']}{$isi['h']}{$isi['i']}{$isi['j']}{$isi['noreg']}{$isi['tahun']}'
						$QryKIB_A = mysql_query("select * from kib_a  $KondisiKIB  limit 0,1");
						while ($isiKIB_A = mysql_fetch_array($QryKIB_A)) {
							$isiKIB_A = array_map('utf8_encode', $isiKIB_A);	
			
							//if($SPg == 'belumsensus'){
								$alm = '';
								$alm .= ifempty($isiKIB_A['alamat'],'-');
								$alm .= ($isi['rt'] && $isi['rw']) == ''? '' : '<br>RT/RW. '.$isi['rt'].'/'.$isi['rw'];		
								$alm .= $isi['kampung'] == ''? '' : '<br>Kp/Komp. '.$isi['kampung'];		
								$alm .= $isiKIB_A['alamat_kel'] != ''? '<br>Kel/Desa. '.$isiKIB_A['alamat_kel'] : '';
								$alm .= $isiKIB_A['alamat_kec'] != ''? '<br>Kec. '.$isiKIB_A['alamat_kec'] : '';
								$alm .= $isiKIB_A['alamat_kota'] != ''? '<br>'.$isiKIB_A['alamat_kota'] : '';
								$ISI5 = $alm;
							//}else{
							//	$ISI5 = '';
							//}
							$ISI6 = "{$isiKIB_A['sertifikat_no']}";  //$ISI10 = "{$isiKIB_A['luas']}";
							$ISI15 = "{$isiKIB_A['ket']}";
							$ISI10 = number_format($isiKIB_A['luas'],2,',','.');
						}
					}
					if ($isi['f'] == "02") {//KIB B;
						//"concat(a1,a,b,c,d,e,f,g,h,i,j,noreg,tahun)='{$isi['a1']}{$isi['a']}{$isi['b']}{$isi['c']}{$isi['d']}{$isi['e']}{$isi['f']}{$isi['g']}{$isi['h']}{$isi['i']}{$isi['j']}{$isi['noreg']}{$isi['tahun']}'";
						$QryKIB_B = mysql_query("select * from kib_b  $KondisiKIB limit 0,1");
						while ($isiKIB_B = mysql_fetch_array($QryKIB_B)) {
							$isiKIB_B = array_map('utf8_encode', $isiKIB_B);
							$ISI5 = "{$isiKIB_B['merk']}";
							$ISI6 = "{$isiKIB_B['no_pabrik']} /<br> {$isiKIB_B['no_rangka']} /<br> {$isiKIB_B['no_mesin']} /<br> {$isiKIB_B['no_polisi']}";
							$ISI7 = "{$isiKIB_B['bahan']}";							
							$ISI15 = "{$isiKIB_B['ket']}";
						}
					}
					if ($isi['f'] == "03") {//KIB C;
						$QryKIB_C = mysql_query("select * from kib_c  $KondisiKIB limit 0,1");
						while ($isiKIB_C = mysql_fetch_array($QryKIB_C)) {
							$isiKIB_C = array_map('utf8_encode', $isiKIB_C);
							//if($SPg == 'belumsensus'){
								$alm = '';
								$alm .= ifempty($isiKIB_C['alamat'],'-');		
								$alm .= ($isi['rt'] && $isi['rw']) == ''? '' : '<br>RT/RW. '.$isi['rt'].'/'.$isi['rw'];		
								$alm .= $isi['kampung'] == ''? '' : '<br>Kp/Komp. '.$isi['kampung'];
								$alm .= $isiKIB_C['alamat_kel'] != ''? '<br>Kel/Desa. '.$isiKIB_C['alamat_kel'] : '';
								$alm .= $isiKIB_C['alamat_kec'] != ''? '<br>Kec. '.$isiKIB_C['alamat_kec'] : '';
								$alm .= $isiKIB_C['alamat_kota'] != ''? '<br>'.$isiKIB_C['alamat_kota'] : '';
								$ISI5 = $alm;
							//}else{
							//	$ISI5 = '';
							//}
							$ISI6 = "{$isiKIB_C['dokumen_no']}";
							$ISI10 = $Main->Bangunan[$isiKIB_C['kondisi_bangunan'] - 1][1];
							$ISI15 = "{$isiKIB_C['ket']}";
						}
					}
					if ($isi['f'] == "04") {//KIB D;
						$QryKIB_D = mysql_query("select * from kib_d  $KondisiKIB limit 0,1");
						while ($isiKIB_D = mysql_fetch_array($QryKIB_D)) {
							$isiKIB_D = array_map('utf8_encode', $isiKIB_D);
							//if($SPg == 'belumsensus'){
								$alm = '';
								$alm .= ifempty($isiKIB_D['alamat'],'-');
								$alm .= ($isi['rt'] && $isi['rw']) == ''? '' : '<br>RT/RW. '.$isi['rt'].'/'.$isi['rw'];		
								$alm .= $isi['kampung'] == ''? '' : '<br>Kp/Komp. '.$isi['kampung'];		
								$alm .= $isiKIB_D['alamat_kel'] != ''? '<br>Kel/Desa. '.$isiKIB_D['alamat_kel'] : '';
								$alm .= $isiKIB_D['alamat_kec'] != ''? '<br>Kec. '.$isiKIB_D['alamat_kec'] : '';
								$alm .= $isiKIB_D['alamat_kota'] != ''? '<br>'.$isiKIB_D['alamat_kota'] : '';
								$ISI5 = $alm;
							//}else{
							//	$ISI5 = '';
							//}
							$ISI6 = "{$isiKIB_D['dokumen_no']}";
							$ISI15 = "{$isiKIB_D['ket']}";
						}
					}
					if ($isi['f'] == "05") {//KIB E;
						$QryKIB_E = mysql_query("select * from kib_e  $KondisiKIB limit 0,1");
						while ($isiKIB_E = mysql_fetch_array($QryKIB_E)) {
							$isiKIB_E = array_map('utf8_encode', $isiKIB_E);
							$ISI7 = "{$isiKIB_E['seni_bahan']}";
							$ISI15 = "{$isiKIB_E['ket']}";
						}
					}
					if ($isi['f'] == "06") {//KIB F;
						$sQryKIB_F = "select * from kib_f  $KondisiKIB limit 0,1";
						$QryKIB_F = mysql_query($sQryKIB_F);
						//echo "<br>qrykibf= $sQryKIB_F";
						while ($isiKIB_F = mysql_fetch_array($QryKIB_F)) {
							$isiKIB_F = array_map('utf8_encode', $isiKIB_F);
							//if($SPg == 'belumsensus'){
								$alm = '';
								$alm .= ifempty($isiKIB_F['alamat'],'-');
								$alm .= ($isi['rt'] && $isi['rw']) == ''? '' : '<br>RT/RW. '.$isi['rt'].'/'.$isi['rw'];		
								$alm .= $isi['kampung'] == ''? '' : '<br>Kp/Komp. '.$isi['kampung'];		
								$alm .= $isiKIB_F['alamat_kel'] != ''? '<br>Kel/Desa. '.$isiKIB_F['alamat_kel'] : '';
								$alm .= $isiKIB_F['alamat_kec'] != ''? '<br>Kec. '.$isiKIB_F['alamat_kec'] : '';
								$alm .= $isiKIB_F['alamat_kota'] != ''? '<br>'.$isiKIB_F['alamat_kota'] : '';
								$ISI5 = $alm;
							//}else{
							//	$ISI5 = '';
							//}
							$ISI6 = "{$isiKIB_F['dokumen_no']}";
							$ISI10 = $Main->Bangunan[$isiKIB_F['bangunan'] - 1][1];
							$ISI15 = "{$isiKIB_F['ket']}";
						}
					}
					if ($isi['f'] == "07") {//KIB E;
						$QryKIB_E = mysql_query("select * from kib_g  $KondisiKIB limit 0,1");
						while ($isiKIB_E = mysql_fetch_array($QryKIB_E)) {
							$isiKIB_E = array_map('utf8_encode', $isiKIB_E);
							$ISI7 = "{$isiKIB_E['pencipta']}";
//							$ISI7 = "{$isiKIB_E['jenis']}";
							$ISI15 = "{$isiKIB_E['ket']}";
						}
					}					
					
					//*******************************************************
					
					$ISI5 = !empty($ISI5) ? $ISI5 : "-";
					$ISI6 = !empty($ISI6) ? $ISI6 : "-";
					$ISI7 = !empty($ISI7) ? $ISI7 : "-";
					$ISI10 = !empty($ISI10) ? $ISI10 : "-";
					$ISI12 = !empty($ISI12) ? $ISI12 : "-";
					$ISI15 = !empty($ISI15) ? $ISI15 : "-";
					if (($fmCariComboField != 'ket')||($fmCariComboField == 'ket' && stripos( $ISI15, $fmCariComboIsi) !== false  )){						
						//ambil data ref status survey						
						if($Main->STATUS_SURVEY==1 ){
							$ss = mysql_fetch_array(mysql_query("select * from ref_statusbarang2 where Id='".$isi['ref_idstatussurvey']."'"));	
							$status_survey="".$ss['nama'];						
						}
						
						if ($sort1 >= 1){			
							$ISI15 	= $ISI15.' /<br>'.TglInd($isi['tgl_buku']).' /<br>'.$isi['tgl_update'].' /<br>'.$isi['tahun_sensus'].$ketskpd.$status_survey.$jnsekstra ;	
						}else{
							$ISI15 	= $ISI15.' /<br>'.TglInd($isi['tgl_buku']).' /<br>'.$isi['tahun_sensus'].$ketskpd.$status_survey.$jnsekstra;			
						}		
						//$ISI15 .= $isi['nmbidang'].' - '.$isi['nmopd'].' - '.$isi['nmunit'];	//$ISI15 .= tampilNmSubUnit($isi);//echo"<br>$ISI15";	
						//tmpil jumlah gambar
						//$ISI15 .= $ketgbr;
							
						
						
						$no++;
						$jmlTotalHargaDisplay += $isi['jml_harga'];
						$clRow = $no % 2 == 0 ?"row1":"row0";
						if ($txls=='1'){
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, '.', '') : number_format($isi['jml_harga'], 2, '.', '');					
						
							
						} else 
						{
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, ',', '.') : number_format($isi['jml_harga'], 2, ',', '.');					
							
						}
						
						//tampil kolom data bi --------------------------------------------------------------------------------
						//$togler =  "<a href='#' class='toggler' data-prod-cat='".$isi['idawal']."'>+ </a>";
						if($tipe=='kertaskerja'){ //cetak kertas kerja sensus
							$ListData .= "
								<tr class=\"$clRow\" valign='top' >
								<td class=\"$clGaris\" align=center>$no.</td>
								$tampilCheckbox
								<td class=\"$clGaris\" align=center>{$isi['a1']}.{$isi['a']}.{$isi['b']}.{$isi['c']}.{$isi['d']}.".substr($isi['thn_perolehan'],2,2).".{$isi['e']}.{$isi['e1']}<br>{$isi['f']}.{$isi['g']}.{$isi['h']}.{$isi['i']}.{$isi['j']}.{$isi['noreg']}<br>{$isi['nm_barang']}</td>								
								
								<td class=\"$clGaris\"><div class='nfmt5'>$ISI5</div></td>
								<td class=\"$clGaris\"><div class='nfmt5'>$ISI6</div></td>	
								<td class=\"$clGaris\" align=right>{$isi['thn_perolehan']}/<br>$tampilHarga</td>".							
								//"<td class=\"$clGaris\" align=center>".$Main->KondisiBarang[$isi['kondisi']-1][1]."</td>".
								"<td class=\"$clGaris\" align=center>Ada /<br> Tidak</td>".
								"<td class=\"$clGaris\" align=center><br>B / KB / RB</td>
								<td class=\"$clGaris\">&nbsp;</td>
								<td class=\"$clGaris\">&nbsp;</td>
								<td class=\"$clGaris\">Digunakan / Dimanfaatkan/<br>Iddle / Dikuasai Pihak Ketiga /<br>Sengketa</td>
								<td class=\"$clGaris\">&nbsp;</td>
								<td class=\"$clGaris\">&nbsp;</td>".
								
								
								"</tr>";
						}
						else{	
							$jns=$_REQUEST['jns'];
							if($jns=='penyusutan' && $Main->PENYUSUTAN){								
								$tahun_susut = $_REQUEST['tahun_susut'];
								//hitung harga rehab ---------------------------------------																
								//if($Main->SUSUT_MODE==5){ //yang lama bdg barat bulanan, serang kota tahun +1 cek deui??
								//	$operTahun = '<';
								//}else{
									$operTahun = '<=';									
								//}
								//if($Main->VERSI_NAME=='BDG_BARAT'){// sekarang
								//	$operTahun = '<=';	
								//}
								$aqryplh = //pelihara
									"select sum(biaya_pemeliharaan) as tot, sum(ifnull(masa_manfaat,0)) as totmanfaat from pemeliharaan ".
									"where tambah_aset=1 and idbi_awal='".$isi['idawal']."' ".
									"and YEAR(tgl_pemeliharaan) $operTahun $tahun_susut ; "; $cek .= $aqryplh;
								$plh= mysql_fetch_array(mysql_query( $aqryplh ));
								$aqryplh = //pengaman
									"select sum(biaya_pengamanan)as tot, sum(ifnull(masa_manfaat,0)) as totmanfaat from pengamanan ".
									"where tambah_aset=1 and idbi_awal='".$isi['idawal']."' ".
									"and YEAR(tgl_pengamanan) $operTahun $tahun_susut ; "; $cek .= $aqryplh;
								$aman= mysql_fetch_array(mysql_query( $aqryplh ));
								$aqryplh = //hapus sebagian
									"select sum(harga_hapus)as tot, sum(ifnull(masa_manfaat,0)) as totmanfaat from penghapusan_sebagian ".
									" where  idbi_awal='".$isi['idawal']."' ".
									"and YEAR(tgl_penghapusan) $operTahun $tahun_susut ; "; $cek .= $aqryplh;
								$hps= mysql_fetch_array(mysql_query( $aqryplh ));
								$aqryplh = //koreksi 
									"select sum(harga_baru - harga)as tot, sum(ifnull(masa_manfaat,0)) as totmanfaat from t_koreksi ".
									"where idbi_awal='".$isi['idawal']."' ".
									"and YEAR(tgl) $operTahun $tahun_susut ; ";  $cek .= $aqryplh;
								$koreksi = mysql_fetch_array(mysql_query( $aqryplh ));
								//$hrg_rehab = $plh['tot'] + $aman['tot'] - $hps['tot'] + $koreksi['tot'];	
								$aqryplh = //penilaian 
									"select sum(nilai_barang - nilai_barang_asal)as tot, sum(ifnull(masa_manfaat,0)) as totmanfaat from penilaian ".
									"where idbi_awal='".$isi['idawal']."' ".
									"and YEAR(tgl_penilaian) $operTahun $tahun_susut ; ";  $cek .= $aqryplh;
								$penilaian = mysql_fetch_array(mysql_query( $aqryplh ));
								$hrg_rehab = $plh['tot'] + $aman['tot'] - $hps['tot'] + $koreksi['tot']+$penilaian['tot'];
								
								
								$aqrsusut = "select count(*) as jmlsusut, 
									ifnull(sum(harga),0) as hrgsusut, 
									ifnull(sum(hrg_rehab),0) as hrgrehab 
									from penyusutan where idbi='".$isi['id']."' and tahun<$tahun_susut and id_koreksi='0'  and year(tgl) <= $tahun_susut "; //yg tgl > $tahun_susut tidak ditampilkan
									//from penyusutan where idbi_awal='".$isi['idawal']."' and tahun<$tahun_susut ";
								//echo $aqrsusut;
								$susut = mysql_fetch_array(mysql_query($aqrsusut));
								$penyusutanprev = $susut['hrgsusut'];
								$aqrsusut = "select count(*) as jmlsusut, 
									ifnull(sum(harga),0) as hrgsusut, 
									ifnull(sum(hrg_rehab),0) as hrgrehab 
									from penyusutan where idbi='".$isi['id']."' and tahun<=$tahun_susut and id_koreksi='0'  and year(tgl) <= $tahun_susut "; //yg tgl > $tahun_susut tidak ditampilkan
									//from penyusutan where idbi_awal='".$isi['idawal']."' and tahun<=$tahun_susut ";
								$susut = mysql_fetch_array(mysql_query($aqrsusut));
								$penyusutantot = $susut['hrgsusut'];
								$penyusutanskr = $penyusutantot-$penyusutanprev  ;
								$nilaibuku = $isi['jml_harga'] + $hrg_rehab - $penyusutantot ;
								$totalSusutPrevHal += $penyusutanprev;
								$totalSusutSkrHal += $penyusutanskr;
								$totalSusutTotHal += $penyusutantot;
								$totalNilaiBukuHal += $nilaibuku;
								$get = mysql_fetch_array(mysql_query("select * from buku_induk where id='".$isi['id']."'"));
								$masa_manfaat = $get['masa_manfaat'];
								$vmasa_manfaat = number_format($masa_manfaat,0,',','.').'thn';
								$nilairesidu  = $get['nilai_sisa'];
								$vresidu = number_format($nilairesidu,2,',','.').'%';
								
								/*if($isi['asal_usul']==5){
									$arrtgl = explode('-', $isi['tgl_buku'] );
									$thn_akhir = $arrtgl[0] + $get['masa_manfaat'];	
								}else{
									$thn_akhir = $isi['thn_perolehan'] + $get['masa_manfaat'];	
								}*/
								if($Main->SUSUT_MODE==6){
									$umur_neraca_awal_ = '2003'-$isi['thn_perolehan'];
									if($isi['thn_perolehan']<'2003'){
										$thn_akhir = $isi['thn_susut_aw'] + ($get['masa_manfaat']-$umur_neraca_awal_);	
									}else{
										$thn_akhir = $isi['thn_susut_aw'] + $get['masa_manfaat'];				
									}								
								}else{
										$thn_akhir = $isi['thn_susut_aw'] + $get['masa_manfaat'];							
								}
									$blnaw = $isi['bln_susut_aw'] - 1;
								if($blnaw<=0) $thn_akhir -=1;
								
								$vmasa_manfaat2 = $get['masa_manfaat'] > 0 ? $vmasa_manfaat."/ ".$vresidu."/ ".$thn_akhir : '-';
								$ListData .= "
									<tr class=\"$clRow\" valign='top'>
									<td class=\"$clGaris\" align=center>$no.</td>
									$tampilCheckbox
									<td class=\"$clGaris\" align=left>{$isi['f']}.{$isi['g']}.{$isi['h']}.{$isi['i']}.{$isi['j']}/<br>{$isi['id']}/<br>{$isi['idawal']}</td>
									<td class=\"$clGaris\" align=center><div class='nfmt3'> {$isi['noreg']}</div></td>
									<td class=\"$clGaris\">{$isi['nm_barang']}</td>						
									<td class=\"$clGaris\"><div class='nfmt5'>".utf8_encode($ISI5)."</div></td>
									<td class=\"$clGaris\"><div class='nfmt5'>".utf8_encode($ISI6)."</div></td>
									<!--<td class=\"$clGaris\">".utf8_encode($ISI7)."</td>-->
									<td class=\"$clGaris\">".$Main->AsalUsul[$AsalUsul-1][1]."<br>/".$jnshibah."<br>/".$Main->StatusBarang[$isi['status_barang']-1][1]."</td>
									<td class=\"$clGaris\" align=center>{$isi['thn_perolehan']}</td>
									<!--<td class=\"$clGaris\">$ISI10</td>-->
									<td class=\"$clGaris\" align=center>".$Main->KondisiBarang[$isi['kondisi']-1][1]."</td>
									<!--<td class=\"$clGaris\" align=right>{$isi['jml_barang']} {$isi['satuan']}</td>-->
									<td class=\"$clGaris\" align=right>".$tampilHarga."</td>
									<!--<td class=\"$clGaris\" align=right>".number_format($penyusutanprev,2,',','.')."</td>-->
									<td class=\"$clGaris\" align=right>".number_format($penyusutantot,2,',','.')."</td>
									<td class=\"$clGaris\" align=right>".number_format($nilaibuku,2,',','.')."</td>
									<td class=\"$clGaris\" align=right>".number_format($penyusutanskr,2,',','.')."</td>									
									<td class=\"$clGaris\">".$vmasa_manfaat2."</td>".
									"<td class=\"$clGaris\">".utf8_encode($ISI15).'<br>'.$isi['vBidang']."</td>".
									//$isi['vBidang'].
									$tampilDok.
									$tampilCbxKeranjang.
									"</tr>	";
								
								
							}
							else{	
								if ($Main->JNS_EKSTRA==1 && $jns=='ekstra' ){
									/*$biekstra = mysql_fetch_array(mysql_query(
										" select * from buku_induk where id='".$isi['id']."' " 
									)); 
									$vjnsekstra = $biekstra['jns_ekstra']==0?'': $Main->arrJnsEkstra[$biekstra['jns_ekstra']][1];*/
									$vjnsekstra = $isi['jns_ekstra']==0?'': $Main->arrJnsEkstra[$isi['jns_ekstra']][1];
									$jnsekstra = "<td class=\"$clGaris\" align=center style=\"min-width:50;\">".$vjnsekstra ."</td>";	
								}
								if ($Main->JNS_LAINLAIN==1 && $jns=='lain' ){
									/*$biekstra = mysql_fetch_array(mysql_query(
										" select * from buku_induk where id='".$isi['id']."' " 
									)); 
									$vjnslain = $biekstra['jns_lain']==0?'': $Main->arrJnsLain[$biekstra['jns_lain']][1];*/
									$vjnslain = $isi['jns_lain']==0?'': $Main->arrJnsLain[$isi['jns_lain']][1];
									$jnslain = "<td class=\"$clGaris\" align=center style=\"min-width:50;\">".$vjnslain ."</td>";	
								}
								
								if($Main->STATUS_SURVEY){
									$kolStatusSurvey = "<td class=\"$clGaris\">".$status_survey."</td>";	
								}
								
								if($Main->TAMPIL_SUSUT){
								
									$kolTampilSusut = "
									<td class=\"$clGaris\" align=right>".number_format($isi['nilai_sisa'],2,',','.')."</td>
									<td class=\"$clGaris\" align=right>".number_format($isi['nilai_ekonomis'],0,',','.')."</td>
									<td class=\"$clGaris\" align=right>".$isi['nilai_susutpertahun']."</td>
									<td class=\"$clGaris\" align=right>".number_format($isi['lama_penggunaan'],0,',','.')."</td>
									<td class=\"$clGaris\" align=right>".number_format($isi['nilai_susut_sd'],2,',','.')."</td>
									<td class=\"$clGaris\" align=right>".number_format($isi['nilai_susut_tahun'],2,',','.')."</td>
									<td class=\"$clGaris\" align=right>".number_format($isi['nilai_buku'],2,',','.')."</td>
									";	
								}	
								//**
								if($Main->SETTING['SENSUS_VERSI']==2 && $SPg=='belumsensus'){
									$vbast = "<td class=\"$clGaris\">$nm_gedung/<br>$nm_ruang</td>";
								}
								//**/
								$ListData .= "
									<tr class=\"$clRow\" valign='top'  >
									<td class=\"$clGaris\" align=center>$togler $no.  </td>
									$tampilCheckbox
									<td class=\"$clGaris\" align=left>{$isi['id_barang']}/<br>{$isi['id']}/<br>{$isi['idawal']}</td>
									<td class=\"$clGaris\" align=center><div class='nfmt3'> {$isi['noreg']}</div></td>
									<td class=\"$clGaris\">{$isi['nm_barang']}</td>						
									<td class=\"$clGaris\"><div class='nfmt5'>$ISI5</div></td>
									<td class=\"$clGaris\"><div class='nfmt5'>$ISI6</div></td>
									<td class=\"$clGaris\"><div class='nfmt5'>$ISI7</div></td>
									<td class=\"$clGaris\">".$Main->AsalUsul[$AsalUsul-1][1]."/<br>".$jnshibah."/<br>".$Main->StatusBarang[$isi['status_barang']-1][1]."/<br>".$vpenggunabi."</td>
									<td class=\"$clGaris\" align=center>{$isi['thn_perolehan']}</td>
									<td class=\"$clGaris\">$ISI10</td>
									<td class=\"$clGaris\" align=center>".$Main->KondisiBarang[$isi['kondisi']-1][1]."</td>
									<!--<td class=\"$clGaris\" align=right>{$isi['jml_barang']} {$isi['satuan']}</td>-->
									<td class=\"$clGaris\" align=right>".$tampilHarga."</td>
									$vbast
									$vspk
									<td class=\"$clGaris\">$ISI15 $ketgbr $ketpenanggungjawab ".'<br>'.$isi['vBidang']."</td>".
									//$isi['vBidang'].
									$tampilDok.
									$tampilCbxKeranjang.
									$kolStatusSurvey.
									$kolTampilSusut.
									$jnsekstra.
									$jnslain.
									
									"</tr>	";
							}
						}
					}
					
					//--- ambil data pemeliharaan & pengamanan -----------------------------
					if($tipe!='kertaskerja'){
						//$jns=='penyusutan'
						if($Main->PENATAUSAHA_VERSI==1){
							$det = $this->GetListDet2($isi['idawal'], '', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
						}else{
							$det = Penatausahaan_GetListDet2($isi['idawal'], '', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
						}
						
						
											
						$ListData .= $det['ListData'];
						//--- total ------------------------------------------------------------
						$jmlTotalHargaDisplay += $det['jmlTotalHargaDisplay'];
					} 
					
					
					//*/
					break;
				}
				case "04" : case "kib_a_cetak" :{
					
					
					$idBI = $isi['idbi']; //?
					
					$no++;
					$clRow = ""; if ($cetak == FALSE){$clRow = $no % 2 == 0 ?"row1":"row0"; }							
					$tampilCheckbox = $cetak ? "":"<td class=\"$clGaris\" align=center><input type=\"checkbox\" $Checked  $infobrg id=\"cb$cb\" name=\"cidBI[]\" value=\"".$idBI."\" onClick=\"isChecked(this.checked);\" /></td>";
					
						
					//}else{
						$ListData .= Penatausahaan_genTableRowKibA($clRow, $clGaris, $tampilCheckbox, $isi, $no, $tampilCbxKeranjang,$tipe, $ketpenanggungjawab);					
					//}
					
					
					//$SPg=$_REQUEST['SPg'];
					//SPg=belumsensus&tipe=kertaskerja
					//$tipw = $_REQUEST['tipe'];
		
					//$det = Penatausahaan_GetListDet($isi['idawal'], '01',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);
					if($Main->PENATAUSAHA_VERSI==1){
						$det = $this->GetListDet2($isi['idawal'], '01', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
					}else{
						$det = Penatausahaan_GetListDet2($isi['idawal'], '01', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
					}			
					
					$ListData .= $det['ListData'];
					
					$jmlTampilKIB_A++;
					$jmlTotalHargaDisplay += $isi['jml_harga'];
					$jmlTotalHargaDisplay += $det['jmlTotalHargaDisplay'];	
					$totLuasTanahHal += $isi['luas'];
						
					break;
				}
				case "05" : case "kib_b_cetak" :{		
					//while ($isi = mysql_fetch_array($Qry)){
						$idBI = $isi['idbi'];//getIDByKodeBrg('buku_induk', $isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['tahun'].$isi['noreg']);
						//$kdBarang = $isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'];
						$ISI1 	= !empty($isi['merk'])?$isi['merk']:"-";
						$ISI2 	= !empty($isi['ukuran'])? number_format($isi['ukuran'],0,',','.'):"-";
						$ISI3 	= !empty($isi['bahan'])?$isi['bahan']:"-";
						$ISI4 	= !empty($isi['thn_perolehan'])?$isi['thn_perolehan']:"-";
						$ISI5 	= !empty($isi['no_pabrik'])?$isi['no_pabrik']:"-";
						$ISI6 	= !empty($isi['no_rangka'])?$isi['no_rangka']:"-";
						$ISI7 	= !empty($isi['no_mesin'])?$isi['no_mesin']:"-";
						$ISI8 	= !empty($isi['no_polisi'])?$isi['no_polisi']:"-";
						$ISI9 	= !empty($isi['no_bpkb'])?$isi['no_bpkb']:"-";
						$ISI10 = !empty($Main->AsalUsul[$isi['asal_usul']-1][1])?$Main->AsalUsul[$isi['asal_usul']-1][1]:"-";
						$ISI10a = !empty($jnshibah)?$jnshibah:"-";
						$ISI11 = !empty($Main->StatusBarang[$isi['status_barang']-1][1])?$Main->StatusBarang[$isi['status_barang']-1][1]:"-";
						$ISI11a= !empty($Main->KondisiBarang[$kondisi-1][1])?$Main->KondisiBarang [$kondisi-1][1]:"-";
						$ISI12 = !empty($isi['ket'])?$isi['ket']:"-";
						//$ISI12 .= '<br>'.$isi['nmbidang'].' - '.$isi['nmopd'].' - '.$isi['nmunit'] ;
						//$ISI12 .= tampilNmSubUnit($isi);
						$jmlTampilKIB_B++;
						$jmlTotalHargaDisplay += $isi['jml_harga'];
						$no++;
						$clRow = ""; if ($cetak == FALSE){$clRow = $no % 2 == 0 ?"row1":"row0"; }		
						if ($txls=='1'){
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, '.', '') : number_format($isi['jml_harga'], 2, '.', '');
							
						} else {
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, ',', '.') : number_format($isi['jml_harga'], 2, ',', '.');
							
						}
						//$dok = $isi['dokumen_file']=="" ? "" : dokumenlink($isi['dokumen_file'], $isi['dokumen']);
						//$tampilDok = '';//$cetak? "" : "<td class=\"$clGaris\">$dok</td>"; 
						$tampilCheckbox = $cetak ? "":"<td class=\"$clGaris\" align=center><input type=\"checkbox\" $Checked $infobrg id=\"cb$cb\" name=\"cidBI[]\" value=\"".$idBI."\" onClick=\"isChecked(this.checked);\" /></td>";
						//ambil data ref status survey
						if($Main->STATUS_SURVEY==1 ){
							$ss = mysql_fetch_array(mysql_query("select * from ref_statusbarang2 where Id='".$isi['ref_idstatussurvey']."'"));	
							$status_survey= "<td class=\"$clGaris\" align=center style=\"min-width:50;\">".$ss['nama']."</td>";
						}
						if($Main->TAMPIL_SUSUT){
							$kolTampilSusut = "
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_sisa'],2,',','.')."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_ekonomis'],0,',','.')."</td>
							<td class=\"$clGaris\" align=right>".$isi['nilai_susutpertahun']."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['lama_penggunaan'],0,',','.')."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_susut_sd'],2,',','.')."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_susut_tahun'],2,',','.')."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_buku'],2,',','.')."</td>
							";	
						}
						if($tipe=='kertaskerja'){
							$ListData .= 
							"<tr class='$clRow'  valign='top' >
							<td class=\"$clGaris\" align=center>$no</td>	
							$tampilCheckbox
							<td class=\"$clGaris\" align=center>{$isi['id_barang']}</td>
							<td class=\"$clGaris\" align=center><div class='nfmt3'>{$isi['noreg']}</div></td>
							<td class=\"$clGaris\" align=left>{$isi['nm_barang']}</td>
							<td class=\"$clGaris\" align=left>{$ISI1}</td>
							<td class=\"$clGaris\">{$ISI2}</td>
							<td class=\"$clGaris\" align=left>{$ISI3}</td>
							<td class=\"$clGaris\" align=center>{$ISI4}</td>
							<td class=\"$clGaris\">{$ISI5}</td>
							<td class=\"$clGaris\">{$ISI6}</td>
							<td class=\"$clGaris\">{$ISI7}</td>
							<td class=\"$clGaris\">{$ISI8}</td>
							<td class=\"$clGaris\">{$ISI9}</td>
							<td class=\"$clGaris\" style='width:100'>".$ISI10."<br>/".$ISI10a."<br>/".$ISI11."</td>
							<td class=\"$clGaris\" align=right>".$tampilHarga."</td>
							<td class=\"$clGaris\">$kondisi_kk</td>".	
							"<td class=\"$clGaris\">$nm_no_ruang</td>".	
							"<td class=\"$clGaris\">$ket_kk".'<br>'.$isi['vBidang']."</td>".	
							//$isi['vBidang'].
							$tampilCbxKeranjang.				
							"</tr>";
						}else{
							$ListData .= 
							"<tr class='$clRow'  valign='top' >
							<td class=\"$clGaris\" align=center>$no</td>	
							$tampilCheckbox
							<td class=\"$clGaris\" align=left>{$isi['id_barang']}/<br>{$isi['idbi']}/<br>{$isi['idawal']}</td>
							<td class=\"$clGaris\" align=center><div class='nfmt3'>{$isi['noreg']}</div></td>
							<td class=\"$clGaris\" align=left>{$isi['nm_barang']}</td>
							<td class=\"$clGaris\" align=left>{$ISI1}</td>
							<td class=\"$clGaris\">{$ISI2}</td>
							<td class=\"$clGaris\" align=left>{$ISI3}</td>
							<td class=\"$clGaris\" align=center>{$ISI4}</td>
							<td class=\"$clGaris\">{$ISI5}</td>
							<td class=\"$clGaris\">{$ISI6}</td>
							<td class=\"$clGaris\">{$ISI7}</td>
							<td class=\"$clGaris\">{$ISI8}</td>
							<td class=\"$clGaris\">{$ISI9}</td>
							<td class=\"$clGaris\" style='width:100'>".$ISI10."/<br>".$ISI10a."<br>/".$ISI11."/<br>".$ISI11a."/<br>".$isi['penggunaan']."</td>
							<td class=\"$clGaris\" align=right>".$tampilHarga."</td>
							$vbast
							$vspk
							<td class=\"$clGaris\">{$ISI12}$ketskpd.$ketgbr $ketpenanggungjawab ".'<br>'.$isi['vBidang']."</td>".	
							//$isi['vBidang'].
							$tampilCbxKeranjang.	
							$status_survey.		
							$kolTampilSusut.	
							"</tr>";
						}
						
						
						//$det =Penatausahaan_GetListDet($isi['idbi'], '02',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);			
						//$det =Penatausahaan_GetListDet($isi['idawal'], '02',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,3);			
						if($Main->PENATAUSAHA_VERSI==1){
							$det = $this->GetListDet2($isi['idawal'], '02', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
						}else{
							$det = Penatausahaan_GetListDet2($isi['idawal'], '02', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
						}
						
						$ListData .= $det['ListData'];
						$jmlTotalHargaDisplay += $det['jmlTotalHargaDisplay'];
						$totLuasTanahHal += $isi['luas'];			
					//}
					break;
				}
				case "06" : case "kib_c_cetak" :{					
					
					$idBI = $isi['idbi'];//getIDByKodeBrg('buku_induk', $isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['tahun'].$isi['noreg']);
					//$kota = '<br>'.$isi['alamat_kota'];//getNmWlayah($isi['alamat_a'], $isi['alamat_b']);
					//$Kec = $isi['alamat_kec'];//table_get_value('select alamat_kec from kib_c where concat(a1,a,b,c,d,e,f,g,h,i,j,tahun,noreg) = "'.$isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['tahun'].$isi['noreg'].'"','alamat_kec');				
					//$Kel = $isi['alamat_kel'];//table_get_value('select alamat_kel from kib_c where concat(a1,a,b,c,d,e,f,g,h,i,j,tahun,noreg) = "'.$isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['tahun'].$isi['noreg'].'"','alamat_kel');
					//if($Kec != ''){ $Kec='<br>Kec. '.$Kec;}
					//if($Kel != ''){ $Kel='<br>Kel. '.$Kel;}	
					
					
					
					$jmlTampilKIB_C++;
					$jmlTotalHargaDisplay += $isi['jml_harga'];
					$no++;
					$clRow = ""; if ($cetak == FALSE){$clRow = $no % 2 == 0 ?"row1":"row0"; }		
					$ISI15 = ifempty($isi['ket'],'-');					
					// $ISI15 .= tampilNmSubUnit($isi);			
						if ($txls=='1'){
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, '.', '') : number_format($isi['jml_harga'], 2, '.', '');
							
						} else {
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, ',', '.') : number_format($isi['jml_harga'], 2, ',', '.');
							
						}
					$tampilCheckbox = $cetak ? "":"<td class=\"$clGaris\" align=center><input type=\"checkbox\" $infobrg $Checked  id=\"cb$cb\" name=\"cidBI[]\" value=\"".$idBI."\" onClick=\"isChecked(this.checked);\" /></td>";
					
					$tampilKodeTanah = 
						substr($isi['kode_tanah'],0,12)."<BR>".
						substr($isi['kode_tanah'],12,12)."<BR>".
						substr($isi['kode_tanah'],24,12)."<BR>".
						substr($isi['kode_tanah'],36,4);
					$tampilIdBrg =
						substr($isi['id_barang'],0,9)."<BR>".
						substr($isi['id_barang'],9,5);
						
					
					$ListData .= 
					Penatausahaan_genTableRowKibC($clRow,$clGaris,$tampilCheckbox,
					/*array(	$no,
						$tampilIdBrg,
						$isi['noreg'],
						$isi['nm_barang'],
						$isi['tahun'],
						ifempty($Main->KondisiBarang[$isi['kondisi']-1][1],'-'),//ifempty($Main->KondisiBarang[$isi['kondisi_bi']-1][1],'-'),
						ifempty($Main->Tingkat[$isi['konstruksi_tingkat']-1][1],'-'),
						ifempty($Main->Beton [$isi['konstruksi_beton']-1][1],'-'),
						( empty($isi['luas_lantai']) ? "-": number_format($isi['luas_lantai'],2,',','.') ),
						ifempty($isi['alamat'],'-').$Kel.$Kec.$kota,
						ifemptyTgl( TglInd($isi['dokumen_tgl']),'-').'<br>'.ifempty($isi['dokumen_no'],'-'),
						( empty($isi['luas']) ? "-": number_format($isi['luas'],2, ',', '.' ) ),
						ifempty($Main->StatusTanah[$isi['status_tanah']-1][1],'-'),
						$tampilKodeTanah,
						ifempty($Main->AsalUsul[$isi['asal_usul']-1][1],'-')."<br>/".ifempty($Main->StatusBarang[$isi['status_barang']-1][1],'-'),
						$tampilHarga,
						$ISI15	)*/
						$isi,$no,$tampilCbxKeranjang, $tipe,$ketpenanggungjawab);	
						
					//$det =Penatausahaan_GetListDet($isi['idbi'], '03',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);			
					if($Main->PENATAUSAHA_VERSI==1){
						$det = $this->GetListDet2($isi['idawal'], '03',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox, 1,'', $jns=='penyusutan');
					}else{
						$det = Penatausahaan_GetListDet2($isi['idawal'], '03',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox, 1,'', $jns=='penyusutan');
					}
					
					
					$ListData .= $det['ListData'];
					$jmlTotalHargaDisplay += $det['jmlTotalHargaDisplay'];
					$totLuasTanahHal += $isi['luas'];
					//}
					break;
				}
				case "07" : case "kib_d_cetak" :{									
					
					//$Qry = mysql_query($sqry);
					//$jmlDataKIB_D = table_get_value("select count(*) as cnt from view_kib_d where $Kondisi ",'cnt');// mysql_num_rows($Qry);			
					//$Qry = mysql_query($sqry." $LimitHalKIB_D"); 			
					//$Qry = mysql_query($sqry);			
					//$no=$Main->PagePerHal * (($HalKIB_D*1) - 1);	
					//$cb=0;	$jmlTampilKIB_D = 0;	$jmlTotalHargaDisplay = 0;	$ListData = "";
					//*
					//while ($isi = mysql_fetch_array($Qry)){
					$idBI = $isi['idbi'];// getIDByKodeBrg('buku_induk', $isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['tahun'].$isi['noreg']);// table_get_value( $sidBi, 'id' );
					$kota = '<br>'.$isi['alamat_kota'];//getNmWlayah($isi['alamat_a'], $isi['alamat_b']);
					// $Kec = $isi['alamat_kec'];
					//table_get_value('select alamat_kec from kib_d where concat(a1,a,b,c,d,e,f,g,h,i,j,tahun,noreg) = "'.$isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['tahun'].$isi['noreg'].'"','alamat_kec');
					// $Kel = $isi['alamat_kel'];//table_get_value('select alamat_kel from kib_d where concat(a1,a,b,c,d,e,f,g,h,i,j,tahun,noreg) = "'.$isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['tahun'].$isi['noreg'].'"','alamat_kel');
					/*
					if($Kec != ''){ $Kec='<br>Kec. '.$Kec;}
					if($Kel != ''){ $Kel='<br>Kel. '.$Kel;}	
					*/
					$rj=mysql_fetch_array(mysql_query("select nama from ref_ruas_jalan where Id='{$isi['ref_ruas_jalan']}' and jns='{$isi['jns']}'"));
					//$rj=mysql_fetch_array(mysql_query("select nama from ref_ruas_jalan where Id='{$isi['ref_ruas_jalan']}' and jns='1'"));
					//$di=mysql_fetch_array(mysql_query("select nama from ref_ruas_jalan where Id='{$isi['ref_ruas_jalan']}' and jns='2'"));
					$ruasjalan=($isi['ref_ruas_jalan']=='0')?'':$rj['nama']."/<br>";
					//$drhirigasi=($isi['ref_ruas_jalan']=='0')?'':$di['nama']."/<br>";
					$nm_jembatan = $isi['nm_jembatan']==''?'':$isi['nm_jembatan']."/<br>";
					$nmbarang = $isi['nm_barang'];
					
					$rtrw =  ($isi['rt'] && $isi['rw']) == '' ? '' : "<br>RT/RW. ".$isi['rt']."/".$isi['rw'];
					$kampung = $isi['kampung'] == '' ? '' : "<br>Kp/Komp. ".$isi['kampung'];
					
					$Kec = getalamat($isi['alamat_b'],$isi['alamat_c'],'',$isi['kota'],$isi['alamat_kec'],$isi['alamat_kel']);
					
					$Kel='';
					$kota='';
					$jmlTampilKIB_D++;
					$jmlTotalHargaDisplay += $isi['jml_harga'];
					$no++;
					$clRow =""; 
					if($cetak == FALSE){$clRow = $no % 2 == 0 ?"row1":"row0";}
					$ISI15 = ifempty($isi['ket'],'-');
					//$ISI15 .= '<br>'.$isi['nmbidang'].' - '.$isi['nmopd'].' - '.$isi['nmunit'] ;//tampilNmSubUnit($isi);	
					//$ISI15 .= tampilNmSubUnit($isi);	
						if ($txls=='1'){
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, '.', '') : number_format($isi['jml_harga'], 2, '.', '');
							
						} else {
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, ',', '.') : number_format($isi['jml_harga'], 2, ',', '.');
							
						}
					$dok = $isi['dokumen_file']=="" ? "" : dokumenlink($isi['dokumen_file'], $isi['dokumen']);
					//ambil data ref status survey
					if($Main->STATUS_SURVEY==1){
						$ss = mysql_fetch_array(mysql_query("select * from ref_statusbarang2 where Id='".$isi['ref_idstatussurvey']."'"));	
						$status_survey= "<td class=\"$clGaris\" align=center style=\"min-width:50;\">".$ss['nama']."</td>";	
					}
					if($Main->TAMPIL_SUSUT==1){
						$kolTampilSusut = "
						<td class=\"$clGaris\" align=right>".number_format($isi['nilai_sisa'],2,',','.')."</td>
						<td class=\"$clGaris\" align=right>".number_format($isi['nilai_ekonomis'],0,',','.')."</td>
						<td class=\"$clGaris\" align=right>".$isi['nilai_susutpertahun']."</td>
						<td class=\"$clGaris\" align=right>".number_format($isi['lama_penggunaan'],0,',','.')."</td>
						<td class=\"$clGaris\" align=right>".number_format($isi['nilai_susut_sd'],2,',','.')."</td>
						<td class=\"$clGaris\" align=right>".number_format($isi['nilai_susut_tahun'],2,',','.')."</td>
						<td class=\"$clGaris\" align=right>".number_format($isi['nilai_buku'],2,',','.')."</td>
						";	
					}
					$tampilDok = '';//$cetak? "" : "<td class=\"$clGaris\">$dok</td>"; 
					$tampilCheckbox = $cetak ? "":"<td class=\"$clGaris\" align=center><input type=\"checkbox\" $infobrg $Checked  id=\"cb$cb\" name=\"cidBI[]\" value=\"".$idBI."\" onClick=\"isChecked(this.checked);\" /></td>";
					$tampilKodeTanah = $isi['kode_tanah']."<BR>".$isi['kode_loktanah'];//$tampilKodeTanah = ifempty($isi['kode_tanah'],'-');	
					if($tipe=='kertaskerja'){	
						$ListData .= "	
							<tr class='$clRow'  valign='top' >
							<td class=\"$clGaris\" align=center>$no</td>
							$tampilCheckbox
							<td class=\"$clGaris\" align=center>{$isi['id_barang']}</td>
							<td class=\"$clGaris\" align=center><div class='nfmt3'>{$isi['noreg']}/<br>{$isi['no_barang']}</div></td>
							<td class=\"$clGaris\" >".$ruasjalan.$nm_jembatan.$nmbarang."</td>
							<td class=\"$clGaris\" >{$isi['tahun']}</td>
							<td class=\"$clGaris\" >".ifempty($isi['konstruksi'],'-')."</td>
							<td class=\"$clGaris\" align=center>". (empty($isi['panjang'])? '-': number_format($isi['panjang'],2,',','.'))."</td>
							<td class=\"$clGaris\" align=center>".(empty($isi['lebar'])?'-':number_format($isi['lebar'],2,',','.'))."</td>
							<td class=\"$clGaris\" align=center>".(empty($isi['luas'])?'-':number_format($isi['luas'],2,',','.'))."</td>
							<td class=\"$clGaris\" >".ifempty($isi['alamat'],'-').$rtrw.$kampung.$Kel.$Kec.$kota."</td>
							<td class=\"$clGaris\" align=center >".ifemptyTgl(TglInd($isi['dokumen_tgl']),'-')."</td>
							<td class=\"$clGaris\">".ifempty($isi['dokumen_no'],'-')."</td>
							<td class=\"$clGaris\" align=center>".ifempty($Main->StatusTanah[$isi['status_tanah']-1][1],'-')."</td>
							<td class=\"$clGaris\" align=center>".ifempty($isi['kode_tanah'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($Main->AsalUsul[$isi['asal_usul']-1][1],'-')."<br>/".
							ifempty($jnshibah,'-')."<br>/".
							ifempty($Main->StatusBarang[$isi['status_barang']-1][1],'-')."</td>
							
							<td class=\"$clGaris\" align=right >".$tampilHarga."</td>
							
							<td class=\"$clGaris\">$kondisi_kk</td>".	
							"<td class=\"$clGaris\"  style='min-width:120'>$status_penguasaan</td>".	
							"<td class=\"$clGaris\" style=''>$ket_kk.".'<br>'.$isi['vBidang']."</td>".	
							$tampilDok.
							//$isi['vBidang'].
							$tampilCbxKeranjang.
							"</tr>
							";
					}else{
						$ListData .= "	
							<tr class='$clRow'  valign='top' >
							<td class=\"$clGaris\" align=center>$no</td>
							$tampilCheckbox
							<td class=\"$clGaris\" align=left>{$isi['id_barang']}/<br>{$isi['idbi']}/<br>{$isi['idawal']}</td>
							<td class=\"$clGaris\" align=center><div class='nfmt3'>{$isi['noreg']}/<br>{$isi['no_barang']}</div></td>
							<td class=\"$clGaris\" >".$ruasjalan.$nm_jembatan.$nmbarang."</td>
							<td class=\"$clGaris\" >{$isi['tahun']}</td>
							<td class=\"$clGaris\" >".ifempty($isi['konstruksi'],'-')."</td>
							<td class=\"$clGaris\" align=center>". (empty($isi['panjang'])? '-': number_format($isi['panjang'],2,',','.'))."</td>
							<td class=\"$clGaris\" align=center>".(empty($isi['lebar'])?'-':number_format($isi['lebar'],2,',','.'))."</td>
							<td class=\"$clGaris\" align=center>".(empty($isi['luas'])?'-':number_format($isi['luas'],2,',','.'))."</td>
							<td class=\"$clGaris\" >".ifempty($isi['alamat'],'-').$rtrw.$kampung.$Kel.$Kec.$kota."</td>
							<td class=\"$clGaris\" align=center >".ifemptyTgl(TglInd($isi['dokumen_tgl']),'-')."</td>
							<td class=\"$clGaris\">".ifempty($isi['dokumen_no'],'-')."</td>
							<td class=\"$clGaris\" align=center>".ifempty($Main->StatusTanah[$isi['status_tanah']-1][1],'-')."</td>
							<td class=\"$clGaris\" align=center>".ifempty($isi['kode_tanah'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($Main->AsalUsul[$isi['asal_usul']-1][1],'-')."/<br>".
							ifempty($jnshibah,'-')."<br>/".
							ifempty($Main->StatusBarang[$isi['status_barang']-1][1],'-').
							"/<br>".ifempty( $Main->KondisiBarang[$isi['kondisi']-1][1], '-').
							"/<br>".ifempty($isi['penggunaan'],'-').
							"</td>
							<td class=\"$clGaris\" >".ifempty($Main->KondisiBarang[$isi['kondisi_bi']-1][1],'-')."</td>
							<td class=\"$clGaris\" align=right >".$tampilHarga."</td>
							$vbast
							$vspk
							<td class=\"$clGaris\">".$ISI15.$ketgbr.$ketpenanggungjawab.'<br>'.$isi['vBidang']."</td>".
							$tampilDok.
							//$isi['vBidang'].
							$tampilCbxKeranjang.
							$status_survey.
							$kolTampilSusut.
							"</tr>
							";
					}
							
					//$det =Penatausahaan_GetListDet($isi['idbi'], '04',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);			
					//$det =Penatausahaan_GetListDet($isi['idawal'], '04',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,3);			
					if($Main->PENATAUSAHA_VERSI==1){
						$det = $this->GetListDet2($isi['idawal'], '04', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'',  $jns=='penyusutan' );
					}else{
						$det = Penatausahaan_GetListDet2($isi['idawal'], '04', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'',  $jns=='penyusutan' );
					}
					
					$ListData .= $det['ListData'];
					$jmlTotalHargaDisplay += $det['jmlTotalHargaDisplay'];
					$totLuasTanahHal += $isi['luas'];
						//	$cb++;
					//}
					//*/
					break;
				}
				case "08" : case "kib_e_cetak" :{			
					//$Qry = mysql_query($sqry);
					//$jmlDataKIB_E = table_get_value("select count(*) as cnt from view_kib_e where $Kondisi ",'cnt');//mysql_num_rows($Qry);
					//$Qry = mysql_query($sqry." $LimitHalKIB_E");
					//$no=$Main->PagePerHal * (($HalKIB_E*1) - 1);
					//$cb=0;	$jmlTampilKIB_E = 0;	$jmlTotalHargaDisplay = 0;		$ListData = "";
					//while ($isi = mysql_fetch_array($Qry)){
						$idBI = $isi['idbi'];//getIDByKodeBrg('buku_induk', $isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['tahun'].$isi['noreg']);// table_get_value( $sidBi, 'id' );
						$jmlTampilKIB_E++;
						$jmlTotalHargaDisplay += $isi['jml_harga'];
						$no++;
					$clRow =""; if($cetak == FALSE){$clRow = $no % 2 == 0 ?"row1":"row0";}
						$ISI15 = ifempty($isi['ket'],'-');
						//$ISI15 .= '<br>'.$isi['nmbidang'].' - '.$isi['nmopd'].' - '.$isi['nmunit'] ;//tampilNmSubUnit($isi);			
						//$ISI15 .= tampilNmSubUnit($isi);	
						if ($txls=='1'){
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, '.', '') : number_format($isi['jml_harga'], 2, '.', '');
							
						} else {
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, ',', '.') : number_format($isi['jml_harga'], 2, ',', '.');
							
						}	
						//ambil data ref status survey
						if($Main->STATUS_SURVEY==1 ){
							$ss = mysql_fetch_array(mysql_query("select * from ref_statusbarang2 where Id='".$isi['ref_idstatussurvey']."'"));	
							$status_survey= "<td class=\"$clGaris\" align=center style=\"min-width:50;\">".$ss['nama']."</td>";	
						}						
						if($Main->TAMPIL_SUSUT==1){
							$kolTampilSusut = "
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_sisa'],2,',','.')."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_ekonomis'],0,',','.')."</td>
							<td class=\"$clGaris\" align=right>".$isi['nilai_susutpertahun']."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['lama_penggunaan'],0,',','.')."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_susut_sd'],2,',','.')."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_susut_tahun'],2,',','.')."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_buku'],2,',','.')."</td>
							";	
						}						
						if($tipe=='kertaskerja'){			
							//$dok = $isi['dokumen_file']=="" ? "" : dokumenlink($isi['dokumen_file'], $isi['dokumen']);
							//$tampilDok = '';//$cetak? "" : "<td class=\"$clGaris\">$dok</td>"; 
							$tampilCheckbox = $cetak ? "":"<td class=\"$clGaris\" align=center><input type=\"checkbox\" $infobrg $Checked  id=\"cb$cb\" name=\"cidBI[]\" value=\"".$idBI."\" onClick=\"isChecked(this.checked);\" /></td>";
							$ListData .= "	
							<tr class='$clRow'  valign='top'>
							<td class=\"$clGaris\" align=center>$no</td>
							$tampilCheckbox
							<td class=\"$clGaris\" align=center>{$isi['id_barang']}</td>
							<td class=\"$clGaris\" align=center><div class='nfmt3'>{$isi['noreg']}</div></td>
							<td class=\"$clGaris\" >{$isi['nm_barang']}</td>
							<!--<td class=\"$clGaris\" style=''>{$isi['tahun']}</td>-->
							<td class=\"$clGaris\" >".ifempty($isi['buku_judul'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['buku_spesifikasi'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['seni_asal_daerah'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['seni_pencipta'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['seni_bahan'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['hewan_jenis'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['hewan_ukuran'],'-')."</td>
							<td class=\"$clGaris\" align=center>".ifempty($isi['jml_barang'],'0')."</td>
							<td class=\"$clGaris\" align=center>".ifempty($isi['thn_perolehan'],'-')."</td>
							<td class=\"$clGaris\">".ifempty($Main->AsalUsul[$isi['asal_usul']-1][1],'-')."<br>/".
							ifempty($jnshibah,'-')."<br>/".
							ifempty($Main->StatusBarang[$isi['status_barang']-1][1],'-')."<br>/".
							ifempty( $Main->KondisiBarang[$isi['kondisi']-1][1], '-').							
							"</td>
							<td class=\"$clGaris\" align=right >".$tampilHarga."</td>
							<td class=\"$clGaris\">$kondisi_kk</td>".									
							"<td class=\"$clGaris\" style=''>$ket_kk".'<br>'.$isi['vBidang']."</td>".	
							$tampilDok.
							//$isi['vBidang'].
							$tampilCbxKeranjang.
							"</tr>
							";
							//$det =Penatausahaan_GetListDet($isi['idbi'], '05',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);			
							//$det =Penatausahaan_GetListDet($isi['idawal'], '05',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);			
							if($Main->PENATAUSAHA_VERSI==1){
								$det = $this->GetListDet2($isi['idawal'], '05', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
							}else{
								$det = Penatausahaan_GetListDet2($isi['idawal'], '05', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
							}
							
							$ListData .= $det['ListData'];
							$jmlTotalHargaDisplay += $det['jmlTotalHargaDisplay'];
							$totLuasTanahHal += $isi['luas'];
						}else{

							//$dok = $isi['dokumen_file']=="" ? "" : dokumenlink($isi['dokumen_file'], $isi['dokumen']);
							//$tampilDok = '';//$cetak? "" : "<td class=\"$clGaris\">$dok</td>"; 
							$tampilCheckbox = $cetak ? "":"<td class=\"$clGaris\" align=center><input type=\"checkbox\" $infobrg $Checked  id=\"cb$cb\" name=\"cidBI[]\" value=\"".$idBI."\" onClick=\"isChecked(this.checked);\" /></td>";
							$ListData .= "	
							<tr class='$clRow'  valign='top'>
							<td class=\"$clGaris\" align=center>$no</td>
							$tampilCheckbox
							<td class=\"$clGaris\" align=left>{$isi['id_barang']}/<br>{$isi['idbi']}/<br>{$isi['idawal']}</td>
							<td class=\"$clGaris\" align=center><div class='nfmt3'>{$isi['noreg']}</div></td>
							<td class=\"$clGaris\" >{$isi['nm_barang']}</td>
							<!--<td class=\"$clGaris\" style=''>{$isi['tahun']}</td>-->
							<td class=\"$clGaris\" >".ifempty($isi['buku_judul'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['buku_spesifikasi'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['seni_asal_daerah'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['seni_pencipta'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['seni_bahan'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['hewan_jenis'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['hewan_ukuran'],'-')."</td>
							<td class=\"$clGaris\" align=center>".ifempty($isi['jml_barang'],'0')."</td>
							<td class=\"$clGaris\" align=center>".ifempty($isi['thn_perolehan'],'-')."</td>
							<td class=\"$clGaris\">".ifempty($Main->AsalUsul[$isi['asal_usul']-1][1],'-')."/<br>".
							ifempty($jnshibah,'-')."<br>/".
							ifempty($Main->StatusBarang[$isi['status_barang']-1][1],'-')."/<br>".
							ifempty( $Main->KondisiBarang[$isi['kondisi']-1][1], '-').
							"/<br>".ifempty($isi['penggunaan'],'-').
							"</td>
							<td class=\"$clGaris\" align=right >".$tampilHarga."</td>
							$vbast
							$vspk
							<td class=\"$clGaris\">".$ISI15.$ketgbr.$ketpenanggungjawab.'<br>'.$isi['vBidang']."</td>".
							$tampilDok.
							//$isi['vBidang'].
							$tampilCbxKeranjang.
							$status_survey.
							$kolTampilSusut.							
							"</tr>
							";
							//$det =Penatausahaan_GetListDet($isi['idbi'], '05',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);			
							//$det =Penatausahaan_GetListDet($isi['idawal'], '05',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);			
							if($Main->PENATAUSAHA_VERSI==1){
								$det = $this->GetListDet2($isi['idawal'], '05', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
							}else{
								$det = Penatausahaan_GetListDet2($isi['idawal'], '05', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
							}
							
							$ListData .= $det['ListData'];
							$jmlTotalHargaDisplay += $det['jmlTotalHargaDisplay'];
							$totLuasTanahHal += $isi['luas'];
						}
					//}
					break;
				}
				case "09" : case "kib_f_cetak" :{
					//$Qry = mysql_query($sqry);
					//$jmlDataKIB_F = table_get_value("select count(*) as cnt from view_kib_f where $Kondisi ",'cnt');//mysql_num_rows($Qry);
					//$Qry = mysql_query($sqry." $LimitHalKIB_F");
					//$ISI15 = ifempty($isi['ket'],'-');
					//$ISI15 .= '<br>'.$isi['nmbidang'].' - '.$isi['nmopd'].' - '.$isi['nmunit'] ;
					//$no=$Main->PagePerHal * (($HalKIB_F*1) - 1);
					//$cb=0;			
					//$jmlTampilKIB_F = 0;
					//$jmlTotalHargaDisplay = 0;
					//$ListData = "";
					//while ($isi = mysql_fetch_array($Qry)){
						$idBI = $isi['idbi'];//getIDByKodeBrg('buku_induk', $isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['tahun'].$isi['noreg']);
//						$kota =  '<br>'.$isi['alamat_kota'];//'<br>'.getNmWlayah($isi['alamat_a'], $isi['alamat_b']);
//						$Kec = $isi['alamat_kec'];//table_get_value('select alamat_kec from kib_f where concat(a1,a,b,c,d,e,f,g,h,i,j,tahun,noreg) = "'.$isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['tahun'].$isi['noreg'].'"','alamat_kec');
//						$Kel = $isi['alamat_kel'];//table_get_value('select alamat_kel from kib_f where concat(a1,a,b,c,d,e,f,g,h,i,j,tahun,noreg) = "'.$isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['tahun'].$isi['noreg'].'"','alamat_kel');
//					if($Kec != ''){ $Kec='<br>Kec. '.$Kec;}
//						if($Kel != ''){ $Kel='<br>Kel. '.$Kel;}	
					
					$rtrw =  ($isi['rt'] && $isi['rw']) == '' ? '' : "<br>RT/RW. ".$isi['rt']."/".$isi['rw'];
					$kampung = $isi['kampung'] == '' ? '' : "<br>Kampung/Komp. ".$isi['kampung'];
					
					$Kec = getalamat($isi['alamat_b'],$isi['alamat_c'],'',$isi['kota'],$isi['alamat_kec'],$isi['alamat_kel']);
					
					$Kel='';
					$kota='';						
						$jmlTampilKIB_F++;
						$jmlTotalHargaDisplay += $isi['jml_harga'];
						$no++;
					$clRow =""; if($cetak == FALSE){$clRow = $no % 2 == 0 ?"row1":"row0";}
						$ISI15 = ifempty($isi['ket'],'-');
						//$ISI15 .='<br>'.$isi['nmbidang'].' - '.$isi['nmopd'].' - '.$isi['nmunit'] ;// tampilNmSubUnit($isi);	
						//$ISI15 .= tampilNmSubUnit($isi);	
						if ($txls=='1'){
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, '.', '') : number_format($isi['jml_harga'], 2, '.', '');
							
						} else {
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, ',', '.') : number_format($isi['jml_harga'], 2, ',', '.');
							
						}
						//ambil data ref status survey
						if($Main->STATUS_SURVEY==1 ){
							$ss = mysql_fetch_array(mysql_query("select * from ref_statusbarang2 where Id='".$isi['ref_idstatussurvey']."'"));	
							$status_survey= "<td class=\"$clGaris\" align=center style=\"min-width:50;\">".$ss['nama']."</td>";
						}
						
						//	$dok = $isi['dokumen_file']=="" ? "" : dokumenlink($isi['dokumen_file'], $isi['dokumen']);
						//	$tampilDok = '';//$cetak? "" : "<td class=\"$clGaris\">$dok</td>"; 				
						$tampilCheckbox = $cetak ? "":"<td class=\"$clGaris\" align=center><input type=\"checkbox\" $infobrg $Checked  id=\"cb$cb\" name=\"cidBI[]\" value=\"".$idBI."\" onClick=\"isChecked(this.checked);\" /></td>";
						$ListData .= "	
						<tr class='$clRow'  valign='top'>
						<td class=\"$clGaris\" align=center>$no</td>
						$tampilCheckbox
						<!--<td class=\"$clGaris\" align=center><input type=\"checkbox\" $infobrg $Checked  id=\"cb$cb\" name=\"cidBI[]\" value=\"".$idBI."\" onClick=\"isChecked(this.checked);\" /></td>-->
						<td class=\"$clGaris\" align=left>{$isi['id_barang']}/<br>{$isi['idbi']}/<br>{$isi['idawal']}</td>
						<td class=\"$clGaris\" align=center><div class='nfmt3'>{$isi['noreg']}</div></td>
						<td class=\"$clGaris\" align=left>{$isi['nm_barang']}</td>
						<td class=\"$clGaris\" >{$isi['tahun']}</td>
						<td class=\"$clGaris\" align=left>".ifempty($Main->Bangunan[$isi['bangunan']-1][1],'-')."</td>
						<td class=\"$clGaris\" align=left>".ifempty($Main->Tingkat[$isi['konstruksi_tingkat']-1][1],'-')."</td>
						<td class=\"$clGaris\" align=left>".ifempty($Main->Beton[$isi['konstruksi_beton']-1][1],'-')."</td>
						<td class=\"$clGaris\" align=center>".(empty($isi['luas'])? '-': number_format($isi['luas'],2,',','.'))."</td>
						<td class=\"$clGaris\" >".ifempty($isi['alamat'],'-').$rtrw.$kampung.$Kel.$Kec.$kota."</td>
						<td class=\"$clGaris\" align=center>".ifemptyTgl(TglInd($isi['dokumen_tgl']),'-')."</td>
						<td class=\"$clGaris\" >".ifempty($isi['dokumen_no'],'-')."</td>
						<td class=\"$clGaris\" align=center>".ifemptyTgl(TglInd($isi['tmt']),'-')."</td>
						<td class=\"$clGaris\" align=center>".ifempty($Main->StatusTanah[$isi['status_tanah']-1][1],'-')."</td>
						<td class=\"$clGaris\" align=center>".ifempty($isi['kode_tanah'],'-')."</td>
						<td class=\"$clGaris\" >".ifempty($Main->AsalUsul[$isi['asal_usul']-1][1],'-')."/<br>".			
						ifempty($jnshibah,'-')."<br>/".
						ifempty($Main->StatusBarang[$isi['status_barang']-1][1],'-')."/<br>".
						ifempty( $Main->KondisiBarang[$isi['kondisi']-1][1], '-').
						"/<br>".ifempty($isi['penggunaan'],'-').
						"</td>
						<td class=\"$clGaris\" align=right>".$tampilHarga."</td>
						$vbast
						$vspk
						<td class=\"$clGaris\">".$ISI15.$ketgbr.$ketpenanggungjawab.$isi['vBidang']."</td>
						<!--<td class=\"$clGaris\">$dok</td>-->
						$tampilDok
						$tampilCbxKeranjang
						$status_survey						
						</tr>";
						
						//$det =Penatausahaan_GetListDet($isi['idbi'], '06',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);			
						//$det =Penatausahaan_GetListDet($isi['idawal'], '06',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);			
						if($Main->PENATAUSAHA_VERSI==1){
							$det = $this->GetListDet2($isi['idawal'], '06', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
						}else{
							$det = Penatausahaan_GetListDet2($isi['idawal'], '06', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
						}
						
						$ListData .= $det['ListData'];
						$jmlTotalHargaDisplay += $det['jmlTotalHargaDisplay'];
						
						$totLuasTanahHal += $isi['luas'];
					//}
					break;
				}
				case "kibg" : case "kib_g_cetak" :{			
					//$Qry = mysql_query($sqry);
					//$jmlDataKIB_E = table_get_value("select count(*) as cnt from view_kib_e where $Kondisi ",'cnt');//mysql_num_rows($Qry);
					//$Qry = mysql_query($sqry." $LimitHalKIB_E");
					//$no=$Main->PagePerHal * (($HalKIB_E*1) - 1);
					//$cb=0;	$jmlTampilKIB_G = 0;	$jmlTotalHargaDisplay = 0;		$ListData = "";
					//while ($isi = mysql_fetch_array($Qry)){
						$idBI = $isi['idbi'];//getIDByKodeBrg('buku_induk', $isi['a1'].$isi['a'].$isi['b'].$isi['c'].$isi['d'].$isi['e'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['tahun'].$isi['noreg']);// table_get_value( $sidBi, 'id' );
						$jmlTampilKIB_G++;
						$jmlTotalHargaDisplay += $isi['jml_harga'];
						$no++;
					$clRow =""; if($cetak == FALSE){$clRow = $no % 2 == 0 ?"row1":"row0";}
						$ISI15 = ifempty($isi['ket'],'-');
						//$ISI15 .= '<br>'.$isi['nmbidang'].' - '.$isi['nmopd'].' - '.$isi['nmunit'] ;//tampilNmSubUnit($isi);			
						// $ISI15 .= tampilNmSubUnit($isi);	
						if ($txls=='1'){
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, '.', '') : number_format($isi['jml_harga'], 2, '.', '');
							
						} else {
						$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['jml_harga']/1000, 2, ',', '.') : number_format($isi['jml_harga'], 2, ',', '.');
							
						}	
						//ambil data ref status survey
						if($Main->STATUS_SURVEY==1 ){
							$ss = mysql_fetch_array(mysql_query("select * from ref_statusbarang2 where Id='".$isi['ref_idstatussurvey']."'"));	
							$status_survey= "<td class=\"$clGaris\" align=center style=\"min-width:50;\">".$ss['nama']."</td>";
						}
						if($Main->TAMPIL_SUSUT){
							$kolTampilSusut = "
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_sisa'],2,',','.')."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_ekonomis'],0,',','.')."</td>
							<td class=\"$clGaris\" align=right>".$isi['nilai_susutpertahun']."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['lama_penggunaan'],0,',','.')."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_susut_sd'],2,',','.')."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_susut_tahun'],2,',','.')."</td>
							<td class=\"$clGaris\" align=right>".number_format($isi['nilai_buku'],2,',','.')."</td>
							";	
						}					
						if($tipe=='kertaskerja'){			
							//$dok = $isi['dokumen_file']=="" ? "" : dokumenlink($isi['dokumen_file'], $isi['dokumen']);
							//$tampilDok = '';//$cetak? "" : "<td class=\"$clGaris\">$dok</td>"; 
							$tampilCheckbox = $cetak ? "":"<td class=\"$clGaris\" align=center><input type=\"checkbox\" $infobrg $Checked  id=\"cb$cb\" name=\"cidBI[]\" value=\"".$idBI."\" onClick=\"isChecked(this.checked);\" /></td>";
							$ListData .= "	
							<tr class='$clRow'  valign='top'>
							<td class=\"$clGaris\" align=center>$no</td>
							$tampilCheckbox
							<td class=\"$clGaris\" align=center>{$isi['id_barang']}</td>
							<td class=\"$clGaris\" align=center><div class='nfmt3'>{$isi['noreg']}</div></td>
							<td class=\"$clGaris\" >{$isi['nm_barang']}</td>
							<!--<td class=\"$clGaris\" style=''>{$isi['tahun']}</td>-->
							<td class=\"$clGaris\" >".ifempty($isi['uraian'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['pencipta'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['jenis'],'-')."</td>
							<td class=\"$clGaris\" align=center>".ifempty($isi['jml_barang'],'0')."</td>
							<td class=\"$clGaris\" align=center>".ifempty($isi['thn_perolehan'],'-')."</td>
							<td class=\"$clGaris\">".ifempty($Main->AsalUsul[$isi['asal_usul']-1][1],'-')."/<br>".
							ifempty($jnshibah,'-')."<br>/".
							ifempty($Main->StatusBarang[$isi['status_barang']-1][1],'-')."/<br>".
							ifempty( $Main->KondisiBarang[$isi['kondisi']-1][1], '-').
							
							"</td>
							<td class=\"$clGaris\" align=right >".$tampilHarga."</td>
							<td class=\"$clGaris\">$kondisi_kk</td>".									
							"<td class=\"$clGaris\" style=''>$ket_kk".'<br>'.$isi['vBidang']."</td>".	
							$tampilDok.
							//$isi['vBidang'].
							$tampilCbxKeranjang.
							"</tr>
							";
							//$det =Penatausahaan_GetListDet($isi['idbi'], '05',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);			
							//$det =Penatausahaan_GetListDet($isi['idawal'], '07',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);			
							if($Main->PENATAUSAHA_VERSI==1){
								$det = $this->GetListDet2($isi['idawal'], '07', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
							}else{
								$det = Penatausahaan_GetListDet2($isi['idawal'], '07', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
							}
							
							$ListData .= $det['ListData'];
							$jmlTotalHargaDisplay += $det['jmlTotalHargaDisplay'];
							$totLuasTanahHal += $isi['luas'];
						}else{

							//$dok = $isi['dokumen_file']=="" ? "" : dokumenlink($isi['dokumen_file'], $isi['dokumen']);
							//$tampilDok = '';//$cetak? "" : "<td class=\"$clGaris\">$dok</td>"; 
							$tampilCheckbox = $cetak ? "":"<td class=\"$clGaris\" align=center><input type=\"checkbox\" $infobrg $Checked  id=\"cb$cb\" name=\"cidBI[]\" value=\"".$idBI."\" onClick=\"isChecked(this.checked);\" /></td>";
							$ListData .= "	
							<tr class='$clRow'  valign='top'>
							<td class=\"$clGaris\" align=center>$no</td>
							$tampilCheckbox
							<td class=\"$clGaris\" align=left>{$isi['id_barang']}/<br>{$isi['idbi']}/<br>{$isi['idawal']}</td>
							<td class=\"$clGaris\" align=center><div class='nfmt3'>{$isi['noreg']}</div></td>
							<td class=\"$clGaris\" >{$isi['nm_barang']}</td>
							<td class=\"$clGaris\" style=''>{$isi['tahun']}</td>
							<td class=\"$clGaris\" >{$isi['uraian']}</td>
							<td class=\"$clGaris\" >".ifempty($isi['pencipta'],'-')."</td>
							<td class=\"$clGaris\" >".ifempty($isi['jenis'],'-')."</td>
							<!--<td class=\"$clGaris\" >".ifempty($isi['kerjasama_nama'],'-')."</td>-->
							<td class=\"$clGaris\" align=center>".ifempty($isi['jml_barang'],'0')."</td>
							<td class=\"$clGaris\">".ifempty($Main->AsalUsul[$isi['asal_usul']-1][1],'-')."/<br>".
							ifempty($jnshibah,'-')."<br>/".
							ifempty($Main->StatusBarang[$isi['status_barang']-1][1],'-')."/<br>".
							ifempty( $Main->KondisiBarang[$isi['kondisi']-1][1], '-').
							"/<br>".ifempty($isi['penggunaan'],'-').
							"</td>
							<td class=\"$clGaris\" align=right >".$tampilHarga."</td>
							$vbast
							$vspk
							<td class=\"$clGaris\">".$ISI15.$ketgbr.$ketpenanggungjawab.'<br>'.$isi['vBidang']."</td>".
							$tampilDok.
							//$isi['vBidang'].
							$tampilCbxKeranjang.
							$status_survey.	
							$kolTampilSusut.							
							"</tr>
							";
							//$det =Penatausahaan_GetListDet($isi['idbi'], '05',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);			
							//$det =Penatausahaan_GetListDet($isi['idawal'], '07',$isi['jml_harga'], $cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox);			
							if($Main->PENATAUSAHA_VERSI==1){
								$det = $this->GetListDet2($isi['idawal'], '07', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
							}else{
								$det = Penatausahaan_GetListDet2($isi['idawal'], '07', $isi['jml_harga'],$cetak, $cbxDlmRibu,$clRow, $clGaris, $tampilCheckbox,1,'', $jns=='penyusutan');
							}
							
							$ListData .= $det['ListData'];
							$jmlTotalHargaDisplay += $det['jmlTotalHargaDisplay'];
							$totLuasTanahHal += $isi['luas'];
						}
					//}
					break;
				}
				
			}
			
			if( ($cetak ) && ($cb % $MaxFlush==0) && $cb >0 ){				
				echo $ListData;
				ob_flush();
				flush();
				$ListData='';	//sleep(2); //tes
			}
			
			$cb++;
			
			
		}	
		//--- TOTAL ----------------------------------------
		$noSumhal = $_REQUEST['noSumhal'];
		if ($noSumhal=='1')
		{
			
		} else {
			
		$img = "<img src='images/wait.gif' height='16'>"; //loading tampil total
		// $jmlTotalHarga=0;		
		switch($SPg){
			case '04':case "kib_a_cetak" :{
				if($tipe=='kertaskerja'){ 
					$ListData .= $this->tampilTotalA_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 13, 4, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);				
				}else{
					$ListData .= $this->tampilTotalA_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 13, 1, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
					
				}
				break;
			}
			case '05':case "kib_b_cetak" :{
				if($tipe=='kertaskerja'){ 
					$ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 15, 4, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
				}else{
					$ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 15, 1, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah,
						$totalSusutPrevHal2,
						$totalSusutSkrHal2,
						$totalNilaiBukuHal2
					);
				}
				break;
			}
			case '06':case "kib_c_cetak" :{
				if($tipe=='kertaskerja'){ 
					$ListData .= $this->tampilTotalC_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 16, 4, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
				}else{
					$ListData .= $this->tampilTotalC_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 16, 1, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah,
						$totalSusutPrevHal2,
						$totalSusutSkrHal2,
						$totalNilaiBukuHal2
					);
				}
				break;
			}
			case '07':case "kib_d_cetak" :{
				if($tipe=='kertaskerja'){ 
					$ListData .= $this->tampilTotalD_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 16, 4, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah, 6);
				}else{
					$ListData .= $this->tampilTotalD_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 17, 1, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah, 7,
						$totalSusutPrevHal2,
						$totalSusutSkrHal2,
						$totalNilaiBukuHal2
					);
				}
				break;
			}
			case '08':case "kib_e_cetak" :{
				$ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 15, 1, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah,
					$totalSusutPrevHal2,
					$totalSusutSkrHal2,
					$totalNilaiBukuHal2			
				);
				break;
			}
			case '09':case "kib_f_cetak" :{
				$ListData .= $this->tampilTotalF_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 17, 1, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
				break;
			}
			case 'kibg':case "kib_g_cetak" :{
				$ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu,11, 1, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
				break;
			}

			case 'belumsensus': {
				
				if($tipe=='kertaskerja'){
					
				}else{
					//if($Main->STATUS_SURVEY){
					//	$ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 13, 4, $clGaris, '', $img);	
					//}else{
						$ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 13, 3, $clGaris, '', $img);					
					//}
				}
				
				break;
			}
			default: {
				$jns=$_REQUEST['jns'];
			
				if($jns=='penyusutan' && $Main->PENYUSUTAN){
					$ListData .= $this->tampilTotalSusut($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 12, 2, $clGaris, '', $img,
						$totalSusutPrevHal,	$totalSusutSkrHal
						, $totalSusutTotHal
						, $totalNilaiBukuHal
					);
					
				}else{
					/*if($Main->STATUS_SURVEY){
						$ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 13, 2, $clGaris, '', $img,
							$totalSusutPrevHal2,
							$totalSusutSkrHal2,
							$totalNilaiBukuHal2
						);
					}else{*/
						$ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 12, 1, $clGaris, '', $img,
							$totalSusutPrevHal2,
							$totalSusutSkrHal2,
							$totalNilaiBukuHal2
						);
					//}
				}
			}
		}
		
		}			
		$cek='';//
		
		$yesSum = $_REQUEST['yesSum'];
		if ($yesSum=='1')
		{
		$Qrysum = mysql_query($sqrysum);
		$cb=0;  $totLuasTanahHal = 0;
		$jmlTotalHargaDisplay = 0;
		 // $ListData = "";
		
		while($isisum=mysql_fetch_array($Qrysum)){
		
			if ($no==$isisum['jml']){
				$jmlTotalHarga=0;	
				
				switch($SPg){
					case "KIP" :{  break; }
					case "KIR" :{  break; }
					case "belumsensus" :{  break; }
					case "03" : case "listbi_cetak" :{  break; }
					case "04" : case "kib_a_cetak" :{ $kondf= " and f='01' "; break; }
					case "05" : case "kib_b_cetak" :{ $kondf= " and f='02' "; break; }
					case "06" : case "kib_c_cetak" :{ $kondf= " and f='03' "; break; }
					case "07" : case "kib_d_cetak": { $kondf= " and f='04' "; break; }
					case "08" : case "kib_e_cetak": { $kondf= " and f='05' "; break; }
					case "09" : case "kib_f_cetak": { $kondf= " and f='06' "; break; }
					case "kibg" : case "kib_g_cetak": { $kondf= " and f='07' ";  break; }
					default :  break;
				}	
				$tot_ = 0;
				//pemeliharaan
				$aqry = "select sum(biaya_pemeliharaan) as tot from pemeliharaan where tambah_aset = 1 and idbi_awal in(select idawal from buku_induk  $Kondisi  $kondf );"; $cek .= $aqry;
				$get = mysql_fetch_array(mysql_query($aqry));
				$tot_ += $get['tot'];								
				//pengamanan
				$aqry = "select sum(biaya_pengamanan) as tot from pengamanan where tambah_aset = 1 and idbi_awal in(select idawal from buku_induk  $Kondisi  $kondf );"; $cek .= $aqry;
				$get = mysql_fetch_array(mysql_query($aqry));
				$tot_ += $get['tot'];
				//hapus sebagian
				$aqry = "select sum(harga_hapus) as tot from penghapusan_sebagian where  idbi_awal in(select idawal from buku_induk  $Kondisi  $kondf );"; $cek .= $aqry;
				$get = mysql_fetch_array(mysql_query($aqry));
				$tot_ += - $get['tot'];				
				//penilaian ---------------------------------------------		
				$aqry = "select sum(nilai_barang - nilai_barang_asal) as tot from penilaian where idbi_awal in(select idawal from buku_induk  $Kondisi  $kondf );"; $cek .= $aqry;
				$get = mysql_fetch_array(mysql_query($aqry));
				$tot_ += $get['tot'];				
				//ganti rugi -----------------------------------------
				if($Main->VERSI_NAME=='BDG_BARAT'){
					if($SPg == '03') {
						$idbi_ = 'id';
					}else{
						$idbi_ = 'idbi';
					}
					$aqry = "select sum(aa.bayar) as tot from gantirugi_bayar aa left join ".$tblNameList."_total bb on aa.id_bukuinduk = bb.$idbi_   $Kondisi ";
					$cek .= $aqry;
					//$aqry = "select sum(aa.bayar) as tot from gantirugi_bayar aa left join view_buku_induk2_total bb on aa.id_bukuinduk = bb.id  Where bb.a1='12' and bb.a='28' and bb.b='01' and bb.status_barang <> 3  and bb.staset<=9 ";
					$get = mysql_fetch_array(mysql_query($aqry));
					$tot_ += -$get['tot'];
				}				
				//koreksi ----------------------------------------------
				$aqry = "select sum(harga_baru - harga) as tot from t_koreksi where idbi_awal in(select idawal from buku_induk  $Kondisi $kondf );"; $cek .= $aqry;
				$get = mysql_fetch_array(mysql_query($aqry));
				$tot_ += $get['tot'];
		
				
				$tot_ = $isisum['jml_harga']+$tot_;				
				$jmlTotalHargaDisplay =  !empty($cbxDlmRibu)? number_format(($tot_)/1000, 2, '.', '') : number_format($tot_, 2, '.', '');
				switch($SPg){
					case '04':case "kib_a_cetak" :{
				if($tipe=='kertaskerja'){ 
					$ListData .= $this->tampilTotalA_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 13, 4, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);				
				}else{
					$ListData .= $this->tampilTotalA_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 13, 1, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
					
				}
				break;
			}																
					case '05':case "kib_b_cetak" :{
				if($tipe=='kertaskerja'){ 
					$ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 15, 4, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
				}else{
					$ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 15, 1, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
				}
				break;
			}														
					case '06':case "kib_c_cetak" :{
				if($tipe=='kertaskerja'){ 
					$ListData .= $this->tampilTotalC_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 16, 4, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
				}else{
					$ListData .= $this->tampilTotalC_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 16, 1, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
				}
				break;
			}														
					case '07':case "kib_d_cetak" :{
				if($tipe=='kertaskerja'){ 
					$ListData .= $this->tampilTotalD_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 16, 4, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah, 6);
				}else{
					$ListData .= $this->tampilTotalD_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 17, 1, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
				}
				break;
			}														
					case '08':case "kib_e_cetak" :{
				$ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 15, 3, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
				break;
			}						
					case '09':case "kib_f_cetak" :{
				$ListData .= $this->tampilTotalF_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 17, 1, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
				break;
			}						
					case 'kibg':case "kib_g_cetak" :{
						$ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 11, 1, $clGaris, '', $img,$totLuasTanahHal, $totLuasTanah);
						break;
					}
		
					case 'belumsensus': {
						
						if($tipe=='kertaskerja'){
							
						}else{
							$ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 13, 2, $clGaris, '', $img);	
						}
						
						break;
					}
					default: $ListData .= $this->tampilTotal_($jmlTotalHargaDisplay, $jmlTotalHarga, $cetak, $cbxDlmRibu, 13, 2, $clGaris, '', $img);
				}
			}
		}		
		
		}
			
		$cek = $cetak ? '':"<div id='cek' style='display:none'>".$cek."</div>";
		
		return $cek.$ListData;
		//header -------------------------------
		//$headerTable
		
		
	}
	
	function genSumHal($SPg, $Kondisi){
		global $Main ; 
		$withJmlHarga = 0;
		
		$optstring = stripslashes($_GET['opt']);
		$Opt = json_decode($optstring); //$page = json_encode(",cek="+$Opt->idprs);
		$withJmlHarga = $Opt->withJmlHarga;
		
		$cek ='';
		//$HalDefault = $_POST['HalDefault'];		
		$cbxDlmRibu = $_POST["cbxDlmRibu"];
		$fmThnLaporan = $_POST['fmThnSusut'];
		$tblNameList = $this->getTableName($SPg);	
		switch($SPg){
			case "KIP" :{  break; }
			case "KIR" :{  break; }
			case "belumsensus" :{  break; }
			case "03" : case "listbi_cetak" :{  break; }
			case "04" : case "kib_a_cetak" :{ $kondf= " and f='01' "; break; }
			case "05" : case "kib_b_cetak" :{ $kondf= " and f='02' "; break; }
			case "06" : case "kib_c_cetak" :{ $kondf= " and f='03' "; break; }
			case "07" : case "kib_d_cetak": { $kondf= " and f='04' "; break; }
			case "08" : case "kib_e_cetak": { $kondf= " and f='05' "; break; }
			case "09" : case "kib_f_cetak": { $kondf= " and f='06' "; break; }
			case "kibg" : case "kib_g_cetak": { $kondf= " and f='07' ";  break; }
			default :  break;
		}	
		if($tblNameList=='view_buku_induk2'){
			
		if($_REQUEST['fmCariComboField' ] <> 'nm_barang' || $_REQUEST['nama_barang']<>'') 
		{ 
			$tblNameList = 'buku_induk';	
		}
		}
		
		$kondisi_ = str_replace('idbi', 'id',$Kondisi);
		$kondTglAkhir = $_REQUEST['fmFiltTglBtw_tgl2'];
		
		if($withJmlHarga){
			
				
			//penilaian ---------------------------------------------		
			$k1= $kondTglAkhir==''? '': "tgl_penilaian <='$kondTglAkhir' and ";
			$aqry = "select sum(nilai_barang - nilai_barang_asal) as tot from penilaian ".
				//" where $k1 idbi_awal in(select idawal from buku_induk where $kondisi_  $kondf );"; $cek .= $aqry;
				" where $k1 idbi_awal in(select idawal from $tblNameList where $Kondisi   );"; $cek .= $aqry;
			$get1 = mysql_fetch_array(mysql_query($aqry));
			$penilaian = $get1['tot'];
			
			$byrTGR = 0;
			//ganti rugi ----------------------------------------------
			if($Main->VERSI_NAME=='BDG_BARAT'){
				if($SPg == '03') {
					$idbi_ = 'id';
				}else{
					$idbi_ = 'idbi';
				}
				$aqry = "select sum(aa.bayar) as tot from gantirugi_bayar aa left join ".$tblNameList."_total bb on aa.id_bukuinduk = bb.$idbi_  Where $Kondisi ";
				$cek .= $aqry;
				//$aqry = "select sum(aa.bayar) as tot from gantirugi_bayar aa left join view_buku_induk2_total bb on aa.id_bukuinduk = bb.id  Where bb.a1='12' and bb.a='28' and bb.b='01' and bb.status_barang <> 3  and bb.staset<=9 ";
				$get2 = mysql_fetch_array(mysql_query($aqry));
				$byrTGR = $get2['tot'];
			}
			
			//koreksi ----------------------------------------------
			$koreksi = 0;
			$k1= $kondTglAkhir==''? '': "tgl <='$kondTglAkhir' and ";
			$aqry3 = "select 1, count(*) as cnt, sum(coalesce(harga_baru,0) - coalesce(harga,0)) as tot from t_koreksi ".
				//" where $k1 idbi_awal in(select idawal from $tblNameList where $kondisi_ $kondf );"; $cek .= $aqry;
				" where $k1 idbi_awal in(select idawal from $tblNameList where $Kondisi  );"; $cek .= $aqry3;
			$qry3 = mysql_query($aqry3);
			$cek .= ' jml qry3='. mysql_num_rows($qry3);
			//$get3 = mysql_fetch_array($qry3);
			//$koreksi = $get3['tot'];
			while($isi= mysql_fetch_array($qry3)){
				$koreksi = $isi['tot'];
			}
			$qrtes = " select idawal from $tblNameList where $Kondisi $kondf "; 
			$get = mysql_fetch_array(mysql_query( $qrtes));
			$tes = $get['idawal'];
			
			//pemeliharaan ----------------------------------------------
			$k1= $kondTglAkhir==''? '': "and tgl_pemeliharaan <='$kondTglAkhir' ";
			$aqry = "select sum(coalesce(biaya_pemeliharaan,0)) as tot from pemeliharaan where tambah_aset=1 $k1 ".
				" and idbi_awal in(select idawal from $tblNameList where $Kondisi  );"; $cek .= $aqry;
			$get4 = mysql_fetch_array(mysql_query($aqry));
			$pelihara = $get4['tot'];
			
			//pengaman ----------------------------------------------
			$k1= $kondTglAkhir==''? '': "and tgl_pengamanan <='$kondTglAkhir' ";
			$aqry = "select sum(coalesce(biaya_pengamanan,0)) as tot from pengamanan where tambah_aset=1 $k1 ".
				" and idbi_awal in(select idawal from $tblNameList where $Kondisi  ) ; "; $cek .= $aqry;
			$get5 = mysql_fetch_array(mysql_query($aqry));
			$pengaman = $get5['tot'];
			
			//penghapusan_sebagian ----------------------------------------------
			$k1= $kondTglAkhir==''? '': "and tgl_penghapusan <='$kondTglAkhir' ";
			$aqry = "select sum(coalesce(harga_hapus,0)) as tot from penghapusan_sebagian where 1=1 $k1 ".
				" and idbi_awal in(select idawal from $tblNameList where $Kondisi  ) ; "; $cek .= $aqry;
			$get6 = mysql_fetch_array(mysql_query($aqry));
			$hapussebagian = $get6['tot'];
		}
		
		
		
		//buku induk -------------------------------------------------------------		
		if($withJmlHarga){
			$aqry="select sum(  coalesce(jml_harga,0))  as total, count(*) as cnt from ".$tblNameList." Where $Kondisi ";
		}else{
			$aqry="select 0 as total, count(*) as cnt from ".$tblNameList." Where $Kondisi ";
		}		
		$cek .= $aqry;
		//$aqry="select sum(jml_harga) as total, count(*) as cnt from ".$tblNameList."_total Where $Kondisi ";
		$Sum = mysql_query($aqry);				
		
		$jmlTotalHarga=0;
		$jmlData=0;
		if($isi = mysql_fetch_array($Sum)){
			//$jmlTotalHarga +=$isi['total'] - $byrTGR +$penilaian + $koreksi;
			$jmlTotalHarga +=$isi['total'] - $byrTGR +$penilaian + $koreksi+$pelihara+$pengaman-$hapussebagian;
			$jmlData = $isi['cnt'];
		}
		
		//$jmlTotalHarga = $cbxDlmRibu==''? '<b>'.number_format(($isi['total']-$byrTGR+$penilaian+ $koreksi),2, ',', '.') : 
		//	'<b>'.number_format(($isi['total']-$byrTGR+$penilaian+ $koreksi)/1000,2, ',', '.');		
		$vjmlTotalHarga = $cbxDlmRibu==''? '<b>'.number_format($jmlTotalHarga,2, ',', '.') : 
			'<b>'.number_format($jmlTotalHarga/1000,2, ',', '.');
				
		$listHalaman =
			//"<table class='koptable' border='1' width='100%' style='margin:4 0 0 0'>
			"<table class='koptable' border='1' width='100%' style='margin:4 0 0 0'>			
			<tr><td align=center style='padding:4'>".
				Halaman2b(
					$jmlData,
					$Main->PagePerHal,
					"HalDefault",
					cekPOST('HalDefault'),
					5, 
					'Penatausaha.gotoHalaman').
			" </td></tr></table>";
		
		
		if($withJmlHarga){
			//-- luas tanah u/ kib a,c,d,f
			$luas_tanah = 0;
			if($SPg=='04'||$SPg=='06'||$SPg=='07'||$SPg=='09'){
				
				$aqry = "select sum(luas)as totluas from $tblNameList Where $Kondisi";
				$get = mysql_fetch_array(mysql_query($aqry));
				$luas_tanah = $get['totluas'];
			
			}
		
			$vluas_tanah = '<b>'.number_format($luas_tanah,2,',','.');
		}
		
		$vjmlData = '<b>'.number_format($jmlData,0,',','.');
		
		$jns = $_REQUEST['jns'];
		if($jns=='penyusutan' && $Main->PENYUSUTAN){
			if($withJmlHarga){
				//tot perolehan 
				$get = mysql_fetch_array(mysql_query(" select sum(harga) as tot from ".$tblNameList."_total Where $Kondisi "));
				//tot susut 
				$tahun_susut = $_REQUEST['tahun_susut'];
				
					
				$aqry= "select count(*) as jmlsusut, ifnull(sum(aa.harga),0) as hrgsusut, ifnull(sum(aa.hrg_rehab),0) as hrgrehab from penyusutan aa ". 
				"join ".
	  			"(  select id from buku_induk Where $Kondisi  ) bb on aa.idbi= bb.id  ".
	 			" where aa.tahun<$tahun_susut and aa.id_koreksi=0  and year(aa.tgl) <= $tahun_susut ;"; $cek.= $aqry;
	
	
				$susut = mysql_fetch_array(mysql_query($aqry));
				$penyusutanprev = $susut['hrgsusut'];		
				
					
				$aqry= "select count(*) as jmlsusut, ifnull(sum(aa.harga),0) as hrgsusut, ifnull(sum(aa.hrg_rehab),0) as hrgrehab from penyusutan aa ". 
				"join ".
	  			"(  select id from buku_induk Where $Kondisi  ) bb on aa.idbi= bb.id ".
	 			" where aa.tahun<=$tahun_susut and aa.id_koreksi=0  and year(aa.tgl) <= $tahun_susut ;"; $cek.= $aqry;
	
				$susut = mysql_fetch_array(mysql_query($aqry));
				$penyusutantot = $susut['hrgsusut'];
				$penyusutanskr = $penyusutantot-$penyusutanprev ;
				//$nilaibuku = $get['tot'] - $penyusutantot ;
				$nilaibuku = ($isi['total']-$byrTGR+$penilaian+$pelihara+$pengaman-$hapussebagian+ $koreksi) - $penyusutantot ;
			}
		}
		
		if($Main->TAMPIL_SUSUT==1){
			if($withJmlHarga){
				$aqry="select ifnull(sum(harga),0)as harga from penyusutan where tahun<$fmThnLaporan and idbi in ( select id from buku_induk Where $kondisi_ )";
				$get_susut = mysql_fetch_array(mysql_query($aqry));$cek.= $aqry;
				$aqry2="select ifnull(sum(harga),0)as harga from penyusutan where tahun=$fmThnLaporan and idbi in ( select id from buku_induk Where $kondisi_ )";
				$get_susut2 = mysql_fetch_array(mysql_query($aqry2));$cek.= $aqry2;
				$penyusutanprev2=$get_susut['harga'];
				$penyusutanskr2=$get_susut2['harga'];	
				$tgl_nilaibuku = $fmThnLaporan.'-12-31';
				//$nbts = getNilaiBuku($isi['id'],$tgl_nilaibuku,0);
				$nilaibuku2=($isi['total'] - $byrTGR +$penilaian + $koreksi)-($penyusutanprev2+$penyusutanskr2);
			}
			
		}
		$cek = $Main->SHOW_CEK == FALSE ? '' : htmlspecialchars($cek) ;
		
		/**/
		return array(
			'withJmlHarga'=>$withJmlHarga,
			'luas_tanah'=>$luas_tanah,
			'vluas_tanah'=>$vluas_tanah, 
			'sum'=>$vjmlTotalHarga, 
			'jmlData'=>$jmlData,  
			'vjmlData'=>$vjmlData, 
			'hal'=>$listHalaman, 
			'cek'=>$cek,
			'penyusutanprev'=>number_format($penyusutanprev,2,',','.'), 
			'penyusutanskr'=>number_format($penyusutanskr,2,',','.'),
			'penyusutantot'=>number_format($penyusutantot,2,',','.'),
			'nilaibuku'=>number_format($nilaibuku,2,',','.'),
			//'totperolehan'=>$isi['total'],
			'totperolehan'=>$jmlTotalHarga,
			
			'penyusutanprev2'=>number_format($penyusutanprev2,2,',','.'), 
			'penyusutanskr2'=>number_format($penyusutanskr2,2,',','.'),
			'nilaibuku2'=>number_format($nilaibuku2,2,',','.'),
			'isitotal'=>$isi['total'], 
			'byrTGR' => $byrTGR ,
			'penilaian' => $penilaian ,
			'koreksi' => $koreksi,
			//'aqry3' =>$aqry3,
			'pelihara' =>$pelihara,
			'pengamanan'=>$pengaman,
			'hapus sebagian'=>$hapussebagian,
			//'tes'=>$tes,
			//'qrtes'=>$qrtes
			
			
		);
	}
	
	
	
		
	function genHeader($SPg='', $cetak=FALSE,$tipe=''){
			global $Main;
			
			//$SPg = $_REQUEST['SPg'];
			$cbxDlmRibu = $_POST['cbxDlmRibu'];
			$fmFiltThnBuku = $_POST['fmThnSusut']==NULL?$_COOKIE['coThnAnggaran']:$_POST['fmThnSusut'];
			$fmFiltThnBuku2 = $_POST['fmThnSusut']==NULL?$_COOKIE['coThnAnggaran']-1:$_POST['fmThnSusut']-1;
			
			$jns = $_REQUEST['jns'];
			$tampilHeaderHarga = !empty($cbxDlmRibu)? 'Harga (Ribuan)': 'Harga';	
			$tampilDok ='';// $cetak? "" : "<th class=\"th01\" rowspan='2' width='24'></th>";
			$clGaris = $cetak? 'GarisCetak':'GarisDaftar';			
			/*if($this->tampilBidang){
				$vBidang =  
					"<th class='th01' rowspan=2>".
					"Bidang / SKPD / Unit / Sub Unit".
					"</th>";
				$vBidangA =  
					"<th class='th01' rowspan=3>".
					"Bidang / SKPD / Unit / Sub Unit".
					"</th>";
			}*/								
			//echo ",spg2=$SPg";
			//$tipe=$_REQUEST['tipe'];
			if($Main->MODUL_BAST) $vbast = $SPg=='KIR'?"<th class='th01' rowspan='2'>Gedung/<br>Ruang</th>":"<th class='th01' rowspan='2'>BAST/<br>Kontrak</th>";//$vbast ="<th class='th01' rowspan='2'>BAST/<br>Kegiatan</th>";
			if($Main->MODUL_SPK) $vspk ="";//$vspk ="<th class='th01' rowspan='2'>Kontrak</th>";
			
			if($Main->SETTING['SENSUS_VERSI']==2 && $SPg=='belumsensus') $vbast = "<th class='th01' rowspan='2'>Gedung/<br>Ruang</th>";
			
			switch($SPg){
				case "03" : case "listbi_cetak" : case 'belumsensus' : case 'KIR': case 'KIP': {
					
					$tampilCheckbox =  $cetak ? "" : "	<th class='th01' ><input type='checkbox' name='toggle' id='toggle' value='' onClick=\"checkAll(".$Main->PagePerHal.");".
					"Penatausaha.checkAll($Main->PagePerHal,'cb','toggle','boxchecked')".
					"\" ></th>";			
					$cp = $cetak? 14:15;
					for ($i=0;$i<$cp;$i++){
						$tambahgaris .= "<th class='$clGaris' style='padding:0'></th>";
					}
					$tambahgaris .= '</tr>';
					$status_survey_header= $Main->STATUS_SURVEY==1 ? "<th class='th01' rowspan='2'>Status Recon</th>":"";
					$tampil_susut_header=$Main->TAMPIL_SUSUT==1 ? 
					"<th class='th01' rowspan='2'>Nilai Sisa</th>
					<th class='th01' rowspan='2'>Umur Ekonomis</th>
					<th class='th01' rowspan='2'>Nilai Penyusutan <br>Per Tahun</th>
					<th class='th01' rowspan='2'>Lama/Umur <br>Penggunaan Per 31 Desember $fmFiltThnBuku2</th>
					<th class='th01' rowspan='2'>Nilai Penyusutan s/d 31 Desember $fmFiltThnBuku2</th>
					<th class='th01' rowspan='2'>Nilai Penyusutan Tahun $fmFiltThnBuku</th>
					<th class='th01' rowspan='2'>Nilai Buku $fmFiltThnBuku</th>
					":"";
					$jnsekstra =$Main->JNS_EKSTRA==1 && $jns=='ekstra' ? "<th class='th01' rowspan='2'>Jenis Ekstra</th>":"";
					$jnslain =$Main->JNS_LAINLAIN==1 && $jns=='lain' ? "<th class='th01' rowspan='2'>Jenis Lain-lain</th>":"";
					
					if($jns=='penyusutan' && $Main->PENYUSUTAN){
						$kolomMerk = 'Merk / Tipe';
						if($SPg=='belumsensus') $kolomMerk = 'Merk / Tipe / Alamat';
						$headerTable =
							"<tr>
							<th class=\"th02\" colspan='". ($cetak? "3": "4") ."'>Nomor</th>
							<th class=\"th02\" colspan='3'>Spesifikasi Barang</th>
							<!--<th class=\"th01\" rowspan='2'>Bahan</th>-->
							<th class=\"th01\" rowspan='2'>Cara Perolehan /<br>Sumber Dana /<br>Status Barang </th>
							<th class=\"th01\" rowspan='2'>Tahun Perolehan</th>
							<!--<th class=\"th01\" rowspan='2'>Ukuran Barang / Konstruksi (P,SP,D)</th>-->
							<th class=\"th01\" rowspan='2'>Kondisi <br> Barang (B,KB,RB)</th>
							<th class=\"th01\" rowspan='2'>Harga Perolehan</th>
							
							<!--<th class=\"th02\" colspan='3'>Penyusutan</th>-->
							<th class=\"th01\" rowspan='2'>Akumulasi penyusutan</th>
							<th class=\"th01\" rowspan='2'>Nilai Buku</th>
							<th class=\"th01\" rowspan='2'>Beban Penyusutan</th>
							<th class=\"th01\" rowspan='2' style='width:90px'>Masa Manfaat/<br>Persen Residu/<br>Akhir Tahun</th>
							<th class=\"th01\" rowspan='2' style='min-width:100;'>Keterangan/<br>Tgl. Buku/<br><!--Tahun Sensus--></th>							
							</tr>
							<tr>
							<th class=\"th01\">No.</th>				
							$tampilCheckbox
							<th class=\"th01\">Kode Barang/<br>ID Barang/<br>ID Awal</th>
							<th class=\"th01\">Reg.</th>
							<th class=\"th01\"  width=\"100\">Nama / Jenis Barang</th>
							<th class=\"th01\"  width=\"100\">$kolomMerk</th>
							<th class=\"th01\">No. Sertifikat / No. Pabrik / No. Chasis / No. Mesin / No. Polisi</th>
							<!--<th class=\"th01\" >s/d Tahun Sebelumnya</th>
							<th class=\"th01\" >Tahun Sekarang</th>
							<th class=\"th01\" >s/d Tahun Sekarang</th>-->
							
							
							</tr>
							$tambahgaris";
					
					}else{
					
						if($tipe=='kertaskerja'){ //sensus.belumcek.kertaskerja
							$headerTable =
								"<tr>
								<th class=\"th01\" rowspan='2'>No.</th>		
								<th class=\"th01\" rowspan='2'>Kode Lokasi/<br> Kode Barang/<br> Nama Barang</th>						
								<th class=\"th02\" colspan='2'>Spesifikasi Barang</th>
								
								<th class=\"th01\" rowspan='2' width='60'>Tahun /<br> Harga Perolehan</th>
								<th class=\"th01\" rowspan='2' width='40'>Ada/<br>Tidak</th>
								
								<th class=\"th01\" rowspan=2 width='70'>  Kondisi Barang<br>(B/KB/RB) </th>
								<th class=\"th01\" rowspan='2' width='100'>Gedung/<br>Ruang/<br>Lokasi </th>
								<th class=\"th01\" rowspan='2' width='150'>Penanggung Jawab Barang</th>
								<th class=\"th01\" rowspan='2' width='150'>Status Penguasaan</th>
								<th class=\"th01\" rowspan='2' width='100'>Catatan</th>							
								<th class=\"th01\" rowspan='2' width='100'>Tgl. Cek/<br>Petugas Sensus</th>
								
								</tr>
								<tr>
								
								<th class=\"th01\"  width=\"100\">Merk / Tipe/ Alamat</th>
								<th class=\"th01\" width='100'>No. Sertifikat / No. Pabrik / No. Chasis / No. Mesin / No. Polisi</th>
								<!--<th class=\"th01\" width='70'>Barang</th>
								<th class=\"th01\"> $tampilHeaderHarga </th>-->
								
								</tr>";
								//$tambahgaris";
						}else{
							$kolomMerk = 'Merk / Tipe / Alamat';
							if($SPg=='belumsensus') $kolomMerk = 'Merk / Tipe / Alamat';
							$headerTable =
								"<tr>
								<th class=\"th02\" colspan='". ($cetak? "3": "4") ."'>Nomor</th>
								<th class=\"th02\" colspan='3'>Spesifikasi Barang</th>
								<th class=\"th01\" rowspan='2'>Bahan</th>
								<th class=\"th01\" rowspan='2'>Cara Perolehan /<br>Sumber Dana /<br>Status Barang /<br>Penggunaan</th>
								<th class=\"th01\" rowspan='2'>Tahun Perolehan</th>
								<th class=\"th01\" rowspan='2'>Ukuran Barang / Konstruksi (P,SP,D)</th>
								<th class=\"th01\" rowspan='2'>Keadaan Barang (B,KB,RB)</th>
								<!--<th class=\"th02\" colspan='2'>Jumlah</th>	-->
								<th class=\"th01\" rowspan='2'> $tampilHeaderHarga </th>
								$vbast
								$vspk
								<th class=\"th01\" rowspan='2' style='min-width:100;'>Keterangan/<br>Tgl. Buku/<br>Tahun Sensus</th>
								$tampilDok
								$vBidang	
								$tampilCbxKeranjangHead							
								$status_survey_header
								$tampil_susut_header
								$jnsekstra
								$jnslain
								</tr>
								<tr>
								<th class=\"th01\">No.</th>				
								$tampilCheckbox
								<th class=\"th01\">Kode Barang/<br>ID Barang/<br>ID Awal</th>
								<th class=\"th01\">Reg.</th>
								<th class=\"th01\"  width=\"100\">Nama / Jenis Barang</th>
								<th class=\"th01\"  width=\"100\">$kolomMerk</th>
								<th class=\"th01\">No. Sertifikat / No. Pabrik / No. Chasis / No. Mesin / No. Polisi</th>
								<!--<th class=\"th01\" width='70'>Barang</th>-->
								
								
								</tr>
								$tambahgaris";
						}
					}
					break;
				} 
				case "04" : case "kib_a_cetak" :{
					//$tampilDok = '';//$cetak? "" : "<th class=\"th01\" rowspan='3' width='24'></th>";
					//$tampilCheckbox =  $cetak ? "" : "<th class=\"th01\" rowspan=\"3\"><input type=\"checkbox\" name=\"toggle\" value=\"\" onClick=\"checkAll($jmlDataKIB_A);\"</th>";
					$tampilCheckbox =  $cetak ? "" : "<th class='th01' rowspan='2'><input type='checkbox' name='toggle' value='' onClick='checkAll(".$Main->PagePerHal.")'></th>";
					$width_alm = $cetak ? 'min-width:150;' :'min-width:150;width:250;';
					$width_ket = $cetak ? '' :'min-width:100;';
					$cp = $cetak? 14:15;
					for ($i=0;$i<$cp;$i++){
						$tambahgaris .= "<th class='$clGaris' style='padding:0'></th>";
					}					
					$tambahgaris .= '</tr>';
					$status_survey_header=$Main->STATUS_SURVEY==1 ? "<th class='th01' rowspan='3'>Status Recon</th>":"";
					//$jnsekstra =$Main->JNS_EKSTRA==1 && $jns=='ekstra' ? "<th class='th01' rowspan='2'>Jenis Ekstra</th>":"";
					
					$vbast ="<th class='th01' rowspan='3'>BAST/Kontrak</th>";
					$vspk ="";//$vspk ="<th class='th01' rowspan='3'>Kontrak</th>";
					if($tipe=='kertaskerja'){
						$headerTable=
							"<tr>
							<th class=\"th01\"  rowspan=\"3\">No.</th>
							$tampilCheckbox
							<th class=\"th02\" colspan=\"2\">N o m o r</th>
							<th class=\"th01\" rowspan=\"3\" style=''>Nama Barang</th>
							<th class=\"th01\" rowspan=\"3\">Luas (M2)</th>
							<th class=\"th01\" rowspan=\"3\" style='width:50'>Tahun Peroleh an</th>
							<th class=\"th01\" rowspan=\"3\" style='$width_alm'>Letak / Alamat</th>
							<th class=\"th02\" colspan=\"3\">Status Tanah</th>
							<th class=\"th01\" rowspan=\"3\">Penggunaan</th>
							<th class=\"th01\" rowspan=\"3\" style='width:50'>Cara Perolehan / Sumber Dana / Status Barang / Kondisi</th>
							<th class=\"th01\" rowspan=\"3\" style=''>$tampilHeaderHarga</th>
							<th class=\"th01\" rowspan=\"3\" style='width:130px'>Status Penguasaan</th>
							<th class=\"th01\" rowspan=\"3\" style=''>DT/TD</th>
							<th class=\"th01\" rowspan=\"3\" style=''>Keterangan</th>
							$tampilDok	
							$vBidangA
							$tampilCbxKeranjangHeadA						
							</tr>
							<tr class=\"koptable\">
							<th class=\"th01\" rowspan=\"2\" style='width:70'>Kode Barang</th>
							<th class=\"th01\" rowspan=\"2\" style='width:25'>Reg</th>
							<th class=\"th01\" rowspan=\"2\">Hak</th>
							<th class=\"th02\" colspan=\"2\">Sertifikat</th>
							</tr>
							<tr>
							<th class=\"th01\" style=''>Tanggal</th>
							<th class=\"th01\" style=''>Nomor</th>
							</tr>
							
							$tambahgaris
							";
					}else{
						
					
						$headerTable=
							"<tr>
							<th class=\"th02\" colspan=\"". ($cetak? "3": "4") ."\">N o m o r</th>
							<th class=\"th01\" rowspan=\"3\" style=''>Nama Barang</th>
							<th class=\"th01\" rowspan=\"3\">Luas (M2)</th>
							<th class=\"th01\" rowspan=\"3\" style='width:50'>Tahun Peroleh an</th>
							<th class=\"th01\" rowspan=\"3\" style='$width_alm'>Letak / Alamat</th>
							<th class=\"th02\" colspan=\"3\">Status Tanah</th>
							<th class=\"th01\" rowspan=\"3\">Penggunaan</th>
							<th class=\"th01\" rowspan=\"3\" style='width:50'>Cara&nbsp;Perolehan&nbsp;/ Sumber&nbsp;Dana&nbsp;/ Status&nbsp;Barang&nbsp;/ Kondisi</th>
							<th class=\"th01\" rowspan=\"3\" style=''>$tampilHeaderHarga</th>
							$vbast
							$vspk
							<th class=\"th01\" rowspan=\"3\" style='$width_ket'>Keterangan</th>
							$tampilDok	
							$vBidangA
							$tampilCbxKeranjangHeadA
							$status_survey_header	
							$jnsekstra												
							</tr>
							<tr class=\"koptable\">
							<th class=\"th01\" rowspan=\"2\"  >No.</th>
							$tampilCheckbox
							<th class=\"th01\" rowspan=\"2\" style='width:70'>Kode Barang/<br>ID Barang/<br>ID Awal</th>
							<th class=\"th01\" rowspan=\"2\" style='width:25'>Reg.</th>
							<th class=\"th01\" rowspan=\"2\">Hak</th>
							<th class=\"th02\" colspan=\"2\">Sertifikat</th>
							</tr>
							<tr>
							<th class=\"th01\" style=''>Tanggal</th>
							<th class=\"th01\" style=''>Nomor</th>
							</tr>
							
							$tambahgaris
							";
					}
					break;
				}
				case "05" : case "kib_b_cetak" :{
					$tampilCheckbox =  $cetak ? "" : "<th class='th01' rowspan=''><input type='checkbox' name='toggle' value='' onClick='checkAll(".$Main->PagePerHal.")'></th>";
					$cp = $cetak? 16:17;
					for ($i=0;$i<$cp;$i++){
						$tambahgaris .= "<th class='$clGaris' style='padding:0'></th>";
					}
					$tambahgaris .= '</tr>';
					$status_survey_header=$Main->STATUS_SURVEY==1 ? "<th class='th01' rowspan='2'>Status Recon</th>":"";
					//$jnsekstra =$Main->JNS_EKSTRA==1 && $jns=='ekstra' ? "<th class='th01' rowspan='2'>Jenis Ekstra</th>":"";
					$tampil_susut_header=$Main->TAMPIL_SUSUT==1 ? 
					"<th class='th01' rowspan='2'>Nilai Sisa</th>
					<th class='th01' rowspan='2'>Umur Ekonomis</th>
					<th class='th01' rowspan='2'>Nilai Penyusutan <br>Per Tahun</th>
					<th class='th01' rowspan='2'>Lama/Umur <br>Penggunaan Per 31 Desember $fmFiltThnBuku2 </th>
					<th class='th01' rowspan='2'>Nilai Penyusutan s/d 31 Desember $fmFiltThnBuku2 </th>
					<th class='th01' rowspan='2'>Nilai Penyusutan Tahun $fmFiltThnBuku </th>
					<th class='th01' rowspan='2'>Nilai Buku $fmFiltThnBuku </th>
					":"";
					
					if($tipe=='kertaskerja'){
						$headerTable=
							"<tr>
							<th class=\"th01\" rowspan=\"2\">No.</th>
							$tampilCheckbox
							<th class=\"th01\" rowspan=\"2\" style='width:40'>Kode Barang</th>
							<th class=\"th01\" rowspan=\"2\" style='width:50'>Nomor Reg</th>
							<th class=\"th01\" rowspan=\"2\" style='min-width:100'>Nama Barang</th>
							<th class=\"th01\" rowspan=\"2\" style='min-width:50'>Merk/Type</th>
							<th class=\"th01\" rowspan=\"2\">Ukuran<br>/CC</th>
							<th class=\"th01\" rowspan=\"2\"  style='width:50'>Bahan</th>
							<th class=\"th01\" rowspan=\"2\" style='width:50'>Tahun Perolehan</th>
							<th class=\"th02\" colspan=\"5\">N o m o r</th>
							<th class=\"th01\" rowspan=\"2\" width='62'>Cara Perolehan / Sumber Dana / Status Barang</th>
							<th class=\"th01\" rowspan=\"2\" style='width:80'>$tampilHeaderHarga</th>							
							<th class=\"th01\" rowspan=\"2\" style=''>Kondisi</th>
							<th class=\"th01\" rowspan=\"2\"  style='min-width:150'>Nama/No Ruang</th>
							<th class=\"th01\" rowspan=\"2\" style=''>Keterangan</th>
							$tampilDok
							$vBidang
							$tampilCbxKeranjangHead	
							</tr>
							<tr>
							<th class=\"th01\">Pabrik</th>
							<th class=\"th01\">Rangka</th>
							<th class=\"th01\">Mesin</th>
							<th class=\"th01\">Polisi</th>
							<th class=\"th01\">BPKB</th>
							</tr>
							$tambahgaris
							";
					}else{
						$headerTable=
							"<tr>
							<th class=\"th02\" colspan=\"". ($cetak? "3": "4") ."\">N o m o r</th>
							
							<th class=\"th01\" rowspan=\"2\" style='min-width:100'>Nama Barang</th>
							<th class=\"th01\" rowspan=\"2\" style='width:200'>Merk/Type</th>
							<th class=\"th01\" rowspan=\"2\">Ukuran/CC</th>
							<th class=\"th01\" rowspan=\"2\">Bahan</th>
							<th class=\"th01\" rowspan=\"2\" style='width:50'>Tahun Perolehan</th>
							<th class=\"th02\" colspan=\"5\">N o m o r</th>
							<th class=\"th01\" rowspan=\"2\" width='62'>Cara&nbsp;Perolehan&nbsp;/ Sumber&nbsp;Dana&nbsp;/ Status&nbsp;Barang&nbsp;/ Kondisi /<br>Penggunaan</th>
							<th class=\"th01\" rowspan=\"2\" style='width:80'>$tampilHeaderHarga</th>
							$vbast
							$vspk
							<th class=\"th01\" rowspan=\"2\" style=''>Keterangan</th>
							$tampilDok
							$vBidang
							$tampilCbxKeranjangHead
							$status_survey_header	
							$tampil_susut_header
							</tr>
							<tr>
							<th class=\"th01\" >No.</th>
							$tampilCheckbox
							<th class=\"th01\" style='width:40'>Kode Barang/<br>ID Barang/<br>ID Awal</th>
							<th class=\"th01\" style='width:50'>Reg.</th>
							<th class=\"th01\">Pabrik</th>
							<th class=\"th01\">Rangka</th>
							<th class=\"th01\">Mesin</th>
							<th class=\"th01\">Polisi</th>
							<th class=\"th01\">BPKB</th>
							</tr>
							$tambahgaris
							";
						
					}
					
					break;
				}
				case "06" : case "kib_c_cetak" :{			
					$tampilCheckbox = $cetak ? "" : "<th class='th01' rowspan=''><input type='checkbox' name='toggle' value='' onClick='checkAll(".$Main->PagePerHal.")'></th>";
					$width_alm = $cetak ? 'min-width:120;' :'min-width:150;';
					$width_ket = $cetak ? 'min-width:180;' :'min-width:100;';
					$tambahgaris = '<tr>';
					$cp = $cetak? 17:18;
					for ($i=0;$i<$cp;$i++){
						$tambahgaris .= "<th class='$clGaris' style='padding:0'></th> ";
					}
					$tambahgaris .= '</tr>';
					$status_survey_header=$Main->STATUS_SURVEY==1 ? "<th class='th01' rowspan='2'>Status Recon</th>":"";
					$tampil_susut_header=$Main->TAMPIL_SUSUT==1 ? 
					"<th class='th01' rowspan='2'>Nilai Sisa</th>
					<th class='th01' rowspan='2'>Umur Ekonomis</th>
					<th class='th01' rowspan='2'>Nilai Penyusutan <br>Per Tahun</th>
					<th class='th01' rowspan='2'>Lama/Umur <br>Penggunaan Per 31 Desember $fmFiltThnBuku2 </th>
					<th class='th01' rowspan='2'>Nilai Penyusutan s/d 31 Desember $fmFiltThnBuku2 </th>
					<th class='th01' rowspan='2'>Nilai Penyusutan Tahun $fmFiltThnBuku </th>
					<th class='th01' rowspan='2'>Nilai Buku $fmFiltThnBuku </th>
					":"";
					if($tipe=='kertaskerja'){
						$headerTable=
						"<tr>
						<th class=\"th01\" rowspan=\"2\">No.</th>
						$tampilCheckbox
						<th class=\"th01\" rowspan=\"2\" style='width:40'>Kode Barang</th>
						<th class=\"th01\" rowspan=\"2\" style='width:35'>Nomor Reg/<br>No. Gedung</th>
						<th class=\"th01\" rowspan=\"2\" style=''>Nama Barang</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Tahun Peroleh an</th>				
						<th class=\"th01\" rowspan=\"2\">Kondisi Bangunan (B, KB, RB)</th>
						<th class=\"th02\" colspan=\"2\">Konstruksi Bangunan</th>
						<th class=\"th01\" rowspan=\"2\">Luas Lantai (M2)</th>
						<th class=\"th01\" rowspan=\"2\" style='$width_alm'>Letak / Alamat</th>
						<th class=\"th02\" colspan=\"1\">Dokumen Gedung</th>
						<th class=\"th01\" rowspan=\"2\">Luas Tanah (M2)</th>
						<th class=\"th01\" rowspan=\"2\">Status Tanah</th>
						<th class=\"th01\" rowspan=\"2\">Nomor Kode Tanah</th>
						<th class=\"th01\" rowspan=\"2\" style='width:62'>Cara <br>Perolehan / Sumber Dana / Status Barang </th>
						<th class=\"th01\" rowspan=\"2\">$tampilHeaderHarga</th>
						<th class=\"th01\" rowspan=\"2\" style=''>Kondisi</th>
						<th class=\"th01\" rowspan=\"2\" style='width:130'>Status Penguasaan</th>
						<th class=\"th01\" rowspan=\"2\" style=''>Ket</th>
						$tampilDok
						$vBidang
						$tampilCbxKeranjangHead	
						</tr>
						<tr>
						<th class=\"th01\">Bertingkat/ Tidak</th>
						<th class=\"th01\">Beton/ Tidak</th>
						<!--<th class=\"th01\" style='width:50'>Tanggal</th>-->
						<th class=\"th01\">Tgl/Nomor</th>				
						</tr>".					
						$tambahgaris
						
						
						;
					}else{
						$headerTable=
						"<tr>
						<th class=\"th02\" colspan=\"". ($cetak? "3": "4") ."\">N o m o r</th>
						<th class=\"th01\" rowspan=\"2\" style=''>Nama Barang</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Tahun Peroleh an</th>				
						<th class=\"th01\" rowspan=\"2\">Kondisi Bangunan (B, KB, RB)</th>
						<th class=\"th02\" colspan=\"2\">Konstruksi Bangunan</th>
						<th class=\"th01\" rowspan=\"2\">Luas Lantai (M2)</th>
						<th class=\"th01\" rowspan=\"2\" style='$width_alm'>Letak / Alamat</th>
						<th class=\"th02\" colspan=\"1\">Dokumen Gedung</th>
						<th class=\"th01\" rowspan=\"2\">Luas Tanah (M2)</th>
						<th class=\"th01\" rowspan=\"2\">Status Tanah/<br>Penggunaan </th>
						<th class=\"th01\" rowspan=\"2\">Nomor Kode Tanah</th>
						<th class=\"th01\" rowspan=\"2\" style='width:62'>Cara Perolehan&nbsp;/ Sumber&nbsp;Dana&nbsp;/ Status&nbsp;Barang&nbsp;/<br> Kondisi </th>
						<th class=\"th01\" rowspan=\"2\">$tampilHeaderHarga</th>
						$vbast
						$vspk
						<th class=\"th01\" rowspan=\"2\" style='$width_ket'>Ket</th>
						$tampilDok
						$vBidang
						$tampilCbxKeranjangHead	
						$status_survey_header
						$tampil_susut_header
						</tr>
						<tr>
						<th class=\"th01\" >No.</th>
						$tampilCheckbox
						<th class=\"th01\" style='width:40'>Kode Barang/<br>ID Barang/<br>ID Awal</th>
						<th class=\"th01\" style='width:35'>Reg./<br>No. Gedung</th>
						
						<th class=\"th01\">Bertingkat/ Tidak</th>
						<th class=\"th01\">Beton/ Tidak</th>
						<!--<th class=\"th01\" style='width:50'>Tanggal</th>-->
						<th class=\"th01\">Tgl/Nomor</th>				
						</tr>".					
						$tambahgaris
						;
					}
					break;
				}
				case "07" : case "kib_d_cetak" :{			
					$tampilCheckbox = $cetak ? "" : "<th class='th01' rowspan=''><input type='checkbox' name='toggle' value='' onClick='checkAll(".$Main->PagePerHal.")'></th>";
					$width_alm = $cetak ? '' :'min-width:150;';
					$width_ket = $cetak ? '' :'min-width:100;';
					$cp = $cetak? 18:19;
					for ($i=0;$i<$cp;$i++){
						$tambahgaris .= "<th class='$clGaris' style='padding:0'></th>";
					}
					$tambahgaris .= '</tr>';
					$status_survey_header=$Main->STATUS_SURVEY==1 ? "<th class='th01' rowspan='2'>Status Recon</th>":"";
					$tampil_susut_header=$Main->TAMPIL_SUSUT==1 ? 
					"<th class='th01' rowspan='2'>Nilai Sisa</th>
					<th class='th01' rowspan='2'>Umur Ekonomis</th>
					<th class='th01' rowspan='2'>Nilai Penyusutan <br>Per Tahun</th>
					<th class='th01' rowspan='2'>Lama/Umur <br>Penggunaan Per 31 Desember $fmFiltThnBuku2 </th>
					<th class='th01' rowspan='2'>Nilai Penyusutan s/d 31 Desember $fmFiltThnBuku2 </th>
					<th class='th01' rowspan='2'>Nilai Penyusutan Tahun $fmFiltThnBuku </th>
					<th class='th01' rowspan='2'>Nilai Buku $fmFiltThnBuku </th>
					":"";
					if($tipe=='kertaskerja'){
						$headerTable="
						<tr>
						<th class=\"th01\" rowspan=\"2\" >No.</th>
						$tampilCheckbox
						<th class=\"th01\" rowspan=\"2\" style='width:60'>Kode Barang</th>
						<th class=\"th01\" rowspan=\"2\" style='width:40'>Nomor Reg/<br>No. RJ</th>
						<th class=\"th01\" rowspan=\"2\" style='width:200'>Nama Barang</th>
						<th class=\"th01\" rowspan=\"2\" style=''>Tahun Perolehan</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Konstruksi</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Panjang (km)</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Lebar (M)</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Luas  (M2)</th>
						<th class=\"th01\" rowspan=\"2\" style='$width_alm'>Letak / Alamat</th>
						<th class=\"th02\" colspan=\"2\">Dokumen</th>
						<th class=\"th01\" rowspan=\"2\">Status Tanah</th>
						<th class=\"th01\" rowspan=\"2\">Nomor Kode Tanah</th>
						<th class=\"th01\" rowspan=\"2\">Cara Perolehan / Sumber Dana / Status Barang</th>
						
						<th class=\"th01\" rowspan=\"2\" style='width:75'>$tampilHeaderHarga</th>				
						<th class=\"th01\" rowspan=\"2\" style='width:40'>Kondisi</th>
						<th class=\"th01\" rowspan=\"2\" style='width:130'>Status Penguasaan</th>
						<th class=\"th01\" rowspan=\"2\" style='width:90'>Ket</th>
						$tampilDok
						$vBidang
						$tampilCbxKeranjangHead	
						</tr>
						<tr class=\"koptabel\">
						<th class=\"th01\" style='width:70'>Tanggal</th>
						<th class=\"th01\">Nomor</th>				
						</tr>
						$tambahgaris";
					}else{
						$headerTable="
						<tr>
						<th class=\"th02\" colspan=\"". ($cetak? "3": "4") ."\">N o m o r</th>
						<th class=\"th01\" rowspan=\"2\" style='width:200'>Nama Barang</th>
						<th class=\"th01\" rowspan=\"2\" style=''>Tahun Perolehan</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Konstruksi</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Panjang (km)</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Lebar (M)</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Luas  (M2)</th>
						<th class=\"th01\" rowspan=\"2\" style='$width_alm'>Letak / Alamat</th>
						<th class=\"th02\" colspan=\"2\">Dokumen</th>
						<th class=\"th01\" rowspan=\"2\">Status Tanah</th>
						<th class=\"th01\" rowspan=\"2\">Nomor Kode Tanah</th>
						<th class=\"th01\" rowspan=\"2\">Cara&nbsp;Perolehan&nbsp;/ Sumber&nbsp;Dana&nbsp;/ Status&nbsp;Barang&nbsp;/<br> Kondisi /<br>Penggunaan</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Kondisi (B,KB,RB)</th>
						<th class=\"th01\" rowspan=\"2\" style='width:75'>$tampilHeaderHarga</th>				
						$vbast
						$vspk
						<th class=\"th01\" rowspan=\"2\" style='$width_ket'>Ket</th>
						$tampilDok
						$vBidang
						$tampilCbxKeranjangHead	
						$status_survey_header
						$tampil_susut_header
						</tr>
						<tr class=\"koptabel\">
						<th class=\"th01\" rowspan=\"\" >No.</th>
						$tampilCheckbox
						<th class=\"th01\" rowspan=\"\" style='width:60'>Kode Barang/<br>ID Barang/<br>ID Awal</th>
						<th class=\"th01\" rowspan=\"\" style='width:40'>Reg./<br>No. RJ</th>
						<th class=\"th01\" style='width:70'>Tanggal</th>
						<th class=\"th01\">Nomor</th>				
						</tr>
						$tambahgaris";
					}
					break;
				}
				case "08" : case "kib_e_cetak" :{					
					$tampilCheckbox =  $cetak ? "" : "<th class='th01' rowspan=''><input type='checkbox' name='toggle' value='' onClick='checkAll(".$Main->PagePerHal.")'></th>";
					$cp = $cetak? 16:17;
					for ($i=0;$i<$cp;$i++){
						$tambahgaris .= "<th class='$clGaris' style='padding:0'></th>";
					}
					$tambahgaris .= '</tr>';
					$status_survey_header=$Main->STATUS_SURVEY==1 ? "<th class='th01' rowspan='2'>Status Recon</th>":"";
					$tampil_susut_header=$Main->TAMPIL_SUSUT==1 ? 
					"<th class='th01' rowspan='2'>Nilai Sisa</th>
					<th class='th01' rowspan='2'>Umur Ekonomis</th>
					<th class='th01' rowspan='2'>Nilai Penyusutan <br>Per Tahun</th>
					<th class='th01' rowspan='2'>Lama/Umur <br>Penggunaan Per 31 Desember $fmFiltThnBuku2 </th>
					<th class='th01' rowspan='2'>Nilai Penyusutan s/d 31 Desember $fmFiltThnBuku2 </th>
					<th class='th01' rowspan='2'>Nilai Penyusutan Tahun $fmFiltThnBuku </th>
					<th class='th01' rowspan='2'>Nilai Buku $fmFiltThnBuku </th>
					":"";
					if($tipe=='kertaskerja'){
					
						$headerTable="
						<tr>
						<th class=\"th01\" rowspan=\"2\">No.</th>				
						$tampilCheckbox
						<th class=\"th01\" rowspan=\"2\" style='width:60'>Kode Barang</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Nomor Reg</th>
						<th class=\"th01\" rowspan=\"2\" style='width:150'>Nama Barang</th>
						<!--<th class=\"th01\" rowspan=\"2\" style=''>Tahun Perolehan</th>-->
						<th class=\"th02\" colspan=\"2\">Buku Perpustakaan</th>
						<th class=\"th02\" colspan=\"3\">Barang Bercorak Kesenian / Kebudayaan</th>
						<th class=\"th02\" colspan=\"2\">Hewan Ternak <br> Dan Tumbuhan</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Jumlah</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Tahun Cetak / Beli</th>
						<th class=\"th01\" rowspan=\"2\">Cara Perolehan / Sumber Dana / Status Barang</th>
						<th class=\"th01\" rowspan=\"2\" style='width:70'>$tampilHeaderHarga</th>
						<th class=\"th01\" rowspan=\"2\" style=''>Kondisi</th>
						<th class=\"th01\" rowspan=\"2\" style='min-width:100;'>Ket.</th>
						$tampilDok
						$vBidang
						$tampilCbxKeranjangHead	
						</tr>
						<tr>
						<th class=\"th01\" style='width:100'>Judul / Pencipta</th>
						<th class=\"th01\" style='width:50'>Spesifikasi</th>
						<th class=\"th01\" style='width:50'>Asal Daerah</th>
						<th class=\"th01\" style='width:50'>Pencipta</th>
						<th class=\"th01\" style='width:50'>Bahan</th>
						<th class=\"th01\" style='width:50'>Jenis</th>
						<th class=\"th01\" style='width:50'>Ukuran</th>
						</tr>
						$tambahgaris";
					}else{
						$headerTable="
						<tr>
						<th class=\"th02\" colspan=\"". ($cetak? "3": "4") ."\">N o m o r</th>
						
						<th class=\"th01\" rowspan=\"2\" style='width:150'>Nama Barang</th>
						<!--<th class=\"th01\" rowspan=\"2\" style=''>Tahun Perolehan</th>-->
						<th class=\"th02\" colspan=\"2\">Buku Perpustakaan</th>
						<th class=\"th02\" colspan=\"3\">Barang Bercorak Kesenian / Kebudayaan</th>
						<th class=\"th02\" colspan=\"2\">Hewan Ternak</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Jumlah</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Tahun Cetak / Beli</th>
						<th class=\"th01\" rowspan=\"2\">Cara&nbsp;Perolehan&nbsp;/ Sumber&nbsp;Dana&nbsp;/ Status&nbsp;Barang&nbsp;/<br> Kondisi /<br>Penggunaan</th>
						<th class=\"th01\" rowspan=\"2\" style='width:70'>$tampilHeaderHarga</th>
						$vbast
						$vspk
						<th class=\"th01\" rowspan=\"2\" style='min-width:150;'>Ket.</th>
						$tampilDok
						$vBidang
						$tampilCbxKeranjangHead	
						$status_survey_header
						$tampil_susut_header
						</tr>
						<tr>
						<th class=\"th01\" rowspan=\"\">No.</th>				
						$tampilCheckbox
						<th class=\"th01\" rowspan=\"\" style='width:60'>Kode Barang/<br>ID Barang/<br>ID Awal</th>
						<th class=\"th01\" rowspan=\"\" style='width:50'>Reg.</th>
						
						<th class=\"th01\" style='width:100'>Judul / Pencipta</th>
						<th class=\"th01\" style='width:50'>Spesifikasi</th>
						<th class=\"th01\" style='width:50'>Asal Daerah</th>
						<th class=\"th01\" style='width:50'>Pencipta</th>
						<th class=\"th01\" style='width:50'>Bahan</th>
						<th class=\"th01\" style='width:50'>Jenis</th>
						<th class=\"th01\" style='width:50'>Ukuran</th>
						</tr>
						$tambahgaris";
					}
					break;
				}
				case "09" : case "kib_f_cetak" :{
					$tampilCheckbox =  $cetak ? "" : "<th class='th01' rowspan=''><input type='checkbox' name='toggle' value='' onClick='checkAll(".$Main->PagePerHal.")'></th>";
					$width_alm = $cetak ? '' :'min-width:150;';
					$width_ket = $cetak ? '' :'min-width:100;';
					$cp = $cetak? 18:19;
					for ($i=0;$i<$cp;$i++){
						$tambahgaris .= "<th class='$clGaris' style='padding:0'></th>";
					}
					$tambahgaris .= '</tr>';
					$status_survey_header=$Main->STATUS_SURVEY==1 ? "<th class='th01' rowspan='2'>Status Recon</th>":"";

					$headerTable="
					<tr>
					<th class=\"th02\" colspan=\"". ($cetak? "3": "4") ."\">N o m o r</th>
					
					<th class=\"th01\" rowspan=\"2\" style='width:200'>Nama Barang</th>
					<th class=\"th01\" rowspan=\"2\" style=''>Tahun Perolehan</th>
					<th class=\"th01\" rowspan=\"2\" style='width:50'>Bangunan(P,SP,D)</th>
					<th class=\"th02\" colspan=\"2\">Konstruksi Bangunan</th>
					<th class=\"th01\" rowspan=\"2\" style='width:50'>Luas (m2)</th>
					<th class=\"th01\" rowspan=\"2\" style='$width_alm'>Letak / Alamat</th>
					<th class=\"th02\" colspan=\"2\">Dokumen</th>
					<th class=\"th01\" rowspan=\"2\" style='width:80'>Tanggal Mulai</th>
					<th class=\"th01\" rowspan=\"2\" style='width:50'>Status Tanah</th>
					<th class=\"th01\" rowspan=\"2\" style='width:50'>Kode Tanah</th>
					<th class=\"th01\" rowspan=\"2\" style='width:50'>Cara&nbsp;Perolehan&nbsp;/ Sumber&nbsp;Dana&nbsp;/ Status&nbsp;Barang&nbsp;/<br> Kondisi /<br>Penggunaan</th>
					<th class=\"th01\" rowspan=\"2\" style='width:75'>Harga Kontrak (Ribuan)</th>
					$vbast
					$vspk	
					<th class=\"th01\" rowspan=\"2\" style='$width_ket'>Ket</th>
					$tampilDok
					$vBidang
					$tampilCbxKeranjangHead
					$status_survey_header
					
					</tr>
					<tr>
					<th class=\"th01\" rowspan=\"\">No.</th>
					$tampilCheckbox
					<th class=\"th01\" rowspan=\"\" style='width:60'>Kode Barang/<br>ID Barang/<br>ID Awal</th>
					<th class=\"th01\" rowspan=\"\" style='width:50'>Reg.</th>
					
					<th class=\"th01\" style='width:50'>Bertingkat/ Tidak</th>
					<th class=\"th01\" style='width:50'>Beton/ Tidak</th>
					<th class=\"th01\" style='width:80'>Tanggal</th>
					<th class=\"th01\" style='width:50'>Nomor</th>				
					</tr>
					$tambahgaris";
					break;
				}
				case "kibg" : case "kib_g_cetak" :{					
					$tampilCheckbox =  $cetak ? "" : "<th class='th01' rowspan=''><input type='checkbox' name='toggle' value='' onClick='checkAll(".$Main->PagePerHal.")'></th>";
					$cp = $cetak? 12:13;
					for ($i=0;$i<$cp;$i++){
						$tambahgaris .= "<th class='$clGaris' style='padding:0'></th>";
					}
					$tambahgaris .= '</tr>';
					$status_survey_header=$Main->STATUS_SURVEY==1 ? "<th class='th01' rowspan='2'>Status Recon</th>":"";
					$tampil_susut_header=$Main->TAMPIL_SUSUT==1 ? 
					"<th class='th01' rowspan='2'>Nilai Sisa</th>
					<th class='th01' rowspan='2'>Umur Ekonomis</th>
					<th class='th01' rowspan='2'>Nilai Penyusutan <br>Per Tahun</th>
					<th class='th01' rowspan='2'>Lama/Umur <br>Penggunaan Per 31 Desember $fmFiltThnBuku2 </th>
					<th class='th01' rowspan='2'>Nilai Penyusutan s/d 31 Desember $fmFiltThnBuku2 </th>
					<th class='th01' rowspan='2'>Nilai Penyusutan Tahun $fmFiltThnBuku </th>
					<th class='th01' rowspan='2'>Nilai Buku $fmFiltThnBuku </th>
					":"";
					if($tipe=='kertaskerja'){
					
						$headerTable="
						<tr>
						<th class=\"th01\" rowspan=\"2\">No.</th>				
						$tampilCheckbox
						<th class=\"th01\" rowspan=\"2\" style='width:60'>Kode Barang</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Nomor Reg</th>
						<th class=\"th01\" rowspan=\"2\" style='width:150'>Nama Barang</th>
						<!--<th class=\"th01\" rowspan=\"2\" style=''>Tahun Perolehan</th>-->
						<th class=\"th02\" colspan=\"2\">Buku Perpustakaan</th>
						<th class=\"th02\" colspan=\"3\">Barang Bercorak Kesenian / Kebudayaan</th>
						<th class=\"th02\" colspan=\"2\">Hewan Ternak <br> Dan Tumbuhan</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Jumlah</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Tahun Cetak / Beli</th>
						<th class=\"th01\" rowspan=\"2\">Cara Perolehan / Sumber Dana / Status Barang</th>
						<th class=\"th01\" rowspan=\"2\" style='width:70'>$tampilHeaderHarga</th>
						<th class=\"th01\" rowspan=\"2\" style=''>Kondisi</th>
						<th class=\"th01\" rowspan=\"2\" style='min-width:100;'>Ket.</th>
						$tampilDok
						$vBidang
						$tampilCbxKeranjangHead	
						</tr>
						<tr>
						<th class=\"th01\" style='width:100'>Judul / Pencipta</th>
						<th class=\"th01\" style='width:50'>Spesifikasi</th>
						<th class=\"th01\" style='width:50'>Asal Daerah</th>
						<th class=\"th01\" style='width:50'>Pencipta</th>
						<th class=\"th01\" style='width:50'>Bahan</th>
						<th class=\"th01\" style='width:50'>Jenis</th>
						<th class=\"th01\" style='width:50'>Ukuran</th>
						</tr>
						$tambahgaris";
					}else{
						$headerTable="
						<tr>
						<th class=\"th02\" colspan=\"". ($cetak? "3": "4") ."\">N o m o r</th>
						
						<th class=\"th01\" rowspan=\"2\" style='width:250'>Nama Barang</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Tahun Perolehan</th>
						<th class=\"th01\" rowspan=\"2\" style='width:200'>Judul</th>
						<th class=\"th01\" rowspan=\"2\" style='width:150'>Pencipta</th>
						<th class=\"th01\" rowspan=\"2\" style='width:150'>Jenis</th>
						<th class=\"th01\" rowspan=\"2\" style='width:50'>Jumlah</th>
						<th class=\"th01\" rowspan=\"2\">Cara&nbsp;Perolehan&nbsp;/ Sumber&nbsp;Dana&nbsp;/ Status&nbsp;Barang&nbsp;/<br> Kondisi /<br>Penggunaan</th>
						<th class=\"th01\" rowspan=\"2\" style='width:70'>$tampilHeaderHarga</th>
						$vbast
						$vspk
						<th class=\"th01\" rowspan=\"2\" style='min-width:150;'>Ket.</th>
						$tampilDok
						$vBidang
						$tampilCbxKeranjangHead	
						$status_survey_header
						$tampil_susut_header
						</tr>
						<tr>
						<th class=\"th01\" rowspan=\"\">No.</th>				
						$tampilCheckbox
						<th class=\"th01\" rowspan=\"\" style='width:60'>Kode Barang/<br>ID Barang/<br>ID Awal</th>
						<th class=\"th01\" rowspan=\"\" style='width:50'>Reg.</th>
						</tr>
						$tambahgaris";
					}
					break;
				}
				
				
			}
			return $headerTable;
		}
		
	function genSubtitle($titleCaption=''){
			$ToolbarATas=
			"<!-- toolbar atas -->
			<div style='float:right;'>
			<script>
			function Penatausahaan_CetakHal(){
				adminForm.action='?Pg=PR&SPg=$spg';
				adminForm.target='_blank';
				adminForm.submit();		
				adminForm.target='';
			}
			function Penatausahaan_CetakAll(){
				adminForm.action='?Pg=PR&SPg=$spg&ctk=1';
				adminForm.target='_blank';
				adminForm.submit();
				adminForm.target='';
			}
			function Penatausahaan_Cetakxls(){
				adminForm.action='?Pg=PR&SPg=$spg&ctk=1&xls=1';
				adminForm.target='_blank';
				adminForm.submit();
				adminForm.target='';
			}			
			function Penatausahaan_CetakKertasKerja(){
				adminForm.action='?Pg=PR&SPg=$spg&ctk=1&tipe=kertaskerja';
				adminForm.target='_blank';
				adminForm.submit();		
				adminForm.target='';
			}
			</script>			
			<table width='125'><tr>
			$ToolbarAtas_edit
			<td>".PanelIcon1("javascript:cetakBrg()","print_f2.png","Barang")."</td>
			<td>".PanelIcon1("javascript:Penatausahaan_CetakHal()","print_f2.png","Halaman")."</td>
			<td>".PanelIcon1("javascript:Penatausahaan_CetakAll()","print_f2.png","Semua")."</td>					
			<td>".PanelIcon1("javascript:Penatausahaan_Cetakxls()","export_xls.png","Excel")."</td>						
			
			</tr></table>			
			</div>";
			$Title = 
			"<table class=\"adminheading\">
			<tr>
			<th height=\"47\" class=\"user\">".$titleCaption."</th>
			<th>
			".$ToolbarATas."
			</th>
			</tr>
			</table>";
			
			return $Title;
		}


	function tampilTotal_($jmlTotalHargaHal, $jmlTotalHarga, $cetak=FALSE, $cbxDlmRibu=FALSE, $clspn1, $clspn2, $clGaris='', $clRow='', $img='',$totalSusutPrevHal2=0,$totalSusutSkrHal2=0,$totalNilaiBukuHal2=0) {
	    global $Main ;
		$tampilTotalHal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHargaHal / 1000), 2, ',', '.') : number_format(($jmlTotalHargaHal), 2, ',', '.');
	    if ($jmlTotalHarga > 0){
			$tampilTotal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHarga / 1000), 2, ',', '.') : number_format(($jmlTotalHarga), 2, ',', '.');
		}
		//$kolStatusSurvey = $Main->STATUS_SURVEY? "<td class=\"$clGaris\" align=right>&nbsp;</td>" :'';
		if($Main->MODUL_BAST) $clspn2 ++;
		if($Main->MODUL_SPK) $clspn2 ++;
		if($Main->STATUS_SURVEY)  $clspn2 ++;
		$kolTampilSusut = $Main->TAMPIL_SUSUT? "
				<td class=\"$clGaris\" align=right><div id=\"Totnilaisisa\" name=\"Totnilaisisa\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totumurekonomis\" name=\"Totumurekonomis\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusutpertahun\" name=\"Totsusutpertahun\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totlama_penggunaan\" name=\"Totlama_penggunaan\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusut_sd\" name=\"Totsusut_sd\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusut_tahun\" name=\"Totsusut_tahun\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totnilaibuku\" name=\"Totnilaibuku\">&nbsp;</div></td>
				" :'';
		$kolTampilSusut2 = $Main->TAMPIL_SUSUT? "
				<td class=\"$clGaris\" align=right><div id=\"TotnilaisisaHal\" name=\"TotnilaisisaHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"TotumurekonomisHal\" name=\"TotumurekonomisHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"TotsusutpertahunHal\" name=\"TotsusutpertahunHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totlama_penggunaanHal\" name=\"Totlama_penggunaanHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusut_sdHal\" name=\"Totsusut_sdHal\"><b>" . number_format($totalSusutPrevHal2,2,',','.') . "</b></div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusut_tahunHal\" name=\"Totsusut_tahunHal\"><b>" . number_format($totalSusutSkrHal2,2,',','.') . "</b></div></td>
				<td class=\"$clGaris\" align=right><div id=\"TotnilaibukuHal\" name=\"TotnilaibukuHal\"><b>" . number_format($totalNilaiBukuHal2,2,',','.') . "</b></div></td>
				" :'';
	    
	    $ListTotal = $cetak ?
	            "<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=" . ($clspn1 - 1) . " >Jumlah Harga " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
					<td class=\"$clGaris\" colspan=" . ($clspn2 - 1) . " align=right>&nbsp;</td>
					$kolTampilSusut2
					</tr>
					" : "
					<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=$clspn1 >Jumlah Harga per Halaman " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
					<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
					$kolTampilSusut2
					</tr>
					<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=$clspn1 >Total Harga Seluruhnya " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right><div id='cntTotHarga' name='cntTotHarga' >$img<b>" . $tampilTotal . "</div></td>
					<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
					$kolTampilSusut
					</tr>
				";
	    return $ListTotal;
	}

		
	function tampilTotalA_($jmlTotalHargaHal, $jmlTotalHarga, $cetak=FALSE, $cbxDlmRibu=FALSE, $clspn1, $clspn2, $clGaris='', $clRow='', $img='', $luas_tanah_hal=0, $luas_tanah=0) {
		global $Main;
	    //u kib a
		$txls = $_REQUEST['xls']=="1"?"1":"";
		if ($txls=="1"){
		$tampilTotalHal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHargaHal / 1000), 2, '.', '') : number_format(($jmlTotalHargaHal), 2, '.', '');
	    if ($jmlTotalHarga > 0){
			$tampilTotal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHarga / 1000), 2, '.', '') : number_format(($jmlTotalHarga), 2, '.', '');

		} 
		$vluas_tanah_hal = number_format($luas_tanah_hal,2,'.','');
		$vluas_tanah = number_format($luas_tanah,2,'.','');

		} else 
		{
		$tampilTotalHal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHargaHal / 1000), 2, ',', '.') : number_format(($jmlTotalHargaHal), 2, ',', '.');
	    if ($jmlTotalHarga > 0){
			$tampilTotal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHarga / 1000), 2, ',', '.') : number_format(($jmlTotalHarga), 2, ',', '.');

		} 
		$vluas_tanah_hal = number_format($luas_tanah_hal,2,',','.');
		$vluas_tanah = number_format($luas_tanah,2,',','.');
			
		}
		if($Main->MODUL_BAST) $clspn2 ++;
		if($Main->MODUL_SPK) $clspn2 ++;
		if($Main->STATUS_SURVEY)  $clspn2 ++;
		
		//if($this->tamp) $clspn2 
	    $ListTotal = $cetak ?
	            "<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=4 >Jumlah Harga " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right>
					<b>" . $vluas_tanah_hal . "
					</td>
					<td class=\"$clGaris\" colspan=7 ></td>
					<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
					<td class=\"$clGaris\" colspan=" . ($clspn2 - 1) . " align=right>&nbsp;</td>
					</tr>" : 
					
					"<tr class=\"$clRow\">
						<td class=\"$clGaris\" colspan=5 >Jumlah Harga per Halaman " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
						<td class=\"$clGaris\" align=right><b>" . $vluas_tanah_hal . "</td>
						<td class=\"$clGaris\" colspan=7 ></td>
					
						<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
						<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
					</tr>
					<tr class=\"$clRow\">
						<td class=\"$clGaris\" colspan=5 >Total Harga Seluruhnya " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
						<td class=\"$clGaris\" align=right>
							<div id='cntTotLuas' name='cntTotHarga' >$img<b>" . $vluas_tanah . "</div>
						</td>
						<td class=\"$clGaris\" colspan=7 ></td>
					
						<td class=\"$clGaris\" align=right>
							<div id='cntTotHarga' name='cntTotHarga' >$img<b>" . $tampilTotal . "</div>
						</td>
						<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
					</tr>
				";
	    return $ListTotal;
	}
	
	function tampilTotalC_($jmlTotalHargaHal, $jmlTotalHarga, $cetak=FALSE, $cbxDlmRibu=FALSE, $clspn1, $clspn2, $clGaris='', $clRow='', $img='', $luas_tanah_hal=0, $luas_tanah=0) {
	    global $Main ;
		//u kib a
		$txls = $_REQUEST['xls']=="1"?"1":"";
		if ($txls=="1"){		
		$tampilTotalHal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHargaHal / 1000), 2, '.', '') : number_format(($jmlTotalHargaHal), 2, '.', '');
	    if ($jmlTotalHarga > 0){
			$tampilTotal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHarga / 1000), 2, '.', '') : number_format(($jmlTotalHarga), 2, '.', '');
		}
		$vluas_tanah_hal = number_format($luas_tanah_hal,2,'.','');
		$vluas_tanah = number_format($luas_tanah,2,'.','');
		} else {
		$tampilTotalHal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHargaHal / 1000), 2, ',', '.') : number_format(($jmlTotalHargaHal), 2, ',', '.');
	    if ($jmlTotalHarga > 0){
			$tampilTotal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHarga / 1000), 2, ',', '.') : number_format(($jmlTotalHarga), 2, ',', '.');
		}
		$vluas_tanah_hal = number_format($luas_tanah_hal,2,',','.');
		$vluas_tanah = number_format($luas_tanah,2,',','.');
			
		}
		if($Main->MODUL_BAST) $clspn2 ++;
		if($Main->MODUL_SPK) $clspn2 ++;
		if($Main->STATUS_SURVEY)  $clspn2 ++;
		$kolTampilSusut = $Main->TAMPIL_SUSUT? "
				<td class=\"$clGaris\" align=right><div id=\"Totnilaisisa\" name=\"Totnilaisisa\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totumurekonomis\" name=\"Totumurekonomis\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusutpertahun\" name=\"Totsusutpertahun\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totlama_penggunaan\" name=\"Totlama_penggunaan\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusut_sd\" name=\"Totsusut_sd\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusut_tahun\" name=\"Totsusut_tahun\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totnilaibuku\" name=\"Totnilaibuku\">&nbsp;</div></td>
				" :'';
		$kolTampilSusut2 = $Main->TAMPIL_SUSUT? "
				<td class=\"$clGaris\" align=right><div id=\"TotnilaisisaHal\" name=\"TotnilaisisaHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"TotumurekonomisHal\" name=\"TotumurekonomisHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"TotsusutpertahunHal\" name=\"TotsusutpertahunHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totlama_penggunaanHal\" name=\"Totlama_penggunaanHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusut_sdHal\" name=\"Totsusut_sdHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusut_tahunHal\" name=\"Totsusut_tahunHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"TotnilaibukuHal\" name=\"TotnilaibukuHal\">&nbsp;</div></td>
				" :'';
	    $ListTotal = $cetak ?
	            "<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=11 >Jumlah Harga " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right>
					<b>" . $vluas_tanah_hal . "
					</td>
					<td class=\"$clGaris\" colspan=3 ></td>
					<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
					<td class=\"$clGaris\" colspan=" . ($clspn2 - 1) . " align=right>&nbsp;</td>
					$kolTampilSusut
					</tr>
					" : "
					<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=12 >Jumlah Harga per Halaman " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<!--<td class=\"$clGaris\" align=right>
					<b>" . $vluas_tanah_hal . "
					</td>-->
					<td class=\"$clGaris\" colspan=4 ></td>
					
					<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
					<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
					$kolTampilSusut2
					</tr>
					
					<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=12 >Total Harga Seluruhnya " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<!--<td class=\"$clGaris\" align=right>
					<div id='cntTotLuas' name='cntTotHarga' >$img<b>" . $vluas_tanah . "</div>
					</td>-->
					<td class=\"$clGaris\" colspan=4 ></td>
					
					<td class=\"$clGaris\" align=right>
					<div id='cntTotHarga' name='cntTotHarga' >$img<b>" . $tampilTotal . "</div></td>
					<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
					$kolTampilSusut
					</tr>
				";
	    return $ListTotal;
	}
	
	function tampilTotalD_($jmlTotalHargaHal, $jmlTotalHarga, $cetak=FALSE, $cbxDlmRibu=FALSE, $clspn1, $clspn2, $clGaris='', $clRow='', $img='', $luas_tanah_hal=0, $luas_tanah=0, $cp3=7,$totalSusutPrevHal2=0,$totalSusutSkrHal2=0,$totalNilaiBukuHal2=0) { 
	    global $Main ;
		//u kib a
		$tampilTotalHal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHargaHal / 1000), 2, ',', '.') : number_format(($jmlTotalHargaHal), 2, ',', '.');
	    if ($jmlTotalHarga > 0){
			$tampilTotal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHarga / 1000), 2, ',', '.') : number_format(($jmlTotalHarga), 2, ',', '.');
		}
		$vluas_tanah_hal = number_format($luas_tanah_hal,2,',','.');
		$vluas_tanah = number_format($luas_tanah,2,',','.');
		if($Main->MODUL_BAST) $clspn2 ++;
		if($Main->MODUL_SPK) $clspn2 ++;
		if($Main->STATUS_SURVEY)  $clspn2 ++;
		$kolTampilSusut = $Main->TAMPIL_SUSUT? "
				<td class=\"$clGaris\" align=right><div id=\"Totnilaisisa\" name=\"Totnilaisisa\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totumurekonomis\" name=\"Totumurekonomis\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusutpertahun\" name=\"Totsusutpertahun\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totlama_penggunaan\" name=\"Totlama_penggunaan\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusut_sd\" name=\"Totsusut_sd\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusut_tahun\" name=\"Totsusut_tahun\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totnilaibuku\" name=\"Totnilaibuku\">&nbsp;</div></td>
				" :'';
		$kolTampilSusut2 = $Main->TAMPIL_SUSUT? "
				<td class=\"$clGaris\" align=right><div id=\"TotnilaisisaHal\" name=\"TotnilaisisaHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"TotumurekonomisHal\" name=\"TotumurekonomisHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"TotsusutpertahunHal\" name=\"TotsusutpertahunHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totlama_penggunaanHal\" name=\"Totlama_penggunaanHal\">&nbsp;</div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusut_sdHal\" name=\"Totsusut_sdHal\"><b>" . number_format($totalSusutPrevHal2,2,',','.') . "</b></div></td>
				<td class=\"$clGaris\" align=right><div id=\"Totsusut_tahunHal\" name=\"Totsusut_tahunHal\"><b>" . number_format($totalSusutSkrHal2,2,',','.') . "</b></div></td>
				<td class=\"$clGaris\" align=right><div id=\"TotnilaibukuHal\" name=\"TotnilaibukuHal\"><b>" . number_format($totalNilaiBukuHal2,2,',','.') . "</b></div></td>
				" :'';
	    $ListTotal = $cetak ?
	            "<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=8 >Jumlah Harga " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right>
					<b>" . $vluas_tanah_hal . "
					</td>
					<td class=\"$clGaris\" colspan=$cp3 ></td>
					<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
					<td class=\"$clGaris\" colspan=" . ($clspn2 - 1) . " align=right>&nbsp;</td>
					$kolTampilSusut2
					</tr>
					" : "
					<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=9 >Jumlah Harga per Halaman " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right>
					<b>" . $vluas_tanah_hal . "
					</td>
					<td class=\"$clGaris\" colspan=$cp3 ></td>
					
					<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
					<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
					$kolTampilSusut2
					</tr>
					
					<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=9 >Total Harga Seluruhnya " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right>
					<div id='cntTotLuas' name='cntTotHarga' >$img<b>" . $vluas_tanah . "</div>
					</td>
					<td class=\"$clGaris\" colspan=$cp3 ></td>
					
					<td class=\"$clGaris\" align=right>
					<div id='cntTotHarga' name='cntTotHarga' >$img<b>" . $tampilTotal . "</div></td>
					<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
					$kolTampilSusut
					</tr>
				";
	    return $ListTotal;
	}
	
	function tampilTotalF_($jmlTotalHargaHal, $jmlTotalHarga, $cetak=FALSE, $cbxDlmRibu=FALSE, $clspn1, $clspn2, $clGaris='', $clRow='', $img='', $luas_tanah_hal=0, $luas_tanah=0) {
		global $Main;
	    //u kib a
		$tampilTotalHal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHargaHal / 1000), 2, ',', '.') : number_format(($jmlTotalHargaHal), 2, ',', '.');
	    if ($jmlTotalHarga > 0){
			$tampilTotal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHarga / 1000), 2, ',', '.') : number_format(($jmlTotalHarga), 2, ',', '.');
		}
		$vluas_tanah_hal = number_format($luas_tanah_hal,2,',','.');
		$vluas_tanah = number_format($luas_tanah,2,',','.');
		if($Main->MODUL_BAST) $clspn2 ++;
		if($Main->MODUL_SPK) $clspn2 ++;
		if($Main->STATUS_SURVEY)  $clspn2 ++;
	    $ListTotal = $cetak ?
	            "<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=8 >Jumlah Harga " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right>
					<b>" . $vluas_tanah_hal . "
					</td>
					<td class=\"$clGaris\" colspan=7 ></td>
					<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
					<td class=\"$clGaris\" colspan=" . ($clspn2 - 1) . " align=right>&nbsp;</td>
					</tr>
					" : "
					<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=9 >Jumlah Harga per Halaman " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right>
					<b>" . $vluas_tanah_hal . "
					</td>
					<td class=\"$clGaris\" colspan=7 ></td>
					
					<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
					<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
					</tr>
					
					<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=9 >Total Harga Seluruhnya " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right>
					<div id='cntTotLuas' name='cntTotHarga' >$img<b>" . $vluas_tanah . "</div>
					</td>
					<td class=\"$clGaris\" colspan=7 ></td>
					
					<td class=\"$clGaris\" align=right>
					<div id='cntTotHarga' name='cntTotHarga' >$img<b>" . $tampilTotal . "</div></td>
					<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
					</tr>
				";
	    return $ListTotal;
	}
	function tampilTotalG_($jmlTotalHargaHal, $jmlTotalHarga, $cetak=FALSE, $cbxDlmRibu=FALSE, $clspn1, $clspn2, $clGaris='', $clRow='', $img='', $luas_tanah_hal=0, $luas_tanah=0) {
	    //u kib g
		global $Main;
		
		$tampilTotalHal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHargaHal / 1000), 2, ',', '.') : number_format(($jmlTotalHargaHal), 2, ',', '.');
	    if ($jmlTotalHarga > 0){
			$tampilTotal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHarga / 1000), 2, ',', '.') : number_format(($jmlTotalHarga), 2, ',', '.');
		}
		$vluas_tanah_hal = number_format($luas_tanah_hal,2,',','.');
		$vluas_tanah = number_format($luas_tanah,2,',','.');
		if($Main->MODUL_BAST) $clspn2 ++;
		if($Main->MODUL_SPK) $clspn2 ++;
		if($Main->STATUS_SURVEY)  $clspn2 ++;
	    $ListTotal = $cetak ?
	            "<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=8 >Jumlah Harga " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right>
					<b>" . $vluas_tanah_hal . "
					</td>
					<td class=\"$clGaris\" colspan=7 ></td>
					<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
					<td class=\"$clGaris\" colspan=" . ($clspn2 - 1) . " align=right>&nbsp;</td>
					</tr>
					" : "
					<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=9 >Jumlah Harga per Halaman " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right>
					<b>" . $vluas_tanah_hal . "
					</td>
					<td class=\"$clGaris\" colspan=7 ></td>
					
					<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
					<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
					</tr>
					
					<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=9 >Total Harga Seluruhnya " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right>
					<div id='cntTotLuas' name='cntTotHarga' >$img<b>" . $vluas_tanah . "</div>
					</td>
					<td class=\"$clGaris\" colspan=7 ></td>
					
					<td class=\"$clGaris\" align=right>
					<div id='cntTotHarga' name='cntTotHarga' >$img<b>" . $tampilTotal . "</div></td>
					<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
					</tr>
				";
	    return $ListTotal;
	}
	
	function tampilTotalSusut($jmlTotalHargaHal, $jmlTotalHarga, $cetak=FALSE, 
			$cbxDlmRibu=FALSE, $clspn1, $clspn2, $clGaris='', $clRow='', $img='' ,
			$totalSusutPrevHal = 0,	$totalSusutSkrHal = 0, $totalSusutTotHal = 0, $totalNilaiBukuHal = 0			
	) {
	    
		$clspn1 = $clspn1-2;
		
		$tampilTotalHal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHargaHal / 1000), 2, ',', '.') : number_format(($jmlTotalHargaHal), 2, ',', '.');
	    if ($jmlTotalHarga > 0){
			$tampilTotal = !empty($cbxDlmRibu) ? number_format(($jmlTotalHarga / 1000), 2, ',', '.') : number_format(($jmlTotalHarga), 2, ',', '.');
		}
		//$totalNilaiBukuHal = $jmlTotalHargaHal - $totalSusutTotHal;
	    $ListTotal = $cetak ?
	            "<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=" . ($clspn1 - 1) . " >Jumlah Harga " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
					<!--<td class=\"$clGaris\" align=right><b>" . number_format($totalSusutPrevHal,2,',','.') . "</td>-->
					<td class=\"$clGaris\" align=right><b>" . number_format($totalSusutTotHal,2,',','.') . "</td>
					<td class=\"$clGaris\" align=right><b>" . number_format($totalNilaiBukuHal,2,',','.') . "</td>
					<td class=\"$clGaris\" align=right><b>" . number_format($totalSusutSkrHal,2,',','.') . "</td>
					<td class=\"$clGaris\" colspan=" . ($clspn2 - 1) . " align=right>&nbsp;</td>
				</tr>
					" : "
				<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=10 >Jumlah Harga per Halaman " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right><b>" . $tampilTotalHal . "</td>
					<!--<td class=\"$clGaris\" align=right><b>" . number_format($totalSusutPrevHal,2,',','.') . "</td>-->
					<td class=\"$clGaris\" align=right><b>" . number_format($totalSusutTotHal,2,',','.') . "</td>
					<td class=\"$clGaris\" align=right><b>" . number_format($totalNilaiBukuHal,2,',','.') . "</td>
					<td class=\"$clGaris\" align=right><b>" . number_format($totalSusutSkrHal,2,',','.') . "</td>
					<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
					</tr>
					<tr class=\"$clRow\">
					<td class=\"$clGaris\" colspan=$clspn1 >Total Harga Seluruhnya " . ( empty($cbxDlmRibu) ? "" : ("(Ribuan)") ) . "</td>
					<td class=\"$clGaris\" align=right><div id='cntTotHarga' name='cntTotHarga' >$img<b>" . $tampilTotal . "</div></td>
					<td class=\"$clGaris\" align=right><div id='cntTotSusut' name='cntTotSusut' ><b>" .  "</div></td>
					<td class=\"$clGaris\" align=right><div id='cntTotNilaibuku' name='cntTotNilaibuku' ><b>" . "</div></td>
					<td class=\"$clGaris\" align=right><div id='cntTotSusutSkr' name='cntTotSusutSkr' ><b>" .  "</div></td>
					
					<td class=\"$clGaris\" colspan=$clspn2 align=right>&nbsp;</td>
				</tr>
				";
	    return $ListTotal;
	}
	
			
}
$Penatausaha = new PenatausahaObj();

			
?>