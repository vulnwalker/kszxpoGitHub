<?php

class renjaKeuanganSKPKDObj  extends DaftarObj2{
	var $Prefix = 'renjaKeuanganSKPKD';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_renja'; //bonus
	var $TblName_Hapus = 'renjaKeuanganSKPKD';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id_anggaran');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 14, 14);//berdasar mode
	var $FieldSum_Cp2 = array( 0, 0, 0);
	var $checkbox_rowspan = 1;
	var $PageTitle = 'RENCANA KERJA';
	var $PageIcon = 'images/perencanaan_ico.png';
	var $pagePerHal ='';
	var $fileNameExcel='renjaKeuanganSKPKD.xls';
	var $namaModulCetak='DAFTAR renjaKeuanganSKPKD';
	var $Cetak_Judul = 'DAFTAR renjaKeuanganSKPKD';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'renjaKeuanganSKPKDForm';
	var $TampilFilterColapse = 0; //0
	var $modul = "RENJA";
	var $jenisForm = "";
	var $tahun = "";
	var $nomorUrut = "";
	var $jenisAnggaran = "";
	var $idTahap = "";
	var $namaTahapTerakhir = "";
	var $masaTerakhir = "";
    //untuk view
	var $urutTerakhir = "";
	var $urutSebelumnya = "";
	var $jenisFormTerakhir = "";
	var $tahapTerakhir = "";

	var $username = "";

	var $wajibValidasi = "";
	var $sqlValidasi = "";
	//untuk view
	var $currentTahap = "";
	var $settingAnggaran = "";

	function setTitle(){

		return 'RENCANA KERJA SKPD '.$this->jenisAnggaran.' TAHUN '.$this->tahun;
	}

	function setMenuEdit(){

		 if($this->wajibValidasi == TRUE){
		 	$tergantung = "<td>".genPanelIcon("javascript:".$this->Prefix.".Validasi()","validasi-menu.png","Validasi", 'Validasi')."</td>";
		 }
		 if ($this->jenisForm == "PENYUSUNAN"){
		 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".InputBaru()","sections.png","Baru ", 'Baru ')."</td>".
						"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
						"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>".
						$tergantung."
						<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
						;
			if($this->settingAnggaran != "MURNI"){
					$listMenu =

				"<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
				}
		 }elseif ($this->jenisForm == "KOREKSI"){
		 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
		 }else{
		 	$listMenu = "<td>".genPanelIcon("javascript:".$this->Prefix.".Info()","info.png","Info", 'Info')."</td>";
		 }


