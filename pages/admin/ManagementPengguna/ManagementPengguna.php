<?php
class ManagementPenggunaObj  extends DaftarObj2{	
	var $Prefix = 'ManagementPengguna';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'managemen_pengguna'; //bonus
	var $TblName_Hapus = 'managemen_pengguna';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id_pengguna');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Management Pengguna';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='refmigrasi.xls';
	var $namaModulCetak='REFERENSI DATA';
	var $Cetak_Judul = 'ManagementPengguna';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'ManagementPenggunaForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	var $kel = array(
				array('1','ADMIN'), 
				array('2','USER'), 
				array('3','CUSTOMER'), 
				array('4','PUBLIK'), 		
		);
		
	var $Status = array(
				array('1','AKTIF'), 
				array('2','TIDAK AKTIF'), 
		);	
		
	function setTitle(){
		return 'Management Pengguna';
	}
	
	function setMenuEdit(){
		return
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Upload()","upload_f2.png","Upload", 'Upload')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","sections.png","Baru", 'Baru')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
		"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
		;
	}
	
	function setMenuView(){
		
			}
	
	function simpanUpload(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $cek = '';			
	 $err = '';			
	 $content = '';	
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 
	 
	 	$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$temp1=mysql_fetch_array(mysql_query("select Id from gambar_upload where id_upload = '$idplh' and stat='0'"));
		$temp2=mysql_fetch_array(mysql_query("select Id from gambar_upload where id_upload = '$idplh' and stat='0'"));
		
		$aq = "SELECT * FROM gambar_upload WHERE id_upload = '$idplh' AND stat = '2' and jns_upload='6'";$cek .=$aq;
		$qry = mysql_query($aq);
		while($del = mysql_fetch_array($qry)){
			unlink("Media/pengguna/".$del['nmfile']);
		}
		$hapus = "DELETE FROM gambar_upload WHERE id_upload = '$idplh' AND stat = '2' and jns_upload='6'"; $cek .= ' || '.$hapus;
		$hps = mysql_query($hapus);
		
		$aq1 = "SELECT * FROM gambar_upload WHERE id_upload = '$idplh' AND stat = '2' and jns_upload='7'";$cek .=$aq;
		$qry1 = mysql_query($aq1);
		while($del2 = mysql_fetch_array($qry1)){
			unlink("Media/pengguna/".$del2['nmfile']);
		}
		$hapus1 = "DELETE FROM gambar_upload WHERE id_upload = '$idplh' AND stat = '2' and jns_upload='7'"; $cek .= ' || '.$hapus;
		$hps1 = mysql_query($hapus1);
		
		$upd = "UPDATE gambar_upload SET stat = '0' , stat2 = '0' , tgl_create = NOW() WHERE jns_upload='6' and id_upload = '$idplh'";//$cek .= ' ||'. $upd;
		$qryupd = mysql_query($upd);
		$upd2 ="UPDATE gambar_upload SET stat = '0' , stat2 = '0' , tgl_create = NOW() WHERE jns_upload='7' and id_upload = '$idplh'";//$cek .= ' ||'. $upd;
		$qryupd2 = mysql_query($upd2);
		$temp1=mysql_fetch_array(mysql_query("select Id from gambar_upload where id_upload = '$idplh' and stat='0' and jns_upload='6'"));
		$temp2=mysql_fetch_array(mysql_query("select Id from gambar_upload where id_upload = '$idplh' and stat='0' and jns_upload='7'"));
		$cek.="select Id from gambar_upload where id_upload = '$idplh' and stat='0' and jns_upload='7'";
		$upd3 = "UPDATE managemen_pengguna SET file_imagesbw ='".$temp1['Id']."',file_imagescolor ='".$temp2['Id']."'  WHERE Id_pengguna = '$idplh'";
		$qryupd3 = mysql_query($upd3);
		$cek.="UPDATE managemen_pengguna SET file_imagesbw ='".$temp1['Id']."',file_imagescolor ='".$temp2['Id']."'  WHERE Id_pengguna = '$idplh'";
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	 function cek_Belum_Isi($err,$val,$pemberitahuan){
	 	if ($err=='' && $val=='' )$err=$pemberitahuan.' Belum di Isi !!';
		
		return $err; 
	 }
	 
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];	 
	 
	 $a= $_REQUEST['a']; 
	 $b= $_REQUEST['b'];				
	 $singkatan= $_REQUEST['singkatan'];
	 $tgl_update= $_REQUEST['tgl_update'];			 
	 $lokasi= $_REQUEST['lokasi'];
	 $status= $_REQUEST['status'];
	 
	$nm_pemda = $_REQUEST['nm_pemda']; 
	$ibukota_pemda = $_REQUEST['ibukota_pemda']; 
	$alamat_pemda = $_REQUEST['alamat_pemda']; 
	$thn_anggaran = $_REQUEST['thn_anggaran']; 
	$nm_kepala_daerah = $_REQUEST['nm_kepala_daerah']; 
	$jbt_kepala_daerah = $_REQUEST['jbt_kepala_daerah']; 
	$nm_seketaris_daerah = $_REQUEST['nm_seketaris_daerah'];
	$nip_seketaris_daerah = $_REQUEST['nip_seketaris_daerah']; 
	$jbt_seketaris_daerah = $_REQUEST['jbt_seketaris_daerah']; 
	$nm_bagian_keuangan = $_REQUEST['nm_bagian_keuangan'];
	$nip_bagian_keuangan = $_REQUEST['nip_bagian_keuangan'];
	$jbt_bagian_keuangan = $_REQUEST['jbt_bagian_keuangan']; 
	$nm_bagian_anggaran = $_REQUEST['nm_bagian_anggaran']; 
	$nip_bagian_anggaran = $_REQUEST['nip_bagian_anggaran']; 
	$jbt_bagian_anggaran = $_REQUEST['jbt_bagian_anggaran']; 
	$nm_fungsi_verikasi = $_REQUEST['nm_fungsi_verikasi']; 
	$nip_fungsi_verikasi = $_REQUEST['nip_fungsi_verikasi']; 
	$jbt_fungsi_verikasi = $_REQUEST['jbt_fungsi_verikasi']; 
	$nm_fungsi_bendahara = $_REQUEST['nm_fungsi_bendahara']; 
	$nip_fungsi_bendahara = $_REQUEST['nip_kepala_fungsi_bendaharaan'];
	$jbt_fungsi_bendahara = $_REQUEST['jbt_fungsi_bendahara']; 
	$nm_fungsi_pembekuan = $_REQUEST['nm_fungsi_pembekuan']; 
	$nip_fungsi_pembekuan = $_REQUEST['nip_fungsi_pembekuan'];
	$jbt_fungsi_pembekuan = $_REQUEST['jbt_fungsi_pembekuan']; 
	$nm_kuasa_bud = $_REQUEST['nm_kuasa_bud']; 
	$nip_kuasa_bud = $_REQUEST['nip_kuasa_bud']; 
	$jbt_kuasa_bud = $_REQUEST['jbt_kuasa_bud']; 
	$nm_atas_kuasa_bud = $_REQUEST['nm_atas_kuasa_bud']; 
	$nip_atas_kuasa_bud = $_REQUEST['nip_atas_kuasa_bud']; 
	$jbt_atas_kuasa_bud = $_REQUEST['jbt_atas_kuasa_bud'];	
			
	  $oldy=mysql_fetch_array(
	 	mysql_query(
	 		"select count(*) as cnt from managemen_pengguna where b='$b'"
		));
		$oldy3=mysql_fetch_array(
	 	mysql_query(
	 		"select count(*) as cnt from managemen_pengguna where Id_pengguna='$idplh'"
		));
	 
			if($fmST == 0){
			if( $err=='' && $nm_pemda =='' ) $err= 'Nama Pemda Belum Di Isi !!'; 
			if( $err=='' && $ibukota_pemda =='' ) $err= 'Ibu Kota Pemda Belum Di Isi !!'; 
			if( $err=='' && $alamat_pemda =='' ) $err= 'Alamat Pemda Belum Di Isi !!'; 
			if( $err=='' && $thn_anggaran =='' ) $err= 'Tahun Anggaran Belum Di Isi !!'; 
			if( $err=='' && $nm_kepala_daerah =='' ) $err= 'Nama Kepala Daerah Belum Di Isi !!'; 
			if( $err=='' && $jbt_kepala_daerah =='' ) $err= 'Jabatan Kepala Daerah Belum Di Isi !!'; 
			if( $err=='' && $nm_seketaris_daerah =='' ) $err= 'Nama Seketaris Daerah Belum Di Isi !!';
			if( $err=='' && $nip_seketaris_daerah =='' ) $err= 'NIP Seketaris Daerah Belum Di Isi !!'; 
			if( $err=='' && $jbt_seketaris_daerah =='' ) $err= 'Jabatan Seketaris Daerah Belum Di Isi !!'; 
			if( $err=='' && $nm_bagian_keuangan =='' ) $err= 'Nama Bagian Keuang Belum Di Isi !!';
			if( $err=='' && $nip_bagian_keuangan =='' ) $err= 'NIP Bagian Keuangan Belum Di Isi !!';
			if( $err=='' && $jbt_bagian_keuangan =='' ) $err= 'Jabatan Bagian Keuangan Belum Di Isi !!'; 
			if( $err=='' && $nm_bagian_anggaran =='' ) $err= 'Nama Bagian Anggaran Belum Di Isi !!'; 
			if( $err=='' && $nip_bagian_anggaran =='' ) $err= 'NIP Bagian Anggaran Belum Di Isi !!'; 
			if( $err=='' && $jbt_bagian_anggaran =='' ) $err= 'Jabatan Bagian Anggaran Belum Di Isi !!'; 
			if( $err=='' && $nm_fungsi_verikasi =='' ) $err= 'Nama Fungsi Verifikasi Belum Di Isi !!';
			if( $err=='' && $nip_fungsi_verikasi =='' ) $err= 'NIP Fungsi Verifikasi Belum Di Isi !!';
			if( $err=='' && $jbt_fungsi_verikasi =='' ) $err= 'Jabatan Fungsi Verifikasi Belum Di Isi !!';
			if( $err=='' && $nm_fungsi_bendahara =='' ) $err= 'Nama Fungsi Perbendaharaan Belum Di Isi !!';
			if( $err=='' && $nip_fungsi_bendahara =='' ) $err= 'NIP Fungsi Perbendaharaan Belum Di Isi !!';
			if( $err=='' && $jbt_fungsi_bendahara =='' ) $err= 'Jabatan Fungsi Perbendaharaan Belum Di Isi !!';
			if( $err=='' && $nm_fungsi_pembekuan =='' ) $err= 'Nama Fungsi Pembekuan Belum Di Isi !!';
			if( $err=='' && $nip_fungsi_pembekuan =='' ) $err= 'NIP Fungsi Pembekuan Pertama Belum Di Isi !!';
			if( $err=='' && $jbt_fungsi_pembekuan =='' ) $err= 'Jabatan Pembekuan Belum Di Isi !!';
			if( $err=='' && $nm_kuasa_bud =='' ) $err= 'Nama Kuasa BUD Belum Di Isi !!';
			if( $err=='' && $nip_kuasa_bud =='' ) $err= 'NIP Kuasa BUD Belum Di Isi !!';
			if( $err=='' && $jbt_kuasa_bud =='' ) $err= 'Jabatan Kuasa BUD Belum Di Isi !!'; 
			if( $err=='' && $nm_atas_kuasa_bud =='' ) $err= 'Nama Atasan Kuasa BUD Belum Di Isi !!'; 
			if( $err=='' && $nip_atas_kuasa_bud =='' ) $err= 'NIP Atasan Kuasa BUD Pertama Belum Di Isi !!';
			if( $err=='' && $jbt_atas_kuasa_bud =='' ) $err= 'Jabatan Atasan BUD Belum Di Isi !!';	
			if( $err=='' && $a =='' ) $err= 'Kode Pertama Belum Di Isi !!';
	 		if( $err=='' && $b =='' ) $err= 'Kode Kedua Belum Di Isi !!';
	 		if( $err=='' && $singkatan =='' ) $err= 'Nama Singkatan Belum Di Pilih !!';
			if( $err=='' && $lokasi =='' ) $err= 'Lokasi Belum Di Isi !!';
			
			if($err=='' && $oldy['cnt']>0) $err="KODE '$a' '$b' Sudah Ada";
	 	
				if($err==''){
					$aqry = "INSERT into managemen_pengguna (a,b,nm_singkatan,lokasi,status,tgl_update,uid,nm_pengguna,ibukota_pemda,alamat_pemda,thn_anggaran,nm_kepala_daerah,jbt_kepala_daerah,nm_seketaris_daerah,nip_seketaris_daerah,jbt_seketaris_daerah,nm_bagian_keuangan,nip_bagian_keuangan,jbt_bagian_keuangan,nm_kepala_fungsi_anggaran,nip_kepala_fungsi_anggaran,jbt_kepala_fungsi_anggaran,nm_kepala_fungsi_verikasi,nip_kepala_fungsi_verikasi,jbt_kepala_fungsi_verikasi,nm_kepala_fungsi_perbendaharaan,nip_kepala_fungsi_perbendaharaan,jbt_kepala_fungsi_perbendaharaan,nm_kepala_fungsi_pembekuan,nip_kepala_fungsi_pembekuan,jbt_kepala_fungsi_pembekuan,nm_kuasa_bud,nip_kuasa_bud,jbt_kuasa_bud,nm_atasan_kuasa_bud,nip_atasan_kuasa_bud,jbt_atasan_kuasa_bud) values('$a','$b','$singkatan','$lokasi','$status',NOW(),'$uid','$nm_pemda','$ibukota_pemda','$alamat_pemda','$thn_anggaran','$nm_kepala_daerah','$jbt_kepala_daerah','$nm_seketaris_daerah','$nip_seketaris_daerah','$jbt_seketaris_daerah','$nm_bagian_keuangan','$nip_bagian_keuangan','$jbt_bagian_keuangan','$nm_bagian_anggaran','$nip_bagian_anggaran','$jbt_bagian_anggaran','$nm_fungsi_verikasi','$nip_fungsi_verikasi','$jbt_fungsi_verikasi','$nm_fungsi_bendahara','$nip_fungsi_bendahara','$jbt_fungsi_bendahara','$nm_fungsi_pembekuan','$nip_fungsi_pembekuan','$jbt_fungsi_pembekuan','$nm_kuasa_bud','$nip_kuasa_bud','$jbt_kuasa_bud','$nm_atas_kuasa_bud','$nip_atas_kuasa_bud','$jbt_atas_kuasa_bud')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{
						if($err==''){
					//	if( $err=='' && $nm_pengguna =='' ) $err= 'Nama Pengguna Belum Di Isi !!';
	 					if( $err=='' && $singkatan =='' ) $err= 'Nama Singkatan Belum Di Pilih !!';
						if( $err=='' && $lokasi =='' ) $err= 'Lokasi Belum Di Isi !!';
						if( $err=='' && $nm_pemda =='' ) $err= 'Nama Pemda Belum Di Isi !!'; 
			if( $err=='' && $ibukota_pemda =='' ) $err= 'Ibu Kota Pemda Belum Di Isi !!'; 
			if( $err=='' && $alamat_pemda =='' ) $err= 'Alamat Pemda Belum Di Isi !!'; 
			if( $err=='' && $thn_anggaran =='' ) $err= 'Tahun Anggaran Belum Di Isi !!'; 
			if( $err=='' && $nm_kepala_daerah =='' ) $err= 'Nama Kepala Daerah Belum Di Isi !!'; 
			if( $err=='' && $jbt_kepala_daerah =='' ) $err= 'Jabatan Kepala Daerah Belum Di Isi !!'; 
			if( $err=='' && $nm_seketaris_daerah =='' ) $err= 'Nama Seketaris Daerah Belum Di Isi !!';
			if( $err=='' && $nip_seketaris_daerah =='' ) $err= 'NIP Seketaris Daerah Belum Di Isi !!'; 
			if( $err=='' && $jbt_seketaris_daerah =='' ) $err= 'Jabatan Seketaris Daerah Belum Di Isi !!'; 
			if( $err=='' && $nm_bagian_keuangan =='' ) $err= 'Nama Bagian Keuang Belum Di Isi !!';
			if( $err=='' && $nip_bagian_keuangan =='' ) $err= 'NIP Bagian Keuangan Belum Di Isi !!';
			if( $err=='' && $jbt_bagian_keuangan =='' ) $err= 'Jabatan Bagian Keuangan Belum Di Isi !!'; 
			if( $err=='' && $nm_bagian_anggaran =='' ) $err= 'Nama Bagian Anggaran Belum Di Isi !!'; 
			if( $err=='' && $nip_bagian_anggaran =='' ) $err= 'NIP Bagian Anggaran Belum Di Isi !!'; 
			if( $err=='' && $jbt_bagian_anggaran =='' ) $err= 'Jabatan Bagian Anggaran Belum Di Isi !!'; 
			if( $err=='' && $nm_fungsi_verikasi =='' ) $err= 'Nama Fungsi Verifikasi Belum Di Isi !!';
			if( $err=='' && $nip_fungsi_verikasi =='' ) $err= 'NIP Fungsi Verifikasi Belum Di Isi !!';
			if( $err=='' && $jbt_fungsi_verikasi =='' ) $err= 'Jabatan Fungsi Verifikasi Belum Di Isi !!';
			if( $err=='' && $nm_fungsi_bendahara =='' ) $err= 'Nama Fungsi Perbendaharaan Belum Di Isi !!';
			if( $err=='' && $nip_fungsi_bendahara =='' ) $err= 'NIP Fungsi Perbendaharaan Belum Di Isi !!';
			if( $err=='' && $jbt_fungsi_bendahara =='' ) $err= 'Jabatan Fungsi Perbendaharaan Belum Di Isi !!';
			if( $err=='' && $nm_fungsi_pembekuan =='' ) $err= 'Nama Fungsi Pembekuan Belum Di Isi !!';
			if( $err=='' && $nip_fungsi_pembekuan =='' ) $err= 'NIP Fungsi Pembekuan Pertama Belum Di Isi !!';
			if( $err=='' && $jbt_fungsi_pembekuan =='' ) $err= 'Jabatan Pembekuan Belum Di Isi !!';
			if( $err=='' && $nm_kuasa_bud =='' ) $err= 'Nama Kuasa BUD Belum Di Isi !!';
			if( $err=='' && $nip_kuasa_bud =='' ) $err= 'NIP Kuasa BUD Belum Di Isi !!';
			if( $err=='' && $jbt_kuasa_bud =='' ) $err= 'Jabatan Kuasa BUD Belum Di Isi !!'; 
			if( $err=='' && $nm_atas_kuasa_bud =='' ) $err= 'Nama Atasan Kuasa BUD Belum Di Isi !!'; 
			if( $err=='' && $nip_atas_kuasa_bud =='' ) $err= 'NIP Atasan Kuasa BUD Pertama Belum Di Isi !!';
			if( $err=='' && $jbt_atas_kuasa_bud =='' ) $err= 'Jabatan Atasan BUD Belum Di Isi !!';	
			if( $err=='' && $a =='' ) $err= 'Kode Pertama Belum Di Isi !!';
	 		if( $err=='' && $b =='' ) $err= 'Kode Kedua Belum Di Isi !!';
	 		if( $err=='' && $singkatan =='' ) $err= 'Nama Singkatan Belum Di Pilih !!';
			if( $err=='' && $lokasi =='' ) $err= 'Lokasi Belum Di Isi !!';
			
					//	if($err=='' && $oldy3['cnt']>0) $err="Kode System '$a' '$b'  Sudah Ada";
						$aqry = "UPDATE managemen_pengguna set a='$a',b='$b',nm_pengguna='$nm_pemda',nm_singkatan='$singkatan',lokasi='$lokasi',status='$status',tgl_update=NOW() where Id_pengguna='".$idplh."'";	$cek .= $aqry;
								$qry = mysql_query($aqry) or die(mysql_error());
						}
			} //end else
					
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
			
		case 'formBaru':{				
			$fm = $this->setFormBaru();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'formUpload':{				
			$fm = $this->setFormUpload();				
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
		case 'hapus':{
			$get= $this->Hapus();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
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
		
		case 'simpanUpload':{
			$get= $this->simpanUpload();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'batal':{
			$get= $this->batal();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
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
 
	function Hapus($ids){ //validasi hapus tbl_sppd
		 $err=''; $cek='';
		 $cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		
		if ($err ==''){
			
		for($i = 0; $i<count($ids); $i++){
		$idplh1 = explode(" ",$ids[$i]);
			
		if($err=='' ){
		
		$aq = "SELECT * FROM gambar_upload WHERE id_upload = '".$ids[$i]."' and jns_upload='6'";$cek .=$aq;
		$qry = mysql_query($aq);
		while($del = mysql_fetch_array($qry)){
			unlink("Media/pengguna/".$del['nmfile']);
		}
		$hapus = "DELETE FROM gambar_upload WHERE id_upload = '".$ids[$i]."' and jns_upload='6'"; $cek .= ' || '.$hapus;
		$hps = mysql_query($hapus);
		
		
		$aq1 = "SELECT * FROM gambar_upload WHERE id_upload = '".$ids[$i]."' and jns_upload='7'";$cek .=$aq;
		$qry1 = mysql_query($aq1);
		while($del2 = mysql_fetch_array($qry1)){
			unlink("Media/pengguna/".$del2['nmfile']);
		}
		$hapus1 = "DELETE FROM gambar_upload WHERE id_upload = '".$ids[$i]."' and jns_upload='7'"; $cek .= ' || '.$hapus;
		$hps1 = mysql_query($hapus1);
					
					$qy = "DELETE FROM managemen_pengguna WHERE Id_pengguna='".$ids[$i]."' ";$cek.=$qy;
					$qry = mysql_query($qy);
					
			}else{
				break;
			}			
		}
		}
		return array('err'=>$err,'cek'=>$cek);
	}	  
	
	function setPage_OtherScript(){
		$scriptload = 
		"<script>
		$(document).ready(function()
		{
			".$this->Prefix.".loading();
			setTimeout(function myFunction()
			{
				".$this->Prefix.".AftFilterRender()},1000);
		}
		);
		</script>";
		return 	
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			
			
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/upload_style.css' type='text/css'>".
			"<script src='js/jquery.js' type='text/javascript'></script>".			
			"<script src='js/jquery-ui.js' type='text/javascript'></script>".
			"<script src='js/jquery.min.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/jquery.form.js'></script> ".
			"<script src='js/jquery-ui.custom.js'></script>".
			
			"<script type='text/javascript' src='js/admin/ManagementPengguna/ManagementPengguna.js' language='JavaScript' ></script>".
			
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
   
   function setFormUpload(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  managemen_pengguna WHERE Id_pengguna='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		
		$file = "SELECT * FROM gambar_upload WHERE id_upload='$this->form_idplh'LIMIT 0,1";$cek=$qry;
		$aqfile = mysql_query($file);
		$qryfile = mysql_fetch_array($aqfile);
		
		if(mysql_num_rows($aqfile) > 0) {
			$dt['isifile'] = mysql_num_rows($aqfile);
			$dt['idfile'] = $qryfile['Id'];
			$dt['nmfile'] = $qryfile['nmfile'];
			$dt['nmfile_asli'] = $qryfile['nmfile_asli'];
		}else{
			$dt['isifile'] = 0;
		}
		
		$fm = $this->setUpload($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
   /*function setForm_content_fields(){
		$content = '';
		
		
		
		foreach ($this->form_fields as $key=>$field){
			if(isset($field['bebas'])){
				$content.=	$field['isi'];
			}
		}
		
		
		
		
		
		
		//$content = 
		//	"<tr><td style='width:100'>field</td><td style='width:10'>:</td><td>value</td></tr>";
		return $content;	
	}*/
	
	
  	function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT * FROM  managemen_pengguna WHERE Id_pengguna='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setFormEditdata($dt);
	//	$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
		
	function setForm($dt){	
	 global $SensusTmp;
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $cek = ''; $err=''; $content=''; 
	 $uid = $HTTP_COOKIE_VARS['coID'];		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	$this->form_width = 500;
	 $this->form_height = 550;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Management Pengguna - Baru';
		//$nip	 = '';
	  }else{
		$this->form_caption = 'Management Pengguna - Edit';			
		$Id = $dt['id'];			
	  }
	    //ambil data trefditeruskan
		$queryKF="SELECT max(no_urut)as nourut FROM system" ;
	//	$cek.="SELECT max(no_urut)as nourut FROM system";
		
	$tgl_update = date('d-m-Y');		
	 //items ----------------------
	 $this->form_fields = array(
	  
	  			 
		
			'Pemda' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>Pemerintah Daerah</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'nm_pemda' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA PEMDA',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='nm_pemda' id='nm_pemda' value='".$dt['nm_pemda']."' style='width:250px;'>",
						 ),				 		
			
			'ibukota' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp IBU KOTA PEMDA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='ibukota_pemda' id='ibukota_pemda' value='".$dt['ibukota_pemda']."' style='width:250px;'>",
						 ),	
						 
			'ALAMAT' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp ALAMAT PEMDA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='alamat_pemda' id='alamat_pemda' value='".$dt['alamat_pemda']."' style='width:250px;'>",
						 ),				 
			
			
						 
			'THN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp TAHUN ANGGARAN',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='thn_anggaran' id='thn_anggaran' value='".$dt['thn_anggaran']."' style='width:250px;'>",
						 ),	
						 
			'br3' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
			'br4' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		 
						 			 
			'KEPALA_DAERAH' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA DAERAH</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_DAE' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_kepala_daerah' id='nm_kepala_daerah' value='".$dt['nm_kepala_daerah']."' style='width:250px;'>",
						 ),
						 
			'JABT' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_kepala_daerah' id='jbt_kepala_daerah' value='".$dt['jbt_kepala_daerah']."' style='width:250px;'>",
						 ),				 		
			
			'br5' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
			'br6' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
						 	 
			'sekdek' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>SEKETARIS DAERAH</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_sek_dek' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_seketaris_daerah' id='nm_seketaris_daerah' value='".$dt['nm_seketaris_daerah']."' style='width:250px;'>",
						 ),
						 
			'nip_sek_dek' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_seketaris_daerah' id='nip_seketaris_daerah' value='".$dt['nip_seketaris_daerah']."' style='width:250px;'>",
						 ),		
			
			'JAB_sek_dek' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_seketaris_daerah' id='jbt_seketaris_daerah' value='".$dt['jbt_seketaris_daerah']."' style='width:250px;'>",
						 ),	
						 		 
				'br7' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
			'br8' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
						 
			'bag_keuangan' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA BADAN / BAGIAN KEUANGAN</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_BAG_UANG' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_bagian_keuangan' id='nm_bagian_keuangan' value='".$dt['nm_bagian_keuangan']."' style='width:250px;'>",
						 ),
						 
			'nip_BAG_UANG' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_bagian_keuangan' id='nip_bagian_keuangan' value='".$dt['nip_bagian_keuangan']."' style='width:250px;'>",
						 ),		
			
			'JAB_BAG_UANG' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_bagian_keuangan' id='jbt_bagian_keuangan' value='".$dt['jbt_bagian_keuangan']."' style='width:250px;'>",
						 ),	
			
						 
			'br9' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
			'br10' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
						 
					 			 
						 						 
			'KEL_FUN_ANGGARAN' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA FUNGSI ANGGARAN</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_ANGGARAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_bagian_anggaran' id='nm_bagian_anggaran' value='".$dt['nm_kepala_fungsi_anggaran']."' style='width:250px;'>",
						 ),
						 
			'nip_KEL_FUN_ANGGARAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_bagian_anggaran' id='nip_bagian_anggaran' value='".$dt['nip_kepala_fungsi_anggaran']."' style='width:250px;'>",
						 ),		
			
			'JAB_KEL_FUN_ANGGARAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_bagian_anggaran' id='jbt_bagian_anggaran' value='".$dt['jbt_kepala_fungsi_perbendaharaan']."' style='width:250px;'>",
						 ),	
			'br11' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br12' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
			'KEL_FUN_VERIKASI' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA FUNGSI VERIKASI</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_VERIKASI' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_fungsi_verikasi' id='nm_fungsi_verikasi' value='".$dt['nm_kepala_fungsi_verikasi']."' style='width:250px;'>",
						 ),
						 
			'nip_KEL_FUN_VERIKASI' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_fungsi_verikasi' id='nip_fungsi_verikasi' value='".$dt['nip_kepala_fungsi_verikasi']."' style='width:250px;'>",
						 ),		
			
			'JAB_KEL_FUN_VERIKASI' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_fungsi_verikasi' id='jbt_fungsi_verikasi' value='".$dt['jbt_kepala_fungsi_verikasi']."' style='width:250px;'>",
						 ),	
			
			
			'br11' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br12' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			
			'KEL_FUN_BENDAHARA' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA FUNGSI BENDAHARA</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_BENDAHARA' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_fungsi_bendahara' id='nm_fungsi_bendahara' value='".$dt['nm_kepala_fungsi_perbendaharaan']."' style='width:250px;'>",
						 ),
						 
			'nip_KEL_FUN_BENDAHARA' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_kepala_fungsi_bendaharaan' id='nip_kepala_fungsi_bendaharaan' value='".$dt['nip_kepala_fungsi_perbendaharaan']."' style='width:250px;'>",
						 ),		
			
			'JAB_KEL_FUN_BENDAHARA' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_fungsi_bendahara' id='jbt_fungsi_bendahara' value='".$dt['jbt_kepala_fungsi_perbendaharaan']."' style='width:250px;'>",
						 ),	
			
			
			'br13' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br14' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
			
			'KEL_FUN_PEMBEKUAN' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA FUNGSI PEMBEKUAN</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_PEMBEKUAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_fungsi_pembekuan' id='nm_fungsi_pembekuan' value='".$dt['nm_kepala_fungsi_pembekuan']."' style='width:250px;'>",
						 ),
						 
			'nip_KEL_FUN_PEMBEKUAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_fungsi_pembekuan' id='nip_fungsi_pembekuan' value='".$dt['nip_kepala_fungsi_pembekuan']."' style='width:250px;'>",
						 ),		
						 
			'JAB_KEL_FUN_PEMBEKUAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_fungsi_pembekuan' id='jbt_fungsi_pembekuan' value='".$dt['jbt_kepala_fungsi_pembekuan']."' style='width:250px;'>",
						 ),	
			
			
			'br15' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br16' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'KUASA_BUD' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KUASA BUD</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_kuasa_bud' id='nm_kuasa_bud' value='".$dt['nm_kuasa_bud']."' style='width:250px;'>",
						 ),
						 
			'nip_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_kuasa_bud' id='nip_kuasa_bud' value='".$dt['nip_kuasa_bud']."' style='width:250px;'>",
						 ),		
			
			'JAB_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_kuasa_bud' id='jbt_kuasa_bud' value='".$dt['jbt_kuasa_bud']."' style='width:250px;'>",
						 ),	
			
			
			'br17' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br18' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'KEL_FUN_KUASA_BUD' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>ATASAN LANGSUNG KUASA BUD</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_atas_kuasa_bud' id='nm_atas_kuasa_bud' value='".$dt['nm_atasan_kuasa_bud']."' style='width:250px;'>",
						 ),
						 
			'nip_KEL_FUN_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_atas_kuasa_bud' id='nip_atas_kuasa_bud' value='".$dt['nip_atasan_kuasa_bud']."' style='width:250px;'>",
						 ),		
			"<BR>".
			'JAB_KEL_FUN_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_atas_kuasa_bud' id='jbt_atas_kuasa_bud' value='".$dt['jbt_atasan_kuasa_bud']."' style='width:250px;'>",
						 ),	
			
			
			'br19' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br20' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'PENGGUNA' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>PENGGUNA</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'KODE' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp KODE',
						'labelWidth'=>100, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='a' id='a' maxlength='2' value='".$dt['a']."' style='width:30px;maxlength='2' >
						<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='b' id='b' maxlength='2' value='".$dt['b']."' style='width:30px;maxlength='2' > 
						",
						 ),
						 
			'singkatan' => array( 
						'label'=>'SINGKATAN PENGGUNA',
						'labelWidth'=>120, 
						'value'=>"<input type='text' name='singkatan' id='singkatan' value='".$dt['nm_singkatan']."' style='width:250px;'>",
						 ),	
						 
			'lokasi' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp LOKASI',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='lokasi' id='lokasi' value='".$dt['lokasi']."' style='width:250px;'>",
						 ),				 			
						 
			'status' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp STATUS',
						'labelWidth'=>100,
						'value'=>cmbArray('status',$dt['status'],$this->Status,'-- PILIH --','style="width:95px;"'),
						 ),	
						 			 			 
			);
	  
	  		
			
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Batal()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	
	
	function setFormEditdata($dt){	
	 global $SensusTmp;
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $cek = ''; $err=''; $content=''; 
	 $uid = $HTTP_COOKIE_VARS['coID'];		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';
					
	$this->form_width = 500;
	 $this->form_height = 550;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Management Pengguna - Baru';
		//$nip	 = '';
	  }else{
		$this->form_caption = 'Management Pengguna - Edit';			
		$Id = $dt['id'];			
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	
	$kode=mysql_fetch_array(mysql_query("select a,b from managemen_pengguna where a='".$dt['a']."' and b='".$dt['b']."'"));	
	$kode2=$kode['a'].'.'.$kode['b'];
	
	$nmupload1=mysql_fetch_array(mysql_query("SELECT `gambar_upload`.`nmfile_asli`,gambar_upload.nmfile FROM `gambar_upload` LEFT JOIN `managemen_pengguna` ON `managemen_pengguna`.`Id_pengguna` = `gambar_upload`.`id_upload` where Id_pengguna='".$dt['Id_pengguna']."' and jns_upload='6'"));
	$nmupload2=mysql_fetch_array(mysql_query("SELECT `gambar_upload`.`nmfile_asli`,gambar_upload.nmfile FROM `gambar_upload` LEFT JOIN `managemen_pengguna` ON `managemen_pengguna`.`Id_pengguna` = `gambar_upload`.`id_upload` where Id_pengguna='".$dt['Id_pengguna']."' and jns_upload='7'"));
	
	 //items ----------------------
	  $this->form_fields = array(
	  		'Pemda' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>Pemerintah Daerah</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'nm_pemda' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA PEMDA',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='nm_pemda' id='nm_pemda' value='".$dt['nm_pengguna']."' style='width:250px;'>",
						 ),				 		
			
			'ibukota' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp IBU KOTA PEMDA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='ibukota_pemda' id='ibukota_pemda' value='".$dt['ibukota_pemda']."' style='width:250px;'>",
						 ),	
						 
			'ALAMAT' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp ALAMAT PEMDA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='alamat_pemda' id='alamat_pemda' value='".$dt['alamat_pemda']."' style='width:250px;'>",
						 ),				 
			
			'THN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp TAHUN ANGGARAN',
						'labelWidth'=>100,
						'value'=>"<input type='text' name='thn_anggaran' id='thn_anggaran' value='".$dt['thn_anggaran']."' style='width:250px;'>",
						 ),	
						 
			'br3' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
			'br4' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		 
						 			 
			'KEPALA_DAERAH' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA DAERAH</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_DAE' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_kepala_daerah' id='nm_kepala_daerah' value='".$dt['nm_kepala_daerah']."' style='width:250px;'>",
						 ),
						 
			'JABT' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_kepala_daerah' id='jbt_kepala_daerah' value='".$dt['jbt_kepala_daerah']."' style='width:250px;'>",
						 ),				 		
			
			'br5' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
						 
			'br6' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
						 	 
			'sekdek' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>SEKETARIS DAERAH</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_sek_dek' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_seketaris_daerah' id='nm_seketaris_daerah' value='".$dt['nm_seketaris_daerah']."' style='width:250px;'>",
						 ),
						 
			'nip_sek_dek' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_seketaris_daerah' id='nip_seketaris_daerah' value='".$dt['nip_seketaris_daerah']."' style='width:250px;'>",
						 ),		
			
			'JAB_sek_dek' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_seketaris_daerah' id='jbt_seketaris_daerah' value='".$dt['jbt_seketaris_daerah']."' style='width:250px;'>",
						 ),	
						 		 
				'br7' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),
						 	
			'br8' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
						 
			'bag_keuangan' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA BADAN / BAGIAN KEUANGAN</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_BAG_UANG' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_bagian_keuangan' id='nm_bagian_keuangan' value='".$dt['nm_bagian_keuangan']."' style='width:250px;'>",
						 ),
						 
			'nip_BAG_UANG' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_bagian_keuangan' id='nip_bagian_keuangan' value='".$dt['nip_bagian_keuangan']."' style='width:250px;'>",
						 ),		
			
			'JAB_BAG_UANG' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_bagian_keuangan' id='jbt_bagian_keuangan' value='".$dt['jbt_bagian_keuangan']."' style='width:250px;'>",
						 ),	
			
			'br9' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
						 
			'br10' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
						 	 						 
			'KEL_FUN_ANGGARAN' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA FUNGSI ANGGARAN</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_ANGGARAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_bagian_anggaran' id='nm_bagian_anggaran' value='".$dt['nm_kepala_fungsi_anggaran']."' style='width:250px;'>",
						 ),
						 
			'nip_KEL_FUN_ANGGARAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_bagian_anggaran' id='nip_bagian_anggaran' value='".$dt['nip_kepala_fungsi_anggaran']."' style='width:250px;'>",
						 ),		
			
			'JAB_KEL_FUN_ANGGARAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_bagian_anggaran' id='jbt_bagian_anggaran' value='".$dt['jbt_kepala_fungsi_perbendaharaan']."' style='width:250px;'>",
						 ),	
			'br11' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br12' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
			'KEL_FUN_VERIKASI' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA FUNGSI VERIKASI</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_VERIKASI' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_fungsi_verikasi' id='nm_fungsi_verikasi' value='".$dt['nm_kepala_fungsi_verikasi']."' style='width:250px;'>",
						 ),
						 
			'nip_KEL_FUN_VERIKASI' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_fungsi_verikasi' id='nip_fungsi_verikasi' value='".$dt['nip_kepala_fungsi_verikasi']."' style='width:250px;'>",
						 ),		
			
			'JAB_KEL_FUN_VERIKASI' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_fungsi_verikasi' id='jbt_fungsi_verikasi' value='".$dt['jbt_kepala_fungsi_verikasi']."' style='width:250px;'>",
						 ),	
			
			'br11' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br12' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'KEL_FUN_BENDAHARA' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA FUNGSI BENDAHARA</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_BENDAHARA' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_fungsi_bendahara' id='nm_fungsi_bendahara' value='".$dt['nm_kepala_fungsi_perbendaharaan']."' style='width:250px;'>",
						 ),
						 
			'nip_KEL_FUN_BENDAHARA' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_kepala_fungsi_bendaharaan' id='nip_kepala_fungsi_bendaharaan' value='".$dt['nip_kepala_fungsi_perbendaharaan']."' style='width:250px;'>",
						 ),		
			
			'JAB_KEL_FUN_BENDAHARA' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_fungsi_bendahara' id='jbt_fungsi_bendahara' value='".$dt['jbt_kepala_fungsi_perbendaharaan']."' style='width:250px;'>",
						 ),	
			
			
			'br13' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br14' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
			
			'KEL_FUN_PEMBEKUAN' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA FUNGSI PEMBEKUAN</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_PEMBEKUAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_fungsi_pembekuan' id='nm_fungsi_pembekuan' value='".$dt['nm_kepala_fungsi_pembekuan']."' style='width:250px;'>",
						 ),
						 
			'nip_KEL_FUN_PEMBEKUAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_fungsi_pembekuan' id='nip_fungsi_pembekuan' value='".$dt['nip_kepala_fungsi_pembekuan']."' style='width:250px;'>",
						 ),		
						 
			'JAB_KEL_FUN_PEMBEKUAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_fungsi_pembekuan' id='jbt_fungsi_pembekuan' value='".$dt['jbt_kepala_fungsi_pembekuan']."' style='width:250px;'>",
						 ),	
			
			'br15' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br16' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'KUASA_BUD' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KUASA BUD</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_kuasa_bud' id='nm_kuasa_bud' value='".$dt['nm_kuasa_bud']."' style='width:250px;'>",
						 ),
						 
			'nip_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_kuasa_bud' id='nip_kuasa_bud' value='".$dt['nip_kuasa_bud']."' style='width:250px;'>",
						 ),		
			
			'JAB_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_kuasa_bud' id='jbt_kuasa_bud' value='".$dt['jbt_kuasa_bud']."' style='width:250px;'>",
						 ),	
			
			'br17' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br18' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'KEL_FUN_KUASA_BUD' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>ATASAN LANGSUNG KUASA BUD</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='nm_atas_kuasa_bud' id='nm_atas_kuasa_bud' value='".$dt['nm_atasan_kuasa_bud']."' style='width:250px;'>",
						 ),
						 
			'nip_KEL_FUN_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57' name='nip_atas_kuasa_bud' id='nip_atas_kuasa_bud' value='".$dt['nip_atasan_kuasa_bud']."' style='width:250px;'>",
						 ),		
			
			'JAB_KEL_FUN_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>"<input type='text' name='jbt_atas_kuasa_bud' id='jbt_atas_kuasa_bud' value='".$dt['jbt_atasan_kuasa_bud']."' style='width:250px;'>",
						 ),	
			
			'br19' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br20' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'PENGGUNA' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>PENGGUNA</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'KODE' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp KODE',
						'labelWidth'=>100, 
						'value'=>"<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='a' id='a' maxlength='2' value='".$dt['a']."' style='width:30px;maxlength='2' readonly>
						<input type='text' onkeypress='return event.charCode >= 48 && event.charCode <= 57'name='b' id='b' maxlength='2' value='".$dt['b']."' style='width:30px;maxlength='2' readonly> 
						",
						 ),
						 
			'singkatan' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp SINGKATAN',
						'labelWidth'=>120, 
						'value'=>"<input type='text' name='singkatan' id='singkatan' value='".$dt['nm_singkatan']."' style='width:250px;'>",
						 ),	
						 
			'lokasi' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp LOKASI',
						'labelWidth'=>100, 
						'value'=>"<input type='text' name='lokasi' id='lokasi' value='".$dt['lokasi']."' style='width:250px;'>",
						 ),				 			
						
			'scan_foto1' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp FILE IMAGES BW',
						'labelWidth'=>100,
						'value'=>"<img src='Media/pengguna/".$nmupload1['nmfile']."' border='0' Width='' Height='35'/>".'<br>'.$nmupload1['nmfile_asli'], 
						),		
						
			'scan_foto2' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp FILE IMAGES COLOR',
						'labelWidth'=>100,
						'value'=>"<img src='Media/pengguna/".$nmupload2['nmfile']."' border='0' Width='' Height='35'/>".'<br>'.$nmupload2['nmfile_asli'], 
						),				
							 
			'status' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp STATUS',
						'labelWidth'=>100,
						'value'=>cmbArray('status',$dt['status'],$this->Status,'-- PILIH --','style="width:95px;"'),
						 ),	
			);	 			 
					
		//tombol
		$this->form_menubawah =
			
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Batal()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	
	function setUpload($dt){	
	 global $SensusTmp;
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 
	 $cek = ''; $err=''; $content=''; 	
	// $uid = $HTTP_COOKIE_VARS['coID'];			
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 450;
	 $this->form_height = 550;
	  if ($this->form_fmST==0) {
		
	  }else{
		$this->form_caption = 'Management Pengguna - Upload';			
	
	  }
	
	$tgl_expired=TglInd($dt['expired_date']);
	$tgl_update=TglInd($dt['tgl_update']);
	$kod=$dt['a'].$dt['b'];	
	 if($dt['status']==1){
	 	$sts='AKTIF';
	 }elseif($dt['status']==2){
	 	$sts='NON AKTIF';
	 }
	 
	 if($dt['status']==1){
	 	$status='AKTIF';
	 }elseif($dt['status']==2){
	 	$status='TIDAK AKTIF';
	 }
	$kode=mysql_fetch_array(mysql_query("select a,b from managemen_pengguna where a='".$dt['a']."' and b='".$dt['b']."'"));	
	$kode2=$kode['a'].'.'.$kode['b'];
	 
	 //items ----------------------
	  $this->form_fields = array(
	  		
			'PENGGUNA' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>PENGGUNA</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'KODE' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp KODE',
						'labelWidth'=>100, 
						'value'=>$kod,
						 ),
						 
			'singkatan' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp SINGKATAN',
						'labelWidth'=>120, 
						'value'=>$dt['nm_singkatan'],
						 ),	
						 
			'lokasi' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp LOKASI',
						'labelWidth'=>100, 
						'value'=>$dt['lokasi'],
						 ),				 			
			
			'BW' => array( 
				'label'=>'&nbsp&nbsp&nbsp&nbsp FILE IMAGES BW','labelWidth'=>100, 
				'value'=>						
					"<form></form>".					
					"<form action='pages.php?Pg=processuploadfilepengguna1' method='post' enctype='multipart/form-data' id='UploadForm'>".
					"<input type='hidden' id='peng_id' name='peng_id' value='".$dt['Id_pengguna']."' >".
					"<input id='ImageFile' name='ImageFile' type='file'  style='visibility:hidden;width:0px;height:0px' onchange=\"".$this->Prefix.".btfile_onchange()\" />".
					"<input type='button' onclick=\"$('#ImageFile').click();\" value='Pilih File'>
					 <input type='hidden' id='isifile' name='isifile' value='".$dt['isifile']."' >
					 <input type='hidden' id='ref_idupload' name='ref_idupload' value='".$dt['id']."' >
					 <input type='hidden' id='idfile' name='idfile' value='".$dt['idfile']."' >
					 <input type='hidden' id='jns_upload' name='jns_upload' value='6' >
					 <input type='hidden' id='nmfile' name='nmfile' value='".$dt['nmfile']."' >".
					"<input type='hidden' id='nmfile_asli' name='nmfile_asli' value='".$dt['nmfile_asli']."' >".
					"<span id='content_newfile' style='margin-left:6px;'>".$datakt['nmfile_asli']."</span>".
					"</form>".
					'', 
			 ),
			 
			 'COLOR' => array( 
				'label'=>'&nbsp&nbsp&nbsp&nbsp FILE IMAGES COLOR','labelWidth'=>150, 
				'value'=>						
					"<form></form>".					
					"<form action='pages.php?Pg=processuploadfilepengguna2' method='post' enctype='multipart/form-data' id='UploadForm2'>".
					"<input type='hidden' id='peng_id' name='peng_id' value='".$dt['Id_pengguna']."' >".
					"<input id='ImageFile2' name='ImageFile2' type='file'  style='visibility:hidden;width:0px;height:0px' onchange=\"".$this->Prefix.".btfile2_onchange()\" />".
					"<input type='button' onclick=\"$('#ImageFile2').click();\" value='Pilih File'>
					 <input type='hidden' id='isifile' name='isifile' value='".$dt['isifile']."' >
					 <input type='hidden' id='ref_idupload1' name='ref_idupload1' value='".$dt['id']."' >
					 <input type='hidden' id='idfile' name='idfile' value='".$dt['idfile']."' >
					<input type='hidden' id='jns_upload' name='jns_upload' value='7' >
					 <input type='hidden' id='nmfile' name='nmfile' value='".$dt['nmfile']."' >".
					"<input type='hidden' id='nmfile_asli' name='nmfile_asli' value='".$dt['nmfile_asli']."' >".
					"<span id='content_newfile2' style='margin-left:6px;'>".$datpsf['nmfile_asli']."</span>".
					"</form>".
					'', 
			 ),
			 
			'progress' => array(
				'label'=>'','labelWidth'=>100, 'pemisah'=>' ',
				'value'=>				
					"<div id='progressbox'><div id='progressbar'></div >
					<div id='statustxt'>0%</div >
					<div id='output'></div>	"
			),
			
						 
			'status' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp STATUS',
						'labelWidth'=>100,
						'value'=>$sts,						
						 ),	
			
			'Pemda' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>Pemerintah Daerah</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'nm_pemda' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA PEMDA',
						'labelWidth'=>150, 
						'value'=>$dt['nm_pemda'],
						 ),				 		
			
			'ibukota' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp IBU KOTA PEMDA',
						'labelWidth'=>100, 
						'value'=>$dt['ibukota_pemda'],
						 ),	
						 
			'ALAMAT' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp ALAMAT PEMDA',
						'labelWidth'=>100, 
						'value'=>$dt['alamat_pemda'],
						 ),				 
			
			
						 
			'THN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp TAHUN ANGGARAN',
						'labelWidth'=>100,
						'value'=>$dt['thn_anggaran'],
						 ),	
						 
			'br3' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),
						 	
			'br4' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		 
						 			 
			'KEPALA_DAERAH' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA DAERAH</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_DAE' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>$dt['nm_kepala_daerah'],
						 ),
						 
			'JABT' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>$dt['jbt_kepala_daerah'],
						 ),				 		
			
			'br5' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
						 
			'br6' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
						 	 
			'sekdek' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>SEKETARIS DAERAH</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_sek_dek' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>$dt['nm_seketaris_daerah'],
						 ),
						 
			'nip_sek_dek' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>$dt['nip_seketaris_daerah'],
						 ),		
			
			'JAB_sek_dek' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>$dt['jbt_seketaris_daerah'],
						 ),	
						 		 
				'br7' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
						 
			'br8' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
						 
			'bag_keuangan' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA BADAN / BAGIAN KEUANGAN</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_BAG_UANG' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>$dt['nm_bagian_keuangan'],
						 ),
						 
			'nip_BAG_UANG' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>$dt['nip_bagian_keuangan'],
						 ),		
			
			'JAB_BAG_UANG' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>$dt['jbt_bagian_keuangan'],
						 ),	
			
			'br9' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
						 
			'br10' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
						 					 
			'KEL_FUN_ANGGARAN' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA FUNGSI ANGGARAN</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_ANGGARAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>$dt['nm_kepala_fungsi_anggaran'],
						 ),
						 
			'nip_KEL_FUN_ANGGARAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>$dt['nip_kepala_fungsi_anggaran'],
						 ),		
			
			'JAB_KEL_FUN_ANGGARAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>$dt['jbt_kepala_fungsi_perbendaharaan'],
						 ),	
			'br11' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br12' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
			'KEL_FUN_VERIKASI' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA FUNGSI VERIKASI</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_VERIKASI' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>$dt['nm_kepala_fungsi_verikasi'],
						 ),
						 
			'nip_KEL_FUN_VERIKASI' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>$dt['nip_kepala_fungsi_verikasi'],
						 ),		
			
			'JAB_KEL_FUN_VERIKASI' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>$dt['jbt_kepala_fungsi_verikasi'],
						 ),	
			
			
			'br11' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br12' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			
			'KEL_FUN_BENDAHARA' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA FUNGSI BENDAHARA</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_BENDAHARA' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>$dt['nm_kepala_fungsi_perbendaharaan'],
						 ),
						 
			'nip_KEL_FUN_BENDAHARA' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>$dt['nip_kepala_fungsi_perbendaharaan'],
						 ),		
			
			'JAB_KEL_FUN_BENDAHARA' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>$dt['jbt_kepala_fungsi_perbendaharaan'],
						 ),	
			
			
			'br13' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br14' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),	
			
			'KEL_FUN_PEMBEKUAN' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KEPALA FUNGSI PEMBEKUAN</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_PEMBEKUAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>$dt['nm_kepala_fungsi_pembekuan'],
						 ),
						 
			'nip_KEL_FUN_PEMBEKUAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>$dt['nip_kepala_fungsi_pembekuan'],
						 ),		
						 
			'JAB_KEL_FUN_PEMBEKUAN' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>$dt['jbt_kepala_fungsi_pembekuan'],
						 ),	
			
			
			'br15' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br16' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'KUASA_BUD' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>KUASA BUD</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>$dt['nm_kuasa_bud'],
						 ),
						 
			'nip_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>$dt['nip_kuasa_bud'],
						 ),		
			
			'JAB_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>$dt['jbt_kuasa_bud'],
						 ),	
		
			'br17' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),		
			
			'br18' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'KEL_FUN_KUASA_BUD' => array( 
						'label'=>'',
						'labelWidth'=>100, 
						'value'=>'<b><u>ATASAN LANGSUNG KUASA BUD</u></b>', 
						'type'=>'merge',
						'param'=>""
						 ),
			
			'NM_KEL_FUN_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NAMA',
						'labelWidth'=>100, 
						'value'=>$dt['nm_atasan_kuasa_bud'],
						 ),
						 
			'nip_KEL_FUN_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp NIP',
						'labelWidth'=>150, 
						'value'=>$dt['nip_atasan_kuasa_bud'],
						 ),		
						 
			'JAB_KEL_FUN_KUASA_BUD' => array( 
						'label'=>'&nbsp&nbsp&nbsp&nbsp JABATAN',
						'labelWidth'=>150, 
						'value'=>$dt['jbt_atasan_kuasa_bud'],
						 ),
			);
						
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanUpload()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Batal()' >";				
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setPage_HeaderOther(){
	return "";
		
	}
			
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox		
	   <th class='th01' width='80'>Kode</th>
   	   <th class='th01' width='300'>Nama Pengguna</th>
   	   <th class='th01' width='200'>Singkatan</th>
   	   <th class='th01' width='120'>Lokasi</th>
   	   <th class='th01' width='100'>Logo Images BW</th>
   	   <th class='th01' width='100'>Logo Images Color</th>
   	   <th class='th01' width='80'>Status</th>
   	   <th class='th01' width='100'>Tanggal Create</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;

	
	 if($isi['kel_user_system']==1){
	 	$kel='ADMIN';
	 }elseif($isi['kel_user_system']==2){
	 	$kel='USER';
	 }elseif($isi['kel_user_system']==3){
	 	$kel='CUSTOMER';
	 }elseif($isi['kel_user_system']==4){
	 	$kel='PUBLIK';
	 }
	 
	 if($isi['status']==1){
	 	$status='AKTIF';
	 }elseif($isi['status']==2){
	 	$status='TIDAK AKTIF';
	 }
	
	$img=mysql_fetch_array(mysql_query("SELECT `gambar_upload`.`direktori`,`gambar_upload`.`nmfile_asli`, `gambar_upload`.`nmfile`, `gambar_upload`.`stat` FROM `managemen_pengguna` RIGHT JOIN `gambar_upload` ON `managemen_pengguna`.`Id_pengguna` = `gambar_upload`.`id_upload` WHERE `gambar_upload`.`stat` = 0 and Id_pengguna='".$isi['Id_pengguna']."' and `gambar_upload`.`jns_upload` ='6'"));
	
	 if($img != ''){
	 	$file = "<a download='".$img['nmfile_asli']."' href='Media/pengguna/".$img['nmfile']."' title='Klik Untuk Download'><img src='Media/pengguna/".$img['nmfile']."' border='0' Width='' Height='35'/></a>";
	 }else{
	 	$file='';
	 }
	 
	  $img2=mysql_fetch_array(mysql_query("SELECT `gambar_upload`.`jns_upload`,`gambar_upload`.`nmfile_asli`, `gambar_upload`.`nmfile`, `gambar_upload`.`stat` FROM `managemen_pengguna` RIGHT JOIN `gambar_upload` ON `managemen_pengguna`.`Id_pengguna` = `gambar_upload`.`id_upload` WHERE `gambar_upload`.`stat` = 0 and `gambar_upload`.`jns_upload` ='7' and Id_pengguna='".$isi['Id_pengguna']."'"));
		
	 if($img2 != ''){
	 	$file2 = "<a download='".$img2['nmfile_asli']."' href='Media/pengguna/".$img2['nmfile']."' title='Klik Untuk Download'><img src='Media/pengguna/".$img2['nmfile']."' border='0' Width='' Height='35'/></a>";
	 }else{
	 	$file2='';
	 }
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="left"',$isi['a'].'.'.$isi['b']);
	 $Koloms[] = array('align="left"',$isi['nm_pengguna']);
	 $Koloms[] = array('align="left"',$isi['nm_singkatan']);
	 $Koloms[] = array('align="left"',$isi['lokasi']);
	 $Koloms[] = array('align="center" width="60px"',$file);
	 $Koloms[] = array('align="center" width="60px"',$file2);
	 $Koloms[] = array('align="left"',$status);
	 $Koloms[] = array('align="left"',TglInd($isi['tgl_update']));
	 return $Koloms;
	}
	
	function genDaftarInitial(){
		global $HTTP_COOKIE_VARS;
		$TampilOpt = $this->genDaftarOpsi();
		
		if($HTTP_COOKIE_VARS['coSKPD']=='00'){
			$skpd=$HTTP_COOKIE_VARS['cofmSKPD'];
			$unit=$HTTP_COOKIE_VARS['cofmUNIT'];
			$subunit=$HTTP_COOKIE_VARS['cofmSUBUNIT'];
		}
		else{
			$skpd=$HTTP_COOKIE_VARS['coSKPD'];
			$unit=$HTTP_COOKIE_VARS['coUNIT'];
			$subunit=$HTTP_COOKIE_VARS['coSUBUNIT'];
		}
		
		return		
			//$NavAtas.	
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_skpd' style='position:relative'></div>".
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 
			//$vOpsi['TampilOpt'].
			"<input type='hidden' id='thn' name='thn' value='".date('Y')."'>".
			"<input type='hidden' id='bln' name='bln' value='".date('m')."'>".
			"<input type='hidden' id='skpd_penerimaanfmBidang' name='skpd_penerimaanfmBidang' value='".$skpd."'>".
			"<input type='hidden' id='skpd_penerimaanfmBagian' name='skpd_penerimaanfmBagian' value='".$unit."'>".
			"<input type='hidden' id='skpd_penerimaanfmSubBagian' name='skpd_penerimaanfmSubBagian' value='".$subunit."'>".
			"</div>".					
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".									
			"</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
			"</div>";
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 
	 $arr = array(
			array('selectBarang','Barang'),		
			);
		
	 //data order ------------------------------
	 $arrOrder = array(
			     	array('1','Barang'),
					);
	 
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	$fmBidang = cekPOST('fmBidang'); 
	$fmSKPD = cekPOST('fmSKPD'); 
	
		return array('TampilOpt'=>$TampilOpt);
	}				
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		$arrKondisi[]="status<>'2'";
		$fmBidang = $_REQUEST['fmBidang']; 
		$fmSKPD = $_REQUEST['fmSKPD']; 
		if(!($fmBidang=='' || $fmBidang=='00') ) $arrKondisi[] = "c='$fmBidang'";
		if(!($fmSKPD=='' || $fmSKPD=='00') ) $arrKondisi[] = "d='$fmSKPD'";		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
	
		$arrOrders[] = " Id_pengguna asc ";
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	
	function batal(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
		
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	  
	 	$aq = "SELECT * FROM gambar_upload WHERE id_upload = '$idplh' AND stat2='1' and jns_upload='6'";$cek .=$aq;
		$qry = mysql_query($aq);
		while($del = mysql_fetch_array($qry)){
			unlink("Media/pengguna/".$del['nmfile']);
		}
		$hapus = "DELETE FROM gambar_upload WHERE id_upload = '$idplh' AND stat2='1' and jns_upload='6'"; $cek .= ' || '.$hapus;
		$hps = mysql_query($hapus);
		
		$upd ="UPDATE gambar_upload SET stat = '0' WHERE id_upload = '$idplh' AND stat2 = '0' and jns_upload='6'";$cek .= ' ||'. $upd;
		$qryupd = mysql_query($upd);
		
		//------------------color----------------------------------
		$aq ="SELECT * FROM gambar_upload WHERE id_upload = '$idplh' AND stat2='1' and jns_upload='7'";$cek .=$aq;
		$qry = mysql_query($aq);
		while($del = mysql_fetch_array($qry)){
			unlink("Media/pengguna/".$del['nmfile']);
		}
		$hapus = "DELETE FROM gambar_upload WHERE id_upload = '$idplh' AND stat2='1' and jns_upload='7'"; $cek .= ' || '.$hapus;
		$hps = mysql_query($hapus);
		
		$upd2 = "UPDATE gambar_upload SET stat = '0' WHERE id_upload = '$idplh' AND stat2 = '0' and jns_upload='7'";$cek .= ' ||'. $upd2;
		$qryupd = mysql_query($upd2);
				
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
}
$ManagementPengguna = new ManagementPenggunaObj();
?>