<?php

class rkaPPKD31Obj  extends DaftarObj2{	
	var $Prefix = 'rkaPPKD31';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_rka_ppkd_3_1'; //bonus
	var $TblName_Hapus = 'tabel_anggaran';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id_anggaran');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'RKA-PPKD';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='rkaPPKD31.xls';
	var $namaModulCetak='RKA';
	var $Cetak_Judul = 'RKA';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'rkaPPKD31Form';
	var $modul = "RKA-PPKD";
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
	
	//buatview
	var $TampilFilterColapse = 0; //0
	
	function setTitle(){
		return 'RKA-PPKD 3.1 '.$this->jenisAnggaran.' TAHUN '.$this->tahun;
	}
	function setMenuView(){
		return 			
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";				
			
	}
	function setMenuEdit(){
	 	 $arrayResult = VulnWalkerTahap("RKA-PPKD");
		 $jenisForm = $arrayResult['jenisForm'];
		 $nomorUrut = $arrayResult['nomorUrut'];
		 $tahun = $arrayResult['tahun'];
		 $jenisAnggaran = $arrayResult['jenisAnggaran'];
		 $query = $arrayResult['query'];
	 if ($jenisForm == "PENYUSUNAN"){
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru ", 'Baru ')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Remove()","delete_f2.png","Hapus", 'Hapus')."</td>".
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>"
					;	
	 }elseif ($jenisForm == "VALIDASI"){
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Validasi()","validasi-menu.png","Validasi", 'Validasi')."</td>
					<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";	
	 }elseif ($jenisForm == "KOREKSI"){
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
	 }else{
	 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
	 }
	 
		return $listMenu ;
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
	 	/*if(!empty($cmbBelanja)){
				if($cmbBelanja == "BELANJA PEGAWAI"){
					$kondisiRekening = "and k='5' and l ='2' and m ='1'";
				}elseif($cmbBelanja == "BELANJA BELANJA BARANG & JASA"){
					$kondisiRekening = "and k='5' and l ='2' and m ='2'";
				}elseif($cmbBelanja == "BELANJA MODAL"){
					$kondisiRekening = "and k='5' and l ='2' and m ='3'";
				}
				
		}*/
		if(!empty($this->jenisForm)){
			$idTahap = $this->idTahap;
		}else{
			$getIdTahapRKATerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from tabel_anggaran where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and jenis_rka !='' and o1 !='0' and (rincian_perhitungan !='' or f1 !='0' ) "));
		 	$idTahap = $getIdTahapRKATerakhir['max'];
		}

		
		$getData = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from tabel_anggaran where o1 !='0' and (rincian_perhitungan !='' or f1 !='0' ) and id_tahap='$idTahap' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and nama_modul ='RKA-PPKD' and jenis_rka = '3.1' $kondisiSKPD $kondisiRekening"));
		$Total = $getData['sum(jumlah_harga)'];
		
		$ContentTotalHal=''; $ContentTotal='';
			$TampilTotalHalRp = number_format($this->SumValue[0],2, ',', '.');
			$TotalColSpan1 = $this->FieldSum_Cp1[$Mode-1];//$Mode ==1 ? 5 : 4;
			$TotalColSpan2 = $this->FieldSum_Cp2[$Mode-1];//$Mode ==1 ? 5 : 4;	
			if($this->jenisForm == "PENYUSUNAN"){
				$ContentTotal = 
				"<tr>
					<td class='$ColStyle' colspan='7' align='center'><b>Total</td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($Total,2,',','.')."</div></td>
				</tr>" ;
			}elseif($this->jenisForm == "VALIDASI"){
				$ContentTotal = 
				"<tr>
					<td class='$ColStyle' colspan='7' align='center'><b>Total</td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($Total,2,',','.')."</div></td>
					<td class='GarisDaftar'  align='center'></td>
				</tr>" ;
			}elseif($this->jenisForm == "KOREKSI"){
				$uruSebelumnya = $this->nomorUrut - 1;
				$getDataSebelumnya = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_ppkd_3_1 where o1 !='0' and (rincian_perhitungan !='' or f1 !='0' ) and no_urut='$uruSebelumnya' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  $kondisiSKPD $kondisiRekening"));
		    	$TotalTahapSebelumnya = $getDataSebelumnya['sum(jumlah_harga)']; 
				$TotalBertambahBerkurang = $TotalTahapSebelumnya - $Total;
				if($TotalBertambahBerkurang   > 0){
					
					$TotalBertambahBerkurang= "( ". number_format($TotalBertambahBerkurang,2,',','.') ." )";
				}else{
					$TotalBertambahBerkurang = $Total  -  $TotalTahapSebelumnya;
					$TotalBertambahBerkurang = number_format($TotalBertambahBerkurang,2,',','.');
				}
				$ContentTotal = 
				"<tr>
					<td class='$ColStyle' colspan='6' align='center'><b>Total</td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($TotalTahapSebelumnya,2,',','.')."</div></td>
					<td class='GarisDaftar'  align='center' colspan='2'></td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($Total,2,',','.')."</div></td>
					<td class='GarisDaftar'  align='center' colspan='2'></td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".$TotalBertambahBerkurang."</div></td>
					<td class='GarisDaftar'  align='center'></td>
				</tr>" ;
			}else{
				if($this->jenisFormTerakhir == "PENYUSUNAN"){
					$ContentTotal = 
					"<tr>
						<td class='$ColStyle' colspan='6' align='center'><b>Total</td>
						<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($Total,2,',','.')."</div></td>
					</tr>" ;
				}elseif($this->jenisFormTerakhir == "VALIDASI"){
				$ContentTotal = 
				"<tr>
					<td class='$ColStyle' colspan='6' align='center'><b>Total</td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($Total,2,',','.')."</div></td>
					<td class='GarisDaftar' colspan='6' align='center'></td>
				</tr>" ;
			}elseif($this->jenisFormTerakhir == "KOREKSI"){
				$uruSebelumnya = $this->urutTerakhir - 1;
				$getDataSebelumnya = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_ppkd_3_1 where o1 !='0' and (rincian_perhitungan !='' or f1 !='0' ) and no_urut='$uruSebelumnya' and tahun ='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'  $kondisiSKPD $kondisiRekening"));
		    	$TotalTahapSebelumnya = $getDataSebelumnya['sum(jumlah_harga)']; 
				$TotalBertambahBerkurang = $TotalTahapSebelumnya - $Total;
				if($TotalBertambahBerkurang   > 0){
					
					$TotalBertambahBerkurang= "( ". number_format($TotalBertambahBerkurang,2,',','.') ." )";
				}else{
					$TotalBertambahBerkurang = $Total  -  $TotalTahapSebelumnya;
					$TotalBertambahBerkurang = number_format($TotalBertambahBerkurang,2,',','.');
				}
				$ContentTotal = 
				"<tr>
					<td class='$ColStyle' colspan='6' align='center'><b>Total</td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($TotalTahapSebelumnya,2,',','.')."</div></td>
					<td class='GarisDaftar'  align='center' colspan='2'></td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".number_format($Total,2,',','.')."</div></td>
					<td class='GarisDaftar'  align='center' colspan='2'></td>
					<td class='GarisDaftar' align='right'><b><div  id='{$this->Prefix}_cont_sum'>".$TotalBertambahBerkurang."</div></td>
					<td class='GarisDaftar'  align='center'></td>
				</tr>" ;
			}
				
			}	

			

				
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
	
	$getJumlahBarang = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$rkaPPKD31_idplh'"));
	$jumlahBarang = $getJumlahBarang['volume_barang'];
	$total = $hargaSatuan * $jumlahBarang;
	
	/* $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja "));
  	 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
	$getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));*/
	$getPaguYangTelahTerpakai = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai from view_rka_ppkd_3_1 where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and no_urut = '$this->nomorUrut' and id_anggaran!='$rkaPPKD31_idplh' "));
	$sisaPaguIndikatif = $paguIndikatif - $getPaguYangTelahTerpakai['paguYangTerpakai'];
    
