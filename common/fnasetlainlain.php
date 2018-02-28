<?php

class AsetLainLainObj  extends DaftarObj2{	
	var $Prefix = 'AsetLainLain';
	var $elCurrPage="HalDefault";
	var $TblName = 'v1_asetlainlain'; //daftar
	var $TblName_Hapus = 't_asetlainlain';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');//('p','q'); //daftar/hapus
	var $FieldSum = array('nilai_buku','nilai_susut');//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 11, 12, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 11, 12, 13);	
	var $fieldSum_lokasi = array( 8,9);
	var $totalCol = 14; //total kolom daftar	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'Pelaporan';
	var $PageIcon = 'images/pelaporan_ico.png';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pegawai.xls';
	var $Cetak_Judul = 'DAFTAR ASET LAIN-LAIN';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;	
	
	//function setPage_TitleDaftar(){	return 'Daftar Pegawai'; }	
	//function setPage_TitlePage(){		return 'Referensi Data';			}
	function setTitle(){
		return 'Mutasi Reklas Aset';
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
		$Id = $_REQUEST['Id'];
		$idbi = $_REQUEST['idbi'];
		//$idbi_awal = $_REQUEST['idbi_awal'];
		$tgl_bast = $_REQUEST['tgl_bast'];
		$no_bast = $_REQUEST['no_bast'];
		$tgl = $_REQUEST['tgl'];
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
		if($err=='' && $tgl=='') $err = 'Tanggal belum diisi!';		
		if($err=='' && !cektanggal($tgl)){	$err = "Tanggal $tgl Salah!";	}					
		// - tanggal harus <= tgl hari ini
		if ($err =='' && compareTanggal($tgl, date('Y-m-d'))==2  ) $err = 'Tanggal tidak lebih besar dari Hari ini!';						
		// - tanggal > tgl closing
		if($err==''){ //cek tahun tgl <= thn closing
			$arrtgl = explode('-',$tgl);
			$thn =$arrtgl[0];
			//if ($thn<=$Main->TAHUN_CLOSING) $err = 'Data Tidak Dapat Disimpan!, Tahun '.$Main->TAHUN_CLOSING.' sudah closing'; 
		}				
		//tgl >=tgl_buku
		if(compareTanggal($bi['tgl_buku'],$tgl)==2) $err = 'Tanggal tidak kecil dari Tanggal Buku Barang !';				
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
					$get = mysql_fetch_array(mysql_query(
						"select max(tgl) as maxtgl from t_history_aset where idbi_awal ='$idbi_awal'  "
					));
					if( compareTanggal( $tgl, $get['maxtgl'] )==0  ) $err = "Tanggal tidak lebih kecil dari transaksi sebelumnya!";
				}	
				if($err=='' && $tgl<=$tgl_closing)$err ='Tanggal sudah Closing !';				
				if($err=='' && $tgl<=$tgl_susutAkhir['tgl'])$err ='Sudah ada penyusutan !';
				
