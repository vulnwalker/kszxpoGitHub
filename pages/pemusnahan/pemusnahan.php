<?php
class pemusnahanObj extends DaftarObj2{
	var $Prefix = 'pemusnahan';
	var $SHOW_CEK = TRUE;	
	var $TblName = 'v_pemusnahan';//'v1_rkb'
	var $TblName_Hapus = 'pemusnahan_det';
	var $TblName_Edit = 'pemusnahan_det';
	var $KeyFields = array('Id');
	var $FieldSum = array('jumlah_harga','nilai_susut');
	var $fieldSum_lokasi = array(11,12);
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 10, 6, 6);
	var $FieldSum_Cp2 = array( 5, 5, 5);	
	var $totalCol = 16; //total kolom daftar
	//var $FormName = 'Sensus_form';
	//var $pagePerHal = 7;
	//var $thnsensus_default = 2013;
	//var $periode_sensus = 5;// tahun	
	var $PageTitle = '';
	var $PageIcon = '';	
	var $checkbox_rowspan = 2;
	var $fileNameExcel='pemusnahan.xls';
	var $Cetak_Judul = 'PEMUSNAHAN BARANG';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $fmST = 0;
	var $idpilih = '';
	
	function setPage_OtherScript(){
		$scriptload = 

					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".	
			 "<script type='text/javascript' src='js/pemusnahan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/master/ref_aset/refbarang.js' language='JavaScript' ></script>".	
			 "<script type='text/javascript' src='js/dkb.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/penghapusan/penghapusan_ins.js' language='JavaScript' ></script>".
			$scriptload;
	}
	function setTitle(){
		return 'PEMUSNAHAN BARANG';
		//return 'Rencana Kebutuhan Barang Milik D';
	}
	function setPage_Header(){	
	
		$jns = $_GET['jns'];	
		$Judul = $jns=='pelaporan'?'Pelaporan':'Pemindahtanganan';
		$IconJudul = $jns=='pelaporan'?'images/pelaporan_ico.png':'images/pemindahtanganan_ico.gif';
		//return createHeaderPage($this->PageIcon, $this->PageTitle);
		return createHeaderPage($IconJudul, $Judul,  
			'', FALSE, 'pageheader', $this->ico_width, $this->ico_height
		);
	}
	function setNavAtas(){
	global $Main;	
		$Pg = $_REQUEST['Pg'];
		$jns = $_GET['jns'];
		switch($Pg){
				case		'pemusnahanba': $styleMenu1_3 = " style='color:blue;'"; break;
				default		: $styleMenu1 = " style='color:blue;'"; break;
				
			}
		$menu_kibg1 =
			$Main->MODUL_ASET_LAINNYA?
			"<A href=\"index.php?Pg=05&SPg=kibg&jns=atb\" $styleMenu3_9 title='Aset Tak Berwujud'>ASET TAK BERWUJUD</a> |":'';
			/*if($Main->MENU_VERSI==3){
			";
			}else{*/
			$menu_pemusnahan="<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">
			<tr>
			<td class=\"menudottedline\" width=\"60%\" height=\"20\" style=\"text-align:right\"><b>
				<a href=\"index.php?Pg=10&bentuk=1&SSPg=\" title=\"PEMINDAHTANGANAN\">PEMINDAHTANGANAN</a>  |  
				<a $styleMenu1 href=\"pages.php?Pg=pemusnahan\" title=\"PEMUSNAHAN\">PEMUSNAHAN</a>&nbsp;&nbsp;&nbsp;
			</b></td>
			</tr>
			<!--<tr>
			<td class=\"menudottedline\" width=\"60%\" height=\"20\" style=\"text-align:right\"><b>
				<a $styleMenu1_3 href=\"pages.php?Pg=pemusnahanba\" title=\"Berita Acara\">Berita Acara </a>  |  
				<a $styleMenu1 href=\"pages.php?Pg=pemusnahan&jns=$jns\" title=\"Pemusnahan\">Pemusnahan</a>  
				
				
				|<a href=\"pages.php?Pg=pemusnahanrekap\" title=\"Rekap\">Rekap</a>  |  
				<a href=\"pages.php?Pg=pemusnahanrekap_skpd\" title=\"Rekap (SKPD)\">Rekap (SKPD)</a>  
				
				  &nbsp;&nbsp;&nbsp;
			</b></td>
			</tr>-->
			</table>";
			$menu_pemusnahan2="<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"100%\">
			<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
					<A href=\"index.php?Pg=05&SPg=03&jns=intra\"  title='Intrakomptabel'>INTRAKOMPTABEL</a> |
					<A href=\"index.php?Pg=05&SPg=03&jns=ekstra\"  title='Ekstrakomptabel'>EKSTRAKOMPTABEL</a> |
					<A href=\"index.php?Pg=05&SPg=03&jns=tetap\"  title='Aset Tetap Tanah'>ASET TETAP</a>  |    
					<A href=\"index.php?Pg=05&SPg=03&jns=pindah\" style='color:blue' title='Aset Lainnya'>ASET LAINNYA</a> |    
					<A href=\"index.php?Pg=09&SPg=01&SSPg=03&mutasi=1\"  title='Mutasi'>MUTASI</a>  |
					<A href=\"pages.php?Pg=Rekap3\" title='Rekap Mutasi' >REKAP MUTASI</a>
					| <A href=\"pages.php?Pg=Rekap2\" title='Rekap Neraca'  >KERTAS KERJA</a>
					| <A href=\"pages.php?Pg=Rekap1\" title='Rekap BI'  >NERACA</a>
					  &nbsp&nbsp&nbsp
					</td></tr>
			<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>".
					"<A href=\"index.php?Pg=05&SPg=03&jns=pindah\" $styleMenu3_13 title='Pemindahtanganan'>PEMINDAHTANGANAN</a> |    
					<A href=\"pages.php?Pg=pemusnahan&jns=$jns\" style='color:blue;' title='Pemusnahan'>PEMUSNAHAN</a> |   
					<A href=\"index.php?Pg=05&SPg=03&jns=mitra\" $styleMenu3_15 title='Kemitraan Dengan Pihak Ke Tiga'>KEMITRAAN</a> | 
					<A href=\"index.php?Pg=05&SPg=03&jns=tgr\" $styleMenu3_14 title='Tuntutan Ganti Rugi'>TGR</a> |        
					$menu_kibg1
					<A href=\"index.php?Pg=05&SPg=03&jns=lain\" $styleMenu3_10 title='Aset Lain-lain'>ASET LAIN LAIN</a> ".
					"&nbsp&nbsp&nbsp".
					"</td></tr>
			</table>";
			if($jns=='pelaporan'){
				return $menu_pemusnahan2;				
			}else{
				return $menu_pemusnahan;
			}
		
		//}
	}
	function setMenuEdit(){		
		return
			//"";
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru2()","new_f2.png","Baru",'DPBMD Baru')."</td>".
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit2()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Batal", 'Batal')."</td>";
			
			
	}
	
	function setKolomHeader($Mode=1, $Checkbox=''){
		$NomorColSpan = $Mode==1? 2: 1;
		$head_lama="<thead>
				<tr>
				
					<th class='th01' width='40' rowspan=2 >No.</th>
					$Checkbox		
					<th class='th01' rowspan=2 width='200'>Kode Barang/Kode Akun/<br>ID Barang</th>
					<th class='th01' rowspan=2 width='300'>Nama Barang/Nama Akun</th>		
					<th class='th01' rowspan=2 width='200'>No. Reg/Tahun</th>
	   				<th class='th02' colspan=2 width='400'>Spesifikasi</th>
	   				<th class='th01' rowspan=2 width='200'>Harga Perolehan</th>
	   				<th class='th01' rowspan=2 width='200'>Harga Akumulasi Penyusutan</th>
					<th class='th01' rowspan=2 width='100'>Kondisi Barang</th>
					<th class='th01' rowspan=2 width='300'>Unit Pengguna </th>
					<th class='th02' colspan=2>Berita Acara</th>
				</tr>
				<tr>
					<th class='th01' width=200>Merk/Type/Alamat</th>
		   			<th class='th01' width=200>No. Sertifikat / No. Pabrik / No. Chasis / No. Mesin / No. Polisi</th>
					<th class='th01' width='80'>Nomor </th>				
					<th class='th01' width='80'>Tanggal </th>
				</tr>
				
			</thead>";
		$head="<thead>
				<tr>
				
					<th class='th02' width='40' colspan=5 >Nomor.</th>
					<th class='th02' colspan=3 >Spesifikasi Barang</th>
					<th class='th01' rowspan=2 width='50'>Tahun Perolehan</th>
	   				<th class='th01' rowspan=2 width='50'>Kondisi Barang (B,KB,RB)	</th>
	   				<th class='th01' rowspan=2 width='50'>Harga Perolehan</th>
	   				<th class='th01' rowspan=2 width='50'>Harga Akumulasi Penyusutan</th>
					<th class='th02' colspan=2 >SK Kep. Daerah</th>
					<th class='th01' rowspan=2 >Keterangan/Tgl. Buku</th>
					<th class='th01' rowspan=2>Cara Pemusnahan</th>
				</tr>
				<tr>
					<th class='th01' rowspan=2 width='40'>No</th>
					$Checkbox		
					<th class='th01' rowspan=2 width='100'>Kode Barang</th>
					<th class='th01' rowspan=2 width='100'>ID Barang/ ID Awal	</th>		
					<th class='th01' rowspan=2 > Reg</th>
					<th class='th01' width=''>Nama / Jenis Barang</th>
					<th class='th01' width='70'>Merk/Type/</th>
		   			<th class='th01' width='70'>No. Sertifikat / No. Pabrik / No. Chasis / No. Mesin / No. Polisi</th>
					<th class='th01' >Nomor </th>				
					<th class='th01' >Tanggal </th>
				</tr>
				
			</thead>";
		$headerTable = $head
			;
		return $headerTable;
	}
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref,$HTTP_COOKIE_VARS,$Main;
		$vc1 = $Main->URUSAN?"c1='".$isi['c1']."' and":"";
		$get_c = mysql_fetch_array(mysql_query("select * from v_bidang where $vc1 c='".$isi['c']."'"));	
	 	$get_d = mysql_fetch_array(mysql_query("select * from v_opd where $vc1 c='".$isi['c']."' and d='".$isi['d']."'"));	
	 	$get_e = mysql_fetch_array(mysql_query("select * from v_unit where $vc1 c='".$isi['c']."' and d='".$isi['d']."' and e='".$isi['e']."'"));
	 	$get_e1 = mysql_fetch_array(mysql_query("select nm_skpd as nmseksi from ref_skpd where $vc1 c='".$isi['c']."' and d='".$isi['d']."' and e='".$isi['e']."' and e1='".$isi['e1']."'"));		
			
	 	$nama_skpd =$get_c['nmbidang'].'/<br>'.$get_d['nmopd'];
	 	$nama_unit =$get_e['nmunit'].'/<br>'.$get_e1['nmseksi'];
		
		$KondF = $Main->KD_BARANG_P108?"f1='".$isi['f1']."'  and f2='".$isi['f2']."'  and f='".$isi['f']."' and g='".$isi['g']."' and h='".$isi['h']."' and i='".$isi['i']."' and j='".$isi['j']."'":"f='".$isi['f']."' and g='".$isi['g']."' and h='".$isi['h']."' and i='".$isi['i']."' and j='".$isi['j']."'";
		
		$get_brg = mysql_fetch_array(mysql_query("select * from ref_barang where $KondF"));
	 	$get_jurnal = mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='".$isi['k']."' and kb='".$isi['l']."' and kc='".$isi['m']."' and kd='".$isi['n']."' and ke='".$isi['o']."' and kf='".$isi['kf']."'"));
		$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id='".$isi['id_bukuinduk']."'")) ;
		if($bi['f']=='01'){
			$aqry = "select * from kib_a where 
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);			
				$arrdet=mysql_fetch_array($qry);
			$merk=$arrdet['alamat'];
			$no_det=$arrdet['sertifikat_no'];
			$ukuran=$arrdet['luas']." m2";
		}
		if($bi['f']=='02'){
			$aqry = "select * from kib_b where 
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);			
				$arrdet=mysql_fetch_array($qry);
			$merk=$arrdet['merk'];
			$no_det=$arrdet['no_pabrik']."/".$arrdet['no_rangka']."/".$arrdet['no_mesin']."/".$arrdet['no_polisi'];
			$ukuran=$arrdet['ukuran']." ";
		}
		if($bi['f']=='03'){
			$aqry = "select * from kib_c where 
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);			
				$arrdet=mysql_fetch_array($qry);
			$merk=$arrdet['alamat'];
			$no_det=$arrdet['dokumen_no'];
			$ukuran=$Main->Bangunan[$arrdet['kondisi_bangunan']-1][1];
		}
		if($bi['f']=='04'){
			$aqry = "select * from kib_d where 
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);			
				$arrdet=mysql_fetch_array($qry);
			$merk=$arrdet['alamat'];
			$no_det=$arrdet['dokumen_no'];
			$ukuran=$Main->Bangunan[$arrdet['konstruksi']-1][1];
		}
		if($bi['f']=='05'){
			$aqry = "select * from kib_e where 
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);			
				$arrdet=mysql_fetch_array($qry);
			$merk=$arrdet['buku_judul']."/".$arrdet['buku_spesifikasi'];
			$no_det="";
			$ukuran=$arrdet['hewan_ukuran'];
		}
		if($bi['f']=='06'){
			$aqry = "select * from kib_f where 
				idbi='".$bi['id']."' ";
				$qry=mysql_query($aqry);			
				$arrdet=mysql_fetch_array($qry);
			$merk=$arrdet['alamat'];
			$no_det=$arrdet['dokumen_no'];
			$ukuran=$Main->Bangunan[$arrdet['bangunan']-1][1];
		}	 
		//1.baik, 2.kurang baik, 3.rusak berat
		if($isi['kondisi']=1){
			$kondisi = 'Baik';
		}elseif($isi['kondisi']=2){
			$kondisi = 'Kurang Baik';
		}elseif($isi['kondisi']=3){
			$kondisi = 'Rusak Berat';
		}else{
			$kondisi='';
		}
		$kdBarang = $Main->KD_BARANG_P108?$isi['f1'].'.'.$isi['f2'].'.'.$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j']:$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'];
		
		/*$Koloms = array();		
		$Koloms[] = array('align=right', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array('', 
			$kdBarang.'/<br>'.
			$isi['k'].'.'.$isi['l'].'.'.$isi['m'].'.'.$isi['n'].'.'.$isi['o'].'.'.$isi['kf'].'/<br>'.$isi['id_bukuinduk']				
		);
	 	$Koloms[] = array('', 
			$get_brg['nm_barang'].'<br>'.$get_jurnal['nm_account']
							
		);		
		$Koloms[] = array("align='left'", $isi['noreg'].'/'.$isi['thn_perolehan']  );
	 	$Koloms[] = array("align='left'", $merk) ;
	 	$Koloms[] = array("align='left'", $no_det);
	 	$Koloms[] = array("align='right'", number_format($isi['jumlah_harga'],2,',','.'));		
	 	$Koloms[] = array("align='right'", number_format($isi['nilai_susut'],2,',','.'));		
		$Koloms[] = array("align='left'",$kondisi  );
		$Koloms[] = array("align='left'", $nama_unit );
		$Koloms[] = array("align='left'",  $isi['no_ba']  );
		$Koloms[] = array("align='left'",  TglInd($isi['tgl_ba'] ) );
		//$Koloms[] = array('', $isi['ket']);*/
		
		$Koloms = array();		
		$Koloms[] = array('align=right', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array("align='left'", $kdBarang);
		$Koloms[] = array("align='left'", $isi['id_bukuinduk'].'/'.$isi['idbi_awal']  );
		$Koloms[] = array("align='left'", $isi['noreg']);
		$Koloms[] = array("align='left'", $get_brg['nm_barang']);
	 	$Koloms[] = array("align='left'", $merk) ;
	 	$Koloms[] = array("align='left'", $no_det);
		$Koloms[] = array("align='left'", $isi['thn_perolehan']  );
		$Koloms[] = array("align='left'",$kondisi  );		
	 	$Koloms[] = array("align='right'", number_format($isi['jumlah_harga'],2,',','.'));	
	 	$Koloms[] = array("align='right'", number_format($isi['nilai_susut'],2,',','.'));		
	 	$Koloms[] = array("align='left'",  $isi['no_ba']  );
		$Koloms[] = array("align='left'",  TglInd($isi['tgl_ba'] ) );
		$Koloms[] = array('', $isi['ket'].'/'.TglInd($isi['tgl_buku'])  );
	 	$Koloms[] = array("align='left'",  $isi['cara_pemusnahan']  );
		return $Koloms;
	}
	function setCekBox($cb, $KeyValueStr, $isi){
		return "<input type='checkbox' id='".$this->Prefix."_cb$cb' name='".$this->Prefix."_cb[]' 
					value='".$KeyValueStr."' stat='".$isi['stat']."'  onClick=\"isChecked2(this.checked,'".$this->Prefix."_jmlcek');\" />";					
	}
	
	function cmbQueryUrusan($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE) {
     global $Ref,$Main,$HTTP_COOKIE_VARS;
			
	 $aqry="select * from ref_skpd where c1!=0 and c='00' and d='00'  GROUP by c1";
	 $Query = mysql_query($aqry);
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $nmSKPDUrusan='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['c1'] ==  $value ? "selected" : "";
				if ($nmSKPDUrusan=='' ) $nmSKPDUrusan =  $value == $Hasil['c1'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[c1]}'>{$Hasil['c1']}. {$Hasil['nm_skpd']}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDUrusan <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	
	function cmbQueryBidang($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE) {
     global $Ref,$Main,$HTTP_COOKIE_VARS;
	 
	 	$fmSKPDUrusan = cekPOST('fmSKPDUrusan')!=$vAtas? cekPOST('fmSKPDUrusan'): $HTTP_COOKIE_VARS['cofmUrusan'];
			
	 $aqry=$Main->URUSAN==1?"select * from ref_skpd where c1='$fmSKPDUrusan' and c!='00' and d='00'  GROUP by c"
	 :"select * from ref_skpd where c!='00' and d='00'  GROUP by c";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDBidang='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['c'] ==  $value ? "selected" : "";
				if ($nmSKPDBidang=='' ) $nmSKPDBidang =  $value == $Hasil['c'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[c]}'>{$Hasil['c']}. {$Hasil['nm_skpd']}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDBidang <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	
	function cmbQuerySKPD($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE) {
	 global $Ref,$Main,$HTTP_COOKIE_VARS;
	 
		$fmSKPDUrusan = cekPOST('fmSKPDUrusan')!=$vAtas? cekPOST('fmSKPDUrusan'): $HTTP_COOKIE_VARS['cofmUrusan'];
		$fmSKPDBidang = cekPOST('fmSKPDBidang')!=$vAtas? cekPOST('fmSKPDBidang'): $HTTP_COOKIE_VARS['fmSKPDBidang'];
			
	 $aqry=$Main->URUSAN==1?"select * from ref_skpd where c1='$fmSKPDUrusan' and c='$fmSKPDBidang' and d!='00' and e='00' GROUP by d"
	 :"select * from ref_skpd where c='$fmSKPDBidang' and d!='00' and e='00' GROUP by d";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDskpd='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['d'] ==  $value ? "selected" : "";
				if ($nmSKPDskpd=='' ) $nmSKPDskpd =  $value == $Hasil['d'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[d]}'>{$Hasil['d']}. {$Hasil['nm_skpd']}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDskpd <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	
	function cmbQueryUnit($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE,$edit='') {
	 global $Ref,$Main,$HTTP_COOKIE_VARS;
	 if($edit==""){
	 	$fmSKPDBidang = cekPOST('fmSKPDBidang')!=$vAtas? cekPOST('fmSKPDBidang'): $HTTP_COOKIE_VARS['cofmSKPD'];
		$fmSKPDSkpd = cekPOST('fmSKPDskpd')!=$vAtas? cekPOST('fmSKPDskpd'): $HTTP_COOKIE_VARS['cofmUNIT'];
	 }else{
	 	$xplode=explode('.',$edit);
		$fmSKPDBidang=$xplode[0];
		$fmSKPDSkpd=$xplode[1];
	 }
		
			
	 $aqry="select * from ref_skpd where c='$fmSKPDBidang' and d='$fmSKPDSkpd' and e!='00' and e1='000' GROUP by e";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDUnit='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['e'] ==  $value ? "selected" : "";
				if ($nmSKPDUnit=='' ) $nmSKPDUnit =  $value == $Hasil['e'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[e]}'>{$Hasil[nm_skpd]}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDUnit <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	
	function cmbQuerySubUnit($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE,$edit='') {
	 global $Ref,$Main,$HTTP_COOKIE_VARS;
	 if($edit==""){
	 	$fmSKPDBidang = cekPOST('c')!=$vAtas? cekPOST('c'): $HTTP_COOKIE_VARS['cofmSKPD'];
		$fmSKPDSkpd = cekPOST('d')!=$vAtas? cekPOST('d'): $HTTP_COOKIE_VARS['cofmUNIT'];
		$fmSKPDUnit = cekPOST('fmSKPDUnit_form')!=$vAtas? cekPOST('fmSKPDUnit_form'): $HTTP_COOKIE_VARS['cofmSUBUNIT'];
	}else{
	 	$xplode=explode('.',$edit);
		$fmSKPDBidang=$xplode[0];
		$fmSKPDSkpd=$xplode[1];
		$fmSKPDUnit=$xplode[2];
	 }
			
	 $aqry="select * from ref_skpd where c='$fmSKPDBidang' and d='$fmSKPDSkpd' and e='$fmSKPDUnit' and e1!='000' GROUP by e1";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDUnit='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['e1'] ==  $value ? "selected" : "";
				if ($nmSKPDUnit=='' ) $nmSKPDUnit =  $value == $Hasil['e1'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[e1]}'>{$Hasil[nm_skpd]}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDUnit <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	
	function genDaftarInitial(){
		global $HTTP_COOKIE_VARS,$Main;
		$vOpsi = $this->genDaftarOpsi();
		$fmThnAnggaran=  $_COOKIE['coThnAnggaran'];
		$fmSKPDUrusan = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST('fmSKPDUrusan');
		$fmSKPDBidang = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST('fmSKPDBidang');
		$fmSKPDskpd = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST('fmSKPDskpd');
		$toolbar_bawah = $this->genToolbarBawah();
		$divHal = "<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
							"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
						"</div>";
		switch($this->daftarMode){						
			case '1' :{ //detail horisontal
				$vdaftar = 
					"<table width='100%'><tr valign=top>
					<td style='width:$this->containWidth;'>".
						"<div id='{$this->Prefix}_cont_daftar' style='position:relative;width:$this->containWidth;overflow:auto' >"."</div>".
						$divHal.
					"</td>".
					"<td>".
						"<div id='{$this->Prefix}_cont_daftar_det' style=''>".$this->genTableDetail()."</div>".
					"</td>".
					"</tr></table>";
				break;
			}
			default :{
				$vdaftar = 
					"<div id='{$this->Prefix}_cont_daftar' style='position:relative;' >"."</div>".
					$divHal;					
				break;
			}
		}
		
		return		
			//$NavAtas.	
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 
				"<input type='hidden' value='$fmThnAnggaran' id='fmThnAnggaran' name='fmThnAnggaran' >".
				"<input type='hidden' value='$fmSKPDUrusan' id='fmSKPDUrusan' name='fmSKPDUrusan' >".
				"<input type='hidden' value='$fmSKPDBidang' id='fmSKPDBidang' name='fmSKPDBidang' >".
				"<input type='hidden' value='$fmSKPDskpd' id='fmSKPDskpd' name='fmSKPDskpd' >".
			"</div>".	
			//"<div style='position:relative'>".
			$vdaftar.
			$toolbar_bawah.
			//"</div>".
			'';
	}
	
	function genDaftarOpsi(){
		global $Ref, $Main,$HTTP_COOKIE_VARS;
		$thn_login = $HTTP_COOKIE_VARS['coThnAnggaran'];
		
		//$fmSKPDBidang=cekPOST('fmSKPDBidang');
		// $fmSKPDskpd=cekPOST('fmSKPDskpd');
		 $fmThnAnggaran=  $_COOKIE['coThnAnggaran'];
		 $fmThnAnggaranDari=  cekPOST('fmThnAnggaranDari')=='' ? $fmThnAnggaran : cekPOST('fmThnAnggaranDari');
		 $fmThnAnggaranSampai=  cekPOST('fmThnAnggaranSampai')=='' ? $fmThnAnggaran : cekPOST('fmThnAnggaranSampai');
		
		$fmSKPDUrusan = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST('fmSKPDUrusan');
		$fmSKPDBidang = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST('fmSKPDBidang');
		$fmSKPDskpd = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST('fmSKPDskpd');
		$fmFiltThnBuku =  $_POST['fmFiltThnBuku']==''?$thn_login:$_POST['fmFiltThnBuku'];
		
		//data cari ----------------------------
		
		$arrCari = array(
			array('1','1'),
			array('2','2'), //array('3','Kode Rekening'),	//array('4','Nama Rekening')
		);
			
		 //get selectbox cari data :kode barang,nama barang
		 $fmkode_barang = cekPOST('fmkode_barang');
		 $fmid_awal = cekPOST('fmid_awal');
		 $fmid_barang = cekPOST('fmid_barang');
		 
		$filterc1=$Main->URUSAN==1?"<tr><td width='100'>Urusan</td><td width='10'>:</td><td>".
				$this->cmbQueryUrusan('fmSKPDUrusan',$fmSKPDUrusan,'','onchange='.$this->Prefix.'.UrusanAfter()','--- Pilih Urusan ---','0')."</td></tr>".
			"</td><tr>":"";
			
			$divskpd="<table width=\"100%\" class=\"adminform\">	
				<tr>		
					<td width=\"100%\" valign=\"top\">" . 
						//WilSKPD_ajx($this->Prefix) . 
						WilSKPD_ajx3($this->Prefix.'Skpd') . 
					"</td>
					<td >" . 
				
					"</td></tr>
				<tr>
					<td>
						
						<!--<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>-->
					</td>
				</tr>			
			</table>";
		$divskpdlama="<input type='hidden' value='".$Main->URUSAN."' id='settingurusan' name='settingurusan' >
			<table  class=\"adminform\"><tr>		
			<td width=\"100%\" valign=\"top\">
			<table>
			$filterc1
			<tr><td width='100'>Bidang</td><td width='10'>:</td><td>".
				$this->cmbQueryBidang('fmSKPDBidang',$fmSKPDBidang,'','onchange='.$this->Prefix.'.BidangAfter()'.$disabled1,'--- Pilih Bidang ---','00')."</td></tr>".
			"</td><tr>".
			"<tr><td width='100'>Skpd</td><td width='10'>:</td><td>".
				$this->cmbQuerySKPD('fmSKPDskpd',$fmSKPDskpd,'','onchange='.$this->Prefix.'.SKPDAfter()'.$disabled1,'--- Pilih Skpd ---','00').
			"</td><tr>
			<td width='100'>Tahun Anggaran</td><td width='10'>:</td><td>
				<input type='text'  size='4' value='$fmThnAnggaranDari' id='fmThnAnggaranDari' name='fmThnAnggaranDari' > s/d <input type='text'  size='4' value='$fmThnAnggaranSampai' id='fmThnAnggaranSampai' name='fmThnAnggaranSampai' >
				<td style='border-right:1px solid #E5E5E5;'></td></tr> 	
			</table></table>";
			
			switch($_GET['SSPg']){
				case '04': $KondisiKib =" where f='01'"; break;
				case '05': $KondisiKib =" where f='02'"; break;
				case '06': $KondisiKib =" where f='03'"; break;
				case '07': $KondisiKib =" where f='04'"; break;
				case '08': $KondisiKib =" where f='05'"; break;
				case '09': $KondisiKib =" where f='06'"; break;	
				case '10': $KondisiKib =" where f='07'"; break;	
				default : $KondisiKib =''; break; 
			}
			$filThnBuku = comboBySQL('fmFiltThnBuku',"select year(tgl_buku)as thnbuku from buku_induk $KondisiKib  group by thnbuku desc",
			'thnbuku', 'thnbuku', 'Semua Thn. Buku');
			
			//order by -------------------------------------------------------
			$AcsDsc1 = cekPOST("AcsDsc1");
			$odr1 = cekPOST("odr1");
			$selThnHapus = $odr1 == "year(tgl_penghapusan)" ? " selected " :  ""; //selected
			$opt1 = "<option value=''>--</option><option $selThnHapus value='year(tgl_penghapusan)'>Thn. Hapus</option>";
			$ListOrderBy = " 
				Urutkan berdasar : 
					<select name=odr1>$opt1</select><input $AcsDsc1 type=checkbox name=AcsDsc1 value='checked'>Desc. 		
				";
		$TampilOpt =$divskpd.			
				genFilterBar(
				array(	
					"Tampilkan : Kode Barang &nbsp;"
					."<input type='text'  size='12' value='$fmkode_barang' id='fmkode_barang' name='fmkode_barang'>&nbsp;"
					."ID Barang&nbsp;"
					."<input type='text'  size='12' value='$fmid_barang' id='fmid_barang' name='fmid_barang'>
					ID Awal &nbsp;"
					."<input type='text'  size='12' value='$fmid_awal' id='fmid_awal' name='fmid_awal'>
					Tahun &nbsp;"
					."<input type='text'  size='4' value='$fmFiltThnBuku' id='fmFiltThnBuku' name='fmFiltThnBuku' >
					"),$this->Prefix.".refreshList(true)",TRUE
				);
		
		return array('TampilOpt'=>$TampilOpt);
	}	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$thn_login = $HTTP_COOKIE_VARS['coThnAnggaran'];
		//kondisi -----------------------------------
		$arrKondisi = array();		
		$arrKondisi[] = "sttemp='0'";
		$arrKondisi[] = "st_hapus=0";
		$fmFiltThnBuku=  cekPOST('fmFiltThnBuku');
		$arrKondisi[]= !empty($fmFiltThnBuku) ? " year(tgl_buku) = '".$fmFiltThnBuku."' ":" year(tgl_buku) = '$thn_login' ";
		/*$fmUrusan = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST('fmSKPDUrusan');
		$fmURUSAN = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST($this->Prefix.'SkpdfmURUSAN');
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST('fmSKPDBidang');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST('fmSKPDskpd');*/
		//$fmSUBUNIT = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		//$fmSEKSI = isset($HTTP_COOKIE_VARS['cofmSEKSI'])? $HTTP_COOKIE_VARS['cofmSEKSI']: cekPOST($this->Prefix.'SkpdfmSEKSI');
		$fmURUSAN = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST($this->Prefix.'SkpdfmURUSAN');
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST($this->Prefix.'SkpdfmSKPD');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		$fmSEKSI = isset($HTTP_COOKIE_VARS['cofmSEKSI'])? $HTTP_COOKIE_VARS['cofmSEKSI']: cekPOST($this->Prefix.'SkpdfmSEKSI');
		
		if(!($fmURUSAN=='' || $fmURUSAN=='0') && ($Main->URUSAN==1) ) $arrKondisi[] = " c1 = '$fmURUSAN'";
		if(!($fmSKPD=='' || $fmSKPD=='00') ) $arrKondisi[] = " c = '$fmSKPD'";
		if(!($fmUNIT=='' || $fmUNIT=='00') ) $arrKondisi[] = " d= '$fmUNIT'";
		if(!($fmSUBUNIT=='' || $fmSUBUNIT=='00') ) $arrKondisi[] = " e = '$fmSUBUNIT'";
		if(!($fmSEKSI=='' || $fmSEKSI=='00') ) $arrKondisi[] = " e1 = '$fmSEKSI'";			
		
		$fmThnAnggaranDari=  cekPOST('fmThnAnggaranDari');
		$fmThnAnggaranSampai=  cekPOST('fmThnAnggaranSampai');
		$fmkode_barang = cekPOST('fmkode_barang');
		$fmid_awal = cekPOST('fmid_awal');
		$fmid_barang = cekPOST('fmid_barang');
		if(!empty($fmid_awal)) $arrKondisi[]= "  idbi_awal like '%$fmid_awal%'";
		if(!empty($fmid_barang)) $arrKondisi[]= "  id_bukuinduk like '%$fmid_barang%'";
		$concatkd = $Main->KD_BARANG_P108?"f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j":"f,'.',g,'.',h,'.',i,'.',j";
		if(!empty($fmkode_barang)) $arrKondisi[]= "  concat($concatkd) like '$fmkode_barang%'";
		/*if($Main->URUSAN==1 && !($fmUrusan=='' || $fmUrusan=='0')  ) $arrKondisi[] = "c1='$fmUrusan'";
		if(!($fmSKPD=='' || $fmSKPD=='00') ) $arrKondisi[] = "c='$fmSKPD'";
		if(!($fmUNIT=='' || $fmUNIT=='00') ) $arrKondisi[] = "d='$fmUNIT'";*/
		//if(!($fmSUBUNIT=='' || $fmSUBUNIT=='00') ) $arrKondisi[] = "e='$fmSUBUNIT'";
		//if(!($fmSEKSI=='' || $fmSEKSI=='00') ) $arrKondisi[] = "e1='$fmSEKSI'";
		if ($fmThnAnggaranDari == $fmThnAnggaranSampai){
		
			if(!($fmThnAnggaranDari=='')  && !($fmThnAnggaranSampai=='')) $arrKondisi[] = " thn_anggaran >= '$fmThnAnggaranDari' and thn_anggaran <= '$fmThnAnggaranSampai' ";
			switch($fmPILCARI){			
			case '1': $arrKondisi[] = " tgl_ba>='".$fmThnAnggaranDari."-01-01' and  cast(tgl_ba as DATE)<='".$fmThnAnggaranSampai."-06-30' "; break;
			case '2': $arrKondisi[] = " tgl_ba>='".$fmThnAnggaranDari."-07-01' and  cast(tgl_ba as DATE)<='".$fmThnAnggaranSampai."-12-31' "; break;
			default :""; break;
			}
		}else{
			if(!($fmThnAnggaranDari=='') && !($fmThnAnggaranSampai=='')) $arrKondisi[] = "thn_anggaran>='$fmThnAnggaranDari' and thn_anggaran<='$fmThnAnggaranSampai'";
		}
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
				
		
		$arrOrders = array();
		//$arrOrders[] = " a,b,c,d,e,nip ";
		switch($fmORDER1){
			case '1': $arrOrders[] = " tahun $Asc1 " ;break;
			case '2': $arrOrders[] = " concat(f,g,h,i,j) $Asc1 " ;break;
			case '3': $arrOrders[] = " concat(k,l,m,n,o) $Asc1 " ;break;
		}		
		
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//limit --------------------------------------
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	
	function getJmlDKB($tahun, $c, $d, $e,$e1, $f,$g,$h,$i,$j){
		$aqry = "select * from dkb where tahun='$tahun' and c='$c' and d='$d' and e='$e' and e1='$e1' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' ";
		$get =  mysql_fetch_array(mysql_query($aqry));
		if($get['jml_barang']== NULL) $get['jml_barang']=0;
		return $get['jml_barang'];
	}
	
	function setFormBaru(){
		$dt=array();
		$dt['c'] = $_REQUEST['fmSKPDBidang'];
		$dt['d'] = $_REQUEST['fmSKPDskpd'];
		$dt['tahun'] = $_COOKIE['coThnAnggaran'];
		$this->form_fmST = 0;
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	
	function setFormEdit(){		
		global $Main;
		$cek = ''; $err=''; $content='';// $json=FALSE;
		$form = '';
		
		//$err = $_REQUEST['rkbSkpdfmSKPD'];
		$cbid = $_POST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];		
		$this->form_fmST = 1;
		$form_name = $this->Prefix.'_form';
		
		$aqry = "select * from $this->TblName where Id='$this->form_idplh'";
		$dt = mysql_fetch_array(mysql_query($aqry));
		
		$akun = mysql_fetch_array(mysql_query("select * from ref_jurnal where concat(ka,kb,kc,kd,ke,kf)='".$dt['k'].$dt['l'].$dt['m'].$dt['n'].$dt['o'].$dt['kf']."'")) ;
		$dt['nm_account']=$akun['nm_account'];
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err']	, 'content'=> $fm['content']);
	}
	
	
	
	function setForm($dt){	
		global $fmIDBARANG,$fmIDREKENING,$Main;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	 	
	 $form_name = $this->Prefix.'_form';
	 $sw=$_REQUEST['sw'];
	 $sh=$_REQUEST['sh'];				
	 $this->form_width = $sw-50;
	 $this->form_height = $sh-100;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU';
	  }else{
		$this->form_caption = 'EDIT';
	  }
	 	
		//items ----------------------
		$editunit= $dt['e'] != '' ? $dt['c'].".".$dt['d']:'';
		$editsubunit=$dt['e1'] != '' ? $dt['c'].".".$dt['d'].".".$dt['e']:'';
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='00' "));
		$bidang = $get['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='00' "));
		$unit = $get['nm_skpd'];
		
	   	$brg = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,g,h,i,j)='".$dt['f'].$dt['g'].$dt['h'].$dt['i'].$dt['j']."'")) ;
	   	$kode_brg = $dt['f']==''? '' : $dt['f'].'.'.$dt['g'].'.'.$dt['h'].'.'.$dt['i'].'.'.$dt['j'] ;			
		$kode_account = $dt['k']==''? '' : $dt['k'].'.'.$dt['l'].'.'.$dt['m'].'.'.$dt['n'].'.'.$dt['o'].'.'.$dt['kf'];
		
		$vjmlharga = //$this->form_fmST==1?
			//number_format($dt['jml_harga'],0,',','.') :
			"<div>
			<input type='text' name='cnt_jmlharga' id='cnt_jmlharga' value='".number_format($dt['jml_harga'],0,',','.')."' readonly=''>
			<input type='button' value='Hitung' onclick=\"
				document.getElementById('cnt_jmlharga').innerHTML = 
					Kali('jml_barang', 'harga', 'cnt_jmlharga')\">&nbsp&nbsp
			</div>";
		if($dt['ref_iddkb']!='0' ){
			$pilihUnit=$this->cmbQueryUnit('fmSKPDUnit_form',$dt['e'],'','onchange=dpb.UnitAfter() '.$disabled1,'--- Pilih Unit ---','00',TRUE,$editunit);
			$pilihSubUnit=$this->cmbQuerySubUnit('fmSKPDSubUnit_form',$dt['e1'],'',' '.$disabled1,'--- Pilih Sub Unit ---','000',TRUE,$editsubunit) ;
		}else{
			$pilihUnit=$this->cmbQueryUnit('fmSKPDUnit_form',$dt['e'],'','onchange=dpb.UnitAfter() '.$disabled1,'--- Pilih Unit ---','00',FALSE,$editunit);
			$pilihSubUnit=$this->cmbQuerySubUnit('fmSKPDSubUnit_form',$dt['e1'],'',' '.$disabled1,'--- Pilih Sub Unit ---','000',FALSE,$editsubunit) ;
		}
		
		/*****************************************************************
		 *				FORM UTAMA                                       *
		 *                                                               *
		 *****************************************************************/
		 $this->form_fields = array(									 
			'bidang' => array( 'label'=>'BIDANG', 
								'labelWidth'=>150,
								'value'=>$bidang, 
								'type'=>'', 'row_params'=>"height='21'"
							),
			'skpd' => array( 'label'=>'SKPD', 
								'value'=>$unit, 
								'type'=>'', 'row_params'=>"height='21'"
							),			
            'thn_anggaran' => array( 
								'label'=>'Tahun',
								'labelWidth'=>150, 
								'value'=>"<input type='text' name='fmtahun' id='fmtahun' size='4' value='".$dt['tahun']."' readonly=''>"
									 ),
			'nm_barang' => array( 
								'label'=>'Nama Barang',
								'labelWidth'=>150, 
								'value'=>"<input type='text' name='fmIDBARANG' id='fmIDBARANG' size='15' value='$kode_brg' readonly=''>".
										 "&nbsp;<input type='text' name='fmNMBARANG' id='fmNMBARANG' size='60' value='".$brg['nm_barang']."' readonly=''>".
										 "<input type=hidden id='ref_iddkb' name='ref_iddkb' value='".$dt['ref_iddkb']."'>".
										 "&nbsp;<input type='button' value='Cari 1' onclick=\"".$this->Prefix.".caribarang1()\" title='Cari Kode Barang' >".
										 "&nbsp;<input type='button' value='Cari 2' onclick ='".$this->Prefix.".CariDKB()' title='Cari Perencanaan DKBMD' >"			 
									 ),
			'kode_account' => array( 
								'label'=>'Nama Akun',
								'labelWidth'=>100, 
								'value'=>"<input type='text' name='kode_account' value='$kode_account' size='15px' id='kode_account' readonly>
										  <input type='text' name='nama_account' value='".$dt['nm_account']."' size='60px' id='nama_account' readonly>
										  <input type=hidden id='tahun_account' name='tahun_account' value='".$dt['thn_akun']."'>
										  " 
									 ),
			'spk' => array(
							'label'=>'', 
							'value'=>'SPK/Kontrak', 
							'type'=>'merge',
							'row_params'=>" height='21'"
							),
			'spk_no' => array(
							'label'=>'&nbsp;&nbsp;Nomor', 
							'value'=>$dt['spk_no'], 
							'type'=>'text'
			),
			'spk_tgl' => array(
							'label'=>'&nbsp;&nbsp;Tanggal', 
							'value'=> createEntryTgl('spk_tgl',$dt['spk_tgl'] ), 
							'type'=>''
			),			
			'nama_perusahaan' => array(
							'label'=>'&nbsp;&nbsp;Perusahaan', 
							'value'=>$dt['nama_perusahaan'], 
							'type'=>'text',
							'param'=> "style='width:430px'"
			),
			'nama_pekerjaan' => array(
							'label'=>'&nbsp;&nbsp;Nama Pekerjaan', 
							'value'=>$dt['nama_pekerjaan'], 
							'type'=>'text',
							'param'=> "style='width:430px'"
			),
			'dpa' => array(
						'label'=>'', 
						'value'=>'SP2D/Kwitansi', 
						'type'=>'merge',
						'row_params'=>" height='21'"
						),
			'dpa_no' => array(
						'label'=>'&nbsp;&nbsp;Nomor', 
						'value'=>$dt['dpa_no'], 
						'type'=>'text'
			),
			'dpa_tgl' => array(
						'label'=>'&nbsp;&nbsp;Tanggal', 
						'value'=> createEntryTgl('dpa_tgl',$dt['dpa_tgl'] ), 
						'type'=>''
			),
			'jml_barang' => array(  
						'label'=>'Jumlah Pengadaan Barang', 
						'value'=>"<input name=\"jml_barang\" id='jml_barang' type=\"text\" value='".$dt['jml_barang']."' onkeypress='return isNumberKey(event)'".
						//onblur='dpb.hitungSisa()
						"' />".
					" Satuan ".
					"<input name=\"satuan\" id='satuan' type=\"text\" value='".$dt['satuan']."' />", 
					'type'=>'' 
			),		
			'harga' => array( 
					'label'=>'Harga Satuan', 
					'value'=>inputFormatRibuan("harga", '',$dt['harga']) ,
				'type'=>'' 
			),
			'jml_harga' => array( 
					'label'=>'Jumlah Harga', 
					'value'=> $vjmlharga ,
					'type'=>'' 
			),			
			'merk' => array(  
						'label'=>'Merk/Type/Ukuran/Spesifikasi', 
						'value'=> "<textarea name=\"fmMEREK\" id=\"fmMEREK\" cols=\"60\" style='margin: 2px;width: 438px; height: 51px;'>".$dt['merk_barang']."</textarea>", 
						//'params'=>"valign='top'",
						'type'=>'' , 
						'row_params'=>"valign='top'"
			),
			'unit' => array( 
					'label'=>'Dipergunakan Unit', 
					'value'=> '<div id=Unit_formdiv>'.$pilihUnit.'</div>' ,
					'type'=>'' 
			),
			'subunit' => array( 
					'label'=>'Dipergunakan Sub Unit', 
					'value'=> '<div id=SubUnit_formdiv>'.$pilihSubUnit.'</div>',
					'type'=>'' 
			),
			'ket' => array( 'label'=>'Keterangan', 
				'value'=>"<textarea name=\"fmKET\" cols=\"60\" style='margin: 2px;width: 438px; height: 51px;' >".$dt['ket']."</textarea>", 
				'type'=>'', 'row_params'=>"valign='top'"
			),
		);
		
				
		//tombol
		$this->form_menubawah = 
			"<input type=hidden id='c' name='c' value='".$dt['c']."'> ".
			"<input type=hidden id='d' name='d' value='".$dt['d']."'> ".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan2()' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >"
			;
		
		//$this->genForm_nodialog();
		$form = $this->genForm();		
				
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function simpan2(){
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
		$id = $_REQUEST[$this->Prefix.'_idplh'];
		$UID = $HTTP_COOKIE_VARS['coID'];
		
		$a1 = $Main->DEF_KEPEMILIKAN;
		$a = $Main->DEF_PROPINSI;
		$b = $Main->DEF_WILAYAH;
		
		$c = $_REQUEST['c'];
		$d = $_REQUEST['d'];
		$e = $_REQUEST['fmSKPDUnit_form'];
		$e1 = $_REQUEST['fmSKPDSubUnit_form'];
		$tahun = $_REQUEST['fmtahun'];
		
		
		$fmIDBARANG = explode('.',$_REQUEST['fmIDBARANG']);
		$f = $fmIDBARANG[0];
		$g = $fmIDBARANG[1];
		$h = $fmIDBARANG[2];
		$i = $fmIDBARANG[3];
		$j = $fmIDBARANG[4];
		$fmNMBARANG = $_REQUEST['fmNMBARANG'];
		$ref_iddkb = $_REQUEST['ref_iddkb'];
		
		$fmIDREKENING = explode('.',$_REQUEST['kode_account']);
		$k = $fmIDREKENING[0];
		$l = $fmIDREKENING[1];
		$m = $fmIDREKENING[2];
		$n = $fmIDREKENING[3];
		$o = $fmIDREKENING[4];
		$kf = $fmIDREKENING[5];
		$nama_account = $_REQUEST['nama_account'];
		$thn_akun = $_REQUEST['tahun_account'];
		
		$spk_no 	= $_REQUEST['spk_no'];
		$spk_tgl 	= $_REQUEST['spk_tgl'];
		$nama_pekerjaan = $_REQUEST['nama_pekerjaan'];
		$nama_perusahaan = $_REQUEST['nama_perusahaan'];

		$dpa_no 	= $_REQUEST['dpa_no'];
		$dpa_tgl 	= $_REQUEST['dpa_tgl'];

		$jml_barang = $_REQUEST['jml_barang'];
		$satuan = $_REQUEST['satuan'];
		$harga = $_REQUEST['harga'];		
		$jml_harga  = $harga * $jml_barang;
		//$jml_harga = str_replace('.','',$_REQUEST['jml_harga']);
		$merk_barang = $_REQUEST['fmMEREK'];
		$ket = $_REQUEST['fmKET'];

		$old = mysql_fetch_array( mysql_query(
			"select * from $this->TblName where id='$id' "		
		));
		
		
		//-- validasi
		if($err=='' && $fmIDBARANG == '')$err = "Barang belum dipilih!";
		if($err=='' && $fmIDREKENING == '')$err = "Kode akun belum dipilih!";
		if($err=='' && ($jml_barang == '' || $jml_barang==0))$err = "Jumlah pengadaan barang belum diisi!";
		if($err=='' && ($harga == ''|| $harga==0))$err = "Harga satuan belum diisi!";
		if($err=='' && $satuan == '')$err = "Satuan belum diisi!";
		if($err=='' && $spk_no == '')$err = "Nomor SPK belum diisi!";
		if($err=='' && $spk_tgl == '')$err = "Tanggal SPK belum diisi!";
		if($err=='' && ($e == '' || $e == '00' ) )$err = "Dipergunakan Unit belum dipilih!";
		if($err=='' && ($e1 == '' || $e1 == '000' ) )$err = "Dipergunakan Sub Unit belum dipilih!";		
		
		if($ref_iddkb == '' || $ref_iddkb == '0'){
			
		}else{
			$get = mysql_fetch_array( mysql_query("select * from dkb where id='$ref_iddkb'"));			
			$thn_akun = $get['thn_akun'];
		}
		
		if($err==''){
			if($fmST == 0){//baru
				
				$aqry = 
					"insert into $this->TblName_Edit ".
					"( a1,a,b,c,d,e,e1,".
					" f,g,h,i,j,ref_iddkb,".
					" k,l,m,n,o,kf,thn_akun,".
					" tahun,".
					" spk_no,spk_tgl,nama_perusahaan,nama_pekerjaan,".
					" dpa_tgl,dpa_no,".
					" jml_barang,satuan,harga,jml_harga,merk_barang, ket,".
					" uid,tgl_update) ".
					"values ".
					"( '$a1','$a','$b','$c','$d','$e','$e1',".
					" '$f','$g','$h','$i','$j','$ref_iddkb',".
					" '$k','$l','$m','$n','$o','$kf','$thn_akun',".
					" '$tahun',".
					" '$spk_no','$spk_tgl','$nama_perusahaan','$nama_pekerjaan',".
					" '$dpa_tgl','$dpa_no',".
					" '$jml_barang','$satuan','$harga','$jml_harga','$merk_barang', '$ket',".
					" '$UID',now())";
				
			}else{
				
				//
				//$get = $this->getJmlBrgBI_($old['c'],$old['d'],$old['e'],$old['f'],$old['g'],$old['h'],$old['i'],$old['j'],$old['tahun']);
		
				$aqry = 
					"update $this->TblName_Edit  ".
					"set ".
					" a1='$a1',a='$a',b='$b',c='$c',d='$d',e='$e',e1='$e1',".
					" f='$f',g='$g',h='$h',i='$i',j='$j',ref_iddkb='$ref_iddkb',".
					" k='$k',l='$l',m='$m',n='$n',o='$o',kf='$kf',thn_akun='$thn_akun',".
					" tahun='$tahun',".
					" spk_no='$spk_no',spk_tgl='$spk_tgl',nama_perusahaan='$nama_perusahaan',nama_pekerjaan='$nama_pekerjaan',".
					" dpa_tgl='$dpa_tgl',dpa_no='$dpa_no',".
					" jml_barang='$jml_barang',satuan='$satuan',harga='$harga',jml_harga='$jml_harga',merk_barang='$merk_barang', ket='$ket',". 
					" uid='$UID', tgl_update= now() ".
					"where id='".$old['id']."' ";
				
			}
			$cek .= $aqry;
			$qry = mysql_query($aqry);
			if($qry == FALSE) $err='Gagal SQL'.mysql_error();
		}		
		//$err=$cek;
		return	array ('cek'=>htmlspecialchars($cek) , 'err'=>$err, 'content'=>$content);					
	}	
	
	/*function Hapus_Validasi($id){
		$err ='';
		//$KeyValue = explode(' ',$id);
		$get = mysql_fetch_array(mysql_query(
			"select count(*) as cnt from penerimaan where id_pengadaan ='$id' "
		));
		if($err=='' && $get['cnt']>0 ) $err = 'Data Tidak Bisa Dihapus, Sudah ada di Penerimaan!';
		
		return $err;
	}*/
	
	
	function getStat(){
		$cek=''; $err=''; $content='';
		//global $Main;
		$cbid = $_POST[$this->Prefix.'_cb'];
		$id = $cbid[0];		
		$aqry = "select * from $this->TblName where id='$id' ";
		$isi = mysql_fetch_array(mysql_query($aqry));
		$content->stat = $isi['stat'];
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);					
	}	
	
	
	function getPengadaanSebelumnya($tahun, $c, $d, $e ,$e1 , $f, $g, $h, $i, $j, $id=''){
		$idstr = $id==''? '' : " and id<>'$id' ";
		$aqry = "select sum(jml_barang) as tot from pengadaan where ".
				"tahun='$tahun'".
				" and c='$c' and d='$d' and e='$e'  and e1='$e1'  ".
				" and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' $idstr "; $cek.=$aqry;
		$get = mysql_fetch_array( mysql_query(
			$aqry
		));	
		if($get['tot']==NULL) $get['tot'] = 0;
		return $get['tot'];
	}
	function hitPengadaanSebelumnya(){
		$cek=''; $err=''; $content='';
		$tahun = $_REQUEST['tahun'];
		$c = $_REQUEST['c'];		
		$d = $_REQUEST['d'];		
		$e = $_REQUEST['e'];	
		$e1 = $_REQUEST['e1'];	
		$fmIDBARANG = $_REQUEST['kdbrg'];		
		$f = $fmIDBARANG['0'].$fmIDBARANG['1'];
		$g = $fmIDBARANG['3'].$fmIDBARANG['4'];
		$h = $fmIDBARANG['6'].$fmIDBARANG['7'];
		$i = $fmIDBARANG['9'].$fmIDBARANG['10'];
		$j = $fmIDBARANG['12'].$fmIDBARANG['13'].$fmIDBARANG['14'];	
		$id = $_REQUEST['id'];
		
		
		$content->jmlada = $this->getPengadaanSebelumnya( $tahun , $c, $d, $e ,$e1 , $f, $g, $h, $i, $j, $id);		
		$content->jmldkb = $this->getJmlDKB($tahun , $c, $d, $e ,$e1 , $f, $g, $h, $i, $j); 
		if($content->jmlada == NULL) $content->jmlada=0;
		if($content->jmldkb == NULL) $content->jmldkb =0;
		
		$content->jml = $content->jmldkb - $content->jmlada;
		$content->jmlsisa = 0;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);					
	}
	
	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){
			case 'formBaru2':{				
				//echo 'tes';
				$get=$this->setFormBaru();				
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];			
				break;
			}
			case 'formEdit2':{								
				$get=$this->setFormEdit();				
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];				
				break;
			}
			case 'simpan2' : {
				$get = $this->simpan2();
				$cek = $get['cek']; 
				$err = $get['err']; 
				$content=$get['content']; 
				break;
			}
			case 'getJmlBrgBI':{
				$get = $this->getJmlBrgBI();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 
				break;
			}
			case 'formDKB':{
				$get = $this->setFormDKB();
				$json = FALSE;
				break;
			}
			case 'simpanDKB' : {
				$get = $this->simpanDKB();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 
				break;
			}
			case 'getsat': {
				$get = $this->getStat();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 
				break;
			}	
			case 'hitPengadaanSebelumnya':{
				$get = $this->hitPengadaanSebelumnya();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 				
				break;
			}
			case 'UrusanAfter':{
				$content->fmSKPDBidang= $this->cmbQueryBidang('fmSKPDBidang',$fmSKPDBidang,'','','--- Pilih Bidang ---','00');
				$content->fmSKPDskpd= $this->cmbQuerySKPD('fmSKPDskpd',$fmSKPDskpd,'','','--- Pilih Skpd ---','00');
				$fmSKPDUrusan = cekPOST('fmSKPDUrusan');
				setcookie('cofmURUSAN',$fmSKPDUrusan);
				setcookie('cofmSKPD','00');
				setcookie('cofmUNIT','00');
				setcookie('cofmSUBUNIT','00');
				setcookie('cofmSEKSI','000');
			break;
		    }
			case 'BidangAfter':{
				$content= $this->cmbQuerySKPD('fmSKPDskpd',$fmSKPDskpd,'','','--- Pilih Skpd ---','00');
				$fmSKPDBidang = cekPOST('fmSKPDBidang');
				setcookie('cofmURUSAN',$fmSKPDUrusan);
				setcookie('cofmSKPD',$fmSKPDBidang);
				setcookie('cofmUNIT','00');
				setcookie('cofmSUBUNIT','00');
				setcookie('cofmSEKSI','000');
			break;
		    }
			case 'SKPDAfter':{
				$fmSKPDBidang = cekPOST('fmSKPDBidang');
				$fmSKPDskpd = cekPOST('fmSKPDskpd');
				setcookie('cofmSKPD',$fmSKPDBidang);
				setcookie('cofmUNIT',$fmSKPDskpd);
				setcookie('cofmSUBUNIT','00');
				setcookie('cofmSUBUNIT','000');
			break;
		    }
			case 'UnitRefresh':{
				$fmc = cekPOST('c');
				$fmd = cekPOST('d');
				$fme = cekPOST('fmSKPDUnit_form');
				$ref_iddkb = cekPOST('ref_iddkb');
				
				$editunit= $fmc != '' ? $fmc.".".$fmd:'';
				if($ref_iddkb != ''){
					$content=$this->cmbQueryUnit('fmSKPDUnit_form',$fme,'','','--- Pilih Unit ---','00',TRUE,$editunit);	
				}else{
					$content=$this->cmbQueryUnit('fmSKPDUnit_form',$fme,'','','--- Pilih Unit ---','00',FALSE,$editunit);
				}
				
			break;
		    }
			case 'UnitAfter':{
			//$fmSKPDUnit = cekPOST('fmSKPDUnit_form');
			//setcookie('cofmSUBUNIT',$fmSKPDUnit);
			$ref_iddkb = cekPOST('ref_iddkb');
			$fme1 = cekPOST('fmSKPDSubUnit_form');
			if($ref_iddkb != ''){
					$content= $this->cmbQuerySubUnit('fmSKPDSubUnit_form',$fme1,'','','--- Pilih Sub Unit ---','000',TRUE);	
				}else{
					$content= $this->cmbQuerySubUnit('fmSKPDSubUnit_form',$fme1,'','','--- Pilih Sub Unit ---','000',FALSE);
				}
			
			break;
		    }	
			/*case 'hitungSisa': {
				$get = $this->hitungSisa();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 
				break;
			}*/			
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		$fmURUSAN = cekPOST('fmSKPDUrusan');
		$fmSKPD = cekPOST('fmSKPDBidang'); //echo 'fmskpd='.$fmSKPD;
		$fmUNIT = cekPOST('fmSKPDskpd');
		$fmSUBUNIT = '00';
		$fmSEKSI = '000';
		$vskpd = $Main->URUSAN ==1 ? PrintSKPD2_urusan($fmURUSAN,$fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI) : PrintSKPD2($fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI);
		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>	
			<table width=\"100%\" border=\"0\">
				<tr>
					<td class=\"subjudulcetak\">".$vskpd."</td>
				</tr>
			</table><br>";
	}
	
	function genToolbarBawah(){
		
		global $ridModul09, $disModul09, $SPg, $Pg,$Main,$jns, $HTTP_COOKIE_VARS;
		$PnlPenghapusan = $Main->MODUL_PENGAPUSAN ?"<table width=\"70\"><tr><td>" . 
						PanelIcon3("javascript:penghapusan_ins.penghapusanbaru(3)", "PENGHAPUSAN", $ridModul09, $disModul09,'',2,90) . 
					"</td></tr></table>":"";
		$ToolBarBawah="<table width=\"100%\" class=\"menudottedline\" ><tr>
					<td>".$PnlPenghapusan."
					</td>
					<td width=\"80%\"></td></tr>
					</table>";

		//tampil link daftar pilihan
		return	$ToolBarBawah;
		
	}
}
$pemusnahan = new pemusnahanObj();

?>