	 if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where c1='0' and f1 = '0' and k = '$k' and l ='$l' and m='$m' and n='$n' and o='$o'  and id_tahap='$this->idTahap' ")) > 0){
				 	
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
											'nama_modul' => 'RKA-PPKD'
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
						'jenis_rka' => '3.1',
						'jumlah_harga' => $total
							
					   );
		$query = VulnWalkerUpdate('tabel_anggaran',$data,"id_anggaran = '$rkaPPKD31_idplh'");
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
		case 'Report':{	
			foreach ($_REQUEST as $key => $value) { 
			 	 $$key = $value; 
			}
			
				if(mysql_num_rows(mysql_query("select * from skpd_report_rka_ppkd_31 where username= '$this->username'")) == 0){
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD
								  
								  );
					$query = VulnWalkerInsert('skpd_report_rka_ppkd_31',$data);
					mysql_query($query);
				}else{
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD
								  
								  
								  );
					$query = VulnWalkerUpdate('skpd_report_rka_ppkd_31',$data,"username = '$this->username'");
					mysql_query($query);
				}
				
														
		break;
		}
		case 'Laporan':{	
			$json = FALSE;
			$this->Laporan();										
		break;
		}	
		case 'formBaru':{		
			foreach ($_REQUEST as $key => $value) { 
			 	 $$key = $value; 
			}
			
			if(empty($cmbUrusan)){
				$err = "Pilih Urusan";
			}elseif(empty($cmbBidang)){
				$err = "Pilih Bidang";
			}elseif(empty($cmbSKPD)){
				$err = "Pilih SKPD";
			}elseif(empty($cmbUnit)){
				$err = "Pilih Unit";
			}elseif(empty($cmbBidang)){
				$err = "Pilih Bidang";
			}elseif(empty($q)){
				$err = "Pilih Kegiatan";
			}elseif(empty($cmbJenisRKA)){
				$err = "Pilih Jenis RKA";
			}else{
				$fm = $this->setFormBaru();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
			}
			
														
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
				mysql_query("delete from temp_rka_ppkd_31 where user ='$username'");	
				foreach ($_REQUEST as $key => $value) { 
			 	 $$key = $value; 
				}
				$getIDTahapRenja = mysql_fetch_array(mysql_query("select max(id_tahap) as idTahapRenja from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' ")); 
				$idTahapRenja = $getIDTahapRenja['idTahapRenja'];
				$getDetailAboutRenja = mysql_fetch_array(mysql_query("select * from view_renja where id_tahap ='$idTahapRenja' and tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));						
				$jenisFormModulRenja = $getDetailAboutRenja['jenis_form_modul'];
				
				$cekRelationRenjaWithSKPD = mysql_num_rows(mysql_query("select *  from view_renja where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and q !='0' and  id_tahap ='$idTahapRenja' and tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				if($jenisFormModulRenja == "VALIDASI"){
				$cekRelationRenjaWithSKPD = mysql_num_rows(mysql_query("select *  from view_renja where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and q !='0' and status_validasi = '1' and id_tahap ='$idTahapRenja' and tahun = '$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				}
				/*if($cekRelationRenjaWithSKPD == 0){
					$err = "SKPD tidak memiliki pagu indikatif";
				}*/
				
				
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
		
		case 'sesuai':{
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 
			$queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
			$getrkaPPKD31nya = mysql_fetch_array(mysql_query($queryRows));
			foreach ($getrkaPPKD31nya as $key => $value) { 
				  $$key = $value; 
			} 
			$cmbUrusanForm = $c1;
			$cmbBidangForm = $c;
			
			$cekUrusan =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='00' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'"));
					if($cekUrusan > 0 ){
						
					}else{
						$data = array(
									    'c1' => $cmbUrusanForm,
										'c' => '00',
										'd' => '00',
										'e' => '00',
										'e1' => '000',
										'bk' => '0',
										'ck' => '0',
										'p' => '0',
										'q' => '0',
										'id_tahap' => $this->idTahap,
										'jenis_anggaran' => $this->jenisAnggaran,
										'tahun' => $this->tahun,
										"nama_modul" => $this->modul
										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= "mampir";
						mysql_query($query)	;				
					}
					
					$cekBidang =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0' and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					if($cekBidang > 0 ){
						
					}else{
						$data = array(
									    'c1' => $cmbUrusanForm,
										'c'  => $cmbBidangForm,
										'd'  => '00',
										'e'  => '00',
										'e1' => '000',
										'bk' => '0',
										'ck' => '0',
										'p' => '0',
										'q' => '0',
										'id_tahap' => $this->idTahap,
										'jenis_anggaran' => $this->jenisAnggaran,
										'tahun' => $this->tahun,
										"nama_modul" => $this->modul
										
										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= $query;
						mysql_query($query)	;				
					}
			
			
			$dataSesuai = array("tahun" => $tahun,
								"c1" => $c1,
								"c" => $c,
								"d" => $d,
								"e" => $e,
								"e1" => $e1,
								"p" => '0',
								"q" => '0',
								"bk" => '0',
								"ck" => '0',
								'jumlah' => $jumlah,
								'id_tahap' => $this->idTahap,
								'jenis_anggaran' => $this->jenisAnggaran,
								'tahun' => $this->tahun,
								"nama_modul" => $this->modul
										
 								);			
			$cekSKPD =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0' and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					if($cekSKPD > 0 ){
						$getID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='00' and e1='000' and bk='0' and ck='0' and p = '0' and q='0' and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					    $idnya = $getID['id_anggaran'];
						mysql_query("update tabel_anggaran set jumlah = '$jumlah' where id_anggaran='$idnya'");
					}else{
						mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));	
						$content .=VulnWalkerInsert("tabel_anggaran", $dataSesuai);	
					}
			
			
			/*$content = array("query" => $query, "sesuai" => number_format($jumlah,2,',','.'), "QUERY ROWS" => $queryData);*/
			 
		break;
	    }
		
		case 'koreksi':{
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 
			$queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
			$getrkaPPKD31nya = mysql_fetch_array(mysql_query($queryRows));
			foreach ($getrkaPPKD31nya as $key => $value) { 
				  $$key = $value; 
			} 
			 
			 $hasilKali = $koreksiSatuanHarga * $koreksiVolumebarang ;
			 
			 $getNomorUrutRenja = mysql_fetch_array(mysql_query("select max(no_urut) as nomor_urut from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' ")) ;
			 $nomorUrutRenja = $getNomorUrutRenja['nomor_urut'];
			 $getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$nomorUrutRenja'"));
			 $paguIndikatif = $getPaguIndikatif['jumlah'];
			 $content .=  "pagu : ". $paguIndikatif;
			 $content .= "HASIL KALI : ".$hasilKali;
			 
			 $filterPagu = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$p.".".$q.".".$f1.".".$f2.".".$f.".".$g.".".$h.".".$i.".".$j.".".$id_jenis_pemeliharaan.".".$k.".".$l.".".$m.".".$n.".".$o;
			 $getSisaPagu = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as paguYangTerpakai  from view_rka_ppkd_3_1 where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and p='$p' and q='$q' and id_tahap='$this->idTahap' and concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',p,'.',q,'.',f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',id_jenis_pemeliharaan,'.',k,'.',l,'.',m,'.',n,'.',o) != '$filterPagu'  and o1 !='0' and rincian_perhitungan !=''"));
			 $sisaPagu = $paguIndikatif - $getSisaPagu['paguYangTerpakai'];
			 $content .= "Sisa PAGU : ".$sisaPagu;
			 $content .= "getSIsaPAGU nya : "."select sum(jumlah_harga) as paguYangTerpakai  from view_rka_ppkd_3_1 where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and p='$p' and q='$q' and id_tahap='$this->idTahap' and concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',p,'.',q,'.',f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',id_jenis_pemeliharaan,'.',k,'.',l,'.',m,'.',n,'.',o) != '$filterPagu' ";
			
			if($this->jenisForm !='KOREKSI'){
				$err = "Tahap Koreksi Telah Habis";
			}else{
				 if($err == ""){
				 	if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where o1='0' and rincian_perhitungan ='' and c1='0' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and id_tahap='$this->idTahap'  ")) > 0){
				 	
					 }else{
						$data = array(
										"tahun" => $tahun,
										"c1" => '0',
										"c" => '00',
										"d" => '00',
										"e" => '00',
										"e1" => '000',
										"bk" => '0',
										"ck" => '0',
										"dk" => '0',
										"p" => '0',
										"q" => '0',
										"f1" => '0',
										"f2" => '0',
										"f" => '00',
										"g" => '00',
										"h" => '00',
										"i" => '00',
										"j" => '000',
										"k" => $k,
										"l" => $l,
										"m" => $m,
										"n" => $n,
										"o" => $o,
										"jenis_rka" => '3.1',
										"jenis_anggaran" => $this->jenisAnggaran,
										"id_tahap" => $this->idTahap,
										"nama_modul" => $this->modul,
										"user_update" => $_COOKIE['coID'],
										"tanggal_update" => date("Y-m-d")
									
									);
							$query = VulnWalkerInsert('tabel_anggaran',$data);
							$content .= $query;
							mysql_query($query);	 	
					 }
					 if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and k = '$k' and l ='$l' and m='$m' and n='$n' and o='$o'  and o1='$o1' and f1='0' and rincian_perhitungan ='' and id_tahap='$this->idTahap' ")) > 0){
				 	
						 }else{
							$arrayPekerjaan = array(
												'c1' => $c1,
												'c' => $c,
												'd' => $d,
												'e' => $e,
												'e1' => $e1,
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
												'o1' => $o1,
												'rincian_perhitungan' => '',
												'jenis_rka' => '3.1',
												'tahun' => $this->tahun,
												'jenis_anggaran' => $this->jenisAnggaran,
												'id_tahap' => $this->idTahap,
												'nama_modul' => 'RKA-PPKD'
												);
							$queryPekerjaan = VulnWalkerInsert('tabel_anggaran',$arrayPekerjaan);
							mysql_query($queryPekerjaan);
						}
					
					 $dataSesuai = array("tahun" => $tahun,
										 "c1" => $c1,
										 "c" => $c,
										 "d" => $d,
										 "e" => $e,
										 "e1" => $e1,
										 "f1" => $f1,
										 "f2" => $f2,
										 "f" => $f,
										 "g" => $g,
										 "h" => $h,
										 "i" => $i,
										 "j" => $j,
										 "id_jenis_pemeliharaan" => $id_jenis_pemeliharaan,
										 "uraian_pemeliharaan" => $uraian_pemeliharaan,
										 "k" => $k,
										 "l" => $l,
										 "m" => $m,
										 "n" => $n,
										 "o" => $o,
										 "o1" => $o1,
										 "rincian_perhitungan" => $rincian_perhitungan,
										 "jumlah" => $koreksiSatuanHarga,
										 "volume_rek" => $koreksiVolumebarang,
										 "jumlah_harga" => $hasilKali,
										 "jenis_anggaran" => $this->jenisAnggaran,
										 "jenis_rka" => '3.1',
										 "id_tahap" => $this->idTahap,
										 "nama_modul" => $this->modul,
										 "user_update" => $_COOKIE['coID'],
										 "tanggal_update" => date("Y-m-d")
		 								);			
					
					$cekRKA =  mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1'  and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' and o1='$o1' and rincian_perhitungan = '$rincian_perhitungan'"));
							if($cekRKA > 0 ){
								$getID = mysql_fetch_array(mysql_query("select * from view_rka_ppkd_3_1 where c1 = '$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1'  and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1 !='0' and rincian_perhitungan !='' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
							    $idnya = $getID['id_anggaran'];
								mysql_query("update tabel_anggaran set jumlah = '$koreksiSatuanHarga', volume_rek ='$koreksiVolumebarang', jumlah_harga = '$hasilKali' where id_anggaran='$idnya'");
							}else{
								mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));	
								$content.=VulnWalkerInsert("tabel_anggaran", $dataSesuai);
							}
			 }
			}
			
			 			
		break;
	    }

	    case 'SaveValid':{
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			 if ($validasi == 'on') {
			 	 $status_validasi = "1";
			 }else{
			 	$status_validasi = "0";
			 }
			 


			 $data = array( "status_validasi" => $status_validasi,
			 				'user_validasi' => $_COOKIE['coID'],
			 				'tanggal_validasi' => date("Y-m-d"),
							'id_tahap' => $this->idTahap
			 				);
			 $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$rkaPPKD31_idplh'");
			 mysql_query($query);

			$content .= $query;
		break;
	    }
		
		 case 'SaveCatatan':{
	    	foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			 } 
			 
			 $data = array( "catatan" => $catatan
			 				);
			 $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$id'");
			 mysql_query($query);

			$content .= $query;
		break;
	    }
		
		
		case 'editTab':{
			$id = $_REQUEST['rkaPPKD31_cb'];
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 
			
			$username = $_COOKIE['coID'];

			$get = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$id[0]'"));		
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;
			
			$getAll = mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and rincian_perhitungan !=''   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'  order by o1, rincian_perhitungan");
			mysql_query("delete from temp_rka_ppkd_31 where user='$username'");
			mysql_query("delete from temp_rincian_volume_21 where user='$username'");
		    mysql_query("delete from temp_alokasi_rka_ppkd_31 where user='$username'");
			$noUrutPekerjaan = 0;
			$angkaO2 = 0;
			$lastO1 = 0;
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) { 
				  $$key = $value; 
				} 
				$getMaxID = mysql_fetch_array(mysql_query("select  max(id) as gblk from temp_rka_ppkd_31 where user ='$username'"));
				$maxID = $getMaxID['gblk'];
				$lastO1 = $o1;
				
				$getLastO1 = mysql_fetch_array(mysql_query("select o1 from temp_rka_ppkd_31 where id='$maxID' "));
				if($getLastO1['o1'] != $lastO1){
					$noUrutPekerjaan = $noUrutPekerjaan + 1;
					if($o1 == '0'){
						$noUrutPekerjaan = 0;
					}
					$angkaO2 = 1;
				}
				
			 	if($o1 != '0'){
					if(mysql_num_rows(mysql_query("select * from temp_rka_ppkd_31 where  o1 ='$o1' and rincian_perhitungan ='' and user ='$username'")) > 0){
			 	
			 	}else{
			 	$data = array( 'c1' => $c1,
							   'c' => $c,
							   'd' => $d,
							   'e' => $e,
							   'e1' => $e1,
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
							   'o1' => $o1,
							   'o2' => 0,
							   'urut' => $noUrutPekerjaan,
							   'user' => $username
							   
						 );
					mysql_query(VulnWalkerInsert("temp_rka_ppkd_31",$data)); 
				 }
				}
				$data = array(
								'c1' => $c1,
								'c' => $c,
								'd' => $d,
								'e' => $e,
								'e1' => $e1,
								'bk' => $bk,
								'ck' => $ck,
								'p' => $p,
								'q' => $q,
								'f1' => $f1,
								'f2' => $f2,
								'f' => $f,
								'g' => $g,
								'h' => $h,
								'i' => $i,
								'j' => $j,
								'k' => $k,
								'l' => $l,
								'm' => $m,
								'n' => $n,
								'o' => $o,
								'o1' => $o1,
								'o2' => $angkaO2,
								'urut' => $noUrutPekerjaan,
								'volume_rek' => $volume_rek,
								'satuan' => $satuan_rek,
								'user' => $username,
								'rincian_perhitungan' => $rincian_perhitungan,
								'jan' => $alokasi_jan,
								'feb' => $alokasi_feb,
								'mar' => $alokasi_mar,
								'apr' => $alokasi_apr,
								'mei' => $alokasi_mei,
								'jun' => $alokasi_jun,
								'jul' => $alokasi_jul,
								'agu' => $alokasi_agu,
								'sep' => $alokasi_sep,
								'okt' => $alokasi_okt,
								'nop' => $alokasi_nop,
								'des' => $alokasi_des,
								'harga_satuan' => $jumlah,
								'jumlah_harga' => $jumlah_harga,
								'jenis_alokasi_kas' => $jenis_alokasi_kas,
								'jumlah1' => $jumlah1,
								'jumlah2' => $jumlah2,
								'jumlah3' => $jumlah3,
								'jumlah4' => $jumlah4,
								'satuan1' => $satuan1,
								'satuan2' => $satuan2,
								'satuan3' => $satuan3,
								'satuan_total' => $satuan_total,
								'id_awal' => $id_anggaran
								);
				$query = VulnWalkerInsert('temp_rka_ppkd_31',$data);
				mysql_query($query);
				$angkaO2 = $angkaO2 + 1;
				
			}
				
				$content = array('kodeRek' => $kodeRek);
			break;
		}
		
		case 'Remove':{
			$id = $_REQUEST['rkaPPKD31_cb'];
			foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			} 
			
			$username = $_COOKIE['coID'];

			$get = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran ='$id[0]'"));		
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;
			
			$getAll = mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and rincian_perhitungan !=''   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'  order by o1, rincian_perhitungan");
			mysql_query("delete from temp_rka_ppkd_31 where user='$username'");
			mysql_query("delete from temp_rincian_volume_21 where user='$username'");
		    mysql_query("delete from temp_alokasi_rka_ppkd_31 where user='$username'");
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) { 
				  $$key = $value; 
				} 
				mysql_query("delete from tabel_anggaran where id_anggaran = '$id_anggaran'");
				mysql_query("delete from tabel_anggaran where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and o1 ='$o1' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and jenis_rka='1' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'");
				
			}
			
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
			
			if($this->jenisForm !='VALIDASI'){
				$err = "Tahap Validasi Telah Habis";
			}else{
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
			"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=rka-ppkd-1\" title='RKA-PPKD MURNI'  > RKA-PPKD 1 </a> |
	<A href=\"pages.php?Pg=rka-ppkd-2.1\" title='RKA-PPKD MURNI'  > RKA-PPKD 2.1 </a> |
	<A href=\"pages.php?Pg=rka-ppkd-3.1\" title='RKA-PPKD MURNI'  style='color:blue;' > RKA-PPKD 3.1 </a> |
	<A href=\"pages.php?Pg=rka-ppkd-3.2\" title='RKA-PPKD MURNI'  > RKA-PPKD 3.2 </a> |
	<A href=\"pages.php?Pg=rka-ppkd\" title='RKA-PPKD MURNI'  > RKA-PPKD </a> 
	
	&nbsp&nbsp&nbsp	
	</td></tr>
	</table>";
	}
   function setPage_OtherScript(){
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
					</script>";
		return 	
			"
			<script src='js/skpd.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/perencanaan/rka/popupBarang.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/popup_rekening/popupRekening.js' language='JavaScript' ></script>
			<script type='text/javascript' src='js/perencanaan/rka/rkaPPKD3.1.js' language='JavaScript' ></script> 
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
	 $this->form_height = 400;
	  if ($this->form_fmST==0) {
		
			
	  }else{
		$this->form_caption = 'Edit';			
		foreach ($dt as $key => $value) { 
			 	 $$key = $value; 
		 }
		 $getNamaUrusan = mysql_fetch_array(mysql_query("select concat(c1,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='00' and d='00' and e='00' and e1 = '000'"));
		 $namaUrusan = $getNamaUrusan['nama'];
		 $urusan = "<input type ='hidden' name='c1' id='c1' value = '$c1' > <input type ='text'  value = '$namaUrusan' style='width:400px;' readonly>";
		 
		 $getNamaBidang = mysql_fetch_array(mysql_query("select concat(c,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='00' and e='00' and e1 = '000'"));
		 $namaBidang = $getNamaBidang['nama'];
		 $bidang = "<input type ='hidden' name='c' id='c' value = '$c' > <input type ='text'  value = '$namaBidang' style='width:400px;' readonly>";
		 
		 $getNamaSKPD = mysql_fetch_array(mysql_query("select concat(d,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='$d' and e='00' and e1 = '000'"));
		 $namaSKPD = $getNamaSKPD['nama'];
		 $skpd = "<input type ='hidden' name='d' id='d' value = '$d' > <input type ='text'  value = '$namaSKPD' style='width:400px;' readonly>";
		 
		 $getNamaUnit = mysql_fetch_array(mysql_query("select concat(e,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='$e' and e='$e' and e1 = '000'"));
		 $namaUnit = $getNamaUnit['nama'];
		 $unit = "<input type ='hidden' name='e' id='e' value = '$e' > <input type ='text'  value = '$namaUnit' style='width:400px;' readonly>";
		 
		 $getNamaSubUnit = mysql_fetch_array(mysql_query("select concat(e1,'. ',nm_skpd) as nama from ref_skpd where c1='$c1'  and c='$c' and d='$d' and e='$e' and e1 = '$e1'"));
		 $namaSubUnit = $getNamaSubUnit['nama'];
		 $subunit = "<input type ='hidden' name='e1' id='e1' value = '$e1' > <input type ='text'  value = '$namaSubUnit' style='width:400px;' readonly>";
		 
		 $getProgram = mysql_fetch_array(mysql_query("select concat(p,'. ',nama) as nama from ref_program where bk='$bk' and ck='$ck' and dk = '0' and p = '$p' and q= '0'"));
		 $namaProgram = $getProgram['nama'];
		 $program = "<input type ='hidden' name='bk' id='bk' value = '$bk' > <input type ='hidden' name='ck' id='ck' value = '$ck' > <input type ='hidden' name='p' id='p' value = '$p' > <input type ='text'  value = '$namaProgram' style='width:400px;' readonly>";
	   	 
		 $getKegiatan = mysql_fetch_array(mysql_query("select concat(q,'. ',nama) as nama from ref_program where bk='$bk' and ck='$ck' and dk = '0' and p = '$p' and q= '$q'"));
		 $namaKegiatan = $getKegiatan['nama'];
		 $kegiatan = "<input type ='hidden' name='q' id='q' value = '$q' > <input type ='text'  value = '$namaKegiatan' style='width:400px;' readonly>";
	  	 
		 $kodeRENJA = $c1.".".$c.".".$d.".".$e.".".$e1.".".$bk.".".$ck.".".$p.".".$q;
		 $hargaSatuan = $satuan_rek;
		 $kodeBarang = $f1.".".$f2.".".$f.".".$g.".".$h.".".$i.".".$j ;
		 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
		 $namaBarang = $getNamaBarang['nm_barang'];	
		 $kodeRekening = $k.".".$l.".".$m.".".$n.".".$o ;
		 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
		 $namaRekening = $getNamaRekening['nm_rekening'];
		 $arrayJenisRKA = array(
						array("1","RKA-PPKD 1"),
						array("1","RKA-PPKD 1")
						
						);
		 $jenis_rka = $jenis_rka;
		 $cmbJenisRKA = cmbArray('cmbJenisRKAForm',$jenis_rka,$arrayJenisRKA,'-- JENIS RKA --','onchange=rkaPPKD31.unlockFindRekening();');
	 	 if(empty($jenis_rka)){
		 	$tergantungJenis = "disabled";
		 }
		 
		 $getIdTahapRenjaTerakhir = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_renja where tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
		 $idTahapRenja = $getIdTahapRenjaTerakhir['max'];
		 $getPaguIndikatif = mysql_fetch_array(mysql_query("select * from view_renja where c1= '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and p='$p' and q='$q' and id_tahap = '$idTahapRenja' "));
		 $angkaPaguIndikatif = number_format($getPaguIndikatif['jumlah'] ,2,',','.');
		 
		 $formPaguIndikatif  = " <input type='hidden' id='paguIndifkatif' name='paguIndikatif' value='".$getPaguIndikatif['jumlah']."' ><input type='text' value='$angkaPaguIndikatif' readonly >";
	  }

	
	
	 //items ----------------------
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
			'kode3' => array( 
						'label'=>'UNIT',
						'labelWidth'=>150, 
						'value'=> $unit
						 ),
			'kode4' => array( 
						'label'=>'SUB UNIT',
						'labelWidth'=>150, 
						'value'=> $subunit
						 ),
			'kode5' => array( 
						'label'=>'PROGRAM',
						'labelWidth'=>150, 
						'value'=> "<input type='hidden' name = 'bk' id = 'bk' value='$bk'> <input type='hidden' name = 'ck' id = 'ck' value='$ck'>".$program
						 ),
			'kode6' => array( 
						'label'=>'KEGIATAN',
						'labelWidth'=>150, 
						'value'=> $kegiatan
						 ),
			'kode12' => array( 
						'label'=>'PAGU INDIKATIF',
						'labelWidth'=>150, 
						'value'=> $formPaguIndikatif 
						 ),		
			'kode11' => array( 
						'label'=>'JENIS RKA',
						'labelWidth'=>150, 
						'value'=> $cmbJenisRKA,
						 ),	
			'kode9' => array( 
						'label'=>'BARANG',
						'labelWidth'=>150,
						'value'=> "<input type='text' id='kodeBarang' name='kodeBarang' style='width:120px;' readonly value = '$kodeBarang'> &nbsp&nbsp
						 <input type='text' id='namaBarang' name='namaBarang' style='width:300px;' readonly value = '$namaBarang'> "
						 ),				 
			'kode7' => array( 
						'label'=>'REKENING',
						'labelWidth'=>150,
						'value'=> "<input type='text' id='kodeRekening' name='kodeRekening' style='width:120px;' readonly value = '$kodeRekening'> &nbsp&nbsp
						 <input type='text' id='namaRekening' name='namaRekening' style='width:300px;' readonly value = '$namaRekening'>
						 <button type='button' id='findRekening' onclick=rkaPPKD31.findRekening('$jenis_rka'); $tergantungJenis> CARI </button> "
						 ),
			'kode8' => array( 
						'label'=>'HARGA SATUAN',
						'labelWidth'=>150, 
						'value'=> "<input type='text' name='hargaSatuan' id='hargaSatuan' value='$hargaSatuan' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='rkaPPKD31.bantu();' > <span id='bantu' style='color:red;'> </span>"
						 ),	
			
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >  &nbsp  ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	

		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	
		
		 $arrayResult = VulnWalkerTahap($this->modul);
		 $jenisForm = $arrayResult['jenisForm'];
		 $nomorUrut = $arrayResult['nomorUrut'];
		 $tahun = $arrayResult['tahun'];
		 $jenisAnggaran = $arrayResult['jenisAnggaran'];
		 $id_tahap = $arrayResult['id_tahap'];
	 if($jenisForm == "PENYUSUNAN"){
	 	$tergantungJenisForm = "
		";
		$headerTable =
		  "<thead>
		   <tr>
	  	   <th class='th01' width='5' rowspan='2' colspan='1' >No.</th>
	  	   $Checkbox		
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='500'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='1000' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' rowspan='2' width='100' >JUMLAH</th>
		   $tergantungJenisForm 
		 
		   </tr>
		   <tr>
		   
		   <th class='th01' >VOLUME</th>
		   <th class='th01' >SATUAN</th>
		   <th class='th01' >TARIF / HARGA</th>
		   
		   
		   </tr>
		   </thead>";
	 }elseif ($jenisForm == "VALIDASI"){
	 	$tergantungJenisForm = "
		<th class='th01' rowspan='2' width='100' >VALIDASI</th>
		";
		$headerTable =
		  "<thead>
		   <tr>
	  	   <th class='th01' width='5' rowspan='2' colspan='1' >No.</th>
	  	   $Checkbox		
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='500'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='1000' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' rowspan='2' width='100' >JUMLAH</th>
		   $tergantungJenisForm 
		 
		   </tr>
		   <tr>
		   
		   <th class='th01' >VOLUME</th>
		   <th class='th01' >SATUAN</th>
		   <th class='th01' >TARIF / HARGA</th>
		   
		   
		   </tr>
		   </thead>";
	 }elseif ($jenisForm == "KOREKSI"){
	 	$Checkbox = "";
	 	$tergantungJenisForm = "
		<th class='th02' rowspan='1' colspan='3' width='600'>KOREKSI</th>
		<th class='th02' rowspan='1' colspan='3' width='600'>BERTAMBAH/(BERKURANG)</th>
		<th class='th01' rowspan='2' width='200'>AKSI</th>
		";
		$headerTable =
		  "<thead>
		   <tr>
	  	   <th class='th01' width='5' rowspan='2' colspan='1' >No.</th>	
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='900'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='600' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' width='200'  rowspan='2' >JUMLAH HARGA</th>
		   $tergantungJenisForm 
		 
		   </tr>
		   <tr>
		   <th class='th01'  >VOLUME</th>
		   <th class='th01'  >SATUAN</th>
		   <th class='th01' width='200' >TARIF / HARGA</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >TARIF / HARGA</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >TARIF / HARGA</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   </tr>
		   </thead>";
	 }else{
	    $Checkbox = "";
		if($this->jenisFormTerakhir == "PENYUSUNAN"){
			$tergantungJenisForm = "
		";
		$headerTable =
		  "<thead>
		   <tr>
	  	   <th class='th01' width='5' rowspan='2' colspan='1' >No.</th>
	  	   $Checkbox		
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='500'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='1000' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' rowspan='2' width='100' >JUMLAH</th>
		   $tergantungJenisForm 
		 
		   </tr>
		   <tr>
		   
		   <th class='th01' >VOLUME</th>
		   <th class='th01' >SATUAN</th>
		   <th class='th01' >TARIF / HARGA</th>
		   
		   
		   </tr>
		   </thead>";
		}elseif($this->jenisFormTerakhir == "KOREKSI"){
			$Checkbox = "";
	 	$tergantungJenisForm = "
		<th class='th02' rowspan='1' colspan='3' width='600'>KOREKSI</th>
		<th class='th02' rowspan='1' colspan='3' width='600'>BERTAMBAH/(BERKURANG)</th>
		";
		$headerTable =
		  "<thead>
		   <tr>
	  	   <th class='th01' width='5' rowspan='2' colspan='1' >No.</th>	
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='900'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='600' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' width='200'  rowspan='2' >JUMLAH HARGA</th>
		   $tergantungJenisForm 
		 
		   </tr>
		   <tr>
		   <th class='th01'  >VOLUME</th>
		   <th class='th01'  >SATUAN</th>
		   <th class='th01' width='200' >TARIF / HARGA</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >TARIF / HARGA</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   <th class='th01' width='200' >VOLUME REKENING</th>
		   <th class='th01' width='200' >TARIF / HARGA</th>
		   <th class='th01' width='200' >JUMLAH HARGA</th>
		   </tr>
		   </thead>";
		}elseif($this->jenisFormTerakhir == "VALIDASI"){
			$tergantungJenisForm = "
			<th class='th01' rowspan='2' width='100' >VALIDASI</th>
			";
		$headerTable =
		  "<thead>
		   <tr>
	  	   <th class='th01' width='5' rowspan='2' colspan='1' >No.</th>
		   <th class='th01' width='100'  rowspan='2' >KODE REKENING</th>
		   <th class='th01' width='500'  rowspan='2' >NAMA REKENING</th>
		   <th class='th02' colspan='3'  rowspan='1' width='1000' >RINCIAN PERHITUNGAN</th>
		   <th class='th01' rowspan='2' width='100' >JUMLAH</th>
		   $tergantungJenisForm 
		 
		   </tr>
		   <tr>
		   
		   <th class='th01' >VOLUME</th>
		   <th class='th01' >SATUAN</th>
		   <th class='th01' >TARIF / HARGA</th>
		   
		   
		   </tr>
		   </thead>";
		}
	 	
	 }
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
	 
	 
	 
	 //TAHAP PENYUSUNAN
	 if($this->jenisForm == 'PENYUSUNAN'){
	 			
			 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
			 $namaRekening = $getNamaRekening['nm_rekening'];
			 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
			 $namaBarang = $getNamaBarang['nm_barang'];
			 $satuanBarang = $getNamaBarang['satuan'];
			 $Koloms = array();
			 $Koloms[] = array('align="center"', $no.'.' );
		 	
			 if($c1 == '0'){
			 	$Koloms[] = array(" align='center'  ", $TampilCheckBox);
				if(strlen($k) > 1){
					$Koloms[] = array(' align="left"', "<span style='color:red;'>x.x.x.xx.xx</span>" );
				}else{
					$Koloms[] = array(' align="left"', $k.".".$l.".".$m.".".$n.".".$o );
				}	
			 	
			 }else{
			 	if($k == ''){
					$Koloms[] = array(" align='center'  ", '');
					$Koloms[] = array(' align="center"', "" );
				}else{
					$Koloms[] = array(" align='center'  ", '');
					$Koloms[] = array(' align="left"', '' );
				}
			 	
			 }
			 
			 if($jumlah1 == 0 && $satuan1 =='' ){
			 	$ilustrasi = "";	
			 }
			 elseif($jumlah3 == 0 && $satuan3 == ''){
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2;
			 }else{
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2." x ".$jumlah3." ".$satuan3;
			 }
			 if($c1 == '0'){
			 	if(strlen($k) > 1){
					$Koloms[] = array('align="left"',"<span style='color:red;'> Belanja xxx </span>" );
				}else{
					$Koloms[] = array('align="left"',"<b>". $namaRekening ."</b>" );
				}
				$ilustrasi = "";
				$getSumJumlahBarang = mysql_fetch_array(mysql_query("select sum(volume_rek) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and id_tahap='$this->idTahap'"));
				
				$jumlahBarang = $getSumJumlahBarang['total'];
				//$Koloms[] = array('align="right"', number_format($jumlahBarang ,0,',','.') );
				$Koloms[] = array('align="right"',  );
			 }else{
			 	if(empty($rincian_perhitungan) && $f1 == '0' ){
					$getNamaPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$o1'"));
					$namaPekerjaan = $getNamaPekerjaan['nama_pekerjaan'];
					
					$getSumPekerjaan = mysql_fetch_array(mysql_query("select sum(jumlah_harga), sum(volume_rek), sum(jumlah) from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and o1='$o1' and id_tahap='$this->idTahap' "));
					$jumlah_harga = $getSumPekerjaan['sum(jumlah_harga)'];
					$volume_rek = $getSumPekerjaan['sum(volume_rek)'];
					$jumlah = $getSumPekerjaan['sum(jumlah)'];
					$Koloms[] = array('align="left"',"<span style='margin-left:5px;'>- ".$namaPekerjaan."</span>" );
					$ilustrasi = "";
					$jumlah = "";
					$volume_rek = "";
				}elseif($f1 != '0' && empty($rincian_perhitungan) ){
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$namaBarang."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}else{
					
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$rincian_perhitungan."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}
			 	
				
				$Koloms[] = array('align="right"', $volume_rek );
			 }
			 
			 $Koloms[] = array('align="left"', $satuan_rek );
			 $getSumSatuanRek = mysql_fetch_array(mysql_query("select sum(jumlah) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n'  and o='$o' $kondisiSKPD and id_tahap='$this->idTahap'"));
			 $sumSatuanRek = $getSumSatuanRek['total'];
			 if($c1 == '0'){
			 	//$Koloms[] = array('align="right"', number_format($sumSatuanRek ,2,',','.') );
				$Koloms[] = array('align="right"','' );
			 }else{
			 	$Koloms[] = array('align="right"', $jumlah );
			 }
			 
			 if($c1 == '0'){
			 $getTotalJumalhHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and id_tahap='$this->idTahap'"));
			 $Koloms[] = array('align="right"', "<span style='font-weight:bold;'>".number_format($getTotalJumalhHarga['total'] ,2,',','.')."</span>" );

			 }else{
			 	$Koloms[] = array('align="right"', number_format($jumlah_harga ,2,',','.') );
				
			 }
	 
	 
	 //TAHAP PENYUSUNAN
	 }elseif($this->jenisForm=="VALIDASI"){
	 	     $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
			 $namaRekening = $getNamaRekening['nm_rekening'];
			 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
			 $namaBarang = $getNamaBarang['nm_barang'];
			 $satuanBarang = $getNamaBarang['satuan'];
			 if($status_validasi == '1'){
				$validnya = "valid.png";
			 }else{
				$validnya = "invalid.png";
			 }
			 $Koloms = array();
			 $Koloms[] = array('align="center"', $no.'.' );
		 	
			 if($c1 == '0'){
			 	$Koloms[] = array(" align='center'  ", "");
				if(strlen($k) > 1){
					$Koloms[] = array(' align="left"', "<span style='color:red;'>x.x.x.xx.xx</span>" );
				}else{
					$Koloms[] = array(' align="left"', $k.".".$l.".".$m.".".$n.".".$o );
				}	
			 	
			 }else{
			 	if($k == ''){
					$Koloms[] = array(" align='center'  ", '');
					$Koloms[] = array(' align="center"', "" );
				}else{
					if($rincian_perhitungan !=''){
						$Koloms[] = array(" align='center'  ", $TampilCheckBox);
					}else{
						$Koloms[] = array(" align='center'  ", "");
					}
					
					$Koloms[] = array(' align="left"', '' );
				}
			 	
			 }
			 
			 if($jumlah1 == 0 && $satuan1 =='' ){
			 	$ilustrasi = "";	
			 }
			 elseif($jumlah3 == 0 && $satuan3 == ''){
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2;
			 }else{
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2." x ".$jumlah3." ".$satuan3;
			 }
			 if($c1 == '0'){
			 	if(strlen($k) > 1){
					$Koloms[] = array('align="left"',"<span style='color:red;'> Belanja xxx </span>" );
				}else{
					$Koloms[] = array('align="left"',"<b>". $namaRekening ."</b>" );
				}
				$ilustrasi = "";
				$Koloms[] = array('align="left"',"" );
				$getSumJumlahBarang = mysql_fetch_array(mysql_query("select sum(volume_rek) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and id_tahap='$this->idTahap'"));
				
				$jumlahBarang = $getSumJumlahBarang['total'];
				//$Koloms[] = array('align="right"', number_format($jumlahBarang ,0,',','.') );
				$Koloms[] = array('align="right"',  );
			 }else{
			 	if(empty($rincian_perhitungan) && $f1 == '0' ){
					$getNamaPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$o1'"));
					$namaPekerjaan = $getNamaPekerjaan['nama_pekerjaan'];
					
					$getSumPekerjaan = mysql_fetch_array(mysql_query("select sum(jumlah_harga), sum(volume_rek), sum(jumlah) from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and o1='$o1' and id_tahap='$this->idTahap' "));
					$jumlah_harga = $getSumPekerjaan['sum(jumlah_harga)'];
					$volume_rek = $getSumPekerjaan['sum(volume_rek)'];
					$jumlah = $getSumPekerjaan['sum(jumlah)'];
					$Koloms[] = array('align="left"',"<span style='margin-left:5px;'>- ".$namaPekerjaan."</span>" );
					$ilustrasi = "";
					$jumlah = "";
					$volume_rek = "";
				}elseif($f1 != '0' && empty($rincian_perhitungan) ){
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$namaBarang."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}else{
					$validasi = "<img src='images/administrator/images/$validnya' width='20px' heigh='20px'> </img>";
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$rincian_perhitungan."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}
			 	
				
				$Koloms[] = array('align="right"', $volume_rek );
			 }
			 
			 $Koloms[] = array('align="left"', $satuan_rek );
			 $getSumSatuanRek = mysql_fetch_array(mysql_query("select sum(jumlah) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n'  and o='$o' $kondisiSKPD and id_tahap='$this->idTahap'"));
			 $sumSatuanRek = $getSumSatuanRek['total'];
			 if($c1 == '0'){
			 	//$Koloms[] = array('align="right"', number_format($sumSatuanRek ,2,',','.') );

			 }else{
			 	$Koloms[] = array('align="right"', $jumlah );
			 }
			 
			 if($c1 == '0'){
			 $getTotalJumalhHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and id_tahap='$this->idTahap'"));
			 $Koloms[] = array('align="right"',"<span style='font-weight:bold;'>". number_format($getTotalJumalhHarga['total'] ,2,',','.')."</span>" );
			 }else{
			 	$Koloms[] = array('align="right"', number_format($jumlah_harga ,2,',','.') );
				
			 }
			 
			 $Koloms[] = array('align="center"', $validasi );
			 
			 
	 }elseif($this->jenisForm=="KOREKSI"){
	 		 $nomorBefore = $this->nomorUrut - 1;
			 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
			 $namaRekening = $getNamaRekening['nm_rekening'];
			 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
			 $namaBarang = $getNamaBarang['nm_barang'];
			 $satuanBarang = $getNamaBarang['satuan'];
			 $Koloms = array();
			 $Koloms[] = array('align="center"', $no.'.' );
		 	 $bk = $isi['bk'];
			 $ck = $isi['ck'];
			 $p = $isi['p'];
			 $q = $isi['q'];
			 if($c1 == '0'){
				if(strlen($k) > 1){
					$Koloms[] = array(' align="left"', "<span style='color:red;'>x.x.x.xx.xx</span>" );
				}else{
					$Koloms[] = array(' align="left"', $k.".".$l.".".$m.".".$n.".".$o );
				}	
			 	
			 }else{
			 	if($k == ''){
					$Koloms[] = array(' align="center"', "" );
				}else{
					$Koloms[] = array(' align="left"', '' );
				}
			 	
			 }
			 
			 if($jumlah1 == 0 && $satuan1 =='' ){
			 	$ilustrasi = "";	
			 }
			 elseif($jumlah3 == 0 && $satuan3 == ''){
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2;
			 }else{
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2." x ".$jumlah3." ".$satuan3;
			 }
			 if($c1 == '0'){
			 	if(strlen($k) > 1){
					$Koloms[] = array('align="left"',"<span style='color:red;'> Belanja xxx </span>" );
				}else{
					$Koloms[] = array('align="left"',"<b>". $namaRekening ."</b>" );
				}
				$ilustrasi = "";
				//$Koloms[] = array('align="left"',"" );
				$getSumJumlahBarang = mysql_fetch_array(mysql_query("select sum(volume_rek) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				
				$jumlahBarang = $getSumJumlahBarang['total'];
				//$Koloms[] = array('align="right"', number_format($jumlahBarang ,0,',','.') );
				$Koloms[] = array('align="right"',  );
			 }else{
			 	if(empty($rincian_perhitungan) && $f1 == '0' ){
					$getNamaPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$o1'"));
					$namaPekerjaan = $getNamaPekerjaan['nama_pekerjaan'];
					
					$getSumPekerjaan = mysql_fetch_array(mysql_query("select sum(jumlah_harga), sum(volume_rek), sum(jumlah) from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and o1='$o1' and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
					$jumlah_harga = $getSumPekerjaan['sum(jumlah_harga)'];
					$volume_rek = $getSumPekerjaan['sum(volume_rek)'];
					$jumlah = $getSumPekerjaan['sum(jumlah)'];
					$Koloms[] = array('align="left"',"<span style='margin-left:5px;'>- ".$namaPekerjaan."</span>" );
					$ilustrasi = "";
					$jumlah = "";
					$volume_rek = "";
				}elseif($f1 != '0' && empty($rincian_perhitungan) ){
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$namaBarang."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}else{
					
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$rincian_perhitungan."</span>" );
					$jumlah =  "<input type='hidden' id='hargaSatuanSesuai$id_anggaran' value='$jumlah'>".number_format($jumlah ,2,',','.');
					$volume_rek = "<input type='hidden' id='volumeRekSesuai$id_anggaran' value='$volume_rek'>".number_format($volume_rek ,0,',','.');
				}
			 	
				
				//$Koloms[] = array('align="left"',$ilustrasi );
				$Koloms[] = array('align="right"', $volume_rek );
			 }
			 
			 $Koloms[] = array('align="left"', $satuan_rek );
			 $getSumSatuanRek = mysql_fetch_array(mysql_query("select sum(jumlah) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n'  and o='$o' $kondisiSKPD and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			 $sumSatuanRek = $getSumSatuanRek['total'];
			 if($c1 == '0'){
			 	//$Koloms[] = array('align="right"', number_format($sumSatuanRek ,2,',','.') );
				$Koloms[] = array('align="right"','' );
			 }else{
			 	$Koloms[] = array('align="right"', $jumlah );
			 }
			 
			 if($c1 == '0'){
			 $getTotalJumalhHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			 $Koloms[] = array('align="right"', "<span style='font-weight:bold;'>".number_format($getTotalJumalhHarga['total'] ,2,',','.')."</span>" );

			 }else{
			 	$Koloms[] = array('align="right"', number_format($jumlah_harga ,2,',','.') );
				
			 }
			 $getAngkaKoreksi = mysql_fetch_array(mysql_query("select * from view_rka_ppkd_3_1 where c1='$c1' and c='$c' and d='$d'  and e='$e' and e1='$e1'  and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1='$o1' and rincian_perhitungan ='$rincian_perhitungan'  and id_tahap='$this->idTahap'"));
			 $koreksiVolumeBarang = number_format($getAngkaKoreksi['volume_rek'] ,0,',','.');
			 $koreksiSatuanHarga = number_format($getAngkaKoreksi['jumlah'] ,2,',','.');
			 $koreksiJumlahHarga = number_format($getAngkaKoreksi['volume_rek']  * $getAngkaKoreksi['jumlah'] ,2,',','.');
			 if($getAngkaKoreksi['volume_rek'] > $isi['volume_rek'] ){
			 	$bertambahBerkurangVolumeBarang = number_format($getAngkaKoreksi['volume_rek'] - $isi['volume_rek'] ,0,',','.'); 
			 }elseif($isi['volume_rek'] > $getAngkaKoreksi['volume_rek']){
			 	$bertambahBerkurangVolumeBarang = "( ". number_format( $isi['volume_rek'] - $getAngkaKoreksi['volume_rek'],0,',','.') ." )" ; 
			 }else{
			 	$bertambahBerkurangVolumeBarang = "0";
			 }
			 if(empty($getAngkaKoreksi['c1'])){
				$bertambahBerkurangVolumeBarang = "";			 	
			 }
			 
			 if($getAngkaKoreksi['jumlah'] > $isi['jumlah'] ){
			 	$bertambahBerkurangSatuanHarga = number_format($getAngkaKoreksi['jumlah'] - $isi['jumlah'] ,0,',','.'); 
			 }elseif($isi['jumlah'] > $getAngkaKoreksi['jumlah']){
			 	$bertambahBerkurangSatuanHarga = "( ". number_format( $isi['jumlah'] - $getAngkaKoreksi['jumlah'],0,',','.') ." )" ; 
			 }else{
			 	$bertambahBerkurangSatuanHarga = "0";
			 }
			 if(empty($getAngkaKoreksi['c1'])){
				$bertambahBerkurangSatuanHarga = "";			 	
			 }
			 
			 if($getAngkaKoreksi['jumlah_harga'] > $jumlah_harga ){
			 	$bertambahBerkurangJumlahHarga = number_format($getAngkaKoreksi['jumlah_harga'] - $jumlah_harga ,0,',','.'); 
			 }elseif($jumlah_harga > $getAngkaKoreksi['jumlah_harga']){
			 	$bertambahBerkurangJumlahHarga = "( ". number_format( $jumlah_harga - $getAngkaKoreksi['jumlah_harga'],0,',','.') ." )" ; 
			 }else{
			 	$bertambahBerkurangJumlahHarga = "0";
			 }
			 if(empty($getAngkaKoreksi['c1'])){
				$bertambahBerkurangJumlahHarga = "";			 	
			 }
			 
			 
			 if(empty($rincian_perhitungan)){
			 	$Koloms[] = array('align="right"',"");
			    $Koloms[] = array('align="right"',"");
				if($o1 !='0'){
				 	$getTotalJumalhHargaKoreksi = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1='$o1' $kondisiSKPD and id_tahap ='$this->idTahap' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				 	
					$Koloms[] = array('align="right"',number_format($getTotalJumalhHargaKoreksi['total'] ,2,',','.'));
				 }else{
				 	$getTotalJumalhHargaKoreksi = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and id_tahap ='$this->idTahap' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				 	
					$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>".number_format($getTotalJumalhHargaKoreksi['total'] ,2,',','.')."</span>");
				 }
			 }else{
			 	$Koloms[] = array('align="right"',"<span id='spanVolumeBarang".$id_anggaran."'> $koreksiVolumeBarang  </span>");
			    $Koloms[] = array('align="right"',"<span id='spanSatuanHarga".$id_anggaran."'> $koreksiSatuanHarga </span>");
				$Koloms[] = array('align="right"',"<span id='spanJumlahHarga$id_anggaran'>".$koreksiJumlahHarga."</span>");
			 }
			 
		     
			 $aksi  = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=rkaPPKD31.sesuai('$id_anggaran');></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=rkaPPKD31.koreksi('$id_anggaran');></img> ";
			 if ($rincian_perhitungan == '') {
			 $aksi = "";
			 }
			 if(empty($rincian_perhitungan)){
			 	 $Koloms[] = array('align="right" id="alignButton'.$id_anggaran.'" ',"");
				 $Koloms[] = array('align="right"',"");
				 if($o1 !='0'){
				 	$getTotalJumalhHargaKoreksi = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1='$o1' $kondisiSKPD and id_tahap ='$this->idTahap' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				 	$kurangLebihPekerjaan = $jumlah_harga - $getTotalJumalhHargaKoreksi['total'];
					if($kurangLebihPekerjaan == 0){
						$Koloms[] = array('align="right"','0');
					}else{
						if($kurangLebihPekerjaan < 0){
							$kurangLebihPekerjaan = $getTotalJumalhHargaKoreksi['total'] - $jumlah_harga  ;
							$Koloms[] = array('align="right"',"( ".number_format($kurangLebihPekerjaan ,2,',','.')." )");
						}else{
							$Koloms[] = array('align="right"',number_format($kurangLebihPekerjaan ,2,',','.'));
						}
						
					}
					
				 }else{
				 	$getTotalJumalhHargaKoreksi = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and id_tahap ='$this->idTahap' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				 	$kurangLebihRekening = $getTotalJumalhHarga['total'] - $getTotalJumalhHargaKoreksi['total'];
					if($kurangLebihRekening == 0){
						$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>".'0'."</span>");
					}else{
						if($kurangLebihRekening < 0){
							$kurangLebihRekening = $getTotalJumalhHarga['total'] - $getTotalJumalhHargaKoreksi['total']   ;
							$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>"."( ".number_format($kurangLebihRekening ,2,',','.')." )"."</span>");
						}else{
							$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>".number_format($kurangLebihRekening ,2,',','.')."</span>");
						}
						
					}
				 }
				 
			 }else{
			 	$Koloms[] = array('align="right" id="alignButton'.$id_anggaran.'" ',$bertambahBerkurangVolumeBarang."</span>");
			 	$Koloms[] = array('align="right"',$bertambahBerkurangSatuanHarga);
			 	$Koloms[] = array('align="right"',$bertambahBerkurangJumlahHarga);
			 }
			 
			 $Koloms[] = array('align="center"',"<span id='buttonSubmitKoreksi$id_anggaran' >".$aksi."</span>");
	 }else{
	 	if($this->jenisFormTerakhir == "KOREKSI"){
			 $nomorBefore = $this->urutTerakhir - 1;
			 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
			 $namaRekening = $getNamaRekening['nm_rekening'];
			 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
			 $namaBarang = $getNamaBarang['nm_barang'];
			 $satuanBarang = $getNamaBarang['satuan'];
			 $Koloms = array();
			 $Koloms[] = array('align="center"', $no.'.' );
		 	 
			 if($c1 == '0'){
				if(strlen($k) > 1){
					$Koloms[] = array(' align="left"', "<span style='color:red;'>x.x.x.xx.xx</span>" );
				}else{
					$Koloms[] = array(' align="left"', $k.".".$l.".".$m.".".$n.".".$o );
				}	
			 	
			 }else{
			 	if($k == ''){
					$Koloms[] = array(' align="center"', "" );
				}else{
					$Koloms[] = array(' align="left"', '' );
				}
			 	
			 }
			 
			 if($jumlah1 == 0 && $satuan1 =='' ){
			 	$ilustrasi = "";	
			 }
			 elseif($jumlah3 == 0 && $satuan3 == ''){
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2;
			 }else{
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2." x ".$jumlah3." ".$satuan3;
			 }
			 if($c1 == '0'){
			 	if(strlen($k) > 1){
					$Koloms[] = array('align="left"',"<span style='color:red;'> Belanja xxx </span>" );
				}else{
					$Koloms[] = array('align="left"',"<b>". $namaRekening ."</b>" );
				}
				$ilustrasi = "";
				//$Koloms[] = array('align="left"',"" );
				$getSumJumlahBarang = mysql_fetch_array(mysql_query("select sum(volume_rek) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				
				$jumlahBarang = $getSumJumlahBarang['total'];
				//$Koloms[] = array('align="right"', number_format($jumlahBarang ,0,',','.') );
				$Koloms[] = array('align="right"',  );
			 }else{
			 	if(empty($rincian_perhitungan) && $f1 == '0' ){
					$getNamaPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$o1'"));
					$namaPekerjaan = $getNamaPekerjaan['nama_pekerjaan'];
					
					$getSumPekerjaan = mysql_fetch_array(mysql_query("select sum(jumlah_harga), sum(volume_rek), sum(jumlah) from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and o1='$o1' and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
					$jumlah_harga = $getSumPekerjaan['sum(jumlah_harga)'];
					$volume_rek = $getSumPekerjaan['sum(volume_rek)'];
					$jumlah = $getSumPekerjaan['sum(jumlah)'];
					$Koloms[] = array('align="left"',"<span style='margin-left:5px;'>- ".$namaPekerjaan."</span>" );
					$ilustrasi = "";
					$jumlah = "";
					$volume_rek = "";
				}elseif($f1 != '0' && empty($rincian_perhitungan) ){
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$namaBarang."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}else{
					
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$rincian_perhitungan."</span>" );
					$jumlah =  "<input type='hidden' id='hargaSatuanSesuai$id_anggaran' value='$jumlah'>".number_format($jumlah ,2,',','.');
					$volume_rek = "<input type='hidden' id='volumeRekSesuai$id_anggaran' value='$volume_rek'>".number_format($volume_rek ,0,',','.');
				}
			 	
				
				//$Koloms[] = array('align="left"',$ilustrasi );
				$Koloms[] = array('align="right"', $volume_rek );
			 }
			 
			 $Koloms[] = array('align="left"', $satuan_rek );
			 $getSumSatuanRek = mysql_fetch_array(mysql_query("select sum(jumlah) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n'  and o='$o' $kondisiSKPD and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			 $sumSatuanRek = $getSumSatuanRek['total'];
			 if($c1 == '0'){
			 	//$Koloms[] = array('align="right"', number_format($sumSatuanRek ,2,',','.') );
				$Koloms[] = array('align="right"','' );
			 }else{
			 	$Koloms[] = array('align="right"', $jumlah );
			 }
			 
			 if($c1 == '0'){
			 $getTotalJumalhHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and no_urut ='$nomorBefore' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			 $Koloms[] = array('align="right"',"<span style='font-weight:bold;'>". number_format($getTotalJumalhHarga['total'] ,2,',','.')."</span>" );

			 }else{
			 	$Koloms[] = array('align="right"', number_format($jumlah_harga ,2,',','.') );
				
			 }
			 $getAngkaKoreksi = mysql_fetch_array(mysql_query("select * from view_rka_ppkd_3_1 where c1='$c1' and c='$c' and d='$d'  and e='$e' and e1='$e1'  and id_jenis_pemeliharaan='$id_jenis_pemeliharaan' and f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1='$o1' and rincian_perhitungan ='$rincian_perhitungan'  and no_urut = '$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			 $koreksiVolumeBarang = number_format($getAngkaKoreksi['volume_rek'] ,0,',','.');
			 $koreksiSatuanHarga = number_format($getAngkaKoreksi['jumlah'] ,2,',','.');
			 $koreksiJumlahHarga = number_format($getAngkaKoreksi['volume_rek']  * $getAngkaKoreksi['jumlah'] ,2,',','.');
			 if($getAngkaKoreksi['volume_rek'] > $isi['volume_rek'] ){
			 	$bertambahBerkurangVolumeBarang = number_format($getAngkaKoreksi['volume_rek'] - $isi['volume_rek'] ,0,',','.'); 
			 }elseif($isi['volume_rek'] > $getAngkaKoreksi['volume_rek']){
			 	$bertambahBerkurangVolumeBarang = "( ". number_format( $isi['volume_rek'] - $getAngkaKoreksi['volume_rek'],0,',','.') ." )" ; 
			 }else{
			 	$bertambahBerkurangVolumeBarang = "0";
			 }
			 if(empty($getAngkaKoreksi['c1'])){
				$bertambahBerkurangVolumeBarang = "";			 	
			 }
			 
			 if($getAngkaKoreksi['jumlah'] > $isi['jumlah'] ){
			 	$bertambahBerkurangSatuanHarga = number_format($getAngkaKoreksi['jumlah'] - $isi['jumlah'] ,0,',','.'); 
			 }elseif($isi['jumlah'] > $getAngkaKoreksi['jumlah']){
			 	$bertambahBerkurangSatuanHarga = "( ". number_format( $isi['jumlah'] - $getAngkaKoreksi['jumlah'],0,',','.') ." )" ; 
			 }else{
			 	$bertambahBerkurangSatuanHarga = "0";
			 }
			 if(empty($getAngkaKoreksi['c1'])){
				$bertambahBerkurangSatuanHarga = "";			 	
			 }
			 
			 if($getAngkaKoreksi['jumlah_harga'] > $jumlah_harga ){
			 	$bertambahBerkurangJumlahHarga = number_format($getAngkaKoreksi['jumlah_harga'] - $jumlah_harga ,0,',','.'); 
			 }elseif($jumlah_harga > $getAngkaKoreksi['jumlah_harga']){
			 	$bertambahBerkurangJumlahHarga = "( ". number_format( $jumlah_harga - $getAngkaKoreksi['jumlah_harga'],0,',','.') ." )" ; 
			 }else{
			 	$bertambahBerkurangJumlahHarga = "0";
			 }
			 if(empty($getAngkaKoreksi['c1'])){
				$bertambahBerkurangJumlahHarga = "";			 	
			 }
			 
			 
			 if(empty($rincian_perhitungan)){
			 	$Koloms[] = array('align="right"',"");
			    $Koloms[] = array('align="right"',"");
				
				
				if($o1 !='0'){
					$getTotalJumalhHargaKoreksi = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' and o1='$o1' $kondisiSKPD and no_urut ='$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
					$Koloms[] = array('align="right"', number_format($getTotalJumalhHargaKoreksi['total'],2,',','.') );
				}else{
					$getTotalJumalhHargaKoreksi = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'  $kondisiSKPD and no_urut ='$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
					$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>". number_format($getTotalJumalhHargaKoreksi['total'],2,',','.')."</span>");
				}
				
			 }else{
			 	$Koloms[] = array('align="right"',"<span id='spanVolumeBarang".$id_anggaran."'> $koreksiVolumeBarang  </span>");
			    $Koloms[] = array('align="right"',"<span id='spanSatuanHarga".$id_anggaran."'> $koreksiSatuanHarga </span>");
				$Koloms[] = array('align="right"',"<span id='spanJumlahHarga$id_anggaran'>".$koreksiJumlahHarga."</span>");
			 }
			 
		     
			 $aksi  = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=rkaPPKD31.sesuai('$id_anggaran');></img>&nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=rkaPPKD31.koreksi('$id_anggaran');></img> ";
			 if ($rincian_perhitungan == '') {
			 $aksi = "";
			 }
			 if(empty($rincian_perhitungan)){
			 	 $Koloms[] = array('align="right" id="alignButton'.$id_anggaran.'" ',"");
				 $Koloms[] = array('align="right"',"");
				 if($o1 !='0'){
				 	$kurangLebihPekerjaan = $jumlah_harga - $getTotalJumalhHargaKoreksi['total'] ;
					if($kurangLebihPekerjaan == 0){
						$Koloms[] = array('align="right"', "0");
					}elseif($kurangLebihPekerjaan < 0){
						$kurangLebihPekerjaan =  $getTotalJumalhHargaKoreksi['total'] - $jumlah_harga ;
						$Koloms[] = array('align="right"',"( ". number_format($kurangLebihPekerjaan,2,',','.')." )");
					}else{
						$Koloms[] = array('align="right"', number_format($kurangLebihPekerjaan,2,',','.'));
					}
				 	
				 }else{
				 	$getTotalJumalhHargaKoreksi = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and id_tahap ='$this->urutTerakhir' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				 	$kurangLebihRekening = $jumlah_harga - $getTotalJumalhHargaKoreksi['total'];
					if($kurangLebihRekening == 0){
						$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>".'0'."</span>");
					}else{
						if($kurangLebihRekening < 0){
							$kurangLebihRekening = $getTotalJumalhHarga['total'] - $getTotalJumalhHargaKoreksi['total']   ;
							$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>"."( ".number_format($kurangLebihRekening ,2,',','.')." )"."</span>");
						}else{
							$Koloms[] = array('align="right"',"<span style='font-weight:bold;'>".number_format($kurangLebihRekening ,2,',','.')."</span>");
						}
						
					}
				 }
				 
			 }else{
			 	$Koloms[] = array('align="right" id="alignButton'.$id_anggaran.'" ',$bertambahBerkurangVolumeBarang);
			 	$Koloms[] = array('align="right"',$bertambahBerkurangSatuanHarga);
			 	$Koloms[] = array('align="right"',$bertambahBerkurangJumlahHarga);
			 }
			 
		}elseif($this->jenisFormTerakhir == "VALIDASI"){
			 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
			 $namaRekening = $getNamaRekening['nm_rekening'];
			 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
			 $namaBarang = $getNamaBarang['nm_barang'];
			 $satuanBarang = $getNamaBarang['satuan'];
			 if($status_validasi == '1'){
				$validnya = "valid.png";
			 }else{
				$validnya = "invalid.png";
			 }
			 $Koloms = array();
			 $Koloms[] = array('align="center"', $no.'.' );
		 	
			 if($c1 == '0'){
				if(strlen($k) > 1){
					$Koloms[] = array(' align="left"', "<span style='color:red;'>x.x.x.xx.xx</span>" );
				}else{
					$Koloms[] = array(' align="left"', $k.".".$l.".".$m.".".$n.".".$o );
				}	
			 	
			 }else{
			 	if($k == ''){
					$Koloms[] = array(" align='center'  ", '');
					$Koloms[] = array(' align="center"', "" );
				}else{
					
					$Koloms[] = array(' align="left"', '' );
				}
			 	
			 }
			 
			 if($jumlah1 == 0 && $satuan1 =='' ){
			 	$ilustrasi = "";	
			 }
			 elseif($jumlah3 == 0 && $satuan3 == ''){
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2;
			 }else{
			 	$ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2." x ".$jumlah3." ".$satuan3;
			 }
			 if($c1 == '0'){
			 	if(strlen($k) > 1){
					$Koloms[] = array('align="left"',"<span style='color:red;'> Belanja xxx </span>" );
				}else{
					$Koloms[] = array('align="left"',"<b>". $namaRekening ."</b>" );
				}
				$ilustrasi = "";
				$Koloms[] = array('align="left"',"" );
				$getSumJumlahBarang = mysql_fetch_array(mysql_query("select sum(volume_rek) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and no_urut ='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				
				$jumlahBarang = $getSumJumlahBarang['total'];
				//$Koloms[] = array('align="right"', number_format($jumlahBarang ,0,',','.') );
				$Koloms[] = array('align="right"',  );
			    }else{
			 	if(empty($rincian_perhitungan) && $f1 == '0' ){
					$getNamaPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$o1'"));
					$namaPekerjaan = $getNamaPekerjaan['nama_pekerjaan'];
					
					$getSumPekerjaan = mysql_fetch_array(mysql_query("select sum(jumlah_harga), sum(volume_rek), sum(jumlah) from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and o1='$o1' and no_urut ='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
					$jumlah_harga = $getSumPekerjaan['sum(jumlah_harga)'];
					$volume_rek = $getSumPekerjaan['sum(volume_rek)'];
					$jumlah = $getSumPekerjaan['sum(jumlah)'];
					$Koloms[] = array('align="left"',"<span style='margin-left:5px;'>- ".$namaPekerjaan."</span>" );
					$ilustrasi = "";
					$jumlah = "";
					$volume_rek = "";
				}elseif($f1 != '0' && empty($rincian_perhitungan) ){
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$namaBarang."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}else{
					$validasi = "<img src='images/administrator/images/$validnya' width='20px' heigh='20px'> </img>";
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$rincian_perhitungan."</span>" );
					$jumlah = number_format($jumlah ,2,',','.');
					$volume_rek = number_format($volume_rek ,0,',','.');
				}
			 	
				
				$Koloms[] = array('align="right"', $volume_rek );
			 }
			 
			 $Koloms[] = array('align="left"', $satuan_rek );
			 $getSumSatuanRek = mysql_fetch_array(mysql_query("select sum(jumlah) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n'  and o='$o' $kondisiSKPD and id_tahap='$this->idTahap'"));
			 $sumSatuanRek = $getSumSatuanRek['total'];
			 if($c1 == '0'){
			 	//$Koloms[] = array('align="right"', number_format($sumSatuanRek ,2,',','.') );
			 }else{
			 	$Koloms[] = array('align="right"', $jumlah );
			 }
			 
			 if($c1 == '0'){
			 $getTotalJumalhHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and no_urut ='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			 $Koloms[] = array('align="right"', "<span style='font-weight:bold;'>".number_format($getTotalJumalhHarga['total'] ,2,',','.')."</span>" );
			 }else{
			 	$Koloms[] = array('align="right"', number_format($jumlah_harga ,2,',','.') );
				
			 }
			 $Koloms[] = array('align="center"', $validasi );
		}elseif($this->jenisFormTerakhir == "PENYUSUNAN"){
			 $nomorurutSebelumnya = $this->urutTerakhir ;
			 $getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l ='$l' and m='$m' and n='$n' and o='$o'"));
			 $namaRekening = $getNamaRekening['nm_rekening'];
			 $getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1='$f1' and f2='$f2' and f='$f' and g='$g' and h='$h' and i='$i' and j='$j'"));
			 $namaBarang = $getNamaBarang['nm_barang'];
			 $satuanBarang = $getNamaBarang['satuan'];
			 $Koloms = array();
			 $Koloms[] = array('align="center"', $no.'.' );
		 	
			 if($c1 == '0'){
				if(strlen($k) > 1){
					$Koloms[] = array(' align="left"', "<span style='color:red;'>x.x.x.xx.xx</span>" );
				}else{
					$Koloms[] = array(' align="left"', $k.".".$l.".".$m.".".$n.".".$o );
				}	
			 	
			 }else{
			 	if($k == ''){
					$Koloms[] = array(' align="center"', "" );
				}else{
					$Koloms[] = array(' align="left"', '' );
				}
			 	
			 }
			 $ilustrasi = $jumlah1." ".$satuan1." x ". " ".$jumlah2." ".$satuan2." x ".$jumlah3." ".$satuan3." = ".$jumlah4." ".$satuan_total;
			 if($c1 == '0'){
			 	if(strlen($k) > 1){
					$Koloms[] = array('align="left"',"<span style='color:red;'> Belanja xxx </span>" );
				}else{
					$Koloms[] = array('align="left"',"<b>". $namaRekening ."</b>" );
				}
				$ilustrasi = "";
			
				$getSumJumlahBarang = mysql_fetch_array(mysql_query("select sum(volume_rek) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and no_urut ='$nomorurutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
				
				$jumlahBarang = $getSumJumlahBarang['total'];
				//$Koloms[] = array('align="right"', number_format($jumlahBarang ,0,',','.') );
				$Koloms[] = array('align="right"', '' );
			 }else{
			 	if(empty($rincian_perhitungan) && $f1 == '0' ){
					$getNamaPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$o1'"));
					$namaPekerjaan = $getNamaPekerjaan['nama_pekerjaan'];
					
					$getSumPekerjaan = mysql_fetch_array(mysql_query("select sum(jumlah_harga), sum(volume_rek), sum(jumlah) from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and o1='$o1' and no_urut ='$nomorurutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' "));
					$jumlah_harga = $getSumPekerjaan['sum(jumlah_harga)'];
					$volume_rek = $getSumPekerjaan['sum(volume_rek)'];
					$jumlah = $getSumPekerjaan['sum(jumlah)'];
					$Koloms[] = array('align="left"',"<span style='margin-left:5px;'>- ".$namaPekerjaan."</span>" );
					$ilustrasi = "";
					$volume_rek = "";
					$jumlah = "";
				}elseif($f1 != '0' && empty($rincian_perhitungan) ){
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$namaBarang."</span>" );
					$volume_rek = number_format($volume_rek ,0,',','.');
					$jumlah =  number_format($jumlah ,2,',','.');
				}else{
					
					$Koloms[] = array('align="left"',"<span style='margin-left:10px;'>&nbsp&nbsp".$rincian_perhitungan."</span>" );
					$volume_rek = number_format($volume_rek ,0,',','.');
					$jumlah =  number_format($jumlah ,2,',','.');
				}
			 	
				
				$Koloms[] = array('align="right"', $volume_rek );
			 }
			 
			 $Koloms[] = array('align="left"', $satuan_rek );
			 $getSumSatuanRek = mysql_fetch_array(mysql_query("select sum(jumlah) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n'  and o='$o' $kondisiSKPD and id_tahap='$this->idTahap'"));
			 $sumSatuanRek = $getSumSatuanRek['total'];
			 if($c1 == '0'){
			 	//$Koloms[] = array('align="right"', number_format($sumSatuanRek ,2,',','.') );
				$Koloms[] = array('align="right"', '' );
			 }else{
			 	$Koloms[] = array('align="right"',$jumlah );
			 }
			 
			 if($c1 == '0'){
			 $getTotalJumalhHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) as total from view_rka_ppkd_3_1 where k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and no_urut ='$nomorurutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
			 $Koloms[] = array('align="right"', "<span style='font-weight:bold;'>".number_format($getTotalJumalhHarga['total'] ,2,',','.')."</span>" );

			 }else{
			 	$Koloms[] = array('align="right"', number_format($jumlah_harga ,2,',','.') );
				
			 }
		}
	 }

	 return $Koloms;
	}


	function Validasi($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI RKA-PPKD 1';
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
						'label'=>'KODE rkaPPKD31',
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
		$urusan = cmbQuery('cmbUrusan',$selectedC1,$codeAndNameUrusan,'onchange=rkaPPKD31.refreshList(true);','-- URUSAN --');
		
		$codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c !='00' and d='00' and e='00' and e1='000' ";
		$bidang = cmbQuery('cmbBidang',$selectedC,$codeAndNameBidang,'onchange=rkaPPKD31.refreshList(true);','-- BIDANG --');
		
		$codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d!='00' and e='00' and e1='000' ";
		$skpd= cmbQuery('cmbSKPD',$selectedD,$codeAndNameSKPD,'onchange=rkaPPKD31.refreshList(true);','-- SKPD --');
		
		$codeAndNameUnit = "select e, concat(e, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e!='00' and e1='000' ";
		$unit = cmbQuery('cmbUnit',$selectedE,$codeAndNameUnit,'onchange=rkaPPKD31.refreshList(true);','-- UNIT --');
		
		
		$codeAndNameSubUnit = "select e1, concat(e1, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and e='$selectedE' and e1!='000' ";
		$subunit = cmbQuery('cmbSubUnit',$selectedE1,$codeAndNameSubUnit,'onchange=rkaPPKD31.refreshList(true);','-- SUB UNIT --');
	
	
	
	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran) as max from view_rkbmd "));
	$maxID = $get1['max'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rkbmd where id_anggaran = '$maxID' "));
	$nomorUrutSebelumnya =  $get2['no_urut'];

	
	
	
	
	
	
	
	
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
			<tr>
			<td>UNIT</td>
			<td>:</td>
			<td style='width:86%;'>
			".$unit."
			</td>
			</tr>
			<tr>
			<td>SUB UNIT</td>
			<td>:</td>
			<td style='width:86%;'>
			".$subunit."
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
			
		
		if($cmbSubUnit != ''){
			$arrKondisi[] = "c1 = '$cmbUrusan'";
			$arrKondisi[] = "c = '$cmbBidang'";
			$arrKondisi[] = "d = '$cmbSKPD'";
			$arrKondisi[] = "e = '$cmbUnit'";
			$arrKondisi[] = "e1 = '$cmbSubUnit'";
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
			

			}elseif($cmbUnit != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$arrKondisi[] = "d = '$cmbSKPD'";
				$arrKondisi[] = "e = '$cmbUnit'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
			}elseif($cmbSKPD != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$arrKondisi[] = "d = '$cmbSKPD'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
			}elseif($cmbBidang != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
			}elseif($cmbUrusan != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$kondisiSKPD = "and c1='$cmbUrusan'";
			}
			$arrKondisi[] = "c1 !='0'";	
			$arrKondisi[] = "o1 !='0'";	
		
		
		
		if($this->jenisForm == 'PENYUSUNAN'){
			
			$getAllParent = mysql_query("select * from view_rka_ppkd_3_1 where id_tahap='$this->idTahap'  and o1 ='0' ");
			$angka = 1;
			if(!empty($kondisiProgram)){
						$kondisiProgram = " or ".$kondisiProgram;
					}else{
						
					}
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) { 
			 	 $$key = $value; 
				}
				$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where id_tahap = '$this->idTahap' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and rincian_perhitungan != ''   "));
				if($cekRekening == 0){
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'";
					 
				}else{
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "1=1 or id_anggaran = '$id_anggaran' ";
					
					$arrKondisi[] = " 1=1 $kondisiProgram";
				}
				
				
						
			}
			
			$arrKondisi[] = "id_tahap = '$this->idTahap' ";
			
		}elseif($this->jenisForm == 'VALIDASI'){
			$nomorUrutSebelumnya = $this->nomorUrut - 1;
			$getJenisTahapSebelumnya = mysql_fetch_array(mysql_query("select * from view_rka_ppkd_3_1 where no_urut = '$nomorUrutSebelumnya'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and o1 !='0' and  rincian_perhitungan !=''"));
			$jenisTahapSebelumnya = $getJenisTahapSebelumnya['jenis_form_modul'];
			$getAllTahapSebelumnya = mysql_query("select * from view_rka_ppkd_3_1 where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya' and o1 !='0' and (rincian_perhitungan !='' or f1 !='0' )  ");
			while($rows = mysql_fetch_array($getAllTahapSebelumnya)){
				if( $jenisTahapSebelumnya == "VALIDASI" && $rows['status_validasi'] != '1' ){
				  }else{
				  		 $cmbUrusanForm =$rows['c1'];
						 $cmbBidangForm = $rows['c'];
						 $cmbSKPDForm = $rows['d'];
						 $cmbUnitForm = $rows['e'];
						 $cmbSubUnitForm = $rows['e1'];
						 $k = $rows['k'];
						 $l = $rows['l'];
						 $m = $rows['m'];
						 $n = $rows['n'];
						 $o = $rows['o'];
						 $o1 = $rows['o1'];
						 $id_jenis_pemeliharaan = $rows['id_jenis_pemeliharaan'];
						 $tempID = $rows['id_anggaran'];
						 
						 if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where c1='0' and f1 = '0' and k = '$k' and l ='$l' and m='$m' and n='$n' and o='$o'  and id_tahap='$this->idTahap' ")) > 0){
				 	
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
												'jenis_rka' => '3.1',
												'tahun' => $this->tahun,
												'jenis_anggaran' => $this->jenisAnggaran,
												'id_tahap' => $this->idTahap,
												'nama_modul' => 'RKA-PPKD'
												);
							$queryRekening = VulnWalkerInsert('tabel_anggaran',$arrayRekening);
							mysql_query($queryRekening);
						}

						if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where c1='$cmbUrusanForm' and c='$cmbBidangForm' and d='$cmbSKPDForm' and e='$cmbUnitForm' and e1='$cmbSubUnitForm' and k = '$k' and l ='$l' and m='$m' and n='$n' and o='$o'  and o1='$o1' and f1='0' and rincian_perhitungan ='' and id_tahap='$this->idTahap' ")) > 0){
				 	
						 }else{
							$arrayPekerjaan = array(
												'c1' => $cmbUrusanForm,
												'c' => $cmbBidangForm,
												'd' => $cmbSKPDForm,
												'e' => $cmbUnitForm,
												'e1' => $cmbSubUnitForm,
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
												'o1' => $o1,
												'rincian_perhitungan' => '',
												'jenis_rka' => '3.1',
												'tahun' => $this->tahun,
												'jenis_anggaran' => $this->jenisAnggaran,
												'id_tahap' => $this->idTahap,
												'nama_modul' => 'RKA-PPKD'
												);
							$queryPekerjaan = VulnWalkerInsert('tabel_anggaran',$arrayPekerjaan);
							mysql_query($queryPekerjaan);
						}		
								
								
								$data = array( " status_validasi" => $status_validasi,
								 				'user_validasi' => $_COOKIE['coID'],
								 				'tanggal_validasi' => date("Y-m-d"),
												'id_tahap' => $this->idTahap
								 				);
								 $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$tempID'");
								 mysql_query($query);
				 	 }
								 
				
				}
				
				
			$getAllParent = mysql_query("select * from view_rka_ppkd_3_1 where id_tahap='$this->idTahap'  and o1 ='0'  ");
			$angka = 1;	
			
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) { 
			 	 $$key = $value; 
				}
				
				$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where id_tahap = '$this->idTahap' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and rincian_perhitungan != ''   "));
				if($cekRekening == 0){
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'";
					 
				}else{
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran = '$id_anggaran' ";
					//VulnWalker
						if(!empty($hiddenP)){

							$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and id_tahap = '$this->idTahap' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
							while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
								$chrootO1 = $chroot['o1'];
								$chrootIdAnggaran = $chroot['id_anggaran'];
								if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where id_tahap ='$this->idTahap' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
									$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran ='$chrootIdAnggaran'";
									
								}
								
							}
							if(!empty($q)){
								$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and id_tahap = '$this->idTahap' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
							while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
								$chrootO1 = $chroot['o1'];
								$chrootIdAnggaran = $chroot['id_anggaran'];
								if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where id_tahap ='$this->idTahap' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
									$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran ='$chrootIdAnggaran'";
									
								}
								
							}
							}

							}
						//VulnWalker
					
					
				}
		
				
			
					
				
						
			}
				
									
				$arrKondisi[] = "id_tahap = '$this->idTahap' ";
				
		}elseif($this->jenisForm == 'KOREKSI'){
			$nomorUrutSebelumnya = $this->nomorUrut - 1;
			$getAllParent = mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and o1 ='0'  ");
			$angka = 1;	
			
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) { 
			 	 $$key = $value; 
				}
				if($jenis_form_modul == "VALIDASI"){
					$kondisiFilter = " and status_validasi = '1' ";
					$getDataValidasi = mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and o1 !='0' and (rincian_perhitungan !='' or f1 !='0')");
					while($got = mysql_fetch_array($getDataValidasi)){
						if($got['status_validasi'] !='1'){
							$gotID = $got['id_anggaran'];
							$arrKondisi[] = " id_anggaran !='$gotID' ";
							$gotC1 = $got['c1'];
							$gotC= $got['c'];
							$gotD= $got['d'];
							$gotE = $got['e'];
							$gotE1 = $got['e1'];
							$gotK=$got['k'];
							$gotL = $got['l'];
							$gotM = $got['m'];
							$gotN = $got['n'];
							$gotO = $got['o'];
							$gotO1 = $got['o1'];
							$getDataPekerjaanValidasi = mysql_fetch_array(mysql_query("select * from view_rka_ppkd_3_1 where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and k='$gotK' and l='$gotL' and m='$gotM' and n='$gotN' and o ='$gotO' and o1='$gotO1' and rincian_perhitungan ='' and f1='0' and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
							$idValidasiPekerjaan = $getDataPekerjaanValidasi['id_anggaran'];
							if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and k='$gotK' and l='$gotL' and m='$gotM' and n='$gotN' and o ='$gotO' and o1='$gotO1'  and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and status_validasi ='1' and (rincian_perhitungan !='' or f1!='0')")) == 0){
								$arrKondisi[] = "id_anggaran !='$idValidasiPekerjaan'";
							}
							//$arrKondisi[] = "coba coba "."select * from view_rka_ppkd_3_1 where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and k='$gotK' and l='$gotL' and m='$gotM' and n='$gotN' and o ='$gotO' and o1='$gotO1'  and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and (rincian_perhitungan !='' or f1!='0')"."       coba coba  ";
						}
					}				
				}
				$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and rincian_perhitungan != '' $kondisiFilter   "));
				if($cekRekening == 0){
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'";
					 
				}else{
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  or id_anggaran = '$id_anggaran'  ";
					//VulnWalker
						if(!empty($hiddenP)){

							$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
							while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
								$chrootO1 = $chroot['o1'];
								$chrootIdAnggaran = $chroot['id_anggaran'];
								if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
									$arrKondisi[] = "no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' or id_anggaran ='$chrootIdAnggaran'";
									
								}
								
							}
							if(!empty($q)){
								$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
							while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
								$chrootO1 = $chroot['o1'];
								$chrootIdAnggaran = $chroot['id_anggaran'];
								if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
									$arrKondisi[] = "no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' or id_anggaran ='$chrootIdAnggaran'";
									
								}
								
							}
							}

							}
						//VulnWalker
					
					
				}
		
				
			
					
				
						
			}
			
			$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
			

		}else{
			if($this->jenisFormTerakhir == "KOREKSI"){
				$nomorUrutSebelumnya = $this->urutTerakhir - 1;
					$getAllParent = mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and o1 ='0'  ");
					$angka = 1;	
					
					while($rows = mysql_fetch_array($getAllParent)){
						foreach ($rows as $key => $value) { 
					 	 $$key = $value; 
						}
						
						if($jenis_form_modul == "VALIDASI"){
					$kondisiFilter = " and status_validasi = '1' ";
					$getDataValidasi = mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and o1 !='0' and (rincian_perhitungan !='' or f1 !='0')");
					while($got = mysql_fetch_array($getDataValidasi)){
						if($got['status_validasi'] !='1'){
							$gotID = $got['id_anggaran'];
							$arrKondisi[] = " id_anggaran !='$gotID' ";
							$gotC1 = $got['c1'];
							$gotC= $got['c'];
							$gotD= $got['d'];
							$gotE = $got['e'];
							$gotE1 = $got['e1'];
							$gotK=$got['k'];
							$gotL = $got['l'];
							$gotM = $got['m'];
							$gotN = $got['n'];
							$gotO = $got['o'];
							$gotO1 = $got['o1'];
							$getDataPekerjaanValidasi = mysql_fetch_array(mysql_query("select * from view_rka_ppkd_3_1 where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and k='$gotK' and l='$gotL' and m='$gotM' and n='$gotN' and o ='$gotO' and o1='$gotO1' and rincian_perhitungan ='' and f1='0' and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
							$idValidasiPekerjaan = $getDataPekerjaanValidasi['id_anggaran'];
							if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and k='$gotK' and l='$gotL' and m='$gotM' and n='$gotN' and o ='$gotO' and o1='$gotO1'  and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and status_validasi ='1' and (rincian_perhitungan !='' or f1!='0')")) == 0){
								$arrKondisi[] = "id_anggaran !='$idValidasiPekerjaan'";
							}
							//$arrKondisi[] = "coba coba "."select * from view_rka_ppkd_3_1 where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and k='$gotK' and l='$gotL' and m='$gotM' and n='$gotN' and o ='$gotO' and o1='$gotO1'  and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and (rincian_perhitungan !='' or f1!='0')"."       coba coba  ";
						}
					}				
				}
				$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and rincian_perhitungan != '' $kondisiFilter   "));
				if($cekRekening == 0){
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'";
					 
				}else{
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' or id_anggaran = '$id_anggaran' ";
							//VulnWalker
								if(!empty($hiddenP)){
		
									$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
									while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
										$chrootO1 = $chroot['o1'];
										$chrootIdAnggaran = $chroot['id_anggaran'];
										if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
											$arrKondisi[] = "tahun = '$this->tahun' or id_anggaran ='$chrootIdAnggaran'";
											
										}
										
									}
									if(!empty($q)){
										$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
									while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
										$chrootO1 = $chroot['o1'];
										$chrootIdAnggaran = $chroot['id_anggaran'];
										if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
											$arrKondisi[] = "tahun = '$this->tahun' or id_anggaran ='$chrootIdAnggaran'";
											
										}
										
									}
									}
		
									}
								//VulnWalker
							
							
						}
				
						
					
							
						
								
					}
				
				$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
			}elseif($this->jenisFormTerakhir == "VALIDASI"){
				$getAllParent = mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and o1 ='0'  ");
			$angka = 1;	

			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) { 
			 	 $$key = $value; 
				}
					
					
					$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and rincian_perhitungan != ''   "));
					if($cekRekening == 0){
						$concat = $k.".".$l.".".$m.".".$n.".".$o;
						$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'";
						 
					}else{
						$concat = $k.".".$l.".".$m.".".$n.".".$o;
						$arrKondisi[] = "no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' or id_anggaran = '$id_anggaran' ";
						//VulnWalker
							if(!empty($hiddenP)){
	
								$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
								while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
									$chrootO1 = $chroot['o1'];
									$chrootIdAnggaran = $chroot['id_anggaran'];
									if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
										$arrKondisi[] = "no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' or id_anggaran ='$chrootIdAnggaran'";
										
									}
									
								}
								if(!empty($q)){
									$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
								while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
									$chrootO1 = $chroot['o1'];
									$chrootIdAnggaran = $chroot['id_anggaran'];
									if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
										$arrKondisi[] = "no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' or id_anggaran ='$chrootIdAnggaran'";
										
									}
									
								}
								}
	
								}
							//VulnWalker
						
						
					}
			
	
							
				}
				$arrKondisi[] =  "no_urut = '$this->urutTerakhir'";
			}elseif($this->jenisFormTerakhir == "PENYUSUNAN"){
				$nomorUrutSebelumnya = $this->urutTerakhir ;
				
				
				$getAllParent = mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and o1 ='0' ");
				$angka = 1;
				if(!empty($kondisiProgram)){
						$kondisiProgram = " or ".$kondisiProgram;
					}else{
						
					}
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) { 
				 	 $$key = $value; 
					}
					$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and rincian_perhitungan != ''   "));
					if($cekRekening == 0){
						$concat = $k.".".$l.".".$m.".".$n.".".$o;
						$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'";
						
					}else{
						$concat = $k.".".$l.".".$m.".".$n.".".$o;
						$arrKondisi[] = "1=1 or id_anggaran = '$id_anggaran' ";
						$arrKondisi[] = " 1=1 $kondisiProgram";
					}
					
					
					
					
				}
				$arrKondisi[] = "no_urut = '$this->urutTerakhir' ";
			}
		}
		
  

		
		
	
		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi ;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		$arrOrders[] = "urut, rincian_perhitungan  asc";
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
		$grabSKPD = mysql_fetch_array(mysql_query("select * from skpd_report_rka_ppkd_31 where username='$this->username'"));
		foreach ($grabSKPD as $key => $value) { 
				  $$key = $value; 
			}
		$cmbUrusan = $c1;
		$cmbBidang = $c;
		$cmbSKPD = $d;
		$cmbUnit = $e;
		$cmbSubUnit = $e1;
		
		if($cmbSubUnit != ''){
			$arrKondisi[] = "c1 = '$cmbUrusan'";
			$arrKondisi[] = "c = '$cmbBidang'";
			$arrKondisi[] = "d = '$cmbSKPD'";
			$arrKondisi[] = "e = '$cmbUnit'";
			$arrKondisi[] = "e1 = '$cmbSubUnit'";
			$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'";
			

			}elseif($cmbUnit != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$arrKondisi[] = "d = '$cmbSKPD'";
				$arrKondisi[] = "e = '$cmbUnit'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' ";
			}elseif($cmbSKPD != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$arrKondisi[] = "d = '$cmbSKPD'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  ";
			}elseif($cmbBidang != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$arrKondisi[] = "c = '$cmbBidang'";
				$kondisiSKPD = "and c1='$cmbUrusan' and c='$cmbBidang'  ";
			}elseif($cmbUrusan != ''){
				$arrKondisi[] = "c1 = '$cmbUrusan'";
				$kondisiSKPD = "and c1='$cmbUrusan'";
			}
			$arrKondisi[] = "c1 !='0'";	
			$arrKondisi[] = "o1 !='0'";	
		
		
		

		if($this->jenisForm == 'PENYUSUNAN'){
			
			$getAllParent = mysql_query("select * from view_rka_ppkd_3_1 where id_tahap='$this->idTahap'  and o1 ='0' ");
			$angka = 1;
			if(!empty($kondisiProgram)){
						$kondisiProgram = " or ".$kondisiProgram;
					}else{
						
					}
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) { 
			 	 $$key = $value; 
				}
				$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where id_tahap = '$this->idTahap' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and rincian_perhitungan != ''   "));
				if($cekRekening == 0){
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'";
					 
				}else{
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "1=1 or id_anggaran = '$id_anggaran' ";
					
					$arrKondisi[] = " 1=1 $kondisiProgram";
				}
				
				
						
			}
			
			$arrKondisi[] = "id_tahap = '$this->idTahap' ";
			
		}elseif($this->jenisForm == 'VALIDASI'){
			
				
				
			$getAllParent = mysql_query("select * from view_rka_ppkd_3_1 where id_tahap='$this->idTahap'  and o1 ='0'  ");
			$angka = 1;	
			
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) { 
			 	 $$key = $value; 
				}
				
				$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where id_tahap = '$this->idTahap' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and rincian_perhitungan != ''   "));
				if($cekRekening == 0){
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'";
					 
				}else{
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran = '$id_anggaran' ";
					//VulnWalker
						if(!empty($hiddenP)){

							$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and id_tahap = '$this->idTahap' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
							while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
								$chrootO1 = $chroot['o1'];
								$chrootIdAnggaran = $chroot['id_anggaran'];
								if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where id_tahap ='$this->idTahap' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
									$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran ='$chrootIdAnggaran'";
									
								}
								
							}
							if(!empty($q)){
								$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and id_tahap = '$this->idTahap' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
							while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
								$chrootO1 = $chroot['o1'];
								$chrootIdAnggaran = $chroot['id_anggaran'];
								if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where id_tahap ='$this->idTahap' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
									$arrKondisi[] = "id_tahap = '$this->idTahap' or id_anggaran ='$chrootIdAnggaran'";
									
								}
								
							}
							}

							}
						//VulnWalker
					
					
				}
		
				
			
					
				
						
			}
				
									
				$arrKondisi[] = "id_tahap = '$this->idTahap' ";
				
		}elseif($this->jenisForm == 'KOREKSI'){
			$nomorUrutSebelumnya = $this->nomorUrut ;
			$getAllParent = mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and o1 ='0'  ");
			$angka = 1;	
			
			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) { 
			 	 $$key = $value; 
				}
				if($jenis_form_modul == "VALIDASI"){
					$kondisiFilter = " and status_validasi = '1' ";
					$getDataValidasi = mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and o1 !='0' and (rincian_perhitungan !='' or f !='00')");
					while($got = mysql_fetch_array($getDataValidasi)){
						if($got['status_validasi'] !='1'){
							$gotID = $got['id_anggaran'];
							$arrKondisi[] = " id_anggaran !='$gotID' ";
							$gotC1 = $got['c1'];
							$gotC= $got['c'];
							$gotD= $got['d'];
							$gotE = $got['e'];
							$gotE1 = $got['e1'];
							$gotK=$got['k'];
							$gotL = $got['l'];
							$gotM = $got['m'];
							$gotN = $got['n'];
							$gotO = $got['o'];
							$gotO1 = $got['o1'];
							$getDataPekerjaanValidasi = mysql_fetch_array(mysql_query("select * from view_rka_ppkd_3_1 where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and k='$gotK' and l='$gotL' and m='$gotM' and n='$gotN' and o ='$gotO' and o1='$gotO1' and rincian_perhitungan ='' and f='00' and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
							$idValidasiPekerjaan = $getDataPekerjaanValidasi['id_anggaran'];
							if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and k='$gotK' and l='$gotL' and m='$gotM' and n='$gotN' and o ='$gotO' and o1='$gotO1'  and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and status_validasi ='1' and (rincian_perhitungan !='' or f!='00')")) == 0){
								$arrKondisi[] = "id_anggaran !='$idValidasiPekerjaan'";
							}
							//$arrKondisi[] = "coba coba "."select * from view_rka_ppkd_3_1 where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and k='$gotK' and l='$gotL' and m='$gotM' and n='$gotN' and o ='$gotO' and o1='$gotO1'  and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and (rincian_perhitungan !='' or f!='00')"."       coba coba  ";
						}
					}				
				}
				$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and rincian_perhitungan != '' $kondisiFilter   "));
				if($cekRekening == 0){
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'";
					 
				}else{
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  or id_anggaran = '$id_anggaran'  ";
				}
		
				
			
					
				
						
			}
			
			$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
			

		}else{
			if($this->jenisFormTerakhir == "KOREKSI"){
				$nomorUrutSebelumnya = $this->urutTerakhir;
					$getAllParent = mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and o1 ='0'  ");
					$angka = 1;	
					
					while($rows = mysql_fetch_array($getAllParent)){
						foreach ($rows as $key => $value) { 
					 	 $$key = $value; 
						}
						
						if($jenis_form_modul == "VALIDASI"){
					$kondisiFilter = " and status_validasi = '1' ";
					$getDataValidasi = mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and o1 !='0' and (rincian_perhitungan !='' or f ='00')");
					while($got = mysql_fetch_array($getDataValidasi)){
						if($got['status_validasi'] !='1'){
							$gotID = $got['id_anggaran'];
							$arrKondisi[] = " id_anggaran !='$gotID' ";
							$gotC1 = $got['c1'];
							$gotC= $got['c'];
							$gotD= $got['d'];
							$gotE = $got['e'];
							$gotE1 = $got['e1'];
							$gotK=$got['k'];
							$gotL = $got['l'];
							$gotM = $got['m'];
							$gotN = $got['n'];
							$gotO = $got['o'];
							$gotO1 = $got['o1'];
							$getDataPekerjaanValidasi = mysql_fetch_array(mysql_query("select * from view_rka_ppkd_3_1 where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and k='$gotK' and l='$gotL' and m='$gotM' and n='$gotN' and o ='$gotO' and o1='$gotO1' and rincian_perhitungan ='' and f='00' and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'"));
							$idValidasiPekerjaan = $getDataPekerjaanValidasi['id_anggaran'];
							if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and k='$gotK' and l='$gotL' and m='$gotM' and n='$gotN' and o ='$gotO' and o1='$gotO1'  and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and status_validasi ='1' and (rincian_perhitungan !='' or f!='00')")) == 0){
								$arrKondisi[] = "id_anggaran !='$idValidasiPekerjaan'";
							}
							//$arrKondisi[] = "coba coba "."select * from view_rka_ppkd_3_1 where c1='$gotC1' and c='$gotC' and d='$gotD' and e='$gotE' and e1='$gotE1' and k='$gotK' and l='$gotL' and m='$gotM' and n='$gotN' and o ='$gotO' and o1='$gotO1'  and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and (rincian_perhitungan !='' or f!='00')"."       coba coba  ";
						}
					}				
				}
				$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and rincian_perhitungan != '' $kondisiFilter   "));
				if($cekRekening == 0){
					$concat = $k.".".$l.".".$m.".".$n.".".$o;
					$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'";
					 
				}else{
							$concat = $k.".".$l.".".$m.".".$n.".".$o;
							$arrKondisi[] = "no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' or id_anggaran = '$id_anggaran' ";
							//VulnWalker
								if(!empty($hiddenP)){
		
									$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
									while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
										$chrootO1 = $chroot['o1'];
										$chrootIdAnggaran = $chroot['id_anggaran'];
										if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
											$arrKondisi[] = "tahun = '$this->tahun' or id_anggaran ='$chrootIdAnggaran'";
											
										}
										
									}
									if(!empty($q)){
										$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
									while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
										$chrootO1 = $chroot['o1'];
										$chrootIdAnggaran = $chroot['id_anggaran'];
										if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
											$arrKondisi[] = "tahun = '$this->tahun' or id_anggaran ='$chrootIdAnggaran'";
											
										}
										
									}
									}
		
									}
								//VulnWalker
							
							
						}
				
						
					
							
						
								
					}
				
				$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
			}elseif($this->jenisFormTerakhir == "VALIDASI"){
				$getAllParent = mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and o1 ='0'  ");
			$angka = 1;	

			while($rows = mysql_fetch_array($getAllParent)){
				foreach ($rows as $key => $value) { 
			 	 $$key = $value; 
				}
					
					
					$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and rincian_perhitungan != ''   "));
					if($cekRekening == 0){
						$concat = $k.".".$l.".".$m.".".$n.".".$o;
						$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'";
						 
					}else{
						$concat = $k.".".$l.".".$m.".".$n.".".$o;
						$arrKondisi[] = "no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' or id_anggaran = '$id_anggaran' ";
						//VulnWalker
							if(!empty($hiddenP)){
	
								$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
								while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
									$chrootO1 = $chroot['o1'];
									$chrootIdAnggaran = $chroot['id_anggaran'];
									if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
										$arrKondisi[] = "no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' or id_anggaran ='$chrootIdAnggaran'";
										
									}
									
								}
								if(!empty($q)){
									$getCheckingPekerjaan =  mysql_query("select * from view_rka_ppkd_3_1 where concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat' and no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1 !='0' and rincian_perhitungan ='' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit'") ;
								while($chroot = mysql_fetch_array($getCheckingPekerjaan)){
									$chrootO1 = $chroot['o1'];
									$chrootIdAnggaran = $chroot['id_anggaran'];
									if(mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and o1= '$chrootO1' and concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'  and rincian_perhitungan != '' $kondisiSKPD")) > 0){
										$arrKondisi[] = "no_urut='$this->urutTerakhir' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' or id_anggaran ='$chrootIdAnggaran'";
										
									}
									
								}
								}
	
								}
							//VulnWalker
						
						
					}
			
	
							
				}
				$arrKondisi[] =  "no_urut = '$this->urutTerakhir'";
			}elseif($this->jenisFormTerakhir == "PENYUSUNAN"){
				$nomorUrutSebelumnya = $this->urutTerakhir ;
				
				
				$getAllParent = mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and o1 ='0' ");
				$angka = 1;
				if(!empty($kondisiProgram)){
						$kondisiProgram = " or ".$kondisiProgram;
					}else{
						
					}
				while($rows = mysql_fetch_array($getAllParent)){
					foreach ($rows as $key => $value) { 
				 	 $$key = $value; 
					}
					$cekRekening = mysql_num_rows(mysql_query("select * from view_rka_ppkd_3_1 where no_urut='$nomorUrutSebelumnya' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'  and k='$k' and l='$l' and m='$m' and n='$n' and o='$o' $kondisiSKPD and rincian_perhitungan != ''   "));
					if($cekRekening == 0){
						$concat = $k.".".$l.".".$m.".".$n.".".$o;
						$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) != '$concat'";
						
					}else{
						$concat = $k.".".$l.".".$m.".".$n.".".$o;
						$arrKondisi[] = "1=1 or id_anggaran = '$id_anggaran' ";
						$arrKondisi[] = " 1=1 $kondisiProgram";
					}
					
					
					
					
				}
				$arrKondisi[] = "no_urut = '$this->urutTerakhir' ";
			}
		}
  

		
		
	
		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";
		
		$Kondisi= join(' and ',$arrKondisi);
		/*if(sizeof($arrKondisi) == 0){
			$Kondisi= '';
		}else{
			$Kondisi = " and ".$Kondisi;
		}*/
		$qry ="select * from view_rka_ppkd_3_1 where $Kondisi ";
		$aqry = mysql_query($qry);
		$getKuasapenggunaBarang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		$kuasaPenggunaBarang = $getKuasapenggunaBarang['nm_skpd'];		
		
		$getUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$cmbUrusan' and c='00'"));
		$urusan = $getUrusan['nm_skpd'];
		$getBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='00'"));
		$bidang = $getBidang['nm_skpd'];
		$getSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='00'"));
		$skpd = $getBidang['nm_skpd'];
		$getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' "));
		$subUnit = $getSubUnit['nm_skpd'];
		$getProgram = mysql_fetch_array(mysql_query("select * from ref_program where bk='$hublaBK' and ck='$hublaCK' and dk='0' and p='$hublaP' and q='0'"));
		$program = $getProgram['nama'];
		$getKegiatan = mysql_fetch_array(mysql_query("select * from ref_program where bk='$hublaBK' and ck='$hublaCK' and dk='0' and p='$hublaP' and q='$hublaQ'"));
		$kegiatan = $getKegiatan['nama'];

		
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
					<table class=\"rangkacetak\" style='width:80%;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\"> <div style='text-align:center;'>
				<span style='font-size:18px;font-weight:bold;text-decoration: '>
					RENCANA KERJA DAN ANGGARAN<br>
					PEJABAT PENGELOLA KEUANGAN DAERAH 
				</span><br>
				<span style='font-size:14px;font-weight:text-decoration: '>
					PROVINSI/Kabupaten/Kota......<br>
					Tahun Anggaran $this->tahun 
				</span><br>

				
				<br>
				
				
				";
		echo "
				<span style='font-size:16px;font-weight:bold;text-decoration: '>
					Rincian Penerimaan Pembiayaan
				</span><br>
								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
										<th class='th01'  colspan='5' >KODE REKENING</th>
										<th class='th01' >URAIAN</th>
										<th class='th01'  >JUMLAH (Rp)</th>
										
									</tr>

								
									
		";
		$getTotal = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_ppkd_3_1 where $Kondisi  "));
		$total = number_format($getTotal['sum(jumlah_harga)'],2,',','.');
		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) { 
				  $$key = $value; 
			} 
			if($o1 == 0){
				$getNamaRekening = mysql_fetch_array(mysql_query("select * from ref_rekening where k='$k' and l='$l' and m='$m' and n='$n' and o='$o'"));
				$uraian = "<b>".$getNamaRekening['nm_rekening']."</b>";
				$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_ppkd_3_1 where $Kondisi and k = '$k' and l='$l' and m='$m' and n='$n' and o='$o'  "));
				$jumlah_harga = "<b>".number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.');
			}elseif($rincian_perhitungan == ''){
				$k = "";
				$l = "";
				$m = "";
				$n = "";
				$o = "";
				$getPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$o1' "));
				$uraian = "<span style='margin-left:5px;'> - ". $getPekerjaan['nama_pekerjaan'] . "</span>";
				$getSumJumlahHarga = mysql_fetch_array(mysql_query("select sum(jumlah_harga) from view_rka_ppkd_3_1 where $Kondisi and o1 ='$o1'  "));
				$jumlah_harga = number_format($getSumJumlahHarga['sum(jumlah_harga)'],2,',','.');
			}else{
				$k = "";
				$l = "";
				$m = "";
				$n = "";
				$o = "";
				
				$uraian = "<span style='margin-left:20px;'> ". $rincian_perhitungan . "</span>";
				$jumlah = number_format($jumlah,2,',','.');
				$jumlah_harga = number_format($jumlah_harga,2,',','.');
				$volume_rek = number_format($volume_rek,0,',','.');
				
			}
			
			echo "
								<tr valign='top'>
									<td align='center' class='GarisCetak' >".$k."</td>
									<td align='center' class='GarisCetak' >".$l."</td>
									<td align='center' class='GarisCetak' >".$m."</td>
									<td align='center' class='GarisCetak' >".$n."</td>
									<td align='center' class='GarisCetak' >".$o."</td>
									<td align='left' class='GarisCetak' >".$uraian."</td>
									<td align='right' class='GarisCetak' >".$jumlah_harga."</td>
								</tr>
			";
			$no++;
			
			
			
			
		}
		echo 				"<tr valign='top'>
									<td align='right' colspan='6' class='GarisCetak'>Jumlah Penerimaan</td>
									<td align='right' class='GarisCetak' ><b>".$total."</b></td>
									
								</tr>
							 </table>";		
		echo 			
						"<br><div class='ukurantulisan'>
					<table width='100%'>
						<tr>
							<td class='ukurantulisan' valign='top' ></td>
							<td class='ukurantulisan' valign='top' width='70%' ></td>
							<td class='ukurantulisan' valign='top'><span style='margin-left:5px;'>Bandung, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</span></td>
						</tr>
						<tr>
							<td class='ukurantulisan' valign='top' ><span style='margin-left:5px;'>&nbsp
