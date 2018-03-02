<?php

class pemindahtanganan_insObj extends DaftarObj2{
	var $Prefix = 'pemindahtanganan_ins';
	var $SHOW_CEK = TRUE;	
	var $TblName = 'pemindahtanganan';//view2_sensus';
	var $TblName_Hapus = 'pemindahtanganan';
	var $TblName_Edit = 'pemindahtanganan';
	var $KeyFields = array('id');
	var $FieldSum = array('nilai_buku','nilai_susut');
	var $SumValue = array('nilai_buku','nilai_susut');
	var $FieldSum_Cp1 = array( 9, 8, 8);
	var $FieldSum_Cp2 = array( 3, 3, 3);	
	var $FormName = 'pemindahtanganan_insForm';
	var $pagePerHal = 25;
	
	var $PageTitle = 'PEMINDAHTANGANAN';
	var $PageIcon = 'images/penatausahaan_ico.gif';
	var $ico_width = '20';
	var $ico_height = '30';
	
	var $fileNameExcel='Daftar PEMINDAHTANGANAN.xls';
	var $Cetak_Judul = 'PEMINDAHTANGANAN';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $fmST = 0;
	var $idpilih = '';
	//var $row_params= " valign='top'";
	
	
	function setTitle(){
		global $Main;
		return 'PEMINDAHTANGANAN';	

	}
	
	function setNavAtas(){
		return
			/*'<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td class="menudottedline" width="60%" height="20" style="text-align:right"><b>
				<a href="pages.php?Pg=lra" title="Daftar LRA">DAFTAR LRA</a> 
				  &nbsp;&nbsp;&nbsp;
			</b></td>
			</tr>
			</table>';	*/"";
	}
	
	function setMenuEdit(){		
		return "";
			/*"<td>".genPanelIcon("javascript:".$this->Prefix.".sotkbaru()","mutasi.png","Mutasi", 'Mutasi')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Batal", 'Batal')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Report()","edit_f2.png","Report", 'Report')."</td>";*/
	}
	
	function setMenuView(){		
		return 			"";
			/*"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakHal(\"$Op\")","print_f2.png",'Halaman',"Cetak Daftar per Halaman")."</td>".			
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".cetakAll(\"$Op\")","print_f2.png",'Cetak',"Cetak Daftar")."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".exportXls(\"$Op\")","export_xls.png",'Excel',"Export Excel")."</td>";*/					

	}
	
	function Simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 global $fmTglBuku;	
	
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 //$idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $jmldata = $_REQUEST['jmldata'];
	 $idubah = $_REQUEST['idubah'];
	 $cbid = $_REQUEST['cidBI'];	
	 $idubah= $_REQUEST['idubah'];
	 $idplh = str_replace(" ",",",$idubah);
	 $gen_tgl = $_REQUEST['tgl_buku'].'-'.$_REQUEST['thn_buku'];	 
	 $tgl_buku = date('Y-m-d', strtotime($gen_tgl));
	 $no_sk= $_REQUEST['no_sk'];
	 $tgl_sk= date('Y-m-d', strtotime($_REQUEST['tgl_sk']));
	 $fmBENTUKPEMINDAHTANGANAN= $_REQUEST['fmBENTUKPEMINDAHTANGANAN'];
	 $ket= $_REQUEST['ket'];
	 //$err.='tgll='.$tgl_sk;
	
	if($err=='' && $no_sk=='') $err = 'NOMOR belum diisi !';
	if($err=='' && $_REQUEST['tgl_sk']=='' )$err = 'TANGGAL belum diisi!';
	if($err=='' && $_REQUEST['tgl_buku']=='') $err = 'TANGGAL BUKU belum diisi!';	
	if($err=='' && !cektanggal($tgl_buku)) $err = 'TANGGAL BUKU salah!';
	if($err =='' && compareTanggal($tgl_buku, date('Y-m-d'))==2  ) $err = 'TANGGAL BUKU tidak lebih besar dari Hari ini!';				
	if($err=='' && $fmBENTUKPEMINDAHTANGANAN=='') $err = 'BENTUK PEMINDAHTANGANAN belum dipilih !';	
	//$err="select * from buku_induk where id in ($idplh) and idawal not in(select idbi_awal from pemindahtanganan where idbi_awal in($idplh) )";
		
