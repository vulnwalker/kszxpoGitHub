<?php

class RKADetailObj  extends DaftarObj2{	
	var $Prefix = 'RKADetail';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'rka'; //daftar
	var $TblName_Hapus = 'rka';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id');
	var $FieldSum = array('jml_harga');//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 9, 10, 10);//berdasar mode
	var $FieldSum_Cp2 = array( 0, 0, 0);	
	var $checkbox_rowspan = 2;
	var $PageTitle = 'RKA';
	var $PageIcon = 'images/pengadaan_ico.png';
	var $ico_width = '';
	var $ico_height = '';	
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'Rencana Kerja & Anggaran ( RKA )';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'RKA_form'; 	
			
	function setTitle(){
		return 'Rencana Kerja & Anggaran ( RKA )';
	}
	function setMenuEdit(){		
		return

			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Edit()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus').
			"</td>";
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
	 $b = '00';
	 $c = $_REQUEST['c'];
	 $d = $_REQUEST['d'];
	 $e = $_REQUEST['e'];
	 $e1 = '00';//$_REQUEST['e1'];
	 $tanggal = $_REQUEST['tanggal'];
	 $kode_barang = $_REQUEST['kode_barang'];
	 $kb = explode('.',$kode_barang);
	 $f = $kb[0];
	 $g = $kb[1];
 	 $h = $kb[2];
 	 $i = $kb[3];
	 $j = $kb[4];
	 $thn_perolehan = $_REQUEST['thn_perolehan'];
	 $noreg = $_REQUEST['noreg'];
	 $id_ruang = $_REQUEST['id_ruang'];
	 $idbi = $_REQUEST['idbi'];
	 $idbi_awal = $_REQUEST['idbi_awal'];	 
	 
	if( $err=='' && $tanggal =='' ) $err= 'Tanggal belum diisi!';
	if( $err=='' && $kode_barang =='' ) $err= 'Barang belum dipilih';
	if( $err=='' && $id_ruang =='') $err= 'Ruang belum dipilih!';
									 	 			 		  
			if($fmST == 0){ //input Kartu Inventaris Ruang
				if($err==''){  
					$aqry1 ="INSERT into t_kir (a1,a,b,c,d,e,e1,f,g,h,i,j,noreg,thn_perolehan,idbi,idbi_awal,ref_idruang,tgl)
					"."values('$a1',
					'$a',
					'$b',
					'$c',
					'$d',
					'$e',
					'$e1',
					'$f',
					'$g',
					'$h',
					'$i',
					'$j',
					'$noreg',
					'$thn_perolehan',
					'$idbi',
					'$idbi_awal',
					'$id_ruang',
					'$tanggal')";	$cek .= $aqry1;	
					$qry = mysql_query($aqry1);
				}
			}elseif($fmST == 1){						
				if($err==''){
						 
							$aqry2 = "UPDATE t_kir
				        	 set "." tgl = '$tanggal',
							 ref_idruang = '$id_ruang'".
						 	"WHERE Id='".$idplh."'";	$cek .= $aqry2;
							$qry = mysql_query($aqry2);

					}
			}else{
			if($err==''){ 

				}
			} //end else
					
			return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }
	
