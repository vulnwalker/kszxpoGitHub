<?php

class PembukuanObj2 extends DaftarObj2{
	var $Prefix = 'Pembukuan2_2'; //jsname
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
	var $fileNameExcel='RekapNeraca.xls';
	var $Cetak_Judul = 'Rekap Neraca';
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
	var $PageTitle = 'Rekap Neraca';
	var $PageIcon = 'images/penatausahaan_ico.gif';
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

		return array('sum'=>0, 'hal'=>0, 'sums'=>0, 'jmldata'=>0, 'cek'=>'' );
	}

	function setTitle(){
		//return 'Rekapitulasi Hasil Sensus Tahun '. getTahunSensus() ;
		return 'Rekap Neraca ';
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
		$menu_kibg1 = $Main->MODUL_ASET_LAINNYA?
			"<A href=\"?Pg=$Pg&SPg=kibg&jns=atb\" $styleMenu3_9 title='Aset Tak Berwujud'>ASET TAK BERWUJUD</a> |":'';
		
		
		$menu_pembukuan1 =
		($Main->MODUL_AKUNTANSI )?
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
	<A href=\"pages.php?Pg=Rekap1\" title='Rekap BI' >REKAP BI</a> 
	<!--| <A href=\"pages.php?Pg=Rekap5\" title='Rekap BI' >REKAP BI 2</a> -->
	$menu_rekapneraca_2
	| <A href=\"pages.php?Pg=Rekap3\" title='Rekap Mutasi'  >REKAP MUTASI</a>
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
		
		return $menubar;
			
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
		
		return $menubar;
			
	}
	
	function genDaftarOpsi(){
		global $Main,$fmFiltThnBuku;
		
		
		$fmFiltThnBuku = $_REQUEST['fmFiltThnBuku'];
		$fmFiltThnSensus = $_REQUEST['fmFiltThnSensus'];
		$fmFiltThnPerolehan = $_REQUEST['fmFiltThnPerolehan'];
		$fmKONDBRG = $_REQUEST['fmKONDBRG'];
		$jnsrekap = $_REQUEST['jnsrekap'];
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
		$cbxTotal = $_REQUEST['cbxTotal'];
		$vcbxtotal = $cbxTotal ?  " checked='true' " : '';
		
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
					'Tampilkan : '.
					' Tahun Buku '.
					"<input type='text' id='fmFiltThnBuku' name='fmFiltThnBuku' value='$fmFiltThnBuku' 
						size='4' maxlength='4' onkeypress='return isNumberKey(event)' >"
					/*genComboBoxQry('fmFiltThnBuku',$fmFiltThnBuku,
						"select year(tgl_buku)as thnbuku from buku_induk group by thnbuku desc",
						'thnbuku', 'thnbuku','Tahun Buku')*/,
					"<input type='checkbox' name='cbxTotal' id='cbxTotal' value='1' $vcbxtotal  >Total"
				),$this->Prefix.".refreshList(true)",TRUE
			)
			;
		
		return array('TampilOpt'=>$TampilOpt);
		
	
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
		$cetak = $Mode==2 || $Mode==3 ;
		$cbxDlmRibu = $_POST['cbxDlmRibu'];
		$fmFiltThnBuku = $_POST['fmFiltThnBuku'];
		$jnsrekap = $_REQUEST['jnsrekap'];
		$rp = $jnsrekap==1? '<br>(Rp)':'';
			
			$tampilHeaderHarga = !empty($cbxDlmRibu)? 'Harga Perolehan (Ribuan)': 'Harga Perolehan';	
			$tampilDok ='';// $cetak? "" : "<th class=\"th01\" rowspan='2' width='24'></th>";
			$clGaris = $cetak? 'GarisCetak':'GarisDaftar';
		if ($fmFiltThnBuku=='') $fmFiltThnBuku = date('Y');
		
		$thnsbl =$fmFiltThnBuku -1;
			
		$headerTable =
			"<tr>
				<th class=\"th01\" width='30' rowspan='2' >No. </th>
				<th class=\"th01\" width='300'  rowspan='2' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SKPD&nbsp;/&nbsp;JENIS&nbsp;ASET&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
				<th class=\"th02\" colspan=2 >SALDO AWAL $thnsbl</th>				
				<th class=\"th02\" >BELANJA MODAL</th>
				<th class=\"th02\" >ATRIBUSI</th>
				<th class=\"th02\" colspan=2 >KAPITALISASI</th>
				<th class=\"th02\" colspan=2 >HIBAH</th>
				<th class=\"th02\" colspan=2 >PINDAH ANTAR SKPD</th>
				<th class=\"th02\" >PENILAIAN</th>
				<th class=\"th02\" >PENGHAPUSAN</th>
				<th class=\"th02\" colspan=2 >KOREKSI PEMBUKUAN </th>
				<th class=\"th02\" colspan=2 >REKLASS </th>
				
				<th class=\"th02\" colspan=2 >AKUM. PENYUSUTAN </th>
				<th class=\"th02\" colspan='3' >SALDO AKHIR $fmFiltThnBuku</th>
			</tr>
			<tr>
				<th class=\"th03\" width='100' >PEROLEHAN</th>
				<th class=\"th03\" width='100' >AKUM. PENYUSUTAN</th>
				<th class=\"th03\" >DEBET</th>				
				<th class=\"th03\" >DEBET</th>
				<th class=\"th03\" >DEBET</th>
				<th class=\"th03\" width='100' >KREDIT</th>
				<th class=\"th03\" width='100' >DEBET</th>
				<th class=\"th03\" width='100' >KREDIT</th>
				<th class=\"th03\" width='100' >DEBET</th>
				<th class=\"th03\" width='100' >KREDIT</th>
				<th class=\"th03\" width='100' >DEBET</th>
				<th class=\"th03\" width='100' >KREDIT</th>
				<th class=\"th03\" width='100' >DEBET</th>
				<th class=\"th03\" width='100' >KREDIT</th>
				<th class=\"th03\" width='100' >DEBET</th>
				<th class=\"th03\" width='100' >KREDIT</th>
				
				<th class=\"th03\" width='100' >DEBET</th>
				<th class=\"th03\" width='100' >KREDIT</th>
				
				<th class=\"th03\" width='100' >PEROLEHAN</th>
				<th class=\"th03\" width='100' >AKUM. PENYUSUTAN</th>
				<th class=\"th03\" width='100' >NILAI BUKU</th>
			</tr>				
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
		$cbxTotal = $_REQUEST['cbxTotal'];
			
		$tampilHeaderHarga = !empty($cbxDlmRibu)? 'Harga Perolehan (Ribuan)': 'Harga Perolehan';	
		$tampilDok ='';// $cetak? "" : "<th class=\"th01\" rowspan='2' width='24'></th>";
		$clGaris = $cetak? 'GarisCetak':'GarisDaftar';
				
		$c = $HTTP_COOKIE_VARS['cofmSKPD'];
		$d = $HTTP_COOKIE_VARS['cofmUNIT'];
		$e = $HTTP_COOKIE_VARS['cofmSUBUNIT'];	
		$e1 = $HTTP_COOKIE_VARS['cofmSEKSI'];
		
		$jnsrekap = $_REQUEST['jnsrekap'];
		$fmFiltThnBuku = empty($_REQUEST['fmFiltThnBuku'])? date('Y') : $_REQUEST['fmFiltThnBuku']; 
		$des = $jnsrekap==1? 2:0;

		$tglAwal="$fmFiltThnBuku-01-01";
		$tglAkhir="$fmFiltThnBuku-12-31";

				
		$arrKond = array();
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
		}
		
	
		$cskpd=0;
		$Qry = mysql_query($sqry);
		while($isi=mysql_fetch_array($Qry)){
			$cskpd++;
			if ( $cbxTotal ==TRUE){
				$KondisiSKPDx = "1=1";
				if($c!='00' && $c !='') $KondisiSKPDx .= " and c= '$c' ";
				if($d!='00' && $d !='') $KondisiSKPDx .=  $KondisiSKPDx ==''? " d= '$d' " : " and d= '$d' ";
				$paramSKPD = "&c=$c&d=$d&e=$e&e1=$e1";				
			}else{
				if ($e1=='00' || $e1=='000' ){
					$KondisiSKPDx=" c='".$isi['c']."' and d='".$isi['d']."' ";							
				} else {
					$KondisiSKPDx=" c='".$isi['c']."' and d='".$isi['d']."' and e='".$isi['e']."' and e1='".$isi['e1']."' ";					
				}
				$paramSKPD = "&c={$isi['c']}&d={$isi['d']}&e={$isi['e']}&e1={$isi['e1']}";
			}
		
			$ListData .="<tr>
				<td align=right>$cskpd.</td>
				<td ><b>{$isi['nmopd']}</b></td>
				<td align=right>&nbsp;</td>	<td align=right>&nbsp;</td>	<td align=right>&nbsp;</td>	<td align=right>&nbsp;</td>
				<td align=right>&nbsp;</td>	<td align=right>&nbsp;</td>	<td align=right>&nbsp;</td>	<td align=right>&nbsp;</td>
				<td align=right>&nbsp;</td>	<td align=right>&nbsp;</td>	<td align=right>&nbsp;</td>	<td align=right>&nbsp;</td>
				<td align=right>&nbsp;</td>	<td align=right>&nbsp;</td>	<td align=right>&nbsp;</td>	<td align=right>&nbsp;</td>
				</tr>"	;
			
			$JmlSaldoAwSKPD=0; $JmlBelanjaSKPD=0; $JmlAtribusiSKPD=0; $JmlKapitalisasiDSKPD=0; $JmlKapitalisasiKSKPD=0;
			$JmlHibahDSKPD=0; $JmlHibahKSKPD=0;	$JmlMutasiDSKPD=0; $JmlMutasiKSKPD=0; $JmlPenilaianDSKPD=0;	$JmlPenghapusanKSKPD=0;
			$JmlPembukuanDSKPD=0; $JmlPembukuanKSKPD=0; $JmlReklassDSKPD=0;	$JmlReklassKSKPD=0;	$JmlSaldoAkSKPD=0;
	
			$JmlSaldoAwTot=0; $JmlBelanjaTot=0;	$JmlAtribusiTot=0;	$JmlKapitalisasiDTot=0;	$JmlKapitalisasiKTot=0;
			$JmlHibahDTot=0; $JmlHibahKTot=0; $JmlMutasiDTot=0; $JmlMutasiKTot=0; $JmlPenilaianDTot=0; $JmlPenghapusanKTot=0;
			$JmlPembukuanDTot=0; $JmlPembukuanKTot=0; $JmlReklassDTot=0; $JmlReklassKTot=0;	$JmlSaldoAkTot=0;			
			
			//qry aset tetap ---------------------------------------------------------------------------------------	
			$bqry=
				"select aa.kint,aa.ka,aa.kb, aa.f,aa.g,aa.nm_barang ,
				(bb.debet_saldoawal_brg - bb.kredit_saldoawal_brg) as jmlbrgawal,
				(bb.debet_saldoawal - bb.kredit_saldoawal) as jmlhargaawal,
				(bb.debet_hp-bb.debet_atribusi) as debet_bmd,
				bb.debet_atribusi,bb.debet_kapitalisasi,bb.kredit_kapitalisasi,bb.debet_hibah,bb.kredit_hibah,bb.debet_mutasi,bb.kredit_mutasi,
				bb.debet_penilaian,
				(bb.kredit_penghapusan-bb.debet_penghapusan) as kredit_penghapusan,
				bb.debet_koreksi,bb.kredit_koreksi,bb.debet_reklass,bb.kredit_reklass,
				(bb.debet_saldoakhir_brg - bb.kredit_saldoakhir_brg) as jmlbrgakhir,
				(bb.debet_saldoakhir - bb.kredit_saldoakhir) as jmlhargaakhir,
				
				(bb.debet_saldoawal - bb.kredit_saldoawal+	bb.debet_hp+bb.debet_kapitalisasi-bb.kredit_kapitalisasi+bb.debet_hibah-bb.kredit_hibah+bb.debet_mutasi-bb.kredit_mutasi+
				bb.debet_penilaian-bb.kredit_penghapusan+bb.debet_koreksi-bb.kredit_koreksi+bb.debet_reklass-bb.kredit_reklass) as jmlhitakhir, 
				
				(bb.kredit_susutawal - bb.debet_susutawal) as susutawal,
				bb.debet_susut, bb.kredit_susut,
				(bb.kredit_susutawal - bb.debet_susutawal + bb.kredit_susut - bb.debet_susut)as susutakhir,
				
				( (bb.debet_saldoawal-bb.kredit_saldoawal+bb.debet_hp+bb.debet_kapitalisasi-bb.kredit_kapitalisasi+bb.debet_hibah-bb.kredit_hibah+bb.debet_mutasi-bb.kredit_mutasi+bb.debet_penilaian-bb.kredit_penghapusan+bb.debet_koreksi-bb.kredit_koreksi+bb.debet_reklass-bb.kredit_reklass)
				- (bb.kredit_susutawal-bb.debet_susutawal+bb.kredit_susut-bb.debet_susut) ) as nilai_buku
					
				
				 from v_ref_kib_keu  aa
				 left join 
				( select  IFNULL(f,'00') as f, IFNULL(g,'00') as g,
				sum(if(tgl_buku<'$tglAwal' && jns_trans<>10,jml_barang_d,0)) as debet_saldoawal_brg, 
				sum(if(tgl_buku<'$tglAwal' && jns_trans<>10,jml_barang_k,0)) as kredit_saldoawal_brg,
				sum(if(tgl_buku<'$tglAwal' && jns_trans<>10,debet,0)) as debet_saldoawal, 
				sum(if(tgl_buku<'$tglAwal' && jns_trans<>10,kredit,0)) as kredit_saldoawal,
				
				sum(if(tgl_buku<'$tglAwal' && jns_trans=10,debet,0)) as debet_susutawal, 
				sum(if(tgl_buku<'$tglAwal' && jns_trans=10,kredit,0)) as kredit_susutawal,
				
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=1 ,debet,0)) as debet_hp, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=1 ,harga_atribusi,0)) as debet_atribusi, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=3 ,debet,0)) as debet_kapitalisasi, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=3 ,kredit,0)) as kredit_kapitalisasi, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=4 ,debet,0)) as debet_hibah, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=4 ,kredit,0)) as kredit_hibah, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=5 ,debet,0)) as debet_mutasi, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=5 ,kredit,0)) as kredit_mutasi, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=6 ,debet,0)) as debet_penilaian, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=7 ,debet,0)) as debet_penghapusan,  
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=7 ,kredit,0)) as kredit_penghapusan, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=8 ,debet,0)) as debet_koreksi, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=8 ,kredit,0)) as kredit_koreksi, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=9 ,debet,0)) as debet_reklass, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=9 ,kredit,0)) as kredit_reklass, 
				
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=10 ,debet,0)) as debet_susut, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=10 ,kredit,0)) as kredit_susut, 
				
				sum(if(tgl_buku<='$tglAkhir' && jns_trans<>10,jml_barang_d,0)) as debet_saldoakhir_brg, 
				sum(if(tgl_buku<='$tglAkhir' && jns_trans<>10,jml_barang_k,0)) as kredit_saldoakhir_brg,
				sum(if(tgl_buku<='$tglAkhir' && jns_trans<>10,debet,0)) as debet_saldoakhir, 
				sum(if(tgl_buku<='$tglAkhir' && jns_trans<>10,kredit,0)) as kredit_saldoakhir,
				
				sum(if(tgl_buku<='$tglAkhir' && jns_trans=10,debet,0)) as debet_susutakhir, 
				sum(if(tgl_buku<='$tglAkhir' && jns_trans=10,kredit,0)) as kredit_susutakhir
				
				from v_jurnal_aset_tetap 
				where $KondisiSKPDx
				group by f,g with rollup
				) bb on aa.f = bb.f and aa.g=bb.g
				 where aa.ka='01' and aa.kb<>'00' "; //echo $bqry;
		
			$aQry = mysql_query($bqry);		
			while($isix=mysql_fetch_array($aQry)){
		  
				if($isix['g']=='00') $JmlSaldoAwSKPD=$JmlSaldoAwSKPD+$isix['jmlhargaawal'];	
				if($isix['g']=='00')$JmlBelanjaSKPD=$JmlBelanjaSKPD+$isix['debet_bmd'];
				if($isix['g']=='00')$JmlAtribusiSKPD=$JmlAtribusiSKPD+$isix['debet_atribusi'];
				if($isix['g']=='00')$JmlKapitalisasiDSKPD=$JmlKapitalisasiDSKPD+$isix['debet_kapitalisasi'];	
				if($isix['g']=='00')$JmlKapitalisasiKSKPD=$JmlKapitalisasiKSKPD+$isix['kredit_kapitalisasi'];
				if($isix['g']=='00')$JmlHibahDSKPD=$JmlHibahDSKPD+$isix['debet_hibah'];
				if($isix['g']=='00')$JmlHibahKSKPD=$JmlHibahKSKPD+$isix['kredit_hibah'];
				if($isix['g']=='00')$JmlMutasiDSKPD=$JmlMutasiDSKPD+$isix['debet_mutasi'];
				if($isix['g']=='00')$JmlMutasiKSKPD=$JmlMutasiKSKPD+$isix['kredit_mutasi'];
				if($isix['g']=='00')$JmlPenilaianDSKPD=$JmlPenilaianDSKPD+$isix['debet_penilaian'];
				if($isix['g']=='00')$JmlPenghapusanKSKPD=$JmlPenghapusanKSKPD+$isix['kredit_penghapusan'];
				if($isix['g']=='00')$JmlPembukuanDSKPD=$JmlPembukuanDSKPD+$isix['debet_koreksi'];
				if($isix['g']=='00')$JmlPembukuanKSKPD=$JmlPembukuanKSKPD+$isix['kredit_koreksi'];
				if($isix['g']=='00')$JmlReklassDSKPD=$JmlReklassDSKPD+$isix['debet_reklass'];
				if($isix['g']=='00')$JmlReklassKSKPD=$JmlReklassKSKPD+$isix['kredit_reklass'];
				if($isix['g']=='00')$JmlSaldoAkSKPD=$JmlSaldoAkSKPD+$isix['jmlhitakhir'];
				
				if($isix['g']=='00')$JmlSusutAk+=$isix['susutakhir'];
				if($isix['g']=='00')$JmlSusutAw+=$isix['susutawal'];
				if($isix['g']=='00')$Jmldebet_susut+=$isix['debet_susut'];
				if($isix['g']=='00')$Jmlkredit_susut+=$isix['kredit_susut'];
				if($isix['g']=='00')$JmlNilaiBuku+=$isix['nilai_buku'];
				
		
				$TampilJmlSaldoAwSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['jmlhargaawal'], 2, ',', '.').'</b>' : number_format($isix['jmlhargaawal'], 2, ',', '.');	
				$TampilJmlBelanjaSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['debet_bmd'], 2, ',', '.').'</b>' :number_format($isix['debet_bmd'], 2, ',', '.');
				$TampilJmlAtribusiSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['debet_atribusi'], 2, ',', '.').'</b>' :number_format($isix['debet_atribusi'], 2, ',', '.');
				$TampilJmlKapitalisasiDSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['debet_kapitalisasi'], 2, ',', '.').'</b>' :number_format($isix['debet_kapitalisasi'], 2, ',', '.');	
				$TampilJmlKapitalisasiKSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['kredit_kapitalisasi'], 2, ',', '.').'</b>' :number_format($isix['kredit_kapitalisasi'], 2, ',', '.');
				$TampilJmlHibahDSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['debet_hibah'], 2, ',', '.').'</b>' :number_format($isix['debet_hibah'], 2, ',', '.');
				$TampilJmlHibahKSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['kredit_hibah'], 2, ',', '.').'</b>' :number_format($isix['kredit_hibah'], 2, ',', '.');
				$TampilJmlMutasiDSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['debet_mutasi'], 2, ',', '.').'</b>' :number_format($isix['debet_mutasi'], 2, ',', '.');
				$TampilJmlMutasiKSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['kredit_mutasi'], 2, ',', '.').'</b>' :number_format($isix['kredit_mutasi'], 2, ',', '.');
				$TampilJmlPenilaianDSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['debet_penilaian'], 2, ',', '.').'</b>' :number_format($isix['debet_penilaian'], 2, ',', '.');
				$TampilJmlPenghapusanKSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['kredit_penghapusan'], 2, ',', '.').'</b>' :number_format($isix['kredit_penghapusan'], 2, ',', '.');
				$TampilJmlPembukuanDSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['debet_koreksi'], 2, ',', '.').'</b>' :number_format($isix['debet_koreksi'], 2, ',', '.');
				$TampilJmlPembukuanKSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['kredit_koreksi'], 2, ',', '.').'</b>' :number_format($isix['kredit_koreksi'], 2, ',', '.');
				$TampilJmlReklassDSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['debet_reklass'], 2, ',', '.').'</b>' :number_format($isix['debet_reklass'], 2, ',', '.');
				$TampilJmlReklassKSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['kredit_reklass'], 2, ',', '.').'</b>' :number_format($isix['kredit_reklass'], 2, ',', '.');
				$TampilJmlSaldoAkSKPD=$isix['g']=='00' ? '<b>'.number_format($isix['jmlhitakhir'], 2, ',', '.').'</b>' :number_format($isix['jmlhitakhir'], 2, ',', '.');		
				
				$TampilJmlSusutAk=$isix['g']=='00' ? '<b>'.number_format($isix['susutakhir'], 2, ',', '.').'</b>' :number_format($isix['susutakhir'], 2, ',', '.');
				$TampilJmlSusutAw=$isix['g']=='00' ? '<b>'.number_format($isix['susutawal'], 2, ',', '.').'</b>' :number_format($isix['susutawal'], 2, ',', '.');
				$TampilJmldebet_susut=$isix['g']=='00' ? '<b>'.number_format($isix['debet_susut'], 2, ',', '.').'</b>' :number_format($isix['debet_susut'], 2, ',', '.');
				$TampilJmlkredit_susut=$isix['g']=='00' ? '<b>'.number_format($isix['kredit_susut'], 2, ',', '.').'</b>' :number_format($isix['kredit_susut'], 2, ',', '.');
				$TampilJmlNilaiBuku=$isix['g']=='00' ? '<b>'.number_format($isix['nilai_buku'], 2, ',', '.').'</b>' :number_format($isix['nilai_buku'], 2, ',', '.');
				
				//tampil aset tetap -------------------------------------------------------------------
				$paramKdAkun = "&kint={$isix['kint']}&ka={$isix['ka']}&kb={$isix['kb']}";
				$tglAwal2 = ($fmFiltThnBuku-1).'-12-31';
				$hrefAw = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAwal2";
				$hrefAk = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAkhir";
				$href 	= "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl1=$tglAwal&tgl2=$tglAkhir";
				$vnmbarang = $isix['g']=='00' ?  "<b>&nbsp;&nbsp;&nbsp;{$isix['nm_barang']}</b>" : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$isix['nm_barang']}";
				$ListData .="<tr>
				<td align=right>&nbsp;</td>
				<td >$vnmbarang</td>
				<td align=right><a href='$hrefAw' target='blank_'  style='color:black;'>$TampilJmlSaldoAwSKPD</a></td>
				
				<td align=right><a href='$hrefAwSusut' target='blank_'  style='color:black;'>$TampilJmlSusutAw</a></td>
				
				<td align=right><a href='$href&jns_trans=1' target='blank_'  style='color:black;'>$TampilJmlBelanjaSKPD</a></td>
				<td align=right><a href='$href&jns_trans=2' target='blank_'  style='color:black;'>$TampilJmlAtribusiSKPD</a></td>
				<td align=right><a href='$href&jns_trans=3&debet=1' target='blank_'  style='color:black;'>$TampilJmlKapitalisasiDSKPD</a></td>
				<td align=right><a href='$href&jns_trans=3&debet=2' target='blank_'  style='color:black;'>$TampilJmlKapitalisasiKSKPD</a></td>
				<td align=right><a href='$href&jns_trans=4&debet=1' target='blank_'  style='color:black;'>$TampilJmlHibahDSKPD</a></td>
				<td align=right><a href='$href&jns_trans=4&debet=2' target='blank_'  style='color:black;'>$TampilJmlHibahKSKPD</a></td>
				<td align=right><a href='$href&jns_trans=5&debet=1' target='blank_'  style='color:black;'>$TampilJmlMutasiDSKPD</a></td>
				<td align=right><a href='$href&jns_trans=5&debet=2' target='blank_'  style='color:black;'>$TampilJmlMutasiKSKPD</a></td>
				<td align=right><a href='$href&jns_trans=6' target='blank_'  style='color:black;'>$TampilJmlPenilaianDSKPD</a></td>
				<td align=right><a href='$href&jns_trans=7&debet=2' target='blank_'  style='color:black;'>$TampilJmlPenghapusanKSKPD</a></td>
				<td align=right><a href='$href&jns_trans=8&debet=1' target='blank_'  style='color:black;'>$TampilJmlPembukuanDSKPD</a></td>
				<td align=right><a href='$href&jns_trans=8&debet=2' target='blank_'  style='color:black;'>$TampilJmlPembukuanKSKPD</a></td>
				<td align=right><a href='$href&jns_trans=9&debet=1' target='blank_'  style='color:black;'>$TampilJmlReklassDSKPD</a></td>
				<td align=right><a href='$href&jns_trans=9&debet=2' target='blank_'  style='color:black;'>$TampilJmlReklassKSKPD</a></td>
				
				<td align=right><a href='$href&jns_trans=10&debet=1' target='blank_'  style='color:black;'>$TampilJmldebet_susut</a></td>
				<td align=right><a href='$href&jns_trans=10&debet=2' target='blank_'  style='color:black;'>$TampilJmlkredit_susut</a></td>
				
				<td align=right><a href='$hrefAk' target='blank_'  style='color:black;'>$TampilJmlSaldoAkSKPD</a></td>
				<td align=right><a href='$hrefAkSusut' target='blank_'  style='color:black;'>$TampilJmlSusutAk</a></td>
				<td align=right><a href='$hrefNilaiBuku' target='blank_'  style='color:black;'>$TampilJmlNilaiBuku</a></td>
				</tr>"	;
		  
		  	}																																																									
				
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
			
			$TampilJmlSusutAk=number_format($JmlSusutAk, 2, ',', '.');
			$TampilJmlSusutAw=number_format($JmlSusutAw, 2, ',', '.');
			$TampilJmldebet_susut=number_format($Jmldebet_susut, 2, ',', '.');
			$TampilJmlkredit_susut=number_format($Jmlkredit_susut, 2, ',', '.');
			$TampilJmlNilaiBuku=number_format($JmlNilaiBuku, 2, ',', '.');
					
			
			//tampil total aset tetap --------------------------------------------------------------
			$paramKdAkun = "&kint=01&ka=01";
			$tglAwal2 = ($fmFiltThnBuku-1).'-12-31';
			$hrefAw = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAwal2";
			$hrefAk = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAkhir";
			$href 	= "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl1=$tglAwal&tgl2=$tglAkhir";
			$ListData .="<tr>
			<td align=right>&nbsp;</td>
			<td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Jumlah Aset Tetap</b></td>
			<td align=right><a href='$hrefAw' target='blank_' style='color:black'><b>$TampilJmlTotSaldoAwSKPD</b></a></td>
			<td align=right><a href='$hrefAwSusut' target='blank_'  style='color:black;'><b>$TampilJmlSusutAw</b></a></td>
			
			<td align=right><a href='$href&jns_trans=1' target='blank_' style='color:black'><b>$TampilJmlTotBelanjaSKPD</b></a></td>
			<td align=right><a href='$href&jns_trans=2' target='blank_' style='color:black'><b>$TampilJmlTotAtribusiSKPD</b></a></td>
			<td align=right><a href='$href&jns_trans=3&debet=1' target='blank_' style='color:black'><b>$TampilJmlTotKapitalisasiDSKPD</b></a></td>
			<td align=right><a href='$href&jns_trans=3&debet=2' target='blank_' style='color:black'><b>$TampilJmlTotKapitalisasiKSKPD</b></a></td>
			<td align=right><a href='$href&jns_trans=4&debet=1' target='blank_' style='color:black'><b>$TampilJmlTotHibahDSKPD</b></a></td>
			<td align=right><a href='$href&jns_trans=4&debet=2' target='blank_' style='color:black'><b>$TampilJmlTotHibahKSKPD</b></a></td>
			<td align=right><a href='$href&jns_trans=5&debet=1' target='blank_' style='color:black'><b>$TampilJmlTotMutasiDSKPD</b></a></td>
			<td align=right><a href='$href&jns_trans=5&debet=2' target='blank_' style='color:black'><b>$TampilJmlTotMutasiKSKPD</b></a></td>
			<td align=right><a href='$href&jns_trans=6' target='blank_' style='color:black'><b>$TampilJmlTotPenilaianDSKPD</b></a></td>
			<td align=right><a href='$href&jns_trans=7' target='blank_' style='color:black'><b>$TampilJmlTotPenghapusanKSKPD</b></a></td>
			<td align=right><a href='$href&jns_trans=8&debet=1' target='blank_' style='color:black'><b>$TampilJmlTotPembukuanDSKPD</b></a></td>
			<td align=right><a href='$href&jns_trans=8&debet=2' target='blank_' style='color:black'><b>$TampilJmlTotPembukuanKSKPD</b></a></td>
			<td align=right><a href='$href&jns_trans=9' target='blank_' style='color:black'><b>$TampilJmlTotReklassDSKPD</b></a></td>
			<td align=right><a href='$href&jns_trans=9' target='blank_' style='color:black'><b>$TampilJmlTotReklassKSKPD</b></a></td>
			
			<td align=right><a href='$href&jns_trans=10&debet=1' target='blank_'  style='color:black;'><b>$TampilJmldebet_susut</b></a></td>
			<td align=right><a href='$href&jns_trans=10&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlkredit_susut</b></a></td>
			
			<td align=right><a href='$hrefAk' target='blank_' style='color:black'><b>$TampilJmlTotSaldoAkSKPD</b></a></td>
			<td align=right><a href='$hrefAkSusut' target='blank_'  style='color:black;'><b>$TampilJmlSusutAk</b></a></td>
			<td align=right><a href='$hrefAkSusut' target='blank_'  style='color:black;'><b>$TampilJmlNilaiBuku</b></a></td>
			</tr>"	;
			
			$JmlSaldoAwTot=$JmlSaldoAwTot+$JmlSaldoAwSKPD;	
			$JmlBelanjaTot=$JmlBelanjaTot+$JmlBelanjaSKPD;
			$JmlAtribusiTot=$JmlAtribusiTot+$JmlAtribusiSKPD;
			$JmlKapitalisasiDTot=$JmlKapitalisasiDTot+$JmlKapitalisasiDSKPD;	
			$JmlKapitalisasiKTot=$JmlKapitalisasiKTot+$JmlKapitalisasiKSKPD;
			$JmlHibahDTot=$JmlHibahDTot+$JmlHibahDSKPD;
			$JmlHibahKTot=$JmlHibahKTot+$JmlHibahKSKPD;
			$JmlMutasiDTot=$JmlMutasiDTot+$JmlMutasiDSKPD;
			$JmlMutasiKTot=$JmlMutasiKTot+$JmlMutasiKSKPD;
			$JmlPenilaianDTot=$JmlPenilaianDTot+$JmlPenilaianDSKPD;
			$JmlPenghapusanKTot=$JmlPenghapusanKTot+$JmlPenghapusanKSKPD;
			$JmlPembukuanDTot=$JmlPembukuanDTot+$JmlPembukuanDSKPD;
			$JmlPembukuanKTot=$JmlPembukuanKTot+$JmlPembukuanKSKPD;
			$JmlReklassDTot=$JmlReklassDTot+$JmlReklassDSKPD;
			$JmlReklassKTot=$JmlReklassKTot+$JmlReklassKSKPD;
			$JmlSaldoAkTot=$JmlSaldoAkTot+$JmlSaldoAkSKPD;		
			
			$JmlSusutAkTot+=$JmlSusutAk;
			$JmlSusutAwTot+=$JmlSusutAw;
			$Jmldebet_susutTot+=$Jmldebet_susut;
			$Jmlkredit_susutTot+=$Jmlkredit_susut;
			$JmlNilaiBukuTot+=$JmlNilaiBuku;
			
			
			$JmlSaldoAwSKPD=0;	
			$JmlBelanjaSKPD=0;
			$JmlAtribusiSKPD=0;
			$JmlKapitalisasiDSKPD=0;	
			$JmlKapitalisasiKSKPD=0;
			$JmlHibahDSKPD=0;
			$JmlHibahKSKPD=0;
			$JmlMutasiDSKPD=0;
			$JmlMutasiKSKPD=0;
			$JmlPenilaianDSKPD=0;
			$JmlPenghapusanKSKPD=0;
			$JmlPembukuanDSKPD=0;
			$JmlPembukuanKSKPD=0;
			$JmlReklassDSKPD=0;
			$JmlReklassKSKPD=0;
			$JmlSaldoAkSKPD=0;
			$JmlSusutAk =0;
			$JmlSusutAw=0;
			$Jmldebet_susut=0;
			$Jmlkredit_susut=0;
			$JmlNilaiBuku =0;
			  
			//query aset lainnya --------------------------------------------- 
			$bqry="
				select aa.kint,aa.ka,aa.kb,
				aa.f,aa.g,aa.nm_barang ,(bb.debet_saldoawal_brg - bb.kredit_saldoawal_brg) as jmlbrgawal,
				(bb.debet_saldoawal - bb.kredit_saldoawal) as jmlhargaawal,
				(bb.debet_hp-bb.debet_atribusi) as debet_bmd,bb.debet_atribusi,bb.debet_kapitalisasi,bb.kredit_kapitalisasi,
				bb.debet_hibah,bb.kredit_hibah,bb.debet_mutasi,bb.kredit_mutasi,
				bb.debet_penilaian,(bb.kredit_penghapusan-bb.debet_penghapusan) as kredit_penghapusan,bb.debet_koreksi,bb.kredit_koreksi,bb.debet_reklass,bb.kredit_reklass,
				(bb.debet_saldoakhir_brg - bb.kredit_saldoakhir_brg) as jmlbrgakhir,				
				(bb.debet_saldoakhir - bb.kredit_saldoakhir) as jmlhargaakhir,
				
				(bb.debet_saldoawal-bb.kredit_saldoawal+bb.debet_hp+bb.debet_kapitalisasi-bb.kredit_kapitalisasi+bb.debet_hibah-bb.kredit_hibah+bb.debet_mutasi-bb.kredit_mutasi+
				bb.debet_penilaian-bb.kredit_penghapusan+bb.debet_koreksi-bb.kredit_koreksi+bb.debet_reklass-bb.kredit_reklass) as jmlhitakhir, 
				
				(bb.kredit_susutawal - bb.debet_susutawal) as susutawal,
				bb.debet_susut, bb.kredit_susut,
				(bb.kredit_susutawal - bb.debet_susutawal + bb.kredit_susut - bb.debet_susut)as susutakhir,
				
				( (bb.debet_saldoawal-bb.kredit_saldoawal+bb.debet_hp+bb.debet_kapitalisasi-bb.kredit_kapitalisasi+
				bb.debet_hibah-bb.kredit_hibah+bb.debet_mutasi-bb.kredit_mutasi+bb.debet_penilaian-bb.kredit_penghapusan+
				bb.debet_koreksi-bb.kredit_koreksi+bb.debet_reklass-bb.kredit_reklass)
				- (bb.kredit_susutawal-bb.debet_susutawal+bb.kredit_susut-bb.debet_susut) ) as nilai_buku
				
				
				 from v_ref_kib_keu  aa
				 left join 
				( select IFNULL(f,'00') as f, IFNULL(g,'00') as g,
				sum(if(tgl_buku<'$tglAwal',jml_barang_d,0)) as debet_saldoawal_brg, sum(if(tgl_buku<'$tglAwal',jml_barang_k,0)) as kredit_saldoawal_brg,
				sum(if(tgl_buku<'$tglAwal',debet,0)) as debet_saldoawal, 
				sum(if(tgl_buku<'$tglAwal',kredit,0)) as kredit_saldoawal,
				sum(if(tgl_buku<'$tglAwal' && jns_trans=10,debet,0)) as debet_susutawal, 
				sum(if(tgl_buku<'$tglAwal' && jns_trans=10,kredit,0)) as kredit_susutawal,
				
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=1 ,debet,0)) as debet_hp, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=1 ,harga_atribusi,0)) as debet_atribusi, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=3 ,debet,0)) as debet_kapitalisasi, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=3 ,kredit,0)) as kredit_kapitalisasi, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=4 ,debet,0)) as debet_hibah, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=4 ,kredit,0)) as kredit_hibah, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=5 ,debet,0)) as debet_mutasi, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=5 ,kredit,0)) as kredit_mutasi, 
				#sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=6 ,kredit,0)) as debet_penilaian,
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=6 ,debet,0)) as debet_penilaian,
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=7 ,debet,0)) as debet_penghapusan,  
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=7 ,kredit,0)) as kredit_penghapusan, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=8 ,debet,0)) as debet_koreksi, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=8 ,kredit,0)) as kredit_koreksi, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=9 ,debet,0)) as debet_reklass, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=9 ,kredit,0)) as kredit_reklass, 
				sum(if(tgl_buku<='$tglAkhir',jml_barang_d,0)) as debet_saldoakhir_brg, sum(if(tgl_buku<='$tglAkhir',jml_barang_k,0)) as kredit_saldoakhir_brg,
				sum(if(tgl_buku<='$tglAkhir',debet,0)) as debet_saldoakhir, sum(if(tgl_buku<='$tglAkhir',kredit,0)) as kredit_saldoakhir,
				
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=10 ,debet,0)) as debet_susut, 
				sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=10 ,kredit,0)) as kredit_susut, 
				
				sum(if(tgl_buku<='$tglAkhir' && jns_trans=10,debet,0)) as debet_susutakhir, 
				sum(if(tgl_buku<='$tglAkhir' && jns_trans=10,kredit,0)) as kredit_susutakhir
								
				from v_jurnal_aset_lainnya 
				where $KondisiSKPDx
				group by f,g
				) bb on aa.f = bb.f	and aa.g = bb.g 
		 		where ka='02' and kb<>'00' ";
		 
			$aQry = mysql_query($bqry);
			while($isix=mysql_fetch_array($aQry)){
				$JmlSaldoAwSKPD=$JmlSaldoAwSKPD+$isix['jmlhargaawal'];	
				$JmlBelanjaSKPD=$JmlBelanjaSKPD+$isix['debet_bmd'];
				$JmlAtribusiSKPD=$JmlAtribusiSKPD+$isix['debet_atribusi'];
				$JmlKapitalisasiDSKPD=$JmlKapitalisasiDSKPD+$isix['debet_kapitalisasi'];	
				$JmlKapitalisasiKSKPD=$JmlKapitalisasiKSKPD+$isix['kredit_kapitalisasi'];
				$JmlHibahDSKPD=$JmlHibahDSKPD+$isix['debet_hibah'];
				$JmlHibahKSKPD=$JmlHibahKSKPD+$isix['kredit_hibah'];
				$JmlMutasiDSKPD=$JmlMutasiDSKPD+$isix['debet_mutasi'];
				$JmlMutasiKSKPD=$JmlMutasiKSKPD+$isix['kredit_mutasi'];
				$JmlPenilaianDSKPD=$JmlPenilaianDSKPD+$isix['debet_penilaian'];
				$JmlPenghapusanKSKPD=$JmlPenghapusanKSKPD+$isix['kredit_penghapusan'];
				$JmlPembukuanDSKPD=$JmlPembukuanDSKPD+$isix['debet_koreksi'];
				$JmlPembukuanKSKPD=$JmlPembukuanKSKPD+$isix['kredit_koreksi'];
				$JmlReklassDSKPD=$JmlReklassDSKPD+$isix['debet_reklass'];
				$JmlReklassKSKPD=$JmlReklassKSKPD+$isix['kredit_reklass'];
				$JmlSaldoAkSKPD=$JmlSaldoAkSKPD+$isix['jmlhitakhir'];	 
				
				$JmlSusutAk+=$isix['susutakhir'];
				$JmlSusutAw+=$isix['susutawal'];
				$Jmldebet_susut+=$isix['debet_susut'];
				$Jmlkredit_susut+=$isix['kredit_susut']; 
				$JmlNilaiBuku+=$isix['nilai_buku']; 
		
				$TampilJmlSaldoAwSKPD=number_format($isix['jmlhargaawal'], 2, ',', '.');	
				$TampilJmlBelanjaSKPD=number_format($isix['debet_bmd'], 2, ',', '.');
				$TampilJmlAtribusiSKPD=number_format($isix['debet_atribusi'], 2, ',', '.');
				$TampilJmlKapitalisasiDSKPD=number_format($isix['debet_kapitalisasi'], 2, ',', '.');	
				$TampilJmlKapitalisasiKSKPD=number_format($isix['kredit_kapitalisasi'], 2, ',', '.');
				$TampilJmlHibahDSKPD=number_format($isix['debet_hibah'], 2, ',', '.');
				$TampilJmlHibahKSKPD=number_format($isix['kredit_hibah'], 2, ',', '.');
				$TampilJmlMutasiDSKPD=number_format($isix['debet_mutasi'], 2, ',', '.');
				$TampilJmlMutasiKSKPD=number_format($isix['kredit_mutasi'], 2, ',', '.');
				$TampilJmlPenilaianDSKPD=number_format($isix['debet_penilaian'], 2, ',', '.');
				$TampilJmlPenghapusanKSKPD=number_format($isix['kredit_penghapusan'], 2, ',', '.');
				$TampilJmlPembukuanDSKPD=number_format($isix['debet_koreksi'], 2, ',', '.');
				$TampilJmlPembukuanKSKPD=number_format($isix['kredit_koreksi'], 2, ',', '.');
				$TampilJmlReklassDSKPD=number_format($isix['debet_reklass'], 2, ',', '.');
				$TampilJmlReklassKSKPD=number_format($isix['kredit_reklass'], 2, ',', '.');
				$TampilJmlSaldoAkSKPD=number_format($isix['jmlhitakhir'], 2, ',', '.');		
				
				$TampilJmlSusutAk=number_format($isix['susutakhir'], 2, ',', '.');		
				$TampilJmlSusutAw=number_format($isix['susutawal'], 2, ',', '.');		
				$TampilJmldebet_susut=number_format($isix['debet_susut'], 2, ',', '.');		
				$TampilJmlkredit_susut=number_format($isix['kredit_susut'], 2, ',', '.');		
				$TampilJmlNilaiBuku=number_format($isix['nilai_buku'], 2, ',', '.');		
				
				//tampil aset lainnya ---------------------------------------------------------------------
				$paramKdAkun = "&kint={$isix['kint']}&ka={$isix['ka']}&kb={$isix['kb']}";
				$tglAwal2 = ($fmFiltThnBuku-1).'-12-31';
				$hrefAw = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAwal2";
				$hrefAw = "<a href='$hrefAw' target='blank_'  style='color:black;'>";
				$hrefAk = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAkhir";
				$hrefAk = "<a href='$hrefAk' target='blank_'  style='color:black;'>";
				$href 	= "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl1=$tglAwal&tgl2=$tglAkhir";
				$ListData .=
					"<tr>
					<td align=right>&nbsp;</td>
					<td >&nbsp;&nbsp;&nbsp;{$isix['nm_barang']}</td>
					<td align=right>$hrefAw$TampilJmlSaldoAwSKPD</a></td>					
					<td align=right><a href='$hrefAwSusut' target='blank_'  style='color:black;'>$TampilJmlSusutAw</a></td>
					
					<td align=right><a href='$href&jns_trans=1' target='blank_'  style='color:black;'>$TampilJmlBelanjaSKPD</a></td>
					<td align=right><a href='$href&jns_trans=2' target='blank_'  style='color:black;'>$TampilJmlAtribusiSKPD</a></td>
					<td align=right><a href='$href&jns_trans=3&debet=1' target='blank_'  style='color:black;'>$TampilJmlKapitalisasiDSKPD</a></td>
					<td align=right><a href='$href&jns_trans=3&debet=2' target='blank_'  style='color:black;'>$TampilJmlKapitalisasiKSKPD</a></td>
					<td align=right><a href='$href&jns_trans=4&debet=1' target='blank_'  style='color:black;'>$TampilJmlHibahDSKPD</a></td>
					<td align=right><a href='$href&jns_trans=4&debet=2' target='blank_'  style='color:black;'>$TampilJmlHibahKSKPD</a></td>
					<td align=right><a href='$href&jns_trans=5&debet=1' target='blank_'  style='color:black;'>$TampilJmlMutasiDSKPD</a></td>
					<td align=right><a href='$href&jns_trans=5&debet=2' target='blank_'  style='color:black;'>$TampilJmlMutasiKSKPD</a></td>
					<td align=right><a href='$href&jns_trans=6' target='blank_'  style='color:black;'>$TampilJmlPenilaianDSKPD</a></td>
					<td align=right><a href='$href&jns_trans=7' target='blank_'  style='color:black;'>$TampilJmlPenghapusanKSKPD</a></td>
					<td align=right><a href='$href&jns_trans=8&debet=1' target='blank_'  style='color:black;'>$TampilJmlPembukuanDSKPD</a></td>
					<td align=right><a href='$href&jns_trans=8&debet=2' target='blank_'  style='color:black;'>$TampilJmlPembukuanKSKPD</a></td>
					<td align=right><a href='$href&jns_trans=9&debet=1' target='blank_'  style='color:black;'>$TampilJmlReklassDSKPD</a></td>
					<td align=right><a href='$href&jns_trans=9&debet=2' target='blank_'  style='color:black;'>$TampilJmlReklassKSKPD</a></td>
					
					<td align=right><a href='$href&jns_trans=10&debet=1' target='blank_'  style='color:black;'>$TampilJmldebet_susut</a></td>
					<td align=right><a href='$href&jns_trans=10&debet=2' target='blank_'  style='color:black;'>$TampilJmlkredit_susut</a></td>
					
					<td align=right>$hrefAk$TampilJmlSaldoAkSKPD</a></td>
					<td align=right><a href='$hrefAkSusut' target='blank_'  style='color:black;'>$TampilJmlSusutAk</a></td>
					<td align=right><a href='$hrefAkSusut' target='blank_'  style='color:black;'>$TampilJmlNilaiBuku</a></td>
					</tr>"	;
	  		}																																																												 
		  
		  	//tampil total aset lainnnya ---------------------------------------------------	
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
			
			$TampilJmlSusutAk=number_format($JmlSusutAk, 2, ',', '.');
			$TampilJmlSusutAw=number_format($JmlSusutAw, 2, ',', '.');
			$TampilJmldebet_susut=number_format($Jmldebet_susut, 2, ',', '.');
			$TampilJmlkredit_susut=number_format($Jmlkredit_susut, 2, ',', '.');
			$TampilJmlNilaiBuku=number_format($JmlNilaiBuku, 2, ',', '.');
								
			$paramKdAkun = "&kint=01&ka=02";
			$tglAwal2 = ($fmFiltThnBuku-1).'-12-31';
			$hrefAw = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAwal2";
			$hrefAw = "<a href='$hrefAw' target='blank_'  style='color:black;'>";
			$hrefAk = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAkhir";
			$hrefAk = "<a href='$hrefAk' target='blank_'  style='color:black;'>";
			$href 	= "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl1=$tglAwal&tgl2=$tglAkhir";
			$ListData .="<tr>
				<td align=right>&nbsp;</td>
				<td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Jumlah Aset Lainnya</b></td>
				<td align=right>$hrefAw<b>$TampilJmlTotSaldoAwSKPD</b></a></td>
				<td align=right><a href='$hrefAwSusut' target='blank_'  style='color:black;'><b>$TampilJmlSusutAw</b></a></td>
				
				<td align=right><a href='$href&jns_trans=1' target='blank_'  style='color:black;'><b>$TampilJmlTotBelanjaSKPD</b></a></td>
				<td align=right><a href='$href&jns_trans=1' target='blank_'  style='color:black;'><b>$TampilJmlTotAtribusiSKPD</b></a></td>
				<td align=right><a href='$href&jns_trans=3&debet=1' target='blank_'  style='color:black;'><b>$TampilJmlTotKapitalisasiDSKPD</b></a></td>
				<td align=right><a href='$href&jns_trans=3&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlTotKapitalisasiKSKPD</b></a></td>
				<td align=right><a href='$href&jns_trans=4&debet=1' target='blank_'  style='color:black;'><b>$TampilJmlTotHibahDSKPD</b></a></td>
				<td align=right><a href='$href&jns_trans=4&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlTotHibahKSKPD</b></a></td>
				<td align=right><a href='$href&jns_trans=5&debet=1' target='blank_'  style='color:black;'><b>$TampilJmlTotMutasiDSKPD</b></a></td>
				<td align=right><a href='$href&jns_trans=5&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlTotMutasiKSKPD</b></a></td>
				<td align=right><a href='$href&jns_trans=6' target='blank_'  style='color:black;'><b>$TampilJmlTotPenilaianDSKPD</b></a></td>
				<td align=right><a href='$href&jns_trans=7' target='blank_'  style='color:black;'><b>$TampilJmlTotPenghapusanKSKPD</b></a></td>
				<td align=right><a href='$href&jns_trans=8&debet=1' target='blank_'  style='color:black;'><b>$TampilJmlTotPembukuanDSKPD</b></a></td>
				<td align=right><a href='$href&jns_trans=8&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlTotPembukuanKSKPD</b></a></td>
				<td align=right><a href='$href&jns_trans=9&debet=1' target='blank_'  style='color:black;'><b>$TampilJmlTotReklassDSKPD</b></a></td>
				<td align=right><a href='$href&jns_trans=9&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlTotReklassKSKPD</b></a></td>
				
				<td align=right><a href='$href&jns_trans=10&debet=1' target='blank_'  style='color:black;'><b>$TampilJmldebet_susut</b></a></td>
				<td align=right><a href='$href&jns_trans=10&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlkredit_susut</b></a></td>
					
				
				<td align=right>$hrefA<b>$TampilJmlTotSaldoAkSKPD</b></a></td>
				<td align=right><a href='$hrefAkSusut' target='blank_'  style='color:black;'><b>$TampilJmlSusutAk</b></a></td>
				<td align=right><a href='$hrefAkSusut' target='blank_'  style='color:black;'><b>$TampilJmlNilaiBuku</b></a></td>
				</tr>"	;	  
		
		
		//tampil total aset (aset tetap + aset lainnya ) --------------------------------------------
			$JmlSaldoAwTot=$JmlSaldoAwTot+$JmlSaldoAwSKPD;	
			$JmlBelanjaTot=$JmlBelanjaTot+$JmlBelanjaSKPD;
			$JmlAtribusiTot=$JmlAtribusiTot+$JmlAtribusiSKPD;
			$JmlKapitalisasiDTot=$JmlKapitalisasiDTot+$JmlKapitalisasiDSKPD;	
			$JmlKapitalisasiKTot=$JmlKapitalisasiKTot+$JmlKapitalisasiKSKPD;
			$JmlHibahDTot=$JmlHibahDTot+$JmlHibahDSKPD;
			$JmlHibahKTot=$JmlHibahKTot+$JmlHibahKSKPD;
			$JmlMutasiDTot=$JmlMutasiDTot+$JmlMutasiDSKPD;
			$JmlMutasiKTot=$JmlMutasiKTot+$JmlMutasiKSKPD;
			$JmlPenilaianDTot=$JmlPenilaianDTot+$JmlPenilaianDSKPD;
			$JmlPenghapusanKTot=$JmlPenghapusanKTot+$JmlPenghapusanKSKPD;
			$JmlPembukuanDTot=$JmlPembukuanDTot+$JmlPembukuanDSKPD;
			$JmlPembukuanKTot=$JmlPembukuanKTot+$JmlPembukuanKSKPD;
			$JmlReklassDTot=$JmlReklassDTot+$JmlReklassDSKPD;
			$JmlReklassKTot=$JmlReklassKTot+$JmlReklassKSKPD;
			$JmlSaldoAkTot=$JmlSaldoAkTot+$JmlSaldoAkSKPD;
			
			$JmlSusutAkTot+=$JmlSusutAk;
			$JmlSusutAwTot+=$JmlSusutAw;
			$Jmldebet_susutTot+=$Jmldebet_susut;
			$Jmlkredit_susutTot+=$Jmlkredit_susut;
			$JmlNilaiBukuTot+=$JmlNilaiBuku;
			
			$JmlSaldoAwTotx=$JmlSaldoAwTotx+$JmlSaldoAwTot;	
			$JmlBelanjaTotx=$JmlBelanjaTotx+$JmlBelanjaTot;
			$JmlAtribusiTotx=$JmlAtribusiTotx+$JmlAtribusiTot;
			$JmlKapitalisasiDTotx=$JmlKapitalisasiDTotx+$JmlKapitalisasiDTot;	
			$JmlKapitalisasiKTotx=$JmlKapitalisasiKTotx+$JmlKapitalisasiKTot;
			$JmlHibahDTotx=$JmlHibahDTotx+$JmlHibahDTot;
			$JmlHibahKTotx=$JmlHibahKTotx+$JmlHibahKTot;
			$JmlMutasiDTotx=$JmlMutasiDTotx+$JmlMutasiDTot;
			$JmlMutasiKTotx=$JmlMutasiKTotx+$JmlMutasiKTot;
			$JmlPenilaianDTotx=$JmlPenilaianDTotx+$JmlPenilaianDTot;
			$JmlPenghapusanKTotx=$JmlPenghapusanKTotx+$JmlPenghapusanKTot;
			$JmlPembukuanDTotx=$JmlPembukuanDTotx+$JmlPembukuanDTot;
			$JmlPembukuanKTotx=$JmlPembukuanKTotx+$JmlPembukuanKTot;
			$JmlReklassDTotx=$JmlReklassDTotx+$JmlReklassDTot;
			$JmlReklassKTotx=$JmlReklassKTotx+$JmlReklassKTot;
			$JmlSaldoAkTotx=$JmlSaldoAkTotx+$JmlSaldoAkTot;	
			
			$JmlSusutAkTotx+=$JmlSusutAk;
			$JmlSusutAwTotx+=$JmlSusutAw;
			$Jmldebet_susutTotx+=$Jmldebet_susut;
			$Jmlkredit_susutTotx+=$Jmlkredit_susut;			
			$JmlNilaiBukuTotx+=$JmlNilaiBuku;			
			
	
			$TampilJmlSaldoAwTot=number_format($JmlSaldoAwTot, 2, ',', '.');	
			$TampilJmlBelanjaTot=number_format($JmlBelanjaTot, 2, ',', '.');
			$TampilJmlAtribusiTot=number_format($JmlAtribusiTot, 2, ',', '.');
			$TampilJmlKapitalisasiDTot=number_format($JmlKapitalisasiDTot, 2, ',', '.');	
			$TampilJmlKapitalisasiKTot=number_format($JmlKapitalisasiKTot, 2, ',', '.');
			$TampilJmlHibahDTot=number_format($JmlHibahDTot, 2, ',', '.');
			$TampilJmlHibahKTot=number_format($JmlHibahKTot, 2, ',', '.');
			$TampilJmlMutasiDTot=number_format($JmlMutasiDTot, 2, ',', '.');
			$TampilJmlMutasiKTot=number_format($JmlMutasiKTot, 2, ',', '.');
			$TampilJmlPenilaianDTot=number_format($JmlPenilaianDTot, 2, ',', '.');
			$TampilJmlPenghapusanKTot=number_format($JmlPenghapusanKTot, 2, ',', '.');
			$TampilJmlPembukuanDTot=number_format($JmlPembukuanDTot, 2, ',', '.');
			$TampilJmlPembukuanKTot=number_format($JmlPembukuanKTot, 2, ',', '.');
			$TampilJmlReklassDTot=number_format($JmlReklassDTot, 2, ',', '.');
			$TampilJmlReklassKTot=number_format($JmlReklassKTot, 2, ',', '.');
			$TampilJmlSaldoAkTot=number_format($JmlSaldoAkTot, 2, ',', '.');	
			
			$TampilJmlSusutAkTot=number_format($JmlSusutAkTot, 2, ',', '.');
			$TampilJmlSusutAwTot=number_format($JmlSusutAwTot, 2, ',', '.');
			$TampilJmldebet_susutTot=number_format($Jmldebet_susutTot, 2, ',', '.');
			$TampilJmlkredit_susutTot=number_format($Jmlkredit_susutTot, 2, ',', '.');
			$TampilJmlNilaiBukuTot=number_format($JmlNilaiBukuTot, 2, ',', '.');
						
			$paramKdAkun = "&kint=01";
			$tglAwal2 = ($fmFiltThnBuku-1).'-12-31';
			$hrefAw = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAwal2";
			$hrefAw = "<a href='$hrefAw' target='blank_'  style='color:black;'>";
			$hrefAk = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAkhir";
			$hrefAk = "<a href='$hrefAk' target='blank_'  style='color:black;'>";
			$href 	= "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl1=$tglAwal&tgl2=$tglAkhir";
			$ListData .="<tr>
				<td align=right>&nbsp;</td>
				<td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Jumlah Aset</b></td>
				<td align=right>$hrefAw<b>$TampilJmlSaldoAwTot</b></a></td>
				<td align=right><a href='$hrefAwSusut' target='blank_'  style='color:black;'><b>$TampilJmlSusutAwTot</b></a></td>
				
				<td align=right><a href='$href&jns_trans=1' target='blank_' style='color:black;'><b>$TampilJmlBelanjaTot</b></a></td>
				<td align=right><a href='$href&jns_trans=1' target='blank_' style='color:black;'><b>$TampilJmlAtribusiTot</b></a></td>
				<td align=right><a href='$href&jns_trans=3&debet=1' target='blank_' style='color:black;'><b>$TampilJmlKapitalisasiDTot</b></a></td>
				<td align=right><a href='$href&jns_trans=3&debet=2' target='blank_' style='color:black;'><b>$TampilJmlKapitalisasiKTot</b></a></td>
				<td align=right><a href='$href&jns_trans=4&debet=1' target='blank_' style='color:black;'><b>$TampilJmlHibahDTot</b></a></td>
				<td align=right><a href='$href&jns_trans=4&debet=2' target='blank_' style='color:black;'><b>$TampilJmlHibahKTot</b></a></td>
				<td align=right><a href='$href&jns_trans=5&debet=1' target='blank_' style='color:black;'><b>$TampilJmlMutasiDTot</b></a></td>
				<td align=right><a href='$href&jns_trans=5&debet=2' target='blank_' style='color:black;'><b>$TampilJmlMutasiKTot</b></a></td>
				<td align=right><a href='$href&jns_trans=6' target='blank_' style='color:black;'><b>$TampilJmlPenilaianDTot</b></a></td>
				<td align=right><a href='$href&jns_trans=7' target='blank_' style='color:black;'><b>$TampilJmlPenghapusanKTot</b></a></td>
				<td align=right><a href='$href&jns_trans=8&debet=1' target='blank_' style='color:black;'><b>$TampilJmlPembukuanDTot</b></a></td>
				<td align=right><a href='$href&jns_trans=8&debet=2' target='blank_' style='color:black;'><b>$TampilJmlPembukuanKTot</b></a></td>
				<td align=right><a href='$href&jns_trans=9&debet=1' target='blank_' style='color:black;'><b>$TampilJmlReklassDTot</b></a></td>
				<td align=right><a href='$href&jns_trans=9&debet=2' target='blank_' style='color:black;'><b>$TampilJmlReklassKTot</b></a></td>
				
				<td align=right><a href='$href&jns_trans=10&debet=1' target='blank_'  style='color:black;'><b>$TampilJmldebet_susutTot</b></a></td>
				<td align=right><a href='$href&jns_trans=10&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlkredit_susutTot</b></a></td>
								
				<td align=right>$hrefAk<b>$TampilJmlSaldoAkTot</b></a></td>
				<td align=right><a href='$hrefAkSusut' target='blank_'  style='color:black;'><b>$TampilJmlSusutAkTot</b></a></td>
				<td align=right><a href='$hrefAkSusut' target='blank_'  style='color:black;'><b>$TampilJmlNilaiBukuTot</b></a></td>
				</tr>"	;
	
			$JmlSaldoAwEkstra=0; $JmlBelanjaEkstra=0; $JmlAtribusiEkstra=0;	$JmlKapitalisasiDEkstra=0; $JmlKapitalisasiKEkstra=0;
			$JmlHibahDEkstra=0; $JmlHibahKEkstra=0;	$JmlMutasiDEkstra=0; $JmlMutasiKEkstra=0; $JmlPenilaianDEkstra=0;
			$JmlPenghapusanKEkstra=0; $JmlPembukuanDEkstra=0; $JmlPembukuanKEkstra=0; $JmlReklassDEkstra=0;	$JmlReklassKEkstra=0;
			$JmlSaldoAkEkstra=0; 
			$JmlSusutAk=0; $JmlSusutAw = 0; $Jmldebet_susut=0; $Jmlkredit_susut=0;
								 
		  	//query aset extrakomptable ------------------------------------------------------
			$bqry="
				select 
				aa.f,aa.g,aa.nm_barang ,(bb.debet_saldoawal_brg - bb.kredit_saldoawal_brg) as jmlbrgawal,(bb.debet_saldoawal - bb.kredit_saldoawal) as jmlhargaawal,
				(bb.debet_hp-bb.debet_atribusi) as debet_bmd,bb.debet_atribusi,bb.debet_kapitalisasi,bb.kredit_kapitalisasi,bb.debet_hibah,bb.kredit_hibah,bb.debet_mutasi,bb.kredit_mutasi,
				bb.debet_penilaian,(bb.kredit_penghapusan-bb.debet_penghapusan) as kredit_penghapusan,bb.debet_koreksi,bb.kredit_koreksi,bb.debet_reklass,bb.kredit_reklass,
				(bb.debet_saldoakhir_brg - bb.kredit_saldoakhir_brg) as jmlbrgakhir,(bb.debet_saldoakhir - bb.kredit_saldoakhir) as jmlhargaakhir,
				(bb.debet_saldoawal - bb.kredit_saldoawal+bb.debet_hp+bb.debet_kapitalisasi-bb.kredit_kapitalisasi+bb.debet_hibah-bb.kredit_hibah+bb.debet_mutasi-bb.kredit_mutasi+
				bb.debet_penilaian-bb.kredit_penghapusan+bb.debet_koreksi-bb.kredit_koreksi+bb.debet_reklass-bb.kredit_reklass) as jmlhitakhir,
				
				(bb.kredit_susutawal - bb.debet_susutawal) as susutawal,
				bb.debet_susut, bb.kredit_susut,
				(bb.kredit_susutawal - bb.debet_susutawal + bb.kredit_susut - bb.debet_susut)as susutakhir,
				
				( (bb.debet_saldoawal-bb.kredit_saldoawal+bb.debet_hp+bb.debet_kapitalisasi-bb.kredit_kapitalisasi+
				bb.debet_hibah-bb.kredit_hibah+bb.debet_mutasi-bb.kredit_mutasi+bb.debet_penilaian-bb.kredit_penghapusan+
				bb.debet_koreksi-bb.kredit_koreksi+bb.debet_reklass-bb.kredit_reklass)
				- (bb.kredit_susutawal-bb.debet_susutawal+bb.kredit_susut-bb.debet_susut) ) as nilai_buku
				
				from v_ref_kib_keu  aa
				left join 
				( select 
					sum(if(tgl_buku<'$tglAwal',jml_barang_d,0)) as debet_saldoawal_brg, sum(if(tgl_buku<'$tglAwal',jml_barang_k,0)) as kredit_saldoawal_brg,
					sum(if(tgl_buku<'$tglAwal',debet,0)) as debet_saldoawal, sum(if(tgl_buku<'$tglAwal',kredit,0)) as kredit_saldoawal,
					
					sum(if(tgl_buku<'$tglAwal' && jns_trans=10,debet,0)) as debet_susutawal, 
					sum(if(tgl_buku<'$tglAwal' && jns_trans=10,kredit,0)) as kredit_susutawal,
									
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=1 ,debet,0)) as debet_hp, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=1 ,harga_atribusi,0)) as debet_atribusi, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=3 ,debet,0)) as debet_kapitalisasi, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=3 ,kredit,0)) as kredit_kapitalisasi, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=4 ,debet,0)) as debet_hibah, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=4 ,kredit,0)) as kredit_hibah, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=5 ,debet,0)) as debet_mutasi, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=5 ,kredit,0)) as kredit_mutasi, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=6 ,debet,0)) as debet_penilaian, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=7 ,debet,0)) as debet_penghapusan,  
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=7 ,kredit,0)) as kredit_penghapusan, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=8 ,debet,0)) as debet_koreksi, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=8 ,kredit,0)) as kredit_koreksi, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=9 ,debet,0)) as debet_reklass, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=9 ,kredit,0)) as kredit_reklass, 
					sum(if(tgl_buku<='$tglAkhir',jml_barang_d,0)) as debet_saldoakhir_brg, 
					sum(if(tgl_buku<='$tglAkhir',jml_barang_k,0)) as kredit_saldoakhir_brg,
					sum(if(tgl_buku<='$tglAkhir',debet,0)) as debet_saldoakhir, 
					sum(if(tgl_buku<='$tglAkhir',kredit,0)) as kredit_saldoakhir,
					
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=10 ,debet,0)) as debet_susut, 
					sum(if(tgl_buku<='$tglAkhir' && tgl_buku>='$tglAwal' && jns_trans=10 ,kredit,0)) as kredit_susut, 
				
					sum(if(tgl_buku<='$tglAkhir' && jns_trans=10,debet,0)) as debet_susutakhir, 
					sum(if(tgl_buku<='$tglAkhir' && jns_trans=10,kredit,0)) as kredit_susutakhir
													
					from v_jurnal_aset_ekstra 
					where $KondisiSKPDx			
				) bb on aa.kint = '02'
			 
			 	where kint='02' "; //echo $bqry;
		 
			$aQry = mysql_query($bqry);
			while($isix=mysql_fetch_array($aQry)){
			
				$JmlSaldoAwEkstra=$JmlSaldoAwEkstra+$isix['jmlhargaawal'];	
				$JmlBelanjaEkstra=$JmlBelanjaEkstra+$isix['debet_bmd'];
				$JmlAtribusiEkstra=$JmlAtribusiEkstra+$isix['debet_atribusi'];
				$JmlKapitalisasiDEkstra=$JmlKapitalisasiDEkstra+$isix['debet_kapitalisasi'];	
				$JmlKapitalisasiKEkstra=$JmlKapitalisasiKEkstra+$isix['kredit_kapitalisasi'];
				$JmlHibahDEkstra=$JmlHibahDEkstra+$isix['debet_hibah'];
				$JmlHibahKEkstra=$JmlHibahKEkstra+$isix['kredit_hibah'];
				$JmlMutasiDEkstra=$JmlMutasiDEkstra+$isix['debet_mutasi'];
				$JmlMutasiKEkstra=$JmlMutasiKEkstra+$isix['kredit_mutasi'];
				$JmlPenilaianDEkstra=$JmlPenilaianDEkstra+$isix['debet_penilaian'];
				$JmlPenghapusanKEkstra=$JmlPenghapusanKEkstra+$isix['kredit_penghapusan'];
				$JmlPembukuanDEkstra=$JmlPembukuanDEkstra+$isix['debet_koreksi'];
				$JmlPembukuanKEkstra=$JmlPembukuanKEkstra+$isix['kredit_koreksi'];
				$JmlReklassDEkstra=$JmlReklassDEkstra+$isix['debet_reklass'];
				$JmlReklassKEkstra=$JmlReklassKEkstra+$isix['kredit_reklass'];
				$JmlSaldoAkEkstra=$JmlSaldoAkEkstra+$isix['jmlhitakhir'];	 
				
				$JmlSusutAkEkstra+=$isix['susutakhir'];  
				$JmlSusutAwEksra +=$isix['susutawal']; 
				$Jmldebet_susutEkstra+=$isix['debet_susut']; 
				$Jmlkredit_susutEkstra+=$isix['kredit_susut']; 
				$JmlNilaiBukuEkstra+=$isix['nilai_buku']; 
		
				$TampilJmlSaldoAwEkstra=number_format($isix['jmlhargaawal'], 2, ',', '.');	
				$TampilJmlBelanjaEkstra=number_format($isix['debet_bmd'], 2, ',', '.');
				$TampilJmlAtribusiEkstra=number_format($isix['debet_atribusi'], 2, ',', '.');
				$TampilJmlKapitalisasiDEkstra=number_format($isix['debet_kapitalisasi'], 2, ',', '.');	
				$TampilJmlKapitalisasiKEkstra=number_format($isix['kredit_kapitalisasi'], 2, ',', '.');
				$TampilJmlHibahDEkstra=number_format($isix['debet_hibah'], 2, ',', '.');
				$TampilJmlHibahKEkstra=number_format($isix['kredit_hibah'], 2, ',', '.');
				$TampilJmlMutasiDEkstra=number_format($isix['debet_mutasi'], 2, ',', '.');
				$TampilJmlMutasiKEkstra=number_format($isix['kredit_mutasi'], 2, ',', '.');
				$TampilJmlPenilaianDEkstra=number_format($isix['debet_penilaian'], 2, ',', '.');
				$TampilJmlPenghapusanKEkstra=number_format($isix['kredit_penghapusan'], 2, ',', '.');
				$TampilJmlPembukuanDEkstra=number_format($isix['debet_koreksi'], 2, ',', '.');
				$TampilJmlPembukuanKEkstra=number_format($isix['kredit_koreksi'], 2, ',', '.');
				$TampilJmlReklassDEkstra=number_format($isix['debet_reklass'], 2, ',', '.');
				$TampilJmlReklassKEkstra=number_format($isix['kredit_reklass'], 2, ',', '.');
				$TampilJmlSaldoAkEkstra=number_format($isix['jmlhitakhir'], 2, ',', '.');	
				
				$TampilJmlSusutAkEkstra=number_format($isix['susutakhir'], 2, ',', '.');	
				$TampilJmlSusutAwEksra=number_format($isix['susutawal'], 2, ',', '.');	
				$TampilJmldebet_susutEkstra=number_format($isix['debet_susut'], 2, ',', '.');	
				$TampilJmlkredit_susutEkstra=number_format($isix['kredit_susut'], 2, ',', '.');	
				$TampilJmlNilaiBukuEkstra=number_format($isix['nilai_buku'], 2, ',', '.');	
				
			}	 
		  
	
			$TampilJmlTotSaldoAwEkstra=number_format($JmlSaldoAwEkstra, 2, ',', '.');
			$TampilJmlTotBelanjaEkstra=number_format($JmlBelanjaEkstra, 2, ',', '.');
			$TampilJmlTotAtribusiEkstra=number_format($JmlAtribusiEkstra, 2, ',', '.');
			$TampilJmlTotKapitalisasiDEkstra=number_format($JmlKapitalisasiDEkstra, 2, ',', '.');
			$TampilJmlTotKapitalisasiKEkstra=number_format($JmlKapitalisasiKEkstra, 2, ',', '.');
			$TampilJmlTotHibahDEkstra=number_format($JmlHibahDEkstra, 2, ',', '.');
			$TampilJmlTotHibahKEkstra=number_format($JmlHibahKEkstra, 2, ',', '.');
			$TampilJmlTotMutasiDEkstra=number_format($JmlMutasiDEkstra, 2, ',', '.');
			$TampilJmlTotMutasiKEkstra=number_format($JmlMutasiKEkstra, 2, ',', '.');
			$TampilJmlTotPenilaianDEkstra=number_format($JmlPenilaianDEkstra, 2, ',', '.');
			$TampilJmlTotPenghapusanKEkstra=number_format($JmlPenghapusanKEkstra, 2, ',', '.');
			$TampilJmlTotPembukuanDEkstra=number_format($JmlPembukuanDEkstra, 2, ',', '.');
			$TampilJmlTotPembukuanKEkstra=number_format($JmlPembukuanKEkstra, 2, ',', '.');
			$TampilJmlTotReklassDEkstra=number_format($JmlReklassDEkstra, 2, ',', '.');
			$TampilJmlTotReklassKEkstra=number_format($JmlReklassKEkstra, 2, ',', '.');
			$TampilJmlTotSaldoAkEkstra=number_format($JmlSaldoAkEkstra, 2, ',', '.');	
						
			$TampilJmlSusutAkEkstra=number_format($JmlSusutAkEkstra, 2, ',', '.');
			$TampilJmlSusutAwEksra =number_format($JmlSusutAwEkstra, 2, ',', '.');
			$TampilJmldebet_susutEkstra=number_format($Jmldebet_susutEkstra, 2, ',', '.');
			$TampilJmlkredit_susutEkstra=number_format($Jmlkredit_susutEkstra, 2, ',', '.');
			$TampilJmlNilaiBukuEkstra=number_format($JmlNilaiBukuEkstra, 2, ',', '.');
			
			//tampil extra ---------------------------------------------------------------------------
			$tglAwal2 = ($fmFiltThnBuku-1).'-12-31';
			$paramKdAkun = "&kint=02&ka=00&kb=00";
			$hrefAw = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAwal2";
			$hrefAw = "<a href='$hrefAw' target='blank_'  style='color:black;'>";
			$hrefAk = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAkhir";
			$hrefAk = "<a href='$hrefAk' target='blank_'  style='color:black;'>";
			$href 	= "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl1=$tglAwal&tgl2=$tglAkhir";		
			$ListData .="<tr>
				<td align=right>&nbsp;</td>
				<td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Jumlah Ekstrakomptabel</b></td>
				<td align=right>$hrefAw<b>$TampilJmlTotSaldoAwEkstra</b></a></td>
				<td align=right><a href='$hrefAwSusut' target='blank_'  style='color:black;'><b>$TampilJmlSusutAw</b></a></td>
				
				<td align=right><a href='$href&jns_trans=1' target='blank_'  style='color:black;'><b>$TampilJmlTotBelanjaEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=2' target='blank_'  style='color:black;'><b>$TampilJmlTotAtribusiEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=3&debet=1' target='blank_'  style='color:black;'><b>$TampilJmlTotKapitalisasiDEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=3&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlTotKapitalisasiKEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=4&debet=1' target='blank_'  style='color:black;'><b>$TampilJmlTotHibahDEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=4&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlTotHibahKEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=5&debet=1' target='blank_'  style='color:black;'><b>$TampilJmlTotMutasiDEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=5&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlTotMutasiKEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=6' target='blank_'  style='color:black;'><b>$TampilJmlTotPenilaianDEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=7' target='blank_'  style='color:black;'><b>$TampilJmlTotPenghapusanKEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=8&debet=1' target='blank_'  style='color:black;'><b>$TampilJmlTotPembukuanDEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=8&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlTotPembukuanKEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=9&debet=1' target='blank_'  style='color:black;'><b>$TampilJmlTotReklassDEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=9&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlTotReklassKEkstra</b></a></td>
				
				<td align=right><a href='$href&jns_trans=10&debet=1' target='blank_'  style='color:black;'><b>$TampilJmldebet_susutEkstra</b></a></td>
				<td align=right><a href='$href&jns_trans=10&debet=2' target='blank_'  style='color:black;'><b>$TampilJmlkredit_susutEkstra</b></a></td>
				
				<td align=right>$hrefAk<b>$TampilJmlTotSaldoAkEkstra</b></a></td>
				<td align=right><a href='$hrefAkSusut' target='blank_'  style='color:black;'><b>$TampilJmlSusutAkEkstra</b></a></td>
				<td align=right><a href='$hrefAkSusut' target='blank_'  style='color:black;'><b>$TampilJmlNilaiBukuEkstra</b></a></td>
				</tr>"	;		
	

			$JmlSaldoAwTot=$JmlSaldoAwTot+$JmlSaldoAwEkstra;	
			$JmlBelanjaTot=$JmlBelanjaTot+$JmlBelanjaEkstra;
			$JmlAtribusiTot=$JmlAtribusiTot+$JmlAtribusiEkstra;
			$JmlKapitalisasiDTot=$JmlKapitalisasiDTot+$JmlKapitalisasiDEkstra;	
			$JmlKapitalisasiKTot=$JmlKapitalisasiKTot+$JmlKapitalisasiKEkstra;
			$JmlHibahDTot=$JmlHibahDTot+$JmlHibahDEkstra;
			$JmlHibahKTot=$JmlHibahKTot+$JmlHibahKEkstra;
			$JmlMutasiDTot=$JmlMutasiDTot+$JmlMutasiDEkstra;
			$JmlMutasiKTot=$JmlMutasiKTot+$JmlMutasiKEkstra;
			$JmlPenilaianDTot=$JmlPenilaianDTot+$JmlPenilaianDEkstra;
			$JmlPenghapusanKTot=$JmlPenghapusanKTot+$JmlPenghapusanKEkstra;
			$JmlPembukuanDTot=$JmlPembukuanDTot+$JmlPembukuanDEkstra;
			$JmlPembukuanKTot=$JmlPembukuanKTot+$JmlPembukuanKEkstra;
			$JmlReklassDTot=$JmlReklassDTot+$JmlReklassDEkstra;
			$JmlReklassKTot=$JmlReklassKTot+$JmlReklassKEkstra;
			$JmlSaldoAkTot=$JmlSaldoAkTot+$JmlSaldoAkEkstra;
			
			$JmlSusutAkTot+=$JmlSaldoAkEkstra;
			$JmlSusutAwTot+=$JmlSaldoAwEkstra;
			$Jmldebet_susutEkstraTot+=$Jmldebet_susutEkstra;
			$Jmlkredit_susutEkstraTot+=$Jmlkredit_susutEkstra;
			$JmlNilaiBukuEkstraTot+=$JmlNilaiBukuEkstra;
			
			$JmlSaldoAwTotx=$JmlSaldoAwTotx+$JmlSaldoAwTot;	
			$JmlBelanjaTotx=$JmlBelanjaTotx+$JmlBelanjaTot;
			$JmlAtribusiTotx=$JmlAtribusiTotx+$JmlAtribusiTot;
			$JmlKapitalisasiDTotx=$JmlKapitalisasiDTotx+$JmlKapitalisasiDTot;	
			$JmlKapitalisasiKTotx=$JmlKapitalisasiKTotx+$JmlKapitalisasiKTot;
			$JmlHibahDTotx=$JmlHibahDTotx+$JmlHibahDTot;
			$JmlHibahKTotx=$JmlHibahKTotx+$JmlHibahKTot;
			$JmlMutasiDTotx=$JmlMutasiDTotx+$JmlMutasiDTot;
			$JmlMutasiKTotx=$JmlMutasiKTotx+$JmlMutasiKTot;
			$JmlPenilaianDTotx=$JmlPenilaianDTotx+$JmlPenilaianDTot;
			$JmlPenghapusanKTotx=$JmlPenghapusanKTotx+$JmlPenghapusanKTot;
			$JmlPembukuanDTotx=$JmlPembukuanDTotx+$JmlPembukuanDTot;
			$JmlPembukuanKTotx=$JmlPembukuanKTotx+$JmlPembukuanKTot;
			$JmlReklassDTotx=$JmlReklassDTotx+$JmlReklassDTot;
			$JmlReklassKTotx=$JmlReklassKTotx+$JmlReklassKTot;
			$JmlSaldoAkTotx=$JmlSaldoAkTotx+$JmlSaldoAkTot;	
	
			$JmlSusutAkTotx+=$JmlSaldoAkEkstra;
			$JmlSusutAwTotx+=$JmlSaldoAwEkstra;
			$Jmldebet_susutEkstraTotx+=$Jmldebet_susutEkstra;
			$Jmlkredit_susutEkstraTotx+=$Jmlkredit_susutEkstra;
			$JmlNilaiBukuEkstraTotx+=$JmlNilaiBukuEkstra;
	
			$TampilJmlSaldoAwTot=number_format($JmlSaldoAwTot, 2, ',', '.');	
			$TampilJmlBelanjaTot=number_format($JmlBelanjaTot, 2, ',', '.');
			$TampilJmlAtribusiTot=number_format($JmlAtribusiTot, 2, ',', '.');
			$TampilJmlKapitalisasiDTot=number_format($JmlKapitalisasiDTot, 2, ',', '.');	
			$TampilJmlKapitalisasiKTot=number_format($JmlKapitalisasiKTot, 2, ',', '.');
			$TampilJmlHibahDTot=number_format($JmlHibahDTot, 2, ',', '.');
			$TampilJmlHibahKTot=number_format($JmlHibahKTot, 2, ',', '.');
			$TampilJmlMutasiDTot=number_format($JmlMutasiDTot, 2, ',', '.');
			$TampilJmlMutasiKTot=number_format($JmlMutasiKTot, 2, ',', '.');
			$TampilJmlPenilaianDTot=number_format($JmlPenilaianDTot, 2, ',', '.');
			$TampilJmlPenghapusanKTot=number_format($JmlPenghapusanKTot, 2, ',', '.');
			$TampilJmlPembukuanDTot=number_format($JmlPembukuanDTot, 2, ',', '.');
			$TampilJmlPembukuanKTot=number_format($JmlPembukuanKTot, 2, ',', '.');
			$TampilJmlReklassDTot=number_format($JmlReklassDTot, 2, ',', '.');
			$TampilJmlReklassKTot=number_format($JmlReklassKTot, 2, ',', '.');
			$TampilJmlSaldoAkTot=number_format($JmlSaldoAkTot, 2, ',', '.');			
			
			$vJmlSusutAkTot=number_format($JmlSusutAkTot, 2, ',', '.');	
			$vJmlSusutAwTot = number_format($JmlSusutAwTot, 2, ',', '.');	
			$vJmldebet_susutTot = number_format($Jmldebet_susutTot, 2, ',', '.');	
			$vJmlkredit_susutTot = number_format($Jmlkredit_susutTot, 2, ',', '.');	
			$vJmlNilaiBukuTot = number_format($JmlNilaiBukuTot, 2, ',', '.');	
			
			//tampil total aset + extra -----------------------------------------------------
			$paramKdAkun = "";
			$tglAwal2 = ($fmFiltThnBuku-1).'-12-31';
			$hrefAw = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAwal2";
			$hrefAw = "<a href='$hrefAw' target='blank_'  style='color:black;'>";
			$hrefAk = "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl2=$tglAkhir";
			$hrefAk = "<a href='$hrefAk' target='blank_'  style='color:black;'>";
			$href 	= "pages.php?Pg=Jurnal$paramSKPD$paramKdAkun&tgl1=$tglAwal&tgl2=$tglAkhir";
			$ListData .="<tr>
				<td align=right>&nbsp;</td>
				<td ><b>Jumlah Aset + Ekstrakomptabel</b></td>
				<td align=right>$hrefAw<b>$TampilJmlSaldoAwTot</b></a></td>
				<td align=right><a href='$hrefAwSusut' target='blank_'  style='color:black;'><b>$TampilJmlSusutAwTot</b></a></td>
				
				<td align=right><a href='$href&jns_trans=1' target='blank_' style='color:black;'><b>$TampilJmlBelanjaTot</b></a></td>
				<td align=right><a href='$href&jns_trans=1' target='blank_' style='color:black;'><b>$TampilJmlAtribusiTot</b></a></td>
				<td align=right><a href='$href&jns_trans=3&debet=1' target='blank_' style='color:black;'><b>$TampilJmlKapitalisasiDTot</b></a></td>
				<td align=right><a href='$href&jns_trans=3&debet=2' target='blank_' style='color:black;'><b>$TampilJmlKapitalisasiKTot</b></a></td>
				<td align=right><a href='$href&jns_trans=4&debet=1' target='blank_' style='color:black;'><b>$TampilJmlHibahDTot</b></a></td>
				<td align=right><a href='$href&jns_trans=4&debet=2' target='blank_' style='color:black;'><b>$TampilJmlHibahKTot</b></a></td>
				<td align=right><a href='$href&jns_trans=5&debet=1' target='blank_' style='color:black;'><b>$TampilJmlMutasiDTot</b></a></td>
				<td align=right><a href='$href&jns_trans=5&debet=2' target='blank_' style='color:black;'><b>$TampilJmlMutasiKTot</b></a></td>
				<td align=right><a href='$href&jns_trans=6' target='blank_' style='color:black;'><b>$TampilJmlPenilaianDTot</b></a></td>
				<td align=right><a href='$href&jns_trans=7' target='blank_' style='color:black;'><b>$TampilJmlPenghapusanKTot</b></a></td>
				<td align=right><a href='$href&jns_trans=8&debet=1' target='blank_' style='color:black;'><b>$TampilJmlPembukuanDTot</b></a></td>
				<td align=right><a href='$href&jns_trans=8&debet=2' target='blank_' style='color:black;'><b>$TampilJmlPembukuanKTot</b></a></td>
				<td align=right><a href='$href&jns_trans=9&debet=1' target='blank_' style='color:black;'><b>$TampilJmlReklassDTot</b></a></td>
				<td align=right><a href='$href&jns_trans=9&debet=2' target='blank_' style='color:black;'><b>$TampilJmlReklassKTot</b></a></td>
				
				<td align=right><a href='$href&jns_trans=10&debet=1' target='blank_'  style='color:black;'><b>$vJmldebet_susutTot</b></a></td>
				<td align=right><a href='$href&jns_trans=10&debet=2' target='blank_'  style='color:black;'><b>$vJmlkredit_susutTot</b></a></td>
				
				<td align=right>$hrefAk<b>$TampilJmlSaldoAkTot</b></a></td>
				<td align=right><a href='$hrefAkSusut' target='blank_'  style='color:black;'><b>$TampilJmlSusutAkTot</b></a></td>
				<td align=right><a href='$hrefAkSusut' target='blank_'  style='color:black;'><b>$vJmlNilaiBukuTot</b></a></td>
				</tr>"	;		
		
				

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

	
	/*function genSum_setTampilValue($i, $value){
		if( $i = 8  || $i =10) {
			return number_format($value, 2, ',' ,'.');
		}else{
			return number_format($value, 0, ',' ,'.');	
		}
		
	}*/


	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		
		$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD'); //echo 'fmskpd='.$fmSKPD;
		$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		$fmSEKSI = cekPOST($this->Prefix.'SkpdfmSEKSI');

		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\" colspan=6>REKAP NERACA</td>
			</tr>
			</table>"	
			.PrintSKPD2($fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI,$this->cetak_xls)."<br>";
	}
	
}


$Pembukuan2_2 = new PembukuanObj2();



?>
