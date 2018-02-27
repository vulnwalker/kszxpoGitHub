<?php
	include "pages/keuangan/daftar_pengeluarankas.php";
	$DataPengeluaranKas = $daftar_pengeluarankas;
	
class form_pengeluarankasObj  extends DaftarObj2{	
	var $Prefix = 'form_pengeluarankas';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_pengeluaran_kas'; //bonus
	var $TblName_Hapus = '';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'PENGELUARAN KAS';
	var $PageIcon = 'images/pengadaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pengeluaran_kas.xls';
	var $namaModulCetak='PENGELUARAN KAS';
	var $Cetak_Judul = 'pengeluaran_kas';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'form_pengeluarankasForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	var $pid_urutan=1;
	var $pid_nomor=0;
	
	//DEKLARASI ---------------------------------------------------------------------------
	var $fm_idplh="";
	var $fm_dokumen_sumber="";
	var $fm_nomor_bukti="";
	var $fm_tgl="";
	var $fm_cara_bayar="";
	var $fm_nama_penerima="";
	var $fm_alamat="";
	var $fm_nama_bank="";
	var $fm_norek_bank="";
	var $fm_atasnama_bank="";
	var $fm_keterangan="";
	
	var $dt_TotRek=0;
	//END DEKLARASI -----------------------------------------------------------------------
	
