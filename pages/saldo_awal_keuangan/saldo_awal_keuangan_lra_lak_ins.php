<?php

class saldo_awal_keuangan_lra_lak_insObj  extends DaftarObj2{	
	var $Prefix = 'saldo_awal_keuangan_lra_lak_ins';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_saldo_keu'; //bonus
	var $TblName_Hapus = 't_saldo_keu';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Data Saldo Awal Keuangan - LRA & LAK';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'SALDO AWAL LRA & LAK';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'saldo_awal_keuangan_lra_lak_insForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	var $arrJns = array( 
		array('0','Debet'),
		array('1','Kredit')
		);
	
	function setTitle(){
		return 'SALDO AWAL KEUANGAN - LRA & LAK';
	}
	
	function setMenuEdit(){
		return "";
	}
	
	function setMenuView(){
		
			}
		
	var $arrayKategori = array( 
					 array('0','Debet'),
					 array('1','Kredit')			 
		);	
	
	function setPage_Header(){		
		return createHeaderPage($this->PageIcon, $this->PageTitle,  
			'', FALSE, 'pageheader', $this->ico_width, $this->ico_height
		);
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
		
		case 'namajurnal':{
			$cek = '';
			$err = '';
			$content = '';
			$idrek = $_REQUEST['idrek'];
			$koderek = addslashes($_REQUEST['Id_jurnal']);
		//	1.1.1.02.02
		
			$ka = substr($koderek, 0,1);
			$kb = substr($koderek, 2,1);
			$kc = substr($koderek, 4,1);
			$kd = substr($koderek, 6,1);
			$ke = substr($koderek, 8,1);
			/*$ka = substr($koderek, 0,1);
			$kb = substr($koderek, 2,1);
			$kc = substr($koderek, 4,1);
			$kd = substr($koderek, 7,1);
			$ke = substr($koderek, 10,1);*/
			
			$kodeJurnal=$ka.'.'.$kb.'.'.$kc.'.'.$kd.'.'.$ke;
			
			$qry = "SELECT nm_account FROM ref_jurnal WHERE concat(ka,'.',kb,'.',kc,'.',kd,'.',ke) = '$kodeJurnal' AND ka!='0' AND kb!='0' AND kc!='0' AND kd!='0' AND ke!='0'"; $cek.=$qry;
			$aqry = mysql_query($qry);
			$daqry = mysql_fetch_array($aqry);
			$kde_dt = sprintf("%02s",$kd);
			$kde_de = sprintf("%02s",$ke);
		
			/*if($daqry['nm_account']=='' && $ka==$ka && $kb==$kb && $kc==$kc && $kd=='' && $ke==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$de' tidak ada";	
			}elseif($daqry['nm_account']=='' && $ka==$ka && $kb==$kb && $kc==$kc && $kd==$kd && $ke==''){
				$err="Kode Akun '$ka.$kb.$kc.$kde_dt.$de' tidak ada";	
			}elseif($daqry['nm_account']=='' && $ka==$ka && $kb==$kb && $kc==$kc && $kd==$kd && $ke==$ke){
				$err="Kode Akun '$ka.$kb.$kc.$kde_dt.$kde_de' tidak ada";	
			}  */
			
			$content['namarekening'] = $daqry['nm_account'];
			$content['idrek'] = $idrek;
			
		break;
	    }
		
		case 'dat_saldo_awal':{
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$IDUBAH = $_REQUEST['idubah'];
		$qrydel1 = "DELETE FROM t_saldo_keu_det WHERE status='1' and refid_jurnal='$idplh' ";
		$aqrydel1 = mysql_query($qrydel1);
		
		$qrydel2 = "DELETE FROM t_saldo_keu_det WHERE status='1' and refid_jurnal='$IDUBAH' ";
		$aqrydel2 = mysql_query($qrydel2);
		
			$get= $this->data_saldo_awal();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];								
			break;
	    }
		case 'Editinput':{
			$cek = '';
			$err = '';
			$content = '';
			$uid = $HTTP_COOKIE_VARS['coID'];
			$idrek = $_REQUEST['idrekeningnya'];
			
			$qry = "SELECT * FROM t_saldo_keu_det WHERE Id='$idrek'";$cek.=$qry;
			$aqry = mysql_query($qry);
			$dt = mysql_fetch_array($aqry);
			$kode_dt = sprintf("%02s",$dt['kd']);
			$kode_de = sprintf("%02s",$dt['ke']);
			$content['koderek'] = "
				<input type='text' onkeyup='setTimeout(function myFunction() {saldo_awal_keuangan_lra_lak_ins.namajurnal();},1000);' name='Id_jurnal' id='Id_jurnal' value='".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke']."' style='width:70px;' maxlength='25' />"
				."<input type='hidden' name='idrek' id='idrek' value='".$idrek."' />
				
				<a href='javascript:cr_jurnal.windowShow(".$dt['Id'].");'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>
				";
			$debetkredit=$dt['debetkredit'];
			if ($debetkredit=='0'){
					$jml_saldo_ = $dt['debet'];
				}else{
					$jml_saldo_ = $dt['kredit'];
			}
			
			$nilaiDebetKredit=$dt['debetkredit'];
				if ($nilaiDebetKredit=='0'){
					$cmbDebetKredit='Debet';
				}else{
					$cmbDebetKredit='Kredit';
				}
			
			$content['jml_saldo'] = "<input type='text' name='jml_saldo' id='jml_saldo' value='".floatval($jml_saldo_)."' style='text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatsaldo`).innerHTML = saldo_awal_keuangan_lra_lak_ins.formatCurrency(this.value);' />
							<span id='formatsaldo'></span>";
							
			$content['jml_anggaran'] = "<input type='text' name='jml_anggaran' id='jml_anggaran' value='".floatval($dt['anggaran'])."' style='text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatanggaran`).innerHTML = saldo_awal_keuangan_lra_lak_ins.formatCurrency(this.value);' />
							<span id='formatanggaran'></span>";
											
			$content['idrek'] = $idrek;
			$content['option'] = "
				<a href='javascript:saldo_awal_keuangan_lra_lak_ins.updKodeJurnal()' />
					<img src='datepicker/save.png' style='width:20px;height:20px;' />
				</a>";
				
			$nilaiDebetKredit=$dt['debetkredit'];
				if ($nilaiDebetKredit=='0'){
					$cmbDebetKredit='Debet';
				}else{
					$cmbDebetKredit='Kredit';
				}
					
