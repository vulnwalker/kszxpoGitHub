<?php

class penerimaanDistribusiObj  extends DaftarObj2{
	var $Prefix = 'penerimaanDistribusi';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_penerimaan_distribusi'; //bonus
	var $TblName_Hapus = 'distribusi';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);
	var $checkbox_rowspan = 2;
	var $PageTitle = 'PENERIMAAN DISTRIBUSI BARANG PERSEDIAAN';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='penerimaanDistribusi.xls';
	var $namaModulCetak='PENERIMAAN DISTRIBUSI BARANG PERSEDIAAN';
	var $Cetak_Judul = 'PENERIMAAN DISTRIBUSI BARANG PERSEDIAAN';
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'penerimaanDistribusiForm';
	var $modul = "PENERIMAAN DISTRIBUSI BARANG PERSEDIAAN";
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

	var $username = "";
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

	var $publicVar = "";

	function setTitle(){
		return 'PENERIMAAN DISTRIBUSI BARANG PERSEDIAAN';
	}
	// function setMenuView(){
	// 	return
	// 		// "<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png",'Laporan',"Laporan")."</td>";
	// 		"";
	// }
	function setMenuEdit(){

	 	$listMenu =
					"<td>".genPanelIcon("javascript:".$this->Prefix.".Posting()","publishdata.png","Posting ", 'Posting ')."</td>"
					;


		return $listMenu ;
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

			case 'savePosting':{
				foreach ($_REQUEST as $key => $value) {
				 	 $$key = $value;
				}
				mysql_query("delete from cancel_distribusi_posting where username = '$this->username'");
				$getDataPosting = mysql_fetch_array(mysql_query("select * from view_penerimaan_distribusi where id = '$idPosting'"));
				$getDataDistribusi = mysql_fetch_array(mysql_query("select * from distribusi where id = '".$getDataPosting['idDistribusi']."'"));
				$explodeTanggalBuku = explode($getDataDistribusi['tanggal_buku']);
				$bulanBuku = $explodeTanggalBuku[1];
				if($bulanBuku <= 6){
				  $semesterPosting = "1";
				}elseif($bulanBuku >= 7){
				  $semesterPosting = "2";
				}
				$getDataRincianDistribusi = mysql_query("select * from rincian_distribusi where id_distribusi = '".$getDataPosting['idDistribusi']."'");
				while ($rincianDistribusi = mysql_fetch_array($getDataRincianDistribusi)) {
						$getDataDetailRincianDistribusi = mysql_query("select * from detail_rincian_distribusi where id_rincian_distribusi = '".$rincianDistribusi['id']."' and c1='".$getDataPosting['c1']."' and c='".$getDataPosting['c']."' and d='".$getDataPosting['d']."' and e='".$getDataPosting['e']."'  and e1='".$getDataPosting['e1']."'");
						while ($detailRincianDistribusi = mysql_fetch_array($getDataDetailRincianDistribusi)) {
								foreach ($detailRincianDistribusi as $key => $value) {
									 $$key = $value;
								}

								if($statusPosting == 'on' && $status != '1'){
									$explodeNomor = explode("/",$getDataDistribusi['nomor']);
									$nomor = $explodeNomor[0]."/".$explodeNomor[1]."/".$getDataDistribusi['c1'].".".$getDataDistribusi['c'].".".$getDataDistribusi['d'].".".$e.".".$e1."/".$explodeNomor[3];
									$dataPostingKurang = array(
																					'c1' => $getDataDistribusi['c1'],
																					'c' => $getDataDistribusi['c'],
																					'd' => $getDataDistribusi['d'],
																					'e' => $getDataDistribusi['e'],
																					'e1' => $getDataDistribusi['e1'],
																					'bk' => $getDataDistribusi['bk'],
																					'ck' => $getDataDistribusi['ck'],
																					'dk' => $getDataDistribusi['dk'],
																					'p' => $getDataDistribusi['p'],
																					'q' => $getDataDistribusi['q'],
																					'f1' => $rincianDistribusi['f1'],
																					'f2' => $rincianDistribusi['f2'],
																					'f' => $rincianDistribusi['f'],
																					'g' => $rincianDistribusi['g'],
																					'h' => $rincianDistribusi['h'],
																					'i' => $rincianDistribusi['i'],
																					'j' => $rincianDistribusi['j'],
																					'j1' => $rincianDistribusi['j1'],
																					'merk' => $rincianDistribusi['merk'],
																					'jumlah' => $jumlah,
																					'jns' => 7,
																					'jenis_persediaan' => 2,
																					'nomor' => $nomor,
																					'refid' => $id,
																					'tanggal_buku' => $getDataDistribusi['tanggal_buku'],
																			);
									$queryKurang = VulnWalkerInsert("t_kartu_persediaan",$dataPostingKurang);
									if(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where  c1 ='".$getDataDistribusi['c1']."' and c ='".$getDataDistribusi['c']."' and d ='".$getDataDistribusi['d']."' and e ='".$getDataDistribusi['e']."' and e1 ='".$getDataDistribusi['e1']."' and f1 ='".$rincianDistribusi['f1']."' and f2 ='".$rincianDistribusi['f2']."' and f ='".$rincianDistribusi['f']."' and g ='".$rincianDistribusi['g']."' and h ='".$rincianDistribusi['h']."' and i ='".$rincianDistribusi['i']."' and j ='".$rincianDistribusi['j']."' and j1 ='".$rincianDistribusi['j1']."' and tahun = '".$_COOKIE['coThnAnggaran']."' and semester = '$semesterPosting' ")) != 0)
									{
											$err = "Data sudah di kunci";
									}

									if(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where  c1 ='".$getDataDistribusi['c1']."' and c ='".$getDataDistribusi['c']."' and d ='".$getDataDistribusi['d']."' and e ='".$e."' and e1 ='".$e1."' and f1 ='".$rincianDistribusi['f1']."' and f2 ='".$rincianDistribusi['f2']."' and f ='".$rincianDistribusi['f']."' and g ='".$rincianDistribusi['g']."' and h ='".$rincianDistribusi['h']."' and i ='".$rincianDistribusi['i']."' and j ='".$rincianDistribusi['j']."' and j1 ='".$rincianDistribusi['j1']."' and tahun = '".$_COOKIE['coThnAnggaran']."' and semester = '$semesterPosting' ")) != 0)
									{
											$err = "Data sudah di kunci";
									}
									// mysql_query($queryKurang);
									$dataPostingTambah = array(
																					'c1' => $getDataDistribusi['c1'],
																					'c' => $getDataDistribusi['c'],
																					'd' => $getDataDistribusi['d'],
																					'e' => $e,
																					'e1' => $e1,
																					'bk' => $getDataDistribusi['bk'],
																					'ck' => $getDataDistribusi['ck'],
																					'dk' => $getDataDistribusi['dk'],
																					'p' => $getDataDistribusi['p'],
																					'q' => $getDataDistribusi['q'],
																					'f1' => $rincianDistribusi['f1'],
																					'f2' => $rincianDistribusi['f2'],
																					'f' => $rincianDistribusi['f'],
																					'g' => $rincianDistribusi['g'],
																					'h' => $rincianDistribusi['h'],
																					'i' => $rincianDistribusi['i'],
																					'j' => $rincianDistribusi['j'],
																					'j1' => $rincianDistribusi['j1'],
																					'jumlah' => $jumlah,
																					'jns' => 3,
																					'jenis_persediaan' => 1,
																					'nomor' => $nomor,
																					'refid' => $id,
																					'tanggal_buku' => $getDataDistribusi['tanggal_buku'],
																			);
									$queryTambah = VulnWalkerInsert("t_kartu_persediaan",$dataPostingTambah);
									// mysql_query($queryTambah);
									// mysql_query("update detail_rincian_distribusi set status = '1' where id = '$id'");
									$dataCancel = array(
																	'action' => base64_encode($queryTambah).";".base64_encode($queryKurang).";".base64_encode("update detail_rincian_distribusi set status = '1' where id = '$id'"),
																	'username' => $this->username,
									);
									mysql_query(VulnWalkerInsert("cancel_distribusi_posting",$dataCancel));
								}else{
									if($statusPosting != 'on'){
										$queryKurang = VulnWalkerInsert("t_kartu_persediaan",$dataPostingKurang);
										if(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where  c1 ='".$getDataDistribusi['c1']."' and c ='".$getDataDistribusi['c']."' and d ='".$getDataDistribusi['d']."' and e ='".$getDataDistribusi['e']."' and e1 ='".$getDataDistribusi['e1']."' and f1 ='".$rincianDistribusi['f1']."' and f2 ='".$rincianDistribusi['f2']."' and f ='".$rincianDistribusi['f']."' and g ='".$rincianDistribusi['g']."' and h ='".$rincianDistribusi['h']."' and i ='".$rincianDistribusi['i']."' and j ='".$rincianDistribusi['j']."' and j1 ='".$rincianDistribusi['j1']."' and tahun = '".$_COOKIE['coThnAnggaran']."' and semester = '$semesterPosting' ")) != 0)
										{
												$err = "Data sudah di kunci";
										}

										if(mysql_num_rows(mysql_query("select * from t_persediaan_lock_barang where  c1 ='".$getDataDistribusi['c1']."' and c ='".$getDataDistribusi['c']."' and d ='".$getDataDistribusi['d']."' and e ='".$e."' and e1 ='".$e1."' and f1 ='".$rincianDistribusi['f1']."' and f2 ='".$rincianDistribusi['f2']."' and f ='".$rincianDistribusi['f']."' and g ='".$rincianDistribusi['g']."' and h ='".$rincianDistribusi['h']."' and i ='".$rincianDistribusi['i']."' and j ='".$rincianDistribusi['j']."' and j1 ='".$rincianDistribusi['j1']."' and tahun = '".$_COOKIE['coThnAnggaran']."' and semester = '$semesterPosting' ")) != 0)
										{
												$err = "Data sudah di kunci";
										}
										// mysql_query("update detail_rincian_distribusi set status = '0' where id = '$id'");
										// mysql_query("delete from t_kartu_persediaan where refid = '$id' and (jns='7' or jns='3') and (jenis_persediaan='1' or jenis_persediaan='2')");
										$dataCancel = array(
																		'action' => base64_encode("update detail_rincian_distribusi set status = '0' where id = '$id'").";".base64_encode("delete from t_kartu_persediaan where refid = '$id' and (jns='7' or jns='3') and (jenis_persediaan='1' or jenis_persediaan='2')"),
																		'username' => $this->username,
										);
										mysql_query(VulnWalkerInsert("cancel_distribusi_posting",$dataCancel));
									}

								}


						}
				}

				if(empty($err)){
						$getDataCancel = mysql_query("select * from cancel_distribusi_posting where username = '$this->username'");
						while ($dataCancel = mysql_fetch_array($getDataCancel)) {
								$explodeQuery = explode(";",$dataCancel['action']);
								mysql_query(base64_decode($explodeQuery[0]));
								mysql_query(base64_decode($explodeQuery[1]));
								mysql_query(base64_decode($explodeQuery[2]));
						}
				}


			break;
			}

		case 'Report':{
			foreach ($_REQUEST as $key => $value) {
			 	 $$key = $value;
			}
			if(empty($cmbUrusan)){
				$err = "Pilih Urusan";
			}elseif(empty($cmbBidang)){
				$err = "Pilih Bidang";
			}elseif(empty($cmbSKPD)){
				$err = "Pilih SKPD";
			}else{
				if(mysql_num_rows(mysql_query("select * from skpd_report_rka_21 where username= '$this->username'")) == 0){
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD

								  );
					$query = VulnWalkerInsert('skpd_report_rka_21',$data);
					mysql_query($query);
				}else{
					$data = array(
								  'username' => $this->username,
								  'c1' => $cmbUrusan,
								  'c' => $cmbBidang,
								  'd' => $cmbSKPD


								  );
					$query = VulnWalkerUpdate('skpd_report_rka_21',$data,"username = '$this->username'");
					mysql_query($query);
				}

			}
		break;
		}
		case 'Laporan':{
			$json = FALSE;
			$this->Laporan();
		break;
		}
		case 'Posting':{
				$idPosting = $_REQUEST[$this->Prefix.'_cb'];
				$fm = $this->Posting($idPosting[0]);
				$cek .= $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];
		break;
		}

		case 'checkItem':{
			foreach ($_REQUEST as $key => $value) {
					$$key = $value;
			}
			mysql_query("update detail_rincian_distribusi  set status = '1' where id = '$id'");
		break;
		}
		case 'unCheckItem':{
			foreach ($_REQUEST as $key => $value) {
					$$key = $value;
			}
			mysql_query("update detail_rincian_distribusi set status = '0' where id = '$id'");
		break;
		}
		case 'newTab':{
			foreach ($_REQUEST as $key => $value) {
					$$key = $value;
			}
			mysql_query("delete from temp_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from delete_temp_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from temp_detail_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from delete_temp_detail_rincian_distribusi where username = '$this->username'");
			$getDataMax = mysql_fetch_array(mysql_query("select max(nomor) from distribusi where c1 = '$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'  "));
			$explodeNomor = explode('/',$getDataMax['max(nomor)']);
			$nomorTerakhir = $explodeNomor[0] + 1;
			$nomorPengeluaran = $this->kasihNol($nomorTerakhir );
			$nomor = $nomorPengeluaran."/"."D/".$c1.".".$c.".".$d.".".$e.".".$e1."/".$_COOKIE['coThnAnggaran'];

			$dataInsert = array(
								'c1' => $c1,
								'c' => $c,
								'd' => $d,
								'e' => $e,
								'e1' => $e1,
								'nomor' => $nomor,
								'status_temp' => "1",
								'tanggal' => $_COOKIE['coThnAnggaran']."-".date("m-d"),
								'tanggal_buku' => $_COOKIE['coThnAnggaran']."-".date("m-d"),
			);
			$query = VulnWalkerInsert($this->TblName,$dataInsert);
			mysql_query($query);
			$cek = $query;



			$content = array("nomor" => $nomor);

		break;
		}




		case 'editTab':{
			mysql_query("delete from temp_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from delete_temp_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from temp_detail_rincian_distribusi where username = '$this->username'");
			mysql_query("delete from delete_temp_detail_rincian_distribusi where username = '$this->username'");
			$id = $_REQUEST['penerimaanDistribusi_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
			$getDataDistribusi = mysql_fetch_array(mysql_query("select * from distribusi where id = '".$id[0]."'"));
			if($getDataDistribusi['status_posting'] == 1){
					$err = "Data sudah di posting tidak dapat di ubah !";
			}
			$kodeSKPD = $getDataDistribusi['c1'].".".$getDataDistribusi['c'].".".$getDataDistribusi['d'].".".$getDataDistribusi['e'].".".$getDataDistribusi['e1'];
			$nomor = $getDataDistribusi['nomor'];

			if(empty($err)){
				$getAllRincianDistribusi = mysql_query("select * from rincian_distribusi where id_distribusi ='".$id[0]."'");
				while ($rincianDistribusi = mysql_fetch_array($getAllRincianDistribusi)) {
					foreach ($rincianDistribusi as $key => $value) {
							$$key = $value;
					}
					$dataRincian = array(
											'f1' => $f1,
											'f2' => $f2,
											'f' => $f,
											'g' => $g,
											'h' => $h,
											'i' => $i,
											'j' => $j,
											'j1' => $j1,
											'jumlah' => $jumlah,
											'id_rincian_distribusi' => $rincianDistribusi['id'],
											'username' => $this->username
					);
					$query = VulnWalkerInsert('temp_rincian_distribusi',$dataRincian);
					mysql_query($query);
					$getIdTempRincianDistribusi = mysql_fetch_array(mysql_query("select max(id) from temp_rincian_distribusi where username = '$this->username'"));
					$getAllDetailRincianDistribusi = mysql_query("select * from detail_rincian_distribusi where id_rincian_distribusi = '".$rincianDistribusi['id']."'");
					while ($detailRincianDistribusi = mysql_fetch_array($getAllDetailRincianDistribusi)) {
							$dataDetailRincian = array(
									'c1' => $detailRincianDistribusi['c1'],
									'c' => $detailRincianDistribusi['c'],
									'd' => $detailRincianDistribusi['d'],
									'e' => $detailRincianDistribusi['e'],
									'e1' => $detailRincianDistribusi['e1'],
									'jumlah' => $detailRincianDistribusi['jumlah'],
									'id_rincian_distribusi' => $getIdTempRincianDistribusi['max(id)'],
									'id_detail_rincian_distribusi' => $detailRincianDistribusi['id'],
									'username' => $this->username
							);
							mysql_query(VulnWalkerInsert("temp_detail_rincian_distribusi",$dataDetailRincian));
					}

				}
			}

				$content = array('skpd' => $kodeSKPD,'nomor'=> $nomor);
			break;
		}

		case 'Remove':{
			$id = $_REQUEST['penerimaanDistribusi_cb'];
			foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}

			$username = $_COOKIE['coID'];

			$get = mysql_fetch_array(mysql_query("select * from tabel_PENERIMAAN DISTRIBUSI BARANG PERSEDIAAN where id ='$id[0]'"));
			$kodeRek = $get['k'].".".$get['l'].".".$get['m'].".".$get['n'].".".$get['o'] ;

			$getAll = mysql_query("select * from tabel_PENERIMAAN DISTRIBUSI BARANG PERSEDIAAN where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and id_tahap='$this->idTahap' and rincian_perhitungan !=''   and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD'  and status_validasi !='1' order by o1, rincian_perhitungan");
			mysql_query("delete from temp_rka_21 where user='$username'");
			mysql_query("delete from temp_rincian_volume_21 where user='$username'");
		    mysql_query("delete from temp_alokasi_rka_21_v2 where user='$username'");
			while($rows = mysql_fetch_array($getAll)){
				foreach ($rows as $key => $value) {
				  $$key = $value;
				}
				mysql_query("delete from tabel_PENERIMAAN DISTRIBUSI BARANG PERSEDIAAN where id = '$id'");
				//mysql_query("delete from tabel_PENERIMAAN DISTRIBUSI BARANG PERSEDIAAN where concat(k,'.',l,'.',m,'.',n,'.',o) ='$kodeRek' and o1 ='$o1' and c1='$cmbUrusan' and c='$cmbBidang' and d='$cmbSKPD' and e='$cmbUnit' and e1='$cmbSubUnit' and jenis_rka='2.1' and tahun ='$this->tahun' and jenis_anggaran ='$this->jenisAnggaran'");

			}

			break;
		}





		case 'formAlokasi':{
				$dt[] = $_REQUEST['jumlahHarga'];
				$dt[] = $_REQUEST['id'];
				$fm = $this->formAlokasi($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


		break;
		}
		case 'formAlokasiTriwulan':{
				$jumlahHargaForm = $_REQUEST['jumlahHarga'];
				$id = $_REQUEST['id'];
				$fm = $this->formAlokasiTriwulan($dt);
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];


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
		 <A href=\"pages.php?Pg=pemasukan&halman=3\" title='PENERIMAAN' > PENERIMAAN </a> |
		 <A href=\"pages.php?Pg=penerimaanDistribusi\" title='DISTRIBUSI' style='color : blue;'> DISTRIBUSI </a>

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
			<script type='text/javascript' src='js/persediaan/distribusi/penerimaanDistribusi.js' language='JavaScript' ></script>
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
			$aqry = "SELECT * FROM  tabel_PENERIMAAN DISTRIBUSI BARANG PERSEDIAAN WHERE id='".$this->form_idplh."' "; $cek.=$aqry;
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
	 $this->form_caption = 'INFO PENERIMAAN DISTRIBUSI BARANG PERSEDIAAN';


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


	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){



		$headerTable =
		  "<thead>
		   <tr>
			 <th class='th01' width='20'>NO</th>
			 <th class='th01' width='20'></th>
			 <th class='th01' width='70'>TANGGAL</th>
		   <th class='th01' width='40'>NOMOR</th>
		   <th class='th01' width='1000'>NAMA BARANG</th>
		   <th class='th01' width='200'>MERK/ TYPE/ SPESIFIKASI</th>
		   <th class='th01' width='100'>SATUAN</th>
		   <th class='th01' width='50'>JUMLAH</th>
		   <th class='th01' width='50'>STATUS</th>



		   </tr>

		   </thead>";
			// <th class='th01' width='50'>POSTING</th>


	 $NomorColSpan = $Mode==1? 2: 1;


		return $headerTable;
	}

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 foreach ($isi as $key => $value) {
		  			$$key = $value;
	 }





		$getRincianDistribusi = mysql_fetch_array(mysql_query("select * from rincian_distribusi where id = '$id_rincian_distribusi'"));
		$getDistribusi = mysql_fetch_array(mysql_query("select * from distribusi where id = '".$getRincianDistribusi['id_distribusi']."'"));
		$getNamaBarang = mysql_fetch_array(mysql_query("select * from ref_barang where f1= '".$getRincianDistribusi['f1']."' and f2= '".$getRincianDistribusi['f2']."' and f= '".$getRincianDistribusi['f']."' and g= '".$getRincianDistribusi['g']."' and h= '".$getRincianDistribusi['h']."' and i= '".$getRincianDistribusi['i']."' and j= '".$getRincianDistribusi['j']."' and j1= '".$getRincianDistribusi['j1']."'"));
		$namaBarang = $getNamaBarang['nm_barang'];
		$satuanBarang = $getNamaBarang['satuan'];
		if($getDistribusi['id'] == $this->lastIdDistribusi){
				$TampilCheckBox = "";
		}else{
				$tanggalDistribusi = $this->generateDate($getDistribusi['tanggal']);
				$nomorDistribusi = $getDistribusi['nomor'];
		}
		if($getRincianDistribusi['id'] == $this->lastRincianDistribusi){
				$namaBarang = "";
				$satuanBarang = "";
		}
		$Koloms = array();
		$Koloms[] = array(' align="center"',$no);
		$Koloms[] = array(' align="center"',$TampilCheckBox);
		$Koloms[] = array(' align="center"',$tanggalDistribusi);
		$Koloms[] = array(' align="left"',$nomorDistribusi);
		$Koloms[] = array(' align="left"',$namaBarang);
		$Koloms[] = array(' align="left"',$getRincianDistribusi['merk']);
		$Koloms[] = array(' align="left"',$satuanBarang);
		$Koloms[] = array(' align="right"',number_format($jumlah,0,',','.'));
		if($status == '1'){
			$status = "<img src='images/administrator/images/valid.png' width='20px' heigh='20px' ></img>";
		}else{
			$status = "<img src='images/administrator/images/invalid.png' width='20px' heigh='20px'></img>";
		}
		$Koloms[] = array(' valign="middle" align="center"',$status);

		$this->lastIdDistribusi = $getDistribusi['id'];
		$this->lastRincianDistribusi = $getRincianDistribusi['id'];


	 return $Koloms;
	}
	function generateDate($tanggal){
			$tanggal = explode('-',$tanggal);
			$tanggal = $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];
			return $tanggal;
	}

	function Validasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 120;
	 $this->form_caption = 'VALIDASI PENERIMAAN DISTRIBUSI BARANG PERSEDIAAN 2.1';
	 $kode = $dt['c1'].".".$dt['c'].".".$dt['d'].".".$dt['e'].".".$dt['e1'].".".$dt['bk'].".".$dt['ck'].".".$dt['p'].".".$dt['q'].".".$dt['o1'];
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
						'label'=>'KODE',
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
	 $idnya = $dt['id'];

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

