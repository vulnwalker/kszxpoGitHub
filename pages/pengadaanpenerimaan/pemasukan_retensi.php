<?php
 include "pages/pencarian/DataPengaturan.php";
 $DataOption = $DataPengaturan->DataOption();

class pemasukan_retensiObj  extends DaftarObj2{	
	var $Prefix = 'pemasukan_retensi';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_penerimaan_retensi'; //daftar 
	var $TblName_Hapus = 't_penerimaan_retensi';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $totalCol = 12; //total kolom daftar
	var $fieldSum_lokasi = array();
	var $FieldSum_Cp1 = array();//berdasar mode
	var $FieldSum_Cp2 = array();	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'PENGADAAN DAN PENERIMAAN';
	var $PageIcon = 'images/pengadaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'SKPD';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'pemasukan_retensiForm'; 
			
	function setTitle(){
		return 'RETENSI BARANG';
	}
	
	/*function setMenuView(){
		return "";
	}*/
	
	function setMenuEdit(){		
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Validasi()","validasi-menu.png","Validasi", 'Validasi')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".PostingForm()","publishdata.png","Posting", 'Posting')."</td>";
	}
	
	function setMenuView(){
		return 
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Laporan()","print_f2.png","Laporan", 'Laporan')."</td>";
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
		$validasi=cekPOST2("validasi");
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi", "*", "WHERE Id='$idplh' ");
		$dt = $qry["hasil"];
		
		if($validasi == "" && $dt["status_validasi"] == "0")$err="Validasi Data, Belum Di Ceklis !";
		if($validasi == "" && $dt["status_posting"] == "1")$err="Tidak Bisa Membatalkan Validasi Data, Data Telah Di Posting!";
		//if($err == "")$err="dfgh";
		
		if($err == ""){
			if($dt["status_validasi"] == "1"){
				$data_upd = array(
								array("uid_validasi",""),
								array("status_validasi","0"),
								array("tgl_validasi",""),
							);
				$content=0;
			}else{
				$data_upd = array(
								array("uid_validasi",$uid),
								array("status_validasi","1"),
								array("tgl_validasi",date("Y-m-d H:i:s")),
							);
				$content=1;
			}
			$qry_upd = $DataPengaturan->QryUpdData("t_penerimaan_retensi", $data_upd,"WHERE Id='$idplh' ");
			
		}
					
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }	
	
	/*function setTopBar(){
	   	return '';
	}*/
	
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
		
		case 'CekEdit':{				
			$fm = $this->CekEdit();				
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
		
		case 'Validasi':{
			$fm = $this->setValidasi();				
			$cek .= $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];													
		break;
		}
		
