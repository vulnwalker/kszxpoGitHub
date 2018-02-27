<?php

class Rekaprpebmd_skpd_rinciObj extends DaftarObj2{
	var $Prefix = 'Rekaprpebmd_skpd_rinci';
	//var $SHOW_CEK = TRUE;	
	var $TblName = 't_rencana_pemindahtanganan';//view2_sensus';
	var $TblName_Hapus = 't_rencana_pemindahtanganan';
	var $TblName_Edit = 't_rencana_pemindahtanganan';
	var $KeyFields = array('Id');
	var $FieldSum = array('harga');
	var $SumValue = array('harga');
	var $FieldSum_Cp1 = array( 8, 7, 7);
	var $FieldSum_Cp2 = array( 4, 4, 4);	
	var $checkbox_rowspan = 2;
	var $FormName = 'Rekaprpebmd_skpd_rinciForm';
	//var $pagePerHal = 7;
	//var $thnsensus_default = 2013;
	//var $periode_sensus = 5;// tahun
	
	var $PageTitle = 'Rincian Rekap RPTBMD (SKPD)';
	var $PageIcon = 'images/perencanaan_ico.png';
	var $ico_width = '';
	var $ico_height = '';
	
	var $fileNameExcel='rekaprpebmd_skpd_rinci.xls';
	var $Cetak_Judul = 'RINCIAN REKAP RPTBMD (SKPD)';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $fmST = 0;
	var $idpilih = '';
	//var $row_params= " valign='top'";
	
	function setPage_OtherScript(){
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			/*"<script type='text/javascript' src='js/dialog1.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/jquery.js' language='JavaScript' ></script>".			*/
			"<script type='text/javascript' src='js/barcode.js' language='JavaScript' ></script>".			
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".		
			"<script type='text/javascript' src='js/perencanaan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".

			$scriptload;
	}
	
	function setPage_OtherScript_nodialog(){
		return "<script type='text/javascript' src='js/barcode.js' language='JavaScript' ></script>".			
				"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".		
				"<script type='text/javascript' src='js/HrgSatPilih.js' language='JavaScript' ></script>".		
				"<script type='text/javascript' src='js/perencanaan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>";
	}
	
	function setTitle(){
		return 'RINCIAN REKAP RPTBMD (SKPD)';
	}
	function setNavAtas(){
		return "";
		
		
	}
	
	/*function setKolomHeader($Mode=1, $Checkbox=''){
		$NomorColSpan = $Mode==1? 2: 1;
		$headerTable =
			"<thead>
				<tr>
				
				<th class='th01' width='5'>No.</th>
				$Checkbox		
				<th class='th01' >Nama Barang / Nama Akun</th>
				<th class='th01' >Merk / Type / Ukuran / Spesifikasi </th>
				<th class='th01' >Jumlah </th>
				<th class='th01' >Satuan</th>
				<th class='th01' >Harga Satuan (Rp)</th>
				<th class='th01' >Jumlah Harga (Rp)</th>							
				<th class='th01' >Sub Unit</th>							
				<th class='th01' >Keterangan</th>							
				
				</tr>
			</thead>";
		return $headerTable;
	}*/
	
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
	  	   <th class='th01' width='5' rowspan='2'>No.</th>
	  	   $Checkbox
		   <th class='th01' rowspan='2'>Kode Barang</th>
		   <th class='th01' rowspan='2'>Noreg</th>
		   <th class='th01' rowspan='2'>Nama Barang</th>
		   <th class='th02' colspan='2'>Spesifikasi Barang</th>
		   <th class='th01' rowspan='2'>Tahun/Cara Perolehan</th>
		   <th class='th01' rowspan='2'>Harga Perolehan</th>
		   <th class='th01' rowspan='2'>Ukuran/Konstruksi</th>
		   <th class='th01' rowspan='2'>Kondisi Barang</th>
		   <th class='th01' rowspan='2'>Bentuk Pemindahtanganan</th>
		   <th class='th01' rowspan='2'>Keterangan</th>
	   </tr>
	   <tr>
	  	   <th class='th01' >Merk/Type/Alamat</th>
		   <th class='th01' >No. Sertifikat / No. Pabrik / No. Chasis / No. Mesin</th>
		   
