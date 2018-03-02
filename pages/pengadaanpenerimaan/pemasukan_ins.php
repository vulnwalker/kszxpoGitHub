<?php
 //if($_COOKIE['cofmSEKSI'] == '000' || $_REQUEST['pemasukanSKPDfmSEKSI']=='')header("Location:pages.php?Pg=pemasukan");
 
 include "pages/pengadaanpenerimaan/pemasukan.php";
 $DataPemasukan = $pemasukan;

class pemasukan_insObj  extends DaftarObj2{	
	var $Prefix = 'pemasukan_ins';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_penerimaan_barang'; //bonus
	var $TblName_Hapus = 't_penerimaan_barang';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'PENGADAAN DAN PENERIMAAN';
	var $PageIcon = 'images/pengadaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pemasukan.xls';
	var $namaModulCetak='PENGADAAN DAN PENERIMAAN';
	var $Cetak_Judul = 'Pemasukan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'pemasukan_insForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	var $refid_terima = '';
		
	function setTitle(){
		$data = "PENGADAAN DAN PENERIMAAN BARANG";
		$Hal = cekPOST2('pil_jns_trans');
		
		if($Hal == "2")$data="PENGADAAN DAN PEMELIHARAAN BARANG";
		if($Hal == "3")$data="PENGADAAN DAN PERSEDIAAN BARANG";
		return $data;
	}
	
	function setMenuEdit(){
		return "";
	}
	
	function setMenuView(){
		return "";
	}
	
	function simpanNomorDokumen(){
		global $HTTP_COOKIE_VARS, $DataPengaturan, $Main, $DataPemasukan;
		$uid = $HTTP_COOKIE_VARS['coID'];
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$cek = ''; $err=''; $content='';
		$Tbl_Edit = $DataPemasukan->TblName_refNomDok;
		//get data -----------------
		$fmST = cekPOST2($this->Prefix.'_fmST');
		$idplh = cekPOST2($this->Prefix.'_idplh');	 
		$nomdok2= cekPOST2('nomdok2');
		$tgl_dok= cekPOST2('tgl_doku')."-".$coThnAnggaran;
		$c1= cekPOST2('c1');
		$c= cekPOST2('c');
		$d= cekPOST2('d');	 
			  
		if($err=='' && $nomdok2 =='') $err= 'Nomor Dokumen Belum Di Isi !!';
		if($err=='' && $tgl_dok =='') $err= 'Tanggal Dokumen Belum Di Isi !!';
		
		$tgl_dok = explode("-",$tgl_dok);
		$tgl_dok = $tgl_dok[2].'-'.$tgl_dok[1].'-'.$tgl_dok[0];
		if( $err=='' && !cektanggal($tgl_dok)) $err= 'Tanggal Dokumen Tidak Valid'; 
		 
		if($err == "" && $fmST==0){
			$Hit_Dok = $DataPengaturan->QryHitungData($Tbl_Edit, " WHERE nomor_dok='$nomdok2' AND c1='$c1' AND c='$c' AND d='$d' "); 
			if($Hit_Dok['hasil'] > 0)$err='Nomor Dokumen Telah Ada !';
		}		 
		if($err==''){
			$data = array(
					array("nomor_dok", $nomdok2),
					array("tgl_dok", $tgl_dok),
				);
			if($fmST == 0){	
				array_push($data,
					array("c1",$c1),
					array("c",$c),
					array("d",$d)
				);	
				$qry = $DataPengaturan->QryInsData($Tbl_Edit,$data);
			}else{
				$IdUbah = cekPOST2("IdDokumenSum"); 		
				$qryUbah = $DataPengaturan->QryUpdData($Tbl_Edit, $data, "WHERE Id='$IdUbah' ");
				if($qryUbah["errmsg"] != "")$err=$qryUbah["errmsg"];
			}	
			$content['nomdok'] = $nomdok2;
		}
				
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}	
	
