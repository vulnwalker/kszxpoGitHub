<?php
 include "pages/pengadaanpenerimaan/pemasukan.php";
 $DataPemasukan = $pemasukan;

class pemasukan_ins_detObj  extends DaftarObj2{	
	var $Prefix = 'pemasukan_ins_det';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'v1_penerimaan_barang_det'; //daftar 
	var $TblName_Hapus = 't_penerimaan_barang_det';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array('jml', 'harga_satuan','harga_total');//array('jml_harga');
	var $SumValue = array();
	var $totalCol = 12; //total kolom daftar
	var $fieldSum_lokasi = array(4,6,8);
	var $FieldSum_Cp1 = array(4, 3, 3);//berdasar mode
	var $FieldSum_Cp2 = array(4, 4, 4);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'PENGADAAN DETAIL';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'SKPD';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'pemasukan_ins_detForm'; 
			
	function setTitle(){
		return 'Refrensi Template Barang';
	}
	
	function setMenuView(){
		return "";
	}
	
	function setMenuEdit(){		
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus').
			"</td>";
	}
	
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		
		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>";	
	}	
	
	function simpan(){
	  global $Ref, $Main, $HTTP_COOKIE_VARS,$DataOption, $DataPengaturan;
		
		$cek = '';$err='';$content='';
		
	 	$uid = $HTTP_COOKIE_VARS['coID'];
	 	$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		
		$idplh = cekPOST($this->Prefix.'_idplh');
		$FMST = cekPOST($this->Prefix.'_fmST');
		$Refid = cekPOST("refid_templatebarang");
		
		$c1nya = cekPOST('c1nya');
		$cnya = cekPOST('cnya');
		$dnya = cekPOST('dnya');
		$enya = cekPOST('enya');
		$e1nya = cekPOST('e1nya');
		
		if($DataOption['skpd'] != 2)$c1nya="0";
		$kodebarang = cekPOST('kodebarang');
		$keteranganbarang = cekPOST('keteranganbarang');
		$jumlah_barang = cekPOST('jumlah_barang');
		$satuan = cekPOST('satuan');
		$harga_satuan = cekPOST('harga_satuan');
		$keterangan = cekPOST('keterangan');
		$kuantitas = cekPOST('kuantitas');
		$ket_kuantitas = cekPOST('ket_kuantitas');
		$Refid = cekPOST('refid_templatebarang');
		
		$qryTampil = $DataPengaturan->QyrTmpl1Brs("ref_templatebarang", "*", "WHERE Id='$Refid' ");$cek.=$qryTampil["cek"];
		$dtTampil = $qryTampil["hasil"];
		$jns_transaksi=$dtTampil["jns_trans"];
		
		//PPN ----------------------------PAJAK ------------------------------------------------------------
		$ppn_ok = cekPOST("ppn_ok");
		$jml_ppn = cekPOST("jml_ppn");
		
		if(isset($_REQUEST['barang_didistribusi'])){
			$barang_didistribusi = addslashes($_REQUEST['barang_didistribusi']);
		}else{
			$barang_didistribusi = '0';
		}
		
		$pid_BIRM = cekPOST("kode_account_ap");
		
		//PENGATURAN KODE BARANG
		
		$kodebrg = explode(".",$kodebarang);
		if($DataOption['kode_barang'] == '1'){
			$where_kode = "concat(f,'.',g,'.',h,'.',i,'.',j)";
			
			$f = $kodebrg[0];
			$g = $kodebrg[1];
			$h = $kodebrg[2];
			$i = $kodebrg[3];
			$j = $kodebrg[4];
			$inpt_kd_brg = "";			
			$val_inpt_kd_brg = "";			
		}else{
			$where_kode = "concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j)";
			$f1 = $kodebrg[0];
			$f2 = $kodebrg[1];
			$f = $kodebrg[2];
			$g = $kodebrg[3];
			$h = $kodebrg[4];
			$i = $kodebrg[5];
			$j = $kodebrg[6];	
			$inpt_kd_brg = "f1,f2,";
			$val_inpt_kd_brg="'$f1','$f2',";
		}
		
		
		if($err == ''){
			$hit_Barang=$DataPengaturan->QryHitungData("ref_barang"," WHERE $where_kode = '$kodebarang' AND j!='000' ");
			if($hit_Barang["hasil"] < 1)$err = "Kode Barang Tidak Valid !";
		}
		if($err =='' && $jns_transaksi == '')$err = "Jenis Transaksi Belum Dipilih !";
			
		if($err == '' && $harga_satuan < 1)$err = "Harga Satuan Belum Diisi !";
		if($err == ''){
			if($jns_transaksi == '2')if($err == '' && $kuantitas < 1)$err = "Jumlah Kuantitas Tidak Boleh 0 !";
		}
		
		if($err == ''){
			if($FMST == '1'){			
				if($idplh!= ''){
					$upd = "UPDATE $this->TblName SET status='2' WHERE Id='$idplh' ";$cek.=$upd; 
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
									
			$simpan = "INSERT INTO $this->TblName_Hapus (c1,c,d,e,e1,$inpt_kd_brg f,g,h,i,j,ket_barang,jml,satuan,harga_satuan, harga_total,keterangan,barangdistribusi,status,refid_templatebarang,sttemp,uid,kuantitas,ket_kuantitas, pajak, ppn) values ('$c1nya', '$cnya', '$dnya', '$enya', '$e1nya', $val_inpt_kd_brg '$f', '$g', '$h', '$i', '$j', '$keteranganbarang', '$jumlah_barang', '$satuan', '$harga_satuan', '$hargatotal', '$keterangan', '$barang_didistribusi', '1', '$Refid', '1','$uid','$kuan', '$ket_kuan', '$pajak', '$ppn')";$cek .= $simpan ; 
			
			$qrysimpan = mysql_query($simpan);
		}
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	function setTopBar(){
	   	return '';
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
		
	    case 'DataCopy':{
			$get= $this->DataCopy();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
	    			
	   
	  /* case 'hapus':{	
				$fm= $this->Hapus($pil);
				$err= $fm['err']; 
				$cek = $fm['cek'];
				$content = $fm['content'];
		break;
		}	*/		
	   
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
			"<script type='text/javascript' src='js/pencarian/cariBarang.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/pengadaanpenerimaan/pemasukan_ins.js' language='JavaScript' ></script>".
			 "<script type='text/javascript' src='js/pengadaanpenerimaan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>
			 ".
			// "<script type='text/javascript' src='js/master/ref_aset/refjurnal.js' language='JavaScript' ></script>".
			
			$scriptload;
	}
		
	function setFormBaru(){
		global $DataOption;
		$err="";$content="";$cek=''; 
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek = $cbid[0];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$dt=array();
		$this->form_fmST = 0;
		
		$c1 = cekPOST("c1nya");
		$c = cekPOST("cnya");
		$d = cekPOST("dnya");
		$e = cekPOST("enya");
		$e1 = cekPOST("e1nya");
		$jns_transaksi = cekPOST("jns_transaksi");
		
		if($err == ""){
			$dt["c1"] = $c1;
			$dt["c"] = $c;
			$dt["d"] = $d;
			$dt["e"] = $e;
			$dt["e1"] = $e1;
			$dt['ket_kuantitas']='KALI';
				
			$dt['jns_transaksi'] = cekPOST("jns_transaksi");	
			$dt['refid_templatebarang']=cekPOST("IdPilih");
			
			$fm = $this->setForm($dt);
			$cek.=$fm['cek'];
			$err=$fm['err'];
			$content=$fm['content'];
		}
		
			
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
  	function setFormEdit(){
		global $DataOption;
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = $cbid[0];
		$this->form_fmST = 1;				
		//get data 
		$aqry = "SELECT rtd.*, rb.nm_barang FROM  pemasukan_ins_det rtd LEFT JOIN ref_barang rb ON (rtd.f1=rb.f1 AND rtd.f2=rb.f2 AND rtd.f=rb.f AND rtd.g=rb.g AND rtd.h=rb.h AND rtd.i=rb.i AND rtd.j=rb.j) WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$dt['jns_transaksi'] = cekPOST("jns_transaksi");
		$dt['kodebarangnya'] = $dt["f"].".".$dt["g"].".".$dt["h"].".".$dt["i"].".".$dt["j"];
		if($DataOption["kode_barang"] == "2")$dt['kodebarangnya']= $dt["f1"].".".$dt["f2"].".".$dt['kodebarangnya'];
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	
	function setForm_content_fields(){
		$content = '';
		
		foreach ($this->form_fields as $key=>$field){
			if(!isset($field['lewat'])){
				if ($field['type'] == ''){
					$val = $field['value'];
				}else{
					$val = Entry($field['value'],$key,$field['param'],$field['type']);	
				}
				
				if($field['ttkDua']==''){ $ttkDua=':' ;}else { $ttkDua=$field['ttkDua']; }			
				if($field['valign'] ==''){	$valign = 'top';}else{	$valign = $field['valign'];	}
				
				$content .= 
					"<tr valign='$valign'>
						<td style='width:".$field['labelWidth']."'>".$field['label']."</td>
						<td style='width:10'>$ttkDua</td>
						<td>". $val."</td>
					</tr>";
			}
			
		}
		return $content;	
	}	
	
	
	function setForm($dt){	
	 global $SensusTmp ,$Main,$DataPengaturan;
	 
	 $cek = ''; $err=''; $content=''; 
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 800;
	 $this->form_height = 320;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'FORM BARU TEMPLATE BARANG DETAIL';
	  }else{
		$this->form_caption = 'FORM UBAH TEMPLATE BARANG DETAIL';			
		$readonly='readonly';
					
	  }
	  $checDistri = "";
	  if($dt['barangdistribusi'] == "1")$checDistri=" checked";
	  
	  if($dt['jns_transaksi'] == 2){
	  		$volume = $dt['jml'] * $dt['kuantitas'];
			
	  		$ket_barang = "URAIAN PEMELIHARAAN";
			$kuantitas = array(
							'label'=>"KUANTITAS",
							'labelWidth'=>200,
							'value'=>
								"<input type='text' name='kuantitas' value='".floatval($dt['kuantitas'])."' id='kuantitas2' style='width:75px;text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='pemasukan_ins.hitungjumlahHarga(`2`);' onkeyup='pemasukan_ins.hitungjumlahHarga(`2`);' /> ".
								"<input type='text' name='ket_kuantitas' id='ket_kuantitas' value='".$dt['ket_kuantitas']."' style='width:75px;' />",
						);
			$volume = array(
							'label'=>"VOLUME",
							'labelWidth'=>200,
							'value'=>"<input type='text' name='volume' id='volume2' value='".$volume."' style='width:75px;'  readonly/>",
						);
					
			$biayatambahan = "<input type='checkbox' name='barang_didistribusi' value='1' id='barang_didistribusi' style='margin-left:20px;' $checDistri />HARGA DI KAPITALISASI";
			$barangDistribusi='';
			$satuan = "<input type='text name='satuan' id='satuan2' value='".$dt['satuan']."' style='width:75px;' readonly />";
			$arr_satuan = array("lewat"=>"");
	  }else{
	  	$ket_barang = "MERK / TYPE/ SPESIFIKASI/ JUDUL/ LOKASI";
		$biayatambahan = '';
		$kuantitas = array("lewat"=>"");
		$volume = array("lewat"=>"");
		$barangDistribusi = "<input type='checkbox' name='barang_didistribusi' value='1' id='barang_didistribusi' style='margin-left:90px;' $checDistri />BARANG AKAN DIDISTRIBUSIKAN.";
		$satuan = "";
		$arr_satuan=array(
						'label'=>'SATUAN',
						'labelWidth'=>200,
						'value'=>"<input type='text name='satuan' id='satuan2' value='".$dt['satuan']."' style='width:150px;' $satuan_readonly />",
					);
	  }
	  
	  if($dt['ppn'] != 0){
			$ppn_readonly = "";
			$ppn_chechked= "checked";
		}else{
			$ppn_readonly = "readonly";
			$ppn_chechked= "";
			$dt['ppn']='';
		}
	  
	  $message=$dt['syarat'];
		//items ----------------------
			$this->form_fields = array(
			'kode_barang' => array( 
							'label'=>'KODE BARANG',
							'labelWidth'=>200, 
							'value'=>
								"<input type='text' name='kodebarang' onkeyup='cariBarang.pilBar2(this.value, `2`)' id='kodebarang2' placeholder='KODE BARANG' style='width:150px;' value='".$dt['kodebarangnya']."' /> ".
								"<input type='text' name='namabarang' id='namabarang2' placeholder='NAMA BARANG' style='width:350px;' readonly value='".$dt['nm_barang']."' /> ".
								"<input type='button' name='caribarang' id='caribarang' value='CARI' onclick='".$this->Prefix.".CariBarang();'/>", 
							 ),
			'ket_barang'=> array(
							'label'=>$ket_barang,
							'labelWidth'=>200,
							'value'=>"<textarea name='keteranganbarang' style='width:300px;height:50px;' placeholder='$ket_barang'>".$dt['ket_barang']."</textarea>
							",
						),
			'jml_barang'=>array(
							'label'=>'JUMLAH',
							'labelWidth'=>200,
							'value'=>"<input type='text' name='jumlah_barang' value='".floatval($dt['jml'])."' id='jumlah_barang2' style='width:75px;text-align:right;' onkeypress='return isNumberKey(event)'  onkeyup='pemasukan_ins.hitungjumlahHarga(`2`);' $title_jumlah /><span id='MSG_Jumlah'></span> $barangDistribusi $satuan",
						),
			'kuantitas'=>$kuantitas,
			'volume'=>$volume,
			'satuan'=>$arr_satuan,
			'hrg_satuan'=>array(
							'label'=>'HARGA SATUAN',
							'labelWidth'=>200,
							'value'=>"<input type='text' name='harga_satuan' align='right' value='".floatval($dt['harga_satuan'])."' id='harga_satuan2' style='width:150px;text-align:right;' onkeypress='return isNumberKey(event)' onkeyup='document.getElementById(`harga_satuannya2`).innerHTML = pemasukan_ins.formatCurrency(this.value);pemasukan_ins.hitungjumlahHarga(`2`);' /> Rp <span id='harga_satuannya2'>".number_format($dt['harga_satuan'],2,",",".")."</span>
								",
						),
			'ppn'=>array(
							'label'=>'PPN (%)',
							'name'=>'ppn',
							'labelWidth'=>200,
							'value'=>
							"<input type='checkbox' name='ppn_ok' value='1' id='ppn_ok2' onclick='pemasukan_ins.Cek_PPN(`2`);' $ppn_chechked />".
							"<input type='number' min='0' name='jml_ppn' value='".$dt['ppn']."' id='jml_ppn2' style='width:54;text-align:right;' onkeyup='pemasukan_ins.hitungjumlahHarga(`2`);' $ppn_readonly /> %",								
						),
			'jml_harga'=>array(
							'label'=>'JUMLAH HARGA',
							'labelWidth'=>200,
							'value'=>"<input type='text' name='jumlah_harga' value='".number_format($dt['harga_total'],2,",",".")."' id='jumlah_harga2' style='width:150;text-align:right;' readonly />".$biayatambahan,
								
						),
			'keterangan'=>array(
							'label'=>'KETERANGAN',
							'labelWidth'=>200,
							'value'=>"<textarea name='keterangan' style='width:300px;height:50px;' placeholder='KETERANGAN'>".$dt['keterangan']."</textarea>",
						),						
			
			);
		//tombol
		$this->form_menubawah =	
			$DataPengaturan->GenViewHiddenSKPD($dt["c1"],$dt["c"],$dt["d"],$dt["e"],$dt["e1"]).
			"<input type='hidden' name='refid_templatebarang' value='".$dt["refid_templatebarang"]."' />".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >"."&nbsp&nbsp".
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
	
	
	function cekDPA(){
		global $DataPemasukan;
		//Cek DPA UPDATE 2 Januari 2018
		 $Idplh = cekPOST2("pemasukan_ins_idplh");
		 $status_dpa = cekPOST2("status_dpa");
		 $CekDPA = $DataPemasukan->Cek_DataDPA($Idplh,$status_dpa);
		
		return $CekDPA;
	}
		
	//daftar =================================	
	function setKolomHeader($Mode=1, $Checkbox=''){
		global $Main, $DataPemasukan;
		$jns_transaksi = cekPOST("jns_transaksi");
		$dstr = "DISTR";
		if($jns_transaksi == "2")$dstr="KPTLS";
		
		$cols_aksi = $this->cekDPA() == "1" && $Main->PENERIMAAN_DET_DPA_DEL != 1?"":"colspan='2'";		
		$header_dstr = $DataPemasukan->STATUS_MODULPERSEDIAAN() && $jns_transaksi=="3"?"":"<th class='th01'>$dstr</th>";
		
		$NomorColSpan = $Mode==1? 2: 1;
		 $headerTable =
		  "<thead>
		   <tr>
	  	   <th class='th01' width='5' >No.</th>
	  	   <!--$Checkbox-->		
		   <th class='th01'>NAMA BARANG</th>
		   <th class='th01'>MERK / TYPE/ SPESIFIKASI/ JUDUL/ LOKASI</th>
		   <th class='th01'>VOLUME</th>
		   <th class='th01'>SATUAN</th>
		   <th class='th01'>HARGA SATUAN</th>
		   <th class='th01'>PPN (%)</th>
		   <th class='th01'>JUMLAH HARGA</th>
		   $header_dstr
		   <th class='th01'>KET</th>
		   <th class='th01' $cols_aksi >AKSI</th>
		   </tr>
		   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref, $DataPemasukan, $Main;
	 
	 $jns_transaksi = cekPOST("jns_transaksi");
	 $jml = $isi['jml'];
	 if($jns_transaksi == "2")$jml = $jml*$isi['kuantitas'];
	 
	 $barangDistribusi = "TDK";
	 if($isi["barangdistribusi"] == "1")$barangDistribusi="YA";
	 
	 $nama_barang= $isi['nm_barang'] == "" ? "Tidak Valid !":$isi['nm_barang'];	 
	 	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  //if ($Mode == 1) $Koloms[] = array(" align='center' ", $TampilCheckBox);
	  $Koloms[] = array('align="left"',"<a href='javascript:pemasukan_ins.UbahRincianPenerimaan(`".$isi['Id']."`)'>".$nama_barang."</a>");
	  $Koloms[] = array('align="left"',$isi['ket_barang']);
	  $Koloms[] = array('align="right"',number_format($jml,0,".",","));
	  $Koloms[] = array('align="left"',$isi['satuan']);
	  $Koloms[] = array('align="right"',number_format($isi['harga_satuan'],2,",","."));
	  $Koloms[] = array('align="right"',$isi['ppn']);
	  $Koloms[] = array('align="right"',number_format($isi['harga_total'],2,",","."));
	  if($jns_transaksi!="3")$Koloms[] = array('align="center"',$barangDistribusi);
	  $Koloms[] = array('align="left"',$isi['keterangan']);
	  if($Main->PENERIMAAN_DET_DPA_DEL == 1)$Koloms[] = array('align="center"', BtnImgDelete("pemasukan_ins.HapusRincianPenerimaan(`".$isi['Id']."`)","Hapus Data"));
	  $Koloms[] = array('align="center"', BtnImgCopy("pemasukan_ins.GandakanPenerimaan(`".$isi['Id']."`)", "Gandakan Data"));
	 return $Koloms;
	}
		
	function genDaftarOpsi(){
	 global $Ref, $Main, $DataPengaturan;
	
	$fmJns = $_REQUEST['fmJns'];	
	$crSyarat = $_REQUEST['crSyarat'];	
	
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	
	
	$TampilOpt = "";
			
		return array('TampilOpt'=>$TampilOpt);
	}				
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$arrKondisi = array();	
		$fmJns = $_REQUEST['fmJns'];
		$crSyarat = $_REQUEST['syarat'];
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		$pemasukan_ins_idplh = cekPOST("pemasukan_ins_idplh");
		$GetRekeningDPA = cekPOST2("GetRekeningDPA");
		
		
		switch($fmPILCARI){					
			case 'selectNama': $arrKondisi[] = " nama_rek like '%$fmPILCARIvalue%'"; break;	
			case 'selectRuang': $arrKondisi[] = " syarat like '%$fmPILCARIvalue%'"; break;								 	
		}	
		$arrKondisi[] = " refid_terima = '$pemasukan_ins_idplh'" ;
		$arrKondisi[] = " status != '2'" ;
		if($GetRekeningDPA != "")$arrKondisi[] = " concat(k,'_',l,'_',m,'_',n,'_',o) = '$GetRekeningDPA'" ;
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " jns $Asc1 " ;break;
			case '2': $arrOrders[] = " saldo $Asc1 " ;break;
			
		}	
		
		$arrOrders[] = " Id DESC " ;
		
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		
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
	
	function Hapus($ids){
		global $DataPengaturan;
		$err=''; $cek=''; $content = '';
		//$cid= $POST['cid'];
		//$err = ''.$ids;
		for($i = 0; $i<count($ids); $i++)	{
			$err .= $this->Hapus_Validasi($ids[$i]);
			
			if($err ==''){
				//$ids[$i]
				$data = array(
							array("status", "2"),
						);
				$qry = $DataPengaturan->QryUpdData($this->TblName_Hapus, $data, "WHERE Id='".$ids[$i]."'");$cek.=$qry;
				 				
			}else{
				break;
			}			
		}
		return array('err'=>$err,'cek'=>$cek, 'content' => $content);
	} 
	
	function DataCopy(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		$err=''; $cek=''; $content = '';
		
		$Idplh = cekPOST("ref_templatebarang_idplh");
		$IdDet = addslashes($_REQUEST['datakopi']);
		
		$qry = $DataPengaturan->QyrTmpl1Brs("pemasukan_ins_det", "*", "WHERE Id='$IdDet' AND refid_templatebarang='$Idplh' AND status!='2'");$cek.=$qry["cek"];
		$dt = $qry["hasil"];
		
		if($dt['Id'] == "" || $dt["Id"] == NULL){
			$err='Gagal Menggandakan Data !';
		}else{
			$data = array(
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
						array("ket_kuantitas",$dt["ket_kuantitas"]),
						array("satuan",$dt["satuan"]),
						array("harga_satuan",$dt["harga_satuan"]),
						array("harga_total",$dt["harga_total"]),
						array("keterangan",$dt["keterangan"]),
						array("barangdistribusi",$dt["barangdistribusi"]),
						array("refid_templatebarang",$dt["refid_templatebarang"]),
						array("uid",$UID),
						array("pajak",$dt["pajak"]),
						array("sttemp","1"),
						array("status","1"),
					);
			for($i=0;$i<=1000;$i++){
				$qry_ins = $DataPengaturan->QryInsData("pemasukan_ins_det", $data);$cek.=" | ".$qry_ins["cek"];
			}
			
		}
		
		
		
		return array('err'=>$err,'cek'=>$cek, 'content' => $content);
		
	}
	
	function genSum_setTampilValue($i, $value){
		if($i == 0){
			$a = number_format($value, 0, '.' ,',');
		}else{
			$a = number_format($value, 2, ',' ,'.');
		}
		
		return $a;
	}
	
	function genRowSum_setTampilValue($i, $value){
		
		if($i == 0){
			$a = number_format($value, 0, '.' ,',');
		}else{
			$a = number_format($value, 2, ',' ,'.');
		}
		
		return $a;	
	}
	
}
$pemasukan_ins_det = new pemasukan_ins_detObj();
?>