		if($err==''){
			$limit=2;
			$getcnt = "select * from buku_induk where id in ($idplh) and status_barang=1 and id not in(select id_bukuinduk from pemindahtanganan )limit 0,$limit";			
			$jml = mysql_num_rows(mysql_query($getcnt));
			$content->jml = $jml;	
				$result = mysql_query($getcnt);
				while($old = mysql_fetch_array($result)){
					$idbiawal = $old['idawal'];
					$idbi = $old['id'];
					$staset = $old['staset'];
					$a1_awal = $old['a1'];
					$a_awal = $old['a'];
					$b_awal = $old['b'];
					$c1_awal = $old['c1'];
					$c_awal = $old['c'];
					$d_awal = $old['d'];
					$e_awal = $old['e'];
					$e1_awal = $old['e1'];
					$f_awal = $old['f'];
					$g_awal = $old['g'];
					$h_awal = $old['h'];
					$i_awal = $old['i'];
					$j_awal = $old['j'];
					$kondisi = $old['kondisi'];
					$noreg = $old['noreg'];
					$thn_perolehan = $old['thn_perolehan'];
					$nilai_buku = getNilaiBuku($idbi,$tgl_buku,0);
					$nilai_susut = getAkumPenyusutan($idbi,$tgl_buku);	
						
					if($err==''){
						//insert pemindahtanganan
						$exequery= "INSERT pemindahtanganan (id_bukuinduk,uid,tgl_pemindahtanganan,bentuk_pemindahtanganan,".
						"nosk,tglsk,ket,nilai_buku,nilai_susut,idbi_awal,staset)".
						"values ('$idbi','$uid','$tgl_buku','$fmBENTUKPEMINDAHTANGANAN','$no_sk','$tgl_sk',".
						"'$ket','$nilai_buku','$nilai_susut','$idbiawal','$staset')";
						$qry = mysql_query($exequery);
						//$cek.='cek='.$exequery;							
					}
				}//end while	
		}//end if		
		//$content->msg_error = $err;				
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function genDaftarOpsi(){
		global $Main,$fmFiltThnBuku,$HTTP_COOKIE_VARS;
		Global $fmSKPDUrusan,$fmSKPDBidang2,$fmSKPDskpd2,$fmSKPDUnit2,$fmSKPDSubUnit2;
		 $fmSKPDUrusan = $_REQUEST['fmSKPDUrusan'];//cekPOST('fmSKPDUrusan');
		 $fmSKPDBidang2 = $_REQUEST['fmSKPDBidang2'];//cekPOST('fmSKPDBidang2');
		 $fmSKPDskpd2 = $_REQUEST['fmSKPDskpd2'];//cekPOST('fmSKPDskpd2');
		 $fmSKPDUnit2 = $_REQUEST['fmSKPDUnit2'];//cekPOST('fmSKPDUnit2');
		 $fmSKPDSubUnit2 = $_REQUEST['fmSKPDSubUnit2'];//cekPOST('fmSKPDSubUnit2');
		$thn_login = $HTTP_COOKIE_VARS['coThnAnggaran'];
		if(isset($_REQUEST['databaru'])){
		if(addslashes($_REQUEST['databaru'] == '1')){			
			$cekid = explode(" ",$_REQUEST['idubah']);
			$jmlcek = count($cekid);			
			$uid = $HTTP_COOKIE_VARS['coID'];			
			$tgl_buku = date('d-m');	
		}else{			
			$IDUBAH = $_REQUEST['idubah'];
			$tgl_buku = date($thn_login.'-m-d');	
		}
	}
	$tgl_sk = date('d-m-').$thn_login;	
	$progress = 
			"<div id='progressbox' style='display:block;'>".
			"<div id='progressbck' style='display:block;width:520px;height:4px;background-color:silver; margin: 6 5 0 0;float:left;border-radius: 3px;'>".
			"<div id='progressbar' style='height:2px;margin:1;width:0%;border-radius: 3px;background-color: green;'></div>".
			"</div>".
			"<div id ='progressmsg' name='progressmsg' style='float:left;'></div>".
			"</div>".
			"<div id ='progreserrormsg' name='progreserrormsg' style='float:left;width:100%;'></div></br>".
			"<div id='' style='float:right; padding: 2 0 0 0'>".
			"<img id='daftaropsierror_slide_img' src='' onclick='".$this->Prefix.".daftaropsierror_click(270)' style='cursor:pointer'>".
			"</div>".
			"<div id='daftaropsisusuterror_div' style='height: 0px; overflow-y: hidden;float:left;'>".
			"<div id ='progreserror' name='progreserror'></div>".
			"</div>".			
			"<input type=hidden id='jmldata' name='jmldata' value='".$jmlcek."'> ".
			"<input type=hidden id='prog' name='prog' value='0'> ";
		$TampilOpt =
			$vOrder=
			genFilterBar(
				array(
					$this->isiform(
						array(
							array(
								'label'=>'JUMLAH DATA BARANG',
								'name'=>'urusan',
								'label-width'=>'200px;',
								'type'=>'margin',
								'value'=>$jmlcek.' data',
								'align'=>'left',
								'parrams'=>"",
							),
						)
					)
				
				),'','','').
				genFilterBar(
				array(
					"<span id='inputpenerimaanbarang' style='color:black;font-size:14px;font-weight:bold;'/>SK PEMINDAHTANGANAN</span>",
				),'','','').
				genFilterBar(
				array(
					$this->isiform(
						array(	
							array(
								'label'=>'&nbsp;&nbsp;&nbsp;NOMOR',
								'name'=>'no_sk',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='no_sk' id='no_sk' value='' size=29/>",
							),							
							array(
								'label'=>'&nbsp;&nbsp;&nbsp;TANGGAL',
								'name'=>'tgl_sk',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='tgl_sk' id='tgl_sk' value='$tgl_sk' class='datepicker2' size='6'>"
								,
							),
							array(
								'label'=>'TANGGAL BUKU',
								'name'=>'tgl_buku',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='tgl_buku' id='tgl_buku' value='$tgl_buku' size='1' class='datepicker'><input type='text' name='thn_buku' id='thn_buku' value='$thn_login' size='4' readonly>"
								//'value'=>createEntryTgl3($tgl_buku, 'tgl_buku', false,'')
										
								,
							),
							array(
									'label'=>'BENTUK PEMINDAHTANGANAN ',
									'name'=>'fmBENTUKPEMINDAHTANGANAN',
									'label-width'=>'200px;',
									'value'=>cmb2D('fmBENTUKPEMINDAHTANGANAN',$fmBENTUKPEMINDAHTANGANAN,$Main->BentukPemindahtanganan,''),
							),
							array(
									'label'=>'KETERANGAN ',
									'name'=>'ket_koreksi',
									'label-width'=>'200px;',
									'value'=>"<textarea id='ket' name='ket' style='width: 234px;height: 35px;'>".$dt['ket']."</textarea>",
							),
						)						
					)				
				),'','','').
				genFilterBar(
					array(
					"<table>
						<tr>
							<td>
							$progress
							</td>
						</tr>
					</table>
					<table>						
						<tr>
							<td>".$this->buttonnya(''.$this->Prefix.'.Simpan()','save_f2.png','SIMPAN','SIMPAN','SIMPAN')."</td>
							<td>".$this->buttonnya('javascript:window.close();window.opener.location.reload();','cancel_f2.png','TUTUP','TUTUP','TUTUP')."</td>
						</tr>".
					"</table>"
				),'','','')
			;
		
		return array('TampilOpt'=>$TampilOpt);
		
	
	}
	
