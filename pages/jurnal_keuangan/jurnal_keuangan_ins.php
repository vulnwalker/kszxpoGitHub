<?php
 
 include "pages/pencarian/DataPengaturan.php";
 $DataOption = $DataPengaturan->DataOption();

class jurnal_keuangan_insObj  extends DaftarObj2{	
	var $Prefix = 'jurnal_keuangan_ins';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_jurnal_keuangan'; //bonus
	var $TblName_Hapus = 't_jurnal_keuangan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Data Jurnal Keuangan';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'JURNAL';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'jurnal_keuangan_insForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	var $arrJns = array( 
		array('0','Debet'),
		array('1','Kredit')
		
		);
	
	function setTitle(){
		return 'JURNAL KEUANGAN';
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
		//return createHeaderPage($this->PageIcon, $this->PageTitle);
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
			/*$kd = substr($koderek, 7,1);
			$ke = substr($koderek, 10,1);*/
			
			$kodeJurnal=$ka.'.'.$kb.'.'.$kc.'.'.$kd.'.'.$ke;
			
			$qry = "SELECT nm_account FROM ref_jurnal WHERE concat(ka,'.',kb,'.',kc,'.',kd,'.',ke) = '$kodeJurnal' AND ka!='0' AND kb!='0' AND kc!='0' AND kd!='0' AND ke!='0'"; $cek.=$qry;
			$aqry = mysql_query($qry);
			$daqry = mysql_fetch_array($aqry);
			/*$kde_dt = sprintf("%02s",$kd);
			$kde_de = sprintf("%02s",$ke);*/
			
			/*if($daqry['nm_account']=='' && $ka==$ka && $kb==$kb && $kc==$kc && $kd=='' && $ke==''){
				$err="Kode Akun '$ka.$kb.$kc.$kd.$de' tidak ada";	
			}elseif($daqry['nm_account']=='' && $ka==$ka && $kb==$kb && $kc==$kc && $kd==$kd && $ke==''){
				$err="Kode Akun '$ka.$kb.$kc.$kde_dt.$de' tidak ada";	
			}elseif($daqry['nm_account']=='' && $ka==$ka && $kb==$kb && $kc==$kc && $kd==$kd && $ke==$ke){
				$err="Kode Akun '$ka.$kb.$kc.$kde_dt.$kde_de' tidak ada";	
			} */ 
			
			$content['namajurnal'] = $daqry['nm_account'];
			$content['idrek'] = $idrek;
			
		break;
	    }
		case 'Editinput':{
			$cek = '';
			$err = '';
			$content = '';
			$uid = $HTTP_COOKIE_VARS['coID'];
			$idrek = $_REQUEST['idrekeningnya'];
			
			$qry = "SELECT * FROM t_jurnal_keuangan_det WHERE Id='$idrek'";$cek.=$qry;
			$aqry = mysql_query($qry);
			$dt = mysql_fetch_array($aqry);
			/*$kode_dt = sprintf("%02s",$dt['kd']);
			$kode_de = sprintf("%02s",$dt['ke']);*/
			
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
			
			$content['koderek'] = "
				<input type='text' onkeyup='setTimeout(function myFunction() {jurnal_keuangan_ins.namajurnal();},1000);'name='Id_jurnal' id='Id_jurnal' value='".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke']."' style='width:70px;' maxlength='25' />"
				."<input type='hidden' name='idrek' id='idrek' value='".$idrek."' />
				
				<a href='javascript:cari_jurnal.windowShow(".$dt['Id'].");'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>
				";	
				
				
			$content['jumlahnya'] = "<input type='text' name='jumlahharga' id='jumlahharga' value='".floatval($jml_saldo_)."' style='text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = jurnal_keuangan_ins.formatCurrency(this.value);' />
							<span id='formatjumlah'></span>";
			/*$content['jumlahnya'] = "<input type='text' name='jumlahharga' id='jumlahharga' value='".floatval($dt['jumlah'])."' style='text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = jurnal_keuangan_ins.formatCurrency(this.value);' />
							<span id='formatjumlah'></span>";*/
			$content['idrek'] = $idrek;
			$content['option'] = "
				<a href='javascript:jurnal_keuangan_ins.updKodeJurnal()' />
					<img src='datepicker/save.png' style='width:20px;height:20px;' />
				</a>";
			
			$nilaiDebetKredit=$dt['debetkredit'];
				if ($nilaiDebetKredit=='0'){
					$cmbDebetKredit='Debet';
				}else{
					$cmbDebetKredit='Kredit';
				}
					
			$content['DebetKredit'] = cmbArray('DebetKredit',$dt['debetkredit'],$this->arrJns,'--PILIH--','style=width:100px;');	
				
			/*$content['DebetKredit'] = 
				cmbArray('DebetKredit','',$this->arrJns,'--PILIH--','style=width:100px;');	*/
			
			$content['atasbutton'] = "<a href='javascript:jurnal_keuangan_ins.bukarekening()' /><img src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>";
		break;
	    }
		
		case 'HapusJurnal':{
			$cek = '';
			$err = '';
			$content = '';
			$uid = $HTTP_COOKIE_VARS['coID'];
			$idrekei = $_REQUEST['idrekei'];
			$idplh = $_REQUEST[$this->Prefix.'_idplh'];
			
			$hapus="delete from t_jurnal_keuangan_det where Id='$idrekei'";
			$aqrhapus = mysql_query($hapus);
					
		break;
	    }
		
		case 'bukaRekening':{
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$IDUBAH = $_REQUEST['idubah'];
		$qrydel1 = "DELETE FROM t_jurnal_keuangan_det WHERE status='1' and refid_jurnal='$idplh' ";
		$aqrydel1 = mysql_query($qrydel1);
		
		$qrydel2 = "DELETE FROM t_jurnal_keuangan_det WHERE status='1' and refid_jurnal='$IDUBAH' ";
		$aqrydel2 = mysql_query($qrydel2);
		
			$get= $this->TampilRekening();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];								
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
		
		case 'inputRekening':{
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$IDUBAH = $_REQUEST['idubah'];
		if ($idplh!=0){
			$qry_jurnal_det="INSERT INTO t_jurnal_keuangan_det (refid_jurnal,status) values ('$idplh','1')";$cek.=$qry_jurnal_det;
			$qry_jurnal_keuangan_det = mysql_query($qry_jurnal_det);
			
		}else{
			$qry_jurnal_det="INSERT INTO t_jurnal_keuangan_det (refid_jurnal,status) values ('$IDUBAH','1')";$cek.=$qry_jurnal_det;
		$qry_jurnal_keuangan_det = mysql_query($qry_jurnal_det);
		}
			$get= $this->TampilRekening();
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
			
			$c1 = $_REQUEST['jurnal_keuanganSKPDfmURUSAN'];
			$c = $_REQUEST['jurnal_keuanganSKPDfmSKPD'];
			$d = $_REQUEST['jurnal_keuanganSKPDfmUNIT'];
			$e = $_REQUEST['jurnal_keuanganSKPDfmSUBUNIT'];
			$e1 = $_REQUEST['jurnal_keuanganSKPDfmSEKSI'];
			$DebetKredit = $_REQUEST['DebetKredit'];
			$uid = $HTTP_COOKIE_VARS['coID'];
			$pemasukan_ins_idplh = $_REQUEST['pemasukan_ins_idplh'];
			$idrek = $_REQUEST['idrek'];
			$Id_jurnal = $_REQUEST['Id_jurnal'];
			$jumlahharga = $_REQUEST['jumlahharga'];
			$idplh = $_REQUEST[$this->Prefix.'_idplh'];
			
			
			$jnsJurnal= $_REQUEST['fmJnsJurnal'];
			$no_bukti= $_REQUEST['no_bukti'];
			$tgl_bukti= $_REQUEST['tgl_bukti'];
			$tgl_bukti_thn = $_REQUEST['tgl_bukti1'];
			$no_referensi= $_REQUEST['no_referensi'];
			$tgl_referensi= $_REQUEST['tgl_referensi'];
			$tgl_referensi_thn = $_REQUEST['tgl_referensi1'];
			$no_bku= $_REQUEST['no_bku'];
			$keterangan= $_REQUEST['keterangan'];
			$tgl_bukti = explode("-",$tgl_bukti);
			$tgl_bukti2 = $tgl_bukti_thn.'-'.$tgl_bukti[1].'-'.$tgl_bukti[0];
			
		//	$IDUBAH = $_REQUEST['idubah'];
			$kode = explode(".",$Id_jurnal);
				$ka = $kode[0];
				$kb = $kode[1];
				$kc = $kode[2];
				$kd = $kode[3];
				$ke = $kode[4];
				$kf = $kode[5];
			if($err=='' && $ka=='' && $kb=='' && $kc=='' &&  $kd=='' && $ke=='' )$err='Kode Akun Belum Terisi !!';
			if($err=='' && $jumlahharga < 1 )$err='Jumlah Harga Belum Di Isi !';
			
			if( $err=='' && $DebetKredit =='' ) $err= 'Jenis Debet / Kredit Belum di Pilih !!';
			if($DebetKredit =='0'){
				$debet=$jumlahharga;
				$kredit=0;
			}else{
				$debet=0;
				$kredit=$jumlahharga;
			}
			
			$nm_jurnal=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and kf='$kf'"));
			$kd_jurnal=mysql_fetch_array(mysql_query("select count(*) as cnt from ref_jurnal where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and kf='$kf'"));
			$cek.="select count(*) as cnt from ref_jurnal where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and kf='$kf'";
			if($kd_jurnal['cnt']=='0')$err="Kode Akun '$ka.$kb.$kc.$kd.$ke' Tidak Ada !!" ;
			$jns_status=mysql_fetch_array(mysql_query("select * from t_jurnal_keuangan_det where refid_jurnal='$idplh' and status='1'"));
			
			if($err==''){
			//	$kode = explode(".",$Id_jurnal);
				/*$ka = $kode[0];
				$kb = $kode[1];
				$kc = $kode[2];
				$kd = $kode[3];
				$ke = $kode[4];
				$kf = $kode[5];*/
			/*$nm_jurnal=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='$ka' and kb='$kb' and kc='$kc' and kd='$kd' and ke='$ke' and kf='$kf'"));
			
			$jns_status=mysql_fetch_array(mysql_query("select * from t_jurnal_keuangan_det where refid_jurnal='$idplh' and status='1'"));*/
				if(addslashes($_REQUEST['databaru'] == '1')){
					$qryupd="UPDATE t_jurnal_keuangan_det SET c1='$c1',c='$c',d='$d',e='$e',e1='$e1',ka='$ka',kb='$kb',kc='$kc',kd='$kd',ke='$ke',kf='$kf',debet='$debet',kredit='$kredit',status='2',nm_account='".$nm_jurnal['nm_account']."', debetkredit='$DebetKredit' WHERE  Id='$idrek'";
				$cek.=" | ".$qryupd;
				$aqryupd = mysql_query($qryupd);
				}else{
					$qryupd="UPDATE t_jurnal_keuangan_det SET c1='$c1x',c='$cx',d='$dx',e='$ex',e1='$e1x',ka='$ka',kb='$kb',kc='$kc',kd='$kd',ke='$ke',kf='$kf',debet='$debet',kredit='$kredit',status='2',nm_account='".$nm_jurnal['nm_account']."', debetkredit='$DebetKredit',tgl_bukti='$tgl_bukti2' ,jns_jurnal='$jnsJurnal',tgl_create=NOW(),uid='$uid',no_bku='$no_bku' WHERE  Id='$idrek'";
				$cek.=" | ".$qryupd;
				$aqryupd = mysql_query($qryupd);
				}
			}		
		break;
	    }
		
		/*case 'jadiinput':{
			$cek = '';
			$err = '';
			$content = '';
			$uid = $HTTP_COOKIE_VARS['coID'];
			$idrek = $_REQUEST['idrekeningnya'];
			
			$qry = "SELECT * FROM t_penerimaan_rekening WHERE Id='$idrek'";$cek.=$qry;
			$aqry = mysql_query($qry);
			$dt = mysql_fetch_array($aqry);
			
			$content['koderek'] = "
				<input type='text' onkeyup='setTimeout(function myFunction() {pemasukan_ins.namarekening();},100);' name='koderek' id='koderek' value='".$dt['k'].".".$dt['l'].".".$dt['m'].".".$dt['n'].".".$dt['o']."' style='width:80px;' maxlength='11' />
				"."<input type='hidden' name='idrek' id='idrek' value='".$idrek."' />".
				"<input type='hidden' name='statidrek' id='statidrek' value='".$dt['status']."' />
				<a href='javascript:cariRekening.windowShow(".$dt['Id'].");'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>
				";
			
			$content['jumlahnya'] = "<input type='text' name='jumlahharga' id='jumlahharga' value='".floatval($dt['jumlah'])."' style='text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = pemasukan_ins.formatCurrency(this.value);' />
							<span id='formatjumlah'></span>";
			$content['idrek'] = $idrek;
			$content['option'] = "
				<a href='javascript:pemasukan_ins.updKodeRek()' />
					<img src='datepicker/save.png' style='width:20px;height:20px;' />
				</a>";
			$content['atasbutton'] = "<a href='javascript:jurnal_keuangan_ins.TampilRekening()' /><img src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>";
			
				
		break;
	    }*/
		
		case 'tabelRekening':{
			$pemasukan_ins_idplh = $_REQUEST['pemasukan_ins_idplh'];
			
			$get= $this->TampilRekening();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'pilihJns':{				
				$fm = $this->pilihJns();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}
			
			case 'EditJnsJurnal':{				
				$fm = $this->setFormEditJnsJurnal();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}	
		
		case 'BaruJnsJurnal':{				
				$fm = $this->setFormBaruJnsJurnal();				
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];												
			break;
			}
		
		case 'simpanJnsJurnal':{
				$get= $this->simpanJnsJurnal();
				$cek = $get['cek'];
				$err = $get['err'];
				$content = $get['content'];
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
		
		case 'refreshJnsJurnal':{
				$get= $this->refreshJnsJurnal();
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
		
		case 'batalJurnalDet':{
			$get= $this->batalJurnalDet();
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
				
		$edit_jurnal=mysql_fetch_array(mysql_query("select * from t_jurnal_keuangan where Id='$IDUBAH'"));	
		$c1=$edit_jurnal['c1'];
		$c=$edit_jurnal['c'];
		$d=$edit_jurnal['d'];
		$e=$edit_jurnal['e'];
		$e1=$edit_jurnal['e1'];
		//
		$jnsJurnal= $_REQUEST['fmJnsJurnal'];
		$no_bukti= $_REQUEST['no_bukti'];
		$tgl_bukti= $_REQUEST['tgl_bukti'];
		$tgl_bukti_thn = $_REQUEST['tgl_bukti1'];
		$tgl_bukti_bln = $_REQUEST['tgl_bukti2'];
		$tgl_referensi_bln = $_REQUEST['tgl_referensi2'];
		$no_referensi= $_REQUEST['no_referensi'];
		$tgl_referensi= $_REQUEST['tgl_referensi'];
		$tgl_referensi_thn = $_REQUEST['tgl_referensi1'];
		$no_bku= $_REQUEST['no_bku'];
		$keterangan= $_REQUEST['keterangan'];
		
		$tgl_bukti = explode("-",$tgl_bukti);
	//	$tgl_bukti2 = $tgl_bukti_bln.'-'.$tgl_bukti_thn.'-'.$tgl_bukti[0];
		$tgl_bukti2 = $tgl_bukti_thn.'-'.$tgl_bukti[1].'-'.$tgl_bukti[0];
	
	$idplhnya = $dataqrytmpl['Id'];
	
	$dd1="select * from t_jurnal_keuangan where Id='$aa'"; $cek.= $dd1;
	$jns = $_REQUEST['fmJnsJurnal'];
	$jenis=mysql_fetch_array(mysql_query("select * from ref_jns_jurnal where nm_jns_jurnal='$jns'"));
	$cek.="select * from ref_jns_jurnal where nm_jns_jurnal='$jns'";
	
	$nilaidebet=mysql_fetch_array(mysql_query("select sum(debet) as debet from t_jurnal_keuangan_det where refid_jurnal='$IDUBAH' order by debetkredit DESC"));
	
		$debet=$nilaidebet['debet'];
		$debet1=$nilaidebet['debet'];
		$debet=number_format($debet,2, ',', '.');
		$nilaikredit=mysql_fetch_array(mysql_query("select sum(kredit) as kredit from t_jurnal_keuangan_det where refid_jurnal='$IDUBAH' order by debetkredit DESC "));
		$kredit=$nilaikredit['kredit'];
		$kredit1=$nilaikredit['kredit'];
		$kredit=number_format($kredit,2, ',', '.');
		$total=$debet1-$kredit1;
		$total=number_format($total,2, ',', '.');
	$cek.="select * t_jurnal_keuangan_det where debet='$total'";
	if($total!=0){
		$ck_saldo=mysql_fetch_array(mysql_query("select * from t_jurnal_det where refid_jurnal='$IDUBAH'"));
		
		$aqry ="UPDATE t_jurnal_keuangan_det set status='3' ,tgl_bukti='$tgl_bukti2' ,jns_jurnal='$jnsJurnal',tgl_create=NOW(),uid='$uid',no_bku='$no_bku' where refid_jurnal='".$IDUBAH."'";$cek.=$aqry;
		$qry = mysql_query($aqry);
		
		$aqry2 ="UPDATE t_jurnal_keuangan set status='3' where Id='".$IDUBAH."'";$cek.=$aqry;
		$qry2 = mysql_query($aqry2);
		
	}
	
	if($total==0){
		$jurnal_cek1=mysql_fetch_array(mysql_query("select count(*) as cnt from t_jurnal_keuangan_det where refid_jurnal='$IDUBAH'"));
		if($jurnal_cek1['cnt']!=0 && $total==0){
		
		$aqry ="UPDATE t_jurnal_keuangan_det set status='0' ,tgl_bukti='$tgl_bukti2' ,jns_jurnal='$jnsJurnal',tgl_create=NOW(),uid='$uid',no_bku='$no_bku' where refid_jurnal='".$IDUBAH."'";$cek.=$aqry;
		$qry = mysql_query($aqry);
		
		$aqry2 ="UPDATE t_jurnal_keuangan set status='0' where Id='".$IDUBAH."'";$cek.=$aqry;
		$qry2 = mysql_query($aqry2);
		
		}else{
		
			$aqry12 ="UPDATE t_jurnal_keuangan set status='3' where Id='".$IDUBAH."'";$cek.=$aqry;
			$qry12 = mysql_query($aqry12);
			$err= 'Tambah Rincian Jurnal Keuangan Belum Di Isi !! !!';		
			
		}
		
		
		
	}
	
	
	
	
	
	
	/*else{
		
		$aqry ="UPDATE t_jurnal_keuangan_det set status='0' ,tgl_bukti='$tgl_bukti2' ,jns_jurnal='$jnsJurnal',tgl_create=NOW(),uid='$uid',no_bku='$no_bku' where refid_jurnal='".$IDUBAH."'";$cek.=$aqry;
		$qry = mysql_query($aqry);
		
		$aqry2 ="UPDATE t_jurnal_keuangan set status='0' where Id='".$IDUBAH."'";$cek.=$aqry;
		$qry2 = mysql_query($aqry2);
		
	}*/
		
		$jurnal_cek=mysql_fetch_array(mysql_query("select count(*) as cnt from t_jurnal_keuangan_det where refid_jurnal='$IDUBAH'"));
	
	if($jurnal_cek['cnt']!=0 && $total==0){
		$btn_Simpan=genPanelIcon("javascript:".$this->Prefix.".SimpanAllEdit()","checkin.png","Simpan", 'Simpan');
		$btn_Batal=genPanelIcon("javascript:".$this->Prefix.".BatalJurnalDet()","cancel_f2.png","Batal", 'Batal');
		
	}else{
		$btn_Simpan='';
		$btn_Batal='';
	}
		
		$content =
		genFilterBar(
				array("<table >			
						<tr>
						<span style='color:black;font-size:14px;font-weight:bold;'>RINCIAN JURNAL KEUANGAN</span>
						</tr>
						</table>
				"),'','').
				
			genFilterBar(
				array("<table>			
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH DEBET </td><td>:
						<span align='right' id='nilai_debet'>
						<input type='text' name='nilai_debet' id='nilai_debet' value='$debet' style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span></td>
						</td></tr>
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH KREDIT </td><td>:
						<span align='right' id='nilai_kredit'>
						<input type='text' name='nilai_kredit' id='nilai_kredit' value='$kredit'style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span> </td>
						</td></tr>
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp
						 </td><td>&nbsp&nbsp--------------------------------------</td>
						</td></tr>
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH SALDO  </td><td>:
						<span  align='right' id='total'>
						<input type='text' name='total' id='total' value='$total' style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span>
						</td>
						</td></tr>
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
				
		$edit_jurnal=mysql_fetch_array(mysql_query("select * from t_jurnal_keuangan where Id='$IDUBAH'"));	
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
	
	$max_no_bukti="SELECT MAX(no_bku) AS maxno FROM t_jurnal_keuangan"; $cek.=$max_no_bukti;
	$get=mysql_fetch_array(mysql_query($max_no_bukti));
	$maxNoBKU=$get['maxno'] + 1;	
		
	$queryJnsJurnal="SELECT Id,nm_jns_jurnal FROM ref_jns_jurnal where st_pilih='1' ORDER BY Id asc"; $cek.=$queryJnsJurnal;
	
	$tgl_bukti=$edit_jurnal['tgl_bukti'];
	$tgl_bukti = explode("-",$tgl_bukti);
	$tgl_bukti_thn = $tgl_bukti[0];
	$tgl_bukti = $tgl_bukti[2].'-'.$tgl_bukti[1];
	
	$tgl_referensi=$edit_jurnal['tgl_referensi'];
	$tgl_referensi = explode("-",$tgl_referensi);
	$tgl_referensi_thn = $tgl_referensi[0];
	$tgl_referensi = $tgl_referensi[2].'-'.$tgl_referensi[1];
	
	/*$tgl_bukti=$edit_jurnal['tgl_bukti'];
	$tgl_bukti = explode("-",$tgl_bukti);
	$tgl_bukti_thn = $tgl_bukti[0];
	$tgl_bukti_bln = $tgl_bukti[1];
	$tgl_bukti = $tgl_bukti[2];
	
	$tgl_referensi=$edit_jurnal['tgl_referensi'];
	$tgl_referensi = explode("-",$tgl_referensi);
	$tgl_referensi_thn = $tgl_referensi[0];
	$tgl_referensi_bln = $tgl_referensi[1];
//	$tgl_referensi = $tgl_referensi[2].'-'.$tgl_referensi[1];
	$tgl_referensi = $tgl_referensi[2];*/
	
	$nilaidebet=mysql_fetch_array(mysql_query("select sum(debet) as debet from t_jurnal_keuangan_det where refid_jurnal='$IDUBAH' order by debetkredit DESC"));
		$cek.="select sum(t_jurnal_keuangan_det.debet) as debet from t_jurnal_keuangan_det where refid_jurnal='$IDUBAH' order by debetkredit DESC";
		$debet=$nilaidebet['debet'];
		$nilaikredit=mysql_fetch_array(mysql_query("select sum(t_jurnal_keuangan_det.kredit) as kredit from t_jurnal_keuangan_det where refid_jurnal='$IDUBAH' order by debetkredit DESC "));
		$kredit=$nilaikredit['kredit'];
		$total=$debet-$kredit;
		
		$jurnal_cek=mysql_fetch_array(mysql_query("select count(*) as cnt from t_jurnal_keuangan_det where refid_jurnal='$IDUBAH'"));
	$cek.="select count(*) as cnt from t_jurnal_keuangan_det where refid_jurnal='$IDUBAH'";
//	if($jurnal_cek['cnt']!=0 && $total==0){
	if($jurnal_cek['cnt']!=0 && $total==0){
		$btn_Simpan=genPanelIcon("javascript:".$this->Prefix.".SimpanAllEdit()","checkin.png","Selesai", 'Selesai');
		$btn_Batal=genPanelIcon("javascript:".$this->Prefix.".BatalJurnalDet()","cancel_f2.png","Tutup", 'Tutup');
	}else{
		$btn_Simpan=genPanelIcon("javascript:".$this->Prefix.".BatalSimpan()","checkin.png","Selesai", 'Selesai');
		$btn_Batal=genPanelIcon("javascript:".$this->Prefix.".BatalJurnalDet()","cancel_f2.png","Tutup", 'Tutup');
	}
	
		/*$btn_Simpan=genPanelIcon("javascript:".$this->Prefix.".SimpanAllEdit()","checkin.png","Selesai", 'Selesai');
		$btn_Batal=genPanelIcon("javascript:".$this->Prefix.".BatalJurnalDet()","cancel_f2.png","Tutup", 'Tutup');*/
		
//	}else{
	//	$btn_Simpan='';
	//	$btn_Batal='';
//	}
		
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
				array(
				"<table>	
			<tr>
			<td style='width:100px'>JENIS JURNAL</td><td style='width:10px'>:</td>
			<td>
			<div id='cont_JnsJurnal'>".
			cmbQuery('fmJnsJurnal',$edit_jurnal['jns_jurnal'],$queryJnsJurnal,'style="width:330px;"','-------- Pilih Jenis Jurnal ------------').
			"</div>	
			</td>
			</tr>
			<tr>
			<td>No.BUKTI</td><td>:</td>
			<td><input type='text' id='no_bukti' name='no_bukti' value='".$edit_jurnal['no_bukti']."' size=50px ></td>
			</tr>
			<tr>
			<td>TANGGAL BUKTI</td><td>:</td>
			<td><input type='text' id='tgl_bukti' name='tgl_bukti' class='datepicker2' value='$tgl_bukti' size=2px >
			<input type='text' id='tgl_bukti' name='tgl_bukti1' value='$tgl_bukti_thn' size=2px readonly></td>
			</tr>
			<tr>
			<td>No.REFERENSI</td><td>:</td>
			<td><input type='text' id='no_referensi' name='no_referensi' value='".$edit_jurnal['no_referensi']."' size=50px ></td>
			</tr>
			<tr>
			<td>TANGGAL REFERENSI</td><td>:</td>
			<td><input type='text' id='tgl_referensi' name='tgl_referensi' class='datepicker2' value='$tgl_referensi' size=2px >
			<input type='text' id='tgl_referensi1' name='tgl_referensi1' value='$tgl_referensi_thn' size=2px readonly></td>
			</tr>
			<tr>
			<td>No.BKU</td><td>:</td>
			<td><input type='text' id='no_bku' name='no_bku' value='".$edit_jurnal['no_bku']."' size=2px readonly></td>
			</tr>
			<tr>
			<td>KETERANGAN</td><td>:</td>
			<td>
			<textarea name='keterangan' id='keterangan' style='margin: 0px; width: 330px; height: 30px;' >".$edit_jurnal['keterangan']."</textarea></td>
			</tr>
			</table>
				"),'','','').
				"<div id='tbl_jurnal_detail' style='width:100%;'></div>".
				
			genFilterBar(
				array("<table>			
						<tr>
						<td>
						<td>".genPanelIcon("javascript:".$this->Prefix.".SimpanEditJurnal()","save_f2.png","Simpan", 'Simpan')."</td>
						</td>
						</tr>
						</table>
				"),'','').
				
					"<div id='cek_data_saldo' style='width:100%;'></div>
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
		$pil_jns_tran = "<select style='width:300px;' onchange='jurnal_keuangan_ins.bukarekening()' id='jns_transaksi' name='jns_transaksi'>";
		$TombolBaru = "<a href='javascript:jurnal_keuangan_ins.inputrekening()' /><img src='datepicker/add-256.png' style='width:20px;height:20px;' /></a>";
		$nilaidebet=mysql_fetch_array(mysql_query("select sum(t_jurnal_keuangan_det.debet) as debet from t_jurnal_keuangan_det where status='2' and refid_jurnal='$idplh' order by debetkredit DESC"));
		$cek.="select sum(t_jurnal_keuangan_det.debet) as debet from t_jurnal_keuangan_det where status='2' order by debetkredit DESC";
		$debet=$nilaidebet['debet'];
		$debet1=$nilaidebet['debet'];
		$debet=number_format($debet,2, ',', '.');
		$nilaikredit=mysql_fetch_array(mysql_query("select sum(t_jurnal_keuangan_det.kredit) as kredit from t_jurnal_keuangan_det where status='2' and refid_jurnal='$idplh' order by debetkredit DESC "));
		$kredit=$nilaikredit['kredit'];
		$kredit1=$nilaikredit['kredit'];
		$kredit=number_format($kredit,2, ',', '.');
		$total=$debet1-$kredit1;
		$total=number_format($total,2, ',', '.');
		$Kolom_BTN_TombolBaru = "<th class='th01' width='50px'>
									<span id='atasbutton'>
									$TombolBaru
									</span>
								</th>";
								
	
	$jurnal_cek=mysql_fetch_array(mysql_query("select count(*) as cnt from t_jurnal_keuangan_det where refid_jurnal='$idplh'"));
	$cek.="select count(*) as cnt from t_jurnal_detail where refid_jurnal='$idplh'";
	if($jurnal_cek['cnt']!=0 && $total==0){
		$btn_Simpan=genPanelIcon("javascript:".$this->Prefix.".SimpanAll()","checkin.png","Simpan", 'Simpan');
	}else{
		$btn_Simpan='';
	}
		$content =
			genFilterBar(
				array("<table >			
						<tr>
						<span style='color:black;font-size:14px;font-weight:bold;'>RINCIAN JURNAL KEUANGAN</span>
						</tr>
						</table>
				"),'','').
			
			genFilterBar(
				array("<table>			
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH DEBET </td><td>:
						<span align='right' id='nilai_debet'>
						<input type='text' name='nilai_debet' id='nilai_debet' value='$debet' style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span></td>
						</td></tr>
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH KREDIT </td><td>:
						<span align='right' id='nilai_kredit'>
						<input type='text' name='nilai_kredit' id='nilai_kredit' value='$kredit'style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span> </td>
						</td></tr>
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp
						 </td><td>&nbsp&nbsp--------------------------------------</td>
						</td></tr>
						<tr><td>&nbsp&nbsp&nbsp&nbsp&nbsp
						JUMLAH SALDO </td><td>:
						<span  align='right' id='total'>
						<input type='text' name='total' id='total' value='$total' style='text-align:right' 'width:100px;' onkeypress='return isNumberKey(event)' readonly>
						</span>
						</td>
						</td></tr>		
						</table>
				"),'','').
				"<div id='tbl_jurnal' style='width:100%;'></div>".
				
				genFilterBar(
				array("<table>			
						<tr>
						<td>$btn_Simpan</td>
						</tr>
						</table>
				"),'','');
			
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
   function TampilRekening(){
		global $DataPengaturan, $Main;
		$cek = '';
		$err = '';
		$datanya='';
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$idjur1= $_REQUEST['idjur'];
		$IDUBAH = $_REQUEST['idubah'];
		if(addslashes($_REQUEST['databaru'] == '1')){
		//new	
			
		$Id_jurnal=mysql_fetch_array(mysql_query("select Id from t_jurnal_keuangan where status='1'"));
		$qry_jurnal_det="INSERT INTO t_jurnal_keuangan_det (refid_jurnla,status) values ('".$Id_jurnal['Id']."','1')";

		$jurnal_keuangan_idplh = $_REQUEST['jurnal_keuangan_ins_idplh'];
		
		$qry = "SELECT * FROM t_jurnal_keuangan_det where status!='0' and refid_jurnal='$idplh' order by debetkredit Asc";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		while($dt = mysql_fetch_array($aqry)){
			if($dt['status'] == '2'){
			$kode_dt = sprintf("%02s",$dt['kd']);
			$kode_de = sprintf("%02s",$dt['ke']);
			$kode = "<a href='javascript:jurnal_keuangan_ins.Editinput(`".$dt['Id']."`,`".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke'].".".$dt['kf']."`);' />
					".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$kode_dt.".".$kode_de."
					</a>
					";
					
				
				$idrek = '';
				$nama_jurnal=$dt['nm_account'];
				$debetkredit=$dt['debetkredit'];
				if ($debetkredit=='0'){
					$jumlahnya = number_format($dt['debet'],2,",",".");
				}else{
					$jumlahnya = number_format($dt['kredit'],2,",",".");
				}
				
				$btn ="
				<a href='javascript:jurnal_keuangan_ins.HapusJurnal_1(`".$dt['Id']."`)' />
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
	//	sprintf("%02s", $lastkode)		
			$kode = "<input type='text' onkeyup='setTimeout(function myFunction() {jurnal_keuangan_ins.namajurnal();},100);' name='Id_jurnal' id='Id_jurnal' value='".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke']."' style='width:70px;' maxlength='25' />"
				."<a href='javascript:cari_jurnal.windowShow(".$dt['Id'].");'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>";	
				
				$idrek = "<input type='hidden' name='idrek' id='idrek' value='".$dt['Id']."' />".
						"<input type='hidden' name='statidjurnal' id='statidjurnal' value='".$dt['status']."' />";
				$nama_jurnal='';			
				$jumlahnya ="<input type='text' name='jumlahharga' id='jumlahharga' value='".floatval($dt['jumlah'])."' style='text-align:right' ;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = jurnal_keuangan_ins.formatCurrency(this.value);' />
							<span id='formatjumlah'></span>";
			
				$data="<input type='text' name='namajurnal_".$dt['Id']."' id='namajurnal_".$dt['Id']."' value='".$nama."'  style='width:220px;'>";
				$btn ="
				<a href='javascript:jurnal_keuangan_ins.updKodeJurnal()' />
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
						<span id='jumlanya_".$dt['Id']."'>$jumlahnya</span>
					</td>
					<td class='GarisDaftar' align='left'>
					<span id='DebetKredit_".$dt['Id']."'>
						".$cmbDebetKredit."
					</span>
					</td>
					$Kolom_BTN
				</tr>
			";
			$no = $no+1;
			$jml_harga = $jml_harga+floatval($dt['jumlah']);
		}
			
		//end	
		}else{
		//new edit
		
		$Id_jurnal=mysql_fetch_array(mysql_query("select Id from t_jurnal_keuangan where status='1'"));
		
		$jurnal_keuangan_idplh = $_REQUEST['jurnal_keuangan_ins_idplh'];
		
		$qry = "SELECT * FROM t_jurnal_keuangan_det where  refid_jurnal='$IDUBAH' order by debetkredit Asc";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		while($dt = mysql_fetch_array($aqry)){
		$kode_dt = sprintf("%02s",$dt['kd']);
		$kode_de = sprintf("%02s",$dt['ke']);
		
			if($dt['status'] == '0'){
				$kode = "
					<a href='javascript:jurnal_keuangan_ins.Editinput(`".$dt['Id']."`,`".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$kode_de.".".$dt['kf']."`);' />
						".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$kode_dt.".".$kode_de."
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
				<a href='javascript:jurnal_keuangan_ins.HapusJurnal_1(`".$dt['Id']."`)' />
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
					
			$kode = "<input type='text' onkeyup='setTimeout(function myFunction() {jurnal_keuangan_ins.namajurnal();},100);' name='Id_jurnal' id='Id_jurnal' value='".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke'].".".$dt['kf']."' style='width:70px;' maxlength='25' />"
				."<a href='javascript:cari_jurnal.windowShow(".$dt['Id'].");'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>";	
				
			$idrek = "<input type='hidden' name='idrek' id='idrek' value='".$dt['Id']."' />".
					"<input type='hidden' name='statidjurnal' id='statidjurnal' value='".$dt['status']."' />";
							
			$jumlahnya ="<input type='text' name='jumlahharga' id='jumlahharga' value='".floatval($dt['jumlah'])."' style='text-align:right' ;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = jurnal_keuangan_ins.formatCurrency(this.value);' />
							<span id='formatjumlah'></span>";
			
				$data="<input type='text' name='namajurnal_".$dt['Id']."' id='namajurnal_".$dt['Id']."' value='".$nama."'  style='width:220px;'>";
				$btn ="
				<a href='javascript:jurnal_keuangan_ins.updKodeJurnal()' />
							<img src='datepicker/save.png' style='width:20px;height:20px;' />
						</a>"; 
			$cmbDebetKredit=cmbArray('DebetKredit',$dt['debetkredit'],$this->arrJns,'--PILIH--','style=width:100px;');
			}
			
			if($dt['status'] == '2'){
			
			$kode = "
					<a href='javascript:jurnal_keuangan_ins.Editinput(`".$dt['Id']."`,`".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke'].".".$dt['kf']."`);' />
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
				<a href='javascript:jurnal_keuangan_ins.HapusJurnal_1(`".$dt['Id']."`)' />
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
					<a href='javascript:jurnal_keuangan_ins.Editinput(`".$dt['Id']."`,`".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke'].".".$dt['kf']."`);' />
						".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$kode_dt.".".$kode_de."
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
				<a href='javascript:jurnal_keuangan_ins.HapusJurnal_1(`".$dt['Id']."`)' />
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
						<span id='jumlanya_".$dt['Id']."'>$jumlahnya</span>
					</td>
					<td class='GarisDaftar' align='left'>
					<span id='DebetKredit_".$dt['Id']."'>
						".$cmbDebetKredit."
					</span>
					</td>
					$Kolom_BTN
				</tr>
			";
			$no = $no+1;
			$jml_harga = $jml_harga+floatval($dt['jumlah']);
		}
		
		//end	
		}
		
		$TombolBaru = "<a href='javascript:jurnal_keuangan_ins.inputrekening()' /><img src='datepicker/add-256.png' style='width:20px;height:20px;' /></a>";
		
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
							<th class='th01' width='200px'>JUMLAH (Rp)</th>
							<th class='th01' width='100px' >DEBET / KREDIT</th>
							$Kolom_BTN_TombolBaru
						</tr>
						$datanya
						
					</table>"
				)
			,'','','');
		
	$content['atasbutton'] = "<a href='javascript:jurnal_keuangan_ins.bukarekening(`".$dt['Id']."`)' /><img src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>";
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
   /*function TampilRekening(){
		global $DataPengaturan, $Main;
		$cek = '';
		$err = '';
		$datanya='';
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$idjur1= $_REQUEST['idjur'];
		$IDUBAH = $_REQUEST['idubah'];
		if(addslashes($_REQUEST['databaru'] == '1')){
		//new	
			
		$Id_jurnal=mysql_fetch_array(mysql_query("select Id from t_jurnal_keuangan where status='1'"));
		$qry_jurnal_det="INSERT INTO t_jurnal_keuangan_det (refid_jurnla,status) values ('".$Id_jurnal['Id']."','1')";

		$jurnal_keuangan_idplh = $_REQUEST['jurnal_keuangan_ins_idplh'];
		
		$qry = "SELECT * FROM t_jurnal_keuangan_det where status!='0' and refid_jurnal='$idplh' order by debetkredit Asc";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		while($dt = mysql_fetch_array($aqry)){
			if($dt['status'] == '2'){
			$kode_dt = sprintf("%02s",$dt['kd']);
			$kode_de = sprintf("%02s",$dt['ke']);
			$kode = "<a href='javascript:pemasukan_ins.jadiinput(`".$dt['Id']."`,`".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke'].".".$dt['kf']."`);' />
					".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke'].".".$dt['kf']."
					</a>
					";
					
				$kode=$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$kode_dt.".".$kode_de;
				
				$idrek = '';
				$nama_jurnal=$dt['nm_account'];
				$debetkredit=$dt['debetkredit'];
				if ($debetkredit=='0'){
					$jumlahnya = number_format($dt['debet'],2,",",".");
				}else{
					$jumlahnya = number_format($dt['kredit'],2,",",".");
				}
				
				$btn ="
				<a href='javascript:jurnal_keuangan_ins.HapusJurnal_1(`".$dt['Id']."`)' />
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
	//	sprintf("%02s", $lastkode)		
			$kode = "<input type='text' onkeyup='setTimeout(function myFunction() {jurnal_keuangan_ins.namaJurnal();},100);' name='Id_jurnal' id='Id_jurnal' value='".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke'].".".$dt['kf']."' style='width:70px;' maxlength='25' />"
				."<a href='javascript:cari_jurnal.windowShow(".$dt['Id'].");'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>";	
				
				$idrek = "<input type='hidden' name='idrek' id='idrek' value='".$dt['Id']."' />".
						"<input type='hidden' name='statidjurnal' id='statidjurnal' value='".$dt['status']."' />";
				$nama_jurnal='';			
				$jumlahnya ="<input type='text' name='jumlahharga' id='jumlahharga' value='".floatval($dt['jumlah'])."' style='text-align:right' ;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = jurnal_keuangan_ins.formatCurrency(this.value);' />
							<span id='formatjumlah'></span>";
			
				$data="<input type='text' name='namajurnal_".$dt['Id']."' id='namajurnal_".$dt['Id']."' value='".$nama."'  style='width:220px;'>";
				$btn ="
				<a href='javascript:jurnal_keuangan_ins.updKodeJurnal()' />
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
						<span id='kodejurnal_".$dt['Id']."' >
							$kode $idrek
							
						</span>
					</td>
					<td class='GarisDaftar'>
						<span $margin id='namajurnal_".$dt['Id']."'>
						$nama_jurnal
						</span>
					</td>
					<td class='GarisDaftar' align='right'>
						<span id='jumlanya_".$dt['Id']."'>$jumlahnya</span>
					</td>
					<td class='GarisDaftar' align='left'>
					<span id='DebetKredit_".$dt['Id']."'>
						".$cmbDebetKredit."
					</span>
					</td>
					$Kolom_BTN
				</tr>
			";
			$no = $no+1;
			$jml_harga = $jml_harga+floatval($dt['jumlah']);
		}
			
		//end	
		}else{
		//new edit
		
		$Id_jurnal=mysql_fetch_array(mysql_query("select Id from t_jurnal_keuangan where status='1'"));
		
		$jurnal_keuangan_idplh = $_REQUEST['jurnal_keuangan_ins_idplh'];
		
		$qry = "SELECT * FROM t_jurnal_keuangan_det where  refid_jurnal='$IDUBAH' order by debetkredit Asc";$cek.=$qry;
		$aqry = mysql_query($qry);
		$no=1;
		while($dt = mysql_fetch_array($aqry)){
		$kode_dt = sprintf("%02s",$dt['kd']);
		$kode_de = sprintf("%02s",$dt['ke']);
		
			if($dt['status'] == '0'){
				$kode = "
					<a href='javascript:jurnal_keuangan_ins.Editinput(`".$dt['Id']."`,`".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$kode_de.".".$dt['kf']."`);' />
						".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$kode_dt.".".$kode_de."
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
				<a href='javascript:jurnal_keuangan_ins.HapusJurnal_1(`".$dt['Id']."`)' />
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
					
			$kode = "<input type='text' onkeyup='setTimeout(function myFunction() {jurnal_keuangan_ins.namaJurnal();},100);' name='Id_jurnal' id='Id_jurnal' value='".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke'].".".$dt['kf']."' style='width:70px;' maxlength='25' />"
				."<a href='javascript:cari_jurnal.windowShow(".$dt['Id'].");'> <img src='datepicker/search.png' style='width:20px;height:20px;margin-bottom:-5px;'  /></a>";	
				
			$idrek = "<input type='hidden' name='idrek' id='idrek' value='".$dt['Id']."' />".
					"<input type='hidden' name='statidjurnal' id='statidjurnal' value='".$dt['status']."' />";
							
			$jumlahnya ="<input type='text' name='jumlahharga' id='jumlahharga' value='".floatval($dt['jumlah'])."' style='text-align:right' ;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah`).innerHTML = jurnal_keuangan_ins.formatCurrency(this.value);' />
							<span id='formatjumlah'></span>";
			
				$data="<input type='text' name='namajurnal_".$dt['Id']."' id='namajurnal_".$dt['Id']."' value='".$nama."'  style='width:220px;'>";
				$btn ="
				<a href='javascript:jurnal_keuangan_ins.updKodeJurnal()' />
							<img src='datepicker/save.png' style='width:20px;height:20px;' />
						</a>"; 
			$cmbDebetKredit=cmbArray('DebetKredit',$dt['debetkredit'],$this->arrJns,'--PILIH--','style=width:100px;');
			}
			
			if($dt['status'] == '2'){
			
			$kode = "
					<a href='javascript:jurnal_keuangan_ins.Editinput(`".$dt['Id']."`,`".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke'].".".$dt['kf']."`);' />
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
				<a href='javascript:jurnal_keuangan_ins.HapusJurnal_1(`".$dt['Id']."`)' />
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
					<a href='javascript:jurnal_keuangan_ins.Editinput(`".$dt['Id']."`,`".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$dt['kd'].".".$dt['ke'].".".$dt['kf']."`);' />
						".$dt['ka'].".".$dt['kb'].".".$dt['kc'].".".$kode_dt.".".$kode_de."
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
				<a href='javascript:jurnal_keuangan_ins.HapusJurnal_1(`".$dt['Id']."`)' />
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
						<span id='jumlanya_".$dt['Id']."'>$jumlahnya</span>
					</td>
					<td class='GarisDaftar' align='left'>
					<span id='DebetKredit_".$dt['Id']."'>
						".$cmbDebetKredit."
					</span>
					</td>
					$Kolom_BTN
				</tr>
			";
			$no = $no+1;
			$jml_harga = $jml_harga+floatval($dt['jumlah']);
		}
		
		//end	
		}
		
		$TombolBaru = "<a href='javascript:jurnal_keuangan_ins.inputrekening()' /><img src='datepicker/add-256.png' style='width:20px;height:20px;' /></a>";
		
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
							<th class='th01' width='200px'>JUMLAH (Rp)</th>
							<th class='th01' width='100px' >DEBET / KREDIT</th>
							$Kolom_BTN_TombolBaru
						</tr>
						$datanya
						
					</table>"
				)
			,'','','');
		
	$content['atasbutton'] = "<a href='javascript:jurnal_keuangan_ins.bukarekening(`".$dt['Id']."`)' /><img src='datepicker/cancel.png' style='width:20px;height:20px;' /></a>";
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}*/
   
   
	function pilihJns2(){
		$cek='';$err="";$content="";
		$Id_penyedia = cekPOST2("fmJnsJurnal");
		
		if($Id_penyedia != ""){
			$content->jns=cmbQuery('fmd',$fmd,$queryd,'style="width:500px;"onchange="'.$this->Prefix.'.pilihSKPD()"','-------- Pilih Kode SKPD ----------------')."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"."<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruSKPD()' title='Baru' >";
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
   
   function BtnUbahHapus($tmblUbah, $fnc_Ubah, $tmblHapus, $fnc_Hapus ){
	
		return " <input type='button' name='$tmblUbah' id='$tmblUbah' value='UBAH' onclick='pemasukan_ins.$fnc_Ubah()' /> <input type='button' name='$tmblHapus' id='$tmblHapus' value='HAPUS' onclick='pemasukan_ins.$fnc_Hapus()' />";
	}
   
   function pilihJns(){
   $cek='';$err="";$content="";				
	$Id_penyedia = cekPOST2("fmJnsJurnal");
		
		if($Id_penyedia != ""){
		
		$r1="<input type='button' name='$tmblUbah' id='$tmblUbah' value='UBAH' onclick='jurnal_keuanga_ins.EditJnsJurnal()' /> <input type='button' name='$tmblHapus' id='$tmblHapus' value='HAPUS' onclick='pemasukan_ins.$fnc_Hapus()' />";
		//	$content=$this->BtnUbahHapus("UbahPenyedia","UbahPenyedia", "HapusPenyedia", "HapusPenyedia");
			$content=$r1;
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);									
	}
  
   
   function simpanJnsJurnal(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$Id= $_REQUEST['Id'];
		$JnsJurnal= $_REQUEST['jns_jurnal'];
	//	$barcode= $_REQUEST['barcode'];
		if( $err=='' && $JnsJurnal =='' ) $err= 'Nama Jenis Jurnal Belum Di Isi !!';
	
		if($fmST == 0){
			if($err==''){
				$aqry = "INSERT into ref_jns_jurnal (nm_jns_jurnal,st_pilih) values('$JnsJurnal','1')";	
				$cek .= $aqry;	
				$qry = mysql_query($aqry);
				$content=$JnsJurnal;	
				}
			}else{
				$aqry = "UPDATE ref_jns_jurnal set nm_jns_jurnal='$JnsJurnal' where Id='".$Id."'";$cek .= $aqry;
			$qry = mysql_query($aqry);
			$content=$JnsJurnal;
			}
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
			
		$tgl_bukti = explode("-",$tgl_bukti);
	//	$tgl_bukti2 = $tgl_bukti_bln.'-'.$tgl_bukti_thn.'-'.$tgl_bukti[0];
		$tgl_bukti2 = $tgl_bukti_thn.'-'.$tgl_bukti[1].'-'.$tgl_bukti[0];
		$tgl_referensi = explode("-",$tgl_referensi);
	//	$tgl_bukti2 = $tgl_bukti_thn.'-'.$tgl_bukti[1].'-'.$tgl_bukti[0];
		$tgl_referensi2 = $tgl_referensi_thn.'-'.$tgl_referensi[1].'-'.$tgl_referensi[0];
				
		$qri_stts2 = "SELECT * FROM t_jurnal_keuangan_det where status='2' and refid_jurnal='$idplh' ";//$cek.=$qry;
		$aqry_stts2 = mysql_query($qri_stts2);
				
		if($err==''){
			$qry_hps=mysql_query("DELETE from t_jurnal_keuangan where status='1'"); $cek.=$qry_hps; 
		}
		
		
		if($err==''){
			$qry_hps_stts1=mysql_query("DELETE from t_jurnal_keuangan_det where refid_jurnal='$idplh' and status='1'"); $cek.=$qry_hps_stts1; 
		}
		
		if($err==''){
			$aqry ="UPDATE t_jurnal_keuangan set c1='$c1',c='$c',d='$d',e='$e',e1='$e1',no_bukti='$no_bukti',tgl_bukti='$tgl_bukti2',no_referensi='$no_referensi',tgl_referensi='$tgl_referensi2',no_bku='$no_bku',jns_jurnal='$jnsJurnal',keterangan='$keterangan',status='0',uid='$uid' where Id='".$idplh."'";$cek.=$aqry;
			$qry = mysql_query($aqry);
		}
		
		if($err==''){
		while($dt1 = mysql_fetch_array($aqry_stts2)){
			$query_stts2 = "UPDATE t_jurnal_keuangan_det set status='0' ,tgl_bukti='$tgl_bukti2' ,jns_jurnal='$jnsJurnal',tgl_create=NOW(),uid='$uid',no_bku='$no_bku'  where refid_jurnal='".$idplh."'";$cek .= $query_stts2;
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
	//	$tgl_bukti_bln = $_REQUEST['tgl_bukti2'];
		$no_referensi= $_REQUEST['no_referensi'];
		$tgl_referensi= $_REQUEST['tgl_referensi'];
		$tgl_referensi_thn = $_REQUEST['tgl_referensi1'];
	//	$tgl_referensi_bln = $_REQUEST['tgl_referensi2'];
		$no_bku= $_REQUEST['no_bku'];
		$keterangan= $_REQUEST['keterangan'];
		
		
		$tgl_bukti = explode("-",$tgl_bukti);
		$tgl_bukti2 = $tgl_bukti_thn.'-'.$tgl_bukti[1].'-'.$tgl_bukti[0];
		$tgl_referensi = explode("-",$tgl_referensi);
		$tgl_referensi2 = $tgl_referensi_thn.'-'.$tgl_referensi[1].'-'.$tgl_referensi[0];
		
		
		$qri_stts2 = "SELECT * FROM t_jurnal_keuangan_det where status='2' and refid_jurnal='$idubah' ";//$cek.=$qry;
		$aqry_stts2 = mysql_query($qri_stts2);
		
		$qri_stts0 = "SELECT * FROM t_jurnal_keuangan_det where status='0' and refid_jurnal='$idubah' ";//$cek.=$qry;
		$aqry_stts0 = mysql_query($qri_stts0);
		
		$qri_stts0 = "SELECT * FROM t_jurnal_keuangan_det where status='0' and refid_jurnal='$idubah' ";//$cek.=$qry;
		$aqry_stts0 = mysql_query($qri_stts0);
		
		if($err==''){
			$qry_hps_stts1=mysql_query("DELETE from t_jurnal_keuangan_det where refid_jurnal='$idubah' and status='1'"); $cek.=$qry_hps_stts1; 
		}
		
		if($err==''){
			$aqry ="UPDATE t_jurnal_keuangan set c1='$c1',c='$c',d='$d',e='$e',e1='$e1',no_bukti='$no_bukti',tgl_bukti='$tgl_bukti2',no_referensi='$no_referensi',tgl_referensi='$tgl_referensi2',no_bku='$no_bku',jns_jurnal='$jnsJurnal',keterangan='$keterangan',status='0',uid='$uid' where Id='".$idubah."'";$cek.=$aqry;
			$qry = mysql_query($aqry);
		}
		
		if($err==''){
		while($dt1 = mysql_fetch_array($aqry_stts2)){
			$query_stts2 = "UPDATE t_jurnal_keuangan_det set status='0' ,tgl_bukti='$tgl_bukti2' ,jns_jurnal='$jnsJurnal',tgl_create=NOW(),uid='$uid',no_bku='$no_bku'  where refid_jurnal='".$idubah."'";$cek .= $query_stts2;
			$qry_stts2 = mysql_query($query_stts2);
			}
		}
		
		if($err==''){
		while($dt2 = mysql_fetch_array($aqry_stts0)){
			$query_stts0 = "UPDATE t_jurnal_keuangan_det set status='0' ,tgl_bukti='$tgl_bukti2' ,jns_jurnal='$jnsJurnal',tgl_create=NOW(),uid='$uid',no_bku='$no_bku'  where refid_jurnal='".$idubah."'";$cek .= $query_stts0;
			$qry_stts0 = mysql_query($query_stts0);
			}
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function SimpanEditJurnal(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$idubah= $_REQUEST['idubah'];
		
		$c1= $_REQUEST['c1'];
		$c= $_REQUEST['c'];
		$d= $_REQUEST['d'];
		$e= $_REQUEST['e'];
		$e1= $_REQUEST['e1'];
		$JnsJurnal= $_REQUEST['jns_jurnal'];
	
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
		
		$tgl_bukti = explode("-",$tgl_bukti);
		$tgl_bukti2 = $tgl_bukti_bln.'-'.$tgl_bukti_thn.'-'.$tgl_bukti[0];
		$tgl_referensi = explode("-",$tgl_referensi);
		$tgl_referensi2 = $tgl_referensi_bln.'-'.$tgl_referensi_thn.'-'.$tgl_referensi[0];
		
		$df="select * from t_jurnal_keuangan where no_bukti='$no_bukti'";$cek.=$df;
		
		$qri_stts2 = "SELECT * FROM t_jurnal_keuangan_det where status='2' and refid_jurnal='$idubah' ";//$cek.=$qry;
		$aqry_stts2 = mysql_query($qri_stts2);
		
		$qri_stts0 = "SELECT * FROM t_jurnal_keuangan_det where status='0' and refid_jurnal='$idubah' ";//$cek.=$qry;
		$aqry_stts0 = mysql_query($qri_stts0);
		
		if($err==''){
			$aqry ="UPDATE t_jurnal_keuangan set c1='$c1',c='$c',d='$d',e='$e',e1='$e1',no_bukti='$no_bukti',tgl_bukti='$tgl_bukti2',no_referensi='$no_referensi',tgl_referensi='$tgl_referensi2',no_bku='$no_bku',jns_jurnal='$jnsJurnal',keterangan='$keterangan',status='0',uid='$uid' where Id='".$idubah."'";$cek.=$aqry;
			$qry = mysql_query($aqry);
		}
		
		if($err==''){
		while($dt1 = mysql_fetch_array($aqry_stts2)){
			$query_stts2 = "UPDATE t_jurnal_keuangan_det set status='0' ,tgl_bukti='$tgl_bukti2' ,jns_jurnal='$jnsJurnal',tgl_create=NOW(),uid='$uid',no_bku='$no_bku'  where refid_jurnal='".$idubah."'";$cek .= $query_stts2;
			$qry_stts2 = mysql_query($query_stts2);
			}
		}
		
		if($err==''){
		while($dt2 = mysql_fetch_array($aqry_stts0)){
			$query_stts0 = "UPDATE t_jurnal_keuangan_det set status='0' ,tgl_bukti='$tgl_bukti2' ,jns_jurnal='$jnsJurnal',tgl_create=NOW(),uid='$uid',no_bku='$no_bku'  where refid_jurnal='".$idubah."'";$cek .= $query_stts0;
			$qry_stts0 = mysql_query($query_stts0);
			}
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	
	function simpanJurnal(){
	global $HTTP_COOKIE_VARS;
	global $Main;
	 
		$uid = $HTTP_COOKIE_VARS['coID'];
		$cek = ''; $err=''; $content=''; $json=TRUE;
		//get data -----------------
		$fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$Id= $_REQUEST['Id'];
		$c1= $_REQUEST['c1'];
		$c= $_REQUEST['c'];
		$d= $_REQUEST['d'];
		$e= $_REQUEST['e'];
		$e1= $_REQUEST['e1'];
		$jnsJurnal= $_REQUEST['fmJnsJurnal'];
		$no_bukti= $_REQUEST['no_bukti'];
		$tgl_bukti= $_REQUEST['tgl_bukti'];
		$tgl_bukti_thn = $_REQUEST['tgl_bukti1'];
		/*$tgl_bukti= $_REQUEST['tgl_bukti'];
		$tgl_bukti_thn = $_REQUEST['tgl_bukti1'];
		$tgl_bukti_bln = $_REQUEST['tgl_bukti2'];*/
		$no_referensi= $_REQUEST['no_referensi'];
		$tgl_referensi= $_REQUEST['tgl_referensi'];
		$tgl_referensi_thn = $_REQUEST['tgl_referensi1'];
		/*$tgl_referensi= $_REQUEST['tgl_referensi'];
		$tgl_referensi_thn = $_REQUEST['tgl_referensi1'];
		$tgl_referensi_bln = $_REQUEST['tgl_referensi2'];*/
		$no_bku= $_REQUEST['no_bku'];
		$keterangan= $_REQUEST['keterangan'];
			
		 if( $err=='' && $jnsJurnal =='' ) $err= 'Jenis Jurnal Belum di Pilih !!';
		 if( $err=='' && $tgl_bukti =='' ) $err= 'Tanggal Bukti Belum di Isi !!';
		 if( $err=='' && $no_referensi =='' ) $err= 'No Referensi Belum di Isi !!';
		 if( $err=='' && $tgl_referensi =='' ) $err= 'Tanggal Referensi  Belum di Isi !!';
		 if( $err=='' && $no_bku =='' ) $err= 'No BKU Belum di Isi !!';
		// if( $err=='' && $keterangan =='' ) $err= 'Keterangan Belum di Isi !!';
		
		
		$tgl_bukti = explode("-",$tgl_bukti);
		$tgl_bukti2 = $tgl_bukti_thn.'-'.$tgl_bukti[1].'-'.$tgl_bukti[0];
		$tgl_referensi = explode("-",$tgl_referensi);
		$tgl_referensi2 = $tgl_referensi_thn.'-'.$tgl_referensi[1].'-'.$tgl_referensi[0];
		
		/*$tgl_bukti = explode("-",$tgl_bukti);
		$tgl_bukti2 = $tgl_bukti_bln.'-'.$tgl_bukti_thn.'-'.$tgl_bukti[0];
		$tgl_referensi = explode("-",$tgl_referensi);
		$tgl_referensi2 = $tgl_referensi_bln.'-'.$tgl_referensi_thn.'-'.$tgl_referensi[0];*/
		
		$aqry = "UPDATE t_jurnal_keuangan set jns_jurnal='$jnsJurnal', no_bukti='$no_bukti' , tgl_bukti='$tgl_bukti2' ,no_referensi='$no_referensi' , tgl_referensi='$tgl_referensi2' ,no_bku='$no_bku',keterangan='$keterangan', status='2' where Id='".$idplh."'";$cek .= $aqry;
			$qry = mysql_query($aqry);
		//$content='1';	
	
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function refreshJnsJurnal(){
	global $Main;
	 
		$Kategori2 = $_REQUEST['fmJnsJurnal'];	 
		$Id = $_REQUEST['Id'];	 
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$Kategori_new= $_REQUEST['id_JnsJurnalBaru'];
	 	
		$queryKategori="SELECT nm_jns_jurnal,nm_jns_jurnal FROM ref_jns_jurnal where st_pilih='1'" ;$cek.=$queryKategori;
		$content->JnsJurnal=cmbQuery('fmJnsJurnal',$Kategori_new,$queryKategori,'style="width:330px;"onchange="'.$this->Prefix.'.pilihJnsJurnal()"','-------- Pilih Kategoria ------------')."
						<input type='button' value='Baru' onclick ='".$this->Prefix.".BaruKategori()' title='Baru' >
						"."&nbsp&nbsp&nbsp"."
						<input type='button' value='Edit' onclick ='".$this->Prefix.".EditJnsJurnal()' title='Edit' >
						"."&nbsp&nbsp&nbsp"."
						<input type='button' value='Hapus' onclick ='".$this->Prefix.".HapusKategori()' title='Hapus' >";
	
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
   
	function BaruJnsJurnal($dt){	
	 global $SensusTmp, $Main;
	 
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_formKA';				
	 $this->form_width = 500;
	 $this->form_height = 50;
	
	 $kat = $_REQUEST['fmJnsJurnal'];
	 
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU JENIS JURNAL';
	  }else{
	  	$this->form_caption = 'EDIT JENIS JURNAL';
		$dat_kategeori=mysql_fetch_array(mysql_query("select * from ref_jns_jurnal where nm_jns_jurnal='$kat' and st_pilih='1'"));
		$cek.="select * from ref_jns_jurnal where nm_jns_jurnal='$kat' and st_pilih='1'";
	
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		
	 //items ----------------------
	  $this->form_fields = array(
							 			
			'jns_jurnal' => array( 
						'label'=>'JENIS JURNAL',
						'labelWidth'=>100, 
						'value'=>"<div style='float:left;'>
						<input type='text' name='jns_jurnal' id='jns_jurnal' value='".$dat_kategeori['nm_jns_jurnal']."' placeholder='Nama Jenis Jurnal' style='width:350px;'>
						<input type='hidden' name='Id' id='Id' value='".$dat_kategeori['Id']."' >
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
		"<input type='button' value='Simpan' onclick ='".$this->Prefix.".SimpanJnsJurnal()' title='Simpan' >"."&nbsp&nbsp".
		"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close1()' >";
		$form = $this->genFormJnsJurnal();		
		$content = $form;
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function genFormJnsJurnal($withForm=TRUE, $params=NULL, $center=TRUE){	
		$form_name = $this->Prefix.'_KAform';	
		
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
	
	
	function batalJurnal(){
	// global $HTTP_COOKIE_VARS;
	global $Main;
	// $uid = $HTTP_COOKIE_VARS['coID'];
		
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data ----------------
	$idplh = $_REQUEST[$this->Prefix.'_idplh'];
	
	// hapus 
	$btl_det2=mysql_query("DELETE from t_jurnal_keuangan_det where refid_jurnal='$idplh' and status='1'"); $cek.=$btl_det; 
	$btl_det=mysql_query("DELETE from t_jurnal_keuangan_det where refid_jurnal='$idplh' and status='2'"); $cek.=$btl_det; 
	
	
	$btl=mysql_query("DELETE from t_jurnal_keuangan where Id='$idplh' and status='2'"); $cek.=$btl; 
	$btl_sementara=mysql_query("DELETE from t_jurnal_keuangan where Id='$idplh' and status='1'"); $cek.=$btl; 
	
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function batalJurnalDet(){
	global $Main;
	$cek = ''; $err=''; $content=''; $json=TRUE;
	$IDUBAH = $_REQUEST['idubah'];
	
	// hapus 
	/*$btl_det2=mysql_query("DELETE from t_jurnal_keuangan_det where refid_jurnal='$IDUBAH' and status='1'"); $cek.=$btl_det; 
	$btl_det=mysql_query("DELETE from t_jurnal_keuangan_det where refid_jurnal='$IDUBAH' and status='2'"); $cek.=$btl_det; 
	*/
	return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
	}
	
	function batalJurnalDetSimpan(){
	global $Main;
	$cek = ''; $err=''; $content=''; $json=TRUE;
	$IDUBAH = $_REQUEST['idubah'];
	
	// hapus 
	/*$btl_det2=mysql_query("DELETE from t_jurnal_keuangan_det where refid_jurnal='$IDUBAH' and status='1'"); $cek.=$btl_det; 
	$btl_det=mysql_query("DELETE from t_jurnal_keuangan_det where refid_jurnal='$IDUBAH' and status='2'"); $cek.=$btl_det; 
	*/
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
			"<script type='text/javascript' src='js/jurnal_keuangan/cari_jurnal.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/jurnal_keuangan/jurnal_keuangan_ins.js' language='JavaScript' ></script>".
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
		global $app, $Main, $DataOption; 
		
		$navatas_ = $this->setNavAtas();
		$navatas = $navatas_==''? // '0': '20';
			'':
			"<tr><td height='20'>".
					$navatas_.
			"</td></tr>";
		$form1 = $this->withform? "<form name='$this->FormName' id='$this->FormName' method='post' action=''>" : '';
		$form2 = $this->withform? "</form >": '';
		
		$cbid = $_REQUEST['jurnal_keuangan_cb'];
		if(addslashes($_REQUEST['YN']) == '1')$cbid[0]='';
		
			$c1input = $_REQUEST['jurnal_keuanganSKPDfmURUSAN'];
			$cinput = $_REQUEST['jurnal_keuanganSKPDfmSKPD'];
			$dinput = $_REQUEST['jurnal_keuanganSKPDfmUNIT'];
			$einput = $_REQUEST['jurnal_keuanganSKPDfmSUBUNIT'];
			$e1input = $_REQUEST['jurnal_keuanganSKPDfmSEKSI'];
		
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
					"<input type='hidden' name='jurnal_keuanganSKPDfmURUSAN' value='".$c1input."' />".
					"<input type='hidden' name='jurnal_keuanganSKPDfmSKPD' value='".$cinput."' />".
					"<input type='hidden' name='jurnal_keuanganSKPDfmUNIT' value='".$dinput."' />".
					"<input type='hidden' name='jurnal_keuanganSKPDfmSUBUNIT' value='".$einput."' />".
					"<input type='hidden' name='jurnal_keuanganSKPDfmSEKSI' value='".$e1input."' />".
					"<input type='hidden' name='databaru' id='databaru' value='".$_REQUEST['YN']."' />".
					"<input type='hidden' name='idubah' id='idubah' value='".$cbid[0]."' />".
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
		
	 //data order ------------------------------
	
	if(isset($_REQUEST['databaru'])){
		if(addslashes($_REQUEST['databaru'] == '1')){
		$idplh = $_REQUEST[$this->Prefix.'_idplh'];
		$simpan_sementara=mysql_fetch_array(mysql_query("select * from t_jurnal_keuangan where Id='$idplh' and status='2'"));
		$cek.="select * from t_jurnal_keuangan where Id='$idplh' and status='2'";
		
		$c1 = $_REQUEST['jurnal_keuanganSKPDfmURUSAN'];
		$c = $_REQUEST['jurnal_keuanganSKPDfmSKPD'];
		$d = $_REQUEST['jurnal_keuanganSKPDfmUNIT'];
		$e = $_REQUEST['jurnal_keuanganSKPDfmSUBUNIT'];
		$e1 = $_REQUEST['jurnal_keuanganSKPDfmSEKSI'];
					
		$uid = $HTTP_COOKIE_VARS['coID'];
			
		$qrybarupenerimaan = "INSERT INTO t_jurnal_keuangan(c1,c,d,e,e1,uid,status) values ('$c1', '$c', '$d', '$e', '$e1', '$uid','1')";
		$aqrybarupenerimaan = mysql_query($qrybarupenerimaan);
			
		$tmpl = "SELECT * FROM t_jurnal_keuangan WHERE c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' AND uid = '$uid' AND status='1' ORDER BY Id DESC ";
		$qrytmpl = mysql_query($tmpl);
		$dataqrytmpl = mysql_fetch_array($qrytmpl);
		
	$idplhnya = $dataqrytmpl['Id'];
	$c1 = $_REQUEST['jurnal_keuanganSKPDfmURUSAN'];
	$c = $_REQUEST['jurnal_keuanganSKPDfmSKPD'];
	$d = $_REQUEST['jurnal_keuanganSKPDfmUNIT'];
	$e = $_REQUEST['jurnal_keuanganSKPDfmSUBUNIT'];
	$e1 = $_REQUEST['jurnal_keuanganSKPDfmSEKSI'];
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
	
	$max_no_bukti="SELECT MAX(no_bku) AS maxno FROM t_jurnal_keuangan"; $cek.=$max_no_bukti;
	$get=mysql_fetch_array(mysql_query($max_no_bukti));
	$maxNoBKU=$get['maxno'] + 1;	
		
	$queryJnsJurnal="SELECT Id,nm_jns_jurnal FROM ref_jns_jurnal where st_pilih='1' ORDER BY Id asc "; $cek.=$queryJnsJurnal;
	
	$TampilOpt = 
	"<tr><td>".
			$vOrder=
			genFilterBar(
				array(
				"<table>			
				<tr>
				<td style='width:130px'>URUSAN </td><td style='width:10px'>:</td>
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
				"),'','','').
				
			genFilterBar(
				array(
				"<table>		
			<tr>
			<td style='width:100px'>JENIS JURNAL</td><td style='width:10px'>:</td>
			<td>
			".
			cmbQuery('fmJnsJurnal',$fmJnsJurnal,$queryJnsJurnal,'style="width:330px;"','-------- Pilih Jenis Jurnal ------------')."	
			</td>
			</tr>
			<tr>
			<td>No.BUKTI</td><td>:</td>
			<td><input type='text' id='no_bukti' name='no_bukti' value='' size=50px ></td>
			</tr>
			<tr>
			<td>TANGGAL BUKTI</td><td>:</td>
			<td><input type='text' id='tgl_bukti' name='tgl_bukti' class='datepicker2' value='' size=2px >
			<input type='text' id='tgl_bukti' name='tgl_bukti1' value='$coThnAnggaran' size=2px readonly></td>
			</tr>
			<tr>
			<td>No.REFERENSI</td><td>:</td>
			<td><input type='text' id='no_referensi' name='no_referensi' value='' size=50px ></td>
			</tr>
			<tr>
			<td>TANGGAL REFERENSI</td><td>:</td>
			<td><input type='text' id='tgl_referensi' name='tgl_referensi' class='datepicker2' value='' size=2px >
			<input type='text' id='tgl_referensi1' name='tgl_referensi1' value='$coThnAnggaran' size=2px readonly></td>
			</tr>
			<tr>
			<td>No.BKU</td><td>:</td>
			<td><input type='text' id='no_bku' name='no_bku' value='$maxNoBKU' size=2px style='text-align:center' readonly></td>
			</tr>
			<tr>
			<td>KETERANGAN</td><td>:</td>
			<td>
			<input type='hidden' name='".$this->Prefix."_idplh' id='".$this->Prefix."_idplh' value='$idplhnya' /><textarea name='keterangan' id='keterangan' style='margin: 0px; width: 330px; height: 50px;' placeholder='KETERANGAN'>".$qrytmpl['keterangan']."</textarea></td> 
			</tr>
			</table>
			"),'','','').
			
			"<div id='databarangnya'></div>".
			
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
		}else{
			
		$IDUBAH = $_REQUEST['idubah'];
		$edit_jurnal=mysql_fetch_array(mysql_query("select * from t_jurnal_keuangan where Id='$IDUBAH'"));	
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
	
	$max_no_bukti="SELECT MAX(no_bku) AS maxno FROM t_jurnal_keuangan"; $cek.=$max_no_bukti;
	$get=mysql_fetch_array(mysql_query($max_no_bukti));
	$maxNoBKU=$get['maxno'] + 1;	
		
	$queryJnsJurnal="SELECT Id,nm_jns_jurnal FROM ref_jns_jurnal where st_pilih='1'"; $cek.=$queryJnsJurnal;
	
	$tgl_bukti=$edit_jurnal['tgl_bukti'];
	$tgl_bukti = explode("-",$tgl_bukti);
	$tgl_bukti_thn = $tgl_bukti[0];
	$tgl_bukti = $tgl_bukti[2].'-'.$tgl_bukti[1];
	
	$tgl_referensi=$edit_jurnal['tgl_referensi'];
	$tgl_referensi = explode("-",$tgl_referensi);
	$tgl_referensi_thn = $tgl_referensi[0];
	$tgl_referensi = $tgl_referensi[2].'-'.$tgl_referensi[1];
	//$tgl_bukti2 = $tgl_bukti_thn[0].'-'.$tgl_bukti[1].'-'.$tgl_bukti[0];
	
	$nilaidebet=mysql_fetch_array(mysql_query("select sum(t_jurnal_keuangan_det.debet) as debet from t_jurnal_keuangan_det where status!='3' and refid_jurnal='$IDUBAH' order by debetkredit DESC"));
	//$cek.="select sum(t_jurnal_keuangan_det.debet) as debet from t_jurnal_keuangan_det where status!='3' and refid_jurnal='$IDUBAH' order by debetkredit DESC";
	$debet=$nilaidebet['debet'];
	$nilaikredit=mysql_fetch_array(mysql_query("select sum(t_jurnal_keuangan_det.kredit) as kredit from t_jurnal_keuangan_det where status!='3' and refid_jurnal='$IDUBAH' order by debetkredit DESC "));
	$kredit=$nilaikredit['kredit'];
	$total=$debet-$kredit;
		
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
		}
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
$jurnal_keuangan_ins = new jurnal_keuangan_insObj();
?>