			$content['DebetKredit'] = cmbArray('DebetKredit',$dt['debetkredit'],$this->arrJns,'--PILIH--','style=width:100px;');	
			$content['atasbutton'] = "<a href='javascript:saldo_awal_keuangan_lra_lak_ins.dat_saldo_awal()' /><img src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>";
		break;
	    }
		
		
		
		case 'HapusJurnal':{
			$cek = '';
			$err = '';
			$content = '';
			$uid = $HTTP_COOKIE_VARS['coID'];
			$idrekei = $_REQUEST['idrekei'];
			$idplh = $_REQUEST[$this->Prefix.'_idplh'];
			
			$hapus="delete from t_saldo_keu_det where Id='$idrekei'";
			$aqrhapus = mysql_query($hapus);
					
		break;
	    }
		
		case 'DetailJurnal':{
			$get= $this->TampilDetailJurnal();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];								
			break;
	    }
		
		case 'EditJurnal':{
			$get= $this->EditJurnal();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];								
			break;
	    }
		
		case 'cek_saldo_jurnal':{
			$get= $this->cek_saldo_jurnal();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];								
			break;
	    }
		
		case 'input_Jurnal':{
		global $Main, $HTTP_COOKIE_VARS;
		
		$coThnAnggaran = $_COOKIE['coThnAnggaran'];
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$IDUBAH = $_REQUEST['idubah'];
		if ($idplh!=0){
			$qry_jurnal_det="INSERT INTO t_saldo_keu_det (refid_jurnal,status,tipe_jurnal,thn_anggaran) values ('$idplh','1','2','$coThnAnggaran')";$cek.=$qry_jurnal_det;
			$qry_jurnal_keuangan_det = mysql_query($qry_jurnal_det);
			
		}else{
			$qry_jurnal_det="INSERT INTO t_saldo_keu_det (refid_jurnal,status,tipe_jurnal,thn_anggaran) values ('$IDUBAH','1','2','$coThnAnggaran')";$cek.=$qry_jurnal_det;
		$qry_jurnal_keuangan_det = mysql_query($qry_jurnal_det);
		}
			$get= $this->data_saldo_awal();
			$cek = $get['cek'];
			$err = $get['err'];
			
			$content = $get['content'];								
			break;
	    }
		
		case 'updKodeJurnal':{
		global $HTTP_COOKIE_VARS;
		global $Main;
		
			$cek = '';
			$err = '';
			$content = '';
			
			$c1x = $_REQUEST['c1'];
			$cx = $_REQUEST['c'];
			$dx = $_REQUEST['d'];
			$ex = $_REQUEST['e'];
			$e1x = $_REQUEST['e1'];
			
			$c1 = $_REQUEST['c1'];
			$c = $_REQUEST['c'];
			$d = $_REQUEST['d'];
			$e = $_REQUEST['e'];
			$e1 = $_REQUEST['e1'];
			$DebetKredit = $_REQUEST['DebetKredit'];
			$uid = $HTTP_COOKIE_VARS['coID'];
			$idrek = $_REQUEST['idrek'];
			$Id_jurnal = $_REQUEST['Id_jurnal'];
			$jumlahharga = $_REQUEST['jml_saldo'];
			$jml_anggaran = $_REQUEST['jml_anggaran'];
			$jns_jurnal = $_REQUEST['jns_jurnal'];
			$saldo_awal = $_REQUEST['saldo_awal'];
			$anggaran = $_REQUEST['anggaran'];
			$anggaran3 = $_REQUEST['jml_anggaran'];
			$idplh = $_REQUEST[$this->Prefix.'_idplh'];
			
			$saldo_awal = explode("-",$saldo_awal);
			$saldo_awal2 = $saldo_awal[2].'-'.$saldo_awal[1].'-'.$saldo_awal[0];
			
			$anggaran = explode("-",$anggaran);
			$anggaran2 = $anggaran[2].'-'.$anggaran[1].'-'.$anggaran[0];
			
			$qry = "SELECT * FROM t_saldo_keu_det WHERE Id='$idrek'";$cek.=$qry;
			$aqry = mysql_query($qry);
			$cek_status = mysql_fetch_array($aqry);
			if($cek_status['status']=='1'){
			if($err=='' && $jumlahharga < 1 )$err='Jumlah Harga Belum Di Isi !';
			
			if( $err=='' && $DebetKredit =='' ) $err= 'Jenis Debet / Kredit Belum di Pilih !!';
			if($DebetKredit =='0'){
				$debet=$jumlahharga;
				$kredit=0;
			}else{
				$debet=0;
				$kredit=$jumlahharga;
			}
			
			$kode = explode(".",$Id_jurnal);
				$ka = $kode[0];
				$kb = $kode[1];
				$kc = $kode[2];
				$kd = $kode[3];
				$ke = $kode[4];
				$kf = $kode[5];
				
				$kd_1='1';
				$kd_2='2';
				$kd_3='3';
				$kd_8='8';
				$kd_9='9';	
			
			if($ka ==$kd_1) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus NERACA";
			if($ka ==$kd_2) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus NERACA";
			if($ka ==$kd_3) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus NERACA";
			if($ka ==$kd_8) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus LO";
			if($ka ==$kd_9) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus LO";
			
			if($ka ==$ka && $kb==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}elseif($ka ==$ka && $kb==$kb && $kc==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}elseif($ka ==$ka && $kb==$kb && $kc==$kc && $kd==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}elseif($ka ==$ka && $kb==$kb && $kc==$kc && $kd==$kd && $ke==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}
				
			$nm_jurnal=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and kf='$kf'"));
			if($nm_jurnal=='')$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak ada ";
			$cek_dat=mysql_fetch_array(mysql_query("select count(*) as cnt from t_saldo_keu_det where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and tipe_jurnal='2'"));
			$cek.="select count(*) as cnt from t_saldo_keu_det where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and tipe_jurnal='2'";
			if($cek_dat['cnt']>0)$err='Kode akun Sudah ada';
			
			}elseif($cek_status['status']=='2'){
			//status 2	
			if($err=='' && $jumlahharga < 1 )$err='Jumlah Harga Belum Di Isi !';
			
			if( $err=='' && $DebetKredit =='' ) $err= 'Jenis Debet / Kredit Belum di Pilih !!';
			if($DebetKredit =='0'){
				$debet=$jumlahharga;
				$kredit=0;
			}else{
				$debet=0;
				$kredit=$jumlahharga;
			}
			
			$kode = explode(".",$Id_jurnal);
				$ka = $kode[0];
				$kb = $kode[1];
				$kc = $kode[2];
				$kd = $kode[3];
				$ke = $kode[4];
				$kf = $kode[5];
				$kd_1='1';
				$kd_2='2';
				$kd_3='3';
				$kd_8='8';
				$kd_9='9';	
			
			if($ka ==$kd_1) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus NERACA";
			if($ka ==$kd_2) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus NERACA";
			if($ka ==$kd_3) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus NERACA";
			if($ka ==$kd_8) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus LO";
			if($ka ==$kd_9) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus LO";
			
			if($ka ==$ka && $kb==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}elseif($ka ==$ka && $kb==$kb && $kc==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}elseif($ka ==$ka && $kb==$kb && $kc==$kc && $kd==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}elseif($ka ==$ka && $kb==$kb && $kc==$kc && $kd==$kd && $ke==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}
			
			$nm_jurnal=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and kf='$kf'"));
			if($nm_jurnal=='')$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak ada ";
			
			$cek_dat=mysql_fetch_array(mysql_query("select * from t_saldo_keu_det where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and tipe_jurnal='2'"));
			$cek_dat2=mysql_fetch_array(mysql_query("select count(*) as cnt,Id from t_saldo_keu_det where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and tipe_jurnal='2'"));
		
			if($cek_dat['Id']==$idrek && $cek_dat2['cnt']>0){
				
			$jns_status=mysql_fetch_array(mysql_query("select * from t_saldo_keu_det where refid_jurnal='$idplh' and status='1'"));
			$qryupd="UPDATE t_saldo_keu_det SET c1='$c1',c='$c',d='$d',e='$e',e1='$e1',ka='$ka',kb='$kb',kc='$kc',kd='$kd',ke='$ke',kf='$kf',debet='$debet',kredit='$kredit',status='2',nm_account='".$nm_jurnal['nm_account']."', debetkredit='$DebetKredit',jns_jurnal='$jns_jurnal',anggaran='$anggaran3',tgl_create=NOW(),uid='$uid',tgl_saldo_awal='$saldo_awal2',tgl_anggaran='$anggaran2' WHERE  Id='$idrek'";
			
			$cek.=" | ".$qryupd;
			$aqryupd = mysql_query($qryupd);
				
			}elseif($cek_dat['Id']!=$idrek && $cek_dat2['cnt']>0){
				$err='Kode akun Sudah ada';
			}
			///0	
			}elseif($cek_status['status']=='0'){
			//status 2	
				if($err=='' && $jumlahharga < 1 )$err='Jumlah Harga Belum Di Isi !';
			
			if( $err=='' && $DebetKredit =='' ) $err= 'Jenis Debet / Kredit Belum di Pilih !!';
			if($DebetKredit =='0'){
				$debet=$jumlahharga;
				$kredit=0;
			}else{
				$debet=0;
				$kredit=$jumlahharga;
			}
			
			$kode = explode(".",$Id_jurnal);
				$ka = $kode[0];
				$kb = $kode[1];
				$kc = $kode[2];
				$kd = $kode[3];
				$ke = $kode[4];
				$kf = $kode[5];
				$kd_1='1';
				$kd_2='2';
				$kd_3='3';
				$kd_8='8';
				$kd_9='9';	
			
			if($ka ==$kd_1) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus NERACA";
			if($ka ==$kd_2) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus NERACA";
			if($ka ==$kd_3) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus NERACA";
			if($ka ==$kd_8) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus LO";
			if($ka ==$kd_9) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus LO";
			
			if($ka ==$ka && $kb==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}elseif($ka ==$ka && $kb==$kb && $kc==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}elseif($ka ==$ka && $kb==$kb && $kc==$kc && $kd==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}elseif($ka ==$ka && $kb==$kb && $kc==$kc && $kd==$kd && $ke==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}
			
			$nm_jurnal=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and kf='$kf'"));
			if($nm_jurnal=='')$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak ada ";
			
			$cek_dat=mysql_fetch_array(mysql_query("select * from t_saldo_keu_det where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and tipe_jurnal='2'"));
			$cek_dat2=mysql_fetch_array(mysql_query("select count(*) as cnt,Id from t_saldo_keu_det where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and tipe_jurnal='2'"));
		
			if($cek_dat['Id']==$idrek && $cek_dat2['cnt']>0){
				
			$jns_status=mysql_fetch_array(mysql_query("select * from t_saldo_keu_det where refid_jurnal='$idplh' and status='1'"));
			$qryupd="UPDATE t_saldo_keu_det SET c1='$c1',c='$c',d='$d',e='$e',e1='$e1',ka='$ka',kb='$kb',kc='$kc',kd='$kd',ke='$ke',kf='$kf',debet='$debet',kredit='$kredit',status='0',nm_account='".$nm_jurnal['nm_account']."', debetkredit='$DebetKredit',jns_jurnal='$jns_jurnal',anggaran='$anggaran3',tgl_create=NOW(),uid='$uid',tgl_saldo_awal='$saldo_awal2',tgl_anggaran='$anggaran2' WHERE  Id='$idrek'";
			
			$cek.=" | ".$qryupd;
			$aqryupd = mysql_query($qryupd);
				
			}elseif($cek_dat['Id']!=$idrek && $cek_dat2['cnt']>0){
				$err='Kode akun Sudah ada';
			}
			///0	
			}elseif($cek_status['status']=='3'){
			//status 2	
				if($err=='' && $jumlahharga < 1 )$err='Jumlah Harga Belum Di Isi !';
			
			if( $err=='' && $DebetKredit =='' ) $err= 'Jenis Debet / Kredit Belum di Pilih !!';
			if($DebetKredit =='0'){
				$debet=$jumlahharga;
				$kredit=0;
			}else{
				$debet=0;
				$kredit=$jumlahharga;
			}
			
			$kode = explode(".",$Id_jurnal);
				$ka = $kode[0];
				$kb = $kode[1];
				$kc = $kode[2];
				$kd = $kode[3];
				$ke = $kode[4];
				$kf = $kode[5];
				$kd_1='1';
				$kd_2='2';
				$kd_3='3';
				$kd_8='8';
				$kd_9='9';	
			
			if($ka ==$kd_1) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus NERACA";
			if($ka ==$kd_2) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus NERACA";
			if($ka ==$kd_3) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus NERACA";
			if($ka ==$kd_8) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus LO";
			if($ka ==$kd_9) $err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input khusus LO";
			
			if($ka ==$ka && $kb==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}elseif($ka ==$ka && $kb==$kb && $kc==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}elseif($ka ==$ka && $kb==$kb && $kc==$kc && $kd==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}elseif($ka ==$ka && $kb==$kb && $kc==$kc && $kd==$kd && $ke==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak bisa di input";
			}
			
			$nm_jurnal=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and kf='$kf'"));
			if($nm_jurnal=='')$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' tidak ada ";
			
			$cek_dat=mysql_fetch_array(mysql_query("select * from t_saldo_keu_det where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and tipe_jurnal='2'"));
			$cek_dat2=mysql_fetch_array(mysql_query("select count(*) as cnt,Id from t_saldo_keu_det where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1' and tipe_jurnal='2'"));
		
			if($cek_dat['Id']==$idrek && $cek_dat2['cnt']>0){
				
			$jns_status=mysql_fetch_array(mysql_query("select * from t_saldo_keu_det where refid_jurnal='$idplh' and status='1'"));
			$qryupd="UPDATE t_saldo_keu_det SET c1='$c1',c='$c',d='$d',e='$e',e1='$e1',ka='$ka',kb='$kb',kc='$kc',kd='$kd',ke='$ke',kf='$kf',debet='$debet',kredit='$kredit',status='3',nm_account='".$nm_jurnal['nm_account']."', debetkredit='$DebetKredit',jns_jurnal='$jns_jurnal',anggaran='$anggaran3',tgl_create=NOW(),uid='$uid',tgl_saldo_awal='$saldo_awal2',tgl_anggaran='$anggaran2' WHERE  Id='$idrek'";
			
			$cek.=" | ".$qryupd;
			$aqryupd = mysql_query($qryupd);
				
			}elseif($cek_dat['Id']!=$idrek && $cek_dat2['cnt']>0){
				$err='Kode akun Sudah ada';
			}
			
			}
			
			if($err==''){
				
			$jns_status=mysql_fetch_array(mysql_query("select * from t_saldo_keu_det where refid_jurnal='$idplh' and status='1'"));
			$qryupd="UPDATE t_saldo_keu_det SET c1='$c1',c='$c',d='$d',e='$e',e1='$e1',ka='$ka',kb='$kb',kc='$kc',kd='$kd',ke='$ke',kf='$kf',debet='$debet',kredit='$kredit',status='2',nm_account='".$nm_jurnal['nm_account']."', debetkredit='$DebetKredit',jns_jurnal='$jns_jurnal',anggaran='$anggaran3',tgl_create=NOW(),uid='$uid',tgl_saldo_awal='$saldo_awal2',tgl_anggaran='$anggaran2' WHERE  Id='$idrek'";
				$cek.=" | ".$qryupd;
				$aqryupd = mysql_query($qryupd);
			}		
		break;
	    }
		
		case 'EditJnsJurnal':{				
				$fm = $this->setFormEditJnsJurnal();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}	
		
		case 'SimpanAll':{
				$get= $this->SimpanAll();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    }
		
		case 'SimpanAllEdit':{
				$get= $this->SimpanAllEdit();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    }
		
		case 'SimpanEditJurnal':{
				$get= $this->SimpanEditJurnal();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
			break;
	    }
			
		case 'formBaru':{				
			$fm = $this->setFormBaru();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'batalJurnal':{
			$get= $this->batalJurnal();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'batalSaldo':{
			$get= $this->batalSaldo();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'batalJurnalDetSimpan':{
			$get= $this->batalJurnalDetSimpan();
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
		
		case 'hapus':{ //untuk ref_pegawai
					$idplh= $_REQUEST['Id'];		
					$get= $this->Hapus();
					$err= $get['err']; 
					$cek = $get['cek'];
					$json=TRUE;	
					break;
		}
		
		case 'simpanJurnal':{
			$get= $this->simpanJurnal();
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
   
   function setNavAtas(){
		global $Menu;
		if($Menu) {
			return '';
		}
	}
   	
	function cek_saldo_jurnal(){
		global $Main ,$HTTP_COOKIE_VARS;
		$cek = '';
		$err = '';
		$datanya='';
		$uid = $HTTP_COOKIE_VARS['coID'];
		$IDUBAH = $_REQUEST['idubah'];
				
		$edit_jurnal=mysql_fetch_array(mysql_query("select * from t_saldo_keu where Id='$IDUBAH'"));	
		$c1=$edit_jurnal['c1'];
		$c=$edit_jurnal['c'];
		$d=$edit_jurnal['d'];
		$e=$edit_jurnal['e'];
		$e1=$edit_jurnal['e1'];
		//
		$jnsJurnal= $_REQUEST['fmJnsJurnal'];
		$anggaran= $_REQUEST['anggaran'];
		$saldo_awal= $_REQUEST['saldo_awal'];
		$jnsJurnal= $_REQUEST['jns_jurnal'];
		
		$tgl_saldo_awal= $_REQUEST['saldo_awal'];
		$tgl_anggaran = $_REQUEST['anggaran'];
		$tgl_saldo_awal = explode("-",$tgl_saldo_awal);
	
		$tgl_saldo_awal2 = $tgl_saldo_awal[2].'-'.$tgl_saldo_awal[1].'-'.$tgl_saldo_awal[0];
		$tgl_anggaran = explode("-",$tgl_anggaran);
		$tgl_anggaran2 = $tgl_anggaran[2].'-'.$tgl_anggaran[1].'-'.$tgl_anggaran[0];
	
	$idplhnya = $dataqrytmpl['Id'];
	

	$jns = $_REQUEST['fmJnsJurnal'];
	$jenis=mysql_fetch_array(mysql_query("select * from ref_jns_jurnal where nm_jns_jurnal='$jns'"));
	$cek.="select * from ref_jns_jurnal where nm_jns_jurnal='$jns'";
	
	$nilaidebet=mysql_fetch_array(mysql_query("select sum(debet) as debet from t_saldo_keu_det where refid_jurnal='$IDUBAH' order by debetkredit DESC"));
	
		$debet=$nilaidebet['debet'];
		$debet1=$nilaidebet['debet'];
		$debet=number_format($debet,2, ',', '.');
		$nilaikredit=mysql_fetch_array(mysql_query("select sum(kredit) as kredit from t_saldo_keu_det where refid_jurnal='$IDUBAH' order by debetkredit DESC "));
		$kredit=$nilaikredit['kredit'];
		$kredit1=$nilaikredit['kredit'];
		$kredit=number_format($kredit,2, ',', '.');
		$total=$debet1-$kredit1;
		$total=number_format($total,2, ',', '.');
		
		$nilai_anggaran=mysql_fetch_array(mysql_query("select sum(t_saldo_keu_det.anggaran) as anggaran from t_saldo_keu_det where refid_jurnal='$IDUBAH' order by debetkredit DESC "));
		$anggaran=number_format($nilai_anggaran['anggaran'],2, ',', '.');
		
	$cek.="select * t_saldo_keu_det where debet='$total'";
	if($total!=0){
		$ck_saldo=mysql_fetch_array(mysql_query("select * from t_saldo_keu_det where refid_jurnal='$IDUBAH'"));
		
		$aqry ="UPDATE t_saldo_keu_det set status='3' ,jns_jurnal='$jnsJurnal',tgl_anggaran='$tgl_anggaran2',tgl_saldo_awal='$tgl_saldo_awal2',tipe_jurnal='2',tgl_create=NOW(),uid='$uid' where refid_jurnal='".$IDUBAH."'";$cek.=$aqry;
		$qry = mysql_query($aqry);
		
		$aqry2 ="UPDATE t_saldo_keu set status='3' where Id='".$IDUBAH."'";$cek.=$aqry;
		$qry2 = mysql_query($aqry2);

	}
	
	if($total==0){
		$jurnal_cek1=mysql_fetch_array(mysql_query("select count(*) as cnt from t_saldo_keu_det where refid_jurnal='$IDUBAH'"));
		if($jurnal_cek1['cnt']!=0 && $total==0){
		
		$aqry ="UPDATE t_saldo_keu_det set status='0' ,jns_jurnal='$jnsJurnal',tgl_saldo_awal='$tgl_saldo_awal2',tgl_anggaran='$tgl_anggaran2',tipe_jurnal='2',tgl_create=NOW(),uid='$uid' where refid_jurnal='".$IDUBAH."'";$cek.=$aqry;
		$qry = mysql_query($aqry);
		
		$aqry2 ="UPDATE t_saldo_keu set status='0' where Id='".$IDUBAH."'";$cek.=$aqry;
		$qry2 = mysql_query($aqry2);
		
		}else{
			$aqry12 ="UPDATE t_saldo_keu set status='3' where Id='".$IDUBAH."'";$cek.=$aqry;
			$qry12 = mysql_query($aqry12);	
		}	
	}
		
	$jurnal_cek=mysql_fetch_array(mysql_query("select count(*) as cnt from t_saldo_keu_det where refid_jurnal='$IDUBAH'"));
		
		$content =
		genFilterBar(
				array("<table >			
						<tr>
						<span style='color:black;font-size:14px;font-weight:bold;'>RINCIAN SALDO AWAL KEUANGAN - NERACA</span>
						</tr>
						</table>
				"),'','').
				
			genFilterBar(
				array("<table>
				<tr>
				<td>&nbsp&nbsp&nbsp&nbsp&nbsp	INFORMASI SALDO</td>
				<td>&nbsp&nbsp&nbsp&nbsp&nbsp	INFORMASI ANGGARAN</td>		
				</tr>
				<td>
				<table>
				<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH DEBET </td><td>:
						<span align='right' id='nilai_debet'>
						<input type='text' name='nilai_debet' id='nilai_debet' value='$debet' style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span></td>
						</td></tr>
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH KREDIT </td><td>:
						<span align='right' id='nilai_kredit'>
						<input type='text' name='nilai_kredit' id='nilai_kredit' value='$kredit'style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span> </td>
						</td></tr>
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						 </td><td>&nbsp&nbsp--------------------------------------</td>
						</td></tr>
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH SALDO </td><td>:
						<span  align='right' id='total'>
						<input type='text' name='total' id='total' value='$total' style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span>
						</td>
						</td></tr>
				</table>
				</td>
				<td>
				<table>
				<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH ANGGARAN </td><td>:
						<span align='right' id='nilai_debet'>
						<input type='text' name='nilai_anggaran' id='nilai_anggaran' value='$anggaran' style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span></td>
						</td></tr>
						<tr><td>.</td></tr>
						<tr><td>.</td></tr>
						<tr><td>.</td></tr>
						<tr><td>.</td></tr>
				</table>			
			</table>
				"),'','');				
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
		
    function EditJurnal(){
	global $Main;
	$cek = '';
	$err = '';
	$datanya='';
	$IDUBAH = $_REQUEST['idubah'];
			
	$edit_jurnal=mysql_fetch_array(mysql_query("select * from t_saldo_keu where Id='$IDUBAH'"));	
	$cek.="select * from t_saldo_awal_keu where Id='$IDUBAH'";
	$c1=$edit_jurnal['c1'];
	$c=$edit_jurnal['c'];
	$d=$edit_jurnal['d'];
	$e=$edit_jurnal['e'];
	$e1=$edit_jurnal['e1'];
	
	$idplhnya = $dataqrytmpl['Id'];
	
	$dd1="select * from t_jurnal_keuangan where Id='$aa'"; $cek.= $dd1;
	$jns = $_REQUEST['fmJnsJurnal'];
	$jenis=mysql_fetch_array(mysql_query("select * from ref_jns_jurnal where nm_jns_jurnal='$jns'"));
	$cek.="select * from ref_jns_jurnal where nm_jns_jurnal='$jns'";
			
	$qry_c1=mysql_fetch_array(mysql_query("SELECT c1, nm_skpd FROM ref_skpd WHERE c1='$c1' and c = '00' and d='00' and e='00' and e1='000'")) ;
	$qry_c=mysql_fetch_array(mysql_query("SELECT c, nm_skpd FROM ref_skpd WHERE c1='$c1' and c='$c' and d= '00' and e='00' and e1='000'")) ; $cek.="SELECT c, nm_skpd FROM ref_skpd WHERE c1='$c1' and c='$c' and d= '00' and e='00' and e1='000'";
	$qry_d=mysql_fetch_array(mysql_query("SELECT d, nm_skpd FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e='00' and e1='000'")) ;
	$qry_e=mysql_fetch_array(mysql_query("SELECT e, nm_skpd FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e='$e' and e1='000'")) ;
	$qry_e1=mysql_fetch_array(mysql_query("SELECT e1, nm_skpd FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'")) ;
			
	$dat_c1=$qry_c1['c1'].".  ".$qry_c1['nm_skpd'];
	$dat_c=$qry_c['c'].". ".$qry_c['nm_skpd'];
	$dat_d=$qry_d['d'].". ".$qry_d['nm_skpd'];
	$dat_e=$qry_e['e'].". ".$qry_e['nm_skpd'];
	$dat_e1=$qry_e1['e1'].". ".$qry_e1['nm_skpd'];
	
	$queryJnsJurnal="SELECT Id,nm_jns_jurnal FROM ref_jns_jurnal where st_pilih='1' ORDER BY Id asc"; $cek.=$queryJnsJurnal;
	
	$tgl_bukti=$edit_jurnal['tgl_bukti'];
	$tgl_bukti = explode("-",$tgl_bukti);
	$tgl_bukti_thn = $tgl_bukti[0];
	$tgl_bukti = $tgl_bukti[2].'-'.$tgl_bukti[1];
	
	$tgl_referensi=$edit_jurnal['tgl_referensi'];
	$tgl_referensi = explode("-",$tgl_referensi);
	$tgl_referensi_thn = $tgl_referensi[0];
	$tgl_referensi = $tgl_referensi[2].'-'.$tgl_referensi[1];
	
	$nilaidebet=mysql_fetch_array(mysql_query("select sum(debet) as debet from t_saldo_keu_det where refid_jurnal='$IDUBAH' order by debetkredit DESC"));
	$debet=$nilaidebet['debet'];
	$nilaikredit=mysql_fetch_array(mysql_query("select sum(t_saldo_keu_det.kredit) as kredit from t_saldo_keu_det where refid_jurnal='$IDUBAH' order by debetkredit DESC "));
	$kredit=$nilaikredit['kredit'];
	$total=$debet-$kredit;
		
	$jurnal_cek=mysql_fetch_array(mysql_query("select count(*) as cnt from t_saldo_keu_det where refid_jurnal='$IDUBAH'"));
	if($jurnal_cek['cnt']!=0 && $total==0){
		$btn_Simpan=genPanelIcon("javascript:".$this->Prefix.".SimpanAllEdit()","checkin.png","Selesai", 'Selesai');
		$btn_Batal=genPanelIcon("javascript:".$this->Prefix.".BatalJurnalDet()","cancel_f2.png","Tutup", 'Tutup');
	}else{
		$btn_Simpan='';
		$btn_Batal=genPanelIcon("javascript:".$this->Prefix.".BatalJurnalDet()","cancel_f2.png","Tutup", 'Tutup');
	}
	
		$jenis_jurnal=mysql_fetch_array(mysql_query("select * from ref_jns_jurnal where st_pilih='0' and Id='1'"));
	//	$saldo_awal_dat=mysql_fetch_array(mysql_query("select * from t_saldo_keu_det where refid_jurnal='$IDUBAH'"));
		$saldo_awal_dat=mysql_fetch_array(mysql_query("select * from t_saldo_keu where Id='$IDUBAH'"));
		$saldo_awal_dat1=$saldo_awal_dat['tgl_saldo_awal'];
		$saldo_awal_dat1 = explode("-",$saldo_awal_dat1);
		$saldo_awal_dat2 = $saldo_awal_dat1[2].'-'.$saldo_awal_dat1[1].'-'.$saldo_awal_dat1[0];
		
	//	$saldo_anggaran_dat=mysql_fetch_array(mysql_query("select * from t_saldo_keu_det where refid_jurnal='$IDUBAH'"));
		$saldo_anggaran_dat=mysql_fetch_array(mysql_query("select * from t_saldo_keu where Id='$IDUBAH'"));
		$saldo_anggaran_dat1=$saldo_anggaran_dat['tgl_anggaran'];
		$saldo_anggaran_dat1 = explode("-",$saldo_anggaran_dat1);
		$saldo_anggaran_dat2 = $saldo_anggaran_dat1[2].'-'.$saldo_anggaran_dat1[1].'-'.$saldo_anggaran_dat1[0];
		
		$jns_jurnal=$saldo_anggaran_dat['jns_jurnal'];
		$jns_jurnal2=mysql_fetch_array(mysql_query("select * from ref_jns_jurnal where Id='$jns_jurnal'"));
		$cek.="select * from ref_jns_jurnal where Id='$jns_jurnal'";
		if($IDUBAH != null){
			$content =
			genFilterBar(
				array(
				"<table>			
				<tr>
			<td style='width:130px'>URUSAN</td><td style='width:10px'>:</td>
			<td>
			<input type='text' id='c1x' name='c1x' value='".$dat_c1."' size=50px readonly>
			<input type='hidden' id='c1' name='c1' value='".$qry_c1['c1']."' size=50px>
			</td>
			</tr><tr>
			<td>BIDANG</td><td>:</td>
			<td><input type='text' id='cx' name='cx' value='".$dat_c."' size=50px readonly></td>
			<input type='hidden' id='c' name='c' value='".$qry_c['c']."' size=50px>
			</tr><tr>
			<td>SKPD</td><td>:</td>
			<td><input type='text' id='dx' name='dx' value='".$dat_d."' size=50px readonly></td>
			<input type='hidden' id='d' name='d' value='".$qry_d['d']."' size=50px >
			</tr><tr>
			<td>UNIT</td><td>:</td>
			<td><input type='text' id='ex' name='ex' value='".$dat_e."' size=50px readonly></td>
			<input type='hidden' id='e' name='e' value='".$qry_e['e']."' size=50px>
			</tr><tr>
			<td>SUB UNIT</td><td>:</td>
			<td><input type='text' id='e1x' name='e1x' value='".$dat_e1."' size=50px readonly></td>
			<input type='hidden' id='e1' name='e1' value='".$qry_e1['e1']."' size=50px>
			</tr>
			</table>
				"),'','').
			genFilterBar(
			array("<table>			
					<tr><td style='width:130px'>
					SALDO AWAL </td><td style='width:10px'>:
					<input type='text' name='saldo_awal' id='saldo_awal' value='".$saldo_awal_dat2."'size=10px readonly>
					</td>
					</td></tr>
					<tr><td>
					TAHUN ANGGARAN </td><td>:
					<input type='text' name='anggaran' id='anggaran' value='".$saldo_anggaran_dat2."'size=10px readonly>
					</td>
					</td></tr>
					<tr><td>
					JENIS JURNAL </td><td>:
					<input type='text' name='nilai_kredit' id='nilai_kredit' value='".$jns_jurnal2['nm_jns_jurnal']."' size=10px readonly>
					<input type='hidden' name='jns_jurnal' id='jns_jurnal' value='".$jenis_jurnal['Id']."' size=10px readonly>
					</td>
					</td></tr>
						
					</table>
			"),'','').
					"<div id='tbl_jurnal_detail' style='width:100%;'></div>
					 <div id='cek_data_saldo' style='width:100%;'></div>
					 <div id='tbl_jurnal' style='width:100%;'></div>".
				genFilterBar(
				array("<table>			
						<tr>
						<td>
						$btn_Simpan
						<td>$btn_Batal</td>
						</td>
						</tr>
						</table>
				"),'','');	
		}else{
			$content =
			genFilterBar(
				array(
				"<table>			
				<tr>
			<td style='width:130px'>URUSAN</td><td style='width:10px'>:</td>
			<td>
			<input type='text' id='c1x' name='c1x' value='".$dat_c1."' size=50px readonly>
			<input type='hidden' id='c1' name='c1' value='".$qry_c1['c1']."' size=50px>
			</td>
			</tr><tr>
			<td>BIDANG</td><td>:</td>
			<td><input type='text' id='cx' name='cx' value='".$dat_c."' size=50px readonly></td>
			<input type='hidden' id='c' name='c' value='".$qry_c['c']."' size=50px>
			</tr><tr>
			<td>SKPD</td><td>:</td>
			<td><input type='text' id='dx' name='dx' value='".$dat_d."' size=50px readonly></td>
			<input type='hidden' id='d' name='d' value='".$qry_d['d']."' size=50px >
			</tr><tr>
			<td>UNIT</td><td>:</td>
			<td><input type='text' id='ex' name='ex' value='".$dat_e."' size=50px readonly></td>
			<input type='hidden' id='e' name='e' value='".$qry_e['e']."' size=50px>
			</tr><tr>
			<td>SUB UNIT</td><td>:</td>
			<td><input type='text' id='e1x' name='e1x' value='".$dat_e1."' size=50px readonly></td>
			<input type='hidden' id='e1' name='e1' value='".$qry_e1['e1']."' size=50px>
			</tr>
			</table>
				"),'','');	
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
   
   function TampilDetailJurnal(){
		global $Main;
		$cek = '';
		$err = '';
		$datanya='';
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$hapus_det="delete from t_jurnal_keuangan_det where status='2' and refid_jurnal'$idplh'";
		
		$cek.=$hapus_det;
		$pil_jns_tran = "<select style='width:300px;' onchange='saldo_awal_keuangan_neraca_ins.bukarekening()' id='jns_transaksi' name='jns_transaksi'>";
		$TombolBaru = "<a href='javascript:saldo_awal_keuangan_ins.inputrekening()' /><img src='datepicker/add-256.png' style='width:20px;height:20px;' /></a>";
		$nilaidebet=mysql_fetch_array(mysql_query("select sum(t_saldo_keu_det.debet) as debet from t_saldo_keu_det where status='2' and refid_jurnal='$idplh' order by debetkredit DESC"));
		$cek.="select sum(t_saldo_keu_det.debet) as debet from t_saldo_keu_det where status='2' order by debetkredit DESC";
		$debet=$nilaidebet['debet'];
		$debet1=$nilaidebet['debet'];
		$debet=number_format($debet,2, ',', '.');
		$nilaikredit=mysql_fetch_array(mysql_query("select sum(t_saldo_keu_det.kredit) as kredit from t_saldo_keu_det where status='2' and refid_jurnal='$idplh' order by debetkredit DESC "));
		$kredit=$nilaikredit['kredit'];
		$kredit1=$nilaikredit['kredit'];
		$kredit=number_format($kredit,2, ',', '.');
		$total=$debet1-$kredit1;
		$total=number_format($total,2, ',', '.');
		
		$nilai_anggaran=mysql_fetch_array(mysql_query("select sum(t_saldo_keu_det.anggaran) as anggaran from t_saldo_keu_det where refid_jurnal='$idplh' order by debetkredit DESC "));
		$anggaran=number_format($nilai_anggaran['anggaran'],2, ',', '.');
		
		$Kolom_BTN_TombolBaru = "<th class='th01' width='50px'>
									<span id='atasbutton'>
									$TombolBaru
									</span>
								</th>";
								
	
	$jurnal_cek=mysql_fetch_array(mysql_query("select count(*) as cnt from t_saldo_keu_det where refid_jurnal='$idplh'"));
	$cek.="select count(*) as cnt from t_saldo_keu_det where refid_jurnal='$idplh'";
	if($jurnal_cek['cnt']!=0 && $total==0){
		$btn_Simpan=genPanelIcon("javascript:".$this->Prefix.".SimpanAll()","checkin.png","Simpan", 'Simpan');
		$btnBatal=genPanelIcon("javascript:".$this->Prefix.".BatalSaldo()","cancel_f2.png","Batal", 'Batal');
	}else{
		$btn_Simpan='';
		$btnBatal=genPanelIcon("javascript:".$this->Prefix.".BatalSaldo()","cancel_f2.png","Batal", 'Batal');
	}
		$content =
			genFilterBar(
				array("<table >			
						<tr>
						<span style='color:black;font-size:14px;font-weight:bold;'>RINCIAN SALDO AWAL KEUANGAN - NERACA</span>
						</tr>
						</table>
				"),'','').
			genFilterBar(
				array("<table>
				<tr>
				<td>&nbsp&nbsp&nbsp&nbsp&nbsp
						INFORMASI SALDO</td>
						
				<td>&nbsp&nbsp&nbsp&nbsp&nbsp
						INFORMASI ANGGARAN</td>		
						</tr>
				<td>
				
				<table>
				<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH DEBET </td><td>:
						<span align='right' id='nilai_debet'>
						<input type='text' name='nilai_debet' id='nilai_debet' value='$debet' style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span></td>
						</td></tr>
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH KREDIT </td><td>:
						<span align='right' id='nilai_kredit'>
						<input type='text' name='nilai_kredit' id='nilai_kredit' value='$kredit'style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span> </td>
						</td></tr>
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						 </td><td>&nbsp&nbsp--------------------------------------</td>
						</td></tr>
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH SALDO </td><td>:
						<span  align='right' id='total'>
						<input type='text' name='total' id='total' value='$total' style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span>
						</td>
						</td></tr>
				</table>
				</td>
				<td>
				<table>
				<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH ANGGARAN </td><td>:
						<span align='right' id='nilai_debet'>
						<input type='text' name='nilai_anggaran' id='nilai_anggaran' value='$anggaran' style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span></td>
						</td></tr>
						<tr><td>.</td></tr>
						<tr><td>.</td></tr>
						<tr><td>.</td></tr>
						<tr><td>.</td></tr>
					</table>
				</table>
				"),'','').
				"<div id='tbl_jurnal' style='width:100%;'></div>".
					
			genFilterBar(
				array("<table>			
						<tr>
						<td>$btn_Simpan </td><td>$btnBatal</td>
						</tr>
						</table>
				"),'','');
			
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
   function data_saldo_awal(){
		global $Main;
		$cek = '';
		$err = '';
		$datanya='';
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$idjur1= $_REQUEST['idjur'];
		$IDUBAH = $_REQUEST['idubah'];
		$pilih=$_REQUEST['databaru'];
	
	if($pilih=='2' && $IDUBAH==''){
	//new	
			
		$Id_jurnal=mysql_fetch_array(mysql_query("select Id from t_saldo_keu where status='1'"));
		$cek.="select Id from t_saldo_keu where status='1'";
		$qry_jurnal_keuangan_det = mysql_query($qry_jurnal_det);

		$jurnal_keuangan_idplh = $_REQUEST['saldo_awal_keuangan_ins_idplh'];
		
		$qry = "SELECT * FROM t_saldo_keu_det where refid_jurnal='$idplh' order by debetkredit Asc";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		while($dt = mysql_fetch_array($aqry)){
			if($dt['status'] == '2'){
			$kode_dt = sprintf("%02s",$dt['kd']);
			$kode_de = sprintf("%02s",$dt['ke']);
			$kode = "<a href='javascript:saldo_awal_keuangan_lra_lak_ins.Editinput(`".$dt['Id']."`,`".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$kode_dt.".".$kode_de.".".$dt['kf']."`);' />
					".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$kode_dt.".".$kode_de."
					</a>";
				
				$idrek = '';
				$nama_jurnal=$dt['nm_account'];
				$jml_anggaran=number_format($dt['anggaran'],2,",",".");
				$debetkredit=$dt['debetkredit'];
				if ($debetkredit=='0'){
					$jml_saldo = number_format($dt['debet'],2,",",".");
				}else{
					$jml_saldo = number_format($dt['kredit'],2,",",".");
				}
				
				$btn ="
				<a href='javascript:saldo_awal_keuangan_lra_lak_ins.HapusJurnal_1(`".$dt['Id']."`)' />
					<img src='datepicker/remove2.png' style='width:20px;height:20px;' />
				</a>";
				$nilaiDebetKredit=$dt['debetkredit'];
				if ($nilaiDebetKredit=='0'){
					$cmbDebetKredit='Debet';
				}else{
					$cmbDebetKredit='Kredit';
				}			
			}
			if($dt['status'] == '1'){	
		
			$kode = "<input type='text' onkeyup='setTimeout(function myFunction() {saldo_awal_keuangan_lra_lak_ins.namajurnal();},1000);' name='Id_jurnal' id='Id_jurnal' value='".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke']."' style='width:70px;' maxlength='25' />"
			."<a href='javascript:cr_jurnal.windowShow(".$dt['Id'].");'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>";	
				
			$idrek = "<input type='hidden' name='idrek' id='idrek' value='".$dt['Id']."' />".
					"<input type='hidden' name='statidjurnal' id='statidjurnal' value='".$dt['status']."' />";
			$nama_jurnal='';			
			$jml_saldo ="<input type='text' name='jml_saldo' id='jml_saldo' value='".floatval($dt['jumlah'])."' style='text-align:right' ;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatsaldo`).innerHTML = saldo_awal_keuangan_lra_lak_ins.formatCurrency(this.value);' />
							<span id='formatsaldo'></span>";
			$jml_anggaran ="<input type='text' name='jml_anggaran' id='jml_anggaran' value='".floatval($dt['jumlah'])."' style='text-align:right' ;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatanggaran`).innerHTML = saldo_awal_keuangan_lra_lak_ins.formatCurrency(this.value);' />
							<span id='formatanggaran'></span>";
			
			$data="<input type='text' name='namajurnal_".$dt['Id']."' id='namajurnal_".$dt['Id']."' value='".$nama."'  style='width:220px;'>";
			$btn ="
			<a href='javascript:saldo_awal_keuangan_lra_lak_ins.updKodeJurnal()' />
				<img src='datepicker/save.png' style='width:20px;height:20px;' />
			</a>"; 
			$cmbDebetKredit=cmbArray('DebetKredit',$dt['debetkredit'],$this->arrJns,'--PILIH--','style=width:100px;');
			}
			
			if($dt['debetkredit']==0){
				$margin = '';
			}else{
				$margin =  'style="margin-left:20px;"';
			}
				//	$kode $idrek
			$Kolom_BTN = "<td class='GarisDaftar' align='center'>
								<span id='option_".$dt['Id']."'>$btn</span>
							</td>";
		
			$datanya.="
				<tr class='row0'>
					<td class='GarisDaftar' align='right'>$no</td>
					<td class='GarisDaftar' align='center'>
						<span id='kodejurnalEdit_".$dt['Id']."' >
							$kode $idrek
						</span>
						
						
					</td>
					<td class='GarisDaftar'>
						<span $margin id='namajurnal_".$dt['Id']."'>
						$nama_jurnal
						</span>
					</td>
					<td class='GarisDaftar' align='right'>
						<span id='jml_saldo_".$dt['Id']."'>$jml_saldo</span>
					</td>
					<td class='GarisDaftar' align='left'>
					<span id='DebetKredit_".$dt['Id']."'>
						".$cmbDebetKredit."
					</span>
					</td>
					<td class='GarisDaftar' align='right'>
						<span id='jml_anggaran_".$dt['Id']."'>$jml_anggaran</span>
					</td>
					$Kolom_BTN
				</tr>
			";
			$no = $no+1;
			$jml_harga = $jml_harga+floatval($dt['jumlah']);
		}
				
		}//else{
		if($pilih=='2' && $IDUBAH!=''){
		$Id_jurnal=mysql_fetch_array(mysql_query("select Id from t_jurnal_keuangan where status='1'"));
		$jurnal_keuangan_idplh = $_REQUEST['jurnal_keuangan_ins_idplh'];
		
		$qry = "SELECT * FROM t_saldo_keu_det where  refid_jurnal='$IDUBAH' order by debetkredit Asc";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		while($dt = mysql_fetch_array($aqry)){
		$kode_dt = sprintf("%02s",$dt['kd']);
		$kode_de = sprintf("%02s",$dt['ke']);
		
			if($dt['status'] == '0'){
				$kode = "
					<a href='javascript:saldo_awal_keuangan_lra_lak_ins.Editinput(`".$dt['Id']."`,`".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$kode_de.".".$dt['kf']."`);' />
						".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$kode_dt.".".$kode_de."
					</a>";
					
				$idrek = '';
				$nama_jurnal=$dt['nm_account'];
				$debetkredit=$dt['debetkredit'];
				if ($debetkredit=='0'){
					$jml_saldo_ = number_format($dt['debet'],2,",",".");
				}else{
					$jml_saldo_ = number_format($dt['kredit'],2,",",".");
				}
				$jml_anggaran_=$dt['anggaran'];
				$btn ="
				<a href='javascript:saldo_awal_keuangan_lra_lak_ins.HapusJurnal_1(`".$dt['Id']."`)' />
					<img src='datepicker/remove2.png' style='width:20px;height:20px;' />
				</a>";
				$nilaiDebetKredit=$dt['debetkredit'];
				if ($nilaiDebetKredit=='0'){
					$cmbDebetKredit='Debet';
				}else{
					$cmbDebetKredit='Kredit';
				}
			}
			if($dt['status'] == '1'){
					
			$kode = "<input type='text' onkeyup='setTimeout(function myFunction() {saldo_awal_keuangan_lra_lak_ins.namajurnal();},1000);' name='Id_jurnal' id='Id_jurnal' value='".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke']."' style='width:70px;' maxlength='25' />"
				."<a href='javascript:cr_jurnal.windowShow(".$dt['Id'].");'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>";	
				
			$idrek = "<input type='hidden' name='idrek' id='idrek' value='".$dt['Id']."' />".
					"<input type='hidden' name='statidjurnal' id='statidjurnal' value='".$dt['status']."' />";
							
			$jml_saldo_ ="<input type='text' name='jml_saldo' id='jml_saldo' value='".floatval($dt['jumlah'])."' style='text-align:right' ;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatsaldo`).innerHTML = saldo_awal_keuangan_lra_lak_ins.formatCurrency(this.value);' />
							<span id='formatsaldo'></span>";
			$jml_anggaran_ ="<input type='text' name='jml_anggaran' id='jml_anggaran' value='".floatval($dt['jumlah'])."' style='text-align:right' ;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatanggaran`).innerHTML = saldo_awal_keuangan_lra_lak_ins.formatCurrency(this.value);' />
							<span id='formatanggaran'></span>";
			
				$data="<input type='text' name='namajurnal_".$dt['Id']."' id='namajurnal_".$dt['Id']."' value='".$nama."'  style='width:220px;'>";
				$btn ="
				<a href='javascript:saldo_awal_keuangan_lra_lak_ins.updKodeJurnal()' />
							<img src='datepicker/save.png' style='width:20px;height:20px;' />
						</a>"; 
			$cmbDebetKredit=cmbArray('DebetKredit',$dt['debetkredit'],$this->arrJns,'--PILIH--','style=width:100px;');
			}
			
			if($dt['status'] == '2'){
			
			$kode = "
					<a href='javascript:saldo_awal_keuangan_lra_lak_ins.Editinput(`".$dt['Id']."`,`".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke'].".".$dt['kf']."`);' />
						".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke'].".".$dt['kf']."
					</a>";
			
				$idrek = '';
				$nama_jurnal=$dt['nm_account'];
				$debetkredit=$dt['debetkredit'];
				if ($debetkredit=='0'){
					$jumlahnya = number_format($dt['debet'],2,",",".");
				}else{
					$jumlahnya = number_format($dt['kredit'],2,",",".");
				}
				
				$btn ="
				<a href='javascript:saldo_awal_keuangan_lra_lak_ins.HapusJurnal_1(`".$dt['Id']."`)' />
					<img src='datepicker/remove2.png' style='width:20px;height:20px;' />
				</a>";
				$nilaiDebetKredit=$dt['debetkredit'];
				if ($nilaiDebetKredit=='0'){
					$cmbDebetKredit='Debet';
				}else{
					$cmbDebetKredit='Kredit';
				}			
			}
			
			if($dt['status'] == '3'){
			$kode_dt = sprintf("%02s",$dt['kd']);
			$kode_de = sprintf("%02s",$dt['ke']);	
			$kode = "
					<a href='javascript:saldo_awal_keuangan_lra_lak_ins.Editinput(`".$dt['Id']."`,`".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke'].".".$dt['kf']."`);' />
						".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$kode_dt.".".$kode_de."
					</a>";
			
				$idrek = '';
				$nama_jurnal=$dt['nm_account'];
				$debetkredit=$dt['debetkredit'];
				if ($debetkredit=='0'){
					$jml_saldo_ = number_format($dt['debet'],2,",",".");
				}else{
					$jml_saldo_ = number_format($dt['kredit'],2,",",".");
				}
				$jml_anggaran_=number_format($dt['anggaran'],2,",",".");
				
				$btn ="
				<a href='javascript:saldo_awal_keuangan_lra_lak_ins.HapusJurnal_1(`".$dt['Id']."`)' />
					<img src='datepicker/remove2.png' style='width:20px;height:20px;' />
				</a>";
				$nilaiDebetKredit=$dt['debetkredit'];
				if ($nilaiDebetKredit=='0'){
					$cmbDebetKredit='Debet';
				}else{
					$cmbDebetKredit='Kredit';
				}
				
			}
			
			if($dt['debetkredit']==0){
				$margin = '';
			}else{
				$margin =  'style="margin-left:20px;"';
			}
				//	$kode $idrek
			$Kolom_BTN = "<td class='GarisDaftar' align='center'>
								<span id='option_".$dt['Id']."'>$btn</span>
							</td>";
			$datanya.="
				<tr class='row0'>
					<td class='GarisDaftar' align='right'>$no</td>
					<td class='GarisDaftar' align='center'>
						<span id='kodejurnalEdit_".$dt['Id']."' >
							$kode $idrek
						</span>
					</td>
					<td class='GarisDaftar'>
						<span $margin id='namajurnal_".$dt['Id']."'>
						
				$nama_jurnal
						</span>
					</td>
					<td class='GarisDaftar' align='right'>
						<span id='jml_saldo_".$dt['Id']."'>$jml_saldo_</span>
					</td>
					<td class='GarisDaftar' align='left'>
					<span id='DebetKredit_".$dt['Id']."'>
						".$cmbDebetKredit."
					</span>
					</td>
					<td class='GarisDaftar' align='right'>
						<span id='jml_anggaran_".$dt['Id']."'>$jml_anggaran_</span>
					</td>
					$Kolom_BTN
				</tr>
			";
			$no = $no+1;
			$jml_harga = $jml_harga+floatval($dt['jumlah']);
		}	
	}
		
		$TombolBaru = "<a href='javascript:saldo_awal_keuangan_lra_lak_ins.input_Jurnal()' /><img src='datepicker/add-256.png' style='width:20px;height:20px;' /></a>";
		
		$Kolom_BTN_TombolBaru = "<th class='th01' width='50px'>
									<span id='atasbutton'>
									$TombolBaru
									</span>
								</th>";
		
		$content['tabel'] =
			genFilterBar(
				array("
					<table class='koptable' style='min-width:1200px;' border='1'>
						<tr>
							<th class='th01' width='30px'>NO</th>
							<th class='th01' width='100px'>KODE AKUN </th>
							<th class='th01'>NAMA AKUN </th>
							<th class='th01' width='200px'>SALDO (Rp)</th>
							<th class='th01' width='100px' >DEBET / KREDIT</th>
							<th class='th01' width='200px' >ANGGARAN</th>
							$Kolom_BTN_TombolBaru
						</tr>
						$datanya
						
					</table>"
				)
			,'','','');
		
	$content['atasbutton'] = "<a href='javascript:saldo_awal_keuangan_lra_lak_ins.dat_saldo_awal(`".$dt['Id']."`)' /><img src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>";
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
  
  
   function SimpanAll(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$c1= $_REQUEST['c1'];
		$c= $_REQUEST['c'];
		$d= $_REQUEST['d'];
		$e= $_REQUEST['e'];
		$e1= $_REQUEST['e1'];
		$e1= $_REQUEST['e1'];
		$jnsJurnal= $_REQUEST['jns_jurnal'];
		$tgl_saldo_awal= $_REQUEST['saldo_awal'];
		$tgl_anggaran = $_REQUEST['anggaran'];
		
		$tgl_saldo_awal = explode("-",$tgl_saldo_awal);
		$tgl_saldo_awal2 = $tgl_saldo_awal[2].'-'.$tgl_saldo_awal[1].'-'.$tgl_saldo_awal[0];
		$tgl_anggaran = explode("-",$tgl_anggaran);
		$tgl_anggaran2 = $tgl_anggaran[2].'-'.$tgl_anggaran[1].'-'.$tgl_anggaran[0];
				
		$qri_stts2 = "SELECT * FROM t_saldo_keu_det where status='2' and refid_jurnal='$idplh' ";//$cek.=$qry;
		$aqry_stts2 = mysql_query($qri_stts2);
				
		if($err==''){
			$aqry ="UPDATE t_saldo_keu set tgl_saldo_awal='$tgl_saldo_awal2',tgl_anggaran='$tgl_anggaran2',jns_jurnal='$jnsJurnal',status='0',uid='$uid' where Id='".$idplh."'";$cek.=$aqry;
			$qry = mysql_query($aqry);
		}
		
		if($err==''){
		while($dt1 = mysql_fetch_array($aqry_stts2)){
			$query_stts2 = "UPDATE t_saldo_keu_det set status='0' ,tgl_create=NOW(),uid='$uid' where refid_jurnal='".$idplh."'";$cek .= $query_stts2;
			$qry_stts2 = mysql_query($query_stts2);
			}
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	
	function SimpanAllEdit(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$idubah = $_REQUEST['idubah'];
		$c1= $_REQUEST['c1'];
		$c= $_REQUEST['c'];
		$d= $_REQUEST['d'];
		$e= $_REQUEST['e'];
		$e1= $_REQUEST['e1'];
		$e1= $_REQUEST['e1'];
		$jnsJurnal= $_REQUEST['fmJnsJurnal'];
		$no_bukti= $_REQUEST['no_bukti'];
		$tgl_bukti= $_REQUEST['tgl_bukti'];
		$tgl_bukti_thn = $_REQUEST['tgl_bukti1'];
		$tgl_bukti_bln = $_REQUEST['tgl_bukti2'];
		$no_referensi= $_REQUEST['no_referensi'];
		$tgl_referensi= $_REQUEST['tgl_referensi'];
		$tgl_referensi_thn = $_REQUEST['tgl_referensi1'];
		$tgl_referensi_bln = $_REQUEST['tgl_referensi2'];
		$no_bku= $_REQUEST['no_bku'];
		$keterangan= $_REQUEST['keterangan'];
				
		$qri_stts2 = "SELECT * FROM t_jurnal_keuangan_det where status='2' and refid_jurnal='$idubah' ";//$cek.=$qry;
		$aqry_stts2 = mysql_query($qri_stts2);
		
		$qri_stts0 = "SELECT * FROM t_jurnal_keuangan_det where status='0' and refid_jurnal='$idubah' ";//$cek.=$qry;
		$aqry_stts0 = mysql_query($qri_stts0);
		
		$qri_stts0 = "SELECT * FROM t_jurnal_keuangan_det where status='0' and refid_jurnal='$idubah' ";//$cek.=$qry;
		$aqry_stts0 = mysql_query($qri_stts0);
		
		if($err==''){
			$qry_hps_stts1=mysql_query("DELETE from t_saldo_keu_det where refid_jurnal='$idubah' and status='1'"); $cek.=$qry_hps_stts1; 
		}
				
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function batalSaldo(){
	global $Main;
		
	$cek = ''; $err=''; $content=''; $json=TRUE;
	//get data ----------------
	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
	
	// hapus 
	$Id_saldo=mysql_fetch_array(mysql_query("select * from t_saldo_keu where Id='$idplh'"));
	$btl_det2=mysql_query("DELETE from t_saldo_keu_det where refid_jurnal=$Id_saldo[Id] and status='1'"); $cek.=$btl_det2; 
	$cek.="select * from t_saldo_keu_det where refid_jurnal=$Id_saldo[Id] and status='1'";
	$btl_det=mysql_query("DELETE from t_saldo_keu_det where refid_jurnal=$Id_saldo[Id] and status='2'"); $cek.=$btl_det; 
	$cek.="select * from t_saldo_keu_det where refid_jurnal=$Id_saldo[Id] and status='2'";

	$btl_sementara=mysql_query("DELETE from t_saldo_keu where Id='$idplh' and status='1'"); $cek.=$btl; 
	
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function batalJurnalDet(){
	global $Main;
	$cek = ''; $err=''; $content=''; $json=TRUE;
	$IDUBAH = $_REQUEST['idubah'];
	
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function batalJurnalDetSimpan(){
	global $Main;
	$cek = ''; $err=''; $content=''; $json=TRUE;
	$IDUBAH = $_REQUEST['idubah'];
	
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function setPage_OtherScript(){
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
			
						});
					</script>";
		return 	
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".		
			"<script type='text/javascript' src='js/saldo_awal_keuangan/cr_jurnal.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/saldo_awal_keuangan/saldo_awal_keuangan_lra_lak_ins.js' language='JavaScript' ></script>".
			'
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>
			'.
			$scriptload;
	}
	
	//form ==================================
	 function setFormBaruJnsJurnal(){
		$dt=array();
		$this->form_fmST = 0;
		$fm = $this->BaruJnsJurnal($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	
	function setFormEditJnsJurnal(){
		$dt=array();
		$this->form_fmST = 1;
		$fm = $this->BaruJnsJurnal($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);	
	}
			
	function setPage_HeaderOther(){
	return "";
		
	}
		
	//daftar =================================
	
	
	function pageShow(){
		global $app, $Main, $DataOption, $HTTP_COOKIE_VARS; 
		
		$navatas_ = $this->setNavAtas();
		$navatas = $navatas_==''? // '0': '20';
			'':
			"<tr><td height='20'>".
					$navatas_.
			"</td></tr>";
		$form1 = $this->withform? "<form name='$this->FormName' id='$this->FormName' method='post' action=''>" : '';
		$form2 = $this->withform? "</form >": '';
		
		$cbid = $_REQUEST['saldo_awal_keuangan_lra_lak_cb'];
		if(addslashes($_REQUEST['YN']) == '2')$cbid[0]='';
		
			/*$c1 = $_COOKIE['cofmURUSAN'];
			$c = $_COOKIE['cofmSKPD'];
			$d = $_COOKIE['cofmUNIT'];
			$e = $_COOKIE['cofmSUBUNIT'];
			$e1 = $_COOKIE['cofmSEKSI'];*/
			$c1input = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmURUSAN'];
			$cinput = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmSKPD'];
			$dinput = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmUNIT'];
			$einput = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmSUBUNIT'];
			$e1input = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmSEKSI'];
		
		return
		
				
		"<html>".
			$this->genHTMLHead().
			"<body >".
							
			"<table id='KerangkaHal' class='menubar' cellspacing='0' cellpadding='0' border='0' width='100%' height='100%' >".
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
					"<input type='hidden' name='saldo_awal_keuangan_lra_lakSKPDfmURUSAN' value='".$c1input."' />".
					"<input type='hidden' name='saldo_awal_keuangan_lra_lakSKPDfmSKPD' value='".$cinput."' />".
					"<input type='hidden' name='saldo_awal_keuangan_lra_lakSKPDfmUNIT' value='".$dinput."' />".
					"<input type='hidden' name='saldo_awal_keuangan_lra_lakSKPDfmSUBUNIT' value='".$einput."' />".
					"<input type='hidden' name='saldo_awal_keuangan_lra_lakSKPDfmSEKSI' value='".$e1input."' />".
					"<input type='hidden' name='databaru' id='databaru' value='".$_REQUEST['YN']."' />".
					"<input type='hidden' name='idubah' id='idubah' value='".$_REQUEST['idubah']."' />".
					"<input type='hidden' name='pil_jns_trans' id='pil_jns_trans' value='".$_REQUEST['halmannya']."' />".
						$this->setPage_Content().
						
					$form2.//"</form>".
					"</div></div>".
				"</td></tr>".
				"<tr><td height='29' >".	
					$Main->CopyRight.							
				"</td></tr>".
				$OtherFooterPage.
			"</table>".
			"</body>
		</html>"; 
	}	
	
	function genDaftarOpsi($Mode=1){
	global $Main, $HTTP_COOKIE_VARS;
	$coThnAnggaran = $_COOKIE['coThnAnggaran'];
	$UID = $_COOKIE['coID'];
	$bln = date("m");	 
	$idubah= $_REQUEST['idubah'];	
	 //data order ------------------------------
	$pilih=$_REQUEST['databaru'];
	
	if($pilih=='2' && $idubah==''){
	//	if(addslashes($_REQUEST['databaru'] == '1')){
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$simpan_sementara=mysql_fetch_array(mysql_query("select * from t_jurnal_keuangan where Id='$idplh' and status='2'"));
		$cek.="select * from t_jurnal_keuangan where Id='$idplh' and status='2'";
		
		$c1 = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmURUSAN'];
		$c = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmSKPD'];
		$d = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmUNIT'];
		$e = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmSUBUNIT'];
		$e1 = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmSEKSI'];
					
		$uid = $HTTP_COOKIE_VARS['coID'];
			
		$tmpl = "SELECT * FROM t_saldo_keu WHERE c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' AND uid = '$uid' AND status='1' ORDER BY Id DESC ";
		$qrytmpl = mysql_query($tmpl);
		$dataqrytmpl = mysql_fetch_array($qrytmpl);
		
	$idplhnya = $dataqrytmpl['Id'];
	$c1 = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmURUSAN'];
	$c = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmSKPD'];
	$d = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmUNIT'];
	$e = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmSUBUNIT'];
	$e1 = $_REQUEST['saldo_awal_keuangan_lra_lakSKPDfmSEKSI'];
	$aa = $_REQUEST['idjur'];
	$idplh = $_REQUEST['idaaap'];
	
	$dd1="select * from t_jurnal_keuangan where Id='$aa'"; $cek.= $dd1;
	$jns = $_REQUEST['fmJnsJurnal'];
	$jenis=mysql_fetch_array(mysql_query("select * from ref_jns_jurnal where nm_jns_jurnal='$jns'"));
	$cek.="select * from ref_jns_jurnal where nm_jns_jurnal='$jns'";
			
	$qry_c1=mysql_fetch_array(mysql_query("SELECT c1, nm_skpd FROM ref_skpd WHERE c1='$c1' and c = '00' and d='00' and e='00' and e1='000'")) ;
	$qry_c=mysql_fetch_array(mysql_query("SELECT c, nm_skpd FROM ref_skpd WHERE c1='$c1' and c='$c' and d= '00' and e='00' and e1='000'")) ; $cek.="SELECT c, nm_skpd FROM ref_skpd WHERE c1='$c1' and c='$c' and d= '00' and e='00' and e1='000'";
	$qry_d=mysql_fetch_array(mysql_query("SELECT d, nm_skpd FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e='00' and e1='000'")) ;
	$qry_e=mysql_fetch_array(mysql_query("SELECT e, nm_skpd FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e='$e' and e1='000'")) ;
	$qry_e1=mysql_fetch_array(mysql_query("SELECT e1, nm_skpd FROM ref_skpd WHERE c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'")) ;
			
	$dat_c1=$qry_c1['c1'].".  ".$qry_c1['nm_skpd'];
	$dat_c=$qry_c['c'].". ".$qry_c['nm_skpd'];
	$dat_d=$qry_d['d'].". ".$qry_d['nm_skpd'];
	$dat_e=$qry_e['e'].". ".$qry_e['nm_skpd'];
	$dat_e1=$qry_e1['e1'].". ".$qry_e1['nm_skpd'];
	
	$queryJnsJurnal="SELECT Id,nm_jns_jurnal FROM ref_jns_jurnal where st_pilih='1' ORDER BY Id asc "; $cek.=$queryJnsJurnal;
	
	$jenis_jurnal=mysql_fetch_array(mysql_query("select * from ref_jns_jurnal where st_pilih='0' and Id='1'"));
	$set_saldo=mysql_fetch_array(mysql_query("select * from setting_saldo_awal_keu where status='1'"));
	$set_saldo = explode("-",$set_saldo['tgl_saldo_awal']);
	$set_saldo_awal = $set_saldo[2]."-".$set_saldo[1]."-".$set_saldo[0];
	
	$set_anggaran=mysql_fetch_array(mysql_query("select * from setting_saldo_awal_keu where status='1'"));
	$set_anggaran = explode("-",$set_anggaran['tgl_anggaran']);
	$set_anggaran_akhir = $set_anggaran[2]."-".$set_anggaran[1]."-".$set_anggaran[0];
	
	
	$TampilOpt = 
	"<tr><td>".
		$vOrder=
		genFilterBar(
			array(
			"<table>			
			<tr>
			<td style='width:130px'>URUSAN</td><td style='width:10px'>:</td>
			<td>
			<input type='text' id='c1x' name='c1x' value='".$dat_c1."' size=50px readonly>
			<input type='hidden' id='c1' name='c1' value='".$qry_c1['c1']."' size=50px>
			</td>
			</tr><tr>
			<td>BIDANG</td><td>:</td>
			<td><input type='text' id='cx' name='cx' value='".$dat_c."' size=50px readonly></td>
			<input type='hidden' id='c' name='c' value='".$qry_c['c']."' size=50px>
			</tr><tr>
			<td>SKPD</td><td>:</td>
			<td><input type='text' id='dx' name='dx' value='".$dat_d."' size=50px readonly></td>
			<input type='hidden' id='d' name='d' value='".$qry_d['d']."' size=50px >
			</tr><tr>
			<td>UNIT</td><td>:</td>
			<td><input type='text' id='ex' name='ex' value='".$dat_e."' size=50px readonly></td>
			<input type='hidden' id='e' name='e' value='".$qry_e['e']."' size=50px>
			</tr><tr>
			<td>SUB UNIT</td><td>:</td>
			<td><input type='text' id='e1x' name='e1x' value='".$dat_e1."' size=50px readonly></td>
			<input type='hidden' id='e1' name='e1' value='".$qry_e1['e1']."' size=50px>
			<input type='hidden' name='".$this->Prefix."_idplh' id='".$this->Prefix."_idplh' value='$idplhnya' />
			</tr>
			</table>
			"),'','','').
			
		genFilterBar(
			array("<table>			
					<tr><td style='width:130px'>
					SALDO AWAL </td><td style='width:10px'>:
					<input type='text' name='saldo_awal' id='saldo_awal' value='".$set_saldo_awal."'size=10px readonly>
					</td>
					</td></tr>
					<tr><td>
					TAHUN ANGGARAN </td><td>:
					<input type='text' name='anggaran' id='anggaran' value='".$set_anggaran_akhir."'size=10px readonly>
					</td>
					</td></tr>
					<tr><td>
					JENIS JURNAL </td><td>:
					<input type='text' name='nm_jurnal' id='nm_jurnal' value='".$jenis_jurnal['nm_jns_jurnal']."' size=10px readonly>
					<input type='hidden' name='jns_jurnal' id='jns_jurnal' value='".$jenis_jurnal['Id']."' size=10px readonly>
					</td>
					</td></tr>
						
					</table>
			"),'','').
			"
				
				<div id='tbl_jurnal_detail' style='width:100%;'></div>
				<div id='tbl_jurnal' style='width:100%;'></div>";
				
		genFilterBar(
			array("<table>			
					<tr>
					<td>".genPanelIcon("javascript:".$this->Prefix.".SimpanJurnal()","save_f2.png","Simpan", 'Simpan')."</td>
					<td>".genPanelIcon("javascript:".$this->Prefix.".BatalJurnal()","clear-icon-8.png","Batal", 'Batal')."</td>
					</tr>
					</table>
			"),'','').
			"
				<input type='hidden' name='jns_dari_rek' id='jns_dari_rek' value='1' />
				<div id='tbl_jurnal_detail' style='width:100%;'></div>";
		}
	if($pilih=='2' && $idubah!=''){
			
	$TampilOpt = 
	"<tr><td>".
			$vOrder=
			genFilterBar(
				array(
				"<table>
				<tr>
				<td>
				<div id='Edit_jurnal' style='width:100%;'></div>
				</td>
				</tr>
				"),'','','');		
	//	}
	}
		return array('TampilOpt'=>$TampilOpt);
	}				
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		$this->pagePerHal=$fmLimit;
		
		$fmPILCARI = $_REQUEST['fmPILCARI'];
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		
		switch($fmPILCARI){			
						
		}
		
		//Cari 
		
		if(!empty($namaAkun)) $arrKondisi[]= " nama_akun like '%$namaAkun%'";	
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		if(empty($fmORDER1)){ 
		
		}
		
		switch($fmORDER1){
		}	
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
		
}
$saldo_awal_keuangan_lra_lak_ins = new saldo_awal_keuangan_lra_lak_insObj();
?>