<br><br><br><br><br></span></td>
							<td class='ukurantulisan' valign='top' width='50%' ></td>
							<td class='ukurantulisan' valign='top' ><span style='margin-left:5px;'>PPKD
</span></td>
						</tr>
						<tr>
							<td class='ukurantulisan'>
								<table width='100%'>
									<tr>
										<td class='ukurantulisan' width='75px'>&nbsp</td>
										<td class='ukurantulisan'>&nbsp</td>
										<td class='ukurantulisan'>&nbsp</td>
									</tr>
									<tr>
										<td class='ukurantulisan'>&nbsp</td>
										<td class='ukurantulisan'> &nbsp </td>
										<td class='ukurantulisan'>&nbsp</td>
									</tr>
								</table>
							</td>
							<td class='ukurantulisan'></td>
							<td class='ukurantulisan'>
								<table width='100%'>
									<tr>
										<td class='ukurantulisan'><u>Nama Lengkap</u></td>
										<td class='ukurantulisan'></td>
										<td class='ukurantulisan'></td>
									</tr>
									<tr>
										<td class='ukurantulisan'>NIP</td>
										<td class='ukurantulisan'></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div></div>	</td></tr>
					</table>
				</div>	
			</body>	
		</html>";
	}	
}
$rkaPPKD31 = new rkaPPKD31Obj();