	function isiform($value){
		$isinya = '';
		$tbl ='<table width="100%">';
		for($i=0;$i<count($value);$i++){
			if(!isset($value[$i]['align']))$value[$i]['align'] = "left";
			if(!isset($value[$i]['valign']))$value[$i]['valign'] = "top";
			
			if(isset($value[$i]['type'])){
				switch ($value[$i]['type']){
					case "text" :
						$isinya = "<input type='text' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
					break;
					case "hidden" :
						$isinya = "<input type='hidden' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
					break;
					case "password" :
						$isinya = "<input type='password' name='".$value[$i]['name']."' id='".$value[$i]['name']."' ".$value[$i]['parrams']." value='".$value[$i]['value']."' />";
					break;
					default:
						$isinya = $value[$i]['value'];
					break;					
				}
			}else{
				$isinya = $value[$i]['value'];
			}
			
			$tbl .= "
				<tr>
					<td width='".$value[$i]['label-width']."' valign='top'>".$value[$i]['label']."</td>
					<td width='10px' valign='top'>:<br></td>
					<td align='".$value[$i]['align']."' valign='".$value[$i]['valign']."'> $isinya</td>
				</tr>
			";		
		}
		$tbl .= '</table>';
		
		return $tbl;
	}
	
	function buttonnya($js,$img,$name,$alt,$judul){
		return "<table cellpadding='0' cellspacing='0' border='0' id='toolbar'>
					<tbody><tr valign='middle' align='center'> 
					<td class='border:none'> 
						<a class='toolbar' id='btsave' 
							href='javascript:$js'> 
						<img src='images/administrator/images/$img' alt='$alt' name='$name' width='32' height='32' border='0' align='middle' title='$judul'> $judul</a> 
					</td> 
					</tr> 
					</tbody></table> ";
	}
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		global $fmPILCARI;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST($this->Prefix.'SkpdfmSKPD');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		$fmSEKSI = isset($HTTP_COOKIE_VARS['cofmSEKSI'])? $HTTP_COOKIE_VARS['cofmSEKSI']: cekPOST($this->Prefix.'SkpdfmSEKSI');