	function Hapus(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $cbid = $_REQUEST[$this->Prefix.'_cb']; $cek .= $cbid;
	 $cb = explode(" ", $cbid[0]);
	 $idplh =$cb[0]; $cek .= $idplh; //id_mutsasi
 	 // $idbi =$cb[1]; $cek .= $idbi; //idbi_baru
	 $cm=mysql_fetch_array(mysql_query("select * from t_kir order by Id DESC limit 0,1"));
	 if($idplh != $cm['Id']) $err="Hanya data terakhir yang bisa dihapus!";
	
		if($err==''){ 
			$aqry = "DELETE FROM t_kir WHERE Id='".$idplh."'";	$cek .= $aqry;	
			$qry = mysql_query($aqry);
			if($qry==FALSE) {
				$err="Gagal Hapus Data";	
			}else{
				//$err="Gagal Hapus Penggunaan";	
			}
		}
					
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);	
    }		
	
	function simpanPilihBarang(){
		 global $HTTP_COOKIE_VARS;
		 global $Main;
		 $uid = $HTTP_COOKIE_VARS['coID'];
		 $cek = ''; $err=''; $content=''; $json=TRUE;
		
		//$coDaftar = $HTTP_COOKIE_VARS['penatausaha_DaftarPilih'];$cek .=$coDaftar;

		//$ids= explode(',',$coDaftar); //$_POST['cidBI'];	//id bi barang
		$ids = $_REQUEST['cidBI'];
		//$id_mutasi = $_REQUEST['id_mutasi'];
		
		if($err=='' && $ids[0] == '') $err = 'Barang belum dipilih!';
		//cek buku_induk sudah usulan
		//$cbi = mysql_fetch_array(mysql_query("select * from penggunaan_det where ref_idbi='".$ids[0]."'")) ; 
		//$ct = mysql_fetch_array(mysql_query("select * from penggunaan where tahun='".$tahun_anggaran."'")) ;
		//if($err=='' && $cbi == TRUE && $ct == TRUE) $err = 'Barang pada tahun ini sudah usulan!';		
								
		if($err==''){
			$bi = mysql_fetch_array(mysql_query("select * from buku_induk where id='".$ids[0]."'")) ;
			$nb = mysql_fetch_array(mysql_query("select * from ref_barang where f='".$bi['f']."' and g='".$bi['g']."' and h='".$bi['h']."' and i='".$bi['i']."' and j='".$bi['j']."'")) ;
			$content->idbi=$bi['id'];
			$content->idbi_awal=$bi['idawal'];
			$content->kode_barang=$bi['f'].'.'.$bi['g'].'.'.$bi['h'].'.'.$bi['i'].'.'.$bi['j'];
			$content->nama_barang=$nb['nm_barang'];
			$content->noreg=$bi['noreg'];
			$content->thn_perolehan=$bi['thn_perolehan'];
			//$brg = mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,g,h,i,j)='".$bi['f'].$bi['g'].$bi['h'].$bi['i'].$bi['j']."'")) ;
			//$query="INSERT into mutasi_det (Id,idbi_asal,sesi,tgl_update,uid,status)
							//"."values('".$id_mutasi."','".$bi['id']."','',now(),'$uid','')"; $cek.=$query;
			//$result=mysql_query($query);				
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function autocomplete_stbarang_getdata(){
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$a_json = array();
		$a_json_row = array();
		$name_startsWith = $_REQUEST['name_startsWith'];
		$maxRows = $_REQUEST['maxRows'];
		//echo $name_startsWith
		$sql = "select Id,nama from ref_statusbarang2 where nama like '%".$name_startsWith."%' limit 0,$maxRows ";$cek.=$sql;		
		$rs = mysql_query($sql);
		while($row = mysql_fetch_assoc($rs)) {
			//$label =;
				//$ns=mysql_fetch_array(mysql_query("select * from ref_satuan where Id='".$row['ref_idsatuan']."'"));
				$a_json_row["id"] = $row['Id'];
				$a_json_row["value"] = $row['nama'];//.' '.$row['uraian'];
				$a_json_row["label"] =  $row['nama'];
					array_push($a_json, $a_json_row);
		}
		//$a_json = apply_highlight($a_json, $parts);
		$json = json_encode($a_json);
		echo $json;
		//$content = $json;
		//return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
		//echo $sql;
		//json_encode($a_json)
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
		
		case 'formBaru2':{				
			$fm = $this->setFormBaru2();				
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
		
		case 'formCariBarang':{				
			$fm = $this->setFormCariBarang();				
			$cek = $fm['cek'];
			$err = $fm['err'];
			$content = $fm['content'];												
		break;
		}
		
	   case 'autocomplete_stbarang_getdata':{
				$json = FALSE;
				$fm = $this->autocomplete_stbarang_getdata();
				break;
		}		
		
		case 'formCariPejabatPengadaan':{				
			$fm = $this->setFormCariPejabatPengadaan();				
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
	   	   
	   	case 'pilihbarang':{

		$ref_pilihbarang = $_REQUEST['daftarpilih'];
		 $kode_barang = explode(' ',$ref_pilihbarang);
		 $f=$kode_barang[0];	
		 $g=$kode_barang[1];
		 $h=$kode_barang[2];	
		 $i=$kode_barang[3];
		 $j=$kode_barang[4];
		 

		$get = mysql_fetch_array( mysql_query("SELECT
							`ref_barang_persediaan`.`nama_barang`, `ref_merk_persediaan`.`nama_merk`,
							`ref_type_persediaan`.`nama_type`, `ref_spec_persediaan`.`nama_spec`,
							`ref_satuan_persediaan`.`nama_satuan`, `dkbp_persediaan`.`Id`,
							`dkbp_persediaan`.`jumlah_disetujui`, `dkbp_persediaan`.`harga_dkbp`,
							`dkbp_persediaan`.`f`, `dkbp_persediaan`.`g`, `dkbp_persediaan`.`h`,
  							`dkbp_persediaan`.`i`, `dkbp_persediaan`.`j`, `dkbp_persediaan`.`satuan`
							FROM
							`ref_barang_persediaan` INNER JOIN
							`dkbp_persediaan` ON `ref_barang_persediaan`.`f` = `dkbp_persediaan`.`f` AND
							`ref_barang_persediaan`.`g` = `dkbp_persediaan`.`g` INNER JOIN
							`ref_merk_persediaan` ON `ref_merk_persediaan`.`h` = `dkbp_persediaan`.`h`
							INNER JOIN
							`ref_type_persediaan` ON `ref_type_persediaan`.`i` = `dkbp_persediaan`.`i`
							INNER JOIN
							`ref_spec_persediaan` ON `ref_spec_persediaan`.`j` = `dkbp_persediaan`.`j`
							INNER JOIN
							`ref_satuan_persediaan` ON `ref_satuan_persediaan`.`Id` =
							`dkbp_persediaan`.`satuan`
							WHERE
							`dkbp_persediaan`.`Id` = $ref_pilihbarang;"));
		$kb=$get['f'].'.'.$get['g'].'.'.$get['h'].'.'.$get['i'].'.'.$get['j'];
		$mts=$get['nama_merk'].' / '.$get['nama_type'].' / '.$get['nama_spec'];
		$content = array('f'=>$get['f'],
						'g'=>$get['g'],
						'h'=>$get['h'],
						'i'=>$get['i'],
						'j'=>$get['j'],
						'kode_barang'=>$kb,
						 'nama_barang'=>$get['nama_barang'],
						 'mts'=>$mts, 
						 'harga'=>$get['harga'],
						 'jml_kebutuhan'=>$get['jumlah_disetujui'],
						 'harga_dkbp'=>$get['harga_dkbp'],
						 'satuan'=>$get['satuan'],
						 'nama_satuan'=>$get['nama_satuan'],
						 'ref_id_dkbp'=>$ref_pilihbarang);	
		break;
	   }
	   
   		case 'simpanPilihBarang':{				
			$get= $this->simpanPilihBarang();
			$cek = $get['cek'];
			$err = $get['err'];
			$content = $get['content'];
			break;
		}	
			   
		case 'Hapus':{
			$get= $this->Hapus();
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
	
	function setPage_OtherScript(){
		$scriptload = 

					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".					
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<script src='js/jquery-ui.custom.js'></script>".		    
			 "<script type='text/javascript' src='js/perencanaan/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/ruang.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/pegawai.js' language='JavaScript' ></script>".
			"<script type='text/javascript' src='js/master/refstatusbarang/refstatusbarang.js' language='JavaScript' ></script>".
			"<script src='js/penatausaha.js' type='text/javascript'></script>".
			
			$scriptload;
	}
	
	//form ==================================
	function setFormBaru(){
		$cbid = $_REQUEST['rkb_cb'];
		$cek =$cbid[0];
				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		$cek.=$this->form_idplh;
		//get data
		$aqry = "select * from rkb where id='".$this->form_idplh."'"; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
	 	
		//query Ambil RKB
		//if($cp==TRUE){
		//	$fm['err']="Maaf data tidak bisa di edit";
		//}else{
			$fm = $this->setForm($dt);
		//}		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
	
	function setFormBaru2(){
		$dt=array();
		//$this->form_idplh ='';
		$this->form_fmST = 0;
		$dt['tgl'] = date("Y-m-d"); //set waktu sekarang
		$fm = $this->setForm2($dt);
		return	array ('cek'=>$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
   
  	function setFormEdit(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek =$cbid[0];
				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;
		//get data
		$aqry = "select * from v_kir where Id='".$this->form_idplh."'"; $cek.=$aqry;
		$dt = mysql_fetch_array(mysql_query($aqry));
	 	
		//query barang
		$cb=mysql_fetch_array(mysql_query("select * from ref_barang where f='".$dt['f']."' and g='".$dt['g']."' and h='".$dt['h']."' and i='".$dt['i']."' and j='".$dt['j']."'"));
		$dt['kode_barang']=$dt['f'].'.'.$dt['g'].'.'.$dt['h'].'.'.$dt['i'].'.'.$dt['j'];
		$dt['nama_barang']=$cb['nm_barang'];		

	 	//query ruang
		$cr=mysql_fetch_array(mysql_query("select * from ref_ruang where Id='".$dt['ref_idruang']."'"));	 
		$dt['kode_ruang']=$cr['p'].'.'.$cr['lantai'].'.'.$cr['q'];
		$dt['nama_ruang']=$cr['nm_ruang'];
		
		$dt['readonly']='readonly';
		$dt['disabled']='disabled';		
		//$dt['c'] = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		//$dt['d'] = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		//$dt['e'] = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		//if($cp==TRUE){
		//	$fm['err']="Maaf data tidak bisa di edit";
		//}else{
			$fm = $this->setForm($dt);
		//}
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setFormCariBarang(){
		$cek = ''; $err=''; $content=''; $json=TRUE;
		$cek = 'tes';
				
		$dt=array();
		$this->form_fmST = 0;
		//$dt['tgl_usul'] = date("Y-m-d"); //set waktu sekarang
		//$dt['sesi'] = gen_table_session('penghapusan_usul','uid'); //generate no sesi
		//$fm = $this->setFormCr($dt);
		
		$sw=$_REQUEST['sw'];
		$sh=$_REQUEST['sh'];
		$id_mutasi=$_REQUEST['id_mutasi'];
		
		$form_name = 'adminForm';	//nama Form			
		$this->form_width = $sw-50;
		$this->form_height = $sh-100;
		$this->form_caption = 'Cari Barang'; //judul form
		$this->form_fields = array(	
			'skpd' => array( 
				'label'=>'',
				'value'=>
					"<table width=\"200\" class=\"adminform\">	<tr>		
					<td width=\"200\" valign=\"top\">" . 					
						WilSKPD_ajx($this->Prefix.'CariSkpd','100%','100',TRUE,'','','','') . 
						//WilSKPD_ajx('Skpd') . 						
					"</td>" . 
					"</tr></table>", 
				'type'=>'merge'
			),			
			'div_detailcaribarang' => array( 
				'label'=>'',
				'value'=>"<div id='div_detailcaribarang' style='height:5px'></div>", 
				'type'=>'merge'
			)
		);
		
		//tombol
		$this->form_menubawah =
			//"<input type=hidden id='id_mutasi' name='id_mutasi' value='$id_mutasi'> ".
			"<input type='button' value='Pilih' onclick ='".$this->Prefix.".PilihBarang()' >&nbsp".
			"<input type='button' value='Close' onclick ='".$this->Prefix.".CloseCariBarang()' >";
		
		//$form = //$this->genForm();		
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
					,
					$this->form_menu_bawah_height,
					'',1
					).
				"</form>";
				
		$content = $form;
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
			
	function setForm($dt){	
	 global $HTTP_COOKIE_VARS;	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 
		
	 $json = TRUE;	//$ErrMsg = 'tes';
	 $get = mysql_fetch_array(mysql_query("select c, nm_skpd  from ref_skpd where c =".$dt['c']." and d=00 and e=00"));				
	 $get1 = mysql_fetch_array(mysql_query("select d, nm_skpd AS nm_unit from ref_skpd where c =".$dt['c']." and d=".$dt['d']." and e=00"));
	 $get2 = mysql_fetch_array(mysql_query("select e, nm_skpd AS nm_subunit from ref_skpd where c =".$dt['c']." and d=".$dt['d']." and e=".$dt['e'].""));
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 700;
	 $this->form_height = 140; 
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Kartu Inventaris Ruang - BARU';
	  }else{
		$this->form_caption = 'Kartu Inventaris Ruang - EDIT';	  	
	  }
	  			
 	    $username=$_REQUEST['username'];
		//query ref_batal
		$querySatuan = "SELECT Id,nama_satuan FROM ref_satuan_persediaan";
       //items ----------------------
		  $this->form_fields = array(									 
			'tanggal' => array( 
					'label'=>'Tanggal',
					 'labelWidth'=>100, 
					 'value'=>createEntryTgl3($dt['tgl'], 'tanggal', false,'tanggal bulan tahun (mis: 1 Januari 1998)')
									 			),									 
									 
			'nama_barang' => array( 
								'label'=>'Nama barang',
								'labelWidth'=>100, 
								'value'=>"<input type='text' name='kode_barang' value='".$dt['f'].'.'.$dt['g'].'.'.$dt['h'].'.'.$dt['i'].'.'.$dt['j']."' size='10px' id='kode_barang' readonly>
								<input type='text' name='nama_barang' value='".$dt['nama_barang']."' size='55px' id='nama_barang' readonly>&nbsp
								<input type='button' value='Cari' onclick ='".$this->Prefix.".CariBarang()' title='Cari Barang' ".$dt['disabled'].">"
									),
									
			'thn_perolehan' => array( 
								'label'=>'Tahun Perolehan',
								'labelWidth'=>100, 
								'value'=>"<input type='text' name='thn_perolehan' value='".$dt['thn_perolehan']."' maxlength='4' size='10px' id='thn_perolehan' readonly>" 
									 ),										
									 
			'noreg' => array( 
								'label'=>'No. Register',
								'labelWidth'=>100, 
								'value'=>"<input type='text' name='noreg' value='".$dt['noreg']."' maxlength='4' size='10px' id='noreg' readonly>" 
									 ),
									 
			'nama_ruang' => array( 
								'label'=>'Ruang',
								'labelWidth'=>100, 
								'value'=>"<input type='hidden' name='id_ruang' value='".$dt['ref_idruang']."' size='10px' id='id_ruang' readonly>
								<input type='text' name='kode_ruang' value='".$dt['kode_ruang']."' size='10px' id='kode_ruang' readonly>
								<input type='text' name='nama_ruang' value='".$dt['nama_ruang']."' size='55px' id='nama_ruang' readonly>&nbsp
								<input type='button' value='Cari' onclick ='".$this->Prefix.".CariRuang()' title='Cari Ruang'>"
									),									 			 		
			
			);
		//tombol
		$this->form_menubawah =	
			"<input type='hidden' id='c' name='c' value='".$dt['c']."'>".
			"<input type='hidden' id='d' name='d' value='".$dt['d']."'>".
			"<input type='hidden' id='e' name='e' value='".$dt['e']."'>".
			"<input type='hidden' id='e1' name='e1' value='".$dt['e1']."'>".
			"<input type='hidden' id='idbi' name='idbi' value='".$dt['idbi']."'>".		
			"<input type='hidden' id='idbi_awal' name='idbi_awal' value='".$dt['idbi_awal']."'>".		
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Batal kunjungan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function setForm2($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 450;
	 $this->form_height = 50;
	  if ($this->form_fmST==0) {
		$this->form_caption = 'Status Barang - Baru';
		$nip	 = '';
	  }else{
		$this->form_caption = 'Status Barang - Edit';			
		$Id = $dt['Id'];			
	  }
	    //ambil data trefditeruskan
	  	$query = "" ;$cek .=$query;
	  	$res = mysql_query($query);
		
	 //items ----------------------
	  $this->form_fields = array(
			'status_barang' => array( 
								'label'=>'Status Barang',
								'labelWidth'=>100, 
								'value'=>"
								<input type='text' name='status_barang' id='status_barang' value='".$dt['nama']."' style='width:200px'>
								<input type='hidden' id='id_status_barang' name='id_status_barang' value='".$dt['Id']."' title='penyedia_barang'>
								<input type='button' name='reset' value='Reset' onClick='document.getElementById(\"status_barang\").value=\"\";document.getElementById(\"id_status_barang\").value=\"\";'>
								<input type='button' value='Cari' id='cari' onclick ='".$this->Prefix.".Cari()' title='Cari' >",
								'type'=>'',
								'row_params'=>"valign='top'",
								'param'=> ""
									 ),		
	
			);
		//tombol
		$this->form_menubawah =
			"<input type='hidden' id='mode' name='mode' value='".$dt['mode']."'>".
			"<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Simpan' >".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".CloseCari()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}	
		
	//daftar =================================
	
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
					 "<thead>
					 <tr>
				  	   <th class='th01' width='20' rowspan='2'>No.</th>
				  	   $Checkbox		
				   	   <th class='th01' width='100' >Kode Barang</th>
					   <th class='th01' width='200' >Nama Barang</th>	   	   	   
					   <th class='th01' width='200' >Unit Kerja</th>
					   <th class='th01' width='75' >Jumlah</th>
					   <th class='th01' width='75' >Kuantitas</th>
					   <th class='th01' width='75' >Satuan</th>
					   <th class='th01' width='150' >Harga Satuan</th>
					   <th class='th01' width='150' >Jumlah Harga</th>					   					   
					</tr>
					</thead>";
	
		return $headerTable;
	}	
	
	/*function setNavAtas(){
	    global $Menu;
		return $Menu->navAtas_Pengadaan(2,1);

	}*/

	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 global $Main;

	 $c=mysql_fetch_array(mysql_query("select * from ref_skpd where c=".$isi['c']." and d=00 and e=00 and e1=00"));
	 $d=mysql_fetch_array(mysql_query("select * from ref_skpd where c=".$isi['c']." and d=".$isi['d']." and e=00 and e1=00"));
	 $e=mysql_fetch_array(mysql_query("select * from ref_skpd where c=".$isi['c']." and d=".$isi['d']." and e=".$isi['e']." and e1=00"));
	 $e1=mysql_fetch_array(mysql_query("select * from ref_skpd where c=".$isi['c']." and d=".$isi['d']." and e=".$isi['e']." and e=".$isi['e1'].""));
	 $kb=mysql_fetch_array(mysql_query("select * from ref_barang where f=".$isi['f']." and g=".$isi['g']." and h=".$isi['h']." and i=".$isi['i']." and j=".$isi['j'].""));	 
	 //$ka=mysql_fetch_array(mysql_query("select * from ref_jurnal where ka='".$kb['ka']."' and kb='".$kb['kb']."' and kc='".$kb['kc']."' and kd='".$kb['kd']."' and ke='".$kb['ke']."'"));	 
	 $kode_barang=$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'];
 	 //$akun=$kb['ka'].'.'.$kb['kb'].'.'.$kb['kc'].'.'.$kb['kd'].'.'.$kb['ke'].'<br>'.$ka['nm_account'];
 	 //$kode_ruang=$isi['p'].'.'.$isi['lantai'].'.'.$isi['q'];
	 $skpd=$isi['c'].'.'.$isi['d'].'.'.$isi['e'].'.'.$isi['e1'].' /</br>'.$c['nm_skpd'].'<br>'.$d['nm_skpd'].'<br>'.$e['nm_skpd'].'</br>'.$e['nm_skpd'];
		
	 $Koloms = array();
	 $Koloms[] = array('align="center" width="20"', $no.'.' );
	 if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
  	 $Koloms[] = array('align="center" "',$kode_barang);
	 $Koloms[] = array('align="left" ',$kb['nm_barang']);
 	 $Koloms[] = array('align="left" ',$skpd);	 	 	 	 	 	 	 	 
 	 $Koloms[] = array('align="right" ',$isi['jml_barang']);	 	 	 	 
 	 $Koloms[] = array('align="right" ',$isi['kuantitas']);	 	 	 	 
 	 $Koloms[] = array('align="left" ',$isi['satuan']);	 	 	 	 	 	 	 	 
 	 $Koloms[] = array('align="right" ',number_format($isi['harga'],2,',','.'));	 	 	 	 
 	 $Koloms[] = array('align="right" ',number_format($isi['jml_harga'],2,',','.'));	 		  	 	  	 	 	 	 	 	 	 	 	 	 
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
		global $Ref, $Main;
		
		
		//data cari ----------------------------
		
	 	$arrCari = array(
			//array('selectAll','Semua'),
			array('selectKodeBarang','Kode Barang'),
			array('selectNamaBarang','Nama Barang'),	
			);
			
 		//get pilih bidang
		$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD');
		$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		 
		 //$fmPILCARI = cekPOST('fmPILCARI');
		 //$fmPILCARIvalue = cekPOST('fmPILCARIvalue');
		 //query combo box
		 $queryBidang = "SELECT Id,nama_satuan FROM ref_satuan_persediaan";
		 $querySKPD = "SELECT Id,nama_satuan FROM ref_satuan_persediaan";
		 //combo box 
		 $BIDANG=cmbQuery('fmBidang',$dt['c'],$queryBidang,'','-- PILIH BIDANG --');	 
		 $SKPD=cmbQuery('fmSKPD',$dt['d'],$querySKPD,'','-- PILIH SKPD --');	
		 $Program=cmbQuery('fmProgram',$dt['c'],$queryProgram,'','-- PILIH Program --');	 
		 $kegiatan=cmbQuery('fmKegiatan',$dt['d'],$queryKegiatan,'','-- PILIH Kegiatan --');	 		  		 
		 //get cari
		 $fmKodeRuang = cekPOST('fmKodeRuang');
		 $fmNamaRuang = cekPOST('fmNamaRuang');
		 $fmKodeBarang = cekPOST('fmKodeBarang');
		 $fmTahunPerolehan = cekPOST('fmTahunPerolehan');
		 $fmNoReg = cekPOST('fmNoReg');
		 $fmIdBarang = cekPOST('fmIdBarang');
		 $fmIdAwal = cekPOST('fmIdAwal');
		 $idrka = cekPOST('idrka');		 
		//data order ------------------------------
		$arrOrder = array(
			array('1','Kode Barang'),
			array('2','Nama Barang'),	
			array('3','Tahun Anggaran'),		
		);
		
		//get select Order1
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');
		
		//get select Order2
		$fmORDER2 = cekPOST('fmORDER2');
		$fmDESC2 = cekPOST('fmDESC2');
		
		//get select Order3
		$fmORDER3 = cekPOST('fmORDER3');
		$fmDESC3 = cekPOST('fmDESC3');
		
		//thn terakhir
		//$get = mysql_fetch_array(mysql_query(
		//	"select max(tahun) as maxthn from $this->TblName "
		//));
		//$fmFiltThnAnggaran = $get['maxthn'];
			
		$TampilOpt ="<input type='hidden' name='idrka' id='idrka' value='$idrka'>";
			/*"<table width=\"100%\" class=\"adminform\">	<tr>		
			<td width=\"100%\" valign=\"top\">" . 
				//WilSKPD_ajx($this->Prefix) . 
				WilSKPD_ajx($this->Prefix.'Skpd') . 
			"</td>
			<td >" . 		
			"</td></tr>
			<!--<tr><td>
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>			-->
			</table>".
			/*genFilterBar(
				array(
					cmbArray('fmPILCARI',$fmPILCARI,$arrCari,'Cari Data','').
					"&nbsp;<input type='text' value='$fmPILCARIvalue' id='fmPILCARIvalue' name='fmPILCARIvalue'>" 
				)	
				, $this->Prefix.".refreshList(true)",TRUE, 'Cari').*/
			/*genFilterBar(
				array(							
					//'Urutkan : '.cmbArray('fmORDER1',$fmORDER1,$arrOrder,'--','').
					"<table>
						<tr>
							<td width='75'>BIDANG</td>
							<td width='25'> : </td>
							<td>$BIDANG</td>
						</tr>
						<tr>
							<td>SKPD</td>
							<td> : </td>
							<td>$SKPD</td>
						</tr>
						<tr>
							<td>Tahun</td>
							<td> : </td>
							<td><input type='text' style='width:100;' value='$fmTahun' id='fmTahun' name='fmTahun'></td>
						</tr>
					</table>"
					),				
				$this->Prefix.".refreshList(true)",FALSE).
			genFilterBar(
				array(							
					"<table>
						<tr>
							<td width='75'>Program</td>
							<td width='25'> : </td>
							<td>$Program</td>
						</tr>
						<tr>
							<td>Kegiatan</td>
							<td> : </td>
							<td>$kegiatan</td>
						</tr>
						<tr>
							<td>Nama Akun</td>
							<td> : </td>
							<td><input type='text' style='width:100;' value='$fmTahun' id='fmTahun' name='fmTahun' readonly>
								&nbsp;<input type='text' style='width:150;' value='$fmTahun' id='fmTahun' name='fmTahun' readonly>
								&nbsp;<input type='button' id='btCari' value='Cari' onclick='".$this->Prefix.".refreshList(true)'>
								&nbsp;<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'></td>
						</tr>
					</table>"
					),				
				$this->Prefix.".refreshList(true)",FALSE);*/
		
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID'];
		
		 $fmKodeRuang = $_REQUEST['fmKodeRuang'];
		 $fmNamaRuang = $_REQUEST['fmNamaRuang'];
		 $fmKodeBarang = $_REQUEST['fmKodeBarang'];
		 $fmTahunPerolehan = $_REQUEST['fmTahunPerolehan'];
		 $fmNoReg = $_REQUEST['fmNoReg'];
		 $fmIdBarang = $_REQUEST['fmIdBarang'];
		 $fmIdAwal = $_REQUEST['fmIdAwal']; 
		 $idrka = $_REQUEST['idrka']; 
		 
		//kondisi -----------------------------------				
		$arrKondisi = array();		
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];			
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST($this->Prefix.'SkpdfmSKPD');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST($this->Prefix.'SkpdfmUNIT');
		$fmSUBUNIT = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST($this->Prefix.'SkpdfmSUBUNIT');		
		
		switch($fmPILCARI){
			case 'selectKodeBarang': $arrKondisi[] = " concat(f,g) like '%$fmPILCARIvalue%'"; break;		 	
			case 'selectNamaBarang': $arrKondisi[] = " nama_barang like '%$fmPILCARIvalue%'"; break;					 	
		}
						
		if(!($fmSKPD=='' || $fmSKPD=='00') ) $arrKondisi[] = "c='$fmSKPD'";
		if(!($fmUNIT=='' || $fmUNIT=='00') ) $arrKondisi[] = "d='$fmUNIT'";
		if(!($fmSUBUNIT=='' || $fmSUBUNIT=='00') ) $arrKondisi[] = "e='$fmSUBUNIT'";
		if(!empty($fmKodeRuang)) $arrKondisi[] = "concat(p,lantai,q) like '%$fmKodeRuang%'";
		if(!empty($fmNamaRuang)) $arrKondisi[] = "nm_ruang like '%$fmNamaRuang%'";	
		if(!empty($fmKodeBarang)) $arrKondisi[] = "concat(f,g,h,i,j) like '%$fmKodeBarang%'";	
		if(!empty($fmTahunPerolehan)) $arrKondisi[] = "thn_perolehan='$fmTahunPerolehan'";	
		if(!empty($fmNoReg)) $arrKondisi[] = "noreg='$fmNoReg'";	
		if(!empty($fmIdBarang)) $arrKondisi[] = "idbi='$fmIdBarang'";	
		if(!empty($fmIdAwal)) $arrKondisi[] = "idbi_awal='$fmIdAwal'";
		if(!empty($idrka)) $arrKondisi[] = "id in ($idrka)";		
		/*if(empty($fmGOLONGAN) && empty($fmSUBGOLONGAN) && empty($fmMERK) && empty($fmTYPE))
		{
			$arrKondisi[]= "f !=00 and g=00 and h=00 and i=00 and j=00";
		}
		elseif(!empty($fmGOLONGAN) && empty($fmSUBGOLONGAN) && empty($fmMERK) && empty($fmTYPE))
		{
			$arrKondisi[]= "f =$fmGOLONGAN and g!=00 and h=00 and i=00 and j=00";
		}
		elseif(!empty($fmGOLONGAN) && !empty($fmSUBGOLONGAN) && empty($fmMERK) && empty($fmTYPE))
		{
			$arrKondisi[]= "f =$fmGOLONGAN and g=$fmSUBGOLONGAN and h!=00 and i=00 and j=00";
		}
		elseif(!empty($fmGOLONGAN) && !empty($fmSUBGOLONGAN) && !empty($fmMERK) && empty($fmTYPE))
		{
			$arrKondisi[]= "f =$fmGOLONGAN and g=$fmSUBGOLONGAN and h=$fmMERK and i!=00 and j=00";
		}
		elseif(!empty($fmGOLONGAN) && !empty($fmSUBGOLONGAN) && !empty($fmMERK) && !empty($fmTYPE))
		{
			$arrKondisi[]= "f =$fmGOLONGAN and g=$fmSUBGOLONGAN and h=$fmMERK and i=$fmTYPE and j!=00";
		}*/
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '1': $arrOrders[] = " concat(f,g,h,i,j) $Asc1 " ;break;
			case '2': $arrOrders[] = " nama_barang $Asc1 " ;break;		
		
		}

			$Order= join(',',$arrOrders);	
			$OrderDefault = '';// Order By no_terima desc ';
			$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//}
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
	
}
$RKADetail = new RKADetailObj();

?>