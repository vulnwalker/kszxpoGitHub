<?php

class RuangObj  extends DaftarObj2{	
	var $Prefix = 'Ruang';
	var $elCurrPage="HalDefault";
	var $TblName = 'ref_ruang'; //daftar
	var $TblName_Hapus = 'ref_ruang';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');//('p','q'); //daftar/hapus
//	var $FormName = 'RuangPilih_Form';
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Data';
	var $PageIcon = 'images/masterdata_ico.gif';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pegawai.xls';
	var $Cetak_Judul = 'DAFTAR RUANG';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	
	function setTitle(){
		return 'Daftar Ruang';
	}
	
	function setCetak_Header(){
		global $Main, $HTTP_COOKIE_VARS;
		
		$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD');// echo 'fmskpd='.$fmSKPD;
		$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		$fmSEKSI = cekPOST($this->Prefix.'SkpdfmSEKSI');
		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\"><DIV ALIGN=CENTER>$this->Cetak_Judul</td>
			</tr>
			</table>	
			<table width=\"100%\" border=\"0\">
				<tr>
					<td class=\"subjudulcetak\">".PrintSKPD2($fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI)."</td>
				</tr>
			</table><br>";
	}
	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $a1 = $Main->DEF_KEPEMILIKAN;
	 $a = $Main->Provinsi[0];
	 $b = $Main->DEF_WILAYAH;
	 $kode0 = $_REQUEST['fmc1'];
     $kode1= $_REQUEST['fmc'];
	 $kode2= $_REQUEST['fmd'];
	 $kode3= $_REQUEST['fme'];
	 $kode4= $_REQUEST['fme1'];
	 $gedung = $_REQUEST['p'];
	 $ruang = $_REQUEST['q'];
	 $nm_ruang = $_REQUEST['nm_q'];
	 $nm_penanggung = $_REQUEST['nm_pegawai'];
	 $nip_penanggung = $_REQUEST['nip_pegawai'];
	 $nm_pendek = $_REQUEST['nm_pendek'];
	
	 if( $err=='' && $kode0 =='' ) $err= 'Kode Urusan Belum Di Pilih !!';
	 if( $err=='' && $kode1 =='' ) $err= 'Kode Bidang Belum Di Pilih !!';
	 if( $err=='' && $kode2 =='' ) $err= 'Kode SKPD Belum Di Pilih !!';
	 if( $err=='' && $kode3 =='' ) $err= 'Kode UNIT Belum Di Pilih !!';
	 if( $err=='' && $kode4 =='' ) $err= 'Kode SUB UNIT Belum Di Pilih !!';
	 if( $err=='' && $gedung =='' ) $err= 'Kode Gedung Belum Di Pilih !!';
	 if( $err=='' && $ruang =='' ) $err= 'Kode Ruang Belum Di Isi !!';
	 if( $err=='' && $nm_ruang =='' ) $err= 'Nama Ruang Belum Di Isi !!';
	 if( $err=='' && $nm_pendek =='' ) $err= 'Nama Ruang Pendek Belum Di Isi !!';
	 if( $err=='' && $nm_penanggung =='' ) $err= 'Nama Penanggung Jawab Belum Di Isi !!';
	 if( $err=='' && $nip_penanggung =='' ) $err= 'NIP Penanggung Jawab Belum Di Isi !!';
	