		 return $listMenu;
	}
	function setMenuView(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";

	}
	  function setPage_HeaderOther(){

	return
			"";
	}
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];

	 foreach ($_REQUEST as $key => $value) {
		  $$key = $value;
	 }

	$tanggalMulai = explode("-",$tanggalMulai);
	$tanggalMulai = $tanggalMulai[2]."-".$tanggalMulai[1]."-".$tanggalMulai[0];
	$tanggalSelesai = explode("-",$tanggalSelesai);
	$tanggalSelesai = $tanggalSelesai[2]."-".$tanggalSelesai[1]."-".$tanggalSelesai[0];

			if($fmST == 0){
				if($err==''){



				}
			}else{
				if($err==''){


					}
			}

			return	array ('cek'=>$aqry, 'err'=>$err, 'content'=>$content);
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

		case 'postReport':{
			 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 if($fmSKPDUrusan == '00'){
			 	$err = "Pilih Urusan";
			 }elseif($fmSKPDBidang== '00') {
			 	$err = "Pilih Bidang";
			 }elseif($fmSKPDskpd == '00'){
			 	$err = "Pilih SKPD";
			 }
			 $data = array(
			 				'c1' => $fmSKPDUrusan,
							'c' => $fmSKPDBidang,
							'd' => $fmSKPDskpd,
							'username' => $this->username
			 				);
			if(mysql_num_rows(mysql_query("select * from skpd_report_renja where username= '$this->username'")) == 0){
				$query = VulnWalkerInsert('skpd_report_renja', $data);
			}else{
				$query = VulnWalkerUpdate('skpd_report_renja', $data, "username = '$this->username'");
			}
			mysql_query($query);

		break;
		}

		case 'Laporan':{
		$json = FALSE;


		if($xls){
			header("Content-type: application/msexcel");
			header("Content-Disposition: attachment; filename=$this->fileNameExcel");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		$get = mysql_fetch_array(mysql_query("select * from skpd_report_renja where username = '$this->username'"));
		$ref_skpdSkpdfmUrusan= $get['c1'];
		$ref_skpdSkpdfmSKPD = $get['c'];
		$ref_skpdSkpdfmUNIT = $get['d'];


		if($ref_skpdSkpdfmUrusan!='0' and $ref_skpdSkpdfmUrusan !='' and $ref_skpdSkpdfmUrusan!='00' ){
			$arrKondisi[]= "c1='$ref_skpdSkpdfmUrusan'";
			if($ref_skpdSkpdfmSKPD!='00' and $ref_skpdSkpdfmSKPD !=''  )$arrKondisi[]= "c='$ref_skpdSkpdfmSKPD'";

			if($ref_skpdSkpdfmSKPD!='00'){

			if($ref_skpdSkpdfmUNIT!='00' and $ref_skpdSkpdfmUNIT !='' )$arrKondisi[]= "d='$ref_skpdSkpdfmUNIT'";
			}
		}

		if($this->jenisForm == 'PENYUSUNAN'){
			$arrKondisi[] = " tahun = '$this->tahun'";
			$arrKondisi[] = " jenis_anggaran = '$this->jenisAnggaran'";
			$arrKondisi[] =  " no_urut = '$this->nomorUrut'";
		}elseif($this->jenisForm == 'KOREKSI'){
			$nomorUrutSebelumnya = $this->nomorUrut - 1;
			$beforeThis = mysql_fetch_array(mysql_query("select * from view_renja where no_urut = '$nomorUrutSebelumnya' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'"));
			$getAllTahapSebelumnya = mysql_query("select * from view_renja where q !='00' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya'   ");
			$arrayID = array();
			while($rows = mysql_fetch_array($getAllTahapSebelumnya)){
				$id_anggaran = $rows['id_anggaran'];
				$c1 = $rows['c1'];
				$c = $rows['c'];
				$d = $rows['d'];
				$e = $rows['e'];
				$e1 = $rows['e1'];
				$bk = $rows['bk'];
				$ck = $rows['ck'];
				$dk = $rows['dk'];
				$p = $rows['p'];
				$q = $rows['q'];
				if($beforeThis['jenis_form_modul'] == 'PENYUSUNAN' && $this->wajibValidasi == TRUE ){
					if($rows['status_validasi'] !='1' && $q != '00' ){
						$arrKondisi[] = " id_anggaran !='$id_anggaran' ";
						$arrayID[] = " id_anggaran !='$id_anggaran' ";
						array_push($arrayID,$id_anggaran);
						$Condition= join(' and ',$arrayID);
						$Condition = $Condition =='' ? '':' Where '.$Condition;

									$resultProgram = mysql_num_rows(mysql_query("select * from view_renja $Condition and q !='00' and c1 ='$c1' and c = '$c' and d='$d' and e = '$e' and e1 = '$e1' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
									if($resultProgram == 0){
									    $concat = $c1.'.'.$c.'.'.$d.'.'.$e.'.'.$e1.'.'.$bk.'.'.$ck.'.'.$dk.'.'.$p;
										$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat' ";
											$resultSubUnit = mysql_num_rows(mysql_query("select * from view_renja $Condition and q !='00' and c1 ='$c1' and c = '$c' and d='$d' and e = '$e' and e1 = '$e1' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
											if($resultSubUnit == 0){
											    $concat = $c1.'.'.$c.'.'.$d.'.'.$e.'.'.$e1;
												$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat' ";
												$resultUnit = mysql_num_rows(mysql_query("select * from view_renja $Condition and q !='00' and c1 ='$c1' and c = '$c' and d='$d' and e = '$e' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
												if($resultUnit == 0){
												    $concat = $c1.'.'.$c.'.'.$d.'.'.$e;
													$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e) != '$concat' ";
													$resultSKPD = mysql_num_rows(mysql_query("select * from view_renja $Condition and q !='00' and c1 ='$c1' and c = '$c' and d='$d' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
													if($resultSKPD == 0){
													    $concat = $c1.'.'.$c.'.'.$d;
														$arrKondisi[] = "concat(c1,'.',c,'.',d) != '$concat' ";
														$resultBidang = mysql_num_rows(mysql_query("select * from view_renja $Condition and q !='00' and c1 ='$c1' and c = '$c' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
														if($resultBidang  == 0){
														    $concat = $c1.'.'.$c;
															$arrKondisi[] = "concat(c1,'.',c) != '$concat' ";
															$resultUrusan = mysql_num_rows(mysql_query("select * from view_renja $Condition and q !='00' and c1 ='$c1'  and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
															if($resultUrusan  == 0){
															 	$concat = $c1;
																$arrKondisi[] = "c1 != '$concat' ";
															}
														}
													}
												}
											}
									}





					}
				}
			}

			$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";

		}else{
					if($this->jenisFormTerakhir == "KOREKSI"){
						$nomorUrutSebelumnya = $this->urutTerakhir - 1;
					$beforeThis = mysql_fetch_array(mysql_query("select * from view_renja where no_urut = '$nomorUrutSebelumnya' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'"));
					$getAllTahapSebelumnya = mysql_query("select * from view_renja where q !='00' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$nomorUrutSebelumnya'   ");
					$arrayID = array();
					while($rows = mysql_fetch_array($getAllTahapSebelumnya)){
						$id_anggaran = $rows['id_anggaran'];
						$c1 = $rows['c1'];
						$c = $rows['c'];
						$d = $rows['d'];
						$e = $rows['e'];
						$e1 = $rows['e1'];
						$bk = $rows['bk'];
						$ck = $rows['ck'];
						$dk = $rows['dk'];
						$p = $rows['p'];
						$q = $rows['q'];
						if($beforeThis['jenis_form_modul'] == 'PENYUSUNAN' && $this->wajibValidasi == TRUE ){
							if($rows['status_validasi'] !='1' && $q != '00' ){
								$arrKondisi[] = " id_anggaran !='$id_anggaran' ";
								$arrayID[] = " id_anggaran !='$id_anggaran' ";
								array_push($arrayID,$id_anggaran);
								$Condition= join(' and ',$arrayID);
								$Condition = $Condition =='' ? '':' Where '.$Condition;

											$resultProgram = mysql_num_rows(mysql_query("select * from view_renja $Condition and q !='0' and c1 ='$c1' and c = '$c' and d='$d' and e = '$e' and e1 = '$e1' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p = '$p' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
											if($resultProgram == 0){
											    $concat = $c1.'.'.$c.'.'.$d.'.'.$e.'.'.$e1.'.'.$bk.'.'.$ck.'.'.$dk.'.'.$p;
												$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',bk,'.',ck,'.',dk,'.',p) != '$concat' ";
												$resultSubUnit = mysql_num_rows(mysql_query("select * from view_renja $Condition and q !='0' and c1 ='$c1' and c = '$c' and d='$d' and e = '$e' and e1 = '$e1' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
												if($resultSubUnit == 0){
												    $concat = $c1.'.'.$c.'.'.$d.'.'.$e.'.'.$e1;
													$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat' ";
													$resultUnit = mysql_num_rows(mysql_query("select * from view_renja $Condition and q !='0' and c1 ='$c1' and c = '$c' and d='$d' and e = '$e' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
													if($resultUnit == 0){
													    $concat = $c1.'.'.$c.'.'.$d.'.'.$e;
														$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',e) != '$concat' ";
														$resultSKPD = mysql_num_rows(mysql_query("select * from view_renja $Condition and q !='0' and c1 ='$c1' and c = '$c' and d='$d' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
														if($resultSKPD == 0){
														    $concat = $c1.'.'.$c.'.'.$d;
															$arrKondisi[] = "concat(c1,'.',c,'.',d) != '$concat' ";
															$resultBidang = mysql_num_rows(mysql_query("select * from view_renja $Condition and q !='0' and c1 ='$c1' and c = '$c' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
															if($resultBidang  == 0){
															    $concat = $c1.'.'.$c;
																$arrKondisi[] = "concat(c1,'.',c) != '$concat' ";
																$resultUrusan = mysql_num_rows(mysql_query("select * from view_renja $Condition and q !='0' and c1 ='$c1'  and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut = '$nomorUrutSebelumnya' "));
																if($resultUrusan  == 0){
																 	$concat = $c1;
																	$arrKondisi[] = "c1 != '$concat' ";
																}
															}
														}
													}
												}
											}





							}
						}
					}

					$arrKondisi[] =  "no_urut = '$nomorUrutSebelumnya' ";
			}elseif($this->jenisFormTerakhir == "VALIDASI"){
					$arrKondisi[] =  "no_urut = '$this->urutTerakhir'";
			}else{
					$arrKondisi[] =  "no_urut = '$this->urutTerakhir'";
			}
		}


		//hidden if fucking colomn is empty
		$queryGetAll = "select * from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' ";
		$execute = mysql_query($queryGetAll);
		while($rows = mysql_fetch_array($execute)){
			$c1 = $rows['c1'];
			$c = $rows['c'];
			$d = $rows['d'];
			$e = $rows['e'];
			$e1 = $rows['e1'];
			$p = $rows['p'];
			$q = $rows['q'];
			$getUrusan = mysql_num_rows(mysql_query("select * from view_renja where c1 = '$c1' and c !='00' and d !='00' and e !='00' and e1 !='000' and p!='0' and q !='0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'"));
			if($getUrusan > 0){
				$queryGetBidang = "select * from view_renja where c1='$c1' and c = '$c'  and d != '00' and e !='00' and e1 !='000' and p!='0' and q !='0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'";
				$getBidang = mysql_num_rows(mysql_query($queryGetBidang));
				if($getBidang > 0){
					$queryGetSKPD = "select * from view_renja where c1='$c1' and c = '$c'  and d = '$d' and e != '00' and e1 !='000' and p!='0' and q !='0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'";
					$getSKPD = mysql_num_rows(mysql_query($queryGetSKPD));
					if($getSKPD > 0){
						$queryGetUNIT = "select * from view_renja where c1='$c1' and c = '$c'  and d = '$d' and e = '$e' and e1 !='000' and p!='0' and q !='0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'";
						$getUNIT = mysql_num_rows(mysql_query($queryGetUNIT));
						if($getUNIT > 0){
							$queryGetSUBUNIT = "select * from view_renja where c1='$c1' and c = '$c'  and d = '$d' and e= '$e' and e1 ='$e1' and p!='0' and q !='0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'";
							$getSUBUNIT = mysql_num_rows(mysql_query($queryGetSUBUNIT));
							if($getSUBUNIT > 0){
								$queryGetPROGRAM = "select * from view_renja where c1='$c1' and c = '$c'  and d = '$d' and e= '$e' and e1 ='$e1' and p='$p' and q !='0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran'";
								$getPROGRAM = mysql_num_rows(mysql_query($queryGetPROGRAM));
								if($getPROGRAM > 0){

								}else{
									if($p == '0'){
									$concat = ".....";
									}else{
										$concat = $c1.".".$c.".".$d.".".$e.".".$e1.".".$p;
									}
									$arrKondisi[] = " concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',p) != '$concat' ";
								}
							}else{
								if($e1 == '000'){
								$concat = "....";
								}else{
									$concat = $c1.".".$c.".".$d.".".$e.".".$e1;
								}
								$arrKondisi[] = " concat(c1,'.',c,'.',d,'.',e,'.',e1) != '$concat' ";
							}
						}else{
							if($e == '00'){
								$concat = "...";
							}else{
								$concat = $c1.".".$c.".".$d.".".$e;
							}
							$arrKondisi[] = " concat(c1,'.',c,'.',d,'.',e) != '$concat' ";
						}
					}else{
						if($d == '00'){
							$concat = "..";
						}else{
							$concat = $c1.".".$c.".".$d;
						}
						$arrKondisi[] = " concat(c1,'.',c,'.',d) != '$concat' ";
					}
				}else{
					if($c == '00'){
						$concat = ".";
					}else{
						$concat = $c1.".".$c;
					}
					$arrKondisi[] = " concat(c1,'.',c) != '$concat' ";
				}
			}else{
				$arrKondisi[] = " c1 !='$c1' ";
			}

		}
		//hidden if fucking colomn is empty
		$arrKondisi[] = "tahun = '$this->tahun'";
		$arrKondisi[] = "jenis_anggaran = '$this->jenisAnggaran'";

		/*$arrKondisi[] = " no_urut = '$this->nomorUrut' ";*/
		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		$getMaxIDTahap = mysql_fetch_array(mysql_query("select max(id_tahap) from view_renja"));
		$idTahap = $getMaxIDTahap['max(id_tahap)'];
		$qry ="select * from view_renja $Kondisi order by urut";
		$aqry = mysql_query($qry);


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
					<table class=\"rangkacetak\" style='width:90%;font-family:Times New Roman;margin-left:2cm;margin-top:2cm;'>
						<tr>
							<td valign=\"top\">".
								$this->JudulLaporan($dari, $sampai, 'DAFTAR PENERIMAAN BARANG').
								$this->LaporanTmplSKPD($get['c1'],$get['c'],$get['d']);

		//echo $qry;
		echo "
								<br>
								<table table width='100%' class='cetak' border='1' style='margin:4 0 0 0;width:100%;'>
									<tr>
										<th class='th01' style='width:20px;' >NO</th>
										<th class='th01' >KODE</th>
										<th class='th01' >NAMA URUSAN PEMERINTAHAN, ORGANISASI, PROGRAM DAN KEGIATAN</th>

									</tr>

		";

		$pid = '';
		$no_cek = 0;
		$no = 1;
		while($daqry = mysql_fetch_array($aqry)){
			foreach ($daqry as $key => $value) {
				  $$key = $value;
			}
			$arrayKode = explode(".",$urut);
		 if($c == '00' && $d =='00' && $e=='00' && $e1=='000' && $bk == '0' && $ck =='0' && $dk =='0' && $p =='0' && $q=='0'  ){
		    $get  = mysql_fetch_array(mysql_query("select nm_skpd from ref_skpd where c1='$c1' and c='00' and d = '00' and e='00' and e1='000'" ));
			$nama_skpd = "<span style='font-weight:bold;'>". $get['nm_skpd'] ."</span>";
			$getJumlah = mysql_fetch_array(mysql_query("select sum(jumlah) as jumlah from view_renja where q!='0' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and id_tahap = '$idTahap'"));
			$jumlah = $getJumlah['jumlah'];
			$kode = $c1;
		 }elseif($c != '00' && $d =='00' && $e=='00' && $e1=='000' && $bk == '0' && $ck =='0' && $dk =='0' && $p =='0' && $q=='0'  ){
		 	 $get  = mysql_fetch_array(mysql_query("select nm_skpd from ref_skpd where c1='$c1' and c='$c' and d = '00' and e='00' and e1='000'" ));
			 $nama_skpd = "<span style='font-weight:bold; margin-left:5px;'>". $get['nm_skpd'] ."</span>";
			 $getJumlah = mysql_fetch_array(mysql_query("select sum(jumlah) as jumlah from view_renja where q!='0' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c ='$c' and id_tahap = '$idTahap'"));
			 $jumlah = $getJumlah['jumlah'];
			 $kode = $c1.".".$c;

		 }elseif($c != '00' && $d !='00' && $e=='00' && $e1=='000' && $bk == '0' && $ck =='0' && $dk =='0' && $p =='0' && $q=='0'  ){
		 	 $get  = mysql_fetch_array(mysql_query("select nm_skpd from ref_skpd where c1='$c1' and c='$c' and d = '$d' and e='00' and e1='000'" ));
			 $nama_skpd = "<span style='font-weight:bold; margin-left:10px;'>". $get['nm_skpd'] ."</span>";
			 $getJumlah = mysql_fetch_array(mysql_query("select sum(jumlah) as jumlah from view_renja where q!='0' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c ='$c' and d='$d' and id_tahap = '$idTahap'"));
			 $jumlah = $getJumlah['jumlah'];
			 $kode = $c1.".".$c.".".$d;
		 }elseif($c != '00' && $d !='00' && $e!='00' && $e1=='000' && $bk == '0' && $ck =='0' && $dk =='0' && $p =='0' && $q=='0'  ){
		 	 $get  = mysql_fetch_array(mysql_query("select nm_skpd from ref_skpd where c1='$c1' and c='$c' and d = '$d' and e='$e' and e1='000'" ));
			 $nama_skpd = "<span style='font-weight:bold; margin-left:15px;'>". $get['nm_skpd'] ."</span>";
			 $getJumlah = mysql_fetch_array(mysql_query("select sum(jumlah) as jumlah from view_renja where q!='0' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c ='$c' and d='$d' and e = '$e' and id_tahap = '$idTahap'"));
			 $jumlah = $getJumlah['jumlah'];
			 $kode = $c1.".".$c.".".$d.".".$e;
		 }elseif($c != '00' && $d !='00' && $e!='00' && $e1!='000' && $bk == '0' && $ck =='0' && $dk =='0' && $p =='0' && $q=='0'  ){
		 	 $get  = mysql_fetch_array(mysql_query("select nm_skpd from ref_skpd where c1='$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1'" ));
			 $nama_skpd = "<span style='font-weight:bold; margin-left:20px;'>". $get['nm_skpd'] ."</span>";
			 $getJumlah = mysql_fetch_array(mysql_query("select sum(jumlah) as jumlah from view_renja where q!='0' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c ='$c' and d='$d' and e='$e' and e1='$e1' and id_tahap = '$idTahap'"));
			 $jumlah = $getJumlah['jumlah'];
			 $kode = $c1.".".$c.".".$d.".".$e.".".$e1;
		 }elseif($c != '00' && $d !='00' && $e!='00' && $e1!='000' &&  $p !='0' && $q =='0'  ){
		 	 $get  = mysql_fetch_array(mysql_query("select nama from ref_program where bk ='$bk' and ck='$ck' and dk = '$dk' and p='$p' and q = '0'" ));
			 $nama_skpd = "<span style='font-weight:bold; margin-left:25px;'>". $get['nama'] ."</span>";
			 $getJumlah = mysql_fetch_array(mysql_query("select sum(jumlah) as jumlah from view_renja where q!='0' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c ='$c' and d='$d'and  e ='$e' and e1='$e1' and bk ='$bk' and ck='$ck' and dk='$dk' and p ='$p' and id_tahap = '$idTahap'"));
			 $jumlah = $getJumlah['jumlah'];
			 $kode = $c1.".".$c.".".$d.".".$e.".".$e1.".".genNumber($bk).".".genNumber($ck).".".genNumber($dk).".".genNumber($p);
		 }elseif($c != '00' && $d !='00' && $e!='00' && $e1!='000' &&  $p !='0' && $q!='0'  ){
		 	 $get  = mysql_fetch_array(mysql_query("select nama from ref_program where bk ='$bk' and ck='$ck' and dk = '$dk' and p='$p' and q = '$q'" ));
			 $nama_skpd = "<span style='margin-left:30px;'>". $get['nama'] ."</span>";
			 $kode = $c1.".".$c.".".$d.".".$e.".".$e1.".".genNumber($bk).".".genNumber($ck).".".genNumber($dk).".".genNumber($p).".".genNumber($q);
		 }
			echo "
								<tr valign='top'>
									<td align='right' class='GarisCetak'>$no</td>
									<td align='left' class='GarisCetak' >".$kode."</td>
									<td align='left' class='GarisCetak' >".$nama_skpd."</td>
								</tr>
			";

			$no++;
			$no_cek++;


		}
		echo 				"</table>";
		echo 			$this->TandaTanganFooter($c1,$c,$d,$e,$e1).
						"</div>	</td></tr>
					</table>
				</div>
			</body>
		</html>";

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


		case 'lihatrenjaKeuanganSKPKD':{
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
		case 'Info':{
				$fm = $this->Info();
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}
		case 'SKPDAfter':{
				$fmSKPDUnit = cekPOST('fmSKPDUnit');
				$fmSKPDBidang = cekPOST('fmSKPDBidang');
				$fmSKPDskpd = cekPOST('fmSKPDskpd');
		break;

		}

		case 'newTab':{



			 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }



				if(mysql_num_rows(mysql_query("select * from skpd_renja_v3 where c1 = '$fmSKPDUrusan' and c = '$fmSKPDBidang' and d='$fmSKPDskpd'")) == 0){
					$data = array("c1" => $fmSKPDUrusan,
								  "c" => $fmSKPDBidang,
								  "d" => $fmSKPDskpd,
								 );
					mysql_query(VulnWalkerInsert('skpd_renja_v3',$data));
				}

				$grabID = mysql_fetch_array(mysql_query("select * from skpd_renja_v3 where c1 = '$fmSKPDUrusan' and c = '$fmSKPDBidang' and d='$fmSKPDskpd'"));
				$ID_PLAFON = $grabID['id'];
				$content = array('idrenjaKeuanganSKPKD' => $ID_PLAFON, "status" => $statunya );
			break;
		    }


			case 'editTab':{

			 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			 }
			 $urutArray = explode(" ",$renjaKeuanganSKPKD_cb[0]);
			 $urut = $renjaKeuanganSKPKD_cb[0];
			 $query = "select * from view_renja where id_anggaran = '$renjaKeuanganSKPKD_cb[0]' ";
			 $getViewrenjaKeuanganSKPKD = mysql_fetch_array(mysql_query($query));
			 foreach ($getViewrenjaKeuanganSKPKD as $key => $value) {
				  $$key = $value;
			 }
			 $IDEDIT = $id_anggaran;
			 $nomor = $this->nomorUrut - 1;

			 $grabID = mysql_fetch_array(mysql_query("select * from skpd_renja_v3 where c1 = '$c1' and c = '$c' and d='$d'"));
			 $ID_PLAFON = $grabID['id'];
			 if($status_validasi == '1'){
			 	$err = "Data sudah di validasi !";
			 }

			 $content = array('ID_PLAFON' => $ID_PLAFON,  'ID_EDIT' => $renjaKeuanganSKPKD_cb[0] , 'query ' =>"select * from view_renja where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1 = '$c1' and c = '$c' and d='$d' and e='00' and e1='000' and bk='0' and ck = '0' and dk = '0' and p ='0' and q = '0' and no_urut = '$nomor' ");

			break;
		    }

			case 'jenisChanged':{
				$jenisKegiatan = $_REQUEST['jenisKegiatan'];
				if($jenisKegiatan == 'baru'){
					$plus = "<input type='text' name ='plus' id ='plus'  readonly> ";
					$minus = "<input type='text' name ='minus' id ='minus' readonly> ";
				}else{
					$plus = "<input type='text' name ='plus' id ='plus' style='width:200px; text-align:right;'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='document.getElementById(`keyPP`).textContent = `Rp. ` + popupProgramrenjaKeuanganSKPKD.formatCurrency(this.value);' > ";
					$minus = "<input type='text' name ='minus' id ='minus' style='width:200px; text-align:right;'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup='document.getElementById(`keyMM`).textContent = `Rp. ` + popupProgramrenjaKeuanganSKPKD.formatCurrency(this.value);'> ";
				}
				$content = array('plus' => $plus, 'minus' => $minus);
			break;
		    }

			case 'comboPlafon':{
				foreach ($_REQUEST as $key => $value) {
		 			 $$key = $value;
				}
				$codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) from ref_skpd where c='00' and d='00' and e='00' and e1='000' ";
				$urusan = cmbQuery('cmbUrusan',$c1,$codeAndNameUrusan,'onchange=rka.refreshList(true);','-- URUSAN --');

				$codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$c1' and c !='00' and d='00' and e='00' and e1='000' ";
				$bidang = cmbQuery('cmbBidang',$c,$codeAndNameBidang,'onchange=rka.refreshList(true);','-- BIDANG --');

				$codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$c1' and c='$c' and d!='00' and e='00' and e1='000' ";
				$skpd= cmbQuery('cmbSKPD',$d,$codeAndNameSKPD,'onchange=rka.refreshList(true);','-- SKPD --');

				$getidTahapPlafon = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_plafon where tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran' "));
				$idTahapPlafon= $getidTahapPlafon['max'];
				$getAngkaPlafon = mysql_fetch_array(mysql_query("select plafon from view_plafon where c1='$c1' and c='$c' and d='$d' and id_tahap='$idTahapPlafon'"));
	 			$angkaPlafon = number_format($getAngkaPlafon['plafon'],2,',','.');


				$content = array('urusan' => $urusan, 'bidang' => $bidang, 'skpd' => $skpd , 'angkaPlafon' => "Rp. ".$angkaPlafon );
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
				$user_update = $dt['user_update'];
					if ($username != $user_validasi && $dt['status_validasi'] == '1') {
					$getNamaOrang = mysql_fetch_array(mysql_query("select * from admin where uid = '$user_validasi'"));
					$err = "Data Sudah di Validasi, Perubahan Hanya Bisa Dilakukan oleh ".$getNamaOrang['nama']." !";
					}else{
						if($username == $user_update){
							$err = "User yang membuat tidak dapat melakukan VALIDASI";
						}
					}

				if($this->jenisForm !='PENYUSUNAN')$err = "Tahap Penyusunan Telah Habis";

					if($err == ''){
						$fm = $this->Validasi($dt);
						$cek .= $fm['cek'];
						$err = $fm['err'];
						$content = $fm['content'];
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
			 $getSKPD = mysql_fetch_array(mysql_query("select * from tabel_anggaran where id_anggaran = '$renjaKeuanganSKPKD_idplh'"));
			 $cmbUrusanForm = $getSKPD['c1'];
			 $cmbBidangForm = $getSKPD['c'];
			 $cmbSKPDForm = $getSKPD['d'];
			 $cmbUnitForm = $getSKPD['e'];
			 $cmbSubUnitForm = $getSKPD['e1'];
			 $bk = $getSKPD['bk'];
			 $ck = $getSKPD['ck'];
			 $dk = $getSKPD['dk'];
			 $p = $getSKPD['p'];
			 $q = $getSKPD['q'];




			 $data = array( "status_validasi" => $status_validasi,
			 				'user_validasi' => $_COOKIE['coID'],
			 				'tanggal_validasi' => date("Y-m-d")
			 				);
			 $query = VulnWalkerUpdate("tabel_anggaran",$data," id_anggaran = '$renjaKeuanganSKPKD_idplh'");
			 mysql_query($query);

			$content .= $query;
		break;
	    }
		case 'sesuai':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
			$getPlafonnya = mysql_fetch_array(mysql_query($queryRows));
			foreach ($getPlafonnya as $key => $value) {
				  $$key = $value;
			}
			$cmbUrusanForm = $c1;
			$cmbBidangForm = $c;
			$cmbSKPDForm = $d;
			$cmbUnitForm = $e;
			$cmbSubUnitForm = $e1;
			$bk = $bk;
			$p = $p;
			$ck = $ck;
			$dk = $dk;
			$q = $q;

			if($this->jenisForm  !='KOREKSI'){
				$err = "Tahap Koreksi Telah Habis";
			}else{
				$cekUrusan =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='00' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and dk='0' and p = '0' and q='0'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'"));
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
										'dk' => '0',
										'p' => '0',
										'q' => '0',
										'id_tahap' => $this->idTahap,
										'jenis_anggaran' => $this->jenisAnggaran,
										'tahun' => $this->tahun,
										'nama_modul' => $this->modul
										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= $query;
						$cek .= "select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='00' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and dk='0' and p = '0' and q='0'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'";
						mysql_query($query)	;
					}

					$cekBidang =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and dk='0' and p = '0' and q='0' and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
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
										'dk' => '0',
										'p' => '0',
										'q' => '0',
										'id_tahap' => $this->idTahap,
										'jenis_anggaran' => $this->jenisAnggaran,
										'tahun' => $this->tahun,
										'nama_modul' => $this->modul

										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= $query;
						mysql_query($query)	;
					}


					$cekSKPD =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$cmbSKPDForm' and e='00' and e1='000' and bk='0' and ck='0' and dk='0' and p = '0' and q='0' and p = '00' and q='00'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					if($cekSKPD > 0 ){
					}else{
						$data = array(
									    'c1' => $cmbUrusanForm,
										'c'  => $cmbBidangForm,
										'd'  => $cmbSKPDForm,
										'e'  => '00',
										'e1' => '000',
										'bk' => '0',
										'ck' => '0',
										'dk' => '0',
										'p'  => '0',
										'q'  => '0',
										'jenis_anggaran' => $this->jenisAnggaran,
										'id_tahap' => $this->idTahap,
										'tahun' => $this->tahun,
										'nama_modul' => $this->modul

										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= $query;
						mysql_query($query);
					}



						$cekUnit = "select * from tabel_anggaran where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1= '$cmbUrusanForm' and c='$cmbBidangForm' and d='$cmbSKPDForm' and e = '$cmbUnitForm' and e1 = '000' and bk='0' and ck ='0' and dk ='0' and p = '0' and q='0' and id_tahap = '$this->idTahap'  ";
						if(mysql_num_rows(mysql_query($cekUnit))  == 0) {
							$data = array(
											'jenis_anggaran' => $this->jenisAnggaran,
											'tahun' => $this->tahun,
											'c1' => $cmbUrusanForm,
											'c' => $cmbBidangForm,
											'd' => $cmbSKPDForm,
											'e' => $cmbUnitForm,
											'e1' => '000',
											'bk' => '0',
											'ck' => '0',
											'dk' => '0',
											'p' => '0',
											'q' => '0',
											'id_tahap' => $this->idTahap,
											'nama_modul' => $this->modul
										  );
							 $query = VulnWalkerInsert("tabel_anggaran",$data);
							 mysql_query($query);
						}
						$cekSubUnit = "select * from tabel_anggaran  where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1= '$cmbUrusanForm' and c='$cmbBidangForm' and d='$cmbSKPDForm' and e = '$cmbUnitForm' and e1 = '$cmbSubUnitForm' and bk='0' and ck ='0' and dk ='0' and p = '0' and q='0' and id_tahap = '$this->idTahap' ";
						if(mysql_num_rows(mysql_query($cekSubUnit))  == 0) {
							$data = array(
											'jenis_anggaran' => $this->jenisAnggaran,
											'tahun' => $this->tahun,
											'c1' => $cmbUrusanForm,
											'c' => $cmbBidangForm,
											'd' => $cmbSKPDForm,
											'e' => $cmbUnitForm,
											'e1' => $cmbSubUnitForm,
											'bk' => '0',
											'ck' => '0',
											'dk' => '0',
											'p' => '0',
											'q' => '0',
											'id_tahap' => $this->idTahap,
											'nama_modul' => $this->modul
										  );
							 $query = VulnWalkerInsert("tabel_anggaran",$data);
							 mysql_query($query);
						}
						$cekProgram = "select * from tabel_anggaran  where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1= '$cmbUrusanForm' and c='$cmbBidangForm' and d='$cmbSKPDForm' and e = '$cmbUnitForm' and e1 = '$cmbSubUnitForm' and bk ='$bk' and ck ='$ck' and dk ='$dk' and p = '$p' and q='0' and id_tahap = '$this->idTahap'";
						if(mysql_num_rows(mysql_query($cekProgram)) == 0){
							$data = array(
											'jenis_anggaran' => $this->jenisAnggaran,
											'tahun' => $this->tahun,
											'c1' => $cmbUrusanForm,
											'c' => $cmbBidangForm,
											'd' => $cmbSKPDForm,
											'e' => $cmbUnitForm,
											'e1' => $cmbSubUnitForm,
											'bk' => $bk,
											'ck' => $ck,
											'dk' => $dk,
											'p' => $p,
											'q' => '0',
											'id_tahap' => $this->idTahap,
											'nama_modul' => $this->modul
										  );
							 $query = VulnWalkerInsert("tabel_anggaran",$data);
							 mysql_query($query);
						}

			$dataSesuai = array(
											'jenis_anggaran' => $this->jenisAnggaran,
											'tahun' => $this->tahun,
											'c1' => $cmbUrusanForm,
											'c' => $cmbBidangForm,
											'd' => $cmbSKPDForm,
											'e' => $cmbUnitForm,
											'e1' => $cmbSubUnitForm,
											'bk' => $bk,
											'ck' => $ck,
											'dk' => $dk,
											'p' => $p,
											'q' => $q,
											'jumlah' => $jumlah,
											'id_tahap' => $this->idTahap,
											'nama_modul' => $this->modul,
											'tanggal_update' => date('Y-m-d')

 								);
			$cekSKPD =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					if($cekSKPD > 0 ){
						$getID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					    $idnya = $getID['id_anggaran'];
						mysql_query("update tabel_anggaran set jumlah = '$jumlah' where id_anggaran='$idnya'");
					}else{
						mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));
						$content .=VulnWalkerInsert("tabel_anggaran", $dataSesuai);
					}
			}



		break;
	    }


		case 'koreksi':{
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$queryRows = "select * from tabel_anggaran where id_anggaran = '$idAwal'";
			$getPlafonnya = mysql_fetch_array(mysql_query($queryRows));
			foreach ($getPlafonnya as $key => $value) {
				  $$key = $value;
			}
			$cmbUrusanForm = $c1;
			$cmbBidangForm = $c;
			$cmbSKPDForm = $d;
			$cmbUnitForm = $e;
			$cmbSubUnitForm = $e1;
			$bk = $bk;
			$p = $p;
			$ck = $ck;
			$dk = $dk;
			$q = $q;


			if($this->jenisForm !='KOREKSI'){
				$err = "Tahap Koreksi Telah Habis";
			}else{
				$cekUrusan =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='00' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and dk='0' and p = '0' and q='0'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'"));
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
										'dk' => '0',
										'p' => '0',
										'q' => '0',
										'id_tahap' => $this->idTahap,
										'jenis_anggaran' => $this->jenisAnggaran,
										'tahun' => $this->tahun,
										'nama_modul' => $this->modul
										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= $query;
						$cek .= "select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='00' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and dk='0' and p = '0' and q='0'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap'";
						mysql_query($query)	;
					}

					$cekBidang =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '00' and e='00' and e1='000' and bk='0' and ck='0' and dk='0' and p = '0' and q='0' and p = '00' and q='00'   and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
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
										'dk' => '0',
										'p' => '0',
										'q' => '0',
										'id_tahap' => $this->idTahap,
										'jenis_anggaran' => $this->jenisAnggaran,
										'tahun' => $this->tahun,
										'nama_modul' => $this->modul

										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= $query;
						mysql_query($query)	;
					}


					$cekSKPD =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$cmbSKPDForm' and e='00' and e1='000' and bk='0' and ck='0' and dk='0' and p = '0' and q='0' and p = '00' and q='00'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					if($cekSKPD > 0 ){
					}else{
						$data = array(
									    'c1' => $cmbUrusanForm,
										'c'  => $cmbBidangForm,
										'd'  => $cmbSKPDForm,
										'e'  => '00',
										'e1' => '000',
										'bk' => '0',
										'ck' => '0',
										'dk' => '0',
										'p'  => '0',
										'q'  => '0',
										'jenis_anggaran' => $this->jenisAnggaran,
										'id_tahap' => $this->idTahap,
										'tahun' => $this->tahun,
										'nama_modul' => $this->modul

										);
						$query = VulnWalkerInsert("tabel_anggaran", $data);
						$content .= $query;
						mysql_query($query);
					}



						$cekUnit = "select * from tabel_anggaran where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1= '$cmbUrusanForm' and c='$cmbBidangForm' and d='$cmbSKPDForm' and e = '$cmbUnitForm' and e1 = '000' and bk='0' and ck ='0' and dk ='0' and p = '0' and q='0' and id_tahap = '$this->idTahap'  ";
						if(mysql_num_rows(mysql_query($cekUnit))  == 0) {
							$data = array(
											'jenis_anggaran' => $this->jenisAnggaran,
											'tahun' => $this->tahun,
											'c1' => $cmbUrusanForm,
											'c' => $cmbBidangForm,
											'd' => $cmbSKPDForm,
											'e' => $cmbUnitForm,
											'e1' => '000',
											'bk' => '0',
											'ck' => '0',
											'dk' => '0',
											'p' => '0',
											'q' => '0',
											'id_tahap' => $this->idTahap,
											'nama_modul' => $this->modul
										  );
							 $query = VulnWalkerInsert("tabel_anggaran",$data);
							 mysql_query($query);
						}
						$cekSubUnit = "select * from tabel_anggaran  where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1= '$cmbUrusanForm' and c='$cmbBidangForm' and d='$cmbSKPDForm' and e = '$cmbUnitForm' and e1 = '$cmbSubUnitForm' and bk='0' and ck ='0' and dk ='0' and p = '0' and q='0' and id_tahap = '$this->idTahap' ";
						if(mysql_num_rows(mysql_query($cekSubUnit))  == 0) {
							$data = array(
											'jenis_anggaran' => $this->jenisAnggaran,
											'tahun' => $this->tahun,
											'c1' => $cmbUrusanForm,
											'c' => $cmbBidangForm,
											'd' => $cmbSKPDForm,
											'e' => $cmbUnitForm,
											'e1' => $cmbSubUnitForm,
											'bk' => '0',
											'ck' => '0',
											'dk' => '0',
											'p' => '0',
											'q' => '0',
											'id_tahap' => $this->idTahap,
											'nama_modul' => $this->modul
										  );
							 $query = VulnWalkerInsert("tabel_anggaran",$data);
							 mysql_query($query);
						}
						$cekProgram = "select * from tabel_anggaran  where jenis_anggaran = '$this->jenisAnggaran' and tahun = '$this->tahun' and c1= '$cmbUrusanForm' and c='$cmbBidangForm' and d='$cmbSKPDForm' and e = '$cmbUnitForm' and e1 = '$cmbSubUnitForm' and bk ='$bk' and ck ='$ck' and dk ='$dk' and p = '$p' and q='0' and id_tahap = '$this->idTahap'";
						if(mysql_num_rows(mysql_query($cekProgram)) == 0){
							$data = array(
											'jenis_anggaran' => $this->jenisAnggaran,
											'tahun' => $this->tahun,
											'c1' => $cmbUrusanForm,
											'c' => $cmbBidangForm,
											'd' => $cmbSKPDForm,
											'e' => $cmbUnitForm,
											'e1' => $cmbSubUnitForm,
											'bk' => $bk,
											'ck' => $ck,
											'dk' => $dk,
											'p' => $p,
											'q' => '0',
											'id_tahap' => $this->idTahap,
											'nama_modul' => $this->modul
										  );
							 $query = VulnWalkerInsert("tabel_anggaran",$data);
							 mysql_query($query);
						}


			 $dataSesuai = array('jenis_anggaran' => $this->jenisAnggaran,
											'tahun' => $this->tahun,
											'c1' => $cmbUrusanForm,
											'c' => $cmbBidangForm,
											'd' => $cmbSKPDForm,
											'e' => $cmbUnitForm,
											'e1' => $cmbSubUnitForm,
											'bk' => $bk,
											'ck' => $ck,
											'dk' => $dk,
											'p' => $p,
											'q' => $q,
											'jumlah' => $angkaKoreksi,
											'id_tahap' => $this->idTahap,
											'nama_modul' => $this->modul
 								);

			 $getIDPlafon = mysql_fetch_array(mysql_query("select max(id_anggaran) as idPlafon from view_plafon where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and c1 = '$cmbUrusanForm' and c = '$cmbBidangForm' and d = '$cmbSKPDForm'"));
			 $idPlafon = $getIDPlafon['idPlafon'];
			 $getJumlahPlafon = mysql_fetch_array(mysql_query("select plafon from view_plafon where id_anggaran = '$idPlafon'"));
			 $jumlahPlafon = $getJumlahPlafon['plafon'];
			 $concatKegiatan = $bk.".".$ck.".".$dk.".".$p.".".$q;
			 $getTotalPagu = mysql_fetch_array(mysql_query("select sum(jumlah) as pagu from view_renja where tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut' and c1 = '$cmbUrusanForm' and c = '$cmbBidangForm' and d = '$cmbSKPDForm' "));
			 $totalPagu = $getTotalPagu['pagu'];

			 $cekSKPD =  mysql_num_rows(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
			 if($cekSKPD > 0 ){

						$getID = mysql_fetch_array(mysql_query("select * from tabel_anggaran where c1 = '$cmbUrusanForm' and c='$cmbBidangForm' and d = '$d' and e='$e' and e1='$e1' and bk='$bk' and ck='$ck' and dk='$dk' and p = '$p' and q='$q'  and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and id_tahap = '$this->idTahap' "));
					    $idnya = $getID['id_anggaran'];
						$pagu = $getID['jumlah'];
						$sisaPlafon = $jumlahPlafon - $totalPagu -  ($angkaKoreksi - $pagu);
						if($sisaPlafon >= 0){
							mysql_query("update tabel_anggaran set jumlah = '$angkaKoreksi' where id_anggaran='$idnya'");
						}else{
							$sesa = $jumlahPlafon -  $totalPagu - ($angkaKoreksi - $pagu) ;
							$err = "Tidak dapat melebihi plafon, sisa plafon = ".str_replace("-","",$sesa);
						}

			}else{
						$sisaPlafon = $jumlahPlafon -  $totalPagu - $angkaKoreksi;
						if($sisaPlafon >= 0){
							mysql_query(VulnWalkerInsert("tabel_anggaran", $dataSesuai));
						}else{
						    $sesa = $jumlahPlafon -  $totalPagu - ($angkaKoreksi - $pagu);
							$err = "Tidak dapat melebihi plafon, sisa plafon = ".str_replace("-","",$sesa);
						}

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
			$getMaxID = mysql_fetch_array(mysql_query("select max(id_anggaran) as maxID from tabel_anggaran where tahun = '$tahun'  and c1 ='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$p' and q='$q' and jenis_anggaran = '$jenis_anggaran' "));
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
   		$angka = mysql_num_rows(mysql_query("select * from view_renja where id_tahap='$this->idTahap'"));

	  /* if($this->jenisForm == "KOREKSI"){

	   	 $noUrutKoreksi  = $this->nomorUrut - 1;
	   	 $angka = mysql_num_rows(mysql_query("select * from view_renja where tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and no_urut ='$noUrutKoreksi'"));



	   }*/
		$scriptload =
					"<script>
						$(document).ready(function(){
							".$this->Prefix.".loading();

						});

					 function checkAll4( n, fldName ,elHeaderChecked, elJmlCek) {

			  if (!fldName) {
			     fldName = 'cb';
			  }
			   if (!elHeaderChecked) {
			     elHeaderChecked = 'toggle';
			  }
				var c = document.getElementById(elHeaderChecked).checked;
				var n2 = 0;
				for (i=0; i < $angka ; i++) {
					cb = document.getElementById(fldName+i);
					if (cb) {
						cb.checked = c;
						n2++;
					}
				}
				if (c) {
					document.getElementById(elJmlCek).value = n2;
				} else {
					document.getElementById(elJmlCek).value = 0;
				}
		}


					</script>
		";
		return
			"<script src='js/skpd.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/perencanaanKeuangan/keuangan/renja/renjaKeuanganSKPKD.js' language='JavaScript' ></script>".
			$scriptload;
	}

	//form ==================================
	function setFormBaru(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$c1 = $_REQUEST[$this->Prefix.'SkpdfmUrusan'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$dt['urusan'] = $_REQUEST['fmSKPDUrusan'];
		$dt['bidang'] = $_REQUEST['fmSKPDBidang'];
		$dt['skpd'] = $_REQUEST['fmSKPDskpd'];
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}

  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode('.',$this->form_idplh);
		$this->form_fmST = 1;

		if($cnt['cnt'] > 0) $err = "renjaKeuanganSKPKD Tidak Bisa Diubah ! Sudah Digunakan Di Ref Barang.";
		if($err == ''){
			$aqry = "SELECT * FROM  view_renja WHERE urut='".$this->form_idplh."' "; $cek.=$aqry;
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
	 $this->form_width = 600;
	 $this->form_height = 200;
	 $this->form_caption = 'INFO RENJA';
	 $selectedC1 = $_REQUEST['fmSKPDUrusan'];
	 $selectedC = $_REQUEST['fmSKPDBidang'];
	 $selectedD = $_REQUEST['fmSKPDskpd'];


	 $getidTahapPlafon = mysql_fetch_array(mysql_query("select max(id_tahap) as max from view_plafon where tahun='$this->tahun' and jenis_anggaran='$this->jenisAnggaran' "));
	 $idTahapPlafon= $getidTahapPlafon['max'];
	 $getAngkaPlafon = mysql_fetch_array(mysql_query("select plafon from view_plafon where c1='$selectedC1' and c='$selectedC' and d='$selectedD' and id_tahap='$idTahapPlafon'"));
	 $angkaPlafon = number_format($getAngkaPlafon['plafon'],2,',','.');
	 $codeAndNameUrusan = "select c1, concat(c1, '. ', nm_skpd) from ref_skpd where c='00' and d='00' and e='00' and e1='000' ";
	 $urusan = cmbQuery('cmbUrusan',$selectedC1,$codeAndNameUrusan,'onchange=renjaKeuanganSKPKD.comboChanged(); disabled','-- URUSAN --');

	 $codeAndNameBidang = "select c, concat(c, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c !='00' and d='00' and e='00' and e1='000' ";
	 $bidang = cmbQuery('cmbBidang',$selectedC,$codeAndNameBidang,'onchange=renjaKeuanganSKPKD.comboChanged(); disabled','-- BIDANG --');

	 $codeAndNameSKPD = "select d, concat(d, '. ', nm_skpd) from ref_skpd where c1='$selectedC1' and c='$selectedC' and d!='00' and e='00' and e1='000' ";
	 $skpd= cmbQuery('cmbSKPD',$selectedD,$codeAndNameSKPD,'onchange=renjaKeuanganSKPKD.comboChanged(); disabled' ,'-- SKPD --');
	/* if($this->jenisFormTerakhir == "VALIDASI"){
	 	$getJumlahSKPDYangMengisiPlafon = mysql_num_rows(mysql_query("select * from view_plafon where tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$this->noUrutTerakhirPlafon' and d!='00' and status_validasi = '1' "));
	 }else{
	 	$getJumlahSKPDYangMengisiPlafon = mysql_num_rows(mysql_query("select * from view_plafon where tahun='$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut ='$this->noUrutTerakhirPlafon' and d!='00' "));
	 }*/



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
						 ),
			'5' => array(
						'label'=>'URUSAN',
						'labelWidth'=>150,
						'value'=> $urusan ,
						 ),
			'6' => array(
						'label'=>'BIDANG',
						'labelWidth'=>150,
						'value'=>  $bidang ,
						 ),
			'7' => array(
						'label'=>'SKPD',
						'labelWidth'=>150,
						'value'=> $skpd ,
						 ),
			'9' => array(
						'label'=>'PLAFON',
						'labelWidth'=>150,
						'value'=> "<span id='angkaPlafon' style='color:red;' >Rp. ".$angkaPlafon."</span>",
						 ),


			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function genForm2($withForm=TRUE){
		$form_name = $this->Prefix.'_form';

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
    function Validasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI RENJA';
	 $kode = $dt['c1'].".".$dt['c'].".".$dt['d'].".".$dt['e'].".".$dt['e1'].".".$dt['p'].".".$dt['q'];
	  if ($dt['status_validasi'] == '1') {
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
						'label'=>'KODE RENJA',
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

	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;

	  if($this->jenisForm == "PENYUSUNAN"){
	  		if($this->wajibValidasi ==TRUE ){
				$tergantung = "<th class='th01' width='100' >VALIDASI</th>";
			}
		  	$headerTable =
		  "<thead>
		   <tr>
	  	   <th class='th01' width='5' >No.</th>
	  	   $Checkbox
	  	   <th class='th01' width='100'>KODE</th>
		   <th class='th01' width='900'>NAMA URUSAN PEMERINTAHAN, ORGANISASI, PROGRAM DAN KEGIATAN</th>
		   <th class='th01' width='100'>SASARAN</th>
		   <th class='th01' width='100'>TARGET KINERJA</th>
		   <th class='th01' width='200'>SUMBER DANA</th>
		   <th class='th01' width='100'>OUTPUT</th>
		   <th class='th01' width='100'>PAGU INDIKATIF</th>
		   $tergantung
		   </tr>
		   </thead>";
	  }elseif($this->jenisForm == "KOREKSI"){
		  	$headerTable =
			  "<thead>
			   <tr>
		  	   <th class='th01' width='5' >No.</th>
		  	   <th class='th01' width='100'>KODE</th>
			   <th class='th01' width='900'>NAMA URUSAN PEMERINTAHAN, ORGANISASI, PROGRAM DAN KEGIATAN</th>

			   <th class='th01' width='200'>PAGU INDIKATIF (Rp)</th>
			   <th class='th01' width='300'>PAGU KOREKSI (Rp)</th>
			   <th class='th01' width='200'>BERTAMBAH/(BERKURANG)</th>
			   <th class='th01' width='200'>AKSI</th>
			   </tr>
			   </thead>";

	  }else{
	    //VulnWalker Was here
	  	if($this->jenisFormTerakhir == "KOREKSI"){
			$headerTable =
			  "<thead>
			   <tr>
		  	   <th class='th01' width='5' >No.</th>
		  	   <th class='th01' width='100'>KODE</th>
			   <th class='th01' width='900'>NAMA URUSAN PEMERINTAHAN, ORGANISASI, PROGRAM DAN KEGIATAN</th>
			   <th class='th01' width='300'>PAGU INDIKATIF (Rp)</th>
			   <th class='th01' width='300'>PAGU KOREKSI (Rp)</th>
			   <th class='th01' width='300'>BERTAMBAH/(BERKURANG)</th>
			   </tr>
			   </thead>";
		}elseif($this->jenisFormTerakhir == "PENYUSUNAN"){
			if($this->wajibValidasi ==TRUE ){
				$tergantung = "<th class='th01' width='100' >VALIDASI</th>";
			}
			$headerTable =
			  "<thead>
			   <tr>
		  	   <th class='th01' width='5' >No</th>
		  	   <th class='th01' width='100'>KODE</th>
			   <th class='th01' width='900'>NAMA URUSAN PEMERINTAHAN, ORGANISASI, PROGRAM DAN KEGIATAN</th>
			   <th class='th01' width='100'>SUMBER DANA</th>
			   <th class='th01' width='200'>PAGU INDIKATIF (Rp)</th>
			   $tergantung
			   </tr>
			   </thead>";
		}

	  }


		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) {
		  $$key = $value;
	 }
	  //VulnWalker PENYUSUNAN
	 if($this->jenisForm == "PENYUSUNAN"){
	 	 $Koloms = array();
		 $Koloms[] = array('align="center"', $no.'.' );
		 $arrayKode = explode(".",$urut);
		 if($c == '00' && $d =='00' && $e=='00' && $e1=='000' && $bk == '0' && $ck =='0' && $dk =='0' && $p =='0' && $q=='0'  ){
		    $get  = mysql_fetch_array(mysql_query("select nm_skpd from ref_skpd where c1='$c1' and c='00' and d = '00' and e='00' and e1='000'" ));
			$nama_skpd = "<span style='font-weight:bold;'>". $get['nm_skpd'] ."</span>";
			$getJumlah = mysql_fetch_array(mysql_query("select sum(jumlah) as jumlah from view_renja where q!='0' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1'"));
			$jumlah = $getJumlah['jumlah'];
			$kode = $c1;
		 }elseif($c != '00' && $d =='00' && $e=='00' && $e1=='000' && $bk == '0' && $ck =='0' && $dk =='0' && $p =='0' && $q=='0'  ){
		 	 $get  = mysql_fetch_array(mysql_query("select nm_skpd from ref_skpd where c1='$c1' and c='$c' and d = '00' and e='00' and e1='000'" ));
			 $nama_skpd = "<span style='font-weight:bold; margin-left:5px;'>". $get['nm_skpd'] ."</span>";
			 $getJumlah = mysql_fetch_array(mysql_query("select sum(jumlah) as jumlah from view_renja where q!='0' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c ='$c' "));
			 $jumlah = $getJumlah['jumlah'];
			 $kode = $c1.".".$c;

		 }elseif($c != '00' && $d !='00' && $e=='00' && $e1=='000' && $bk == '0' && $ck =='0' && $dk =='0' && $p =='0' && $q=='0'  ){
		 	 $get  = mysql_fetch_array(mysql_query("select nm_skpd from ref_skpd where c1='$c1' and c='$c' and d = '$d' and e='00' and e1='000'" ));
			 $nama_skpd = "<span style='font-weight:bold; margin-left:10px;'>". $get['nm_skpd'] ."</span>";
			 $getJumlah = mysql_fetch_array(mysql_query("select sum(jumlah) as jumlah from view_renja where q!='0' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c ='$c' and d='$d'"));
			 $jumlah = $getJumlah['jumlah'];
			 $kode = $c1.".".$c.".".$d;
		 }elseif($c != '00' && $d !='00' && $p !='0' && $q =='0'  ){
		 	 $get  = mysql_fetch_array(mysql_query("select nama from ref_program where bk ='$bk' and ck='$ck' and dk = '$dk' and p='$p' and q = '0'" ));
			 $nama_skpd = "<span style='font-weight:bold; margin-left:25px;'>". $get['nama'] ."</span>";
			 $getJumlah = mysql_fetch_array(mysql_query("select sum(jumlah) as jumlah from view_renja where q!='0' and tahun='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran' and c1 ='$c1' and c ='$c' and d='$d'and  e ='$e' and e1='$e1' and bk ='$bk' and ck='$ck' and dk='$dk' and p ='$p' "));
			 $jumlah = $getJumlah['jumlah'];
			 $kode = $c1.".".$c.".".$d.".".genNumber($bk).".".genNumber($ck).".".genNumber($dk).".".genNumber($p);
		 }elseif($c != '00' && $d !='00'  &&  $p !='0' && $q!='0'  ){
		 	 $get  = mysql_fetch_array(mysql_query("select nama from ref_program where bk ='$bk' and ck='$ck' and dk = '$dk' and p='$p' and q = '$q'" ));
			 $nama_skpd = "<span style='margin-left:30px;'>". $get['nama'] ."</span>";
			 $kode = $c1.".".$c.".".$d.".".genNumber($bk).".".genNumber($ck).".".genNumber($dk).".".genNumber($p).".".genNumber($q);
		 }
		 $getDetailRenja = mysql_fetch_array(mysql_query("select * from detail_renja where id_anggaran ='$id_anggaran'"));
		 foreach ($getDetailRenja as $key => $value) {
		  $$key = $value;
	 }
		 if($q == 0){
		 	$Mode = 0;
			$target_kinerja = "";
			$hasil_tuk = "";
		 }else{
		 	$Mode = 1;
		 }
		 if ($Mode == 1){
		 	 $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		 }else{
		 	 $Koloms[] = array(" align='center'  ", "");
		 }

		 $Koloms[] = array('align="left"', $kode );
		 $Koloms[] = array('align="left"', $nama_skpd );
		 $Koloms[] = array('align="left"', $hasil_tuk );
		 $Koloms[] = array('align="left"', $hasil_tk );
		 $Koloms[] = array('align="left"', $sumber_dana );

		 $getUnitPelaksana = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 ='$c1' and c='$c' and d='$d' and e = '$e' and e1='$e1'"));

		 if($q!='0' && $e1 !='000')$unitPelaksana = $getUnitPelaksana['nm_skpd'];
		  $Koloms[] = array('align="left"', $output );
		  $Koloms[] = array('align="right"', number_format($jumlah,0,',','.') );
		 if ($status_validasi =='1') {
			 	$validnya = "valid.png";
			 }else{
			 	$validnya = "invalid.png";
			 }
			 if($this->wajibValidasi == TRUE){
			 	if($q == '0'){
				 $Koloms[] = array('align="center"', "");
				 }else{
				 $Koloms[] = array('align="center"', "<img src='images/administrator/images/$validnya' width='20px' heigh='20px'");
				 }
			 }


	 }


	 //VulnWalker KOREKSI
	 return $Koloms;
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
	 Global $fmSKPDBidang,$fmSKPDskpd, $fmSKPDUrusan;
	 $fmSKPDBidang = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST('fmSKPDBidang');
	 $fmSKPDskpd = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST('fmSKPDskpd');
	$fmTahun=  cekPOST('fmTahun')==''?$_COOKIE['coThnAnggaran']:cekPOST('fmTahun');
	$fmBIDANG = cekPOST('fmBIDANG');


	 $arr = array(
			//array('selectAll','Semua'),
			array('nama_renjaKeuanganSKPKD','NAMA renjaKeuanganSKPKD'),
			array('alamat','ALAMAT'),
			array('kota','KOTA / KABUPATEN'),
			array('nama_pimpinan','NAMA PIMPINAN'),
			array('no_npwp','NO. NPWP'),
			);

	 //data order ------------------------------
	 $arrOrder = array(
			     	array('1','NAMA renjaKeuanganSKPKD'),
					array('2','ALAMAT'),
					array('3','KOTA / KABUPATEN'),
					array('4','NAMA PIMPINAN'),
					array('5','NO. NPWP'),
					);

	$fmPILCARI = $_REQUEST['fmPILCARI'];
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	$baris = $_REQUEST['baris'];
	if ($baris == ''){
		$baris = "25";
	}
	$TampilOpt =
	"<div class='FilterBar' style='margin-top:10px;'><table style='width:100%'>".
			CmbUrusanBidangSkpd('renjaKeuanganSKPKD').
"</table></div>";

		return array('TampilOpt'=>$TampilOpt);
	}

			function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];

		//kondisi -----------------------------------

		$arrKondisi = array();

		$fmPILCARI = $_REQUEST['fmPILCARI'];
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];

		$fmSKPDUrusan = $_REQUEST['fmSKPDUrusan'];
		$fmSKPDBidang = $_REQUEST['fmSKPDBidang'];
		$fmSKPDskpd = $_REQUEST['fmSKPDskpd'];

		if(isset($fmSKPDskpd)){
			$data = array("CurrentUrusan" => $fmSKPDUrusan,
					  "CurrentBidang" => $fmSKPDBidang,
					  "CurrentSKPD" => $fmSKPDskpd,

					  );
		}elseif(isset($fmSKPDBidang)){
			$data = array("CurrentUrusan" => $fmSKPDUrusan,
					  "CurrentBidang" => $fmSKPDBidang,

					  );
		}elseif(isset($fmSKPDUrusan)){
			$data = array("CurrentUrusan" => $fmSKPDUrusan

			 );
		}

		mysql_query(VulnWalkerUpdate("current_filter",$data,"username='$this->username'"));

		foreach ($HTTP_COOKIE_VARS as $key => $value) {
		  			$$key = $value;
	 	}


	   if(!isset($fmSKPDUrusan) ){
	   		$arrayData = mysql_fetch_array(mysql_query("select * from current_filter where username ='".$_COOKIE['coID']."'"));
			foreach ($arrayData as $key => $value) {
			  $$key = $value;
			 }
		   	 if($CurrentSKPD !='' ){
				$fmSKPDskpd = $CurrentSKPD;
				$fmSKPDBidang = $CurrentBidang;
				$fmSKPDUrusan = $CurrentUrusan;

			}elseif($CurrentBidang !=''){
				$fmSKPDBidang = $CurrentBidang;
				$fmSKPDUrusan = $CurrentUrusan;

			}elseif($CurrentUrusan !=''){
				$fmSKPDUrusan = $CurrentUrusan;
			}
	   }

		$noUrutSebelumnya = $this->nomorUrut - 1;
		/*$fmLimit = $_REQUEST['baris'];
		$this->pagePerHal=$fmLimit;*/
		if($_COOKIE['VulnWalkerSKPD'] != '00'){
			$fmSKPDUrusan = $_COOKIE['VulnWalkerUrusan'];
			$fmSKPDBidang = $_COOKIE['VulnWalkerBidang'];
			$fmSKPDskpd = $_COOKIE['VulnWalkerSKPD'];
		}elseif($_COOKIE['VulnWalkerBidang'] !='00'){
			$fmSKPDUrusan = $_COOKIE['VulnWalkerUrusan'];
			$fmSKPDBidang = $_COOKIE['VulnWalkerBidang'];
		}elseif($_COOKIE['VulnWalkerUrusan'] !='0'){
			$fmSKPDUrusan = $_COOKIE['VulnWalkerUrusan'];
		}
		if($fmSKPDskpd != "00"){
			$arrKondisi[] = "d = '$fmSKPDskpd'";
			$arrKondisi[] = "c = '$fmSKPDBidang'";
			$arrKondisi[] = "c1 = '$fmSKPDUrusan'";
		}elseif($fmSKPDBidang != "00"){
			$arrKondisi[] = "c = '$fmSKPDBidang'";
			$arrKondisi[] = "c1 = '$fmSKPDUrusan'";
		}elseif($fmSKPDUrusan != "0"){
			$arrKondisi[] = "c1 = '$fmSKPDUrusan'";
		}


			$arrKondisi[] = " tahun = '$this->tahun'";
			$arrKondisi[] = " jenis_anggaran = '$this->jenisAnggaran'";
			$arrKondisi[] =  " no_urut = '$this->nomorUrut'";


		/*$getUrusan = mysql_query("select * from view_renja where  c = '00' and  tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'");
		while($Urusan= mysql_fetch_array($getUrusan)){
			foreach ($Urusan as $key => $value) {
		  			$$key = $value;
	 		}
			if(mysql_num_rows(mysql_query("select * from view_renja where c1='$c1' and q != '0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'")) == 0 ){
				$arrKondisi[] = "id_anggaran !='$id_anggaran'";
			}else{
				$getBidang = mysql_query("select * from view_renja where c1 = '$c1' and  c != '00' and d='00' and  tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'");
				while($Bidang= mysql_fetch_array($getBidang)){
					foreach ($Bidang as $key => $value) {
				  			$$key = $value;
			 		}
					if(mysql_num_rows(mysql_query("select * from view_renja where c1='$c1' and c='$c' and q != '0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'")) == 0 ){
						$arrKondisi[] = "id_anggaran !='$id_anggaran'";
					}else{
						$getSkpd = mysql_query("select * from view_renja where c1 = '$c1' and  c = '$c' and d !='00' and p='0' and  tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'");
						while($Skpd= mysql_fetch_array($getSkpd)){
							foreach ($Skpd as $key => $value) {
						  			$$key = $value;
					 		}
							if(mysql_num_rows(mysql_query("select * from view_renja where c1='$c1' and c='$c' and d='$d' and q != '0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'")) == 0 ){
								$arrKondisi[] = "id_anggaran !='$id_anggaran'";
							}else{
								$getProgram = mysql_query("select * from view_renja where c1 = '$c1' and  c = '$c' and d ='$d' and p!='0' and q='0' and  tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'");
								while($Program= mysql_fetch_array($getProgram)){
									foreach ($Program as $key => $value) {
								  			$$key = $value;
							 		}
									if(mysql_num_rows(mysql_query("select * from view_renja where c1='$c1' and c='$c' and d='$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p ='$p' and q != '0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'")) == 0 ){
										$arrKondisi[] = "id_anggaran !='$id_anggaran'";
									}
								}
							}
						}
					}
				}
			}
		}*/
		$getUrusan = mysql_query("select * from view_renja where  c1 !='0' and c='00' and d = '00' and  tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'");
		while($Urusan= mysql_fetch_array($getUrusan)){
			foreach ($Urusan as $key => $value) {
		  			$$key = $value;
	 		}
			if(mysql_num_rows(mysql_query("select * from view_renja where c1='$c1' and q != '0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'")) == 0 ){
				$concatUrusan = $c1;
				$arrKondisi[] = "c1 !='$concatUrusan'";
			}else{
				$getBidang = mysql_query("select * from view_renja where c1 = '$c1' and  c != '00' and d='00' and  tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'");
				while($Bidang= mysql_fetch_array($getBidang)){
					foreach ($Bidang as $key => $value) {
				  			$$key = $value;
			 		}
					if(mysql_num_rows(mysql_query("select * from view_renja where c1='$c1' and c='$c' and q != '0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'")) == 0 ){
						$concatBidang = $c1.".".$c;
						$arrKondisi[] = "concat(c1,'.',c) !='$concatBidang'";
					}else{
						$getSkpd = mysql_query("select * from view_renja where c1 = '$c1' and  c = '$c' and d !='00' and p='0' and  tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'");
						while($Skpd= mysql_fetch_array($getSkpd)){
							foreach ($Skpd as $key => $value) {
						  			$$key = $value;
					 		}
							if(mysql_num_rows(mysql_query("select * from view_renja where c1='$c1' and c='$c' and d='$d' and q != '0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'")) == 0 ){
								$concatSKPD = $c1.".".$c.".".$d;
								$arrKondisi[] = "concat(c1,'.',c,'.',d) !='$concatSKPD'";
							}else{
								$getProgram = mysql_query("select * from view_renja where c1 = '$c1' and  c = '$c' and d ='$d' and p!='0' and q='0' and  tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'");
								while($Program= mysql_fetch_array($getProgram)){
									foreach ($Program as $key => $value) {
								  			$$key = $value;
							 		}
									if(mysql_num_rows(mysql_query("select * from view_renja where c1='$c1' and c='$c' and d='$d' and bk = '$bk' and ck = '$ck' and dk = '$dk' and p ='$p' and q != '0' and tahun = '$this->tahun' and jenis_anggaran = '$this->jenisAnggaran' and no_urut = '$this->nomorUrut'")) == 0 ){
										$concatProgram = $c1.".".$c.".".$d.".".$bk.".".$ck.".".$dk.".".$p;
										$arrKondisi[] = "concat(c1,'.',c,'.',d,'.',bk,'.',ck,'.',dk,'.',p) !='$concatProgram'";
									}
								}
							}
						}
					}
				}
			}
		}


		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;

		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();

		$arrOrders[] = " urut $Asc1 " ;
		$Order= join(',',$arrOrders);
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;

	/*	$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	*/

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);

	}




	function Hapus($ids){ //validasi hapus ref_kota
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++)	{
			$getData = mysql_fetch_array(mysql_query("select * from view_renja where id_anggaran ='$ids[$i]' "));
			if($getData['status_validasi'] == '1' ){

			}else{
				$qy = "DELETE FROM tabel_anggaran WHERE id_anggaran='$ids[$i]' ";$cek.=$qy;
					$qry = mysql_query($qy);
					$qy = "DELETE FROM detail_renja WHERE id_anggaran='$ids[$i]' ";$cek.=$qy;
					$qry = mysql_query($qy);
			}
		}
		return array('err'=>$err,'cek'=>$cek);
	}

	function JudulLaporan($dari='', $sampai='',$judul=''){
		return "<div style='text-align:center;'>
				<span style='font-size:18px;font-weight:bold;text-decoration: underline;'>
					RENCANA KERJA SKPD $this->jenisAnggaran
				</span><br>
				<span class='ukurantulisanIdPenerimaan'>TAHUN : $this->tahun </span></div><br>";
	}
	function TandaTanganFooter($c1,$c,$d,$e,$e1){
		global $Main, $DataPengaturan,$HTTP_COOKIE_VARS;




		return "<br><div class='ukurantulisan'>
					<table width='100%'>
						<tr>
							<td class='ukurantulisan' valign='top' ></td>
							<td class='ukurantulisan' valign='top' width='50%' ></td>
							<td class='ukurantulisan' valign='top'><span style='margin-left:5px;'>Bandung, ".VulnWalkerTitiMangsa(date('Y-m-d'))."</span></td>
						</tr>
						<tr>
							<td class='ukurantulisan' valign='top' ><span style='margin-left:5px;'>Tanda Tangan Satu
<br><br><br><br><br></span></td>
							<td class='ukurantulisan' valign='top' width='50%' ></td>
							<td class='ukurantulisan' valign='top' ><span style='margin-left:5px;'>Tanda Tangan Dua
</span></td>
						</tr>
						<tr>
							<td class='ukurantulisan'>
								<table width='100%'>
									<tr>
										<td class='ukurantulisan' width='75px'>Nama</td>
										<td class='ukurantulisan'> : </td>
										<td class='ukurantulisan'>Nama Tanda Tangan Satu</td>
									</tr>
									<tr>
										<td class='ukurantulisan'>NIP</td>
										<td class='ukurantulisan'> : </td>
										<td class='ukurantulisan'>NIP Tanda Tangan Satu</td>
									</tr>
								</table>
							</td>
							<td class='ukurantulisan'></td>
							<td class='ukurantulisan'>
								<table width='100%'>
									<tr>
										<td class='ukurantulisan' width='75px'>Nama</td>
										<td class='ukurantulisan'> : </td>
										<td class='ukurantulisan'>Nama Tanda Tangan Dua</td>
									</tr>
									<tr>
										<td class='ukurantulisan'>NIP</td>
										<td class='ukurantulisan'> : </td>
										<td class='ukurantulisan'>NIP Tanda Tangan Dua</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>";
	}
	function LaporanTmplSKPD($c1, $c, $d, $e, $e1){
		global $Main, $DataPengaturan, $DataOption;

		$get = mysql_fetch_array(mysql_query("select * from skpd_report_renja where username = '$this->username'"));
		foreach ($get as $key => $value) {
		  $$key = $value;
	 	}
		$grabUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='00'"));
		$urusan = $c1.". ".$grabUrusan['nm_skpd'];
		$grabBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='00'"));
		$bidang = $c.". ".$grabBidang['nm_skpd'];
		$grabSkpd = mysql_fetch_array(mysql_query("select * from ref_skpd where c1 = '$c1' and c='$c' and d='$d' and e='00'"));
		$skpd = $d.". ".$grabSkpd['nm_skpd'];



		$data = "
				<table width=\"100%\" border=\"0\" class='subjudulcetak'>
					<tr>
						<td width='10%' valign='top'>URUSAN</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$urusan."</td>
					</tr>
					<tr>
						<td width='10%' valign='top' >BIDANG</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$bidang."</td>
					</tr>
					<tr>
						<td width='10%' valign='top'>SKPD</td>
						<td width='1%' valign='top'> : </td>
						<td valign='top'>".$skpd."</td>
					</tr>

				</table>";

		return $data;
	}


}
$renjaKeuanganSKPKD = new renjaKeuanganSKPKDObj();

$arrayResult = tahapPerencanaanV3($renjaKeuanganSKPKD->modul,"MURNI");


$jenisForm = $arrayResult['jenisForm'];
$nomorUrut = $arrayResult['nomorUrut'];
$tahun = $arrayResult['tahun'];
$jenisAnggaran = "MURNI";
$idTahap = $arrayResult['idTahap'];

$renjaKeuanganSKPKD->jenisForm = $jenisForm;
$renjaKeuanganSKPKD->nomorUrut = $nomorUrut;
$renjaKeuanganSKPKD->tahun = $tahun;
$renjaKeuanganSKPKD->jenisAnggaran = $jenisAnggaran;
$renjaKeuanganSKPKD->idTahap = $idTahap;
$renjaKeuanganSKPKD->username = $_COOKIE['coID'];
$renjaKeuanganSKPKD->wajibValidasi = $arrayResult['wajib_validasi'];
$renjaKeuanganSKPKD->settingAnggaran = $arrayResult['settingAnggaran'];


?>
