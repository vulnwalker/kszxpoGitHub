<?php

include "pages/pencarian/DataPengaturan.php";
$DataOption = $DataPengaturan->DataOption();

class cariTemplateObj  extends DaftarObj2{	
	var $Prefix = 'cariTemplate';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_template'; //bonus
	var $TblName_Hapus = 'ref_template';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;	
	var $PageTitle = 'Data Template';
	var $PageIcon = 'images/administrator/images/icon_template.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pemasukan.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'Pemasukan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'cariTemplateForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	function setTitle(){
		return 'TEMPLATE DISTRIBUSI';
	}
	
	/*function setMenuEdit(){
		return "";
	}*/
	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main, $DataPengaturan;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	//get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 
	 $idplh = cekPOST("idplh");
	 $NAMATMPLT = cekPOST("NAMATMPLT");
	 $TGLTMPLT = cekPOST("TGLTMPLT");
	 $TGLTMPLT = explode("-",$TGLTMPLT);
	 $TGLTMPLT = $TGLTMPLT[2]."-".$TGLTMPLT[1]."-".$TGLTMPLT[0];
	 
	 $hit = $DataPengaturan->QyrTmpl1Brs("ref_rincian_template", "SUM(jumlah) as jml", "WHERE refid_template='$idplh' AND status!='2'");
	 $dt_hit = $hit["hasil"];
	 
	 if($err==""&& $NAMATMPLT=="")$err = "Nama Template Belum Di Isi !";
	 if($err==""&& $TGLTMPLT=="")$err = "Tanggal Template Belum Di Isi !";
	 if($err=='' && !cektanggal($TGLTMPLT)){	 		
		 $TGLTMPLT = explode("-",$TGLTMPLT);
		 $TGLTMPLT = $TGLTMPLT[2]."-".$TGLTMPLT[1]."-".$TGLTMPLT[0];	
		 if(!cektanggal($TGLTMPLT))$err= 'Tanggal Template Tidak Valid';	
	 }
	 if($err==""&& $dt_hit['jml']==0)$err = "Belum Ada Data Rincian Template !";
	
	 if($err == ""){
	 	$data = array(
	 			array("nama", $NAMATMPLT),
	 			array("sttemp", "0"),
	 			array("jumlah", $dt_hit['jml']),
	 			array("tgl", $TGLTMPLT),
			);
		$qry_upd = $DataPengaturan->QryUpdData("ref_template", $data, "WHERE id='$idplh' ");$cek.=$qry_upd["cek"];
		
		//UPDATE DATA sttemp ref_rincian_template
		$data_upd_det = array(array("sttemp","0"));
		$qry_upd_det = $DataPengaturan->QryUpdData("ref_rincian_template", $data_upd_det, "WHERE refid_template='$idplh' AND status='1'");
		//DELETE DATA ref_rincian_template
		$qry_del_det = "DELETE FROM ref_rincian_template WHERE refid_template='$idplh' AND status='2' ";
		$aqry_del_det = mysql_query($qry_del_det);
	 }
	 
	  			
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
		case 'GetDataTemplate':{				
			$fm = $this->GetDataTemplate();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'CekDet_DataTemplate':{				
			$fm = $this->CekDet_DataTemplate();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
		case 'Simpan_DetDataTemplate':{
			$get= $this->Simpan_DetDataTemplate();
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
		
		case 'BersihData':{
			$get= $this->BersihData();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
		break;
	    }
		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
		break;
		}
		
		case 'pilihan':{
				$fm = $this->setTemplate();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
		break;
		}
		
		case 'DataCopy':{
				$fm = $this->DataCopy();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
		break;
		}
		
		case 'Get_JumlahBarang':{
				$fm = $this->Get_JumlahBarang();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
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
   
   function setPage_OtherScript(){
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
					</script>";
		return 	
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".	
			"<script type='text/javascript' src='js/master/ref_template/ref_Template.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/pencarian/".$this->Prefix.".js' language='JavaScript' ></script>".
			'
			  <link rel="stylesheet" href="datepicker/jquery-ui.css">
			  <script src="datepicker/jquery-1.12.4.js"></script>
			  <script src="datepicker/jquery-ui.js"></script>
			'.
			$scriptload;
	}
	
	//form ==================================
	function setFormBaru(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS, $DataOption;
		$UID = $_COOKIE['coID']; 
		$dt=array();
		$err='';$cek='';$content='';
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$dt["c1"] = cekPOST('c1_tmplt',cekPOST('cariTemplateSKPDfmURUSAN','0'));
		$dt["c"] = cekPOST('c_tmplt',cekPOST('cariTemplateSKPDfmSKPD'),'00');
		$dt["d"] = cekPOST('d_tmplt',cekPOST('cariTemplateSKPDfmUNIT'),'00');
		
		if($DataOption['skpd'] != '1')if($dt["c1"] == "0" && $err=='')$err="Urusan Belum Di Pilih !";
		if($dt["c"] == "00" && $err=='')$err="Bidang Belum Di Pilih !";
		if($dt["d"] == "00" && $err=='')$err="SKPD Belum Di Pilih !";
		
		if($err == ''){
			$dt_array = array(
						array("c1", $dt["c1"]),
						array("c", $dt["c"]),
						array("d", $dt["d"]),
						array("tgl", date("Y-m-d")),
						array("sttemp", "1"),
						array("uid", $UID),
					);
			$qry_ins = $DataPengaturan->QryInsData("ref_template", $dt_array);
			$qry_tmpl = $DataPengaturan->QyrTmpl1Brs2("ref_template", "*", $dt_array, "ORDER BY id DESC LIMIT 0,1");
			$dt = $qry_tmpl["hasil"];
			
			$fm = $this->setForm($dt);
			$cek=$fm['cek'];
			$err=$fm['err'];
			$content=$fm['content'];
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
		
	}
   
  	function setFormEdit(){
		global $DataPengaturan;
		$cek ='';
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;				
		//get data 
		$qry_tmpl = $DataPengaturan->QyrTmpl1Brs("ref_template", "*", "WHERE id='".$cbid[0]."'");
		$dt = $qry_tmpl["hasil"];
		
		$fm = $this->setForm($dt);
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	
	function setForm_content_fields(){
		$content = '';
		
		
		
		foreach ($this->form_fields as $key=>$field){
			if(!isset($field["kosong"])){				
				$labelWidth = $field['labelWidth']==''? $this->formLabelWidth: $field['labelWidth'];
				$pemisah = $field['pemisah']==NULL? ':': $field['pemisah'];			
				$row_params = $field['row_params']==NULL? $this->row_params : $field['row_params'];
				if ($field['type'] == ''){
					$val = $field['value'];
					$content .= 
						"<tr $row_params>
							<td style='width:$labelWidth'>".$field['label']."</td>
							<td style='width:10'>$pemisah</td>
							<td>". $val."</td>
						</tr>";
				}else if ($field['type'] == 'merge' ){
					$val = $field['value'];
					$content .= 
						"<tr $row_params>
							<td colspan=3 >".$val."</td>
						</tr>";
				}else{
					$val = Entry($field['value'],$key,$field['param'],$field['type']);	
					$content .= 
						"<tr $row_params>
							<td style='width:$labelWidth'>".$field['label']."</td>
							<td style='width:10'>$pemisah</td>
							<td>". $val."</td>
						</tr>";
				}
			}			
			
		}
		//$content = 
		//	"<tr><td style='width:100'>field</td><td style='width:10'>:</td><td>value</td></tr>";
		return $content;	
	}	
		
	function setForm($dt){	
	 global $SensusTmp, $DataOption, $DataPengaturan;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 300;
	 $this->form_height = 50;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'BARU TEMPLATE DISTRIBUSI BARANG';
		$nip	 = '';
	  }else{
		$this->form_caption = 'UBAH TEMPLATE DISTRIBUSI BARANG';			
		$Id = $dt['Id'];			
	  }
	  $tgl_template = explode("-", $dt['tgl']);
	  $tgl_template = $tgl_template[2]."-".$tgl_template[1]."-".$tgl_template[0];
	  
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
		$dataCi = array("kosong"=>"");
		$WHERE = "WHERE c1='".$dt["c1"]."'  AND e='00' AND e1='000' ";
		if($DataOption["skpd"] != 1){
			$qry_c1 = $DataPengaturan->QyrTmpl1Brs("ref_skpd", "concat(c1,'. ', nm_skpd) as nama", $WHERE." AND c='00' AND d='00' ");
			$dt_c1 = $qry_c1["hasil"];
			$dataCi = array(
				'label'=>'URUSAN',
				'labelWidth'=>100, 
				'value'=>$dt_c1['nama'], 
				'type'=>'text',
				'param'=>"style='width:400px;' readonly"
			);
		}
		
		$qry_c = $DataPengaturan->QyrTmpl1Brs("ref_skpd", "concat(c,'. ', nm_skpd) as nama", $WHERE." AND c='".$dt["c"]."' AND d='00' ");
		$dt_c = $qry_c["hasil"];
		$qry_d = $DataPengaturan->QyrTmpl1Brs("ref_skpd", "concat(d,'. ', nm_skpd) as nama", $WHERE." AND c='".$dt["c"]."' AND d='".$dt["d"]."' ");
		$dt_d = $qry_d["hasil"];
		
		$qry_unit = "SELECT e, concat(e,'. ', nm_skpd) FROM ref_skpd WHERE c1='".$dt["c1"]."' AND c='".$dt["c"]."' AND d='".$dt["d"]."' AND e!='00' AND e1='000' ";$cek.=$qry_unit;
		 
		
		
		
	 //items ----------------------
	  $this->form_fields = array(
			'URUSAN' => $dataCi,
			"BIDANG" => array(
							'label'=>'BIDANG',
							'labelWidth'=>200, 
							'value'=>$dt_c['nama'], 
							'type'=>'text',
							'param'=>"style='width:400px;' readonly"	
							),
			"SKPD" => array(
							'label'=>'SKPD',
							'labelWidth'=>200, 
							'value'=>$dt_d['nama'], 
							'type'=>'text',
							'param'=>"style='width:400px;' readonly"	
							),
			"NAMATMPLT" => array(
							'label'=>'NAMA TEMPLATE',
							'labelWidth'=>200, 
							'value'=>$dt['nama'], 
							'type'=>'text',
							'param'=>"style='width:400px;' "	
							),
			"TGLTMPLT" => array(
							'label'=>'TANGGAL TEMPLATE',
							'labelWidth'=>200, 
							'value'=>$tgl_template, 
							'type'=>'text',
							'param'=>"style='width:80px;' class='datepicker' "	
							),
			"UNIT" => array(
							'label'=>'UNIT',
							'labelWidth'=>200, 
							'value'=>cmbQuery("UNIT",$dt["e"], $qry_unit,"style='width:400px;' onchange='".$this->Prefix.".CleanCariSubUnit();".$this->Prefix.".CekDet_DataTemplate();".$this->Prefix.".CekDet_DataTemplate();' ", "--- PILIH UNIT ---"), 
							),
			"JUMLAH_BRG" => array(
							'label'=>'JUMLAH',
							'labelWidth'=>200,
							'value'=>"<input type='text' name='JUMLAH_BRG' id='JUMLAH_BRG' value='' style='width:50px;' readonly />",
							),
			'data' => array( 
						'type'=>"merge",
						'value'=>"<div id='DataPenerimaTemplate'></div>", 
						 ),		
			
		);
		//tombol
		$this->form_menubawah =
			"<input type='hidden' id='c1' name='c1' value='".$dt["c1"]."'/>".
			"<input type='hidden' id='c' name='c' value='".$dt["c"]."'/>".
			"<input type='hidden' id='d' name='d' value='".$dt["d"]."'/>".
			"<input type='hidden' id='idplh' name='idplh' value='".$dt["id"]."'/>".
			"<input type='button' value='SELESAI' onclick ='".$this->Prefix.".CekDet_DataTemplate(1)' title='Selesai' > ".
			"<input type='button' value='BATAL' onclick ='".$this->Prefix.".BersihData(".$dt["id"].")' >";
							
		$form = $this->genForm2();		
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
	
	function setPage_HeaderOther(){
	return "";
			/*"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style='margin:0 0 0 0'>
	<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>
	<A href=\"pages.php?Pg=bagian\" title='Organisasi' >Organisasi</a> |
	<A href=\"pages.php?Pg=pegawai\" title='Pegawai' >Pegawai</a> |
	<A href=\"pages.php?Pg=barang\" title='Barang'>Barang</a> |
	<A href=\"pages.php?Pg=jenis\" title='Jenis'  >Jenis</a> |
	<A href=\"pages.php?Pg=satuan\" title='Satuan' style='color:blue' >Satuan</a> 
	&nbsp&nbsp&nbsp	
	</td></tr></table>";*/
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $this->BersihData();
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
	  	   <th class='th01' width='5'>No.</th>".
	  	   $Checkbox."		
		   <th class='th01' width='80px'>TANGGAL</th>
		   <th class='th01'>NAMA</th>
		   <th class='th01' width='100px'>JUMLAH</th>
		   <th class='th01' width='30px'>AKSI</th>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function Gen_TombolOption($title, $gambar, $func){
		return "<a href='javascript:$func' >
					<img src='images/administrator/images/$gambar' width='20px' height='20px'  title='$title'/>
				</a>";
	}
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 $tanggal = explode("-",$isi['tgl']);
	 $tanggal = $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];
	 
	 $nm_tmplt = "<a href='javascript:".$this->Prefix.".pilihan(`".$isi['id']."`)' >".$isi['nama']."</a>";
	 if(!isset($_REQUEST['c1_tmplt']))$nm_tmplt=$isi['nama'];
	
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 $Koloms[] = array('align="center" ',$tanggal);
	 $Koloms[] = array('align="left"',$nm_tmplt);
	 $Koloms[] = array('align="right"',number_format($isi['jumlah'],0,'.',','));
	 //$Koloms[] = array('align="right"',$this->Gen_TombolOption("Lihat Data", "properties_f2.png",""));
	 $Koloms[] = array('align="center"',$this->Gen_TombolOption("Gandakan Data", "move_f2.png",$this->Prefix.".DataCopy(".$isi['id'].")"));
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 
	 $arr = array(
			//array('selectAll','Semua'),	
			array('selectSatuan','Satuan'),		
			);
		
	 //data order ------------------------------
	 $arrOrder = array(
			     	array('1','Satuan'),
					);
	 
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	
	$DataSKPD = genFilterBar(array(WilSKPD_ajx3($this->Prefix.'SKPD','100%','145px')),'','','');
	if(isset($_REQUEST['c1_tmplt']))$DataSKPD='';
	
	$TampilOpt =
			//<table width=\"100%\" class=\"adminform\">
			"<tr><td>".
			$vOrder=
			$DataSKPD.
			genFilterBar(
				array(							
					"<input type='text' value='".$fmPILCARIvalue."' placeholder='NAMA TEMPLATE' name='fmPILCARIvalue' id='fmPILCARIvalue' size='70'>
					<input type='hidden' value='' id='data_copy' name='data_copy' />
					",
					"
					<input type='button' id='btTampil' value='Cari' onclick='".$this->Prefix.".refreshList(true)'>"
					),			
				'','');
				;
			
			
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS, $DataOption;
		$UID = $_COOKIE['coID']; 
		$c1input = $_COOKIE['cofmURUSAN'];
		$cinput = $_COOKIE['cofmSKPD'];
		$dinput = $_COOKIE['cofmUNIT'];
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn
		$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];			
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
		
		$c1_tmplt = cekPOST('c1_tmplt',cekPOST('cariTemplateSKPD2URUSAN',$c1input));
		$c_tmplt = cekPOST('c_tmplt',cekPOST('cariTemplateSKPD2fmSKPD',$cinput));
		$d_tmplt = cekPOST('d_tmplt',cekPOST('cariTemplateSKPD2fmUNIT',$dinput));
		
		$idTerima_tmplt = $_REQUEST['idTerima_tmplt'];
		$idTerima_det_tmplt = $_REQUEST['idTerima_det_tmplt'];
		
		if($fmPILCARIvalue !='')$arrKondisi[] = " nama like '%$fmPILCARIvalue%' ";
		if($DataOption['skpd'] !='1')if($c1_tmplt != '0')$arrKondisi[] = " c1='$c1_tmplt'";
		if($c_tmplt != '00')$arrKondisi[] = " c='$c_tmplt'";
		if($d_tmplt != '00')$arrKondisi[] = " d='$d_tmplt'";
		$arrKondisi[] = " sttemp='0'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		$arrOrders[] = " id DESC ";
		
		/*if($fmORDER1 == ''){
			$arrOrders[] = " bk ";
			$arrOrders[] = " ck ";
			$arrOrders[] = " dk ";
			$arrOrders[] = " p ";
		}
		
		switch($fmORDER1){
			case '1': $arrOrders[] = " p $Asc1 " ;break;
		}	*/
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
	
	/*function setTopBar(){
	   	return '';
	}	*/
	
	function setMenuView(){
		return "";
	}
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
				
		$form_name = $this->FormName;
		
		$c1nya = $_REQUEST['c1nya'];
		$cnya = $_REQUEST['cnya'];
		$dnya = $_REQUEST['dnya'];
		$idTerima = $_REQUEST['idTerima'];
		$idTerima_det = $_REQUEST['idTerima_det'];
		
			$FormContent = $this->genDaftarInitial($ref_jenis);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						900,
						500,
						'Pilih Template',
						'',
						/*"
						<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".*/
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='c1_tmplt' name='c1_tmplt' value='$c1nya' >".
						"<input type='hidden' id='c1_tmfmSKPDUrusanplt' name='fmSKPDUrusan' value='$c1nya' >".
						"<input type='hidden' id='c_tmplt' name='c_tmplt' value='$cnya' >".
						"<input type='hidden' id='fmSKPDBidang' name='fmSKPDBidang' value='$cnya' >".
						"<input type='hidden' id='d_tmplt' name='d_tmplt' value='$dnya' >".
						"<input type='hidden' id='fmSKPDskpd' name='fmSKPDskpd' value='$dnya' >".
						"<input type='hidden' id='idTerima_tmplt' name='idTerima_tmplt' value='$idTerima' >".
						"<input type='hidden' id='idTerima_det_tmplt' name='idTerima_det_tmplt' value='$idTerima_det' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
		//}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setTemplate(){		
		global $HTTP_COOKIE_VARS;
	 	global $Main;
		$cek = ''; $err=''; $content=''; 
		$thn_anggaran = $HTTP_COOKIE_VARS['coThnAnggaran'];
		$uid = $HTTP_COOKIE_VARS['coID'];
		
		$idTerima_det_tmplt = $_REQUEST['idTerima_det_tmplt'];
		$idTerima_tmplt = $_REQUEST['idTerima_tmplt'];
		
		$qry_pendet = "SELECT * FROM t_penerimaan_barang_det WHERE Id='$idTerima_det_tmplt' ";
		$aqry_pendet = mysql_query($qry_pendet);
		$dt_pendet = mysql_fetch_array($aqry_pendet);
		
		$c1 = $dt_pendet['c1'];
		$c = $dt_pendet['c'];
		$d = $dt_pendet['d'];
		
		$idnya = $_REQUEST['idnya'];
		
		//UPDATE t_distribusi
		$qry_upd_dstr = "UPDATE t_distribusi SET status='2' WHERE refid_penerimaan_det='$idTerima_det_tmplt' AND refid_terima='$idTerima_tmplt' AND status='1' ";
		$aqry_upd_dstr = mysql_query($qry_upd_dstr);
		
			
		$qry = "SELECT * FROM ref_rincian_template WHERE refid_template='$idnya' AND jumlah > 0";
		$aqry = mysql_query($qry);
		while($dt = mysql_fetch_array($aqry)){
			//$cek.= $dt['jumlah']." | ";
			//INSERY t_distribusi
			$qry_ins_dstr = "INSERT INTO t_distribusi (c1,c,d,e,e1,f1,f2,f,g,h,i,j,jumlah, refid_terima, refid_penerimaan_det, status, sttemp, uid,tahun) values ('$c1', '$c', '$d', '".$dt['e']."', '".$dt['e1']."', '".$dt_pendet['f1']."', '".$dt_pendet['f2']."', '".$dt_pendet['f']."', '".$dt_pendet['g']."', '".$dt_pendet['h']."', '".$dt_pendet['i']."', '".$dt_pendet['j']."', '".$dt['jumlah']."', '$idTerima_tmplt', '$idTerima_det_tmplt', '1', '1', '$uid', '$thn_anggaran')";
			
			$daqry_ins_dstr = mysql_query($qry_ins_dstr);			
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function GetDataTemplate(){
		$cek='';$err='';$content="";
		$c1 = cekPOST("c1");
		$c = cekPOST("c");
		$d = cekPOST("d");
		$e = cekPOST("UNIT");
		$idplh = cekPOST("idplh");
		$CariSubUnit = cekPOST("CariSubUnit");
		
		//<td class="GarisDaftar">
		$data = "";
		if($e != ""){			
			//$qry = "SELECT a.e, a.e1, concat(a.e1, '. ', a.nm_skpd) as nama, b.jumlah FROM ref_skpd LEFT JOIN ref_rincian_template b ON a.c1=b.c1 AND a.c=b.c AND a.d=b.d AND a.e=b.e AND a.e1=b.e1 WHERE a.c1='$c1' AND a.c='$c' AND a.d='$d' AND a.e='$e' AND a.e1!='000' AND b.refid_template='$idplh' ";$cek.=$qry;
			$qry = "SELECT a.e, a.e1, concat(a.e1, '. ', a.nm_skpd) as nama, b.jumlah FROM (SELECT * FROM ref_skpd WHERE c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1!='000') a LEFT JOIN (SELECT * FROM ref_rincian_template  WHERE refid_template='$idplh' AND status!='2') b ON a.c1=b.c1 AND a.c=b.c AND a.d=b.d AND a.e=b.e AND a.e1=b.e1 WHERE a.nm_skpd LIKE '%$CariSubUnit%' ";$cek.=$qry;
			$no=1;
			$aqry = mysql_query($qry);
			while($dt = mysql_fetch_array($aqry)){
				$data.="
					<tr>
						<td class='GarisDaftar' align='center' width='20px'>$no</td>
						<td class='GarisDaftar'>".$dt["nama"]."</td>
						<td class='GarisDaftar' width='100px'>
							<input type='number' name='jml_".$dt["e"]."_".$dt["e1"]."' value='".$dt["jumlah"]."' style='width:100px;text-align:right;' />
							<input type='hidden' name='Id[]' value='".$dt["e"]."_".$dt["e1"]."' style='width:100px;' />
						</td>
					</tr>
				";
				$no++;
			}
		}
		
		$content = 
			"<table class='koptable' style='margin:4 0 0 0;width:100%' border='1'>
				<tr>
					<th class='GarisDaftar' width='20px'></th>
					<th class='GarisDaftar'><input type='text' name='CariSubUnit' style='width:94%' id='CariSubUnit' value='$CariSubUnit' placeholder='NAMA SUB UNIT' /> <input type='button' name='CariFilter' onclick='cariTemplate.CekDet_DataTemplate();' value='CARI' style='width:5%'/>  </th>
					<th class='GarisDaftar' width='100px'><input type='button' value='SIMPAN' title='SIMPAN'  onclick='cariTemplate.Simpan_DetDataTemplate();' value='CARI' style='width:100%' /></th>
				</tr>
				<tr>
					<th class='th01' width='20px'>NO</th>
					<th class='th01'>NAMA SUB UNIT</th>
					<th class='th01' width='100px'>JUMLAH</th>
				</tr>
				".$data."
			</table>";
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function CekDet_DataTemplate(){
		global $DataPengaturan;
		
		$cek='';$err='';$content=array();
		
		$Id = $_REQUEST["Id"];
		$idplh = cekPOST("idplh");
		$c1 = cekPOST("c1");
		$c = cekPOST("c");
		$d = cekPOST("d");
		
		$content["confrim"] = "";
		
		for($i=0;$i<count($Id);$i++){
			$jml = cekPOST("jml_".$Id[$i]);
			$skpd = explode("_", $Id[$i]);
			$e=$skpd[0];
			$e1=$skpd[1];
			
			$qry = "SELECT a.e, a.e1, concat(a.e1, '. ', a.nm_skpd) as nama, b.jumlah FROM (SELECT * FROM ref_skpd WHERE c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1') a LEFT JOIN (SELECT * FROM ref_rincian_template  WHERE refid_template='$idplh' AND status != '2') b ON a.c1=b.c1 AND a.c=b.c AND a.d=b.d AND a.e=b.e AND a.e1=b.e1";$cek.=$qry;
			$aqry = mysql_query($qry);
			$dt = mysql_fetch_array($aqry);
			$cek.="| ".intval($jml)." != ".intval($dt["jumlah"]);
			
			if(intval($jml) != intval($dt["jumlah"])){
				$content["confrim"]="Ada Data Yang Belum Tersimpan ! Mau Di Simpan ?";
				break;
			}
			
		}	
		
		$hit = $DataPengaturan->QyrTmpl1Brs("ref_rincian_template", "SUM(jumlah) as jml", "WHERE refid_template='$idplh' AND status!='2'");
	 	$dt_hit = $hit["hasil"];
		
		$content["jml_brg"] = floatval($dt_hit["jml"]);
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Simpan_DetDataTemplate(){
		global $DataPengaturan;
		
		$cek='';$err='';$content="";
		
		$Id = $_REQUEST["Id"];
		$idplh = cekPOST("idplh");
		$c1 = cekPOST("c1");
		$c = cekPOST("c");
		$d = cekPOST("d");
		
		for($i=0;$i<count($Id);$i++){
			$jml = cekPOST("jml_".$Id[$i]);
			$skpd = explode("_", $Id[$i]);
			$e=$skpd[0];
			$e1=$skpd[1];
			
			$WHERESKPD = " c1='$c1' AND c='$c' AND d='$d' AND e='$e' AND e1='$e1' ";
			
			$qry = "SELECT a.e, a.e1, concat(a.e1, '. ', a.nm_skpd) as nama, a.nm_skpd, b.jumlah, b.id, b.status FROM (SELECT * FROM ref_skpd WHERE $WHERESKPD ) a LEFT JOIN (SELECT * FROM ref_rincian_template  WHERE refid_template='$idplh' AND status != '2') b ON a.c1=b.c1 AND a.c=b.c AND a.d=b.d AND a.e=b.e AND a.e1=b.e1";$cek.=$qry;
			$aqry = mysql_query($qry);
			$dt = mysql_fetch_array($aqry);
			$cek.="| ".intval($jml)." != ".intval($dt["jumlah"]);
			
			if(intval($jml) != intval($dt["jumlah"])){
				if($dt["id"] != null || $dt["id"] != ""){
					$data_upd = array(
								array("status","2"),
							);
					
					$qry_upd = $DataPengaturan->QryUpdData("ref_rincian_template", $data_upd, "WHERE id='".$dt["id"]."'");
					$cek.=$qry_upd["cek"];
				}
				
				$data_ins = array(
						array("c1",$c1),
						array("c",$c),
						array("d",$d),
						array("e",$e),
						array("e1",$e1),
						array("jumlah",$jml),
						array("refid_template",$idplh),
						array("nama_sub_unit",$dt["nm_skpd"]),
						array("status","1"),
						array("sttemp","1"),
					);
				$qry_ins = $DataPengaturan->QryInsData("ref_rincian_template", $data_ins);$cek.=$qry_ins["cek"];
				
			}
			
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function BersihData(){
		global $DataPengaturan;
		
		$tbl = "ref_template";
		$tbl_det = "ref_rincian_template";
		
		$cek='';$err='';$content='';
		$IdBersih = cekPOST("IdBersih");
		//Hapus ref_template
		$qry_Del = $DataPengaturan->QryDelData($tbl, "WHERE tgl_create < DATE_SUB(NOW(), INTERVAL 2 DAY) AND sttemp!='0'");
		$cek.=$qry_Del["hasil"];
		
		//Update ref_rincian_template
		$data_upd_det = array(array("status", "1")); 
		
		$qry_upd_det = $DataPengaturan->QryUpdData($tbl_det, $data_upd_det, "WHERE sttemp='0' AND tgl_create < DATE_SUB(NOW(), INTERVAL 2 HOUR) AND status='2' ");
		$qry_del_det = $DataPengaturan->QryDelData($tbl_det, "WHERE sttemp!='0' AND tgl_create < DATE_SUB(NOW(), INTERVAL 2 HOUR) ");		
		
		if($IdBersih != 0){
			//CEK APAKAH STTEMP != '0'
			$qry_cek = $DataPengaturan->QyrTmpl1Brs($tbl, "*", "WHERE id='$IdBersih' ");
			$dt_cek = $qry_cek["hasil"];
			if($dt_cek["sttemp"] == "1"){
				$qry2 = $DataPengaturan->QryDelData($tbl, "WHERE id='$IdBersih'" );$cek.=$qry2["cek"];
			}else{
				$qry2 = $DataPengaturan->QryDelData($tbl_det, "WHERE sttemp!='0' AND refid_template='$IdBersih'" );$cek.=$qry2["cek"];				
				$data_upd = array(array("status","1"));
				$qry_upd = $DataPengaturan->QryUpdData("ref_rincian_template", $data_upd, "WHERE sttemp='0' AND refid_template='$IdBersih' AND status='2' ");$cek.=$qry_upd["cek"];
			}
			
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function DataCopy(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 	
		$cek='';$err='';$content='';
		
		$idTemplate = addslashes($_REQUEST["datakopi"]);
		$c1_tmplt = cekPOST('c1_tmplt',cekPOST('cariTemplateSKPD2URUSAN','0'));
		$c_tmplt = cekPOST('c_tmplt',cekPOST('cariTemplateSKPD2fmSKPD'));
		$d_tmplt = cekPOST('d_tmplt',cekPOST('cariTemplateSKPD2fmUNIT'));
		//Cek Di Template
		$qry_tmpl = $DataPengaturan->QyrTmpl1Brs("ref_template", "*", "WHERE id='$idTemplate' AND sttemp='0'");$cek.=$qry_tmpl["cek"];
		$dt_tmpl = $qry_tmpl["hasil"];
		
		if($dt_tmpl['id'] != '' || $dt_tmpl['id'] != NULL){
			$tgl_sekarang = date("Y-m-d");
			$data_ins = array(
							array("c1",$dt_tmpl['c1']),
							array("c",$dt_tmpl['c']),
							array("d",$dt_tmpl['d']),
							array("nama",$dt_tmpl['nama']."-copy-".$tgl_sekarang),
							array("tgl",$tgl_sekarang),
							array("jumlah",$dt_tmpl['jumlah']),
							array("sttemp","0"),
							array("uid", $UID),
						);
						
			$qry_ins = $DataPengaturan->QryInsData("ref_template", $data_ins);
			
			$qry_tampil = $DataPengaturan->QyrTmpl1Brs2("ref_template", "id", $data_ins, "ORDER BY id DESC");
			$dt_tampil = $qry_tampil["hasil"];
		
			$qry_det = "SELECT * FROM ref_rincian_template WHERE refid_template='$idTemplate' AND sttemp='0'";$cek.=$qry_det;
			$aqry_det =mysql_query($qry_det);
			while($dt_det = mysql_fetch_array($aqry_det)){
				$data_ins_det = array(
									array("c1",$dt_det['c1']),
									array("c",$dt_det['c']),
									array("d",$dt_det['d']),
									array("e",$dt_det['e']),
									array("e1",$dt_det['e1']),
									array("jumlah",$dt_det['jumlah']),
									array("refid_template",$dt_tampil['id']),
									array("nama_sub_unit",$dt_det['nama_sub_unit']),
									array("status","1"),
									array("sttemp","0"),
								);
				$qry_ins_det = $DataPengaturan->QryInsData("ref_rincian_template", $data_ins_det);
			}
		}else{
			$err = "Data Template Tidak Bisa Di Gandakan !";
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_JumlahBarang(){
		global $DataPengaturan, $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 	
		$cek='';$err='';$content='';
		
		$idplh = cekPOST("idplh");
		
		$hit = $DataPengaturan->QyrTmpl1Brs("ref_rincian_template", "SUM(jumlah) as jml", "WHERE refid_template='$idplh' AND status!='2'");
	 	$dt_hit = $hit["hasil"];
		
		$content = floatval($dt_hit["jml"]);
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
}
$cariTemplate = new cariTemplateObj();
?>