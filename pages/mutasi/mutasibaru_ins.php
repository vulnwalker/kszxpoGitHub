<?php

class MutasiBaru_insObj extends DaftarObj2{
	var $Prefix = 'MutasiBaru_ins';
	var $SHOW_CEK = TRUE;	
	var $TblName = 'bast_mutasi';//view2_sensus';
	var $TblName_Hapus = 'bast_mutasi';
	var $TblName_Edit = 'bast_mutasi';
	var $KeyFields = array('no_ba,c1,c,d,e,e1');
	var $FieldSum = array('nilai_buku','nilai_susut');
	var $SumValue = array('nilai_buku','nilai_susut');
	var $FieldSum_Cp1 = array( 9, 8, 8);
	var $FieldSum_Cp2 = array( 3, 3, 3);	
	var $FormName = 'MutasiBaru_insForm';
	var $pagePerHal = 25;
	
	var $PageTitle = 'MUTASI';
	var $PageIcon = 'images/penatausahaan_ico.gif';
	var $ico_width = '20';
	var $ico_height = '30';
	
	var $fileNameExcel='Daftar MUTASI.xls';
	var $Cetak_Judul = 'MUTASI ';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $fmST = 0;
	var $idpilih = '';
	//var $row_params= " valign='top'";
	
	
	function setTitle(){
		global $Main;
		return 'MUTASI SKPD';	

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
	
	function HapusBAST(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 
	 $c1 = $_REQUEST['urusan_lama'];
	 $c = $_REQUEST['skpd_lama'];
	 $d = $_REQUEST['unit_lama'];
	 $e = $_REQUEST['subunit_lama'];
	 $e1 = $_REQUEST['seksi_lama'];
	 $no_ba= $_REQUEST['no_bast'];
	 //$gen_tgl = $_REQUEST['tgl_ba'].'-'.$_REQUEST['thn_ba'];
	 $gen_tgl = $_REQUEST['tgl_ba'];
	 $tgl_ba = date('Y-m-d', strtotime($gen_tgl));
	 $gethps ="SELECT count(nosk)as cnt FROM penghapusan where nosk='$no_ba' and concat(c1,c,d)='".$c1.$c.$d."' and mutasi=1";
	 $cek.=$gethps;
	 $row = table_get_rec($gethps);
	 if($row['cnt']>0)$err.='NOMOR BAST TIDAK BISA DIHAPUS, SUDAH ADA TRANSAKSI MUTASI SEBELUMNYA !';
			
	 
	 
		if($err==''){
			$aqry = " DELETE FROM $this->TblName WHERE concat(c1,c,d,no_ba)='".$c1.$c.$d.$no_ba."' ";	$cek .= $aqry;	
			$qry = mysql_query($aqry);
		}	 
	 	if($qry){
			$qrypenyedia = "SELECT no_ba,no_ba FROM $this->TblName where c1='$c1' and c='$c' and d='$d'";
			$content->bast = cmbQuery('no_bast','',$qrypenyedia," style='width:303px;' ","--- NOMOR BAST ---","");
		}
			 
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function SimpanBAST(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 
	 $c1 = $_REQUEST['c1'];
	 $c = $_REQUEST['c'];
	 $d = $_REQUEST['d'];
	 $e = $_REQUEST['e'];
	 $e1 = $_REQUEST['e1'];
	 $no_ba= $_REQUEST['no_ba'];
	 $gen_tgl = $_REQUEST['tgl_ba'].'-'.$_REQUEST['thn_ba'];
	 //$gen_tgl = $_REQUEST['tgl_ba'];
	 $tgl_ba = date('Y-m-d', strtotime($gen_tgl));
	 	  
	 if( $err=='' && $no_ba =='' ) $err= 'Nomor BAST Belum Di Isi !!';
	 if( $err=='' && $tgl_ba =='' ) $err= 'Tanggal BAST Belum Di Isi !!';
	 
	 if( $err=='' && $fmST == 0){
	 	$oldba = table_get_rec("SELECT no_ba,tgl_ba FROM $this->TblName where no_ba='$no_ba' and concat(c1,c,d)='".$c1.$c.$d."'");
		if($oldba['no_ba']==$no_ba)$err.='NOMOR BAST SUDAH ADA !';
		//$cek.="noba=SELECT no_ba FROM $this->TblName where no_ba='$no_ba' and concat(c1,c,d,e,e1)='".$c1.$c.$d.$e.$e1."'";
		if($err==''){
			$aqry = "INSERT into $this->TblName(no_ba,tgl_ba,c1,c,d)".
			"values('$no_ba','$tgl_ba','$c1','$c','$d')";	$cek .= $aqry;	
			$qry = mysql_query($aqry);		
			
		}
	 }elseif($fmST == 1){
	 	$oldba = table_get_rec("SELECT no_ba,tgl_ba FROM $this->TblName where concat(c1,c,d)='".$c1.$c.$d."' and no_ba='$no_ba'");
		if($oldba['no_ba']!=$no_ba){
			$gethps ="SELECT count(nosk)as cnt FROM penghapusan where nosk='".$oldba['no_ba']."' and concat(c1,c,d)='".$c1.$c.$d."' and mutasi=1";
			$cek.=$gethps;
			$row = table_get_rec($gethps);
			if($row['cnt']>0)$err.='NOMOR BAST TIDAK BISA DIEDIT, SUDAH ADA TRANSAKSI MUTASI SEBELUMNYA !';
		}		
	 	if($err==''){
			$aqry = "UPDATE $this->TblName set ".
					"no_ba='$no_ba', ".
					"tgl_ba='$tgl_ba' ".
					"where c1='$c1' and c='$c' and d='$d'";
			$cek .= $aqry;	
			$qry = mysql_query($aqry) ;//or die(mysql_error());
		}
	 } //end else
	 	if($qry){
			$qrypenyedia = "SELECT no_ba,no_ba FROM $this->TblName where c1='$c1' and c='$c' and d='$d'";
			$content->bast = cmbQuery('no_bast',$no_ba,$qrypenyedia," style='width:303px;' ","--- NOMOR BAST ---","");
			$content->tgl_bast2 = TglInd($tgl_ba);
		}
			 
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
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
	 $idubah = $_REQUEST['idubah'];
	 $cbid = $_REQUEST['cidBI'];
	 $c1= $_REQUEST['fmSKPDUrusan'];
	 $c2= $_REQUEST['fmSKPDBidang2'];
	 $d2= $_REQUEST['fmSKPDskpd2'];
	 $e2= $_REQUEST['fmSKPDUnit2'];
	 $e12= $_REQUEST['fmSKPDSubUnit2'];
	 $idubah= $_REQUEST['idubah'];
	 $idplh = str_replace(" ",",",$idubah);
	 $gen_tgl = $_REQUEST['tgl_buku'].'-'.$_REQUEST['thn_buku'];	 
	 $tgl_buku = date('Y-m-d', strtotime($gen_tgl));
	 $no_ba= $_REQUEST['no_bast'];
	 //$tgl_ba= $_REQUEST['tgl_bast'];
	 $tgl_ba= date('Y-m-d', strtotime($_REQUEST['tgl_bast2']));
	 $tgl_closing=getTglClosing($c2,$d2,$e2,$e12,$c1);
	 if( $err=='' && $c1 =='00' ) $err= 'URUSAN Belum Di Pilih !!';
	 if( $err=='' && $c2 =='00' ) $err= 'BIDANG Belum Di Pilih !!';
	 if( $err=='' && $d2 =='00' ) $err= 'SKPD Belum Di Pilih !!';
	 if( $err=='' && $e2 =='00' ) $err= 'UNIT Belum Di Pilih !!';
	 if( $err=='' && $e12 =='000' ) $err= 'SUB UNIT Belum Di Pilih !!';
	 if( $err=='' && $no_ba =='' ) $err= 'Nomor BAST Belum Di Pilih !!';
	 if( $err=='' && $_REQUEST['tgl_buku'] =='' ) $err= 'TANGGAL BUKU Belum Di Isi !!';
	 if ($err=='' && !cektanggal($tgl_buku)) $err = 'TANGGAL BUKU salah!';
	 if( $err=='' && $tgl_buku<=$tgl_closing)$err ='TANGGAL BUKU harus lebih besar dari Tanggal Closing !';
	 	
	if ($err =='' && compareTanggal($tgl_buku, date('Y-m-d'))==2  ) $err = 'TANGGAL BUKU tidak lebih besar dari Hari ini!';				
	
	$idarr = explode(" ",$idubah);
	//$err='arr='.$idarr[0];
	//$resultbi = mysql_query($getbi);
	for($i=0;$i<count($idarr);$i++){
		$getbi = "select c1,c,d,e,e1,tgl_buku from buku_induk where id='".$idarr[$i]."' ";
		$bi = table_get_rec("select * from buku_induk where id='".$idarr[$i]."'");
	 	$fmTglBuku = $bi['tgl_buku'];
		if ($err=='' &&  compareTanggal($tgl_buku, $fmTglBuku)==0 ){ $err = 'TANGGAL BUKU dengan Id '.$bi['id'].' tidak lebih kecil dari Tanggal Buku Barang!'; }		
		//cek tgl BA
		if($err==''){
			if($bi['tgl_ba'] == '') $err = 'Tanggal Berita Acara Perolehan Barang belum diisi! Isi di Penatausahaan - Edit';
		}
		if($err == ''){
			$ceksusut = mysql_fetch_array(mysql_query("select tgl as tgl_penyusutan from penyusutan where idbi='".$idarr[$i]."' order by Id desc limit 0,1"));
			if($tgl_buku <= $ceksusut['tgl_penyusutan']) $err = 'Gagal penghapusan, sudah penyusutan !';
		}
		$hps = table_get_rec("select count(*)as cnt from penghapusan where mutasi=1 and idbi_awal='".$idarr[$i]."'");
		if ($hps['cnt'] > 1) $err = 'Barang sudah di Penghapusan!';
		//if ($bi['status_barang'] == 4) $errmsg = 'Barang sudah di Pemindahtanganan!';
		if ($bi['status_barang'] == 5) $errmsg = 'Barang sudah di Tuntutan Ganti Rugi!';
		//if ($bi['thn_perolehan'] < 1945 ) $errmsg = 'Tahun Perolehan tidak lebih kecil dari 1945!';
		$transaksi = mysql_fetch_array(mysql_query("select max(tgl_buku) as maxtgl from t_transaksi where idbi = '".$idarr[$i]."'"));
		if ($err=='' && (compareTanggal( $tgl_buku , $transaksi['maxtgl']  )==0) ) $err = 'TANGGAL BUKU harus lebih besar dari Tanggal Transaksi!';
			
	}	
		if($err==''){
			$limit=2;
			$getcnt = "select * from buku_induk where id in ($idplh) and idawal not in(select idbi_awal from penghapusan where idbi_awal in($idplh) )limit 0,$limit";			
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
					$idall = $old['idall'];
					$c1_awal = $old['c1'];
					$f1_awal = $old['f1'];
					$f2_awal = $old['f2'];
					$jml_barang = $old['jml_barang'];
					$satuan = $old['satuan'];
					$harga = $old['harga'];
					$jml_harga = $old['jml_harga'];
					$status_barang = $old['status_barang'];
					$stusul = $old['stusul'];
					$tgl_update = $old['tgl_update'];
					$tahun = $old['tahun'];
					$gambar = $old['gambar'];
					$dokumen = $old['dokumen'];
					$dokumen_ket = $old['dokumen_ket'];
					$dokumen_file = $old['dokumen_file'];
					$nilai_appraisal = $old['nilai_appraisal'];
					$uid_lama = $old['uid'];
					$tgl_sensus = $old['tgl_sensus'];
					$jml_barang_tmp = $old['jml_barang_tmp'];
					$jml_gambar = $old['jml_gambar'];
					$idall2 = $old['idall2'];
					$ref_idpemegang = $old['ref_idpemegang'];
					$ref_idpenanggung = $old['ref_idpenanggung'];
					$ref_idruang = $old['ref_idruang'];
					$tahun_sensus = $old['tahun_sensus'];
					$ref_idpemegang2 = $old['ref_idpemegang2'];
					$status_penguasaan = $old['status_penguasaan'];
					$verifikasi = $old['verifikasi'];
					$harga_beli = $old['harga_beli'];
					$harga_atribusi = $old['harga_atribusi'];
					$ref_idatribusi = $old['ref_idatribusi'];
					$masa_manfaat = $old['masa_manfaat'];
					$nilai_sisa = $old['nilai_sisa'];
					$thn_susut_aw = $old['thn_susut_aw'];
					$thn_susut_ak = $old['thn_susut_ak'];
					$bln_susut_aw = $old['bln_susut_aw'];
					$bln_susut_ak = $old['bln_susut_ak'];
					$ref_idstatussurvey = $old['ref_idstatussurvey'];
					$stmigrasi = $old['stmigrasi'];
					$thn_akun = $old['thn_akun'];
					$penggunaan = $old['penggunaan'];
					$no_spk = $old['no_spk'];
					$tgl_spk = $old['tgl_spk'];
					$jns_ekstra = $old['jns_ekstra'];
					$jns_lain = $old['jns_lain'];
					$masa_manfaat_tot = $old['masa_manfaat_tot'];
					$asal_usul_awal = $old['asal_usul_awal'];
					$stop_susut = $old['stop_susut'];
					$jns_hibah = $old['jns_hibah'];
					$no_barang = $old['no_barang'];
					$kampung = $old['kampung'];
					$rt = $old['rt'];
					$rw = $old['rw'];
					$bk = $old['bk'];
					$ck = $old['ck'];
					$bk_p = $old['bk_p'];
					$ck_p = $old['ck_p'];
					$dk_p = $old['dk_p'];
					$p = $old['p'];
					$q = $old['q'];
					$nmprogram = $old['nmprogram'];
					$nmkegiatan = $old['nmkegiatan'];
					
				//validasi duplicate data bi
				$cnt= table_get_rec("select count(*)as cnt from buku_induk where c1= $c1 and c=$c2 and d=$d2 and e=$e2 and e1=$e12 
				and f='$f_awal' and g='$g_awal' and h='$h_awal' and i='$i_awal' and j='$j_awal' and thn_perolehan=$thn_perolehan and noreg='$noreg'");
				//if($cnt['cnt']>0)$err="Id Barang $idbi Duplikasi data !";
				//if($cnt['cnt']==0){					
					//NO REG BARU
					$get_noreg = table_get_rec("select max(ifnull(noreg,0)) as noreg_baru from buku_induk where c1= $c1 and c=$c2 and d=$d2 and e=$e2 and e1=$e12 
    				and f='$f_awal' and g='$g_awal' and h='$h_awal' and i='$i_awal' and j='$j_awal' and thn_perolehan=$thn_perolehan and id<>'".$idbi."' ");
					$noreg_baru = sprintf("%04s",$get_noreg['noreg_baru']+1);
					//---------------------------------------------
					if($err==''){
						//insert/salin ke buku induk
						$ins_bi = "INSERT buku_induk (a1,a,b,c1,c,d,e,e1,f1,f2,f,g,h,i,j,".
						"noreg,thn_perolehan,jml_barang,satuan,harga,jml_harga,asal_usul,kondisi,status_barang,staset,tgl_buku,".
						"id_lama,idawal,stusul,tgl_update,tahun,gambar,dokumen,dokumen_ket,dokumen_file,nilai_appraisal,".
						"uid,tgl_sensus,jml_barang_tmp,jml_gambar,idall2,ref_idpemegang,ref_idpenanggung,ref_idruang,tahun_sensus,".
						"ref_idpemegang2,status_penguasaan,verifikasi,harga_beli,harga_atribusi,ref_idatribusi,masa_manfaat,nilai_sisa,".
						"thn_susut_aw,thn_susut_ak,bln_susut_aw,bln_susut_ak,ref_idstatussurvey,stmigrasi,ka,kb,kc,kd,ke,kf,no_ba,tgl_ba,".
						"thn_akun,penggunaan,no_spk,tgl_spk,jns_ekstra,jns_lain,masa_manfaat_tot,tgl_create,uid_create,asal_usul_awal,stop_susut,".
						"jns_hibah,no_barang,kampung,rt,rw,bk,ck,dk,bk_p,ck_p,dk_p,p,q,nmprogram,nmkegiatan,".
						"nilai_buku,nilai_susut) ".
						"values('$a1_awal','$a_awal','$b_awal','$c1','$c2','$d2','$e2','$e12','$f1_awal','$f2_awal','$f_awal','$g_awal','$h_awal','$i_awal','$j_awal',".
						"'$noreg_baru','$thn_perolehan','$jml_barang','$satuan','$harga','$jml_harga',4,'$kondisi',1,'$staset','$tgl_buku',".
						"'$idbi','$idbiawal','$stusul','$tgl_update','$tahun','$gambar','$dokumen','$dokumen_ket','$dokumen_file','$nilai_appraisal',".
						"'$uid_lama','$tgl_sensus','$jml_barang_tmp','$jml_gambar','$idall2','$ref_idpemegang','$ref_idpenanggung','$ref_idruang','$tahun_sensus',".
						"'$ref_idpemegang2','$status_penguasaan','$verifikasi','$harga_beli','$harga_atribusi','$ref_idatribusi','$masa_manfaat','$nilai_sisa',".
						"'$thn_susut_aw','$thn_susut_ak','$bln_susut_aw','$bln_susut_ak','$ref_idstatussurvey','$stmigrasi','$ka','$kb','$kc','$kd','$ke','$kf','$no_ba','$tgl_ba',".
						"'$thn_akun','$penggunaan','$no_spk','$tgl_spk','$jns_ekstra','$jns_lain','$masa_manfaat_tot',NOW(),'$uid','$asal_usul_awal','$stop_susut',".
						"'$jns_hibah','$no_barang','$kampung','$rt','$rw','$bk','$ck','$dk','$bk_p','$ck_p','$dk_p','$p','$q','$nmprogram','$nmkegiatan',".
						"'$nilai_buku','$nilai_susut')";
						$qry_bi = mysql_query($ins_bi);
						if($qry_bi==FALSE)$err="Gagal Simpan bi ".mysql_error();
						$newid = mysql_insert_id();						
					}					
					
					if($err==''){
						switch($f_awal){
							case '01':{
								$qry_kib = "select * from kib_a where idbi='".$idbi."'";//GET KIB LAMA
								$row = table_get_rec($qry_kib);
								$luas 		= $row['luas'];
								$alamat 	= $row['alamat'];
								$alamat_kel = $row['alamat_kel'];
								$alamat_kec = $row['alamat_kec'];
								$alamat_a	= $row['alamat_a'];
								$alamat_b	= $row['alamat_b'];
								$koordinat_gps 	= $row['koordinat_gps'];
								$koord_bidang 	= $row['koord_bidang'];	
								$status_hak 	= $row['status_hak'];
								$bersertifikat = $row['bersertifikat'];
								$sertifikat_tgl= $row['sertifikat_tgl'];
								$sertifikat_no = $row['sertifikat_no'];	
								$penggunaan 	= $row['penggunaan'];							
								$ket 		= $row['ket'];
								$qrykib =
										" insert into kib_a ".
										" (a1,a,b,c1,c,d,e,e1,".
										" f,g,h,i,j,noreg,tahun,".
										" luas,alamat,alamat_a,alamat_b,alamat_kel,alamat_kec,".
										" koordinat_gps,koord_bidang,status_hak,".
										" bersertifikat,sertifikat_tgl,sertifikat_no,".
										" penggunaan,ket,idbi)".
										" values('$a1_awal','$a_awal','$b_awal','$c1','$c2','$d2','$e2','$e12',".
										"'$f_awal','$g_awal','$h_awal','$i_awal','$j_awal','$noreg_baru','$thn_perolehan','".	
										$luas."','".$alamat."','".$alamat_a."','".$alamat_b."','".$alamat_kel."','".$alamat_kec."','".
										$koordinat_gps."','".$koord_bidang."','".$status_hak."','".
										$bersertifikat."','".$sertifikat_tgl."','".$sertifikat_no."','".
										$penggunaan."','".$ket."',".$newid.
										" )"
									;
								$kib = mysql_query($qrykib);
								break;
							}
							case '02':{
								$qry_kib = "select * from kib_b where idbi='".$idbi."'";
								$row = table_get_rec($qry_kib);
								$merk 			= $row['merk'];
								$ukuran 		= $row['ukuran'];
								$bahan 			= $row['bahan'];
								$no_pabrik 		= $row['no_pabrik'];
								$no_rangka 		= $row['no_rangka'];
								$no_mesin 		= $row['no_mesin'];
								$no_polisi 		= $row['no_polisi'];
								$no_bpkb 		= $row['no_bpkb'];															
								$ket 		= $row['ket'];
								$qrykib = 
									" insert into kib_b ".
									" (a1,a,b,c1,c,d,e,e1,".
									" f,g,h,i,j,noreg,tahun,".
									
									"merk,ukuran,bahan,".
									"no_pabrik,no_rangka,no_mesin,".
									"no_polisi,no_bpkb,ket,idbi".
									
									") values('$a1_awal','$a_awal','$b_awal','$c1','$c2','$d2','$e2','$e12',".
									"'$f_awal','$g_awal','$h_awal','$i_awal','$j_awal','$noreg_baru','$thn_perolehan','".	
									$merk."','".$ukuran."','".$bahan."','".
									$no_pabrik."','".$no_rangka."','".$no_mesin."','".
									$no_polisi."','".$no_bpkb."','".
									$ket."',".$newid.
									" )"
								;
								$kib = mysql_query($qrykib);
								break;								
							}
							case '03':{
								$qry_kib = "select * from kib_c where idbi='".$idbi."'";
								$row = table_get_rec($qry_kib);
								$kondisi_bangunan=$row['kondisi_bangunan'];
								$konstruksi_tingkat	= $row['konstruksi_tingkat'];
								$konstruksi_beton=$row['konstruksi_beton'];
								$luas_lantai 	= $row['luas_lantai'];
								$alamat 	= $row['alamat'];
								$alamat_kel = $row['alamat_kel'];
								$alamat_kec = $row['alamat_kec'];
								$alamat_a	= $row['alamat_a'];
								$alamat_b	= $row['alamat_b'];
								$koordinat_gps 	= $row['koordinat_gps'];
								$koord_bidang 	= $row['koord_bidang'];	
								$dokumen_tgl	=$row['dokumen_tgl'];
								$dokumen_no		=$row['dokumen_no'];
								$luas 		= $row['luas'];
								$status_tanah = $row['status_tanah'];
								$kode_tanah		=$row['kode_tanah'];														
								$ket 		= $row['ket'];
								$qrykib = 
									" insert into kib_c ".
									" (a1,a,b,c1,c,d,e,e1,".
									" f,g,h,i,j,noreg,tahun,".
									" kondisi_bangunan, konstruksi_tingkat, ".
									" konstruksi_beton,luas_lantai,alamat,alamat_a,alamat_b,".
									" alamat_kel,alamat_kec,koordinat_gps,koord_bidang,".
									" dokumen_tgl,dokumen_no, luas, status_tanah, ".
									" kode_tanah,".
									" ket,idbi".
									") values('$a1_awal','$a_awal','$b_awal','$c1','$c2','$d2','$e2','$e12',".
									"'$f_awal','$g_awal','$h_awal','$i_awal','$j_awal','$noreg_baru','$thn_perolehan','".	
									$kondisi_bangunan."','".$konstruksi_tingkat."','".
									$konstruksi_beton."','".$luas_lantai."','".$alamat."','".$alamat_a."','".$alamat_b."','".
									$alamat_kel."','".$alamat_kec."','".$koordinat_gps."','".$koord_bidang."','".
									$dokumen_tgl."','".$dokumen_no."','".$luas."','".$status_tanah."','".
									$kode_tanah."','".
									$ket."',".$newid.
									" )"
								;
								$kib = mysql_query($qrykib);
								break;
							}
							case '04':{
								$qry_kib = "select * from kib_d where idbi='".$idbi."'";
								$row = table_get_rec($qry_kib);
								$konstruksi	= $row['konstruksi'];
								$panjang	= $row['panjang'];
								$lebar		= $row['lebar'];
								$luas 		= $row['luas'];								
								$alamat 	= $row['alamat'];
								$alamat_kel = $row['alamat_kel'];
								$alamat_kec = $row['alamat_kec'];
								$alamat_a	= $row['alamat_a'];
								$alamat_b	= $row['alamat_b'];								
								$koordinat_gps 	= $row['koordinat_gps'];
								$koord_bidang 	= $row['koord_bidang'];
								$dokumen_tgl	=$row['dokumen_tgl'];
								$dokumen_no		=$row['dokumen_no'];	
								$status_tanah = $row['status_tanah'];
								$kode_tanah		=$row['kode_tanah'];														
								$ket 		= $row['ket'];
								$qrykib = 
									" insert into kib_d ".
									" (a1,a,b,c1,c,d,e,e1,".
									" f,g,h,i,j,noreg,tahun,".
									" konstruksi,panjang,lebar,luas,".
									" alamat,alamat_a,alamat_b,alamat_kel,alamat_kec,".
									" koordinat_gps,koord_bidang,dokumen_tgl,dokumen_no,".
									" status_tanah,kode_tanah, ".
									" ket,idbi".
									") values('$a1_awal','$a_awal','$b_awal','$c1','$c2','$d2','$e2','$e12',".
									"'$f_awal','$g_awal','$h_awal','$i_awal','$j_awal','$noreg_baru','$thn_perolehan','".	
									$konstruksi."','".$panjang."','".$lebar."','".$luas."','".
									$alamat."','".$alamat_a."','".$alamat_b."','".$alamat_kel."','".$alamat_kec."','".
									$koordinat_gps."','".$koord_bidang."','".$dokumen_tgl."','".$dokumen_no."','".
									$status_tanah."','".$kode_tanah."','".
									$ket."',".$newid.
									" )"
								;
								$kib = mysql_query($qrykib);
								break;
							}
							case '05':{
								$qry_kib = "select * from kib_e where idbi='$idbi'";
								$row = table_get_rec($qry_kib);
								$buku_judul 	= $row['buku_judul'];
								$buku_spesifikasi = $row['buku_spesifikasi'];								
								$seni_asal_daerah = $row['seni_asal_daerah'];
								$seni_pencipta 	= $row['seni_pencipta'];
								$seni_bahan 	= $row['seni_bahan'];
								$hewan_jenis 	= $row['hewan_jenis'];
								$hewan_ukuran 	= $row['hewan_ukuran'];																					
								$ket 		= $row['ket'];
								$qrykib = 
									" insert into kib_e ".
									" (a1,a,b,c1,c,d,e,e1,".
									" f,g,h,i,j,noreg,tahun,".						
									" buku_judul,buku_spesifikasi,seni_asal_daerah, ".
									" seni_pencipta,seni_bahan,hewan_jenis,hewan_ukuran, ".						
									" ket,idbi".
									") values('$a1_awal','$a_awal','$b_awal','$c1','$c2','$d2','$e2','$e12',".
									"'$f_awal','$g_awal','$h_awal','$i_awal','$j_awal','$noreg_baru','$thn_perolehan','".	
									$buku_judul."','".$buku_spesifikasi."','".$seni_asal_daerah."','".
									$seni_pencipta."','".$seni_bahan."','".$hewan_jenis."','".$hewan_ukuran."','".
									$ket."',".$newid.
									" )"
								;
								$kib = mysql_query($qrykib);
								break;
							}
							case '06':{
								$qry_kib = "select * from kib_f where idbi='$idbi'";
								$row = table_get_rec($qry_kib);
								$bangunan	= $row['bangunan'];
								$konstruksi_tingkat	= $row['konstruksi_tingkat'];
								$konstruksi_beton	= $row['konstruksi_beton'];
								$luas 		= $row['luas'];		
								$alamat 	= $row['alamat'];
								$alamat_kel = $row['alamat_kel'];
								$alamat_kec = $row['alamat_kec'];
								$alamat_a	= $row['alamat_a'];
								$alamat_b	= $row['alamat_b'];								
								$koordinat_gps 	= $row['koordinat_gps'];
								$koord_bidang 	= $row['koord_bidang'];
								$dokumen_tgl	=$row['dokumen_tgl'];
								$dokumen_no		=$row['dokumen_no'];	
								$tmt		=$row['tmt'];	
								$status_tanah = $row['status_tanah'];
								$kode_tanah		=$row['kode_tanah'];														
								$ket 		= $row['ket'];
								$qrykib = 
									" insert into kib_f ".
									" (a1,a,b,c1,c,d,e,e1,".
									" f,g,h,i,j,noreg,tahun,".
									"bangunan,konstruksi_tingkat,konstruksi_beton,luas,".
									
									"alamat,alamat_a,alamat_b,alamat_kel,alamat_kec,".
									"koordinat_gps,koord_bidang,dokumen_tgl,dokumen_no,".
									"tmt,".
									"status_tanah,kode_tanah,".
									
									" ket,idbi".
									") values('$a1_awal','$a_awal','$b_awal','$c1','$c2','$d2','$e2','$e12',".
									"'$f_awal','$g_awal','$h_awal','$i_awal','$j_awal','$noreg_baru','$thn_perolehan','".	
									$bangunan."','".$konstruksi_tingkat."','".$konstruksi_beton."','".$luas."','".
									
									$alamat."','".$alamat_a."','".$alamat_b."','".$alamat_kel."','".$alamat_kec."','".
									$koordinat_gps."','".$koord_bidang."','".$dokumen_tgl."','".$dokumen_no."','".
									$tmt."','".
									$status_tanah."','".$kode_tanah."','".
									$ket."',".$newid.
									" )"
								;
								$kib = mysql_query($qrykib);
								break;
							}
							case '07':{
								$qry_kib = "select * from kib_g where idbi='$idbi'";
								$row = table_get_rec($qry_kib);
								$uraian			= $row['uraian'];
								$software_nama	= $row['software_nama'];
								$kajian_nama	= $row['kajian_nama'];
								$kerjasama_nama	= $row['kerjasama_nama'];
								$pencipta		= $row['pencipta'];
								$jenis			= $row['jenis'];
								$ket			= $row['ket'];
								$qrykib = 
									" insert into kib_g ".
									" (a1,a,b,c1,c,d,e,e1,".
									" f,g,h,i,j,noreg,tahun,".
									"uraian,software_nama,kajian_nama,kerjasama_nama,ket,idbi,pencipta,jenis".
									
									") values('$a1_awal','$a_awal','$b_awal','$c1','$c2','$d2','$e2','$e12',".
									"'$f_awal','$g_awal','$h_awal','$i_awal','$j_awal','$noreg_baru','$thn_perolehan','".	
									$uraian."','".$software_nama."','".$kajian_nama."','".$kerjasama_nama."','".$ket."','".$newid."','".$pencipta."','".$jenis.
									"' )"
								;
								$kib = mysql_query($qrykib);
								break;
								
							}
								if($kib==FALSE)$err="Gagal Simpan kib ".mysql_error();
						}	
					}	
						if($err==''){			
							//update buku induk set status barang lama =3
							$upd_bi = "UPDATE buku_induk set status_barang=3 WHERE id='$idbi'";
							$qryupdbi = mysql_query($upd_bi);
							if($qryupdbi==FALSE)$err="Gagal Simpan data ".mysql_error();
						}
								
						if($err==''){
							//insert penghapusan
							$query_hps= "INSERT penghapusan (tgl_penghapusan,mutasi,sudahmutasi,nosk,tglsk,".
							"idbi_awal,id_bukuinduk,staset,a1,a,b,c1,c,d,e,e1,".
							"f,g,h,i,j,kondisi_akhir,noreg,thn_perolehan,".
							"nilai_buku,nilai_susut,tgl_create,uid_create) values ('$tgl_buku',1,1,'$no_ba','$tgl_ba',".
							"'$idbiawal','$idbi','$staset','$a1_awal','$a_awal','$b_awal','$c1_awal','$c_awal','$d_awal','$e_awal','$e1_awal',".
							"'$f_awal','$g_awal','$h_awal','$i_awal','$j_awal','$kondisi','$noreg','$thn_perolehan',".
							"'$nilai_buku','$nilai_susut',NOW(),'$uid')";
							$qry_hps = mysql_query($query_hps);							
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
			$c1 = $_REQUEST['urusan_lama'];
			$c = $_REQUEST['skpd_lama'];
			$d = $_REQUEST['unit_lama'];
			$e = $_REQUEST['subunit_lama'];
			$e1 = $_REQUEST['seksi_lama'];
			
			$cekid = explode(" ",$_REQUEST['idubah']);
			$jmlcek = count($cekid);			
			$uid = $HTTP_COOKIE_VARS['coID'];			
			$tgl_buku = date('d-m');	
		}else{			
			$IDUBAH = $_REQUEST['idubah'];
			$tgl_buku = date($thn_login.'-m-d');	
		}
	}
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
	
	$qry_bast = "SELECT no_ba,no_ba FROM $this->TblName where c1='$c1' and c='$c' and d='$d'";	
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
					"<span id='inputpenerimaanbarang' style='color:black;font-size:14px;font-weight:bold;'/>PILIH SKPD BARU</span>",
					
				
				),'','','').
			genFilterBar(
				array(
					$this->isiform(
						array(
							array(
								'label'=>'URUSAN',
								'name'=>'fmSKPDUrusan',
								'label-width'=>'200px;',
								'value'=>$this->cmbQueryUrusan('fmSKPDUrusan',$fmSKPDUrusan,'','onchange=MutasiBaru_ins.UrusanAfter() '.$disabled1,'--- Pilih URUSAN ---','00',TRUE),
								
							),
							array(
								'label'=>'BIDANG',
								'name'=>'fmSKPDBidang2',
								'label-width'=>'200px;',
								'value'=>$this->cmbQueryBidang('fmSKPDBidang2',$fmSKPDBidang2,'','onchange=MutasiBaru_ins.BidangAfter2() '.$disabled1,'--- Pilih BIDANG ---','00'),
								
							),
							array(
								'label'=>'SKPD',
								'name'=>'fmSKPDskpd2',
								'label-width'=>'200px;',
								'value'=>$this->cmbQuerySKPD('fmSKPDskpd2',$fmSKPDskpd2,'','onchange=MutasiBaru_ins.SKPDAfter2() '.$disabled1,'--- Pilih SKPD ---','00'),
								
							),
							array(
								'label'=>'UNIT',
								'name'=>'fmSKPDUnit2',
								'label-width'=>'200px;',
								'value'=>$this->cmbQueryUnit('fmSKPDUnit2',$fmSKPDUnit2,'','onchange=MutasiBaru_ins.UnitAfter2() '.$disabled1,'--- Pilih UNIT ---','00'),
								
							),
							array(
								'label'=>'SUB UNIT',
								'name'=>'fmSKPDSubUnit2',
								'label-width'=>'200px',
								'value'=>$this->cmbQuerySubUnit('fmSKPDSubUnit2',$fmSKPDSubUnit2,'',''.$disabled1,'--- Pilih SUB UNIT ---','000'),
								
							),
						)
					)
				
				),'','','').
				genFilterBar(
				array(
					"<span id='inputpenerimaanbarang' style='color:black;font-size:14px;font-weight:bold;'/>PILIH NOMOR DAN TANGGAL BAST</span>",
				),'','','').
				genFilterBar(
				array(
					$this->isiform(
						array(
							array(
								'label'=>'NOMOR BAST',
								'name'=>'no_bast',
								'label-width'=>'200px;',
								'value'=>"<span id='nomber'>"
										.cmbQuery('no_bast',$no_bast,$qry_bast," style='width:200px;' onchange='MutasiBaru_ins.ambilTglBA()'","--- NOMOR BAST ---")."</span>".
								"<input type='hidden' name='tgl_bast' id='tgl_bast' value='$tgl_bast' /> ".
								"<input type='button' name='BaruBAST' id='BaruBAST' value='BARU' onclick='MutasiBaru_ins.BaruBAST()' />
								<input type='button' name='HapusBAST' id='HapusBAST' value='HAPUS' onclick='MutasiBaru_ins.HapusBAST()' />
								<!--<input type='button' name='EditBAST' id='EditBAST' value='EDIT' onclick='MutasiBaru_ins.EditBAST()' />-->"
										
								,
							),
							array(
								'label'=>'TANGGAL BAST',
								'name'=>'tgl_bast',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='tgl_bast2' id='tgl_bast2' value='' size='7' readonly>"
								//'value'=>createEntryTgl3($tgl_buku, 'tgl_buku', false,'')
										
								,
							),
							array(
								'label'=>'TANGGAL BUKU',
								'name'=>'tgl_buku',
								'label-width'=>'200px;',
								'value'=>"<input type='text' name='tgl_buku' id='tgl_buku' value='$tgl_buku' size='1' class='datepicker2'><input type='text' name='thn_buku' id='thn_buku' value='$thn_login' size='4' readonly>"
								//'value'=>createEntryTgl3($tgl_buku, 'tgl_buku', false,'')
										
								,
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
							<td>".$this->buttonnya('MutasiBaru_ins.Simpan(0)','save_f2.png','SIMPAN','SIMPAN','SIMPAN')."</td>
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
	
	function genDaftarInitial(){
		$vOpsi = $this->genDaftarOpsi();
		$fmFiltThnAnggaran=$_COOKIE['coThnAnggaran'];
		$urusan = $_COOKIE['coURUSAN'];
		$skpd = $_COOKIE['coSKPD2'];
		$unit = $_COOKIE['coUNIT2'];
		$subunit = $_COOKIE['coSUBUNIT2'];
		$seksi = $_COOKIE['coSEKSI2'];
		return			
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 		
				//"<input type='hidden' id='fmFiltThnAnggaran' name='fmFiltThnAnggaran' value='$fmFiltThnAnggaran'>".
				//"<input type='hidden' id='fmNMBARANG' name='fmNMBARANG' value='$fmNMBARANG'>".
				"<input type='hidden' id='fmSKPDUrusan' name='fmSKPDUrusan' value='$urusan'>".
				"<input type='hidden' id='fmSKPDBidang2' name='fmSKPDBidang2' value='$skpd'>".
				"<input type='hidden' id='fmSKPDskpd2' name='fmSKPDskpd2' value='$unit'>".
				"<input type='hidden' id='fmSKPDUnit2' name='fmSKPDUnit2' value='$subunit'>".
				"<input type='hidden' id='fmSKPDSubUnit2' name='fmSKPDSubUnit2' value='$seksi'>".
			"</div>".					
			"<div id=garis style='height:1;border-bottom:1px solid #E5E5E5;'></div>".
			"<div id=contain style='overflow:auto;height:$height;'>".
			//"<div id=contain style='overflow:auto;height:256;'>".
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".					
			"</div>
			</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
				"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
			"</div>";
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
		"<script type='text/javascript' src='js/mutasi/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
		$scriptload;
	}
	
	function setFormBaruBAST(){
		$dt=array();
		$cek = '';$err='';
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setFormBAST($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormEditBAST(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		$no_ba = $_REQUEST['no_bast'];	
		$c1=$_REQUEST['urusan_lama'];
		$c=$_REQUEST['skpd_lama'];
		$d=$_REQUEST['unit_lama'];		
		//get data 
		$aqry = "SELECT * FROM  $this->TblName WHERE no_ba='$no_ba' and concat(c1,c,d)='".$c1.$c.$d."'"; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setFormBAST($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormBAST($dt){	
	 global $SensusTmp, $Ref, $Main, $HTTP_COOKIE_VARS;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 400;
	 $this->form_height = 100;
	 $thn_login = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $thn_login = $HTTP_COOKIE_VARS['coThnAnggaran'];
		
	  if ($this->form_fmST==0) {
		$this->form_caption = 'NOMOR BAST BARU';
		$tgl_ba=date('d-m');
	  }else{
		$this->form_caption = 'NOMOR BAST EDIT';	
		$tgl_ba = date('d-m-Y', strtotime($dt['tgl_ba']));	
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			'no_ba' => array( 
						'label'=>'NOMOR BAST',
						'labelWidth'=>200, 
						'value'=>$dt['no_ba'], 
						'type'=>'text',
						'param'=>"style='width:270px;' placeholder='NOMOR BAST'"
						 ),/*
			'tgl_ba' => array('label'=>'TANGGAL',
							   'value'=>"<input type='text' name='tgl_ba' id='tgl_ba' value='$tgl_ba' size='1' class='datepicker'><input type='text' name='thn_ba' id='thn_ba' value='$thn_login' size='4' readonly>",  
							   'type'=>'' ,
							   'param'=> "",
							 ),	*/
			'tgl_ba' => array('label'=>'TANGGAL',
							   'value'=>"<input type='text' name='tgl_ba' id='tgl_ba' value='$tgl_ba' size='1' class='datepicker2'><input type='text' name='thn_ba' id='thn_ba' value='$thn_login' size='4'>",  
							   'type'=>'' ,
							   'param'=> "",
							 ),		
			);
		//tombol
		$this->form_menubawah =
			"<input type='hidden' name='c1' id='c1' value='".$_REQUEST['urusan_lama']."' />".
			"<input type='hidden' name='c' id='c' value='".$_REQUEST['skpd_lama']."' />".
			"<input type='hidden' name='d' id='d' value='".$_REQUEST['unit_lama']."' />".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanBAST()' title='Simpan' >&nbsp;".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
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
			case 'UrusanAfter':{
				$content['c2']= $this->cmbQueryBidang('fmSKPDBidang2',$fmSKPDBidang2,'','onchange=MutasiBaru_ins.refreshList(true)','--- Pilih BIDANG ---','00');
				$content['d2']= $this->cmbQuerySKPD('fmSKPDskpd2',$fmSKPDskpd2,'','onchange=MutasiBaru_ins.BidangAfter2()','--- Pilih SKPD ---','00');
				$content['e2']= $this->cmbQueryUnit('fmSKPDUnit2',$fmSKPDUnit2,'','onchange=MutasiBaru_ins.UnitAfter2() ','--- Pilih UNIT ---','00');
				$content['e12']= $this->cmbQuerySubUnit('fmSKPDSubUnit2',$fmSKPDSubUnit2,'','onchange=MutasiBaru_ins.refreshList(true)','--- Pilih SUB UNIT ---','000');
			break;
			}
			case 'BidangAfter2':{
				$content= $this->cmbQuerySKPD('fmSKPDskpd2',$fmSKPDskpd2,'','onchange=MutasiBaru_ins.BidangAfter2()','--- Pilih SKPD ---','00');
			break;
			}
				
			case 'SKPDAfter2':{
				//$fmSKPDBidang2 = cekPOST('fmSKPDBidang2');
				//$fmSKPDskpd2 = cekPOST('fmSKPDskpd2');
				//setcookie('cofmSKPD2',$fmSKPDBidang2);
				//setcookie('cofmUNIT2',$fmSKPDskpd2);
				$content=$this->cmbQueryUnit('fmSKPDUnit2',$fmSKPDUnit2,'','onchange=MutasiBaru_ins.UnitAfter2() ','--- Pilih UNIT ---','00');
			break;
		    }
			
			case 'UnitAfter2':{
				//$fmSKPDBidang2 = cekPOST('fmSKPDBidang2');
				//$fmSKPDskpd2 = cekPOST('fmSKPDskpd2');
				//$fmSKPDUnit2 = cekPOST('fmSKPDUnit2');
				//setcookie('cofmSKPD2',$fmSKPDBidang2);
				//setcookie('cofmUNIT2',$fmSKPDskpd2);
				$content=$this->cmbQuerySubUnit('fmSKPDSubUnit2',$fmSKPDSubUnit2,'','','--- Pilih SUB UNIT ---','000');
			break;
		    }
			case 'formBaruBAST':{				
				$fm = $this->setformBaruBAST();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
				break;
			}
			
			case 'formEditBAST':{				
				$fm = $this->setformEditBAST();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
				break;
			}
			
			case 'simpanBAST':{
				$get= $this->SimpanBAST();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }	
					
			case 'hapusBAST':{
				$get= $this->HapusBAST();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }
			
			case 'simpan':{
				$get= $this->Simpan();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }
						
			case 'hapus':{
				$cbid= $_POST[$this->Prefix.'_cb'];				
				$get= $this->Hapus($cbid);
				$err= $get['err']; 
				$cek = $get['cek'];
				$json=TRUE;	
				break;
			}
			
			case 'ambilTglBA':{				
				global $Main;
				$cek = ''; $err=''; $content=''; $json=TRUE;
				
				$noba = $_REQUEST['noba'];
				
				$query = "select * FROM $this->TblName WHERE no_ba='$noba'" ;
				$get=mysql_fetch_array(mysql_query($query));$cek.=$query;
				$content= TglInd($get['tgl_ba']);											
				break;
			}			
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function cmbQueryUrusan($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE) {
     global $Ref,$Main;
	 Global $fmSKPDUrusan;
		$fmSKPDUrusan = $_REQUEST['fmSKPDUrusan'];//cekPOST('fmSKPDUrusan');
	 $aqry = "select * from ref_skpd where c1 !='0' and  c ='00' and d='00' and e ='00' and e1 ='000'  order by c1";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDUrusan='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['c1'] ==  $value ? "selected" : "";
				if ($nmSKPDUrusan=='' ) $nmSKPDUrusan =  $value == $Hasil['c1'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[c1]}'>{$Hasil['c1']}. {$Hasil[nm_skpd]}";
    	}
	 if($value <> '' && $value <>'00') $readonly = TRUE;
     /*$Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "<input type='text' name='nmurusan' id='nmurusan' value='".$nmSKPDUrusan."' size='60' readonly> <input type='hidden' name='$name' id='$name' value='". $value."' >";*/
     $Input = "<select $param name='$name' id='$name'> $Input</select>";
	 return $Input;
	}
	
	function cmbQueryBidang($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE) {
     global $Ref,$Main;
	 Global $fmSKPDUrusan,$fmSKPDBidang2;
	 	$fmSKPDUrusan = $_REQUEST['fmSKPDUrusan'];//cekPOST('fmSKPDUrusan');
		$fmSKPDBidang2 = $_REQUEST['fmSKPDBidang2'];//cekPOST('fmSKPDBidang2');
	 $aqry = "select * from ref_skpd where 1=1 and c!= '00' and d='00' and c1='$fmSKPDUrusan' order by c";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDBidang='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['c'] ==  $value ? "selected" : "";
				if ($nmSKPDBidang=='' ) $nmSKPDBidang =  $value == $Hasil['c'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[c]}'>{$Hasil['c']}. {$Hasil[nm_skpd]}";
    	}
	 if($value <> '' && $value <>'00') $readonly = TRUE;
     /*$Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "<input type='text' name='nmbidang' id='nmbidang' value='".$nmSKPDBidang."' size='60' readonly> <input type='hidden' name='$name' id='$name' value='". $value."' >";*/
     $Input = "<select $param name='$name' id='$name'> $Input</select>";
	 return $Input;
	}
	
	function cmbQuerySKPD($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE) {
	 global $Ref,$Main;
	 Global $fmSKPDUrusan,$fmSKPDBidang2,$fmSKPDskpd2;
	 	$fmSKPDUrusan = $_REQUEST['fmSKPDUrusan'];//cekPOST('fmSKPDUrusan');
		$fmSKPDBidang2 = $_REQUEST['fmSKPDBidang2'];//cekPOST('fmSKPDBidang2');
		$fmSKPDskpd2 = $_REQUEST['fmSKPDskpd2'];//cekPOST('fmSKPDskpd2');
		//setcookie('cofmSKPD',$fmSKPDBidang);
		//setcookie('cofmUNIT',$fmSKPDskpd);
	 $aqry="select * from ref_skpd where c='$fmSKPDBidang2' and d <> '00' and e = '00' and c1='$fmSKPDUrusan' order by d";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDskpd='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['d'] ==  $value ? "selected" : "";
				if ($nmSKPDskpd=='' ) $nmSKPDskpd =  $value == $Hasil['d'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[d]}'>{$Hasil[d]}. {$Hasil[nm_skpd]}";
    	}
	 if($value <> '' && $value <>'00') $readonly = TRUE;
     /*$Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "<input type='text' name='nmskpd' id='nmskpd' value='".$nmSKPDskpd."' size='60' readonly> <input type='hidden' name='$name' id='$name' value='". $value."' >";*/
     $Input = "<select $param name='$name' id='$name'> $Input</select>";
	 return $Input;
	}
	
	function cmbQueryUnit($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE,$edit='') {
	 global $Ref,$Main,$HTTP_COOKIE_VARS;
	 Global $fmSKPDUrusan,$fmSKPDBidang2,$fmSKPDskpd2,$fmSKPDUnit2;
	 	$fmSKPDUrusan = $_REQUEST['fmSKPDUrusan'];//cekPOST('fmSKPDUrusan');
		$fmSKPDBidang2 = $_REQUEST['fmSKPDBidang2'];//cekPOST('fmSKPDBidang2');
		$fmSKPDskpd2 = $_REQUEST['fmSKPDskpd2'];//cekPOST('fmSKPDskpd2');
		$fmSKPDUnit2 = $_REQUEST['fmSKPDUnit2'];//cekPOST('fmSKPDUnit2');
		
			
	 $aqry = "select * from ref_skpd where c='$fmSKPDBidang2' and d = '$fmSKPDskpd2' and e <> '00' and e1='000' and c1='$fmSKPDUrusan'  order by e";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDUnit='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['e'] ==  $value ? "selected" : "";
				if ($nmSKPDUnit=='' ) $nmSKPDUnit =  $value == $Hasil['e'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[e]}'>{$Hasil[e]}. {$Hasil[nm_skpd]}";
    	}
	 if($value <> '' && $value <>'00') $readonly = TRUE;
     /*$Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "<input type='text' name='nmunit' id='nmunit' value='".$nmSKPDUnit."' size='60' readonly> <input type='hidden' name='$name' id='$name' value='". $value."' >";*/
     $Input = "<select $param name='$name' id='$name'> $Input</select>";
	 return $Input;
	}
	
	function cmbQuerySubUnit($name='txtField', $value='', $query='', $param='', $Atas='Pilih', $vAtas='',$readonly=FALSE,$edit='') {
	 global $Ref,$Main,$HTTP_COOKIE_VARS;
	 Global $fmSKPDUrusan,$fmSKPDBidang2,$fmSKPDskpd2,$fmSKPDUnit2,$fmSKPDSubUnit2;
	 	$fmSKPDUrusan = $_REQUEST['fmSKPDUrusan'];//cekPOST('fmSKPDUrusan');
		$fmSKPDBidang2 = $_REQUEST['fmSKPDBidang2'];//cekPOST('fmSKPDBidang2');
		$fmSKPDskpd2 = $_REQUEST['fmSKPDskpd2'];//cekPOST('fmSKPDskpd2');
		$fmSKPDUnit2 = $_REQUEST['fmSKPDUnit2'];//cekPOST('fmSKPDUnit2');
		$fmSKPDSubUnit2 = $_REQUEST['fmSKPDSubUnit2'];//cekPOST('fmSKPDSubUnit2');
			
	 $aqry="select * from ref_skpd where c='$fmSKPDBidang2' and d='$fmSKPDskpd2' and e='$fmSKPDUnit2' and e1!='000'  and c1='$fmSKPDUrusan' order by e1";
	 $Input = "<option value='$vAtas'>$Atas</option>";
	 $Query = mysql_query($aqry);
	 $nmSKPDSubUnit='';
    	while ($Hasil = mysql_fetch_array($Query)) {
        	$Sel = $Hasil['e1'] ==  $value ? "selected" : "";
				if ($nmSKPDSubUnit=='' ) $nmSKPDSubUnit =  $value == $Hasil['e1'] ? $Hasil['nm_skpd'] : '';
			$Input .= "<option $Sel value='{$Hasil[e1]}'>{$Hasil[e1]}. {$Hasil[nm_skpd]}";
    	}
	 if($value <> '' && $value <>'000') $readonly = TRUE;
     /*$Input = $readonly == false ?
	 "<select $param name='$name' id='$name'> $Input</select>":
	 "<input type='text' name='nmsubunit' id='nmsubunit' value='".$nmSKPDSubUnit."' size='60' readonly> <input type='hidden' name='$name' id='$name' value='". $value."' >";*/
     $Input = "<select $param name='$name' id='$name'> $Input</select>";
	 return $Input;
	}
	
}
$MutasiBaru_ins = new MutasiBaru_insObj();

?>