<?php

class pembuatanSPDObj  extends DaftarObj2{	
	var $Prefix = 'pembuatanSPD';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'nomor_spd'; //bonus
	var $TblName_Hapus = 'tabel_anggaran';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'SPD-SKPD';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pembuatanSPD.xls';
	var $namaModulCetak='RKA';
	var $Cetak_Judul = 'RKA';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'pembuatanSPDForm';
	var $modul = "SPD";
	var $jenisForm = "";
	var $tahun = "";
	var $nomorUrut = "";
	var $jenisAnggaran = "";
	var $idTahap = "";
	var $currentTahap = "";
	var $namaTahapTerakhir = "";
	var $masaTerakhir = "";
	//buatview
	var $urutTerakhir = "";
	var $urutSebelumnya = "";
	var $jenisFormTerakhir = "";
	
	var $wajibValidasi = "";
	
	var $sqlValidasi = "";
	
	//buatview
	var $TampilFilterColapse = 0; //0
	
	var $provinsi = "";
	var $kota = "";
	var $pengelolaBarang = "";
	var $pejabatPengelolaBarang = "";
	var $pengurusPengelolaBarang = "";
	var $nipPengelola = "";
	var $nipPejabat = "";
	var $nipPengurus ="";
	var $username = "";
	
	function setTitle(){
		return 'PEMBUATAN SPD '.$this->jenisAnggaran.' TAHUN '.$this->tahun;
	}
	function setMenuView(){
		return 			
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";				
			
	}
	function setMenuEdit(){
		return
			
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru ", 'Baru ')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
	}
	function genRowSum($ColStyle, $Mode, $Total){
		foreach ($_REQUEST as $key => $value) { 
		  	$$key = $value; 
		 } 
		 if($cmbSubUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
		if(!empty($hiddenP)){
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and p='$hiddenP'";
					if(!empty($q)){
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and p='$hiddenP' and q='$q'";
		}
		}						
		}elseif($cmbUnit != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
		}elseif($cmbSKPD != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
		}elseif($cmbBidang != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
		}elseif($cmbUrusan != ''){
			$kondisiSKPD = "and c1='$cmbUrusan'";
		}
	 	
		if ($this->jenisForm == "PENYUSUNAN" || $this->jenisForm == "KOREKSI" ){
			$idTahap = $this->idTahap;
		}else{
			$getIdTahapRKATerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from tabel_anggaran where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and jenis_rka !=''  and (rincian_perhitungan !='' or f ='00' ) "));
		 	$idTahap = $getIdTahapRKATerakhir['max'];
		}

		$getAllKegiatan = mysql_query("select * from tabel_anggaran where id_tahap='$idTahap' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' $kondisiSKPD ");
		while($got = mysql_fetch_array($getAllKegiatan)){
			$gotC1= $got['c1'];
			$gotC= $got['c'];
			$gotD= $got['d'];
			$gotE = $got['e'];
			$gotE1 = $got['e1'];
			$gotQ= $got['q'];
			$getIdAwalRenja = mysql_fetch_array(mysql_query("select min(id_anggaran) as idAwalRenja from view_renja where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and bk='$bk' and ck='$ck' and p='$p' and q='$gotQ' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  "));
			$idAwalRenja = $getIdAwalRenja['idAwalRenja'];
			$getDetailRenja = mysql_fetch_array(mysql_query("select * from detail_renja where id_anggaran ='$idAwalRenja'"));
			$sumTahunPlus = $sumTahunPlus + $getDetailRenja['plus'];
		}
		$tahunPlus = number_format($sumTahunPlus ,2,',','.');
		$getData = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f ='00' ) and id_tahap='$idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka = '2.2.1' $kondisiSKPD $kondisiRekening"));
		$Total = $getData['sum(jumlah_harga)'];
		$getTotalPegawai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f ='00' ) and id_tahap='$idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka = '2.2.1' and k = '5' and l ='2' and m='1' $kondisiSKPD $kondisiRekening"));
		$TotalBelanjaPegawai = $getTotalPegawai['sum(jumlah_harga)'];
		$getTotalBarangJasa = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f ='00' ) and id_tahap='$idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka = '2.2.1' and k = '5' and l ='2' and m='2' $kondisiSKPD $kondisiRekening"));
		$TotalBelanjaBarangJasa = $getTotalBarangJasa['sum(jumlah_harga)'];
		$getTotalModal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f ='00' ) and id_tahap='$idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka = '2.2.1' and k = '5' and l ='2' and m='3' $kondisiSKPD $kondisiRekening"));
		$TotalBelanjaModal = $getTotalModal['sum(jumlah_harga)'];
		$ContentTotalHal=''; $ContentTotal='';
			$TampilTotalHalRp = number_format($this->SumValue[0],2, ',', '.');
			$TotalColSpan1 = $this->FieldSum_Cp1[$Mode-1];//$Mode ==1 ? 5 : 4;
			$TotalColSpan2 = $this->FieldSum_Cp2[$Mode-1];//$Mode ==1 ? 5 : 4;	
			$Kiri2 = $TotalColSpan1 > 0 ? "<td class='$ColStyle' colspan='8' align='center'><b>Total</td>": '';
				$ContentTotal = 
				"<tr>
					$Kiri2
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($this->totalAnggaran,2,',','.')."</div></td>
					
				</tr>" ;

			

				
			if($Mode == 2){			
				$ContentTotal = '';
			}else if($Mode == 3){
				$ContentTotalHal='';			
			}
			
		return $ContentTotalHal.$ContentTotal;
	}
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];

	 foreach ($_REQUEST as $key => $value) { 
		  $$key = $value; 
	 } 
	
	
	
	$user = $_COOKIE['coID'];
	$arrayKodeRekening = explode(".",$kodeRekening);
	$k = $arrayKodeRekening[0];
	$l = $arrayKodeRekening[1];
	$m = $arrayKodeRekening[2];
	$n = $arrayKodeRekening[3];
	$o = $arrayKodeRekening[4];
	
	$getJumlahBarang = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$pembuatanSPD_idplh'"));
	$jumlahBarang = $getJumlahBarang['volume_barang'];
	$total = $hargaSatuan * $jumlahBarang;
	
	/* $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja "));
  	 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
	$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));*/
	$getPaguYangTelahTerpakai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from tabel_spd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and no_urut = '$this->nomorUrut' and id_anggaran!='$pembuatanSPD_idplh' "));
	$sisaPaguIndikatif = $paguIndikatif - $getPaguYangTelahTerpakai['paguYangTerpakai'];
    
	 if(mysql_num_rows(mysql_query("select * from tabel_spd where c1='0' and f = '00' and k = '$k' and l ='$l' and m='$m' and n='$n' and o='$o'  and id_tahap='$this->idTahap' ")) > 0){
				 	
					}else{
						$arrayRekening = array(
											'c1' => '0',
											'c' => '00',
											'd' => '00',
											'e' => '00',
											'e1' => '000',
											'f1' => '0',
							  				'f2' => '0',
							  				'f' => '00',
							 			    'g' => '00',
							  			    'h' => '00',
										    'i' => '00',
										    'j' => '000',
											'k' => $k,
											'l' => $l,
											'm' => $m,
											'n' => $n,
											'o' => $o,
											'tahun' => $this->tahun,
											'jenis_anggaran' => $this->jenisAnggaran,
											'id_tahap' => $this->idTahap,
											'nama_modul' => 'RKA-SKPD'
											);
						$queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
						mysql_query($queryRekening);
					}
	 	
 	 if(empty($cmbJenisRKAForm) ){
	   	$err= 'Pilih Jenis RKA ';
	 }elseif(empty($kodeRekening)){
	 	$err = 'Pilih Rekening';
	 }elseif(empty($hargaSatuan) || $hargaSatuan == '0'){
	 	$err = 'Isi Harga Satuan';
	 }elseif($total > $sisaPaguIndikatif){
	 	$err = 'Tidak dapat Melebihi Pagu Indikatif';
	 }else{
	 	$data = array(
						'k' => $k,
						'l' => $l,
						'm' => $m,
						'n' => $n,
						'o' => $o,
						'satuan_rek' => $hargaSatuan,
						'jenis_rka' => $cmbJenisRKAForm,
						'jumlah_harga' => $total
							
					   );
		$query = VulnWalkerUpdate('tabel_anggaran',$data,"id_anggaran = '$pembuatanSPD_idplh'");
		mysql_query($query);
	 }
	 
		
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
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
		case 'Laporan':{	
			$json = FALSE;
			$this->Laporan();										
		break;
		}
		
		case 'SaveNomorSPD':{	
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 
			if(empty($noSPD)){
				$err = "Isis nomor SPD";
			}elseif(empty($tanggalSPD)){
				$err = "Isi Tanggal SPD";
			}elseif(mysql_num_rows(mysql_query("select * from nomor_spd where nomor_spd = '$noSPD'")) != 0){
				$err = "Nomor SPD sudah ada";
			}else{
				$tanggalSPD = explode("-",$tanggalSPD);
				$tanggalSPD = $tanggalSPD[2]."-".$tanggalSPD[1]."-".$tanggalSPD[0];
				$dataSpd = array(
									"tahun" => $this->tahun,
									"anggaran" => $this->jenisAnggaran,
									"c1" => $cmbUrusan,
									"c" => $cmbBidang,
									"d" => $cmbSKPD,
									"nomor_spd" => $noSPD,
									"tanggal_spd" => $tanggalSPD
									);
				mysql_query(VulnWalkerInsert("nomor_spd",$dataSpd));
				$kondisiSKPD = "and c1='".$cmbUrusan."' and c='".$cmbBidang."' and d='".$cmbSKPD."'";
				$getIDBarusan = mysql_fetch_array(mysql_query("select * from nomor_spd where  nomor_spd ='$noSPD' and tahun='$this->tahun' and anggaran ='$this->jenisAnggaran' $kondisiSKPD "));
				$codeAndNamePekerjaan = "select id, nomor_spd from nomor_spd where 1=1 $kondisiSKPD ";
				$cmbNomorSPD = cmbQuery('cmbNomorSPD', $getIDBarusan['id'], $codeAndNamePekerjaan,"  ",'-- NOMOR SPD --');
				
				$content = array('cmbNomorSPD' => $cmbNomorSPD);
			}										
		break;
		}
		
		case 'SaveEditNomorSPD':{	
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 
			if(empty($noSPD)){
				$err = "Isis nomor SPD";
			}elseif(empty($tanggalSPD)){
				$err = "Isi Tanggal SPD";
			}elseif(mysql_num_rows(mysql_query("select * from nomor_spd where nomor_spd = '$noSPD' and id !='$cmbNomorSPD'")) != 0){
				$err = "Nomor SPD sudah ada";
			}else{
				$tanggalSPD = explode("-",$tanggalSPD);
				$tanggalSPD = $tanggalSPD[2]."-".$tanggalSPD[1]."-".$tanggalSPD[0];
				$dataSpd = array(
									"nomor_spd" => $noSPD,
									"tanggal_spd" => $tanggalSPD
									);
				mysql_query(VulnWalkerUpdate("nomor_spd",$dataSpd,"id ='$cmbNomorSPD'"));
				$kondisiSKPD = "and c1='".$cmbUrusan."' and c='".$cmbBidang."' and d='".$cmbSKPD."'";
				$codeAndNamePekerjaan = "select id, nomor_spd from nomor_spd where 1=1 $kondisiSKPD ";
				$cmbNomorSPD = cmbQuery('cmbNomorSPD', $cmbNomorSPD, $codeAndNamePekerjaan,"  ",'-- NOMOR SPD --');
				
				$content = array('cmbNomorSPD' => $cmbNomorSPD);
			}										
		break;
		}
		case 'editNomorSPD':{
				$dt = $_REQUEST['noSPD'];
				$fm = $this->editNomorSPD($dt);				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];										
		break;
		}
		
		case 'setSPD':{	
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 
			if(empty($cmbNomorSPD)){
				$err = "Pilih Nomor SPD";
			}else{
				$arrayMemberRekening = array();
				
				
				if(strpos($anggota, ',') !== false) {
				    $arrayRekening = explode(',',$anggota);
					$huge = sizeof($arrayRekening);
					for($i = 0 ; $i < $huge; $i++){
						$id_rekening =  $arrayRekening[$i];
						$getRekening = mysql_fetch_array(mysql_query("select * from tabel_spd where id = '$id_rekening'"));
						foreach ($getRekening as $key => $value) { 
						  $$key = $value; 
					 	}
						$data = array("nomor_spd" => $cmbNomorSPD);
						$arrayMemberRekening[] = $k.".".$l.".".$m.".".$n.".".$o;
						mysql_query(VulnWalkerUpdate("tabel_spd",$data,"id = '$id_rekening'"));
						
					}
					
					
				}else{
						$id_rekening =  $anggota;
						
						
						$data = array("nomor_spd" => $cmbNomorSPD);
						$arrayMemberRekening[] = $k.".".$l.".".$m.".".$n.".".$o;
						mysql_query(VulnWalkerUpdate("tabel_spd",$data,"id = '$id_rekening'"));
				}
				
			}									
		break;
		}
		case 'inputSPD':{	
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 
			if(!isset($pembuatanSPD_cb)){
				$err = "Pilih Data";
			}
			if(empty($cmbUrusan)){
				$err = "Pilih Urusan";
			}elseif(empty($cmbBidang)){
				$err = "Pilih Bidang";
			}elseif(empty($cmbSKPD)){
				$err = "Pilih SKPD";
			}
			$dt = implode(',',$pembuatanSPD_cb);
			if($this->jenisForm !='PENYUSUNAN')$err = "Tahap Penyusunan Telah Habis";
				 if($err == ''){
						$fm = $this->inputSPD($dt);				
						$cek = $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
				 }			
															
		break;
		}
		case 'showListRekening':{
				$fm = $this->showListRekening();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];										
		break;
		}	
		case 'formBaru':{				
			$fm = $this->setFormBaru();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'formEdit':{				
			$fm = $this->setFormEdit();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		case 'Info':{
				$fm = $this->Info();				
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];										
		break;
		}
		case 'clearTemp':{
				$username =$_COOKIE['coID'];
				mysql_query("delete from temp_rka_221 where user ='$username'");							
		break;
		}
		case 'BidangAfterForm':{
			 $kondisiBidang = "";
			 $cmbUrusan = $_REQUEST['fmSKPDUrusan'];
			 $cmbBidang = $_REQUEST['fmSKPDBidang'];
			 
			 $codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) as vnama from ref_skpd where d='00' and c ='00' order by c1";
		
		     $codeAndNameBidang = "SELECT c, concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where d = '00' and e = '00' and c!='00'and c1 = '$cmbUrusan'  and e1='000'";	
		
		     $codeAndNameskpd = "SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd  where c='$cmbBidang' and c1='$cmbUrusan' and d != '00' and  e = '00' and e1='000' ";
			
			
				$bidang =  cmbQuery('cmbBidangForm', $cmbBidang, $codeAndNameBidang,' '.$cmbRo.' onChange=\''.$this->Prefix.'.BidangAfterform()\'','-- Pilih Semua --');	
				$skpd = cmbQuery('cmbSKPDForm', $cmbSKPD, $codeAndNameskpd,''.$cmbRo.'','-- Pilih Semua --');
				$content = array('bidang' => $bidang, 'skpd' =>$skpd ,'queryGetBidang' => $kondisiBidang);
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
			$get= $this->simpan();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }

		
	    case 'Validasi':{
			$dt = array();
			$err='';
			$content='';
			$uid = $HTTP_COOKIE_VARS['coID'];
			
			$cbid = $_REQUEST[$this->Prefix.'_cb'];
			$idplh = $cbid[0];
			$this->form_idplh = $cbid[0];
			
			$qry = "SELECT * FROM tabel_anggaran WHERE id_anggaran = '$idplh' ";$cek=$qry;
			$aqry = mysql_query($qry);
			$dt = mysql_fetch_array($aqry);
			$username = $_COOKIE['coID'];
			$user_validasi = $dt['user_validasi'];

			if ($username != $user_validasi && $dt['status_validasi'] == '1') {
				$getNamaOrang = mysql_fetch_array(mysql_query("select * from admin where uid = '$user_validasi'"));
				$err = "Data Sudah di Validasi, Perubahan Hanya Bisa Dilakukan oleh ".$getNamaOrang['nama']." !";
			}
			
			
			if($err == ''){
				$fm = $this->Validasi($dt);				
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			}				
															
		break;
		}
		
		
		 case 'Catatan':{
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			
			$getData = mysql_fetch_array(mysql_query("SELECT * FROM tabel_anggaran WHERE id_anggaran = '$idAwal'"));
			foreach ($getData as $key => $value) { 
				  $$key = $value; 
			}
			$getMaxID = mysql_fetch_array(mysql_query("select max(id_anggaran) as maxID from tabel_anggaran where tahun = '$tahun'  and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$p' and q='$q' and jenis_anggaran = '$jenis_anggaran'  ")); 
			$maxID = $getMaxID['maxID'];
			$aqry = "select * from tabel_anggaran where id_anggaran ='$maxID' ";
			$dt = mysql_fetch_array(mysql_query($aqry));
			if($dt['id_tahap'] != $this->idTahap){
				$err = "Data Belum Di Koreksi ";
			}
			if($err == ''){
				$fm = $this->Catatan($dt);				
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
			}				
															
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
     function setPage_HeaderOther(){
   		
	return 
			"";
	}
   function setPage_OtherScript(){
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
					</script>";
		//if($this->jenisForm == "PENYUSUNAN")
		$read = "<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/spd/pembuatanSPD.js' language='JavaScript' ></script> ";
		return 	
			"
			<script src='js/skpd.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/spd/listRekening.js' language='JavaScript' ></script>

			$read
			  <link rel='stylesheet' href='datepicker/jquery-ui.css'>
			  <script src='datepicker/jquery-1.12.4.js'></script>
			  <script src='datepicker/jquery-ui.js'></script>
			  
			".
			$scriptload;
	}
	
	function setFormBaru(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d");
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
   
  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;				
		if($err == ''){
			$aqry = "SELECT * FROM  tabel_anggaran WHERE id_anggaran='".$this->form_idplh."' "; $cek.=$aqry;
			$dt = mysql_fetch_array(mysql_query($aqry));
			$fm = $this->setForm($dt);
		}
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}	
	function Info(){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 500;
	 $this->form_height = 100;
	 $this->form_caption = 'INFO RKA';

	 
	 if($this->jenisFormTerakhir == "VALIDASI"){
	 	$getJumlahSKPDYangMengisiPlafon = mysql_num_rows(mysql_query("select * from view_plafon where tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$this->noUrutTerakhirPlafon' and d!='00' and status_validasi = '1' "));
	 }else{
	 	$getJumlahSKPDYangMengisiPlafon = mysql_num_rows(mysql_query("select * from view_plafon where tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$this->noUrutTerakhirPlafon' and d!='00' "));
	 }
	 
	 
	 	
	 //items ----------------------
	  $this->form_fields = array(
			'1' => array( 
						'label'=>'ANGGARAN',
						'labelWidth'=>150, 
						'value'=>$this->jenisAnggaran. " TAHUN  ". $this->tahun,
						 ),
			'2' => array( 
						'label'=>'NAMA TAHAP TERAKHIR',
						'labelWidth'=>150, 
						'value'=>$this->namaTahapTerakhir,
						 ),	
			'3' => array( 
						'label'=>'WAKTU',
						'labelWidth'=>150, 
						'value'=>$this->masaTerakhir,
						 ),		
			'4' => array( 
						'label'=>'TAHAP SEKARANG',
						'labelWidth'=>150, 
						'value'=>$this->currentTahap,
						 )
						 				
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
		
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 700;
	 $this->form_height = 200;
	 $this->form_caption = 'Baru';

	 foreach ($_REQUEST as $key => $value) { 
		  			$$key = $value; 
	 }
	 $getNamaUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 ='$cmbUrusan' and c='00' and d='00'"));
	 $urusan = $getNamaUrusan['nm_skpd'];
	 $getNamaBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 ='$cmbUrusan' and c='$cmbBidang' and d='00'"));
	 $bidang = $getNamaBidang['nm_skpd'];
	 $getNamaSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 ='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='00'"));
	 $skpd = $getNamaSKPD['nm_skpd'];
	 $getProgram = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck='$ck' and dk='0' and p='$hiddenP' and q='0'"));
	 $program = $getProgram['nama'];
	 $getKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk ='$bk' and ck='$ck' and dk='0' and p='$hiddenP' and q='$q'"));
	 $kegiatan = $getKegiatan['nama'];


	 
	  $this->form_fields = array(
	  	  	'kode0' => array(
	  					'label'=>'URUSAN',
						'labelWidth'=>150, 
						'value'=> $urusan
						 ),
	  		'kode1' => array(
	  					'label'=>'BIDANG',
						'labelWidth'=>150, 
						'value'=> $bidang
						 ),
			'kode2' => array( 
						'label'=>'SKPD',
						'labelWidth'=>150, 
						'value'=> $skpd
						 ),
			'kode5' => array( 
						'label'=>'PROGRAM',
						'labelWidth'=>150, 
						'value'=> $program
						 ),
			'kode6' => array( 
						'label'=>'KEGIATAN',
						'labelWidth'=>150, 
						'value'=> $kegiatan
						 ),
			'kode12' => array( 
						'label'=>'NOMOR SPD',
						'labelWidth'=>150, 
						'value'=> "<input type='text' id='nomorSPD' name='nomorSPD'>"
						 ),	
			'kode1ss' => array( 
						'label'=>'TANGGAL SPD',
						'labelWidth'=>150, 
						'value'=> "<input type='text' id='tanggalSPD' name='tanggalSPD'>"
						 ),		
			'kode11' => array( 
						'label'=>'DETAIL',
						'labelWidth'=>150, 
						'value'=> "<input type='button' value='Detail' onclick=$this->Prefix.showListRekening(); >",
						 ),	

			
			
			);
		//tombol
		$this->form_menubawah =
			"
				<input type='hidden' name='c1' id='c1' value='$cmbUrusan'> 
				<input type='hidden' name='c' id='c' value='$cmbBidang'> 
				<input type='hidden' name='d' id='d' value='$cmbSKPD'> 
				<input type='hidden' name='bk' id='bk' value='$bk'> 
				<input type='hidden' name='ck' id='ck' value='$ck'> 
				<input type='hidden' name='p' id='p' value='$hiddenP'> 
				<input type='hidden' name='q' id='q' value='$q'> 

			"
			.
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".saveSPD()' title='Simpan' >  &nbsp  ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	

		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	
		
		 
	 
		$headerTable =
		  "<thead>
		   <tr>
	  	   <th class='th01' width='5'  >No.</th>	
		   $Checkbox
		   <th class='th01' width='80' colspan ='3'   >KODE SKPD</th>
		   <th class='th01' width='600' >NAMA SKPD</th>
		   <th class='th01' width='200' >NOMOR SPD</th>
		   <th class='th01' width='150' >TANGGAL SPD</th>
		   <th class='th01' width='150' >ANGGARAN</th>




		   </tr>


		   </thead>";
	 
	
	 	
	 $NomorColSpan = $Mode==1? 2: 1;
	 
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) { 
		  			$$key = $value; 
	 }
	 foreach ($_REQUEST as $key => $value) { 
		  			$$key = $value; 
	 }
		if($cmbSKPD != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
		}elseif($cmbBidang != ''){
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
		}elseif($cmbUrusan != ''){
			$kondisiSKPD = "and c1='$cmbUrusan'";
		}

	 	$Koloms = array();
	 	$Koloms[] = array('align="center"', $no.'.' );
		 if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);

	 	
		$Koloms[] = array('align="center"', $c1 );	
		$Koloms[] = array('align="center"', $c );	
		$Koloms[] = array('align="center"', $d );	
		$getNamaSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c ='$c' and d='$d' and e='00'"));
		$namaSKPD = $getNamaSKPD['nm_skpd'];
		$Koloms[] = array('align="left"', $namaSKPD );	
		$Koloms[] = array('align="left"', $nomor_spd );	
		$Koloms[] = array('align="left"', VulnWalkerTitiMangsa($tanggal_spd) );	
		$getAnggaran = mysql_fetch_array(mysql_query("select sum(total) from tabel_spd where nomor_spd = '$id'"));
		$Koloms[] = array('align="right"', number_format($getAnggaran['sum(total)'] ,2,',','.') );
		$this->totalAnggaran += $getAnggaran['sum(total)'];

	



	 
	 
	 
	

	 return $Koloms;
	}


	function Validasi($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI RKA-SKPD 2.2';
	 $kode = $dt['c1'].".".$dt['c'].".".$dt['d'];
	  if ($dt['status_validasi'] == '1') {
	  	//2017-03-30 17:12:16
		// $tglvalidnya = $dt['tgl_validasi'];
		// $thn1 = substr($tglvalidnya,0,4); 
		// $bln1 = substr($tglvalidnya,5,2); 
		// $tgl1 = substr($tglvalidnya,8,2); 
		// $jam1 = substr($tglvalidnya,11,8);
		$arrayTanggalValidasi = explode("-", $dt['tanggal_validasi']);

		$tglvalid = $arrayTanggalValidasi[2]."-".$arrayTanggalValidasi[1]."-".$arrayTanggalValidasi[0];
		$username = $dt['user_validasi'];
		$checked = "checked='checked'";			
	  }else{			
		$tglvalid = date("d-m-Y");
		$checked = "";	
		$username = $_COOKIE['coID'];
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			'kode' => array( 
						'label'=>'KODE pembuatanSPD',
						'labelWidth'=>100, 
						'value'=>$kode, 
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),
			'tgl_validasi' => array( 
						'label'=>'TANGGAL',
						'labelWidth'=>100, 
						'value'=>$tglvalid, 
						'type'=>'text',
						'param'=>"style='width:125px;' readonly"
						 ),

			'username' => array( 
						'label'=>'USERNAME',
						'labelWidth'=>100, 
						'value'=>$username ,
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),
			'validasi' => array( 
						'label'=>'VALIDASI DATA',
						'labelWidth'=>100, 
						'value'=>"<input type='checkbox' name='validasi' $checked style='margin-left:-1px;' />",
						 ),					
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveValid()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Catatan($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'CATATAN';
	 $catatan = $dt['catatan'];
	 $idnya = $dt['id_anggaran'];
	 	
	 //items ----------------------
	  $this->form_fields = array(
			'catatan' => array( 
						'label'=>'CATATAN',
						'labelWidth'=>100, 
						'value'=>"<textarea id='catatan' name='catatan' style='width:100%; height : 100px;'>".$catatan."</textarea>",
						 ),					
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveCatatan($idnya)' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 
	 
	 $arrOrder = array(
				     	array('nama_tahap','NAMA TAHAP'),		
						array('waktu_aktif','WAKTU AKTIF'),	
						array('waktu_pasif','WAKTU PASIF'),
						array('modul','MODUL'),
						array('status','STATUS')			
					);
	 
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];			
$fmORDER1 = $_REQUEST['fmORDER1'];


	$fmDESC1 = cekPOST('fmDESC1');
	$baris = $_REQUEST['baris'];
	if($baris == ''){
		$baris = "25";
	}
	
	$selectedC1 = $_REQUEST['cmbUrusan'];
	$selectedC  = $_REQUEST['cmbBidang'];
	$selectedD = $_REQUEST['cmbSKPD'];
	$selectedE = $_REQUEST['cmbUnit'];
	$selectedE1 = $_REQUEST['cmbSubUnit'];
	
	
	
	
	if(!isset($selectedC1) ){
	   		$arrayData = mysql_fetch_array(mysql_query("select * from current_filter where username ='".$_COOKIE['coID']."'"));
			foreach ($arrayData as $key => $value) { 
			  $$key = $value; 
			 }
			 if($CurrentQ !='' ){
			 	$_REQUEST['p'] = $CurrentBK.".".$CurrentCK.".".$CurrentP;
				$_REQUEST['q'] =  $CurrentQ;
			 	$selectedE1 = $CurrentSubUnit;
			 	$selectedE = $CurrentUnit;
				$selectedD = $CurrentSKPD;
				$selectedC = $CurrentBidang;
				$selectedC1 = $CurrentUrusan;
				
			}elseif($CurrentP !='' ){
			 	$_REQUEST['p'] = $CurrentBK.".".$CurrentCK.".".$CurrentP;
			 	$selectedE1 = $CurrentSubUnit;
			 	$selectedE = $CurrentUnit;
				$selectedD = $CurrentSKPD;
				$selectedC = $CurrentBidang;
				$selectedC1 = $CurrentUrusan;
				
			}elseif($CurrentSubUnit !='000' ){
			 	$selectedE1 = $CurrentSubUnit;
			 	$selectedE = $CurrentUnit;
				$selectedD = $CurrentSKPD;
				$selectedC = $CurrentBidang;
				$selectedC1 = $CurrentUrusan;
				
			}elseif($CurrentUnit !='00' ){
			 	$selectedE = $CurrentUnit;
				$selectedD = $CurrentSKPD;
				$selectedC = $CurrentBidang;
				$selectedC1 = $CurrentUrusan;
				
			}elseif($CurrentSKPD !='00' ){
				$selectedD = $CurrentSKPD;
				$selectedC = $CurrentBidang;
				$selectedC1 = $CurrentUrusan;
				
			}elseif($CurrentBidang !='00'){
				$selectedC = $CurrentBidang;
				$selectedC1 = $CurrentUrusan;
	
			}elseif($CurrentUrusan !='0'){
				$selectedC1 = $CurrentUrusan;
			}
	   }
	
	$arrayProgram = explode(".",$_REQUEST['p']);
	$selectedBK = $arrayProgram[0];
	$selectedCK = $arrayProgram[1];
	$selectedP = $arrayProgram[2];
	$selectedQ = $_REQUEST['q'];
	
	foreach ($_COOKIE as $key => $value) { 
				  $$key = $value; 
			}
	
	
		if($VulnWalkerSubUnit != '000'){
			$selectedE1 = $VulnWalkerSubUnit;
			$selectedE = $VulnWalkerUnit;
			$selectedD = $VulnWalkerSKPD;
			$selectedC = $VulnWalkerBidang;
			$selectedC1 = $VulnWalkerUrusan;
		}elseif($VulnWalkerUnit != '00'){
			$selectedE = $VulnWalkerUnit;
			$selectedD = $VulnWalkerSKPD;
			$selectedC = $VulnWalkerBidang;
			$selectedC1 = $VulnWalkerUrusan;
		}elseif($VulnWalkerSKPD != '00'){
			$selectedD = $VulnWalkerSKPD;
			$selectedC = $VulnWalkerBidang;
			$selectedC1 = $VulnWalkerUrusan;
		}elseif($VulnWalkerBidang != '00'){
			$selectedC = $VulnWalkerBidang;
			$selectedC1 = $VulnWalkerUrusan;
		}elseif($VulnWalkerUrusan != '0'){
			$selectedC1 = $VulnWalkerUrusan;
		}

		$codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) from ref_skpd where c='00' and d='00' and e='00' and e1='000' ";
		$urusan = cmbQuery('cmbUrusan',$selectedC1,$codeAndNameUrusan,'onchange=pembuatanSPD.refreshList(true);','-- URUSAN --');
		
		$codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c !='00' and d='00' and e='00' and e1='000' ";
		$bidang = cmbQuery('cmbBidang',$selectedC,$codeAndNameBidang,'onchange=pembuatanSPD.refreshList(true);','-- BIDANG --');
		
		$codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d!='00' and e='00' and e1='000' ";
		$skpd= cmbQuery('cmbSKPD',$selectedD,$codeAndNameSKPD,'onchange=pembuatanSPD.refreshList(true);','-- SKPD --');
		
		$codeAndNameUnit = "select e, concat(e, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e!='00' and e1='000' ";
		$unit = cmbQuery('cmbUnit',$selectedE,$codeAndNameUnit,'onchange=pembuatanSPD.refreshList(true);','-- UNIT --');
		
		
		$codeAndNameSubUnit = "select e1, concat(e1, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1!='000' ";
		$subunit = cmbQuery('cmbSubUnit',$selectedE1,$codeAndNameSubUnit,'onchange=pembuatanSPD.refreshList(true);','-- SUB UNIT --');


	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran) as max from view_rkbmd "));
	$maxID = $get1['max'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran = '$maxID' "));
	$nomorUrutSebelumnya =  $get2['no_urut'];

		$codeAndNameProgram = mysql_query("select tabel_anggaran.bk, tabel_anggaran.ck, tabel_anggaran.p as pFromProgram, tabel_anggaran.q  , ref_program.nama from tabel_anggaran  inner join ref_program on tabel_anggaran.bk = ref_program.bk and tabel_anggaran.ck = ref_program.ck and tabel_anggaran.p = ref_program.p and tabel_anggaran.q = ref_program.q  inner join ref_tahap_anggaran on tabel_anggaran.id_tahap = ref_tahap_anggaran.id_tahap where tabel_anggaran.dk='0' and ref_tahap_anggaran.no_urut = '$nomorUrutSebelumnya' and tabel_anggaran.tahun ='$this->tahun' and tabel_anggaran.jenis_anggaran = '$this->jenisAnggaran' and tabel_anggaran.c1 = '$selectedC1' and tabel_anggaran.c = '$selectedC' and tabel_anggaran.d = '$selectedD'  and tabel_anggaran.q='0'  ");
	$pSama = "";
	$arrayP = array() ;
	while($rows = mysql_fetch_array($codeAndNameProgram)){
		foreach ($rows as $key => $value) { 
				  $$key = $value; 
		}
		
			$concat = $bk.".".$ck.".".$pFromProgram ;
			if($concat != ".."){
				if($concat == $pSama){		
				}else{
					array_push($arrayP,
				 	  array($concat,$nama  )
					);
				}
			}
		
		
		
		
		
		
		$pSama = $concat;		
	}
	
	$program = "<input type='hidden' id='bk' name='bk' value='$selectedBK'> <input type='hidden' id='ck' name='ck' value='$selectedCK'> <input type='hidden' id='hiddenP' name='hiddenP' value='$selectedP'>".cmbArray('p',$_REQUEST['p'],$arrayP,'-- PROGRAM --','onchange=pembuatanSPD.programChanged();');
	
	$codeAndNameKegiatan = mysql_query("select tabel_anggaran.bk, tabel_anggaran.ck, tabel_anggaran.p, tabel_anggaran.q, ref_program.nama from tabel_anggaran  inner join ref_program on tabel_anggaran.bk = ref_program.bk and tabel_anggaran.ck = ref_program.ck and tabel_anggaran.p = ref_program.p and tabel_anggaran.q = ref_program.q  inner join ref_tahap_anggaran on tabel_anggaran.id_tahap = ref_tahap_anggaran.id_tahap where tabel_anggaran.dk='0' and ref_tahap_anggaran.no_urut = '$nomorUrutSebelumnya' and tabel_anggaran.tahun ='$this->tahun' and tabel_anggaran.jenis_anggaran = '$this->jenisAnggaran' and tabel_anggaran.c1 = '$selectedC1' and tabel_anggaran.c = '$selectedC' and tabel_anggaran.d = '$selectedD' and tabel_anggaran.q !='0' and tabel_anggaran.bk='$selectedBK' and tabel_anggaran.ck='$selectedCK' and tabel_anggaran.p='$selectedP'  ");
	
	//}
	$qSama = "";
	$arrayQ = array() ;
	while($rows = mysql_fetch_array($codeAndNameKegiatan)){
		foreach ($rows as $key => $value) { 
				  $$key = $value; 
		}
		if($q != 0) {
			if($q == $qSama){		
			}else{
				array_push($arrayQ,
				   array($q,$nama)
				);
			}
		}
		
		
		
		
		$qSama = $q;		
	}
	
	$kegiatan = cmbArray('q',$_REQUEST['q'],$arrayQ,'-- KEGIATAN --','onchange=pembuatanSPD.refreshList(true);');
	
	
	if($this->jenisForm == "KOREKSI" || $this->jenisForm == "PENYUSUNAN" || $this->jenisForm == "VALIDASI"){
		$getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		$idTahapRenja = $getIdTahapRenjaTerakhir['max'];
		
		$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
		$getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$this->idTahap'  "));
		$cekDulu=mysql_num_rows(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja'"));
		if($cekDulu == 0){
			$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD'  and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
			$getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD'  and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$this->idTahap'  "));
		
		}
		$angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');
		
		$sisaPagu = $getPaguIndikatif['jumlah'] - $getPaguYangTerpakai['paguYangTerpakai'];
		$sisaPagu =  number_format($sisaPagu ,2,',','.');
		$paguIndikatif = "<input type='text' value='$angkaPaguIndikatif' readonly> &nbsp &nbsp &nbsp SISA PAGU  :  <input type='text' value='$sisaPagu' readonly>";
		
	}else{
		$getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		$idTahapRenja = $getIdTahapRenjaTerakhir['max'];
		$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
		$cekDulu = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
		$getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1='$selectedE1' and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and no_urut = '$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  "));
		
		if($cekDulu ==0){
			$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$selectedC1' and c='$selectedC' and d='$selectedD'  and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and id_tahap = '$idTahapRenja' "));
			$getPaguYangTerpakai =  mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_2_2_1 where c1= '$selectedC1' and c='$selectedC' and d='$selectedD'  and bk='$selectedBK' and ck='$selectedCK' and p='$selectedP' and q='$selectedQ' and no_urut = '$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  "));
		
		}
		$angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');
		
		$sisaPagu = $getPaguIndikatif['jumlah'] - $getPaguYangTerpakai['paguYangTerpakai'];
		$sisaPagu =  number_format($sisaPagu ,2,',','.');
		$paguIndikatif = "<input type='text' value='$angkaPaguIndikatif' readonly> &nbsp &nbsp &nbsp SISA PAGU  :  <input type='text' value='$sisaPagu' readonly>";
		
	}
	$arrayBelanja = array(
						   array('BELANJA PEGAWAI','BELANJA PEGAWAI'),
						   array('BELANJA BELANJA BARANG & JASA','BELANJA BARANG & JASA'),
						   array('BELANJA MODAL','BELANJA MODAL'),
					);
	$arrayDPA = array(
						   array('DPA-SKPD 2.2.1','DPA-SKPD 2.2.1'),
						   array('DPA-SKPD 2.1','DPA-SKPD 2.1'),
						   array('DPA-SKPD 1','DPA-SKPD 1'),
						   array('DPA-PPKD 1','DPA-PPKD 1'),
						   array('DPA-PPKD 2.1','DPA-PPKD 2.1'),
						   array('DPA-PPKD 3.1','DPA-PPKD 3.1'),
						   array('DPA-PPKD 3.2','DPA-PPKD 3.2'),
					);
	//$cmbBelanja = cmbArray('cmbBelanja',$_REQUEST['cmbBelanja'],$arrayBelanja,'-- JENIS BELANJA--','onchange=pembuatanSPD.refreshList(true);');
	$cmbDPA = cmbArray('cmbDPA',$_REQUEST['cmbDPA'],$arrayDPA,'-- JENIS DPA --','onchange=pembuatanSPD.refreshList(true);');
	
	
	$TampilOpt = 
			"<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td>URUSAN </td>
			<td>:</td>
			<td style='width:86%;'> 
			".$urusan."
			</td>
			</tr>
			<tr>
			<td>BIDANG</td>
			<td>:</td>
			<td style='width:86%;'>
			".$bidang."
			</td>
			</tr>
			<tr>
			<td>SKPD</td>
			<td>:</td>
			<td style='width:86%;'>
			".$skpd."
			</td>
			</tr>
			</table>".
			"</div>"."<div class='FilterBar' style='margin-top:5px;'>".
			"<table style='width:100%'>
			<tr>
			<td>PROGRAM</td>
			<td>:</td>
			<td style='width:86%;'>
			<input type='hidden' name='tahun' id='tahun' value='$this->tahun' style='width:40px;' > <input type='hidden' name ='cmbJenisRKA' id='cmbJenisRKA' value='2.2.1'>
			".$program."
			</td>
			</tr>
			<tr>
			<td>KEGIATAN</td>
			<td>:</td>
			<td style='width:86%;'>
			".$kegiatan."
			</td>
			</tr>
			</table>".
			"</div>"
			;
			
		return array('TampilOpt'=>$TampilOpt);
		
		
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$nomorUrutSebelumnya = $this->nomorUrut - 1;		
		$arrKondisi = array();		
		$arrKondisi[] = ' 1 = 1';
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn

	
		$cmbJenisRKA = $_REQUEST['cmbJenisRKA'];

		foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 }
			
		if(isset($q)){
			$data = array("CurrentUrusan" => $cmbUrusan,
					  "CurrentBidang" => $cmbBidang,
					  "CurrentSKPD" => $cmbSKPD,
					   "CurrentUnit" => $cmbUnit,
					    "CurrentSubUnit" => $cmbSubUnit,
						"CurrentBK" => $bk,
						"CurrentCK" => $ck,
						"CurrentP" => $hiddenP,
						"CurrentQ" => $q,
					  
					  );
		}elseif(isset($hiddenP)){
			$data = array("CurrentUrusan" => $cmbUrusan,
					  "CurrentBidang" => $cmbBidang,
					  "CurrentSKPD" => $cmbSKPD,
					   "CurrentUnit" => $cmbUnit,
					    "CurrentSubUnit" => $cmbSubUnit,
						"CurrentBK" => $bk,
						"CurrentCK" => $ck,
						"CurrentP" => $hiddenP,
					  
					  );
		}elseif(isset($cmbSubUnit)){
			$data = array("CurrentUrusan" => $cmbUrusan,
					  "CurrentBidang" => $cmbBidang,
					  "CurrentSKPD" => $cmbSKPD,
					   "CurrentUnit" => $cmbUnit,
					    "CurrentSubUnit" => $cmbSubUnit,
					  
					  );
		}elseif(isset($cmbUnit)){
			$data = array("CurrentUrusan" => $cmbUrusan,
					  "CurrentBidang" => $cmbBidang,
					  "CurrentSKPD" => $cmbSKPD,
					   "CurrentUnit" => $cmbUnit,
					  
					  );
		}elseif(isset($cmbSKPD)){
			$data = array("CurrentUrusan" => $cmbUrusan,
					  "CurrentBidang" => $cmbBidang,
					  "CurrentSKPD" => $cmbSKPD,
					  
					  );
		}elseif(isset($cmbBidang)){
			$data = array("CurrentUrusan" => $cmbUrusan,
					  "CurrentBidang" => $cmbBidang,
					  
					  );
		}elseif(isset($cmbUrusan)){
			$data = array("CurrentUrusan" => $cmbUrusan
			
			 );
		}
		
		mysql_query(VulnWalkerUpdate("current_filter",$data,"username='$this->username'"));
		
		if(!isset($cmbUrusan) ){
	   		$arrayData = mysql_fetch_array(mysql_query("select * from current_filter where username ='".$_COOKIE['coID']."'"));
			foreach ($arrayData as $key => $value) { 
			  $$key = $value; 
			 }
			 if($CurrentQ !='' ){
			 	$_REQUEST['q'] = $CurrentQ;
			 	$_REQUEST['hiddenP'] = $CurrentP;
				$_REQUEST['bk'] = $CurrentBK;
				$_REQUEST['ck'] = $CurrentCK;
				$selectedQ =  $CurrentQ;
			 	$cmbSubUnit = $CurrentSubUnit;
			 	$cmbUnit = $CurrentUnit;
				$cmbSKPD = $CurrentSKPD;
				$cmbBidang = $CurrentBidang;
				$cmbUrusan = $CurrentUrusan;
				
			}elseif($CurrentP !='' ){
			 	$_REQUEST['hiddenP'] = $CurrentP;
				$_REQUEST['bk'] = $CurrentBK;
				$_REQUEST['ck'] = $CurrentCK;
			 	$cmbSubUnit = $CurrentSubUnit;
			 	$cmbUnit = $CurrentUnit;
				$cmbSKPD = $CurrentSKPD;
				$cmbBidang = $CurrentBidang;
				$cmbUrusan = $CurrentUrusan;
				
			}elseif($CurrentSubUnit !='000' ){
			 	$cmbSubUnit = $CurrentSubUnit;
			 	$cmbUnit = $CurrentUnit;
				$cmbSKPD = $CurrentSKPD;
				$cmbBidang = $CurrentBidang;
				$cmbUrusan = $CurrentUrusan;
				
			}elseif($CurrentUnit !='00' ){
			 	$cmbUnit = $CurrentUnit;
				$cmbSKPD = $CurrentSKPD;
				$cmbBidang = $CurrentBidang;
				$cmbUrusan = $CurrentUrusan;
				
			}elseif($CurrentSKPD !='00' ){
				$cmbSKPD = $CurrentSKPD;
				$cmbBidang = $CurrentBidang;
				$cmbUrusan = $CurrentUrusan;
				
			}elseif($CurrentBidang !='00'){
				$cmbBidang = $CurrentBidang;
				$cmbUrusan = $CurrentUrusan;
	
			}elseif($CurrentUrusan !='0'){
				$cmbUrusan = $CurrentUrusan;
			}
	   }
	   
	   if(isset($cmbUrusan) && $cmbUrusan== ''){
	   		$cmbBidang = "";
			$cmbSKPD = "";
			$hiddenP = "";
			$cmbUnit = "";
			$cmbSubUnit = "";
	   }elseif(isset($cmbBidang) && $cmbBidang== ''){
			$cmbSKPD = "";
			$hiddenP = "";
			$cmbUnit = "";
			$cmbSubUnit = "";
	   }elseif(isset($cmbSKPD) && $cmbSKPD== ''){
			$hiddenP = "";
			$cmbUnit = "";
			$cmbSubUnit = "";
			if(isset($hiddenP) && $hiddenP == ''){
			   		$q = "";
			 }
	   }elseif(isset($cmbUnit) && $cmbUnit== ''){
			$cmbSubUnit = "";
	   }
	   
	   
		
	
		 if($cmbSKPD != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$arrKondisi[] = "d = '$cmbSKPD'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
				if(!empty($hiddenP)){
					$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and bk='$bk' and ck='$ck' and p='$hiddenP' $kondisiRekening";
					if(!empty($cmbUnit)){
						$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit'  and bk='$bk' and ck='$ck' and p='$hiddenP' $kondisiRekening";
						if(!empty($cmbSubUnit)){
							$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and p='$hiddenP' $kondisiRekening";
						
						
						}
					}
					$arrKondisi[] = "ck = '$ck' ";
					$arrKondisi[] = "bk = '$bk' ";
					$arrKondisi[] = " p = '$hiddenP'  ";
		if(!empty($q)){
					$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and bk='$bk' and ck='$ck' and p='$hiddenP' and q='$q' $kondisiRekening";	
					if(!empty($cmbUnit)){
						$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit'  and bk='$bk' and ck='$ck' and p='$hiddenP' and q='$q' $kondisiRekening";
						if(!empty($cmbSubUnit)){
							$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and bk='$bk' and ck='$ck' and p='$hiddenP' and q='$q' $kondisiRekening";
						}
					}
					$arrKondisi[] = "q = '$q' ";
				}
		}
			}elseif($cmbBidang != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
			}elseif($cmbUrusan != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$kondisiSKPD = "and c1='$cmbUrusan'";
			}
			
			

		
		
		
		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "anggaran = '$this->jenisAnggaran' ";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi ;
		/*$Kondisi = $Kondisi." group by ";*/
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();

		$Order= join(',',$arrOrders);	
		$OrderDefault = '';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal );
		
	}
	
	function Hapus($ids){ //validasi hapus ref_kota
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++)	{
		
		
			$qy = "DELETE FROM $this->TblName_Hapus WHERE id_anggaran='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);				
				
		}
		return array('err'=>$err,'cek'=>$cek);
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
		
		if($this->jenisForm =="PENYUSUNAN" || $this->jenisForm =="VALIDASI" || $this->jenisFormTerakhir == "PENYUSUNAN" || $this->jenisFormTerakhir == "VALIDASI" ){
			$tergantung = "100";
		}else{
			$tergantung = "100";
		}
		return
				
		"<html>".
			$this->genHTMLHead().
			"<body >".
							
			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0'  height='100%' >".	
				"<tr height='34'><td>".						
					$this->setPage_Header().
					"<div id='header' ></div>".
				"</td></tr>".	
				$navatas.			
				"<tr height='*' valign='top'> <td >".
					
					$this->setPage_HeaderOther().
					"<div align='center' class='centermain' >".
					"<div class='main' >".
					$form1.				
						$this->setPage_Content().
						
					$form2.
					"</div></div>".
				"</td></tr>".
				"<tr><td height='29' >".	
					$Main->CopyRight.							
				"</td></tr>".
				$OtherFooterPage.
			"</table>".
			"</body>
		</html>
		<style>
			#kerangkaHal {
						width:$tergantung%;
			}
			
		</style>
		"; 
	}		

