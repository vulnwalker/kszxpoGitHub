<?php

class kirObj extends DaftarObj2{
	var $Prefix = 'kir';
	var $SHOW_CEK = TRUE;	
	var $TblName = 'view_buku_induk2';//view2_sensus';
	var $TblName_Hapus = 'view_buku_induk2';
	var $TblName_Edit = 'view_buku_induk2';
	var $KeyFields = array('no_ba,c1,c,d,e,e1');
	var $FieldSum = array('nilai_buku','nilai_susut');
	var $SumValue = array('nilai_buku','nilai_susut');
	var $FieldSum_Cp1 = array( 9, 8, 8);
	var $FieldSum_Cp2 = array( 3, 3, 3);	
	var $FormName = 'kirForm';
	var $pagePerHal = 25;
	
	var $PageTitle = 'Kartu Inventaring Ruangan';
	var $PageIcon = 'images/penatausahaan_ico.gif';
	var $ico_width = '20';
	var $ico_height = '30';
	
	var $fileNameExcel='Daftar Kartu Inventaring Ruangan.xls';
	var $Cetak_Judul = 'Kartu Inventaring Ruangan ';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $fmST = 0;
	var $idpilih = '';
	
	function setTitle(){
		global $Main;
		return 'Kartu Inventaring Ruangan';
	}
	
	function setNavAtas(){
		return "";
	}
	
	function setMenuEdit(){		
		return "";
	}
	
	function setMenuView(){		
		return "";
	}
	
	function genDaftarOpsi(){
		global $Main,$HTTP_COOKIE_VARS;
		$thn_login = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$idplh = $_REQUEST['idplh'];
		$cekid = explode(" ",$idplh);
		$jmlcek = count($cekid);			
		$uid = $HTTP_COOKIE_VARS['coID'];		
		
			$TampilOpt =
			$vOrder=
			genFilterBar(
				array(
					$this->isiform(
						array(
							array(
								'label'=>'JUMLAH DATA BARANG',
								'name'=>'jml',
								'label-width'=>'200px;',
								'type'=>'margin',
								'value'=>$jmlcek.' data',
								'align'=>'left',
								'parrams'=>"",
							),				
							array(
								'label'=>'GEDUNG / RUANG',
								'name'=>'no_bast',
								'label-width'=>'200px;',
								'value'=>"<input type='text' id='nm_gedung' value='".$gedung['nm_ruang']."' readonly='true' style='width:205'>".
			' &nbsp; / &nbsp; '.
			" <input type='text' id='nm_ruang' value='".$ruang['nm_ruang']."' readonly='true' style='width:205'>".			
			" <input type='hidden' id='ref_idruang' name='ref_idruang' value='".$ref_idruang."'><input type='button' value='Pilih' onclick='".$this->Prefix.".pilihRuang()'>",
							),	
						)
					)
				
				),'','','').
				genFilterBar(
					array(
					"<table>							
						<tr>
							<td>".$this->buttonnya(''.$this->Prefix.'.Simpan();','save_f2.png','SIMPAN','SIMPAN','SIMPAN')."</td>
							<td>".$this->buttonnya('window.close();window.opener.location.reload();','cancel_f2.png','TUTUP','TUTUP','TUTUP')."</td>
						</tr>".
					"</table>"
				),'','','')
			;
		
		return array('TampilOpt'=>$TampilOpt);
		
	
	}
	
	function genFilterBar($Filters, $onClick, $withButton=TRUE, $TombolCaption='Tampilkan', $Style='FilterBar' ,$idbar=''){
	$Content=''; $i=0;
	while( $i < count($Filters) ){
		$border	= $i== count($Filters)-1 ? '' : "border-right:1px solid #E5E5E5;";		
		$Content.= "<td  align='left' style='padding:1 8 0 8; $border'>".
						$Filters[$i].
					"</td>";
		$i++;
	}
	//tombol
	if($withButton){
		$Content.= "<td  align='left' style='padding:1 8 0 8;'>
					<input type=button id='btTampil' value='$TombolCaption' 
						onclick=\"$onClick\">
				</td>";		
	}
		
	/*return  "
		<table class='$Style' width='100%' style='margin: 4 0 0 0' cellspacing='0' cellpadding='0' border='0'>
		<tr><td>
			<table cellspacing='0' cellpadding='0' border='0'>
			<tr valign='middle'>   						
				$Content				
			</tr>
			</table>
		</td><td width='*'>&nbsp</td></tr>		
		</table>";	*/
	return  "
		<!--<table class='$Style' width='100%' style='margin: 4 0 0 0' cellspacing='0' cellpadding='0' border='0'>
		<tr><td> -->
		<div class='$Style' id='$idbar' style='display:none;'>
			<table style='width:100%'><tr><td align=left>
			<table cellspacing='0' cellpadding='0' border='0' style='height:28'>
			<tr valign='middle'>   						
				$Content				
			</tr>
			</table>
			</td></tr></table>
		</div>
		<!--</td><td width='*'>&nbsp</td>
		</tr>		
		</table>-->
		
		";	
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
					/*"<input type='hidden' name='urusan_lama' id='urusan_lama' value='".$_REQUEST['fmURUSAN']."' />".
					"<input type='hidden' name='skpd_lama' id='skpd_lama' value='".$_REQUEST['fmSKPD']."' />".
					"<input type='hidden' name='unit_lama' id='unit_lama' value='".$_REQUEST['fmUNIT']."' />".
					"<input type='hidden' name='subunit_lama' id='subunit_lama' value='".$_REQUEST['fmSUBUNIT']."' />".
					"<input type='hidden' name='seksi_lama' id='seksi_lama' value='".$_REQUEST['fmSEKSI']."' />".*/
					"<input type='hidden' name='idplh' id='idplh' value='".$idplh."' />".
					
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
		}
		);
		</script>";
		return  	
		"<script src='js/skpd.js' type='text/javascript'></script>".
		"<script src='js/ruang.js' type='text/javascript'></script>".
		"<script type='text/javascript' src='js/kir/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
		$scriptload;
	}
	
	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){
			case 'simpan':{
				$get= $this->simpan();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }			
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function simpan(){
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;
				
		$idplh= explode(" ",$_REQUEST['idplh']);
		$ref_idruang = $_REQUEST['ref_idruang'];
		$getdt = table_get_rec("select p,q from ref_ruang where id='$ref_idruang'");
		//if($err=='' && $ref_idruang=='') $err = 'GEDUNG / RUANG	 belum dipilih !';		
			if($err==''){
				for($i=0;$i<count($idplh);$i++){
					$sql = "update buku_induk set ref_idruang = '$ref_idruang',p='".$getdt['p']."',q='".$getdt['q']."' where id ='".$idplh[$i]."' ";$cek.=$sql;			
					$qry = mysql_query($sql);
				}
			}		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
}
$kir = new kirObj();

?>