	    case 'DataCopy':{
			$get= $this->DataCopy();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		
		case 'PostingForm':{				
			$fm = $this->PostingForm();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'SimpanPosting':{				
			$fm = $this->SavePosting();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'UpdatePosting':{				
			$fm = $this->UpdatePosting();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'Cek_SimpanPosting':{				
			$fm = $this->Cek_SimpanPosting();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'BatalkanPosting':{				
			$fm = $this->BatalkanPosting();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
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
		global $DataPengaturan;
		$scriptload = 

					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			$DataPengaturan->Gen_Script_DatePicker().
			fn_TagScript('js/skpd.js').
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/upload_style.css' type='text/css'>".
			fn_TagScript('js/jquery.js').
			fn_TagScript('js/jquery-ui.js').
			fn_TagScript('js/jquery.min.js').
			fn_TagScript('js/jquery.form.js').
			fn_TagScript('js/jquery-ui.custom.js').
			fn_TagScript('js/pencarian/cariBarang.js').
			fn_TagScript('js/pencarian/DataPengaturan.js').
			fn_TagScript('js/pengadaanpenerimaan/pemasukan_ins.js').
			fn_TagScript('js/pengadaanpenerimaan/Laporan/'.strtolower($this->Prefix).'_baru.js').
			fn_TagScript('js/pengadaanpenerimaan/'.strtolower($this->Prefix).'.js').
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
		$aqry = "SELECT rtd.*, rb.nm_barang FROM  pemasukan_retensi rtd LEFT JOIN ref_barang rb ON (rtd.f1=rb.f1 AND rtd.f2=rb.f2 AND rtd.f=rb.f AND rtd.g=rb.g AND rtd.h=rb.h AND rtd.i=rb.i AND rtd.j=rb.j) WHERE Id='".$this->form_idplh."' "; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
		$dt['jns_transaksi'] = cekPOST("jns_transaksi");
		$dt['kodebarangnya'] = $dt["f"].".".$dt["g"].".".$dt["h"].".".$dt["i"].".".$dt["j"];
		if($DataOption["kode_barang"] == "2")$dt['kodebarangnya']= $dt["f1"].".".$dt["f2"].".".$dt['kodebarangnya'];
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
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
	
	
	
		
	//daftar =================================	
	function setKolomHeader($Mode=1, $Checkbox=''){
		$this->BersihkanData();
		$jns_transaksi = cekPOST("jns_transaksi");
		$dstr = "DISTR";
		if($jns_transaksi == "2")$dstr="KPTLS";
		
	$NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
  	   <th class='th01' width='5' >No.</th>
  	   $Checkbox	
	   <th class='th01'>TANGGAL</th>
	   <th class='th01'>NOMOR</th>
	   <th class='th01'>NAMA REKENING/ BARANG</th>
	   <th class='th01'>HARGA REKENING<br>BELANJA</th>
	   <th class='th01'>HARGA RETENSI<br>BARANG</th>
	   <th class='th01'>VALID</th>
	   <th class='th01'>POST</th>
	   </tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function genDaftar($Kondisi='', $Order='', $Limit='', $noAwal = 0, $Mode=1, $vKondisi_old=''){
		//$Mode -> 1. daftar, 2. cetak hal, 3.cetak all
		$cek =''; $err='';
					
		$MaxFlush=$this->MaxFlush;		
		$headerTable = $this->genDaftarHeader($Mode);		
		$TblStyle =	$this->TblStyle[$Mode-1];//$Mode ==1 ? 'koptable': 'cetak';
		$ListData = 
			"<table class='$TblStyle' border='1'   style='margin:4 0 0 0;width:100%'>".
			$headerTable.
			"<tbody>";
				
		$ColStyle = $this->ColStyle[$Mode-1];//$Mode==1? 'GarisDaftar':'GariCetak';			
		$no=$noAwal; $cb=0; $jmlDataPage =0;
		$TotalHalRp = 0;
		
		//$aqry = "select * from $this->TblName $Kondisi $Order $Limit ";	//echo $aqry;
		//$qry = mysql_query($aqry);
		$aqry = $this->setDaftar_query($Kondisi, $Order, $Limit); $cek .= $aqry.'<br>';
		$tuk_Kondisi = $Kondisi;
		$qry = mysql_query($aqry);
		$numrows = mysql_num_rows($qry); $cek.= " jmlrow = $numrows ";
		if( $numrows> 0 ) {
					
		while ( $isi=mysql_fetch_array($qry)){
			if ( $isi[$this->KeyFields[0]] != '' ){
				$isi = array_map('utf8_encode', $isi);	
				
				$no++;
				$jmlDataPage++;
				if($Mode == 1) $RowAtr = $no % 2 == 1? "class='row0'" : "class='row1'";
				
				$KeyValue = array();
				for ($i=0; $i< sizeof($this->KeyFields) ; $i++) {
					$KeyValue[$i] = $isi[$this->KeyFields[$i]];
				}
				$KeyValueStr = join($this->pemisahID,$KeyValue);
				$TampilCheckBox =  $this->setCekBox($cb, $KeyValueStr, $isi);//$Cetak? '' : 
					
				
				
				//sum halaman
				for ($i=0; $i< sizeof($this->FieldSum) ; $i++) {
					$this->SumValue[$i] += $isi[$this->FieldSum[$i]];
				}
				
				//---------------------------
				$rowatr_ = $RowAtr." valign='top' id='$cb' value='".$isi['Id']."'";
				$bef= $this->setDaftar_before_getrow(
						$no,$isi,$Mode, $TampilCheckBox,  
						$rowatr_,
						$ColStyle
						);
				$ListData .= $bef['ListData'];
				$no = $bef['no'];
				//get row
				$Koloms = $this->setKolomData($no,$isi,$Mode, $TampilCheckBox);	$cek .= $Koloms;		
				
				if($Koloms != NULL){
					
				
					$list_row = genTableRow($Koloms, 
								$rowatr_,
								$ColStyle);		
					
					
					$ListData .= $this->setDaftar_after_getrow($list_row, $isi , $no, $Mode, $TampilCheckBox,
						$RowAtr, $ColStyle);
					
					$cb++;
					
					if( ($Mode == 3 ) && ($cb % $MaxFlush==0) && $cb >0 ){				
						echo $ListData;
						ob_flush();
						flush();
						$ListData='';
						//sleep(2); //tes
					}
				}
			}
		}
		
		}
		
		$ListData .= $this->setDaftar_After($no, $ColStyle);
		//total -----------------------		
		if ($Mode==3) {	//flush
			echo $ListData;
			ob_flush();
			flush();
			$ListData='';			
			$SumHal = $this->genSumHal($Kondisi); 			
		}
		//$SumHal = $this->genSumHal($Kondisi);
		$ContentSum = $this->genRowSum($ColStyle,  $Mode, 
			$SumHal['sums']
		);
		/*$TampilTotalHalRp = number_format($TotalHalRp,2, ',', '.');		
		$TotalColSpan = $this->FieldSum_Cp1[$Mode-1];//$Mode ==1 ? 5 : 4;
		$ContentTotalHal =
			"<tr>
				<td class='$ColStyle' colspan='$TotalColSpan' align='center'><b>Total per Halaman</td>
				<td class='$ColStyle' align='right'><b>$TampilTotalHalRp</td>
				<td class='$ColStyle' colspan='4'></td>
			</tr>" ;
			
		$ContentTotal = 
				"<tr>
					<td class='$ColStyle' colspan='$TotalColSpan' align='center'><b>Total</td>
					<td class='$ColStyle' align='right'><b><div  id='cntDaftarTotal'>".$SumHal['sum']."</div></td>
					<td class='$ColStyle' colspan='4'></td>
				</tr>" ;
		
		if($Mode == 2){			
			$ContentTotal = '';
		}else if($Mode == 3){
			$ContentTotalHal='';			
		}
		$ContentSum=$ContentTotalHal.$ContentTotal;
		*/
		
		$ListData .= 
				//$ContentTotalHal.$ContentTotal.
				$ContentSum.
				"</tbody>".
			"</table>				
			<input type='hidden' id='".$this->Prefix."_jmldatapage' name='".$this->Prefix."_jmldatapage' value='$jmlDataPage'>
			<input type='hidden' id='".$this->Prefix."_jmlcek' name='".$this->Prefix."_jmlcek' value=''>"
			.$vKondisi_old
			;
		if ($Mode==3) {	//flush
			echo $ListData;	
		}
					
		return array('cek'=>$cek,'content'=>$ListData, 'err'=>$err);
	}
	
	function QueryRekening($Id){
		$qry_rek = "SELECT a.*, b.nm_rekening FROM t_penerimaan_retensi_rekening a LEFT JOIN ref_rekening b ON a.k=b.k AND a.l=b.l AND a.m=b.m AND a.n=b.n AND a.o=b.o WHERE a.sttemp='0' AND a.refid_retensi='$Id'";
		
		return $qry_rek;
	}
	
	function QueryRetensiDet($Id){
		$qry_rek = "SELECT a.*, b.nm_barang FROM t_penerimaan_retensi_det a LEFT JOIN ref_barang b ON a.f1=b.f1 AND a.f2=b.f2 AND a.f=b.f AND a.g=b.g AND a.h=b.h AND a.i=b.i AND a.j=b.j WHERE a.sttemp='0' AND a.refid_retensi='$Id'";
		
		return $qry_rek;
	}
	
	function KolomSingkat($cssclass, $i){
		$Koloms='';
		for($x=0;$x<$i;$x++)$Koloms.="<td class='$cssclass' align='left' ></td>";
		return $Koloms;		
	}
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 $no2=0;	 
	 $jns_transaksi = cekPOST("jns_transaksi");
	 $jml = $isi['jml'];
	 if($jns_transaksi == "2")$jml = $jml*$isi['kuantitas'];
	 
	 $barangDistribusi = "TDK";
	 if($isi["barangdistribusi"] == "1")$barangDistribusi="YA";
	 
	 $cssclass = 'GarisCetak';
	 if($Mode == 1)$cssclass = 'GarisDaftar';
	 	 
	 $Koloms= "<tr class='row0'>";
	 	$Koloms.="<td class='$cssclass' align='center' >$no</td>";
	  	if ($Mode == 1) $Koloms.="<td class='$cssclass' align='center' >$TampilCheckBox</td>";
		$Koloms.="<td class='$cssclass' align='center' >".$isi['tgl_kontrak']."</td>";
		$Koloms.="<td class='$cssclass' align='left' >".$isi['nomor_kontrak']."</td>";
		// Data Rekening -----------------------------------------------------------------------------------------	
		$subTotalRek=0;	
		$aqry_rek = mysql_query($this->QueryRekening($isi["Id"]));
		while($dt_rek = mysql_fetch_array($aqry_rek)){
			if($no2!=0){
				$rowrek="row1";
				if($no2%2==0)$rowrek="row0";
				if($no2!=0)$Koloms.="<tr class='$rowrek'>";
					$Koloms.=$this->KolomSingkat($cssclass,4);
			}
			
			$Koloms.="<td class='$cssclass' align='left' >".$dt_rek['nm_rekening']."</td>";
			$Koloms.="<td class='$cssclass' align='right' >".number_format($dt_rek["jumlah"], 2,",",".")."</td>";
			$Koloms.=$this->KolomSingkat($cssclass,3)."</tr>";			
			$no2++;
			$subTotalRek+=$dt_rek["jumlah"];
		}
		
		//Status Valid
		$valid="invalid";
		if($isi["status_validasi"] == "1")$valid="valid";
		//Status Posting
		$post="invalid";
		if($isi["status_posting"] == "1")$post="valid";
		
		//Data Detail Retensi ---------------------------------------------------------------------------------
		$subTotalDet=0;	
		$no3=0;
		$aqry_retensi_det = mysql_query($this->QueryRetensiDet($isi["Id"]));
		
		while($dt_ret_det = mysql_fetch_array($aqry_retensi_det)){
			if($no2%2==0){
				$rowrek="row0";
			}else{
				$rowrek="row1";
			}
			$Koloms.="<tr class='$rowrek'>";
			$Koloms.=$this->KolomSingkat($cssclass,2);
			if($no3==0){	
				$tgl_buku='';
				$id_retensi='';
				if(mysql_num_rows($aqry_retensi_det) == 1){
					$tgl_buku = explode("-",$isi['tgl_buku']);
					$tgl_buku = "<br>".$tgl_buku[2]."-".$tgl_buku[1]."-".$tgl_buku[0];
					$id_retensi = "<br>".$isi['id_retensi'];
				}
				$Koloms.="<td class='$cssclass' align='center' >".$isi['tgl_dokumen_sumber'].$tgl_buku."</td>";
				$Koloms.="<td class='$cssclass' align='left' >".$isi['no_dokumen_sumber'].$id_retensi."</td>";
				
			}else{
				if($no3==1){
					$tgl_buku = explode("-",$isi['tgl_buku']);
					$tgl_buku = $tgl_buku[2]."-".$tgl_buku[1]."-".$tgl_buku[0];
					$Koloms.="<td class='$cssclass' align='center' >".$tgl_buku."</td>";
					$Koloms.="<td class='$cssclass' align='left' >".$isi['id_retensi']."</td>";
				}else{
					$Koloms.=$this->KolomSingkat($cssclass,2);	
				}
				
			}
			
			$Koloms.="<td class='$cssclass' align='left' ><span style='margin-left:25px;'>".$dt_ret_det['nm_barang']."</span></td>";
			$Koloms.=$this->KolomSingkat($cssclass,1);
			$Koloms.="<td class='$cssclass' align='right' >".number_format($dt_ret_det["harga_total"], 2,",",".")."</td>";
			$Koloms.="<td class='$cssclass' align='center' ><img src='images/administrator/images/$valid.png' width='20px' height='20px' /></td>";
			$Koloms.="<td class='$cssclass' align='center' ><img src='images/administrator/images/$post.png' width='20px' height='20px' /></td>";		
			$no2++;
			$no3++;
			$subTotalDet+=$dt_ret_det["harga_total"];
		}
		
		//SUB TOTAL ---------------------------------------------------------------------------------------
		$Koloms.=
			"<tr class='row1'>
				<td class='$cssclass' align='right' colspan='5'><b>SUB TOTAL</b></td>
				<td class='$cssclass' align='right' ><b>".number_format($subTotalRek, 2,",",".")."</b></td>
				<td class='$cssclass' align='right' ><b>".number_format($subTotalDet, 2,",",".")."</b></td>
				<td class='$cssclass' align='left' colspan='2'></td>
			</tr>";
			
	  
	 $Koloms = array(
	 	array("Y", $Koloms),
	 );
	 
	 return $Koloms;
	}
		
	function genDaftarOpsi(){
	 global $Ref, $Main, $DataPengaturan, $DataOption;
	
	$fmJns = $_REQUEST['fmJns'];	
	$crSyarat = $_REQUEST['crSyarat'];	
	
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	
	
	$TampilOpt = "<input type='hidden' id='ver_skpd' value='".$DataOption['skpd']."' />".
				genFilterBar(array(WilSKPD_ajx3($this->Prefix.'SKPD2','100%','145px')),'','','');
			
		return array('TampilOpt'=>$TampilOpt);
	}				
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS,$_COOKIE;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$arrKondisi = array();	
		$fmJns = $_REQUEST['fmJns'];
		$crSyarat = $_REQUEST['syarat'];
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		$pemasukan_ins_idplh = cekPOST("pemasukan_ins_idplh");
		
		$c1input = $_COOKIE['cofmURUSAN'];
		$cinput = $_COOKIE['cofmSKPD'];
		$dinput = $_COOKIE['cofmUNIT'];
		$einput = $_COOKIE['cofmSUBUNIT'];
		$e1input = $_COOKIE['cofmSEKSI'];
		
		
		switch($fmPILCARI){			
			
			case 'selectNama': $arrKondisi[] = " nama_rek like '%$fmPILCARIvalue%'"; break;	
			case 'selectRuang': $arrKondisi[] = " syarat like '%$fmPILCARIvalue%'"; break;	
								 	
		}	
		//$arrKondisi[] = " refid_terima = '$pemasukan_ins_idplh'" ;
		if($c1input != '' && $c1input != '0')$arrKondisi[] = "c1='$c1input'";
		if($cinput != '' && $cinput != '00')$arrKondisi[] = "c='$cinput'";
		if($dinput != '' && $dinput != '00')$arrKondisi[] = "d='$dinput'";
		if($einput != '' && $einput != '00')$arrKondisi[] = "e='$einput'";
		if($e1input != '' && $e1input != '000')$arrKondisi[] = "e1='$e1input'";
		$arrKondisi[] = " sttemp = '0'" ;
		
		
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
	
	function DataCopy(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		$err=''; $cek=''; $content = '';
		
		$Idplh = cekPOST("ref_templatebarang_idplh");
		$IdDet = addslashes($_REQUEST['datakopi']);
		
		$qry = $DataPengaturan->QyrTmpl1Brs("pemasukan_retensi", "*", "WHERE Id='$IdDet' AND refid_templatebarang='$Idplh' AND status!='2'");$cek.=$qry["cek"];
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
				$qry_ins = $DataPengaturan->QryInsData("pemasukan_retensi", $data);$cek.=" | ".$qry_ins["cek"];
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
	
	function setPage_HeaderOther(){	
	
	return 
			"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=pemasukan&halman=1\" title='PENGADAAN' >PENGADAAN</a> | 
	<A href=\"pages.php?Pg=pemasukan&halman=2\" title='PEMELIHARAAN' >PEMELIHARAAN</a> |
	<A href=\"pages.php?Pg=pemasukan_retensi\" title='RETENSI' style='color:blue'  >RETENSI</a> 
	&nbsp&nbsp&nbsp	
	</td></tr></table>";
	}
	
	function setValidasi(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$idplh = $cbid[0];
		$this->form_idplh = $cbid[0];
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi","*"," WHERE Id = '$idplh' ");$cek=$qry["cek"];
		$dt = $qry["hasil"];
		
		$qryvalid =  $DataPengaturan->QyrTmpl1Brs("admin","nama","WHERE uid='".$dt['uid_validasi']."'");
		$aqry_namavalid = $qryvalid["hasil"];
		
		$prosesValid = TRUE;
		if($Main->ADMIN_BATAL_VALIDASI == 1){
			$qry_LevelLogin = $DataPengaturan->QyrTmpl1Brs("admin", "level", "WHERE uid='$uid' ");
			$dt_LvlLogin = $qry_LevelLogin["hasil"];
			
			if($dt_LvlLogin["level"] == "1")$prosesValid = FALSE;				 
		}
		
		if($prosesValid){
			if($dt['status_validasi'] == '1')if($dt['uid_validasi'] != '' || $dt['uid_validasi'] != null)if($dt['uid_validasi'] != $uid)$err = "Data Sudah di Validasi, Perubahan Hanya Bisa Dilakukan oleh ".$aqry_namavalid['nama']." !";
		}
		
		if($err == ""){
			$get = $this->setFormValidasi($dt);
			$cek.=$get["cek"];
			$err=$get["err"];
			$content=$get["content"];
		}
		
		
		return array('err'=>$err,'cek'=>$cek, 'content' => $content);	
	}
	
	function setFormValidasi($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 450;
	 $this->form_height = 110;
	 $this->form_caption = 'VALIDASI RETENSI';
	  if ($dt['status_validasi'] == '1') {
	  	//2017-03-30 17:12:16
		$tglvalidnya = $dt['tgl_validasi'];
		$thn1 = substr($tglvalidnya,0,4); 
		$bln1 = substr($tglvalidnya,5,2); 
		$tgl1 = substr($tglvalidnya,8,2); 
		$jam1 = substr($tglvalidnya,11,8);
		
		$tglvalid = $tgl1."-".$bln1."-".$thn1." ".$jam1;
		
		$checked = "checked='checked'";			
	  }else{			
		$tglvalid = date("d-m-Y H:i:s");
		$checked = "";	
	  }
	  
	  $tgl_kontrak = explode("-",$dt['tgl_kontrak']);
	  $tgl_kontrak=$tgl_kontrak[2]."-".$tgl_kontrak[1]."-".$tgl_kontrak[0];
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			'nomor_kontrak' => array( 
						'label'=>'NOMOR KONTRAK',
						'labelWidth'=>150, 
						'value'=>$dt['nomor_kontrak'], 
						'type'=>'text',
						'param'=>"style='width:250px;' readonly"
						 ),
			'tgl_kontrak' => array( 
						'label'=>'TANGGAL KONTRAK',
						'labelWidth'=>150, 
						'value'=>$tgl_kontrak, 
						'type'=>'text',
						'param'=>"style='width:80px;' readonly"
						 ),
			'tgl_validasi' => array( 
						'label'=>'TANGGAL',
						'labelWidth'=>150, 
						'value'=>$tglvalid, 
						'type'=>'text',
						'param'=>"style='width:125px;' readonly"
						 ),
			'validasi' => array( 
						'label'=>'VALIDASI DATA',
						'labelWidth'=>150, 
						'value'=>"<input type='checkbox' name='validasi' $checked style='margin-left:-1px;' />",
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
	
	function Hapus_Validasi($id){
		global $DataPengaturan;
		
		$errmsg ='';		
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi", "*", "WHERE Id='$id' ");
		$dt = $qry["hasil"];
		
		//Hitung di pemeliharaan
		$qry_pemeliharaan = $DataPengaturan->QryHitungData("pemeliharaan","WHERE refid_retensi='$id'");
		if($errmsg == "" && $qry_pemeliharaan["hasil"] > 0)$errmsg="Data Sudah di Posting, Tidak Bisa di Hapus !";
		if($errmsg == "" && $dt["status_posting"] == "1")$errmsg="Data Sudah di Posting, Tidak Bisa di Hapus !";		
		if($errmsg == "" && $dt["status_validasi"] == "1")$errmsg="Data Sudah di Validasi, Tidak Bisa di Hapus !";
		
		return $errmsg;
	}
	
	function PostingForm(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$idplh = $cbid[0];
		$this->form_idplh = $cbid[0];
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi","*"," WHERE Id = '$idplh' ");$cek=$qry["cek"];
		$dt = $qry["hasil"];
		
		if($err==""){
			$dt['persen']=0;
			$qry_det = "SELECT * FROM t_penerimaan_retensi_det WHERE refid_retensi='$idplh' AND sttemp='0' ";
			$aqry_det = mysql_query($qry_det);
			while($dt_det = mysql_fetch_array($aqry_det)){
				$dt['barangnya'][] = $dt_det["Id"];
			}
			
			$hitung_pmlhrn = $DataPengaturan->QryHitungData("pemeliharaan","WHERE refid_retensi='$idplh'");
			if($hitung_pmlhrn["hasil"] != 0)$dt['persen']=intval((mysql_num_rows($aqry_det)/$hitung_pmlhrn['hasil'])*100);
						
			$get = $this->setFormPosting($dt);
			$cek.=$get["cek"];
			$err=$get["err"];
			$content=$get["content"];			
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
		
	function setFormPosting($dt){	
	 global $SensusTmp, $DataPengaturan;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 500;
	 $this->form_height = 230;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'POSTING DATA RETENSI';
		//$nip	 = '';
		$disabled = FALSE;
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		$checked = $dt['status_posting']=="1"?"checked":"";
		
		$BARANGNYA = '';
		for($i=0;$i<count($dt['barangnya']);$i++){
			$BARANGNYA .= "<input type='hidden' id='id_barangnya_$i' name='id_barangnya_$i' value='".$dt['barangnya'][$i]."' />";
		}
		
		$tgl_kontrak = explode("-",$dt['tgl_kontrak']);
		$tgl_kontrak = $tgl_kontrak[2]."-".$tgl_kontrak[1]."-".$tgl_kontrak[0];
		
		$tgl_post=$dt['tgl_posting'];
		//2017-01-02
		$tgl_posting = $dt['status_posting'] == "1"?substr($tgl_post,8,2)."-".substr($tgl_post,5,2)."-".substr($tgl_post,0,4):date("d-m-Y");
		
		//Hitung Jumlah Barang
		$qry_hitRetensi = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi_det", "IFNULL(SUM(harga_total),0) as harga_total, count(*) as jml_brg", "WHERE refid_retensi='".$dt["Id"]."' AND sttemp='0' ");
		$dt_hitRetensi = $qry_hitRetensi["hasil"];
		
		
	 //items ----------------------
	  $this->form_fields = array(
	  		'nomor_kontrak'=>array(
				'label'=>'NOMOR KONTRAK',
				'labelWidth'=>150, 
				'type'=>'text', 
				'value'=>$dt['nomor_kontrak'],
				'param'=>"readonly style='width:300px;'",
			),	
			'tgl_kontrak'=>array(
				'label'=>'TANGGAL KONTRAK',
				'labelWidth'=>150, 
				'type'=>'text', 
				'value'=>$tgl_kontrak,
				'param'=>"readonly style='width:80px;'",
			),		
			'jml_retensi'=>array(
				'label'=>'JUMLAH BARANG',
				'labelWidth'=>150, 
				'type'=>'text', 
				'value'=>number_format($dt_hitRetensi['jml_brg'],0,'.',','),
				'param'=>"readonly style='width:80px;text-align:right;'",
			),				
			'total_retensi'=>array(
				'label'=>'TOTAL BIAYA RETENSI',
				'labelWidth'=>150, 
				'type'=>'text', 
				'value'=>number_format($dt_hitRetensi['harga_total'],2,',','.'),
				'param'=>"readonly style='width:160px;text-align:right;'",
			),			
			'tgl_posting'=>array(
				'label'=>'TANGGAL POSTING',
				'labelWidth'=>150, 
				'type'=>'text', 
				'value'=>$tgl_posting,
				'param'=>"readonly style='width:80px;'",
			),	
			'stat_posing'=>array(
				'label'=>'POSTING DATA ?',
				'labelWidth'=>150, 
				'value'=>"<input type='checkbox' name='posting' id='posting' value='postingkan' $checked />",
			),	
			'progress' => array(
				'label'=>'',
				'labelWidth'=>1, 
				'type'=>'merge',
				'value'=>				
					"<br><div id='progressbox1' style='background:#fffbf0;border-radius:5px;border:1px solid;height:10px;'>
						<div id='progressbar1'></div >
						<div id='statustxt1' style='width:".$dt["persen"]."%;background:green;height:10px;text-align:right;color:white;font-size:8px;'>".$dt["persen"]."%</div>						
						<div id='output1'></div>
					</div><br>"
				),
			'peringatan' => array( 
				'label'=>'',
				'labelWidth'=>1, 
				'type'=>'merge',
				'value'=>"<div id='pemisah' style='color:red;font-size:11px;'></div>",
			),
			);
		//tombol
		$this->form_menubawah =
			$BARANGNYA.
			"<input type='hidden' name='tot_jmlbarang' id='tot_jmlbarang' value='".$dt_hitRetensi['jml_brg']."'>".
			"<input type='hidden' name='c1' id='c1' value='".$dt['c1']."'>".
			"<input type='hidden' name='c' id='c' value='".$dt['c']."'>".
			"<input type='hidden' name='d' id='d' value='".$dt['d']."'>".
			"<input type='hidden' name='e' id='e' value='".$dt['e']."'>".
			"<input type='hidden' name='e1' id='e1' value='".$dt['e1']."'>".
			"<input type='hidden' name='tahun' id='tahun' value='".$dt['tahun']."'>".
			"<input type='button' value='Posting' onclick ='".$this->Prefix.".SimpanPosting()' title='Posting' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Cek_SimpanPosting(){
		global $Main, $DataPengaturan;
		$err='';$cek='';$content=array();$pesan='';
		
		$idplh = cekPOST2($this->Prefix."_idplh");
		$posting = cekPOST2("posting");
		//Cek Di Pemliharaan 
		$qry_pmlhrn = $DataPengaturan->QryHitungData("pemeliharaan", "WHERE refid_retensi='$idplh' ");
		
		//Cek Jumlah di t_penerimaan_retensi_det
		$qry_ret_det = $DataPengaturan->QryHitungData("t_penerimaan_retensi_det", "WHERE refid_retensi='$idplh' AND sttemp='0' ");		
		
		if($err == "" && $posting == '' && $qry_pmlhrn["hasil"] == 0)$err="Posting Data Belum di Ceklis !";		
		if($err == "" && $posting != '' && $qry_pmlhrn["hasil"] == $qry_ret_det["hasil"])$err="Data Sudah di Posting !";
		
		if($err == ""){
			if($posting == '' && $qry_pmlhrn["hasil"] > 0){
				$content['pesan']="Batalkan Posting Data ?";
				$content['tanya']="3";
			}	
			
			if($posting != '' && $qry_pmlhrn["hasil"] < $qry_ret_det["hasil"] && $qry_pmlhrn["hasil"] != 0){
				$content['pesan']="Lanjutkan Posting Data ?";
				$content['tanya']="2";
			}
			
			if($content['pesan'] == "" && $content['tanya']==""){
				$content['pesan']="Posting Data ?";
				$content['tanya']="1";
			}
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function PersenPostingRetensi($Id){
		global $DataPengaturan;
		$Persen=0;
		$qry_retensi_det = $DataPengaturan->QryHitungData("t_penerimaan_retensi_det","WHERE refid_retensi='$Id' AND sttemp='0' ");
		$qry_pmlhrn = $DataPengaturan->QryHitungData("pemeliharaan", "WHERE refid_retensi='$Id'");
		
		if($qry_retensi_det["hasil"] != 0)$Persen = ($qry_pmlhrn["hasil"]/$qry_retensi_det["hasil"])*100;		
		return intval($Persen);
		
	}
	
	function SavePosting(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		//Cek Dulu Di Pemeliharaan;
		$IdRetensiDet = cekPOST2("IdRetensiDet");
		$Id = cekPOST2($this->Prefix."_idplh");
		
		$qry_pmlhrn = $DataPengaturan->QryHitungData("pemeliharaan", "WHERE refid_retensi='$Id' AND refid_retensi_det='$IdRetensiDet'");
		if($qry_pmlhrn["hasil"] == 0){
			$qry_retensi = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi a LEFT JOIN t_penerimaan_retensi_det b", "a.tgl_buku, a.nomor_kontrak, a.tgl_kontrak,a.tgl_dokumen_sumber, a.no_dokumen_sumber,  b.*", "ON a.Id=b.refid_retensi WHERE b.Id='$IdRetensiDet' AND b.refid_retensi='$Id' ");$cek.=$qry_retensi["cek"];
			$dt_retensi = $qry_retensi['hasil'];
			
			//Cek Kode Belanja
			$qry_rek = $DataPengaturan->QryHitungData("t_penerimaan_retensi_rekening", "WHERE concat(k,'.',l,'.',m) = '".$Main->KODE_BELANJA_MODAL."'");
			$cara_perolehan = 2;
			if($qry_rek['hasil'] > 0)$cara_perolehan=1;
			
			$data = 
				array(
					array("id_bukuinduk", $dt_retensi["id_bi"]),
					array("tgl_pemeliharaan", $dt_retensi["tgl_buku"]),
					array("surat_no", $dt_retensi["nomor_kontrak"]),
					array("surat_tgl", $dt_retensi["tgl_kontrak"]),
					array("jenis_pemeliharaan", "RETENSI"),
					array("biaya_pemeliharaan", $dt_retensi['harga_total']),
					array("uid", $uid),
					array("tgl_perolehan", $dt_retensi["tgl_buku"]),
					array("no_bast", $dt_retensi["no_dokumen_sumber"]),
					array("tgl_bast", $dt_retensi["tgl_dokumen_sumber"]),
					array("refid_retensi", $Id),
					array("refid_retensi_det", $IdRetensiDet),
					array("cara_perolehan", $cara_perolehan),
					array("tambah_aset", "1"),
					//array("tambah_masamanfaat", "1"),
				);
				
			$qry_Inp = $DataPengaturan->QryInsData("pemeliharaan", $data);
			$cek.=$qry_Inp["cek"];
		}
			$content['maxpersen']=$this->PersenPostingRetensi($Id);
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function UpdatePosting(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		$Id = cekPOST2($this->Prefix."_idplh");
		$kondisi=cekPOST2("kondisi");
		
		$status_posting=0;
		$tgl_posting='';
		$uid_posting='';
		
		if($kondisi == "1"){
			$status_posting=1;
			$tgl_posting=date("Y-m-d H:i:s");
			$uid_posting=$uid;
		}
		
		$data_upd = array(
						array("status_posting",$status_posting),
						array("tgl_posting",$tgl_posting),
						array("uid_posting",$uid_posting),
					);
		$qry = $DataPengaturan->QryUpdData("t_penerimaan_retensi",$data_upd, "WHERE Id='$Id' ");$cek.=$qry["cek"];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function BatalkanPosting(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$cek='';$err='';$content='';
		$Id = cekPOST2($this->Prefix."_idplh");
		
		$qry="DELETE FROM pemeliharaan WHERE refid_retensi='$Id' LIMIT 100";$cek.=$qry;
		$aqry = mysql_query($qry);
		
		$Persen = $this->PersenPostingRetensi($Id);
		
		$content['next']=0;
		if($Persen > 0)$content['next']=1;
		$content['maxpersen']=$Persen;
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function CekEdit(){
		global $DataPengaturan;
		$cek='';$err='';$content='';$errmsg='';
		
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$idplh = $cbid[0];	
		
		$qry = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_retensi", "*", "WHERE Id='$idplh' ");
		$dt = $qry["hasil"];
		
		//Hitung di pemeliharaan
		$qry_pemeliharaan = $DataPengaturan->QryHitungData("pemeliharaan","WHERE refid_retensi='$idplh'");
		if($errmsg == "" && $qry_pemeliharaan["hasil"] > 0)$errmsg="Data Sudah di Posting, Tidak Bisa di Ubah !";
		if($errmsg == "" && $dt["status_posting"] == "1")$errmsg="Data Sudah di Posting, Tidak Bisa di Ubah !";		
		if($errmsg == "" && $dt["status_validasi"] == "1")$errmsg="Data Sudah di Validasi, Tidak Bisa di Ubah !";
		
		
		return	array ('cek'=>$cek, 'err'=>$errmsg, 'content'=>$content);
	}
	
	function BersihkanData(){
		$cek='';
		//Retensi Rekening
		$hapusrek = "DELETE FROM t_penerimaan_retensi_rekening WHERE tgl_update < DATE_SUB(NOW(), INTERVAL 3 HOURS) AND sttemp!='0'"; $cek.="| ".$hapusrek;
		$qry_hapusrek = mysql_query($hapusrek);
		
		$updrek = "UPDATE t_penerimaan_retensi_rekening SET status='0' WHERE tgl_update < DATE_SUB(NOW(), INTERVAL 15 MINUTE) AND sttemp='0'";$cek.="| ".$updrek;
		$qry_updrek = mysql_query($updrek);		
					
					
		//Retensi Detail -----------------------------------------------------------------------------------
		$hapuspenerimaan_det = "DELETE FROM t_penerimaan_retensi_det WHERE tgl_update < DATE_SUB(NOW(), INTERVAL 30 MINUTE) AND sttemp!='0'"; $cek.="| ".$hapuspenerimaan_det;
		$qry_hapuspenerimaan_det	= mysql_query($hapuspenerimaan_det);
		
		$updpenerimaan_det =  "UPDATE t_penerimaan_retensi_det SET status='0' WHERE tgl_update < DATE_SUB(NOW(), INTERVAL 15 MINUTE) AND sttemp='0'"; $cek.='| '.$updpenerimaan_det;
		
		$qry_updpenerimaan_det = mysql_query($updpenerimaan_det);		
					
		//Retensi ------------------------------------------------------------------------------------------
		$hapus_penerimaan = "DELETE FROM t_penerimaan_retensi WHERE tgl_create < DATE_SUB(NOW(), INTERVAL 2 DAY) AND sttemp!='0'"; $cek.="| ".$hapus_penerimaan;		
		$qry_hapus_penerimaan = mysql_query($hapus_penerimaan);
				
		return $cek;
	}
}
$pemasukan_retensi = new pemasukan_retensiObj();
?>