				if($err==''){
					$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id='$idbi'"));
					
					$staset = $bi['staset'];
					if($staset == 9){
						//$staset_baru =  getStatusAset('', $kondisi_baru, $bi['harga'], $bi['f'], $bi['g'], $bi['h'], $bi['i'], $bi['j'] ) 	;
						$staset_baru= $bi['f']=='07' ? 8: 3;
					}else{
						$staset_baru = 9;
					}
					
					$aqry = "insert into t_asetlainlain (tgl,idbi,uid,tgl_update,staset,staset_baru,ket, kondisi,kondisi_baru,idbi_awal,nilai_buku,nilai_susut) ".
						" values('$tgl','$idbi','$uid',now(),'$staset','$staset_baru','$ket', '$kondisi','$kondisi_baru','".$bi['idawal']."','$nilai_buku','$nilai_susut') "; $cek .= $aqry;
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
							set tgl_bast='$tgl_bast', 
							no_bast='$no_bast', 
							tgl='$tgl', 
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
	
	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){
			case 'formBaruBI':{				
				$fm = $this->setFormBaruBI();				
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
		for($i = 0; $i<count($ids); $i++)	{
			//cek id terakhir
			$old=mysql_fetch_array(mysql_query("select * from t_asetlainlain where Id='".$ids[$i]."' "));
			//$aqry = "select Id from t_asetlainlain where idbi_awal='".$old['idbi_awal']."' order by tgl desc, Id desc limit 0,1";
			$aqry = "select * from t_history_aset where idbi_awal='".$old['idbi_awal']."' and jns=2 order by tgl desc, Id desc limit 0,1";
			$get = mysql_fetch_array(mysql_query($aqry));
			$cek .= $aqry;
			//if($err == '' && $get['refid'] != $old['Id'] && $get['jns']==2) $err = "Hanya status aset terakhir yang bisa dihapus!";
			//if($err == '' && $get['jns']!=2) $err = "Hanya status aset terakhir yang bisa dihapus !";
			if($err == '' && $get['refid'] != $old['Id']) $err = "Hanya status aset terakhir yang bisa dihapus!";
			$aqry = "select count(*) as cnt from t_history_aset where idbi_awal='".$old['idbi_awal']."' ";
			$get = mysql_fetch_array(mysql_query($aqry));
			if($err == '' && $get['cnt']==1) $err = "Status perolehan tidak boleh dihapus!";
			 
			if($err == ''){
				$aqry2 = "delete from t_asetlainlain where Id='".$old['Id']."' "; $cek = $aqry2;
				$qry = mysql_query($aqry2);
				if($qry){
					$aqry = "update buku_induk set staset = '".$old['staset']."' where id='".$old['idbi']."' "; $cek .= $aqry;
					mysql_query($aqry);
					$aqry = "delete from t_history_aset where jns=2 and refid='".$ids[$i]."' ";
					mysql_query($aqry);
				}
			}
			
			
			
					
		}
		return array('err'=>$err,'cek'=>$cek);
	}
	
	//form ==================================
	function setFormBaruBI(){
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
		$dt['staset'] =  $bi['staset'];
		$dt['tgl'] =  Date('Y-m-d');
		$dt['kondisi'] = $bi['kondisi'];
		$dt['kondisi_baru'] = $bi['kondisi'];
			
		if($err=='' && ($bi['staset']==5 || $bi['staset']==6 || $bi['staset']==7)) $err = 'Barang '.$Main->StatusAsetView[$bi['staset']-1][1].' ini tidak bisa di reclass ke Aset Lain-lain!';
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
		$aqry = "select * from t_asetlainlain where id ='".$this->form_idplh."'  "; 
		$get = mysql_fetch_array(mysql_query($aqry));
		
		
		$cek.=$aqry;
		$fm = $this->setForm($get);
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
		$this->form_height = $Main->STASET_OTOMATIS? 170: 150;
		$idbi = $dt['idbi'];
		$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id = '$idbi' "));
		
		if($err=='' && !( $bi['staset']==9 || $bi['staset']==3 || $bi['staset']==8) ){
			$err = $Main->StatusAsetView[$bi['staset']-1][1]." tidak bisa reklas ke Aset Lain-Lain! ";
		}
		
		if($err==''){
			if ($this->form_fmST==0) {		
				$tgl = $tgl_buku;
			}else{
				$tgl = $dt['tgl'];
				$tgl_bast = $dt['tgl_bast'];
			}	
			
			$stasetAwal = $Main->StatusAsetView[$dt['staset']-1][1] ."<input type='hidden' id='staset' name='staset' value='".$dt['staset']."'>" ;
			
			$vtgl = createEntryTgl(	'tgl', $tgl, 	false, 	'', 	'','adminForm','2');
			//$selKondisi = cmb2D_v2( 'staset_baru',$dt['staset_baru'],$Main->StatusAset );
			
			
					
			$vkondisi = $Main->KondisiBarang[$dt['kondisi']-1][1];	
			$stkondisi = "<input type='hidden' id='kondisi' name='kondisi' value ='".$bi['kondisi']."' >";
			$stkondisi_baru = "<input type='hidden' id='kondisi_baru' name='kondisi_baru' value ='".$bi['kondisi']."' >";
			
			if($dt['staset'] == 9){
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
					
					$this->form_fields = array(							
						'tgl_bast' => array(  'label'=>'Tanggal Berita Acara', 'value'=> createEntryTgl('tgl_bast', $tgl_bast, 	false, 	'', 	'','adminForm','0'),  'type'=>'' ),
						'no_bast' => array(  'label'=>'No Berita Acara', 'value'=> "<input type='text' name='no_bast' id='no_bast' value='".$dt['no_bast']."'"),
						'tgl' => array(  'label'=>'Tanggal', 'value'=> $vtgl,  'type'=>'' ),
						'staset' => array(  'label'=>'Dari', 'value'=> $stasetAwal, 'labelWidth'=>150, 'type'=>'' ),
						'staset_baru' => array(  'label'=>'Ke', 'value'=> $selSTASET.$stkondisi.$stkondisi_baru, 'type'=>'' ),
						'ket'=> array(  'label'=>'Keterangan', 'value'=> "<textarea id='ket' name='ket' style='width: 234px;height: 35px;'>".$dt['ket']."</textarea>", 'type'=>'' )
					);
				//}
				
				
				
			}else{
				$caption = 'Reclass ke Aset Lain-lain' ;
				$selSTASET = $Main->StatusAsetView[9-1][1]	;
				
				$dt['kondisi_baru'] = $bi['kondisi'];
				if($Main->STASET_OTOMATIS){				
					$vkondisi_baru= cmb2D_v2( 'kondisi_baru',$dt['kondisi_baru'],$Main->KondisiBarang );
					$this->form_fields = array(							
						'tgl_bast' => array(  'label'=>'Tanggal Berita Acara', 'value'=> createEntryTgl('tgl_bast', $tgl_bast, 	false, 	'', 	'','adminForm','0'),  'type'=>'' ),
						'no_bast' => array(  'label'=>'No Berita Acara', 'value'=> "<input type='text' name='no_bast' id='no_bast' value='".$dt['no_bast']."'"),
						'tgl' => array(  'label'=>'Tanggal', 'value'=> $vtgl,  'type'=>'' ),
						'staset' => array(  'label'=>'Dari', 'value'=> $stasetAwal, 'labelWidth'=>150, 'type'=>'' ),
						'staset_baru' => array(  'label'=>'Ke', 'value'=> $selSTASET, 'type'=>'' ),
						//'kondisi' => array(  'label'=>'Kondisi Awal', 'value'=> $vkondisi.$stkondisi, 'labelWidth'=>90, 'type'=>'' ),
						//'kondisi_baru' => array(  'label'=>'Kondisi Akhir', 'value'=> $vkondisi_baru, 'type'=>'' ),
						'ket'=> array(  'label'=>'Keterangan', 'value'=> "<textarea id='ket' name='ket' style='width: 234px;height: 35px;'>".$dt['ket']."</textarea>", 'type'=>'' )
					);
				}else{
					//$vkondisi_baru = $Main->KondisiBarang[$dt['kondisi_baru']-1][1];
					
					$this->form_fields = array(							
						'tgl_bast' => array(  'label'=>'Tanggal Berita Acara', 'value'=> createEntryTgl('tgl_bast', $tgl, 	false, 	'', 	'','adminForm','0'),  'type'=>'' ),
						'tgl' => array(  'label'=>'Tanggal', 'value'=> $vtgl,  'type'=>'' ),
						'staset' => array(  'label'=>'Dari', 'value'=> $stasetAwal, 'labelWidth'=>90, 'type'=>'' ),
						'staset_baru' => array(  'label'=>'Ke', 'value'=> $selSTASET.$stkondisi.$stkondisi_baru, 'type'=>'' ),
						'ket'=> array(  'label'=>'Keterangan', 'value'=> "<textarea id='ket' name='ket' style='width: 234px;height: 35px;'>".$dt['ket']."</textarea>", 'type'=>'' )
					);
				}
			}
			
			if ($this->form_fmST==0) {		
				$this->form_caption = $caption;
			}else{
				$this->form_caption = $caption.' - Edit';
			}	
			
							
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
				
				<th class='th01' width='40' rowspan='2'>No.</th>
				$Checkbox		
				<th class='th01' rowspan='2'>Kode Barang/<br>Id Barang/<br>Id Awal</th>
   	   			<th class='th01' rowspan='2'>No.Reg/<br>Thn</th>
   	   			<th class='th02' colspan='3'>Spesifikasi Barang</th>
				<!--<th class='th01' rowspan='2'width='80'>Tanggal Buku/<br>Tanggal Perolehan</th>
				<th class='th01' rowspan='2' width='80'>Tanggal</th>-->							
				<th class='th01' rowspan='2'>Harga Perolehan</th>								
				<th class='th01' rowspan='2'>Akumulasi Penyusutan</th>
				<th class='th02' colspan='2'>Berita Acara</th>
				<th class='th01' rowspan='2'>Status Aset Lama </th>
				<th class='th01' rowspan='2'>Status Aset Baru </th>									
				<th class='th01' rowspan='2'>Ket </th>		
				</tr>
				<tr>				
				<th class='th01' >Nama Barang/<br>Penggunaan</th>
				<th class='th01' >Merk/Tipe/Alamat</th>
				<th class='th01' >No. Sertifikat/<br> No. Pabrik/<br> No. Chasis/<br> No. Mesin/<br> No.Polisi</th>
				<th class='th01' >No</th>
				<th class='th01' >Tanggal</th>
				</tr>
				
			</thead>";
		return $headerTable;
	}
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref, $Main;
		$KondF = $Main->KD_BARANG_P108?"f1 = '{$isi['f1']}' and f2 = '{$isi['f2']}' and f = '{$isi['f']}' and g = '{$isi['g']}' and h = '{$isi['h']}' and i = '{$isi['i']}' and j = '{$isi['j']}'":"f = '{$isi['f']}' and g = '{$isi['g']}' and h = '{$isi['h']}' and i = '{$isi['i']}' and j = '{$isi['j']}'";
		
		$KondisiKIB = "	where a1= '{$isi['a1']}' and a = '{$isi['a']}' and 	c = '{$isi['c']}' and d = '{$isi['d']}' and e = '{$isi['e']}' and e1 = '{$isi['e1']}' and 
					$KondF and 
					tahun = '{$isi['thn_perolehan']}' and noreg = '{$isi['noreg']}'  ";
		switch($isi['f']){
			case '01':{//KIB A			
				
				$sqryKIBA = "select sertifikat_no, luas, ket from kib_a  $KondisiKIB limit 0,1";
				//$sqryKIBA = "select * from view_kib_a  $KondisiKIB limit 0,1";
				//echo '<br> qrykibA = '.$sqryKIBA;
				$QryKIB_A = mysql_query($sqryKIBA);
				while($isiKIB_A = mysql_fetch_array($QryKIB_A))	{
					$isiKIB_A = array_map('utf8_encode', $isiKIB_A);	
					//$ISI5 = $isiKIB_A['alamat'].'<br>'.$isiKIB_A['alamat_kel'].'<br>'.$isiKIB_A['alamat_kec'].'<br>'.$isiKIB_A['alamat_kota'] ;
					$ISI6 = $isiKIB_A['sertifikat_no'];
					/*$ISI6 = $isiKIB_A['sertifikat_no'].'/<br>'.
					TglInd($isiKIB_A['sertifikat_tgl']).'/<br>'.
					$Main->StatusHakPakai[ $isiKIB_A['status_hak']-1 ][1];
					*/
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
					$isiKIB_B = array_map('utf8_encode', $isiKIB_B);
					$ISI5 = "{$isiKIB_B['merk']}";
					$ISI6 = "{$isiKIB_B['no_pabrik']} / {$isiKIB_B['no_rangka']} / {$isiKIB_B['no_mesin']}";
					$ISI7 = "{$isiKIB_B['bahan']}";
					$ISI10 = "{$isiKIB_B['ukuran']}";
					$ISI15 = "{$isiKIB_B['ket']}";
				}
				break;
				}	
			case '03':{//KIB C;
				$QryKIB_C = mysql_query("select dokumen_no, kondisi_bangunan, ket,kota, alamat_kec, alamat_kel, alamat,alamat_b,alamat_c from kib_c  $KondisiKIB limit 0,1");
				//$QryKIB_C = mysql_query("select dokumen_no, kondisi_bangunan, ket, alamat_kota, alamat_kec, alamat_kel, alamat from view_kib_c  $KondisiKIB limit 0,1");
				while($isiKIB_C = mysql_fetch_array($QryKIB_C))	{
					$isiKIB_C = array_map('utf8_encode', $isiKIB_C);
					//$ISI5 = $isiKIB_C['alamat'].'<br>'.$isiKIB_C['alamat_kel'].'<br>'.$isiKIB_C['alamat_kec'].'<br>'.$isiKIB_C['alamat_kota'] ;
					$ISI5= getalamat($isiKIB_C['alamat_b'],$isiKIB_C['alamat_c'],$isiKIB_C['alamat'],$isiKIB_C['kota'] ,$isiKIB_C['alamat_kec'],$isiKIB_C['alamat_kel']);
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
					$isiKIB_D = array_map('utf8_encode', $isiKIB_D);
					//$ISI5 = $isiKIB_D['alamat'].'<br>'.$isiKIB_D['alamat_kel'].'<br>'.$isiKIB_D['alamat_kec'].'<br>'.$isiKIB_D['alamat_kota'] ;
					$ISI6 = "{$isiKIB_D['dokumen_no']}";
					$ISI15 = "{$isiKIB_D['ket']}";
				}
				break;
			}
			case '05':{//KIB E;		
				$QryKIB_E = mysql_query("select seni_bahan, ket from kib_e  $KondisiKIB limit 0,1");
				while($isiKIB_E = mysql_fetch_array($QryKIB_E))	{
					$isiKIB_E = array_map('utf8_encode', $isiKIB_E);
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
					$isiKIB_F = array_map('utf8_encode', $isiKIB_F);
					//$ISI5 = $isiKIB_F['alamat'].'<br>'.$isiKIB_F['alamat_kel'].'<br>'.$isiKIB_F['alamat_kec'].'<br>'.$isiKIB_F['alamat_kota'] ;
					$ISI6 = "{$isiKIB_F['dokumen_no']}";
					$ISI10 = $Main->Bangunan[$isiKIB_F['bangunan']-1][1];
					$ISI15 = "{$isiKIB_F['ket']}";
				}
				break;
			}
		}
		
		$ISI5 	= !empty($ISI5)?$ISI5:"-"; 
		$ISI6 	= !empty($ISI6)?$ISI6:"-";
		
		$kdBarang = $Main->KD_BARANG_P108?$isi['f1'].'.'.$isi['f2'].'.'.$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j']:$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'];
		$kdbrg = $Main->KD_BARANG_P108?$isi['f1'].$isi['f2'].$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j']:$isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'];
		$concatkd = $Main->KD_BARANG_P108?"f1,f2,f,g,h,i,j":"f,g,h,i,j";
		$nmBarang = mysql_fetch_array(mysql_query("select * from ref_barang where concat($concatkd)='$kdbrg'"));		
		$bi = mysql_fetch_array(mysql_query("SELECT * FROM view_buku_induk2 WHERE id='".$isi['id_bukuinduk']."'"));
		$penggunaan = $bi['penggunaan'];	
		