		$arrKondisi[] = 
		//$tes =
		getKondisiSKPD3(
			$Main->DEF_KEPEMILIKAN, 
			$Main->Provinsi[0], 
			$Main->DEF_WILAYAH, 
			$fmSKPD, 
			$fmUNIT, 
			$fmSUBUNIT,
			$fmSEKSI
		);
		
		$fmCariComboIsi = cekPOST('fmCariComboIsi');
		$fmCariComboField = cekPOST('fmCariComboField');
		if (!empty($fmCariComboIsi) && !empty($fmCariComboField)) {
			//if ($fmCariComboField != 'ket' && $fmCariComboField != 'Cari Data') {
			if ($fmCariComboField != 'Cari Data') {
			//if(  $fmCariComboField == 'nm_barang'){
				
			//	$Kondisi .=  " and  concat(f,g,h,i,j) in (  select concat(f,g,h,i,j) from ref_barang where nm_barang like '%$fmCariComboIsi%' ) ";
			//}else{
				$arrKondisi[] = " $fmCariComboField like '%$fmCariComboIsi%' ";
			//}
				
			}
		}
		
		$arrKondisi[] = "status_barang <> '3' and status_barang <> '4' and status_barang <> '5'";
		
		$fmStMutasi=  cekPOST('stmutasi');
		$fmStAset=  cekPOST('staset');
		$fmThn2=  cekPOST('fmThn2');
		$fmSemester = cekPOST('fmSemester');
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
			switch($fmORDER1){
				//case '': $arrOrders[] = " tgl DESC " ;break;
				case '1': $arrOrders[] = " thn_perolehan $Asc1 " ;break;
				case '2': $arrOrders[] = " kondisi $Asc1 " ;break;
				case '3': $arrOrders[] = " year(tgl_buku) $Asc1 " ;break;			
			
			}
			$arrOrders [] = " a1,a,b,c,d,e,e1,f,g,h,i,j,tahun,noreg";
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
		$jmPerHal = cekPOST("jmPerHal"); 
		$Main->PagePerHal = !empty($jmPerHal) ? $jmPerHal : $Main->PagePerHal;
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
	
	function pageShow(){
		global $app, $Main; 
		
		$navatas_ = $this->setNavAtas();
		$navatas = $navatas_==''? // '0': '20';
			'':
			"<tr><td height='20'>".
					$navatas_.
			"</td></tr>";
		$form1 = $this->withform? "<form name='$this->FormName' id='$this->FormName' method='post' action=''>" : '';
		$form2 = $this->withform? "</form >": '';
		
		$cbid = $_REQUEST['cidBI'];
		$idplh = implode(" ",$cbid);
		
		return
		
		//"<html xmlns='http://www.w3.org/1999/xhtml'>".			
		"<html>".
			$this->genHTMLHead().
			"<body >".
			/*"<div id='pageheader'>".$this->setPage_Header()."</div>".
			"<div id='pagecontent'>".$this->setPage_Content()."</div>".
			$Main->CopyRight.*/
							
			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0' width='100%' height='100%' >".
				//header page -------------------		
				"<tr height='34'><td>".					
					//$this->setPage_Header($IconPage, $TitlePage).
					$this->setPage_Header().
					"<div id='header' ></div>".
				"</td></tr>".	
				$navatas.			
				//$this->setPage_HeaderOther().
				//Content ------------------------			
				//style='padding:0 8 0 8'
				"<tr height='*' valign='top'> <td >".
					
					$this->setPage_HeaderOther().
					"<div align='center' class='centermain' >".
					"<div class='main' >".
					$form1.
					"<input type='hidden' name='databaru' id='databaru' value='".$_REQUEST['baru']."' />".
					"<input type='hidden' name='idubah' id='idubah' value='".$idplh."' />".
					
						//Form ------------------
						//$hidden.					
						//genSubTitle($TitleDaftar,$SubTitle_menu).						
						$this->setPage_Content().
						//$OtherInForm.
						
					$form2.//"</form>".
					"</div></div>".
				"</td></tr>".
				//$OtherContentPage.				
				//Footer ------------------------
				"<tr><td height='29' >".	
					//$app->genPageFoot(FALSE).
					$Main->CopyRight.							
				"</td></tr>".
				$OtherFooterPage.
			"</table>".
			/*'<script src="assets2/js/bootstrap.min.js"></script>'.
			'<script src="assets2/jquery.min.js"></script>'.*/
			"</body>
		</html>"; 
	}	
	
