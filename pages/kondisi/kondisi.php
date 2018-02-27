<?php

class KondisiObj  extends DaftarObj2{	
	var $Prefix = 'Kondisi';
	var $elCurrPage="HalDefault";
	var $TblName = 'v_t_kondisi'; //daftar
	var $TblName_Hapus = 't_kondisi';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');//('p','q'); //daftar/hapus
	var $FieldSum = array('jml_harga','nilai_susut');//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 8, 8, 8);//berdasar mode
	var $FieldSum_Cp2 = array( 4, 4, 4);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'Pelaporan';
	var $PageIcon = 'images/pelaporan_ico.png';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pegawai.xls';
	var $Cetak_Judul = 'Pelaporan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $fieldSum_lokasi = array(9,10);
	var $totalCol = 15;	
	//function setPage_TitleDaftar(){	return 'Daftar Pegawai'; }	
	//function setPage_TitlePage(){		return 'Referensi Data';			}
	function setTitle(){
		return 'Mutasi Kondisi';
	}
	
	function setMenuEdit(){
		
		return
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
			
			//"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Recycle Bin", 'Batalkan SPPT')."</td>";
			'';
	}
	
	
	function Simpan(){
		global $Main, $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;
				
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$Id = $_REQUEST['Id'];
		$idbi = $_REQUEST['idbi'];
		$idbi_awal = $_REQUEST['idbi_awal'];
		$tgl = $_REQUEST['tgl'];
		$tgl_bast = $_REQUEST['tgl_bast'];
		$no_bast = $_REQUEST['no_bast'];
		$uid = $HTTP_COOKIE_VARS['coID'];
		$ket = $_REQUEST['ket'];
		$kondisi = $_REQUEST['kondisi'];
		$kondisi_baru = $_REQUEST['kondisi_baru'];
		$dif_kondisi = $_REQUEST['kondisi_baru']-$_REQUEST['kondisi'];
		$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id = '$idbi' "));
		$idbi_awal = $bi['idawal'];
		
		
		$old = mysql_fetch_array(mysql_query("select * from t_kondisi where Id='$idplh' "));
		if($err=='' && sudahClosing($tgl,$bi['c'],$bi['d'],$bi['e'],$bi['e1'],$bi['c1']))$err = 'Tanggal sudah Closing !';		
		if($err=='' && $tgl=='') $err = 'Tanggal belum diisi!';		
		if($err=='' && !cektanggal($tgl))$err = "Tanggal $tgl Salah!";					
		// - tanggal harus <= tgl hari ini
		if ($err =='' && compareTanggal($tgl, date('Y-m-d'))==2  ) $err = 'Tanggal tidak lebih besar dari Hari ini!';						
		//tgl >=tgl_buku
		if( compareTanggal( $tgl, $bi['tgl_buku'] )==0  ) $err = "Tanggal tidak lebih kecil dari Tanggal Buku!";
		
				
		switch ($fmST){
			case 0 : { //baru
				//- tanggal >= tgl terakhir transaski u/ barang ini
				if($err=='' && $old['tgl'] <> $tgl ){ 			
					$get = mysql_fetch_array(mysql_query(
						"select max(tgl_buku) as maxtgl from t_transaksi where idawal ='$idbi_awal'  "
					));
					if( compareTanggal( $tgl, $get['maxtgl'] )==0 ) $err = "Tanggal tidak lebih kecil dari transaksi sebelumnya!";
				}	
				if($err==''){
					$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id='$idbi'"));
					$aqry = "insert into t_kondisi (tgl,idbi,uid,tgl_update,ket, kond_awal,kond_akhir,idbi_awal,dif_kondisi) ".
						" values('$tgl','$idbi','$uid',now(),'$ket', '$kondisi','$kondisi_baru','".$bi['idawal']."','$dif_kondisi') "; $cek .= $aqry;
					$qry = mysql_query($aqry);		
//					$newid= mysql_insert_id();
					if($qry){
						$upd_bi = "update buku_induk set kondisi = '$kondisi_baru' where  id='$idbi'";$cek .= $upd_bi;
						mysql_query($upd_bi);						
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
							set tgl_bast='$tgl_bast', 
							no_bast='$no_bast', 
							tgl='$tgl', 
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
	
	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){
			case 'formBaruKondisi':{				
				$fm = $this->setBaruKondisi();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
				//$content = 'tesssss';
				break;
			} 	
			case 'formEdit':{				
				$fm = $this->setFormEdit();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
				break;
			}
			case 'simpan':{
				$get = $this->Simpan();					
				//$get = array('cek'=>'', 'err'=>'ggal','content'=>'', 'json'=>TRUE);
				$cek = $get['cek'];
				$err = $get['err'];
				$content=$get['content'];
				$json=$get['json'];
				break;
			}
			/*case 'formBaru':{				
				$fm = $this->setFormBaru();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
				break;
			}
			*/
			/*case 'formKondisiSimpan':{				
				$get= $this->formKondisiSimpan();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
				break;
			}*/
			
			default:{
				$other = $this->set_selector_other2($tipe);
				$cek = $other['cek'];
				$err = $other['err'];
				$content=$other['content'];
				$json=$other['json'];
				break;
			}			
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function Hapus($ids){ //validasi hapus
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++){
			//cek id terakhir
			$old = mysql_fetch_array(mysql_query("select * from t_kondisi where Id='".$ids[$i]."' "));
			$idbi_awal = $old['idbi_awal'];
			$idbi = $old['idbi'];
			$kond_awal = $old['kond_awal'];
			$staset_lama = $old['staset_lama'];
			$aqry = mysql_fetch_array(mysql_query("select Id from t_kondisi where idbi_awal='$idbi_awal' order by tgl desc, Id desc limit 0,1"));
			//$cek .= $aqry['Id'];
			if($err == '' && $ids[$i] != $aqry['Id']) $err = "Hanya kondisi terakhir yang bisa dihapus!";
			if($err == '' && $kond_awal==0) $err = "Tidak bisa dihapus, Kondisi awal kosong!";
			 
			if($err == ''){
				$aqry2 = "delete from t_kondisi where Id='".$ids[$i]."' "; $cek = $aqry2;
				$qry = mysql_query($aqry2);
				if($qry){
					//$aqry3 = mysql_fetch_array(mysql_query("select kond_awal from t_kondisi where idbi_awal='$idbi_awal' order by tgl desc, Id desc limit 0,1"));
					$aqry = "update buku_induk set kondisi = '$kond_awal',staset='$staset_lama' where id='$idbi' "; $cek .= $aqry;
					mysql_query($aqry);
				}
			}	
		}
		return array('err'=>$err,'cek'=>$cek);
	}
	
	//form ==================================
	function setBaruKondisi(){
		global $Main;
		$dt=array();
		$dt['c'] = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$dt['d'] = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$dt['e'] = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		
		
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		
		$cidBI = $_REQUEST['cidBI'];
		$idbi = $cidBI[0];// 735615;
		$aqry = "select * from buku_induk where id ='$idbi'"; $cek .= $aqry;
		$bi = mysql_fetch_array(mysql_query($aqry));
		
		$dt['idbi']= $idbi;
		$dt['tgl'] =  Date('Y-m-d');
		$dt['kondisi'] = $bi['kondisi'];
		$dt['kondisi_baru'] = $bi['kondisi'];
			
		//if($err=='' && ($bi['staset']==5 || $bi['staset']==6 || $bi['staset']==7)) $err = 'Barang '.$Main->StatusAsetView[$bi['staset']-1][1].' ini tidak bisa di reclass ke Aset Lain-lain!';
		if($err==''){		
			$fm = $this->setForm($dt);
		}
		return	array ('cek'=>$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}
	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		//$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		//$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		//$e = $_REQUEST[$this->Prefix.'SkpdSUBUNIT'];
				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		
		//get data 
		$aqry = "select * from t_kondisi where id ='".$this->form_idplh."'  "; 
		$get = mysql_fetch_array(mysql_query($aqry));
		$dt['idbi']= $get['idbi'];
		$dt['tgl_bast'] =  $get['tgl_bast'];		
		$dt['no_bast'] =  $get['no_bast'];		
		$dt['tgl'] =  $get['tgl'];		
		$dt['kondisi'] = $get['kond_awal'];
		$dt['kondisi_baru'] = $get['kond_akhir'];
		$dt['ket'] = $get['ket'];
		$cek.=$aqry;
		$fm = $this->setForm($dt);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	
	function setForm($dt){
		global $Main;
		global $HTTP_COOKIE_VARS;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$thn_login = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$tgl_buku =	$thn_login.'-00-00';
		$form_name = $this->Prefix.'_form';				
		$this->form_width = 450;
		$this->form_height = $Main->STASET_OTOMATIS? 190: 210;
		$idbi = $dt['idbi'];
		$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id = '$idbi' "));
		
		/*if($err=='' && !( $bi['staset']==9 || $bi['staset']==3 ) ){
			$err = $Main->StatusAsetView[$bi['staset']-1][1]." tidak bisa reklas ke Aset Lain-Lain ! ";
		}*/
		
		if($err==''){
			$caption = 'Kondisi Barang' ;
			if ($this->form_fmST==0) {		
				$this->form_caption = $caption.' - Baru';				
				$tgl = $tgl_buku;
			}else{
				$this->form_caption = $caption.' - Edit';
				$tgl = $dt['tgl'];
				$tgl_bast = $dt['tgl_bast'];
				
			}	
			//$tgl = $dt['tgl'];
			$vtgl = createEntryTgl(	'tgl', $tgl, 	false, 	'', 	'','adminForm','0');
			
			$vkondisi = $Main->KondisiBarang[$dt['kondisi']-1][1];	
			$stkondisi = "<input type='hidden' id='kondisi' name='kondisi' value ='".$dt['kondisi']."' >";
			//$stkondisi_baru = "<input type='hidden' id='kondisi_baru' name='kondisi_baru' value ='".$bi['kond_akhir']."' >";
						
			$vkondisi_baru = cmb2D_v2( 'kondisi_baru',$dt['kondisi_baru'],$Main->KondisiBarang );
					
					$this->form_fields = array(							
						'tgl_bast' => array(  'label'=>'Tanggal Berita Acara', 'value'=> createEntryTgl('tgl_bast', $tgl_bast, 	false, 	'', 	'','adminForm','0'),  'type'=>'' ),
						'no_bast' => array(  'label'=>'No Berita Acara', 'value'=> "<input type='text' name='no_bast' id='no_bast' value='".$dt['no_bast']."'"),
						'tgl' => array(  'label'=>'Tanggal Buku Kondisi', 'value'=> $vtgl,  'type'=>'' ),
						'kondisi' => array(  'label'=>'Kondisi Awal', 'value'=> $vkondisi.$stkondisi, 'labelWidth'=>150, 'type'=>'' ),
						'kondisi_baru' => array(  'label'=>'Kondisi Akhir', 'value'=> $vkondisi_baru, 'type'=>'' ),
						'ket'=> array(  'label'=>'Keterangan', 'value'=> "<textarea id='ket' name='ket' style='width: 234px;height: 35px;'>".$dt['ket']."</textarea>", 'type'=>'' )
					);
			
			
			
							
			//tombol
			$this->form_menubawah =			
				"<input type='hidden' name='idbi' id='idbi' value='$idbi'>".
				"<input type='hidden' name='idbi_awal' id='idbi_awal'  value='".$dt['idbi_awal']."'>".
				"<input type='hidden' name='Id' id='Id' value='".$dt['Id']."'>".
				"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' >&nbsp;".
				"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
					
			$form = $this->genForm();		
					
			$content = $form;//$content = 'content';
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
		$NomorColSpan = $Mode==1? 2: 1;
		$headerTable =
			"<thead>
				<tr>
				
				<th class='th01' width='10' rowspan='2'>No.</th>
				$Checkbox		
				<!--<th class='th01' width='80' rowspan='2'>Tanggal</th>
				<th class='th01' width='200' rowspan='2'>Kd SKPD / Nama SKPD</th>-->
				<th class='th01' width='100' rowspan='2'>Kode Barang /<br> ID Barang /<br> ID Awal</th>
				<th class='th02' width='300' colspan='3'>Spesifikasi - Barang</th>
				<th class='th01' width='100' rowspan='2'>Cara Perolehan / Penggunaan</th>
				<th class='th01' width='100' rowspan='2'>Tahun Perolehan / No Register</th>
				<th class='th01' width='80' rowspan='2'>Harga Perolehan</th>
				<th class='th01' width='80' rowspan='2'>Akumulasi Penyusutan	</th>
				<th class='th02' colspan='2'>Berita Acara</th>
				<th class='th01' rowspan='2'>Kondisi Awal (B,KB,RB)</th>
				<th class='th01' rowspan='2'>Kondisi Akhir (B,KB,RB)</th>								
				<th class='th01' rowspan='2' width='100'>Ket </th>				
				</tr>
				<tr>
				<th class='th01' >Nama / Jenis Barang</th>
				<th class='th01' >Merk / Type</th>
				<th class='th01' >No. Sertifikat /<br> No. Pabrik /<br> No. Chasis /<br> No. Mesin /<br> No. Polisi</th>
				<th class='th01' >No</th>
				<th class='th01' >Tanggal</th>
				</tr>
				
			</thead>";
		return $headerTable;
	}
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref, $Main;
			$AsalUsul = $isi['asal_usul'];
			$SPg = $SPg_ ==''? $_GET['SPg'] : $SPg_; $cek .= "SPg = $SPg";
			//get opd
			$get = mysql_fetch_array(mysql_query(
				"select * from ref_skpd where c='".$isi['c']."'  and d='".$isi['d']."' and e='00'"
			));
			$ISI5 = "";	$ISI6 = "";
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
						f1 = '{$isi['f1']}' and 
						f2 = '{$isi['f2']}' and 
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
			
							if($SPg == 'belumsensus'){
								$alm = '';
								$alm .= ifempty($isiKIB_A['alamat'],'-');		
								$alm .= $isiKIB_A['alamat_kel'] != ''? '<br>Kel. '.$isiKIB_A['alamat_kel'] : '';
								$alm .= $isiKIB_A['alamat_kec'] != ''? '<br>Kec. '.$isiKIB_A['alamat_kec'] : '';
								$alm .= $isiKIB_A['alamat_kota'] != ''? '<br>'.$isiKIB_A['alamat_kota'] : '';
								$ISI5 = $alm;
							}else{
								$ISI5 = '';
							}
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
							if($SPg == 'belumsensus'){
								$alm = '';
								$alm .= ifempty($isiKIB_C['alamat'],'-');		
								$alm .= $isiKIB_C['alamat_kel'] != ''? '<br>Kel. '.$isiKIB_C['alamat_kel'] : '';
								$alm .= $isiKIB_C['alamat_kec'] != ''? '<br>Kec. '.$isiKIB_C['alamat_kec'] : '';
								$alm .= $isiKIB_C['alamat_kota'] != ''? '<br>'.$isiKIB_C['alamat_kota'] : '';
								$ISI5 = $alm;
							}else{
								$ISI5 = '';
							}
							$ISI6 = "{$isiKIB_C['dokumen_no']}";
							$ISI10 = $Main->Bangunan[$isiKIB_C['kondisi_bangunan'] - 1][1];
							$ISI15 = "{$isiKIB_C['ket']}";
						}
					}
					if ($isi['f'] == "04") {//KIB D;
						$QryKIB_D = mysql_query("select * from kib_d  $KondisiKIB limit 0,1");
						while ($isiKIB_D = mysql_fetch_array($QryKIB_D)) {
							$isiKIB_D = array_map('utf8_encode', $isiKIB_D);
							if($SPg == 'belumsensus'){
								$alm = '';
								$alm .= ifempty($isiKIB_D['alamat'],'-');		
								$alm .= $isiKIB_D['alamat_kel'] != ''? '<br>Kel. '.$isiKIB_D['alamat_kel'] : '';
								$alm .= $isiKIB_D['alamat_kec'] != ''? '<br>Kec. '.$isiKIB_D['alamat_kec'] : '';
								$alm .= $isiKIB_D['alamat_kota'] != ''? '<br>'.$isiKIB_D['alamat_kota'] : '';
								$ISI5 = $alm;
							}else{
								$ISI5 = '';
							}
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
							if($SPg == 'belumsensus'){
								$alm = '';
								$alm .= ifempty($isiKIB_F['alamat'],'-');		
								$alm .= $isiKIB_F['alamat_kel'] != ''? '<br>Kel. '.$isiKIB_F['alamat_kel'] : '';
								$alm .= $isiKIB_F['alamat_kec'] != ''? '<br>Kec. '.$isiKIB_F['alamat_kec'] : '';
								$alm .= $isiKIB_F['alamat_kota'] != ''? '<br>'.$isiKIB_F['alamat_kota'] : '';
								$ISI5 = $alm;
							}else{
								$ISI5 = '';
							}
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
					$kode_barang = $Main->KD_BARANG_P108?$isi['f1'].'.'.$isi['f2'].'.'.$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j']:$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'];
		
		$Koloms = array();
		$Koloms[] = array('align=right', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		//$Koloms[] = array('', TglInd($isi['tgl']));
		//$Koloms[] = array('', $isi['c'].'.'.$isi['d'].'.'.$isi['e'].'.'.$isi['e1'].'<br>'.$get['nm_skpd']);
		$Koloms[] = array('', $kode_barang.'<br>'.$isi['idbi'].'<br>'.$isi['idbi_awal']);		
		$Koloms[] = array('', $isi['nm_barang']);
		$Koloms[] = array('', utf8_encode($ISI5));
		$Koloms[] = array('', utf8_encode($ISI6));
		$Koloms[] = array('', $Main->AsalUsul[$AsalUsul-1][1].'<br>'.$isi['penggunaan']);
		$Koloms[] = array('', $isi['thn_perolehan'].'/<br>'.$isi['noreg']);		
 		$Koloms[] = array('align=right', number_format($isi['jml_harga'], 2, ',', '.'));
 		$Koloms[] = array('align=right', number_format($isi['nilai_susut'], 2, ',', '.'));
		$Koloms[] = array('align=left', $isi['no_bast']);					
		$Koloms[] = array('align=left', TglInd($isi['tgl_bast']));		
		$Koloms[] = array('', $Main->KondisiBarang[$isi['kond_awal']-1][1] );
		$Koloms[] = array('', $Main->KondisiBarang[$isi['kond_akhir']-1][1] );				
		$Koloms[] = array('', $isi['ket']."<br>".TglInd($isi['tgl']).'&nbsp;/<br>&nbsp;'.TglInd($isi['tgl_perolehan']));			
		return $Koloms;
	}
	
	function setPage_HeaderOther(){
	global $Main;	
		
		//style = terpilih
		$Pg= $_REQUEST['Pg'];
		$SSPg = $_REQUEST['SSPg'];
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
		$menu_penyusutan = $Main->PENYUSUTAN ? " <A href=\"index.php?Pg=05&jns=penyusutan\" $styleMenuPenyusutan title='Penyusutan'>PENYUSUTAN</a> |   ":'';
		
		$menu_rekapneraca_2 = $Main->REKAP_NERACA_2 ?
			" | <A href=\"pages.php?Pg=Rekap2\" title='Rekap Neraca'  >REKAP NERACA</a>": '';
		
		$menu_kibg1 = $Main->MODUL_ASET_LAINNYA?
							"<A href=\"?Pg=$Pg&SPg=kibg&jns=atb\" $styleMenu3_9 title='Aset Tak Berwujud'>ASET TAK BERWUJUD</a> |":'';
						
		switch($SSPg){
			//case '03' : $menustyle04 = "style='color:blue'"; break;
			case '04' : $menustyle1 = "style='color:blue'"; break;
			case '05' : $menustyle2 = "style='color:blue'"; break;
			case '06' : $menustyle3 = "style='color:blue'"; break;
			case '07' : $menustyle4 = "style='color:blue'"; break;
			case '08' : $menustyle5 = "style='color:blue'"; break;		
			case '09' : $menustyle6 = "style='color:blue'"; break;		
			case '10' : $menustyle7 = "style='color:blue'"; break;		
			//default: $menustyle1a = $SPg == '01' ?  "style='color:blue'" : ''; break;
			default: $menustyle1a = "style='color:blue'" ; break;
		}
		
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
	<!--<A href=\"pages.php?Pg=Rekap5\" title='Rekap BI' >REKAP BI 2</a>-->
	$menu_rekapneraca_2
	| <A href=\"pages.php?Pg=Rekap3\" title='Rekap Mutasi'  >REKAP MUTASI</a>
	| <A href=\"pages.php?Pg=Jurnal\" title='Jurnal' $styleMenu>JURNAL</a> 
	  &nbsp&nbsp&nbsp
	</td></tr>
	<tr>
	<td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	
	<A href=\"pages.php?Pg=Jurnal\" title='Jurnal'  >JURNAL</a> |
	<A href=\"pages.php?Pg=AsetLainLain\" title='Reklas Aset Lain-lain'  >ASET LAIN-LAIN</a> |
	<A href=\"pages.php?Pg=Kapitalisasi\" title='Kapitalisasi' $styleMenu >KAPITALISASI</a> |
	<A href=\"pages.php?Pg=Kondisi\" title='Kondisi'  >KONDISI</a>
	
	&nbsp&nbsp&nbsp
	</td>
	</tr>":'';
		
		
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
		if($Main->MODUL_PEMBUKUAN) $menubar=$menubar."<A href=\"index.php?Pg=05&SPg=03&jns=intra\" title='Akuntansi' $styleMenu>AKUNTANSI</a>";
		
		//$menubar .= ;	
		
		if($Main->MENU_VERSI==3){
			/***
			$menubar = "<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
					<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
					<A href=\"index.php?Pg=05&SPg=03&jns=intra\"  title='Intrakomptabel'>INTRAKOMPTABEL</a> |
					<A href=\"index.php?Pg=05&SPg=03&jns=ekstra\"  title='Ekstrakomptabel'>EKSTRAKOMPTABEL</a> |
					<A href=\"index.php?Pg=05&SPg=04&jns=tetap\"  title='Aset Tetap Tanah'>ASET TETAP</a>  |    
					<A href=\"index.php?Pg=05&SPg=03&jns=pindah\"  title='Aset Lainnya'>ASET LAINNYA</a> |    
					<A href=\"index.php?Pg=09&SPg=01&SSPg=03&mutasi=1\" style='color:blue' title='Mutasi'>MUTASI</a>  |
					<A href=\"pages.php?Pg=Rekap3\" title='Rekap Mutasi' >REKAP MUTASI</a>
					| <A href=\"pages.php?Pg=Rekap2\" title='Rekap Neraca'  >KERTAS KERJA</a>
					| <A href=\"pages.php?Pg=Rekap1\" title='Rekap BI'  >NERACA</a>
					  &nbsp&nbsp&nbsp
					</td></tr>".
					"<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
					<A href=\"index.php?Pg=09&SPg=01&SSPg=03&mutasi=1\" $mutstyle1 title='Daftar Mutasi'>PINDAH SKPD</a>  |
					<A href=\"index.php?Pg=09&SPg=01&SSPg=03&mutasi=2\" $mutstyle2 title='Daftar Reklas Kib'>REKLAS KIB</a> |
					<A href=\"pages.php?Pg=AsetLainLain\" title='Daftar Reklas Aset'>REKLAS ASET</a> |
					<A href=\"pages.php?Pg=Kapitalisasi\"  title='Daftar Kapitalisasi'>KAPITALISASI</a> |
					<A href=\"pages.php?Pg=Koreksi\" title='Daftar Koreksi'>KOREKSI</a> |
					<A href=\"pages.php?Pg=Kondisi\" $styleMenu title='Daftar Kondisi'>KONDISI</a> 
					 | <A href=\"index.php?Pg=09&SPg=01&SSPg=03&mutasi=4\" $mutstyle4 title='Daftar Penggabungan'>PENGGABUNGAN</a> 
					 | <A href=\"index.php?Pg=09&SPg=01&SSPg=03&mutasi=5\" $mutstyle5 title='Daftar Double Catat'>DOUBLE CATAT</a> 
					 | <A href=\"pages.php?Pg=Jurnal\" title='Jurnal' >HISTORI</a> 
					
					&nbsp&nbsp&nbsp	
					</td>
					<!--</tr>
				<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>	
				<A href=\"?Pg=$Pg&SSPg=03$mut\" $menustyle1a title='Buku Inventaris'>BI</a> |
				<A href=\"?Pg=$Pg&SSPg=04$mut\" $menustyle1 title='Tanah'>KIB A</a>  |  
				<A href=\"?Pg=$Pg&SSPg=05$mut\" $menustyle2 title='Peralatan & Mesin'>KIB B</a>  |  
				<A href=\"?Pg=$Pg&SSPg=06$mut\" $menustyle3 title='Gedung & Bangunan'>KIB C</a>  |  
				<A href=\"?Pg=$Pg&SSPg=07$mut\" $menustyle4 title='Jalan, Irigasi & Jaringan'>KIB D</a>  |  
				<A href=\"?Pg=$Pg&SSPg=08$mut\" $menustyle5 title='Aset Tetap Lainnya'>KIB E</a>  |  
				<A href=\"?Pg=$Pg&SSPg=09$mut\" $menustyle6 title='Konstruksi Dalam Pengerjaan'>KIB F</a>
				 | <A href=\"?Pg=$Pg&SSPg=10$mut\" $menustyle7 title='Aset Tak Berwujud'>ATB</a>
				  &nbsp&nbsp&nbsp
					</td></tr>-->
			</table>";	
			***/
			$menubar='';
				
		}else{
			$menubar=$menubar."&nbsp&nbsp&nbsp
			</td></tr>
			$menu_pembukuan1			
			</table>".			
			""
			;			
		}	
		
		/*$menubar .= 
			"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
			
			<td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
			
			<A href=\"pages.php?Pg=Jurnal\" title='Jurnal' $styleMenu >JURNAL</a> |
			<A href=\"pages.php?Pg=AsetLainLain\" title='Reklas Aset Lain-lain'  >ASET LAIN-LAIN</a> |
			<A href=\"pages.php?Pg=Kapitalisasi\" title='Kapitalisasi'  >KAPITALISASI</a> | 
			<A href=\"pages.php?Pg=Koreksi\" title='Koreksi Pembukuan'  >KOREKSI</a>
			
			&nbsp&nbsp&nbsp
			</td>
			</tr>	</table>";
		*/
		return $menubar;
			
	}
	
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
			"<script type='text/javascript' src='js/kondisi/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			$scriptload;
	}
	
	
	function genDaftarOpsi(){
		global $Ref, $Main,$HTTP_COOKIE_VARS;
		$thn_login = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$fmPILGEDUNG = $_REQUEST['fmPILGEDUNG'];
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];	
		$fmIdbi = $_REQUEST['idbi'];
		$fmIdbiAwal = $_REQUEST['idbi_awal'];
		$fmKdBarang = $_REQUEST['kd_barang'];
		$fmThnPerolehan = $_REQUEST['thn_perolehan']==''?$thn_login:$_REQUEST['thn_perolehan'];
		$fmNoreg = $_REQUEST['noreg'];
		$TampilOpt =
			"<table width=\"100%\" class=\"adminform\">	
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
			</table>".
			"<div class='FilterBar'>
				<table style='width:100%'>
					<tbody>
						<tr>
							<td align='left'>
								<table cellspacing='0' cellpadding='0' border='0' style='height:28'>
									<tr valign='middle'>
										<td align='left' style='padding:1 8 0 8; '>".
											$vtgl =
											"<div style='float:left;padding: 2 8 0 0;height:20;padding: 4 4 0 0'> Tanggal :</div>".
											createEntryTglBeetwen('fmFiltTglBtw',$fmFiltTglBtw_tgl1, $fmFiltTglBtw_tgl2,'','','adminForm',1)."
										</td>
									</tr>
									<tr>
										<td align='left' style='padding:1 8 0 8; '>
											ID Barang : <input type='text' name='idbi' id='idbi' value='".$fmIdbi."'> &nbsp;&nbsp;&nbsp;
											ID Awal : <input type='text' name='idbi_awal' id='idbi_awal' value='".$fmIdbiAwal."'> &nbsp;&nbsp;&nbsp;
											KD Barang : <input type='text' name='kd_barang' id='kd_barang' value='".$fmKdBarang."'> &nbsp;&nbsp;&nbsp;
											Tahun : <input type='text' name='thn_perolehan' id='thn_perolehan' value='".$fmThnPerolehan."' size='4' readonly> &nbsp;&nbsp;&nbsp;
											Noreg : <input type='text' name='noreg' id='noreg' value='".$fmNoreg."'> &nbsp;&nbsp;&nbsp;
											<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
		    </div>";
			/*genFilterBar(
				''
				,$this->Prefix.".refreshList(true)",TRUE, 'Tampilkan'
			);*/
		return array('TampilOpt'=>$TampilOpt);
	}			
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$thn_login = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();	
		$arrKondisi[] = " kond_awal != '0'";
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
		$kd_brg = str_replace('.','',$_POST['kd_barang']);			
		$fmURUSAN = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST($this->Prefix.'SkpdfmURUSAN');
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST($this->Prefix.'SkpdfmSKPD');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST($this->Prefix.'SkpdfmSUBUNIT');		
		$fmSEKSI = isset($HTTP_COOKIE_VARS['cofmSEKSI'])? $HTTP_COOKIE_VARS['cofmSEKSI']: cekPOST($this->Prefix.'SkpdfmSEKSI');		
		/*$arrKondisi[] = getKondisiSKPD2(
			12, 
			$Main->Provinsi[0], 
			'00', 
			$fmSKPD, 
			$fmUNIT, 
			$fmSUBUNIT,
			$fmSEKSI
		);*/
		$concatkd = $Main->KD_BARANG_P108?"f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j":"f,'.',g,'.',h,'.',i,'.',j";
		
		if(!($fmURUSAN=='' || $fmURUSAN=='0') && ($Main->URUSAN==1) ) $arrKondisi[] = " c1 = '$fmURUSAN'";
		if(!($fmSKPD=='' || $fmSKPD=='00') ) $arrKondisi[] = "c='$fmSKPD'";
		if(!($fmUNIT=='' || $fmUNIT=='00') ) $arrKondisi[] = "d='$fmUNIT'";
		if(!($fmSUBUNIT=='' || $fmSUBUNIT=='00') ) $arrKondisi[] = "e='$fmSUBUNIT'";
		if(!($fmSEKSI=='' || $fmSEKSI=='00') ) $arrKondisi[] = "e1='$fmSEKSI'";
		if(!empty($fmFiltTglBtw_tgl1)) $arrKondisi[] = " tgl>='$fmFiltTglBtw_tgl1'";
		if(!empty($fmFiltTglBtw_tgl2)) $arrKondisi[] = " tgl<='$fmFiltTglBtw_tgl2'"; 	
		if(!empty($_POST['idbi'])) $arrKondisi[] = " idbi = '".$_POST['idbi']."'";
		if(!empty($_POST['idbi_awal'])) $arrKondisi[] = " idbi_awal = '".$_POST['idbi_awal']."'";
		if(!empty($kd_brg)) $arrKondisi[] = " concat($concatkd) like '".$kd_brg."%'";
		//if(!empty($_POST['thn_perolehan'])) 
		$arrKondisi[] = !empty($_POST['thn_perolehan'])?" year(tgl) = '".$_POST['thn_perolehan']."'" : " year(tgl) = '$thn_login'";
		if(!empty($_POST['noreg'])) $arrKondisi[] = " noreg = '".$_POST['noreg']."'";
		//$fmPILGEDUNG = $_REQUEST['fmPILGEDUNG'];
		//if (!empty($fmPILGEDUNG)) $arrKondisi[] = "p='$fmPILGEDUNG'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');				
		$Asc = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		//$arrOrders[] = " a,b,c,d,e,nip ";
		/*switch($fmORDER1){
			case '1': $arrOrders[] = " no_terima $Asc " ;break;
			case '2': $arrOrders[] = " i $Asc " ;break;
		}*/		
		//$arrOrders[] = " c,d,e,e1,f,g,h,i,j,thn_perolehan,noreg,tgl ";
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
	
}
$Kondisi = new KondisiObj();

?>