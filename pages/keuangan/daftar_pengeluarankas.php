<?php
	include "pages/pencarian/DataPengaturan.php";
	$DataOption = $DataPengaturan->DataOption();
	
class daftar_pengeluarankasObj  extends DaftarObj2{	
	var $Prefix = 'daftar_pengeluarankas';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_pengeluaran_kas'; //bonus
	var $TblName_Hapus = 't_pengeluaran_kas';
	
	//Tabel Modul	
	var $TblName_N = 't_pengeluaran_kas';
	var $TblName_Rek = 't_pengeluaran_kas_rek';
	var $TblName_Pot = 't_pengeluaran_kas_pot';
	
	//View Modul
	var $View_N = 'v1_pengeluaran_kas_total_semua';
	var $View_Rek = 'v1_pengeluaran_kas_rek';
	var $View_Pot = 'v1_pengeluaran_kas_pot';
	var $View_TotalRek = 'v1_pengeluaran_kas_total_rek';
	var $View_TotalPot = 'v1_pengeluaran_kas_total_pot';
	
	//View Refrensi
	var $View_RefPotongan = "v1_ref_potongan_spm_rek";	
	
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
	var $Cetak_Judul = 'DAFTAR PENGELUARAN KAS';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'daftar_pengeluarankasForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	var $pid_urutan=1;
	var $pid_nomor=0;
	
	var $Total_Rek = 0;
	var $Total_Pot = 0;
	
	var $SubTotal_Rek = 0;
	var $SubTotal_Pot = 0;
	
	var $arr_caraBayar2 = array("1"=>"TUNAI","2"=>"BANK");
	var $arr_caraBayar = array(array("1","TUNAI"),array("2","BANK"));
	
	function setTitle(){
		return 'DAFTAR PENGELUARAN KAS';
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
	  	case "formBaru"		: $fm=$this->formBaru();break;  
	  	case "formEdit"		: $fm=$this->formEdit();break;  
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
			fn_TagScript("js/pencarian/DataPengaturan.js").
			fn_TagScript("js/keuangan/".strtolower($this->Prefix).".js").
			$DataPengaturan->Gen_Script_DatePicker().
			$scriptload;
	}
	
	
	
	function setPage_HeaderOther(){
		return "";	
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $this->BersihkanData();
	 $headerTable =
	  "<thead>
	   <tr>
	   		<th class='th01' width='5' >NO</th>
			$Checkbox
			<th class='th01' width='80'>TANGGAL</th>
			<th class='th01' width='180'>NOMOR</th>
		    <th class='th01'>URAIAN</th>
		    <th class='th01' width='120'>JUMLAH</th>
		    <th class='th01' width='120'>POTONGAN</th>
		    <th class='th01' width='120'>TOTAL BAYAR</th>
	   </tr>
	 
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass){
		$Koloms="";
		
		$Koloms.=$this->pid_urutan%2==0?"<tr class='row1'>":"<tr class='row0'>";
		$Koloms.=$this->pid_nomor==0?Tbl_Td($no,"right",$cssclass):Tbl_Td("","right",$cssclass);			
		if($Mode == 1)$Koloms.=$this->pid_nomor==0?Tbl_Td($TampilCheckBox,"center",$cssclass):Tbl_Td("","right",$cssclass);			
		return $Koloms;
	}
	
	function setKolomDataRekening($no, $isi, $Mode, $TampilCheckBox, $cssclass){
		global $DataPengaturan;
		$Koloms="";
		$this->pid_nomor=1;
		$qry = "SELECT * FROM $this->View_Rek WHERE refid='".$isi["Id"]."' AND sttemp='0' ";
		$aqry = mysql_query($qry);
		$i=0;
		while($dt = mysql_fetch_assoc($aqry)){
		     $KdRek = $DataPengaturan->Gen_valRekening($dt);
			 $Koloms.=$this->setKolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass);
			 $nomor_srt = $i == 0?$isi["nomor_bukti"]:"";
			 $Koloms.= Tbl_Td("", "left", $cssclass);
			 $Koloms.= Tbl_Td($nomor_srt, "left", $cssclass);
			 $Koloms.= Tbl_Td($KdRek.". ".$dt["nm_rekening"], "left", $cssclass);
			 $Koloms.= Tbl_Td(FormatUang($dt["jumlah"]), "right", $cssclass);
			 $Koloms.= Tbl_Td("", "right", $cssclass, 2)."</tr>";
			 $this->pid_urutan++;
			 $i++;
			 $this->SubTotal_Rek+=$dt["jumlah"];
		}
			
