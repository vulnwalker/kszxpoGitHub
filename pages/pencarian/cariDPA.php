<?php
 include "pages/pencarian/DataPengaturan.php";
 $DataOption = $DataPengaturan->DataOption();
class cariDPAObj  extends DaftarObj2{	
	var $Prefix = 'cariDPA';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'view_data_dpa'; //bonus
	var $TblName_dpa = 'tabel_dpa'; //bonus
	var $TblName_Hapus = 'tabel_dpa';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'ADMINISTRASI SYSTEM';
	var $PageIcon = 'images/pengadaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal =100;
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pemasukan.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'Pemasukan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'cariDPAForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	var $pid_urut = 1;
	var $pid_program = "";
	var $pid_kegiatan = "";
	var $pid_rekening = "";
	
	
	function setTitle(){
		return 'DAFTAR DPA';
	}
	
	function setMenuEdit(){
		return "";
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
		case 'windowshow':$fm = $this->windowShow();break;
		case 'windowSave':$fm = $this->windowSave();break;
		default:{
			$other = $this->set_selector_other2($tipe);
			$cek = $other['cek'];
			$err = $other['err'];
			$content=$other['content'];
			$json=$other['json'];
		break;
		}
		 
	 }//end switch
	 
	 	if($json){
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];	
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
			"<script type='text/javascript' src='js/pencarian/".$this->Prefix.".js' language='JavaScript' ></script>".
			$scriptload;
	}
		
	function setPage_HeaderOther(){
		return "";
	}
	
	function genTableRow($Koloms, $RowAtr='', $KolomClassStyle=''){
		$baris = '';	
		$data = TRUE;	
		foreach ($Koloms as &$value) { 	
			if($value[0] == "Y"){
				$baris .=$value[1];
				$data = FALSE;
			}else{
				$baris .= "<td class='$KolomClassStyle'  {$value[0]}>$value[1]</td>"; 
			}			
		}	
		if ($data && count($Koloms)>0 && $value[0] != "Y"){$baris ="<tr $RowAtr onclick=\"".$this->Prefix.".rowOnClick(this)\"> $baris </tr>"; }
		return $baris;
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 
	 $headerTable =
	  "<thead>
	   	<tr>
	  	   <th class='th01' width='5' rowspan='2'>NO.</th>".
	  	   $Checkbox."		
		   <th class='th01' rowspan='2' width='70px'>KODE REKENING</th>
		   <th class='th01' rowspan='2'>URAIAN</th>
		   <th class='th02' colspan='3'>RINCIAN PENGHITUNGAN</th>
		   <th class='th01' rowspan='2' width='100px'>JUMLAH HARGA</th>
		</tr>
		<tr>			
		   <th class='th01' width='40px'>VOL</th>
		   <th class='th01' width='60px'>SATUAN</th>
		   <th class='th01' width='100px'>HARGA SATUAN</th>
		</tr>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData_KodeProgram($no, $isi, $Mode,$q=FALSE){
	 global $Ref, $DataPengaturan;
	 	$Koloms="";
	 	$kode_program = $isi['bk'].".".$isi['ck'].".".$isi['dk'].".".$isi['p'];
		$kode_program .= $q == TRUE?".".$isi['q']:"";
		
		$pilihan = $q == TRUE?$this->pid_kegiatan:$this->pid_program;
		if($pilihan != $kode_program){			
			if($q == FALSE){
				$isi['q']=0;
				if($this->pid_urut!=1){
					$Koloms.= $this->pid_urut%2==0?"<tr class='row1'>":"<tr class='row0'>";
					$Koloms.= Tbl_Td("<hr>","left","colspan='8'")."</tr>";			
					$this->pid_urut++;
				}				
			}
			$Program = $DataPengaturan->GetProgKeg3($isi["bk"],$isi["ck"],$isi["dk"],$isi["p"],$isi['q']);	
			$Program["kode"]="";	
			$NamaProgram = $isi['q']!="0"?LabelSPan1("kd-prog",$Program["nm_prog"],"style='margin-left:5px;'"):$Program["nm_prog"];	
			$Koloms.= $this->pid_urut%2==0?"<tr class='row1'>":"<tr class='row0'>";
			$Koloms.= Tbl_Td("","left");
			$Koloms.= Tbl_Td("","left");
			$Koloms.= Tbl_Td("<b>".$Program["kode"]."</b>","left","class='GarisDaftar'");
			$Koloms.= Tbl_Td("<b>".$NamaProgram."</b>","left","class='GarisDaftar'");
			$Koloms.= Tbl_Td("","left");
			$Koloms.= Tbl_Td("","left");
			$Koloms.= Tbl_Td("","left");
			$Koloms.= Tbl_Td("","left");			
			$this->pid_urut++;
			if($q){
				$this->pid_rekening ='';
			}else{			
				$this->pid_kegiatan ='';
			}
		}	
		
		if($q){
			$this->pid_kegiatan = $kode_program;
		}else{			
			$this->pid_program = $kode_program;
		}
	 return $Koloms;
	}
	
	function setKolomData_DataRekening($no, $isi, $Mode){
	 global $Ref, $DataPengaturan;
	 	$Koloms='';
		$kode_rekening = $DataPengaturan->Gen_valRekening($isi);
		if($this->pid_rekening != $kode_rekening){
			$style = "style='font-weight:bold;margin-left:10px;'";
			$Rekening = $DataPengaturan->Get_valRekening($isi);
			$Koloms = $this->pid_urut%2==0?"<tr class='row1'>":"<tr class='row0'>";
			$Koloms.= Tbl_Td("","left");
			$Koloms.= Tbl_Td("","left");
			$Koloms.= Tbl_Td("<b>".$kode_rekening."</b>","center","class='GarisDaftar'");
			$Koloms.= Tbl_Td(LabelSPan1("rek1",$Rekening["nm_rekening"],$style)."</b>","left","class='GarisDaftar'");
			$Koloms.= Tbl_Td("","left");
			$Koloms.= Tbl_Td("","left");
			$Koloms.= Tbl_Td("","left");
			$Koloms.= Tbl_Td("","left");
			
			$this->pid_urut++;
		}
		$this->pid_rekening = $kode_rekening;
	 return $Koloms;
	}
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref, $DataOption;
	 $Koloms='';
	 $jenis_transaksi = cekPOST2("jenis_transaksi");
	 $volume = floatval($isi['volume_rek']) - floatval($isi['realisasi']); 
	 $kode_brg = $DataOption['kode_barang'] == 2?$isi['f1'].".".$isi['f2'].".":"";
	 $kode_brg .= $isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'];
	 $kode_brg .= $jenis_transaksi == 3?".".$isi['j1']:"";
	 $kode_brg="";
	 $Koloms.= $this->setKolomData_KodeProgram($no, $isi, $Mode);
	 $Koloms.= $this->setKolomData_KodeProgram($no, $isi, $Mode,TRUE);
	 $Koloms.= $this->setKolomData_DataRekening($no, $isi, $Mode);
	 
	 $style="style='margin-left:15px;'";
	 
	 $Koloms.= $this->pid_urut%2==0?"<tr class='row1'>":"<tr class='row0'>";
	 $Koloms.= Tbl_Td($no,"center","class='GarisDaftar'");
	 if($Mode == 1) $Koloms.= Tbl_Td($TampilCheckBox,"center","class='GarisDaftar'");
	 $Koloms.= Tbl_Td(LabelSPan1("kd",$kode_brg,""),"left","class='GarisDaftar'");
	 $Koloms.= Tbl_Td(LabelSPan1("ket",$isi['nm_barang'],$style),"left","class='GarisDaftar'");
	 $Koloms.= Tbl_Td(FormatAngka($volume),"right","class='GarisDaftar'");
	 $Koloms.= Tbl_Td($isi['satuan_total'],"left","class='GarisDaftar'");
	 $Koloms.= Tbl_Td(FormatUang($isi['jumlah']),"right","class='GarisDaftar'");
	 $Koloms.= Tbl_Td(FormatUang($isi['jumlah_harga']),"right","class='GarisDaftar'");
	 $Koloms .= "</tr>";
	 
	 $Koloms = array(
	 	array("Y", $Koloms),
	 );
	 $this->pid_urut++;
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main, $DataPengaturan, $DataPemasukan;
	 $prog = explode(".",cekPOST2("program"));
	 $q = cekPOST2("kegiatan");
	 $data_program = $DataPengaturan->GetProgKeg3($prog[0],$prog[1], $prog[2],$prog[3]);
	 $data_kegiatan = $DataPengaturan->GetProgKeg3($prog[0],$prog[1], $prog[2],$prog[3],$q);
	 $jenis_transaksi = cekPOST2("jenis_transaksi");
	 $fm_jenis_anggaran = cekPOST2("fm_jenis_anggaran");	 
	 $fm_prog = cekPOST2("fm_prog");
	 
	 $c1 = cekPOST2("c1");
	 $c = cekPOST2("c");
	 $d = cekPOST2("d");
	 
	 $where_data = " WHERE c1='$c1' AND c='$c' AND d='$d' AND jenis_transaksi='".$DataPengaturan->arr_JNS_TRANS[$jenis_transaksi]."' ";
	 $concat_prog = "concat(a.bk,'.',a.ck,'.',a.dk,'.',a.p)";
	 
	 $qry_jns_anggaran = "SELECT jenis_anggaran, jenis_anggaran FROM tabel_dpa GROUP BY jenis_anggaran";
	 $qry_prog = "SELECT concat(a.bk,'.',a.ck,'.',a.dk,'.',a.p) as kd_prog, b.nama FROM (SELECT bk,ck,dk,p FROM tabel_dpa $where_data GROUP BY bk,ck,dk,p) a LEFT JOIN ref_program b ON a.bk=b.bk AND a.ck=b.ck AND a.dk=b.dk AND a.p=b.p WHERE b.q='0' ";
	 
	 $qry_kegiatan = "SELECT a.q, b.nama FROM (SELECT bk,ck,dk,p,q FROM tabel_dpa $where_data AND concat(bk,'.',ck,'.',dk,'.',p) ='$fm_prog' GROUP BY bk,ck,dk,p,q) a LEFT JOIN ref_program b ON a.bk=b.bk AND a.ck=b.ck AND a.dk=b.dk AND a.p=b.p AND a.q=b.q WHERE b.q!='0' ";
	 
	 $btn_cari = InputTypeButton("btn_cari","CARI","onclick='".$this->Prefix.".refreshList(true);'");
	 $fn_js1 = '$("#fm_kegiatan").val("");';
	 	
	$TampilOpt =			
			genFilterBar(
				array(
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>'TRANSAKSI',
								'label-width'=>'150px;',
								'value'=>InputTypeText("fm_jns_transaksi",$DataPengaturan->arr_JNS_TRANS2[$jenis_transaksi]." BARANG", "style='width:200px;' readonly")
							),
							/*array(
								'label'=>'SUMBER DANA',
								'label-width'=>'150px;',
								'value'=>InputTypeText("fm_sumberdana",cekPOST2("sumberdana"), "style='width:200px;' readonly")
							),*/
							array(
								'label'=>'ANGGARAN',
								'label-width'=>'150px;',
								'value'=>
									cmbQuery("fm_jenis_anggaran",$fm_jenis_anggaran,$qry_jns_anggaran,"style='width:200px;' ","--- PILIH JENIS ANGGARAN ---")
									//InputTypeText("fm_jenis_anggaran",$jenis_anggaran, "style='width:200px;' readonly")
							),
							array(
								'label'=>'PROGRAM',
								'label-width'=>'150px;',
								'value'=>
									cmbQuery("fm_prog",$fm_prog,$qry_prog,"style='width:450px;' onchange='".$fn_js1.$this->Prefix.".refreshList(true)'","--- PILIH PROGRAM ---")
									//InputTypeText("fm_prog",$data_program["nm_prog"], "style='width:450px;' readonly")
							),
							array(
								'label'=>'KEGIATAN',
								'label-width'=>'150px;',
								'value'=>
									cmbQuery("fm_kegiatan",cekPOST2("fm_kegiatan"),$qry_kegiatan,"style='width:450px;' onchange='".$this->Prefix.".refreshList(true)'","--- PILIH KEGIATAN ---")
								//InputTypeText("fm_kegitan",$data_kegiatan["nm_prog"], "style='width:450px;' readonly")
							),
						)
					)
				),			
			'','').
			genFilterBar(
				array(
					$DataPengaturan->isiform(
						array(
							array(
								'label'=>InputTypeText("fm_kode_rekening", cekPOST2("fm_kode_rekening"),"style='width:150px;' placeholder='KODE REKENING'"),
								'pemisah'=>"",
								'label-width'=>'150px;',
								'value'=>InputTypeText("fm_nama_rekening",cekPOST2("fm_nama_rekening"), "style='width:400px;' placeholder='NAMA REKENING'")." ".$btn_cari
							),
							array(
								'label'=>InputTypeText("fm_kode_barang", cekPOST2("fm_kode_barang"),"style='width:150px;' placeholder='KODE BARANG'"),
								'label-width'=>'150px;',
								'pemisah'=>"",
								'value'=>InputTypeText("fm_nama_barang",cekPOST2("fm_nama_barang"), "style='width:400px;' placeholder='NAMA BARANG'")." ".$btn_cari
							),
						)
					)
				),			
			'','')
			;
			
			
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS,$DataPengaturan;
		$UID = $_COOKIE['coID']; 
		$arrKondisi = array();	
		
		//kondisi -----------------------------------
		$IdPenerimaan = cekPOST2("IdPenerimaan");
		$c1 = cekPOST2("c1");
		$c = cekPOST2("c");
		$d = cekPOST2("d");
		$program = cekPOST2("program");
		$kegiatan = cekPOST2("kegiatan");
		$sumberdana = cekPOST2("sumberdana");
		$jenis_anggaran = cekPOST2("fm_jenis_anggaran");
		$jenis_transaksi = cekPOST2("jenis_transaksi");
		$fm_prog = cekPOST2("fm_prog");
		$fm_kegiatan = cekPOST2("fm_kegiatan");
		$fm_kode_rekening = cekPOST2("fm_kode_rekening");
		$fm_kode_barang = cekPOST2("fm_kode_barang");
		$fm_nama_rekening = cekPOST2("fm_nama_rekening");
		$fm_nama_barang = cekPOST2("fm_nama_barang");
		
		$arrKondisi[] = "c1='$c1'";
		$arrKondisi[] = "c='$c'";
		$arrKondisi[] = "d='$d'";
		$arrKondisi[] = "j!='000'";
		if($jenis_anggaran != '')$arrKondisi[] = "jenis_anggaran='$jenis_anggaran'";
		if($fm_prog != '')$arrKondisi[] = "concat(bk,'.',ck,'.',dk,'.',p)='$fm_prog'";
		if($fm_kegiatan != '')$arrKondisi[] = "q='".$fm_kegiatan."'";
		$arrKondisi[] = "jenis_transaksi='".$DataPengaturan->arr_JNS_TRANS[$jenis_transaksi]."'";
		
		if($fm_kode_rekening != "")$arrKondisi[] = "concat(k,'.',l,'.',m,'.',n,'.',o) LIKE '%$fm_kode_rekening%'";
		if($fm_kode_barang != "")$arrKondisi[] = "concat(f1,'.',f2,'.',f,'.',g,'.',h,'.',i,'.',j,'.',j1) LIKE '%$fm_kode_barang%'";
		if($fm_nama_rekening != "")$arrKondisi[] = "nm_rekening LIKE '%$fm_nama_rekening%'";
		if($fm_nama_barang != "")$arrKondisi[] = "nm_barang LIKE '%$fm_nama_barang%'";
		
		/*$arrKondisi[] = "concat(bk,'.',ck,'.',dk,'.',p,'.',q)='$program.$kegiatan'";
		$arrKondisi[] = "j!='000'";
		//$arrKondisi[] = "sumber_dana='$sumberdana'";
		$arrKondisi[] = "jenis_anggaran='$jenis_anggaran'";
		$arrKondisi[] = "id NOT IN (SELECT refid_dpa FROM t_penerimaan_barang_det_v2 WHERE refid_terima='$IdPenerimaan' AND status!='2')";
		$arrKondisi[] = "cast(realisasi AS DECIMAL(10,2)) < cast(volume_rek AS DECIMAL(10,2))";*/
				
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " p $Asc1 " ;break;
		}	
		
		$arrOrders[] = "jenis_anggaran,bk,ck,dk,p,q,k,l,m,n,o " ;
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal;
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);
		
	}
	
	function setTopBar(){
	   	return '';
	}	
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
		$jns_transaksi = cekPOST2("jns_transaksi");
		$pemasukan_ins_idplh = cekPOST2("pemasukan_ins_idplh");
		
		$pil = $pemasukan_ins_idplh != ''?"2":"1";				
		$form_name = $this->FormName;
		//$ref_jenis=$_REQUEST['ref_jenis'];
		if($err==''){
			$FormContent = $this->genDaftarInitial($ref_jenis);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						1024,
						500,
						'Pilih Data DPA',
						'',
						InputTypeHidden("IdPenerimaan",cekPOST2("IdPenerimaan",$pemasukan_ins_idplh)).
						InputTypeHidden("jenis_transaksi",$jns_transaksi).
						InputTypeHidden("c1",cekPOST2("c1nya")).
						InputTypeHidden("c",cekPOST2("cnya")).
						InputTypeHidden("d",cekPOST2("dnya")).
						InputTypeHidden("e",cekPOST2("enya")).
						InputTypeHidden("e1",cekPOST2("e1nya")).
						"<input type='button' value='PILIH' onclick ='".$this->Prefix.".windowSave($pil)' > ".
						"<input type='button' value='BATAL' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function windowSave(){
		$cek = ''; $err=''; $content=''; 		
		$dt_proces = cekPOST2("dt_proces");
		
		switch($dt_proces){
			case "1":$get = $this->Set_SimpanKePenerimaan_DetV2();break;
			case "2":$get = $this->Set_SimpanKePenerimaan();break;
		} 
		
		$cek.=$get['cek'];
		$err=$get['err'];
		$content=$get['content'];
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Set_SimpanKePenerimaan_Validasi(){
		global $DataPengaturan;
		$err="";
		
		$cariDPA_cb = $_REQUEST["cariDPA_cb"];
		$hitung_data = count($cariDPA_cb);
		if($hitung_data < 1)$err="Data Belum di Pilih !";
		if($err == ""){
			$prog="";
			$kegiatan="";
			for($i=0;$i<$hitung_data;$i++){
				if($err == ""){
					$IdDPA = cekPOST_Arr("cariDPA_cb",$i);
					$qry = $DataPengaturan->QyrTmpl1Brs($this->TblName,"*","WHERE id='$IdDPA' ");
					$dt = $qry["hasil"];
					if($err == "" && ($dt['id']=="" || $dt["id"]==NULL))$err="Data Tidak Valid !";
					if($err == "" && $prog != '' && $prog != $DataPengaturan->Gen_valProgram($dt))$err = "Pilih Data Yang Hanya dalam 1 Program Yang Sama !";
					if($err == "" && $kegiatan != '' && $kegiatan != $DataPengaturan->Gen_valKegiatan($dt))$err = "Pilih Data Yang Hanya dalam 1 Kegiatan Yang Sama !";
					
					$prog = $DataPengaturan->Gen_valProgram($dt);
					$kegiatan = $DataPengaturan->Gen_valKegiatan($dt);
				}else{
					break;
				}
			}			
		}
		return $err;
	}
	function Set_SimpanKePenerimaan_Before(){
		global $DataPengaturan;
		$cek='';
		//UPDATE t_penerimaan_rekening
		$IdPenerimaan=cekPOST2("IdPenerimaan");
		
		$data_upd = array(array("status","2"));
		$data_where = "WHERE refid_terima='$IdPenerimaan'";
		$qry_rek = $DataPengaturan->QryUpdData("t_penerimaan_rekening",$data_upd,$data_where);$cek.=" | ".$qry_rek["cek"];
		$qry_det = $DataPengaturan->QryUpdData("t_penerimaan_barang_det",$data_upd,$data_where);$cek.=" | ".$qry_det["cek"];
		
		return $cek;
	}
	function Set_SimpanKePenerimaan(){
		global $HTTP_COOKIE_VARS, $DataPengaturan;
		$cek = ''; $err=''; $content=''; 
		
	 	$uid = $HTTP_COOKIE_VARS['coID'];
	 	$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$IdPenerimaan=cekPOST2("IdPenerimaan");
		$jenis_transaksi=cekPOST2("jenis_transaksi");
		
		$err = $this->Set_SimpanKePenerimaan_Validasi();
		$cek.= $this->Set_SimpanKePenerimaan_Before();
		//if($err == "")$err="Ehh!";
		if($err == ""){
			$arr_rek = array();
			$cariDPA_cb = $_REQUEST["cariDPA_cb"];
			$hitung_data = count($cariDPA_cb);
			for($i=0;$i<$hitung_data;$i++){
				if($err == ""){
					//SIMPAN KE t_penerimaan_barang_det
					$IdDPA = cekPOST_Arr("cariDPA_cb",$i);
					$qry = $DataPengaturan->QyrTmpl1Brs($this->TblName,"*","WHERE id='$IdDPA' ");
					$dt = $qry["hasil"];
					$harga_total = floatval($dt["volume_rek"]) * floatval($dt["jumlah"]);
					
					$ket_kuantitas=$jenis_transaksi=="2"?$dt["satuan2"]:"";
					
					$data_ins = 
						array(
							array("refid_terima",$IdPenerimaan),
							array("refid_dpa",$dt["id"]),
							array("ket_barang",""),
							array("barangdistribusi","0"),
							array("status","1"),
							array("tahun",$coThnAnggaran),
							array("uid",$uid),
							array("sttemp","1"),
							array("harga_satuan",0),
							array("harga_total",0),
							array("jml",0),
							array("kuantitas",0),
							array("satuan",$dt["satuan1"]),
							array("ket_kuantitas",$ket_kuantitas),
						);
						
					/*if($jenis_transaksi == "2"){
						array_push(
							$data_ins,
							array("jml",$dt["jumlah1"]),
							array("kuantitas",$dt["jumlah2"]),
							array("satuan",$dt["satuan1"]),
							array("ket_kuantitas",$dt["satuan2"])
						);
					}else{
						array_push(
							$data_ins,
							array("satuan",$dt["satuan_total"]),
							array("jml",$dt["volume_rek"])
						);
					}*/
					
					$qry_ins = $DataPengaturan->QryInsData("t_penerimaan_barang_det",$data_ins);$cek.=$qry_ins["cek"];
				}else{
					break;
				}
			}	
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Set_SimpanKePenerimaan_DetV2(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$uid = $HTTP_COOKIE_VARS['coID']; 
		$coThnAnggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$cek = ''; $err=''; $content=''; 
				
		//DEKLARASI
		$cb = $_REQUEST[$this->Prefix."_cb"];
		$IdPenerimaan = cekPOST2("IdPenerimaan");
		$asalusul = cekPOST2("asalusul");
		
		if($err == "" && count($cb) < 1)$err="Data Belum Di Pilih !";
		
		if($err == ""){			
			for($i=0;$i<count($cb);$i++){
				$refid_dpa = $cb[$i];
				$data = 
					array(
						array("refid_dpa",$refid_dpa),
						array("refid_terima",$IdPenerimaan),
						array("asal_usul",$asalusul),
						array("uid",$uid),
						array("tahun",$coThnAnggaran),
						array("status","1"),
						array("status_sblm","1"),
						array("sttemp","1"),
					);
				$qry_ins = $DataPengaturan->QryInsData("t_penerimaan_barang_det_v2",$data);$cek.=$qry_ins["cek"];
			}
		}	
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
}
$cariDPA = new cariDPAObj();
?>