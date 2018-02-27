<?php

class rekapdkb_skpdObj  extends DaftarObj2{	
	var $Prefix = 'rekapdkb_skpd';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'dkb'; //daftar
	var $TblName_Hapus = 'dkb';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('c','d');
	var $FieldSum = array('jml_brg_a','jml_hrg_a',
						  'jml_brg_b','jml_hrg_b',
						  'jml_brg_c','jml_hrg_c',
						  'jml_brg_d','jml_hrg_d',
						  'jml_brg_e','jml_hrg_e',
						  'jml_brg_f','jml_hrg_f',
						  'jml_brg_g','jml_hrg_g',
						  'tot_brg','tot_hrg');//array('jml_harga');
	var $fieldSum_lokasi = array( 4);
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'Perencanaan Kebutuhan dan Penganggaran';
	var $PageIcon = 'images/perencanaan_ico.png';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='Rekap DKBMD SKPD.xls';
	var $Cetak_Judul = 'REKAP DKBMD SKPD';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	
	var $FormName = 'rekapdkb_skpdForm'; 	
			
	function setTitle(){
		return 'Rekap Daftar Kebutuhan Barang Milik Daerah (SKPD)';
	}
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".rincian()","edit_f2.png","Rincian", 'Rincian')."</td>";
	}
	function setMenuView(){
		return 
			"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png",'Halaman',"Cetak Daftar per Halaman")."</td>".			
			"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakAll(\"$Op\")","print_f2.png",'Semua',"Cetak Semua Daftar")."</td>";
	}
	
	
	
	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
		
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function set_selector_other($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	  
	  switch($tipe){
	  
		case 'BidangAfter':{
			$content= $this->cmbQuerySKPD('fmSKPDskpd',$fmSKPDskpd,'','onchange=rekapdkb_skpd.refreshList(true)','--- Pilih SKPD ---','00');
		break;
	    }
		case 'SKPDAfter':{
			$fmSKPDBidang = cekPOST('fmSKPDBidang');
			$fmSKPDskpd = cekPOST('fmSKPDskpd');
			setcookie('cofmSKPD',$fmSKPDBidang);
			setcookie('cofmUNIT',$fmSKPDskpd);
		break;
	    }			
		
	   
	   case 'subtitle':{		
					$content = $this->setTopBar();
					$json=TRUE;
					break;
				}
					   	   	   
	   default:{
			$other = $this->set_selector_other2($tipe);
			$cek = $other['cek'];
			$err = $other['err'];
			$content=$other['content'];
			$json=$other['json'];
	   break;
	   }
	 }//end switch
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }
	
	function setPage_OtherScript(){
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
		 "<script type='text/javascript' src='js/perencanaan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			
			 
			
			$scriptload;
	}
	

	//daftar =================================	
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
	  	   <th class='th01' width='5' rowspan='2'>No.</th>
	  	   $Checkbox
		   <th class='th01' rowspan='2'>SKPD</th>
		   <th class='th02' colspan='2'>KIB A</th>
		   <th class='th02' colspan='2'>KIB B</th>
		   <th class='th02' colspan='2'>KIB C</th>
		   <th class='th02' colspan='2'>KIB D</th>
		   <th class='th02' colspan='2'>KIB E</th>
		   <th class='th02' colspan='2'>KIB F</th>
		   <th class='th02' colspan='2'>KIB G</th>
		   <th class='th02' colspan='2'>Total</th>
	   </tr>
	   <tr>
	  	   <th class='th01' >Jumlah</th>
		   <th class='th01' >Harga</th>
		   <th class='th01' >Jumlah</th>
		   <th class='th01' >Harga</th>	
		   <th class='th01' >Jumlah</th>
		   <th class='th01' >Harga</th>	
		   <th class='th01' >Jumlah</th>
		   <th class='th01' >Harga</th>	
		   <th class='th01' >Jumlah</th>
		   <th class='th01' >Harga</th>	
		   <th class='th01' >Jumlah</th>
		   <th class='th01' >Harga</th>	
		   <th class='th01' >Jumlah</th>
		   <th class='th01' >Harga</th>	
		   <th class='th01' >Jumlah</th>
		   <th class='th01' >Harga</th>			   
	   </tr>
	   </thead>";
	
	return $headerTable;
	}	
	
	function setPage_HeaderOther(){
	
		return 
			"";
	}
	function setNavAtas(){
		global $Main;
		if ($Main->VERSI_NAME=='JABAR') $persediaan = "| <a href='pages.php?Pg=perencanaanbarang_persediaan' title='Perencanaan Persediaan'>Persediaan</a> ";
	
		return
		
			'<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td class="menudottedline" width="60%" height="20" style="text-align:right"><b>
				<a style="color:blue;" href="pages.php?Pg=rkb" title="Pengadaan">Pengadaan</a> |				
				<a href="pages.php?Pg=rkpb" title="Pemeliharaan">Pemeliharaan</a>  |  
				<a href="pages.php?Pg=rencana_pemanfaatan" title="Pemanfaatan">Pemanfaatan</a>  |
				<a href="pages.php?Pg=rpebmd" title="Pemindahtanganan">Pemindahtanganan</a>  |
				<a href="pages.php?Pg=rphbmd" title="Penghapusan">Penghapusan</a> '.
					$persediaan.
				  '&nbsp;&nbsp;&nbsp;
			</b></td>
			</tr>
			
			<tr>
			<td class="menudottedline" width="60%" height="20" style="text-align:right"><b>
				<a href="pages.php?Pg=rkb" title="Rencana Kebutuhan Barang Milik Daerah">RKBMD</a> |	
				<a href="pages.php?Pg=rekaprkb" title="Rekap Rencana Kebutuhan Barang Milik Daerah">Rekap RKBMD</a> |
				<a href="pages.php?Pg=rekaprkb_skpd" title="Rencana Kebutuhan Barang Milik Daerah">Rekap RKBMD (SKPD)</a>  |	
				<a href="pages.php?Pg=rka" title="Rekap Rencana Kebutuhan Anggaran">RKA</a> | 		
				<a href="pages.php?Pg=dkb" title="Daftar Kebutuhan Barang Milik Daerah">DKBMD</a>  |  
				<a href="pages.php?Pg=rekapdkb" title="Rekap Daftar Kebutuhan Barang Milik Daerah">Rekap DKBMD</a>  |  
				<a style="color:blue;"   href="pages.php?Pg=rekapdkb_skpd" title="Daftar Kebutuhan Pemeliharaan Barang Milik Daerah">Rekap DKBMD (SKPD)</a>
				  &nbsp;&nbsp;&nbsp;
			</b></td>
			</tr>
			</table>';
	}
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 global $Main;
		
		$Koloms = array();
		$Koloms[] = array('align=center', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array('align=Left', $isi['nm_skpd']);			
		$Koloms[] = array('align=right', number_format($isi['jml_brg_a'],0,',','.'));
		$Koloms[] = array('align=right', number_format($isi['jml_hrg_a'],2,',','.'));
		$Koloms[] = array('align=right', number_format($isi['jml_brg_b'],0,',','.'));
		$Koloms[] = array('align=right', number_format($isi['jml_hrg_b'],2,',','.'));
		$Koloms[] = array('align=right', number_format($isi['jml_brg_c'],0,',','.'));
		$Koloms[] = array('align=right', number_format($isi['jml_hrg_c'],2,',','.'));
		$Koloms[] = array('align=right', number_format($isi['jml_brg_d'],0,',','.'));
		$Koloms[] = array('align=right', number_format($isi['jml_hrg_d'],2,',','.'));
		$Koloms[] = array('align=right', number_format($isi['jml_brg_e'],0,',','.'));
		$Koloms[] = array('align=right', number_format($isi['jml_hrg_e'],2,',','.'));
		$Koloms[] = array('align=right', number_format($isi['jml_brg_f'],0,',','.'));
		$Koloms[] = array('align=right', number_format($isi['jml_hrg_f'],2,',','.'));
		$Koloms[] = array('align=right', number_format($isi['jml_brg_g'],0,',','.'));
		$Koloms[] = array('align=right', number_format($isi['jml_hrg_g'],2,',','.'));
		$Koloms[] = array('align=right', number_format($isi['tot_brg'],0,',','.'));
		$Koloms[] = array('align=right', number_format($isi['tot_hrg'],2,',','.'));
		return $Koloms;
	}
	
	function cmbQueryBidang($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE) {
     global $Ref,$Main;
	 Global $fmSKPDBidang;
		$fmSKPDBidang = cekPOST('fmSKPDBidang');
	 $aqry="select * from ref_skpd where c!='00' and d='00'  GROUP by c";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDBidang='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['c'] ==  $value ? "selected" : "";
				if ($nmSKPDBidang=='' ) $nmSKPDBidang =  $value == $Hasil['c'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[c]}'>{$Hasil[nm_skpd]}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDBidang <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	
	function cmbQuerySKPD($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE) {
	 global $Ref,$Main;
	 Global $fmSKPDBidang,$fmSKPDskpd;
		$fmSKPDBidang = cekPOST('fmSKPDBidang');
		$fmSKPDskpd = cekPOST('fmSKPDskpd');
		setcookie('cofmSKPD',$fmSKPDBidang);
		setcookie('cofmUNIT',$fmSKPDskpd);
	 $aqry="select * from ref_skpd where c='$fmSKPDBidang' and d!='00' and e='00' GROUP by d";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDskpd='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['d'] ==  $value ? "selected" : "";
				if ($nmSKPDskpd=='' ) $nmSKPDskpd =  $value == $Hasil['d'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[d]}'>{$Hasil[nm_skpd]}";
    	}
     $Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "$nmSKPDskpd <input type='hidden' name='$name' id='$name' value='". $value."' >";
     return $Input;
	}
	function genDaftarInitial(){
		$vOpsi = $this->genDaftarOpsi();
		$fmThnAnggaran=  $_COOKIE['coThnAnggaran'];
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
			"</div>".	
			//"<div style='position:relative'>".
			$vdaftar.
			//"</div>".
			'';
	}
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 Global $fmSKPDBidang,$fmSKPDskpd;
	 $fmSKPDBidang=cekPOST('fmSKPDBidang');
	 $fmSKPDskpd=cekPOST('fmSKPDskpd');
	 $fmThnAnggaran=  $_COOKIE['coThnAnggaran'];
	
	
	$TampilOpt = 
			"<table  class=\"adminform\">	<tr>		
			<td style='padding:1 8 0 8; '  valign=\"top\">".
			"<table><tr><td width='100'>Bidang</td><td width='10'>:</td><td>".
				$this->cmbQueryBidang('fmSKPDBidang',$fmSKPDBidang,'','onchange=rekapdkb_skpd.BidangAfter() '.$disabled1,'--- Pilih BIDANG ---','00')."</td></tr>".
			"<tr><td width='100'>SKPD</td><td width='10'>:</td><td>".
				$this->cmbQuerySKPD('fmSKPDskpd',$fmSKPDskpd,'','onchange=rekapdkb_skpd.SKPDAfter() '.$disabled1,'--- Pilih SKPD ---','00').
			"</td></tr></table>".
			"</td>
			</tr></table>".
			
			genFilterBar(
				array(	
					"Tahun Anggaran &nbsp;"
					."<input type='text'  size='4' value='$fmThnAnggaran' id='fmThnAnggaran' name='fmThnAnggaran' readonly=''>"
				),$this->Prefix.".refreshList(true)",TRUE
			)
			;		
		return array('TampilOpt'=>$TampilOpt);
	}
		
	function setDaftar_query($Kondisi='', $Order='', $Limit=''){		
		
		$fmSKPDBidang = cekPOST('fmSKPDBidang');
		$fmSKPDskpd = cekPOST('fmSKPDskpd');		
		$fmThnAnggaran=$_REQUEST['fmThnAnggaran'];
		$arrKondisiSKPD = array();
		if(!($fmThnAnggaran=='') ) $arrKondisiSKPD[] = "tahun='$fmThnAnggaran'";
		if(!($fmSKPDBidang=='' || $fmSKPDBidang=='00') ) $arrKondisiSKPD[] = "c='$fmSKPDBidang'";
		if(!($fmSKPDskpd=='' || $fmSKPDskpd=='00') ) $arrKondisiSKPD[] = "d='$fmSKPDskpd'";
		//$arrKondisiSKPD[] = " e='00' and e1='000' and d<>'00'";
		$kondSKPD= join(' and ',$arrKondisiSKPD);		
		$kondSKPD = $kondSKPD =='' ? '':' where '.$kondSKPD;
			
		$arrKondisiSKPD2 = array();
		if(!($fmSKPDBidang=='' || $fmSKPDBidang=='00') ) $arrKondisiSKPD2[] = "aa.c='$fmSKPDBidang'";
		if(!($fmSKPDskpd=='' || $fmSKPDskpd=='00') ) {
			$arrKondisiSKPD2[] = "aa.d='$fmSKPDskpd'";
		}else{
			$arrKondisiSKPD2[] = "  aa.d<>'00'";
		}
		
		$kondSKPD2= join(' and ',$arrKondisiSKPD2);		
		$kondSKPD2 = $kondSKPD2 =='' ? '':' where '.$kondSKPD2;
		$aqry = "
		select aa.c, aa.d, aa.nm_skpd,
		bb.jml_brg_a,bb.jml_hrg_a,bb.jml_brg_b,bb.jml_hrg_b,bb.jml_brg_c,bb.jml_hrg_c,
		bb.jml_brg_d,bb.jml_hrg_d,bb.jml_brg_e,bb.jml_hrg_e,bb.jml_brg_f,bb.jml_hrg_f,
		bb.jml_brg_g,bb.jml_hrg_g,
		(bb.jml_brg_a+bb.jml_brg_b+bb.jml_brg_c+bb.jml_brg_d+bb.jml_brg_e+bb.jml_brg_f+bb.jml_brg_g) as tot_brg,
		(bb.jml_hrg_a+bb.jml_hrg_b+bb.jml_hrg_c+bb.jml_hrg_d+bb.jml_hrg_e+bb.jml_hrg_f+bb.jml_hrg_g) as tot_hrg
		from ref_skpd aa
		left join
		(
		select c,d,  
		sum(if(f='01',jml_barang,0)) as jml_brg_a,sum(if(f='01',jml_harga,0)) as jml_hrg_a,
		sum(if(f='02',jml_barang,0)) as jml_brg_b,sum(if(f='02',jml_harga,0)) as jml_hrg_b,
		sum(if(f='03',jml_barang,0)) as jml_brg_c,sum(if(f='03',jml_harga,0)) as jml_hrg_c,
		sum(if(f='04',jml_barang,0)) as jml_brg_d,sum(if(f='04',jml_harga,0)) as jml_hrg_d,
		sum(if(f='05',jml_barang,0)) as jml_brg_e,sum(if(f='05',jml_harga,0)) as jml_hrg_e,
		sum(if(f='06',jml_barang,0)) as jml_brg_f,sum(if(f='06',jml_harga,0)) as jml_hrg_f,
		sum(if(f='07',jml_barang,0)) as jml_brg_g,sum(if(f='07',jml_harga,0)) as jml_hrg_g
		 from dkb 
		 $kondSKPD 
		 group by c,d
		) bb
		on aa.c=bb.c and aa.d=bb.d 
		$kondSKPD2
		group by c,d
		$Order $Limit
		 ";	
		//$aqry = "select * from $this->TblName $Kondisi $Order $Limit ";	
		return $aqry;		
	}
	function setSumHal_query($Kondisi, $fsum){
		$fmSKPDBidang = cekPOST('fmSKPDBidang');
		$fmSKPDskpd = cekPOST('fmSKPDskpd');		
		$fmThnAnggaran=$_REQUEST['fmThnAnggaran'];
		$arrKondisiSKPD = array();
		if(!($fmThnAnggaran=='') ) $arrKondisiSKPD[] = "tahun='$fmThnAnggaran'";
		if(!($fmSKPDBidang=='' || $fmSKPDBidang=='00') ) $arrKondisiSKPD[] = "c='$fmSKPDBidang'";
		if(!($fmSKPDskpd=='' || $fmSKPDskpd=='00') ) $arrKondisiSKPD[] = "d='$fmSKPDskpd'";
		//$arrKondisiSKPD[] = " e='00' and e1='000' and d<>'00'";
		$kondSKPD= join(' and ',$arrKondisiSKPD);		
		$kondSKPD = $kondSKPD =='' ? '':' where '.$kondSKPD;
			
		$arrKondisiSKPD2 = array();
		if(!($fmSKPDBidang=='' || $fmSKPDBidang=='00') ) $arrKondisiSKPD2[] = "aa.c='$fmSKPDBidang'";
		if(!($fmSKPDskpd=='' || $fmSKPDskpd=='00') ) {
			$arrKondisiSKPD2[] = "aa.d='$fmSKPDskpd'";
		}else{
			$arrKondisiSKPD2[] = "  aa.d<>'00'";
		}
		$kondSKPD2= join(' and ',$arrKondisiSKPD2);		
		$kondSKPD2 = $kondSKPD2 =='' ? '':' where '.$kondSKPD2;
		return "select $fsum from (
		select aa.c, aa.d, aa.nm_skpd,
		bb.jml_brg_a,bb.jml_hrg_a,bb.jml_brg_b,bb.jml_hrg_b,bb.jml_brg_c,bb.jml_hrg_c,
		bb.jml_brg_d,bb.jml_hrg_d,bb.jml_brg_e,bb.jml_hrg_e,bb.jml_brg_f,bb.jml_hrg_f,
		bb.jml_brg_g,bb.jml_hrg_g,
		(bb.jml_brg_a+bb.jml_brg_b+bb.jml_brg_c+bb.jml_brg_d+bb.jml_brg_e+bb.jml_brg_f+bb.jml_brg_g) as tot_brg,
		(bb.jml_hrg_a+bb.jml_hrg_b+bb.jml_hrg_c+bb.jml_hrg_d+bb.jml_hrg_e+bb.jml_hrg_f+bb.jml_hrg_g) as tot_hrg
		from ref_skpd aa
		left join
		(
		select c,d,  
		sum(if(f='01',jml_barang,0)) as jml_brg_a,sum(if(f='01',jml_harga,0)) as jml_hrg_a,
		sum(if(f='02',jml_barang,0)) as jml_brg_b,sum(if(f='02',jml_harga,0)) as jml_hrg_b,
		sum(if(f='03',jml_barang,0)) as jml_brg_c,sum(if(f='03',jml_harga,0)) as jml_hrg_c,
		sum(if(f='04',jml_barang,0)) as jml_brg_d,sum(if(f='04',jml_harga,0)) as jml_hrg_d,
		sum(if(f='05',jml_barang,0)) as jml_brg_e,sum(if(f='05',jml_harga,0)) as jml_hrg_e,
		sum(if(f='06',jml_barang,0)) as jml_brg_f,sum(if(f='06',jml_harga,0)) as jml_hrg_f,
		sum(if(f='07',jml_barang,0)) as jml_brg_g,sum(if(f='07',jml_harga,0)) as jml_hrg_g
		 from dkb 
		 $kondSKPD 
		 group by c,d
		) bb
		on aa.c=bb.c and aa.d=bb.d 
		$kondSKPD2
		group by c,d
		$Order $Limit
		) zz"; //echo $aqry;
	}
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		global $fmPILCARI;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();
		$fmSKPDBidang = cekPOST('fmSKPDBidang');
		$fmSKPDskpd = cekPOST('fmSKPDskpd');		
		$fmThnAnggaran=$_REQUEST['fmThnAnggaran'];
		
		
		if(!($fmSKPDBidang=='' || $fmSKPDBidang=='00') ) $arrKondisi[] = "c='$fmSKPDBidang'";
		if(!($fmSKPDskpd=='' || $fmSKPDskpd=='00') ) $arrKondisi[] = "d='$fmSKPDskpd'";
		if(!($fmThnAnggaran=='') ) $arrKondisi[] = "thn_anggaran='$fmThnAnggaran'";
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		$arrOrders[]="c,d";
			$Order= join(',',$arrOrders);	
			$OrderDefault = '';// Order By no_terima desc ';
			$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//}
		//$Order ="";
		//limit --------------------------------------
		/**$HalDefault=cekPOST($this->Prefix.'_hal',1);	//Cat:Settingan Lama				
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		**/
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	
}
$rekapdkb_skpd = new rekapdkb_skpdObj();

?>