	   </tr>
	   </thead>";
	
	return $headerTable;
	}
	
	/*function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref,$HTTP_COOKIE_VARS;
		
		$Koloms = array();
		
		//cari total bi
		$totalbi = '';
		$status = $isi['stat'] == '1' ? 'DKB' : '';
		
		
		
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST($this->Prefix.'SkpdfmSKPD');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST($this->Prefix.'SkpdfmSUBUNIT');				
		$fmSEKSI = isset($HTTP_COOKIE_VARS['cofmSEKSI'])? $HTTP_COOKIE_VARS['cofmSEKSI']: cekPOST($this->Prefix.'SkpdfmSEKSI');				


		if($fmSEKSI == '00' || $fmSEKSI == '000'){
			$get = mysql_fetch_array(mysql_query(
				"select nm_skpd as nmseksi from ref_skpd where c='".$isi['c']."' and d='".$isi['d']."' and e='".$isi['e']."' and e1='".$isi['e1']."'"
			));		
			//if($get['nmseksi']<>'') $nmopdarr[] = $get['nmseksi'];
		}


		$nmopd = //$fmSKPD.'-'.$fmUNIT.'-'.$fmSUBUNIT.' ';
			//join(' <br> ', $nmopdarr );
		
		
		
		$Koloms[] = array('align=right', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array('', 
			$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'].'<br>'.
			$isi['nm_barang'].'/<br>'.
			$isi['k'].'.'.$isi['l'].'.'.$isi['m'].'.'.$isi['n'].'.'.$isi['o'].'.'.$isi['kf'].'<br>'.
			$isi['nm_account']		
		);		
		$Koloms[] = array('', $isi['merk_barang'] );
		$Koloms[] = array("align='center'", $isi['jml_barang']);
		$Koloms[] = array("align='center'", $isi['satuan']);
		$Koloms[] = array("align='right'", number_format( $isi['harga'] , 2,',','.') );		
		$Koloms[] = array("align='right'", number_format( $isi['jml_harga'] ,2,',','.') );
		$Koloms[] = array('',$get['nmseksi']);
		$Koloms[] = array('',$isi['ket']);
		return $Koloms;
	}*/
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 global $Main;
		$kd_barang=$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'];
	 	$brg = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,g,h,i,j)='".$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j']."'")) ;
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
			$no_det=$arrdet['no_pabrik']."/".$arrdet['no_rangka']."/".$arrdet['no_mesin'];
			$ukuran=$arrdet['ukuran']." cc";
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
		
	    $cara=$isi['thn_perolehan']." / ".$Main->AsalUsul[$bi['asal_usul']-1][1];
		$harga=number_format($isi['harga'],2,',','.');
		
		$Koloms = array();
		$Koloms[] = array('align=center', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array('align=center', $kd_barang);			
		$Koloms[] = array('align=center', $isi['noreg']);
		$Koloms[] = array('', $brg['nm_barang']);
		$Koloms[] = array('', $merk) ;
		$Koloms[] = array('', $no_det);
		$Koloms[] = array('', $cara);
		$Koloms[] = array('align=right', $harga);
		$Koloms[] = array('', $ukuran);
		$Koloms[] = array('', $Main->KondisiBarang[$bi['kondisi']-1][1]);
		$Koloms[] = array('', $Main->BentukPemindahtanganan[$isi['bentuk_pemindahtanganan']-1][1]);
		$Koloms[] = array('', $isi['ket']);
		return $Koloms;
	}
	
	function genDaftarOpsi(){
		global $Ref, $Main;
	
		$tahun=$_REQUEST['tahun']==''?$_COOKIE['coThnAnggaran']:$_REQUEST['tahun'];
		$c=$_REQUEST['c'];
		$d=$_REQUEST['d'];
		
		//ambil nama bidang
		$row=mysql_fetch_array(mysql_query("select nm_skpd as nmBidang from ref_skpd where c='$c' and d='00'"));
		$fmBidang=$row['nmBidang']==''?'-':$row['nmBidang'];
		
		if($d!='00'){
			//ambil nama skpd
			$row=mysql_fetch_array(mysql_query("select nm_skpd as nmSkpd from ref_skpd where c='$c' and d='$d'"));
		}$fmSkpd=$row['nmSkpd']==''?'-':$row['nmSkpd'];
		
		$TampilOpt =
			"<table width=\"100%\" class=\"adminform\">	
				<tr>		
					<td width='50'>BIDANG</td>
					<td width='10'>:</td>
					<td><input type='text' value='$fmBidang' id='fmBidang' name='fmBidang' size='60' readonly></td>
				</tr>
				<tr>		
					<td>SKPD</td>
					<td>:</td>
					<td><input type='text' value='$fmSkpd' id='$fmSkpd' name='fmSkpd' size='60' readonly></td>
				</tr>
				<tr>		
					<td>TAHUN</td>
					<td>:</td>
					<td>
					<input type='text' value='$tahun' id='tahun' name='tahun' size='5' readonly>
					<input type='hidden' value='$c' id='c' name='c'>
					<input type='hidden' value='$d' id='d' name='d'>
					</td>
				</tr>
			</table>";
			/*genFilterBar(
				array(	
					boxFilter( 'BIDANG : '.	"<input type='text' value='$fmBidang' id='fmBidang' name='fmBidang' size='60' readonly>").'<BR>'.
					boxFilter( 'SKPD   : '.	"<input type='text' value='$fmSkpd' id='fmSkpd' name='fmSkpd' size='60' readonly>").'<BR>'.
					boxFilter( 'TAHUN  : '.	"<input type='text' value='$fmFiltThnAnggaran' id='fmFiltThnAnggaran' name='fmFiltThnAnggaran' readonly>
								<input type='hidden' value='$fmC' id='fmC' name='fmC'>
								<input type='hidden' value='$fmD' id='fmD' name='fmD'>")
					
				),				
				$this->Prefix.".refreshList(true)"
			);*/
		
		return array('TampilOpt'=>$TampilOpt);
	}	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		
		//kondisi -----------------------------------
		$arrKondisi = array();		
		
		$tahun = $_REQUEST['tahun'];
		$c = $_REQUEST['c'];
		$d = $_REQUEST['d']=='00'?'':$_REQUEST['d'];
		
		if(!empty($tahun)) $arrKondisi[]= "thn_anggaran = '$tahun'";
		if(!empty($c) )  $arrKondisi[] = "c='$c'";
		if(!empty($d) )  $arrKondisi[] = "d='$d'";
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		//Order -------------------------------------
		
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//lim it --------------------------------------
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	
	function setMenuEdit(){		
		return "";
			
	}
	
	function setMenuView(){
		return //"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHit()","print_f2.png","Cetak", 'Cetak Nota Hitung')."</td>
					"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png","Halaman")."</td>			
					<td>".genPanelIcon("javascript:".$this->Prefix.".cetakAll(\"$Op\")","print_f2.png","Semua")."</td>
					<td>".genPanelIcon("javascript:".$this->Prefix.".exportXls(\"$Op\")","export_xls.png","Excel")."</td>";
					
	}
	
	function setFormBaru(){
		global $Main;
		$dt=array();
		$dt['c'] = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$dt['d'] = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$dt['e'] = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$dt['e1'] = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
		
		$dt['p'] = '';
		$dt['q'] = '';
		$dt['tahun']=$_COOKIE['coTahunAnggaran'];
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
		
		/*setcookie('cofmSKPD', $old['c']);
		setcookie('cofmUNIT', $old['d']);
		setcookie('cofmSUBUNIT', $old['e']);
		*/
		
		$aqry = "select * from $this->TblName where id='$this->form_idplh'";
		$dt = mysql_fetch_array(mysql_query($aqry));
		
		//echo sizeof($cbid).' '.$cbid[0] ;
		//print_r($cbid);
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err']	, 'content'=> $fm['content']
		);
	}
	
	function setForm($dt){	
		//global $SensusTmp;
		global $fmIDBARANG, $fmIDREKENING,$Main;
		$cek = ''; $err=''; $content=''; 
		
		$json = TRUE;	//$ErrMsg = 'tes';
		
		$form_name = $this->Prefix.'_form';				
		$this->form_width = 500;
		$this->form_height = 150;
		if ($this->form_fmST==0) {
			$this->form_caption = 'Baru';
			$nip	 = '';
		}else{
			$this->form_caption = 'Edit';			
			$nip = $dt['nip'];			
		}
		$kdSubUnit0 = genNumber(0, $Main->SUBUNIT_DIGIT );
		//items ----------------------
		//$sesi = gen_table_session('sensus','uid');
		//style='width: 318px;text-transform: uppercase;'
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='00' "));
		$bidang = $get['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='00' "));
		$unit = $get['nm_skpd'];
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='$kdSubUnit0'"));
		$subunit = $get['nm_skpd'];		
		$get=mysql_fetch_array(mysql_query("select * from ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' "));
		$seksi = $get['nm_skpd'];
		
		$menu =
			"<table width='100%' class='menudottedline'>
			<tbody><tr><td>
				<table width='50'><tbody><tr>				
					<td>					
					 <table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
					<tbody><tr valign='middle' align='center'> 
					<td class='border:none'> 
						<a class='toolbar' id='btsave' 
							href='javascript:".$this->Prefix.".Simpan2()'> 
						<img src='images/administrator/images/save_f2.png' alt='Save' name='save' width='32' height='32' border='0' align='middle' title='Simpan'> Simpan</a> 
					</td> 
					</tr> 
					</tbody></table> 
					</td>
					<td>			
					 <table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
					<tbody><tr valign='middle' align='center'> 
					<td class='border:none'> 
						<a class='toolbar' id='' href='javascript:window.close();'> 
						<img src='images/administrator/images/cancel_f2.png' alt='Save' name='save' width='32' height='32' border='0' align='middle' title='Batal'> Batal</a> 
					</td> 
					</tr> 
					</tbody></table> 
					</td>
					</tr>
				</tbody></table>
			</td></tr>
			</tbody></table>";
		
		$fmIDBARANG = $dt['f']==''? '':  $dt['f'].'.'.$dt['g'].'.'.$dt['h'].'.'.$dt['i'].'.'.$dt['j'] ;//'01.01.01.02.01';
		$fmNMBARANG = $dt['nm_barang'];
		$fmIDREKENING = $dt['k']==''? '' : $dt['k'].'.'.$dt['l'].'.'.$dt['m'].'.'.$dt['n'].'.'.$dt['o'].'.'.$dt['kf'];//'5.1.1.01.05';
		$fmNMREKENING = $dt['nm_account'];
		$fmTAHUN = $dt['tahun']==''?  $_COOKIE['coThnAnggaran'] : $dt['tahun'] ; //def tahun = 2012
		
		
		$vtahun = //$this->form_fmST==1? $fmTAHUN :
			'<input type="text" id="fmTAHUN" name="fmTAHUN" value="'.$fmTAHUN.'" size="4" maxlength=4 onkeypress="return isNumberKey(event)" readonly>';
		
		$vkdbarang = //$this->form_fmST==1?	$fmIDBARANG.' - '.$dt['nm_barang'] :
			cariInfo("adminForm","pages/01/caribarang1.php","pages/01/caribarang2a.php",
					"fmIDBARANG",
					"fmNMBARANG",
					"readonly","$DisAbled");
					
		$vkdrekening = //$this->form_fmST==1?	$fmIDREKENING.' - '.$dt['nm_account'] :
			cariInfo("adminForm","pages/01/cariakun1.php","pages/01/cariakun2.php","fmIDREKENING","fmNMREKENING",'readonly'); 
		
		$vjmlbi = //$this->form_fmST==1?	$dt['jml_bi'] :
			'<input type="text"  readonly="true" id="jmlbi" name="jmlbi" value="'.$dt['jml_bi'].'" >&nbsp;'
			."<input type='button' id='btcek_jmlbi' name='btcek_jmlbi' value='Cek' onclick='rkb.cekJmlBrgBI()' title='Cek Jumlah Inventaris (Tahun Sebelumnya) dan Jumlah Standar'>"
			;
		
		$vstandar = /*$this->form_fmST==1?$dt['jml_standar'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Info Maks Rencana : '.$dt['jml_max'] :*/
			'<input type="text"  readonly="true" id="standar" name="standar" value="'.$dt['jml_standar'].'" >&nbsp;'
			."<input type='button' id='btcek_jmlstandar' name='btcek_jmlstandar' value='Cek' onclick='rkb.cekJmlBrgStandar()' title='Cek Jumlah Standar Kebutuhan'>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Info Maks Rencana : ".
			"<input name=\"jml_max\" id='jml_max' type=\"text\" value='".$dt['jml_max']."' readonly/>"
			;
			
		$vjmlharga = //$this->form_fmST==1?
			//number_format($dt['jml_harga'],0,',','.') :
			"<input type='text'  readonly='true' id='cnt_jmlharga' name='cnt_jmlharga' value='".number_format($dt['jml_harga'],0,',','.')."' >
			<input type='button' value='Hitung' onclick=\"
				document.getElementById('cnt_jmlharga').innerHTML = 
					Kali('jml_barang', 'harga', 'cnt_jmlharga')\">&nbsp&nbsp
			<!--<span id='cnt_jmlharga'>".number_format($dt['jml_harga'],0,',','.')."</span>-->";
				 
			
		
		$title = $this->form_fmST == 1? 'Rencana Kebutuhan Barang Milik Daerah - Edit' : 'Rencana Kebutuhan Barang Milik Daerah - Baru';
		$this->form_fields = array(	
			'title' => array('label'=>'','value'=>'<div style="font-size: 18px;font-weight: bold;color: #C64934;margin:0 0 10 0">'.$title.'</div>', 'type'=>'merge' ),			
			'bidang' => array( 'label'=>'BIDANG', 
				'value'=>$bidang, 
				'type'=>'', 'row_params'=>"height='21'"
			),
			'unit' => array( 'label'=>'SKPD', 
				'value'=>$unit, 
				'type'=>'', 'row_params'=>"height='21'"
			),
			'subunit' => array( 'label'=>'UNIT', 
				'value'=>$subunit, 
				'type'=>'', 'row_params'=>"height='21'"
			),
			'seksi' => array( 'label'=>'SUB UNIT', 
				'value'=>$seksi, 
				'type'=>'', 'row_params'=>"height='21'"
			),
			'tahun' => array(  'label'=>'Tahun', 
				'value'=> $vtahun
				,'labelWidth'=>170, 'row_params'=>"height='21'", 'type'=>'' 
			),
			'nm_barang' => array(  'label'=>'Nama Barang', 
				'value'=> $vkdbarang,
				'labelWidth'=>170, 'row_params'=>"height='21'", 'type'=>'' 
			),
			'nm_akun' => array( 'label'=>'Nama Akun', 
				'value'=>$vkdrekening,
				'type'=>''  
			),
			'jmlbi' => array(  'label'=>'Jumlah Inventaris', 
				'value'=> $vjmlbi				
				,'labelWidth'=>170, 'row_params'=>"height='21'", 'type'=>'' 
			),
			'divJmlBrgBi' => array(  'label'=>'', 
				'value'=> "<div id='divJmlBrgBi' name='divJmlBrgBi'></div>"				
				, 'type'=>'' , 'pemisah'=>' '
			),
			
			'standar' => array(  'label'=>'Jumlah Standar Kebutuhan', 
				'value'=> $vstandar
					
					//."<input type='button' id='btcek_jmlbi' name='btcek_jmlbi' value='Cek' onclick='rkb.getStandar()' title='Cek Jumlah Standar'>"
				,'labelWidth'=>170, 'row_params'=>"height='21'", 'type'=>'' 
			),
			
			'jml_brg_sblm' => array(  'label'=>'Jumlah Rencana Tahun Sebelum', 
				'value'=> 
					"<input name=\"jml_brg_sblm\" id='jml_brg_sblm' type=\"text\" value='".$dt['jml_brg_sblm']."' readonly/>", 
					//inputFormatRibuan("jml_barang", '',$dt['jml_barang']) ,
				'type'=>'' 
			),
			
			'jml_barang' => array(  'label'=>'Jumlah Rencana Barang', 
				'value'=> 
					"<input name=\"jml_barang\" id='jml_barang' type=\"text\" value='".$dt['jml_barang']."' />".
					"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					Satuan Barang &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ".
					"<input name=\"satuan\" id='satuan' type=\"text\" value='".$dt['satuan']."' />", 
					//inputFormatRibuan("jml_barang", '',$dt['jml_barang']) ,
				'type'=>'' 
			),
					
			'harga' => array( 'label'=>'Harga Satuan Barang', 
				'value'=>"<input name=\"harga\" id=\"harga\" type=\"text\" value='".$dt['harga']."' />&nbsp;".
				//inputFormatRibuan("harga", '',$dt['harga']).
				"<input type='button' value='Info' onclick=\"".$this->Prefix.".Info()\">" ,
				'type'=>'' 
			),
			'jml_harga' => array( 'label'=>'Jumlah Harga', 
				'value'=> $vjmlharga ,
				'type'=>'' 
			),
			'merk' => array(  'label'=>'Merk / Type / Ukuran / Spesifikasi', 
				'value'=> "<textarea name=\"fmMEREK\" cols=\"60\" style='margin: 2px;width: 438px; height: 51px;'>".$dt['merk_barang']."</textarea>", 
				//'params'=>"valign='top'",
				'type'=>'' , 'row_params'=>"valign='top'"
			),	
			
			'ket' => array( 'label'=>'Keterangan', 
				'value'=>"<textarea name=\"fmKET\" cols=\"60\" style='margin: 2px;width: 438px; height: 51px;' >".$dt['ket']."</textarea>", 
				'type'=>'', 'row_params'=>"valign='top'"
			),
			'menu'=> array( 'label'=>'', 
				'value'=>
				"<input type=hidden id='c' name='c' value='".$dt['c']."'> ".
				"<input type=hidden id='d' name='d' value='".$dt['d']."'> ".
				"<input type=hidden id='e' name='e' value='".$dt['e']."'> ".
				"<input type=hidden id='e1' name='e1' value='".$dt['e1']."'> ".
				$menu,
				'type'=>'merge'
			)
		);
		
				
		//tombol
		$this->form_menubawah = ''
			/*"<input type=hidden id='c' name='c' value='".$dt['c']."'> ".
			"<input type=hidden id='d' name='d' value='".$dt['d']."'> ".
			"<input type=hidden id='e' name='e' value='".$dt['e']."'> "
			//"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' >".
			//"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >"
			*/
			;
		
		$this->genForm_nodialog();
		//$form = $this->genForm(FALSE);		
				
		//$content = $form;//$content = 'content';
		//return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	

	
	function Hapus_Validasi($id){
		$err ='';
		//$KeyValue = explode(' ',$id);
		$old = mysql_fetch_array(mysql_query(
			"select * from $this->TblName where id ='$id' "
		));
		if($err=='' && $old['stat']=='1') $err = 'Data Tidak Bisa Dihapus, RKB sudah DKB!';
		
		return $err;
	}
	
			
	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){
			case 'formBaru2':{				
				//echo 'tes';
				$this->setFormBaru();				
				//$cek = $fm['cek'];
				//$err = $fm['err'];
				//$content = $fm['content'];
				$json = FALSE;				
				break;
			}
			
			case 'formInfo':{								
				$this->setFormInfo();				
				$json = FALSE;				
				break;
			}
			
			case 'formEdit2':{								
				$this->setFormEdit();				
				$json = FALSE;				
				break;
			}
			case 'simpan2' : {
				$get = $this->simpan2();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 
				break;
			}
			case 'getJmlBrgBI':{
				$get = $this->getJmlBrgBI();
				$cek = $get['cek']; $err = $get['err']; $content=$get['content']; 
				break;
			}
			case 'getJmlBrgStandar':{
				$get = $this->getJmlBrgStandar();
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
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function genDaftarInitial(){
		global $HTTP_COOKIE_VARS;
		$TampilOpt = $this->genDaftarOpsi();
		
		return		
			//$NavAtas.	
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 
			//$vOpsi['TampilOpt'].
			"<input type='hidden' id='c' name='c' value='".$_REQUEST['c']."'>".
			"<input type='hidden' id='d' name='d' value='".$_REQUEST['d']."'>".
			"<input type='hidden' id='tahun' name='tahun' value='".$_REQUEST['tahun']."'>".
			//"<input type='hidden' id='skpd_distribusifmBidang' name='skpd_distribusifmBidang' value='".$skpd."'>".
			//"<input type='hidden' id='skpd_distribusifmBagian' name='skpd_distribusifmBagian' value='".$unit."'>".
			//"<input type='hidden' id='skpd_distribusifmSubBagian' name='skpd_distribusifmSubBagian' value='".$subunit."'>".
			"</div>".					
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".	
				//$this->genDaftar($Opsi['Kondisi'],$Opsi['Order'], $Opsi['Limit'], $Opsi['NoAwal']).									
			"</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
				//"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
			"</div>";
	}
	
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		
		$fmBIDANG = cekPOST('fmBidang'); //echo 'fmskpd='.$fmSKPD;
		$fmSKPD = cekPOST('fmSkpd');
		$fmTahun = cekPOST('tahun');
		//$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		//$fmSEKSI = cekPOST($this->Prefix.'SkpdfmSEKSI');

		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>	
			<table width=\"100%\" border=\"0\">
				<tr>
					<td class=\"subjudulcetak\">
						<table cellpadding='0' cellspacing='0' border='0' width=\"100%\">
							<tbody>
								<tr valign='top'> 
									<td style='font-weight:bold;font-size:10pt' width='70'>BIDANG</td>
									<td style='width:10;font-weight:bold;font-size:10pt'>:</td>
									<td style='font-weight:bold;font-size:10pt'>$fmBIDANG</td> 
								</tr> 
								<tr valign='top'> 
									<td style='font-weight:bold;font-size:10pt'>SKPD</td>
									<td style='width:10;font-weight:bold;font-size:10pt'>:</td>
									<td style='font-weight:bold;font-size:10pt'>$fmSKPD</td> 
								</tr> 
								<tr valign='top'> 
									<td style='font-weight:bold;font-size:10pt'>TAHUN</td>
									<td style='width:10;font-weight:bold;font-size:10pt'>:</td>
									<td style='font-weight:bold;font-size:10pt'>$fmTahun</td> 
								</tr> 
								
								<!--<tr valign='top'> <td style='font-weight:bold;font-size:10pt'>UNIT</td><td style='width:10;font-weight:bold;font-size:10pt'>:</td><td style='font-weight:bold;font-size:10pt'> </td> </tr> 
								<tr valign='top'> <td style='font-weight:bold;font-size:10pt'>SUB UNIT</td><td style='width:10;font-weight:bold;font-size:10pt'>:</td><td style='font-weight:bold;font-size:10pt'> </td> </tr>--> 
							
							</tbody>
						</table>
					</td>
				</tr>
			</table>
			<br>";
	}
	
	function genCetak($xls= FALSE, $Mode=''){
		global $Main;
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
		$this->cetak_xls=$xls;
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
		if($this->Cetak_Mode==3){//flush
			$this->genDaftar(	$Opsi['Kondisi'], $Opsi['Order'], $Opsi['Limit'], $Opsi['NoAwal'], $this->Cetak_Mode, $Opsi['vKondisi_old']);
		}else{
			$daftar = $this->genDaftar(	$Opsi['Kondisi'], $Opsi['Order'], $Opsi['Limit'], $Opsi['NoAwal'], $this->Cetak_Mode, $Opsi['vKondisi_old']);
			echo $daftar['content'];
		}								
		echo	"</div>	".			
				$this->setCetak_footer($xls).
			"</td></tr>
			</table>
			</div>
			</form>		
			</body>	
			</html>";
	}
	
}
$Rekaprpebmd_skpd_rinci = new Rekaprpebmd_skpd_rinciObj();

?>