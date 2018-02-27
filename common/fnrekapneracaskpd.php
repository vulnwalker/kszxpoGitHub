<?php
//kertas kerja
class RekapNeracaSKPDObj extends DaftarObj2{
	var $Prefix = 'RekapNeracaSKPD'; //jsname
	var $SHOW_CEK = FALSE;
	var $withform = TRUE;
	//daftar -------------------
	//var $elCurrPage="HalDefault";
	var $TblName = 'ref_barang'; //daftar
	var $TblName_Hapus = '';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('f'); //daftar/hapus
	var $FieldSum = array();
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 5,5,5);//berdasar mode
	var $FieldSum_Cp2 = array( 0, 0,0);	
	var $checkbox_rowspan = 1;
	var $totalCol = 18; //total kolom daftar
	var $fieldSum_lokasi = array( 10);  //lokasi sumary di kolom ke	
	var $withSumAll = TRUE;
	var $withSumHal = TRUE;
	var $WITH_HAL = FALSE;
	var $totalhalstr = '';
	var $totalAllStr = '';
	//var $KeyFields_Hapus = array('Id');
	//cetak --------------------
	var $cetak_xls=FALSE ;
	var $fileNameExcel='RekapNeracaSKPD.xls';
	var $Cetak_Judul = 'Rekap Neraca SKPD';
	//var $Cetak_Header;
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead ='<style>
	.nfmt1 {
	mso-number-format:"\#\,\#\#0_\)\;\[Red\]\\\(\#\,\#\#0\\\)";
	
}
.nfmt2 {
	mso-number-format:"0\.00_ ";
	
}
.nfmt3 {
	mso-number-format:"0000";
	
}		
.nfmt4 {
	mso-number-format:"\#\,\#\#0.00_\)\;\[Red\]\\\(\#\,\#\#0\\\)";
}
.nfmt5 {
	mso-number-format:"00";
	
}</style>';//="<link type='text/css' href='css/template_css.css' rel='stylesheet'>";
	//page ----------------------
	//var $Prefix='page'; //js object pake ini
	var $ToolbarAtas_edit ='';
	var $PageTitle ='Pelaporan';// 'Rekap Neraca';
	var $PageIcon = 'images/pelaporan_ico.png';
	var $pagePerHal= '9999';
	var $FormName = 'adminForm';	
	var $ico_width = 20;
	var $ico_height = 30;
	
	var $jml_data=0;
	var $totBrgAset = 0;
	var $totHrgAset = 0;
	
	/*
	$TampilJmlTotSaldoAwSKPD=number_format($JmlSaldoAwSKPD, 2, ',', '.');
		$TampilJmlTotBelanjaSKPD=number_format($JmlBelanjaSKPD, 2, ',', '.');
		$TampilJmlTotAtribusiSKPD=number_format($JmlAtribusiSKPD, 2, ',', '.');
		$TampilJmlTotKapitalisasiDSKPD=number_format($JmlKapitalisasiDSKPD, 2, ',', '.');
		$TampilJmlTotKapitalisasiKSKPD=number_format($JmlKapitalisasiKSKPD, 2, ',', '.');
		$TampilJmlTotHibahDSKPD=number_format($JmlHibahDSKPD, 2, ',', '.');
		$TampilJmlTotHibahKSKPD=number_format($JmlHibahKSKPD, 2, ',', '.');
		$TampilJmlTotMutasiDSKPD=number_format($JmlMutasiDSKPD, 2, ',', '.');
		$TampilJmlTotMutasiKSKPD=number_format($JmlMutasiKSKPD, 2, ',', '.');
		$TampilJmlTotPenilaianDSKPD=number_format($JmlPenilaianDSKPD, 2, ',', '.');
		$TampilJmlTotPenghapusanKSKPD=number_format($JmlPenghapusanKSKPD, 2, ',', '.');
		$TampilJmlTotPembukuanDSKPD=number_format($JmlPembukuanDSKPD, 2, ',', '.');
		$TampilJmlTotPembukuanKSKPD=number_format($JmlPembukuanKSKPD, 2, ',', '.');
		$TampilJmlTotReklassDSKPD=number_format($JmlReklassDSKPD, 2, ',', '.');
		$TampilJmlTotReklassKSKPD=number_format($JmlReklassKSKPD, 2, ',', '.');
		$TampilJmlTotSaldoAkSKPD=number_format($JmlSaldoAkSKPD, 2, ',', '.');	
	*/
	
	var $JmlSaldoAwSKPD = 0;
	var $JmlBelanjaSKPD = 0;
	var $JmlAtribusiSKPD = 0;
	var $JmlKapitalisasiDSKPD = 0;
	var $JmlKapitalisasiKSKPD = 0;
	var $JmlHibahDSKPD = 0;
	var $JmlHibahKSKPD = 0;
	var $JmlMutasiDSKPD = 0;
	var $JmlMutasiKSKPD = 0;
	var $JmlPenilaianDSKPD = 0;
	var $JmlPenghapusanKSKPD = 0;
	var $JmlPembukuanDSKPD = 0;
	var $JmlPembukuanKSKPD = 0;
	var $JmlReklassDSKPD = 0;
	var $JmlReklassKSKPD = 0;
	var $JmlSaldoAkSKPD  = 0;
	
	/**
	function set_selector_other($tipe){
		$cek = ''; $err=''; $content=''; $json=FALSE;
		switch($tipe){	
			case 'total':{
				$get = $this->changeTahun();
				$err = $get['err'];
				$cek = $get['cek'];
				$content = $get['content'];				
				$json=TRUE;
				break;
			}				
			default:{
				$err = 'tipe tidak ada!';
				break;
			}
		}	
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	**/
	
	function genDaftarInitial(){
		global $Main;
		$vOpsi = $this->genDaftarOpsi();
		
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
		$vcekbi =  $Main->SETTING['CEK_BI_REKAP']==1? "<div id='cont_cekbi' style='position:relative'></div>" : '';
		return		
			//$NavAtas.	
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			$vcekbi.
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 
				//$vOpsi['TampilOpt'].
			"</div>".
			
			//"<div id='cont_cek' style='position:relative'></div>". 
				
			//"<div style='position:relative'>".
			$vdaftar.
			//"</div>".
			'';
	}

	function genRowSum(){
		//hal

		$ContentTotalHal=''; $ContentTotal='';
		return $ContentTotalHal.$ContentTotal;
	}
	
	function genDaftar($Kondisi='', $Order='', $Limit='', $noAwal = 0, $Mode=1, $vKondisi_old=''){
		//$Mode -> 1. daftar, 2. cetak hal, 3.cetak all
		$cek =''; $err='';
					
		$MaxFlush=$this->MaxFlush;		
		$headerTable = $this->genDaftarHeader($Mode);		
		$TblStyle =	$this->TblStyle[$Mode-1];//$Mode ==1 ? 'koptable': 'cetak';
		$ListData = 
			"<table class='$TblStyle' border='1'   style='margin:4 0 0 0;width:100%'>".
			$headerTable.
			"<tbody>";
				
		$ColStyle = $this->ColStyle[$Mode-1];//$Mode==1? 'GarisDaftar':'GariCetak';			
		$no=$noAwal; $cb=0; $jmlDataPage =0;
		$TotalHalRp = 0;
		
		//$aqry = "select * from $this->TblName $Kondisi $Order $Limit ";	//echo $aqry;
		//$qry = mysql_query($aqry);
		$aqry = $this->setDaftar_query($Kondisi, $Order, $Limit); $cek .= $aqry.'<br>';
		/*
		$qry = mysql_query($aqry);
		$numrows = mysql_num_rows($qry); $cek.= " jmlrow = $numrows ";
		if( $numrows> 0 ) {
					
		while ( $isi=mysql_fetch_array($qry)){
			if ( $isi[$this->KeyFields[0]] != '' ){
				
			
			$no++;
			$jmlDataPage++;
			if($Mode == 1) $RowAtr = $no % 2 == 1? "class='row0'" : "class='row1'";
			
			$KeyValue = array();
			for ($i=0; $i< sizeof($this->KeyFields) ; $i++) {
				$KeyValue[$i] = $isi[$this->KeyFields[$i]];
			}
			$KeyValueStr = join(' ',$KeyValue);
			$TampilCheckBox =  $this->setCekBox($cb, $KeyValueStr, $isi);//$Cetak? '' : 
				
			
			
			//sum halaman
			for ($i=0; $i< sizeof($this->FieldSum) ; $i++) {
				$this->SumValue[$i] += $isi[$this->FieldSum[$i]];
			}
			
			//---------------------------
			$rowatr_ = $RowAtr." valign='top' id='$cb' value='".$isi['Id']."'";
			$bef= $this->setDaftar_before_getrow(
					$no,$isi,$Mode, $TampilCheckBox,  
					$rowatr_,
					$ColStyle
					);
			$ListData .= $bef['ListData'];
			$no = $bef['no'];
			//get row
			$Koloms = $this->setKolomData($no,$isi,$Mode, $TampilCheckBox);	$cek .= $Koloms;		
			$list_row = genTableRow($Koloms, 
						$rowatr_,
						$ColStyle);		
			
			
			$ListData .= $this->setDaftar_after_getrow($list_row, $isi , $no, $Mode, $TampilCheckBox,
				$RowAtr, $ColStyle);
			
			$cb++;
			
			if( ($Mode == 3 ) && ($cb % $MaxFlush==0) && $cb >0 ){				
				echo $ListData;
				ob_flush();
				flush();
				$ListData='';
				//sleep(2); //tes
			}
			}
		}
		
		}
		*/
		$ListData .= $this->setDaftar_After($no, $ColStyle);
		//total -----------------------		
		if ($Mode==3) {	//flush
			echo $ListData;
			ob_flush();
			flush();
			$ListData='';			
			$SumHal = $this->genSumHal($Kondisi); 			
		}
		//$SumHal = $this->genSumHal($Kondisi);
		$ContentSum = $this->genRowSum($ColStyle,  $Mode, 
			$SumHal['sums']
		);
		/*$TampilTotalHalRp = number_format($TotalHalRp,2, ',', '.');		
		$TotalColSpan = $this->FieldSum_Cp1[$Mode-1];//$Mode ==1 ? 5 : 4;
		$ContentTotalHal =
			"<tr>
				<td class='$ColStyle' colspan='$TotalColSpan' align='center'><b>Total per Halaman</td>
				<td class='$ColStyle' align='right'><b>$TampilTotalHalRp</td>
				<td class='$ColStyle' colspan='4'></td>
			</tr>" ;
			
		$ContentTotal = 
				"<tr>
					<td class='$ColStyle' colspan='$TotalColSpan' align='center'><b>Total</td>
					<td class='$ColStyle' align='right'><b><div  id='cntDaftarTotal'>".$SumHal['sum']."</div></td>
					<td class='$ColStyle' colspan='4'></td>
				</tr>" ;
		
		if($Mode == 2){			
			$ContentTotal = '';
		}else if($Mode == 3){
			$ContentTotalHal='';			
		}
		$ContentSum=$ContentTotalHal.$ContentTotal;
		*/
		
		$ListData .= 
				//$ContentTotalHal.$ContentTotal.
				
				$ContentSum.
				"</tbody>".
			"</table>				
			<input type='hidden' id='".$this->Prefix."_jmldatapage' name='".$this->Prefix."_jmldatapage' value='$jmlDataPage'>
			<input type='hidden' id='".$this->Prefix."_jmlcek' name='".$this->Prefix."_jmlcek' value=''>"
			.$vKondisi_old
			;
		if ($Mode==3) {	//flush
			echo $ListData;	
		}
					
		return array('cek'=>$cek,'content'=>$ListData, 'err'=>$err);
	}

	function genSumHal(){

		//return array('sum'=>0, 'hal'=>0, 'sums'=>0, 'jmldata'=>0, 'cek'=>'' );
		return array('sum'=>'', 'hal'=>'', 'sums'=>0, 'jmldata'=>'', 'cek'=>'' );
	}

	function setTitle(){
		//return 'Rekapitulasi Hasil Sensus Tahun '. getTahunSensus() ;
		 /*if($Main->VERSI_NAME == 'KOTA_BANDUNG' ){
		 	$title = "Kertas Kerja";
		 }else{
		 	$title = "Rekap Neraca ";
		 }*/
		return 'Rekap Neraca SKPD';
	}
	function setCetakTitle(){
		//return	"<DIV ALIGN=CENTER>$this->Cetak_Judul Tahun ". getTahunSensus();
		$judul=" <DIV ALIGN=CENTER>Rekap Neraca";
		if ($this->cetak_xls==TRUE)
		{
			$judul="<table width='100%'><tr><td colspan=6>Rekap Neraca x</td></tr></table>";
		}
		return $judul;
	}
	
	function setMenuEdit(){		
		return '';
	}
	
	
	function setMenuView(){		
		return 			
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png",'Halaman',"Cetak Daftar per Halaman")."</td>".			
			"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakAll(\"$Op\")","print_f2.png",'Cetak',"Cetak Daftar")."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".exportXls(\"$Op\")","export_xls.png",'Excel',"Export Excel")."</td>".						
			"";
		
	}
	
	function setPage_HeaderOther(){
		global $Main;	
		
		$menu_penyusutan = $Main->PENYUSUTAN ? " <A href=\"index.php?Pg=05&jns=penyusutan\" $styleMenuPenyusutan title='Penyusutan'>PENYUSUTAN</a> |   ":'';
		$menu_kibg1 = $Main->MODUL_ASET_LAINNYA?
			"<A href=\"index.php?Pg=05&SPg=kibg&jns=atb\" $styleMenu3_9 title='Aset Tak Berwujud'>ASET TAK BERWUJUD</a> |":'';
		
		//style = terpilih
		$Pg= $_REQUEST['Pg'];

		//if($Pg == 'sensus'){
		//	$styleMenu = " style='color:blue;' ";	
		//}
		$menu = $_REQUEST['menu'];
				
		
		if($Main->VERSI_NAME=='JABAR'){
			$styleMenu = " style='color:blue;' ";	
			$styleMenu2_4 = " style='color:blue;' ";
			$menu_rekapneraca_2 = $Main->REKAP_NERACA_2 ?
				" | <A href=\"pages.php?Pg=Rekap2\" title='Rekap Neraca' $styleMenu >REKAP NERACA</a>": '';
		
			$menu_pembukuan1 =
				($Main->MODUL_AKUNTANSI )?
				"<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
				<A href=\"index.php?Pg=05&SPg=03&jns=intra\"  title='Intrakomptabel'>INTRAKOMPTABEL</a> |
				<A href=\"index.php?Pg=05&SPg=03&jns=ekstra\"  title='Ekstrakomptabel'>EKTRAKOMPTABEL</a> |
				<A href=\"index.php?Pg=05&SPg=04&jns=tetap\"  title='Aset Tetap Tanah'>Tanah</a>  |  
				<A href=\"index.php?Pg=05&SPg=05&jns=tetap\"  title='Aset Tetap Peralatan & Mesin'>P & M</a>  |  
				<A href=\"index.php?Pg=05&SPg=06&jns=tetap\"  title='Aset Tetap Gedung & Bangunan'>G & B</a>  |  
				<A href=\"index.php?Pg=05&SPg=07&jns=tetap\"  title='Aset Tetap Jalan, Irigasi & Jaringan'>JIJ</a>  |  
				<A href=\"index.php?Pg=05&SPg=08&jns=tetap\"  title='Aset Tetap Lainnya'>ATL</a>  |  
				<A href=\"index.php?Pg=05&SPg=09&jns=tetap\"  title='Aset Tetap Konstruksi Dalam Pengerjaan'>KDP</a> |    
				<A href=\"index.php?Pg=05&SPg=09&jns=tetap\"  title='Pemindahtanganan'>PEMINDAHTANGANAN</a> |    
				<A href=\"index.php?Pg=05&SPg=09&jns=tetap\"  title='Tuntutan Ganti Rugi'>TGR</a> |    
				<A href=\"index.php?Pg=05&SPg=09&jns=tetap\"  title='Kemitraan Dengan Pihak Ke Tiga'>KEMITRAAN</a> |    
				$menu_kibg1
				<A href=\"index.php?Pg=05&SPg=03&jns=lain\"  title='Aset Lain-lain'>ASET LAIN LAIN</a> |  
				$menu_penyusutan
				<!-- <A href=\"pages.php?Pg=Pembukuan\" title='Rekap Neraca' >REKAP NERACA</a> |
				 <A href=\"index.php?Pg=05&jns=tetap\" title='Rincian Neraca' >RINCIAN NERACA</a> 
				| -->
				<A href=\"pages.php?Pg=Rekap1\" title='Rekap Aset' >REKAP ASET</a>   
				$menu_rekapneraca_2
				| <A href=\"pages.php?Pg=Rekap3\" title='Rekap Mutasi'  >REKAP MUTASI II</a>
				| <A href=\"pages.php?Pg=Jurnal\" title='Jurnal' >JURNAL</a>
				  &nbsp&nbsp&nbsp
				</td></tr>":'';	
		
		
			$menubar = 			//"<tr height='22' valign='top'><td >".
				"<!--menubar_page-->
			
				<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
				<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
			
				<A href=\"index.php?Pg=05&SPg=03\" title='Buku Inventaris'>BI</a> |
				<A href=\"index.php?Pg=05&SPg=04\" title='Tanah'>KIB A</a>  |  
				<A href=\"index.php?Pg=05&SPg=05\" title='Peralatan & Mesin'>KIB B</a>  |  
				<A href=\"index.php?Pg=05&SPg=06\" title='Gedung & Bangunan'>KIB C</a>  |  
				<A href=\"index.php?Pg=05&SPg=07\" title='Jalan, Irigasi & Jaringan'>KIB D</a>  |  
				<A href=\"index.php?Pg=05&SPg=08\" title='Aset Tetap Lainnya'>KIB E</a>  |  
				<A href=\"index.php?Pg=05&SPg=09\" title='Konstruksi Dalam Pengerjaan'>KIB F</a>  |  
				<A href=\"index.php?Pg=05&SPg=11\" title='Rekap BI'>REKAP BI</a> |";
			if($Main->MODUL_MUTASI) $menubar=$menubar."
				<A target='blank' href=\"pages.php?Pg=map&SPg=03\" title='Peta Sebaran' $styleMenu8>PETA</a> |
				<A href=\"index.php?Pg=05&SPg=12\" title='Daftar Mutasi'>MUTASI</a>  |
				<A href=\"index.php?Pg=05&SPg=13\" title='Rekap Mutasi'>REKAP MUTASI</a> |";
			//$menubar=$menubar."<A href=\"index.php?Pg=05&SPg=KIR\" title='Kartu Inventaris Ruangan'>KIR</a> |";
	
			if($Main->MODUL_SENSUS) $menubar=$menubar."	<A href=\"index.php?Pg=05&SPg=belumsensus\" title='Sensus' >INVENTARISASI</a> |";
			if($Main->MODUL_PEMBUKUAN) $menubar=$menubar."
				<A href=\"index.php?Pg=05&SPg=03&jns=intra\" title='Akuntansi' $styleMenu>AKUNTANSI</a>";
				
			$menubar=$menubar." | <A href=\"pages.php?Pg=penatausahakol\" title='Gambar' >GAMBAR</a> 	
				&nbsp&nbsp&nbsp
				</td></tr>$menu_pembukuan1	
						
				</table>".
				"";
			
			
			
			
		}else{
			
			$styleMenu = " style='color:blue;' ";	
			$styleMenu2_4 = " style='color:blue;' ";
			$menu_LRA = $Main->VERSI_NAME == 'SERANG' ? 
						"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
						<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
						<A href=\"pages.php?Pg=perbandingan\" title='Perbandingan LRA - Belanja Modal' >PERBANDNGAN LRA</a> 
						&nbsp&nbsp&nbsp</td></tr>
						</table>" : "";
			//$txtRakapbi = $Main->VERSI_NAME == 'KOTA_BANDUNG' ? "REKAP NERACA" : "REKAP BI";
			//$txtRekapneraca = $Main->VERSI_NAME == 'KOTA_BANDUNG' ? "KERTAS KERJA" : "REKAP NERACA";
			$menu_penyusutan = $Main->PENYUSUTAN ? " <A href=\"index.php?Pg=05&jns=penyusutan\" $styleMenuPenyusutan title='Penyusutan'>PENYUSUTAN</a> |   ":'';
			$menu_rekapneraca_2 = $Main->REKAP_NERACA_2 ? " | <A href=\"pages.php?Pg=Rekap2\" title='Rekap Neraca' $styleMenu >KERTAS KERJA</a>": '';
			$menu_kibg1 = $Main->MODUL_ASET_LAINNYA?
				"<A href=\"index.php?Pg=05&SPg=kibg&jns=atb\" $styleMenu3_9 title='Aset Tak Berwujud'>ASET TAK BERWUJUD</a> |":'';
			
			
			$menu_pembukuan1 = ($Main->MODUL_AKUNTANSI )?
				"<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		
				<A href=\"index.php?Pg=05&SPg=03&jns=intra\"  title='Intrakomptabel'>INTRAKOMPTABEL</a> |
				<A href=\"index.php?Pg=05&SPg=03&jns=ekstra\"  title='Ekstrakomptabel'>EKSTRAKOMPTABEL</a> |
				<A href=\"index.php?Pg=05&SPg=04&jns=tetap\"  title='Aset Tetap Tanah'>Tanah</a>  |  
				<A href=\"index.php?Pg=05&SPg=05&jns=tetap\"  title='Aset Tetap Peralatan & Mesin'>P & M</a>  |  
				<A href=\"index.php?Pg=05&SPg=06&jns=tetap\"  title='Aset Tetap Gedung & Bangunan'>G & B</a>  |  
				<A href=\"index.php?Pg=05&SPg=07&jns=tetap\"  title='Aset Tetap Jalan, Irigasi & Jaringan'>JIJ</a>  |  
				<A href=\"index.php?Pg=05&SPg=08&jns=tetap\"  title='Aset Tetap Lainnya'>ATL</a>  |  
				<A href=\"index.php?Pg=05&SPg=09&jns=tetap\"  title='Aset Tetap Konstruksi Dalam Pengerjaan'>KDP</a> |   
				<A href=\"index.php?Pg=05&SPg=09&jns=tetap\"  title='Pemindahtanganan'>PEMINDAHTANGANAN</a> |    
				<A href=\"index.php?Pg=05&SPg=09&jns=tetap\"  title='Tuntutan Ganti Rugi'>TGR</a> |    
				<A href=\"index.php?Pg=05&SPg=09&jns=tetap\"  title='Kemitraan Dengan Pihak Ke Tiga'>KEMITRAAN</a> |    
				$menu_kibg1
				<A href=\"index.php?Pg=05&SPg=03&jns=lain\"  title='Aset Lain-lain'>ASET LAIN LAIN</a> |  
				$menu_penyusutan
				<A href=\"pages.php?Pg=Rekap1\" title='Rekap BI' >REKAP NERACA</a> 
				<!--| <A href=\"pages.php?Pg=Rekap5\" title='Rekap BI'  >REKAP BI 2</a>	-->		
				$menu_rekapneraca_2
				| <A href=\"pages.php?Pg=Rekap3\" title='Rekap Mutasi'  >REKAP MUTASI</a>
				| <A href=\"pages.php?Pg=Jurnal\" title='Jurnal' >JURNAL</a> 
				  &nbsp&nbsp&nbsp
				</td></tr>":'';	
				
			if($Main->MENU_VERSI==3){
				$menubar = '';
				/**"<!--menubar_page-->
					
				<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
				<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
				<A href=\"index.php?Pg=05&SPg=03&jns=intra\"  title='Intrakomptabel'>INTRAKOMPTABEL</a> |
				<A href=\"index.php?Pg=05&SPg=03&jns=ekstra\"  title='Ekstrakomptabel'>EKSTRAKOMPTABEL</a> |
				<A href=\"index.php?Pg=05&SPg=04&jns=tetap\"  title='Aset Tetap Tanah'>ASET TETAP</a>  |    
				<A href=\"index.php?Pg=05&SPg=03&jns=pindah\"  title='Aset Lainnya'>ASET LAINNYA</a> |    
				<A href=\"index.php?Pg=09&SPg=01&SSPg=03&mutasi=1\"  title='Mutasi'>MUTASI</a>  |
				<A href=\"pages.php?Pg=Rekap3\" title='Rekap Mutasi' >REKAP MUTASI</a>
				$menu_rekapneraca_2
				| <A href=\"pages.php?Pg=Rekap1\" title='Rekap BI'>NERACA</a>
				  &nbsp&nbsp&nbsp
				</td></tr></table>
				";**/
			}else{
				$menubar = 			//"<tr height='22' valign='top'><td >".
				"<!--menubar_page-->			
				<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
				<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
			
				<A href=\"index.php?Pg=05&SPg=03\" title='Buku Inventaris'>BI</a> |
				<A href=\"index.php?Pg=05&SPg=04\" title='Tanah'>KIB A</a>  |  
				<A href=\"index.php?Pg=05&SPg=05\" title='Peralatan & Mesin'>KIB B</a>  |  
				<A href=\"index.php?Pg=05&SPg=06\" title='Gedung & Bangunan'>KIB C</a>  |  
				<A href=\"index.php?Pg=05&SPg=07\" title='Jalan, Irigasi & Jaringan'>KIB D</a>  |  
				<A href=\"index.php?Pg=05&SPg=08\" title='Aset Tetap Lainnya'>KIB E</a>  |  
				<A href=\"index.php?Pg=05&SPg=09\" title='Konstruksi Dalam Pengerjaan'>KIB F</a>  |  
							
				<A href=\"index.php?Pg=05&SPg=11\" title='Rekap BI'>REKAP BI</a> |";
				if($Main->MODUL_MUTASI) $menubar=$menubar."
				<A href=\"index.php?Pg=05&SPg=12\" title='Daftar Mutasi'>MUTASI</a>  |
				<A href=\"index.php?Pg=05&SPg=13\" title='Rekap Mutasi'>REKAP MUTASI</a> |";
			   $menubar=$menubar."<A href=\"index.php?Pg=05&SPg=KIR\" title='Kartu Inventaris Ruangan'>KIR</a> |";
	
				if($Main->MODUL_SENSUS) $menubar=$menubar."
				<A href=\"index.php?Pg=05&SPg=belumsensus\" title='Sensus' >SENSUS</a> |";
				if($Main->MODUL_PEMBUKUAN) $menubar=$menubar."
				<A href=\"index.php?Pg=05&SPg=03&jns=intra\" title='Akuntansi' $styleMenu>AKUNTANSI</a>";
				$menubar=$menubar."&nbsp&nbsp&nbsp
				</td></tr>$menu_pembukuan1			
				</table>".			
				$menu_LRA.
				""	;
			}
			
			
		}
		return "";//$menubar;
			
	}
	
	
	
	function setPage_HeaderOther_(){
	global $Main;	
		
		//style = terpilih
		$Pg= $_REQUEST['Pg'];

		//if($Pg == 'sensus'){
		//	$styleMenu = " style='color:blue;' ";	
		//}
		$menu = $_REQUEST['menu'];
		/*switch ($menu){
			case 'belumcek' : $styleMenu2_1 = " style='color:blue;' "; break;
			case 'diusulkan': $styleMenu2_3 = " style='color:blue;' "; break;
			case 'laporan' 	: $styleMenu2_4 = " style='color:blue;' "; break;
			case 'kertaskerja' 	: $styleMenu2_5 = " style='color:blue;' "; break;
			case 'ada' :$styleMenu2_2 = " style='color:blue;' "; break;	
			case 'tidakada' :$styleMenu2_5 = " style='color:blue;' "; break;	
			
			//default: $styleMenu2_2 = " style='color:blue;' "; break;	
		}*/
		//if($tipe='tipe')$styleMenu2_4 = " style='color:blue;' ";
		$styleMenu = " style='color:blue;' ";	
		$styleMenu2_4 = " style='color:blue;' ";
		$menu_penyusutan = $Main->PENYUSUTAN ? " <A href=\"index.php?Pg=05&jns=penyusutan\" $styleMenuPenyusutan title='Penyusutan'>PENYUSUTAN</a> |   ":'';
		$menu_rekapneraca_2 = $Main->REKAP_NERACA_2 ?
			" | <A href=\"pages.php?Pg=Rekap2\" title='Rekap Neraca' $styleMenu >REKAP NERACA</a>": '';
		
			$menu_pembukuan1 =
		($Main->MODUL_AKUNTANSI )?
		"<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>



	<A href=\"index.php?Pg=05&SPg=03&jns=intra\"  title='Intrakomptabel'>INTRAKOMPTABEL</a> |
	<A href=\"index.php?Pg=05&SPg=03&jns=ekstra\"  title='Ekstrakomptabel'>EKSTRAKOMPTABEL</a> |
	<A href=\"index.php?Pg=05&SPg=04&jns=tetap\"  title='Tanah'>KIB A</a>  |  
	<A href=\"index.php?Pg=05&SPg=05&jns=tetap\"  title='Peralatan & Mesin'>KIB B</a>  |  
	<A href=\"index.php?Pg=05&SPg=06&jns=tetap\"  title='Gedung & Bangunan'>KIB C</a>  |  
	<A href=\"index.php?Pg=05&SPg=07&jns=tetap\"  title='Jalan, Irigasi & Jaringan'>KIB D</a>  |  
	<A href=\"index.php?Pg=05&SPg=08&jns=tetap\"  title='Aset Tetap Lainnya'>KIB E</a>  |  
	<A href=\"index.php?Pg=05&SPg=09&jns=tetap\"  title='Konstruksi Dalam Pengerjaan'>KIB F</a> |    
	<A href=\"index.php?Pg=05&SPg=09&jns=tetap\"  title='Pemindahtanganan'>PEMINDAHTANGANAN</a> |    
	<A href=\"index.php?Pg=05&SPg=09&jns=tetap\"  title='Tuntutan Ganti Rugi'>TGR</a> |    
	<A href=\"index.php?Pg=05&SPg=09&jns=tetap\"  title='Kemitraan Dengan Pihak Ke Tiga'>KEMITRAAN</a> |    
	$menu_kibg1
	<A href=\"index.php?Pg=05&SPg=03&jns=lain\"  title='Aset Lain-lain'>ASET LAIN LAIN</a> |  
	$menu_penyusutan
	<A href=\"pages.php?Pg=Rekap1\" title='Rekap BI' >REKAP BI</a> 
	$menu_rekapneraca_2
	| <A href=\"pages.php?Pg=Rekap3\" title='Rekap Mutasi'  >REKAP MUTASI</a>
	  &nbsp&nbsp&nbsp
	</td></tr>":'';	
		
		
		$menubar = 			//"<tr height='22' valign='top'><td >".
			"<!--menubar_page-->
		
			<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
			<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
		
			<A href=\"index.php?Pg=05&SPg=03\" title='Buku Inventaris'>BI</a> |
			<A href=\"index.php?Pg=05&SPg=04\" title='Tanah'>KIB A</a>  |  
			<A href=\"index.php?Pg=05&SPg=05\" title='Peralatan & Mesin'>KIB B</a>  |  
			<A href=\"index.php?Pg=05&SPg=06\" title='Gedung & Bangunan'>KIB C</a>  |  
			<A href=\"index.php?Pg=05&SPg=07\" title='Jalan, Irigasi & Jaringan'>KIB D</a>  |  
			<A href=\"index.php?Pg=05&SPg=08\" title='Aset Tetap Lainnya'>KIB E</a>  |  
			<A href=\"index.php?Pg=05&SPg=09\" title='Konstruksi Dalam Pengerjaan'>KIB F</a>  |  
						
			<A href=\"index.php?Pg=05&SPg=11\" title='Rekap BI'>REKAP BI</a> |";
			if($Main->MODUL_MUTASI) $menubar=$menubar."
			<A href=\"index.php?Pg=05&SPg=12\" title='Daftar Mutasi'>MUTASI</a>  |
			<A href=\"index.php?Pg=05&SPg=13\" title='Rekap Mutasi'>REKAP MUTASI</a> |";
		   $menubar=$menubar."<A href=\"index.php?Pg=05&SPg=KIR\" title='Kartu Inventaris Ruangan'>KIR</a> |";

			if($Main->MODUL_SENSUS) $menubar=$menubar."
			<A href=\"index.php?Pg=05&SPg=belumsensus\" title='Sensus' >SENSUS</a> |";
			if($Main->MODUL_PEMBUKUAN) $menubar=$menubar."
			<A href=\"index.php?Pg=05&SPg=03&jns=intra\" title='Akuntansi' $styleMenu>AKUNTANSI</a>";
			$menubar=$menubar."&nbsp&nbsp&nbsp
			</td></tr>$menu_pembukuan1			
			</table>".
			
			
			""
			;
		
		return "";//$menubar;
			
	}
	
	function genDaftarOpsi(){
		global $Main,$fmFiltThnBuku;
		
		
		$fmFiltThnBuku = $_REQUEST['fmFiltThnBuku'];
		$fmFiltThnSensus = $_REQUEST['fmFiltThnSensus'];
		$fmFiltThnPerolehan = $_REQUEST['fmFiltThnPerolehan'];
		$fmKONDBRG = $_REQUEST['fmKONDBRG'];
		$jnsrekap = $_REQUEST['jnsrekap'];
		$fmSemester = $_REQUEST['fmSemester'];
		$fmLvlSkpd = $_REQUEST['fmLvlSkpd'];
		$arrLevelSKPD = array(
			array('1','Level 2'),
			array('2','Level 3'),
			array('3','Level 4')
		);
		/*
		$xls =$_REQUEST['tipe'];
		if ($xls=='exportXls')
		{
			$this->cetak_xls==TRUE;
		} else {
			$this->cetak_xls==FALSE;
		}		
		*/		
		//data order ------------------------------
		/*
		$arrOrder = array(
			array('1','Tahun Perolehan'),
			array('2','Keadaan Barang'),
			array('3','Tahun Buku')
		);
		
		*/
		//tampil -------------------------------
		/*
		$menu = $_REQUEST['menu'];
		if($menu=='ada'){
			$filtKondBrg = cmb2D_v2('fmKONDBRG',$fmKONDBRG, $Main->KondisiBarang,'','Kondisi Barang','');
		}
		*/
		//$cbxTotal = $_REQUEST['cbxTotal'];
		//$vcbxtotal = $cbxTotal ?  " checked='true' " : '';
		$Semester = "Semester ".cmb2D_v2('fmSemester',$fmSemester,$Main->ArSemester1,'','Semester I');
		$cmbLevelSKPD = "  Level SKPD ".cmb2D_v2('fmLvlSkpd',$fmLvlSkpd,$arrLevelSKPD,'','Level 1');
		if ($fmFiltThnBuku=='') $fmFiltThnBuku = date('Y');
		$TampilOpt =
			"<table width=\"100%\" class=\"adminform\">	<tr>		
			<td width=\"100%\" valign=\"top\">		
				" . WilSKPD_ajx3($this->Prefix.'Skpd') . 
			"</td>
			<td style='padding:6'>
			</td>
			</tr></table>".
			
			genFilterBar(
				array(	
					'Tampilkan : '.$Semester.
					' Tahun Buku '.
					"<input type='text' id='fmFiltThnBuku' name='fmFiltThnBuku' value='$fmFiltThnBuku' 
						size='4' maxlength='4' onkeypress='return isNumberKey(event)' >".
					"<input type='hidden' id='daftarcetak' name='daftarcetak' value='' >".
					$cmbLevelSKPD
					/*genComboBoxQry('fmFiltThnBuku',$fmFiltThnBuku,
						"select year(tgl_buku)as thnbuku from buku_induk group by thnbuku desc",
						'thnbuku', 'thnbuku','Tahun Buku')*/,
					//"<input type='checkbox' name='cbxTotal' id='cbxTotal' value='1' $vcbxtotal  >Total"
				),$this->Prefix.".refreshList(true,'$Main->VERSI_NAME')",TRUE
			)
			;
		
		return array('TampilOpt'=>$TampilOpt);
		
	
	}
	
	function genCetak($xls= FALSE, $Mode=''){
		global $Main;
		
		$daftarCetak=$_REQUEST['daftarcetak'];
		
		$this->cetak_xls = $xls;
		/*
		<style>
		.nfmt1 {mso-number-format:'\#\,\#\#0_\)\;\[Red\]\\(\#\,\#\#0\\)';}
		.nfmt2 {mso-number-format:'0\.00_';}
		.nfmt3 {mso-number-format:'00000';}
		.nfmt4 {mso-number-format:'\#\,\#\#0.00_\)\;\[Red\]\\(\#\,\#\#0\\)';}
		.nfmt5 {mso-number-format:'\@';} 
		table {mso-displayed-decimal-separator:'\.';
			mso-displayed-thousand-separator:'\,';}	
		br {mso-data-placement:same-cell;}	
		</style>*/ 	
		//if($this->cetak_xls){
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		
		
		//$css = $this->cetak_xls	? 
		$css = $xls	? 
			"<style>
			.nfmt5 {mso-number-format:'\@';}						
			</style>":
			"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo 
			"<html>".
				"<head>
					<title>$Main->Judul</title>
					$css					
					$this->Cetak_OtherHTMLHead
				</head>".
			"<body >
			<form name='adminForm' id='adminForm' method='post' action=''>
			<div style='width:$this->Cetak_WIDTH'>
			<table class=\"rangkacetak\" style='width:$this->Cetak_WIDTH'>
			<tr><td valign=\"top\">".
				//$this->cetak_xls.		
				$this->setCetak_Header($Mode).//$this->Cetak_Header.//
				"<div id='cntTerimaKondisi'>".
					//$TampilOpt['TampilOpt'].
				"</div>
				<div id='cntTerimaDaftar' >";			
		
		$Opsi = $this->getDaftarOpsi($this->Cetak_Mode);
			//echo ',Kondisi='.$Opsi['Kondisi'].',Order='.$Opsi['Order'].',hal='.$_POST['HalDefault'].
			//	',limit='.$Opsi['Limit'].',NoAwal='.$Opsi['NoAwal'].',';								
			//echo 'vkondisi='.$$Opsi[vKondisi;
		/*if($this->Cetak_Mode==3){//flush
			$this->genDaftar(	$Opsi['Kondisi'], $Opsi['Order'], $Opsi['Limit'], $Opsi['NoAwal'], $this->Cetak_Mode, $Opsi['vKondisi_old']);
		}else{
			$daftar = $this->genDaftar(	$Opsi['Kondisi'], $Opsi['Order'], $Opsi['Limit'], $Opsi['NoAwal'], $this->Cetak_Mode, $Opsi['vKondisi_old']);
			echo $daftar['content'];
		}*/
		echo $daftarCetak;
		echo	"</div>	".			
				$this->setCetak_footer($xls).
			"</td></tr>
			</table>
			</div>
			</form>		
			</body>	
			</html>";
	}



	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		
		$Kondisi=''; $Order = ''; $Limit=''; $NoAwal = 0; $cek ='';
		
		
		//$fmFiltThnBuku = $_REQUEST['fmFiltThnBuku'];
		
		//Kondisi				
		$arrKondisi= array();
		$arrKondisi[] = " h='00'";		
		//$arrKondisi[] = " year(tgl_buku)<='$fmFiltThnBuku' ";
		
		
		$Kondisi = join(' and ',$arrKondisi); $cek .=$Kondisi;
		if($Kondisi !='') $Kondisi = ' Where '.$Kondisi;
		
		
		//order -------------------------
		$fmDESC1 = $_POST['fmDESC1'];
		$AscDsc1 = $fmDESC1 == 1? 'desc' : '';
		$fmORDER1 = $_POST['fmORDER1'];
		$fmDESC2 = $_POST['fmDESC2'];
		$AscDsc2 = $fmDESC2 == 1? 'desc' : '';
		$fmORDER2 = $_POST['fmORDER2'];
		$fmDESC3 = $_POST['fmDESC3'];
		$AscDsc3 = $fmDESC3 == 1? 'desc' : '';
		$fmORDER3 = $_POST['fmORDER3'];
		
		$OrderArr= array();		
		switch($fmORDER1){
			case '1': $OrderArr[] =  " thn_perolehan $AscDsc1 "; break;
			case '2': $OrderArr[] =  " kondisi $AscDsc1 "; break;
			case '3': $OrderArr[] =  " year(tgl_buku) $AscDsc1 "; break;			
		}
		switch($fmORDER2){
			case '1': $OrderArr[] =  " thn_perolehan $AscDsc2 "; break;
			case '2': $OrderArr[] =  " kondisi $AscDsc2 "; break;
			case '3': $OrderArr[] =  " year(tgl_buku) $AscDsc2 "; break;			
		}
		switch($fmORDER3){
			case '1': $OrderArr[] =  " thn_perolehan $AscDsc3 "; break;
			case '2': $OrderArr[] =  " kondisi $AscDsc3 "; break;
			case '3': $OrderArr[] =  " year(tgl_buku) $AscDsc3 "; break;			
		}
			
		
		//limit --------------------------------------
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal;
		$Limit = $Mode == 3 ? '': $Limit;
		$Limit = '';
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;
		
		
		$Order = join(', ',$OrderArr); 
		if($Order !='') $Order = ' Order by '.$Order;
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order, 'Limit'=>$Limit,'NoAwal'=>$NoAwal,'cek'=>$cek);
	
	}
	
	function setPage_OtherScript(){
		$scriptload = 
					"<script>
						
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
							
						});
						
						
					</script>";
		return "<script src='js/skpd.js' type='text/javascript'></script>
				<script src='js/barcode.js' type='text/javascript'></script>
				<script src='js/ruang.js' type='text/javascript'></script>
				<script src='js/pegawai.js' type='text/javascript'></script>
				
				<script src='js/usulanhapus.js' type='text/javascript'></script>
				<script src='js/usulanhapusdetail.js' type='text/javascript'></script>
				<script src='js/penatausaha.js' type='text/javascript'></script>
				<script src='js/cekbi.js' type='text/javascript'></script>
				
				
				<script type='text/javascript' src='js/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
				<!--<script type='text/javascript' src='js/unload.js' language='JavaScript' ></script>-->
						<!--<script type='text/javascript' src='pages/pendataan/modul_entry.js' language='JavaScript' ></script>
						<script type='text/javascript' src='js/dialog1.js' language='JavaScript' ></script>
						<script type='text/javascript' src='js/jquery.js' language='JavaScript' ></script>
						
						-->"
						.'<style>
						.nfmt1 {
	mso-number-format:"\#\,\#\#0_\)\;\[Red\]\\\(\#\,\#\#0\\\)";
	
}
.nfmt2 {
	mso-number-format:"0\.00_ ";
	
}
.nfmt3 {
	mso-number-format:"0000";
	
}		
.nfmt4 {
	mso-number-format:"\#\,\#\#0.00_\)\;\[Red\]\\\(\#\,\#\#0\\\)";
}
.nfmt5 {
	mso-number-format:"00";
	
}
table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";
	}
						</style>'.
						$scriptload;
	}
	
	function setKolomHeader($Mode=1, $Checkbox=''){
	global $Main,$HTTP_COOKIE_VARS;
		$cetak = $Mode==2 || $Mode==3 ;
		$cbxDlmRibu = $_POST['cbxDlmRibu'];
		$fmFiltThnBuku = $_POST['fmFiltThnBuku'];
		$fmSemester = $_POST['fmSemester'];
		$fmLvlSkpd = $_POST['fmLvlSkpd'];
		$jnsrekap = $_REQUEST['jnsrekap'];
		$rp = $jnsrekap==1? '<br>(Rp)':'';
			
			$tampilHeaderHarga = !empty($cbxDlmRibu)? 'Harga Perolehan (Ribuan)': 'Harga Perolehan';	
			$tampilDok ='';// $cetak? "" : "<th class=\"th01\" rowspan='2' width='24'></th>";
			$clGaris = $cetak? 'GarisCetak':'GarisDaftar';
		if ($fmFiltThnBuku=='') $fmFiltThnBuku = date('Y');
		
		$thnsbl =$fmFiltThnBuku -1;
		
		//default semester 1
		$thnsbl = '1 Jan '.$fmFiltThnBuku;
		$thnakhir= '30 Jun '.$fmFiltThnBuku;
		switch($fmSemester){
			case '1' :  $thnsbl = '1 Jul '.$fmFiltThnBuku; $thnakhir= '31 Des '. $fmFiltThnBuku; break; //semester 2
			case '2' :  $thnsbl = '1 Jan '.$fmFiltThnBuku ; $thnakhir= '31 Des '.$fmFiltThnBuku; break; //tahun			
		}
		if($fmLvlSkpd=='1'){
			$cols = "colspan=2";
			$tampilKodeSkpd = "<th class=\"th01\" width='10'>c1</th>
								<th class=\"th01\" width='10'>c</th>";
		}elseif($fmLvlSkpd=='2'){
			$cols = "colspan=3";
			$tampilKodeSkpd = "<th class=\"th01\" width='10'>c1</th>
								<th class=\"th01\" width='10'>c</th>
								<th class=\"th01\" width='10'>d</th>";
		}elseif($fmLvlSkpd=='3'){
			$cols = "colspan=4";
			$tampilKodeSkpd = "<th class=\"th01\" width='10'>c1</th>
								<th class=\"th01\" width='10'>c</th>
								<th class=\"th01\" width='10'>d</th>
								<th class=\"th01\" width='10'>e</th>";
		}else{
			$cols = "";
			$tampilKodeSkpd = "<th class=\"th01\" width='50'>c1</th>
								";
			$tampilHeaderAngka = "";
		}
		
		if($Main->PENERIMAAN_P19 == 1){
			$belanjaModal = "PENERIMAAN PEMBELIAN";
		}else{
			$belanjaModal = "BELANJA MODAL";
		}
		
		/** generate kolom no
		$jmlkol = 25;
		for($i=1l$i<=$jmlkol;$i++){
			$vkolno = 
		}**/
		
		//22penerimaan - pemeliharaan - belanja modal
			//23penerimaan - pemeliharaan - barang jasa
			//24penerimaan - pemeliharaan - koreksi & penggabungan - debet
			//25penerimaan - pemeliharaan - koreksi & penggabungan - kredit
			//26penerimaan - pemeliharaan - hibah
			//27penerimaan - koreksi
		
		$headerTable =
			/**"<tr>
				<th class=\"th01\" colspan='5'>Penerimaan </th>
			</tr>".**/
			"<tr>
				<th class=\"th01\" width='30' rowspan='3' >No. </th>
				<th class=\"th02\" width='50' $cols rowspan='2'>SKPD</th>
				<th class=\"th01\" width='300'  rowspan='3' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SKPD&nbsp;/&nbsp;JENIS&nbsp;ASET&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
				<th class=\"th02\" colspan='13' >Intrakomptabel</th>				
				<th class=\"th02\" rowspan='3' >Ekstrakomptabel</th>
			</tr>
			<tr>
				<th class=\"th02\" colspan='6'>Aset Tetap</th>	
				<th class=\"th02\" colspan='7'>Aset lainnnya</th>	
			</tr>
			<tr>
				$tampilKodeSkpd
				<th class=\"th03\" >Tanah</th>				
				<th class=\"th03\" >P&M</th>
				<th class=\"th03\" >G&B</th>	
				<th class=\"th03\" >JIJ</th>			
				<th class=\"th03\" >ATL</th>
				<th class=\"th03\" >KDP</th>
				<th class=\"th03\" >Tagihan Penjualan</th>
				<th class=\"th03\" >TGR</th>
				<th class=\"th03\" >Kemitraan</th>
				<th class=\"th03\" >Aset Tidak Berwujud</th>
				<th class=\"th03\" >Aset lain-Lain</th>			
				<th class=\"th03\" >Pemindahtanganan</th>
				<th class=\"th03\" >Pemusnahan</th>
			</tr>	
			$vkolno			
			$tambahgaris";
			$headerTable=$headerTable.$this->gen_table_data($Mode);
		return $headerTable;
	}
	
	function setDaftar_After($no=0, $ColStyle=''){
	
	/*	
		$c = $HTTP_COOKIE_VARS['cofmSKPD'];
		$d = $HTTP_COOKIE_VARS['cofmUNIT'];
		$e = $HTTP_COOKIE_VARS['cofmSUBUNIT'];			
		$e1 = $HTTP_COOKIE_VARS['cofmSEKSI'];			
		$jnsrekap = $_REQUEST['jnsrekap'];
		$des = $jnsrekap==1? 2:0;
		$fmFiltThnBuku = empty($_REQUEST['fmFiltThnBuku'])? date('Y') : $_REQUEST['fmFiltThnBuku']; 
		
		
		
		$vtotjmlbarang 	= number_format($this->totBrgAset, $des,',','.');
		$vtotjmlharga 		= number_format($this->totHrgAset, $des,',','.');

				
		$ListData = 
			"<tr class='row1'>
			<td class='$ColStyle' colspan=4 align=center><b>TOTAL</td> 
			<td class='$ColStyle' align='right'><b>$vtotjmlbarang</td>
				
			<td class='$ColStyle' align='right'><b>$vtotjmlharga</td>
			";
		*/
		$ListData="";
		return $ListData;
	}
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Main,$HTTP_COOKIE_VARS;
		$Koloms = array();


		
		
		
		

		return $Koloms;
	}
	
	function setKolomData_($no, $isi, $Mode, $TampilCheckBox){
		global $Main,$HTTP_COOKIE_VARS;
	
		
		

		return $Koloms;
	}
	
	
	function gen_table_data($Mode=1){
		global $Main,$HTTP_COOKIE_VARS;

		
		$cek = '';
		$cetak = $Mode==2 || $Mode==3 ;
				
		$cbxDlmRibu = $_POST['cbxDlmRibu'];
		$fmLvlSkpd = $_REQUEST['fmLvlSkpd'];
		$cbxTotal = 1;//$_REQUEST['cbxTotal'];
			
		$tampilHeaderHarga = !empty($cbxDlmRibu)? 'Harga Perolehan (Ribuan)': 'Harga Perolehan';	
		$tampilDok ='';// $cetak? "" : "<th class=\"th01\" rowspan='2' width='24'></th>";
		$clGaris = $cetak? 'GarisCetak':'GarisDaftar';
				
		$c1 = $HTTP_COOKIE_VARS['cofmURUSAN'];
		$c = $HTTP_COOKIE_VARS['cofmSKPD'];
		$d = $HTTP_COOKIE_VARS['cofmUNIT'];
		$e = $HTTP_COOKIE_VARS['cofmSUBUNIT'];	
		$e1 = $HTTP_COOKIE_VARS['cofmSEKSI'];
		
		$jnsrekap = $_REQUEST['jnsrekap'];
		$fmFiltThnBuku = empty($_REQUEST['fmFiltThnBuku'])? date('Y') : $_REQUEST['fmFiltThnBuku']; 
		$des = $jnsrekap==1? 2:0;
		
		//$tglAwal="$fmFiltThnBuku-01-01";
		//$tglAkhir="$fmFiltThnBuku-12-31";
			
		$smter=empty($_REQUEST['fmSemester'])? '' : $_REQUEST['fmSemester']; 
	
	// $smter=$_POST['$fmSemester'];

		if ($smter=='1') 
		{
			$tglAwal="$fmFiltThnBuku-07-01";
			$tglAkhir="$fmFiltThnBuku-12-31";
			$tglAwal2 = ($fmFiltThnBuku).'-06-30';
		} else if ($smter=='2') 
		{
			$tglAwal="$fmFiltThnBuku-01-01";
			$tglAkhir="$fmFiltThnBuku-12-31";
			$tglAwal2 = ($fmFiltThnBuku-1).'-12-31';
		} else
		{
			$tglAwal="$fmFiltThnBuku-01-01";
			$tglAkhir="$fmFiltThnBuku-06-30";
			$tglAwal2 = ($fmFiltThnBuku-1).'-12-31';
		}	

				
		$arrKond = array();
		if($Main->URUSAN==1){
			if(!($c1 == '' || $c1=='0') ) $arrKond[] = " c1= '$c1'";
		}
		if(!($c == '' || $c=='00') ) $arrKond[] = " c= '$c'";
		if(!($d == '' || $d=='00') ) $arrKond[] = " d= '$d'";
		if(!($e == '' || $e=='00') ) $arrKond[] = " e= '$e'";
		if(!($e1 == '' || $e1=='00' || $e1=='000') ) $arrKond[] = " e1= '$e1'";
		$KondisiSKPD = join(' and ', $arrKond);
		$KondisiSKPD = $KondisiSKPD==''? '' : ' and '.$KondisiSKPD;

		$Kondisi_ATetap=" and staset<=3 ";
		$KondisiAsal = join(' and ', $arrKond);
		if ($KondisiAsal==''){
			$KondisiAsal=" c <> '' ";
		}


		$JmlSaldoAwTot=0; $JmlBelanjaTot=0;	$JmlAtribusiTot=0; $JmlKapitalisasiDTot=0; $JmlKapitalisasiKTot=0;
		$JmlHibahDTot=0; $JmlHibahKTot=0; $JmlMutasiDTot=0; $JmlMutasiKTot=0; $JmlPenilaianDTot=0; $JmlPenghapusanKTot=0;
		$JmlPembukuanDTot=0; $JmlPembukuanKTot=0; $JmlPembukuanKTot=0; $JmlReklassDTot=0; $JmlReklassKTot=0; $JmlSaldoAkTot=0;	

		$JmlSaldoAw=0; $JmlBelanja=0; $JmlAtribusi=0; $JmlKapitalisasiD=0; $JmlKapitalisasiK=0; $JmlHibahD=0; $JmlHibahK=0;
		$JmlMutasiD=0; $JmlMutasiK=0; $JmlPenilaianD=0; $JmlPenghapusanK=0; $JmlPembukuanD=0; $JmlPembukuanK=0;	$JmlReklassD=0;
		$JmlReklassK=0; $JmlSaldoAk=0;
		
		$JmlSaldoAwTotx0; $JmlBelanjaTotx0;	$JmlAtribusiTotx0; $JmlKapitalisasiDTotx0; $JmlKapitalisasiKTotx0; $JmlHibahDTotx0;
		$JmlHibahKTotx0; $JmlMutasiDTotx0; $JmlMutasiKTotx0; $JmlPenilaianDTotx0; $JmlPenghapusanKTotx0; $JmlPembukuanDTotx0;
		$JmlPembukuanKTotx0; $JmlReklassDTotx0; $JmlReklassKTotx0; $JmlSaldoAkTotx0;						

		$Kondisi = $KondisiAsal." and staset<=4 and f<='06' ";
		
		if ( $cbxTotal ){
			$sqry=" select '00' as c, '00' as d, '00' as e, '00' as e1, 'T O T A L' as nmopd,
				'T O T A L' as nm_barcode  ";
		}else{
			if ($e1=='00' || $e1=='000' ){
				$sqry=" select * from v_opd  where c<>'' $KondisiSKPD ";
			} else {
				$sqry=" select *,nm_skpd as nmopd from ref_skpd  where c<>'' $KondisiSKPD ";
			}	
			$sqry2= $sqry;
			
			//if($c<> '00' ) 
		}
		//$sqry=" select '00' as c, '00' as d, '00' as e, '00' as e1, 'T O T A L' as nmopd,				'T O T A L' as nm_barcode  ";
		//$sqry=" select *,nm_skpd as nmopd from ref_skpd where  c='04' and d<>'00' and e='00' ";
		$cek .=$sqry;
		$cskpd=0;
		$Qry = mysql_query($sqry);
		while($isi=mysql_fetch_array($Qry)){
			$cskpd++;
			if ( $cbxTotal ==TRUE){
				$KondisiSKPDx = "1=1";
				if($Main->URUSAN==1){
					if($c1!='00' && $c1 !='') $KondisiSKPDx .= " and c1= '$c1' ";
					if($c!='00' && $c !='') $KondisiSKPDx .= $KondisiSKPDx ==''? " c= '$c' " : " and c= '$c' ";
				}else{
					if($c!='00' && $c !='') $KondisiSKPDx .= " and c= '$c' ";
				}
				//if($c!='00' && $c !='') $KondisiSKPDx .= " and c= '$c' ";
				if($d!='00' && $d !='') $KondisiSKPDx .=  $KondisiSKPDx ==''? " d= '$d' " : " and d= '$d' ";
				//$paramSKPD = $Main->URUSAN==1 ? "&c1=$c1&c=$c&d=$d&e=$e&e1=$e1" : "&c=$c&d=$d&e=$e&e1=$e1";		$cek.= ' no=1 ';		
			}else{
				if ($e1=='00' || $e1=='000' ){
					$KondisiSKPDx= $Main->URUSAN==1 ? " c1='".$isi['c1']."' and c='".$isi['c']."' and d='".$isi['d']."' " : " c='".$isi['c']."' and d='".$isi['d']."' ";							
				} else {
					$KondisiSKPDx= $Main->URUSAN==1 ? " c1='".$isi['c1']."' and c='".$isi['c']."' and d='".$isi['d']."' and e='".$isi['e']."' and e1='".$isi['e1']."' " : " c='".$isi['c']."' and d='".$isi['d']."' and e='".$isi['e']."' and e1='".$isi['e1']."' ";					
				}
				//$paramSKPD = $Main->URUSAN==1 ? "&c1=".$isi['c1']."&c=".$isi['c']."&d=".$isi['d']."&e=".$isi['e']."&e1=".$isi['e1'] : "&c=".$isi['c']."&d=".$isi['d']."&e=".$isi['e']."&e1=".$isi['e1'];
				$cek.= ' no=2 ';
			}
		
		if($fmLvlSkpd=='1'){
			$cols = "colspan=3";
		}elseif($fmLvlSkpd=='2'){
			$cols = "colspan=4";
		}elseif($fmLvlSkpd=='3'){
			$cols = "colspan=5";
		}else{
			$cols = "colspan=2";
		}
		
		$cek = $Main->SHOW_CEK  ? $cek : '';
			$ListData .="<tr class='row1'>
				<td class='GarisDaftar' align=right>$cskpd.</td>
				<td class='GarisDaftar' $cols><b>{$isi['nmopd']}</b> <div id='div_cek' style='display:none'>$cek</div></td>
				<td class='GarisDaftar' align=right>&nbsp;</td>	<td class='GarisDaftar'  align=right>&nbsp;</td><td class='GarisDaftar' align=right>&nbsp;</td>	<td class='GarisDaftar' align=right>&nbsp;</td>
				<td class='GarisDaftar' align=right>&nbsp;</td>	<td class='GarisDaftar' align=right>&nbsp;</td>	<td class='GarisDaftar' align=right>&nbsp;</td>	<td class='GarisDaftar' align=right>&nbsp;</td>
				<td class='GarisDaftar' align=right>&nbsp;</td>	<td class='GarisDaftar' align=right>&nbsp;</td>	<td class='GarisDaftar' align=right>&nbsp;</td>	<td class='GarisDaftar' align=right>&nbsp;</td> <td class='GarisDaftar' align=right>&nbsp;</td><td class='GarisDaftar' align=right>&nbsp;</td>

				</tr>"	;
			
			$JmlSaldoAwSKPD=0; $JmlBelanjaSKPD=0; $JmlAtribusiSKPD=0; $JmlKapitalisasiDSKPD=0; $JmlKapitalisasiKSKPD=0;
			$JmlHibahDSKPD=0; $JmlHibahKSKPD=0;	$JmlMutasiDSKPD=0; $JmlMutasiKSKPD=0; $JmlPenilaianDSKPD=0;	$JmlPenghapusanKSKPD=0;
			$JmlPembukuanDSKPD=0; $JmlPembukuanKSKPD=0; $JmlReklassDSKPD=0;	$JmlReklassKSKPD=0;	$JmlSaldoAkSKPD=0;
	
			$JmlSaldoAwTot=0; $JmlBelanjaTot=0;	$JmlAtribusiTot=0;	$JmlKapitalisasiDTot=0;	$JmlKapitalisasiKTot=0;
			$JmlHibahDTot=0; $JmlHibahKTot=0; $JmlMutasiDTot=0; $JmlMutasiKTot=0; $JmlPenilaianDTot=0; $JmlPenghapusanKTot=0;
			$JmlPembukuanDTot=0; $JmlPembukuanKTot=0; $JmlReklassDTot=0; $JmlReklassKTot=0;	$JmlSaldoAkTot=0;			
			
			//qry aset tetap ---------------------------------------------------------------------------------------				
			switch($fmLvlSkpd){
				case '1': $get_table="ref_skpd"; $sel="c1,c"; $konLvl1="d='00'"; break;
				case '2': $get_table="ref_skpd"; $sel="c1,c,d"; $konLvl1="e='00'"; break;
				case '3': $get_table="ref_skpd"; $sel="c1,c,d,e"; $konLvl1="e1='000'"; break;
				default : $get_table="ref_skpd"; $sel="c1"; $konLvl1="c='00'"; break;
			}
			
			$bqry = "select c1,c,d,e,e1, nm_skpd 
					from ref_skpd 
					where $konLvl1 $KondisiSKPD";
			/*$bqry =
				"select kint,ka,kb, $sel,nm_barang ,
				null as jmlbrgawal, null as jmlhargaawal, null as debet_bmd,
				null as debet_atribusi, null as debet_kapitalisasi, null as kredit_kapitalisasi, null as debet_hibah,
                null as kredit_hibah,null as debet_mutasi,null as kredit_mutasi,
				null as debet_penilaian, null as kredit_penghapusan,null as debet_koreksi,
                null as kredit_koreksi, null as debet_reklass, null as kredit_reklass,
				null as jmlbrgakhir, null as jmlhargaakhir, null as jmlhitakhir, 
				
				null as susutawal,	null as debet_susut, null as kredit_susut,
				null as susutakhir, null as nilai_buku
				from $get_table  
               	
				#$KondisiSKPDx
				
				where kint='01' and ka='01' and kb<>'00' $konLvl1";*/
			
			/*$bqry =
				"select kint,ka,kb, f,g,h,i,nm_barang ,
				null as jmlbrgawal, null as jmlhargaawal, null as debet_bmd,
				null as debet_atribusi, null as debet_kapitalisasi, null as kredit_kapitalisasi, null as debet_hibah,
                null as kredit_hibah,null as debet_mutasi,null as kredit_mutasi,
				null as debet_penilaian, null as kredit_penghapusan,null as debet_koreksi,
                null as kredit_koreksi, null as debet_reklass, null as kredit_reklass,
				null as jmlbrgakhir, null as jmlhargaakhir, null as jmlhitakhir, 
				
				null as susutawal,	null as debet_susut, null as kredit_susut,
				null as susutakhir, null as nilai_buku
				from v_ref_kib_keu_h1  
               	
				#$KondisiSKPDx
				
				where kint='01' and ka='01' and kb<>'00' ";
			*/	
			$aQry = mysql_query($bqry);		$rowno=0;
			while($isix=mysql_fetch_array($aQry)){
		  		$kdBidang = $isix['c'] == "00" ? "" : $isix['c'];
		  		$h = $isix['d'] == "00" ? "" : $isix['d'];
		  		$i = $isix['e'] == "00" ? "" : $isix['e'];
				
				if($isix['c']=='00') $JmlSaldoAwSKPD=$JmlSaldoAwSKPD+$isix['jmlhargaawal'];	
				if($isix['c']=='00')$JmlBelanjaSKPD=$JmlBelanjaSKPD+$isix['debet_bmd'];
				if($isix['c']=='00')$JmlAtribusiSKPD=$JmlAtribusiSKPD+$isix['debet_atribusi'];
				if($isix['c']=='00')$JmlKapitalisasiDSKPD=$JmlKapitalisasiDSKPD+$isix['debet_kapitalisasi'];	
				if($isix['c']=='00')$JmlKapitalisasiKSKPD=$JmlKapitalisasiKSKPD+$isix['kredit_kapitalisasi'];
				if($isix['c']=='00')$JmlHibahDSKPD=$JmlHibahDSKPD+$isix['debet_hibah'];
				if($isix['c']=='00')$JmlHibahKSKPD=$JmlHibahKSKPD+$isix['kredit_hibah'];
				if($isix['c']=='00')$JmlMutasiDSKPD=$JmlMutasiDSKPD+$isix['debet_mutasi'];
				if($isix['c']=='00')$JmlMutasiKSKPD=$JmlMutasiKSKPD+$isix['kredit_mutasi'];
				if($isix['c']=='00')$JmlPenilaianDSKPD=$JmlPenilaianDSKPD+$isix['debet_penilaian'];
				if($isix['c']=='00')$JmlPenghapusanKSKPD=$JmlPenghapusanKSKPD+$isix['kredit_penghapusan'];
				if($isix['c']=='00')$JmlPembukuanDSKPD=$JmlPembukuanDSKPD+$isix['debet_koreksi'];
				if($isix['c']=='00')$JmlPembukuanKSKPD=$JmlPembukuanKSKPD+$isix['kredit_koreksi'];
				if($isix['c']=='00')$JmlReklassDSKPD=$JmlReklassDSKPD+$isix['debet_reklass'];
				if($isix['c']=='00')$JmlReklassKSKPD=$JmlReklassKSKPD+$isix['kredit_reklass'];
				if($isix['c']=='00')$JmlSaldoAkSKPD=$JmlSaldoAkSKPD+$isix['jmlhitakhir'];
				
				if($isix['c']=='00')$JmlSusutAk+=$isix['susutakhir'];
				if($isix['c']=='00')$JmlSusutAw+=$isix['susutawal'];
				if($isix['c']=='00')$Jmldebet_susut+=$isix['debet_susut'];
				if($isix['c']=='00')$Jmlkredit_susut+=$isix['kredit_susut'];
				if($isix['c']=='00')$JmlNilaiBuku+=$isix['nilai_buku'];
				
		
				
				
				//tampil aset tetap -------------------------------------------------------------------
				$rowno ++;
				if($fmLvlSkpd=='1' || $fmLvlSkpd=='2' || $fmLvlSkpd=='3'){
					$bold = ($isix['c']=='00') || ($isix['c']<>'00' && $isix['d']=='00') || ($isix['c']<>'00' && $isix['d']<>'00' && $isix['e']=='00') ? 1 : 0;
				}else{
					$bold = 0;
				}
				//get kondisi f,g,h,i,j
				$arrParamSKPD = array();
				if(($isix['c1'] != '' || $isix['c1']!='00') ) {$arrParamSKPD[] = "c1=".$isix['c1']."";}
				else{ $arrParamSKPD[] = "c1=00";}
				if(($isix['c'] != '' || $isix['c']!='00') ) {$arrParamSKPD[] = "c=".$isix['c']."";}
				else{ $arrParamSKPD[] = "c=00";}
				if(($isix['d'] != '' || $isix['d']!='00') ) {$arrParamSKPD[] = "d=".$isix['d']."";}
				else{ $arrParamSKPD[] = "d=00";}
				if(($isix['e'] != '' || $isix['e']!='00') ) {$arrParamSKPD[] = "e=".$isix['e']."";}
				else{ $arrParamSKPD[] = "e=00";}				
				$paramSKPD = join('&', $arrParamSKPD);
				$paramSKPD = $paramSKPD==''? '' : '&'.$paramSKPD;				
				$hrefAw = "pages.php?Pg=Jurnal$paramSKPD&tgl2=$tglAwal2";
				$hrefAk = "pages.php?Pg=Jurnal$paramSKPD&tgl2=$tglAkhir";
				$href 	= "pages.php?Pg=Jurnal$paramSKPD&tgl1=$tglAwal&tgl2=$tglAkhir";
				//$vnmbarang = $isix['g']=='00' ?  "<b>&nbsp;&nbsp;&nbsp;{$isix['nm_barang']}</b>" : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$isix['nm_barang']}";
				//bold
				if($fmLvlSkpd=='1' || $fmLvlSkpd=='2' || $fmLvlSkpd=='3'){
					if($isix['c']=='00'){
						$vnmbidang = "<b>{$isix['nm_skpd']}</b>";
						$vf = "<b>{$isix['c1']}</b>";
						$vg = "<b>$kdBidang</b>";
						$vh = "<b>$h</b>";
						$vi = "<b>$i</b>";
					}elseif($isix['c']<>'00' && $isix['d']=='00'){
						//$vnmbarang = "<b>&nbsp;&nbsp;&nbsp;&nbsp;{$isix['nm_barang']}</b>";
						$vnmbidang = "<b><span class='tab20'>{$isix['nm_skpd']}</span></b>";
						$vf = "<b>{$isix['c1']}</b>";
						$vg = "<b>$kdBidang</b>";
						$vh = "<b>$h</b>";
						$vi = "<b>$i</b>";
					}elseif($isix['c']<>'00' && $isix['d']<>'00' && $isix['e']=='00'){
						//$vnmbarang = "<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$isix['nm_barang']}</b>";
						$vnmbidang = "<b><span class='tab30'>{$isix['nm_skpd']}</span></b>";
						$vf = "<b>{$isix['c1']}</b>";
						$vg = "<b>$kdBidang</b>";
						$vh = "<b>$h</b>";
						$vi = "<b>$i</b>";
					}else{
						//$vnmbarang = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$isix['nm_barang']}";
						$vnmbidang = "<b><span class='tab40'>{$isix['nm_skpd']}</span></b>";
						$vf = "{$isix['c1']}";
						$vg = "$kdBidang";
						$vh = "$h";
						$vi = "$i";
					}
				}else{
					if($fmLvlSkpd=='1'){
						//$vnmbarang = $isix['g']=='00' ?  "<b>&nbsp;&nbsp;&nbsp;{$isix['nm_barang']}</b>" : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$isix['nm_barang']}";
						$vnmbidang = $isix['c']=='00' ?  "<b><span class='tab15'>{$isix['nm_skpd']}</span></b>" : "<span class='tab30'>{$isix['nm_skpd']}</span>";
						$vf = $isix['g']=='00' ? "<b>{$isix['c1']}</b>" : "{$isix['c1']}";
						$vg = $isix['g']=='00' ? "<b>$kdBidang</b>" : "$kdBidang";
						$vh = $isix['g']=='00' ? "<b>$h</b>" : "$h";
						$vi = $isix['g']=='00' ? "<b>$i</b>" : "$i";
					}else{
						$vnmbidang = "{$isix['nm_skpd']}";
							$vf = "{$isix['c1']}";
							$vg = "$kdBidang";
							$vh = "$h";
							$vi = "$i";
					}
				}
				
				//kode barang f,g,h,i
				if($fmLvlSkpd=='1'){
					$daftarKodeBarang = "<td class='GarisDaftar' align=right>$vg</td>";
				}elseif($fmLvlSkpd=='2'){
					$daftarKodeBarang = "<td class='GarisDaftar' align=right>$vg</td>
										<td class='GarisDaftar' align=right>$vh</td>";
				}elseif($fmLvlSkpd=='3'){
					$daftarKodeBarang = "<td class='GarisDaftar' align=right>$vg</td>
										<td class='GarisDaftar' align=right>$vh</td>
										<td class='GarisDaftar' align=right>$vi</td>";
				}else{
					$daftarKodeBarang = "";
				}
				
				
				
							
				
				
				
				$ListData .="<tr class='row1'>
				<td class='GarisDaftar' align=right>&nbsp;</td>
				<td class='GarisDaftar' align=right>$vf</td>
				$daftarKodeBarang
				<td class='GarisDaftar' >$vnmbidang</td>
				
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=01&kb=01' target='blank_'  style='color:black;' id='vrekap_$rowno"."_1' name='vrekap'>$TampilJmlSaldoAwSKPD</a></td>
				
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=01&kb=02' target='blank_'  style='color:black;' id='vrekap_$rowno"."_2' name='vrekap'>$TampilJmlSusutAw</a></td>
				
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=01&kb=03' target='blank_'  style='color:black;' id='vrekap_$rowno"."_3' name='vrekap'>$TampilJmlBelanjaSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=01&kb=04' target='blank_'  style='color:black;' id='vrekap_$rowno"."_4' name='vrekap'>$TampilJmlAtribusiSKPD</a></td>".
				
				"<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=01&kb=05' target='blank_'  style='color:black;' id='vrekap_$rowno"."_5' name='vrekap'>$TampilJmlHibahDSKPD</a></td>". //penerimaan hibah				
				"<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=01&kb=06' target='blank_'  style='color:black;' id='vrekap_$rowno"."_6' name='vrekap'>$TampilJmlKapitalisasiDSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=01' target='blank_'  style='color:black;' id='vrekap_$rowno"."_7' name='vrekap'>$TampilJmlKapitalisasiKSKPD</a></td>
				
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=02' target='blank_'  style='color:black;' id='vrekap_$rowno"."_8' name='vrekap'>$TampilJmlHibahKSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=03' target='blank_'  style='color:black;' id='vrekap_$rowno"."_9' name='vrekap'>$TampilJmlMutasiDSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=04' target='blank_'  style='color:black;' id='vrekap_$rowno"."_10' name='vrekap'>$TampilJmlMutasiKSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=05' target='blank_'  style='color:black;' id='vrekap_$rowno"."_11' name='vrekap'>$TampilJmlPenilaianDSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=06' target='blank_'  style='color:black;' id='vrekap_$rowno"."_12' name='vrekap'>$TampilJmlPenghapusanKSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=07' target='blank_'  style='color:black;' id='vrekap_$rowno"."_13' name='vrekap'>$TampilJmlPenghapusanKSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=02&ka=00&kb=00' target='blank_'  style='color:black;' id='vrekap_$rowno"."_14' name='vrekap'>$TampilJmlPenghapusanKSKPD</a></td>
				".
				
				
				
				
				"</tr>"	;
		  
		  	}																																																									
			
			//22penerimaan - pemeliharaan - belanja modal
			//23penerimaan - pemeliharaan - barang jasa
			//24penerimaan - pemeliharaan - koreksi & penggabungan - debet
			//25penerimaan - pemeliharaan - koreksi & penggabungan - kredit
			//26penerimaan - pemeliharaan - hibah
			//27penerimaan - koreksi
			
			//tampil total Jumlah -----------------------------------------------------
			if($KondisiSKPD!=""){
				$arrParamSKPD = array();
				if(($c1 != '' || $c1!='00') ) {$arrParamSKPD[] = "c1=".$c1."";}
				else{ $arrParamSKPD[] = "c1=00";}
				if(($c != '' || $c!='00') ) {$arrParamSKPD[] = "c=".$c."";}
				else{ $arrParamSKPD[] = "c=00";}
				if(($d != '' || $d!='00') ) {$arrParamSKPD[] = "d=".$d."";}
				else{ $arrParamSKPD[] = "d=00";}
				if(($e != '' || $e!='00') ) {$arrParamSKPD[] = "e=".$e."";}
				else{ $arrParamSKPD[] = "e=00";}				
				$paramSKPD = join('&', $arrParamSKPD);
				$paramSKPD = $paramSKPD==''? '' : '&'.$paramSKPD;	
				//$paramSKPD = $paramSKPD;						
			}else{
				$paramSKPD = "";			
			}
			$paramKdAkun = "&bold=1";
			//$tglAwal2 = ($fmFiltThnBuku-1).'-12-31';
			$hrefAw = "pages.php?Pg=Jurnal$paramSKPD&tgl2=$tglAwal2";
			//$hrefAw = "<a href='$hrefAw' target='blank_'  style='color:black;'>";
			$hrefAk = "pages.php?Pg=Jurnal$paramSKPD&tgl2=$tglAkhir";
			//$hrefAk = "<a href='$hrefAk' target='blank_'  style='color:black;'>";
			$href 	= "pages.php?Pg=Jurnal$paramSKPD&tgl1=$tglAwal&tgl2=$tglAkhir";
			$rowno++;
			$ListData .="<tr class='row1'>
				<td class='GarisDaftar' align=right>&nbsp;</td>
				<td class='GarisDaftar' $cols><b>Jumlah Total</b></td>".
				"<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=01&kb=01' target='blank_'  style='color:black;' id='vrekap_$rowno"."_1' name='vrekap'>$TampilJmlSaldoAwSKPD</a></td>
				
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=01&kb=02' target='blank_'  style='color:black;' id='vrekap_$rowno"."_2' name='vrekap'>$TampilJmlSusutAw</a></td>
				
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=01&kb=03' target='blank_'  style='color:black;' id='vrekap_$rowno"."_3' name='vrekap'>$TampilJmlBelanjaSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=01&kb=04' target='blank_'  style='color:black;' id='vrekap_$rowno"."_4' name='vrekap'>$TampilJmlAtribusiSKPD</a></td>".
				
				"<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=01&kb=05' target='blank_'  style='color:black;' id='vrekap_$rowno"."_5' name='vrekap'>$TampilJmlHibahDSKPD</a></td>". //penerimaan hibah				
				"<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=01&kb=06' target='blank_'  style='color:black;' id='vrekap_$rowno"."_6' name='vrekap'>$TampilJmlKapitalisasiDSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=01' target='blank_'  style='color:black;' id='vrekap_$rowno"."_7' name='vrekap'>$TampilJmlKapitalisasiKSKPD</a></td>
				
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=02' target='blank_'  style='color:black;' id='vrekap_$rowno"."_8' name='vrekap'>$TampilJmlHibahKSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=03' target='blank_'  style='color:black;' id='vrekap_$rowno"."_9' name='vrekap'>$TampilJmlMutasiDSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=04' target='blank_'  style='color:black;' id='vrekap_$rowno"."_10' name='vrekap'>$TampilJmlMutasiKSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=05' target='blank_'  style='color:black;' id='vrekap_$rowno"."_11' name='vrekap'>$TampilJmlPenilaianDSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=06' target='blank_'  style='color:black;' id='vrekap_$rowno"."_12' name='vrekap'>$TampilJmlPenghapusanKSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=01&ka=02&kb=07' target='blank_'  style='color:black;' id='vrekap_$rowno"."_13' name='vrekap'>$TampilJmlPenghapusanKSKPD</a></td>
				<td class='GarisDaftar' align=right><a href='$hrefAk&kint=02&ka=00&kb=00' target='blank_'  style='color:black;' id='vrekap_$rowno"."_14' name='vrekap'>$TampilJmlPenghapusanKSKPD</a></td>
				".
				
				
				
				
				"</tr>"	;
		
				

			$this->JmlSaldoAwTot += $JmlSaldoAwTot;	
			$this->JmlBelanjaTot += $JmlBelanjaTot;
			$this->JmlAtribusiTot += $JmlAtribusiTot ;
			$this->JmlKapitalisasiDTot += $JmlKapitalisasiDTot;	
			$this->JmlKapitalisasiKTot += $JmlKapitalisasiKTot;
			$this->JmlHibahDTot += $JmlHibahDTot;
			$this->JmlHibahKTot += $JmlHibahKTot;
			$this->JmlMutasiDTot += $JmlMutasiDTot;
			$this->JmlMutasiKTot += $JmlMutasiKTot;
			$this->JmlPenilaianDTot += $JmlPenilaianDTot;
			$this->JmlPenghapusanKTot += $JmlPenghapusanKTot;
			$this->JmlPembukuanDTot += $JmlPembukuanDTot;
			$this->JmlPembukuanKTot += $JmlPembukuanKTot;
			$this->JmlReklassDTot += $JmlReklassDTot;
			$this->JmlReklassKTot += $JmlReklassKTot;
			$this->JmlSaldoAkTot += $JmlSaldoAkTot;
			
			$this->JmlSusutAkTot += $JmlSusutAkTot;
			$this->JmlSusutAwTot += $JmlSusutAkTot;
			$this->Jmldebet_susutTot += $Jmldebet_susutTot;
			$this->debet_susutTot += $jmlkredit_susutTot;
			$this->NilaiBukuTot += $jmlNilaiBukuTot;
	
		}

		return $ListData;
	}

	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		
		$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD'); //echo 'fmskpd='.$fmSKPD;
		$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		$fmSEKSI = cekPOST($this->Prefix.'SkpdfmSEKSI');
		
		if($Main->URUSAN==1){
			$fmURUSAN = cekPOST($this->Prefix.'SkpdfmURUSAN');
			$printSKPD = PrintSKPD2_urusan($fmURUSAN, $fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI,$this->cetak_xls);
		}else{
			$printSKPD = PrintSKPD2($fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI,$this->cetak_xls);
		}

		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\" colspan=6>REKAP NERACA</td>
			</tr>
			</table>"	
			.$printSKPD."<br>";
	}
	
	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){	
			case 'rekapNeraca':{
				$fm = $this->rekapNeraca();// $this->total();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
				break;
			}			
			default:{
				$err = 'content tidak ada!';
				break;
			}
		}	
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function rekapNeraca(){
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		
		//&c=00&d=00&e=00&e1=00&kint=01&ka=01&kb=01&tgl1=2015-01-01&tgl2=2015-12-31&jns_trans=1
		$c1 = $_REQUEST['c1'];
		$c = $_REQUEST['c'];
		$d = $_REQUEST['d'];
		$e = $_REQUEST['e'];
		$e1 = $_REQUEST['e1'];
		$idel= $_REQUEST['idel'];
		$bold = $_REQUEST['bold'];
		$tanpasusut = $_REQUEST['tanpasusut'];
		$isjmlbrg = $_REQUEST['isjmlbrg'];
		$fmFiltThnBuku = $_REQUEST['fmFiltThnBuku'];
		$fmSemester = $_REQUEST['fmSemester'];
				
		//$tgl1 = $_REQUEST['tgl1'];
		//$tgl2 = $_REQUEST['tgl2'];		
		//$jns_trans = $_REQUEST['jns_trans'];
				
		//kondisi
		$arrKondisi = array();	//$arrKondisi[] = " idawal = '740330' ";				
		if($Main->URUSAN==1){
			if(!($c1=='' || $c1=='00') ) $arrKondisi[] = "c1='$c1'";
		}
		if(!($c=='' || $c=='00') ) $arrKondisi[] = "c='$c'";
		if(!($d=='' || $d=='00') ) $arrKondisi[] = "d='$d'";
		if(!($e=='' || $e=='00') ) $arrKondisi[] = "e='$e'";
		if(!($e1=='' || $e1=='00') ) $arrKondisi[] = "e1='$e1'";
				
		$idawal = $_REQUEST['idawal'];
		if($idawal!='')$arrKondisi[] = " idawal = '$idawal' ";	
		$idbi = $_REQUEST['idbi'];
		if($idbi!='')$arrKondisi[] = " idbi = '$idbi' ";	
		
		//$kd_akun = $_REQUEST['kd_akun'];
		$kint = $_REQUEST['kint'];
		$ka = $_REQUEST['ka'];
		$kb = $_REQUEST['kb'];
		$g = $_REQUEST['g']==''?'00':$_REQUEST['g'];
		$h = $_REQUEST['h']==''?'00':$_REQUEST['h'];
		$i = $_REQUEST['i']==''?'00':$_REQUEST['i'];
		$debet = $_REQUEST['debet'];
		
		$cek .= "kint=$kint ka=$ka kb=$kb";
		$kdakun = $kint; //$cek .= " kdakun1=$kdakun ";
		$kdakun .= $ka!='' && $ka!='00' && $ka != NULL ?  '.'.$ka :''; //$cek .= " kdakun2=$kdakun ";
		$kdakun .= $kb!='' && $kb!='00' && $kb != NULL ?  '.'.$kb :''; //$cek .= " kdakun3=$kdakun ";	
		/*if($kdakun!='') {
			//
			
			//if($kint = '01' && $ka = '01') {
			//	$arrKondisi[] = " f='$ka' and g='$kb'";	
			//}else{
				$arrKondisi[] = " CONCAT(CAST(kint AS CHAR CHARACTER SET utf8),'.',CAST(ka AS CHAR CHARACTER SET utf8),'.', CAST(kb AS CHAR CHARACTER SET utf8)) like '$kdakun%'";
			//}
		}*/
		
		
		
		/*		
		$tgl1 = $_REQUEST['tgl1'];
		if($tgl1!='') $arrKondisi[] = " tgl_buku >='$tgl1' ";
		$tgl2 = $_REQUEST['tgl2'];
		if($tgl2!='') $arrKondisi[] = " tgl_buku <='$tgl2' ";
		$jns_trans = $_REQUEST['jns_trans'];
		if($jns_trans!='') $arrKondisi[] = " jns_trans ='$jns_trans' ";
		$jns_trans2 = $_REQUEST['jns_trans2'];
		if($jns_trans2!='') $arrKondisi[] = " jns_trans2 ='$jns_trans2' ";
		$debet = $_REQUEST['debet'];
		*/
		
		//if($tanpasusut==1) $arrKondisi[] = " jns_trans <> 10 ";
		
		/*if($debet!='') {
			switch ($debet){
				case '1': $arrKondisi[] = " debet >0 "; break;
				case '2': $arrKondisi[] = " kredit >0 "; break;				
			}			
		}else{
			
		}*/
		
		
		if($g!='' && $g != '00') $arrKondisi[] = " g='$g' ";
		if($h!='' && $h != '00') $arrKondisi[] = " h='$h' ";
		if($i!='' && $i != '00') $arrKondisi[] = " i='$i' ";
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//$jml = $debet ==2 ? "kredit" : "debet";
		
		
		
		if($isjmlbrg==1){
			if($jns_trans==10){
				$jml = " jml_barang_k-jml_barang_d "; //penyusutan
			}else{
				$jml = " jml_barang_d-jml_barang_k ";	
			}
			switch($debet){
				case '1' : $jml = "jml_barang_d"; break;
				case '2' : $jml = "jml_barang_k"; break;
				//else $jml = " debet-kredit "; break;
			}
		}else{
			if($jns_trans==10){
				$jml = " kredit-debet "; //penyusutan
			}else{
				$jml = " debet-kredit ";	
			}
			switch($debet){
				case '1' : $jml = "debet"; break;
				case '2' : $jml = "kredit"; break;
				//else $jml = " debet-kredit "; break;
			}
		}
			
		
		if($Main->JURNAL_FISIK){
			$tbl = 't_jurnal_aset';//				
		}else{
			$tbl = 'v_jurnal';//				
		}
		
		/*switch ($kint){
			case '01' : 
				switch ($ka){
					case '01': $tbl = ' t_jurnal_aset_tetap ';	break;
					case '02': $tbl = ' t_jurnal_aset_lainnya ';	break;
				}				
			break;
			case '02' :
				$tbl = ' t_jurnal_aset_ekstra ';
			break;			
		}
		*/
		
		switch($fmSemester){
			case 1 : $tgl1 = $fmFiltThnBuku.'-07-01'; $tgl2 = $fmFiltThnBuku.'-12-31'; break;
			case 2 : $tgl1 = $fmFiltThnBuku.'-01-01'; $tgl2 = $fmFiltThnBuku.'-12-31'; break; 
			default : $tgl1 = $fmFiltThnBuku.'-01-01'; $tgl2 = $fmFiltThnBuku.'-06-31'; break;
		}
		
		

				
		$aqry = " select  ".			
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='01' and kb='01', debet-kredit  ,0) ) as total1_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='01' and kb='01', jml_barang_d - jml_barang_k  ,0) ) as total1_2, 
			
			sum( if( tgl_buku<='$tgl2' and kint='01' and ka='01' and kb='02', debet-kredit  ,0) ) as total2_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='01' and kb='02', jml_barang_d - jml_barang_k  ,0) ) as total2_2,
			
			sum( if( tgl_buku<='$tgl2' and kint='01' and ka='01' and kb='03', debet-kredit  ,0) ) as total3_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='01' and kb='03', jml_barang_d - jml_barang_k  ,0) ) as total3_2,
			
			sum( if( tgl_buku<='$tgl2' and kint='01' and ka='01' and kb='04', debet-kredit  ,0) ) as total4_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='01' and kb='04', jml_barang_d - jml_barang_k  ,0) ) as total4_2,
			
			sum( if( tgl_buku<='$tgl2' and kint='01' and ka='01' and kb='05', debet-kredit  ,0) ) as total5_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='01' and kb='05', jml_barang_d - jml_barang_k  ,0) ) as total5_2,
			
			sum( if( tgl_buku<='$tgl2' and kint='01' and ka='01' and kb='06', debet-kredit  ,0) ) as total6_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='01' and kb='06', jml_barang_d - jml_barang_k  ,0) ) as total6_2, 
			
			sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='01', debet-kredit  ,0) ) as total7_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='01', jml_barang_d - jml_barang_k  ,0) ) as total7_2,

			sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='02', debet-kredit  ,0) ) as total8_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='02', jml_barang_d - jml_barang_k  ,0) ) as total8_2,

			sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='03', debet-kredit  ,0) ) as total9_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='03', jml_barang_d - jml_barang_k  ,0) ) as total9_2,

			sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='04', debet-kredit  ,0) ) as total10_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='04', jml_barang_d - jml_barang_k  ,0) ) as total10_2,
			
			sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='05', debet-kredit  ,0) ) as total11_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='05', jml_barang_d - jml_barang_k  ,0) ) as total11_2,
			
			sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='06', debet-kredit  ,0) ) as total112_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='06', jml_barang_d - jml_barang_k  ,0) ) as total112_2,
			
			sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='07', debet-kredit  ,0) ) as total13_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='01' and ka='02' and kb='07', jml_barang_d - jml_barang_k  ,0) ) as total13_2,

			sum( if( tgl_buku<='$tgl2' and kint='02' and ka='00' and kb='00', debet-kredit  ,0) ) as total14_1, ".	//penilaian debet (+/-)
			" sum( if( tgl_buku<='$tgl2' and kint='02' and ka='00' and kb='00', jml_barang_d - jml_barang_k  ,0) ) as total14_2
			".
			
			" from $tbl ".
			" $Kondisi "; $cek.=$aqry;
		
		//select  sum( jml_barang_d-jml_barang_k ) as total from  t_jurnal_aset   Where  CONCAT(CAST(kint AS CHAR CHARACTER SET utf8),'.',CAST(ka AS CHAR CHARACTER SET utf8),'.', CAST(kb AS CHAR CHARACTER SET utf8)) like '01.01.01%' and  tgl_buku <='2008-12-31'  and  jns_trans <> 10
		//rekap mutasi
		//$aqry = "select sum( if( , jml_barang_d - jml_barang_k,0  ) ".
		//	"from $tbl ".
		//	$Kondisi;
		
		$hsl = mysql_fetch_array( mysql_query($aqry) );
		
		$des = 2;//$isjmlbrg ==1? 0: 2;
		
		$content->idel = $idel;
		$content->total =  is_null($hsl['total'])? 0 : $hsl['total'] ;
		$content->total1 = is_null($hsl['total1'])? 0 :$hsl['total1'];//saldo aw
		$content->total2 = is_null($hsl['total2'])? 0 :$hsl['total2'];//saldo aw
		$content->total3 = is_null($hsl['total3'])? 0 :$hsl['total3'];//saldo aw
		$content->total4 = is_null($hsl['total4'])? 0 :$hsl['total4'];
		$content->total5 = is_null($hsl['total5'])? 0 :$hsl['total5'];
		$content->total6 = is_null($hsl['total6'])? 0 :$hsl['total6'];
		$content->total7 = is_null($hsl['total7'])? 0 :$hsl['total7'];
		$content->total8 = is_null($hsl['total8'])? 0 :$hsl['total8'];
		$content->total9 = is_null($hsl['total9'])? 0 :$hsl['total9'];
		$content->total10 = is_null($hsl['total10'])? 0 :$hsl['total10'];//saldo ak brg
		$content->total11 = is_null($hsl['total11'])? 0 :$hsl['total11'];//saldo ak hrg 
		$content->total12 = is_null($hsl['total12'])? 0 :$hsl['total12'];//saldo ak susut
		
		
		
		
		$content->vtotal =  $bold ? '<b>'. number_format($content->total,$des,',' , '.' ) .'</b>':  number_format($content->total,$des,',' , '.' );
		$content->vtotal1 =  $bold ? '<b>'. number_format($content->total1,$des,',' , '.' ) .'</b>':  number_format($content->total1,$des,',' , '.' );
		$content->vtotal2 =  $bold ? '<b>'. number_format($content->total2,$des,',' , '.' ) .'</b>':  number_format($content->total2,$des,',' , '.' );
		$content->vtotal3 =  $bold ? '<b>'. number_format($content->total3,$des,',' , '.' ) .'</b>':  number_format($content->total3,$des,',' , '.' );
		$content->vtotal4 =  $bold ? '<b>'. number_format($content->total4,$des,',' , '.' ) .'</b>':  number_format($content->total4,$des,',' , '.' );
		$content->vtotal5 =  $bold ? '<b>'. number_format($content->total5,$des,',' , '.' ) .'</b>':  number_format($content->total5,$des,',' , '.' );
		$content->vtotal6 =  $bold ? '<b>'. number_format($content->total6,$des,',' , '.' ) .'</b>':  number_format($content->total6,$des,',' , '.' );
		$content->vtotal7 =  $bold ? '<b>'. number_format($content->total7,$des,',' , '.' ) .'</b>':  number_format($content->total7,$des,',' , '.' );
		$content->vtotal8 =  $bold ? '<b>'. number_format($content->total8,$des,',' , '.' ) .'</b>':  number_format($content->total8,$des,',' , '.' );
		$content->vtotal9 =  $bold ? '<b>'. number_format($content->total9,$des,',' , '.' ) .'</b>':  number_format($content->total9,$des,',' , '.' );
		$content->vtotal10 =  $bold ? '<b>'. number_format($content->total10,$des,',' , '.' ) .'</b>':  number_format($content->total10,$des,',' , '.' );
		$content->vtotal11 =  $bold ? '<b>'. number_format($content->total11,$des,',' , '.' ) .'</b>':  number_format($content->total11,$des,',' , '.' );
		$content->vtotal12 =  $bold ? '<b>'. number_format($content->total12,$des,',' , '.' ) .'</b>':  number_format($content->total12,$des,',' , '.' );
		
		$jmlkol = 14;
		$arrTotN = array();
		$arrVTotN = array();
		for ($i=0;$i<$jmlkol;$i++){
			//for ($j=0;$j<4;$j++){
				$des= $j<2 ? 2 : 0;
				$arrTotN[$i+1][1] = is_null( $hsl['total'.($i+1).'_1'] )? 0 : $hsl['total'.($i+1).'_1'];	//harga
				$arrTotN[$i+1][2] = is_null( $hsl['total'.($i+1).'_2'] )? 0 : $hsl['total'.($i+1).'_2'];	//jumlah
				//$arrTotN[$i][$j] = is_null( $hsl['total'.($i+1).'_2'] )? 0 : $hsl['total'.($i+1).'_2'];	//harga format
				//$arrTotN[$i][$j] = is_null( $hsl['total'.($i+1).'_2'] )? 0 : $hsl['total'.($i+1).'_2'];	//jumlah format							
				$arrTotN[$i+1][3] =  $bold ? '<b>'. number_format($arrTotN[$i+1][1],$des,',' , '.' ) .'</b>':  number_format($arrTotN[$i+1][1],$des,',' , '.' );
				$arrTotN[$i+1][4] =    number_format($arrTotN[$i+1][2],0,',' , '.' );
			//}
		}
		/**
		//nilai buku 21
		$arrTotN[$jmlkol][1] = $arrTotN[$jmlkol-2][1] - $arrTotN[$jmlkol-1][1] ;
		$arrTotN[$jmlkol][2] = $arrTotN[$jmlkol-2][2] - $arrTotN[$jmlkol-1][2] ;
		$arrTotN[$jmlkol][3] =  $bold ? '<b>'. number_format($arrTotN[$jmlkol][1],$des,',' , '.' ) .'</b>':  number_format($arrTotN[$jmlkol][1],$des,',' , '.' );
		$arrTotN[$jmlkol][4] =    number_format($arrTotN[$jmlkol][2],0,',' , '.' );
		**/		
		$content->totalN = $arrTotN;
		//$content->vtotalN = $arrVTotN;
		
		
		$content->saldoAk = is_null($hsl['total11'])? 0 : $hsl['total11'];
		$content->saldoAkBrg = is_null($hsl['total10'])? 0 : $hsl['total10'];
		$content->susutAk = is_null($hsl['total12'])? 0 :$hsl['total12'];
		$content->nilaibukuAk = $content->saldoAk  - $content->susutAk ;
		
		$content->vSaldoAk =$bold ? '<b>'. number_format($content->saldoAk ,2,',' , '.' ) .'</b>':  number_format($content->saldoAk ,2,',' , '.' );
		$content->vSaldoAkBrg =$bold ? '<b>'. number_format($content->saldoAkBrg ,0,',' , '.' ) .'</b>':  number_format($content->saldoAkBrg ,0,',' , '.' );
		$content->vSusutAk =$bold ? '<b>'. number_format($content->susutAk,2,',' , '.' ) .'</b>':  number_format($content->susutAk,2,',' , '.' );
		$content->vNilaibukuAk =$bold ? '<b>'. number_format($content->nilaibukuAk,2,',' , '.' ) .'</b>':  number_format($content->nilaibukuAk,2,',' , '.' );
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	
}


$RekapNeracaSKPD= new RekapNeracaSKPDObj();



?>