	function setPage_OtherScript(){
		global $HTTP_COOKIE_VARS;
		$thn_anggaran = $_COOKIE['coThnAnggaran'];
		
		$scriptload = 
		"<script>
		$(document).ready(function()
		{
			".$this->Prefix.".loading();
			setTimeout(function myFunction(){".$this->Prefix.".AftFilterRender()},1000);
			setTimeout(function myFunction(){".$this->Prefix.".AftFilterRender2()},1000);
			
		}
		);
		</script>";
		return  	
		"<link href='datepicker/jquery-ui.css' type='text/css' rel='stylesheet'  >".
		"<script src='datepicker/jquery-1.12.4.js' type='text/javascript' language='JavaScript'></script>".
		"<script src='datepicker/jquery-ui.js' type='text/javascript' language='JavaScript' ></script>".
		//"<script src='js/skpd.js' type='text/javascript'></script>".
		"<script type='text/javascript' src='js/pemindahtanganan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
		$scriptload;
	}
	
	function setKolomHeader($Mode=1, $Checkbox=''){
		$cetak = $Mode==2 || $Mode==3 ;
		
			
		$headerTable =
				"<tr>
				<th class='th02'colspan=4>Nomor</th>
				<th class='th02'colspan=3>Spesifikasi Barang</th>
				<!--<th class='th01'rowspan=2>Bahan</th>
				<th class='th01'rowspan=2>Cara Perolehan/<br>Sumber Dana</th>-->
				<th class='th01'rowspan=2>Tahun <br> Perolehan</th>
				<th class='th02'colspan=3>Jumlah</th>
				<th class='th02'colspan=2>Mutasi ke SOTK Baru</th>
				</tr>
				
				<tr>
				<th class='th01' width='20' rowspan=2>No.</th>
  	  			$Checkbox 		
				<th class='th01'>Kode Barang/ <br> ID Barang</th>
				<th class='th01'>Reg</th>
				<th class='th01'>Nama/ Jenis Barang</th>
				<th class='th01'>Merk/ Type/ Lokasi</th>
				<th class='th01'>No. Sertifikat/ <br>No. Pabrik</th>
				<th class='th01'>Barang</th>
				<th class='th01'>Harga</th>
				<th class='th01'>Akumulasi<br>Penyusutan</th>
				<th class='th01'>Kode/Nama</th>
				<th class='th01'>BAST</th>
				</tr>
				
				";
				
		return $headerTable;
	}
	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref;
		$arrStatus = array ('','','', 'Batal','Dihapus');
		
		$kode_brg = $isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'];
		
		//--- ambil data kib by noreg --------------------------------				
					if ($isi['f'] == "01" || $isi['f'] == "02" || $isi['f'] == "03" || $isi['f'] == "04" || $isi['f'] == "05" || $isi['f'] == "06" || $isi['f'] == "07") {
						$KondisiKIB = "
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
						tahun = '{$isi['tahun']}' ";
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
		$tampilHarga = !empty($cbxDlmRibu)? number_format($isi['nilai_buku']/1000, 2, ',', '.') : number_format($isi['nilai_buku'], 2, ',', '.');
		$tampilAkumSusut = !empty($cbxDlmRibu)? number_format($isi['nilai_susut']/1000, 2, ',', '.') : number_format($isi['nilai_susut'], 2, ',', '.');
		$jns_hibah = $isi['jns_hibah'] == 0?'':$isi['jns_hibah'];
		$Koloms = array();
		$Koloms[] = array('align=right', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array('', $kode_brg.'/<br>'.$isi['id']);		
		$Koloms[] = array('', $isi['noreg']);		
		$Koloms[] = array('', $isi['nm_barang']);
		
		$Koloms[] = array('', $ISI5 );
		$Koloms[] = array('', $ISI6 );
		//$Koloms[] = array('', $ISI7 );
		//$Koloms[] = array('', $Main->AsalUsul[$isi['asal_usul']-1][1]."<br>/".$jns_hibah."<br>/".$Main->StatusBarang[$isi['status_barang']-1][1] );
		
		$Koloms[] = array('', $isi['thn_perolehan'] );
		$Koloms[] = array('', $isi['jml_barang']." ".$isi['satuan'] );
		$Koloms[] = array('align=right', $tampilHarga );
		$Koloms[] = array('align=right', $tampilAkumSusut );
		$Koloms[] = array('', );
		$Koloms[] = array('',  );
		
		return $Koloms;
	}	
	
	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){
			case 'simpan':{
				$get= $this->Simpan();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
}
$pemindahtanganan_ins = new pemindahtanganan_insObj();

?>