		$Koloms = array();
		$Koloms[] = array('align=right', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array('align="left" "',$kdBarang.'/<BR>'.$isi['idbi'].'/<BR>'.$isi['idbi_awal']."");
 		$Koloms[] = array('align="left" "',$isi['noreg'].'/<BR>'.$isi['thn_perolehan']);
		$Koloms[] = array('align="left" "',$nmBarang['nm_barang'].'/<br>'.$penggunaan);
		$Koloms[] = array('align="left" "',$ISI5);
		$Koloms[] = array('align="left" "',$ISI6); 
		//$Koloms[] = array('', TglInd($isi['tgl']).'&nbsp;/<br>&nbsp;'.TglInd($isi['tgl_perolehan']));				
		$Koloms[] = array('align=right', number_format($isi['nilai_buku'],2,',','.'));				
		$Koloms[] = array('align=right', number_format($isi['nilai_susut'],2,',','.'));		
		$Koloms[] = array('align=left', $isi['no_bast']);				
		$Koloms[] = array('align=left', TglInd($isi['tgl_bast']));			
		$Koloms[] = array('', $Main->StatusAsetView[$isi['staset']-1][1] );
		$Koloms[] = array('', $Main->StatusAsetView[$isi['staset_baru']-1][1] );//$isi['staset_baru']);			
		$Koloms[] = array('', $isi['ket']."<br>".TglInd($isi['tgl']).'&nbsp;/<br>&nbsp;'.TglInd($isi['tgl_perolehan']));				
		return $Koloms;
	}
	