	function simpanPenyedia(){
	 global $HTTP_COOKIE_VARS, $DataPengaturan;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = cekPOST2($this->Prefix.'_fmST');
	 $idplh = cekPOST2($this->Prefix.'_idplh');
	 
	 $namapenyedia= cekPOST2('namapenyedia');
	 $alamatpenyedia= cekPOST2('alamatpenyedia');
	 $kotapenyedia= cekPOST2('kotapenyedia');
	 $namapimpinan= cekPOST2('namapimpinan');
	 $nonpwp= cekPOST2('nonpwp');
	 $norekeningbank= cekPOST2('norekeningbank');
	 $namabank= cekPOST2('namabank');
	 $atasnamabank= cekPOST2('atasnamabank');
	 $c1= cekPOST2('c1nya');
	 $c= cekPOST2('cnya');
	 $d= cekPOST2('dnya');
	 
	 	  
	 if( $err=='' && $namapenyedia =='' ) $err= 'Nama Penyedia Belum Di Isi !';
	 if($Main->CekNPWP_PenyediaBarang){
	 	 if( $err=='' && $nonpwp =='' ) $err= 'No NPWP Belum Di Isi ! Penyedia Belum Di Isi !!';
		 //CEK Di ref_tandatangan
		 if($err == ""){
		 	 $Qry_Cek = $DataPengaturan->QryHitungData("ref_penyedia","WHERE c1='$c1' AND c='$c' AND d='$d' AND no_npwp='$nonpwp' AND Id !='$idplh'");
			 if($Qry_Cek["hasil"] > 0)$err = "No NPWP Sudah Ada !";
		 }
	 }
	
	 
	 //if($err == "")$err="dgdff";
	 
	 if($err == ""){
	 	if($fmST == 0){	
			$data = array(
						array("c1",$c1),array("c",$c),array("d",$d),
						array("kota", $kotapenyedia), array("nama_pimpinan",$namapimpinan),
						array("nama_penyedia",$namapenyedia),array("alamat",$alamatpenyedia),array("no_npwp",$nonpwp),
						array("nama_bank",$namabank),array("norek_bank",$norekeningbank),array("atasnama_bank",$atasnamabank),
					);
			$qry_ins = $DataPengaturan->QryInsData("ref_penyedia", $data);$cek.=$qry_ins["cek"];
			$qry_tmpl = $DataPengaturan->QyrTmpl1Brs2("ref_penyedia","id", $data, " ORDER BY Id DESC ");
			$dtId = $qry_tmpl["hasil"];
						
			
	 	}else{
			$data = array(
						array("nama_penyedia",$namapenyedia),array("alamat",$alamatpenyedia),array("no_npwp",$nonpwp),
						array("kota", $kotapenyedia), array("nama_pimpinan",$namapimpinan),
						array("nama_bank",$namabank),array("norek_bank",$norekeningbank),array("atasnama_bank",$atasnamabank),
					);
			$qry_upd = $DataPengaturan->QryUpdData("ref_penyedia", $data, "WHERE id='$idplh'");$cek.=$qry_upd["cek"];
			$dtId['id'] = $idplh;
		}		
		
		$qrypenyedia = "SELECT id,nama_penyedia FROM ref_penyedia WHERE c1='$c1' AND c='$c' AND d='$d' ";			
		$content['penyedian'] = cmbQuery('penyedian',$dtId['id'],$qrypenyedia," style='width:303px;' ","--- PILIH PENYEDIA BARANG ---");
	 }
	 
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function simpanPenerima(){
	 global $HTTP_COOKIE_VARS, $DataPengaturan;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 
	 
	 $c1= cekPOST2('c1_penerima');
	 $c= cekPOST2('c_penerima');
	 $d= cekPOST2('d_penerima');
	 $e= cekPOST2('e_penerima');
	 $e1= cekPOST2('e1_penerima');
	 $namapegawai= cekPOST2('namapegawai');
	 $nippegawai= cekPOST2('nippegawai');
	 $pangkatakhir= cekPOST2('pangkatakhir');
	 $jabatan= cekPOST2('jabatan');
	 $eselon_akhir= cekPOST2('eselon_akhir');
	 $golang_akhir= cekPOST2('golang_akhir');
	 
	 	  
	 if($err=='' && $namapegawai =='') $err= 'Nama Pegawai Belum Di Isi !!';
	 if($err=='' && $nippegawai =='') $err= 'NIP Belum Di Isi !!';
	 //if( $err=='' && $pangkatakhir =='' ) $err= 'Pangkat Belum Di Pilih !!';
	 if($err=='' && $jabatan =='') $err= 'Jabatan Belum Di Isi !!';
	 //if( $err=='' && $eselon_akhir =='' ) $err= 'Eselon Belum Di Pilih !!';
	 
	 $golru = explode("/",$golang_akhir);
	 $gol = $golru[0];
	 $ruang = $golru[1];
	 
	 //CEK Di ref_tandatangan
	 if($err == ""){
	 	 $Qry_Cek = $DataPengaturan->QryHitungData("ref_tandatangan","WHERE c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' AND nip='$nippegawai' AND Id != '$idplh' ");
		 if($Qry_Cek["hasil"] > 0)$err = "NIP Sudah Ada !";
	 }
	
	$data = array(
				array("nip", $nippegawai), array("nama", $namapegawai), array("jabatan", $jabatan),
				array("pangkat", $pangkatakhir), array("gol", $gol), array("ruang", $ruang), 
				array("eselon", $eselon_akhir),
			);
	 
	if($err==''){	 
		if($fmST == 0){
			array_push($data, array("c1",$c1), array("c",$c), array("d",$d), array("e",$e), array("e1",$e1));
			
			$qry = $DataPengaturan->QryInsData("ref_tandatangan", $data);
			
			$qry_penyedia = $DataPengaturan->QyrTmpl1Brs2("ref_tandatangan", "Id, nama", $data, "ORDER BY Id DESC");
			$dtId = $qry_penyedia["hasil"];			
			
		}else{		
			$qry = $DataPengaturan->QryUpdData("ref_tandatangan", $data,"WHERE Id='$idplh' ");
			$dtId['Id'] = $idplh;
		}
		$qrypenyedia = "SELECT Id,nama FROM ref_tandatangan WHERE c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' ";		
		$content['penerima'] = cmbQuery('penerima',$dtId['Id'],$qrypenyedia," style='width:303px;' ","--- PILIH PENERIMA BARANG ---");
		
		if(isset($HTTP_COOKIE_VARS['CoPenerima']))unset($_COOKIE["CoPenerima"]);
		setcookie("CoPenerima", $dtId['Id'], time() + (86400 * 30), "/");
	 } //end else
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function Sebelum_SimpanSemua(){
		global $DataPengaturan, $Main;
		$cek='';$err='';
		
		$idplh = cekPOST2($this->Prefix.'_idplh');
		$jns_transaksi = cekPOST2("jns_transaksi");
		$cara_bayar = cekPOST2("cara_bayar");
		$status_kdp = cekPOST2("status_kdp");
		
		$where = " status!= '2' AND refid_terima='$idplh' ";
		
		//khusus transaksi pengadaan (penerimaan-pengadaan), jika  pembayaran =  termin/uang muka  : ------------------	
		//if($jns_transaksi == "1" && ($cara_bayar=="1" || $cara_bayar=="2")){
		if($jns_transaksi == "1" && $cara_bayar=="2"){
			$qry1 = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang_det", "IFNULL(SUM(jml),0) as jml_brg","WHERE $where ");
			$dt1 = $qry1["hasil"];
			if($dt1["jml_brg"] > 1)$err="Pembayaran Termin, Rincian Penerimaan Barang Harus 1 Barang !";
			if($err == ""){
				$qry2 = $DataPengaturan->QryHitungData("t_penerimaan_barang_det", "WHERE f='".$Main->KIB_F."' AND $where");
				if($qry2["hasil"] == 0 && $status_kdp == "1")$err = "Untuk Pembayaran Termin/Uang Muka , Kode Barang disi KIB F (Konstruksi Dalam Pengerjaan), kode barang asli nya bisa ditulis di keterangan !";
			}		
		}
		// ----------------------------------------------------------------------------------------------------------
				
		return array("cek"=>$cek, "err"=>$err);
	}	
	
	function Cek_NomDok($Id){
		global $DataPengaturan;
		
		$err='';
		$nomdok = cekPOST2('nomdok');
		$tgl_dok = cekPOST2('tgl_dok');
		$jns_transaksi= cekPOST2('jns_transaksi');
		$cara_bayar= cekPOST2('cara_bayar');
		
		if($jns_transaksi == 1){
			//Cek Apakah Ada Barang Lain yang sudah lunas ?
			$qry1 = $DataPengaturan->QryHitungData("t_penerimaan_barang", "WHERE Id!='$Id' AND jns_trans='1' AND cara_bayar='3' AND nomor_kontrak='$nomdok' AND tgl_kontrak='$tgl_dok' ");
			if($err == "" && $qry1["hasil"] > 0)$err="Tanggal dan Nomor Dokumen Kontrak Sudah Ada Yang Di Bayar Lunas, Tidak Bisa di Gunakan !";
			//$err=$qry1['cek'];
		}
		
		
		return $err;
	}
	
	function SimpanSemua_ValidasiDPA($Id){
		global $DataPemasukan, $DataPengaturan;
		$err = "";
		
		if($DataPemasukan->Cek_DataDPA($Id,1) == 1){
			$qry = $DataPengaturan->QryHitungData($DataPemasukan->TblName_det,"WHERE refid_terima='$Id' AND status!='2' AND refid_dpa!='0' AND jml='0'");
			if($qry["hasil"] > 0)$err="Data Tidak Bisa Disimpan, Masih Ada Rincian Barang Yang Ber-Volume 0 !";
		}
		return $err;
	}
	function SimpanSemua(){
	 global $HTTP_COOKIE_VARS,$DataPengaturan;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $c1= $_REQUEST['c1nya'];
	 $c= $_REQUEST['cnya'];
	 $d= $_REQUEST['dnya'];
	 $e= $_REQUEST['enya'];
	 $e1= $_REQUEST['e1nya'];
	 
	 $jns_transaksi= cekPOST2('jns_transaksi');
	 $asalusul= cekPOST2('asalusul');
	 $sumberdana= cekPOST2('sumberdana');
	 $metodepengadaan= cekPOST2('metodepengadaan');
	 $pencairan_dana= cekPOST2('pencairan_dana');
	 $prog= cekPOST2('prog');
	 $kegiatan= cekPOST2('kegiatan');
	 $pekerjaan	= cekPOST2('pekerjaan');
	 $nomdok = cekPOST2('nomdok');
	 $tgl_dok = cekPOST2('tgl_dok');//Langsung
	 $cara_bayar = cekPOST2('cara_bayar');
	 $dokumen_sumber = cekPOST2('dokumen_sumber');
	 $thn_dokumen_bast = $asalusul != "3"?$coThnAnggaran:cekPOST2('thn_dokumen_bast');
	 $tgl_dokumen_bast = cekPOST2('tgl_dokumen_bast')."-".$thn_dokumen_bast;
	 $nomor_dokumen_bast = cekPOST2('nomor_dokumen_bast');
	 $penyedian = cekPOST2('penyedian');
	 $penerima = cekPOST2('penerima');
	 $tgl_buku = cekPOST2('tgl_buku')."-".$coThnAnggaran;
	 $biayaatribusi = cekPOST2('biayaatribusi');
	 $keterangan_penerimaan = cekPOST2('keterangan_penerimaan');
	 $status_kdp = cekPOST2('status_kdp',0);
	 
	 $ID_BIRM =cekPOST2("kode_account_ap");
	  
	 //default
	 if($asalusul != "1")$metodepengadaan = '1';
	 
	 $tgl_dokumen_bast = FormatTanggalnya($tgl_dokumen_bast);
	 $tgl_buku = FormatTanggalnya($tgl_buku);
	 
	if($jns_transaksi == '' && $err=='')$err = 'Transaksi Belum di Pilih !';
	if($asalusul == '' && $err=='')$err = 'Cara Perolehan Belum di Pilih !';
	if($sumberdana == '' && $err=='')$err = 'Sumber Dana Belum di Pilih !';
	if($metodepengadaan == '' && $err=='')$err = 'Metode Pengadaan Belum di Pilih !';
	if($pencairan_dana == '' && $err=='' && $asalusul=='1')$err = 'Metode Pencairan Dana Belum di Pilih !';
	if($prog == '' && $err=='' && $asalusul=='1')$err = 'Program Belum di Isi !';
	if($kegiatan == '' && $err=='' && $asalusul=='1')$err = 'Kegiatan Belum di Pilih !';
	if($pekerjaan == '' && $err=='' && $asalusul=='1')$err = 'Pekerjaan Belum di Isi !';
	if($nomdok == '' && $err=='' && $asalusul=='1')$err = 'Dokumen Kontrak Belum di Pilih !';	
	
	if($asalusul=='1')if($cara_bayar == '' && $err=='')$err = 'Cara Bayar Belum di Pilih !';
	if($dokumen_sumber == '' && $err=='')$err = 'Dokumen Sumber Belum di Pilih !';
	if($tgl_dok == '' && $err=='' && $asalusul=='1')$err = 'Tanggal Dokumen Kontrak Belum di Isi !';
	if($nomor_dokumen_bast == '' && $err=='')$err = 'Nomor Dokumen Sumber Belum di Isi !';
	if($tgl_buku == '' && $err=='')$err = 'Tanggal Buku Belum di Isi !';
	if($biayaatribusi == '' && $err=='')$err = 'Biaya Atribusi Belum di Pilih !';
	
	if($asalusul=='1')if( $err=='' && !cektanggal($tgl_dok)) $err= 'Tanggal Dokumen Kontrak Tidak Valid';
	if( $err=='' && !cektanggal($tgl_dokumen_bast)) $err= 'Tanggal Dokumen BAST Tidak Valid';
	if( $err=='' && !cektanggal($tgl_buku)) $err= 'Tanggal Buku Tidak Valid';
	
	//Cek Tahun Dokumen Kontrak ------------------------------
	if($asalusul=='1')if($err == "" && intval(substr($tgl_dok,0,4)) > intval($coThnAnggaran))$err = "Tahun Dokumen Kontrak Tidak Boleh Melebihi Tahun Login !";
	//-----------------------------------------------
	
	//Cek Tahun BAST ---------------------------------
	if($err == "" && intval(substr($tgl_dokumen_bast,0,4)) > intval($coThnAnggaran))$err = "Tahun $dokumen_sumber Tidak Boleh Melebihi Tahun Login !";
	//-----------------------------------------------
		
		
		if($err=="")$err = $this->CekBarangInputValid($idplh);
		if($err == ""){
			if($asalusul == '1'){
			$periksasesuai = $this->cekSesuai();
			$contentperiksa = $periksasesuai['content']; 
			if($contentperiksa['statussesuai'] != '1')$err='Total Belanja Dan Rincian Penerimaan Barang Belum Sesuai !';
			//$idpenerimaan = $contentperiksa['idpenerimaaan'];
			$cek.=$periksasesuai['cek'];
			}else{
				$ambilKodePenerimaan = $this->KodePenerimaan();
				//$idpenerimaan = $ambilKodePenerimaan['content'];
			}
		}
		
		$ambilKodePenerimaan = $this->KodePenerimaan();
		$idpenerimaan = $ambilKodePenerimaan['content'];
		
		//Cek Barang Apa Sudah Di Input
		if($this->CekJumlahBarangInput($idplh) == '0' && $err == '')$err="Jumlah Penerimaan Barang, Belum Ada !";
		
		//Cek Ada Data Di Rekening 
		if($err == "")$err = $this->Get_PeriksaRekeningPenerimaan();
		
		//Cek Apakah No Dokumen Kontrak Sudah Di Pakai ?
		if($err == "")$err=$this->Cek_NomDok($idplh);
		
		if($err == ""){
			$BeforeSimpanSemua = $this->Sebelum_SimpanSemua();
			$err=$BeforeSimpanSemua["err"];
			$cek.=$BeforeSimpanSemua["cek"];
		}
		
		//Cek DPA -- UPDATE 29 DESEMBER 2017 -----------------------------------------------
		if($err == "")$err=$this->SimpanSemua_ValidasiDPA($idplh);
		
		if($err == ''){
			$whereIdTerima = "WHERE refid_terima='$idplh' ";
			//Penerimaan Barang Detail
			$qrybrgdet = "UPDATE t_penerimaan_barang_det SET status='0', sttemp='0' WHERE refid_terima='$idplh' AND status='1'";$cek.=$qrybrgdet;
			$aqrybrgdet = mysql_query($qrybrgdet);			
			
			$DelPenDet = $DataPengaturan->QryDelData("t_penerimaan_barang_det",$whereIdTerima." AND status='2' ");
			$cek.=$DelPenDet["cek"];
			
			//Penerimaan Data Rekening
			$qrybrgRek = "UPDATE t_penerimaan_rekening SET sttemp='0' WHERE refid_terima='$idplh' AND status='0'";$cek.=$qrybrgRek;
			$aqrybrgRek = mysql_query($qrybrgRek);			
			
			
			$DelRek = $DataPengaturan->QryDelData("t_penerimaan_rekening",$whereIdTerima." AND status='2' ");
			$cek.=$DelRek["cek"];
			
			$this->BUATBarcode($idpenerimaan,'PENGADAAN',$idplh);
			
			if($biayaatribusi == "0"){ //UPDATE 28Feb2018 Hapus Atribusi
				$DelAtr = $DataPengaturan->QryDelData("t_atribusi",$whereIdTerima);$cek.=$DelAtr["cek"];
			}
			
			$prog = explode(".",$prog);
			$bknya = $prog[0];
			$cknya = $prog[1];
			$dknya = $prog[2];
			$pnya = $prog[3];
			
			//Perbarui Penerimaan
			$simpan = "UPDATE t_penerimaan_barang SET jns_trans='$jns_transaksi', asal_usul='$asalusul', sumber_dana='$sumberdana',metode_pengadaan='$metodepengadaan',pencairan_dana='$pencairan_dana',bk='$bknya', ck='$cknya', dk='$dknya', p='$pnya', q='$kegiatan', pekerjaan='$pekerjaan', nomor_kontrak='$nomdok', tgl_kontrak='$tgl_dok', cara_bayar='$cara_bayar', id_penerimaan='$idpenerimaan', dokumen_sumber='$dokumen_sumber', tgl_dokumen_sumber='$tgl_dokumen_bast', no_dokumen_sumber='$nomor_dokumen_bast', refid_penyedia='$penyedian', refid_penerima='$penerima', tgl_buku='$tgl_buku', sttemp='0', tahun='$coThnAnggaran', biayaatribusi='$biayaatribusi', keterangan_penerimaan='$keterangan_penerimaan', refid_t_birm='$ID_BIRM', status_kdp='$status_kdp' WHERE Id='$idplh' ";$cek.=' || '.$simpan;//$err=$simpan;
			$qrysimpan = mysql_query($simpan);
		}
	  
						
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function CekJumlahBarangInput($Id){
		global $DataPengaturan;
		$hasil = '0';
		
		$qry = $DataPengaturan->QryHitungData("t_penerimaan_barang_det", "WHERE refid_terima='$Id' ANd status != '2' ");
		if($qry['hasil'] > 0)$hasil='1';
		
		return $hasil;
	}	
	
	function CekBarangInputValid($Id){
		global $DataPengaturan;
		$err='';
		$HitungBarang = $DataPengaturan->QryHitungData("t_penerimaan_barang_det", "WHERE refid_terima='$Id' AND status!='2' AND concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j) NOT IN (SELECT concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j) FROM ref_barang)");
		//$err=$HitungBarang['cek'];
		if($HitungBarang['hasil'] > 0)$err= "Data Barang Tidak Valid !";
		
		return $err;
	}
	
	function BatalSemua(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $c1= $_REQUEST['c1nya'];
	 $c= $_REQUEST['cnya'];
	 $d= $_REQUEST['dnya'];
	 $e= $_REQUEST['enya'];
	 $e1= $_REQUEST['e1nya'];
	 
	 	$qry = "SELECT * FROM t_penerimaan_barang WHERE Id='$idplh'";$cek.=$qry;
		$aqry = mysql_query($qry);
		$daqry = mysql_fetch_array($aqry);
		
		if($daqry['sttemp'] == '1'){
			//Penerimaan Rekening
			$hapusrek = "DELETE FROM t_penerimaan_rekening WHERE refid_terima='$idplh'"; $cek.="| ".$hapusrek;
			$qry_hapusrek = mysql_query($hapusrek);
								
			//Penerimaan Detail -----------------------------------------------------------------------------------
			$hapuspenerimaan_det = "DELETE FROM t_penerimaan_barang_det WHERE refid_terima='$idplh'"; $cek.="| ".$hapuspenerimaan_det;
			$qry_hapuspenerimaan_det = mysql_query($hapuspenerimaan_det);	
						
			//Penerimaan ------------------------------------------------------------------------------------------
			$hapus_penerimaan = "DELETE FROM t_penerimaan_barang WHERE Id='$idplh'"; $cek.="| ".$hapus_penerimaan;		
			$qry_hapus_penerimaan = mysql_query($hapus_penerimaan);
		}else{
			//Penerimaan Rekening
			$hapusrek = "DELETE FROM t_penerimaan_rekening WHERE refid_terima='$idplh' AND sttemp='1'"; $cek.="| ".$hapusrek;
			$qry_hapusrek = mysql_query($hapusrek);
			
			$updrek = "UPDATE t_penerimaan_rekening SET status='0' WHERE refid_terima='$idplh' AND sttemp='0'";$cek.="| ".$updrek;
			$qry_updrek = mysql_query($updrek);		
						
						
			//Penerimaan Detail -----------------------------------------------------------------------------------
			$hapuspenerimaan_det = "DELETE FROM t_penerimaan_barang_det WHERE refid_terima='$idplh' AND sttemp='1'"; $cek.="| ".$hapuspenerimaan_det;
			$qry_hapuspenerimaan_det = mysql_query($hapuspenerimaan_det);
			
			$updpenerimaan_det =  "UPDATE t_penerimaan_barang_det SET status='0' WHERE refid_terima='$idplh' AND sttemp='0'"; $cek.='| '.$updpenerimaan_det;
			
			$qry_updpenerimaan_det = mysql_query($updpenerimaan_det);
		}
			//$err='dgfd';
	  
						
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
		
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function set_selector_other($tipe){
	 global $Main,$HTTP_COOKIE_VARS, $DataPengaturan, $DataOption;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 	  
	  switch($tipe){	
		case 'formBaru'					: $fm = $this->setFormBaru();break;
		case 'formEdit'					: $fm = $this->setFormEdit();break;			
		case 'SimpanSemua'				: $fm = $this->SimpanSemua();break;
	    case 'BatalSemua'				: $fm = $this->BatalSemua();break;
	    case 'AfterPilBIRM'				: $fm = $this->AfterPilBIRM();break;
	    case 'Gen_DefaultTglBAST'		: $fm = $this->Gen_DefaultTglBAST();break;
	    case 'CekSesuai'				: $fm = $this->CekSesuai();break;
	    case 'SimpanDet'				: $fm = $this->SimpanDet();break;
	    case 'SetPenerima'				: $fm = $this->SetPenerima();break;
	    case 'rincianpenerimaanDET'		: $fm = $this->rincianpenerimaanDET();break;
	    case 'caraperolehan'			: $fm = $this->caraperolehan();break;
	    case 'KodePenerimaan' 			: $fm = $this->KodePenerimaan();break;
		case 'inputpenerimaanDET'		: $fm = $this->Option_inputpenerimaanDET();break;
	    case 'UbahRincianPenerimaan'	: $fm = $this->Option_UbahRincianPenerimaan();break;
	    case 'HapusRincianPenerimaan'	: $fm = $this->Option_HapusRincianPenerimaan();break;
	    case 'tabelRekening'			: $fm = $this->Option_tabelRekening();break;
	    case 'InsertRekening'			: $fm = $this->Option_InsertRekening();break;
	    case 'updKodeRek'				: $fm = $this->Option_updKodeRek();break;
	    case 'HapusRekening'			: $fm = $this->Option_HapusRekening();break;
	    case 'jadiinput'				: $fm = $this->Option_jadiinput();break;
	    case 'namarekening'				: $fm = $this->Option_namarekening();break;
	    case 'nomordokumen'				: $fm = $this->Option_nomordokumen();break;
	    case 'Tglnomordokumen'			: $fm = $this->Option_Tglnomordokumen();break;
	    case 'HapusNomorDokumen'		: $fm = $this->HapusNomorDokumen();break;
		case 'formBaruNomDok'			: $fm = $this->setformBaruNomDok();break;
		case 'formUbahNomDok' 			: $fm = $this->setformUbahNomDok(); break;
		case 'pilihPangkat'				: $fm = $this->Option_pilihPangkat();break;
		case 'simpanNomorDokumen'		: $fm = $this->simpanNomorDokumen();break;
		case 'formBaruPenyedia'			: $fm = $this->setformBaruPenyedia();break;
		case 'formBaruPenerima'			: $fm = $this->setformBaruPenerima();break;
		case 'formUbahPenerima'			: $fm = $this->setformUbahPenerima();break;
		case 'simpanPenyedia'			: $fm = $this->simpanPenyedia();break;
		case 'OptionPenyediaBarang'		: $fm = $this->GenOptPenyediaBarang();break;
		case 'formUbahPenyedia'			: $fm = $this->setformUbahPenyedia();break;
		case 'simpanPenerima' 			: $fm = $this->simpanPenerima();break;
		case 'HapusPenyedia'			: $fm = $this->HapusPenyedia();break;
		case 'ImportTemplateBarang'		: $fm = $this->ImportTemplateBarang();break;
		case 'HapusPenerima'			: $fm = $this->HapusPenerima();break;
		case 'GetSumberDana'			: $fm = $this->GetSumberDana();break;
		case 'FormLoadingImport'		: $fm = $this->FormLoadingImport();break;
	    case 'DataCopy'					: $fm = $this->DataCopy();break;
		case 'Get_TanggalDok_Sumber'	: $fm = $this->Get_TanggalDok_Sumber();break;
		case 'Load_DataCaraBayar'		: $fm = $this->Load_DataCaraBayar();break;
		case 'Set_SaveRekeningForDPA'	: $fm = $this->Set_SaveRekeningForDPA();break;
		case 'GetData_DPA_ProgKeg'		: $fm = $this->GetData_DPA_ProgKeg();break;
		case 'Get_jmlMaksBarang_DPA'	: $fm = $this->Get_jmlMaksBarang_DPA();break;
		case 'Get_jmlBarangRealisasi_DPA': $fm = $this->Get_jmlBarangRealisasi_DPA();break;
		//case 'tabelRekening_DataFormDPA_jmlMaksBarang' : $fm = $this->tabelRekening_DataFormDPA_jmlMaksBarang();break;
		case 'Get_Btn_CariTermin'		: $fm = $this->Get_Btn_CariTermin();break;
		case 'cariDokumenKontrak_After'	: $fm = $this->cariDokumenKontrak_After();break;
		default:{
			$other = $this->set_selector_other2($tipe);
			$cek = $other['cek'];
			$err = $other['err'];
			$content=$other['content'];
			$json=$other['json'];
		break;
		}
		 
	 }//end switch	 
	 if($json && isset($fm)){
		$cek = $fm['cek'];
		$err = $fm['err'];
		$content = $fm['content'];	
	 }
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }
   
   function setPage_Content(){
		global $DataPengaturan;
		$YN = cekPOST2("YN");
		
		$halman=intval(cekPOST2("halmannya",1));
		$halman = $halman > 3?1:$halman;	
		
		$dskrp = "pemasukanSKPD";
		$c1 = $YN == "1"?cekPOST2($dskrp."2fmURUSAN","0"):"";
		$c = $YN == "1"?cekPOST2($dskrp."2fmSKPD",'01'):"";
		$d = $YN == "1"?cekPOST2($dskrp."2fmUNIT",'01'):"";
		$e = $YN == "1"?cekPOST2($dskrp."2fmSUBUNIT",'01'):"";
		$e1 = $YN == "1"?cekPOST2($dskrp."2fmSEKSI",'001'):"";
		$jns_trans = $halman;
		
		$Id=$_REQUEST["pemasukan_cb"];
		
		$data = InputTypeHidden($dskrp."fmUrusan",$c1).
				InputTypeHidden($dskrp."fmSKPD",$c).
				InputTypeHidden($dskrp."fmUNIT",$d).
				InputTypeHidden($dskrp."fmSUBUNIT",$e).
				InputTypeHidden($dskrp."fmSEKSI",$e1).
				InputTypeHidden("pil_jns_trans",$jns_trans).
				InputTypeHidden("databaru",$YN).
				InputTypeHidden("idubah",$Id[0]);
		
		return $data.$this->genDaftarInitial();
		
	}
   
   function setPage_OtherScript(){
   		global $DataPengaturan;
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
							 /*$(window).bind('beforeunload', function () {
								return 'Apakah anda yakin akan meninggalkan halaman ini ?';
							});*/
						});
						
						
						
					</script>";
		return
			fn_TagScript('js/skpd.js').
			fn_TagScript('js/pencarian/DataPengaturan.js').
			fn_TagScript('js/master/ref_dokumen_kontrak/ref_dokumen_kontrak.js').
			fn_TagScript('js/master/ref_templatebarang/ref_templatebarang.js').
			fn_TagScript('js/master/ref_templatebarang/ref_templatebarang_det.js').
			fn_TagScript('js/pengadaanpenerimaan/'.strtolower($this->Prefix).'_det.js').
			fn_TagScript('js/pengadaanpenerimaan/'.strtolower($this->Prefix).'.js').
			fn_TagScript('js/pengadaanpenerimaan/pemasukan.js').
			fn_TagScript('js/pencarian/cariPenyedia.js').
			fn_TagScript('js/pencarian/cariprogram.js').
			fn_TagScript('js/pencarian/cariRekening.js').
			fn_TagScript('js/pencarian/cariBarang.js').
			fn_TagScript('js/pencarian/cariDPA.js').
			fn_TagScript('js/birm/birm.js').
			$DataPengaturan->Gen_Script_DatePicker().
			$scriptload;
	}
	
	//form ==================================
	function setFormBaru(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setformBaruNomDok(){
		global $HTTP_COOKIE_VARS;
		$coThnAnggaran = $_COOKIE['coThnAnggaran'];
		$cek = '';$err='';
		
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("d-m");
		$dt['thn'] = $coThnAnggaran;
		
		if($err == '')$fm = $this->setFormNomDok($dt);
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormNomDok($dt){	
	 global $SensusTmp, $DataOption, $DataPengaturan;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 550;
	 $this->form_height = 170;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU DOKUMEN KONTRAK';
		$nip	 = '';
	  }else{
		$this->form_caption = 'UBAH DOKUMEN KONTRAK';			
		$Id = $dt['Id'];			
	  }
	  $c1 = $_REQUEST['c1nya'];
	  $c = $_REQUEST['cnya'];
	  $d = $_REQUEST['dnya'];
			
	  $data_skpd = $DataPengaturan->GenViewSKPD6($c1,$c,$d,100);
		
	 //items ----------------------
	  $data_form = array(
			'nomdok2' => array( 
						'label'=>'NOMOR',
						'labelWidth'=>100, 
						'value'=>$dt["nomor_dok"], 
						'type'=>'text',
						'param'=>"style='width:380px;' placeholder='DOKUMEN KONTRAK'"
						 ),
			'tgl' => array( 
						'label'=>'TANGGAL',
						'labelWidth'=>100, 
						'value'=>
							InputTypeText("tgl_doku",$dt['tgl'], "class='datepicker2' style='width:40px;'"). 
							InputTypeText("tthn_doku",$dt['thn'], "readonly style='width:40px;'"),						
						 ),
						
			
			);
		$this->form_fields = array_merge($data_skpd,$data_form);
		
		$this->form_menubawah =
			InputTypeHidden("IdDokumenSum",$dt["Id"]).
			InputTypeHidden("c1",$c1).
			InputTypeHidden("c",$c).
			InputTypeHidden("d",$d).
			InputTypeButton("btn_sv","SIMPAN","onclick='".$this->Prefix.".SimpanNomorDokumen()' ")." ".
			InputTypeButton("btn_btl","BATAL","onclick='".$this->Prefix.".Close()' title='Simpan'");
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setformBaruPenyedia(){
		global $Ref, $Main, $HTTP_COOKIE_VARS;
		$dt=array();
		$cek = '';$err='';
		
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		 //set waktu sekarang
		
		$dt['tgl'] = date("d-m-Y");
		$dt['c1'] = $_REQUEST['c1nya'];
		$dt['c'] = $_REQUEST['cnya'];
		$dt['d'] = $_REQUEST['dnya'];
		$dt['idweh'] = $_REQUEST['pemasukan_ins_idplh'];
		
		if($err == '')$fm = $this->setFormPenyedia($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}
	
	function setformUbahPenyedia(){
		global $Ref, $Main, $HTTP_COOKIE_VARS, $DataPengaturan;
		$dt=array();
		$cek = '';$err='';
		
		$Id_penyedia = cekPOST2("penyedian");
		$this->form_idplh =$Id_penyedia;
		$this->form_fmST = 1;
		 //set waktu sekarang
		$qry = $DataPengaturan->QyrTmpl1Brs("ref_penyedia", "*", "WHERE Id='$Id_penyedia' ");
		$dt = $qry["hasil"];
		
		
		if($err == '')$fm = $this->setFormPenyedia($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormPenyedia($dt){	
	 global $SensusTmp, $Ref, $Main, $HTTP_COOKIE_VARS;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 470;
	 $this->form_height = 300;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU PENYEDIA BARANG';
		$nip	 = '';
	  }else{
		$this->form_caption = 'UBAH PENYEDIA BARANG';			
		$Id = $dt['Id'];			
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			'namapenyedia' => array( 
						'label'=>'NAMA PENYEDIA',
						'labelWidth'=>150, 
						'value'=>$dt["nama_penyedia"], 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='NAMA PENYEDIA'"
						 ),
			'alamatpenyedia' => array( 
						'label'=>'ALAMAT LENGKAP',
						'labelWidth'=>150, 
						'value'=>"<textarea name='alamatpenyedia' id='alamatpenyedia' style='width:270px;height:50px;' placeholder='ALAMAT LENGKAP'>".$dt["alamat"]."</textarea>",
						 ),
			'kotapenyedia' => array( 
						'label'=>'KOTA / KABUPATEN',
						'labelWidth'=>150, 
						'value'=>$dt["kota"], 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='KOTA / KABUPATEN'"
						 ),
			'namapimpinan' => array( 
						'label'=>'NAMA PIMPINAN',
						'labelWidth'=>150, 
						'value'=>$dt["nama_pimpinan"], 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='NAMA PIMPINAN'"
						 ),
			'nonpwp' => array( 
						'label'=>'NO NPWP',
						'labelWidth'=>150, 
						'value'=>$dt["no_npwp"], 
						'type'=>'text',
						'param'=>"style='width:270px;' maxlength='25' placeholder='NO NPWP'"
						 ),
			'norekeningbank' => array( 
						'label'=>'NO REKENING BANK',
						'labelWidth'=>150, 
						'value'=>$dt["norek_bank"], 
						'type'=>'text',
						'param'=>"style='width:270px;' maxlength='30' placeholder='NO REKENING BANK'"
						 ),
			'namabank' => array( 
						'label'=>'NAMA BANK',
						'labelWidth'=>150, 
						'value'=>$dt["nama_bank"], 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='NAMA BANK'"
						 ),
			'atasnamabank' => array( 
						'label'=>'ATAS NAMA BANK',
						'labelWidth'=>150, 
						'value'=>$dt["atasnama_bank"], 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='ATAS NAMA BANK'"
						 ),
			);
		//tombol
		$this->form_menubawah =
			/*"<input type='text' name='idweh' id='c1nya' value='".$dt['idweh']."' />".*/
			"<input type='hidden' name='c1nya' id='c1nya' value='".$dt['c1']."' />".
			"<input type='hidden' name='cnya' id='cnya' value='".$dt['c']."' />".
			"<input type='hidden' name='dnya' id='dnya' value='".$dt['d']."' />".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanPenyedia()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setformBaruPenerima(){
		global $Ref, $Main, $HTTP_COOKIE_VARS;
		$dt=array();
		$cek = '';$err='';
		
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		 //set waktu sekarang
		
		$dt['tgl'] = date("d-m-Y");
		$dt['c1'] = $_REQUEST['c1nya'];
		$dt['c'] = $_REQUEST['cnya'];
		$dt['d'] = $_REQUEST['dnya'];
		$dt['e'] = $_REQUEST['enya'];
		$dt['e1'] = $_REQUEST['e1nya'];
		$dt['idweh'] = $_REQUEST['pemasukan_ins_idplh'];
		
		if($err == '')$fm = $this->setFormPenerima($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormPenerima($dt){	
		global $SensusTmp, $DataPengaturan, $DataOption;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 530;
	 $this->form_height = 290;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
		$nip	 = '';
	  }else{
		$this->form_caption = 'Edit';			
		$readonly='readonly';
					
	  }
	   $arrOrder = array(
	  	          array('1','Kepala Dinas'),
			     	array('2','Pengurus Barang'),
					);
	$arr = array(
			//array('selectAll','Semua'),	
			array('selectKepala Dinas','Kepala Dinas'),	
			array('selectPengurus Barang','Pengurus Barang'),		
			);
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		$kode1=genNumber($dt['c'],2);
		$kode2=genNumber($dt['d'],2);
		$kode3=genNumber($dt['e'],2);
		$kode4=genNumber($dt['e1'],3);
		$nama=$dt['nama'];
		$nip=$dt['nip'];
		$jabatan=$dt['jabatan'];
		$Arrjbt = array(
						array('1.',"Kepala Dinas"),
						array('2.','Pengurus Barang'),


);		
		$c1 = $dt['c1'];
		$c = $dt['c'];
		$d = $dt['d'];
		$e = $dt['e'];
		$e1 = $dt['e1'];
		
		if($c1 !='0' && $DataOption['skpd']!='1'){
		$qry4 = "SELECT concat(c1,'. ', nm_skpd) as nama FROM ref_skpd WHERE c1='$c1' AND c='00' AND d='00' AND e='00' AND e1='000'";$cek.=$qry4;
		$aqry4 = mysql_query($qry4);
		$data4 = mysql_fetch_array($aqry4);
		$URUSAN = array( 
						'label'=>'URUSAN',
						'labelWidth'=>150, 
						'type'=>'text',
						'value'=>$data4['nama'],
						'param'=>" style='width:300px;' readonly",
						);
		$UntukC1 = "c1 = '$c1' AND ";
		}else{
			$URUSAN = '';
			$UntukC1='';
			if($DataPengaturan->FieldC1 == 1)$UntukC1="c1='0' AND ";
		}
		
		$qry = "SELECT * FROM ref_skpd WHERE $UntukC1 c='$c' AND d='00' AND e='00' AND e1='000'";$cek.=$qry;
		$aqry = mysql_query($qry);
		$data = mysql_fetch_array($aqry);
		
		$qry1 = "SELECT * FROM ref_skpd WHERE $UntukC1 c='$c' AND d='$d' AND e='00' AND e1='000'";$cek.=$qry1;
		$aqry1 = mysql_query($qry1);
		$data1 = mysql_fetch_array($aqry1);
		
		$qry2 = "SELECT * FROM ref_skpd WHERE $UntukC1 c='$c' AND d='$d' AND e='$e' AND e1='000'";$cek.=$qry2;
		$aqry2 = mysql_query($qry2);
		$data2 = mysql_fetch_array($aqry2);
		
		$qry3 = "SELECT * FROM ref_skpd WHERE $UntukC1 c='$c' AND d='$d' AND e='$e' AND e1='$e1'";$cek.=$qry3;
		$aqry3 = mysql_query($qry3);
		$data3 = mysql_fetch_array($aqry3);
		
		
		
		$queryPangkat = "select nama,concat(nama,' (',gol,'/',ruang,')')as nama from ref_pangkat order by gol,ruang" ;
       //items ----------------------
		 
		//$qry_jabatan = "SELECT Id, nama FROM ref_jabatan WHERE c1='$c1' AND c='$c' AND d='$d' ";
		 
		 $this->form_fields = array(
			$URUSAN,
			'bidang' => array( 
						'label'=>'BIDANG',
						'labelWidth'=>150, 
						'type'=>'text',
						'value'=>$data['c'].". ".$data['nm_skpd'],
						'param'=>" style='width:300px;' readonly",
						),
			'skpd' => array( 
						'label'=>'SKPD',
						'labelWidth'=>150, 
						'type'=>'text',
						'value'=>$data1['d'].". ".$data1['nm_skpd'],
						'param'=>" style='width:300px;' readonly",
						),
			'unit' => array( 
						'label'=>'UNIT',
						'labelWidth'=>150, 
						'type'=>'text',
						'value'=>$data2['e'].". ".$data2['nm_skpd'],
						'param'=>" style='width:300px;' readonly",
						),
			'subunit' => array( 
						'label'=>'SUB UNIT',
						'labelWidth'=>150, 
						'type'=>'text',
						'value'=>$data3['e1'].". ".$data3['nm_skpd'],
						'param'=>" style='width:300px;' readonly",
						),
			'namapegawai' => array( 
						'label'=>'NAMA PEGAWAI',
						'labelWidth'=>150, 
						'type'=>'text',
						'value'=>$dt["nama"],
						'param'=>" style='width:300px;'",
						),
			'nippegawai' => array( 
						'label'=>'NIP',
						'labelWidth'=>150, 
						'type'=>'text',
						'value'=>$dt["nip"],
						'param'=>"style='width:300px;'",
						),
			'pangkat' => array( 
						'label'=>'PANGKAT/ GOL/ RUANG',
						'labelWidth'=>150, 
						'value'=>cmbQuery('pangkatakhir',$dt["pangkat"],$queryPangkat,"onChange='".$this->Prefix.".pilihPangkat()' style='width:250px;'",'--PILIH--')."&nbsp;/&nbsp;<input type='text' name='golang_akhir' style='width:40px;' id='golang_akhir' size=1 value='".$dt["gol"]."/".$dt["ruang"]."' readonly>",
						),
			'jabatan' => array( 
						'label'=>'JABATAN',
						'labelWidth'=>150, 
						'type'=>'text',
						'value'=>$dt["jabatan"],
						'param'=>" style='width:300px;'",
						),
			'eselon' => array( 
						'label'=>'ESELON',
						'labelWidth'=>150, 
						'value'=>cmbArray('eselon_akhir',$dt["eselon"],$DataPengaturan->arrEselon,'--PILIH--','style=width:130px;'),
						),
														 
			);
		//tombol
		$this->form_menubawah =	
			"<input type='hidden' name='Id_skpd' id='Id_skpd'  value='".$Id."'>".
			"<input type='hidden' name='c1_penerima' id='c1_penerima'  value='".$c1."'>".
			"<input type='hidden' name='c_penerima' id='c_penerima'  value='".$c."'>".
			"<input type='hidden' name='d_penerima' id='d_penerima'  value='".$d."'>".
			"<input type='hidden' name='e_penerima' id='e_penerima'  value='".$e."'>".
			"<input type='hidden' name='e1_penerima' id='e1_penerima'  value='".$e1."'>".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanPenerima()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
   
  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  ref_satuan WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 300;
	 $this->form_height = 50;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru';
		$nip	 = '';
	  }else{
		$this->form_caption = 'Edit';			
		$Id = $dt['Id'];			
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			'nama' => array( 
						'label'=>'Satuan',
						'labelWidth'=>100, 
						'value'=>$dt['nama'], 
						'type'=>'text',
						'param'=>"style='width:200px;'"
						 ),			
			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setPage_HeaderOther(){
		
	return 
			/*"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=bagian\" title='Organisasi' >Organisasi</a> |
	<A href=\"pages.php?Pg=pegawai\" title='Pegawai' >Pegawai</a> |
	<A href=\"pages.php?Pg=barang\" title='Barang'>Barang</a> |
	<A href=\"pages.php?Pg=jenis\" title='Jenis'  >Jenis</a> |
	<A href=\"pages.php?Pg=satuan\" title='Satuan' style='color:blue' >Satuan</a> 
	&nbsp&nbsp&nbsp	
	</td></tr></table>"*/"";
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
	  	   <th class='th01' width='5' rowspan='2'>No.</th>
	  	   $Checkbox		
		   <th class='th01' rowspan='2'>TANGGAL BAST/ BUKU</th>
		   <th class='th01' rowspan='2'>NO BAST/ID PENERIMAAN</th>
		   <th class='th02' colspan='2'>DOKUMEN SUMBER</th>
		   <th class='th01' rowspan='2'>SUMBER DANA/ KODE AKUN / PENYEDIA BARANG</th>
		   <th class='th01' rowspan='2'>NAMA BARANG</th>
		   <th class='th01' rowspan='2'>MERK / TYPE/ SPESIFIKASI/ LOKASI</th>
		   <th class='th01' rowspan='2'>JUMLAH</th>
		   <th class='th01' rowspan='2'>HARGA SATUAN</th>
		   <th class='th01' rowspan='2'>JUMLAH HARGA</th>
		   <th class='th01' rowspan='2'>HARGA ATRIBUSI</th>
		   <th class='th01' rowspan='2'>HARGA PEROLEHAN</th>
		   <th class='th01' rowspan='2'>ADA ATRIBUSI</th>
		   <th class='th02' colspan='2'>DISTRIBUSI</th>
		   <th class='th01' rowspan='2'>VALIDASI</th>
		   <th class='th01' rowspan='2'>POSTING</th>
		   <th class='th01' rowspan='2'>KET.</th>
	   </tr>
	   <tr>
	   		<th class='th01'>DOKUMEN</th>
	   		<th class='th01'>TANGGAL DAN NOMOR</th>
	   		<th class='th01'>Y/T</th>
	   		<th class='th01'>SESUAI</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$isi['tgl_buku']."<br>".$isi['tgl_bast']);
	 $Koloms[] = array('align="left"',$isi['no_bast']."/".$isi['id_penerimaan']);
	 $Koloms[] = array('align="left"',$isi['id_dok_sumber']);
	 $Koloms[] = array('align="left"',$isi['nomor_dok']);
	 $Koloms[] = array('align="left"',$isi['sumber_dana']."<br>".$isi['ka'].".".$isi['kb'].".".$isi['kc'].".".$isi['kd'].".".$isi['ke'].".".$isi['kf']."<br>".$isi['id_penyedia']);
	 $Koloms[] = array('align="left"',"Nama Barang");
	 $Koloms[] = array('align="left"',"Keterangan Barang");
	 $Koloms[] = array('align="left"',"Jumlah");
	 $Koloms[] = array('align="left"',"Harga Satuan");
	 $Koloms[] = array('align="left"',"Jumlah Harga");
	 $Koloms[] = array('align="left"',"Harga Atribusi");
	 $Koloms[] = array('align="left"',"Harga Perolehan");
	 $Koloms[] = array('align="left"',"ada atribusi");
	 $Koloms[] = array('align="left"',"");
	 $Koloms[] = array('align="left"',"");
	 $Koloms[] = array('align="left"',"");
	 $Koloms[] = array('align="left"',"");
	 $Koloms[] = array('align="left"',"");
	 return $Koloms;
	}
	
	function Get_DataBIRM($Id){
		global $DataPengaturan;
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_birm", "*", "WHERE pid='$Id' ");
		$dt= $qry["hasil"];
		
		return $dt;
	}
	
	function Cek_OlahBIRMRek($Id){
		global $DataPengaturan;
		
		$status = FALSE;
		$hit = $DataPengaturan->QryHitungData("t_penerimaan_rekening", "WHERE refid_terima = '$Id' AND status != '2' AND jumlah='0' ");
		if($hit['hasil'] > 0)$status=TRUE;
		
		return $status;
	}
	
	function tabelRekening_cekDariDPA(){
		global $DataPengaturan, $DataPemasukan;
		$idplh = cekPOST2($this->Prefix."_idplh");
		$qry = $DataPengaturan->QryHitungData($DataPemasukan->TblName_det,"WHERE refid_terima='$idplh' AND status!='2' AND status_dpa!='0' ");
		$hasil = $qry["hasil"] > 0?TRUE:FALSE;
		
		return $hasil;
	}
	
	function tabelRekening_DataFormDPA_HartotDPA($dt, $idDPA=0){
		global $DataPengaturan, $DataPemasukan;
		
		$where_refid_DPA = $idDPA != 0?" AND refid_dpa='$idDPA' ":"";
		$qry = $DataPengaturan->QyrTmpl1Brs($DataPemasukan->TblName_rek_det,"IFNULL(SUM(harga_total),0) as hartot","WHERE refid_rek='".$dt["Id"]."' AND refid_terima='".$dt["refid_terima"]."' $where_refid_DPA");
		$dt = $qry["hasil"];
		
		return $dt["hartot"];		
	}
	
	function tabelRekening_DataFormDPA($dt){
		global $DataPemasukan, $DataPengaturan;
		$Koloms='';
		$kd_rek = $DataPengaturan->Gen_valRekening($dt,"_");
		$on = array(array("a.refid_dpa","b.id"));
		
		$data = array(
					array("a.refid_terima",$this->refid_terima),
					array("a.k",$dt['k']),
					array("a.l",$dt['l']),
					array("a.m",$dt['m']),
					array("a.n",$dt['n']),
					array("a.o",$dt['o']),
					array("a.status","2","!="),
					array("a.refid_dpa","0","!="),
				);
		$qry = QueryJoin(array($DataPemasukan->TblName_det." a ","view_data_dpa b"),"LEFT JOIN","b.id, b.nm_barang",$on,$data, "GROUP BY a.refid_dpa ");
		
		$fn_btn = $this->Prefix.'.RincianRekeningDPA("'.$kd_rek.'",'.$dt["Id"].')';
		$hrg_tot = $this->tabelRekening_DataFormDPA_HartotDPA($dt);
		$Koloms =Tbl_Td(FormatUang($hrg_tot),"right", $cls_GarisDaftar);
		$Koloms.=Tbl_Td(LabelSPan1("jumlanya_".$dt['Id'],FormatUang($dt["jumlah"])),"right", $cls_GarisDaftar);
		$Koloms.=Tbl_Td(InputTypeButton("brg_".$kd_rek,"RINCIAN","onclick='$fn_btn'"),"center", $cls_GarisDaftar);
		//$Koloms.=Tbl_Td($this->tabelRekening_DataFormDPA_JMLMAKSBarang("fm_PilBrgDPA_$kd_rek"));
		return $Koloms;
	}
	
	function tabelRekening_HeaderFromDPA(){
		$Koloms ="<th class='th01' width='120px;'>JUMLAH DPA (Rp)</th>";
		$Koloms.="<th class='th01' width='120px;'>PENERIMAAN (Rp)</th>";
		$Koloms.="<th class='th01' width='70px;'>RINCIAN".InputTypeHidden("GetRekeningDPA","").InputTypeHidden("IdRekeningDPA","")."</th>";
		//$Koloms.="<th class='th01' width='60px;'>BARANG MAKS</th>";
		return $Koloms;
	}
	
	function tabelRekening_JmlBarangDariDPA($dt){
		global $DataPengaturan, $DataPemasukan;
		$refid_terima = cekPOST2($this->Prefix."_idplh");
		$data =
			array(
				array("refid_terima",$refid_terima),
				array("k",$dt['k']),
				array("l",$dt['l']),
				array("m",$dt['m']),
				array("n",$dt['n']),
				array("o",$dt['o']),
				array("status","2","!="),
				array("refid_dpa","0","!="),
			);
		$qry = $DataPengaturan->QyrTmpl1Brs2($DataPemasukan->TblName_det,"IFNULL(SUM(jml),0) as jml",$data);
		$dt = $qry["hasil"];
		
		return $dt["jml"];
	}
	
	function tabelRekening(){
		global $DataPengaturan, $Main, $DataPemasukan;
		$cek = '';
		$err = '';
		$jml_harga=0;
		$datanya='';
		
		$refid_terima = cekPOST2($this->Prefix."_idplh");
		$this->refid_terima = $refid_terima;
		$kode_account_ap = cekPOST2("kode_account_ap");
		$dt_BIRM["nilaikontrak"] = 0;
		$dt_BIRM["bast_nilai"] = 0;
		
		//Data Penerimaan -----------------------------------------------------------------------------
		$qry_penerimaan = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang", "cara_bayar", "WHERE Id='$refid_terima' ");
		$dt_Penerimaan = $qry_penerimaan["hasil"];
		
		$cara_bayar = cekPOST2("cara_bayar","3");
		if($dt_Penerimaan["cara_bayar"] != "" || $dt_Penerimaan["cara_bayar"] != NULL)$cara_bayar = $dt_Penerimaan["cara_bayar"];
		//---------------------------------------------------------------------------------------------
		
		if($kode_account_ap == "0")$kode_account_ap = "";
		
		$olahBIRM = TRUE;
		if($Main->BIRMS == 1){
			if($kode_account_ap != "")$dt_BIRM = $this->Get_DataBIRM($kode_account_ap);
			if($dt_BIRM["nilaikontrak"] == $dt_BIRM["bast_nilai"])$olahBIRM = FALSE;
			if($olahBIRM == FALSE && $this->Cek_OlahBIRMRek($refid_terima) == TRUE)$olahBIRM=TRUE;
		}		
		//DARI DPA ------- UPDATE 20 Desember 2017
		//Cek Apakah Ada Dati Dari DPA	
		$field_pilih = " a.*,b.nm_rekening ";
		$groupby_rek = "";
		
		$cekDariDPA = $this->tabelRekening_cekDariDPA();
		if($cekDariDPA){
			$field_pilih = "a.Id, a.k, a.l, a.m, a.n, a.o, a.jumlah, a.refid_terima, a.status, a.uid, a.sttemp, a.tgl_create, a.tgl_update, a.tahun, a.refid_dpa, a.refid_terima_det, a.jumlah_dpa, b.nm_rekening  ";
			//$groupby_rek = " GROUP BY k,l,m,n,o ";
		}
		
		$qry = "SELECT $field_pilih FROM t_penerimaan_rekening a LEFT JOIN ref_rekening b ON a.k=b.k AND a.l=b.l AND a.m=b.m AND a.n=b.n AND a.o=b.o WHERE a.refid_terima = '$refid_terima' AND status != '2' $groupby_rek ORDER BY Id DESC";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		$cls_GarisDaftar = " class='GarisDaftar'";
		while($dt = mysql_fetch_array($aqry)){
			if($dt['status'] == '0'){
				$kodeRekening = $DataPengaturan->Gen_valRekening($dt);
				$kode = BtnText($kodeRekening,$this->Prefix.".jadiinput(`".$dt['Id']."`,`".$kodeRekening."`);");
					
				if($kode_account_ap != "" && $Main->BIRMS == 1 && $olahBIRM == FALSE)$kode=$kodeRekening;
				//DARI DPA ------- UPDATE 20 Desember 2017
			 	if($cekDariDPA)$kode=$kodeRekening;
				$idrek = '';
				
				$jumlahnya = FormatUang($dt['jumlah']);
				$btn =BtnImgDelete($this->Prefix.".HapusRekening(`".$dt['Id']."`)");
			}
			
			if($dt['status'] == '1'){
			// DENGAN INPUTAN TEXT
				$kdRek = $DataPengaturan->Gen_valRekening($dt);
				$kode = InputTypeText("koderek",$kdRek,"onkeyup='setTimeout(function myFunction() {pemasukan_ins.namarekening();},100);' style='width:80px;' maxlength='13' ").
						BtnImg_Cari("cariRekening.windowShow(".$dt['Id'].");");
										 
				$idrek = InputTypeHidden("idrek",$dt['Id']).
						 InputTypeHidden("statidrek",$dt['status']);
				
				$jumlahnya = InputTypeText("jumlahharga",floatval($dt['jumlah']),"style='text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = pemasukan_ins.formatCurrency(this.value);'").
							 LabelSPan1("formatjumlah",FormatUang($dt['jumlah']));
				
				$btn = BtnImgSave($this->Prefix.".updKodeRek()");
			}
			
			$Kolom_Jumlah = Tbl_Td(LabelSPan1("jumlanya_".$dt['Id'],$jumlahnya),"right", $cls_GarisDaftar);
			$Kolom_BTN = Tbl_Td(LabelSPan1("option_".$dt['Id'],$btn),"center", $cls_GarisDaftar);
			if($kode_account_ap != "" && $Main->BIRMS == 1 && $olahBIRM == FALSE)$Kolom_BTN='';
			//DARI DPA ------- UPDATE 20 Desember 2017
			if($cekDariDPA){
				$Kolom_Jumlah = "";
				$Kolom_BTN=$this->tabelRekening_DataFormDPA($dt);
				
			}
			
			$datanya.=$no%2==0?"<tr class='row1'>":"<tr class='row0'>";
			$datanya.=
					Tbl_Td($no,"right"," class='GarisDaftar'").
					Tbl_Td(LabelSPan1("koderekeningnya_".$dt['Id'],$kode." ".$idrek),"center", $cls_GarisDaftar).
					Tbl_Td(LabelSPan1("namaakun_".$dt['Id'],$dt['nm_rekening']),"left", $cls_GarisDaftar).
					$Kolom_Jumlah.
					$Kolom_BTN.
				"</tr>";
			$no = $no+1;
			$jml_harga = $jml_harga+floatval($dt['jumlah']);
		}
		
		// KodeBIRM 
		$TombolBaru = BtnImgAdd($this->Prefix.".BaruRekening()");		
		$Kolom_BTN_TombolBaru = "<th class='th01'>
									<span id='atasbutton'>
									$TombolBaru
									</span>
								</th>";
								
		if($kode_account_ap != "" && $Main->BIRMS == 1 && $olahBIRM == FALSE)$Kolom_BTN_TombolBaru='';				
		//DARI DPA ------- UPDATE 20 Desember 2017
		$KolomHeaderJumlah = "<th class='th01'>JUMLAH (Rp)</th>";
		if($cekDariDPA){
			$KolomHeaderJumlah="";
			$Kolom_BTN_TombolBaru=$this->tabelRekening_HeaderFromDPA();
		}
		$content['tabel'] =
			genFilterBar(
				array("
					<table class='koptable' style='min-width:780px;' border='1'>
						<tr>
							<th class='th01'>NO</th>
							<th class='th01' width='50px'>KODE REKENING</th>
							<th class='th01'>NAMA REKENING BELANJA</th>
							$KolomHeaderJumlah
							$Kolom_BTN_TombolBaru
						</tr>
						$datanya						
					</table>"
				)
			,'','','')
		;
		$jml_harga = $this->Get_JumlahHargaTotalBelanja($jml_harga);
		//UPDATE 08 Januari 2018 Modul Persediaan -----------------------------------------------------	
		/*$Get_BTN_TERMIN=$this->Get_Btn_CariTermin(TRUE);
		$BTN_Termin = $cara_bayar!="3"?$Get_BTN_TERMIN["content"]:"";
		$Fm_Pembayaran = 
			array(
				'label'=>'PEMBAYARAN',
				'label-width'=>'200px;',
				'value'=>
					InputTypeHidden("status_kdp",cekPOST2("status_kdp",$dt["status_kdp"])).
					cmbArray('cara_bayar',$cara_bayar,$DataPengaturan->arr_cara_bayar,"--- PILIH JENIS PEMBAYARAN ---", "style='width:150px;' onchange='".$this->Prefix.".reload_carabayar();'")." ".
					LabelSPan1("reload_carabayar",$BTN_Termin),
			);
		$Hidden_Fm_Pembayaran = "";*/
		if($DataPemasukan->STATUS_MODULPERSEDIAAN() && cekPOST2("jns_transaksi") == "3"){
			//$Fm_Pembayaran = array("kosong"=>"");
			$Hidden_Fm_Pembayaran = InputTypeHidden("cara_bayar","3");
		}
		//END UPDATE 08 Januari 2018 Modul Persediaan -----------------------------------------------------			
		$content['jumlah'] = 
				$DataPengaturan->isiform(
						array(
								array(
									'label'=>'TOTAL BELANJA',
									'label-width'=>'200px;',
									'name'=>'totalbelanja',
									'value'=>
										InputTypeText("totalbelanja",FormatUang($jml_harga)," style='width:150px;text-align:right' readonly").$Hidden_Fm_Pembayaran.
										LabelSPan1("jumlahsudahsesuai",
											InputTypeCheckbox("jumlah_sesuai","1","style=' margin-left:20px;' disabled ").
											LabelSPan1("jml_sesuai1","TOTAL HARGA SESUAI", "style='font-weight:bold;color:red;'")
										),								
								),
								//$Fm_Pembayaran,
						)
				);
		$content['atasbutton'] = "<a href='javascript:pemasukan_ins.tabelRekening()' /><img src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>";
		
		if(cekPOST("asalusul") != "1"){
			$content['tabel'] = "" ;
			$content['jumlah'] = "" ;
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_JumlahHargaTotalBelanja($jml_harga){
		global $Main, $DataPengaturan;
		$pidBIRM = cekPOST2("kode_account_ap");
		
		if($pidBIRM == "0")$pidBIRM = "";
		
		if($pidBIRM != "" && $Main->BIRMS == 1){
			$qry = $DataPengaturan->QyrTmpl1Brs("t_birm", "bast_nilai","WHERE pid='$pidBIRM' ");
			$dt = $qry["hasil"];
			
			$jml_harga = $dt["bast_nilai"];
		}
		
		return $jml_harga;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main, $HTTP_COOKIE_VARS, $DataOption, $DataPengaturan, $DataPemasukan;
	 $coThnAnggaran = $_COOKIE['coThnAnggaran']; 
	 
	$arr = array(
			//array('selectAll','Semua'),	
			array('selectSatuan','Satuan'),		
			);
		
	$cara_perolehan = array(
			//array('selectAll','Semua'),	
			array('1','PEMBELIAN'),	
			array('2','HIBAH'),			
			array('3','LAINNYA'),			
			);	
	$arr_dokumen_sumber = array(
			array('1', "BAST"),
			array('2', "BAKF"),
			array('3', "BA HIBAH"),
			array('4', "SURAT KEPUTUSAN"),
			);
			
	$arr_biayaatribusi = array(
			//array('selectAll','Semua'),	
			array('1','YA'),		
			array('0','TDK'),		
			);
			
	 //data order ------------------------------
	 $arrOrder = array(
			     	array('1','Satuan'),
					);
	 
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST2('fmORDER1');
	$fmDESC1 = cekPOST2('fmDESC1');
	$databaru = cekPOST2("databaru");
	
	if($databaru != ""){
		if($databaru == '1'){
			$c1input = cekPOST2('pemasukanSKPDfmUrusan');
			$cinput = cekPOST2('pemasukanSKPDfmSKPD');
			$dinput = cekPOST2('pemasukanSKPDfmUNIT');
			$einput = cekPOST2('pemasukanSKPDfmSUBUNIT');
			$e1input = cekPOST2('pemasukanSKPDfmSEKSI');
			
			$jns_trans = cekPOST2("pil_jns_trans",1);			
			if($c1input == '' && $DataOption['skpd'] == 1)$c1input=0;			
			$uid = $HTTP_COOKIE_VARS['coID'];			
			$data = 
				array(
					array("c1",$c1input),array("c",$cinput),array("d",$dinput),array("e",$einput),array("e1",$e1input),
					array("jns_trans",$jns_trans),array("uid",$uid),array("sttemp","1"),
				);
			$qry_ins = $DataPengaturan->QryInsData($this->TblName,$data);
		}else{
			$IDUBAH = $_REQUEST['idubah'];
			$data =array(array("Id",$IDUBAH));			
		}
		//DEKLARASI ---------------------------------------------------------------------------------------------		
		$qrytmpl = $DataPengaturan->QyrTmpl1Brs2($this->TblName,"*",$data," ORDER BY Id DESC ");
		$dataqrytmpl = $qrytmpl["hasil"];
		
		$jns_transaksi = $databaru == "1"?cekPOST2("pil_jns_trans"):$dataqrytmpl['jns_trans'];
		$asalusul = $databaru == "1"?"1":$dataqrytmpl['asal_usul'];
		$sumberdana = $databaru == "1"?"APBD":$dataqrytmpl['sumber_dana'];
		$cara_bayar = $databaru == "1"?"3":$dataqrytmpl['cara_bayar'];
		$dokumen_sumber = $databaru == "1"?"BAST":$dataqrytmpl['dokumen_sumber'];
		$tgl_dokumen_bast = $databaru == "1"?date('d-m-Y'):explode("-",$dataqrytmpl['tgl_dokumen_sumber']);
		$tgl_dokumen_bast = $tgl_dokumen_bast[2]."-".$tgl_dokumen_bast[1]."-".$tgl_dokumen_bast[0];
		$nomor_dokumen_bast = $databaru == "1"?"":$dataqrytmpl['no_dokumen_sumber'];
		$penyedia = $databaru == "1"?"":$dataqrytmpl['refid_penyedia'];
		$penerima = $databaru == "1"?"":$dataqrytmpl['refid_penerima'];
		$tgl_buku = $databaru == "1"?explode("-",date("Y-m-d")):explode("-",$dataqrytmpl['tgl_buku']);
		//$tgl_buku = $tgl_buku[2]."-".$tgl_buku[1]."-".$tgl_buku[0];
		$thn_buku = $databaru == "1"?$coThnAnggaran:$tgl_buku[0];
		$tgl_buku = $tgl_buku[2]."-".$tgl_buku[1];
		$biayaatribusi = $databaru == "1"?"0":$dataqrytmpl['biayaatribusi'];
		$keterangan_penerimaan = $databaru == "1"?"":$dataqrytmpl['keterangan_penerimaan'];
	}
		
	$idplhnya = $dataqrytmpl['Id'];
	$c1 = $dataqrytmpl['c1'];
	$c = $dataqrytmpl['c'];
	$d = $dataqrytmpl['d'];
	$e = $dataqrytmpl['e'];
	$e1 = $dataqrytmpl['e1'];
		
	$qrysumber_dn = "SELECT nama,nama FROM ref_sumber_dana";$cek.=$qrysumber_dn;	
	$qrypenyedia = "SELECT id,nama_penyedia FROM ref_penyedia WHERE c1= '$c1' AND c='$c' AND d='$d'";	
	$qrypenerima = "SELECT Id,nama FROM ref_tandatangan WHERE c1= '$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1'";$cek.=$qrypenerima;	
	$qry_dokumen_sumber = "SELECT nama_dokumen,nama_dokumen FROM ref_dokumensumber ";	
	$pil_jns_tran = "<select style='width:300px;' onchange='pemasukan_ins.inputpenerimaan()' id='jns_transaksi' name='jns_transaksi'>";
	
	switch($jns_transaksi){
		case "1":$pil_jns_tran.="<option selected value='1'>PENGADAAN BARANG</option></select>";break;
		case "2":$pil_jns_tran.="<option selected value='2'>PEMELIHARAAN BARANG</option></select>";break;
		case "3":$pil_jns_tran.="<option selected value='3'>PERSEDIAAN BARANG</option></select>";break;
	}
	
	//UPDATE 08 Januari 2018 Modul Persediaan -----------------------------------------------------	
	$Fm_Tangga_Buku = 
		array(
			'label'=>'TANGGAL BUKU',
			'value'=>
				InputTypeText("tgl_buku",$tgl_buku, "style='width:40px;' onchange='pemasukan_ins.CekSesuai()'  class='datepicker2'").
				InputTypeText("thn_buku",$thn_buku, "style='width:40px;' readonly")
		);
	$Fm_Tangga_Buku_hidden="";
	$Fm_Atribusi = array(
		'label'=>'DITAMBAH BIAYA ATRIBUSI ?',
		'value'=>cmbArray('biayaatribusi',$biayaatribusi,$arr_biayaatribusi,"PILIH", "style='width:99px;'"),
	);
	$Fm_Atribusi_hidden="";
	if($DataPemasukan->STATUS_MODULPERSEDIAAN() && $jns_transaksi == "3"){
		$Fm_Tangga_Buku = array("kosong"=>"");
		$Fm_Tangga_Buku_hidden = InputTypeHidden("tgl_buku",date("d-m")).InputTypeHidden("thn_buku",$thn_buku);
		$Fm_Atribusi = array("kosong"=>"");
		$Fm_Atribusi_hidden = InputTypeHidden("biayaatribusi", 0);
	}
	
		
	$TampilOpt =
			$vOrder=
				$DataPengaturan->GenViewHiddenSKPD($c1, $c, $d, $e, $e1).
				$DataPengaturan->GenViewSKPD($c1, $c, $d, $e, $e1).				
				genFilterBar(
				array(
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>'TRANSAKSI',
								'label-width'=>'200px;',
								'value'=>
								//cmbArray('jns_transaksi',$jns_transaksi,$DataPengaturan->jns_trans,"--- PILIH JENIS TRANSAKSI ---", "style='width:300px;' onchange='pemasukan_ins.inputpenerimaan()'"),
								$pil_jns_tran
							),
							array(
								'label'=>'CARA PEROLEHAN',
								'value'=>cmbArray('asalusul',$asalusul,$cara_perolehan,"--- PILIH CARA PEROLEHAN ---", "style='width:300px;' onchange='pemasukan_ins.caraperolehan()' "),
							),
							array(
								'label'=>'SUMBER DANA',
								'value'=>
									LabelSPan1("tukCaraPerolehan",
										cmbQuery('sumberdana',$sumberdana,$qrysumber_dn, "style='width:300px;' onchange='pemasukan_ins.CekSesuai()' ","--- PILIH SUMBER DANA ---")
									),
							),						
						)
					).
					LabelSPan1("pilCaraPerolehan","")				
				),'','','').
					InputTypeHidden("jns_dari_rek","1").
					LabelDiv1("id='tbl_rekening' style='width:100%;'","").
													
				genFilterBar(
				array(
					LabelSPan1("totalbelanja23","").
					$DataPengaturan->isiform(
						array(
								array(
									'label'=>'ID PENERIMAAN',
									'label-width'=>'200px;',
									'type'=>'text',
									'name'=>'idpenerimaan',
									'value'=>'',
									'parrams'=>"style='width:300px;text-align:left' readonly"
									,
								),
								array(
								'label'=>'DOKUMEN SUMBER',
								'value'=>
									cmbQuery('dokumen_sumber',$dokumen_sumber,$qry_dokumen_sumber," style='width:303px;' ",'--- PILIH DOKUMEN SUMBER ---').LabelSPan1("UntukDokumenSumber",""),						
								),
								array(
								'label'=>'TANGGAL DAN NOMOR',
								'value'=>
									LabelSPan1("UntukTanggalBAST",
										InputTypeText("tgl_dokumen_bast",$tgl_dokumen_bast, "class='datepicker' style='width:80px;' "))." ".
									InputTypeText("nomor_dokumen_bast",$nomor_dokumen_bast," placeholder='NOMOR' style='width:258px;' "),						
								),
								array(
									'label'=>'PENYEDIA BARANG',
									'value'=>
										LabelSPan1("det_dafpenyedia",
											LabelSPan1("dafpenyedia",
												cmbQuery('penyedian',$penyedia,$qrypenyedia," style='width:303px;' onchange='".$this->Prefix.".OptionPenyedia();'",'--- PILIH PENYEDIA BARANG ---')
											)." ".
											InputTypeButton("CariPenyedia","CARI", "onclick='pemasukan_ins.CariPenyedia()' ")
											." ".
											InputTypeButton("BaruPenyedia","BARU", "onclick='pemasukan_ins.BaruPenyedia()' ")
										).
										LabelSPan1("OptPenyedia",""),
								),
								array(
									'label'=>'PENERIMA BARANG',
									'value'=>
										$Fm_Tangga_Buku_hidden.$Fm_Atribusi_hidden.
										LabelSPan1("det_dafpenerima",
											LabelSPan1("dafpenerima",
												cmbQuery('penerima',$penerima,$qrypenerima," style='width:303px;' onchange='".$this->Prefix.".SetPenerima();'",'--- PILIH PENERIMA BARANG ---')
											)." ".
											InputTypeButton("BaruPenerima","BARU", "onclick='pemasukan_ins.BaruPenerima()' ")
										).
										LabelSPan1("OptPenerima",""),					
								),
								$Fm_Tangga_Buku,
								$Fm_Atribusi,
								array(
									'label'=>'KETERANGAN',
									'value'=>InputTypeTextArea("keterangan_penerimaan",$keterangan_penerimaan, "style='width:300px;height:50px;' placeholder='KETERANGAN'" ),
							),
								
						)
					)
				
				),'','','').
				
				genFilterBar(
					array(
						LabelSPan1("inputpenerimaanbarang", "INPUT PENERIMAAN BARANG", "style='color:black;font-size:14px;font-weight:bold;'"),				
				),'','','').
				LabelDiv1("id='databarangnya'","").
				genFilterBar(
					array(
					"<a href='javascript:pemasukan_ins.rincianpenerimaan();'><span id='rincianpenerimaanbarang' style='color:black;font-size:14px;font-weight:bold;' />RINCIAN PENERIMAAN BARANG</span></a>",				
				),'','','').
				LabelDiv1("id='rinciandatabarangnya'","").
				genFilterBar(
				array(
					InputTypeHidden("KodeTemplateBarang","").
					InputTypeHidden($this->Prefix."_idplh",$idplhnya).
					"<table>
						<tr>
							<td>".LabelSPan1("selesaisesuai",$DataPengaturan->buttonnya($this->Prefix.'.SimpanSemua()','save_f2.png','SIMPAN','SIMPAN','SIMPAN'))."</td>
							<td>".$DataPengaturan->buttonnya($this->Prefix.'.BatalSemua()','cancel_f2.png','BATAL','BATAL','BATAL')."</td>
						</tr>".
					"</table>",				
				),'','','')
								
			;
			
			
		return array('TampilOpt'=>$TampilOpt);
	}
	
	function caraperolehan(){
		global $Ref, $Main, $HTTP_COOKIE_VARS, $DataPengaturan, $DataPemasukan;
		$cek = '';$err='';
		$coThnAnggaran = $_COOKIE['coThnAnggaran']; 
				
		$kode_account_ap = cekPOST2("kode_account_ap");
		$databaru = cekPOST2("databaru");
		
		if($databaru == '1'){							
			//p,q
			$programnya = '';
			$prog = '';
			$kegiatan='';
			$qrykegitan = "SELECT q,nama_program_kegiatan FROM ref_programkegiatan WHERE p='00' AND q='00'";			
			$kegiatanDSBL ='disabled';			
			//PEKERJAAN
			$pekerjaan = '';			
			//DOKUMEN
			$tgl_dok='';
			$tgl_dokcopy='';
			$nomdok='';
			$cara_bayar="3";
						
		}else{
			$IDUBAH = cekPOST2('idubah');
			$qrytmpl = $DataPengaturan->QyrTmpl1Brs($DataPemasukan->TblName,"*","WHERE Id='$IDUBAH' ORDER BY Id DESC") ;
			$dataqrytmpl = $qrytmpl["hasil"];		
			
			//p,q
			$prog = $dataqrytmpl['bk'].".".$dataqrytmpl['ck'].".".$dataqrytmpl['dk'].".".$dataqrytmpl['p'];
			$p= $dataqrytmpl['p'];
			$bknya = $dataqrytmpl['bk'];
			$cknya = $dataqrytmpl['ck'];
			$dknya = $dataqrytmpl['dk'];

			$cariprogmnya = "SELECT *, concat (bk,'.', IF(LENGTH(ck)=1,concat('0',ck), ck),'.', IF(LENGTH(dk)=1,concat('0',dk), dk),'.', IF(LENGTH(p)=1,concat('0',p), p),'. ', nama) as v2_nama FROM ref_program WHERE bk='$bknya' AND ck='$cknya' AND dk='$dknya' AND p='$p' AND q='0' ";$cek.=$cariprogmnya;
			$qrycariprogmnya = mysql_fetch_array(mysql_query($cariprogmnya));
			
						
			$kegiatanDSBL ='';
			$qrykegitan = "SELECT q,concat (IF(LENGTH(q)=1,concat('0',q), q),'. ',nama) as nama FROM ref_program WHERE bk='$bknya' AND ck='$cknya' AND dk='$dknya' AND p='$p' AND q!='0'";
			$kegiatan=$dataqrytmpl['q'];
			
			//PEKERJAAN
			$pekerjaan = $dataqrytmpl['pekerjaan'];
			
			//DOKUMEN
			$tgl_dok=$dataqrytmpl['tgl_kontrak'];
			$tgl_dokcopy=explode("-", $tgl_dok);
			$tgl_dokcopy=$tgl_dokcopy[2]."-".$tgl_dokcopy[1]."-".$tgl_dokcopy[0];
			
			$cara_bayar = $dataqrytmpl["cara_bayar"];
			
			$nomdok=$dataqrytmpl['nomor_kontrak'];
			if($kode_account_ap == "")$kode_account_ap=$dataqrytmpl['refid_t_birm'];
			
		}
		//DEKLARASI --------------------------------------------------------------------------
		//TRANSAKSI
		$metodepengadaan = $databaru=="1"?"1":$dataqrytmpl['metode_pengadaan'];
		$pencairan_dana = $databaru=="1"?"1":$dataqrytmpl['pencairan_dana'];
		//p,q
		$programnya = $databaru=="1"?"":$qrycariprogmnya['v2_nama'];
		$prog = $databaru=="1"?"":$dataqrytmpl['bk'].".".$dataqrytmpl['ck'].".".$dataqrytmpl['dk'].".".$dataqrytmpl['p'];
		$pekerjaan = $databaru=="1"?"":$dataqrytmpl['pekerjaan'];
		
		$c1 = $_REQUEST['c1nya'];
		$c = $_REQUEST['cnya'];
		$d = $_REQUEST['dnya'];	
		
		$untukBIRM = "";
		$widthNomDok = "397";
		
		$btnCariProgram = "<input type='button' name='progcar' id='progcar' value='CARI' onclick='pemasukan_ins.CariProgram()' />";		
		if($Main->BIRMS == 1){
			$untukBIRM	= "<input type='button' name='BIRMS' id='BIRMS' value='BIRMS' onclick='pemasukan_ins.CariBIRM()' />";	
			$widthNomDok = "287";
			$tampil_BTNCari = TRUE;
			
			//Cek Apakah Kode refid_birm != ''			
			if($kode_account_ap != '0' && $kode_account_ap!='')$btnCariProgram = "";	
		}
		
		
		//CEK DPA -----------------------------------------------------------------------------
		$cekDPA=$this->tabelRekening_cekDariDPA();
		$status_dpa = $cekDPA?"1":"0";
		$btnCariDPA = $Main->DPA == 1?InputTypeButton("BtnCariDPA","DPA","onclick='".$this->Prefix.".cariDPA();'").InputTypeHidden("status_dpa",$status_dpa):"";		
		
	
		$qrynomdok = "SELECT nomor_dok,nomor_dok FROM ref_nomor_dokumen  WHERE c1='$c1' AND c='$c' AND d='$d' AND YEAR(tgl_dok)='$coThnAnggaran' ";
		
		//UPDATE 08 Januari 2018 Modul Persediaan -----------------------------------------------------	
		$Get_BTN_TERMIN=$this->Get_Btn_CariTermin(TRUE);
		$BTN_Termin = $cara_bayar!="3"?$Get_BTN_TERMIN["content"]:"";
		$Fm_Pembayaran = 
			array(
				'label'=>'PEMBAYARAN',
				'label-width'=>'200px;',
				'value'=>
					InputTypeHidden("status_kdp",cekPOST2("status_kdp",$dataqrytmpl["status_kdp"])).
					cmbArray('cara_bayar',$cara_bayar,$DataPengaturan->arr_cara_bayar,"--- PEMBAYARAN ---", "style='width:100px;' onchange='".$this->Prefix.".reload_carabayar();'")." ".
					LabelSPan1("reload_carabayar",$BTN_Termin),
			);
		$Hidden_Fm_Pembayaran = "";
		if($DataPemasukan->STATUS_MODULPERSEDIAAN() && cekPOST2("jns_transaksi") == "3"){
			$Fm_Pembayaran = array("kosong"=>"");
		}
		
			
		$content = $DataPengaturan->isiform(
						array(
							array(
								'label'=>'METODE PENGADAAN',
								'name'=>'metodepengadaan',
								'label-width'=>'200px;',
								'value'=>cmbArray('metodepengadaan',$metodepengadaan,$DataPengaturan->arr_metode_pengad,"--- PILIH METODE PENGADAAN DANA ---", "style='width:300px;' onchange='".$this->Prefix.".Pil_MetodePengadaan();' "),
							),
							array(
								'label'=>'MEKANISME PENCAIRAN DANA',
								'name'=>'pencairan_dana',
								'label-width'=>'200px;',
								'value'=>cmbArray('pencairan_dana',$pencairan_dana,$DataPengaturan->arr_pencairan_dana,"--- PILIH MEKANISME PENCAIRAN DANA ---", "style='width:300px;'"),
							),
							$Fm_Pembayaran,
							array(
								'label'=>'PROGRAM',
								'name'=>'program',
								'label-width'=>'200px;',
								'value'=>
									InputTypeText("program",$programnya," style='width:500px;' readonly")." ".
									$btnCariProgram." ".
									$btnCariDPA.
									InputTypeHidden("prog",$prog),
							),
							array(
								'label'=>'KEGIATAN',
								'name'=>'kegiatan',
								'label-width'=>'200px;',
								'value'=>
									LabelDiv1("id='dafkeg'",
										cmbQuery('kegiatan1',$kegiatan,$qrykegitan,"$kegiatanDSBL style='width:500px;' onchange='document.getElementById(`kegiatan`).value=this.value;' ",'--- PILIH KEGIATAN ---').
										InputTypeHidden("kegiatan",$kegiatan)
									),
							),
							array(
								'label'=>'PEKERJAAN',
								'name'=>'pekerjaan',
								'label-width'=>'140px',
								'type'=>'text',
								'value'=>$pekerjaan,
								'parrams'=>"style='width:500px;' placeholder='PEKERJAAN'",
							),
							array(
								'label'=>'DOKUMEN KONTRAK',
								'name'=>'dokumensumber',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='tgl_dokcopy' value='$tgl_dokcopy' id='tgl_dokcopy' readonly style='width:100px;' /> ".
								"<span id='nomber'>".cmbQuery('nomdok',$nomdok,$qrynomdok," style='width:".$widthNomDok."px;'  onchange='pemasukan_ins.TglNomorDokumen();' ","--- PILIH NOMOR DOKUMEN ---")."</span>".
								"<input type='hidden' name='tgl_dok' id='tgl_dok' value='$tgl_dok' /> ".
								"<span id='TombolBaruNomDok'><input type='button' name='BaruNomDok' id='BaruNoDok' value='BARU' onclick='pemasukan_ins.BaruNomDok()' /> 
								<span id='TombolPilih'></span>
								</span> ".
								$untukBIRM."<input type='hidden' id='kode_account_ap' value='$kode_account_ap' name='kode_account_ap' />"
										
								,
							),
			)
		);
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn
		$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];			
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
		//Cari 
		switch($fmPILCARI){			
			case 'selectSatuan': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;						 	
		}
		if(!empty($fmFiltTglBtw_tgl1)) $arrKondisi[]= " tgl_daftar>='$fmFiltTglBtw_tgl1'";
		if(!empty($fmFiltTglBtw_tgl2)) $arrKondisi[]= " tgl_daftar<='$fmFiltTglBtw_tgl2'";	
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST2('fmORDER1');
		$fmDESC1 = cekPOST2('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " nama $Asc1 " ;break;
		}	
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//$Order ="";
		//limit --------------------------------------
		/**$HalDefault=cekPOST2($this->Prefix.'_hal',1);	//Cat:Settingan Lama				
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		**/
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST2($this->Prefix.'_hal',1);					
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	
	function GetHargaMaksimalDPA($Id, $IdDet, $rek, $dpa){
		global $DataPengaturan, $DataPemasukan;
		$cek='';$err='';$content='';
		
		$where="WHERE refid_terima='$Id' AND refid_dpa='$dpa' ";
	
		$qry_rek = $DataPengaturan->QyrTmpl1Brs($DataPemasukan->TblName_rek_det, "*",$where."  AND refid_rek='$rek' ");
		$dt_rek = $qry_rek["hasil"];$cek.=$qry_rek["cek"];
		
		$content["harga_satuan"]=$dt_rek["harga_satuan"];	
		
		$qry_det = $DataPengaturan->QyrTmpl1Brs($DataPemasukan->TblName_det,"IFNULL(SUM(jml),0) as jml_tot",$where." AND status!='2' AND Id!='$IdDet'");
		$dt_det = $qry_det["hasil"];
			
		$content["jml"]=$dt_rek["jml"]-$dt_det["jml_tot"];		
		$content["kuantitas"]=$dt_rek["kuantitas"];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Gen_Button_RealisasiDPA(){
		return LabelSPan1("konten_BTNRealisasi",InputTypeButton("Btn_realisasiDPA","REALISASI", "onclick='".$this->Prefix.".Get_jmlBarangRealisasi_DPA();'"));
	}
	
	function inputpenerimaanDET_Data_DPA($idplh, $dt){
		global $Ref, $Main, $DataPengaturan, $DataPemasukan;
		$cek ='';$content=array();
		$jns_transaksi = cekPOST2("jns_transaksi");
		$kodeRekening = $DataPengaturan->Gen_valRekening($dt);
		
		$qry_rek = $DataPengaturan->QyrTmpl1Brs($DataPemasukan->TblName_rek,"Id","WHERE status='0' AND refid_terima='$idplh' AND status_dpa!='0' AND concat(k,'.',l,'.',m,'.',n,'.',o)='$kodeRekening' ");
		$dt_rek = $qry_rek["hasil"]; 
		
		if($Main->PENERIMAAN_DET_DPA_DEL == 1){
			$qry_dpa = "SELECT refid_dpa, nm_barang FROM $DataPemasukan->ViewName_rek_det WHERE refid_terima='$idplh' AND refid_rek='".$dt_rek["Id"]."' ";
			
			$konten_BarangDPA = cmbQuery("refid_dpa_brg",$dt["refid_dpa"],$qry_dpa,"style='width:553px;' onchange='".$this->Prefix.".Get_jmlMaksBarang_DPA();'","--- PILIH BARANG DPA ---");
		}else{
			$qry_dpa = $DataPengaturan->QyrTmpl1Brs($DataPemasukan->ViewName_rek_det,"refid_dpa, nm_barang"," WHERE refid_terima='$idplh' AND refid_dpa='".$dt["refid_dpa"]."' ");
			$dt_dpa = $qry_dpa["hasil"];
			
			$konten_BarangDPA = 
				InputTypeText("nm_refid_dpa_brg",$dt_dpa["nm_barang"],"style='width:553px;' readonly placeholder='NAMA BARANG DPA'").
				InputTypeHidden("refid_dpa_brg",$dt_dpa["refid_dpa"]);
		}		
		
		
		
		$content["data_FROM_DPA"] = 
			$DataPengaturan->isiform(
				array(
					array(
						'label'=>'REKENING',
						'label-width'=>'200px;',
						'value'=>
							InputTypeText("kode_rekBar",$kodeRekening," readonly  placeholder='KODE REKENING' style='width:80px;'")." ".
							InputTypeText("nama_rekBar",$dt["nm_rekening"]," readonly  placeholder='NAMA REKENING' style='width:470px;'").
							InputTypeHidden("IdRekBarang",$dt_rek["Id"]).
							InputTypeHidden("kd_rekPilBarang",$kodeRekening),
					),
					array(
						'label'=>'BARANG DARI DPA',
						'label-width'=>'200px;',
						'value'=>
							$konten_BarangDPA,
					)
				)
			);
		$refid_dpa_brg = cekPOST2("refid_dpa_brg");
		$getHargaMaksimalDPA = $this->GetHargaMaksimalDPA($idplh,$dt['Id'],$dt_rek["Id"],$dt['refid_dpa']);
		$cek.="  ||| ".$getHargaMaksimalDPA["cek"];
		$hrg_maks = $getHargaMaksimalDPA["content"];
		$content["hrgMaksDPA"] = $hrg_maks["harga_satuan"];
		$content["jmlMaksDPA"] = $hrg_maks["jml"];
		
		$content["Pil_FM_HargaDPA"] = 
			//" <img src='datepicker/lebihkecil.png' style='width:15px;' /> ".
			//LabelSPan1("psn","Harga DPA","style='font-size:10px;color:red;font-weight:bold;float:top;'").
			LabelSPan1("psn"," HARGA DPA : ","style='font-size:11px;color:red;font-weight:bold;float:top;'").
			InputTypeText("hrg_maksimal",FormatUang($content["hrgMaksDPA"]),"style='width:150;text-align:right;' readonly ")
			;
		$lbl_jml = $jns_transaksi == "2"?"&nbsp &nbsp &nbsp ":"";
		$content["Pil_FM_JMLDPA"] = 
			//" <img src='datepicker/lebihkecil.png' style='width:15px;' /> ".
			LabelSPan1("psn1"," JUMLAH DPA $lbl_jml : ","style='font-size:11px;color:red;font-weight:bold;float:top;'").
			InputTypeText("jml_maksimal",FormatAngka($content["jmlMaksDPA"]),"style='width:64;text-align:right;' readonly ")
			;
			
		$content["Pil_FM_REALISASI"] = $this->Gen_Button_RealisasiDPA();
				
		$content["Pil_FM_KUANTIASDPA"] = 
			//" <img src='datepicker/lebihkecil.png' style='width:15px;' /> ".
			LabelSPan1("psn1"," KUANTITAS DPA : ","style='font-size:11px;color:red;font-weight:bold;float:top;'").
			InputTypeText("kuantitas_maksimal",FormatAngka($hrg_maks["kuantitas"]),"style='width:64;text-align:right;' readonly ")
			;
		
		return	array ('cek'=>$cek, 'content'=>$content);
	}
	
	function inputpenerimaanDET($dt){
		global $Ref, $Main, $HTTP_COOKIE_VARS, $DataOption, $DataPengaturan, $DataPemasukan;
		$cek ='';$err='';$content='';
		$checDistri = '';
		$checAtri = '';
		$tbl_det = $DataPemasukan->TblName_det;
		if($dt['barangdistribusi'] == 1)$checDistri = 'checked';
		if($dt['biayaatribusi'] == 1)$checAtri = 'checked';
		
		$cara_bayar = cekPOST2("cara_bayar");
		$jns_transaksi = cekPOST2("jns_transaksi");
		
		$volume = $dt['jml'] * $dt['kuantitas'];
		
		//Pengaturan Satuan
		if($DataOption['kode_barang'] == '1'){
			$satuan_readonly = '';
		}else{
			$satuan_readonly = 'readonly';
		}
		// Pajak --------------------------------------------------
		if($dt["ppn"] != 0){
			$ppn_readonly = "";
			$ppn_chechked= "checked";
		}else{
			$ppn_readonly = "readonly";
			$ppn_chechked= "";
		}
		$title_jumlah="";
		
		$kode_account_ap = cekPOST2("kode_account_ap");
		if($kode_account_ap == "0")$kode_account_ap = "";
		if($kode_account_ap != "" && $Main->BIRMS ==1)$title_jumlah = "onfocus='pemasukan_ins.JumlahOnFocus();' onfocusout='pemasukan_ins.JumlahOFFFocus();'" ;
		
		$Btn_Template = InputTypeButton("templatebarang","TEMPLATE", "onclick='".$this->Prefix.".CariTemplateBarang();'");
		$Btn_Cari = InputTypeButton("caribarang","CARI", "onclick='".$this->Prefix.".CariBarang();'");
		$data_FROM_DPA = "";
		$Pil_FM_HargaDPA='';
		$Pil_FM_JumlahDPA="";
		$Pil_FM_KUANTIASDPA="";
		$Pil_FM_REALISASI="";
		//UPDATE 27 DESEMBER 2017 --- DPA ---------------------------------------------------------------------------	
		$idplh = cekPOST2($this->Prefix."_idplh");
		$status_dpa = cekPOST2("status_dpa");
		$cekDataDPA = $DataPemasukan->Cek_DataDPA($idplh,$status_dpa);
		if($cekDataDPA == 1){
			$Get_DataFormDPA = $this->inputpenerimaanDET_Data_DPA($idplh, $dt);
			$Get_DataFormDPA_Content = $Get_DataFormDPA["content"];
			$cek.=$Get_DataFormDPA["cek"];
			
			$Btn_Template = "";
			$data_FROM_DPA = $Get_DataFormDPA_Content["data_FROM_DPA"];
			$hrgMaksDPA = $Get_DataFormDPA_Content["hrgMaksDPA"];
			$Pil_FM_HargaDPA =$Get_DataFormDPA_Content["Pil_FM_HargaDPA"];
			$Pil_FM_JumlahDPA = $Get_DataFormDPA_Content["Pil_FM_JMLDPA"];
			$Pil_FM_KUANTIASDPA =$Get_DataFormDPA_Content["Pil_FM_KUANTIASDPA"];
			$Pil_FM_REALISASI =$Get_DataFormDPA_Content["Pil_FM_REALISASI"];
		}
		
		if($cara_bayar == "2" && $jns_transaksi == "1"){
			$Btn_Template = "";
			$qry_hit = $DataPengaturan->QryHitungData($tbl_det,"WHERE refid_terima='$idplh' AND status!='2' ");
			if($qry_hit["hasil"] > 0)$Btn_Cari="";
		}
		
		if($_REQUEST['jns_transaksi'] == 2){
			if($dt['ket_kuantitas']== '')$dt['ket_kuantitas']='KALI';
			$ARRAYNYA = $DataPengaturan->isiform(
						array(
							array(
								'label'=>'URAIAN PEMELIHARAAN',
								'label-width'=>'200px;',
								'value'=>
									InputTypeTextArea("keteranganbarang",$dt['ket_barang'], "style='width:505px;height:50px;' placeholder='URAIAN PEMELIHARAAN'"),
							),
							array(
								'label'=>'JUMLAH',
								'value'=>
									InputTypeText("jumlah_barang",floatval($dt['jml']), "style='width:75px;text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='pemasukan_ins.hitungjumlahHarga();'")." ".
									InputTypeText("satuan",$dt['satuan'], "style='width:75px;' readonly ")." ".			
									$Pil_FM_JumlahDPA." ".$Pil_FM_REALISASI,
							),
							array(
								'label'=>'KUANTITAS',
								'value'=>
									InputTypeText("kuantitas",floatval($dt['kuantitas']), "style='width:75px;text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='pemasukan_ins.hitungjumlahHarga();' onkeyup='pemasukan_ins.hitungjumlahHarga();'")." ".
									InputTypeText("ket_kuantitas",$dt['ket_kuantitas'], "style='width:75px;'")." ".
									$Pil_FM_KUANTIASDPA,
							),
							array(
								'label'=>'VOLUME',
								'value'=>InputTypeText("volume",$volume, "style='width:75px;text-align:right;' readonly"),
								
							),
						)
					);
					
			$biayatambahan = InputTypeCheckbox("barang_didistribusi","1","style='margin-left:20px;' $checDistri")."HARGA DI KAPITALISASI";
		}else{
			// UPDATE 08 Januari 2017 TUK PERSEDIAAN -------------------------------------------------------------------
			$margin_DSTR = $cekDataDPA == 1?"35px":"90px";
			$FM_BarangDistribusi = InputTypeCheckbox("barang_didistribusi","1", "style='margin-left:$margin_DSTR;' $checDistri")."BARANG AKAN DIDISTRIBUSIKAN.";
			if($DataPemasukan->STATUS_MODULPERSEDIAAN() && cekPOST2("jns_transaksi") == "3"){
				$Btn_Template = "";
				$FM_BarangDistribusi = "";
			}
			
			$ARRAYNYA = $DataPengaturan->isiform(
						array(
							array(
								'label'=>'MERK / TYPE/ SPESIFIKASI/ JUDUL/ LOKASI',
								'label-width'=>'200px;',
								'value'=>
									InputTypeTextArea("keteranganbarang", $dt['ket_barang'], "style='width:323px;height:50px;' placeholder='MERK / TYPE/ SPESIFIKASI/ JUDUL/ LOKASI'"),
							),
							array(
								'label'=>'JUMLAH',
								'value'=>
									InputTypeText("jumlah_barang",floatval($dt['jml']), "style='width:64px;text-align:right;' onkeypress='return isNumberKey(event)'  onkeyup='pemasukan_ins.hitungjumlahHarga();' $title_jumlah").
									LabelSPan1("MSG_Jumlah","").
									$Pil_FM_JumlahDPA." ".$Pil_FM_REALISASI.
									$FM_BarangDistribusi
									,
							),
							array(
								'label'=>'SATUAN',
								'value'=>InputTypeText("satuan",$dt['satuan'],"style='width:150px;' $satuan_readonly"),
							),
						)
					)
					;
			$biayatambahan = '';
		}
		
		
		$content = genFilterBar(
				array(
					$data_FROM_DPA.
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>'KODE BARANG',
								'label-width'=>'200px;',
								'value'=>
									InputTypeText("kodebarang",$dt['kodebarangnya'], "onkeyup='cariBarang.pilBar2(this.value)'placeholder='KODE BARANG' style='width:150px;'" )." ".
									InputTypeText("namabarang",$dt['nm_barang'], "style='width:350px;' readonly" )." ".
									$Btn_Cari." ".
									$Btn_Template,
							),
						)
					).
					$ARRAYNYA.
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>'HARGA SATUAN',
								'label-width'=>'200px;',
								'value'=>
									InputTypeText("harga_satuan",floatval($dt['harga_satuan']), "style='width:150px;text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`harga_satuannya`).innerHTML = pemasukan_ins.formatCurrency(this.value);pemasukan_ins.hitungjumlahHarga();'")." Rp ".
									LabelSPan1("harga_satuannya",FormatUang($dt['harga_satuan']))." ".$Pil_FM_HargaDPA,
							),
							array(
								'label'=>'PPN (%)',
								'value'=>
									InputTypeCheckbox("ppn_ok","1","onclick='".$this->Prefix.".Cek_PPN();' $ppn_chechked").
									InputTypeNumber("jml_ppn",$dt['ppn'],"min='0' ' id='jml_ppn' style='width:54;text-align:right;' onkeyup='pemasukan_ins.hitungjumlahHarga();' $ppn_readonly ")." %",								
							),
							array(
								'label'=>'JUMLAH HARGA',
								'value'=>
									InputTypeText("jumlah_harga", FormatUang($dt['harga_total']), "style='width:150;text-align:right;' readonly")." ".$biayatambahan,								
							),
							array(
								'label'=>'KETERANGAN',
								'value'=>
									InputTypeTextArea("keterangan",$dt['keterangan'], "style='width:323px;height:50px;' placeholder='KETERANGAN'"),
							),
							array(
								'label'=>'',
								'pemisah'=>'',
								'value'=>
									InputTypeButton("SIMPAN_DET","SIMPAN", "onclick='".$this->Prefix.".SimpanDet()' title='Simpan Rincian Penerimaan Barang'")." ".
									InputTypeButton("CLEAR_DET","CLEAR", "onclick='".$this->Prefix.".inputpenerimaan()' title='Bersihkan Form Rincian Penerimaan Barang'"),
							),
						)
					)
				
				),'','','').
				InputTypeHidden("refid_terimanya",$dt['Id']).
				InputTypeHidden("FMST_penerimaan_det",$dt['FMST_penerimaan_det'])
				
				/*genFilterBar(
					array(
					InputTypeHidden("refid_terimanya",$dt['Id']).
					InputTypeHidden("FMST_penerimaan_det",$dt['FMST_penerimaan_det']).
					"
					<table>
						<tr>
							<td>".$DataPengaturan->buttonnya($this->Prefix.'.SimpanDet()','save_f2.png','BATAL','BATAL','SIMPAN')."</td>
							<td>".$DataPengaturan->buttonnya($this->Prefix.'.inputpenerimaan()','clear-icon-8.png','BATAL','BATAL','BATAL')."</td>
						</tr>".
					"</table>
					"				
				),'','','')*/;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function rincianpenerimaanDET(){
		global $DataPengaturan;
		$cek = '';$err='';
		
		$idplh = addslashes($_REQUEST['pemasukan_ins_idplh']);
		
		$qry = "SELECT * FROM ".$DataPengaturan->VPenerima_det()." WHERE refid_terima='$idplh' AND status != '2' ";$cek.=$qry;
		$aqry = mysql_query($qry);
		
		//$datanya = ";
		$no = 1;
		$totalharga = 0;
		
		$label_dis = "DISTR";
			
		if($_REQUEST['jns_transaksi'] == '2'){
			$label_dis = "KPTLS";
		}
			
		while($dt = mysql_fetch_array($aqry)){
			
			if($dt['barangdistribusi'] == '1'){
				$distri = "YA";
			}else{
				$distri = "TDK";
			}
			/*if($dt['biayaatribusi'] == '1'){
				$atri = "YA";
			}else{
				$atri = "TDK";
			}*/
			
			$jumlah_barang = $dt['jml'];
			$label_dis = "DISTR";
			
			if($_REQUEST['jns_transaksi'] == '2'){
				$jumlah_barang = $dt['jml'] * $dt['kuantitas'];
				//$label_dis = "KPTLS";
			}
			
			$namabarang = $dt['nm_barang'];
			if($namabarang == "" || $namabarang == NULL)$namabarang="Tidak Valid";
			
			$jumlahbarangnya = number_format($jumlah_barang,0,".",",");
			if(cekPOST2("kode_account_ap") != "")$jumlahbarangnya = number_format($jumlah_barang,2,".",",");
			
			$datanya .= "
				<tr class='row0'>
					<td class='GarisDaftar' align='right'>$no</td>
					<td class='GarisDaftar'><a href='javascript:pemasukan_ins.UbahRincianPenerimaan(`".$dt['Id']."`)' >".$namabarang."</a></td>
					<td class='GarisDaftar'>".$dt['ket_barang']."</td>
					<td class='GarisDaftar' align='right'>".$jumlahbarangnya."</td>
					<td class='GarisDaftar'>".$dt['satuan']."</td>
					<td class='GarisDaftar' align='right'>".number_format($dt['harga_satuan'],2,",",".")."</td>
					<td class='GarisDaftar' align='right'>".$dt['ppn']."</td>
					<td class='GarisDaftar' align='right'>".number_format($dt['harga_total'],2,",",".")."</td>
					<td class='GarisDaftar' align='center'>".$distri."</td>
					<!--<td class='GarisDaftar' align='center'>".$atri."</td>-->
					<td class='GarisDaftar'>".$dt['keterangan']."</td>
					<td class='GarisDaftar' align='center'>
						<a href='javascript:pemasukan_ins.HapusRincianPenerimaan(`".$dt['Id']."`)' />
							<img src='datepicker/remove2.png' style='width:20px;height:20px;' title='Hapus Data' />
						</a>
					</td>
					<td class='GarisDaftar' align='center'>
						<a href='javascript:pemasukan_ins.GandakanPenerimaan(`".$dt['Id']."`)' />
							<img src='images/administrator/images/move_f2.png' style='width:20px;height:20px;' title='Gandakan Data'  />
						</a>
					</td>
				</tr>
			";
			$no = $no+1;
			$totalharga = $totalharga + $dt['harga_total'];
		} 
		
		$content = 
					"
					<div class='FilterBar' style='padding:10px;'>
					<table class='koptable' style='width:100%;' border='1'>
						<tr>
							<th class='th01'>NO</th>
							<th class='th01'>NAMA BARANG</th>
							<th class='th01'>MERK / TYPE/ SPESIFIKASI/ JUDUL/ LOKASI</th>
							<th class='th01'>VOLUME</th>
							<th class='th01'>SATUAN</th>
							<th class='th01'>HARGA SATUAN</th>
							<th class='th01'>PPN (%)</th>
							<th class='th01'>JUMLAH HARGA</th>
							<th class='th01' width='50px'>".$label_dis."</th>
							<!--<th class='th01' width='50px'>ATRIB</th>-->
							<th class='th01'>KET.</th>
							<th class='th01' colspan='2'>AKSI</th>
						</tr>
						$datanya
						<tr>
							<td class='GarisDaftar' colspan='7' align='center'><b>TOTAL</b></td>
							<td class='GarisDaftar' align='right'><b>".number_format($totalharga,2,",",".")."</b></td>
							<td class='GarisDaftar' colspan='5'></td>
						</tr>
					</table>
					</div>"
				
				;
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function SimpanDet_ValidasiDPA(){
		global $DataPengaturan, $DataPemasukan;
		$err="";
		
		$status_dpa = cekPOST2("status_dpa");
		$IdDet = cekPOST2("refid_terimanya");
		$jns_transaksi = cekPOST2("jns_transaksi");
		$Id = cekPOST2($this->Prefix."_idplh");
		$kd_rekPilBarang = cekPOST2("kd_rekPilBarang");
		$refid_dpa_brg = cekPOST2("refid_dpa_brg");
		
		$jumlah_barang = cekPOST2Float("jumlah_barang");
		$harga_satuan = cekPOST2Float("harga_satuan");
		$kuantitas = cekPOST2Float("kuantitas");
		
		$kdrek = explode(".",$kd_rekPilBarang);
		$qry_rek = $DataPengaturan->Get_valRekening2($kdrek[0],$kdrek[1],$kdrek[2],$kdrek[3],$kdrek[4]);
		
		if($err == "" && $qry_rek["kode"] == "")$err = "Kode Rekening Tidak Valid !";
		if($err == "" && $DataPemasukan->Cek_DataDPA($Id,$status_dpa,$kd_rekPilBarang)==0)$err = "Kode Rekening Tidak Valid !";
		if($err == "" && $refid_dpa_brg=="")$err = "Barang Dari DPA Tidak Valid !";
		if($err == "" && $jumlah_barang<1)$err = "Jumlah Barang Tidak Boleh 0 !";
		if($err == ""){
			$qry_rek = $DataPengaturan->QyrTmpl1Brs($DataPemasukan->TblName_rek,"Id","WHERE status='0' AND refid_terima='$Id' AND status_dpa!='0' AND concat(k,'.',l,'.',m,'.',n,'.',o)='$kd_rekPilBarang' ");
			$dt_rek = $qry_rek["hasil"]; 
		
			//Cek Harga Maksimal DPA
			$GetHargaMaksimalDPA = $this->GetHargaMaksimalDPA($Id,$IdDet,$dt_rek["Id"],$refid_dpa_brg);
			$hrg_DPA = $GetHargaMaksimalDPA["content"];
			$jml_maksimal = $hrg_DPA["jml"];
			$harga_satuan_maksimal = $hrg_DPA["harga_satuan"];
			$kuantitas_maksimal = $hrg_DPA["kuantitas"];
			//Jika Pengadaan ------------------------------------------------------------------------
			$dt = $DataPemasukan->Gen_DataPenerimaan($Id);
			
			if($err == "" && $jumlah_barang > $jml_maksimal)$err="Jumlah Barang Tidak Boleh Melebihi Jumlah DPA ! ";
			if($jns_transaksi == "2" && $err == "" && $kuantitas > $kuantitas_maksimal)$err="Kuantitas Barang Tidak Boleh Melebihi Kuantitas DPA !";
			if($err == "" && $harga_satuan > $harga_satuan_maksimal)$err="Harga Satuan Tidak Boleh Melebihi Harga DPA !";	
		}			
		
		return $err;
	}
	
	function SimpanDet_After_DPA($Id, $rek){
		global $DataPengaturan, $DataPemasukan;
		$cek='';
		$where = "WHERE refid_terima='$Id' AND concat(k,'.',l,'.',m,'.',n,'.',o)='$rek' AND status_dpa='1' "; 		
		$qry = $DataPengaturan->QyrTmpl1Brs($DataPemasukan->TblName_det, "IFNULL(SUM(harga_total),0) as hrg_total", $where." AND status!='2' "); $cek.=$qry["cek"];
		$dt = $qry["hasil"];
		
		$data_udp = array(array("jumlah",$dt["hrg_total"]));
		$qry_upd = $DataPengaturan->QryUpdData($DataPemasukan->TblName_rek, $data_udp, $where." AND status='0' ");
		$cek.=$qry_upd["cek"];
		
		return $cek;		
	}
		
	function SimpanDet(){
		global $Ref, $Main, $HTTP_COOKIE_VARS,$DataOption, $DataPengaturan, $DataPemasukan;
		
		$cek = '';$err='';$content='';
		
		$tbl_det = $DataPemasukan->TblName_det;
		
	 	$uid = $HTTP_COOKIE_VARS['coID'];
	 	$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		
		$idplh = cekPOST2('pemasukan_ins_idplh');
		$caraperolehan = cekPOST2('asalusul');
		$c1nya = cekPOST2('c1nya');
		$cnya = cekPOST2('cnya');
		$dnya = cekPOST2('dnya');
		$enya = cekPOST2('enya');
		$e1nya = cekPOST2('e1nya');
		
		if($DataOption['skpd'] != 2)$c1nya="0";
		$kodebarang = cekPOST2('kodebarang');
		$keteranganbarang = cekPOST2('keteranganbarang');
		$jumlah_barang = cekPOST2('jumlah_barang');
		$satuan = cekPOST2('satuan');
		$harga_satuan = cekPOST2('harga_satuan');
		$keterangan = cekPOST2('keterangan');
		$jns_transaksi = cekPOST2('jns_transaksi');
		$kuantitas = cekPOST2('kuantitas');
		$ket_kuantitas = cekPOST2('ket_kuantitas');
		$barang_didistribusi = cekPOST2("barang_didistribusi","0");
		$cara_bayar = cekPOST2("cara_bayar");
		$idterima = cekPOST2('refid_terimanya');
		
		//PPN ----------------------------PAJAK ------------------------------------------------------------
		$ppn_ok = cekPOST2("ppn_ok");
		$jml_ppn = cekPOST2("jml_ppn");		
		
		$pid_BIRM = cekPOST2("kode_account_ap");
						
		//PENGATURAN KODE BARANG		
		$kodebrg = explode(".",$kodebarang);
		if($DataOption['kode_barang'] == '1'){
			$where_kode = "concat(f,'.',g,'.',h,'.',i,'.',j";
			
			$f1 = "0";
			$f2 = "0";
			$f = $kodebrg[0];
			$g = $kodebrg[1];
			$h = $kodebrg[2];
			$i = $kodebrg[3];
			$j = $kodebrg[4];
			$j1 = $jns_transaksi=="3" && isset($kodebrg[5])?$kodebrg[5]:"0000";
			$inpt_kd_brg = "";			
			$val_inpt_kd_brg = "";			
		}else{
			$where_kode = "concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j";
			$f1 = $kodebrg[0];
			$f2 = $kodebrg[1];
			$f = $kodebrg[2];
			$g = $kodebrg[3];
			$h = $kodebrg[4];
			$i = $kodebrg[5];
			$j = $kodebrg[6];	
			$j1 = $jns_transaksi=="3" && isset($kodebrg[7])?$kodebrg[7]:"0000";
			$inpt_kd_brg = "f1,f2,";
			$val_inpt_kd_brg="'$f1','$f2',";
		}
		
		$where_kode.=$jns_transaksi=="3"?",'.',j1)":")";		
		
		//UPDATE 27 DESEMBER 2017 DPA ----------------------------------------------------------------------
		$status_dpa = cekPOST2("status_dpa");
		$cekDataDPA = $DataPemasukan->Cek_DataDPA($idplh, $status_dpa);
		if($cekDataDPA == 1)$err = $this->SimpanDet_ValidasiDPA();
		if($err == ""){			
			$kd_rekPilBarang = cekPOST2("kd_rekPilBarang");
			$refid_dpa_brg = cekPOST2("refid_dpa_brg");
			$kdrek = explode(".",$kd_rekPilBarang);
			$program = cekPOST2("prog");
			$prog = explode(".",$program);
			$q = cekPOST2("kegiatan");
		}		
		
		if($cara_bayar == "2" && $err==""){			
			$hitData = $DataPengaturan->QryHitungData($tbl_det, "WHERE refid_terima='$idplh' AND Id!='$idterima' AND status != '2' ");
			if($hitData["hasil"] > 0)$err = "Pembayaran Termin Hanya Untuk 1 Barang !";
			if($err == "" && intval($idterima) > 0){
				$qry_cekKdBrg = $DataPengaturan->QyrTmpl1Brs($tbl_det, "concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j) as kdbrg","WHERE refid_terima='$idplh' AND Id='$idterima' ");
				$dt_cekKdBrg = $qry_cekKdBrg["hasil"];
				
				$kdBrg = $DataOption['kode_barang'] == '1'?"0.0.".$kodebarang:$kodebarang;
				if($kdBrg != $dt_cekKdBrg["kdbrg"])$err = "Kode Barang Harus Sama Dengan Kode Barang Sebelumnya !";
				//if($err == "") $err = $kdBrg." | ".$dt_cekKdBrg["kdbrg"]."|".$qry_cekKdBrg["cek"];
			}		
		}
		//--------------------------------------------------------------------------------------------------
		
		if($caraperolehan == '1' && $err == ""){
			$qry_cekbarang = "SELECT * FROM ref_barang WHERE $where_kode = '$kodebarang' AND j!='000' ";$cek.=$qry_cekbarang;
			$aqry = mysql_query($qry_cekbarang);
			if(mysql_num_rows($aqry) < 1)$err = "Kode Barang Tidak Valid !";
		}
		if($err =='' && $jns_transaksi == '')$err = "Jenis Transaksi Belum Dipilih !";
		
		//CEK JUMLAH BARANG ------------------------------------------------------------------------------
		if($err == ''){
			if($pid_BIRM != ""){
				if($jumlah_barang < 0)$err = "Jumlah Barang Tidak Boleh 0 !";
			}else{
				if($jumlah_barang < 1)$err = "Jumlah Barang Tidak Boleh 0 !";
			}			
		}		
		
		if($err =='' && $satuan == '' && $jns_transaksi == "1")$err = "Satuan Belum Diisi !";
		if($err == '' && $harga_satuan < 1)$err = "Harga Satuan Belum Diisi !";
		if($err == ''){
			if($jns_transaksi == '2')if($err == '' && $kuantitas < 1)$err = "Jumlah Kuantitas Tidak Boleh 0 !";
		}
		
		if($err == ''){
			if($_REQUEST['FMST_penerimaan_det'] == '1'){
				if($_REQUEST['refid_terimanya'] != ''){					
					$upd = "UPDATE t_penerimaan_barang_det SET status='2' WHERE Id='$idterima' ";$cek.=$upd; 
					$qryupd = mysql_query($upd);
				}
			}
			
			
			if($jns_transaksi == '2'){
				$hargatotal = ($jumlah_barang*$kuantitas)*$harga_satuan;
				$kuan = $kuantitas;
				$ket_kuan = $ket_kuantitas;
			}else{
				$hargatotal = $jumlah_barang*$harga_satuan;
				$kuan = 1;
				$ket_kuan = '';
			}
			
			$pajak = 0;
			$ppn = 0;
			if($ppn_ok != ''){
				$pajak = $hargatotal * ($jml_ppn/100);
				$hargatotal = $hargatotal + $pajak;
				$ppn = $jml_ppn;
			}
			
			$data_ins = 
				array(
					array("c1",$c1nya),array("c",$cnya),array("d",$dnya),array("e",$enya),array("e1",$e1nya),
					array("f1",$f1),array("f2",$f2),array("f",$f),array("g",$g),
					array("h",$h),array("i",$i),array("j",$j),array("j1",$j1),
					array("ket_barang",$keteranganbarang),
					array("jml",$jumlah_barang),
					array("satuan",$satuan),
					array("harga_satuan",$harga_satuan),
					array("harga_total",$hargatotal),
					array("keterangan",$keterangan),
					array("barangdistribusi",$barang_didistribusi),
					array("status","1"),
					array("refid_terima",$idplh),
					array("sttemp","1"),
					array("uid",$uid),
					array("tahun",$coThnAnggaran),
					array("kuantitas",$kuan),
					array("ket_kuantitas",$ket_kuan),
					array("pajak",$pajak),
					array("ppn",$ppn),
				);	
				
			if($cekDataDPA == 1){
				array_push($data_ins,
					array("status_dpa","1"),
					array("status2_dpa","1"),
					array("refid_dpa",$refid_dpa_brg)
				);
			}		
			$qry_simpan = $DataPengaturan->QryInsData($tbl_det, $data_ins);$cek.=$qry_simpan["cek"];
				
			if($cekDataDPA == 1)$cek.=$this->SimpanDet_After_DPA($idplh,$kd_rekPilBarang);
									
			//$simpan = "INSERT INTO t_penerimaan_barang_det (c1,c,d,e,e1,$inpt_kd_brg f,g,h,i,j,ket_barang,jml,satuan,harga_satuan, harga_total,keterangan,barangdistribusi,status,refid_terima,sttemp,uid,tahun,kuantitas,ket_kuantitas, pajak, ppn) values ('$c1nya', '$cnya', '$dnya', '$enya', '$e1nya', $val_inpt_kd_brg '$f', '$g', '$h', '$i', '$j', '$keteranganbarang', '$jumlah_barang', '$satuan', '$harga_satuan', '$hargatotal', '$keterangan', '$barang_didistribusi', '1', '$idplh', '1','$uid','$coThnAnggaran','$kuan', '$ket_kuan', '$pajak', '$ppn')";$cek .= $simpan ; 
			//$qrysimpan = mysql_query($simpan);
		}
		
		
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function cekSesuai(){
		$cek='';$err='';$content='';
		
			$idplh = addslashes($_REQUEST['pemasukan_ins_idplh']);
			
			$hitungrincian = "SELECT SUM(harga_total) as harga FROM t_penerimaan_barang_det WHERE refid_terima='$idplh' AND status !='2' ";
			$qryhitungrincian = mysql_query($hitungrincian);
			$jmlhtng_rincian = mysql_fetch_array($qryhitungrincian);
			
			$hitungrekening = "SELECT SUM(jumlah) as harga FROM t_penerimaan_rekening WHERE refid_terima='$idplh' AND status !='2' ";
			$qryhitungrekening = mysql_query($hitungrekening);
			$jmlhtngrekening = mysql_fetch_array($qryhitungrekening);
			
			$jmlhtngrekening['harga'] = $this->Get_JumlahHargaTotalBelanja($jmlhtngrekening['harga']);
			
			if($jmlhtng_rincian['harga'] != 0 && $jmlhtngrekening['harga'] != 0 && $jmlhtng_rincian['harga'] == $jmlhtngrekening['harga'] ){
				$idpenerimaan = '';
				//$idpenerimaan = $this->KodePenerimaan();
				$cek.=$idpenerimaan['cek'];
				
				
				$content['statussesuai'] = 1;
				$content['idpenerimaaan'] = $idpenerimaan['content'];
				$content['ceklis'] = "<input type='checkbox' name='jumlah_sesuai' value='1' id='jumlah_sesuai' style='margin-left:20px;' disabled checked /><span style='font-weight:bold;color:black;'>TOTAL HARGA SESUAI</span>";
			}else{
				$content['statussesuai'] = 0;
				$content['ceklis'] = "<input type='checkbox' name='jumlah_sesuai' value='1' id='jumlah_sesuai' style='margin-left:20px;' disabled /><span style='font-weight:bold;color:red;'>TOTAL HARGA BELUM SESUAI</span>";
				$content['idpenerimaaan'] = '';
			}
			
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
			
	}
	
	function KodePenerimaan(){
		global $Main, $HTTP_COOKIE_VARS;
		$coThnAnggaran = $_COOKIE['coThnAnggaran'];
		
		$cek = '';
		$err='';
		$jns_transaksi = $_REQUEST['jns_transaksi'];
		$sumberdana = $_REQUEST['sumberdana'];
		$tgl_buku = explode("-", addslashes($_REQUEST['tgl_buku']));
		//$tgl = $tgl_buku[2].'-'.$tgl_buku[1];
		//$tgl = $coThnAnggaran.'-'.$tgl_buku[1];
		$tgl = $coThnAnggaran;
		
		$c1 = $_REQUEST['c1nya'];
		$c = $_REQUEST['cnya'];
		$d = $_REQUEST['dnya'];
		
		
		$tmpl1 = "SELECT * FROM t_penerimaan_barang WHERE Id='".$_REQUEST['idubah']."' ORDER BY Id DESC ";
		$qrytmpl1 = mysql_query($tmpl1);$cek.=$tmpl1;
					
		if(mysql_num_rows($qrytmpl1) == 0){
			$qry = "SELECT id_penerimaan, SUBSTRING(id_penerimaan,1,5) as kodeAngka  FROM t_penerimaan_barang WHERE c='$c' AND d='$d' AND tgl_buku LIKE '$tgl-%'  ORDER BY kodeAngka DESC LIMIT 0,1";$cek.= $qry;
			$aqry = mysql_query($qry);
			
			$bln = $tgl_buku[1];
			$bulanRomawi = $Main->BulanRomawi[$bln];
			//$tahun = $tgl_buku[2];
			$tahun = $coThnAnggaran;
				
			if(mysql_num_rows($aqry) > 0){
				$dt = mysql_fetch_array($aqry);
				$kodeAngka = $dt['kodeAngka'];
				
	
				$kodeAmbil = intval($kodeAngka)+1;
											
				if(strlen($kodeAmbil) == 1)$kodeAmbil = "0000".$kodeAmbil;
				if(strlen($kodeAmbil) == 2)$kodeAmbil = "000".$kodeAmbil;
				if(strlen($kodeAmbil) == 3)$kodeAmbil = "00".$kodeAmbil;
				if(strlen($kodeAmbil) == 4)$kodeAmbil = "0".$kodeAmbil;					
				
				$content = $kodeAmbil."/$c.$d/$sumberdana/$bulanRomawi/$tahun";
				
			}else{
				$content = "00001/$c.$d/$sumberdana/$bulanRomawi/$tahun";
			}
		}else{
			$IDUBAH = $_REQUEST['idubah'];
			$tmpl = "SELECT * FROM t_penerimaan_barang WHERE Id='$IDUBAH' ORDER BY Id DESC ";$cek.=" | ".$tmpl;
			$qrytmpl = mysql_query($tmpl);
			$dataqrytmpl = mysql_fetch_array($qrytmpl);
			
			$content = $dataqrytmpl['id_penerimaan'];
		}
		
		if($_REQUEST['asalusul'] == '1'){
			$ceksesuai = $this->cekSesuai();
			$cekDULU =$ceksesuai['content'];
			if($cekDULU['statussesuai'] != '1')$content='';
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function BUATBarcode($namanya,$nm_folder,$Idpenerimaan){
		include "lib/phpqrcode/qrlib.php"; //<-- LOKASI FILE UTAMA PLUGINNYA
 
		$tempdir = "Media/$nm_folder/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
		if (!file_exists($tempdir))#kalau folder belum ada, maka buat.
		    mkdir($tempdir);
		 
		 
		$isi_teks = $namanya;
		$namafile = $Idpenerimaan.".png";
		$quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
		$ukuran = 5; //batasan 1 paling kecil, 10 paling besar
		$padding = 0;
		 
		QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
	}
	
	function setForm_content_fields(){
		$content = '';
		
		
		
		foreach ($this->form_fields as $key=>$field){
			if(isset($field['labelWidth'])){
				$labelWidth = $field['labelWidth']==''? $this->formLabelWidth: $field['labelWidth'];
				$pemisah = $field['pemisah']==NULL? ':': $field['pemisah'];			
				$row_params = $field['row_params']==NULL? $this->row_params : $field['row_params'];
				if ($field['type'] == ''){
					$val = $field['value'];
					$content .= 
						"<tr $row_params>
							<td style='width:$labelWidth'>".$field['label']."</td>
							<td style='width:10'>$pemisah</td>
							<td>". $val."</td>
						</tr>";
				}else if ($field['type'] == 'merge' ){
					$val = $field['value'];
					$content .= 
						"<tr $row_params>
							<td colspan=3 >".$val."</td>
						</tr>";
				}else{
					$val = Entry($field['value'],$key,$field['param'],$field['type']);	
					$content .= 
						"<tr $row_params>
							<td style='width:$labelWidth'>".$field['label']."</td>
							<td style='width:10'>$pemisah</td>
							<td>". $val."</td>
						</tr>";
				}	
			}
		}
		//$content = 
		//	"<tr><td style='width:100'>field</td><td style='width:10'>:</td><td>value</td></tr>";
		return $content;	
	}
	
	function Get_AftBIRM_NoBAST($bast_no="", $bast_tgl=""){
		global $DataPengaturan;
		$content = array();
		//NO BAST ----------------------------------------------------------------------------------------------
			$content['hide_bast'] = 0;
			if(($bast_no != "" || $bast_no != NULL) && ($bast_tgl != '' || $bast_tgl !=NULL)){
				$content['no_bast'] = $bast_no;
				$content['tgl_bast'] = $bast_tgl;
				$content['hide_bast'] = 1;
				
				$tgl_bastnya = explode("-",$bast_tgl);
				
				$content['tgl_bast_idn'] = $DataPengaturan->InputTextbox("tgl_dokumen_bast",$tgl_bastnya[2]."-".$tgl_bastnya[1]."-".$tgl_bastnya[0], "","style='width:80px;' readonly");
				
				$content['dokumen_sumber'] = $DataPengaturan->InputHidden("dokumen_sumber", "BAST");
				
			} 
			//$content['hide_bast'] = 0;
		return $content;
			
	}
	
	function Get_AftBIRM_NoKontrak($kontrak_no, $kontrak_tgl){
		global $DataPengaturan;
		
		$c1=cekPOST2("c1nya");
		$c=cekPOST2("cnya");
		$d=cekPOST2("dnya");
		
		$content = array();
			$content["hide_kontrak"] = 0; 
			if(($kontrak_no != "" || $kontrak_no != NULL) && ($kontrak_tgl != '' || $kontrak_tgl !=NULL)){
				// Simpan Data Ke ref_nomor_dokumen -------------------------------------------------
				//Cek Data Ke ref_nomor_dokumen
				$cek_NoDokumen = $DataPengaturan->QryHitungData("ref_nomor_dokumen", "WHERE nomor_dok='$kontrak_no' AND tgl_dok='$kontrak_tgl' AND c1='$c1' AND c='$c' AND d='$d' ");
				if($cek_NoDokumen['hasil'] < 1){
					$data_ins = array(
									array("c1",$c1),
									array("c",$c),
									array("d",$d),
									array("nomor_dok",$kontrak_no),
									array("tgl_dok",$kontrak_tgl),
								);	
					$qry_insNomDok = $DataPengaturan->QryInsData("ref_nomor_dokumen",$data_ins);
				}				
				//No Kontrak
				$content["no_kontrak"] = $DataPengaturan->InputTextbox("nomdok",$kontrak_no,"", 'style="width:339px;" readonly');
				//Tanggal Kontrak
				$content["tgl_kontrak"] = $kontrak_tgl;
				$tgl_kontraknya = explode("-",$kontrak_tgl);
				$content["tgl_kontrak_idn"] = $tgl_kontraknya[2]."-".$tgl_kontraknya[1]."-".$tgl_kontraknya[0];
				
				$content["hide_kontrak"] = 1;
			}
		return $content;
	}
	
	function Set_AftBIRM_InputRekPenerima($KodeBIRM, $Id, $jumlah){
		global $DataPengaturan, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		$data_upd = array(
						array("status", "2"),
					);
		$qry_upd = $DataPengaturan->QryUpdData("t_penerimaan_rekening", $data_upd, "WHERE refid_terima='$Id'");
		
		$data = array(
					array("k",$KodeBIRM[8]),
					array("l",$KodeBIRM[9]),
					array("m",$KodeBIRM[10]),
					array("n",$KodeBIRM[11]),
					array("o",$KodeBIRM[12]),
					array("jumlah",$jumlah),
					array("refid_terima",$Id),
					array("status","0"),
					array("uid",$UID),
					array("sttemp","1"),
				);
		
		$qry = $DataPengaturan->QryInsData("t_penerimaan_rekening", $data);
		
		return $qry["cek"];
	}
	
	function Set_AftBIRM_InputRekPenerima_v2($Id, $IdBIRM){
		global $DataPengaturan, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		$data_upd = array(
						array("status", "2"),
					);
		
		$qry_upd = $DataPengaturan->QryUpdData("t_penerimaan_rekening", $data_upd, "WHERE refid_terima='$Id'");
		
		$qry_birm_rek = "SELECT * FROM t_birm_rekening WHERE ref_idbirm = '$IdBIRM' ";
		$daqry_birm = mysql_query($qry_birm_rek);
		while($dt = mysql_fetch_array($daqry_birm)){
			$data = array(
					array("k",$dt["k"]),
					array("l",$dt["l"]),
					array("m",$dt["m"]),
					array("n",$dt["n"]),
					array("o",$dt["o"]),
					array("jumlah",$dt["jumlah"]),
					array("refid_terima",$Id),
					array("status","0"),
					array("uid",$UID),
					array("sttemp","1"),
				);
		
			$qry = $DataPengaturan->QryInsData("t_penerimaan_rekening", $data);
		}
		
		return $qry["cek"];
	}
	
	function Set_AftBIRM_InputPenDet($pid, $Id){
		global $DataPengaturan, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		$tahun = $_COOKIE['coThnAnggaran']; 
		$cek="";
		//Update t_penerimaan_barang_det -------------------------------------------------------------------------
		$data_upd = array(
						array("status", "2"),
					);
		$qry_upd = $DataPengaturan->QryUpdData("t_penerimaan_barang_det", $data_upd, "WHERE refid_terima='$Id'");
		$cek.=$qry_upd['cek'];
		
		//--------------------------------------------------------------------------------------------------------
		
		$jns_transaksi = cekPOST2("jns_transaksi");
		
		$dtPenerimaan = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang", "c1,c,d,e,e1", "WHERE Id='$Id' ");$cek.=$dtPenerimaan["cek"];
		$DT_Pen = $dtPenerimaan["hasil"];
		
		$qry = "SELECT * FROM t_birm_pekerjaan WHERE ref_idbirm='$pid' ";
		$aqry = mysql_query($qry);
		while($dt = mysql_fetch_array($aqry)){
			
			$jml = $dt["jumlah_barang_vol1"] * $dt["jumlah_barang_vol2"];
			$vol = 1;
			
			$harga_total = $dt["harga"]	* $jml;
			$ppn = 10;
			$hargappn = $harga_total * ($ppn/100);
			$harga_total = $harga_total + $hargappn;
				
			$data = array(
						array("c1", $DT_Pen['c1']),
						array("c", $DT_Pen['c']),
						array("d", $DT_Pen['d']),
						array("e", $DT_Pen['e']),
						array("e1", $DT_Pen['e1']),
						array("f1", "0"),
						array("f", "0"),
						array("g", "0"),
						array("h", "0"),
						array("i", "0"),
						array("j", "0"),
						array("ket_barang", $dt['nama']),
						array("jml", $jml),
						array("kuantitas", $vol),
						array("satuan", $dt["satuan"]),
						array("harga_satuan", $dt["harga"]),
						array("harga_total", $harga_total),
						array("barangdistribusi", "0"),
						array("status", "1"),
						array("sttemp", "1"),
						array("tahun", $tahun),
						array("refid_terima", $Id),
						array("uid", $UID),
						array("ppn", $ppn),
						array("pajak", $hargappn),
					);
					
			$qry_ins = $DataPengaturan->QryInsData("t_penerimaan_barang_det", $data);
			$cek.=$qry_ins["cek"];
		}
		
		return $cek;
	}
	
	function Set_AftBIRM_InputPenyedia($dt){
		global $DataPengaturan;
		$cek='';$content="";
		$c1 = cekPOST2("c1nya");
		$c = cekPOST2("cnya");
		$d = cekPOST2("dnya");
		
		if($dt['no_npwp'] != ""){
			$cekRefPenyedia = $DataPengaturan->QyrTmpl1Brs("ref_penyedia","Id", "WHERE c1='$c1' AND c='$c' AND d='$d' AND no_npwp='".$dt['no_npwp']."' ");$cek.=$cekRefPenyedia["cek"];
			$cekPenyedia = $cekRefPenyedia["hasil"];
			
			
			if($cekPenyedia['Id'] == NULL || $cekPenyedia['Id'] == ""){
				$data = array(
							array("c1", $c1),
							array("c", $c),
							array("d", $d),
							array("nama_penyedia", $dt["nama_penyedia"]),
							array("alamat", $dt["alamat"]),
							array("kota", $dt["kota"]),
							array("nama_pimpinan", $dt["nama_pimpinan"]),
							array("no_npwp", $dt["no_npwp"]),
							array("nama_bank", $dt["nama_bank"]),
							array("norek_bank", $dt["norek_bank"]),
							array("atasnama_bank", $dt["atasnama_bank"]),
						);
				$qry = $DataPengaturan->QryInsData("ref_penyedia", $data);
				
				$ambil = $DataPengaturan->QyrTmpl1Brs2("ref_penyedia", "Id", $data);
				$Qr_ambil = $ambil["hasil"];
				
				$IdPenyedia = $Qr_ambil["Id"]; 
				$Nama_penyedia = $dt["nama_penyedia"]; 
				
			}else{
				$data = array(
							array("nama_penyedia", $dt["nama_penyedia"]),
							array("alamat", $dt["alamat"]),
							array("kota", $dt["kota"]),
							array("nama_pimpinan", $dt["nama_pimpinan"]),
							array("nama_bank", $dt["nama_bank"]),
							array("norek_bank", $dt["norek_bank"]),
							array("atasnama_bank", $dt["atasnama_bank"]),
						);
				$qry = $DataPengaturan->QryUpdData("ref_penyedia", $data, "WHERE Id='".$cekPenerima['Id']."' ");
				
				$IdPenyedia = $cekPenyedia["Id"]; 
				$Nama_penyedia = $dt["nama_penyedia"]; 
			}
				$content = $DataPengaturan->InputTextbox("text_penyedian", $Nama_penyedia, "", "style='width:355px;' readonly").$DataPengaturan->InputHidden("penyedian", $IdPenyedia);
									
			$cek.=$qry["cek"];
		}
		
		
		return array("cek"=>$cek, "content"=>$content);
	}
	
	function Set_AftBIRM_InputPenerima($dt){
		global $DataPengaturan;
		$content = "";
		$cek='';
		$c1 = cekPOST2("c1nya");
		$c = cekPOST2("cnya");
		$d = cekPOST2("dnya");
		$e = cekPOST2("enya");
		$e1 = cekPOST2("e1nya");
		
		if($dt['nip'] != ""){
			$cekRefPenerima = $DataPengaturan->QyrTmpl1Brs("ref_tandatangan","Id", "WHERE c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' AND nip='".$dt['nip']."' ");$cek.=$cekRefPenerima["cek"];
			$cekPenerima = $cekRefPenerima["hasil"];
			if($cekPenerima['Id'] == NULL || $cekPenerima['Id'] == ""){
				$data = array(
							array("c1", $c1),
							array("c", $c),
							array("d", $d),
							array("e", $e),
							array("e1", $e1),
							array("nip", $dt["nip"]),
							array("nama", $dt["nama"]),
							array("jabatan", $dt["jabatan"]),
							array("pangkat", $dt["pangkat"]),
							array("gol", $dt["gol"]),
							array("ruang", $dt["ruang"]),
							array("eselon", $dt["eselon"]),
						);
				$qry = $DataPengaturan->QryInsData("ref_tandatangan", $data);
				$ambilPenerima = $DataPengaturan->QyrTmpl1Brs2("ref_tandatangan", "Id", $data);
				$Qr_ambilPenerima = $ambilPenerima["hasil"];
				
				$IdPenerima = $Qr_ambilPenerima["Id"]; 
				$Nama_penerima = $dt["nama"]; 
			}else{
				$data = array(
							array("nama", $dt["nama"]),
							array("jabatan", $dt["jabatan"]),
							array("pangkat", $dt["pangkat"]),
							array("gol", $dt["gol"]),
							array("ruang", $dt["ruang"]),
							array("eselon", $dt["eselon"]),
						);
				$qry = $DataPengaturan->QryUpdData("ref_tandatangan", $data, "WHERE Id='".$cekPenerima['Id']."' ");
				
				$IdPenerima = $cekPenerima['Id']; 
				$Nama_penerima = $dt["nama"]; 
			}
			
			$content = $DataPengaturan->InputTextbox("text_penerima", $Nama_penerima, "", "style='width:355px;' readonly").$DataPengaturan->InputHidden("penerima", $IdPenerima);
			
			$cek.=$qry["cek"];
		}
		
		
		return array("cek"=>$cek, "content"=>$content);
	}
	
	function AfterPilBIRM(){
		global $DataPengaturan, $Main;
		$cek="";$err="";$content=array();
		
		$IDBIRM = cekPOST2("kode_account_ap");
		$IdPilih = cekPOST2("pemasukan_ins_idplh");
		
		if($IDBIRM != ""){
			$qry = $DataPengaturan->QyrTmpl1Brs("t_birm", "*", "WHERE pid='$IDBIRM' ");
			$dt = $qry['hasil']; $cek.=$qry['cek'];
			
			//Data Kontrak --------------------------------------------------------------------------------------	
			$content["DataKontrak"] =$this->Get_AftBIRM_NoKontrak($dt["kontrak_no"], $dt["kontrak_tgl"]);		
			//Data BAST			
			$content["DataNoBAST"] = $this->Get_AftBIRM_NoBAST($dt["bast_no"], $dt["bast_tgl"]);
			
			//Data BIRM
			$kodeBIRMnya = $dt["kode_pekerjaan"];
			$kodeBIRM = explode(".", $kodeBIRMnya);
			
			
			//Program & Kegiatan ---------------------------------------------------------------------------------
			$content['bk'] = intval($kodeBIRM[2]);
			$content['ck'] = intval($kodeBIRM[3]);
			$content['dk'] = "0";
			$content['p'] = intval($kodeBIRM[6]);
			$content['q'] = intval($kodeBIRM[7]);
			$content['prog'] = $content['bk'].".".$content['ck'].".".$content['dk'].".".$content['p'];
			$content['nama_program'] = $DataPengaturan->KodeProgram($content['bk'], $content['ck'], $content['dk'], $content['p']).". ".$this->getNamaProgKeg($content['bk'], $content['ck'], $content['dk'], $content['p'], "0",1,$IDBIRM);
			
			//Kegiatan
			$nama_kegitan = $DataPengaturan->KodeKegiatan($content['q']).". ".$this->getNamaProgKeg($content['bk'], $content['ck'], $content['dk'], $content['p'], $content['q'],1,$IDBIRM);
			$content['kegiatan'] = $DataPengaturan->InputTextbox("kegiatan1",$nama_kegitan,"", 'style="width:499px;" readonly')."<input type='hidden' name='kegiatan' id='kegiatan' value='".$content['q']."' />";
			
			
			//Pekerjaan --------------------------------------------------------------------------------------------
			$content['pekerjaan'] = $dt['namapekerjaan'];
			$content['hide_pekerjaan'] = "T";
			if($dt['namapekerjaan'] != "" || $dt['namapekerjaan'] != NULL)$content['hide_pekerjaan'] = "Y";
			
						
			//Masukan Ke t_penerimaan_rekening & t_penerimaan_barang_det -------------------------------------------
			$SimpanT = cekPOST2("SimpanT");
			if($SimpanT == "1"){
				if($Main->REK_PENERIMAAN_BIRM == 1){
					$cek.=$this->Set_AftBIRM_InputRekPenerima($kodeBIRM,$IdPilih,$dt["nilaikontrak"]);
					$content["cara_bayar"] = 0;
				}else{
					$cek.=$this->Set_AftBIRM_InputRekPenerima_v2($IdPilih,$dt["pid"]);
					//Sistem Pembayaran
					//$cara_bayar = $this->Get_CekSistemPembayaran($dt);
					//$cek.=$cara_bayar["cek"];
					$content["cara_bayar"]=2;
					if($dt["nilaikontrak"] == $dt["bast_nilai"])$content["cara_bayar"] = 3;
				}
				
				$cek.=$this->Set_AftBIRM_InputPenDet($IDBIRM,$IdPilih);
			}			
			
			//Penyedia Barang --------------------------------------------------------------------------------------
			$InputPenyedia=$this->Set_AftBIRM_InputPenyedia($dt);
			$cek.=$InputPenyedia["cek"];
			$content["penyedian"]= $InputPenyedia["content"];
			
			//Penerima Barang ---------------------------------------------------------------------------------------
			$InputPenerima=$this->Set_AftBIRM_InputPenerima($dt);
			$cek.=$InputPenerima["cek"];
			$content["penerima"]= $InputPenerima["content"];
						
		}
				
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_CekSistemPembayaran($dt_BRIM){
		global $DataPengaturan;
		$cek='';
		
		$totalBelanja = 0;
		//Cari nomor_kontrak & tgl_kontrak yang sama di t_penerimaan
		$qry = "SELECT Id FROM t_penerimaan_barang WHERE nomor_kontrak='".$dt["kontrak_no"]."' AND tgl_kontrak='".$dt["kontrak_tgl"]."' ";$cek.=$qry;
		$aqry =  mysql_query($qry);
		while($dt = mysql_fetch_array($aqry)){
			$qry_pendet = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_rekening", "IFNULL(SUM(jumlah),0) as total", "WHERE refid_terima='".$dt['Id']."' ");
			
			$hasil_total = $qry_pendet["hasil"];
			$totalBelanja = $totalBelanja + $hasil_total["total"];
		}
		
		//Total Belanja Ditambah Data Rekening BIRM
		$qry_BIRM_Rek = $DataPengaturan->QyrTmpl1Brs("t_birm_rekening", "IFNULL(SUM(jumlah),0) as total", "WHERE ref_idbirm='".$dt_BRIM["pid"]."'");
		$dt_BRIM_Rek = $qry_BIRM_Rek["hasil"];		
		
		$totalBelanja = $totalBelanja + $dt_BRIM_Rek["total"];
		
		if($dt_BRIM["nilaikontrak"] == $totalBelanja){
			$cara_bayar = 3;
		}else{
			$cara_bayar = 2;
		}
		
		 $cek.=" | ".$dt_BRIM["nilai_kontrak"]." == ".$totalBelanja." | ";
		
		return array("cek"=>$cek, "cara_bayar"=>$cara_bayar);		
	}
	
	function getNamaProgKeg($bk,$ck,$dk,$p,$q='0',$jns=0,$Id='0'){
		global $DataPengaturan;
		$qry = $DataPengaturan->QyrTmpl1Brs("ref_program", "nama", "WHERE bk='$bk' AND ck='$ck' AND dk='$dk' AND p='$p' AND q='$q' ");
		$hasil = $qry['hasil'];
		
		if($hasil['nama'] == "" || $hasil["nama"] == NULL){
			if($jns != 0){
				switch($jns){
					case 1: //t_birm
						if($Id != "0"){
							$namaProgram = "namaprogram";
							if($q != "0")$namaProgram="namakegiatan";
							//Ambil Data di t_birm
							$qry_BIRM = $DataPengaturan->QyrTmpl1Brs("t_birm", $namaProgram." as nm_pk", "WHERE pid='$Id' ");
							$dt_BIRM = $qry_BIRM['hasil'];
							$data_insProg = array(
												array("bk",$bk),
												array("ck",$ck),
												array("dk",$dk),
												array("p",$p),
												array("q",$q),
												array("nama",$dt_BIRM['nm_pk']),
											);
							$qry_insProg = $DataPengaturan->QryInsData("ref_program",$data_insProg);
							$DataNamaProgKeg = $dt_BIRM['nm_pk'];				
						}
					break;
				}
				
				
				$hasil["nama"] = $DataNamaProgKeg;
				
			}
		}
		
		
		return $hasil["nama"];
		
	}
	
	function Gen_DefaultTglBAST(){
		global $DataPengaturan;
		$cek='';$err="";$content="";
		//Ambil Data
		$Id = cekPOST2("pemasukan_ins_idplh");
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang", "tgl_dokumen_sumber", "WHERE Id='$Id' ");
		$dt = $qry['hasil'];
		$tgl_dokSUM = $dt['tgl_dokumen_sumber'];
		
		$tgl = date("d-m-Y");
		if($tgl_dokSUM != null){
			$tgl_dokSUM = explode("-", $tgl_dokSUM);
			$tgl = $tgl_dokSUM[2]."-".$tgl_dokSUM[1]."-".$tgl_dokSUM[0];
		}
		$content = $DataPengaturan->InputTextbox("tgl_dokumen_bast",$tgl, "","style='width:80px;' class='datepicker'");
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_PeriksaRekeningPenerimaan(){
		global $DataPengaturan, $Main;
		$err = "";
		
		$Id = cekPOST2($this->Prefix."_idplh");
		$kode_BIRM = cekPOST2("kode_account_ap");
		$asalusul = cekPOST2("asalusul");
		
		if($kode_BIRM == "0")$kode_BIRM="";
		//Cek Jumlah Rekening
		$qry = "SELECT * FROM t_penerimaan_rekening WHERE refid_terima='$Id' AND status != '2' GROUP BY k,l,m,n,o ";
		$aqry = mysql_query($qry);
		if($err == "" && mysql_num_rows($aqry) == 0 && $asalusul == "1")$err = "Rekening Belanja Belum Di Masukan !";
		if($err == "" && $kode_BIRM != "" && $Main->BIRMS == 1){
			while($dt = mysql_fetch_array($aqry)){
				$hit_rekBirm = $DataPengaturan->QryHitungData("t_birm_rekening", "WHERE ref_idbirm='$kode_BIRM' AND k='".$dt["k"]."' AND l='".$dt["l"]."' AND m='".$dt["m"]."' AND n='".$dt["n"]."' AND o='".$dt["o"]."' ");
				if($hit_rekBirm["hasil"] < 1){
					$err = "Kode Rekening ".$dt["k"].".".$dt["l"].".".$dt["m"].".".$dt["n"].".".$dt["o"]." Tidak Ada Di BIRM Rekening";
					break;
				}
			}
		}
		
		return $err;
		
	}
	
	function setformUbahNomDok(){
		global $DataPengaturan;
		$cek=''; $err=''; $content='';
		$nomdok = cekPOST2("nomdok");
		$tgl_dok = cekPOST2("tgl_dok");
		$c1 = cekPOST2("c1nya");
		$c = cekPOST2("cnya");
		$d = cekPOST2("dnya");
		$Id = cekPOST2($this->Prefix."_idplh");
		$this->form_fmST = 1;
		
		$qry = $DataPengaturan->QyrTmpl1Brs("ref_nomor_dokumen", "*", "WHERE c1='$c1' AND c='$c' AND d='$d' AND nomor_dok='$nomdok' AND tgl_dok='$tgl_dok' ");$cek.=$qry["cek"];
		$dt = $qry["hasil"];
		if($err =='' && ($dt["Id"] == NULL ||$dt["Id"] == ""))$err="Nomor Dokumen Tidak Valid !";
		if($err ==""){
			//Cek Di t_penerimaan_barang
			$qry_pen = $DataPengaturan->QryHitungData("t_penerimaan_barang", "WHERE nomor_kontrak='$nomdok' AND tgl_kontrak='$tgl_dok' AND c1='$c1' AND c='$c' AND d='$d' AND Id != '$Id'", "Id");$cek.=$qry_pen["cek"];
			$qry_pen1 = $DataPengaturan->QryHitungData("t_penerimaan_retensi", "WHERE nomor_kontrak='$nomdok' AND tgl_kontrak='$tgl_dok' AND c1='$c1' AND c='$c' AND d='$d' AND Id != '$Id'", "Id");$cek.=$qry_pen["cek"];
			
			
			if($qry_pen["hasil"] > 0)$err = "Nomor Dokumen Tidak Bisa di Ubah, Sudah Di Gunakan !";
			if($qry_pen1["hasil"] > 0)$err = "Nomor Dokumen Tidak Bisa di Ubah, Sudah Di Gunakan !";
		}
		
		if($err==""){
			$tgl = explode("-",$tgl_dok);
			
			$dt['tgl'] = $tgl[2]."-".$tgl[1];
			$dt['thn'] = $tgl[0];
			$fm = $this->setFormNomDok($dt);
			$cek.=$fm["cek"];
			$err=$fm['err'];
			$content=$fm['content'];
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function HapusNomorDokumen(){
	 global $HTTP_COOKIE_VARS, $DataPengaturan, $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 //$dokumen_sumber= $_REQUEST['dokumen_sumber2'];
	 $nomdok2= cekPOST2('nomdok');
	 $tgl_dok= cekPOST2('tgl_dok');
	 $c1= cekPOST2('c1nya');
	 $c= cekPOST2('cnya');
	 $d= cekPOST2('dnya');
	 $IdPLH = cekPOST2($this->Prefix."_idplh");
	 	 	 
	 $hit_dok = $DataPengaturan->QryHitungData("t_penerimaan_barang", "WHERE nomor_kontrak='$nomdok2' AND tgl_kontrak='$tgl_dok' AND c1='$c1' AND c='$c' AND d='$d' AND Id!='$IdPLH' ");$cek.=$hit_dok["cek"];
	 
	 $hit_dok1 = $DataPengaturan->QryHitungData("t_penerimaan_retensi", "WHERE nomor_kontrak='$nomdok2' AND tgl_kontrak='$tgl_dok' AND c1='$c1' AND c='$c' AND d='$d' AND Id!='$IdPLH' ");$cek.=$hit_dok["cek"];
	 
	 
	 if($err == '' && $hit_dok['hasil'] > 0)$err='Nomor Dokumen Tidak Bisa Di Hapus Sudah Di Gunakan !';
	 if($err == '' && $hit_dok1['hasil'] > 0)$err='Nomor Dokumen Tidak Bisa Di Hapus Sudah Di Gunakan !';
	 if($err==''){
	 	$qry_hapus = "DELETE FROM ref_nomor_dokumen WHERE nomor_dok='$nomdok2' AND tgl_dok='$tgl_dok' AND c1='$c1' AND c='$c' AND d='$d' ";
		$aqry_hps = mysql_query($qry_hapus);
	 }
					
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function HapusPenyedia(){
	 global $HTTP_COOKIE_VARS, $DataPengaturan, $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 
	 $IdPLH = cekPOST2($this->Prefix."_idplh");
	 $penyedian = cekPOST2("penyedian");
	 $c1 = cekPOST2("c1nya");
	 $c = cekPOST2("cnya");
	 $d = cekPOST2("dnya");
	 	 	 
	 $hit = $DataPengaturan->QryHitungData("t_penerimaan_barang", "WHERE refid_penyedia='$penyedian'");$cek.=$hit["cek"]; 
	 $hit_attr = $DataPengaturan->QryHitungData("t_atribusi", "WHERE refid_penyedia='$penyedian'");$cek.=$hit_attr["cek"]; 
	 
	 if($err == '' && $hit['hasil'] > 0)$err='Penyedia Barang Tidak Bisa Di Hapus, Sudah Di Gunakan !';
	 if($err == '' && $hit_attr['hasil'] > 0)$err='Penyedia Barang Tidak Bisa Di Hapus, Sudah Di Gunakan !';
	 	 
	 //if($err=="")$err='fdghjk';
	 if($err==''){
	 	$qry_hapus = "DELETE FROM ref_penyedia WHERE id='$penyedian'";$cek.=$qry_hapus;
		$aqry_hps = mysql_query($qry_hapus);
	 }
	 
	 $qrypenyedia = "SELECT id,nama_penyedia FROM ref_penyedia WHERE c1= '$c1' AND c='$c' AND d='$d'";
	 $content = cmbQuery('penyedian',"",$qrypenyedia," style='width:303px;' onchange='".$this->Prefix.".OptionPenyedia();'",'--- PILIH PENYEDIA BARANG ---');
					
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function BtnUbahHapus($tmblUbah, $fnc_Ubah, $tmblHapus, $fnc_Hapus ){
	
		return " <input type='button' name='$tmblUbah' id='$tmblUbah' value='UBAH' onclick='pemasukan_ins.$fnc_Ubah()' /> <input type='button' name='$tmblHapus' id='$tmblHapus' value='HAPUS' onclick='pemasukan_ins.$fnc_Hapus()' />";
	}
	function GenOptPenyediaBarang(){
		$cek='';$err="";$content="";
		
		$Id_penyedia = cekPOST2("penyedian");
		if($Id_penyedia != ""){
			$content=$this->BtnUbahHapus("UbahPenyedia","UbahPenyedia", "HapusPenyedia", "HapusPenyedia");
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function SetPenerima(){
		global $HTTP_COOKIE_VARS,$_COOKIE; 
		$cek='';$err="";$content="";
			
		$penerima = cekPOST2('penerima');
		if(isset($HTTP_COOKIE_VARS['CoPenerima'])){
			unset($_COOKIE["CoPenerima"]);
		}
			setcookie("CoPenerima", $penerima , time() + (86400 * 30), "/");	
			$cek .= $HTTP_COOKIE_VARS['CoPenerima'];
		
		if($penerima != ""){
			$content=$this->BtnUbahHapus("UbahPenerima","UbahPenerima", "HapusPenerima", "HapusPenerima");
		}	
			
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function setformUbahPenerima(){
		global $Ref, $Main, $HTTP_COOKIE_VARS, $DataPengaturan;
		$dt=array();
		$cek = '';$err='';
		
		$IdPenerima = cekPOST2("penerima");
		$this->form_idplh =$IdPenerima;
		$this->form_fmST = 1;
		 //set waktu sekarang
		
		$qry = $DataPengaturan->QyrTmpl1Brs("ref_tandatangan", "*", "WHERE Id='$IdPenerima' ");
		$dt = $qry["hasil"];		
		if($err == '')$fm = $this->setFormPenerima($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}
	
	function HapusPenerima(){
	 global $HTTP_COOKIE_VARS, $DataPengaturan, $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 
	 $penerima = cekPOST2("penerima");
	 $c1 = cekPOST2("c1nya");
	 $c = cekPOST2("cnya");
	 $d = cekPOST2("dnya");
	 $e = cekPOST2("enya");
	 $e1 = cekPOST2("e1nya");
	 	 	 
	 $hit = $DataPengaturan->QryHitungData("t_penerimaan_barang", "WHERE refid_penerima='$penerima'");$cek.=$hit["cek"];
	 
	 if($err == '' && $hit['hasil'] > 0)$err='Penerima Barang Tidak Bisa Di Hapus, Sudah Di Gunakan !';
	 	 
	 //if($err=="")$err='fdghjk';
	 if($err==''){
	 	$qry_hapus = "DELETE FROM ref_tandatangan WHERE Id='$penerima'";$cek.=$qry_hapus;
		$aqry_hps = mysql_query($qry_hapus);
	 }
	 
	 $qrypenerima = "SELECT Id, nama FROM ref_tandatangan WHERE c1= '$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' ";
	 $content = cmbQuery('penerima',"",$qrypenerima," style='width:303px;' onchange='".$this->Prefix.".SetPenerima();'",'--- PILIH PENERIMA BARANG ---');
					
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function ImportTemplateBarang(){
	 	global $HTTP_COOKIE_VARS, $DataPengaturan, $Main;
		$cek='';$err='';$content='';
		
		$uid = $HTTP_COOKIE_VARS['coID'];
	 	$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		
		$c1nya = cekPOST2("c1nya");
		$cnya = cekPOST2("cnya");
		$dnya = cekPOST2("dnya");
		$enya = cekPOST2("enya");
		$e1nya = cekPOST2("e1nya");
		
		$IdTmpltBrg = cekPOST2("KodeTemplateBarang");
		$Id_Penerimaan = cekPOST2("pemasukan_ins_idplh");
		$mulainya = cekPOST2("mulainya");
		
		$qry = $DataPengaturan->QyrTmpl1Brs("ref_templatebarang", "*", "WHERE Id='$IdTmpltBrg' AND sttemp='0' ");
		$dt = $qry["hasil"];
		
		if($err == "" && ($dt["Id"] == "" || $dt["Id"] == NULL))$err = "Template Barang Tidak Valid !";
		
		if($err == ""){
			$qry_TBrg_det = "SELECT * FROM ref_templatebarang_det WHERE refid_templatebarang='$IdTmpltBrg' AND sttemp='0'ORDER BY Id LIMIT $mulainya,100 ";$cek.=$qry_TBrg_det;
			$aqry = mysql_query($qry_TBrg_det);
			while($dt_det = mysql_fetch_array($aqry)){
				$data_inp = array(
								array("c1",$c1nya), 
								array("c",$cnya),
								array("d",$dnya), 
								array("e",$enya), 
								array("e1",$e1nya),
								array("f1",$dt_det['f1']), 
								array("f2",$dt_det['f2']), 
								array("f",$dt_det['f']),
								array("g",$dt_det['g']), 
								array("h",$dt_det['h']), 
								array("i",$dt_det['i']),
								array("j",$dt_det['j']), 
								array("ket_barang",$dt_det['ket_barang']), 
								array("jml",$dt_det['jml']), 
								array("kuantitas",$dt_det['kuantitas']),
								array("ket_kuantitas",$dt_det['ket_kuantitas']), 
								array("satuan",$dt_det['satuan']),
								array("harga_satuan",$dt_det['harga_satuan']), 
								array("harga_total",$dt_det['harga_total']),
								array("keterangan",$dt_det['keterangan']), 
								array("barangdistribusi",$dt_det['barangdistribusi']),
								array("status","1"), 
								array("tahun",$coThnAnggaran),
								array("refid_terima",$Id_Penerimaan),
								array("uid",$uid),
								array("sttemp","1"),
							);
				$qry_inp = $DataPengaturan->QryInsData("t_penerimaan_barang_det", $data_inp);$cek.=$qry_inp["cek"]." | ";
				if($qry_inp["errmsg"] != ""){
					$err = "Ups, Ada Error !";
					break;
				}
				
				//Hitung Jumlah Barang
				$qry_hit = $DataPengaturan->QryHitungData("ref_templatebarang_det", "WHERE refid_templatebarang='$IdTmpltBrg' AND sttemp='0'", "Id");
				$content['jmlbarang'] = $qry_hit['hasil'];
				$content['mulai'] = $mulainya+100;
				$content['maxpersen'] = intval(($content['mulai']/$qry_hit['hasil'])*100);
				
			}
			
		}
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function GetSumberDana(){
		global $DataPengaturan;
		$cek='';$err='';$content='';
		$IDUBAH = addslashes($_REQUEST['idubah']);
		$asalusul = cekPOST2("asalusul");
		
		$where_cara =" WHERE nama = 'APBD' ";
		$sumberdana = "APBD";
		if($asalusul != "1"){
			$where_cara=" WHERE nama != 'APBD' ";
			$sumberdana="Hibah Provinsi";
		}
		
		$qrytmpl = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang","*"," WHERE Id='$IDUBAH' ORDER BY Id DESC ");
		$dataqrytmpl = $qrytmpl["hasil"];
		
		if($dataqrytmpl["sumber_dana"] != "" || $dataqrytmpl["sumber_dana"] != NULL)$sumberdana=$dataqrytmpl["sumber_dana"];
		
		$qrysumber_dn = "SELECT nama,nama FROM ref_sumber_dana $where_cara";$cek.=$qrysumber_dn;
		
		$content = cmbQuery('sumberdana',$sumberdana,$qrysumber_dn, "style='width:300px;' onchange='pemasukan_ins.CekSesuai()' ","--- PILIH SUMBER DANA ---");
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function DataCopyDPA($dt, $jns_trans, $data){
		global $DataPengaturan, $DataPemasukan , $Main, $HTTP_COOKIE_VARS;
		$cek='';$err='';
		$uid = $HTTP_COOKIE_VARS['coID'];
		$IdRekBarang = cekPOST2("IdRekBarang");
		
		$where_data = "WHERE refid_terima='".$dt["refid_terima"]."' AND refid_dpa='".$dt["refid_dpa"]."' "; 		
		
		if($err == "" && $IdRekBarang == "")$err="Rekening Rincian Belum di Pilih !";
		if($err == ""){
			$qry_dpa = $DataPengaturan->QyrTmpl1Brs($DataPemasukan->ViewName_rek_det,"*",$where_data." AND refid_rek='$IdRekBarang' ");
			$dt_dpa = $qry_dpa["hasil"];
			if($dt_dpa["refid_rek"] == NULL || $dt_dpa["refid_rek"] == "")$err="Rekening yang Di Pilih, Tidak Valid !";
		}
		if($err == "" && ($dt["Id"] == "" || $dt["Id"] == NULL))$err="Data Tidak Valid !";
		if($err == "" && $dt["jml"] == 0)$err="Data yang Di Gandakan, Volume Tidak Boleh 0 !";
		if($err == "" && $dt["harga_satuan"] == 0)$err="Data yang Di Gandakan, Harga Satuan Tidak Boleh 0 !";
		//Cek Data Dengan Id DPA SAMA --------------------------------------------------------------------------------
		if($err == ""){			
			$qry_cek = $DataPengaturan->QryHitungData($DataPemasukan->TblName_det,$where_data." AND status!='2' AND jml='0' ");
			if($qry_cek["hasil"] > 0)$err = "Data Barang Dari DPA Dengan Nama Barang ".$dt_dpa['nm_barang']." Masih Ada yang Ber-Volume 0 ! Silahkan Selesaikan Terlebih Dahulu !";
		}		
		//Cek Jumlah Maksimal Barang !
		if($err == ""){	
			$qry_tot_jml = $DataPengaturan->QyrTmpl1Brs($DataPemasukan->TblName_det,"IFNULL(SUM(jml),0) as jml_tot ", $where_data." AND status!='2' ");
			$dt_tot_jml = $qry_tot_jml["hasil"];
			if($dt_tot_jml["jml_tot"] >= $dt_dpa["jml"])$err="Tidak Bisa Menggandakan Data, Volume Barang DPA Dengan Nama Barang ".$dt_dpa['nm_barang']." Sudah Tidak Bisa Di Tambahkan !";
		}
		//if($err == "")$err="Fungsi ini Belum Tersedia !";
		if($err == ""){					
			array_push($data,
					array("jml",0),
					array("harga_satuan",0), array("harga_total",0),
					array("pajak",0), array("ppn",0),
					array("refid_dpa",$dt["refid_dpa"]), array("status_dpa",1), array("status2_dpa",1),					
					array("kuantitas",0)
				);
			$data_ins = $DataPengaturan->QryInsData($DataPemasukan->TblName_det,$data);$cek.=$data_ins["cek"];
		}
		
		return array("cek"=>$cek,"err"=>$err);
	}
	
	function DataCopy(){
		global $DataPengaturan,$DataPemasukan, $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		$cek='';$err='';$content='';
		
		$datakopi = cekPOST2("datakopi");
		$Idpilih = cekPOST2($this->Prefix."_idplh");
		
		if($err == "")$err = $this->ValidasiTermin("Gandakan");
		
		if($err == ""){
			$qry = $DataPengaturan->QyrTmpl1Brs($DataPemasukan->ViewName_det,"*", "WHERE Id='$datakopi' AND refid_terima='$Idpilih' AND status != '2' ");
			$dt = $qry["hasil"];
			if($dt['Id'] != '' || $dt["Id"] != NULL){
				$data = array(
							array("c1",$dt["c1"]), array("c",$dt["c"]), array("d",$dt["d"]),
							array("e",$dt["e"]), array("e1",$dt["e1"]),
							array("f1",$dt["f1"]), array("f2",$dt["f2"]), array("f",$dt["f"]), 
							array("g",$dt["g"]), array("h",$dt["h"]), array("i",$dt["i"]), array("j",$dt["j"]),
							array("ket_barang",$dt["ket_barang"]), 
							array("satuan",$dt["satuan"]), array("keterangan",$dt["keterangan"]),
							array("barangdistribusi",$dt["barangdistribusi"]), array("status","1"),
							array("refid_terima",$dt["refid_terima"]),
							array("sttemp","1"), array("uid",$UID), array("tahun",$dt["tahun"]),
							array("ket_kuantitas",$dt["ket_kuantitas"]),
							
						);
				if($dt["refid_dpa"] == NULL || $dt["refid_dpa"] == 0 || $dt["refid_dpa"] == ""){
					array_push($data,
						array("jml",$dt["jml"]),
						array("harga_satuan",$dt["harga_satuan"]), array("harga_total",$dt["harga_total"]),
						array("pajak",$dt["pajak"]), array("ppn",$dt["ppn"]),					
						array("kuantitas",$dt["kuantitas"])
					);
					$data_ins = $DataPengaturan->QryInsData($DataPemasukan->TblName_det,$data);$cek.=$data_ins["cek"];
				}else{
					$jns_transaksi = cekPOST2("jns_transaksi");
					$SetDataCopyDPA = $this->DataCopyDPA($dt,$jns_transaksi, $data);
					$cek.=$SetDataCopyDPA["cek"];
					$err =$SetDataCopyDPA["err"];				
				}
				
			}else{
				$err='Gagal Menggandakan Data Rincian Penerimaan Ini !';
			} 
		}
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function FormLoadingImport(){	
	 global $SensusTmp, $DataPengaturan;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 70;	  
	 $this->form_caption = 'IMPORT DATA TEMPLATE BARANG';
	 
	 $KodeTemplateBarang = cekPOST2("KodeTemplateBarang");
			
	//items ----------------------
	  $this->form_fields = array(
			'progress' => array(
				'label'=>'',
				'labelWidth'=>1, 
				'pemisah'=>' ',
				'value'=>				
					"<br><div id='progressbox' style='background:#fffbf0;border-radius:5px;border:1px solid;height:10px;margin-left:-20px;'>
						<div id='progressbar'></div >
						<div id='statustxt' style='width:0%;background:green;height:10px;text-align:right;color:white;font-size:8px;'>0%</div>						
						<div id='output'></div>
					</div><br>"
				),
			);
		//tombol
		$this->form_menubawah =
			$BARANGNYA.
			"<input type='hidden' name='IdTemplate' id='IdTemplate' value='$KodeTemplateBarang'>";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_TanggalDok_Sumber(){
		global $Main, $DataPengaturan, $HTTP_COOKIE_VARS;
		$err='';$cek='';$content='';		
	 	$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];		
		
		$asalusul = cekPOST2("asalusul");
		$idplh = cekPOST2($this->Prefix."_idplh");
		
		if($err == ""){
			$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang", "tgl_dokumen_sumber","WHERE Id='$idplh' ");
			$dt = $qry["hasil"];
			
			$tgl_dok = FormatTanggalBulan($dt["tgl_dokumen_sumber"]);
			$thn_dok = $asalusul !="3"?$coThnAnggaran:GetTahunFromDB($dt["tgl_dokumen_sumber"]);
			
			$tgl=$tgl_dok == "00-00" || $tgl_dok == "" || $tgl_dok == "-"?date("d-m"):$tgl_dok;
			$thn=intval($thn_dok) > 0?$thn_dok:$coThnAnggaran;
			
			$rd = $asalusul !="3"?"readonly":"";
			
			$content = 
				InputTypeText("tgl_dokumen_bast", $tgl, "class='datepicker2' style='width:40px;'").
				InputTypeText("thn_dokumen_bast", $thn, "style='width:40px;' $rd");
			
			/*if($asalusul == "1"){
				$tgl = $tgl_dokumen[2]."-".$tgl_dokumen[1];
				$thn = $tgl_dokumen[0];
				if($tgl == "00-00" || $tgl=="-")$tgl=date("d-m");
				if($thn == "0000" || $thn == "")$thn=$coThnAnggaran;
				
				$content = "<input type='text' name='tgl_dokumen_bast' id='tgl_dokumen_bast' class='datepicker2' value='$tgl' style='width:40px;' /><input type='text' name='thn_dokumen_bast' id='thn_dokumen_bast' value='$thn' style='width:40px;'  readonly />";
				
			}else{
				$tgl_dokumen_bast = $tgl_dokumen[2]."-".$tgl_dokumen[1]."-".$tgl_dokumen[0]; 
				if($dt["tgl_dokumen_sumber"] == "0000-00-00" || $dt["tgl_dokumen_sumber"] == "")$tgl_dokumen_bast=date("d-m-Y");
				
				$content = "<input type='text' name='tgl_dokumen_bast' id='tgl_dokumen_bast' class='datepicker' value='$tgl_dokumen_bast' style='width:80px;' />";				
			}*/
			
		}
		
		
		
		//if($err=='')$err="gdfhf";
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Load_DataCaraBayar_InsRek($IdTerima){
		global $DataPengaturan,$HTTP_COOKIE_VARS;
		$cek="";
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		$idplh=cekPOST2($this->Prefix."_idplh");
		
		//Ambil Dari Rekening
		$qry_rek = "SELECT * FROM t_penerimaan_rekening WHERE refid_terima='$IdTerima' AND sttemp='0' ";$cek.=$qry_rek;
		$aqry_rek = mysql_query($qry_rek);
		while($dt_rek = mysql_fetch_array($aqry_rek)){
			$data_ins_rek = array(
								array("k",$dt_rek["k"]),
								array("l",$dt_rek["l"]),
								array("m",$dt_rek["m"]),
								array("n",$dt_rek["n"]),
								array("o",$dt_rek["o"]),
								array("jumlah","1"),
								array("refid_terima",$idplh),
								array("status","0"),
								array("sttemp","1"),
								array("uid",$uid),
							);	
			$qry_ins_rek = $DataPengaturan->QryInsData("t_penerimaan_rekening",$data_ins_rek);$cek.=$qry_ins_rek["cek"];
		}
		
		return $cek;
	}
	
	function Load_DataCaraBayar_InsPenDet($IdTerima){
		global $DataPengaturan,$HTTP_COOKIE_VARS;
		$cek="";
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		$idplh=cekPOST2($this->Prefix."_idplh");
		
		//Ambil Dari t_penerimaan_barang_det
		$qry = "SELECT * FROM t_penerimaan_barang_det WHERE refid_terima='$IdTerima' AND sttemp='0' ";$cek.=$qry;
		$aqry = mysql_query($qry);
		while($dt = mysql_fetch_array($aqry)){
			$data_ins = array(
								array("c1",$dt["c1"]),
								array("c",$dt["c"]),
								array("d",$dt["d"]),
								array("e",$dt["e"]),
								array("e1",$dt["e1"]),
								array("f1",$dt["f1"]),
								array("f2",$dt["f2"]),
								array("f",$dt["f"]),
								array("g",$dt["g"]),
								array("h",$dt["h"]),
								array("i",$dt["i"]),
								array("j",$dt["j"]),
								array("ket_barang",$dt["ket_barang"]),
								array("jml",$dt["jml"]),
								array("kuantitas",$dt["kuantitas"]),
								array("ket_kuantitas",$dt["ket_kuantitas"]),
								array("satuan",$dt["satuan"]),
								array("harga_satuan",$dt["harga_satuan"]),
								array("harga_total",$dt["harga_total"]),
								array("keterangan",$dt["keterangan"]),
								array("barangdistribusi",$dt["barangdistribusi"]),
								array("tahun",$dt["tahun"]),
								array("jml_terima",$dt["jml_terima"]),								
								array("refid_terima",$idplh),
								array("status","1"),
								array("sttemp","1"),
								array("uid",$uid),
							);	
			$qry_ins = $DataPengaturan->QryInsData("t_penerimaan_barang_det",$data_ins);
		}
		
		return $cek;
	}
	
	function Load_DataCaraBayar_Upd(){
		global $DataPengaturan,$HTTP_COOKIE_VARS;
		$cek='';
		$idplh=cekPOST2($this->Prefix."_idplh");
		//Update Rekening
		$data = array(array("status",2));
		$qry_rek = $DataPengaturan->QryUpdData("t_penerimaan_rekening",$data,"WHERE refid_terima='$idplh' ");
		$qry_pendet = $DataPengaturan->QryUpdData("t_penerimaan_barang_det",$data,"WHERE refid_terima='$idplh' ");
		$cek.=$qry_rek["cek"]." | ".$qry_pendet["cek"];
		
		return $cek;
	}
	function Load_DataCaraBayar(){
		global $DataPengaturan,$HTTP_COOKIE_VARS;
		$cek="";$err="";$content='';$content['aktif']=0;
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		$nomdok=cekPOST2("nomdok");
		$tgl_dok=cekPOST2("tgl_dok");
		$idplh=cekPOST2($this->Prefix."_idplh");
		
		$c1=cekPOST2("c1nya");
		$c=cekPOST2("cnya");
		$d=cekPOST2("dnya");
		$e=cekPOST2("enya");
		$e1=cekPOST2("e1nya");
		$jns_transaksi=cekPOST2("jns_transaksi");
		
		if($err == "" && $nomdok=="")$err= "Nomor Dokumen Belum di Pilih !";
		if($err == ""){
			if($jns_transaksi == "1"){
				$data_where = array(
								array("c1",$c1),
								array("c",$c),
								array("d",$d),
								array("e",$e),
								array("e1",$e1),
								array("jns_trans",$jns_transaksi),
								array("tgl_kontrak",$tgl_dok),
								array("sttemp","0"),
							);
				//Ambil Data Di t_penerimaan_barang
				$qry = $DataPengaturan->QyrTmpl1Brs2("t_penerimaan_barang", "*", $data_where," ORDER BY Id DESC");
				$dt=$qry["hasil"];
				
				if($dt["Id"] != NULL){
					$cek.=$this->Load_DataCaraBayar_Upd();
					$cek.=$this->Load_DataCaraBayar_InsRek($dt["Id"]);
					$cek.=$this->Load_DataCaraBayar_InsPenDet($dt["Id"]);
					$content['aktif']=1;
					$content['sumberdana']=$dt["sumber_dana"];
					$content['metodepengadaan']=$dt["metode_pengadaan"];
					$content['pencairan_dana']=$dt["pencairan_dana"];
					$content['prog']=$dt["bk"].".".$dt["ck"].".".$dt["dk"].".".$dt["p"];
					$content["program"] = $DataPengaturan->GetProgKeg2($dt["bk"],$dt["ck"],$dt["dk"],$dt["p"]);
					
					$qrykegitan = "SELECT q,concat (IF(LENGTH(q)=1,concat('0',q), q),'. ',nama) as nama FROM ref_program WHERE bk='".$dt["bk"]."' AND ck='".$dt["ck"]."' AND dk='".$dt["dk"]."' AND p='".$dt["p"]."' AND q!='0'";
					
					$content["dafkeg"] = cmbQuery('kegiatan1',$dt["q"],$qrykegitan," style='width:500px;' onchange='document.getElementById(`kegiatan`).value=this.value;' ",'--- PILIH KEGIATAN ---')."<input type='hidden' name='kegiatan' value='".$dt["q"]."' id='kegiatan' />";
					
					$content['pekerjaan']=$dt["pekerjaan"];
					$content['penyedian']=$dt["refid_penyedia"];
					$content['penerima']=$dt["refid_penerima"];
					$content['keterangan_penerimaan']=$dt["keterangan_penerimaan"];
					$content['keterangan_penerimaan']=$dt["keterangan_penerimaan"];
					
				}
			}
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_inputpenerimaanDET(){
		global $DataPengaturan,$DataOption, $DataPemasukan;
		$cek='';$err='';$content='';
		
		$dt = array();
		$dt['FMST_penerimaan_det'] = '0';
		if($_REQUEST['jns_transaksi'] == '2')$dt['barangdistribusi'] = 1;
		
		
		//UPDATE DPA 27 DESEMBER 2017 -------------------------------------
		$status_dpa = cekPOST2("status_dpa");
		$idplh = cekPOST2($this->Prefix."_idplh");
		if($DataPemasukan->Cek_DataDPA($idplh, $status_dpa) == 1){			
			$GetRekeningDPA = cekPOST2("GetRekeningDPA");
			$dt_rek = explode("_",$GetRekeningDPA);
			$DataRekening = $DataPengaturan->Get_valRekening2($dt_rek[0],$dt_rek[1],$dt_rek[2],$dt_rek[3],$dt_rek[4]);
			$dt["k"]= $dt_rek[0];$cek.=" ".$dt_rek[0];
			$dt["l"]= $dt_rek[1];
			$dt["m"]= $dt_rek[2];
			$dt["n"]= $dt_rek[3];
			$dt["o"]= $dt_rek[4];
			$dt["nm_rekening"]= $DataRekening["nm_rekening"];$cek.=" ".$DataRekening["nm_rekening"];
			$dt["harga_total"] = 0;
		}
				
		
		$get = $this->inputpenerimaanDET($dt);
		$cek.= $get['cek'];
		$err = $get['err'];
		$content = $get['content'];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_UbahRincianPenerimaan(){
		global $DataPengaturan,$DataOption, $DataPemasukan;
		$cek='';$err='';$content='';
		$IdRincian = $_REQUEST['IdRincian'];
		
		$qry = "SELECT * FROM ".$DataPengaturan->VPenerima_det()." WHERE Id='$IdRincian' ";$cek.=$qry;
		$aqry = mysql_query($qry);
		$dt = mysql_fetch_array($aqry);	
		
		$DataPenerimaan = $DataPemasukan->Gen_DataPenerimaan($dt["refid_terima"]);
		
		if($DataOption['kode_barang'] != '1'){
			$dt['kodebarangnya'] = $kodebarang = $dt['f1'].'.'.$dt['f2'].'.'.$dt['f'].'.'.$dt['g'].'.'.$dt['h'].'.'.$dt['i'].'.'.$dt['j'] ;
		}else{
			$dt['kodebarangnya'] = $kodebarang = $dt['f'].'.'.$dt['g'].'.'.$dt['h'].'.'.$dt['i'].'.'.$dt['j'] ;
		}
		
		$dt['kodebarangnya'].=$DataPenerimaan["jns_trans"] == "3"?".".$dt["j1"]:"";
		
			
		$dt['FMST_penerimaan_det'] = '1';	
					
		$get= $this->inputpenerimaanDET($dt);
		$cek = $cek.$get['cek'];
		$err = $get['err'];
		$content = $get['content'];
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_HapusRincianPenerimaan(){
		global $DataPengaturan,$DataOption;
		$cek = '';$err = '';$content = '';
		$IdRincian=cekPOST2("IdRincian");
		$pemasukan_ins_idplh=cekPOST2($this->Prefix."_idplh");
				
		if($IdRincian == '' && $err == '')$err = "Data Tidak Ada ?";
		if($err == "")$err=$this->ValidasiTermin("Hapus");
		
		if($err == ''){
			$qry = "UPDATE t_penerimaan_barang_det SET status='2' WHERE Id='$IdRincian' AND refid_terima='$pemasukan_ins_idplh' ";$cek.=$qry;
			$aqry = mysql_query($qry);
			if($aqry == FALSE)$err = "Data Tidak Bisa Dihapus !";
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_tabelRekening(){		
		global $DataPengaturan,$DataOption;
		$pemasukan_ins_idplh = $_REQUEST['pemasukan_ins_idplh'];		
		if(addslashes($_REQUEST['HapusData'])==1){	
			$qrydel1 = "DELETE FROM t_penerimaan_rekening WHERE refid_terima='$pemasukan_ins_idplh' AND status='1' ";
			$aqrydel1 = mysql_query($qrydel1);
		}
		$get= $this->tabelRekening();
		$cek = $get['cek'];
		$err = $get['err'];
		$content = $get['content'];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_InsertRekening(){
		global $DataPengaturan,$DataOption, $HTTP_COOKIE_VARS;
		$cek = '';$err = '';$content = '';
		$uid = $HTTP_COOKIE_VARS['coID'];
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$pemasukan_ins_idplh = $_REQUEST['pemasukan_ins_idplh'];
		
		if($err == "")$err = $this->ValidasiTermin("2", "Rekening");		
		if($err == ""){		
			$qrydel = "DELETE FROM t_penerimaan_rekening WHERE refid_terima='$pemasukan_ins_idplh' AND status='1' AND uid='$uid'";
			$aqrydel = mysql_query($qrydel);			
			if($aqrydel){
				$qry="INSERT INTO t_penerimaan_rekening (refid_terima, status,uid, sttemp,tahun) values ('$pemasukan_ins_idplh','1','$uid','1','$coThnAnggaran')";$cek.=$qry;
				$aqry = mysql_query($qry);
				if($aqry){
					$content = 1;
				}else{
					$err= 'Gagal !';
				}
			}
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_updKodeRek(){
		global $DataPengaturan,$DataOption, $HTTP_COOKIE_VARS;
		$cek = '';$err = '';$content = '';
		$uid = $HTTP_COOKIE_VARS['coID'];
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$pemasukan_ins_idplh = $_REQUEST['pemasukan_ins_idplh'];
		$idrek = $_REQUEST['idrek'];
		$koderek = $_REQUEST['koderek'];
		$jumlahharga = $_REQUEST['jumlahharga'];
		if($jumlahharga < 1 && $err=='')$err='Jumlah Harga Belum Di Isi !';
		
		$qry = "SELECT nm_rekening FROM ref_rekening WHERE concat(k,'.',l,'.',m,'.',n,'.',o) = '$koderek' AND k != '0' AND l != '0' AND m != '0' AND n != '00' AND o != '00'"; $cek.=$qry;
		$aqry = mysql_query($qry);
		
		if(mysql_num_rows($aqry) == 0 && $err=='')$err = "KODE REKENING TIDAK VALID !";
		
		if($err==''){
			$kode = explode(".",$koderek);
			$knya = $kode[0];
			$lnya = $kode[1];
			$mnya = $kode[2];
			$nnya = $kode[3];
			$onya = $kode[4];
			if($_REQUEST['statidrek'] == '1'){
				$qryupd="UPDATE t_penerimaan_rekening SET k='$knya',l = '$lnya',m = '$mnya', n= '$nnya',o= '$onya', jumlah='$jumlahharga', status='0' WHERE refid_terima='$pemasukan_ins_idplh' AND Id='$idrek'";
			}else{
				$qryupd="INSERT INTO t_penerimaan_rekening (k,l,m,n,o,status,refid_terima,sttemp,uid,jumlah,tahun)values('$knya','$lnya','$mnya','$nnya','$onya','0','$pemasukan_ins_idplh','1','$uid','$jumlahharga', '$coThnAnggaran')";
				$updq = "UPDATE t_penerimaan_rekening SET status = '2' WHERE Id='$idrek'";
				$aupdq = mysql_query($updq); 
			}
			$cek.=" | ".$qryupd;
			$aqryupd = mysql_query($qryupd);
			if($aqryupd){
				$content['koderek'] = "<a href='javascript:pemasukan_ins.jadiinput(`".$idrek."`);' />".$koderek."</a>";
				$content['jumlahnya'] = number_format($jumlahharga,2,",",".");
				$content['idrek'] = $idrek;
				$content['option'] = "
			<a href='javascript:pemasukan_ins.HapusRekening(`$idrek`)' />
				<img src='datepicker/remove2.png' style='width:20px;height:20px;' />
			</a>";
			}else{
				$err= 'Gagal !';
			}
		}	
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_HapusRekening(){		
		global $DataPengaturan,$DataOption;
		$cek = '';$err = '';$content = '';
		$uid = $HTTP_COOKIE_VARS['coID'];
		$idrekei = $_REQUEST['idrekei'];
		$pemasukan_ins_idplh = $_REQUEST['pemasukan_ins_idplh'];
		
		if($err == "")$err = $this->ValidasiTermin("Hapus", "Rekening");		
		if($err == ""){
			$qrydel = "UPDATE t_penerimaan_rekening SET status='2' WHERE Id='$idrekei'";$cek.=$qrydel;
			$aqrydel = mysql_query($qrydel);
			
			$qrydel1 = "DELETE FROM t_penerimaan_rekening WHERE refid_terima='$pemasukan_ins_idplh' AND status='1' AND uid='$uid'";
			$aqrydel1 = mysql_query($qrydel1);
			
			if(!$aqrydel)$err='Gagal Menghapus Data Rekening';
			if(!$aqrydel1)$err='Gagal Menghapus Data Rekening';
		}
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_jadiinput(){		
		global $DataPengaturan, $DataOption;
		$cek = '';$err = '';$content = '';
		$uid = $HTTP_COOKIE_VARS['coID'];
		$idrek = $_REQUEST['idrekeningnya'];
		
		$qry = "SELECT * FROM t_penerimaan_rekening WHERE Id='$idrek'";$cek.=$qry;
		$aqry = mysql_query($qry);
		$dt = mysql_fetch_array($aqry);
		
		$kdRek = $DataPengaturan->Gen_valRekening($dt);
		
		$content['koderek'] = 
			InputTypeText("koderek", $kdRek, "onkeyup='setTimeout(function myFunction() {pemasukan_ins.namarekening();},100);' style='width:80px;' maxlength='13'").
			BtnImg_Cari("cariRekening.windowShow(".$dt['Id'].");","Cari", "style='width:20px;height:20px;margin-bottom:-5px;'");
		$cekTermin = $this->ValidasiTermin(".",".");
		if($cekTermin != '')$content['koderek']=InputTypeText("koderek", $kdRek, "style='width:80px;' readonly");
		
		$content['koderek'] .=	
			InputTypeHidden("idrek", $idrek).
			InputTypeHidden("statidrek", $dt['status']);		
		
		
		$content['jumlahnya'] = "<input type='text' name='jumlahharga' id='jumlahharga' value='".floatval($dt['jumlah'])."' style='text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = pemasukan_ins.formatCurrency(this.value);' />
						<span id='formatjumlah'></span>";
		$content['idrek'] = $idrek;
		$content['option'] = "
			<a href='javascript:pemasukan_ins.updKodeRek()' />
				<img src='datepicker/save.png' style='width:20px;height:20px;' />
			</a>";
		$content['atasbutton'] = "<a href='javascript:pemasukan_ins.tabelRekening()' /><img src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>";
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_namarekening(){		
		global $DataPengaturan, $DataOption;
		$cek = '';$err = '';$content = '';
		
		$idrek = $_REQUEST['idrek'];
		$koderek = addslashes($_REQUEST['koderek']);
		
		$qry = "SELECT nm_rekening FROM ref_rekening WHERE concat(k,'.',l,'.',m,'.',n,'.',o) = '$koderek' AND k<>'0' AND l<>'0' AND m<>'0' AND n<>'00' AND o<>'00'"; $cek.=$qry;
		$aqry = mysql_query($qry);
		$daqry = mysql_fetch_array($aqry);
		$content['namarekening'] = $daqry['nm_rekening'];
		$content['idrek'] = $idrek;
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_nomordokumen(){		
		global $DataPengaturan, $DataOption;
		$cek = '';$err = '';$content = '';
		
		$c1 = $_REQUEST['c1nya'];
	    $c = $_REQUEST['cnya'];
	    $d = $_REQUEST['dnya'];
		$content["Tombol"]="";
		
		$dokumen_sumber = $_REQUEST['dokumen_sumber'];
		$nomdok =$_REQUEST['nom'];
					
		$qrynomdok = "SELECT nomor_dok,nomor_dok FROM ref_nomor_dokumen WHERE c1='$c1' AND c='$c' AND d='$d' ";
		$cek.=$qrynomdok;
		$content['isi'] = cmbQuery('nomdok',$nomdok,$qrynomdok," style='width:287px;' onchange='pemasukan_ins.TglNomorDokumen()' ","--- PILIH NOMOR DOKUMEN ---");
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_Tglnomordokumen(){		
		global $DataPengaturan, $DataOption;
		$cek = '';$err = '';$content = '';
		$dokumen_sumber = $_REQUEST['dokumen_sumber'];
		$nomdok =$_REQUEST['nomdok'];
		$c1 = $_REQUEST['c1nya'];
	    $c = $_REQUEST['cnya'];
	    $d = $_REQUEST['dnya'];
				
		$qrynomdok = "SELECT * FROM ref_nomor_dokumen WHERE nomor_dok='$nomdok' AND  c1='$c1' AND c='$c' AND d='$d' LIMIT 0,1";
		$cek.=$qrynomdok;
		$aqrtnomdok = mysql_query($qrynomdok);
		$dt = mysql_fetch_array($aqrtnomdok);
		
		
		if(mysql_num_rows($aqrtnomdok) != 0){
			$tgl = explode("-",$dt['tgl_dok']);
		
			$content['tgl'] = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
			$content['tgl_dok'] = $dt['tgl_dok'];
			$content["Tombol"] = $this->BtnUbahHapus("UbahNomDok","UbahNomDok", "HapusNomDok", "HapusNomDok");
		}else{
			$content['tgl_dok'] ='';
			$content['tgl'] = '';
			$content["Tombol"] = "";
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Option_pilihPangkat(){		
		global $DataPengaturan, $DataOption;
		global $Main;
		$cek = '';$err = '';$content = '';
			
		$idpangkat = $_REQUEST['pangkatakhir'];		
		$query = "select concat(gol,'/',ruang)as nama FROM ref_pangkat WHERE nama='$idpangkat'" ;
		$get=mysql_fetch_array(mysql_query($query));$cek.=$query;
		$content=$get['nama'];
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function GetData_DPA_ProgKeg(){
		global $DataPengaturan,$Main,$DataPemasukan;
		$cek = '';$err = '';$content = array();
		
		$idplh = cekPOST2($this->Prefix."_idplh");
		$qry = $DataPengaturan->QyrTmpl1Brs($DataPemasukan->TblName_det, "*", "WHERE refid_terima='$idplh' AND refid_dpa!='0' AND status != '2' ");
		$dt = $qry["hasil"];
		$content["status_dpa"] = 0;
		if($this->tabelRekening_cekDariDPA()){
			$content["nm_program"] = $DataPengaturan->GetProgKeg2($dt["bk"], $dt["ck"], $dt["dk"],$dt["p"]);
			$content["kd_program"] = $DataPengaturan->Gen_valProgram($dt);
			$content["kd_kegiatan"] = $dt["q"];
			$content["status_dpa"] = 1;
			$content["nm_kegiatan"] = 
				InputTypeText("kegiatan1",$DataPengaturan->GetProgKeg2($dt["bk"], $dt["ck"], $dt["dk"], $dt["p"], $dt["q"]),"style='width:500px;' readonly").
				InputTypeHidden("kegiatan",$dt["q"]);
		}	
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Set_SaveRekeningForDPA(){
		global $DataPengaturan,$Main,$DataPemasukan;
		$cek = '';$err = '';$content = '';
		
		$idplh = cekPOST2($this->Prefix."_idplh");
		//UPDATE t_penerimaan_rekening --------------------------------------
		//$qry_upd = $DataPengaturan->QryUpdData($DataPemasukan->TblName_rek,$data_upd,"WHERE Id='$idplh' AND status !='2' ");
		$qry = QueryTmplBrs2($DataPemasukan->TblName_det,"SUM(harga_total) as harga_total,k,l,m,n,o,uid,tahun","WHERE refid_terima='$idplh' AND status !='2' AND refid_dpa!='0' GROUP BY k,l,m,n,o ");$cek.=$qry;
		$aqry = mysql_query($qry);
		while($dt = mysql_fetch_array($aqry)){
			$data = array(
						array("k",$dt["k"]),
						array("l",$dt["l"]),
						array("m",$dt["m"]),
						array("n",$dt["n"]),
						array("o",$dt["o"]),
						array("jumlah",$dt["harga_total"]),
						array("refid_terima",$idplh),
						array("status","0"),
						array("uid",$dt["uid"]),
						array("sttemp","1"),
						array("tahun",$dt["tahun"]),
						array("status_dpa","1"),
					);
			$qry_ins = $DataPengaturan->QryInsData($DataPemasukan->TblName_rek,$data);
		}
		
		$tbl = array($DataPemasukan->TblName_det." a",$DataPemasukan->TblName_rek." b");
		$on = array(array("a.k","b.k"),array("a.l","b.l"),array("a.m","b.m"),array("a.n","b.n"),array("a.o","b.o"),array("a.refid_terima","b.refid_terima"));
		$where = array(array("a.refid_dpa","0","!="),array("a.status","2","!="),array("b.status","0"),array("b.refid_terima",$idplh));
		$qry_tmpl = QueryJoin($tbl,"LEFT JOIN","a.refid_dpa, b.Id as IdRek, b.refid_terima",$on,$where,"GROUP BY a.refid_dpa"); $cek.=$qry_tmpl;		
		$aqry_tmpl = mysql_query($qry_tmpl);
		while($dt_rek = mysql_fetch_array($aqry_tmpl)){
			$data_ins_rekDet = 
				array(
					array("refid_rek",$dt_rek["IdRek"]),
					array("refid_dpa",$dt_rek["refid_dpa"]),
					array("refid_terima",$dt_rek["refid_terima"]),
				);
			$qry_ins_rekDet = $DataPengaturan->QryInsData($DataPemasukan->TblName_rek_det,$data_ins_rekDet);
		}				
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_jmlMaksBarang_DPA(){
		global $DataPengaturan;
		$cek = '';$err = '';$content = array();
		
		$idplh=cekPOST2($this->Prefix."_idplh");
		$IdRekeningDPA=cekPOST2("IdRekeningDPA");
		$refid_terimanya=cekPOST2("refid_terimanya");
		$refid_dpa_brg=cekPOST2("refid_dpa_brg");
		
		$err="";
		$getHargaMaksimalDPA = $this->GetHargaMaksimalDPA($idplh,$refid_terimanya,$IdRekeningDPA,$refid_dpa_brg);
		$cek.= $getHargaMaksimalDPA["cek"];
		$hrg_maks = $getHargaMaksimalDPA["content"];
		$content["hrg_maksimal"] = FormatUang($hrg_maks["harga_satuan"]);
		$content["jml_maksimal"] = FormatAngka($hrg_maks["jml"]);
		$content["kuantitas_maksimal"] = FormatAngka($hrg_maks["kuantitas"]);
		$content["konten_BTNRealisasi"] = $this->Gen_Button_RealisasiDPA();
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_Btn_CariTermin($AMBIL=FALSE){
		global $DataPengaturan;
		$cek = '';$err = '';$content = "";
		
		$status_kdp = cekPOST2("status_kdp");
		$content=InputTypeButton("Btn_Status_KDP_nomdok","CARI","onclick='".$this->Prefix.".cariDokumenKontrak();'");
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function cariDokumenKontrak_After_InsBarang($dt){
		global $DataPengaturan, $DataPemasukan, $HTTP_COOKIE_VARS;
	 	$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek="";
		$tbl = $DataPemasukan->TblName_det;
		$qry_det = $DataPengaturan->QyrTmpl1Brs($tbl, "*", "WHERE refid_terima='".$dt["Id"]."' AND sttemp='0' ");
		$isi = $qry_det["hasil"];
		$Idplh = cekPOST2($this->Prefix."_idplh");
		$data_ins =
			array(
				array("c1",$isi["c1"]),array("c",$isi["c"]),array("d",$isi["d"]),array("e",$isi["e"]),array("e1",$isi["e1"]),
				array("f1",$isi["f1"]),
				array("f2",$isi["f2"]),
				array("f",$isi["f"]),
				array("g",$isi["g"]),
				array("h",$isi["h"]),
				array("i",$isi["i"]),
				array("j",$isi["j"]),
				array("j1",$isi["j1"]),
				array("ket_barang",$isi["ket_barang"]),
				array("jml",$isi["jml"]),
				array("kuantitas",$isi["kuantitas"]),
				array("ket_kuantitas",$isi["ket_kuantitas"]),
				array("satuan",$isi["satuan"]),
				array("harga_satuan",0),
				array("harga_total",0),
				array("keterangan",$isi["keterangan"]),
				array("barangdistribusi",$isi["barangdistribusi"]),
				array("status",0),
				array("tahun",$coThnAnggaran),
				array("refid_terima",$Idplh),
				array("uid",$Idplh),
				array("sttemp","1"),
			);
		$qry_ins = $DataPengaturan->QryInsData($tbl, $data_ins); $cek.=$qry_ins["cek"];
			
		return $cek;
	}
	
	function cariDokumenKontrak_After(){
		global $DataPengaturan;
		$cek = '';$err = '';$content = array();
		
		$data_where = 
			array(
				array("c1",cekPOST2("c1nya")),array("c",cekPOST2("cnya")),array("d",cekPOST2("dnya")),
				array("e",cekPOST2("enya")),array("e1",cekPOST2("e1nya")),array("sttemp","0"),
				array("nomor_kontrak",cekPOST2("nomdok")),array("tgl_kontrak",cekPOST2("tgl_dok")),
				array("jns_trans",1),array("cara_bayar IS NOT NULL")
			);
		
		$qry = $DataPengaturan->QyrTmpl1Brs2($this->TblName,"*",$data_where," ORDER BY Id ");$cek.=$qry["cek"]." || ";
		$dt = $qry["hasil"];		
		
		$aksi=$dt["Id"]!=NULL || $dt["Id"]!=""?1:0;			
		if($aksi == "1"){
			$qrykegitan = "SELECT q,concat (IF(LENGTH(q)=1,concat('0',q), q),'. ',nama) as nama FROM ref_program WHERE bk='".$dt['bk']."' AND ck='".$dt['ck']."' AND dk='".$dt['dk']."' AND p='".$dt['p']."' AND q!='0'";			
			$content["program"]=$DataPengaturan->GetProgKeg2($dt["bk"],$dt["ck"],$dt["dk"],$dt["p"]);
			$content["prog"]=$DataPengaturan->Gen_valProgram($dt);
			$content["pekerjaan"]=$dt["pekerjaan"];
			$content["dafkeg"]=
				cmbQuery('kegiatan1',$dt["q"],$qrykegitan," style='width:500px;' onchange='document.getElementById(`kegiatan`).value=this.value;' ",'--- PILIH KEGIATAN ---').
				InputTypeHidden("kegiatan",$dt["q"]);
			$content["penyedian"]=$dt["refid_penyedia"];
			$content["penerima"]=$dt["refid_penerima"];
			$content["keterangan_penerimaan"]=$dt["keterangan_penerimaan"];
			//Masukan Data Ke Rekening	
			$cek.=$this->cariDokumenKontrak_After_InsRekBelanja($dt);
			$cek.=$this->cariDokumenKontrak_After_InsBarang($dt);
		}else{
			$qrykegitan = "SELECT q,nama_program_kegiatan FROM ref_programkegiatan WHERE p='00' AND q='00'";
			$content["program"]="";
			$content["prog"]="";
			$content["pekerjaan"]="";
			$content["dafkeg"]=
				cmbQuery('kegiatan1',"",$qrykegitan," disabled style='width:500px;' onchange='document.getElementById(`kegiatan`).value=this.value;' ",'--- PILIH KEGIATAN ---').
				InputTypeHidden("kegiatan","");
		}
		
				
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function cariDokumenKontrak_After_InsRekBelanja($dt){
		global $DataPengaturan, $DataPemasukan, $HTTP_COOKIE_VARS;
		$uid = $HTTP_COOKIE_VARS['coID'];
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$cek="";
		$t_penerimaan_rek = $DataPemasukan->TblName_rek;
		$Idplh = cekPOST2($this->Prefix."_idplh");
		if($dt["Id"] != $Idplh){
			$where = "WHERE refid_terima='$Idplh' ";
			$data = array(array("status","2"));
			//UPDATE
			$qryUpd_det = $DataPengaturan->QryUpdData($DataPemasukan->TblName_det,$data, $where);
			$qryUpd_rek = $DataPengaturan->QryUpdData($t_penerimaan_rek,$data, $where);
			
			$qry_rek = QueryTmplBrs2($t_penerimaan_rek,"*","WHERE refid_terima='".$dt["Id"]."' AND sttemp='0' ");$cek.=$qry_rek;
			$aqry_rek = mysql_query($qry_rek);
			while($dt_rek = mysql_fetch_assoc($aqry_rek)){
				$data_ins = 
					array(
						array("k",$dt_rek["k"]),array("l",$dt_rek["l"]),array("m",$dt_rek["m"]),
						array("n",$dt_rek["n"]),array("o",$dt_rek["o"]),
						array("jumlah",0),
						array("refid_terima",$Idplh),
						array("status",0),array("uid",$uid),array("sttemp",1),array("tahun",$coThnAnggaran),
					);
				$qryIns_rek = $DataPengaturan->QryInsData($t_penerimaan_rek, $data_ins);
			}
			
		}
		
		return $cek;
	}
	
	function Get_jmlBarangRealisasi_DPA(){
		global $DataPengaturan, $DataPemasukan;
		$cek="";$err="";$content="";
		$refid_dpa_brg = cekPOST2("refid_dpa_brg");
		if($err=="" && $refid_dpa_brg == "")$err="Barang Dari DPA Belum di Pilih !";
		if($err == ""){
			$qry = $DataPengaturan->QyrTmpl1Brs($DataPemasukan->TblName_det,"IFNULL(SUM(jml),0) as jml_tot", "WHERE refid_dpa='$refid_dpa_brg' AND sttemp='0' ");
			$dt = $qry["hasil"];
			$content = LabelSPan1("rls","REALISASI : ",'style="font-size:11px;color:red;font-weight:bold;float:top;"').InputTypeText("jml_RealisasiDPA",FormatAngka($dt["jml_tot"])," readonly style='width:40;text-align:right;'" );
		}
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function ValidasiTermin($msg="Hapus", $dari="Barang"){		
		global $DataPengaturan, $DataPemasukan;
		$cek = '';$err = '';$content = '';
				
		$tbl = $DataPemasukan->TblName_N;
		$tbl_det = $DataPemasukan->TblName_det;
		
		$Idplh = cekPOST2($this->Prefix."_idplh");
		$nomdok=cekPOST2("nomdok");
		$tgl_dok=cekPOST2("tgl_dok");
		$cara_bayar=cekPOST2("cara_bayar");
		$jns_transaksi=cekPOST2("jns_transaksi");
		
		if($jns_transaksi == "1" && $cara_bayar == "2"){
			//cek Apakah Ada Data Lain Dengan Kontrak Yang Sama
			$qry = $DataPengaturan->QryHitungData($tbl, "WHERE nomor_kontrak='$nomdok' AND tgl_kontrak='$tgl_dok' AND Id!='$Idplh' AND sttemp='0' AND jns_trans='1' AND cara_bayar='2' ");
			if($qry["hasil"] > 0){
				if($msg == "2"){
					$err = "Tidak Bisa Menambah Rekening !";
				}else{
					$err = "$dari Ini Tidak Bisa di $msg !";
				}				
			}
		}	
			
		//return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
		return $err;	
	}
	
	/*function a(){		
		global $DataPengaturan;
		$cek = '';$err = '';$content = '';
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}*/
}
$pemasukan_ins = new pemasukan_insObj();
?>