$arrayResult = VulnWalkerTahap($rkaPPKD31->modul);
$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = $arrayResult['jenisAnggaran'];
$idTahap = $arrayResult['idTahap'];

$rkaPPKD31->jenisForm = $jenisForm;
$rkaPPKD31->nomorUrut = $nomorUrut;
$rkaPPKD31->tahun = $tahun;
$rkaPPKD31->jenisAnggaran = $jenisAnggaran;
$rkaPPKD31->idTahap = $idTahap;


if(empty($rkaPPKD31->tahun)){
    
	$get1 = mysql_fetch_array(mysql_query("select max(id_anggaran)  from view_rka_ppkd_3_1 "));
	$maxAnggaran = $get1['max(id_anggaran)'];
	$get2 = mysql_fetch_array(mysql_query("select * from view_rka_ppkd_3_1 where id_anggaran = '$maxAnggaran'"));
	/*$rkaPPKD31->tahun = "select max(id_anggaran) as max from view_rka_ppkd_3_1 where nama_modul = 'rkaPPKD31'";*/
	$rkaPPKD31->tahun  = $get2['tahun'];
	$rkaPPKD31->jenisAnggaran = $get2['jenis_anggaran'];
	$rkaPPKD31->urutTerakhir = $get2['no_urut'];
	$rkaPPKD31->jenisFormTerakhir = $get2['jenis_form_modul'];
	$rkaPPKD31->urutSebelumnya = $rkaPPKD31->urutTerakhir - 1;
	
	
	$idtahapTerakhir = $get2['id_tahap'];
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$idtahapTerakhir'"));
	$rkaPPKD31->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaPPKD31->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
	
	$arrayHasil =  VulnWalkerLASTTahap();
	$rkaPPKD31->currentTahap = $arrayHasil['currentTahap'];
}else{
	$getCurrenttahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$rkaPPKD31->idTahap'"));
	$rkaPPKD31->currentTahap = $getCurrenttahap['nama_tahap'];
	
	$namaTahap = mysql_fetch_array(mysql_query("select * from ref_tahap_anggaran where id_tahap = '$rkaPPKD31->idTahap'"));
	$rkaPPKD31->jenisFormTerakhir =  $namaTahap['jenis_form_modul'];
	$rkaPPKD31->namaTahapTerakhir = $namaTahap['nama_tahap'];
	$arrayMasa = explode("-",$namaTahap['tanggal_mulai']);
	$lastTanggalMulai = $arrayMasa[2]."-".$arrayMasa[1]."-".$arrayMasa[0];
	$arrayMasa2 = explode("-",$namaTahap['tanggal_selesai']);
	$lastTanggalSelesai = $arrayMasa2[2]."-".$arrayMasa2[1]."-".$arrayMasa2[0];
	$rkaPPKD31->masaTerakhir = $lastTanggalMulai." JAM : ".$namaTahap['jam_mulai']."  s/d  ".$lastTanggalSelesai." JAM : ".$namaTahap['jam_selesai'];
}


?>