	function setPage_HeaderOther(){
	global $Main, $Menu;	
		
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
		$menu_penyusutan = $Main->PENYUSUTAN ? " <A href=\"index.php?Pg=05&jns=penyusutan\" $styleMenuPenyusutan title='Penyusutan'>PENYUSUTAN</a> |   ":'';
		
		$menu_rekapneraca_2 = $Main->REKAP_NERACA_2 ?
			" | <A href=\"pages.php?Pg=Rekap2\" title='Rekap Neraca'  >REKAP NERACA</a>": '';
		
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
			<!--<A href=\"pages.php?Pg=Rekap5\" title='Rekap BI' >REKAP BI 2</a>-->
			$menu_rekapneraca_2
			| <A href=\"pages.php?Pg=Rekap3\" title='Rekap Mutasi'  >REKAP MUTASI</a>
			| <A href=\"pages.php?Pg=Jurnal\" title='Jurnal' $styleMenu>JURNAL</a> 
			  &nbsp&nbsp&nbsp
			</td></tr>
			<tr>
			<td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
			
			<A href=\"pages.php?Pg=Jurnal\" title='Jurnal'  >JURNAL</a> |
			<A href=\"pages.php?Pg=AsetLainLain\" title='Reklas Aset Lain-lain' $styleMenu >ASET LAIN-LAIN</a> |
			<A href=\"pages.php?Pg=Kapitalisasi\" title='Kapitalisasi'  >KAPITALISASI</a> |
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
			/**
			$menubar = "<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
					<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
					<A href=\"index.php?Pg=05&SPg=03&jns=intra\"  title='Intrakomptabel'>INTRAKOMPTABEL</a> |
					<A href=\"index.php?Pg=05&SPg=03&jns=ekstra\"  title='Ekstrakomptabel'>EKSTRAKOMPTABEL</a> |
					<A href=\"index.php?Pg=05&SPg=04&jns=tetap\"  title='Aset Tetap Tanah'>ASET TETAP</a>  |    
					<A href=\"index.php?Pg=05&SPg=03&jns=pindah\"  title='Aset Lainnya'>ASET LAINNYA</a> |    
					<A href=\"index.php?Pg=05&SPg=01&SSPg=03&mutasi=1\" style='color:blue' title='Mutasi'>MUTASI</a>  |
					<A href=\"pages.php?Pg=Rekap3\" title='Rekap Mutasi' >REKAP MUTASI</a>
					| <A href=\"pages.php?Pg=Rekap2\" title='Rekap Neraca'  >KERTAS KERJA</a>
					| <A href=\"pages.php?Pg=Rekap1\" title='Rekap BI'  >NERACA</a>
					  &nbsp&nbsp&nbsp
					</td></tr>".
					"<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
					<A href=\"index.php?Pg=09&SPg=01&SSPg=03&mutasi=1\" $mutstyle1 title='Daftar Mutasi'>PINDAH SKPD</a>  |
					<A href=\"index.php?Pg=09&SPg=01&SSPg=03&mutasi=2\" $mutstyle2 title='Daftar Reklas Kib'>REKLAS KIB</a> |
					<A href=\"pages.php?Pg=AsetLainLain\" $styleMenu title='Daftar Reklas Aset'>REKLAS ASET</a> |
					<A href=\"pages.php?Pg=Kapitalisasi\" title='Daftar Kapitalisasi'>KAPITALISASI</a> |
					<A href=\"pages.php?Pg=Koreksi\" title='Daftar Koreksi'>KOREKSI</a> |
					<A href=\"pages.php?Pg=Kondisi\" title='Daftar Kondisi'>KONDISI</a> 
					 | <A href=\"index.php?Pg=09&SPg=01&SSPg=03&mutasi=4\" $mutstyle4 title='Daftar Penggabungan'>PENGGABUNGAN</a> 
					 | <A href=\"index.php?Pg=09&SPg=01&SSPg=03&mutasi=5\" $mutstyle5 title='Daftar Double Catat'>DOUBLE CATAT</a> 
					 | <A href=\"pages.php?Pg=Jurnal\" title='Jurnal' >HISTORI</a> 
					
					&nbsp&nbsp&nbsp	
					</td></tr>
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
		</table>";	**/
		
			//$menubar = $Menu->genMenu();	
			$menubar='';
		}
		else{
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
		
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
		//$kd_brg = str_replace('.','',$_POST['kd_barang']);			
		$kd_brg = $_REQUEST['kd_barang'];			
		$fmURUSAN = isset($HTTP_COOKIE_VARS['cofmURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST($this->Prefix.'SkpdfmURUSAN');
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST($this->Prefix.'SkpdfmSKPD');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST($this->Prefix.'SkpdfmSUBUNIT');		
		$fmSEKSI = isset($HTTP_COOKIE_VARS['cofmSEKSI'])? $HTTP_COOKIE_VARS['cofmSEKSI']: cekPOST($this->Prefix.'SkpdfmSEKSI');		
		/*$arrKondisi[] = getKondisiSKPD2(
			$Main->DEF_KEPEMILIKAN, 
			$Main->Provinsi[0], 
			$Main->DEF_WILAYAH, 
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
		$arrOrders[] = " c1,c,d,e,e1,f,g,h,i,j,thn_perolehan,noreg,tgl ";
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
$AsetLainLain = new AsetLainLainObj();

?>