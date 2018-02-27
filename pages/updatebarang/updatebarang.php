<?php

class updatebarangObj extends DaftarObj2{
	var $Prefix = 'updatebarang';
	var $SHOW_CEK = TRUE;	
	var $TblName = 'view_buku_induk2';//view2_sensus';
	var $TblName_Hapus = 'view_buku_induk2';
	var $TblName_Edit = 'view_buku_induk2';
	var $KeyFields = array('no_ba,c1,c,d,e,e1');
	var $FieldSum = array('nilai_buku','nilai_susut');
	var $SumValue = array('nilai_buku','nilai_susut');
	var $FieldSum_Cp1 = array( 9, 8, 8);
	var $FieldSum_Cp2 = array( 3, 3, 3);	
	var $FormName = 'updatebarangForm';
	var $pagePerHal = 25;
	
	var $PageTitle = 'UPDATE';
	var $PageIcon = 'images/penatausahaan_ico.gif';
	var $ico_width = '20';
	var $ico_height = '30';
	
	var $fileNameExcel='Daftar UPDATE BARANG.xls';
	var $Cetak_Judul = 'UPDATE ';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $fmST = 0;
	var $idpilih = '';
	
	function setTitle(){
		global $Main;
		return 'UPDATE';
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
		$idubah = $_REQUEST['idubah'];
		$cekid = explode(" ",$_REQUEST['idubah']);
		$jmlcek = count($cekid);			
		$uid = $HTTP_COOKIE_VARS['coID'];			
		$tgl_buku = date('d-m');
		
		$arrList=array(
			array('1','KOREKSI HARGA'),
			array('2','KONDISI BARANG'),
			array('3','KAPITALISASI'),
			array('4','REKLAS ASET'),
			array('5','DOUBLE CATAT'),
			array('6','PENGGABUNGAN'),
			array('7','PENGHAPUSAN SEBAGIAN'),
			);
		
		$arrKondisiBarang = array(
				array("1","Baik"),
				array("2","Kurang Baik"),					
			);
	
		$qrybi = "SELECT * FROM $this->TblName where id='$idubah'";
		$resultbi = mysql_query($qrybi);	
		$bi = mysql_fetch_array($resultbi);
		$vstaset = $bi['staset'];
		$idawal = $bi['idawal'];
		$kdbarang = $bi['f'].'.'.$bi['g'].'.'.$bi['h'].'.'.$bi['i'].'.'.$bi['j'];
		$harga = getNilaiBuku($bi['id'],$bi['tgl_buku'],0);
		$tglperoleh = $bi['tgl_perolehan'] = $bi['tgl_buku']!=NULL?TglInd($bi['tgl_buku']):$bi['thn_perolehan'].'-00-00';
		$tglperoleh2 = $bi['tgl_perolehan'] = $bi['tgl_buku']!=NULL?TglInd($bi['tgl_buku']):$bi['thn_perolehan'].'-00-00';
		//$tglperoleh2 = $bi['tgl_ba']!=NULL?TglInd($bi['tgl_ba']):TglInd($bi['thn_perolehan'].'-'.date("m", strtotime($bi['tgl_buku'])).'-'.date("d",strtotime($bi['tgl_buku'])));
		//$tgl_bast = date('d-m-Y');
		$tgl_bast = date('d-m');
		$tgl_bi = TglInd($bi['tgl_buku']);
		$fmHARGA_AWAL = $bi['harga'];
		$nilai_buku = getNilaiBuku($bi['id'],$bi['tgl_perolehan'],0);
		$nilai_susut = getAkumPenyusutan($bi['id'],$bi['tgl_perolehan']);	
		$fmHARGA_BUKU = $nilai_buku - $nilai_susut;
		//TglInd($bi['tgl_perolehan']);
		if($bi['staset'] = 3){
			$staset = 'Aset Tetap';
		}elseif($bi['staset'] = 9){
			$staset = 'Aset Lain Lain';
		}elseif($bi['staset'] = 10){
			$staset = 'Aset Ekstra';
		}elseif($bi['staset'] = 8){
			$staset = 'Aset Tidak Berwujud';
		}else{
			$staset = '';
		}		
		
		if($vstaset == 10){
			$caption = 'KAPITALISASI KE INTRAKOMPTABLE' ;
			$vstateAwal = "Ekstrakomptable <input type='hidden' id='staset' name='staset' value='10' >";
			//$stateAkhir = getStatusAset('', $bi['kondisi'], $bi['harga'], $bi['f'], $bi['g'], $bi['h'], $bi['i'], $bi['j'] );
			$stateAkhir=3;
			$vstateAkhir = $Main->StatusAsetView[$stateAkhir-1][1]." <input type='hidden' id='staset_baru' name='staset_baru' value='$stateAkhir' >";
		}else{
			$caption = 'KAPITALISASI KE EKSTRAKOMPTABLE' ;
			$vstateAwal = $Main->StatusAsetView[$bi['staset']-1][1]." <input type='hidden' id='staset' name='staset' value='".$bi['staset']."' >";
			$vstateAkhir = "Ekstrakomptable <input type='hidden' id='staset_baru' name='staset_baru' value='10' >";
		}
		
		$vkondisi = $Main->KondisiBarang[$bi['kondisi']-1][1];
		$vkondisi_baru = cmb2D_v2( 'kondisi_baru',$bi['kondisi_baru'],$arrKondisiBarang );
		$querydoksumber = "select * from ref_dokumensumber";
		$vdoksumber=6;//berita acara
		
		$stasetAwal = $Main->StatusAsetView[$vstaset-1][1] ."<input type='hidden' id='staset' name='staset' value='".$vstaset."'>" ;
		$stkondisi = "<input type='hidden' id='kondisi' name='kondisi' value ='".$bi['kondisi']."' >";
		$stkondisi_baru = "<input type='hidden' id='kondisi_baru' name='kondisi_baru' value ='".$bi['kondisi']."' >";
				
		if($vstaset == 9){
				$caption = 'Reclass dari Aset Lain-lain' ;
				/**if($Main->STASET_OTOMATIS){
					$dt['kondisi_baru'] = 1;
					$selSTASET =  $Main->StatusAsetView[ getStatusAset('', $dt['kondisi_baru'], $bi['harga'], $bi['f'], $bi['g'], 
						$bi['h'], $bi['i'], $bi['j'] ) -1][1];// $Main->StatusAsetView[3-1][1];						
					
					$arrKondisiBarang = array(
						array("1","Baik"),
						array("2","Kurang Baik"),					
					);
					$vkondisi_baru= cmb2D_v2( 'kondisi_baru',$dt['kondisi_baru'], $arrKondisiBarang);	
					$stkondisi = "<input type='hidden' id='kondisi' name='kondisi' value ='".$bi['kondisi']."' >";
					
					$this->form_fields = array(							
						'tgl' => array(  'label'=>'Tanggal', 'value'=> $vtgl,  'type'=>'' ),
						'staset' => array(  'label'=>'Dari', 'value'=> $stasetAwal, 'labelWidth'=>90, 'type'=>'' ),
						'staset_baru' => array(  'label'=>'Ke', 'value'=> $selSTASET, 'type'=>'' ),
						'kondisi' => array(  'label'=>'Kondisi Awal', 'value'=> $vkondisi.$stkondisi, 'labelWidth'=>90, 'type'=>'' ),
						'kondisi_baru' => array(  'label'=>'Kondisi Akhir', 'value'=> $vkondisi_baru, 'type'=>'' ),
						'ket'=> array(  'label'=>'Keterangan', 'value'=> "<textarea id='ket' name='ket' style='width: 234px;height: 35px;'>".$dt['ket']."</textarea>", 'type'=>'' )
					);
				}else{
				**/
					$dt['kondisi_baru'] = $bi['kondisi'];
					//$selSTASET =  $Main->StatusAsetView[ getStatusAset('', $dt['kondisi_baru'], $bi['harga'], $bi['f'], $bi['g'], 
					//	$bi['h'], $bi['i'], $bi['j'] ) -1][1];// $Main->StatusAsetView[3-1][1];	
				
					$vkondisi_baru = $Main->KondisiBarang[$dt['kondisi_baru']-1][1];
					$selSTASET = $bi['f']=='07' ? $Main->StatusAsetView[8-1][1] :  $Main->StatusAsetView[3-1][1];
					$arrasetlain2=
					$this->isiform(
						array(
							array(
									'label'=>'DARI',
									'name'=>'staset',
									'label-width'=>'200px;',
									'value'=>$stasetAwal,
							),
							array(
									'label'=>'KE',
									'name'=>'staset_baru',
									'label-width'=>'200px;',
									'value'=>$selSTASET,
							),
							array(
									'label'=>'KETERANGAN ',
									'name'=>'ket',
									'label-width'=>'200px;',
									'value'=>"<textarea id='ket' name='ket' style='width: 234px;height: 35px;'>".$dt['ket']."</textarea>",
							),
						)
					);
					/*$this->form_fields = array(							
						'tgl' => array(  'label'=>'Tanggal', 'value'=> $vtgl,  'type'=>'' ),
						'staset' => array(  'label'=>'Dari', 'value'=> $stasetAwal, 'labelWidth'=>90, 'type'=>'' ),
						'staset_baru' => array(  'label'=>'Ke', 'value'=> $selSTASET.$stkondisi.$stkondisi_baru, 'type'=>'' ),
						'ket'=> array(  'label'=>'Keterangan', 'value'=> "<textarea id='ket' name='ket' style='width: 234px;height: 35px;'>".$dt['ket']."</textarea>", 'type'=>'' )
					);*/
				//}
				
				
				
			}else{
				$caption = 'Reclass ke Aset Tetap' ;
				$selSTASET = $Main->StatusAsetView[9-1][1];				
				$arrasetlain2=
					$this->isiform(
						array(
							array(
									'label'=>'DARI',
									'name'=>'staset',
									'label-width'=>'200px;',
									'value'=>$stasetAwal,
							),
							array(
									'label'=>'KE',
									'name'=>'staset_baru',
									'label-width'=>'200px;',
									'value'=>$selSTASET,
							),/*
							array(
									'label'=>'KONDISI AWAL',
									'name'=>'kondisi',
									'label-width'=>'200px;',
									'value'=>$vkondisi.$stkondisi,
							),
							array(
									'label'=>'KONDISI AKHIR',
									'name'=>'kondisi_baru',
									'label-width'=>'200px;',
									'value'=>$vkondisi_baru,
							),*/
							array(
									'label'=>'KETERANGAN ',
									'name'=>'ket',
									'label-width'=>'200px;',
									'value'=>"<textarea id='ket' name='ket' style='width: 234px;height: 35px;'>".$dt['ket']."</textarea>",
							),
						)
					);
					/*$this->form_fields = array(							
						'tgl' => array(  'label'=>'Tanggal', 'value'=> $vtgl,  'type'=>'' ),
						'staset' => array(  'label'=>'Dari', 'value'=> $stasetAwal, 'labelWidth'=>90, 'type'=>'' ),
						'staset_baru' => array(  'label'=>'Ke', 'value'=> $selSTASET, 'type'=>'' ),
						'kondisi' => array(  'label'=>'Kondisi Awal', 'value'=> $vkondisi.$stkondisi, 'labelWidth'=>90, 'type'=>'' ),
						'kondisi_baru' => array(  'label'=>'Kondisi Akhir', 'value'=> $vkondisi_baru, 'type'=>'' ),
						'ket'=> array(  'label'=>'Keterangan', 'value'=> "<textarea id='ket' name='ket' style='width: 234px;height: 35px;'>".$dt['ket']."</textarea>", 'type'=>'' )
					);*/
			}
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
								'label'=>'KODE BARANG',
								'name'=>'kd',
								'label-width'=>'200px;',
								'value'=>$kdbarang,
								
							),
							array(
								'label'=>'NAMA BARANG',
								'name'=>'nm',
								'label-width'=>'200px;',
								'value'=>$bi['nm_barang'],
								
							),
							array(
								'label'=>'STATUS ASET',
								'name'=>'st',
								'label-width'=>'200px;',
								'value'=>$staset,
								
							),					
							array(
								'label'=>'DOKUMEN SUMBER',
								'name'=>'dok_sumber',
								'label-width'=>'200px;',
								'value'=>cmbQuery('dok_sumber',$vdoksumber,$querydoksumber,'','--- PILIH DOKUMEN SUMBER---',''),
								
							),							
							array(
								'label'=>'&nbsp;&nbsp;&nbsp;NOMOR',
								'name'=>'no_bast',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='no_bast' id='no_bast' value='' size=29/>",
							),							
							array(
								'label'=>'&nbsp;&nbsp;&nbsp;TANGGAL',
								'name'=>'tgl_bast',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='tgl_bast' id='tgl_bast' value='$tgl_bast' class='datepicker2' size='1'><input type='text' name='thn_ba' id='thn_ba' value='$thn_login' size='4'>"
								,
							),
							array(
								'label'=>'TANGGAL BUKU',
								'name'=>'tgl',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='tgl' id='tgl' value='$tgl_buku' size='1' class='datepicker2'><input type='text' name='thn_buku' id='thn_buku' value='$thn_login' size='4' readonly>"
								//'value'=>"<input type='text' name='tgl' id='tgl' value='' size='6' class='datepicker2'>"
								,
							),
							array(
								'label'=>'TRANSAKSI',
								'name'=>'trans',
								'label-width'=>'200px;',
								'value'=>cmbArray('trans','',$arrList,'--- PILIH TRANSAKSI---',"onChange='".$this->Prefix.".PilihTrans()'")
								,
							),		
						)
					)
				
				),'','','').
				$this->genFilterBar(						
					array(
					$this->isiform(
						array(
							array(
									'label'=>'TANGGAL NILAI PEROLEHAN',
									'name'=>'tgl_perolehan',
									'label-width'=>'200px;',
									'value'=>"<input type='text' name='tgl_perolehan' id='tgl_perolehan' value='$tglperoleh' size='6' class='datepicker3' onkeyup='".$this->Prefix.".GetHrg_Asal()'>",
							),
							array(
									'label'=>'HARGA PEROLEHAN ASAL RP. ',
									'name'=>'hrg',
									'label-width'=>'200px;',
									'value'=>"<p id='hrg2' >".number_format($harga, 2, ',', '.' )."</p> <input type='hidden' id='hrg' name='hrg' value='".$harga."' >",
							),
							array(
									'label'=>'HARGA PEROLEHAN BARU RP. ',
									'name'=>'hrg_baru',
									'label-width'=>'200px;',
									'value'=>inputFormatRibuan3("hrg_baru", ($entryMutasi==FALSE? $htmlreadonly:' readonly="" '),0,'','',''),
							),
							array(
									'label'=>'KETERANGAN ',
									'name'=>'ket_koreksi',
									'label-width'=>'200px;',
									'value'=>"<textarea id='ket_koreksi' name='ket_koreksi' style='width: 234px;height: 35px;'>".$dt['ket']."</textarea>",
							),
						)
					)
				),'','','','FilterBar','areakoreksi').
				$this->genFilterBar(						
					array(
					$this->isiform(
						array(
							array(
									'label'=>'KONDISI AWAL',
									'name'=>'kondisi',
									'label-width'=>'200px;',
									'value'=>$vkondisi.$stkondisi,
							),
							array(
									'label'=>'KONDISI AKHIR',
									'name'=>'kondisi_baru',
									'label-width'=>'200px;',
									'value'=>$vkondisi_baru,
							),
							array(
									'label'=>'KETERANGAN ',
									'name'=>'ket',
									'label-width'=>'200px;',
									'value'=>"<textarea id='ket' name='ket' style='width: 234px;height: 35px;'>".$dt['ket']."</textarea>",
							),
						)
					)
				),'','','','FilterBar','areakondisi').
				$this->genFilterBar(						
					array(
					$this->isiform(
						array(
							array(
									'label'=>'DARI',
									'name'=>'staset',
									'label-width'=>'200px;',
									'value'=>$vstateAwal,
							),
							array(
									'label'=>'KE',
									'name'=>'staset_baru',
									'label-width'=>'200px;',
									'value'=>$vstateAkhir,
							),
							array(
									'label'=>'KETERANGAN ',
									'name'=>'ket',
									'label-width'=>'200px;',
									'value'=>"<textarea id='ket' name='ket' style='width: 234px;height: 35px;'>".$dt['ket']."</textarea>",
							),
						)
					)
				),'','','','FilterBar','areakapitalisasi').
				$this->genFilterBar(						
					array(
					$arrasetlain2,
				),'','','','FilterBar','areaasetlain2').
				/*genFilterBar(
				array(
					"<span style='color:black;font-size:14px;font-weight:bold;'/>$caption</span>",
					
				
				),'','','').*/
				$this->genFilterBar(						
					array(
					$this->isiform(
						array(
							array(
								'label'=>'DENGAN ID DATA',
								'name'=>'idbibaru',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='idbibaru' id='idbibaru' value='' size=29/>",
							),	
						)
					)
				),'','','','FilterBar','areadbcct').
				$this->genFilterBar(						
					array(
					$this->isiform(
						array(							
							array(
								'label'=>'TANGGAL NILAI PEROLEHAN',
								'name'=>'tgl_bast',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='tgl_perolehangabung' id='tgl_perolehangabung' value='$tgl_bi' class='datepicker' size='6'>"
								,
							),
							array(
								'label'=>'ID DATA INDUK',
								'name'=>'idbibaru2',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='idbibaru2' id='idbibaru2' value='' size=29/>",
							),	
							array(
								'label'=>'MENAMBAH MASA MANFAAT',
								'name'=>'fmTAMBAHMasaManfaat',
								'label-width'=>'200px;',
								'value'=>"<input type='checkbox' name='fmTAMBAHMasaManfaat' id='fmTAMBAHMasaManfaat' value='1' size=29/> Ya",
							),	
						)
					)
				),'','','','FilterBar','areagabung').
				$this->genFilterBar(						
					array(
					$this->isiform(
						array(							
							array(
								'label'=>'TANGGAL NILAI PEROLEHAN',
								'name'=>'tgl_bast',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='tgl_perolehanhpsbagian' id='tgl_perolehanhpsbagian' value='$tglperoleh2' class='datepicker3' size='6' class='datepicker3' onkeyup='".$this->Prefix.".GetHrg_Asal()'>"
								,
							),
							/*array(
								'label'=>'NILAI PEROLEHAN',
								'name'=>'fmHARGA_AWAL',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='fmHARGA_AWAL' id='fmHARGA_AWAL' value='$fmHARGA_AWAL' readonly align='right' 
							style='width:150px;text-align:right;' onkeypress='return isNumberKey(event)' 
							onkeyup=\"document.getElementById('fmHARGA_AWAL2').innerHTML = $this->Prefix.formatCurrency(this.value);".$this->Prefix.".GetNilaiScarp();\" />
							 Rp <span id='fmHARGA_AWAL2'>",	
							),*/
							array(
								'label'=>'NILAI PEROLEHAN',
								'name'=>'fmHARGA_AWAL',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='fmHARGA_AWALfaxe' id='fmHARGA_AWALfaxe' value='".number_format($fmHARGA_AWAL,2,',','.')."' readonly align='right' 
							style='width:150px;text-align:right;'><input type='hidden' name='fmHARGA_AWAL' id='fmHARGA_AWAL' value='$fmHARGA_AWAL'",	
							),
							array(
								'label'=>'NILAI BUKU',
								'name'=>'fmHARGA_BUKU',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='fmHARGA_BUKU2' id='fmHARGA_BUKU2' value='".number_format($fmHARGA_BUKU,2,',','.')."' readonly align='right' 
							style='width:150px;text-align:right;'><input type='hidden' name='fmHARGA_BUKU' id='fmHARGA_BUKU' value='$fmHARGA_BUKU'",	
							),
							array(
								'label'=>'NILAI PENGHAPUSAN',
								'name'=>'fmHARGA_HAPUS',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='fmHARGA_HAPUS' id='fmHARGA_HAPUS' value=''  align='right' 
							style='width:150px;text-align:right;' onkeypress='return isNumberKey(event)' 
							onkeyup=\"document.getElementById('fmHARGA_HAPUS2').innerHTML = $this->Prefix.formatCurrency(this.value);".$this->Prefix.".GetNilaiScarp();\" />
							 Rp <span id='fmHARGA_HAPUS2'>",
							),		
							array(
								'label'=>'NILAI SCRAP/SISA',
								'name'=>'fmHARGA_AWAL',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='fmHARGA_SCRAP' id='fmHARGA_SCRAP' value='$fmHARGA_SCRAP' style='text-align: right;' readonly>&nbsp;&nbsp;&nbsp;&nbsp;<span id='fmHARGA_SCRAP2' style='color:red;font-weight: bold;' >&nbsp;</span>",
							),			
							array(
								'label'=>'KETERANGAN',
								'name'=>'fmHARGA_AWAL',
								'label-width'=>'200px;',
								'value'=>"<textarea name='fmKET' id='fmKET' cols='47'></textarea>",
							),	
						)
					)
				),'','','','FilterBar','areahpsbagian').
				genFilterBar(
					array(
					"<table>
					<tr>
						<td><input type='hidden' name='idbi' id='idbi' value='$idubah'>
							<input type='hidden' name='idbi_awal' id='idbi_awal'  value='$idawal'>
						</td>
					</tr>
					</table><table>						
						<tr>
							<td>".$this->buttonnya('','save_f2.png','SIMPAN','SIMPAN','SIMPAN')."</td>
							<td>".$this->buttonnya('javascript:window.close();window.opener.location.reload();','cancel_f2.png','TUTUP','TUTUP','TUTUP')."</td>
						</tr>".
					"</table>"
				),'','','')
			;
		
		return array('TampilOpt'=>$TampilOpt);
		
	
	}
	
	function inputFormatRibuancustom($obj="obj", $params="", $value=0, $ket=' pemisah pecahan dengan titik (mis: 1.5)') {
    global $$obj; //$$obj = round($$obj,0);
    //onKeyPress=\"return isNumberKey(event); \"
	//$str = " <input type=\"text\" name=\"$obj\" id=\"$obj\" value=\"" . $value . "\"
	if ($value == 0){
		$value = $$obj;
	}
    $str = " <input type=\"text\" name=\"$obj\" id=\"$obj\" value=\"" . $value . "\"
			$params
			onKeyDown = \"oldValue=this.value;\" 
			 onKeyPress=\"return isNumberKey(event); \"
			 onkeyup=\"javascript:TampilUang('Tampil$obj',this.value); ".$this->Prefix.".GetNilaiScarp();\"
			 
			 /> 
			&nbsp;&nbsp
			<b>	
			<span id=\"Tampil$obj\" style='color:red'>&nbsp;</span></b> 
			&nbsp;&nbsp<br> 
				<span style='color:red'>$ket</span>";
    return $str;
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
					"<input type='hidden' name='urusan_lama' id='urusan_lama' value='".$_REQUEST['fmURUSAN']."' />".
					"<input type='hidden' name='skpd_lama' id='skpd_lama' value='".$_REQUEST['fmSKPD']."' />".
					"<input type='hidden' name='unit_lama' id='unit_lama' value='".$_REQUEST['fmUNIT']."' />".
					"<input type='hidden' name='subunit_lama' id='subunit_lama' value='".$_REQUEST['fmSUBUNIT']."' />".
					"<input type='hidden' name='seksi_lama' id='seksi_lama' value='".$_REQUEST['fmSEKSI']."' />".
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
			setTimeout(function myFunction(){".$this->Prefix.".AftFilterRender3()},1000);
			
		}
		);
		</script>
		";
		return  	
		"<link href='datepicker/jquery-ui.css' type='text/css' rel='stylesheet'  >".
		"<script src='datepicker/jquery-1.12.4.js' type='text/javascript' language='JavaScript'></script>".
		"<script src='datepicker/jquery-ui.js' type='text/javascript' language='JavaScript' ></script>".
		"<script type='text/javascript' src='js/updatebarang/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
		$scriptload;
	}
	
	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){
			case 'simpankoreksi':{
				$get= $this->simpankoreksi();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }
			case 'simpankondisi':{
				$get= $this->simpankondisi();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }
			case 'simpankapitalisasi':{
				$get= $this->simpankapitalisasi();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }		
			case 'simpanasetlainlain':{
				$get= $this->simpanasetlainlain();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }		
			case 'simpanpenghapusan':{
				$get= $this->simpanpenghapusan();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }		
			case 'simpanhpsbagian':{
				$get= $this->simpanhpsbagian();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }
			case 'PilihTrans':{
				$get= $this->PilihTrans();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }				
			case 'GetHrg_Asal':{				
				$fm = $this->GetHrg_Asal();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
				$json=TRUE;														
				break;
			}
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function simpankoreksi(){
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$idbi = $_REQUEST['idbi'];
		$dok_sumber = $_REQUEST['dok_sumber'];
		$no_bast = $_REQUEST['no_bast'];
		$tgl_bast = date('Y-m-d', strtotime($_REQUEST['tgl_bast'].'-'.$_REQUEST['thn_ba']));
		//$tgl_perolehandb = date('Y-m-d', strtotime($_REQUEST['tgl_bast']));
		$tgl_perolehan = date('Y-m-d', strtotime($_REQUEST['tgl_perolehan']));
		
		$uid = $HTTP_COOKIE_VARS['coID'];		
		$ket = $_REQUEST['ket_koreksi'];
		$hrg = $_REQUEST['hrg'];
		$hrg_baru = $_REQUEST['hrg_baru'];
		
		//$tgl = date('Y-m-d', strtotime($_REQUEST['tgl']));		
		$tgl = date('Y-m-d', strtotime($_REQUEST['tgl'].'-'.$_REQUEST['thn_buku']));
			
		$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id='$idbi'"));
		$idbi_awal = $bi['idawal'];
		$thn_perolehan = substr($tgl_perolehan,0,4);
		//$tgl_perolehan = date('Y-m-d', strtotime($tgl_peroleh));	
		
		$tgl_susutAkhir = tglSusutAkhir($idbi);
		//get tglakhir susut,koreksi,penilaian,penghapusan_sebagian dgn idbi_awal yg sama
		//$tgl_susutAkhir = mysql_fetch_array(mysql_query("select tgl from penyusutan where idbi='$idbi' and jns_trans2=30 and id_koreksi=0 order by id desc limit 1"));
		$tgl_korAkhir = mysql_fetch_array(mysql_query("select tgl,tgl_perolehan,tgl_create from t_koreksi where idbi_awal='$idbi_awal' order by tgl desc limit 1"));
		$tgl_nilaiAkhir = mysql_fetch_array(mysql_query("select tgl_penilaian,tgl_perolehan,tgl_create from penilaian where idbi_awal='$idbi_awal' order by tgl_penilaian desc limit 1"));
		$tgl_hpsAkhir = mysql_fetch_array(mysql_query("select tgl_penghapusan,tgl_create from penghapusan_sebagian where idbi_awal='$idbi_awal' order by tgl_penghapusan desc limit 1"));
		
		$get_ba = mysql_fetch_array(mysql_query("select tgl_ba from buku_induk where idawal='$idbi_awal'"));		
		if($get_ba['tgl_ba']=='0000-00-00' or $get_ba['tgl_ba']=='' or $get_ba['tgl_ba']==NULL){
			$gentgl_perolehan = $bi['thn_perolehan'].'-'.date("m", strtotime($bi['tgl_buku'])).'-'.date("d",strtotime($bi['tgl_buku']));			
		}else{
			$gentgl_perolehan = $get_ba['tgl_ba'];
		}
		//-------------------------------------
				
		if($err=='' && $dok_sumber=='') $err = 'DOKUMEN SUMBER belum dipilih !';
		if($err=='' && $no_bast=='') $err = 'NOMOR belum diisi !';
		if($err=='' && ($_REQUEST['tgl_bast']=='') ){ $err = 'TANGGAL belum diisi!';	}
		if($err=='' && ($_REQUEST['tgl']=='') ){ $err = 'TANGGAL BUKU belum diisi!';	}
		//if($err=='' && ($tgl_perolehan == '0000-00-00' || $tgl_perolehan=='') ){ $err = 'TANGGAL belum diisi!';	}
		if($err=='' && !cektanggal($tgl_bast)){ 	$err = "TANGGAL Salah!";	}
		if($err=='' && !cektanggal($tgl)){ 	$err = "TANGGAL BUKU Salah!";	}
		if($err=='' && compareTanggal($tgl, date('Y-m-d'))==2  ) $err = 'TANGGAL BUKU tidak lebih besar dari Hari ini!';				
		//if($err=='' && compareTanggal($tgl, $bi['tgl_buku'])==0  ) $err = 'TANGGAL BUKU tidak lebih kecil dari Tanggal Buku Barang !';			
		if($err =='' && compareTanggal($tgl_perolehan,$tgl )==2) $err = 'TANGGAL NILAI  PEROLEHAN tidak lebih besar dari TANGGAL BUKU !';				
		if($err=='' && $tgl_perolehan<$gentgl_perolehan)$err ='TANGGAL NILAI  PEROLEHAN tidak lebih kecil dari Tanggal BAST/Buku Barang !';
		if($err=='' && $hrg_baru=='') $err = 'HARGA PEROLEHAN BARU belum diisi !';
			
		if($err=='' &&$fmst==1 && $bi['status_barang'] != 1 ) $err= "Hanya Barang Inventaris yang bisa Koreksi!";
		$oldmaxtgl = mysql_fetch_array(mysql_query("select max(tgl_perolehan) as maxtgl from t_koreksi where idbi_awal='$idbi_awal'"));
		if($err=='' && compareTanggal($tgl, $oldmaxtgl['maxtgl'])==0  ) $err = 'TANGGAL BUKU tidak lebih kecil dari tanggal terakhir transaksi !';
		
		$maxtrans = mysql_fetch_array(mysql_query("select max(tgl_buku) as maxtgl from t_transaksi where idawal='$idbi_awal'"));
		if($err=='' && compareTanggal($tgl, $maxtrans['maxtgl'])==0  ) $err = 'TANGGAL BUKU tidak lebih kecil dari tanggal transaksi sebelumnya!';
							
		//jika tambah aset =1 atau tambah manfaat = 1:
		//if($fmTAMBAHASET==1 || $fmTAMBAHMasaManfaat==1){
		if($err =='' && compareTanggal($tgl,$bi['tgl_buku'])==0) $err = 'TANGGAL BUKU tidak lebih kecil dari Tanggal Buku Barang !';				
		if($err =='' && $thn_perolehan<$bi['thn_perolehan']) $err = 'Tahun tidak kecil dari Tahun Perolehan Buku Barang !';				
		if($err=='' && sudahClosing($tgl,$bi['c'],$bi['d'],$bi['e'],$bi['e1'],$bi['c1']))$err = 'Tanggal sudah Closing !';
		if($err=='' && $tgl<=$tgl_susutAkhir['tgl'])$err ='Sudah ada penyusutan !';
			if($err=='' && $tgl<$tgl_korAkhir['tgl'] )$err ='Sudah ada koreksi harga !';
			if($err=='' && $tgl<$tgl_nilaiAkhir['tgl_penilaian'] )$err ='Sudah ada penilaian !';
			if($err=='' && $tgl_perolehan<$tgl_korAkhir['tgl_perolehan'] )$err ='Sudah ada koreksi harga !';
			if($err=='' && $tgl_perolehan<$tgl_nilaiAkhir['tgl_perolehan'] )$err ='Sudah ada penilaian !';
			if($err=='' && $tgl<$tgl_hpsAkhir['tgl_penghapusan'] )$err ='Sudah ada penghapusan sebagian !';
				//}
			if($err==''){
				//harga asal
				$harga= 0;
				//$get = mysql_fetch_array(mysql_query("select harga as tot from buku_induk where id = '".$bi['idawal']."' "));
				//$harga += $get['tot'];
				//$get = mysql_fetch_array(mysql_query("select sum(harga_baru - harga) as tot from t_koreksi where idbi_awal = '".$bi['idawal']."' and tgl<='$tgl' "));
				//$harga += $get['tot'];			
				$get = mysql_fetch_array(mysql_query("select harga as tot from buku_induk where id = '".$bi['idawal']."' "));
				$harga += $get['tot'];
				$get = mysql_fetch_array(mysql_query("select sum(biaya_pemeliharaan) as tot from pemeliharaan where idbi_awal = '".$bi['idawal']."' and tgl_pemeliharaan<='$tgl' and tambah_aset = 1  "));
				$harga += $get['tot'];
				$get = mysql_fetch_array(mysql_query("select sum(biaya_pengamanan) as tot from pengamanan where idbi_awal = '".$bi['idawal']."' and tgl_pengamanan<='$tgl' and tambah_aset = 1  "));
				$harga += $get['tot'];
				$get = mysql_fetch_array(mysql_query("select sum(biaya_pemanfaatan) as tot from pemanfaatan where idbi_awal = '".$bi['idawal']."' and tgl_pemanfaatan<='$tgl' and tambah_aset = 1  "));
				$harga += $get['tot'];
				$get = mysql_fetch_array(mysql_query("select sum(harga_hapus) as tot from penghapusan_sebagian where idbi_awal = '".$bi['idawal']."' and tgl_penghapusan<='$tgl'  "));
				$harga -= $get['tot'];
				$get = mysql_fetch_array(mysql_query("select sum(nilai_barang - nilai_barang_asal) as tot from penilaian where idbi_awal = '".$bi['idawal']."' and tgl_penilaian<='$tgl'  "));
				$harga += $get['tot'];
				$get = mysql_fetch_array(mysql_query("select sum(harga_baru - harga) as tot from t_koreksi where idbi_awal = '".$bi['idawal']."' and tgl<='$tgl' "));
				$harga += $get['tot'];		
				
				//simpan		
				$aqry = 
					"insert into t_koreksi".
					"(tgl,  idbi, idbi_awal, uid, tgl_update, staset, harga, harga_baru, ket , tgl_perolehan,no_bast,tgl_bast,dokumen_sumber )".					
					" values ".
					"('$tgl', '$idbi', '".$bi['idawal']."', '$uid', now(), '".$bi['staset']."' , '".$hrg."', '$hrg_baru', '$ket' , '$tgl_perolehan','$no_bast','$tgl_bast','$dok_sumber') "; $cek .= $aqry;
				$qry = mysql_query($aqry);							
			}	
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function simpankondisi(){
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;
				
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$idbi = $_REQUEST['idbi'];
		$idbi_awal = $_REQUEST['idbi_awal'];
		$dok_sumber = $_REQUEST['dok_sumber'];
		$no_bast = $_REQUEST['no_bast'];
		$tgl_bast = date('Y-m-d', strtotime($_REQUEST['tgl_bast'].'-'.$_REQUEST['thn_ba']));
		//$tgl = date('Y-m-d', strtotime($_REQUEST['tgl']));		
		$tgl = date('Y-m-d', strtotime($_REQUEST['tgl'].'-'.$_REQUEST['thn_buku']));
		$uid = $HTTP_COOKIE_VARS['coID'];
		$ket = $_REQUEST['ket'];
		$kondisi = $_REQUEST['kondisi'];
		$kondisi_baru = $_REQUEST['kondisi_baru'];
		$dif_kondisi = $_REQUEST['kondisi_baru']-$_REQUEST['kondisi'];
		$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id = '$idbi' "));
		$idbi_awal = $bi['idawal'];
		$staset = $bi['staset'];
		
		$tgl_susutAkhir = mysql_fetch_array(mysql_query("select tgl from penyusutan where idbi_awal='$idbi' order by tgl desc limit 1"));
		
		$old = mysql_fetch_array(mysql_query("select * from t_kondisi where Id='$idplh' "));		
		if($err=='' && $dok_sumber=='') $err = 'DOKUMEN SUMBER belum dipilih !';
		if($err=='' && $no_bast=='') $err = 'NOMOR belum diisi !';
		if($err=='' && $_REQUEST['tgl_bast']=='' )$err = 'TANGGAL belum diisi!';
		if($err=='' && $_REQUEST['tgl']=='') $err = 'TANGGAL BUKU belum diisi!';		
		if($err=='' && !cektanggal($tgl))$err = "TANGGAL BUKU $tgl Salah!";					
		if($err=='' && sudahClosing($tgl,$bi['c'],$bi['d'],$bi['e'],$bi['e1'],$bi['c1']))$err = 'Tanggal sudah Closing !';
		if($err=='' && $tgl<=$tgl_susutAkhir['tgl'])$err ='Sudah ada penyusutan !';
		// - tanggal harus <= tgl hari ini
		if ($err =='' && compareTanggal($tgl, date('Y-m-d'))==2  ) $err = 'Tanggal tidak lebih besar dari Hari ini!';						
		//tgl >=tgl_buku
		if( compareTanggal( $tgl,$bi['tgl_buku'])==0  ) $err = "TANGGAL BUKU tidak lebih kecil dari TANGGAL BUKU BARANG!";
		
		$maxtrans = mysql_fetch_array(mysql_query("select max(tgl_buku) as maxtgl from t_transaksi where idawal='$idbi_awal'"));
		if($err=='' && compareTanggal($tgl, $maxtrans['maxtgl'])==0  ) $err = 'TANGGAL BUKU tidak lebih kecil dari tanggal transaksi sebelumnya!';
				
				
		switch ($fmST){
			case 0 : { //baru
				//- tanggal >= tgl terakhir transaski u/ barang ini
				if($err=='' && $old['tgl'] <> $tgl ){ 			
					$get = mysql_fetch_array(mysql_query(
						"select max(tgl_buku) as maxtgl from t_transaksi where idawal ='$idbi_awal'  "
					));
					if( compareTanggal( $tgl, $get['maxtgl'] )==0 ) $err = "TANGGAL BUKU tidak lebih kecil dari transaksi sebelumnya!";
				}	
				if($err==''){
					$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id='$idbi'"));
					$aqry = "insert into t_kondisi (tgl,idbi,uid,tgl_update,ket, kond_awal,kond_akhir,idbi_awal,dif_kondisi,no_bast,tgl_bast,dokumen_sumber,staset_lama) ".
						" values('$tgl','$idbi','$uid',now(),'$ket', '$kondisi','$kondisi_baru','".$bi['idawal']."','$dif_kondisi','$no_bast','$tgl_bast','$dok_sumber','$staset') "; $cek .= $aqry;
					$qry = mysql_query($aqry);		
//					$newid= mysql_insert_id();
					if($qry){
						if($kondisi_baru==3){//khusus rusak berat
							$upd_bi = "update buku_induk set kondisi = '$kondisi_baru',staset=9 where  id='$idbi'";$cek .= $upd_bi;
							mysql_query($upd_bi);	
						}else{
							$upd_bi = "update buku_induk set kondisi = '$kondisi_baru' where  id='$idbi'";$cek .= $upd_bi;
							mysql_query($upd_bi);	
						}
											
					}
				}
				break;
			}
			case 1 : { //edit
				if($err == '' && $old['kond_awal']==0)$err = " Tidak bisa diedit, Kondisi awal kosong!";
				//get kondisi terakhir
				$query = "select refid from t_transaksi where jns_trans2=34 and idawal='$idbi_awal'  order by refid desc limit 0,1";
				$check = mysql_fetch_array(mysql_query($query));	
				if($err==''){					
					if($check['refid'] != $idplh){						
						//$cek .= $check['Id'];			
						if($old['kond_akhir'] <> $kondisi_baru)$err = "Hanya kondisi terakhir yang dapat di edit! Kecuali Keterangan"; //hanya transaksi terkahir yg boleh diedit 						
						if($old['tgl'] <> $tgl)$err = "Hanya kondisi terakhir yang dapat di edit! Kecuali Keterangan"; //hanya transaksi terkahir yg boleh diedit 						
					}
				}				
				if($err=='' && $old['tgl'] <> $tgl ){ 	
					$get = mysql_fetch_array(mysql_query(
						"select max(tgl_buku) as maxtgl from t_transaksi where jns_trans2=34 and idawal ='$idbi_awal' and refid<>'$idplh'  "
					));					
					//cek tgl transaksi terakhir tidak boleh lebih kecil dari tgl transaksi sebelumnya
					if($check['refid'] == $idplh){						
						if( compareTanggal( $tgl,$get['maxtgl']  )==0 ) $err = "Tanggal tidak lebih kecil dari transaksi sebelumnya!";
					}			
					
					/*validasi te kapake
					//- tanggal >= tgl terakhir transaski u/ barang ini
					$get = mysql_fetch_array(mysql_query(
						"select max(tgl_buku) as maxtgl from t_transaksi where jns_trans2=34 and idawal ='$idbi_awal' and refid<>'$idplh'  "
					));
					$get2 = mysql_fetch_array(mysql_query(
						"select min(tgl_buku) as mintgl from t_transaksi where jns_trans2=34 and idawal ='$idbi_awal' and refid<>'$idplh'  "
					));
					
					//cek tgl transaksi pertama tidak boleh lebih besar dari tgl transaksi setelahnya
					$query2 = "select refid from t_transaksi where jns_trans2=34 and idawal='$idbi_awal' order by refid asc limit 0,1";
					$check2 = mysql_fetch_array(mysql_query($query2));	
					if($check2['refid'] == $idplh && $get2['mintgl']!=NULL){						
						if( compareTanggal( $tgl,$get2['mintgl']  )==2 ) $err = "Tanggal tidak lebih besar dari transaksi setelahnya!";
					}
										
					//cek tgl transaksi terakhir tidak boleh lebih kecil dari tgl transaksi sebelumnya
					$query3 = "select refid from t_transaksi where jns_trans2=34 and idawal='$idbi_awal' order by refid desc limit 0,1";
					$check3 = mysql_fetch_array(mysql_query($query3));	
					if($check3['refid'] == $idplh){						
						if( compareTanggal( $tgl,$get['maxtgl']  )==0 ) $err = "Tanggal tidak lebih kecil dari transaksi sebelumnya!";
					}		
					
					//------------------------------------------------------------------
					//cek tgl transaksi tidak boleh lebih kecil dari tgl transaksi sebelumnya dan tidak boleh lebih besar dari tgl transaksi setelahnya 
					if($check2['refid'] != $idplh && $check3['refid'] != $idplh){
						if( compareTanggal( $tgl,$get2['mintgl']  )==0 ) $err = "Tanggal tidak lebih kecil dari transaksi sebelumnya!";
						if( compareTanggal( $tgl,$get['maxtgl']  )==2 ) $err = "Tanggal tidak lebih besar dari transaksi setelahnya!";
						
					}
					//------------------------------------------------------------------	
					*/		
				}						
				if($err==''){
					$aqry = "UPDATE t_kondisi 
							set tgl='$tgl', 
							uid='$uid', 
							tgl_update = now(), 
							kond_akhir = '$kondisi_baru', 
							ket='$ket', 
							dif_kondisi='$dif_kondisi' 
							WHERE Id='".$idplh."'";	
							$cek .= $aqry;
					$qry = mysql_query($aqry) or die(mysql_error());
					if($qry){
						$upd_bi = "update buku_induk set kondisi = '$kondisi_baru' where  id='$idbi'";$cek .= $upd_bi;
						mysql_query($upd_bi);						
					}					
				}
			
				break;
			}
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function simpankapitalisasi(){
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;		
		
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
		$idbi = $_REQUEST['idbi'];
		$idbi_awal = $_REQUEST['idbi_awal'];
		$Id = $_REQUEST['Id'];
		$dok_sumber = $_REQUEST['dok_sumber'];
		$no_bast = $_REQUEST['no_bast'];
		$tgl_bast = date('Y-m-d', strtotime($_REQUEST['tgl_bast'].'-'.$_REQUEST['thn_ba']));
		//$tgl = date('Y-m-d', strtotime($_REQUEST['tgl']));
		$tgl = date('Y-m-d', strtotime($_REQUEST['tgl'].'-'.$_REQUEST['thn_buku']));
		$uid = $HTTP_COOKIE_VARS['coID'];
		$staset = $_REQUEST['staset'];
		$staset_baru = $_REQUEST['staset_baru'];
		$ket = $_REQUEST['ket'];
		$kondisi = $_REQUEST['kondisi'];
		$kondisi_baru = $_REQUEST['kondisi_baru'];
		
		$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id = '$idbi' "));
		$idbi_awal = $bi['idawal'];		
		$old = mysql_fetch_array(mysql_query("select * from t_kapitalisasi where Id='$Id' "));
				
		//if($err=='' && $staset_baru == '') $err = "Status Aset belum dipilih!";
		//if($err=='' && $staset_baru == $staset) $err = "Status Aset harus beda!";		
		if($err=='' && $dok_sumber=='') $err = 'DOKUMEN SUMBER belum dipilih !';
		if($err=='' && $no_bast=='') $err = 'NOMOR belum diisi !';
		if($err=='' && $_REQUEST['tgl_bast']=='') $err = 'TANGGAL belum diisi!';
		if($err=='' && $_REQUEST['tgl']=='') $err = 'TANGGAL BUKU belum diisi!';		
		if($err=='' && !cektanggal($tgl))$err = "TANGGAL BUKU $tgl Salah!";				
		if($err =='' && compareTanggal($bi['tgl_buku'],$tgl)==2) $err = 'TANGGAL BUKU tidak lebih kecil dari TANGGAL BUKU BARANG !';				
		// - tanggal harus <= tgl hari ini
		if ($err =='' && compareTanggal($tgl, date('Y-m-d'))==2  ) $err = 'TANGGAL BUKU tidak lebih besar dari Hari ini!';						
		// - tanggal > tgl closing
		if($err==''){ //cek tahun tgl <= thn closing
			$arrtgl = explode('-',$tgl);
			$thn =$arrtgl[0];
			//if ($thn<=$Main->TAHUN_CLOSING) $err = 'Data Tidak Dapat Disimpan!, Tahun '.$Main->TAHUN_CLOSING.' sudah closing'; 
		}				
		//tgl >=tgl_buku
		//tgl >=tgl_buku
		$tgl_closing=getTglClosing($bi['c'],$bi['d'],$bi['e'],$bi['e1'],$bi['c1']); 
		$tgl_susutAkhir = mysql_fetch_array(mysql_query("select tgl from penyusutan where idbi_awal='$idbi' order by tgl desc limit 1"));
		
		$nilai_buku = getNilaiPerolehan($idbi,$tgl);
		$nilai_susut = getAkumPenyusutan($idbi,$tgl);
		switch ($fmST){
			case 0 : { //baru	
				$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id='$idbi'"));
				$staset = $bi['staset'];
				//- tanggal >= tgl terakhir transaski u/ barang ini
				if($err=='' && $old['tgl'] <> $tgl ){ 			
					$get = mysql_fetch_array(mysql_query(
						"select max(tgl) as maxtgl from t_transaksi where idawal ='$idbi_awal'  "
					));
					if( compareTanggal( $tgl, $get['maxtgl'] )==0  ) $err = "TANGGAL BUKU tidak lebih kecil dari transaksi sebelumnya!";
				}
				
				if($err=='' && $bi['staset']==$staset_baru) $err = "Tidak ada perubahan status aset!";
				if($err=='' && $tgl<=$tgl_closing)$err ='Tanggal sudah Closing !';				
				if($err=='' && $tgl<=$tgl_susutAkhir['tgl'])$err ='Sudah ada penyusutan !';
				
				$maxtrans = mysql_fetch_array(mysql_query("select max(tgl_buku) as maxtgl from t_transaksi where idawal='$idbi_awal'"));
				if($err=='' && compareTanggal($tgl, $maxtrans['maxtgl'])==0  ) $err = 'TANGGAL BUKU tidak lebih kecil dari tanggal transaksi sebelumnya!';
				
				
				if($err==''){
				
					
					/**if($staset == 10){
						$staset_baru =  getStatusAset('', $kondisi_baru, $bi['harga'], $bi['f'], $bi['g'], $bi['h'], $bi['i'], $bi['j'] ) 	;
					}else{
						$staset_baru = 10;
					}**/
					if ($staset_baru == 3 ){
						if($bi['f']=='07') $staset_baru= 8;
					}
					
					$aqry = "insert into t_kapitalisasi (tgl,idbi,uid,tgl_update,staset,staset_baru,ket, idbi_awal,nilai_buku,nilai_susut,no_bast,tgl_bast,dokumen_sumber) ".
						" values('$tgl','$idbi','$uid',now(),'$staset','$staset_baru','$ket', '$idbi_awal','$nilai_buku','$nilai_susut','$no_bast','$tgl_bast','$dok_sumber') "; $cek .= $aqry;
					$qry = mysql_query($aqry);
					$newid= mysql_insert_id();
					if($qry){
						mysql_query("update buku_induk set staset = '$staset_baru' where  id='$idbi' ");
						//jurnal							
						$jur = jurnalKapitalisasi($bi, $idbi,$uid,$tgl, 1, FALSE, $newid);						
						$cek .= $jur['cek']; $err .=$jur['err'];
						//history Aset
						mysql_query(
							"insert into t_history_aset ".
							"(tgl,idbi,uid,tgl_update,staset,staset_baru,div_staset,idbi_awal,jns,refid) ".
							" values ".
							"('$tgl','$idbi','$uid',now(),'$staset','$staset_baru','".($staset_baru-$staset)."','".$bi['idawal']."',3,'$newid' )"
						);
					}
				}				
				break;
			}
			case 1 : { //edit
				//cek data terakhir
				if($err==''){
					//$query = "select Id from t_kapitalisasi where idbi_awal='$idbi_awal' order by tgl desc, Id desc limit 0,1";
					$query = "select * from t_transaksi where idawal='$idbi_awal'  order by tgl desc, Id desc limit 0,1";
					$check = mysql_fetch_array(mysql_query($query));				
					$cek .= $query;
					if($check['refid']!= $Id && $check['jns']==3 && $old['tgl'] <> $tgl) $err = "Hanya status aset terakhir yang dapat di edit! \nKecuali Keterangan";	
				}					
				if($err=='' && $old['tgl'] <> $tgl ){ 			
					//- tanggal >= tgl terakhir transaski u/ barang ini
					$get = mysql_fetch_array(mysql_query(
						"select max(tgl) as maxtgl from t_transaksi where idawal ='$idbi_awal'  and Id<>'$Id' "
					));
					if( compareTanggal( $tgl, $get['maxtgl'] )==0  ) $err = "Tanggal tidak lebih kecil dari transaksi sebelumnya!";
					
					//tgl utk transaksi pertama (staset=null) harus sama dgn tanggal buku
					if($err=='' && ($old['staset']==0 || $old['staset']==NULL) ) $err = "Tanggal harus sama dengan tanggal buku perolehan barang!";				
				}	
				
				if($err=='' && ($old['tgl']<=$tgl_closing) ) $err = "Reklas tidak bisa di edit, tanggal sudah closing !";
				if($err=='' && ($old['tgl']<$tgl_susutAkhir['tgl']) ) $err = "Reklas tidak bisa di edit, sudah penyusutan !";
				
				
				if($err==''){
					$aqry = "UPDATE t_kapitalisasi 
							set tgl='$tgl', 
							uid='$uid', 
							tgl_update = now(), 
							ket='$ket', 
							nilai_buku='$nilai_buku', 
							nilai_susut='$nilai_susut' 
							WHERE Id='".$Id."'";	
							$cek .= $aqry;
					$qry = mysql_query($aqry) or die(mysql_error());
					if($qry){
						mysql_query(
							"update t_history_aset set tgl='$tgl', uid='$uid', tgl_update=now() where jns=3 and refid='$Id'"
						);
					}
				}
			
				break;
			}
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function simpanasetlainlain(){
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;
				
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
		$Id = $_REQUEST['Id'];
		$idbi = $_REQUEST['idbi'];
		//$idbi_awal = $_REQUEST['idbi_awal'];
		$dok_sumber = $_REQUEST['dok_sumber'];
		$no_bast = $_REQUEST['no_bast'];
		$tgl_bast = date('Y-m-d', strtotime($_REQUEST['tgl_bast'].'-'.$_REQUEST['thn_ba']));
		//$tgl = date('Y-m-d', strtotime($_REQUEST['tgl']));		
		$tgl = date('Y-m-d', strtotime($_REQUEST['tgl'].'-'.$_REQUEST['thn_buku']));
		$uid = $HTTP_COOKIE_VARS['coID'];
		$staset = $_REQUEST['staset'];
		$staset_baru = $_REQUEST['staset_baru'];
		$ket = $_REQUEST['ket'];
		$kondisi = $_REQUEST['kondisi'];
		$kondisi_baru = $_REQUEST['kondisi_baru'];
		
		$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id = '$idbi' "));
		$idbi_awal = $bi['idawal'];
		$old = mysql_fetch_array(mysql_query("select * from t_asetlainlain where Id='$Id' "));
				
		//if($err=='' && $staset_baru == '') $err = "Status Aset belum dipilih!";
		//if($err=='' && $staset_baru == $staset) $err = "Status Aset harus beda!";
		
		if($err=='' && $dok_sumber=='') $err = 'DOKUMEN SUMBER belum dipilih !';
		if($err=='' && $no_bast=='') $err = 'NOMOR belum diisi !';
		if($err=='' && $_REQUEST['tgl_bast']=='') $err = 'TANGGAL belum diisi!';
		if($err=='' && $_REQUEST['tgl']=='') $err = 'TANGGAL BUKU belum diisi!';		
		if($err=='' && !cektanggal($tgl))$err = "TANGGAL BUKU $tgl Salah!";					
		// - tanggal harus <= tgl hari ini
		if ($err =='' && compareTanggal($tgl, date('Y-m-d'))==2  ) $err = 'TANGGAL BUKU	 tidak lebih besar dari Hari ini!';						
		// - tanggal > tgl closing
		if($err==''){ //cek tahun tgl <= thn closing
			$arrtgl = explode('-',$tgl);
			$thn =$arrtgl[0];
			//if ($thn<=$Main->TAHUN_CLOSING) $err = 'Data Tidak Dapat Disimpan!, Tahun '.$Main->TAHUN_CLOSING.' sudah closing'; 
		}				
		//tgl >=tgl_buku
		if($err =='' && compareTanggal($bi['tgl_buku'],$tgl)==2) $err = 'TANGGAL BUKU tidak kecil dari Tanggal Buku Barang !';				
		$tgl_closing=getTglClosing($bi['c'],$bi['d'],$bi['e'],$bi['e1'],$bi['c1']); 
		$tgl_susutAkhir = mysql_fetch_array(mysql_query("select tgl from penyusutan where idbi_awal='$idbi' order by tgl desc limit 1"));
				
		$nilai_buku = getNilaiBuku($idbi,$tgl,0);
		$nilai_susut = getAkumPenyusutan($idbi,$tgl);	
		switch ($fmST){
			case 0 : { //baru
				//- tanggal >= tgl terakhir transaski u/ barang ini
				if($err=='' && $old['tgl'] <> $tgl ){ 			
					/**$get = mysql_fetch_array(mysql_query(
						"select max(tgl) as maxtgl from t_asetlainlain where idbi_awal ='$idbi_awal'  "
					));**/
					/*$get = mysql_fetch_array(mysql_query(
						"select max(tgl) as maxtgl from t_history_aset where idbi_awal ='$idbi_awal'  "
					));
					if( compareTanggal( $tgl, $get['maxtgl'] )==0  ) $err = "TANGGAL BUKU tidak lebih kecil dari transaksi sebelumnya!";*/
				}	
				if($err=='' && $tgl<=$tgl_closing)$err ='Tanggal sudah Closing !';				
				if($err=='' && $tgl<=$tgl_susutAkhir['tgl'])$err ='Sudah ada penyusutan !';
				
				$maxtrans = mysql_fetch_array(mysql_query("select max(tgl_buku) as maxtgl from t_transaksi where idawal='$idbi_awal'"));
				if($err=='' && compareTanggal($tgl, $maxtrans['maxtgl'])==0  ) $err = 'TANGGAL BUKU tidak lebih kecil dari tanggal transaksi sebelumnya!';
		
				if($err==''){
					$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id='$idbi'"));
					
					$staset = $bi['staset'];
					if($staset == 9){
						//$staset_baru =  getStatusAset('', $kondisi_baru, $bi['harga'], $bi['f'], $bi['g'], $bi['h'], $bi['i'], $bi['j'] ) 	;
						$staset_baru= $bi['f']=='07' ? 8: 3;
					}else{
						$staset_baru = 9;
					}
					
					$aqry = "insert into t_asetlainlain (tgl,idbi,uid,tgl_update,staset,staset_baru,ket, kondisi,kondisi_baru,idbi_awal,nilai_buku,nilai_susut,no_bast,tgl_bast,dokumen_sumber) ".
						" values('$tgl','$idbi','$uid',now(),'$staset','$staset_baru','$ket', '$kondisi','$kondisi_baru','".$bi['idawal']."','$nilai_buku','$nilai_susut','$no_bast','$tgl_bast','$dok_sumber') "; $cek .= $aqry;
					$qry = mysql_query($aqry);		
					$newid= mysql_insert_id();
					if($qry){
						mysql_query("update buku_induk set staset = '$staset_baru' where  id='$idbi' ");	
						//jurnal
						$jur = jurnalAsetLainLain($bi, $idbi,$uid,$tgl,1, FALSE, $newid);
						$cek .= $jur['cek']; $err .=$jur['err'];
						//history Aset
						mysql_query(
							"insert into t_history_aset ".
							"(tgl,idbi,uid,tgl_update,staset,staset_baru,div_staset,idbi_awal,jns,refid) ".
							" values ".
							"('$tgl','$idbi','$uid',now(),'$staset','$staset_baru','".($staset_baru-$staset)."','".$bi['idawal']."',2,'$newid' )"
						);
					}
				}
				break;
			}
			case 1 : { //edit
				
				if($err==''){
					if($old['tgl'] <> $tgl){
						//$query = "select Id from t_asetlainlain where idbi_awal='$idbi_awal'  order by tgl desc, Id desc limit 0,1";
						$query = "select * from t_history_aset where idbi_awal='$idbi_awal'  order by tgl desc, Id desc limit 0,1";
						$check = mysql_fetch_array(mysql_query($query));					
						$cek .= $query;
						if($check['refid'] != $Id && $check['jns']!=2  ) $err = "Hanya status aset terakhir yang dapat di edit!\nKecuali Keterangan"; //hanya transaksi terkahir yg boleh diedit 						
					}
				}				
				if($err=='' && $old['tgl'] <> $tgl ){ 			
					//- tanggal >= tgl terakhir transaski u/ barang ini
					$get = mysql_fetch_array(mysql_query(
						"select max(tgl) as maxtgl from t_kapitalisasi where idbi_awal ='$idbi_awal'  and Id<>'$Id'  "
					));
					if( compareTanggal( $tgl, $get['maxtgl'] )==0  ) $err = "Tanggal tidak lebih kecil dari transaksi sebelumnya!";
					
					//tgl utk transaksi pertama (staset=null) harus sama dgn tanggal buku
					if($err=='' && ($old['staset']==0 || $old['staset']==NULL) ) $err = "Tanggal harus sama dengan tanggal buku perolehan barang!";				
				}
				
				/*
				if($errmsg=='' && $fmST!=1){ //cek tahun pelihara baru <= thn closing edit
					$old = mysql_fetch_array(mysql_query(
							"select * from pemeliharaan where id = '$idplh';"
						));
					$arrtgl = explode('-',$old['tgl_pemeliharaan']);
					$thnpelihara =$arrtgl[0];
					if ($thnpelihara<=$Main->TAHUN_CLOSING) $errmsg = 'Data Tidak Dapat Disimpan!, Tahun '.$Main->TAHUN_CLOSING.' sudah closing'; 
				}
				*/
				
				if($err=='' && ($old['tgl']<=$tgl_closing) ) $err = "Reklas tidak bisa di edit, tanggal sudah closing !";
				if($err=='' && ($old['tgl']<$tgl_susutAkhir['tgl']) ) $err = "Reklas tidak bisa di edit, sudah penyusutan !";
				
				if($err==''){
					$aqry = "UPDATE t_asetlainlain 
							set tgl='$tgl', 
							uid='$uid', 
							tgl_update = now(), 
							nilai_buku='$nilai_buku', 
							nilai_susut='$nilai_susut',
							ket='$ket' 
							WHERE Id='".$Id."'";	
							$cek .= $aqry;
					$qry = mysql_query($aqry) or die(mysql_error());
					if($qry){
						mysql_query(
							"update t_history_aset set tgl='$tgl', uid='$uid', tgl_update=now() where jns=2 and refid='$Id'"
						);
					}
				}
			
				break;
			}
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function simpanpenghapusan(){
		global $Main, $HTTP_COOKIE_VARS;
		$uid = $HTTP_COOKIE_VARS['coID'];
	 	$cek = ''; $err=''; $content=''; $json=TRUE;
		$idubah = $_REQUEST['idubah'];	
		$dok_sumber = $_REQUEST['dok_sumber'];
		$no_bast = $_REQUEST['no_bast'];
		$fmTAMBAHMasaManfaat = $_REQUEST['fmTAMBAHMasaManfaat'];
		$trans = $_REQUEST['trans'];
		$idbibaru = $trans==5?$_REQUEST['idbibaru']:$_REQUEST['idbibaru2'];//jika 5=doublecatat,6=penggabungan
		$tgl_bast = date('Y-m-d', strtotime($_REQUEST['tgl_bast'].'-'.$_REQUEST['thn_ba']));
		//$tgl = date('Y-m-d', strtotime($_REQUEST['tgl']));		
		$tgl = date('Y-m-d', strtotime($_REQUEST['tgl'].'-'.$_REQUEST['thn_buku']));
		$tgl_perolehan = date('Y-m-d', strtotime($_REQUEST['tgl_perolehangabung']));		
		$old = mysql_fetch_array(mysql_query(
			"select * from buku_induk where id='$idubah'"
		));
		$fmIsMutasi = $trans==5?5:4;//ti tbl penghapusan 4=penggabungan, 5=penghapusan koreksi, 
		$fmTglBuku = $old['tgl_buku'];
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
		$tgl_update = $old['tgl_update'];
		$nilai_buku = getNilaiBuku($idbi,$tgl_buku,0);
		//cek tgl hapus				
		if($err=='' && $dok_sumber=='') $err = 'DOKUMEN SUMBER belum dipilih !';
		if($err=='' && $no_bast=='') $err = 'NOMOR belum diisi !';
		if($err=='' && $_REQUEST['tgl_bast']=='') $err = 'TANGGAL belum diisi!';
		if($err=='' && $_REQUEST['tgl']=='') $err = 'TANGGAL BUKU belum diisi!';		
		if ($err=='' && !cektanggal($tgl)){ $err = 'TANGGAL BUKU salah!'; }		
		if ($err =='' && compareTanggal($tgl, date('Y-m-d'))==2  ) $err = 'TANGGAL BUKU tidak lebih besar dari Hari ini!';				
		if ($err=='' &&  compareTanggal($tgl, $fmTglBuku)==0 ){ $err = 'TANGGAL BUKU tidak lebih kecil dari Tanggal Buku barang!'; }		
		//if ($err=='' && sudahClosing($tgl,$c,$d,$e,$e1,$c1) ) $err = 'TANGGAL BUKU harus lebih besar dari Tanggal Closing !';
		if ($err=='' && ($trans==5 && $idbibaru=="" )) $err = 'DENGAN ID DATA belum diisi !';
		if ($err=='' && ($trans==6 && $idbibaru=="" )) $err = 'ID DATA INDUK belum diisi !';
		
		
		//VALIDASI PEMELIHARAAN
		$tgl_susutAkhir = tglSusutAkhir($idbi);
		//$tgl_susutAkhir = mysql_fetch_array(mysql_query("select tgl from penyusutan where idbi='$idbi' and jns_trans2=30 and id_koreksi=0 order by id desc limit 1"));
		$tgl_korAkhir = mysql_fetch_array(mysql_query("select tgl,tgl_create from t_koreksi where idbi_awal='$idbiawal' order by tgl desc limit 1"));
		$tgl_nilaiAkhir = mysql_fetch_array(mysql_query("select tgl_penilaian,tgl_create from penilaian where idbi_awal='$idbiawal' order by tgl_penilaian desc limit 1"));
		$tgl_hpsAkhir = mysql_fetch_array(mysql_query("select tgl_penghapusan,tgl_create from penghapusan_sebagian where idbi_awal='$idbiawal' order by tgl_penghapusan desc limit 1"));
		$tgl_asetAkhir = mysql_fetch_array(mysql_query("select tgl,tgl_create from t_history_aset where idbi_awal='$idbiawal' order by tgl desc limit 1"));
		
		$get_ba = mysql_fetch_array(mysql_query("select tgl_ba from buku_induk where idawal='$idbiawal'"));		
		if($get_ba['tgl_ba']=='0000-00-00' or $get_ba['tgl_ba']=='' or $get_ba['tgl_ba']==NULL){ 
			$gentgl_perolehan = $old['thn_perolehan'].'-'.date("m", strtotime($old['tgl_buku'])).'-'.date("d",strtotime($old['tgl_buku']));			
		}else{
			$gentgl_perolehan = $get_ba['tgl_ba'];
		}
		
		if($errmsg =='' && compareTanggal($old['tgl_buku'],$tgl)==2) $errmsg = 'Tanggal Buku Pemeliharaan tidak lebih kecil dari Tanggal Buku Barang !';				
		if($errmsg =='' && $thn_Perolehan<$old['thn_perolehan']) $errmsg = 'Tahun Perolehan Pemeliharaan tidak lebih kecil dari Tahun Perolehan Buku Barang !';				
		if($errmsg=='' && $fmTANGGALPerolehan<$gentgl_perolehan)$errmsg ='Tanggal Perolehan tidak lebih kecil dari Tanggal BAST/Buku Barang !';
		if($errmsg=='' && $tgl<=$tgl_closing)$errmsg ='Tanggal sudah Closing !';
		if($errmsg=='' && $tgl<=$tgl_susutAkhir['tgl'])$errmsg ='Sudah ada penyusutan !';
		if($errmsg=='' && $tgl<$tgl_korAkhir['tgl'] )$errmsg ='Sudah ada koreksi harga !';
		if($errmsg=='' && $tgl<$tgl_nilaiAkhir['tgl_penilaian'] )$errmsg ='Sudah ada penilaian !';
		if($errmsg=='' && $tgl<$tgl_hpsAkhir['tgl_penghapusan'] )$errmsg ='Sudah ada penghapusan sebagian !';
		if($errmsg=='' && $tgl<$tgl_asetAkhir['tgl'] )$errmsg ='Sudah ada perubahan status aset !';
		//-----------------------------------------------
		$maxtrans = mysql_fetch_array(mysql_query("select max(tgl_buku) as maxtgl from t_transaksi where idawal='$idbiawal'"));
		if($err=='' && compareTanggal($tgl, $maxtrans['maxtgl'])==0  ) $err = 'TANGGAL BUKU tidak lebih kecil dari tanggal transaksi sebelumnya!';
		
		//cek tgl BA
		if($err==''){
			//$idbi = $fmIDBUKUINDUK;
			$cekba = mysql_fetch_array(mysql_query(
					"select * from buku_induk where id='$idbi'"
			));
			if($cekba['tgl_ba'] == '') $err = 'Tanggal Berita Acara Perolehan Barang belum diisi! Isi di Penatausahaan - Edit';
		}
		if($err == ''){
			$ceksusut = mysql_fetch_array(mysql_query("select tgl as tgl_penyusutan from penyusutan where idbi=$idbi order by Id desc limit 0,1"));
			if($tgl <= $ceksusut['tgl_penyusutan']) $err = 'Gagal penghapusan, sudah penyusutan !';
		}
		//if ($bi['status_barang'] <> 1) $err = 'Gagal penghapusan , status barang bukan inventaris!';
		if ($idbibaru == $idbiawal) $err = 'Barang sama !';
		if ($bi['status_barang'] == 3) $err = 'Barang sudah di Penghapusan!';
		//if ($bi['status_barang'] == 4) $err = 'Barang sudah di Pemindahtanganan!';
		if ($bi['status_barang'] == 5) $err = 'Barang sudah di Tuntutan Ganti Rugi!';
		//if ($bi['thn_perolehan'] < 1945 ) $err = 'Tahun Perolehan tidak lebih kecil dari 1945!';
		$transaksi = mysql_fetch_array(mysql_query("select max(tgl_buku) as maxtgl from t_transaksi where idbi = '$idbi'"));
		if ($err=='' && (compareTanggal( $tgl , $transaksi['maxtgl']  )==0) ) $err = 'TANGGAL BUKU harus lebih besar dari Tanggal Transaksi!';
		if ($err==''){
			$field = $trans ==5?'idbi_doublecatat':'idbi_penggabungan';		
			$Qry = "insert into penghapusan (a1,a,b,c1,c,d,e,e1,f,g,h,i,j,id_bukuinduk,noreg,thn_perolehan,$field,".
					"tgl_penghapusan,tahun, mutasi, kondisi_akhir, nosk, tglsk, tgl_update, uid,staset,idbi_awal,nilai_buku,nilai_susut,tgl_create,uid_create)".
					"values ('$a1_awal','$a_awal','$b_awal','$c1_awal','$c_awal','$d_awal','$e_awal','$e1_awal','$f_awal','$g_awal','$h_awal','$i_awal','$j_awal','$idbi','$noreg','$thn_perolehan','$idbibaru',".
					"'$tgl','$tahun','$fmIsMutasi','$kondisi','$no_bast','$tgl_bast','$tgl_update','$uid_lama','$staset','$idbiawal','$nilai_buku','$nilai_susut',NOW(),'$uid')";
					//echo "<br>qry=".$Qry;
				//$cek.='cek='.$Qry;
				$Penghapusan_Simpan = mysql_query($Qry);
				//$idhps = mysql_insert_id();				
				if ($Penghapusan_Simpan){				
					$UpdateBI = mysql_query("update buku_induk set status_barang='3' where id='$idbi'");
				}
				
		if ($UpdateBI==TRUE && $trans==6){
					$fmTAMBAHASET = 1;
					//$fmTAMBAHMasaManfaat = 0;
					$aqry = "insert into pemeliharaan (id_bukuinduk,tgl_pemeliharaan,tgl_create,uid_create,".
					"biaya_pemeliharaan,idbi_awal,tambah_aset,tambah_masamanfaat, cara_perolehan,tgl_perolehan,no_bast,tgl_bast,idasal ) ".
					"values ('$idbibaru','$tgl',NOW(),'$uid',".
					"'$nilai_buku','$idbiawal','$fmTAMBAHASET','$fmTAMBAHMasaManfaat','4','$tgl_perolehan','$no_bast','$tgl_bast','$idbi') ";//echo "errmsg=$aqry<r>";
					$cek.='cek='.$aqry;
					$sukses = mysql_query($aqry);
				}
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function simpanhpsbagian(){
		global $Main, $HTTP_COOKIE_VARS;
		$uid = $HTTP_COOKIE_VARS['coID'];
	 	$cek = ''; $err=''; $content=''; $json=TRUE;
		$idubah = $_REQUEST['idubah'];	
		$dok_sumber = $_REQUEST['dok_sumber'];
		$fmSURATNOMOR = $_REQUEST['no_bast'];
		$fmHARGA_AWAL = $_REQUEST['fmHARGA_AWAL'];
		$fmHARGA_HAPUS = $_REQUEST['fmHARGA_HAPUS'];
		$fmHARGA_SCRAP = $_REQUEST['fmHARGA_SCRAP'];
		$fmHARGA_BUKU = $_REQUEST['fmHARGA_BUKU'];
		$fmKET = $_REQUEST['fmKET'];
		$fmSURATTANGGAL = date('Y-m-d', strtotime($_REQUEST['tgl_bast'].'-'.$_REQUEST['thn_ba']));
		//$tgl = date('Y-m-d', strtotime($_REQUEST['tgl']));		
		$fmTANGGALPENGHAPUSAN = date('Y-m-d', strtotime($_REQUEST['tgl'].'-'.$_REQUEST['thn_buku']));
		$fmTANGGALPEROLEHAN = date('Y-m-d', strtotime($_REQUEST['tgl_perolehanhpsbagian']));		
		$thn_PEROLEHAN= substr($fmTANGGALPEROLEHAN,0,4);
		
		$bi = mysql_fetch_array(mysql_query(
			"select * from buku_induk where id='$idubah'"
		));
		$idbi = $bi['id'];
		$idbi_awal = $bi['idawal'];
		$fmTglBuku = $bi['tgl_buku'];
		$nilai_buku = getNilaiPerolehan($idbi,$fmTANGGALPENGHAPUSAN);
		//cek tgl hapus				
		if($err=='' && $dok_sumber=='') $err = 'DOKUMEN SUMBER belum dipilih !';
		if($err=='' && $fmSURATNOMOR=='') $err = 'NOMOR belum diisi !';
		if($err=='' && $_REQUEST['tgl_bast']=='') $err = 'TANGGAL belum diisi!';
		if($err=='' && $_REQUEST['tgl']=='') $err = 'TANGGAL BUKU belum diisi!';		
		if ($err=='' && !cektanggal($fmTANGGALPENGHAPUSAN))$err = 'TANGGAL BUKU salah!';		
		if ($err =='' && compareTanggal($fmTANGGALPENGHAPUSAN, date('Y-m-d'))==2  ) $err = 'TANGGAL BUKU tidak lebih besar dari Hari ini!';				
		if ($err=='' &&  compareTanggal($fmTANGGALPENGHAPUSAN, $fmTglBuku)==0 )$err = 'TANGGAL BUKU tidak lebih kecil dari Tanggal Buku barang!';				
		if ($err =='' && compareTanggal($fmTANGGALPEROLEHAN,$fmTANGGALPENGHAPUSAN )==2) $err = 'TANGGAL PEROLEHAN tidak lebih besar dari TANGGAL BUKU !';
		if($err =='' && $_REQUEST['tgl_perolehanhpsbagian']==''){ $err = 'TANGGAL PEROLEHAN belum diisi!';	}		
		if($err =='' && ($fmHARGA_AWAL == '' || $fmHARGA_AWAL==0) )$err = 'NILAI PEROLEHAN belum diisi!';			
		if($err =='' && ($fmHARGA_HAPUS == '' || $fmHARGA_HAPUS==0) )$err = 'NILAI PENGHAPUSAN belum diisi!';			
		if($err =='' && ($fmHARGA_HAPUS > $fmHARGA_BUKU) )$err = 'NILAI PENGHAPUSAN harus lebih kecil dari NILAI BUKU!';			

		if( $err =='' & (!($fmSURATTANGGAL == '0000-00-00' || $fmSURATTANGGAL==''))){
		 	if( !cektanggal($fmSURATTANGGAL)){ 	$err = 'Tanggal Surat Salah!';}
			if ($err =='' && compareTanggal($fmSURATTANGGAL, date('Y-m-d'))==2  ) $err = 'Tanggal Surat tidak lebih besar dari Hari ini!';				
		}
		if ($err=='' && $fmst==1){
		 $err=HapusSebagian_CekdataCutoff('insert',$idplh,$fmTANGGALPENGHAPUSAN,$idbi);	
		 }
		 
		$get_cd = mysql_fetch_array(mysql_query("select c1,c,d,e,e1,tgl_buku,thn_perolehan from buku_induk where id='$idbi'"));
		$tgl_closing=getTglClosing($bi['c'],$bi['d'],$bi['e'],$bi['e1'],$bi['c1']);  
		//get tglakhir susut,koreksi,penilaian,penghapusan_sebagian dgn idbi_awal yg sama
		$tgl_susutAkhir = tglSusutAkhir($idbi);
		//$tgl_susutAkhir = mysql_fetch_array(mysql_query("select tgl from penyusutan where idbi='$idbi' and jns_trans2=30 and id_koreksi=0 order by id desc limit 1"));
		$tgl_korAkhir = mysql_fetch_array(mysql_query("select tgl,tgl_create from t_koreksi where idbi_awal='$idbi_awal' order by tgl desc limit 1"));
		$tgl_nilaiAkhir = mysql_fetch_array(mysql_query("select tgl_penilaian,tgl_create from penilaian where idbi_awal='$idbi_awal' order by tgl_penilaian desc limit 1"));
		$tgl_hpsAkhir = mysql_fetch_array(mysql_query("select tgl_penghapusan,tgl_create from penghapusan_sebagian where idbi_awal='$idbi_awal' order by tgl_penghapusan desc limit 1"));
		
		$get_ba = mysql_fetch_array(mysql_query("select tgl_ba from buku_induk where idawal='$idbi_awal'"));		
		if($get_ba['tgl_ba']=='0000-00-00' or $get_ba['tgl_ba']=='' or $get_ba['tgl_ba']==NULL){
			$gentgl_perolehan = $bi['thn_perolehan'].'-'.date("m", strtotime($bi['tgl_buku'])).'-'.date("d",strtotime($bi['tgl_buku']));			
		}else{
			$gentgl_perolehan = $get_ba['tgl_ba'];
		}
		
		if($err =='' && compareTanggal($bi['tgl_buku'],$fmTANGGALPENGHAPUSAN)==2) $err = 'TANGGAL BUKU tidak kecil dari Tanggal Buku Barang !';				
		if($err =='' && $thn_PEROLEHAN<$bi['thn_perolehan']) $err = 'Tahun Perolehan tidak kecil dari Tahun Perolehan Buku Barang !';				
		if($err=='' && $fmTANGGALPEROLEHAN<$gentgl_perolehan)$err ='TANGGAL PEROLEHAN tidak lebih kecil dari Tanggal BAST/Buku Barang !';
		if($err=='' && $fmTANGGALPENGHAPUSAN<=$tgl_closing)$err ='Tanggal sudah Closing !';
		if($err=='' && $fmTANGGALPENGHAPUSAN<=$tgl_susutAkhir['tgl'])$err ='Sudah ada penyusutan !';
		if($err=='' && $fmTANGGALPENGHAPUSAN<$tgl_korAkhir['tgl'] )$err ='Sudah ada koreksi harga !';
		if($err=='' && $fmTANGGALPENGHAPUSAN<$tgl_nilaiAkhir['tgl_penilaian'] )$err ='Sudah ada penilaian !';
		if($err=='' && $fmTANGGALPENGHAPUSAN<$tgl_hpsAkhir['tgl_penghapusan'] )$err ='Sudah ada penghapusan sebagian !';
		
		$maxtrans = mysql_fetch_array(mysql_query("select max(tgl_buku) as maxtgl from t_transaksi where idawal='$idbi_awal'"));
		if($err=='' && compareTanggal($fmTANGGALPENGHAPUSAN, $maxtrans['maxtgl'])==0  ) $err = 'TANGGAL BUKU tidak lebih kecil dari tanggal transaksi sebelumnya!';
					
		
		if ($err==''){
			$aqry = "insert into penghapusan_sebagian (id_bukuinduk,tgl_penghapusan,". 
					"surat_no, surat_tgl, harga_awal,harga_hapus,harga_scrap,  ket, idbi_awal, tgl_update, uid, tgl_perolehan  )". 
					"values ('$idbi','$fmTANGGALPENGHAPUSAN',".    
						"'$fmSURATNOMOR', '$fmSURATTANGGAL', '$fmHARGA_AWAL', '$fmHARGA_HAPUS', '$fmHARGA_SCRAP',  '$fmKET',".
						"'$idbi_awal', now(), '$uid','$fmTANGGALPEROLEHAN') ";
				//$cek.='cek='.$aqry;
				$sukses = mysql_query($aqry);
				//$idhps = mysql_insert_id();				
				if($sukses  ){
					$id = mysql_insert_id();
					if($Main->MODUL_JURNAL) jurnalHapusSebagian($id,$uid,1);
				}
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function PilihTrans(){
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;
				
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
		$Id = $_REQUEST['idubah'];		
		$trans = $_REQUEST['trans'];		
		
		$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id = '$Id' "));
		$idbi_awal = $bi['idawal'];
		if($trans==4 && ($bi['staset']==5 || $bi['staset']==6 || $bi['staset']==7)){
			$err = "Barang ".$Main->StatusAsetView[$bi['staset']-1][1]." tidak bisa reklas ke Aset Lain-Lain ! ";
		}
		if($trans==3 && ($bi['staset']==5 || $bi['staset']==6 || $bi['staset']==7 || $bi['staset']==9)) $err = 'Barang '.$Main->StatusAsetView[$bi['staset']-1][1].' tidak bisa di Kapitalisasi!';
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function GetHrg_Asal(){
		$cek = ''; $err=''; $content=''; 
	 	$json = TRUE;	//$ErrMsg = 'tes';
		$trans = $_REQUEST['trans'];			
		//$tgl_= $_REQUEST['tgl'];			
		$tgl = date('Y-m-d', strtotime($_REQUEST['tgl'].'-'.$_REQUEST['thn_buku']));		
		$gettgl_perolehan = $trans==1?$_REQUEST['tgl_perolehan']:$_REQUEST['tgl_perolehanhpsbagian'];//1=KOREKSI HARGA		
		$tgl_perolehan = date('Y-m-d', strtotime($gettgl_perolehan));$cek.='cek='.$gettgl_perolehan;
		$idbukuinduk= $_REQUEST['idubah'];			
		$nilai_buku = getNilaiPerolehan($idbukuinduk,$tgl_perolehan);
		$content->hrg2 = number_format($nilai_buku,2,',','.');		
		$content->hrg = $nilai_buku;	
		
		
		$nilai_buku = getNilaiBuku($idbukuinduk,$tgl_perolehan,0);
		$nilai_susut = getAkumPenyusutan($idbukuinduk,$tgl_perolehan);	
		$fmHARGA_BUKU = $nilai_buku - $nilai_susut;
		$content->fmHARGA_BUKU2 = number_format($fmHARGA_BUKU,2,',','.');		
		$content->fmHARGA_BUKU = $fmHARGA_BUKU;		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	 	
	}
}
$updatebarang = new updatebarangObj();

?>