function Laporan($xls =FALSE){
		global $Main;
		
	
		
		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		
		
		
		$arrKondisi = array();

		

		
	 $getIdTahapTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) from tabel_anggaran where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and nama_modul = 'RKA-SKPD' and id_tahap < $this->idTahap"));
			$idTahapTerakhir = $getIdTahapTerakhir['max(id_tahap)'];
		    $kondisiFilter = " and id_tahap = '$idTahapTerakhir' ";
			if($this->jenisFormTerakhir == "PENYUSUNAN" && $this->wajibValidasi == TRUE ){
				$kondisiFilter = $kondisiFilter." and status_validasi ='1' ";
			}

					
  		
		
		
	
		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
		
		$Kondisi= join(' and ',$arrKondisi);
		$qry ="select * from tabel_spd where $Kondisi  ";
		$aqry = mysql_query($qry);
		
		//
				
		//MULAI Halaman Laporan ------------------------------------------------------------------------------------------ 
		$css = $xls	? "<style>.nfmt5 {mso-number-format:'\@';}</style>":"<link rel=\"stylesheet\" href=\"css/template_css.css\" type=\"text/css\" />";
		echo 
			"<html>".
				"<head>
					<title>$Main->Judul</title>
					$css					
					$this->Cetak_OtherHTMLHead
					<style>
						.ukurantulisan{
							font-size:17px;
						}
						.ukurantulisan1{
							font-size:20px;
						}
						.ukurantulisanIdPenerimaan{
							font-size:16px;
						}
					</style>
				</head>".
			"<body >
				<div style='width:$this->Cetak_WIDTH_Landscape;'>
					<table class=\"rangkacetak\" style='width:33cm;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
				<span style='font-size:18px;font-weight:bold;text-decoration: '>
					PROVINSI/KABUPATEN/KOTA ".strtoupper($this->kota)."<br>
					REKAPITULASI BELANJA MENURUT URUSAN PEMERINTAHAN DAERAH, ORGANISASI, PROGRAM, DAN KEGIATAN	
				</span><br>
				<span style='font-size:14px;font-weight:text-decoration: '>
					Tahun Anggaran $this->tahun 
				</span><br>
				
				
				<br>
				
				
				";
		echo "
				<span style='font-size:16px;font-weight:bold;text-decoration: '>
					Ringkasan Anggaran Pendapatan, Belanja dan Pembiayaan Satuan Kerja Perangkat Daerah
				</span><br>
								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
									   <th class='th01' width='100'  rowspan='2'  >KODE</th>
									   <th class='th01' width='500'  rowspan='2' >URAIAN</th>
									   <th class='th02' colspan='3'  rowspan='1' width='500' >JUMLAH BELANJA</th>
									   <th class='th01' rowspan='2'>JUMLAH</th>
									 </tr>
							
									 <tr>
									   <th class='th01' rowspan='1'>BELANJA PEGAWAI</th>
									   <th class='th01' rowspan='1'>BELANJA BARANG & JASA</th>
									   <th class='th01' rowspan='1'>BELANJA MODAL</th>
							
									 </tr>
								
								
									
		";
		
		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) { 
				  $$key = $value; 
			} 
			echo "<tr valign='top'>";
			 
	 		 if($q !='0'){
				echo "<td align='left' class='GarisCetak' >".$c1.'.'.$c.'.'.$d.'.'.genNumber($bk).'.'.genNumber($ck).'.'.genNumber($p).'.'.genNumber($q)."</td>";
				$getNamaKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck='$ck' and dk='0' and p='$p' and q='$q'"));
				$namaKegiatan =  $getNamaKegiatan['nama'];
				echo "<td align='left' class='GarisCetak' >"."<span style='margin-left:20px;'>".$namaKegiatan."</span>" ."</td>";
				$getBelanjaPegawai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaPegawai from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1' and c='$c' and d='$d' $kondisiFilter and bk='$bk' and ck='$ck' and p='$p'  and k='5' and l='2' and m='1' "));
			   	$getBelanjaBarangJasa = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaBarangJasa from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1' and c='$c' and d='$d' $kondisiFilter and bk='$bk' and ck='$ck' and p='$p'  and k='5' and l='2' and m='2' "));
			 	$getBelanjaModal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaModal from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1' and c='$c' and d='$d' $kondisiFilter and bk='$bk' and ck='$ck' and p='$p'  and k='5' and l='2' and m='3' "));
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaPegawai['belanjaPegawai'] ,2,',','.') ."</span>"."</td>";
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaBarangJasa['belanjaBarangJasa'] ,2,',','.')."</span>"."</td>";
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaModal['belanjaModal'] ,2,',','.')."</span>"."</td>";	
				$jumlahRekening = $getBelanjaPegawai['belanjaPegawai'] + $getBelanjaBarangJasa['belanjaBarangJasa'] + $getBelanjaModal['belanjaModal'];
				echo "<td align='right' class='GarisCetak' >"."<span style='font-weight:bold;'>" . number_format($jumlahRekening ,2,',','.')."</span>"."</td>";	
			 }elseif($q == '0' && $p !='0'){
			 	echo "<td align='left' class='GarisCetak' >".$c1.'.'.$c.'.'.$d.'.'.genNumber($bk).'.'.genNumber($ck).'.'.genNumber($p)."</td>";
				$getNamaProgram = mysql_fetch_array(mysql_query("select * from ref_program where bk='$bk' and ck='$ck' and dk='0' and p='$p' and q='0'"));
				$namaProgram =  $getNamaProgram['nama'];
				echo "<td align='left' class='GarisCetak' >"."<span style='font-weight:bold;margin-left:15px;'>".$namaProgram."</span>"."</td>";
				$getBelanjaPegawai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaPegawai from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1' and c='$c' and d='$d' $kondisiFilter and bk='$bk' and ck='$ck' and p='$p'  and k='5' and l='2' and m='1' "));
			   	$getBelanjaBarangJasa = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaBarangJasa from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1' and c='$c' and d='$d' $kondisiFilter and bk='$bk' and ck='$ck' and p='$p'  and k='5' and l='2' and m='2' "));
			 	$getBelanjaModal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaModal from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1' and c='$c' and d='$d' $kondisiFilter and bk='$bk' and ck='$ck' and p='$p' and k='5' and l='2' and m='3' "));
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaPegawai['belanjaPegawai'] ,2,',','.') ."</span>"."</td>";
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaBarangJasa['belanjaBarangJasa'] ,2,',','.')."</span>"."</td>";
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaModal['belanjaModal'] ,2,',','.')."</span>"." </td>";	
				$jumlahRekening = $getBelanjaPegawai['belanjaPegawai'] + $getBelanjaBarangJasa['belanjaBarangJasa'] + $getBelanjaModal['belanjaModal'];
				echo "<td align='right' class='GarisCetak' >"."<span style='font-weight:bold;'>" . number_format($jumlahRekening ,2,',','.')."</span>"."</td>";	
			 }elseif($p == '0' && $d !='00'){
			 	echo "<td align='left' class='GarisCetak' >".$c1.'.'.$c.'.'.$d."</td>";	
				$getSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1= '$c1' and c='$c' and d='$d' and e='00' and e1='000'"));
				echo "<td align='left' class='GarisCetak' >"."<span style='font-weight:bold;margin-left:10px;'>".$getSKPD['nm_skpd']."</span>"."</td>";	
				$getBelanjaPegawai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaPegawai from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1' and c='$c' and d='$d' $kondisiFilter   and k='5' and l='2' and m='1' "));
			   	$getBelanjaBarangJasa = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaBarangJasa from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1' and c='$c' and d='$d' $kondisiFilter   and k='5' and l='2' and m='2' "));
			 	$getBelanjaModal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaModal from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1' and c='$c' and d='$d' $kondisiFilter  and k='5' and l='2' and m='3' "));
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaPegawai['belanjaPegawai'] ,2,',','.') ."</span>"."</td>";
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaBarangJasa['belanjaBarangJasa'] ,2,',','.')."</span>"."</td>";
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaModal['belanjaModal'] ,2,',','.')."</span>"."</td>";	
				$jumlahRekening = $getBelanjaPegawai['belanjaPegawai'] + $getBelanjaBarangJasa['belanjaBarangJasa'] + $getBelanjaModal['belanjaModal'];
				echo "<td align='right' class='GarisCetak' >"."<span style='font-weight:bold;'>" . number_format($jumlahRekening ,2,',','.')."</span>"."</td>";	
			 }elseif($d == '00' && $c !='00'){
			 	echo "<td align='left' class='GarisCetak' >".$c1.'.'.$c."</td>";	
				$getSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1= '$c1' and c='$c' and d='00' and e='00' and e1='000'"));
				echo "<td align='left' class='GarisCetak' >"."<span style='font-weight:bold;margin-left:5px;'>".$getSKPD['nm_skpd']."</span>"."</td>";
				$getBelanjaPegawai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaPegawai from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1' and c='$c'  $kondisiFilter   and k='5' and l='2' and m='1' "));
			   	$getBelanjaBarangJasa = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaBarangJasa from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1' and c='$c'  $kondisiFilter   and k='5' and l='2' and m='2' "));
			 	$getBelanjaModal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaModal from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1' and c='$c'  $kondisiFilter  and k='5' and l='2' and m='3' "));
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaPegawai['belanjaPegawai'] ,2,',','.') ."</span>"."</td>";
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaBarangJasa['belanjaBarangJasa'] ,2,',','.')."</span>"."</td>";
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaModal['belanjaModal'] ,2,',','.')."</span>"."</td>";	
				$jumlahRekening = $getBelanjaPegawai['belanjaPegawai'] + $getBelanjaBarangJasa['belanjaBarangJasa'] + $getBelanjaModal['belanjaModal'];
				echo "<td align='right' class='GarisCetak' >"."<span style='font-weight:bold;'>" . number_format($jumlahRekening ,2,',','.')."</span>"."</td>";	
			 }else{
			 	echo "<td align='left' class='GarisCetak' >".$c1."</td>";		
				$getSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1= '$c1' and c='00' and d='00' and e='00' and e1='000'"));
				echo "<td align='left' class='GarisCetak' >". "<span style='font-weight:bold;'>".$getSKPD['nm_skpd']."</span>"."</td>";	
				$getBelanjaPegawai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaPegawai from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1'  $kondisiFilter   and k='5' and l='2' and m='1' "));
			   	$getBelanjaBarangJasa = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaBarangJasa from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1'   $kondisiFilter   and k='5' and l='2' and m='2' "));
			 	$getBelanjaModal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as belanjaModal from tabel_anggaran where nama_modul = 'RKA-SKPD' and c1='$c1'   $kondisiFilter  and k='5' and l='2' and m='3' "));
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaPegawai['belanjaPegawai'] ,2,',','.') ."</span>"."</td>";
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaBarangJasa['belanjaBarangJasa'] ,2,',','.')."</span>"."</td>";
				echo "<td align='right' class='GarisCetak' >"."<span style=''>" .number_format($getBelanjaModal['belanjaModal'] ,2,',','.')."</span>"."</td>";	
				$jumlahRekening = $getBelanjaPegawai['belanjaPegawai'] + $getBelanjaBarangJasa['belanjaBarangJasa'] + $getBelanjaModal['belanjaModal'];
				echo "<td align='right' class='GarisCetak' >"."<span style='font-weight:bold;'>" . number_format($jumlahRekening ,2,',','.')."</span>"."</td>";	
			 }
	 

									
									
										
				
			$no++;
			
			
		echo "</tr>";	
			
		}
		$getData = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f ='00' ) $kondisiFilter and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka = '2.2.1' $kondisiSKPD $kondisiRekening"));
		$Total = $getData['sum(jumlah_harga)'];
		$getTotalPegawai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f ='00' ) $kondisiFilter and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka = '2.2.1' and k = '5' and l ='2' and m='1' $kondisiSKPD $kondisiRekening"));
		$TotalBelanjaPegawai = $getTotalPegawai['sum(jumlah_harga)'];
		$getTotalBarangJasa = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f ='00' ) $kondisiFilter and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka = '2.2.1' and k = '5' and l ='2' and m='2' $kondisiSKPD $kondisiRekening"));
		$TotalBelanjaBarangJasa = $getTotalBarangJasa['sum(jumlah_harga)'];
		$getTotalModal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where  (rincian_perhitungan !='' or f ='00' ) $kondisiFilter and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and jenis_rka = '2.2.1' and k = '5' and l ='2' and m='3' $kondisiSKPD $kondisiRekening"));
		$TotalBelanjaModal = $getTotalModal['sum(jumlah_harga)'];
		echo 				"<tr valign='top'>
									<td align='right' colspan='2' class='GarisCetak'>Jumlah</td>
									<td class='GarisCetak' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($TotalBelanjaPegawai,2,',','.')."</div></td>
					<td class='GarisCetak' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($TotalBelanjaBarangJasa,2,',','.')."</div></td>
					<td class='GarisCetak' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($TotalBelanjaModal,2,',','.')."</div></td>
					<td class='GarisCetak' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($Total,2,',','.')."</div></td>
									
								</tr>
								
							 </table> 

		";
		echo 			
						"<br><div class='ukurantulisan' style ='float:right;'>
						$this->kota, ".VulnWalkerTitiMangsa(date('Y-m-d'))."<br>
						Gubernur/Bupati/Walikota
						<br>
						<br>
						<br>
						<br>
						<br>
						
						<u>"."Nama Bupati"."</u><br>
					
						
						</div>	
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
						<div class='ukurantulisan' style ='float:right;'>
						MENTERI DALAM NEGRI
						
						<br>
						<br>
						<br>
						<br>
						<br>
						
						<u>"."NAMA MENTERI"."</u><br>
					
						
						</div>	
			</body>	
		</html>";
	}
	
	function inputSPD($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';	
	 foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 			
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'INPUT NOMOR SPD';
	 $getCurrent = mysql_fetch_array(mysql_query("select * from current_filter where username = '$this->username'"));
	 $kondisiSKPD = "and c1=".$getCurrent['CurrentUrusan']." and c=".$getCurrent['CurrentBidang']." and d=".$getCurrent['CurrentSKPD']."";
	 $codeAndNamePekerjaan = "select id, nomor_spd from nomor_spd where 1=1 $kondisiSKPD ";
	 $cmbNomorSPD = cmbQuery('cmbNomorSPD', '', $codeAndNamePekerjaan,"  ",'-- NOMOR SPD --');
		
	 //items ----------------------
	  $this->form_fields = array(
	  		'pekerjaan' => array( 
						'label'=>'NOMOR SPD',
						'labelWidth'=>100, 
						'value'=>$cmbNomorSPD." &nbsp <button type='button' onclick=$this->Prefix.newNomorSPD(); >Tambah</button>  &nbsp <button type='button' onclick=$this->Prefix.editNomorSPD(); >Edit</button>
								<input type='hidden' name='anggota' id='anggota' value='$dt'>
								",
						 ),
			/*'asd' => array( 
						'label'=>'NOMOR SPD',
						'labelWidth'=>100, 
						'value'=>" <input type='text' name='nomorSPD' id='nomorSPD'>
								<input type='hidden' name='anggota' id='anggota' value='$dt'>
								",
						 ),
			'sad' => array( 
						'label'=>'TANGGAL SPD',
						'labelWidth'=>100, 
						'value'=>" <input type='text' name='tanggalSPD' id='tanggalSPD' value='".date('d-m-Y')."' style='width:80px;'>
								",
						 ),*/
			
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".setSPD()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function genForm2($withForm=TRUE){	
		$form_name = 'listRekeningForm';	
				
		if($withForm){
			$params->tipe=1;
			$form= "<form name='$form_name' id='$form_name' method='post' action=''>".
				createDialog(
					$form_name.'_div', 
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height,
					'',$params
					).
				"</form>";
				
		}else{
			$form= 
				createDialog(
					$form_name.'_div', 
					$this->setForm_content(),
					$this->form_width,
					$this->form_height,
					$this->form_caption,
					'',
					$this->form_menubawah.
					"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height
				);
			
			
		}
		return $form;
	}
	
	function showListRekening(){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'NOMOR SPD BARU';
	 
	 	
	 //items ----------------------
	  $this->form_fields = array(
			'asdas' => array( 
						'label'=>'',
						'value'=>"
						
						<div id='listRekening' style='height:5px'>
							"."<div id='listBarangMax_cont_title' style='position:relative'></div>".
			"<div id='listRekening_cont_opsi' style='position:relative'>".
			"</div>".
			"<div id='listRekening_cont_daftar' style='position:relative'></div>".
			"<div id='listRekening_cont_hal' style='position:relative'></div>"."
						</div>", 
							
						'type'=>'merge'
					 ),				
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveNomorSPD();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genForm2();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function editNomorSPD($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'EDIT NOMOR SPD';
	 
	 $get = mysql_fetch_array(mysql_query("select * from nomor_spd where id='$dt'"));
	 foreach ($get as $key => $value) { 
		  	$$key = $value; 
		 } 	
	  $tanggal_spd = explode("-",$tanggal_spd);
	  $tanggal_spd = $tanggal_spd[2]."-".$tanggal_spd[1]."-".$tanggal_spd[0];	 
	 //items ----------------------
	  $this->form_fields = array(
			'namaPekerjaan' => array( 
						'label'=>'NOMOR SPD '.$dt,
						'labelWidth'=>130, 
						'value'=>"<input type='text' name='noSPD' id='noSPD' style='width:210px;' value='$nomor_spd'>",
						 ),	
			'tangalSPD' => array( 
						'label'=>'TANGGAL SPD',
						'labelWidth'=>130, 
						'value'=>"<input type='text' name='tanggalSPD' id='tanggalSPD' style='width:100px;' value='$tanggal_spd'>",
						 ),					
			
			);				
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveEditNomorSPD();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}	
	
}
$pembuatanSPD = new pembuatanSPDObj();

$arrayResult = VulnWalkerTahap_v2($pembuatanSPD->modul);
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$pembuatanSPD->jenisForm = $jenisForm;
$pembuatanSPD->nomorUrut = $nomorUrut;
$pembuatanSPD->tahun = $tahun;
$pembuatanSPD->jenisAnggaran = $jenisAnggaran;
$pembuatanSPD->idTahap = $idTahap;
$pembuatanSPD->username = $_COOKIE['coID'];

$pembuatanSPD->wajibValidasi = $Main->wajibValidasi;
if($Main->wajibValidasi == TRUE){
	$pembuatanSPD->sqlValidasi = " and status_validasi ='1' ";
}else{
	$pembuatanSPD->sqlValidasi = " ";
}

if(empty($pembuatanSPD->tahun)){
    
	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from tabel_spd "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from tabel_spd where id_anggaran = '$maxAnggaran'"));
	/*$pembuatanSPD->tahun = "select max(id_anggaran) as max from tabel_spd where nama_modul = 'pembuatanSPD'";*/
	$pembuatanSPD->tahun  = $get2['tahun'];
	$pembuatanSPD->jenisAnggaran = $get2['jenis_anggaran'];
	$pembuatanSPD->urutTerakhir = $get2['no_urut'];
	$pembuatanSPD->jenisFormTerakhir = $get2['jenis_form_modul'];
	$pembuatanSPD->urutSebelumnya = $pembuatanSPD->urutTerakhir - 1;
	
	
	$idtahapTerakhir = $get2['id_tahap'];
	$pembuatanSPD->idTahap = $idtahapTerakhir;
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$pembuatanSPD->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$pembuatanSPD->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
	
	$arrayHasil =  VulnWalkerLASTTahap_v2();
	$pembuatanSPD->currentTahap = $arrayHasil['currentTahap'];
}else{
	$getCurrenttahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$pembuatanSPD->idTahap'"));
	$pembuatanSPD->currentTahap = $getCurrenttahap['nama_tahap'];
	
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$pembuatanSPD->idTahap'"));
	$pembuatanSPD->jenisFormTerakhir =  $namaTahap['jenis_form_modul'];
	$pembuatanSPD->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$pembuatanSPD->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
}


$setting = settinganPerencanaan_v2();
$pembuatanSPD->provinsi = $setting['provinsi'];
$pembuatanSPD->kota = $setting['kota'];
$pembuatanSPD->pengelolaBarang = $setting['pengelolaBarang'];
$pembuatanSPD->pejabatPengelolaBarang = $setting['pejabat'];
$pembuatanSPD->pengurusPengelolaBarang = $setting['pengurus'];
$pembuatanSPD->nipPengelola = $setting['nipPengelola'];
$pembuatanSPD->nipPengurus = $setting['nipPengurus'];
$pembuatanSPD->nipPejabat = $setting['nipPejabat'];

?>