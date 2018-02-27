<?php

class refstdbutuhObj  extends DaftarObj2{	
	var $Prefix = 'refstdbutuh';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = "ref_std_kebutuhan "; //daftar
	var $TblName_Hapus = 'ref_std_kebutuhan';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('c1', 'c', 'd', 'e', 'e1', 'f', 'g', 'h', 'i', 'j');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Data';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'Daftar Standar Kebutuhan Barang Maksimal';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'refstdbutuhForm'; 	
	var $kode_skpd = '';
	var $username = '';
			
	function setTitle(){
		return 'Standar Kebutuhan Barang Maksimal';
	}
	function setMenuEdit(){
		return
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Baru()","new_f2.png","Baru",'Baru')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".editData()","edit_f2.png","Edit", 'Edit')."</td>".
			"<td>".genPanelIcon("javascript:".$this->Prefix.".Hapus()","delete_f2.png","Hapus", 'Hapus').
			"</td>";
	}
	function setMenuView(){
		return "";
	}
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		
		//$fmSKPD = cekPOST($this->Prefix.'SkpdfmSKPD'); //echo 'fmskpd='.$fmSKPD;
		//$fmUNIT = cekPOST($this->Prefix.'SkpdfmUNIT');
		//$fmSUBUNIT = cekPOST($this->Prefix.'SkpdfmSUBUNIT');
		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>";	
			/*"<table width=\"100%\" border=\"0\">
				<tr>
					<td class=\"subjudulcetak\">".PrintSKPD2($fmSKPD, $fmUNIT, $fmSUBUNIT)."</td>
				</tr>
			</table><br>";*/
	}		
	
	//function setPage_IconPage(){		return 'images/masterData_ico.gif';	}	
	function simpan(){
	 global $HTTP_COOKIE_VARS;
	 global $Main;
	 $uid = $HTTP_COOKIE_VARS['coID'];
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	 //get data -----------------
	 $fmST = $_REQUEST[$this->Prefix.'_fmST'];
	 $idplh = $_REQUEST[$this->Prefix.'_idplh'];
	 foreach ($_REQUEST as $key => $value) { 
		  $$key = $value; 
	 } 
	 if(mysql_num_rows(mysql_query("select * from temp_standar_kebutuhan where username = '$this->username' and jumlah !='0'")) == 0){
	 	$err ="Jumlah kosong !";
	 }
	 


				if($err==''){ 
						$getData = mysql_query("select * from temp_standar_kebutuhan where username = '$this->username' and jumlah !='0'");
						while($rows = mysql_fetch_array($getData)){
								if(mysql_num_rows(mysql_query("select * from $this->TblName where f = '".$rows['f']."' and g = '".$rows['g']."' and h = '".$rows['h']."' and i = '".$rows['i']."' and j = '".$rows['j']."'   ")) == 0 ){
									$data = array ('c1' => $c1,
									   'c' => $c,
									   'd' => $d,
									   'e' => $e,
									   'e1' => $e1,
									   'f1' => '0',
									   'f2' => '0',
									   'f' => $rows['f'],
									   'g' => $rows['g'],
									   'h' => $rows['h'],
									   'i' => $rows['i'],
									   'j' => $rows['j'],
									   'jumlah' => $rows['jumlah']
									   );
									$query = VulnWalkerInsert("ref_std_kebutuhan",$data);
									mysql_query($query);
								}else{
									 $data = array (
									   'jumlah' => $rows['jumlah']
									   );
									$query = VulnWalkerUpdate("ref_std_kebutuhan",$data," f = '".$rows['f']."' and g = '".$rows['g']."' and h = '".$rows['h']."' and i = '".$rows['i']."' and j = '".$rows['j']."' and c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'");
									mysql_query($query);

								}


						}
						
							
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

		case 'saveData':{				
			foreach ($_REQUEST as $key => $value) { 
				 $$key = $value; 
			}
			$data = array('jumlah' => $jumlahBarang);
			$query = VulnWalkerUpdate($this->TblName,$data,"concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) = '$kode'");
			mysql_query($query);

		break;
		}
		case 'editData':{		
			$cbid = $_REQUEST[$this->Prefix.'_cb'];	
			$fm = $this->editData($cbid[0]);				
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
			 "<script type='text/javascript' src='js/master/refstdbutuh/refstdbutuh.js' language='JavaScript' ></script>".		
			 "<script type='text/javascript' src='js/master/refstdbutuh/listBarangMax.js' language='JavaScript' ></script>".		
			$scriptload;
	}
	
	//form ==================================
	function setFormBaru(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$dt=array();
		
		$c1 = $_REQUEST[$this->Prefix.'SkpdfmUrusan'];
		$c = $_REQUEST[$this->Prefix.'SkpdfmSKPD'];
		$d = $_REQUEST[$this->Prefix.'SkpdfmUNIT'];
		$e = $_REQUEST[$this->Prefix.'SkpdfmSUBUNIT'];
		$e1 = $_REQUEST[$this->Prefix.'SkpdfmSEKSI'];
		
		$dt['c1'] = $c1; 
		$dt['c'] = $c; 
		$dt['d'] = $d; 
		$dt['e'] = $e; 
		$dt['e1'] = $e1;
		//if(mysql_num_rows(mysql_query("select * from temp_standar_kebutuhan where username = '$this->username'")) == 0){
			//	$this->copyDataBarang();
		//	}
		mysql_query("delete from temp_standar_kebutuhan where username = '$this->username'");

		$cek =$cbid[0];				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 0;
		$fm = $this->setForm($dt);		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}	
   
  	function setFormEdit(){
		$cbid = $_REQUEST[$this->Prefix.'_cb'];
		$cek =$cbid[0];				
		$this->form_idplh = $cbid[0];
		$kode = explode(' ',$this->form_idplh);
		$this->form_fmST = 1;

		$aqry = "select * from ref_std_kebutuhan where concat(c1,' ',c,' ',d,' ',e,' ',e1,' ',f,' ',g,' ',h,' ',i,' ',j) ='".$this->form_idplh."' "; $cek.=$aqry;
		

		$dt = mysql_fetch_array(mysql_query($aqry));
		$fm = $this->setForm($dt);
		
		
		return	array ('cek'=>$cek.$fm['cek'], 'err'=>$fm['err'], 'content'=>$fm['content']);
	}
	
	function setForm($dt){	
	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 
		
	 $json = TRUE;	//$ErrMsg = 'tes';
	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 900;
	 $this->form_height = 200;
		$this->form_caption = 'BARU';
		

		foreach ($_REQUEST as $key => $value) { 
				  $$key = $value; 
			}

		$getNamaUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$refstdbutuhSkpdfmUrusan' and c='00' and d='00' and e='00' and e1='000'"));
		$getNamaBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$refstdbutuhSkpdfmUrusan' and c='$refstdbutuhSkpdfmSKPD' and d='00' and e='00' and e1='000'"));
		$getNamaSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$refstdbutuhSkpdfmUrusan' and c='$refstdbutuhSkpdfmSKPD' and d='$refstdbutuhSkpdfmUNIT' and e='00' and e1='000'"));
		$getNamaUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$refstdbutuhSkpdfmUrusan' and c='$refstdbutuhSkpdfmSKPD' and d='$refstdbutuhSkpdfmUNIT' and e='$refstdbutuhSkpdfmSUBUNIT' and e1='000'"));
		$getNamaSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$refstdbutuhSkpdfmUrusan' and c='$refstdbutuhSkpdfmSKPD' and d='$refstdbutuhSkpdfmUNIT' and e='$refstdbutuhSkpdfmSUBUNIT' and e1='$refstdbutuhSkpdfmSEKSI'"));

		$urusan = $getNamaUrusan['nm_skpd'];
		$bidang = $getNamaBidang['nm_skpd'];
		$skpd = $getNamaSKPD['nm_skpd'];
		$unit = $getNamaUnit['nm_skpd'];
		$subUnit = $getNamaSubUnit['nm_skpd'];

	  				
       //items ----------------------
		  $this->form_fields = array(
		  
		   	'infoSKPD' => array( 
						'label'=>'',
						'value'=>
								'<div class="FilterBar"><table style="width:100%">
								<tbody>
								<tr>
								<td style="width:170px;">URUSAN</td>
								<td style="
								    width: 20px;
								    height: 20px;
								">:</td>
								<td>'.$urusan.'</td>
								</tr>
								<tr>
								<td style="width:170px;">BIDANG</td>
								<td>:</td>
								<td>'.$bidang.'</td>
								</tr>
								<tr>
								<td style="width:170px;">SKPD</td>
								<td>:</td>
								<td>'.$skpd.'</td>
								</tr>
								<tr>
								<td style="width:170px;">UNIT</td>
								<td>:</td>
								<td>'.$unit.'</td>
								</tr>
								<tr>
								<td style="width:170px;">SUB UNIT</td>
								<td>:</td>
								<td>'.$subUnit.'</td>
								</tr>
								</tbody></table></div>'
							, 
							
						'type'=>'merge'
					 ),
			'asdas' => array( 
						'label'=>'',
						'value'=>"
						
						<div id='listBarang' style='height:5px'>
							"."<div id='listBarangMax_cont_title' style='position:relative'></div>".
			"<div id='listBarangMax_cont_opsi' style='position:relative'>".
			"</div>".
			"<div id='listBarangMax_cont_daftar' style='position:relative'></div>".
			"<div id='listBarangMax_cont_hal' style='position:relative'></div>"."
						</div>", 
							
						'type'=>'merge'
					 ),
			);
		//tombol
		$this->form_menubawah =	
			"
			<input type='hidden' id ='c1' name ='c1' value='$refstdbutuhSkpdfmUrusan'>
			<input type='hidden' id ='c' name ='c' value='$refstdbutuhSkpdfmSKPD'>
			<input type='hidden' id ='d' name ='d' value='$refstdbutuhSkpdfmUNIT'>
			<input type='hidden' id ='e' name ='e' value='$refstdbutuhSkpdfmSUBUNIT'>
			<input type='hidden' id ='e1' name ='e1' value='$refstdbutuhSkpdfmSEKSI'>

			<input type='button' value='Simpan' onclick ='".$this->Prefix.".Simpan()' title='Batal kunjungan' >&nbsp &nbsp ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm2();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	function genForm2($withForm=TRUE){	
		$form_name = 'listBarangMaxForm';	
				
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
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	 "<thead>
	 <tr>
  	   <th class='th01' width='20' >No.</th>
  	   $Checkbox	
   	   <th class='th01' align='center' width='100'>KODE BARANG</th>
	   <th class='th01' align='center' width='900'>NAMA BARANG</th>	   	   	   
   	   <th class='th01' align='center' width='100'>SATUAN</th>
	   <th class='th01' align='center' width='80'>JUMLAH</th>	
	   <th class='th01' align='center' width='300'>KETERANGAN</th>	
	   </tr>
	   </thead>";
	
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	
	
	 $Koloms = array();
	 $Koloms[] = array('align="center" width="20"', $no.'.' );
	 if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 
	 
	 $Koloms[] = array('align="center" width="100" ',$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j']);
	 
	 $kodeBarang =$isi['f'].".".$isi['g'].".".$isi['h'].".".$isi['i'].".".$isi['j'] ;
	 $syntax = "select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'";
	 $getBarang = mysql_fetch_array(mysql_query($syntax));
 	 $Koloms[] = array('align="left"',$getBarang['nm_barang']);	 	 	 	 
	 $Koloms[] = array('align="left" ',$getBarang['satuan']);
 	 $Koloms[] = array('align="right" ',number_format($isi['jumlah'],0,',','.'));
 	 $kodeSKPD = $isi['c1'].".".$isi['c'].".".$isi['d'].".".$isi['e'].".".$isi['e1'];
	 $getSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where concat(c1,'.',c,'.',d,'.',e,'.',e1) = '$kodeSKPD'"));
	 $Koloms[] = array('align="left" ',$getSubUnit['nm_skpd']);	 	
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main,  $HTTP_COOKIE_VARS;
	
	
	$fmKODE = $_REQUEST['fmKODE'];
	$fmBARANG = $_REQUEST['fmBARANG'];
	 $arr = array(
			//array('selectAll','Semua'),
			array('selectfg','Kode Barang'),
			array('selectbarang','Nama Barang'),	
			);
		
		
	//data order ------------------------------
	 $arrOrder = array(
	  	         array('1','Kode Barang'),
			     array('2','Nama Barang'),	
	 );	
	 
	 if($Main->WITH_THN_ANGGARAN){
		$aqry1 = "select Max(thn_akun) as thnMax from ref_jurnal where 
				thn_akun<=$fmThnAnggaran";
				$qry1=mysql_query($aqry1);			
				$qry_jurnal=mysql_fetch_array($qry1);
				$thn_akun=$qry_jurnal['thnMax'];
				//$arrKondisi[] = " thn_akun = '$thn_akun'";														
		$vthnakun = " and thn_akun=$thn_akun ";
			
	}	
	 
				
	$TampilOpt = 
			//"<tr><td>".	
			"<table width=\"100%\" class=\"adminform\">	<tr>		
			<td width=\"100%\" valign=\"top\">" . 
				WilSKPD_ajxVW("refstdbutuhSkpd") . 
			"</td>
			<td >" . 		
			"</td></tr>
			<tr><td>
				
			</td></tr>			
			</table>".
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Kode Barang : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' maxlength='' size=20px>&nbsp
				Nama Barang : <input type='text' id='fmBARANG' name='fmBARANG' value='".$fmBARANG."' size=30px>&nbsp".
				"<input type='hidden' id='filterAkun' name='filterAkun' value='".$filterAkun."'>".
				"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
			</table>".
			"</div>";		
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID  = $_COOKIE['coID']; 
		$c1   = $_REQUEST['refstdbutuhSkpdfmUrusan'];
		$c    = $_REQUEST['refstdbutuhSkpdfmSKPD'];
		$d    = $_REQUEST['refstdbutuhSkpdfmUNIT'];
		$e    = $_REQUEST['refstdbutuhSkpdfmSUBUNIT'];
		$e1   = $_REQUEST['refstdbutuhSkpdfmSEKSI'];	
			$fmKODE = $_REQUEST['fmKODE'];
	$fmBARANG = $_REQUEST['fmBARANG'];
			
		$arrKondisi = array();		
		
		if(!empty($c1) && $c1!="0" ){
			$arrKondisi[] = "c1 = $c1";
		}else{
			$c = "";
		}
		if(!empty($c ) && $c!="00"){
			$arrKondisi[] = "c = $c";
		}else{
			$d = "";
		}
		if(!empty($d) && $d!="00"){
			$arrKondisi[] = "d = $d";
		}else{
			$e = "";
		}
		if(!empty($e) && $e!="00"){
			$arrKondisi[] = "e = $e";
		}else{
			$e1 = "";
		}
		if(!empty($e1) && $e1!="000")$arrKondisi[] = "e1 = $e1";
 		if(empty($fmKODE)){
			
		}else{
			$arrKondisi[]= "concat(ref_std_kebutuhan.f,'.',ref_std_kebutuhan.g,'.',ref_std_kebutuhan.h,'.',ref_std_kebutuhan.i,'.',ref_std_kebutuhan.j) like '$fmKODE%'";
		}
		if(empty($fmBARANG)){
			
		}else{
			$exc = mysql_query("select concat(f,'.',g,'.',h,'.',i,'.',j) as kodeMix from ref_barang where nm_barang like '%$fmBARANG%' and j !='000'");
			$connn = array();
			while($rows = mysql_fetch_array($exc)){
				$connn[] = " concat(f,'.',g,'.',h,'.',i,'.',j) = '".$rows['kodeMix']."'";
			}
			
			if(sizeof($jsjs) != 1){
				$jsjs = join(' or ',$connn);
				$arrKondisi[] = "( $jsjs )";
			}else{
				$arrKondisi[] = $connn[0];
			}
			
		}
	
		
		$Kondisi= join(' and ',$arrKondisi);	
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();

		$arrOrders[] = " c1,c,d,e,e1,concat(ref_std_kebutuhan.f1,'.',ref_std_kebutuhan.f2,'.',ref_std_kebutuhan.f,'.',ref_std_kebutuhan.g,'.',ref_std_kebutuhan.h,'.',ref_std_kebutuhan.i,'.',ref_std_kebutuhan.j) ASC " ;
			

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

	function copyDataBarang(){
		$getAllBarang = mysql_query("select * from ref_barang where j!='000'");
		while($rows = mysql_fetch_array($getAllBarang)){
			foreach ($rows as $key => $value) { 
				  $$key = $value; 
			 } 
			 $kodeBarang =$f.".".$g.".".$h.".".$i.".".$j;
			 if(mysql_num_rows(mysql_query("select * from temp_standar_kebutuhan where username = '$this->username' and concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang'")) == 0){
			 		$data = array(
			 						"f" => $f,
			 						"g" => $g,
			 						"h" => $h,
			 						"i" => $i,
			 						"j" => $j,
			 						'jumlah' => '0',
			 						'username' => $this->username
			 					  );
			 		$query = VulnWalkerInsert('temp_standar_kebutuhan',$data);
			 		mysql_query($query);
			 }

		}
	}	

	function editData($id){	

	 global $SensusTmp;
	 $cek = ''; $err=''; $content=''; 		
	 $json = TRUE;	//$ErrMsg = 'tes';	 	
	 $form_name = $this->Prefix.'_form';				
	 $this->form_width = 900;
	 $this->form_height = 200;
	
		$this->form_caption = 'Edit';	
		$kode = explode(' ', $id);
		$c1 = $kode[0];
		$c = $kode[1];
		$d = $kode[2];
		$e = $kode[3];
		$e1 = $kode[4];

		$f = $kode[5];
		$g = $kode[6];
		$h = $kode[7];
		$i = $kode[8];
		$j = $kode[9];

		$kodeBarang = $f.".".$g.".".$h.".".$i.".".$j;

		$getNamaBarang =  mysql_fetch_array(mysql_query("select * from ref_barang where concat(f,'.',g,'.',h,'.',i,'.',j) = '$kodeBarang' "));
		$namaBarang = $getNamaBarang['nm_barang'];
		$satuanBarang = $getNamaBarang['satuan'];	

		$getNamaUrusan = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='00' and d='00' and e='00' and e1='000'"));
		$getNamaBidang = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='00' and e='00' and e1='000'"));
		$getNamaSKPD = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='00' and e1='000'"));
		$getNamaUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='000'"));
		$getNamaSubUnit = mysql_fetch_array(mysql_query("select * from ref_skpd where c1='$c1' and c='$c' and d='$d' and e='$e' and e1='$e1'"));

		$urusan = $getNamaUrusan['nm_skpd'];
		$bidang = $getNamaBidang['nm_skpd'];
		$skpd = $getNamaSKPD['nm_skpd'];
		$unit = $getNamaUnit['nm_skpd'];
		$subUnit = $getNamaSubUnit['nm_skpd'];

		$primaryKey = $c1.".".$c.".".$d.".".$e.".".$e1.".".$f.".".$g.".".$h.".".$i.".".$j;

		$getData = mysql_fetch_array(mysql_query("select * from $this->TblName where concat(c1,'.',c,'.',d,'.',e,'.',e1,'.',f,'.',g,'.',h,'.',i,'.',j) ='$primaryKey'"));
		$jumlahBarang = $getData['jumlah'];

       //items ----------------------
		 $this->form_fields = array(
			'urusan' => array( 
								'label'=>'URUSAN',
								'labelWidth'=>200, 
								'value'=>"$urusan" 
									 ),
						 
			'bidang' => array( 
								'label'=>'BIDANG',
								'labelWidth'=>200, 
								'value'=>"$bidang" 
									 ),
			'skpd' => array( 
								'label'=>'SKPD',
								'labelWidth'=>200, 
								'value'=>"$skpd" 
									 ),
			'skpd' => array( 
								'label'=>'SKPD',
								'labelWidth'=>200, 
								'value'=>"$skpd" 
									 ),
			'unit' => array( 
								'label'=>'UNIT',
								'labelWidth'=>200, 
								'value'=>"$unit" 
									 ),
			'subUnit' => array( 
								'label'=>'SUB UNIT',
								'labelWidth'=>200, 
								'value'=>"$subUnit" 
									 ),
			'kodeBarang' => array( 
								'label'=>'KODE BARANG',
								'labelWidth'=>200, 
								'value'=>"$kodeBarang" 
									 ),
			'namaBarang' => array( 
								'label'=>'NAMA BARANG',
								'labelWidth'=>200, 
								'value'=>"$namaBarang" 
									 ),
			'satuanBarang' => array( 
								'label'=>'SATUAN',
								'labelWidth'=>200, 
								'value'=>"$satuanBarang" 
									 ),
			'jumlahBarang' => array( 
								'label'=>'JUMLAH BARANG',
								'labelWidth'=>200, 
								'value'=>"<input type='text' name='jumlahBarang' id='jumlahBarang' value='$jumlahBarang' onkeypress='return event.charCode >= 48 && event.charCode <= 57'>" 
									 ),
			  
			);
		//tombol
		$this->form_menubawah =	
			"
			<input type='hidden' id ='c1' name ='c1' value='$c1'>
			<input type='hidden' id ='c' name ='c' value='$c'>
			<input type='hidden' id ='d' name ='d' value='$d'>
			<input type='hidden' id ='e' name ='e' value='$e'>
			<input type='hidden' id ='e1' name ='e1' value='$e1'>

			".
			"<input type='button' value='Simpan' onclick =$this->Prefix.saveData('$primaryKey') title='Simpan' > &nbsp &nbsp ".
			"<input type='button' value='Batal' onclick ='".$this->Prefix.".Close()' >";
							
		$form = $this->genForm();		
		$content = $form;//$content = 'content';
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
}
$refstdbutuh = new refstdbutuhObj();
$refstdbutuh->username = $_COOKIE['coID'];

?>