		return $Koloms;
	}
	
	function setKolomDataPotongan($no, $isi, $Mode, $TampilCheckBox, $cssclass){
		global $DataPengaturan;
		$Koloms="";
		$qry = "SELECT * FROM $this->View_Pot WHERE refid='".$isi["Id"]."' AND sttemp='0' ";
		$aqry = mysql_query($qry);
		while($dt = mysql_fetch_assoc($aqry)){
			 $KdRek = $DataPengaturan->Gen_valRekening($dt);
			 $Koloms.=$this->setKolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass);
			 $Koloms.= Tbl_Td("", "left", $cssclass,2);
			 $Koloms.= Tbl_Td(LabelDiv1("style='margin-left:15px;'", $KdRek.". ".$dt["nm_rekening"]), "left", $cssclass);
			 $Koloms.= Tbl_Td("", "right", $cssclass);
			 $Koloms.= Tbl_Td(FormatUang($dt["jumlah"]), "right", $cssclass);
			 $Koloms.= Tbl_Td("", "right", $cssclass)."</tr>";
			 $this->pid_urutan++;
			 $this->SubTotal_Pot+=$dt["jumlah"];
		}
			
		return $Koloms;
	}
	
	function setKolomDataSubTotal($no, $isi, $Mode, $TampilCheckBox, $cssclass){
		global $DataPengaturan;
		$Koloms="";
		
		$TotalBayar = $this->SubTotal_Rek - $this->SubTotal_Pot;
		
		$Koloms.=$this->setKolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass);
		$Koloms.= Tbl_Td("<b>SUB TOTAL</b>", "right", $cssclass." colspan='3'");
		$Koloms.= Tbl_Td("<b>".FormatUang($this->SubTotal_Rek)."</b>", "right", $cssclass);
		$Koloms.= Tbl_Td("<b>".FormatUang($this->SubTotal_Pot)."</b>", "right", $cssclass);
		$Koloms.= Tbl_Td("<b>".FormatUang($TotalBayar)."</b>", "right", $cssclass);
		$this->pid_urutan++;
			
		return $Koloms;
	}
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 $Koloms="";
	 $this->pid_nomor=0;
	 $this->SubTotal_Rek=0;
	 $this->SubTotal_Pot=0;
	 $cssclass = $Mode == 1?'class="GarisDaftar"':'class="GarisCetak"';	 
	 $uraian = $isi["cara_bayar"] == 2?$isi["nama_bank"]."/ ".$isi["atasnama_bank"]:$isi["nama_penerima"]."/ ".$isi["alamat"];
	 
	 $Koloms.=$this->setKolomData_KolomNomor($no, $isi, $Mode, $TampilCheckBox, $cssclass);	 
	 $Koloms.=
	 	Tbl_Td(FormatTanggalnya($isi["tanggal"]),"center",$cssclass).
	 	Tbl_Td($isi["dokumen_sumber"],"left",$cssclass).
	 	Tbl_Td($this->arr_caraBayar2[$isi["cara_bayar"]]." ".$uraian."/ ".$isi["keterangan"],"left",$cssclass).
	 	Tbl_Td("","right",$cssclass).
	 	Tbl_Td("","right",$cssclass).
	 	Tbl_Td("","right",$cssclass)."</tr>";
	 $this->pid_urutan++;
	 $Koloms.=$this->setKolomDataRekening($no, $isi, $Mode, $TampilCheckBox, $cssclass);
	 $Koloms.=$this->setKolomDataPotongan($no, $isi, $Mode, $TampilCheckBox, $cssclass);
	 $Koloms.=$this->setKolomDataSubTotal($no, $isi, $Mode, $TampilCheckBox, $cssclass);
	 
	 $this->Total_Rek+=$this->SubTotal_Rek;
	 $this->Total_Pot+=$this->SubTotal_Pot;
	 
	 $Koloms = array(
	 	array("Y", $Koloms),
	 );
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main, $HTTP_COOKIE_VARS;
	 
	 $thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
	 $arr_cari = 
	 	array(
			array('1','URAIAN'),		
			array('2','KODE REKENING'),		
			array('3','NAMA REKENING'),		
			array('4','KODE POTONGAN'),		
			array('5','NAMA POTONGAN'),		
			array('6','NOMOR BUKTI'),		
		);
		
	 //data order ------------------------------
	 $arrOrder = 
	 	array(
	     	array('1','TANGGAL'),
	     	array('2','NOMOR BUKTI'),
		);
	
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	
	$fmBIDANG = cekPOST('fmBIDANG');
	$fmKELOMPOK = cekPOST('fmKELOMPOK');
	$fmSUBKELOMPOK = cekPOST('fmSUBKELOMPOK');
	$fmSUBSUBKELOMPOK = cekPOST('fmSUBSUBKELOMPOK');
	$fmKODE = cekPOST('fmKODE');
	$fmBARANG = cekPOST('fmBARANG');
	
	$DataSKPD = WilSKPD_ajx3($this->Prefix.'SKPD');
	
	$qry_doksum = "SELECT nama_dokumen, nama_dokumen FROM ref_dokumensumber ";
	
	//Style --------------------------
	$style1= "style='width:200px;'";
	$style2= "style='width:40px;' class='datepicker2' ";
	$style3= "style='width:150px;'";
	
	$ceked= isset($_REQUEST["fmDESC1"])?"checked='checked'":"";
	
	$TampilOpt =
		genFilterBar(array($DataSKPD),"","","").
		genFilterBar(
			array(
				cmbArray("fm_pil_cari", cekPOST2("fm_pil_cari"), $arr_cari, "--- CARI BERDASARKAN ---", $style1),
				InputTypeText("fm_cari", cekPOST2("fm_cari"),"style='width:400px;' placeholder='PENCARIAN'"),
				InputTypeButton("btn_cari", "CARI", "onclick='".$this->Prefix.".refreshList(true);'")
			)
		,"","","").
		genFilterBar(
			array(
				cmbQuery("fm_doksum", cekPOST2("fm_doksum"), $qry_doksum,$style1,"--- DOKUMEN SUMBER ---"),
				cmbArray("fm_cara_bayar", cekPOST2("fm_cara_bayar"), $this->arr_caraBayar, "--- CARA BAYAR ---", $style3),
				InputTypeText("fm_tgl_dari", cekPOST2("fm_tgl_dari","01-01"), $style2)." s/d ".
				InputTypeText("fm_tgl_sampai", cekPOST2("fm_tgl_sampai","31-12"), $style2)." ".
				InputTypeText("fm_thn_anggaran", $thn_anggaran, "style='width:40px;' readonly")
			)
		,"","","").
		genFilterBar(
			array(
				cmbArray("fm_order", cekPOST2("fm_order"), $arrOrder, "--- URUTKAN BERDASARKAN ---", $style1)." ".
				InputTypeCheckbox("fmDESC1","ok", $ceked)." Menurun.",
				InputTypeButton("btn_cari", "TAMPILKAN", "onclick='".$this->Prefix.".refreshList(true);'")
			)
		,"","","");
			
			
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function getDaftarOpsi_PilOpt($tbl, $field, $isi){
		return "Id IN (SELECT refid FROM $tbl WHERE $field LIKE '%$isi%')";
	}		
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$UID = $_COOKIE['coID']; 
		$v_rek = $this->View_Rek;
		$v_pot = $this->View_Pot;
		
		$concatRek = "concat(k,'.',l,'.',m,'.',n,'.',o)";
		
		//kondisi -----------------------------------				
		$arrKondisi = array();		
		
		$fm_pil_cari = cekPOST2("fm_pil_cari");
		$fm_cari = cekPOST2("fm_cari");
		$fm_doksum = cekPOST2("fm_doksum");
		$fm_cara_bayar = cekPOST2("fm_cara_bayar");
		$fm_tgl_dari = FormatTanggalnya(cekPOST2("fm_tgl_dari","01-31")."-".$thn_anggaran);
		$fm_tgl_sampai = FormatTanggalnya(cekPOST2("fm_tgl_sampai","01-31")."-".$thn_anggaran);
		$fm_thn_anggaran = cekPOST2("fm_thn_anggaran");
		$fm_order = cekPOST2("fm_order");
		$fmDESC1 = cekPOST2("fmDESC1");
				
		$c1 = $_COOKIE['cofmURUSAN'];
		$c = $_COOKIE['cofmSKPD'];
		$d = $_COOKIE['cofmUNIT'];
		$e = $_COOKIE['cofmSUBUNIT'];
		$e1 = $_COOKIE['cofmSEKSI'];
		
		
		if($c1	!="0"	)$arrKondisi[] = " c1 = '$c1'";
		if($c	!="00"	)$arrKondisi[] = " c = '$c'";
		if($d	!="00"	)$arrKondisi[] = " d = '$d'";
		if($e	!="00"	)$arrKondisi[] = " e = '$e'";
		if($e1	!="000"	)$arrKondisi[] = " e1 = '$e1'";
		
		if($fm_pil_cari != "" && $fm_cari != ""){
			switch($fm_pil_cari){
				case "1":
					$arrKondisi[] = " IF(cara_bayar=1,concat(nama_penerima,'/ ', alamat, '/ ', keterangan), concat(nama_bank,'/ ', atasnama_bank, '/ ', keterangan)) LIKE '%$fm_cari%'";
				break;
				case "2":$arrKondisi[] = $this->getDaftarOpsi_PilOpt($v_rek,$concatRek,$fm_cari);break;
				case "3":$arrKondisi[] = $this->getDaftarOpsi_PilOpt($v_rek,"nm_rekening",$fm_cari);break;
				case "4":$arrKondisi[] = $this->getDaftarOpsi_PilOpt($v_pot,$concatRek,$fm_cari);break;
				case "5":$arrKondisi[] = $this->getDaftarOpsi_PilOpt($v_pot,"nm_rekening",$fm_cari);break;
				case "6":$arrKondisi[] = "nomor_bukti LIKE '%$fm_cari%'";break;
			}
		}
		
		if($fm_doksum != "")$arrKondisi[] = " dokumen_sumber = '$fm_doksum'";
		if($fm_cara_bayar != "")$arrKondisi[] = " cara_bayar = '$fm_cara_bayar'";
		if(cektanggal($fm_tgl_dari))$arrKondisi[] = " tanggal >= '$fm_tgl_dari'";
		if(cektanggal($fm_tgl_sampai))$arrKondisi[] = " tanggal <= '$fm_tgl_sampai'";
		
		$arrKondisi[] = " sttemp = '0'";
		$arrKondisi[] = " tahun = '$thn_anggaran'";
			
		
		//$arrKondisi[] = " q='00'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		switch($fm_order){
			case '1': $arrOrders[] = " tanggal $Asc1 " ;break;
			case '2': $arrOrders[] = " nomor_bukti $Asc1 " ;break;
			default : $arrOrders[] = " Id DESC " ;break;
		}
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//$Order ="";
		//limit --------------------------------------
		/**$HalDefault=cekPOST($this->Prefix.'_hal',1);	//Cat:Settingan Lama				
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		**/
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
	
	function formBaru(){
		global $DataPengaturan, $DataOption;
		$cek="";$err="";$content="";
				
		if($err == "")$err = $DataPengaturan->Validasi_SKPD($this->Prefix, $err);
		
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function GenQueryPengeluaranKas($where, $order){
		global $DataPengaturan;
		
		$qry_Tmpl = $DataPengaturan->QyrTmpl1Brs2($this->TblName_N,"*",$where,$order);
		
		return $qry_Tmpl;
	}
	
	function GenTotalRekening($where){
		global $DataPengaturan;
		
		$qry = $DataPengaturan->QyrTmpl1Brs($this->TblName_Rek, "IFNULL(SUM(jumlah),0) as jumlah", $where);
		
		return $qry;
	}
	
	function GenTotalPotongan($where){
		global $DataPengaturan;
		
		$qry = $DataPengaturan->QyrTmpl1Brs($this->View_Pot, "IFNULL(SUM(jumlah),0) as jumlah", $where);
		
		return $qry;
	}
	
	function BersihkanData(){
		global $DataPengaturan;	
		$tbl_rek = $this->TblName_Rek;	
		$tbl_pot = $this->TblName_Pot;	
		
		$where_del = "WHERE sttemp!='0' AND tgl_update < DATE_SUB(NOW(), INTERVAL 4 HOUR)";
		$where_upd = "WHERE sttemp='0' AND status != '0'  AND tgl_update < DATE_SUB(NOW(), INTERVAL 4 HOUR)";
		
		$val = array(array("status","0"));
		
		$qryDel = $DataPengaturan->QryDelData($this->TblName_N, "WHERE sttemp='1' AND tgl_update < DATE_SUB(NOW(), INTERVAL 2 DAY)");		
		
		$qryDelRek = $DataPengaturan->QryDelData($tbl_rek, $where_del);
		$qryDelPot = $DataPengaturan->QryDelData($tbl_pot, $where_del);
		
		$qryUpdRek = $DataPengaturan->QryUpdData($tbl_rek,$val, $where_upd);
		$qryUpdPot = $DataPengaturan->QryUpdData($tbl_pot,$val, $where_upd);
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
		
		$ListData .= 
				//$ContentTotalHal.$ContentTotal.
				$this->GrandTotal($Mode,$tuk_Kondisi).
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
	
	function GrandTotal_Data($Label="TOTAL PER HALAMAN",$cols="", $cssclass="", $TotRek=0, $TotPot=0, $Jumlah=0){
		$Koloms="";
		
		$Koloms.=$this->pid_urutan%2==0?"<tr class='row1'>":"<tr class='row0'>";
		$Koloms.=
			Tbl_Td("<b>$Label</b>","center",$cssclass." colspan='$cols'").
			Tbl_Td("<b>".FormatUang($TotRek)."</b>","right",$cssclass);
			$Koloms.=Tbl_Td("<b>".FormatUang($TotPot)."</b>","right",$cssclass);
			$Koloms.=Tbl_Td("<b>".FormatUang($Jumlah)."</b>","right",$cssclass);
		
		return $Koloms;
	}
	
	function GrandTotal_Semua(){
		global $DataPengaturan;
		
		$Tbl = $this->View_N;
		
		$get = $this->getDaftarOpsi();
		$kondisi = $get["Kondisi"];
		$order = $get["Order"];
		
		$qry = $DataPengaturan->QyrTmpl1Brs($Tbl, "IFNULL(SUM(total_rek),0) as jml_rek, IFNULL(SUM(total_pot),0) as jml_pot", $kondisi." ".$order);
		$dt = $qry["hasil"];
		
		$dt["total"] = $dt["jml_rek"]-$dt["jml_pot"];
		
		return $dt;
		
	}
		
	function GrandTotal($Mode=1,$tuk_Kondisi=''){
		global $DataPengaturan;
		$Koloms='';
		
		$jumlah = $this->Total_Rek - $this->Total_Pot;
		
		$cols 	  =	$Mode == 1?5:4;	
		$cssclass = $Mode == 1?'class="GarisDaftar"':'class="GarisCetak"';
		//TOTAL PERHALAMAN ---------------------------------------------------------------------------------
		$Koloms.=$this->GrandTotal_Data("TOTAL PER HALAMAN",$cols, $cssclass,$this->Total_Rek, $this->Total_Pot, $jumlah);
		$this->pid_urutan++;
		
		//TOTAL SEMUA ---------------------------------------------------------------------------------
		$Harga= $this->GrandTotal_Semua();
		$Koloms.=$this->GrandTotal_Data("TOTAL",$cols, $cssclass,$Harga["jml_rek"],$Harga["jml_pot"],$Harga["total"]);
		$this->pid_urutan++;
		
		return $Koloms;
	}
	
	function ValidasiPengeluaranKas($idplh, $tanya="Ubah"){
		$errmsg = "";
		
		$data_where= array(array("Id",$idplh),array("sttemp","0"));
		$qry = $this->GenQueryPengeluaranKas($data_where,"");
		$dt = $qry["hasil"];
		
		if($dt["Id"] == "" && $errmsg == "")$errmsg="Data Tidak Valid ! ";
		if($dt["status"] != "0" && $errmsg == "")$errmsg="Data Pengeluaran KAS Dengan Nomor Bukti ".$dt["dokumen_sumber"]." ".$dt["nomor_bukti"]." Tidak Bisa di $tanya, Status Sudah Berubah !";
		
		return array("errmsg"=>$errmsg, "dt"=>$dt);
	}
	
	function formEdit(){
		global $Main, $DataPengaturan;
		$cek="";$err="";$content="";
		$cbid = $_REQUEST[$this->Prefix."_cb"];
		$hit = count($cbid);
		
		if($hit < 1 && $err == "")$err = "Data Belum di Pilih !";
		if($hit > 1 && $err == "")$err = "Pilih Hanya 1 Data !";
		if($err == ""){
			$idplh = cekPOST_Arr($this->Prefix."_cb", 0);
			$Get = $this->ValidasiPengeluaranKas($idplh);
			$err = $Get["errmsg"];
			$dt = $Get["dt"];
		}
		
		
		return array("cek"=>$cek, "err"=>$err, "content"=>$content);
	}
	
	function Hapus_Validasi($id){//id -> multi id with space delimiter
		global $DataPengaturan;
		
		$cbid = $_REQUEST[$this->Prefix."_cb"];
		
		for($i=0;$i<count($cbid);$i++){
			if($errmsg == ""){
				$idplh = cekPOST_Arr($this->Prefix."_cb", $i);
				$Get = $this->ValidasiPengeluaranKas($idplh);
				$errmsg = $Get["errmsg"];
				$dt = $Get["dt"];
			}else{
				break;
			}
		}	
		
		return $errmsg;
	}
}
$daftar_pengeluarankas = new daftar_pengeluarankasObj();
?>