$jumlahData = $_REQUEST['jumlahData'];
if(empty($jumlahData))$jumlahData = 50;
			$TampilOpt =
					"<tr><td>".
					genFilterBar(array(WilSKPD_ajx3($this->Prefix.'SKPD2','100%','145px')),'','','').
					genFilterBar(
						array(
							"TAHUN &nbsp &nbsp <input type='text' value='".$_COOKIE['coThnAnggaran']."' style='width:40px;' readonly>&nbsp &nbsp &nbsp &nbsp JUMLAH DATA &nbsp &nbsp <input type='text' name ='jumlahData' id='jumlahData' value ='$jumlahData' style='width:40px;'>  &nbsp <input type='button' onclick =$this->Prefix.refreshList(true); value='Tampilkan'>"
					),'','','')

						;

		return array('TampilOpt'=>$TampilOpt);


	}

	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
		//kondisi -----------------------------------
		$arrKondisi = array();
		foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
		}
		if($penerimaanDistribusiSKPD2fmURUSAN !='00'){
				$arrKondisi[] = "c1 = '$penerimaanDistribusiSKPD2fmURUSAN'";
		}
		if($penerimaanDistribusiSKPD2fmSKPD !='00'){
				$arrKondisi[] = "c = '$penerimaanDistribusiSKPD2fmSKPD'";
		}
		if($penerimaanDistribusiSKPD2fmUNIT !='00'){
				$arrKondisi[] = "d = '$penerimaanDistribusiSKPD2fmUNIT'";
		}
		if($penerimaanDistribusiSKPD2fmSUBUNIT !='00'){
				$arrKondisi[] = "e = '$penerimaanDistribusiSKPD2fmSUBUNIT'";
		}
		if($penerimaanDistribusiSKPD2fmSEKSI !='00'){
				$arrKondisi[] = "e1 = '$penerimaanDistribusiSKPD2fmSEKSI'";
		}

		//$arrKondisi[] = "status_temp  != '1'";

		$Kondisi= join(' and ',$arrKondisi);
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi ;
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		$Asc1 = $fmDESC1 ==''? '': 'desc';
		$arrOrders = array();
		$arrOrders[] = "idDistribusi";
		$Order= join(',',$arrOrders);
		$OrderDefault = '';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;

		if(empty($jumlahData))$jumlahData =50;
		$this->pagePerHal = $jumlahData;
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal;
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);
		$NoAwal = $Mode == 3 ? 0: $NoAwal;

		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal );

	}

	function Hapus($ids){ //validasi hapus ref_kota
		 $err=''; $cek='';
		for($i = 0; $i<count($ids); $i++)	{


			$qy = "DELETE FROM $this->TblName_Hapus WHERE id='".$ids[$i]."' ";$cek.=$qy;
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

function formAlokasi($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';
	 $jumlahHargaForm = $_REQUEST['jumlahHarga'];
	 $id = $_REQUEST['id'];
	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );


	 $jenisAlokasi = $jenis_alokasi_kas;
	 $resultPenjumlahan = $jan + $feb + $mar + $apr + $mei + $jun + $jul + $agu + $sep + $okt + $nop + $des;
	 if(empty($jenisPerhitungan))$jenisPerhitungan = "MANUAL";
	 if(empty($jan))$jan="0";
	 if(empty($feb))$feb="0";
	 if(empty($mar))$mar="0";
	 if(empty($apr))$apr="0";
	 if(empty($mei))$mei="0";
	 if(empty($jun))$jun="0";
	 if(empty($jul))$jul="0";
	 if(empty($agu))$agu="0";
	 if(empty($sep))$sep="0";
	 if(empty($okt))$okt="0";
	 if(empty($nop))$nop="0";
	 if(empty($des))$des="0";
	 $selisih = $jumlahHargaForm - $resultPenjumlahan;
	 if($jenisAlokasi == "TRIWULAN"){
	 	$readOnly = "readOnly";
	 }
	 $cmbJenisAlokasi = cmbArray('jenisAlokasi','BULANAN',$arrayJenisAlokasi,'-- JENIS ALOKASI --',"onchange=$this->Prefix.jenisAlokasiChanged($id);") ;
	 $cmbJenisPerhitungan = cmbArray('jenisPerhitungan',$jenisPerhitungan,$arrayJenisPerhitungan,'-- JENIS PERHITUNGAN --',"onchange=$this->Prefix.jenisPerhitunganChanged();") ;
	 //items ----------------------
	  $this->form_fields = array(
			'1' => array(
						'label'=>'JUMLAH HARGA ',
						'labelWidth'=>150,
						'value'=>"<input type='hidden' name='jumlahHargaForm' id ='jumlahHargaForm'  value='$jumlahHargaForm'>
						<input type='text' value='Rp. ".number_format($jumlahHargaForm,2,',','.')."' readonly style='width:210px;'> ",
						 ),
			'2' => array(
						'label'=>'JENIS ALOKASI',
						'labelWidth'=>150,
						'value'=>$cmbJenisAlokasi,
						 ),
			'3' => array(
						'label'=>'SISTEM PERHITUNGAN',
						'labelWidth'=>150,
						'value'=>$cmbJenisPerhitungan." &nbsp <button type='button' id='buttonHitung' onclick='$this->Prefix.hitung();' disabled >HITUNG</button> ",
						 ),
			'4' => array(
						'label'=>'JANUARI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jan' id='jan' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='$jan' onkeyup=$this->Prefix.hitungSelisih('bantuJan'); > &nbsp <span id='bantuJan' style='color:red;'>".number_format($jan ,2,',','.')."</span> ",

						 ),
			'5' => array(
						'label'=>'FEBRUARI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='feb' id='feb' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$feb' onkeyup=$this->Prefix.hitungSelisih('bantuFeb'); > &nbsp <span id='bantuFeb' style='color:red;'>".number_format($feb ,2,',','.')."</span> ",

						 ),
			'6' => array(
						'label'=>'MARET',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='mar' id='mar' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$mar' onkeyup=$this->Prefix.hitungSelisih('bantuMar');> &nbsp <span id='bantuMar' style='color:red;'>".number_format($mar ,2,',','.')."</span> ",

						 ),
			'7' => array(
						'label'=>'APRIL',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='apr' id='apr' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$apr' onkeyup=$this->Prefix.hitungSelisih('bantuApr');> &nbsp <span id='bantuApr' style='color:red;'>".number_format($apr ,2,',','.')."</span> ",

						 ),
			'22' => array(
						'label'=>'MEI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='mei' id='mei' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$mei' onkeyup=$this->Prefix.hitungSelisih('bantuMei');> &nbsp <span id='bantuMei' style='color:red;'>".number_format($mei ,2,',','.')."</span> ",

						 ),
			'8' => array(
						'label'=>'JUNI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jun' id='jun' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$jun' onkeyup=$this->Prefix.hitungSelisih('bantuJun');> &nbsp <span id='bantuJun' style='color:red;'>".number_format($jun ,2,',','.')."</span> ",

						 ),
			'9' => array(
						'label'=>'JULI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jul' id='jul' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$jul' onkeyup=$this->Prefix.hitungSelisih('bantuJul');> &nbsp <span id='bantuJul' style='color:red;'>".number_format($jul,2,',','.')."</span> ",

						 ),
			'10' => array(
						'label'=>'AGUSTUS',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='agu' id='agu' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$agu' onkeyup=$this->Prefix.hitungSelisih('bantuAgu');> &nbsp <span id='bantuAgu' style='color:red;'>".number_format($agu ,2,',','.')."</span> ",

						 ),

			'11' => array(
						'label'=>'SEPTEMBER',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='sep' id='sep'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$sep' onkeyup=$this->Prefix.hitungSelisih('bantuSep');> &nbsp <span id='bantuSep' style='color:red;'>".number_format($sep ,2,',','.')."</span> ",

						 ),
			'12' => array(
						'label'=>'OKTOBER',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='okt' id='okt' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$okt' onkeyup=$this->Prefix.hitungSelisih('bantuOkt');> &nbsp <span id='bantuOkt' style='color:red;'>".number_format($okt ,2,',','.')."</span> ",

						 ),
			'13' => array(
						'label'=>'NOPEMBER',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='nop' id='nop' $readOnly onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$nop' onkeyup=$this->Prefix.hitungSelisih('bantuNop');> &nbsp <span id='bantuNop' style='color:red;'>".number_format($nop ,2,',','.')."</span> ",

						 ),
			'14' => array(
						'label'=>'DESEMBER',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='des' id='des' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$des' onkeyup=$this->Prefix.hitungSelisih('bantuDes');> &nbsp <span id='bantuDes' style='color:red;'>".number_format($des ,2,',','.')."</span> ",

						 ),
			'15' => array(
						'label'=>'JUMLAH HARGA ALOKASI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jumlahHargaAlokasi' id='jumlahHargaAlokasi' value='$resultPenjumlahan' readonly > &nbsp <span id='bantuPenjumlahan' style='color:red;'>".number_format($resultPenjumlahan ,2,',','.')."</span>",

						 ),
			'16' => array(
						'label'=>'SELISIH (+/-)',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='selisih' id='selisih' value='$selisih' readonly > &nbsp <span id='bantuSelisih' style='color:red;'>".number_format($selisih ,2,',','.')."</span>",

						 ),

			);
		//tombol

		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi($id);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function formAlokasiTriwulan($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 600;
	 $this->form_height = 430;
	 $this->form_caption = 'ALOKASI KAS';
	 $jumlahHargaForm = $_REQUEST['jumlahHarga'];
	 $id = $_REQUEST['id'];
	 $arrayJenisAlokasi = array(
	 							array('BULANAN','BULANAN'),
								array('TRIWULAN','TRIWULAN')
						  );
	$arrayJenisPerhitungan = array(
	 							array('SEMI OTOMATIS','SEMI OTOMATIS'),
								array('MANUAL','MANUAL')
						  );

	 $username = $_COOKIE['coID'];
	 $getAlokasi = mysql_fetch_array(mysql_query("select * from temp_alokasi_rka_v2 where user='$username'"));
	 foreach ($getAlokasi as $key => $value) {
				  $$key = $value;
			}
	 $jenisAlokasi = $jenis_alokasi_kas;
	 $resultPenjumlahan = $jan + $feb + $mar + $apr + $mei + $jun + $jul + $agu + $sep + $okt + $nop + $des;
	 if(empty($jenisPerhitungan))$jenisPerhitungan = "MANUAL";
	 if(empty($jan))$jan="0";
	 if(empty($feb))$feb="0";
	 if(empty($mar))$mar="0";
	 if(empty($apr))$apr="0";
	 if(empty($mei))$mei="0";
	 if(empty($jun))$jun="0";
	 if(empty($jul))$jul="0";
	 if(empty($agu))$agu="0";
	 if(empty($sep))$sep="0";
	 if(empty($okt))$okt="0";
	 if(empty($nop))$nop="0";
	 if(empty($des))$des="0";
	 $selisih = $jumlahHargaForm - $resultPenjumlahan;
	 if($jenisAlokasi == "TRIWULAN"){
	 	$readOnly = "readOnly";
	 }
	 $cmbJenisAlokasi = cmbArray('jenisAlokasi','TRIWULAN',$arrayJenisAlokasi,'-- JENIS ALOKASI --',"onchange=$this->Prefix.jenisAlokasiChanged($id);") ;
	 $cmbJenisPerhitungan = cmbArray('jenisPerhitungan',$jenisPerhitungan,$arrayJenisPerhitungan,'-- JENIS PERHITUNGAN --',"onchange=$this->Prefix.jenisPerhitunganChanged();") ;
	 //items ----------------------
	  $this->form_fields = array(
			'1' => array(
						'label'=>'JUMLAH HARGA',
						'labelWidth'=>150,
						'value'=>"<input type='hidden' name='jumlahHargaForm' id ='jumlahHargaForm'  value='$jumlahHargaForm'> <input type='text' value='Rp. ".number_format($jumlahHargaForm,2,',','.')."' readonly style='width:210px;'>",
						 ),
			'2' => array(
						'label'=>'JENIS ALOKASI',
						'labelWidth'=>150,
						'value'=>$cmbJenisAlokasi,
						 ),
			'3' => array(
						'label'=>'SISTEM PERHITUNGAN',
						'labelWidth'=>150,
						'value'=>$cmbJenisPerhitungan." &nbsp <button type='button' id='buttonHitung' onclick='$this->Prefix.hitung();' disabled >HITUNG</button>  <input type='hidden' name='jan' id='jan'><input type='hidden' name='feb' id='feb'> <input type='hidden' name='apr' id='apr'> <input type='hidden' name='mei' id='mei'> <input type='hidden' name='jul' id='jul'> <input type='hidden' name='agu' id='agu'> <input type='hidden' name='okt' id='okt'> <input type='hidden' name='nop' id='nop'> ",
						 ),
			'6' => array(
						'label'=>'TRIWULAN 1',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='mar' id='mar' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$mar' onkeyup=$this->Prefix.hitungSelisih('bantuMar');> &nbsp <span id='bantuMar' style='color:red;'>".number_format($mar ,2,',','.')."</span> ",

						 ),
			'8' => array(
						'label'=>'TRIWULAN 2',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jun' id='jun' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$jun' onkeyup=$this->Prefix.hitungSelisih('bantuJun');> &nbsp <span id='bantuJun' style='color:red;'>".number_format($jun ,2,',','.')."</span> ",

						 ),
			'11' => array(
						'label'=>'TRIWULAN 3',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='sep' id='sep'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$sep' onkeyup=$this->Prefix.hitungSelisih('bantuSep');> &nbsp <span id='bantuSep' style='color:red;'>".number_format($sep ,2,',','.')."</span> ",

						 ),
			'14' => array(
						'label'=>'TRIWULAN 4',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='des' id='des' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  value='$des' onkeyup=$this->Prefix.hitungSelisih('bantuDes');> &nbsp <span id='bantuDes' style='color:red;'>".number_format($des ,2,',','.')."</span> ",

						 ),
			'15' => array(
						'label'=>'JUMLAH HARGA ALOKASI',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='jumlahHargaAlokasi' id='jumlahHargaAlokasi' value='$resultPenjumlahan' readonly > &nbsp <span id='bantuPenjumlahan' style='color:red;'>".number_format($resultPenjumlahan ,2,',','.')."</span>",

						 ),
			'16' => array(
						'label'=>'SELISIH (+/-)',
						'labelWidth'=>150,
						'value'=> "<input type='text' name='selisih' id='selisih' value='$selisih' readonly > &nbsp <span id='bantuSelisih' style='color:red;'>".number_format($selisih ,2,',','.')."</span>",

						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveAlokasi($id);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}


    function newJob($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'PEKERJAAN BARU';


	 //items ----------------------
	  $this->form_fields = array(
			'namaPekerjaan' => array(
						'label'=>'NAMA PEKERJAAN',
						'labelWidth'=>130,
						'value'=>"<input type='text' name='namaPekerjaan' id='namaPekerjaan' style='width:210px;'>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveJob();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function editJob($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 400;
	 $this->form_height = 80;
	 $this->form_caption = 'EDIT PEKERJAAN';

	 $getNamaPekerjaan = mysql_fetch_array(mysql_query("select * from ref_pekerjaan where id='$dt'"));
	 $namaPekerjaan = $getNamaPekerjaan['nama_pekerjaan'];

	 //items ----------------------
	  $this->form_fields = array(
			'namaPekerjaan' => array(
						'label'=>'NAMA PEKERJAAN',
						'labelWidth'=>130,
						'value'=>"<input type='text' name='namaPekerjaan' id='namaPekerjaan' value='$namaPekerjaan' style='width:210px;'>",
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveEditJob();' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function Gruping($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 foreach ($_REQUEST as $key => $value) {
				  $$key = $value;
			}
	 $this->form_width = 600;
	 $this->form_height = 80;
	 $this->form_caption = 'Gruping Pekerjaan';
	 $codeAndNamePekerjaan = "select id, nama_pekerjaan from ref_pekerjaan  ";
	 $cmbPekerjaan = cmbQuery('pekerjaan', $pekerjaan, $codeAndNamePekerjaan,"  ",'-- PEKERJAAN --');

	 //items ----------------------
	  $this->form_fields = array(
			'pekerjaan' => array(
						'label'=>'PEKERJAAN',
						'labelWidth'=>100,
						'value'=>$cmbPekerjaan." &nbsp <button type='button' onclick=$this->Prefix.newJob(); >Tambah</button>  &nbsp <button type='button' onclick=$this->Prefix.editJob(); >Edit</button>
								<input type='hidden' name='anggota' id='anggota' value='$dt'>
								",
						 ),


			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".setGrup()' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function checkKosong($jumlah){
			if($jumlah == 0 || $jumlah == ''){
					$jumlah = "";
			}
			return $jumlah;
	}

	function nullChecker($angka){
		if(empty($angka)){
				$angka = "";
		}
		return $angka;

	}

	function removeKoma($angka){
			return str_replace(".00","",$angka);
	}

	function formRincianVolume($dt){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 500;
	 $this->form_height = 180;
	 $this->form_caption = 'DETAIL VOLUME';
	 $jumlahHargaForm = $dt;
	 $username =$_COOKIE['coID'];
	//  $getRincianVolume = mysql_fetch_array(mysql_query("select * from tabel_PENERIMAAN DISTRIBUSI BARANG PERSEDIAAN where id ='$dt'"));
	//  foreach ($getRincianVolume as $key => $value) {
	// 			  $$key = $value;
	// 	}

	foreach ($_REQUEST as $key => $value) {
				 $$key = $value;
	 }
	 if(empty($volume3Temp) && !empty($volume2Temp)){
	  $totalResult = $volume1Temp * $volume2Temp ;
	  $volume3Temp = "";
		 $satuanVolume = $satuan1Temp." / ".$satuan2Temp;

	}elseif(empty($volume2Temp)){
	 $totalResult = $volume1Temp  ;
	 $volume3Temp = "";
	 $volume2Temp = "";
	$satuanVolume = $satuan1Temp;
	}else{
	  $totalResult = $jumlah1 * $jumlah2 * $jumlah3 ;
		$satuanVolume = $satuan1Temp." / ".$satuan2Temp." / ".$satuan3Temp;
	 }
// <input type='hidden' id='volumeRek' value='$volume_rek'>
	 //items ----------------------
	  $this->form_fields = array(
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 1 &nbsp<input type='text' id='jumlah1' value='$volume1Temp' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder='JUMLAH'> &nbsp SATUAN 1   &nbsp&nbsp&nbsp&nbsp&nbsp  <input type='text' name ='satuan1' id ='satuan1' value='$satuan1Temp'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 2 &nbsp<input type='text' id='jumlah2' placeholder='JUMLAH' value='".$this->nullChecker($volume2Temp)."' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp SATUAN 2  &nbsp&nbsp&nbsp&nbsp&nbsp    <input type='text' value='$satuan2Temp' name ='satuan2' id ='satuan2'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" JUMLAH 3 &nbsp<input type='text' id='jumlah3' placeholder='JUMLAH' value='".$this->nullChecker($volume3Temp)."' onkeyup='$this->Prefix.setTotalRincian();'  onkeypress='return event.charCode >= 48 && event.charCode <= 57'> &nbsp SATUAN 3  &nbsp&nbsp&nbsp&nbsp&nbsp  <input type='text' value='$satuan3Temp'name ='satuan3' id ='satuan3'>",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>"",
						 ),
			array( 		'label' => '',
						'labelWidth' => 1,
						'pemisah' => ' ',
						'value'=>" VOLUME &nbsp &nbsp<input type='text' value='$totalResult' placeholder='JUMLAH' id='jumlah4' readonly >&nbsp SATUAN VOL &nbsp <input type='text' name ='satuanVolume' id ='satuanVolume' style='width:150px;'  value='$satuanVolume' readonly> &nbsp &nbsp <span id='detailVolumeRincian'>",
						 ),
			 array( 		'label' => '',
 						'labelWidth' => 1,
 						'pemisah' => ' ',
 						'value'=>"",
 						 ),
	 			array( 	'label' => '',
	 						'labelWidth' => 1,
	 						'pemisah' => ' ',
	 						'value'=>" URAIAN VOLUME &nbsp <input type='text' value='$uraianVolume' placeholder=''  id='rincianVolumeTemp' style='width:330px;' >",
	 						 ),


			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SaveRincianVolume($dt);' title='Simpan' >   ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

	function kasihNol($angka){
			if($angka < 10){
					$hubla = "000".$angka;
			}elseif($angka < 100){
					$hubla = "00".$angka;
			}elseif($angka < 1000){
					$hubla = "0".$angka;
			}elseif($angka < 10000){
					$hubla = $angka;
			}
			return $hubla;
	}

	function Posting($idPosting){
	 global $SensusTmp;
	 $cek = ''; $err=''; $content='';
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';
	 $this->form_width = 350;
	 $this->form_height = 80;

		$this->form_caption = 'Posting';
		$getDataDetailRincianDistribusi = mysql_fetch_array(mysql_query("select * from detail_rincian_distribusi where id = '$idPosting'"));
		$getDataRincianDistribusi = mysql_fetch_array(mysql_query("select * from rincian_distribusi where id = '".$getDataDetailRincianDistribusi['id_rincian_distribusi']."'"));
		$getDataDistribusi = mysql_fetch_array(mysql_query("select * from distribusi where id ='".$getDataRincianDistribusi['id_distribusi']."'"));
		$explodeNomor = explode("/",$getDataDistribusi['nomor']);
		$nomor = $explodeNomor[0]."/".$explodeNomor[1]."/".$getDataDistribusi['c1'].".".$getDataDistribusi['c'].".".$getDataDistribusi['d'].".".$getDataDetailRincianDistribusi['e'].".".$getDataDetailRincianDistribusi['e1']."/".$explodeNomor[3];

		$jumlahData = mysql_num_rows(mysql_query("select * from detail_rincian_distribusi where id_rincian_distribusi = '".$getDataRincianDistribusi['id']."' and c1 = '".$getDataDetailRincianDistribusi['c1']."' and c = '".$getDataDetailRincianDistribusi['c']."' and d = '".$getDataDetailRincianDistribusi['d']."' and e = '".$getDataDetailRincianDistribusi['e']."' and e1 = '".$getDataDetailRincianDistribusi['e1']."'"));

		$jumlahChecked = mysql_num_rows(mysql_query("select * from detail_rincian_distribusi where id_rincian_distribusi = '".$getDataRincianDistribusi['id']."' and c1 = '".$getDataDetailRincianDistribusi['c1']."' and c = '".$getDataDetailRincianDistribusi['c']."' and d = '".$getDataDetailRincianDistribusi['d']."' and e = '".$getDataDetailRincianDistribusi['e']."' and e1 = '".$getDataDetailRincianDistribusi['e1']."' and status = '1'"));

		if($jumlahData == $jumlahChecked)$statusPosting = "checked";
	 //items ----------------------
	  $this->form_fields = array(
	  	'kode0' => array(
					'label'=>'NOMOR DISTRIBUSI',
				'labelWidth'=>150,
				'value'=> $nomor.
				"


				"

				 ),

			'kode12' => array(
						'label'=>'STATUS POSTING',
						'labelWidth'=>150,
						'value'=> "<input type='checkbox' name='statusPosting' id='statusPosting' $statusPosting>"
						 ),

			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".savePosting($idPosting)' title='Simpan' >  &nbsp  ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";

		$form = $this->genForm();
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}

}
$penerimaanDistribusi = new penerimaanDistribusiObj();
$penerimaanDistribusi->username = $_COOKIE['coID'];



?>