	function setTitle(){
		return 'PENGELUARAN KAS';
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
	  	case "Form_Rekening"				: $fm = $this->Form_Rekening(); break;
	  	case "Form_PenerimaCaraBayar"		: $fm = $this->Form_PenerimaCaraBayar(); break;
	  	case "Form_RekeningBaru"			: $fm = $this->Form_RekeningBaru(); break;
	  	case "FormRekening_Simpan"			: $fm = $this->FormRekening_Simpan(); break;
	  	case "FormRekening_Ubah"			: $fm = $this->FormRekening_Ubah(); break;
	  	case "FormRekening_Hapus"			: $fm = $this->FormRekening_Hapus(); break;
	  	case "Get_JumlahDiBayar"			: $fm = $this->Get_JumlahDiBayar(); break;
		
	  	case "Form_Potongan"				: $fm = $this->Form_Potongan(); break;
	  	case "Form_PotonganBaru"			: $fm = $this->Form_PotonganBaru(); break;
	  	case "Form_PotonganHapus"			: $fm = $this->Form_PotonganHapus(); break;
	  	case "Form_PotonganUbah"			: $fm = $this->Form_PotonganUbah(); break;
		
	  	case "SimpanSemua"					: $fm = $this->SimpanSemua(); break;
	  	case "BatalSemua"					: $fm = $this->BatalSemua(); break;
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
   
   function setPage_OtherScript(){
   		global $DataPengaturan;
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
					</script>";
		return 	
			fn_TagScript("js/skpd.js").
			fn_TagScript("js/pencarian/cariRekening.js").			
			fn_TagScript("js/pencarian/cariRekeningPajak.js").
			fn_TagScript("js/pencarian/DataPengaturan.js").
			fn_TagScript("js/keuangan/".strtolower($this->Prefix).".js").			
			$DataPengaturan->Gen_Script_DatePicker().
			$scriptload;
	}	
	
	function setPage_HeaderOther(){
		return "";	
	}
	
	function setMenuEdit(){
		return "";
	}
	
	function setMenuView(){
		return "";
	}
	
	function Cek_Validasi_Idplh($Id){
		global $DataPengaturan, $DataPengeluaranKas;
		$err = "";
		$qry = $DataPengeluaranKas->GenQueryPengeluaranKas(array(array("Id",$Id)),"");
		$dt = $qry["hasil"];
		
		if($err == "" && ($dt["Id"] == "" || $dt["Id"] == NULL))$err = Msg_Dt_TdkVld();
		
		return array("err"=>$err, "data"=>$qry);
		
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main, $DataPengaturan, $HTTP_COOKIE_VARS, $DataPengeluaranKas;
	 $thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 
	 $TblName = $DataPengeluaranKas->TblName_N;
	 
	 $dt_br = cekPOST2("databaru");
	 
	 if($dt_br == "1"){
	 	$data = 
			array(
				array("c1",cekPOST2("c1")),array("c",cekPOST2("c")),array("d",cekPOST2("d")),
				array("e",cekPOST2("e")),array("e1",cekPOST2("e1")),
				array("uid",$uid),array("tahun",$thn_anggaran),array("sttemp","1")
			);
		$qry_ins = $DataPengaturan->QryInsData($TblName,$data); $cek.=$qry_ins["cek"];		
	 }else{
	 	$Idplh = cekPOST2("idubah");
	 	$data = array(array("Id",$Idplh));
	 }
	 
	 $qry_Tmpl = $DataPengeluaranKas->GenQueryPengeluaranKas($data, "ORDER BY Id DESC");
	 $dt = $qry_Tmpl["hasil"]; $cek.=" | ".$qry_Tmpl["cek"];	 
	 
	 //DEKLARASI --------------------------------------------------------------------------------------------------
	 $c1 = $dt["c1"];
	 $c = $dt["c"];
	 $d = $dt["d"];
	 $e = $dt["e"];
	 $e1 = $dt["e1"];
	 
	 $d_dokumen_sumber = $dt_br == "2"?$dt["dokumen_sumber"]:"KWITANSI";
	 $d_nomor_bukti = $dt_br == "2"?$dt["nomor_bukti"]:"";
	 $d_tgl = $dt_br == "2"?FormatTanggalnya($dt["tanggal"]):date("d-m");
	 $d_cara_bayar = $dt_br == "2"?$dt["cara_bayar"]:"1";
	 $d_keterangan = $dt_br == "2"?$dt["keterangan"]:"";
	 //END DEKLARASI ----------------------------------------------------------------------------------------------
	 
	 //Query ------------------------------------
	 $qry_dokumen = "SELECT nama_dokumen, nama_dokumen FROM ref_dokumensumber";	 
	 
	 //Style ------------------------------------
	 $style1 = "style='width:200px;'";
	 $style2 = "style='width:40px;'";
	 $style3 = "style='width:300px;'";
	
	 $TampilOpt =
	 	InputTypeHidden($this->Prefix."_idplh", $dt["Id"]).
		$DataPengaturan->GenViewHiddenSKPD($c1, $c, $d, $e, $e1).
		$DataPengaturan->GenViewSKPD($c1, $c, $d, $e, $e1).		
		genFilterBar(array(
			$DataPengaturan->isiform(
				array(
					array(
						'label'=>'DOKUMEN SUMBER',
						'label-width'=>'200px',
						'value'=>cmbQuery("fm_dokumen_sumber", $d_dokumen_sumber, $qry_dokumen, $style1,"--- PILIH DOKUMEN SUMBER ---")							
					),
					array(
						'label'=>'NOMOR BUKTI',
						'value'=>InputTypeText("fm_nomor_bukti", $d_nomor_bukti,$style1." placeholder='NOMOR BUKTI' ")		
					),
					array(
						'label'=>'TANGGAL',
						'value'=>InputTypeText("fm_tgl", $d_tgl,$style2." class='datepicker2'").
								 InputTypeText("fm_thn", $thn_anggaran, $style2." readonly")				
					),
					array(
						'label'=>'CARA BAYAR',
						'value'=>cmbArray("fm_cara_bayar", $d_cara_bayar, $DataPengeluaranKas->arr_caraBayar,"--- CARA BAYAR ---", "style='width:97px;' onchange='".$this->Prefix.".Form_PenerimaCaraBayar()'")							
					),
				)								
			).
			LabelSPan1("Form_PenerimaCaraBayar","").
			$DataPengaturan->isiform(
				array(
					array(
						'label'=>'KETERANGAN',
						'label-width'=>'200px',
						'value'=>InputTypeTextArea("fm_keterangan", $d_keterangan, "style='width:300px;height:50px;' placeholder='KETERANGAN'")		
					),
				)								
			)
		),"","","").
		LabelSPan1("Form_Rekening","").
		LabelSPan1("Form_Potongan","").
		genFilterBar(array(
			$DataPengaturan->isiform(
				array(
					array(
						'label'=>'<b>JUMLAH YANG DIBAYAR</b>',
						'label-width'=>'200px',
						'value'=>InputTypeText("fm_jumlah_yang_dibayar","","style='text-align:right;width:200px' readonly")	
					)
				)
			)
		),"","","").
		genFilterBar(
			array(
			"<table>
				<tr>
					<td>".$DataPengaturan->buttonnya($this->Prefix.'.SimpanSemua()','checkin.png','SELESAI','SELESAI','SELESAI')."</td>
					<td>".$DataPengaturan->buttonnya($this->Prefix.'.BatalSemua()','cancel_f2.png','BATAL','BATAL','BATAL')."</td>
				</tr>".
			"</table>",				
		),'','','');
			
			
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function setPage_Content(){
		global $DataPengaturan;
		$YN = cekPOST2("YN");
		
		$dskrp = "daftar_pengeluarankasSKPDfm";
		$c1 = $YN == "1"?cekPOST2($dskrp."URUSAN",0):"";
		$c = $YN == "1"?cekPOST2($dskrp."SKPD","00"):"";
		$d = $YN == "1"?cekPOST2($dskrp."UNIT","00"):"";
		$e = $YN == "1"?cekPOST2($dskrp."SUBUNIT","00"):"";
		$e1 = $YN == "1"?cekPOST2($dskrp."SEKSI","000"):"";
		
		$Id=$_REQUEST["daftar_pengeluarankas_cb"];
		
		$data = InputTypeHidden("c1",$c1).
				InputTypeHidden("c",$c).
				InputTypeHidden("d",$d).
				InputTypeHidden("e",$e).
				InputTypeHidden("e1",$e1).
				InputTypeHidden("idubah",$Id[0]).
				InputTypeHidden("databaru",$YN);
		
		return $data.$this->genDaftarInitial();
		
	}
	
	function Form_PenerimaCaraBayar_Tunai($dt, $style3){
		return	
		array(
			array(
				'label'=>'NAMA PENERIMA',
				'label-width'=>'200px',
				'value'=>InputTypeText("fm_nama_penerima", $dt["nama_penerima"],$style3." placeholder='NAMA PENERIMA'")),
			array(
				'label'=>'ALAMAT',
				'value'=>InputTypeTextArea("fm_alamat", $dt["alamat"],"style='width:300px;height:45px;' placeholder='ALAMAT'")	),
		);
	}
	
	function Form_PenerimaCaraBayar_Bank($dt, $style3){
		return	
		array(
			array(
				'label'=>'NAMA BANK',
				'label-width'=>'200px',
				'value'=>InputTypeText("fm_nama_bank", $dt["nama_bank"],$style3." placeholder='NAMA BANK'")),
			array(
				'label'=>'NO. REKENING BANK',
				'value'=>InputTypeText("fm_norek_bank", $dt["norek_bank"],$style3." placeholder='NO. REKENING BANK'")),
			array(
				'label'=>'ATAS NAMA BANK',
				'value'=>InputTypeText("fm_atasnama_bank", $dt["atasnama_bank"],$style3." placeholder='ATAS NAMA BANK'")),
		);
	}		
	
	function Form_PenerimaCaraBayar(){
		global $DataPengaturan, $DataPengeluaranKas;
		$cek="";$err="";$content="";
		$cara_bayar = cekPOST2("fm_cara_bayar");
		$Id = cekPOST2($this->Prefix."_idplh");
		
		$qry_Tmpl = $DataPengeluaranKas->GenQueryPengeluaranKas(array(array("Id",$Id)), "ORDER BY Id DESC");
	 	$dt = $qry_Tmpl["hasil"]; $cek.=" | ".$qry_Tmpl["cek"];	 	
		
		if($err == "" && ($dt["Id"] == "" || $dt["Id"] == NULL))$err="Data Tidak Valid !";	
		if($err == ""){
			$style3 = "style='width:300px;'";
			switch ($cara_bayar){
				case "1": $data=$this->Form_PenerimaCaraBayar_Tunai($dt,$style3);break;	
				case "2": $data=$this->Form_PenerimaCaraBayar_Bank($dt, $style3);break;
			}
			
			$content = isset($data)?$DataPengaturan->isiform($data):"";	
		}	
		
				
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function Form_RekeningBersih($Id){
		global $DataPengaturan, $DataPengeluaranKas;
		$cek="";
		$DelData = cekPOST2("DelData");
		$TblName_Rek = $DataPengeluaranKas->TblName_Rek;
		if($DelData == 1){
			$qry = $DataPengaturan->QryDelData($TblName_Rek,"WHERE refid='$Id' AND status='1' AND sttemp='1' ");
			$cek.=$qry["cek"];
		}
		
		return $cek;
	}
		
	function Form_Rekening(){
		global $DataPengaturan, $DataPengeluaranKas;
		$cek="";$err="";$content="";
		
		$GetRek = cekPOST2("GetRek",1);
		
		$V_Rek = $DataPengeluaranKas->View_Rek;
		$Id = cekPOST2($this->Prefix."_idplh");
		$cek.=$this->Form_RekeningBersih($Id);
		
		$qry = "SELECT * FROM $V_Rek WHERE refid='$Id' AND status!='2' AND jns='$GetRek' ";
		$aqry = mysql_query($qry);	
		
		$datanya="";
		$no=1;
		$css_class='class="GarisDaftar"';
		$jml_harga=0;
		while($dt = mysql_fetch_assoc($aqry)){
			$row = $no%2==0?"row1":"row0";
			$nama_rekening = LabelSPan1("namaakun_".$dt["Id"], $dt["nm_rekening"]);
			$kodeRek = $DataPengaturan->Gen_valRekening($dt);
			if($dt['status'] == '1'){
				$this->Ada_Status=1;				
				$kode = 
					InputTypeText("koderek_".$dt['Id'],$kodeRek,"style='width:80px;' maxlength='12'").
					BtnImg_Cari($this->Prefix.".CariRek(".$dt['Id'].");'");				
				$btn =BtnImgSave($this->Prefix.".FormRekening_Simpan(".$dt['Id'].", $GetRek)");
				$jumlahnya = 
					InputTypeText("fm_jumlah_".$dt["Id"], $dt["jumlah"],"style='width:100%;text-align:right;' onkeypress='return DataPengaturan.isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah_".$dt['Id']."`).innerHTML = `<br>`+DataPengaturan.formatCurrency(this.value);'").
					LabelSPan1("formatjumlah_".$dt['Id'], "");
			}else{
				$kode = LabelSPan1("kd_Rek_".$dt['Id'],BtnText($kodeRek,$this->Prefix.".FormRekening_Ubah(".$dt['Id'].", $GetRek)"));
				$jumlahnya = LabelSPan1("kd_Jumlah_".$dt['Id'], FormatUang($dt["jumlah"]));
				$btn =BtnImgDelete($this->Prefix.".FormRekening_Hapus(".$dt['Id'].", $GetRek)'");					
			}
			
			$Kolom_BTN = "<td class='GarisDaftar' align='center'>".LabelSPan1("option_".$dt['Id'],$btn)."</td>";
			$datanya.="
				<tr class='$row'>".
					Tbl_Td($no, "right", $css_class).
					Tbl_Td($kode, "center", $css_class).
					Tbl_Td($nama_rekening, "left", $css_class).
					Tbl_Td($jumlahnya, "right", $css_class).
					$Kolom_BTN.
				"</tr>";
			$no = $no+1;
			$jml_harga = $jml_harga+floatval($dt['jumlah']);
		}
		
		$Btn_Atas = $this->Ada_Status == 1?BtnImgCancel($this->Prefix.".Form_Rekening($GetRek,1)"):BtnImgAdd($this->Prefix.".Form_RekeningBaru($GetRek)");
		
		$row = $no%2==0?"row1":"row0";
		$Judul = $GetRek == 1?"REKENING":"POTONGAN";
		$content= 
			genFilterBar(array(BtnText($Judul, $this->Prefix.".Form_Rekening($GetRek, 1);","style='color:black;font-size:14px;font-weight:bold;'")),'','','').
			genFilterBar(array("
				<table class='koptable' style='min-width:1024px;' border='1'>
					<tr>
						<th class='th01' width='25'>NO</th>
						<th class='th01' width='120'>REKENING</th>
						<th class='th01'>URAIAN</th>
						<th class='th01' width='150px'>JUMLAH (Rp)</th>						
						<th class='th01' width='50px'>".LabelSPan1("Btn_option",$Btn_Atas)."</th>						
					</tr>								
					$datanya
				<tr class='$row'>".
					Tbl_Td("<b>TOTAL</b>", "right", $css_class." colspan='3'").
					Tbl_Td("<b>".FormatUang($jml_harga)."</b>", "right", $css_class).
					Tbl_Td("", "right", $css_class).
				"</tr>		
				</table>"
			),'','','');
		
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);		
	}	
	
	function Form_RekeningBaru(){
		global $DataPengaturan, $DataPengeluaranKas,$HTTP_COOKIE_VARS;
		$cek="";$err="";$content="";
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		$GetRek = cekPOST2("GetRek",1);		
		$Tbl_Rek = $DataPengeluaranKas->TblName_Rek;
		
		$Idplh = cekPOST2($this->Prefix."_idplh");
		$qry = $DataPengeluaranKas->GenQueryPengeluaranKas(array(array("Id",$Idplh)),"");
		$dt = $qry["hasil"];
		
		if($err == "" && $dt["Id"] == "")$err = "Data Tidak Valid !";
		if($err == "" && $GetRek == "")$err = "Data Tidak Valid !";
		//if($err == "")$err = $Tbl_Rek;
		if($err == ""){
			$data = 
				array(
					array("jns",$GetRek),
					array("refid",$dt["Id"]),
					array("status","1"),
					array("sttemp","1"),
					array("uid",$uid),
				);
			$qry_ins = $DataPengaturan->QryInsData($Tbl_Rek, $data);
		}
		
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function FormRekening_Simpan(){
		global $DataPengaturan, $DataPengeluaranKas,$HTTP_COOKIE_VARS;
		$cek="";$err="";$content="";
		$uid = $HTTP_COOKIE_VARS['coID'];
		$Tbl_Rek = $DataPengeluaranKas->TblName_Rek;
		$GetRek = cekPOST2("GetRek",1);
		
		$Idplh = cekPOST2($this->Prefix."_idplh");
		$Idnya = cekPOST2("Idnya");
		$koderek = cekPOST2("koderek_".$Idnya);
		$fm_jumlah = cekPOST2Float("fm_jumlah_".$Idnya);
		
		if($err == "" && $GetRek == "")$err = "Data Tidak Valid !";
		$qry = $DataPengeluaranKas->GenQueryPengeluaranKas(array(array("Id",$Idplh)),"");
		$dt = $qry["hasil"];
		
		if($err == "" && $dt["Id"] == "")$err = "Data Tidak Valid !";
		if($err == ""){
			$qry_rek = $DataPengaturan->QyrTmpl1Brs($Tbl_Rek, "*", "WHERE Id='$Idnya' AND refid='".$Idplh."' ");
			$dt_rek = $qry_rek["hasil"];
			if($dt_rek["Id"] == "")$err="Data Tidak Valid !";
		}
		if($err == ""){
			$kdRek = explode(".",$koderek);
			$arrRek["k"] = $kdRek[0];
			$arrRek["l"] = $kdRek[1];
			$arrRek["m"] = $kdRek[2];
			$arrRek["n"] = $kdRek[3];
			$arrRek["o"] = $kdRek[4];
			$DataRek = $DataPengaturan->Get_valRekening($arrRek);
			if($DataRek["jml"] < 1)$err = "Rekening Tidak Valid !";
		}
		
		if($err == "" && $fm_jumlah == 0)$err="Jumlah Harga Belum di Isi !";		
		if($err == ""){
			$where = "WHERE Id='".$dt_rek["Id"]."'";
			
			$data = 
				array(
					array("k",$arrRek["k"]),array("l",$arrRek["l"]),array("m",$arrRek["m"]),
					array("n",$arrRek["n"]),array("o",$arrRek["o"]),
					array("jumlah",$fm_jumlah),
					array("status","0"),array("uid",$uid),
				);
			
			if($dt_rek["sttemp"] == "1"){
				$qry_upd = $DataPengaturan->QryUpdData($Tbl_Rek,$data, $where);
			}else{
				$qry_upd = $DataPengaturan->QryUpdData($Tbl_Rek,array(array("status",2)),$where);
				array_push($data,
					array("sttemp","1"), array("jns",$dt_rek["jns"]), array("refid",$dt_rek["refid"])
				);
				$qry_ins = $DataPengaturan->QryInsData($Tbl_Rek,$data);$cek.= $qry_ins["cek"];	
			}
			$cek.= $qry_upd["cek"];			
		}
		
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function FormRekening_Ubah(){
		global $DataPengaturan, $DataPengeluaranKas;
		$cek="";$err="";$content="";
		
		$Tbl_Rek = $DataPengeluaranKas->TblName_Rek;
		
		$Idnya = cekPOST2("Idnya");
		$GetRek = cekPOST2("GetRek",1);
		
		$qry = $DataPengaturan->QyrTmpl1Brs($Tbl_Rek, "*", "WHERE Id='$Idnya' ");
		$dt = $qry["hasil"];
		
		if($err == "" && $dt["Id"] == "")$err="Data Tidak Valid !";
		if($err == ""){
			$kodeRek = $DataPengaturan->Gen_valRekening($dt);
			$content["rekening"] =
				InputTypeText("koderek_".$dt['Id'],$kodeRek,"style='width:80px;' maxlength='12'").
				BtnImg_Cari($this->Prefix.".CariRek(".$dt['Id'].");'");				
			$content["jumlah"] = 
				InputTypeText("fm_jumlah_".$dt["Id"], $dt["jumlah"],"style='width:100%;text-align:right;' onkeypress='return DataPengaturan.isNumberKey(event)' onkeyup='document.getElementById(`formatjumlah_".$dt['Id']."`).innerHTML = `<br>`+DataPengaturan.formatCurrency(this.value);'").
				LabelSPan1("formatjumlah_".$dt['Id'], "");
			$content["option"] = BtnImgSave($this->Prefix.".FormRekening_Simpan(".$dt['Id'].", $GetRek)");
		}
		
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function FormRekening_Hapus(){
		global $DataPengaturan, $DataPengeluaranKas;
		$cek="";$err="";$content="";
		$Tbl_Rek = $DataPengeluaranKas->TblName_Rek;
		$Idplh = cekPOST2($this->Prefix."_idplh");
		$Idnya = cekPOST2("Idnya");
		
		$qry_upd = $DataPengaturan->QryUpdData($Tbl_Rek, array(array("status","2")), "WHERE Id='$Idnya' AND refid='$Idplh' ");
		
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function Get_JumlahDiBayar(){
		global $DataPengaturan, $DataPengeluaranKas;
		$cek="";$err="";$content="";
		$Tbl_Rek = $DataPengeluaranKas->TblName_Rek;
		$v_pot = $DataPengeluaranKas->View_Pot;
		$Idplh = cekPOST2($this->Prefix."_idplh");
		
		$field = "IFNULL(SUM(jumlah),0) as jumlah";
		$where = "WHERE refid='$Idplh' AND status='0' ";
		
		$qry_TotRek = $DataPengaturan->QyrTmpl1Brs($Tbl_Rek, $field, $where." AND jns='1' ");
		$dt_Tot = $qry_TotRek["hasil"];
		
		$qry_TotPot = $DataPengaturan->QyrTmpl1Brs($v_pot, $field, $where);
		$dt_Pot = $qry_TotPot["hasil"];
		
		$total = $dt_Tot["jumlah"]-$dt_Pot["jumlah"];
		$content = FormatUang($total);
		
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function Form_Potongan(){
		global $DataPengaturan, $DataPengeluaranKas;
		$cek="";$err="";$content="";$datanya="";
		$css_class='class="GarisDaftar"';
		$Idplh = cekPOST2($this->Prefix."_idplh");
		$v_pot = $DataPengeluaranKas->View_Pot;
		$no = 1;
		$qry = "SELECT * FROM $v_pot WHERE refid='$Idplh' AND status != '2' ";
		$aqry = mysql_query($qry);
		$jml_harga=0;
		while($dt = mysql_fetch_assoc($aqry)){
			$kodeRek = $DataPengaturan->Gen_valRekening($dt);
			$row = $no%2==0?"row1":"row0";
			$harga = BtnText(FormatUang($dt["jumlah"]), $this->Prefix.".Form_PotonganUbah(".$dt["Id"].")");
			$datanya .= "<tr class='$row'>".
				Tbl_Td($no,"right",$css_class).
				Tbl_Td($kodeRek,"center",$css_class).
				Tbl_Td($dt["nm_rekening"]."/ ".$dt["nama_potongan"]."/ ".$dt["persen"]."%","left",$css_class).
				Tbl_Td($harga,"right",$css_class).
				Tbl_Td(BtnImgDelete($this->Prefix.".Form_PotonganHapus(".$dt['Id'].")'"),"center",$css_class)."</tr>";
				
			$no++;
			$jml_harga+=$dt["jumlah"];
		}
		
		$Btn_Atas = BtnImgAdd($this->Prefix.".CariPotongan()");
		$row = $no%2==0?"row1":"row0";
		$content= 
			InputTypeHidden("Set_IdPotonganIns","").
			genFilterBar(array(BtnText("POTONGAN", $this->Prefix.".Form_Potongan();","style='color:black;font-size:14px;font-weight:bold;'")),'','','').
			genFilterBar(array("
				<table class='koptable' style='min-width:1024px;' border='1'>
					<tr>
						<th class='th01' width='25'>NO</th>
						<th class='th01' width='120'>REKENING</th>
						<th class='th01'>URAIAN</th>
						<th class='th01' width='150px'>JUMLAH (Rp)</th>						
						<th class='th01' width='50px'>".LabelSPan1("Btn_option",$Btn_Atas)."</th>						
					</tr>								
					$datanya
				<tr class='$row'>".
					Tbl_Td("<b>TOTAL</b>", "right", $css_class." colspan='3'").
					Tbl_Td("<b>".FormatUang($jml_harga)."</b>", "right", $css_class).
					Tbl_Td("", "right", $css_class).
				"</tr>		
				</table>"
			),'','','');
		
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function Form_PotonganBaru(){
		global $DataPengaturan, $DataPengeluaranKas, $HTTP_COOKIE_VARS;
		$cek="";$err="";$content="";
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		$ref_pot = $DataPengeluaranKas->View_RefPotongan;
		$tbl_pot = $DataPengeluaranKas->TblName_Pot;
		
		$refid_pot = cekPOST2("Set_IdPotonganIns");
		$Idplh = cekPOST2($this->Prefix."_idplh");
		
		$data = $this->Cek_Validasi_Idplh($Idplh);
		
		$err = $data["err"];
		if($err == "" && $refid_pot == "")$err = Msg_Dt_TdkVld();
		if($err == ""){
			$qry_pot = $DataPengaturan->QyrTmpl1Brs($ref_pot,"*", "WHERE Id='$refid_pot'");$cek.=$qry_pot["cek"];
			$dt_pot = $qry_pot["hasil"];
			if($dt_pot["Id"] == "" || $dt_pot["Id"] == NULL)$err=Msg_Dt_TdkVld();
		}
		if($err == ""){
			$qry_rek = $DataPengeluaranKas->GenTotalRekening("WHERE refid='$Idplh' AND status='0' ");
			$dt_rek = $qry_rek["hasil"];
			if($dt_rek["jumlah"] == 0)$err="Belum Ada Rekening. Silahkan Isi Terlebih Dahulu !";
		}
		if($err == ""){
			$qry_rek = $DataPengeluaranKas->GenTotalRekening("WHERE refid='$Idplh' AND status='0' ");
			$dt_rek = $qry_rek["hasil"];
			
			$jumlah_pot = $dt_rek["jumlah"]*(floatval($dt_pot["persen"])/100);
			
			$data_ins = 
				array(
					array("jumlah",$jumlah_pot),
					array("status","0"),
					array("sttemp","1"),
					array("refid",$Idplh),
					array("uid",$uid),
					array("refid_potongan_spm",$dt_pot["Id"]),
				);
			$qry_ins = $DataPengaturan->QryInsData($tbl_pot,$data_ins);$cek.=$qry_ins["cek"];
		}						
		
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function Form_PotonganHapus(){
		global $DataPengaturan, $DataPengeluaranKas;
		$cek="";$err="";$content="";
		$tbl_pot = $DataPengeluaranKas->TblName_Pot;
		
		$Idplh = cekPOST2($this->Prefix."_idplh");
		$Idnya = cekPOST2("Idnya");
		
		$qry_upd = $DataPengaturan->QryUpdData($tbl_pot, array(array("status","2")), "WHERE Id='$Idnya' AND refid='$Idplh' ");
		$cek.=$qry_upd["cek"];
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function Form_PotonganUbah(){
		global $DataPengaturan, $DataPengeluaranKas, $HTTP_COOKIE_VARS;
		$cek="";$err="";$content="";
		$uid = $HTTP_COOKIE_VARS['coID'];
		$tbl_pot = $DataPengeluaranKas->TblName_Pot;
		$V_pot = $DataPengeluaranKas->View_Pot;
		
		$Idplh = cekPOST2($this->Prefix."_idplh");
		$Idnya = cekPOST2("Idnya");
		
		$wherePot = "WHERE Id='$Idnya' AND refid='$Idplh'";
		
		$qry = $DataPengaturan->QyrTmpl1Brs($V_pot, "*", $wherePot);
		$dt = $qry["hasil"];		
		if($err == "" && ($dt["Id"] == "" || $dt["Id"] == NULL))$err=Msg_Dt_TdkVld();
		if($err == ""){
			$qry_rek = $DataPengeluaranKas->GenTotalRekening("WHERE refid='$Idplh' AND status='0' ");
			$dt_rek = $qry_rek["hasil"];
			if($dt_rek["jumlah"] == 0)$err="Belum Ada Rekening. Silahkan Isi Terlebih Dahulu !";
		}
		
		if($err == ""){
			$jumlah_baru = $dt_rek["jumlah"] * (floatval($dt["persen"])/100);$cek.=floatval($dt["persen"]);
			$data_upd = array(array("jumlah",$jumlah_baru));
			if($dt["sttemp"] == 0){
				$data_ins = $data_upd;
				array_push($data_ins,
					array("status",0),
					array("sttemp",1),
					array("refid",$Idplh),
					array("uid",$uid),
					array("refid_potongan_spm",$dt["refid_potongan_spm"])
				);
				$qry_ins = $DataPengaturan->QryInsData($tbl_pot, $data_ins);
				$data_upd = array(array("status","2"));
			}			
			$qry_upd = $DataPengaturan->QryUpdData($tbl_pot, $data_upd, $wherePot);$cek.=$qry_upd["cek"];
		}
		
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function Set_DataPotongan(){
		global $DataPengaturan, $DataPengeluaranKas;
		$cek="";
		$view_pot = $DataPengeluaranKas->View_Pot;
		$tbl_pot = $DataPengeluaranKas->TblName_Pot;
		$qry = "SELECT * FROM $view_pot WHERE refid='$this->fm_idplh' AND status='0' ";
		$aqry = mysql_query($qry);
		while($dt = mysql_fetch_assoc($aqry)){
			$hrg_baru = $this->dt_TotRek * (floatval($dt["persen"])/100);
			$data_upd = array(array("jumlah",$hrg_baru),array("sttemp","0"));
			$qry_upd = $DataPengaturan->QryUpdData($tbl_pot, $data_upd, "WHERE Id='".$dt["Id"]."'"); $cek.=$qry_upd["cek"];
		}
		
		return $cek;
	}
	
	function SimpanSemua_Validasi($dt){
		global $DataPengaturan, $DataPengeluaranKas;
		$err='';
		
		if($err == "" && $this->fm_dokumen_sumber == "")$err="Dokumen Sumber Belum di Pilih !";
		if($err == "" && $this->fm_nomor_bukti == "")$err="Nomor Bukti Belum di Isi !";
		if($err == "" && !cektanggal($this->fm_tgl))$err="Tanggal Tidak Valid !";
		if($err == "" && $this->fm_cara_bayar == "")$err="Cara Bayar Belum di Pilih !";
		if($err == "" && $this->fm_cara_bayar == "1" && $this->fm_nama_penerima == "")$err="Nama Penerima Belum di Isi !";
		if($err == "" && $this->fm_cara_bayar == "2" && $this->fm_nama_bank == "")$err="Nama Bank Belum di Isi !";
		if($err == "" && $this->fm_cara_bayar == "2" && $this->fm_norek_bank == "")$err="Nomor Rekening Bank Belum di Isi !";
		if($err == "" && $this->fm_cara_bayar == "2" && $this->fm_atasnama_bank == "")$err="Atas Nama Bank Belum di Isi !";
		//Hitung Rekening
		if($err == ""){
			$qry_rek = $DataPengeluaranKas->GenTotalRekening("WHERE refid='".$dt["Id"]."' AND status='0' ");
			$dt_rek = $qry_rek["hasil"];			
			if($dt_rek["jumlah"] <= 0)$err="Belum Ada Rekening. Silahkan Isi Terlebih Dahulu !".$qry_rek["cek"];
			$this->dt_TotRek = $dt_rek["jumlah"];
		}
		
		
		return $err;
	}
	
	function SimpanSemua_After(){
		global $DataPengaturan, $DataPengeluaranKas, $HTTP_COOKIE_VARS;
		$cek="";
		$tbl_rek = $DataPengeluaranKas->TblName_Rek;
		
		$where = "WHERE refid='$this->fm_idplh' ";
		$where_upd = $where." AND status ='0' ";
		$where_del = $where." AND status!='0' ";
		//Hapus Rekening
		$qryDel_Rek = $DataPengaturan->QryDelData($tbl_rek, $where_del);
		//Hapus Potongan
		$qryDel_Pot = $DataPengaturan->QryDelData($DataPengeluaranKas->TblName_Pot, $where_del);
		//Update Potongan
		$cek.=$this->Set_DataPotongan();
		//Update Rekening
		$qryUpd_Rek = $DataPengaturan->QryUpdData($tbl_rek, array(array("sttemp",0)), $where_upd);
		
		return $cek;
	}
	
	function SimpanSemua(){
		global $DataPengaturan, $DataPengeluaranKas, $HTTP_COOKIE_VARS;
		$cek="";$err="";$content="";
		$uid = $HTTP_COOKIE_VARS['coID'];
		$thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
				
		$this->fm_idplh=cekPOST2($this->Prefix."_idplh");
		
		$this->fm_dokumen_sumber=cekPOST2("fm_dokumen_sumber");
		$this->fm_nomor_bukti=cekPOST2("fm_nomor_bukti");
		$this->fm_tgl=FormatTanggalnya(cekPOST2("fm_tgl")."-".$thn_anggaran);
		$this->fm_cara_bayar=cekPOST2("fm_cara_bayar");
		
		$this->fm_nama_penerima=cekPOST2("fm_nama_penerima");
		$this->fm_alamat=cekPOST2("fm_alamat");
		
		$this->fm_nama_bank=cekPOST2("fm_nama_bank");
		$this->fm_norek_bank=cekPOST2("fm_norek_bank");
		$this->fm_atasnama_bank=cekPOST2("fm_atasnama_bank");
		$this->fm_keterangan=cekPOST2("fm_keterangan");
		
		$GetData = $this->Cek_Validasi_Idplh($this->fm_idplh);
		$err = $GetData["err"];
		$qry = $GetData["data"];
		$dt = $qry["hasil"];
		
		if($err == "")$err = $this->SimpanSemua_Validasi($dt);
		if($err == ""){			
			$data_upd =
				array(
					array("dokumen_sumber", $this->fm_dokumen_sumber),
					array("nomor_bukti", $this->fm_nomor_bukti),
					array("tanggal", $this->fm_tgl),
					array("cara_bayar", $this->fm_cara_bayar),
					array("nama_penerima", $this->fm_nama_penerima),
					array("alamat", $this->fm_alamat),
					array("nama_bank", $this->fm_nama_bank),
					array("norek_bank", $this->fm_norek_bank),
					array("atasnama_bank", $this->fm_atasnama_bank),
					array("keterangan", $this->fm_keterangan),
					array("sttemp", "0"),
				);
			$qry_upd = $DataPengaturan->QryUpdData($DataPengeluaranKas->TblName_N, $data_upd, "WHERE Id='$this->fm_idplh'");
			$cek.=$qry_upd["cek"];
			
			$cek.=$this->SimpanSemua_After();
		}
		
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function BatalSemua(){
		global $DataPengaturan, $DataPengeluaranKas, $HTTP_COOKIE_VARS;
		$cek="";$err="";$content="";
		
		$Tbl = $DataPengeluaranKas->TblName_N;
		$Tbl_Rek = $DataPengeluaranKas->TblName_Rek;
		$Tbl_Pot = $DataPengeluaranKas->TblName_Pot;
		
		$this->fm_idplh=cekPOST2($this->Prefix."_idplh");
		$Get = $this->Cek_Validasi_Idplh($this->fm_idplh);
		
		$err = $Get["err"];
		$qry = $Get["data"];
		$dt = $qry["hasil"];
		if($err == ""){
			if($dt["sttemp"] == "1"){
				$qryDel = $DataPengaturan->QryDelData($Tbl, "WHERE Id='".$dt["Id"]."' ");
			}else{
				//Hapus Data
				$where_del = "WHERE sttemp!='0' AND refid='".$dt["Id"]."' ";
				$qryDelRek = $DataPengaturan->QryDelData($Tbl_Rek, $where_del);
				$qryDelPot = $DataPengaturan->QryDelData($Tbl_Pot, $where_del);
				//Update Data
				$where_upd = "WHERE sttemp ='0' AND refid='".$dt["Id"]."' ";
				$val = array(array("status","0"));
				$qryUpdRek = $DataPengaturan->QryUpdData($Tbl_Rek, $val, $where_upd);
				$qryUpdPot = $DataPengaturan->QryUpdData($Tbl_Pot, $val, $where_upd);
			}
		}
		
		
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
}
$form_pengeluarankas = new form_pengeluarankasObj();
?>