		if($fmST == 0){
			if($err==''){
				$aqry = "INSERT into ref_ruang (a1,a,b,c1,c,d,e,e1,p,q,nm_ruang,nm_pendek,nm_penanggung_jawab,nip_penanggung_jawab) values('$a1','$a','$b','$kode0','$kode1','$kode2','$kode3','$kode4','$gedung','$ruang','$nm_ruang','$nm_pendek','$nm_penanggung','$nip_penanggung')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{						
				if($err==''){
				$aqry = "UPDATE ref_skpd SET nm_skpd='$nama_skpd', nm_barcode='$nama_barcode',nm_skpd_singkatan='$nm_skpd_singkatan',alamat='$alamat',kota='$kota',nm_kop_surat='$nmkopsurata',no_telp_fax='$fax' WHERE c1='$kode0' and c='$kode1' and d='$kode2' and e='$kode3' and e1='$kode4'";	$cek .= $aqry;
						$qry = mysql_query($aqry) or die(mysql_error());
			
					}
			
			} //end else
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function simpan_4(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 $a1 = $Main->DEF_KEPEMILIKAN;
	 $a = $Main->Provinsi[0];
	 $b = $Main->DEF_WILAYAH;
     $kode1= $_REQUEST['fmc'];
	 $kode2= $_REQUEST['fmd'];
	 $kode3= $_REQUEST['fme'];
	 $kode4= $_REQUEST['fme1'];
	 $gedung = $_REQUEST['p'];
	 $ruang = $_REQUEST['q'];
	 $nm_ruang = $_REQUEST['nm_q'];
	 $nm_penanggung = $_REQUEST['nm_penanggung'];
	 $nip_penanggung = $_REQUEST['nip_penanggung'];
	 $nm_pendek = $_REQUEST['nm_pendek'];
	
	 if( $err=='' && $kode1 =='' ) $err= 'Kode Bidang Belum Di Pilih !!';
	 if( $err=='' && $kode2 =='' ) $err= 'Kode SKPD Belum Di Pilih !!';
	 if( $err=='' && $kode3 =='' ) $err= 'Kode UNIT Belum Di Pilih !!';
	 if( $err=='' && $kode4 =='' ) $err= 'Kode SUB UNIT Belum Di Pilih !!';
	 if( $err=='' && $gedung =='' ) $err= 'Kode Gedung Belum Di Pilih !!';
	 if( $err=='' && $ruang =='' ) $err= 'Kode Ruang Belum Di Isi !!';
	 if( $err=='' && $nm_ruang =='' ) $err= 'Nama Ruang Belum Di Isi !!';
	 if( $err=='' && $nm_pendek =='' ) $err= 'Nama Ruang Pendek Belum Di Isi !!';
	 if( $err=='' && $nm_penanggung =='' ) $err= 'Nama Penanggung Jawab Belum Di Isi !!';
	 if( $err=='' && $nip_penanggung =='' ) $err= 'NIP Penanggung Jawab Belum Di Isi !!';
	 
		if($fmST == 0){
			if($err==''){
				$aqry = "INSERT into ref_ruang (a1,a,b,c1,c,d,e,e1,p,q,nm_ruang,nm_pendek,nm_penanggung_jawab,nip_penanggung_jawab) values('$a1','$a','$b','0','$kode1','$kode2','$kode3','$kode4','$gedung','$ruang','$nm_ruang','$nm_pendek','$nm_penanggung','$nip_penanggung')";	$cek .= $aqry;	
					$qry = mysql_query($aqry);
				}
			}else{						
				if($err==''){
				$aqry = "UPDATE ref_skpd SET nm_skpd='$nama_skpd', nm_barcode='$nama_barcode',nm_skpd_singkatan='$nm_skpd_singkatan',alamat='$alamat',kota='$kota',nm_kop_surat='$nmkopsurata',no_telp_fax='$fax' WHERE c1='$kode0' and c='$kode1' and d='$kode2' and e='$kode3' and e1='$kode4'";	$cek .= $aqry;
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
			case 'cbxgedung':{
				$c1= $_REQUEST[$this->Prefix.'SkpdfmURUSAN'];
				$c= $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
				$d= $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
				$e= $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
				$e1= $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
				if($c1=='' || $c1 =='0') {
					$kondC1='';
				}else{
					$kondC1 = "and c1 = '$c1'";
				}if($c=='' || $c =='00') {
					$kondC='';
				}else{
					$kondC = "and c = '$c'";
				}
				if($d=='' || $d =='00') {
					$kondD='';
				}else{
					$kondD = "and d = '$d'";
				}
				if($e=='' || $e =='00') {
					$kondE='';
				}else{
					$kondE = "and e = '$e'";
				}
				if($e1=='' || $e1 =='00' || $e1 =='000') {
					$kondE1='';
				}else{
					$kondE1 = "and e1 = '$e1'";
				}

				$aqry = "select * from ref_ruang where q='0000'  $kondC1 $kondC $kondD $kondE $kondE1";
				$cek .= $aqry;
				$content = genComboBoxQry( 'fmPILGEDUNG', $fmPILGEDUNG, 
						$aqry,
						'p', 'nm_ruang', '-- Semua Gedung --',"style='width:140'" );
				break;
			}		
			
			case 'formBaruPil':{				
				$fm = $this->setFormBaruPil();				
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
			
			case 'hapus':{	
				$fm= $this->Hapus($pil);
				$err= $fm['err']; 
				$cek = $fm['cek'];
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
			
			case 'pilihUrusan':{				
			global $Main;
			
			$c1 = cekPOST($this->Prefix.'SkpdfmURUSAN');
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
			
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$queryc="SELECT c, concat(c, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c<>'00' and d = '00' and e='00' and e1='000'" ;$cek.=$queryc;
			$content->unit=cmbQuery('fmc',$fmc,$queryc,'style="width:500px;"onchange="'.$this->Prefix.'.pilihBidang()"','-------- Pilih Kode BIDANG ------------');
			
			$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d <> '00' and e='00' and e1='000'" ;$cek.=$queryd;
			$content->bid=cmbQuery('fmd',$fmd,$queryd,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSKPD()"','-------- Pilih Kode SKPD ----------------');
			
			$querye="SELECT e, concat(e,' . ', nm_skpd) as vnama  FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e<>'00' and e1='000'" ;$cek.=$querye;
			$content->skp=cmbQuery('fme',$fme,$querye,'style="width:500px;"onchange="'.$this->Prefix.'.pilihUnit()"','-------- Pilih Kode UNIT -----------------');
			
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->sub1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubUnit()"','-------- Pilih Kode SUB UNIT -----------------');
			
	 		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}
			
			case 'pilihUrusanPil':{				
			global $Main,$RuangPilih;
			
			$c1 = cekPOST($this->Prefix.'SkpdfmURUSAN');
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
			
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$queryc="SELECT c, concat(c, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c<>'00' and d = '00' and e='00' and e1='000'" ;$cek.=$queryc;
			$content->unit=cmbQuery('fmc',$fmc,$queryc,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihBidangPil()"','-------- Pilih Kode BIDANG ------------');
			
			$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d <> '00' and e='00' and e1='000'" ;$cek.=$queryd;
			$content->bid=cmbQuery('fmd',$fmd,$queryd,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihSKPDPil()"','-------- Pilih Kode SKPD ----------------');
			
			$querye="SELECT e, concat(e,' . ', nm_skpd) as vnama  FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e<>'00' and e1='000'" ;$cek.=$querye;
			$content->skp=cmbQuery('fme',$fme,$querye,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihUnitPil()"','-------- Pilih Kode UNIT -----------------');
			
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->sub1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihSubUnitPil()"','-------- Pilih Kode SUB UNIT -----------------');
			
	 		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}
			
			case 'pilihBidang':{				
			global $Main;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
	 
			$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d <> '00' and e='00' and e1='000'" ;$cek.=$queryd;
			$content->bid=cmbQuery('fmd',$fmd,$queryd,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSKPD()"','-------- Pilih Kode SKPD ----------------');$cek.=$queryJenis;
	 
	 		$querye="SELECT e, concat(e,' . ', nm_skpd) as vnama  FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e<>'00' and e1='000'" ;$cek.=$querye;
			$content->skp=cmbQuery('fme',$fme,$querye,'style="width:500px;"onchange="'.$this->Prefix.'.pilihUnit()"','-------- Pilih Kode UNIT -----------------');$cek.=$queryJenis;
			
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->sub1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubUnit()"','-------- Pilih Kode SUB UNIT -----------------');$cek.=$queryJenis;
			
	 		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);											break;
			}
			
			case 'pilihBidangPil':{				
			global $Main,$RuangPilih;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
	 
			$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d <> '00' and e='00' and e1='000'" ;$cek.=$queryd;
			$content->bid=cmbQuery('fmd',$fmd,$queryd,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihSKPDPil()"','-------- Pilih Kode SKPD ----------------');$cek.=$queryJenis;
	 
	 		$querye="SELECT e, concat(e,' . ', nm_skpd) as vnama  FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e<>'00' and e1='000'" ;$cek.=$querye;
			$content->skp=cmbQuery('fme',$fme,$querye,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihUnitPil()"','-------- Pilih Kode UNIT -----------------');$cek.=$queryJenis;
			
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->sub1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihSubUnitPil()"','-------- Pilih Kode SUB UNIT -----------------');$cek.=$queryJenis;
			
			
	 		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);											break;
			}
				
			case 'pilihSKPD':{				
			global $Main;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		 
			$querye="SELECT e, concat(e,' . ', nm_skpd) as vnama  FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e<>'00' and e1='000'" ;$cek.=$querye;
			$content->skp=cmbQuery('fme',$fme,$querye,'style="width:500px;"onchange="'.$this->Prefix.'.pilihUnit()"','-------- Pilih Kode UNIT -----------------');$cek.=$queryJenis;
		 	
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->sub1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubUnit()"','-------- Pilih Kode SUB UNIT -----------------');$cek.=$queryJenis;
				
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									
			break;
			}
		
			case 'pilihSKPDPil':{				
			global $Main,$RuangPilih;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		 
			$querye="SELECT e, concat(e,' . ', nm_skpd) as vnama  FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e<>'00' and e1='000'" ;$cek.=$querye;
			$content->skp=cmbQuery('fme',$fme,$querye,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihUnitPil()"','-------- Pilih Kode UNIT -----------------');$cek.=$queryJenis;
		 	
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->sub1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihSubUnitPil()"','-------- Pilih Kode SUB UNIT -----------------');$cek.=$queryJenis;
				
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									
			break;
			}	
			
			case 'pilihUnit':{				
			global $Main;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		 
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->sub1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubUnit()"','-------- Pilih Kode SUB UNIT -----------------');$cek.=$queryJenis;
		 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}	
		
			case 'pilihUnitPil':{				
			global $Main,$RuangPilih;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		 
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->sub1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihSubUnitPil()"','-------- Pilih Kode SUB UNIT -----------------');$cek.=$queryJenis;
		 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}	
		
			case 'pilihSubUnit':{				
			global $Main;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		 
			$queryKE1="SELECT p, concat(p,' . ', nm_ruang) as vnama FROM ref_ruang WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and p!='000' and q='0000'" ;$cek.=$queryKE1;
			$content->unit=cmbQuery('p',$gd,$queryKE1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihGedung()"','-------- Pilih Kode Gedung -----------------')."&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruGedung()' title='Kode UNIT' >";$cek.=$queryJenis;
		 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									
			break;
			}		
	
			case 'pilihSubUnitPil':{				
			global $Main,$RuangPilih;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		 
			$queryKE1="SELECT p, concat(p,' . ', nm_ruang) as vnama FROM ref_ruang WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and p!='000' and q='0000'" ;$cek.=$queryKE1;
			
			$content->unit=cmbQuery('p',$gd,$queryKE1,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihGedungPil()"','-------- Pilih Kode Gedung -----------------')."&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$RuangPilih->Prefix.".BaruGedungPil()' title='Baru Gedung' >";$cek.=$queryJenis;
		 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									
			break;
			}		
	
			case 'pilihGedung':{				
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
			$gedung = $_REQUEST['p'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		
			$queryKF="SELECT max(q)as q, nm_ruang FROM ref_ruang WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and p= '$gedung'" ;
			
			$content->unit=cmbQuery('fmKE',$fmke,$queryKF,'style="width:210;"onchange="'.$this->Prefix.'.pilihGedung()"','&nbsp&nbsp-------- Pilih Sub Rincian Objek --------')."&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruJenis()' title='Baru' >";$cek.=$queryJenis;
		 
		 	$get=mysql_fetch_array(mysql_query($queryKF));
			$lastkode=$get['q'] + 1;
			$kode_ke = sprintf("%04s", $lastkode);
			$content->q=$kode_ke;
		 
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									
			break;
			} 
		
			case 'pilihGedungPil':{				
			global $Main,$RuangPilih;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
			$gedung = $_REQUEST['p'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		
			$queryKF="SELECT max(q)as q, nm_ruang FROM ref_ruang WHERE c1='$c1' and c='$c' and d = '$d' and e='$e' and e1='$e1' and p= '$gedung'" ;
			
			$content->unit=cmbQuery('fmKE',$fmke,$queryKF,'style="width:210;"onchange="'.$RuangPilih->Prefix.'.pilihGedung()"','&nbsp&nbsp-------- Pilih Sub Rincian Objek --------')."&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$RuangPilih->Prefix.".BaruJenis()' title='Baru' >";$cek.=$queryJenis;
		 
		 	$get=mysql_fetch_array(mysql_query($queryKF));
			$lastkode=$get['q'] + 1;
			$kode_ke = sprintf("%04s", $lastkode);
			$content->q=$kode_ke;
		 
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									
			break;
			} 
			
			case 'pilihRuangKIR' :{				
				$fmPILGEDUNG = $_REQUEST['fmPILGEDUNG'];
				
				$arrkond = array();
				$arrkond = explode(' ',$fmPILGEDUNG);	
				$c1 = $arrkond[0];$c = $arrkond[1]; $d = $arrkond[2]; 
				$e = $arrkond[3];$e1 = $arrkond[4]; $p = $arrkond[5];
				
				$arrkond = array();
				$arrkond[] =  "q<>'0000'";
				$arrkond[] = " c = '$c' ";
				$arrkond[] = " d = '$d' ";
				$arrkond[] = " e = '$e' ";
				$arrkond[] = " e1 = '$e1' ";
				$arrkond[] = " p = '$p' ";
				$Kondisi = join(' and ',$arrkond);
				
				if($Kondisi != '') $Kondisi = ' where '.$Kondisi;
				$aqry = "select * from ref_ruang $Kondisi";
				$cek .= $aqry;
				$content = genComboBoxQry2( 'fmPILRUANG', $fmPILRUANG, $aqry,
						array('c1','c','d','e','e1','p','q'), 'nm_ruang', '-- Semua Ruang --',"style=''  onChange=\"Penatausaha.refreshList(true);Penatausaha.tampilPJRuang();\" " );				
				break;
				return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									
			
			}
		 	case 'tampilPJruang':{				
			$fmPILRUANG = $_REQUEST['fmPILRUANG'];
				
				$arrkond = array();
				$arrkond = explode(' ',$fmPILRUANG);	
				$c1 = $arrkond[0]; $c = $arrkond[1]; $d = $arrkond[2]; 
				$e = $arrkond[3]; $e1 = $arrkond[4]; $p = $arrkond[5];
				$q = $arrkond[6];
				$arrkond = array();				
				$arrkond[] = " c1 = '$c1' ";
				$arrkond[] = " c = '$c' ";
				$arrkond[] = " d = '$d' ";
				$arrkond[] = " e = '$e' ";
				$arrkond[] = " e1 = '$e1' ";
				$arrkond[] = " p = '$p' ";
				$arrkond[] = " q = '$q' ";
				$Kondisi = join(' and ',$arrkond);
				if($Kondisi != '') $Kondisi = ' where '.$Kondisi;
				$aqry = "select * from ref_ruang $Kondisi"; $cek .= $aqry;
				$ruang = mysql_fetch_array(mysql_query($aqry));
				$pgwnm = $ruang['nm_penanggung_jawab'];
				$pgwnip = $ruang['nip_penanggung_jawab'];
				
				$hsl->nip = $pgwnip;
				$hsl->nama = $pgwnm;
				
				$content = $hsl;
				break;
			}
			case 'formBaruGedung':{				
			$fm = $this->setFormBaruGedung();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];		
													
			break;
			}
		
			case 'formBaruGedungPil':{				
			$fm = $this->setFormBaruGedungPil();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
			break;
			}	
		
			case 'simpanGedung':{
			$get= $this->simpanGedung();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
			break;
		    }
		
			case 'simpanGedungPil':{
			$get= $this->simpanGedungPil();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
			break;
		    }
		
			case 'refreshGedung':{
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
		
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$gedungnew= $_REQUEST['id_GedungBaru'];
		 
			$queryGedung="SELECT p, concat(p, '. ', nm_ruang) as vnama FROM ref_ruang WHERE c1='$c1' and c= '$c' and d='$d' and e='$e' and e1='$e1'" ;
			
			$cek.="SELECT p, concat(p, '. ', nm_ruang) as vnama FROM ref_ruang WHERE c1='$c1' and c= '$c' and d='$d' and e='$e' and e1='$e1'";
			
			$content->unit=cmbQuery('p',$gedungnew,$queryGedung,'style="width:500px;"onchange="'.$this->Prefix.'.pilihGedung()"','&nbsp&nbsp-------- Pilih Kode Gedung -----------')."&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruGedung()' title='Baru' >";
		 	 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
			break;
		    }
		
			case 'refreshGedungPil':{
			global $Main,$RuangPilih;
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
		
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$gedungnew= $_REQUEST['id_GedungBaru'];
		 
			$queryGedung="SELECT p, concat(p, '. ', nm_ruang) as vnama FROM ref_ruang WHERE c1='$c1' and c= '$c' and d='$d' and e='$e' and e1='$e1'" ;
			
			$cek.="SELECT p, concat(p, '. ', nm_ruang) as vnama FROM ref_ruang WHERE c1='$c1' and c= '$c' and d='$d' and e='$e' and e1='$e1'";
			
			$content->unit=cmbQuery('p',$gedungnew,$queryGedung,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihGedung()"','&nbsp&nbsp-------- Pilih Kode Gedung -----------')."&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$RuangPilih->Prefix.".BaruGedung()' title='Baru' >";
		 	 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
			break;
		    }		
	
			case 'getGedung':{
			
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
			$gedung = $_REQUEST['p'];;
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$gedungnew= $_REQUEST['id_GedungBaru'];
		 
		 	$aqry5="SELECT MAX(q) AS maxno FROM ref_ruang WHERE c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$gedung'";
		 	$cek.="SELECT MAX(q) AS maxno FROM ref_ruang WHERE c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$gedung'";
			$get=mysql_fetch_array(mysql_query($aqry5));
			$newke=$get['maxno'] + 1;
			$newke1 = sprintf("%04s", $newke);
			$content->q=$newke1;	
		
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
			break;
		    }
		
			case 'getGedungPil':{
			global $RuangPilih;
			$c1 = $_REQUEST['fmc1'];
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
			$gedung = $_REQUEST['p'];;
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$gedungnew= $_REQUEST['id_GedungBaru'];
		 
		 	$aqry5="SELECT MAX(q) AS maxno FROM ref_ruang WHERE c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$gedung'";
		 	$cek.="SELECT MAX(q) AS maxno FROM ref_ruang WHERE c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$gedung'";
			$get=mysql_fetch_array(mysql_query($aqry5));
			$newke=$get['maxno'] + 1;
			$newke1 = sprintf("%04s", $newke);
			$content->q=$newke1;	
		
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
			break;
		    }
		
			case 'simpanEditGedung':{
				$get= $this->simpanEditGedung();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		   }
	   
		   case 'simpanEditGedungPil':{
				$get= $this->simpanEditGedungPil();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		   }
	   
		   	case 'simpanEditRuang':{
				$get= $this->simpanEditRuang();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		   }
	   	
			case 'getdata':{
				$id = $_REQUEST['id'];
				$aqry = "select aa.*, bb.nm_ruang as nm_gedung from ref_ruang aa 
					left join ref_ruang bb on aa.a1=bb.a1 and aa.a=bb.a and aa.b=bb.b 
					and aa.c=bb.c and aa.d=bb.d and aa.e=bb.e and aa.e1=bb.e1 
					and aa.p=bb.p and bb.q='0000'
					where aa.id='$id'";
				$get = mysql_fetch_array(mysql_query($aqry));				
				$content = array('id'=>$get['id'], 'p'=>$get['p'], 'q'=>$get['q'], 'nm_ruang'=>$get['nm_ruang'], 'nm_gedung'=>$get['nm_gedung']);
				break;
			}
			
			case 'pilihBidang_4':{				
		
			$c = $_REQUEST['fmc'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		 
			$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd WHERE c='$c' and d !='00' and e='00' and e1='000'" ;$cek.=$queryd;
			$content->bid=cmbQuery('fmd',$fmd,$queryd,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSKPD_4()"','-------- Pilih Kode SKPD ----------------');$cek.=$queryJenis;
			
			$querye="SELECT e, concat(e,' . ', nm_skpd) as vnama  FROM ref_skpd WHERE c='$c' and d='$d' and e<>'00' and e1='000'" ;$cek.=$querye;
			$content->skp=cmbQuery('fme',$fme,$querye,'style="width:500px;"onchange="'.$this->Prefix.'.pilihUnit_4()"','-------- Pilih Kode UNIT -----------------');$cek.=$queryJenis;
			
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->sub1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubUnit_4()"','-------- Pilih Kode SUB UNIT -----------------');$cek.=$queryJenis;
		 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);											break;
			}
			
			case 'pilihSKPD_4':{				
			
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		 
			$querye="SELECT e, concat(e,' . ', nm_skpd) as vnama  FROM ref_skpd WHERE c='$c' and d='$d' and e<>'00' and e1='000'" ;$cek.=$querye;
			$content->skp=cmbQuery('fme',$fme,$querye,'style="width:500px;"onchange="'.$this->Prefix.'.pilihUnit_4()"','-------- Pilih Kode UNIT -----------------');$cek.=$queryJenis;
		 
		 	$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->sub1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubUnit_4()"','-------- Pilih Kode SUB UNIT -----------------');$cek.=$queryJenis;
		 	
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									
			break;
			}
			
			case 'pilihUnit_4':{				
			
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		 
			$queryKE1="SELECT e1, concat(e1,' . ', nm_skpd) as vnama FROM ref_skpd WHERE c='$c' and d = '$d' and e='$e' and e1!='000'" ;$cek.=$queryKE;
			$content->sub1=cmbQuery('fme1',$fme1,$queryKE1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubUnit_4()"','-------- Pilih Kode SUB UNIT -----------------');$cek.=$queryJenis;
		 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);								
			break;
			}	
			
			case 'pilihSubUnit_4':{				
			
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		 
			$queryKE1="SELECT p, concat(p,' . ', nm_ruang) as vnama FROM ref_ruang WHERE c1='0' and c='$c' and d = '$d' and e='$e' and e1='$e1' and p!='000' and q='0000'" ;$cek.=$queryKE1;
			$content->unit=cmbQuery('p',$gd,$queryKE1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihGedung_4()"','-------- Pilih Kode Gedung -----------------')."&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruGedung_4()' title='Baru' >";$cek.=$queryJenis;
		 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									
			break;
			}
		
			case 'pilihGedung_4':{				
			
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
			$gedung = $_REQUEST['p'];
			$cek = ''; $err=''; $content=''; $json=TRUE;
		
			$queryKF="SELECT max(q)as q, nm_ruang FROM ref_ruang WHERE c='$c' and d = '$d' and e='$e' and e1='$e1' and p= '$gedung'" ;$cek.=$queryKF;
			$content->unit=cmbQuery('fmKE',$fmke,$queryKF,'style="width:210;"onchange="'.$this->Prefix.'.pilihGedung_4()"','&nbsp&nbsp-------- Pilih Sub Rincian Objek --------')."&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruJenis()' title='Baru' >";$cek.=$queryJenis;
		 
		 	$get=mysql_fetch_array(mysql_query($queryKF));
			$lastkode=$get['q'] + 1;
			$kode_ke = sprintf("%04s", $lastkode);
			$content->q=$kode_ke;
		 
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);									
			break;
			}
		
			case 'formBaruGedung_4':{				
			
			$fm = $this->setFormBaruGedung_4();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
			break;
			}	
			
			case 'simpanGedung_4':{
			
			$get= $this->simpanGedung_4();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
			break;
		    } 
		
			case 'refreshGedung_4':{
			
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
		
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$gedungnew= $_REQUEST['id_GedungBaru'];
		 
			$queryGedung="SELECT p, concat(p, '. ', nm_ruang) as vnama FROM ref_ruang WHERE  c1='0' and c= '$c' and d='$d' and e='$e' and e1='$e1'" ;
			$content->unit=cmbQuery('p',$gedungnew,$queryGedung,'style="width:500px;"onchange="'.$this->Prefix.'.pilihGedung_4()"','&nbsp&nbsp-------- Pilih Kode Gedung -----------')."&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruGedung_4()' title='Baru' >";
		 	 
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
			break;
		    }	
		
			case 'getGedung_4':{
			
			$c = $_REQUEST['fmc'];
			$d = $_REQUEST['fmd'];
			$e = $_REQUEST['fme'];
			$e1 = $_REQUEST['fme1'];
			$gedung = $_REQUEST['p'];;
			$cek = ''; $err=''; $content=''; $json=TRUE;
			$gedungnew= $_REQUEST['id_GedungBaru'];
		 
		 	$aqry5="SELECT MAX(q) AS maxno FROM ref_ruang WHERE c1='0' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$gedung'";
			$get=mysql_fetch_array(mysql_query($aqry5));
			$newke=$get['maxno'] + 1;
			$newke1 = sprintf("%04s", $newke);
			$content->q=$newke1;	
		
		 	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
			break;
		    }
		
			case 'simpan_4':{
				$get= $this->simpan_4();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		    }			
			
			case 'simpanEditGedung_4':{
				$get= $this->simpanEditGedung_4();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
		   }
		
			 case 'simpanEditRuang_4':{
				$get= $this->simpanEditRuang_4();
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
			/*default:{
				$err = 'tipe tidak ada!';
				break;
			}*/
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function setPage_OtherScript(){
		$scriptload = 

					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			 "<script src='js/skpd.js' type='text/javascript'></script>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/upload_style.css' type='text/css'>".
			"<script src='js/jquery.js' type='text/javascript'></script>".			
			"<script src='js/jquery-ui.js' type='text/javascript'></script>".
			"<script src='js/jquery.min.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/jquery.form.js'></script> ".
			"<script src='js/jquery-ui.custom.js'></script>".
			"<script type='text/javascript' src='js/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/fnCariPegawai.js' language='JavaScript' ></script>
			 ".
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".
			
			$scriptload;
	}
	
	function setFormBaruGedung_4(){
		$dt=array();
		$this->form_fmST = 0;
		$fm = $this->BaruGedung_4($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function BaruGedung_4($dt){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 700;
	 $this->form_height = 200;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'FORM BARU GEDUNG';
		$nip	 = '';
		$c = $_REQUEST['fmc'];
		$d = $_REQUEST['fmd'];
		$e = $_REQUEST['fme'];
		$e1 = $_REQUEST['fme1'];
			
		$aqry2="SELECT MAX(p) AS maxno FROM ref_ruang WHERE c1='0' and c='$c' and d='$d' and e='$e' and e1='$e1'";
	
		$get=mysql_fetch_array(mysql_query($aqry2));
		$new=$get['maxno'] + 1;
		$gedung = sprintf("%03s", $new);
		
		//---------query------------
		$queryc=mysql_fetch_array(mysql_query("SELECT c, nm_skpd FROM ref_skpd where c='$c' and d=00 and e=00 and e1=000"));  
		$queryd=mysql_fetch_array(mysql_query("SELECT d, nm_skpd FROM ref_skpd where c='$c' and d='$d' and e=00 and e1=000"));  
		$querye=mysql_fetch_array(mysql_query("SELECT e, nm_skpd FROM ref_skpd where c='$c' and d='$d' and e='$e' and e1=000"));  
		$querye1=mysql_fetch_array(mysql_query("SELECT e1, nm_skpd FROM ref_skpd where c='$c' and d='$d' and e='$e' and e1='$e1'"));  
		
		$datac=$queryc['c'].".".$queryc['nm_skpd'];
		$datad=$queryd['d'].".".$queryd['nm_skpd'];
		$datae=$querye['e'].".".$querye['nm_skpd'];
		$datae1=$querye1['e1'].".".$querye1['nm_skpd'];
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			
			'bidang' => array( 
						'label'=>'KODE BIDANG',
						'labelWidth'=>150, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='dc' id='dc' value='".$datac."' style='width:400px;' readonly>
						<input type ='hidden' name='c' id='c' value='".$queryc['c']."'>
						</div>", 
						 ),	
						 
			'skpd' => array( 
						'label'=>'KODE SKPD',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='dd' id='dd' value='".$datad."' style='width:400px;' readonly>
						<input type ='hidden' name='d' id='d' value='".$queryd['d']."'>
						</div>", 
						 ),	
						 
			'unit' => array( 
						'label'=>'Kode UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='de' id='de' value='".$datae."' style='width:400px;' readonly>
						<input type ='hidden' name='e' id='e' value='".$querye['e']."'>
						</div>", 
						 ),	
						 
			'subunit' => array( 
						'label'=>'KODE SUB UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='de1' id='de1' value='".$datae1."' style='width:400px;' readonly>
						<input type ='hidden' name='e1' id='e1' value='".$querye1['e1']."'>
						</div>", 
						 ),				 			 			 
									 			
			'gedung' => array( 
						'label'=>'Kode GEDUNG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='gedung' id='gedung' value='".$gedung."' style='width:50px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Gedung' style='width:445px;'>
						</div>", 
						 ),		
			
			'nm_gedung_pendek' => array(
						'label'=>'NAMA GEDUNG PENDEK',
						'value'=>$dt['nm_pendek'],
						'type'=>'text',
						'param'=>" maxlength=15 title='Nama Gedung Pendek (ex: Gedung Sate)' placeholder='Nama Gedung Pendek' style='width: 255px;'"
						),
						
			'penanggung' => array( 
						'label'=>'PENANGGUNG JAWAB',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='nm_penanggung' id='nm_penanggung' value='".$dt['nm_skpd_singkatan']."' placeholder='Nama' style='width:255px;'>&nbsp&nbsp
						<input type='text' name='nip_penanggung' id='nip_penanggung' value='".$dt['nm_skpd_singkatan']."' placeholder='NIP' style='width:235px;'>
						</div>", 
						 ),				 				
			
			'Add' => array( 
						'label'=>'',
						'value'=>"<div id='Add'></div>",
						'type'=>'merge'
					 )			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanGedung_4()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormGedung_4();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function genFormGedung_4($withForm=TRUE, $params=NULL, $center=TRUE){	
		$form_name = $this->Prefix.'_KBform';	
		
		if($withForm){
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
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
					$this->form_menu_bawah_height,'',$params).
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
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
					$this->form_menu_bawah_height,'',$params
				);
		}
		
		if($center){
			$form = centerPage( $form );	
		}
		return $form;
	}
	
	function Hapus($ids){ //validasi hapus tbl_sppd
	global $HTTP_COOKIE_VARS;		
	
		$err=''; $cek='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		
		$co_c1=$HTTP_COOKIE_VARS['coURUSAN'];
		$co_c=$HTTP_COOKIE_VARS['coSKPD'];
		$co_d=$HTTP_COOKIE_VARS['coUNIT'];
		$co_e=$HTTP_COOKIE_VARS['coSUBUNIT'];
		$co_e1=$HTTP_COOKIE_VARS['coSEKSI'];
		
		if ($err ==''){
		for($i = 0; $i<count($ids); $i++){	

		$t1 = substr($ids[$i], 0,1);
		$t2 = substr($ids[$i], 1,1);
		$t3 = substr($ids[$i], 2,2);
		$t4 = substr($ids[$i], 4,2);
		$t5 = substr($ids[$i], 6,2);
		$t6 = substr($ids[$i], 8,3);
		$t7 = substr($ids[$i], 11,3);
		$t8 = substr($ids[$i], 14,4);
	
		if($co_c1 == 0 && $co_c == 00 && $co_d == 00 && $co_e==00 && $co_e1==000){
			
		if ($t7 != '000'){
			$sk1="select c1,c,d,e,e1,p,q from ref_ruang where c1='$t2' and c='$t3' and d='$t4' and e='$t5' and e1='$t6' and p='$t7' and q!='0000'";
		}
		
		if ($t8=='0000'){
			$qrycek=mysql_query($sk1);$cek.=$sk1;
			if(mysql_num_rows($qrycek)>0)$err='Gedung data tidak bisa di hapus karena ada data Ruang';
		}
		
		if($err=='' ){
			$qy = "DELETE FROM ref_ruang WHERE c1='$t2' and c='$t3' and d='$t4'  and  e='$t5' and e1='$t6' and p='$t7' and q='$t8' and id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}			
		}elseif($co_c1 ==$t2 && $co_c !=$t3 && $co_d!=$t4 && $co_e!=$t5 && $co_e1!=$t6){
		
		if ($t7 != '000'){
			$sk1="select c1,c,d,e,e1,p,q from ref_ruang where c1='$t2' and c='$t3' and d='$t4' and e='$t5' and e1='$t6' and p='$t7' and q!='0000'";
		}
		
		if ($t8=='0000'){
			$qrycek=mysql_query($sk1);$cek.=$sk1;
			if(mysql_num_rows($qrycek)>0)$err='Gedung data tidak bisa di hapus karena ada data Ruang';
		}
		
		if($err=='' ){
			$qy = "DELETE FROM ref_ruang WHERE c1='$t2' and c='$t3' and d='$t4'  and  e='$t5' and e1='$t6' and p='$t7' and q='$t8' and id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		
		}elseif($co_c1 ==$t2 && $co_c ==$t3 && $co_d!=$t4 && $co_e!=$t5 && $co_e1!=$t6){
		
		if ($t7 != '000'){
			$sk1="select c1,c,d,e,e1,p,q from ref_ruang where c1='$t2' and c='$t3' and d='$t4' and e='$t5' and e1='$t6' and p='$t7' and q!='0000'";
		}
		
		if ($t8=='0000'){
			$qrycek=mysql_query($sk1);$cek.=$sk1;
			if(mysql_num_rows($qrycek)>0)$err='Gedung data tidak bisa di hapus karena ada data Ruang';
		}
		
		if($err=='' ){
			$qy = "DELETE FROM ref_ruang WHERE c1='$t2' and c='$t3' and d='$t4'  and  e='$t5' and e1='$t6' and p='$t7' and q='$t8' and id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		
		}elseif($co_c1 ==$t2 && $co_c ==$t3 && $co_d==$t4 && $co_e!=$t5 && $co_e1!=$t6){
		
		if ($t7 != '000'){
			$sk1="select c1,c,d,e,e1,p,q from ref_ruang where c1='$t2' and c='$t3' and d='$t4' and e='$t5' and e1='$t6' and p='$t7' and q!='0000'";
		}
		
		if ($t8=='0000'){
			$qrycek=mysql_query($sk1);$cek.=$sk1;
			if(mysql_num_rows($qrycek)>0)$err='Gedung data tidak bisa di hapus karena ada data Ruang';
		}
		
		if($err=='' ){
			$qy = "DELETE FROM ref_ruang WHERE c1='$t2' and c='$t3' and d='$t4'  and  e='$t5' and e1='$t6' and p='$t7' and q='$t8' and id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		
		}elseif($co_c1 ==$t2 && $co_c ==$t3 && $co_d==$t4 && $co_e==$t5 && $co_e1!=$t6){
		
		if ($t7 != '000'){
			$sk1="select c1,c,d,e,e1,p,q from ref_ruang where c1='$t2' and c='$t3' and d='$t4' and e='$t5' and e1='$t6' and p='$t7' and q!='0000'";
		}
		
		if ($t8=='0000'){
			$qrycek=mysql_query($sk1);$cek.=$sk1;
			if(mysql_num_rows($qrycek)>0)$err='Gedung data tidak bisa di hapus karena ada data Ruang';
		}
		
		if($err=='' ){
			$qy = "DELETE FROM ref_ruang WHERE c1='$t2' and c='$t3' and d='$t4'  and  e='$t5' and e1='$t6' and p='$t7' and q='$t8' and id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		
		}elseif($co_c1 ==$t2 && $co_c !=$t3 && $co_d==$t4 && $co_e==$t5 && $co_e1==$t6){
		
		if ($t7 != '000'){
			$sk1="select c1,c,d,e,e1,p,q from ref_ruang where c1='$t2' and c='$t3' and d='$t4' and e='$t5' and e1='$t6' and p='$t7' and q!='0000'";
		}
		
		if ($t8=='0000'){
			$qrycek=mysql_query($sk1);$cek.=$sk1;
			if(mysql_num_rows($qrycek)>0)$err='Gedung data tidak bisa di hapus karena ada data Ruang';
		}
		
		if($err=='' ){
			$qy = "DELETE FROM ref_ruang WHERE c1='$t2' and c='$t3' and d='$t4'  and  e='$t5' and e1='$t6' and p='$t7' and q='$t8' and id ='".$ids[$i]."' ";$cek.=$qy;
			$qry = mysql_query($qy);		
			}else{
				break;
			}
		
		}else{
			$err="Data Tidak Bisa di Hapus !!";	
			
			
		}
		
		}//for
		}
		return array('err'=>$err,'cek'=>$cek);
	}	  
	
	function setFormBaruGedung(){
		$dt=array();
		$this->form_fmST = 0;
		$fm = $this->BaruGedung($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormBaruGedungPil(){
		$dt=array();
		$this->form_fmST = 0;
		$fm = $this->BaruGedungPil($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function simpanGedung(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		
		$a1= $Main->DEF_KEPEMILIKAN;
		$a= $Main->DEF_PROPINSI;
		$b= $Main->DEF_WILAYAH;
		$c1= $_REQUEST['c1'];
		$c= $_REQUEST['c'];
		$d= $_REQUEST['d'];
		$e= $_REQUEST['e'];
		$e1= $_REQUEST['e1'];
		$gedung= $_REQUEST['gedung'];
		$nama= $_REQUEST['nama'];
		$nm_gedung_pendek= $_REQUEST['nm_gedung_pendek'];
		$nm_penanggung = $_REQUEST['nm_penanggung'];
	 	$nip_penanggung = $_REQUEST['nip_penanggung'];
	
		$nama= $_REQUEST['nama'];
	if( $err=='' && $nama =='' ) $err= 'Nama Kode Gedung Belum Di Isi !!';
	if( $err=='' && $nm_gedung_pendek =='' ) $err= 'Nama Gedung Pendek Belum Di Isi !!';
	/*if( $err=='' && $nm_penanggung =='' ) $err= 'Nama Nama Penanggung Jawab Belum Di Isi !!';
	if( $err=='' && $nip_penanggung =='' ) $err= 'Nama NIP Penanggung Jawab Belum Di Isi !!';*/
	
		if($fmST == 0){
			if($err==''){
				$aqry = "INSERT into ref_ruang (a1,a,b,c1,c,d,e,e1,p,q,nm_ruang,nm_pendek) values('$a1','$a','$b','$c1','$c','$d','$e','$e1','$gedung','0000','$nama','$nm_gedung_pendek')";	
				$cek .= $aqry;	
				$qry = mysql_query($aqry);
				$content=$gedung;	
				}
			}
				
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function simpanGedungPil(){
	global $HTTP_COOKIE_VARS;
	global $Main,$RuangPilih;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = $_REQUEST[$RuangPilih->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$RuangPilih->Prefix.'_idplh'];
		
		$a1= $Main->DEF_KEPEMILIKAN;
		$a= $Main->DEF_PROPINSI;
		$b= $Main->DEF_WILAYAH;
		$c1= $_REQUEST['c1'];
		$c= $_REQUEST['c'];
		$d= $_REQUEST['d'];
		$e= $_REQUEST['e'];
		$e1= $_REQUEST['e1'];
		$gedung= $_REQUEST['gedung'];
		$nama= $_REQUEST['nama'];
		$nm_gedung_pendek= $_REQUEST['nm_gedung_pendek'];
		$nm_penanggung = $_REQUEST['nm_penanggung'];
	 	$nip_penanggung = $_REQUEST['nip_penanggung'];
	
		$nama= $_REQUEST['nama'];
	if( $err=='' && $nama =='' ) $err= 'Nama Kode Gedung Belum Di Isi !!';
	if( $err=='' && $nm_gedung_pendek =='' ) $err= 'Nama Gedung Pendek Belum Di Isi !!';
	/*if( $err=='' && $nm_penanggung =='' ) $err= 'Nama Nama Penanggung Jawab Belum Di Isi !!';
	if( $err=='' && $nip_penanggung =='' ) $err= 'Nama NIP Penanggung Jawab Belum Di Isi !!';*/
	
		if($fmST == 0){
			if($err==''){
				$aqry = "INSERT into ref_ruang (a1,a,b,c1,c,d,e,e1,p,q,nm_ruang,nm_pendek) values('$a1','$a','$b','$c1','$c','$d','$e','$e1','$gedung','0000','$nama','$nm_gedung_pendek')";	
				$cek .= $aqry;	
				$qry = mysql_query($aqry);
				$content=$gedung;	
				}
			}
				
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function simpanGedung_4(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		
		$a1= $Main->DEF_KEPEMILIKAN;
		$a= $Main->DEF_PROPINSI;
		$b= $Main->DEF_WILAYAH;
		$c= $_REQUEST['c'];
		$d= $_REQUEST['d'];
		$e= $_REQUEST['e'];
		$e1= $_REQUEST['e1'];
		$gedung= $_REQUEST['gedung'];
		$nama= $_REQUEST['nama'];
		$nm_gedung_pendek= $_REQUEST['nm_gedung_pendek'];
		$nm_penanggung = $_REQUEST['nm_penanggung'];
	 	$nip_penanggung = $_REQUEST['nip_penanggung'];
	
	//	$nama= $_REQUEST['nama'];
	if( $err=='' && $nama =='' ) $err= 'Nama Kode Gedung Belum Di Isi !!';
	if( $err=='' && $nm_gedung_pendek =='' ) $err= 'Nama Gedung Pendek Belum Di Isi !!';
	if( $err=='' && $nm_penanggung =='' ) $err= 'Nama Penanggung Jawab Belum Di Isi !!';
	if( $err=='' && $nip_penanggung =='' ) $err= 'NIP Penanggung Jawab Belum Di Isi !!';
		if($fmST == 0){
			if($err==''){
				$aqry = "INSERT into ref_ruang (a1,a,b,c1,c,d,e,e1,p,q,nm_ruang,nm_pendek,nm_penanggung_jawab,nip_penanggung_jawab) values('$a1','$a','$b','0','$c','$d','$e','$e1','$gedung','0000','$nama','$nm_gedung_pendek','$nm_penanggung','$nip_penanggung')";	
				$cek .= $aqry;	
				$qry = mysql_query($aqry);
				$content=$gedung;	
				}
			}
				
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function simpanEditGedung(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	
	$a1 = $Main->DEF_KEPEMILIKAN;
	$a = $Main->Provinsi[0];
	$b = $Main->DEF_WILAYAH;
	$c1= $_REQUEST['c1'];
	$c= $_REQUEST['c'];
	$d= $_REQUEST['d'];
	$e= $_REQUEST['e'];
	$e1= $_REQUEST['e1'];
	$p= $_REQUEST['p'];
	$q= $_REQUEST['q'];
	$nm_p= $_REQUEST['nm_p'];
	$nm_q= $_REQUEST['nm_q'];
	$nama= $_REQUEST['nama'];
	$nip= $_REQUEST['nip'];
	$pendek= $_REQUEST['pendek'];
	$nm_penanggung= $_REQUEST['nm_penanggung'];
	$nip_penanggung= $_REQUEST['nip_penanggung'];
								
	if($err==''){						
		
	$aqry = "UPDATE ref_ruang set a1='$a1',a='$a',b='$b',c1='$c1',c='$c',d='$d',e='$e',e1='$e1',p='$p', q='0000',nm_ruang='$nm_p' ,nm_pendek='$pendek' where a1='$a1'and a='$a' and b='$b' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$p' and q='0000'";$cek .= $aqry;
	
		$qry = mysql_query($aqry);
		$qry2 = mysql_query($aqry2);
		}
							
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function simpanEditRuang(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	
	$a1 = $Main->DEF_KEPEMILIKAN;
	$a = $Main->Provinsi[0];
	$b = $Main->DEF_WILAYAH;
	$c1= $_REQUEST['c1'];
	$c= $_REQUEST['c'];
	$d= $_REQUEST['d'];
	$e= $_REQUEST['e'];
	$e1= $_REQUEST['e1'];
	$p= $_REQUEST['p'];
	$q= $_REQUEST['q'];
	$nm_p= $_REQUEST['nm_p'];
	$nm_q= $_REQUEST['nm_q'];
	$nama= $_REQUEST['nm_pegawai'];
	$nip= $_REQUEST['nip_pegawai'];
	$pendek= $_REQUEST['pendek'];
	
	 if( $err=='' && $nm_p =='' ) $err= 'Nama Gedung Belum Di Isi !!';
	 if( $err=='' && $pendek =='' ) $err= 'Nama Gedung Pendek Belum Di Isi !!';
	 if( $err=='' && $nama =='' ) $err= 'Nama Penanggung Jawab Belum Di Isi !!';
	 if( $err=='' && $nip =='' ) $err= 'NIP Penanggung Jawab Belum Di Isi !!';
								
	if($err==''){						
		
	$aqry2 = "UPDATE ref_ruang set a1='$a1',a='$a',b='$b',c1='$c1',c='$c',d='$d',e='$e',e1='$e1', q='$q',nm_ruang='$nm_q',nm_pendek='$pendek',nm_penanggung_jawab='$nama' ,nip_penanggung_jawab='$nip' where a1='$a1'and a='$a' and b='$b' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$p' and q='$q'";$cek .= $aqry2;
	
		$qry = mysql_query($aqry);
		$qry2 = mysql_query($aqry2);
		}
							
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function simpanEditGedung_4(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	
	$a1 = $Main->DEF_KEPEMILIKAN;
	$a = $Main->Provinsi[0];
	$b = $Main->DEF_WILAYAH;
	$c= $_REQUEST['c'];
	$d= $_REQUEST['d'];
	$e= $_REQUEST['e'];
	$e1= $_REQUEST['e1'];
	$p= $_REQUEST['p'];
	$q= $_REQUEST['q'];
	$nm_p= $_REQUEST['nm_p'];
	$nm_q= $_REQUEST['nm_q'];
	$nama= $_REQUEST['nama'];
	$nip= $_REQUEST['nip'];
	$pendek= $_REQUEST['pendek'];
	$nm_penanggung= $_REQUEST['nm_penanggung'];
	$nip_penanggung= $_REQUEST['nip_penanggung'];
	
	 if( $err=='' && $nm_p =='' ) $err= 'Nama Gedung Belum Di Isi !!';
	 if( $err=='' && $pendek =='' ) $err= 'Nama Gedung Pendek Belum Di Isi !!';
	 if( $err=='' && $nm_penanggung =='' ) $err= 'Nama Penanggung Jawab Belum Di Isi !!';
	 if( $err=='' && $nip_penanggung =='' ) $err= 'NIP Penanggung Jawab Belum Di Isi !!';
								
	if($err==''){						
		
	$aqry = "UPDATE ref_ruang set a1='$a1',a='$a',b='$b',c1='0',c='$c',d='$d',e='$e',e1='$e1',p='$p', q='0000',nm_ruang='$nm_p' ,nm_pendek='$pendek',nip_penanggung_jawab='$nip_penanggung',nm_penanggung_jawab='$nm_penanggung' where a1='$a1'and a='$a' and b='$b' and c1='0' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$p' and q='0000'";$cek .= $aqry;
	
		$qry = mysql_query($aqry);
		$qry2 = mysql_query($aqry2);
		}
							
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function simpanEditRuang_4(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	
	$a1 = $Main->DEF_KEPEMILIKAN;
	$a = $Main->Provinsi[0];
	$b = $Main->DEF_WILAYAH;
	$c1= $_REQUEST['c1'];
	$c= $_REQUEST['c'];
	$d= $_REQUEST['d'];
	$e= $_REQUEST['e'];
	$e1= $_REQUEST['e1'];
	$p= $_REQUEST['p'];
	$q= $_REQUEST['q'];
	$nm_p= $_REQUEST['nm_p'];
	$nm_q= $_REQUEST['nm_q'];
	$nama= $_REQUEST['nama'];
	$nip= $_REQUEST['nip'];
	$pendek= $_REQUEST['pendek'];
	
	 if( $err=='' && $nm_q =='' ) $err= 'Nama Ruang Belum Di Isi !!';
	 if( $err=='' && $pendek =='' ) $err= 'Nama Ruang Pendek Belum Di Isi !!';
	 if( $err=='' && $nama =='' ) $err= 'Nama Penanggung Jawab Belum Di Isi !!';
	 if( $err=='' && $nip =='' ) $err= 'NIP Penanggung Jawab Belum Di Isi !!';
								
	if($err==''){						
		
	$aqry2 = "UPDATE ref_ruang set a1='$a1',a='$a',b='$b',c1='0',c='$c',d='$d',e='$e',e1='$e1', q='$q',nm_ruang='$nm_q',nm_pendek='$pendek',nm_penanggung_jawab='$nama' ,nip_penanggung_jawab='$nip' where a1='$a1'and a='$a' and b='$b' and c1='0' and c='$c' and d='$d' and e='$e' and e1='$e1' and p='$p' and q='$q'";$cek .= $aqry2;
	
		$qry = mysql_query($aqry);
		$qry2 = mysql_query($aqry2);
		}
							
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function BaruGedung($dt){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKB';				
	 $this->form_width = 700;
	 $this->form_height = 220;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru Kode Gedung';
		$nip	 = '';
		$c1 = $_REQUEST['fmc1'];
		$c = $_REQUEST['fmc'];
		$d = $_REQUEST['fmd'];
		$e = $_REQUEST['fme'];
		$e1 = $_REQUEST['fme1'];
			
		$aqry2="SELECT MAX(p) AS maxno FROM ref_ruang WHERE c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'";
	
		$get=mysql_fetch_array(mysql_query($aqry2));
		$new=$get['maxno'] + 1;
		$gedung = sprintf("%03s", $new);
		
		//---------query------------
		$queryc1=mysql_fetch_array(mysql_query("SELECT c1, nm_skpd FROM ref_skpd where c1='$c1' and c=00 and d=00 and e=00 and e1=000"));  
		$queryc=mysql_fetch_array(mysql_query("SELECT c, nm_skpd FROM ref_skpd where c1='$c1' and c='$c' and d=00 and e=00 and e1=000"));  
		$queryd=mysql_fetch_array(mysql_query("SELECT d, nm_skpd FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e=00 and e1=000"));  
		$querye=mysql_fetch_array(mysql_query("SELECT e, nm_skpd FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1=000"));  
		$querye1=mysql_fetch_array(mysql_query("SELECT e1, nm_skpd FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));  
		
		$cek.="SELECT e1, nm_skpd FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'";
		$datac1=$queryc1['c1'].".".$queryc1['nm_skpd'];
		$datac=$queryc['c'].".".$queryc['nm_skpd'];
		$datad=$queryd['d'].".".$queryd['nm_skpd'];
		$datae=$querye['e'].".".$querye['nm_skpd'];
		$datae1=$querye1['e1'].".".$querye1['nm_skpd'];
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			
			'urusan' => array( 
						'label'=>'KODE URUSAN',
						'labelWidth'=>150, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='dc1' id='dc1' value='".$datac1."' style='width:400px;' readonly>
						<input type ='hidden' name='c1' id='c1' value='".$queryc1['c1']."'>
						</div>", 
						 ),	
						 
			'bidang' => array( 
						'label'=>'KODE BIDANG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='dc' id='dc' value='".$datac."' style='width:400px;' readonly>
						<input type ='hidden' name='c' id='c' value='".$queryc['c']."'>
						</div>", 
						 ),	
						 
			'skpd' => array( 
						'label'=>'KODE SKPD',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='dd' id='dd' value='".$datad."' style='width:400px;' readonly>
						<input type ='hidden' name='d' id='d' value='".$queryd['d']."'>
						</div>", 
						 ),	
						 
			'unit' => array( 
						'label'=>'Kode UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='de' id='de' value='".$datae."' style='width:400px;' readonly>
						<input type ='hidden' name='e' id='e' value='".$querye['e']."'>
						</div>", 
						 ),	
						 
			'subunit' => array( 
						'label'=>'KODE SUB UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='de1' id='de1' value='".$datae1."' style='width:400px;' readonly>
						<input type ='hidden' name='e1' id='e1' value='".$querye1['e1']."'>
						</div>", 
						 ),				 			 			 
									 			
			'gedung' => array( 
						'label'=>'Kode GEDUNG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='gedung' id='gedung' value='".$gedung."' style='width:50px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Gedung' style='width:445px;'>
						</div>", 
						 ),		
			
			'nm_gedung_pendek' => array(
						'label'=>'NAMA GEDUNG PENDEK',
						'value'=>$dt['nm_pendek'],
						'type'=>'text',
						'param'=>" maxlength=15 title='Nama Gedung Pendek (ex: Gedung Sate)' placeholder='Nama Gedung Pendek' style='width: 255px;'"
						),
						
			/*'penanggung' => array( 
						'label'=>'PENANGGUNG JAWAB',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='nm_penanggung' id='nm_penanggung' value='".$dt['nm_skpd_singkatan']."' placeholder='Nama' style='width:255px;'>&nbsp&nbsp
						<input type='text' name='nip_penanggung' id='nip_penanggung' value='".$dt['nm_skpd_singkatan']."' placeholder='NIP' style='width:235px;'>
						</div>", 
						 ),		*/		 				
			
			'Add' => array( 
						'label'=>'',
						'value'=>"<div id='Add'></div>",
						'type'=>'merge'
					 )			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanGedung()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
							
		$form = $this->genFormGedung();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function genFormGedung($withForm=TRUE, $params=NULL, $center=TRUE){	
		$form_name = $this->Prefix.'_KBform';	
		
		if($withForm){
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
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
					$this->form_menu_bawah_height,'',$params).
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
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
					$this->form_menu_bawah_height,'',$params
				);
		}
		
		if($center){
			$form = centerPage( $form );	
		}
		return $form;
	}
	
	function BaruGedungPil($dt){	
	 global $SensusTmp, $Main, $RuangPilih;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $RuangPilih->Prefix.'_formKB';				
	 $this->form_width = 700;
	 $this->form_height = 200;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Baru Kode Gedung';
		$nip	 = '';
		$c1 = $_REQUEST['fmc1'];
		$c = $_REQUEST['fmc'];
		$d = $_REQUEST['fmd'];
		$e = $_REQUEST['fme'];
		$e1 = $_REQUEST['fme1'];
			
		$aqry2="SELECT MAX(p) AS maxno FROM ref_ruang WHERE c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'";
	
		$get=mysql_fetch_array(mysql_query($aqry2));
		$new=$get['maxno'] + 1;
		$gedung = sprintf("%03s", $new);
		
		//---------query------------
		$queryc1=mysql_fetch_array(mysql_query("SELECT c1, nm_skpd FROM ref_skpd where c1='$c1' and c=00 and d=00 and e=00 and e1=000"));  
		$queryc=mysql_fetch_array(mysql_query("SELECT c, nm_skpd FROM ref_skpd where c1='$c1' and c='$c' and d=00 and e=00 and e1=000"));  
		$queryd=mysql_fetch_array(mysql_query("SELECT d, nm_skpd FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e=00 and e1=000"));  
		$querye=mysql_fetch_array(mysql_query("SELECT e, nm_skpd FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1=000"));  
		$querye1=mysql_fetch_array(mysql_query("SELECT e1, nm_skpd FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));  
		
		$cek.="SELECT e1, nm_skpd FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'";
		$datac1=$queryc1['c1'].".".$queryc1['nm_skpd'];
		$datac=$queryc['c'].".".$queryc['nm_skpd'];
		$datad=$queryd['d'].".".$queryd['nm_skpd'];
		$datae=$querye['e'].".".$querye['nm_skpd'];
		$datae1=$querye1['e1'].".".$querye1['nm_skpd'];
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			
			'urusan' => array( 
						'label'=>'KODE URUSAN',
						'labelWidth'=>150, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='dc1' id='dc1' value='".$datac1."' style='width:400px;' readonly>
						<input type ='hidden' name='c1' id='c1' value='".$queryc1['c1']."'>
						</div>", 
						 ),	
			'bidang' => array( 
						'label'=>'KODE BIDANG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='dc' id='dc' value='".$datac."' style='width:400px;' readonly>
						<input type ='hidden' name='c' id='c' value='".$queryc['c']."'>
						</div>", 
						 ),	
						 
			'skpd' => array( 
						'label'=>'KODE SKPD',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='dd' id='dd' value='".$datad."' style='width:400px;' readonly>
						<input type ='hidden' name='d' id='d' value='".$queryd['d']."'>
						</div>", 
						 ),	
						 
			'unit' => array( 
						'label'=>'Kode UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='de' id='de' value='".$datae."' style='width:400px;' readonly>
						<input type ='hidden' name='e' id='e' value='".$querye['e']."'>
						</div>", 
						 ),	
						 
			'subunit' => array( 
						'label'=>'KODE SUB UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='de1' id='de1' value='".$datae1."' style='width:400px;' readonly>
						<input type ='hidden' name='e1' id='e1' value='".$querye1['e1']."'>
						</div>", 
						 ),				 			 			 
									 			
			'gedung' => array( 
						'label'=>'Kode GEDUNG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='gedung' id='gedung' value='".$gedung."' style='width:50px;' readonly>
						<input type='text' name='nama' id='nama' value='".$nama."' placeholder='Nama Kode Gedung' style='width:445px;'>
						</div>", 
						 ),		
			
			'nm_gedung_pendek' => array(
						'label'=>'NAMA GEDUNG PENDEK',
						'value'=>$dt['nm_pendek'],
						'type'=>'text',
						'param'=>" maxlength=15 title='Nama Gedung Pendek (ex: Gedung Sate)' placeholder='Nama Gedung Pendek' style='width: 255px;'"
						),
						
			/*'penanggung' => array( 
						'label'=>'PENANGGUNG JAWAB',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='nm_penanggung' id='nm_penanggung' value='".$dt['nm_skpd_singkatan']."' placeholder='Nama' style='width:255px;'>&nbsp&nbsp
						<input type='text' name='nip_penanggung' id='nip_penanggung' value='".$dt['nm_skpd_singkatan']."' placeholder='NIP' style='width:235px;'>
						</div>", 
						 ),		*/		 				
			
			'Add' => array( 
						'label'=>'',
						'value'=>"<div id='Add'></div>",
						'type'=>'merge'
					 )			
			);
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$RuangPilih->Prefix.".SimpanGedungPil()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close2()' >";
		$form = $this->genFormGedungPil();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function genFormGedungPil($withForm=TRUE, $params=NULL, $center=TRUE){	
		$form_name = $this->Prefix.'_KBform';	
		
		if($withForm){
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
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
					$this->form_menu_bawah_height,'',$params).
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
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
					$this->form_menu_bawah_height,'',$params
				);
		}
		
		if($center){
			$form = centerPage( $form );	
		}
		return $form;
	}
	
	
	//form ==================================
	function setFormBaru(){
	global $Main;
	
		$urusan = $Main->URUSAN;
		$dt=array();
		$dt['c1'] = $_REQUEST[$this->Prefix.'SkpdfmURUSAN'];
		$dt['c'] = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$dt['d'] = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$dt['e'] = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$dt['e1'] = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
		
		$dt['p'] = '';
		$dt['q'] = '';
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		if($urusan!='0'){
			$fm = $this->setForm($dt);
		}else{
			$fm = $this->setForm_4($dt);
		}
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormBaruPil(){
	global $Main;
	
		$urusan = $Main->URUSAN;
		$dt=array();
		$dt['c1'] = $_REQUEST['fmURUSAN'];
		$dt['c'] = $_REQUEST['fmBIDANG'];
		$dt['d'] = $_REQUEST['fmSKPD'];
		$dt['e'] = $_REQUEST['fmUNIT'];
		$dt['e1'] = $_REQUEST['fmSUBUNIT'];
		
		$dt['p'] = '';
		$dt['q'] = '';
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		if($urusan!='0'){
			$fm = $this->setFormPil($dt);
		}else{
			$fm = $this->setForm_4($dt);
		}
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormEdit(){
		global $HTTP_COOKIE_VARS;
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$e1 = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
		
		$co_c1=$HTTP_COOKIE_VARS['coURUSAN'];
		$co_c=$HTTP_COOKIE_VARS['coSKPD'];
		$co_d=$HTTP_COOKIE_VARS['coUNIT'];
		$co_e=$HTTP_COOKIE_VARS['coSUBUNIT'];
		$co_e1=$HTTP_COOKIE_VARS['coSEKSI'];
		
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		
		//get data 
		$aqry = "select * from ref_ruang where id ='".$this->form_idplh."'  "; $cek.=$aqry;
		
		$dt = mysql_fetch_array(mysql_query($aqry));
		// SUPER ADMIN
		if($co_c1 == 0 && $co_c == 00 && $co_d == 00 && $co_e==00 && $co_e1==000){
		
		if ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung($dt);
			}elseif ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] !='0000'){
			$fm = $this->setFormEditRuang($dt);
			}elseif ($dt['c1'] == '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung_4($dt);
			}else{
			$fm = $this->setFormEditRuang_4($dt);
			}
		
	
		}elseif($co_c1==$dt['c1'] && $co_c!=$dt['c'] && $co_d!=$dt['d'] && $co_e!=$dt['e'] && $co_e1!=$dt['e1']){
		// Urusan
		if ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung($dt);
			}elseif ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] !='0000'){
			$fm = $this->setFormEditRuang($dt);
			}elseif ($dt['c1'] == '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung_4($dt);
			}else{
			$fm = $this->setFormEditRuang_4($dt);
			}
			
		}elseif($co_c1==$dt['c1'] && $co_c==$dt['c'] && $co_d!=$dt['d'] && $co_e!=$dt['e'] && $co_e1!=$dt['e1']){
		//Bidang
		if ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung($dt);
			}elseif ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] !='0000'){
			$fm = $this->setFormEditRuang($dt);
			}elseif ($dt['c1'] == '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung_4($dt);
			}else{
			$fm = $this->setFormEditRuang_4($dt);
			}	
	
		}elseif($co_c1==$dt['c1'] && $co_c==$dt['c'] && $co_d==$dt['d'] && $co_e!=$dt['e'] && $co_e1!=$dt['e1']){
		//Skpd
		if ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung($dt);
			}elseif ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] !='0000'){
			$fm = $this->setFormEditRuang($dt);
			}elseif ($dt['c1'] == '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung_4($dt);
			}else{
			$fm = $this->setFormEditRuang_4($dt);
			}
	
	}elseif($co_c1==$dt['c1'] && $co_c==$dt['c'] && $co_d==$dt['d'] && $co_e==$dt['e'] && $co_e1!=$dt['e1']){
	//Unit
		if ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung($dt);
			}elseif ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] !='0000'){
			$fm = $this->setFormEditRuang($dt);
			}elseif ($dt['c1'] == '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung_4($dt);
			}else{
			$fm = $this->setFormEditRuang_4($dt);
			}
		
	}elseif($co_c1==$dt['c1'] && $co_c==$dt['c'] && $co_d==$dt['d'] && $co_e==$dt['e'] && $co_e1==$dt['e1']){
	//Seksi
		if ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung($dt);
			}elseif ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] !='0000'){
			$fm = $this->setFormEditRuang($dt);
			}elseif ($dt['c1'] == '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung_4($dt);
			}else{
			$fm = $this->setFormEditRuang_4($dt);
			}
	
	}else{
		$fm['err']="Data Tidak Bisa di Edit Berdasar Hak Akses !!";
	}		
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$err.$fm['err'], 'content'=>$fm['content']);
	}
	
	/*function setFormEdit(){
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$e1 = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		
		//get data 
		$aqry = "select * from ref_ruang where id ='".$this->form_idplh."'  "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		
		if ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung($dt);
		}elseif ($dt['c1'] != '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] !='0000'){
			$fm = $this->setFormEditRuang($dt);
		}elseif ($dt['c1'] == '0' && $dt['c'] !='00' && $dt['d'] !='00' && $dt['e'] !='00'&& $dt['e1'] !='000' && $dt['p'] !='000' && $dt['q'] =='0000'){
			$fm = $this->setFormEditGedung_4($dt);
		}else{
			$fm = $this->setFormEditRuang_4($dt);
		}
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	*/
	
	function setFormEditGedung_4($dt){	
	 global $SensusTmp ,$Main;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 750;
	 $this->form_height = 190;
	  if ($this->form_fmST==1) {
		$this->form_caption = 'FORM EDIT RUANG';
	  }
		
		$queryKAedit=mysql_fetch_array(mysql_query("SELECT c1, nm_skpd FROM ref_skpd WHERE c1='0' and c = '00' and d='00' and e='00' and e1='000'")) ;
		$queryKBedit=mysql_fetch_array(mysql_query("SELECT c, nm_skpd FROM ref_skpd WHERE c1='1' and c='".$dt['c']."' and d= '".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."'")) ;
		$queryKCedit=mysql_fetch_array(mysql_query("SELECT d, nm_skpd FROM ref_skpd WHERE c1='1' and c='".$dt['c']."' and d='".$dt['d']."' and e='00' and e1='000'")) ;
		$queryKDedit=mysql_fetch_array(mysql_query("SELECT e, nm_skpd FROM ref_skpd WHERE c1='1' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='000'")) ;
		$queryKEedit=mysql_fetch_array(mysql_query("SELECT e1, nm_skpd FROM ref_skpd WHERE c1='1' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."'")) ;
		$queryGedung=mysql_fetch_array(mysql_query("SELECT p, nm_ruang FROM ref_ruang WHERE c1='0' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' and p='".$dt['p']."' and q=0000")) ;
		$queryRuang=mysql_fetch_array(mysql_query("SELECT q, nm_ruang FROM ref_ruang WHERE c1='1' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' and p='".$dt['p']."' and q='".$dt['q']."'")) ;
		
		$datka=$queryKAedit['c1'].".".$queryKAedit['nm_skpd'];
		$datkb=$queryKBedit['c'].".".$queryKBedit['nm_skpd'];
		$datkc=$queryKCedit['d'].".".$queryKCedit['nm_skpd'];
		$datkd=$queryKDedit['e'].".".$queryKDedit['nm_skpd'];
		$datke=$queryKEedit['e1'].".".$queryKEedit['nm_skpd'];
		$datgedung1=$queryGedung['p'];
		$datgedung2=$queryGedung['nm_ruang'];
		$datRuang1=$queryRuang['q'];
		$datRuang2=$queryRuang['nm_ruang'];
		$dat=mysql_fetch_array(mysql_query("SELECT count(*) as cnt FROM ref_ruang where p='".$dt['p']."' and q!='0000'"));
		$cek.="SELECT count(*) as cnt FROM ref_ruang where p='".$dt['p']."' and q!='0000'";
       //items ----------------------
		  $this->form_fields = array(
		  
			'BIDANG' => array( 
						'label'=>'BIDANG gedung',
						'labelWidth'=>150, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='el' id='el' value='".$datkb."' style='width:490px;' readonly>
						<input type ='hidden' name='c' id='c' value='".$queryKBedit['c']."'>
						</div>", 
						 ),
						 
			'SKPD' => array( 
						'label'=>'SKPD',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='em' id='em' value='".$datkc."' style='width:490px;' readonly>
						<input type ='hidden' name='d' id='d' value='".$queryKCedit['d']."'>
						</div>", 
						 ),
						 
			'UNIT' => array( 
						'label'=>'UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='en' id='en' value='".$datkd."' style='width:490px;' readonly>
						<input type ='hidden' name='e' id='e' value='".$queryKDedit['e']."'>
						</div>", 
						 ),
			
			'SUB_UNIT' => array( 
						'label'=>'SUB UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='e1dat' id='e1dat' value='".$datke."' style='width:490px;' readonly>
						<input type ='hidden' name='e1' id='e1' value='".$queryKEedit['e1']."'>
						</div>", 
						 ),			 			 			 
			
			'gedung' => array( 
						'label'=>'GEDUNG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='p' id='p' value='$datgedung1' style='width:40px;' readonly>
						<input type='text' name='nm_p' id='nm_p' value='$datgedung2' size='69px'>
						</div>", 
						 ),			
						 
			'pendek' => array( 
						'label'=>'NAMA GEDUNG PENDEK',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='pendek' id='pendek' value='".$dt['nm_pendek']."' style='width:250px;'>
						</div>", 
						 ),
						 				 
			'penanggung' => array( 
						'label'=>'PENANGGUNG JAWAB',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='nm_penanggung' id='nm_penanggung' value='".$dt['nm_penanggung_jawab']."' placeholder='Nama' style='width:250px;'>&nbsp&nbsp
						<input type='text' name='nip_penanggung' id='nip_penanggung' value='".$dt['nip_penanggung_jawab']."' placeholder='NIP' style='width:235px;'>
						</div>", 
						 ),					 
					);
		//tombol
		$this->form_menubawah =	
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanEditGedung_4()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}	
	
	function setFormEditGedung($dt){	
	 global $SensusTmp ,$Main;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 750;
	 $this->form_height = 200;
	  if ($this->form_fmST==1) {
		$this->form_caption = 'FORM EDIT GEDUNG';
	  }
	 
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;	
		$c1=$kode[0];
		$c=$kode[1];
		$d=$kode[2];
		$e=$kode[3];
		$e1=$kode[4];
		
		$queryKAedit=mysql_fetch_array(mysql_query("SELECT c1, nm_skpd FROM ref_skpd WHERE c1='".$dt['c1']."' and c = '00' and d='00' and e='00' and e1='000'")) ;
		$queryKBedit=mysql_fetch_array(mysql_query("SELECT c, nm_skpd FROM ref_skpd WHERE c1='".$dt['c1']."' and c='".$dt['c']."' and d= '00' and e='00' and e1='000'")) ;
		$queryKCedit=mysql_fetch_array(mysql_query("SELECT d, nm_skpd FROM ref_skpd WHERE c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='00' and e1='000'")) ;
		$queryKDedit=mysql_fetch_array(mysql_query("SELECT e, nm_skpd FROM ref_skpd WHERE c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='000'")) ;
		$queryKEedit=mysql_fetch_array(mysql_query("SELECT e1, nm_skpd FROM ref_skpd WHERE c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."'")) ;
		$queryGedung=mysql_fetch_array(mysql_query("SELECT p, nm_ruang FROM ref_ruang WHERE c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' and p='".$dt['p']."' and q=000")) ;
		$queryRuang=mysql_fetch_array(mysql_query("SELECT q, nm_ruang FROM ref_ruang WHERE c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' and p='".$dt['p']."' and q='".$dt['q']."'")) ;
		
		$datka=$queryKAedit['c1'].".".$queryKAedit['nm_skpd'];
		$datkb=$queryKBedit['c'].".".$queryKBedit['nm_skpd'];
		$datkc=$queryKCedit['d'].".".$queryKCedit['nm_skpd'];
		$datkd=$queryKDedit['e'].".".$queryKDedit['nm_skpd'];
		$datke=$queryKEedit['e1'].".".$queryKEedit['nm_skpd'];
		$datgedung1=$queryGedung['p'];
		$datgedung2=$queryGedung['nm_ruang'];
		$datRuang1=$queryRuang['q'];
		$datRuang2=$queryRuang['nm_ruang'];
		
       //items ----------------------
		  $this->form_fields = array(
		  
		  'URUSAN' => array( 
						'label'=>'URUSAN Gedung',
						'labelWidth'=>150, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='ek' id='ek' value='".$datka."' style='width:490px;' readonly>
						<input type ='hidden' name='c1' id='c1' value='".$queryKAedit['c1']."'>
						</div>", 
						 ),
						 
			'BIDANG' => array( 
						'label'=>'BIDANG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='el' id='el' value='".$datkb."' style='width:490px;' readonly>
						<input type ='hidden' name='c' id='c' value='".$queryKBedit['c']."'>
						</div>", 
						 ),
						 
			'SKPD' => array( 
						'label'=>'SKPD',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='em' id='em' value='".$datkc."' style='width:490px;' readonly>
						<input type ='hidden' name='d' id='d' value='".$queryKCedit['d']."'>
						</div>", 
						 ),
						 
			'UNIT' => array( 
						'label'=>'UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='en' id='en' value='".$datkd."' style='width:490px;' readonly>
						<input type ='hidden' name='e' id='e' value='".$queryKDedit['e']."'>
						</div>", 
						 ),
			
			'SUB_UNIT' => array( 
						'label'=>'SUB UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='e1dat' id='e1dat' value='".$datke."' style='width:490px;' readonly>
						<input type ='hidden' name='e1' id='e1' value='".$queryKEedit['e1']."'>
						</div>", 
						 ),			 			 			 
			
			'gedung' => array( 
						'label'=>'GEDUNG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='p' id='p' value='$datgedung1' style='width:40px;' readonly>
						<input type='text' name='nm_p' id='nm_p' value='$datgedung2' size='69px'>
						</div>", 
						 ),			
						 
			'pendek' => array( 
						'label'=>'NAMA GEDUNG PENDEK',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='pendek' id='pendek' value='".$dt['nm_pendek']."' style='width:250px;'>
						</div>", 
						 )
						 
			/*'penanggung' => array( 
						'label'=>'PENANGGUNG JAWAB',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='nm_penanggung' id='nm_penanggung' value='".$dt['nm_penanggung_jawab']."' placeholder='Nama' style='width:250px;'>&nbsp&nbsp
						<input type='text' name='nip_penanggung' id='nip_penanggung' value='".$dt['nip_penanggung_jawab']."' placeholder='NIP' style='width:240px;'>
						</div>", 
						 )		*/		 			 				 
					);
		//tombol
		$this->form_menubawah =	
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanEditGedung()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}	
	
	function setFormEditRuang($dt){	
	 global $SensusTmp ,$Main;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 750;
	 $this->form_height = 240;
	  if ($this->form_fmST==1) {
		$this->form_caption = 'FORM EDIT RUANG';
	  }
	 
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;	
		$c1=$kode[0];
		$c=$kode[1];
		$d=$kode[2];
		$e=$kode[3];
		$e1=$kode[4];
	
		$queryKAedit=mysql_fetch_array(mysql_query("SELECT c1, nm_skpd FROM ref_skpd WHERE c1='".$dt['c1']."' and c = '00' and d='00' and e='00' and e1='000'")) ;
		$queryKBedit=mysql_fetch_array(mysql_query("SELECT c, nm_skpd FROM ref_skpd WHERE c1='".$dt['c1']."' and c='".$dt['c']."' and d= '00' and e='00' and e1='000'")) ;
		$queryKCedit=mysql_fetch_array(mysql_query("SELECT d, nm_skpd FROM ref_skpd WHERE c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='00' and e1='000'")) ;
		$queryKDedit=mysql_fetch_array(mysql_query("SELECT e, nm_skpd FROM ref_skpd WHERE c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='000'")) ;
		$queryKEedit=mysql_fetch_array(mysql_query("SELECT e1, nm_skpd FROM ref_skpd WHERE c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."'")) ;
		$queryGedung=mysql_fetch_array(mysql_query("SELECT p, nm_ruang FROM ref_ruang WHERE c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' and p='".$dt['p']."' and q=000")) ;
		$queryRuang=mysql_fetch_array(mysql_query("SELECT q, nm_ruang FROM ref_ruang WHERE c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' and p='".$dt['p']."' and q='".$dt['q']."'")) ;
		
		$datka=$queryKAedit['c1'].".".$queryKAedit['nm_skpd'];
		$datkb=$queryKBedit['c'].".".$queryKBedit['nm_skpd'];
		$datkc=$queryKCedit['d'].".".$queryKCedit['nm_skpd'];
		$datkd=$queryKDedit['e'].".".$queryKDedit['nm_skpd'];
		$datke=$queryKEedit['e1'].".".$queryKEedit['nm_skpd'];
		$datgedung1=$queryGedung['p'];
		$datgedung2=$queryGedung['nm_ruang'];
		$datRuang1=$queryRuang['q'];
		$datRuang2=$queryRuang['nm_ruang'];
		
       //items ----------------------
		  $this->form_fields = array(
		  
		  'URUSAN' => array( 
						'label'=>'URUSAN ruang',
						'labelWidth'=>150, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='ek' id='ek' value='".$datka."' style='width:490px;' readonly>
						<input type ='hidden' name='c1' id='c1' value='".$queryKAedit['c1']."'>
						</div>", 
						 ),
						 
			'BIDANG' => array( 
						'label'=>'BIDANG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='el' id='el' value='".$datkb."' style='width:490px;' readonly>
						<input type ='hidden' name='c' id='c' value='".$queryKBedit['c']."'>
						</div>", 
						 ),
						 
			'SKPD' => array( 
						'label'=>'SKPD',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='em' id='em' value='".$datkc."' style='width:490px;' readonly>
						<input type ='hidden' name='d' id='d' value='".$queryKCedit['d']."'>
						</div>", 
						 ),
						 
			'UNIT' => array( 
						'label'=>'UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='en' id='en' value='".$datkd."' style='width:490px;' readonly>
						<input type ='hidden' name='e' id='e' value='".$queryKDedit['e']."'>
						</div>", 
						 ),
			
			'SUB_UNIT' => array( 
						'label'=>'SUB UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='e1' id='e1' value='".$datke."' style='width:490px;' readonly>
						</div>", 
						 ),			 			 			 
			
			'gedung' => array( 
						'label'=>'GEDUNG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='p' id='p' value='$datgedung1' style='width:40px;' readonly>
						<input type='text' name='nm_p' id='nm_p' value='$datgedung2' size='69px' readonly>
						</div>", 
						 ),			
			
			'ruang' => array( 
						'label'=>'RUANG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='q' id='q' value='$datRuang1' style='width:40px;' readonly>
						<input type='text' name='nm_q' id='nm_q' value='$datRuang2' size='69px'>
						</div>", 
						 ),	
						 
			'pendek' => array( 
						'label'=>'NAMA RUANG PENDEK',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='pendek' id='pendek' value='".$dt['nm_pendek']."' style='width:250px;'>
						</div>", 
						 ),				 
						 
			'penanggung' => array( 
						'label'=>'PENANGGUNG JAWAB',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='nm_pegawai' id='nm_pegawai' value='".$dt['nm_penanggung_jawab']."' style='width:250px;' readonly>
						<input type ='hidden' name='e1' id='e1' value='".$queryKEedit['e1']."'>
						<input type='text' name='nip_pegawai' id='nip_pegawai' value='".$dt['nip_penanggung_jawab']."' style='width:240px;' readonly>&nbsp&nbsp<input type='button' value='Cari' onclick ='".$this->Prefix.".cariPegawai()' title='Baru Gedung' >
						</div>", 
						 ),				 			 					 			 	 
			);
		//tombol
		$this->form_menubawah =	
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanEditRuang()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}	
	
	function setFormEditRuang_4($dt){	
	 global $SensusTmp ,$Main;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 700;
	 $this->form_height = 240;
	  if ($this->form_fmST==1) {
		$this->form_caption = 'FORM EDIT RUANG';
	  }
	 
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;	
		$c1=$kode[0];
		$c=$kode[1];
		$d=$kode[2];
		$e=$kode[3];
		$e1=$kode[4];
	
		$queryKAedit=mysql_fetch_array(mysql_query("SELECT c1, nm_skpd FROM ref_skpd WHERE c1='".$dt['c1']."' and c = '00' and d='00' and e='00' and e1='000'")) ;
		$queryKBedit=mysql_fetch_array(mysql_query("SELECT c, nm_skpd FROM ref_skpd WHERE c='".$dt['c']."' and d= '00' and e='00' and e1='000'")) ;
		$queryKCedit=mysql_fetch_array(mysql_query("SELECT d, nm_skpd FROM ref_skpd WHERE c='".$dt['c']."' and d='".$dt['d']."' and e='00' and e1='000'")) ;
		$queryKDedit=mysql_fetch_array(mysql_query("SELECT e, nm_skpd FROM ref_skpd WHERE c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='000'")) ;
		$queryKEedit=mysql_fetch_array(mysql_query("SELECT e1, nm_skpd FROM ref_skpd WHERE c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."'")) ;
		$queryGedung=mysql_fetch_array(mysql_query("SELECT p, nm_ruang FROM ref_ruang WHERE c1='0' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' and p='".$dt['p']."' and q='0000'"));
		$queryRuang=mysql_fetch_array(mysql_query("SELECT q, nm_ruang FROM ref_ruang WHERE c1='0' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' and p='".$dt['p']."' and q='".$dt['q']."'")) ;
		
		$datka=$queryKAedit['c1'].".".$queryKAedit['nm_skpd'];
		$datkb=$queryKBedit['c'].".".$queryKBedit['nm_skpd'];
		$datkc=$queryKCedit['d'].".".$queryKCedit['nm_skpd'];
		$datkd=$queryKDedit['e'].".".$queryKDedit['nm_skpd'];
		$datke=$queryKEedit['e1'].".".$queryKEedit['nm_skpd'];
		$datgedung1=$queryGedung['p'];
		$datgedung2=$queryGedung['nm_ruang'];
		$datRuang1=$queryRuang['q'];
		$datRuang2=$queryRuang['nm_ruang'];
		
       //items ----------------------
		  $this->form_fields = array(
		  
			'BIDANG' => array( 
						'label'=>'BIDANG Ruang',
						'labelWidth'=>150, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='el' id='el' value='".$datkb."' style='width:490px;' readonly>
						<input type ='hidden' name='c' id='c' value='".$queryKBedit['c']."'>
						</div>", 
						 ),
						 
			'SKPD' => array( 
						'label'=>'SKPD',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='em' id='em' value='".$datkc."' style='width:490px;' readonly>
						<input type ='hidden' name='d' id='d' value='".$queryKCedit['d']."'>
						</div>", 
						 ),
						 
			'UNIT' => array( 
						'label'=>'UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='en' id='en' value='".$datkd."' style='width:490px;' readonly>
						<input type ='hidden' name='e' id='e' value='".$queryKDedit['e']."'>
						</div>", 
						 ),
			
			'SUB_UNIT' => array( 
						'label'=>'SUB UNIT',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='e1' id='e1' value='".$datke."' style='width:490px;' readonly>
						</div>", 
						 ),			 			 			 
			
			'gedung' => array( 
						'label'=>'GEDUNG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='p' id='p' value='$datgedung1' style='width:40px;' readonly>
						<input type='text' name='nm_p' id='nm_p' value='$datgedung2' size='69px' readonly>
						</div>", 
						 ),			
			
			'ruang' => array( 
						'label'=>'RUANG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='q' id='q' value='$datRuang1' style='width:40px;' readonly>
						<input type='text' name='nm_q' id='nm_q' value='$datRuang2' size='69px'>
						</div>", 
						 ),	
						 
			'pendek' => array( 
						'label'=>'NAMA RUANG PENDEK',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='pendek' id='pendek' value='".$dt['nm_pendek']."' style='width:250px;'>
						</div>", 
						 ),				 
						 
			'penanggung' => array( 
						'label'=>'PENANGGUNG JAWAB',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='nama' id='nama' value='".$dt['nm_penanggung_jawab']."' style='width:250px;' >
						<input type ='hidden' name='e1' id='e1' value='".$queryKEedit['e1']."'>
						<input type='text' name='nip' id='nip' value='".$dt['nip_penanggung_jawab']."' style='width:240px;'>
						</div>", 
						 ),				 			 					 			 	 
			);
		//tombol
		$this->form_menubawah =	
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanEditRuang_4()' title='Simpan' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}	
	
	function setForm($dt){	
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
		
		$urusan2 = $Main->URUSAN;
		
		$form_name = $this->Prefix.'_form';				
		$this->form_width = 750;
		$this->form_height = 220;
		if ($this->form_fmST==0) {
			$this->form_caption = 'FORM BARU RUANG';
			$kode	 = '';
		}else{
			$this->form_caption = 'Edit';			
			$kode = $dt['p'].'.'.$dt['q'];			
		}
			$kdSubUnit0 = genNumber(0, $Main->SUBUNIT_DIGIT );
		//items ----------------------
		
		$fmc1 = $_REQUEST['fmc1'];
		$fmc = $_REQUEST['fmc'];
		$fmd = $_REQUEST['fmd'];
		$fme = $_REQUEST['fme'];
		$fme1 = $_REQUEST['fme1'];
		$gedung = $_REQUEST['gedung'];
		
		$c1 = $_REQUEST['fmURUSAN'];
		$c = $_REQUEST['fmSKPD'];
		$d = $_REQUEST['fmUNIT'];
		$e = $_REQUEST['fmSUBUNIT'];
		$e1 = $_REQUEST['fmSEKSI'];
		$dafSKPD=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		
		$queryc1="SELECT c1, concat(c1, '. ', nm_skpd) as vnama FROM ref_skpd where c1!='0' and c=00 and d=00 and e=00 and e1=000";
		$queryc="SELECT c,concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c!=00 and d=00 and e=00 and e1=000";
		$queryd="SELECT d,concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d!='00' and e=00 and e1=000";
		$querye="SELECT e,concat(e, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e!='00' and e1='000'";
		$querye1="SELECT e1, concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1!='000'";
		$querygedung="SELECT p,concat(p, '. ', nm_ruang) as vnama FROM ref_ruang where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' and q='0000'";
		$cek.="SELECT p,nm_ruang FROM ref_ruang where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."'";
					
		$this->form_fields = array(	
			'urusan' => array( 
						'label'=>'URUSAN',
						'labelWidth'=>150, 
						'value'=>"<div id='cont_c1'>".cmbQuery('fmc1',$dt['c1'],$queryc1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihUrusan()"','-------- Pilih Kode URUSAN ----------')."</div>",
						 ),		
		//	$URUSAN,			 	
			'bidang' => array( 
						'label'=>'BIDANG',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_c'>".cmbQuery('fmc',$dt['c'],$queryc,'style="width:500px;"onchange="'.$this->Prefix.'.pilihBidang()"','-------- Pilih Kode BIDANG -----------')."</div>",
						 ),
						 		 
			'skpd' => array( 
						'label'=>'SKPD',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_d'>".cmbQuery('fmd',$dt['d'],$queryd,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSKPD()"','-------- Pilih Kode SKPD --------------')."</div>",
						 ),	
						 
			'unit' => array( 
						'label'=>'UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e'>".cmbQuery('fme',$dt['e'],$querye,'style="width:500px;"onchange="'.$this->Prefix.'.pilihUnit()"','-------- Pilih Kode UNIT ---------------')."</div>",
						 ),		
				
			'sub_unit' => array( 
						'label'=>'SUB UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e1'>".cmbQuery('fme1',$dt['e1'],$querye1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubUnit()"','-------- Pilih Kode SUB UNIT --------')."</div>",
						 ),		
			
			'gedung' => array( 
						'label'=>'GEDUNG',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_gd'>".cmbQuery('p',$dt['p'],$querygedung,'style="width:500px;"onchange="'.$this->Prefix.'.pilihGedung()"','-------- Pilih Kode Gedung -----------')."&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruGedung()' title='Baru Gedung' ></div>",
						 ),
						 	
			'ruang' => array( 
						'label'=>'RUANG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='q' id='q' value='".$newke."' style='width:50px;' readonly>
						<input type='text' name='nm_q' id='nm_q' value='".$nama."' placeholder='Nama Ruang' style='width:449px;'>
						</div>", 
						 ),	
						 			 
			'nm_pendek' => array(
						'label'=>'NAMA RUANG PENDEK',
						'value'=>$dt['nm_pendek'],
						'type'=>'text',
						'param'=>" maxlength=15 title='Nama Ruang Pendek (ex: Ruang Perlengkapan)' placeholder='Nama Ruang Pendek' style='width: 250px;'"
						),			 
						 
			'penanggung' => array( 
						'label'=>'PENANGGUNG JAWAB',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='nm_pegawai' id='nm_pegawai' value='".$dt['nm_penanggung']."' placeholder='Nama' style='width:250px;' readonly >&nbsp&nbsp
						<input type='text' name='nip_pegawai' id='nip_pegawai' value='".$dt['nip_penanggung']."' placeholder='NIP' style='width:240px;' readonly>&nbsp&nbsp<input type='button' value='Cari' onclick ='".$this->Prefix.".cariPegawai()' title='cari Pegawai' >
						</div>", 
						 )				 
					);
		
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setFormPil($dt){	
		global $RuangPilih;
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
		
		$urusan2 = $Main->URUSAN;
		
		$form_name = $this->Prefix.'_form';				
		$this->form_width = 750;
		$this->form_height = 220;
		if ($this->form_fmST==0) {
			$this->form_caption = 'FORM BARU RUANG';
			$kode	 = '';
		}else{
			$this->form_caption = 'Edit';			
			$kode = $dt['p'].'.'.$dt['q'];			
		}
			$kdSubUnit0 = genNumber(0, $Main->SUBUNIT_DIGIT );
		//items ----------------------
		
		$fmc1 = $_REQUEST['fmc1'];
		$fmc = $_REQUEST['fmc'];
		$fmd = $_REQUEST['fmd'];
		$fme = $_REQUEST['fme'];
		$fme1 = $_REQUEST['fme1'];
		$gedung = $_REQUEST['gedung'];
		
		$c1 = $_REQUEST['fmURUSAN'];
		$c = $_REQUEST['fmSKPD'];
		$d = $_REQUEST['fmUNIT'];
		$e = $_REQUEST['fmSUBUNIT'];
		$e1 = $_REQUEST['fmSEKSI'];
		$dafSKPD=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		
		$queryc1="SELECT c1, concat(c1, '. ', nm_skpd) as vnama FROM ref_skpd where c1!='0' and c=00 and d=00 and e=00 and e1=000";$cek.=$queryc1;
		$queryc="SELECT c, concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c!=00 and d=00 and e=00 and e1=000";$cek.=$queryc;
		$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d!=00 and e=00 and e1=000";$cek.=$queryd;
		$querye="SELECT e, concat(e, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e!=00 and e1=000";
		$querye1="SELECT e1, concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."'"; $cek.=$querye1;
		$querygedung="SELECT p,concat(p, '. ', nm_ruang) as vnama FROM ref_ruang where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' and q='0000'";
		$cek.="SELECT p,nm_ruang FROM ref_ruang where c1='".$dt['c1']."' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."'";
				
		$this->form_fields = array(	
			'urusan' => array( 
						'label'=>'URUSAN',
						'labelWidth'=>150, 
						'value'=>"<div id='cont_c1'>".cmbQuery('fmc1',$dt['c1'],$queryc1,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihUrusanPil()"','-------- Pilih Kode URUSAN ----------')."</div>",
						 ),		
		//	$URUSAN,			 	
			'bidang' => array( 
						'label'=>'BIDANG',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_c'>".cmbQuery('fmc',$dt['c'],$queryc,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihBidangPil()"','-------- Pilih Kode BIDANG -----------')."</div>",
						 ),
						 		 
			'skpd' => array( 
						'label'=>'SKPD',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_d'>".cmbQuery('fmd',$dt['d'],$queryd,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihSKPDPil()"','-------- Pilih Kode SKPD --------------')."</div>",
						 ),	
						 
			'unit' => array( 
						'label'=>'UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e'>".cmbQuery('fme',$dt['e'],$querye,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihUnitPil()"','-------- Pilih Kode UNIT ---------------')."</div>",
						 ),		
				
			'sub_unit' => array( 
						'label'=>'SUB UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e1'>".cmbQuery('fme1',$dt['e1'],$querye1,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihSubUnitPil()"','-------- Pilih Kode SUB UNIT --------')."</div>",
						 ),		
			
			'gedung' => array( 
						'label'=>'GEDUNG',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_gd'>".cmbQuery('p',$dt['p'],$querygedung,'style="width:500px;"onchange="'.$RuangPilih->Prefix.'.pilihGedungPil()"','-------- Pilih Kode Gedung -----------')."&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$RuangPilih->Prefix.".BaruGedungPil()' title='Baru Gedung' ></div>",
						 ),	
						 
			'ruang' => array( 
						'label'=>'RUANG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='q' id='q' value='".$newke."' style='width:50px;' readonly>
						<input type='text' name='nm_q' id='nm_q' value='".$nama."' placeholder='Nama Ruang' style='width:449px;'>
						</div>", 
						 ),	
						 			 
			'nm_pendek' => array(
						'label'=>'NAMA RUANG PENDEK',
						'value'=>$dt['nm_pendek'],
						'type'=>'text',
						'param'=>" maxlength=15 title='Nama Ruang Pendek (ex: Ruang Perlengkapan)' placeholder='Nama Ruang Pendek' style='width: 250px;'"
						),			 
						 
			'penanggung' => array( 
						'label'=>'PENANGGUNG JAWAB',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='nm_pegawai' id='nm_pegawai' value='".$dt['nm_penanggung']."' placeholder='Nama' style='width:250px;' readonly>&nbsp&nbsp
						<input type='text' name='nip_pegawai' id='nip_pegawai' value='".$dt['nip_penanggung']."' placeholder='NIP' style='width:240px;' readonly>&nbsp&nbsp<input type='button' value='Cari' onclick ='".$RuangPilih->Prefix.".cariPegawai()' title='cari Pegawai' >
						</div>", 
						 )				 
		);
			
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setForm_4($dt){	
	global $SensusTmp,$Main;
	
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
		
		$urusan2 = $Main->URUSAN;
		$form_name = $this->Prefix.'_form';				
		$this->form_width = 750;
		$this->form_height = 220;
		if ($this->form_fmST==0) {
			$this->form_caption = 'FORM BARU RUANG';
			$kode	 = '';
		}else{
			$this->form_caption = 'Edit';			
			$kode = $dt['p'].'.'.$dt['q'];			
		}

		//items ----------------------
		
		$fmc = $_REQUEST['fmc'];
		$fmd = $_REQUEST['fmd'];
		$fme = $_REQUEST['fme'];
		$fme1 = $_REQUEST['fme1'];
		$gedung = $_REQUEST['gedung'];

		$c = $_REQUEST['fmSKPD'];
		$d = $_REQUEST['fmUNIT'];
		$e = $_REQUEST['fmSUBUNIT'];
		$e1 = $_REQUEST['fmSEKSI'];
		$dafSKPD=mysql_fetch_array(mysql_query("select * from ref_skpd where c='$c' and d='$d' and e='$e' and e1='$e1'"));
		
	//	$queryc1="SELECT c1, concat(c1, '. ', nm_skpd) as vnama FROM ref_skpd where c1!='0' and c=00 and d=00 and e=00 and e1=000";$cek.=$queryc1;
		$queryc="SELECT c, concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c!='00' and d=00 and e=00 and e1=000"; $cek.=$queryc;
		$queryd="SELECT d, concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c='".$dt['c']."' and d!=00 and e=00 and e1=000";
		$querye="SELECT e, concat(e, '. ', nm_skpd) as vnama FROM ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e!=00 and e1=000";
		$querye1="SELECT e1, concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1!='000'";
		$querygedung="SELECT p,concat(p, '. ', nm_ruang) as vnama FROM ref_ruang where c1='0' and c='".$dt['c']."' and d='".$dt['d']."' and e='".$dt['e']."' and e1='".$dt['e1']."' and q='0000'";
				
		$this->form_fields = array(	
					 	
			'bidang' => array( 
						'label'=>'BIDANG',
						'labelWidth'=>150, 
						'value'=>
						"<div id='cont_c'>".cmbQuery('fmc',$dt['c'],$queryc,'style="width:500px;"onchange="'.$this->Prefix.'.pilihBidang_4()"','-------- Pilih Kode BIDANG -----------')."</div>",
						 ),
						 		 
			'skpd' => array( 
						'label'=>'SKPD',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_d'>".cmbQuery('fmd',$dt['d'],$queryd,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSKPD_4()"','-------- Pilih Kode SKPD --------------')."</div>",
						 ),	
						 
			'unit' => array( 
						'label'=>'UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e'>".cmbQuery('fme',$dt['e'],$querye,'style="width:500px;"onchange="'.$this->Prefix.'.pilihUnit_4()"','-------- Pilih Kode UNIT ---------------')."</div>",
						 ),		
				
			'sub_unit' => array( 
						'label'=>'SUB UNIT',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_e1'>".cmbQuery('fme1',$dt['e1'],$querye1,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSubUnit_4()"','-------- Pilih Kode SUB UNIT --------')."</div>",
						 ),		
			
			'gedung' => array( 
						'label'=>'GEDUNG',
						'labelWidth'=>100, 
						'value'=>
						"<div id='cont_gd'>".cmbQuery('p',$dt['p'],$querygedung,'style="width:500px;"onchange="'.$this->Prefix.'.pilihGedung_4()"','-------- Pilih Kode Gedung -----------')."&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruGedung_4()' title='Baru Gedung' ></div>",
						 ),	
						 
			'ruang' => array( 
						'label'=>'RUANG',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='q' id='q' value='".$newke."' style='width:50px;' readonly>
						<input type='text' name='nm_q' id='nm_q' value='".$nama."' placeholder='Nama Ruang' style='width:449px;'>
						</div>", 
						 ),	
						 			 
			'nm_pendek' => array(
						'label'=>'NAMA RUANG PENDEK',
						'value'=>$dt['nm_pendek'],
						'type'=>'text',
						'param'=>" maxlength=15 title='Nama Ruang Pendek (ex: Ruang Perlengkapan)' placeholder='Nama Ruang Pendek' style='width: 250px;'" 
						),			 
						 
			'penanggung' => array( 
						'label'=>'PENANGGUNG JAWAB',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='nm_penanggung' id='nm_penanggung' value='".$dt['nm_penanggung']."' placeholder='Nama' style='width:250px;'>&nbsp&nbsp
						<input type='text' name='nip_penanggung' id='nip_penanggung' value='".$dt['nip_penanggung']."' placeholder='NIP' style='width:240px;'>
						</div>", 
						 )				 
		);
		
		//tombol
		$this->form_menubawah =
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan_4()' >"."&nbsp&nbsp".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
		
		$form = $this->genForm_4();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function genForm_4($withForm=TRUE, $params=NULL, $center=TRUE){	
		$form_name = $this->Prefix.'_form';	
		
		if($withForm){
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
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
					$this->form_menu_bawah_height,'',$params).
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
					<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >",
					$this->form_menu_bawah_height,'',$params
				);
		}
		
		if($center){
			$form = centerPage( $form );	
		}
		return $form;
	}
	
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
		$NomorColSpan = $Mode==1? 2: 1;
		$headerTable =
			"<thead>
				<tr>
				<th class='th01' width='40'>No.</th>
				$Checkbox		
				<th class='th01' width=150>KODE</th>
				<th class='th01' >NAMA GEDUNG / RUANG</th>
				<th class='th01' >NAMA GEDUNG / RUANG PENDEK</th>								
				<th class='th01' width=200>PENANGGUNG JAWAB RUANG</th>									
				</tr>
			</thead>";
		return $headerTable;
	}
	
	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	global $Ref,$Main;
	$q=$isi['q'];
	$urusan = $Main->URUSAN;
	
	$kodeskpd=$isi['c1'].'.'.$isi['c'].'.'.$isi['d'].'.'.$isi['e'].'.'.$isi['e1'];
		
	if($isi['q'] == '00000' ){
		$margin = '';
	if($isi['q'] != '0000') $margin = 'style="margin-left:15px;"';
	}else{ 	
		$margin = 'style="margin-left:15px;"';
	 }	
		$Koloms = array();
		$Koloms[] = array('align=right', $no.'.' );
		if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
		$Koloms[] = array('', $kodeskpd.' - '.$isi['p'].'.'.$isi['q']);		
		$Koloms[] = array('',"<span $margin>".$isi['nm_ruang']."</span>");
		$Koloms[] = array('',"<span $margin>".$isi['nm_pendek']."</span>");
		$Koloms[] = array('', $isi['nm_penanggung_jawab']);				
		return $Koloms;
	}
	
	function genDaftarOpsi(){
		global $Ref, $Main;
		$fmPILGEDUNG = $_REQUEST['fmPILGEDUNG'];
		$CrRuang = $_REQUEST['CrRuang'];
			
		$arr = array(	
			array('1','GEDUNG'),	
			array('2','RUANG'),
			);	
		$TampilOpt =
			"<table width=\"100%\" class=\"adminform\">	<tr>		
			<td width=\"100%\" valign=\"top\">" . 
				WilSKPD_ajx3($this->Prefix.'Skpd') . 
			"</td>
			<td >" . 		
			"</td>
			</tr></table>".	
			genFilterBar(
			array("<table>
						<tr>
						<td>
						<td>".
						"Cari Gedung/Ruang :
						<input type='text' value='".$CrRuang."' name='CrRuang' id='CrRuang' placeholder='Gedung / Ruang'>
						<input type='button' id='btTampil' value='Cari' onclick='".$this->Prefix.".refreshList(true)'>
						<input type='hidden' id='dat_urusan' value='".$Main->URUSAN."' >
							</td>
						</tr>
						</table>
				"),'',''
				
			);
		return array('TampilOpt'=>$TampilOpt);
	}			
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$cek='';
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$urusan = $Main->URUSAN;
		$fmPILGEDUNG = $_REQUEST['fmPILGEDUNG'];
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		$CrRuang = $_REQUEST['CrRuang'];
		if ($urusan==0){
			$arrKondisi = array();
			$arrKondisi[] = getKondisiSKPD2(
			$Main->DEF_KEPEMILIKAN, 
			$Main->Provinsi[0], 
			$Main->DEF_WILAYAH,
			
			cekPOST($this->Prefix.'SkpdfmSKPD'), 
			cekPOST($this->Prefix.'SkpdfmUNIT'), 
			cekPOST($this->Prefix.'SkpdfmSUBUNIT'),
			cekPOST($this->Prefix.'SkpdfmSEKSI')
		);	
		}else{
			$arrKondisi = array();
			$arrKondisi[] = getKondisiSKPD2(
			$Main->DEF_KEPEMILIKAN, 
			$Main->Provinsi[0], 
			$Main->DEF_WILAYAH,
			cekPOST($this->Prefix.'SkpdfmSKPD'), 
			cekPOST($this->Prefix.'SkpdfmUNIT'), 
			cekPOST($this->Prefix.'SkpdfmSUBUNIT'),
			cekPOST($this->Prefix.'SkpdfmSEKSI'),
			cekPOST($this->Prefix.'SkpdfmURUSAN')
		);	
		}
				
		$cek .= 'prefix='.$this->Prefix;
		$fmPILGEDUNG = $_REQUEST['fmPILGEDUNG'];
		if(!empty($_POST['CrRuang']) ) $arrKondisi[] = " nm_ruang like '%".$_POST['CrRuang']."%'";
				
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');				
		$Asc = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		$isivalue=explode('.',$fmPILCARIvalue);
		
		switch($fmPILCARI){			
			case 'selectRuang': $arrKondisi[] = " nm_ruang like '%$fmPILCARIvalue%'"; break;						 	
		}		
			
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
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal, 'cek'=>$cek);
	}
}
$Ruang = new RuangObj();


class RuangPilihObj  extends RuangObj{
	var $Prefix = 'RuangPilih';
	var $elCurrPage="HalDefault";
	var $TblName = 'ref_ruang'; //daftar
	var $TblName_Hapus = 'ref_ruang';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');//('p','q'); //daftar/hapus
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Data';
	var $PageIcon = 'images/masterdata_ico.gif';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pegawai.xls';
	var $Cetak_Judul = 'DAFTAR RUANG';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	
	
	function setTitle(){
		return 'Pilih Ruang';
	}
	
	function setMenuView(){
		return '';
	}		
	
	function setMenuEdit(){
	global $Ruang;
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".BaruPil()","sections.png","Baru", 'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>";
	}
	
	function genDaftarOpsi(){
		global $Ref, $Main;
		$fmPILGEDUNG = $_REQUEST['fmPILGEDUNG'];
		$CrRuang = $_REQUEST['CrRuang'];
	
		$arr = array(	
			array('1','GEDUNG'),	
			array('2','RUANG'),
			);	
		
		$c1 = $_REQUEST['RuangPilihSkpdfmURUSAN'];
		$c = $_REQUEST['RuangPilihSkpdfmSKPD'];
		$d = $_REQUEST['RuangPilihSkpdfmUNIT'];
		$e = $_REQUEST['RuangPilihSkpdfmSUBUNIT'];
		$e1 = $_REQUEST['RuangPilihSkpdfmSEKSI'];
		$dafSKPD=mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));
		if ($Main->URUSAN!='1'){
		if ($c==''){
			
			$c = $_REQUEST['fmBIDANG'];
			$d = $_REQUEST['fmSKPD'];
			$e = $_REQUEST['fmUNIT'];
			$e1 = $_REQUEST['fmSUBUNIT'];
		}else{
			
			$c = $_REQUEST['RuangPilihSkpdfmSKPD'];
			$d = $_REQUEST['RuangPilihSkpdfmUNIT'];
			$e = $_REQUEST['RuangPilihSkpdfmSUBUNIT'];
			$e1 = $_REQUEST['RuangPilihSkpdfmSEKSI'];
		}
		
			$pil="<table width=\"100%\" class=\"adminform\">
			<tr>
			<td style='width:75px'>BIDANG</td><td style='width:10px'>:</td>
				<td>".
					cmbQuery("fmBIDANG",$c,"SELECT c,concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c!=00 and d=00 and e=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td>
			</tr>
			<tr>
			<td style='width:50px'>SKPD</td><td style='width:10px'>:</td>
				<td>".
					cmbQuery("fmSKPD",$d,"SELECT d,concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c='$c' and d!=00 and e=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td>
			</tr>
			<tr>
			<td style='width:50px'>UNIT</td><td style='width:10px'>:</td>
				<td>".
					cmbQuery("fmUNIT",$e,"SELECT e,concat(e, '. ', nm_skpd) as vnama FROM ref_skpd where c='$c' and d='$d' and e!=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td>
			</tr>
			<tr>
			<td style='width:50px'>SUB UNIT</td><td style='width:10px'>:</td>
				<td>".
					cmbQuery("fmSUBUNIT",$e1,"SELECT e1,concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c='$c' and d='$d' and e='$e' and e1!='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td>
			</tr>
			</table>".
			genFilterBar(
			array("<table>
						<tr>
						<td>
						<td>".
						"Cari Gedung/Ruang :
						<input type='text' value='".$CrRuang."' name='CrRuang' id='CrRuang' placeholder='Gedung / Ruang'>
						<input type='button' id='btTampil' value='Cari' onclick='".$this->Prefix.".refreshList(true)'>
						<input type='hidden'  name='dat_urusan' id='dat_urusan' value='".$Main->URUSAN."' >
							</td>
						</tr>
						</table>
				"),'',''
				
			);
		}else{

		if ($c1==''){
			$c1 = $_REQUEST['fmURUSAN'];
			$c = $_REQUEST['fmBIDANG'];
			$d = $_REQUEST['fmSKPD'];
			$e = $_REQUEST['fmUNIT'];
			$e1 = $_REQUEST['fmSUBUNIT'];
		}else{
			$c1 = $_REQUEST['RuangPilihSkpdfmURUSAN'];
			$c = $_REQUEST['RuangPilihSkpdfmSKPD'];
			$d = $_REQUEST['RuangPilihSkpdfmUNIT'];
			$e = $_REQUEST['RuangPilihSkpdfmSUBUNIT'];
			$e1 = $_REQUEST['RuangPilihSkpdfmSEKSI'];
		}
		$cek.="SELECT e1,concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'";
	
			$pil="<table width=\"100%\" class=\"adminform\">
			<tr>		
			<td width=\"50%\" valign=\"top\">		
			 <table style='width:100%'>
			<tr>
			<td style='width:75px'>URUSAN</td><td style='width:10px'>:</td>
				<td>".
					cmbQuery("fmURUSAN",$c1,"SELECT c1,concat(c1,'.',nm_skpd) as vnama FROM ref_skpd where c1!='0' and c=00 and d=00 and e=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td>
			</tr>
			<tr>
			<td style='width:50px'>BIDANG</td><td style='width:10px'>:</td>
				<td>".
					cmbQuery("fmBIDANG",$c,"SELECT c,concat(c, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$c1' and c!=00 and d=00 and e=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td>
			</tr>
			<tr>
			<td style='width:50px'>SKPD</td><td style='width:10px'>:</td>
				<td>".
					cmbQuery("fmSKPD",$d,"SELECT d,concat(d, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$c1' and c='$c' and d!=00 and e=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td>
			</tr>
			<tr>
			<td style='width:50px'>UNIT</td><td style='width:10px'>:</td>
				<td>".
					cmbQuery("fmUNIT",$e,"SELECT e,concat(e, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e!=00 and e1=000","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td>
			</tr>
			<tr>
			<td style='width:50px'>SUB UNIT</td><td style='width:10px'>:</td>
				<td>".
					cmbQuery("fmSUBUNIT",$e1,"SELECT e1,concat(e1, '. ', nm_skpd) as vnama FROM ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1!='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
				"</td>
			</tr>
			</table>".
			genFilterBar(
			array("<table>
						<tr>
						<td>
						<td>".
						"Cari Gedung/Ruang :
						<input type='text' value='".$CrRuang."' name='CrRuang' id='CrRuang' placeholder='Gedung / Ruang'>
						<input type='button' id='btTampil' value='Cari' onclick='".$this->Prefix.".refreshList(true)'>
						<input type='hidden'  name='dat_urusan' id='dat_urusan' value='".$Main->URUSAN."' >
						<input type='hidden'  name='c1' id='c1' value='".$c1."' >
					<input type='hidden'  name='c' id='c' value='".$c."' >
					<input type='hidden'  name='d' id='d' value='".$d."' >
					<input type='hidden'  name='e' id='e' value='".$e."' >
					<input type='hidden'  name='e1' id='e1' value='".$e1."' >
							</td>
						</tr>
						</table>
				"),'',''
			);	
	}
				
		$TampilOpt =$pil;
		return array('TampilOpt'=>$TampilOpt);
	}
	
	
	function getDaftarOpsi($Mode=1){
	global $Main, $HTTP_COOKIE_VARS;
	
		$cek='';
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$urusan = $Main->URUSAN;
		$fmPILGEDUNG = $_REQUEST['fmPILGEDUNG'];
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		$CrRuang = $_REQUEST['CrRuang'];
		
		$c1 = $_REQUEST['RuangPilihSkpdfmURUSAN'];
		
		if ($urusan!='1'){
		//------level 4
		if ($c==''){
			
			$c = $_REQUEST['fmBIDANG'];
			$d = $_REQUEST['fmSKPD'];
			$e = $_REQUEST['fmUNIT'];
			$e1 = $_REQUEST['fmSUBUNIT'];
		}else{
			
			$c = $_REQUEST['RuangPilihSkpdfmSKPD'];
			$d = $_REQUEST['RuangPilihSkpdfmUNIT'];
			$e = $_REQUEST['RuangPilihSkpdfmSUBUNIT'];
			$e1 = $_REQUEST['RuangPilihSkpdfmSEKSI'];
		}
				
		if(empty($c)) {
			$d='';
			$e='';
			$e1='';
		}
		
		if(empty($d)) {
			$e='';
			$e1='';
		}
		
		if(empty($e)) {
			$e1='';
		}
		
		if(empty($c) && empty($d) && empty($e)  && empty($e1))
		{
			$arrKondisi[]= "a1 ='".$Main->DEF_KEPEMILIKAN."' and a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='0' ";
		}
		
		elseif(!empty($c) && empty($d) && empty($e) && empty($e1))
		{
			$arrKondisi[]= "a1 ='".$Main->DEF_KEPEMILIKAN."' and a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='0' and c='$c' and d='00' and e='00' and e1='000'";		
		}
		
		elseif(!empty($c) && !empty($d) && empty($e) && empty($e1))
		{
			$arrKondisi[]= "a1 ='".$Main->DEF_KEPEMILIKAN."' and a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='0' and c='$c' and d='$d' and e!='00' and e1!='000'";		
		}
		
		elseif(!empty($c) && !empty($d) && !empty($e) && empty($e1))
		{
			$arrKondisi[]= "a1 ='".$Main->DEF_KEPEMILIKAN."' and a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='0' and c='$c' and d='$d' and e='$e' and e1!='000'";		
		}
		
		elseif(!empty($c) && !empty($d) && !empty($e) && !empty($e1))
		{
			$arrKondisi[]= "a1 ='".$Main->DEF_KEPEMILIKAN."' and a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='0' and c='$c' and d='$d' and e='$e' and e1='$e1'";		
		}
	
		}else{
			
			if ($c1==''){
			$c1 = $_REQUEST['fmURUSAN'];
			$c = $_REQUEST['fmBIDANG'];
			$d = $_REQUEST['fmSKPD'];
			$e = $_REQUEST['fmUNIT'];
			$e1 = $_REQUEST['fmSUBUNIT'];
		}else{
			$c1 = $_REQUEST['RuangPilihSkpdfmURUSAN'];
			$c = $_REQUEST['RuangPilihSkpdfmSKPD'];
			$d = $_REQUEST['RuangPilihSkpdfmUNIT'];
			$e = $_REQUEST['RuangPilihSkpdfmSUBUNIT'];
			$e1 = $_REQUEST['RuangPilihSkpdfmSEKSI'];
		}
				
		if(empty($c1)) {
			$c= '';
			$d='';
			$e='';
			$e1='';
		}
		
		if(empty($c)) {
			$d='';
			$e='';
			$e1='';
		}
		
		if(empty($d)) {
			$e='';
			$e1='';
		}
		
		if(empty($e)) {
			$e1='';
		}
		
		if(empty($c1) && empty($c) && empty($d) && empty($e)  && empty($e1))
		{
			$arrKondisi[]= "a1 ='".$Main->DEF_KEPEMILIKAN."' and a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."'";
		}
		
		elseif(!empty($c1) && empty($c) && empty($d) && empty($e) && empty($e1))
		{
			$arrKondisi[]= "a1 ='".$Main->DEF_KEPEMILIKAN."' and a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='$c1' and c!='00' and d!='00' and e!='00' and e1!='000'";		
		}
		
		elseif(!empty($c1) && !empty($c) && empty($d) && empty($e) && empty($e1))
		{
			$arrKondisi[]= "a1 ='".$Main->DEF_KEPEMILIKAN."' and a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='$c1' and c='$c' and d!='00' and e!='00' and e1!='000'";		
		}
		
		elseif(!empty($c1) && !empty($c) && !empty($d) && empty($e) && empty($e1))
		{
			$arrKondisi[]= "a1 ='".$Main->DEF_KEPEMILIKAN."' and a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='$c1' and c='$c' and d='$d' and e!='00' and e1!='000'";		
		}
		
		elseif(!empty($c1) && !empty($c) && !empty($d) && !empty($e) && empty($e1))
		{
			$arrKondisi[]= "a1 ='".$Main->DEF_KEPEMILIKAN."' and a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1!='000'";		
		}
		
		elseif(!empty($c1) && !empty($c) && !empty($d) && !empty($e) && !empty($e1))
		{
			$arrKondisi[]= "a1 ='".$Main->DEF_KEPEMILIKAN."' and a='".$Main->Provinsi[0]."' and b='".$Main->DEF_WILAYAH."' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'";		
		}
				
		}
		
		$cek .= 'prefix='.$this->Prefix;
		$fmPILGEDUNG = $_REQUEST['fmPILGEDUNG'];
		if(!empty($_POST['CrRuang']) ) $arrKondisi[] = " nm_ruang like '%".$_POST['CrRuang']."%'";
				
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');				
		$Asc = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		$arrOrders[] = " a1,a,b,c1,c,d,e,e1 ";
		$isivalue=explode('.',$fmPILCARIvalue);
		
		switch($fmPILCARI){			
			case 'selectRuang': $arrKondisi[] = " nm_ruang like '%$fmPILCARIvalue%'"; break;	
		}		
		
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
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal, 'cek'=>$cek);
		
	}
	
	
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';		
		$form_name = $this->Prefix.'_Form';
		
		$fmURUSAN = $_REQUEST['fmURUSAN'];
		$fmSKPD = $_REQUEST['fmSKPD'];
		$fmUNIT = $_REQUEST['fmUNIT'];
		$fmSUBUNIT = $_REQUEST['fmSUBUNIT'];
		$fmSEKSI = $_REQUEST['fmSEKSI'];
			
		$FormContent = $this->genDaftarInitial($fmURUSAN, $fmSKPD, $fmUNIT, $fmSUBUNIT, $fmSEKSI);
		$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						1000,
						400,
						'Pilih Ruang',
						'',
						"<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
						"<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
		);
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function set_selector_other2($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){				
			case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
				break;
			}
			default:{
				$err = 'tipe tidak ada!';
				break;
			}
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function genDaftarInitial($fmURUSAN='', $fmSKPD='', $fmUNIT='', $fmSUBUNIT='', $fmSEKSI=''){
		$vOpsi = $this->genDaftarOpsi();
		
		return			
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 
			"<input type='hidden' id='RuangPilihSkpdfmURUSAN' name='RuangPilihSkpdfmURUSAN' value='$fmURUSAN'>".
			"<input type='hidden' id='RuangPilihSkpdfmSKPD' name='RuangPilihSkpdfmSKPD' value='$fmSKPD'>".
			"<input type='hidden' id='RuangPilihSkpdfmUNIT' name='RuangPilihSkpdfmUNIT' value='$fmUNIT'>".
			"<input type='hidden' id='RuangPilihSkpdfmSUBUNIT' name='RuangPilihSkpdfmSUBUNIT' value='$fmSUBUNIT'>".
			"<input type='hidden' id='RuangPilihSkpdfmSEKSI' name='RuangPilihSkpdfmSEKSI' value='$fmSEKSI'>".
			"</div>".					
			"<div id=garis style='height:1;border-bottom:1px solid #E5E5E5;'></div>".
			"<div id=contain style='overflow:auto;height:256;'>".
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".					
			"</div>
			</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
				"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
			"</div>";
	}
	
}
$RuangPilih = new RuangPilihObj();

?>